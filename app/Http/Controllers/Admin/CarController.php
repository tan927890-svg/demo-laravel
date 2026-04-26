<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::orderBy('name')->get();

        $cars = Car::with('brand')->latest();

        if ($request->filled('brand')) {
            $cars->where('brand_id', $request->brand);
        }

        if ($request->filled('featured')) {
            $cars->where('is_featured', true);
        }

        if ($request->filled('search')) {
            $cars->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('model', 'like', '%'.$request->search.'%');
            });
        }

        $cars = $cars->paginate(15)->withQueryString();

        return view('admin.cars.index', compact('cars', 'brands'));
    }

    public function show(Car $car)
    {
        return view('admin.cars.show', compact('car'));
    }

    public function create()
    {
        if (Auth::user()->isStaff()) abort(403);
        $brands = Brand::orderBy('name')->get();
        return view('admin.cars.create', compact('brands'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->canManageStaff()) {
            abort(403);
        }

        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'brand_id'          => 'required|exists:brands,id',
            'model'             => 'nullable|string|max:255',
            'price_per_day'     => 'required|numeric|min:0',
            'color'             => 'nullable|string|max:100',
            'mileage'           => 'nullable|integer|min:0',
            'fuel_type'         => 'nullable|string|max:50',
            'condition'         => 'nullable|string|max:50',
            'engine'            => 'nullable|string|max:100',
            'seats'             => 'nullable|integer|min:1',
            'description'       => 'nullable|string',
            'content'           => 'nullable|string',
            'status'            => 'nullable|string|in:available,out_of_stock,coming_soon',
            'image_url'         => 'nullable|string|max:500',
            'image_file'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'is_featured'       => 'nullable|boolean',
            'badge_label'       => 'nullable|string|max:50',
            'image_360_prefix'  => 'nullable|string|max:100',
            'slug'              => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'year'              => 'nullable|integer|min:2000',
            'transmission'      => 'nullable|string|max:50',
            'horsepower'        => 'nullable|integer|min:0',
            'fuel_consumption'  => 'nullable|string|max:20',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image_file')) {
            $file     = $request->file('image_file');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('images/car'), $filename);
            $validated['image_url'] = 'images/car/' . $filename;
        }

        if (!$validated['is_featured']) {
            $validated['badge_label']      = null;
            $validated['image_360_prefix'] = null;
        }

        Car::create($validated);

        return redirect()->route('admin.cars.index')
                         ->with('success', 'Thêm xe thành công!');
    }

    public function edit(Car $car)
    {
        if (Auth::user()->isStaff()) abort(403);
        $brands = Brand::orderBy('name')->get();
        return view('admin.cars.edit', compact('car', 'brands'));
    }

    public function update(Request $request, Car $car)
    {
        if (Auth::user()->isStaff()) abort(403);

        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'brand_id'          => 'required|exists:brands,id',
            'model'             => 'nullable|string|max:255',
            'price_per_day'     => 'required|numeric|min:0',
            'color'             => 'nullable|string|max:100',
            'mileage'           => 'nullable|integer|min:0',
            'fuel_type'         => 'nullable|string|max:50',
            'condition'         => 'nullable|string|max:50',
            'engine'            => 'nullable|string|max:100',
            'seats'             => 'nullable|integer|min:1',
            'description'       => 'nullable|string',
            'content'           => 'nullable|string',
            'status'            => 'nullable|string|in:available,out_of_stock,coming_soon',
            'image_url'         => 'nullable|string|max:500',
            'image_file'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'is_featured'       => 'nullable|boolean',
            'badge_label'       => 'nullable|string|max:50',
            'image_360_prefix'  => 'nullable|string|max:100',
            'slug'              => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'year'              => 'nullable|integer|min:2000',
            'transmission'      => 'nullable|string|max:50',
            'horsepower'        => 'nullable|integer|min:0',
            'fuel_consumption'  => 'nullable|string|max:20',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image_file')) {
            $file     = $request->file('image_file');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('images/car'), $filename);
            $validated['image_url'] = 'images/car/' . $filename;
        }

        if (!$validated['is_featured']) {
            $validated['badge_label']      = null;
            $validated['image_360_prefix'] = null;
        }

        $car->update($validated);

        return redirect()->route('admin.cars.index')
                         ->with('success', 'Cập nhật xe thành công!');
    }

    public function destroy(Car $car)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        $car->delete();
        return back()->with('success', 'Đã xóa xe.');
    }
}