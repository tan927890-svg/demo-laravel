@extends('layouts.admin')
@section('page-title', 'Thanh toán đặt cọc · ' . $deposit->transaction_code)

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

.dp-wrap { font-family: 'Plus Jakarta Sans', sans-serif; max-width: 960px; margin: 0 auto; padding: 20px 16px 40px; }

/* Back link */
.dp-back {
  display: inline-flex; align-items: center; gap: 6px;
  font-size: 11px; font-weight: 700; letter-spacing: 1.5px;
  text-transform: uppercase; color: #9ca3af; text-decoration: none;
  margin-bottom: 16px;
}
.dp-back:hover { color: #374151; }

/* Header */
.dp-header {
  display: flex; align-items: flex-start; justify-content: space-between;
  flex-wrap: wrap; gap: 12px; margin-bottom: 20px;
}
.dp-title { font-size: 24px; font-weight: 800; color: #111827; margin: 0; }
.dp-sub   { font-size: 12px; color: #9ca3af; margin-top: 3px; }

/* Grid */
.dp-grid { display: grid; grid-template-columns: 1fr 340px; gap: 16px; align-items: start; }
@media (max-width: 768px) { .dp-grid { grid-template-columns: 1fr; } }

/* Cards */
.dp-card {
  background: #fff; border: 1px solid #e5e7eb;
  border-radius: 14px; overflow: hidden; margin-bottom: 14px;
}
.dp-card-head {
  padding: 12px 18px; border-bottom: 1px solid #f3f4f6;
  font-size: 11px; font-weight: 800; letter-spacing: 1.5px;
  text-transform: uppercase; color: #6b7280;
  display: flex; align-items: center; gap: 8px;
}
.dp-card-body { padding: 18px 18px; }

/* Field grid */
.dp-fields { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.dp-field-label { font-size: 10px; font-weight: 700; color: #9ca3af; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 4px; }
.dp-field-val   { font-size: 14px; font-weight: 600; color: #111827; }
.dp-field-val.muted { color: #9ca3af; }

/* Amount blocks */
.dp-amount-row {
  display: grid; grid-template-columns: 1fr 1fr 1fr;
  gap: 12px; margin-bottom: 18px;
}
@media (max-width: 480px) { .dp-amount-row { grid-template-columns: 1fr; } }

.dp-amount-block {
  border-radius: 12px; padding: 14px 16px; text-align: center;
}
.dp-amount-block .lbl { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; margin-bottom: 6px; }
.dp-amount-block .val { font-size: 20px; font-weight: 800; line-height: 1; }
.dp-amount-block.deposit  { background: #eff6ff; }
.dp-amount-block.deposit  .lbl { color: #3b82f6; }
.dp-amount-block.deposit  .val { color: #1d4ed8; }
.dp-amount-block.remaining{ background: #fef3c7; }
.dp-amount-block.remaining .lbl { color: #d97706; }
.dp-amount-block.remaining .val { color: #b45309; }
.dp-amount-block.total    { background: #f0fdf4; }
.dp-amount-block.total    .lbl { color: #16a34a; }
.dp-amount-block.total    .val { color: #15803d; }

/* QR section */
.dp-qr-wrap {
  display: flex; flex-direction: column; align-items: center;
  gap: 14px; padding: 20px;
}
.dp-qr-img {
  width: 220px; height: 220px; border-radius: 12px;
  border: 2px solid #e5e7eb; object-fit: contain; background: #fff;
}
.dp-bank-info {
  width: 100%; background: #f9fafb; border: 1px solid #e5e7eb;
  border-radius: 10px; padding: 14px 16px;
}
.dp-bank-row {
  display: flex; justify-content: space-between; align-items: center;
  padding: 6px 0; border-bottom: 1px solid #f3f4f6; font-size: 13px;
}
.dp-bank-row:last-child { border-bottom: none; }
.dp-bank-row .key { color: #9ca3af; font-weight: 500; }
.dp-bank-row .val { font-weight: 700; color: #111827; display: flex; align-items: center; gap: 6px; }

.copy-btn {
  background: #f3f4f6; border: none; border-radius: 5px;
  padding: 2px 7px; font-size: 11px; font-weight: 700; cursor: pointer;
  color: #374151; transition: background .15s;
}
.copy-btn:hover { background: #d1fae5; color: #065f46; }
.copy-btn.copied { background: #d1fae5; color: #065f46; }

/* Transfer content badge */
.dp-transfer-content {
  background: #eff6ff; border: 1.5px dashed #93c5fd;
  border-radius: 10px; padding: 12px 16px;
  font-size: 15px; font-weight: 800; color: #1d4ed8;
  letter-spacing: 1px; text-align: center; word-break: break-all;
  margin-bottom: 14px;
}

/* Status badge */
.dp-status {
  display: inline-block; padding: 6px 16px; border-radius: 20px;
  font-size: 11px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase;
}
.dp-status.pending   { background: #fef3c7; color: #92400e; border: 1.5px solid #fde68a; }
.dp-status.confirmed { background: #dbeafe; color: #1e40af; border: 1.5px solid #bfdbfe; }
.dp-status.completed { background: #d1fae5; color: #065f46; border: 1.5px solid #6ee7b7; }
.dp-status.cancelled { background: #fee2e2; color: #991b1b; border: 1.5px solid #fca5a5; }

/* Finalize form */
.dp-finalize-card {
  background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
  border: 2px solid #6ee7b7; border-radius: 14px; padding: 20px; margin-bottom: 14px;
}
.dp-finalize-title { font-size: 15px; font-weight: 800; color: #065f46; margin-bottom: 4px; }
.dp-finalize-sub   { font-size: 13px; color: #6b7280; margin-bottom: 16px; }

.dp-select {
  width: 100%; padding: 10px 12px; border: 1.5px solid #d1d5db;
  border-radius: 10px; font-size: 14px; font-family: inherit;
  color: #111827; background: #fff; outline: none; margin-bottom: 10px;
}
.dp-select:focus { border-color: #6ee7b7; }

.dp-textarea {
  width: 100%; padding: 10px 12px; border: 1.5px solid #d1d5db;
  border-radius: 10px; font-size: 13px; font-family: inherit;
  color: #111827; background: #fff; outline: none; resize: vertical;
  margin-bottom: 14px;
}
.dp-textarea:focus { border-color: #6ee7b7; }

.dp-confirm-btn {
  width: 100%; padding: 13px; background: #16a34a; color: #fff;
  border: none; border-radius: 10px; font-size: 14px; font-weight: 800;
  font-family: inherit; cursor: pointer; transition: background .15s;
  letter-spacing: .3px;
}
.dp-confirm-btn:hover { background: #15803d; }

/* Completed state */
.dp-completed-box {
  background: #d1fae5; border: 2px solid #34d399; border-radius: 14px;
  padding: 20px; text-align: center; margin-bottom: 14px;
}
.dp-completed-box .icon { font-size: 40px; margin-bottom: 8px; }
.dp-completed-box .title { font-size: 16px; font-weight: 800; color: #065f46; margin-bottom: 4px; }
.dp-completed-box .sub   { font-size: 13px; color: #047857; }

/* Alert */
.dp-alert-success {
  background: #d1fae5; border-left: 4px solid #16a34a;
  border-radius: 0 8px 8px 0; padding: 12px 16px;
  margin-bottom: 16px; font-size: 13px; color: #065f46; font-weight: 600;
}
.dp-alert-error {
  background: #fee2e2; border-left: 4px solid #dc2626;
  border-radius: 0 8px 8px 0; padding: 12px 16px;
  margin-bottom: 16px; font-size: 13px; color: #991b1b; font-weight: 600;
}

/* Car card (right col) */
.dp-car-card {
  background: #0d0d0f; border-radius: 14px; overflow: hidden; margin-bottom: 14px;
}
.dp-car-img  { width: 100%; height: 160px; object-fit: cover; display: block; }
.dp-car-body { padding: 16px 18px; }
.dp-car-name { font-size: 20px; font-weight: 800; color: #fff; letter-spacing: -.3px; margin-bottom: 4px; }
.dp-car-price { font-size: 18px; font-weight: 800; color: #f0c040; margin-bottom: 12px; }
.dp-car-badge {
  display: inline-block; font-size: 9px; font-weight: 800;
  letter-spacing: 2px; text-transform: uppercase;
  color: #f0c040; background: rgba(240,192,64,.15);
  border: 1px solid rgba(240,192,64,.3); padding: 3px 9px; border-radius: 3px;
  margin-bottom: 12px;
}

/* Confirm modal */
.dp-modal-overlay {
  display: none; position: fixed; inset: 0;
  background: rgba(0,0,0,.5); backdrop-filter: blur(3px);
  z-index: 9999; align-items: center; justify-content: center;
}
.dp-modal-overlay.open { display: flex; }
.dp-modal-box {
  background: #fff; border-radius: 16px; padding: 28px 24px;
  width: 100%; max-width: 400px; margin: 16px;
  animation: dpModalIn .2s ease;
}
@keyframes dpModalIn {
  from { opacity:0; transform:translateY(12px) scale(.97); }
  to   { opacity:1; transform:translateY(0) scale(1); }
}
.dp-modal-icon { width: 52px; height: 52px; border-radius: 50%; background: #d1fae5; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; font-size: 24px; }
.dp-modal-title { font-size: 16px; font-weight: 800; color: #111827; text-align: center; margin-bottom: 6px; }
.dp-modal-sub   { font-size: 13px; color: #6b7280; text-align: center; margin-bottom: 20px; line-height: 1.5; }
.dp-modal-amount {
  background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 10px;
  padding: 12px; text-align: center; margin-bottom: 20px;
}
.dp-modal-amount .lbl { font-size: 11px; color: #16a34a; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; }
.dp-modal-amount .num { font-size: 24px; font-weight: 800; color: #15803d; }
.dp-modal-actions { display: flex; gap: 10px; }
.dp-modal-cancel { flex:1; padding: 11px; border: 1.5px solid #e5e7eb; border-radius: 10px; background: #fff; font-size: 14px; font-weight: 700; color: #374151; cursor: pointer; font-family: inherit; }
.dp-modal-ok { flex:2; padding: 11px; border: none; border-radius: 10px; background: #16a34a; color: #fff; font-size: 14px; font-weight: 800; cursor: pointer; font-family: inherit; }
</style>

<div class="dp-wrap">

  <a href="{{ route('admin.staff.deposits.index') }}" class="dp-back">← Danh sách đặt cọc</a>

  {{-- Flash --}}
  @if(session('success'))
    <div class="dp-alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="dp-alert-error">{{ session('error') }}</div>
  @endif

  {{-- Header --}}
  <div class="dp-header">
    <div>
      <h1 class="dp-title">💳 {{ $deposit->transaction_code }}</h1>
      <div class="dp-sub">Tạo lúc {{ $deposit->created_at->format('H:i · d/m/Y') }}</div>
    </div>
    <span class="dp-status {{ $deposit->status }}">
      @switch($deposit->status)
        @case('pending')   ⏳ Chờ xác nhận @break
        @case('confirmed') ✅ Đã xác nhận  @break
        @case('completed') 🏁 Hoàn tất     @break
        @case('cancelled') ❌ Đã huỷ       @break
        @default {{ $deposit->status }}
      @endswitch
    </span>
  </div>

  <div class="dp-grid">

    {{-- ══ CỘT TRÁI ══ --}}
    <div>

      {{-- Tóm tắt số tiền --}}
      <div class="dp-amount-row">
        <div class="dp-amount-block deposit">
          <div class="lbl">Đã đặt cọc</div>
          <div class="val">{{ number_format($deposit->deposit_amount) }}<span style="font-size:13px;font-weight:500">₫</span></div>
        </div>
        <div class="dp-amount-block remaining">
          <div class="lbl">Còn cần thanh toán</div>
          <div class="val">{{ number_format($remainingAmount) }}<span style="font-size:13px;font-weight:500">₫</span></div>
        </div>
        <div class="dp-amount-block total">
          <div class="lbl">Tổng giá trị xe</div>
          <div class="val">{{ $carPrice > 0 ? number_format($carPrice) : '—' }}<span style="font-size:13px;font-weight:500">{{ $carPrice > 0 ? '₫' : '' }}</span></div>
        </div>
      </div>

      {{-- ══ FORM + QR (gộp chung, chỉ hiện khi chưa completed/cancelled và còn tiền) ══ --}}
      @if(
          $deposit->status !== 'completed' &&
          $deposit->status !== 'cancelled' &&
          $remainingAmount > 0
      )

        {{-- QR card — chỉ hiện khi chọn bank_transfer hoặc momo, ẩn mặc định --}}
        @if(in_array($deposit->payment_method, ['bank_transfer', 'momo']))
        <div class="dp-card" id="qr-card" style="display:none">
          <div class="dp-card-head">📱 Mã QR chuyển khoản — Số tiền còn lại</div>
          <div class="dp-qr-wrap">

            {{-- Nội dung chuyển khoản --}}
            <div style="width:100%">
              <div class="dp-field-label" style="margin-bottom:6px">Nội dung chuyển khoản</div>
              <div class="dp-transfer-content" id="transfer-content">{{ $transferContent }}</div>
            </div>

            {{-- QR --}}
            @if($vietQrUrl)
              <img src="{{ $vietQrUrl }}" alt="QR Code" class="dp-qr-img"
                   onerror="this.style.display='none';document.getElementById('qr-fallback').style.display='flex'">
              <div id="qr-fallback" style="display:none;width:220px;height:220px;border-radius:12px;border:2px dashed #e5e7eb;align-items:center;justify-content:center;color:#9ca3af;font-size:12px;text-align:center;padding:20px">
                Không tải được QR.<br>Dùng thông tin bên dưới.
              </div>
            @endif

            {{-- Thông tin tài khoản --}}
            <div class="dp-bank-info">
              @foreach([
                ['Ngân hàng', $bank['bank_name'], false],
                ['Số tài khoản', $bank['bank_account'], true],
                ['Chủ tài khoản', $bank['bank_owner'], false],
                ['Số tiền', number_format($remainingAmount) . ' ₫', true],
                ['Nội dung CK', $transferContent, true],
              ] as [$key, $val, $copyable])
              <div class="dp-bank-row">
                <span class="key">{{ $key }}</span>
                <span class="val">
                  {{ $val }}
                  @if($copyable)
                    <button class="copy-btn" onclick="copyText(this, '{{ addslashes($val) }}')">Copy</button>
                  @endif
                </span>
              </div>
              @endforeach
            </div>

          </div>
        </div>
        @endif

        {{-- Form xác nhận — dùng chung cho mọi phương thức --}}
        <div class="dp-finalize-card">
          <div class="dp-finalize-title">✅ Xác nhận đã nhận đủ thanh toán</div>
          <div class="dp-finalize-sub">Sau khi khách thanh toán thành công, chọn phương thức và nhấn xác nhận.</div>

          <form id="finalizeForm" action="{{ route('admin.staff.deposits.finalize', $deposit) }}" method="POST">
            @csrf
            <label class="dp-field-label" style="margin-bottom:6px;display:block">Phương thức khách thanh toán phần còn lại *</label>
            <select name="final_payment_method" class="dp-select" required id="payment-method-select"
                    onchange="toggleQR(this.value)">
              <option value="">-- Chọn phương thức --</option>
              <option value="bank_transfer" {{ $deposit->payment_method === 'bank_transfer' ? 'selected' : '' }}>🏦 Chuyển khoản ngân hàng</option>
              <option value="cash"          {{ $deposit->payment_method === 'cash'          ? 'selected' : '' }}>💵 Tiền mặt tại showroom</option>
              <option value="momo"          {{ $deposit->payment_method === 'momo'          ? 'selected' : '' }}>💜 Ví MoMo</option>
              <option value="vnpay"         {{ $deposit->payment_method === 'vnpay'         ? 'selected' : '' }}>💳 VNPay</option>
            </select>

            <label class="dp-field-label" style="margin-bottom:6px;display:block">Ghi chú (không bắt buộc)</label>
            <textarea name="final_payment_note" class="dp-textarea" rows="2"
                      placeholder="VD: Khách chuyển khoản lúc 14:35, mã GD MB093824..."></textarea>

            <button type="button" class="dp-confirm-btn" onclick="openConfirmModal()">
              🎉 Xác nhận hoàn tất — Thu {{ number_format($remainingAmount) }} ₫
            </button>
          </form>
        </div>

      @endif
      {{-- ══ END FORM + QR ══ --}}

      {{-- Đã hoàn tất --}}
      @if($deposit->status === 'completed')
      <div class="dp-completed-box">
        <div class="icon">🎉</div>
        <div class="title">Giao dịch hoàn tất!</div>
        <div class="sub">
          Khách đã thanh toán đủ
          @if($deposit->final_paid_at)· Xác nhận lúc {{ $deposit->final_paid_at->format('H:i d/m/Y') }}@endif
          @if($deposit->finalizedBy)· Bởi {{ $deposit->finalizedBy->name }}@endif
        </div>
        @if($deposit->final_amount)
        <div style="margin-top:10px;font-size:14px;font-weight:700;color:#065f46">
          Số tiền nhận thêm: {{ number_format($deposit->final_amount) }} ₫
        </div>
        @endif
        @if($deposit->final_payment_method)
        <div style="margin-top:4px;font-size:13px;color:#047857">
          Phương thức: {{ ['bank_transfer'=>'Chuyển khoản','cash'=>'Tiền mặt','momo'=>'MoMo','vnpay'=>'VNPay'][$deposit->final_payment_method] ?? $deposit->final_payment_method }}
        </div>
        @endif
        @if($deposit->final_payment_note)
        <div style="margin-top:8px;font-size:13px;color:#6b7280;font-style:italic">
          "{{ $deposit->final_payment_note }}"
        </div>
        @endif
      </div>
      @endif

      {{-- Thông tin khách hàng --}}
      <div class="dp-card">
        <div class="dp-card-head">👤 Thông tin khách hàng</div>
        <div class="dp-card-body">
          <div class="dp-fields">
            @foreach([
              ['Họ và tên', $deposit->customer_name, true],
              ['Số điện thoại', $deposit->customer_phone, false],
              ['Email', $deposit->customer_email, false],
              ['CCCD / CMND', $deposit->customer_id_card ?: '—', false],
              ['Địa chỉ', $deposit->customer_address ?: '—', false],
            ] as [$label, $val, $full])
            <div style="{{ $full ? 'grid-column:1/-1' : '' }}">
              <div class="dp-field-label">{{ $label }}</div>
              <div class="dp-field-val {{ $val === '—' ? 'muted' : '' }}">{{ $val }}</div>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      {{-- Chi tiết đặt cọc --}}
      <div class="dp-card">
        <div class="dp-card-head">💰 Chi tiết đặt cọc</div>
        <div class="dp-card-body">
          <div class="dp-fields">
            <div>
              <div class="dp-field-label">Mã giao dịch</div>
              <code style="font-size:13px;color:#1d4ed8;background:#eff6ff;padding:3px 10px;border-radius:5px;font-weight:700">{{ $deposit->transaction_code }}</code>
            </div>
            <div>
              <div class="dp-field-label">Phương thức đặt cọc</div>
              <div class="dp-field-val">{{ ['bank_transfer'=>'🏦 Chuyển khoản','cash'=>'💵 Tiền mặt','momo'=>'💜 MoMo','vnpay'=>'💳 VNPay'][$deposit->payment_method] ?? $deposit->payment_method }}</div>
            </div>
            @if($deposit->color)
            <div>
              <div class="dp-field-label">Màu xe chọn</div>
              <div class="dp-field-val" style="display:flex;align-items:center;gap:6px">
                <span style="width:14px;height:14px;border-radius:50%;background:{{ $deposit->color->hex_code ?? '#ccc' }};border:1.5px solid rgba(0,0,0,.1);flex-shrink:0"></span>
                {{ $deposit->color->name }}
              </div>
            </div>
            @endif
            <div>
              <div class="dp-field-label">Ngày đặt cọc</div>
              <div class="dp-field-val">{{ $deposit->created_at->format('H:i · d/m/Y') }}</div>
            </div>
            @if($deposit->note)
            <div style="grid-column:1/-1">
              <div class="dp-field-label">Ghi chú của khách</div>
              <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:10px 12px;font-size:13px;color:#374151;line-height:1.6">{{ $deposit->note }}</div>
            </div>
            @endif
          </div>
          @if($deposit->staff_note)
          <div style="margin-top:14px;padding-top:14px;border-top:1px solid #f3f4f6">
            <div class="dp-field-label">📋 Ghi chú từ Admin / Manager</div>
            <div style="background:#fef3c7;border:1px solid #fde68a;border-radius:8px;padding:10px 12px;font-size:13px;color:#92400e;line-height:1.6">{{ $deposit->staff_note }}</div>
          </div>
          @endif
        </div>
      </div>

    </div>

    {{-- ══ CỘT PHẢI ══ --}}
    <div style="position:sticky;top:80px">

      {{-- Xe --}}
      @if($deposit->car)
      @php
        $car    = $deposit->car;
        $carImg = null;
        $defColor = $car->colors->firstWhere('is_default', true) ?? $car->colors->first();
        if ($defColor?->image) {
          $segs   = explode('/', ltrim($defColor->image, '/'));
          $carImg = asset(implode('/', array_map(fn($s) => rawurlencode(rawurldecode($s)), $segs)));
        }
        if (!$carImg) {
          $gal = $car->galleries->where('type','image')->sortBy('sort_order')->first();
          if ($gal?->file_path) {
            $segs   = explode('/', ltrim($gal->file_path, '/'));
            $carImg = asset(implode('/', array_map(fn($s) => rawurlencode(rawurldecode($s)), $segs)));
          }
        }
      @endphp
      <div class="dp-car-card">
        @if($carImg)
          <img src="{{ $carImg }}" alt="{{ $car->name }}" class="dp-car-img">
        @else
          <div style="height:100px;background:#1a1a1a;display:flex;align-items:center;justify-content:center">
            <span style="font-size:10px;color:rgba(255,255,255,.15);letter-spacing:3px;text-transform:uppercase">{{ $car->name }}</span>
          </div>
        @endif
        <div class="dp-car-body">
          @if($car->brand?->name)
            <div class="dp-car-badge">{{ $car->brand->name }}</div>
          @endif
          <div class="dp-car-name">{{ $car->name }}</div>
          @if($carPrice > 0)
            <div class="dp-car-price">{{ number_format($carPrice) }} <span style="font-size:12px;color:rgba(240,192,64,.6);font-weight:500">₫</span></div>
          @endif
        </div>
      </div>
      @endif

      {{-- Phân công --}}
      <div class="dp-card">
        <div class="dp-card-head">👷 Nhân viên phụ trách</div>
        <div class="dp-card-body">
          @if($deposit->assignedTo)
            <div style="display:flex;align-items:center;gap:10px">
              <div style="width:38px;height:38px;border-radius:50%;background:#d1fae5;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0">👤</div>
              <div>
                <div style="font-weight:700;color:#111827">{{ $deposit->assignedTo->name }}</div>
                <div style="font-size:12px;color:#9ca3af">{{ ucfirst($deposit->assignedTo->role) }}</div>
              </div>
            </div>
          @else
            <div style="font-size:13px;color:#9ca3af">Chưa phân công</div>
          @endif
        </div>
      </div>

      {{-- Timeline --}}
      <div class="dp-card">
        <div class="dp-card-head">🕐 Lịch sử</div>
        <div class="dp-card-body" style="padding:14px 18px">
          <div style="display:flex;flex-direction:column;gap:0">
            @php
              $timeline = [
                ['icon'=>'📝','label'=>'Khách đặt cọc','time'=>$deposit->created_at,'color'=>'#6b7280'],
              ];
              if ($deposit->confirmed_at)
                $timeline[] = ['icon'=>'✅','label'=>'Admin xác nhận','time'=>$deposit->confirmed_at,'color'=>'#2563eb'];
              if ($deposit->assignedTo)
                $timeline[] = ['icon'=>'👷','label'=>'Phân công: '.$deposit->assignedTo->name,'time'=>$deposit->updated_at,'color'=>'#d97706'];
              if ($deposit->final_paid_at)
                $timeline[] = ['icon'=>'🎉','label'=>'Hoàn tất thanh toán','time'=>$deposit->final_paid_at,'color'=>'#16a34a'];
            @endphp
            @foreach($timeline as $i => $ev)
            <div style="display:flex;gap:10px;align-items:flex-start;{{ !$loop->last ? 'padding-bottom:12px;border-bottom:1px solid #f3f4f6;margin-bottom:12px' : '' }}">
              <span style="font-size:16px;flex-shrink:0">{{ $ev['icon'] }}</span>
              <div>
                <div style="font-size:13px;font-weight:600;color:{{ $ev['color'] }}">{{ $ev['label'] }}</div>
                <div style="font-size:11px;color:#9ca3af">{{ $ev['time']->format('H:i · d/m/Y') }}</div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

{{-- Confirm Modal --}}
<div id="dp-confirm-modal" class="dp-modal-overlay">
  <div class="dp-modal-box">
    <div class="dp-modal-icon">🎉</div>
    <div class="dp-modal-title">Xác nhận đã nhận đủ tiền?</div>
    <div class="dp-modal-sub">
      Thao tác này sẽ đánh dấu giao dịch <strong>{{ $deposit->transaction_code }}</strong>
      là hoàn tất và không thể hoàn tác.
    </div>
    <div class="dp-modal-amount">
      <div class="lbl">Số tiền xác nhận thu</div>
      <div class="num">{{ number_format($remainingAmount) }} ₫</div>
    </div>
    <div class="dp-modal-actions">
      <button class="dp-modal-cancel" onclick="closeConfirmModal()">Hủy bỏ</button>
      <button class="dp-modal-ok" onclick="submitFinalize()">✅ Xác nhận</button>
    </div>
  </div>
</div>

<script>
function copyText(btn, text) {
  var clean = text.includes('₫') ? text.replace(/[^0-9]/g, '') : text;
  navigator.clipboard.writeText(clean).then(function() {
    btn.textContent = '✓';
    btn.classList.add('copied');
    setTimeout(function() { btn.textContent = 'Copy'; btn.classList.remove('copied'); }, 2000);
  }).catch(function() {
    var ta = document.createElement('textarea');
    ta.value = clean; document.body.appendChild(ta);
    ta.select(); document.execCommand('copy'); document.body.removeChild(ta);
    btn.textContent = '✓'; btn.classList.add('copied');
    setTimeout(function() { btn.textContent = 'Copy'; btn.classList.remove('copied'); }, 2000);
  });
}

// Toggle hiện/ẩn QR card theo phương thức thanh toán
function toggleQR(val) {
  var qrCard = document.getElementById('qr-card');
  if (!qrCard) return;
  qrCard.style.display = (val === 'bank_transfer' || val === 'momo') ? 'block' : 'none';
}

// Chạy ngay khi load để sync với giá trị pre-selected (nếu có)
document.addEventListener('DOMContentLoaded', function() {
  var sel = document.getElementById('payment-method-select');
  if (sel) toggleQR(sel.value);
});

function openConfirmModal() {
  var sel = document.querySelector('select[name=final_payment_method]');
  if (!sel.value) { sel.focus(); sel.style.borderColor = '#f87171'; return; }
  sel.style.borderColor = '';
  document.getElementById('dp-confirm-modal').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeConfirmModal() {
  document.getElementById('dp-confirm-modal').classList.remove('open');
  document.body.style.overflow = '';
}
function submitFinalize() {
  closeConfirmModal();
  document.getElementById('finalizeForm').submit();
}
document.getElementById('dp-confirm-modal').addEventListener('click', function(e) {
  if (e.target === this) closeConfirmModal();
});
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeConfirmModal(); });
</script>

@endsection