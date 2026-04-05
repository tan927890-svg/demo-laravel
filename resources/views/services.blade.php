@extends('layouts.frontend')

@section('title', 'Dịch Vụ - Concept Car Dealer')

@push('styles')
<style>
  :root {
    --red: #d42b2b; --red-dark: #b01e1e;
    --red-light: rgba(212,43,43,0.08); --red-border: rgba(212,43,43,0.22);
    --bg: #1c1c1e; --bg2: #242426; --bg3: #2c2c2f; --card: #2a2a2d;
    --border: #3a3a3e; --border-light: #4a4a4e;
    --white: #f5f0eb; --text: #c8c3bc; --muted: #8a857e; --subtle: #5a5854;
  }

  .section { padding: 96px 0; }
  .container { max-width: 1240px; margin: 0 auto; padding: 0 48px; }
  .section-label {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: 4px; text-transform: uppercase; color: var(--red);
    margin-bottom: 10px; display: flex; align-items: center; gap: 10px;
  }
  .section-label::before { content: ''; width: 3px; height: 14px; background: var(--red); flex-shrink: 0; }
  .section-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(34px,4vw,52px); font-weight: 800;
    text-transform: uppercase; color: var(--white); letter-spacing: -.5px;
  }
  .divider-line { width: 56px; height: 3px; background: var(--red); margin: 24px 0; }

  /* HERO */
  .hero {
    position: relative; height: 440px;
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
    position: absolute; width: 700px; height: 350px;
    background: radial-gradient(ellipse,rgba(180,30,30,.2) 0%,transparent 68%);
    top: 50%; left: 50%; transform: translate(-50%,-50%);
    animation: pulse 5s ease-in-out infinite;
  }
  @keyframes pulse { 0%,100%{opacity:.5;transform:translate(-50%,-50%) scale(1)} 50%{opacity:1;transform:translate(-50%,-50%) scale(1.08)} }
  .hero-content { position: relative; text-align: center; }
  .hero-eyebrow {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: 5px; text-transform: uppercase; color: var(--red);
    margin-bottom: 18px; display: flex; align-items: center; justify-content: center; gap: 14px;
  }
  .hero-eyebrow::before,.hero-eyebrow::after { content: ''; width: 36px; height: 1px; background: var(--red); opacity: .5; }
  .hero h1 {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(60px,9vw,106px); font-weight: 800;
    color: var(--white); line-height: .92; text-transform: uppercase; letter-spacing: -1px;
  }
  .hero h1 em { color: var(--red); font-style: normal; }
  .hero-sub { margin-top: 20px; font-size: 15px; color: var(--muted); }
  .breadcrumb {
    position: absolute; bottom: 28px; left: 50%; transform: translateX(-50%);
    display: flex; align-items: center; gap: 10px;
    font-size: 12px; letter-spacing: 1px; color: var(--subtle);
  }
  .breadcrumb a { color: var(--subtle); text-decoration: none; }
  .breadcrumb a:hover { color: var(--red); }
  .breadcrumb span { color: var(--red); }

  /* SERVICES INTRO */
  .intro-section { background: var(--bg); padding: 96px 0; }
  .intro-grid { display: grid; grid-template-columns: 1fr 1.4fr; gap: 80px; align-items: center; }
  .intro-text p { color: var(--text); font-size: 15px; line-height: 1.85; margin-bottom: 16px; }
  .intro-nums { display: grid; grid-template-columns: 1fr 1fr; gap: 2px; margin-top: 36px; background: var(--border); }
  .intro-num-item { background: var(--card); padding: 28px 24px; text-align: center; }
  .intro-num-item strong { font-family: 'Barlow Condensed', sans-serif; font-size: 48px; font-weight: 800; color: var(--red); line-height: 1; display: block; }
  .intro-num-item span { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--muted); margin-top: 4px; display: block; }
  .intro-visual { position: relative; }
  .service-showcase { background: var(--bg3); border: 1px solid var(--border); padding: 0; overflow: hidden; }
  .showcase-header { background: var(--red); padding: 18px 28px; display: flex; align-items: center; justify-content: space-between; }
  .showcase-header span { font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: #fff; }
  .showcase-dots { display: flex; gap: 6px; }
  .showcase-dots i { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,.4); }
  .showcase-dots i:first-child { background: rgba(255,255,255,.9); }
  .showcase-body { padding: 28px; display: flex; flex-direction: column; gap: 3px; }
  .mini-service { display: flex; align-items: center; gap: 16px; padding: 14px 16px; background: var(--card); border-left: 3px solid transparent; transition: border-color .3s, background .3s; cursor: default; }
  .mini-service:hover { border-left-color: var(--red); background: var(--bg2); }
  .mini-svc-icon { width: 36px; height: 36px; background: var(--red-light); border: 1px solid var(--red-border); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
  .mini-svc-icon svg { width: 16px; height: 16px; stroke: var(--red); fill: none; stroke-width: 1.5; }
  .mini-svc-name { font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--white); }
  .mini-svc-desc { font-size: 12px; color: var(--muted); margin-top: 2px; }
  .mini-svc-price { font-family: 'Barlow Condensed', sans-serif; font-size: 20px; font-weight: 700; color: var(--red); margin-left: auto; white-space: nowrap; }

  /* MAIN SERVICES GRID */
  .services-grid-section { background: var(--bg2); padding: 96px 0; }
  .services-header { text-align: center; margin-bottom: 60px; }
  .services-header .section-label { justify-content: center; }
  .services-header .section-label::before { display: none; }
  .services-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 2px; background: var(--border); }
  .service-card { background: var(--card); padding: 44px 32px; position: relative; overflow: hidden; transition: background .3s; }
  .service-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--border); transition: background .4s; }
  .service-card:hover::before { background: var(--red); }
  .service-card:hover { background: var(--bg3); }
  .svc-num { font-family: 'Barlow Condensed', sans-serif; font-size: 72px; font-weight: 800; color: rgba(212,43,43,.08); line-height: 1; position: absolute; top: 16px; right: 20px; transition: color .3s; }
  .service-card:hover .svc-num { color: rgba(212,43,43,.16); }
  .svc-icon { width: 56px; height: 56px; background: var(--red-light); border: 1px solid var(--red-border); display: flex; align-items: center; justify-content: center; margin-bottom: 24px; }
  .svc-icon svg { width: 24px; height: 24px; stroke: var(--red); fill: none; stroke-width: 1.5; }
  .svc-title { font-family: 'Barlow Condensed', sans-serif; font-size: 22px; font-weight: 800; text-transform: uppercase; color: var(--white); letter-spacing: .5px; margin-bottom: 12px; }
  .svc-desc { font-size: 13px; color: var(--muted); line-height: 1.85; margin-bottom: 22px; }
  .svc-list { list-style: none; padding: 0; margin: 0 0 24px; display: flex; flex-direction: column; gap: 8px; }
  .svc-list li { display: flex; align-items: flex-start; gap: 10px; font-size: 13px; color: var(--text); }
  .svc-list li::before { content: ''; width: 6px; height: 6px; background: var(--red); flex-shrink: 0; margin-top: 6px; }
  .svc-price-tag { display: inline-flex; align-items: baseline; gap: 4px; }
  .svc-price-tag .from { font-size: 11px; color: var(--muted); letter-spacing: 1px; text-transform: uppercase; }
  .svc-price-tag .price { font-family: 'Barlow Condensed', sans-serif; font-size: 28px; font-weight: 800; color: var(--red); }
  .svc-price-tag .unit { font-size: 12px; color: var(--muted); }
  .btn-svc {
    display: inline-flex; align-items: center; gap: 8px; margin-top: 20px;
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; color: var(--red);
    text-decoration: none; border-bottom: 1px solid var(--red-border);
    padding-bottom: 3px; transition: color .2s, border-color .2s;
  }
  .btn-svc:hover { color: var(--white); border-color: var(--white); }
  .btn-svc svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; }

  /* PROCESS */
  .process-section { background: var(--bg); padding: 96px 0; }
  .process-header { margin-bottom: 60px; }
  .process-steps { display: grid; grid-template-columns: repeat(5,1fr); position: relative; }
  .process-steps::before { content: ''; position: absolute; top: 36px; left: 10%; right: 10%; height: 1px; background: var(--border); z-index: 0; }
  .process-step { text-align: center; position: relative; z-index: 1; padding: 0 12px; }
  .step-circle { width: 72px; height: 72px; background: var(--card); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; position: relative; transition: background .3s, border-color .3s; }
  .step-circle:hover { background: var(--red); border-color: var(--red); }
  .step-circle svg { width: 24px; height: 24px; stroke: var(--muted); fill: none; stroke-width: 1.5; transition: stroke .3s; }
  .step-circle:hover svg { stroke: #fff; }
  .step-num { position: absolute; top: -8px; right: -8px; width: 22px; height: 22px; background: var(--red); font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; color: #fff; display: flex; align-items: center; justify-content: center; }
  .step-title { font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--white); margin-bottom: 8px; }
  .step-desc { font-size: 12px; color: var(--muted); line-height: 1.7; }

  /* PACKAGES */
  .packages-section { background: var(--bg2); padding: 96px 0; }
  .packages-header { text-align: center; margin-bottom: 60px; }
  .packages-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 2px; background: var(--border); }
  .pkg-card { background: var(--card); padding: 44px 32px; position: relative; overflow: hidden; }
  .pkg-card.featured { background: var(--red); }
  .pkg-badge { position: absolute; top: 0; right: 0; background: var(--white); color: var(--red); font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 6px 14px; }
  .pkg-card.featured .pkg-badge { background: rgba(255,255,255,.2); color: #fff; }
  .pkg-name { font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700; letter-spacing: 4px; text-transform: uppercase; color: var(--muted); margin-bottom: 8px; }
  .pkg-card.featured .pkg-name { color: rgba(255,255,255,.7); }
  .pkg-price { font-family: 'Barlow Condensed', sans-serif; font-size: 56px; font-weight: 800; color: var(--white); line-height: 1; }
  .pkg-card.featured .pkg-price { color: #fff; }
  .pkg-price sup { font-size: 22px; vertical-align: top; margin-top: 12px; }
  .pkg-period { font-size: 13px; color: var(--muted); margin-top: 4px; margin-bottom: 28px; }
  .pkg-card.featured .pkg-period { color: rgba(255,255,255,.6); }
  .pkg-divider { height: 1px; background: var(--border); margin-bottom: 24px; }
  .pkg-card.featured .pkg-divider { background: rgba(255,255,255,.2); }
  .pkg-features { list-style: none; padding: 0; margin: 0 0 32px; display: flex; flex-direction: column; gap: 12px; }
  .pkg-features li { display: flex; align-items: flex-start; gap: 12px; font-size: 13px; color: var(--text); line-height: 1.5; }
  .pkg-card.featured .pkg-features li { color: rgba(255,255,255,.85); }
  .pkg-features li .tick { width: 16px; height: 16px; min-width: 16px; background: var(--red-light); border: 1px solid var(--red-border); display: flex; align-items: center; justify-content: center; margin-top: 1px; }
  .pkg-card.featured .pkg-features li .tick { background: rgba(255,255,255,.15); border-color: rgba(255,255,255,.3); }
  .pkg-features li .tick svg { width: 9px; height: 9px; stroke: var(--red); fill: none; stroke-width: 2.5; }
  .pkg-card.featured .pkg-features li .tick svg { stroke: #fff; }
  .btn-red {
    display: inline-flex; align-items: center; gap: 10px;
    background: var(--red); color: #fff;
    font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; padding: 14px 32px;
    text-decoration: none; transition: background .2s, transform .15s; width: 100%; justify-content: center;
  }
  .btn-red:hover { background: var(--red-dark); transform: translateY(-2px); }
  .btn-outline-pkg {
    display: inline-flex; align-items: center; gap: 10px; justify-content: center; width: 100%;
    background: transparent; color: var(--white);
    font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; padding: 13px 32px;
    text-decoration: none; border: 1px solid var(--border-light); transition: border-color .2s, color .2s;
  }
  .btn-outline-pkg:hover { border-color: var(--red); color: var(--red); }
  .btn-white-pkg {
    display: inline-flex; align-items: center; gap: 10px; justify-content: center; width: 100%;
    background: #fff; color: var(--red);
    font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; padding: 14px 32px;
    text-decoration: none; transition: opacity .2s;
  }
  .btn-white-pkg:hover { opacity: .9; }

  /* CTA */
  .cta-section { background: var(--bg); padding: 100px 0; position: relative; overflow: hidden; text-align: center; }
  .cta-section::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse 70% 60% at 50% 110%,rgba(170,20,20,.18) 0%,transparent 70%); }
  .cta-section h2 { font-family: 'Barlow Condensed', sans-serif; font-size: clamp(42px,6vw,74px); font-weight: 800; text-transform: uppercase; color: var(--white); line-height: 1; position: relative; }
  .cta-section h2 em { color: var(--red); font-style: normal; }
  .cta-section p { color: var(--muted); max-width: 500px; margin: 20px auto 36px; font-size: 15px; position: relative; }
  .btn-row { display: inline-flex; gap: 12px; flex-wrap: wrap; justify-content: center; }
  .btn-red-inline {
    display: inline-flex; align-items: center; gap: 10px;
    background: var(--red); color: #fff;
    font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; padding: 14px 32px;
    text-decoration: none; transition: background .2s;
  }
  .btn-red-inline:hover { background: var(--red-dark); }
  .btn-outline-inline {
    display: inline-flex; align-items: center; gap: 10px;
    background: transparent; color: var(--white);
    font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; padding: 13px 32px;
    text-decoration: none; border: 1px solid var(--border-light); transition: border-color .2s, color .2s;
  }
  .btn-outline-inline:hover { border-color: var(--red); color: var(--red); }

  [data-anim] { opacity: 0; transform: translateY(28px); transition: opacity .65s ease, transform .65s ease; }
  [data-anim].visible { opacity: 1; transform: translateY(0); }
  [data-anim="left"] { transform: translateX(-28px); }
  [data-anim="left"].visible { transform: translateX(0); }
  [data-anim="right"] { transform: translateX(28px); }
  [data-anim="right"].visible { transform: translateX(0); }

  @media (max-width: 900px) {
    .container { padding: 0 24px; }
    .intro-grid, .process-steps { grid-template-columns: 1fr; }
    .services-grid, .packages-grid { grid-template-columns: 1fr; }
    .process-steps::before { display: none; }
  }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="hero">
  <div class="hero-glow"></div>
  <div class="hero-content">
    <div class="hero-eyebrow">Giải pháp toàn diện</div>
    <h1>Dịch <em>Vụ</em></h1>
    <p class="hero-sub">Mọi nhu cầu xe hơi — Một điểm đến duy nhất</p>
  </div>
  <div class="breadcrumb">
  <a href="{{ url('/') }}">Home</a> &rsaquo;
  <a href="{{ url('/about') }}">About Us</a> &rsaquo;
  <a href="{{ url('/cars') }}">Cars</a> &rsaquo;
  <span>Dịch Vụ</span>
</div>
</section>

{{-- INTRO --}}
<section class="intro-section">
  <div class="container">
    <div class="intro-grid">
      <div class="intro-text" data-anim="left">
        <div class="section-label">Tại sao chọn chúng tôi</div>
        <h2 class="section-title">Dịch Vụ<br/>Đẳng Cấp</h2>
        <div class="divider-line"></div>
        <p>Chúng tôi không chỉ bán xe — chúng tôi cung cấp trải nghiệm hoàn chỉnh từ lúc bạn bước vào showroom đến khi chiếc xe của bạn lăn bánh trên đường.</p>
        <p>Mỗi dịch vụ được thiết kế để đảm bảo bạn có được giá trị tốt nhất, quy trình minh bạch và sự hỗ trợ liên tục sau mua hàng.</p>
        <div class="intro-nums">
          <div class="intro-num-item"><strong>15+</strong><span>Năm kinh nghiệm</span></div>
          <div class="intro-num-item"><strong>8K+</strong><span>Khách hàng phục vụ</span></div>
          <div class="intro-num-item"><strong>24/7</strong><span>Hỗ trợ liên tục</span></div>
          <div class="intro-num-item"><strong>98%</strong><span>Hài lòng sau dịch vụ</span></div>
        </div>
      </div>
      <div class="intro-visual" data-anim="right">
        <div class="service-showcase">
          <div class="showcase-header">
            <span>Dịch vụ nổi bật</span>
            <div class="showcase-dots"><i></i><i></i><i></i></div>
          </div>
          <div class="showcase-body">
            <div class="mini-service">
              <div class="mini-svc-icon"><svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div>
              <div><div class="mini-svc-name">Tư vấn & Mua xe</div><div class="mini-svc-desc">Hỗ trợ chọn xe phù hợp nhất</div></div>
              <div class="mini-svc-price">Miễn phí</div>
            </div>
            <div class="mini-service">
              <div class="mini-svc-icon"><svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
              <div><div class="mini-svc-name">Hỗ trợ Tài Chính</div><div class="mini-svc-desc">Vay mua xe lãi suất thấp</div></div>
              <div class="mini-svc-price">Từ 5.9%</div>
            </div>
            <div class="mini-service">
              <div class="mini-svc-icon"><svg viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg></div>
              <div><div class="mini-svc-name">Bảo Dưỡng & Sửa Chữa</div><div class="mini-svc-desc">Kỹ thuật viên chứng nhận quốc tế</div></div>
              <div class="mini-svc-price">Từ 500K</div>
            </div>
            <div class="mini-service">
              <div class="mini-svc-icon"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
              <div><div class="mini-svc-name">Bảo Hiểm Xe</div><div class="mini-svc-desc">Gói bảo hiểm toàn diện</div></div>
              <div class="mini-svc-price">Từ 2.5%</div>
            </div>
            <div class="mini-service">
              <div class="mini-svc-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
              <div><div class="mini-svc-name">Đổi Xe & Trade-in</div><div class="mini-svc-desc">Định giá xe cũ chính xác</div></div>
              <div class="mini-svc-price">Định giá ngay</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- MAIN SERVICES --}}
