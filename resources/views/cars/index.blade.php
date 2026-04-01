@extends('layouts.frontend')

@section('title', 'Danh Sách Xe — Concept Car Dealer')

@push('styles')
<style>
  /* HERO */
  .hero {
    margin-top: 70px; position: relative; height: 320px;
    background: linear-gradient(160deg, #1c1c1e 0%, #2a1616 50%, #1c1c1e 100%);
    display: flex; align-items: center; justify-content: center; overflow: hidden;
  }
  .hero::before {
    content: ''; position: absolute; inset: 0;
    background:
      repeating-linear-gradient(90deg, transparent, transparent 80px, rgba(212,43,43,.03) 80px, rgba(212,43,43,.03) 81px),
      repeating-linear-gradient(0deg,  transparent, transparent 80px, rgba(212,43,43,.03) 80px, rgba(212,43,43,.03) 81px);
  }
  .hero-glow {
    position: absolute; width: 600px; height: 300px;
    background: radial-gradient(ellipse, rgba(180,30,30,.22) 0%, transparent 70%);
    top: 50%; left: 50%; transform: translate(-50%, -50%);
  }
  .hero-content { position: relative; text-align: center; }
  .hero-eyebrow {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: 5px; text-transform: uppercase; color: var(--red);
    margin-bottom: 16px; display: flex; align-items: center; justify-content: center; gap: 14px;
  }
  .hero-eyebrow::before, .hero-eyebrow::after { content: ''; width: 32px; height: 1px; background: var(--red); opacity: .5; }
  .hero h1 {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(48px, 7vw, 82px); font-weight: 800;
    color: var(--white); line-height: .95; text-transform: uppercase; letter-spacing: -1px;
  }
  .hero h1 em { color: var(--red); font-style: normal; }
  .hero-sub { margin-top: 16px; font-size: 14px; color: var(--muted); }
  .breadcrumb {
    position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%);
    display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--subtle);
  }
  .breadcrumb a { color: var(--subtle); text-decoration: none; }
  .breadcrumb a:hover { color: var(--red); }
  .breadcrumb span { color: var(--red); }

  /* PAGE BODY */
  .page-body { max-width: 1400px; margin: 0 auto; padding: 56px 48px; display: grid; grid-template-columns: 260px 1fr; gap: 36px; align-items: start; }

  /* SIDEBAR */
  .sidebar { background: var(--card); border: 1px solid var(--border); position: sticky; top: 90px; overflow: hidden; }
  .sidebar-head {
    background: var(--bg3); padding: 18px 24px; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 10px;
  }
  .sidebar-head::before { content: ''; width: 3px; height: 16px; background: var(--red); flex-shrink: 0; }
  .sidebar-head span { font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--white); }
  .sidebar-body { padding: 24px; }
  .field { margin-bottom: 18px; }
  .field label { display: block; font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase; color: var(--muted); margin-bottom: 7px; }
  .field select, .field input {
    width: 100%; background: var(--bg); border: 1px solid var(--border);
    color: var(--text); padding: 10px 14px; font-family: 'Barlow', sans-serif;
    font-size: 13px; outline: none; transition: border-color .2s; appearance: none;
  }
  .field select:focus, .field input:focus { border-color: var(--red); }
  .field input::placeholder { color: var(--subtle); }
  .btn-search {
    width: 100%; background: var(--red); color: #fff; border: none;
    font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; padding: 13px;
    cursor: pointer; transition: background .2s; margin-top: 6px;
  }
  .btn-search:hover { background: var(--red-dark); }
  .btn-reset {
    display: block; width: 100%; text-align: center; margin-top: 10px;
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: 2px; text-transform: uppercase; color: var(--muted);
    text-decoration: none; padding: 8px; border: 1px solid var(--border);
    transition: border-color .2s, color .2s;
  }
  .btn-reset:hover { border-color: var(--border-light); color: var(--white); }

  /* RESULTS HEADER */
  .results-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
  .results-count { font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--muted); }
  .results-count b { color: var(--red); }

  /* CAR GRID */
  .cars-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px; background: var(--border); }

  .car-card { background: var(--card); overflow: hidden; position: relative; transition: background .25s; display: flex; flex-direction: column; }
  .car-card:hover { background: var(--bg3); }
  .car-card-top { position: absolute; top: 0; left: 0; right: 0; height: 2px; background: var(--red); transform: scaleX(0); transform-origin: left; transition: transform .3s ease; z-index: 1; }
  .car-card:hover .car-card-top { transform: scaleX(1); }

  .car-thumb { position: relative; overflow: hidden; }
  .car-thumb img { width: 100%; height: 190px; object-fit: cover; display: block; transition: transform .4s ease; }
  .car-card:hover .car-thumb img { transform: scale(1.04); }
  .car-thumb-placeholder { width: 100%; height: 190px; background: var(--bg3); display: flex; align-items: center; justify-content: center; }
  .car-thumb-placeholder svg { width: 40px; height: 40px; stroke: var(--subtle); fill: none; stroke-width: 1; }

  .car-status {
    position: absolute; top: 12px; left: 12px;
    font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase; padding: 4px 10px;
  }
  .status-available { background: var(--red); color: #fff; }
  .status-unavailable { background: var(--bg3); color: var(--muted); border: 1px solid var(--border); }

  .car-info { padding: 18px 20px 20px; flex: 1; display: flex; flex-direction: column; }
  .car-brand { font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--red); margin-bottom: 3px; }
  .car-name { font-family: 'Barlow Condensed', sans-serif; font-size: 19px; font-weight: 700; color: var(--white); text-transform: uppercase; letter-spacing: .3px; margin-bottom: 10px; line-height: 1.1; }

  .car-specs { display: flex; gap: 0; margin-bottom: 14px; background: var(--bg); border: 1px solid var(--border); }
  .spec-item { flex: 1; padding: 8px 6px; text-align: center; border-right: 1px solid var(--border); }
  .spec-item:last-child { border-right: none; }
  .spec-val { font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700; color: var(--white); display: block; }
  .spec-key { font-size: 10px; color: var(--subtle); letter-spacing: 1px; text-transform: uppercase; }

  .car-bottom { display: flex; align-items: center; justify-content: space-between; padding-top: 14px; border-top: 1px solid var(--border); margin-top: auto; }
  .car-price { line-height: 1.1; }
  .car-price-val { font-family: 'Barlow Condensed', sans-serif; font-size: 22px; font-weight: 800; color: var(--red); display: block; }
  .car-price-unit { font-size: 11px; color: var(--muted); }
  .btn-view {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase; color: var(--white);
    text-decoration: none; padding: 9px 18px; border: 1px solid var(--border);
    transition: background .2s, border-color .2s, color .2s; white-space: nowrap;
  }
  .btn-view:hover { background: var(--red); border-color: var(--red); color: #fff; }

  /* EMPTY */
  .empty-box { grid-column: 1/-1; background: var(--card); border: 1px solid var(--border); padding: 80px 40px; text-align: center; }
  .empty-box h3 { font-family: 'Barlow Condensed', sans-serif; font-size: 28px; font-weight: 800; color: var(--white); text-transform: uppercase; margin-bottom: 8px; }
  .empty-box p { color: var(--muted); font-size: 14px; }

  /* PAGINATION */
  .pag-wrap { margin-top: 32px; display: flex; justify-content: center; align-items: center; gap: 4px; }
  .pag-wrap nav { display: flex; gap: 4px; }
  .pag-wrap .page-link, .pag-wrap span {
    font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 600;
    letter-spacing: 1px; color: var(--muted); background: var(--card);
    border: 1px solid var(--border); padding: 8px 14px; text-decoration: none;
    transition: border-color .2s, color .2s, background .2s; display: inline-block;
  }
  .pag-wrap .page-link:hover { border-color: var(--red); color: var(--red); }
  .pag-wrap span[aria-current] { border-color: var(--red); color: var(--red); background: rgba(212,43,43,.08); }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="hero">
  <div class="hero-glow"></div>
  <div class="hero-content">
    <div class="hero-eyebrow">Bộ sưu tập</div>
    <h1>Danh Sách <em>Xe</em></h1>
    <p class="hero-sub">Khám phá những mẫu xe đẳng cấp dành cho bạn</p>
  </div>
  <div class="breadcrumb">
    <a href="{{ url('/') }}">Home</a> &rsaquo; <span>Cars</span>
  </div>
</section>

{{-- PAGE BODY --}}
<div class="page-body">

  {{-- SIDEBAR --}}
  <aside class="sidebar">
    <div class="sidebar-head"><span>Bộ lọc</span></div>
    <div class="sidebar-body">
      <form method="GET" action="{{ route('cars.index') }}">
        <div class="field">
          <label>Hãng xe</label>
          <select name="brand">
            <option value="">Tất cả hãng</option>
            @foreach($brands as $brand)
              <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
            @endforeach
          </select>
        </div>
        <div class="field">
          <label>Tìm theo tên</label>
          <input type="text" name="search" placeholder="Toyota, BMW, Camry..." value="{{ request('search') }}">
        </div>
        <div class="field">
          <label>Giá tối thiểu / ngày</label>
          <input type="number" name="min_price" placeholder="0 VNĐ" value="{{ request('min_price') }}">
        </div>
        <div class="field">
          <label>Giá tối đa / ngày</label>
          <input type="number" name="max_price" placeholder="Không giới hạn" value="{{ request('max_price') }}">
        </div>
        <button type="submit" class="btn-search">Tìm kiếm →</button>
        <a href="{{ route('cars.index') }}" class="btn-reset">Xóa bộ lọc</a>
      </form>
    </div>
  </aside>

  {{-- RESULTS --}}
  <div>
    <div class="results-header">
      <div class="results-count">Tìm thấy <b>{{ $cars->total() }}</b> xe</div>
    </div>

    <div class="cars-grid">
      @forelse($cars as $car)
      <div class="car-card">
        <div class="car-card-top"></div>
        <div class="car-thumb">
          @if($car->image)
            <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}">
          @else
            <div class="car-thumb-placeholder">
              <svg viewBox="0 0 24 24"><rect x="1" y="8" width="22" height="10" rx="2"/><path d="M5 8V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>
            </div>
          @endif
          @if(isset($car->status))
            <span class="car-status {{ $car->status === 'available' ? 'status-available' : 'status-unavailable' }}">
              {{ $car->status === 'available' ? 'Còn xe' : 'Hết xe' }}
            </span>
          @endif
        </div>
        <div class="car-info">
          <div class="car-brand">{{ $car->brand }}</div>
          <div class="car-name">{{ $car->name }}</div>
          <div class="car-specs">
            @if($car->year)
            <div class="spec-item">
              <span class="spec-val">{{ $car->year }}</span>
              <span class="spec-key">Năm</span>
            </div>
            @endif
            @if($car->transmission)
            <div class="spec-item">
              <span class="spec-val">{{ Str::limit($car->transmission, 4) }}</span>
              <span class="spec-key">Hộp số</span>
            </div>
            @endif
            @if($car->mileage)
            <div class="spec-item">
              <span class="spec-val">{{ number_format($car->mileage/1000, 0) }}K</span>
              <span class="spec-key">Km</span>
            </div>
            @endif
          </div>
          <div class="car-bottom">
            <div class="car-price">
              <span class="car-price-val">{{ number_format($car->price_per_day) }}</span>
              <span class="car-price-unit">VNĐ / ngày</span>
            </div>
            <a href="{{ route('cars.show', $car) }}" class="btn-view">Xem →</a>
          </div>
        </div>
      </div>
      @empty
      <div class="empty-box">
        <h3>Không tìm thấy xe</h3>
        <p>Thử thay đổi bộ lọc để xem thêm kết quả.</p>
      </div>
      @endforelse
    </div>

    @if($cars->hasPages())
    <div class="pag-wrap">
      {{ $cars->appends(request()->query())->links() }}
    </div>
    @endif
  </div>

</div>
@endsection