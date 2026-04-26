<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Contact;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    /**
     * Tính khoảng cách Haversine (mét)
     */
    private function getDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $R    = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a    = sin($dLat/2) * sin($dLat/2)
              + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
              * sin($dLng/2) * sin($dLng/2);
        return $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    /**
     * Trang khách hàng — phân quyền theo role
     */
    public function customers(Request $request)
    {
        $user  = Auth::user();
        $query = Order::with(['car', 'assignedUser'])->latest();

        if ($user->isAdmin()) {
            if ($request->filled('staff_id')) {
                $query->where('assigned_to', $request->staff_id);
            }
            $staffList = User::whereIn('role', ['staff', 'manager', 'admin'])
                             ->orderBy('name')->get();

        } elseif ($user->isManager()) {
            $allowedIds = User::whereIn('role', ['staff', 'manager'])->pluck('id');
            $query->whereIn('assigned_to', $allowedIds);

            if ($request->filled('staff_id')) {
                $query->where('assigned_to', $request->staff_id);
            }
            $staffList = User::whereIn('role', ['staff', 'manager'])
                             ->orderBy('name')->get();

        } else {
            $query->where('assigned_to', $user->id);
            $staffList = collect();
        }

        if ($request->filled('status')) {
            $query->where('consultation_status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('customer_name',  'like', "%{$s}%")
                  ->orWhere('customer_email', 'like', "%{$s}%")
                  ->orWhere('customer_phone', 'like', "%{$s}%");
            });
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('admin.staff.customers', compact('orders', 'staffList'));
    }

    // ────────────────────────────────────────────────────────
    //  QUẢN LÝ ĐƠN HÀNG CÁ NHÂN
    // ────────────────────────────────────────────────────────

    public function ordersIndex(Request $request)
    {
        $user = Auth::user();

        $query = Order::with('car')
            ->where('assigned_to', $user->id)
            ->latest();

        if ($request->filled('status')) {
            $query->where('consultation_status', $request->status);
        }

        $orders = $query->paginate(15)->withQueryString();

        $stats = [
            'total'      => Order::where('assigned_to', $user->id)->count(),
            'chua'       => Order::where('assigned_to', $user->id)->where('consultation_status', 'chua_tu_van')->count(),
            'da_tu_van'  => Order::where('assigned_to', $user->id)->where('consultation_status', 'da_tu_van')->count(),
            'da_chot'    => Order::where('assigned_to', $user->id)->where('consultation_status', 'da_chot_don')->count(),
            'commission' => Order::where('assigned_to', $user->id)->where('consultation_status', 'da_chot_don')->sum('commission_amount'),
        ];

        return view('admin.staff.orders.index', compact('orders', 'stats'));
    }

    public function ordersCreate(Request $request)
    {
        $cars = \App\Models\Car::where('is_available', true)->with('brand')->get();

        $assignedStaff = null;
        if ($request->filled('assigned_to')) {
            $assignedStaff = User::find($request->assigned_to);
        }

        return view('admin.staff.orders.create', compact('cars', 'assignedStaff'));
    }

    public function ordersStore(Request $request)
    {
        $request->validate([
            'car_id'           => 'required|exists:cars,id',
            'customer_name'    => 'required|string|max:255',
            'customer_email'   => 'required|email',
            'customer_phone'   => 'required|string|max:20',
            'customer_address' => 'nullable|string|max:500',
            'note'             => 'nullable|string|max:1000',
            'assigned_to'      => 'nullable|exists:users,id',
        ]);

        $assignedTo = $request->filled('assigned_to') ? (int) $request->assigned_to : Auth::id();

        Order::create([
            'car_id'              => $request->car_id,
            'assigned_to'         => $assignedTo,
            'created_by'          => Auth::id(),
            'customer_name'       => $request->customer_name,
            'customer_email'      => $request->customer_email,
            'customer_phone'      => $request->customer_phone,
            'customer_address'    => $request->customer_address,
            'note'                => $request->note,
            'status'              => 'pending',
            'consultation_status' => 'chua_tu_van',
        ]);

        if ($request->filled('assigned_to')) {
            $staff = User::find($assignedTo);
            return redirect()->route('admin.kpi.show', $assignedTo)
                ->with('success', 'Đã tạo đơn hàng mới cho ' . ($staff->name ?? 'nhân viên') . '!');
        }

        return redirect()->route('admin.staff.orders.index')
            ->with('success', 'Đã tạo đơn hàng mới!');
    }

    public function ordersShow(Order $order)
    {
        if ($order->assigned_to !== Auth::id()) {
            abort(403);
        }

        $order->load('car');

        return view('admin.staff.orders.show', compact('order'));
    }

    public function ordersDestroy(Order $order)
    {
        if ($order->assigned_to !== Auth::id()) {
            abort(403);
        }

        if ($order->consultation_status !== 'chua_tu_van') {
            return back()->with('error', 'Không thể xóa đơn đã được tư vấn hoặc đã chốt!');
        }

        $order->delete();

        return redirect()->route('admin.staff.orders.index')
            ->with('success', 'Đã xóa đơn hàng thành công!');
    }

    public function updateConsultation(Request $request, Order $order)
    {
        $user = Auth::user();

        if ($order->assigned_to !== $user->id) {
            abort(403);
        }

        $request->validate([
            'consultation_status' => 'required|in:chua_tu_van,da_tu_van',
            'note'                => 'nullable|string|max:1000',
        ]);

        if ($order->consultation_status === 'da_chot_don') {
            return back()->with('error', 'Đơn đã được chốt, không thể thay đổi!');
        }

        $data = ['consultation_status' => $request->consultation_status];

        if ($request->consultation_status === 'da_tu_van') {
            $data['consulted_at'] = now();
        }

        if ($request->filled('note')) {
            $data['note'] = $request->note;
        }

        $order->update($data);

        $msg = $request->consultation_status === 'da_tu_van'
            ? 'Đã cập nhật "Đã tư vấn" – đơn đang chờ Manager chốt!'
            : 'Đã cập nhật trạng thái!';

        return back()->with('success', $msg);
    }

    // ────────────────────────────────────────────────────────
    //  CHẤM CÔNG GPS
    // ────────────────────────────────────────────────────────

    public function attendance()
    {
        $user  = Auth::user();
        $today = now()->toDateString();

        $record = Attendance::where('user_id', $user->id)
            ->where('work_date', $today)
            ->first();

        $history = Attendance::where('user_id', $user->id)
            ->orderByDesc('work_date')
            ->limit(30)
            ->get();

        return view('admin.staff.attendance', compact('record', 'history'));
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'lat'     => 'required|numeric',
            'lng'     => 'required|numeric',
            'address' => 'nullable|string|max:500',
        ]);

        $officeLat    = (float) env('OFFICE_LAT', 10.7769);
        $officeLng    = (float) env('OFFICE_LNG', 106.7009);
        $officeRadius = (int)   env('OFFICE_RADIUS', 50);

        $dist = $this->getDistance(
            $request->lat, $request->lng,
            $officeLat, $officeLng
        );

        if ($dist > $officeRadius) {
            $distRound = round($dist);
            return back()->with('error',
                "Bạn đang cách văn phòng {$distRound}m — cần ở trong vòng {$officeRadius}m để check-in!"
            );
        }

        $user  = Auth::user();
        $today = now()->toDateString();

        $existing = Attendance::where('user_id', $user->id)
            ->where('work_date', $today)
            ->first();

        if ($existing && $existing->check_in_at) {
            return back()->with('error', 'Bạn đã check-in hôm nay rồi!');
        }

        Attendance::updateOrCreate(
            ['user_id' => $user->id, 'work_date' => $today],
            [
                'check_in_at'      => now(),
                'check_in_lat'     => $request->lat,
                'check_in_lng'     => $request->lng,
                'check_in_address' => $request->address,
            ]
        );

        return back()->with('success', 'Check-in thành công lúc ' . now()->format('H:i'));
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'lat'     => 'required|numeric',
            'lng'     => 'required|numeric',
            'address' => 'nullable|string|max:500',
        ]);

        $officeLat    = (float) env('OFFICE_LAT', 10.7769);
        $officeLng    = (float) env('OFFICE_LNG', 106.7009);
        $officeRadius = (int)   env('OFFICE_RADIUS', 50);

        $dist = $this->getDistance(
            $request->lat, $request->lng,
            $officeLat, $officeLng
        );

        if ($dist > $officeRadius) {
            $distRound = round($dist);
            return back()->with('error',
                "Bạn đang cách văn phòng {$distRound}m — cần ở trong vòng {$officeRadius}m để check-out!"
            );
        }

        $user  = Auth::user();
        $today = now()->toDateString();

        $record = Attendance::where('user_id', $user->id)
            ->where('work_date', $today)
            ->first();

        if (!$record || !$record->check_in_at) {
            return back()->with('error', 'Bạn chưa check-in hôm nay!');
        }

        if ($record->check_out_at) {
            return back()->with('error', 'Bạn đã check-out hôm nay rồi!');
        }

        $record->update([
            'check_out_at'      => now(),
            'check_out_lat'     => $request->lat,
            'check_out_lng'     => $request->lng,
            'check_out_address' => $request->address,
        ]);

        return back()->with('success', 'Check-out thành công lúc ' . now()->format('H:i'));
    }

    // ────────────────────────────────────────────────────────
    //  HIỆU SUẤT CÁ NHÂN
    // ────────────────────────────────────────────────────────

    public function performance()
    {
        $user = Auth::user();

        $stats = [
            'total_customers' => Order::where('assigned_to', $user->id)->count(),
            'consulted'       => Order::where('assigned_to', $user->id)->where('consultation_status', '!=', 'chua_tu_van')->count(),
            'closed'          => Order::where('assigned_to', $user->id)->where('consultation_status', 'da_chot_don')->count(),
            'commission'      => Order::where('assigned_to', $user->id)->where('consultation_status', 'da_chot_don')->sum('commission_amount'),
        ];

        $stats['conversion_rate'] = $stats['total_customers'] > 0
            ? round($stats['closed'] / $stats['total_customers'] * 100, 1)
            : 0;

        $monthly = Order::where('assigned_to', $user->id)
            ->where('consultation_status', 'da_chot_don')
            ->whereYear('closed_at', now()->year)
            ->selectRaw('MONTH(closed_at) as month, SUM(sale_price) as revenue, SUM(commission_amount) as commission, COUNT(*) as cnt')
            ->groupByRaw('MONTH(closed_at)')
            ->orderBy('month')
            ->get();

        return view('admin.staff.performance', compact('stats', 'monthly'));
    }
}