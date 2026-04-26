@extends('layouts.admin')
@section('page-title', 'Tạo đơn hàng mới')

@section('topbar-actions')
  @if(request('assigned_to'))
    <a href="{{ route('admin.kpi.show', request('assigned_to')) }}" class="btn btn-sm">← Quay lại KPI</a>
  @else
    <a href="{{ route('admin.staff.orders.index') }}" class="btn btn-sm">← Quay lại</a>
  @endif
@endsection

@section('content')

@if($errors->any())
  <div class="alert alert-error" style="margin-bottom:16px">
    <strong>Vui lòng kiểm tra lại:</strong>
    <ul style="margin:6px 0 0 16px;font-size:13px">
      @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('admin.staff.orders.store') }}">
  @csrf

  {{-- Truyền assigned_to nếu Manager tạo đơn cho nhân viên cụ thể --}}
  @if(request('assigned_to'))
    <input type="hidden" name="assigned_to" value="{{ request('assigned_to') }}">
  @endif

  <div style="display:flex;flex-direction:column;gap:16px;max-width:860px">

    {{-- Xe --}}
    <div class="card card-pad">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:18px;padding-bottom:14px;border-bottom:1px solid var(--border)">
        <div style="width:36px;height:36px;background:#E8F5E9;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0">🚗</div>
        <div>
          <div style="font-weight:700;font-size:14px">Xe khách hàng quan tâm</div>
          <div style="font-size:12px;color:var(--text-2);margin-top:2px">Chọn xe muốn tư vấn</div>
        </div>
      </div>

      <div>
        <label class="form-label">Chọn xe <span style="color:var(--danger)">*</span></label>
        <select name="car_id" class="form-control" required>
          <option value="">-- Chọn xe --</option>
          @foreach($cars as $car)
            <option value="{{ $car->id }}" @selected(old('car_id') == $car->id)>
              {{ $car->brand->name ?? '' }} {{ $car->name }}
             — {{ number_format($car->price_per_day ?? 0, 0, ',', '.') }}đ
            </option>
          @endforeach
        </select>
        @error('car_id')
          <div style="color:var(--danger);font-size:12px;margin-top:5px">{{ $message }}</div>
        @enderror
      </div>
    </div>

    {{-- Khách hàng --}}
    <div class="card card-pad">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:18px;padding-bottom:14px;border-bottom:1px solid var(--border)">
        <div style="width:36px;height:36px;background:#E3F2FD;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0">👤</div>
        <div>
          <div style="font-weight:700;font-size:14px">Thông tin khách hàng</div>
          <div style="font-size:12px;color:var(--text-2);margin-top:2px">Điền đầy đủ để liên hệ sau</div>
        </div>
      </div>

      <div class="form-row">
        <div>
          <label class="form-label">Họ và tên <span style="color:var(--danger)">*</span></label>
          <input type="text" name="customer_name" class="form-control"
                 placeholder="Nguyễn Văn A" value="{{ old('customer_name') }}" required>
          @error('customer_name')
            <div style="color:var(--danger);font-size:12px;margin-top:4px">{{ $message }}</div>
          @enderror
        </div>
        <div>
          <label class="form-label">Số điện thoại <span style="color:var(--danger)">*</span></label>
          <input type="text" name="customer_phone" class="form-control"
                 placeholder="0901 234 567" value="{{ old('customer_phone') }}" required>
          @error('customer_phone')
            <div style="color:var(--danger);font-size:12px;margin-top:4px">{{ $message }}</div>
          @enderror
        </div>
        <div>
          <label class="form-label">Email <span style="color:var(--danger)">*</span></label>
          <input type="email" name="customer_email" class="form-control"
                 placeholder="email@example.com" value="{{ old('customer_email') }}" required>
          @error('customer_email')
            <div style="color:var(--danger);font-size:12px;margin-top:4px">{{ $message }}</div>
          @enderror
        </div>
        <div>
          <label class="form-label">Địa chỉ</label>
          <input type="text" name="customer_address" class="form-control"
                 placeholder="Quận/Huyện, Tỉnh/TP" value="{{ old('customer_address') }}">
        </div>
      </div>

      <div style="margin-top:16px">
        <label class="form-label">Ghi chú tư vấn</label>
        <textarea name="note" class="form-control" rows="3"
                  placeholder="Nhu cầu, yêu cầu đặc biệt của khách...">{{ old('note') }}</textarea>
      </div>
    </div>

    {{-- Actions --}}
    <div class="card card-pad" style="border:1.5px solid var(--accent)">
      <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap">

        {{-- Summary --}}
        <div style="display:flex;gap:8px;flex:1;flex-wrap:wrap;align-items:center;min-height:34px" id="summary-area">
          <div id="sum-empty" style="font-size:13px;color:var(--text-3)">Điền thông tin để xem tóm tắt...</div>
          <div id="sum-car" style="display:none;align-items:center;gap:6px;padding:6px 12px;background:var(--bg);border:1px solid var(--border);border-radius:20px;font-size:12px;font-weight:600">
            🚗 <span id="sum-car-name"></span>
          </div>
          <div id="sum-customer" style="display:none;align-items:center;gap:6px;padding:6px 12px;background:var(--bg);border:1px solid var(--border);border-radius:20px;font-size:12px;font-weight:600">
            👤 <span id="sum-customer-name"></span>
            <span id="sum-phone" style="color:var(--text-3);font-weight:400"></span>
          </div>
          @if(request('assigned_to') && isset($assignedStaff))
            <div style="display:inline-flex;align-items:center;gap:6px;padding:6px 12px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:20px;font-size:12px;font-weight:600;color:#166534">
              👨‍💼 Gán cho: {{ $assignedStaff->name }}
            </div>
          @endif
        </div>

        {{-- Buttons --}}
        <div style="display:flex;gap:8px;flex-shrink:0">
          @if(request('assigned_to'))
            <a href="{{ route('admin.kpi.show', request('assigned_to')) }}" class="btn">Hủy</a>
          @else
            <a href="{{ route('admin.staff.orders.index') }}" class="btn">Hủy</a>
          @endif
          <button type="submit" class="btn btn-primary">✓ Tạo đơn hàng</button>
        </div>

      </div>
    </div>

  </div>
</form>

<script>
const carSel  = document.querySelector('[name=car_id]');
const nameIn  = document.querySelector('[name=customer_name]');
const phoneIn = document.querySelector('[name=customer_phone]');

function sync() {
  const hasCar  = carSel.value !== '';
  const hasName = nameIn.value.trim() !== '';
  const hasAny  = hasCar || hasName;

  document.getElementById('sum-empty').style.display    = hasAny ? 'none' : 'block';
  document.getElementById('sum-car').style.display      = hasCar ? 'inline-flex' : 'none';
  document.getElementById('sum-customer').style.display = hasName ? 'inline-flex' : 'none';

  if (hasCar) {
    const txt = carSel.options[carSel.selectedIndex].text;
    document.getElementById('sum-car-name').textContent = txt.split('—')[0].trim();
  }
  if (hasName) document.getElementById('sum-customer-name').textContent = nameIn.value.trim();
  document.getElementById('sum-phone').textContent = phoneIn.value.trim() ? '· ' + phoneIn.value.trim() : '';
}

carSel.addEventListener('change', sync);
nameIn.addEventListener('input', sync);
phoneIn.addEventListener('input', sync);
</script>

@endsection