@extends('layouts.frontend')

@section('title', 'Danh Sách Xe - Concept Car Dealer')

@push('styles')
<style>
  /* ── HERO ───────────────────────────────────────────────── */
  .hero {
    margin-top:0; position:relative; height:360px;
    background: linear-gradient(160deg,#1c1c1e 0%,#2a1616 45%,#1c1c1e 100%);
    display:flex; align-items:center; justify-content:center; overflow:hidden;
  }
  .hero::before {
    content:''; position:absolute; inset:0;
    background:
      repeating-linear-gradient(90deg,transparent,transparent 80px,rgba(212,43,43,.025) 80px,rgba(212,43,43,.025) 81px),
      repeating-linear-gradient(0deg,transparent,transparent 80px,rgba(212,43,43,.025) 80px,rgba(212,43,43,.025) 81px);
  }
  .hero-glow {
    position:absolute; width:700px; height:350px;
    background:radial-gradient(ellipse,rgba(180,30,30,.22) 0%,transparent 68%);
    top:50%; left:50%; transform:translate(-50%,-50%);
    animation: pulse-glow 4s ease-in-out infinite;
  }
  @keyframes pulse-glow {
    0%,100% { opacity:.8; }
    50% { opacity:1.2; }
  }
  .hero-content { position:relative; text-align:center; }
  .hero-eyebrow {
    font-family:'Rajdhani',sans-serif; font-size:11px; font-weight:600;
    letter-spacing:5px; text-transform:uppercase; color:var(--red);
    margin-bottom:18px; display:flex; align-items:center; justify-content:center; gap:14px;
  }
  .hero-eyebrow::before,.hero-eyebrow::after { content:''; width:36px; height:1px; background:var(--red); opacity:.5; }
  .hero h1 {
    font-family:'Barlow Condensed',sans-serif;
    font-size:clamp(50px,8vw,90px); font-weight:800;
    color:var(--white); line-height:.92; text-transform:uppercase; letter-spacing:-1px;
    animation: hero-in .7s cubic-bezier(.22,1,.36,1) both;
  }
  @keyframes hero-in { from { opacity:0; transform:translateY(24px); } to { opacity:1; transform:none; } }
  .hero h1 em { color:var(--red); font-style:normal; }
  .hero-sub { margin-top:20px; font-size:15px; color:var(--muted); animation: hero-in .7s .15s cubic-bezier(.22,1,.36,1) both; }
  .breadcrumb {
    position:absolute; bottom:28px; left:50%; transform:translateX(-50%);
    display:flex; align-items:center; gap:10px;
    font-size:12px; letter-spacing:1px; color:var(--subtle); white-space:nowrap;
  }
  .breadcrumb a { color:var(--subtle); text-decoration:none; }
  .breadcrumb a:hover { color:var(--red); }
  .breadcrumb span { color:var(--red); }

  /* ── LAYOUT ─────────────────────────────────────────────── */
  .cars-section { padding:64px 0 80px; background:var(--bg); }
  .container { max-width:1280px; margin:0 auto; padding:0 48px; }
  .cars-layout { display:grid; grid-template-columns:288px 1fr; gap:36px; align-items:start; }

  /* ── SIDEBAR ─────────────────────────────────────────────── */
  .sidebar {
    background:var(--card); border:1px solid var(--border);
    padding:28px; position:sticky; top:90px;
    animation: slide-in-left .5s cubic-bezier(.22,1,.36,1) both;
  }
  @keyframes slide-in-left { from { opacity:0; transform:translateX(-16px); } to { opacity:1; transform:none; } }
  .sidebar-title {
    font-family:'Rajdhani',sans-serif; font-size:13px; font-weight:700;
    letter-spacing:3px; text-transform:uppercase; color:var(--white);
    margin-bottom:24px; padding-bottom:14px; border-bottom:1px solid var(--border);
    display:flex; align-items:center; gap:10px;
  }
  .sidebar-title::before { content:''; width:3px; height:14px; background:var(--red); flex-shrink:0; }
  .form-group { margin-bottom:18px; }
  .form-group label {
    display:block; font-family:'Rajdhani',sans-serif; font-size:11px;
    font-weight:600; letter-spacing:2px; text-transform:uppercase;
    color:var(--muted); margin-bottom:8px;
  }
  .select-wrap { position:relative; }
  .select-wrap::after {
    content:''; position:absolute; right:12px; top:50%; transform:translateY(-50%);
    width:0; height:0;
    border-left:4px solid transparent;
    border-right:4px solid transparent;
    border-top:5px solid var(--muted);
    pointer-events:none;
  }
  .form-group select, .form-group input {
    width:100%; background:var(--bg3); border:1px solid var(--border);
    color:var(--text); padding:10px 14px; font-family:'Barlow',sans-serif;
    font-size:14px; outline:none; transition:border-color .2s,box-shadow .2s;
    appearance:none; -webkit-appearance:none; box-sizing:border-box;
  }
  .form-group select:focus, .form-group input:focus {
    border-color:var(--red);
    box-shadow: 0 0 0 2px rgba(212,43,43,.12);
  }
  .price-range-row { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
  .price-range-row input { font-size:13px; }
  .btn-search {
    width:100%; background:var(--red); color:#fff; border:none;
    font-family:'Rajdhani',sans-serif; font-size:12px; font-weight:700;
    letter-spacing:3px; text-transform:uppercase; padding:14px;
    cursor:pointer; transition:background .2s,transform .15s; margin-top:6px;
    display:flex; align-items:center; justify-content:center; gap:8px;
  }
  .btn-search:hover { background:var(--red-dark); }
  .btn-search:active { transform:scale(.98); }
  .btn-reset {
    width:100%; background:transparent; color:var(--muted); border:1px solid var(--border);
    font-family:'Rajdhani',sans-serif; font-size:11px; font-weight:600;
    letter-spacing:2px; text-transform:uppercase; padding:10px;
    cursor:pointer; transition:border-color .2s,color .2s; margin-top:8px; text-align:center;
    text-decoration:none; display:block;
  }
  .btn-reset:hover { border-color:var(--red); color:var(--red); }

  /* Active filter pills */
  .active-filters { display:flex; flex-wrap:wrap; gap:6px; margin-bottom:16px; }
  .filter-pill {
    background:rgba(212,43,43,.12); border:1px solid rgba(212,43,43,.3);
    color:var(--red); font-family:'Rajdhani',sans-serif; font-size:10px;
    font-weight:600; letter-spacing:1.5px; text-transform:uppercase;
    padding:4px 10px; display:flex; align-items:center; gap:6px;
  }
  .filter-pill a { color:var(--red); text-decoration:none; font-size:13px; line-height:1; opacity:.7; }
  .filter-pill a:hover { opacity:1; }

  /* ── TOOLBAR (above grid) ───────────────────────────────── */
  .cars-toolbar {
    display:flex; align-items:center; justify-content:space-between;
    margin-bottom:20px; gap:16px; flex-wrap:wrap;
  }
  .result-count {
    font-family:'Rajdhani',sans-serif; font-size:13px; font-weight:600;
    letter-spacing:2px; text-transform:uppercase; color:var(--muted);
  }
  .result-count strong { color:var(--white); }
  .toolbar-right { display:flex; align-items:center; gap:12px; }

  /* Sort select */
  .sort-wrap { position:relative; }
  .sort-wrap::after {
    content:''; position:absolute; right:10px; top:50%; transform:translateY(-50%);
    width:0; height:0;
    border-left:4px solid transparent;
    border-right:4px solid transparent;
    border-top:5px solid var(--muted);
    pointer-events:none;
  }
  .sort-select {
    background:var(--card); border:1px solid var(--border);
    color:var(--text); padding:8px 30px 8px 12px;
    font-family:'Rajdhani',sans-serif; font-size:11px; font-weight:600;
    letter-spacing:2px; text-transform:uppercase;
    outline:none; appearance:none; -webkit-appearance:none; cursor:pointer;
    transition:border-color .2s;
  }
  .sort-select:focus { border-color:var(--red); }

  /* View toggle */
  .view-toggle { display:flex; gap:2px; }
  .view-btn {
    background:var(--card); border:1px solid var(--border); color:var(--muted);
    padding:8px 11px; cursor:pointer; transition:all .2s; line-height:0;
  }
  .view-btn:hover { border-color:var(--border); color:var(--white); }
  .view-btn.active { border-color:var(--red); color:var(--red); background:rgba(212,43,43,.08); }
  .view-btn svg { width:15px; height:15px; fill:none; stroke:currentColor; stroke-width:1.8; }

  /* ── CAR GRID ────────────────────────────────────────────── */
  .cars-grid {
    display:grid; grid-template-columns:repeat(3,1fr);
    gap:2px; background:var(--border);
    transition: grid-template-columns .3s ease;
  }
  .cars-grid.view-list {
    grid-template-columns:1fr;
    gap:2px;
  }

  /* ── CAR CARD — GRID MODE ────────────────────────────────── */
  .car-card {
    background:var(--card); overflow:hidden; position:relative;
    transition:background .3s;
    animation: card-in .45s cubic-bezier(.22,1,.36,1) both;
  }
  @keyframes card-in { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:none; } }
  .car-card:nth-child(2) { animation-delay:.05s; }
  .car-card:nth-child(3) { animation-delay:.1s; }
  .car-card:nth-child(4) { animation-delay:.15s; }
  .car-card:nth-child(5) { animation-delay:.2s; }
  .car-card:nth-child(6) { animation-delay:.25s; }
  .car-card:hover { background:var(--bg3); }
  .car-card::before {
    content:''; position:absolute; top:0; left:0; right:0; height:2px;
    background:var(--red); transform:scaleX(0); transform-origin:left;
    transition:transform .35s ease; z-index:2;
  }
  .car-card:hover::before { transform:scaleX(1); }

  .car-img-wrap { position:relative; overflow:hidden; }
  .car-img {
    width:100%; height:200px; object-fit:cover; display:block;
    transition:transform .5s ease;
  }
  .car-card:hover .car-img { transform:scale(1.04); }
  .car-img-placeholder {
    width:100%; height:200px; background:var(--bg3);
    display:flex; align-items:center; justify-content:center;
    color:var(--subtle); font-size:13px;
  }

  /* Status badge */
  .status-badge {
    position:absolute; top:12px; left:12px; z-index:3;
    font-family:'Rajdhani',sans-serif; font-size:10px; font-weight:700;
    letter-spacing:2px; text-transform:uppercase;
    padding:4px 10px;
  }
  .status-available   { background:rgba(34,197,94,.15); border:1px solid rgba(34,197,94,.4); color:#4ade80; }
  .status-rented      { background:rgba(212,43,43,.15);  border:1px solid rgba(212,43,43,.4);  color:#f87171; }
  .status-maintenance { background:rgba(234,179,8,.15);  border:1px solid rgba(234,179,8,.4);  color:#fbbf24; }

  /* Favourite (decorative) */
  .fav-btn {
    position:absolute; top:10px; right:10px; z-index:3;
    background:rgba(0,0,0,.45); border:1px solid rgba(255,255,255,.1);
    color:var(--muted); width:32px; height:32px;
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; transition:all .2s; backdrop-filter:blur(4px);
  }
  .fav-btn:hover { color:var(--red); border-color:var(--red); }
  .fav-btn svg { width:14px; height:14px; fill:none; stroke:currentColor; stroke-width:1.8; }

  .car-body { padding:20px; }
  .car-brand {
    font-family:'Rajdhani',sans-serif; font-size:10px; font-weight:700;
    letter-spacing:3px; text-transform:uppercase; color:var(--red); margin-bottom:4px;
  }
  .car-name {
    font-family:'Barlow Condensed',sans-serif; font-size:20px; font-weight:700;
    color:var(--white); text-transform:uppercase; letter-spacing:.5px; margin-bottom:12px;
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
  }
  .car-meta { display:flex; gap:14px; margin-bottom:14px; flex-wrap:wrap; }
  .car-meta-item { font-size:12px; color:var(--muted); display:flex; align-items:center; gap:5px; }
  .car-meta-item svg { width:13px; height:13px; stroke:var(--red); fill:none; stroke-width:1.8; flex-shrink:0; }
  .car-footer {
    display:flex; align-items:center; justify-content:space-between;
    padding-top:14px; border-top:1px solid var(--border);
  }
  .car-price { font-family:'Barlow Condensed',sans-serif; font-size:22px; font-weight:800; color:var(--red); }
  .car-price span { font-size:12px; color:var(--muted); font-family:'Barlow',sans-serif; font-weight:400; }
  .btn-detail {
    font-family:'Rajdhani',sans-serif; font-size:11px; font-weight:700;
    letter-spacing:2px; text-transform:uppercase; color:var(--white);
    text-decoration:none; padding:8px 16px; border:1px solid var(--border);
    transition:border-color .2s,color .2s,background .2s;
  }
  .btn-detail:hover { border-color:var(--red); color:var(--red); }

  /* ── CAR CARD — LIST MODE ────────────────────────────────── */
  .cars-grid.view-list .car-card { display:flex; }
  .cars-grid.view-list .car-img-wrap { flex-shrink:0; width:260px; }
  .cars-grid.view-list .car-img { width:260px; height:100%; min-height:160px; }
  .cars-grid.view-list .car-img-placeholder { width:260px; height:160px; }
  .cars-grid.view-list .car-body { flex:1; display:flex; flex-direction:column; justify-content:space-between; }
  .cars-grid.view-list .car-name { font-size:24px; white-space:normal; }
  .cars-grid.view-list .car-meta { gap:18px; }
  .cars-grid.view-list .car-price { font-size:26px; }

  /* ── EMPTY ───────────────────────────────────────────────── */
  .empty-state {
    background:var(--card); border:1px solid var(--border);
    padding:80px 40px; text-align:center; grid-column:1/-1;
  }
  .empty-icon { font-size:48px; margin-bottom:16px; opacity:.3; }
  .empty-state h3 {
    font-family:'Barlow Condensed',sans-serif; font-size:28px; font-weight:800;
    color:var(--white); text-transform:uppercase; margin-bottom:8px;
  }
  .empty-state p { color:var(--muted); font-size:14px; }

  /* ── PAGINATION ──────────────────────────────────────────── */
  .pagination-wrap { margin-top:36px; display:flex; justify-content:center; gap:4px; }
  .pagination-wrap .page-link {
    font-family:'Rajdhani',sans-serif; font-size:12px; font-weight:600;
    letter-spacing:1px; color:var(--muted); background:var(--card);
    border:1px solid var(--border); padding:9px 15px; text-decoration:none;
    transition:border-color .2s,color .2s,background .2s;
  }
  .pagination-wrap .page-link:hover,
  .pagination-wrap .page-link.active { border-color:var(--red); color:var(--red); }

  /* Pagination info */
  .pagination-info {
    text-align:center; margin-top:14px;
    font-family:'Rajdhani',sans-serif; font-size:11px; font-weight:600;
    letter-spacing:2px; text-transform:uppercase; color:var(--subtle);
  }

  /* ── RESPONSIVE ──────────────────────────────────────────── */
  @media(max-width:1024px) {
    .cars-layout { grid-template-columns:240px 1fr; }
    .cars-grid { grid-template-columns:repeat(2,1fr); }
  }
  @media(max-width:768px) {
    .container { padding:0 20px; }
    .cars-layout { grid-template-columns:1fr; }
    .sidebar { position:static; }
    .cars-grid { grid-template-columns:1fr; }
    .cars-grid.view-list .car-img-wrap { width:160px; }
    .cars-grid.view-list .car-img { width:160px; }
  }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="hero">
  <div class="hero-glow"></div>
  <div class="hero-content">
    <div class="hero-eyebrow">Bộ sưu tập của chúng tôi</div>
    <h1>Danh Sách <em>Xe</em></h1>
    <p class="hero-sub">Tìm chiếc xe hoàn hảo dành cho bạn</p>
  </div>
  <div class="breadcrumb">
    <a href="{{ url('/') }}">Home</a> &rsaquo; <span>Cars</span>
  </div>
</section>

{{-- MAIN --}}
<section class="cars-section">
  <div class="container">
    <div class="cars-layout">

      {{-- ── SIDEBAR ─────────────────────────────────────────── --}}
      <div class="sidebar">
        <div class="sidebar-title">Bộ lọc</div>

        {{-- Active filter pills --}}
        @php
          $hasFilter = request()->anyFilled(['brand','min_price','max_price','search','fuel_type','sort']);
        @endphp
        @if($hasFilter)
        <div class="active-filters">
          @if(request('brand'))
            <div class="filter-pill">{{ request('brand') }} <a href="{{ request()->fullUrlWithoutQuery('brand') }}">✕</a></div>
          @endif
          @if(request('fuel_type'))
            <div class="filter-pill">{{ request('fuel_type') }} <a href="{{ request()->fullUrlWithoutQuery('fuel_type') }}">✕</a></div>
          @endif
          @if(request('search'))
            <div class="filter-pill">"{{ request('search') }}" <a href="{{ request()->fullUrlWithoutQuery('search') }}">✕</a></div>
          @endif
          @if(request('min_price') || request('max_price'))
            <div class="filter-pill">Giá đã lọc <a href="{{ request()->fullUrlWithoutQuery(['min_price','max_price']) }}">✕</a></div>
          @endif
        </div>
        @endif

        <form method="GET" action="{{ route('cars.index') }}">
          {{-- Preserve sort --}}
          @if(request('sort'))
            <input type="hidden" name="sort" value="{{ request('sort') }}">
          @endif

          <div class="form-group">
            <label>Hãng xe</label>
            <div class="select-wrap">
              <select name="brand">
                <option value="">Tất cả hãng</option>
                @foreach($brands as $brand)
                  <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group">
            <label>Nhiên liệu</label>
            <div class="select-wrap">
              <select name="fuel_type">
                <option value="">Tất cả</option>
                @foreach(['Xăng','Diesel','Điện','Hybrid'] as $fuel)
                  <option value="{{ $fuel }}" {{ request('fuel_type') == $fuel ? 'selected' : '' }}>{{ $fuel }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group">
            <label>Giá thuê (VNĐ/ngày)</label>
            <div class="price-range-row">
              <input type="number" name="min_price" placeholder="Từ" value="{{ request('min_price') }}">
              <input type="number" name="max_price" placeholder="Đến" value="{{ request('max_price') }}">
            </div>
          </div>

          <div class="form-group">
            <label>Tìm theo tên</label>
            <input type="text" name="search" placeholder="Toyota, BMW..." value="{{ request('search') }}">
          </div>

          <button type="submit" class="btn-search">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Tìm xe
          </button>
          @if($hasFilter)
            <a href="{{ route('cars.index') }}" class="btn-reset">✕ Xoá bộ lọc</a>
          @endif
        </form>
      </div>

      {{-- ── DANH SÁCH XE ─────────────────────────────────────── --}}
      <div>

        {{-- Toolbar --}}
        <div class="cars-toolbar">
          <div class="result-count">
            Tìm thấy <strong>{{ $cars->total() }}</strong> xe
            @if($cars->total() > 0)
              &mdash; trang {{ $cars->currentPage() }}/{{ $cars->lastPage() }}
            @endif
          </div>
          <div class="toolbar-right">
            {{-- Sort --}}
            <div class="sort-wrap">
              <form method="GET" action="{{ route('cars.index') }}" id="sort-form">
                @foreach(request()->except('sort') as $k => $v)
                  <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                @endforeach
                <select name="sort" class="sort-select" onchange="document.getElementById('sort-form').submit()">
                  <option value=""          {{ !request('sort')              ? 'selected' : '' }}>Mặc định</option>
                  <option value="price_asc" {{ request('sort')=='price_asc'  ? 'selected' : '' }}>Giá: thấp → cao</option>
                  <option value="price_desc"{{ request('sort')=='price_desc' ? 'selected' : '' }}>Giá: cao → thấp</option>
                  <option value="newest"    {{ request('sort')=='newest'     ? 'selected' : '' }}>Mới nhất</option>
                  <option value="name_asc"  {{ request('sort')=='name_asc'   ? 'selected' : '' }}>Tên A → Z</option>
                </select>
              </form>
            </div>

            {{-- View toggle --}}
            <div class="view-toggle">
              <button class="view-btn active" id="btn-grid" onclick="setView('grid')" title="Lưới" type="button">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
              </button>
              <button class="view-btn" id="btn-list" onclick="setView('list')" title="Danh sách" type="button">
                <svg viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
              </button>
            </div>
          </div>
        </div>

        {{-- Grid --}}
        <div class="cars-grid" id="cars-grid">
          @forelse($cars as $i => $car)
          <div class="car-card" style="animation-delay:{{ $i * 0.06 }}s">

            <div class="car-img-wrap">
              @if(!empty($car->image_url))
                  <img class="car-img" src="{{ asset($car->image_url) }}" alt="{{ $car->name }}" loading="lazy">
              @else
                  <div class="car-img-placeholder">
                      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" opacity=".3">
                          <rect x="1" y="3" width="15" height="13"/>
                          <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/>
                          <circle cx="5.5" cy="18.5" r="2.5"/>
                          <circle cx="18.5" cy="18.5" r="2.5"/>
                      </svg>
                  </div>
              @endif

              {{-- Status badge --}}
              @if(isset($car->status))
                @php
                  $statusMap = [
                    'available'   => ['class'=>'status-available',   'label'=>'Còn xe'],
                    'rented'      => ['class'=>'status-rented',       'label'=>'Đang thuê'],
                    'maintenance' => ['class'=>'status-maintenance',  'label'=>'Bảo dưỡng'],
                  ];
                  $st = $statusMap[$car->status] ?? null;
                @endphp
                @if($st)
                  <div class="status-badge {{ $st['class'] }}">{{ $st['label'] }}</div>
                @endif
              @else
                {{-- Default available if no status field --}}
                <div class="status-badge status-available">Còn xe</div>
              @endif

              {{-- Favourite button (decorative / hookable) --}}
              <button class="fav-btn" type="button" onclick="toggleFav(this, {{ $car->id }})" title="Yêu thích">
                <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
              </button>
            </div>

            <div class="car-body">
              <div class="car-brand">{{ $car->brand }}</div>
              <div class="car-name">{{ $car->name }}</div>
              <div class="car-meta">
                @if($car->year)
                <div class="car-meta-item">
                  <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/></svg>
                  {{ $car->year }}
                </div>
                @endif
                @if($car->transmission)
                <div class="car-meta-item">
                  <svg viewBox="0 0 24 24"><circle cx="5" cy="12" r="2"/><circle cx="19" cy="5" r="2"/><circle cx="19" cy="19" r="2"/><line x1="7" y1="12" x2="19" y2="7"/><line x1="7" y1="12" x2="19" y2="17"/></svg>
                  {{ $car->transmission }}
                </div>
                @endif
                @if(isset($car->fuel_type) && $car->fuel_type)
                <div class="car-meta-item">
                  <svg viewBox="0 0 24 24"><path d="M3 22V8l7-6 7 6v14"/><line x1="3" y1="22" x2="21" y2="22"/><path d="M14 22v-5a2 2 0 0 0-4 0v5"/></svg>
                  {{ $car->fuel_type }}
                </div>
                @endif
                @if($car->mileage)
                <div class="car-meta-item">
                  <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                  {{ number_format($car->mileage) }} km
                </div>
                @endif
              </div>
                            <div class="car-footer">
                    <div class="car-price">
                        {{ number_format($car->price_per_day ?? $car->price) }}
                        <span>VNĐ/ngày</span>
                    </div>

                    <a href="{{ route('cars.show', $car->id) }}" class="btn-detail">
                        Xem →
                    </a>
                </div>
                </div>
                </div>

                @empty
                <div class="empty-state">
                    <div class="empty-icon">🚗</div>
                    <h3>Không tìm thấy xe</h3>
                    <p>Thử thay đổi bộ lọc để xem thêm kết quả.</p>
                </div>
                @endforelse
             </div>

        {{-- Pagination --}}
        @if($cars->hasPages())
        <div class="pagination-wrap">
          {{ $cars->appends(request()->query())->links() }}
        </div>
        <div class="pagination-info">
          Hiển thị {{ $cars->firstItem() }}–{{ $cars->lastItem() }} / {{ $cars->total() }} xe
        </div>
        @endif

      </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
// ── View toggle ──────────────────────────────────────────────
const GRID_KEY = 'cars_view';
function setView(v) {
  const grid = document.getElementById('cars-grid');
  const btnGrid = document.getElementById('btn-grid');
  const btnList = document.getElementById('btn-list');
  if (v === 'list') {
    grid.classList.add('view-list');
    btnList.classList.add('active');
    btnGrid.classList.remove('active');
  } else {
    grid.classList.remove('view-list');
    btnGrid.classList.add('active');
    btnList.classList.remove('active');
  }
  localStorage.setItem(GRID_KEY, v);
}
// Restore preference
(function() {
  const saved = localStorage.getItem(GRID_KEY);
  if (saved === 'list') setView('list');
})();

// ── Favourite (localStorage demo) ───────────────────────────
function toggleFav(btn, id) {
  const favs = JSON.parse(localStorage.getItem('car_favs') || '[]');
  const idx  = favs.indexOf(id);
  if (idx === -1) {
    favs.push(id);
    btn.style.color = 'var(--red)';
    btn.style.borderColor = 'var(--red)';
    btn.querySelector('svg').style.fill = 'var(--red)';
  } else {
    favs.splice(idx, 1);
    btn.style.color = '';
    btn.style.borderColor = '';
    btn.querySelector('svg').style.fill = '';
  }
  localStorage.setItem('car_favs', JSON.stringify(favs));
}
// Restore fav state on load
(function() {
  const favs = JSON.parse(localStorage.getItem('car_favs') || '[]');
  document.querySelectorAll('.fav-btn').forEach(btn => {
    const id = parseInt(btn.getAttribute('onclick').match(/\d+/)[0]);
    if (favs.includes(id)) {
      btn.style.color = 'var(--red)';
      btn.style.borderColor = 'var(--red)';
      btn.querySelector('svg').style.fill = 'var(--red)';
    }
  });
})();
</script>
@endpush