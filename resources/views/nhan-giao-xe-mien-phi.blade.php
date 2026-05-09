@extends('layouts.frontend')

@section('title', 'Nhận & Giao Xe Miễn Phí - AUTO X')

@push('styles')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');
  :root {
    --red: #1c69d4; --red-dark: #1555b0;
    --red-light: rgba(28,105,212,0.08); --red-border: rgba(28,105,212,0.25);
    --bg: #f7f7f7; --bg2: #f0f0f0; --bg3: #e8e8e8; --card: #ffffff;
    --border: #e8e8e8; --border-light: #d4d4d4;
    --white: #ffffff; --text: #1a1a1a; --muted: #888888; --subtle: #aaaaaa;
  }

  .container { max-width: 1240px; margin: 0 auto; padding: 0 48px; }
  .section-label {
    font-family: 'Poppins', sans-serif;; font-size: 11px; font-weight: 600;
    letter-spacing: 4px; text-transform: uppercase; color: var(--red);
    margin-bottom: 10px; display: flex; align-items: center; gap: 10px;
  }
  .section-label::before { content: ''; width: 3px; height: 14px; background: var(--red); flex-shrink: 0; }
  .section-title {
    font-family: 'Poppins', sans-serif;
    font-size: clamp(32px, 4vw, 52px);
    font-weight: 700;
    letter-spacing: 0;
    text-transform: uppercase; color: var(--text); letter-spacing: -.5px;
  }
  .divider-line { width: 56px; height: 3px; background: var(--red); margin: 24px 0; }

  /* HERO */
  .hero {
    position: relative; height: 440px;
    display: flex; align-items: center; justify-content: center; overflow: hidden;
  }
  .hero-bg {
    position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=1600&q=80') center/cover no-repeat;
    z-index: 0;
  }
  .hero-overlay { position: absolute; inset: 0; z-index: 1; background: linear-gradient(160deg,rgba(10,10,10,0.75) 0%,rgba(10,10,10,0.55) 50%,rgba(10,10,10,0.75) 100%); }
  .hero-content { position: relative; text-align: center; z-index: 3; }
  .hero-eyebrow {
    font-family: 'Rajdhani', sans-serif; font-size: 18px; font-weight: 600;
    letter-spacing: 5px; text-transform: uppercase; color: var(--red);
    margin-bottom: 18px; display: flex; align-items: center; justify-content: center; gap: 14px;
  }
  .hero-eyebrow::before,.hero-eyebrow::after { content: ''; width: 36px; height: 1px; background: var(--red); opacity: .10; }
  .hero h1 {  font-family: 'Poppins', sans-serif;  font-size: clamp(42px, 6vw, 72px); font-weight: 800; color: #ffffff; line-height: 1.2; text-transform: uppercase; letter-spacing: 0; }
  .hero h1 em { color: var(--red); font-style: normal; }
  .hero-sub { margin-top: 16px; font-size: 15px; color: rgba(255,255,255,0.65); }
  .hero-badge {
    display: inline-flex; align-items: center; gap: 10px; margin-top: 24px;
    background: var(--red); padding: 10px 24px;
    font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #fff;
  }

  /* BREADCRUMB */
  .breadcrumb-bar { background: var(--bg); border-bottom: 1px solid var(--border); padding: 6px 0; }
  .breadcrumb { display: flex; align-items: center; justify-content: center; gap: 10px; font-size: 12px; letter-spacing: 1px; color: var(--muted); }
  .breadcrumb a { color: var(--blue); text-decoration: none; transition: color .18s; }
  .breadcrumb a:hover { color: var(--red); }
  .breadcrumb span { color: var(--blue); font-weight: 700; }

  /* HOW IT WORKS */
  .how-section { background: var(--bg); padding: 96px 0; }
  .how-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; margin-top: 56px; }
  .how-visual { position: relative; }
  .how-map-mock { background: var(--bg3); border: 1px solid var(--border); padding: 0; overflow: hidden; height: 420px; position: relative; }
  .how-map-mock img { width: 100%; height: 100%; object-fit: cover; opacity: .7; }
  .map-overlay { position: absolute; inset: 0; background: linear-gradient(to bottom, transparent 40%, rgba(10,10,10,0.5) 100%); }
  .map-pin { position: absolute; display: flex; flex-direction: column; align-items: center; gap: 4px; cursor: default; }
  .map-pin-dot {
    width: 14px; height: 14px; background: var(--red); border: 2px solid #fff;
    border-radius: 50%; box-shadow: 0 0 0 4px rgba(28,105,212,0.25);
    animation: pulse-pin 2s ease-in-out infinite;
  }
  @keyframes pulse-pin { 0%,100%{box-shadow:0 0 0 4px rgba(28,105,212,0.25)} 50%{box-shadow:0 0 0 10px rgba(28,105,212,0.08)} }
  .map-pin-label { background: rgba(10,10,10,.8); color: #ffffff; font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 4px 10px; white-space: nowrap; backdrop-filter: blur(4px); }
  .map-info-bar { position: absolute; bottom: 0; left: 0; right: 0; background: rgba(10,10,10,0.85); padding: 16px 20px; display: flex; gap: 24px; flex-wrap: wrap; }
  .map-info-item { display: flex; align-items: center; gap: 8px; }
  .map-info-item svg { width: 14px; height: 14px; stroke: var(--red); fill: none; stroke-width: 1.8; }
  .map-info-item span { font-size: 15px; color: rgba(255,255,255,0.75); font-family: 'Rajdhani', sans-serif; font-weight: 800; letter-spacing: 1px; }

  .how-steps { display: flex; flex-direction: column; gap: 0; }
  .how-step { display: flex; gap: 20px; padding: 28px 0; border-bottom: 1px solid var(--border); position: relative; }
  .how-step:last-child { border-bottom: none; }
  .how-step-num { font-family: 'Barlow Condensed', sans-serif; font-size: 64px; font-weight: 800; color: rgba(28,105,212,0.10); line-height: 1; flex-shrink: 0; width: 52px; transition: color .3s; }
  .how-step:hover .how-step-num { color: rgba(28,105,212,0.22); }
  .how-step-body { padding-top: 8px; }
  .how-step-title { font-family: 'Barlow Condensed', sans-serif; font-size: 20px; font-weight: 800; text-transform: uppercase; color: var(--text); letter-spacing: .5px; margin-bottom: 8px; }
  .how-step-desc { font-size: 16px; color: var(--black); line-height: 1.85; }
  .how-step-time { display: inline-flex; align-items: center; gap: 6px; margin-top: 10px; font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--red); }
  .how-step-time svg { width: 16px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; }

 /* BENEFITS */
