<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Quản lý xe</h2>
            <a href="{{ route('admin.cars.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">+ Thêm xe</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 border">Ảnh</th>
                            <th class="p-3 border">Tên xe</th>
                            <th class="p-3 border">Hãng</th>
                            <th class="p-3 border">Năm</th>
                            <th class="p-3 border">Giá/ngày</th>
                            <th class="p-3 border">Trạng thái</th>
                            <th class="p-3 border">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cars as $car)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border">
                                @if($car->image)
                                    <img src="{{ Storage::url($car->image) }}" class="w-16 h-12 object-cover rounded">
                                @else
                                    <div class="w-16 h-12 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-400">No img</div>
                                @endif
                            </td>
                            <td class="p-3 border font-medium">{{ $car->name }}</td>
                            <td class="p-3 border">{{ $car->brand }}</td>
                            <td class="p-3 border">{{ $car->year }}</td>
                            <td class="p-3 border">{{ number_format($car->price_per_day, 0, ',', '.') }}đ</td>
                            <td class="p-3 border">
                                @if($car->is_available)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-sm">Có sẵn</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-sm">Đã thuê</span>
                                @endif
                            </td>
                            <td class="p-3 border space-x-2">
                                <a href="{{ route('admin.cars.edit', $car) }}" class="text-blue-600 hover:underline">Sửa</a>
                                <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="inline" onsubmit="return confirm('Xóa xe này?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Xóa</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $cars->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
