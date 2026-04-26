<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Danh sách đơn hàng – lọc theo role
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Order::with(['car', 'user', 'assignedStaff'])->latest();

        if ($user->isStaff()) {
            return redirect()->route('admin.staff.orders.index');
        }

        if ($request->filled('consultation_status')) {
            $query->where('consultation_status', $request->consultation_status);
        }

        if ($request->filled('staff_id')) {
            $query->where('assigned_to', $request->staff_id);
        }

        $orders    = $query->paginate(20)->withQueryString();
        $staffList = User::where('role', 'staff')->get();

        return view('admin.orders.index', compact('orders', 'staffList'));
    }

    /**
     * Form tạo đơn hàng mới (Admin/Manager)
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isManager()) {
            abort(403);
        }

        $cars      = Car::with('brand')->where('is_available', true)->get();
        $staffList = User::where('role', 'staff')->get();

        return view('admin.orders.create', compact('cars', 'staffList'));
    }

    /**
     * Lưu đơn hàng mới (Admin/Manager)
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isManager()) {
            abort(403);
        }

        $validated = $request->validate([
            'car_id'           => 'required|exists:cars,id',
            'customer_name'    => 'required|string|max:255',
            'customer_email'   => 'required|email|max:255',
            'customer_phone'   => 'required|string|max:20',
            'customer_address' => 'nullable|string|max:500',
            'note'             => 'nullable|string|max:1000',
            'assigned_to'      => 'nullable|exists:users,id',
        ]);

        $order = Order::create([
            'car_id'              => $validated['car_id'],
            'user_id'             => Auth::id(),
            'customer_name'       => $validated['customer_name'],
            'customer_email'      => $validated['customer_email'],
            'customer_phone'      => $validated['customer_phone'],
            'customer_address'    => $validated['customer_address'] ?? null,
            'note'                => $validated['note'] ?? null,
            'assigned_to'         => $validated['assigned_to'] ?? null,
            'status'              => 'pending',
            // Manager tự tạo → coi như đã tư vấn luôn, Admin vẫn cần qua flow
            'consultation_status' => $user->isManager() ? 'da_tu_van' : 'chua_tu_van',
            'consulted_at'        => $user->isManager() ? now() : null,
        ]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Tạo đơn hàng #' . $order->id . ' thành công!');
    }

    /**
     * Chi tiết đơn hàng
     */
    public function show(Order $order)
    {
        $user = Auth::user();

        if ($user->isStaff() && $order->assigned_to !== $user->id) {
            abort(403);
        }

        $order->load(['car', 'user', 'assignedStaff']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Cập nhật trạng thái đơn hàng (Admin)
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        if (in_array($request->status, ['cancelled', 'completed']) && $order->car) {
            $order->car->update(['is_available' => true]);
        }

        return back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    /**
     * Manager chốt đơn: nhập giá bán + % hoa hồng (old method – giữ lại cho tương thích route)
     */
    public function closeOrder(Request $request, Order $order)
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isManager()) {
            abort(403);
        }

        if ($order->consultation_status !== 'da_tu_van') {
            return back()->with('error', 'Chỉ có thể chốt đơn đã tư vấn!');
        }

        $request->validate([
            'sale_price'      => 'required|numeric|min:1',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'manager_note'    => 'nullable|string|max:1000',
        ]);

        $salePrice      = $request->sale_price;
        $commissionRate = $request->commission_rate;
        $commissionAmt  = round($salePrice * $commissionRate / 100);

        $order->update([
            'consultation_status' => 'da_chot_don',
            'sale_price'          => $salePrice,
            'commission_rate'     => $commissionRate,
            'commission_amount'   => $commissionAmt,
            'manager_note'        => $request->manager_note,
            'closed_at'           => now(),
            'status'              => 'completed',
        ]);

        if ($order->car) {
            $order->car->update(['is_available' => false]);
        }

        return back()->with('success', 'Đã chốt đơn! Hoa hồng: ' . number_format($commissionAmt, 0, ',', '.') . 'đ');
    }

    /**
     * Gán đơn hàng cho nhân viên (Admin/Manager)
     */
    public function assignStaff(Request $request, Order $order)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $staff = User::findOrFail($request->assigned_to);
        if (!$staff->isStaff()) {
            return back()->with('error', 'Người được gán phải là nhân viên (staff)!');
        }

        $order->update(['assigned_to' => $request->assigned_to]);

        return back()->with('success', 'Đã gán đơn cho ' . $staff->name);
    }

    /**
     * Xóa đơn hàng (Admin only)
     */
    public function destroy(Order $order): RedirectResponse
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403);
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Đã xóa đơn hàng #' . $order->id . '!');
    }

    /**
     * Chốt đơn nhanh: hoa hồng tự động 0.05% nếu < 10 tỷ, 0.1% nếu ≥ 10 tỷ
     *
     * Quyền:
     *  - Admin  : chốt tất cả đơn đã ở trạng thái "đã tư vấn"
     *  - Manager: chốt tất cả đơn của staff lẫn của mình (kể cả chưa tư vấn)
     */
    public function close(Request $request, Order $order): RedirectResponse
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isManager()) {
            abort(403);
        }

        // Không cho chốt đơn đã chốt rồi
        if ($order->consultation_status === 'da_chot_don') {
            return back()->with('error', 'Đơn hàng này đã được chốt!');
        }

        // Admin yêu cầu đơn phải "đã tư vấn"; Manager chốt thẳng được
        if ($user->isAdmin() && $order->consultation_status !== 'da_tu_van') {
            return back()->with('error', 'Chỉ có thể chốt đơn đã tư vấn!');
        }

        $request->validate([
            'sale_price'   => ['required', 'integer', 'min:1'],
            'manager_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $sale       = $request->sale_price;
        $rate       = $sale >= 10_000_000_000 ? 0.1 : 0.05;
        $commission = (int) round($sale * $rate / 100);

        $order->update([
            'sale_price'          => $sale,
            'commission_rate'     => $rate,
            'commission_amount'   => $commission,
            'consultation_status' => 'da_chot_don',
            'status'              => 'completed',
            'manager_note'        => $request->manager_note,
            'closed_at'           => now(),
            'consulted_at'        => $order->consulted_at ?? now(),
        ]);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success',
                'Chốt đơn thành công! '
                . 'Hoa hồng (' . $rate . '%): '
                . number_format($commission, 0, ',', '.') . '₫'
            );
    }
}