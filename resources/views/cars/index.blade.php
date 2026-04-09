@extends('layouts.frontend')

@section('title', 'Bộ sưu tập xe - AUTO X')

@push('styles')
<style>
/* ── VARIABLES (theo theme ivory của custom-override.css) ── */
:root {
  --cars-red:    #d42b2b;
  --cars-muted:  #6B6056;
  --cars-border: #DDD0B5;
  --cars-ivory:  #FAF6EF;
  --cars-dark:   #1C1C1C;
}

/* ── HEADER ── */
.cars-header {
  background: #FAF6EF;
  border-bottom: 1px solid #DDD0B5;
  padding: 28px 60px 0;
}
.cars-header-top {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  margin-bottom: 20px;
  flex-wrap: wrap;
  gap: 12px;
}
.cars-title {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: clamp(22px, 3vw, 36px);
  font-weight: 900;
  color: #1C1C1C;
  text-transform: uppercase;
  letter-spacing: -.5px;
}
.cars-header-actions { display: flex; gap: 10px; }
.btn-action {
  font-family: 'Rajdhani', sans-serif;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
  border: 1.5px solid var(--cars-red);
  color: var(--cars-red) !important;
  background: transparent !important;
  box-shadow: none !important;
  padding: 9px 20px;
  text-decoration: none !important;
  transition: background .2s, color .2s;
  white-space: nowrap;
  border-radius: 0 !important;
}
.btn-action:hover {
  background: var(--cars-red) !important;
  color: #fff !important;
}

/* ── BRAND TABS ── */
.brand-tabs {
  display: flex;
  gap: 0;
  overflow-x: auto;
  scrollbar-width: none;
}
.brand-tabs::-webkit-scrollbar { display: none; }
.brand-tab {
  font-family: 'Rajdhani', sans-serif;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--cars-muted) !important;
  padding: 14px 20px;
  text-decoration: none !important;
  white-space: nowrap;
  border-bottom: 2px solid transparent;
  border-top: none; border-left: none; border-right: none;
  background: none !important;
  box-shadow: none !important;
  cursor: pointer;
  transition: color .2s, border-color .2s;
  border-radius: 0 !important;
}
.brand-tab:hover { color: #1C1C1C !important; }
.brand-tab.active { color: var(--cars-red) !important; border-bottom-color: var(--cars-red); }

/* ── WRAP ── */
.cars-wrap {
  padding: 44px 60px 60px;
  max-width: 1400px;
  margin: 0 auto;
  background: transparent;
}

/* ── GRID ── */
.cars-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 48px 32px;
}

/* ══════════════════════════════════════════════════════
   CAR ITEM — override hoàn toàn custom-override.css
   Dùng selector mạnh hơn để thắng !important của theme
══════════════════════════════════════════════════════ */
html body .cars-grid a.car-item,
html body .cars-grid a.car-item:link,
html body .cars-grid a.car-item:visited,
html body .cars-grid a.car-item:hover,
html body .cars-grid a.car-item:focus,
html body .cars-grid a.car-item:active {
  display: block !important;
  text-decoration: none !important;
  background: transparent !important;
  background-color: transparent !important;
  background-image: none !important;
  border: none !important;
  border-radius: 0 !important;
  box-shadow: none !important;
  outline: none !important;
  padding: 0 !important;
  margin: 0 !important;
  transform: none !important;
  cursor: pointer;
  overflow: visible !important;
  position: static !important;
}

/* Tên xe */
html body .cars-grid a.car-item .car-item-name {
  font-family: 'Barlow Condensed', sans-serif !important;
  font-size: 22px !important;
  font-weight: 900 !important;
  color: var(--cars-red) !important;
  text-transform: uppercase !important;
  letter-spacing: -.2px !important;
  margin-bottom: 4px !important;
  line-height: 1.1 !important;
  background: transparent !important;
  border: none !important;
  box-shadow: none !important;
  padding: 0 !important;
}

/* Dòng giá */
html body .cars-grid a.car-item .car-item-price-line {
  font-family: 'Barlow', sans-serif !important;
  font-size: 13px !important;
  color: #6B6056 !important;
  margin-bottom: 12px !important;
  background: transparent !important;
  border: none !important;
  padding: 0 !important;
}
html body .cars-grid a.car-item .car-item-price-line strong {
  font-weight: 800 !important;
  color: #1C1C1C !important;
}
html body .cars-grid a.car-item .car-item-price-line small {
  font-size: 11px !important;
  color: #8a857e !important;
  font-weight: 400 !important;
}

/* Vùng ảnh — nền ivory để multiply hoạt động */
html body .cars-grid a.car-item .car-item-img-wrap {
  width: 100% !important;
  overflow: hidden !important;
  background: #FAF6EF !important;
  background-color: #FAF6EF !important;
  border: none !important;
  border-radius: 0 !important;
  box-shadow: none !important;
  padding: 0 !important;
  position: relative !important;
}

html body .cars-grid a.car-item .car-item-img {
  width: 100% !important;
  height: 175px !important;
  object-fit: contain !important;
  display: block !important;
  transition: transform .4s ease !important;
  mix-blend-mode: multiply !important;
  background: transparent !important;
  border: none !important;
  box-shadow: none !important;
  filter: none !important;
  border-radius: 0 !important;
}

