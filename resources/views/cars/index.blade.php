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
   CARS WRAP
══════════════════════════════════════════ */
.cars-wrap { padding: 44px 60px 60px; max-width: 1400px; margin: 0 auto; background: #fff; }

/* ══════════════════════════════════════════
   GRID XE
══════════════════════════════════════════ */
.brand-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 40px 36px;
}
#panelVinfast .brand-grid {
  grid-template-columns: repeat(3, 1fr);
}

.brand-card {
  display: block;
  text-decoration: none;
  cursor: pointer;
  background: transparent;
}

/* INFO PHÍA TRÊN */
.brand-card-info { padding: 0 0 12px; }
.brand-card-name {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 20px; font-weight: 900;
  color: var(--red); text-transform: uppercase;
  letter-spacing: -.2px; margin-bottom: 4px; line-height: 1.1;
}
.brand-card-price {
  font-family: 'Barlow', sans-serif; font-size: 15px; color: var(--dark);
}
.brand-card-price strong { font-weight: 800; }
.brand-card-price small  { font-size: 11px; color: var(--muted); font-weight: 400; }

/* ẢNH PHÍA DƯỚI */
.brand-card-img-wrap {
  background: transparent;
  overflow: hidden;
  position: relative;
}
.brand-card-img {
  width: 100%; height: 200px;
  object-fit: contain; display: block;
  transition: transform .4s ease;
  padding: 12px 8px;
}
.brand-card:hover .brand-card-img {
  transform: scale(1.05) translateX(6px);
}

