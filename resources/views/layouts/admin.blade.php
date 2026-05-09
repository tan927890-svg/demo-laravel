<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('page-title', 'Admin') — AutoX</title>

  {{-- PWA --}}
  <link rel="manifest" href="/manifest.json">
  <meta name="theme-color" content="#0f0f0f">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="apple-mobile-web-app-title" content="AutoX">
  <link rel="apple-touch-icon" href="/icons/icon-192.png">
  <script>
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('/sw.js');
    }
  </script>

  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --sidebar: 240px;
      --topbar: 58px;
      --font: 'Nunito', sans-serif;

      --bg: #f4f4f1;
      --surface: #ffffff;
      --border: #e8e7e2;

      --text: #1a1a1a;
      --text-2: #5a5955;
      --text-3: #a09f9b;

      --sb-bg: #0f0f0f;
      --sb-surface: #1a1a1a;
      --sb-border: rgba(255,255,255,0.07);
      --sb-text: #f0efeb;
      --sb-text-2: rgba(240,239,235,0.55);
      --sb-text-3: rgba(240,239,235,0.28);
      --sb-hover: rgba(255,255,255,0.06);
      --sb-active-bg: rgba(255,255,255,0.10);
      --sb-active-text: #ffffff;
      --sb-accent: #f59e0b;

      --accent: #1a1a1a;
      --danger: #dc2626;
      --success: #16a34a;
      --warning: #d97706;
      --info: #2563eb;
    }

    body {
      font-family: var(--font);
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      font-size: 15px;
      -webkit-font-smoothing: antialiased;
    }

    /* ─── SIDEBAR ─────────────────────────────────── */
    .sidebar {
      width: var(--sidebar);
      background: var(--sb-bg);
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      z-index: 20;
      border-right: 1px solid var(--sb-border);
      transition: transform .25s ease;
    }

    .logo { border-bottom: 1px solid var(--sb-border); }
    .logo img { width: 100%; height: 90px; object-fit: cover; display: block; }

    nav {
      flex: 1; padding: 14px 10px; overflow-y: auto;
      scrollbar-width: thin; scrollbar-color: var(--sb-border) transparent;
    }
    nav::-webkit-scrollbar { width: 4px; }
    nav::-webkit-scrollbar-thumb { background: var(--sb-border); border-radius: 4px; }

    .nav-group {
      font-size: 10px; color: var(--sb-text-3); letter-spacing: 1.4px;
      text-transform: uppercase; padding: 14px 10px 5px; font-weight: 700;
    }

    .nav-group-btn {
      display: flex; align-items: center; justify-content: space-between;
      width: 100%; background: none; border: none; cursor: pointer;
      font-family: var(--font); font-size: 12px; font-weight: 700;
      color: rgba(240,239,235,0.55); letter-spacing: 0.8px; text-transform: uppercase;
      padding: 14px 10px 5px;
      transition: color .15s;
      user-select: none;
    }
    .nav-group-btn:hover { color: rgba(240,239,235,0.85); }
    .nav-group-btn .chev {
      width: 15px; height: 15px; flex-shrink: 0;
      color: rgba(240,239,235,0.45);
      transition: transform .28s cubic-bezier(.4,0,.2,1), color .2s;
    }
    .nav-group-btn:hover .chev { color: rgba(240,239,235,0.8); }
    .nav-group-btn.open .chev { transform: rotate(180deg); color: rgba(240,239,235,0.7); }

    .nav-group-content {
      display: grid;
      grid-template-rows: 1fr;
      overflow: hidden;
      transition: grid-template-rows .28s cubic-bezier(.4,0,.2,1);
    }
    .nav-group-content.closed { grid-template-rows: 0fr; }
    .nav-group-inner { min-height: 0; }

    .nav-link {
      display: flex; align-items: center; gap: 11px; padding: 10px 12px;
      border-radius: 10px; font-size: 14px; font-weight: 600;
      color: var(--sb-text-2); text-decoration: none;
      transition: background .15s, color .15s; margin-bottom: 2px; line-height: 1.3;
    }
    .nav-link:hover { background: var(--sb-hover); color: var(--sb-text); }
    .nav-link.active { background: var(--sb-active-bg); color: var(--sb-active-text); position: relative; }
    .nav-link.active::before {
      content: ''; position: absolute; left: 0; top: 20%; bottom: 20%;
      width: 3px; background: var(--sb-accent); border-radius: 0 3px 3px 0;
    }
    .nav-link svg { width: 17px; height: 17px; flex-shrink: 0; opacity: .9; transition: opacity .15s; }
    .nav-link:hover svg, .nav-link.active svg { opacity: 1; }

    .nav-link .icon-wrap {
      width: 28px; height: 28px; border-radius: 7px;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0; transition: all .15s;
    }
    .nav-link .icon-wrap svg { opacity: 1; }

    .icon-blue   { background: rgba(59,130,246,.18); color: #93c5fd; }
    .icon-green  { background: rgba(16,185,129,.18); color: #6ee7b7; }
    .icon-orange { background: rgba(249,115,22,.18);  color: #fdba74; }
    .icon-amber  { background: rgba(245,158,11,.18);  color: #fcd34d; }
    .icon-teal   { background: rgba(20,184,166,.18);  color: #5eead4; }
    .icon-cyan   { background: rgba(6,182,212,.18);   color: #67e8f9; }
    .icon-slate  { background: rgba(148,163,184,.15); color: #cbd5e1; }
    .icon-violet { background: rgba(99,102,241,.18);  color: #a5b4fc; }
    .icon-red    { background: rgba(239,68,68,.15);   color: #fca5a5; }
    .icon-sky    { background: rgba(14,165,233,.18);  color: #7dd3fc; }

    .nav-link:hover .icon-wrap, .nav-link.active .icon-wrap { filter: brightness(1.15); }

    .nav-badge {
      margin-left: auto; background: #dc2626; color: #fff;
      font-size: 10px; padding: 2px 7px; border-radius: 20px; font-weight: 700;
    }

    .sidebar-foot { padding: 14px 10px; border-top: 1px solid var(--sb-border); }
    .user-chip {
      display: flex; align-items: center; gap: 10px; padding: 10px 12px;
      border-radius: 10px; background: var(--sb-surface);
    }
    .avatar {
      width: 34px; height: 34px; border-radius: 50%;
      background: linear-gradient(135deg, #f59e0b, #f97316);
      display: flex; align-items: center; justify-content: center;
      font-size: 13px; font-weight: 800; color: #fff; flex-shrink: 0;
    }
    .user-name { font-size: 13px; font-weight: 700; color: var(--sb-text); line-height: 1.3; }
    .user-role { font-size: 11px; color: var(--sb-text-3); font-weight: 500; }
    .logout-btn {
      margin-top: 8px; width: 100%; padding: 9px; border-radius: 10px;
      border: 1px solid var(--sb-border); background: transparent; color: var(--sb-text-2);
      font-size: 13px; font-weight: 600; font-family: var(--font);
      cursor: pointer; transition: background .15s, color .15s; text-align: center;
    }
    .logout-btn:hover { background: var(--sb-hover); color: var(--sb-text); }

    .sidebar-overlay {
      display: none;
      position: fixed; inset: 0; z-index: 19;
      background: rgba(0,0,0,.45);
    }

    /* ─── TOPBAR ──────────────────────────────────── */
    .topbar {
      height: var(--topbar);
      background: var(--surface);
      border-bottom: 1px solid var(--border);
      display: flex; align-items: center;
      padding: 0 20px; gap: 12px;
      position: sticky; top: 0; z-index: 10;
    }

    .hamburger {
      display: none;
      width: 36px; height: 36px; border-radius: 9px;
      border: 1px solid var(--border); background: var(--surface);
      align-items: center; justify-content: center;
      cursor: pointer; flex-shrink: 0;
    }
    .hamburger svg { width: 18px; height: 18px; color: var(--text-2); }

    .page-title {
      flex: 1;
      text-align: center;
      font-size: 20px; font-weight: 800; letter-spacing: -0.3px;
      white-space: nowrap; color: var(--text);
      pointer-events: none;
    }

    /* ─── NOTIFICATION BELL ───────────────────────── */
    .notif-wrap { position: relative; }
    .notif-btn {
      width: 38px; height: 38px; border-radius: 10px;
      border: 1px solid var(--border); background: var(--surface);
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; transition: background .15s; position: relative;
    }
    .notif-btn:hover { background: var(--bg); }
    .notif-btn svg { width: 18px; height: 18px; color: var(--text-2); }
    .notif-dot {
      position: absolute; top: 6px; right: 6px;
      width: 8px; height: 8px; border-radius: 50%;
      background: #dc2626; border: 2px solid #fff;
      display: none;
    }
    .notif-count {
      position: absolute; top: -4px; right: -4px;
      background: #dc2626; color: #fff; border-radius: 20px;
      font-size: 10px; font-weight: 800; padding: 1px 5px;
      border: 2px solid #fff; display: none;
    }

    .notif-panel {
      display: none;
      position: absolute; top: calc(100% + 10px); right: 0;
      width: 360px; background: var(--surface);
      border: 1px solid var(--border); border-radius: 14px;
      box-shadow: 0 12px 40px rgba(0,0,0,.12);
      z-index: 999; overflow: hidden;
      animation: panelIn .15s ease;
    }
    .notif-panel.open { display: block; }
    @keyframes panelIn {
      from { opacity:0; transform: translateY(6px); }
      to   { opacity:1; transform: translateY(0); }
    }
    .notif-panel-hd {
      padding: 14px 18px; border-bottom: 1px solid var(--border);
      display: flex; align-items: center; justify-content: space-between;
    }
    .notif-panel-hd span { font-weight: 700; font-size: 14px; }
    .notif-panel-hd button {
      font-size: 12px; color: var(--info); background: none;
      border: none; cursor: pointer; font-weight: 600; font-family: var(--font);
    }
    .notif-list { max-height: 400px; overflow-y: auto; }
    .notif-item {
      padding: 14px 18px; border-bottom: 1px solid var(--border);
      cursor: pointer; transition: background .1s; position: relative;
    }
    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background: var(--bg); }
    .notif-item.unread { background: #f0f7ff; }
    .notif-item.unread:hover { background: #e8f2ff; }
    .notif-item-title {
      font-size: 13px; font-weight: 700; margin-bottom: 4px;
      display: flex; align-items: center; gap: 7px;
    }
    .notif-item-body { font-size: 12px; color: var(--text-2); line-height: 1.5; }
    .notif-item-meta { font-size: 11px; color: var(--text-3); margin-top: 5px; }
    .notif-unread-dot {
      width: 7px; height: 7px; border-radius: 50%;
      background: #2563eb; flex-shrink: 0; margin-left: auto;
    }
    .notif-empty {
      padding: 40px; text-align: center;
      color: var(--text-3); font-size: 13px;
    }
    .notif-footer {
      padding: 10px 18px; border-top: 1px solid var(--border); text-align: center;
    }
    .notif-footer a {
      font-size: 13px; color: var(--info); font-weight: 600; text-decoration: none;
    }

    /* ─── MAIN ────────────────────────────────────── */
    .main {
      margin-left: var(--sidebar);
      flex: 1; display: flex; flex-direction: column; min-height: 100vh;
    }
    .content { padding: 8px 20px 28px; flex: 1; }

    /* ─── BUTTONS ─────────────────────────────────── */
    .btn {
      display: inline-flex; align-items: center; gap: 7px;
      padding: 9px 16px; border-radius: 10px; font-size: 14px; font-weight: 700;
      cursor: pointer; border: 1px solid var(--border); background: var(--surface);
      color: var(--text); text-decoration: none; transition: all .15s;
      font-family: var(--font); line-height: 1;
    }
    .btn:hover { background: var(--bg); }
    .btn-primary { background: var(--accent); color: #fff; border-color: var(--accent); }
    .btn-primary:hover { background: #333; border-color: #333; color: #fff; }
    .btn-danger { color: var(--danger); border-color: #fecaca; }
    .btn-danger:hover { background: #fef2f2; }
    .btn-sm { padding: 6px 12px; font-size: 13px; }
    .btn-icon { padding: 7px; width: 34px; height: 34px; justify-content: center; }

    /* ─── CARDS ───────────────────────────────────── */
    .card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; }
    .card-pad { padding: 22px; }

    /* ─── BADGES ──────────────────────────────────── */
    .badge {
      display: inline-flex; align-items: center;
      padding: 3px 10px; border-radius: 20px;
      font-size: 12px; font-weight: 700; white-space: nowrap;
    }
    .badge-green  { background: #dcfce7; color: #15803d; }
    .badge-red    { background: #fee2e2; color: #dc2626; }
    .badge-amber  { background: #fef3c7; color: #92400e; }
    .badge-blue   { background: #dbeafe; color: #1d4ed8; }
    .badge-gray   { background: #f1f5f9; color: #64748b; }
    .badge-purple { background: #ede9fe; color: #6d28d9; }
    .badge-info   { background: #dbeafe; color: #1d4ed8; }
    .badge-success { background: #dcfce7; color: #15803d; }
    .badge-warning { background: #fef3c7; color: #92400e; }

    /* ─── TABLE ───────────────────────────────────── */
    table { width: 100%; border-collapse: collapse; font-size: 14px; }
    th {
      text-align: left; padding: 11px 16px; font-size: 12px; font-weight: 700;
      color: var(--text-2); letter-spacing: .4px; text-transform: uppercase;
      border-bottom: 1px solid var(--border); background: #fafaf8;
    }
    td { padding: 13px 16px; border-bottom: 1px solid var(--border); vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: #fafaf8; }

    /* ─── FORMS ───────────────────────────────────── */
    .form-group { margin-bottom: 18px; }
    .form-label { display: block; font-size: 13px; font-weight: 700; color: var(--text-2); margin-bottom: 6px; }
    .form-control {
      width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: 10px;
      font-size: 14px; font-family: var(--font); color: var(--text); background: var(--surface);
      transition: border-color .15s; outline: none;
    }
    .form-control:focus { border-color: #999; }
    textarea.form-control { resize: vertical; min-height: 100px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-hint { font-size: 12px; color: var(--text-3); margin-top: 5px; }
    .form-input { padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px; font-family: var(--font); }

    /* ─── ALERTS ──────────────────────────────────── */
    .alert { padding: 12px 16px; border-radius: 10px; font-size: 14px; font-weight: 600; margin-bottom: 18px; }
    .alert-success { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .alert-error   { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }

    /* ─── STAT CARDS ──────────────────────────────── */
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 18px 20px; }
    .stat-label { font-size: 12px; color: var(--text-3); text-transform: uppercase; letter-spacing: .7px; margin-bottom: 8px; font-weight: 700; }
    .stat-val { font-size: 30px; font-weight: 800; letter-spacing: -1.2px; line-height: 1; margin-bottom: 5px; }
    .stat-sub { font-size: 13px; color: var(--text-3); }

    /* ─── SECTION HEADER ──────────────────────────── */
    .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
    .section-title { font-size: 15px; font-weight: 800; }

    /* ─── PAGINATION ──────────────────────────────── */
    .pagination { display: flex; align-items: center; gap: 6px; margin-top: 18px; font-size: 14px; color: var(--text-2); }
    .pagination a, .pagination span {
      padding: 6px 12px; border: 1px solid var(--border); border-radius: 8px;
      text-decoration: none; color: var(--text); background: var(--surface);
      font-size: 13px; font-weight: 600;
    }
    .pagination .active span { background: var(--accent); color: #fff; border-color: var(--accent); }

    /* ─── SEARCH & FILTERS ────────────────────────── */
    .search-wrap { position: relative; }
    .search-wrap svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 15px; height: 15px; color: var(--text-3); }
    .search-wrap input { padding-left: 36px; }
    .filter-bar { display: flex; gap: 10px; margin-bottom: 16px; flex-wrap: wrap; align-items: center; }

    /* ─── FLASH ───────────────────────────────────── */
    @keyframes fadeout { 0%{opacity:1} 80%{opacity:1} 100%{opacity:0} }
    .flash { animation: fadeout 4s forwards; }

    /* ─── MOBILE ──────────────────────────────────── */
    @media (max-width: 768px) {
      .sidebar { transform: translateX(-100%); z-index: 30; }
      .sidebar.open { transform: translateX(0); }
      .sidebar-overlay.open { display: block; }
      .main { margin-left: 0 !important; }
      .main.sb-collapsed { margin-left: 0 !important; }
      .hamburger { display: flex; }
      .page-title { font-size: 16px; }
      .content { padding: 8px 14px 24px; }
      .topbar { padding: 0 14px; }
      .notif-panel { width: calc(100vw - 28px); right: -10px; }
      .form-row { grid-template-columns: 1fr; }
      .sb-admin-toggle { display: none !important; }
    }
  </style>
  <style>
    /* ── SIDEBAR COLLAPSE ── */
    .sidebar {
      width: 240px;
      overflow: hidden;
      transition: width .28s ease, transform .25s ease;
    }
    .sidebar.collapsed { width: 64px !important; }

    .nav-link { white-space: nowrap; overflow: hidden; }

    .sidebar.collapsed .nav-link {
      justify-content: center;
      padding: 10px 0 !important;
      font-size: 0 !important;
      gap: 0;
    }
    .sidebar.collapsed .icon-wrap { font-size: 14px; flex-shrink: 0; margin: 0; }
    .sidebar.collapsed .icon-wrap svg { width: 17px; height: 17px; }

    .sidebar.collapsed .nav-group,
    .sidebar.collapsed .nav-group-btn,
    .sidebar.collapsed .nav-badge,
    .sidebar.collapsed .user-name,
    .sidebar.collapsed .user-role,
    .sidebar.collapsed .logout-btn { display: none !important; }

    .sidebar.collapsed .nav-group-content { grid-template-rows: 1fr !important; }

    .sidebar.collapsed .logo img { height: 64px; object-fit: cover; }
    .sidebar.collapsed .user-chip { justify-content: center; padding: 10px 4px; }
    .sidebar.collapsed .sidebar-foot { padding: 10px 4px; }
    .sidebar.collapsed .nav-link.active::before { display: none; }
    .sidebar.collapsed .avatar { margin: 0; }

    .main { transition: margin-left .28s ease; }
    .main.sb-collapsed { margin-left: 64px !important; }

    .sb-admin-toggle {
      position: fixed; top: 72px; left: calc(240px - 14px);
      width: 28px; height: 28px; border-radius: 50%;
      background: #1a1a1a; border: 1.5px solid rgba(255,255,255,0.18);
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; color: #aaa; z-index: 9999;
      transition: left .28s ease, background .15s, color .15s;
      box-shadow: 2px 0 10px rgba(0,0,0,0.35);
    }
    .sb-admin-toggle:hover { background: #000; color: #fff; }
    .sb-admin-toggle.collapsed { left: 50px; }
    .sb-admin-toggle svg { width: 14px; height: 14px; transition: transform .28s ease; }
    .sb-admin-toggle.collapsed svg { transform: rotate(180deg); }
  </style>
  @stack('styles')
</head>
<body>

<div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

<aside class="sidebar" id="sidebar">
  <div class="logo">
    <img src="{{ asset('images/logo.png') }}" alt="AutoX Logo">
  </div>

  <nav>

    @if(Auth::user()->canManageStaff())
      <div class="nav-group">Tổng quan</div>
      <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span class="icon-wrap icon-blue"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg></span>
        Bảng tổng quan
      </a>
      <a href="{{ route('admin.dashboard.revenue') }}" class="nav-link {{ request()->routeIs('admin.dashboard.revenue') ? 'active' : '' }}">
        <span class="icon-wrap icon-green"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg></span>
        Doanh thu
      </a>
    @endif

    @php
      $quanlyActive = request()->routeIs('admin.cars*') || request()->routeIs('admin.featured-cars*')
        || request()->routeIs('admin.orders*') || request()->routeIs('admin.staff.orders*')
        || request()->routeIs('admin.staff.customers*') || request()->routeIs('admin.users*');
    @endphp
    <button class="nav-group-btn open" id="btn-quanly" onclick="toggleGroup('quanly')" aria-expanded="true">
      <span>Quản lý</span>
      <svg class="chev" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
    </button>
    <div class="nav-group-content" id="grp-quanly">
      <div class="nav-group-inner">
        <a href="{{ route('admin.cars.index') }}" class="nav-link {{ request()->routeIs('admin.cars*') || request()->routeIs('admin.featured-cars*') ? 'active' : '' }}">
          <span class="icon-wrap icon-orange"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M5 17H3a2 2 0 01-2-2v-4l2.5-7h13L19 11v4a2 2 0 01-2 2h-2M5 17a2 2 0 104 0m6 0a2 2 0 104 0"/></svg></span>
          Quản lý xe
        </a>

        @if(Auth::user()->canManageStaff())
          <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
            <span class="icon-wrap icon-amber"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg></span>
            Đơn hàng
          </a>
        @endif

        @if(Auth::user()->isStaff())
          <a href="{{ route('admin.staff.orders.index') }}" class="nav-link {{ request()->routeIs('admin.staff.orders*') ? 'active' : '' }}">
            <span class="icon-wrap icon-amber"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg></span>
            Đơn hàng của tôi
          </a>
        @endif

        <a href="{{ route('admin.staff.customers') }}" class="nav-link {{ request()->routeIs('admin.staff.customers*') ? 'active' : '' }}">
          <span class="icon-wrap icon-teal"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg></span>
          @if(Auth::user()->isStaff()) Khách hàng của tôi
          @else Quản lý khách hàng
          @endif
        </a>

        @if(Auth::user()->canManageStaff())
          <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <span class="icon-wrap icon-teal"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg></span>
            Quản lý nhân viên
          </a>
        @endif
      </div>
    </div>

    @php
      $kpiActive = request()->routeIs('admin.kpi*') || request()->routeIs('admin.attendance*') || request()->routeIs('admin.staff.attendance*');
    @endphp
    <button class="nav-group-btn open" id="btn-kpi" onclick="toggleGroup('kpi')" aria-expanded="true">
      <span>KPI</span>
      <svg class="chev" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
    </button>
    <div class="nav-group-content" id="grp-kpi">
      <div class="nav-group-inner">
        @if(Auth::user()->canManageStaff())
          <a href="{{ route('admin.kpi.index') }}" class="nav-link {{ request()->routeIs('admin.kpi.index') || request()->routeIs('admin.kpi.show') ? 'active' : '' }}">
            <span class="icon-wrap icon-cyan"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></span>
            Xem KPI nhân viên
          </a>
          <a href="{{ route('admin.attendance.index') }}" class="nav-link {{ request()->routeIs('admin.attendance*') ? 'active' : '' }}">
            <span class="icon-wrap icon-slate"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></span>
            Chấm công nhân viên
          </a>
        @endif

        @if(Auth::user()->isStaff() || Auth::user()->isManager())
          <a href="{{ route('admin.kpi.me') }}" class="nav-link {{ request()->routeIs('admin.kpi.me') ? 'active' : '' }}">
            <span class="icon-wrap icon-cyan"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></span>
            KPI của tôi
          </a>
          <a href="{{ route('admin.staff.attendance') }}" class="nav-link {{ request()->routeIs('admin.staff.attendance*') ? 'active' : '' }}">
            <span class="icon-wrap icon-slate"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></span>
            Chấm công của tôi
          </a>
        @endif
      </div>
    </div>

    {{-- ── TÍNH LƯƠNG — chỉ hiển thị cho Admin ── --}}
    @if(Auth::user()->isAdmin())
    <button class="nav-group-btn open" id="btn-luong" onclick="toggleGroup('luong')" aria-expanded="true">
      <span>Tính lương</span>
      <svg class="chev" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
    </button>
    <div class="nav-group-content" id="grp-luong">
      <div class="nav-group-inner">
        <a href="{{ route('admin.payroll.index') }}" class="nav-link {{ request()->routeIs('admin.payroll.index') || request()->routeIs('admin.payroll.show') || request()->routeIs('admin.payroll.calculate') ? 'active' : '' }}">
          <span class="icon-wrap icon-green">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <line x1="12" y1="1" x2="12" y2="23"/>
              <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
            </svg>
          </span>
          Bảng lương
        </a>
        <a href="{{ route('admin.payroll.salary.index') }}" class="nav-link {{ request()->routeIs('admin.payroll.salary*') ? 'active' : '' }}">
          <span class="icon-wrap icon-amber">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <rect x="2" y="3" width="20" height="14" rx="2"/>
              <path d="M8 21h8M12 17v4"/>
            </svg>
          </span>
          Quản lý lương cứng
        </a>
      </div>
    </div>
    @endif

    @if(Auth::user()->canManageStaff())
      <button class="nav-group-btn open" id="btn-taichi" onclick="toggleGroup('taichi')" aria-expanded="true">
        <span>Tài chính</span>
        <svg class="chev" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
      </button>
      <div class="nav-group-content" id="grp-taichi">
        <div class="nav-group-inner">
          <a href="{{ route('admin.profit.index') }}" class="nav-link {{ request()->routeIs('admin.profit*') ? 'active' : '' }}">
            <span class="icon-wrap icon-green"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg></span>
            Lợi nhuận xe
          </a>
        </div>
      </div>

      <button class="nav-group-btn open" id="btn-hethong" onclick="toggleGroup('hethong')" aria-expanded="true">
        <span>Hệ thống</span>
        <svg class="chev" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
      </button>
      <div class="nav-group-content" id="grp-hethong">
        <div class="nav-group-inner">
          <a href="{{ route('admin.notifications.index') }}" class="nav-link {{ request()->routeIs('admin.notifications*') ? 'active' : '' }}">
            <span class="icon-wrap icon-amber"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg></span>
            Thông báo nội bộ
          </a>
          <a href="{{ route('admin.news.index') }}" class="nav-link {{ request()->routeIs('admin.news*') ? 'active' : '' }}">
            <span class="icon-wrap icon-violet"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v8a2 2 0 01-2 2z"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="13" y2="17"/></svg></span>
            Tin tức
          </a>
          <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ request()->routeIs('admin.contacts*') ? 'active' : '' }}">
            <span class="icon-wrap icon-red"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 4h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2z"/><polyline points="22,6 12,13 2,6"/></svg></span>
            Email & Liên hệ
            @php $unread = \App\Models\Contact::where('is_read', false)->count(); @endphp
            @if($unread > 0)<span class="nav-badge">{{ $unread }}</span>@endif
          </a>
          <a href="{{ route('admin.newsletter.index') }}" class="nav-link {{ request()->routeIs('admin.newsletter*') ? 'active' : '' }}">
            <span class="icon-wrap icon-sky"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg></span>
            Newsletter
          </a>
        </div>
      </div>
    @endif

  </nav>

  <div class="sidebar-foot">
    <a href="{{ route('admin.profile') }}" class="user-chip"
       style="text-decoration:none; transition: background .15s;"
       onmouseover="this.style.background='#252525'"
       onmouseout="this.style.background=''">
      <div class="avatar" style="overflow:hidden; padding:0;">
        @if(Auth::user()->avatar)
          <img src="/images/{{ Auth::user()->avatar }}" style="width:100%;height:100%;object-fit:cover;">
        @else
          {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        @endif
      </div>
      <div>
        <div class="user-name">{{ Auth::user()->name }}</div>
        <div class="user-role">
          @if(Auth::user()->isAdmin()) Admin
          @elseif(Auth::user()->isManager()) Manager
          @else Nhân viên
          @endif
        </div>
      </div>
    </a>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="logout-btn">Đăng xuất</button>
    </form>
  </div>
</aside>

<button class="sb-admin-toggle" id="sb-admin-toggle" title="Thu/mở menu">
  <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
    <polyline points="15 18 9 12 15 6"/>
  </svg>
</button>

<div class="main" id="admin-main">
  <div class="topbar">
    <button class="hamburger" onclick="openSidebar()" aria-label="Menu">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <line x1="3" y1="6" x2="21" y2="6"/>
        <line x1="3" y1="12" x2="21" y2="12"/>
        <line x1="3" y1="18" x2="21" y2="18"/>
      </svg>
    </button>

    <div class="page-title">@yield('page-title', 'Admin')</div>

    {{-- 🔔 NOTIFICATION BELL --}}
    <div class="notif-wrap" style="margin-right:10px">
      <button class="notif-btn" id="notif-btn" onclick="toggleNotif()" title="Thông báo">
        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
          <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
          <path d="M13.73 21a2 2 0 01-3.46 0"/>
        </svg>
        <span class="notif-count" id="notif-count"></span>
      </button>

      <div class="notif-panel" id="notif-panel">
        <div class="notif-panel-hd">
          <span>🔔 Thông báo</span>
          <button onclick="markAllRead()">Đánh dấu đọc tất cả</button>
        </div>
        <div class="notif-list" id="notif-list">
          <div class="notif-empty">Đang tải...</div>
        </div>
        @if(Auth::user()->canManageStaff())
        <div class="notif-footer">
          <a href="{{ route('admin.notifications.index') }}">Quản lý thông báo →</a>
        </div>
        @endif
      </div>
    </div>

    @yield('topbar-actions')
  </div>

  <div class="content">
    @if(session('success'))
      <div class="alert alert-success flash">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-error flash">{{ session('error') }}</div>
    @endif
    @yield('content')
  </div>
</div>

<script>
const NOTIF_UNREAD_URL  = '{{ route("admin.notifications.unread") }}';
const NOTIF_READ_URL    = '{{ url("admin/notifications") }}';
const CSRF              = document.querySelector('meta[name="csrf-token"]').content;

let notifOpen   = false;
let notifLoaded = false;

function toggleNotif() {
  notifOpen = !notifOpen;
  document.getElementById('notif-panel').classList.toggle('open', notifOpen);
  if (notifOpen && !notifLoaded) { loadNotifications(); notifLoaded = true; }
}

document.addEventListener('click', function(e) {
  const wrap = document.querySelector('.notif-wrap');
  if (notifOpen && wrap && !wrap.contains(e.target)) {
    notifOpen = false;
    document.getElementById('notif-panel').classList.remove('open');
  }
});

function openSidebar() {
  document.getElementById('sidebar').classList.add('open');
  document.getElementById('sidebar-overlay').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeSidebar() {
  document.getElementById('sidebar').classList.remove('open');
  document.getElementById('sidebar-overlay').classList.remove('open');
  document.body.style.overflow = '';
}

async function loadNotifications() {
  const res  = await fetch(NOTIF_UNREAD_URL, { headers: { 'X-CSRF-TOKEN': CSRF } });
  const data = await res.json();
  updateBadge(data.unread_count);
  renderList(data.items);
}

function updateBadge(count) {
  const el = document.getElementById('notif-count');
  if (count > 0) { el.textContent = count > 99 ? '99+' : count; el.style.display = 'block'; }
  else { el.style.display = 'none'; }
}

function renderList(items) {
  const list = document.getElementById('notif-list');
  if (!items.length) { list.innerHTML = '<div class="notif-empty">📭 Không có thông báo nào</div>'; return; }
  list.innerHTML = items.map(n => `
    <div class="notif-item ${n.is_read ? '' : 'unread'}" onclick="readNotif(${n.id}, this)">
      <div class="notif-item-title">
        <span>${n.icon}</span><span>${n.title}</span>
        ${!n.is_read ? '<span class="notif-unread-dot"></span>' : ''}
      </div>
      <div class="notif-item-body">${n.body}</div>
      <div class="notif-item-meta">${n.creator} · ${n.created_at}</div>
    </div>
  `).join('');
}

async function readNotif(id, el) {
  if (!el.classList.contains('unread')) return;
  await fetch(`${NOTIF_READ_URL}/${id}/read`, {
    method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' }
  });
  el.classList.remove('unread');
  el.querySelector('.notif-unread-dot')?.remove();
  const countEl = document.getElementById('notif-count');
  updateBadge(Math.max(0, (parseInt(countEl.textContent) || 0) - 1));
}

async function markAllRead() {
  await fetch('{{ route("admin.notifications.markAllRead") }}', {
    method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF }
  });
  document.querySelectorAll('.notif-item.unread').forEach(el => {
    el.classList.remove('unread');
    el.querySelector('.notif-unread-dot')?.remove();
  });
  updateBadge(0);
}

window.addEventListener('DOMContentLoaded', async () => {
  try {
    const res  = await fetch(NOTIF_UNREAD_URL);
    const data = await res.json();
    updateBadge(data.unread_count);
  } catch(e) {}
});

setInterval(async () => {
  try {
    notifLoaded = false;
    const res  = await fetch(NOTIF_UNREAD_URL);
    const data = await res.json();
    updateBadge(data.unread_count);
  } catch(e) {}
}, 60000);

function toggleGroup(id) {
  const btn = document.getElementById('btn-' + id);
  const grp = document.getElementById('grp-' + id);
  if (!btn || !grp) return;
  const isOpen = !grp.classList.contains('closed');
  grp.classList.toggle('closed', isOpen);
  btn.classList.toggle('open', !isOpen);
  btn.setAttribute('aria-expanded', String(!isOpen));
  try { localStorage.setItem('nav-grp-' + id, isOpen ? '0' : '1'); } catch(e) {}
}

document.addEventListener('DOMContentLoaded', function() {
  ['quanly', 'kpi', 'luong', 'taichi', 'hethong'].forEach(function(id) {
    const btn = document.getElementById('btn-' + id);
    const grp = document.getElementById('grp-' + id);
    if (!btn || !grp) return;
    try {
      const saved = localStorage.getItem('nav-grp-' + id);
      if (saved === '0') {
        grp.classList.add('closed');
        btn.classList.remove('open');
        btn.setAttribute('aria-expanded', 'false');
      }
    } catch(e) {}
  });
});
</script>

@stack('scripts')
<script>
(function() {
  var sidebar  = document.getElementById('sidebar');
  var main     = document.getElementById('admin-main');
  var btn      = document.getElementById('sb-admin-toggle');
  var collapsed = localStorage.getItem('admin-sb-collapsed') === '1';

  function isMobile() { return window.innerWidth <= 768; }

  function apply() {
    if (isMobile()) {
      sidebar.classList.remove('collapsed');
      main.classList.remove('sb-collapsed');
      btn.classList.remove('collapsed');
      return;
    }
    if (collapsed) {
      sidebar.classList.add('collapsed');
      main.classList.add('sb-collapsed');
      btn.classList.add('collapsed');
    } else {
      sidebar.classList.remove('collapsed');
      main.classList.remove('sb-collapsed');
      btn.classList.remove('collapsed');
    }
  }
  apply();

  window.addEventListener('resize', apply);

  btn.addEventListener('click', function() {
    collapsed = !collapsed;
    localStorage.setItem('admin-sb-collapsed', collapsed ? '1' : '0');
    apply();
  });
})();
</script>
</body>
</html>