@extends('layouts.app')

@section('title', $car->name . ' — AutoViet')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">

  <!-- Breadcrumb -->
  <nav class="text-sm text-gray-400 mb-6 flex items-center gap-2">
    <a href="{{ route('home') }}" class="hover:text-red-500">Trang chủ</a>
    <span>/</span>
    <a href="{{ route('cars.index') }}" class="hover:text-red-500">Xe</a>
    <span>/</span>
    <span class="text-gray-700 font-medium">{{ $car->name }}</span>
  </nav>

  <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">

    <!-- LEFT: Ảnh -->
    <div class="lg:col-span-3">
      @php $images = $car->images ?? []; @endphp

      <!-- Main image -->
      <div class="rounded-2xl overflow-hidden bg-gray-100 h-80 md:h-96 mb-3">
        <img id="main-img"
             src="{{ count($images) > 0 ? Storage::url($images[0]) : 'https://placehold.co/800x500/f1f5f9/94a3b8?text=No+Image' }}"
             alt="{{ $car->name }}"
             class="w-full h-full object-cover"/>
      </div>

      <!-- Thumbnails -->
      @if(count($images) > 1)
      <div class="flex gap-2 overflow-x-auto pb-1">
        @foreach($images as $img)
        <img src="{{ Storage::url($img) }}" alt=""
             onclick="document.getElementById('main-img').src = this.src"
             class="w-20 h-16 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-red-500 transition flex-shrink-0"/>
        @endforeach
      </div>
      @endif

      <!-- Description -->
      @if($car->description)
      <div class="mt-8 bg-white rounded-2xl border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-3">Mô tả chi tiết</h3>
        <div class="text-sm text-gray-600 leading-relaxed">{{ $car->description }}</div>
      </div>
      @endif
    </div>

    <!-- RIGHT: Info + CTA -->
    <div class="lg:col-span-2 space-y-5">
      <!-- Status -->
      @php $status = $car->status_label; @endphp
      <span class="inline-block px-3 py-1 rounded-full text-xs font-bold
        {{ $status['color'] === 'green' ? 'bg-green-100 text-green-700' : '' }}
        {{ $status['color'] === 'yellow' ? 'bg-yellow-100 text-yellow-700' : '' }}
        {{ $status['color'] === 'red' ? 'bg-red-100 text-red-700' : '' }}">
        {{ $status['label'] }}
      </span>

      <!-- Title & Price -->
      <div>
        <p class="text-sm text-gray-400">{{ $car->brand }} · {{ $car->year }}</p>
        <h1 class="text-2xl font-extrabold text-gray-900 mt-1 leading-snug">{{ $car->name }}</h1>
        <p class="text-3xl font-black text-red-600 mt-3">{{ $car->formatted_price }}</p>
        <p class="text-xs text-gray-400 mt-1">Đặt cọc {{ number_format($car->price * 0.1, 0, ',', '.') }} ₫ (10%)</p>
      </div>

      <!-- Specs -->
      <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <h3 class="font-bold text-gray-800 mb-4">Thông số kỹ thuật</h3>
        <div class="space-y-3">
          @foreach([
            ['icon' => '🏷', 'label' => 'Hãng xe', 'val' => $car->brand],
            ['icon' => '🚘', 'label' => 'Dòng xe', 'val' => $car->model],
            ['icon' => '📅', 'label' => 'Năm sản xuất', 'val' => $car->year],
            ['icon' => '🎨', 'label' => 'Màu sắc', 'val' => $car->color],
            ['icon' => '⛽', 'label' => 'Nhiên liệu', 'val' => $car->fuel_type],
            ['icon' => '⚙️', 'label' => 'Hộp số', 'val' => $car->transmission],
            ['icon' => '🔧', 'label' => 'Động cơ', 'val' => $car->engine ?? 'N/A'],
            ['icon' => '🪑', 'label' => 'Số chỗ ngồi', 'val' => $car->seats],
            ['icon' => '📍', 'label' => 'Số km', 'val' => number_format($car->mileage) . ' km'],
            ['icon' => '✅', 'label' => 'Tình trạng', 'val' => $car->condition],
          ] as $spec)
          <div class="flex justify-between items-center text-sm py-1 border-b border-gray-50 last:border-0">
            <span class="text-gray-500">{{ $spec['icon'] }} {{ $spec['label'] }}</span>
            <span class="font-semibold text-gray-800">{{ $spec['val'] }}</span>
          </div>
          @endforeach
        </div>
      </div>

      <!-- CTA Buttons -->
      @if($car->status === 'available')
      <a href="{{ route('cars.order.form', $car->slug) }}"
         class="block w-full text-center bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-2xl transition text-base">
        🛒 Đặt cọc ngay
      </a>
      <a href="tel:0901234567"
         class="block w-full text-center border-2 border-red-600 text-red-600 hover:bg-red-50 font-bold py-3.5 rounded-2xl transition text-sm">
        📞 Gọi tư vấn: 0901 234 567
      </a>
      @else
      <div class="bg-gray-100 rounded-2xl p-4 text-center text-gray-500 font-medium">
        Xe này hiện không còn khả dụng
      </div>
      @endif
    </div>
  </div>

  <!-- Related Cars -->
  @if($related->isNotEmpty())
  <div class="mt-16">
    <h2 class="text-xl font-extrabold text-gray-800 mb-6">Xe cùng hãng {{ $car->brand }}</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      @foreach($related as $rel)
      <a href="{{ route('cars.show', $rel->slug) }}" class="bg-white rounded-xl border border-gray-100 hover:shadow-md transition overflow-hidden group">
        <div class="h-36 bg-gray-100 overflow-hidden">
          <img src="{{ Storage::url($rel->main_image) }}"
               onerror="this.src='https://placehold.co/300x200/f1f5f9/94a3b8?text=No+Image'"
               alt="{{ $rel->name }}"
               class="w-full h-full object-cover group-hover:scale-105 transition-transform"/>
        </div>
        <div class="p-3">
          <p class="text-xs text-gray-400">{{ $rel->year }}</p>
          <p class="font-bold text-sm text-gray-900 leading-snug line-clamp-2">{{ $rel->name }}</p>
          <p class="text-red-600 font-extrabold text-sm mt-1">{{ $rel->formatted_price }}</p>
        </div>
      </a>
      @endforeach
    </div>
  </div>
  @endif

</div>
@endsection
