@extends('layouts.frontend')

@section('title', 'Liên Hệ - Concept Car Dealer')

@push('styles')
<style>
  :root {
    --red: #d42b2b; --red-dark: #b01e1e;
    --red-light: rgba(212,43,43,0.08); --red-border: rgba(212,43,43,0.22);
    --bg: #1c1c1e; --bg2: #242426; --bg3: #2c2c2f; --card: #2a2a2d;
    --border: #3a3a3e; --border-light: #4a4a4e;
    --white: #f5f0eb; --text: #c8c3bc; --muted: #8a857e; --subtle: #5a5854;
  }

  .section { padding: 96px 0; }
  .container { max-width: 1240px; margin: 0 auto; padding: 0 48px; }
  .section-label {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: 4px; text-transform: uppercase; color: var(--red);
    margin-bottom: 10px; display: flex; align-items: center; gap: 10px;
  }
  .section-label::before { content: ''; width: 3px; height: 14px; background: var(--red); flex-shrink: 0; }
  .section-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(34px,4vw,52px); font-weight: 800;
    text-transform: uppercase; color: var(--white); letter-spacing: -.5px;
  }
  .divider-line { width: 56px; height: 3px; background: var(--red); margin: 24px 0; }

  /* HERO */
  .hero {
    position: relative; height: 440px;
    background: linear-gradient(160deg,#1c1c1e 0%,#2a1616 45%,#1c1c1e 100%);
    display: flex; align-items: center; justify-content: center; overflow: hidden;
  }
  .hero::before {
    content: ''; position: absolute; inset: 0;
    background:
      repeating-linear-gradient(90deg,transparent,transparent 80px,rgba(212,43,43,.025) 80px,rgba(212,43,43,.025) 81px),
      repeating-linear-gradient(0deg,transparent,transparent 80px,rgba(212,43,43,.025) 80px,rgba(212,43,43,.025) 81px);
  }
  .hero-glow {
    position: absolute; width: 700px; height: 350px;
    background: radial-gradient(ellipse,rgba(180,30,30,.2) 0%,transparent 68%);
    top: 50%; left: 50%; transform: translate(-50%,-50%);
    animation: pulse 5s ease-in-out infinite;
  }
  @keyframes pulse { 0%,100%{opacity:.5;transform:translate(-50%,-50%) scale(1)} 50%{opacity:1;transform:translate(-50%,-50%) scale(1.08)} }
  .hero-content { position: relative; text-align: center; }
  .hero-eyebrow {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: 5px; text-transform: uppercase; color: var(--red);
    margin-bottom: 18px; display: flex; align-items: center; justify-content: center; gap: 14px;
  }
  .hero-eyebrow::before,.hero-eyebrow::after { content: ''; width: 36px; height: 1px; background: var(--red); opacity: .5; }
  .hero h1 {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(60px,9vw,106px); font-weight: 800;
    color: var(--white); line-height: .92; text-transform: uppercase; letter-spacing: -1px;
  }
  .hero h1 em { color: var(--red); font-style: normal; }
  .hero-sub { margin-top: 20px; font-size: 15px; color: var(--muted); }
  .breadcrumb {
    position: absolute; bottom: 28px; left: 50%; transform: translateX(-50%);
    display: flex; align-items: center; gap: 10px;
    font-size: 12px; letter-spacing: 1px; color: var(--subtle);
  }
  .breadcrumb a { color: var(--subtle); text-decoration: none; }
  .breadcrumb a:hover { color: var(--red); }
  .breadcrumb span { color: var(--red); }

  /* CONTACT INFO STRIP */
  .info-strip { background: var(--red); }
  .info-grid { display: grid; grid-template-columns: repeat(4,1fr); border-left: 1px solid rgba(255,255,255,.15); }
  .info-item { padding: 36px 28px; border-right: 1px solid rgba(255,255,255,.15); display: flex; align-items: flex-start; gap: 16px; transition: background .2s; }
  .info-item:hover { background: rgba(0,0,0,.1); }
  .info-icon { width: 42px; height: 42px; background: rgba(255,255,255,.15); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
  .info-icon svg { width: 18px; height: 18px; stroke: #fff; fill: none; stroke-width: 1.5; }
  .info-label { font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: rgba(255,255,255,.6); margin-bottom: 4px; }
  .info-value { font-family: 'Barlow Condensed', sans-serif; font-size: 18px; font-weight: 700; color: #fff; line-height: 1.2; }
  .info-sub { font-size: 12px; color: rgba(255,255,255,.55); margin-top: 2px; }

  /* MAIN CONTACT SECTION */
  .contact-section { background: var(--bg); padding: 96px 0; }
  .contact-layout { display: grid; grid-template-columns: 1.1fr 1fr; gap: 60px; align-items: start; }

  /* FORM */
  .form-wrapper { background: var(--bg2); border: 1px solid var(--border); }
  .form-header { padding: 28px 36px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
  .form-header-title { font-family: 'Barlow Condensed', sans-serif; font-size: 22px; font-weight: 800; text-transform: uppercase; color: var(--white); }
  .form-header-sub { font-size: 12px; color: var(--muted); margin-top: 4px; }
  .form-badge { background: var(--red); font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #fff; padding: 6px 12px; }
  .form-body { padding: 36px; }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
  .form-group { margin-bottom: 16px; }
  .form-label { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--muted); margin-bottom: 8px; display: block; }
  .form-label span { color: var(--red); }
  .form-input, .form-select, .form-textarea {
    width: 100%; background: var(--card); border: 1px solid var(--border); color: var(--white);
    font-family: 'Rajdhani', sans-serif; font-size: 14px; font-weight: 500;
    padding: 13px 16px; outline: none; transition: border-color .2s, background .2s;
    box-sizing: border-box; appearance: none; -webkit-appearance: none;
  }
  .form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: var(--red); background: var(--bg3);
  }
  .form-input::placeholder, .form-textarea::placeholder { color: var(--subtle); }
  .form-select { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238a857e' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 40px; cursor: pointer; }
  .form-select option { background: var(--card); color: var(--white); }
  .form-textarea { resize: vertical; min-height: 120px; font-family: 'Rajdhani', sans-serif; }
  .form-checkbox { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 24px; }
  .form-checkbox input[type="checkbox"] { width: 16px; height: 16px; min-width: 16px; accent-color: var(--red); margin-top: 2px; cursor: pointer; }
  .form-checkbox label { font-size: 12px; color: var(--muted); line-height: 1.6; cursor: pointer; }
  .form-checkbox label a { color: var(--red); text-decoration: none; }
  .btn-submit {
    width: 100%; background: var(--red); color: #fff; border: none; cursor: pointer;
    font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700;
    letter-spacing: 4px; text-transform: uppercase; padding: 16px;
    display: flex; align-items: center; justify-content: center; gap: 10px;
    transition: background .2s, transform .15s;
  }
  .btn-submit:hover { background: var(--red-dark); transform: translateY(-1px); }
  .btn-submit svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; }

  /* SUCCESS MESSAGE */
  .success-msg { display: none; background: rgba(30,120,30,.12); border: 1px solid rgba(30,200,30,.2); padding: 16px 20px; margin-top: 16px; }
  .success-msg.show { display: flex; align-items: center; gap: 12px; }
  .success-msg svg { width: 18px; height: 18px; stroke: #4caf50; fill: none; stroke-width: 2; flex-shrink: 0; }
  .success-msg span { font-size: 13px; color: #4caf50; }

  /* SIDEBAR */
  .contact-sidebar { display: flex; flex-direction: column; gap: 20px; }
  .sidebar-card { background: var(--bg2); border: 1px solid var(--border); overflow: hidden; }
  .sidebar-card-header { padding: 18px 24px; background: var(--card); border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; }
  .sidebar-card-icon { width: 36px; height: 36px; background: var(--red-light); border: 1px solid var(--red-border); display: flex; align-items: center; justify-content: center; }
  .sidebar-card-icon svg { width: 16px; height: 16px; stroke: var(--red); fill: none; stroke-width: 1.5; }
  .sidebar-card-title { font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--white); }
  .sidebar-card-body { padding: 20px 24px; }

  /* HOURS */
  .hours-list { display: flex; flex-direction: column; gap: 2px; }
  .hour-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--border); font-size: 13px; }
  .hour-row:last-child { border-bottom: none; }
  .hour-day { color: var(--text); }
  .hour-time { font-family: 'Rajdhani', sans-serif; font-weight: 700; color: var(--white); letter-spacing: .5px; }
  .hour-row.today .hour-day { color: var(--red); }
  .hour-row.today .hour-time { color: var(--red); }
  .open-badge { background: var(--red-light); border: 1px solid var(--red-border); font-family: 'Rajdhani', sans-serif; font-size: 9px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--red); padding: 3px 8px; margin-left: 8px; }

  /* MAP PLACEHOLDER */
  .map-frame { width: 100%; height: 200px; background: var(--card); border: 1px solid var(--border); position: relative; overflow: hidden; display: flex; align-items: center; justify-content: center; }
  .map-frame svg { width: 100%; height: 100%; }
  .map-pin { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -100%); }
  .map-pin-icon { width: 36px; height: 36px; background: var(--red); display: flex; align-items: center; justify-content: center; position: relative; clip-path: polygon(50% 100%, 0% 30%, 0% 0%, 100% 0%, 100% 30%); }
  .map-pin-icon svg { width: 16px; height: 16px; stroke: #fff; fill: none; stroke-width: 2; margin-bottom: 6px; }
  .map-overlay { position: absolute; bottom: 0; left: 0; right: 0; padding: 10px 14px; background: linear-gradient(transparent,rgba(0,0,0,.7)); display: flex; align-items: center; justify-content: space-between; }
  .map-address { font-size: 12px; color: rgba(255,255,255,.75); }
  .map-link { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--red); text-decoration: none; }
  .map-link:hover { color: #fff; }

  /* SOCIAL */
  .social-links { display: flex; flex-direction: column; gap: 2px; }
  .social-link { display: flex; align-items: center; gap: 14px; padding: 12px 0; border-bottom: 1px solid var(--border); text-decoration: none; transition: gap .2s; }
  .social-link:last-child { border-bottom: none; }
  .social-link:hover { gap: 20px; }
  .social-link-icon { width: 34px; height: 34px; background: var(--card); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; transition: background .2s, border-color .2s; }
  .social-link:hover .social-link-icon { background: var(--red-light); border-color: var(--red-border); }
  .social-link-icon svg { width: 14px; height: 14px; stroke: var(--muted); fill: none; stroke-width: 1.5; transition: stroke .2s; }
  .social-link:hover .social-link-icon svg { stroke: var(--red); }
  .social-link-name { font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--text); transition: color .2s; }
  .social-link:hover .social-link-name { color: var(--white); }
  .social-link-handle { font-size: 12px; color: var(--subtle); }

  /* FAQ QUICK */
  .faq-quick { display: flex; flex-direction: column; gap: 2px; }
  .faq-item { background: var(--bg3); border: 1px solid var(--border); overflow: hidden; }
  .faq-q { padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; }
  .faq-q-text { font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700; letter-spacing: .5px; color: var(--white); }
  .faq-q svg { width: 14px; height: 14px; stroke: var(--muted); fill: none; stroke-width: 2; transition: transform .3s; flex-shrink: 0; }
  .faq-item.open .faq-q svg { transform: rotate(180deg); stroke: var(--red); }
  .faq-a { max-height: 0; overflow: hidden; transition: max-height .35s ease, padding .35s ease; }
  .faq-item.open .faq-a { max-height: 200px; }
  .faq-a-inner { padding: 0 20px 16px; font-size: 13px; color: var(--muted); line-height: 1.75; border-top: 1px solid var(--border); padding-top: 12px; }

  [data-anim] { opacity: 0; transform: translateY(28px); transition: opacity .65s ease, transform .65s ease; }
  [data-anim].visible { opacity: 1; transform: translateY(0); }
  [data-anim="left"] { transform: translateX(-28px); }
  [data-anim="left"].visible { transform: translateX(0); }
  [data-anim="right"] { transform: translateX(28px); }
  [data-anim="right"].visible { transform: translateX(0); }

  @media (max-width: 900px) {
    .container { padding: 0 24px; }
    .contact-layout { grid-template-columns: 1fr; }
    .info-grid { grid-template-columns: 1fr 1fr; }
    .form-row { grid-template-columns: 1fr; }
  }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="hero">
  <div class="hero-glow"></div>
  <div class="hero-content">
    <div class="hero-eyebrow">Luôn sẵn sàng hỗ trợ bạn</div>
    <h1>Liên <em>Hệ</em></h1>
    <p class="hero-sub">Đội ngũ chuyên gia luôn sẵn sàng — 24 giờ mỗi ngày</p>
  </div>
  <div class="breadcrumb"><a href="{{ url('/') }}">Home</a> &rsaquo; <span>Liên Hệ</span></div>
</section>

{{-- INFO STRIP --}}
<div class="info-strip">
  <div class="container" style="padding:0">
    <div class="info-grid">
      <div class="info-item">
        <div class="info-icon"><svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.36 2 2 0 0 1 3.6 1.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.41a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.69 16z"/></svg></div>
        <div>
          <div class="info-label">Điện thoại</div>
          <div class="info-value">(007) 123 456 7890</div>
          <div class="info-sub">Gọi bất cứ lúc nào</div>
        </div>
      </div>
      <div class="info-item">
        <div class="info-icon"><svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
        <div>
          <div class="info-label">Email</div>
          <div class="info-value">support@website.com</div>
          <div class="info-sub">Phản hồi trong 2 giờ</div>
        </div>
      </div>
      <div class="info-item">
        <div class="info-icon"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
        <div>
          <div class="info-label">Địa chỉ</div>
          <div class="info-value">220E Front St.</div>
          <div class="info-sub">Burlington, NC 27215</div>
        </div>
      </div>
      <div class="info-item">
        <div class="info-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
        <div>
          <div class="info-label">Giờ mở cửa</div>
          <div class="info-value">08:00 – 20:00</div>
          <div class="info-sub">Thứ 2 – Chủ nhật</div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- MAIN CONTACT --}}
