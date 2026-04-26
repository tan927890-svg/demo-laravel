<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Order;
use App\Models\User;
use App\Models\Contact;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Dashboard chính – hiển thị theo role
     */
    public function index()
    {
        $user = Auth::user();

        // ── Stats cơ bản ──────────────────────────────────────────
        $stats = [
            'total_cars'     => Car::count(),
            'available_cars' => Car::where('is_available', true)->count(),
            'sold_cars'      => Car::where('is_available', false)->count(),
            'pending_orders' => Order::where('consultation_status', 'chua_tu_van')->count(),
        ];

        // ── ADMIN: thêm stats toàn hệ thống ──────────────────────
        if ($user->isAdmin()) {
            $stats['total_revenue']   = Order::where('consultation_status', 'da_chot_don')->sum('sale_price');
            $stats['total_orders']    = Order::count();
            $stats['closed_orders']   = Order::where('consultation_status', 'da_chot_don')->count();
            $stats['active_staff']    = User::whereIn('role', ['manager', 'staff'])->count();
            $stats['total_contacts']  = Contact::count();
            $stats['unread_contacts'] = Contact::where('is_read', false)->count();

            // Top nhân viên + manager theo doanh số
            $topStaff = User::whereIn('role', ['staff', 'manager'])
                ->withCount(['orders as closed_count' => fn($q) =>
                    $q->where('consultation_status', 'da_chot_don')])
                ->withSum(['orders as revenue_sum' => fn($q) =>
                    $q->where('consultation_status', 'da_chot_don')], 'sale_price')
                ->orderByDesc('revenue_sum')
                ->limit(5)
                ->get();

            $cars = Car::with('brand')->latest()->get()->map(fn($car) => [
                'id'    => $car->id,
                'name'  => $car->name,
                'brand' => $car->brand?->name ?? '',
                'price' => $car->price_per_day ?? $car->price ?? 0,
                'stock' => $car->is_available ? 1 : 0,
            ]);

            return view('admin.dashboard', compact('stats', 'cars', 'topStaff'));
        }

        // ── MANAGER: stats theo team (staff + bản thân) ───────────
        if ($user->isManager()) {
            $staffIds = User::where('role', 'staff')->pluck('id');

            // Đơn của team (staff) + đơn manager tự tạo
            $teamQuery = Order::where(function ($q) use ($staffIds, $user) {
                $q->whereIn('assigned_to', $staffIds)
                  ->orWhere(function ($q2) use ($user) {
                      $q2->where('user_id', $user->id)
                         ->whereNull('assigned_to');
                  })
                  ->orWhere('assigned_to', $user->id);
            });

            $stats['team_revenue']   = (clone $teamQuery)->where('consultation_status', 'da_chot_don')->sum('sale_price');
            $stats['team_orders']    = (clone $teamQuery)->count();
            $stats['closed_orders']  = (clone $teamQuery)->where('consultation_status', 'da_chot_don')->count();
            $stats['pending_review'] = (clone $teamQuery)->where('consultation_status', 'da_tu_van')->count();

            $staffPerformance = User::where('role', 'staff')
                ->withCount([
                    'orders as total_orders_count',
                    'orders as closed_count' => fn($q) => $q->where('consultation_status', 'da_chot_don'),
                ])
                ->withSum(['orders as revenue_sum' => fn($q) =>
                    $q->where('consultation_status', 'da_chot_don')], 'sale_price')
                ->orderByDesc('revenue_sum')
                ->orderByDesc('closed_count')
                ->get();

            $recentOrders = (clone $teamQuery)
                ->with(['car', 'assignedStaff'])
                ->where('consultation_status', 'da_tu_van')
                ->latest()->limit(10)->get();

            return view('admin.dashboard', compact('stats', 'staffPerformance', 'recentOrders'));
        }

        // ── STAFF: stats cá nhân ──────────────────────────────────
        $stats['my_orders']     = Order::where('assigned_to', $user->id)->count();
        $stats['my_closed']     = Order::where('assigned_to', $user->id)
            ->where('consultation_status', 'da_chot_don')->count();
        $stats['my_consulting'] = Order::where('assigned_to', $user->id)
            ->where('consultation_status', 'da_tu_van')->count();
        $stats['my_commission'] = Order::where('assigned_to', $user->id)
            ->where('consultation_status', 'da_chot_don')->sum('commission_amount');

        $myOrders = Order::with('car')
            ->where('assigned_to', $user->id)
            ->latest()->limit(10)->get();

        return view('admin.dashboard', compact('stats', 'myOrders'));
    }

    /**
     * Trang báo cáo doanh thu – chỉ Admin & Manager
     */
    public function revenue(Request $request)
    {
        $year    = $request->get('year',  now()->year);
        $month   = $request->get('month', null);
        $staffId = $request->get('staff_id', null);

        // Doanh thu theo nhân viên + manager
        $staffRevenue = User::whereIn('role', ['staff', 'manager'])
            ->withSum(['orders as revenue_sum' => function ($q) use ($year, $month) {
                $q->where('consultation_status', 'da_chot_don')
                  ->whereYear('closed_at', $year);
                if ($month) $q->whereMonth('closed_at', $month);
            }], 'sale_price')
            ->withSum(['orders as commission_sum' => function ($q) use ($year, $month) {
                $q->where('consultation_status', 'da_chot_don')
                  ->whereYear('closed_at', $year);
                if ($month) $q->whereMonth('closed_at', $month);
            }], 'commission_amount')
            ->withCount(['orders as closed_count' => function ($q) use ($year, $month) {
                $q->where('consultation_status', 'da_chot_don')
                  ->whereYear('closed_at', $year);
                if ($month) $q->whereMonth('closed_at', $month);
            }])
            ->orderByDesc('revenue_sum')
            ->get();

        // Doanh thu theo tháng (chart)
        $monthlyRevenue = Order::where('consultation_status', 'da_chot_don')
            ->whereYear('closed_at', $year)
            ->when($staffId, fn($q) => $q->where('assigned_to', $staffId))
            ->selectRaw('MONTH(closed_at) as month, SUM(sale_price) as total, COUNT(*) as count')
            ->groupByRaw('MONTH(closed_at)')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        // Tổng thống kê
        $revenueStats = [
            'total_revenue'    => Order::where('consultation_status', 'da_chot_don')
                ->whereYear('closed_at', $year)
                ->when($month, fn($q) => $q->whereMonth('closed_at', $month))
                ->sum('sale_price'),
            'total_commission' => Order::where('consultation_status', 'da_chot_don')
                ->whereYear('closed_at', $year)
                ->when($month, fn($q) => $q->whereMonth('closed_at', $month))
                ->sum('commission_amount'),
            'total_orders'     => Order::where('consultation_status', 'da_chot_don')
                ->whereYear('closed_at', $year)
                ->when($month, fn($q) => $q->whereMonth('closed_at', $month))
                ->count(),
        ];

        $orders = Order::with(['car', 'assignedStaff'])
            ->where('consultation_status', 'da_chot_don')
            ->whereYear('closed_at', $year)
            ->when($month,   fn($q) => $q->whereMonth('closed_at', $month))
            ->when($staffId, fn($q) => $q->where('assigned_to', $staffId))
            ->latest('closed_at')
            ->paginate(20);

        $staffList = User::whereIn('role', ['staff', 'manager'])->get();

        return view('admin.dashboard.revenue', compact(
            'orders', 'revenueStats', 'staffRevenue',
            'monthlyRevenue', 'staffList', 'year', 'month', 'staffId'
        ));
    }
}