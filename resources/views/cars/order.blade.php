@extends('layouts.app')
@section('title', 'Đặt cọc — ' . $car->name)

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
  <div class="text-center mb-8">
    <h1 class="text-2xl font-extrabold text-gray-900">Đặt cọc xe</h1>
    <p class="text-gray-500 mt-1 text-sm">Điền thông tin để đặt cọc — chúng tôi sẽ liên hệ xác nhận trong 24h</p>
  </div>

  <!-- Car summary -->
  <div class="bg-gray-900 text-white rounded-2xl p-5 mb-8 flex gap-4 items-center">
    <img src="{{ Storage::url($car->main_image) }}"
         onerror="this.src='https://placehold.co/120x80/374151/9ca3af?text=Car'"
         class="w-24 h-16 object-cover rounded-xl flex-shrink-0"/>
    <div class="flex-1 min-w-0">
      <p class="text-xs text-gray-400">{{ $car->brand }} · {{ $car->year }}</p>
      <p class="font-bold text-base leading-snug">{{ $car->name }}</p>
      <p class="text-red-400 font-extrabold mt-1">{{ $car->formatted_price }}</p>
    </div>
    <div class="text-right flex-shrink-0">
      <p class="text-xs text-gray-400">Tiền cọc (10%)</p>
      <p class="font-extrabold text-yellow-400">{{ number_format($car->price * 0.1, 0, ',', '.') }} ₫</p>
    </div>
  </div>

  <!-- Form -->
  <form method="POST" action="{{ route('orders.store', $car->slug) }}" class="bg-white rounded-2xl border border-gray-100 p-7 space-y-5">
    @csrf

    <!-- Tiền cọc ẩn - tự động tính 10% giá xe -->
    <input type="hidden" name="deposit_amount" value="{{ $car->price * 0.1 }}"/>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
      <ul class="text-sm text-red-600 space-y-1 list-disc list-inside">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
      <div>
        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Họ và tên <span class="text-red-500">*</span></label>
        <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()?->name) }}"
          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('customer_name') border-red-400 @enderror"
          placeholder="Nguyễn Văn A"/>
      </div>
      <div>
        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Số điện thoại <span class="text-red-500">*</span></label>
        <input type="tel" name="customer_phone" value="{{ old('customer_phone') }}"
          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('customer_phone') border-red-400 @enderror"
          placeholder="0901 234 567"/>
      </div>
    </div>

    <div>
      <label class="block text-xs font-semibold text-gray-600 mb-1.5">Email <span class="text-red-500">*</span></label>
      <input type="email" name="customer_email" value="{{ old('customer_email', auth()->user()?->email) }}"
        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('customer_email') border-red-400 @enderror"
        placeholder="email@example.com"/>
    </div>

    <div>
      <label class="block text-xs font-semibold text-gray-600 mb-1.5">Địa chỉ</label>
      <input type="text" name="customer_address" value="{{ old('customer_address') }}"
        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-400"
        placeholder="Số nhà, đường, quận, tỉnh/thành"/>
    </div>

    <div>
      <label class="block text-xs font-semibold text-gray-600 mb-1.5">Ghi chú</label>
      <textarea name="note" rows="3"
        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 resize-none"
        placeholder="Yêu cầu thêm, câu hỏi...">{{ old('note') }}</textarea>
    </div>

    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-sm text-yellow-800">
      💡 Sau khi đặt cọc, nhân viên sẽ liên hệ trong <strong>24 giờ</strong> để xác nhận.
    </div>

    <button type="submit"
      class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-2xl transition text-base">
      Xác nhận đặt cọc
    </button>
  </form>
</div>
@endsection