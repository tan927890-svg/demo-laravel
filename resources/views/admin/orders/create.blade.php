@extends('layouts.admin')
@section('page-title', 'Tạo đơn hàng mới')

@section('topbar-actions')
  <a href="{{ route('admin.orders.index') }}" class="btn btn-sm">← Quay lại</a>
@endsection

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.co-wrap {
    font-family: 'Inter', sans-serif;
    max-width: 1080px;
    padding: 24px 20px;
}
.co-wrap *, .co-wrap *::before, .co-wrap *::after { box-sizing: border-box; }

.co-grid {
    display: grid;
    grid-template-columns: 1fr 308px;
    gap: 18px;
    align-items: start;
}

.co-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 16px;
}
.co-card:last-child { margin-bottom: 0; }

.co-card-head {
    padding: 13px 18px;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
    gap: 10px;
    background: #fafafa;
}
.co-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.co-icon svg { width: 18px; height: 18px; display: block; }
.co-icon-amber  { background: #fef3c7; }
.co-icon-blue   { background: #dbeafe; }
.co-icon-purple { background: #ede9fe; }

.co-card-title {
    font-size: 14px; font-weight: 600; color: #111827;
}

.co-card-body { padding: 18px; }

.co-field { margin-bottom: 14px; }
.co-field:last-child { margin-bottom: 0; }

.co-label {
    display: block;
    font-size: 11.5px; font-weight: 600;
    color: #6b7280;
    text-transform: uppercase; letter-spacing: .45px;
    margin-bottom: 6px;
}
.co-req { color: #ef4444; margin-left: 2px; }

.co-input, .co-select, .co-textarea {
    width: 100%;
    padding: 9px 12px;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
    color: #111827;
    background: #fff;
    outline: none;
    transition: border-color .15s, box-shadow .15s;
    line-height: 1.5;
}
.co-input:focus, .co-select:focus, .co-textarea:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,.1);
}
.co-input::placeholder, .co-textarea::placeholder { color: #c9ced6; }
.co-textarea { resize: vertical; min-height: 82px; }

.co-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.co-submit {
    background: linear-gradient(150deg, #1e1b4b 0%, #3730a3 100%);
    border-radius: 12px;
    padding: 18px;
    margin-bottom: 16px;
}
.co-submit-label {
    font-size: 11px; font-weight: 700;
    color: rgba(255,255,255,.5);
    text-transform: uppercase; letter-spacing: .7px;
    margin-bottom: 12px;
}
.co-summary {
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 9px;
    padding: 11px 13px;
    margin-bottom: 14px;
    min-height: 62px;
    display: flex; flex-direction: column; gap: 7px;
}
.co-sum-row {
    display: flex; align-items: flex-start; gap: 8px;
    font-size: 13px;
}
.co-sum-row .ico {
    width: 22px; height: 22px; flex-shrink: 0; margin-top: 1px;
    background: rgba(255,255,255,.15);
    border-radius: 5px;
    display: flex; align-items: center; justify-content: center;
}
.co-sum-row .ico svg { width: 12px; height: 12px; }
.co-sum-row .val { color: rgba(255,255,255,.92); font-weight: 500; font-size: 13px; line-height: 1.4; }
.co-sum-empty {
    font-size: 12.5px; color: rgba(255,255,255,.35);
    font-style: italic; text-align: center;
    padding: 8px 0;
}

.co-btn-primary {
    width: 100%;
    padding: 11px;
    background: #4f46e5;
    color: #fff;
    border: none;
    border-radius: 9px;
    font-size: 14px; font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    transition: background .15s, transform .1s;
    margin-bottom: 8px;
    letter-spacing: -.1px;
}
.co-btn-primary:hover { background: #4338ca; transform: translateY(-1px); }
.co-btn-primary:active { transform: none; }

.co-btn-ghost {
    width: 100%;
    padding: 9px;
    background: rgba(255,255,255,.08);
    color: rgba(255,255,255,.65);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 9px;
    font-size: 13px; font-weight: 500;
    font-family: inherit;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    display: block;
    transition: background .15s;
}
.co-btn-ghost:hover { background: rgba(255,255,255,.14); color: #fff; }

.co-assign {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
}
.co-assign-head {
    padding: 13px 18px;
    border-bottom: 1px solid #f0f0f0;
    background: #fafafa;
    display: flex; align-items: center; gap: 10px;
}
.co-assign-body { padding: 16px 18px; }
.co-hint { font-size: 11.5px; color: #9ca3af; margin-top: 7px; line-height: 1.5; }

.co-alert {
    background: #fef2f2; border: 1px solid #fecaca;
    border-radius: 10px; padding: 12px 16px;
    margin-bottom: 16px; font-size: 13px; color: #dc2626;
}
.co-alert strong { display: block; font-weight: 700; margin-bottom: 5px; }
.co-alert ul { margin: 0; padding-left: 18px; }
.co-alert li { margin-bottom: 2px; }

/* ── Custom Modal ── */
.co-modal-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.45);
    z-index: 9999;
    align-items: center; justify-content: center;
    padding: 16px;
}
.co-modal-overlay.active { display: flex; }

.co-modal {
    background: #fff;
    border-radius: 20px;
    padding: 32px 28px 24px;
    max-width: 400px; width: 100%;
    box-shadow: 0 24px 80px rgba(0,0,0,.2);
    animation: modalIn .18s ease;
}
@keyframes modalIn {
    from { opacity:0; transform: scale(.95) translateY(8px); }
    to   { opacity:1; transform: scale(1)  translateY(0); }
}

.co-modal-icon {
    width: 56px; height: 56px;
    border-radius: 16px;
    background: #eef2ff;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
    font-size: 26px;
}
.co-modal-title {
    font-size: 17px; font-weight: 800;
    color: #111827; text-align: center;
    margin-bottom: 8px;
}
.co-modal-body {
    font-size: 13.5px; color: #6b7280;
    text-align: center; line-height: 1.65;
    margin-bottom: 24px;
}
.co-modal-body b { color: #111827; }

.co-modal-actions {
    display: flex; gap: 10px;
}
.co-modal-cancel {
    flex: 1; padding: 10px;
    background: #f3f4f6; color: #374151;
    border: none; border-radius: 10px;
    font-size: 14px; font-weight: 600;
    font-family: inherit; cursor: pointer;
    transition: background .15s;
}
.co-modal-cancel:hover { background: #e5e7eb; }

.co-modal-confirm {
    flex: 1; padding: 10px;
    background: #4f46e5; color: #fff;
    border: none; border-radius: 10px;
    font-size: 14px; font-weight: 600;
    font-family: inherit; cursor: pointer;
    transition: background .15s;
}
.co-modal-confirm:hover { background: #4338ca; }

@media (max-width: 768px) {
    .co-grid { grid-template-columns: 1fr; }
    .co-row  { grid-template-columns: 1fr; }
    .co-wrap { padding: 14px; }
}
</style>

<div class="co-wrap">

    @if($errors->any())
    <div class="co-alert">
        <strong>⚠ Vui lòng kiểm tra lại:</strong>
        <ul>
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.orders.store') }}" id="co-form">
    @csrf

    <div class="co-grid">

        {{-- Cột trái --}}
        <div>

            {{-- Xe --}}
            <div class="co-card">
                <div class="co-card-head">
                    <div class="co-icon co-icon-amber">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 17H3v-5l2-5h14l2 5v5h-2"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="16.5" cy="17.5" r="1.5"/><path d="M5 12h14"/>
                        </svg>
                    </div>
                    <div class="co-card-title">Xe khách hàng quan tâm</div>
                </div>
                <div class="co-card-body">
                    <div class="co-field">
                        <label class="co-label">Chọn xe <span class="co-req">*</span></label>
                        <select name="car_id" class="co-select" required>
                            <option value="">-- Chọn xe --</option>
                            @foreach($cars as $car)
                                <option value="{{ $car->id }}" @selected(old('car_id') == $car->id)>
                                    {{ $car->name }}
                                    @if($car->sale_price)
                                        – {{ number_format($car->sale_price, 0, ',', '.') }}đ
                                    @elseif($car->cost_price)
                                        – {{ number_format($car->cost_price, 0, ',', '.') }}đ
                                    @endif
                                    @if($car->brand) ({{ $car->brand->name }}) @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Khách hàng --}}
            <div class="co-card">
                <div class="co-card-head">
                    <div class="co-icon co-icon-blue">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                        </svg>
                    </div>
                    <div class="co-card-title">Thông tin khách hàng</div>
                </div>
                <div class="co-card-body">
                    <div class="co-row">
                        <div class="co-field">
                            <label class="co-label">Họ và tên <span class="co-req">*</span></label>
                            <input type="text" name="customer_name" class="co-input"
                                   placeholder="Nguyễn Văn A"
                                   value="{{ old('customer_name') }}" required>
                        </div>
                        <div class="co-field">
                            <label class="co-label">Số điện thoại <span class="co-req">*</span></label>
                            <input type="text" name="customer_phone" class="co-input"
                                   placeholder="0901 234 567"
                                   value="{{ old('customer_phone') }}" required>
                        </div>
                        <div class="co-field">
                            <label class="co-label">Email <span class="co-req">*</span></label>
                            <input type="email" name="customer_email" class="co-input"
                                   placeholder="email@example.com"
                                   value="{{ old('customer_email') }}" required>
                        </div>
                        <div class="co-field">
                            <label class="co-label">Địa chỉ</label>
                            <input type="text" name="customer_address" class="co-input"
                                   placeholder="Quận/Huyện, Tỉnh/TP"
                                   value="{{ old('customer_address') }}">
                        </div>
                    </div>
                    <div class="co-field" style="margin-top:4px">
                        <label class="co-label">Ghi chú tư vấn</label>
                        <textarea name="note" class="co-textarea"
                                  placeholder="Ghi chú nhu cầu, yêu cầu đặc biệt của khách...">{{ old('note') }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        {{-- Cột phải --}}
        <div>

            {{-- Submit --}}
            <div class="co-submit">
                <div class="co-submit-label">📋 Xác nhận tạo đơn</div>
                <div class="co-summary">
                    <div class="co-sum-empty" id="sum-empty">Điền thông tin để xem tóm tắt</div>
                    <div class="co-sum-row" id="sum-car" style="display:none">
                        <span class="ico">
                            <svg viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.9)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 17H3v-5l2-5h14l2 5v5h-2"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="16.5" cy="17.5" r="1.5"/>
                            </svg>
                        </span>
                        <span class="val" id="sum-car-name"></span>
                    </div>
                    <div class="co-sum-row" id="sum-customer" style="display:none">
                        <span class="ico">
                            <svg viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.9)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                            </svg>
                        </span>
                        <span class="val">
                            <span id="sum-customer-name"></span>
                            <span id="sum-phone" style="opacity:.6;font-size:12px;margin-left:4px"></span>
                        </span>
                    </div>
                </div>

                {{-- Nút bấm gọi modal thay vì submit thẳng --}}
                <button type="button" class="co-btn-primary" id="btn-open-confirm">
                    ✅ Tạo đơn hàng
                </button>
                <a href="{{ route('admin.orders.index') }}" class="co-btn-ghost">Hủy bỏ</a>
            </div>

            {{-- Phân công --}}
            <div class="co-assign">
                <div class="co-assign-head">
                    <div class="co-icon co-icon-purple">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/><path d="M16 3l2 2 4-4"/>
                        </svg>
                    </div>
                    <div class="co-card-title">Phân công nhân viên</div>
                </div>
                <div class="co-assign-body">
                    <div class="co-field">
                        <label class="co-label">Nhân viên phụ trách</label>
                        <select name="assigned_to" class="co-select">
                            <option value="">-- Chưa phân công --</option>
                            @foreach($staffList as $s)
                                <option value="{{ $s->id }}" @selected(old('assigned_to') == $s->id)>{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="co-hint">💡 Có thể phân công sau trong trang chi tiết đơn hàng.</p>
                </div>
            </div>

        </div>
    </div>
    </form>

</div>

{{-- Custom Confirm Modal --}}
<div class="co-modal-overlay" id="co-modal-overlay">
    <div class="co-modal">
        <div class="co-modal-icon">🚗</div>
        <div class="co-modal-title">Xác nhận tạo đơn hàng</div>
        <div class="co-modal-body" id="co-modal-body">
            Bạn có chắc chắn muốn tạo đơn hàng này không?
        </div>
        <div class="co-modal-actions">
            <button type="button" class="co-modal-cancel" id="co-modal-cancel">Huỷ bỏ</button>
            <button type="button" class="co-modal-confirm" id="co-modal-confirm">✅ Xác nhận tạo</button>
        </div>
    </div>
</div>

<script>
const carSelect  = document.querySelector('[name=car_id]');
const nameInput  = document.querySelector('[name=customer_name]');
const phoneInput = document.querySelector('[name=customer_phone]');
const form       = document.getElementById('co-form');
const overlay    = document.getElementById('co-modal-overlay');
const modalBody  = document.getElementById('co-modal-body');

function updateSummary() {
    const carName      = carSelect.options[carSelect.selectedIndex]?.text?.trim();
    const customerName = nameInput.value.trim();
    const phone        = phoneInput.value.trim();
    const hasCar       = carSelect.value !== '';
    const hasCustomer  = customerName.length > 0;

    document.getElementById('sum-empty').style.display    = (!hasCar && !hasCustomer) ? 'block' : 'none';
    document.getElementById('sum-car').style.display      = hasCar ? 'flex' : 'none';
    document.getElementById('sum-customer').style.display = hasCustomer ? 'flex' : 'none';

    if (hasCar)      document.getElementById('sum-car-name').textContent      = carName;
    if (hasCustomer) document.getElementById('sum-customer-name').textContent = customerName;
    document.getElementById('sum-phone').textContent = phone ? '· ' + phone : '';
}

carSelect.addEventListener('change', updateSummary);
nameInput.addEventListener('input',  updateSummary);
phoneInput.addEventListener('input', updateSummary);

// Mở modal xác nhận
document.getElementById('btn-open-confirm').addEventListener('click', function () {
    const carName      = carSelect.options[carSelect.selectedIndex]?.text?.trim();
    const customerName = nameInput.value.trim();
    const phone        = phoneInput.value.trim();

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    let bodyHtml = 'Bạn sắp tạo đơn hàng mới';
    if (customerName) bodyHtml += ' cho khách <b>' + customerName + '</b>';
    if (phone)        bodyHtml += ' <span style="color:#9ca3af">(' + phone + ')</span>';
    if (carName && carSelect.value) bodyHtml += ',<br>quan tâm xe <b>' + carName + '</b>';
    bodyHtml += '.<br><span style="font-size:12.5px;color:#9ca3af">Vui lòng kiểm tra lại trước khi xác nhận.</span>';

    modalBody.innerHTML = bodyHtml;
    overlay.classList.add('active');
});

// Xác nhận → submit form
document.getElementById('co-modal-confirm').addEventListener('click', function () {
    overlay.classList.remove('active');
    form.submit();
});

// Huỷ
document.getElementById('co-modal-cancel').addEventListener('click', function () {
    overlay.classList.remove('active');
});

// Click ngoài modal
overlay.addEventListener('click', function (e) {
    if (e.target === overlay) overlay.classList.remove('active');
});
</script>

@endsection