<section class="contact-section">
  <div class="container">
    <div class="contact-layout">

      {{-- FORM --}}
      <div data-anim="left">
        <div class="form-wrapper">
          <div class="form-header">
            <div>
              <div class="form-header-title">Gửi Tin Nhắn</div>
              <div class="form-header-sub">Chúng tôi sẽ phản hồi trong vòng 2 giờ làm việc</div>
            </div>
            <div class="form-badge">Miễn phí tư vấn</div>
          </div>
          <div class="form-body">
            <form id="contactForm" action="{{ url('/contact') }}" method="POST">
              @csrf
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label">Họ và tên <span>*</span></label>
                  <input type="text" name="name" class="form-input" placeholder="Nguyễn Văn A" required>
                </div>
                <div class="form-group">
                  <label class="form-label">Số điện thoại <span>*</span></label>
                  <input type="tel" name="phone" class="form-input" placeholder="0901 234 567" required>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" placeholder="email@example.com">
              </div>
              <div class="form-group">
                <label class="form-label">Chủ đề quan tâm</label>
                <select name="subject" class="form-select">
                  <option value="">— Chọn chủ đề —</option>
                  <option value="buy">Mua xe mới</option>
                  <option value="tradein">Đổi xe / Trade-in</option>
                  <option value="finance">Hỗ trợ tài chính & vay mua xe</option>
                  <option value="service">Bảo dưỡng & sửa chữa</option>
                  <option value="insurance">Bảo hiểm xe</option>
                  <option value="testdrive">Đặt lịch lái thử</option>
                  <option value="other">Khác</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Xe bạn quan tâm</label>
                <select name="car_interest" class="form-select">
                  <option value="">— Chọn dòng xe —</option>
                  <option value="sedan">Sedan</option>
                  <option value="suv">SUV / Crossover</option>
                  <option value="coupe">Coupe / Thể thao</option>
                  <option value="luxury">Xe sang cao cấp</option>
                  <option value="electric">Xe điện</option>
                  <option value="unsure">Chưa quyết định</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Nội dung tin nhắn <span>*</span></label>
                <textarea name="message" class="form-textarea" placeholder="Cho chúng tôi biết thêm về nhu cầu của bạn..." required></textarea>
              </div>
              <div class="form-checkbox">
                <input type="checkbox" id="consent" name="consent" required>
                <label for="consent">Tôi đồng ý để Concept Car Dealer lưu trữ và sử dụng thông tin của tôi theo <a href="#">chính sách bảo mật</a>.</label>
              </div>
              <button type="submit" class="btn-submit">
                <svg viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                Gửi Tin Nhắn
              </button>
              @if(session('success'))
              <div class="success-msg show">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                <span>{{ session('success') }}</span>
              </div>
              @endif
            </form>
          </div>
        </div>
      </div>

      {{-- SIDEBAR --}}
      <div class="contact-sidebar" data-anim="right">

        {{-- MAP --}}
        <div class="sidebar-card">
          <div class="sidebar-card-header">
            <div class="sidebar-card-icon"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
            <div class="sidebar-card-title">Vị Trí Showroom</div>
          </div>
          <div class="sidebar-card-body" style="padding:0">
            <div class="map-frame">
              <svg viewBox="0 0 480 200" xmlns="http://www.w3.org/2000/svg">
                <rect width="480" height="200" fill="#242426"/>
                <!-- Grid lines -->
                <line x1="0" y1="50" x2="480" y2="50" stroke="#2c2c2f" stroke-width="1"/>
                <line x1="0" y1="100" x2="480" y2="100" stroke="#2c2c2f" stroke-width="1"/>
                <line x1="0" y1="150" x2="480" y2="150" stroke="#2c2c2f" stroke-width="1"/>
                <line x1="80" y1="0" x2="80" y2="200" stroke="#2c2c2f" stroke-width="1"/>
                <line x1="160" y1="0" x2="160" y2="200" stroke="#2c2c2f" stroke-width="1"/>
                <line x1="240" y1="0" x2="240" y2="200" stroke="#2c2c2f" stroke-width="1"/>
                <line x1="320" y1="0" x2="320" y2="200" stroke="#2c2c2f" stroke-width="1"/>
                <line x1="400" y1="0" x2="400" y2="200" stroke="#2c2c2f" stroke-width="1"/>
                <!-- Roads -->
                <rect x="0" y="92" width="480" height="16" fill="#2a2a2d"/>
                <rect x="232" y="0" width="16" height="200" fill="#2a2a2d"/>
                <line x1="0" y1="100" x2="480" y2="100" stroke="#3a3a3e" stroke-width="1" stroke-dasharray="12,8"/>
                <line x1="240" y1="0" x2="240" y2="200" stroke="#3a3a3e" stroke-width="1" stroke-dasharray="12,8"/>
                <!-- Blocks -->
                <rect x="84" y="20" width="68" height="60" rx="2" fill="#2c2c2f" stroke="#3a3a3e" stroke-width="1"/>
                <rect x="84" y="120" width="68" height="60" rx="2" fill="#2c2c2f" stroke="#3a3a3e" stroke-width="1"/>
                <rect x="256" y="20" width="50" height="40" rx="2" fill="#2c2c2f" stroke="#3a3a3e" stroke-width="1"/>
                <rect x="316" y="20" width="70" height="60" rx="2" fill="#2c2c2f" stroke="#3a3a3e" stroke-width="1"/>
                <rect x="256" y="120" width="130" height="60" rx="2" fill="#2c2c2f" stroke="#3a3a3e" stroke-width="1"/>
                <!-- Showroom highlight -->
                <rect x="164" y="20" width="56" height="60" rx="2" fill="rgba(212,43,43,.15)" stroke="#d42b2b" stroke-width="1.5"/>
                <text x="192" y="55" text-anchor="middle" font-size="9" fill="#d42b2b" font-family="Rajdhani,sans-serif" font-weight="700" letter-spacing="1">SHOWROOM</text>
                <!-- Pin -->
                <circle cx="192" cy="16" r="6" fill="#d42b2b"/>
                <line x1="192" y1="22" x2="192" y2="28" stroke="#d42b2b" stroke-width="2"/>
                <circle cx="192" cy="16" r="2.5" fill="#fff"/>
              </svg>
              <div class="map-overlay">
                <span class="map-address">220E Front St, Burlington NC</span>
                <a href="https://maps.google.com" target="_blank" class="map-link">Xem bản đồ ↗</a>
              </div>
            </div>
            <div style="padding:16px 20px">
              <p style="font-size:13px;color:var(--muted);margin:0">220E Front St. Burlington, NC 27215 · Cách trung tâm 5 phút · Bãi đỗ xe miễn phí</p>
            </div>
          </div>
        </div>

        {{-- HOURS --}}
        <div class="sidebar-card">
          <div class="sidebar-card-header">
            <div class="sidebar-card-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
            <div class="sidebar-card-title">Giờ Mở Cửa</div>
          </div>
          <div class="sidebar-card-body">
            <div class="hours-list">
              <div class="hour-row"><span class="hour-day">Thứ 2 – Thứ 6</span><span class="hour-time">08:00 – 20:00</span></div>
              <div class="hour-row today"><span class="hour-day">Thứ 7 <span class="open-badge">Hôm nay</span></span><span class="hour-time">08:00 – 18:00</span></div>
              <div class="hour-row"><span class="hour-day">Chủ nhật</span><span class="hour-time">09:00 – 17:00</span></div>
              <div class="hour-row" style="margin-top:4px;padding-top:12px">
                <span style="font-size:12px;color:var(--muted);">Hotline hỗ trợ kỹ thuật</span>
                <span class="hour-time">24/7</span>
              </div>
            </div>
          </div>
        </div>

        {{-- SOCIAL --}}
        <div class="sidebar-card">
          <div class="sidebar-card-header">
            <div class="sidebar-card-icon"><svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></div>
            <div class="sidebar-card-title">Mạng Xã Hội</div>
          </div>
          <div class="sidebar-card-body">
            <div class="social-links">
              <a href="#" class="social-link">
                <div class="social-link-icon"><svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></div>
                <div><div class="social-link-name">Facebook</div><div class="social-link-handle">@conceptcardealervn</div></div>
              </a>
              <a href="#" class="social-link">
                <div class="social-link-icon"><svg viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></div>
                <div><div class="social-link-name">Instagram</div><div class="social-link-handle">@conceptcar.vn</div></div>
              </a>
              <a href="#" class="social-link">
                <div class="social-link-icon"><svg viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.54C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg></div>
                <div><div class="social-link-name">YouTube</div><div class="social-link-handle">Concept Car Dealer VN</div></div>
              </a>
            </div>
          </div>
        </div>

        {{-- FAQ QUICK --}}
        <div class="sidebar-card">
          <div class="sidebar-card-header">
            <div class="sidebar-card-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
            <div class="sidebar-card-title">Câu Hỏi Thường Gặp</div>
          </div>
          <div class="sidebar-card-body">
            <div class="faq-quick">
              <div class="faq-item open">
                <div class="faq-q" onclick="toggleFaq(this)">
                  <span class="faq-q-text">Có thể lái thử xe trước khi mua không?</span>
                  <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <div class="faq-a"><div class="faq-a-inner">Có, chúng tôi cung cấp dịch vụ lái thử miễn phí tại showroom hoặc tại địa điểm bạn chọn. Vui lòng đặt lịch trước ít nhất 1 ngày qua form liên hệ hoặc gọi điện trực tiếp.</div></div>
              </div>
              <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">
                  <span class="faq-q-text">Thủ tục vay mua xe mất bao lâu?</span>
                  <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <div class="faq-a"><div class="faq-a-inner">Hồ sơ vay thường được phê duyệt trong vòng 24 giờ làm việc. Chúng tôi hợp tác với 10+ ngân hàng, giúp bạn nhanh chóng nhận được câu trả lời và mức lãi suất tốt nhất.</div></div>
              </div>
              <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">
                  <span class="faq-q-text">Có thể định giá xe cũ online không?</span>
                  <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <div class="faq-a"><div class="faq-a-inner">Bạn có thể điền thông tin xe cũ qua form liên hệ, chúng tôi sẽ gửi định giá sơ bộ trong 2 giờ. Để được định giá chính xác nhất, hãy mang xe đến showroom để kiểm tra trực tiếp.</div></div>
              </div>
              <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">
                  <span class="faq-q-text">Showroom có giao xe tận nhà không?</span>
                  <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <div class="faq-a"><div class="faq-a-inner">Có, chúng tôi giao xe tận nơi trên toàn quốc. Phí giao xe phụ thuộc vào khoảng cách. Nội thành miễn phí giao xe trong vòng bán kính 20km.</div></div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
  // Intersection observer animations
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
  }, { threshold: 0.1 });
  document.querySelectorAll('[data-anim]').forEach(el => observer.observe(el));

  // FAQ toggle
  function toggleFaq(el) {
    const item = el.closest('.faq-item');
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
  }
</script>
@endpush
