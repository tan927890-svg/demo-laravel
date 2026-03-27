<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us - Concept Car Dealer</title>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Barlow:wght@300;400;500;600&family=Barlow+Condensed:wght@700;800&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --red: #e00;
      --red-dark: #b00;
      --bg: #0d0d0d;
      --bg2: #141414;
      --bg3: #1a1a1a;
      --card: #181818;
      --border: #2a2a2a;
      --text: #d4d4d4;
      --muted: #777;
      --white: #fff;
    }

    html { scroll-behavior: smooth; }
    body {
      background: var(--bg);
      color: var(--text);
      font-family: 'Barlow', sans-serif;
      font-size: 15px;
      line-height: 1.7;
      overflow-x: hidden;
    }

    /* ── NAV ── */
    nav {
      position: fixed; top: 0; left: 0; width: 100%; z-index: 100;
      background: #111;
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 40px;
      height: 72px;
      border-bottom: 1px solid #1e1e1e;
    }
    .logo {
      font-family: 'Rajdhani', sans-serif;
      font-size: 22px; font-weight: 700; letter-spacing: 1px;
      color: var(--white); text-decoration: none;
    }
    .logo span { color: var(--red); }
    .nav-links { display: flex; gap: 36px; list-style: none; }
    .nav-links a {
      font-family: 'Rajdhani', sans-serif;
      font-size: 13px; font-weight: 600;
      letter-spacing: 2px; text-transform: uppercase;
      color: var(--muted); text-decoration: none;
      transition: color .2s;
    }
    .nav-links a:hover, .nav-links a.active { color: var(--white); }
    .nav-links a.active { position: relative; }
    .nav-links a.active::after {
      content: ''; position: absolute;
      bottom: -26px; left: 50%; transform: translateX(-50%);
      width: 28px; height: 2px; background: var(--red);
    }

    /* ── HERO BANNER ── */
    .hero {
      margin-top: 72px;
      position: relative;
      height: 420px;
      background: linear-gradient(135deg, #0d0d0d 0%, #1a0000 50%, #0d0d0d 100%);
      display: flex; align-items: center; justify-content: center;
      overflow: hidden;
    }
    .hero::before {
      content: '';
      position: absolute; inset: 0;
      background:
        repeating-linear-gradient(90deg, transparent, transparent 60px, rgba(255,0,0,.03) 60px, rgba(255,0,0,.03) 61px),
        repeating-linear-gradient(0deg, transparent, transparent 60px, rgba(255,0,0,.03) 60px, rgba(255,0,0,.03) 61px);
    }
    .hero-glow {
      position: absolute;
      width: 600px; height: 300px;
      background: radial-gradient(ellipse, rgba(200,0,0,.18) 0%, transparent 70%);
      top: 50%; left: 50%; transform: translate(-50%, -50%);
      animation: pulse 4s ease-in-out infinite;
    }
    @keyframes pulse { 0%,100%{opacity:.6;transform:translate(-50%,-50%) scale(1)} 50%{opacity:1;transform:translate(-50%,-50%) scale(1.1)} }
    .hero-content { position: relative; text-align: center; }
    .hero-eyebrow {
      font-family: 'Rajdhani', sans-serif;
      font-size: 12px; font-weight: 600;
      letter-spacing: 5px; text-transform: uppercase;
      color: var(--red); margin-bottom: 16px;
      display: flex; align-items: center; justify-content: center; gap: 14px;
    }
    .hero-eyebrow::before,.hero-eyebrow::after {
      content: ''; width: 40px; height: 1px; background: var(--red); opacity: .6;
    }
    .hero h1 {
      font-family: 'Barlow Condensed', sans-serif;
      font-size: clamp(56px, 8vw, 100px);
      font-weight: 800; letter-spacing: -1px;
      color: var(--white); line-height: .95;
      text-transform: uppercase;
    }
    .hero h1 em { color: var(--red); font-style: normal; }
    .hero-sub {
      margin-top: 18px;
      font-size: 15px; color: var(--muted); letter-spacing: .5px;
    }
    /* breadcrumb */
    .breadcrumb {
      position: absolute; bottom: 28px; left: 50%; transform: translateX(-50%);
      display: flex; align-items: center; gap: 10px;
      font-size: 12px; letter-spacing: 1px; color: var(--muted);
    }
    .breadcrumb a { color: var(--muted); text-decoration: none; transition: color .2s; }
    .breadcrumb a:hover { color: var(--red); }
    .breadcrumb span { color: var(--red); }

    /* ── SECTION WRAPPER ── */
    .section { padding: 90px 0; }
    .container { max-width: 1220px; margin: 0 auto; padding: 0 40px; }

    /* ── SECTION TITLE ── */
    .section-title {
      font-family: 'Barlow Condensed', sans-serif;
      font-size: clamp(32px, 4vw, 48px);
      font-weight: 800; text-transform: uppercase;
      color: var(--white); letter-spacing: -0.5px;
    }
    .section-label {
      font-family: 'Rajdhani', sans-serif;
      font-size: 11px; font-weight: 600; letter-spacing: 4px;
      text-transform: uppercase; color: var(--red);
      margin-bottom: 10px;
      display: flex; align-items: center; gap: 10px;
    }
    .section-label::before { content: ''; width: 3px; height: 14px; background: var(--red); }

    /* ── WHO WE ARE ── */
    .who { background: var(--bg); }
    .who-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
    .who-visual {
      position: relative;
    }
    .who-img-frame {
      aspect-ratio: 4/3;
      background: var(--bg3);
      border: 1px solid var(--border);
      overflow: hidden;
      position: relative;
    }
    .who-img-frame svg { width: 100%; height: 100%; }
    .who-img-frame::after {
      content: ''; position: absolute;
      bottom: 0; left: 0; right: 0; height: 3px;
      background: var(--red);
    }
    .who-badge {
      position: absolute; bottom: -20px; right: -20px;
      width: 120px; height: 120px;
      background: var(--red);
      display: flex; flex-direction: column; align-items: center; justify-content: center;
      clip-path: polygon(50% 0%,100% 25%,100% 75%,50% 100%,0% 75%,0% 25%);
    }
    .who-badge strong {
      font-family: 'Barlow Condensed', sans-serif;
      font-size: 36px; font-weight: 800; color: #fff; line-height: 1;
    }
    .who-badge span { font-size: 10px; font-weight: 600; color: #ffccc; letter-spacing: 1px; text-transform: uppercase; }
    .who-text p { color: var(--text); margin-bottom: 20px; font-size: 15px; }
    .who-text p:first-of-type { font-size: 17px; color: #aaa; }
    .divider-line {
      width: 60px; height: 3px; background: var(--red); margin: 24px 0;
    }

    /* ── STATS STRIP ── */
    .stats-strip {
      background: var(--red);
      padding: 0;
    }
    .stats-grid {
      display: grid; grid-template-columns: repeat(4, 1fr);
      border-left: 1px solid rgba(255,255,255,.15);
    }
    .stat-item {
      padding: 40px 30px; text-align: center;
      border-right: 1px solid rgba(255,255,255,.15);
      position: relative;
    }
    .stat-item:hover { background: rgba(0,0,0,.1); }
    .stat-num {
      font-family: 'Barlow Condensed', sans-serif;
      font-size: 56px; font-weight: 800; color: #fff; line-height: 1;
    }
    .stat-num sup { font-size: 22px; vertical-align: top; margin-top: 10px; }
    .stat-label {
      font-family: 'Rajdhani', sans-serif;
      font-size: 11px; font-weight: 600; letter-spacing: 3px;
      text-transform: uppercase; color: rgba(255,255,255,.7);
      margin-top: 6px;
    }

    /* ── TEAM ── */
    .team { background: var(--bg2); }
    .team-header { margin-bottom: 56px; }
    .team-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px; }
    .team-card {
      background: var(--card);
      overflow: hidden;
      position: relative;
      cursor: pointer;
      border: 1px solid var(--border);
      transition: border-color .3s;
    }
    .team-card:hover { border-color: var(--red); }
    .team-card-img {
      aspect-ratio: 3/4;
      background: var(--bg3);
      position: relative; overflow: hidden;
    }
    /* Placeholder portrait SVG */
    .team-card-img svg { width: 100%; height: 100%; display: block; }
    .team-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(to top, rgba(0,0,0,.85) 0%, transparent 50%);
      opacity: 0; transition: opacity .3s;
    }
    .team-card:hover .team-overlay { opacity: 1; }
    .team-social {
      position: absolute; bottom: 20px; left: 0; right: 0;
      display: flex; justify-content: center; gap: 12px;
      transform: translateY(20px); opacity: 0;
      transition: all .3s .05s;
    }
    .team-card:hover .team-social { transform: translateY(0); opacity: 1; }
    .soc-btn {
      width: 36px; height: 36px; border: 1px solid rgba(255,255,255,.4);
      background: rgba(255,255,255,.1); border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      color: #fff; font-size: 13px; text-decoration: none;
      transition: background .2s, border-color .2s;
    }
    .soc-btn:hover { background: var(--red); border-color: var(--red); }
    .team-info { padding: 20px 22px; }
    .team-name {
      font-family: 'Rajdhani', sans-serif;
      font-size: 18px; font-weight: 700; color: var(--white);
      letter-spacing: .5px;
    }
    .team-role {
      font-size: 12px; letter-spacing: 2px; text-transform: uppercase;
      color: var(--red); margin-top: 3px;
    }
    .team-stripe {
      height: 3px; background: var(--border);
      position: relative; overflow: hidden;
      transition: background .3s;
    }
    .team-card:hover .team-stripe { background: var(--red); }

    /* ── VALUES ── */
    .values { background: var(--bg); }
    .values-header { text-align: center; margin-bottom: 60px; }
    .values-header .section-label { justify-content: center; }
    .values-header .section-label::before,.values-header .section-label::after {
      content:''; width:30px; height:1px; background:var(--red); opacity:.5;
    }
    .values-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 1px; background: var(--border); }
    .value-card {
      background: var(--card); padding: 44px 30px;
      position: relative; overflow: hidden;
      transition: background .3s;
    }
    .value-card::before {
      content: ''; position: absolute;
      top: 0; left: 0; width: 3px; height: 0;
      background: var(--red);
      transition: height .4s ease;
    }
    .value-card:hover::before { height: 100%; }
    .value-card:hover { background: var(--bg3); }
    .val-icon {
      width: 52px; height: 52px;
      background: rgba(200,0,0,.1);
      border: 1px solid rgba(200,0,0,.2);
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 24px;
    }
    .val-icon svg { width: 24px; height: 24px; stroke: var(--red); fill: none; stroke-width: 1.5; }
    .val-title {
      font-family: 'Rajdhani', sans-serif;
      font-size: 17px; font-weight: 700;
      color: var(--white); letter-spacing: 1px;
      text-transform: uppercase; margin-bottom: 12px;
    }
    .val-text { font-size: 13px; color: var(--muted); line-height: 1.8; }

    /* ── TIMELINE ── */
    .timeline-section { background: var(--bg2); }
    .timeline-wrap { position: relative; margin-top: 56px; }
    .timeline-line {
      position: absolute;
      left: 50%; transform: translateX(-50%);
      top: 0; bottom: 0; width: 1px;
      background: var(--border);
    }
    .timeline-item {
      display: grid; grid-template-columns: 1fr 60px 1fr;
      gap: 0; margin-bottom: 56px; align-items: start;
    }
    .timeline-item:nth-child(odd) .tl-content { grid-column: 1; text-align: right; }
    .timeline-item:nth-child(odd) .tl-empty  { grid-column: 3; }
    .timeline-item:nth-child(even) .tl-content { grid-column: 3; text-align: left; }
    .timeline-item:nth-child(even) .tl-empty  { grid-column: 1; }
    .tl-dot-col { grid-column: 2; display: flex; justify-content: center; padding-top: 6px; }
    .tl-dot {
      width: 14px; height: 14px; border-radius: 50%;
      border: 2px solid var(--red); background: var(--bg2);
      position: relative; z-index: 2;
      transition: background .3s;
    }
    .timeline-item:hover .tl-dot { background: var(--red); }
    .tl-year {
      font-family: 'Barlow Condensed', sans-serif;
      font-size: 13px; font-weight: 700; letter-spacing: 2px;
      color: var(--red); text-transform: uppercase;
      margin-bottom: 6px;
    }
    .tl-title {
      font-family: 'Rajdhani', sans-serif;
      font-size: 18px; font-weight: 700; color: var(--white);
      margin-bottom: 8px;
    }
    .tl-desc { font-size: 13px; color: var(--muted); line-height: 1.8; }

    /* ── CTA ── */
    .cta-section {
      background: var(--bg);
      padding: 100px 0;
      position: relative; overflow: hidden;
      text-align: center;
    }
    .cta-section::before {
      content: '';
      position: absolute; inset: 0;
      background: radial-gradient(ellipse 80% 60% at 50% 100%, rgba(180,0,0,.15) 0%, transparent 70%);
    }
    .cta-section h2 {
      font-family: 'Barlow Condensed', sans-serif;
      font-size: clamp(40px, 6vw, 72px);
      font-weight: 800; text-transform: uppercase;
      color: var(--white); line-height: 1;
      position: relative;
    }
    .cta-section h2 em { color: var(--red); font-style: normal; }
    .cta-section p { color: var(--muted); max-width: 520px; margin: 20px auto 36px; font-size: 15px; position: relative; }
    .btn-red {
      display: inline-flex; align-items: center; gap: 10px;
      background: var(--red); color: #fff;
      font-family: 'Rajdhani', sans-serif;
      font-size: 13px; font-weight: 700; letter-spacing: 3px;
      text-transform: uppercase; padding: 16px 36px;
      text-decoration: none; position: relative;
      border: none; cursor: pointer;
      transition: background .2s, transform .2s;
    }
    .btn-red:hover { background: var(--red-dark); transform: translateY(-2px); }
    .btn-outline {
      display: inline-flex; align-items: center; gap: 10px;
      background: transparent; color: var(--white);
      font-family: 'Rajdhani', sans-serif;
      font-size: 13px; font-weight: 700; letter-spacing: 3px;
      text-transform: uppercase; padding: 15px 36px;
      text-decoration: none; position: relative;
      border: 1px solid rgba(255,255,255,.25); cursor: pointer;
      transition: border-color .2s, color .2s;
      margin-left: 16px;
    }
    .btn-outline:hover { border-color: var(--red); color: var(--red); }

    /* ── FOOTER ── */
    footer {
      background: #0a0a0a;
      border-top: 1px solid #1e1e1e;
      padding: 28px 40px;
      display: flex; align-items: center; justify-content: space-between;
    }
    footer p { font-size: 12px; color: var(--muted); letter-spacing: 1px; }
    footer a { color: var(--red); text-decoration: none; }

    /* ── ANIMATIONS ── */
    [data-anim] { opacity: 0; transform: translateY(30px); transition: opacity .7s ease, transform .7s ease; }
    [data-anim].visible { opacity: 1; transform: translateY(0); }
    [data-anim="left"] { transform: translateX(-30px); }
    [data-anim="left"].visible { transform: translateX(0); }
    [data-anim="right"] { transform: translateX(30px); }
    [data-anim="right"].visible { transform: translateX(0); }
  </style>
