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
  <title>@yield('title', 'Concept Car Dealer')</title>

  <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.carousel.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/mega_menu.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.magnific-popup.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/settings.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}" />

  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Barlow:wght@300;400;500;600&family=Barlow+Condensed:wght@700;800&display=swap" rel="stylesheet"/>

<style>
  :root {
    --red: #d42b2b; --red-dark: #b01e1e;
    --bg: #1c1c1e; --bg2: #242426; --bg3: #2c2c2f; --card: #2a2a2d;
    --border: #3a3a3e; --white: #f5f0eb; --text: #c8c3bc; --muted: #8a857e; --subtle: #5a5854;
    --green: #2bbf85;
    --green-light: #e8f7f0;
    --green-hover: #f0faf5;
  }

  html { scroll-behavior: smooth; }
  body {
    background: #1c1c1e;
    color: #c8c3bc;
    font-family: 'Barlow', 'Open Sans', sans-serif;
    font-size: 15px;
    line-height: 1.75;
    overflow-x: hidden;
    margin: 0;
  }
  main { margin-top: 90px; }

  /* ── Owl navigation ── */
  .owl-prev, .owl-next {
    position: absolute !important; top: 40% !important;
    transform: translateY(-50%) !important;
    background: rgba(212,43,43,0.85) !important;
    color: #fff !important; width: 44px !important; height: 44px !important;
    line-height: 44px !important; text-align: center !important;
    opacity: 1 !important; margin: 0 !important; border-radius: 0 !important;
    transition: background .2s !important; z-index: 99 !important;
  }
  .owl-prev:hover, .owl-next:hover { background: #b01e1e !important; }
  .owl-prev { left: 0 !important; }
  .owl-next { right: 0 !important; }

  /* ── Social footer hàng ngang ── */
  .social ul {
    display: flex !important; flex-direction: row !important;
    flex-wrap: wrap; justify-content: center; align-items: center;
    gap: 10px; list-style: none !important; padding: 0 !important; margin: 0 !important;
  }
  .social ul li { display: inline-block !important; margin: 0 !important; }
  .social ul li::before { display: none !important; }

  /* ── Boxster section ── */
  .section-boxster {
    min-height: 400px; display: flex;
    align-items: center; justify-content: center;
    text-align: center; position: relative;
  }
  .section-boxster::before { content: ''; position: absolute; inset: 0; background: rgba(0,0,0,0.55); }
  .section-boxster .custom-block-1 { position: relative; z-index: 2; width: 100%; }

  /* ════════════════════════════════════
     HEADER — PILL NAVBAR STYLE
  ════════════════════════════════════ */
  #header {
    position: fixed;
    top: 16px;
    left: 0;
    width: 100%;
    z-index: 9999;
    background: transparent !important;
  }

  #header .menu {
    background: transparent !important;
    border-bottom: none !important;
    padding: 0 !important;
    overflow: visible !important;
  }

  #header .menu nav,
