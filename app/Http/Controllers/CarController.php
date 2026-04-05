<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Brand;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function home()
    {
        $featuredCars = Car::with('brand')->latest()->take(6)->get();
        $brands = Brand::orderBy('name')->get();

        return view('welcome', compact('featuredCars', 'brands'));
    }

    public function index(Request $request)
    {
        $query = Car::with('brand');

        // ── SEARCH ───────────────────────
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('brand', fn($b) => $b->where('name', 'like', '%' . $request->search . '%'));
            });
        }

       // ── FILTER ───────────────────────
if ($request->filled('brand')) {
    $query->where(function($q) use ($request) {
        $q->where('brand', $request->brand)
          ->orWhereHas('brand', fn($b) => $b->where('name', $request->brand));
    });
}

if ($request->filled('fuel_type')) {
    $query->where('fuel_type', $request->fuel_type);
}

if ($request->filled('min_price')) {
    $query->where('price_per_day', '>=', $request->min_price);
}

if ($request->filled('max_price')) {
    $query->where('price_per_day', '<=', $request->max_price);
}

if ($request->filled('status')) {
    $query->where('status', $request->status);
}
        // ── SORT ─────────────────────────
        switch ($request->sort) {
            case 'price_asc':  $query->orderBy('price_per_day', 'asc'); break;
            case 'price_desc': $query->orderBy('price_per_day', 'desc'); break;
            case 'name_asc':   $query->orderBy('name', 'asc'); break;
            default:           $query->latest(); break;
        }

        // ── PAGINATION ───────────────────
        $cars = $query->paginate(12)->appends($request->query());

        // ── BRAND LIST ───────────────────
        $brands = Brand::orderBy('name')->pluck('name');

        return view('cars.index', compact('cars', 'brands'));
    }

   public function show(Car $car)
{
    $car->load([
        'brand',
        'variants',
        'colors',
        'features' => fn($q) => $q->with('variant'),
        'specs'    => fn($q) => $q->with('variant'),
        'galleries',
    ]);

    // Nhóm specs theo category để render bảng thông số
    $specsByCategory = $car->specs
        ->groupBy('category')
        ->sortBy(fn($group) => $group->first()->category_order);

    // Xe cùng hãng để gợi ý so sánh
    $relatedCars = Car::with('brand')
        ->where('brand_id', $car->brand_id)
        ->where('id', '!=', $car->id)
        ->limit(4)
        ->get();

    return view('cars.show', compact('car', 'specsByCategory', 'relatedCars'));
}
}