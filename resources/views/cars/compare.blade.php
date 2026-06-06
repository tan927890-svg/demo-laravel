@extends('layouts.frontend')

@section('title', 'So Sánh Sản Phẩm - AUTO X')

@push('styles')
<style>
:root {
  --cmp-red:    #d42b2b;
  --cmp-red-dk: #a00000;
  --cmp-border: #e5e5e5;
  --cmp-bg:     #f8f7f4;
  --cmp-dark:   #111;
  --cmp-muted:  #888;
}
*, *::before, *::after { box-sizing: border-box; }

/* ── PAGE HEADER ── */
.cmp-page-header {
  background: #fff;
  border-bottom: 1px solid var(--cmp-border);
  padding: 16px 48px;
  display: flex;
  align-items: center;
  gap: 20px;
}
.cmp-back-link {
  font-family: 'Rajdhani', sans-serif;
  font-size: 12px; font-weight: 700;
  letter-spacing: 2px; text-transform: uppercase;
  color: var(--cmp-muted); text-decoration: none;
  display: flex; align-items: center; gap: 6px;
  transition: color .2s;
}
.cmp-back-link:hover { color: var(--cmp-red); }
.cmp-page-title {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 26px; font-weight: 900;
  color: var(--cmp-red); text-transform: uppercase;
  letter-spacing: -0.5px; font-style: italic;
}

