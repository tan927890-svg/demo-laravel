<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Newsletter mới – AUTO X Admin</title>
</head>
<body style="margin:0;padding:0;background:#f0f0f0;font-family:'Segoe UI',Arial,sans-serif">

  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f0f0;padding:40px 0">
    <tr>
      <td align="center">
        <table width="520" cellpadding="0" cellspacing="0"
               style="background:#ffffff;border-radius:4px;overflow:hidden;
                      box-shadow:0 2px 12px rgba(0,0,0,0.08)">

          <tr>
            <td style="background:#000;padding:20px 32px;border-bottom:3px solid #1c69d4">
              <p style="margin:0;font-size:13px;color:#aaa;letter-spacing:2px;text-transform:uppercase">
                AUTO X — Admin Notification
              </p>
            </td>
          </tr>

          <tr>
            <td style="padding:32px">
              <h2 style="margin:0 0 20px;font-size:20px;color:#000">
                📬 Đăng ký nhận tin mới
              </h2>

              <table width="100%" cellpadding="0" cellspacing="0"
                     style="background:#f8f9fc;border:1px solid #e8e8e8;
                            border-radius:3px;padding:20px 24px">
                <tr>
                  <td>
                    <p style="margin:0 0 10px;font-size:14px;color:#555">
                      <strong>Email:</strong>
                      <span style="color:#1c69d4;font-weight:600"> {{ $email }}</span>
                    </p>
                    <p style="margin:0;font-size:14px;color:#555">
                      <strong>Thời gian:</strong>
                      <span> {{ now()->format('H:i – d/m/Y') }}</span>
                    </p>
                  </td>
                </tr>
              </table>

              <p style="margin:20px 0 0;font-size:13px;color:#888">
                Email này được gửi tự động từ hệ thống AUTO X.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>
