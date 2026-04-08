<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'car'])->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'car']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Nếu hủy đơn thì trả lại xe
        if ($request->status === 'cancelled' && $oldStatus !== 'cancelled') {
            $order->car->update(['is_available' => true]);
        }

        // Nếu hoàn thành thì trả lại xe
        if ($request->status === 'completed') {
            $order->car->update(['is_available' => true]);
        }

        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
}