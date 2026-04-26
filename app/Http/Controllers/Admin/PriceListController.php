<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PriceListController extends Controller
{
    /**
     * Hiển thị trang cập nhật bảng giá.
     * Admin/Manager có thể sửa price_per_day + image_url của từng xe.
     */
    public function index(Request $request)
    {
        $brands = Brand::orderBy('name')->get();

        $query = Car::with('brand')->orderBy('brand_id')->orderBy('name');

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qb) use ($q) {
                $qb->where('name', 'like', "%$q%")
                   ->orWhere('model', 'like', "%$q%");
            });
        }

        $cars = $query->get();

        return view('admin.price-list.index', compact('cars', 'brands'));
    }

    /**
     * Cập nhật hàng loạt price_per_day + image_url.
     * POST body: prices[car_id] = số tiền, images[car_id] = file upload (optional)
     */
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
            if (!$car) continue;

            if ($price !== null && $price !== '') {
                $car->price_per_day = (float) $price;
            }

            // Nếu có upload ảnh mới cho xe này
            if ($request->hasFile("images.$carId")) {
                $file = $request->file("images.$carId");
                $path = $file->store('cars', 'public');
                $car->image_url = '/storage/' . $path;
            }

            $car->save();
            $updated++;
        }

        return redirect()
            ->route('admin.price-list.index', $request->only('brand', 'search'))
            ->with('success', "Đã cập nhật bảng giá cho $updated xe.");
    }
}
