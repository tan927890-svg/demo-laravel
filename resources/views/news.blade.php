{{-- ============================================================
    resources/views/news.blade.php
    Trang Tin Tức — AUTO X (Light Gold Theme)
     ============================================================ --}}
@extends('layouts.frontend')
@section('title', 'Tin Tức — AUTO X')

@push('styles')
<style>
  :root {
    --gold: #b8973a;
    --gold-dark: #8a6d1e;
    --gold-light: rgba(184,151,58,0.10);
    --gold-border: rgba(184,151,58,0.28);
    --bg:  #f5f0e8;
    --bg2: #ede8de;
    --bg3: #e6e0d4;
    --card: #ffffff;
    --border: #d8d0c0;
    --border-light: #c8bfaa;
    --dark: #1c1a16;
    --text: #4a4438;
    --muted: #7a7060;
    --subtle: #a09880;
  }

  /* ─── BASE ─── */
  .container { max-width: 1240px; margin: 0 auto; padding: 0 48px; }
  .section-label {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: 4px; text-transform: uppercase; color: var(--gold);
    margin-bottom: 10px; display: flex; align-items: center; gap: 10px;
  }
  .section-label::before { content: ''; width: 3px; height: 14px; background: var(--gold); flex-shrink: 0; }
  .section-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(24px,2.8vw,36px); font-weight: 800;
    text-transform: uppercase; color: var(--dark); letter-spacing: -.5px;
  }

  /* ─── HERO ─── */
  .hero {
    position: relative; height: 380px;
    display: flex; align-items: center; justify-content: center; overflow: hidden;
  }
  .hero-bg {
    position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=1600&q=80') center/cover no-repeat;
  }
  .hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(160deg, rgba(28,26,22,0.84) 0%, rgba(28,26,22,0.70) 50%, rgba(28,26,22,0.80) 100%);
  }
  .hero-content { position: relative; text-align: center; z-index: 2; }
  .hero-eyebrow {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: 5px; text-transform: uppercase; color: var(--gold);
    margin-bottom: 14px; display: flex; align-items: center; justify-content: center; gap: 14px;
  }
  .hero-eyebrow::before,.hero-eyebrow::after { content:''; width:30px; height:1px; background:var(--gold); opacity:.7; }
  .hero h1 {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(52px,7vw,88px); font-weight: 800;
    color: #f5f0e8; line-height: .92; text-transform: uppercase; letter-spacing: -1px;
  }
  .hero h1 em { color: var(--gold); font-style: normal; }
  .hero-sub { margin-top: 16px; font-size: 14px; color: rgba(245,240,232,0.6); letter-spacing: .5px; }
  .breadcrumb {
    position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);
    display: flex; align-items: center; gap: 10px; z-index: 2;
    font-size: 12px; letter-spacing: 1px; color: rgba(245,240,232,0.9);
    white-space: nowrap; background: rgba(10,10,10,0.32);
    padding: 8px 14px; border-radius: 18px; box-shadow: 0 8px 20px rgba(0,0,0,0.35);
    backdrop-filter: blur(6px);
  }
  .breadcrumb a { color: rgba(245,240,232,0.85); text-decoration: none; transition: color .18s; }
  .breadcrumb a:hover { color: var(--gold); }
  .breadcrumb span.active { color: var(--gold); font-weight:700; }

  /* ─── CATEGORY FILTER BAR ─── */
  .filter-bar { background: var(--card); border-bottom: 1px solid var(--border); box-shadow: 0 1px 4px rgba(0,0,0,.05); }
  .filter-inner {
    display: flex; align-items: center; gap: 0;
    overflow-x: auto; scrollbar-width: none;
  }
  .filter-inner::-webkit-scrollbar { display: none; }
  .filter-tab {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; color: var(--muted);
    padding: 16px 24px; border-bottom: 2px solid transparent;
    cursor: pointer; white-space: nowrap; transition: color .2s, border-color .2s;
    background: none; border-top: none; border-left: none; border-right: none;
    text-decoration: none; display: inline-flex; align-items: center;
  }
  .filter-tab:hover { color: var(--dark); }
  .filter-tab.active { color: var(--dark); border-bottom-color: var(--gold); }
  .filter-count {
    font-size: 10px; color: var(--subtle); margin-left: 5px;
    font-family: 'Rajdhani', sans-serif; font-weight: 600;
  }

  /* ─── MAIN LAYOUT ─── */
  .news-layout { background: var(--bg); padding: 72px 0 100px; }
  .news-grid { display: grid; grid-template-columns: 1fr 340px; gap: 48px; align-items: start; }
  .news-grid > div:first-child { max-width: 880px; margin: 0 auto; }

  /* ─── SEC HEAD ─── */
  .sec-head { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 20px; }
  .sec-head-left { display: flex; flex-direction: column; gap: 4px; }
  .sec-link {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; color: var(--gold);
    text-decoration: none; display: flex; align-items: center; gap: 6px; transition: gap .2s;
  }
  .sec-link:hover { gap: 10px; }

  /* ─── HERO STORY ─── */
  .story-hero {
    background: var(--card); border: 1px solid var(--border); overflow: hidden;
    cursor: pointer; position: relative;
    transition: border-color .3s, box-shadow .3s;
    display: grid; grid-template-columns: 320px 1fr;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    min-height: 0;
  }
  .story-hero:hover { border-color: var(--gold); box-shadow: 0 4px 20px rgba(184,151,58,.12); }
  .story-hero-img {
    position: relative; overflow: hidden; background: var(--bg3);
    height: 240px;
    display: flex; align-items: center; justify-content: center;
  }
  .story-hero-img img {
    width: 100%; height: 100%;
    object-fit: cover; object-position: center center;
    display: block; transition: transform .6s ease;
  }
  .story-hero:hover .story-hero-img img { transform: scale(1.05); }
  .story-hero-badge {
    position: absolute; top: 14px; left: 14px;
    background: var(--gold); color: #fff;
    font-family: 'Rajdhani', sans-serif; font-size: 9px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; padding: 4px 12px; z-index: 2;
  }
  .story-hero-body {
    padding: 24px 28px;
    display: flex; flex-direction: column; justify-content: center;
    height: 240px; box-sizing: border-box; overflow: hidden;
  }
  .story-tag {
    font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; color: var(--gold);
    display: flex; align-items: center; gap: 8px; margin-bottom: 10px;
  }
  .story-tag::before { content: ''; width: 16px; height: 1px; background: var(--gold); }
  .story-hero-title {
    font-family: 'Barlow Condensed', sans-serif; font-size: clamp(20px,2vw,28px);
    font-weight: 800; text-transform: uppercase; color: var(--dark);
    line-height: 1.05; letter-spacing: -.3px; margin-bottom: 10px;
  }
  .story-hero-title em { color: var(--gold); font-style: normal; }
  .story-excerpt {
    font-size: 12.5px; color: var(--muted); line-height: 1.7; margin-bottom: 12px;
    display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
  }
  .story-meta {
    display: flex; align-items: center; gap: 10px;
    font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 600;
    letter-spacing: 2px; text-transform: uppercase; color: var(--subtle);
  }
  .story-meta-dot { width: 3px; height: 3px; background: var(--subtle); border-radius: 50%; }
  .story-meta-author { color: var(--text); }
  .btn-read {
    display: inline-flex; align-items: center; gap: 8px; margin-top: 14px;
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; color: var(--gold);
    text-decoration: none; transition: gap .2s;
  }
  .btn-read:hover { gap: 14px; }

  /* ─── GRIDS ─── */
  .grid3 { display: grid; grid-template-columns: repeat(3,1fr); gap: 2px; }
  .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 2px; }

  /* ─── ARTICLE CARD ─── */
  .a-card {
    background: var(--card); border: 1px solid var(--border); overflow: hidden;
    cursor: pointer; transition: border-color .3s, background .3s, box-shadow .3s; position: relative;
    box-shadow: 0 1px 4px rgba(0,0,0,.04);
  }
  .a-card::after {
    content: ''; position: absolute; bottom: 0; left: 0; right: 0;
    height: 2px; background: var(--gold); transform: scaleX(0); transform-origin: left;
    transition: transform .35s;
  }
  .a-card:hover::after { transform: scaleX(1); }
  .a-card:hover { border-color: var(--gold-border); background: var(--bg); box-shadow: 0 4px 16px rgba(184,151,58,.08); }
  .a-card-img {
    overflow: hidden; height: 180px; background: var(--bg3); position: relative;
  }
  .a-card-img img {
    width: 100%; height: 100%; display: block;
    object-fit: cover; object-position: center center;
    transition: transform .5s ease;
  }
  .a-card:hover .a-card-img img { transform: scale(1.06); }
  .a-card-body { padding: 16px 18px 18px; }
  .a-card-tag {
    font-family: 'Rajdhani', sans-serif; font-size: 9px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; color: var(--gold);
    border-left: 2px solid var(--gold); padding-left: 8px; margin-bottom: 8px;
    display: inline-block;
  }
  .a-card-title {
    font-family: 'Barlow Condensed', sans-serif; font-size: 16px; font-weight: 700;
    text-transform: uppercase; color: var(--dark); line-height: 1.2; margin-bottom: 8px;
  }
  .a-card-excerpt { font-size: 12px; color: var(--muted); line-height: 1.7; margin-bottom: 12px; }
  .a-card-meta {
    font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 600;
    letter-spacing: 2px; text-transform: uppercase; color: var(--subtle);
    display: flex; align-items: center; gap: 8px;
  }

  /* ─── MAGAZINE WIDE ─── */
  .mag-wide {
    background: var(--card); border: 1px solid var(--border); overflow: hidden;
    display: grid; grid-template-columns: 44% 1fr; margin: 2px 0;
    cursor: pointer; transition: border-color .3s, box-shadow .3s;
    box-shadow: 0 1px 4px rgba(0,0,0,.04);
  }
  .mag-wide:hover { border-color: var(--gold); box-shadow: 0 4px 20px rgba(184,151,58,.10); }
  .mag-wide-img { overflow: hidden; background: var(--bg3); height: 260px; }
  .mag-wide-img img {
    width: 100%; height: 100%; object-fit: cover; object-position: center center;
    display: block; transition: transform .6s ease;
  }
  .mag-wide:hover .mag-wide-img img { transform: scale(1.04); }
  .mag-wide-body {
    padding: 32px 36px; display: flex; flex-direction: column; justify-content: center;
    border-left: 1px solid var(--border);
  }
  .mag-wide-label {
    display: inline-block; background: var(--gold); color: #fff;
    font-family: 'Rajdhani', sans-serif; font-size: 9px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; padding: 4px 12px; margin-bottom: 14px;
  }
  .mag-wide-title {
    font-family: 'Barlow Condensed', sans-serif; font-size: clamp(20px,1.8vw,28px);
    font-weight: 800; text-transform: uppercase; color: var(--dark);
    line-height: 1.1; margin-bottom: 12px;
  }
  .mag-wide-excerpt { font-size: 13px; color: var(--muted); line-height: 1.75; margin-bottom: 18px; }

  /* ─── H-CARD ─── */
  .h-card {
    background: var(--card); border: 1px solid var(--border); overflow: hidden;
    display: grid; grid-template-columns: 90px 1fr;
    cursor: pointer; transition: border-color .3s, background .3s;
  }
  .h-card:hover { border-color: var(--gold-border); background: var(--bg2); }
  .h-card-img { overflow: hidden; background: var(--bg3); height: 80px; }
  .h-card-img img {
    width: 100%; height: 100%; display: block;
    object-fit: cover; object-position: center center;
  }
  .h-card-body { padding: 12px 14px; display: flex; flex-direction: column; justify-content: center; }
  .h-card-title {
    font-family: 'Barlow Condensed', sans-serif; font-size: 13px; font-weight: 700;
    text-transform: uppercase; color: var(--dark); line-height: 1.3; margin-bottom: 6px;
  }

  /* ─── VIDEO CARDS ─── */
  .video-card {
    background: var(--card); border: 1px solid var(--border); overflow: hidden;
    cursor: pointer; transition: border-color .3s, box-shadow .3s;
    box-shadow: 0 1px 4px rgba(0,0,0,.04);
  }
  .video-card:hover { border-color: var(--gold); box-shadow: 0 4px 16px rgba(184,151,58,.10); }
  .video-thumb { position: relative; overflow: hidden; height: 180px; background: var(--bg3); }
  .video-thumb img {
    width: 100%; height: 100%; object-fit: cover; object-position: center center;
    display: block; transition: transform .5s;
  }
  .video-card:hover .video-thumb img { transform: scale(1.05); }
  .play-btn {
    position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
    width: 50px; height: 50px; background: rgba(184,151,58,.92); border-radius: 50%;
    display: flex; align-items: center; justify-content: center; transition: transform .2s, background .2s;
    backdrop-filter: blur(4px);
  }
  .video-card:hover .play-btn { transform: translate(-50%,-50%) scale(1.12); background: var(--gold); }
  .play-icon { width: 0; height: 0; border-top: 9px solid transparent; border-bottom: 9px solid transparent; border-left: 15px solid #fff; margin-left: 4px; }
  .video-body { padding: 16px 18px; }

  /* ─── SIDEBAR ─── */
  .sidebar { display: flex; flex-direction: column; gap: 2px; }
  .sidebar-block { background: var(--card); border: 1px solid var(--border); padding: 22px 20px; box-shadow: 0 1px 4px rgba(0,0,0,.04); }
  .sidebar-title {
    font-family: 'Barlow Condensed', sans-serif; font-size: 16px; font-weight: 800;
    text-transform: uppercase; color: var(--dark); letter-spacing: .5px;
    padding-bottom: 12px; border-bottom: 2px solid var(--gold); margin-bottom: 14px;
    display: flex; align-items: center; gap: 8px;
  }
  .sidebar-title::before { content: ''; width: 3px; height: 16px; background: var(--gold); }
  .rank-item {
    display: flex; gap: 12px; align-items: flex-start;
    padding: 12px 0; border-bottom: 1px solid var(--border);
    cursor: pointer; transition: background .2s;
  }
  .rank-item:last-child { border-bottom: none; padding-bottom: 0; }
  .rank-num {
    font-family: 'Barlow Condensed', sans-serif; font-size: 32px; font-weight: 800;
    color: rgba(160,152,128,.2); line-height: 1; flex-shrink: 0; width: 28px;
    transition: color .3s;
  }
  .rank-item:hover .rank-num { color: var(--gold); }
  .rank-item.top .rank-num { color: rgba(184,151,58,.35); }
  .rank-title {
    font-family: 'Barlow Condensed', sans-serif; font-size: 13px; font-weight: 700;
    text-transform: uppercase; color: var(--dark); line-height: 1.3; margin-bottom: 4px;
  }
  .rank-meta {
    font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 600;
    letter-spacing: 2px; text-transform: uppercase; color: var(--subtle);
  }
  .tag-cloud { display: flex; flex-wrap: wrap; gap: 5px; }
  .tag-c {
    font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase; color: var(--muted);
    border: 1px solid var(--border); padding: 6px 12px; cursor: pointer;
    text-decoration: none; transition: color .2s, border-color .2s, background .2s;
  }
  .tag-c:hover { color: var(--gold); border-color: var(--gold); background: var(--gold-light); }
  .nl-sidebar { background: var(--gold); padding: 22px 20px; }
  .nl-sidebar-title {
    font-family: 'Barlow Condensed', sans-serif; font-size: 20px; font-weight: 800;
    text-transform: uppercase; color: #fff; margin-bottom: 6px; line-height: 1.1;
  }
  .nl-sidebar p { font-size: 12px; color: rgba(255,255,255,.75); margin-bottom: 14px; line-height: 1.6; }
  .nl-form { display: flex; flex-direction: column; gap: 7px; }
  .nl-input {
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.35); color: #fff;
    padding: 10px 12px; font-size: 12px; font-family: 'Barlow Condensed', sans-serif;
    outline: none; transition: border-color .2s;
  }
  .nl-input::placeholder { color: rgba(255,255,255,.5); }
  .nl-input:focus { border-color: rgba(255,255,255,.75); }
  .nl-btn {
    background: #fff; color: var(--gold); border: none; padding: 11px;
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; cursor: pointer; transition: background .2s, color .2s;
  }
  .nl-btn:hover { background: var(--gold-dark); color: #fff; }

  /* ─── TICKER ─── */
  .ticker-bar {
    background: var(--bg3); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);
    overflow: hidden; height: 40px; display: flex; align-items: center; margin: 40px 0 0;
  }
  .ticker-label {
    background: var(--gold); color: #fff; flex-shrink: 0;
    font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; padding: 0 18px; height: 100%;
    display: flex; align-items: center; white-space: nowrap;
  }
  .ticker-track { display: flex; gap: 0; white-space: nowrap; animation: ticker 30s linear infinite; }
  .ticker-track:hover { animation-play-state: paused; }
  @keyframes ticker { from{transform:translateX(0)} to{transform:translateX(-50%)} }
  .ticker-item {
    display: inline-flex; align-items: center; gap: 10px; padding: 0 28px;
    font-size: 12px; color: var(--muted); font-style: italic;
  }
  .ticker-item::after { content: '◆'; font-size: 6px; color: var(--subtle); font-style: normal; }
  .ticker-author { font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--subtle); font-style: normal; }
  .ticker-stars { color: var(--gold); font-size: 11px; font-style: normal; }

  /* ─── STATS ─── */
  .stats-strip { background: var(--gold); }
  .stats-grid { display: grid; grid-template-columns: repeat(4,1fr); border-left: 1px solid rgba(255,255,255,.2); }
  .stat-item { padding: 32px 20px; text-align: center; border-right: 1px solid rgba(255,255,255,.2); transition: background .2s; }
  .stat-item:hover { background: rgba(0,0,0,.08); }
  .stat-num { font-family: 'Barlow Condensed', sans-serif; font-size: 44px; font-weight: 800; color: #fff; line-height: 1; }
  .stat-label { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: 3px; text-transform: uppercase; color: rgba(255,255,255,.75); margin-top: 5px; }

  /* ─── DATE BADGE ─── */
  .date-badge {
    position: absolute; bottom: 12px; right: 12px; z-index: 2;
    background: rgba(28,26,22,.75); backdrop-filter: blur(4px);
    color: rgba(245,240,232,.85); font-family: 'Rajdhani', sans-serif;
    font-size: 10px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase;
    padding: 4px 10px;
  }

  /* ─── ANIMATIONS ─── */
  [data-anim] { opacity: 0; transform: translateY(20px); transition: opacity .6s ease, transform .6s ease; }
  [data-anim].visible { opacity: 1; transform: translateY(0); }
  [data-anim="left"] { transform: translateX(-20px); }
  [data-anim="left"].visible { transform: translateX(0); }
  [data-anim="fade"] { transform: none; }
  [data-anim="fade"].visible { transform: none; }

  /* ─── RESPONSIVE ─── */
  @media(max-width:1100px){
    .news-grid { grid-template-columns: 1fr; }
    .story-hero { grid-template-columns: 260px 1fr; }
    .story-hero-img { height: 220px; }
    .story-hero-body { height: 220px; }
    .mag-wide { grid-template-columns: 1fr; }
    .mag-wide-img { height: 220px; }
    .grid3 { grid-template-columns: 1fr 1fr; }
  }
  @media(max-width:700px){
    .container { padding: 0 16px; }
    .grid3, .grid2 { grid-template-columns: 1fr; }
    .story-hero { grid-template-columns: 1fr; }
    .story-hero-img { height: 200px; }
    .story-hero-body { height: auto; padding: 20px 18px; }
    .h-card { grid-template-columns: 80px 1fr; }
  }
</style>
@endpush

@section('content')

{{-- ─── HERO ─── --}}
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-overlay"></div>
  <div class="hero-content" data-anim>
    <div class="hero-eyebrow">Cập nhật mới nhất</div>
    <h1>Tin <em>Tức</em><br/>Xe Hơi</h1>
    <p class="hero-sub">Đánh giá — Ra mắt — Phân tích thị trường</p>
  </div>
  <div class="breadcrumb">
    <a href="{{ url('/') }}">Home</a> &rsaquo;
    <a href="{{ url('/cars') }}">Cars</a> &rsaquo;
    <span class="active">Tin Tức</span>
  </div>
</section>

{{-- ─── FILTER BAR ─── --}}
<div class="filter-bar">
  <div class="container">
    <div class="filter-inner">
      <a href="{{ route('news.index') }}"
         class="filter-tab {{ !request()->get('category') ? 'active' : '' }}">
        Tất Cả <span class="filter-count">{{ $totalCount ?? 128 }}</span>
      </a>
      <a href="{{ route('news.index', ['category' => 'ra-mat-moi']) }}"
         class="filter-tab {{ request()->get('category') === 'ra-mat-moi' ? 'active' : '' }}">
        Ra Mắt Mới <span class="filter-count">{{ $categoryCounts['ra-mat-moi'] ?? 34 }}</span>
      </a>
      <a href="{{ route('news.index', ['category' => 'danh-gia']) }}"
         class="filter-tab {{ request()->get('category') === 'danh-gia' ? 'active' : '' }}">
        Đánh Giá <span class="filter-count">{{ $categoryCounts['danh-gia'] ?? 46 }}</span>
      </a>
      <a href="{{ route('news.index', ['category' => 'xu-huong']) }}"
         class="filter-tab {{ request()->get('category') === 'xu-huong' ? 'active' : '' }}">
        Xu Hướng <span class="filter-count">{{ $categoryCounts['xu-huong'] ?? 18 }}</span>
      </a>
      <a href="{{ route('news.index', ['category' => 'cong-nghe']) }}"
         class="filter-tab {{ request()->get('category') === 'cong-nghe' ? 'active' : '' }}">
        Công Nghệ <span class="filter-count">{{ $categoryCounts['cong-nghe'] ?? 22 }}</span>
      </a>
      <a href="{{ route('news.index', ['category' => 'thi-truong']) }}"
         class="filter-tab {{ request()->get('category') === 'thi-truong' ? 'active' : '' }}">
        Thị Trường <span class="filter-count">{{ $categoryCounts['thi-truong'] ?? 20 }}</span>
      </a>
      <a href="{{ route('news.index', ['category' => 'meo-hay']) }}"
         class="filter-tab {{ request()->get('category') === 'meo-hay' ? 'active' : '' }}">
        Mẹo Hay <span class="filter-count">{{ $categoryCounts['meo-hay'] ?? 15 }}</span>
      </a>
    </div>
  </div>
</div>

{{-- ─── MAIN CONTENT ─── --}}
<section class="news-layout">
  <div class="container">
    <div class="news-grid">

      {{-- ═══ LEFT COLUMN ═══ --}}
      <div>

        {{-- COVER STORY --}}
        <div class="sec-head" data-anim>
          <div class="sec-head-left">
            <div class="section-label">Câu chuyện nổi bật</div>
            <h2 class="section-title">Bài Viết Chính</h2>
          </div>
          <a href="{{ route('news.index') }}" class="sec-link">Xem tất cả &#8594;</a>
        </div>

        <a href="{{ route('news.show', $coverStory->slug ?? 'bmw-m5-hybrid-2025') }}"
           class="story-hero" style="text-decoration:none" data-anim>
          <div class="story-hero-img">
            @if(!empty($coverStory->thumbnail))
              <img src="{{ asset('storage/'.$coverStory->thumbnail) }}"
                   alt="{{ $coverStory->title }}" loading="lazy"/>
            @else
              {{-- BMW M5 thực tế, góc chụp 3/4 trước --}}
              <img src="https://images.unsplash.com/photo-1555215695-3004980ad54e?w=800&q=80"
                   alt="BMW M5 Hybrid 2025" loading="lazy"/>
            @endif
            <div class="story-hero-badge">COVER STORY</div>
          </div>
          <div class="story-hero-body">
            <div class="story-tag">{{ $coverStory->category->name ?? 'Ra Mắt Mới' }}</div>
            <h2 class="story-hero-title">
              @if(!empty($coverStory->title))
                {{ $coverStory->title }}
              @else
                BMW M5 <em>Hybrid</em> 2025:<br/>Cuộc Cách Mạng <em>727</em> Mã Lực
              @endif
            </h2>
            <p class="story-excerpt">
              {{ $coverStory->excerpt ?? 'BMW chính thức công bố thế hệ M5 hoàn toàn mới tích hợp hệ thống hybrid plug-in, tổng công suất 727 mã lực. Tăng tốc 0–100 km/h chỉ 3.5 giây — phá vỡ mọi kỷ lục M5 từ trước đến nay.' }}
            </p>
            <div class="story-meta">
              <span>{{ isset($coverStory->published_at) ? $coverStory->published_at->format('d/m/Y') : '15/03/2025' }}</span>
              <div class="story-meta-dot"></div>
              <span class="story-meta-author">{{ $coverStory->author->name ?? 'MINH KHOA' }}</span>
              <div class="story-meta-dot"></div>
              <span>{{ ($coverStory->read_time ?? 7) }} PHÚT ĐỌC</span>
            </div>
            <span class="btn-read">Đọc bài viết &#8594;</span>
          </div>
        </a>

        {{-- 3 LATEST --}}
        <div class="sec-head" style="margin-top:44px;" data-anim>
          <div class="sec-head-left">
            <div class="section-label">Cập nhật hôm nay</div>
            <h2 class="section-title">Tin Mới Nhất</h2>
          </div>
          <a href="{{ route('news.index') }}" class="sec-link">Xem thêm &#8594;</a>
        </div>

        <div class="grid3" data-anim>
          @forelse($latestNews ?? [] as $post)
          <a href="{{ route('news.show', $post->slug) }}" class="a-card" style="text-decoration:none">
            <div class="a-card-img">
              @if($post->thumbnail)
                <img src="{{ asset('storage/'.$post->thumbnail) }}" alt="{{ $post->title }}" loading="lazy">
              @else
                <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=400&q=70" alt="{{ $post->title }}" loading="lazy">
              @endif
            </div>
            <div class="a-card-body">
              <div class="a-card-tag">{{ $post->category->name ?? 'Tin Tức' }}</div>
              <div class="a-card-title">{{ $post->title }}</div>
              <p class="a-card-excerpt">{{ Str::limit($post->excerpt ?? '', 80) }}</p>
              <div class="a-card-meta">
                <span>{{ $post->published_at->format('d/m') }}</span>
                <div class="story-meta-dot"></div>
                <span>{{ $post->read_time ?? 5 }} ph đọc</span>
              </div>
            </div>
          </a>
          @empty
          {{-- Card 1 — Ferrari SF90 thực tế, màu đỏ nổi bật --}}
          <a href="#" class="a-card" style="text-decoration:none">
            <div class="a-card-img">
              <img src="https://images.unsplash.com/photo-1592198084033-aade902d1aae?w=500&q=75"
                   alt="Ferrari SF90" loading="lazy"/>
              <div class="date-badge">05/03</div>
            </div>
            <div class="a-card-body">
              <div class="a-card-tag">Ra Mắt Mới</div>
              <div class="a-card-title">Ferrari SF90 XX Stradale: Gần 1.000 HP Cho Đường Phố</div>
              <p class="a-card-excerpt">Siêu xe hybrid mạnh nhất Ferrari, 0–100 trong 2.3 giây, giới hạn 799 chiếc.</p>
              <div class="a-card-meta"><span>05/03</span><div class="story-meta-dot"></div><span>6 ph đọc</span></div>
            </div>
          </a>
          {{-- Card 2 — Mercedes EQS nội thất sang trọng --}}
          <a href="#" class="a-card" style="text-decoration:none">
            <div class="a-card-img">
              <img src="https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?w=500&q=75"
                   alt="Mercedes EQS" loading="lazy"/>
              <div class="date-badge">03/03</div>
            </div>
            <div class="a-card-body">
              <div class="a-card-tag" style="border-color:#2a7a2a;color:#2a7a2a">Xe Điện</div>
              <div class="a-card-title">Mercedes EQS 2025: Tầm Xa 800 km, Sang Bậc Nhất</div>
              <p class="a-card-excerpt">Pin 118 kWh, nội thất Hyperscreen 56 inch — xe điện sang trọng vượt trội.</p>
              <div class="a-card-meta"><span>03/03</span><div class="story-meta-dot"></div><span>5 ph đọc</span></div>
            </div>
          </a>
          {{-- Card 3 — Lamborghini Urus thực tế --}}
          <a href="#" class="a-card" style="text-decoration:none">
            <div class="a-card-img">
              <img src="https://images.unsplash.com/photo-1600712242805-5f78671b24da?w=500&q=75"
                   alt="Lamborghini Urus" loading="lazy"/>
              <div class="date-badge">28/02</div>
            </div>
            <div class="a-card-body">
              <div class="a-card-tag">Đánh Giá</div>
              <div class="a-card-title">Lamborghini Urus S: SUV Siêu Xe Tốt Nhất 2025?</div>
              <p class="a-card-excerpt">Chúng tôi trải nghiệm Urus S trên phố và đường đua — kết quả bất ngờ.</p>
              <div class="a-card-meta"><span>28/02</span><div class="story-meta-dot"></div><span>8 ph đọc</span></div>
            </div>
          </a>
          @endforelse
        </div>

        {{-- MAGAZINE FEATURE --}}
        <div class="sec-head" style="margin-top:44px;" data-anim>
          <div class="sec-head-left">
            <div class="section-label">Phân tích sâu</div>
            <h2 class="section-title">Bài Phân Tích</h2>
          </div>
        </div>

        {{-- Mag wide — xe điện thực tế trên đường --}}
        <a href="{{ route('news.show', 'cuoc-chien-xe-dien-2025') }}" class="mag-wide" style="text-decoration:none" data-anim>
          <div class="mag-wide-img">
            <img src="https://images.unsplash.com/photo-1593941707882-a5bba14938c7?w=700&q=80"
                 alt="Cuộc chiến xe điện 2025" loading="lazy"/>
          </div>
          <div class="mag-wide-body">
            <span class="mag-wide-label">Phân Tích Sâu</span>
            <div class="mag-wide-title">Cuộc Chiến Xe Điện 2025: Tesla, BYD & Ai Sẽ Thắng Tại Việt Nam?</div>
            <p class="mag-wide-excerpt">Thị trường xe điện Việt Nam bước vào giai đoạn bùng nổ. Chúng tôi phân tích chiến lược, ưu thế và điểm yếu từng hãng một cách khách quan nhất.</p>
            <div class="story-meta" style="margin-bottom:14px">
              <span>22/02/2025</span>
              <div class="story-meta-dot"></div>
              <span class="story-meta-author">THANH TÙNG</span>
              <div class="story-meta-dot"></div>
              <span>12 PHÚT ĐỌC</span>
            </div>
            <span class="btn-read">Đọc bài viết &#8594;</span>
          </div>
        </a>

        {{-- VIDEO --}}
        <div class="sec-head" style="margin-top:44px;" data-anim>
          <div class="sec-head-left">
            <div class="section-label">Trải nghiệm trực tiếp</div>
            <h2 class="section-title">Video Nổi Bật</h2>
          </div>
        </div>

        <div class="grid2" data-anim>
          {{-- Video 1 — BMW M4 trên đường đua --}}
          <div class="video-card">
            <div class="video-thumb">
              <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=700&q=75"
                   alt="Test Drive BMW M4" loading="lazy"/>
              <div class="play-btn"><div class="play-icon"></div></div>
            </div>
            <div class="video-body">
              <div class="a-card-tag">Video</div>
              <div class="a-card-title">Test Drive BMW M4 2025: Cảm Giác Không Xe Nào Có Được</div>
              <div class="a-card-meta" style="margin-top:8px"><span>12/03</span><div class="story-meta-dot"></div><span>18:32</span></div>
            </div>
          </div>
          {{-- Video 2 — Tesla trên đường thẳng --}}
          <div class="video-card">
            <div class="video-thumb">
              <img src="https://images.unsplash.com/photo-1561580125-028ee3bd62eb?w=700&q=75"
                   alt="Tesla vs BMW" loading="lazy"/>
              <div class="play-btn"><div class="play-icon"></div></div>
            </div>
            <div class="video-body">
              <div class="a-card-tag">Video</div>
              <div class="a-card-title">Tesla vs BMW: Xe Điện Hay Xăng — Cuộc Đua 400m</div>
              <div class="a-card-meta" style="margin-top:8px"><span>05/03</span><div class="story-meta-dot"></div><span>12:47</span></div>
            </div>
          </div>
        </div>

        {{-- MARKET & TRENDS --}}
        <div class="sec-head" style="margin-top:44px;" data-anim>
          <div class="sec-head-left">
            <div class="section-label">Biến động ngành</div>
            <h2 class="section-title">Thị Trường & Xu Hướng</h2>
          </div>
          <a href="{{ route('news.index', ['category' => 'thi-truong']) }}" class="sec-link">Xem thêm &#8594;</a>
        </div>

        <div class="grid3" data-anim>
          {{-- Card thị trường — showroom xe sang --}}
          <a href="#" class="a-card" style="text-decoration:none">
            <div class="a-card-img">
              <img src="https://images.unsplash.com/photo-1549927681-0b673b8243ab?w=500&q=75"
                   alt="Thị trường xe sang" loading="lazy"/>
              <div class="date-badge">18/02</div>
            </div>
            <div class="a-card-body">
              <div class="a-card-tag">Thị Trường</div>
              <div class="a-card-title">Doanh Số Xe Sang Tăng Vọt 32% Trong Q1/2025</div>
              <div class="a-card-meta" style="margin-top:8px"><span>18/02</span><div class="story-meta-dot"></div><span>4 ph đọc</span></div>
            </div>
          </a>
          {{-- Card sự kiện — triển lãm xe --}}
          <a href="#" class="a-card" style="text-decoration:none">
            <div class="a-card-img">
              <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&q=75"
                   alt="Vietnam Motor Show" loading="lazy"/>
              <div class="date-badge">14/02</div>
            </div>
            <div class="a-card-body">
              <div class="a-card-tag">Sự Kiện</div>
              <div class="a-card-title">Vietnam Motor Show 2025: 50+ Mẫu Xe Ra Mắt</div>
              <div class="a-card-meta" style="margin-top:8px"><span>14/02</span><div class="story-meta-dot"></div><span>5 ph đọc</span></div>
            </div>
          </a>
          {{-- Card mẹo — tư vấn mua xe --}}
          <a href="#" class="a-card" style="text-decoration:none">
            <div class="a-card-img">
              <img src="https://images.unsplash.com/photo-1560253023-3ec5d502959f?w=500&q=75"
                   alt="Mẹo mua xe" loading="lazy"/>
              <div class="date-badge">10/02</div>
            </div>
            <div class="a-card-body">
              <div class="a-card-tag">Mẹo Hay</div>
              <div class="a-card-title">7 Điều Bắt Buộc Kiểm Tra Trước Khi Ký Hợp Đồng</div>
              <div class="a-card-meta" style="margin-top:8px"><span>10/02</span><div class="story-meta-dot"></div><span>6 ph đọc</span></div>
            </div>
          </a>
        </div>

        {{-- REVIEW TICKER --}}
        <div class="ticker-bar" data-anim="fade">
          <div class="ticker-label">Đánh giá</div>
          <div class="ticker-track">
            <div class="ticker-item"><span class="ticker-stars">★★★★★</span> "Dịch vụ xuất sắc, xe đúng như mô tả, giao xe đúng hẹn." <span class="ticker-author">— Anh Minh, TP.HCM</span></div>
            <div class="ticker-item"><span class="ticker-stars">★★★★★</span> "Tư vấn tận tâm, không bị ép mua. Rất chuyên nghiệp." <span class="ticker-author">— Chị Hà, Hà Nội</span></div>
            <div class="ticker-item"><span class="ticker-stars">★★★★★</span> "Thủ tục vay nhanh gọn, lãi suất tốt hơn tôi tưởng." <span class="ticker-author">— Anh Khoa, Đà Nẵng</span></div>
            <div class="ticker-item"><span class="ticker-stars">★★★★★</span> "Hậu mãi tốt, gọi là có người hỗ trợ ngay. Uy tín số 1." <span class="ticker-author">— Anh Tuấn, Cần Thơ</span></div>
            <div class="ticker-item"><span class="ticker-stars">★★★★★</span> "Dịch vụ xuất sắc, xe đúng như mô tả, giao xe đúng hẹn." <span class="ticker-author">— Anh Minh, TP.HCM</span></div>
            <div class="ticker-item"><span class="ticker-stars">★★★★★</span> "Tư vấn tận tâm, không bị ép mua. Rất chuyên nghiệp." <span class="ticker-author">— Chị Hà, Hà Nội</span></div>
            <div class="ticker-item"><span class="ticker-stars">★★★★★</span> "Thủ tục vay nhanh gọn, lãi suất tốt hơn tôi tưởng." <span class="ticker-author">— Anh Khoa, Đà Nẵng</span></div>
            <div class="ticker-item"><span class="ticker-stars">★★★★★</span> "Hậu mãi tốt, gọi là có người hỗ trợ ngay. Uy tín số 1." <span class="ticker-author">— Anh Tuấn, Cần Thơ</span></div>
          </div>
        </div>

      </div>{{-- END LEFT --}}

      {{-- ═══ SIDEBAR ═══ --}}
      <div class="sidebar">

        {{-- POPULAR --}}
        <div class="sidebar-block" data-anim>
          <div class="sidebar-title">Đọc Nhiều Nhất</div>
          @forelse($popularPosts ?? [] as $i => $popular)
          <a href="{{ route('news.show', $popular->slug) }}" class="rank-item {{ $i === 0 ? 'top' : '' }}" style="text-decoration:none">
            <div class="rank-num">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</div>
            <div>
              <div class="rank-title">{{ $popular->title }}</div>
              <div class="rank-meta">{{ $popular->published_at->format('d/m') }} · {{ number_format($popular->views) }} lượt xem</div>
            </div>
          </a>
          @empty
          <div class="rank-item top"><div class="rank-num">01</div><div><div class="rank-title">BMW M5 Hybrid 2025: 727 Mã Lực, Kỷ Lục Toàn Thời Đại</div><div class="rank-meta">15/03 · 7.2K LƯỢT XEM</div></div></div>
          <div class="rank-item"><div class="rank-num">02</div><div><div class="rank-title">Porsche 911 GT3 RS: Siêu Phẩm Đường Đua</div><div class="rank-meta">10/03 · 5.8K LƯỢT XEM</div></div></div>
          <div class="rank-item"><div class="rank-num">03</div><div><div class="rank-title">Tesla vs BYD: Ai Thắng Tại Việt Nam?</div><div class="rank-meta">08/03 · 5.1K LƯỢT XEM</div></div></div>
          <div class="rank-item"><div class="rank-num">04</div><div><div class="rank-title">Lamborghini Urus S: Đánh Giá Sau 1.000 km</div><div class="rank-meta">28/02 · 4.1K LƯỢT XEM</div></div></div>
          <div class="rank-item"><div class="rank-num">05</div><div><div class="rank-title">Vietnam Motor Show 2025 — Tất Cả Cần Biết</div><div class="rank-meta">14/02 · 3.6K LƯỢT XEM</div></div></div>
          @endforelse
        </div>

        {{-- RECENT --}}
        <div class="sidebar-block" data-anim>
          <div class="sidebar-title">Tin Mới Nhất</div>
          @forelse($recentPosts ?? [] as $recent)
          <a href="{{ route('news.show', $recent->slug) }}" class="h-card" style="text-decoration:none;margin-bottom:2px;display:grid">
            <div class="h-card-img">
              @if($recent->thumbnail)
                <img src="{{ asset('storage/'.$recent->thumbnail) }}" alt="{{ $recent->title }}" loading="lazy">
              @else
                <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=100&q=60" alt="car" loading="lazy">
              @endif
            </div>
            <div class="h-card-body">
              <div class="h-card-title">{{ $recent->title }}</div>
              <div class="rank-meta">{{ $recent->published_at->format('d/m') }} · {{ $recent->read_time ?? 3 }} ph đọc</div>
            </div>
          </a>
          @empty
          {{-- Sidebar recent 1 — Audi RS6 thực tế --}}
          <a href="#" class="h-card" style="text-decoration:none;margin-bottom:2px;display:grid">
            <div class="h-card-img">
              <img src="https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=150&q=70"
                   alt="Audi RS6" loading="lazy"/>
            </div>
            <div class="h-card-body">
              <div class="h-card-title">Audi RS6 Avant 2025 về Việt Nam: Giá Từ 5,2 Tỷ</div>
              <div class="rank-meta">01/03 · 3 ph đọc</div>
            </div>
          </a>
          {{-- Sidebar recent 2 — Bentley Bentayga thực tế --}}
          <a href="#" class="h-card" style="text-decoration:none;margin-bottom:2px;display:grid">
            <div class="h-card-img">
              <img src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?w=150&q=70"
                   alt="Bentley" loading="lazy"/>
            </div>
            <div class="h-card-body">
              <div class="h-card-title">Bentley Bentayga EWB: Sang Trọng Vô Đối Phân Khúc SUV</div>
              <div class="rank-meta">27/02 · 4 ph đọc</div>
            </div>
          </a>
          {{-- Sidebar recent 3 — Tesla Model 3 thực tế --}}
          <a href="#" class="h-card" style="text-decoration:none;margin-bottom:0;display:grid">
            <div class="h-card-img">
              <img src="https://images.unsplash.com/photo-1561580125-028ee3bd62eb?w=150&q=70"
                   alt="Tesla Model 3" loading="lazy"/>
            </div>
            <div class="h-card-body">
              <div class="h-card-title">Tesla Model 3 Highland: Bản Nâng Cấp Có Đáng Tiền?</div>
              <div class="rank-meta">24/02 · 5 ph đọc</div>
            </div>
          </a>
          @endforelse
        </div>

        {{-- NEWSLETTER --}}
        <div class="nl-sidebar" data-anim>
          <div class="nl-sidebar-title">Đừng Bỏ<br/>Lỡ Tin Mới</div>
          <p>Nhận ngay các đánh giá xe, tin tức & ưu đãi đặc biệt mỗi tuần.</p>
          <form class="nl-form" action="{{ route('newsletter.subscribe') }}" method="POST">
            @csrf
            <input type="email" name="email" class="nl-input" placeholder="Email của bạn..." required>
            <button type="submit" class="nl-btn">Đăng Ký &#8594;</button>
          </form>
        </div>

        {{-- TAGS --}}
        <div class="sidebar-block" data-anim>
          <div class="sidebar-title">Chủ Đề</div>
          <div class="tag-cloud">
            @forelse($tags ?? [] as $tag)
              <a href="{{ route('news.index', ['tag' => $tag->slug]) }}" class="tag-c">{{ $tag->name }}</a>
            @empty
              <a href="{{ route('news.index', ['tag' => 'bmw']) }}" class="tag-c">BMW</a>
              <a href="{{ route('news.index', ['tag' => 'mercedes']) }}" class="tag-c">Mercedes</a>
              <a href="{{ route('news.index', ['tag' => 'porsche']) }}" class="tag-c">Porsche</a>
              <a href="{{ route('news.index', ['tag' => 'tesla']) }}" class="tag-c">Tesla</a>
              <a href="{{ route('news.index', ['tag' => 'ferrari']) }}" class="tag-c">Ferrari</a>
              <a href="{{ route('news.index', ['tag' => 'xe-dien']) }}" class="tag-c">Xe Điện</a>
              <a href="{{ route('news.index', ['tag' => 'suv']) }}" class="tag-c">SUV</a>
              <a href="{{ route('news.index', ['tag' => 'hybrid']) }}" class="tag-c">Hybrid</a>
              <a href="{{ route('news.index', ['category' => 'danh-gia']) }}" class="tag-c">Đánh Giá</a>
              <a href="{{ route('news.index', ['category' => 'meo-hay']) }}" class="tag-c">Mẹo Hay</a>
              <a href="{{ route('news.index', ['category' => 'thi-truong']) }}" class="tag-c">Thị Trường</a>
              <a href="{{ route('news.index', ['tag' => 'lamborghini']) }}" class="tag-c">Lamborghini</a>
              <a href="{{ route('news.index', ['tag' => 'rolls-royce']) }}" class="tag-c">Rolls-Royce</a>
              <a href="{{ route('news.index', ['tag' => 'audi']) }}" class="tag-c">Audi</a>
            @endforelse
          </div>
        </div>

      </div>{{-- END SIDEBAR --}}
    </div>{{-- END news-grid --}}
  </div>
</section>

{{-- ─── STATS STRIP ─── --}}
<div class="stats-strip">
  <div class="container" style="padding:0">
    <div class="stats-grid">
      <div class="stat-item"><div class="stat-num" data-count="{{ $totalCount ?? 128 }}" data-suffix="+">0</div><div class="stat-label">Bài viết</div></div>
      <div class="stat-item"><div class="stat-num" data-count="30" data-suffix="K">0</div><div class="stat-label">Lượt đọc / tháng</div></div>
      <div class="stat-item"><div class="stat-num" data-count="6" data-suffix="">0</div><div class="stat-label">Chuyên mục</div></div>
      <div class="stat-item"><div class="stat-num" data-count="49" data-suffix="★">0</div><div class="stat-label">Điểm đánh giá</div></div>
    </div>
  </div>
</div>

{{-- ─── CTA ─── --}}
<section style="background:var(--bg);padding:80px 0;position:relative;overflow:hidden;text-align:center">
  <div style="position:absolute;inset:0;background:radial-gradient(ellipse 70% 60% at 50% 110%,rgba(184,151,58,.12) 0%,transparent 70%)"></div>
  <div class="container" style="position:relative">
    <div class="section-label" style="justify-content:center;" data-anim>
      <div style="width:3px;height:14px;background:var(--gold)"></div>
      Bạn đang tìm xe?
    </div>
    <h2 style="font-family:'Barlow Condensed',sans-serif;font-size:clamp(36px,5vw,62px);font-weight:800;text-transform:uppercase;color:var(--dark);line-height:1;letter-spacing:-.5px;margin-top:8px" data-anim>
      Khám Phá <span style="color:var(--gold)">Showroom</span><br/>Của Chúng Tôi
    </h2>
    <p style="color:var(--muted);max-width:440px;margin:18px auto 32px;font-size:14px;line-height:1.75" data-anim>
      Hơn 200 mẫu xe từ 30+ thương hiệu danh tiếng. Liên hệ ngay để được tư vấn miễn phí.
    </p>
    <div style="display:flex;gap:10px;justify-content:center" data-anim>
      <a href="{{ route('cars.index') }}" style="display:inline-flex;align-items:center;gap:10px;background:var(--gold);color:#fff;font-family:'Rajdhani',sans-serif;font-size:12px;font-weight:700;letter-spacing:3px;text-transform:uppercase;padding:13px 28px;text-decoration:none;transition:background .2s,transform .15s" onmouseover="this.style.background='#8a6d1e';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='var(--gold)';this.style.transform='none'">Xem Xe Ngay &#8594;</a>
      <a href="#" style="display:inline-flex;align-items:center;gap:10px;background:transparent;color:var(--dark);font-family:'Rajdhani',sans-serif;font-size:12px;font-weight:700;letter-spacing:3px;text-transform:uppercase;padding:12px 28px;text-decoration:none;border:1px solid var(--border);transition:border-color .2s,color .2s" onmouseover="this.style.borderColor='var(--gold)';this.style.color='var(--gold)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--dark)'">Liên Hệ Ngay</a>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
  // Scroll reveal
  const observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(e) {
      if (e.isIntersecting) e.target.classList.add('visible');
    });
  }, { threshold: 0.08 });
  document.querySelectorAll('[data-anim]').forEach(function(el) { observer.observe(el); });

  // Counter animation
  function animateCount(el) {
    const target = parseInt(el.dataset.count);
    const suffix = el.dataset.suffix || '';
    const duration = 700;
    const steps = 40;
    const stepTime = duration / steps;
    let current = 0;
    el.style.opacity = '0';
    el.style.transform = 'translateY(12px)';
    setTimeout(function() {
      el.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
      el.style.opacity = '1';
      el.style.transform = 'translateY(0)';
      if (el.dataset.count === '49') {
        const timer = setInterval(function() {
          current += target / steps;
          if (current >= target) { current = target; clearInterval(timer); }
          el.textContent = (Math.floor(current) / 10).toFixed(1) + suffix;
        }, stepTime);
        return;
      }
      const timer = setInterval(function() {
        current += target / steps;
        if (current >= target) { current = target; clearInterval(timer); }
        el.textContent = Math.floor(current) + suffix;
      }, stepTime);
    }, 200);
  }

  const counterObserver = new IntersectionObserver(function(entries) {
    entries.forEach(function(e) {
      if (e.isIntersecting && !e.target.dataset.counted) {
        e.target.dataset.counted = '1';
        animateCount(e.target);
      }
    });
  }, { threshold: 0.5 });
  document.querySelectorAll('.stat-num[data-count]').forEach(function(el) { counterObserver.observe(el); });
</script>
@endpush