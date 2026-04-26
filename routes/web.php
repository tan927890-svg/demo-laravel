<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaoGiaNhanhController;
use App\Http\Controllers\MaintenanceReminderController;
use App\Http\Controllers\PickupDeliveryController;

// ── Auth routes ──
Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// ── Trang chủ ──
Route::get('/', [CarController::class, 'home'])->name('home');

// ── Về chúng tôi ──
Route::get('/about', function () {
    return view('about');
})->name('about');

// ── Dịch vụ ──
Route::get('/services', function () {
    return view('services');
})->name('services');

// ── Liên hệ ──
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// ── Báo giá nhanh ──
Route::post('/bao-gia-nhanh', [BaoGiaNhanhController::class, 'store'])->name('bao-gia-nhanh.store');

// ── Dashboard ──
Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ── Tin tức ──
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// ── Newsletter ──
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// ── Cars - public ──
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::get('/cars/compare', [CarController::class, 'compare'])->name('cars.compare');
Route::get('/cars/bang-gia', fn() => view('cars.bang-gia'))->name('cars.price-list');
Route::get('/cars/{car}/du-toan', [CarController::class, 'costEstimate'])->name('cars.costEstimate');
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show')->whereNumber('car');

// ── Dự toán chi phí ──
Route::get('/du-toan-chi-phi', [CarController::class, 'costEstimateGeneral'])->name('costEstimate');

// ── Dịch vụ bổ sung ──
Route::get('/services/dat-lich', function () {
    return view('dat-lich-dich-vu');
})->name('services.booking');

Route::post('/services/dat-lich', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'ho_ten'       => 'required|string|max:100',
        'dien_thoai'   => 'required|string|max:20',
        'hang_xe'      => 'required|string',
        'booking_date' => 'required|date|after:today',
    ]);
    return redirect()->route('services.booking')->with('success', 'Đặt lịch thành công!');
})->name('services.booking.store');

Route::get('/services/quy-trinh-bao-duong', function () {
    return view('quy-trinh-bao-duong');
})->name('services.maintenance-process');

Route::get('/services/lich-bao-duong', function () {
    return view('lich-bao-duong-dinh-ky');
})->name('services.maintenance-schedule');

Route::get('/services/nhan-giao-xe', function () {
    return view('nhan-giao-xe-mien-phi');
})->name('services.pickup-delivery');

Route::post('/maintenance/reminder/send', [MaintenanceReminderController::class, 'send'])
    ->name('maintenance.reminder.send');

Route::post('/services/nhan-giao-xe/send', [PickupDeliveryController::class, 'send'])
    ->name('pickup-delivery.send');

// ── Search API ──
Route::get('/api/cars/search', function (\Illuminate\Http\Request $request) {
    $q = trim($request->get('q', ''));
    if (strlen($q) < 2) return response()->json([]);

    $cars = \App\Models\Car::with(['colors', 'galleries'])
        ->where('name', 'like', '%' . $q . '%')
        ->orWhereHas('brand', fn($b) => $b->where('name', 'like', '%' . $q . '%'))
        ->limit(8)
        ->get()
        ->map(function ($car) {
            $image = null;

            $color = $car->colors->firstWhere('is_default', true) ?? $car->colors->first();
            if ($color?->image) {
                $image = asset(ltrim($color->image, '/'));
            }

            if (!$image) {
                $gallery = $car->galleries
                    ->where('type', 'image')
                    ->filter(fn($g) => str_contains($g->file_path ?? '', '-TN'))
                    ->sortBy('sort_order')
                    ->first();
                if ($gallery?->file_path) {
                    $image = asset(ltrim($gallery->file_path, '/'));
                }
            }

            if (!$image) {
                $gallery = $car->galleries->where('type', 'image')->sortBy('sort_order')->first();
                if ($gallery?->file_path) {
                    $image = asset(ltrim($gallery->file_path, '/'));
                }
            }

            return [
                'id'    => $car->id,
                'name'  => $car->name,
                'price' => $car->price_per_day ?? $car->price,
                'image' => $image,
            ];
        });

    return response()->json($cars);
});

// ── Routes cần đăng nhập ──
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cars/{car}/order', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/cars/{car}/order', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
});

// ── Admin routes ──
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // ── ADMIN only ──────────────────────────────────────
    Route::middleware('role:admin')->group(function () {
        // Dashboard doanh thu
        Route::get('dashboard/revenue', [App\Http\Controllers\Admin\DashboardController::class, 'revenue'])
            ->name('dashboard.revenue');

        // Quản lý users
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);

        // Xóa xe
        Route::delete('cars/{car}', [AdminCarController::class, 'destroy'])->name('cars.destroy');

        // Tin tức
        Route::resource('news', App\Http\Controllers\Admin\NewsController::class);

        // Liên hệ
        Route::post('contacts/mark-all-read', [App\Http\Controllers\Admin\ContactController::class, 'markAllRead'])
            ->name('contacts.markAllRead');
        Route::resource('contacts', App\Http\Controllers\Admin\ContactController::class);

        // Newsletter
        Route::resource('newsletter', App\Http\Controllers\Admin\NewsletterController::class);

        // Media
        Route::post('media/upload', [App\Http\Controllers\Admin\MediaController::class, 'upload'])->name('media.upload');
        Route::get('media/images',  [App\Http\Controllers\Admin\MediaController::class, 'images'])->name('media.images');
    });

    // ── ADMIN + MANAGER ──────────────────────────────────
    Route::middleware('role:admin,manager')->group(function () {
        // Dashboard chính
        Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Đơn hàng
        Route::get('orders',                 [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}',         [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

        // KPI nhân viên: danh sách + chi tiết từng người
        Route::get('kpi',        [App\Http\Controllers\Admin\KpiController::class, 'index'])->name('kpi.index');
        Route::get('kpi/{user}', [App\Http\Controllers\Admin\KpiController::class, 'show'])->name('kpi.show');

        // CRUD xe (trừ xóa - xóa chỉ admin)
        Route::get('cars/create',     [AdminCarController::class, 'create'])->name('cars.create');
        Route::post('cars',           [AdminCarController::class, 'store'])->name('cars.store');
        Route::get('cars/{car}/edit', [AdminCarController::class, 'edit'])->name('cars.edit');
        Route::put('cars/{car}',      [AdminCarController::class, 'update'])->name('cars.update');
    });

    // ── TẤT CẢ (admin, manager, staff) ──────────────────
    Route::middleware('role:admin,manager,staff')->group(function () {
        Route::get('cars',       [AdminCarController::class, 'index'])->name('cars.index');
        Route::get('cars/{car}', [AdminCarController::class, 'show'])->name('cars.show');
    });
});

// ── Password reset ──
Route::get('/password/reset', function () {
    return view('auth.forgot-password');
})->name('password.request');

// ── Newsletter export ──
Route::get('newsletter/export', [NewsletterController::class, 'export'])->name('admin.newsletter.export');