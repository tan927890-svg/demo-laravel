@extends('layouts.frontend')

@section('title', 'About Us - Concept Car Dealer')

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

  /* WHO */
  .who { background: var(--bg); }
  .who-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
  .who-img-frame { aspect-ratio: 4/3; background: var(--bg3); border: 1px solid var(--border); overflow: hidden; position: relative; }
  .who-img-frame svg { width: 100%; height: 100%; display: block; }
  .who-img-frame::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: var(--red); }
  .who-visual { position: relative; }
  .who-badge {
    position: absolute; bottom: -18px; right: -18px;
    width: 114px; height: 114px; background: var(--red);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    clip-path: polygon(50% 0%,100% 25%,100% 75%,50% 100%,0% 75%,0% 25%);
  }
  .who-badge strong { font-family: 'Barlow Condensed', sans-serif; font-size: 34px; font-weight: 800; color: #fff; line-height: 1; }
  .who-badge span { font-size: 10px; color: rgba(255,255,255,.8); letter-spacing: 1px; text-transform: uppercase; }
  .who-text p { color: var(--text); margin-bottom: 18px; font-size: 15px; }
  .who-text p:first-of-type { font-size: 16px; color: #b0aba4; }
  .btn-row { display: flex; gap: 12px; margin-top: 32px; }
  .btn-red {
    display: inline-flex; align-items: center; gap: 10px;
    background: var(--red); color: #fff;
    font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; padding: 14px 32px;
    text-decoration: none; transition: background .2s, transform .15s;
  }
  .btn-red:hover { background: var(--red-dark); transform: translateY(-2px); }
  .btn-outline {
    display: inline-flex; align-items: center; gap: 10px;
    background: transparent; color: var(--white);
    font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; padding: 13px 32px;
    text-decoration: none; border: 1px solid var(--border-light); transition: border-color .2s, color .2s;
  }
  .btn-outline:hover { border-color: var(--red); color: var(--red); }

  /* STATS */
  .stats-strip { background: var(--red); }
  .stats-grid { display: grid; grid-template-columns: repeat(4,1fr); border-left: 1px solid rgba(255,255,255,.15); }
  .stat-item { padding: 44px 28px; text-align: center; border-right: 1px solid rgba(255,255,255,.15); transition: background .2s; }
  .stat-item:hover { background: rgba(0,0,0,.12); }
  .stat-num { font-family: 'Barlow Condensed', sans-serif; font-size: 60px; font-weight: 800; color: #fff; line-height: 1; }
  .stat-num sup { font-size: 24px; vertical-align: top; margin-top: 10px; }
  .stat-label { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: 3px; text-transform: uppercase; color: rgba(255,255,255,.7); margin-top: 6px; }

  /* VALUES */
  .values { background: var(--bg2); }
  .values-header { text-align: center; margin-bottom: 60px; }
  .values-header .section-label { justify-content: center; }
  .values-header .section-label::before { display: none; }
  .values-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 2px; background: var(--border); }
  .value-card { background: var(--card); padding: 44px 28px; position: relative; overflow: hidden; transition: background .3s; }
  .value-card::before { content: ''; position: absolute; top: 0; left: 0; width: 3px; height: 0; background: var(--red); transition: height .4s ease; }
  .value-card:hover::before { height: 100%; }
  .value-card:hover { background: var(--bg3); }
  .val-icon { width: 50px; height: 50px; background: var(--red-light); border: 1px solid var(--red-border); display: flex; align-items: center; justify-content: center; margin-bottom: 22px; }
  .val-icon svg { width: 22px; height: 22px; stroke: var(--red); fill: none; stroke-width: 1.5; }
  .val-title { font-family: 'Rajdhani', sans-serif; font-size: 16px; font-weight: 700; color: var(--white); letter-spacing: 1px; text-transform: uppercase; margin-bottom: 10px; }
  .val-text { font-size: 13px; color: var(--muted); line-height: 1.85; }

  /* BRANDS */
  .brands-section { background: var(--bg); padding: 96px 0; }
  .brands-header { text-align: center; margin-bottom: 60px; }
  .brands-grid { display: grid; grid-template-columns: repeat(5,1fr); gap: 2px; background: var(--border); }
  .brands-grid-2 { display: grid; grid-template-columns: repeat(4,1fr); gap: 2px; background: var(--border); margin-top: 2px; }
  .brand-card { background: var(--card); display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 36px 20px; position: relative; overflow: hidden; cursor: pointer; transition: background .3s; }
  .brand-card::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 2px; background: var(--red); transform: scaleX(0); transform-origin: left; transition: transform .35s ease; }
  .brand-card:hover::after { transform: scaleX(1); }
  .brand-card:hover { background: var(--bg3); }
  .brand-logo-wrap { width: 68px; height: 68px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; filter: grayscale(1) brightness(.45); transition: filter .35s; }
  .brand-card:hover .brand-logo-wrap { filter: grayscale(0) brightness(1); }
  .brand-name { font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--muted); transition: color .3s; }
  .brand-card:hover .brand-name { color: var(--white); }
  .brand-type { font-size: 11px; color: var(--subtle); letter-spacing: 1px; text-transform: uppercase; margin-top: 4px; transition: color .3s; }
  .brand-card:hover .brand-type { color: var(--red); }
  .trust-row { text-align: center; margin-top: 40px; font-size: 13px; color: var(--subtle); letter-spacing: .5px; }
  .trust-row b { color: var(--red); font-weight: 400; }

  /* WHY */
  .why-section { background: var(--bg2); padding: 96px 0; }
  .why-header { margin-bottom: 60px; }
  .why-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 56px; align-items: start; }
  .why-features { display: flex; flex-direction: column; gap: 3px; }
  .why-feature { background: var(--card); border: 1px solid var(--border); padding: 26px 30px; display: flex; gap: 22px; align-items: flex-start; position: relative; overflow: hidden; transition: border-color .3s, background .3s; }
  .why-feature::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px; background: var(--red); transform: scaleY(0); transform-origin: bottom; transition: transform .35s ease; }
  .why-feature:hover::before { transform: scaleY(1); }
  .why-feature:hover { border-color: var(--border-light); background: var(--bg3); }
  .why-num { font-family: 'Barlow Condensed', sans-serif; font-size: 46px; font-weight: 800; color: rgba(212,43,43,.12); line-height: 1; min-width: 44px; transition: color .3s; }
  .why-feature:hover .why-num { color: rgba(212,43,43,.28); }
  .why-feature-title { font-family: 'Rajdhani', sans-serif; font-size: 16px; font-weight: 700; color: var(--white); letter-spacing: .5px; text-transform: uppercase; margin-bottom: 8px; }
  .why-feature-text { font-size: 13px; color: var(--muted); line-height: 1.85; }
  .why-right { display: flex; flex-direction: column; gap: 22px; }
  .why-highlight { background: var(--red); padding: 36px 30px; position: relative; overflow: hidden; }
  .why-highlight::before { content: ''; position: absolute; top: -28px; right: -28px; width: 110px; height: 110px; border-radius: 50%; background: rgba(255,255,255,.07); }
  .why-highlight-num { font-family: 'Barlow Condensed', sans-serif; font-size: 68px; font-weight: 800; color: #fff; line-height: 1; }
  .why-highlight-label { font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 600; letter-spacing: 3px; text-transform: uppercase; color: rgba(255,255,255,.75); margin-top: 4px; }
  .why-highlight-desc { font-size: 13px; color: rgba(255,255,255,.65); margin-top: 14px; line-height: 1.75; }
  .why-checklist { background: var(--card); border: 1px solid var(--border); padding: 26px 30px; }
  .why-checklist-title { font-family: 'Rajdhani', sans-serif; font-size: 14px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--white); margin-bottom: 16px; }
  .checklist-item { display: flex; align-items: flex-start; gap: 13px; padding: 10px 0; border-bottom: 1px solid var(--border); font-size: 13px; color: var(--text); line-height: 1.65; }
  .checklist-item:last-child { border-bottom: none; }
  .check-icon { width: 18px; height: 18px; min-width: 18px; background: var(--red-light); border: 1px solid var(--red-border); display: flex; align-items: center; justify-content: center; margin-top: 1px; }
  .check-icon svg { width: 10px; height: 10px; stroke: var(--red); fill: none; stroke-width: 2.5; }

  /* REVIEWS */
  .reviews-strip { background: var(--bg3); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 20px 0; overflow: hidden; margin-top: 60px; }
  .reviews-track { display: flex; gap: 40px; white-space: nowrap; animation: marquee 30s linear infinite; }
  .reviews-track:hover { animation-play-state: paused; }
  @keyframes marquee { from{transform:translateX(0)} to{transform:translateX(-50%)} }
  .review-item { display: inline-flex; align-items: center; gap: 12px; flex-shrink: 0; }
  .review-stars { color: var(--red); font-size: 13px; letter-spacing: 1px; }
  .review-text { font-size: 13px; color: var(--muted); font-style: italic; }
  .review-author { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--subtle); }
  .review-sep { color: var(--border); }

  /* CTA */
  .cta-section { background: var(--bg); padding: 100px 0; position: relative; overflow: hidden; text-align: center; }
  .cta-section::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse 70% 60% at 50% 110%,rgba(170,20,20,.18) 0%,transparent 70%); }
  .cta-section h2 { font-family: 'Barlow Condensed', sans-serif; font-size: clamp(42px,6vw,74px); font-weight: 800; text-transform: uppercase; color: var(--white); line-height: 1; position: relative; }
  .cta-section h2 em { color: var(--red); font-style: normal; }
  .cta-section p { color: var(--muted); max-width: 500px; margin: 20px auto 36px; font-size: 15px; position: relative; }

  [data-anim] { opacity: 0; transform: translateY(28px); transition: opacity .65s ease, transform .65s ease; }
  [data-anim].visible { opacity: 1; transform: translateY(0); }
  [data-anim="left"] { transform: translateX(-28px); }
  [data-anim="left"].visible { transform: translateX(0); }
  [data-anim="right"] { transform: translateX(28px); }
  [data-anim="right"].visible { transform: translateX(0); }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="hero">
  <div class="hero-glow"></div>
  <div class="hero-content">
    <div class="hero-eyebrow">Khám phá chúng tôi</div>
    <h1>Về <em>Chúng Tôi</em></h1>
    <p class="hero-sub">Đam mê xe hơi — Sứ mệnh của chúng tôi</p>
  </div>
  <div class="breadcrumb"><a href="{{ url('/') }}">Home</a> &rsaquo; <span>About Us</span></div>
