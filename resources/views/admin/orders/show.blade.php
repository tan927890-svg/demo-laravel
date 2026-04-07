@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 mb-6">
            Chi tiết đơn hàng #{{ $order->id }}
        </h2>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-6">

            <!-- Thông tin xe -->
            <div>
                <h3 class="font-semibold text-lg mb-3">Thông tin xe</h3>
                <div class="flex gap-4">
                    @if($order->car->main_image)
                        <img src="{{ Storage::url($order->car->main_image) }}"
                             onerror="this.src='https://placehold.co/200x130/f1f5f9/94a3b8?text=No+Image'"
                             class="w-40 h-28 object-cover rounded">
                    @endif
                    <div>
                        <p><span class="font-medium">Tên xe:</span> {{ $order->car->name }}</p>
                        <p><span class="font-medium">Hãng:</span> {{ $order->car->brand }}</p>
                        <p><span class="font-medium">Năm:</span> {{ $order->car->year }}</p>
                        <p><span class="font-medium">Giá xe:</span>
                            <span class="text-red-600 font-bold">{{ $order->car->formatted_price }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Thông tin đơn hàng -->
            <div class="border-t pt-4">
                <h3 class="font-semibold text-lg mb-3">Thông tin đơn hàng</h3>
                <p><span class="font-medium">Tên khách hàng:</span> {{ $order->customer_name }}</p>
                <p><span class="font-medium">Email:</span> {{ $order->customer_email }}</p>
                <p><span class="font-medium">Số điện thoại:</span> {{ $order->customer_phone }}</p>
                @if($order->customer_address)
                <p><span class="font-medium">Địa chỉ:</span> {{ $order->customer_address }}</p>
                @endif
                <p class="mt-2"><span class="font-medium">Tiền đặt cọc:</span>
                    <span class="text-xl font-bold text-blue-600">{{ number_format($order->deposit_amount, 0, ',', '.') }}đ</span>
                </p>
                @if($order->note)
                <p><span class="font-medium">Ghi chú:</span> {{ $order->note }}</p>
                @endif
            </div>

            <!-- Trạng thái -->
            <div class="border-t pt-4">
                <h3 class="font-semibold text-lg mb-3">Trạng thái</h3>
                @php
                    $statusMap = [
                        'pending'   => ['label' => 'Chờ xác nhận', 'class' => 'bg-yellow-100 text-yellow-800'],
                        'confirmed' => ['label' => 'Đã xác nhận',  'class' => 'bg-blue-100 text-blue-800'],
                        'completed' => ['label' => 'Hoàn thành',   'class' => 'bg-green-100 text-green-800'],
                        'cancelled' => ['label' => 'Đã hủy',       'class' => 'bg-red-100 text-red-800'],
                    ];
                    $s = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'bg-gray-100'];
                @endphp
                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $s['class'] }}">{{ $s['label'] }}</span>
            </div>

            <!-- Hành động -->
            <div class="border-t pt-4 flex gap-3">
                <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">← Quay lại</a>
                @if($order->status === 'pending')
                <form action="{{ route('orders.destroy', $order) }}" method="POST"
                      onsubmit="return confirm('Hủy đơn hàng này?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Hủy đơn hàng</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection