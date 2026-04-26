@extends('layouts.admin')
@section('page-title', 'Đơn hàng #' . $order->id)

@section('topbar-actions')
  <a href="{{ route('admin.orders.index') }}" class="btn btn-sm">← Danh sách đơn</a>
@endsection

@section('content')

<style>
  .content-wrapper, .main-content, [data-page-content],
  .page-content, .content-body, #content, #main-content {
    padding-top: 0 !important;
    margin-top: 0 !important;
  }

  .order-page { margin-top: 0 !important; }
  .alert:first-child { margin-top: 0 !important; }

  .order-page {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 12px;
    align-items: start;
    padding: 0;
    margin-top: 0;
  }

  .col-left {
    background: var(--surface, #fff);
    border: 1px solid var(--border, #e5e7eb);
    border-radius: 10px;
    overflow: hidden;
  }
  .col-left .section {
    padding: 14px 18px;
    border-bottom: 1px solid var(--border, #e5e7eb);
  }
  .col-left .section:last-child { border-bottom: none; }

  .col-right {
    background: var(--surface, #fff);
    border: 1px solid var(--border, #e5e7eb);
    border-radius: 10px;
    overflow: hidden;
  }
  .col-right .section {
    padding: 14px 18px;
    border-bottom: 1px solid var(--border, #e5e7eb);
  }
  .col-right .section:last-child { border-bottom: none; }

  .section-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 700;
    font-size: 14px;
    margin-bottom: 12px;
  }
  .section-icon {
    width: 28px; height: 28px; border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; flex-shrink: 0;
  }

  .info-grid   { display: grid; grid-template-columns: 1fr 1fr;       gap: 8px; }
  .info-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr;   gap: 8px; }

  .info-cell { padding: 9px 11px; background: var(--surface2, #f9fafb); border-radius: 6px; }
  .info-cell .label { font-size: 11px; color: var(--text-muted, #6b7280); margin-bottom: 3px; }
  .info-cell .value { font-size: 14px; font-weight: 500; }

  .status-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 7px 0; border-bottom: 1px solid var(--border, #e5e7eb); font-size: 14px;
  }
  .status-row:last-child { border-bottom: none; }
  .status-row .slabel { color: var(--text-muted, #6b7280); }

  .form-row { display: flex; gap: 8px; }
  .flabel { font-size: 12px; color: var(--text-muted, #6b7280); display: block; margin-bottom: 4px; }

  .note-block {
    margin-top: 8px; padding: 9px 12px;
    background: var(--surface2, #f9fafb); border-radius: 6px;
    font-size: 14px; border-left: 3px solid var(--primary, #2563eb);
  }

  .staff-chip {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 12px; background: var(--surface2, #f9fafb);
    border-radius: 6px; margin-bottom: 10px;
  }
  .staff-avatar {
    width: 32px; height: 32px; border-radius: 50%;
    background: var(--primary, #2563eb);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 700; font-size: 13px; flex-shrink: 0;
  }

  .commission-box {
    display: flex; justify-content: space-between; align-items: center;
    padding: 9px 12px; background: var(--surface2, #f9fafb);
    border-radius: 6px; margin-top: 4px; font-size: 14px;
  }

  .alert { padding: 10px 14px; border-radius: 7px; font-size: 14px; margin-bottom: 10px; }
  .alert-success { background: #dcfce7; color: #166534; }
  .alert-error   { background: #fee2e2; color: #991b1b; }
</style>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-error">{{ session('error') }}</div>
@endif

<div class="order-page">

  {{-- ===== CỘT TRÁI ===== --}}
  <div class="col-left">

    {{-- Thông tin khách hàng --}}
    <div class="section">
      <div class="section-title">
        <div class="section-icon" style="background:#E3F2FD">👤</div>
        Thông tin khách hàng
      </div>
      <div class="info-grid">
        <div class="info-cell">
          <div class="label">Họ tên</div>
          <div class="value">{{ $order->customer_name }}</div>
        </div>
        <div class="info-cell">
          <div class="label">Số điện thoại</div>
          <div class="value">{{ $order->customer_phone }}</div>
        </div>
        <div class="info-cell">
          <div class="label">Email</div>
          <div class="value" style="font-weight:400">{{ $order->customer_email }}</div>
        </div>
        @if($order->customer_address)
        <div class="info-cell">
          <div class="label">Địa chỉ</div>
          <div class="value" style="font-weight:400">{{ $order->customer_address }}</div>
        </div>
        @endif
      </div>
      @if($order->note)
      <div class="note-block">
        <div class="label" style="font-size:11px;color:var(--text-muted);margin-bottom:3px">Ghi chú</div>
        {{ $order->note }}
      </div>
      @endif
    </div>

    {{-- Thông tin xe --}}
    <div class="section">
      <div class="section-title">
        <div class="section-icon" style="background:#E8F5E9">🚗</div>
        Thông tin xe
      </div>
      <div class="info-grid-3">
        <div class="info-cell">
          <div class="label">Tên xe</div>
          <div class="value">{{ $order->car->name ?? 'N/A' }}</div>
        </div>
        <div class="info-cell">
          <div class="label">Hãng</div>
          <div class="value" style="font-weight:400">{{ $order->car->brand->name ?? 'N/A' }}</div>
        </div>
        <div class="info-cell">
          <div class="label">Giá niêm yết</div>
          <div class="value" style="color:var(--danger,#ef4444)">
            {{ $order->car ? number_format($order->car->price_per_day ?? 0, 0, ',', '.') . 'đ' : 'N/A' }}
          </div>
        </div>
      </div>
    </div>

    {{-- Nhân viên phụ trách --}}
    <div class="section">
      <div class="section-title">
        <div class="section-icon" style="background:#F3E5F5">👨‍💼</div>
        Nhân viên phụ trách
      </div>

      @if($order->assignedStaff)
        <div class="staff-chip">
          <div class="staff-avatar">{{ strtoupper(substr($order->assignedStaff->name, 0, 1)) }}</div>
          <div>
            <div style="font-weight:600;font-size:14px">{{ $order->assignedStaff->name }}</div>
            <div style="font-size:12px;color:var(--text-muted)">{{ $order->assignedStaff->email }}</div>
          </div>
          @if($order->consulted_at)
          <div style="margin-left:auto;font-size:11px;color:var(--text-muted);text-align:right">
            Tư vấn lúc<br>{{ $order->consulted_at->format('H:i d/m/Y') }}
          </div>
          @endif
        </div>
      @else
        <div class="info-cell" style="margin-bottom:10px;font-size:14px;color:var(--text-muted)">Chưa gán nhân viên</div>
      @endif

      @if(auth()->user()->isAdmin() || auth()->user()->isManager())
      <form method="POST" action="{{ route('admin.orders.assign', $order) }}" class="form-row">
        @csrf
        <select name="assigned_to" class="form-input" style="flex:1;font-size:14px">
          <option value="">-- Chọn nhân viên --</option>
          @foreach(\App\Models\User::where('role','staff')->get() as $s)
            <option value="{{ $s->id }}" @selected($order->assigned_to == $s->id)>{{ $s->name }}</option>
          @endforeach
        </select>
        <button type="submit" class="btn btn-sm">Gán</button>
      </form>
      @endif
    </div>

    {{-- Ghi chú Manager --}}
    @if($order->manager_note)
    <div class="section">
      <div class="section-title">
        <div class="section-icon" style="background:#FFF8E1">📝</div>
        Ghi chú Manager
      </div>
      <div style="font-size:14px;color:var(--text-muted);line-height:1.6">{{ $order->manager_note }}</div>
    </div>
    @endif

  </div>

  {{-- ===== CỘT PHẢI ===== --}}
  <div class="col-right">

    {{-- Trạng thái đơn --}}
    <div class="section">
      <div class="section-title">
        <div class="section-icon" style="background:#E8EAF6">📋</div>
        Trạng thái đơn
      </div>

      <div class="status-row">
        <span class="slabel">Ngày tạo</span>
        <span style="font-weight:500;font-size:14px">{{ $order->created_at->format('d/m/Y H:i') }}</span>
      </div>
      <div class="status-row">
        <span class="slabel">Tư vấn</span>
        @if($order->consultation_status === 'chua_tu_van')
          <span class="badge badge-warning">Chưa tư vấn</span>
        @elseif($order->consultation_status === 'da_tu_van')
          <span class="badge badge-info">Đã tư vấn</span>
        @else
          <span class="badge badge-success">Đã chốt đơn</span>
        @endif
      </div>
      @if($order->sale_price)
      <div class="status-row">
        <span class="slabel">Giá chốt</span>
        <span style="font-weight:700;font-size:15px;color:var(--primary)">{{ number_format($order->sale_price, 0, ',', '.') }}đ</span>
      </div>
      @endif
      @if($order->commission_rate)
      <div class="status-row">
        <span class="slabel">% Hoa hồng</span>
        <span style="font-size:14px">{{ $order->commission_rate }}%</span>
      </div>
      @endif
      @if($order->commission_amount)
      <div class="commission-box">
        <span class="slabel">Hoa hồng</span>
        <span style="font-weight:700;font-size:16px;color:var(--success,#16a34a)">{{ number_format($order->commission_amount, 0, ',', '.') }}đ</span>
      </div>
      @endif
      @if($order->closed_at)
      <div class="status-row" style="border-bottom:none;margin-top:4px">
        <span class="slabel">Chốt lúc</span>
        <span style="font-size:13px">{{ $order->closed_at->format('d/m/Y H:i') }}</span>
      </div>
      @endif
    </div>

    {{-- Form chốt đơn --}}
    {{-- ✅ Admin: cần da_tu_van | Manager: chỉ cần là người tạo/được assign và chưa chốt --}}
    @if(
      $order->consultation_status !== 'da_chot_don' && (
        auth()->user()->isAdmin() && $order->consultation_status === 'da_tu_van'
        ||
        auth()->user()->isManager() && (
          $order->user_id === auth()->id() || $order->assigned_to === auth()->id()
        )
      )
    )
    <div class="section" style="border-top:2px solid var(--primary,#2563eb)">
      <div class="section-title" style="color:var(--primary)">
        <div class="section-icon" style="background:#E8F5E9">✅</div>
        Chốt đơn hàng
      </div>
      <form id="close-order-form" method="POST" action="{{ route('admin.orders.close', $order) }}">
        @csrf
        <div style="display:flex;flex-direction:column;gap:10px">
          <div>
            <label class="flabel">Giá bán cuối (đ) <span style="color:var(--danger,#ef4444)">*</span></label>
            <input type="number" name="sale_price" class="form-input" style="width:100%;font-size:14px"
                   placeholder="5500000000"
                   value="{{ old('sale_price', $order->car->price_per_day ?? '') }}"
                   required>
          </div>
          <div style="padding:9px 12px;background:var(--surface2,#f9fafb);border-radius:6px;font-size:14px">
            Hoa hồng dự tính: <strong id="commission-val" style="color:var(--success,#16a34a)">—</strong>
            <span id="commission-rate-label" style="color:var(--text-muted);font-size:12px"></span>
          </div>
          <div style="font-size:12px;color:var(--text-muted)">
            * Tự động: <strong>0.05%</strong> nếu &lt; 10 tỷ · <strong>0.1%</strong> nếu ≥ 10 tỷ
          </div>
          <div>
            <label class="flabel">Ghi chú</label>
            <textarea name="manager_note" class="form-input" rows="2"
                      style="width:100%;resize:vertical;font-size:14px"
                      placeholder="Ghi chú thêm...">{{ old('manager_note') }}</textarea>
          </div>
          <button type="button" class="btn"
                  style="background:var(--primary,#2563eb);color:#fff;justify-content:center;padding:10px;font-size:14px"
                  onclick="openConfirmModal()">
            ✅ Xác nhận chốt đơn
          </button>
        </div>
      </form>
    </div>
    @endif

    {{-- Cập nhật trạng thái (Admin only) --}}
    @if(auth()->user()->isAdmin())
    <div class="section">
      <div class="section-title">
        <div class="section-icon" style="background:#FFF3E0">🔄</div>
        Cập nhật trạng thái
      </div>
      <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="form-row">
        @csrf
        <select name="status" class="form-input" style="flex:1;font-size:14px">
          <option value="pending"   @selected($order->status==='pending')>Chờ xác nhận</option>
          <option value="confirmed" @selected($order->status==='confirmed')>Đã xác nhận</option>
          <option value="completed" @selected($order->status==='completed')>Hoàn thành</option>
          <option value="cancelled" @selected($order->status==='cancelled')>Đã hủy</option>
        </select>
        <button type="submit" class="btn btn-sm">Lưu</button>
      </form>
    </div>
    @endif

  </div>
</div>

{{-- Custom Confirm Modal --}}
<div id="confirm-modal" style="
  display:none;position:fixed;inset:0;z-index:9999;
  background:rgba(0,0,0,.45);backdrop-filter:blur(3px);
  align-items:center;justify-content:center;
">
  <div style="
    background:#fff;border-radius:14px;padding:28px 28px 22px;
    width:340px;box-shadow:0 20px 60px rgba(0,0,0,.18);
    animation:modalIn .18s ease;
  ">
    <div style="font-size:22px;margin-bottom:10px">✅</div>
    <div style="font-weight:700;font-size:16px;margin-bottom:6px">Xác nhận chốt đơn?</div>
    <div style="font-size:14px;color:var(--text-muted,#6b7280);line-height:1.5;margin-bottom:22px">
      Hành động này sẽ chốt đơn hàng và tính hoa hồng. Bạn không thể hoàn tác sau khi xác nhận.
    </div>
    <div style="display:flex;gap:8px;justify-content:flex-end">
      <button onclick="closeConfirmModal()" style="
        padding:9px 20px;border-radius:8px;border:1px solid var(--border,#e5e7eb);
        background:#fff;font-size:14px;font-weight:500;cursor:pointer;
      ">Hủy</button>
      <button onclick="document.getElementById('close-order-form').submit()" style="
        padding:9px 20px;border-radius:8px;border:none;
        background:var(--primary,#2563eb);color:#fff;
        font-size:14px;font-weight:600;cursor:pointer;
      ">Xác nhận chốt đơn</button>
    </div>
  </div>
</div>

<style>
@keyframes modalIn {
  from { opacity:0; transform:scale(.95) translateY(8px); }
  to   { opacity:1; transform:scale(1)  translateY(0); }
}
</style>

<script>
function openConfirmModal()  { document.getElementById('confirm-modal').style.display = 'flex'; }
function closeConfirmModal() { document.getElementById('confirm-modal').style.display = 'none'; }
document.getElementById('confirm-modal').addEventListener('click', function(e) {
  if (e.target === this) closeConfirmModal();
});

function calcCommission() {
  const price = parseFloat(document.querySelector('[name=sale_price]')?.value) || 0;
  const rate  = price >= 10000000000 ? 0.1 : 0.05;
  const comm  = Math.round(price * rate / 100);
  const val   = document.getElementById('commission-val');
  const label = document.getElementById('commission-rate-label');
  if (val) {
    val.textContent   = price > 0 ? new Intl.NumberFormat('vi-VN').format(comm) + 'đ' : '—';
    label.textContent = price > 0 ? ' (' + rate + '%)' : '';
  }
}
document.addEventListener('DOMContentLoaded', () => {
  calcCommission();
  document.querySelector('[name=sale_price]')?.addEventListener('input', calcCommission);
});
</script>

@endsection