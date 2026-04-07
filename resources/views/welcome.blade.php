@extends('layouts.frontend')

@section('title', 'Trang chủ')

@push('styles')
<style>
/* ── GOOGLE FONTS ── */
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Montserrat:wght@300;400;500;600;700&display=swap');

/* ── FEATURE BOX ── */
.feature-box .icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid #c9a84c;
}
.feature-box .icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
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
.feature-box h6 {
    margin-top: 10px;
    font-weight: 700;
    letter-spacing: 1px;
}
.feature-box p {
    font-size: 14px;
    line-height: 1.6;
}

/* ══════════════════════════════════════════
   NEW SEARCH BAR — Luxury style
   ══════════════════════════════════════════ */
.luxury-search-section {
    background: #f8f5ef;
    padding: 0;
}

/* Thumbnail strip */
.search-thumbnails {
    display: flex;
    gap: 0;
    overflow: hidden;
    height: 160px;
}
.search-thumbnails .thumb-item {
    flex: 1;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    transition: flex 0.4s ease;
}
.search-thumbnails .thumb-item:hover {
    flex: 2;
}
.search-thumbnails .thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
    filter: brightness(0.75);
}
.search-thumbnails .thumb-item:hover img {
    transform: scale(1.05);
    filter: brightness(0.9);
}
.search-thumbnails .thumb-item .thumb-label {
    position: absolute;
    bottom: 8px;
    left: 50%;
    transform: translateX(-50%);
    color: #fff;
    font-family: 'Montserrat', sans-serif;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    white-space: nowrap;
    opacity: 0;
    transition: opacity 0.3s;
}
.search-thumbnails .thumb-item:hover .thumb-label {
    opacity: 1;
}

/* Search form container */
.luxury-search-wrap {
    background: #fff;
    border-top: 3px solid #c9a84c;
    padding: 28px 40px 32px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
}
.luxury-search-title {
    text-align: center;
    margin-bottom: 22px;
}
.luxury-search-title p {
    font-family: 'Montserrat', sans-serif;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #c9a84c;
    margin: 0 0 6px 0;
}
.luxury-search-title h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 26px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
    letter-spacing: 1px;
}
.luxury-search-title .title-line {
    width: 50px;
    height: 2px;
    background: #c9a84c;
    margin: 10px auto 0;
}

/* Fields row */
.luxury-search-fields {
    display: flex;
    align-items: flex-end;
    gap: 0;
    border: 1px solid #e5e0d8;
}
.lsf-group {
    flex: 1;
    padding: 12px 20px 14px;
    border-right: 1px solid #e5e0d8;
    position: relative;
    background: #fff;
    transition: background 0.2s;
}
.lsf-group:last-of-type {
    border-right: none;
}
.lsf-group:hover {
    background: #fdf9f2;
}
.lsf-group label {
    display: block;
    font-family: 'Montserrat', sans-serif;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #c9a84c;
    margin-bottom: 6px;
}
.lsf-group select,
.lsf-group input[type="text"],
.lsf-group input[type="number"] {
    width: 100%;
    border: none;
    outline: none;
    background: transparent;
    font-family: 'Montserrat', sans-serif;
    font-size: 13px;
    font-weight: 500;
    color: #1a1a1a;
    appearance: none;
    -webkit-appearance: none;
    cursor: pointer;
    padding: 0;
}
.lsf-group .select-arrow {
    position: absolute;
    right: 14px;
    bottom: 18px;
    pointer-events: none;
    color: #c9a84c;
    font-size: 10px;
}

/* Price inputs row */
.lsf-price-inputs {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 4px;
}
.lsf-price-inputs input[type="number"] {
    flex: 1;
    border: 1px solid #e5e0d8 !important;
    border-radius: 3px !important;
    padding: 4px 8px !important;
    font-size: 12px !important;
    background: #fafafa !important;
    appearance: auto !important;
    -webkit-appearance: auto !important;
}
.lsf-price-inputs span {
    font-family: 'Montserrat', sans-serif;
    font-size: 11px;
    color: #999;
}

/* Search button */
.luxury-search-btn {
    background: #1a1a1a;
    color: #c9a84c;
    border: none;
    padding: 0 36px;
    height: 100%;
    min-height: 68px;
    font-family: 'Montserrat', sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.3s, color 0.3s;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 5px;
    white-space: nowrap;
    text-decoration: none;
}
.luxury-search-btn:hover {
    background: #c9a84c;
    color: #1a1a1a;
}
.luxury-search-btn i {
    font-size: 18px;
}

