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

  {{-- Fonts cho các trang custom (cars, about...) --}}
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Barlow:wght@300;400;500;600&family=Barlow+Condensed:wght@700;800&display=swap" rel="stylesheet"/>

  <style>
    :root {
      --red: #d42b2b; --red-dark: #b01e1e;
      --bg: #1c1c1e; --bg2: #242426; --bg3: #2c2c2f; --card: #2a2a2d;
      --border: #3a3a3e; --white: #f5f0eb; --text: #c8c3bc; --muted: #8a857e; --subtle: #5a5854;
    }
    html { scroll-behavior: smooth; }
    body { background: #1c1c1e; color: #c8c3bc; font-family: 'Barlow', 'Open Sans', sans-serif; font-size: 15px; line-height: 1.75; overflow-x: hidden; }
    main { min-height: calc(100vh - 70px - 300px); }

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

    /* ── Boxster section căn giữa ── */
    .section-boxster {
      min-height: 400px; display: flex;
      align-items: center; justify-content: center;
      text-align: center; position: relative;
    }
    .section-boxster::before { content: ''; position: absolute; inset: 0; background: rgba(0,0,0,0.55); }
    .section-boxster .custom-block-1 { position: relative; z-index: 2; width: 100%; }

    /* ── SERVICES DROPDOWN ── */
    #services-menu-item { position: relative; }

    #services-menu-item .drop-down {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background: #1c1c1e;
      border: 1px solid #3a3a3e;
      border-top: 3px solid #d42b2b;
      min-width: 270px;
      z-index: 9999;
      padding: 8px 0 !important;
      box-shadow: 0 8px 32px rgba(0,0,0,0.6);
      list-style: none !important;
      margin: 0 !important;
    }
    #services-menu-item:hover .drop-down { display: block; }

    #services-menu-item .drop-down li {
      display: block !important;
      margin: 0 !important;
      padding: 0 !important;
      border-bottom: 1px solid #2c2c2f;
    }
    #services-menu-item .drop-down li:last-child {
      border-bottom: none;
      border-top: 1px solid #3a3a3e;
    }
    #services-menu-item .drop-down li::before { display: none !important; }

    #services-menu-item .drop-down li a {
      display: flex !important;
      align-items: center;
      gap: 12px;
      padding: 11px 20px !important;
      color: #c8c3bc !important;
      font-size: 13px !important;
      font-family: 'Rajdhani', sans-serif;
      font-weight: 600;
      letter-spacing: 0.5px;
      text-transform: none !important;
      transition: background 0.2s, color 0.2s, padding-left 0.2s;
      white-space: nowrap;
      background: transparent !important;
    }
    #services-menu-item .drop-down li a:hover {
      background: #2a2a2d !important;
      color: #f5f0eb !important;
      padding-left: 26px !important;
    }
    #services-menu-item .drop-down li a i {
      color: #d42b2b;
      width: 16px;
      text-align: center;
      flex-shrink: 0;
    }

    /* Liên hệ - nổi bật */
    #services-menu-item .drop-down li.divider-item a {
      color: #d42b2b !important;
      font-weight: 700;
    }
    #services-menu-item .drop-down li.divider-item a:hover {
      background: #d42b2b !important;
      color: #fff !important;
      padding-left: 26px !important;
    }
    #services-menu-item .drop-down li.divider-item a i { color: inherit; }

    /* Mũi tên xoay khi hover */
    #services-menu-item > a .fa-angle-down {
      font-size: 11px; margin-left: 4px;
      transition: transform 0.2s; display: inline-block;
    }
    #services-menu-item:hover > a .fa-angle-down { transform: rotate(180deg); }
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
              <ul class="menu-logo">
                <li>
                  <a href="{{ url('/') }}">
                    <img id="logo_img" src="{{ asset('images/logo-light.png') }}" alt="logo">
                  </a>
                </li>
              </ul>
              <ul class="menu-links">
                <li class="{{ request()->is('/') ? 'active' : '' }}">
                  <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="{{ request()->is('about') ? 'active' : '' }}">
                  <a href="{{ url('/about') }}">About Us</a>
                </li>
                <li class="{{ request()->is('cars*') ? 'active' : '' }}">
                  <a href="{{ url('/cars') }}">Cars</a>
                </li>

                {{-- SERVICES DROPDOWN --}}
                <li class="menu-item-has-children {{ request()->is('services') || request()->is('contact') ? 'active' : '' }}" id="services-menu-item">
                  <a href="{{ url('/services') }}">Dịch Vụ & Hỗ Trợ <i class="fa fa-angle-down"></i></a>
                  <ul class="drop-down">
                    <li>
                      <a href="{{ url('/services') }}">
                        <i class="fa fa-comments-o"></i> Tư vấn &amp; Mua xe
                      </a>
                    </li>
                    <li>
                      <a href="{{ url('/services') }}#tai-chinh">
                        <i class="fa fa-credit-card"></i> Hỗ trợ Tài chính &amp; Vay xe
                      </a>
                    </li>
                    <li>
                      <a href="{{ url('/services') }}#bao-duong">
                        <i class="fa fa-wrench"></i> Bảo dưỡng &amp; Sửa chữa
                      </a>
                    </li>
                    <li>
                      <a href="{{ url('/services') }}#doi-xe">
                        <i class="fa fa-exchange"></i> Đổi xe &amp; Trade-in
                      </a>
                    </li>
                    <li class="divider-item">
                      <a href="{{ url('/contact') }}">
                        <i class="fa fa-phone"></i> Liên hệ với chúng tôi
                      </a>
                    </li>
                  </ul>
                </li>

                <li class="{{ request()->is('news') ? 'active' : '' }}">
                  <a href="{{ url('/news') }}">News</a>
                </li>
              </ul>
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
        <div class="social">
          <ul>
            <li><a class="facebook" href="#">facebook <i class="fa fa-facebook"></i></a></li>
            <li><a class="twitter" href="#">twitter <i class="fa fa-twitter"></i></a></li>
            <li><a class="pinterest" href="#">pinterest <i class="fa fa-pinterest-p"></i></a></li>
            <li><a class="dribbble" href="#">dribbble <i class="fa fa-dribbble"></i></a></li>
            <li><a class="google-plus" href="#">google plus <i class="fa fa-google-plus"></i></a></li>
            <li><a class="behance" href="#">behance <i class="fa fa-behance"></i></a></li>
          </ul>
        </div>
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

@stack('scripts')
</body>
</html>