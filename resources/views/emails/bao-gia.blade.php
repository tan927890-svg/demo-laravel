<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
</head>
<body style="margin:0;padding:0;background:#f0f0f0;font-family:'Segoe UI',Arial,sans-serif;">

  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f0f0;padding:40px 0;">
    <tr><td align="center">
      <table width="600" cellpadding="0" cellspacing="0">

        {{-- HEADER --}}
        <tr>
          <td style="background:#0a0a0a;padding:32px 40px;border-radius:8px 8px 0 0;">
            <table width="100%"><tr>
              <td>
                <div style="font-size:22px;font-weight:800;color:#fff;letter-spacing:3px;">AUTO X</div>
                <div style="font-size:11px;color:#888;letter-spacing:2px;margin-top:2px;">SHOWROOM Ô TÔ CAO CẤP</div>
              </td>
              <td align="right">
                <div style="background:#1c69d4;color:#fff;font-size:11px;font-weight:700;padding:6px 12px;border-radius:4px;letter-spacing:2px;">
                  BÁO GIÁ MỚI
                </div>
              </td>
            </tr></table>
          </td>
        </tr>

        {{-- BANNER --}}
        <tr>
          <td style="background:#1c69d4;padding:16px 40px;">
            <p style="margin:0;color:#fff;font-size:15px;font-weight:600;">
              🔔 &nbsp;Có khách hàng mới vừa đăng ký nhận báo giá!
            </p>
          </td>
        </tr>

        {{-- BODY --}}
        <tr>
          <td style="background:#fff;padding:40px;">

            <p style="margin:0 0 28px;font-size:15px;color:#555;line-height:1.7;">
              Hệ thống vừa ghi nhận yêu cầu báo giá mới.
              Vui lòng liên hệ khách hàng
              <strong style="color:#0a0a0a;">sớm nhất có thể</strong>.
            </p>

            {{-- INFO TABLE --}}
            <table width="100%" cellpadding="0" cellspacing="0"
                   style="border:1px solid #e8e8e8;border-radius:8px;overflow:hidden;margin-bottom:28px;">
              <tr>
                <td colspan="2" style="background:#f7f7f7;padding:12px 20px;border-bottom:1px solid #e8e8e8;">
                  <span style="font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#888;">
                    Thông tin khách hàng
                  </span>
                </td>
              </tr>
              <tr>
                <td style="padding:16px 20px;background:#fafafa;font-size:13px;font-weight:600;color:#888;text-transform:uppercase;letter-spacing:.5px;border-bottom:1px solid #f0f0f0;width:40%;">
                  👤 Họ tên
                </td>
                <td style="padding:16px 20px;font-size:16px;font-weight:700;color:#0a0a0a;border-bottom:1px solid #f0f0f0;">
                  {{ $data->ten }}
                </td>
              </tr>
              <tr>
                <td style="padding:16px 20px;background:#fafafa;font-size:13px;font-weight:600;color:#888;text-transform:uppercase;letter-spacing:.5px;border-bottom:1px solid #f0f0f0;">
                  📞 Số điện thoại
                </td>
                <td style="padding:16px 20px;font-size:16px;font-weight:700;border-bottom:1px solid #f0f0f0;">
                  <a href="tel:{{ $data->so_dien_thoai }}" style="color:#1c69d4;text-decoration:none;">
                    {{ $data->so_dien_thoai }}
                  </a>
                </td>
              </tr>
              <tr>
                <td style="padding:16px 20px;background:#fafafa;font-size:13px;font-weight:600;color:#888;text-transform:uppercase;letter-spacing:.5px;border-bottom:1px solid #f0f0f0;">
                  🚘 Dòng xe
                </td>
                <td style="padding:16px 20px;font-size:15px;font-weight:600;color:#0a0a0a;border-bottom:1px solid #f0f0f0;">
                  {{ $data->dong_xe ?? '—' }}
                </td>
              </tr>
              <tr>
                <td style="padding:16px 20px;background:#fafafa;font-size:13px;font-weight:600;color:#888;text-transform:uppercase;letter-spacing:.5px;">
                  🕐 Thời gian
                </td>
                <td style="padding:16px 20px;font-size:14px;color:#555;">
                 {{ optional($data->created_at)->format('H:i — d/m/Y') }}
                </td>
              </tr>
            </table>

            {{-- CTA --}}
            <table width="100%"><tr><td align="center">
              <a href="tel:{{ $data->so_dien_thoai }}"
                 style="display:inline-block;background:#0a0a0a;color:#fff;font-size:13px;font-weight:700;letter-spacing:2px;text-transform:uppercase;padding:16px 40px;border-radius:6px;text-decoration:none;">
                📞 &nbsp;Gọi Ngay Cho Khách
              </a>
            </td></tr></table>

          </td>
        </tr>

        {{-- FOOTER --}}
        <tr>
          <td style="background:#0a0a0a;padding:24px 40px;border-radius:0 0 8px 8px;">
            <p style="margin:0;font-size:12px;color:#666;line-height:1.7;">
              © {{ date('Y') }} <strong style="color:#fff;">AUTO X</strong> — Showroom Ô Tô Cao Cấp<br>
              Email tự động — Vui lòng không reply trực tiếp.
            </p>
          </td>
        </tr>

      </table>
    </td></tr>
  </table>

</body>
</html>