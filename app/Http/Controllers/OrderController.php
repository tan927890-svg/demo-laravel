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

    // Form đặt xe
    public function create(Car $car)
    {
        if ($car->status !== 'available') {
            return redirect()->route('cars.show', $car->slug)
                ->with('error', 'Xe này hiện không có sẵn để đặt.');
        }

        return view('cars.order', compact('car'));
    }

    // Lưu đơn hàng
    public function store(Request $request, Car $car)
    {
        $validated = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_email'   => 'required|email|max:255',
            'customer_phone'   => 'required|string|max:20',
            'customer_address' => 'nullable|string|max:500',
            'deposit_amount'   => 'required|numeric|min:0',
            'note'             => 'nullable|string|max:500',
        ]);

        Order::create([
            'user_id'          => Auth::id(),
            'car_id'           => $car->id,
            'customer_name'    => $validated['customer_name'],
            'customer_email'   => $validated['customer_email'],
            'customer_phone'   => $validated['customer_phone'],
            'customer_address' => $validated['customer_address'] ?? null,
            'deposit_amount'   => $validated['deposit_amount'],
            'note'             => $validated['note'] ?? null,
            'status'           => 'pending',
        ]);

        // Cập nhật trạng thái xe thành đã đặt cọc
        $car->update(['status' => 'reserved']);

        return redirect()->route('orders.index')
            ->with('success', 'Đặt xe thành công! Chờ xác nhận từ admin.');
    }

    // Chi tiết đơn hàng
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('car');
        return view('orders.show', compact('order'));
    }

    // Hủy đơn hàng
    public function destroy(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Chỉ có thể hủy đơn hàng đang chờ xử lý.');
        }

        // Trả lại trạng thái xe
        $order->car->update(['status' => 'available']);
        $order->update(['status' => 'cancelled']);

        return redirect()->route('orders.index')
            ->with('success', 'Đã hủy đơn hàng.');
    }
}