<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function home()
    {
        $featuredCars = Car::latest()->take(3)->get();
        $brands = Car::select('brand')->distinct()->orderBy('brand')->pluck('brand');
        return view('welcome', compact('featuredCars', 'brands'));
    }

    public function index(Request $request)
    {
        $query = Car::query();

        // Tìm kiếm theo tên
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%')
                  ->orWhere('model', 'like', '%' . $request->search . '%');
            });
        }

        // Lọc theo hãng xe
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Lọc theo giá
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $cars = $query->latest()->paginate(12);

        // Lấy danh sách hãng xe để hiển thị filter
        $brands = Car::select('brand')->distinct()->orderBy('brand')->pluck('brand');

        return view('cars.index', compact('cars', 'brands'));
    }

    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }
}