<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Danh sách đơn hàng của user đang đăng nhập
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('car')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // Form đặt mua xe
    public function create(Car $car)
    {
        if ($car->status !== 'available') {
            return redirect()->route('cars.show', $car->slug)
                ->with('error', 'Xe này hiện không còn sẵn để đặt mua.');
        }

        return view('cars.order', compact('car'));
    }

    // Lưu đơn hàng → redirect sang trang xác nhận + QR cọc
    public function store(Request $request, Car $car)
    {
        $validated = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_email'   => 'required|email|max:255',
            'customer_phone'   => 'required|string|max:20',
            'customer_address' => 'nullable|string|max:500',
            'note'             => 'nullable|string|max:500',
            'start_date'       => 'required|date|after_or_equal:today',
            'end_date'         => 'required|date|after:start_date',
        ]);

        // Giá xe: ưu tiên sale_price → price → price_per_day
        $basePrice     = $car->sale_price ?? $car->price ?? $car->price_per_day ?? 0;
        $depositAmount = intval($basePrice * 0.3);

        $order = Order::create([
            'user_id'          => Auth::id(), // null nếu chưa đăng nhập — OK
            'car_id'           => $car->id,
            'customer_name'    => $validated['customer_name'],
            'customer_email'   => $validated['customer_email'],
            'customer_phone'   => $validated['customer_phone'],
            'customer_address' => $validated['customer_address'] ?? null,
            'deposit_amount'   => $depositAmount,
            'note'             => $validated['note'] ?? null,
            'status'           => 'pending',
            'start_date'       => $validated['start_date'],
            'end_date'         => $validated['end_date'],
        ]);

        // Cập nhật trạng thái xe — dùng 'sold' thay vì 'reserved' để tránh lỗi ENUM
        // Nếu muốn dùng 'reserved', chạy migration thêm giá trị đó vào ENUM trước
        $car->update(['status' => 'sold']);

        // Lưu order id vào session để show() không cần auth
        session(['last_order_id' => $order->id]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Đặt xe thành công! Vui lòng thanh toán cọc để giữ xe.');
    }

    // Trang xác nhận đơn hàng + QR cọc
    public function show(Order $order)
    {
        // Cho phép xem nếu: là chủ đơn (đã login) HOẶC session khớp (khách vãng lai)
        $isOwner       = Auth::check() && $order->user_id === Auth::id();
        $isGuestViewer = session('last_order_id') === $order->id;

        if (!$isOwner && !$isGuestViewer) {
            abort(403);
        }

        $order->load('car');
        return view('orders.show', compact('order'));
    }

    // Hủy đơn hàng
    public function destroy(Order $order)
    {
        $isOwner       = Auth::check() && $order->user_id === Auth::id();
        $isGuestViewer = session('last_order_id') === $order->id;

        if (!$isOwner && !$isGuestViewer) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Chỉ có thể hủy đơn hàng đang chờ xử lý.');
        }

        // Trả lại trạng thái xe
        $order->car->update(['status' => 'available']);
        $order->update(['status' => 'cancelled']);

        // Xóa session nếu là khách vãng lai
        if ($isGuestViewer) {
            session()->forget('last_order_id');
            return redirect()->route('cars.index')
                ->with('success', 'Đã hủy đơn hàng.');
        }

        return redirect()->route('orders.index')
            ->with('success', 'Đã hủy đơn hàng.');
    }
}