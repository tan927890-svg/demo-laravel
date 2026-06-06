<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hóa đơn thanh toán</title>
</head>
<body style="margin:0;padding:0;background:#f5f6fa;font-family:'Segoe UI',Arial,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f6fa;padding:32px 0;">
    <tr><td align="center">
      <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08);">

        {{-- Header --}}
        <tr>
          <td style="background:linear-gradient(135deg,#16a34a 0%,#15803d 100%);padding:32px 36px;text-align:center;">
            <div style="font-size:26px;font-weight:800;color:#fff;letter-spacing:-0.5px;margin-bottom:4px;">🚗 AutoViet</div>
            <div style="font-size:13px;color:rgba(255,255,255,.75);">Xác nhận thanh toán thành công</div>
          </td>
        </tr>

        {{-- Body --}}
        <tr>
          <td style="padding:32px 36px;">

            <div style="font-size:18px;font-weight:700;color:#111827;margin-bottom:8px;">Xin chào {{ $deposit->customer_name }},</div>
            <div style="font-size:14px;color:#6b7280;line-height:1.6;margin-bottom:24px;">
              Giao dịch đặt cọc và thanh toán xe của bạn đã được xác nhận hoàn tất.
              Vui lòng xem hóa đơn đính kèm (file PDF) để lưu làm chứng từ.
            </div>

            {{-- Badge --}}
            <table width="100%" cellpadding="0" cellspacing="0" style="background:#d1fae5;border:1.5px solid #34d399;border-radius:10px;margin-bottom:24px;">
              <tr><td style="padding:18px 20px;text-align:center;">
                <div style="font-size:32px;margin-bottom:6px;">🎉</div>
                <div style="font-size:15px;font-weight:800;color:#065f46;">Thanh toán hoàn tất!</div>
                <div style="font-size:13px;color:#047857;margin-top:4px;">Mã giao dịch: {{ $deposit->transaction_code }}</div>
              </td></tr>
            </table>

            {{-- Info table --}}
            <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:12px;">

              <tr style="border-bottom:1px solid #d1fae5;">
                <td style="padding:14px 20px;font-size:14px;color:#6b7280;font-weight:500;width:50%;">Khách hàng</td>
                <td style="padding:14px 20px;font-size:14px;font-weight:700;color:#111827;text-align:right;">{{ $deposit->customer_name }}</td>
              </tr>

              <tr style="border-bottom:1px solid #d1fae5;">
                <td style="padding:14px 20px;font-size:14px;color:#6b7280;font-weight:500;border-top:1px solid #d1fae5;">Số điện thoại</td>
                <td style="padding:14px 20px;font-size:14px;font-weight:700;color:#111827;text-align:right;border-top:1px solid #d1fae5;">{{ $deposit->customer_phone }}</td>
              </tr>

              <tr>
                <td style="padding:14px 20px;font-size:14px;color:#6b7280;font-weight:500;border-top:1px solid #d1fae5;">Xe đặt cọc</td>
                <td style="padding:14px 20px;font-size:14px;font-weight:700;color:#111827;text-align:right;border-top:1px solid #d1fae5;">{{ optional($deposit->car)->name ?? '—' }}</td>
              </tr>

              <tr>
                <td style="padding:14px 20px;font-size:14px;color:#6b7280;font-weight:500;border-top:1px solid #d1fae5;">Số tiền đặt cọc</td>
                <td style="padding:14px 20px;font-size:15px;font-weight:700;color:#16a34a;text-align:right;border-top:1px solid #d1fae5;">{{ number_format($deposit->deposit_amount) }} ₫</td>
              </tr>

              @if($deposit->final_amount)
              <tr>
                <td style="padding:14px 20px;font-size:14px;color:#6b7280;font-weight:500;border-top:1px solid #d1fae5;">Thanh toán thêm</td>
                <td style="padding:14px 20px;font-size:15px;font-weight:700;color:#16a34a;text-align:right;border-top:1px solid #d1fae5;">{{ number_format($deposit->final_amount) }} ₫</td>
              </tr>
              @endif

              <tr>
                <td style="padding:14px 20px;font-size:14px;color:#6b7280;font-weight:500;border-top:1px solid #d1fae5;">Ngày hoàn tất</td>
                <td style="padding:14px 20px;font-size:14px;font-weight:700;color:#111827;text-align:right;border-top:1px solid #d1fae5;">{{ $deposit->final_paid_at?->format('H:i · d/m/Y') ?? now()->format('H:i · d/m/Y') }}</td>
              </tr>

              @if($deposit->assignedTo)
              <tr>
                <td style="padding:14px 20px;font-size:14px;color:#6b7280;font-weight:500;border-top:1px solid #d1fae5;">Nhân viên phụ trách</td>
                <td style="padding:14px 20px;font-size:14px;font-weight:700;color:#111827;text-align:right;border-top:1px solid #d1fae5;">{{ $deposit->assignedTo->name }}</td>
              </tr>
              @endif

            </table>

            {{-- PDF note --}}
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:24px;">
              <tr>
                <td style="background:#eff6ff;border-left:4px solid #3b82f6;border-radius:0 8px 8px 0;padding:12px 16px;font-size:13px;color:#1e40af;line-height:1.5;">
                  📎 <strong>File hóa đơn PDF</strong> đã được đính kèm trong email này. Vui lòng tải về và lưu lại để làm chứng từ khi nhận xe.
                </td>
              </tr>
            </table>

          </td>
        </tr>

        {{-- Footer --}}
        <tr>
          <td style="background:#f9fafb;border-top:1px solid #e5e7eb;padding:20px 36px;text-align:center;font-size:12px;color:#9ca3af;line-height:1.7;">
            <strong style="color:#374151;">AutoViet – Showroom xe chính hãng</strong><br>
            Email: tan927890@gmail.com<br>
            Nếu có thắc mắc, vui lòng liên hệ nhân viên phụ trách hoặc hotline showroom.
          </td>
        </tr>

      </table>
    </td></tr>
  </table>
</body>
</html>