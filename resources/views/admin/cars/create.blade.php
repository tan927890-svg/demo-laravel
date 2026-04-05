<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Thêm xe mới</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    {{-- Hãng xe --}}
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Hãng xe</label>
                        <select name="brand_id" id="brand_id"
                            class="mt-1 w-full border rounded px-3 py-2 @error('brand_id') border-red-500 @enderror">
                            <option value="">-- Chọn hãng xe --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    data-price="{{ $brand->default_price_per_day }}"
                                    data-fuel="{{ $brand->default_fuel_type }}"
                                    data-transmission="{{ $brand->default_transmission }}"
                                    data-seats="{{ $brand->default_seats }}"
                                    {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Tên xe --}}
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Tên xe</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="mt-1 w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror">
                        @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Năm sản xuất --}}
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Năm sản xuất</label>
                        <input type="number" name="year" value="{{ old('year', date('Y')) }}"
                            class="mt-1 w-full border rounded px-3 py-2 @error('year') border-red-500 @enderror">
                        @error('year')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Giá thuê --}}
                    <div>
                        <label class="block font-medium text-sm text-gray-700">
                            Giá thuê / ngày (VNĐ)
                            <span class="text-xs text-gray-400 font-normal ml-1">— tự điền theo hãng, có thể sửa</span>
                        </label>
                        <input type="number" name="price_per_day" id="price_per_day" value="{{ old('price_per_day') }}"
                            class="mt-1 w-full border rounded px-3 py-2 @error('price_per_day') border-red-500 @enderror">
                        @error('price_per_day')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Nhiên liệu --}}
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Nhiên liệu</label>
                        <select name="fuel_type" id="fuel_type"
                            class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-- Chọn --</option>
                            @foreach(['Xăng','Diesel','Điện','Hybrid'] as $fuel)
                                <option value="{{ $fuel }}" {{ old('fuel_type') == $fuel ? 'selected' : '' }}>
                                    {{ $fuel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Hộp số --}}
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Hộp số</label>
                        <select name="transmission" id="transmission"
                            class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-- Chọn --</option>
                            @foreach(['Tự động','Số sàn','CVT'] as $trans)
                                <option value="{{ $trans }}" {{ old('transmission') == $trans ? 'selected' : '' }}>
                                    {{ $trans }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Số chỗ --}}
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Số chỗ ngồi</label>
                        <input type="number" name="seats" id="seats" value="{{ old('seats') }}"
                            class="mt-1 w-full border rounded px-3 py-2" min="2" max="16">
                    </div>

                    {{-- Màu sắc --}}
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Màu sắc</label>
                        <input type="text" name="color" value="{{ old('color') }}"
                            placeholder="Trắng, Đen, Bạc..."
                            class="mt-1 w-full border rounded px-3 py-2">
                    </div>

                    {{-- Số km --}}
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Số km đã đi</label>
                        <input type="number" name="mileage" value="{{ old('mileage', 0) }}"
                            class="mt-1 w-full border rounded px-3 py-2">
                    </div>

                    {{-- Mô tả --}}
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Mô tả</label>
                        <textarea name="description" rows="3"
                            class="mt-1 w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
                    </div>

                    {{-- Ảnh xe --}}
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Ảnh xe</label>
                        <input type="file" name="image" id="image" accept="image/*" class="mt-1 w-full"
                            onchange="previewImage(this)">
                        <img id="preview" src="" alt="" class="mt-2 rounded hidden" style="max-height:200px">
                        @error('image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Có sẵn --}}
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_available" id="is_available" value="1" checked>
                        <label for="is_available" class="text-sm text-gray-700">Có sẵn để thuê</label>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Thêm xe</button>
                        <a href="{{ route('admin.cars.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    // ── Tự động điền khi chọn hãng ──────────────────────────
    document.getElementById('brand_id').addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];

        const price        = opt.dataset.price;
        const fuel         = opt.dataset.fuel;
        const transmission = opt.dataset.transmission;
        const seats        = opt.dataset.seats;

        if (price)        document.getElementById('price_per_day').value  = price;
        if (fuel)         document.getElementById('fuel_type').value       = fuel;
        if (transmission) document.getElementById('transmission').value    = transmission;
        if (seats)        document.getElementById('seats').value           = seats;
    });

    // ── Preview ảnh trước khi upload ────────────────────────
    function previewImage(input) {
        const preview = document.getElementById('preview');
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            preview.classList.remove('hidden');
        }
    }
    </script>
</x-app-layout>