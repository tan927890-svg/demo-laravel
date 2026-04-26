<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarExpense;
use Illuminate\Http\Request;

class ProfitController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::with(['brand', 'expenses']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $cars = $query->latest()->paginate(20)->withQueryString();

        $allCars = Car::with(['expenses'])->get();

        $summary = [
            'total_cars'    => $allCars->count(),
            'total_cost'    => $allCars->sum(fn($c) => $this->calcTotalCost($c)),
            'total_revenue' => $allCars->sum(fn($c) => $this->calcRevenue($c)),
            'total_profit'  => $allCars->sum(fn($c) => $this->calcProfit($c)),
        ];

        return view('admin.profit.index', compact('cars', 'summary'));
    }

    public function show(Car $car)
    {
        $car->load(['brand', 'expenses']);

        $totalCost = $this->calcTotalCost($car);
        $revenue   = $this->calcRevenue($car);
        $profit    = $revenue - $totalCost;
        $margin    = $revenue > 0 ? round($profit / $revenue * 100, 1) : 0;

        return view('admin.profit.show', compact('car', 'totalCost', 'revenue', 'profit', 'margin'));
    }

    public function update(Request $request, Car $car)
    {
        $request->validate([
            'cost_price'          => 'nullable|numeric|min:0',
            'sale_price'          => 'nullable|numeric|min:0',
            'expenses'            => 'nullable|array',
            'expenses.*.name'     => 'required|string|max:255',
            'expenses.*.amount'   => 'required|numeric|min:0',
            'expenses.*.category' => 'nullable|string',
            'expenses.*.note'     => 'nullable|string',
        ]);

        $car->update([
            'cost_price' => $request->cost_price,
            'sale_price' => $request->sale_price,
        ]);

        $car->expenses()->delete();

        if ($request->has('expenses') && is_array($request->expenses)) {
            foreach ($request->expenses as $exp) {
                if (!empty($exp['name']) || ($exp['amount'] ?? 0) > 0) {
                    $car->expenses()->create([
                        'name'     => $exp['name'],
                        'amount'   => $exp['amount'] ?? 0,
                        'category' => $exp['category'] ?? null,
                        'note'     => $exp['note'] ?? null,
                    ]);
                }
            }
        }

        return back()->with('success', 'Đã cập nhật chi phí cho ' . $car->name);
    }

    // ── Helpers ──────────────────────────────────────────────────

    private function calcTotalCost(Car $car): float
    {
        $cost   = (float) ($car->cost_price ?? 0);
        $expSum = $car->expenses->sum('amount');
        return $cost + $expSum;
    }

    private function calcRevenue(Car $car): float
    {
        return (float) ($car->sale_price ?? 0);
    }

    private function calcProfit(Car $car): float
    {
        return $this->calcRevenue($car) - $this->calcTotalCost($car);
    }
}