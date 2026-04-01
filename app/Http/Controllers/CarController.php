<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function home()
    {
        $featuredCars = Car::latest()->take(6)->get();
        $brands = Car::select('brand')->distinct()->orderBy('brand')->pluck('brand');

        return view('welcome', compact('featuredCars', 'brands'));
    }

    public function index(Request $request)
    {
        $query = Car::query();

        // ── SEARCH ───────────────────────
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%');
            });
        }

        // ── FILTER ───────────────────────
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->fuel_type);
        }

        // 🔥 SỬA: price_per_day → price
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // (OPTIONAL)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ── SORT ─────────────────────────
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc'); // 🔥 sửa
                break;

            case 'price_desc':
                $query->orderBy('price', 'desc'); // 🔥 sửa
                break;

            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;

            case 'newest':
                $query->latest();
                break;

            default:
                $query->latest();
                break;
        }

        // ── PAGINATION ───────────────────
        $cars = $query->paginate(12)->appends($request->query());

        // ── BRAND LIST ───────────────────
        $brands = Car::select('brand')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');

        return view('cars.index', compact('cars', 'brands'));
    }

    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }
}