<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Brand;
use Illuminate\Http\Request;

class CarController extends Controller
{
public function home()
{
    $featuredCars = Car::with('brand')
        ->where('is_featured', true)
        ->latest()
        ->get();

    $brands = Brand::orderBy('name')->pluck('name');

    return view('welcome', compact('featuredCars', 'brands'));
}

    public function index(Request $request)
    {
        $query = Car::with(['brand', 'colors', 'galleries']);
        // ── SEARCH ───────────────────────
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('brand', fn($b) => $b->where('name', 'like', '%' . $request->search . '%'));
            });
        }

        // ── FILTER ───────────────────────
        if ($request->filled('brand')) {
            $query->whereHas('brand', fn($b) => $b->where('name', $request->brand));
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

        // ── FEATURED CARS ─────────────────
        $featuredCars = Car::featured()->orderBy('name')->get();

        return view('cars.index', compact('cars', 'brands', 'featuredCars'));
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

        $specsByCategory = $car->specs
            ->groupBy('category')
            ->sortBy(fn($group) => $group->first()->category_order);

        $relatedCars = Car::with(['brand', 'variants', 'specs'])
            ->where('brand_id', $car->brand_id)
            ->where('id', '!=', $car->id)
            ->limit(4)
            ->get();

        $compAllCars = collect([$car])
            ->concat($relatedCars)
            ->map(fn($c) => [
                'id'       => $c->id,
                'name'     => $c->name,
                'brand'    => $c->brand?->name ?? '',
                'img'      => $this->carImgUrl($c),
                'variants' => $c->variants->unique('name')->values()
                                ->map(fn($v) => ['name' => $v->name, 'price' => (int)$v->price])
                                ->toArray(),
                'specs'    => $c->specs
                                ->groupBy('category')
                                ->map(fn($g) => $g->pluck('spec_value', 'spec_key'))
                                ->toArray(),
            ])
            ->values()
            ->toArray();

        return view('cars.show', compact('car', 'specsByCategory', 'relatedCars', 'compAllCars'));
    }

    public function compare(Request $request)
    {
        $allCars = Car::with(['colors', 'variants'])
            ->orderBy('name')
            ->get();

        $slotCars = collect();
        for ($i = 0; $i < 3; $i++) {
            $carId = $request->query("slot{$i}");
            if ($carId) {
                $car = Car::with(['specs', 'variants', 'colors'])->find($carId);
                $slotCars->push($car);
            } else {
                $slotCars->push(null);
            }
        }

        return view('cars.compare', compact('allCars', 'slotCars'));
    }

    private function carImgUrl($car): ?string
    {
        foreach (['image_url', 'image', 'hero_image'] as $field) {
            $val = $car->$field ?? null;
            if ($val) return asset(ltrim($val, '/'));
        }
        return null;
    }

    public function costEstimate(Car $car)
    {
        $car->load('variants'); // ← FIX: eager load variants
        return view('cars.cost-estimate', compact('car'));
    }

    public function costEstimateGeneral()
    {
        $cars = Car::with('variants')->where('status', 'available')->get();
        return view('cars.cost-estimate', compact('cars'));
    }
}