</head>
<body>

<!-- NAV -->
<nav>
  <a class="logo" href="#"><span>Concept</span> Car Dealer</a>
  <ul class="nav-links">
  <li><a href="{{ url('/') }}">HOME</a></li>
  <li><a href="{{ url('/about') }}" class="active">ABOUT US</a></li>
  <li><a href="{{ url('/contact') }}">CONTACT US</a></li>
  <li><a href="{{ url('/faq') }}">FAQ</a></li>
</ul>
</nav>
<!-- HERO -->
<section class="hero">
  <div class="hero-glow"></div>
  <div class="hero-content">
    <div class="hero-eyebrow">Khám phá chúng tôi</div>
    <h1>Về <em>Chúng Tôi</em></h1>
    <p class="hero-sub">Đam mê xe hơi — Sứ mệnh của chúng tôi</p>
  </div>
  <div class="breadcrumb">
    <a href="#">Home</a> &rsaquo; <span>About Us</span>
  </div>
</section>

<!-- WHO WE ARE -->
<section class="section who">
  <div class="container">
    <div class="who-grid">
      <div class="who-visual" data-anim="left">
        <div class="who-img-frame">
          <!-- Decorative car silhouette SVG -->
          <svg viewBox="0 0 600 450" xmlns="http://www.w3.org/2000/svg">
            <rect width="600" height="450" fill="#111"/>
            <!-- Grid lines -->
            <line x1="0" y1="225" x2="600" y2="225" stroke="#1e1e1e" stroke-width="1"/>
            <line x1="300" y1="0" x2="300" y2="450" stroke="#1e1e1e" stroke-width="1"/>
            <!-- Car silhouette -->
            <g transform="translate(60,140)">
              <!-- Body -->
              <path d="M20 200 Q20 170 40 170 L80 120 Q120 80 200 72 L330 72 Q390 72 420 110 L460 170 L470 170 Q490 170 490 200 L490 220 Q480 240 460 240 L80 240 Q40 240 20 220 Z" fill="#1a0000" stroke="#c00" stroke-width="1.5"/>
              <!-- Windows -->
              <path d="M100 120 L130 85 Q160 72 220 72 L310 72 Q350 74 360 100 L380 120 Z" fill="#0d0d0d" stroke="#333" stroke-width="1"/>
              <line x1="250" y1="72" x2="260" y2="120" stroke="#333" stroke-width="1"/>
              <!-- Wheels -->
              <circle cx="130" cy="240" r="50" fill="#0a0a0a" stroke="#c00" stroke-width="1.5"/>
              <circle cx="130" cy="240" r="30" fill="#111" stroke="#555" stroke-width="1"/>
              <circle cx="130" cy="240" r="8" fill="#c00"/>
              <circle cx="370" cy="240" r="50" fill="#0a0a0a" stroke="#c00" stroke-width="1.5"/>
              <circle cx="370" cy="240" r="30" fill="#111" stroke="#555" stroke-width="1"/>
              <circle cx="370" cy="240" r="8" fill="#c00"/>
              <!-- Headlight -->
              <path d="M18 180 L35 175 L35 195 L18 192 Z" fill="#c00" opacity=".7"/>
              <!-- Glow -->
              <ellipse cx="250" cy="240" rx="200" ry="15" fill="rgba(200,0,0,.08)"/>
            </g>
            <!-- Red accent stripe -->
            <rect x="0" y="0" width="600" height="3" fill="#c00"/>
          </svg>
        </div>
        <div class="who-badge">
          <strong>15+</strong>
          <span>Năm</span>
        </div>
      </div>
      <div class="who-text" data-anim="right">
        <div class="section-label">Câu chuyện của chúng tôi</div>
        <h2 class="section-title">Chúng Tôi Là<br/>Ai?</h2>
        <div class="divider-line"></div>
        <p>Concept Car Dealer được thành lập với niềm đam mê bất tận dành cho những chiếc xe hơi đẳng cấp. Chúng tôi không chỉ bán xe — chúng tôi mang đến trải nghiệm và phong cách sống.</p>
        <p>Với hơn 15 năm hoạt động trong ngành, chúng tôi đã phục vụ hàng nghìn khách hàng trên toàn quốc, cung cấp những mẫu xe mới nhất từ các thương hiệu hàng đầu thế giới như Ferrari, Lamborghini, Porsche, Mercedes-Benz và nhiều hãng xe cao cấp khác.</p>
        <p>Đội ngũ chuyên gia của chúng tôi luôn sẵn sàng tư vấn và đồng hành cùng bạn trong hành trình lựa chọn chiếc xe hoàn hảo nhất.</p>
        <div style="display:flex;gap:12px;margin-top:32px">
          <a href="#" class="btn-red">Khám phá xe</a>
          <a href="#" class="btn-outline">Liên hệ</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- STATS -->
