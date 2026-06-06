<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Xác nhận đặt cọc – AUTO X</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { background: #f2f2f0; font-family: 'Helvetica Neue', Arial, sans-serif; color: #111; -webkit-font-smoothing: antialiased; }
  a { color: inherit; text-decoration: none; }

  .wrap { max-width: 600px; margin: 32px auto; background: #fff; border-radius: 4px; overflow: hidden; box-shadow: 0 2px 16px rgba(0,0,0,.08); }

  /* ── HEADER ── */
  .header { background: #111; padding: 32px 40px 28px; text-align: center; position: relative; }
  .header-logo { font-size: 11px; font-weight: 800; letter-spacing: 5px; text-transform: uppercase; color: #d4a017; margin-bottom: 20px; }
  .header-title { font-size: 28px; font-weight: 900; color: #fff; text-transform: uppercase; letter-spacing: -0.5px; line-height: 1.1; margin-bottom: 6px; }
  .header-title span { color: #f0c040; }
  .header-sub { font-size: 11px; color: rgba(255,255,255,.45); font-weight: 500; letter-spacing: 1px; }
  .header-bar { height: 3px; background: linear-gradient(90deg, #d4a017, #f0c040, #d4a017); margin-top: 24px; }

  /* ── STATUS BADGE ── */
  .status-wrap { background: #f9f9f7; padding: 20px 40px; text-align: center; border-bottom: 1px solid #ebebeb; }
  .status-badge { display: inline-flex; align-items: center; gap: 8px; background: #fef9c3; border: 1px solid #fde047; border-radius: 20px; padding: 6px 18px; font-size: 11px; font-weight: 800; color: #854d0e; text-transform: uppercase; letter-spacing: 1.5px; }

  /* ── BODY ── */
  .body { padding: 36px 40px; }

  .greeting { font-size: 16px; color: #333; line-height: 1.6; margin-bottom: 28px; }
  .greeting strong { color: #111; }

  /* ── SECTION ── */
  .section { margin-bottom: 28px; }
  .section-title { font-size: 9px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; color: #aaa; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #eee; }

  /* ── TABLE ROWS ── */
  .info-table { width: 100%; border-collapse: collapse; }
  .info-table tr { border-bottom: 1px solid #f3f3f3; }
  .info-table tr:last-child { border-bottom: none; }
  .info-table td { padding: 10px 0; font-size: 14px; vertical-align: top; }
  .info-table td:first-child { color: #888; font-weight: 500; width: 42%; }
  .info-table td:last-child { color: #111; font-weight: 700; text-align: right; }
  .info-table .val-code { font-size: 17px; font-weight: 900; color: #c00; letter-spacing: 1px; font-family: 'Courier New', monospace; }
  .info-table .val-amount { font-size: 20px; font-weight: 900; color: #16a34a; }

  /* ── BANK BOX ── */
  .bank-box { background: #1e3a8a; border-radius: 6px; padding: 20px 24px; margin-bottom: 28px; }
  .bank-box-title { font-size: 9px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; color: #93c5fd; margin-bottom: 14px; }
  .bank-table { width: 100%; border-collapse: collapse; }
  .bank-table tr { border-bottom: 1px solid rgba(255,255,255,.08); }
  .bank-table tr:last-child { border-bottom: none; }
  .bank-table td { padding: 9px 0; font-size: 14px; color: rgba(255,255,255,.6); font-weight: 500; vertical-align: middle; }
  .bank-table td:last-child { color: #fff; font-weight: 700; text-align: right; }
  .bank-table .val-ck { background: rgba(255,255,255,.12); color: #fde047; font-weight: 900; font-size: 15px; padding: 3px 12px; border-radius: 4px; display: inline-block; letter-spacing: 1px; font-family: 'Courier New', monospace; }

  /* ── NOTE ── */
  .note-box { background: #fffbeb; border-left: 3px solid #fbbf24; border-radius: 0 6px 6px 0; padding: 14px 16px; margin-bottom: 28px; font-size: 13px; color: #78350f; line-height: 1.7; }
  .note-box strong { color: #92400e; }

  /* ── PLEDGE ── */
  .pledge-box { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 6px; padding: 16px 20px; margin-bottom: 28px; }
  .pledge-title { font-size: 9px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; color: #16a34a; margin-bottom: 10px; }
  .pledge-list { list-style: none; }
  .pledge-list li { font-size: 13px; color: #166534; line-height: 2; padding-left: 16px; position: relative; }
  .pledge-list li::before { content: '✓'; position: absolute; left: 0; color: #16a34a; font-weight: 900; }

  /* ── CTA ── */
  .cta-wrap { text-align: center; margin-bottom: 32px; }
  .cta-btn { display: inline-block; background: #1a1a1a; color: #fff; padding: 14px 36px; border-radius: 6px; font-size: 12px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; text-decoration: none; }

  /* ── FOOTER ── */
  .footer { background: #111; padding: 24px 40px; text-align: center; }
  .footer-logo { font-size: 10px; font-weight: 800; letter-spacing: 5px; text-transform: uppercase; color: #d4a017; margin-bottom: 10px; }
  .footer-text { font-size: 12px; color: rgba(255,255,255,.35); line-height: 1.8; }
  .footer-text a { color: rgba(255,255,255,.5); }
  .footer-divider { height: 1px; background: rgba(255,255,255,.08); margin: 14px 0; }

  @media (max-width: 620px) {
    .wrap { margin: 0; border-radius: 0; }
    .header, .body, .footer, .status-wrap { padding-left: 20px; padding-right: 20px; }
    .info-table td:first-child { width: 46%; font-size: 13px; }
    .info-table td:last-child { font-size: 13px; }
  }
</style>
</head>
<body>

<div class="wrap">

  {{-- ── HEADER ── --}}
  <div class="header">
    <div class="header-logo">AUTO X Showroom</div>
    <div class="header-title">Xác nhận <span>đặt cọc</span></div>
    <div class="header-sub">Biên nhận đặt cọc xe · Lưu lại để đối chiếu</div>
    <div class="header-bar"></div>
  </div>

  {{-- ── STATUS ── --}}
  <div class="status-wrap">
    <div class="status-badge">⏳ &nbsp;Chờ xác nhận thanh toán</div>
  </div>

  {{-- ── BODY ── --}}
  <div class="body">

    <p class="greeting">
      Xin chào <strong>{{ $deposit->customer_name }}</strong>,<br><br>
      Chúng tôi đã nhận được yêu cầu đặt cọc của bạn cho chiếc <strong>{{ $deposit->car->name }}</strong>.
      Email này là biên nhận ghi lại toàn bộ thông tin đặt cọc — vui lòng lưu lại để đối chiếu khi cần.
    </p>

    {{-- THÔNG TIN ĐẶT CỌC --}}
    <div class="section">
      <div class="section-title">Thông tin đặt cọc</div>
      <table class="info-table">
        <tr>
          <td>Mã giao dịch</td>
          <td><span class="val-code">{{ $deposit->transaction_code }}</span></td>
        </tr>
        <tr>
          <td>Xe đặt cọc</td>
          <td>{{ $deposit->car->name }}</td>
        </tr>
        <tr>
          <td>Số tiền cọc</td>
          <td><span class="val-amount">{{ number_format($deposit->deposit_amount, 0, ',', '.') }}đ</span></td>
        </tr>
        <tr>
          <td>Phương thức TT</td>
          <td>{{ $deposit->payment_method_label }}</td>
        </tr>
        <tr>
          <td>Trạng thái</td>
          <td>{{ $deposit->status_label }}</td>
        </tr>
        <tr>
          <td>Thời gian</td>
          <td>{{ $deposit->created_at->format('H:i · d/m/Y') }}</td>
        </tr>
      </table>
    </div>

    {{-- THÔNG TIN KHÁCH HÀNG --}}
    <div class="section">
      <div class="section-title">Thông tin khách hàng</div>
      <table class="info-table">
        <tr>
          <td>Họ và tên</td>
          <td>{{ $deposit->customer_name }}</td>
        </tr>
        <tr>
          <td>Số điện thoại</td>
          <td>{{ $deposit->customer_phone }}</td>
        </tr>
        <tr>
          <td>Email</td>
          <td>{{ $deposit->customer_email }}</td>
        </tr>
        @if($deposit->customer_id_card)
        <tr>
          <td>CCCD / CMND</td>
          <td>{{ $deposit->customer_id_card }}</td>
        </tr>
        @endif
        @if($deposit->customer_address)
        <tr>
          <td>Địa chỉ</td>
          <td>{{ $deposit->customer_address }}</td>
        </tr>
        @endif
        @if($deposit->note)
        <tr>
          <td>Ghi chú</td>
          <td style="color:#666;font-weight:500;">{{ $deposit->note }}</td>
        </tr>
        @endif
      </table>
    </div>

    {{-- THÔNG TIN CHUYỂN KHOẢN --}}
    @if($deposit->payment_method === 'bank_transfer')
    <div class="bank-box">
      <div class="bank-box-title">🏦 &nbsp;Thông tin chuyển khoản</div>
      <table class="bank-table">
        <tr>
          <td>Ngân hàng</td>
          <td>{{ config('payment.bank_name', env('PAYMENT_BANK_NAME', 'MB Bank')) }}</td>
        </tr>
        <tr>
          <td>Số tài khoản</td>
          <td>{{ config('payment.bank_account', env('PAYMENT_BANK_ACCOUNT', '0328078853')) }}</td>
        </tr>
        <tr>
          <td>Chủ tài khoản</td>
          <td>{{ config('payment.bank_owner', env('PAYMENT_BANK_OWNER', 'VO MINH TAN')) }}</td>
        </tr>
        <tr>
          <td>Số tiền</td>
          <td>{{ number_format($deposit->deposit_amount, 0, ',', '.') }}đ</td>
        </tr>
        <tr>
          <td>Nội dung CK</td>
          <td><span class="val-ck">{{ $deposit->transaction_code }}</span></td>
        </tr>
      </table>
    </div>
    @endif

    {{-- LƯU Ý --}}
    <div class="note-box">
      <strong>Lưu ý:</strong> Vui lòng chuyển khoản <strong>đúng số tiền</strong> và ghi <strong>đúng nội dung</strong>
      mã giao dịch để chúng tôi xác nhận nhanh nhất. Sau khi xác minh thanh toán,
      tư vấn viên sẽ liên hệ lại với bạn trong vòng <strong>24 giờ</strong>.
    </div>

    {{-- CAM KẾT --}}
    <div class="pledge-box">
      <div class="pledge-title">✦ Cam kết của AUTO X</div>
      <ul class="pledge-list">
        <li>Giữ xe trong vòng <strong>30 ngày</strong> kể từ khi nhận cọc</li>
        <li>Hoàn trả <strong>100%</strong> tiền cọc nếu xe không còn hàng</li>
        <li>Tư vấn viên liên hệ xác nhận trong <strong>24 giờ</strong></li>
      </ul>
    </div>

    {{-- CTA --}}
    <div class="cta-wrap">
      <a href="{{ route('cars.show', $deposit->car->slug) }}" class="cta-btn">
        Xem lại thông tin xe →
      </a>
    </div>

  </div>

  {{-- ── FOOTER ── --}}
  <div class="footer">
    <div class="footer-logo">AUTO X Showroom</div>
    <div class="footer-divider"></div>
    <div class="footer-text">
      Hotline: <a href="tel:0909123456">0909 123 456</a> &nbsp;·&nbsp;
      Email: <a href="mailto:info@autox.vn">info@autox.vn</a><br>
      Email này được gửi tự động, vui lòng không reply trực tiếp.<br>
      © {{ date('Y') }} AUTO X Showroom. All rights reserved.
    </div>
  </div>

</div>

</body>
</html>
