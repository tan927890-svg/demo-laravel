<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: Arial, sans-serif; color: #1a1a1a; background: #f5f5f5; margin: 0; padding: 0; }
  .wrap { max-width: 600px; margin: 32px auto; background: #fff; border: 1px solid #e0e0e0; }
  .header { background: #1c69d4; padding: 24px 32px; text-align: center; }
  .header h2 { color: #fff; margin: 0; font-size: 22px; }
  .header p { color: rgba(255,255,255,0.85); margin: 6px 0 0; font-size: 13px; }
  .body { padding: 32px; }
  .check { text-align: center; margin-bottom: 24px; }
  .check-circle { display: inline-flex; align-items: center; justify-content: center;
                  width: 64px; height: 64px; background: #eaf2ff; border-radius: 50%;
                  border: 2px solid #bcd4f8; font-size: 28px; }
  h3 { text-align: center; font-size: 20px; margin: 0 0 8px; }
  .sub { text-align: center; color: #666; font-size: 14px; margin-bottom: 28px; line-height: 1.6; }
  .ref { text-align: center; background: #f0f6ff; border: 1px solid #bcd4f8;
         color: #1c69d4; font-weight: 700; font-size: 16px;
         padding: 12px; margin-bottom: 28px; letter-spacing: 1px; }
  table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
  tr { border-bottom: 1px solid #f0f0f0; }
  td { padding: 10px 6px; font-size: 14px; vertical-align: top; }
  td:first-child { width: 40%; color: #888; font-weight: 600; font-size: 12px;
                   text-transform: uppercase; letter-spacing: 0.5px; }
  .note { background: #fffbf0; border-left: 3px solid #f39c12; padding: 14px 16px;
          font-size: 13px; color: #555; line-height: 1.6; margin-bottom: 20px; }
  .footer { background: #f7f7f7; border-top: 1px solid #e0e0e0; padding: 16px 32px;
            font-size: 12px; color: #999; text-align: center; }
  .footer a { color: #1c69d4; text-decoration: none; }
</style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <h2>AUTO X</h2>
    <p>Xác nhận đặt lịch dịch vụ</p>
  </div>
  <div class="body">
    <div class="check"><div class="check-circle">✓</div></div>
    <h3>Đặt lịch thành công!</h3>
    <p class="sub">
      Xin chào <strong>{{ $ho_ten }}</strong>,<br>
      Chúng tôi đã nhận được yêu cầu đặt lịch của bạn.<br>
      Nhân viên sẽ liên hệ xác nhận qua điện thoại trong vòng <strong>30 phút</strong>.
    </p>

    <div class="ref">Mã đặt lịch: {{ $ref }}</div>

    <table>
      <tr><td>Dịch vụ</td><td>{{ $dich_vu ?? '—' }} — {{ $chu_de ?? '—' }}</td></tr>
      <tr><td>Xe</td><td>{{ $hang_xe ?? '—' }} {{ $mau_xe ?? '' }} ({{ $bien_so ?? '—' }})</td></tr>
      <tr><td>Ngày hẹn</td><td><strong>{{ $ngay }}</strong></td></tr>
      <tr><td>Giờ hẹn</td><td><strong>{{ $gio ?? '—' }}</strong></td></tr>
      <tr><td>Địa chỉ</td><td>Hẻm 2276/23 Trung Mỹ Tây, Q.12, TP.HCM</td></tr>
    </table>

    <div class="note">
      ⚠️ <strong>Lưu ý:</strong> Vui lòng mang theo giấy tờ xe khi đến.<br>
      Nếu cần hủy hoặc đổi lịch, báo trước ít nhất <strong>2 giờ</strong> qua hotline <strong>0909 123 456</strong>.
    </div>
  </div>
  <div class="footer">
    AUTO X &mdash; <a href="tel:0909123456">0909 123 456</a> &mdash;
    <a href="mailto:tan927890@gmail.com">tan927890@gmail.com</a>
  </div>
</div>
</body>
</html>