<div class="stats-strip">
  <div class="container" style="padding:0">
    <div class="stats-grid">
      <div class="stat-item" data-anim>
        <div class="stat-num">15<sup>+</sup></div>
        <div class="stat-label">Năm kinh nghiệm</div>
      </div>
      <div class="stat-item" data-anim>
        <div class="stat-num">8K<sup>+</sup></div>
        <div class="stat-label">Khách hàng hài lòng</div>
      </div>
      <div class="stat-item" data-anim>
        <div class="stat-num">200<sup>+</sup></div>
        <div class="stat-label">Mẫu xe hiện có</div>
      </div>
      <div class="stat-item" data-anim>
        <div class="stat-num">30<sup>+</sup></div>
        <div class="stat-label">Thương hiệu đối tác</div>
      </div>
    </div>
  </div>
</div>

<!-- VALUES -->
<section class="section values">
  <div class="container">
    <div class="values-header" data-anim>
      <div class="section-label">Triết lý hoạt động</div>
      <h2 class="section-title">Giá Trị Cốt Lõi</h2>
    </div>
    <div class="values-grid">
      <div class="value-card" data-anim>
        <div class="val-icon">
          <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        </div>
        <div class="val-title">Chất Lượng</div>
        <div class="val-text">Mỗi chiếc xe đều được kiểm tra kỹ lưỡng theo tiêu chuẩn quốc tế trước khi đến tay khách hàng.</div>
      </div>
      <div class="value-card" data-anim>
        <div class="val-icon">
          <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div class="val-title">Tận Tâm</div>
        <div class="val-text">Khách hàng là trung tâm. Chúng tôi lắng nghe, tư vấn và hỗ trợ từng cá nhân một cách chuyên nghiệp nhất.</div>
      </div>
      <div class="value-card" data-anim>
        <div class="val-icon">
          <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        </div>
        <div class="val-title">Minh Bạch</div>
        <div class="val-text">Mọi thông tin về xe, giá cả và dịch vụ đều rõ ràng, không ẩn phí. Sự trung thực là nền tảng của chúng tôi.</div>
      </div>
      <div class="value-card" data-anim>
        <div class="val-icon">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div class="val-title">Hiệu Quả</div>
        <div class="val-text">Quy trình mua xe nhanh chóng, thủ tục đơn giản — chúng tôi trân trọng thời gian của bạn.</div>
      </div>
    </div>
  </div>
