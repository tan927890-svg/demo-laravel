@extends('layouts.frontend')

@section('title', 'Quy Trình Bảo Dưỡng Nhanh - AUTO X')

@push('styles')
<style>
  :root {
    --red: #1c69d4; --red-dark: #1555b0;
    --red-light: rgba(28,105,212,0.08); --red-border: rgba(28,105,212,0.25);
    --bg: #f5f0e8; --bg2: #ede8de; --bg3: #e6e0d4; --card: #ffffff;
    --border: #d8d0c0; --border-light: #c8bfaa;
    --white: #ffffff; --text: #4a4438; --muted: #7a7060; --subtle: #a09880;
  }

  .container { max-width: 1240px; margin: 0 auto; padding: 0 48px; }
  .section-label {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: 4px; text-transform: uppercase; color: var(--red);
    margin-bottom: 10px; display: flex; align-items: center; gap: 10px;
  }
  .section-label::before { content: ''; width: 3px; height: 14px; background: var(--red); flex-shrink: 0; }
  .section-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(28px,4vw,48px); font-weight: 800;
    text-transform: uppercase; color: var(--text); letter-spacing: -.5px;
  }
  .divider-line { width: 56px; height: 3px; background: var(--red); margin: 24px 0; }

  /* HERO */
  .hero {
    position: relative; height: 480px;
    display: flex; align-items: flex-start; justify-content: center;
    overflow: hidden; padding-top: 80px;
  }
  .hero-bg {
    position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1530046339160-ce3e530c7d2f?w=1600&q=80') center/cover no-repeat;
    z-index: 0;
  }
  .hero-overlay { position: absolute; inset: 0; z-index: 1; background: linear-gradient(160deg,rgba(28,26,22,0.72) 0%,rgba(28,26,22,0.55) 50%,rgba(28,26,22,0.72) 100%); }
  .hero-content { position: relative; text-align: center; z-index: 3; }
  .hero-eyebrow {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: 5px; text-transform: uppercase; color: var(--red);
    margin-bottom: 18px; display: flex; align-items: center; justify-content: center; gap: 14px;
  }
  .hero-eyebrow::before,.hero-eyebrow::after { content: ''; width: 36px; height: 1px; background: var(--red); opacity: .5; }
  .hero h1 { font-family: 'Barlow Condensed', sans-serif; font-size: clamp(48px,7vw,86px); font-weight: 800; color: #f5f0e8; line-height: .96; text-transform: uppercase; letter-spacing: -1px; }
  .hero h1 em { color: var(--red); font-style: normal; }
  .hero-sub { margin-top: 16px; font-size: 15px; color: rgba(245,240,232,0.65); }
  .breadcrumb {
    position: absolute; bottom: 28px; left: 50%; transform: translateX(-50%);
    display: flex; align-items: center; gap: 10px; font-size: 12px; letter-spacing: 1px;
    color: rgba(245,240,232,0.9); z-index: 4; background: rgba(10,10,10,0.32);
    padding: 8px 14px; border-radius: 18px; box-shadow: 0 8px 20px rgba(0,0,0,0.35); backdrop-filter: blur(6px);
  }
  .breadcrumb a { color: rgba(245,240,232,0.85); text-decoration: none; transition: color .18s; }
  .breadcrumb a:hover { color: var(--red); }
  .breadcrumb span { color: var(--red); font-weight: 700; }

  /* STATS BAR — màu giống trang dịch vụ: nền trắng, số xanh, label xám */
  .stats-bar-outer {
    background: #ffffff;
    border-bottom: 1px solid #e8e8e8;
  }
  .stats-bar-inner {
    display: grid; grid-template-columns: repeat(4,1fr);
    max-width: 1240px; margin: 0 auto; padding: 0 48px;
  }
  .stat-item {
    padding: 36px 24px; text-align: center;
    border-right: 1px solid #e8e8e8;
  }
  .stat-item:last-child { border-right: none; }
  .stat-item strong {
    display: block; font-family: 'Barlow Condensed', sans-serif;
    font-size: 52px; font-weight: 800; color: #1c69d4; line-height: 1;
  }
  .stat-item span {
    font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 600;
    letter-spacing: 1px; text-transform: uppercase;
    color: #888888; margin-top: 6px; display: block;
  }

  /* PROCESS TIMELINE */
  .process-section { background: var(--bg); padding: 96px 0; }
  .process-intro { max-width: 640px; margin-bottom: 72px; }

  .timeline { position: relative; }
  .timeline::before {
    content: ''; position: absolute; left: 40px; top: 0; bottom: 0; width: 2px;
    background: linear-gradient(to bottom, var(--red) 0%, var(--border) 100%);
  }
  .timeline-item { display: grid; grid-template-columns: 80px 1fr; gap: 0; margin-bottom: 0; position: relative; }
  .timeline-item:last-child .timeline-content { border-bottom: none; }

  .timeline-node { display: flex; flex-direction: column; align-items: center; padding-top: 24px; position: relative; z-index: 1; }
  .node-circle {
    width: 48px; height: 48px; background: var(--card); border: 2px solid var(--border);
    display: flex; align-items: center; justify-content: center; position: relative;
    transition: background .3s, border-color .3s;
  }
  .timeline-item:hover .node-circle { background: var(--red); border-color: var(--red); }
  .node-circle svg { width: 20px; height: 20px; fill: none; stroke-width: 1.6; transition: stroke .3s; }
  .timeline-item:hover .node-circle svg { stroke: #fff !important; }
  .node-num {
    position: absolute; top: -8px; right: -8px; width: 20px; height: 20px;
    background: var(--red); color: #fff; font-family: 'Rajdhani', sans-serif;
    font-size: 10px; font-weight: 700; display: flex; align-items: center; justify-content: center;
  }
  .node-time { font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 1px; color: var(--subtle); text-transform: uppercase; margin-top: 8px; white-space: nowrap; }

  .timeline-content { padding: 24px 0 40px 40px; border-bottom: 1px solid var(--border); }
  .tc-header { display: flex; align-items: center; gap: 16px; margin-bottom: 12px; }
  .tc-title { font-family: 'Barlow Condensed', sans-serif; font-size: 22px; font-weight: 800; text-transform: uppercase; color: var(--text); letter-spacing: .5px; }
  .tc-badge { font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 4px 10px; border: 1px solid var(--red-border); color: var(--red); }
  .tc-desc { font-size: 14px; color: var(--muted); line-height: 1.85; margin-bottom: 16px; max-width: 640px; }
  .tc-checklist { display: flex; flex-wrap: wrap; gap: 8px; }
  .tc-check-item {
    display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text);
    padding: 6px 12px;
  }
  .tc-check-item::before { content: '✓'; color: var(--red); font-weight: 700; font-size: 11px; }
  .tc-alert { display: flex; align-items: flex-start; gap: 12px; background: var(--red-light); border: 1px solid var(--red-border); padding: 12px 16px; margin-top: 12px; font-size: 13px; color: var(--text); max-width: 560px; }
  .tc-alert svg { width: 16px; height: 16px; stroke: var(--red); fill: none; stroke-width: 2; flex-shrink: 0; margin-top: 1px; }

  /* Node icon colors per step */
  .step-1 .node-circle svg { stroke: #5b9bd5; }
  .step-2 .node-circle svg { stroke: #e07b4a; }
  .step-3 .node-circle svg { stroke: var(--red); }
  .step-4 .node-circle svg { stroke: #e05555; }
  .step-5 .node-circle svg { stroke: #6db86d; }
  .step-6 .node-circle svg { stroke: #9b7dd4; }
  .step-7 .node-circle svg { stroke: var(--red); }

  /* WARRANTY SECTION */
  .warranty-section { background: #ffffff; padding: 96px 0; }
  .warranty-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 2px; background: var(--border); margin-top: 48px; }
  .warranty-card { background: #ffffff; padding: 40px 32px; position: relative; overflow: hidden; }
  .warranty-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
  .warranty-card:nth-child(1)::before { background: #378ADD; }
  .warranty-card:nth-child(2)::before { background: #D4537E; }
  .warranty-card:nth-child(3)::before { background: #639922; }
  .warranty-icon { width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; }
  .warranty-card:nth-child(1) .warranty-icon { background: #ddeef9; }
  .warranty-card:nth-child(2) .warranty-icon { background: #f7e0ea; }
  .warranty-card:nth-child(3) .warranty-icon { background: #dff0cc; }
  .warranty-stat { font-family: 'Barlow Condensed', sans-serif; font-size: 38px; font-weight: 800; line-height: 1; margin-bottom: 2px; }
  .warranty-card:nth-child(1) .warranty-stat { color: #185FA5; }
  .warranty-card:nth-child(2) .warranty-stat { color: #993556; }
  .warranty-card:nth-child(3) .warranty-stat { color: #3B6D11; }
  .warranty-stat-label { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--subtle); margin-bottom: 14px; display: block; }
  .warranty-title { font-family: 'Barlow Condensed', sans-serif; font-size: 18px; font-weight: 800; text-transform: uppercase; color: #1a1a1a; margin-bottom: 10px; }
  .warranty-desc { font-size: 13px; color: #555; line-height: 1.8; }

  /* CTA */
  .cta-strip { background: var(--text); padding: 60px 0; }
  .cta-strip-inner { display: flex; align-items: center; justify-content: space-between; gap: 32px; flex-wrap: wrap; }
  .cta-strip h2 { font-family: 'Barlow Condensed', sans-serif; font-size: 36px; font-weight: 800; text-transform: uppercase; color: #f5f0e8; line-height: 1.1; }
  .cta-strip h2 em { color: var(--red); font-style: normal; }
  .cta-strip p { color: rgba(245,240,232,0.55); font-size: 14px; margin-top: 6px; }
  .btn-cta-gold {
    display: inline-flex; align-items: center; gap: 10px; flex-shrink: 0;
    background: var(--red); color: #fff;
    font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase; padding: 14px 32px;
    text-decoration: none; transition: background .2s;
  }
  .btn-cta-gold:hover { background: var(--red-dark); }

  [data-anim] { opacity: 0; transform: translateY(28px); transition: opacity .65s ease, transform .65s ease; }
  [data-anim].visible { opacity: 1; transform: translateY(0); }
  [data-anim="left"] { transform: translateX(-28px); }
  [data-anim="left"].visible { transform: translateX(0); }

  @media (max-width: 900px) {
    .container { padding: 0 24px; }
    .stats-bar-inner { grid-template-columns: repeat(2,1fr); padding: 0 24px; }
    .timeline::before { display: none; }
    .timeline-item { grid-template-columns: 1fr; }
    .timeline-node { flex-direction: row; gap: 12px; padding-top: 0; margin-bottom: 12px; }
    .timeline-content { padding-left: 0; }
    .warranty-grid { grid-template-columns: 1fr; }
  }
  .breadcrumb {
  bottom: 16px !important;
}
.breadcrumb a {
  color: rgba(255,255,255,0.85) !important;
}
.breadcrumb a:hover {
  color: #ffffff !important;
}
.hero-content {
  margin-top: 60px !important;
}
.stats-bar-outer {
  border: none !important;
  border-bottom: none !important;
}
.stat-item {
  border-right: none !important;
}
.cta-strip {
  position: relative;
  overflow: hidden;
  background: #0a0a0a !important;
}
.cta-strip::before {
  content: '';
  position: absolute; inset: 0;
  background: url('https://images.unsplash.com/photo-1625047509248-ec889cbff17f?w=1600&q=80') center/cover no-repeat;
  opacity: .25;
}
.cta-strip-inner {
  position: relative;
  z-index: 1;
}
.cta-strip h2,
.cta-strip h2 em {
  color: #ffffff !important;
  -webkit-text-fill-color: #ffffff !important;
}
.cta-strip p {
  color: rgba(255,255,255,0.7) !important;
}
.btn-cta-gold {
  background: #ffffff !important;
  color: var(--red) !important;
  border: none !important;
}
.btn-cta-gold:hover {
  background: #f0f0f0 !important;
  color: var(--red-dark) !important;
}
</style>
@endpush

@section('content')

@include('partials.icons')

{{-- HERO --}}
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <div class="hero-eyebrow">Chuẩn hóa — Minh bạch — Nhanh chóng</div>
    <h1>Quy Trình Bảo <em>Dưỡng</em> Nhanh</h1>
    <p class="hero-sub">Hoàn thành trong 60 phút — Không chờ đợi, không phát sinh</p>
  </div>
  <div class="breadcrumb">
    <a href="{{ url('/') }}">Home</a> &rsaquo;
    <a href="{{ url('/services') }}">Dịch Vụ</a> &rsaquo;
    <span>Quy Trình Bảo Dưỡng</span>
  </div>
</section>

{{-- STATS BAR — nằm ngoài hero, không bị che --}}
<div class="stats-bar-outer">
  <div class="stats-bar-inner">
    <div class="stat-item"><strong>60'</strong><span>Thời gian bảo dưỡng</span></div>
    <div class="stat-item"><strong>12</strong><span>Bay dịch vụ</span></div>
    <div class="stat-item"><strong>100%</strong><span>Phụ tùng chính hãng</span></div>
    <div class="stat-item"><strong>24h</strong><span>Bảo hành sau bảo dưỡng</span></div>
  </div>
</div>

{{-- PROCESS TIMELINE --}}
<section class="process-section">
  <div class="container">
    <div class="process-intro" data-anim>
      <div class="section-label">Từng bước rõ ràng</div>
      <h2 class="section-title">Quy Trình <em style="color:var(--red);font-style:normal">7 Bước</em></h2>
      <div class="divider-line"></div>
      <p style="color:var(--muted);font-size:14px;line-height:1.85">Mỗi xe vào xưởng đều được phục vụ theo quy trình chuẩn hóa, đảm bảo không bỏ sót hạng mục nào và khách hàng luôn được thông báo kịp thời.</p>
    </div>

    <div class="timeline" data-anim>

      <div class="timeline-item step-1">
        <div class="timeline-node">
          <div class="node-circle">
            <div class="node-num">1</div>
            <svg viewBox="0 0 24 24"><path d="M18 20V10"/><path d="M12 20V4"/><path d="M6 20v-6"/></svg>
          </div>
          <div class="node-time">0 – 5'</div>
        </div>
        <div class="timeline-content">
          <div class="tc-header">
            <div class="tc-title">Tiếp nhận & Kiểm tra ngoại quan</div>
            <div class="tc-badge">Tiếp tân</div>
          </div>
          <p class="tc-desc">Nhân viên tiếp nhận xe, xác nhận thông tin lịch hẹn, kiểm tra ngoại thất và ghi nhận tình trạng ban đầu trước khi đưa vào xưởng.</p>
          <div class="tc-checklist">
            <div class="tc-check-item">Xác nhận danh tính & lịch hẹn</div>
            <div class="tc-check-item">Chụp ảnh toàn bộ xe</div>
            <div class="tc-check-item">Lập phiếu tiếp nhận</div>
            <div class="tc-check-item">Ghi số km hiện tại</div>
          </div>
        </div>
      </div>

      <div class="timeline-item step-2">
        <div class="timeline-node">
          <div class="node-circle">
            <div class="node-num">2</div>
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          </div>
          <div class="node-time">5 – 20'</div>
        </div>
        <div class="timeline-content">
          <div class="tc-header">
            <div class="tc-title">Chẩn đoán & Quét mã lỗi OBD</div>
            <div class="tc-badge">Kỹ thuật</div>
          </div>
          <p class="tc-desc">Kỹ thuật viên sử dụng máy chẩn đoán chuyên dụng để đọc toàn bộ mã lỗi từ hệ thống ECU, phát hiện sớm các vấn đề tiềm ẩn.</p>
          <div class="tc-checklist">
            <div class="tc-check-item">Quét mã lỗi OBD-II toàn diện</div>
            <div class="tc-check-item">Kiểm tra hệ thống điện</div>
            <div class="tc-check-item">Đánh giá mức độ ưu tiên</div>
            <div class="tc-check-item">Báo cáo sơ bộ cho khách</div>
          </div>
          <div class="tc-alert">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Nếu phát hiện hạng mục phát sinh, kỹ thuật viên sẽ báo và xin phép khách hàng trước khi tiến hành.
          </div>
        </div>
      </div>

      <div class="timeline-item step-3">
        <div class="timeline-node">
          <div class="node-circle">
            <div class="node-num">3</div>
            <svg viewBox="0 0 24 24"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
          </div>
          <div class="node-time">20 – 35'</div>
        </div>
        <div class="timeline-content">
          <div class="tc-header">
            <div class="tc-title">Thay dầu & Bộ lọc</div>
            <div class="tc-badge">Hạng mục chính</div>
          </div>
          <p class="tc-desc">Xả dầu cũ, thay lọc dầu, đổ dầu động cơ chính hãng theo đúng tiêu chuẩn của nhà sản xuất. Đồng thời kiểm tra và bổ sung các chất lỏng khác.</p>
          <div class="tc-checklist">
            <div class="tc-check-item">Xả & thay dầu động cơ</div>
            <div class="tc-check-item">Thay lọc dầu</div>
            <div class="tc-check-item">Kiểm tra dầu hộp số</div>
            <div class="tc-check-item">Nước làm mát</div>
            <div class="tc-check-item">Dầu phanh</div>
            <div class="tc-check-item">Dầu trợ lực lái</div>
          </div>
        </div>
      </div>

      <div class="timeline-item step-4">
        <div class="timeline-node">
          <div class="node-circle">
            <div class="node-num">4</div>
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
          </div>
          <div class="node-time">35 – 45'</div>
        </div>
        <div class="timeline-content">
          <div class="tc-header">
            <div class="tc-title">Kiểm tra hệ thống phanh & lốp</div>
            <div class="tc-badge">An toàn</div>
          </div>
          <p class="tc-desc">Đánh giá độ mòn má phanh, kiểm tra đĩa phanh, cân bằng áp suất lốp và xoay lốp nếu cần thiết để đảm bảo an toàn vận hành.</p>
          <div class="tc-checklist">
            <div class="tc-check-item">Kiểm tra độ dày má phanh</div>
            <div class="tc-check-item">Đĩa phanh & xi lanh phanh</div>
            <div class="tc-check-item">Áp suất lốp 4 bánh</div>
            <div class="tc-check-item">Độ mòn & tình trạng lốp</div>
            <div class="tc-check-item">Xoay lốp định kỳ</div>
          </div>
        </div>
      </div>

      <div class="timeline-item step-5">
        <div class="timeline-node">
          <div class="node-circle">
            <div class="node-num">5</div>
            <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
          </div>
          <div class="node-time">45 – 55'</div>
        </div>
        <div class="timeline-content">
          <div class="tc-header">
            <div class="tc-title">Kiểm tra tổng thể & vệ sinh</div>
            <div class="tc-badge">Hoàn thiện</div>
          </div>
          <p class="tc-desc">Kiểm tra lại toàn bộ các hạng mục đã thực hiện, vệ sinh khoang động cơ và lau sạch nội thất cơ bản trước khi bàn giao xe.</p>
          <div class="tc-checklist">
            <div class="tc-check-item">Kiểm tra đèn & còi</div>
            <div class="tc-check-item">Hệ thống điều hòa</div>
            <div class="tc-check-item">Gạt mưa & kính</div>
            <div class="tc-check-item">Vệ sinh khoang máy</div>
          </div>
        </div>
      </div>

      <div class="timeline-item step-6">
        <div class="timeline-node">
          <div class="node-circle">
            <div class="node-num">6</div>
            <svg viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <div class="node-time">55 – 58'</div>
        </div>
        <div class="timeline-content">
          <div class="tc-header">
            <div class="tc-title">QC & Kiểm tra lần cuối</div>
            <div class="tc-badge">Chất lượng</div>
          </div>
          <p class="tc-desc">Kỹ thuật viên cấp cao kiểm tra độc lập tất cả hạng mục đã thực hiện, ký xác nhận trên phiếu dịch vụ trước khi bàn giao cho khách hàng.</p>
          <div class="tc-checklist">
            <div class="tc-check-item">Ký xác nhận QC</div>
            <div class="tc-check-item">Chạy thử ngắn</div>
            <div class="tc-check-item">Scan lỗi lần cuối</div>
          </div>
        </div>
      </div>

      <div class="timeline-item step-7">
        <div class="timeline-node">
          <div class="node-circle">
            <div class="node-num">7</div>
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </div>
          <div class="node-time">58 – 60'</div>
        </div>
        <div class="timeline-content">
          <div class="tc-header">
            <div class="tc-title">Bàn giao & Tư vấn tiếp theo</div>
            <div class="tc-badge">Hoàn tất</div>
          </div>
          <p class="tc-desc">Giải thích đầy đủ các hạng mục đã thực hiện, tư vấn lịch bảo dưỡng tiếp theo và nhận thanh toán. Xe được bàn giao sạch sẽ, đúng hẹn.</p>
          <div class="tc-checklist">
            <div class="tc-check-item">Giải thích phiếu dịch vụ</div>
            <div class="tc-check-item">Nhắc lịch bảo dưỡng kế tiếp</div>
            <div class="tc-check-item">Xuất hóa đơn VAT</div>
            <div class="tc-check-item">Dán tem km tiếp theo</div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- WARRANTY --}}
<section class="warranty-section">
  <div class="container">
    <div data-anim>
      <div class="section-label">Cam kết chất lượng</div>
      <h2 class="section-title">Bảo Hành Sau <em style="color:var(--red);font-style:normal">Dịch Vụ</em></h2>
    </div>
    <div class="warranty-grid" data-anim>
      <div class="warranty-card">
        <div class="warranty-icon">
          <svg width="32" height="32" viewBox="0 0 36 36" fill="none">
            <path d="M18 3L5 8.2V17c0 7.8 5.5 14.8 13 16.8C25.5 31.8 31 24.8 31 17V8.2L18 3z" fill="#85B7EB"/>
            <path d="M18 7L9 11.2V17c0 5.5 3.8 10.4 9 12 5.2-1.6 9-6.5 9-12v-5.8L18 7z" fill="#B5D4F4"/>
            <path d="M12.5 18.5l4 4 7.5-8" stroke="#0C447C" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M10 10.5c2-1.2 5-2 8-2" stroke="white" stroke-width="1.4" stroke-linecap="round" opacity="0.5"/>
          </svg>
        </div>
        <div class="warranty-stat">30</div>
        <span class="warranty-stat-label">ngày / 1,000 km</span>
        <div class="warranty-title">Bảo hành nhân công</div>
        <p class="warranty-desc">Tất cả công việc kỹ thuật được bảo hành 30 ngày hoặc 1,000 km, tùy điều kiện nào đến trước.</p>
      </div>
      <div class="warranty-card">
        <div class="warranty-icon">
          <svg width="32" height="32" viewBox="0 0 36 36" fill="none">
            <path d="M5 15h26v16a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V15z" fill="#ED93B1"/>
            <path d="M5 15l4-8h8v8H5z" fill="#D4537E"/>
            <path d="M31 15l-4-8h-8v8h12z" fill="#F4C0D1"/>
            <line x1="18" y1="7" x2="18" y2="15" stroke="#993556" stroke-width="1.5"/>
            <rect x="14" y="15" width="8" height="16" rx="0" fill="#F4C0D1" opacity="0.6"/>
            <line x1="14" y1="15" x2="14" y2="31" stroke="#D4537E" stroke-width="0.8"/>
            <line x1="22" y1="15" x2="22" y2="31" stroke="#D4537E" stroke-width="0.8"/>
            <circle cx="9" cy="24" r="4" fill="white" opacity="0.7"/>
            <text x="9" y="27.5" text-anchor="middle" font-size="7" font-weight="700" fill="#993556">✓</text>
            <path d="M8 17c3-1 7-1.5 10-1.2" stroke="white" stroke-width="1.2" stroke-linecap="round" opacity="0.5"/>
          </svg>
        </div>
        <div class="warranty-stat">6</div>
        <span class="warranty-stat-label">tháng bảo hành</span>
        <div class="warranty-title">Phụ tùng chính hãng</div>
        <p class="warranty-desc">Phụ tùng thay thế có bảo hành theo nhà sản xuất, tối thiểu 6 tháng, kèm hóa đơn đầy đủ.</p>
      </div>
      <div class="warranty-card">
        <div class="warranty-icon">
          <svg width="32" height="32" viewBox="0 0 36 36" fill="none">
            <path d="M7 20C7 12.8 12 7 18 7s11 5.8 11 13" stroke="#97C459" stroke-width="3" stroke-linecap="round"/>
            <path d="M10 20C10 14.5 13.6 10 18 10s8 4.5 8 10" stroke="#C0DD97" stroke-width="2" stroke-linecap="round"/>
            <rect x="4" y="19" width="6" height="9" rx="3" fill="#63991F"/>
            <rect x="5.5" y="20.5" width="3" height="6" rx="1.5" fill="#97C459"/>
            <rect x="26" y="19" width="6" height="9" rx="3" fill="#63991F"/>
            <rect x="27.5" y="20.5" width="3" height="6" rx="1.5" fill="#97C459"/>
            <path d="M30 26 Q33 28 32 31" stroke="#3B6D11" stroke-width="1.8" stroke-linecap="round"/>
            <circle cx="32" cy="31.5" r="1.5" fill="#639922"/>
            <path d="M10 18C10.5 13 14 9.5 18 9.5" stroke="white" stroke-width="1.2" stroke-linecap="round" opacity="0.45"/>
          </svg>
        </div>
        <div class="warranty-stat">15'</div>
        <span class="warranty-stat-label">thời gian phản hồi</span>
        <div class="warranty-title">Hỗ trợ 24/7</div>
        <p class="warranty-desc">Gặp sự cố sau bảo dưỡng, liên hệ ngay hotline 24/7. Kỹ thuật viên phản hồi trong 15 phút.</p>
      </div>
    </div>
  </div>
</section>

{{-- CTA --}}
<section class="cta-strip">
  <div class="container">
    <div class="cta-strip-inner">
      <div>
        <h2>Đặt lịch <em>bảo dưỡng</em><br/>ngay hôm nay</h2>
        <p>Còn nhiều slot trống trong tuần này — chọn giờ phù hợp với bạn.</p>
      </div>
      <a href="{{ url('/services/dat-lich') }}" class="btn-cta-gold">Đặt lịch ngay →</a>
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
</script>
@endpush