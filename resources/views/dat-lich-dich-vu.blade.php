@extends('layouts.frontend')

@section('title', 'Đặt Lịch Dịch Vụ Trực Tuyến - AUTO X')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
<style>
  :root {
    --blue:        #1c69d4;
    --blue-dark:   #1555b0;
    --blue-light:  rgba(28,105,212,0.08);
    --blue-border: rgba(28,105,212,0.25);
    --black:  #0a0a0a;
    --white:  #ffffff;
    --gray-1: #f7f7f7;
    --gray-2: #e8e8e8;
    --gray-3: #cccccc;
    --gray-4: #888888;
    --gray-5: #444444;
    --text:   #1a1a1a;
    --font:   'Inter', sans-serif;
    --font-h: 'Plus Jakarta Sans', sans-serif;
    --radius: 10px;
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: var(--font); color: var(--text); }
  a { text-decoration: none; color: inherit; }
  .container { max-width: 1200px; margin: 0 auto; padding: 0 48px; }

  /* ── HERO ── */
  .hero {
    background: var(--black); padding: 100px 0 48px;
    position: relative; overflow: hidden;
  }
  .hero::before {
    content: ''; position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1625047509248-ec889cbff17f?w=1600&q=80') center/cover no-repeat;
    opacity: .18;
  }
  .hero-inner { position: relative; z-index: 1; display: flex; flex-direction: column; align-items: center; text-align: center; gap: 14px; }
  .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; background: transparent !important; padding: 0 !important; border: none !important; box-shadow: none !important; }
  .breadcrumb a { color: rgba(255,255,255,.75); transition: color .2s; }
  .breadcrumb a:hover { color: var(--white); }
  .breadcrumb span { color: var(--blue); }
  .breadcrumb i { font-size: 9px; color: rgba(255,255,255,.4); }
  .hero h1 {
    font-family: var(--font-h); font-size: clamp(42px,6vw,76px);
    font-weight: 800; color: var(--white); text-transform: uppercase;
    letter-spacing: -1px; line-height: 1;
  }
  .hero h1 span { color: var(--blue); }
  .hero p { font-size: 16px; color: var(--gray-3); max-width: 520px; line-height: 1.7; margin: 0 auto; }

  /* ── BOOKING LAYOUT ── */
  .booking-section { background: var(--gray-1); padding: 72px 0; }
  .booking-grid { display: grid; grid-template-columns: 1fr 380px; gap: 48px; align-items: start; }

  /* ── FORM WRAP ── */
  .booking-form-wrap { background: var(--white); border: 1px solid var(--gray-2); border-radius: 14px; overflow: hidden; }
  .form-header {
    padding: 24px 32px; border-bottom: 1px solid var(--gray-2);
    background: var(--gray-1); display: flex; align-items: center; justify-content: space-between;
  }
  .form-header-title { font-family: var(--font-h); font-size: 22px; font-weight: 800; text-transform: uppercase; color: var(--text); }
  .form-header-sub { font-size: 12px; color: var(--gray-4); margin-top: 3px; }
  .form-badge {
    background: var(--blue); color: var(--white);
    font-family: var(--font-h); font-size: 10px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase; padding: 6px 14px; border-radius: 6px;
    display: flex; align-items: center; gap: 7px;
  }
  .form-badge::before {
    content: ''; width: 7px; height: 7px; background: #7ee8a2;
    border-radius: 50%; flex-shrink: 0;
    animation: badgepulse 1.6s ease-in-out infinite;
  }
  @keyframes badgepulse {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:.4; transform:scale(1.4); }
  }
  .form-body { padding: 32px; }

  .form-block-title {
    font-family: var(--font-h); font-size: 13px; font-weight: 700;
    text-transform: uppercase; color: var(--gray-4); letter-spacing: 1px;
    margin-bottom: 16px; padding-bottom: 10px; border-bottom: 1px solid var(--gray-2);
    display: flex; align-items: center; gap: 10px;
  }
  .step-badge {
    display: inline-flex; align-items: center; justify-content: center;
    width: 24px; height: 24px; background: var(--blue); color: var(--white);
    font-size: 12px; font-weight: 700; border-radius: 50%; flex-shrink: 0;
  }
  .form-step-divider { margin: 28px 0; border: none; border-top: 1px solid var(--gray-2); }

  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
  .form-group { display: flex; flex-direction: column; gap: 7px; margin-bottom: 16px; }
  .form-group:last-child { margin-bottom: 0; }
  .form-group label { font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--gray-4); }
  .form-group label .req { color: var(--blue); }
  .form-group input,
  .form-group select,
  .form-group textarea {
    padding: 11px 14px; border: 1px solid var(--gray-2); background: var(--gray-1);
    font-size: 14px; color: var(--text); font-family: var(--font);
    outline: none; transition: border-color .2s, background .2s, box-shadow .2s; border-radius: 8px;
    appearance: none; -webkit-appearance: none; line-height: 1.5;
  }
  .form-group input:focus,
  .form-group select:focus,
  .form-group textarea:focus {
    border-color: var(--blue); background: var(--white);
    box-shadow: 0 0 0 3px rgba(28,105,212,.1);
  }
  .form-group input::placeholder, .form-group textarea::placeholder { color: var(--gray-3); }
  .form-group select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23888' stroke-width='1.5' fill='none'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 14px center;
    background-size: 12px; padding-right: 38px; cursor: pointer;
  }
  .form-group textarea { min-height: 110px; resize: vertical; }
  .input-error { border-color: #e74c3c !important; background: #fff5f5 !important; }
  .field-error { font-size: 12px; color: #e74c3c; font-weight: 500; margin-top: 2px; display: block; }

  /* ── SERVICE CARDS ── */
  .service-type-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 10px; margin-bottom: 20px; }

  .svc-type-card {
    position: relative; padding: 18px 10px 14px;
    border: 1.5px solid var(--gray-2); border-radius: 12px;
    background: var(--white); cursor: pointer;
    transition: border-color .18s, background .18s, box-shadow .18s, transform .18s;
    text-align: center; user-select: none;
  }
  .svc-type-card:hover {
    border-color: rgba(28,105,212,.35);
    background: rgba(28,105,212,.03);
    box-shadow: 0 6px 20px rgba(28,105,212,.1);
    transform: translateY(-2px);
  }
  .svc-type-card.active {
    border-color: var(--blue);
    background: rgba(28,105,212,.05);
    box-shadow: 0 6px 20px rgba(28,105,212,.13);
    transform: translateY(-2px);
  }

  /* tick badge */
  .svc-tick {
    position: absolute; top: 8px; right: 8px;
    width: 20px; height: 20px; border-radius: 50%;
    background: var(--blue); display: flex; align-items: center; justify-content: center;
    opacity: 0; transform: scale(0.5); transition: opacity .2s, transform .25s cubic-bezier(.34,1.56,.64,1);
  }
  .svc-type-card.active .svc-tick { opacity: 1; transform: scale(1); }
  .svc-tick svg { width: 10px; height: 10px; stroke: #fff; fill: none; stroke-width: 2.5; }

  .icon-wrap {
    width: 54px; height: 54px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 10px; transition: transform .18s;
  }
  .svc-type-card:hover .icon-wrap,
  .svc-type-card.active .icon-wrap { transform: scale(1.1); }

  .svc-type-card svg.svc-icon { width: 24px; height: 24px; fill: none; stroke-width: 1.6; stroke: currentColor; }
  .svc-type-card span.svc-label {
    display: block; font-family: var(--font-h); font-size: 11px; font-weight: 700;
    letter-spacing: .5px; text-transform: uppercase; color: var(--gray-5);
    transition: color .18s;
  }
  .svc-type-card.active span.svc-label { color: var(--blue); }

  /* per-type icon colors */
  .svc-type-card[data-svc="baoduong"] .icon-wrap { color:#1c69d4; background:rgba(28,105,212,.1); }
  .svc-type-card[data-svc="suachua"]  .icon-wrap { color:#e67e22; background:rgba(230,126,34,.1); }
  .svc-type-card[data-svc="kiemtra"]  .icon-wrap { color:#27ae60; background:rgba(39,174,96,.1); }
  .svc-type-card[data-svc="dien"]     .icon-wrap { color:#8e44ad; background:rgba(142,68,173,.1); }
  .svc-type-card[data-svc="lop"]      .icon-wrap { color:#c0392b; background:rgba(192,57,43,.1); }
  .svc-type-card[data-svc="laithu"]   .icon-wrap { color:#2980b9; background:rgba(41,128,185,.1); }

  .svc-type-card.active[data-svc="baoduong"] .icon-wrap { background:rgba(28,105,212,.18); }
  .svc-type-card.active[data-svc="suachua"]  .icon-wrap { background:rgba(230,126,34,.18); }
  .svc-type-card.active[data-svc="kiemtra"]  .icon-wrap { background:rgba(39,174,96,.18); }
  .svc-type-card.active[data-svc="dien"]     .icon-wrap { background:rgba(142,68,173,.18); }
  .svc-type-card.active[data-svc="lop"]      .icon-wrap { background:rgba(192,57,43,.18); }
  .svc-type-card.active[data-svc="laithu"]   .icon-wrap { background:rgba(41,128,185,.18); }

  /* ── TOPIC CHIPS ── */
  .topic-section { margin-bottom: 4px; }
  .topic-header {
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 10px; font-size: 11px; font-weight: 700;
    letter-spacing: 1.5px; text-transform: uppercase; color: var(--gray-4);
  }
  .topic-header .selected-svc-badge {
    padding: 3px 10px; border-radius: 20px; font-size: 10px; font-weight: 700;
    letter-spacing: 1px; background: var(--blue-light); border: 1px solid var(--blue-border);
    color: var(--blue); text-transform: uppercase; transition: all .2s;
  }
  .topic-chips { display: flex; flex-wrap: wrap; gap: 8px; }
  .chip {
    padding: 7px 15px; border: 1px solid var(--gray-2); border-radius: 20px;
    font-size: 13px; font-weight: 400; color: var(--gray-5); cursor: pointer;
    transition: all .15s; background: var(--gray-1);
  }
  .chip:hover { border-color: rgba(28,105,212,.4); color: var(--blue); background: rgba(28,105,212,.05); }
  .chip.selected {
    background: var(--blue); border-color: var(--blue);
    color: #fff; font-weight: 500;
  }
  .chip.selected:hover { background: var(--blue-dark); border-color: var(--blue-dark); }
  .topic-hint {
    margin-top: 10px; font-size: 12px; color: var(--gray-4);
    display: flex; align-items: center; gap: 6px;
  }
  .topic-hint svg { width: 13px; height: 13px; stroke: var(--blue); fill: none; stroke-width: 1.8; flex-shrink: 0; }

  /* ── TIME SLOTS ── */
  .time-slots-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 8px; margin-top: 8px; }
  .time-slot {
    padding: 9px 6px; border: 1px solid var(--gray-2); background: var(--gray-1);
    text-align: center; cursor: pointer; transition: border-color .15s, background .15s;
    font-family: var(--font); font-size: 13px; font-weight: 500; color: var(--gray-4);
    border-radius: 8px;
  }
  .time-slot:hover { border-color: var(--blue-border); color: var(--text); }
  .time-slot.active { border-color: var(--blue); background: var(--blue-light); color: var(--blue); font-weight: 600; }
  .time-slot.unavailable { opacity: .35; cursor: not-allowed; }
  .time-slot-hint { font-size: 11px; color: var(--gray-4); margin-top: 8px; }

  /* ── SUBMIT BUTTON ── */
  .btn-submit {
    display: flex; align-items: center; justify-content: center; gap: 10px;
    width: 100%; padding: 15px 32px; background: var(--blue); color: var(--white);
    font-family: var(--font-h); font-size: 14px; font-weight: 700;
    letter-spacing: 1px; text-transform: uppercase; border: none; cursor: pointer;
    transition: background .2s, transform .2s, box-shadow .2s;
    margin-top: 24px; border-radius: 10px;
    position: relative; overflow: hidden;
  }
  .btn-submit:hover:not(:disabled) {
    background: var(--blue-dark);
    transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(28,105,212,.35);
  }
  .btn-submit:disabled { opacity: .75; cursor: not-allowed; transform: none; box-shadow: none; }

  /* btn inner states */
  .btn-submit .btn-text {
    display: flex; align-items: center; gap: 10px;
    transition: opacity .25s, transform .25s;
  }
  .btn-submit.loading .btn-text { opacity: 0; transform: translateY(-14px); }

  .btn-submit .btn-loader {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center; gap: 12px;
    opacity: 0; transform: translateY(14px);
    transition: opacity .25s, transform .25s;
  }
  .btn-submit.loading .btn-loader { opacity: 1; transform: translateY(0); }

  .btn-submit svg.ic { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; }

  /* loading dots */
  .ldots { display: flex; gap: 5px; align-items: center; }
  .ldot {
    width: 6px; height: 6px; border-radius: 50%; background: #fff;
    animation: ldot .75s ease-in-out infinite;
  }
  .ldot:nth-child(2) { animation-delay: .15s; }
  .ldot:nth-child(3) { animation-delay: .3s; }
  @keyframes ldot {
    0%,80%,100% { transform: scale(.55); opacity: .45; }
    40%          { transform: scale(1);   opacity: 1; }
  }

  /* ── SUCCESS ── */
  .booking-success { display: none; text-align: center; padding: 64px 32px; }
  .check-circle {
    width: 80px; height: 80px; background: var(--blue-light); border: 2px solid var(--blue-border);
    display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; border-radius: 50%;
    animation: ringIn .5s cubic-bezier(.34,1.56,.64,1) forwards;
  }
  @keyframes ringIn { from { transform:scale(0); opacity:0; } to { transform:scale(1); opacity:1; } }
  .check-circle svg { width: 36px; height: 36px; stroke: var(--blue); fill: none; stroke-width: 2; }
  .booking-success h3 { font-family: var(--font-h); font-size: 32px; font-weight: 800; text-transform: uppercase; color: var(--text); margin-bottom: 12px; }
  .booking-success p { color: var(--gray-4); font-size: 14px; max-width: 400px; margin: 0 auto; line-height: 1.7; }
  .booking-success .ref { font-family: var(--font-h); font-size: 14px; font-weight: 700; letter-spacing: 2px; color: var(--blue); margin-top: 16px; background: var(--blue-light); border: 1px solid var(--blue-border); display: inline-block; padding: 8px 20px; border-radius: 8px; }

  /* ── SIDEBAR ── */
  .booking-sidebar { display: flex; flex-direction: column; gap: 0; }
  .hotline-box { background: var(--blue); padding: 24px 28px; text-align: center; border-radius: 14px 14px 0 0; }
  .hotline-box p { font-family: var(--font-h); font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: rgba(255,255,255,.7); margin-bottom: 4px; }
  .hotline-box a.hotline-num { font-family: var(--font-h); font-size: 34px; font-weight: 800; color: #fff; letter-spacing: -1px; display: block; }
  .hotline-box a.hotline-email {
    display: inline-flex; align-items: center; gap: 6px; margin-top: 8px;
    font-size: 12px; font-weight: 600; color: rgba(255,255,255,.8); transition: color .2s;
  }
  .hotline-box a.hotline-email:hover { color: var(--white); }
  .hotline-box a.hotline-email svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; }

  .sidebar-card { background: var(--white); border: 1px solid var(--gray-2); border-top: none; overflow: hidden; }
  .sidebar-card:last-child { border-radius: 0 0 14px 14px; }
  .sidebar-card-header {
    padding: 14px 20px; background: var(--gray-1); border-bottom: 1px solid var(--gray-2);
    display: flex; align-items: center; gap: 10px;
  }
  .sidebar-card-icon {
    width: 32px; height: 32px; background: var(--blue-light); border: 1px solid var(--blue-border);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0; border-radius: 6px;
  }
  .sidebar-card-icon svg { width: 14px; height: 14px; stroke: var(--blue); fill: none; stroke-width: 1.5; }
  .sidebar-card-title { font-family: var(--font-h); font-size: 14px; font-weight: 800; text-transform: uppercase; color: var(--text); letter-spacing: .5px; }
  .sidebar-card-body { padding: 18px 20px; }

  .info-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 12px; }
  .info-list li { display: flex; align-items: flex-start; gap: 10px; font-size: 13px; }
  .info-list li .icon {
    width: 32px; height: 32px; background: var(--blue-light); border: 1px solid var(--blue-border);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0; border-radius: 6px;
  }
  .info-list li .icon svg { width: 14px; height: 14px; stroke: var(--blue); fill: none; stroke-width: 1.5; }
  .info-list li .lbl { font-size: 10px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--gray-4); margin-bottom: 2px; }
  .info-list li .val { font-size: 13px; color: var(--text); line-height: 1.5; }

  .info-list li:nth-child(1) .icon { background: rgba(248,241,241,.9); border-color: rgba(255,25,0,.3); }
  .info-list li:nth-child(1) .icon svg { stroke: #c91b1b; }
  .info-list li:nth-child(2) .icon { background: rgba(230,126,34,.1); border-color: rgba(230,126,34,.25); }
  .info-list li:nth-child(2) .icon svg { stroke: #e67e22; }
  .info-list li:nth-child(3) .icon { background: rgba(28,105,212,.1); border-color: rgba(28,105,212,.25); }
  .info-list li:nth-child(3) .icon svg { stroke: #1c69d4; }
  .info-list li:nth-child(4) .icon { background: rgba(142,68,173,.1); border-color: rgba(142,68,173,.25); }
  .info-list li:nth-child(4) .icon svg { stroke: #8e44ad; }

  .map-frame { width: 100%; height: 190px; overflow: hidden; display: block; }
  .map-frame iframe { width: 100%; height: 100%; border: none; display: block; }
  .map-footer {
    padding: 10px 16px; background: var(--gray-1); border-top: 1px solid var(--gray-2);
    display: flex; align-items: center; justify-content: space-between;
  }
  .map-address { font-size: 11px; color: var(--gray-4); }
  .map-link { font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--blue); transition: color .2s; }
  .map-link:hover { color: var(--blue-dark); }

  .steps-mini { display: flex; flex-direction: column; }
  .step-mini { display: flex; gap: 10px; align-items: flex-start; padding: 10px 0; border-bottom: 1px solid var(--gray-2); }
  .step-mini:last-child { border-bottom: none; }
  .step-mini-num {
    width: 26px; height: 26px; background: var(--blue); color: var(--white);
    font-family: var(--font-h); font-size: 13px; font-weight: 700;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0; border-radius: 50%;
  }
  .step-mini-text { font-size: 13px; color: var(--gray-5); line-height: 1.5; }
  .step-mini-text strong { display: block; font-size: 12px; font-weight: 700; letter-spacing: .5px; text-transform: uppercase; color: var(--text); margin-bottom: 2px; }

  .notes-list { padding: 0; margin: 0; list-style: none; display: flex; flex-direction: column; gap: 9px; }
  .notes-list li { display: flex; align-items: flex-start; gap: 8px; font-size: 13px; color: var(--gray-5); line-height: 1.5; }
  .notes-list li::before { content: ''; width: 6px; height: 6px; background: var(--blue); flex-shrink: 0; margin-top: 6px; border-radius: 50%; }

  [data-anim] { opacity: 0; transform: translateY(24px); transition: opacity .65s ease, transform .65s ease; }
  [data-anim].visible { opacity: 1; transform: translateY(0); }
  [data-anim="left"] { transform: translateX(-24px); }
  [data-anim="left"].visible { transform: translateX(0); }
  [data-anim="right"] { transform: translateX(24px); }
  [data-anim="right"].visible { transform: translateX(0); }

  @media (max-width: 900px) {
    .container { padding: 0 20px; }
    .booking-grid { grid-template-columns: 1fr; }
    .form-row { grid-template-columns: 1fr; }
    .service-type-grid { grid-template-columns: repeat(2,1fr); }
    .time-slots-grid { grid-template-columns: repeat(3,1fr); }
    .sidebar-card { border-top: 1px solid var(--gray-2); margin-top: 16px; }
    .hotline-box { border-radius: 14px 14px 0 0; }
  }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="hero">
  <div class="container">
    <div class="hero-inner">
      <div class="breadcrumb">
        <a href="{{ url('/') }}">Trang chủ</a>
        <i class="fa fa-angle-right"></i>
        <a href="{{ url('/services') }}">Dịch Vụ</a>
        <i class="fa fa-angle-right"></i>
        <span>Đặt Lịch</span>
      </div>
      <h1>Đặt Lịch <span>Trực Tuyến</span></h1>
      <p>Chọn thời gian phù hợp — chúng tôi lo phần còn lại. Xác nhận trong vòng 30 phút.</p>
    </div>
  </div>
</section>

{{-- BOOKING SECTION --}}
<section class="booking-section">
  <div class="container">
    <div class="booking-grid">

      {{-- FORM --}}
      <div data-anim="left">
        <div class="booking-form-wrap">
          <div class="form-header">
            <div>
              <div class="form-header-title">Thông tin đặt lịch</div>
              <div class="form-header-sub">Điền đầy đủ để chúng tôi phục vụ bạn tốt nhất</div>
            </div>
            <div class="form-badge">Miễn phí tư vấn</div>
          </div>

          <div class="form-body">
            <div id="booking-form-view">

              {{-- BƯỚC 1: LOẠI DỊCH VỤ --}}
              <div class="form-block-title">
                <span class="step-badge">1</span> Loại dịch vụ
              </div>

              <div class="service-type-grid" id="svcGrid">

                {{-- BẢO DƯỠNG: cờ lê + tua vít chéo nhau --}}
                <div class="svc-type-card active" data-svc="baoduong" tabindex="0">
                  <span class="svc-tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></span>
                  <div class="icon-wrap">
                    <svg class="svc-icon" viewBox="0 0 24 24">
                      <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                    </svg>
                  </div>
                  <span class="svc-label">Bảo dưỡng</span>
                </div>

                {{-- SỬA CHỮA: búa + cờ lê --}}
                <div class="svc-type-card" data-svc="suachua" tabindex="0">
                  <span class="svc-tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></span>
                  <div class="icon-wrap">
                    <svg class="svc-icon" viewBox="0 0 24 24">
                      <path d="M3 21l9-9"/>
                      <path d="M12.22 6.22a5.5 5.5 0 0 1 7.56 7.56l-3.5 3.5-7.56-7.56 3.5-3.5z"/>
                      <path d="M5 11L2.5 8.5l4-4L9 7"/>
                    </svg>
                  </div>
                  <span class="svc-label">Sửa chữa</span>
                </div>

                {{-- KIỂM TRA: clipboard + dấu tích --}}
                <div class="svc-type-card" data-svc="kiemtra" tabindex="0">
                  <span class="svc-tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></span>
                  <div class="icon-wrap">
                    <svg class="svc-icon" viewBox="0 0 24 24">
                      <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                      <rect x="9" y="3" width="6" height="4" rx="1"/>
                      <polyline points="9 12 11 14 15 10"/>
                    </svg>
                  </div>
                  <span class="svc-label">Kiểm tra</span>
                </div>

                {{-- ĐIỆN & ECU: tia chớp / bolt --}}
                <div class="svc-type-card" data-svc="dien" tabindex="0">
                  <span class="svc-tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></span>
                  <div class="icon-wrap">
                    <svg class="svc-icon" viewBox="0 0 24 24">
                      <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                    </svg>
                  </div>
                  <span class="svc-label">Điện &amp; ECU</span>
                </div>

                {{-- LỐP & LA-ZĂNG: bánh xe --}}
                <div class="svc-type-card" data-svc="lop" tabindex="0">
                  <span class="svc-tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></span>
                  <div class="icon-wrap">
                    <svg class="svc-icon" viewBox="0 0 24 24">
                      <circle cx="12" cy="12" r="10"/>
                      <circle cx="12" cy="12" r="4"/>
                      <line x1="12" y1="2"  x2="12" y2="8"/>
                      <line x1="12" y1="16" x2="12" y2="22"/>
                      <line x1="2"  y1="12" x2="8"  y2="12"/>
                      <line x1="16" y1="12" x2="22" y2="12"/>
                    </svg>
                  </div>
                  <span class="svc-label">Lốp &amp; La-zăng</span>
                </div>

                {{-- LÁI THỬ: vô lăng --}}
                <div class="svc-type-card" data-svc="laithu" tabindex="0">
                  <span class="svc-tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></span>
                  <div class="icon-wrap">
                    <svg class="svc-icon" viewBox="0 0 24 24">
                      <circle cx="12" cy="12" r="10"/>
                      <circle cx="12" cy="12" r="3"/>
                      <line x1="12" y1="9"  x2="12" y2="2"/>
                      <line x1="9.5"  y1="11" x2="3.5"  y2="7.5"/>
                      <line x1="14.5" y1="11" x2="20.5" y2="7.5"/>
                    </svg>
                  </div>
                  <span class="svc-label">Lái thử</span>
                </div>

              </div>

              {{-- CHỦ ĐỀ DỊCH VỤ --}}
              <div class="topic-section" id="topicSection">
                <div class="topic-header">
                  <span>Chủ đề dịch vụ</span>
                  <span class="selected-svc-badge" id="selectedSvcBadge">Bảo dưỡng</span>
                </div>
                <div class="topic-chips" id="topicChips"></div>
                <p class="topic-hint">
                  <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                  Chọn chủ đề để kỹ thuật viên chuẩn bị trước
                </p>
                <input type="hidden" name="dich_vu" id="hiddenDichVu" value="baoduong">
                <input type="hidden" name="chu_de"  id="hiddenChuDe"  value="">
              </div>

              <hr class="form-step-divider">

              {{-- BƯỚC 2: THÔNG TIN --}}
              <div class="form-block-title"><span class="step-badge">2</span> Thông tin khách hàng &amp; xe</div>

              <div class="form-row">
                <div class="form-group" style="margin-bottom:0">
                  <label>Họ và tên <span class="req">*</span></label>
                  <input type="text" name="ho_ten" placeholder="Nguyễn Văn A" required>
                </div>
                <div class="form-group" style="margin-bottom:0">
                  <label>Số điện thoại <span class="req">*</span></label>
                  <input type="tel" name="dien_thoai" placeholder="0909 123 456" required>
                </div>
              </div>
              <div class="form-row">
  <div class="form-group" style="margin-bottom:0">
    <label>Email <span class="req">*</span></label>
    <input type="email" name="email" placeholder="email@example.com" required>
  </div>
  <div class="form-group" style="margin-bottom:0">
    <label>Hãng xe</label>
    <select name="hang_xe" id="selectHangXe" onchange="loadDongXe()">
      <option value="">-- Chọn hãng xe --</option>
      <option value="mercedes">Mercedes-Benz</option>
      <option value="vinfast">VinFast</option>
    </select>
  </div>
</div>
<div class="form-row">
  <div class="form-group" style="margin-bottom:0">
    <label>Dòng xe</label>
    <select name="mau_xe" id="selectDongXe">
      <option value="">-- Chọn hãng trước --</option>
    </select>
  </div>
</div>

<hr class="form-step-divider">

{{-- BƯỚC 3: NGÀY GIỜ --}}
<div class="form-block-title"><span class="step-badge">3</span> Chọn ngày &amp; giờ</div>

<div class="form-row">
  <div class="form-group" style="margin-bottom:0">
    <label>Ngày đặt lịch <span class="req">*</span></label>
    <input type="date" id="booking-date" name="ngay" required>
  </div>
  <div class="form-group" style="margin-bottom:0">
    <label>Số km hiện tại</label>
    <input type="text" name="so_km" placeholder="VD: 45,000 km">
  </div>
</div>
              <div class="form-group" style="margin-top:4px">
                <label>Khung giờ ưu tiên <span class="req">*</span></label>
                <div class="time-slots-grid">
                  <div class="time-slot active" onclick="selectTime(this)">8:00</div>
                  <div class="time-slot" onclick="selectTime(this)">8:30</div>
                  <div class="time-slot" onclick="selectTime(this)">9:00</div>
                  <div class="time-slot" onclick="selectTime(this)">9:30</div>
                  <div class="time-slot" onclick="selectTime(this)">10:00</div>
                  <div class="time-slot" onclick="selectTime(this)">10:30</div>
                  <div class="time-slot unavailable">11:00</div>
                  <div class="time-slot unavailable">11:30</div>
                  <div class="time-slot" onclick="selectTime(this)">13:30</div>
                  <div class="time-slot" onclick="selectTime(this)">14:00</div>
                  <div class="time-slot" onclick="selectTime(this)">14:30</div>
                  <div class="time-slot" onclick="selectTime(this)">15:00</div>
                  <div class="time-slot" onclick="selectTime(this)">15:30</div>
                  <div class="time-slot unavailable">16:00</div>
                  <div class="time-slot" onclick="selectTime(this)">16:30</div>
                  <div class="time-slot" onclick="selectTime(this)">17:00</div>
                </div>
                <p class="time-slot-hint">Màu xám = đã đầy. Vui lòng chọn khung giờ khác.</p>
              </div>

              <div class="form-group">
                <label>Ghi chú thêm</label>
                <textarea name="ghi_chu" placeholder="Mô tả sự cố hoặc yêu cầu đặc biệt…"></textarea>
              </div>

              {{-- SUBMIT BUTTON với loading state --}}
              <button class="btn-submit" id="btnSubmit" onclick="return handleSubmit()">
                <div class="btn-text">
                  <svg class="ic" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                  Xác nhận đặt lịch
                </div>
                <div class="btn-loader">
                  <div class="ldots">
                    <div class="ldot"></div>
                    <div class="ldot"></div>
                    <div class="ldot"></div>
                  </div>
                  <span style="font-size:13px;letter-spacing:1.5px;text-transform:uppercase;font-weight:700;">Đang xử lý...</span>
                </div>
              </button>
            </div>

            {{-- SUCCESS --}}
            <div class="booking-success" id="booking-success">
              <div class="check-circle">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
              </div>
              <h3>Đặt lịch thành công!</h3>
              <p>Chúng tôi đã nhận được yêu cầu của bạn. Nhân viên sẽ xác nhận qua điện thoại trong vòng 30 phút.</p>
              <div class="ref">Mã đặt lịch: <span id="booking-ref">AX-####-####</span></div>
              <a href="{{ url('/services') }}" style="display:inline-block;margin-top:28px;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--blue);border-bottom:1px solid var(--blue-border);padding-bottom:3px;">← Quay lại dịch vụ</a>
            </div>
          </div>
        </div>
      </div>

      {{-- SIDEBAR --}}
      <div class="booking-sidebar" data-anim="right">
        <div class="hotline-box">
          <p>Đặt lịch qua điện thoại</p>
          <a href="tel:0909123456" class="hotline-num">0909 123 456</a>
          <a href="mailto:tan927890@gmail.com" class="hotline-email">
            <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            tan927890@gmail.com
          </a>
        </div>

        <div class="sidebar-card">
          <div class="sidebar-card-header">
            <div class="sidebar-card-icon">
              <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <div class="sidebar-card-title">Thông tin xưởng</div>
          </div>
          <div class="sidebar-card-body">
            <ul class="info-list">
              <li>
                <div class="icon"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
                <div><div class="lbl">Địa chỉ</div><div class="val">Hẻm 2276/23 Trung Mỹ Tây, Q.12, TP.HCM</div></div>
              </li>
              <li>
                <div class="icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                <div><div class="lbl">Giờ làm việc</div><div class="val">T2–T7: 7:30–18:00 &nbsp;|&nbsp; CN: 8:00–17:00</div></div>
              </li>
              <li>
                <div class="icon"><svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.36 2 2 0 0 1 3.6 1.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.41a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.69 16z"/></svg></div>
                <div><div class="lbl">Hotline</div><div class="val">0909 123 456 — 24/7</div></div>
              </li>
              <li>
                <div class="icon"><svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
                <div><div class="lbl">Email</div><div class="val">tan927890@gmail.com</div></div>
              </li>
            </ul>
          </div>
        </div>

        <div class="sidebar-card">
          <div class="sidebar-card-header">
            <div class="sidebar-card-icon">
              <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <div class="sidebar-card-title">Vị Trí Xưởng</div>
          </div>
          <div style="padding:0">
            <div class="map-frame">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.0!2d106.6216313!3d10.8506588!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752a267da9b68b%3A0xc9738dba08edcf3b!2zSOG6uzzigJkyMjc2LzIzLCBUcnVuZyBNeSBU4bqleSwgSMaw4bubbmcgMTIsIEjDoCBO4buZaSA3MDAwMCwgVGjDoG5oIHBo4buRIEjhu5MgQ2jDrSBNaW5o!5e0!3m2!1svi!2svn!4v1700000000000"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
              </iframe>
            </div>
            <div class="map-footer">
              <span class="map-address">Hẻm 2276/23, Trung Mỹ Tây, Q.12</span>
              <a href="https://maps.app.goo.gl/PEbxHZaW56esFzwK7" target="_blank" class="map-link">Chỉ đường ↗</a>
            </div>
          </div>
        </div>

        <div class="sidebar-card">
          <div class="sidebar-card-header">
            <div class="sidebar-card-icon">
              <svg viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
            <div class="sidebar-card-title">Quy trình đặt lịch</div>
          </div>
          <div class="sidebar-card-body">
            <div class="steps-mini">
              <div class="step-mini">
                <div class="step-mini-num">1</div>
                <div class="step-mini-text"><strong>Điền form</strong>Chọn dịch vụ và điền thông tin xe, khách hàng</div>
              </div>
              <div class="step-mini">
                <div class="step-mini-num">2</div>
                <div class="step-mini-text"><strong>Xác nhận SMS</strong>Nhận mã xác nhận & lịch hẹn qua SMS</div>
              </div>
              <div class="step-mini">
                <div class="step-mini-num">3</div>
                <div class="step-mini-text"><strong>Đến xưởng</strong>Mang xe đến đúng giờ, KTV đã chờ sẵn</div>
              </div>
              <div class="step-mini">
                <div class="step-mini-num">4</div>
                <div class="step-mini-text"><strong>Nhận xe</strong>Thanh toán và nhận xe sau khi hoàn thành</div>
              </div>
            </div>
          </div>
        </div>

        <div class="sidebar-card" style="background:var(--gray-1)">
          <div class="sidebar-card-header" style="background:var(--gray-2)">
            <div class="sidebar-card-icon">
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div class="sidebar-card-title">Lưu ý khi đặt lịch</div>
          </div>
          <div class="sidebar-card-body">
            <ul class="notes-list">
              <li>Đặt lịch trước ít nhất 24 giờ</li>
              <li>Mang theo giấy tờ xe khi đến</li>
              <li>Hủy/đổi lịch báo trước 2 giờ</li>
              <li>Xe được giữ miễn phí trong 24h</li>
            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
/* ── Scroll animations ── */
const observer = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
}, { threshold: 0.12 });
document.querySelectorAll('[data-anim]').forEach(el => observer.observe(el));

/* ── Topic data per service ── */
const SVC_LABELS = {
  baoduong: 'Bảo dưỡng',
  suachua:  'Sửa chữa',
  kiemtra:  'Kiểm tra',
  dien:     'Điện & ECU',
  lop:      'Lốp & La-zăng',
  laithu:   'Lái thử'
};

const SVC_TOPICS = {
  baoduong: ['Bảo dưỡng định kỳ','Thay dầu nhớt & lọc','Thay bộ lọc gió','Kiểm tra & thay bugi','Vệ sinh kim phun nhiên liệu','Thay dây curoa','Thay nước làm mát'],
  suachua:  ['Sửa chữa động cơ','Hệ thống phanh','Hệ thống treo & giảm xóc','Hộp số & ly hợp','Hệ thống lái','Sửa rò rỉ dầu','Sửa chữa thân vỏ'],
  kiemtra:  ['Kiểm tra tổng quát','Kiểm tra trước khi mua xe','Kiểm tra định kỳ 5.000 km','Kiểm tra sau tai nạn','Đánh giá tình trạng xe cũ'],
  dien:     ['Chẩn đoán ECU / OBD2','Điều hòa & hệ thống lạnh','Hệ thống đèn chiếu sáng','Camera & cảm biến đỗ xe','Ắc quy & hệ thống khởi động','Màn hình & giải trí xe'],
  lop:      ['Thay lốp mới','Vá lốp khẩn cấp','Cân bằng động bánh xe','Chỉnh góc đặt bánh (Alignment)','Thay la-zăng','Kiểm tra áp suất lốp'],
  laithu:   ['Lái thử xe mới','Lái thử xe đã qua sử dụng','Tư vấn chọn mua xe','So sánh 2 mẫu xe','Lái thử xe điện / hybrid']
};

let activeSvc = 'baoduong';
let activeTopic = null;

function renderTopics(svc) {
  const chips = document.getElementById('topicChips');
  const badge = document.getElementById('selectedSvcBadge');
  badge.textContent = SVC_LABELS[svc] || svc;
  activeTopic = null;
  document.getElementById('hiddenChuDe').value = '';
  chips.innerHTML = SVC_TOPICS[svc].map(t =>
    `<div class="chip" onclick="selectTopic(this,'${t}')">${t}</div>`
  ).join('');
}

function selectTopic(el, val) {
  document.querySelectorAll('.chip').forEach(c => c.classList.remove('selected'));
  el.classList.add('selected');
  activeTopic = val;
  document.getElementById('hiddenChuDe').value = val;
}

/* ── Service card selection ── */
document.querySelectorAll('.svc-type-card').forEach(card => {
  card.addEventListener('click', () => {
    document.querySelectorAll('.svc-type-card').forEach(c => c.classList.remove('active'));
    card.classList.add('active');
    activeSvc = card.dataset.svc;
    document.getElementById('hiddenDichVu').value = activeSvc;
    renderTopics(activeSvc);
  });
});

/* ── Time slot ── */
function selectTime(slot) {
  if (slot.classList.contains('unavailable')) return;
  document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('active'));
  slot.classList.add('active');
}

/* ── Date min (tomorrow) ── */
const dateInput = document.getElementById('booking-date');
if (dateInput) {
  const t = new Date(); t.setDate(t.getDate() + 1);
  dateInput.min = t.toISOString().split('T')[0];
}

/* ── Validation helpers ── */
function clearErrors() {
  document.querySelectorAll('.field-error').forEach(e => e.remove());
  document.querySelectorAll('.input-error').forEach(e => e.classList.remove('input-error'));
}

function showError(name, msg) {
  const input = document.querySelector('[name="' + name + '"]');
  if (!input) return;
  input.classList.add('input-error');
  const err = document.createElement('span');
  err.className = 'field-error';
  err.textContent = msg;
  input.parentNode.appendChild(err);
}

/* ── Submit handler ── */
function handleSubmit() {
  clearErrors();

  const ten   = document.querySelector('[name="ho_ten"]').value.trim();
  const tel   = document.querySelector('[name="dien_thoai"]').value.trim();
  const email = document.querySelector('[name="email"]').value.trim();
  const ngay  = document.querySelector('[name="ngay"]').value.trim();

  let hasError = false;
  function flag(name, msg) { showError(name, msg); hasError = true; }

  if (!ten) flag('ho_ten', 'Vui lòng nhập họ và tên');
  if (!tel) {
    flag('dien_thoai', 'Vui lòng nhập số điện thoại');
  } else if (!/^[0-9]{10}$/.test(tel.replace(/\s/g, ''))) {
    flag('dien_thoai', 'Số điện thoại phải đủ 10 chữ số');
  }
  if (!email) {
    flag('email', 'Vui lòng nhập email');
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    flag('email', 'Email không hợp lệ');
  }
  if (!ngay) flag('ngay', 'Vui lòng chọn ngày đặt lịch');

  if (hasError) return false;

  const btn = document.getElementById('btnSubmit');
  btn.classList.add('loading');
  btn.disabled = true;

  submitBooking(btn);
  return false;
}

/* ── API call ── */
function submitBooking(btn) {
  const formData = {
    _token:     '{{ csrf_token() }}',
    ho_ten:     document.querySelector('[name="ho_ten"]').value,
    dien_thoai: document.querySelector('[name="dien_thoai"]').value,
    email:      document.querySelector('[name="email"]').value,
    ngay:       document.querySelector('[name="ngay"]').value,
    dich_vu:    document.getElementById('hiddenDichVu').value,
    chu_de:     document.getElementById('hiddenChuDe').value,
    hang_xe:    document.querySelector('[name="hang_xe"]')?.value ?? '',
    mau_xe:     document.querySelector('[name="mau_xe"]')?.value ?? '',
    so_km:      document.querySelector('[name="so_km"]')?.value ?? '',
    gio:        document.querySelector('.time-slot.active')?.textContent ?? '',
    ghi_chu:    document.querySelector('[name="ghi_chu"]')?.value ?? '',
  };

  fetch('{{ route("booking.store") }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(formData)
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      document.getElementById('booking-ref').textContent = data.ref;
      document.getElementById('booking-form-view').style.display = 'none';
      const s = document.getElementById('booking-success');
      s.style.display = 'block';
      s.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
      btn.classList.remove('loading');
      btn.disabled = false;
      alert('Có lỗi xảy ra, vui lòng thử lại!');
    }
  })
  .catch(() => {
    btn.classList.remove('loading');
    btn.disabled = false;
    alert('Có lỗi xảy ra, vui lòng thử lại!');
  });
}

/* ── Dependent dropdown ── */
const DONG_XE = {
  mercedes: [
    'Mercedes-AMG GLE',
    'Mercedes-Benz E-Class',
    'Mercedes-Benz EQS',
    'Mercedes-Benz G-Class',
    'Mercedes-Benz GLE',
    'Mercedes-Benz GLS',
    'Mercedes-Benz S-Class',
    'Mercedes-Benz SL-Class',
    'Mercedes-Maybach GLS',
    'Mercedes-Maybach S-Class',
  ],
  vinfast: [
    'VinFast VF 3',
    'VinFast VF 5',
    'VinFast VF 6',
    'VinFast VF 7',
    'VinFast VF 8',
    'VinFast VF 9',
  ],
};

function loadDongXe() {
  const hang   = document.getElementById('selectHangXe').value;
  const select = document.getElementById('selectDongXe');

  if (!hang || !DONG_XE[hang]) {
    select.innerHTML = '<option value="">-- Chọn hãng trước --</option>';
    return;
  }

  select.innerHTML = '<option value="">-- Chọn dòng xe --</option>';
  DONG_XE[hang].forEach(xe => {
    const opt = document.createElement('option');
    opt.value = xe;
    opt.textContent = xe;
    select.appendChild(opt);
  });
}

/* ── Auto-fill từ URL params ── */
(function(){
  const params = new URLSearchParams(window.location.search);
  const svc = params.get('svc');
  if (svc) {
    const card = document.querySelector(`.svc-type-card[data-svc="${svc}"]`);
    if (card) {
      document.querySelectorAll('.svc-type-card').forEach(c => c.classList.remove('active'));
      card.classList.add('active');
      activeSvc = svc;
      document.getElementById('hiddenDichVu').value = svc;
      renderTopics(svc);
      const chuDe = params.get('chu_de');
      if (chuDe) {
        document.querySelectorAll('.chip').forEach(chip => {
          if (chip.textContent === chuDe) selectTopic(chip, chuDe);
        });
      }
    }
  }
})();

/* ── Init topics ── */
renderTopics('baoduong');
</script>
@endpush