</section>

<!-- TEAM -->
<section class="section team">
  <div class="container">
    <div class="team-header" data-anim>
      <div class="section-label">Những người đứng sau</div>
      <h2 class="section-title">Đội Ngũ Chuyên Gia</h2>
    </div>
    <div class="team-grid">

      <!-- Member 1 -->
      <div class="team-card" data-anim>
        <div class="team-card-img">
          <svg viewBox="0 0 400 520" xmlns="http://www.w3.org/2000/svg">
            <rect width="400" height="520" fill="#141414"/>
            <rect x="0" y="0" width="400" height="520" fill="url(#g1)"/>
            <defs>
              <linearGradient id="g1" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#1a0000"/>
                <stop offset="100%" stop-color="#0d0d0d"/>
              </linearGradient>
            </defs>
            <circle cx="200" cy="180" r="80" fill="#222" stroke="#333" stroke-width="1"/>
            <circle cx="200" cy="160" r="55" fill="#2a2a2a"/>
            <ellipse cx="200" cy="420" rx="130" ry="80" fill="#1e1e1e"/>
            <text x="200" y="175" text-anchor="middle" font-size="64" fill="#444">👤</text>
            <rect x="160" y="90" width="80" height="4" fill="#c00" rx="2"/>
          </svg>
          <div class="team-overlay"></div>
          <div class="team-social">
            <a class="soc-btn" href="#">in</a>
            <a class="soc-btn" href="#">tw</a>
          </div>
        </div>
        <div class="team-stripe"></div>
        <div class="team-info">
          <div class="team-name">Nguyễn Văn Hùng</div>
          <div class="team-role">Giám đốc điều hành</div>
        </div>
      </div>

      <!-- Member 2 -->
      <div class="team-card" data-anim>
        <div class="team-card-img">
          <svg viewBox="0 0 400 520" xmlns="http://www.w3.org/2000/svg">
            <rect width="400" height="520" fill="#141414"/>
            <rect x="0" y="0" width="400" height="520" fill="url(#g2)"/>
            <defs>
              <linearGradient id="g2" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%" stop-color="#0d0d0d"/>
                <stop offset="100%" stop-color="#1a0000"/>
              </linearGradient>
            </defs>
            <circle cx="200" cy="180" r="80" fill="#222" stroke="#333" stroke-width="1"/>
            <circle cx="200" cy="160" r="55" fill="#2a2a2a"/>
            <ellipse cx="200" cy="420" rx="130" ry="80" fill="#1e1e1e"/>
            <text x="200" y="175" text-anchor="middle" font-size="64" fill="#444">👤</text>
            <rect x="160" y="90" width="80" height="4" fill="#c00" rx="2"/>
          </svg>
          <div class="team-overlay"></div>
          <div class="team-social">
            <a class="soc-btn" href="#">in</a>
            <a class="soc-btn" href="#">tw</a>
          </div>
        </div>
        <div class="team-stripe"></div>
        <div class="team-info">
          <div class="team-name">Trần Thị Lan</div>
          <div class="team-role">Trưởng phòng kinh doanh</div>
        </div>
      </div>

      <!-- Member 3 -->
      <div class="team-card" data-anim>
        <div class="team-card-img">
          <svg viewBox="0 0 400 520" xmlns="http://www.w3.org/2000/svg">
            <rect width="400" height="520" fill="#141414"/>
            <rect x="0" y="0" width="400" height="520" fill="url(#g3)"/>
            <defs>
              <linearGradient id="g3" x1="1" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#1a0000"/>
                <stop offset="100%" stop-color="#111"/>
              </linearGradient>
            </defs>
            <circle cx="200" cy="180" r="80" fill="#222" stroke="#333" stroke-width="1"/>
            <circle cx="200" cy="160" r="55" fill="#2a2a2a"/>
            <ellipse cx="200" cy="420" rx="130" ry="80" fill="#1e1e1e"/>
            <text x="200" y="175" text-anchor="middle" font-size="64" fill="#444">👤</text>
            <rect x="160" y="90" width="80" height="4" fill="#c00" rx="2"/>
          </svg>
          <div class="team-overlay"></div>
          <div class="team-social">
            <a class="soc-btn" href="#">in</a>
            <a class="soc-btn" href="#">tw</a>
          </div>
        </div>
        <div class="team-stripe"></div>
        <div class="team-info">
          <div class="team-name">Lê Minh Khoa</div>
          <div class="team-role">Chuyên gia tư vấn</div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- TIMELINE -->