/* ══════════════════════════════════════════
   BMW M8 BANNER — Full background image
   ══════════════════════════════════════════ */
.section-boxster {
    position: relative;
    min-height: 460px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    overflow: hidden;
}
.section-boxster::before {
    display: none !important;
}
.section-boxster .banner-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    transition: transform 6s ease;
}
.section-boxster:hover .banner-bg {
    transform: scale(1.04);
}
.section-boxster .banner-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(0,0,0,0.72) 0%,
        rgba(0,0,0,0.35) 50%,
        rgba(0,0,0,0.55) 100%
    );
}
.section-boxster .custom-block-1 {
    position: relative;
    z-index: 2;
    width: 100%;
    padding: 60px 20px;
}
.section-boxster .custom-block-1 h2 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 72px;
    font-weight: 700;
    color: #fff;
    letter-spacing: 6px;
    text-transform: uppercase;
    margin-bottom: 0;
    line-height: 1;
    text-shadow: 0 4px 20px rgba(0,0,0,0.5);
}
.section-boxster .custom-block-1 .banner-subtitle {
    display: block;
    font-family: 'Montserrat', sans-serif;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 5px;
    text-transform: uppercase;
    color: #c9a84c;
    margin: 14px 0 20px;
}
.section-boxster .custom-block-1 .banner-price {
    display: block;
    font-family: 'Cormorant Garamond', serif;
    font-size: 42px;
    font-weight: 600;
    color: #c9a84c;
    letter-spacing: 2px;
    margin-bottom: 8px;
}
.section-boxster .custom-block-1 .banner-note {
    display: block;
    font-family: 'Montserrat', sans-serif;
    font-size: 13px;
    color: rgba(255,255,255,0.75);
    margin-bottom: 6px;
}
.section-boxster .custom-block-1 .banner-offer {
    display: inline-block;
    background: rgba(201,168,76,0.15);
    border: 1px solid rgba(201,168,76,0.4);
    color: #c9a84c;
    font-family: 'Montserrat', sans-serif;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 3px;
    text-transform: uppercase;
    padding: 6px 20px;
    border-radius: 2px;
    margin-bottom: 28px;
}
.section-boxster .custom-block-1 .button.red {
    display: inline-block;
    background: #c9a84c;
    color: #1a1a1a;
    font-family: 'Montserrat', sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    padding: 14px 40px;
    border: none;
    text-decoration: none;
    transition: background 0.3s, color 0.3s, transform 0.2s;
}
.section-boxster .custom-block-1 .button.red:hover {
    background: #fff;
    color: #1a1a1a;
    transform: translateY(-2px);
}

/* ── SOCIAL: hàng ngang ── */
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

/* ── CAR CAROUSEL FIX ── */
.owl-carousel-1 .car-item .car-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

/* ══════════════════════════════════════════
   PLAY VIDEO — Compact with YouTube embed
   ══════════════════════════════════════════ */