</section>

{{-- WHO WE ARE --}}
<section class="section who">
  <div class="container">
    <div class="who-grid">
      <div class="who-visual" data-anim="left">
        <div class="who-img-frame">
          <svg viewBox="0 0 600 450" xmlns="http://www.w3.org/2000/svg">
            <rect width="600" height="450" fill="#222224"/>
            <line x1="0" y1="225" x2="600" y2="225" stroke="#2e2e31" stroke-width="1"/>
            <line x1="300" y1="0" x2="300" y2="450" stroke="#2e2e31" stroke-width="1"/>
            <g transform="translate(60,140)">
              <path d="M20 200 Q20 170 40 170 L80 120 Q120 80 200 72 L330 72 Q390 72 420 110 L460 170 L470 170 Q490 170 490 200 L490 220 Q480 240 460 240 L80 240 Q40 240 20 220 Z" fill="#2a1818" stroke="#d42b2b" stroke-width="1.5"/>
              <path d="M100 120 L130 85 Q160 72 220 72 L310 72 Q350 74 360 100 L380 120 Z" fill="#1c1c1e" stroke="#3a3a3e" stroke-width="1"/>
              <circle cx="130" cy="240" r="50" fill="#1a1a1c" stroke="#d42b2b" stroke-width="1.5"/>
              <circle cx="130" cy="240" r="30" fill="#222224" stroke="#4a4a4e" stroke-width="1"/>
              <circle cx="130" cy="240" r="8" fill="#d42b2b"/>
              <circle cx="370" cy="240" r="50" fill="#1a1a1c" stroke="#d42b2b" stroke-width="1.5"/>
              <circle cx="370" cy="240" r="30" fill="#222224" stroke="#4a4a4e" stroke-width="1"/>
              <circle cx="370" cy="240" r="8" fill="#d42b2b"/>
              <path d="M18 180 L35 175 L35 195 L18 192 Z" fill="#d42b2b" opacity=".8"/>
              <ellipse cx="250" cy="240" rx="200" ry="14" fill="rgba(212,43,43,.07)"/>
            </g>
            <rect x="0" y="0" width="600" height="3" fill="#d42b2b"/>
          </svg>
        </div>
        <div class="who-badge"><strong>15+</strong><span>Năm</span></div>
      </div>
      <div class="who-text" data-anim="right">
        <div class="section-label">Câu chuyện của chúng tôi</div>
        <h2 class="section-title">Chúng Tôi Là<br/>Ai?</h2>
        <div class="divider-line"></div>
        <p>Concept Car Dealer được thành lập với niềm đam mê bất tận dành cho những chiếc xe hơi đẳng cấp.</p>
        <p>Với hơn 15 năm hoạt động, chúng tôi đã phục vụ hàng nghìn khách hàng, cung cấp những mẫu xe mới nhất từ các thương hiệu hàng đầu thế giới.</p>
        <p>Đội ngũ chuyên gia luôn sẵn sàng tư vấn và đồng hành cùng bạn trong hành trình lựa chọn chiếc xe hoàn hảo nhất.</p>
        <div class="btn-row">
          <a href="{{ route('cars.index') }}" class="btn-red">Khám phá xe</a>
          <a href="#" class="btn-outline">Liên hệ</a>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- STATS --}}
