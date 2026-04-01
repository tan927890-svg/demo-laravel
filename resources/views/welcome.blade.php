<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="keywords" content="HTML5 Template" />
      <meta name="description" content="Car Dealer - The Best Car Dealer Automotive Responsive HTML5 Template" />
      <meta name="author" content="potenzaglobalsolutions.com" />
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
      <title>Concept Car Dealer - Free Website Template</title>
      <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
      <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
      <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}" />
      <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.carousel.css') }}" />
      <link rel="stylesheet" type="text/css" href="{{ asset('css/mega_menu.css') }}" />
      <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.css') }}" />
      <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.magnific-popup.min.css') }}" />
      <link rel="stylesheet" type="text/css" href="{{ asset('css/settings.css') }}" />
      <link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}" />
      <style>
         /* ── BOXSTER: căn giữa toàn màn hình ── */
         .section-boxster {
            background-size: cover;
            background-position: center;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
         }
         .section-boxster::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.55);
         }
         .section-boxster .custom-block-1 {
            position: relative;
            z-index: 2;
            width: 100%;
         }

         /* ── SOCIAL: hàng ngang, căn giữa ── */
         .social ul {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 10px;
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
         }
         .social ul li {
            display: inline-block !important;
            margin: 0 !important;
         }
         .social ul li::before {
            display: none !important;
         }
      </style>
   </head>
   <body>
      <div id="loading">
         <div id="loading-center">
            <img src="{{ asset('images/loader.gif') }}" alt="">
         </div>
      </div>
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

      <section class="slider">
         <div id="rev_slider_2_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="car-dealer-03" style="margin:0 auto;background-color:transparent;padding:0;margin-top:0;margin-bottom:0">
            <div id="rev_slider_2_1" class="rev_slider fullwidthabanner" style="display:none" data-version="5.2.6">
               <ul>
                  <li data-index="rs-3" data-transition="random-static,random-premium,random" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-randomtransition="on">
                     <img src="{{ asset('images/slider/2.jpg') }}" alt="" />
                     <div class="tp-caption tp-resizeme" id="slide-3-layer-1" data-x="62" data-y="179" data-width="['auto']" data-height="['auto']" data-type="text" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"nothing"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index:5;white-space:nowrap;font-size:70px;line-height:80px;font-weight:900;color:rgba(255,255,255,1.00);font-family:Roboto;text-transform:uppercase">Are You Ready..
                        <br> For The Race
                     </div>
                     <div class="tp-caption tp-resizeme" id="slide-3-layer-2" data-x="62" data-y="348" data-width="['657']" data-height="['auto']" data-type="text" data-responsive_offset="on" data-frames='[{"delay":1720,"speed":1070,"frame":"0","from":"x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"nothing"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index:6;min-width:657px;max-width:657px;white-space:normal;font-size:14px;line-height:24px;font-weight:400;color:rgba(255,255,255,1.00);font-family:Open Sans">We are dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </div>
                     <div class="tp-caption button red" data-x="62" data-y="452" data-width="['auto']" data-height="['auto']" data-type="button" data-responsive_offset="on" data-frames='[{"delay":1720,"speed":2000,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","to":"o:1;","ease":"Power2.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"nothing"},{"frame":"hover","speed":"300","ease":"Linear.easeNone","force":true,"to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgba(0, 0, 0, 1.00);bg:rgba(255, 255, 255, 1.00);bs:solid;bw:0 0 0 0;"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[10,10,10,10]" data-paddingright="[30,30,30,30]" data-paddingbottom="[10,10,10,10]" data-paddingleft="[30,30,30,30]" style="z-index:7;white-space:nowrap;font-size:14px;line-height:16px;font-weight:400;font-family:Open Sans;outline:0;box-shadow:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer">Discover More </div>
                  </li>
                  <li data-index="rs-5" data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="default" data-rotate="0" data-saveperformance="off" data-title="Slide">
                     <img src="{{ asset('images/slider/back-road.jpg') }}" alt="" />
                     <div class="tp-caption tp-resizeme" id="slide-5-layer-6" data-x="center" data-y="270" data-width="['auto']" data-height="['auto']" data-transform_idle="o:1;" data-transform_in="y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;s:800;e:Power4.easeInOut;" data-transform_out="opacity:0;s:300;" data-mask_in="x:0px;y:0px;" data-start="1400" data-splitin="chars" data-splitout="none" data-responsive_offset="on" data-elementdelay="0.05" style="z-index:5;white-space:nowrap;font-size:30px;line-height:30px;font-weight:400;color:rgba(255,255,255,1.00);font-family:Roboto;text-align:center;text-transform:uppercase">Welcome to the most stunning</div>
                     <div class="tp-caption tp-resizeme" id="slide-5-layer-7" data-x="center" data-y="center" data-voffset="-140" data-width="['auto']" data-height="['auto']" data-transform_idle="o:1;" data-transform_in="y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;s:800;e:Power4.easeInOut;" data-transform_out="opacity:0;s:300;" data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" data-start="1700" data-splitin="chars" data-splitout="none" data-responsive_offset="on" data-elementdelay="0.05" style="z-index:6;white-space:nowrap;font-size:70px;line-height:70px;font-weight:700;color:rgba(255,255,255,1.00);font-family:Roboto;text-align:center;text-transform:uppercase">Concept Car dealer website</div>
                     <div class="tp-caption button red tp-resizeme" id="slide-5-layer-10" data-x="center" data-y="bottom" data-voffset="130" data-width="['auto']" data-height="['auto']" data-transform_idle="o:1;" data-transform_hover="o:1;rX:0;rY:0;rZ:0;z:0;s:300;e:Power0.easeIn;" data-style_hover="c:rgba(0, 0, 0, 1.00);bg:rgba(255, 255, 255, 1.00);" data-transform_in="y:bottom;s:600;e:Power2.easeInOut;" data-transform_out="opacity:0;s:300;" data-start="3300" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index:7;white-space:nowrap;font-size:14px;line-height:18px;font-weight:400;color:rgba(255,255,255,1.00);font-family:Open Sans;text-align:center;text-transform:uppercase;background-color:rgba(219,45,46,1.00);padding:12px 20px 12px 20px;border-color:rgba(0,0,0,1.00);outline:0;box-shadow:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer">learn more</div>
                     <div class="tp-caption tp-resizeme" id="slide-5-layer-12" data-x="right" data-hoffset="70" data-y="center" data-voffset="135" data-width="['none','none','none','none']" data-height="['none','none','none','none']" data-transform_idle="o:1;" data-transform_in="x:-50px;opacity:0;s:800;e:Power2.easeInOut;" data-transform_out="opacity:0;s:300;" data-start="620" data-responsive_offset="on" style="z-index:8"> <img src="{{ asset('images/slider/left-car.png') }}" alt="" /> </div>
                     <div class="tp-caption tp-resizeme" id="slide-5-layer-11" data-x="120" data-y="center" data-voffset="130" data-width="['none','none','none','none']" data-height="['none','none','none','none']" data-transform_idle="o:1;" data-transform_in="x:50px;opacity:0;s:800;e:Power2.easeInOut;" data-transform_out="opacity:0;s:300;" data-start="200" data-responsive_offset="on" style="z-index:9"><img src="{{ asset('images/slider/right-car.png') }}" alt="" /></div>
                  </li>
               </ul>
               <div class="tp-bannertimer tp-bottom" style="visibility:hidden!important"></div>
            </div>
         </div>
      </section>

      <section class="welcome-block objects-car page-section-ptb white-bg portfolio-main">
         <div class="car-search-bar">
            <div class="container">
               <div class="search-wrap">
                  <div class="search-header">
                     <i class="fa fa-search"></i>
                     <span>Tìm kiếm xe của bạn</span>
                  </div>
                  <form class="search-form" action="#" method="GET">
                     <div class="search-fields">
                        <div class="search-field">
                           <label><i class="fa fa-car"></i> Hãng xe</label>
                           <select name="brand" class="search-select">
                              <option value="">Tất cả hãng</option>
                              <option value="toyota">Toyota</option>
                              <option value="honda">Honda</option>
                              <option value="ford">Ford</option>
                              <option value="bmw">BMW</option>
                              <option value="mercedes">Mercedes-Benz</option>
                              <option value="audi">Audi</option>
                              <option value="lexus">Lexus</option>
                              <option value="hyundai">Hyundai</option>
                              <option value="kia">Kia</option>
                              <option value="mazda">Mazda</option>
                              <option value="porsche">Porsche</option>
                              <option value="acura">Acura</option>
                           </select>
                        </div>
                        <div class="search-divider"></div>
                        <div class="search-field">
                           <label><i class="fa fa-tag"></i> Dòng xe</label>
                           <select name="model" class="search-select">
                              <option value="">Tất cả dòng</option>
                              <option value="gs450h">Lexus GS 450h</option>
                              <option value="rsx">Acura Rsx</option>
                              <option value="santafe">Hyundai Santa Fe</option>
                              <option value="boxster">Porsche Boxster</option>
                              <option value="camry">Toyota Camry</option>
                              <option value="civic">Honda Civic</option>
                              <option value="mustang">Ford Mustang</option>
                           </select>
                        </div>
                        <div class="search-divider"></div>
                        <div class="search-field">
                           <label><i class="fa fa-th-large"></i> Loại xe</label>
                           <select name="type" class="search-select">
                              <option value="">Tất cả loại</option>
                              <option value="sedan">Sedan</option>
                              <option value="suv">SUV / Crossover</option>
                              <option value="coupe">Coupe</option>
                              <option value="hatchback">Hatchback</option>
                              <option value="pickup">Pickup Truck</option>
                              <option value="convertible">Convertible</option>
                              <option value="van">Van / Minivan</option>
                           </select>
                        </div>
                        <div class="search-divider"></div>
                        <div class="search-field">
                           <label><i class="fa fa-dollar"></i> Khoảng giá</label>
                           <select name="price" class="search-select">
                              <option value="">Tất cả mức giá</option>
                              <option value="0-10000">Dưới $10,000</option>
                              <option value="10000-20000">$10,000 – $20,000</option>
                              <option value="20000-35000">$20,000 – $35,000</option>
                              <option value="35000-50000">$35,000 – $50,000</option>
                              <option value="50000-80000">$50,000 – $80,000</option>
                              <option value="80000+">Trên $80,000</option>
                           </select>
                        </div>
                        <button type="submit" class="search-btn">
                           <i class="fa fa-search"></i>
                           <span>Tìm Xe</span>
                        </button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <div class="container">
            <div class="row">
               <div class="col-lg-12 col-md-12">
                  <div class="section-title">
                     <span>Welcome to our website</span>
                     <h2>Dealeractive</h2>
                     <div class="separator"></div>
                     <p>Concept Car Dealer is the best Free Ruby On Rails Template. We provide everything you need to build an
                        <strong>Amazing dealership website</strong> developed especially for car sellers, dealers or auto motor retailers. You can use this template for creating website based on any framework and any language.
                     </p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-6">
                  <div class="feature-box text-center">
                     <div class="icon"><i class="fa fa-car"></i></div>
                     <div class="content">
                        <h6>All brands</h6>
                        <p>Galley simply dummy text lorem Ipsum is of the printin k a of type and</p>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 col-md-3 col-sm-6">
                  <div class="feature-box text-center">
                     <div class="icon"><i class="fa fa-comments-o"></i></div>
                     <div class="content">
                        <h6>Free Support</h6>
                        <p>Text of the printin lorem ipsum the is simply k a type text and galley of</p>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 col-md-3 col-sm-6">
                  <div class="feature-box text-center">
                     <div class="icon"><i class="fa fa-key"></i></div>
                     <div class="content">
                        <h6>Dealership</h6>
                        <p>Printin k a of type and lorem Ipsum is simply dummy text of the galley</p>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 col-md-3 col-sm-6">
                  <div class="feature-box text-center">
                     <div class="icon"><i class="fa fa-car"></i></div>
                     <div class="content">
                        <h6>affordable</h6>
                        <p>The printin k a galley Lorem Ipsum is type and simply dummy text of</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-12 col-md-12">
                  <div class="halp-call text-center">
                     <img class="img-responsive" src="{{ asset('images/team/01.jpg') }}" alt="" />
                     <span>Have any question ?</span>
                     <h2 class="text-red">(007) 123 456 7890</h2>
                  </div>
               </div>
            </div>
         </div>
      </section>

    <div class="owl-carousel-1">
   @forelse($featuredCars as $car)
   <div class="item">
      <div class="car-item text-center">

         <div class="car-image">
         @if($car->image_url)
           <img class="img-responsive" src="{{ asset('images/car/' . $car->image_url) }}" alt="{{ $car->name }}">
         @else
            <img class="img-responsive" src="{{ asset('images/car/placeholder.jpg') }}" alt="No image">
         @endif

            <div class="car-overlay-banner">
               <ul>
                  <li>
                     <a href="{{ route('cars.show', $car) }}">
                        <i class="fa fa-link"></i>
                     </a>
                  </li>
                  <li>
                     <a href="{{ route('cars.show', $car) }}">
                        <i class="fa fa-dashboard"></i>
                     </a>
                  </li>
               </ul>
            </div>
         </div>

         <div class="car-list">
            <ul class="list-inline">
               <li><i class="fa fa-registered"></i> {{ $car->year ?? 'N/A' }}</li>
               <li><i class="fa fa-cog"></i> {{ $car->transmission ?? 'N/A' }}</li>
               <li><i class="fa fa-dashboard"></i> {{ $car->mileage ?? 'N/A' }}</li>
            </ul>
         </div>

         <div class="car-content">
            <div class="star">
               <i class="fa fa-star orange-color"></i>
               <i class="fa fa-star orange-color"></i>
               <i class="fa fa-star orange-color"></i>
               <i class="fa fa-star orange-color"></i>
               <i class="fa fa-star-o orange-color"></i>
            </div>

            <a href="{{ route('cars.show', $car) }}">{{ $car->name }}</a>

            <div class="separator"></div>

            <div class="price">
               <span class="new-price">
                  {{ number_format($car->price_per_day) }} VNĐ/ngày
               </span>
            </div>
         </div>

      </div>
   </div>
   @empty
      <p class="text-white text-center">Không có xe nào</p>
   @endforelse
