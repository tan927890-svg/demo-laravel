<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\FeaturedCarController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaoGiaNhanhController;
use App\Http\Controllers\MaintenanceReminderController;
use App\Http\Controllers\PickupDeliveryController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Admin\ProfitController;
use App\Http\Controllers\Admin\PriceListController;
use App\Http\Controllers\Admin\AttendanceViewController;
use App\Http\Controllers\Admin\PayrollController;

// ── Auth routes ──────────────────────────────────────────────────────────────
Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// ── Trang chủ ────────────────────────────────────────────────────────────────
Route::get('/', function () {
    $userAgent = request()->header('User-Agent');
    $isMobile = preg_match('/Android|iPhone|iPad|Mobile/i', $userAgent);

    if ($isMobile && Auth::check()) {
        return app(AuthController::class)->redirectByRole(Auth::user());
    }

    return app(CarController::class)->home(request());
})->name('home');

// ── Về chúng tôi ─────────────────────────────────────────────────────────────
Route::get('/about', fn() => view('about'))->name('about');

// ── Dịch vụ ──────────────────────────────────────────────────────────────────
Route::get('/services', fn() => view('services'))->name('services');

// ── Liên hệ ──────────────────────────────────────────────────────────────────
Route::get('/contact',  [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// ── Báo giá nhanh ────────────────────────────────────────────────────────────
Route::post('/bao-gia-nhanh', [BaoGiaNhanhController::class, 'store'])->name('bao-gia-nhanh.store');

// ── Dashboard redirect ────────────────────────────────────────────────────────
Route::get('/dashboard', function () {
    if (Auth::check() && (Auth::user()->role !== null)) {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ── Tin tức ──────────────────────────────────────────────────────────────────
Route::get('/news',        [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// ── Newsletter ────────────────────────────────────────────────────────────────
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// ── Cars public ──────────────────────────────────────────────────────────────
Route::get('/cars',               [CarController::class, 'index'])->name('cars.index');
Route::get('/cars/compare',       [CarController::class, 'compare'])->name('cars.compare');

// ── BẢNG GIÁ ─────────────────────────────────────────────────────────────────
Route::get('/cars/bang-gia', function () {
    $cars = \App\Models\Car::with('brand')
        ->orderBy('brand_id')
        ->orderBy('name')
        ->get();
    return view('cars.bang-gia', compact('cars'));
})->name('cars.price-list');

Route::get('/cars/{car}/du-toan', [CarController::class, 'costEstimate'])->name('cars.costEstimate');
Route::get('/cars/{car}',         [CarController::class, 'show'])->name('cars.show')->whereNumber('car');
Route::get('/du-toan-chi-phi',    [CarController::class, 'costEstimateGeneral'])->name('costEstimate');

// ── Dịch vụ bổ sung ──────────────────────────────────────────────────────────
Route::get('/services/dat-lich',            [BookingController::class, 'create'])->name('services.booking');
Route::post('/services/dat-lich',           [BookingController::class, 'store'])->name('booking.store');
Route::get('/services/quy-trinh-bao-duong', fn() => view('quy-trinh-bao-duong'))->name('services.maintenance-process');
Route::get('/services/lich-bao-duong',      fn() => view('lich-bao-duong-dinh-ky'))->name('services.maintenance-schedule');
Route::get('/services/nhan-giao-xe',        fn() => view('nhan-giao-xe-mien-phi'))->name('services.pickup-delivery');
Route::post('/maintenance/reminder/send',   [MaintenanceReminderController::class, 'send'])->name('maintenance.reminder.send');
Route::post('/services/nhan-giao-xe/send',  [PickupDeliveryController::class, 'send'])->name('pickup-delivery.send');

// ── Chat bot ─────────────────────────────────────────────────────────────────
Route::get('/chat',        [ChatController::class, 'index'])->name('chat.index');
Route::post('/chat',       [ChatController::class, 'send'])->name('chat.send');
Route::post('/chat/image', [ChatController::class, 'sendImage'])->name('chat.image');
Route::post('/chat/clear', [ChatController::class, 'clearSession'])->name('chat.clear');

// ── Search API ────────────────────────────────────────────────────────────────
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
            if ($color?->image) $image = asset(ltrim($color->image, '/'));
            if (!$image) {
                $gallery = $car->galleries->where('type', 'image')
                    ->filter(fn($g) => str_contains($g->file_path ?? '', '-TN'))
                    ->sortBy('sort_order')->first();
                if ($gallery?->file_path) $image = asset(ltrim($gallery->file_path, '/'));
            }
            if (!$image) {
                $gallery = $car->galleries->where('type', 'image')->sortBy('sort_order')->first();
                if ($gallery?->file_path) $image = asset(ltrim($gallery->file_path, '/'));
            }
            return ['id' => $car->id, 'name' => $car->name, 'price' => $car->price_per_day ?? $car->price, 'image' => $image];
        });

    return response()->json($cars);
});

// ── Cars data proxy cho chatbot ───────────────────────────────────────────────
Route::get('/api/cars-data', function () {
    $cars = \App\Models\Car::with(['variants', 'colors', 'specs', 'features', 'galleries'])
        ->get()
        ->map(function ($car) {
            $image = null;
            $color = $car->colors->firstWhere('is_default', true) ?? $car->colors->first();
            if ($color?->image) $image = asset(ltrim($color->image, '/'));
            if (!$image) {
                $gallery = $car->galleries
                    ->where('type', 'image')
                    ->filter(fn($g) => str_contains($g->file_path ?? '', '-TN'))
                    ->sortBy('sort_order')->first();
                if ($gallery?->file_path) $image = asset(ltrim($gallery->file_path, '/'));
            }
            if (!$image) {
                $gallery = $car->galleries->where('type', 'image')->sortBy('sort_order')->first();
                if ($gallery?->file_path) $image = asset(ltrim($gallery->file_path, '/'));
            }

            $variants = $car->variants->sortBy('sort_order')->map(fn($v) => [
                'name'  => $v->name,
                'price' => $v->price,
            ])->values();

            $prices    = $variants->pluck('price')->filter();
            $minPrice  = $prices->min() ?? 0;
            $maxPrice  = $prices->max() ?? 0;

            $specsGrouped = [];
            foreach ($car->specs->sortBy(['category_order','sort_order']) as $s) {
                $specsGrouped[$s->category][] = ['key' => $s->spec_key, 'value' => $s->spec_value];
            }

            $featuresGrouped = [];
            foreach ($car->features as $f) {
                $cat = $f->category ?? 'Tính năng';
                $featuresGrouped[$cat][] = $f->description ?? $f->name ?? '';
            }

            return [
                'id'          => $car->id,
                'name'        => $car->name,
                'slug'        => $car->slug ?? '',
                'image'       => $image,
                'description' => $car->description ?? $car->short_description ?? null,
                'variants'    => $variants,
                'min_price'   => $minPrice,
                'max_price'   => $maxPrice,
                'colors'      => $car->colors->pluck('name')->filter()->values(),
                'specs'       => $specsGrouped,
                'features'    => $featuresGrouped,
            ];
        });

    return response()->json(['status' => 'ok', 'count' => $cars->count(), 'cars' => $cars]);
});

// ── Routes cần đăng nhập (khách hàng) ───────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cars/{car}/order',  [OrderController::class, 'create'])->name('orders.create');
    Route::post('/cars/{car}/order', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders',            [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}',    [OrderController::class, 'show'])->name('orders.show');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
});

// ────────────────────────────────────────────────────────────────────────────
//  ADMIN PANEL
// ────────────────────────────────────────────────────────────────────────────
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // ── Admin profile ────────────────────────────────────────────────────────
    Route::get('profile',            [ProfileController::class, 'index'])->name('profile');
    Route::patch('profile',          [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('profile/password', [ProfileController::class, 'password'])->name('profile.password');

    // ── ADMIN only ───────────────────────────────────────────────────────────
    Route::middleware('role:admin')->group(function () {
        Route::delete('cars/{car}', [AdminCarController::class, 'destroy'])->name('cars.destroy');
    });

    // ── ADMIN + MANAGER ──────────────────────────────────────────────────────
    Route::middleware('role:admin,manager')->group(function () {

        Route::resource('users', App\Http\Controllers\Admin\UserController::class);

        Route::get('dashboard/revenue',
            [App\Http\Controllers\Admin\DashboardController::class, 'revenue'])
            ->name('dashboard.revenue');

        Route::get('orders/create',          [AdminOrderController::class, 'create'])->name('orders.create');
        Route::post('orders',                [AdminOrderController::class, 'store'])->name('orders.store');
        Route::get('orders',                 [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}',         [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::post('orders/{order}/close',  [AdminOrderController::class, 'close'])->name('orders.close');
        Route::post('orders/{order}/assign', [AdminOrderController::class, 'assignStaff'])->name('orders.assign');
        Route::delete('orders/{order}',      [AdminOrderController::class, 'destroy'])->name('orders.destroy');

        Route::get('kpi',                                    [App\Http\Controllers\Admin\KpiController::class, 'index'])->name('kpi.index');
        Route::get('kpi/{user}',                             [App\Http\Controllers\Admin\KpiController::class, 'show'])->name('kpi.show')->whereNumber('user');
        Route::post('kpi/{user}/set-target',                 [App\Http\Controllers\Admin\KpiController::class, 'setKpiTarget'])->name('kpi.setTarget')->whereNumber('user');
        Route::post('kpi/{user}/orders',                     [App\Http\Controllers\Admin\KpiController::class, 'storeOrder'])->name('kpi.storeOrder')->whereNumber('user');
        Route::delete('kpi/{user}/orders/{order}',           [App\Http\Controllers\Admin\KpiController::class, 'destroyOrder'])->name('kpi.destroyOrder')->whereNumber('user');
        Route::post('kpi/orders/{order}/consulted',          [App\Http\Controllers\Admin\KpiController::class, 'markConsulted'])->name('kpi.markConsulted');
        Route::post('kpi/orders/{order}/close',              [App\Http\Controllers\Admin\KpiController::class, 'closeOrder'])->name('kpi.closeOrder');

        Route::get('cars/image-browser', [AdminCarController::class, 'imageBrowser'])->name('cars.imageBrowser');
        Route::get('cars/create',     [AdminCarController::class, 'create'])->name('cars.create');
        Route::post('cars',           [AdminCarController::class, 'store'])->name('cars.store');
        Route::get('cars/{car}/edit', [AdminCarController::class, 'edit'])->name('cars.edit');
        Route::put('cars/{car}',      [AdminCarController::class, 'update'])->name('cars.update');

        Route::get('featured-cars/{car}/edit',             [FeaturedCarController::class, 'edit'])->name('featured-cars.edit');
        Route::patch('featured-cars/{car}/mark',           [FeaturedCarController::class, 'markFeatured'])->name('featured-cars.mark');
        Route::patch('featured-cars/{car}/unmark',         [FeaturedCarController::class, 'unmarkFeatured'])->name('featured-cars.unmark');
        Route::put('featured-cars/{car}/update-360',       [FeaturedCarController::class, 'update360'])->name('featured-cars.update360');
        Route::delete('featured-cars/{car}/frame/{frame}', [FeaturedCarController::class, 'deleteFrame'])->name('featured-cars.delete-frame');
        Route::delete('featured-cars/{car}/frames',        [FeaturedCarController::class, 'deleteFrames'])->name('featured-cars.delete-frames');

        Route::resource('news', App\Http\Controllers\Admin\NewsController::class);
        Route::post('contacts/mark-all-read',
            [App\Http\Controllers\Admin\ContactController::class, 'markAllRead'])
            ->name('contacts.markAllRead');
        Route::post('contacts/{contact}/assign',
            [App\Http\Controllers\Admin\ContactController::class, 'assign'])
            ->name('contacts.assign');
        Route::resource('contacts',   App\Http\Controllers\Admin\ContactController::class);
        Route::resource('newsletter', App\Http\Controllers\Admin\NewsletterController::class);

        Route::post('media/upload', [App\Http\Controllers\Admin\MediaController::class, 'upload'])->name('media.upload');
        Route::get('media/images',  [App\Http\Controllers\Admin\MediaController::class, 'images'])->name('media.images');

        Route::get('attendance/export',        [AttendanceViewController::class, 'export'])->name('attendance.export');
        Route::get('attendance',               [AttendanceViewController::class, 'index'])->name('attendance.index');
        Route::get('attendance/{user}/export', [AttendanceViewController::class, 'exportUser'])->name('attendance.export.user')->whereNumber('user');
        Route::get('attendance/{user}',        [AttendanceViewController::class, 'show'])->name('attendance.show')->whereNumber('user');

        Route::get('notifications/create',            [App\Http\Controllers\Admin\NotificationController::class, 'create'])->name('notifications.create');
        Route::post('notifications',                  [App\Http\Controllers\Admin\NotificationController::class, 'store'])->name('notifications.store');
        Route::delete('notifications/{notification}', [App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');

        Route::get('profit',       [ProfitController::class, 'index'])->name('profit.index');
        Route::get('profit/{car}', [ProfitController::class, 'show'])->name('profit.show');
        Route::put('profit/{car}', [ProfitController::class, 'update'])->name('profit.update');

        Route::get('price-list',  [PriceListController::class, 'index'])->name('price-list.index');
        Route::post('price-list', [PriceListController::class, 'update'])->name('price-list.update');

        Route::get('payroll',                          [PayrollController::class, 'index'])->name('payroll.index');
        Route::post('payroll/calculate',               [PayrollController::class, 'calculate'])->name('payroll.calculate');
        Route::get('payroll/export',                   [PayrollController::class, 'export'])->name('payroll.export');
        Route::get('payroll/salary/manage',            [PayrollController::class, 'salaryIndex'])->name('payroll.salary.index');
        Route::post('payroll/salary/store',            [PayrollController::class, 'storeSalary'])->name('payroll.salary.store');
        Route::get('payroll/{payroll}',                [PayrollController::class, 'show'])->name('payroll.show');
        Route::post('payroll/{payroll}/approve',       [PayrollController::class, 'approve'])->name('payroll.approve');
        Route::post('payroll/{payroll}/reopen',        [PayrollController::class, 'reopen'])->name('payroll.reopen');
        Route::patch('payroll/{payroll}/base-salary',  [PayrollController::class, 'updateBaseSalary'])->name('payroll.updateBaseSalary');
       Route::patch(
    'payroll/{payroll}/overtime-rate',
    [PayrollController::class, 'updateOvertimeRate']
)->name('payroll.updateOvertimeRate');
        Route::delete('payroll/{payroll}',             [PayrollController::class, 'destroy'])->name('payroll.destroy');
    });

    // ── TẤT CẢ (admin, manager, staff) ──────────────────────────────────────
    Route::middleware('role:admin,manager,staff')->group(function () {

        Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('kpi/me', [App\Http\Controllers\Admin\KpiController::class, 'me'])->name('kpi.me');

        Route::get('featured-cars', [FeaturedCarController::class, 'index'])->name('featured-cars.index');

        Route::get('cars',       [AdminCarController::class, 'index'])->name('cars.index');
        Route::get('cars/{car}', [AdminCarController::class, 'show'])->name('cars.show');

        Route::get('notifications',                      [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
        Route::get('notifications/unread',               [App\Http\Controllers\Admin\NotificationController::class, 'unread'])->name('notifications.unread');
        Route::get('notifications/latest',               [App\Http\Controllers\Admin\NotificationController::class, 'latest'])->name('notifications.latest');
        Route::post('notifications/mark-all-read',       [App\Http\Controllers\Admin\NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
        Route::post('notifications/{notification}/read', [App\Http\Controllers\Admin\NotificationController::class, 'markRead'])->name('notifications.markRead');
    });

    // ── STAFF + MANAGER (chấm công cá nhân) ─────────────────────────────────
    Route::middleware(['role:admin,manager,staff', 'office.network'])->prefix('staff')->name('staff.')->group(function () {

        Route::get('customers', [StaffController::class, 'customers'])->name('customers');

        Route::get('orders',                [StaffController::class, 'ordersIndex'])->name('orders.index');
        Route::get('orders/create',         [StaffController::class, 'ordersCreate'])->name('orders.create');
        Route::post('orders',               [StaffController::class, 'ordersStore'])->name('orders.store');
        Route::get('orders/{order}',        [StaffController::class, 'ordersShow'])->name('orders.show');
        Route::post('orders/{order}/consultation',
            [StaffController::class, 'updateConsultation'])->name('orders.consultation');
        Route::delete('orders/{order}',
            [StaffController::class, 'ordersDestroy'])->name('orders.destroy');

        Route::get('attendance',                  [StaffController::class, 'attendance'])->name('attendance');
        Route::post('attendance/checkin',         [StaffController::class, 'checkIn'])->name('attendance.checkin');
        Route::post('attendance/checkout',        [StaffController::class, 'checkOut'])->name('attendance.checkout');
        Route::get('attendance/face-descriptor',  [StaffController::class, 'getFaceDescriptor'])->name('attendance.face.get');
        Route::post('attendance/face-descriptor', [StaffController::class, 'saveFaceDescriptor'])->name('attendance.face.save');

        Route::get('performance', [StaffController::class, 'performance'])->name('performance');
    });
});

// ── Newsletter export ─────────────────────────────────────────────────────────
Route::get('newsletter/export', [NewsletterController::class, 'export'])->name('admin.newsletter.export');

// ── Password reset ────────────────────────────────────────────────────────────
Route::get('/password/reset',       [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/password/reset',      [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
Route::get('/password/otp',         [ForgotPasswordController::class, 'showOtpForm'])->name('password.otp');
Route::post('/password/otp/verify', [ForgotPasswordController::class, 'verifyOtp'])->name('password.otp.verify');
Route::get('/password/new',         [ForgotPasswordController::class, 'showNewPasswordForm'])->name('password.reset.form');
Route::post('/password/new',        [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');

Route::post('/admin/users/{user}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])
    ->name('admin.users.reset-password');