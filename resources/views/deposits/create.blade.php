{{-- resources/views/deposits/create.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Đặt cọc - ' . $car->name . ' - AUTO X')

@section('hide_home_hero', true)

@php
    function depCarImgPath($val) {
        if (!$val) return null;
        $val = trim($val);
        if ($val === '') return null;
        if (preg_match('#^https?://#i', $val)) return $val;
        $val = ltrim($val, '/');
        $segments = explode('/', $val);
        $encoded  = array_map(fn($seg) => rawurlencode(rawurldecode($seg)), $segments);
        return asset(implode('/', $encoded));
    }

    $carImage = null;
    $defaultColor = $car->colors->firstWhere('is_default', true) ?? $car->colors->first();
    if ($defaultColor?->image) $carImage = depCarImgPath($defaultColor->image);
    if (!$carImage) {
        $gal = $car->galleries->where('type','image')
                ->filter(fn($g) => str_contains($g->file_path ?? '', '-TN'))
                ->sortBy('sort_order')->first();
        if ($gal?->file_path) $carImage = depCarImgPath($gal->file_path);
    }
    if (!$carImage) {
        $gal = $car->galleries->where('type','image')->sortBy('sort_order')->first();
        if ($gal?->file_path) $carImage = depCarImgPath($gal->file_path);
    }

    $rollingPrice = (int) request('rolling_price');
    $carPrice     = $rollingPrice > 0 ? $rollingPrice : ($car->price_per_day ?? $car->price ?? 0);
    $priceSource  = $rollingPrice > 0 ? 'rolling' : 'list';
    $brandName    = $car->brand?->name ?? '';

    $bankId      = config('payment.bank_id',    env('PAYMENT_BANK_ID',    'MB'));
    $bankAccount = config('payment.bank_account',env('PAYMENT_BANK_ACCOUNT','0328078853'));
    $bankName    = config('payment.bank_name',   env('PAYMENT_BANK_NAME',  'MB Bank'));
    $bankOwner   = config('payment.bank_owner',  env('PAYMENT_BANK_OWNER', 'VO MINH TAN'));

    $hasColors = $car->colors->isNotEmpty();
@endphp

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800;900&family=Barlow+Condensed:ital,wght@0,700;0,900;1,900&display=swap" rel="stylesheet">
<style>
/* ── BASE ── */
.dep-page { background: #f4f4f2; min-height: 100vh; padding: 0 0 100px; font-family: 'Be Vietnam Pro', sans-serif; }
.dep-container { max-width: 1120px; margin: 0 auto; padding: 0 40px; }

/* ── CAR BANNER ── */
.dep-car-banner { background: #111; border-bottom: 2px solid #222; padding: 22px 0 18px; margin-bottom: 26px; position: relative; overflow: hidden; }
.dep-car-banner::before { content:''; position:absolute; inset:0; background:rgba(0,0,0,.5); }
.dep-car-banner-inner { position:relative; z-index:1; max-width:1120px; margin:0 auto; padding:0 40px; display:flex; align-items:center; justify-content:space-between; gap:20px; flex-wrap:wrap; }
.dep-car-banner-badge { display:inline-block; font-size:9px; font-weight:800; letter-spacing:3px; text-transform:uppercase; color:#d4a017; background:rgba(0,0,0,.6); border:1px solid rgba(212,160,23,.3); padding:3px 10px; border-radius:2px; margin-bottom:7px; }
.dep-car-banner-label { font-size:10px; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:rgba(255,255,255,.6); margin-bottom:4px; }
.dep-car-banner-name { font-family:'Barlow Condensed',sans-serif; font-size:clamp(22px,3.5vw,36px); font-weight:900; color:#fff; text-transform:uppercase; letter-spacing:-1px; line-height:1; }
.dep-car-banner-price-label { font-size:10px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:rgba(255,255,255,.55); margin-bottom:3px; text-align:right; }
.dep-car-banner-price { font-family:'Barlow Condensed',sans-serif; font-size:clamp(22px,3.5vw,38px); font-weight:900; color:#f0c040; line-height:1; }
.dep-car-banner-price small { font-family:'Be Vietnam Pro',sans-serif; font-size:13px; color:rgba(255,255,255,.5); margin-left:3px; font-weight:500; }
.dep-car-banner-img { position:absolute; right:0; top:0; height:100%; max-width:320px; object-fit:cover; object-position:left center; opacity:.1; pointer-events:none; }

.dep-back { font-size:11px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:#777; text-decoration:none; display:inline-flex; align-items:center; gap:6px; margin-bottom:14px; transition:color .2s; }
.dep-back:hover { color: #111; }

.dep-title { font-family:'Barlow Condensed',sans-serif; font-size:clamp(28px,4vw,42px); font-weight:900; text-transform:uppercase; color:#111; letter-spacing:-1px; line-height:1.1; margin-bottom:10px; }
.dep-title em { color:#c00; font-style:normal; text-decoration:none; }
.dep-subtitle { font-size:10px; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:#777; margin-bottom:26px; display:flex; align-items:center; gap:8px; }
.dep-subtitle::before { content:''; width:16px; height:2px; background:#c00; }

.dep-grid { display: grid; grid-template-columns: 1fr 370px; gap: 22px; align-items: start; }

/* ── CARD ── */
.dep-card { background: #fff; border-top: 3px solid #1a1a1a; border-radius: 0 0 4px 4px; padding: 26px 28px; margin-bottom: 14px; box-shadow: 0 1px 4px rgba(0,0,0,.05); }
.dep-card-title { font-family: 'Barlow Condensed', sans-serif; font-size: 19px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; color: #111; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 10px; }
.dep-card-title .step-num { font-size: 11px; background: #1a1a1a; color: #fff; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center; font-family: 'Be Vietnam Pro', sans-serif; font-weight: 800; flex-shrink: 0; border-radius: 3px; }

/* ── FORM FIELDS ── */
.dep-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.dep-form-row.full { grid-template-columns: 1fr; }
.dep-field { margin-bottom: 14px; }
.dep-label { font-size: 10px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: #555; margin-bottom: 6px; display: block; }
.dep-label .req { color: #c00; }
.dep-input { width: 100%; padding: 9px 13px; border: 1.5px solid #e2e2e2; background: #fafafa; font-family: 'Be Vietnam Pro', sans-serif; font-size: 14px; font-weight: 500; color: #111; box-sizing: border-box; outline: none; border-radius: 5px; transition: border-color .2s, background .2s; }
.dep-input:focus { border-color: #888; background: #fff; }
.dep-input.invalid { border-color: #ef4444; }
.dep-error { color: #ef4444; font-size: 11px; margin-top: 4px; display: block; font-weight: 500; }
textarea.dep-input { resize: vertical; min-height: 88px; }

/* ── CUSTOM DROPDOWN ── */
.dep-custom-select { position: relative; user-select: none; }
.dep-custom-select-trigger {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 14px; border: 1.5px solid #e2e2e2; background: #fafafa;
    border-radius: 6px; cursor: pointer; transition: border-color .2s, background .2s;
    font-family: 'Be Vietnam Pro', sans-serif; font-size: 13px; font-weight: 500; color: #111;
    gap: 10px;
}
.dep-custom-select-trigger:hover { border-color: #bbb; background: #f5f5f5; }
.dep-custom-select.open .dep-custom-select-trigger { border-color: #888; background: #fff; border-bottom-left-radius: 0; border-bottom-right-radius: 0; }
.dep-custom-select-trigger-text { flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.dep-custom-select-trigger-text.placeholder { color: #aaa; font-weight: 400; }
.dep-custom-select-arrow { width: 18px; height: 18px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; transition: transform .22s cubic-bezier(.4,0,.2,1); color: #999; }
.dep-custom-select.open .dep-custom-select-arrow { transform: rotate(180deg); }
.dep-custom-select-dropdown {
    position: absolute; top: 100%; left: 0; right: 0; z-index: 999;
    background: #fff; border: 1.5px solid #888; border-top: none;
    border-radius: 0 0 8px 8px;
    max-height: 0; overflow-y: auto;
    transition: max-height .25s cubic-bezier(.4,0,.2,1), box-shadow .2s;
    box-shadow: none;
}
.dep-custom-select.open .dep-custom-select-dropdown { max-height: 260px; box-shadow: 0 8px 24px rgba(0,0,0,.12); }
.dep-custom-select-group-label { font-size: 9px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; color: #c00; padding: 8px 14px 4px; background: #fafafa; border-bottom: 1px solid #f0f0f0; border-top: 1px solid #f0f0f0; margin-top: 2px; }
.dep-custom-select-group-label:first-child { border-top: none; margin-top: 0; }
.dep-custom-select-search { padding: 8px 10px; border-bottom: 1px solid #f0f0f0; position: sticky; top: 0; background: #fff; z-index: 1; }
.dep-custom-select-search input { width: 100%; padding: 7px 10px; border: 1.5px solid #e2e2e2; border-radius: 5px; font-family: 'Be Vietnam Pro', sans-serif; font-size: 13px; font-weight: 500; color: #111; outline: none; box-sizing: border-box; background: #fafafa; transition: border-color .2s; }
.dep-custom-select-search input:focus { border-color: #888; background: #fff; }
.dep-custom-select-option.hidden { display: none; }
.dep-custom-select-option { padding: 9px 14px 9px 22px; cursor: pointer; font-size: 13px; font-weight: 500; color: #333; transition: background .13s, color .13s; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid #f5f5f5; }
.dep-custom-select-option:last-child { border-bottom: none; }
.dep-custom-select-option:hover { background: #f5f5f3; color: #111; }
.dep-custom-select-option.selected { background: #f0f0ee; color: #111; font-weight: 700; }
.dep-custom-select-option.selected::before { content: '✓'; font-size: 11px; color: #c00; width: 14px; flex-shrink: 0; margin-left: -14px; }

/* ── NATIVE SELECT (rolling calc) ── */
.dep-native-select {
    width: 100%; padding: 10px 36px 10px 14px; border: 1.5px solid #e2e2e2; background: #fafafa;
    border-radius: 6px; font-family: 'Be Vietnam Pro', sans-serif; font-size: 13px; font-weight: 500;
    color: #111; outline: none; cursor: pointer; box-sizing: border-box;
    appearance: none; -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23999' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 10px center;
    transition: border-color .2s, background-color .2s;
}
.dep-native-select:focus { border-color: #888; background-color: #fff; }
.dep-native-select option { font-weight: 500; }
.dep-native-select optgroup { font-size: 11px; font-weight: 800; color: #c00; }


.dep-rolling-calc { border:1.5px solid #fde68a; border-radius:8px; margin-bottom:20px; overflow:hidden; }
.dep-rolling-calc-trigger {
    display:flex; align-items:center; justify-content:space-between;
    padding:11px 16px; background:#fffbeb; cursor:pointer;
    font-size:12px; font-weight:800; letter-spacing:1.5px; text-transform:uppercase;
    color:#b45309; user-select:none; transition:background .18s; gap:10px;
}
.dep-rolling-calc-trigger:hover { background:#fef3c7; }
.dep-rolling-calc.open .dep-rolling-calc-trigger { border-bottom:1px solid #fde68a; }
.dep-rolling-calc-body {
    max-height:0; overflow:hidden;
    transition:max-height .3s cubic-bezier(.4,0,.2,1);
    background:#fffbeb;
}
.dep-rolling-calc.open .dep-rolling-calc-body { max-height:420px; }
.dep-rolling-selects { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:12px; padding:14px 16px 0; }
.dep-rolling-label { font-size:10px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#92400e; display:block; margin-bottom:5px; }
.dep-rolling-calc-btn { padding:10px; background:#b45309; color:#fff; border:none; cursor:pointer; font-family:'Be Vietnam Pro',sans-serif; font-size:11px; font-weight:800; letter-spacing:2px; text-transform:uppercase; transition:background .2s; margin:0 16px 14px; width:calc(100% - 32px); border-radius:6px; }
.dep-rolling-calc-btn:hover { background:#92400e; }
.dep-rolling-result { display:none; margin:0 16px 14px; padding:10px 12px; background:#fff; border:1.5px solid #fde68a; border-radius:6px; }
.dep-rolling-result-row { display:flex; justify-content:space-between; align-items:center; }
.dep-rolling-result-label { font-size:11px; font-weight:700; color:#b45309; text-transform:uppercase; letter-spacing:1px; }
.dep-rolling-result-val { font-family:'Barlow Condensed',sans-serif; font-size:20px; font-weight:900; color:#b45309; }
.dep-rolling-result-note { font-size:10px; color:#aaa; margin-top:4px; }
.dep-rolling-breakdown { margin:0 16px 0; padding:0 0 14px; }
.dep-rolling-breakdown-row { display:flex; justify-content:space-between; font-size:11px; color:#92400e; padding:3px 0; }
.dep-rolling-breakdown-row .rbl { font-weight:500; }
.dep-rolling-breakdown-row .rbv { font-weight:700; }
.dep-rolling-breakdown-row.total { border-top:1px solid #fde68a; margin-top:4px; padding-top:6px; font-size:13px; }
.dep-rolling-breakdown-row.total .rbl { font-weight:800; }
.dep-rolling-breakdown-row.total .rbv { font-weight:900; color:#b45309; }

/* ── COLOR PICKER ── */
.dep-color-grid { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 6px; }
.dep-color-opt { position: relative; cursor: pointer; }
.dep-color-opt input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
.dep-color-swatch { display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 8px 10px; border: 2px solid #e2e2e2; border-radius: 8px; background: #fafafa; transition: all .18s; min-width: 70px; }
.dep-color-dot { width: 28px; height: 28px; border-radius: 50%; border: 2px solid rgba(0,0,0,.1); flex-shrink: 0; }
.dep-color-name { font-size: 10px; font-weight: 700; color: #555; text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 80px; }
.dep-color-opt input:checked + .dep-color-swatch { border-color: #1a1a1a; background: #f0f0ee; box-shadow: 0 0 0 2px rgba(0,0,0,.08); }
.dep-color-opt input:checked + .dep-color-swatch .dep-color-name { color: #111; font-weight: 800; }

/* ── SLIDER ── */
.dep-slider-wrap { margin-bottom: 16px; }
.dep-slider-row { display: flex; align-items: center; gap: 14px; margin-bottom: 10px; }
.dep-slider-edge { font-size: 11px; font-weight: 700; color: #aaa; white-space: nowrap; }
.dep-slider { flex: 1; -webkit-appearance: none; appearance: none; height: 6px; border-radius: 3px; background: linear-gradient(to right, #1a1a1a 40%, #e2e2e2 40%); outline: none; cursor: pointer; transition: background .1s; }
.dep-slider::-webkit-slider-thumb { -webkit-appearance: none; width: 22px; height: 22px; border-radius: 50%; background: #1a1a1a; border: 3px solid #fff; box-shadow: 0 1px 6px rgba(0,0,0,.25); cursor: pointer; }
.dep-slider::-moz-range-thumb { width: 22px; height: 22px; border-radius: 50%; background: #1a1a1a; border: 3px solid #fff; box-shadow: 0 1px 6px rgba(0,0,0,.25); cursor: pointer; }
.dep-pct-display { text-align: center; margin-bottom: 14px; line-height: 1; }
.dep-pct-display-num { font-family: 'Barlow Condensed', sans-serif; font-size: 52px; font-weight: 900; color: #1a1a1a; }
.dep-pct-display-unit { font-size: 13px; color: #aaa; font-weight: 500; margin-left: 4px; }

/* ── AMOUNT BOX ── */
.dep-amount-box { background: #f8f8f8; border: 1.5px solid #e2e2e2; border-radius: 8px; padding: 14px 16px; margin-bottom: 6px; }
.dep-amount-box-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
.dep-amount-display-label { font-size: 12px; font-weight: 600; color: #666; }
.dep-amount-display-val { font-family: 'Barlow Condensed', sans-serif; font-size: 26px; font-weight: 900; color: #c00; }
.dep-amount-manual-row { display: flex; align-items: center; gap: 8px; padding-top: 10px; border-top: 1px solid #eaeaea; }
.dep-amount-manual-label { font-size: 10px; font-weight: 700; color: #bbb; letter-spacing: 1px; text-transform: uppercase; white-space: nowrap; }
.dep-amount-manual-input { flex: 1; padding: 7px 11px; border: 1.5px solid #e2e2e2; border-radius: 5px; font-family: 'Be Vietnam Pro', sans-serif; font-size: 14px; font-weight: 600; color: #111; outline: none; background: #fff; transition: border-color .2s; }
.dep-amount-manual-input:focus { border-color: #888; }
.dep-amount-manual-unit { font-size: 13px; font-weight: 700; color: #777; }
.dep-amount-min-warn { display: none; font-size: 11px; color: #ef4444; font-weight: 600; margin-top: 6px; }

.dep-hint { font-size: 11px; color: #888; margin-bottom: 20px; font-weight: 500; }

/* ── PAYMENT OPTIONS ── */
.dep-payment-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 10px; }
.dep-pay-opt { display: flex; align-items: center; gap: 10px; padding: 11px 13px; border: 1.5px solid #e2e2e2; background: #fafafa; cursor: pointer; border-radius: 6px; transition: all .18s; }
.dep-pay-opt:has(input:checked) { border-color: #1a1a1a; background: #f5f5f3; }
.dep-pay-opt input { accent-color: #111; width: 15px; height: 15px; flex-shrink: 0; }
.dep-pay-icon { font-size: 18px; flex-shrink: 0; }
.dep-pay-name { font-family: 'Barlow Condensed', sans-serif; font-size: 16px; font-weight: 700; color: #111; text-transform: uppercase; line-height: 1.1; }
.dep-pay-desc { font-size: 10px; color: #888; font-weight: 500; margin-top: 1px; }

/* ── TERMS ── */
.dep-terms { display: flex; gap: 12px; align-items: flex-start; padding: 14px 16px; background: #f8f7f5; border-left: 3px solid #ddd; border-radius: 0 4px 4px 0; margin-bottom: 4px; }
.dep-terms input { width: 15px; height: 15px; accent-color: #c00; margin-top: 3px; flex-shrink: 0; }
.dep-terms-text { font-size: 13px; color: #777; line-height: 1.7; font-weight: 400; }
.dep-terms-text a { color: #c00; font-weight: 600; }

/* ── SUBMIT ── */
.dep-submit { width: 100%; padding: 15px; background: #1a1a1a; color: #fff; border: none; border-radius: 6px; font-family: 'Be Vietnam Pro', sans-serif; font-size: 13px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; cursor: pointer; transition: background .2s, transform .15s; margin-top: 16px; display: flex; align-items: center; justify-content: center; gap: 10px; }
.dep-submit:hover:not(:disabled) { background: #c00; transform: translateY(-1px); }
.dep-submit:disabled { opacity: .4; cursor: not-allowed; transform: none; }

/* ── QR MODAL OVERLAY ── */
.dep-qr-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.65); z-index: 9999; align-items: center; justify-content: center; padding: 16px; backdrop-filter: blur(4px); }
.dep-qr-overlay.active { display: flex; }
.dep-qr-modal { background: #fff; border-radius: 20px; max-width: 380px; width: 100%; overflow: hidden; box-shadow: 0 32px 80px rgba(0,0,0,.35); animation: qrSlideUp .3s cubic-bezier(.22,1,.36,1); max-height: 95vh; display: flex; flex-direction: column; }
@keyframes qrSlideUp { from{transform:translateY(50px) scale(.97);opacity:0} to{transform:translateY(0) scale(1);opacity:1} }
.dep-qr-modal-header { background: linear-gradient(135deg, #111 0%, #1e1e1e 100%); padding: 20px 22px 18px; text-align: center; position: relative; flex-shrink: 0; }
.dep-qr-modal-header::after { content:''; position:absolute; bottom:0; left:50%; transform:translateX(-50%); width:40px; height:3px; background:#d4a017; border-radius:2px 2px 0 0; }
.dep-qr-header-bank { display:inline-flex; align-items:center; gap:6px; background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.12); border-radius:20px; padding:4px 12px; margin-bottom:10px; }
.dep-qr-header-bank span { font-size:10px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:rgba(255,255,255,.6); }
.dep-qr-header-amount-label { font-size:9px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:rgba(255,255,255,.35); margin-bottom:4px; }
.dep-qr-modal-header .pay-amount { font-family:'Barlow Condensed',sans-serif; font-size:42px; font-weight:900; color:#f0c040; line-height:1; }
.dep-qr-modal-header .pay-amount small { font-family:'Be Vietnam Pro',sans-serif; font-size:15px; font-weight:600; color:rgba(255,255,255,.4); margin-left:4px; }
.dep-qr-body { padding: 18px 20px 20px; text-align: center; overflow-y: auto; flex: 1; }
.dep-qr-img-wrap { display: inline-block; padding: 0; border-radius: 16px; margin-bottom: 16px; background: #fff; box-shadow: 0 4px 24px rgba(0,0,0,.13), 0 0 0 1px rgba(0,0,0,.06); overflow: hidden; }
.dep-qr-img-wrap img { width: 260px; height: auto; display: block; }
.dep-qr-bank-info { background: #f7f7f6; border-radius: 12px; padding: 4px 0; margin-bottom: 14px; text-align: left; overflow:hidden; }
.dep-qr-bank-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 16px; border-bottom: 1px solid rgba(0,0,0,.05); }
.dep-qr-bank-row:last-child { border-bottom: none; }
.dep-qr-bank-row .lbl { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: #bbb; flex-shrink:0; margin-right:12px; }
.dep-qr-bank-row .val { font-size: 14px; font-weight: 800; color: #111; font-family: 'Be Vietnam Pro', sans-serif; text-align:right; }
.dep-qr-content-edit { width:100%; border:none; background:transparent; font-family:'Be Vietnam Pro',sans-serif; font-size:14px; font-weight:800; color:#c00; text-align:right; outline:none; padding:0; }
.dep-qr-content-edit::placeholder { color:#ccc; font-weight:500; }
.dep-qr-note { font-size: 11.5px; color: #aaa; line-height: 1.6; margin-bottom: 14px; font-weight: 500; text-align:left; background:#fffbeb; border-left:3px solid #fbbf24; padding:10px 12px; border-radius:0 8px 8px 0; }
.dep-qr-note strong { color: #b45309; }
.dep-qr-timer { display: inline-flex; align-items: center; gap: 7px; font-size: 11px; font-weight: 700; color: #f59e0b; margin-bottom: 14px; background:#fffbeb; border:1px solid #fde68a; border-radius:20px; padding:5px 14px; }
.dep-qr-timer span { font-family: 'Barlow Condensed', sans-serif; font-size: 18px; font-weight: 900; }
.dep-qr-confirm { width: 100%; padding: 14px; background: linear-gradient(135deg,#16a34a,#15803d); color: #fff; border: none; border-radius: 10px; font-family: 'Be Vietnam Pro', sans-serif; font-size: 13px; font-weight: 800; cursor: pointer; transition: opacity .18s, transform .15s; display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 8px; letter-spacing:.5px; }
.dep-qr-confirm:hover { opacity:.9; transform:translateY(-1px); }
.dep-qr-cancel { width: 100%; padding: 10px; background: transparent; color: #bbb; border: 1.5px solid #ebebeb; border-radius: 10px; font-family: 'Be Vietnam Pro', sans-serif; font-size: 12px; font-weight: 700; cursor: pointer; transition: all .18s; }
.dep-qr-cancel:hover { border-color: #ccc; color: #555; }
.dep-qr-status { text-align:center; padding: 10px 0 6px; }
.dep-qr-status-text { font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 7px; }
.dep-qr-status-text.success { color: #16a34a; }

/* ── SIDEBAR ── */
.dep-sidebar { position: sticky; top: 90px; }
.dep-car-card { background: #0d0d0f; overflow: hidden; border-radius: 6px; box-shadow: 0 4px 20px rgba(0,0,0,.15); }
.dep-car-img-wrap { position: relative; height: 200px; overflow: hidden; background: #111; }
.dep-car-img-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .5s, opacity .3s; }
.dep-car-img-wrap:hover img { transform: scale(1.04); }
.dep-car-img-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,.75) 0%, transparent 60%); }
.dep-car-brand-badge { position: absolute; top: 10px; left: 10px; font-size: 9px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; color: #f0c040; background: rgba(0,0,0,.75); border: 1px solid rgba(240,192,64,.4); padding: 4px 10px; border-radius: 3px; }
.dep-car-info { padding: 20px 22px; }
.dep-car-name { font-family: 'Barlow Condensed', sans-serif; font-size: 28px; font-weight: 900; text-transform: uppercase; color: #fff; letter-spacing: -1px; line-height: 1; margin-bottom: 4px; }
.dep-car-price { font-family: 'Barlow Condensed', sans-serif; font-size: 32px; font-weight: 900; color: #f0c040; line-height: 1; margin-bottom: 16px; }
.dep-car-price small { font-family: 'Be Vietnam Pro', sans-serif; font-size: 12px; color: rgba(255,255,255,.5); margin-left: 3px; }
.dep-summary { border-top: 1px solid rgba(255,255,255,.1); padding-top: 16px; }
.dep-summary-title { font-size: 9px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; color: rgba(255,255,255,.5); margin-bottom: 10px; }
.dep-summary-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,.08); }
.dep-summary-row:last-child { border-bottom: none; padding-top: 12px; }
.dep-summary-label { font-size: 13px; color: rgba(255,255,255,.7); font-weight: 500; }
.dep-summary-value { font-family: 'Barlow Condensed', sans-serif; font-size: 17px; font-weight: 700; color: #fff; }
.dep-summary-value.red { color: #d4a017; font-size: 22px; }
.dep-summary-pct { font-size: 9px; font-weight: 700; background: rgba(212,160,23,.25); color: #f0c040; padding: 2px 7px; border-radius: 20px; margin-left: 5px; }
.dep-sidebar-color { display: flex; align-items: center; gap: 8px; padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,.08); }
.dep-sidebar-color-dot { width: 14px; height: 14px; border-radius: 50%; border: 1.5px solid rgba(255,255,255,.2); flex-shrink: 0; }
.dep-sidebar-color-name { font-size: 13px; color: rgba(255,255,255,.7); font-weight: 500; }
.dep-sidebar-color-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,.35); margin-right: auto; }
.dep-pledge { background: rgba(34,197,94,.08); border: 1px solid rgba(34,197,94,.25); padding: 14px 16px; margin-top: 16px; border-radius: 6px; }
.dep-pledge-title { font-size: 9px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; color: #4ade80; margin-bottom: 10px; }
.dep-pledge ul { margin: 0; padding-left: 16px; }
.dep-pledge ul li { font-size: 13px; color: rgba(255,255,255,.75); line-height: 2; font-weight: 500; }
.dep-hotline { text-align: center; padding: 14px 20px; border-top: 1px solid rgba(255,255,255,.1); }
.dep-hotline-label { font-size: 9px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; color: rgba(255,255,255,.5); margin-bottom: 3px; }
.dep-hotline a { font-family: 'Barlow Condensed', sans-serif; font-size: 26px; font-weight: 900; color: #fff; text-decoration: none; transition: color .2s; }
.dep-hotline a:hover { color: #d4a017; }

/* ── ALERTS ── */
.dep-alert-err { background: #fee2e2; border-left: 3px solid #ef4444; border-radius: 0 5px 5px 0; padding: 13px 16px; margin-bottom: 14px; font-size: 13px; color: #991b1b; font-weight: 500; }

@media (max-width: 920px) {
    .dep-grid { grid-template-columns: 1fr; }
    .dep-sidebar { position: static; }
    .dep-container { padding: 0 16px; }
    .dep-form-row { grid-template-columns: 1fr; }
    .dep-payment-grid { grid-template-columns: 1fr; }
    .dep-car-banner-inner { flex-direction: column; align-items: flex-start; gap: 10px; }
    .dep-car-banner-inner > div:last-child { text-align: left; }
    .dep-car-banner { padding: 18px 0 14px; }
    .dep-color-grid { gap: 8px; }
    .dep-color-swatch { min-width: 60px; padding: 6px 8px; }
    .dep-rolling-selects { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="dep-page">

{{-- ── BANNER ── --}}
<div class="dep-car-banner" @if($carImage) style="background-image:url('{{ $carImage }}')" @endif>
    @if($carImage)<img class="dep-car-banner-img" src="{{ $carImage }}" alt="{{ $car->name }}">@endif
    <div class="dep-car-banner-inner">
        <div>
            @if($brandName)<div class="dep-car-banner-badge">{{ $brandName }}</div>@endif
            <div class="dep-car-banner-label">Đặt cọc xe</div>
            <div class="dep-car-banner-name">{{ $car->name }}</div>
        </div>
        <div style="text-align:right">
            <div class="dep-car-banner-price-label">{{ $priceSource === 'rolling' ? 'Giá lăn bánh (từ dự toán)' : 'Giá niêm yết' }}</div>
            @if($carPrice > 0)
                <div class="dep-car-banner-price">{{ number_format($carPrice) }}<small>VNĐ</small></div>
            @else
                <div class="dep-car-banner-price" style="font-size:18px;color:rgba(255,255,255,.3)">Liên hệ báo giá</div>
            @endif
        </div>
    </div>
</div>

<div class="dep-container">

    <a href="{{ url()->previous() }}" class="dep-back">← Quay lại</a>

    <div class="dep-title">Đặt <em>Cọc</em> — {{ $car->name }}</div>
    <div class="dep-subtitle">AUTO X Showroom · Đăng ký giữ chỗ</div>

    @if(session('error'))
        <div class="dep-alert-err">⚠️ {{ session('error') }}</div>
    @endif

    <div class="dep-grid">

        {{-- ====== CỘT TRÁI: Form ====== --}}
        <div>
            <form action="{{ route('deposits.store', $car->slug) }}" method="POST" id="dep-form">
                @csrf

                {{-- THÔNG TIN KHÁCH HÀNG --}}
                <div class="dep-card">
                    <div class="dep-card-title"><span class="step-num">1</span> Thông tin khách hàng</div>
                    <div class="dep-form-row full">
                        <div class="dep-field">
                            <label class="dep-label">Họ và tên <span class="req">*</span></label>
                            <input type="text" name="customer_name"
                                class="dep-input @error('customer_name') invalid @enderror"
                                value="{{ old('customer_name') }}" placeholder="Nguyễn Văn A" required>
                            @error('customer_name')<span class="dep-error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="dep-form-row">
                        <div class="dep-field">
                            <label class="dep-label">Email <span class="req">*</span></label>
                            <input type="email" name="customer_email"
                                class="dep-input @error('customer_email') invalid @enderror"
                                value="{{ old('customer_email') }}" placeholder="example@email.com" required>
                            @error('customer_email')<span class="dep-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="dep-field">
                            <label class="dep-label">Số điện thoại <span class="req">*</span></label>
                            <input type="tel" name="customer_phone"
                                class="dep-input @error('customer_phone') invalid @enderror"
                                value="{{ old('customer_phone') }}" placeholder="0912 345 678" required>
                            @error('customer_phone')<span class="dep-error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="dep-form-row" style="margin-bottom:0">
                        <div class="dep-field" style="margin-bottom:0">
                            <label class="dep-label">CCCD / CMND</label>
                            <input type="text" name="customer_id_card"
                                class="dep-input @error('customer_id_card') invalid @enderror"
                                value="{{ old('customer_id_card') }}" placeholder="012345678910">
                            @error('customer_id_card')<span class="dep-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="dep-field" style="margin-bottom:0">
                            <label class="dep-label">Địa chỉ</label>
                            <input type="text" name="customer_address"
                                class="dep-input @error('customer_address') invalid @enderror"
                                value="{{ old('customer_address') }}" placeholder="Quận/Huyện, Tỉnh/Thành">
                            @error('customer_address')<span class="dep-error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                {{-- THÔNG TIN ĐẶT CỌC --}}
                <div class="dep-card">
                    <div class="dep-card-title"><span class="step-num">2</span> Thông tin đặt cọc</div>

                    {{-- ── Giá box — FIX: thêm id vào label và subtext ── --}}
                    @if($carPrice > 0)
                    <div style="background:#f9f9f7;border:1.5px solid #e2e2e2;border-radius:6px;padding:10px 16px;margin-bottom:16px;display:flex;align-items:center;justify-content:space-between;gap:12px;">
                        <div>
                            <span id="dep-price-box-label" style="font-size:9px;font-weight:800;color:#aaa;text-transform:uppercase;letter-spacing:1.5px;display:block;">
                                {{ $priceSource === 'rolling' ? 'Giá lăn bánh (từ dự toán)' : 'Giá niêm yết tham khảo' }}
                            </span>
                            @if($priceSource === 'rolling')
                                <span id="dep-price-box-sub" style="font-size:10px;color:#16a34a;font-weight:600;">✓ Đã bao gồm thuế, phí, đăng ký</span>
                            @else
                                <span id="dep-price-box-sub" style="font-size:10px;color:#f59e0b;font-weight:600;">⚠ Chưa bao gồm phí lăn bánh</span>
                            @endif
                        </div>
                        <span id="dep-display-price" style="font-family:'Barlow Condensed',sans-serif;font-size:22px;font-weight:900;color:{{ $priceSource === 'rolling' ? '#16a34a' : '#111' }};white-space:nowrap;">
                            {{ number_format($carPrice) }}<span style="font-size:12px;color:#bbb;margin-left:3px;font-family:'Be Vietnam Pro',sans-serif;font-weight:500;">đ</span>
                        </span>
                    </div>
                    @endif

                    {{-- ── BLOCK TÍNH LĂN BÁNH (chỉ hiện khi chưa có rolling_price) ── --}}
                    @if($priceSource !== 'rolling' && $carPrice > 0)
                    <div class="dep-rolling-calc" id="dep-rolling-calc-wrap">
                        <div class="dep-rolling-calc-trigger" onclick="depToggleRolling()">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                <span>Tính phí lăn bánh</span>
                                <span style="font-size:9px;font-weight:700;background:rgba(180,83,9,.15);color:#b45309;padding:2px 8px;border-radius:20px;letter-spacing:1px;text-transform:uppercase;">Tuỳ chọn</span>
                            </div>
                            <svg id="dep-rolling-arrow" style="width:16px;height:16px;transition:transform .22s cubic-bezier(.4,0,.2,1);flex-shrink:0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                        <div class="dep-rolling-calc-body" id="dep-rolling-calc-body">
                            <div class="dep-rolling-selects">
                                <div>
                                    <label class="dep-rolling-label" for="dep-province-select">Tỉnh / Thành phố</label>
                                    <select id="dep-province-select" class="dep-native-select" onchange="depOnProvinceChange(this)">
                                        <option value="">-- Chọn tỉnh thành --</option>
                                        <optgroup label="── Khu vực I ──">
                                            <option value="hanoi"        data-zone="1">Hà Nội</option>
                                            <option value="hcm"          data-zone="1">TP. Hồ Chí Minh</option>
                                        </optgroup>
                                        <optgroup label="── Khu vực II ──">
                                            <option value="haiphong"     data-zone="2">Hải Phòng</option>
                                            <option value="danang"       data-zone="2">Đà Nẵng</option>
                                            <option value="cantho"       data-zone="2">Cần Thơ</option>
                                            <option value="binhduong"    data-zone="2">Bình Dương</option>
                                            <option value="dongnai"      data-zone="2">Đồng Nai</option>
                                            <option value="bariavungtau" data-zone="2">Bà Rịa - Vũng Tàu</option>
                                            <option value="bacninh"      data-zone="2">Bắc Ninh</option>
                                            <option value="quangninh"    data-zone="2">Quảng Ninh</option>
                                            <option value="hatinh"       data-zone="2">Hà Tĩnh</option>
                                            <option value="nghean"       data-zone="2">Nghệ An</option>
                                            <option value="thanhhoa"     data-zone="2">Thanh Hóa</option>
                                            <option value="khanhhoa"     data-zone="2">Khánh Hòa</option>
                                            <option value="binhthuan"    data-zone="2">Bình Thuận</option>
                                            <option value="longaon"      data-zone="2">Long An</option>
                                            <option value="tiengiang"    data-zone="2">Tiền Giang</option>
                                            <option value="vinhlong"     data-zone="2">Vĩnh Long</option>
                                        </optgroup>
                                        <optgroup label="── Khu vực III ──">
                                            <option value="other"        data-zone="3">Các tỉnh thành khác</option>
                                        </optgroup>
                                    </select>
                                    <input type="hidden" id="dep-province-val" value="">
                                    <input type="hidden" id="dep-zone-val" value="">
                                </div>
                                <div>
                                    <label class="dep-rolling-label" for="dep-zone-select">Khu vực trước bạ</label>
                                    <select id="dep-zone-select" class="dep-native-select" onchange="depOnZoneChange(this)">
                                        <option value="">-- Chọn khu vực --</option>
                                        <option value="1">Khu vực I (10%) — HN, HCM</option>
                                        <option value="2">Khu vực II (10%)</option>
                                        <option value="3">Khu vực III (8%)</option>
                                    </select>
                                    <input type="hidden" id="dep-zone-direct-val" value="">
                                </div>
                            </div>
                            <button type="button" class="dep-rolling-calc-btn" onclick="depCalcRolling()">
                                TÍNH GIÁ LĂN BÁNH →
                            </button>
                            {{-- Breakdown chi tiết --}}
                            <div class="dep-rolling-breakdown" id="dep-rolling-breakdown" style="display:none;">
                                <div class="dep-rolling-breakdown-row"><span class="rbl">Giá niêm yết</span><span class="rbv" id="rb-list-price"></span></div>
                                <div class="dep-rolling-breakdown-row"><span class="rbl">Trước bạ</span><span class="rbv" id="rb-reg-fee"></span></div>
                                <div class="dep-rolling-breakdown-row"><span class="rbl">Phí đường bộ</span><span class="rbv" id="rb-road-fee"></span></div>
                                <div class="dep-rolling-breakdown-row"><span class="rbl">Bảo hiểm TNDS</span><span class="rbv" id="rb-insurance"></span></div>
                                <div class="dep-rolling-breakdown-row"><span class="rbl">Đăng kiểm</span><span class="rbv" id="rb-inspection"></span></div>
                                <div class="dep-rolling-breakdown-row total"><span class="rbl">Tổng lăn bánh</span><span class="rbv" id="rb-total"></span></div>
                            </div>
                            <div class="dep-rolling-result" id="dep-rolling-result">
                                <div class="dep-rolling-result-row">
                                    <span class="dep-rolling-result-label">Đã áp dụng giá lăn bánh</span>
                                    <span class="dep-rolling-result-val" id="dep-rolling-total"></span>
                                </div>
                                <div class="dep-rolling-result-note">✓ Slider % bên dưới đang tính trên giá này</div>
                            </div>
                        </div>{{-- /dep-rolling-calc-body --}}
                    </div>
                    @endif

                    {{-- ── CHỌN MÀU XE ── --}}
                    @if($hasColors)
                    <div class="dep-field" style="margin-bottom:20px;">
                        <label class="dep-label">Màu xe yêu thích</label>
                        <div class="dep-color-grid" id="dep-color-grid">
                            @foreach($car->colors->sortBy('sort_order') as $color)
                            <label class="dep-color-opt">
                                <input type="radio" name="color_id" value="{{ $color->id }}"
                                    data-name="{{ $color->name }}"
                                    data-hex="{{ $color->hex_code ?? '#cccccc' }}"
                                    data-img="{{ $color->image ? depCarImgPath($color->image) : '' }}"
                                    {{ (old('color_id', $defaultColor?->id) == $color->id) ? 'checked' : '' }}
                                    onchange="depOnColorChange(this)">
                                <div class="dep-color-swatch">
                                    <div class="dep-color-dot" style="background:{{ $color->hex_code ?? '#cccccc' }};"></div>
                                    <span class="dep-color-name">{{ $color->name }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('color_id')<span class="dep-error">{{ $message }}</span>@enderror
                    </div>
                    @endif

                    <label class="dep-label">Chọn mức đặt cọc <span class="req">*</span></label>

                    <div class="dep-slider-wrap">
                        <div class="dep-pct-display">
                            <span class="dep-pct-display-num" id="dep-pct-label">40</span><span style="font-family:'Barlow Condensed',sans-serif;font-size:36px;font-weight:900;color:#1a1a1a;">%</span>
                            <span class="dep-pct-display-unit">trên giá xe</span>
                        </div>
                        <div class="dep-slider-row">
                            <span class="dep-slider-edge">10%</span>
                            <input type="range" id="dep-pct-slider" class="dep-slider" min="10" max="100" step="1" value="40">
                            <span class="dep-slider-edge">100%</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;padding:0 2px;margin-top:-4px;margin-bottom:4px;">
                            @foreach([10,20,30,40,50,60,70,80,90,100] as $tick)
                                <span style="font-size:9px;font-weight:700;color:#ccc;cursor:pointer;transition:color .15s;"
                                    onclick="depSetPct({{ $tick }})" title="{{ $tick }}%">{{ $tick }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="dep-amount-box">
                        <div class="dep-amount-box-top">
                            <span class="dep-amount-display-label">Số tiền đặt cọc</span>
                            <span class="dep-amount-display-val" id="dep-preview-amount">—</span>
                        </div>
                        <div class="dep-amount-manual-row">
                            <span class="dep-amount-manual-label">Tự nhập</span>
                            <input type="text" id="dep-amount-manual" class="dep-amount-manual-input"
                                placeholder="VD: 50.000.000" autocomplete="off">
                            <span class="dep-amount-manual-unit">đ</span>
                        </div>
                        <div class="dep-amount-min-warn" id="dep-min-warn">⚠ Tối thiểu 10.000.000đ (10 triệu)</div>
                        <div id="dep-max-warn" style="display:none;font-size:11px;color:#f59e0b;font-weight:600;margin-top:6px;">⚠ Số tiền vượt quá giá xe — thường đặt cọc từ 10% đến 50%</div>
                    </div>

                    <p class="dep-hint" id="dep-hint-text">* Kéo thanh hoặc tự nhập · Tối thiểu 10.000.000đ · % tính trên {{ $priceSource === 'rolling' ? 'giá lăn bánh dự toán' : 'giá niêm yết' }}</p>

                    @php $defaultAmt = $carPrice > 0 ? round($carPrice * 0.4) : 40000000; @endphp
                    <input type="number" name="deposit_amount" id="dep-amount"
                        value="{{ old('deposit_amount', $defaultAmt) }}" min="10000000" step="1" required style="display:none;">
                    @error('deposit_amount')<span class="dep-error">{{ $message }}</span>@enderror

                    <label class="dep-label" style="margin-top:8px">Phương thức thanh toán <span class="req">*</span></label>
                    <div class="dep-payment-grid" style="grid-template-columns:1fr 1fr 1fr;">
                        <label class="dep-pay-opt">
                            <input type="radio" name="payment_method" value="bank_transfer"
                                {{ old('payment_method', 'bank_transfer') === 'bank_transfer' ? 'checked' : '' }}>
                            <span class="dep-pay-icon">🏦</span>
                            <div>
                                <div class="dep-pay-name">Chuyển khoản</div>
                                <div class="dep-pay-desc">Ngân hàng / QR</div>
                            </div>
                        </label>
                        <label class="dep-pay-opt">
                            <input type="radio" name="payment_method" value="momo"
                                {{ old('payment_method') === 'momo' ? 'checked' : '' }}>
                            <span class="dep-pay-icon" style="display:flex;align-items:center;">
                                <span style="width:26px;height:26px;border-radius:6px;background:linear-gradient(135deg,#ae2070,#d82d8b);display:inline-flex;align-items:center;justify-content:center;font-family:'Barlow Condensed',sans-serif;font-size:14px;font-weight:900;color:#fff;letter-spacing:-0.5px;flex-shrink:0;">M</span>
                            </span>
                            <div>
                                <div class="dep-pay-name">MoMo</div>
                                <div class="dep-pay-desc">Ví điện tử</div>
                            </div>
                        </label>
                        <label class="dep-pay-opt">
                            <input type="radio" name="payment_method" value="vnpay"
                                {{ old('payment_method') === 'vnpay' ? 'checked' : '' }}>
                            <span class="dep-pay-icon">💳</span>
                            <div>
                                <div class="dep-pay-name">VNPay</div>
                                <div class="dep-pay-desc">Cổng thanh toán</div>
                            </div>
                        </label>
                    </div>
                    @error('payment_method')<span class="dep-error" style="margin-top:6px;display:block;">{{ $message }}</span>@enderror
                </div>

                {{-- GHI CHÚ --}}
                <div class="dep-card">
                    <div class="dep-card-title"><span class="step-num">3</span> Ghi chú</div>
                    <textarea name="note" class="dep-input" placeholder="Yêu cầu màu sắc, phụ kiện, thời gian nhận xe...">{{ old('note') }}</textarea>
                </div>

                {{-- ĐIỀU KHOẢN + NÚT --}}
                <div class="dep-terms">
                    <input type="checkbox" name="agree_terms" id="dep-agree" value="1" {{ old('agree_terms') ? 'checked' : '' }}>
                    <div class="dep-terms-text">
                        Tôi đồng ý với <a href="#">điều khoản đặt cọc</a> của AUTO X Showroom.
                        Số tiền cọc sẽ được hoàn trả đầy đủ trong trường hợp xe không còn hàng hoặc showroom không thể giao xe đúng hẹn.
                    </div>
                </div>
                @error('agree_terms')<span class="dep-error" style="margin-top:6px;display:block;">{{ $message }}</span>@enderror

                <button type="button" id="dep-open-qr" class="dep-submit">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3h-3zM17 17h3v3h-3zM14 20h3"/></svg>
                    Quét mã QR để đặt cọc →
                </button>
            </form>
        </div>

        {{-- ====== CỘT PHẢI: Xe + Tóm tắt ====== --}}
        <div class="dep-sidebar">
            <div class="dep-car-card">
                <div class="dep-car-img-wrap">
                    @if($carImage)
                        <img id="dep-sidebar-img" src="{{ $carImage }}" alt="{{ $car->name }}">
                    @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                            <span style="font-family:'Barlow Condensed',sans-serif;font-size:12px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.08);">{{ $car->name }}</span>
                        </div>
                    @endif
                    <div class="dep-car-img-overlay"></div>
                    @if($brandName)<div class="dep-car-brand-badge">{{ $brandName }}</div>@endif
                </div>

                <div class="dep-car-info">
                    <div class="dep-car-name">{{ $car->name }}</div>
                    @if($carPrice > 0)
                        <div class="dep-car-price" id="dep-sidebar-price">{{ number_format($carPrice) }}<small>VNĐ</small></div>
                    @else
                        <div class="dep-car-price" style="font-size:18px;color:rgba(255,255,255,.35);">Liên hệ báo giá</div>
                    @endif

                    <div class="dep-summary">
                        <div class="dep-summary-title">Chi tiết đặt cọc</div>

                        @if($hasColors)
                        <div class="dep-sidebar-color" id="dep-sidebar-color-row">
                            <span class="dep-sidebar-color-label">Màu</span>
                            <span class="dep-sidebar-color-dot" id="dep-sidebar-color-dot"
                                style="background:{{ $defaultColor?->hex_code ?? '#cccccc' }};"></span>
                            <span class="dep-sidebar-color-name" id="dep-sidebar-color-name">
                                {{ $defaultColor?->name ?? '—' }}
                            </span>
                        </div>
                        @endif

                        @if($carPrice > 0)
                        <div class="dep-summary-row">
                            <span class="dep-summary-label">Giá xe</span>
                            <span class="dep-summary-value" id="sb-car-price">{{ number_format($carPrice) }}đ</span>
                        </div>
                        @endif
                        <div class="dep-summary-row">
                            <span class="dep-summary-label">Tiền đặt cọc <span class="dep-summary-pct" id="sb-pct">40%</span></span>
                            <span class="dep-summary-value red" id="sb-amount">{{ number_format($defaultAmt) }}đ</span>
                        </div>
                        @if($carPrice > 0)
                        <div class="dep-summary-row">
                            <span class="dep-summary-label">Còn lại khi nhận xe</span>
                            <span class="dep-summary-value" id="sb-remain">{{ number_format(max(0,$carPrice - $defaultAmt)) }}đ</span>
                        </div>
                        @endif
                    </div>

                    <div class="dep-pledge">
                        <div class="dep-pledge-title">✦ Cam kết của chúng tôi</div>
                        <ul>
                            <li>Giữ xe trong vòng 30 ngày</li>
                            <li>Hoàn cọc nếu xe không còn hàng</li>
                            <li>Tư vấn viên liên hệ trong 24h</li>
                        </ul>
                    </div>
                </div>

                <div class="dep-hotline">
                    <div class="dep-hotline-label">Cần hỗ trợ? Gọi ngay</div>
                    <a href="tel:0909123456">0909 123 456</a>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

{{-- ====== QR MODAL ====== --}}
<div class="dep-qr-overlay" id="dep-qr-overlay">
    <div class="dep-qr-modal">
        <div class="dep-qr-modal-header">
            <div class="dep-qr-header-bank">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.5)" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                <span>{{ $bankName }} · {{ $bankAccount }}</span>
            </div>
            <div class="dep-qr-header-amount-label">Số tiền cần chuyển</div>
            <div class="pay-amount" id="qr-show-amount">0<small>đ</small></div>
        </div>
        <div class="dep-qr-body">
            <div class="dep-qr-img-wrap">
                <img id="qr-img" src="" alt="QR Code thanh toán" style="width:260px;height:auto;display:block;">
            </div>
            <div class="dep-qr-bank-info">
                <div class="dep-qr-bank-row">
                    <span class="lbl">Ngân hàng</span>
                    <span class="val">{{ $bankName }}</span>
                </div>
                <div class="dep-qr-bank-row">
                    <span class="lbl">Số tài khoản</span>
                    <span class="val">{{ $bankAccount }}</span>
                </div>
                <div class="dep-qr-bank-row">
                    <span class="lbl">Chủ TK</span>
                    <span class="val">{{ $bankOwner }}</span>
                </div>
                <div class="dep-qr-bank-row">
                    <span class="lbl">Nội dung CK</span>
                    <input type="text" id="qr-transfer-content" class="dep-qr-content-edit"
                        value="DAT COC {{ $car->name }}"
                        placeholder="Nhập nội dung chuyển khoản">
                </div>
            </div>
            <div class="dep-qr-note">
                Mở app ngân hàng, quét mã QR và chuyển <strong>đúng số tiền</strong> trên.<br>
                Sau khi chuyển xong nhấn <strong>"Tôi đã chuyển khoản"</strong> để hoàn tất đặt cọc.
            </div>
            <div style="text-align:center;">
                <div class="dep-qr-timer">
                    ⏱&nbsp; Mã hết hạn sau <span id="qr-timer">10:00</span>
                </div>
            </div>
            <div class="dep-qr-status" id="dep-qr-status" style="display:none;">
                <div class="dep-qr-status-text success">✓ Đang ghi nhận đặt cọc...</div>
            </div>
            <button type="button" class="dep-qr-confirm" id="dep-qr-confirm">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                Tôi đã chuyển khoản →
            </button>
            <button type="button" class="dep-qr-cancel" id="dep-qr-cancel">Huỷ, quay lại</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    /* ── Hằng số phí lăn bánh ── */
    var ZONE_RATE  = { '1': 0.10, '2': 0.10, '3': 0.08 };
    var REG_FEE    = { '1': 20000000, '2': 1000000, '3': 1000000 };
    var ROAD_FEE_GAS      = 1560000;
    var ROAD_FEE_ELECTRIC = 0;
    var INSURANCE  = 530900;
    var INSPECTION = 560000;

    function isElectric(name) {
        var t = (name || '').toLowerCase();
        return t.includes('vf ') || t.includes('vf3') || t.includes('vf5') ||
               t.includes('vf6') || t.includes('vf7') || t.includes('vf8') ||
               t.includes('vf9') || t.includes('eqs');
    }

    var listPrice   = {{ $carPrice }};
    var carPrice    = {{ $carPrice }};
    var priceSource = '{{ $priceSource }}';
    var carName     = '{{ addslashes($car->name) }}';
    var bankId      = '{{ $bankId }}';
    var bankAccount = '{{ $bankAccount }}';

    var MIN_DEPOSIT = 10000000; /* 10 triệu */
    var maxWarn      = document.getElementById('dep-max-warn');
    var amountInput  = document.getElementById('dep-amount');
    var sbAmt        = document.getElementById('sb-amount');
    var sbRemain     = document.getElementById('sb-remain');
    var sbPct        = document.getElementById('sb-pct');
    var sbCarPrice   = document.getElementById('sb-car-price');
    var previewAmt   = document.getElementById('dep-preview-amount');
    var pctLabel     = document.getElementById('dep-pct-label');
    var slider       = document.getElementById('dep-pct-slider');
    var manualInput  = document.getElementById('dep-amount-manual');
    var minWarn      = document.getElementById('dep-min-warn');
    var qrImg        = document.getElementById('qr-img');
    var qrShowAmt    = document.getElementById('qr-show-amount');
    var qrContent    = document.getElementById('qr-transfer-content');
    var qrTimerEl    = document.getElementById('qr-timer');
    var overlay      = document.getElementById('dep-qr-overlay');
    var confirmBtn   = document.getElementById('dep-qr-confirm');
    var statusBox    = document.getElementById('dep-qr-status');
    var timerInterval = null;

    var sidebarImg       = document.getElementById('dep-sidebar-img');
    var sidebarColorDot  = document.getElementById('dep-sidebar-color-dot');
    var sidebarColorName = document.getElementById('dep-sidebar-color-name');

    /* ── Format số ── */
    function fmt(n) {
        return new Intl.NumberFormat('vi-VN').format(Math.round(n)) + 'đ';
    }

    /* ── Slider track gradient ── */
    function updateSliderTrack(pct) {
        var fill = ((pct - 10) / 90 * 100).toFixed(1);
        slider.style.background = 'linear-gradient(to right, #1a1a1a ' + fill + '%, #e2e2e2 ' + fill + '%)';
    }

    /* ── Cập nhật toàn bộ UI số tiền ── */
    function setAmount(amt) {
        amt = Math.round(Math.max(0, amt));
        amountInput.value = amt;
        if (previewAmt) previewAmt.textContent = amt > 0 ? fmt(amt) : '—';
        if (sbAmt)      sbAmt.textContent      = amt > 0 ? fmt(amt) : '—';
        if (sbRemain)   sbRemain.textContent   = fmt(Math.max(0, carPrice - amt));
        var pct = carPrice > 0 ? Math.round(amt / carPrice * 100) : parseInt(slider.value);
        if (sbPct) sbPct.textContent = pct + '%';
        if (minWarn) minWarn.style.display = (amt > 0 && amt < MIN_DEPOSIT) ? 'block' : 'none';
        if (maxWarn) maxWarn.style.display = (carPrice > 0 && amt > carPrice) ? 'block' : 'none';
    }

    window.depSetPct = function(pct) {
        slider.value = pct;
        pctLabel.textContent = pct;
        updateSliderTrack(pct);
        var amt = carPrice > 0 ? Math.round(carPrice * pct / 100) : pct * 100000;
        manualInput.value = new Intl.NumberFormat('vi-VN').format(amt);
        setAmount(amt);
    };

    slider.addEventListener('input', function () {
        var pct = parseInt(this.value);
        pctLabel.textContent = pct;
        updateSliderTrack(pct);
        var amt = carPrice > 0 ? Math.round(carPrice * pct / 100) : pct * 100000;
        manualInput.value = new Intl.NumberFormat('vi-VN').format(amt);
        setAmount(amt);
    });

    manualInput.addEventListener('input', function () {
        var raw = this.value.replace(/[^0-9]/g, '');
        var amt = parseInt(raw) || 0;
        setAmount(amt);
        if (amt > 0 && carPrice > 0) {
            var pct = Math.min(100, Math.max(10, Math.round(amt / carPrice * 100)));
            slider.value = pct;
            pctLabel.textContent = pct;
            updateSliderTrack(pct);
        }
    });

    manualInput.addEventListener('blur', function () {
        var raw = this.value.replace(/[^0-9]/g, '');
        var amt = parseInt(raw) || 0;
        if (amt > 0) this.value = new Intl.NumberFormat('vi-VN').format(amt);
    });

    /* Init */
    (function init() {
        var pct = 40;
        var amt = carPrice > 0 ? Math.round(carPrice * pct / 100) : 40000000;
        slider.value = pct;
        pctLabel.textContent = pct;
        updateSliderTrack(pct);
        manualInput.value = new Intl.NumberFormat('vi-VN').format(amt);
        setAmount(amt);
    })();

    /* ═══════════════════════════════════════
       NATIVE SELECT — ROLLING CALC
    ═══════════════════════════════════════ */
    window.depOnProvinceChange = function(sel) {
        var opt  = sel.options[sel.selectedIndex];
        var zone = opt ? (opt.dataset.zone || '') : '';
        var val  = sel.value;
        var provVal = document.getElementById('dep-province-val');
        var zoneVal = document.getElementById('dep-zone-val');
        if (provVal) provVal.value = val;
        if (zoneVal) zoneVal.value = zone;
        /* Tự đồng bộ dropdown khu vực */
        var zSel = document.getElementById('dep-zone-select');
        var zHid = document.getElementById('dep-zone-direct-val');
        if (zone && zSel) { zSel.value = zone; if (zHid) zHid.value = zone; }
    };

    window.depOnZoneChange = function(sel) {
        var hidden = document.getElementById('dep-zone-direct-val');
        if (hidden) hidden.value = sel.value;
    };

    /* ═══════════════════════════════════════
       ROLLING CALC (accordion toggle + tính toán)
    ═══════════════════════════════════════ */
    window.depToggleRolling = function() {
        var wrap  = document.getElementById('dep-rolling-calc-wrap');
        var arrow = document.getElementById('dep-rolling-arrow');
        if (!wrap) return;
        wrap.classList.toggle('open');
        if (arrow) arrow.style.transform = wrap.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
    };

    window.depCalcRolling = function() {
        var zSel   = document.getElementById('dep-zone-select');
        var zHid   = document.getElementById('dep-zone-direct-val');
        var zone   = (zSel && zSel.value) || (zHid && zHid.value);
        if (!zone) {
            alert('Vui lòng chọn tỉnh thành hoặc khu vực trước bạ.');
            return;
        }

        var rate      = ZONE_RATE[zone]  || 0.10;
        var regFee    = REG_FEE[zone]    || 1000000;
        var roadFee   = isElectric(carName) ? ROAD_FEE_ELECTRIC : ROAD_FEE_GAS;
        var truocBa   = Math.round(listPrice * rate);
        var rolling   = listPrice + truocBa + regFee + roadFee + INSURANCE + INSPECTION;

        /* Hiện breakdown chi tiết */
        var bd = document.getElementById('dep-rolling-breakdown');
        if (bd) {
            bd.style.display = 'block';
            document.getElementById('rb-list-price').textContent  = fmt(listPrice);
            document.getElementById('rb-reg-fee').textContent     = fmt(truocBa) + ' (' + Math.round(rate * 100) + '%)';
            document.getElementById('rb-road-fee').textContent    = fmt(regFee);
            document.getElementById('rb-insurance').textContent   = fmt(INSURANCE);
            document.getElementById('rb-inspection').textContent  = fmt(INSPECTION);
            document.getElementById('rb-total').textContent       = fmt(rolling);
        }

        /* Hiện result */
        var resultEl = document.getElementById('dep-rolling-result');
        var totalEl  = document.getElementById('dep-rolling-total');
        if (totalEl) totalEl.textContent = fmt(rolling);
        if (resultEl) resultEl.style.display = 'block';

        /* Cập nhật carPrice và các UI liên quan */
        carPrice = rolling;

        var sidebarPriceEl = document.getElementById('dep-sidebar-price');
        if (sidebarPriceEl) sidebarPriceEl.innerHTML = new Intl.NumberFormat('vi-VN').format(rolling) + '<small>VNĐ</small>';
        if (sbCarPrice)     sbCarPrice.textContent   = fmt(rolling);

        /* ── FIX: cập nhật số giá trong box ── */
        var displayPrice = document.getElementById('dep-display-price');
        if (displayPrice) {
            displayPrice.style.color = '#16a34a';
            displayPrice.innerHTML   = new Intl.NumberFormat('vi-VN').format(rolling)
                + '<span style="font-size:12px;color:#bbb;margin-left:3px;font-family:\'Be Vietnam Pro\',sans-serif;font-weight:500;">đ</span>';
        }

        /* ── FIX: cập nhật label "Giá lăn bánh (từ dự toán)" ── */
        var priceBoxLabel = document.getElementById('dep-price-box-label');
        if (priceBoxLabel) priceBoxLabel.textContent = 'Giá lăn bánh (từ dự toán)';

        /* ── FIX: cập nhật subtext xanh "✓ Đã bao gồm thuế, phí, đăng ký" ── */
        var priceBoxSub = document.getElementById('dep-price-box-sub');
        if (priceBoxSub) {
            priceBoxSub.style.color   = '#16a34a';
            priceBoxSub.textContent   = '✓ Đã bao gồm thuế, phí, đăng ký';
        }

        var hintText = document.getElementById('dep-hint-text');
        if (hintText) hintText.textContent = '* Kéo thanh hoặc tự nhập · Tối thiểu 10.000.000đ · % tính trên giá lăn bánh dự toán';

        /* Tính lại số tiền theo % hiện tại */
        var pct = parseInt(slider.value);
        var amt = Math.round(rolling * pct / 100);
        manualInput.value = new Intl.NumberFormat('vi-VN').format(amt);
        setAmount(amt);
    };

    /* ═══════════════════════════════════════
       COLOR CHANGE
    ═══════════════════════════════════════ */
    window.depOnColorChange = function(radio) {
        var img  = radio.dataset.img;
        var hex  = radio.dataset.hex;
        var name = radio.dataset.name;
        if (sidebarImg && img) {
            sidebarImg.style.opacity = '0';
            setTimeout(function() { sidebarImg.src = img; sidebarImg.style.opacity = '1'; }, 200);
        }
        if (sidebarColorDot)  sidebarColorDot.style.background = hex || '#ccc';
        if (sidebarColorName) sidebarColorName.textContent = name || '';
    };

    (function initColor() {
        var checked = document.querySelector('#dep-color-grid input[type="radio"]:checked');
        if (checked) depOnColorChange(checked);
    })();

    /* ═══════════════════════════════════════
       QR MODAL
    ═══════════════════════════════════════ */
    function buildQrUrl(amount) {
        var content = (qrContent ? qrContent.value : 'DAT COC ' + carName).trim() || 'DAT COC ' + carName;
        return 'https://img.vietqr.io/image/' + bankId + '-' + bankAccount
            + '-compact2.png?amount=' + amount + '&addInfo=' + encodeURIComponent(content) + '&accountName={{ rawurlencode($bankOwner) }}';
    }

    document.getElementById('dep-open-qr').addEventListener('click', function () {
        var agree = document.getElementById('dep-agree');
        if (!agree.checked) { agree.focus(); alert('Vui lòng đồng ý với điều khoản đặt cọc trước khi tiếp tục.'); return; }
        var amt = parseInt(amountInput.value) || 0;
        if (amt < MIN_DEPOSIT) { manualInput.focus(); alert('Số tiền đặt cọc tối thiểu là 10.000.000đ (10 triệu).'); return; }
        var form   = document.getElementById('dep-form');
        var inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
        var valid  = true;
        inputs.forEach(function(inp) { if (!inp.value.trim()) { inp.focus(); valid = false; } });
        if (!valid) { alert('Vui lòng điền đầy đủ thông tin bắt buộc.'); return; }
        qrShowAmt.innerHTML = new Intl.NumberFormat('vi-VN').format(amt) + '<small>đ</small>';
        if (!qrContent.value.trim()) qrContent.value = 'DAT COC ' + carName;
        qrImg.src = buildQrUrl(amt);
        overlay.classList.add('active');
        startTimer(600);
    });

    confirmBtn.addEventListener('click', function () {
        confirmBtn.disabled = true;
        confirmBtn.style.opacity = '.6';
        confirmBtn.textContent = 'Đang xử lý...';
        statusBox.style.display = 'block';
        clearInterval(timerInterval);
        overlay.classList.remove('active');
        document.getElementById('dep-form').submit();
    });

    document.getElementById('dep-qr-cancel').addEventListener('click', closeOverlay);
    overlay.addEventListener('click', function(e) { if (e.target === overlay) closeOverlay(); });

    function closeOverlay() { clearInterval(timerInterval); overlay.classList.remove('active'); }

    function startTimer(seconds) {
        clearInterval(timerInterval);
        var remaining = seconds;
        function tick() {
            var m = Math.floor(remaining / 60), s = remaining % 60;
            qrTimerEl.textContent = (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
            if (remaining <= 0) { clearInterval(timerInterval); qrTimerEl.textContent = 'Hết hạn'; qrTimerEl.style.color = '#ef4444'; }
            remaining--;
        }
        tick();
        timerInterval = setInterval(tick, 1000);
    }
})();
</script>
@endpush
@endsection