</div>
      {{-- ── BOXSTER: đã căn giữa toàn màn hình ── --}}
      <section class="bg-5 section-boxster">
         <div class="custom-block-1">
            <h2>boxster</h2>
            <span>Get the Porsche You always Wanted </span>
            <strong class="text-red">$450 </strong>
            <span>per month </span>
            <p>Limited time Offer!</p>
            <a href="#" class="button red"> read more </a>
         </div>
      </section>

      <section class="latest-blog objects-car white-bg page page-section-ptb">
         <div class="container">
            <div class="row">
               <div class="col-lg-12 col-md-12">
                  <div class="section-title">
                     <span>Read our latest news</span>
                     <h2>Latest News</h2>
                     <div class="separator"></div>
                  </div>
               </div>
            </div>
            <div class="blog-1">
               <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-6">
                     <img class="img-responsive" src="{{ asset('images/blog/01.png') }}" alt="" />
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                     <div class="blog-content">
                        <a class="link" href="#">Porsche 911 is text of the printin a galley of type and bled it to make a type specimen book.</a>
                        <span class="uppercase">November 29, 2018 |
                        <strong class="text-red">post by john doe</strong>
                        </span>
                        <p>Sed do eiusmod tempor lorem ipsum dolor sit amet, consectetur adipisicing elit, incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa</p>
                        <a class="button border" href="#">Read more</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <section class="play-video popup-gallery">
         <div class="play-video-bg bg-3 bg-overlay-black-70">
            <div class="container">
               <div class="row">
                  <div class="col-md-offset-2 col-md-8 text-center">
                     <h3 class="text-white">Want to know more about us? Play our promotional video now!</h3>
                  </div>
               </div>
            </div>
         </div>
         <div class="container">
            <div class="row">
               <div class="col-md-offset-1 col-md-10">
                  <div class="video-info text-center">
                     <img class="img-responsive" src="{{ asset('images/car/24.jpg') }}" alt="" />
                     <a class="popup-youtube" href=""><i class="fa fa-play"></i></a>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <section class="testimonial-1 white-bg page page-section-ptb">
         <div class="container">
            <div class="row">
               <div class="col-lg-12 col-md-12">
                  <div class="section-title">
                     <span>What Our Happy Clients say about us</span>
                     <h2>our Testimonial</h2>
                     <div class="separator"></div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-12 col-md-12">
                  <div class="owl-carousel-2">
                     <div class="item">
                        <div class="testimonial-block text-center border-new">
                           <div class="testimonial-image"><img class="img-responsive" src="{{ asset('images/testimonial/01.jpg') }}" alt="" /></div>
                           <div class="testimonial-box">
                              <div class="testimonial-avtar">
                                 <img class="img-responsive" src="{{ asset('images/team/01.jpg') }}" alt="" />
                                 <h6>Alice Williams</h6><span>Auto Dealer</span>
                              </div>
                              <div class="testimonial-content">
                                 <p>It has survived not only five centuries. lorem Ipsum is simply dummy text of the printin a galley of type and bled it to make a type specimen book.</p>
                                 <i class="fa fa-quote-right"></i>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="item">
                        <div class="testimonial-block text-center border-new">
                           <div class="testimonial-image"><img class="img-responsive" src="{{ asset('images/testimonial/02.jpg') }}" alt="" /></div>
                           <div class="testimonial-box">
                              <div class="testimonial-avtar">
                                 <img class="img-responsive" src="{{ asset('images/team/02.jpg') }}" alt="" />
                                 <h6>Michael Bean</h6><span>Car Dealer</span>
                              </div>
                              <div class="testimonial-content">
                                 <p>A galley of type and bled it to make a type specimen book. Ipsum is simply dummy text of the printin It has survived not only five centuries.</p>
                                 <i class="fa fa-quote-right"></i>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="item">
                        <div class="testimonial-block text-center border-new">
                           <div class="testimonial-image"><img class="img-responsive" src="{{ asset('images/testimonial/03.jpg') }}" alt="" /></div>
                           <div class="testimonial-box">
                              <div class="testimonial-avtar">
                                 <img class="img-responsive" src="{{ asset('images/team/03.jpg') }}" alt="" />
                                 <h6>Felica Queen</h6><span>Auto Dealer</span>
                              </div>
                              <div class="testimonial-content">
                                 <p>Text of the printin a galley of type and bled it to a type specimen book. It has survived not only five centuries make Lorem Ipsum is simply dummy.</p>
                                 <i class="fa fa-quote-right"></i>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="item">
                        <div class="testimonial-block text-center border-new">
                           <div class="testimonial-image"><img class="img-responsive" src="{{ asset('images/testimonial/04.jpg') }}" alt="" /></div>
                           <div class="testimonial-box">
                              <div class="testimonial-avtar">
                                 <img class="img-responsive" src="{{ asset('images/team/04.jpg') }}" alt="" />
                                 <h6>Sara Lisbon</h6><span>Customer</span>
                              </div>
                              <div class="testimonial-content">
                                 <p>Printin a galley of type and bled It has survived not lorem Ipsum is simply dummy text of the it to make a type specimen book only five centuries.</p>
                                 <i class="fa fa-quote-right"></i>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <footer class="footer bg-2 bg-overlay-black-90">
         <div class="container">
            {{-- ── SOCIAL: hàng ngang căn giữa ── --}}
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
                     <a href="#"><img class="img-responsive" src="{{ asset('images/logo-light.png') }}" alt=""></a>
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
                        <p>©Copyright 2018 Concept Car Dealer Developed by <a href="http://www.devdap.com/" target="_blank">devdap.com</a></p>
                     </div>
                  </div>
                  <div class="col-lg-6 col-md-6">
                     <ul class="list-inline text-right">
                        <li><a href="#">privacy policy</a> |</li>
                        <li><a href="#">terms and conditions</a> |</li>
                        <li><a href="#">contact us</a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </footer>

      <div class="car-top">
         <span><img src="{{ asset('images/car.png') }}" alt=""></span>
      </div>

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
      <script type="text/javascript">(function(b){var a=jQuery;var c;a(document).ready(function(){if(a("#rev_slider_2_1").revolution==undefined){revslider_showDoubleJqueryError("#rev_slider_2_1")}else{c=a("#rev_slider_2_1").show().revolution({sliderType:"standard",sliderLayout:"fullwidth",dottedOverlay:"none",delay:9000,navigation:{keyboardNavigation:"off",keyboard_direction:"horizontal",mouseScrollNavigation:"off",mouseScrollReverse:"default",onHoverStop:"off",bullets:{enable:true,hide_onmobile:false,style:"hermes",hide_onleave:false,direction:"horizontal",h_align:"center",v_align:"bottom",h_offset:0,v_offset:50,space:10,tmp:""}},visibilityLevels:[1240,1024,778,480],gridwidth:1570,gridheight:1000,lazyType:"none",shadow:0,spinner:"spinner3",stopLoop:"off",stopAfterLoops:-1,stopAtSlide:-1,shuffle:"off",autoHeight:"off",disableProgressBar:"on",hideThumbsOnMobile:"off",hideSliderAtLimit:0,hideCaptionAtLimit:0,hideAllCaptionAtLilmit:0,debugMode:false,fallbacks:{simplifyAll:"off",nextSlideOnWindowFocus:"off",disableFocusListener:false,}})}})})(jQuery);</script>
      <link rel="stylesheet" type="text/css" href="{{ asset('css/custom-override.css') }}" />
   </body>
</html>