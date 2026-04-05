{{-- ============================================================
     resources/views/news.blade.php
     Trang Tin Tức — Concept Car Dealer
     ============================================================ --}}
@extends('layouts.frontend')
@section('title', 'Tin Tức — Concept Car Dealer')

@push('styles')
<style>
  :root {
    --red: #d42b2b; --red-dark: #b01e1e;
    --red-light: rgba(212,43,43,0.08); --red-border: rgba(212,43,43,0.22);
    --bg:  #1c1c1e; --bg2: #242426; --bg3: #2c2c2f; --card: #2a2a2d;
    --border: #3a3a3e; --border-light: #4a4a4e;
    --white: #f5f0eb; --text: #c8c3bc; --muted: #8a857e; --subtle: #5a5854;
  }

  /* ─── BASE ─── */
  .container { max-width: 1240px; margin: 0 auto; padding: 0 48px; }
  .section-label {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: 4px; text-transform: uppercase; color: var(--red);
    margin-bottom: 10px; display: flex; align-items: center; gap: 10px;
  }
  .section-label::before { content: ''; width: 3px; height: 14px; background: var(--red); flex-shrink: 0; }
  .section-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(24px,2.8vw,36px); font-weight: 800;
    text-transform: uppercase; color: var(--white); letter-spacing: -.5px;
  }

  /* ─── HERO ─── */
  .hero {
    position: relative; height: 340px;
    background: linear-gradient(160deg,#1c1c1e 0%,#2a1616 45%,#1c1c1e 100%);
    display: flex; align-items: center; justify-content: center; overflow: hidden;
  }
  .hero::before {
    content: ''; position: absolute; inset: 0;
    background:
      repeating-linear-gradient(90deg,transparent,transparent 80px,rgba(212,43,43,.025) 80px,rgba(212,43,43,.025) 81px),
      repeating-linear-gradient(0deg,transparent,transparent 80px,rgba(212,43,43,.025) 80px,rgba(212,43,43,.025) 81px);
  }
  .hero-glow {
    position: absolute; width: 600px; height: 280px;
    background: radial-gradient(ellipse,rgba(180,30,30,.18) 0%,transparent 68%);
    top: 50%; left: 50%; transform: translate(-50%,-50%);
    animation: pulse 5s ease-in-out infinite;
  }
  @keyframes pulse { 0%,100%{opacity:.5;transform:translate(-50%,-50%) scale(1)} 50%{opacity:1;transform:translate(-50%,-50%) scale(1.08)} }
  .hero-content { position: relative; text-align: center; }
  .hero-eyebrow {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: 5px; text-transform: uppercase; color: var(--red);
    margin-bottom: 14px; display: flex; align-items: center; justify-content: center; gap: 14px;
  }
  .hero-eyebrow::before,.hero-eyebrow::after { content:''; width:30px; height:1px; background:var(--red); opacity:.5; }
  .hero h1 {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(52px,7vw,88px); font-weight: 800;
    color: var(--white); line-height: .92; text-transform: uppercase; letter-spacing: -1px;
  }
  .hero h1 em { color: var(--red); font-style: normal; }
  .hero-sub { margin-top: 16px; font-size: 14px; color: var(--muted); letter-spacing: .5px; }
  .breadcrumb {
    position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);
    display: flex; align-items: center; gap: 10px;
    font-size: 12px; letter-spacing: 1px; color: var(--subtle);
    white-space: nowrap;
  }
  .breadcrumb a { color: var(--subtle); text-decoration: none; transition: color .2s; }
  .breadcrumb a:hover { color: var(--red); }
  .breadcrumb span.active { color: var(--red); }

  /* ─── CATEGORY FILTER BAR ─── */
  .filter-bar { background: var(--bg2); border-bottom: 1px solid var(--border); }
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
  }
  .filter-tab:hover { color: var(--white); }
  .filter-tab.active { color: var(--white); border-bottom-color: var(--red); }
  .filter-count {
    font-size: 10px; color: var(--subtle); margin-left: 5px;
    font-family: 'Rajdhani', sans-serif; font-weight: 600;
  }

  /* ─── MAIN LAYOUT ─── */
  .news-layout { background: var(--bg); padding: 56px 0 80px; }
  .news-grid { display: grid; grid-template-columns: 1fr 300px; gap: 40px; align-items: start; }

  /* ─── SEC HEAD ─── */
  .sec-head { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 20px; }
  .sec-head-left { display: flex; flex-direction: column; gap: 4px; }
  .sec-link {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; color: var(--red);
    text-decoration: none; display: flex; align-items: center; gap: 6px; transition: gap .2s;
  }
  .sec-link:hover { gap: 10px; }

  /* ─── HERO STORY (featured) ─── */
  .story-hero {
    background: var(--card); border: 1px solid var(--border); overflow: hidden;
    cursor: pointer; position: relative;
    transition: border-color .3s; display: grid; grid-template-columns: 340px 1fr;
  }
  .story-hero:hover { border-color: var(--red); }
  .story-hero-img {
    position: relative; overflow: hidden; background: var(--bg3);
    min-height: 260px;
  }
  .story-hero-img svg {
    position: absolute; top: 0; left: 0;
    width: 100%; height: 100%; display: block;
  }
  .story-hero-badge {
    position: absolute; top: 16px; left: 16px;
    background: var(--red); color: #fff;
    font-family: 'Rajdhani', sans-serif; font-size: 9px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; padding: 4px 12px; z-index: 2;
  }
  .story-hero-body { padding: 28px 32px; display: flex; flex-direction: column; justify-content: center; }
  .story-tag {
    font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; color: var(--red);
    display: flex; align-items: center; gap: 8px; margin-bottom: 12px;
  }
  .story-tag::before { content: ''; width: 16px; height: 1px; background: var(--red); }
  .story-hero-title {
    font-family: 'Barlow Condensed', sans-serif; font-size: clamp(22px,2.2vw,32px);
    font-weight: 800; text-transform: uppercase; color: var(--white);
    line-height: 1.05; letter-spacing: -.3px; margin-bottom: 12px;
  }
  .story-hero-title em { color: var(--red); font-style: normal; }
  .story-excerpt { font-size: 13px; color: var(--muted); line-height: 1.75; margin-bottom: 16px; }
  .story-meta {
    display: flex; align-items: center; gap: 12px;
    font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 600;
    letter-spacing: 2px; text-transform: uppercase; color: var(--subtle);
  }
  .story-meta-dot { width: 3px; height: 3px; background: var(--subtle); border-radius: 50%; }
  .story-meta-author { color: var(--text); }
  .btn-read {
    display: inline-flex; align-items: center; gap: 8px; margin-top: 18px;
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; color: var(--red);
    text-decoration: none; transition: gap .2s;
  }
  .btn-read:hover { gap: 14px; }

  /* ─── 3-COL GRID ─── */
  .grid3 { display: grid; grid-template-columns: repeat(3,1fr); gap: 2px; }
  .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 2px; }

  /* ─── ARTICLE CARD ─── */
  .a-card {
    background: var(--card); border: 1px solid var(--border); overflow: hidden;
    cursor: pointer; transition: border-color .3s, background .3s; position: relative;
  }
  .a-card::after {
    content: ''; position: absolute; bottom: 0; left: 0; right: 0;
    height: 2px; background: var(--red); transform: scaleX(0); transform-origin: left;
    transition: transform .35s;
  }
  .a-card:hover::after { transform: scaleX(1); }
  .a-card:hover { border-color: var(--border-light); background: var(--bg3); }

  /* ─── CARD IMAGE — fixed height, no huge gaps ─── */
  .a-card-img {
    overflow: hidden; height: 160px; background: var(--bg3);
    position: relative;
  }
  .a-card-img img,
  .a-card-img svg { width: 100%; height: 100%; display: block; object-fit: cover; }

  .a-card-body { padding: 16px 18px 18px; }
  .a-card-tag {
    font-family: 'Rajdhani', sans-serif; font-size: 9px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; color: var(--red);
    border-left: 2px solid var(--red); padding-left: 8px; margin-bottom: 8px;
    display: inline-block;
  }
  .a-card-title {
    font-family: 'Barlow Condensed', sans-serif; font-size: 16px; font-weight: 700;
    text-transform: uppercase; color: var(--white); line-height: 1.2; margin-bottom: 8px;
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
    cursor: pointer; transition: border-color .3s;
  }
  .mag-wide:hover { border-color: var(--red); }
  .mag-wide-img { overflow: hidden; background: var(--bg3); max-height: 260px; }
  .mag-wide-img svg { width: 100%; height: 100%; display: block; object-fit: cover; }
  .mag-wide-body {
    padding: 32px 36px; display: flex; flex-direction: column; justify-content: center;
    border-left: 1px solid var(--border);
  }
  .mag-wide-label {
    display: inline-block; background: var(--red); color: #fff;
    font-family: 'Rajdhani', sans-serif; font-size: 9px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; padding: 4px 12px; margin-bottom: 14px;
  }
  .mag-wide-title {
    font-family: 'Barlow Condensed', sans-serif; font-size: clamp(20px,1.8vw,28px);
    font-weight: 800; text-transform: uppercase; color: var(--white);
    line-height: 1.1; margin-bottom: 12px;
  }
  .mag-wide-excerpt { font-size: 13px; color: var(--muted); line-height: 1.75; margin-bottom: 18px; }

  /* ─── H-CARD (list style) ─── */
  .h-card {
    background: var(--card); border: 1px solid var(--border); overflow: hidden;
    display: grid; grid-template-columns: 90px 1fr;
    cursor: pointer; transition: border-color .3s, background .3s;
  }
  .h-card:hover { border-color: var(--border-light); background: var(--bg3); }
  .h-card-img { overflow: hidden; background: var(--bg3); }
  .h-card-img img,
  .h-card-img svg { width: 100%; height: 100%; display: block; object-fit: cover; }
  .h-card-body { padding: 12px 14px; display: flex; flex-direction: column; justify-content: center; }
  .h-card-title {
    font-family: 'Barlow Condensed', sans-serif; font-size: 13px; font-weight: 700;
    text-transform: uppercase; color: var(--white); line-height: 1.3; margin-bottom: 6px;
  }

  /* ─── VIDEO CARDS ─── */
  .video-card {
    background: var(--card); border: 1px solid var(--border); overflow: hidden;
    cursor: pointer; transition: border-color .3s;
  }
  .video-card:hover { border-color: var(--red); }
  .video-thumb { position: relative; overflow: hidden; height: 160px; background: var(--bg3); }
  .video-thumb svg { width: 100%; height: 100%; display: block; transition: transform .5s; }
  .video-card:hover .video-thumb svg { transform: scale(1.04); }
  .play-btn {
    position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
    width: 46px; height: 46px; background: rgba(212,43,43,.92); border-radius: 50%;
    display: flex; align-items: center; justify-content: center; transition: transform .2s;
  }
  .video-card:hover .play-btn { transform: translate(-50%,-50%) scale(1.1); }
  .play-icon { width: 0; height: 0; border-top: 9px solid transparent; border-bottom: 9px solid transparent; border-left: 15px solid #fff; margin-left: 3px; }
  .video-body { padding: 16px 18px; }

  /* ─── SIDEBAR ─── */
  .sidebar { display: flex; flex-direction: column; gap: 2px; }
  .sidebar-block { background: var(--card); border: 1px solid var(--border); padding: 22px 20px; }
  .sidebar-title {
    font-family: 'Barlow Condensed', sans-serif; font-size: 16px; font-weight: 800;
    text-transform: uppercase; color: var(--white); letter-spacing: .5px;
    padding-bottom: 12px; border-bottom: 2px solid var(--red); margin-bottom: 14px;
    display: flex; align-items: center; gap: 8px;
  }
  .sidebar-title::before { content: ''; width: 3px; height: 16px; background: var(--red); }

  /* Rank items */
  .rank-item {
    display: flex; gap: 12px; align-items: flex-start;
    padding: 12px 0; border-bottom: 1px solid var(--border);
    cursor: pointer; transition: background .2s;
  }
  .rank-item:last-child { border-bottom: none; padding-bottom: 0; }
  .rank-num {
    font-family: 'Barlow Condensed', sans-serif; font-size: 32px; font-weight: 800;
    color: rgba(90,88,84,.2); line-height: 1; flex-shrink: 0; width: 28px;
    transition: color .3s;
  }
  .rank-item:hover .rank-num { color: var(--red); }
  .rank-item.top .rank-num { color: rgba(212,43,43,.3); }
  .rank-title {
    font-family: 'Barlow Condensed', sans-serif; font-size: 13px; font-weight: 700;
    text-transform: uppercase; color: var(--white); line-height: 1.3; margin-bottom: 4px;
  }
  .rank-meta {
    font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 600;
    letter-spacing: 2px; text-transform: uppercase; color: var(--subtle);
  }

  /* Tag cloud */
  .tag-cloud { display: flex; flex-wrap: wrap; gap: 5px; }
  .tag-c {
    font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase; color: var(--muted);
    border: 1px solid var(--border); padding: 6px 12px; cursor: pointer;
    text-decoration: none; transition: color .2s, border-color .2s;
  }
  .tag-c:hover { color: var(--red); border-color: var(--red); }

  /* Newsletter in sidebar */
  .nl-sidebar { background: var(--red); padding: 22px 20px; }
  .nl-sidebar-title {
    font-family: 'Barlow Condensed', sans-serif; font-size: 20px; font-weight: 800;
    text-transform: uppercase; color: #fff; margin-bottom: 6px; line-height: 1.1;
  }
  .nl-sidebar p { font-size: 12px; color: rgba(255,255,255,.7); margin-bottom: 14px; line-height: 1.6; }
  .nl-form { display: flex; flex-direction: column; gap: 7px; }
  .nl-input {
    background: rgba(0,0,0,.2); border: 1px solid rgba(255,255,255,.25); color: #fff;
    padding: 10px 12px; font-size: 12px; font-family: 'Barlow Condensed', sans-serif;
    outline: none; transition: border-color .2s;
  }
  .nl-input::placeholder { color: rgba(255,255,255,.4); }
  .nl-input:focus { border-color: rgba(255,255,255,.6); }
  .nl-btn {
    background: #fff; color: var(--red); border: none; padding: 11px;
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; cursor: pointer; transition: background .2s, color .2s;
  }
  .nl-btn:hover { background: var(--red-dark); color: #fff; }

  /* ─── REVIEWS TICKER ─── */
  .ticker-bar {
    background: var(--bg3); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);
    overflow: hidden; height: 40px; display: flex; align-items: center; margin: 40px 0 0;
  }
  .ticker-label {
    background: var(--red); color: #fff; flex-shrink: 0;
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
  .ticker-stars { color: var(--red); font-size: 11px; font-style: normal; }

  /* ─── STATS STRIP ─── */
  .stats-strip { background: var(--red); }
  .stats-grid { display: grid; grid-template-columns: repeat(4,1fr); border-left: 1px solid rgba(255,255,255,.15); }
  .stat-item { padding: 32px 20px; text-align: center; border-right: 1px solid rgba(255,255,255,.15); transition: background .2s; }
  .stat-item:hover { background: rgba(0,0,0,.12); }
  .stat-num { font-family: 'Barlow Condensed', sans-serif; font-size: 44px; font-weight: 800; color: #fff; line-height: 1; }
  .stat-num sup { font-size: 18px; vertical-align: top; margin-top: 6px; }
  .stat-label { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: 3px; text-transform: uppercase; color: rgba(255,255,255,.7); margin-top: 5px; }

  /* ─── DIVIDER ─── */
  .divider-line { width: 40px; height: 3px; background: var(--red); margin: 14px 0 20px; }

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
    .story-hero { grid-template-columns: 280px 1fr; }
    .mag-wide { grid-template-columns: 1fr; }
    .mag-wide-img { max-height: 220px; }
    .grid3 { grid-template-columns: 1fr 1fr; }
  }
  @media(max-width:700px){
    .container { padding: 0 16px; }
    .grid3, .grid2 { grid-template-columns: 1fr; }
    .story-hero { grid-template-columns: 1fr; }
    .story-hero-img { min-height: 180px; }
    .h-card { grid-template-columns: 80px 1fr; }
    .story-hero-body { padding: 20px 18px; }
  }
</style>
@endpush

@section('content')

{{-- ─── HERO ─── --}}
<section class="hero">
  <div class="hero-glow"></div>
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
      <button class="filter-tab active" data-cat="">Tất Cả <span class="filter-count">128</span></button>
      <button class="filter-tab" data-cat="ra-mat-moi">Ra Mắt Mới <span class="filter-count">34</span></button>
      <button class="filter-tab" data-cat="danh-gia">Đánh Giá <span class="filter-count">46</span></button>
      <button class="filter-tab" data-cat="xu-huong">Xu Hướng <span class="filter-count">18</span></button>
      <button class="filter-tab" data-cat="cong-nghe">Công Nghệ <span class="filter-count">22</span></button>
      <button class="filter-tab" data-cat="thi-truong">Thị Trường <span class="filter-count">20</span></button>
      <button class="filter-tab" data-cat="meo-hay">Mẹo Hay <span class="filter-count">15</span></button>
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

        <a href="{{ route('news.show', 'bmw-m5-hybrid-2025') }}" class="story-hero" style="display:grid;text-decoration:none" data-anim>
          <div class="story-hero-img">
            <svg viewBox="0 0 340 260" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
              <defs>
                <radialGradient id="hg" cx="45%" cy="60%" r="65%">
                  <stop offset="0%" stop-color="#1e0a0a"/>
                  <stop offset="100%" stop-color="#080808"/>
                </radialGradient>
              </defs>
              <rect width="340" height="260" fill="url(#hg)"/>
              <g transform="translate(30,40)">
                <path d="M28,145 L50,92 L130,60 L242,56 L300,80 L316,122 L320,148 L320,170 L28,170 Z" fill="#1c1c1c" stroke="#d42b2b" stroke-width="1.5"/>
                <path d="M130,60 L154,38 L242,56" fill="none" stroke="#d42b2b" stroke-width="1" opacity=".25"/>
                <circle cx="92" cy="172" r="30" fill="#111" stroke="#d42b2b" stroke-width="2"/>
                <circle cx="92" cy="172" r="16" fill="#0d0d0d" stroke="#3a3a3e" stroke-width="1.5"/>
                <circle cx="92" cy="172" r="6" fill="#d42b2b"/>
                <circle cx="272" cy="172" r="30" fill="#111" stroke="#d42b2b" stroke-width="2"/>
                <circle cx="272" cy="172" r="16" fill="#0d0d0d" stroke="#3a3a3e" stroke-width="1.5"/>
                <circle cx="272" cy="172" r="6" fill="#d42b2b"/>
                <ellipse cx="182" cy="172" rx="160" ry="7" fill="rgba(212,43,43,.05)"/>
              </g>
              <text x="28" y="36" font-family="Barlow Condensed" font-size="32" font-weight="800" letter-spacing="2" fill="#d42b2b" opacity=".06">BMW M5</text>
              <text x="28" y="248" font-family="Rajdhani" font-size="9" letter-spacing="5" fill="#d42b2b" opacity=".3">CONCEPT — EXCLUSIVE</text>
              <rect x="0" y="0" width="340" height="2.5" fill="#d42b2b"/>
            </svg>
            <div class="story-hero-badge">COVER STORY</div>
          </div>
          <div class="story-hero-body">
            <div class="story-tag">Ra Mắt Mới</div>
            <h2 class="story-hero-title">BMW M5 <em>Hybrid</em> 2025:<br/>Cuộc Cách Mạng <em>727</em> Mã Lực</h2>
            <p class="story-excerpt">BMW chính thức công bố thế hệ M5 hoàn toàn mới tích hợp hệ thống hybrid plug-in, tổng công suất 727 mã lực. Tăng tốc 0–100 km/h chỉ 3.5 giây — phá vỡ mọi kỷ lục M5 từ trước đến nay.</p>
            <div class="story-meta">
              <span>15/03/2025</span>
              <div class="story-meta-dot"></div>
              <span class="story-meta-author">MINH KHOA</span>
              <div class="story-meta-dot"></div>
              <span>7 PHÚT ĐỌC</span>
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
                <img src="{{ asset('storage/'.$post->thumbnail) }}" alt="{{ $post->title }}">
              @else
              <svg viewBox="0 0 340 160" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
                <rect width="340" height="160" fill="#222224"/>
                <text x="170" y="88" text-anchor="middle" font-family="Barlow Condensed" font-size="12" letter-spacing="3" fill="#3a3a3e">{{ strtoupper(Str::limit($post->title,20)) }}</text>
              </svg>
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
          {{-- FALLBACK: 3 static cards --}}
          <a href="#" class="a-card" style="text-decoration:none">
            <div class="a-card-img">
              <svg viewBox="0 0 340 160" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
                <rect width="340" height="160" fill="#1c1c1e"/>
                <radialGradient id="c1" cx="50%" cy="55%" r="55%"><stop offset="0%" stop-color="#1c0808"/><stop offset="100%" stop-color="#111"/></radialGradient>
                <rect width="340" height="160" fill="url(#c1)"/>
                <g transform="translate(24,20)">
                  <path d="M18,90 L34,54 L88,34 L172,30 L226,50 L246,76 L250,100 L250,114 L18,114 Z" fill="#1c1c1c" stroke="#d42b2b" stroke-width="1.5"/>
                  <circle cx="64" cy="116" r="22" fill="#111" stroke="#d42b2b" stroke-width="1.5"/>
                  <circle cx="204" cy="116" r="22" fill="#111" stroke="#d42b2b" stroke-width="1.5"/>
                </g>
                <text x="170" y="148" text-anchor="middle" font-family="Rajdhani" font-size="8" letter-spacing="3" fill="#d42b2b" opacity=".35">FERRARI SF90 XX</text>
              </svg>
            </div>
            <div class="a-card-body">
              <div class="a-card-tag">Ra Mắt Mới</div>
              <div class="a-card-title">Ferrari SF90 XX Stradale: Gần 1.000 HP Cho Đường Phố</div>
              <p class="a-card-excerpt">Siêu xe hybrid mạnh nhất Ferrari, 0–100 trong 2.3 giây, giới hạn 799 chiếc.</p>
              <div class="a-card-meta"><span>05/03</span><div class="story-meta-dot"></div><span>6 ph đọc</span></div>
            </div>
          </a>
          <a href="#" class="a-card" style="text-decoration:none">
            <div class="a-card-img">
              <svg viewBox="0 0 340 160" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
                <rect width="340" height="160" fill="#1c1c1e"/>
                <radialGradient id="c2" cx="50%" cy="55%" r="55%"><stop offset="0%" stop-color="#061606"/><stop offset="100%" stop-color="#111"/></radialGradient>
                <rect width="340" height="160" fill="url(#c2)"/>
                <g transform="translate(24,20)">
                  <path d="M16,92 L34,52 L96,30 L178,26 L238,48 L258,78 L262,102 L262,114 L16,114 Z" fill="#141c14" stroke="#336633" stroke-width="1.5"/>
                  <circle cx="70" cy="116" r="22" fill="#111" stroke="#336633" stroke-width="1.5"/>
                  <circle cx="208" cy="116" r="22" fill="#111" stroke="#336633" stroke-width="1.5"/>
                </g>
                <text x="170" y="148" text-anchor="middle" font-family="Rajdhani" font-size="8" letter-spacing="3" fill="#449944" opacity=".45">MERCEDES EQS 2025</text>
              </svg>
            </div>
            <div class="a-card-body">
              <div class="a-card-tag" style="border-color:#449944;color:#449944">Xe Điện</div>
              <div class="a-card-title">Mercedes EQS 2025: Tầm Xa 800 km, Sang Bậc Nhất</div>
              <p class="a-card-excerpt">Pin 118 kWh, nội thất Hyperscreen 56 inch — xe điện sang trọng vượt trội.</p>
              <div class="a-card-meta"><span>03/03</span><div class="story-meta-dot"></div><span>5 ph đọc</span></div>
            </div>
          </a>
          <a href="#" class="a-card" style="text-decoration:none">
            <div class="a-card-img">
              <svg viewBox="0 0 340 160" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
                <rect width="340" height="160" fill="#1c1c1e"/>
                <radialGradient id="c3" cx="50%" cy="55%" r="55%"><stop offset="0%" stop-color="#1a1408"/><stop offset="100%" stop-color="#111"/></radialGradient>
                <rect width="340" height="160" fill="url(#c3)"/>
                <g transform="translate(24,20)">
                  <path d="M14,92 L36,50 L96,28 L182,24 L242,48 L262,80 L268,104 L268,114 L14,114 Z" fill="#1a1810" stroke="#cc9922" stroke-width="1.5"/>
                  <circle cx="68" cy="116" r="24" fill="#111" stroke="#cc9922" stroke-width="1.5"/>
                  <circle cx="212" cy="116" r="24" fill="#111" stroke="#cc9922" stroke-width="1.5"/>
                </g>
                <text x="170" y="148" text-anchor="middle" font-family="Rajdhani" font-size="8" letter-spacing="3" fill="#cc9922" opacity=".45">LAMBORGHINI URUS S</text>
              </svg>
            </div>
            <div class="a-card-body">
              <div class="a-card-tag" style="border-color:#cc9922;color:#cc9922">Đánh Giá</div>
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

        <a href="{{ route('news.show', 'cuoc-chien-xe-dien-2025') }}" class="mag-wide" style="text-decoration:none" data-anim>
          <div class="mag-wide-img">
            <svg viewBox="0 0 400 260" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" style="width:100%;height:100%">
              <rect width="400" height="260" fill="#0f0f0f"/>
              <radialGradient id="mw" cx="45%" cy="58%" r="60%"><stop offset="0%" stop-color="#0a0a1a"/><stop offset="100%" stop-color="#080808"/></radialGradient>
              <rect width="400" height="260" fill="url(#mw)"/>
              <g transform="translate(38,54)">
                <path d="M26,148 L48,90 L116,60 L218,54 L294,76 L318,116 L324,148 L324,172 L26,172 Z" fill="#12121c" stroke="#4466cc" stroke-width="1.5"/>
                <circle cx="86" cy="174" r="28" fill="#111" stroke="#4466cc" stroke-width="2"/>
                <circle cx="86" cy="174" r="14" fill="#0d0d0d" stroke="#2a2a3e" stroke-width="1.5"/>
                <circle cx="274" cy="174" r="28" fill="#111" stroke="#4466cc" stroke-width="2"/>
                <circle cx="274" cy="174" r="14" fill="#0d0d0d" stroke="#2a2a3e" stroke-width="1.5"/>
              </g>
              <text x="38" y="46" font-family="Barlow Condensed" font-size="32" font-weight="800" letter-spacing="2" fill="#4466cc" opacity=".07">EV BATTLE 2025</text>
              <text x="38" y="248" font-family="Rajdhani" font-size="9" letter-spacing="4" fill="#4466cc" opacity=".35">TESLA · BYD · VINFAST</text>
            </svg>
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
          <div class="video-card">
            <div class="video-thumb">
              <svg viewBox="0 0 400 160" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
                <rect width="400" height="160" fill="#0f0f0f"/>
                <radialGradient id="v1" cx="50%" cy="55%" r="55%"><stop offset="0%" stop-color="#1a0808"/><stop offset="100%" stop-color="#080808"/></radialGradient>
                <rect width="400" height="160" fill="url(#v1)"/>
                <g transform="translate(54,22)">
                  <path d="M26,108 L46,66 L102,44 L192,38 L250,58 L272,90 L278,116 L278,130 L26,130 Z" fill="#181818" stroke="#d42b2b" stroke-width="1.5"/>
                  <circle cx="84" cy="132" r="24" fill="#111" stroke="#d42b2b" stroke-width="2"/>
                  <circle cx="218" cy="132" r="24" fill="#111" stroke="#d42b2b" stroke-width="2"/>
                </g>
                <text x="200" y="150" text-anchor="middle" font-family="Rajdhani" font-size="8" letter-spacing="4" fill="#d42b2b" opacity=".3">BMW M4 TEST DRIVE</text>
              </svg>
              <div class="play-btn"><div class="play-icon"></div></div>
            </div>
            <div class="video-body">
              <div class="a-card-tag">Video</div>
              <div class="a-card-title">Test Drive BMW M4 2025: Cảm Giác Không Xe Nào Có Được</div>
              <div class="a-card-meta" style="margin-top:8px"><span>12/03</span><div class="story-meta-dot"></div><span>18:32</span></div>
            </div>
          </div>
          <div class="video-card">
            <div class="video-thumb">
              <svg viewBox="0 0 400 160" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
                <rect width="400" height="160" fill="#0d0d0d"/>
                <radialGradient id="v2" cx="50%" cy="55%" r="55%"><stop offset="0%" stop-color="#0a0a18"/><stop offset="100%" stop-color="#080808"/></radialGradient>
                <rect width="400" height="160" fill="url(#v2)"/>
                <g transform="translate(54,22)">
                  <path d="M24,110 L46,66 L108,42 L196,36 L258,58 L282,92 L288,118 L288,132 L24,132 Z" fill="#141420" stroke="#4466cc" stroke-width="1.5"/>
                  <circle cx="88" cy="134" r="24" fill="#111" stroke="#4466cc" stroke-width="2"/>
                  <circle cx="224" cy="134" r="24" fill="#111" stroke="#4466cc" stroke-width="2"/>
                </g>
                <text x="200" y="150" text-anchor="middle" font-family="Rajdhani" font-size="8" letter-spacing="4" fill="#4466cc" opacity=".4">TESLA vs BMW M4</text>
              </svg>
              <div class="play-btn"><div class="play-icon"></div></div>
            </div>
            <div class="video-body">
              <div class="a-card-tag" style="border-color:#4466cc;color:#4466cc">Video</div>
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
          <a href="#" class="a-card" style="text-decoration:none">
            <div class="a-card-img">
              <svg viewBox="0 0 340 160" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
                <rect width="340" height="160" fill="#131313"/>
                <g transform="translate(50,30)">
                  <rect x="0" y="38" width="32" height="58" fill="#d42b2b" opacity=".5"/>
                  <rect x="40" y="52" width="32" height="44" fill="#d42b2b" opacity=".38"/>
                  <rect x="80" y="24" width="32" height="72" fill="#d42b2b" opacity=".6"/>
                  <rect x="120" y="42" width="32" height="54" fill="#d42b2b" opacity=".45"/>
                  <rect x="160" y="12" width="32" height="84" fill="#d42b2b" opacity=".7"/>
                  <rect x="0" y="96" width="192" height="1" fill="#3a3a3e"/>
                </g>
                <text x="170" y="148" text-anchor="middle" font-family="Rajdhani" font-size="8" letter-spacing="3" fill="#555">DOANH SỐ Q1 2025</text>
              </svg>
            </div>
            <div class="a-card-body">
              <div class="a-card-tag">Thị Trường</div>
              <div class="a-card-title">Doanh Số Xe Sang Tăng Vọt 32% Trong Q1/2025</div>
              <div class="a-card-meta" style="margin-top:8px"><span>18/02</span><div class="story-meta-dot"></div><span>4 ph đọc</span></div>
            </div>
          </a>
          <a href="#" class="a-card" style="text-decoration:none">
            <div class="a-card-img">
              <svg viewBox="0 0 340 160" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
                <rect width="340" height="160" fill="#111"/>
                <g transform="translate(120,28)">
                  <circle cx="50" cy="52" r="44" fill="none" stroke="#d42b2b" stroke-width="1.5" opacity=".25"/>
                  <circle cx="50" cy="52" r="30" fill="none" stroke="#d42b2b" stroke-width="1.5" opacity=".4"/>
                  <circle cx="50" cy="52" r="14" fill="#d42b2b" opacity=".3"/>
                  <text x="50" y="57" text-anchor="middle" font-family="Barlow Condensed" font-size="18" font-weight="800" fill="#d42b2b" opacity=".75">50+</text>
                </g>
                <text x="170" y="148" text-anchor="middle" font-family="Rajdhani" font-size="8" letter-spacing="3" fill="#444">VIETNAM MOTOR SHOW</text>
              </svg>
            </div>
            <div class="a-card-body">
              <div class="a-card-tag">Sự Kiện</div>
              <div class="a-card-title">Vietnam Motor Show 2025: 50+ Mẫu Xe Ra Mắt</div>
              <div class="a-card-meta" style="margin-top:8px"><span>14/02</span><div class="story-meta-dot"></div><span>5 ph đọc</span></div>
            </div>
          </a>
          <a href="#" class="a-card" style="text-decoration:none">
            <div class="a-card-img">
              <svg viewBox="0 0 340 160" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
                <rect width="340" height="160" fill="#151515"/>
                <g transform="translate(128,28)">
                  <circle cx="42" cy="52" r="42" fill="none" stroke="#d42b2b" stroke-width="1.5" opacity=".22"/>
                  <circle cx="42" cy="52" r="28" fill="none" stroke="#d42b2b" stroke-width="1.5" opacity=".36"/>
                  <circle cx="42" cy="52" r="14" fill="#d42b2b" opacity=".28"/>
                  <text x="42" y="57" text-anchor="middle" font-family="Barlow Condensed" font-size="20" font-weight="800" fill="#d42b2b" opacity=".9">7</text>
                </g>
                <text x="170" y="148" text-anchor="middle" font-family="Rajdhani" font-size="8" letter-spacing="3" fill="#444">MẸO MUA XE</text>
              </svg>
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
          <div class="rank-item {{ $i === 0 ? 'top' : '' }}">
            <div class="rank-num">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</div>
            <div>
              <div class="rank-title">{{ $popular->title }}</div>
              <div class="rank-meta">{{ $popular->published_at->format('d/m') }} · {{ number_format($popular->views) }} lượt xem</div>
            </div>
          </div>
          @empty
          <div class="rank-item top">
            <div class="rank-num">01</div>
            <div><div class="rank-title">BMW M5 Hybrid 2025: 727 Mã Lực, Kỷ Lục Toàn Thời Đại</div><div class="rank-meta">15/03 · 7.2K LƯỢT XEM</div></div>
          </div>
          <div class="rank-item">
            <div class="rank-num">02</div>
            <div><div class="rank-title">Porsche 911 GT3 RS: Siêu Phẩm Đường Đua</div><div class="rank-meta">10/03 · 5.8K LƯỢT XEM</div></div>
          </div>
          <div class="rank-item">
            <div class="rank-num">03</div>
            <div><div class="rank-title">Tesla vs BYD: Ai Thắng Tại Việt Nam?</div><div class="rank-meta">08/03 · 5.1K LƯỢT XEM</div></div>
          </div>
          <div class="rank-item">
            <div class="rank-num">04</div>
            <div><div class="rank-title">Lamborghini Urus S: Đánh Giá Sau 1.000 km</div><div class="rank-meta">28/02 · 4.1K LƯỢT XEM</div></div>
          </div>
          <div class="rank-item">
            <div class="rank-num">05</div>
            <div><div class="rank-title">Vietnam Motor Show 2025 — Tất Cả Cần Biết</div><div class="rank-meta">14/02 · 3.6K LƯỢT XEM</div></div>
          </div>
          @endforelse
        </div>

        {{-- RECENT --}}
        <div class="sidebar-block" data-anim>
          <div class="sidebar-title">Tin Mới Nhất</div>
          @forelse($recentPosts ?? [] as $recent)
          <a href="{{ route('news.show', $recent->slug) }}" class="h-card" style="text-decoration:none;margin-bottom:2px;display:grid">
            <div class="h-card-img" style="aspect-ratio:1/1">
              @if($recent->thumbnail)
                <img src="{{ asset('storage/'.$recent->thumbnail) }}" alt="{{ $recent->title }}">
              @else
                <svg viewBox="0 0 80 80"><rect width="80" height="80" fill="#222224"/><circle cx="40" cy="40" r="22" fill="none" stroke="#d42b2b" stroke-width="1.5" opacity=".35"/></svg>
              @endif
            </div>
            <div class="h-card-body">
              <div class="h-card-title">{{ $recent->title }}</div>
              <div class="rank-meta">{{ $recent->published_at->format('d/m') }} · {{ $recent->read_time ?? 3 }} ph đọc</div>
            </div>
          </a>
          @empty
          <a href="#" class="h-card" style="text-decoration:none;margin-bottom:2px;display:grid">
            <div class="h-card-img" style="aspect-ratio:1/1"><svg viewBox="0 0 80 80"><rect width="80" height="80" fill="#222224"/><circle cx="40" cy="40" r="22" fill="none" stroke="#d42b2b" stroke-width="1.5" opacity=".4"/><text x="40" y="44" text-anchor="middle" font-family="Rajdhani" font-size="9" fill="#d42b2b" opacity=".6">AUDI</text></svg></div>
            <div class="h-card-body"><div class="h-card-title">Audi RS6 Avant 2025 về Việt Nam: Giá Từ 5,2 Tỷ</div><div class="rank-meta">01/03 · 3 ph đọc</div></div>
          </a>
          <a href="#" class="h-card" style="text-decoration:none;margin-bottom:2px;display:grid">
            <div class="h-card-img" style="aspect-ratio:1/1"><svg viewBox="0 0 80 80"><rect width="80" height="80" fill="#1c1c20"/><circle cx="40" cy="40" r="22" fill="none" stroke="#cc9922" stroke-width="1.5" opacity=".4"/><text x="40" y="44" text-anchor="middle" font-family="Rajdhani" font-size="8" fill="#cc9922" opacity=".6">BENTLEY</text></svg></div>
            <div class="h-card-body"><div class="h-card-title">Bentley Bentayga EWB: Sang Trọng Vô Đối Phân Khúc SUV</div><div class="rank-meta">27/02 · 4 ph đọc</div></div>
          </a>
          <a href="#" class="h-card" style="text-decoration:none;margin-bottom:0;display:grid">
            <div class="h-card-img" style="aspect-ratio:1/1"><svg viewBox="0 0 80 80"><rect width="80" height="80" fill="#1a1c1e"/><circle cx="40" cy="40" r="22" fill="none" stroke="#4466cc" stroke-width="1.5" opacity=".4"/><text x="40" y="44" text-anchor="middle" font-family="Rajdhani" font-size="8" fill="#4466cc" opacity=".6">TESLA</text></svg></div>
            <div class="h-card-body"><div class="h-card-title">Tesla Model 3 Highland: Bản Nâng Cấp Có Đáng Tiền?</div><div class="rank-meta">24/02 · 5 ph đọc</div></div>
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
              <a href="#" class="tag-c">BMW</a>
              <a href="#" class="tag-c">Mercedes</a>
              <a href="#" class="tag-c">Porsche</a>
              <a href="#" class="tag-c">Tesla</a>
              <a href="#" class="tag-c">Ferrari</a>
              <a href="#" class="tag-c">Xe Điện</a>
              <a href="#" class="tag-c">SUV</a>
              <a href="#" class="tag-c">Hybrid</a>
              <a href="#" class="tag-c">Đánh Giá</a>
              <a href="#" class="tag-c">Mẹo Hay</a>
              <a href="#" class="tag-c">Thị Trường</a>
              <a href="#" class="tag-c">Lamborghini</a>
              <a href="#" class="tag-c">Rolls-Royce</a>
              <a href="#" class="tag-c">Audi</a>
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
      <div class="stat-item" data-anim><div class="stat-num">128<sup>+</sup></div><div class="stat-label">Bài viết</div></div>
      <div class="stat-item" data-anim><div class="stat-num">30<sup>K</sup></div><div class="stat-label">Lượt đọc / tháng</div></div>
      <div class="stat-item" data-anim><div class="stat-num">6</div><div class="stat-label">Chuyên mục</div></div>
      <div class="stat-item" data-anim><div class="stat-num">4.9<sup>★</sup></div><div class="stat-label">Điểm đánh giá</div></div>
    </div>
  </div>
</div>

{{-- ─── CTA ─── --}}
<section style="background:var(--bg);padding:80px 0;position:relative;overflow:hidden;text-align:center">
  <div style="position:absolute;inset:0;background:radial-gradient(ellipse 70% 60% at 50% 110%,rgba(170,20,20,.18) 0%,transparent 70%)"></div>
  <div class="container" style="position:relative">
    <div class="section-label" style="justify-content:center;" data-anim>
      <div style="width:3px;height:14px;background:var(--red)"></div>
      Bạn đang tìm xe?
    </div>
    <h2 style="font-family:'Barlow Condensed',sans-serif;font-size:clamp(36px,5vw,62px);font-weight:800;text-transform:uppercase;color:var(--white);line-height:1;letter-spacing:-.5px;margin-top:8px" data-anim>
      Khám Phá <span style="color:var(--red)">Showroom</span><br/>Của Chúng Tôi
    </h2>
    <p style="color:var(--muted);max-width:440px;margin:18px auto 32px;font-size:14px;line-height:1.75" data-anim>
      Hơn 200 mẫu xe từ 30+ thương hiệu danh tiếng. Liên hệ ngay để được tư vấn miễn phí.
    </p>
    <div style="display:flex;gap:10px;justify-content:center" data-anim>
      <a href="{{ route('cars.index') }}" style="display:inline-flex;align-items:center;gap:10px;background:var(--red);color:#fff;font-family:'Rajdhani',sans-serif;font-size:12px;font-weight:700;letter-spacing:3px;text-transform:uppercase;padding:13px 28px;text-decoration:none;transition:background .2s,transform .15s" onmouseover="this.style.background='#b01e1e';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='var(--red)';this.style.transform='none'">Xem Xe Ngay &#8594;</a>
      <a href="#" style="display:inline-flex;align-items:center;gap:10px;background:transparent;color:var(--white);font-family:'Rajdhani',sans-serif;font-size:12px;font-weight:700;letter-spacing:3px;text-transform:uppercase;padding:12px 28px;text-decoration:none;border:1px solid var(--border-light);transition:border-color .2s,color .2s" onmouseover="this.style.borderColor='var(--red)';this.style.color='var(--red)'" onmouseout="this.style.borderColor='var(--border-light)';this.style.color='var(--white)'">Liên Hệ Ngay</a>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
  // Category filter
  document.querySelectorAll('.filter-tab').forEach(function(btn) {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.filter-tab').forEach(function(b) { b.classList.remove('active'); });
      this.classList.add('active');
    });
  });

  // Scroll animations
  const observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(e) {
      if (e.isIntersecting) e.target.classList.add('visible');
    });
  }, { threshold: 0.08 });
  document.querySelectorAll('[data-anim]').forEach(function(el) { observer.observe(el); });
</script>
@endpush