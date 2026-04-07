<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Chi tiết đơn hàng #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-semibold text-lg mb-3">Thông tin xe</h3>
                        @if($order->car->image)
                            <img src="{{ Storage::url($order->car->image) }}" class="w-full h-48 object-cover rounded mb-3">
                        @endif
                        <p><span class="font-medium">Tên xe:</span> {{ $order->car->name }}</p>
                        <p><span class="font-medium">Hãng:</span> {{ $order->car->brand }}</p>
                        <p><span class="font-medium">Năm sản xuất:</span> {{ $order->car->year }}</p>
                        <p><span class="font-medium">Giá/ngày:</span> {{ number_format($order->car->price_per_day, 0, ',', '.') }}đ</p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-lg mb-3">Thông tin đơn hàng</h3>
                        <p><span class="font-medium">Ngày thuê:</span> {{ \Carbon\Carbon::parse($order->start_date)->format('d/m/Y') }}</p>
                        <p><span class="font-medium">Ngày trả:</span> {{ \Carbon\Carbon::parse($order->end_date)->format('d/m/Y') }}</p>
                        <p><span class="font-medium">Số ngày:</span>
                            {{ \Carbon\Carbon::parse($order->start_date)->diffInDays($order->end_date) }} ngày
                        </p>
                        <p><span class="font-medium">Tổng tiền:</span>
                            <span class="text-xl font-bold text-blue-600">{{ number_format($order->total_price, 0, ',', '.') }}đ</span>
                        </p>
                        <p class="mt-2"><span class="font-medium">Trạng thái:</span>
                            @php
                                $statusMap = [
                                    'pending'   => ['label' => 'Chờ xác nhận', 'class' => 'bg-yellow-100 text-yellow-800'],
                                    'confirmed' => ['label' => 'Đã xác nhận',  'class' => 'bg-blue-100 text-blue-800'],
                                    'completed' => ['label' => 'Hoàn thành',   'class' => 'bg-green-100 text-green-800'],
                                    'cancelled' => ['label' => 'Đã hủy',        'class' => 'bg-red-100 text-red-800'],
                                ];
                                $s = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'bg-gray-100'];
                            @endphp
                            <span class="px-2 py-1 rounded text-sm {{ $s['class'] }}">{{ $s['label'] }}</span>
                        </p>
                        @if($order->notes)
                        <p class="mt-2"><span class="font-medium">Ghi chú:</span> {{ $order->notes }}</p>
                        @endif
                    </div>
                </div>

                <div class="flex gap-3 pt-4 border-t">
                    <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">← Quay lại</a>
                    @if($order->status === 'pending')
                    <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Hủy đơn hàng này?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Hủy đơn hàng</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
