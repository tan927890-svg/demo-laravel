@extends('layouts.frontend')

@section('title', 'Liên Hệ - AUTO X')

@push('styles')
<style>
  :root {
    --gold: #b8973a;
    --gold-dark: #8a6d1e;
    --gold-light: rgba(184,151,58,0.10);
    --gold-border: rgba(184,151,58,0.28);
    --bg:  #f5f0e8;
    --bg2: #ede8de;
    --bg3: #e6e0d4;
    --card: #ffffff;
    --border: #d8d0c0;
    --dark: #1c1a16;
    --text: #4a4438;
    --muted: #7a7060;
    --subtle: #a09880;
  }

  .container { max-width: 1240px; margin: 0 auto; padding: 0 48px; }

  .section-label {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: 4px; text-transform: uppercase; color: var(--gold);
    margin-bottom: 10px; display: flex; align-items: center; gap: 10px;
  }
  .section-label::before { content: ''; width: 3px; height: 14px; background: var(--gold); flex-shrink: 0; }

  /* ─── HERO ─── */
  .hero {
    position: relative; height: 380px;
    display: flex; align-items: center; justify-content: center; overflow: hidden;
  }
  .hero-bg {
    position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1486325212027-8081e485255e?w=1600&q=80') center/cover no-repeat;
  }
  .hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(160deg, rgba(28,26,22,0.88) 0%, rgba(28,26,22,0.72) 50%, rgba(28,26,22,0.84) 100%);
  }
  .hero-content { position: relative; text-align: center; z-index: 2; }
  .hero-eyebrow {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: 5px; text-transform: uppercase; color: var(--gold);
    margin-bottom: 14px; display: flex; align-items: center; justify-content: center; gap: 14px;
  }
  .hero-eyebrow::before,.hero-eyebrow::after { content:''; width:30px; height:1px; background:var(--gold); opacity:.7; }
  .hero h1 {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(52px,7vw,88px); font-weight: 800;
    color: #f5f0e8; line-height: .92; text-transform: uppercase; letter-spacing: -1px;
  }
  .hero h1 em { color: var(--gold); font-style: normal; }
  .hero-sub { margin-top: 16px; font-size: 14px; color: rgba(245,240,232,0.6); letter-spacing: .5px; }
  .breadcrumb {
    position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);
    display: flex; align-items: center; gap: 10px; z-index: 2;
    font-size: 12px; letter-spacing: 1px; color: rgba(245,240,232,0.4); white-space: nowrap;
  }
  .breadcrumb a { color: rgba(245,240,232,0.4); text-decoration: none; transition: color .2s; }
  .breadcrumb a:hover { color: var(--gold); }
  .breadcrumb span { color: var(--gold); }

  /* ─── INFO STRIP ─── */
  .info-strip { background: var(--gold); }
  .info-grid { display: grid; grid-template-columns: repeat(4,1fr); border-left: 1px solid rgba(255,255,255,.2); }
  .info-item {
    padding: 32px 24px; border-right: 1px solid rgba(255,255,255,.2);
    display: flex; align-items: flex-start; gap: 14px; transition: background .2s;
  }
  .info-item:hover { background: rgba(0,0,0,.08); }
  .info-icon {
    width: 40px; height: 40px; background: rgba(255,255,255,.15);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    border-radius: 10px;
  }
  .info-icon svg { width: 18px; height: 18px; stroke: #fff; fill: none; stroke-width: 1.5; }
  .info-label {
    font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; color: rgba(255,255,255,.65); margin-bottom: 4px;
  }
  .info-value { font-family: 'Barlow Condensed', sans-serif; font-size: 18px; font-weight: 700; color: #fff; line-height: 1.2; }
  .info-sub { font-size: 12px; color: rgba(255,255,255,.55); margin-top: 2px; }

  /* ─── MAIN SECTION ─── */
  .contact-section { background: var(--bg); padding: 72px 0 96px; }
  .contact-layout { display: grid; grid-template-columns: 1.1fr 1fr; gap: 48px; align-items: start; }

  /* ─── FORM ─── */
  .form-wrapper { background: var(--card); border: 1px solid var(--border); border-radius: 4px; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
  .form-header {
    padding: 24px 32px; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    background: var(--bg2); border-radius: 4px 4px 0 0;
  }
  .form-header-title {
    font-family: 'Barlow Condensed', sans-serif; font-size: 22px; font-weight: 800;
    text-transform: uppercase; color: var(--dark);
  }
  .form-header-sub { font-size: 12px; color: var(--muted); margin-top: 3px; }
  .form-badge {
    background: var(--gold); color: #fff;
    font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase; padding: 6px 14px; white-space: nowrap;
    border-radius: 4px;
  }
  .form-body { padding: 32px; }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }
  .form-group { margin-bottom: 14px; }
  .form-label {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase; color: var(--muted);
    margin-bottom: 7px; display: block;
  }
  .form-label span { color: var(--gold); }
  .form-input, .form-select, .form-textarea {
    width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--dark);
    font-family: 'Rajdhani', sans-serif; font-size: 14px; font-weight: 500;
    padding: 12px 14px; outline: none; transition: border-color .2s, background .2s;
    box-sizing: border-box; appearance: none; -webkit-appearance: none;
    border-radius: 6px;
  }
  .form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: var(--gold); background: #fff;
  }
  .form-input::placeholder, .form-textarea::placeholder { color: var(--subtle); }
  .form-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23a09880' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 14px center; padding-right: 38px; cursor: pointer;
    background-color: var(--bg);
  }
  .form-select option { background: #fff; color: var(--dark); }
  .form-textarea { resize: vertical; min-height: 120px; }
  .form-checkbox { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 22px; }
  .form-checkbox input[type="checkbox"] { width: 16px; height: 16px; min-width: 16px; accent-color: var(--gold); margin-top: 2px; cursor: pointer; }
  .form-checkbox label { font-size: 12px; color: var(--muted); line-height: 1.6; cursor: pointer; }
  .form-checkbox label a { color: var(--gold); text-decoration: none; }
  .btn-submit {
    width: 100%; background: var(--gold); color: #fff; border: none; cursor: pointer;
    font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700;
    letter-spacing: 4px; text-transform: uppercase; padding: 15px;
    display: flex; align-items: center; justify-content: center; gap: 10px;
    transition: background .2s, transform .15s;
    border-radius: 6px;
  }
  .btn-submit:hover { background: var(--gold-dark); transform: translateY(-1px); }
  .btn-submit svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; }

  .success-msg {
    display: none; background: rgba(40,120,40,.08); border: 1px solid rgba(40,160,40,.25);
    padding: 14px 18px; margin-top: 14px; border-radius: 6px;
  }
  .success-msg.show { display: flex; align-items: center; gap: 10px; }
  .success-msg svg { width: 18px; height: 18px; stroke: #4caf50; fill: none; stroke-width: 2; flex-shrink: 0; }
  .success-msg span { font-size: 13px; color: #3a8a3a; }

  /* ─── SIDEBAR ─── */
  .contact-sidebar { display: flex; flex-direction: column; gap: 2px; }

  .sidebar-card { background: var(--card); border: 1px solid var(--border); overflow: hidden; border-radius: 4px; box-shadow: 0 1px 4px rgba(0,0,0,.04); }
  .sidebar-card-header {
    padding: 16px 22px; background: var(--bg2); border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 12px;
  }
  .sidebar-card-icon {
    width: 34px; height: 34px; background: var(--gold-light);
    border: 1px solid var(--gold-border); display: flex; align-items: center; justify-content: center;
    border-radius: 8px;
  }
  .sidebar-card-icon svg { width: 15px; height: 15px; stroke: var(--gold); fill: none; stroke-width: 1.5; }
  .sidebar-card-title {
    font-family: 'Barlow Condensed', sans-serif; font-size: 15px; font-weight: 800;
    text-transform: uppercase; color: var(--dark); letter-spacing: .5px;
  }
  .sidebar-card-body { padding: 20px 22px; }

  /* MAP */
  .map-frame {
    width: 100%; height: 240px; position: relative; overflow: hidden;
    background: var(--bg3);
  }
  .map-frame iframe {
    width: 100%; height: 100%; border: none; display: block;
    filter: sepia(20%) saturate(90%) brightness(98%);
  }
  .map-footer {
    padding: 14px 20px; background: var(--bg2); border-top: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
  }
  .map-address { font-size: 12px; color: var(--muted); }
  .map-link {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase; color: var(--gold);
    text-decoration: none; transition: color .2s;
  }
  .map-link:hover { color: var(--gold-dark); }

  /* HOURS */
  .hours-list { display: flex; flex-direction: column; }
  .hour-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 0; border-bottom: 1px solid var(--border); font-size: 13px;
  }
  .hour-row:last-child { border-bottom: none; }
  .hour-day { color: var(--muted); }
  .hour-time { font-family: 'Rajdhani', sans-serif; font-weight: 700; color: var(--dark); letter-spacing: .5px; }
  .hour-row.today .hour-day { color: var(--gold); }
  .hour-row.today .hour-time { color: var(--gold); }
  .open-badge {
    display: inline-block; background: var(--gold-light); border: 1px solid var(--gold-border);
    font-family: 'Rajdhani', sans-serif; font-size: 9px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase; color: var(--gold);
    padding: 2px 7px; margin-left: 7px; border-radius: 4px;
  }

  /* ─── SOCIAL (màu thương hiệu + bo góc + hiệu ứng) ─── */
  .social-links { display: flex; flex-direction: column; }
  .social-link {
    display: flex; align-items: center; gap: 14px; padding: 11px 0;
    border-bottom: 1px solid var(--border); text-decoration: none;
    transition: gap .22s ease;
  }
  .social-link:last-child { border-bottom: none; }
  .social-link:hover { gap: 19px; }

  .social-link-icon {
    width: 38px; height: 38px; flex-shrink: 0;
    border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    transition: transform .25s cubic-bezier(.34,1.56,.64,1), box-shadow .25s ease;
  }
  .social-link:hover .social-link-icon {
    transform: translateY(-3px) scale(1.06);
    box-shadow: 0 8px 20px rgba(0,0,0,.18);
  }
  /* Facebook */
  .social-link.fb .social-link-icon { background: #1877F2; }
  /* Instagram */
  .social-link.ig .social-link-icon { background: linear-gradient(135deg, #f58529 0%, #dd2a7b 50%, #8134af 100%); }
  /* YouTube */
  .social-link.yt .social-link-icon { background: #FF0000; }

  .social-link-icon svg { width: 15px; height: 15px; stroke: #fff; fill: none; stroke-width: 1.8; }

  .social-link-name {
    font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700;
    letter-spacing: .5px; text-transform: uppercase; color: var(--text); transition: color .2s;
  }
  .social-link:hover .social-link-name { color: var(--dark); }
  .social-link-handle { font-size: 12px; color: var(--subtle); }

  .social-followers {
    margin-left: auto;
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
    letter-spacing: 1px; color: var(--subtle);
    opacity: 0; transform: translateX(8px);
    transition: opacity .22s ease, transform .22s ease;
  }
  .social-link:hover .social-followers { opacity: 1; transform: translateX(0); }

  /* FAQ */
  .faq-quick { display: flex; flex-direction: column; gap: 4px; }
  .faq-item { background: var(--bg2); border: 1px solid var(--border); overflow: hidden; border-radius: 6px; }
  .faq-q {
    padding: 14px 18px; display: flex; align-items: center; justify-content: space-between;
    cursor: pointer;
  }
  .faq-q-text {
    font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700;
    letter-spacing: .3px; color: var(--dark);
  }
  .faq-q svg { width: 14px; height: 14px; stroke: var(--muted); fill: none; stroke-width: 2; transition: transform .3s; flex-shrink: 0; }
  .faq-item.open .faq-q svg { transform: rotate(180deg); stroke: var(--gold); }
  .faq-a { max-height: 0; overflow: hidden; transition: max-height .35s ease; }
  .faq-item.open .faq-a { max-height: 200px; }
  .faq-a-inner {
    padding: 12px 18px 16px; font-size: 13px; color: var(--muted); line-height: 1.75;
    border-top: 1px solid var(--border);
  }

  /* ─── ANIMATIONS ─── */
  [data-anim] { opacity: 0; transform: translateY(24px); transition: opacity .65s ease, transform .65s ease; }
  [data-anim].visible { opacity: 1; transform: translateY(0); }
  [data-anim="left"] { transform: translateX(-24px); }
  [data-anim="left"].visible { transform: translateX(0); }
  [data-anim="right"] { transform: translateX(24px); }
  [data-anim="right"].visible { transform: translateX(0); }

  /* ─── RESPONSIVE ─── */
  @media (max-width: 1000px) {
    .contact-layout { grid-template-columns: 1fr; }
    .info-grid { grid-template-columns: 1fr 1fr; }
    .form-row { grid-template-columns: 1fr; }
  }
  @media (max-width: 600px) {
    .container { padding: 0 16px; }
    .info-grid { grid-template-columns: 1fr; }
    .form-body { padding: 20px; }
  }
</style>
@endpush

@section('content')

{{-- ─── HERO ─── --}}
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <div class="hero-eyebrow">Luôn sẵn sàng hỗ trợ bạn</div>
    <h1>Liên <em>Hệ</em></h1>
    <p class="hero-sub">Đội ngũ chuyên gia luôn sẵn sàng — 7 ngày mỗi tuần</p>
  </div>
  <div class="breadcrumb">
    <a href="{{ url('/') }}">Home</a> &rsaquo;
    <span>Liên Hệ</span>
  </div>
</section>

{{-- ─── INFO STRIP ─── --}}
<div class="info-strip">
  <div class="container" style="padding:0">
    <div class="info-grid">
      <div class="info-item">
        <div class="info-icon">
          <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.36 2 2 0 0 1 3.6 1.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.41a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.69 16z"/></svg>
        </div>
        <div>
          <div class="info-label">Điện thoại</div>
          <div class="info-value">(007) 123 456 7890</div>
          <div class="info-sub">Gọi bất cứ lúc nào</div>
        </div>
      </div>
      <div class="info-item">
        <div class="info-icon">
          <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </div>
        <div>
          <div class="info-label">Email</div>
          <div class="info-value">support@website.com</div>
          <div class="info-sub">Phản hồi trong 2 giờ</div>
        </div>
      </div>
      <div class="info-item">
        <div class="info-icon">
          <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
        <div>
          <div class="info-label">Địa chỉ</div>
          <div class="info-value">Hẻm 2276/23</div>
          <div class="info-sub">Trung Mỹ Tây, TP.HCM</div>
        </div>
      </div>
      <div class="info-item">
        <div class="info-icon">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div>
          <div class="info-label">Giờ mở cửa</div>
          <div class="info-value">08:00 – 20:00</div>
          <div class="info-sub">Thứ 2 – Chủ nhật</div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ─── MAIN CONTACT ─── --}}
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
                <div class="form-group" style="margin-bottom:0">
                  <label class="form-label">Họ và tên <span>*</span></label>
                  <input type="text" name="name" class="form-input" placeholder="Nguyễn Văn A" required>
                </div>
                <div class="form-group" style="margin-bottom:0">
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
                <label for="consent">Tôi đồng ý để AUTO X lưu trữ và sử dụng thông tin của tôi theo <a href="#">chính sách bảo mật</a>.</label>
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
            <div class="sidebar-card-icon">
              <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <div class="sidebar-card-title">Vị Trí Showroom</div>
          </div>
          <div style="padding:0">
            <div class="map-frame">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.0!2d106.6216313!3d10.8506588!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752a267da9b68b%3A0xc9738dba08edcf3b!2zSOG6uzzigJkyMjc2LzIzLCBUcnVuZyBNeSBU4bqleSwgSMaw4bubbmcgMTIsIEjDoCBO4buZaSA3MDAwMCwgVGjDoG5oIHBo4buRIEjhu5MgQ2jDrSBNaW5o!5e0!3m2!1svi!2svn!4v1700000000000"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
              </iframe>
            </div>
            <div class="map-footer">
              <span class="map-address">Hẻm 2276/23, Trung Mỹ Tây, TP.HCM</span>
              <a href="https://maps.app.goo.gl/PEbxHZaW56esFzwK7" target="_blank" class="map-link">Chỉ đường ↗</a>
            </div>
          </div>
        </div>

        {{-- HOURS --}}
        <div class="sidebar-card">
          <div class="sidebar-card-header">
            <div class="sidebar-card-icon">
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="sidebar-card-title">Giờ Mở Cửa</div>
          </div>
          <div class="sidebar-card-body">
            <div class="hours-list">
              <div class="hour-row">
                <span class="hour-day">Thứ 2 – Thứ 6</span>
                <span class="hour-time">08:00 – 20:00</span>
              </div>
              <div class="hour-row">
                <span class="hour-day">Thứ 7 <span class="open-badge">Hôm nay</span></span>
                <span class="hour-time">08:00 – 18:00</span>
              </div>
              <div class="hour-row">
                <span class="hour-day">Chủ nhật</span>
                <span class="hour-time">09:00 – 17:00</span>
              </div>
              <div class="hour-row">
                <span class="hour-day" style="color:var(--subtle);font-size:12px">Hotline kỹ thuật</span>
                <span class="hour-time">24/7</span>
              </div>
            </div>
          </div>
        </div>

        {{-- SOCIAL --}}
        <div class="sidebar-card">
          <div class="sidebar-card-header">
            <div class="sidebar-card-icon">
              <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
            </div>
            <div class="sidebar-card-title">Mạng Xã Hội</div>
          </div>
          <div class="sidebar-card-body">
            <div class="social-links">

              <a href="#" class="social-link fb">
                <div class="social-link-icon">
                  <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                </div>
                <div>
                  <div class="social-link-name">Facebook</div>
                  <div class="social-link-handle">@conceptcardealervn</div>
                </div>
                <span class="social-followers">12.4K</span>
              </a>

              <a href="#" class="social-link ig">
                <div class="social-link-icon">
                  <svg viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                </div>
                <div>
                  <div class="social-link-name">Instagram</div>
                  <div class="social-link-handle">@conceptcar.vn</div>
                </div>
                <span class="social-followers">8.1K</span>
              </a>

              <a href="#" class="social-link yt">
                <div class="social-link-icon">
                  <svg viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.54C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg>
                </div>
                <div>
                  <div class="social-link-name">YouTube</div>
                  <div class="social-link-handle">AUTO X VN</div>
                </div>
                <span class="social-followers">3.2K</span>
              </a>

            </div>
          </div>
        </div>

        {{-- FAQ --}}
        <div class="sidebar-card">
          <div class="sidebar-card-header">
            <div class="sidebar-card-icon">
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <div class="sidebar-card-title">Câu Hỏi Thường Gặp</div>
          </div>
          <div class="sidebar-card-body">
            <div class="faq-quick">
              <div class="faq-item open">
                <div class="faq-q" onclick="toggleFaq(this)">
                  <span class="faq-q-text">Có thể lái thử xe trước khi mua không?</span>
                  <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <div class="faq-a"><div class="faq-a-inner">Có, chúng tôi cung cấp dịch vụ lái thử miễn phí tại showroom hoặc tại địa điểm bạn chọn. Vui lòng đặt lịch trước ít nhất 1 ngày qua form hoặc gọi trực tiếp.</div></div>
              </div>
              <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">
                  <span class="faq-q-text">Thủ tục vay mua xe mất bao lâu?</span>
                  <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <div class="faq-a"><div class="faq-a-inner">Hồ sơ vay thường được phê duyệt trong 24 giờ làm việc. Chúng tôi hợp tác với 10+ ngân hàng để bạn có lãi suất tốt nhất.</div></div>
              </div>
              <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">
                  <span class="faq-q-text">Có thể định giá xe cũ online không?</span>
                  <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <div class="faq-a"><div class="faq-a-inner">Bạn có thể điền thông tin xe cũ qua form, chúng tôi sẽ gửi định giá sơ bộ trong 2 giờ. Để chính xác hơn, hãy mang xe đến showroom kiểm tra trực tiếp.</div></div>
              </div>
              <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">
                  <span class="faq-q-text">Showroom có giao xe tận nhà không?</span>
                  <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <div class="faq-a"><div class="faq-a-inner">Có, chúng tôi giao xe tận nơi toàn quốc. Nội thành miễn phí trong bán kính 20km từ showroom.</div></div>
              </div>
            </div>
          </div>
        </div>

      </div>{{-- END SIDEBAR --}}
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
  // Scroll reveal
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

  // Auto-detect today for hours highlight
  (function() {
    const day = new Date().getDay(); // 0=Sun, 6=Sat
    const rows = document.querySelectorAll('.hour-row');
    rows.forEach(r => r.classList.remove('today'));
    if (day === 6) {
      if (rows[1]) rows[1].classList.add('today');
    } else if (day === 0) {
      if (rows[2]) rows[2].classList.add('today');
    } else {
      if (rows[0]) rows[0].classList.add('today');
    }
    const badge = document.querySelector('.open-badge');
    if (badge) badge.textContent = 'Hôm nay';
  })();
</script>
@endpush