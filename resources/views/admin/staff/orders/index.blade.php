@extends('layouts.admin')
@section('page-title', 'Đơn hàng của tôi')

@section('topbar-actions')
  <a href="{{ route('admin.staff.orders.create') }}" class="btn btn-sm btn-primary">+ Tạo đơn mới</a>
@endsection

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

/* ===== Reset ===== */
.so-wrap *, .so-wrap *::before, .so-wrap *::after { box-sizing: border-box; }
.so-wrap {
  font-family: 'Plus Jakarta Sans', sans-serif;
  padding: 14px 14px 0;
  background: #f5f6fa;
  min-height: 100vh;
}

/* ===== Stat Row ===== */
.so-stat-row {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 8px;
  margin-bottom: 10px;
}
.so-stat-card {
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  padding: 11px 10px;
  text-align: center;
}
.so-stat-label {
  font-size: 9.5px; font-weight: 700;
  color: #9ca3af; text-transform: uppercase; letter-spacing: .4px;
  line-height: 1.2; margin-bottom: 4px;
}
.so-stat-val {
  font-size: 22px; font-weight: 700; color: #111827; line-height: 1;
}

/* ===== Filter ===== */
.so-filter {
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  padding: 12px 14px;
  margin-bottom: 10px;
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.so-filter-row { display: flex; gap: 8px; align-items: flex-end; }
.so-filter-select {
  flex: 1;
  padding: 9px 28px 9px 10px;
  border: 1px solid #e5e7eb;
  border-radius: 9px;
  font-size: 13px;
  font-family: inherit;
  color: #111827;
  background: #f9fafb url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E") no-repeat right 10px center;
  -webkit-appearance: none; appearance: none;
  outline: none;
}
.so-filter-select:focus { border-color: #93c5fd; }
.so-filter-actions { display: flex; gap: 7px; }
.so-fbtn {
  flex: 1; padding: 9px 14px; border-radius: 9px;
  font-size: 13px; font-family: inherit; font-weight: 600;
  cursor: pointer; border: none; transition: all .15s; text-align: center;
  text-decoration: none; display: inline-flex; align-items: center; justify-content: center;
}
.so-fbtn-primary { background: #1d4ed8; color: #fff; }
.so-fbtn-reset { background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; }

/* ===== Table card ===== */
.so-table-card {
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 14px;
  overflow: hidden;
}
.so-table-header {
  padding: 12px 14px;
  border-bottom: 1px solid #f0f0f0;
  display: flex; align-items: center; justify-content: space-between;
}
.so-table-title { font-size: 14px; font-weight: 700; color: #111827; }
.so-count-badge {
  font-size: 11px; color: #6b7280; background: #f3f4f6;
  border: 1px solid #e5e7eb; border-radius: 6px;
  padding: 2px 8px; font-weight: 600;
}

/* ===== DESKTOP TABLE ===== */
.so-desktop { display: none; overflow-x: auto; }
.so-table {
  width: 100%; border-collapse: collapse;
  font-size: 13px; min-width: 720px;
}
.so-table thead tr { background: #f9fafb; border-bottom: 1px solid #f0f0f0; }
.so-table th {
  padding: 9px 13px; text-align: left;
  font-weight: 700; color: #6b7280;
  font-size: 11px; text-transform: uppercase; letter-spacing: .5px;
  white-space: nowrap;
}
.so-table tbody tr { border-bottom: 1px solid #f9fafb; transition: background .1s; }
.so-table tbody tr:last-child { border-bottom: none; }
.so-table tbody tr:hover { background: #fafbff; }
.so-table td { padding: 9px 13px; color: #374151; vertical-align: middle; }

.expand-row { background: #f9fafb !important; }
.expand-row td { padding: 14px 16px !important; }

/* ===== MOBILE CARDS ===== */
.so-mobile { display: flex; flex-direction: column; }
.so-card {
  padding: 13px 14px;
  border-bottom: 1px solid #f3f4f6;
}
.so-card:last-child { border-bottom: none; }

.so-card-top {
  display: flex; align-items: flex-start;
  justify-content: space-between; gap: 8px; margin-bottom: 7px;
}
.so-card-id { font-size: 11px; color: #c0c5cc; font-weight: 700; flex-shrink: 0; margin-top: 2px; }
.so-card-customer { flex: 1; }
.so-card-name { font-size: 14px; font-weight: 700; color: #111827; }
.so-card-phone { font-size: 11px; color: #9ca3af; margin-top: 1px; }

.so-card-mid {
  display: flex; align-items: center; gap: 7px;
  margin-bottom: 9px; flex-wrap: wrap;
}
.so-car-chip {
  font-size: 12px; color: #374151; font-weight: 500;
  background: #f9fafb; border: 1px solid #f0f0f0;
  border-radius: 6px; padding: 3px 8px;
  flex: 1; min-width: 0; white-space: nowrap;
  overflow: hidden; text-overflow: ellipsis;
}
.so-car-price { font-size: 11px; color: #9ca3af; flex-shrink: 0; }

.so-card-bottom {
  display: flex; align-items: center;
  justify-content: space-between; gap: 8px;
}
.so-card-meta { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.so-commission { font-size: 13px; font-weight: 700; color: #16a34a; }
.so-date { font-size: 11px; color: #9ca3af; }

.so-card-actions { display: flex; gap: 5px; flex-shrink: 0; flex-wrap: wrap; justify-content: flex-end; }

/* Expandable panel inside card */
.so-expand-panel {
  display: none;
  margin-top: 11px;
  border-top: 1px solid #f0f0f0;
  padding-top: 11px;
}
.so-expand-panel.open { display: block; }

.so-panel-section { margin-bottom: 12px; }
.so-panel-title {
  font-size: 11px; font-weight: 700; color: #6b7280;
  text-transform: uppercase; letter-spacing: .4px; margin-bottom: 7px;
}
.so-panel-info {
  font-size: 12px; color: #374151; line-height: 2;
  background: #f9fafb; border: 1px solid #f0f0f0;
  border-radius: 9px; padding: 10px 12px;
}

/* Close form inside card */
.so-close-form {
  background: #f0fdf4; border: 1px solid #bbf7d0;
  border-radius: 10px; padding: 12px;
  display: flex; flex-direction: column; gap: 10px;
}
.so-close-form-title {
  font-size: 13px; font-weight: 700; color: #15803d; margin-bottom: 2px;
}
.so-form-label {
  font-size: 10px; font-weight: 700; color: #6b7280;
  text-transform: uppercase; letter-spacing: .4px;
  display: block; margin-bottom: 4px;
}
.so-form-input {
  width: 100%; padding: 9px 11px;
  border: 1px solid #e5e7eb; border-radius: 9px;
  font-size: 13px; font-family: inherit; color: #111827;
  outline: none; background: #fff;
  transition: border .15s;
  -webkit-appearance: none;
}
.so-form-input:focus { border-color: #93c5fd; }
.so-commission-preview {
  padding: 9px 11px;
  background: #fff; border: 1px solid #bbf7d0;
  border-radius: 9px; font-size: 13px; font-weight: 700;
  color: #16a34a; min-height: 38px;
  display: flex; align-items: center;
}
.so-close-hint {
  font-size: 11px; color: #6b7280;
}
.so-close-actions { display: flex; gap: 7px; }

/* ===== Badges ===== */
.badge {
  display: inline-flex; align-items: center; gap: 3px;
  padding: 3px 9px; border-radius: 20px;
  font-size: 11px; font-weight: 700;
  border: 1px solid transparent; white-space: nowrap;
}
.badge-amber { background: #fffbeb; color: #b45309; border-color: #fde68a; }
.badge-blue  { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
.badge-green { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
.badge-loyal {
  display: inline-block;
  font-size: 11px;
  background: #fef3c7;
  color: #d97706;
  padding: 2px 8px;
  border-radius: 999px;
  font-weight: 700;
  border: 1px solid #fde68a;
  white-space: nowrap;
}

/* ===== Buttons ===== */
.so-btn {
  display: inline-flex; align-items: center; justify-content: center; gap: 4px;
  padding: 6px 11px; border-radius: 8px; font-size: 12px;
  font-family: inherit; font-weight: 600; cursor: pointer;
  text-decoration: none; border: 1px solid transparent;
  transition: all .15s; white-space: nowrap; min-height: 32px;
}
.so-btn-default { background: #f3f4f6; color: #374151; border-color: #e5e7eb; }
.so-btn-default:hover { background: #e5e7eb; }
.so-btn-blue { background: #2563eb; color: #fff; border-color: #2563eb; }
.so-btn-blue:hover { background: #1d4ed8; }
.so-btn-green { background: #16a34a; color: #fff; border-color: #16a34a; }
.so-btn-green:hover { background: #15803d; }
.so-btn-danger { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
.so-btn-danger:hover { background: #fee2e2; }
.so-btn-sm { padding: 5px 10px; font-size: 11px; min-height: 28px; }
.so-btn-full { width: 100%; }

/* ===== Pagination ===== */
.so-pag { padding: 10px 14px; border-top: 1px solid #f0f0f0; }

/* ===== Confirm Modal ===== */
.confirm-overlay {
  display: none; position: fixed; inset: 0; z-index: 9999;
  background: rgba(15,23,42,.5);
  align-items: flex-end; justify-content: center;
}
.confirm-overlay.show { display: flex; }
.confirm-box {
  background: #fff;
  border-radius: 20px 20px 0 0;
  width: 100%; max-width: 480px;
  padding: 0 0 24px;
  box-shadow: 0 -8px 40px rgba(0,0,0,.14);
  animation: slideUp .22s ease;
}
.confirm-handle {
  width: 36px; height: 4px;
  background: #e5e7eb; border-radius: 2px;
  margin: 10px auto 16px;
}
.confirm-icon {
  width: 48px; height: 48px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 12px; font-size: 22px;
}
.confirm-title {
  font-size: 16px; font-weight: 700; color: #111;
  text-align: center; margin-bottom: 6px;
  padding: 0 20px;
}
.confirm-message {
  font-size: 13px; color: #6b7280; text-align: center;
  line-height: 1.6; margin-bottom: 20px;
  padding: 0 20px;
}
.confirm-actions {
  display: flex; gap: 10px; padding: 0 20px;
}
.confirm-cancel {
  flex: 1; padding: 12px; border-radius: 10px;
  border: 1.5px solid #e5e7eb; background: #fff;
  font-size: 14px; font-weight: 600; color: #374151;
  cursor: pointer; transition: all .15s; font-family: inherit;
}
.confirm-cancel:hover { background: #f9fafb; }
.confirm-ok {
  flex: 1; padding: 12px; border-radius: 10px;
  border: none; font-size: 14px; font-weight: 700;
  color: #fff; cursor: pointer; transition: all .15s;
  font-family: inherit;
}

@keyframes slideUp {
  from { transform: translateY(40px); opacity: 0; }
  to   { transform: translateY(0);    opacity: 1; }
}

/* ===== RESPONSIVE ===== */
@media (max-width: 767px) {
  .so-wrap { padding: 12px 12px 0; }
  .so-stat-row { grid-template-columns: repeat(3, 1fr); gap: 7px; }
  .so-stat-row { grid-template-columns: 1fr 1fr 1fr; }
  .so-stat-val { font-size: 19px; }
  .so-desktop { display: none !important; }
  .so-mobile { display: flex; }
}

@media (min-width: 768px) {
  .so-wrap { padding: 18px 20px 0; }
  .so-stat-row { grid-template-columns: repeat(5,1fr); gap: 12px; margin-bottom: 18px; }
  .so-stat-val { font-size: 24px; }
  .so-filter { flex-direction: row; align-items: flex-end; }
  .so-filter-row { flex: 1; flex-wrap: nowrap; }
  .so-filter-select { width: 200px; flex: none; }
  .so-filter-actions { flex: none; }
  .so-fbtn { flex: none; width: auto; }
  .so-desktop { display: block; }
  .so-mobile { display: none !important; }
  .confirm-overlay { align-items: center; padding: 16px; }
  .confirm-box {
    border-radius: 16px; max-width: 380px;
    padding-bottom: 24px;
    animation: modalIn .18s ease;
  }
  @keyframes modalIn {
    from { opacity:0; transform:scale(.95) translateY(8px); }
    to   { opacity:1; transform:scale(1) translateY(0); }
  }
  .confirm-handle { display: none; }
}
</style>

<div class="so-wrap">

  {{-- ===== Stats ===== --}}
  <div class="so-stat-row">
    <div class="so-stat-card">
      <div class="so-stat-label">Tổng đơn</div>
      <div class="so-stat-val">{{ $stats['total'] }}</div>
    </div>
    <div class="so-stat-card">
      <div class="so-stat-label">Chưa tư vấn</div>
      <div class="so-stat-val" style="color:#d97706">{{ $stats['chua'] }}</div>
    </div>
    <div class="so-stat-card">
      <div class="so-stat-label">Đã tư vấn</div>
      <div class="so-stat-val" style="color:#2563eb">{{ $stats['da_tu_van'] }}</div>
    </div>
    <div class="so-stat-card">
      <div class="so-stat-label">Đã chốt</div>
      <div class="so-stat-val" style="color:#16a34a">{{ $stats['da_chot'] }}</div>
    </div>
    <div class="so-stat-card">
      <div class="so-stat-label">Hoa hồng</div>
      <div class="so-stat-val" style="font-size:15px;letter-spacing:-.5px">
        {{ number_format($stats['commission'],0,',','.') }}đ
      </div>
    </div>
  </div>

  {{-- ===== Filter ===== --}}
  <div class="so-filter">
    <form method="GET" style="display:contents">
      <div class="so-filter-row">
        <select name="status" class="so-filter-select">
          <option value="">Tất cả trạng thái</option>
          <option value="chua_tu_van" @selected(request('status')==='chua_tu_van')>Chưa tư vấn</option>
          <option value="da_tu_van"   @selected(request('status')==='da_tu_van')>Đã tư vấn</option>
          <option value="da_chot_don" @selected(request('status')==='da_chot_don')>Đã chốt đơn</option>
        </select>
        <button type="submit" class="so-fbtn so-fbtn-primary">Lọc</button>
      </div>
    </form>
    <a href="{{ route('admin.staff.orders.index') }}" class="so-fbtn so-fbtn-reset">✕ Xóa lọc</a>
  </div>

  {{-- ===== Table/Card wrapper ===== --}}
  <div class="so-table-card">
    <div class="so-table-header">
      <span class="so-table-title">Đơn hàng của tôi</span>
      <span class="so-count-badge">{{ $orders->total() }} đơn</span>
    </div>

    {{-- ========== MOBILE: Cards ========== --}}
    <div class="so-mobile">
      @forelse($orders as $order)
      @php
        $key = $order->customer_phone . '|' . $order->customer_name;
        $isLoyal = ($allOrders[$key] ?? 0) >= 2;
      @endphp
      <div class="so-card">

        {{-- Top: id + customer + badge --}}
        <div class="so-card-top">
          <span class="so-card-id">#{{ $order->id }}</span>
          <div class="so-card-customer">
            <div class="so-card-name">
              {{ $order->customer_name }}
              @if($isLoyal) <span class="badge-loyal">⭐ Thân thuộc</span> @endif
            </div>
            <div class="so-card-phone">{{ $order->customer_phone }}</div>
          </div>
          @if($order->consultation_status === 'chua_tu_van')
            <span class="badge badge-amber">Chưa tư vấn</span>
          @elseif($order->consultation_status === 'da_tu_van')
            <span class="badge badge-blue">Đã tư vấn ✓</span>
          @else
            <span class="badge badge-green">Đã chốt 🎉</span>
          @endif
        </div>

        {{-- Mid: car --}}
        <div class="so-card-mid">
          <span class="so-car-chip">🚗 {{ $order->car->name ?? 'N/A' }}</span>
          @if($order->car && $order->car->price_per_day)
            <span class="so-car-price">{{ number_format($order->car->price_per_day,0,',','.') }}đ</span>
          @endif
        </div>

        {{-- Bottom: commission + date + actions --}}
        <div class="so-card-bottom">
          <div class="so-card-meta">
            @if($order->commission_amount)
              <span class="so-commission">+{{ number_format($order->commission_amount,0,',','.') }}đ</span>
            @endif
            <span class="so-date">{{ $order->created_at->format('d/m/Y') }}</span>
          </div>
          <div class="so-card-actions">
            @if($order->consultation_status === 'chua_tu_van')
            <form id="mob-consult-form-{{ $order->id }}" method="POST"
                  action="{{ route('admin.staff.orders.consultation', $order) }}" style="display:none">
              @csrf
              <input type="hidden" name="consultation_status" value="da_tu_van">
            </form>
            <button type="button" class="so-btn so-btn-blue confirm-btn"
                    data-title="Xác nhận tư vấn"
                    data-message="Xác nhận đã tư vấn xong khách <strong>{{ $order->customer_name }}</strong>?"
                    data-type="info"
                    data-form="mob-consult-form-{{ $order->id }}">✓ Tư vấn</button>
            @endif

            @if($order->consultation_status === 'da_tu_van' && (Auth::user()->isAdmin() || Auth::user()->isManager()))
            <button type="button" class="so-btn so-btn-green"
                    onclick="toggleMobClose({{ $order->id }})">💰 Chốt</button>
            @endif

            <button type="button" class="so-btn so-btn-default"
                    onclick="toggleMobDetail({{ $order->id }})">Chi tiết</button>

            @if($order->consultation_status === 'chua_tu_van')
            <form id="mob-del-form-{{ $order->id }}" method="POST"
                  action="{{ route('admin.staff.orders.destroy', $order) }}" style="display:none">
              @csrf @method('DELETE')
            </form>
            <button type="button" class="so-btn so-btn-danger confirm-btn"
                    data-title="Xóa đơn hàng"
                    data-message="Xóa đơn <strong>#{{ $order->id }}</strong> của <strong>{{ $order->customer_name }}</strong>? Không thể hoàn tác!"
                    data-type="danger"
                    data-form="mob-del-form-{{ $order->id }}">Xóa</button>
            @endif
          </div>
        </div>

        {{-- Expand: chi tiết --}}
        <div id="mob-detail-{{ $order->id }}" class="so-expand-panel">
          <div class="so-panel-section">
            <div class="so-panel-title">Thông tin khách hàng</div>
            <div class="so-panel-info">
              📧 {{ $order->customer_email }}<br>
              @if($order->customer_address)📍 {{ $order->customer_address }}<br>@endif
              @if($order->note)📝 {{ $order->note }}@endif
            </div>
          </div>

          @if($order->consultation_status === 'chua_tu_van')
          <div class="so-panel-section">
            <div class="so-panel-title">Cập nhật ghi chú tư vấn</div>
            <form method="POST" action="{{ route('admin.staff.orders.consultation', $order) }}">
              @csrf
              <input type="hidden" name="consultation_status" value="chua_tu_van">
              <textarea name="note" class="so-form-input" rows="2"
                        style="margin-bottom:8px;resize:vertical"
                        placeholder="Ghi chú tình trạng tư vấn...">{{ $order->note }}</textarea>
              <button type="submit" class="so-btn so-btn-default so-btn-sm">Lưu ghi chú</button>
            </form>
          </div>
          @elseif($order->consultation_status === 'da_chot_don')
          <div class="so-panel-section">
            <div class="so-panel-title">Thông tin chốt đơn</div>
            <div class="so-panel-info">
              💰 Giá chốt: <strong>{{ number_format($order->sale_price ?? 0,0,',','.') }}đ</strong><br>
              🎯 Hoa hồng {{ $order->commission_rate }}%:
              <strong style="color:#16a34a">{{ number_format($order->commission_amount ?? 0,0,',','.') }}đ</strong><br>
              🕐 Chốt lúc: {{ $order->closed_at?->format('d/m/Y H:i') ?? '—' }}<br>
              @if($order->manager_note)📝 {{ $order->manager_note }}@endif
            </div>
          </div>
          @endif
        </div>

        {{-- Expand: chốt đơn --}}
        @if($order->consultation_status === 'da_tu_van' && (Auth::user()->isAdmin() || Auth::user()->isManager()))
        <div id="mob-close-{{ $order->id }}" class="so-expand-panel">
          <div class="so-close-form">
            <div class="so-close-form-title">💰 Chốt đơn #{{ $order->id }} — {{ $order->customer_name }}</div>
            <form id="mob-close-form-{{ $order->id }}" method="POST"
                  action="{{ route('admin.orders.close', $order) }}">
              @csrf
              <div style="margin-bottom:9px">
                <label class="so-form-label">Giá bán thực tế (đ) <span style="color:#dc2626">*</span></label>
                <input type="number" name="sale_price" class="so-form-input"
                       placeholder="VD: 5500000000"
                       value="{{ $order->car->price_per_day ?? '' }}"
                       min="1" required
                       oninput="calcMobCommission({{ $order->id }}, this.value)">
              </div>
              <div style="margin-bottom:9px">
                <label class="so-form-label">Hoa hồng dự kiến</label>
                <div id="mob-comm-{{ $order->id }}" class="so-commission-preview">—</div>
              </div>
              <div style="margin-bottom:9px">
                <label class="so-form-label">Ghi chú</label>
                <input type="text" name="manager_note" class="so-form-input"
                       placeholder="Ghi chú thêm (nếu có)">
              </div>
              <div class="so-close-hint">* 0.05% nếu &lt; 10 tỷ · 0.1% nếu ≥ 10 tỷ</div>
              <div class="so-close-actions" style="margin-top:10px">
                <button type="button" onclick="toggleMobClose({{ $order->id }})"
                        class="so-btn so-btn-default" style="flex:1">Hủy</button>
                <button type="button" class="so-btn so-btn-green confirm-btn" style="flex:2"
                        data-title="Xác nhận chốt đơn"
                        data-message="Xác nhận chốt đơn <strong>#{{ $order->id }}</strong> cho khách <strong>{{ $order->customer_name }}</strong>?"
                        data-type="success"
                        data-form="mob-close-form-{{ $order->id }}">✓ Xác nhận chốt</button>
              </div>
            </form>
          </div>
        </div>
        @endif

      </div>
      @empty
      <div style="padding:48px;text-align:center;color:#9ca3af;font-size:13px">
        Bạn chưa có đơn hàng nào.
        <a href="{{ route('admin.staff.orders.create') }}" style="color:#2563eb">Tạo đơn ngay →</a>
      </div>
      @endforelse
    </div>

    {{-- ========== DESKTOP: Table ========== --}}
    <div class="so-desktop">
      <table class="so-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Khách hàng</th>
            <th>Xe quan tâm</th>
            <th>Trạng thái</th>
            <th>Hoa hồng</th>
            <th>Ngày tạo</th>
            <th style="text-align:right">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          @forelse($orders as $order)
          @php
            $key = $order->customer_phone . '|' . $order->customer_name;
            $isLoyal = ($allOrders[$key] ?? 0) >= 2;
          @endphp
          <tr>
            <td style="color:#c0c5cc;font-size:13px">#{{ $order->id }}</td>
            <td>
              <div style="font-weight:700">
                {{ $order->customer_name }}
                @if($isLoyal)
                  <span class="badge-loyal">⭐ Thân thuộc</span>
                @endif
              </div>
              <div style="font-size:12px;color:#9ca3af">{{ $order->customer_phone }}</div>
            </td>
            <td>
              <div style="font-size:13px;font-weight:600">{{ $order->car->name ?? 'N/A' }}</div>
              @if($order->car && $order->car->price_per_day)
                <div style="font-size:12px;color:#9ca3af">{{ number_format($order->car->price_per_day,0,',','.') }}đ</div>
              @endif
            </td>
            <td>
              @if($order->consultation_status === 'chua_tu_van')
                <span class="badge badge-amber">Chưa tư vấn</span>
              @elseif($order->consultation_status === 'da_tu_van')
                <span class="badge badge-blue">Đã tư vấn ✓</span>
              @else
                <span class="badge badge-green">Đã chốt đơn 🎉</span>
              @endif
            </td>
            <td style="font-size:13px;color:#16a34a;font-weight:700">
              {{ $order->commission_amount ? number_format($order->commission_amount,0,',','.') . 'đ' : '—' }}
            </td>
            <td style="font-size:12px;color:#9ca3af">{{ $order->created_at->format('d/m/Y') }}</td>
            <td style="text-align:right">
              <div style="display:inline-flex;gap:6px;align-items:center">

                @if($order->consultation_status === 'chua_tu_van')
                <form id="consult-form-{{ $order->id }}" method="POST"
                      action="{{ route('admin.staff.orders.consultation', $order) }}" style="display:inline">
                  @csrf
                  <input type="hidden" name="consultation_status" value="da_tu_van">
                  <button type="button" class="so-btn so-btn-blue confirm-btn"
                          data-title="Xác nhận tư vấn"
                          data-message="Xác nhận đã tư vấn xong khách <strong>{{ $order->customer_name }}</strong>?"
                          data-type="info"
                          data-form="consult-form-{{ $order->id }}">✓ Đã tư vấn</button>
                </form>
                @endif

                @if($order->consultation_status === 'da_tu_van' && (Auth::user()->isAdmin() || Auth::user()->isManager()))
                <button type="button" class="so-btn so-btn-green"
                        onclick="toggleClose({{ $order->id }})">💰 Chốt đơn</button>
                @endif

                <button type="button" class="so-btn so-btn-default"
                        onclick="toggleDetail({{ $order->id }})">Chi tiết</button>

                @if($order->consultation_status === 'chua_tu_van')
                <form id="del-form-{{ $order->id }}" method="POST"
                      action="{{ route('admin.staff.orders.destroy', $order) }}" style="display:inline">
                  @csrf @method('DELETE')
                  <button type="button" class="so-btn so-btn-danger confirm-btn"
                          data-title="Xóa đơn hàng"
                          data-message="Xóa đơn <strong>#{{ $order->id }}</strong> của <strong>{{ $order->customer_name }}</strong>? Không thể hoàn tác!"
                          data-type="danger"
                          data-form="del-form-{{ $order->id }}">Xóa</button>
                </form>
                @endif

              </div>
            </td>
          </tr>

          {{-- Close row (desktop) --}}
          @if($order->consultation_status === 'da_tu_van' && (Auth::user()->isAdmin() || Auth::user()->isManager()))
          <tr id="close-{{ $order->id }}" class="expand-row" style="display:none">
            <td colspan="7">
              <form method="POST" action="{{ route('admin.orders.close', $order) }}"
                    id="close-form-{{ $order->id }}">
                @csrf
                <div style="font-weight:700;margin-bottom:12px;color:#16a34a">
                  💰 Chốt đơn #{{ $order->id }} — {{ $order->customer_name }}
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr 2fr auto;gap:12px;align-items:end">
                  <div>
                    <label class="so-form-label">Giá bán thực tế (đ) <span style="color:#dc2626">*</span></label>
                    <input type="number" name="sale_price" class="so-form-input"
                           placeholder="VD: 5500000000"
                           value="{{ $order->car->price_per_day ?? '' }}"
                           min="1" required
                           oninput="calcCommission({{ $order->id }}, this.value)">
                  </div>
                  <div>
                    <label class="so-form-label">Hoa hồng dự kiến</label>
                    <div id="commission-preview-{{ $order->id }}" class="so-commission-preview">—</div>
                  </div>
                  <div>
                    <label class="so-form-label">Ghi chú</label>
                    <input type="text" name="manager_note" class="so-form-input"
                           placeholder="Ghi chú thêm (nếu có)">
                  </div>
                  <div style="display:flex;gap:8px">
                    <button type="button" onclick="toggleClose({{ $order->id }})"
                            class="so-btn so-btn-default">Hủy</button>
                    <button type="button" class="so-btn so-btn-green confirm-btn"
                            data-title="Xác nhận chốt đơn"
                            data-message="Xác nhận chốt đơn <strong>#{{ $order->id }}</strong> cho khách <strong>{{ $order->customer_name }}</strong>?"
                            data-type="success"
                            data-form="close-form-{{ $order->id }}">✓ Xác nhận chốt</button>
                  </div>
                </div>
                <div style="margin-top:8px;font-size:12px;color:#9ca3af">
                  * Hoa hồng: <strong>0.05%</strong> nếu &lt; 10 tỷ · <strong>0.1%</strong> nếu ≥ 10 tỷ
                </div>
              </form>
            </td>
          </tr>
          @endif

          {{-- Detail row (desktop) --}}
          <tr id="detail-{{ $order->id }}" class="expand-row" style="display:none">
            <td colspan="7">
              <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;font-size:13px">
                <div>
                  <div style="font-weight:700;margin-bottom:8px">Thông tin khách</div>
                  <div style="color:#6b7280;line-height:2">
                    Email: {{ $order->customer_email }}<br>
                    @if($order->customer_address)Địa chỉ: {{ $order->customer_address }}<br>@endif
                    @if($order->note)Ghi chú: {{ $order->note }}@endif
                  </div>
                </div>
                @if($order->consultation_status === 'chua_tu_van')
                <div>
                  <div style="font-weight:700;margin-bottom:8px">Cập nhật ghi chú tư vấn</div>
                  <form method="POST" action="{{ route('admin.staff.orders.consultation', $order) }}">
                    @csrf
                    <input type="hidden" name="consultation_status" value="chua_tu_van">
                    <textarea name="note" class="so-form-input" rows="2"
                              style="margin-bottom:8px;resize:vertical"
                              placeholder="Ghi chú tình trạng tư vấn...">{{ $order->note }}</textarea>
                    <button type="submit" class="so-btn so-btn-default so-btn-sm">Lưu ghi chú</button>
                  </form>
                </div>
                @elseif($order->consultation_status === 'da_chot_don')
                <div>
                  <div style="font-weight:700;margin-bottom:8px">Thông tin chốt đơn</div>
                  <div style="color:#6b7280;line-height:2">
                    Giá chốt: <strong>{{ number_format($order->sale_price ?? 0,0,',','.') }}đ</strong><br>
                    Hoa hồng {{ $order->commission_rate }}%:
                    <strong style="color:#16a34a">{{ number_format($order->commission_amount ?? 0,0,',','.') }}đ</strong><br>
                    Chốt lúc: {{ $order->closed_at?->format('d/m/Y H:i') ?? '—' }}<br>
                    @if($order->manager_note)Ghi chú Manager: {{ $order->manager_note }}@endif
                  </div>
                </div>
                @endif
              </div>
            </td>
          </tr>

          @empty
          <tr>
            <td colspan="7" style="text-align:center;padding:48px;color:#9ca3af">
              Bạn chưa có đơn hàng nào.
              <a href="{{ route('admin.staff.orders.create') }}" style="color:#2563eb">Tạo đơn ngay →</a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($orders->hasPages())
    <div class="so-pag">{{ $orders->links() }}</div>
    @endif
  </div>

  <div style="height:24px"></div>
</div>

{{-- ===== Confirm Modal ===== --}}
<div id="confirm-modal" class="confirm-overlay">
  <div class="confirm-box">
    <div class="confirm-handle"></div>
    <div id="confirm-icon" class="confirm-icon"></div>
    <div id="confirm-title" class="confirm-title"></div>
    <div id="confirm-message" class="confirm-message"></div>
    <div class="confirm-actions">
      <button class="confirm-cancel" onclick="closeConfirm()">Hủy bỏ</button>
      <button id="confirm-ok" class="confirm-ok">Xác nhận</button>
    </div>
  </div>
</div>

<script>
let _confirmFormId = null;

const THEMES = {
  info:    { bg:'#eff6ff', icon:'ℹ️', btn:'#2563eb' },
  success: { bg:'#f0fdf4', icon:'✅', btn:'#16a34a' },
  danger:  { bg:'#fef2f2', icon:'⚠️', btn:'#dc2626' },
  warning: { bg:'#fffbeb', icon:'⚠️', btn:'#d97706' },
};

document.addEventListener('click', function(e) {
  const btn = e.target.closest('.confirm-btn');
  if (!btn) return;
  const type = btn.dataset.type || 'info';
  const t = THEMES[type] || THEMES.info;
  _confirmFormId = btn.dataset.form || null;
  const icon = document.getElementById('confirm-icon');
  icon.style.background = t.bg;
  icon.textContent = t.icon;
  document.getElementById('confirm-title').textContent = btn.dataset.title || '';
  document.getElementById('confirm-message').innerHTML  = btn.dataset.message || '';
  document.getElementById('confirm-ok').style.background = t.btn;
  document.body.style.overflow = 'hidden';
  document.getElementById('confirm-modal').classList.add('show');
});

function closeConfirm() {
  document.getElementById('confirm-modal').classList.remove('show');
  document.body.style.overflow = '';
  _confirmFormId = null;
}

document.getElementById('confirm-ok').addEventListener('click', function() {
  const id = _confirmFormId;
  closeConfirm();
  if (id) { const f = document.getElementById(id); if (f) f.submit(); }
});

document.getElementById('confirm-modal').addEventListener('click', function(e) {
  if (e.target === this) closeConfirm();
});
document.addEventListener('keydown', function(e) { if (e.key==='Escape') closeConfirm(); });

function toggleDetail(id) {
  const r = document.getElementById('detail-' + id);
  r.style.display = r.style.display === 'none' ? 'table-row' : 'none';
}
function toggleClose(id) {
  const r = document.getElementById('close-' + id);
  r.style.display = r.style.display === 'none' ? 'table-row' : 'none';
}
function toggleMobDetail(id) {
  const p = document.getElementById('mob-detail-' + id);
  p.classList.toggle('open');
}
function toggleMobClose(id) {
  const p = document.getElementById('mob-close-' + id);
  if (p) p.classList.toggle('open');
}
function calcCommission(id, value) {
  const sale = parseInt(value) || 0;
  const rate = sale >= 10000000000 ? 0.1 : 0.05;
  const comm = Math.round(sale * rate / 100);
  const el = document.getElementById('commission-preview-' + id);
  el.textContent = comm > 0 ? comm.toLocaleString('vi-VN') + 'đ (' + rate + '%)' : '—';
}
function calcMobCommission(id, value) {
  const sale = parseInt(value) || 0;
  const rate = sale >= 10000000000 ? 0.1 : 0.05;
  const comm = Math.round(sale * rate / 100);
  const el = document.getElementById('mob-comm-' + id);
  el.textContent = comm > 0 ? comm.toLocaleString('vi-VN') + 'đ (' + rate + '%)' : '—';
}
</script>

@endsection