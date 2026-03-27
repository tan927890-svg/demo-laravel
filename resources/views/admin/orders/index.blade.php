@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 mb-6">Đơn hàng của tôi</h2>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if($orders->isEmpty())
                    <div class="text-center py-12 text-gray-500">
                        <div class="text-5xl mb-4">📋</div>
                        <p class="font-medium">Bạn chưa có đơn hàng nào.</p>
                        <a href="{{ route('cars.index') }}" class="text-red-500 hover:underline mt-2 inline-block">Xem xe ngay →</a>
                    </div>
                @else
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-3 border">#</th>
                                <th class="p-3 border">Xe</th>
                                <th class="p-3 border">Tiền đặt cọc</th>
                                <th class="p-3 border">Trạng thái</th>
                                <th class="p-3 border">Ngày đặt</th>
                                <th class="p-3 border">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 border">{{ $order->id }}</td>
                                <td class="p-3 border font-medium">{{ $order->car->name ?? 'N/A' }}</td>
                                <td class="p-3 border">{{ number_format($order->deposit_amount, 0, ',', '.') }}đ</td>
                                <td class="p-3 border">
                                    @php
                                        $statusMap = [
                                            'pending'   => ['label' => 'Chờ xác nhận', 'class' => 'bg-yellow-100 text-yellow-800'],
                                            'confirmed' => ['label' => 'Đã xác nhận',  'class' => 'bg-blue-100 text-blue-800'],
                                            'completed' => ['label' => 'Hoàn thành',   'class' => 'bg-green-100 text-green-800'],
                                            'cancelled' => ['label' => 'Đã hủy',       'class' => 'bg-red-100 text-red-800'],
                                        ];
                                        $s = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'bg-gray-100'];
                                    @endphp
                                    <span class="px-2 py-1 rounded text-sm {{ $s['class'] }}">{{ $s['label'] }}</span>
                                </td>
                                <td class="p-3 border">{{ $order->created_at->format('d/m/Y') }}</td>
                                <td class="p-3 border space-x-2">
                                    <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:underline">Xem</a>
                                    @if($order->status === 'pending')
                                    <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Hủy đơn hàng này?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hủy</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $orders->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection