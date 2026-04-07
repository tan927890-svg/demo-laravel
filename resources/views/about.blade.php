@extends('layouts.frontend')

@section('title', 'About Us - AUTO X')

@push('styles')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Rajdhani:wght@500;600;700&family=Barlow+Condensed:wght@600;700;800&display=swap');

  :root {
    --gold: #b8973a;
    --gold-dark: #8a6d1e;
    --gold-light: rgba(184,151,58,0.10);
    --gold-border: rgba(184,151,58,0.28);
    --bg: #f5f0e8;
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

  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'Rajdhani', sans-serif; background: var(--bg); color: var(--text); }

  .section { padding: 96px 0; }
  .container { max-width: 1240px; margin: 0 auto; padding: 0 48px; }
  .section-label {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: 4px; text-transform: uppercase; color: var(--gold);
    margin-bottom: 10px; display: flex; align-items: center; gap: 10px;
  }
  .section-label::before { content: ''; width: 36px; height: 1px; background: var(--gold); flex-shrink: 0; }
  .section-label::after { content: ''; width: 36px; height: 1px; background: var(--gold); flex-shrink: 0; }
  .section-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(34px,4vw,56px); font-weight: 800;
    text-transform: uppercase; color: var(--dark); letter-spacing: -.5px;
  }
  .section-title em { color: var(--gold); font-style: normal; }
  .divider-line { width: 56px; height: 2px; background: var(--gold); margin: 24px 0; }

  /* HERO */
  .hero {
    position: relative; height: 520px;
    display: flex; align-items: center; justify-content: center; overflow: hidden;
  }
  .hero-bg {
    position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1600&q=80') center/cover no-repeat;
  }
  .hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(160deg, rgba(28,26,22,0.82) 0%, rgba(28,26,22,0.68) 50%, rgba(28,26,22,0.78) 100%);
  }
  .hero-content { position: relative; text-align: center; z-index: 2; }
  .hero-eyebrow {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: 5px; text-transform: uppercase; color: var(--gold);
    margin-bottom: 18px; display: flex; align-items: center; justify-content: center; gap: 14px;
  }
  .hero-eyebrow::before,.hero-eyebrow::after { content: ''; width: 36px; height: 1px; background: var(--gold); opacity: .7; }
  .hero h1 {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(60px,9vw,106px); font-weight: 800;
    color: #f5f0e8; line-height: .92; text-transform: uppercase; letter-spacing: -1px;
  }
  .hero h1 em { color: var(--gold); font-style: normal; }
  .hero-sub { margin-top: 20px; font-size: 15px; color: rgba(245,240,232,0.65); letter-spacing: 1px; }
  .breadcrumb {
    position: absolute; bottom: 28px; left: 50%; transform: translateX(-50%);
    display: flex; align-items: center; gap: 10px; z-index: 2;
    font-size: 12px; letter-spacing: 1px; color: rgba(245,240,232,0.8);
    background: rgba(28,26,22,0.36); padding: 8px 14px; border-radius: 18px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.35); backdrop-filter: blur(6px);
  }
  .breadcrumb a { color: rgba(245,240,232,0.85); text-decoration: none; transition: color .18s; }
  .breadcrumb a:hover { color: var(--gold); }
  .breadcrumb span { color: var(--gold); font-weight:700; }

  /* WHO WE ARE */
  .who { background: var(--bg); }
  .who-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
  .who-visual { position: relative; }
  .who-img-frame {
    aspect-ratio: 4/3; overflow: hidden; position: relative;
    border: 1px solid var(--border);
  }
  .who-img-frame img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .6s ease; }
  .who-img-frame:hover img { transform: scale(1.04); }
  .who-img-frame::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: var(--gold); }
  .who-badge {
    position: absolute; bottom: -18px; right: -18px;
    width: 114px; height: 114px; background: var(--gold);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    clip-path: polygon(50% 0%,100% 25%,100% 75%,50% 100%,0% 75%,0% 25%);
    z-index: 2;
  }
  .who-badge strong { font-family: 'Barlow Condensed', sans-serif; font-size: 34px; font-weight: 800; color: #fff; line-height: 1; }
  .who-badge span { font-size: 10px; color: rgba(255,255,255,.85); letter-spacing: 1px; text-transform: uppercase; }
  .who-text p { color: var(--text); margin-bottom: 18px; font-size: 15px; line-height: 1.8; }
  .who-text p:first-of-type { font-size: 16px; color: var(--dark); font-family: 'Cormorant Garamond', serif; font-size: 18px; }
  .btn-row { display: flex; gap: 12px; margin-top: 32px; }
  .btn-gold {
    display: inline-flex; align-items: center; gap: 10px;
    background: var(--gold); color: #fff;
    font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; padding: 14px 32px;
    text-decoration: none; transition: background .2s, transform .15s;
  }
  .btn-gold:hover { background: var(--gold-dark); transform: translateY(-2px); }
  .btn-outline {
    display: inline-flex; align-items: center; gap: 10px;
    background: transparent; color: var(--dark);
    font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; padding: 13px 32px;
    text-decoration: none; border: 1px solid var(--border); transition: border-color .2s, color .2s;
  }
  .btn-outline:hover { border-color: var(--gold); color: var(--gold); }

  /* STATS */
  .stats-strip { background: var(--gold); }
  .stats-grid { display: grid; grid-template-columns: repeat(4,1fr); border-left: 1px solid rgba(255,255,255,.2); }
  .stat-item { padding: 44px 28px; text-align: center; border-right: 1px solid rgba(255,255,255,.2); transition: background .2s; }
  .stat-item:hover { background: rgba(0,0,0,.08); }
  .stat-num { font-family: 'Barlow Condensed', sans-serif; font-size: 60px; font-weight: 800; color: #fff; line-height: 1; }
  .stat-num sup { font-size: 24px; vertical-align: top; margin-top: 10px; }
  .stat-label { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: 3px; text-transform: uppercase; color: rgba(255,255,255,.75); margin-top: 6px; }

  /* VALUES */
  .values { background: var(--bg2); }
  .values-header { text-align: center; margin-bottom: 60px; }
  .values-header .section-label { justify-content: center; }
  .values-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 2px; background: var(--border); }
  .value-card { background: var(--card); padding: 44px 28px; position: relative; overflow: hidden; transition: background .3s; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
  .value-card::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 3px; background: var(--gold); transform: scaleX(0); transform-origin: left; transition: transform .4s ease; }
  .value-card:hover::before { transform: scaleX(1); }
  .value-card:hover { background: var(--bg); }
  .val-icon { width: 50px; height: 50px; background: var(--gold-light); border: 1px solid var(--gold-border); display: flex; align-items: center; justify-content: center; margin-bottom: 22px; }
  .val-icon svg { width: 22px; height: 22px; stroke: var(--gold); fill: none; stroke-width: 1.5; }
  .val-title { font-family: 'Rajdhani', sans-serif; font-size: 16px; font-weight: 700; color: var(--dark); letter-spacing: 1px; text-transform: uppercase; margin-bottom: 10px; }
  .val-text { font-size: 13px; color: var(--muted); line-height: 1.85; }

  /* BRANDS */
  .brands-section { background: var(--bg); padding: 96px 0; }
  .brands-header { text-align: center; margin-bottom: 60px; }
  .brands-grid { display: grid; grid-template-columns: repeat(5,1fr); gap: 2px; background: var(--border); }
  .brands-grid-2 { display: grid; grid-template-columns: repeat(4,1fr); gap: 2px; background: var(--border); margin-top: 2px; }
  .brand-card { background: var(--card); display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 36px 20px; position: relative; overflow: hidden; cursor: pointer; transition: background .3s; }
  .brand-card::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 2px; background: var(--gold); transform: scaleX(0); transform-origin: left; transition: transform .35s ease; }
  .brand-card:hover::after { transform: scaleX(1); }
  .brand-card:hover { background: var(--bg2); }
  .brand-logo-wrap { width: 72px; height: 72px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; opacity: .55; transition: opacity .35s, transform .35s; }
  .brand-card:hover .brand-logo-wrap { opacity: 1; transform: scale(1.08); }
  .brand-name { font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--muted); transition: color .3s; }
  .brand-card:hover .brand-name { color: var(--dark); }
  .brand-type { font-size: 11px; color: var(--subtle); letter-spacing: 1px; text-transform: uppercase; margin-top: 4px; transition: color .3s; }
  .brand-card:hover .brand-type { color: var(--gold); }
  .trust-row { text-align: center; margin-top: 40px; font-size: 13px; color: var(--muted); letter-spacing: .5px; }
  .trust-row b { color: var(--gold); font-weight: 500; }

  /* WHY */
  .why-section { background: var(--bg2); padding: 96px 0; }
  .why-header { margin-bottom: 60px; }
  .why-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 56px; align-items: start; }
  .why-features { display: flex; flex-direction: column; gap: 3px; }
  .why-feature { background: var(--card); border: 1px solid var(--border); padding: 26px 30px; display: flex; gap: 22px; align-items: flex-start; position: relative; overflow: hidden; transition: border-color .3s, background .3s; }
  .why-feature::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px; background: var(--gold); transform: scaleY(0); transform-origin: bottom; transition: transform .35s ease; }
  .why-feature:hover::before { transform: scaleY(1); }
  .why-feature:hover { border-color: var(--gold-border); background: var(--bg); }
  .why-num { font-family: 'Barlow Condensed', sans-serif; font-size: 46px; font-weight: 800; color: rgba(184,151,58,.15); line-height: 1; min-width: 44px; transition: color .3s; }
  .why-feature:hover .why-num { color: rgba(184,151,58,.35); }
  .why-feature-title { font-family: 'Rajdhani', sans-serif; font-size: 16px; font-weight: 700; color: var(--dark); letter-spacing: .5px; text-transform: uppercase; margin-bottom: 8px; }
  .why-feature-text { font-size: 13px; color: var(--muted); line-height: 1.85; }
  .why-right { display: flex; flex-direction: column; gap: 22px; }
  .why-highlight { background: var(--gold); padding: 36px 30px; position: relative; overflow: hidden; }
  .why-highlight::before { content: ''; position: absolute; top: -28px; right: -28px; width: 110px; height: 110px; border-radius: 50%; background: rgba(255,255,255,.1); }
  .why-highlight-num { font-family: 'Barlow Condensed', sans-serif; font-size: 68px; font-weight: 800; color: #fff; line-height: 1; }
  .why-highlight-label { font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 600; letter-spacing: 3px; text-transform: uppercase; color: rgba(255,255,255,.8); margin-top: 4px; }
  .why-highlight-desc { font-size: 13px; color: rgba(255,255,255,.7); margin-top: 14px; line-height: 1.75; }

  /* WHY RIGHT IMAGE */
  .why-img-wrap { position: relative; overflow: hidden; border: 1px solid var(--border); }
  .why-img-wrap img { width: 100%; height: 220px; object-fit: cover; display: block; transition: transform .6s ease; }
  .why-img-wrap:hover img { transform: scale(1.04); }
  .why-img-wrap::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: var(--gold); }

  .why-checklist { background: var(--card); border: 1px solid var(--border); padding: 26px 30px; }
  .why-checklist-title { font-family: 'Rajdhani', sans-serif; font-size: 14px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--dark); margin-bottom: 16px; }
  .checklist-item { display: flex; align-items: flex-start; gap: 13px; padding: 10px 0; border-bottom: 1px solid var(--border); font-size: 13px; color: var(--text); line-height: 1.65; }
  .checklist-item:last-child { border-bottom: none; }
  .check-icon { width: 18px; height: 18px; min-width: 18px; background: var(--gold-light); border: 1px solid var(--gold-border); display: flex; align-items: center; justify-content: center; margin-top: 1px; }
  .check-icon svg { width: 10px; height: 10px; stroke: var(--gold); fill: none; stroke-width: 2.5; }

  /* REVIEWS */
  .reviews-strip { background: var(--bg3); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 20px 0; overflow: hidden; margin-top: 60px; }
  .reviews-track { display: flex; gap: 40px; white-space: nowrap; animation: marquee 30s linear infinite; }
  .reviews-track:hover { animation-play-state: paused; }
  @keyframes marquee { from{transform:translateX(0)} to{transform:translateX(-50%)} }
  .review-item { display: inline-flex; align-items: center; gap: 12px; flex-shrink: 0; }
  .review-stars { color: var(--gold); font-size: 13px; letter-spacing: 1px; }
  .review-text { font-size: 13px; color: var(--muted); font-style: italic; }
  .review-author { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--subtle); }
  .review-sep { color: var(--border); }

  /* WHY US - FEATURES IMAGE ROW */
  .features-img-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 2px; background: var(--border); margin-bottom: 56px; }
  .feat-img-card { background: var(--card); position: relative; overflow: hidden; }
  .feat-img-card img { width: 100%; height: 200px; object-fit: cover; display: block; filter: grayscale(.2); transition: filter .4s, transform .5s; }
  .feat-img-card:hover img { filter: grayscale(0); transform: scale(1.05); }
  .feat-img-label {
    position: absolute; bottom: 0; left: 0; right: 0; padding: 16px 20px;
    background: linear-gradient(to top, rgba(28,26,22,.85) 0%, transparent 100%);
    font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase; color: #f5f0e8;
  }
  .feat-img-label span { display: block; font-size: 11px; color: var(--gold); letter-spacing: 1px; font-weight: 500; margin-bottom: 2px; }

  /* CTA */
  .cta-section { position: relative; padding: 0; overflow: hidden; text-align: center; }
  .cta-bg {
    position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=1600&q=80') center/cover no-repeat;
  }
  .cta-overlay { position: absolute; inset: 0; background: rgba(28,26,22,0.80); }
  .cta-inner { position: relative; z-index: 2; padding: 100px 0; }
  .cta-section h2 { font-family: 'Barlow Condensed', sans-serif; font-size: clamp(42px,6vw,74px); font-weight: 800; text-transform: uppercase; color: #f5f0e8; line-height: 1; }
  .cta-section h2 em { color: var(--gold); font-style: normal; }
  .cta-section p { color: rgba(245,240,232,0.65); max-width: 500px; margin: 20px auto 36px; font-size: 15px; }

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
  <div class="hero-bg"></div>
  <div class="hero-overlay"></div>
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
          <img src="https://images.unsplash.com/photo-1567818735868-e71b99932e29?w=800&q=80" alt="Luxury car showroom" loading="lazy"/>
        </div>
        <div class="who-badge"><strong>15+</strong><span>Năm</span></div>
      </div>
      <div class="who-text" data-anim="right">
        <div class="section-label">Câu chuyện của chúng tôi</div>
        <h2 class="section-title">Chúng Tôi Là<br/>Ai?</h2>
        <div class="divider-line"></div>
        <p>AUTO X được thành lập với niềm đam mê bất tận dành cho những chiếc xe hơi đẳng cấp.</p>
        <p>Với hơn 15 năm hoạt động, chúng tôi đã phục vụ hàng nghìn khách hàng, cung cấp những mẫu xe mới nhất từ các thương hiệu hàng đầu thế giới.</p>
        <p>Đội ngũ chuyên gia luôn sẵn sàng tư vấn và đồng hành cùng bạn trong hành trình lựa chọn chiếc xe hoàn hảo nhất.</p>
        <div class="btn-row">
          <a href="{{ route('cars.index') }}" class="btn-gold">Khám phá xe</a>
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
      <div class="stat-item"><div class="stat-num" data-count="15" data-suffix="+">0</div><div class="stat-label">Năm kinh nghiệm</div></div>
      <div class="stat-item"><div class="stat-num" data-count="8" data-suffix="K+">0</div><div class="stat-label">Khách hàng hài lòng</div></div>
      <div class="stat-item"><div class="stat-num" data-count="200" data-suffix="+">0</div><div class="stat-label">Mẫu xe hiện có</div></div>
      <div class="stat-item"><div class="stat-num" data-count="30" data-suffix="+">0</div><div class="stat-label">Thương hiệu đối tác</div></div>
    </div>
  </div>
</div>

{{-- VALUES --}}
<section class="section values">
  <div class="container">
    <div class="values-header" data-anim>
      <div class="section-label" style="justify-content:center;">Triết lý hoạt động</div>
      <h2 class="section-title">Giá Trị <em>Cốt Lõi</em></h2>
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
      <h2 class="section-title">Thương Hiệu <em>Đối Tác</em></h2>
      <p style="color:var(--muted);margin-top:14px;font-size:14px;max-width:480px;margin-left:auto;margin-right:auto;">Chúng tôi là đại lý chính hãng được ủy quyền bởi các thương hiệu ô tô danh tiếng nhất thế giới.</p>
    </div>
    <div class="brands-grid" data-anim>

      {{-- Ferrari: Cavallino Rampante shield - prancing horse on red --}}
      <div class="brand-card">
        <div class="brand-logo-wrap">
          <svg viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
            <!-- Shield -->
            <path d="M40 6 L66 14 L66 46 Q66 62 40 74 Q14 62 14 46 L14 14 Z" fill="#CC0000" stroke="#990000" stroke-width="1.5"/>
            <!-- Yellow stripe at bottom -->
            <path d="M14 52 Q14 62 40 74 Q66 62 66 52 Z" fill="#FDCC02"/>
            <!-- White stripe -->
            <rect x="14" y="14" width="52" height="6" fill="#fff"/>
            <!-- Black stripe + Green stripe (Italian flag) -->
            <rect x="14" y="14" width="17" height="6" fill="#009246"/>
            <rect x="49" y="14" width="17" height="6" fill="#009246"/>
            <!-- Horse silhouette (simplified) -->
            <path d="M36 22 Q34 18 37 16 Q40 14 42 17 L43 20 Q45 19 46 21 Q47 23 45 24 L44 28 Q45 30 44 33 L42 36 Q41 38 39 37 L38 33 Q36 32 35 30 L34 26 Q33 24 36 22Z" fill="#1a1a1a"/>
            <!-- Legs -->
            <line x1="38" y1="34" x2="36" y2="42" stroke="#1a1a1a" stroke-width="2" stroke-linecap="round"/>
            <line x1="41" y1="35" x2="43" y2="43" stroke="#1a1a1a" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </div>
        <div class="brand-name">Ferrari</div>
        <div class="brand-type">Siêu xe Ý</div>
      </div>

      {{-- Lamborghini: Bull on gold shield --}}
      <div class="brand-card">
        <div class="brand-logo-wrap">
          <svg viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
            <!-- Shield outline -->
            <path d="M40 6 L66 14 L66 50 Q66 64 40 74 Q14 64 14 50 L14 14 Z" fill="#D4A017" stroke="#A07800" stroke-width="1.5"/>
            <!-- Inner shield dark -->
            <path d="M40 12 L61 18 L61 48 Q61 60 40 69 Q19 60 19 48 L19 18 Z" fill="#1a1000"/>
            <!-- Bull silhouette (charging bull) -->
            <g fill="#D4A017">
              <!-- Body -->
              <ellipse cx="40" cy="44" rx="13" ry="8" fill="#D4A017"/>
              <!-- Head -->
              <circle cx="30" cy="40" r="6" fill="#D4A017"/>
              <!-- Horns -->
              <path d="M26 36 Q22 28 18 30 Q20 34 24 37Z" fill="#D4A017"/>
              <path d="M28 35 Q26 27 30 26 Q31 31 29 36Z" fill="#D4A017"/>
              <!-- Legs -->
              <rect x="34" y="50" width="3" height="8" rx="1" fill="#D4A017"/>
              <rect x="39" y="51" width="3" height="7" rx="1" fill="#D4A017"/>
              <rect x="44" y="50" width="3" height="8" rx="1" fill="#D4A017"/>
              <rect x="49" y="49" width="3" height="9" rx="1" fill="#D4A017"/>
              <!-- Tail -->
              <path d="M53 44 Q60 40 58 36" fill="none" stroke="#D4A017" stroke-width="2" stroke-linecap="round"/>
            </g>
          </svg>
        </div>
        <div class="brand-name">Lamborghini</div>
        <div class="brand-type">Siêu xe Ý</div>
      </div>

      {{-- Porsche: Stuttgart coat of arms - horse on yellow/black --}}
      <div class="brand-card">
        <div class="brand-logo-wrap">
          <svg viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
            <!-- Outer ring -->
            <circle cx="40" cy="40" r="34" fill="none" stroke="#8B0000" stroke-width="2"/>
            <!-- Shield shape -->
            <path d="M40 10 L62 16 L62 50 Q62 64 40 70 Q18 64 18 50 L18 16 Z" fill="#1a1a1a"/>
            <!-- Left half (Stuttgart black/red) -->
            <path d="M40 10 L18 16 L18 50 Q18 64 40 70 Z" fill="#8B0000"/>
            <!-- Horizontal stripes on left -->
            <clipPath id="leftHalf"><path d="M40 10 L18 16 L18 50 Q18 64 40 70 Z"/></clipPath>
            <rect x="18" y="22" width="22" height="6" fill="#1a1a1a" clip-path="url(#leftHalf)"/>
            <rect x="18" y="34" width="22" height="6" fill="#1a1a1a" clip-path="url(#leftHalf)"/>
            <rect x="18" y="46" width="22" height="10" fill="#1a1a1a" clip-path="url(#leftHalf)"/>
            <!-- Right half yellow with antlers -->
            <path d="M40 10 L62 16 L62 50 Q62 64 40 70 Z" fill="#FDCC02"/>
            <!-- Antler/deer motif right -->
            <g fill="#1a1a1a">
              <line x1="51" y1="14" x2="51" y2="28" stroke="#1a1a1a" stroke-width="2.5"/>
              <line x1="51" y1="18" x2="56" y2="14" stroke="#1a1a1a" stroke-width="2"/>
              <line x1="51" y1="22" x2="57" y2="20" stroke="#1a1a1a" stroke-width="2"/>
              <line x1="51" y1="18" x2="46" y2="14" stroke="#1a1a1a" stroke-width="2"/>
              <line x1="51" y1="22" x2="46" y2="20" stroke="#1a1a1a" stroke-width="2"/>
            </g>
            <!-- Horse (Stuttgart) center -->
            <path d="M37 26 Q35 22 38 20 Q41 18 43 21 L44 24 Q46 23 47 25 Q47 27 45 28 L44 32 Q45 34 43 37 L41 39 Q40 40 38 39 L37 35 Q35 34 34 31 L34 27Z" fill="#1a1a1a"/>
            <!-- PORSCHE text ring hint -->
            <circle cx="40" cy="40" r="33" fill="none" stroke="#8B0000" stroke-width="1"/>
          </svg>
        </div>
        <div class="brand-name">Porsche</div>
        <div class="brand-type">Xe thể thao Đức</div>
      </div>

      {{-- Mercedes-Benz: 3-pointed star in circle --}}
      <div class="brand-card">
        <div class="brand-logo-wrap">
          <svg viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
            <!-- Outer circle -->
            <circle cx="40" cy="40" r="34" fill="none" stroke="#1a1a1a" stroke-width="3"/>
            <!-- 3-pointed star -->
            <path d="M40 10 L43.5 37.5 L68 47 L43.5 42.5 L40 70 L36.5 42.5 L12 47 L36.5 37.5 Z" fill="#1a1a1a"/>
            <!-- Inner circle -->
            <circle cx="40" cy="40" r="8" fill="#1a1a1a"/>
            <circle cx="40" cy="40" r="5" fill="white"/>
          </svg>
        </div>
        <div class="brand-name">Mercedes</div>
        <div class="brand-type">Xe sang Đức</div>
      </div>

      {{-- BMW: Blue/white roundel --}}
      <div class="brand-card">
        <div class="brand-logo-wrap">
          <svg viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
            <!-- Outer black ring -->
            <circle cx="40" cy="40" r="34" fill="#1a1a1a"/>
            <!-- White separator ring -->
            <circle cx="40" cy="40" r="30" fill="white"/>
            <!-- Fill full circle white first -->
            <circle cx="40" cy="40" r="30" fill="white"/>
            <!-- Top-left quadrant: Blue -->
            <path d="M40 40 L40 10 A30 30 0 0 0 10 40 Z" fill="#0066B1"/>
            <!-- Bottom-right quadrant: Blue -->
            <path d="M40 40 L40 70 A30 30 0 0 0 70 40 Z" fill="#0066B1"/>
            <!-- Cross dividers white -->
            <line x1="40" y1="10" x2="40" y2="70" stroke="white" stroke-width="3"/>
            <line x1="10" y1="40" x2="70" y2="40" stroke="white" stroke-width="3"/>
            <!-- Outer black ring -->
            <circle cx="40" cy="40" r="34" fill="none" stroke="#1a1a1a" stroke-width="7"/>
            <!-- Inner white separator -->
            <circle cx="40" cy="40" r="27" fill="none" stroke="white" stroke-width="2.5"/>
          </svg>
        </div>
        <div class="brand-name">BMW</div>
        <div class="brand-type">Xe sang Đức</div>
      </div>

    </div>
    <div class="brands-grid-2" data-anim>

      {{-- Audi: 4 interlocking rings --}}
      <div class="brand-card">
        <div class="brand-logo-wrap">
          <svg viewBox="0 0 100 40" xmlns="http://www.w3.org/2000/svg">
            <circle cx="15" cy="20" r="13" fill="none" stroke="#1a1a1a" stroke-width="3.5"/>
            <circle cx="38" cy="20" r="13" fill="none" stroke="#1a1a1a" stroke-width="3.5"/>
            <circle cx="61" cy="20" r="13" fill="none" stroke="#1a1a1a" stroke-width="3.5"/>
            <circle cx="84" cy="20" r="13" fill="none" stroke="#1a1a1a" stroke-width="3.5"/>
          </svg>
        </div>
        <div class="brand-name">Audi</div>
        <div class="brand-type">Xe sang Đức</div>
      </div>

      {{-- Bentley: Flying B wings --}}
      <div class="brand-card">
        <div class="brand-logo-wrap">
          <svg viewBox="0 0 100 60" xmlns="http://www.w3.org/2000/svg">
            <!-- Wings left -->
            <path d="M50 30 Q35 10 5 15 Q20 22 30 30 Q20 38 5 45 Q35 50 50 30Z" fill="#5C4A1E" stroke="#8B6914" stroke-width="1"/>
            <!-- Wings right -->
            <path d="M50 30 Q65 10 95 15 Q80 22 70 30 Q80 38 95 45 Q65 50 50 30Z" fill="#5C4A1E" stroke="#8B6914" stroke-width="1"/>
            <!-- Center circle with B -->
            <circle cx="50" cy="30" r="14" fill="#5C4A1E" stroke="#8B6914" stroke-width="1.5"/>
            <text x="50" y="35" text-anchor="middle" font-size="18" fill="#D4AF37" font-family="Georgia, serif" font-weight="bold">B</text>
          </svg>
        </div>
        <div class="brand-name">Bentley</div>
        <div class="brand-type">Siêu sang Anh</div>
      </div>

      {{-- Rolls-Royce: Spirit of Ecstasy / RR monogram --}}
      <div class="brand-card">
        <div class="brand-logo-wrap">
          <svg viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
            <!-- Circle -->
            <circle cx="40" cy="40" r="34" fill="none" stroke="#1a1a1a" stroke-width="2.5"/>
            <!-- Double RR monogram -->
            <text x="22" y="52" font-size="28" fill="#1a1a1a" font-family="Georgia, serif" font-weight="bold" letter-spacing="-2">RR</text>
            <!-- Top line decoration -->
            <line x1="14" y1="22" x2="66" y2="22" stroke="#1a1a1a" stroke-width="1.5"/>
            <!-- Bottom line decoration -->
            <line x1="14" y1="60" x2="66" y2="60" stroke="#1a1a1a" stroke-width="1.5"/>
          </svg>
        </div>
        <div class="brand-name">Rolls-Royce</div>
        <div class="brand-type">Siêu sang Anh</div>
      </div>

      {{-- McLaren: Swoosh / Speedmark --}}
      <div class="brand-card">
        <div class="brand-logo-wrap">
          <svg viewBox="0 0 100 60" xmlns="http://www.w3.org/2000/svg">
            <!-- McLaren speedmark - orange arc swoosh -->
            <path d="M10 42 Q30 8 50 10 Q70 8 90 42" fill="none" stroke="#FF6600" stroke-width="5" stroke-linecap="round"/>
            <path d="M20 48 Q40 18 50 20 Q60 18 80 48" fill="none" stroke="#FF6600" stroke-width="4" stroke-linecap="round" opacity=".5"/>
            <!-- Triangle peak -->
            <path d="M45 12 L50 5 L55 12 Z" fill="#FF6600"/>
          </svg>
        </div>
        <div class="brand-name">McLaren</div>
        <div class="brand-type">Siêu xe Anh</div>
      </div>

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
      <h2 class="section-title">Tại Sao Chọn <em>Chúng Tôi?</em></h2>
    </div>

    {{-- 3 feature images --}}
    <div class="features-img-row" data-anim>
      <div class="feat-img-card">
        <img src="https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?w=600&q=80" alt="Diverse cars" loading="lazy"/>
        <div class="feat-img-label"><span>01</span>Đa dạng mẫu xe</div>
      </div>
      <div class="feat-img-card">
        <img src="https://images.unsplash.com/photo-1560179707-f14e90ef3623?w=600&q=80" alt="Support 24/7" loading="lazy"/>
        <div class="feat-img-label"><span>02</span>Hỗ trợ 24/7</div>
      </div>
      <div class="feat-img-card">
        <img src="https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=600&q=80" alt="Authorized dealer" loading="lazy"/>
        <div class="feat-img-label"><span>03</span>Đại lý uy tín</div>
      </div>
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
        <div class="why-img-wrap" data-anim="right">
          <img src="https://images.unsplash.com/photo-1542362567-b07e54358753?w=800&q=80" alt="Car delivery" loading="lazy"/>
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
  <div class="cta-bg"></div>
  <div class="cta-overlay"></div>
  <div class="cta-inner">
    <div class="container" style="position:relative">
      <h2>Sẵn Sàng Tìm <em>Chiếc Xe</em><br/>Của Bạn?</h2>
      <p>Liên hệ ngay để được tư vấn miễn phí từ đội ngũ chuyên gia của chúng tôi.</p>
      <a href="{{ route('cars.index') }}" class="btn-gold">Xem xe ngay &#8594;</a>
      &nbsp;
      <a href="#" class="btn-outline" style="color:#f5f0e8;border-color:rgba(245,240,232,0.3);">Xem showroom</a>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
  // Scroll reveal
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
  }, { threshold: 0.1 });
  document.querySelectorAll('[data-anim]').forEach(el => observer.observe(el));

  // Counter animation
  function animateCount(el) {
    const target = parseInt(el.dataset.count);
    const suffix = el.dataset.suffix || '';
    const duration = 700;
    const steps = 60;
    const stepTime = duration / steps;
    let current = 0;
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    // Small delay before starting
    setTimeout(() => {
      el.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
      el.style.opacity = '1';
      el.style.transform = 'translateY(0)';
      const timer = setInterval(() => {
        current += target / steps;
        if (current >= target) {
          current = target;
          clearInterval(timer);
        }
        el.textContent = Math.floor(current) + suffix;
      }, stepTime);
    }, 200);
  }

  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting && !e.target.dataset.counted) {
        e.target.dataset.counted = '1';
        animateCount(e.target);
      }
    });
  }, { threshold: 0.5 });
  document.querySelectorAll('.stat-num[data-count]').forEach(el => counterObserver.observe(el));
</script>
@endpush