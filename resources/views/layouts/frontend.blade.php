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
      --blue:    #1c69d4;

      --font:    'Inter', 'Segoe UI', sans-serif;
      --font-h:  'Nunito', 'Inter', sans-serif;

      --sb-w:       260px;
      --sb-bg:      #0d0d0d;
      --sb-bg2:     #050505;
      --sb-dark:    #000000;
      --sb-gold:    #ffffff;
      --sb-gold-l:  #f0f0f0;
      --sb-hover:   rgba(255,255,255,0.10);
      --sb-active:  rgba(255,255,255,0.18);
      --sb-border:  rgba(255,255,255,0.18);
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
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }
    a { text-decoration: none !important; color: inherit; }

    /* ── LAYOUT ── */
    .ax-layout { display: flex; min-height: 100vh; }

    /* ── SIDEBAR ── */
    #ax-sidebar {
      width: var(--sb-w);
      min-width: var(--sb-w);
      background: #0d0d0d;
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; left: 0;
      height: 100vh;
      z-index: 9000;
      overflow-y: auto;
      overflow-x: clip;
      transition: width .28s ease, transform .28s ease;
    }
    #ax-sidebar::-webkit-scrollbar { width: 4px; }
    #ax-sidebar::-webkit-scrollbar-track { background: transparent; }
    #ax-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.20); border-radius: 4px; }

    /* ── COLLAPSED ── */
    #ax-sidebar.collapsed { width: 64px; min-width: 64px; }
    .ax-main-wrap { transition: margin-left .28s ease; }
    .ax-main-wrap.collapsed { margin-left: 64px; }

    #ax-sidebar.collapsed .sb-brand-text,
    #ax-sidebar.collapsed .sb-item > span,
    #ax-sidebar.collapsed .sb-sub,
    #ax-sidebar.collapsed .sb-search,
    #ax-sidebar.collapsed .sb-chat-btn span,
    #ax-sidebar.collapsed .sb-book-text { display: none !important; }

    #ax-sidebar.collapsed .sb-item { justify-content: center; padding: 12px 0; }
    #ax-sidebar.collapsed .sb-brand { justify-content: center; padding: 20px 0 16px; }
    #ax-sidebar.collapsed .sb-bottom { align-items: center; }
    #ax-sidebar.collapsed .sb-book-btn { justify-content: center; padding: 10px; width: 44px; min-width: unset; }

    /* ── BRAND ── */
    .sb-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 20px 18px 16px;
      border-bottom: 1px solid var(--sb-border);
      flex-shrink: 0;
      background: #000000;
      text-decoration: none !important;
    }
    .sb-logo {
      width: 44px; height: 44px;
      border-radius: 50%;
      overflow: hidden;
      flex-shrink: 0;
      background: rgba(255,255,255,0.08);
      border: 2px solid rgba(255,255,255,0.45);
      position: relative;
    }
    .sb-logo::after {
      content: '';
      position: absolute; top: 0; left: -75%;
      width: 50%; height: 100%;
      background: linear-gradient(120deg, transparent, rgba(255,255,255,0.65), transparent);
      transform: skewX(-25deg);
      animation: sb-shine 7s infinite;
    }
    @keyframes sb-shine {
      0%   { left: -75%; opacity: 0; }
      10%  { opacity: 1; }
      25%  { left: 125%; opacity: 0; }
      100% { left: 125%; opacity: 0; }
    }
    .sb-logo img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }

    .sb-brand-text strong {
      display: block;
      font-family: var(--font-h);
      font-size: 18px;
      font-weight: 800;
      color: #ffffff;
      letter-spacing: 2.5px;
      text-transform: uppercase;
      line-height: 1.1;
    }
    .sb-brand-text span {
      font-size: 9.5px;
      color: rgba(255,255,255,0.60);
      letter-spacing: 2.2px;
      text-transform: uppercase;
      font-weight: 500;
    }

    /* ── NAV ── */
    .sb-nav {
      flex: 1;
      padding: 6px 0 4px;
      display: flex;
      flex-direction: column;
      gap: 0;
    }

    .sb-item-wrap { position: relative; }

    .sb-item {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 13px 18px;
      border-radius: 0;
      cursor: pointer;
      transition: background .15s, color .15s;
      color: #ffffff !important;
      font-family: var(--font);
      font-size: 15px;
      font-weight: 600;
      letter-spacing: 0.3px;
      text-transform: none;
      white-space: nowrap;
      text-decoration: none !important;
      position: relative;
    }
    .sb-item i {
      font-size: 15px;
      width: 30px;
      height: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      border: 1.5px solid rgba(255,255,255,0.35) !important;
      border-radius: 8px;
      background: rgba(255,255,255,0.08) !important;
      color: #ffffff !important;
      transition: background .15s, border-color .15s;
    }
    .sb-item span { color: #ffffff !important; }
    .sb-item:hover { background: var(--sb-hover); color: #ffffff !important; }
    .sb-item:hover i { background: rgba(255,255,255,0.18) !important; border-color: rgba(255,255,255,0.65) !important; color: #ffffff !important; }
    .sb-item.sb-active { background: var(--sb-active); color: #ffffff !important; }
    .sb-item.sb-active i { background: rgba(255,255,255,0.22) !important; border-color: rgba(255,255,255,0.75) !important; color: #ffffff !important; }

    #ax-sidebar .sb-nav .sb-item,
    #ax-sidebar .sb-nav .sb-item span,
    #ax-sidebar .sb-nav .sb-item i { color: #ffffff !important; }

    /* ── INLINE SUBMENU ── */
    .sb-sub { display: none !important; }
    .sb-sub a {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 9px 16px 9px 0;
      color: rgba(255,255,255,0.75);
      font-family: var(--font);
      font-size: 13.5px;
      font-weight: 400;
      text-transform: none;
      letter-spacing: 0;
      transition: background .15s, color .15s;
      text-decoration: none !important;
      border-bottom: 1px solid rgba(255,255,255,0.07);
    }
    .sb-sub a::before {
      content: '';
      width: 4px; height: 4px;
      border-radius: 50%;
      background: rgba(255,255,255,0.35);
      flex-shrink: 0;
    }
    .sb-sub a:hover { background: rgba(255,255,255,0.08); color: #ffffff; }
    .sb-sub a:hover::before { background: #ffffff; }

    .sb-sub-label {
      padding: 8px 16px 3px 0;
      font-family: var(--font-h);
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: rgba(255,255,255,0.38);
    }

    /* ── FLYOUT ── */
    .sb-flyout {
      position: fixed;
      top: 0;
      background: #0d0d0d;
      border: none;
      border-left: 3px solid rgba(255,255,255,0.35);
      border-radius: 0 16px 16px 0;
      min-width: 260px;
      padding: 0 0 14px;
      z-index: 999999;
      box-shadow: 6px 0 32px rgba(0,0,0,0.5);
      display: none;
      flex-direction: column;
      max-height: 96vh;
      overflow-y: auto;
      pointer-events: none;
      isolation: isolate;
      transform: translateZ(0);
      will-change: transform;
    }
    .sb-flyout.show { display: flex; pointer-events: auto; }
    .sb-flyout::-webkit-scrollbar { width: 3px; }
    .sb-flyout::-webkit-scrollbar-track { background: transparent; }
    .sb-flyout::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.20); border-radius: 3px; }

    .sb-flyout-title {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 14px 18px 12px;
      font-family: var(--font-h);
      font-size: 13px;
      font-weight: 800;
      letter-spacing: 0.8px;
      text-transform: uppercase;
      color: #ffffff;
      border-bottom: 1px solid rgba(255,255,255,0.12);
      margin-bottom: 4px;
      flex-shrink: 0;
      background: #000000;
      border-radius: 0 16px 0 0;
      position: relative;
    }
    .sb-flyout-title i { font-size: 14px; color: #ffffff; }

    .sb-flyout-close {
      position: absolute;
      right: 12px; top: 50%; transform: translateY(-50%);
      width: 24px; height: 24px;
      border-radius: 50%;
      background: rgba(255,255,255,0.10);
      border: 1px solid rgba(255,255,255,0.25);
      cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      font-size: 11px;
      color: rgba(255,255,255,0.70);
      transition: background .15s, color .15s;
    }
    .sb-flyout-close:hover { background: rgba(255,255,255,0.22); color: #ffffff; }

    .sb-flyout .sb-sub-label {
      padding: 8px 18px 2px;
      color: rgba(255,255,255,0.38);
    }
    .sb-flyout a {
      display: flex;
      align-items: center;
      padding: 10px 18px;
      color: rgba(255,255,255,0.78);
      font-family: var(--font);
      font-size: 14px;
      font-weight: 400;
      text-decoration: none !important;
      transition: background .15s, color .15s, padding-left .15s;
      white-space: nowrap;
      line-height: 1.4;
    }
    .sb-flyout a::before { display: none; }
    .sb-flyout a:hover { background: rgba(255,255,255,0.08); color: #ffffff; padding-left: 24px; }

    .sb-flyout .flyout-all-link {
      color: rgba(255,255,255,0.68) !important;
      font-weight: 600;
      font-size: 13.5px;
      border-top: 1px solid rgba(255,255,255,0.10);
      margin-top: 6px;
      padding-top: 12px;
      padding-bottom: 6px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .sb-flyout .flyout-all-link i { font-size: 12px; opacity: 0.7; }
    .sb-flyout .flyout-all-link:hover { color: #ffffff !important; background: rgba(255,255,255,0.08); padding-left: 24px; }

    .sb-divider { height: 1px; background: var(--sb-border); margin: 4px 0; }

    /* ── CHAT BUTTON ── */
    .sb-chat-wrap {
      padding: 10px 12px 4px;
      box-sizing: border-box;
      align-self: stretch;
      flex-shrink: 0;
    }
    .sb-chat-btn {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 11px 16px;
      border-radius: 28px;
      background: rgba(255,255,255,0.08);
      border: 1.5px solid rgba(255,255,255,0.28);
      cursor: pointer;
      transition: background .2s, border-color .2s, box-shadow .2s;
      text-decoration: none !important;
      width: 100%;
      box-sizing: border-box;
    }
    .sb-chat-btn:hover {
      background: rgba(255,255,255,0.16);
      border-color: rgba(255,255,255,0.55);
      box-shadow: 0 0 18px rgba(255,255,255,0.12), 0 4px 16px rgba(0,0,0,0.3);
    }
    .sb-chat-avatar {
      width: 32px; height: 32px;
      border-radius: 50%;
      background: rgba(255,255,255,0.12);
      border: 1.5px solid rgba(255,255,255,0.40);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
      font-size: 16px;
      line-height: 1;
    }
    .sb-chat-btn span {
      color: #ffffff;
      font-family: var(--font);
      font-size: 14px;
      font-weight: 600;
      letter-spacing: 0.15px;
      white-space: nowrap;
      overflow: hidden;
    }
    /* Collapsed */
    #ax-sidebar.collapsed .sb-chat-wrap {
      padding: 10px 0 4px;
      display: flex;
      justify-content: center;
      align-self: stretch;
    }
    #ax-sidebar.collapsed .sb-chat-btn {
      width: 44px;
      height: 44px;
      min-width: unset;
      max-width: unset;
      padding: 0;
      justify-content: center;
      border-radius: 50%;
      gap: 0;
    }

    /* ── BOTTOM ── */
    .sb-bottom {
      padding: 10px 12px 16px;
      display: flex;
      flex-direction: column;
      gap: 8px;
      flex-shrink: 0;
      background: #000000;
      border-top: 1px solid var(--sb-border);
    }

    .sb-search {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 9px 13px;
      border-radius: 8px;
      background: rgba(255,255,255,0.07);
      border: 1px solid rgba(255,255,255,0.18);
      transition: border-color .15s, background .15s;
      cursor: text;
    }
    .sb-search:focus-within {
      border-color: rgba(255,255,255,0.45);
      background: rgba(255,255,255,0.12);
    }
    .sb-search i { color: rgba(255,255,255,0.55); font-size: 13px; flex-shrink: 0; }
    #ax-search-input {
      background: transparent;
      border: none;
      outline: none;
      color: #ffffff;
      font-family: var(--font);
      font-size: 13.5px;
      font-weight: 400;
      letter-spacing: 0.15px;
      text-transform: none;
      width: 100%;
    }
    #ax-search-input::placeholder { color: rgba(255,255,255,0.32); }

    .sb-book-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 11px 14px;
      border-radius: 8px;
      background: #ffffff;
      border: none;
      cursor: pointer;
      transition: background .15s, transform .12s;
      text-decoration: none !important;
      color: #000000 !important;
      font-family: var(--font-h);
      font-size: 13px;
      font-weight: 800;
      letter-spacing: 0.4px;
      text-transform: uppercase;
    }
    .sb-book-btn:hover { background: #f0f0f0; transform: translateY(-1px); }
    .sb-book-btn i { font-size: 13px; flex-shrink: 0; color: #000000; }
    .sb-book-text { white-space: nowrap; }

    /* Search dropdown */
    .sb-search-wrap { position: relative; }
    .ax-search-dropdown {
      position: absolute;
      bottom: calc(100% + 6px);
      left: 0; right: 0;
      background: #fff;
      border: 1px solid #e0e0e0;
      border-top: 3px solid #0d0d0d;
      box-shadow: 0 -8px 24px rgba(0,0,0,.15);
      max-height: 380px;
      overflow-y: auto;
      display: none;
      z-index: 99999;
      border-radius: 8px 8px 0 0;
    }
    .ax-search-dropdown.show { display: block; }
    .ax-search-item { display: flex; align-items: center; gap: 12px; padding: 10px 14px; cursor: pointer; border-bottom: 1px solid #f0f0f0; text-decoration: none; transition: background .15s; }
    .ax-search-item:last-child { border-bottom: none; }
    .ax-search-item:hover { background: #f8f8f8; }
    .ax-search-item-img { width: 60px; height: 42px; object-fit: cover; border-radius: 5px; flex-shrink: 0; background: #eee; }
    .ax-search-item-img-placeholder { width: 60px; height: 42px; background: #eee; border-radius: 5px; flex-shrink: 0; }
    .ax-search-item-name { font-size: 13.5px; font-weight: 500; color: #1a1a1a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .ax-search-item-name em { color: #1a1a1a; font-style: normal; font-weight: 700; background: rgba(0,0,0,0.08); padding: 0 2px; border-radius: 2px; }
    .ax-search-item-price { font-size: 12px; color: #888; margin-top: 2px; }
    .ax-search-empty { padding: 20px 14px; font-size: 13px; color: #999; text-align: center; }
    .ax-search-loading { padding: 14px; text-align: center; font-size: 12px; color: #aaa; }
    .ax-search-footer { padding: 10px 14px; border-top: 1px solid #eee; font-size: 12px; color: #333; font-weight: 600; text-align: center; cursor: pointer; transition: background .15s; }
    .ax-search-footer:hover { background: #f5f5f5; }

    /* ── COLLAPSE BUTTON ── */
    .sb-collapse-btn {
      position: fixed;
      top: 80px;
      left: calc(var(--sb-w) - 14px);
      width: 28px; height: 28px;
      border-radius: 50%;
      background: #0d0d0d;
      border: 1.5px solid rgba(255,255,255,0.28);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: #ffffff;
      font-size: 11px;
      z-index: 99999;
      transition: left .28s ease, background .15s, border-color .15s;
      box-shadow: 2px 0 10px rgba(0,0,0,0.35);
    }
    .sb-collapse-btn:hover {
      background: #000000;
      border-color: rgba(255,255,255,0.65);
    }

    #ax-sidebar.collapsed ~ .sb-collapse-btn,
    #ax-sidebar.collapsed + .sb-collapse-btn { left: 50px; }

    .sb-collapse-btn .cb-icon { display: inline-block; transition: transform .28s ease; }
    #ax-sidebar.collapsed ~ .sb-collapse-btn .cb-icon { transform: rotate(180deg); }

    /* Tooltip khi collapsed */
    #ax-sidebar.collapsed .sb-item[data-label]:not(.has-flyout)::after {
      content: attr(data-label);
      position: absolute;
      left: 72px; top: 50%; transform: translateY(-50%);
      background: #0d0d0d;
      color: #ffffff;
      font-family: var(--font);
      font-size: 12.5px;
      font-weight: 500;
      padding: 6px 12px;
      border-radius: 7px;
      white-space: nowrap;
      pointer-events: none;
      opacity: 0;
      transition: opacity .15s;
      border: 1px solid rgba(255,255,255,0.20);
      box-shadow: 0 4px 12px rgba(0,0,0,0.35);
      z-index: 9999;
    }
    #ax-sidebar.collapsed .sb-item[data-label]:not(.has-flyout):hover::after { opacity: 1; }

    /* ── MAIN WRAP ── */
    .ax-main-wrap {
      margin-left: var(--sb-w);
      flex: 1;
      display: flex;
      flex-direction: column;
      min-width: 0;
    }
    main { min-height: 60vh; }

    /* Mobile toggle */
    .sb-toggle {
      display: none;
      position: fixed;
      top: 14px; left: 14px;
      z-index: 9100;
      width: 42px; height: 42px;
      border-radius: 9px;
      background: #0d0d0d;
      border: 1px solid rgba(255,255,255,0.25);
      align-items: center; justify-content: center;
      cursor: pointer;
      color: #ffffff;
      font-size: 17px;
    }
    .sb-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.6);
      z-index: 8999;
    }

    /* ── FOOTER ── */
    .ax-footer { background: #0a0a0a; color: var(--gray-3); font-size: 14px; }
    .ax-footer-cols { padding: 48px 48px 36px; display: grid; grid-template-columns: 1fr 1.8fr 1fr 1.5fr; gap: 40px; border-bottom: 1px solid #1e1e1e; }
    .ax-footer-col h6 { font-family: var(--font-h); font-size: 18px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; color: #fff !important; margin: 0 0 20px; padding-bottom: 12px; text-shadow: 0 0 6px rgba(255,255,255,0.25); position: relative; }
    .ax-footer-col h6::after { content: ""; position: absolute; left: 0; bottom: 0; width: 40px; height: 2px; background: #ffffff; }
    .ax-footer-logo-col { display: flex; flex-direction: column; gap: 12px; padding-top: 4px; }
    .ax-footer-logo { width: 62px; height: 62px; border-radius: 50%; overflow: hidden; border: 2px solid #333; background: #000; flex-shrink: 0; position: relative; }
    .ax-footer-logo img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
    .ax-footer-brand-text strong { display: block; font-family: var(--font-h); font-size: 24px; font-weight: 800; color: #ffffff; letter-spacing: 3px; text-transform: uppercase; line-height: 1.1; }
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
    .ax-newsletter-form input:focus { border-color: #ffffff; }
    .ax-newsletter-form button { padding: 11px 18px; background: #ffffff; border: 1px solid #0d0d0d; color: #000000; font-size: 13px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; cursor: pointer; border-radius: 0 6px 6px 0; font-family: var(--font-h); transition: background .18s; }
    .ax-newsletter-form button:hover { background: #f0f0f0; border-color: #000000; }
    .ax-footer-bottom { padding: 18px 48px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; font-size: 13px; color: var(--gray-4); letter-spacing: 0.2px; }
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

    @media (max-width: 1100px) { .ax-footer-cols { grid-template-columns: 1fr 1fr; } }

    /* ── MOBILE FIXES ── */
    @media (max-width: 900px) {
      #ax-sidebar {
        transform: translateX(-100%);
        /* Fix khoảng trắng: sidebar mobile không dùng height 100vh cứng,
           thay bằng min-height để nội dung co lại tự nhiên */
        height: 100vh;
        overflow-y: auto;
      }
      #ax-sidebar.open { transform: translateX(0); }

      /* KEY FIX: Trên mobile, nav KHÔNG flex:1 nữa → không kéo dãn gây khoảng trắng */
      #ax-sidebar .sb-nav {
        flex: 0 0 auto !important;
      }

      /* Chat wrap và bottom bám sát ngay sau nav */
      #ax-sidebar .sb-chat-wrap {
        flex: 0 0 auto;
        margin-top: 8px;
      }
      #ax-sidebar .sb-bottom {
        flex: 0 0 auto;
        margin-top: 0;
      }

      .ax-main-wrap { margin-left: 0; }
      .sb-toggle { display: flex; }
      .sb-overlay.show { display: block; }
      .ax-slide-indicators { left: 14px; }

      /* Ẩn collapse button trên mobile */
      .sb-collapse-btn { display: none !important; }
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

<button class="sb-toggle" id="sb-toggle" aria-label="Mở menu">
  <i class="fa fa-bars"></i>
</button>
<div class="sb-overlay" id="sb-overlay"></div>

<div class="ax-layout">

  <aside id="ax-sidebar">

    <a href="{{ url('/') }}" class="sb-brand">
      <div class="sb-logo">
        <img src="{{ asset('images/logo.png') }}"
             onerror="this.onerror=null;this.src='{{ asset('images/testimonial/logo.jpg') }}'"
             alt="AUTO X Logo">
      </div>
      <div class="sb-brand-text">
        <strong>AUTO X</strong>
        <span>Showroom Ô Tô</span>
      </div>
    </a>

    <nav class="sb-nav">

      <a href="{{ url('/') }}"
         class="sb-item {{ request()->is('/') ? 'sb-active' : '' }}"
         data-label="Trang Chủ">
        <i class="fa fa-home"></i>
        <span>Trang Chủ</span>
      </a>

      <a href="{{ url('/about') }}"
         class="sb-item {{ request()->is('about') ? 'sb-active' : '' }}"
         data-label="Giới Thiệu">
        <i class="fa fa-info-circle"></i>
        <span>Giới Thiệu</span>
      </a>

      <div class="sb-item-wrap" id="sb-cars-wrap">
        <div class="sb-item has-flyout {{ request()->is('cars*') ? 'sb-active' : '' }}"
             id="sb-cars-toggle" data-label="Xem Xe">
          <i class="fa fa-car"></i>
          <span>Xem Xe</span>
        </div>
        <div class="sb-sub {{ request()->is('cars*') ? 'open' : '' }}" id="sb-cars-sub">
          <div class="sb-sub-label">Sedan</div>
          @php $car = \App\Models\Car::where('name','Mercedes-Benz E-Class')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-Benz E-Class</a>@endif
          @php $car = \App\Models\Car::where('name','Mercedes-Benz S-Class')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-Benz S-Class</a>@endif
          @php $car = \App\Models\Car::where('name','Mercedes-Maybach S-Class')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-Maybach S-Class</a>@endif
          <div class="sb-sub-label">SUV</div>
          @php $car = \App\Models\Car::where('name','Mercedes-Benz GLE')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-Benz GLE</a>@endif
          @php $car = \App\Models\Car::where('name','Mercedes-Benz GLS')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-Benz GLS</a>@endif
          @php $car = \App\Models\Car::where('name','Mercedes-Benz G-Class')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-Benz G-Class</a>@endif
          @php $car = \App\Models\Car::where('name','Mercedes-Maybach GLS')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-Maybach GLS</a>@endif
          <div class="sb-sub-label">Coupe &amp; Roadster</div>
          @php $car = \App\Models\Car::where('name','Mercedes-AMG GT')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-AMG GT</a>@endif
          @php $car = \App\Models\Car::where('name','Mercedes-Benz SL-Class')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-Benz SL-Class</a>@endif
          <div class="sb-sub-label">Xe Điện EQ</div>
          @php $car = \App\Models\Car::where('name','Mercedes-Benz EQS')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-Benz EQS</a>@endif
          <a href="{{ url('/cars') }}" style="color:rgba(255,255,255,0.70) !important;font-weight:600;margin-top:4px;border-top:1px solid rgba(255,255,255,0.08);padding-top:8px;">
            <i class="fa fa-th-large" style="font-size:12px;"></i> Xem tất cả xe
          </a>
        </div>
        <div class="sb-flyout" id="sb-cars-flyout">
          <div class="sb-flyout-title">
            <i class="fa fa-car"></i> Xem Xe
            <button class="sb-flyout-close" id="sb-cars-flyout-close" title="Đóng"><i class="fa fa-times"></i></button>
          </div>
          <div class="sb-sub-label">Sedan</div>
          @php $car = \App\Models\Car::where('name','Mercedes-Benz E-Class')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-Benz E-Class</a>@endif
          @php $car = \App\Models\Car::where('name','Mercedes-Benz S-Class')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-Benz S-Class</a>@endif
          @php $car = \App\Models\Car::where('name','Mercedes-Maybach S-Class')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-Maybach S-Class</a>@endif
          <div class="sb-sub-label">SUV</div>
          @php $car = \App\Models\Car::where('name','Mercedes-Benz GLE')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-Benz GLE</a>@endif
          @php $car = \App\Models\Car::where('name','Mercedes-Benz GLS')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-Benz GLS</a>@endif
          @php $car = \App\Models\Car::where('name','Mercedes-Benz G-Class')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-Benz G-Class</a>@endif
          @php $car = \App\Models\Car::where('name','Mercedes-Maybach GLS')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-Maybach GLS</a>@endif
          <div class="sb-sub-label">Coupe &amp; Roadster</div>
          @php $car = \App\Models\Car::where('name','Mercedes-AMG GT')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-AMG GT</a>@endif
          @php $car = \App\Models\Car::where('name','Mercedes-Benz SL-Class')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-Benz SL-Class</a>@endif
          <div class="sb-sub-label">Xe Điện EQ</div>
          @php $car = \App\Models\Car::where('name','Mercedes-Benz EQS')->first(); @endphp
          @if($car)<a href="{{ route('cars.show', $car) }}">Mercedes-Benz EQS</a>@endif
          <a href="{{ url('/cars') }}" class="flyout-all-link"><i class="fa fa-th-large"></i> Xem tất cả xe</a>
        </div>
      </div>

      <div class="sb-item-wrap" id="sb-svc-wrap">
        <div class="sb-item has-flyout {{ request()->is('services*') ? 'sb-active' : '' }}"
             id="sb-svc-toggle" data-label="Dịch Vụ">
          <i class="fa fa-wrench"></i>
          <span>Dịch Vụ</span>
        </div>
        <div class="sb-sub {{ request()->is('services*') ? 'open' : '' }}" id="sb-svc-sub">
          <a href="{{ url('/services') }}">Dịch Vụ</a>
          <a href="{{ route('services.booking') }}">Đặt lịch trực tuyến</a>
          <a href="{{ route('services.maintenance-process') }}">Quy trình bảo dưỡng nhanh</a>
          <a href="{{ route('services.maintenance-schedule') }}">Lịch bảo dưỡng định kỳ</a>
          <a href="{{ route('services.pickup-delivery') }}">Nhận &amp; giao xe tận nơi</a>
        </div>
        <div class="sb-flyout" id="sb-svc-flyout">
          <div class="sb-flyout-title">
            <i class="fa fa-wrench"></i> Dịch Vụ
            <button class="sb-flyout-close" id="sb-svc-flyout-close" title="Đóng"><i class="fa fa-times"></i></button>
          </div>
          <a href="{{ url('/services') }}">Dịch Vụ</a>
          <a href="{{ route('services.booking') }}">Đặt lịch trực tuyến</a>
          <a href="{{ route('services.maintenance-process') }}">Quy trình bảo dưỡng nhanh</a>
          <a href="{{ route('services.maintenance-schedule') }}">Lịch bảo dưỡng định kỳ</a>
          <a href="{{ route('services.pickup-delivery') }}">Nhận &amp; giao xe tận nơi</a>
        </div>
      </div>

      <a href="{{ url('/news') }}"
         class="sb-item {{ request()->is('news*') ? 'sb-active' : '' }}"
         data-label="Tin Tức">
        <i class="fa fa-newspaper-o"></i>
        <span>Tin Tức</span>
      </a>

    </nav>

    <div class="sb-chat-wrap">
      <button class="sb-chat-btn" id="ax-chat-open-btn" type="button">
        <div class="sb-chat-avatar">🤖</div>
        <span>Chat với AUTO X</span>
      </button>
    </div>

    <div class="sb-bottom">
      <div class="sb-search-wrap">
        <div class="sb-search" id="ax-search-wrap">
          <i class="fa fa-search"></i>
          <input type="text" id="ax-search-input" placeholder="Tìm xe…" autocomplete="off">
        </div>
        <div class="ax-search-dropdown" id="ax-search-dropdown"></div>
      </div>
      <a href="{{ route('services.booking') }}" class="sb-book-btn">
        <i class="fa fa-calendar"></i>
        <span class="sb-book-text">Đặt Lịch</span>
      </a>
    </div>
  </aside>

  <button class="sb-collapse-btn" id="sb-collapse-btn" title="Thu gọn menu">
    <i class="fa fa-angle-left cb-icon"></i>
  </button>

  <div class="ax-main-wrap">
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
            <li><a href="#" class="fb" title="Facebook"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#" class="yt" title="YouTube"><i class="fa fa-youtube-play"></i></a></li>
            <li><a href="#" class="ig" title="Instagram"><i class="fa fa-instagram"></i></a></li>
          </ul>
        </div>
        <div class="ax-footer-col">
          <h6>Liên Kết Nhanh</h6>
          <ul class="ax-footer-links">
            <li><a href="{{ url('/') }}">Trang chủ</a></li>
            <li><a href="{{ url('/about') }}">Giới thiệu</a></li>
            <li><a href="{{ url('/cars') }}">Xem xe</a></li>
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
  </div>

</div>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>

<script>
  if (typeof jQuery !== 'undefined') {
    if (!$.fn.megaMenu)        $.fn.megaMenu        = function(){ return this; };
    if (!$.fn.magnificPopup)   $.fn.magnificPopup   = function(){ return this; };
    if (!$.fn.owlCarousel)     $.fn.owlCarousel     = function(){ return this; };
    if (!$.fn.counterUp)       $.fn.counterUp       = function(){ return this; };
    if (!$.fn.parallax)        $.fn.parallax        = function(){ return this; };
    if (!$.fn.waypoint)        $.fn.waypoint        = function(){ return this; };
    if (!$.fn.niceSelect)      $.fn.niceSelect      = function(){ return this; };
    if (!$.fn.slick)           $.fn.slick           = function(){ return this; };
  }
</script>

<script src="{{ asset('js/custom.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/custom-override.css') }}" />
<style>
/* ===== FORCE WHITE – ghi đè custom-override.css ===== */
#ax-sidebar,
#ax-sidebar .sb-item,
#ax-sidebar .sb-item span,
#ax-sidebar .sb-item i,
#ax-sidebar .sb-nav a,
#ax-sidebar .sb-nav div.sb-item,
#ax-sidebar .sb-brand-text strong,
#ax-sidebar .sb-brand-text span,
#ax-sidebar .sb-search i,
#ax-sidebar #ax-search-input,
#ax-sidebar .sb-chat-btn span,
#ax-sidebar .sb-collapse-btn,
.sb-collapse-btn { color: #ffffff !important; }

#ax-sidebar .sb-item i,
#ax-sidebar .sb-item:hover i,
#ax-sidebar .sb-item.sb-active i {
  border-color: rgba(255,255,255,0.40) !important;
  background: rgba(255,255,255,0.09) !important;
  color: #ffffff !important;
}
#ax-sidebar .sb-item:hover i,
#ax-sidebar .sb-item.sb-active i {
  border-color: rgba(255,255,255,0.70) !important;
  background: rgba(255,255,255,0.18) !important;
}
#ax-sidebar .sb-sub a { color: rgba(255,255,255,0.78) !important; }
#ax-sidebar .sb-sub-label { color: rgba(255,255,255,0.38) !important; }
#ax-sidebar .sb-logo { border-color: rgba(255,255,255,0.45) !important; }
#ax-sidebar .sb-brand { border-bottom-color: rgba(255,255,255,0.15) !important; }
#ax-sidebar .sb-bottom { border-top-color: rgba(255,255,255,0.15) !important; }
#ax-sidebar .sb-search { border-color: rgba(255,255,255,0.18) !important; background: rgba(255,255,255,0.07) !important; }
#ax-sidebar .sb-search:focus-within { border-color: rgba(255,255,255,0.45) !important; }
#ax-sidebar .sb-chat-btn {
  border-color: rgba(255,255,255,0.28) !important;
  background: rgba(255,255,255,0.08) !important;
  width: 100% !important;
  box-sizing: border-box !important;
}
#ax-sidebar.collapsed .sb-chat-btn {
  width: 44px !important;
  height: 44px !important;
}
#ax-sidebar .sb-book-btn { background: #ffffff !important; color: #000000 !important; }
#ax-sidebar .sb-book-btn i { color: #000000 !important; }
#ax-sidebar .sb-book-btn span { color: #000000 !important; }

/* Flyout màu trắng */
.sb-flyout .sb-flyout-title,
.sb-flyout .sb-flyout-title i { color: #ffffff !important; }
.sb-flyout .sb-sub-label { color: rgba(255,255,255,0.38) !important; }
.sb-flyout a { color: rgba(255,255,255,0.80) !important; }
.sb-flyout a:hover { color: #ffffff !important; }
.sb-flyout .flyout-all-link { color: rgba(255,255,255,0.70) !important; border-top-color: rgba(255,255,255,0.12) !important; }
.sb-flyout { border-left-color: rgba(255,255,255,0.30) !important; }
.sb-flyout .sb-flyout-close { color: rgba(255,255,255,0.70) !important; border-color: rgba(255,255,255,0.25) !important; }

/* ===== MOBILE NAV FIX – override flex:1 trên nav ===== */
@media (max-width: 900px) {
  #ax-sidebar .sb-nav {
    flex: 0 0 auto !important;
  }
  #ax-sidebar .sb-chat-wrap {
    flex: 0 0 auto !important;
    margin-top: 8px !important;
  }
  #ax-sidebar .sb-bottom {
    flex: 0 0 auto !important;
    margin-top: 0 !important;
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

  var sidebar  = document.getElementById('ax-sidebar');
  var mainWrap = document.querySelector('.ax-main-wrap');
  var collapsed = localStorage.getItem('sb-collapsed') === '1';

  // Move flyouts to body so they are never clipped by sidebar overflow
  document.querySelectorAll('.sb-flyout').forEach(function(f) {
    document.body.appendChild(f);
  });

  function applySidebarState() {
    if (collapsed) {
      sidebar.classList.add('collapsed');
      mainWrap.classList.add('collapsed');
    } else {
      sidebar.classList.remove('collapsed');
      mainWrap.classList.remove('collapsed');
    }
  }
  applySidebarState();

  var collapseBtn = document.getElementById('sb-collapse-btn');
  if (collapseBtn) {
    collapseBtn.addEventListener('click', function () {
      collapsed = !collapsed;
      localStorage.setItem('sb-collapsed', collapsed ? '1' : '0');
      applySidebarState();
    });
  }

  function initFlyout(toggleId, flyoutId, closeBtnId) {
    var toggle   = document.getElementById(toggleId);
    var flyout   = document.getElementById(flyoutId);
    var closeBtn = closeBtnId ? document.getElementById(closeBtnId) : null;
    if (!toggle || !flyout) return;

    var hideTimer = null;

    function showFlyout() {
      clearTimeout(hideTimer);
      var rect    = toggle.getBoundingClientRect();
      var sbRect  = sidebar.getBoundingClientRect();
      var topPos  = Math.max(4, rect.top);
      var leftPos = sbRect.right;
      flyout.style.top       = topPos + 'px';
      flyout.style.left      = leftPos + 'px';
      flyout.style.maxHeight = (window.innerHeight - 8 - topPos) + 'px';
      flyout.classList.add('show');
    }
    function hideFlyout() {
      hideTimer = setTimeout(function () { flyout.classList.remove('show'); }, 150);
    }

    toggle.addEventListener('mouseenter', showFlyout);
    toggle.addEventListener('mouseleave', hideFlyout);
    flyout.addEventListener('mouseenter', function () { clearTimeout(hideTimer); });
    flyout.addEventListener('mouseleave', hideFlyout);

    if (closeBtn) {
      closeBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        flyout.classList.remove('show');
      });
    }
  }
  initFlyout('sb-cars-toggle', 'sb-cars-flyout', 'sb-cars-flyout-close');
  initFlyout('sb-svc-toggle',  'sb-svc-flyout',  'sb-svc-flyout-close');

  var mobileToggle = document.getElementById('sb-toggle');
  var sbOverlay    = document.getElementById('sb-overlay');
  if (mobileToggle) {
    mobileToggle.addEventListener('click', function () {
      sidebar.classList.toggle('open');
      sbOverlay.classList.toggle('show');
    });
    sbOverlay.addEventListener('click', function () {
      sidebar.classList.remove('open');
      sbOverlay.classList.remove('show');
    });
  }

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
        dropdown.innerHTML = '<div class="ax-search-empty">Không tìm thấy xe phù hợp</div>';
        return;
      }
      items.forEach(function (car) {
        var a = document.createElement('a');
        a.className = 'ax-search-item';
        a.href = '/cars/' + car.id;
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