<div class="stats-strip">
  <div class="container" style="padding:0">
    <div class="stats-grid">
      <div class="stat-item" data-anim><div class="stat-num">15<sup>+</sup></div><div class="stat-label">Năm kinh nghiệm</div></div>
      <div class="stat-item" data-anim><div class="stat-num">8K<sup>+</sup></div><div class="stat-label">Khách hàng hài lòng</div></div>
      <div class="stat-item" data-anim><div class="stat-num">200<sup>+</sup></div><div class="stat-label">Mẫu xe hiện có</div></div>
      <div class="stat-item" data-anim><div class="stat-num">30<sup>+</sup></div><div class="stat-label">Thương hiệu đối tác</div></div>
    </div>
  </div>
</div>

{{-- VALUES --}}
<section class="section values">
  <div class="container">
    <div class="values-header" data-anim>
      <div class="section-label" style="justify-content:center;"><div style="width:3px;height:14px;background:var(--red);"></div> Triết lý hoạt động</div>
      <h2 class="section-title">Giá Trị Cốt Lõi</h2>
    </div>
    <div class="values-grid">
      <div class="value-card" data-anim>
        <div class="val-icon"><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
        <div class="val-title">Chất Lượng</div>
        <div class="val-text">Mỗi chiếc xe đều được kiểm tra kỹ lưỡng theo tiêu chuẩn quốc tế trước khi đến tay khách hàng.</div>
      </div>
      <div class="value-card" data-anim>
        <div class="val-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
        <div class="val-title">Tận Tâm</div>
        <div class="val-text">Khách hàng là trung tâm. Chúng tôi lắng nghe, tư vấn và hỗ trợ từng cá nhân một cách chuyên nghiệp nhất.</div>
      </div>
      <div class="value-card" data-anim>
        <div class="val-icon"><svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
        <div class="val-title">Minh Bạch</div>
        <div class="val-text">Mọi thông tin về xe, giá cả và dịch vụ đều rõ ràng, không ẩn phí. Sự trung thực là nền tảng của chúng tôi.</div>
      </div>
      <div class="value-card" data-anim>
        <div class="val-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
        <div class="val-title">Hiệu Quả</div>
        <div class="val-text">Quy trình mua xe nhanh chóng, thủ tục đơn giản — chúng tôi trân trọng thời gian của bạn.</div>
      </div>
    </div>
  </div>
