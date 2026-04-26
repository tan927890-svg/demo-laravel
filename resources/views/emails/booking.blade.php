<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: Arial, sans-serif; color: #1a1a1a; background: #f5f5f5; margin: 0; padding: 0; }
  .wrap { max-width: 600px; margin: 32px auto; background: #fff; border: 1px solid #e0e0e0; }
  .header { background: #1c69d4; padding: 24px 32px; }
  .header h2 { color: #fff; margin: 0; font-size: 20px; letter-spacing: 1px; }
  .header p { color: rgba(255,255,255,0.8); margin: 4px 0 0; font-size: 13px; }
  .body { padding: 28px 32px; }
  .ref { display: inline-block; background: #f0f6ff; border: 1px solid #bcd4f8; color: #1c69d4;
         font-weight: 700; font-size: 15px; padding: 8px 18px; margin-bottom: 24px; letter-spacing: 1px; }
  table { width: 100%; border-collapse: collapse; }
  tr { border-bottom: 1px solid #f0f0f0; }
  td { padding: 10px 6px; font-size: 14px; vertical-align: top; }
  td:first-child { width: 38%; color: #888; font-weight: 600; font-size: 12px;
                   text-transform: uppercase; letter-spacing: 0.5px; padding-right: 12px; }
  .footer { background: #f7f7f7; border-top: 1px solid #e0e0e0; padding: 16px 32px;
            font-size: 12px; color: #999; }
</style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <h2>🔧 ĐẶT LỊCH MỚI</h2>
    <p>Yêu cầu đặt lịch vừa được gửi từ website AUTO X</p>
  </div>
  <div class="body">
    <div class="ref">Mã đặt lịch: {{ $ref }}</div>
    <table>
      <tr><td>Họ và tên</td><td><strong>{{ $ho_ten }}</strong></td></tr>
      <tr><td>Điện thoại</td><td>{{ $dien_thoai }}</td></tr>
      <tr><td>Email</td><td>{{ $email }}</td></tr>
      <tr><td>Dịch vụ</td><td>{{ $dich_vu ?? '—' }}</td></tr>
      <tr><td>Chủ đề</td><td>{{ $chu_de ?? '—' }}</td></tr>
      <tr><td>Hãng xe</td><td>{{ $hang_xe ?? '—' }}</td></tr>
      <tr><td>Mẫu xe</td><td>{{ $mau_xe ?? '—' }}</td></tr>
      <tr><td>Biển số</td><td>{{ $bien_so ?? '—' }}</td></tr>
      <tr><td>Số km</td><td>{{ $so_km ?? '—' }}</td></tr>
      <tr><td>Ngày hẹn</td><td><strong>{{ $ngay }}</strong></td></tr>
      <tr><td>Giờ hẹn</td><td><strong>{{ $gio ?? '—' }}</strong></td></tr>
      <tr><td>Ghi chú</td><td>{{ $ghi_chu ?? '—' }}</td></tr>
    </table>
  </div>
  <div class="footer">AUTO X &mdash; Hẻm 2276/23 Trung Mỹ Tây, Q.12, TP.HCM &mdash; 0909 123 456</div>
</div>
</body>
</html>