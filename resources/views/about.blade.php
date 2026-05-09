@extends('layouts.frontend')

@section('title', 'About Us - AUTO X')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
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
    --font:   'Nunito', sans-serif;
    --font-h: 'Nunito', sans-serif;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'Nunito', sans-serif;
    font-size: 16px;
    line-height: 1.85;
    letter-spacing: 0.2px;
    color: var(--text);
    background: var(--white);
  }

  .section { padding: 64px 0; }
  .container { max-width: 1240px; margin: 0 auto; padding: 0 48px; }

  .section-label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--blue);
    margin-bottom: 12px;
  }
  .section-label::before,
  .section-label::after { content: ''; width: 36px; height: 1px; background: var(--blue); flex-shrink: 0; }

  .section-title {
    font-family: 'Nunito', sans-serif;
    font-size: clamp(26px, 4vw, 50px);
    font-weight: 800;
    letter-spacing: -0.3px;
  }
  .section-title em { color: var(--black); font-style: normal; }
  .divider-line { width: 56px; height: 2px; background: var(--blue); margin: 24px 0; }

  /* ── HERO ── */
  .hero {
    position: relative; height: 480px;
    display: flex; align-items: center; justify-content: center; overflow: hidden;
  }
  .hero-bg {
    position: absolute; inset: 0;
    background: url('{{ asset('images/CTN/Mercedes-Maybach-S-Class-CTN.png') }}') center/cover no-repeat;
    background-position: center 60%;
  }
  .hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(160deg, rgba(10,10,10,0.85) 0%, rgba(10,10,10,0.68) 50%, rgba(10,10,10,0.80) 100%);
  }
  .hero-content { position: relative; text-align: center; z-index: 2; padding: 0 20px; }
  .hero-eyebrow {
    font-family: var(--font); font-size: 14px; font-weight: 600;
    letter-spacing: 4px; text-transform: uppercase; color: rgba(255,255,255,0.7);
    margin-bottom: 14px; display: flex; align-items: center; justify-content: center; gap: 12px;
  }
  .hero-eyebrow::before,
  .hero-eyebrow::after { content: ''; width: 28px; height: 1px; background: var(--blue); opacity: .8; }
  .hero h1 {
    font-family: var(--font-h);
    font-size: clamp(46px, 12vw, 106px); font-weight: 800;
    color: var(--white); line-height: .92; text-transform: uppercase; letter-spacing: -1px;
  }
  .hero h1 em { color: var(--white); font-style: normal; }
  .hero-sub { margin-top: 16px; font-size: 13px; color: rgba(255,255,255,0.6); letter-spacing: 1px; }
  .breadcrumb {
    position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);
    display: flex; align-items: center; gap: 8px; z-index: 2;
    font-size: 12px; letter-spacing: 1px; color: rgba(255,255,255,0.75);
    background: rgba(0,0,0,0.35); padding: 7px 14px; border-radius: 18px;
    backdrop-filter: blur(6px); white-space: nowrap;
  }
  .breadcrumb a { color: rgba(255,255,255,0.85) !important; font-size: 12px !important; text-decoration: none; transition: color .18s; }
  .breadcrumb a:hover { color: #fff !important; }
  .breadcrumb span { color: var(--blue); font-weight: 700; font-size: 12px !important; }

  /* ── WHO WE ARE ── */
  .who { background: var(--white); }
  .who-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
  .who-visual { position: relative; }
  .who-img-frame {
    aspect-ratio: 4/3; overflow: hidden; position: relative;
    border: 1px solid var(--gray-2);
  }
  .who-img-frame img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .6s ease; }
  .who-img-frame:hover img { transform: scale(1.04); }
  .who-img-frame::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: var(--blue); }
  .who-badge {
    position: absolute; bottom: -18px; right: -18px;
    width: 100px; height: 100px; background: var(--blue);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    clip-path: polygon(50% 0%,100% 25%,100% 75%,50% 100%,0% 75%,0% 25%);
    z-index: 2;
  }
  .who-badge strong { font-family: var(--font-h); font-size: 28px; font-weight: 800; color: #fff; line-height: 1; }
  .who-badge span { font-size: 9px; color: rgba(255,255,255,.85); letter-spacing: 1px; text-transform: uppercase; }
  .who-text p { color: var(--gray-5); margin-bottom: 16px; font-size: 15px; line-height: 1.8; }
  .who-text p:first-of-type { font-size: 17px; color: var(--black); }
  .btn-row { display: flex; gap: 12px; margin-top: 28px; flex-wrap: wrap; }

  .btn-blue {
    display: inline-flex; align-items: center; gap: 10px;
    background: var(--blue); color: var(--white);
    font-family: var(--font); font-size: 12px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; padding: 14px 28px;
    text-decoration: none; transition: background .2s, transform .15s;
    border: 1px solid var(--blue);
  }
  .btn-blue:hover { background: var(--blue-dark); border-color: var(--blue-dark); transform: translateY(-2px); color: var(--white); }

  /* ── STATS ── */
  .stats-strip {
    background: var(--gray-1);
    border-top: 1px solid var(--gray-2);
    border-bottom: 1px solid var(--gray-2);
  }
  .stats-grid { display: grid; grid-template-columns: repeat(4,1fr); }
  .stat-item {
    padding: 40px 20px; text-align: center;
    border-right: 1px solid var(--gray-2);
    transition: background .25s;
  }
  .stat-item:last-child { border-right: none; }
  .stat-item:hover { background: var(--blue-light); }
  .stat-num {
    font-family: var(--font-h); font-size: 52px; font-weight: 800;
    color: #1e40af; line-height: 1;
  }
  .stat-num sup { font-size: 20px; vertical-align: top; margin-top: 10px; }
  .stat-label { font-size: 13px; font-weight: 700; letter-spacing: 0.5px; margin-top: 6px; }

  /* ── VALUES ── */
  .values { background: var(--gray-1); }
  .values-header { text-align: center; margin-bottom: 52px; }
  .values-header .section-label { justify-content: center; }
  .values-grid {
    display: grid; grid-template-columns: repeat(4,1fr);
    border-top: 1px solid var(--gray-2);
  }
  .value-card {
    background: var(--white); padding: 36px 24px; position: relative; overflow: hidden;
    transition: background .3s;
    border-right: 1px solid var(--gray-2);
    border-bottom: 1px solid var(--gray-2);
  }
  .value-card:last-child { border-right: none; }
  .value-card::before {
    content: ''; position: absolute; top: 0; left: 0;
    width: 100%; height: 3px; background: var(--blue);
    transform: scaleX(0); transform-origin: left; transition: transform .4s ease;
  }
  .value-card:hover::before { transform: scaleX(1); }
  .value-card:hover { background: var(--blue-light); }
  .val-icon { width: 72px; height: 72px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; }
  .val-icon img { width: 64px; height: 64px; object-fit: contain; display: block; transition: transform .35s ease; filter: drop-shadow(0 4px 12px rgba(0,0,0,0.12)); }
  .value-card:hover .val-icon img { transform: scale(1.12) translateY(-3px); }
  .val-title { font-size: 15px; font-weight: 800; letter-spacing: 0.5px; margin-bottom: 10px; }
  .val-text { font-size: 14px; line-height: 1.8; color: var(--gray-5); }

  /* ── BRANDS ── */
  .brands-section { background: var(--white); padding: 80px 0; }
  .brands-header { text-align: center; margin-bottom: 52px; }

  /* ── BRANDS GRID CŨ: ẩn đi, dùng brands-grid-single thay thế ── */
  .brands-grid,
  .brands-grid-2 { display: none !important; }

  /* ── BRANDS GRID MỚI: 1 grid duy nhất, tự wrap ── */
  .brands-grid-single {
    display: grid;
    grid-template-columns: repeat(5, 1fr); /* Desktop: 5 cột, 9 brand = hàng 1 có 5, hàng 2 có 4 */
    gap: 0.5px;
    background: var(--gray-2);
  }

  .brand-card {
    background: var(--white); display: flex; flex-direction: column; align-items: center;
    justify-content: center; padding: 30px 16px; position: relative; overflow: hidden;
    cursor: pointer; transition: background .3s;
  }
  .brand-card::after {
    content: ''; position: absolute; bottom: 0; left: 0; right: 0;
    height: 2px; background: var(--blue); transform: scaleX(0);
    transform-origin: left; transition: transform .35s ease;
  }
  .brand-card:hover::after { transform: scaleX(1); }
  .brand-card:hover { background: var(--gray-1); }
  .brand-logo-wrap { width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; opacity: .5; transition: opacity .35s, transform .35s; }
  .brand-card:hover .brand-logo-wrap { opacity: 1; transform: scale(1.08); }
  .brand-name { font-size: 12px; font-weight: 700; letter-spacing: 0.5px; }
  .brand-card:hover .brand-name { color: var(--black); }
  .brand-type { font-size: 10px; color: var(--gray-3); letter-spacing: 1px; text-transform: uppercase; margin-top: 3px; transition: color .3s; }
  .brand-card:hover .brand-type { color: var(--blue); }
  .trust-row { text-align: center; margin-top: 36px; font-size: 13px; color: var(--gray-4); letter-spacing: .5px; }
  .trust-row b { color: var(--blue); font-weight: 600; }

  /* ── WHY ── */
  .why-section { background: var(--gray-1); padding: 80px 0; }
  .why-header { margin-bottom: 52px; }
  .why-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: start; }
  .why-features { display: flex; flex-direction: column; gap: 3px; }
  .why-feature {
    background: var(--white); border: 1px solid var(--gray-2); padding: 24px 26px;
    display: flex; gap: 18px; align-items: flex-start; position: relative; overflow: hidden;
    transition: border-color .3s, background .3s;
  }
  .why-feature::before {
    content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px;
    background: var(--blue); transform: scaleY(0); transform-origin: bottom; transition: transform .35s ease;
  }
  .why-feature:hover::before { transform: scaleY(1); }
  .why-feature:hover { border-color: var(--blue-border); background: var(--blue-light); }
  .why-num {
    font-family: var(--font-h); font-size: 40px; font-weight: 800;
    color: rgba(28,105,212,.12); line-height: 1; min-width: 40px; transition: color .3s;
  }
  .why-feature:hover .why-num { color: rgba(28,105,212,.30); }
  .why-feature-title { font-size: 15px; font-weight: 800; letter-spacing: 0.3px; margin-bottom: 6px; }
  .why-feature-text { font-size: 14px; line-height: 1.8; color: var(--gray-4); }

  .why-right { display: flex; flex-direction: column; gap: 18px; }
  .why-highlight { background: var(--blue); padding: 32px 28px; position: relative; overflow: hidden; }
  .why-highlight::before { content: ''; position: absolute; top: -28px; right: -28px; width: 110px; height: 110px; border-radius: 50%; background: rgba(255,255,255,.1); }
  .why-highlight-num { font-family: var(--font-h); font-size: 60px; font-weight: 800; color: #fff; line-height: 1; }
  .why-highlight-label { font-family: var(--font); font-size: 11px; font-weight: 600; letter-spacing: 3px; text-transform: uppercase; color: rgba(255,255,255,.8); margin-top: 4px; }
  .why-highlight-desc { font-size: 13px; color: rgba(255,255,255,.75); margin-top: 12px; line-height: 1.75; }

  .why-img-wrap { position: relative; overflow: hidden; border: 1px solid var(--gray-2); }
  .why-img-wrap img { width: 100%; height: 200px; object-fit: cover; display: block; transition: transform .6s ease; }
  .why-img-wrap:hover img { transform: scale(1.04); }
  .why-img-wrap::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: var(--blue); }

  .why-checklist { background: var(--white); border: 1px solid var(--gray-2); padding: 24px 28px; }
  .why-checklist-title { font-family: var(--font); font-size: 13px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--black); margin-bottom: 14px; }
  .checklist-item { display: flex; align-items: flex-start; gap: 12px; padding: 9px 0; border-bottom: 1px solid var(--gray-2); font-size: 13px; color: var(--gray-5); line-height: 1.65; }
  .checklist-item:last-child { border-bottom: none; }
  .check-icon {
    width: 18px; height: 18px; min-width: 18px;
    background: var(--blue-light); border: 1px solid var(--blue-border);
    display: flex; align-items: center; justify-content: center; margin-top: 1px;
  }
  .check-icon svg { width: 10px; height: 10px; stroke: var(--blue); fill: none; stroke-width: 2.5; }

  /* ── REVIEWS MARQUEE ── */
  .reviews-strip {
    background: var(--gray-2); border-top: 1px solid var(--gray-2); border-bottom: 1px solid var(--gray-2);
    padding: 18px 0; overflow: hidden; margin-top: 52px;
  }
  .reviews-track { display: flex; gap: 36px; white-space: nowrap; animation: marquee 30s linear infinite; }
  .reviews-track:hover { animation-play-state: paused; }
  @keyframes marquee { from{transform:translateX(0)} to{transform:translateX(-50%)} }
  .review-item { display: inline-flex; align-items: center; gap: 10px; flex-shrink: 0; }
  .review-stars { color: var(--blue); font-size: 13px; letter-spacing: 1px; }
  .review-text { font-size: 13px; color: var(--gray-4); font-style: italic; }
  .review-author { font-family: var(--font); font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--gray-4); }
  .review-sep { color: var(--gray-3); }

  /* ── FEATURES IMAGE ROW ── */
  .features-img-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 1px; background: var(--gray-2); margin-bottom: 48px; }
  .feat-img-card { background: var(--white); position: relative; overflow: hidden; }
  .feat-img-card img { width: 100%; height: 190px; object-fit: cover; display: block; filter: grayscale(.2); transition: filter .4s, transform .5s; }
  .feat-img-card:hover img { filter: grayscale(0); transform: scale(1.05); }
  .feat-img-label {
    position: absolute; bottom: 0; left: 0; right: 0; padding: 14px 16px;
    background: linear-gradient(to top, rgba(10,10,10,.85) 0%, transparent 100%);
    font-family: var(--font); font-size: 12px; font-weight: 700;
    letter-spacing: 1.5px; text-transform: uppercase; color: var(--white);
  }
  .feat-img-label span { display: block; font-size: 10px; color: var(--blue); letter-spacing: 1px; font-weight: 500; margin-bottom: 2px; }

  /* ── CTA ── */
  .cta-section { position: relative; padding: 0; overflow: hidden; text-align: center; }
  .cta-bg {
    position: absolute; inset: 0;
    background: url('{{ asset('images/CTN/Mercedes-Benz-G-Class-1-CTN.png') }}') center/cover no-repeat;
  }
  .cta-overlay { position: absolute; inset: 0; background: rgba(10,10,10,0.82); }
  .cta-inner { position: relative; z-index: 2; padding: 88px 0; }
  .cta-section h2,
  .cta-section h2 em {
    font-family: var(--font-h) !important;
    font-size: clamp(36px,6vw,74px) !important;
    font-weight: 800 !important;
    text-transform: uppercase !important;
    color: var(--white) !important;
    -webkit-text-fill-color: var(--white) !important;
    background: none !important;
    line-height: 1.1 !important;
  }
  .cta-section p { color: rgba(255,255,255,0.85); max-width: 500px; margin: 18px auto 32px; font-size: 15px; line-height: 1.75; }

  /* ── ANIMATIONS ── */
  [data-anim] { opacity: 0; transform: translateY(28px); transition: opacity .65s ease, transform .65s ease; }
  [data-anim].visible { opacity: 1; transform: translateY(0); }
  [data-anim="left"]  { transform: translateX(-28px); }
  [data-anim="left"].visible  { transform: translateX(0); }
  [data-anim="right"] { transform: translateX(28px); }
  [data-anim="right"].visible { transform: translateX(0); }

  /* ═══════════════════════════════════════
     RESPONSIVE — TABLET (≤ 900px)
  ═══════════════════════════════════════ */
  @media (max-width: 900px) {
    .container { padding: 0 28px; }
    .section { padding: 56px 0; }

    .hero { height: 400px; }

    .who-grid { grid-template-columns: 1fr; gap: 48px; }
    .who-badge { bottom: -14px; right: -8px; width: 88px; height: 88px; }
    .who-badge strong { font-size: 24px; }

    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .stat-item:nth-child(2) { border-right: none; }
    .stat-item:nth-child(3) { border-right: 1px solid var(--gray-2); border-top: 1px solid var(--gray-2); }
    .stat-item:nth-child(4) { border-top: 1px solid var(--gray-2); border-right: none; }
    .stat-num { font-size: 44px; }

    .values-grid { grid-template-columns: repeat(2, 1fr); }
    .value-card:nth-child(2) { border-right: none; }
    .value-card:nth-child(3) { border-right: 1px solid var(--gray-2); }
    .value-card:nth-child(4) { border-right: none; }

    /* Brands: 3 cột tablet */
    .brands-grid-single { grid-template-columns: repeat(3, 1fr); }

    .features-img-row { grid-template-columns: 1fr 1fr; }
    .feat-img-card:last-child { display: none; }

    .why-layout { grid-template-columns: 1fr; gap: 36px; }
    .why-right { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .why-highlight { grid-column: 1 / -1; }

    .cta-inner { padding: 64px 0; }
  }

  /* ═══════════════════════════════════════
     RESPONSIVE — MOBILE (≤ 600px)
  ═══════════════════════════════════════ */
  @media (max-width: 600px) {
    .container { padding: 0 18px; }
    .section { padding: 48px 0; }

    .hero { height: 360px; }
    .hero-eyebrow { font-size: 11px; letter-spacing: 3px; gap: 8px; }
    .hero-eyebrow::before, .hero-eyebrow::after { width: 18px; }
    .hero h1 { font-size: clamp(40px, 14vw, 64px); }
    .hero-sub { font-size: 12px; }
    .breadcrumb { font-size: 11px; padding: 6px 12px; bottom: 14px; }

    .section-label { font-size: 11px; letter-spacing: 2px; }
    .section-label::before, .section-label::after { width: 22px; }

    .who-grid { gap: 36px; }
    .who-badge { bottom: -12px; right: -6px; width: 78px; height: 78px; }
    .who-badge strong { font-size: 20px; }
    .who-badge span { font-size: 8px; }
    .who-text p { font-size: 14px; }
    .who-text p:first-of-type { font-size: 15px; }
    .btn-blue { font-size: 11px; padding: 12px 22px; letter-spacing: 2px; }
    .btn-row { margin-top: 20px; }
    .divider-line { margin: 18px 0; }

    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .stat-item { padding: 28px 12px; }
    .stat-item:nth-child(2) { border-right: none; }
    .stat-item:nth-child(3) { border-right: 1px solid var(--gray-2); border-top: 1px solid var(--gray-2); }
    .stat-item:nth-child(4) { border-top: 1px solid var(--gray-2); border-right: none; }
    .stat-num { font-size: 36px; }
    .stat-label { font-size: 12px; }

    .values-grid { grid-template-columns: 1fr 1fr; }
    .value-card { padding: 28px 18px; }
    .value-card:nth-child(odd) { border-right: 1px solid var(--gray-2); }
    .value-card:nth-child(even) { border-right: none; }
    .val-icon { width: 56px; height: 56px; margin-bottom: 14px; }
    .val-icon img { width: 52px; height: 52px; }
    .val-title { font-size: 14px; }
    .val-text { font-size: 13px; }

    /* Brands: 2 cột mobile */
    .brands-grid-single { grid-template-columns: repeat(2, 1fr); }
    .brands-section { padding: 52px 0; }
    .brand-card { padding: 22px 10px; }
    .brand-logo-wrap { width: 46px; height: 46px; margin-bottom: 8px; }
    .brand-name { font-size: 11px; }
    .brand-type { font-size: 9px; }
    .trust-row { font-size: 12px; line-height: 1.9; margin-top: 28px; }

    .why-section { padding: 48px 0; }
    .why-layout { grid-template-columns: 1fr; gap: 28px; }
    .features-img-row { grid-template-columns: 1fr; margin-bottom: 28px; }
    .feat-img-card:last-child { display: block; }
    .feat-img-card img { height: 180px; }
    .feat-img-label { font-size: 11px; padding: 12px 14px; }
    .why-feature { padding: 18px 18px; gap: 14px; }
    .why-num { font-size: 32px; min-width: 32px; }
    .why-feature-title { font-size: 14px; }
    .why-feature-text { font-size: 13px; }
    .why-right { display: flex; flex-direction: column; gap: 14px; }
    .why-highlight { padding: 28px 22px; }
    .why-highlight-num { font-size: 50px; }
    .why-img-wrap img { height: 180px; }
    .why-checklist { padding: 20px 20px; }
    .checklist-item { font-size: 13px; gap: 10px; }
    .why-header { margin-bottom: 36px; }

    .reviews-strip { margin-top: 32px; padding: 14px 0; }
    .review-text { font-size: 12px; }

    .cta-inner { padding: 52px 0; }
    .cta-section p { font-size: 14px; margin-bottom: 24px; padding: 0 8px; }
    .cta-section h2 { font-size: clamp(28px, 9vw, 48px) !important; padding: 0 8px; }
  }

  /* ═══════════════════════════════════════
     RESPONSIVE — MOBILE RẤT NHỎ (≤ 380px)
  ═══════════════════════════════════════ */
  @media (max-width: 380px) {
    .container { padding: 0 14px; }
    .hero h1 { font-size: 38px; }
    .stat-num { font-size: 30px; }
    .values-grid { grid-template-columns: 1fr; }
    .value-card { border-right: none !important; }

    /* Brands: vẫn 2 cột ở màn rất nhỏ */
    .brands-grid-single { grid-template-columns: repeat(2, 1fr); }
  }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <div class="hero-eyebrow">Khám phá chúng tôi</div>
    <h1>Về <em>AUTO X</em></h1>
    <p class="hero-sub">Đam mê xe hơi — Sứ mệnh của chúng tôi</p>
  </div>
  <div class="breadcrumb">
    <a href="{{ url('/') }}">Home</a> &rsaquo; <span>About Us</span>
  </div>
</section>

{{-- WHO WE ARE --}}
<section class="section who">
  <div class="container">
    <div class="who-grid">
      <div class="who-visual" data-anim="left">
        <div class="who-img-frame">
          <img src="{{ asset('images/CTN/Mercedes-Benz-GLS-CTN.png') }}" alt="Luxury car showroom" loading="lazy"/>
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
          <a href="{{ route('cars.index') }}" class="btn-blue">Khám phá xe</a>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- STATS --}}