.play-video-section {
    background: #111;
    padding: 40px 0;
}
.play-video-section .video-header {
    text-align: center;
    margin-bottom: 24px;
}
.play-video-section .video-header h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 28px;
    font-weight: 700;
    color: #fff;
    letter-spacing: 2px;
    margin: 0 0 8px;
}
.play-video-section .video-header p {
    font-family: 'Montserrat', sans-serif;
    font-size: 11px;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #c9a84c;
    margin: 0;
}
.video-embed-wrap {
    position: relative;
    width: 100%;
    max-width: 900px;
    margin: 0 auto;
    padding-bottom: 50.625%; /* 16:9 ratio for max-width 900 */
    height: 0;
    overflow: hidden;
    border: 2px solid rgba(201,168,76,0.3);
}
.video-embed-wrap iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
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
                  <div class="tp-caption tp-resizeme" id="slide-3-layer-2" data-x="62" data-y="348" data-width="['657']" data-height="['auto']" data-type="text" data-responsive_offset="on" data-frames='[{"delay":1720,"speed":1070,"frame":"0","from":"x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"nothing"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index:6;min-width:657px;max-width:657px;white-space:normal;font-size:14px;line-height:24px;font-weight:400;color:rgba(255,255,255,1.00);font-family:Open Sans">We are dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                  <div class="tp-caption button red" data-x="62" data-y="452" data-width="['auto']" data-height="['auto']" data-type="button" data-responsive_offset="on" data-frames='[{"delay":1720,"speed":2000,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","to":"o:1;","ease":"Power2.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"nothing"},{"frame":"hover","speed":"300","ease":"Linear.easeNone","force":true,"to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgba(0, 0, 0, 1.00);bg:rgba(255, 255, 255, 1.00);bs:solid;bw:0 0 0 0;"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[10,10,10,10]" data-paddingright="[30,30,30,30]" data-paddingbottom="[10,10,10,10]" data-paddingleft="[30,30,30,30]" style="z-index:7;white-space:nowrap;font-size:14px;line-height:16px;font-weight:400;font-family:Open Sans;outline:0;box-shadow:none;box-sizing:border-box;cursor:pointer">Discover More</div>
               </li>
               <li data-index="rs-5" data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="default" data-rotate="0" data-saveperformance="off" data-title="Slide">
                  <img src="{{ asset('images/slider/back-road.jpg') }}" alt="" />
                  <div class="tp-caption tp-resizeme" id="slide-5-layer-6" data-x="center" data-y="270" data-width="['auto']" data-height="['auto']" data-transform_idle="o:1;" data-transform_in="y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;s:800;e:Power4.easeInOut;" data-transform_out="opacity:0;s:300;" data-mask_in="x:0px;y:0px;" data-start="1400" data-splitin="chars" data-splitout="none" data-responsive_offset="on" data-elementdelay="0.05" style="z-index:5;white-space:nowrap;font-size:30px;line-height:30px;font-weight:400;color:rgba(255,255,255,1.00);font-family:Roboto;text-align:center;text-transform:uppercase">Welcome to the most stunning</div>
                  <div class="tp-caption tp-resizeme" id="slide-5-layer-7" data-x="center" data-y="center" data-voffset="-140" data-width="['auto']" data-height="['auto']" data-transform_idle="o:1;" data-transform_in="y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;s:800;e:Power4.easeInOut;" data-transform_out="opacity:0;s:300;" data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" data-start="1700" data-splitin="chars" data-splitout="none" data-responsive_offset="on" data-elementdelay="0.05" style="z-index:6;white-space:nowrap;font-size:70px;line-height:70px;font-weight:700;color:rgba(255,255,255,1.00);font-family:Roboto;text-align:center;text-transform:uppercase">AUTO X Kính Chào Quý Khách</div>
                  <div class="tp-caption button red tp-resizeme" id="slide-5-layer-10" data-x="center" data-y="bottom" data-voffset="130" data-width="['auto']" data-height="['auto']" data-transform_idle="o:1;" data-transform_hover="o:1;rX:0;rY:0;rZ:0;z:0;s:300;e:Power0.easeIn;" data-style_hover="c:rgba(0, 0, 0, 1.00);bg:rgba(255, 255, 255, 1.00);" data-transform_in="y:bottom;s:600;e:Power2.easeInOut;" data-transform_out="opacity:0;s:300;" data-start="3300" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index:7;white-space:nowrap;font-size:14px;line-height:18px;font-weight:400;color:rgba(255,255,255,1.00);font-family:Open Sans;text-align:center;text-transform:uppercase;background-color:rgba(219,45,46,1.00);padding:12px 20px;cursor:pointer">learn more</div>
                  <div class="tp-caption tp-resizeme" id="slide-5-layer-12" data-x="right" data-hoffset="70" data-y="center" data-voffset="135" data-width="['none','none','none','none']" data-height="['none','none','none','none']" data-transform_idle="o:1;" data-transform_in="x:-50px;opacity:0;s:800;e:Power2.easeInOut;" data-transform_out="opacity:0;s:300;" data-start="620" data-responsive_offset="on" style="z-index:8"><img src="{{ asset('images/slider/left-car.png') }}" alt="" /></div>
                  <div class="tp-caption tp-resizeme" id="slide-5-layer-11" data-x="120" data-y="center" data-voffset="130" data-width="['none','none','none','none']" data-height="['none','none','none','none']" data-transform_idle="o:1;" data-transform_in="x:50px;opacity:0;s:800;e:Power2.easeInOut;" data-transform_out="opacity:0;s:300;" data-start="200" data-responsive_offset="on" style="z-index:9"><img src="{{ asset('images/slider/right-car.png') }}" alt="" /></div>
               </li>
            </ul>
            <div class="tp-bannertimer tp-bottom" style="visibility:hidden!important"></div>
         </div>
      </div>
   </section>

   {{-- ══════════════════════════════════════════
        NEW SEARCH BAR — Luxury with thumbnails
        ══════════════════════════════════════════ --}}
   <section class="luxury-search-section">

      {{-- Thumbnail strip --}}
      <div class="search-thumbnails">
         <div class="thumb-item">
            <img src="{{ asset('images/Xe/Porsche/Porsche 911 đen.avif') }}" alt="Porsche 911" onerror="this.src='{{ asset('images/car/01.jpg') }}'">
            <span class="thumb-label">Porsche 911</span>
         </div>
         <div class="thumb-item">
            <img src="{{ asset('images/Xe/Lamborghini/Lamborghini Aventador do.avif') }}" alt="Lamborghini" onerror="this.src='{{ asset('images/car/01.jpg') }}'">
            <span class="thumb-label">Lamborghini</span>
         </div>
         <div class="thumb-item">
            <img src="{{ asset('images/Xe/Bugatti/Bugatti Chiron cam.avif') }}" alt="Bugatti Chiron" onerror="this.src='{{ asset('images/car/01.jpg') }}'">
            <span class="thumb-label">Bugatti Chiron</span>
         </div>
         <div class="thumb-item">
            <img src="{{ asset('images/Xe/BMW/BMW M4 đen.avif') }}" alt="BMW M4" onerror="this.src='{{ asset('images/car/01.jpg') }}'">
            <span class="thumb-label">BMW M4</span>
         </div>
         <div class="thumb-item">
            <img src="{{ asset('images/Xe/Audi/AudiR8.avif') }}" alt="Audi R8" onerror="this.src='{{ asset('images/car/01.jpg') }}'">
            <span class="thumb-label">Audi R8</span>
         </div>
      </div>

      {{-- Search form — action dẫn đến trang cars --}}
      <div class="luxury-search-wrap">
         <div class="luxury-search-title">
            <p>AutoX Collection</p>
            <h3>Bạn Đang Tìm Kiếm Xe Gì?</h3>
            <div class="title-line"></div>
         </div>

         <form action="{{ route('cars.index') }}" method="GET" id="luxury-search-form">
            <div class="luxury-search-fields">

               {{-- Keyword --}}
               <div class="lsf-group">
                  <label>Tìm kiếm</label>
                  <input type="text" name="q" placeholder="Nhập tên xe..." />
               </div>

               {{-- Brand --}}
               <div class="lsf-group">
                  <label>Hãng xe</label>
                  <select name="brand" id="brand-select">
                     <option value="">Tất cả hãng</option>
                     <option value="audi">Audi</option>
                     <option value="bmw">BMW</option>
                     <option value="bugatti">Bugatti</option>
                     <option value="lamborghini">Lamborghini</option>
                     <option value="porsche">Porsche</option>
                     <option value="vinfast">VinFast</option>
                  </select>
                  <span class="select-arrow">▾</span>
               </div>

               {{-- Model — filtered by brand --}}
               <div class="lsf-group">
                  <label>Dòng xe</label>
                  <select name="model" id="model-select">
                     <option value="">Tất cả dòng</option>
                     {{-- Audi --}}
                     <option value="tt-rs" data-brand="audi">Audi TT RS</option>
                     <option value="r8"    data-brand="audi">Audi R8</option>
                     {{-- BMW --}}
                     <option value="m4"   data-brand="bmw">BMW M4</option>
                     <option value="m8"   data-brand="bmw">BMW M8</option>
                     {{-- Bugatti --}}
                     <option value="chiron"     data-brand="bugatti">Bugatti Chiron</option>
                     {{-- Lamborghini --}}
                     <option value="aventador"  data-brand="lamborghini">Lamborghini Aventador</option>
                     {{-- Porsche --}}
                     <option value="911"     data-brand="porsche">Porsche 911</option>
                     <option value="cayenne" data-brand="porsche">Porsche Cayenne</option>
                     {{-- VinFast --}}
                     <option value="vf6" data-brand="vinfast">VinFast VF 6</option>
                     <option value="vf9" data-brand="vinfast">VinFast VF 9</option>
                  </select>
                  <span class="select-arrow">▾</span>
               </div>

               {{-- Price range — number inputs --}}
               <div class="lsf-group" style="min-width: 220px;">
                  <label>Khoảng giá thuê / ngày (VNĐ)</label>
                  <div class="lsf-price-inputs">
                     <input type="number" name="price_min" id="price-min-input"
                            placeholder="Tối thiểu" min="0" step="100000"
                            value="" style="width:100%;" />
                     <span>—</span>
                     <input type="number" name="price_max" id="price-max-input"
                            placeholder="Tối đa" min="0" step="100000"
                            value="" style="width:100%;" />
                  </div>
               </div>

               {{-- Button — submit dẫn qua trang cars --}}
               <button type="submit" class="luxury-search-btn">
                  <i class="fa fa-search"></i>
                  <span>SEARCH</span>
               </button>

            </div>
         </form>
      </div>
   </section>

   {{-- ── WELCOME ── --}}
   <section class="welcome-block objects-car page-section-ptb white-bg portfolio-main">
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
                     <img src="{{ asset('images/car/01.jpg') }}" alt="Car">
                  </div>
                  <div class="content">
                     <h6>ĐA DẠNG MẪU XE</h6>
                     <p>AutoX cung cấp hàng trăm mẫu xe từ phổ thông đến cao cấp, đáp ứng mọi nhu cầu và phong cách sống.</p>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
               <div class="feature-box text-center">
                  <div class="icon">
                     <img src="{{ asset('images/team/suport.jpg') }}" alt="Support">
                  </div>
                  <div class="content">
                     <h6>HỖ TRỢ 24/7</h6>
                     <p>Đội ngũ AutoX luôn sẵn sàng tư vấn và hỗ trợ bạn mọi lúc, giúp quá trình mua xe nhanh chóng và dễ dàng.</p>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
               <div class="feature-box text-center">
                  <div class="icon">
                     <img src="{{ asset('images/testimonial/showroom.jpg') }}" alt="Showroom">
                  </div>
                  <div class="content">
                     <h6>ĐẠI LÝ UY TÍN</h6>
                     <p>Chúng tôi hợp tác với các đại lý chính hãng, đảm bảo chất lượng xe và dịch vụ tốt nhất.</p>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
               <div class="feature-box text-center">
                  <div class="icon">
                     <img src="{{ asset('images/team/customer car.webp') }}" alt="Price">
                  </div>
                  <div class="content">
                     <h6>GIÁ TỐT NHẤT</h6>
                     <p>AutoX cam kết giá cạnh tranh cùng nhiều ưu đãi hấp dẫn, phù hợp với mọi ngân sách.</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-12 col-md-12">
               <div class="halp-call text-center">
                  <img class="img-responsive" src="{{ asset('images/team/01.jpg') }}" alt="" />
                  <span>Liên hệ ngay với chúng tôi?</span>
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
                  @if(str_starts_with($car->image_url, 'images/'))
                     <img class="img-responsive" src="{{ asset($car->image_url) }}" alt="{{ $car->name }}"
                          style="width:100%;height:200px;object-fit:cover;"
                          onerror="this.src='{{ asset('images/car/placeholder.jpg') }}'">
                  @else
                     <img class="img-responsive" src="{{ asset('images/car/' . $car->image_url) }}" alt="{{ $car->name }}"
                          style="width:100%;height:200px;object-fit:cover;"
                          onerror="this.src='{{ asset('images/car/placeholder.jpg') }}'">
                  @endif
               @else
                  <img class="img-responsive" src="{{ asset('images/car/placeholder.jpg') }}" alt="No image"
                       style="width:100%;height:200px;object-fit:cover;">
               @endif
               <div class="car-overlay-banner">
                  <ul>
                     <li><a href="{{ route('cars.show', $car) }}"><i class="fa fa-link"></i></a></li>
                     <li><a href="{{ route('cars.show', $car) }}"><i class="fa fa-dashboard"></i></a></li>
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
                     {{ number_format($car->price_per_day) }} VNĐ
                  </span>
               </div>
            </div>
         </div>
      </div>
      @empty
         <p class="text-white text-center">Không có xe nào</p>
      @endforelse
   </div>

   {{-- ══════════════════════════════════════════
        BMW M8 BANNER — Full background image
        ══════════════════════════════════════════ --}}
   <section class="section-boxster">
      <div class="banner-bg"
           style="background-image: url('{{ asset('images/Xe/BMW/BMWM8 đen.avif') }}'),
                                    url('{{ asset('images/Xe/BMW/bmw-m8.jpg') }}'),
                                    url('{{ asset('images/car/24.jpg') }}');">
      </div>
      <div class="banner-overlay"></div>

      <div class="custom-block-1">
         <h2>BMW M8</h2>
         <span class="banner-subtitle">Competition Coupe · 617 Mã Lực</span>
         <span class="banner-price">7.200.000.000 VNĐ</span>
         <span class="banner-note">Trả góp từ 28 triệu/tháng</span>
         <span class="banner-offer">⚡ Ưu Đãi Có Hạn</span>
         <br>
         <a href="#" class="button red">Đặt Ngay</a>
      </div>
   </section>

   {{-- ── LATEST BLOG ── --}}
   <section class="latest-blog objects-car white-bg page page-section-ptb">
      <div class="container">
         <div class="row">
            <div class="col-lg-12 col-md-12">
               <div class="section-title">
                  <span>Xem tin tức mới nhất</span>
                  <h2>Điểm tin thị trường</h2>
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
                     <a class="link" href="#">Porsche 911 là văn bản của việc in một bản mẫu chữ và chỉnh sửa nó để tạo thành một cuốn sách mẫu chữ.</a>
                     <span class="uppercase">Ngày 29 tháng 11 năm 2026 |
                     <strong class="text-red">Bài đăng của John Doe</strong>
                     </span>
                     <p>Chiếc xe mang đến sự kết hợp hoàn hảo giữa thiết kế hiện đại và hiệu suất mạnh mẽ, đem lại trải nghiệm lái mượt mà và đầy cảm hứng.</p>
                     <p>Với động cơ bền bỉ, khả năng vận hành ổn định cùng tiện nghi cao cấp, đây là lựa chọn lý tưởng cho những ai yêu thích sự thoải mái và phong cách trong từng hành trình.</p>
                     <a class="button border" href="#"> Đăng ký </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>

   {{-- ══════════════════════════════════════════
        PLAY VIDEO — YouTube embed (autoplay on scroll)
        ══════════════════════════════════════════ --}}
   <section class="play-video-section" id="video-section">
      <div class="container">
         <div class="video-header">
            <p>AutoX Showcase</p>
            <h3>Khám Phá Thế Giới Xe Đẳng Cấp</h3>
         </div>
         <div class="video-embed-wrap" id="video-wrap">
            {{-- iframe sẽ được chèn vào đây bởi IntersectionObserver --}}
         </div>
      </div>
   </section>

   {{-- ── TESTIMONIALS ── --}}
   <section class="testimonial-1 white-bg page page-section-ptb">
      <div class="container">
         <div class="row">
            <div class="col-lg-12 col-md-12">
               <div class="section-title">
                  <span> Những đánh giá của khách hàng về chúng tôi. </span>
                  <h2>Nhận xét của khách hàng</h2>
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
                              <h6>Nguyễn Văn A</h6><span>Auto X</span>
                           </div>
                           <div class="testimonial-content">
                              <p>Tôi rất ấn tượng với không gian hiện đại và sự đón tiếp nồng hậu tại showroom. Đội ngũ nhân viên tư vấn rất am hiểu kỹ thuật, giúp tôi chọn được dòng xe phù hợp với nhu cầu gia đình mà không hề cảm thấy bị áp đặt. Chế độ hậu mãi và bảo dưỡng tại đây cũng rất nhanh chóng</p>
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
                              <h6>Trần Thị B</h6><span>Chủ xe BMW</span>
                           </div>
                           <div class="testimonial-content">
                              <p>Sau 6 tháng cầm lái, tôi hoàn toàn hài lòng với khả năng vận hành của xe. Xe chạy êm, tiết kiệm nhiên liệu và các tính năng an toàn thực sự vượt mong đợi. Cảm ơn hệ thống showroom đã tư vấn tận tình để tôi tìm thấy người bạn đồng hành ưng ý này.</p>
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
                              <h6>Lê Hoàng C</h6><span>Khách hàng thân thiết</span>
                           </div>
                           <div class="testimonial-content">
                              <p>Điểm tôi thích nhất ở Auto X là hệ thống chi nhánh có mặt ở nhiều tỉnh thành. Dù đi công tác hay du lịch, tôi vẫn dễ dàng tìm được điểm bảo hành chính hãng. Nhân viên ở mọi chi nhánh đều có chung một phong cách phục vụ chu đáo, tận tâm.</p>
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
                              <h6>Phạm Minh D</h6><span>Khách hàng thân thiết</span>
                           </div>
                           <div class="testimonial-content">
                              <p>Xe đẹp, lái chất, dịch vụ 5 sao! Từ lúc xem xe đến khi nhận xe chỉ mất vài ngày. Thủ tục trả góp tại showroom rất đơn giản và minh bạch.Chế độ hậu mãi và bảo dưỡng tại đây cũng rất nhanh chóng.Cảm ơn hệ thống showroom đã tư vấn tận tình để tôi tìm thấy người bạn đồng hành ưng ý này.</p>
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
         <div style="background:#e8f5e9;padding:26px 32px 18px;
                     text-align:center;border-bottom:1px solid #ddd;">
            <h2 style="margin:0;color:#1a7a3c;letter-spacing:2px;
                       font-size:22px;font-weight:700;">BÁO GIÁ NHANH</h2>
         </div>
         <button onclick="closePopup()"
                 style="position:absolute;top:12px;right:14px;
                        background:#e53935;border:none;border-radius:50%;
                        width:28px;height:28px;color:#fff;font-size:16px;
                        cursor:pointer;line-height:28px;padding:0;">✕</button>
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
/* ══════════════════════════════════════════
   1. BRAND → MODEL FILTER
   ══════════════════════════════════════════ */
(function() {
   var brandSelect = document.getElementById('brand-select');
   var modelSelect = document.getElementById('model-select');
   if (!brandSelect || !modelSelect) return;

   // Cache all original options (except the first "Tất cả dòng")
   var allOptions = Array.from(modelSelect.querySelectorAll('option[data-brand]'));

   brandSelect.addEventListener('change', function() {
      var selectedBrand = this.value;

      // Remove all brand options first
      allOptions.forEach(function(opt) {
         if (opt.parentNode) opt.parentNode.removeChild(opt);
      });

      // Reset model selection
      modelSelect.value = '';

      if (!selectedBrand) {
         // Show all models
         allOptions.forEach(function(opt) {
            modelSelect.appendChild(opt);
         });
      } else {
         // Show only matching brand models
         allOptions.forEach(function(opt) {
            if (opt.getAttribute('data-brand') === selectedBrand) {
               modelSelect.appendChild(opt);
            }
         });
      }
   });
})();

/* ══════════════════════════════════════════
   2. YOUTUBE VIDEO — autoplay on scroll
   ══════════════════════════════════════════ */
(function() {
   var videoWrap = document.getElementById('video-wrap');
   if (!videoWrap) return;

   var videoLoaded = false;
   // Video ID từ: https://youtu.be/OGEEQ9VEEmc
   var videoId = 'OGEEQ9VEEmc';

   function loadVideo(autoplay) {
      if (videoLoaded) return;
      videoLoaded = true;
      var iframe = document.createElement('iframe');
      iframe.src = 'https://www.youtube.com/embed/' + videoId
                 + '?autoplay=' + (autoplay ? '1' : '0')
                 + '&rel=0&modestbranding=1';
      iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
      iframe.allowFullscreen = true;
      iframe.style.cssText = 'position:absolute;top:0;left:0;width:100%;height:100%;border:0;';
      videoWrap.appendChild(iframe);
   }

   // IntersectionObserver — tự động load + play khi scroll đến
   if ('IntersectionObserver' in window) {
      var observer = new IntersectionObserver(function(entries) {
         entries.forEach(function(entry) {
            if (entry.isIntersecting) {
               loadVideo(true);  // autoplay=1
               observer.unobserve(entry.target);
            }
         });
      }, { threshold: 0.4 });
      observer.observe(videoWrap);
   } else {
      // Fallback cho trình duyệt cũ
      loadVideo(false);
   }
})();

/* ══════════════════════════════════════════
   3. POPUP
   ══════════════════════════════════════════ */
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