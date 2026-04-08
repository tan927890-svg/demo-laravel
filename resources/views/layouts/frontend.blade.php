<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="keywords" content="HTML5 Template" />
  <meta name="description" content="Car Dealer - The Best Car Dealer Automotive Responsive HTML5 Template" />
  <meta name="author" content="potenzaglobalsolutions.com" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'AUTO X')</title>

  <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.carousel.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/mega_menu.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.magnific-popup.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/settings.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}" />
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&family=Barlow+Condensed:wght@600;700;800&family=Barlow:wght@300;400;500;600&display=swap" rel="stylesheet"/>

<style>
/* ═══════════════════════════════════════
   RESET & VARIABLES
═══════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; }

:root {
  /* ── Màu header mới: Navy-Blue sang trọng ── */
  --hdr-deep:    #0b1f3a;   /* nền chính — đủ tối để sang */
  --hdr-mid:     #0f2a4e;   /* gradient giữa              */
  --hdr-light:   #143460;   /* gradient nhạt              */
  --hdr-hover:   rgba(255,255,255,0.10);
  --hdr-border:  #c9a84c;   /* viền dưới vàng — sang trọng */
  --hdr-gold:    #c9a84c;
  --hdr-text:    rgba(255,255,255,0.82);

  --red:         #d42b2b;
  --red-dark:    #b01e1e;
  --gold:        #c9a84c;
  --header-h:    72px;
}

html { scroll-behavior: smooth; }

body {
  background: #1c1c1e;
  color: #c8c3bc;
  font-family: 'Barlow', sans-serif;
  font-size: 15px;
  line-height: 1.75;
  overflow-x: hidden;
  margin: 0;
}

main { margin-top: var(--header-h); }
body.home-page main { margin-top: 0; }
.anchor-target { scroll-margin-top: 90px; }
#loading { display: none !important; }

/* ═══════════════════════════════════════
   OWL CAROUSEL
═══════════════════════════════════════ */
.owl-prev, .owl-next {
  position: absolute !important; top: 40% !important;
  transform: translateY(-50%) !important;
  background: rgba(212,43,43,0.85) !important;
  color: #fff !important; width: 44px !important; height: 44px !important;
  line-height: 44px !important; text-align: center !important;
  opacity: 1 !important; margin: 0 !important; border-radius: 0 !important;
  transition: background .2s !important; z-index: 99 !important;
}
.owl-prev:hover, .owl-next:hover { background: var(--red-dark) !important; }
.owl-prev { left: 0 !important; }
.owl-next { right: 0 !important; }

/* ═══════════════════════════════════════
   SECTION BOXSTER
═══════════════════════════════════════ */
.section-boxster {
  min-height: 400px; display: flex;
  align-items: center; justify-content: center;
  text-align: center; position: relative;
}
.section-boxster::before {
  content: ''; position: absolute; inset: 0;
  background: rgba(0,0,0,0.55);
}
.section-boxster .custom-block-1 { position: relative; z-index: 2; width: 100%; }

/* ═══════════════════════════════════════
   HEADER — NAVY-BLUE SANG TRỌNG
═══════════════════════════════════════ */
#header {
  position: fixed !important;
  top: 0 !important; left: 0 !important;
  width: 100% !important;
  z-index: 9999 !important;
  background: transparent !important;
  border: none !important;
  box-shadow: none !important;
  padding: 0 !important;
  height: var(--header-h) !important;
}

#header .menu,
#header .mega-menu,
#header nav,
#header section.menu-list-items,
#header .menu-list-items,
#header .container,
#header .row,
#header .col-lg-12 {
  background:       transparent !important;
  background-color: transparent !important;
  border:           none !important;
  box-shadow:       none !important;
  padding:          0 !important;
  margin:           0 !important;
  max-width:        100% !important;
  width:            100% !important;
  height:           100% !important;
  overflow:         visible !important;
}

/* ── Thanh header ── */
.autox-bar {
  background: linear-gradient(180deg, var(--hdr-light) 0%, var(--hdr-mid) 50%, var(--hdr-deep) 100%);
  border-bottom: 2px solid var(--hdr-border);
  height: var(--header-h);
  width: 100%;
  display: flex;
  align-items: center;
  /* Bóng đổ xanh — tạo chiều sâu sang trọng */
  box-shadow:
    0 4px 28px rgba(11,31,58,0.75),
    0 1px 0 rgba(255,255,255,0.06) inset,
    0 -1px 0 rgba(0,0,0,0.25) inset;
  position: relative;
}

