@extends('layouts.frontend')

@section('title', 'Dịch Vụ - AUTO X')

@push('styles')
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
  :root {
    --blue:   #1c69d4;
    --black:  #0a0a0a;
    --white:  #ffffff;
    --gray-1: #f7f7f7;
    --gray-2: #e8e8e8;
    --gray-3: #cccccc;
    --gray-4: #6b6b6b;
    --gray-5: #2a2a2a;
    --text:   #1a1a1a;
    --font:   'Inter', sans-serif;
    --font-h: 'Barlow Condensed', sans-serif;
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: var(--font); color: var(--text); font-size: 16px; -webkit-font-smoothing: antialiased; }
  a { text-decoration: none; color: inherit; }
  .container { max-width: 1200px; margin: 0 auto; padding: 0 48px; }
  @media (max-width: 768px) { .container { padding: 0 20px; } }

  /* ── HERO ── */
  .svc-hero { background: var(--black); padding: 80px 0 72px; position: relative; overflow: hidden; }
  .svc-hero::before {
    content: ''; position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1486006920555-c77dcf18193c?w=1600&q=80') center/cover no-repeat;
    opacity: .30;
  }
  .svc-hero-inner { position: relative; z-index: 1; display: flex; flex-direction: column; gap: 16px; }
  .svc-breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 14px; color: var(--gray-3); letter-spacing: .3px; }
  .svc-breadcrumb a { color: rgba(255,255,255,0.75); transition: color .2s; font-size: 14px; }
  .svc-breadcrumb a:hover { color: var(--white); }
  .svc-breadcrumb span { color: var(--white); font-size: 14px; }
  .svc-breadcrumb i { font-size: 10px; color: rgba(255,255,255,0.4); }
  .svc-hero h1 { font-family: var(--font-h); font-size: clamp(42px,6vw,76px); font-weight: 800; color: var(--white); text-transform: uppercase; letter-spacing: -1px; line-height: 1; }
  .svc-hero h1 span { color: var(--blue); }
  .svc-hero p { font-size: 17px; color: rgba(255,255,255,0.80); max-width: 520px; line-height: 1.75; font-weight: 400; }
  .svc-hero-actions { display: flex; gap: 12px; margin-top: 6px; flex-wrap: wrap; }
  .btn-primary { display: inline-flex; align-items: center; gap: 8px; background: var(--blue); color: var(--white) !important; font-size: 14px; font-weight: 600; letter-spacing: .6px; text-transform: uppercase; padding: 13px 28px; transition: background .2s; }
  .btn-primary:hover { background: #1555b0; color: var(--white) !important; }
  .btn-secondary { display: inline-flex; align-items: center; gap: 8px; background: transparent; color: var(--white) !important; font-size: 14px; font-weight: 600; letter-spacing: .6px; text-transform: uppercase; padding: 12px 28px; border: 1px solid rgba(255,255,255,.40); transition: border-color .2s; }
  .btn-secondary:hover { border-color: var(--white); color: var(--white) !important; }

  /* ── STATS BAR ── */
  .stats-bar { background: var(--white); border-bottom: 1px solid var(--gray-2); }
  .stats-bar-inner { display: grid; grid-template-columns: repeat(4,1fr); }
  .stat-item {
    padding: 36px 24px; border-right: 1px solid var(--gray-2); text-align: center;
    opacity: 0; transform: translateY(16px);
    transition: opacity .6s ease, transform .6s ease;
  }
  .stat-item:last-child { border-right: none; }
  .stat-item.visible { opacity: 1; transform: translateY(0); }
  .stat-num { font-family: var(--font-h); font-size: 52px; font-weight: 800; color: var(--blue); line-height: 1; display: block; }
  .stat-label { font-size: 13px; color: var(--gray-4); letter-spacing: .8px; margin-top: 8px; display: block; text-transform: uppercase; font-weight: 500; }
  @media (max-width: 640px) {
    .stats-bar-inner { grid-template-columns: repeat(2,1fr); }
    .stat-item:nth-child(-n+2) { border-bottom: 1px solid var(--gray-2); }
  }

  /* ── SECTION HEADER ── */
  .section { padding: 72px 0; }
  .section-tag { font-size: 12px; font-weight: 600; letter-spacing: 2.5px; text-transform: uppercase; color: var(--blue); margin-bottom: 10px; display: block; }
  .section-title { font-family: var(--font-h); font-size: clamp(28px,4vw,44px); font-weight: 800; text-transform: uppercase; color: var(--text); letter-spacing: -.5px; line-height: 1.1; }
  .section-sub { font-size: 16px; color: var(--gray-4); margin-top: 12px; max-width: 560px; line-height: 1.8; }
  .section-divider { width: 48px; height: 3px; background: var(--blue); margin: 18px 0 0; }

  /* ── QUICK NAV ── */
  .quick-nav { background: var(--gray-1); border-top: 1px solid var(--gray-2); border-bottom: 1px solid var(--gray-2); }
  .quick-nav-inner { display: flex; overflow-x: auto; scrollbar-width: none; }
  .quick-nav-inner::-webkit-scrollbar { display: none; }
  .quick-nav-item { display: flex; align-items: center; gap: 8px; padding: 16px 22px; font-size: 14px; font-weight: 500; color: var(--gray-5); white-space: nowrap; border-right: 1px solid var(--gray-2); transition: background .18s, color .18s; }
  .quick-nav-item:hover, .quick-nav-item.active { background: var(--white); color: var(--blue); }
  .quick-nav-item i { font-size: 13px; color: var(--blue); }

  /* ── MAIN SERVICES GRID ── */
  .svc-list-section { background: var(--white); }
  .svc-list-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 0; border: 1px solid var(--gray-2); margin-top: 48px; }
  .svc-list-item { display: flex; align-items: flex-start; gap: 20px; padding: 32px 28px; border-right: 1px solid var(--gray-2); border-bottom: 1px solid var(--gray-2); transition: background .18s; position: relative; }
  .svc-list-item:nth-child(even) { border-right: none; }
  .svc-list-item:hover { background: var(--gray-1); }
  .svc-list-item::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: transparent; transition: background .2s; }
  .svc-list-item:hover::before { background: var(--blue); }
  .svc-icon-box { width: 52px; height: 52px; flex-shrink: 0; background: #e8f0fe; display: flex; align-items: center; justify-content: center; border-radius: 8px; }
  .svc-icon-box img { width: 26px; height: 26px; object-fit: contain; }
  .svc-info { flex: 1; }
  .svc-info h3 { font-family: var(--font-h); font-size: 20px; font-weight: 700; text-transform: uppercase; color: var(--text); letter-spacing: .2px; margin-bottom: 8px; }
  .svc-info p { font-size: 15px; color: var(--gray-4); line-height: 1.8; margin-bottom: 16px; }
  .svc-link { font-size: 13px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--blue); display: inline-flex; align-items: center; gap: 6px; transition: gap .2s; }
  .svc-link:hover { gap: 10px; color: var(--blue); }
  .svc-link i { font-size: 11px; }
  @media (max-width: 768px) { .svc-list-grid { grid-template-columns: 1fr; } .svc-list-item { border-right: none; } }

  /* ── QUICK SERVICE ── */
  .quick-svc-grid {
    display: grid; grid-template-columns: repeat(3,1fr);
    gap: 0; margin-top: 36px;
    border-top: 1px solid var(--gray-2);
    border-left: 1px solid var(--gray-2);
  }
  .quick-svc-item {
    display: flex; align-items: flex-start; gap: 16px;
    padding: 28px 24px;
    border-right: 1px solid var(--gray-2);
    border-bottom: 1px solid var(--gray-2);
    background: transparent;
    transition: background .18s;
    color: var(--text);
  }
  .quick-svc-item:hover { background: var(--white); }
  .quick-svc-icon { width: 44px; height: 44px; flex-shrink: 0; background: #e8f0fe; display: flex; align-items: center; justify-content: center; border-radius: 6px; }
  .quick-svc-icon i { color: var(--blue); font-size: 18px; }
  .quick-svc-title { font-family: var(--font-h); font-size: 17px; font-weight: 700; text-transform: uppercase; color: var(--text); margin-bottom: 6px; }
  .quick-svc-desc { font-size: 14px; color: var(--gray-4); line-height: 1.7; }
  @media (max-width: 768px) { .quick-svc-grid { grid-template-columns: 1fr; } }

  /* ── PROCESS ── */
  .process-section { background: var(--gray-1); }
  .process-grid { display: grid; grid-template-columns: repeat(5,1fr); gap: 0; margin-top: 48px; border: 1px solid var(--gray-2); background: var(--gray-2); }
  .process-step { background: var(--white); padding: 32px 20px; text-align: center; transition: background .18s; }
  .process-step:hover { background: var(--gray-1); }
  .process-step + .process-step { border-left: 1px solid var(--gray-2); }
  .step-num-circle { width: 48px; height: 48px; background: var(--blue); color: var(--white); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: var(--font-h); font-size: 20px; font-weight: 800; margin: 0 auto 16px; }
  .process-step h4 { font-family: var(--font-h); font-size: 16px; font-weight: 700; text-transform: uppercase; letter-spacing: .3px; color: var(--text); margin-bottom: 10px; }
  .process-step p { font-size: 14px; color: var(--gray-4); line-height: 1.75; }
  @media (max-width: 900px) { .process-grid { grid-template-columns: repeat(2,1fr); } .process-step + .process-step { border-left: none; border-top: 1px solid var(--gray-2); } }
  @media (max-width: 480px) { .process-grid { grid-template-columns: 1fr; } }

  /* ── PACKAGES ── */
  .packages-section { background: var(--white); }
  .pkg-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 0; margin-top: 48px; border: 1px solid var(--gray-2); background: var(--gray-2); }
  .pkg-card { background: var(--white); padding: 36px 28px; position: relative; transition: background .2s; }
  .pkg-card + .pkg-card { border-left: 1px solid var(--gray-2); }
  .pkg-card:hover { background: var(--gray-1); }
  .pkg-card.highlight { background: var(--blue); color: var(--white); }
  .pkg-card.highlight:hover { background: #1555b0; }
  .pkg-badge-label { display: inline-block; font-size: 11px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; padding: 5px 12px; background: var(--white); color: var(--blue); margin-bottom: 16px; }
  .pkg-card.highlight .pkg-badge-label { background: rgba(255,255,255,.2); color: var(--white); }
  .pkg-name { font-size: 12px; font-weight: 600; letter-spacing: 2.5px; text-transform: uppercase; color: var(--gray-4); margin-bottom: 8px; }
  .pkg-card.highlight .pkg-name { color: rgba(255,255,255,.7); }
  .pkg-price-num { font-family: var(--font-h); font-size: 52px; font-weight: 800; line-height: 1; color: var(--text); }
  .pkg-card.highlight .pkg-price-num { color: var(--white); }
  .pkg-price-unit { font-size: 14px; color: var(--gray-4); margin: 6px 0 24px; }
  .pkg-card.highlight .pkg-price-unit { color: rgba(255,255,255,.65); }
  .pkg-divider { height: 1px; background: var(--gray-2); margin-bottom: 20px; }
  .pkg-card.highlight .pkg-divider { background: rgba(255,255,255,.2); }
  .pkg-features-list { list-style: none; padding: 0; margin: 0 0 28px; }
  .pkg-features-list li { display: flex; align-items: flex-start; gap: 10px; font-size: 14px; color: var(--gray-5); padding: 9px 0; border-bottom: 1px solid var(--gray-2); line-height: 1.6; }
  .pkg-card.highlight .pkg-features-list li { color: rgba(255,255,255,.90); border-bottom-color: rgba(255,255,255,.15); }
  .pkg-features-list li:last-child { border-bottom: none; }
  .pkg-features-list li i { color: var(--blue); margin-top: 3px; font-size: 12px; flex-shrink: 0; }
  .pkg-card.highlight .pkg-features-list li i { color: rgba(255,255,255,.9); }
  .btn-pkg-outline { display: block; text-align: center; font-size: 13px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; padding: 13px 20px; border: 1px solid var(--blue); color: var(--blue); transition: background .18s, color .18s; }
  .btn-pkg-outline:hover { background: var(--blue); color: var(--white); }
  .btn-pkg-white { display: block; text-align: center; font-size: 13px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; padding: 13px 20px; background: var(--white); color: var(--blue); transition: opacity .18s; }
  .btn-pkg-white:hover { opacity: .9; color: var(--blue); }
  @media (max-width: 768px) { .pkg-grid { grid-template-columns: 1fr; } .pkg-card + .pkg-card { border-left: none; border-top: 1px solid var(--gray-2); } }

  /* ── CTA ── */
  .cta-section { background: var(--black); padding: 80px 0; text-align: center; position: relative; overflow: hidden; }
  .cta-section::before { content: ''; position: absolute; inset: 0; background: url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1400&q=80') center/cover no-repeat; opacity: .40; }
  .cta-inner { position: relative; z-index: 1; }
  .cta-section h2 { font-family: var(--font-h); font-size: clamp(32px,5vw,60px); font-weight: 800; text-transform: uppercase; color: #ffffff !important; -webkit-text-fill-color: #ffffff !important; line-height: 1.1; margin-bottom: 16px; }
  .cta-section h2 span { color: var(--blue) !important; -webkit-text-fill-color: var(--blue) !important; }
  .cta-section p { font-size: 17px; color: rgba(255,255,255,0.80) !important; -webkit-text-fill-color: rgba(255,255,255,0.80) !important; max-width: 480px; margin: 0 auto 32px; line-height: 1.8; }
  .cta-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

  .svc-breadcrumb { justify-content: center; }
  .svc-hero-inner { align-items: center; }
  .svc-breadcrumb { order: 10; margin-top: 16px; }
  .quick-nav-inner { overflow-x: scroll !important; }
</style>
@endpush
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="svc-hero">
  <div class="container">
    <div class="svc-hero-inner">
      <div class="svc-breadcrumb">
        <a href="{{ url('/') }}">Trang chủ</a>
        <i class="fa fa-angle-right"></i>
        <span>Dịch Vụ</span>
      </div>
      <h1>Dịch Vụ &amp; <span>Bảo Dưỡng</span></h1>
      <p>Chúng tôi cung cấp dịch vụ toàn diện — từ tư vấn mua xe, hỗ trợ tài chính đến bảo dưỡng và chăm sóc xe sau mua.</p>
      <div class="svc-hero-actions">
        <a href="{{ route('services.booking') }}" class="btn-primary">
          <i class="fa fa-calendar"></i> Đặt lịch dịch vụ
        </a>
        <a href="{{ url('/contact') }}" class="btn-secondary">
          <i class="fa fa-phone"></i> Liên hệ ngay
        </a>
      </div>
    </div>
  </div>
</section>

{{-- STATS — nền trắng, số đếm khi scroll --}}
<div class="stats-bar">
  <div class="container" style="padding:0 48px">
    <div class="stats-bar-inner">
      <div class="stat-item" data-delay="0">
        <span class="stat-num" data-target="15" data-suffix="+">0</span>
        <span class="stat-label">Năm kinh nghiệm</span>
      </div>
      <div class="stat-item" data-delay="120">
        <span class="stat-num" data-target="8000" data-suffix="+">0</span>
        <span class="stat-label">Khách hàng phục vụ</span>
      </div>
      <div class="stat-item" data-delay="240">
        <span class="stat-num" data-static="24/7">24/7</span>
        <span class="stat-label">Hỗ trợ liên tục</span>
      </div>
      <div class="stat-item" data-delay="360">
        <span class="stat-num" data-target="98" data-suffix="%">0</span>
        <span class="stat-label">Hài lòng sau dịch vụ</span>
      </div>
    </div>
  </div>
</div>

{{-- QUICK NAV --}}
<nav class="quick-nav">
  <div class="container" style="padding:0 48px">
    <div class="quick-nav-inner">
      <a href="#danh-muc" class="quick-nav-item active"><i class="fa fa-th-large"></i> Tất cả dịch vụ</a>
      <a href="{{ route('services.booking') }}" class="quick-nav-item"><i class="fa fa-calendar-check-o"></i> Đặt lịch trực tuyến</a>
      <a href="{{ route('services.maintenance-process') }}" class="quick-nav-item"><i class="fa fa-bolt"></i> Quy trình bảo dưỡng nhanh</a>
      <a href="{{ route('services.maintenance-schedule') }}" class="quick-nav-item"><i class="fa fa-clock-o"></i> Lịch bảo dưỡng định kỳ</a>
      <a href="{{ route('services.pickup-delivery') }}" class="quick-nav-item"><i class="fa fa-truck"></i> Nhận &amp; giao xe tận nơi</a>
      <a href="{{ url('/contact') }}" class="quick-nav-item"><i class="fa fa-phone"></i> Liên hệ hỗ trợ</a>
    </div>
  </div>
</nav>

{{-- MAIN SERVICES --}}
<section class="section svc-list-section" id="danh-muc">
  <div class="container">
    <span class="section-tag">Danh mục dịch vụ</span>
    <h2 class="section-title">Tất Cả Dịch Vụ</h2>
    <p class="section-sub">Mọi nhu cầu xe hơi của bạn được đáp ứng tại một địa điểm duy nhất.</p>
    <div class="section-divider"></div>
    <div class="svc-list-grid">
      <div class="svc-list-item">
        <div class="svc-icon-box"><img src="https://cdn-icons-png.flaticon.com/512/3774/3774278.png" alt=""></div>
        <div class="svc-info">
          <h3>Tư Vấn &amp; Mua Xe</h3>
          <p>Đội ngũ tư vấn chuyên nghiệp giúp bạn tìm chiếc xe phù hợp nhất. Lái thử miễn phí, so sánh đa thương hiệu, tư vấn giá trị tái bán.</p>
          <a href="{{ url('/contact') }}" class="svc-link">Đặt lịch tư vấn <i class="fa fa-arrow-right"></i></a>
        </div>
      </div>
      <div class="svc-list-item">
        <div class="svc-icon-box"><img src="https://cdn-icons-png.flaticon.com/512/2830/2830284.png" alt=""></div>
        <div class="svc-info">
          <h3>Hỗ Trợ Tài Chính</h3>
          <p>Kết nối trực tiếp 10+ ngân hàng hàng đầu. Phê duyệt trong 24h, lãi suất từ 5.9%/năm, trả góp linh hoạt 12–60 tháng.</p>
          <a href="{{ url('/contact') }}" class="svc-link">Tính toán ngay <i class="fa fa-arrow-right"></i></a>
        </div>
      </div>
      <div class="svc-list-item">
        <div class="svc-icon-box"><img src="https://cdn-icons-png.flaticon.com/512/2092/2092063.png" alt=""></div>
        <div class="svc-info">
          <h3>Bảo Dưỡng &amp; Sửa Chữa</h3>
          <p>Xưởng dịch vụ đạt chuẩn quốc tế. Kỹ thuật viên được chứng nhận, thiết bị hiện đại, phụ tùng chính hãng.</p>
          <a href="{{ route('services.booking') }}" class="svc-link">Đặt lịch bảo dưỡng <i class="fa fa-arrow-right"></i></a>
        </div>
      </div>
      <div class="svc-list-item">
        <div class="svc-icon-box"><img src="https://cdn-icons-png.flaticon.com/512/3068/3068583.png" alt=""></div>
        <div class="svc-info">
          <h3>Bảo Hiểm Xe Hơi</h3>
          <p>Gói bảo hiểm toàn diện từ các công ty uy tín. Bồi thường trong 48h, xe thay thế khi sửa chữa, ưu đãi cho khách mua xe.</p>
          <a href="{{ url('/contact') }}" class="svc-link">Nhận báo giá <i class="fa fa-arrow-right"></i></a>
        </div>
      </div>
      <div class="svc-list-item">
        <div class="svc-icon-box"><img src="https://cdn-icons-png.flaticon.com/512/3144/3144456.png" alt=""></div>
        <div class="svc-info">
          <h3>Đổi Xe &amp; Trade-in</h3>
          <p>Định giá xe cũ trong 30 phút theo thị trường thực tế. Thanh toán ngay, hỗ trợ sang tên, áp dụng chiết khấu mua xe mới.</p>
          <a href="{{ url('/contact') }}" class="svc-link">Định giá xe ngay <i class="fa fa-arrow-right"></i></a>
        </div>
      </div>
      <div class="svc-list-item">
        <div class="svc-icon-box"><img src="https://cdn-icons-png.flaticon.com/512/1048/1048953.png" alt=""></div>
        <div class="svc-info">
          <h3>Đăng Ký &amp; Thủ Tục</h3>
          <p>Hỗ trợ đăng ký biển số, sang tên, đổi chủ và toàn bộ thủ tục pháp lý liên quan đến xe nhanh chóng, trọn gói.</p>
          <a href="{{ url('/contact') }}" class="svc-link">Tìm hiểu thêm <i class="fa fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- QUICK SERVICE — không có khung nổi, hoà vào nền xám --}}
<section class="section" style="background:var(--gray-1);padding-top:0;padding-bottom:72px;">
  <div class="container">
    <span class="section-tag">Truy cập nhanh</span>
    <h2 class="section-title">Dịch Vụ Trực Tuyến</h2>
    <div class="section-divider"></div>
    <div class="quick-svc-grid">
      <a href="{{ route('services.booking') }}" class="quick-svc-item">
        <div class="quick-svc-icon"><i class="fa fa-calendar"></i></div>
        <div><div class="quick-svc-title">Đặt lịch dịch vụ</div><div class="quick-svc-desc">Đặt lịch trực tuyến nhanh chóng, chọn giờ phù hợp</div></div>
      </a>
      <a href="{{ route('services.maintenance-process') }}" class="quick-svc-item">
        <div class="quick-svc-icon"><i class="fa fa-bolt"></i></div>
        <div><div class="quick-svc-title">Quy trình bảo dưỡng nhanh</div><div class="quick-svc-desc">Hoàn thành trong 60 phút không cần đặt lịch trước</div></div>
      </a>
      <a href="{{ route('services.maintenance-schedule') }}" class="quick-svc-item">
        <div class="quick-svc-icon"><i class="fa fa-clock-o"></i></div>
        <div><div class="quick-svc-title">Lịch bảo dưỡng định kỳ</div><div class="quick-svc-desc">Tra cứu lịch bảo dưỡng theo số km xe bạn đã đi</div></div>
      </a>
      <a href="{{ route('services.pickup-delivery') }}" class="quick-svc-item">
        <div class="quick-svc-icon"><i class="fa fa-truck"></i></div>
        <div><div class="quick-svc-title">Nhận &amp; giao xe miễn phí</div><div class="quick-svc-desc">Chúng tôi đến tận nơi nhận xe, giao xe sau khi xong</div></div>
      </a>
      <a href="{{ url('/contact') }}" class="quick-svc-item">
        <div class="quick-svc-icon"><i class="fa fa-shield"></i></div>
        <div><div class="quick-svc-title">Cơ sở bảo hành bảo dưỡng</div><div class="quick-svc-desc">Tìm trung tâm dịch vụ ủy quyền gần nhất</div></div>
      </a>
      <a href="{{ url('/contact') }}" class="quick-svc-item">
        <div class="quick-svc-icon"><i class="fa fa-headphones"></i></div>
        <div><div class="quick-svc-title">Hỗ trợ khách hàng 24/7</div><div class="quick-svc-desc">Gọi hotline hoặc chat trực tiếp với chuyên gia</div></div>
      </a>
    </div>
  </div>
</section>

{{-- QUY TRÌNH --}}
<section class="section process-section">
  <div class="container">
    <span class="section-tag">Đơn giản &amp; nhanh chóng</span>
    <h2 class="section-title">Quy Trình 5 Bước</h2>
    <p class="section-sub">Từ lúc liên hệ đến khi nhận xe — chúng tôi đảm bảo trải nghiệm trơn tru nhất.</p>
    <div class="section-divider"></div>
    <div class="process-grid">
      <div class="process-step"><div class="step-num-circle">1</div><h4>Liên hệ tư vấn</h4><p>Gọi điện, nhắn tin hoặc đến trực tiếp showroom để được tư vấn miễn phí.</p></div>
      <div class="process-step"><div class="step-num-circle">2</div><h4>Chọn xe &amp; lái thử</h4><p>Xem xe thực tế và lái thử miễn phí để trải nghiệm trực tiếp.</p></div>
      <div class="process-step"><div class="step-num-circle">3</div><h4>Hoàn thiện hồ sơ</h4><p>Đội ngũ hỗ trợ chuẩn bị đầy đủ giấy tờ, hợp đồng và thủ tục pháp lý.</p></div>
      <div class="process-step"><div class="step-num-circle">4</div><h4>Thanh toán &amp; ký kết</h4><p>Thanh toán linh hoạt — tiền mặt, chuyển khoản hoặc vay ngân hàng.</p></div>
      <div class="process-step"><div class="step-num-circle">5</div><h4>Nhận xe &amp; hậu mãi</h4><p>Giao xe tận nơi, hỗ trợ biển số và theo dõi hậu mãi 24/7.</p></div>
    </div>
  </div>
</section>

{{-- PACKAGES --}}
<section class="section packages-section">
  <section class="reminder-section" id="reminder">
  <div class="container">
    <span class="section-tag">Gói hậu mãi</span>
    <h2 class="section-title">Chọn Gói Phù Hợp</h2>
    <p class="section-sub">Các gói dịch vụ hậu mãi được thiết kế để bảo vệ xe của bạn toàn diện.</p>
    <div class="section-divider"></div>
    <div class="pkg-grid">
      <div class="pkg-card">
        <div class="pkg-name">Gói Cơ Bản</div>
        <div class="pkg-price-num">2.9<span style="font-size:24px;font-weight:600">tr</span></div>
        <div class="pkg-price-unit">/ năm</div>
        <div class="pkg-divider"></div>
        <ul class="pkg-features-list">
          <li><i class="fa fa-check"></i> Kiểm tra xe 2 lần/năm</li>
          <li><i class="fa fa-check"></i> Thay dầu &amp; lọc gió</li>
          <li><i class="fa fa-check"></i> Hotline hỗ trợ 8h–18h</li>
          <li><i class="fa fa-check"></i> Chiết khấu 5% phụ tùng</li>
        </ul>
        <a href="{{ route('services.maintenance-schedule') }}#reminder" class="btn-pkg-outline">Đăng ký gói</a>
      </div>
      <div class="pkg-card highlight">
        <div class="pkg-badge-label">Phổ biến nhất</div>
        <div class="pkg-name">Gói Tiêu Chuẩn</div>
        <div class="pkg-price-num">6,9<span style="font-size:24px;font-weight:600">tr</span></div>
        <div class="pkg-price-unit">/ năm</div>
        <div class="pkg-divider"></div>
        <ul class="pkg-features-list">
          <li><i class="fa fa-check"></i> Kiểm tra xe 4 lần/năm</li>
          <li><i class="fa fa-check"></i> Bảo dưỡng toàn diện</li>
          <li><i class="fa fa-check"></i> Hotline hỗ trợ 24/7</li>
          <li><i class="fa fa-check"></i> Chiết khấu 10% phụ tùng</li>
          <li><i class="fa fa-check"></i> Xe thay thế khi sửa chữa</li>
          <li><i class="fa fa-check"></i> Cứu hộ khẩn cấp 24/7</li>
        </ul>
       <a href="{{ route('services.maintenance-schedule') }}#reminder" class="btn-pkg-white">Đăng ký ngay</a>
      </div>
      <div class="pkg-card">
        <div class="pkg-name">Gói Cao Cấp</div>
        <div class="pkg-price-num">4,9<span style="font-size:24px;font-weight:600">tr</span></div>
        <div class="pkg-price-unit">/ năm</div>
        <div class="pkg-divider"></div>
        <ul class="pkg-features-list">
          <li><i class="fa fa-check"></i> Kiểm tra xe không giới hạn</li>
          <li><i class="fa fa-check"></i> Bảo dưỡng VIP ưu tiên</li>
          <li><i class="fa fa-check"></i> Quản lý xe cá nhân 1–1</li>
          <li><i class="fa fa-check"></i> Chiết khấu 20% phụ tùng</li>
          <li><i class="fa fa-check"></i> Rửa xe miễn phí hàng tuần</li>
          <li><i class="fa fa-check"></i> Ưu tiên test-drive xe mới</li>
        </ul>
       <a href="{{ route('services.maintenance-schedule') }}#reminder" class="btn-pkg-outline">Đăng ký gói</a>
      </div>
    </div>
  </div>
</section>
</section>
{{-- CTA --}}
<section class="cta-section">
  <div class="cta-inner container">
    <h2>Bắt Đầu Trải Nghiệm<br/><span>Dịch Vụ</span> Ngay Hôm Nay</h2>
    <p>Đội ngũ chuyên gia luôn sẵn sàng hỗ trợ bạn 24/7. Liên hệ ngay để được tư vấn miễn phí.</p>
    <div class="cta-btns">
      <a href="{{ route('services.booking') }}" class="btn-primary"><i class="fa fa-calendar"></i> Đặt lịch dịch vụ</a>
      <a href="{{ url('/cars') }}" class="btn-secondary"><i class="fa fa-car"></i> Xem tất cả xe</a>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
(function () {

  /* ── COUNT-UP KHI SCROLL TỚI ── */
  function countUp(el, target, suffix, duration) {
    // Nếu là static thì bỏ qua
    if (el.dataset.static) return;

    const start = performance.now();
    function step(now) {
      const progress = Math.min((now - start) / duration, 1);
      const ease = 1 - Math.pow(1 - progress, 3); // easeOutCubic
      const value = Math.floor(ease * target);
      // Format 1000+ thành "1.000"
      el.textContent = (target >= 1000 ? value.toLocaleString('vi-VN') : value) + suffix;
      if (progress < 1) requestAnimationFrame(step);
      else el.textContent = (target >= 1000 ? target.toLocaleString('vi-VN') : target) + suffix;
    }
    requestAnimationFrame(step);
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const item = entry.target;
      if (item.dataset.counted) return;
      item.dataset.counted = '1';

      const delay  = parseInt(item.dataset.delay || 0);
      const numEl  = item.querySelector('.stat-num');
      const target = parseInt(numEl.dataset.target || 0);
      const suffix = numEl.dataset.suffix || '';

      setTimeout(() => {
        item.classList.add('visible');
        if (!numEl.dataset.static) countUp(numEl, target, suffix, 1500);
      }, delay);

      observer.unobserve(item);
    });
  }, { threshold: 0.35 });

  document.querySelectorAll('.stat-item').forEach(el => observer.observe(el));

  /* ── ACTIVE QUICK NAV KHI SCROLL ── */
  const navItems = document.querySelectorAll('.quick-nav-item');
  window.addEventListener('scroll', () => {
    document.querySelectorAll('section[id]').forEach(s => {
      if (window.scrollY >= s.offsetTop - 150) {
        navItems.forEach(a => {
          a.classList.toggle('active', a.getAttribute('href') === '#' + s.id);
        });
      }
    });
  }, { passive: true });

})();
</script>
@endpush