</section>

{{-- BRANDS --}}
<section class="brands-section">
  <div class="container">
    <div class="brands-header" data-anim>
      <div class="section-label" style="justify-content:center;">Hợp tác chính thức</div>
      <h2 class="section-title">Thương Hiệu <em style="color:var(--red);font-style:normal">Đối Tác</em></h2>
      <p style="color:var(--muted);margin-top:14px;font-size:14px;max-width:480px;margin-left:auto;margin-right:auto;">Chúng tôi là đại lý chính hãng được ủy quyền bởi các thương hiệu ô tô danh tiếng nhất thế giới.</p>
    </div>
    <div class="brands-grid" data-anim>
      <div class="brand-card"><div class="brand-logo-wrap"><svg viewBox="0 0 80 80"><path d="M40 4 L70 14 L70 52 Q70 68 40 76 Q10 68 10 52 L10 14 Z" fill="#c00" stroke="#900" stroke-width="1.5"/><path d="M40 20 Q46 18 48 22 Q50 26 47 30 L44 34 L44 52 L36 52 L36 34 L33 30 Q30 26 32 22 Q34 18 40 20Z" fill="#fff" opacity=".9"/></svg></div><div class="brand-name">Ferrari</div><div class="brand-type">Siêu xe Ý</div></div>
      <div class="brand-card"><div class="brand-logo-wrap"><svg viewBox="0 0 80 80"><rect x="5" y="5" width="70" height="70" fill="#d4a000" stroke="#b08000" stroke-width="1.5"/><ellipse cx="40" cy="46" rx="16" ry="12" fill="#111"/><circle cx="40" cy="34" r="10" fill="#111"/></svg></div><div class="brand-name">Lamborghini</div><div class="brand-type">Siêu xe Ý</div></div>
      <div class="brand-card"><div class="brand-logo-wrap"><svg viewBox="0 0 80 80"><path d="M40 6 L68 20 L68 58 Q68 72 40 74 Q12 72 12 58 L12 20 Z" fill="none" stroke="#888" stroke-width="2"/><rect x="28" y="18" width="24" height="44" fill="#222"/><rect x="12" y="18" width="16" height="44" fill="#c00"/><rect x="52" y="18" width="16" height="44" fill="#c00"/></svg></div><div class="brand-name">Porsche</div><div class="brand-type">Xe thể thao Đức</div></div>
      <div class="brand-card"><div class="brand-logo-wrap"><svg viewBox="0 0 80 80"><circle cx="40" cy="40" r="34" fill="none" stroke="#888" stroke-width="2"/><path d="M40 10 L44 34 L66 42 L44 46 L40 70 L36 46 L14 42 L36 34 Z" fill="#c8c3bc"/></svg></div><div class="brand-name">Mercedes</div><div class="brand-type">Xe sang Đức</div></div>
      <div class="brand-card"><div class="brand-logo-wrap"><svg viewBox="0 0 80 80"><circle cx="40" cy="40" r="34" fill="none" stroke="#888" stroke-width="2"/><path d="M40 10 A30 30 0 0 1 70 40 L40 40 Z" fill="#f0ebe4"/><path d="M40 40 A30 30 0 0 1 10 40 Z" fill="#f0ebe4"/><path d="M40 10 A30 30 0 0 0 10 40 L40 40 Z" fill="#0066cc"/><path d="M40 40 A30 30 0 0 0 70 40 Z" fill="#0066cc"/></svg></div><div class="brand-name">BMW</div><div class="brand-type">Xe sang Đức</div></div>
    </div>
    <div class="brands-grid-2" data-anim>
      <div class="brand-card"><div class="brand-logo-wrap"><svg viewBox="0 0 80 80"><circle cx="18" cy="40" r="14" fill="none" stroke="#aaa" stroke-width="3"/><circle cx="34" cy="40" r="14" fill="none" stroke="#aaa" stroke-width="3"/><circle cx="50" cy="40" r="14" fill="none" stroke="#aaa" stroke-width="3"/><circle cx="66" cy="40" r="14" fill="none" stroke="#aaa" stroke-width="3"/></svg></div><div class="brand-name">Audi</div><div class="brand-type">Xe sang Đức</div></div>
      <div class="brand-card"><div class="brand-logo-wrap"><svg viewBox="0 0 80 80"><ellipse cx="40" cy="40" rx="34" ry="34" fill="none" stroke="#888" stroke-width="2"/><text x="40" y="47" text-anchor="middle" font-size="38" fill="#aaa" font-family="serif" font-weight="bold">B</text></svg></div><div class="brand-name">Bentley</div><div class="brand-type">Siêu sang Anh</div></div>
      <div class="brand-card"><div class="brand-logo-wrap"><svg viewBox="0 0 80 80"><circle cx="40" cy="40" r="32" fill="none" stroke="#888" stroke-width="2"/><text x="28" y="52" text-anchor="middle" font-size="26" fill="#aaa" font-family="serif" font-weight="bold">R</text><text x="52" y="52" text-anchor="middle" font-size="26" fill="#aaa" font-family="serif" font-weight="bold">R</text></svg></div><div class="brand-name">Rolls-Royce</div><div class="brand-type">Siêu sang Anh</div></div>
      <div class="brand-card"><div class="brand-logo-wrap"><svg viewBox="0 0 80 80"><ellipse cx="40" cy="40" rx="34" ry="20" fill="none" stroke="#e66000" stroke-width="2.5"/><ellipse cx="40" cy="40" rx="34" ry="20" fill="none" stroke="#e66000" stroke-width="2.5" transform="rotate(60,40,40)"/><ellipse cx="40" cy="40" rx="34" ry="20" fill="none" stroke="#e66000" stroke-width="2.5" transform="rotate(120,40,40)"/><circle cx="40" cy="40" r="6" fill="#e66000"/></svg></div><div class="brand-name">McLaren</div><div class="brand-type">Siêu xe Anh</div></div>
    </div>
    <div class="trust-row" data-anim>
      <b>✓</b> Đại lý được cấp phép chính thức &nbsp;·&nbsp;
      <b>✓</b> Xe chính hãng 100% &nbsp;·&nbsp;
      <b>✓</b> Bảo hành toàn diện từ nhà sản xuất
    </div>
  </div>
