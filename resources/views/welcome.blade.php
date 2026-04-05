@extends('layouts.frontend')

@section('title', 'Trang chủ')

@push('styles')
<style>
   /* ── FEATURE BOX ICON IMAGE ── */
.feature-box .icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 15px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.feature-box .icon img {
    width: 100%;
    height: 100%;
    object-fit: contain; /* giữ tỷ lệ ảnh */
}

/* Đảm bảo các box đều nhau */
.feature-box {
    padding: 30px 20px;
    min-height: 260px;
    border: 1px solid #eee;
    transition: 0.3s;
}

.feature-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

/* Title đẹp hơn */
.feature-box h6 {
    margin-top: 10px;
    font-weight: 700;
    letter-spacing: 1px;
}

/* Text gọn hơn */
.feature-box p {
    font-size: 14px;
    line-height: 1.6;
}
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
@endpush

@section('content')

   {{-- ── SLIDER ── --}}
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

   {{-- ── WELCOME + SEARCH ── --}}
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
                  <span>WELCOME TO AUTOX EXPERIENCE</span>
                  <h2>TẠI SAO CHỌN AUTOX</h2>
                  <div class="separator"></div>
                  <p>
                  AutoX là nền tảng mua bán và trải nghiệm ô tô hiện đại, mang đến cho bạn mọi thứ cần thiết để xây dựng một 
                  <strong>website showroom xe chuyên nghiệp</strong>. 
                  Chúng tôi được phát triển dành riêng cho các đại lý, nhà phân phối và doanh nghiệp kinh doanh ô tô, 
                  với khả năng tùy chỉnh linh hoạt và phù hợp trên mọi nền tảng công nghệ.
                  </p>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
               <div class="feature-box text-center">
                 <div class="icon">
                  <img src="{{ asset('images/car/01.jpg') }}" alt="Car" style="width:80px;">
               </div>
                  <div class="content">
                     <h6>ĐA DẠNG MẪU XE</h6>
                        <p>
                        AutoX cung cấp hàng trăm mẫu xe từ phổ thông đến cao cấp, đáp ứng mọi nhu cầu và phong cách sống.
                        </p>
                     </div>
                  </div>
               </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
               <div class="feature-box text-center">
                  <div class="icon">
                  <img src="{{ asset('images/team/suport.jpg') }}" alt="Car" style="width:80px;">
               </div>
                  <div class="content">
                     <h6>HỖ TRỢ 24/7</h6>
                     <p>
                     Đội ngũ AutoX luôn sẵn sàng tư vấn và hỗ trợ bạn mọi lúc, giúp quá trình mua xe nhanh chóng và dễ dàng.
                     </p>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
               <div class="feature-box text-center">
                 <div class="icon">
                  <img src="{{ asset('images/testimonial/showroom.jpg') }}" alt="Car" style="width:80px;">
               </div>
                  <div class="content">
                     <h6>ĐẠI LÝ UY TÍN</h6>
                      <p>
                        Chúng tôi hợp tác với các đại lý chính hãng, đảm bảo chất lượng xe và dịch vụ tốt nhất.
                     </p>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
               <div class="feature-box text-center">
                 <div class="icon">
                  <img src="{{ asset('images/team/customer car.webp') }}" alt="Car" style="width:80px;">
               </div>
                  <div class="content">
                     <h6>GIÁ TỐT NHẤT</h6>
                     <p>
                     AutoX cam kết giá cạnh tranh cùng nhiều ưu đãi hấp dẫn, phù hợp với mọi ngân sách.
                     </p>
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

   {{-- ── FEATURED CARS CAROUSEL ── --}}
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

   {{-- ── BOXSTER BANNER ── --}}
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

   {{-- ── LATEST BLOG ── --}}
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

   {{-- ── PLAY VIDEO ── --}}
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

   {{-- ── TESTIMONIALS ── --}}
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

   {{-- ── POPUP BÁO GIÁ NHANH ── --}}
   <div id="popup-overlay"
        style="position:fixed;top:0;left:0;width:100%;height:100%;
               background:rgba(0,0,0,0.55);z-index:99999;
               display:flex;align-items:center;justify-content:center;">

      <div style="background:#fff;border-radius:10px;width:90%;
                  max-width:480px;overflow:hidden;position:relative;
                  animation:popupIn .4s ease;">

         {{-- Header --}}
         <div style="background:#e8f5e9;padding:26px 32px 18px;
                     text-align:center;border-bottom:1px solid #ddd;">
            <h2 style="margin:0;color:#1a7a3c;letter-spacing:2px;
                       font-size:22px;font-weight:700;">BÁO GIÁ NHANH</h2>
         </div>

         {{-- Nút đóng --}}
         <button onclick="closePopup()"
                 style="position:absolute;top:12px;right:14px;
                        background:#e53935;border:none;border-radius:50%;
                        width:28px;height:28px;color:#fff;font-size:16px;
                        cursor:pointer;line-height:28px;padding:0;">✕</button>

         {{-- Form --}}
         <div style="padding:22px 32px 30px;display:flex;flex-direction:column;gap:14px;">
            <input type="text" id="popup-ten" placeholder="Tên Bạn"
                   style="padding:13px 16px;border:1.5px solid #b0c4b8;
                          border-radius:6px;font-size:15px;width:100%;box-sizing:border-box;" />
            <input type="tel" id="popup-sdt" placeholder="Số Điện Thoại"
                   style="padding:13px 16px;border:1.5px solid #b0c4b8;
                          border-radius:6px;font-size:15px;width:100%;box-sizing:border-box;" />
            <input type="text" id="popup-dongxe" placeholder="Dòng Xe Quan Tâm"
                   style="padding:13px 16px;border:1.5px solid #b0c4b8;
                          border-radius:6px;font-size:15px;width:100%;box-sizing:border-box;" />
            <button id="popup-submit"
                    style="padding:14px;background:#1a1a1a;color:#fff;border:none;
                           border-radius:6px;font-size:14px;font-weight:700;
                           letter-spacing:2px;cursor:pointer;">ĐĂNG KÝ</button>
         </div>
      </div>
   </div>

