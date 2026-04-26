@extends('layouts.admin')
@section('page-title', 'Tạo đơn hàng mới')

@section('topbar-actions')
  <a href="{{ route('admin.orders.index') }}" class="btn btn-sm">← Quay lại</a>
@endsection

@section('content')

@if($errors->any())
  <div class="alert alert-error" style="margin-bottom:16px">
    <strong>Vui lòng kiểm tra lại:</strong>
    <ul style="margin:6px 0 0 16px;font-size:13px">
      @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('admin.orders.store') }}">
  @csrf

  <div style="display:grid;grid-template-columns:1fr 320px;gap:16px;align-items:start">

    {{-- Cột trái --}}
    <div style="display:flex;flex-direction:column;gap:14px">

      {{-- Thông tin xe --}}
      <div class="card card-pad">
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px">
          <div style="width:28px;height:28px;background:#EAF3DE;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:14px">🚗</div>
          <span style="font-weight:600;font-size:15px">Xe khách hàng quan tâm</span>
        </div>

        <label style="font-size:12px;color:var(--text-muted);display:block;margin-bottom:6px">
          Chọn xe <span style="color:var(--danger)">*</span>
        </label>
        <select name="car_id" class="form-input" style="width:100%" required>
          <option value="">-- Chọn xe --</option>
          @foreach($cars as $car)
            <option value="{{ $car->id }}" @selected(old('car_id') == $car->id)>
              {{ $car->name }} – {{ number_format($car->price ?? 0, 0, ',', '.') }}đ
              @if($car->brand) ({{ $car->brand->name }}) @endif
            </option>
          @endforeach
        </select>
      </div>

      {{-- Thông tin khách hàng --}}
      <div class="card card-pad">
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px">
          <div style="width:28px;height:28px;background:#E6F1FB;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:14px">👤</div>
          <span style="font-weight:600;font-size:15px">Thông tin khách hàng</span>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
          <div>
            <label style="font-size:12px;color:var(--text-muted);display:block;margin-bottom:4px">
              Họ và tên <span style="color:var(--danger)">*</span>
            </label>
            <input type="text" name="customer_name" class="form-input" style="width:100%"
                   placeholder="Nguyễn Văn A"
                   value="{{ old('customer_name') }}" required>
          </div>
          <div>
            <label style="font-size:12px;color:var(--text-muted);display:block;margin-bottom:4px">
              Số điện thoại <span style="color:var(--danger)">*</span>
            </label>
            <input type="text" name="customer_phone" class="form-input" style="width:100%"
                   placeholder="0901234567"
                   value="{{ old('customer_phone') }}" required>
          </div>
          <div>
            <label style="font-size:12px;color:var(--text-muted);display:block;margin-bottom:4px">
              Email <span style="color:var(--danger)">*</span>
            </label>
            <input type="email" name="customer_email" class="form-input" style="width:100%"
                   placeholder="email@example.com"
                   value="{{ old('customer_email') }}" required>
          </div>
          <div>
            <label style="font-size:12px;color:var(--text-muted);display:block;margin-bottom:4px">
              Địa chỉ
            </label>
            <input type="text" name="customer_address" class="form-input" style="width:100%"
                   placeholder="Quận/Huyện, Tỉnh/TP"
                   value="{{ old('customer_address') }}">
          </div>
        </div>

        <div style="margin-top:12px">
          <label style="font-size:12px;color:var(--text-muted);display:block;margin-bottom:4px">
            Ghi chú tư vấn
          </label>
          <textarea name="note" class="form-input" rows="3"
                    style="width:100%;resize:vertical"
                    placeholder="Ghi chú nhu cầu, yêu cầu đặc biệt của khách...">{{ old('note') }}</textarea>
        </div>
      </div>

    </div>

    {{-- Cột phải --}}
    <div style="display:flex;flex-direction:column;gap:14px">

      {{-- Phân công nhân viên --}}
      <div class="card card-pad">
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px">
          <div style="width:28px;height:28px;background:#FAF0FB;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:14px">👨‍💼</div>
          <span style="font-weight:600;font-size:15px">Phân công</span>
        </div>

        <label style="font-size:12px;color:var(--text-muted);display:block;margin-bottom:4px">
          Nhân viên phụ trách
        </label>
        <select name="assigned_to" class="form-input" style="width:100%">
          <option value="">-- Chưa phân công --</option>
          @foreach($staffList as $s)
            <option value="{{ $s->id }}" @selected(old('assigned_to') == $s->id)>{{ $s->name }}</option>
          @endforeach
        </select>
        <p style="font-size:11px;color:var(--text-muted);margin-top:6px">
          Có thể phân công sau trong chi tiết đơn.
        </p>
      </div>

      {{-- Tóm tắt & submit --}}
      <div class="card card-pad" style="border:1.5px solid var(--primary)">
        <div style="font-weight:600;font-size:15px;color:var(--primary);margin-bottom:14px">📋 Xác nhận tạo đơn</div>

        <div id="order-summary" style="font-size:13px;color:var(--text-muted);margin-bottom:16px;display:flex;flex-direction:column;gap:6px">
          <div id="sum-car" style="display:none;padding:8px 10px;background:var(--surface2);border-radius:6px">
            🚗 <span id="sum-car-name" style="font-weight:500;color:var(--text-primary)"></span>
          </div>
          <div id="sum-customer" style="display:none;padding:8px 10px;background:var(--surface2);border-radius:6px">
            👤 <span id="sum-customer-name" style="font-weight:500;color:var(--text-primary)"></span>
            — <span id="sum-phone" style="color:var(--text-muted)"></span>
          </div>
          <div id="sum-empty" style="color:var(--text-muted)">Điền thông tin bên trái để xem tóm tắt.</div>
        </div>

        <div style="display:flex;flex-direction:column;gap:8px">
          <button type="submit" class="btn"
                  style="background:var(--primary);color:#fff;justify-content:center;padding:10px;font-size:14px">
            ✅ Tạo đơn hàng
          </button>
          <a href="{{ route('admin.orders.index') }}" class="btn"
             style="justify-content:center;text-align:center;background:var(--surface2)">
            Hủy
          </a>
        </div>
      </div>

    </div>
  </div>
</form>

<script>
const carSelect   = document.querySelector('[name=car_id]');
const nameInput   = document.querySelector('[name=customer_name]');
const phoneInput  = document.querySelector('[name=customer_phone]');

function updateSummary() {
  const carName      = carSelect.options[carSelect.selectedIndex]?.text;
  const customerName = nameInput.value.trim();
  const phone        = phoneInput.value.trim();
  const hasCar       = carSelect.value !== '';
  const hasCustomer  = customerName.length > 0;

  document.getElementById('sum-empty').style.display    = (!hasCar && !hasCustomer) ? 'block' : 'none';
  document.getElementById('sum-car').style.display      = hasCar ? 'block' : 'none';
  document.getElementById('sum-customer').style.display = hasCustomer ? 'block' : 'none';

  if (hasCar)       document.getElementById('sum-car-name').textContent      = carName;
  if (hasCustomer)  document.getElementById('sum-customer-name').textContent = customerName;
  if (phone)        document.getElementById('sum-phone').textContent         = phone;
}

carSelect.addEventListener('change', updateSummary);
nameInput.addEventListener('input',  updateSummary);
phoneInput.addEventListener('input', updateSummary);
</script>

@endsection