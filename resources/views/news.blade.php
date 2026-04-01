{{-- ============================================================
     resources/views/news.blade.php
     Trang Tin Tức — Concept Car Dealer
     ============================================================ --}}
@extends('layouts.app')

@section('title', 'Tin Tức — Concept Car Dealer')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Barlow+Condensed:wght@500;600;700&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{
  --red:#E8192C;--red-dark:#B01020;
  --black:#0d0d0d;--dark:#141414;--dark2:#1a1a1a;--dark3:#222;--dark4:#2a2a2a;
  --white:#f0ebe4;--muted:#888;--faint:#444;
}
body{background:var(--black);color:var(--white);font-family:'Barlow',sans-serif;overflow-x:hidden}
a{text-decoration:none;color:inherit}
img{display:block;width:100%}

/* ─── NAV ─── */
nav{height:68px;background:rgba(13,13,13,.97);border-bottom:1px solid #1c1c1c;display:flex;align-items:center;justify-content:space-between;padding:0 56px;position:sticky;top:0;z-index:100}
.logo{font-family:'Bebas Neue';font-size:24px;letter-spacing:2px}.logo em{color:var(--red);font-style:normal}
.nav-links{display:flex;gap:32px;list-style:none}
.nav-links a{font-size:11px;font-weight:600;letter-spacing:2.5px;text-transform:uppercase;color:#666;transition:color .2s}
.nav-links a:hover,.nav-links a.active{color:var(--white)}
.nav-links .active{border-bottom:2px solid var(--red);padding-bottom:2px}
.nav-login{background:var(--red);padding:9px 22px;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;border:none;cursor:pointer;color:var(--white);transition:background .2s}
.nav-login:hover{background:var(--red-dark)}
.nav-user{display:flex;align-items:center;gap:14px}
.nav-user-name{font-size:11px;color:#888;letter-spacing:1px}
.nav-logout{background:transparent;border:1px solid var(--faint);color:var(--faint);padding:8px 18px;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;cursor:pointer;transition:all .2s}
.nav-logout:hover{border-color:var(--red);color:var(--red)}

/* ─── PAGE HEADER ─── */
.page-header{background:var(--dark);border-bottom:1px solid #1c1c1c;padding:48px 56px 40px}
.ph-breadcrumb{font-size:11px;color:var(--faint);letter-spacing:1px;text-transform:uppercase;margin-bottom:16px}
.ph-breadcrumb span{color:var(--red)}
.ph-title{font-family:'Bebas Neue';font-size:clamp(52px,6vw,96px);letter-spacing:3px;line-height:.92;color:var(--white)}
.ph-title em{color:var(--red);font-style:normal}
.ph-meta{display:flex;align-items:center;gap:32px;margin-top:20px}
.ph-count{font-size:12px;color:var(--muted)}
.ph-cats{display:flex;gap:4px;flex-wrap:wrap}
.cat-pill{background:transparent;border:1px solid var(--dark4);color:#666;padding:6px 16px;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;cursor:pointer;transition:all .2s}
.cat-pill:hover,.cat-pill.on{background:var(--red);border-color:var(--red);color:var(--white)}

/* ─── LAYOUT ─── */
.wrap{max-width:1400px;margin:0 auto;padding:0 56px}

/* ─── HERO STORY ─── */
.hero-story{display:grid;grid-template-columns:1fr 400px;gap:2px;margin:2px 0}
.hs-main{position:relative;overflow:hidden;cursor:pointer;background:var(--dark2)}
.hs-main-img{aspect-ratio:16/9;object-fit:cover;transition:transform .7s ease}
.hs-main:hover .hs-main-img{transform:scale(1.03)}
.hs-main-body{padding:36px 40px}
.hs-side{display:flex;flex-direction:column;gap:2px}
.hs-side-item{flex:1;background:var(--dark2);cursor:pointer;overflow:hidden;position:relative;display:flex;flex-direction:column}
.hs-side-img{aspect-ratio:16/7;object-fit:cover;transition:transform .6s}
.hs-side-item:hover .hs-side-img{transform:scale(1.04)}
.hs-side-body{padding:20px 24px;flex:1}

/* tags / category labels */
.tag{display:inline-block;font-size:9px;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;padding:4px 10px;margin-bottom:10px}
.tag-red{background:var(--red);color:var(--white)}
.tag-line{color:var(--red);background:transparent;padding:0;border-left:2px solid var(--red);padding-left:10px;letter-spacing:2px}

.story-title-xl{font-family:'Bebas Neue';font-size:clamp(28px,3vw,48px);letter-spacing:1.5px;line-height:1;margin-bottom:14px;color:var(--white)}
.story-title-lg{font-family:'Barlow Condensed';font-size:clamp(18px,2vw,26px);font-weight:700;line-height:1.2;margin-bottom:10px;color:var(--white)}
.story-title-md{font-family:'Barlow Condensed';font-size:17px;font-weight:600;line-height:1.3;margin-bottom:8px;color:var(--white)}
.story-excerpt{font-size:14px;color:#888;line-height:1.7;font-weight:300;margin-bottom:16px}
.story-excerpt-sm{font-size:12px;color:#666;line-height:1.6;font-weight:300}
.story-meta{font-size:10px;color:var(--faint);letter-spacing:1px;text-transform:uppercase;display:flex;align-items:center;gap:12px}
.story-meta .dot{width:3px;height:3px;background:var(--faint);border-radius:50%;display:inline-block}
.read-more{font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--red);display:inline-flex;align-items:center;gap:6px;margin-top:12px;transition:gap .2s}
.read-more:hover{gap:10px}

/* ─── SECTION DIVIDER ─── */
.sec-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;padding-top:56px}
.sec-label{font-family:'Bebas Neue';font-size:28px;letter-spacing:2px;display:flex;align-items:center;gap:12px}
.sec-label::before{content:'';width:20px;height:3px;background:var(--red);display:inline-block}
.sec-link{font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--red);transition:opacity .2s}
.sec-link:hover{opacity:.7}

/* ─── 3-COL GRID ─── */
.grid3{display:grid;grid-template-columns:repeat(3,1fr);gap:2px}
.grid4{display:grid;grid-template-columns:repeat(4,1fr);gap:2px}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:2px}

.card{background:var(--dark2);overflow:hidden;cursor:pointer;transition:background .2s}
.card:hover{background:var(--dark3)}
.card-img{aspect-ratio:16/9;overflow:hidden}
.card-img-sq{aspect-ratio:1/1;overflow:hidden}
.card-img img,.card-img-sq img{width:100%;height:100%;object-fit:cover;transition:transform .55s}
.card:hover .card-img img,.card:hover .card-img-sq img{transform:scale(1.05)}
.card-body{padding:22px 26px 28px}
.card-body-sm{padding:16px 20px 20px}

/* ─── HORIZONTAL CARD ─── */
.hcard{display:grid;grid-template-columns:180px 1fr;background:var(--dark2);cursor:pointer;overflow:hidden;transition:background .2s}
.hcard:hover{background:var(--dark3)}
.hcard-img{aspect-ratio:4/3;overflow:hidden}
.hcard-img img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
.hcard:hover .hcard-img img{transform:scale(1.06)}
.hcard-body{padding:18px 22px;display:flex;flex-direction:column;justify-content:center}

/* ─── TICKER ─── */
.ticker-wrap{background:var(--red);overflow:hidden;height:36px;display:flex;align-items:center}
.ticker-label{background:var(--black);color:var(--white);font-size:10px;font-weight:700;letter-spacing:3px;text-transform:uppercase;padding:0 20px;height:100%;display:flex;align-items:center;flex-shrink:0}
.ticker-track{display:flex;animation:tick 28s linear infinite;white-space:nowrap}
.ticker-track:hover{animation-play-state:paused}
.ticker-item{font-size:11px;font-weight:600;letter-spacing:1px;padding:0 40px;color:var(--white);display:flex;align-items:center;gap:10px}
.ticker-item::after{content:'◆';font-size:6px;opacity:.6}
@keyframes tick{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}

/* ─── MAGAZINE FEATURE (wide card) ─── */
.mag-card{display:grid;grid-template-columns:55% 1fr;background:var(--dark2);cursor:pointer;overflow:hidden}
.mag-card-img{aspect-ratio:16/10;overflow:hidden}
.mag-card-img img{width:100%;height:100%;object-fit:cover;transition:transform .6s}
.mag-card:hover .mag-card-img img{transform:scale(1.04)}
.mag-card-body{padding:40px 44px;display:flex;flex-direction:column;justify-content:center;border-left:1px solid var(--dark4)}

/* ─── VIDEO CARD ─── */
.video-thumb{position:relative;cursor:pointer;overflow:hidden;background:var(--dark2)}
.video-thumb-img{aspect-ratio:16/9;overflow:hidden}
.video-thumb-img img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
.video-thumb:hover .video-thumb-img img{transform:scale(1.05)}
.play-btn{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:52px;height:52px;background:rgba(232,25,44,.9);border-radius:50%;display:flex;align-items:center;justify-content:center;transition:transform .2s}
.video-thumb:hover .play-btn{transform:translate(-50%,-50%) scale(1.1)}
.play-icon{width:0;height:0;border-top:9px solid transparent;border-bottom:9px solid transparent;border-left:16px solid white;margin-left:3px}
.video-body{padding:16px 20px}

/* ─── SIDEBAR ─── */
.sidebar-layout{display:grid;grid-template-columns:1fr 320px;gap:32px;align-items:start}
.sidebar-section{background:var(--dark2);padding:24px 28px}
.sidebar-title{font-family:'Bebas Neue';font-size:22px;letter-spacing:1.5px;border-bottom:2px solid var(--red);padding-bottom:12px;margin-bottom:16px}
.rank-item{display:flex;gap:14px;align-items:flex-start;padding:14px 0;border-bottom:1px solid var(--dark3);cursor:pointer}
.rank-item:last-child{border-bottom:none}
.rank-num{font-family:'Bebas Neue';font-size:32px;color:var(--dark4);line-height:1;flex-shrink:0;width:28px}
.rank-on .rank-num{color:var(--red)}
.rank-text{flex:1}
.rank-title{font-family:'Barlow Condensed';font-size:15px;font-weight:600;line-height:1.3;margin-bottom:4px}
.rank-meta{font-size:10px;color:var(--faint);letter-spacing:1px}
.tag-cloud{display:flex;flex-wrap:wrap;gap:6px;margin-top:8px}
.tag-c{font-size:10px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;padding:6px 14px;border:1px solid var(--dark4);color:#666;cursor:pointer;transition:all .2s}
.tag-c:hover{border-color:var(--red);color:var(--red)}

/* ─── NEWSLETTER STRIP ─── */
.nl-strip{background:var(--dark2);border-top:3px solid var(--red);padding:48px 56px;display:flex;align-items:center;justify-content:space-between;gap:40px;margin-top:2px}
.nl-left h3{font-family:'Bebas Neue';font-size:36px;letter-spacing:2px;margin-bottom:6px}
.nl-left p{font-size:13px;color:var(--muted);font-weight:300}
.nl-form{display:flex;gap:0;flex:1;max-width:480px}
.nl-input{flex:1;background:var(--black);border:1px solid var(--dark4);border-right:none;color:var(--white);padding:14px 20px;font-size:13px;font-family:'Barlow',sans-serif;outline:none}
.nl-input:focus{border-color:var(--red)}
.nl-input::placeholder{color:#444}
.nl-btn{background:var(--red);color:var(--white);border:none;padding:14px 28px;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;cursor:pointer;transition:background .2s;white-space:nowrap}
.nl-btn:hover{background:var(--red-dark)}

/* ─── FOOTER ─── */
footer{background:var(--dark);border-top:1px solid #1a1a1a;padding:56px 56px 36px}
.footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:48px;margin-bottom:40px}
.f-logo{font-family:'Bebas Neue';font-size:26px;letter-spacing:2px;margin-bottom:12px}
.f-logo em{color:var(--red);font-style:normal}
.f-desc{font-size:12px;color:#555;line-height:1.9;font-weight:300}
.f-head{font-size:10px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:#555;margin-bottom:16px}
.f-links{list-style:none;display:flex;flex-direction:column;gap:10px}
.f-links a{font-size:12px;color:#444;transition:color .2s}
.f-links a:hover{color:var(--white)}
.f-bottom{border-top:1px solid #1a1a1a;padding-top:24px;display:flex;justify-content:space-between;align-items:center}
.f-copy{font-size:11px;color:#333}

/* ─── MODAL (Login / Register) ─── */
.overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.88);z-index:500;align-items:center;justify-content:center;backdrop-filter:blur(6px)}
.overlay.open{display:flex}
.modal{background:var(--dark);width:100%;max-width:460px;position:relative;border-top:3px solid var(--red);animation:slideUp .3s ease}
@keyframes slideUp{from{transform:translateY(20px);opacity:0}to{transform:none;opacity:1}}
.modal-head{padding:28px 36px 20px;border-bottom:1px solid var(--dark3)}
.modal-tabs{display:flex;gap:28px}
.mtab{background:none;border:none;color:#555;font-size:10px;font-weight:700;letter-spacing:3px;text-transform:uppercase;cursor:pointer;padding-bottom:14px;border-bottom:2px solid transparent;transition:all .2s;font-family:'Barlow',sans-serif}
.mtab.on{color:var(--white);border-bottom-color:var(--red)}
.modal-body{padding:32px 36px}
.mcl{position:absolute;top:14px;right:18px;background:none;border:none;color:#444;font-size:20px;cursor:pointer;transition:color .2s;line-height:1}
.mcl:hover{color:var(--white)}
.fg{margin-bottom:18px}
.fl{display:block;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#555;margin-bottom:7px}
.fi{width:100%;background:var(--black);border:1px solid var(--dark4);color:var(--white);padding:13px 16px;font-size:13px;font-family:'Barlow',sans-serif;outline:none;transition:border-color .2s}
.fi:focus{border-color:var(--red)}
.fi::placeholder{color:#333}
.fbtn{width:100%;background:var(--red);color:var(--white);border:none;padding:15px;font-size:10px;font-weight:700;letter-spacing:3px;text-transform:uppercase;cursor:pointer;margin-top:6px;transition:background .2s;font-family:'Barlow',sans-serif}
.fbtn:hover{background:var(--red-dark)}
.fhint{text-align:center;font-size:11px;color:#444;margin-top:14px}
.fhint a{color:var(--red);cursor:pointer}
.frow{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.fdiv{border:none;border-top:1px solid var(--dark3);margin:20px 0}
.ferr{font-size:11px;color:var(--red);margin-top:6px;display:none}
.fsuccess{background:rgba(232,25,44,.08);border:1px solid rgba(232,25,44,.2);padding:14px 18px;font-size:13px;color:#ccc;margin-bottom:18px;display:none}
.fcheck{display:flex;align-items:flex-start;gap:10px;margin-bottom:20px}
.fcheck input{margin-top:3px;accent-color:var(--red)}
.fcheck label{font-size:12px;color:#555;cursor:pointer;line-height:1.5}
.fcheck a{color:var(--red)}
/* Validation error highlight */
.fi.is-invalid{border-color:var(--red)}
/* Session alert */
.alert-danger{background:rgba(232,25,44,.1);border:1px solid rgba(232,25,44,.3);color:#f0ebe4;padding:12px 16px;font-size:13px;margin-bottom:16px}

@media(max-width:1100px){
  .grid3{grid-template-columns:1fr 1fr}
  .grid4{grid-template-columns:1fr 1fr}
  .hero-story{grid-template-columns:1fr}
  .sidebar-layout{grid-template-columns:1fr}
  .mag-card{grid-template-columns:1fr}
}
@media(max-width:700px){
  nav,.page-header,.wrap,footer,.nl-strip{padding-left:20px;padding-right:20px}
  .grid2,.grid3,.grid4{grid-template-columns:1fr}
  .nl-strip{flex-direction:column}
  .footer-grid{grid-template-columns:1fr 1fr}
  .hcard{grid-template-columns:120px 1fr}
}
</style>
@endpush

@section('content')

{{-- ─── NAV ─── --}}
<nav>
  <a href="{{ url('/') }}" class="logo"><em>Concept</em> Car Dealer</a>
  <ul class="nav-links">
    <li><a href="{{ url('/') }}">HOME</a></li>
    <li><a href="{{ url('/cars') }}">CARS</a></li>
    <li><a href="{{ route('news.index') }}" class="active">TIN TỨC</a></li>
    <li><a href="{{ url('/contact') }}">LIÊN HỆ</a></li>
  </ul>

  {{-- Nút login/logout tùy trạng thái đăng nhập --}}
  @auth
    <div class="nav-user">
      <span class="nav-user-name">{{ Auth::user()->name }}</span>
      <form method="POST" action="{{ route('logout') }}" style="margin:0">
        @csrf
        <button type="submit" class="nav-logout">ĐĂNG XUẤT</button>
      </form>
    </div>
  @else
    <button class="nav-login" onclick="openLogin()">ĐĂNG NHẬP</button>
  @endauth
</nav>

{{-- ─── TICKER ─── --}}
<div class="ticker-wrap">
  <div class="ticker-label">BREAKING</div>
  <div class="ticker-track" id="ticker">
    <div class="ticker-item">BMW M5 Hybrid 2025 chính thức ra mắt – 727 mã lực kỷ lục</div>
    <div class="ticker-item">Porsche 911 GT3 RS lập kỷ lục Nürburgring mới 6:49</div>
    <div class="ticker-item">Doanh số xe sang Việt Nam tăng 32% Quý 1/2025</div>
    <div class="ticker-item">Tesla Model S Plaid – 0–100 km/h chỉ 2.1 giây</div>
    <div class="ticker-item">Vietnam Motor Show 2025: Hơn 50 mẫu xe ra mắt</div>
    <div class="ticker-item">Mercedes EQS 2025 tầm xa 800 km chính thức về VN</div>
    {{-- Duplicate for seamless loop --}}
    <div class="ticker-item">BMW M5 Hybrid 2025 chính thức ra mắt – 727 mã lực kỷ lục</div>
    <div class="ticker-item">Porsche 911 GT3 RS lập kỷ lục Nürburgring mới 6:49</div>
    <div class="ticker-item">Doanh số xe sang Việt Nam tăng 32% Quý 1/2025</div>
    <div class="ticker-item">Tesla Model S Plaid – 0–100 km/h chỉ 2.1 giây</div>
    <div class="ticker-item">Vietnam Motor Show 2025: Hơn 50 mẫu xe ra mắt</div>
    <div class="ticker-item">Mercedes EQS 2025 tầm xa 800 km chính thức về VN</div>
  </div>
</div>

{{-- ─── PAGE HEADER ─── --}}
<div class="page-header">
  <div class="ph-breadcrumb">
    <a href="{{ url('/') }}">Home</a> <span>›</span> Tin Tức
  </div>
  <h1 class="ph-title">TIN TỨC<br><em>XE HƠI</em></h1>
  <div class="ph-meta">
    <span class="ph-count">{{ $totalPosts ?? 128 }} bài viết</span>
    <div class="ph-cats">
      <button class="cat-pill on" data-cat="">Tất Cả</button>
      <button class="cat-pill" data-cat="ra-mat-moi">Ra Mắt Mới</button>
      <button class="cat-pill" data-cat="danh-gia">Đánh Giá</button>
      <button class="cat-pill" data-cat="xu-huong">Xu Hướng</button>
      <button class="cat-pill" data-cat="cong-nghe">Công Nghệ</button>
      <button class="cat-pill" data-cat="thi-truong">Thị Trường</button>
    </div>
  </div>
</div>

{{-- ─── HERO STORIES ─── --}}
<div style="background:var(--dark2)">
  <div class="hero-story">
    <div class="hs-main">
      <div style="background:var(--dark3);overflow:hidden">
        <svg viewBox="0 0 740 416" width="100%" xmlns="http://www.w3.org/2000/svg" style="display:block;aspect-ratio:16/9">
          <rect width="740" height="416" fill="#101010"/>
          <radialGradient id="gMain" cx="45%" cy="55%" r="60%"><stop offset="0%" stop-color="#1a0808"/><stop offset="100%" stop-color="#080808"/></radialGradient>
          <rect width="740" height="416" fill="url(#gMain)"/>
          <g transform="translate(70,100)">
            <path d="M50,215 L88,135 L190,88 L360,80 L480,105 L560,162 L576,215 L576,252 L50,252 Z" fill="#1c1c1c" stroke="#E8192C" stroke-width="2.5"/>
            <path d="M190,88 L240,58 L360,80" fill="none" stroke="#E8192C" stroke-width="1.2" opacity=".3"/>
            <path d="M480,105 L540,75 L560,95" fill="none" stroke="#E8192C" stroke-width="1.2" opacity=".3"/>
            <circle cx="155" cy="255" r="40" fill="#111" stroke="#E8192C" stroke-width="3"/>
            <circle cx="155" cy="255" r="20" fill="#0d0d0d" stroke="#2a2a2a" stroke-width="2"/>
            <circle cx="455" cy="255" r="40" fill="#111" stroke="#E8192C" stroke-width="3"/>
            <circle cx="455" cy="255" r="20" fill="#0d0d0d" stroke="#2a2a2a" stroke-width="2"/>
          </g>
          <text x="60" y="110" font-family="Bebas Neue" font-size="72" letter-spacing="4" fill="#E8192C" opacity=".08">BMW M5</text>
          <text x="60" y="400" font-family="Bebas Neue" font-size="14" letter-spacing="8" fill="#E8192C" opacity=".5">CONCEPT CAR DEALER EXCLUSIVE</text>
        </svg>
        <div style="position:absolute;top:16px;left:16px"><span class="tag tag-red">COVER STORY</span></div>
      </div>
      <div class="hs-main-body" style="background:var(--dark2)">
        <div class="tag tag-line">Ra Mắt Mới</div>
        <h2 class="story-title-xl">BMW M5 Hybrid 2025:<br>Cuộc Cách Mạng<br>727 Mã Lực</h2>
        <p class="story-excerpt">BMW chính thức công bố thế hệ M5 hoàn toàn mới tích hợp hệ thống hybrid plug-in, tổng công suất lên đến 727 mã lực. Khả năng tăng tốc 0–100 km/h chỉ còn 3.5 giây.</p>
        <div class="story-meta">
          <span>15 THÁNG 3, 2025</span><span class="dot"></span>
          <span>MINH KHOA</span><span class="dot"></span>
          <span>7 PHÚT ĐỌC</span>
        </div>
        <a href="{{ route('news.show', 'bmw-m5-hybrid-2025') }}" class="read-more">ĐỌC BÀI VIẾT &#8594;</a>
      </div>
    </div>
    <div class="hs-side">
      <div class="hs-side-item">
        <div style="background:var(--dark3);overflow:hidden">
          <svg viewBox="0 0 400 200" width="100%" xmlns="http://www.w3.org/2000/svg" style="display:block;aspect-ratio:16/7">
            <rect width="400" height="200" fill="#161616"/>
            <radialGradient id="g1" cx="50%" cy="50%" r="50%"><stop offset="0%" stop-color="#1f0a0a"/><stop offset="100%" stop-color="#0d0d0d"/></radialGradient>
            <rect width="400" height="200" fill="url(#g1)"/>
            <g transform="translate(30,40)">
              <path d="M30,110 C30,110 48,72 88,54 L138,36 L248,33 L308,54 L338,82 L348,110 L348,130 L30,130 Z" fill="#1c1c1c" stroke="#E8192C" stroke-width="1.5"/>
              <circle cx="98" cy="132" r="26" fill="#111" stroke="#E8192C" stroke-width="2"/>
              <circle cx="278" cy="132" r="26" fill="#111" stroke="#E8192C" stroke-width="2"/>
            </g>
            <text x="200" y="170" text-anchor="middle" font-family="Bebas Neue" font-size="11" letter-spacing="4" fill="#E8192C" opacity=".4">PORSCHE 911 GT3 RS</text>
          </svg>
        </div>
        <div class="hs-side-body" style="background:var(--dark2)">
          <div class="tag tag-line" style="font-size:9px;margin-bottom:8px">Đánh Giá</div>
          <div class="story-title-md">Porsche 911 GT3 RS: Đường Đua Thu Nhỏ Cho Phố</div>
          <div class="story-meta" style="margin-top:8px"><span>10 TH3, 2025</span><span class="dot"></span><span>5 ph đọc</span></div>
        </div>
      </div>
      <div class="hs-side-item">
        <div style="background:var(--dark3);overflow:hidden">
          <svg viewBox="0 0 400 200" width="100%" xmlns="http://www.w3.org/2000/svg" style="display:block;aspect-ratio:16/7">
            <rect width="400" height="200" fill="#141414"/>
            <radialGradient id="g2" cx="40%" cy="60%" r="50%"><stop offset="0%" stop-color="#0a0a1f"/><stop offset="100%" stop-color="#0d0d0d"/></radialGradient>
            <rect width="400" height="200" fill="url(#g2)"/>
            <g transform="translate(30,40)">
              <path d="M25,115 C25,115 44,68 92,46 L148,28 L240,25 L316,50 L344,85 L352,115 L352,132 L25,132 Z" fill="#1a1a2a" stroke="#4466cc" stroke-width="1.5"/>
              <circle cx="95" cy="134" r="27" fill="#111" stroke="#4466cc" stroke-width="2"/>
              <circle cx="280" cy="134" r="27" fill="#111" stroke="#4466cc" stroke-width="2"/>
            </g>
            <text x="200" y="170" text-anchor="middle" font-family="Bebas Neue" font-size="11" letter-spacing="4" fill="#4466cc" opacity=".5">TESLA MODEL S PLAID</text>
          </svg>
        </div>
        <div class="hs-side-body" style="background:var(--dark2)">
          <div class="tag tag-line" style="font-size:9px;margin-bottom:8px">Công Nghệ</div>
          <div class="story-title-md">Tesla Model S Plaid: Xe Điện Nhanh Nhất Thế Giới 2025</div>
          <div class="story-meta" style="margin-top:8px"><span>7 TH3, 2025</span><span class="dot"></span><span>4 ph đọc</span></div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ─── MAIN CONTENT AREA ─── --}}
<div class="wrap" style="padding-top:0">

  <div class="sec-head">
    <div class="sec-label">Tin Mới Nhất</div>
    <a href="{{ route('news.index') }}" class="sec-link">XEM TẤT CẢ &#8594;</a>
  </div>

  <div class="sidebar-layout">
    {{-- Left: articles --}}
    <div>
      <div class="grid3" style="margin-bottom:2px">
        @forelse($latestNews ?? [] as $post)
        <div class="card">
          <div class="card-img">
            @if($post->thumbnail)
              <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}">
            @else
              <svg viewBox="0 0 400 225" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <rect width="400" height="225" fill="#181818"/>
                <text x="200" y="120" text-anchor="middle" font-family="Bebas Neue" font-size="18" letter-spacing="2" fill="#333">{{ strtoupper($post->title) }}</text>
              </svg>
            @endif
          </div>
          <div class="card-body">
            <div class="tag tag-line" style="font-size:9px;margin-bottom:8px">{{ $post->category->name ?? 'Tin Tức' }}</div>
            <div class="story-title-md">{{ $post->title }}</div>
            <p class="story-excerpt-sm" style="margin:8px 0 12px">{{ Str::limit($post->excerpt, 100) }}</p>
            <div class="story-meta">
              <span>{{ $post->published_at->format('d TH') }}</span>
              <span class="dot"></span>
              <span>{{ $post->read_time ?? 5 }} ph</span>
            </div>
          </div>
        </div>
        @empty
        {{-- Fallback: static cards khi chưa có dữ liệu --}}
        <div class="card">
          <div class="card-img">
            <svg viewBox="0 0 400 225" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><rect width="400" height="225" fill="#181818"/><radialGradient id="ga" cx="50%" cy="50%" r="50%"><stop offset="0%" stop-color="#1a0808"/><stop offset="100%" stop-color="#101010"/></radialGradient><rect width="400" height="225" fill="url(#ga)"/><g transform="translate(20,50)"><path d="M28,108 L52,68 L112,44 L224,40 L292,62 L318,95 L326,122 L326,140 L28,140 Z" fill="#1c1c1c" stroke="#E8192C" stroke-width="1.5"/><circle cx="86" cy="142" r="28" fill="#111" stroke="#E8192C" stroke-width="2"/><circle cx="264" cy="142" r="28" fill="#111" stroke="#E8192C" stroke-width="2"/></g><text x="200" y="200" text-anchor="middle" font-family="Bebas Neue" font-size="10" letter-spacing="3" fill="#E8192C" opacity=".35">FERRARI SF90 XX</text></svg>
          </div>
          <div class="card-body">
            <div class="tag tag-line" style="font-size:9px;margin-bottom:8px">Ra Mắt Mới</div>
            <div class="story-title-md">Ferrari SF90 XX Stradale: Gần 1.000 HP Cho Đường Phố</div>
            <p class="story-excerpt-sm" style="margin:8px 0 12px">Siêu xe hybrid mạnh nhất Ferrari, tăng tốc 0-100 chỉ 2.3 giây, giới hạn 799 chiếc toàn cầu.</p>
            <div class="story-meta"><span>5 TH3</span><span class="dot"></span><span>6 ph</span></div>
          </div>
        </div>
        <div class="card">
          <div class="card-img">
            <svg viewBox="0 0 400 225" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><rect width="400" height="225" fill="#141414"/><radialGradient id="gb" cx="50%" cy="50%" r="50%"><stop offset="0%" stop-color="#0a1a0a"/><stop offset="100%" stop-color="#0e0e0e"/></radialGradient><rect width="400" height="225" fill="url(#gb)"/><g transform="translate(20,50)"><path d="M22,110 L48,66 L120,38 L228,34 L300,60 L326,98 L334,125 L334,142 L22,142 Z" fill="#181c18" stroke="#336633" stroke-width="1.5"/><circle cx="90" cy="144" r="28" fill="#111" stroke="#336633" stroke-width="2"/><circle cx="268" cy="144" r="28" fill="#111" stroke="#336633" stroke-width="2"/></g><text x="200" y="200" text-anchor="middle" font-family="Bebas Neue" font-size="10" letter-spacing="3" fill="#449944" opacity=".5">MERCEDES EQS 2025</text></svg>
          </div>
          <div class="card-body">
            <div class="tag tag-line" style="font-size:9px;margin-bottom:8px;border-color:#449944;color:#449944">Xe Điện</div>
            <div class="story-title-md">Mercedes EQS 2025: Tầm Xa 800 km, Sang Trọng Bậc Nhất</div>
            <p class="story-excerpt-sm" style="margin:8px 0 12px">EQS thế hệ mới phá vỡ rào cản tầm xa với pin 118 kWh, nội thất Hyperscreen 56 inch.</p>
            <div class="story-meta"><span>3 TH3</span><span class="dot"></span><span>5 ph</span></div>
          </div>
        </div>
        <div class="card">
          <div class="card-img">
            <svg viewBox="0 0 400 225" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><rect width="400" height="225" fill="#161616"/><radialGradient id="gc" cx="50%" cy="50%" r="50%"><stop offset="0%" stop-color="#1a1408"/><stop offset="100%" stop-color="#101010"/></radialGradient><rect width="400" height="225" fill="url(#gc)"/><g transform="translate(20,48)"><path d="M18,112 L46,64 L124,36 L232,32 L306,58 L330,100 L336,128 L336,145 L18,145 Z" fill="#1a1810" stroke="#cc9922" stroke-width="1.5"/><circle cx="88" cy="147" r="30" fill="#111" stroke="#cc9922" stroke-width="2"/><circle cx="270" cy="147" r="30" fill="#111" stroke="#cc9922" stroke-width="2"/></g><text x="200" y="200" text-anchor="middle" font-family="Bebas Neue" font-size="10" letter-spacing="3" fill="#cc9922" opacity=".5">LAMBORGHINI URUS S</text></svg>
          </div>
          <div class="card-body">
            <div class="tag tag-line" style="font-size:9px;margin-bottom:8px;border-color:#cc9922;color:#cc9922">Đánh Giá</div>
            <div class="story-title-md">Lamborghini Urus S: SUV Siêu Xe Tốt Nhất 2025?</div>
            <p class="story-excerpt-sm" style="margin:8px 0 12px">Chúng tôi trải nghiệm Urus S trên đường phố và đường đua — kết quả khiến cả đội bất ngờ.</p>
            <div class="story-meta"><span>28 TH2</span><span class="dot"></span><span>8 ph</span></div>
          </div>
        </div>
        @endforelse
      </div>

      {{-- Magazine Feature --}}
      <div class="sec-head" style="padding-top:40px">
        <div class="sec-label">Bài Phân Tích</div>
      </div>
      <div class="mag-card" style="margin-bottom:2px">
        <div class="mag-card-img">
          <svg viewBox="0 0 700 430" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" style="display:block;width:100%;height:100%">
            <rect width="700" height="430" fill="#111"/>
            <radialGradient id="gm" cx="40%" cy="55%" r="60%"><stop offset="0%" stop-color="#1a0505"/><stop offset="100%" stop-color="#080808"/></radialGradient>
            <rect width="700" height="430" fill="url(#gm)"/>
            <g transform="translate(60,100)">
              <path d="M40,200 L75,125 L155,85 L290,78 L400,82 L490,115 L530,175 L540,220 L540,260 L40,260 Z" fill="#1a1a1a" stroke="#E8192C" stroke-width="2.5"/>
              <circle cx="140" cy="263" r="44" fill="#111" stroke="#E8192C" stroke-width="3"/>
              <circle cx="140" cy="263" r="22" fill="#0d0d0d" stroke="#2a2a2a" stroke-width="2"/>
              <circle cx="440" cy="263" r="44" fill="#111" stroke="#E8192C" stroke-width="3"/>
              <circle cx="440" cy="263" r="22" fill="#0d0d0d" stroke="#2a2a2a" stroke-width="2"/>
            </g>
          </svg>
        </div>
        <div class="mag-card-body">
          <span class="tag tag-red" style="margin-bottom:16px">PHÂN TÍCH SÂU</span>
          <h2 class="story-title-lg" style="font-size:28px;margin-bottom:16px;line-height:1.15">Cuộc Chiến Xe Điện 2025:<br>Tesla, BYD, Và Ai Sẽ Thắng Tại Việt Nam?</h2>
          <p class="story-excerpt">Thị trường xe điện Việt Nam đang bước vào giai đoạn bùng nổ thực sự. Chúng tôi phân tích chiến lược, ưu thế và điểm yếu từng hãng.</p>
          <div class="story-meta" style="margin-bottom:16px">
            <span>22 TH2, 2025</span><span class="dot"></span>
            <span>THANH TÙNG</span><span class="dot"></span>
            <span>12 PHÚT ĐỌC</span>
          </div>
          <a href="{{ route('news.show', 'cuoc-chien-xe-dien-2025') }}" class="read-more">ĐỌC BÀI VIẾT &#8594;</a>
        </div>
      </div>

      {{-- More articles --}}
      <div class="sec-head" style="padding-top:40px">
        <div class="sec-label">Thị Trường & Xu Hướng</div>
        <a href="{{ route('news.index', ['category' => 'thi-truong']) }}" class="sec-link">XEM THÊM &#8594;</a>
      </div>
      <div class="grid3" style="margin-bottom:2px">
        <div class="card">
          <div class="card-img">
            <svg viewBox="0 0 400 225" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><rect width="400" height="225" fill="#131313"/><text x="200" y="90" text-anchor="middle" font-family="Bebas Neue" font-size="32" letter-spacing="2" fill="#1f1f1f">THỊ TRƯỜNG</text><rect x="60" y="100" width="280" height="60" rx="2" fill="#1a1a1a" stroke="#555" stroke-width="1"/><rect x="60" y="100" width="196" height="60" fill="var(--red)" opacity=".7"/><text x="200" y="186" text-anchor="middle" font-family="Bebas Neue" font-size="10" letter-spacing="3" fill="#444">DOANH SỐ Q1 2025</text></svg>
          </div>
          <div class="card-body">
            <div class="tag tag-line" style="font-size:9px;margin-bottom:8px">Thị Trường</div>
            <div class="story-title-md">Doanh Số Xe Sang Tăng Vọt 32% Trong Quý 1/2025</div>
            <div class="story-meta" style="margin-top:10px"><span>18 TH2</span><span class="dot"></span><span>4 ph</span></div>
          </div>
        </div>
        <div class="card">
          <div class="card-img">
            <svg viewBox="0 0 400 225" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><rect width="400" height="225" fill="#111"/><text x="200" y="80" text-anchor="middle" font-family="Bebas Neue" font-size="28" letter-spacing="2" fill="#1c1c1c">MOTOR SHOW</text><g transform="translate(80,95)"><rect x="0" y="30" width="40" height="70" fill="#E8192C" opacity=".6"/><rect x="50" y="50" width="40" height="50" fill="#E8192C" opacity=".4"/><rect x="100" y="20" width="40" height="80" fill="#E8192C" opacity=".7"/><rect x="150" y="40" width="40" height="60" fill="#E8192C" opacity=".5"/><rect x="200" y="10" width="40" height="90" fill="#E8192C" opacity=".8"/></g><text x="200" y="190" text-anchor="middle" font-family="Bebas Neue" font-size="10" letter-spacing="3" fill="#444">VIETNAM MOTOR SHOW</text></svg>
          </div>
          <div class="card-body">
            <div class="tag tag-line" style="font-size:9px;margin-bottom:8px">Sự Kiện</div>
            <div class="story-title-md">Vietnam Motor Show 2025: 50+ Mẫu Xe Ra Mắt</div>
            <div class="story-meta" style="margin-top:10px"><span>14 TH2</span><span class="dot"></span><span>5 ph</span></div>
          </div>
        </div>
        <div class="card">
          <div class="card-img">
            <svg viewBox="0 0 400 225" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><rect width="400" height="225" fill="#151515"/><g transform="translate(140,95)"><circle cx="60" cy="60" r="55" fill="none" stroke="#E8192C" stroke-width="2" opacity=".3"/><circle cx="60" cy="60" r="38" fill="none" stroke="#E8192C" stroke-width="2" opacity=".5"/><circle cx="60" cy="60" r="20" fill="#E8192C" opacity=".4"/><text x="60" y="65" text-anchor="middle" font-family="Bebas Neue" font-size="16" fill="#E8192C">7</text></g><text x="200" y="192" text-anchor="middle" font-family="Bebas Neue" font-size="10" letter-spacing="3" fill="#444">MẸO HAY</text></svg>
          </div>
          <div class="card-body">
            <div class="tag tag-line" style="font-size:9px;margin-bottom:8px">Mẹo Hay</div>
            <div class="story-title-md">7 Điều Bắt Buộc Kiểm Tra Trước Khi Ký Hợp Đồng Mua Xe</div>
            <div class="story-meta" style="margin-top:10px"><span>10 TH2</span><span class="dot"></span><span>6 ph</span></div>
          </div>
        </div>
      </div>

      {{-- Video Section --}}
      <div class="sec-head" style="padding-top:40px">
        <div class="sec-label">Video Nổi Bật</div>
      </div>
      <div class="grid2" style="margin-bottom:56px">
        <div class="video-thumb">
          <div class="video-thumb-img">
            <svg viewBox="0 0 480 270" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><rect width="480" height="270" fill="#0f0f0f"/><radialGradient id="gv1" cx="50%" cy="50%" r="50%"><stop offset="0%" stop-color="#1a0808"/><stop offset="100%" stop-color="#080808"/></radialGradient><rect width="480" height="270" fill="url(#gv1)"/><g transform="translate(60,55)"><path d="M35,145 L62,90 L135,58 L244,52 L326,76 L360,118 L368,150 L368,172 L35,172 Z" fill="#181818" stroke="#E8192C" stroke-width="2"/><circle cx="110" cy="174" r="34" fill="#111" stroke="#E8192C" stroke-width="2.5"/><circle cx="290" cy="174" r="34" fill="#111" stroke="#E8192C" stroke-width="2.5"/></g><text x="240" y="240" text-anchor="middle" font-family="Bebas Neue" font-size="11" letter-spacing="4" fill="#E8192C" opacity=".4">TEST DRIVE BMW M4</text></svg>
          </div>
          <div class="play-btn"><div class="play-icon"></div></div>
          <div class="video-body" style="background:var(--dark2)">
            <div class="tag tag-line" style="font-size:9px;margin-bottom:6px">Video</div>
            <div class="story-title-md">Test Drive BMW M4 2025: Cảm Giác Không Xe Nào Có Được</div>
            <div class="story-meta" style="margin-top:8px"><span>12 TH3</span><span class="dot"></span><span>18:32</span></div>
          </div>
        </div>
        <div class="video-thumb">
          <div class="video-thumb-img">
            <svg viewBox="0 0 480 270" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><rect width="480" height="270" fill="#0d0d0d"/><radialGradient id="gv2" cx="50%" cy="50%" r="50%"><stop offset="0%" stop-color="#0a0a18"/><stop offset="100%" stop-color="#080808"/></radialGradient><rect width="480" height="270" fill="url(#gv2)"/><g transform="translate(60,55)"><path d="M30,148 L58,88 L138,54 L250,48 L332,74 L364,120 L372,152 L372,174 L30,174 Z" fill="#141420" stroke="#4466cc" stroke-width="2"/><circle cx="112" cy="176" r="34" fill="#111" stroke="#4466cc" stroke-width="2.5"/><circle cx="292" cy="176" r="34" fill="#111" stroke="#4466cc" stroke-width="2.5"/></g><text x="240" y="240" text-anchor="middle" font-family="Bebas Neue" font-size="11" letter-spacing="4" fill="#4466cc" opacity=".5">TESLA MODEL S PLAID</text></svg>
          </div>
          <div class="play-btn"><div class="play-icon"></div></div>
          <div class="video-body" style="background:var(--dark2)">
            <div class="tag tag-line" style="font-size:9px;margin-bottom:6px;border-color:#4466cc;color:#4466cc">Video</div>
            <div class="story-title-md">Tesla vs BMW: Xe Điện Hay Xăng — Cuộc Đua 400m</div>
            <div class="story-meta" style="margin-top:8px"><span>5 TH3</span><span class="dot"></span><span>12:47</span></div>
          </div>
        </div>
      </div>
    </div>

    {{-- Right Sidebar --}}
    <div>
      <div class="sidebar-section" style="margin-bottom:2px">
        <div class="sidebar-title">ĐỌC NHIỀU NHẤT</div>
        @forelse($popularPosts ?? [] as $i => $popular)
        <div class="rank-item {{ $i === 0 ? 'rank-on' : '' }}">
          <div class="rank-num">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</div>
          <div class="rank-text">
            <div class="rank-title">{{ $popular->title }}</div>
            <div class="rank-meta">{{ $popular->published_at->format('d TH') }} · {{ number_format($popular->views) }} LƯỢT XEM</div>
          </div>
        </div>
        @empty
        <div class="rank-item rank-on">
          <div class="rank-num">01</div>
          <div class="rank-text">
            <div class="rank-title">BMW M5 Hybrid 2025: 727 Mã Lực, Kỷ Lục Toàn Thời Đại</div>
            <div class="rank-meta">15 TH3 · 7.2K LƯỢT XEM</div>
          </div>
        </div>
        <div class="rank-item">
          <div class="rank-num">02</div>
          <div class="rank-text">
            <div class="rank-title">Porsche 911 GT3 RS: Siêu Phẩm Đường Đua</div>
            <div class="rank-meta">10 TH3 · 5.8K LƯỢT XEM</div>
          </div>
        </div>
        <div class="rank-item">
          <div class="rank-num">03</div>
          <div class="rank-text">
            <div class="rank-title">Tesla vs BYD: Ai Thắng Tại Việt Nam?</div>
            <div class="rank-meta">8 TH3 · 5.1K LƯỢT XEM</div>
          </div>
        </div>
        <div class="rank-item">
          <div class="rank-num">04</div>
          <div class="rank-text">
            <div class="rank-title">Lamborghini Urus S: Đánh Giá Sau 1000 km</div>
            <div class="rank-meta">28 TH2 · 4.1K LƯỢT XEM</div>
          </div>
        </div>
        <div class="rank-item">
          <div class="rank-num">05</div>
          <div class="rank-text">
            <div class="rank-title">Vietnam Motor Show 2025 — Tất Cả Những Gì Cần Biết</div>
            <div class="rank-meta">14 TH2 · 3.6K LƯỢT XEM</div>
          </div>
        </div>
        @endforelse
      </div>

      <div class="sidebar-section" style="margin-bottom:2px">
        <div class="sidebar-title">TIN MỚI NHẤT</div>
        @forelse($recentPosts ?? [] as $recent)
        <a href="{{ route('news.show', $recent->slug) }}" class="hcard" style="margin-bottom:2px;grid-template-columns:100px 1fr;display:grid">
          <div class="hcard-img" style="aspect-ratio:1/1">
            @if($recent->thumbnail)
              <img src="{{ asset('storage/' . $recent->thumbnail) }}" alt="{{ $recent->title }}">
            @else
              <svg viewBox="0 0 100 100" width="100%" height="100%"><rect width="100" height="100" fill="#181818"/><circle cx="50" cy="50" r="30" fill="none" stroke="#E8192C" stroke-width="2" opacity=".4"/></svg>
            @endif
          </div>
          <div class="hcard-body">
            <div class="rank-title" style="font-size:13px">{{ $recent->title }}</div>
            <div class="rank-meta" style="margin-top:6px">{{ $recent->published_at->format('d TH') }} · {{ $recent->read_time ?? 3 }} ph đọc</div>
          </div>
        </a>
        @empty
        <div class="hcard" style="margin-bottom:2px;grid-template-columns:100px 1fr">
          <div class="hcard-img" style="aspect-ratio:1/1"><svg viewBox="0 0 100 100" width="100%" height="100%"><rect width="100" height="100" fill="#181818"/><circle cx="50" cy="50" r="30" fill="none" stroke="#E8192C" stroke-width="2" opacity=".4"/><text x="50" y="54" text-anchor="middle" font-family="Bebas Neue" font-size="10" fill="#E8192C" opacity=".6">AUDI</text></svg></div>
          <div class="hcard-body">
            <div class="rank-title" style="font-size:13px">Audi RS6 Avant 2025 về Việt Nam: Giá Từ 5,2 Tỷ</div>
            <div class="rank-meta" style="margin-top:6px">1 TH3 · 3 ph đọc</div>
          </div>
        </div>
        @endforelse
      </div>

      <div class="sidebar-section">
        <div class="sidebar-title">CHỦ ĐỀ</div>
        <div class="tag-cloud">
          @forelse($tags ?? [] as $tag)
            <a href="{{ route('news.index', ['tag' => $tag->slug]) }}" class="tag-c">{{ $tag->name }}</a>
          @empty
            <span class="tag-c">BMW</span>
            <span class="tag-c">Mercedes</span>
            <span class="tag-c">Porsche</span>
            <span class="tag-c">Tesla</span>
            <span class="tag-c">Ferrari</span>
            <span class="tag-c">Xe Điện</span>
            <span class="tag-c">SUV</span>
            <span class="tag-c">Hybrid</span>
            <span class="tag-c">Đánh Giá</span>
            <span class="tag-c">Mẹo Hay</span>
            <span class="tag-c">Thị Trường</span>
            <span class="tag-c">Lamborghini</span>
          @endforelse
        </div>
      </div>
    </div>
  </div>

</div>

{{-- ─── NEWSLETTER ─── --}}
<div class="nl-strip">
  <div class="nl-left">
    <h3>ĐỪNG BỎ LỠ TIN MỚI</h3>
    <p>Nhận ngay các tin tức, đánh giá xe và ưu đãi đặc biệt mỗi tuần.</p>
  </div>
  <form class="nl-form" action="{{ route('newsletter.subscribe') }}" method="POST">
    @csrf
    <input type="email" name="email" class="nl-input" placeholder="Nhập email của bạn..." required>
    <button type="submit" class="nl-btn">ĐĂNG KÝ</button>
  </form>
</div>

{{-- ─── FOOTER ─── --}}
<footer>
  <div class="footer-grid">
    <div>
      <div class="f-logo"><em>Concept</em> Car Dealer</div>
      <p class="f-desc">Đại lý xe hơi cao cấp uy tín hơn 20 năm. Chúng tôi mang đến trải nghiệm mua xe đẳng cấp và tin cậy nhất Việt Nam.</p>
    </div>
    <div>
      <div class="f-head">Điều Hướng</div>
      <ul class="f-links">
        <li><a href="{{ url('/') }}">Trang Chủ</a></li>
        <li><a href="{{ url('/cars') }}">Xem Xe</a></li>
        <li><a href="{{ route('news.index') }}">Tin Tức</a></li>
        <li><a href="{{ url('/contact') }}">Liên Hệ</a></li>
      </ul>
    </div>
    <div>
      <div class="f-head">Chuyên Mục</div>
      <ul class="f-links">
        <li><a href="{{ route('news.index', ['category' => 'ra-mat-moi']) }}">Ra Mắt Mới</a></li>
        <li><a href="{{ route('news.index', ['category' => 'danh-gia']) }}">Đánh Giá Xe</a></li>
        <li><a href="{{ route('news.index', ['category' => 'xu-huong']) }}">Xu Hướng</a></li>
        <li><a href="{{ route('news.index', ['category' => 'meo-hay']) }}">Mẹo Mua Xe</a></li>
      </ul>
    </div>
    <div>
      <div class="f-head">Liên Hệ</div>
      <ul class="f-links">
        <li><a href="tel:+840071234567890">(007) 123 456 7890</a></li>
        <li><a href="mailto:support@conceptcardealer.vn">support@conceptcardealer.vn</a></li>
        <li><a href="#">220E Front St, Burlington</a></li>
        <li><a href="#">08:00 – 20:00</a></li>
      </ul>
    </div>
  </div>
  <div class="f-bottom">
    <div class="f-copy">© {{ date('Y') }} Concept Car Dealer. All rights reserved.</div>
    <div class="f-copy">Thiết kế bởi Concept Studio</div>
  </div>
</footer>

{{-- ════════════════════════════════════════════
     LOGIN / REGISTER MODAL
     (Tích hợp từ login-modal.html)
     Chỉ hiển thị nếu chưa đăng nhập
════════════════════════════════════════════ --}}
@guest
<div class="overlay" id="loginOverlay">
  <div class="modal" role="dialog" aria-modal="true" aria-label="Đăng nhập">
    <button class="mcl" onclick="closeLogin()" aria-label="Đóng">✕</button>

    {{-- TABS --}}
    <div class="modal-head">
      <div class="modal-tabs">
        <button class="mtab on" id="tabLogin" onclick="switchTab('login')">
          <span style="font-family:'Bebas Neue';font-size:18px;display:block;line-height:1">01</span>
          ĐĂNG NHẬP
        </button>
        <button class="mtab" id="tabReg" onclick="switchTab('reg')">
          <span style="font-family:'Bebas Neue';font-size:18px;display:block;line-height:1">02</span>
          ĐĂNG KÝ
        </button>
      </div>
    </div>

    <div class="modal-body">
      {{-- Success Message --}}
      <div class="fsuccess" id="successMsg">
        <strong style="color:var(--red);display:block;margin-bottom:4px;font-size:10px;letter-spacing:2px">THÀNH CÔNG</strong>
        <span id="successText"></span>
      </div>

      {{-- ── FORM ĐĂNG NHẬP ── --}}
      <div id="loginForm">
        {{-- Hiển thị lỗi từ Laravel session --}}
        @if($errors->has('email') && old('_form') === 'login')
          <div class="alert-danger">{{ $errors->first('email') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="laravelLoginForm">
          @csrf
          {{-- Dùng để phân biệt form nào submit khi có lỗi --}}
          <input type="hidden" name="_form" value="login">

          <div class="fg">
            <label class="fl" for="loginEmail">Email</label>
            <input type="email" class="fi {{ $errors->has('email') && old('_form') === 'login' ? 'is-invalid' : '' }}"
                   id="loginEmail" name="email"
                   value="{{ old('email') }}"
                   placeholder="email@example.com"
                   autocomplete="email">
            <div class="ferr" id="lEmailErr">Vui lòng nhập email hợp lệ.</div>
          </div>

          <div class="fg">
            <label class="fl" for="loginPassword">Mật Khẩu</label>
            <input type="password" class="fi" id="loginPassword" name="password"
                   placeholder="••••••••" autocomplete="current-password">
            <div class="ferr" id="lPassErr">Vui lòng nhập mật khẩu.</div>
          </div>

          <div style="display:flex;justify-content:flex-end;margin:-6px 0 16px">
            <a href="{{ route('password.request') }}" style="font-size:11px;color:var(--red)">Quên mật khẩu?</a>
          </div>

          <button type="submit" class="fbtn" onclick="return validateLogin()">ĐĂNG NHẬP</button>
        </form>

        <div class="fhint" style="margin-top:16px">
          Chưa có tài khoản? <a onclick="switchTab('reg')">Đăng ký ngay</a>
        </div>
        <div class="fdiv"></div>
        <div class="fhint" style="font-size:11px;letter-spacing:.5px;color:var(--faint)">
          Hoặc <a onclick="closeLogin()" style="color:var(--red)">tiếp tục không cần tài khoản</a>
        </div>
      </div>

      {{-- ── FORM ĐĂNG KÝ ── --}}
      <div id="regForm" style="display:none">
        @if($errors->has('name') || ($errors->has('email') && old('_form') === 'register'))
          <div class="alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}" id="laravelRegForm">
          @csrf
          <input type="hidden" name="_form" value="register">

          <div class="frow">
            <div class="fg">
              <label class="fl" for="regHo">Họ</label>
              <input type="text" class="fi" id="regHo" name="ho"
                     value="{{ old('ho') }}" placeholder="Nguyễn">
            </div>
            <div class="fg">
              <label class="fl" for="regTen">Tên</label>
              <input type="text" class="fi" id="regTen" name="ten"
                     value="{{ old('ten') }}" placeholder="Văn An">
            </div>
          </div>

          <div class="fg">
            <label class="fl" for="regEmail">Email</label>
            <input type="email" class="fi {{ $errors->has('email') && old('_form') === 'register' ? 'is-invalid' : '' }}"
                   id="regEmail" name="email"
                   value="{{ old('email') }}"
                   placeholder="email@example.com">
            <div class="ferr" id="rEmailErr">Vui lòng nhập email hợp lệ.</div>
          </div>

          <div class="fg">
            <label class="fl" for="regPhone">Số Điện Thoại</label>
            <input type="tel" class="fi" id="regPhone" name="phone"
                   value="{{ old('phone') }}" placeholder="0912 345 678">
          </div>

          <div class="fg">
            <label class="fl" for="regPassword">Mật Khẩu</label>
            <input type="password" class="fi" id="regPassword" name="password"
                   placeholder="Tối thiểu 8 ký tự" autocomplete="new-password">
            <div class="ferr" id="rPassErr">Mật khẩu cần ít nhất 8 ký tự.</div>
          </div>

          <div class="fg">
            <label class="fl" for="regPasswordConfirm">Xác Nhận Mật Khẩu</label>
            <input type="password" class="fi" id="regPasswordConfirm"
                   name="password_confirmation"
                   placeholder="Nhập lại mật khẩu" autocomplete="new-password">
          </div>

          <div class="fcheck">
            <input type="checkbox" id="rAgree" name="agree" value="1">
            <label for="rAgree">
              Tôi đồng ý với <a href="{{ url('/terms') }}">Điều khoản sử dụng</a>
              và <a href="{{ url('/privacy') }}">Chính sách bảo mật</a>
            </label>
          </div>

          <button type="submit" class="fbtn" onclick="return validateRegister()">TẠO TÀI KHOẢN</button>
        </form>

        <div class="fhint" style="margin-top:14px">
          Đã có tài khoản? <a onclick="switchTab('login')">Đăng nhập</a>
        </div>
      </div>
    </div>{{-- /modal-body --}}
  </div>{{-- /modal --}}
</div>
@endguest

@endsection

@push('scripts')
<script>
// ─── Category filter pills ───
document.querySelectorAll('.cat-pill').forEach(function(p) {
  p.addEventListener('click', function() {
    document.querySelectorAll('.cat-pill').forEach(function(x) { x.classList.remove('on'); });
    this.classList.add('on');
    // Nếu muốn filter thật sự qua URL:
    // const cat = this.dataset.cat;
    // window.location.href = '{{ route("news.index") }}' + (cat ? '?category=' + cat : '');
  });
});

// ─── Login Modal ───
function openLogin(defaultTab) {
  switchTab(defaultTab || 'login');
  document.getElementById('loginOverlay').classList.add('open');
}
function closeLogin() {
  document.getElementById('loginOverlay').classList.remove('open');
}

// Đóng khi click backdrop
var overlay = document.getElementById('loginOverlay');
if (overlay) {
  overlay.addEventListener('click', function(e) {
    if (e.target === this) closeLogin();
  });
}

// Đóng bằng phím ESC
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeLogin();
});

function switchTab(t) {
  var isLogin = t === 'login';
  document.getElementById('tabLogin').classList.toggle('on', isLogin);
  document.getElementById('tabReg').classList.toggle('on', !isLogin);
  document.getElementById('loginForm').style.display = isLogin ? 'block' : 'none';
  document.getElementById('regForm').style.display   = isLogin ? 'none'  : 'block';
  document.getElementById('successMsg').style.display = 'none';
  clearErrors();
}

function clearErrors() {
  document.querySelectorAll('.ferr').forEach(function(e) { e.style.display = 'none'; });
}

// ─── Client-side validation trước khi submit form Laravel ───
function validateLogin() {
  clearErrors();
  var email = document.getElementById('loginEmail').value.trim();
  var pass  = document.getElementById('loginPassword').value;
  var ok = true;
  if (!email || !/\S+@\S+\.\S+/.test(email)) {
    document.getElementById('lEmailErr').style.display = 'block'; ok = false;
  }
  if (!pass) {
    document.getElementById('lPassErr').style.display = 'block'; ok = false;
  }
  return ok; // false = chặn submit
}

function validateRegister() {
  clearErrors();
  var email = document.getElementById('regEmail').value.trim();
  var pass  = document.getElementById('regPassword').value;
  var ok = true;
  if (!email || !/\S+@\S+\.\S+/.test(email)) {
    document.getElementById('rEmailErr').style.display = 'block'; ok = false;
  }
  if (pass.length < 8) {
    document.getElementById('rPassErr').style.display = 'block'; ok = false;
  }
  return ok;
}

// ─── Tự mở modal nếu Laravel redirect về với lỗi ───
@if($errors->any() && in_array(old('_form'), ['login', 'register']))
  document.addEventListener('DOMContentLoaded', function() {
    openLogin('{{ old("_form") }}');
  });
@endif

// ─── Newsletter ───
var nlBtn = document.querySelector('.nl-btn');
if (nlBtn) {
  // Form submit xử lý qua Laravel route, không cần JS thêm
}
</script>
@endpush
