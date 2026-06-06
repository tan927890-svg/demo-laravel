@extends('layouts.frontend')

@section('title', 'Lịch Bảo Dưỡng Định Kỳ - AUTO X')

@push('styles')
<style>
  :root {
    --red: #1c69d4; --red-dark: #1555b0;
    --red-light: rgba(28,105,212,0.08); --red-border: rgba(28,105,212,0.25);
    --bg: #f7f7f7; --bg2: #f0f0f0; --bg3: #e8e8e8; --card: #ffffff;
    --border: #e8e8e8; --border-light: #d4d4d4;
    --white: #ffffff; --text: #1a1a1a; --muted: #777777; --subtle: #999999;
  }

  *, *::before, *::after { box-sizing: border-box; }

  .container { max-width: 1240px; margin: 0 auto; padding: 0 48px; }

  .section-label {
    font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; color: var(--red);
    margin-bottom: 12px; display: flex; align-items: center; gap: 10px;
  }
  .section-label::before { content: ''; width: 3px; height: 15px; background: var(--red); flex-shrink: 0; }

  .section-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(28px, 5vw, 56px); font-weight: 800;
    text-transform: uppercase; color: var(--text); letter-spacing: 0;
    line-height: 1.08;
  }
  .divider-line { width: 56px; height: 3px; background: var(--red); margin: 24px 0; }

  /* ── HERO ── */
  .hero {
    position: relative;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    padding: 52px 16px 28px; overflow: hidden; min-height: 320px;
  }
  .hero-bg {
    position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1600&q=80') center/cover no-repeat;
    z-index: 0;
  }
  .hero-overlay { position: absolute; inset: 0; z-index: 1; background: linear-gradient(160deg,rgba(28,26,22,0.72) 0%,rgba(28,26,22,0.52) 50%,rgba(28,26,22,0.72) 100%); }
  .hero-content { position: relative; text-align: center; z-index: 3; padding: 0; width: 100%; }

  .hero-eyebrow {
    font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; color: var(--white);
    margin-bottom: 14px; display: flex; align-items: center; justify-content: center; gap: 10px;
  }
  .hero-eyebrow::before, .hero-eyebrow::after { content: ''; width: 24px; height: 1px; background: var(--red); opacity: .6; }

  .hero h1 {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(38px, 10vw, 92px); font-weight: 800;
    color: #ffffff; line-height: 1.0; text-transform: uppercase; letter-spacing: -0.5px;
  }
  .hero h1 em { color: var(--red); font-style: normal; }

  .hero-sub {
    margin-top: 12px; font-size: 14px; line-height: 1.55;
    color: rgba(245,240,232,0.78); letter-spacing: 0.2px;
  }

  .breadcrumb {
    position: relative; z-index: 4; margin-top: 22px;
    display: inline-flex; align-items: center; gap: 8px; flex-wrap: wrap; justify-content: center;
    font-size: 12px; letter-spacing: 0.2px;
    color: rgba(245,240,232,0.9); background: rgba(10,10,10,0.32);
    padding: 7px 16px; border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.35); backdrop-filter: blur(6px);
  }
  .breadcrumb, .breadcrumb a { color: #ffffff !important; }
  .breadcrumb a { text-decoration: none; transition: color .18s; }
  .breadcrumb a:hover { color: var(--red); }
  .breadcrumb span { color: var(--red); font-weight: 700; }

  /* ── INTRO ── */
  .intro-section { background: var(--bg); padding: 56px 0 48px; }
  .intro-section p { font-size: 15px; color: var(--muted); line-height: 1.85; max-width: 680px; }

  .intro-box {
    background: var(--red-light); border: 1px solid var(--red-border);
    padding: 20px 20px; display: flex; align-items: flex-start; gap: 16px; margin-top: 24px;
    border-radius: 8px;
  }
  .intro-box svg { width: 26px; height: 26px; stroke: var(--red); fill: none; stroke-width: 1.6; flex-shrink: 0; margin-top: 2px; }
  .intro-box p { font-size: 14px !important; color: var(--text); line-height: 1.8; margin: 0; }

  /* ── CALCULATOR ── */
  .calc-section { background: var(--bg2); padding: 56px 0; }
  .calc-wrap { background: var(--card); border-radius: 12px; border: 1px solid var(--border); padding: 28px 24px; }

  .calc-title {
    font-family: 'Barlow Condensed', sans-serif; font-size: 20px; font-weight: 800;
    text-transform: uppercase; color: var(--text); margin-bottom: 24px;
    display: flex; align-items: center; gap: 10px; letter-spacing: 0;
  }
  .calc-title span { width: 34px; height: 34px; background: var(--red); color: #fff; display: flex; align-items: center; justify-content: center; border-radius: 8px; flex-shrink: 0; }
  .calc-title span svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; }

  .calc-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

  .calc-group label {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
    letter-spacing: 1.5px; text-transform: uppercase; color: var(--muted);
    display: block; margin-bottom: 7px;
  }
  .calc-group input, .calc-group select {
    width: 100%; padding: 11px 14px; border: 1px solid var(--border); background: var(--bg);
    font-size: 14px; color: var(--text); font-family: 'Barlow', sans-serif; outline: none;
    transition: border-color .2s, background .2s; appearance: none; border-radius: 8px;
    line-height: 1.5;
  }
  .calc-group select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23888' stroke-width='1.5' fill='none'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 12px center; background-size: 11px; padding-right: 34px; cursor: pointer;
  }
  .calc-group input:focus, .calc-group select:focus { border-color: var(--red); background: var(--white); }

  .calc-group.full-col { grid-column: 1 / -1; }

  .btn-calc {
    width: 100%; padding: 13px; background: var(--red); color: #fff; border: none; cursor: pointer;
    font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;
    transition: background .2s; border-radius: 8px; grid-column: 1 / -1;
  }
  .btn-calc:hover { background: var(--red-dark); }

  /* ── RESULT ── */
  .calc-result { margin-top: 28px; display: none; }
  .calc-result.show { display: block; }
  .result-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; border-top: 1px solid var(--border); padding-top: 24px; }
  .result-card { padding: 0; }
  .result-card strong { font-family: 'Barlow Condensed', sans-serif; font-size: 32px; font-weight: 800; color: var(--red); display: block; line-height: 1.1; }
  .result-card span { font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; color: var(--subtle); display: block; margin-top: 5px; }
  .result-card p { font-size: 12px; color: var(--muted); margin-top: 6px; line-height: 1.5; }

  .result-alert { background: var(--red); padding: 14px 18px; display: flex; align-items: flex-start; gap: 12px; margin-top: 20px; border-radius: 8px; }
  .result-alert svg { width: 18px; height: 18px; stroke: #fff; fill: none; stroke-width: 2; flex-shrink: 0; margin-top: 2px; }
  .result-alert p { margin: 0; color: #fff; font-size: 14px; font-weight: 600; line-height: 1.5; }

  /* ── SCHEDULE TABLE ── */
  .schedule-section { background: var(--bg); padding: 56px 0; }
  .tabs { display: flex; gap: 2px; background: var(--border); border-radius: 8px 8px 0 0; overflow: hidden; }
  .tab-btn {
    flex: 1; padding: 13px 10px; border: none; background: var(--bg2); cursor: pointer;
    font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700; letter-spacing: 1px;
    text-transform: uppercase; color: var(--muted); transition: background .2s, color .2s; line-height: 1.3;
  }
  .tab-btn.active { background: var(--card); color: var(--red); }
  .tab-panel { display: none; }
  .tab-panel.active { display: block; }

  .schedule-table { width: 100%; border-collapse: collapse; }
  .schedule-table thead tr { background: var(--text); }
  .schedule-table thead th {
    padding: 13px 10px; text-align: center;
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
    letter-spacing: 1px; text-transform: uppercase; white-space: nowrap;
  }
  .schedule-table thead th:first-child { text-align: left; color: #f5f0e8; min-width: 140px; }
  .schedule-table thead th:not(:first-child) { color: rgba(245,240,232,0.65); min-width: 58px; }
  .km-header { color: #6eaaff !important; opacity: 1 !important; }

  .schedule-table tbody tr { border-bottom: 1px solid var(--border); transition: background .18s; }
  .schedule-table tbody tr:nth-child(even) { background: var(--bg); }
  .schedule-table tbody tr:hover { background: var(--bg3); }
  .schedule-table tbody td { padding: 11px 10px; vertical-align: middle; font-size: 13px; line-height: 1.45; }
  .schedule-table tbody td:first-child { font-size: 13px; color: var(--text); font-weight: 500; }
  .schedule-table tbody td:not(:first-child) { text-align: center; }

  .dot-check   { color: #16a34a; font-size: 16px; font-weight: 700; line-height: 1; }
  .dot-inspect { color: #d97706; font-size: 14px; font-weight: 600; line-height: 1; }
  .dot-none    { color: #b0b0b0; font-size: 14px; font-weight: 400; line-height: 1; }

  .cat-row td {
    background: var(--bg3);
    font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase; color: var(--muted);
    padding: 10px 10px !important;
  }

  .legend { display: flex; gap: 16px; flex-wrap: wrap; padding: 14px 16px; background: var(--bg2); border-top: 1px solid var(--border); font-size: 12px; color: var(--muted); line-height: 1.6; }
  .legend-item { display: flex; align-items: center; gap: 6px; }

  /* ── TABLE TOGGLE ── */
  .table-toggle-btn {
    display: flex; align-items: center; justify-content: center;
    width: 100%; height: 40px; background: var(--red);
    border: none; cursor: pointer; transition: background .2s;
  }
  .table-toggle-btn:hover { background: var(--red-dark); }
  .table-toggle-btn .toggle-icon {
    color: #fff; font-size: 14px; line-height: 1;
    transition: transform .3s;
  }
  .table-collapsible { overflow: hidden; max-height: 0; transition: max-height .4s ease; }
  .table-collapsible.open { max-height: 3000px; }
  .table-toggle-btn.open .toggle-icon { transform: rotate(180deg); }

  /* ── BRANDS ── */
  .brands-section { background: var(--bg2); padding: 56px 0; }
  .brands-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; margin-top: 36px; }
  .brand-card {
    background: var(--card); padding: 22px 16px 18px; text-align: center;
    cursor: pointer; transition: background .2s, transform .2s, box-shadow .2s;
    border-radius: 12px; border: 1px solid var(--border);
    display: flex; flex-direction: column; align-items: center;
  }
  .brand-card:hover { background: var(--bg3); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.07); }

  .brand-logo-wrap {
    width: 64px; height: 64px; border-radius: 50%;
    background: var(--white); border: 1.5px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 12px; overflow: hidden; flex-shrink: 0;
    transition: border-color .2s, box-shadow .2s;
  }
  .brand-card:hover .brand-logo-wrap { border-color: var(--red); box-shadow: 0 0 0 3px var(--red-light); }
  .brand-logo-wrap img { width: 46px; height: 46px; object-fit: contain; object-position: center; display: block; }
  .brand-logo-wrap img.logo-sm { width: 36px; height: 36px; }
  .brand-logo-wrap img.logo-lg { width: 54px; height: 54px; }

  .brand-name { font-family: 'Barlow Condensed', sans-serif; font-size: 19px; font-weight: 800; text-transform: uppercase; color: var(--text); letter-spacing: 0.3px; margin-bottom: 6px; }
  .brand-interval { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--red); }
  .brand-note { font-size: 12px; color: var(--muted); margin-top: 6px; line-height: 1.4; }

  /* ── REMINDER ── */
  .reminder-section { padding: 56px 0; position: relative; overflow: hidden; }
  .reminder-section::before {
    content: ''; position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1600&q=80') center/cover no-repeat;
    z-index: 0;
  }
  .reminder-section::after { content: ''; position: absolute; inset: 0; background: rgba(5,10,20,0.55); z-index: 1; }
  .reminder-section .container { position: relative; z-index: 2; }

  .reminder-grid { display: grid; grid-template-columns: 1fr 1.2fr; gap: 56px; align-items: center; }

  .reminder-text .section-label { color: rgba(100,160,255,0.9); }
  .reminder-text .section-label::before { background: rgba(100,160,255,0.9); }
  .reminder-text h2 {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(30px, 4.5vw, 56px); font-weight: 800;
    text-transform: uppercase; color: #ffffff !important; line-height: 1.08;
  }
  .reminder-text h2 em { color: var(--red); font-style: normal; }
  .reminder-text p { color: rgba(233,232,232,0.97) !important; font-size: 14px !important; line-height: 1.8; margin-top: 14px; }

  .reminder-form { background: rgba(255,255,255,0.92); border: 1px solid rgba(255,255,255,.15); padding: 28px 22px; border-radius: 12px; }

  .rf-label {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
    letter-spacing: 1.5px; text-transform: uppercase; color: rgba(4,3,3,0.75);
    margin-bottom: 7px; display: block;
  }
  .rf-input {
    width: 100%; padding: 11px 14px;
    background: #ffffff; border: 1px solid #ccc;
    color: #000000; font-family: 'Barlow', sans-serif;
    font-size: 14px; outline: none; margin-bottom: 14px;
    transition: border-color .2s; border-radius: 8px; line-height: 1.5;
  }
  .rf-input:focus { border-color: rgba(28,105,212,0.6); }
  .rf-input::placeholder { color: #999; }

  .rf-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23888' stroke-width='1.5' fill='none'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 12px center; background-size: 11px; padding-right: 34px; cursor: pointer;
  }
  .rf-select option { background: #1a1a1a; color: #ffffff; }

  .btn-remind {
    width: 100%; padding: 14px; background: var(--red); color: #fff; border: none; cursor: pointer;
    font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;
    transition: background .2s; border-radius: 8px;
  }
  .btn-remind:hover { background: var(--red-dark); }

  #rf-error { font-size: 13px !important; line-height: 1.6; }

  /* ── ANIMATIONS ── */
  [data-anim] { opacity: 0; transform: translateY(24px); transition: opacity .6s ease, transform .6s ease; }
  [data-anim].visible { opacity: 1; transform: translateY(0); }
  [data-anim="left"] { transform: translateX(-24px); }
  [data-anim="left"].visible { transform: translateX(0); }
  [data-anim="right"] { transform: translateX(24px); }
  [data-anim="right"].visible { transform: translateX(0); }

  /* ══════════════════════════════════════
     RESPONSIVE — mobile-first breakpoints
  ══════════════════════════════════════ */

  /* ≤ 768px — tablet & large phone */
  @media (max-width: 768px) {
    .container { padding: 0 16px; }

    /* hero */
    .hero { padding: 40px 16px 24px; min-height: 0; }
    .breadcrumb { font-size: 11px; padding: 6px 12px; }

    /* sections */
    .intro-section, .calc-section, .schedule-section, .brands-section, .reminder-section { padding: 40px 0; }

    /* intro box */
    .intro-box { flex-direction: column; gap: 10px; padding: 16px; }
    .intro-box svg { margin-top: 0; }

    /* calc */
    .calc-wrap { padding: 20px 16px; border-radius: 10px; }
    .calc-grid { grid-template-columns: 1fr; gap: 12px; }
    .calc-group.full-col { grid-column: 1; }
    .btn-calc { grid-column: 1; }

    /* result */
    .result-cards { grid-template-columns: 1fr 1fr; gap: 14px; }
    .result-card strong { font-size: 26px; }

    /* tabs */
    .tabs { border-radius: 6px 6px 0 0; }
    .tab-btn { font-size: 11px; padding: 11px 6px; letter-spacing: 0.5px; }

    /* table: horizontal scroll */
    .table-scroll-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .schedule-table { min-width: 480px; }
    .schedule-table thead th { font-size: 10px; padding: 11px 8px; }
    .schedule-table tbody td { padding: 10px 8px; font-size: 12px; }
    .schedule-table tbody td:first-child { font-size: 12px; min-width: 130px; }
    .schedule-table thead th:not(:first-child) { min-width: 50px; }

    /* brands */
    .brands-grid { grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 24px; }
    .brand-card { padding: 18px 12px 14px; border-radius: 10px; }
    .brand-logo-wrap { width: 52px; height: 52px; margin-bottom: 10px; }
    .brand-logo-wrap img { width: 38px; height: 38px; }
    .brand-name { font-size: 16px; }
    .brand-interval { font-size: 10px; }
    .brand-note { font-size: 11px; }

    /* reminder */
    .reminder-grid { grid-template-columns: 1fr; gap: 28px; }
    .reminder-form { padding: 22px 18px; border-radius: 10px; }
    .reminder-text p { margin-top: 10px; }
  }

  /* ≤ 480px — small phone */
  @media (max-width: 480px) {
    /* hero */
    .hero { padding: 36px 16px 20px; }
    .hero-sub { font-size: 13px; }
    .hero-eyebrow { font-size: 11px; letter-spacing: 2px; }

    /* result — stack 1 col */
    .result-cards { grid-template-columns: 1fr; gap: 12px; border-top-width: 1px; }
    .result-card { padding-bottom: 12px; border-bottom: 1px solid var(--border-light); }
    .result-card:last-child { border-bottom: none; padding-bottom: 0; }
    .result-card strong { font-size: 28px; }

    /* brands — stack 1 col */
    .brands-grid { grid-template-columns: 1fr; gap: 10px; }
    .brand-card { flex-direction: row; text-align: left; padding: 14px 16px; gap: 14px; }
    .brand-logo-wrap { width: 48px; height: 48px; flex-shrink: 0; margin-bottom: 0; }
    .brand-info { display: flex; flex-direction: column; gap: 2px; }
    .brand-name { font-size: 17px; margin-bottom: 2px; }
    .brand-interval { font-size: 10px; }
    .brand-note { font-size: 11px; margin-top: 2px; }

    /* calc */
    .calc-title { font-size: 17px; }

    /* tabs — 3 equal cols, smaller text */
    .tabs { display: grid; grid-template-columns: repeat(3, 1fr); }
    .tab-btn { font-size: 10px; padding: 10px 4px; letter-spacing: 0; }

    /* table: tighter */
    .schedule-table { min-width: 440px; }

    /* legend */
    .legend { gap: 10px; font-size: 11px; padding: 12px 12px; }
  }

  /* ≤ 360px — very small phones */
  @media (max-width: 360px) {
    .container { padding: 0 12px; }
    .hero { padding: 32px 12px 18px; }
    .hero h1 { font-size: 34px; }
    .hero-sub { display: none; }
    .section-title { font-size: clamp(22px, 7vw, 36px) !important; }
    .calc-wrap { padding: 16px 12px; }
    .schedule-table { min-width: 400px; }
  }
</style>
@endpush

@section('content')

@include('partials.icons')

{{-- HERO --}}
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <div class="hero-eyebrow">Bảo vệ xe từ sớm</div>
    <h1>Lịch Bảo <em>Dưỡng</em> Định Kỳ</h1>
    <p class="hero-sub">Biết đúng thời điểm — Bảo vệ đúng cách — Tiết kiệm đúng chỗ</p>
  </div>
  <div class="breadcrumb">
    <a href="{{ url('/') }}">Home</a> &rsaquo;
    <a href="{{ url('/services') }}">Dịch Vụ</a> &rsaquo;
    <span>Lịch Bảo Dưỡng Định Kỳ</span>
  </div>
</section>

{{-- INTRO --}}
<section class="intro-section">
  <div class="container">
    <div data-anim>
      <div class="section-label">Tại sao cần bảo dưỡng đúng lịch</div>
      <h2 class="section-title">Bảo Dưỡng <em style="color:var(--red);font-style:normal">Đúng Hạn</em></h2>
      <div class="divider-line"></div>
      <p style="color:var(--text);font-size:15px;line-height:1.85;max-width:680px">Theo nghiên cứu của các nhà sản xuất ô tô hàng đầu, xe được bảo dưỡng đúng lịch có tuổi thọ động cơ cao hơn 40% và tiết kiệm chi phí sửa chữa lớn lên đến 60% so với xe không được bảo dưỡng định kỳ.</p>
      <div class="intro-box">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <p><strong>Lưu ý quan trọng:</strong> Lịch bảo dưỡng bên dưới áp dụng cho điều kiện vận hành thông thường tại Việt Nam. Xe hoạt động trong điều kiện khắc nghiệt (kẹt xe thường xuyên, đường đồi núi, khí hậu nóng ẩm) nên rút ngắn chu kỳ bảo dưỡng 20–30%.</p>
      </div>
    </div>
  </div>
</section>

{{-- CALCULATOR --}}
<section class="calc-section">
  <div class="container">
    <div data-anim>
      <div class="section-label">Công cụ tra cứu</div>
      <h2 class="section-title">Tính Lịch Bảo <em style="color:var(--red);font-style:normal">Dưỡng</em></h2>
    </div>
    <div class="calc-wrap" data-anim style="transition-delay:.1s;margin-top:24px">
      <div class="calc-title">
        <span><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></span>
        Tra cứu lịch bảo dưỡng của bạn
      </div>
      <div class="calc-grid">
        <div class="calc-group">
          <label>Số km hiện tại</label>
          <input type="number" id="calc-km" placeholder="VD: 45000" min="0" inputmode="numeric">
        </div>
        <div class="calc-group">
          <label>Km bảo dưỡng gần nhất</label>
          <input type="number" id="calc-last" placeholder="VD: 40000" min="0" inputmode="numeric">
        </div>
        <div class="calc-group full-col">
          <label>Hãng xe</label>
          <select id="calc-brand">
            <option value="5000">Toyota / Honda / Mazda (5,000 km)</option>
            <option value="7500">Ford / Hyundai / Kia (7,500 km)</option>
            <option value="10000">BMW / Mercedes / Audi (10,000 km)</option>
            <option value="5000">VinFast (5,000 km)</option>
          </select>
        </div>
        <button class="btn-calc" onclick="calcMaintenance()">Tính ngay</button>
      </div>

      <div class="calc-result" id="calc-result">
        <div class="result-cards">
          <div class="result-card">
            <strong id="res-done">0</strong>
            <span>Km đã đi từ lần cuối</span>
            <p>Kể từ lần bảo dưỡng gần nhất</p>
          </div>
          <div class="result-card">
            <strong id="res-remain">0</strong>
            <span>Km còn lại</span>
            <p>Đến kỳ bảo dưỡng tiếp theo</p>
          </div>
          <div class="result-card">
            <strong id="res-next">0</strong>
            <span>Km bảo dưỡng tiếp</span>
            <p>Mốc cần bảo dưỡng lần tới</p>
          </div>
          <div class="result-card">
            <strong id="res-status">OK</strong>
            <span>Trạng thái</span>
            <p id="res-status-desc">Xe đang trong tình trạng tốt</p>
          </div>
        </div>
        <div class="result-alert" id="res-alert" style="display:none">
          <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
          <p id="res-alert-text">Xe đã đến hoặc quá hạn bảo dưỡng. Hãy đặt lịch ngay!</p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- SCHEDULE TABLE --}}
<section class="schedule-section">
  <div class="container">
    <div data-anim>
      <div class="section-label">Lịch chi tiết</div>
      <h2 class="section-title">Bảng Lịch Bảo <em style="color:var(--red);font-style:normal">Dưỡng</em> Theo Km</h2>
    </div>
    <div data-anim style="transition-delay:.1s;margin-top:32px">
      <div class="tabs">
        <button class="tab-btn active" onclick="switchTab('petrol', this)">Xe Xăng</button>
        <button class="tab-btn" onclick="switchTab('diesel', this)">Xe Dầu</button>
        <button class="tab-btn" onclick="switchTab('electric', this)">Xe Điện/Hybrid</button>
      </div>

      {{-- PETROL --}}
      <div class="tab-panel active" id="tab-petrol">
        <button class="table-toggle-btn" onclick="toggleTable(this)" aria-label="Mở rộng bảng xe xăng">
          <span class="toggle-icon">▼</span>
        </button>
        <div class="table-collapsible">
          <div class="table-scroll-wrap">
            <table class="schedule-table">
              <thead>
                <tr>
                  <th>Hạng mục bảo dưỡng</th>
                  <th class="km-header">10K</th>
                  <th>20K</th>
                  <th class="km-header">40K</th>
                  <th>60K</th>
                  <th class="km-header">80K</th>
                  <th>100K</th>
                </tr>
              </thead>
              <tbody>
                <tr class="cat-row"><td colspan="7">Dầu nhớt &amp; Bộ lọc</td></tr>
                <tr><td>Dầu động cơ</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td></tr>
                <tr><td>Lọc dầu động cơ</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td></tr>
                <tr><td>Lọc gió động cơ</td><td class="dot-none">–</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-none">–</td><td class="dot-check">✓</td></tr>
                <tr><td>Lọc gió điều hòa</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-none">–</td></tr>
                <tr><td>Lọc nhiên liệu</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-check">✓</td><td class="dot-none">–</td><td class="dot-none">–</td></tr>
                <tr class="cat-row"><td colspan="7">Hệ thống phanh &amp; Lốp</td></tr>
                <tr><td>Kiểm tra má phanh</td><td class="dot-inspect">✗</td><td class="dot-inspect">✗</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-inspect">✗</td><td class="dot-check">✓</td></tr>
                <tr><td>Kiểm tra áp suất lốp</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td></tr>
                <tr><td>Xoay lốp</td><td class="dot-none">–</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-none">–</td><td class="dot-check">✓</td></tr>
                <tr><td>Dầu phanh</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-check">✓</td></tr>
                <tr class="cat-row"><td colspan="7">Động cơ &amp; Hệ thống</td></tr>
                <tr><td>Bugi đánh lửa</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-check">✓</td></tr>
                <tr><td>Nước làm mát</td><td class="dot-inspect">✗</td><td class="dot-inspect">✗</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-check">✓</td><td class="dot-none">–</td></tr>
                <tr><td>Đai cam / Xích cam</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-inspect">✗</td><td class="dot-none">–</td><td class="dot-check">✓</td></tr>
                <tr><td>Quét mã lỗi OBD</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td></tr>
              </tbody>
            </table>
          </div>
          <div class="legend">
            <div class="legend-item"><span style="color:#16a34a;font-weight:700;font-size:15px">✓</span> Thực hiện / Thay thế</div>
            <div class="legend-item"><span style="color:#d97706;font-weight:600;font-size:13px">✗</span> Kiểm tra, thay nếu cần</div>
            <div class="legend-item"><span style="color:#b0b0b0;font-size:13px">–</span> Không áp dụng</div>
          </div>
        </div>
      </div>

      {{-- DIESEL --}}
      <div class="tab-panel" id="tab-diesel">
        <button class="table-toggle-btn" onclick="toggleTable(this)" aria-label="Mở rộng bảng xe dầu">
          <span class="toggle-icon">▼</span>
        </button>
        <div class="table-collapsible">
          <div class="table-scroll-wrap">
            <table class="schedule-table">
              <thead>
                <tr>
                  <th>Hạng mục bảo dưỡng</th>
                  <th class="km-header">10K</th>
                  <th>20K</th>
                  <th class="km-header">40K</th>
                  <th>60K</th>
                  <th class="km-header">80K</th>
                  <th>100K</th>
                </tr>
              </thead>
              <tbody>
                <tr class="cat-row"><td colspan="7">Dầu nhớt &amp; Bộ lọc Diesel</td></tr>
                <tr><td>Dầu động cơ Diesel</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td></tr>
                <tr><td>Lọc dầu</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td></tr>
                <tr><td>Lọc nhiên liệu Diesel</td><td class="dot-none">–</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-none">–</td><td class="dot-check">✓</td><td class="dot-none">–</td></tr>
                <tr><td>Bình lọc nước diesel</td><td class="dot-inspect">✗</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-inspect">✗</td><td class="dot-check">✓</td><td class="dot-inspect">✗</td></tr>
                <tr class="cat-row"><td colspan="7">Hệ thống đặc thù Diesel</td></tr>
                <tr><td>DPF / Hệ thống khí thải</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-check">✓</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-check">✓</td></tr>
                <tr><td>Vòi phun nhiên liệu</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-check">✓</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-check">✓</td></tr>
                <tr><td>Quét mã lỗi OBD</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td></tr>
              </tbody>
            </table>
          </div>
          <div class="legend">
            <div class="legend-item"><span style="color:#16a34a;font-weight:700;font-size:15px">✓</span> Thực hiện / Thay thế</div>
            <div class="legend-item"><span style="color:#d97706;font-weight:600;font-size:13px">✗</span> Kiểm tra, thay nếu cần</div>
            <div class="legend-item"><span style="color:#b0b0b0;font-size:13px">–</span> Không áp dụng</div>
          </div>
        </div>
      </div>

      {{-- ELECTRIC --}}
      <div class="tab-panel" id="tab-electric">
        <button class="table-toggle-btn" onclick="toggleTable(this)" aria-label="Mở rộng bảng xe điện">
          <span class="toggle-icon">▼</span>
        </button>
        <div class="table-collapsible">
          <div class="table-scroll-wrap">
            <table class="schedule-table">
              <thead>
                <tr>
                  <th>Hạng mục bảo dưỡng</th>
                  <th class="km-header">10K</th>
                  <th>20K</th>
                  <th class="km-header">40K</th>
                  <th>60K</th>
                  <th class="km-header">80K</th>
                  <th>100K</th>
                </tr>
              </thead>
              <tbody>
                <tr class="cat-row"><td colspan="7">Pin &amp; Hệ thống điện</td></tr>
                <tr><td>Kiểm tra dung lượng pin</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td></tr>
                <tr><td>Kiểm tra dây điện &amp; connector</td><td class="dot-inspect">✗</td><td class="dot-inspect">✗</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-inspect">✗</td><td class="dot-check">✓</td></tr>
                <tr><td>Làm mát pin</td><td class="dot-inspect">✗</td><td class="dot-inspect">✗</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-inspect">✗</td><td class="dot-check">✓</td></tr>
                <tr class="cat-row"><td colspan="7">Hệ thống phanh &amp; Lốp</td></tr>
                <tr><td>Má phanh &amp; Đĩa phanh</td><td class="dot-inspect">✗</td><td class="dot-inspect">✗</td><td class="dot-check">✓</td><td class="dot-inspect">✗</td><td class="dot-check">✓</td><td class="dot-inspect">✗</td></tr>
                <tr><td>Kiểm tra áp suất lốp</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td></tr>
                <tr class="cat-row"><td colspan="7">Phần mềm &amp; Cập nhật</td></tr>
                <tr><td>Cập nhật firmware OTA</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-check">✓</td></tr>
                <tr><td>Hiệu chỉnh hệ thống ADAS</td><td class="dot-none">–</td><td class="dot-none">–</td><td class="dot-check">✓</td><td class="dot-check">✓</td><td class="dot-none">–</td><td class="dot-check">✓</td></tr>
              </tbody>
            </table>
          </div>
          <div class="legend">
            <div class="legend-item"><span style="color:#16a34a;font-weight:700;font-size:15px">✓</span> Thực hiện</div>
            <div class="legend-item"><span style="color:#d97706;font-weight:600;font-size:13px">✗</span> Kiểm tra</div>
            <div class="legend-item"><span style="color:#b0b0b0;font-size:13px">–</span> Không áp dụng</div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- BRANDS --}}
<section class="brands-section">
  <div class="container">
    <div data-anim>
      <div class="section-label">Tra cứu theo hãng</div>
      <h2 class="section-title">Chu Kỳ Bảo Dưỡng <em style="color:var(--red);font-style:normal">Theo Hãng</em></h2>
    </div>
    <div class="brands-grid" data-anim style="transition-delay:.1s">

      <div class="brand-card">
        <div class="brand-logo-wrap"><svg viewBox="0 0 100 100" width="60" height="60"><ellipse cx="50" cy="50" rx="46" ry="46" fill="none" stroke="#eb0a1e" stroke-width="3"/><ellipse cx="50" cy="50" rx="29" ry="18" fill="none" stroke="#eb0a1e" stroke-width="3"/><ellipse cx="50" cy="50" rx="12" ry="46" fill="none" stroke="#eb0a1e" stroke-width="3"/><line x1="50" y1="4" x2="50" y2="96" stroke="#eb0a1e" stroke-width="3"/></svg></div>
        <div class="brand-info"><div class="brand-name">Toyota</div><div class="brand-interval">5,000 km / 6 tháng</div><div class="brand-note">Dầu khoáng thường</div></div>
      </div>

      <div class="brand-card">
        <div class="brand-logo-wrap"><svg viewBox="0 0 100 100" width="56" height="56"><rect x="8" y="22" width="84" height="56" rx="4" fill="#cc0000"/><text x="50" y="64" font-family="Arial Black,sans-serif" font-size="48" font-weight="900" fill="white" text-anchor="middle">H</text></svg></div>
        <div class="brand-info"><div class="brand-name">Honda</div><div class="brand-interval">5,000 km / 6 tháng</div><div class="brand-note">Dầu tổng hợp bán phần</div></div>
      </div>

      <div class="brand-card">
        <div class="brand-logo-wrap"><svg viewBox="0 0 100 100" width="60" height="60"><circle cx="50" cy="50" r="46" fill="none" stroke="#1a1a1a" stroke-width="2"/><path d="M50 20 C50 50 35 68 20 55" fill="none" stroke="#1a1a1a" stroke-width="2.5"/><path d="M50 20 C50 50 65 68 80 55" fill="none" stroke="#1a1a1a" stroke-width="2.5"/></svg></div>
        <div class="brand-info"><div class="brand-name">Mazda</div><div class="brand-interval">5,000 km / 6 tháng</div><div class="brand-note">Dầu Skyactiv chuyên dụng</div></div>
      </div>

      <div class="brand-card">
        <div class="brand-logo-wrap"><svg viewBox="0 0 120 60" width="66" height="33"><ellipse cx="60" cy="30" rx="58" ry="28" fill="#003478"/><text x="60" y="40" font-family="Arial,sans-serif" font-size="32" font-weight="900" font-style="italic" fill="white" text-anchor="middle">Ford</text></svg></div>
        <div class="brand-info"><div class="brand-name">Ford</div><div class="brand-interval">7,500 km / 6 tháng</div><div class="brand-note">Dầu Ford Formula</div></div>
      </div>

      <div class="brand-card">
        <div class="brand-logo-wrap"><svg viewBox="0 0 100 100" width="60" height="60"><circle cx="50" cy="50" r="46" fill="#002c5f"/><text x="50" y="67" font-family="Arial Black,sans-serif" font-size="52" font-weight="900" font-style="italic" fill="white" text-anchor="middle">H</text></svg></div>
        <div class="brand-info"><div class="brand-name">Hyundai</div><div class="brand-interval">7,500 km / 6 tháng</div><div class="brand-note">Dầu tổng hợp</div></div>
      </div>

      <div class="brand-card">
        <div class="brand-logo-wrap"><svg viewBox="0 0 120 50" width="68" height="28"><rect width="120" height="50" rx="4" fill="#05141f"/><text x="60" y="37" font-family="Arial Black,sans-serif" font-size="30" font-weight="900" fill="white" text-anchor="middle" letter-spacing="4">KIA</text></svg></div>
        <div class="brand-info"><div class="brand-name">Kia</div><div class="brand-interval">7,500 km / 6 tháng</div><div class="brand-note">Dầu tổng hợp</div></div>
      </div>

      <div class="brand-card">
        <div class="brand-logo-wrap"><svg viewBox="0 0 100 100" width="60" height="60"><circle cx="50" cy="50" r="46" fill="none" stroke="#1a1a1a" stroke-width="2.5"/><circle cx="50" cy="50" r="38" fill="none" stroke="#1a1a1a" stroke-width="1.5"/><line x1="50" y1="12" x2="50" y2="50" stroke="#1a1a1a" stroke-width="2.5"/><line x1="50" y1="50" x2="17" y2="72" stroke="#1a1a1a" stroke-width="2.5"/><line x1="50" y1="50" x2="83" y2="72" stroke="#1a1a1a" stroke-width="2.5"/><circle cx="50" cy="50" r="5" fill="#1a1a1a"/></svg></div>
        <div class="brand-info"><div class="brand-name">Mercedes</div><div class="brand-interval">10,000 km / 12 tháng</div><div class="brand-note">Dầu MB Approval</div></div>
      </div>

      <div class="brand-card">
        <div class="brand-logo-wrap"><svg viewBox="0 0 100 100" width="60" height="60"><circle cx="50" cy="50" r="47" fill="none" stroke="#1c1c1c" stroke-width="3"/><path d="M50 10 A40 40 0 0 1 90 50 L50 50Z" fill="#1e78c8"/><path d="M90 50 A40 40 0 0 1 50 90 L50 50Z" fill="white"/><path d="M50 90 A40 40 0 0 1 10 50 L50 50Z" fill="#1e78c8"/><path d="M10 50 A40 40 0 0 1 50 10 L50 50Z" fill="white"/><circle cx="50" cy="50" r="40" fill="none" stroke="#1c1c1c" stroke-width="2"/><line x1="50" y1="10" x2="50" y2="90" stroke="#1c1c1c" stroke-width="2"/><line x1="10" y1="50" x2="90" y2="50" stroke="#1c1c1c" stroke-width="2"/></svg></div>
        <div class="brand-info"><div class="brand-name">BMW</div><div class="brand-interval">10,000 km / 12 tháng</div><div class="brand-note">Dầu Longlife-04</div></div>
      </div>

    </div>
  </div>
</section>

{{-- REMINDER --}}
<section class="reminder-section" id="reminder">
  <div class="container">
    <div class="reminder-grid">
      <div class="reminder-text" data-anim="left">
        <div class="section-label">Không bao giờ quên hạn</div>
        <h2>Đăng Ký <em>Nhắc Lịch</em><br>Bảo Dưỡng</h2>
        <p>Để số điện thoại lại — chúng tôi sẽ nhắc bạn trước 500 km hoặc 2 tuần trước hạn bảo dưỡng, hoàn toàn miễn phí.</p>
      </div>
      <div class="reminder-form" data-anim="right">
        <label class="rf-label">Họ và tên</label>
        <input id="rf-ho-ten" class="rf-input" type="text" placeholder="Nguyễn Văn A" autocomplete="name">
        <label class="rf-label">Số điện thoại</label>
        <input id="rf-dien-thoai" class="rf-input" type="tel" placeholder="0909 123 456" autocomplete="tel" inputmode="tel">
        <label class="rf-label">Km bảo dưỡng gần nhất</label>
        <input id="rf-km" class="rf-input" type="number" placeholder="VD: 45000" inputmode="numeric">
        <label class="rf-label">Hãng xe</label>
        <select id="rf-hang-xe" class="rf-input rf-select">
          <option>Toyota / Honda / Mazda</option>
          <option>Ford / Hyundai / Kia</option>
          <option>BMW / Mercedes / Audi</option>
          <option>VinFast</option>
        </select>
        <div id="rf-error" style="display:none;color:#f87171;font-size:13px;margin-bottom:12px;padding:10px 14px;background:rgba(248,113,113,0.1);border-radius:6px;"></div>
        <button id="rf-btn" class="btn-remind" onclick="submitReminder()">Đăng Ký Nhắc Lịch</button>
      </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
  const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
  }, { threshold: 0.1 });
  document.querySelectorAll('[data-anim]').forEach(el => observer.observe(el));

  function switchTab(tab, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-' + tab).classList.add('active');
  }

  async function submitReminder() {
    const btn       = document.getElementById('rf-btn');
    const errBox    = document.getElementById('rf-error');
    const hoTen     = document.getElementById('rf-ho-ten').value.trim();
    const dienThoai = document.getElementById('rf-dien-thoai').value.trim();
    const km        = document.getElementById('rf-km').value.trim();
    const hangXe    = document.getElementById('rf-hang-xe').value;

    errBox.style.display = 'none';
    if (!hoTen)     { showErr('Vui lòng nhập họ và tên.'); return; }
    if (!dienThoai) { showErr('Vui lòng nhập số điện thoại.'); return; }
    if (!km)        { showErr('Vui lòng nhập số km bảo dưỡng gần nhất.'); return; }

    btn.disabled = true;
    btn.textContent = 'Đang gửi...';

    try {
      const res = await fetch('{{ url("/maintenance/reminder/send") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json',
        },
        body: JSON.stringify({ ho_ten: hoTen, dien_thoai: dienThoai, km_gan_nhat: km, hang_xe: hangXe }),
      });
      const data = await res.json();
      if (res.ok && data.success) {
        btn.textContent = '✓ Đăng ký thành công!';
        btn.style.background = '#16a34a';
        ['rf-ho-ten','rf-dien-thoai','rf-km'].forEach(id => document.getElementById(id).value = '');
      } else {
        const msgs = data.errors ? Object.values(data.errors).flat().join(' ') : (data.message || 'Có lỗi xảy ra.');
        showErr(msgs);
        btn.disabled = false;
        btn.textContent = 'Đăng Ký Nhắc Lịch';
      }
    } catch (e) {
      showErr('Không thể kết nối. Vui lòng kiểm tra mạng và thử lại.');
      btn.disabled = false;
      btn.textContent = 'Đăng Ký Nhắc Lịch';
    }

    function showErr(msg) { errBox.textContent = msg; errBox.style.display = 'block'; }
  }

  function calcMaintenance() {
    const km       = parseInt(document.getElementById('calc-km').value) || 0;
    const last     = parseInt(document.getElementById('calc-last').value) || 0;
    const interval = parseInt(document.getElementById('calc-brand').value) || 5000;
    const done     = km - last;
    const next     = last + interval;
    const remain   = next - km;

    document.getElementById('res-done').textContent    = done.toLocaleString('vi') + ' km';
    document.getElementById('res-remain').textContent  = remain > 0 ? remain.toLocaleString('vi') + ' km' : '0 km';
    document.getElementById('res-next').textContent    = next.toLocaleString('vi') + ' km';

    const result     = document.getElementById('calc-result');
    const resAlert   = document.getElementById('res-alert');
    const status     = document.getElementById('res-status');
    const statusDesc = document.getElementById('res-status-desc');
    result.classList.add('show');

    if (remain <= 0) {
      status.textContent = 'QUÁ HẠN'; statusDesc.textContent = 'Cần bảo dưỡng ngay!';
      resAlert.style.display = 'flex';
      document.getElementById('res-alert-text').textContent = 'Xe đã quá hạn bảo dưỡng ' + Math.abs(remain).toLocaleString('vi') + ' km. Đặt lịch ngay!';
    } else if (remain <= 1000) {
      status.textContent = 'SẮP ĐẾN'; statusDesc.textContent = 'Sắp đến hạn bảo dưỡng';
      resAlert.style.display = 'flex';
      document.getElementById('res-alert-text').textContent = 'Còn ' + remain.toLocaleString('vi') + ' km nữa là đến hạn. Nên đặt lịch sớm!';
    } else {
      status.textContent = 'TỐT'; statusDesc.textContent = 'Xe đang trong tình trạng tốt';
      resAlert.style.display = 'none';
    }
  }

  function toggleTable(btn) {
    btn.classList.toggle('open');
    btn.nextElementSibling.classList.toggle('open');
  }
</script>
@endpush