<section class="services-grid-section">
  <div class="container">
    <div class="services-header" data-anim>
      <div class="section-label" style="justify-content:center;"><div style="width:3px;height:14px;background:var(--red);"></div> Danh mục dịch vụ</div>
      <h2 class="section-title">Tất Cả <em style="color:var(--red);font-style:normal">Dịch Vụ</em></h2>
    </div>
    <div class="services-grid" data-anim>

      <div class="service-card">
        <div class="svc-num">01</div>
        <div class="svc-icon"><svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></div>
        <div class="svc-title">Tư Vấn & Mua Xe</div>
        <p class="svc-desc">Đội ngũ tư vấn chuyên nghiệp giúp bạn tìm ra chiếc xe phù hợp nhất với nhu cầu và ngân sách.</p>
        <ul class="svc-list">
          <li>Phân tích nhu cầu sử dụng chi tiết</li>
          <li>So sánh đa dạng mẫu xe từ 30+ thương hiệu</li>
          <li>Lái thử miễn phí không giới hạn</li>
          <li>Tư vấn giá trị bền lâu và tái bán</li>
        </ul>
        <div class="svc-price-tag">
          <span class="from">Phí tư vấn</span>
          <span class="price">Miễn phí</span>
        </div>
        <a href="{{ url('/contact') }}" class="btn-svc">Đặt lịch tư vấn <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
      </div>

      <div class="service-card">
        <div class="svc-num">02</div>
        <div class="svc-icon"><svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
        <div class="svc-title">Hỗ Trợ Tài Chính</div>
        <p class="svc-desc">Kết nối trực tiếp với 10+ ngân hàng hàng đầu. Phê duyệt nhanh, thủ tục đơn giản, lãi suất cạnh tranh.</p>
        <ul class="svc-list">
          <li>Phê duyệt khoản vay trong 24 giờ</li>
          <li>Lãi suất từ 5.9%/năm</li>
          <li>Trả góp linh hoạt 12–60 tháng</li>
          <li>Hỗ trợ hồ sơ tài chính toàn diện</li>
        </ul>
        <div class="svc-price-tag">
          <span class="from">Lãi suất từ</span>
          <span class="price">5.9%</span>
          <span class="unit">/năm</span>
        </div>
        <a href="{{ url('/contact') }}" class="btn-svc">Tính toán ngay <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
      </div>

      <div class="service-card">
        <div class="svc-num">03</div>
        <div class="svc-icon"><svg viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg></div>
        <div class="svc-title">Bảo Dưỡng & Sửa Chữa</div>
        <p class="svc-desc">Xưởng dịch vụ đạt chuẩn quốc tế với thiết bị hiện đại và đội ngũ kỹ thuật viên được chứng nhận.</p>
        <ul class="svc-list">
          <li>Bảo dưỡng định kỳ theo nhà sản xuất</li>
          <li>Sửa chữa điện, động cơ, hộp số</li>
          <li>Thay thế phụ tùng chính hãng</li>
          <li>Kiểm tra xe định kỳ miễn phí</li>
        </ul>
        <div class="svc-price-tag">
          <span class="from">Bảo dưỡng từ</span>
          <span class="price">500K</span>
          <span class="unit">VNĐ</span>
        </div>
        <a href="{{ url('/contact') }}" class="btn-svc">Đặt lịch bảo dưỡng <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
      </div>

      <div class="service-card">
        <div class="svc-num">04</div>
        <div class="svc-icon"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
        <div class="svc-title">Bảo Hiểm Xe Hơi</div>
        <p class="svc-desc">Các gói bảo hiểm toàn diện từ những công ty bảo hiểm uy tín. Thủ tục nhanh gọn, bồi thường nhanh chóng.</p>
        <ul class="svc-list">
          <li>Bảo hiểm bắt buộc & tự nguyện</li>
          <li>Bồi thường trong 48 giờ</li>
          <li>Hỗ trợ xe thay thế khi sửa chữa</li>
          <li>Gói combo ưu đãi cho khách mua xe</li>
        </ul>
        <div class="svc-price-tag">
          <span class="from">Phí bảo hiểm từ</span>
          <span class="price">2.5%</span>
          <span class="unit">giá trị xe</span>
        </div>
        <a href="{{ url('/contact') }}" class="btn-svc">Nhận báo giá <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
      </div>

      <div class="service-card">
        <div class="svc-num">05</div>
        <div class="svc-icon"><svg viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg></div>
        <div class="svc-title">Đổi Xe & Trade-in</div>
        <p class="svc-desc">Định giá xe cũ của bạn theo thị trường thực tế. Quy trình đổi xe minh bạch, nhận giá tốt nhất.</p>
        <ul class="svc-list">
          <li>Định giá xe trong 30 phút</li>
          <li>Thanh toán ngay khi giao dịch</li>
          <li>Hỗ trợ thủ tục sang tên đổi chủ</li>
          <li>Áp dụng chiết khấu mua xe mới</li>
        </ul>
        <div class="svc-price-tag">
          <span class="from">Định giá</span>
          <span class="price">Miễn phí</span>
        </div>
        <a href="{{ url('/contact') }}" class="btn-svc">Định giá xe ngay <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
      </div>

      <div class="service-card">
        <div class="svc-num">06</div>
        <div class="svc-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg></div>
        <div class="svc-title">Đăng Ký & Thủ Tục</div>
        <p class="svc-desc">Dịch vụ hỗ trợ đăng ký biển số, sang tên, đổi chủ và tất cả thủ tục pháp lý liên quan đến xe.</p>
        <ul class="svc-list">
          <li>Đăng ký biển số mới toàn quốc</li>
          <li>Sang tên & đổi chủ xe nhanh chóng</li>
          <li>Hỗ trợ kiểm định an toàn kỹ thuật</li>
          <li>Đăng kiểm & làm lại giấy tờ xe</li>
        </ul>
        <div class="svc-price-tag">
          <span class="from">Phí dịch vụ từ</span>
          <span class="price">300K</span>
          <span class="unit">VNĐ</span>
        </div>
        <a href="{{ url('/contact') }}" class="btn-svc">Tìm hiểu thêm <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
      </div>

    </div>
  </div>