<div class="stats-strip">
  <div class="container" style="padding:0">
    <div class="stats-grid">
      <div class="stat-item">
        <div class="stat-num" data-count="15" data-suffix="+">0</div>
        <div class="stat-label">Năm kinh nghiệm</div>
      </div>
      <div class="stat-item">
        <div class="stat-num" data-count="8" data-suffix="K+">0</div>
        <div class="stat-label">Khách hàng hài lòng</div>
      </div>
      <div class="stat-item">
        <div class="stat-num" data-count="200" data-suffix="+">0</div>
        <div class="stat-label">Mẫu xe hiện có</div>
      </div>
      <div class="stat-item">
        <div class="stat-num" data-count="30" data-suffix="+">0</div>
        <div class="stat-label">Thương hiệu đối tác</div>
      </div>
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
        <div class="val-icon"><img src="https://img.icons8.com/color/96/prize.png" alt="Chất lượng"/></div>
        <div class="val-title">Chất Lượng</div>
        <div class="val-text">Mỗi chiếc xe đều được kiểm tra kỹ lưỡng theo tiêu chuẩn quốc tế trước khi đến tay khách hàng.</div>
      </div>
      <div class="value-card" data-anim>
        <div class="val-icon"><img src="https://img.icons8.com/color/96/trust.png" alt="Tận tâm"/></div>
        <div class="val-title">Tận Tâm</div>
        <div class="val-text">Khách hàng là trung tâm. Chúng tôi lắng nghe, tư vấn và hỗ trợ từng cá nhân một cách chuyên nghiệp nhất.</div>
      </div>
      <div class="value-card" data-anim>
        <div class="val-icon"><img src="https://img.icons8.com/color/96/agreement.png" alt="Minh bạch"/></div>
        <div class="val-title">Minh Bạch</div>
        <div class="val-text">Mọi thông tin về xe, giá cả và dịch vụ đều rõ ràng, không ẩn phí. Sự trung thực là nền tảng của chúng tôi.</div>
      </div>
      <div class="value-card" data-anim>
        <div class="val-icon"><img src="https://img.icons8.com/color/96/speed.png" alt="Hiệu quả"/></div>
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
      <p style="color:var(--gray-4);margin-top:14px;font-size:16px;max-width:480px;margin-left:auto;margin-right:auto;">Chúng tôi là đại lý chính hãng được ủy quyền bởi các thương hiệu ô tô danh tiếng nhất thế giới.</p>
    </div>

    <div class="brands-grid-single" data-anim>

      {{-- Mercedes-Benz --}}
      <div class="brand-card">
        <div class="brand-logo-wrap">
          <svg viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
            <circle cx="40" cy="40" r="34" fill="none" stroke="#1a1a1a" stroke-width="3"/>
            <path d="M40 10 L43.5 37.5 L68 47 L43.5 42.5 L40 70 L36.5 42.5 L12 47 L36.5 37.5 Z" fill="#1a1a1a"/>
            <circle cx="40" cy="40" r="8" fill="#1a1a1a"/>
            <circle cx="40" cy="40" r="5" fill="white"/>
          </svg>
        </div>
        <div class="brand-name">Mercedes</div>
        <div class="brand-type">Xe sang Đức</div>
      </div>

      {{-- BMW --}}
      <div class="brand-card">
        <div class="brand-logo-wrap">
          <svg viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
            <circle cx="40" cy="40" r="34" fill="#1a1a1a"/>
            <circle cx="40" cy="40" r="30" fill="white"/>
            <path d="M40 40 L40 10 A30 30 0 0 0 10 40 Z" fill="#0066B1"/>
            <path d="M40 40 L40 70 A30 30 0 0 0 70 40 Z" fill="#0066B1"/>
            <line x1="40" y1="10" x2="40" y2="70" stroke="white" stroke-width="3"/>
            <line x1="10" y1="40" x2="70" y2="40" stroke="white" stroke-width="3"/>
            <circle cx="40" cy="40" r="34" fill="none" stroke="#1a1a1a" stroke-width="7"/>
            <circle cx="40" cy="40" r="27" fill="none" stroke="white" stroke-width="2.5"/>
          </svg>
        </div>
        <div class="brand-name">BMW</div>
        <div class="brand-type">Xe sang Đức</div>
      </div>

      {{-- Rolls-Royce --}}
      <div class="brand-card">
        <div class="brand-logo-wrap">
          <svg viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
            <circle cx="40" cy="40" r="34" fill="none" stroke="#1a1a1a" stroke-width="2.5"/>
            <text x="22" y="52" font-size="28" fill="#1a1a1a" font-family="Georgia, serif" font-weight="bold" letter-spacing="-2">RR</text>
            <line x1="14" y1="22" x2="66" y2="22" stroke="#1a1a1a" stroke-width="1.5"/>
            <line x1="14" y1="60" x2="66" y2="60" stroke="#1a1a1a" stroke-width="1.5"/>
          </svg>
        </div>
        <div class="brand-name">Rolls-Royce</div>
        <div class="brand-type">Siêu sang Anh</div>
      </div>

      {{-- Audi --}}
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

 {{-- VinFast --}}
