<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đăng ký nhận tin – AUTO X</title>
</head>
<body style="margin:0;padding:0;background:#f0f0f0;font-family:'Segoe UI',Arial,sans-serif">

  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f0f0;padding:40px 0">
    <tr>
      <td align="center">
        <table width="580" cellpadding="0" cellspacing="0"
               style="background:#ffffff;border-radius:4px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.08)">

          {{-- Header --}}
          <tr>
            <td style="background:#000000;padding:28px 40px;border-bottom:4px solid #1c69d4">
              <p style="margin:0;font-family:'Segoe UI',Arial,sans-serif;font-size:22px;
                         font-weight:700;color:#ffffff;letter-spacing:6px;text-transform:uppercase">
                AUTO X
              </p>
              <p style="margin:4px 0 0;font-size:10px;color:#aaaaaa;letter-spacing:3px;text-transform:uppercase">
                Showroom Ô Tô Cao Cấp
              </p>
            </td>
          </tr>

          {{-- Body --}}
          <tr>
            <td style="padding:40px 40px 32px">
              <h2 style="margin:0 0 16px;font-size:22px;color:#000000;font-weight:700">
                Đăng ký thành công! 🎉
              </h2>
              <p style="margin:0 0 16px;font-size:15px;color:#333333;line-height:1.7">
                Xin chào,
              </p>
              <p style="margin:0 0 16px;font-size:15px;color:#333333;line-height:1.7">
                Email <strong style="color:#1c69d4">{{ $email }}</strong> đã được đăng ký
                nhận tin từ <strong>AUTO X Showroom</strong>.
              </p>
              <p style="margin:0 0 24px;font-size:15px;color:#333333;line-height:1.7">
                Từ nay bạn sẽ nhận được:
              </p>

              <table cellpadding="0" cellspacing="0" width="100%"
                     style="background:#f8f9fc;border-left:4px solid #1c69d4;
                            border-radius:2px;padding:20px 24px;margin-bottom:28px">
                <tr>
                  <td style="font-size:14px;color:#444;line-height:1.9">
                    ✔ &nbsp;Ưu đãi & khuyến mãi độc quyền<br>
                    ✔ &nbsp;Thông tin các mẫu xe mới nhất<br>
                    ✔ &nbsp;Chương trình sự kiện đặc biệt<br>
                    ✔ &nbsp;Mẹo chăm sóc & bảo dưỡng xe
                  </td>
                </tr>
              </table>

              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="background:#1c69d4;border-radius:2px">
                    <a href="https://autox.vn/cars"
                       style="display:inline-block;padding:13px 28px;font-size:13px;
                              font-weight:600;color:#ffffff;text-decoration:none;
                              letter-spacing:1px;text-transform:uppercase">
                      Khám Phá Xe Ngay →
                    </a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          {{-- Footer --}}
          <tr>
            <td style="background:#0a0a0a;padding:20px 40px">
              <p style="margin:0;font-size:12px;color:#666666;line-height:1.7">
                Bạn nhận được email này vì đã đăng ký tại <a href="https://autox.vn"
                style="color:#1c69d4;text-decoration:none">autox.vn</a>.<br>
                Nếu không phải bạn đăng ký, vui lòng bỏ qua email này.
              </p>
              <p style="margin:12px 0 0;font-size:11px;color:#444444">
                © {{ date('Y') }} AUTO X – Hẻm 2276/23 Trung Mỹ Tây, Quận 12, TP.HCM
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>
