@extends('layouts.frontend')

@section('title', 'Bảng Giá Xe – AUTO X')

@push('styles')
<style>
body:not(.home-page) main { margin-top: 0 !important; }
:root {
  --red:   #c0392b;
  --dark:  #1a1a1a;
  --muted: #888;
  --th-bg: #6b6b6b;
}
*, *::before, *::after { box-sizing: border-box; }
body { background: #fff; color: var(--dark); }

/* ── HERO ── */
.pg-hero {
  margin-top: 0;
  background: url('{{ asset("images/car/Banner8.jpeg") }}') center/cover no-repeat;
  padding: 56px 0 40px;
  text-align: center;
  border-bottom: 3px solid var(--red);
  position: relative; overflow: hidden;
}
.pg-hero::before {
  content: ''; position: absolute; inset: 0;
  background: linear-gradient(to bottom, rgba(0,0,0,0.45) 0%, rgba(0,0,0,0.35) 100%);
  pointer-events: none;
}
.pg-hero-label {
  position: relative; z-index: 1;
  display: inline-block;
  font-family: 'Rajdhani', sans-serif; font-size: 14px; font-weight: 800;
  letter-spacing: 4px; text-transform: uppercase;
  color: #fff; margin-bottom: 14px;
  padding: 6px 20px; background: var(--red);
  border: 1px solid rgba(255,255,255,0.25); border-radius: 2px;
}
.pg-hero h1 {
  position: relative; z-index: 1;
  font-family: 'Barlow Condensed', sans-serif;
  font-size: clamp(28px, 5vw, 56px); font-weight: 900;
  color: #fff; letter-spacing: 3px; text-transform: uppercase;
  margin: 0 0 12px;
  text-shadow: 0 4px 20px rgba(0,0,0,0.6);
}
.pg-hero p { position: relative; z-index: 1; color: #f9f6f6; font-size: 15px; margin: 0; }

/* ── BREADCRUMB ── */
.pg-breadcrumb {
  padding: 11px 60px; background: #f9f9f9;
  border-bottom: 1px solid #ddd;
  font-family: 'Rajdhani', sans-serif; font-size: 12.5px;
  display: flex; align-items: center; gap: 8px; color: var(--muted);
}
.pg-breadcrumb a { color: var(--muted); text-decoration: none; transition: color .2s; }
.pg-breadcrumb a:hover { color: var(--red); }
.pg-breadcrumb .current { color: var(--red); font-weight: 700; }

/* ── WRAP ── */
.pg-wrap { max-width: 1100px; margin: 0 auto; padding: 40px 40px 72px; }

.pg-note {
  background: #fff8f8; border-left: 3px solid var(--red);
  padding: 12px 18px; font-size: 15px; color: #555;
  margin-bottom: 24px; border-radius: 0 4px 4px 0;
}
.pg-note strong { color: var(--dark); }

.pg-back {
  display: inline-flex; align-items: center; gap: 8px;
  font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700;
  letter-spacing: 1.5px; text-transform: uppercase;
  color: var(--muted); text-decoration: none;
  margin-bottom: 20px; transition: color .2s;
}
.pg-back:hover { color: var(--red); }
.pg-back::before { content: '←'; font-size: 14px; }

/* ══════════════════════════════
   DESKTOP TABLE (≥640px)
══════════════════════════════ */
.pt-wrap { border: 1px solid #ddd; overflow-x: auto; }
.pt-table { width: 100%; border-collapse: collapse; font-size: 15px; }

.pt-table thead th {
  background: var(--th-bg); color: #fff;
  font-weight: 600; font-size: 15px;
  padding: 16px 20px; text-align: center;
  border-right: 1px solid #888; white-space: nowrap;
}
.pt-table thead th:last-child { border-right: none; text-align: right; padding-right: 28px; }

.pt-table td {
  border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;
  vertical-align: middle; padding: 0;
}
.pt-table td:last-child { border-right: none; }

.td-img { text-align: center; padding: 18px 16px; width: 220px; background: #fff; }
.td-img img {
  width: 195px; height: 124px; object-fit: contain;
  display: block; margin: 0 auto; transition: transform .3s ease;
}
.pt-table tr:hover .td-img img { transform: scale(1.05); }

.td-model {
  text-align: center; padding: 20px 18px; width: 195px;
  font-size: 15px; font-weight: 600; color: var(--dark);
}
.td-model-car {
  font-size: 12.5px; font-weight: 700; color: #555;
  text-transform: uppercase; letter-spacing: .4px;
  margin-bottom: 7px; line-height: 1.4;
}

.td-color { text-align: center; padding: 20px 24px; font-size: 14px; color: #555; }

.td-price { text-align: center; padding: 20px 32px; white-space: nowrap; width: 320px; min-width: 280px; }
.price-val { font-size: 18px; font-weight: 700; color: var(--red); letter-spacing: .3px; }
.price-vnd { font-size: 15px; color: #aaa; font-weight: 400; margin-left: 2px; }

.pt-table tbody tr.data-row { background: #fff; }
.pt-table tbody tr.data-row:nth-child(even) { background: #f8f8f8; }
.pt-table tbody tr.data-row:hover { background: #fff0f0; transition: background .12s; }

.car-sep td { height: 12px; background: #ececec; border-bottom: 2px solid #ddd; border-right: none; padding: 0; }

.pt-table tfoot td {
  padding: 13px 20px; font-size: 14px; color: #0c0505;
  background: #f9f9f9; border-top: 2px solid #ddd;
}

/* ══════════════════════════════
   MOBILE CARD LIST (<640px)
══════════════════════════════ */
.price-mobile-list { display: none; }

@media (max-width: 639px) {
  /* Hero */
  .pg-hero { padding: 36px 16px 28px; }
  .pg-hero-label { font-size: 11px; letter-spacing: 2px; padding: 5px 14px; }

  /* Breadcrumb */
  .pg-breadcrumb { padding: 10px 16px; font-size: 11.5px; flex-wrap: wrap; }

  /* Wrap */
  .pg-wrap { padding: 20px 14px 48px; }
  .pg-note { font-size: 13px; padding: 10px 14px; }

  /* Ẩn table, hiện card list */
  .pt-wrap { display: none; }
  .price-mobile-list { display: block; }
}

/* Card item */
.pml-item {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 14px 0;
  border-bottom: 1px solid #efefef;
}
.pml-item:last-child { border-bottom: none; }

.pml-img {
  flex-shrink: 0;
  width: 100px; height: 66px;
  object-fit: contain;
}
.pml-img-placeholder {
  width: 100px; height: 66px;
  display: flex; align-items: center; justify-content: center;
  font-size: 28px; color: #ddd; flex-shrink: 0;
}

.pml-info { flex: 1; min-width: 0; }
.pml-brand {
  font-family: 'Rajdhani', sans-serif;
  font-size: 10px; font-weight: 700;
  letter-spacing: 1.5px; text-transform: uppercase;
  color: var(--muted); margin-bottom: 3px;
}
.pml-name {
  font-size: 14px; font-weight: 700; color: var(--dark);
  line-height: 1.2; margin-bottom: 3px;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.pml-variant {
  font-size: 11.5px; color: #999; margin-bottom: 6px;
}
.pml-price {
  font-size: 15px; font-weight: 800; color: var(--red);
}
.pml-price-sub {
  font-size: 11px; color: #aaa; font-weight: 400;
}

/* Footer note mobile */
.price-footer-note {
  margin-top: 18px;
  font-size: 12px; color: #999; line-height: 1.6;
  padding: 12px 14px;
  background: #f9f9f9;
  border-top: 1px solid #eee;
}
</style>
@endpush

@section('content')

<section class="pg-hero">
  <div class="pg-hero-label">Bảng Giá Tháng {{ date('m/Y') }}</div>
  <h1>Bảng Giá Xe Mới</h1>
  <p>Giá bán lẻ đề xuất (MSRP) – chưa bao gồm phí trước bạ, đăng ký &amp; phụ kiện</p>
</section>

<div class="pg-breadcrumb">
  <a href="{{ url('/') }}">Trang chủ</a>
  <span>›</span>
  <a href="{{ route('cars.index') }}">Xem xe</a>
  <span>›</span>
  <span class="current">Bảng giá sản phẩm</span>
</div>

<div class="pg-wrap">

  <a href="{{ route('cars.index') }}" class="pg-back">Quay lại danh sách xe</a>

  <div class="pg-note">
    <strong>Lưu ý:</strong> Giá niêm yết dưới đây là giá bán lẻ đề xuất (MSRP) tại thời điểm {{ date('d/m/Y') }}.
    Giá thực tế có thể thay đổi theo chính sách hãng &amp; chương trình ưu đãi hiện hành.
    Vui lòng liên hệ showroom để nhận báo giá chính xác nhất.
  </div>

  {{-- ══ DESKTOP TABLE ══ --}}
  <div class="pt-wrap">
    <table class="pt-table">
      <thead>
        <tr>
          <th>Hình ảnh</th>
          <th>Dòng xe</th>
          <th>Phiên bản / Màu xe</th>
          <th>Giá bán lẻ đề xuất</th>
        </tr>
      </thead>
      <tbody>
        @forelse($cars as $car)
          @php
            $thumb = null;
            if (!empty($car->image_url)) {
              $raw   = $car->image_url;
              $thumb = preg_match('#^https?://#i', $raw) ? $raw : asset(ltrim($raw, '/'));
            }
          @endphp
          <tr class="data-row">
            <td class="td-img">
              @if($thumb)
                <img src="{{ $thumb }}" alt="{{ $car->name }}" onerror="this.style.opacity=.1">
              @else
                <div style="width:195px;height:124px;display:flex;align-items:center;justify-content:center;font-size:40px;color:#ddd;margin:0 auto;">🚗</div>
              @endif
            </td>
            <td class="td-model">
              <div class="td-model-car">{{ $car->brand->name ?? '' }}</div>
              {{ $car->name }}
              @if($car->model && $car->model !== $car->name)
                <div style="font-size:12px;color:#aaa;margin-top:4px;">{{ $car->model }}</div>
              @endif
            </td>
            <td class="td-color">
              {{ $car->status === 'coming_soon' ? 'Sắp ra mắt' : ($car->model ?? '—') }}
            </td>
            <td class="td-price">
              @if($car->price_per_day)
                <span class="price-val">{{ number_format($car->price_per_day, 0, ',', '.') }}</span>
                <span class="price-vnd">VND</span>
              @else
                <span style="color:#aaa;font-size:14px;">Liên hệ</span>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" style="padding:40px;text-align:center;color:#aaa;">Chưa có dữ liệu giá.</td>
          </tr>
        @endforelse
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4">
            * Giá trên là MSRP đề xuất. Phí trước bạ, đăng ký biển số và phụ kiện tính riêng.
            Giá thực tế tại showroom có thể thay đổi theo chương trình ưu đãi hiện hành.
          </td>
        </tr>
      </tfoot>
    </table>
  </div>

  {{-- ══ MOBILE CARD LIST ══ --}}
  <div class="price-mobile-list">
    @forelse($cars as $car)
      @php
        $thumb = null;
        if (!empty($car->image_url)) {
          $raw   = $car->image_url;
          $thumb = preg_match('#^https?://#i', $raw) ? $raw : asset(ltrim($raw, '/'));
        }
      @endphp
      <div class="pml-item">
        {{-- Ảnh --}}
        @if($thumb)
          <img class="pml-img" src="{{ $thumb }}" alt="{{ $car->name }}" onerror="this.style.opacity=.1">
        @else
          <div class="pml-img-placeholder">🚗</div>
        @endif

        {{-- Thông tin --}}
        <div class="pml-info">
          <div class="pml-brand">{{ $car->brand->name ?? '' }}</div>
          <div class="pml-name">{{ $car->name }}</div>
          <div class="pml-variant">
            {{ $car->status === 'coming_soon' ? 'Sắp ra mắt' : ($car->model ?? '—') }}
          </div>
          @if($car->price_per_day)
            <div class="pml-price">
              {{ number_format($car->price_per_day, 0, ',', '.') }}
              <span class="pml-price-sub">VND</span>
            </div>
          @else
            <div class="pml-price" style="font-size:13px;color:#aaa;font-weight:600">Liên hệ</div>
          @endif
        </div>
      </div>
    @empty
      <div style="padding:40px 0;text-align:center;color:#aaa;font-size:14px;">Chưa có dữ liệu giá.</div>
    @endforelse

    <div class="price-footer-note">
      * Giá trên là MSRP đề xuất. Phí trước bạ, đăng ký biển số và phụ kiện tính riêng.
      Giá thực tế tại showroom có thể thay đổi theo chương trình ưu đãi hiện hành.
    </div>
  </div>

</div>

@endsection