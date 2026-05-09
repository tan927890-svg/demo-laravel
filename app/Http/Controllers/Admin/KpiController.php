<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KpiController extends Controller
{
    /**
     * Danh sách KPI tất cả nhân viên (Manager xem)
     */
    public function index()
    {
        $staffList = User::where('role', 'staff')
            ->withCount(['orders as kpi_total'])
            ->withCount(['orders as kpi_closed' => fn($q) => $q->where('consultation_status', 'da_chot_don')])
            ->withSum(['orders as kpi_revenue' => fn($q) => $q->where('consultation_status', 'da_chot_don')], 'sale_price')
            ->withSum(['orders as kpi_commission' => fn($q) => $q->where('consultation_status', 'da_chot_don')], 'commission_amount')
            ->get();

        return view('admin.kpi.index', compact('staffList'));
    }

    /**
     * KPI của người đang đăng nhập (Staff hoặc Manager tự xem)
     */
    public function me()
    {
        return $this->show(Auth::user());
    }

    /**
     * Chi tiết KPI của một user (Manager/Admin xem)
     * - Nếu là staff  : chỉ lấy đơn assigned_to = user->id
     * - Nếu là manager: lấy đơn assigned_to = user->id HOẶC user_id = user->id (đơn tự tạo)
     */
    public function show(User $user)
    {
        // Build query phù hợp theo role
        $baseQuery = $this->buildOrderQuery($user);

        $stats = [
            'total'      => (clone $baseQuery)->count(),
            'closed'     => (clone $baseQuery)->where('consultation_status', 'da_chot_don')->count(),
            'revenue'    => (clone $baseQuery)->where('consultation_status', 'da_chot_don')->sum('sale_price'),
            'commission' => (clone $baseQuery)->where('consultation_status', 'da_chot_don')->sum('commission_amount'),
        ];

        $stats['conversion_rate'] = $stats['total'] > 0
            ? round($stats['closed'] / $stats['total'] * 100, 1)
            : 0;

        $monthly = (clone $baseQuery)
            ->where('consultation_status', 'da_chot_don')
            ->whereYear('closed_at', now()->year)
            ->selectRaw('MONTH(closed_at) as month, SUM(sale_price) as revenue, SUM(commission_amount) as commission, COUNT(*) as cnt')
            ->groupByRaw('MONTH(closed_at)')
            ->orderBy('month')
            ->get();

        $orders = (clone $baseQuery)
            ->with('car')
            ->latest()
            ->paginate(10);

        $cars = Car::where('is_available', true)->with('brand')->get();

        return view('admin.kpi.show', compact('user', 'stats', 'monthly', 'orders', 'cars'));
    }

    /**
     * Tạo query đơn hàng theo role:
     * - Manager : assigned_to = user->id OR (user_id = user->id AND assigned_to IS NULL)
     * - Staff   : assigned_to = user->id
     */
    private function buildOrderQuery(User $user)
    {
        if ($user->isManager()) {
            return Order::where(function ($q) use ($user) {
                $q->where('assigned_to', $user->id)
                  ->orWhere(function ($q2) use ($user) {
                      $q2->where('user_id', $user->id)
                         ->whereNull('assigned_to');
                  });
            });
        }

        return Order::where('assigned_to', $user->id);
    }

    /**
     * Manager/Admin đặt KPI target cho nhân viên theo tháng
     */
    public function setKpiTarget(Request $request, User $user)
    {
        abort_unless(Auth::user()->isManager() || Auth::user()->isAdmin(), 403);

        $request->validate([
            'month'          => 'required|integer|min:1|max:12',
            'year'           => 'required|integer|min:2020|max:2100',
            'target_revenue' => 'required|integer|min:1',
            'target_orders'  => 'nullable|integer|min:0',
        ]);

        \App\Models\Kpi::updateOrCreate(
            [
                'user_id' => $user->id,
                'month'   => $request->month,
                'year'    => $request->year,
            ],
            [
                'target_revenue' => $request->target_revenue,
                'target_orders'  => $request->target_orders ?? 0,
                'actual_revenue' => 0,
                'actual_orders'  => 0,
            ]
        );

        return back()->with('success', "Đã đặt KPI tháng {$request->month}/{$request->year} cho {$user->name}.");
    }

    /**
     * Manager tạo đơn hàng mới cho nhân viên
     */
    public function storeOrder(Request $request, User $user)
    {
        abort_unless(Auth::user()->role === 'manager', 403);

        $request->validate([
            'car_id'           => 'required|exists:cars,id',
            'customer_name'    => 'required|string|max:255',
            'customer_email'   => 'required|email|max:255',
            'customer_phone'   => 'required|string|max:20',
            'customer_address' => 'nullable|string|max:500',
            'note'             => 'nullable|string|max:1000',
        ]);

        Order::create([
            'car_id'              => $request->car_id,
            'assigned_to'         => $user->id,
            'created_by'          => Auth::id(),
            'user_id'             => Auth::id(),
            'customer_name'       => $request->customer_name,
            'customer_email'      => $request->customer_email,
            'customer_phone'      => $request->customer_phone,
            'customer_address'    => $request->customer_address,
            'note'                => $request->note,
            'status'              => 'pending',
            'consultation_status' => 'chua_tu_van',
        ]);

        return redirect()->route('admin.kpi.show', $user)
            ->with('success', 'Đã tạo đơn hàng mới cho ' . $user->name . '!');
    }

    /**
     * Manager đánh dấu đơn "Đã tư vấn"
     */
    public function markConsulted(Order $order)
    {
        abort_unless(Auth::user()->isManager() || Auth::user()->isAdmin(), 403);

        if ($order->consultation_status !== 'chua_tu_van') {
            return back()->with('error', 'Đơn này không ở trạng thái "Chưa tư vấn"!');
        }

        $order->update([
            'consultation_status' => 'da_tu_van',
            'consulted_at'        => now(),
        ]);

        return back()->with('success', 'Đã cập nhật trạng thái "Đã tư vấn"!');
    }

    /**
     * Manager/Admin chốt đơn từ trang KPI
     *
     * FIX: commission_rate lưu đúng là 0.05% / 0.1% (không phải 5% / 10%)
     * Công thức: commission = sale_price * rate / 100
     * Ví dụ: 5 tỷ * 0.05 / 100 = 2.500.000đ
     */
    public function closeOrder(Request $request, Order $order)
    {
        abort_unless(Auth::user()->isManager() || Auth::user()->isAdmin(), 403);

        if ($order->consultation_status === 'da_chot_don') {
            return back()->with('error', 'Đơn hàng này đã được chốt!');
        }

        $request->validate([
            'sale_price'   => ['required', 'integer', 'min:1'],
            'manager_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $sale = (int) $request->sale_price;

        // ✅ FIX: rate đúng là 0.05% hoặc 0.1% (không phải 5% hay 10%)
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

        return back()->with('success',
            'Chốt đơn thành công! Hoa hồng (' . $rate . '%): '
            . number_format($commission, 0, ',', '.') . 'đ'
        );
    }

    /**
     * Manager xóa đơn của nhân viên (chỉ khi chưa tư vấn)
     */
    public function destroyOrder(User $user, Order $order)
    {
        abort_unless(Auth::user()->role === 'manager', 403);

        if ($order->consultation_status !== 'chua_tu_van') {
            return back()->with('error', 'Không thể xóa đơn đã được tư vấn hoặc đã chốt!');
        }

        $order->delete();

        return redirect()->route('admin.kpi.show', $user)
            ->with('success', 'Đã xóa đơn hàng thành công!');
    }
}