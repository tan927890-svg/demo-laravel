<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Yêu cầu nhận / giao xe</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { background: #f0ebe0; font-family: Arial, sans-serif; }
  .wrap { max-width: 600px; margin: 32px auto; background: #fff; }

  .header {
    background: #1c1a16;
    padding: 32px 40px;
    display: flex; align-items: center; gap: 16px;
  }
  .logo-mark {
    width: 44px; height: 44px; background: #b8973a;
    display: flex; align-items: center; justify-content: center;
    font-weight: 900; font-size: 18px; color: #fff; letter-spacing: -1px;
    flex-shrink: 0;
  }
  .logo-text { color: #f5f0e8; font-size: 22px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; }
  .logo-sub { color: rgba(245,240,232,0.45); font-size: 10px; letter-spacing: 3px; text-transform: uppercase; margin-top: 2px; }

  .badge-bar {
    background: #b8973a;
    padding: 10px 40px;
    font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: #fff;
  }

  .body { padding: 36px 40px; }

  .greeting { font-size: 15px; color: #4a4438; margin-bottom: 6px; }
  .intro { font-size: 13px; color: #7a7060; line-height: 1.7; margin-bottom: 28px; }

  .section-title {
    font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase;
    color: #b8973a; margin-bottom: 12px;
    padding-bottom: 8px; border-bottom: 2px solid #b8973a;
  }

  .info-table { width: 100%; border-collapse: collapse; margin-bottom: 28px; }
  .info-table tr { border-bottom: 1px solid #e8e0d0; }
  .info-table tr:last-child { border-bottom: none; }
  .info-table td { padding: 11px 0; font-size: 13px; vertical-align: top; }
  .info-table td:first-child {
    color: #7a7060; width: 160px; font-weight: 600;
    text-transform: uppercase; font-size: 11px; letter-spacing: 1px;
    padding-top: 13px;
  }
  .info-table td:last-child { color: #1c1a16; font-weight: 500; }

  .loai-badge {
    display: inline-block;
    background: #b8973a; color: #fff;
    font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;
    padding: 4px 12px;
  }

  .note-box {
    background: #f5f0e8; border-left: 3px solid #b8973a;
    padding: 14px 18px; margin-bottom: 28px;
    font-size: 13px; color: #4a4438; line-height: 1.7;
  }
  .note-label { font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #7a7060; margin-bottom: 6px; }

  .action-box {
    background: #1c1a16; padding: 24px 28px; margin-bottom: 28px;
    display: flex; align-items: center; justify-content: space-between; gap: 16px;
    flex-wrap: wrap;
  }
  .action-text { color: rgba(245,240,232,0.65); font-size: 13px; }
  .action-phone { color: #b8973a; font-size: 24px; font-weight: 800; }
  .action-btn {
    display: inline-block; background: #b8973a; color: #fff;
    padding: 10px 24px; text-decoration: none;
    font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;
  }

  .footer {
    background: #f5f0e8; padding: 20px 40px;
    border-top: 1px solid #d8d0c0;
    font-size: 11px; color: #a09880; text-align: center; line-height: 1.8;
  }
  .footer a { color: #b8973a; text-decoration: none; }
</style>
</head>
<body>
<div class="wrap">

  {{-- HEADER --}}
  <div class="header">
    <div class="logo-mark">AX</div>
    <div>
      <div class="logo-text">AUTO X</div>
      <div class="logo-sub">Premium Auto Service</div>
    </div>
  </div>

  <div class="badge-bar">
    📋 Yêu cầu nhận &amp; giao xe mới
  </div>

  <div class="body">

    <p class="greeting">Xin chào đội ngũ AUTO X,</p>
    <p class="intro">
      Có một yêu cầu nhận / giao xe mới vừa được gửi qua website. Vui lòng liên hệ khách hàng để xác nhận trong vòng <strong>15 phút</strong>.
    </p>

    {{-- THÔNG TIN KHÁCH HÀNG --}}
    <div class="section-title">Thông tin khách hàng</div>
    <table class="info-table">
      <tr>
        <td>Loại dịch vụ</td>
        <td><span class="loai-badge">{{ $data['loai_dich_vu'] }}</span></td>
      </tr>
      <tr>
        <td>Họ và tên</td>
        <td>{{ $data['ho_ten'] }}</td>
      </tr>
      <tr>
        <td>Số điện thoại</td>
        <td><strong style="font-size:15px">{{ $data['dien_thoai'] }}</strong></td>
      </tr>
      <tr>
        <td>Địa chỉ</td>
        <td>{{ $data['dia_chi'] }}</td>
      </tr>
    </table>

    {{-- THÔNG TIN LỊCH HẸN --}}
    <div class="section-title">Lịch hẹn</div>
    <table class="info-table">
      <tr>
        <td>Ngày</td>
        <td>{{ \Carbon\Carbon::parse($data['ngay'])->format('d/m/Y') }}</td>
      </tr>
      <tr>
        <td>Khung giờ</td>
        <td>{{ $data['khung_gio'] }}</td>
      </tr>
    </table>

    {{-- THÔNG TIN XE --}}
    <div class="section-title">Thông tin xe &amp; dịch vụ</div>
    <table class="info-table">
      <tr>
        <td>Hãng xe</td>
        <td>{{ $data['hang_xe'] ?: '—' }}</td>
      </tr>
      <tr>
        <td>Biển số</td>
        <td>{{ $data['bien_so'] ?: '—' }}</td>
      </tr>
      <tr>
        <td>Dịch vụ</td>
        <td>{{ $data['dich_vu'] }}</td>
      </tr>
    </table>

    {{-- GHI CHÚ --}}
    @if(!empty($data['ghi_chu']))
    <div class="note-box">
      <div class="note-label">Ghi chú của khách</div>
      {{ $data['ghi_chu'] }}
    </div>
    @endif

    {{-- ACTION --}}
    <div class="action-box">
      <div>
        <div class="action-text">Gọi ngay để xác nhận lịch</div>
        <div class="action-phone">{{ $data['dien_thoai'] }}</div>
      </div>
      <a href="tel:{{ preg_replace('/\s+/', '', $data['dien_thoai']) }}" class="action-btn">Gọi ngay →</a>
    </div>

  </div>

  <div class="footer">
    Email này được gửi tự động từ website <a href="#">autox.vn</a><br>
    © {{ date('Y') }} AUTO X — Premium Auto Service, TP. Hồ Chí Minh
  </div>

</div>
</body>
</html>
