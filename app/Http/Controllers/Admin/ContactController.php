<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Deposit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $loai = $request->input('loai', '');

        // ── Contacts query ──────────────────────────────────────────────────
        $query = Contact::latest();

        if ($request->input('status') === 'unread') {
            $query->where('is_read', false);
        } elseif ($request->input('status') === 'read') {
            $query->where('is_read', true);
        }

        if ($loai === 'baogianhanh') {
            $query->where(function ($q) {
                $q->where('subject', 'like', '%báo giá%')
                  ->orWhere('subject', 'like', '%bao gia%');
            });
        } elseif ($loai === 'datlich') {
            $query->where(function ($q) {
                $q->where('subject', 'like', '%đặt lịch%')
                  ->orWhere('subject', 'like', '%dat lich%');
            });
        } elseif ($loai === 'baoduong') {
            $query->where(function ($q) {
                $q->where('subject', 'like', '%bảo dưỡng%')
                  ->orWhere('subject', 'like', '%bao duong%')
                  ->orWhere('subject', 'like', '%nhắc%');
            });
        } elseif ($loai === 'nhangiao') {
            $query->where(function ($q) {
                $q->where('subject', 'like', '%nhận%')
                  ->orWhere('subject', 'like', '%giao xe%')
                  ->orWhere('subject', 'like', '%pickup%');
            });
        } elseif ($loai === 'lienhe') {
            $query->where(function ($q) {
                $q->where('subject', 'not like', '%báo giá%')
                  ->where('subject', 'not like', '%đặt lịch%')
                  ->where('subject', 'not like', '%bảo dưỡng%')
                  ->where('subject', 'not like', '%nhận%')
                  ->where('subject', 'not like', '%giao xe%')
                  ->where(function ($sub) {
                      $sub->whereNull('subject')->orWhere('subject', '!=', '');
                  });
            });
        }

        if ($q = $request->input('q')) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name',    'like', "%$q%")
                    ->orWhere('email',   'like', "%$q%")
                    ->orWhere('phone',   'like', "%$q%")
                    ->orWhere('subject', 'like', "%$q%");
            });
        }

        $contacts          = $query->paginate(20)->withQueryString();
        $totalContactCount = Contact::count();
        $unreadCount       = Contact::where('is_read', false)->count();
        $readCount         = Contact::where('is_read', true)->count();
        $staffList         = User::whereIn('role', ['staff', 'manager'])->orderBy('name')->get();

        // ── Deposit stats — luôn truyền (mọi tab dùng để hiển thị badge) ──
        $depositStats = [
            'total'     => Deposit::count(),
            'pending'   => Deposit::where('status', 'pending')->count(),
            'confirmed' => Deposit::where('status', 'confirmed')->count(),
            'completed' => Deposit::where('status', 'completed')->count(),
            'cancelled' => Deposit::where('status', 'cancelled')->count(),
        ];
        $depositTotalAmount = Deposit::whereIn('status', ['confirmed', 'completed'])
                                     ->sum('deposit_amount');

        // ── Deposits list — chỉ query khi ở tab dat-coc ────────────────────
        $deposits = collect();
        if ($loai === 'dat-coc') {
            $depQuery = Deposit::with(['car', 'color', 'assignedTo'])->latest();

            if ($request->filled('dep_status')) {
                $depQuery->where('status', $request->dep_status);
            }

            $search = $request->input('search') ?: $request->input('q');
            if ($search) {
                $depQuery->where(function ($sub) use ($search) {
                    $sub->where('customer_name',    'like', "%$search%")
                        ->orWhere('customer_phone',  'like', "%$search%")
                        ->orWhere('transaction_code','like', "%$search%");
                });
            }

            $deposits = $depQuery->paginate(20)->withQueryString();
        }

        return view('admin.contacts.index', compact(
            'contacts',
            'totalContactCount',
            'unreadCount',
            'readCount',
            'staffList',
            'depositStats',
            'depositTotalAmount',
            'deposits',
        ));
    }

    public function show(Contact $contact)
    {
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        $unreadCount = Contact::where('is_read', false)->count();
        $staffList   = User::whereIn('role', ['staff', 'manager'])->orderBy('name')->get();

        return view('admin.contacts.show', compact('contact', 'unreadCount', 'staffList'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Đã xóa email liên hệ.');
    }

    public function markAllRead()
    {
        Contact::where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'Đã đánh dấu tất cả là đã đọc.');
    }

    public function assign(Request $request, Contact $contact)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
            'staff_note'  => 'nullable|string|max:1000',
        ]);

        $staff = User::findOrFail($request->assigned_to);

        $contact->update([
            'assigned_to'   => $staff->id,
            'staff_note'    => $request->staff_note,
            'assigned_at'   => now(),
            'assign_status' => 'assigned',
        ]);

        // Tạo order draft từ contact nếu chưa có
        $existingOrder = \App\Models\Order::where('contact_id', $contact->id)->first();

        if (!$existingOrder) {
            \App\Models\Order::create([
                'user_id'             => Auth::id(),
                'assigned_to'         => $staff->id,
                'contact_id'          => $contact->id,
                'customer_name'       => $contact->name,
                'customer_email'      => $contact->email ?? null,
                'customer_phone'      => $contact->phone ?? null,
                'note'                => $contact->message,
                'status'              => 'pending',
                'consultation_status' => 'chua_tu_van',
            ]);
        }

        // Gửi thông báo cho nhân viên
        \App\Models\Notification::create([
            'user_id'    => $staff->id,
            'title'      => 'Bạn có liên hệ mới cần xử lý',
            'body'       => "Khách hàng {$contact->name} ({$contact->phone}) — {$contact->subject}",
            'type'       => 'info',
            'data'       => json_encode(['contact_id' => $contact->id]),
            'created_by' => Auth::id(),
        ]);

        return back()->with('success', "Đã chuyển cho {$staff->name}!");
    }
}