/* Đường highlight mỏng phía trên */
.autox-bar::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent 0%, rgba(201,168,76,0.35) 30%, rgba(255,255,255,0.18) 50%, rgba(201,168,76,0.35) 70%, transparent 100%);
  pointer-events: none;
}

.ax-inner {
  max-width: 1280px;
  width: 100%;
  margin: 0 auto;
  padding: 0 24px;
  display: flex;
  align-items: center;
  height: 100%;
}

/* ── Logo & Brand — GIỮ NGUYÊN ── */
.ax-brand {
  display: flex;
  align-items: center;
  gap: 12px;
  text-decoration: none !important;
  flex-shrink: 0;
  margin-right: 36px;
}
.ax-logo {
  width: 50px; height: 50px;
  border-radius: 50%;
  overflow: hidden;
  border: 2px solid rgba(201,168,76,0.55);
  flex-shrink: 0;
  box-shadow: 0 0 14px rgba(201,168,76,0.22);
}
.ax-logo img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }

.ax-name { line-height: 1.15; }
.ax-name strong {
  display: block;
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 26px;
  font-weight: 800;
  letter-spacing: 3px;
  text-transform: uppercase;
  background: linear-gradient(180deg, #ffffff 0%, #c8d8f0 55%, #8aaad0 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.ax-name span {
  font-size: 9px;
  color: var(--hdr-gold);
  letter-spacing: 3px;
  text-transform: uppercase;
  font-weight: 600;
  font-family: 'Barlow', sans-serif;
}

/* ── Nav Links ── */
.ax-nav {
  display: flex;
  align-items: center;
  list-style: none;
  margin: 0; padding: 0;
  flex: 1;
  justify-content: center;
  height: 100%;
  gap: 0;
}
.ax-nav > li {
  position: relative;
  height: 100%;
  display: flex;
  align-items: center;
}
.ax-nav > li > a {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 0 15px;
  height: 100%;
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 14px;
  font-weight: 700;
  letter-spacing: 1.2px;
  text-transform: uppercase;
  color: var(--hdr-text) !important;
  text-decoration: none !important;
  white-space: nowrap;
  transition: color .2s, background .2s;
  position: relative;
}

/* Gạch vàng dưới — hiệu ứng hover */
.ax-nav > li > a::after {
  content: '';
  position: absolute;
  bottom: 0; left: 15px; right: 15px;
  height: 3px;
  background: var(--hdr-gold);
  border-radius: 2px 2px 0 0;
  transform: scaleX(0);
  transform-origin: center;
  transition: transform .25s ease;
}
.ax-nav > li > a:hover {
  color: #ffffff !important;
  background: var(--hdr-hover);
}
.ax-nav > li > a:hover::after { transform: scaleX(1); }
.ax-nav > li > a.ax-active {
  color: #ffffff !important;
  background: rgba(255,255,255,0.07);
}
.ax-nav > li > a.ax-active::after { transform: scaleX(1); }

/* Chevron */
.ax-chev {
  font-size: 9px; opacity: 0.5;
  transition: transform .2s; display: inline-block;
}
.ax-nav > li:hover .ax-chev { transform: rotate(180deg); }

/* ── Dropdown ── */
.ax-has-dd { position: relative; }
.ax-dropdown {
  position: absolute;
  top: 100%; left: 0;
  background: var(--hdr-deep);
  border-top: 2px solid var(--hdr-gold);
  list-style: none;
  padding: 6px 0;
  min-width: 220px;
  opacity: 0;
  visibility: hidden;
  transform: translateY(-8px);
  transition: opacity .22s, transform .22s, visibility .22s;
  z-index: 99999;
  box-shadow: 0 14px 36px rgba(0,0,0,0.6);
}
.ax-has-dd:hover .ax-dropdown {
  opacity: 1; visibility: visible; transform: translateY(0);
}
.ax-dropdown li a {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 20px;
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 13.5px;
  font-weight: 600;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  color: var(--hdr-text) !important;
  text-decoration: none !important;
  border-left: 3px solid transparent;
  transition: background .15s, color .15s, padding-left .15s, border-color .15s;
}
.ax-dropdown li a::before {
  content: '';
  width: 5px; height: 5px;
  background: var(--hdr-gold);
  border-radius: 50%;
  flex-shrink: 0;
  opacity: 0.4;
  transition: opacity .15s;
}
.ax-dropdown li a:hover {
  background: rgba(255,255,255,0.08);
  color: #fff !important;
  padding-left: 24px;
  border-left-color: var(--hdr-gold);
}
.ax-dropdown li a:hover::before { opacity: 1; }

/* ── Separator ── */
.ax-sep {
  width: 1px; height: 30px;
  background: rgba(255,255,255,0.12);
  flex-shrink: 0;
  margin: 0 16px;
}

/* ── CTA Button ── */
.ax-cta {
  flex-shrink: 0;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: var(--red);
  color: #fff !important;
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 14px;
  font-weight: 800;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  padding: 11px 24px;
  text-decoration: none !important;
  transition: background .2s, transform .15s, box-shadow .2s;
  box-shadow: 0 4px 18px rgba(212,43,43,0.45);
  clip-path: polygon(10px 0%, 100% 0%, calc(100% - 10px) 100%, 0% 100%);
  white-space: nowrap;
}
.ax-cta i { font-size: 14px; opacity: 0.9; }
.ax-cta:hover {
  background: var(--red-dark);
  transform: translateY(-1px);
  box-shadow: 0 6px 24px rgba(212,43,43,0.6);
  color: #fff !important;
}

.ax-admin-link > a { color: var(--hdr-gold) !important; }
.ax-admin-link > a:hover { color: #fff !important; }

/* ═══════════════════════════════════════
   SOCIAL FOOTER (reset cũ)
═══════════════════════════════════════ */
.social ul {
  display: flex !important; flex-direction: row !important;
  flex-wrap: wrap; gap: 8px;
  list-style: none !important; padding: 0 !important; margin: 0 !important;
}
.social ul li { display: inline-block !important; margin: 0 !important; }
.social ul li::before { display: none !important; }

/* ── Social icons có màu sắc ── */
.social ul li a {
  display: inline-flex !important;
  align-items: center !important;
  gap: 6px !important;
  padding: 6px 13px !important;
  border-radius: 6px !important;
  font-size: 12px !important;
  font-weight: 700 !important;
  letter-spacing: 0.4px !important;
  text-decoration: none !important;
  transition: all .2s !important;
  text-transform: capitalize !important;
}
.social ul li a.facebook  { background: #1877f2 !important; color: #fff !important; }
.social ul li a.facebook:hover  { background: #0d65d9 !important; transform: translateY(-2px) !important; }
/* google-plus slot → dùng làm TikTok */
.social ul li a.google-plus { background: #111 !important; color: #fff !important; border: 1px solid #333 !important; }
.social ul li a.google-plus:hover { background: #2a2a2a !important; transform: translateY(-2px) !important; }
/* pinterest slot → YouTube */
.social ul li a.pinterest  { background: #ff0000 !important; color: #fff !important; }
.social ul li a.pinterest:hover  { background: #cc0000 !important; transform: translateY(-2px) !important; }

/* ═══════════════════════════════════════
   RESPONSIVE HEADER
═══════════════════════════════════════ */
@media (max-width: 1199px) {
  .ax-nav > li > a  { padding: 0 11px; font-size: 13px; letter-spacing: 0.7px; }
  .ax-name strong   { font-size: 22px; }
  .ax-brand         { margin-right: 20px; }
  .ax-cta           { padding: 10px 18px; font-size: 13px; }
}
@media (max-width: 991px) {
  .ax-nav   { display: none; }
  .ax-sep   { display: none; }
  .ax-brand { margin-right: auto; }
  .ax-name strong { font-size: 20px; }
  .ax-name span   { display: none; }
}
@media (max-width: 575px) {
  .ax-cta-label { display: none; }
  .ax-cta       { padding: 10px 16px; clip-path: none; border-radius: 4px; }
  .ax-logo      { width: 40px; height: 40px; }
  .ax-name strong { font-size: 18px; letter-spacing: 2px; }
}
</style>

  @stack('styles')
</head>

<body class="{{ request()->is('/') ? 'home-page' : '' }}">

{{-- ── LOADING (ẩn) ── --}}
<div id="loading">
  <div id="loading-center">
    <img src="{{ asset('images/loader.gif') }}" alt="">
  </div>
</div>

{{-- ══════════════════════════════════════════════════
     HEADER
════════════════════════════════════════════════════ --}}
<header id="header">
  <div class="menu">
    <nav id="menu" class="mega-menu">
      <section class="menu-list-items">

        <div class="autox-bar">
          <div class="ax-inner">

            {{-- ── LOGO & TÊN — GIỮ NGUYÊN ── --}}
            <a href="{{ url('/') }}" class="ax-brand">
              <div class="ax-logo">
                <img src="{{ asset('images/testimonial/logo.jpg') }}" alt="AUTO X">
              </div>
              <div class="ax-name">
                <strong>AUTO X</strong>
                <span>Showroom ô tô</span>
              </div>
            </a>

            {{-- ── NAV LINKS ── --}}
            <ul class="ax-nav">

              <li>
                <a href="{{ url('/') }}"
                   class="{{ request()->is('/') ? 'ax-active' : '' }}">
                  Trang Chủ
                </a>
              </li>

              <li>
                <a href="{{ url('/about') }}"
                   class="{{ request()->is('about') ? 'ax-active' : '' }}">
                  Về Chúng Tôi
                </a>
              </li>

              <li>
                <a href="{{ url('/cars') }}"
                   class="{{ request()->is('cars*') ? 'ax-active' : '' }}">
                  Xem Xe
                </a>
              </li>

              {{-- Dropdown Dịch vụ --}}
              <li class="ax-has-dd">
                <a href="{{ url('/services') }}"
                   class="{{ request()->is('services*') ? 'ax-active' : '' }}">
                  Dịch Vụ <span class="ax-chev">&#9660;</span>
                </a>
                <ul class="ax-dropdown">
                  <li><a href="{{ url('/services') }}">Tư Vấn &amp; Mua Xe</a></li>
                  <li><a href="{{ url('/services#tai-chinh') }}">Tài Chính &amp; Vay</a></li>
                  <li><a href="{{ url('/services#bao-duong') }}">Bảo Dưỡng</a></li>
                  <li><a href="{{ url('/services#doi-xe') }}">Trade-in</a></li>
                  <li><a href="{{ url('/contact') }}">Liên Hệ</a></li>
                </ul>
              </li>

              <li>
                <a href="{{ url('/news') }}"
                   class="{{ request()->is('news*') ? 'ax-active' : '' }}">
                  Tin Tức
                </a>
              </li>

              @auth
                @if(Auth::user()->is_admin)
                  <li class="ax-admin-link">
                    <a href="{{ route('admin.dashboard') }}"
                       class="{{ request()->routeIs('admin.*') ? 'ax-active' : '' }}">
                      Admin
                    </a>
                  </li>
                @endif
              @endauth

            </ul>{{-- /.ax-nav --}}

            <div class="ax-sep"></div>

            <a href="{{ url('/contact') }}" class="ax-cta">
              <i class="fa fa-phone"></i>
              <span class="ax-cta-label">Liên Hệ Ngay</span>
            </a>

          </div>{{-- /.ax-inner --}}
        </div>{{-- /.autox-bar --}}

      </section>
    </nav>
  </div>
</header>

{{-- ══════════════════════════════════════════════════
     MAIN CONTENT
════════════════════════════════════════════════════ --}}
<main>
  @yield('content')
</main>

{{-- ══════════════════════════════════════════════════
     FOOTER — THU GỌN, BỎ BÀI VIẾT, ICON MÀU SẮC
════════════════════════════════════════════════════ --}}
<footer class="footer bg-2 bg-overlay-black-90">
  <div class="container">

    {{-- ── Wrapper riêng để tránh bị custom-override.css ẩn nhầm ── --}}
    <div class="footer-main">
    <div class="row">
      {{-- Cột 1: Thương hiệu + địa chỉ + social --}}
      <div class="col-lg-4 col-md-4 col-sm-6">
        <div class="about-content">
          <a href="{{ url('/') }}">
            <span style="font-size:32px;font-weight:900;color:#ffffff;font-family:'Barlow Condensed',sans-serif;letter-spacing:4px;">AUTO X</span>
          </a>
          <p style="margin-top:8px;font-size:13.5px;color:#6b7280;line-height:1.75;">
            Không chỉ bán xe — chúng tôi trao gửi sự an tâm và phong cách sống. Showroom hiện đại, dịch vụ toàn diện từ mua bán đến bảo dưỡng chuyên nghiệp.
          </p>
        </div>
        <div class="address">
          <ul>
            <li><i class="fa fa-map-marker"></i><span>Hẻm 2276/23 Trung Mỹ Tây</span></li>
            <li><i class="fa fa-phone"></i><span>(007) 123 456 7890</span></li>
            <li><i class="fa fa-envelope-o"></i><span>AutoX@gmail.com</span></li>
          </ul>

          {{-- Social icons có màu sắc --}}
          <div class="social" style="margin-top:16px;">
            <ul>
              <li>
                <a class="facebook" href="#">
                  <i class="fa fa-facebook"></i> Facebook
                </a>
              </li>
              <li>
                {{-- Slot google-plus → TikTok (đổi label, giữ class để CSS áp dụng) --}}
                <a class="google-plus" href="#">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="flex-shrink:0;">
                    <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.34 6.34 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.76a4.85 4.85 0 01-1.01-.07z"/>
                  </svg>
                  TikTok
                </a>
              </li>
              <li>
                {{-- Slot pinterest → YouTube --}}
                <a class="pinterest" href="#">
                  <i class="fa fa-youtube-play"></i> YouTube
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      {{-- Cột 2: Liên kết --}}
      <div class="col-lg-4 col-md-4 col-sm-6">
        <div class="usefull-link">
          <h6 class="text-white">Liên Kết</h6>
          <ul>
            <li><a href="{{ url('/') }}"><i class="fa fa-angle-double-right"></i> Trang chủ</a></li>
            <li><a href="{{ url('/about') }}"><i class="fa fa-angle-double-right"></i> Về chúng tôi</a></li>
            <li><a href="{{ url('/cars') }}"><i class="fa fa-angle-double-right"></i> Xem xe</a></li>
            <li><a href="{{ url('/services') }}"><i class="fa fa-angle-double-right"></i> Dịch vụ</a></li>
            <li><a href="{{ url('/news') }}"><i class="fa fa-angle-double-right"></i> Tin tức</a></li>
            <li><a href="{{ url('/contact') }}"><i class="fa fa-angle-double-right"></i> Liên hệ</a></li>
          </ul>
        </div>
      </div>

      {{-- Cột 3: Đăng ký --}}
      <div class="col-lg-4 col-md-4 col-sm-6">
        <div class="news-letter">
          <h6 class="text-white">Đăng Ký Nhận Tin</h6>
          <p>Nhận thông tin xe mới và ưu đãi từ Auto X qua email của bạn.</p>
          <form class="news-letter">
            <input type="email" placeholder="Nhập email của bạn..." class="form-control placeholder">
            <a class="button red" href="#">Đăng Ký</a>
          </form>
        </div>
      </div>

    </div>{{-- /.row --}}
    </div>{{-- /.footer-main --}}

    <hr/>

    <div class="copyright">
      <div class="row">
        <div class="col-lg-6 col-md-6">
          <div class="text-left">
            <p>©Copyright {{ date('Y') }} <a href="{{ url('/') }}">AUTO X</a></p>
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <ul class="list-inline text-right">
            <li><a href="#">Chính sách bảo mật</a> |</li>
            <li><a href="#">Điều khoản</a> |</li>
            <li><a href="{{ url('/contact') }}">Liên hệ</a></li>
          </ul>
        </div>
      </div>
    </div>

  </div>
</footer>

{{-- ══════════════════════════════════════════════════
     SCRIPTS
════════════════════════════════════════════════════ --}}
<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/mega_menu.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.appear.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jquery.tools.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jquery.revolution.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/extensions/revolution.extension.actions.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/extensions/revolution.extension.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/extensions/revolution.extension.kenburn.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/extensions/revolution.extension.layeranimation.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/extensions/revolution.extension.migration.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/extensions/revolution.extension.navigation.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/extensions/revolution.extension.parallax.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/extensions/revolution.extension.slideanims.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/custom-override.css') }}" />

<script>
$(document).ready(function () {
  function lockHeaderStyles() {
    var $h = $('#header');
    $h.add(
      $h.find('.menu, .mega-menu, nav, section, .menu-list-items, .container, .row, .col-lg-12')
    ).each(function () {
      $(this).css({
        'background':       'transparent',
        'background-color': 'transparent',
        'border':           'none',
        'border-bottom':    'none',
        'box-shadow':       'none',
        'height':           'auto',
        'overflow':         'visible',
        'max-width':        '100%',
        'width':            '100%',
        'padding':          '0',
        'margin':           '0'
      });
    });
    $h.css({
      'position': 'fixed',
      'top':      '0',
      'left':     '0',
      'width':    '100%',
      'z-index':  '9999',
      'height':   'auto'
    });
  }

  lockHeaderStyles();

  if (window.MutationObserver) {
    var obs = new MutationObserver(function (mutations) {
      var needFix = false;
      mutations.forEach(function (m) {
        if (m.attributeName === 'style' || m.attributeName === 'class') needFix = true;
      });
      if (needFix) lockHeaderStyles();
    });
    obs.observe(document.getElementById('header'), {
      attributes: true, subtree: true, attributeFilter: ['style', 'class']
    });
  } else {
    setInterval(lockHeaderStyles, 250);
  }
});
</script>

@stack('scripts')
</body>
</html>