/* Unavailable */
.brand-card.car-unavailable .brand-card-img { opacity: .45; }
.car-item-status {
  display: inline-block; margin-top: 5px;
  font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700;
  letter-spacing: 2px; text-transform: uppercase; padding: 2px 8px;
}
.car-item-status.out-of-stock { color: #e53e3e; border: 1px solid #e53e3e; }
.car-item-status.coming-soon  { color: #d69e2e; border: 1px solid #d69e2e; }

/* ── EMPTY STATE ── */
.empty-state { grid-column: 1/-1; text-align: center; padding: 80px 20px; color: #ccc; }
.empty-state p {
  font-family: 'Barlow Condensed', sans-serif; font-size: 24px;
  font-weight: 700; text-transform: uppercase; margin-top: 16px;
}

/* ── RESPONSIVE ── */
@media (max-width: 1100px) {
  .brand-grid,
  #panelVinfast .brand-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 800px) {
  .brand-grid,
  #panelVinfast .brand-grid { grid-template-columns: repeat(2, 1fr); }
  .cars-header, .cars-wrap { padding-left: 24px; padding-right: 24px; }
}
@media (max-width: 480px) {
  .brand-grid,
  #panelVinfast .brand-grid { grid-template-columns: repeat(2, 1fr); gap: 24px 12px; }
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
    <button class="brand-tab active" id="tabMercedes" type="button">Mercedes</button>
    <button class="brand-tab"        id="tabVinfast"  type="button">VinFast</button>
  </div>
</div>

{{-- CARS WRAP --}}
<div class="cars-wrap">

  {{-- ══════════════ PANEL MERCEDES ══════════════ --}}
  <div id="panelMercedes">
    <div class="brand-grid">
      @php
        $mercedesCars = \App\Models\Car::whereHas('brand', fn($q) => $q->where('name', 'Mercedes'))
          ->with(['galleries', 'colors'])
          ->get();
      @endphp

      @forelse($mercedesCars as $car)
        @php
          $imgSrc = null;
          $raw = trim($car->image_url ?? $car->image ?? '');
          if ($raw !== '') {
              $imgSrc = preg_match('#^https?://#i', $raw) ? $raw : asset(ltrim($raw, '/'));
          }
          if (!$imgSrc && $car->relationLoaded('colors')) {
              $dc  = $car->colors->firstWhere('is_default', true) ?? $car->colors->first();
              $raw = trim($dc?->image ?? '');
              if ($raw !== '') $imgSrc = preg_match('#^https?://#i', $raw) ? $raw : asset(ltrim($raw, '/'));
          }
          if (!$imgSrc && $car->relationLoaded('galleries')) {
              $gal = $car->galleries->where('type', 'image')->sortBy('sort_order')->first();
              $raw = trim($gal?->file_path ?? '');
              if ($raw !== '') $imgSrc = preg_match('#^https?://#i', $raw) ? $raw : asset(ltrim($raw, '/'));
          }
          $isUnavailable = in_array($car->status, ['out_of_stock', 'coming_soon']);
          $statusBadgeMap = [
            'out_of_stock' => ['class' => 'out-of-stock', 'label' => 'Hết hàng'],
            'coming_soon'  => ['class' => 'coming-soon',  'label' => 'Sắp ra mắt'],
          ];
          $statusBadge = $statusBadgeMap[$car->status] ?? null;
        @endphp

        <a href="{{ route('cars.show', $car->id) }}"
           class="brand-card {{ $isUnavailable ? 'car-unavailable' : '' }}">
          <div class="brand-card-info">
            <div class="brand-card-name">{{ $car->name }}</div>
            <div class="brand-card-price">
              Giá từ <strong>{{ number_format($car->price_per_day ?? $car->price) }}</strong>
              <small> VNĐ</small>
            </div>
            @if($statusBadge)
              <div class="car-item-status {{ $statusBadge['class'] }}">{{ $statusBadge['label'] }}</div>
            @endif
          </div>
          <div class="brand-card-img-wrap">
            @if($imgSrc)
              <img class="brand-card-img" src="{{ $imgSrc }}" alt="{{ $car->name }}" loading="lazy"
                   onerror="this.style.display='none';">
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
          <p>Chưa có xe Mercedes</p>
        </div>
      @endforelse
    </div>
  </div>{{-- /panelMercedes --}}


  {{-- ══════════════ PANEL VINFAST ══════════════ --}}
  <div id="panelVinfast" style="display:none;">
    <div class="brand-grid">
      @php
        $vinfastCars = \App\Models\Car::whereHas('brand', fn($q) => $q->where('name', 'VinFast'))
  ->with(['galleries', 'colors'])
  ->get();
      @endphp

      @forelse($vinfastCars as $car)
        @php
          $imgSrc = null;
          $raw = trim($car->image_url ?? $car->image ?? '');
          if ($raw !== '') {
              $imgSrc = preg_match('#^https?://#i', $raw) ? $raw : asset(ltrim($raw, '/'));
          }
          if (!$imgSrc && $car->relationLoaded('colors')) {
              $dc  = $car->colors->firstWhere('is_default', true) ?? $car->colors->first();
              $raw = trim($dc?->image ?? '');
              if ($raw !== '') $imgSrc = preg_match('#^https?://#i', $raw) ? $raw : asset(ltrim($raw, '/'));
          }
          if (!$imgSrc && $car->relationLoaded('galleries')) {
              $gal = $car->galleries->where('type', 'image')->sortBy('sort_order')->first();
              $raw = trim($gal?->file_path ?? '');
              if ($raw !== '') $imgSrc = preg_match('#^https?://#i', $raw) ? $raw : asset(ltrim($raw, '/'));
          }
          $fPrice = number_format($car->price_per_day ?? $car->price ?? 0);
          $isUnavailable = in_array($car->status, ['out_of_stock', 'coming_soon']);
          $statusBadgeMap = [
            'out_of_stock' => ['class' => 'out-of-stock', 'label' => 'Hết hàng'],
            'coming_soon'  => ['class' => 'coming-soon',  'label' => 'Sắp ra mắt'],
          ];
          $statusBadge = $statusBadgeMap[$car->status] ?? null;
        @endphp

        <a href="{{ route('cars.show', $car->id) }}"
           class="brand-card {{ $isUnavailable ? 'car-unavailable' : '' }}">
          <div class="brand-card-info">
            <div class="brand-card-name">{{ $car->name }}</div>
            <div class="brand-card-price">
              Giá từ <strong>{{ $fPrice }}</strong>
              <small> VNĐ</small>
            </div>
            @if($statusBadge)
              <div class="car-item-status {{ $statusBadge['class'] }}">{{ $statusBadge['label'] }}</div>
            @endif
          </div>
          <div class="brand-card-img-wrap">
            @if($imgSrc)
              <img class="brand-card-img" src="{{ $imgSrc }}" alt="{{ $car->name }}" loading="lazy"
                   onerror="this.style.display='none';">
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
          <p>Chưa có xe VinFast</p>
        </div>
      @endforelse
    </div>
  </div>{{-- /panelVinfast --}}

</div>{{-- /cars-wrap --}}

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

  /* ══════════════════════════════════════
     TAB SWITCHING: Mercedes ↔ VinFast
  ══════════════════════════════════════ */
  var tabMer   = document.getElementById('tabMercedes');
  var tabVf    = document.getElementById('tabVinfast');
  var panelMer = document.getElementById('panelMercedes');
  var panelVf  = document.getElementById('panelVinfast');

  function showMercedes() {
    panelMer.style.display = 'block';
    panelVf.style.display  = 'none';
    tabMer.classList.add('active');
    tabVf.classList.remove('active');
  }

  function showVinfast() {
    panelMer.style.display = 'none';
    panelVf.style.display  = 'block';
    tabMer.classList.remove('active');
    tabVf.classList.add('active');
  }

  tabMer.addEventListener('click', showMercedes);
  tabVf.addEventListener('click', showVinfast);

  /* ══════════════════════════════════════
     HERO SLIDER
  ══════════════════════════════════════ */
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
    function startAuto() { timer = setInterval(function(){ goTo(cur + 1); }, 4000); }
    function resetAuto()  { clearInterval(timer); startAuto(); }
    if (prevBtn) prevBtn.addEventListener('click', function(){ goTo(cur - 1); resetAuto(); });
    if (nextBtn) nextBtn.addEventListener('click', function(){ goTo(cur + 1); resetAuto(); });
    goTo(0); startAuto();
  }

});
</script>
@endpush