/* ── MAIN WRAP ── */
.cmp-wrap { background: #fff; min-height: 100vh; padding-bottom: 80px; }

/* ══════════════════════════════
   DESKTOP LAYOUT (≥640px)
══════════════════════════════ */
.cmp-sticky-header {
  position: sticky; top: 0; z-index: 200;
  background: #fff; border-bottom: 1px solid var(--cmp-border);
  box-shadow: 0 2px 12px rgba(0,0,0,.06);
}
.cmp-slots-row {
  display: flex; max-width: 1160px; margin: 0 auto;
}
.cmp-label-spacer {
  width: 200px; flex-shrink: 0;
  border-right: 1px solid var(--cmp-border);
}
.cmp-slot {
  flex: 1; padding: 16px 20px 14px;
  border-left: 1px solid var(--cmp-border);
  min-height: 210px;
  display: flex; flex-direction: column;
  align-items: center; text-align: center; position: relative;
}
.cmp-slot-empty {
  flex: 1; display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  gap: 10px; cursor: pointer; width: 100%;
}
.cmp-slot-add-btn {
  font-family: 'Rajdhani', sans-serif;
  font-size: 11px; font-weight: 700;
  letter-spacing: 2px; text-transform: uppercase;
  border: 1.5px solid var(--cmp-red); color: var(--cmp-red);
  background: transparent; padding: 10px 20px; cursor: pointer;
  display: inline-flex; align-items: center; gap: 8px;
  transition: background .2s, color .2s;
  width: 100%; justify-content: center;
}
.cmp-slot-add-btn:hover { background: var(--cmp-red); color: #fff; }
.cmp-slot-car-img {
  width: 190px; height: 110px; object-fit: contain;
  display: block; mix-blend-mode: multiply;
}
.cmp-slot-name-bar {
  width: 100%; background: var(--cmp-red);
  display: flex; align-items: center; justify-content: space-between;
  padding: 7px 10px; margin: 8px 0 0;
}
.cmp-slot-name {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 15px; font-weight: 800; color: #fff;
  text-transform: uppercase; letter-spacing: .5px;
  text-align: left; flex: 1;
}
.cmp-slot-refresh {
  background: none; border: none; cursor: pointer;
  padding: 2px 4px; opacity: .75; transition: opacity .2s;
  color: #fff; font-size: 15px; line-height: 1;
}
.cmp-slot-refresh:hover { opacity: 1; }
.cmp-slot-remove {
  background: none; border: none; cursor: pointer;
  color: #aaa; font-size: 16px; padding: 2px 5px;
  position: absolute; top: 6px; right: 6px;
  transition: color .2s; line-height: 1;
}
.cmp-slot-remove:hover { color: var(--cmp-red); }
.cmp-slot-variant-select {
  width: 100%; margin-top: 8px;
  font-family: 'Barlow', sans-serif; font-size: 13px;
  border: 1px solid #ddd; padding: 8px 32px 8px 12px;
  background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23666'/%3E%3C/svg%3E") right 12px center no-repeat;
  -webkit-appearance: none; appearance: none;
  cursor: pointer; color: var(--cmp-dark);
}

/* ── BODY ── */
.cmp-body { max-width: 1160px; margin: 0 auto; }

.cmp-section-title {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 14px; font-weight: 800; color: var(--cmp-red);
  text-transform: uppercase; letter-spacing: 3px;
  padding: 20px 24px 12px;
  border-top: 2px solid var(--cmp-red);
  border-bottom: 1px solid #fdd; background: #fff9f9;
  opacity: 0; transform: translateY(16px);
  transition: opacity .5s ease, transform .5s ease;
}
.cmp-section-title.visible { opacity: 1; transform: none; }

.cmp-spec-group {
  display: flex; border-bottom: 1px solid var(--cmp-border);
  opacity: 0; transform: translateY(12px);
  transition: opacity .45s ease, transform .45s ease;
}
.cmp-spec-group.visible { opacity: 1; transform: none; }

.cmp-spec-label-col {
  width: 200px; flex-shrink: 0;
  padding: 18px 20px 18px 24px;
  display: flex; align-items: flex-start;
  border-right: 1px solid var(--cmp-border);
}
.cmp-spec-label { font-family: 'Barlow', sans-serif; font-size: 13px; color: var(--cmp-muted); line-height: 1.4; }
.cmp-spec-values { flex: 1; display: flex; }
.cmp-spec-val {
  flex: 1; padding: 18px 20px;
  border-left: 1px solid var(--cmp-border);
  font-family: 'Barlow', sans-serif; font-size: 14px;
  font-weight: 600; color: var(--cmp-dark); line-height: 1.5;
  min-height: 56px; display: flex; align-items: center;
  justify-content: center; text-align: center;
}
.cmp-spec-val:first-child { border-left: none; }
.cmp-spec-val.empty { color: #bbb; font-weight: 400; font-size: 13px; font-style: italic; }

.cmp-price-block {
  display: flex; background: #fafafa;
  border-top: 2px solid var(--cmp-border); border-bottom: 2px solid var(--cmp-border);
  opacity: 0; transform: translateY(12px);
  transition: opacity .5s ease, transform .5s ease;
}
.cmp-price-block.visible { opacity: 1; transform: none; }
.cmp-price-label-cell {
  width: 200px; flex-shrink: 0;
  padding: 20px 20px 20px 24px;
  font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
  letter-spacing: 3px; text-transform: uppercase; color: var(--cmp-muted);
  border-right: 1px solid var(--cmp-border);
  display: flex; align-items: center; white-space: normal; line-height: 1.5;
}
.cmp-price-cells { flex: 1; display: flex; }
.cmp-price-cell {
  flex: 1; padding: 20px;
  border-left: 1px solid var(--cmp-border);
  display: flex; flex-direction: column;
  align-items: center; justify-content: center; gap: 2px;
}
.cmp-price-cell:first-child { border-left: none; }
.cmp-price-amount {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 22px; font-weight: 900; color: var(--cmp-red);
  line-height: 1; letter-spacing: -.5px;
}
.cmp-price-unit { font-family: 'Barlow', sans-serif; font-size: 11px; color: var(--cmp-muted); }

.cmp-cta-block {
  display: flex; border-top: 1px solid var(--cmp-border);
  opacity: 0; transform: translateY(12px);
  transition: opacity .5s ease, transform .5s ease;
}
.cmp-cta-block.visible { opacity: 1; transform: none; }
.cmp-cta-spacer { width: 200px; flex-shrink: 0; border-right: 1px solid var(--cmp-border); }
.cmp-cta-cells { flex: 1; display: flex; }
.cmp-cta-cell {
  flex: 1; padding: 20px 16px;
  border-left: 1px solid var(--cmp-border);
  display: flex; flex-direction: column; gap: 8px; align-items: stretch;
}
.cmp-cta-cell:first-child { border-left: none; }
.cmp-btn-detail {
  font-family: 'Barlow', sans-serif !important; font-size: 14px !important;
  font-weight: 600 !important; letter-spacing: 0.5px !important;
  text-transform: none !important; background: transparent !important;
  color: var(--cmp-red) !important; border: 1.5px solid var(--cmp-red) !important;
  padding: 14px 16px !important; cursor: pointer; text-decoration: none !important;
  text-align: center; display: flex !important; align-items: center;
  justify-content: center; gap: 6px; transition: background .2s, color .2s;
  box-shadow: none !important; border-radius: 0 !important; line-height: 1.3 !important;
}
.cmp-btn-detail:hover { background: var(--cmp-red) !important; color: #fff !important; }

/* ══════════════════════════════
   MOBILE SLOTS BAR (< 640px)
══════════════════════════════ */
.cmp-mobile-slots {
  display: none;
  position: sticky; top: 0; z-index: 200;
  background: #fff; border-bottom: 2px solid var(--cmp-border);
  box-shadow: 0 2px 8px rgba(0,0,0,.08);
  overflow-x: auto; scrollbar-width: none;
}
.cmp-mobile-slots::-webkit-scrollbar { display: none; }
.cmp-mobile-slots-inner {
  display: flex; min-width: max-content;
  padding: 10px 12px; gap: 10px; align-items: stretch;
}
.cmp-mobile-slot {
  width: 100px; flex-shrink: 0;
  border: 1.5px solid var(--cmp-border);
  border-radius: 8px; overflow: hidden;
  display: flex; flex-direction: column;
  align-items: center; position: relative;
  background: #fff;
}
.cmp-mobile-slot.filled { border-color: var(--cmp-red); }
.cmp-mobile-slot-img {
  width: 80px; height: 50px; object-fit: contain;
  padding: 6px 4px; mix-blend-mode: multiply;
}
.cmp-mobile-slot-name {
  width: 100%; background: var(--cmp-red);
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 10px; font-weight: 800; color: #fff;
  text-transform: uppercase; text-align: center;
  padding: 4px 6px; line-height: 1.2;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.cmp-mobile-slot-remove {
  position: absolute; top: 3px; right: 3px;
  width: 16px; height: 16px; border-radius: 50%;
  background: rgba(0,0,0,.25); color: #fff;
  border: none; cursor: pointer; font-size: 9px;
  display: flex; align-items: center; justify-content: center;
  line-height: 1;
}
.cmp-mobile-slot-empty {
  width: 100px; height: 80px;
  border: 1.5px dashed #ccc; border-radius: 8px;
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  gap: 4px; cursor: pointer; flex-shrink: 0;
  color: var(--cmp-red); background: #fff;
  transition: border-color .2s, background .2s;
}
.cmp-mobile-slot-empty:hover { border-color: var(--cmp-red); background: #fff9f9; }
.cmp-mobile-slot-empty span {
  font-family: 'Rajdhani', sans-serif; font-size: 9px;
  font-weight: 700; letter-spacing: 1px; text-transform: uppercase;
  text-align: center; line-height: 1.3;
}

/* Mobile spec table — scrollable columns */
.cmp-mobile-body { display: none; padding: 0 0 40px; }

.cmp-mobile-section-title {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 13px; font-weight: 800; color: var(--cmp-red);
  text-transform: uppercase; letter-spacing: 2px;
  padding: 14px 14px 10px;
  border-top: 2px solid var(--cmp-red);
  border-bottom: 1px solid #fdd; background: #fff9f9;
}

/* Scrollable spec row on mobile */
.cmp-mobile-spec-row {
  border-bottom: 1px solid #f0f0f0;
  padding: 12px 14px;
}
.cmp-mobile-spec-key {
  font-size: 11px; font-weight: 700; color: #aaa;
  text-transform: uppercase; letter-spacing: .8px;
  margin-bottom: 8px;
}
.cmp-mobile-spec-vals {
  display: flex; gap: 8px;
}
.cmp-mobile-spec-val {
  flex: 1; min-width: 0;
  background: #f8f9fb; border-radius: 6px;
  padding: 8px 10px; font-size: 13px; font-weight: 600;
  color: var(--cmp-dark); text-align: center; line-height: 1.4;
}
.cmp-mobile-spec-val.empty { color: #ccc; font-weight: 400; font-style: italic; font-size: 12px; }
.cmp-mobile-spec-val-label {
  font-size: 9px; font-weight: 700; color: #bbb;
  text-transform: uppercase; letter-spacing: .5px;
  margin-bottom: 3px;
}

/* Mobile price row */
.cmp-mobile-price-row {
  display: flex; gap: 8px; padding: 14px;
  background: #fafafa; border-bottom: 2px solid var(--cmp-border);
  border-top: 2px solid var(--cmp-border);
}
.cmp-mobile-price-cell {
  flex: 1; text-align: center; padding: 10px 6px;
  background: #fff; border-radius: 8px; border: 1px solid #eee;
}
.cmp-mobile-price-label {
  font-size: 9px; color: #aaa; font-weight: 700;
  text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px;
}
.cmp-mobile-price-amount {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 16px; font-weight: 900; color: var(--cmp-red); line-height: 1;
}
.cmp-mobile-price-unit { font-size: 10px; color: #aaa; margin-top: 2px; }

/* Mobile CTA */
.cmp-mobile-cta-row {
  display: flex; gap: 8px; padding: 14px;
}
.cmp-mobile-cta-row a {
  flex: 1; padding: 12px 8px;
  border: 1.5px solid var(--cmp-red); color: var(--cmp-red);
  text-align: center; font-size: 12px; font-weight: 700;
  text-decoration: none; display: flex;
  align-items: center; justify-content: center;
  transition: background .2s, color .2s;
}
.cmp-mobile-cta-row a:hover { background: var(--cmp-red); color: #fff; }
.cmp-mobile-cta-placeholder {
  flex: 1; padding: 12px 8px; background: #f8f8f8;
  border: 1.5px dashed #ddd; border-radius: 4px;
}

/* ── PICKER MODAL ── */
.cmp-picker-backdrop {
  position: fixed; inset: 0; z-index: 9999;
  background: rgba(0,0,0,.6);
  display: none; align-items: flex-start; justify-content: flex-end;
  overflow-y: auto;
}
.cmp-picker-backdrop.open { display: flex; }
.cmp-picker-modal {
  background: #fff; width: 100%; max-width: 860px; min-height: 100vh;
  animation: cmpSlideIn .3s cubic-bezier(.22,1,.36,1);
}
@keyframes cmpSlideIn { from { opacity:0; transform: translateX(40px); } to { opacity:1; transform:none; } }
.cmp-picker-header {
  padding: 0 24px; border-bottom: 1px solid var(--cmp-border);
  display: flex; align-items: stretch; justify-content: space-between; min-height: 56px;
}
.cmp-picker-tabs { display: flex; }
.cmp-picker-tab {
  font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700;
  letter-spacing: 2px; text-transform: uppercase; color: var(--cmp-muted);
  padding: 0 20px; border: none; background: none; cursor: pointer;
  border-bottom: 2px solid transparent; transition: color .2s, border-color .2s;
  display: flex; align-items: center;
}
.cmp-picker-tab.active { color: var(--cmp-red); border-bottom-color: var(--cmp-red); }
.cmp-picker-close {
  background: var(--cmp-red); border: none; color: #fff;
  font-size: 22px; cursor: pointer; width: 56px;
  display: flex; align-items: center; justify-content: center;
  transition: background .2s; align-self: stretch; line-height: 1;
}
.cmp-picker-close:hover { background: var(--cmp-red-dk); }
.cmp-picker-body { padding: 24px; }
.cmp-picker-search-wrap { position: relative; margin-bottom: 24px; }
.cmp-picker-search {
  width: 100%; border: 1px solid #ddd; border-radius: 0;
  padding: 10px 40px 10px 16px;
  font-family: 'Barlow', sans-serif; font-size: 14px;
  box-sizing: border-box; outline: none; transition: border-color .2s; color: var(--cmp-dark);
}
.cmp-picker-search::placeholder { color: #bbb; }
.cmp-picker-search:focus { border-color: var(--cmp-red); }
.cmp-picker-search-icon {
  position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
  color: #bbb; pointer-events: none; font-size: 15px;
}
.cmp-picker-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0; }
.cmp-picker-card {
  padding: 20px 12px 16px; cursor: pointer; text-align: center;
  border: 1px solid transparent; position: relative; transition: border-color .2s;
}
.cmp-picker-card:hover { border-color: var(--cmp-red); }
.cmp-picker-card.selected { border-color: var(--cmp-red); background: #fff9f9; }
.cmp-picker-card.disabled { opacity: .3; cursor: not-allowed; pointer-events: none; }
.cmp-picker-car-img {
  width: 100%; height: 80px; object-fit: contain;
  mix-blend-mode: multiply; display: block; margin-bottom: 10px;
}
.cmp-picker-car-name {
  font-family: 'Barlow Condensed', sans-serif; font-size: 14px; font-weight: 800;
  color: var(--cmp-red); text-transform: uppercase; line-height: 1.2; margin-bottom: 2px;
}
.cmp-picker-car-price { font-family: 'Barlow', sans-serif; font-size: 11px; color: var(--cmp-muted); }
.cmp-picker-check {
  position: absolute; top: 8px; right: 8px;
  width: 18px; height: 18px; background: var(--cmp-red); border-radius: 50%;
  display: none; align-items: center; justify-content: center;
  color: #fff; font-size: 10px; line-height: 1;
}
.cmp-picker-card.selected .cmp-picker-check { display: flex; }
.cmp-picker-footer {
  padding: 16px 24px; border-top: 1px solid var(--cmp-border);
  display: flex; justify-content: center;
}
.cmp-picker-confirm {
  font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700;
  letter-spacing: 3px; text-transform: uppercase;
  background: transparent; color: var(--cmp-red); border: 1.5px solid var(--cmp-red);
  padding: 12px 40px; cursor: pointer; display: flex; align-items: center; gap: 10px;
  transition: background .2s, color .2s;
}
.cmp-picker-confirm:hover { background: var(--cmp-red); color: #fff; }

/* ── RESPONSIVE ── */
@media (max-width: 900px) {
  .cmp-spec-label-col, .cmp-price-label-cell, .cmp-cta-spacer, .cmp-label-spacer { width: 120px; }
  .cmp-picker-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 640px) {
  /* Ẩn desktop, hiện mobile */
  .cmp-sticky-header { display: none; }
  .cmp-body { display: none; }
  .cmp-mobile-slots { display: block; }
  .cmp-mobile-body { display: block; }

  .cmp-page-header { padding: 12px 16px; gap: 10px; }
  .cmp-page-title { font-size: 18px; }
  .cmp-back-link { font-size: 11px; }

  .cmp-picker-grid { grid-template-columns: repeat(2, 1fr); }
  .cmp-picker-modal { max-width: 100%; }
  .cmp-picker-body { padding: 16px; }
}
</style>
@endpush

@section('content')

@php
function cmpImg($val) {
    if (!$val) return null;
    $val = trim($val);
    if ($val === '') return null;
    if (preg_match('#^https?://#i', $val)) return $val;
    $val = ltrim($val, '/');
    return asset(implode('/', array_map(fn($s) => rawurlencode(rawurldecode($s)), explode('/', $val))));
}

$slotCars      = $slotCars   ?? collect();
$allCars       = $allCars    ?? collect();

$allCategories = collect();
foreach ($slotCars->filter() as $sc) {
    foreach ($sc->specs->groupBy('category') as $cat => $specs) {
        if (!$allCategories->has($cat)) $allCategories[$cat] = collect();
        foreach ($specs as $spec) {
            if (!$allCategories[$cat]->contains($spec->spec_key))
                $allCategories[$cat]->push($spec->spec_key);
        }
    }
}

$recScores = [];
for ($i = 0; $i < 3; $i++) {
    $car = $slotCars->get($i);
    $recScores[$i] = $car ? $car->specs->count() : 0;
}
$recMax    = max($recScores ?: [0]);
$recFilled = collect($recScores)->filter(fn($s) => $s > 0)->count();
@endphp

<div class="cmp-page-header" style="padding-top:24px;padding-bottom:24px;min-height:60px;">
    <a href="{{ route('cars.index') }}" class="cmp-back-link">‹ Quay về</a>
    <div class="cmp-page-title">So Sánh Sản Phẩm</div>
</div>

<div class="cmp-wrap">

    {{-- ══ DESKTOP: STICKY SLOTS ══ --}}
    <div class="cmp-sticky-header">
        <div class="cmp-slots-row">
            <div class="cmp-label-spacer"></div>
            @for($i = 0; $i < 3; $i++)
            @php $car = $slotCars->get($i); @endphp
            <div class="cmp-slot" id="slot-{{ $i }}">
                @if($car)
                    <button class="cmp-slot-remove" onclick="removeSlot({{ $i }})">✕</button>
                    @php
                        $img = null;
                        foreach (['image_url','image','hero_image'] as $_f) { $img = cmpImg($car->$_f ?? null); if ($img) break; }
                        if (!$img) { $dc = $car->colors->firstWhere('is_default',true) ?? $car->colors->first(); if ($dc) $img = cmpImg($dc->image ?? null); }
                    @endphp
                    @if($img)
                        <img class="cmp-slot-car-img" src="{{ $img }}" alt="{{ $car->name }}" onerror="this.style.display='none'">
                    @else
                        <div style="width:190px;height:110px;display:flex;align-items:center;justify-content:center;opacity:.1;">
                            <svg width="80" height="56" viewBox="0 0 80 56" fill="none"><rect x="4" y="12" width="52" height="36" rx="4" stroke="#333" stroke-width="2"/><polygon points="56,20 76,20 80,32 80,48 56,48" stroke="#333" stroke-width="2" fill="none"/><circle cx="18" cy="50" r="6" stroke="#333" stroke-width="2" fill="none"/><circle cx="62" cy="50" r="6" stroke="#333" stroke-width="2" fill="none"/></svg>
                        </div>
                    @endif
                    <div class="cmp-slot-name-bar">
                        <span class="cmp-slot-name">{{ $car->name }}</span>
                        <button class="cmp-slot-refresh" onclick="openPicker({{ $i }})">↺</button>
                    </div>
                    @if($car->variants->count())
                    <select class="cmp-slot-variant-select" onchange="updateSlotVariant({{ $i }}, this.value)">
                        @foreach($car->variants->unique('name') as $v)
                        <option value="{{ $v->id }}" {{ (request("variant_{$i}") == $v->id || ($loop->first && !request("variant_{$i}"))) ? 'selected' : '' }}>{{ $v->name }}</option>
                        @endforeach
                    </select>
                    @endif
                @else
                    <div class="cmp-slot-empty" onclick="openPicker({{ $i }})">
                        <svg width="72" height="56" viewBox="0 0 100 72" fill="none" opacity=".15">
                            <rect x="5" y="16" width="66" height="44" rx="5" stroke="#555" stroke-width="2.5"/>
                            <polygon points="71,26 96,26 100,40 100,60 71,60" stroke="#555" stroke-width="2.5" fill="none"/>
                            <circle cx="22" cy="63" r="8" stroke="#555" stroke-width="2.5" fill="none"/>
                            <circle cx="78" cy="63" r="8" stroke="#555" stroke-width="2.5" fill="none"/>
                            <line x1="40" y1="4" x2="40" y2="24" stroke="#d42b2b" stroke-width="3"/>
                            <line x1="30" y1="14" x2="50" y2="14" stroke="#d42b2b" stroke-width="3"/>
                        </svg>
                        <button class="cmp-slot-add-btn">CHỌN THÊM SẢN PHẨM +</button>
                    </div>
                @endif
            </div>
            @endfor
        </div>
    </div>

    {{-- ══ MOBILE: SLOTS BAR ══ --}}
    <div class="cmp-mobile-slots">
        <div class="cmp-mobile-slots-inner">
            @for($i = 0; $i < 3; $i++)
            @php $car = $slotCars->get($i); @endphp
            @if($car)
                @php
                    $img = null;
                    foreach (['image_url','image','hero_image'] as $_f) { $img = cmpImg($car->$_f ?? null); if ($img) break; }
                    if (!$img) { $dc = $car->colors->firstWhere('is_default',true) ?? $car->colors->first(); if ($dc) $img = cmpImg($dc->image ?? null); }
                @endphp
                <div class="cmp-mobile-slot filled" onclick="openPicker({{ $i }})">
                    <button class="cmp-mobile-slot-remove" onclick="event.stopPropagation();removeSlot({{ $i }})">✕</button>
                    @if($img)
                        <img class="cmp-mobile-slot-img" src="{{ $img }}" alt="{{ $car->name }}" onerror="this.style.display='none'">
                    @else
                        <div style="height:50px;display:flex;align-items:center;justify-content:center;font-size:22px;color:#ddd">🚗</div>
                    @endif
                    <div class="cmp-mobile-slot-name">{{ $car->name }}</div>
                </div>
            @else
                <div class="cmp-mobile-slot-empty" onclick="openPicker({{ $i }})">
                    <span style="font-size:20px;color:var(--cmp-red)">+</span>
                    <span>Thêm xe</span>
                </div>
            @endif
            @endfor
        </div>
    </div>

    {{-- ══ DESKTOP BODY ══ --}}
    <div class="cmp-body">
        {{-- GIÁ --}}
        <div class="cmp-price-block scroll-reveal">
            <div class="cmp-price-label-cell">Giá bán lẻ đề xuất</div>
            <div class="cmp-price-cells">
                @for($i = 0; $i < 3; $i++)
                @php
                    $car = $slotCars->get($i); $price = null;
                    if ($car) {
                        $vid = request("variant_{$i}");
                        $price = $car->price_per_day ?? $car->price;
                        if ($vid) { $v = $car->variants->firstWhere('id',$vid); if ($v) $price = $v->price; }
                        elseif ($car->variants->count()) $price = $car->variants->first()->price;
                    }
                @endphp
                <div class="cmp-price-cell">
                    @if($car && $price)
                        <div class="cmp-price-amount">{{ number_format($price) }}</div>
                        <div class="cmp-price-unit">VNĐ</div>
                    @endif
                </div>
                @endfor
            </div>
        </div>

        {{-- SPECS --}}
        @foreach($allCategories as $category => $specKeys)
        <div class="cmp-section-title scroll-reveal">{{ $category }}</div>
        @foreach($specKeys as $specKey)
        <div class="cmp-spec-group scroll-reveal">
            <div class="cmp-spec-label-col"><span class="cmp-spec-label">{{ $specKey }}</span></div>
            <div class="cmp-spec-values">
                @for($i = 0; $i < 3; $i++)
                @php
                    $car = $slotCars->get($i); $val = null;
                    if ($car) { $spec = $car->specs->where('category',$category)->where('spec_key',$specKey)->first(); $val = $spec?->spec_value; }
                @endphp
                <div class="cmp-spec-val {{ ($car && !$val) ? 'empty' : '' }}">
                    @if($car) {{ $val ?? 'Không có' }} @endif
                </div>
                @endfor
            </div>
        </div>
        @endforeach
        @endforeach

        {{-- RECOMMENDATION --}}
        @if($recFilled > 0)
        <div class="cmp-spec-group scroll-reveal" style="background:#fffdf7;border-top:2px solid #f0ebe1;border-bottom:2px solid #f0ebe1;">
            <div class="cmp-spec-label-col" style="padding:20px 20px 20px 24px;">
                <span class="cmp-spec-label" style="font-weight:700;color:#9a6f28;font-size:12px;letter-spacing:1.5px;text-transform:uppercase;line-height:1.5;">✦ Đánh giá</span>
            </div>
            <div class="cmp-spec-values">
                @for($i = 0; $i < 3; $i++)
                @php $car = $slotCars->get($i); @endphp
                <div class="cmp-spec-val" style="flex-direction:column;gap:6px;padding:20px;">
                    @if($car)
                        @if($recScores[$i] === $recMax && $recMax > 0)
                            <span style="display:inline-flex;align-items:center;gap:6px;background:#c9a84c;color:#fff;font-family:'Barlow Condensed',sans-serif;font-size:12px;font-weight:800;letter-spacing:2px;text-transform:uppercase;padding:5px 14px;">★ Được đề xuất</span>
                            <span style="font-family:'Barlow',sans-serif;font-size:12px;color:#888;font-weight:400;margin-top:4px;">{{ $recFilled === 1 ? 'Lựa chọn duy nhất' : 'Trang bị đầy đủ nhất' }}</span>
                        @else
                            <span style="font-family:'Barlow',sans-serif;font-size:13px;color:#aaa;font-style:italic;font-weight:400;">Phù hợp nhu cầu cơ bản</span>
                        @endif
                    @endif
                </div>
                @endfor
            </div>
        </div>
        @endif

        {{-- CTA --}}
        <div class="cmp-cta-block scroll-reveal">
            <div class="cmp-cta-spacer"></div>
            <div class="cmp-cta-cells">
                @for($i = 0; $i < 3; $i++)
                @php $car = $slotCars->get($i); @endphp
                <div class="cmp-cta-cell">
                    @if($car)
                        <a href="{{ route('cars.show', $car->id) }}" class="cmp-btn-detail">Xem chi tiết →</a>
                    @endif
                </div>
                @endfor
            </div>
        </div>
    </div>

    {{-- ══ MOBILE BODY ══ --}}
    <div class="cmp-mobile-body">

        {{-- Giá mobile --}}
        <div class="cmp-mobile-price-row">
            @for($i = 0; $i < 3; $i++)
            @php
                $car = $slotCars->get($i); $price = null;
                if ($car) {
                    $vid = request("variant_{$i}");
                    $price = $car->price_per_day ?? $car->price;
                    if ($vid) { $v = $car->variants->firstWhere('id',$vid); if ($v) $price = $v->price; }
                    elseif ($car->variants->count()) $price = $car->variants->first()->price;
                }
            @endphp
            <div class="cmp-mobile-price-cell">
                @if($car)
                    <div class="cmp-mobile-price-label">{{ $car->name }}</div>
                    @if($price)
                        <div class="cmp-mobile-price-amount">{{ number_format($price) }}</div>
                        <div class="cmp-mobile-price-unit">VNĐ</div>
                    @else
                        <div style="font-size:12px;color:#ccc;">—</div>
                    @endif
                @else
                    <div style="height:40px"></div>
                @endif
            </div>
            @endfor
        </div>

        {{-- Specs mobile --}}
        @foreach($allCategories as $category => $specKeys)
        <div class="cmp-mobile-section-title">{{ $category }}</div>
        @foreach($specKeys as $specKey)
        <div class="cmp-mobile-spec-row">
            <div class="cmp-mobile-spec-key">{{ $specKey }}</div>
            <div class="cmp-mobile-spec-vals">
                @for($i = 0; $i < 3; $i++)
                @php
                    $car = $slotCars->get($i); $val = null;
                    if ($car) { $spec = $car->specs->where('category',$category)->where('spec_key',$specKey)->first(); $val = $spec?->spec_value; }
                @endphp
                @if($car)
                <div class="cmp-mobile-spec-val {{ !$val ? 'empty' : '' }}">
                    <div class="cmp-mobile-spec-val-label">{{ \Illuminate\Support\Str::limit($car->name, 8) }}</div>
                    {{ $val ?? '—' }}
                </div>
                @endif
                @endfor
            </div>
        </div>
        @endforeach
        @endforeach

        {{-- CTA mobile --}}
        <div class="cmp-mobile-cta-row">
            @for($i = 0; $i < 3; $i++)
            @php $car = $slotCars->get($i); @endphp
            @if($car)
                <a href="{{ route('cars.show', $car->id) }}">Chi tiết →</a>
            @else
                <div class="cmp-mobile-cta-placeholder"></div>
            @endif
            @endfor
        </div>
    </div>

</div>

{{-- PICKER MODAL --}}
<div class="cmp-picker-backdrop" id="cmp-picker-backdrop">
    <div class="cmp-picker-modal">
        <div class="cmp-picker-header">
            <div class="cmp-picker-tabs">
                <button class="cmp-picker-tab active">Tất cả</button>
            </div>
            <button class="cmp-picker-close" onclick="closePicker()">✕</button>
        </div>
        <div class="cmp-picker-body">
            <div class="cmp-picker-search-wrap">
                <input type="text" class="cmp-picker-search" id="cmp-search"
                       placeholder="Nhập tên loại xe" oninput="filterPicker(this.value)">
                <span class="cmp-picker-search-icon">⌕</span>
            </div>
            <div class="cmp-picker-grid" id="cmp-picker-grid">
                @foreach($allCars as $pc)
                @php
                    $pImg = null;
                    foreach (['image_url','image','hero_image'] as $_f) { $pImg = cmpImg($pc->$_f ?? null); if ($pImg) break; }
                    if (!$pImg) { $pCol = $pc->colors->firstWhere('is_default',true) ?? $pc->colors->first(); if ($pCol) $pImg = cmpImg($pCol->image ?? null); }
                    $minP = $pc->variants->min('price') ?? $pc->price_per_day ?? $pc->price;
                @endphp
                <div class="cmp-picker-card"
                     data-car-id="{{ $pc->id }}"
                     data-car-name="{{ strtolower($pc->name) }}"
                     onclick="selectCar({{ $pc->id }})">
                    <div class="cmp-picker-check">✓</div>
                    @if($pImg)
                        <img class="cmp-picker-car-img" src="{{ $pImg }}" alt="{{ $pc->name }}" onerror="this.style.display='none'">
                    @else
                        <div style="height:80px;display:flex;align-items:center;justify-content:center;opacity:.12;margin-bottom:10px;">
                            <svg width="60" height="42" viewBox="0 0 80 56" fill="none"><rect x="4" y="12" width="52" height="36" rx="4" stroke="#333" stroke-width="2.5"/><polygon points="56,20 76,20 80,32 80,48 56,48" stroke="#333" stroke-width="2.5" fill="none"/><circle cx="18" cy="50" r="6" stroke="#333" stroke-width="2.5" fill="none"/><circle cx="62" cy="50" r="6" stroke="#333" stroke-width="2.5" fill="none"/></svg>
                        </div>
                    @endif
                    <div class="cmp-picker-car-name">{{ $pc->name }}</div>
                    <div class="cmp-picker-car-price">Giá từ {{ number_format($minP) }} VNĐ</div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="cmp-picker-footer">
            <button class="cmp-picker-confirm" onclick="confirmPicker()">XÁC NHẬN CHỌN →</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function() {
    'use strict';

    var reveals = document.querySelectorAll('.scroll-reveal');
    var obs = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                var el = entry.target;
                var idx = Array.from(reveals).indexOf(el);
                setTimeout(function() { el.classList.add('visible'); }, Math.min(idx * 40, 300));
                obs.unobserve(el);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
    reveals.forEach(function(el) { obs.observe(el); });

    var activeSlot = null;
    var pendingCarId = null;
    var currentSlots = [
        @for($i=0;$i<3;$i++){{ $slotCars->get($i)?->id ?? 'null' }},@endfor
    ];

    window.openPicker = function(slotIdx) {
        activeSlot = slotIdx;
        pendingCarId = currentSlots[slotIdx] || null;
        document.querySelectorAll('.cmp-picker-card').forEach(function(card) {
            var cid = parseInt(card.dataset.carId);
            var inOther = currentSlots.some(function(sid, i) { return sid === cid && i !== slotIdx; });
            card.classList.toggle('disabled', inOther);
            card.classList.toggle('selected', cid === pendingCarId);
        });
        document.getElementById('cmp-search').value = '';
        filterPicker('');
        document.getElementById('cmp-picker-backdrop').classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    window.closePicker = function() {
        document.getElementById('cmp-picker-backdrop').classList.remove('open');
        document.body.style.overflow = '';
        activeSlot = null; pendingCarId = null;
    };

    window.selectCar = function(carId) {
        pendingCarId = (pendingCarId === carId) ? null : carId;
        document.querySelectorAll('.cmp-picker-card').forEach(function(card) {
            card.classList.toggle('selected', parseInt(card.dataset.carId) === pendingCarId);
        });
    };

    window.confirmPicker = function() {
        if (activeSlot === null) return;
        var url = new URL(window.location.href);
        if (pendingCarId) {
            url.searchParams.set('slot' + activeSlot, pendingCarId);
            url.searchParams.delete('variant_' + activeSlot);
        } else {
            url.searchParams.delete('slot' + activeSlot);
            url.searchParams.delete('variant_' + activeSlot);
        }
        window.location.href = url.toString();
    };

    window.removeSlot = function(idx) {
        var url = new URL(window.location.href);
        url.searchParams.delete('slot' + idx);
        url.searchParams.delete('variant_' + idx);
        window.location.href = url.toString();
    };

    window.updateSlotVariant = function(idx, variantId) {
        var url = new URL(window.location.href);
        url.searchParams.set('variant_' + idx, variantId);
        window.location.href = url.toString();
    };

    window.filterPicker = function(q) {
        q = (q || '').toLowerCase().trim();
        document.querySelectorAll('.cmp-picker-card').forEach(function(card) {
            card.style.display = (!q || (card.dataset.carName || '').includes(q)) ? '' : 'none';
        });
    };

    document.getElementById('cmp-picker-backdrop').addEventListener('click', function(e) {
        if (e.target === this) closePicker();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePicker();
    });
})();
</script>
@endpush