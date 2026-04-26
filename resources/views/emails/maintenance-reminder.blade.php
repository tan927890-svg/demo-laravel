<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng ký nhắc lịch bảo dưỡng</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f0e8; color: #4a4438; }
    .wrapper { max-width: 600px; margin: 0 auto; background: #ffffff; }
    .header {
      background: #4a4438;
      padding: 36px 40px;
      text-align: center;
    }
    .header-logo {
      font-family: Arial Black, sans-serif;
      font-size: 28px;
      font-weight: 900;
      color: #b8973a;
      letter-spacing: 4px;
      text-transform: uppercase;
    }
    .header-sub {
      font-size: 11px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: rgba(245,240,232,0.5);
      margin-top: 6px;
    }
    .accent-bar { height: 4px; background: #b8973a; }
    .body { padding: 40px; }
    .greeting {
      font-size: 22px;
      font-weight: 700;
      color: #4a4438;
      margin-bottom: 8px;
    }
    .greeting em { color: #b8973a; font-style: normal; }
    .intro {
      font-size: 14px;
      color: #7a7060;
      line-height: 1.8;
      margin-bottom: 32px;
    }
    .info-card {
      background: #f5f0e8;
      border: 1px solid #d8d0c0;
      border-left: 4px solid #b8973a;
      border-radius: 8px;
      padding: 24px 28px;
      margin-bottom: 28px;
    }
    .info-card h3 {
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: #b8973a;
      margin-bottom: 20px;
    }
    .info-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 0;
      border-bottom: 1px solid #e6e0d4;
      font-size: 14px;
    }
    .info-row:last-child { border-bottom: none; }
    .info-label { color: #7a7060; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; }
    .info-value { color: #4a4438; font-weight: 600; }
    .notice-box {
      background: rgba(184,151,58,0.1);
      border: 1px solid rgba(184,151,58,0.3);
      border-radius: 8px;
      padding: 18px 22px;
      font-size: 13px;
      color: #7a7060;
      line-height: 1.7;
      margin-bottom: 28px;
    }
    .notice-box strong { color: #b8973a; }
    .cta-btn {
      display: block;
      background: #b8973a;
      color: #ffffff;
      text-align: center;
      padding: 16px;
      border-radius: 8px;
      text-decoration: none;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 3px;
      text-transform: uppercase;
      margin-bottom: 32px;
    }
    .footer {
      background: #f5f0e8;
      border-top: 1px solid #d8d0c0;
      padding: 28px 40px;
      text-align: center;
    }
    .footer p { font-size: 12px; color: #a09880; line-height: 1.8; }
    .footer strong { color: #b8973a; }
    @media (max-width: 600px) {
      .body, .footer { padding: 28px 20px; }
      .header { padding: 28px 20px; }
      .info-row { flex-direction: column; align-items: flex-start; gap: 4px; }
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="header">
      <div class="header-logo">AUTO X</div>
      <div class="header-sub">Trung tâm bảo dưỡng xe</div>
    </div>
    <div class="accent-bar"></div>

    <div class="body">
      <div class="greeting">Xin chào, <em>{{ $hoTen }}</em>!</div>
      <p class="intro">
        Chúng tôi đã nhận được yêu cầu đăng ký nhắc lịch bảo dưỡng định kỳ của bạn.
        Dưới đây là thông tin bạn đã đăng ký:
      </p>

      <div class="info-card">
        <h3>Thông tin đăng ký</h3>
        <div class="info-row">
          <span class="info-label">Họ và tên</span>
          <span class="info-value">{{ $hoTen }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Số điện thoại</span>
          <span class="info-value">{{ $soDienThoai }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Hãng xe</span>
          <span class="info-value">{{ $hangXe }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Km bảo dưỡng gần nhất</span>
          <span class="info-value">{{ number_format($kmGanNhat) }} km</span>
        </div>
      </div>

      <div class="notice-box">
        <strong>📅 Lịch nhắc của bạn:</strong> Chúng tôi sẽ liên hệ khi xe bạn còn <strong>khoảng 500 km</strong>
        hoặc <strong>2 tuần</strong> trước hạn bảo dưỡng tiếp theo — hoàn toàn miễn phí.
      </div>

      <a href="tel:{{ $soDienThoai }}" class="cta-btn">Liên hệ ngay nếu cần hỗ trợ</a>

      <p style="font-size:13px;color:#a09880;line-height:1.8">
        Nếu bạn không thực hiện đăng ký này, vui lòng bỏ qua email. Cảm ơn bạn đã tin tưởng <strong style="color:#b8973a">AUTO X</strong>.
      </p>
    </div>

    <div class="footer">
      <p>
        <strong>AUTO X</strong> — Trung tâm bảo dưỡng & sửa chữa xe<br>
        Email: {{ config('mail.from.address') }} &nbsp;|&nbsp; Hotline: 1900 xxxx<br><br>
        Email này được gửi tự động. Vui lòng không reply trực tiếp.
      </p>
    </div>
  </div>
</body>
</html>
