<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'DejaVu Sans', sans-serif;
      font-size: 12px;
      color: #1a1a1a;
      background: #fff;
      padding: 36px 44px;
    }

    /* ── Header ── */
    .header { display: table; width: 100%; margin-bottom: 24px; border-bottom: 3px solid #16a34a; padding-bottom: 18px; }
    .header-left  { display: table-cell; vertical-align: middle; width: 60%; }
    .header-right { display: table-cell; vertical-align: middle; text-align: right; }
    .company-name { font-size: 20px; font-weight: bold; color: #16a34a; letter-spacing: -0.3px; }
    .company-sub  { font-size: 10px; color: #6b7280; margin-top: 2px; }
    .invoice-title { font-size: 18px; font-weight: bold; color: #111827; }
    .invoice-code  { font-size: 12px; color: #6b7280; margin-top: 3px; }
    .invoice-date  { font-size: 11px; color: #9ca3af; margin-top: 2px; }

    /* ── Badges ── */
    .badge-wrap { margin-bottom: 18px; text-align: right; }
    .badge-stamp {
      display: inline-block;
      border: 2px solid #16a34a; color: #16a34a;
      font-size: 9px; font-weight: bold;
      letter-spacing: 1.5px; text-transform: uppercase;
      padding: 3px 10px; border-radius: 4px;
    }
    .badge-completed {
      display: inline-block;
      background: #d1fae5; color: #065f46;
      border: 1.5px solid #34d399; border-radius: 20px;
      padding: 4px 14px; font-size: 10px; font-weight: bold;
      letter-spacing: 0.5px; margin-bottom: 16px;
    }

    /* ── Section ── */
    .section { margin-bottom: 20px; }
    .section-title {
      font-size: 9px; font-weight: bold; color: #9ca3af;
      text-transform: uppercase; letter-spacing: 1.5px;
      margin-bottom: 8px; padding-bottom: 5px;
      border-bottom: 1px solid #f3f4f6;
    }

    /* ── Two col ── */
    .two-col { display: table; width: 100%; }
    .col-left  { display: table-cell; vertical-align: top; width: 50%; padding-right: 18px; }
    .col-right { display: table-cell; vertical-align: top; width: 50%; padding-left: 18px; }

    /* ── Field ── */
    .field { margin-bottom: 9px; }
    .field-label { font-size: 9px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 2px; }
    .field-val { font-size: 12px; font-weight: bold; color: #111827; }

    /* ── Amount table ── */
    .amount-table { width: 100%; border-collapse: collapse; }
    .amount-table td { padding: 8px 10px; font-size: 12px; border-bottom: 1px solid #f3f4f6; }
    .amount-table tr:last-child td { border-bottom: none; }
    .lbl { color: #6b7280; }
    .val { text-align: right; font-weight: bold; color: #111827; }
    .val-muted { text-align: right; color: #6b7280; }
    .total-row td { background: #f0fdf4; }
    .total-lbl { font-weight: bold; color: #065f46; font-size: 12px; }
    .total-val { text-align: right; font-weight: bold; color: #16a34a; font-size: 15px; }

    /* ── Signature ── */
    .sig-row { display: table; width: 100%; margin-top: 36px; }
    .sig-cell { display: table-cell; width: 50%; text-align: center; vertical-align: bottom; }
    .sig-label { font-size: 9px; font-weight: bold; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px; }
    .sig-name  { font-size: 12px; font-weight: bold; color: #111827; margin-top: 8px; }
    .sig-role  { font-size: 10px; color: #9ca3af; margin-top: 2px; }
    .sig-line  { border-top: 1.5px dashed #d1d5db; width: 170px; margin: 0 auto; padding-top: 7px; }

    /* ── Footer ── */
    .pdf-footer {
      margin-top: 32px; padding-top: 12px;
      border-top: 1px solid #e5e7eb;
      text-align: center;
      font-size: 9px; color: #9ca3af; line-height: 1.8;
    }
    .pdf-footer strong { color: #374151; }

    /* ── Note ── */
    .note-box {
      background: #f9fafb; border: 1px solid #e5e7eb;
      border-left: 3px solid #d1d5db; border-radius: 6px;
      padding: 9px 12px; font-size: 11px; color: #374151;
      line-height: 1.6; font-style: italic;
    }
  </style>
</head>
<body>

  {{-- Header --}}
  <div class="header">
    <div class="header-left">
      <div class="company-name">AUTO X</div>
      <div class="company-sub">Showroom xe chính hãng – autox.vn</div>
    </div>
    <div class="header-right">
      <div class="invoice-title">HÓA ĐƠN THANH TOÁN</div>
      <div class="invoice-code">Mã: {{ $deposit->transaction_code }}</div>
      <div class="invoice-date">Ngày: {{ now()->format('d/m/Y') }}</div>
    </div>
  </div>

  {{-- Badges --}}
  <div class="badge-wrap">
    <span class="badge-stamp">✓ Đã xác nhận thanh toán</span>
  </div>
  <div class="badge-completed">🎉 Hoàn tất giao dịch</div>

  {{-- 2 cột thông tin --}}
  <div class="section">
    <div class="two-col">
      <div class="col-left">
        <div class="section-title">Thông tin khách hàng</div>
        <div class="field">
          <div class="field-label">Họ và tên</div>
          <div class="field-val">{{ $deposit->customer_name }}</div>
        </div>
        <div class="field">
          <div class="field-label">Số điện thoại</div>
          <div class="field-val">{{ $deposit->customer_phone }}</div>
        </div>
        @if($deposit->customer_email)
        <div class="field">
          <div class="field-label">Email</div>
          <div class="field-val">{{ $deposit->customer_email }}</div>
        </div>
        @endif
        @if($deposit->customer_id_card)
        <div class="field">
          <div class="field-label">CCCD / CMND</div>
          <div class="field-val">{{ $deposit->customer_id_card }}</div>
        </div>
        @endif
        @if($deposit->customer_address)
        <div class="field">
          <div class="field-label">Địa chỉ</div>
          <div class="field-val">{{ $deposit->customer_address }}</div>
        </div>
        @endif
      </div>

      <div class="col-right">
        <div class="section-title">Thông tin xe</div>
        <div class="field">
          <div class="field-label">Tên xe</div>
          <div class="field-val">{{ optional($deposit->car)->name ?? '—' }}</div>
        </div>
        @if(optional($deposit->car)->brand)
        <div class="field">
          <div class="field-label">Hãng xe</div>
          <div class="field-val">{{ $deposit->car->brand->name }}</div>
        </div>
        @endif
        @if($deposit->relationLoaded('color') && $deposit->color)
        <div class="field">
          <div class="field-label">Màu xe</div>
          <div class="field-val">{{ $deposit->color->name }}</div>
        </div>
        @endif
        @if(isset($deposit->assignedTo) && $deposit->assignedTo)
        <div class="field">
          <div class="field-label">Nhân viên phụ trách</div>
          <div class="field-val">{{ $deposit->assignedTo->name }}</div>
        </div>
        @endif
      </div>
    </div>
  </div>

  {{-- Bảng thanh toán --}}
  <div class="section">
    <div class="section-title">Chi tiết thanh toán</div>
    @php
      $pm = [
        'bank_transfer' => 'Chuyển khoản ngân hàng',
        'cash'          => 'Tiền mặt',
        'momo'          => 'Ví MoMo',
        'vnpay'         => 'VNPay',
      ];
    @endphp
    <table class="amount-table">
      <tr>
        <td class="lbl">Số tiền đặt cọc ban đầu</td>
        <td class="val">{{ number_format($deposit->deposit_amount) }} đ</td>
      </tr>
      <tr>
        <td class="lbl">Phương thức đặt cọc</td>
        <td class="val-muted">{{ $pm[$deposit->payment_method] ?? $deposit->payment_method }}</td>
      </tr>
      @if(!empty($deposit->final_amount))
      <tr>
        <td class="lbl">Thanh toán phần còn lại</td>
        <td class="val">{{ number_format($deposit->final_amount) }} đ</td>
      </tr>
      <tr>
        <td class="lbl">Phương thức thanh toán cuối</td>
        <td class="val-muted">{{ $pm[$deposit->final_payment_method] ?? ($deposit->final_payment_method ?? '—') }}</td>
      </tr>
      @endif
      <tr>
        <td class="lbl">Ngày hoàn tất</td>
        <td class="val-muted">
          {{ ($deposit->final_paid_at ?? now())->format('H:i · d/m/Y') }}
        </td>
      </tr>
      <tr class="total-row">
        <td class="total-lbl">TỔNG ĐÃ THANH TOÁN</td>
        <td class="total-val">{{ number_format(($deposit->deposit_amount ?? 0) + ($deposit->final_amount ?? 0)) }} đ</td>
      </tr>
    </table>
  </div>

  @if(!empty($deposit->final_payment_note))
  <div class="section">
    <div class="section-title">Ghi chú</div>
    <div class="note-box">{{ $deposit->final_payment_note }}</div>
  </div>
  @endif

  {{-- Chữ ký --}}
  <div class="sig-row">
    <div class="sig-cell">
      <div class="sig-label">Khách hàng</div>
      <div style="height:60px;"></div>
      <div class="sig-line"></div>
      <div class="sig-name">{{ $deposit->customer_name }}</div>
      <div class="sig-role">Bên mua</div>
    </div>
    <div class="sig-cell">
      <div class="sig-label">Kế toán / Đại diện AUTO X</div>
      @if(!empty($signatureSrc))
        <img src="{{ $signatureSrc }}" style="height:56px;max-width:150px;" alt="Chữ ký">
      @else
        <div style="height:60px;"></div>
      @endif
      <div class="sig-line"></div>
      <div class="sig-name">AUTO X Showroom</div>
      <div class="sig-role">Bên bán</div>
    </div>
  </div>

  {{-- Footer --}}
  <div class="pdf-footer">
    Hóa đơn này được tạo tự động bởi hệ thống AUTO X · autox.vn<br>
    Mọi thắc mắc vui lòng liên hệ: support@autox.vn<br>
    <strong>Xin cảm ơn quý khách đã tin tưởng AUTO X!</strong>
  </div>

</body>
</html>