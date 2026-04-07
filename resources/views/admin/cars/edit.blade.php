<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sửa xe: {{ $car->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.cars.update', $car) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf @method('PUT')

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Tên xe</label>
                        <input type="text" name="name" value="{{ old('name', $car->name) }}"
                            class="mt-1 w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror">
                        @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>


                    <div>
                        <label class="block font-medium text-sm text-gray-700">Hãng xe</label>
                        <select name="brand_id" id="brand_id"
                            class="mt-1 w-full border rounded px-3 py-2 @error('brand_id') border-red-500 @enderror">
                            <option value="">-- Chọn hãng xe --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $car->brand_id) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Năm sản xuất</label>
                        <input type="number" name="year" value="{{ old('year', $car->year) }}"
                            class="mt-1 w-full border rounded px-3 py-2 @error('year') border-red-500 @enderror">
                        @error('year')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Giá thuê / ngày (VNĐ)</label>
                        <input type="number" name="price_per_day" id="price_per_day" value="{{ old('price_per_day', $car->price_per_day) }}"
                            class="mt-1 w-full border rounded px-3 py-2 @error('price_per_day') border-red-500 @enderror">
                        @error('price_per_day')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Mô tả</label>
                        <textarea name="description" rows="3"
                            class="mt-1 w-full border rounded px-3 py-2">{{ old('description', $car->description) }}</textarea>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Ảnh xe</label>
                        @if($car->image)
                            <img src="{{ Storage::url($car->image) }}" class="w-32 h-24 object-cover rounded mb-2">
                        @endif
                        <input type="file" name="image" accept="image/*" class="mt-1 w-full">
                        <p class="text-sm text-gray-500">Để trống nếu không muốn thay ảnh</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_available" id="is_available" value="1"
                            {{ old('is_available', $car->is_available) ? 'checked' : '' }}>
                        <label for="is_available" class="text-sm text-gray-700">Có sẵn để thuê</label>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Cập nhật</button>
                        <a href="{{ route('admin.cars.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