html body .cars-grid a.car-item:hover .car-item-img {
  transform: scale(1.05) !important;
}

/* Scene images */
html body .cars-grid a.car-item .car-item-img.img-scene {
  object-fit: cover !important;
  object-position: center 60% !important;
  mix-blend-mode: normal !important;
}
html body .cars-grid a.car-item .car-item-img-wrap:has(.img-scene) {
  background: transparent !important;
}

/* Overlay từ custom-override — ẩn đi */
html body .cars-grid a.car-item .car-overlay-banner {
  display: none !important;
}

/* Placeholder khi ảnh lỗi */
html body .cars-grid a.car-item .car-item-img-placeholder {
  width: 100% !important;
  height: 175px !important;
  display: none;
  align-items: center !important;
  justify-content: center !important;
  color: #ccc !important;
  background: transparent !important;
  border: none !important;
  box-shadow: none !important;
}

/* ── EMPTY STATE ── */
.empty-state {
  grid-column: 1 / -1;
  text-align: center;
  padding: 80px 20px;
  color: #ccc;
}
.empty-state p {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 24px;
  font-weight: 700;
  text-transform: uppercase;
  margin-top: 16px;
  color: #ccc;
}

/* ── PAGINATION ── */
.pagi {
  display: flex;
  justify-content: center;
  gap: 4px;
  padding: 40px 0 0;
  flex-wrap: wrap;
}
.pagi a, .pagi span {
  font-family: 'Rajdhani', sans-serif;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  padding: 8px 14px;
  border: 1px solid #DDD0B5;
  text-decoration: none !important;
  color: #6B6056 !important;
  background: #FAF6EF !important;
  border-radius: 0 !important;
  box-shadow: none !important;
  transition: background .2s, color .2s, border-color .2s;
}
.pagi a:hover {
  background: var(--cars-red) !important;
  color: #fff !important;
  border-color: var(--cars-red) !important;
}
.pagi .current {
  background: var(--cars-red) !important;
  color: #fff !important;
  border-color: var(--cars-red) !important;
}
.pagi [aria-disabled] { opacity: .35; pointer-events: none; }

/* ── RESPONSIVE ── */
@media (max-width: 1100px) { .cars-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 800px) {
  .cars-grid { grid-template-columns: repeat(2, 1fr); }
  .cars-header, .cars-wrap { padding-left: 24px; padding-right: 24px; }
}
@media (max-width: 480px) {
  .cars-grid { grid-template-columns: repeat(2, 1fr); gap: 28px 12px; }
  .cars-header-top { flex-direction: column; align-items: flex-start; }
}
</style>
@endpush

@section('content')

<div class="cars-header">
  <div class="cars-header-top">
    <div class="cars-title">Danh Sách Xe</div>
    <div class="cars-header-actions">
      <a href="{{ route('cars.index', ['sort'=>'price_asc']) }}" class="btn-action">Bảng giá sản phẩm →</a>
      <a href="#" class="btn-action">So sánh sản phẩm →</a>
    </div>
  </div>
  <div class="brand-tabs">
    <a href="{{ route('cars.index', request()->except('brand', 'page')) }}"
       class="brand-tab {{ !request('brand') ? 'active' : '' }}">Tất cả</a>
    @foreach($brands as $brand)
      <a href="{{ route('cars.index', array_merge(request()->except('page'), ['brand' => $brand])) }}"
         class="brand-tab {{ request('brand') === $brand ? 'active' : '' }}">{{ $brand }}</a>
    @endforeach
  </div>
</div>

<div class="cars-wrap">
  <div class="cars-grid">
    @forelse($cars as $car)
      @php
        $rawUrl = trim($car->image_url ?? '');

        if ($rawUrl === '') {
            $imgSrc = asset('images/car/01.jpg');
        } elseif (preg_match('#^https?://#i', $rawUrl)) {
            $imgSrc = $rawUrl;
        } else {
            $clean = ltrim($rawUrl, '/');
            $parts = explode('/', $clean);
            $encoded = array_map(fn($s) => rawurlencode(rawurldecode($s)), $parts);
            $imgSrc = asset(implode('/', $encoded));
        }

        $isTN       = str_contains($rawUrl, 'images/car/') || str_contains($rawUrl, '-TN');
        $sceneClass = $isTN ? '' : 'img-scene';
      @endphp

      <a href="{{ route('cars.show', $car->id) }}" class="car-item">

        <div class="car-item-name">{{ $car->name }}</div>

        <div class="car-item-price-line">
          Giá từ <strong>{{ number_format($car->price_per_day ?? $car->price) }}</strong>
          <small> VNĐ</small>
        </div>

        <div class="car-item-img-wrap">
          <img
            class="car-item-img {{ $sceneClass }}"
            src="{{ $imgSrc }}"
            alt="{{ $car->name }}"
            loading="lazy"
            onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
          <div class="car-item-img-placeholder">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
              <rect x="1" y="3" width="15" height="13"/>
              <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/>
              <circle cx="5.5" cy="18.5" r="2.5"/>
              <circle cx="18.5" cy="18.5" r="2.5"/>
            </svg>
          </div>
        </div>

      </a>
    @empty
      <div class="empty-state">
        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1">
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
</div>

@endsection