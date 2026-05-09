<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
            $search     = strtolower(trim($request->search));
            $searchNorm = preg_replace('/(\D)(\d)/', '$1 $2', $search);

            $cars->where(function ($q) use ($search, $searchNorm) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(model) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(name) LIKE ?', ['%' . $searchNorm . '%'])
                  ->orWhereRaw('LOWER(model) LIKE ?', ['%' . $searchNorm . '%']);
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
            'name'             => 'required|string|max:255',
            'brand_id'         => 'required|exists:brands,id',
            'model'            => 'nullable|string|max:255',
            'tagline'          => 'nullable|string|max:255',
            'price_per_day'    => 'required|numeric|min:0',
            'cost_price'       => 'nullable|numeric|min:0',
            'sale_price'       => 'nullable|numeric|min:0',
            'mileage'          => 'nullable|integer|min:0',
            'fuel_type'        => 'nullable|string|max:50',
            'condition'        => 'nullable|string|max:50',
            'engine'           => 'nullable|string|max:100',
            'seats'            => 'nullable|integer|min:1',
            'transmission'     => 'nullable|string|max:50',
            'description'      => 'nullable|string',
            'content'          => 'nullable|string',
            'status'           => 'nullable|string|in:available,out_of_stock,coming_soon',
            'image_url'        => 'nullable|string|max:500',
            'image_file'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'hero_image'       => 'nullable|string|max:500',
            'is_available'     => 'nullable|boolean',
            'is_featured'      => 'nullable|boolean',
            'badge_label'      => 'nullable|string|max:50',
            'image_360_prefix' => 'nullable|string|max:100',
            'image_360_frames' => 'nullable|integer|min:1|max:72',
            'slug'             => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'year'             => 'nullable|integer|min:2000',
            'horsepower'       => 'nullable|integer|min:0',
            'fuel_consumption' => 'nullable|string|max:20',
        ]);

        $validated['is_featured']  = $request->boolean('is_featured');
        $validated['is_available'] = $request->boolean('is_available', true);

        // ── Ảnh đại diện ──────────────────────────────────
        if ($request->hasFile('image_file')) {
            $file     = $request->file('image_file');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('images/car'), $filename);
            $validated['image_url'] = 'images/car/' . $filename;
        } elseif ($request->filled('image_url')) {
            $validated['image_url'] = $request->input('image_url');
        }

        // ── Slug tự động + tránh trùng ────────────────────
        $baseSlug = !empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['name']);

        $slug  = $baseSlug;
        $count = 1;
        while (Car::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }
        $validated['slug'] = $slug;

        // ── Ảnh hero ──────────────────────────────────────
        if ($request->hasFile('hero_image_file')) {
            $file     = $request->file('hero_image_file');
            $filename = time() . '_hero_' . $file->getClientOriginalName();
            @mkdir(public_path('images/hero'), 0775, true);
            $file->move(public_path('images/hero'), $filename);
            $validated['hero_image'] = 'images/hero/' . $filename;
        }

        // ── Badge & 360 chỉ khi is_featured ───────────────
        if (!$validated['is_featured']) {
            $validated['badge_label']      = null;
            $validated['image_360_prefix'] = null;
        }

        // ── Tạo xe ────────────────────────────────────────
        try {
            $car = Car::create($validated);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062 && str_contains($e->getMessage(), 'cars_slug_unique')) {
                $validated['slug'] = $baseSlug . '-' . time();
                $car = Car::create($validated);
            } else {
                throw $e;
            }
        }

        // ── Variants ──────────────────────────────────────
        foreach ($request->input('variants', []) as $v) {
            if (empty($v['name'])) continue;
            $car->variants()->create([
                'name'                  => $v['name'],
                'price'                 => $v['price'] ?? null,
                'price_with_battery'    => $v['price_with_battery'] ?? null,
                'price_without_battery' => $v['price_without_battery'] ?? null,
                'sort_order'            => $v['sort_order'] ?? 0,
            ]);
        }

        // ── Specs ─────────────────────────────────────────
        foreach ($request->input('specs', []) as $s) {
            if (empty($s['spec_key']) || empty($s['spec_value'])) continue;
            $car->specs()->create([
                'category'       => $s['category'] ?? '',
                'category_order' => $s['category_order'] ?? 0,
                'spec_key'       => $s['spec_key'],
                'spec_value'     => $s['spec_value'],
                'variant_id'     => $s['variant_id'] ?? null,
                'sort_order'     => $s['sort_order'] ?? 0,
            ]);
        }

        // ── Features ──────────────────────────────────────
        @mkdir(public_path('images/features'), 0775, true);
        foreach ($request->input('features', []) as $idx => $f) {
            if (empty($f['title'])) continue;

            $featImg = $f['image'] ?? null;
            if ($request->hasFile("feature_images.{$idx}")) {
                $file     = $request->file("feature_images.{$idx}");
                $filename = time() . '_feat_' . $idx . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/features'), $filename);
                $featImg  = 'images/features/' . $filename;
            }

            $featImg2 = $f['image2'] ?? null;
            if ($request->hasFile("feature_images2.{$idx}")) {
                $file2     = $request->file("feature_images2.{$idx}");
                $filename2 = time() . '_feat2_' . $idx . '_' . $file2->getClientOriginalName();
                $file2->move(public_path('images/features'), $filename2);
                $featImg2  = 'images/features/' . $filename2;
            }

            $car->features()->create([
                'title'       => $f['title'],
                'description' => $f['description'] ?? '',
                'image'       => $featImg ?? '',
                'image2'      => $featImg2 ?? '',
                'variant_id'  => $f['variant_id'] ?? null,
                'sort_order'  => $f['sort_order'] ?? 0,
            ]);
        }

        // ── Galleries ─────────────────────────────────────
        foreach ($request->input('galleries', []) as $idx => $g) {
            $filePath = $g['file_path'] ?? null;
            if ($request->hasFile("gallery_files.{$idx}")) {
                $file     = $request->file("gallery_files.{$idx}");
                $filename = time() . '_gallery_' . $idx . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/car'), $filename);
                $filePath = 'images/car/' . $filename;
            }
            if (empty($filePath)) continue;
            $car->galleries()->create([
                'file_path'  => $filePath,
                'type'       => $g['type'] ?? 'image',
                'thumbnail'  => $g['thumbnail'] ?? null,
                'caption'    => $g['caption'] ?? null,
                'sort_order' => $g['sort_order'] ?? 0,
            ]);
        }

        // ── Colors ────────────────────────────────────────
        @mkdir(public_path('images/colors'), 0775, true);
        foreach ($request->input('colors', []) as $idx => $c) {
            if (empty($c['name'])) continue;

            $colorImg = $c['image'] ?? null;
            if ($request->hasFile("color_images.{$idx}")) {
                $file     = $request->file("color_images.{$idx}");
                $filename = time() . '_color_' . $idx . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/colors'), $filename);
                $colorImg = 'images/colors/' . $filename;
            }

            $car->colors()->create([
                'name'        => $c['name'],
                'hex_code'    => $c['hex_code'] ?? '',
                'image'       => $colorImg,
                'price_addon' => $c['price_addon'] ?? 0,
                'is_default'  => isset($c['is_default']) ? 1 : 0,
                'sort_order'  => $c['sort_order'] ?? 0,
            ]);
        }

        // ── Expenses ──────────────────────────────────────
        foreach ($request->input('expenses', []) as $e) {
            if (empty($e['name']) || empty($e['amount'])) continue;
            $car->expenses()->create([
                'name'     => $e['name'],
                'category' => $e['category'] ?? 'other',
                'amount'   => $e['amount'],
                'note'     => $e['note'] ?? null,
            ]);
        }

        return redirect()->route('admin.cars.index')
                         ->with('success', 'Thêm xe "' . $car->name . '" thành công!');
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
            'name'             => 'required|string|max:255',
            'brand_id'         => 'required|exists:brands,id',
            'model'            => 'nullable|string|max:255',
            'tagline'          => 'nullable|string|max:255',
            'price_per_day'    => 'required|numeric|min:0',
            'cost_price'       => 'nullable|numeric|min:0',
            'sale_price'       => 'nullable|numeric|min:0',
            'mileage'          => 'nullable|integer|min:0',
            'fuel_type'        => 'nullable|string|max:50',
            'condition'        => 'nullable|string|max:50',
            'engine'           => 'nullable|string|max:100',
            'seats'            => 'nullable|integer|min:1',
            'transmission'     => 'nullable|string|max:50',
            'description'      => 'nullable|string',
            'content'          => 'nullable|string',
            'status'           => 'nullable|string|in:available,out_of_stock,coming_soon',
            'image_url'        => 'nullable|string|max:500',
            'image_file'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'hero_image'       => 'nullable|string|max:500',
            'is_available'     => 'nullable|boolean',
            'is_featured'      => 'nullable|boolean',
            'badge_label'      => 'nullable|string|max:50',
            'image_360_prefix' => 'nullable|string|max:100',
            'image_360_frames' => 'nullable|integer|min:1|max:72',
            'slug'             => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'year'             => 'nullable|integer|min:2000',
            'horsepower'       => 'nullable|integer|min:0',
            'fuel_consumption' => 'nullable|string|max:20',
        ]);

        $validated['is_featured']  = $request->boolean('is_featured');
        $validated['is_available'] = $request->boolean('is_available', true);

        // ── Ảnh đại diện ──────────────────────────────────
        if ($request->hasFile('image_file')) {
            $file     = $request->file('image_file');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('images/car'), $filename);
            $validated['image_url'] = 'images/car/' . $filename;
        } elseif ($request->filled('image_url')) {
            $validated['image_url'] = $request->input('image_url');
        }

        // ── Ảnh hero ──────────────────────────────────────
        if ($request->hasFile('hero_image_file')) {
            $file     = $request->file('hero_image_file');
            $filename = time() . '_hero_' . $file->getClientOriginalName();
            @mkdir(public_path('images/hero'), 0775, true);
            $file->move(public_path('images/hero'), $filename);
            $validated['hero_image'] = 'images/hero/' . $filename;
        } elseif ($request->filled('hero_image')) {
            $validated['hero_image'] = $request->input('hero_image');
        }

        // ── Slug tự động + tránh trùng ────────────────────
        $baseSlug = !empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['name']);

        $slug  = $baseSlug;
        $count = 1;
        while (Car::where('slug', $slug)->where('id', '!=', $car->id)->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }
        $validated['slug'] = $slug;

        // ── Badge & 360 chỉ khi is_featured ───────────────
        if (!$validated['is_featured']) {
            $validated['badge_label']      = null;
            $validated['image_360_prefix'] = null;
        }

        // ── Cập nhật xe ───────────────────────────────────
        try {
            $car->update($validated);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062 && str_contains($e->getMessage(), 'cars_slug_unique')) {
                $validated['slug'] = $baseSlug . '-' . time();
                $car->update($validated);
            } else {
                throw $e;
            }
        }

        // ── Variants: xóa cũ → tạo mới ───────────────────
        $car->variants()->delete();
        foreach ($request->input('variants', []) as $v) {
            if (empty($v['name'])) continue;
            $car->variants()->create([
                'name'                  => $v['name'],
                'price'                 => $v['price'] ?? null,
                'price_with_battery'    => $v['price_with_battery'] ?? null,
                'price_without_battery' => $v['price_without_battery'] ?? null,
                'sort_order'            => $v['sort_order'] ?? 0,
            ]);
        }

        // ── Specs: xóa cũ → tạo mới ──────────────────────
        $car->specs()->delete();
        foreach ($request->input('specs', []) as $s) {
            if (empty($s['spec_key']) || empty($s['spec_value'])) continue;
            $car->specs()->create([
                'category'       => $s['category'] ?? '',
                'category_order' => $s['category_order'] ?? 0,
                'spec_key'       => $s['spec_key'],
                'spec_value'     => $s['spec_value'],
                'variant_id'     => $s['variant_id'] ?? null,
                'sort_order'     => $s['sort_order'] ?? 0,
            ]);
        }

        // ── Features: xóa cũ → tạo mới ───────────────────
        @mkdir(public_path('images/features'), 0775, true);
        $car->features()->delete();
        foreach ($request->input('features', []) as $idx => $f) {
            if (empty($f['title'])) continue;

            // Upload ảnh chính (nếu có file mới, dùng file; không thì giữ path cũ từ hidden input)
            $featImg = $f['image'] ?? '';
            if ($request->hasFile("feature_images.{$idx}")) {
                $file     = $request->file("feature_images.{$idx}");
                $filename = time() . '_feat_' . $idx . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/features'), $filename);
                $featImg  = 'images/features/' . $filename;
            }

            // Upload ảnh phụ
            $featImg2 = $f['image2'] ?? '';
            if ($request->hasFile("feature_images2.{$idx}")) {
                $file2     = $request->file("feature_images2.{$idx}");
                $filename2 = time() . '_feat2_' . $idx . '_' . $file2->getClientOriginalName();
                $file2->move(public_path('images/features'), $filename2);
                $featImg2  = 'images/features/' . $filename2;
            }

            $car->features()->create([
                'title'       => $f['title'],
                'description' => $f['description'] ?? '',
                'image'       => $featImg,
                'image2'      => $featImg2,
                'variant_id'  => $f['variant_id'] ?? null,
                'sort_order'  => $f['sort_order'] ?? 0,
            ]);
        }

        // ── Galleries: xóa cũ → tạo mới ──────────────────
        $car->galleries()->delete();
        foreach ($request->input('galleries', []) as $idx => $g) {
            $filePath = $g['file_path'] ?? null;
            if ($request->hasFile("gallery_files.{$idx}")) {
                $file     = $request->file("gallery_files.{$idx}");
                $filename = time() . '_gallery_' . $idx . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/car'), $filename);
                $filePath = 'images/car/' . $filename;
            }
            if (empty($filePath)) continue;
            $car->galleries()->create([
                'file_path'  => $filePath,
                'type'       => $g['type'] ?? 'image',
                'thumbnail'  => $g['thumbnail'] ?? null,
                'caption'    => $g['caption'] ?? null,
                'sort_order' => $g['sort_order'] ?? 0,
            ]);
        }

        // ── Colors: xóa cũ → tạo mới ─────────────────────
        @mkdir(public_path('images/colors'), 0775, true);
        $car->colors()->delete();
        foreach ($request->input('colors', []) as $idx => $c) {
            if (empty($c['name'])) continue;

            $colorImg = $c['image'] ?? null;
            if ($request->hasFile("color_images.{$idx}")) {
                $file     = $request->file("color_images.{$idx}");
                $filename = time() . '_color_' . $idx . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/colors'), $filename);
                $colorImg = 'images/colors/' . $filename;
            }

            $car->colors()->create([
                'name'        => $c['name'],
                'hex_code'    => $c['hex_code'] ?? '',
                'image'       => $colorImg,
                'price_addon' => $c['price_addon'] ?? 0,
                'is_default'  => isset($c['is_default']) ? 1 : 0,
                'sort_order'  => $c['sort_order'] ?? 0,
            ]);
        }

        // ── Expenses: xóa cũ → tạo mới ───────────────────
        $car->expenses()->delete();
        foreach ($request->input('expenses', []) as $e) {
            if (empty($e['name']) || empty($e['amount'])) continue;
            $car->expenses()->create([
                'name'     => $e['name'],
                'category' => $e['category'] ?? 'other',
                'amount'   => $e['amount'],
                'note'     => $e['note'] ?? null,
            ]);
        }

        return redirect()->route('admin.cars.index')
                         ->with('success', 'Cập nhật xe "' . $car->name . '" thành công!');
    }

    public function destroy(Car $car)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        $car->delete();
        return back()->with('success', 'Đã xóa xe.');
    }

    // ── Image Browser ─────────────────────────────────────────────────────────
    public function imageBrowser(Request $request): \Illuminate\Http\JsonResponse
    {
        $allowed = ['car', 'hero', 'features', 'colors', 'vinfast'];
        $folder  = $request->get('folder', 'car');

        if (!in_array($folder, $allowed)) {
            return response()->json([]);
        }

        $dir = public_path('images/' . $folder);

        if (!is_dir($dir)) {
            return response()->json([]);
        }

        $files = collect(scandir($dir))
            ->filter(fn($f) => preg_match('/\.(jpg|jpeg|png|webp|gif|svg)$/i', $f))
            ->values()
            ->map(fn($f) => [
                'name' => $f,
                'path' => 'images/' . $folder . '/' . $f,
                'url'  => '/images/' . $folder . '/' . $f,
            ]);

        return response()->json($files);
    }
}