.benefits-section { background: #274769; padding: 96px 0; }
.benefits-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 1px; background: rgba(255,255,255,.08); margin-top: 56px; border: 1px solid rgba(255,255,255,.08); }
.benefit-card { background: rgba(255,255,255,.03); padding: 40px 28px; transition: all .3s; border-top: 2px solid transparent; }
.benefit-card:hover { background: rgba(22, 7, 7, 0.08); border-top-color: var(--red); }
.benefit-icon {
  width: 52px; height: 52px; border-radius: 12px;
  display: flex; align-items: center; justify-content: center; margin-bottom: 24px;
  background: linear-gradient(135deg, #1c69d4 0%, #0f4299 100%);
  box-shadow: 0 8px 24px rgba(28,105,212,0.3);
}
.benefit-icon svg { width: 22px; height: 22px; fill: #fff; stroke: #fff; stroke-width: 0; }
.benefit-icon.stroke svg { fill: none; stroke: #fff; stroke-width: 2; }
.benefit-title { font-family: 'Barlow Condensed', sans-serif; font-size: 18px; font-weight: 800; text-transform: uppercase; color: #ffffff; letter-spacing: 1px; margin-bottom: 12px; }
.benefit-desc { font-size: 15px; color: rgba(255,255,255,.85); line-height: 1.85; }

  /* COVERAGE AREA */
  .coverage-section { background: var(--bg2); padding: 96px 0; }
  .coverage-grid { display: grid; grid-template-columns: 1.2fr 1fr; gap: 80px; align-items: start; margin-top: 56px; }
  .district-list { display: grid; grid-template-columns: 1fr 1fr; gap: 0; background: var(--border); }
  .district-item { background: var(--card); padding: 14px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; font-size: 15px; color: var(--text); }
  .district-item:nth-child(odd) { border-right: 1px solid var(--border); }
  .district-item .badge { font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 3px 8px; }
  .badge-free { background: var(--red-light); border: 1px solid var(--red-border); color: var(--red); }
  .badge-fee { background: var(--bg2); border: 1px solid var(--border); color: var(--muted); }
  .coverage-info { display: flex; flex-direction: column; gap: 20px; }
  .info-panel { background: var(--card); border: 1px solid var(--border); padding: 28px; }
  .info-panel-title { font-family: 'Barlow Condensed', sans-serif; font-size: 18px; font-weight: 800; text-transform: uppercase; color: var(--text); margin-bottom: 16px; padding-bottom: 10px; border-bottom: 1px solid var(--border); }
  .info-panel ul { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px; }
  .info-panel ul li { display: flex; align-items: flex-start; gap: 10px; font-size: 15px; color: var(--text); }
  .info-panel ul li::before { content: ''; width: 6px; height: 6px; background: var(--red); flex-shrink: 0; margin-top: 6px; }

  /* REQUEST FORM */
  .request-section { background: var(--bg); padding: 96px 0; }
  .request-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; }
  .request-form-wrap { background: var(--card); border: 1px solid var(--border); padding: 48px; }
  .form-title { font-family: 'Barlow Condensed', sans-serif; font-size: 22px; font-weight: 800; text-transform: uppercase; color: var(--text); margin-bottom: 28px; }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
  .form-row.full { grid-template-columns: 1fr; }
  .form-group label { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--muted); display: block; margin-bottom: 7px; }
  .form-group input, .form-group select, .form-group textarea {
  width: 100%;
  padding: 12px 16px;
  border: 1px solid var(--border);
  background: var(--bg);
  font-size: 14px;
  color: var(--text);
  font-family: 'Barlow', sans-serif;
  outline: none;
  border-radius: 10px; /* bo góc */
  transition: all .25s ease;
}
  .form-group select {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23888' stroke-width='1.5' fill='none'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 12px center;
  background-size: 12px;
  padding-right: 36px;
  cursor: pointer;
}
  .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: var(--red); background: var(--white); }
  .form-group textarea { min-height: 100px; resize: vertical; }
  .direction-toggle { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 20px; }
  .dir-btn { padding: 12px; border: 1px solid var(--border); background: var(--bg); cursor: pointer; text-align: center; font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--muted); transition: all .2s; }
  .dir-btn.active { border-color: var(--red); background: var(--red-light); color: var(--red); }
  .btn-request {
    width: 100%; padding: 15px; background: var(--red); color: #fff; border: none; cursor: pointer;
    font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase;
    transition: background .2s; margin-top: 8px;
  }
  .btn-request:hover { background: var(--red-dark); }
  .alert-success { background: #eef6e8; border: 1px solid #6a9a4a; color: #3a6a2a; padding: 14px 18px; margin-bottom: 24px; font-size: 13px; line-height: 1.6; }
  .alert-error { background: #fdf0f0; border: 1px solid #c0544a; color: #8a2a2a; padding: 14px 18px; margin-bottom: 24px; font-size: 13px; }
  .alert-error ul { margin: 0; padding-left: 16px; }
  .request-info { display: flex; flex-direction: column; gap: 24px; }
  .req-info-card { background: var(--card); border: 1px solid var(--border); padding: 32px; }
  .req-info-title { font-family: 'Barlow Condensed', sans-serif; font-size: 17px; font-weight: 800; text-transform: uppercase; color: var(--text); margin-bottom: 16px; }
  .faq-item { border-bottom: 1px solid var(--border); }
  .faq-q { display: flex; justify-content: space-between; align-items: center; padding: 14px 0; cursor: pointer; font-size: 14px; color: var(--text); font-weight: 500; user-select: none; }
  .faq-q svg { width: 14px; height: 14px; stroke: var(--muted); fill: none; stroke-width: 2; transition: transform .25s; flex-shrink: 0; }
  .faq-item.open .faq-q svg { transform: rotate(180deg); }
  .faq-a { max-height: 0; overflow: hidden; transition: max-height .3s ease; font-size: 13px; color: var(--muted); line-height: 1.8; }
  .faq-item.open .faq-a { max-height: 200px; padding-bottom: 14px; }

  /* CTA */
  .cta-strip { background: var(--red); padding: 56px 0; }
  .cta-inner { display: flex; align-items: center; justify-content: space-between; gap: 32px; flex-wrap: wrap; }
  .cta-inner h2 { font-family: 'Barlow Condensed', sans-serif; font-size: 38px; font-weight: 800; text-transform: uppercase; color: #fff; line-height: 1.1; }
  .cta-inner p { color: rgba(255,255,255,.7); font-size: 14px; margin-top: 6px; }
  .btn-white { display: inline-flex; align-items: center; gap: 10px; flex-shrink: 0; background: #fff; color: var(--red); font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; padding: 14px 32px; text-decoration: none; transition: opacity .2s; }
  .btn-white:hover { opacity: .9; }

  [data-anim] { opacity: 0; transform: translateY(28px); transition: opacity .65s ease, transform .65s ease; }
  [data-anim].visible { opacity: 1; transform: translateY(0); }
  [data-anim="left"] { transform: translateX(-28px); }
  [data-anim="left"].visible { transform: translateX(0); }
  [data-anim="right"] { transform: translateX(28px); }
  [data-anim="right"].visible { transform: translateX(0); }

  @media (max-width: 900px) {
    .container { padding: 0 24px; }
    .how-grid, .coverage-grid, .request-grid { grid-template-columns: 1fr; }
    .benefits-grid { grid-template-columns: repeat(2,1fr); }
    .form-row { grid-template-columns: 1fr; }
    .district-list { grid-template-columns: 1fr; }
  }
  .breadcrumb {
  position: absolute; bottom: 28px; left: 50%; transform: translateX(-50%);
  display: flex; align-items: center; gap: 10px; font-size: 12px; letter-spacing: 1px;
  color: #ffffff; z-index: 4; background: rgba(10,10,10,0.32);
  padding: 8px 14px; border-radius: 18px; box-shadow: 0 8px 20px rgba(0,0,0,0.35); backdrop-filter: blur(6px);
}
.breadcrumb a { color: #3d70c7; text-decoration: none; transition: color .18s; }
.breadcrumb a:hover { color: var(--red); }
.breadcrumb span { color: #ffffff; font-weight: 700; }
.breadcrumb, .breadcrumb a, .breadcrumb span { color: #ffffff !important; }
.benefits-section .section-title,
.benefits-section .section-title em { color: #ffffff !important; }
.cta-strip {
  background: rgba(5, 10, 20, 0.75);
  padding: 56px 0;
  position: relative;
  overflow: hidden;
}
.cta-strip::before {
  content: '';
  position: absolute;
  inset: 0;
  background: url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=1600&q=80') center/cover no-repeat;
  opacity: 0.35;
  z-index: 0;
}
.cta-strip .container {
  position: relative;
  z-index: 1;
}
.cta-strip h2, .cta-strip p { color: #ffffff !important; }
</style>
@endpush

@section('content')

@include('partials.icons')

{{-- HERO --}}
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <div class="hero-eyebrow">Tận nhà — Không phụ phí</div>
    <h1>Nhận & Giao Xe<br/><em>Miễn Phí</em></h1>
    <p class="hero-sub">Đặt lịch — chúng tôi đến tận nơi nhận xe — giao trả khi hoàn thành</p>
    <!-- <div class="hero-badge">
      <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" fill="none" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      Miễn phí 100% trong vùng phục vụ TP.HCM
    </div> -->
  </div>
  <div class="breadcrumb">
    <a href="{{ url('/') }}">Home</a> &rsaquo;
    <a href="{{ url('/services') }}">Dịch Vụ</a> &rsaquo;
    <span>Nhận & Giao Xe</span>
  </div>
</section>

{{-- HOW IT WORKS --}}
<section class="how-section">
  <div class="container">
    <div data-anim>
      <div class="section-label">Cách thức hoạt động</div>
      <h2 class="section-title">Đơn Giản Chỉ <em style="color:var(--red);font-style:normal">4 Bước</em></h2>
      <div class="divider-line"></div>
      <p style="color:var(--black);font-size:15px;line-height:1.95;max-width:700px">Chúng tôi đến tận nơi nhận xe của bạn, thực hiện dịch vụ tại xưởng và giao trả xe tận nhà hoặc văn phòng sau khi hoàn thành — hoàn toàn miễn phí.</p>
    </div>
    <div class="how-grid">
      <div class="how-visual" data-anim="left">
        <div class="how-map-mock">
          <img src="https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=800&q=70" alt="Bản đồ TP.HCM">
          <div class="map-overlay"></div>
          <div class="map-pin" style="top:35%;left:48%">
            <div class="map-pin-dot"></div>
            <div class="map-pin-label">Nhà bạn</div>
          </div>
          <div class="map-pin" style="top:58%;left:30%">
            <div class="map-pin-dot" style="background:#444444"></div>
            <div class="map-pin-label">AUTO X Xưởng</div>
          </div>
          <div class="map-info-bar">
            <div class="map-info-item">
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              <span>Đến trong 30–45 phút</span>
            </div>
            <div class="map-info-item">
              <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
              <span>Bán kính 20km từ xưởng</span>
            </div>
          </div>
        </div>
      </div>

      <div class="how-steps" data-anim="right">
        <div class="how-step">
          <div class="how-step-num">1</div>
          <div class="how-step-body">
            <div class="how-step-title">Đặt lịch trực tuyến</div>
            <p class="how-step-desc">Chọn dịch vụ cần thực hiện, nhập địa chỉ nhận xe và khung giờ phù hợp với bạn qua website hoặc hotline.</p>
            <div class="how-step-time"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Mất 3 phút</div>
          </div>
        </div>
        <div class="how-step">
          <div class="how-step-num">2</div>
          <div class="how-step-body">
            <div class="how-step-title">Tài xế đến nhận xe</div>
            <p class="how-step-desc">Tài xế được chứng nhận của chúng tôi sẽ đến đúng giờ, kiểm tra xe cùng bạn, ký biên bản bàn giao và đưa xe về xưởng.</p>
            <div class="how-step-time"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Đến trong 30–45 phút</div>
          </div>
        </div>
        <div class="how-step">
          <div class="how-step-num">3</div>
          <div class="how-step-body">
            <div class="how-step-title">Thực hiện dịch vụ & cập nhật</div>
            <p class="how-step-desc">Xe được bảo dưỡng tại xưởng. Bạn nhận thông báo tiến độ qua SMS và có thể theo dõi trạng thái xe qua link được gửi.</p>
            <div class="how-step-time"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>60–120 phút tùy dịch vụ</div>
          </div>
        </div>
        <div class="how-step">
          <div class="how-step-num">4</div>
          <div class="how-step-body">
            <div class="how-step-title">Giao xe tận nơi</div>
            <p class="how-step-desc">Sau khi hoàn thành, tài xế giao xe trả đến địa chỉ bạn muốn. Thanh toán linh hoạt tại điểm giao hoặc chuyển khoản trước.</p>
            <div class="how-step-time"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Giao trong ngày</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- BENEFITS --}}
<section class="benefits-section">
  <div class="container">
    <div data-anim>
      <div class="section-label" style="color:rgba(28,105,212,0.75)">Lợi ích dịch vụ</div>
    <h2 class="section-title" style="color:#ffffff">Tại Sao Nên Dùng <em style="color:var(--red);font-style:normal;color:#ffffff">Dịch Vụ Này</em></h2>
    </div>
    <div class="benefits-grid" data-anim style="transition-delay:.1s">
      <div class="benefit-card">
        <div class="benefit-icon">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="#fff" stroke="none"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
        </div>
        <div class="benefit-title">Không mất thời gian</div>
        <p class="benefit-desc">Không cần ngồi chờ ở showroom. Bạn làm việc bình thường trong khi xe được phục vụ.</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="#fff" stroke="none"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
        </div>
        <div class="benefit-title">An toàn tuyệt đối</div>
        <p class="benefit-desc">Xe được bảo hiểm trong suốt quá trình vận chuyển. Tài xế được chứng nhận và theo dõi GPS.</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon stroke">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div class="benefit-title">Hoàn toàn miễn phí</div>
        <p class="benefit-desc">Không phụ phí nhận xe, giao xe trong bán kính 20km từ xưởng cho mọi dịch vụ từ 500K trở lên.</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon stroke">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        </div>
        <div class="benefit-title">Theo dõi thời gian thực</div>
        <p class="benefit-desc">Nhận SMS cập nhật trạng thái, theo dõi tài xế trên bản đồ và xem tiến độ dịch vụ trong thời gian thực.</p>
      </div>
    </div>
  </div>
</section>

{{-- COVERAGE --}}
<section class="coverage-section">
  <div class="container">
    <div data-anim>
      <div class="section-label">Phạm vi phục vụ</div>
      <h2 class="section-title">Vùng Phủ Sóng <em style="color:var(--red);font-style:normal">Dịch Vụ</em></h2>
    </div>
    <div class="coverage-grid">
      <div data-anim="left">
        <div class="district-list">
          <div class="district-item"><span>Quận 1</span><span class="badge badge-free">Miễn phí</span></div>
          <div class="district-item"><span>Quận 3</span><span class="badge badge-free">Miễn phí</span></div>
          <div class="district-item"><span>Quận 5</span><span class="badge badge-free">Miễn phí</span></div>
          <div class="district-item"><span>Quận 7</span><span class="badge badge-free">Miễn phí</span></div>
          <div class="district-item"><span>Quận 10</span><span class="badge badge-free">Miễn phí</span></div>
          <div class="district-item"><span>Quận 11</span><span class="badge badge-free">Miễn phí</span></div>
          <div class="district-item"><span>Quận 12</span><span class="badge badge-free">Miễn phí</span></div>
          <div class="district-item"><span>Bình Thạnh</span><span class="badge badge-free">Miễn phí</span></div>
          <div class="district-item"><span>Tân Bình</span><span class="badge badge-free">Miễn phí</span></div>
          <div class="district-item"><span>Gò Vấp</span><span class="badge badge-free">Miễn phí</span></div>
          <div class="district-item"><span>Phú Nhuận</span><span class="badge badge-free">Miễn phí</span></div>
          <div class="district-item"><span>Thủ Đức</span><span class="badge badge-free">Miễn phí</span></div>
          <div class="district-item"><span>Nhà Bè</span><span class="badge badge-fee">+ 50K</span></div>
          <div class="district-item"><span>Bình Chánh</span><span class="badge badge-fee">+ 50K</span></div>
          <div class="district-item"><span>Hóc Môn</span><span class="badge badge-fee">+ 80K</span></div>
          <div class="district-item"><span>Củ Chi</span><span class="badge badge-fee">Liên hệ</span></div>
        </div>
      </div>
      <div class="coverage-info" data-anim="right">
        <div class="info-panel">
          <div class="info-panel-title">Điều kiện miễn phí</div>
          <ul>
            <li>Đơn dịch vụ từ 500,000 VNĐ trở lên</li>
            <li>Trong bán kính 20km từ xưởng</li>
            <li>Đặt lịch trước ít nhất 4 giờ</li>
            <li>Xe không bị hỏng máy, cần xe chuyên dụng</li>
          </ul>
        </div>
        <div class="info-panel">
          <div class="info-panel-title">Thời gian phục vụ</div>
          <ul>
            <li>Nhận xe: 7:30 – 17:00 hàng ngày</li>
            <li>Giao xe: 10:00 – 19:00 hàng ngày</li>
            <li>Thứ 7 & Chủ nhật: 8:00 – 17:00</li>
            <li>Ngày lễ: vui lòng liên hệ trước</li>
          </ul>
        </div>
        <div class="info-panel" style="background:var(--red-light);border-color:var(--red-border)">
          <div class="info-panel-title">Đội xe chuyên dụng</div>
          <ul>
            <li>10 tài xế chuyên nghiệp, được chứng nhận</li>
            <li>Xe chuyên dụng đảm bảo an toàn</li>
            <li>Camera hành trình & GPS theo dõi 24/7</li>
            <li>Bảo hiểm trách nhiệm dân sự đầy đủ</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- REQUEST FORM --}}
<section class="request-section">
  <div class="container">
    <div data-anim style="margin-bottom:48px">
      <div class="section-label">Đặt dịch vụ ngay</div>
      <h2 class="section-title">Yêu Cầu <em style="color:var(--red);font-style:normal">Nhận / Giao</em> Xe</h2>
    </div>
    <div class="request-grid">
      <div class="request-form-wrap" data-anim="left">
        <div class="form-title">Thông tin yêu cầu</div>

        @if(session('success'))
          <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
          <div class="alert-error">
            <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('pickup-delivery.send') }}" method="POST">
          @csrf
          <input type="hidden" name="loai_dich_vu" id="loai_dich_vu" value="Nhận xe từ bạn">

          <div style="margin-bottom:20px">
            <div class="form-group" style="margin-bottom:10px"><label>Loại dịch vụ *</label></div>
            <div class="direction-toggle">
              <button type="button" class="dir-btn active" onclick="toggleDir(this,'Nhận xe từ bạn')">← Nhận xe từ bạn</button>
              <button type="button" class="dir-btn" onclick="toggleDir(this,'Giao xe đến bạn')">→ Giao xe đến bạn</button>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group"><label>Họ và tên *</label><input type="text" name="ho_ten" placeholder="Nguyễn Văn A" value="{{ old('ho_ten') }}"></div>
            <div class="form-group"><label>Số điện thoại *</label><input type="tel" name="dien_thoai" placeholder="0909 123 456" value="{{ old('dien_thoai') }}"></div>
          </div>
          <div class="form-row full">
            <div class="form-group"><label>Địa chỉ nhận / giao xe *</label><input type="text" name="dia_chi" placeholder="Số nhà, tên đường, Quận, TP.HCM" value="{{ old('dia_chi') }}"></div>
          </div>
          <div class="form-row">
            <div class="form-group"><label>Ngày *</label><input type="date" name="ngay" id="req-date" value="{{ old('ngay') }}"></div>
            <div class="form-group"><label>Khung giờ *</label>
              <select name="khung_gio">
                <option>7:30 – 9:00</option><option>9:00 – 11:00</option>
                <option>13:30 – 15:00</option><option>15:00 – 17:00</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group"><label>Hãng xe</label><input type="text" name="hang_xe" placeholder="Toyota, Honda, ..." value="{{ old('hang_xe') }}"></div>
            <div class="form-group"><label>Biển số xe</label><input type="text" name="bien_so" placeholder="51A-123.45" value="{{ old('bien_so') }}"></div>
          </div>
          <div class="form-row full">
            <div class="form-group"><label>Dịch vụ cần thực hiện *</label>
              <select name="dich_vu">
                <option>Bảo dưỡng định kỳ</option><option>Sửa chữa / Khắc phục sự cố</option>
                <option>Thay lốp & cân bằng</option><option>Kiểm tra tổng quát</option>
                <option>Khác (ghi chú bên dưới)</option>
              </select>
            </div>
          </div>
          <div class="form-row full">
            <div class="form-group"><label>Ghi chú thêm</label><textarea name="ghi_chu" placeholder="Mô tả triệu chứng, yêu cầu đặc biệt...">{{ old('ghi_chu') }}</textarea></div>
          </div>
          <button type="submit" class="btn-request">Gửi yêu cầu ngay →</button>
        </form>
      </div>

      <div class="request-info" data-anim="right">
        <div class="req-info-card">
          <div class="req-info-title">Câu hỏi thường gặp</div>
          <div class="faq-item">
            <div class="faq-q" onclick="toggleFaq(this)">Dịch vụ này có thực sự miễn phí?<svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg></div>
            <div class="faq-a">Hoàn toàn miễn phí cho đơn dịch vụ từ 500K trong bán kính 20km. Không có phí ẩn hay phụ phí phát sinh liên quan đến vận chuyển.</div>
          </div>
          <div class="faq-item">
            <div class="faq-q" onclick="toggleFaq(this)">Xe của tôi có an toàn không?<svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg></div>
            <div class="faq-a">Tất cả xe được bảo hiểm trong quá trình vận chuyển. Tài xế được chứng nhận, theo dõi GPS và camera hành trình hoạt động liên tục.</div>
          </div>
          <div class="faq-item">
            <div class="faq-q" onclick="toggleFaq(this)">Tôi có thể theo dõi xe không?<svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg></div>
            <div class="faq-a">Có. Sau khi tài xế nhận xe, bạn sẽ nhận link theo dõi vị trí thời gian thực qua SMS. Cập nhật tiến độ dịch vụ cũng được gửi tự động.</div>
          </div>
          <div class="faq-item">
            <div class="faq-q" onclick="toggleFaq(this)">Nếu cần hủy hoặc đổi lịch?<svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg></div>
            <div class="faq-a">Liên hệ hotline trước ít nhất 2 giờ để hủy hoặc đổi lịch mà không phát sinh chi phí. Hủy sát giờ có thể tính phí điều phối nhỏ.</div>
          </div>
          <div class="faq-item">
            <div class="faq-q" onclick="toggleFaq(this)">Thanh toán khi nào và bằng cách nào?<svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg></div>
            <div class="faq-a">Thanh toán khi nhận xe trả: tiền mặt, chuyển khoản, thẻ ngân hàng hoặc ví điện tử. Bạn cũng có thể thanh toán trước qua app để tiện hơn.</div>
          </div>
        </div>

        <div class="req-info-card" style="background:var(--bg2)">
          <div class="req-info-title">Liên hệ khẩn cấp</div>
          <p style="font-size:13px;color:var(--muted);margin-bottom:16px">Cần hỗ trợ ngay hoặc xe gặp sự cố trên đường?</p>
          <a href="tel:0909123456" style="font-family:'Barlow Condensed',sans-serif;font-size:32px;font-weight:800;color:var(--red);display:block;margin-bottom:4px">0909 123 456</a>
          <span style="font-family:'Rajdhani',sans-serif;font-size:11px;font-weight:600;letter-spacing:2px;text-transform:uppercase;color:var(--muted)">Hotline 24/7</span>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- CTA --}}
<section class="cta-strip">
  <div class="container">
    <div class="cta-inner">
      <div>
        <h2>Đặt lịch ngay — nhận xe ngay hôm nay</h2>
        <p>Còn nhiều slot trống hôm nay. Đặt lịch trực tuyến nhanh trong 3 phút.</p>
      </div>
      <a href="{{ url('/services/dat-lich') }}" class="btn-white">Đặt lịch ngay →</a>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
  const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
  }, { threshold: 0.12 });
  document.querySelectorAll('[data-anim]').forEach(el => observer.observe(el));

  const dateInput = document.getElementById('req-date');
  if (dateInput) { const t = new Date(); t.setDate(t.getDate()+1); dateInput.min = t.toISOString().split('T')[0]; }

  function toggleDir(btn, value) {
    document.querySelectorAll('.dir-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('loai_dich_vu').value = value;
  }

  function toggleFaq(el) {
    const item = el.closest('.faq-item');
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
  }
</script>
@endpush