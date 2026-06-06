<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function index(Request $request)
    {
        $query = Deposit::with(['car'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($sub) use ($q) {
                $sub->where('customer_name',    'like', "%$q%")
                    ->orWhere('customer_phone',  'like', "%$q%")
                    ->orWhere('transaction_code','like', "%$q%");
            });
        }

        $deposits = $query->paginate(20)->withQueryString();

        return view('admin.deposits.index', compact('deposits'));
    }

    public function show(Deposit $deposit)
    {
        $deposit->load(['car.colors', 'car.galleries', 'car.brand']);

        return view('admin.deposits.show', compact('deposit'));
    }

    public function update(Request $request, Deposit $deposit)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled,refunded',
        ]);

        $data = ['status' => $request->status];

        if ($request->status === 'confirmed' && !$deposit->confirmed_at) {
            $data['confirmed_at'] = now();
        }

        $deposit->update($data);

        return back()->with('success', 'Cập nhật trạng thái thành công.');
    }

    public function updateStatus(Request $request, Deposit $deposit)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled,refunded',
        ]);

        $data = ['status' => $request->status];

        if ($request->status === 'confirmed' && !$deposit->confirmed_at) {
            $data['confirmed_at'] = now();
        }

        $deposit->update($data);

        return back()->with('success', 'Cập nhật trạng thái thành công.');
    }

    public function assign(Request $request, Deposit $deposit)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
            'staff_note'  => 'nullable|string|max:1000',
        ]);

        $deposit->update([
            'assigned_to' => $request->assigned_to,
            'staff_note'  => $request->staff_note,
        ]);

        return back()->with('success', 'Đã phân công nhân viên xử lý đặt cọc.');
    }

    public function destroy(Deposit $deposit)
    {
        $deposit->delete();

        return redirect()
            ->route('admin.contacts.index', ['loai' => 'dat-coc'])
            ->with('success', 'Đã xoá đặt cọc #' . $deposit->id . '.');
    }

    public function export(Request $request)
    {
        $query = Deposit::with('car')->latest();

        if ($request->filled('dep_status')) {
            $query->where('status', $request->dep_status);
        }

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($sub) use ($q) {
                $sub->where('customer_name',    'like', "%$q%")
                    ->orWhere('customer_phone',  'like', "%$q%")
                    ->orWhere('transaction_code','like', "%$q%");
            });
        }

        $deposits = $query->get();
        $filename = 'dat-coc-' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($deposits) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // BOM UTF-8 cho Excel

            fputcsv($file, [
                'Mã GD', 'Tên KH', 'SĐT', 'Email',
                'Xe', 'Số tiền cọc', 'Phương thức', 'Trạng thái', 'Ngày đặt', 'Nhân viên phụ trách',
            ]);

            foreach ($deposits as $d) {
                fputcsv($file, [
                    $d->transaction_code,
                    $d->customer_name,
                    $d->customer_phone,
                    $d->customer_email ?? '',
                    optional($d->car)->name ?? '—',
                    $d->deposit_amount,
                    $d->payment_method_label,
                    $d->status_label,
                    $d->created_at->format('d/m/Y H:i'),
                    optional($d->assignedTo)->name ?? '—',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}