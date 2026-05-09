<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="keywords" content="AUTO X – Showroom Ô Tô" />
  <meta name="description" content="AUTO X – Showroom Ô Tô cao cấp tại TP.HCM" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'AUTO X')</title>

  <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/owl.carousel.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/settings.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />

  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>

  <style>
    *, *::before, *::after { box-sizing: border-box; }

    :root {
      --black:   #000000;
      --white:   #ffffff;
      --gray-1:  #f2f2f2;
      --gray-2:  #e0e0e0;
      --gray-3:  #cccccc;
      --gray-4:  #999999;
      --gray-5:  #1a1a1a;
      --red:     #D42B2B;
      --font:    'Inter', 'Segoe UI', sans-serif;
      --font-h:  'Nunito', 'Inter', sans-serif;
      --nav-h:   88px;
      --nav-bg:  #0d0d0d;
      --nav-border: rgba(255,255,255,0.12);
      --nav-hover:  rgba(255,255,255,0.10);
      --nav-active: rgba(255,255,255,0.18);
    }

    html { scroll-behavior: smooth; }
    body {
      background: var(--white);
      color: var(--gray-5);
      font-family: var(--font);
      font-size: 16px;
      line-height: 1.75;
      overflow-x: hidden;
      margin: 0;
      padding-top: var(--nav-h);
      -webkit-font-smoothing: antialiased;
    }
    a { text-decoration: none !important; color: inherit; }

    /* ══ NAVBAR ══ */
    #ax-navbar {
      position: fixed;
      top: 0; left: 0; right: 0;
      height: var(--nav-h);
      background: var(--nav-bg);
      display: flex;
      align-items: center;
      z-index: 9000;
      border-bottom: 1px solid var(--nav-border);
      padding: 0 24px 0 16px;
    }

    .nb-brand {
      display: flex; align-items: center; gap: 10px;
      text-decoration: none !important; flex-shrink: 0; height: var(--nav-h);
    }
    .nb-logo {
      width: 52px; height: 52px; border-radius: 50%; overflow: hidden;
      flex-shrink: 0; border: 2px solid rgba(255,255,255,0.40);
      position: relative; background: rgba(255,255,255,0.08);
    }
    .nb-logo::after {
      content: ''; position: absolute; top: 0; left: -75%;
      width: 50%; height: 100%;
      background: linear-gradient(120deg, transparent, rgba(255,255,255,0.65), transparent);
      transform: skewX(-25deg); animation: nb-shine 7s infinite;
    }
    @keyframes nb-shine {
      0%   { left: -75%; opacity: 0; } 10%  { opacity: 1; }
      25%  { left: 125%; opacity: 0; } 100% { left: 125%; opacity: 0; }
    }
    .nb-logo img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
    .nb-brand-text { display: flex; flex-direction: column; }
    .nb-brand-text strong { display: block; font-family: var(--font-h); font-size: 16px; font-weight: 800; color: #fff; letter-spacing: 2px; text-transform: uppercase; line-height: 1.2; }
    .nb-brand-text span { display: block; font-size: 9px; color: rgba(255,255,255,0.55); letter-spacing: 1.8px; text-transform: uppercase; font-weight: 500; line-height: 1.5; }
    .nb-brand-text .nb-tagline { font-size: 9px; color: rgba(255,255,255,0.55); letter-spacing: 1.2px; text-transform: uppercase; font-weight: 600; font-family: var(--font-h); }

    .nb-nav { display: flex; align-items: center; height: var(--nav-h); justify-content: center; flex: 1; }

    .nb-item {
      display: flex; align-items: center; gap: 7px;
      padding: 6px 14px; margin: 0 2px;
      border-radius: 8px;
      color: #fff !important; font-family: var(--font); font-size: 14px; font-weight: 600;
      white-space: nowrap; text-decoration: none !important; cursor: pointer;
      transition: background .15s; position: relative;
    }
    .nb-item i { font-size: 13px; color: rgba(255,255,255,0.70) !important; }
    .nb-item:hover { background: rgba(255,255,255,0.10); }
    .nb-item.nb-active { background: rgba(255,255,255,0.15); }
    .nb-item span { color: #fff !important; }

    /* Standard dropdown */
    .nb-drop-wrap { position: relative; height: var(--nav-h); display: flex; align-items: center; }
    .nb-dropdown {
      position: absolute; top: 100%; left: 0;
      background: #0d0d0d; border: 1px solid rgba(255,255,255,0.14);
      border-top: 2px solid #333; border-radius: 0 0 12px 12px;
      min-width: 240px; padding: 6px 0 10px;
      display: none; z-index: 99999; box-shadow: 0 12px 32px rgba(0,0,0,0.5);
    }
    .nb-drop-wrap:hover .nb-dropdown, .nb-dropdown:hover { display: block; }

    .nb-drop-label {
      padding: 8px 18px 3px; font-family: var(--font-h); font-size: 10px;
      font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,0.38);
    }
    .nb-dropdown a {
      display: flex; align-items: center; gap: 8px; padding: 9px 18px;
      color: rgba(255,255,255,0.78) !important; font-size: 13.5px; font-weight: 400;
      text-decoration: none !important; transition: background .15s, color .15s, padding-left .15s; white-space: nowrap;
    }
    .nb-dropdown a:hover { background: rgba(255,255,255,0.08); color: #fff !important; padding-left: 24px; }
    .nb-dropdown .nb-drop-all {
      color: rgba(255,255,255,0.65) !important; font-weight: 600; font-size: 13px;
      border-top: 1px solid rgba(255,255,255,0.10); margin-top: 6px; padding-top: 10px;
    }
    .nb-dropdown .nb-drop-all:hover { color: #fff !important; }

    /* ══ MEGA DROPDOWN (Xem Xe) – Light / VinFast style ══ */
    .nb-mega-wrap {
      position: fixed; top: var(--nav-h); left: 0; right: 0;
      background: #fff;
      border: none;
      border-top: 3px solid #0d0d0d;
      border-bottom: 1px solid #e0e0e0;
      border-radius: 0;
      width: 100%;
      display: none; z-index: 99999;
      box-shadow: 0 8px 24px rgba(0,0,0,0.10);
      overflow: hidden;
    }
    .nb-drop-wrap:hover .nb-mega-wrap,
    .nb-mega-wrap:hover { display: block; }

    /* Tab bar */
    .nb-mega-tabbar {
      display: flex;
      justify-content: center;
      background: #fff;
      border-bottom: 2px solid #efefef;
      padding: 0 24px;
      gap: 0;
    }
    .nb-mega-taббtn {
      flex: unset;
      padding: 14px 28px;
      background: transparent; border: none;
      border-bottom: 3px solid transparent;
      margin-bottom: -2px;
      color: #999;
      font-family: var(--font); font-size: 12px;
      font-weight: 700; letter-spacing: 1px; text-transform: uppercase;
      cursor: pointer; transition: all .15s;
      display: flex; align-items: center; gap: 8px;
    }
    .nb-mega-taббtn:hover { color: #333; }
    .nb-mega-taббtn.active { color: #0d0d0d; border-bottom-color: #0d0d0d; }

    /* Panels */
    .nb-mega-body { display: flex; }
    .nb-mega-panel { display: none; width: 100%; padding: 16px 40px 14px; }
    .nb-mega-panel.active { display: block; }

    /* ── 1 hàng ngang ── */
    .nb-car-grid {
      display: flex;
      flex-direction: row;
      flex-wrap: nowrap;
      gap: 0;
      justify-content: space-evenly;
      overflow-x: auto;
      scrollbar-width: none;
    }
    .nb-car-grid::-webkit-scrollbar { display: none; }

    .nb-car-card {
      display: flex; flex-direction: column; align-items: center;
      padding: 12px 16px 14px; border-radius: 10px;
      text-decoration: none !important;
      transition: background .15s; cursor: pointer; gap: 10px;
      flex: 1; min-width: 110px; max-width: 160px;
    }
    .nb-car-card:hover { background: #f4f4f4; }
    .nb-car-card:hover .nb-car-card-name { color: #000 !important; }

    .nb-car-card-img {
      width: 130px; height: 80px; object-fit: contain;
      filter: drop-shadow(0 2px 8px rgba(0,0,0,0.13));
      transition: transform .2s;
    }
    .nb-car-card:hover .nb-car-card-img { transform: scale(1.07) translateY(-3px); }

    .nb-car-card-img-placeholder {
      width: 130px; height: 80px;
      background: #f3f3f3; border-radius: 6px;
      display: flex; align-items: center; justify-content: center;
    }
    .nb-car-card-img-placeholder i { color: #ccc; font-size: 22px; }

    .nb-car-card-name {
      font-family: var(--font); font-size: 13px; font-weight: 800;
      color: #111 !important; text-align: center;
      letter-spacing: 0.5px; text-transform: uppercase; line-height: 1.3;
      transition: color .15s;
    }
    .nb-car-card-price { display: none; }

    /* Mega footer */
    .nb-mega-footer {
      display: flex;
      border-top: 1px solid #efefef;
      background: #fafafa;
    }
    .nb-mega-footer a {
      flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px;
      padding: 13px 16px; color: #555 !important;
      font-size: 12px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;
      text-decoration: none !important; transition: background .15s, color .15s;
      border-right: 1px solid #efefef;
    }
    .nb-mega-footer a:last-child { border-right: none; }
    .nb-mega-footer a:hover { background: #f0f0f0; color: #000 !important; }
    .nb-mega-footer a i { font-size: 12px; opacity: 0.6; }

    /* Right side */
    .nb-right { display: flex; align-items: center; gap: 8px; justify-content: flex-end; flex-shrink: 0; }

    .nb-search-wrap { position: relative; }
    .nb-search {
      display: flex; align-items: center; gap: 8px; padding: 7px 12px;
      border-radius: 8px; background: rgba(255,255,255,0.07);
      border: 1px solid rgba(255,255,255,0.18); cursor: text; transition: border-color .15s, background .15s;
    }
    .nb-search:focus-within { border-color: rgba(255,255,255,0.45); background: rgba(255,255,255,0.12); }
    .nb-search i { color: rgba(255,255,255,0.55); font-size: 12px; }
    #ax-search-input { background: transparent; border: none; outline: none; color: #fff; font-family: var(--font); font-size: 13px; width: 160px; }
    #ax-search-input::placeholder { color: rgba(255,255,255,0.32); }

    .ax-search-dropdown {
      position: absolute; top: calc(100% + 6px); right: 0;
      background: #fff; border: 1px solid #e0e0e0; border-top: 3px solid #0d0d0d;
      box-shadow: 0 8px 24px rgba(0,0,0,.15); max-height: 380px; overflow-y: auto;
      display: none; z-index: 99999; border-radius: 0 0 8px 8px; min-width: 280px;
    }
    .ax-search-dropdown.show { display: block; }
    .ax-search-item { display: flex; align-items: center; gap: 12px; padding: 10px 14px; cursor: pointer; border-bottom: 1px solid #f0f0f0; text-decoration: none; transition: background .15s; }
    .ax-search-item:hover { background: #f8f8f8; }
    .ax-search-item-img { width: 60px; height: 42px; object-fit: cover; border-radius: 5px; flex-shrink: 0; background: #eee; }
    .ax-search-item-img-placeholder { width: 60px; height: 42px; background: #eee; border-radius: 5px; flex-shrink: 0; }
    .ax-search-item-name { font-size: 13.5px; font-weight: 500; color: #1a1a1a; }
    .ax-search-item-name em { font-style: normal; font-weight: 700; background: rgba(0,0,0,0.08); padding: 0 2px; border-radius: 2px; }
    .ax-search-item-price { font-size: 12px; color: #888; margin-top: 2px; }
    .ax-search-empty { padding: 20px 14px; font-size: 13px; color: #999; text-align: center; }
    .ax-search-loading { padding: 14px; text-align: center; font-size: 12px; color: #aaa; }
    .ax-search-footer { padding: 10px 14px; border-top: 1px solid #eee; font-size: 12px; color: #333; font-weight: 600; text-align: center; cursor: pointer; transition: background .15s; }
    .ax-search-footer:hover { background: #f5f5f5; }

    .nb-book-btn {
      display: flex; align-items: center; gap: 7px; padding: 8px 16px;
      border-radius: 8px; background: #fff; border: none; cursor: pointer;
      transition: background .15s, transform .12s; text-decoration: none !important;
      color: #000 !important; font-family: var(--font-h); font-size: 12px;
      font-weight: 800; letter-spacing: 0.4px; text-transform: uppercase; white-space: nowrap; flex-shrink: 0;
    }
    .nb-book-btn:hover { background: #f0f0f0; transform: translateY(-1px); }
    .nb-book-btn i { font-size: 12px; color: #000; }

    .nb-toggle {
      display: none; align-items: center; justify-content: center;
      width: 40px; height: 40px; border-radius: 8px;
      background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.25);
      cursor: pointer; color: #fff; font-size: 16px; flex-shrink: 0; margin-left: 8px;
    }

    .nb-mobile-menu {
      display: none; position: fixed; top: var(--nav-h); left: 0; right: 0;
      background: #0d0d0d; border-bottom: 1px solid rgba(255,255,255,0.12);
      z-index: 8999; padding: 8px 0 16px;
      max-height: calc(100vh - var(--nav-h)); overflow-y: auto;
    }
    .nb-mobile-menu.open { display: block; }
    .nb-mobile-menu a { display: flex; align-items: center; gap: 10px; padding: 12px 20px; color: rgba(255,255,255,0.85) !important; font-size: 14px; font-weight: 500; text-decoration: none !important; border-bottom: 1px solid rgba(255,255,255,0.06); transition: background .15s; }
    .nb-mobile-menu a:hover { background: rgba(255,255,255,0.08); color: #fff !important; }
    .nb-mobile-menu a i { width: 18px; font-size: 13px; color: rgba(255,255,255,0.55); }
    .nb-mobile-label { padding: 10px 20px 3px; font-size: 10px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,0.35); }
    .nb-mobile-divider { height: 1px; background: rgba(255,255,255,0.10); margin: 6px 0; }
    .nb-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 8998; top: var(--nav-h); }
    .nb-overlay.show { display: block; }

    main { min-height: 60vh; }

    /* ══ FOOTER ══ */
    .ax-footer { background: #0a0a0a; color: var(--gray-3); font-size: 14px; }
    .ax-footer-cols { padding: 48px 48px 36px; display: grid; grid-template-columns: 1fr 1.8fr 1fr 1.5fr; gap: 40px; border-bottom: 1px solid #1e1e1e; }
    .ax-footer-col h6 { font-family: var(--font-h); font-size: 18px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; color: #fff !important; margin: 0 0 20px; padding-bottom: 12px; position: relative; }
    .ax-footer-col h6::after { content: ""; position: absolute; left: 0; bottom: 0; width: 40px; height: 2px; background: #fff; }
    .ax-footer-logo-col { display: flex; flex-direction: column; gap: 12px; padding-top: 4px; }
    .ax-footer-logo { width: 62px; height: 62px; border-radius: 50%; overflow: hidden; border: 2px solid #333; background: #000; flex-shrink: 0; position: relative; }
    .ax-footer-logo img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
    .ax-footer-brand-text strong { display: block; font-family: var(--font-h); font-size: 24px; font-weight: 800; color: #fff; letter-spacing: 3px; text-transform: uppercase; line-height: 1.1; }
    .ax-footer-brand-text .sub { display: block; font-size: 10.5px; color: var(--gray-3); letter-spacing: 2px; text-transform: uppercase; margin-top: 2px; font-weight: 500; }
    .ax-footer-brand-text .tagline { display: block; font-size: 11px; color: rgba(255,255,255,0.65); letter-spacing: 1px; text-transform: uppercase; margin-top: 4px; font-family: var(--font-h); font-weight: 700; }
    .ax-footer-logo::after { content: ''; position: absolute; top: 0; left: -75%; width: 50%; height: 100%; background: linear-gradient(120deg, transparent, rgba(255,255,255,0.8), transparent); transform: skewX(-25deg); animation: shine-footer 7s infinite; }
    @keyframes shine-footer { 0% { left: -75%; opacity: 0; } 10% { opacity: 1; } 25% { left: 125%; opacity: 0; } 100% { left: 125%; opacity: 0; } }
    .ax-contact-list { list-style: none; padding: 0; margin: 0 0 24px; }
    .ax-contact-list li { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 11px; font-size: 14px; color: var(--gray-3); }
    .ax-contact-list i { font-size: 13px; margin-top: 3px; flex-shrink: 0; width: 16px; }
    .ax-contact-list .fa-map-marker { color: #e74c3c !important; }
    .ax-contact-list .fa-phone { color: #f5f5f5 !important; }
    .ax-contact-list .fa-envelope-o { color: #3498db !important; }
    .ax-contact-list .fa-clock-o { color: #f2f2f2 !important; }
    .ax-contact-list a { color: var(--gray-3) !important; transition: color .18s; }
    .ax-contact-list a:hover { color: var(--white) !important; }
    .ax-social { display: flex; gap: 10px; list-style: none; padding: 0; margin: 0; }
    .ax-social a { display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; border: 1px solid #2e2e2e; border-radius: 8px; font-size: 15px; transition: background .18s, border-color .18s, color .18s; }
    .ax-social a.fb { color: #1877F2 !important; } .ax-social a.yt { color: #FF0000 !important; } .ax-social a.ig { color: #E1306C !important; }
    .ax-social a.fb:hover { background: #1877F2; border-color: #1877F2; color: #fff !important; }
    .ax-social a.yt:hover { background: #FF0000; border-color: #FF0000; color: #fff !important; }
    .ax-social a.ig:hover { background: #E1306C; border-color: #E1306C; color: #fff !important; }
    .ax-footer-links { list-style: none; padding: 0; margin: 0; }
    .ax-footer-links li { margin-bottom: 11px; }
    .ax-footer-links a { color: var(--gray-3) !important; font-size: 15px; transition: color .18s, padding-left .18s; display: inline-block; }
    .ax-footer-links a:hover { color: var(--white) !important; padding-left: 4px; }
    .ax-newsletter-form { display: flex; margin-top: 14px; }
    .ax-newsletter-form input { flex: 1; padding: 11px 14px; font-size: 14px; background: #161616; border: 1px solid #2e2e2e; border-right: none; color: var(--white); outline: none; border-radius: 6px 0 0 6px; font-family: var(--font); }
    .ax-newsletter-form input::placeholder { color: #666; }
    .ax-newsletter-form input:focus { border-color: #fff; }
    .ax-newsletter-form button { padding: 11px 18px; background: #fff; border: 1px solid #0d0d0d; color: #000; font-size: 13px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; cursor: pointer; border-radius: 0 6px 6px 0; font-family: var(--font-h); transition: background .18s; }
    .ax-newsletter-form button:hover { background: #f0f0f0; }
    .ax-footer-bottom { padding: 18px 48px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; font-size: 13px; color: var(--gray-4); }
    .ax-footer-bottom a { color: var(--gray-4) !important; transition: color .18s; }
    .ax-footer-bottom a:hover { color: var(--white) !important; }
    .ax-footer-bottom-links { display: flex; gap: 20px; list-style: none; padding: 0; margin: 0; }

    .home-banner .owl-nav, .banner-section .owl-nav, .hero-slider .owl-nav,
    .slide-one .owl-nav, .rev-slider .owl-nav, body.home-page main .owl-nav { display: none !important; }

    .ax-slide-indicators { position: absolute; left: 28px; top: 50%; transform: translateY(-50%); display: flex; flex-direction: column; gap: 10px; z-index: 100; }
    .ax-slide-dot { display: flex; align-items: center; gap: 10px; cursor: pointer; opacity: 0.45; transition: opacity .25s; }
    .ax-slide-dot:hover { opacity: 0.75; }
    .ax-slide-dot.active { opacity: 1; }
    .ax-slide-dot-num { font-family: var(--font-h); font-size: 13px; font-weight: 700; color: #fff; letter-spacing: 0.5px; min-width: 22px; text-align: right; line-height: 1; }
    .ax-slide-dot-bar { width: 24px; height: 2px; background: rgba(255,255,255,0.4); border-radius: 2px; overflow: hidden; position: relative; transition: width .25s; }
    .ax-slide-dot.active .ax-slide-dot-bar { width: 44px; background: rgba(255,255,255,0.3); }
    .ax-slide-dot-bar::after { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 0%; background: #fff; border-radius: 2px; transition: width 0s; }
    .ax-slide-dot.active .ax-slide-dot-bar::after { width: 100%; transition: width var(--slide-duration, 5000ms) linear; }

    @media (max-width: 1100px) {
      .ax-footer-cols { grid-template-columns: 1fr 1fr; }
      #ax-search-input { width: 120px; }
    }
    @media (max-width: 900px) {
      .nb-nav, .nb-search-wrap, .nb-chat-btn { display: none !important; }
      .nb-toggle { display: flex; }
      .nb-book-btn .nb-book-text { display: none; }
      .nb-book-btn { padding: 8px 10px; }
    }
    @media (max-width: 767px) {
      .ax-footer-cols { grid-template-columns: 1fr; padding: 32px 24px; }
      .ax-footer-bottom { padding: 16px 24px; flex-direction: column; text-align: center; }
      .ax-slide-indicators { display: none; }
    }
  </style>

  @stack('styles')
</head>
<body class="{{ request()->is('/') ? 'home-page' : '' }}">

{{-- ══ NAVBAR ══ --}}
<nav id="ax-navbar">

  <a href="{{ url('/') }}" class="nb-brand">
    <div class="nb-logo">
      <img src="{{ asset('images/logo.png') }}"
           onerror="this.onerror=null;this.src='{{ asset('images/testimonial/logo.jpg') }}'"
           alt="AUTO X Logo">
    </div>
    <div class="nb-brand-text">
      <strong>AUTO X</strong>
      <span>Showroom Ô Tô Cao Cấp</span>
      <span class="nb-tagline">Lái Xe — Trải Nghiệm — Đẳng Cấp</span>
    </div>
  </a>

  <div class="nb-nav">

    <a href="{{ url('/') }}" class="nb-item {{ request()->is('/') ? 'nb-active' : '' }}">
      <i class="fa fa-home"></i><span>Trang Chủ</span>
    </a>

    <a href="{{ url('/about') }}" class="nb-item {{ request()->is('about') ? 'nb-active' : '' }}">
      <i class="fa fa-info-circle"></i><span>Giới Thiệu</span>
    </a>

    {{-- ══ MEGA DROPDOWN XEM XE ══ --}}
    @php
      $navCars = \App\Models\Car::with(['variants' => function($q){ $q->orderBy('sort_order'); }])
        ->get()->keyBy('name');

      $merNames = [
        'Mercedes-Benz E-Class','Mercedes-Benz S-Class','Mercedes-Maybach S-Class',
        'Mercedes-Benz GLE','Mercedes-Benz GLS','Mercedes-Benz G-Class','Mercedes-Maybach GLS',
        'Mercedes-AMG GT','Mercedes-Benz SL-Class','Mercedes-Benz EQS',
      ];
      $vfNames = [
        'VinFast VF 3','VinFast VF 5','VinFast VF 6',
        'VinFast VF 7','VinFast VF 8','VinFast VF 9',
      ];

      function navCarImg($car) {
        if (!$car) return null;
        foreach (['image_url','image','hero_image','thumbnail'] as $f) {
          if (!empty($car->$f)) return asset(ltrim($car->$f, '/'));
        }
        return null;
      }
      function navCarPrice($car) {
        if (!$car) return null;
        $p = $car->variants->min('price') ?? $car->price ?? null;
        return $p ? number_format($p, 0, ',', '.') . ' VNĐ' : null;
      }
    @endphp

    <div class="nb-drop-wrap" id="mega-xemxe">
      <div class="nb-item {{ request()->is('cars*') ? 'nb-active' : '' }}">
        <i class="fa fa-car"></i>
        <span>Xem Xe</span>
        <i class="fa fa-angle-down" style="font-size:10px;margin-left:2px;opacity:0.6"></i>
      </div>

      <div class="nb-mega-wrap">

        {{-- Tab bar --}}
        <div class="nb-mega-tabbar">
          <button class="nb-mega-taббtn active" data-mega-tab="mer" type="button">
            <i class="fa fa-star" style="color:#c8a84b;font-size:11px"></i> Mercedes-Benz
          </button>
          <button class="nb-mega-taббtn" data-mega-tab="vf" type="button">
            <i class="fa fa-bolt" style="color:#3b9eff;font-size:11px"></i> VinFast
          </button>
        </div>

        {{-- Mercedes panel – 1 hàng ngang --}}
        <div class="nb-mega-panel active" id="mega-panel-mer">
          <div class="nb-car-grid">
            @foreach($merNames as $mName)
              @php $mc = $navCars->get($mName); @endphp
              @if($mc)
                @php
                  $mImg   = navCarImg($mc);
                  $mPrice = navCarPrice($mc);
                  $mShort = str_replace(['Mercedes-Benz ','Mercedes-Maybach ','Mercedes-AMG '], '', $mName);
                @endphp
                <a href="{{ route('cars.show', $mc) }}" class="nb-car-card">
                  @if($mImg)
                    <img src="{{ $mImg }}" alt="{{ $mName }}" class="nb-car-card-img"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                    <div class="nb-car-card-img-placeholder" style="display:none"><i class="fa fa-car"></i></div>
                  @else
                    <div class="nb-car-card-img-placeholder"><i class="fa fa-car"></i></div>
                  @endif
                  <div class="nb-car-card-name">{{ $mShort }}</div>
                  @if($mPrice)<div class="nb-car-card-price">Từ {{ $mPrice }}</div>@endif
                </a>
              @endif
            @endforeach
          </div>
        </div>

        {{-- VinFast panel – 1 hàng ngang --}}
        <div class="nb-mega-panel" id="mega-panel-vf">
          <div class="nb-car-grid">
            @foreach($vfNames as $vName)
              @php
                $vc = $navCars->get($vName)
                   ?? $navCars->first(fn($c) => str_contains(strtolower($c->name), strtolower(str_replace('VinFast ','',$vName))));
              @endphp
              @if($vc)
                @php
                  $vImg   = navCarImg($vc);
                  $vPrice = navCarPrice($vc);
                  $vShort = preg_replace('/VinFast\s*/i','',$vc->name);
                @endphp
                <a href="{{ route('cars.show', $vc) }}" class="nb-car-card">
                  @if($vImg)
                    <img src="{{ $vImg }}" alt="{{ $vc->name }}" class="nb-car-card-img"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                    <div class="nb-car-card-img-placeholder" style="display:none"><i class="fa fa-car"></i></div>
                  @else
                    <div class="nb-car-card-img-placeholder"><i class="fa fa-car"></i></div>
                  @endif
                  <div class="nb-car-card-name">{{ $vShort }}</div>
                  @if($vPrice)<div class="nb-car-card-price">Từ {{ $vPrice }}</div>@endif
                </a>
              @endif
            @endforeach
          </div>
        </div>

        {{-- Footer --}}
        <div class="nb-mega-footer">
          <a href="{{ url('/cars') }}"><i class="fa fa-th-large"></i> Xem tất cả xe</a>
          <a href="{{ url('/cars/bang-gia') }}"><i class="fa fa-list-alt"></i> Bảng giá xe</a>
        </div>

      </div>
    </div>
    {{-- END MEGA --}}

    {{-- Dịch Vụ dropdown --}}
    <div class="nb-drop-wrap">
      <div class="nb-item {{ request()->is('services*') ? 'nb-active' : '' }}">
        <i class="fa fa-wrench"></i><span>Dịch Vụ</span>
        <i class="fa fa-angle-down" style="font-size:10px;margin-left:2px;opacity:0.6"></i>
      </div>
      <div class="nb-dropdown">
        <a href="{{ url('/services') }}"><i class="fa fa-wrench" style="width:16px;opacity:0.6"></i> Dịch Vụ</a>
        <a href="{{ route('services.booking') }}"><i class="fa fa-calendar" style="width:16px;opacity:0.6"></i> Đặt lịch trực tuyến</a>
        <a href="{{ route('services.maintenance-process') }}"><i class="fa fa-cogs" style="width:16px;opacity:0.6"></i> Quy trình bảo dưỡng nhanh</a>
        <a href="{{ route('services.maintenance-schedule') }}"><i class="fa fa-clock-o" style="width:16px;opacity:0.6"></i> Lịch bảo dưỡng định kỳ</a>
        <a href="{{ route('services.pickup-delivery') }}"><i class="fa fa-truck" style="width:16px;opacity:0.6"></i> Nhận &amp; giao xe tận nơi</a>
      </div>
    </div>

    <a href="{{ url('/news') }}" class="nb-item {{ request()->is('news*') ? 'nb-active' : '' }}">
      <i class="fa fa-newspaper-o"></i><span>Tin Tức</span>
    </a>

  </div>

  <div class="nb-right">
    <div class="nb-search-wrap">
      <div class="nb-search" id="ax-search-wrap">
        <i class="fa fa-search"></i>
        <input type="text" id="ax-search-input" placeholder="Tìm xe…" autocomplete="off">
      </div>
      <div class="ax-search-dropdown" id="ax-search-dropdown"></div>
    </div>

    <a href="{{ route('services.booking') }}" class="nb-book-btn">
      <i class="fa fa-calendar"></i>
      <span class="nb-book-text">Đặt Lịch</span>
    </a>

    <button class="nb-toggle" id="nb-toggle" aria-label="Mở menu">
      <i class="fa fa-bars"></i>
    </button>
  </div>

</nav>

{{-- Mobile menu --}}
<div class="nb-mobile-menu" id="nb-mobile-menu">
  <a href="{{ url('/') }}"><i class="fa fa-home"></i> Trang Chủ</a>
  <a href="{{ url('/about') }}"><i class="fa fa-info-circle"></i> Giới Thiệu</a>
  <div class="nb-mobile-label">Mercedes-Benz</div>
  @foreach(['Mercedes-Benz E-Class','Mercedes-Benz S-Class','Mercedes-Benz GLE','Mercedes-Benz GLS','Mercedes-Benz G-Class','Mercedes-Benz EQS'] as $mn)
    @php $mc = $navCars->get($mn); @endphp
    @if($mc)<a href="{{ route('cars.show', $mc) }}"><i class="fa fa-car"></i> {{ str_replace('Mercedes-Benz ','',$mn) }}</a>@endif
  @endforeach
  <div class="nb-mobile-label">VinFast</div>
  @foreach($vfNames as $vn)
    @php $vc = $navCars->get($vn) ?? $navCars->first(fn($c)=>str_contains(strtolower($c->name),strtolower(str_replace('VinFast ','',$vn)))); @endphp
    @if($vc)<a href="{{ route('cars.show', $vc) }}"><i class="fa fa-bolt"></i> {{ preg_replace('/VinFast\s*/i','',$vc->name) }}</a>@endif
  @endforeach
  <a href="{{ url('/cars') }}"><i class="fa fa-th-large"></i> Xem tất cả xe</a>
  <a href="{{ url('/cars/bang-gia') }}"><i class="fa fa-list-alt"></i> Bảng giá xe</a>
  <div class="nb-mobile-divider"></div>
  <div class="nb-mobile-label">Dịch Vụ</div>
  <a href="{{ url('/services') }}"><i class="fa fa-wrench"></i> Dịch Vụ</a>
  <a href="{{ route('services.booking') }}"><i class="fa fa-calendar"></i> Đặt lịch trực tuyến</a>
  <a href="{{ route('services.maintenance-process') }}"><i class="fa fa-cogs"></i> Quy trình bảo dưỡng</a>
  <a href="{{ route('services.maintenance-schedule') }}"><i class="fa fa-clock-o"></i> Lịch bảo dưỡng định kỳ</a>
  <a href="{{ route('services.pickup-delivery') }}"><i class="fa fa-truck"></i> Nhận &amp; giao xe tận nơi</a>
  <div class="nb-mobile-divider"></div>
  <a href="{{ url('/news') }}"><i class="fa fa-newspaper-o"></i> Tin Tức</a>
</div>
<div class="nb-overlay" id="nb-overlay"></div>

<main>@yield('content')</main>

<footer class="ax-footer">
  <div class="ax-footer-cols">
    <div class="ax-footer-col">
      <div class="ax-footer-logo-col">
        <div class="ax-footer-logo">
          <img src="{{ asset('images/logo.png') }}"
               onerror="this.onerror=null;this.src='{{ asset('images/testimonial/logo.jpg') }}'"
               alt="AUTO X Logo">
        </div>
        <div class="ax-footer-brand-text">
          <strong>AUTO X</strong>
          <span class="sub">Showroom Ô Tô Cao Cấp</span>
          <span class="tagline">Lái xe — Trải nghiệm — Đẳng cấp</span>
        </div>
      </div>
    </div>
    <div class="ax-footer-col">
      <h6>Thông Tin Liên Hệ</h6>
      <ul class="ax-contact-list">
        <li><i class="fa fa-map-marker"></i><span>Hẻm 2276/23 Trung Mỹ Tây, Quận 12, TP.HCM</span></li>
        <li><i class="fa fa-phone"></i><span><a href="tel:0909123456">0909 123 456</a></span></li>
        <li><i class="fa fa-envelope-o"></i><span><a href="mailto:info@autox.vn">info@autox.vn</a></span></li>
        <li><i class="fa fa-clock-o"></i><span>T2–T7: 8:00 – 18:00 | CN: 9:00 – 17:00</span></li>
      </ul>
      <ul class="ax-social">
        <li><a href="#" class="fb"><i class="fa fa-facebook"></i></a></li>
        <li><a href="#" class="yt"><i class="fa fa-youtube-play"></i></a></li>
        <li><a href="#" class="ig"><i class="fa fa-instagram"></i></a></li>
      </ul>
    </div>
    <div class="ax-footer-col">
      <h6>Liên Kết Nhanh</h6>
      <ul class="ax-footer-links">
        <li><a href="{{ url('/') }}">Trang chủ</a></li>
        <li><a href="{{ url('/about') }}">Giới thiệu</a></li>
        <li><a href="{{ url('/cars') }}">Xem xe</a></li>
        <li><a href="{{ url('/cars/bang-gia') }}">Bảng giá xe</a></li>
        <li><a href="{{ url('/services') }}">Dịch vụ</a></li>
        <li><a href="{{ url('/news') }}">Tin tức</a></li>
      </ul>
    </div>
    <div class="ax-footer-col">
      <h6>Đăng Ký Nhận Tin</h6>
      <p style="font-size:14px;color:var(--gray-3);margin-bottom:0;line-height:1.75">
        Nhận ưu đãi mới nhất, thông tin xe và chương trình khuyến mãi trực tiếp vào hộp thư của bạn.
      </p>
      <div class="ax-newsletter-form">
        <input type="email" id="ax-newsletter-email" placeholder="Nhập email của bạn…">
        <button type="button" id="ax-newsletter-btn">Đăng Ký</button>
      </div>
      <p id="ax-newsletter-msg" style="font-size:13px;margin-top:8px;display:none;line-height:1.6"></p>
      <p style="font-size:12.5px;color:#666;margin-top:10px">Chúng tôi tôn trọng quyền riêng tư. Không spam.</p>
    </div>
  </div>
  <div class="ax-footer-bottom">
    <span>© {{ date('Y') }} <a href="{{ url('/') }}">AUTO X</a>. Bảo lưu mọi quyền.</span>
    <ul class="ax-footer-bottom-links">
      <li><a href="#">Chính sách bảo mật</a></li>
      <li><a href="#">Điều khoản sử dụng</a></li>
    </ul>
  </div>
</footer>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>

<script>
  if (typeof jQuery !== 'undefined') {
    if (!$.fn.megaMenu)      $.fn.megaMenu      = function(){ return this; };
    if (!$.fn.magnificPopup) $.fn.magnificPopup = function(){ return this; };
    if (!$.fn.owlCarousel)   $.fn.owlCarousel   = function(){ return this; };
    if (!$.fn.counterUp)     $.fn.counterUp     = function(){ return this; };
    if (!$.fn.parallax)      $.fn.parallax      = function(){ return this; };
    if (!$.fn.waypoint)      $.fn.waypoint      = function(){ return this; };
    if (!$.fn.niceSelect)    $.fn.niceSelect    = function(){ return this; };
    if (!$.fn.slick)         $.fn.slick         = function(){ return this; };
  }
</script>

<script src="{{ asset('js/custom.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/custom-override.css') }}" />

<script>
document.addEventListener('DOMContentLoaded', function () {

  // ── Mobile menu ──────────────────────────────────────────────────────
  var nbToggle   = document.getElementById('nb-toggle');
  var mobileMenu = document.getElementById('nb-mobile-menu');
  var nbOverlay  = document.getElementById('nb-overlay');
  if (nbToggle) {
    nbToggle.addEventListener('click', function () {
      mobileMenu.classList.toggle('open');
      nbOverlay.classList.toggle('show');
    });
    nbOverlay.addEventListener('click', function () {
      mobileMenu.classList.remove('open');
      nbOverlay.classList.remove('show');
    });
  }

  // ── Mega tab switching ───────────────────────────────────────────────
  document.querySelectorAll('.nb-mega-taббtn').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      var tab  = this.dataset.megaTab;
      var wrap = this.closest('.nb-mega-wrap');
      wrap.querySelectorAll('.nb-mega-taббtn').forEach(function (b) { b.classList.remove('active'); });
      wrap.querySelectorAll('.nb-mega-panel').forEach(function (p) { p.classList.remove('active'); });
      this.classList.add('active');
      wrap.querySelector('#mega-panel-' + tab).classList.add('active');
    });
  });

  // ── Search ───────────────────────────────────────────────────────────
  var input    = document.getElementById('ax-search-input');
  var dropdown = document.getElementById('ax-search-dropdown');
  var swrap    = document.getElementById('ax-search-wrap');
  var timer    = null;
  if (input) {
    input.addEventListener('input', function () {
      clearTimeout(timer);
      var q = this.value.trim();
      if (q.length < 2) { dropdown.classList.remove('show'); dropdown.innerHTML = ''; return; }
      dropdown.innerHTML = '<div class="ax-search-loading"><i class="fa fa-spinner fa-spin"></i></div>';
      dropdown.classList.add('show');
      timer = setTimeout(function () { doSearch(q); }, 280);
    });
    function doSearch(q) {
      fetch('/api/cars/search?q=' + encodeURIComponent(q))
        .then(function (r) { return r.json(); })
        .then(function (data) { renderResults(data, q); })
        .catch(function () { renderResults([], q); });
    }
    function highlight(text, q) {
      var re = new RegExp('(' + q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
      return text.replace(re, '<em>$1</em>');
    }
    function formatPrice(p) { if (!p) return ''; return parseInt(p).toLocaleString('vi-VN') + ' VNĐ'; }
    function renderResults(items, q) {
      dropdown.innerHTML = '';
      if (!items || items.length === 0) {
        dropdown.innerHTML = '<div class="ax-search-empty">Không tìm thấy xe phù hợp</div>'; return;
      }
      items.forEach(function (car) {
        var a = document.createElement('a');
        a.className = 'ax-search-item'; a.href = '/cars/' + car.id;
        var imgHtml = car.image
          ? '<img class="ax-search-item-img" src="' + car.image + '" alt="">'
          : '<div class="ax-search-item-img-placeholder"></div>';
        a.innerHTML = imgHtml + '<div><div class="ax-search-item-name">' + highlight(car.name, q) + '</div><div class="ax-search-item-price">' + formatPrice(car.price) + '</div></div>';
        dropdown.appendChild(a);
      });
      var footer = document.createElement('div');
      footer.className = 'ax-search-footer';
      footer.textContent = 'Xem tất cả kết quả →';
      footer.onclick = function () { window.location.href = '/cars?search=' + encodeURIComponent(q); };
      dropdown.appendChild(footer);
    }
    document.addEventListener('click', function (e) {
      if (!swrap.contains(e.target)) dropdown.classList.remove('show');
    });
    input.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' && this.value.trim())
        window.location.href = '/cars?search=' + encodeURIComponent(this.value.trim());
    });
  }

  // ── Newsletter ───────────────────────────────────────────────────────
  var btn  = document.getElementById('ax-newsletter-btn');
  var mail = document.getElementById('ax-newsletter-email');
  var msg  = document.getElementById('ax-newsletter-msg');
  if (btn) {
    btn.addEventListener('click', function () {
      var email = mail.value.trim();
      if (!email) { showMsg('⚠ Vui lòng nhập email.', '#e67e22'); return; }
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showMsg('⚠ Email không hợp lệ.', '#e67e22'); return; }
      btn.disabled = true; btn.textContent = '...'; msg.style.display = 'none';
      fetch('{{ route("newsletter.subscribe") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
        body: JSON.stringify({ email: email }),
      })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.success) { showMsg('✅ Đăng ký thành công!', '#27ae60'); mail.value = ''; }
        else { showMsg('❌ ' + (data.errors && data.errors.email ? data.errors.email[0] : 'Có lỗi xảy ra.'), '#e74c3c'); }
      })
      .catch(function () { showMsg('❌ Không thể kết nối.', '#e74c3c'); })
      .finally(function () { btn.disabled = false; btn.textContent = 'Đăng Ký'; });
    });
    mail.addEventListener('keydown', function (e) { if (e.key === 'Enter') btn.click(); });
    function showMsg(text, color) { msg.textContent = text; msg.style.color = color; msg.style.display = 'block'; }
  }

  // ── Slide indicators ─────────────────────────────────────────────────
  if (document.body.classList.contains('home-page')) {
    var SLIDE_DURATION = 5000;
    setTimeout(function () {
      var owlEl = document.querySelector('main .owl-carousel');
      if (!owlEl) return;
      var nav = owlEl.querySelector('.owl-nav');
      if (nav) nav.style.display = 'none';
      var items = owlEl.querySelectorAll('.owl-item:not(.cloned)');
      var total = items.length;
      if (total < 2) return;
      var indWrap = document.createElement('div');
      indWrap.className = 'ax-slide-indicators';
      indWrap.style.setProperty('--slide-duration', SLIDE_DURATION + 'ms');
      for (var i = 0; i < total; i++) {
        var dot = document.createElement('div');
        dot.className = 'ax-slide-dot' + (i === 0 ? ' active' : '');
        dot.setAttribute('data-index', i);
        dot.innerHTML = '<span class="ax-slide-dot-num">' + String(i + 1).padStart(2, '0') + '</span><span class="ax-slide-dot-bar"></span>';
        indWrap.appendChild(dot);
      }
      var owlWrapper = owlEl.closest('.banner-section, .hero-slider, .slide-one, section, div') || owlEl.parentElement;
      owlWrapper.style.position = 'relative';
      owlWrapper.appendChild(indWrap);
      if (typeof jQuery !== 'undefined' && jQuery(owlEl).data('owl.carousel')) {
        var $owl = jQuery(owlEl);
        function syncDots(idx) {
          indWrap.querySelectorAll('.ax-slide-dot').forEach(function (d, di) { d.classList.toggle('active', di === idx); });
        }
        $owl.on('changed.owl.carousel', function (e) { syncDots(e.item.index % total); });
        indWrap.querySelectorAll('.ax-slide-dot').forEach(function (dot) {
          dot.addEventListener('click', function () { $owl.trigger('to.owl.carousel', [parseInt(this.getAttribute('data-index')), 400]); });
        });
      } else {
        var currentDot = 0;
        setInterval(function () {
          currentDot = (currentDot + 1) % total;
          indWrap.querySelectorAll('.ax-slide-dot').forEach(function (d, di) { d.classList.toggle('active', di === currentDot); });
        }, SLIDE_DURATION);
      }
    }, 600);
  }

});
</script>

@stack('scripts')
@include('partials.chat-widget')
</body>
</html>