<div class="brand-card">
  <div class="brand-logo-wrap" style="display:flex; align-items:center; justify-content:center;">
    <svg viewBox="0 0 200 60" xmlns="http://www.w3.org/2000/svg" style="width:180px; height:auto;">
      <!-- Chữ V cách điệu -->
      <polygon points="10,5 24,5 40,45 56,5 70,5 40,55" fill="#63666a"/>
      <!-- Chữ INFAST -->
      <text x="82" y="40" font-family="'Arial Black', Arial, sans-serif"
            font-size="26" font-weight="900" letter-spacing="1.5" fill="#003DA5">INFAST</text>
      <!-- Chữ V trong text (ghép với polygon) -->
      <text x="82" y="40" font-family="'Arial Black', Arial, sans-serif"
            font-size="26" font-weight="900" letter-spacing="1.5" fill="#939599">INFAST</text>
    </svg>
  </div>
  <div class="brand-name">VinFast</div>
  <div class="brand-type">Xe điện Việt Nam</div>
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

    <div class="features-img-row" data-anim>
      <div class="feat-img-card">
        <img src="{{ asset('images/CTN/Mercedes-Benz-G-Class-CTN.png') }}" alt="Diverse cars" loading="lazy"/>
        <div class="feat-img-label"><span>01</span>Đa dạng mẫu xe</div>
      </div>
      <div class="feat-img-card">
        <img src="{{ asset('images/team/suport.jpg') }}" alt="Support 24/7" loading="lazy"/>
        <div class="feat-img-label"><span>02</span>Hỗ trợ 24/7</div>
      </div>
      <div class="feat-img-card">
        <img src="{{ asset('images/testimonial/showroom.jpg') }}" alt="Authorized dealer" loading="lazy"/>
        <div class="feat-img-label"><span>03</span>Đại lý uy tín</div>
      </div>
    </div>

    <div class="why-layout">
      <div class="why-features">
        <div class="why-feature" data-anim>
          <div class="why-num">01</div>
          <div>
            <div class="why-feature-title">Xe chính hãng, giấy tờ minh bạch</div>
            <div class="why-feature-text">100% xe nhập khẩu có đầy đủ chứng từ hải quan, CO/CQ nguồn gốc xuất xứ. Khách hàng được xem hồ sơ xe trước khi quyết định.</div>
          </div>
        </div>
        <div class="why-feature" data-anim>
          <div class="why-num">02</div>
          <div>
            <div class="why-feature-title">Hỗ trợ tài chính & vay mua xe</div>
            <div class="why-feature-text">Kết nối trực tiếp với 10+ ngân hàng. Lãi suất ưu đãi, phê duyệt trong 24 giờ. Trả góp linh hoạt từ 12 đến 60 tháng.</div>
          </div>
        </div>
        <div class="why-feature" data-anim>
          <div class="why-num">03</div>
          <div>
            <div class="why-feature-title">Bảo hành & dịch vụ hậu mãi</div>
            <div class="why-feature-text">Bảo hành chính hãng theo tiêu chuẩn nhà sản xuất. Hotline hỗ trợ 24/7, phản hồi trong 30 phút.</div>
          </div>
        </div>
        <div class="why-feature" data-anim>
          <div class="why-num">04</div>
          <div>
            <div class="why-feature-title">Thử xe & tư vấn không áp lực</div>
            <div class="why-feature-text">Lái thử miễn phí tại showroom hoặc tại địa điểm bạn chọn. Đội ngũ tư vấn chuyên nghiệp, không ép doanh số.</div>
          </div>
        </div>
      </div>

      <div class="why-right">
        <div class="why-highlight" data-anim="right">
          <div class="why-highlight-num">98%</div>
          <div class="why-highlight-label">Khách hàng hài lòng</div>
          <div class="why-highlight-desc">Dựa trên khảo sát sau mua năm 2026 với hơn 1.200 khách hàng.</div>
        </div>
        <div class="why-img-wrap" data-anim="right">
          <img src="{{ asset('images/CTN/Mercedes-Benz-G-Class-CTN.png') }}" alt="Car delivery" loading="lazy"/>
        </div>
        <div class="why-checklist" data-anim="right">
          <div class="why-checklist-title">Cam kết của chúng tôi</div>
          <div class="checklist-item">
            <div class="check-icon"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>
            Giá niêm yết công khai, không phí ẩn
          </div>
          <div class="checklist-item">
            <div class="check-icon"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>
            Hỗ trợ đăng ký biển số & bảo hiểm trọn gói
          </div>
          <div class="checklist-item">
            <div class="check-icon"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>
            Giao xe tận nơi trên toàn quốc
          </div>
          <div class="checklist-item">
            <div class="check-icon"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>
            Kiểm định xe độc lập trước giao dịch
          </div>
          <div class="checklist-item">
            <div class="check-icon"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>
            Chính sách đổi trả trong 7 ngày đầu
          </div>
          <div class="checklist-item">
            <div class="check-icon"><svg viewBox="0 0 12 12"><polyline points="2,6 5,9 10,3"/></svg></div>
            Hỗ trợ định giá xe cũ khi đổi lên xe mới
          </div>
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
      <h2>Sẵn Sàng Tìm Chiếc Xe<br/>Của Bạn?</h2>
      <p>Liên hệ ngay để được tư vấn miễn phí từ đội ngũ chuyên gia của chúng tôi.</p>
      <a href="{{ route('cars.index') }}" class="btn-blue">Xem xe ngay &#8594;</a>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
  // Scroll reveal
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('visible');
        observer.unobserve(e.target);
      }
    });
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