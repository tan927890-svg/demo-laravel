@extends('layouts.frontend')

@section('title', 'Bộ sưu tập xe - AUTO X')

@push('styles')
<style>
body:not(.home-page) main { margin-top: 0 !important; }
:root {
  --red: #d42b2b;
  --dark: #1a1a1a;
  --muted: #888;
  --border: #e8e8e8;
}
*, *::before, *::after { box-sizing: border-box; }
body { background: #fff; color: var(--dark); }
body:not(.home-page) main { margin-top: 0 !important; padding-top: 0 !important; }

/* ══════════════════════════════════════════
   XE NỔI BẬT
══════════════════════════════════════════ */
.featured-block {
  margin-bottom: 56px;
  padding-bottom: 52px;
  border-bottom: 1px solid var(--border);
}
.featured-block-header {
  display: flex; align-items: flex-end; justify-content: space-between;
  margin-bottom: 28px; flex-wrap: wrap; gap: 12px;
}
.featured-title {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: clamp(24px,3vw,40px); font-weight: 900;
  color: var(--dark); text-transform: uppercase; letter-spacing: -1px; line-height: 1;
}
.featured-title span { color: var(--red); }
.featured-subtitle {
  font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700;
  letter-spacing: 3px; text-transform: uppercase; color: var(--muted);
  margin-bottom: 6px;
}

.featured-grid {
  display: grid; grid-template-columns: repeat(4, 1fr); gap: 2px;
}

/* CARD */
.feat-card {
  position: relative; cursor: pointer; overflow: hidden;
  background: #f5f5f5; border: 1px solid var(--border);
  user-select: none; -webkit-user-select: none;
}
.feat-card::after {
  content: ''; position: absolute; inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.1) 45%, transparent 100%);
  pointer-events: none; z-index: 2;
}
.feat-canvas-wrap {
  position: relative; width: 100%; padding-top: 68%; overflow: hidden; background: #f5f5f5;
}
.feat-canvas-wrap img.feat-frame {
  position: absolute; inset: 0; width: 100%; height: 100%;
  object-fit: contain; padding: 8% 4% 4%;
}
.feat-drag-hint {
  position: absolute; top: 12px; right: 14px; z-index: 5;
  font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700;
  letter-spacing: 2px; text-transform: uppercase; color: rgba(0,0,0,0.35);
  display: flex; align-items: center; gap: 5px;
  transition: opacity .3s;
}
.feat-card.dragging .feat-drag-hint { opacity: 0; }
.feat-badge {
  position: absolute; top: 12px; left: 14px; z-index: 5;
  font-family: 'Rajdhani', sans-serif; font-size: 9px; font-weight: 700;
  letter-spacing: 2.5px; text-transform: uppercase;
  color: #fff; background: #d42b2b; padding: 4px 10px;
}
.feat-info {
  position: absolute; bottom: 0; left: 0; right: 0; z-index: 3;
  padding: 20px 20px 18px;
  transform: translateY(6px); transition: transform .3s ease;
}
.feat-card:hover .feat-info { transform: translateY(0); }
.feat-car-name {
  font-family: 'Barlow Condensed', sans-serif; font-size: 20px; font-weight: 900;
  color: #fff; text-transform: uppercase; letter-spacing: -.2px;
  margin-bottom: 4px; line-height: 1.1;
}
.feat-car-price {
  font-family: 'Barlow', sans-serif; font-size: 13px; color: rgba(255,255,255,0.55);
  margin-bottom: 12px;
}
.feat-car-price strong { color: rgba(255,255,255,0.9); font-weight: 700; }
.feat-btn {
  display: inline-block; font-family: 'Rajdhani', sans-serif;
  font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;
  color: #fff; border: 1px solid rgba(255,255,255,0.5); padding: 7px 16px;
  text-decoration: none; opacity: 0; transform: translateY(4px);
  transition: opacity .25s ease .05s, transform .25s ease .05s, background .2s, border-color .2s;
  cursor: pointer; background: transparent;
}
.feat-card:hover .feat-btn { opacity: 1; transform: translateY(0); }
.feat-btn:hover { background: #d42b2b; border-color: #d42b2b; }
.feat-progress {
  position: absolute; bottom: 0; left: 0; right: 0;
  height: 2px; background: rgba(0,0,0,0.1); z-index: 6; overflow: hidden;
}
.feat-progress-bar { height: 100%; background: #d42b2b; width: 0%; }

/* ══════════════════════════════════════════
   MODAL XE NỔI BẬT
══════════════════════════════════════════ */
.feat-modal-backdrop {
  position: fixed; inset: 0; z-index: 1000;
  background: rgba(0,0,0,0.82);
  display: flex; align-items: center; justify-content: center;
  opacity: 0; pointer-events: none;
  transition: opacity .3s ease;
  padding: 20px;
}
.feat-modal-backdrop.open { opacity: 1; pointer-events: all; }

.feat-modal {
  background: #0f0f0f; border: 1px solid rgba(255,255,255,0.08);
  width: 100%; max-width: 900px; max-height: 90vh;
  display: grid; grid-template-columns: 1fr 1fr;
  overflow: hidden;
  transform: translateY(20px) scale(0.97);
  transition: transform .3s ease;
  position: relative;
}
.feat-modal-backdrop.open .feat-modal {
  transform: translateY(0) scale(1);
}

.feat-modal-close {
  position: absolute; top: 16px; right: 18px; z-index: 10;
  background: none; border: none; color: rgba(255,255,255,0.5);
  font-size: 28px; cursor: pointer; line-height: 1; padding: 0;
  transition: color .2s;
}
.feat-modal-close:hover { color: #fff; }

.feat-modal-viewer {
  background: #1a1a1a; position: relative; overflow: hidden;
  display: flex; align-items: center; justify-content: center;
}
.feat-modal-viewer img {
  width: 100%; object-fit: contain; padding: 8%;
  cursor: ew-resize;
}
.feat-modal-viewer::after {
  content: '';
  position: absolute; bottom: 0; left: 0; right: 0; height: 60px;
  background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);
  pointer-events: none;
}
.feat-modal-progress {
  position: absolute; bottom: 0; left: 0; right: 0;
  height: 2px; background: rgba(255,255,255,0.08); overflow: hidden;
  z-index: 2;
}
.feat-modal-progress-bar { height: 100%; background: #d42b2b; width: 0%; }
.feat-modal-drag-tip {
  position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%);
  font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700;
  letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,0.7);
  white-space: nowrap; pointer-events: none; z-index: 3;
  background: rgba(0,0,0,0.45); padding: 4px 12px; border-radius: 20px;
}

.feat-modal-info {
  padding: 36px 32px; overflow-y: auto; color: #fff;
  display: flex; flex-direction: column;
}
.feat-modal-badge {
  font-family: 'Rajdhani', sans-serif; font-size: 9px; font-weight: 700;
  letter-spacing: 3px; text-transform: uppercase;
  color: #d42b2b; margin-bottom: 10px;
}
.feat-modal-name {
  font-family: 'Barlow Condensed', sans-serif; font-size: 32px; font-weight: 900;
  text-transform: uppercase; letter-spacing: -0.5px; line-height: 1.05;
  margin-bottom: 6px;
}
.feat-modal-price {
  font-family: 'Barlow', sans-serif; font-size: 15px;
  color: rgba(255,255,255,0.5); margin-bottom: 28px;
}
.feat-modal-price strong { color: #fff; font-size: 20px; font-weight: 800; }

.feat-modal-specs { margin-bottom: 24px; }
.feat-modal-spec-row {
  display: flex; justify-content: space-between; align-items: center;
  border-bottom: 1px solid rgba(255,255,255,0.07); padding: 9px 0;
}
.feat-modal-spec-label {
  font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
  letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,0.35);
}
.feat-modal-spec-val {
  font-family: 'Barlow', sans-serif; font-size: 13px; font-weight: 600;
  color: #fff; text-align: right;
}

.feat-modal-actions { margin-top: auto; display: flex; gap: 10px; padding-top: 20px; }

/* ── [SỬA] Nút chính: chữ trắng, không bị override ── */
.feat-modal-btn-main {
  flex: 1; font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
  letter-spacing: 2px; text-transform: uppercase;
  background: #d42b2b; color: #fff !important; border: none; padding: 13px 20px;
  cursor: pointer; text-decoration: none !important; text-align: center;
  transition: background .2s; display: inline-flex; align-items: center; justify-content: center;
}
.feat-modal-btn-main:hover { background: #b52222; color: #fff !important; }

.feat-modal-btn-sec {
  font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
  letter-spacing: 2px; text-transform: uppercase;
  background: none; color: rgba(255,255,255,0.6);
  border: 1px solid rgba(255,255,255,0.2); padding: 13px 18px;
  cursor: pointer; text-decoration: none; text-align: center;
  transition: color .2s, border-color .2s;
}
.feat-modal-btn-sec:hover { color: #fff; border-color: rgba(255,255,255,0.5); }

/* ══════════════════════════════════════════
   HEADER / BRAND TABS
══════════════════════════════════════════ */
.cars-header {
  background: #fff; border-bottom: 1px solid var(--border);
  padding: 28px 60px 0;
}
.cars-header-top {
  display: flex; align-items: flex-end; justify-content: space-between;
  margin-bottom: 20px; flex-wrap: wrap; gap: 12px;
}
.cars-title {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: clamp(22px,3vw,36px); font-weight: 900;
  color: var(--dark); text-transform: uppercase; letter-spacing: -.5px;
}
.cars-header-actions { display: flex; gap: 10px; }
.btn-action {
  font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
  letter-spacing: 2px; text-transform: uppercase;
  border: 1.5px solid var(--dark); color: var(--dark); background: #fff;
  padding: 9px 20px; text-decoration: none; white-space: nowrap;
  transition: background .2s, color .2s;
  display: inline-flex; align-items: center;
}
.btn-action:hover { background: var(--dark); color: #fff; }
.brand-tabs { display: flex; gap: 0; overflow-x: auto; scrollbar-width: none; }
.brand-tabs::-webkit-scrollbar { display: none; }
.brand-tab {
  font-family: 'Rajdhani', sans-serif; font-size: 15px; font-weight: 700;
  letter-spacing: 2px; text-transform: uppercase; color: var(--muted);
  padding: 14px 20px; text-decoration: none; white-space: nowrap;
  border-bottom: 2px solid transparent;
  border-top: none; border-left: none; border-right: none;
  background: none; cursor: pointer; transition: color .2s, border-color .2s;
}
.brand-tab:hover { color: var(--dark); }
.brand-tab.active { color: var(--red); border-bottom-color: var(--red); }

/* ══════════════════════════════════════════
   CARS GRID
══════════════════════════════════════════ */
.cars-wrap { padding: 44px 60px 60px; max-width: 1400px; margin: 0 auto; background: #fff; }
.cars-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 52px 36px; }
.cars-grid .car-item {
  text-decoration: none !important; display: block !important;
  cursor: pointer !important; background: transparent !important;
  border: none !important; border-radius: 0 !important;
  box-shadow: none !important; padding: 0 !important;
  transform: none !important; overflow: visible !important;
}
.cars-grid .car-item:hover {
  background: transparent !important; border: none !important;
  box-shadow: none !important; transform: none !important;
}
.car-item-info { padding: 0 0 10px; text-align: left; }
.car-item-name {
  font-family: 'Barlow Condensed', sans-serif; font-size: 22px; font-weight: 900;
  color: var(--red); text-transform: uppercase; letter-spacing: -.2px; margin-bottom: 3px;
}
.car-item-price-line { font-family: 'Barlow', sans-serif; font-size: 17px; color: var(--dark); }
.car-item-price-line strong { font-weight: 800; }
.car-item-price-line small { font-size: 11px; color: var(--muted); font-weight: 400; }

.car-item-status {
  display: inline-block; margin-top: 5px;
  font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700;
  letter-spacing: 2px; text-transform: uppercase; padding: 2px 8px;
}
.car-item-status.out-of-stock { color: #e53e3e; border: 1px solid #e53e3e; }
.car-item-status.coming-soon  { color: #d69e2e; border: 1px solid #d69e2e; }

.cars-grid .car-item .car-item-img-wrap {
  background: transparent !important; border: none !important;
  box-shadow: none !important; overflow: hidden;
}
.cars-grid .car-item .car-item-img {
  width: 100% !important; height: 180px !important;
  object-fit: contain !important; display: block !important;
  transition: transform .4s ease !important;
}
.cars-grid .car-item:hover .car-item-img { transform: scale(1.05) translateX(6px) !important; }
.cars-grid .car-item .car-item-img-placeholder {
  width: 100% !important; height: 0 !important;
  display: flex !important; align-items: center !important;
  justify-content: center !important; background: transparent !important;
  border: none !important; box-shadow: none !important;
}

.cars-grid .car-item.car-unavailable .car-item-img { opacity: .45; }

.empty-state { grid-column: 1/-1; text-align: center; padding: 80px 20px; color: #ccc; }
.empty-state p {
  font-family: 'Barlow Condensed', sans-serif; font-size: 24px;
  font-weight: 700; text-transform: uppercase; margin-top: 16px;
}
.pagi {
  display: flex; justify-content: center; gap: 4px; padding: 40px 0 0; flex-wrap: wrap;
}
.pagi a, .pagi span {
  font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
  letter-spacing: 1.5px; text-transform: uppercase;
  padding: 8px 14px; border: 1px solid var(--border);
  text-decoration: none; color: var(--muted); background: #fff;
  transition: background .2s, color .2s, border-color .2s;
}
.pagi a:hover { background: var(--red); color: #fff; border-color: var(--red); }
.pagi .current { background: var(--red); color: #fff; border-color: var(--red); }
.pagi [aria-disabled] { opacity: .35; pointer-events: none; }

/* ══════════════════════════════════════════
   HERO SLIDER
══════════════════════════════════════════ */
.cars-hero {
  position: relative;
  height: clamp(400px, 55vw, 680px);
  width: 100%; overflow: hidden; margin-top: 0;
}
.hero-slider { position: absolute; inset: 0; width: 100%; height: 100%; z-index: 0; }
.hero-slider .slide {
  position: absolute; width: 100%; height: 100%;
  object-fit: cover; object-position: center;
  opacity: 0; transition: opacity .8s ease;
}
.hero-slider .slide.active { opacity: 1; }
.cars-hero-overlay {
  position: absolute; inset: 0; z-index: 1;
  background: linear-gradient(to right, rgba(0,0,0,.08) 0%, rgba(0,0,0,0) 50%, rgba(0,0,0,.08) 100%);
}
.slider-btn {
  position: absolute; top: 50%; transform: translateY(-50%); z-index: 5;
  background: rgba(0,0,0,.30); border: 1.5px solid rgba(255,255,255,.4);
  color: #fff; font-size: 32px; width: 48px; height: 48px;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; border-radius: 50%; padding: 0;
  transition: background .2s, border-color .2s;
}
.slider-btn:hover { background: rgba(255,255,255,.20); border-color: rgba(255,255,255,.8); }
.slider-btn.prev { left: 28px; }
.slider-btn.next { right: 28px; }
.slider-counter {
  position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);
  z-index: 5; font-family: 'Rajdhani', sans-serif; font-size: 13px;
  font-weight: 700; color: rgba(255,255,255,.7); letter-spacing: 2px;
}

/* ── RESPONSIVE ── */
@media (max-width: 1100px) {
  .featured-grid { grid-template-columns: repeat(2,1fr); }
  .cars-grid { grid-template-columns: repeat(3,1fr); }
}
@media (max-width: 800px) {
  .cars-grid { grid-template-columns: repeat(2,1fr); }
  .cars-header, .cars-wrap { padding-left: 24px; padding-right: 24px; }
  .feat-modal { grid-template-columns: 1fr; grid-template-rows: 260px 1fr; }
}
@media (max-width: 600px) {
  .featured-grid { grid-template-columns: repeat(2,1fr); gap: 1px; }
}
@media (max-width: 480px) {
  .cars-grid { grid-template-columns: repeat(2,1fr); gap: 28px 12px; }
  .cars-header-top { flex-direction: column; align-items: flex-start; }
}
</style>
@endpush

@section('content')

{{-- HERO SLIDER --}}
<section class="cars-hero">
  <div class="hero-slider">
    <img src="{{ asset('images/car/Banner9.jpeg') }}" class="slide active" alt="Banner 1">
    <img src="{{ asset('images/car/Banner6.png') }}"  class="slide" alt="Banner 2">
    <img src="{{ asset('images/car/Banner7.png') }}"  class="slide" alt="Banner 3">
    <img src="{{ asset('images/car/Banner5.png') }}"  class="slide" alt="Banner 4">
  </div>
  <div class="cars-hero-overlay"></div>
  <button class="slider-btn prev" aria-label="Trước">&#8249;</button>
  <button class="slider-btn next" aria-label="Tiếp">&#8250;</button>
  <div class="slider-counter" id="slider-counter">1 / 4</div>
</section>

{{-- MODAL --}}
<div class="feat-modal-backdrop" id="featModal">
  <div class="feat-modal">
    <button class="feat-modal-close" id="featModalClose">&#215;</button>

    <div class="feat-modal-viewer" id="featModalViewer">
      <img id="featModalImg" src="" alt="" draggable="false" style="cursor:ew-resize;">
      <div class="feat-modal-progress">
        <div class="feat-modal-progress-bar" id="featModalBar"></div>
      </div>
      <div class="feat-modal-drag-tip">← Kéo để xoay 360° →</div>
    </div>

    <div class="feat-modal-info">
      <div class="feat-modal-badge" id="featModalBadge"></div>
      <div class="feat-modal-name"  id="featModalName"></div>
      <div class="feat-modal-price" id="featModalPrice"></div>
      <div class="feat-modal-specs" id="featModalSpecs"></div>
      <div class="feat-modal-actions">
        <a href="#" class="feat-modal-btn-main" id="featModalBtnMain">Xem chi tiết đầy đủ →</a>
        <button class="feat-modal-btn-sec" id="featModalBtnClose">Đóng</button>
      </div>
    </div>
  </div>
</div>

{{-- HEADER + BRAND TABS --}}
<div class="cars-header">
  <div class="cars-header-top">
    <div class="cars-title">Danh Sách Xe</div>
    <div class="cars-header-actions">
      <a href="{{ route('cars.price-list') }}" class="btn-action">Bảng giá sản phẩm →</a>
      <a href="{{ route('cars.compare') }}"    class="btn-action">So sánh sản phẩm →</a>
    </div>
  </div>
  <div class="brand-tabs">
    <a href="{{ route('cars.index', request()->except('brand','page','tab')) }}"
       class="brand-tab {{ !request('brand') && request('tab') !== 'featured' ? 'active' : '' }}">Tất cả</a>

    <button class="brand-tab {{ request('tab') === 'featured' ? 'active' : '' }}"
            id="tabFeatured" type="button">Xe Nổi Bật</button>

    @foreach($brands as $brand)
      <a href="{{ route('cars.index', array_merge(request()->except('brand','page','tab'), ['brand' => $brand])) }}"
         class="brand-tab {{ request('brand') == $brand ? 'active' : '' }}">{{ $brand }}</a>
    @endforeach
  </div>
</div>

{{-- CARS WRAP --}}
<div class="cars-wrap">

  {{-- XE NỔI BẬT --}}
  <div id="panelFeatured" style="display:none;">
    <div class="featured-block">
      <div class="featured-block-header">
        <div>
          <div class="featured-subtitle">Bộ sưu tập đặc biệt</div>
          <h2 class="featured-title">Xe <span>Nổi Bật</span></h2>
        </div>
      </div>

      <div class="featured-grid">
        @php
          $featuredCars = \App\Models\Car::where('is_featured', true)->with(['specs','galleries','colors'])->get();
        @endphp

        @forelse($featuredCars as $fCar)
          @php
            $slug   = \Illuminate\Support\Str::slug($fCar->name);
            $prefix = rtrim(asset('images/quay360/' . $slug), '/') . '/';
            $fUrl   = route('cars.show', $fCar->id);
            $fPrice = number_format($fCar->price_per_day ?? $fCar->price ?? 0);

            // Lấy specs
            $fSpecs = [];
            if ($fCar->relationLoaded('specs') && $fCar->specs->count()) {
                foreach ($fCar->specs->take(5) as $spec) {
                    $fSpecs[$spec->label ?? $spec->name ?? 'Thông số'] = $spec->value ?? '';
                }
            } else {
                if ($fCar->engine)    $fSpecs['Động cơ']   = $fCar->engine;
                if ($fCar->seats)     $fSpecs['Chỗ ngồi']  = $fCar->seats . ' chỗ';
                if ($fCar->fuel_type) $fSpecs['Nhiên liệu'] = $fCar->fuel_type;
                if ($fCar->mileage)   $fSpecs['Số km']      = number_format($fCar->mileage) . ' km';
                if ($fCar->color)     $fSpecs['Màu sắc']    = $fCar->color;
            }

            $fFirst = $prefix . '1.png';
          @endphp

          <div class="feat-card"
               data-prefix="{{ $prefix }}"
               data-frames="{{ $fCar->image_360_frames ?? 8 }}"
               data-name="{{ $fCar->name }}"
               data-badge="{{ $fCar->badge_label ?? '' }}"
               data-price="{{ $fPrice }}"
               data-specs="{{ json_encode($fSpecs) }}"
               data-show-url="{{ $fUrl }}">

            @if($fCar->badge_label)
              <span class="feat-badge">{{ $fCar->badge_label }}</span>
            @endif

            <div class="feat-canvas-wrap">
              <img class="feat-frame" src="{{ $fFirst }}" alt="{{ $fCar->name }}" draggable="false">
            </div>

            <div class="feat-drag-hint">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M5 12h14M12 5l7 7-7 7"/>
              </svg>
              Kéo để xoay
            </div>

            <div class="feat-progress"><div class="feat-progress-bar"></div></div>

            <div class="feat-info">
              <div class="feat-car-name">{{ $fCar->name }}</div>
              <div class="feat-car-price">Giá từ <strong>{{ $fPrice }}</strong> VNĐ</div>
              <button class="feat-btn">Xem thông tin →</button>
            </div>
          </div>

        @empty
          <p style="color:#888;padding:20px;grid-column:1/-1;">Chưa có xe nổi bật nào.</p>
        @endforelse
      </div>
    </div>
  </div>

  {{-- CARS GRID --}}
  <div id="panelCars">
    <div class="cars-grid">
      @forelse($cars as $car)
        @php
          $imgSrc = null;
          $raw = trim($car->image_url ?? $car->image ?? '');
          if ($raw !== '') {
              $imgSrc = preg_match('#^https?://#i', $raw) ? $raw : asset(ltrim($raw, '/'));
          }
          if (!$imgSrc && $car->relationLoaded('colors')) {
              $dc  = $car->colors->firstWhere('is_default', true) ?? $car->colors->first();
              $raw = trim($dc?->image ?? '');
              if ($raw !== '') {
                  $imgSrc = preg_match('#^https?://#i', $raw) ? $raw : asset(ltrim($raw, '/'));
              }
          }
          if (!$imgSrc && $car->relationLoaded('galleries')) {
              $gal = $car->galleries->where('type', 'image')->sortBy('sort_order')->first();
              $raw = trim($gal?->file_path ?? '');
              if ($raw !== '') {
                  $imgSrc = preg_match('#^https?://#i', $raw) ? $raw : asset(ltrim($raw, '/'));
              }
          }

          $isUnavailable = in_array($car->status, ['out_of_stock', 'coming_soon']);
          $statusBadgeMap = [
            'out_of_stock' => ['class' => 'out-of-stock', 'label' => 'Hết hàng'],
            'coming_soon'  => ['class' => 'coming-soon',  'label' => 'Sắp ra mắt'],
          ];
          $statusBadge = $statusBadgeMap[$car->status] ?? null;
        @endphp
        <a href="{{ route('cars.show', $car->id) }}"
           class="car-item {{ $isUnavailable ? 'car-unavailable' : '' }}">
          <div class="car-item-info">
            <div class="car-item-name">{{ $car->name }}</div>
            <div class="car-item-price-line">
              Giá từ <strong>{{ number_format($car->price_per_day ?? $car->price) }}</strong>
              <small> VNĐ</small>
            </div>
            @if($statusBadge)
              <div class="car-item-status {{ $statusBadge['class'] }}">
                {{ $statusBadge['label'] }}
              </div>
            @endif
          </div>
          <div class="car-item-img-wrap">
            @if($imgSrc)
              <img class="car-item-img" src="{{ $imgSrc }}" alt="{{ $car->name }}" loading="lazy"
                   onerror="this.style.display='none';">
              <div class="car-item-img-placeholder" style="display:none;"></div>
            @else
              <div class="car-item-img-placeholder" style="display:none;"></div>
            @endif
          </div>
        </a>
      @empty
        <div class="empty-state">
          <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#ddd" stroke-width="1">
            <rect x="1" y="3" width="15" height="13"/>
            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/>
            <circle cx="5.5" cy="18.5" r="2.5"/>
            <circle cx="18.5" cy="18.5" r="2.5"/>
          </svg>
          <p>Không tìm thấy xe</p>
        </div>
      @endforelse
    </div>

    @if($cars->hasPages())
    <div class="pagi">
      @if($cars->onFirstPage())
        <span aria-disabled>← Trước</span>
      @else
        <a href="{{ $cars->previousPageUrl() }}">← Trước</a>
      @endif
      @foreach($cars->getUrlRange(1, $cars->lastPage()) as $page => $url)
        @if($page == $cars->currentPage())
          <span class="current">{{ $page }}</span>
        @else
          <a href="{{ $url }}">{{ $page }}</a>
        @endif
      @endforeach
      @if($cars->hasMorePages())
        <a href="{{ $cars->nextPageUrl() }}">Tiếp →</a>
      @else
        <span aria-disabled>Tiếp →</span>
      @endif
    </div>
    @endif
  </div>{{-- /panelCars --}}

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

  /* ── TAB: XE NỔI BẬT vs CARS GRID ── */
  var tabFeatured   = document.getElementById('tabFeatured');
  var panelFeatured = document.getElementById('panelFeatured');
  var panelCars     = document.getElementById('panelCars');
  var allTabs       = document.querySelectorAll('.brand-tab');
  var featInited    = false;

  function showFeatured() {
    panelCars.style.display     = 'none';
    panelFeatured.style.display = 'block';
    allTabs.forEach(function(t){ t.classList.remove('active'); });
    tabFeatured.classList.add('active');
    if (!featInited) {
      document.querySelectorAll('#panelFeatured .feat-card').forEach(initCard);
      featInited = true;
    }
  }

  function showCars() {
    panelFeatured.style.display = 'none';
    panelCars.style.display     = 'block';
  }

  if (tabFeatured) tabFeatured.addEventListener('click', showFeatured);
  allTabs.forEach(function(t) {
    if (t !== tabFeatured && t.tagName === 'A') t.addEventListener('click', showCars);
  });

  /* ── HERO SLIDER ── */
  var slides  = document.querySelectorAll('.hero-slider .slide');
  var prevBtn = document.querySelector('.slider-btn.prev');
  var nextBtn = document.querySelector('.slider-btn.next');
  var counter = document.getElementById('slider-counter');
  var total   = slides.length;
  if (total) {
    var cur = 0, timer;
    function goTo(i) {
      slides[cur].classList.remove('active');
      cur = (i + total) % total;
      slides[cur].classList.add('active');
      if (counter) counter.textContent = (cur + 1) + ' / ' + total;
    }
    function startAuto() { timer = setInterval(function(){ goTo(cur+1); }, 4000); }
    function resetAuto()  { clearInterval(timer); startAuto(); }
    if (prevBtn) prevBtn.addEventListener('click', function(){ goTo(cur-1); resetAuto(); });
    if (nextBtn) nextBtn.addEventListener('click', function(){ goTo(cur+1); resetAuto(); });
    goTo(0); startAuto();
  }

  /* ── 360 spin ── */
  function initCard(card) {
    var img    = card.querySelector('.feat-frame');
    var bar    = card.querySelector('.feat-progress-bar');
    var prefix = card.dataset.prefix.replace(/\/?$/, '/');
    var total  = parseInt(card.dataset.frames) || 8;
    var cur = 0, isDrag = false, startX = 0, lastX = 0, vel = 0, raf = null;
    var sensitivity = 20;

    var frames = [];
    for (var i = 0; i < total; i++) {
      var f = new Image();
      f.src = prefix + (i + 1) + '.png';
      frames.push(f);
    }

    // Lưu frames vào card để modal dùng lại
    card._frames = frames;

    function show(idx) {
      idx = ((idx % total) + total) % total;
      cur = idx;
      img.src = frames[idx].src;
      if (bar) bar.style.width = ((idx / (total - 1)) * 100) + '%';
    }

    var autoT = null;
    card.addEventListener('mouseenter', function () {
      if (autoT) return;
      autoT = setInterval(function () { if (!isDrag) show(cur + 1); }, 280);
    });
    card.addEventListener('mouseleave', function () {
      clearInterval(autoT); autoT = null; vel = 0;
    });

    function onMove(x) {
      var dx = x - lastX; lastX = x; vel = dx;
      var steps = Math.round(dx / sensitivity);
      if (steps) show(cur + steps);
    }

    card.addEventListener('mousedown', function (e) {
      isDrag = true; startX = lastX = e.clientX;
      card.classList.add('dragging');
      clearInterval(autoT); autoT = null;
      e.preventDefault();
    });
    document.addEventListener('mousemove', function (e) { if (isDrag) onMove(e.clientX); });
    document.addEventListener('mouseup', function () {
      if (!isDrag) return;
      isDrag = false; card.classList.remove('dragging');
      cancelAnimationFrame(raf);
      (function inertia() {
        if (Math.abs(vel) < 0.3) return;
        show(cur + Math.round(vel / sensitivity));
        vel *= 0.85; raf = requestAnimationFrame(inertia);
      })();
    });
    card.addEventListener('touchstart', function (e) {
      isDrag = true; startX = lastX = e.touches[0].clientX;
      clearInterval(autoT); autoT = null;
    }, { passive: true });
    card.addEventListener('touchmove', function (e) {
      if (isDrag) { onMove(e.touches[0].clientX); e.preventDefault(); }
    }, { passive: false });
    card.addEventListener('touchend', function () { isDrag = false; });

    card.addEventListener('click', function (e) {
      if (Math.abs(e.clientX - startX) > 6) return;
      openModal(card, cur);
    });

    card._getFrame = function () { return cur; };
  }

  document.querySelectorAll('.feat-card').forEach(initCard);

  /* ── MODAL ── */
  var backdrop   = document.getElementById('featModal');
  var modalImg   = document.getElementById('featModalImg');
  var modalBar   = document.getElementById('featModalBar');
  var modalBadge = document.getElementById('featModalBadge');
  var modalName  = document.getElementById('featModalName');
  var modalPrice = document.getElementById('featModalPrice');
  var modalSpecs = document.getElementById('featModalSpecs');
  var modalBtn   = document.getElementById('featModalBtnMain');

  var mFolder, mTotal, mCur = 0, mFrames = [];
  var mIsDrag = false, mLastX = 0, mVel = 0, mRaf = null;
  var mSensitivity = 8;

  var mAutoSpin = null; // không dùng auto-spin, chỉ xoay khi kéo

  function mShow(idx) {
    idx = ((idx % mTotal) + mTotal) % mTotal;
    mCur = idx;
    modalImg.src = mFrames[idx].src;
    if (modalBar) modalBar.style.width = ((idx / (mTotal - 1)) * 100) + '%';
  }

  function openModal(card, startFrame) {
    mFolder = card.dataset.prefix.replace(/\/?$/, '/');
    mTotal  = parseInt(card.dataset.frames) || 8;
    mCur    = startFrame || 0;

    // Dùng lại frames đã preload từ card, không load lại
    mFrames = (card._frames && card._frames.length) ? card._frames : [];
    if (!mFrames.length) {
      for (var i = 0; i < mTotal; i++) {
        var f = new Image(); f.src = mFolder + (i + 1) + '.png'; mFrames.push(f);
      }
    }

    mShow(mCur);

    modalBadge.textContent = card.dataset.badge;
    modalName.textContent  = card.dataset.name;
    modalPrice.innerHTML   = 'Giá từ <strong>' + card.dataset.price + '</strong> VNĐ';
    modalBtn.href          = card.dataset.showUrl;

    var specs = {};
    try { specs = JSON.parse(card.dataset.specs); } catch(e) {}
    var html = '';
    Object.keys(specs).forEach(function (k) {
      html += '<div class="feat-modal-spec-row">'
            + '<span class="feat-modal-spec-label">' + k + '</span>'
            + '<span class="feat-modal-spec-val">'   + specs[k] + '</span>'
            + '</div>';
    });
    modalSpecs.innerHTML = html;

    backdrop.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    backdrop.classList.remove('open');
    document.body.style.overflow = '';
    cancelAnimationFrame(mRaf); mVel = 0;
  }

  document.getElementById('featModalClose').addEventListener('click', closeModal);
  document.getElementById('featModalBtnClose').addEventListener('click', closeModal);
  backdrop.addEventListener('click', function (e) { if (e.target === backdrop) closeModal(); });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeModal(); });

  modalImg.addEventListener('mousedown', function (e) {
    mIsDrag = true; mLastX = e.clientX;
    e.preventDefault();
  });
  document.addEventListener('mousemove', function (e) {
    if (!mIsDrag) return;
    var dx = e.clientX - mLastX; mLastX = e.clientX; mVel = dx;
    var steps = Math.round(dx / mSensitivity);
    if (steps) mShow(mCur + steps);
  });
  document.addEventListener('mouseup', function () {
    if (!mIsDrag) return;
    mIsDrag = false;
    cancelAnimationFrame(mRaf);
    (function inertia() {
      if (Math.abs(mVel) < 0.3) return;
      mShow(mCur + Math.round(mVel / mSensitivity));
      mVel *= 0.85; mRaf = requestAnimationFrame(inertia);
    })();
  });

  modalImg.addEventListener('touchstart', function (e) {
    mIsDrag = true; mLastX = e.touches[0].clientX;
  }, { passive: true });
  modalImg.addEventListener('touchmove', function (e) {
    if (!mIsDrag) return;
    var dx = e.touches[0].clientX - mLastX; mLastX = e.touches[0].clientX; mVel = dx;
    var steps = Math.round(dx / mSensitivity);
    if (steps) mShow(mCur + steps);
    e.preventDefault();
  }, { passive: false });
  modalImg.addEventListener('touchend', function () { mIsDrag = false; });

});
</script>
@endpush