<section class="section timeline-section">
  <div class="container">
    <div style="text-align:center;margin-bottom:56px" data-anim>
      <div class="section-label" style="justify-content:center">Hành trình phát triển</div>
      <h2 class="section-title">Lịch Sử Của Chúng Tôi</h2>
    </div>
    <div class="timeline-wrap">
      <div class="timeline-line"></div>

      <div class="timeline-item">
        <div class="tl-content" data-anim="left">
          <div class="tl-year">2009</div>
          <div class="tl-title">Thành lập</div>
          <div class="tl-desc">Concept Car Dealer được thành lập tại TP.HCM với tầm nhìn trở thành nhà phân phối xe cao cấp hàng đầu Việt Nam.</div>
        </div>
        <div class="tl-dot-col"><div class="tl-dot"></div></div>
        <div class="tl-empty"></div>
      </div>

      <div class="timeline-item">
        <div class="tl-empty"></div>
        <div class="tl-dot-col"><div class="tl-dot"></div></div>
        <div class="tl-content" data-anim="right">
          <div class="tl-year">2013</div>
          <div class="tl-title">Mở rộng showroom</div>
          <div class="tl-desc">Khai trương showroom thứ 2 tại Hà Nội, đánh dấu bước phát triển ra toàn quốc với hơn 50 mẫu xe cao cấp.</div>
        </div>
      </div>

      <div class="timeline-item">
        <div class="tl-content" data-anim="left">
          <div class="tl-year">2017</div>
          <div class="tl-title">Đối tác Ferrari chính thức</div>
          <div class="tl-desc">Trở thành đại lý chính thức của Ferrari tại Đông Nam Á, mang đến những mẫu xe siêu sang cho khách hàng Việt.</div>
        </div>
        <div class="tl-dot-col"><div class="tl-dot"></div></div>
        <div class="tl-empty"></div>
      </div>

      <div class="timeline-item">
        <div class="tl-empty"></div>
        <div class="tl-dot-col"><div class="tl-dot"></div></div>
        <div class="tl-content" data-anim="right">
          <div class="tl-year">2024</div>
          <div class="tl-title">Nền tảng số & EV</div>
          <div class="tl-desc">Ra mắt nền tảng mua xe trực tuyến và bổ sung dòng xe điện cao cấp, hướng tới tương lai xanh và bền vững.</div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="container" style="position:relative">
    <h2>Sẵn Sàng Tìm <em>Chiếc Xe</em><br/>Của Bạn?</h2>
    <p>Liên hệ ngay để được tư vấn miễn phí từ đội ngũ chuyên gia của chúng tôi.</p>
    <a href="#" class="btn-red">Liên hệ ngay &#8594;</a>
    <a href="#" class="btn-outline">Xem showroom</a>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <p>&copy; 2024 <a href="#">Concept Car Dealer</a>. All rights reserved.</p>
  <p style="font-size:12px;color:#444">HOME &nbsp;|&nbsp; ABOUT US &nbsp;|&nbsp; CONTACT US &nbsp;|&nbsp; FAQ</p>
</footer>

<script>
  // Scroll animation
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
  }, { threshold: 0.1 });
  document.querySelectorAll('[data-anim]').forEach(el => observer.observe(el));
</script>
</body>
</html>