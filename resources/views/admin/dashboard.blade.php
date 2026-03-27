@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

  <!-- Header -->
  <div class="flex items-center justify-between mb-8">
    <div>
      <h1 class="text-2xl font-extrabold text-gray-900">Dashboard</h1>
      <p class="text-sm text-gray-400 mt-1">Quản lý showroom AutoViet</p>
    </div>
    <a href="{{ route('admin.cars.create') }}"
       class="bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition">
      + Thêm xe mới
    </a>
  </div>

  <!-- Stats -->
  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-10">
    @foreach([
      ['label' => 'Tổng xe', 'val' => $stats['total_cars'], 'color' => 'blue', 'icon' => '🚗'],
      ['label' => 'Còn hàng', 'val' => $stats['available_cars'], 'color' => 'green', 'icon' => '✅'],
      ['label' => 'Đã bán', 'val' => $stats['sold_cars'], 'color' => 'red', 'icon' => '🏷'],
      ['label' => 'Tổng đơn', 'val' => $stats['total_orders'], 'color' => 'purple', 'icon' => '📋'],
      ['label' => 'Chờ duyệt', 'val' => $stats['pending_orders'], 'color' => 'yellow', 'icon' => '⏳'],
      ['label' => 'Doanh thu cọc', 'val' => number_format($stats['total_revenue'], 0, ',', '.') . '₫', 'color' => 'emerald', 'icon' => '💰'],
    ] as $s)
    <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
      <p class="text-xl mb-1">{{ $s['icon'] }}</p>
      <p class="text-2xl font-extrabold text-gray-900">{{ $s['val'] }}</p>
      <p class="text-xs text-gray-400 mt-0.5">{{ $s['label'] }}</p>
    </div>
    @endforeach
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    <!-- Recent Orders -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
      <div class="flex items-center justify-between p-5 border-b border-gray-50">
        <h2 class="font-bold text-gray-800">Đơn đặt cọc gần đây</h2>
        <a href="{{ route('admin.orders') }}" class="text-xs text-red-500 hover:underline">Xem tất cả</a>
      </div>
      <div class="divide-y divide-gray-50">
        @forelse($recent_orders as $order)
        <div class="flex items-center gap-4 px-5 py-3">
          <div class="flex-1 min-w-0">
            <p class="font-semibold text-sm text-gray-800 truncate">{{ $order->customer_name }}</p>
            <p class="text-xs text-gray-400 truncate">{{ $order->car->name ?? '—' }}</p>
          </div>
          @php $st = $order->status_label; @endphp
          <span class="text-xs font-bold px-2 py-1 rounded-full
            {{ $st['color'] === 'yellow' ? 'bg-yellow-100 text-yellow-700' : '' }}
            {{ $st['color'] === 'blue' ? 'bg-blue-100 text-blue-700' : '' }}
            {{ $st['color'] === 'green' ? 'bg-green-100 text-green-700' : '' }}
            {{ $st['color'] === 'red' ? 'bg-red-100 text-red-700' : '' }}">
            {{ $st['label'] }}
          </span>
        </div>
        @empty
        <p class="text-center text-gray-400 py-8 text-sm">Chưa có đơn nào</p>
        @endforelse
      </div>
    </div>

    <!-- Recent Cars -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
      <div class="flex items-center justify-between p-5 border-b border-gray-50">
        <h2 class="font-bold text-gray-800">Xe mới thêm</h2>
        <a href="{{ route('admin.cars.index') }}" class="text-xs text-red-500 hover:underline">Quản lý xe</a>
      </div>
      <div class="divide-y divide-gray-50">
        @forelse($recent_cars as $car)
        <div class="flex items-center gap-4 px-5 py-3">
          <img src="{{ Storage::url($car->main_image) }}"
               onerror="this.src='https://placehold.co/48x36/f1f5f9/94a3b8?text='"
               class="w-12 h-9 object-cover rounded-lg flex-shrink-0"/>
          <div class="flex-1 min-w-0">
            <p class="font-semibold text-sm text-gray-800 truncate">{{ $car->name }}</p>
            <p class="text-xs text-gray-400">{{ $car->formatted_price }}</p>
          </div>
          <div class="flex gap-2">
            <a href="{{ route('admin.cars.edit', $car) }}" class="text-xs text-blue-500 hover:underline">Sửa</a>
          </div>
        </div>
        @empty
        <p class="text-center text-gray-400 py-8 text-sm">Chưa có xe nào</p>
        @endforelse
      </div>
    </div>

  </div>
</div>
@endsection
