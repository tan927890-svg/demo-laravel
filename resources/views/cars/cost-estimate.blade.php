@extends('layouts.frontend')

@section('title', 'Dự Toán Chi Phí - ' . ($car->name ?? 'Xe') . ' - AUTO X')

@push('styles')
<style>
/* ── IMPORT FONTS ── */
@import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,400;0,600;0,700;0,900;1,700;1,900&family=Barlow:wght@400;500;600&family=Rajdhani:wght@500;600;700&display=swap');

/* ── ROOT VARS (match AUTO X theme) ── */
:root {
  --red:    #D42B2B;
  --gold:   #f3f3f3;
  --white:  #FFFFFF;
  --bg1:    #0d0d0f;
  --bg2:    #111113;
  --bg3:    #1a1a1d;
  --card:   #141416;
  --border: rgba(255,255,255,.08);
  --muted:  rgba(255,255,255,.45);
}

/* ── PAGE WRAPPER ── */
.dtt-page {
  background: #f2f1ed;
  min-height: 100vh;
  font-family: 'Barlow', sans-serif;
}

/* ── BREADCRUMB ── */
.page-breadcrumb {
  background: #fff;
  border-bottom: 1px solid #DDD0B5;
  padding: 13px 40px;
  display: flex; align-items: center; gap: 8px;
  font-family: 'Barlow', sans-serif; font-size: 13px; color: #555;
}
.page-breadcrumb a { color: #555; text-decoration: none; transition: color .2s; }
.page-breadcrumb a:hover { color: #e8e2d8; }
.page-breadcrumb span { color: #9A6F28; font-weight: 600; }

/* ── HERO BANNER ── */
.dtt-hero {
  background: var(--bg1);
  padding: 56px 40px 48px;
  text-align: center;
  position: relative;
  overflow: hidden;
}
.dtt-hero::before {
  content: 'DỰ TOÁN';
  position: absolute; top: -20px; left: 50%; transform: translateX(-50%);
  font-family: 'Barlow Condensed', sans-serif;
  font-size: clamp(80px, 12vw, 160px); font-weight: 900;
  color: rgba(255,255,255,.03); letter-spacing: -6px;
  white-space: nowrap; pointer-events: none; user-select: none;
}
.dtt-hero-badge {
  display: inline-flex; align-items: center; gap: 10px;
  font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
  letter-spacing: 4px; text-transform: uppercase; color: var(--red);
  margin-bottom: 16px;
}
.dtt-hero-badge::before,
.dtt-hero-badge::after { content:''; width:32px; height:1px; background:var(--red); }
.dtt-hero-title {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: clamp(36px, 5vw, 64px); font-weight: 900;
  color: var(--white); text-transform: uppercase;
  letter-spacing: -2px; line-height: .95;
  position: relative; z-index: 1;
}
.dtt-hero-title em { color: var(--red); font-style: normal; }
.dtt-hero-sub {
  margin-top: 12px;
  font-family: 'Barlow Condensed', sans-serif; font-size: 15px; font-weight: 500;
  letter-spacing: 3px; text-transform: uppercase;
  color: rgba(255,255,255,.38); position: relative; z-index: 1;
}

/* ── MAIN LAYOUT ── */
.dtt-main {
  max-width: 1280px; margin: 0 auto;
  padding: 56px 40px 80px;
  display: grid;
  grid-template-columns: 480px 1fr;
  gap: 48px;
  align-items: start;
}

/* ── FORM PANEL ── */
.dtt-form-panel {
  background: #fff;
  border-top: 3px solid var(--red);
  box-shadow: 0 4px 32px rgba(0,0,0,.10);
  padding: 40px;
}
.dtt-form-section-title {
  font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700;
  letter-spacing: 4px; text-transform: uppercase; color: var(--red);
  display: flex; align-items: center; gap: 10px; margin-bottom: 6px;
}
.dtt-form-section-title::before { content:''; width:20px; height:1px; background:var(--red); }
.dtt-form-heading {
  font-family: 'Barlow Condensed', sans-serif; font-size: 26px; font-weight: 900;
  color: #111; text-transform: uppercase; letter-spacing: -0.5px;
  margin-bottom: 28px;
}

.dtt-field { margin-bottom: 20px; }
.dtt-label {
  font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700;
  letter-spacing: 1px; color: #333; margin-bottom: 8px; display: block;
}
.dtt-select {
  width: 100%; padding: 13px 16px;
  border: 1.5px solid #d0cec8; background: #f5f4f0;
  font-family: 'Barlow', sans-serif; font-size: 14px; color: #333;
  appearance: none; -webkit-appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23999' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
  background-repeat: no-repeat; background-position: right 14px center;
  cursor: pointer; transition: border-color .2s, background .2s;
}
.dtt-select:focus { outline: none; border-color: var(--red); background: #fff; }

.dtt-region-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

.dtt-submit-btn {
  width: 100%; padding: 16px;
  background: var(--red); border: none; cursor: pointer;
  font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700;
  letter-spacing: 4px; text-transform: uppercase; color: #fff;
  margin-top: 8px; transition: background .2s, transform .15s;
  display: flex; align-items: center; justify-content: center; gap: 10px;
}
.dtt-submit-btn:hover { background: #181616; transform: translateY(-1px); }
.dtt-submit-btn svg { transition: transform .2s; }
.dtt-submit-btn:hover svg { transform: translateX(4px); }

.dtt-note {
  margin-top: 24px; padding-top: 20px; border-top: 1px solid #e8e6e0;
  font-size: 12px; color: #888; line-height: 1.7;
}
.dtt-note p { margin: 0 0 4px; }
.dtt-note strong { color: #555; }

/* ── RESULT PANEL ── */
.dtt-result-panel {
  position: sticky; top: 20px;
}
.dtt-result-car-thumb {
  background: var(--bg1); position: relative; overflow: hidden;
  height: 200px; margin-bottom: 0;
  display: flex; align-items: center; justify-content: center;
}
.dtt-result-car-thumb img {
  width: 100%; height: 100%; object-fit: cover; display: block;
  opacity: .85;
}
.dtt-result-car-thumb-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,.8) 0%, transparent 60%);
}
.dtt-result-car-info {
  position: absolute; bottom: 0; left: 0; right: 0; padding: 20px 24px;
}
.dtt-result-car-brand {
  font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700;
  letter-spacing: 4px; text-transform: uppercase; color: var(--red); margin-bottom: 4px;
}
.dtt-result-car-name {
  font-family: 'Barlow Condensed', sans-serif; font-size: 24px; font-weight: 900;
  color: #fff; text-transform: uppercase; letter-spacing: -0.5px;
}
.dtt-result-car-variant {
  font-size: 12px; color: rgba(255,255,255,.5); margin-top: 2px;
  font-family: 'Barlow', sans-serif;
}

.dtt-result-box {
  background: #fff; border-top: 3px solid var(--red);
  box-shadow: 0 4px 32px rgba(0,0,0,.10); padding: 36px 40px;
}

/* Rows */
.dtt-row {
  display: flex; justify-content: space-between; align-items: flex-start;
  padding: 14px 0; border-bottom: 1px solid #f0eeea;
  gap: 20px;
}
.dtt-row:last-child { border-bottom: none; }
.dtt-row-label {
  font-family: 'Barlow', sans-serif; font-size: 14px; color: #555; flex: 1;
}
.dtt-row-label small {
  display: block; font-size: 12px; color: #999; margin-top: 2px;
}
.dtt-row-val {
  font-family: 'Barlow Condensed', sans-serif; font-size: 18px;
  font-weight: 700; color: #222; text-align: right; white-space: nowrap;
  min-width: 140px;
}
.dtt-row-val.empty { color: #ccc; font-size: 14px; font-weight: 400; }

/* Sub indent row */
.dtt-row.sub {
  padding: 8px 0 8px 20px; border-bottom: 1px solid #f8f7f5;
}
.dtt-row.sub .dtt-row-label { font-size: 13px; color: #777; }
.dtt-row.sub .dtt-row-val { font-size: 15px; font-weight: 600; color: #444; }

/* Total row */
.dtt-row.total {
  padding: 20px 0 0; border-bottom: none; margin-top: 8px;
  border-top: 2px solid #111;
}
.dtt-row.total .dtt-row-label {
  font-family: 'Barlow Condensed', sans-serif; font-size: 20px;
  font-weight: 900; color: #111; text-transform: uppercase; letter-spacing: 1px;
}
.dtt-row.total .dtt-row-val {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 38px; font-weight: 900; color: var(--red); line-height: 1;
}
.dtt-row.total .dtt-row-val small {
  display: block; font-family: 'Barlow', sans-serif;
  font-size: 12px; color: #999; font-weight: 400; text-align: right; margin-top: 2px;
}

/* Disclaimer */
.dtt-disclaimer {
  margin-top: 20px; padding: 16px 20px;
  background: #f5f4f0; border-left: 3px solid #d0cec8;
  font-size: 12px; color: #888; line-height: 1.7;
}

/* Empty state */
.dtt-empty-state {
  padding: 48px 0; text-align: center;
}
.dtt-empty-icon {
  width: 56px; height: 56px; margin: 0 auto 16px;
  opacity: .15;
}
.dtt-empty-text {
  font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700;
  letter-spacing: 3px; text-transform: uppercase; color: #aaa;
}

/* Pulse animation for result update */
@keyframes val-pulse { 0%{opacity:.4} 50%{opacity:1} 100%{opacity:.4} }
.calculating .dtt-row-val { animation: val-pulse 1s ease infinite; }

/* ── CTA bottom ── */
.dtt-cta-row {
  display: flex; gap: 12px; margin-top: 28px; flex-wrap: wrap;
}
.dtt-cta-btn {
  flex: 1; min-width: 160px; padding: 15px 20px; text-align: center;
  font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700;
  letter-spacing: 3px; text-transform: uppercase; text-decoration: none;
  cursor: pointer; border: none; transition: all .2s; display: inline-block;
}
.dtt-cta-btn.primary { background: var(--red); color: #ffe7e7; }
.dtt-cta-btn.primary:hover { background: #000000; }
.dtt-cta-btn.secondary { background: transparent; color: #111; border: 2px solid #111; }
.dtt-cta-btn.secondary:hover { border-color: var(--red); color: var(--red); }

/* ── RESPONSIVE ── */
@media(max-width: 1024px) {
  .dtt-main { grid-template-columns: 1fr; gap: 32px; }
  .dtt-result-panel { position: static; }
}
@media(max-width: 768px) {
  .dtt-main { padding: 32px 20px 60px; }
  .dtt-form-panel, .dtt-result-box { padding: 28px 24px; }
  .page-breadcrumb { padding: 13px 20px; }
  .dtt-region-row { grid-template-columns: 1fr; }
  .dtt-hero { padding: 40px 20px 36px; }
}
/* PANEL */
.dtt-form-panel,
.dtt-result-box {
  border-radius: 14px;
}

/* SELECT */
.dtt-select {
  border-radius: 10px;
}

/* BUTTON */
.dtt-submit-btn {
  border-radius: 10px;
}

/* RESULT ROW */
.dtt-row {
  border-radius: 8px;
}
</style>
@endpush

@section('content')
<div class="dtt-page">

  {{-- BREADCRUMB --}}
  <div class="page-breadcrumb">
    <a href="{{ url('/') }}">Home</a> ›
    <a href="{{ route('cars.index') }}">Xe</a> ›
    @if(isset($car))
      <a href="{{ route('cars.show', $car->id) }}">{{ $car->name }}</a> ›
    @endif
    <span>Dự Toán Chi Phí</span>
  </div>

  {{-- HERO --}}
  <div class="dtt-hero">
    <div class="dtt-hero-badge">Auto X</div>
    <div class="dtt-hero-title">Dự Toán <em>Chi Phí</em></div>
    <div class="dtt-hero-sub">Tính toán nhanh — Minh bạch — Chính xác</div>
  </div>

  {{-- MAIN --}}
  <div class="dtt-main">

    {{-- FORM PANEL --}}
    <div class="dtt-form-panel">
      <div class="dtt-form-section-title">Công cụ</div>
      <div class="dtt-form-heading">Thông Tin Xe</div>

      {{-- Chọn xe --}}
      <div class="dtt-field">
        <label class="dtt-label">Chọn xe</label>
        <select class="dtt-select" id="sel-car">
          @if(isset($car))
            @foreach($car->variants as $variant)
              <option value="{{ $variant->id }}"
                      data-price="{{ $variant->price }}"
                      {{ $loop->first ? 'selected' : '' }}>
                {{ $car->name }} {{ $variant->name }}
              </option>
            @endforeach
            @if($car->variants->isEmpty())
              <option value="0"
                      data-price="{{ $car->price_per_day ?? $car->price ?? 0 }}">
                {{ $car->name }}
              </option>
            @endif
          @elseif(isset($cars))
            <option value="">— Chọn xe —</option>
            @foreach($cars as $c)
              @foreach($c->variants as $v)
                <option value="{{ $v->id }}"
                        data-price="{{ $v->price }}">
                  {{ $c->name }} {{ $v->name }}
                </option>
              @endforeach
              @if($c->variants->isEmpty())
                <option value="car-{{ $c->id }}"
                        data-price="{{ $c->price_per_day ?? $c->price ?? 0 }}">
                  {{ $c->name }}
                </option>
              @endif
            @endforeach
          @endif
        </select>
      </div>

      {{-- Nơi đăng ký trước bạ --}}
      <div class="dtt-form-section-title" style="margin-top: 28px;">Khu Vực</div>
      <div class="dtt-form-heading" style="font-size:22px;">Nơi đăng ký trước bạ</div>

      <div class="dtt-region-row">
        <div class="dtt-field">
          <label class="dtt-label">Tỉnh / TP</label>
          <select class="dtt-select" id="sel-province" onchange="onProvinceChange()">
            <option value="">Chọn tỉnh thành</option>
            <optgroup label="Khu vực I">
              <option value="hanoi"   data-zone="1">Hà Nội</option>
              <option value="hcm"     data-zone="1">TP. Hồ Chí Minh</option>
            </optgroup>
            <optgroup label="Khu vực II">
              <option value="haiphong"    data-zone="2">Hải Phòng</option>
              <option value="danang"      data-zone="2">Đà Nẵng</option>
              <option value="cantho"      data-zone="2">Cần Thơ</option>
              <option value="binhduong"   data-zone="2">Bình Dương</option>
              <option value="dongnai"     data-zone="2">Đồng Nai</option>
              <option value="bariavungtau" data-zone="2">Bà Rịa - Vũng Tàu</option>
              <option value="bacninh"     data-zone="2">Bắc Ninh</option>
              <option value="quangninh"   data-zone="2">Quảng Ninh</option>
              <option value="hatinh"      data-zone="2">Hà Tĩnh</option>
              <option value="nghean"      data-zone="2">Nghệ An</option>
              <option value="thanhhoa"    data-zone="2">Thanh Hóa</option>
              <option value="khanhhoa"    data-zone="2">Khánh Hòa</option>
              <option value="binhthuan"   data-zone="2">Bình Thuận</option>
              <option value="longaon"     data-zone="2">Long An</option>
              <option value="tiengiang"   data-zone="2">Tiền Giang</option>
              <option value="vinhlong"    data-zone="2">Vĩnh Long</option>
            </optgroup>
            <optgroup label="Khu vực III">
              <option value="other" data-zone="3">Các tỉnh thành khác</option>
            </optgroup>
          </select>
        </div>
        <div class="dtt-field">
          <label class="dtt-label">Khu vực (*)</label>
          <select class="dtt-select" id="sel-zone">
            <option value="">Chọn khu vực</option>
            <option value="1" data-rate="0.10">Khu vực I (10%)</option>
            <option value="2" data-rate="0.10">Khu vực II (10%)</option>
            <option value="3" data-rate="0.08">Khu vực III (8%)</option>
          </select>
        </div>
      </div>

      {{-- Submit --}}
      <button class="dtt-submit-btn" onclick="recalculate()">
        DỰ TOÁN CHI PHÍ
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="5" y1="12" x2="19" y2="12"/>
          <polyline points="12 5 19 12 12 19"/>
        </svg>
      </button>

      {{-- Ghi chú khu vực --}}
      <div class="dtt-note">
        <p><strong>(*) Phân loại khu vực:</strong></p>
        <p>Khu vực I: Gồm TP Hà Nội và TP Hồ Chí Minh</p>
        <p>Khu vực II: Gồm các TP trực thuộc trung ương (trừ TP Hà Nội và TP Hồ Chí Minh), các TP trực thuộc tỉnh và các thị xã</p>
        <p>Khu vực III: Gồm các khu vực khác ngoài khu vực I và khu vực II nêu trên</p>
      </div>
    </div>

    {{-- RESULT PANEL --}}
    <div class="dtt-result-panel">

      {{-- Car thumb --}}
      @if(isset($car))
      @php
        $thumbSrc = null;
        foreach (['image_url', 'image', 'hero_image'] as $_f) {
            if (!empty($car->$_f)) { $thumbSrc = asset(ltrim($car->$_f, '/')); break; }
        }
      @endphp
      <div class="dtt-result-car-thumb">
        @if($thumbSrc)
          <img src="{{ $thumbSrc }}" alt="{{ $car->name }}" onerror="this.style.display='none'">
        @else
          <div style="width:100%;height:100%;background:linear-gradient(135deg,#1a1a1f,#2a1818);display:flex;align-items:center;justify-content:center;">
            <span style="font-family:'Barlow Condensed',sans-serif;font-size:32px;font-weight:900;letter-spacing:-1px;text-transform:uppercase;color:rgba(255,255,255,.08);">{{ $car->name }}</span>
          </div>
        @endif
        <div class="dtt-result-car-thumb-overlay"></div>
        <div class="dtt-result-car-info">
          <div class="dtt-result-car-brand">{{ $car->brand?->name ?? $car->brand }}</div>
          <div class="dtt-result-car-name" id="result-car-name">{{ $car->name }}</div>
          <div class="dtt-result-car-variant" id="result-car-variant">
            {{ $car->variants->first()?->name ?? '' }}
          </div>
        </div>
      </div>
      @endif

      {{-- Result box --}}
      <div class="dtt-result-box" id="result-box">

        {{-- Empty state (mặc định) --}}
        <div id="result-empty" class="dtt-empty-state">
          <svg class="dtt-empty-icon" viewBox="0 0 64 64" fill="none" stroke="#333" stroke-width="1.5">
            <rect x="8" y="8" width="48" height="48" rx="4"/>
            <line x1="20" y1="24" x2="44" y2="24"/>
            <line x1="20" y1="32" x2="44" y2="32"/>
            <line x1="20" y1="40" x2="36" y2="40"/>
          </svg>
          <div class="dtt-empty-text">Chọn xe & khu vực<br>để xem dự toán</div>
        </div>

        {{-- Result rows (ẩn khi chưa tính) --}}
        <div id="result-content" style="display:none;">

          <div class="dtt-row">
            <div class="dtt-row-label">Giá xe (bao gồm VAT)</div>
            <div class="dtt-row-val" id="r-car-price">—</div>
          </div>

          <div class="dtt-row">
            <div class="dtt-row-label">Lệ phí trước bạ</div>
            <div class="dtt-row-val" id="r-tb-total">—</div>
          </div>
          <div class="dtt-row sub">
            <div class="dtt-row-label">— Mức lệ phí</div>
            <div class="dtt-row-val" id="r-tb-rate">—</div>
          </div>
          <div class="dtt-row sub">
            <div class="dtt-row-label">— Thành tiền</div>
            <div class="dtt-row-val" id="r-tb-amount">—</div>
          </div>

          <div class="dtt-row">
            <div class="dtt-row-label">
              Lệ phí đăng ký
              <small>Biển số xe</small>
            </div>
            <div class="dtt-row-val" id="r-reg-fee">—</div>
          </div>

          <div class="dtt-row">
            <div class="dtt-row-label">
              Phí sử dụng đường bộ
              <small>1 năm</small>
            </div>
            <div class="dtt-row-val" id="r-road-fee">—</div>
          </div>

          <div class="dtt-row">
            <div class="dtt-row-label">
              Bảo hiểm TNDS
              <small>1 năm (đã gồm 10% VAT)</small>
            </div>
            <div class="dtt-row-val" id="r-insurance">—</div>
          </div>

          <div class="dtt-row total">
            <div class="dtt-row-label">Tổng cộng (VNĐ)</div>
            <div class="dtt-row-val" id="r-total">
              <small>*Tạm tính</small>
            </div>
          </div>

          <div class="dtt-disclaimer">
            Mức biểu phí trên đây là tạm tính và có thể thay đổi do sự thay đổi của thuế và các bên cung cấp dịch vụ khác. Mức bảo hiểm đã gồm 10% VAT.
          </div>

          <div class="dtt-cta-row">
            @if(isset($car))
             <a href="{{ route('services.booking', ['car_id' => $car->id]) }}"
              class="dtt-cta-btn primary">
                ĐẶT XE NGAY →
            </a>
              <a href="{{ route('cars.show', $car->id) }}" class="dtt-cta-btn secondary">XEM XE</a>
            @else
              <a href="{{ route('cars.index') }}" class="dtt-cta-btn primary">XEM TẤT CẢ XE →</a>
            @endif
          </div>
        </div>
      </div>

    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
(function () {
  'use strict';

  const FIXED = {
    regFee    : 1_000_000,
    roadFee   : 1_560_000,
    insurance : 480_700,
  };

  const ZONE_RATE  = { '1': 0.10, '2': 0.10, '3': 0.08 };
  const ZONE_LABEL = { '1': '10%', '2': '10%', '3': '8%' };

  const fmt = n => new Intl.NumberFormat('vi-VN').format(Math.round(n));
  function el(id) { return document.getElementById(id); }

  /* Chỉ fill khu vực, KHÔNG tính kết quả */
  window.onProvinceChange = function () {
    const prov = el('sel-province');
    const opt  = prov.options[prov.selectedIndex];
    const zone = opt.dataset.zone;
    const zSel = el('sel-zone');
    if (zone) {
      for (let i = 0; i < zSel.options.length; i++) {
        if (zSel.options[i].value === zone) {
          zSel.selectedIndex = i; break;
        }
      }
    }
    // Không gọi recalculate() ở đây
  };

  /* Chỉ chạy khi bấm nút */
  window.recalculate = function () {
    const carSel  = el('sel-car');
    const zoneSel = el('sel-zone');

    if (!carSel || !zoneSel) return;

    const carOpt  = carSel.options[carSel.selectedIndex];
    const zoneOpt = zoneSel.options[zoneSel.selectedIndex];

    const carPrice = parseFloat(carOpt?.dataset?.price) || 0;
    const zone     = zoneOpt?.value;
    const rate     = ZONE_RATE[zone] || null;

    if (!carPrice || !rate) {
      el('result-empty').style.display   = 'block';
      el('result-content').style.display = 'none';
      return;
    }

    const tbAmount = carPrice * rate;
    const total    = carPrice + tbAmount + FIXED.regFee + FIXED.roadFee + FIXED.insurance;

    el('result-empty').style.display   = 'none';
    el('result-content').style.display = 'block';

    el('result-content').classList.add('calculating');
    setTimeout(() => el('result-content').classList.remove('calculating'), 600);

    el('r-car-price').textContent = fmt(carPrice);
    el('r-tb-total').textContent  = fmt(tbAmount);
    el('r-tb-rate').textContent   = ZONE_LABEL[zone];
    el('r-tb-amount').textContent = fmt(tbAmount);
    el('r-reg-fee').textContent   = fmt(FIXED.regFee);
    el('r-road-fee').textContent  = fmt(FIXED.roadFee);
    el('r-insurance').textContent = fmt(FIXED.insurance);
    el('r-total').innerHTML       = fmt(total) + '<small>*Tạm tính</small>';

    const variantEl = el('result-car-variant');
    if (variantEl) variantEl.textContent = carOpt.text || '';
  };

})();
</script>
@endpush