</section>

{{-- WHY US --}}
<section class="why-section">
  <div class="container">
    <div class="why-header" data-anim>
      <div class="section-label">Sự khác biệt của chúng tôi</div>
      <h2 class="section-title">Tại Sao Chọn <em style="color:var(--red);font-style:normal">Chúng Tôi?</em></h2>
    </div>
    <div class="why-layout">
      <div class="why-features">
        <div class="why-feature" data-anim><div class="why-num">01</div><div><div class="why-feature-title">Xe chính hãng, giấy tờ minh bạch</div><div class="why-feature-text">100% xe nhập khẩu có đầy đủ chứng từ hải quan, CO/CQ nguồn gốc xuất xứ. Khách hàng được xem hồ sơ xe trước khi quyết định.</div></div></div>
        <div class="why-feature" data-anim><div class="why-num">02</div><div><div class="why-feature-title">Hỗ trợ tài chính & vay mua xe</div><div class="why-feature-text">Kết nối trực tiếp với 10+ ngân hàng. Lãi suất ưu đãi, phê duyệt trong 24 giờ. Trả góp linh hoạt từ 12 đến 60 tháng.</div></div></div>
        <div class="why-feature" data-anim><div class="why-num">03</div><div><div class="why-feature-title">Bảo hành & dịch vụ hậu mãi</div><div class="why-feature-text">Bảo hành chính hãng theo tiêu chuẩn nhà sản xuất. Hotline hỗ trợ 24/7, phản hồi trong 30 phút.</div></div></div>
        <div class="why-feature" data-anim><div class="why-num">04</div><div><div class="why-feature-title">Thử xe & tư vấn không áp lực</div><div class="why-feature-text">Lái thử miễn phí tại showroom hoặc tại địa điểm bạn chọn. Đội ngũ tư vấn chuyên nghiệp, không ép doanh số.</div></div></div>
      </div>
      <div class="why-right">
        <div class="why-highlight" data-anim="right">
          <div class="why-highlight-num">98%</div>
          <div class="why-highlight-label">Khách hàng hài lòng</div>
          <div class="why-highlight-desc">Dựa trên khảo sát sau mua năm 2024 với hơn 1.200 khách hàng.</div>
        </div>
        <div class="why-checklist" data-anim="right">
          <div class="why-checklist-title">Cam kết của chúng tôi</div>
          <div class="checklist-item"><div class="check-icon"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Giá niêm yết công khai, không phí ẩn</div>
          <div class="checklist-item"><div class="check-icon"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Hỗ trợ đăng ký biển số & bảo hiểm trọn gói</div>
          <div class="checklist-item"><div class="check-icon"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Giao xe tận nơi trên toàn quốc</div>
          <div class="checklist-item"><div class="check-icon"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Kiểm định xe độc lập trước giao dịch</div>
          <div class="checklist-item"><div class="check-icon"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Chính sách đổi trả trong 7 ngày đầu</div>
          <div class="checklist-item"><div class="check-icon"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>Hỗ trợ định giá xe cũ khi đổi lên xe mới</div>
        </div>
      </div>
    </div>
    <div class="reviews-strip" data-anim>
      <div class="reviews-track">
        <div class="review-item"><span class="review-stars">★★★★★</span><span class="review-text">"Dịch vụ xuất sắc, xe đúng như mô tả, giao xe đúng hẹn."</span><span class="review-author">— Anh Minh, TP.HCM</span></div>
        <span class="review-sep">◆</span>
        <div class="review-item"><span class="review-stars">★★★★★</span><span class="review-text">"Tư vấn tận tâm, không hề bị ép mua. Rất chuyên nghiệp."</span><span class="review-author">— Chị Hà, Hà Nội</span></div>
        <span class="review-sep">◆</span>
        <div class="review-item"><span class="review-stars">★★★★★</span><span class="review-text">"Thủ tục vay nhanh gọn, lãi suất tốt hơn tôi tưởng."</span><span class="review-author">— Anh Khoa, Đà Nẵng</span></div>
        <span class="review-sep">◆</span>
        <div class="review-item"><span class="review-stars">★★★★★</span><span class="review-text">"Hậu mãi tốt, gọi là có người hỗ trợ ngay. Uy tín số 1."</span><span class="review-author">— Anh Tuấn, Cần Thơ</span></div>
        <span class="review-sep">◆</span>
        <div class="review-item"><span class="review-stars">★★★★★</span><span class="review-text">"Dịch vụ xuất sắc, xe đúng như mô tả, giao xe đúng hẹn."</span><span class="review-author">— Anh Minh, TP.HCM</span></div>
        <span class="review-sep">◆</span>
        <div class="review-item"><span class="review-stars">★★★★★</span><span class="review-text">"Tư vấn tận tâm, không hề bị ép mua. Rất chuyên nghiệp."</span><span class="review-author">— Chị Hà, Hà Nội</span></div>
        <span class="review-sep">◆</span>
        <div class="review-item"><span class="review-stars">★★★★★</span><span class="review-text">"Thủ tục vay nhanh gọn, lãi suất tốt hơn tôi tưởng."</span><span class="review-author">— Anh Khoa, Đà Nẵng</span></div>
        <span class="review-sep">◆</span>
        <div class="review-item"><span class="review-stars">★★★★★</span><span class="review-text">"Hậu mãi tốt, gọi là có người hỗ trợ ngay. Uy tín số 1."</span><span class="review-author">— Anh Tuấn, Cần Thơ</span></div>
        <span class="review-sep">◆</span>
      </div>
    </div>
  </div>
</section>

{{-- CTA --}}
<section class="cta-section">
  <div class="container" style="position:relative">
    <h2>Sẵn Sàng Tìm <em>Chiếc Xe</em><br/>Của Bạn?</h2>
    <p>Liên hệ ngay để được tư vấn miễn phí từ đội ngũ chuyên gia của chúng tôi.</p>
    <a href="{{ route('cars.index') }}" class="btn-red">Xem xe ngay &#8594;</a>
    &nbsp;
    <a href="#" class="btn-outline">Xem showroom</a>
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