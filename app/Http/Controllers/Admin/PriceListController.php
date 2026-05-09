<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PriceListController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::orderBy('name')->get();

        $query = Car::with('brand')
            ->orderBy('brand_id')
            ->orderBy('name');

        // lọc hãng
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        // tìm kiếm
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        $cars = $query->get();

        return view(
            'admin.price-list.index',
            compact('cars', 'brands')
        );
    }

    public function update(Request $request)
    {
        $request->validate([
            'prices'   => 'required|array',
            'prices.*' => 'nullable|numeric|min:0',

            'images'   => 'nullable|array',
            'images.*' => 'nullable|image|max:4096',
        ]);

        $updated = 0;

        foreach ($request->prices as $carId => $price) {

            $car = Car::find($carId);

            if (!$car) {
                continue;
            }

            // cập nhật giá
            if ($price !== null && $price !== '') {
                $car->price_per_day = (float) $price;
            }

            // upload ảnh
            if ($request->hasFile("images.$carId")) {

                $file = $request->file("images.$carId");

                if ($file && $file->isValid()) {

                    // extension
                    $extension = $file->getClientOriginalExtension();

                    if (empty($extension)) {
                        $extension = 'jpg';
                    }

                    // tên file
                    $filename =
                        uniqid('car_' . $carId . '_') .
                        '.' .
                        $extension;

                    // xoá ảnh cũ
                    if (!empty($car->image_url)) {

                        $oldPath = str_replace(
                            '/storage/',
                            '',
                            $car->image_url
                        );

                        if (
                            !empty($oldPath) &&
                            Storage::disk('public')->exists($oldPath)
                        ) {
                            Storage::disk('public')->delete($oldPath);
                        }
                    }

                    // tạo folder nếu chưa có
                    if (!Storage::disk('public')->exists('cars')) {
                        Storage::disk('public')->makeDirectory('cars');
                    }

                    // move file
                    $file->move(
                        storage_path('app/public/cars'),
                        $filename
                    );

                    // lưu db
                    $car->image_url =
                        '/storage/cars/' . $filename;
                }
            }

            $car->save();
            $updated++;
        }

        return redirect()
            ->route(
                'admin.price-list.index',
                $request->only('brand', 'search')
            )
            ->with(
                'success',
                "Đã cập nhật {$updated} xe."
            );
    }
}