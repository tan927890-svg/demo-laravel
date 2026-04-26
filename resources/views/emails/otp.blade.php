<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: Arial, sans-serif; background: #f5f0e8; margin: 0; padding: 32px 16px; }
    .card { max-width: 480px; margin: 0 auto; background: #fff; border-radius: 16px; overflow: hidden; }
    .header { background: #002D74; padding: 28px 32px; text-align: center; }
    .header span { font-size: 22px; font-weight: 700; color: #fff; letter-spacing: 1px; }
    .body { padding: 32px; }
    .otp-box { background: #f5f0e8; border-radius: 12px; text-align: center; padding: 20px; margin: 24px 0; }
    .otp-box p { margin: 0 0 6px; font-size: 13px; color: #6b7280; }
    .otp-code { font-size: 36px; font-weight: 700; letter-spacing: 10px; color: #002D74; }
    .note { font-size: 13px; color: #6b7280; line-height: 1.6; }
    .footer { background: #f9fafb; padding: 16px 32px; text-align: center; font-size: 12px; color: #9ca3af; }
  </style>
</head>
<body>
  <div class="card">
    <div class="header"><span>AUTO X</span></div>
    <div class="body">
      <p style="font-size:16px;color:#111827;margin:0 0 8px">Xin chào,</p>
      <p class="note">Chúng tôi nhận được yêu cầu đặt lại mật khẩu. Sử dụng mã OTP bên dưới:</p>
      <div class="otp-box">
        <p>Mã xác minh của bạn</p>
        <div class="otp-code">{{ $otp }}</div>
      </div>
      <p class="note">Mã có hiệu lực trong <strong>10 phút</strong>. Không chia sẻ mã này cho bất kỳ ai.</p>
      <p class="note" style="margin-top:12px">Nếu bạn không yêu cầu, hãy bỏ qua email này.</p>
    </div>
    <div class="footer">© {{ date('Y') }} AUTO X — Hệ thống quản lý xe</div>
  </div>
</body>
</html>