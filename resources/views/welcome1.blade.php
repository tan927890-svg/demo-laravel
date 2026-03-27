<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xe Ô Tô - Showroom Trực Tuyến Hàng Đầu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --bg: #f5f6f8;
            --bg2: #ffffff;
            --bg3: #f0f2f5;
            --text: #1a1f2e;
            --text2: #4a5568;
            --muted: #8896a8;
            --accent: #c8920a;
            --accent-light: #fef3d0;
            --accent-hover: #a87308;
            --border: rgba(0,0,0,0.08);
            --shadow: 0 2px 16px rgba(0,0,0,0.08);
            --shadow-md: 0 8px 32px rgba(0,0,0,0.12);
            --ff-head: 'Playfair Display', Georgia, serif;
            --ff-body: 'DM Sans', sans-serif;
        }
        html, body { background: var(--bg); color: var(--text); font-family: var(--ff-body); }

        /* ===== NAVBAR ===== */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            background: rgba(255,255,255,0.96);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 6vw; height: 64px;
            box-shadow: 0 1px 12px rgba(0,0,0,0.06);
        }
        .navbar-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; color: var(--text); }
        .navbar-brand svg { width: 28px; height: 28px; }
        .navbar-brand span { font-family: var(--ff-head); font-size: 18px; font-weight: 700; color: var(--text); }
        .navbar-links { display: flex; align-items: center; gap: 28px; }
        .navbar-links a { color: var(--text2); text-decoration: none; font-size: 14px; font-weight: 400; transition: color 0.2s; }
        .navbar-links a:hover { color: var(--accent); }
        .navbar-actions { display: flex; align-items: center; gap: 10px; }

        /* ===== DROPDOWN ===== */
        .nav-dropdown { position: relative; }
        .nav-dropdown-btn {
            color: var(--text2); font-size: 14px; font-weight: 400;
            background: none; border: none; cursor: pointer;
            font-family: var(--ff-body); padding: 0;
            display: flex; align-items: center; gap: 5px;
            transition: color 0.2s;
        }
        .nav-dropdown-btn:hover { color: var(--accent); }
        .nav-dropdown-btn svg { width: 12px; height: 12px; transition: transform 0.2s; }
        .nav-dropdown:hover .nav-dropdown-btn svg { transform: rotate(180deg); }
        .dropdown-menu {
            position: absolute; top: calc(100% + 16px); left: 50%;
            transform: translateX(-50%);
            background: #fff; border-radius: 14px;
            border: 1.5px solid var(--border);
            box-shadow: 0 16px 48px rgba(0,0,0,0.12);
            min-width: 220px; padding: 8px;
            opacity: 0; visibility: hidden;
            transform: translateX(-50%) translateY(-8px);
            transition: all 0.2s ease;
            z-index: 200;
        }
        .nav-dropdown:hover .dropdown-menu {
            opacity: 1; visibility: visible;
            transform: translateX(-50%) translateY(0);
        }
        .dropdown-menu::before {
            content: ''; position: absolute; top: -6px; left: 50%;
            transform: translateX(-50%);
            width: 12px; height: 12px; background: #fff;
            border-left: 1.5px solid var(--border);
            border-top: 1.5px solid var(--border);
            transform: translateX(-50%) rotate(45deg);
        }
        .dropdown-item {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 14px; border-radius: 9px;
            text-decoration: none; color: var(--text2);
            font-size: 13px; font-weight: 400;
            transition: all 0.15s;
        }
        .dropdown-item:hover { background: var(--accent-light); color: var(--accent); }
        .dropdown-item-icon {
            width: 34px; height: 34px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; flex-shrink: 0;
        }
        .dropdown-item-text { line-height: 1.4; }
        .dropdown-item-title { font-weight: 600; color: var(--text); font-size: 13px; }
        .dropdown-item:hover .dropdown-item-title { color: var(--accent); }
        .dropdown-item-sub { font-size: 11px; color: var(--muted); margin-top: 1px; }
        .dropdown-divider { height: 1px; background: var(--border); margin: 6px 8px; }
        .btn-nav-outline {
            background: transparent; color: var(--text);
            font-family: var(--ff-body); font-size: 13px; font-weight: 500;
            padding: 8px 20px; border: 1.5px solid var(--border);
            border-radius: 8px; cursor: pointer; text-decoration: none;
            transition: all 0.2s;
        }
        .btn-nav-outline:hover { border-color: var(--accent); color: var(--accent); }
        .btn-nav-primary {
            background: var(--accent); color: #fff;
            font-family: var(--ff-body); font-size: 13px; font-weight: 500;
            padding: 8px 20px; border: none; border-radius: 8px;
            cursor: pointer; text-decoration: none; transition: background 0.2s;
        }
        .btn-nav-primary:hover { background: var(--accent-hover); }

        /* ===== HERO SLIDESHOW ===== */
        .hero {
            margin-top: 64px;
            position: relative;
            height: 88vh; min-height: 560px;
            overflow: hidden;
        }
        .slide {
            position: absolute; inset: 0;
            opacity: 0; transition: opacity 1s ease-in-out;
            background-size: cover; background-position: center;
        }
        .slide.active { opacity: 1; }
        .slide::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(90deg, rgba(10,12,18,0.72) 0%, rgba(10,12,18,0.3) 55%, transparent 100%);
        }

        /* Các ảnh slide - thay src bằng ảnh thật của bạn */
        .slide-1 { background-image: url('/images/cars/hero-1.jpg'); }
        .slide-2 { background-image: url('/images/cars/hero-2.jpg'); }
        .slide-3 { background-image: url('/images/cars/hero-3.jpg'); }

        .hero-content {
            position: absolute; z-index: 10;
            top: 50%; left: 6vw;
            transform: translateY(-50%);
            max-width: 560px; color: #fff;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            font-size: 11px; letter-spacing: 0.15em; text-transform: uppercase;
            color: #f5d87a; border: 1px solid rgba(245,216,122,0.4);
            padding: 6px 14px; border-radius: 20px; margin-bottom: 24px;
            background: rgba(245,216,122,0.1);
        }
        .hero-badge span { width: 6px; height: 6px; background: #f5d87a; border-radius: 50%; display: inline-block; }
        .hero-title {
            font-family: var(--ff-head);
            font-size: clamp(36px, 5vw, 64px); font-weight: 700;
            line-height: 1.1; margin-bottom: 18px; color: #fff;
        }
        .hero-title em { font-style: normal; color: #f5d87a; }
        .hero-subtitle { font-size: 16px; line-height: 1.8; color: rgba(255,255,255,0.8); margin-bottom: 36px; max-width: 420px; }
        .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn-hero-primary {
            background: var(--accent); color: #fff;
            font-family: var(--ff-body); font-size: 14px; font-weight: 500;
            padding: 14px 32px; border: none; border-radius: 8px;
            cursor: pointer; text-decoration: none; display: inline-block;
            transition: background 0.2s, transform 0.15s;
        }
        .btn-hero-primary:hover { background: var(--accent-hover); transform: translateY(-1px); }
        .btn-hero-outline {
            background: rgba(255,255,255,0.12); color: #fff;
            font-family: var(--ff-body); font-size: 14px;
            padding: 14px 32px; border: 1.5px solid rgba(255,255,255,0.35);
            border-radius: 8px; cursor: pointer; text-decoration: none; display: inline-block;
            transition: all 0.2s; backdrop-filter: blur(4px);
        }
        .btn-hero-outline:hover { background: rgba(255,255,255,0.22); border-color: rgba(255,255,255,0.6); }

        /* Slide indicators */
        .slide-dots {
            position: absolute; bottom: 32px; left: 6vw;
            display: flex; gap: 10px; z-index: 10;
        }
        .dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: rgba(255,255,255,0.4); cursor: pointer;
            transition: all 0.3s; border: none;
        }
        .dot.active { background: #f5d87a; width: 28px; border-radius: 4px; }

        /* Slide arrows */
        .slide-arrow {
            position: absolute; top: 50%; z-index: 10;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.15); border: 1.5px solid rgba(255,255,255,0.3);
            color: #fff; width: 48px; height: 48px;
            border-radius: 50%; cursor: pointer; font-size: 18px;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s; backdrop-filter: blur(4px);
        }
        .slide-arrow:hover { background: rgba(255,255,255,0.28); }
        .slide-prev { left: 24px; }
        .slide-next { right: 24px; }

        /* Stats overlay */
        .hero-stats {
            position: absolute; bottom: 32px; right: 6vw;
            display: flex; gap: 32px; z-index: 10;
        }
        .stat-item { text-align: center; }
        .stat-num { font-family: var(--ff-head); font-size: 26px; font-weight: 700; color: #fff; }
        .stat-lbl { font-size: 11px; color: rgba(255,255,255,0.65); letter-spacing: 0.06em; margin-top: 2px; }
        .stat-div { width: 1px; background: rgba(255,255,255,0.2); height: 36px; align-self: center; }

        /* ===== SEARCH BAR ===== */
        .search-section {
            padding: 0 6vw;
            margin-top: 32px;
            position: relative; z-index: 20;
        }
        .search-bar {
            background: #fff; border-radius: 14px;
            padding: 20px 24px;
            display: flex; gap: 12px; align-items: center; flex-wrap: wrap;
            box-shadow: 0 8px 40px rgba(0,0,0,0.10);
            border: 1.5px solid var(--border);
        }
        .search-bar select, .search-bar input {
            background: var(--bg3); border: 1.5px solid transparent;
            color: var(--text); font-family: var(--ff-body);
            font-size: 14px; padding: 11px 14px; border-radius: 8px;
            flex: 1; min-width: 140px; outline: none; transition: border-color 0.2s;
        }
        .search-bar select:focus, .search-bar input:focus { border-color: var(--accent); background: #fff; }
        .search-bar option { background: #fff; color: var(--text); }
        .btn-search {
            background: var(--accent); color: #fff;
            font-family: var(--ff-body); font-size: 14px; font-weight: 500;
            padding: 12px 28px; border: none; border-radius: 8px;
            cursor: pointer; white-space: nowrap; flex: 0;
            transition: background 0.2s;
        }
        .btn-search:hover { background: var(--accent-hover); }

        /* ===== SECTIONS ===== */
        .section { padding: 72px 6vw; }
        .section-header { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 36px; }
        .section-label { font-size: 11px; letter-spacing: 0.15em; text-transform: uppercase; color: var(--accent); margin-bottom: 8px; font-weight: 500; }
        .section-title { font-family: var(--ff-head); font-size: clamp(26px, 3vw, 38px); font-weight: 700; color: var(--text); }
        .link-all { font-size: 13px; color: var(--accent); text-decoration: none; font-weight: 500; }
        .link-all:hover { text-decoration: underline; }

        /* ===== CATEGORIES ===== */
        .cats-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            justify-content: center;
        }
        .cat-card {
            background: #fff; border: 1.5px solid var(--border);
            border-radius: 14px; padding: 0;
            text-align: center; cursor: pointer; transition: all 0.2s;
            text-decoration: none; display: block;
            box-shadow: var(--shadow);
            width: 160px; overflow: hidden;
        }
        .cat-card:hover { border-color: var(--accent); transform: translateY(-3px); box-shadow: var(--shadow-md); }
        .cat-img {
            width: 100%; height: 100px; object-fit: cover; display: block;
            transition: transform 0.3s;
        }
        .cat-card:hover .cat-img { transform: scale(1.05); }
        .cat-img-placeholder {
            width: 100%; height: 100px;
            background: var(--bg3);
            display: flex; align-items: center; justify-content: center;
            font-size: 32px;
        }
        .cat-label { padding: 10px 12px; }
        .cat-name { font-size: 13px; font-weight: 500; color: var(--text); }

        /* ===== CAR CARDS ===== */
        .cars-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap: 22px; }
        .car-card {
            background: #fff; border: 1.5px solid var(--border);
            border-radius: 14px; overflow: hidden;
            transition: all 0.25s;
            text-decoration: none; display: block; color: var(--text);
            box-shadow: var(--shadow);
        }
        .car-card:hover { border-color: var(--accent); transform: translateY(-5px); box-shadow: var(--shadow-md); }
        .car-thumb {
            aspect-ratio: 16/9; background: var(--bg3);
            display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
        }
        .car-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.3s; }
        .car-card:hover .car-thumb img { transform: scale(1.05); }
        .car-thumb-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 8px; }
        .car-tag {
            position: absolute; top: 12px; left: 12px;
            font-size: 10px; letter-spacing: 0.08em; text-transform: uppercase;
            padding: 5px 12px; border-radius: 6px; font-weight: 600;
        }
        .tag-new { background: var(--accent-light); color: var(--accent); }
        .tag-hot { background: #fde8e8; color: #d03030; }
        .car-info { padding: 20px 22px 22px; }
        .car-brand { font-size: 11px; color: var(--muted); letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 4px; font-weight: 500; }
        .car-name { font-family: var(--ff-head); font-size: 20px; font-weight: 700; margin-bottom: 12px; color: var(--text); }
        .car-specs { display: flex; gap: 14px; margin-bottom: 16px; flex-wrap: wrap; }
        .car-spec { font-size: 12px; color: var(--text2); display: flex; align-items: center; gap: 5px; }
        .car-spec-dot { width: 4px; height: 4px; background: var(--accent); border-radius: 50%; display: inline-block; }
        .car-footer { display: flex; align-items: center; justify-content: space-between; padding-top: 14px; border-top: 1.5px solid var(--border); }
        .car-price { font-family: var(--ff-head); font-size: 20px; font-weight: 700; color: var(--accent); }
        .car-price small { font-family: var(--ff-body); font-size: 11px; color: var(--muted); font-weight: 400; }
        .btn-sm {
            font-size: 12px; padding: 8px 18px;
            background: var(--bg3); color: var(--text);
            border: 1.5px solid var(--border); border-radius: 7px;
            cursor: pointer; transition: all 0.2s;
            font-family: var(--ff-body); text-decoration: none; font-weight: 500;
        }
        .btn-sm:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-light); }

        /* ===== CTA BANNER ===== */
        .cta-banner {
            background: linear-gradient(135deg, #1a1200 0%, #2d1f00 50%, #1a1200 100%);
            border-radius: 18px; padding: 56px;
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 28px;
            position: relative; overflow: hidden;
        }
        .cta-banner::before {
            content: ''; position: absolute; top: -60px; right: -60px;
            width: 300px; height: 300px; border-radius: 50%;
            background: radial-gradient(circle, rgba(200,146,10,0.2) 0%, transparent 70%);
        }
        .cta-title { font-family: var(--ff-head); font-size: clamp(22px, 3vw, 34px); font-weight: 700; margin-bottom: 10px; color: #fff; }
        .cta-sub { font-size: 14px; color: rgba(255,255,255,0.65); }
        .cta-form { display: flex; gap: 10px; flex-wrap: wrap; position: relative; z-index: 1; }
        .cta-input {
            background: rgba(255,255,255,0.1); border: 1.5px solid rgba(255,255,255,0.2);
            color: #fff; font-family: var(--ff-body); font-size: 14px;
            padding: 13px 20px; border-radius: 8px; min-width: 240px; outline: none;
            transition: border-color 0.2s;
        }
        .cta-input::placeholder { color: rgba(255,255,255,0.45); }
        .cta-input:focus { border-color: #f5d87a; }

        /* ===== FOOTER ===== */
        .footer {
            background: var(--text); color: rgba(255,255,255,0.5);
            padding: 32px 6vw; text-align: center; font-size: 13px;
        }
        .footer a { color: rgba(255,255,255,0.7); text-decoration: none; }

        /* ===== TẠI SAO CHỌN CHÚNG TÔI ===== */
        .why-section { background: linear-gradient(135deg, #fffbf0 0%, #fff8e6 100%); }
        .why-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }
        .why-card {
            background: #fff; border-radius: 20px; padding: 40px 28px;
            border: 2px solid transparent;
            box-shadow: 0 4px 24px rgba(200,146,10,0.08);
            transition: all 0.3s ease;
            position: relative; overflow: hidden; text-align: center;
        }
        .why-card::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0;
            height: 4px; background: linear-gradient(90deg, var(--accent), #f5a623);
            transform: scaleX(0); transition: transform 0.3s ease;
        }
        .why-card:hover { transform: translateY(-8px); box-shadow: 0 20px 48px rgba(200,146,10,0.18); border-color: #fde68a; }
        .why-card:hover::after { transform: scaleX(1); }
        .why-icon {
            width: 72px; height: 72px; border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 32px; margin: 0 auto 22px;
            transition: transform 0.3s;
        }
        .why-card:hover .why-icon { transform: scale(1.12) rotate(-5deg); }
        .why-icon-1 { background: linear-gradient(135deg, #fef3d0, #fde68a); }
        .why-icon-2 { background: linear-gradient(135deg, #d1fae5, #6ee7b7); }
        .why-icon-3 { background: linear-gradient(135deg, #dbeafe, #93c5fd); }
        .why-icon-4 { background: linear-gradient(135deg, #fce7f3, #f9a8d4); }
        .why-title { font-size: 17px; font-weight: 700; color: var(--text); margin-bottom: 12px; }
        .why-desc { font-size: 14px; color: var(--text2); line-height: 1.8; }

        /* ===== THƯƠNG HIỆU ===== */
        .brands-section { background: var(--text); }
        .brands-section .section-label { color: #f5d87a; }
        .brands-section .section-title { color: #fff; }
        .brands-track {
            display: flex; gap: 16px; align-items: stretch;
            flex-wrap: wrap; justify-content: center; padding: 8px 0;
        }
        .brand-item {
            display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px;
            padding: 22px 32px; background: rgba(255,255,255,0.07); border-radius: 16px;
            border: 2px solid rgba(255,255,255,0.1); transition: all 0.25s;
            min-width: 120px; cursor: pointer;
        }
        .brand-item:hover {
            border-color: var(--accent); background: rgba(200,146,10,0.15);
            transform: translateY(-5px);
            box-shadow: 0 12px 32px rgba(200,146,10,0.25);
        }
        .brand-logo {
            width: 52px; height: 52px; border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; font-weight: 900; color: #fff;
            font-family: var(--ff-head); transition: all 0.25s;
        }
        .brand-item:hover .brand-logo { background: var(--accent); color: #111; transform: scale(1.1); }
        .brand-name { font-size: 13px; font-weight: 600; color: rgba(255,255,255,0.7); letter-spacing: 0.04em; transition: color 0.25s; }
        .brand-item:hover .brand-name { color: #fff; }

        /* ===== TESTIMONIALS ===== */
        .reviews-section { background: linear-gradient(160deg, #f0f7ff 0%, #e8f0fe 100%); }
        .reviews-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 26px;
        }
        .review-card {
            background: #fff; border-radius: 20px; padding: 34px;
            border: 2px solid transparent;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            transition: all 0.3s ease; position: relative; overflow: hidden;
        }
        .review-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 48px rgba(37,99,235,0.12);
            border-color: #bfdbfe;
        }
        .review-card::before {
            content: '"'; position: absolute; top: 8px; right: 22px;
            font-family: var(--ff-head); font-size: 100px;
            color: rgba(200,146,10,0.08); line-height: 1; pointer-events: none;
        }
        .review-stars { font-size: 20px; margin-bottom: 16px; letter-spacing: 4px; }
        .review-text {
            font-size: 14px; color: var(--text2); line-height: 1.9;
            margin-bottom: 24px; font-style: italic;
            border-left: 4px solid var(--accent); padding-left: 16px;
        }
        .review-author { display: flex; align-items: center; gap: 14px; padding-top: 18px; border-top: 1.5px solid var(--border); }
        .review-avatar {
            width: 48px; height: 48px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; font-weight: 700; color: #fff; flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(0,0,0,0.18);
        }
        .review-name { font-size: 15px; font-weight: 700; color: var(--text); }
        .review-car { font-size: 12px; color: var(--accent); margin-top: 3px; font-weight: 600; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero { height: 70vh; }
            .hero-stats { display: none; }
            .navbar-links { display: none; }
            .cta-banner { padding: 32px 24px; }
            .search-section { margin-top: -20px; }
            .why-grid { grid-template-columns: 1fr 1fr; }
            .reviews-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    {{-- ===== NAVBAR ===== --}}
    <nav class="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">
            <svg viewBox="0 0 50 52" xmlns="http://www.w3.org/2000/svg" fill="none">
                <path d="M49.626 11.564a.809.809 0 0 1 .028.209v10.972a.8.8 0 0 1-.402.694l-9.209 5.302V39.25c0 .286-.152.55-.4.694L20.42 51.01a.814.814 0 0 1-.117.048c-.013.005-.025.014-.038.018a.783.783 0 0 1-.506 0c-.014-.004-.027-.013-.04-.018a.78.78 0 0 1-.116-.048L.402 39.944A.8.8 0 0 1 0 39.25V6.334c0-.072.01-.144.028-.209.006-.023.02-.044.028-.067.015-.042.029-.085.051-.124.015-.026.037-.047.055-.071.023-.032.044-.065.071-.093.023-.023.053-.04.079-.06.029-.024.055-.05.088-.069h.001l9.61-5.533a.802.802 0 0 1 .8 0l9.61 5.533h.002c.032.02.059.045.088.068.026.02.055.038.078.06.028.029.048.062.072.094.017.024.04.045.054.071.023.04.036.082.052.124.008.023.022.044.028.068a.809.809 0 0 1 .028.209v21.427l8.007-4.615V11.563a.81.81 0 0 1 .028-.209c.006-.023.02-.044.028-.068.016-.041.029-.084.052-.124.015-.026.037-.047.054-.071.024-.032.044-.065.072-.093.023-.023.052-.04.078-.06.03-.024.056-.05.088-.069l9.611-5.533a.802.802 0 0 1 .8 0l9.61 5.533c.034.02.06.045.09.068.025.02.054.038.077.06.028.029.048.062.072.094.018.024.04.045.054.071.023.039.036.082.052.124.008.023.022.044.028.068zm-1.574 10.718v-9.124l-3.363 1.936-4.644 2.678v9.124l8.007-4.614zm-9.61 16.505v-9.13l-4.57 2.619-13.05 7.524v9.216l17.62-10.229zM1.602 7.719v31.531l17.618 10.228v-9.214l-9.204-5.206-.003-.002-.004-.002c-.031-.018-.057-.044-.086-.066-.025-.02-.054-.036-.076-.058l-.002-.003c-.026-.025-.044-.056-.066-.084-.02-.027-.044-.05-.06-.078l-.001-.003c-.018-.03-.029-.066-.042-.1-.013-.03-.03-.058-.038-.09v-.001c-.01-.038-.013-.078-.016-.117-.004-.039-.01-.077-.008-.116v-.001-21.429L4.965 9.654 1.602 7.72zm8.81-5.994L2.405 6.334l8.005 4.613 8.006-4.613-8.006-4.609zm4.57 26.13 4.644-2.678V7.719l-3.363 1.936-4.644 2.678v18.438l3.363-1.936zM39.623 6.334l-8.006 4.613 8.006 4.614 8.005-4.614-8.005-4.613zm-.801 10.538-4.644-2.678-3.363-1.936v9.124l4.644 2.678 3.363 1.936v-9.124zM20.02 38.648l11.713-6.733 5.855-3.363-8-4.608-9.2 5.301-8.4 4.835 8.032 4.568z" fill="#FF2D20"/>
            </svg>
            <span>Xe Ô Tô</span>
        </a>
        <div class="navbar-links">
            <a href="{{ route('cars.index') }}">Xe ô tô</a>

            {{-- Dropdown Dịch vụ --}}
            <div class="nav-dropdown">
                <button class="nav-dropdown-btn">
                    Dịch vụ
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                </button>
                <div class="dropdown-menu">
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon" style="background:#fef3d0;">🚗</div>
                        <div class="dropdown-item-text">
                            <div class="dropdown-item-title">Đặt lịch mua xe</div>
                            <div class="dropdown-item-sub">Tư vấn & đặt cọc online</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon" style="background:#d1fae5;">🔧</div>
                        <div class="dropdown-item-text">
                            <div class="dropdown-item-title">Bảo dưỡng xe</div>
                            <div class="dropdown-item-sub">Đặt lịch bảo dưỡng định kỳ</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon" style="background:#dbeafe;">🛡️</div>
                        <div class="dropdown-item-text">
                            <div class="dropdown-item-title">Bảo hiểm xe</div>
                            <div class="dropdown-item-sub">Tư vấn gói bảo hiểm phù hợp</div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon" style="background:#fce7f3;">🔄</div>
                        <div class="dropdown-item-text">
                            <div class="dropdown-item-title">Đổi xe / Thu cũ</div>
                            <div class="dropdown-item-sub">Định giá xe cũ miễn phí</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon" style="background:#ede9fe;">🏦</div>
                        <div class="dropdown-item-text">
                            <div class="dropdown-item-title">Vay trả góp</div>
                            <div class="dropdown-item-sub">Lãi suất từ 6.9%/năm</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon" style="background:#fef9c3;">🧪</div>
                        <div class="dropdown-item-text">
                            <div class="dropdown-item-title">Lái thử miễn phí</div>
                            <div class="dropdown-item-sub">Tại showroom hoặc tại nhà</div>
                        </div>
                    </a>
                </div>
            </div>

            <a href="#">Liên hệ</a>

            @auth
                <a href="{{ route('orders.index') }}">Đơn hàng của tôi</a>
                @if(auth()->user()->is_admin ?? false)
                    <a href="{{ route('admin.dashboard') }}" style="color: var(--accent); font-weight:500;">Quản trị</a>
                @endif
            @endauth
        </div>
        <div class="navbar-actions">
            @auth
                <span style="font-size:13px; color:var(--text2);">{{ auth()->user()->name }}</span>
                <a href="{{ route('dashboard') }}" class="btn-nav-outline">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-nav-outline" style="cursor:pointer;">Đăng xuất</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-nav-outline">Đăng nhập</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-nav-primary">Đăng ký</a>
                @endif
            @endauth
        </div>
    </nav>

    {{-- ===== HERO SLIDESHOW ===== --}}
    {{--
        Thêm ảnh vào thư mục: public/images/cars/
        Đặt tên: hero-1.jpg, hero-2.jpg, hero-3.jpg
        Hoặc sửa background-image trong CSS bên trên
    --}}
    <section class="hero" id="heroSlider">

        <div class="slide slide-1 active"></div>
        <div class="slide slide-2"></div>
        <div class="slide slide-3"></div>

        <div class="hero-content">
            <div class="hero-badge"><span></span> Showroom trực tuyến hàng đầu</div>
            <h1 class="hero-title">Tìm chiếc xe <em>hoàn hảo</em> của bạn</h1>
            <p class="hero-subtitle">Hơn 500+ mẫu xe từ các thương hiệu hàng đầu thế giới. Giá tốt nhất, dịch vụ chuyên nghiệp.</p>
            <div class="hero-actions">
                <a href="{{ route('cars.index') }}" class="btn-hero-primary">Khám phá xe ngay</a>
                @auth
                    <a href="{{ route('orders.index') }}" class="btn-hero-outline">Đơn hàng của tôi</a>
                @else
                    <a href="{{ route('register') }}" class="btn-hero-outline">Đăng ký ngay</a>
                @endauth
            </div>
        </div>

        {{-- Arrows --}}
        <button class="slide-arrow slide-prev" onclick="changeSlide(-1)">&#8592;</button>
        <button class="slide-arrow slide-next" onclick="changeSlide(1)">&#8594;</button>

        {{-- Dots --}}
        <div class="slide-dots">
            <button class="dot active" onclick="goToSlide(0)"></button>
            <button class="dot" onclick="goToSlide(1)"></button>
            <button class="dot" onclick="goToSlide(2)"></button>
        </div>

        {{-- Stats --}}
        <div class="hero-stats">
            <div class="stat-item"><div class="stat-num">500+</div><div class="stat-lbl">Mẫu xe</div></div>
            <div class="stat-div"></div>
            <div class="stat-item"><div class="stat-num">50+</div><div class="stat-lbl">Thương hiệu</div></div>
            <div class="stat-div"></div>
            <div class="stat-item"><div class="stat-num">10K+</div><div class="stat-lbl">Khách hàng</div></div>
        </div>
    </section>

    {{-- ===== SEARCH BAR ===== --}}
    <div class="search-section">
        <form action="{{ route('cars.index') }}" method="GET" class="search-bar">
            <select name="brand">
                <option value="">Tất cả hãng xe</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand }}">{{ $brand }}</option>
                @endforeach
            </select>
            <select name="transmission">
                <option value="">Hộp số</option>
                <option value="Tự động">Tự động</option>
                <option value="Số sàn">Số sàn</option>
                <option value="CVT">CVT</option>
            </select>
            <select name="fuel_type">
                <option value="">Nhiên liệu</option>
                <option value="Xăng">Xăng</option>
                <option value="Diesel">Diesel</option>
                <option value="Hybrid">Hybrid</option>
                <option value="Điện">Điện</option>
            </select>
            <input type="text" name="search" placeholder="Tìm theo tên xe, hãng..."/>
            <button type="submit" class="btn-search">🔍 Tìm kiếm</button>
        </form>
    </div>

    {{-- ===== CATEGORIES ===== --}}
    {{--
        Để thêm ảnh vào danh mục, lưu ảnh vào:
        public/images/cats/sedan.jpg
        public/images/cats/suv.jpg
        public/images/cats/mpv.jpg
        public/images/cats/pickup.jpg
        public/images/cats/electric.jpg
        public/images/cats/hybrid.jpg
    --}}
    <section class="section" style="text-align: center;">
        <div style="margin-bottom: 36px;">
            <div class="section-label">Danh mục</div>
            <div class="section-title">Loại xe phổ biến</div>
        </div>
        <div class="cats-grid">
            <a href="{{ route('cars.index', ['search' => 'Sedan']) }}" class="cat-card">
                @if(file_exists(public_path('images/cats/sedan.jpg')))
                    <img src="{{ asset('images/cats/sedan.jpg') }}" alt="Sedan" class="cat-img">
                @else
                    <div class="cat-img-placeholder">🚗</div>
                @endif
                <div class="cat-label"><div class="cat-name">Sedan</div></div>
            </a>
            <a href="{{ route('cars.index', ['search' => 'SUV']) }}" class="cat-card">
                @if(file_exists(public_path('images/cats/suv.jpg')))
                    <img src="{{ asset('images/cats/suv.jpg') }}" alt="SUV" class="cat-img">
                @else
                    <div class="cat-img-placeholder">🚙</div>
                @endif
                <div class="cat-label"><div class="cat-name">SUV</div></div>
            </a>
            <a href="{{ route('cars.index', ['search' => 'MPV']) }}" class="cat-card">
                @if(file_exists(public_path('images/cats/mpv.jpg')))
                    <img src="{{ asset('images/cats/mpv.jpg') }}" alt="MPV" class="cat-img">
                @else
                    <div class="cat-img-placeholder">🚐</div>
                @endif
                <div class="cat-label"><div class="cat-name">MPV</div></div>
            </a>
            <a href="{{ route('cars.index', ['search' => 'Pickup']) }}" class="cat-card">
                @if(file_exists(public_path('images/cats/pickup.jpg')))
                    <img src="{{ asset('images/cats/pickup.jpg') }}" alt="Pickup" class="cat-img">
                @else
                    <div class="cat-img-placeholder">🛻</div>
                @endif
                <div class="cat-label"><div class="cat-name">Pickup</div></div>
            </a>
            <a href="{{ route('cars.index', ['fuel_type' => 'Điện']) }}" class="cat-card">
                @if(file_exists(public_path('images/cats/electric.jpg')))
                    <img src="{{ asset('images/cats/electric.jpg') }}" alt="Điện" class="cat-img">
                @else
                    <div class="cat-img-placeholder">⚡</div>
                @endif
                <div class="cat-label"><div class="cat-name">Điện</div></div>
            </a>
            <a href="{{ route('cars.index', ['fuel_type' => 'Hybrid']) }}" class="cat-card">
                @if(file_exists(public_path('images/cats/hybrid.jpg')))
                    <img src="{{ asset('images/cats/hybrid.jpg') }}" alt="Hybrid" class="cat-img">
                @else
                    <div class="cat-img-placeholder">🌿</div>
                @endif
                <div class="cat-label"><div class="cat-name">Hybrid</div></div>
            </a>
        </div>
    </section>

    {{-- ===== FEATURED CARS ===== --}}
    <section class="section" style="padding-top: 0; background: var(--bg3); margin: 0;">
        <div style="padding: 72px 6vw 80px;">
            <div class="section-header">
                <div>
                    <div class="section-label">Nổi bật</div>
                    <div class="section-title">Xe được xem nhiều nhất</div>
                </div>
                <a href="{{ route('cars.index') }}" class="link-all">Xem tất cả →</a>
            </div>
            <div class="cars-grid">
                @forelse($featuredCars as $car)
                <a href="{{ route('cars.show', $car) }}" class="car-card">
                    <div class="car-thumb">
                        @if($car->image_url)
                            <img src="{{ $car->image_url }}" alt="{{ $car->name }}">
                        @else
                            <div class="car-thumb-placeholder">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#c0cad6" stroke-width="1.5">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <path d="M21 15l-5-5L5 21"/>
                                </svg>
                                <span style="font-size:12px; color:#c0cad6;">Chưa có ảnh</span>
                            </div>
                        @endif
                        <div class="car-tag tag-new">Mới</div>
                    </div>
                    <div class="car-info">
                        <div class="car-brand">{{ $car->brand }}</div>
                        <div class="car-name">{{ $car->name }}</div>
                        <div class="car-specs">
                            @if($car->engine)
                                <span class="car-spec"><span class="car-spec-dot"></span>{{ $car->engine }}</span>
                            @endif
                            @if($car->transmission)
                                <span class="car-spec"><span class="car-spec-dot"></span>{{ $car->transmission }}</span>
                            @endif
                            @if($car->seats)
                                <span class="car-spec"><span class="car-spec-dot"></span>{{ $car->seats }} chỗ</span>
                            @endif
                        </div>
                        <div class="car-footer">
                            <div class="car-price">{{ number_format($car->price / 1e9, 2) }} tỷ <small>VNĐ</small></div>
                            @auth
                                <span class="btn-sm">Đặt mua</span>
                            @else
                                <span class="btn-sm">Xem ngay</span>
                            @endauth
                        </div>
                    </div>
                </a>
                @empty
                <div style="grid-column: 1/-1; text-align:center; padding: 60px 20px; color: var(--muted);">
                    <div style="font-size: 52px; margin-bottom: 16px;">🚗</div>
                    <div style="font-size: 16px; font-weight:500; margin-bottom: 8px;">Chưa có xe nào</div>
                    <div style="font-size: 13px;">Thêm xe qua trang <a href="{{ route('admin.cars.create') }}" style="color:var(--accent);">Admin</a></div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ===== TẠI SAO CHỌN CHÚNG TÔI ===== --}}
    <section style="padding: 80px 6vw; background: linear-gradient(135deg, #fffbf0 0%, #fff8e6 100%);">
        <div style="text-align: center; margin-bottom: 52px;">
            <div class="section-label">Cam kết</div>
            <div class="section-title">Tại sao chọn chúng tôi?</div>
            <p style="font-size:15px; color:var(--text2); margin-top:14px; max-width:520px; margin-left:auto; margin-right:auto; line-height:1.8;">Chúng tôi không chỉ bán xe — chúng tôi mang đến trải nghiệm mua xe tốt nhất</p>
        </div>
        <div style="display:grid; grid-template-columns: repeat(4,1fr); gap:24px; max-width:1200px; margin:0 auto;">
            <div class="why-card">
                <div class="why-icon why-icon-1">🏆</div>
                <div class="why-title">Giá tốt nhất thị trường</div>
                <div class="why-desc">Cam kết mức giá cạnh tranh nhất, minh bạch không phát sinh chi phí ẩn.</div>
            </div>
            <div class="why-card">
                <div class="why-icon why-icon-2">🛡️</div>
                <div class="why-title">Bảo hành chính hãng</div>
                <div class="why-desc">100% xe chính hãng, giấy tờ đầy đủ, bảo hành theo tiêu chuẩn nhà sản xuất.</div>
            </div>
            <div class="why-card">
                <div class="why-icon why-icon-3">🚗</div>
                <div class="why-title">Lái thử miễn phí</div>
                <div class="why-desc">Đặt lịch lái thử tại showroom hoặc tại nhà, hoàn toàn miễn phí, không ràng buộc.</div>
            </div>
            <div class="why-card">
                <div class="why-icon why-icon-4">💳</div>
                <div class="why-title">Hỗ trợ vay trả góp</div>
                <div class="why-desc">Kết nối 10+ ngân hàng, lãi suất từ 6.9%/năm, thủ tục nhanh trong 24h.</div>
            </div>
        </div>
    </section>

    {{-- ===== THƯƠNG HIỆU ===== --}}
    <section style="padding: 64px 6vw; background: var(--text);">
        <div style="text-align: center; margin-bottom: 44px;">
            <div class="section-label" style="color:#f5d87a;">Đối tác</div>
            <div class="section-title" style="color:#fff;">Thương hiệu nổi bật</div>
        </div>
        <div style="display:flex; gap:16px; flex-wrap:wrap; justify-content:center; max-width:1200px; margin:0 auto;">
            <div class="brand-item">
                <div class="brand-logo" style="font-size:28px; color:#eb0a1e; font-weight:900; font-family:serif;">T</div>
                <div class="brand-name">Toyota</div>
            </div>
            <div class="brand-item">
                <div class="brand-logo" style="font-size:28px; color:#cc0000; font-weight:900; font-family:serif;">H</div>
                <div class="brand-name">Honda</div>
            </div>
            <div class="brand-item">
                <div class="brand-logo" style="font-size:22px; color:#1c69d4; font-weight:900; font-family:sans-serif; letter-spacing:-1px;">BMW</div>
                <div class="brand-name">BMW</div>
            </div>
            <div class="brand-item">
                <div class="brand-logo" style="font-size:14px; color:#fff; font-weight:900; font-family:serif; letter-spacing:1px;">★ MB</div>
                <div class="brand-name">Mercedes</div>
            </div>
            <div class="brand-item">
                <div class="brand-logo" style="font-size:22px; color:#002c5f; font-weight:900; font-family:sans-serif;">HY</div>
                <div class="brand-name">Hyundai</div>
            </div>
            <div class="brand-item">
                <div class="brand-logo" style="font-size:22px; color:#BB162B; font-weight:900; font-family:sans-serif;">KIA</div>
                <div class="brand-name">KIA</div>
            </div>
            <div class="brand-item">
                <div class="brand-logo" style="font-size:28px; color:#003478; font-weight:900; font-family:sans-serif;">F</div>
                <div class="brand-name">Ford</div>
            </div>
            <div class="brand-item">
                <div class="brand-logo" style="font-size:22px; color:#C00000; font-weight:900; font-family:sans-serif; letter-spacing:-1px;">MZD</div>
                <div class="brand-name">Mazda</div>
            </div>
        </div>
    </section>

    {{-- ===== ĐÁNH GIÁ KHÁCH HÀNG ===== --}}
    <section style="padding: 80px 6vw; background: linear-gradient(160deg, #f0f7ff 0%, #e8f0fe 100%);">
        <div style="text-align: center; margin-bottom: 48px;">
            <div class="section-label">Phản hồi</div>
            <div class="section-title">Khách hàng nói gì về chúng tôi</div>
            <p style="font-size:15px; color:var(--text2); margin-top:12px; max-width:480px; margin-left:auto; margin-right:auto; line-height:1.7;">Hơn 10.000 khách hàng hài lòng tin tưởng lựa chọn chúng tôi</p>
        </div>
        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:26px; max-width:1200px; margin:0 auto;">
            <div class="review-card">
                <div class="review-stars">★★★★★</div>
                <div class="review-text">Mua Toyota Camry ở đây, dịch vụ rất chuyên nghiệp. Nhân viên tư vấn nhiệt tình, thủ tục nhanh gọn. Xe giao đúng hẹn, tình trạng hoàn hảo.</div>
                <div class="review-author">
                    <div class="review-avatar" style="background: linear-gradient(135deg, #c8920a, #f5a623);">AT</div>
                    <div>
                        <div class="review-name">Anh Tuấn</div>
                        <div class="review-car">Toyota Camry 2024</div>
                    </div>
                </div>
            </div>
            <div class="review-card">
                <div class="review-stars">★★★★★</div>
                <div class="review-text">Đã mua Honda CR-V cho gia đình. Giá cả hợp lý, không bị ép thêm phụ kiện. Chính sách bảo hành rất tốt, yên tâm sử dụng lâu dài.</div>
                <div class="review-author">
                    <div class="review-avatar" style="background: linear-gradient(135deg, #1d4ed8, #3b82f6);">MH</div>
                    <div>
                        <div class="review-name">Minh Hằng</div>
                        <div class="review-car">Honda CR-V 2024</div>
                    </div>
                </div>
            </div>
            <div class="review-card">
                <div class="review-stars">★★★★☆</div>
                <div class="review-text">Trải nghiệm lái thử BMW Series 3 rất tuyệt vời. Nhân viên am hiểu xe, giải đáp mọi thắc mắc. Quyết định mua ngay sau khi lái thử.</div>
                <div class="review-author">
                    <div class="review-avatar" style="background: linear-gradient(135deg, #059669, #10b981);">PL</div>
                    <div>
                        <div class="review-name">Phú Lâm</div>
                        <div class="review-car">BMW Series 3 2024</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CTA BANNER ===== --}}
    <section style="padding: 72px 6vw;">
        <div class="cta-banner">
            <div style="position: relative; z-index: 1;">
                <div class="section-label" style="color: #f5d87a;">Ưu đãi đặc biệt</div>
                <div class="cta-title">Đăng ký nhận thông báo<br>xe mới &amp; khuyến mãi</div>
                <div class="cta-sub">Nhận ngay voucher 5 triệu cho lần mua đầu tiên</div>
            </div>
            <form action="{{ url('/subscribe') }}" method="POST" class="cta-form">
                @csrf
                <input type="email" name="email" class="cta-input" placeholder="Email của bạn..." required/>
                <button type="submit" class="btn-hero-primary">Đăng ký ngay</button>
            </form>
        </div>
    </section>

    {{-- ===== FOOTER ===== --}}
    <footer class="footer">
        <p>© {{ date('Y') }} Xe Ô Tô. Bản quyền thuộc về công ty.</p>
    </footer>

    {{-- ===== SLIDESHOW JS ===== --}}
    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        let autoPlay = setInterval(() => changeSlide(1), 5000);

        function goToSlide(n) {
            slides[currentSlide].classList.remove('active');
            dots[currentSlide].classList.remove('active');
            currentSlide = (n + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        }

        function changeSlide(dir) {
            clearInterval(autoPlay);
            goToSlide(currentSlide + dir);
            autoPlay = setInterval(() => changeSlide(1), 5000);
        }
    </script>

</body>
</html>