<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::latest();

        // Lọc theo trạng thái đọc
        if ($request->input('status') === 'unread') {
            $query->where('is_read', false);
        } elseif ($request->input('status') === 'read') {
            $query->where('is_read', true);
        }

        // Lọc theo loại (dựa vào subject)
        $loai = $request->input('loai', '');
        if ($loai === 'baogianhanh') {
            $query->where(function($q) {
                $q->where('subject', 'like', '%báo giá%')
                  ->orWhere('subject', 'like', '%bao gia%');
            });
        } elseif ($loai === 'datlich') {
            $query->where(function($q) {
                $q->where('subject', 'like', '%đặt lịch%')
                  ->orWhere('subject', 'like', '%dat lich%');
            });
        } elseif ($loai === 'baoduong') {
            $query->where(function($q) {
                $q->where('subject', 'like', '%bảo dưỡng%')
                  ->orWhere('subject', 'like', '%bao duong%')
                  ->orWhere('subject', 'like', '%nhắc%');
            });
        } elseif ($loai === 'nhangiao') {
            $query->where(function($q) {
                $q->where('subject', 'like', '%nhận%')
                  ->orWhere('subject', 'like', '%giao xe%')
                  ->orWhere('subject', 'like', '%pickup%');
            });
        } elseif ($loai === 'lienhe') {
            $query->where(function($q) {
                $q->where('subject', 'not like', '%báo giá%')
                  ->where('subject', 'not like', '%đặt lịch%')
                  ->where('subject', 'not like', '%bảo dưỡng%')
                  ->where('subject', 'not like', '%nhận%')
                  ->where('subject', 'not like', '%giao xe%')
                  ->where(function($sub) {
                      $sub->whereNull('subject')->orWhere('subject', '!=', '');
                  });
            });
        }

        // Tìm kiếm
        if ($q = $request->input('q')) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('phone', 'like', "%$q%")
                    ->orWhere('subject', 'like', "%$q%");
            });
        }

        $contacts    = $query->paginate(20);
        $unreadCount = Contact::where('is_read', false)->count();
        $staffList   = User::whereIn('role', ['staff', 'manager'])->orderBy('name')->get();

        return view('admin.contacts.index', compact('contacts', 'unreadCount', 'staffList'));
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

        // Tạo order draft từ contact, gán luôn cho nhân viên
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