</section>

{{-- PROCESS --}}
<section class="process-section">
  <div class="container">
    <div class="process-header" data-anim>
      <div class="section-label">Đơn giản & nhanh chóng</div>
      <h2 class="section-title">Quy Trình <em style="color:var(--red);font-style:normal">5 Bước</em></h2>
    </div>
    <div class="process-steps" data-anim>
      <div class="process-step">
        <div class="step-circle">
          <div class="step-num">1</div>
          <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </div>
        <div class="step-title">Liên hệ tư vấn</div>
        <p class="step-desc">Gọi điện, nhắn tin hoặc đến trực tiếp showroom để được tư vấn miễn phí.</p>
      </div>
      <div class="process-step">
        <div class="step-circle">
          <div class="step-num">2</div>
          <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>
        <div class="step-title">Chọn xe & lái thử</div>
        <p class="step-desc">Xem xe thực tế tại showroom và lái thử miễn phí để trải nghiệm trực tiếp.</p>
      </div>
      <div class="process-step">
        <div class="step-circle">
          <div class="step-num">3</div>
          <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        </div>
        <div class="step-title">Hoàn thiện hồ sơ</div>
        <p class="step-desc">Đội ngũ hỗ trợ chuẩn bị đầy đủ giấy tờ, hợp đồng và thủ tục pháp lý.</p>
      </div>
      <div class="process-step">
        <div class="step-circle">
          <div class="step-num">4</div>
          <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        </div>
        <div class="step-title">Thanh toán & ký kết</div>
        <p class="step-desc">Thanh toán linh hoạt — tiền mặt, chuyển khoản hoặc vay ngân hàng qua chúng tôi.</p>
      </div>
      <div class="process-step">
        <div class="step-circle">
          <div class="step-num">5</div>
          <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        </div>
        <div class="step-title">Nhận xe & hậu mãi</div>
        <p class="step-desc">Giao xe tận nơi, hỗ trợ đăng ký biển số và theo dõi hậu mãi 24/7.</p>
      </div>
    </div>
  </div>
