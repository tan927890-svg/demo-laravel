<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::latest()->paginate(15);
        return view('admin.cars.index', compact('cars'));
    }

    public function create()
    {
        return view('admin.cars.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'brand'         => 'required|string|max:100',
            'year'          => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'price_per_day' => 'required|numeric|min:0',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_available'  => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('cars', 'public');
        }

        $validated['is_available'] = $request->has('is_available');

        Car::create($validated);

        return redirect()->route('admin.cars.index')
            ->with('success', 'Thêm xe thành công!');
    }

    public function edit(Car $car)
    {
        return view('admin.cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'brand'         => 'required|string|max:100',
            'year'          => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'price_per_day' => 'required|numeric|min:0',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($car->image) Storage::disk('public')->delete($car->image);
            $validated['image'] = $request->file('image')->store('cars', 'public');
        }

        $validated['is_available'] = $request->has('is_available');

        $car->update($validated);

        return redirect()->route('admin.cars.index')
            ->with('success', 'Cập nhật xe thành công!');
    }

    public function destroy(Car $car)
    {
        if ($car->image) Storage::disk('public')->delete($car->image);
        $car->delete();

        return redirect()->route('admin.cars.index')
            ->with('success', 'Đã xóa xe.');
    }
}