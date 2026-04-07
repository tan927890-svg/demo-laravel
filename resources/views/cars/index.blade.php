@extends('layouts.frontend')

@section('title', 'Bộ sưu tập xe - AUTO X')

@push('styles')
<style>
:root {
  --red: #d42b2b;
  --dark: #1a1a1a;
  --muted: #888;
  --border: #e8e8e8;
}
*, *::before, *::after { box-sizing: border-box; }
body { background: #fff; color: var(--dark); }

/* ── HEADER ── */
.cars-header {
  background: #fff;
  border-bottom: 1px solid var(--border);
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
  color: var(--dark);
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
  border: 1.5px solid var(--red);
  color: var(--red);
  background: #fff;
  padding: 9px 20px;
  text-decoration: none;
  transition: background .2s, color .2s;
  white-space: nowrap;
}
.btn-action:hover { background: var(--red); color: #fff; }

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
  color: var(--muted);
  padding: 14px 20px;
  text-decoration: none;
  white-space: nowrap;
  border-bottom: 2px solid transparent;
  border-top: none;
  border-left: none;
  border-right: none;
  background: none;
  cursor: pointer;
  transition: color .2s, border-color .2s;
}
.brand-tab:hover { color: var(--dark); }
.brand-tab.active { color: var(--red); border-bottom-color: var(--red); }

/* ── GRID ── */
.cars-wrap {
  padding: 44px 60px 60px;
  max-width: 1400px;
  margin: 0 auto;
}
.cars-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 52px 36px;
}

/* ── CAR ITEM — Honda VN: không khung, tên+giá trên, ảnh dưới ── */
.car-item {
  text-decoration: none;
  display: block;
  cursor: pointer;
  /* KHÔNG border, KHÔNG background, KHÔNG box-shadow */
}

.car-item-info {
  padding: 0 0 10px 0;
   text-align: center;  
}
.car-item-name {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 22px;
  font-weight: 900;
  color: var(--red);
  text-transform: uppercase;
  letter-spacing: -.2px;
  margin-bottom: 3px;
}
.car-item-price-line {
  font-family: 'Barlow', sans-serif;
  font-size: 13px;
  color: var(--dark);
}
.car-item-price-line strong { font-weight: 800; }
.car-item-price-line small {
  font-size: 11px;
  color: var(--muted);
  font-weight: 400;
}

/* Vùng ảnh: nền xám nhẹ, KHÔNG có border hay border-radius */
.car-item-img-wrap {
  background: #f5f5f5;
  overflow: hidden;
  /* KHÔNG border, KHÔNG border-radius, KHÔNG box-shadow */
}
.car-item-img {
  width: 100%;
  height: 180px;
  object-fit: cover;   
  display: block;
  transition: transform .4s ease;
}
.car-item:hover .car-item-img {
  transform: scale(1.05) translateX(6px);
}
.car-item-img-placeholder {
  width: 100%;
  height: 180px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f5f5f5;
}

/* ── EMPTY ── */
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
  border: 1px solid var(--border);
  text-decoration: none;
  color: var(--muted);
  background: #fff;
  transition: background .2s, color .2s, border-color .2s;
}
.pagi a:hover { background: var(--red); color: #fff; border-color: var(--red); }
.pagi .current { background: var(--red); color: #fff; border-color: var(--red); }
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
    $imgSrc = $car->image_url
        ? asset(preg_replace_callback('/[^\x20-\x7E]| /', fn($m) => rawurlencode($m[0]), $car->image_url))
        : asset('images/car/01.jpg');
  @endphp
      <a href="{{ route('cars.show', $car->id) }}" class="car-item">

        {{-- Tên + giá TRÊN ảnh --}}
        <div class="car-item-info">
          <div class="car-item-name">{{ $car->name }}</div>
          <div class="car-item-price-line">
            Giá từ <strong>{{ number_format($car->price_per_day ?? $car->price) }}</strong>
            <small> VNĐ</small>
          </div>
        </div>

        {{-- Ảnh xe — nền xám nhẹ, không khung --}}
        <div class="car-item-img-wrap">
          <img class="car-item-img"
               src="{{ $imgSrc }}"
               alt="{{ $car->name }}"
               loading="lazy"
               onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
          <div class="car-item-img-placeholder" style="display:none;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1">
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
</div>

@endsection