</section>

{{-- PACKAGES --}}
<section class="packages-section">
  <div class="container">
    <div class="packages-header" data-anim>
      <div class="section-label" style="justify-content:center;"><div style="width:3px;height:14px;background:var(--red);"></div> Gói hậu mãi</div>
      <h2 class="section-title">Chọn Gói <em style="color:var(--red);font-style:normal">Phù Hợp</em></h2>
      <p style="color:var(--muted);margin-top:14px;font-size:14px;">Các gói dịch vụ hậu mãi được thiết kế để bảo vệ xe của bạn toàn diện.</p>
    </div>
    <div class="packages-grid" data-anim>

      <div class="pkg-card">
        <div class="pkg-name">Gói Cơ Bản</div>
        <div class="pkg-price"><sup>₫</sup>1.9<span style="font-size:24px">tr</span></div>
        <div class="pkg-period">/ năm</div>
        <div class="pkg-divider"></div>
        <ul class="pkg-features">
          <li><div class="tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Kiểm tra xe 2 lần/năm</li>
          <li><div class="tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Thay dầu & lọc gió</li>
          <li><div class="tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Hotline hỗ trợ 8h–18h</li>
          <li><div class="tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Chiết khấu 5% phụ tùng</li>
        </ul>
        <a href="{{ url('/contact') }}" class="btn-outline-pkg">Đăng ký gói</a>
      </div>

      <div class="pkg-card featured">
        <div class="pkg-badge">Phổ biến nhất</div>
        <div class="pkg-name">Gói Tiêu Chuẩn</div>
        <div class="pkg-price"><sup>₫</sup>3.9<span style="font-size:24px">tr</span></div>
        <div class="pkg-period">/ năm</div>
        <div class="pkg-divider"></div>
        <ul class="pkg-features">
          <li><div class="tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Kiểm tra xe 4 lần/năm</li>
          <li><div class="tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Bảo dưỡng toàn diện</li>
          <li><div class="tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Hotline hỗ trợ 24/7</li>
          <li><div class="tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Chiết khấu 10% phụ tùng</li>
          <li><div class="tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Xe thay thế khi sửa chữa</li>
          <li><div class="tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Cứu hộ khẩn cấp 24/7</li>
        </ul>
        <a href="{{ url('/contact') }}" class="btn-white-pkg">Đăng ký ngay</a>
      </div>

      <div class="pkg-card">
        <div class="pkg-name">Gói Cao Cấp</div>
        <div class="pkg-price"><sup>₫</sup>6.9<span style="font-size:24px">tr</span></div>
        <div class="pkg-period">/ năm</div>
        <div class="pkg-divider"></div>
        <ul class="pkg-features">
          <li><div class="tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Kiểm tra xe không giới hạn</li>
          <li><div class="tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Bảo dưỡng VIP ưu tiên</li>
          <li><div class="tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Quản lý xe cá nhân 1-1</li>
          <li><div class="tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Chiết khấu 20% phụ tùng</li>
          <li><div class="tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Rửa xe miễn phí hàng tuần</li>
          <li><div class="tick"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Ưu tiên test-drive xe mới</li>
        </ul>
        <a href="{{ url('/contact') }}" class="btn-outline-pkg">Đăng ký gói</a>
      </div>

    </div>
  </div>
</section>

{{-- CTA --}}
<section class="cta-section">
  <div class="container" style="position:relative">
    <h2>Bắt Đầu Trải <em>Nghiệm</em><br/>Dịch Vụ Ngay Hôm Nay</h2>
    <p>Đội ngũ chuyên gia luôn sẵn sàng hỗ trợ bạn 24/7. Liên hệ ngay để được tư vấn miễn phí.</p>
    <div class="btn-row">
      <a href="{{ url('/contact') }}" class="btn-red-inline">Liên hệ ngay &#8594;</a>
      <a href="{{ url('/cars') }}" class="btn-outline-inline">Xem tất cả xe</a>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
  }, { threshold: 0.1 });
  document.querySelectorAll('[data-anim]').forEach(el => observer.observe(el));
</script>
@endpush