@endsection

@push('scripts')
<script type="text/javascript">
   (function(b){
      var a=jQuery;var c;
      a(document).ready(function(){
         if(a("#rev_slider_2_1").revolution==undefined){
            revslider_showDoubleJqueryError("#rev_slider_2_1");
         } else {
            c=a("#rev_slider_2_1").show().revolution({
               sliderType:"standard",sliderLayout:"fullwidth",dottedOverlay:"none",
               delay:9000,
               navigation:{
                  keyboardNavigation:"off",keyboard_direction:"horizontal",
                  mouseScrollNavigation:"off",mouseScrollReverse:"default",
                  onHoverStop:"off",
                  bullets:{enable:true,hide_onmobile:false,style:"hermes",hide_onleave:false,
                     direction:"horizontal",h_align:"center",v_align:"bottom",
                     h_offset:0,v_offset:50,space:10,tmp:""}
               },
               visibilityLevels:[1240,1024,778,480],gridwidth:1570,gridheight:1000,
               lazyType:"none",shadow:0,spinner:"spinner3",stopLoop:"off",
               stopAfterLoops:-1,stopAtSlide:-1,shuffle:"off",autoHeight:"off",
               disableProgressBar:"on",hideThumbsOnMobile:"off",hideSliderAtLimit:0,
               hideCaptionAtLimit:0,hideAllCaptionAtLilmit:0,debugMode:false,
               fallbacks:{simplifyAll:"off",nextSlideOnWindowFocus:"off",disableFocusListener:false}
            });
         }
      });
   })(jQuery);
</script>

<style>
   @keyframes popupIn {
      from { opacity:0; transform:translateY(-24px); }
      to   { opacity:1; transform:translateY(0); }
   }
</style>

<script>
function closePopup() {
   document.getElementById('popup-overlay').style.display = 'none';
}

document.getElementById('popup-submit').addEventListener('click', function () {
   var btn           = document.getElementById('popup-submit');
   var ten           = document.getElementById('popup-ten').value.trim();
   var so_dien_thoai = document.getElementById('popup-sdt').value.trim();
   var dong_xe       = document.getElementById('popup-dongxe').value.trim();

   if (!ten || !so_dien_thoai) {
      alert('Vui lòng nhập Tên và Số Điện Thoại!');
      return;
   }

   btn.disabled = true;
   btn.textContent = 'Đang gửi...';

   fetch('{{ route("bao-gia-nhanh.store") }}', {
      method: 'POST',
      headers: {
         'Content-Type': 'application/json',
         'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ ten: ten, so_dien_thoai: so_dien_thoai, dong_xe: dong_xe })
   })
   .then(function(r) {
      if (!r.ok) {
         return r.text().then(function(text) {
            console.error('Server error ' + r.status + ':', text);
            throw new Error('Server error ' + r.status);
         });
      }
      return r.json();
   })
   .then(function(data) {
      if (data.success) {
         alert('Đăng ký thành công! Chúng tôi sẽ liên hệ sớm.');
         closePopup();
      } else {
         alert('Có lỗi xảy ra, vui lòng thử lại!');
      }
   })
   .catch(function(err) {
      console.error('Fetch error:', err);
      alert('Có lỗi xảy ra, vui lòng thử lại!');
   })
   .finally(function() {
      btn.disabled = false;
      btn.textContent = 'ĐĂNG KÝ';
   });
});
</script>
@endpush