#header .menu nav section,
#header .menu .container,
#header .menu .row,
#header .menu .col-lg-12,
#header .mega-menu,
#header .mega-menu .menu-list-items,
#header nav.mega-menu,
#header section.menu-list-items {
  overflow: visible !important;
  background: transparent !important;
  background-color: transparent !important;
  border: none !important;
  box-shadow: none !important;
  padding-left: 0 !important;
  padding-right: 0 !important;
  max-width: 100% !important;
  margin: 0 !important;
}

  #header .menu nav { background: transparent !important; }
  #header .menu-list-items { background: transparent !important; padding: 0 !important; overflow: visible !important; }

  /* Pill wrapper */
 .navbar-pill {
  background: #fff !important;
  border-radius: 50px;
  box-shadow: 0 4px 24px rgba(0,0,0,0.12);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 6px 12px 6px 10px;
  gap: 8px;
  position: relative;
  overflow: visible !important;
  max-width: 780px;
  margin: 0 auto;
}
  /* Brand */
  .nb-brand {
    display: flex; align-items: center; gap: 10px;
    flex-shrink: 0; text-decoration: none !important;
  }
  .nb-icon {
    width: 46px; height: 46px;
    background: var(--green-light);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
    flex-shrink: 0;
  }
  .nb-icon img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
  .nb-title { line-height: 1.15; }
  .nb-title strong { display: block; font-size: 16px; font-weight: 700; color: #1a1a1a; font-family: 'Rajdhani', sans-serif; letter-spacing: 0.5px; }
  .nb-title span   { font-size: 10px; color: #aaa; font-weight: 500; letter-spacing: 1.5px; text-transform: uppercase; }

  /* Nav links */
  .nb-links {
    display: flex; align-items: center; gap: 2px;
    list-style: none; margin: 0; padding: 0;
    flex: 1; justify-content: center;
  }
  .nb-links > li { position: relative; }
  .nb-links > li > a {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 8px 14px;
    font-size: 14px; font-weight: 500; color: #555 !important;
    text-decoration: none !important;
    border-radius: 50px;
    font-family: 'Barlow', sans-serif;
    transition: background .18s, color .18s;
    white-space: nowrap;
  }
  .nb-links > li > a:hover { background: var(--green-hover); color: var(--green) !important; }
  .nb-links > li > a.nb-active {
    background: var(--green-light);
    color: var(--green) !important;
    font-weight: 600;
  }

  /* Chevron */
  .nb-chev { font-size: 10px; opacity: 0.6; transition: transform .2s; }
  .nb-links > li:hover .nb-chev { transform: rotate(180deg); }

  /* Dropdown */
  .has-dropdown { position: relative; }
  .has-dropdown .dropdown {
    position: absolute;
    top: 120%; left: 50%;
    transform: translateX(-50%);
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    list-style: none;
    padding: 6px;
    min-width: 200px;
    opacity: 0;
    visibility: hidden;
    transition: all 0.2s ease;
    z-index: 9999;
  }
  .has-dropdown:hover .dropdown {
    opacity: 1;
    visibility: visible;
    top: 110%;
  }
  .dropdown li a {
    display: block;
    padding: 8px 12px;
    border-radius: 8px;
    color: #333;
    font-size: 13px;
    text-decoration: none;
  }
  .dropdown li a:hover {
    background: #e8f7f0;
    color: var(--green);
  }

  /* CTA button */
  .nb-cta {
    flex-shrink: 0;
    background: linear-gradient(135deg, #2bbf85, #1a9e6a);
    color: #fff !important;
    font-size: 13.5px; font-weight: 600;
    padding: 10px 22px;
    border-radius: 50px;
    text-decoration: none !important;
    white-space: nowrap;
    font-family: 'Barlow', sans-serif;
    transition: opacity .18s, transform .18s;
    display: inline-block;
  }
  .nb-cta:hover { opacity: 0.88; transform: translateY(-1px); }

  /* ── Car top scroll button ── */
  .car-top {
    position: fixed;
    bottom: 50px; right: 20px;
    z-index: 999; cursor: pointer;
  }
  .car-top span img { width: 60px; height: auto; display: block; }

  @media (max-width: 991px) {
    .nb-links { gap: 0; }
    .nb-links > li > a { font-size: 12px; padding: 7px 9px; }
    .nb-title strong { font-size: 14px; }
    .nb-cta { font-size: 12px; padding: 8px 16px; }
    .nb-icon { width: 38px; height: 38px; }
    .navbar-pill { max-width: calc(100% - 32px); }
  }

  @media (max-width: 767px) {
    .navbar-pill { border-radius: 16px; padding: 8px 12px; }
    .nb-links { display: none; }
  }

  #loading { display: none !important; }
</style>
  @stack('styles')
</head>
<body>

{{-- ── LOADING ── --}}
<div id="loading">
  <div id="loading-center">
    <img src="{{ asset('images/loader.gif') }}" alt="">
  </div>
</div>

{{-- ── HEADER / NAV ── --}}
<header id="header" class="defualt">
  <div class="menu">
    <nav id="menu" class="mega-menu">
      <section class="menu-list-items">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-md-12">

              <div class="navbar-pill">

                {{-- Brand: Logo + Tên --}}
                <a href="{{ url('/') }}" class="nb-brand">
                  <div class="nb-icon">
                    <img src="{{ asset('images/testimonial/logo.jpg') }}" alt="Logo">
                  </div>
                  <div class="nb-title">
                    <strong>CONCEPT</strong>
                    <span>Car Dealer</span>
                  </div>
                </a>

                {{-- Nav links căn giữa --}}
                <ul class="nb-links">
                  <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'nb-active' : '' }}">Home</a></li>
                  <li><a href="{{ url('/about') }}">About</a></li>
                  <li><a href="{{ url('/cars') }}">Cars</a></li>

                  {{-- Dropdown --}}
                  <li class="has-dropdown">
                    <a href="#">Dịch vụ <i class="fa fa-angle-down"></i></a>
                    <ul class="dropdown">
                      <li><a href="{{ url('/services') }}">Tư vấn & Mua xe</a></li>
                      <li><a href="{{ url('/services#tai-chinh') }}">Tài chính & Vay</a></li>
                      <li><a href="{{ url('/services#bao-duong') }}">Bảo dưỡng</a></li>
                      <li><a href="{{ url('/services#doi-xe') }}">Trade-in</a></li>
                      <li><a href="{{ url('/contact') }}">Liên hệ</a></li>
                    </ul>
                  </li>

                  <li><a href="{{ url('/news') }}">News</a></li>
                </ul>

                {{-- CTA button --}}
                <a href="{{ url('/contact') }}" class="nb-cta">Liên hệ ngay</a>

              </div>

            </div>
          </div>
        </div>
      </section>
    </nav>
  </div>
</header>

{{-- ── CONTENT ── --}}
<main>@yield('content')</main>

{{-- ── FOOTER ── --}}
<footer class="footer bg-2 bg-overlay-black-90">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12">
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-6">
        <div class="about-content">
          <a href="{{ url('/') }}"><img class="img-responsive" src="{{ asset('images/logo-light.png') }}" alt=""></a>
          <p>We provide everything you need to build an amazing dealership website developed especially for car sellers dealers or auto motor retailers.</p>
        </div>
        <div class="address">
          <ul>
            <li><i class="fa fa-map-marker"></i><span>220E Front St. Burlington NC 27215</span></li>
            <li><i class="fa fa-phone"></i><span>(007) 123 456 7890</span></li>
            <li><i class="fa fa-envelope-o"></i><span>support@website.com</span></li>
          </ul>
          <div class="social">
          <ul>
            <li><a class="facebook" href="#">facebook <i class="fa fa-facebook"></i></a></li>
            <li><a class="google-plus" href="#">google plus <i class="fa fa-google-plus"></i></a></li>
            <li><a class="pinterest" href="#">pinterest <i class="fa fa-pinterest-p"></i></a></li>
          </ul>
        </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6">
        <div class="usefull-link">
          <h6 class="text-white">Useful Links</h6>
          <ul>
            <li><a href="#"><i class="fa fa-angle-double-right"></i> Change Oil and Filter</a></li>
            <li><a href="#"><i class="fa fa-angle-double-right"></i> Brake Pads Replacement</a></li>
            <li><a href="#"><i class="fa fa-angle-double-right"></i> Timing Belt Replacement</a></li>
            <li><a href="#"><i class="fa fa-angle-double-right"></i> Pre-purchase Car Inspection</a></li>
            <li><a href="#"><i class="fa fa-angle-double-right"></i> Starter Replacement</a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6">
        <div class="recent-post-block">
          <h6 class="text-white">recent posts</h6>
          <div class="recent-post">
            <div class="recent-post-image"><img class="img-responsive" src="{{ asset('images/car/01.jpg') }}" alt=""></div>
            <div class="recent-post-info">
              <a href="#">Time to change your</a>
              <span class="post-date"><i class="fa fa-calendar"></i>JAN 10, 2018</span>
            </div>
          </div>
          <div class="recent-post">
            <div class="recent-post-image"><img class="img-responsive" src="{{ asset('images/car/02.jpg') }}" alt=""></div>
            <div class="recent-post-info">
              <a href="#">The best time to</a>
              <span class="post-date"><i class="fa fa-calendar"></i>JAN 10, 2018</span>
            </div>
          </div>
          <div class="recent-post">
            <div class="recent-post-image"><img class="img-responsive" src="{{ asset('images/car/03.jpg') }}" alt=""></div>
            <div class="recent-post-info">
              <a href="#">Replacing a timing</a>
              <span class="post-date"><i class="fa fa-calendar"></i>JAN 10, 2018</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6">
        <div class="news-letter">
          <h6 class="text-white">subscribe Our Newsletter</h6>
          <p>Keep up on our always evolving products features and technology. Enter your e-mail and subscribe to our newsletter.</p>
          <form class="news-letter">
            <input type="email" placeholder="Enter your Email" class="form-control placeholder">
            <a class="button red" href="#">Subscribe</a>
          </form>
        </div>
      </div>
    </div>
    <hr/>
    <div class="copyright">
      <div class="row">
        <div class="col-lg-6 col-md-6">
          <div class="text-left">
            <p>©Copyright {{ date('Y') }} <a href="{{ url('/') }}">Concept Car Dealer</a></p>
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <ul class="list-inline text-right">
            <li><a href="#">privacy policy</a> |</li>
            <li><a href="#">terms and conditions</a> |</li>
            <li><a href="{{ url('/contact') }}">contact us</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>

<div class="car-top">
  <span><img src="{{ asset('images/car.png') }}" alt=""></span>
</div>

{{-- ── SCRIPTS ── --}}
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
$(document).ready(function() {
 function fixHeader() {
    $('#header, #header .menu, #header nav, #header section.menu-list-items, #header .menu-list-items').css({
      'background': 'transparent',
      'background-color': 'transparent',
      'border-bottom': 'none',
      'box-shadow': 'none',
      'border': 'none',
      'height': 'auto',
      'top': '16px',
      'width': '100%'
    });

    /* Bỏ giới hạn container trong header */
    $('#header .container, #header .row, #header .col-lg-12').css({
      'max-width': '100%',
      'width': '100%',
      'padding-left': '0',
      'padding-right': '0',
      'margin-left': '0',
      'margin-right': '0'
    });

    $('.navbar-pill').css({
      'max-width': '780px',
      'width': '100%',
      'margin-left': 'auto',
      'margin-right': 'auto',
      'border-radius': '50px',
      'display': 'flex'
    });
  }

  // Chạy ngay
  fixHeader();

  // Chạy mỗi khi scroll
  $(window).on('scroll', fixHeader);

  // Chạy liên tục mỗi 100ms để bắt mọi thay đổi từ mega_menu.js
  setInterval(fixHeader, 100);
});
</script>
@stack('scripts')
</body>
</html>