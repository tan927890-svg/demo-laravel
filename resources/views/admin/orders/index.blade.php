@extends('layouts.admin')
@section('page-title', 'Quản lý đơn hàng')

@section('topbar-actions')
  <a href="{{ route('admin.orders.create') }}" class="btn" style="background:#1d4ed8;color:#fff;font-size:14px;padding:8px 16px">+ Tạo đơn mới</a>
  <a href="{{ route('admin.dashboard') }}" class="btn btn-sm" style="font-size:14px;padding:8px 14px">← Quay lại</a>
@endsection

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

/* ===== Reset ===== */
.ord-wrap *, .ord-wrap *::before, .ord-wrap *::after { box-sizing: border-box; }

.ord-wrap {
    padding: 14px 14px 0;
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #f5f6fa;
    min-height: 100vh;
}

/* ===== Alerts ===== */
.ord-alert {
    padding: 9px 14px; border-radius: 10px;
    margin-bottom: 12px; font-size: 13px;
    display: flex; align-items: center; gap: 7px;
}
.ord-alert-success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
.ord-alert-error   { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

/* ===== Stat cards ===== */
.stat-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
    margin-bottom: 10px;
}
.stat-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 11px 10px;
    text-decoration: none;
    display: block;
    transition: box-shadow .15s, border-color .15s;
}
.stat-card:hover,
.stat-card:active { border-color: #bfdbfe; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
.stat-card-label {
    font-size: 9.5px; font-weight: 700; color: #9ca3af;
    text-transform: uppercase; letter-spacing: .4px;
    line-height: 1.2;
}
.stat-card-value { font-size: 24px; font-weight: 700; margin-top: 3px; line-height: 1; }
.stat-card-sub   { font-size: 10px; color: #9ca3af; margin-top: 3px; }
.stat-warning { color: #d97706; }
.stat-blue    { color: #2563eb; }
.stat-green   { color: #16a34a; }

/* ===== Filter card ===== */
.filter-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 12px 14px;
    margin-bottom: 10px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.filter-row { display: flex; gap: 8px; align-items: flex-end; flex-wrap: wrap; }
.filter-group { display: flex; flex-direction: column; gap: 4px; flex: 1; min-width: 120px; }
.filter-label {
    font-size: 10px; font-weight: 700; color: #9ca3af;
    text-transform: uppercase; letter-spacing: .4px;
}
.filter-select {
    width: 100%;
    padding: 9px 10px;
    border: 1px solid #e5e7eb;
    border-radius: 9px;
    font-size: 13px;
    font-family: inherit;
    color: #111827;
    background: #f9fafb;
    outline: none;
    transition: border .15s;
    -webkit-appearance: none;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    padding-right: 28px;
}
.filter-select:focus { border-color: #93c5fd; }
.filter-actions { display: flex; gap: 7px; }
.filter-btn {
    flex: 1;
    padding: 9px 14px;
    border-radius: 9px;
    font-size: 13px;
    font-family: inherit;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: all .15s;
    text-align: center;
}
.filter-btn-primary { background: #1d4ed8; color: #fff; }
.filter-btn-primary:hover { background: #1e40af; }
.filter-btn-reset {
    background: #f3f4f6; color: #374151;
    border: 1px solid #e5e7eb;
    text-decoration: none;
    display: flex; align-items: center; justify-content: center;
}
.filter-btn-reset:hover { background: #e5e7eb; }

/* ===== Table card wrapper ===== */
.table-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    overflow: hidden;
}
.table-card-header {
    padding: 12px 14px;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.table-card-title { font-size: 14px; font-weight: 700; color: #111827; }
.table-count-badge {
    font-size: 11px; color: #6b7280; background: #f3f4f6;
    border: 1px solid #e5e7eb; border-radius: 6px;
    padding: 2px 8px; font-weight: 600;
}

/* ===== DESKTOP TABLE (hidden on mobile) ===== */
.ord-table-wrap { overflow-x: auto; display: none; }
.ord-table {
    width: 100%; border-collapse: collapse;
    font-size: 13px; min-width: 760px;
}
.ord-table thead tr { background: #f9fafb; border-bottom: 1px solid #f0f0f0; }
.ord-table th {
    padding: 9px 13px; text-align: left;
    font-weight: 700; color: #6b7280;
    font-size: 11px; text-transform: uppercase; letter-spacing: .5px;
    white-space: nowrap;
}
.ord-table tbody tr { border-bottom: 1px solid #f9fafb; transition: background .1s; }
.ord-table tbody tr:last-child { border-bottom: none; }
.ord-table tbody tr:hover { background: #fafbff; }
.ord-table td { padding: 9px 13px; color: #374151; vertical-align: middle; }

/* ===== MOBILE CARDS (shown on mobile) ===== */
.order-cards { display: flex; flex-direction: column; }
.order-card {
    padding: 13px 14px;
    border-bottom: 1px solid #f3f4f6;
    transition: background .1s;
}
.order-card:last-child { border-bottom: none; }
.order-card:active { background: #fafbff; }

.oc-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 7px;
    gap: 8px;
}
.oc-id { font-size: 11px; color: #c0c5cc; font-weight: 700; flex-shrink: 0; margin-top: 2px; }
.oc-customer { flex: 1; }
.oc-name { font-size: 14px; font-weight: 700; color: #111827; }
.oc-phone { font-size: 11px; color: #9ca3af; margin-top: 1px; }

.oc-mid {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 9px;
    flex-wrap: wrap;
}
.oc-car {
    font-size: 12px; color: #374151; font-weight: 500;
    background: #f9fafb; border: 1px solid #f0f0f0;
    border-radius: 6px; padding: 3px 8px;
    flex: 1; min-width: 0;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.staff-chip {
    display: inline-flex; align-items: center;
    background: #f3f4f6; color: #374151;
    font-size: 11px; font-weight: 600;
    padding: 3px 8px; border-radius: 5px;
    border: 1px solid #e5e7eb;
    flex-shrink: 0;
}

.oc-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}
.oc-meta { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.oc-price { font-size: 13px; font-weight: 700; color: #1d4ed8; }
.oc-commission { font-size: 12px; font-weight: 600; color: #16a34a; }
.oc-dash { font-size: 12px; color: #d1d5db; }
.oc-date { font-size: 11px; color: #9ca3af; }

.oc-actions { display: flex; gap: 5px; flex-shrink: 0; }

/* ===== Badges ===== */
.badge {
    display: inline-flex; align-items: center; gap: 3px;
    padding: 3px 9px; border-radius: 20px;
    font-size: 11px; font-weight: 700;
    border: 1px solid transparent; white-space: nowrap;
}
.badge-warning { background: #fffbeb; color: #b45309; border-color: #fde68a; }
.badge-info    { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
.badge-success { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }

/* ===== Action buttons ===== */
.act-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: 3px;
    padding: 6px 11px; border-radius: 8px; font-size: 12px;
    font-family: inherit; font-weight: 600; cursor: pointer;
    text-decoration: none; border: 1px solid transparent;
    transition: all .15s; white-space: nowrap;
    min-height: 32px;
}
.act-view   { background: #f3f4f6; color: #374151; border-color: #e5e7eb; }
.act-view:hover, .act-view:active { background: #e5e7eb; }
.act-close  { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
.act-close:hover, .act-close:active { background: #dcfce7; }
.act-delete { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
.act-delete:hover, .act-delete:active { background: #fee2e2; }

/* ===== Empty ===== */
.empty-state { padding: 40px; text-align: center; color: #9ca3af; font-size: 13px; }

/* ===== Pagination ===== */
.pag-wrap { padding: 10px 14px; border-top: 1px solid #f0f0f0; }

/* ===== Modal shared ===== */
.modal-overlay {
    display: none; position: fixed; inset: 0;
    z-index: 9999; background: rgba(15,23,42,.5);
    align-items: flex-end; justify-content: center;
    padding: 0;
}
.modal-box {
    background: #fff;
    border-radius: 20px 20px 0 0;
    width: 100%;
    max-width: 540px;
    max-height: 92vh;
    overflow-y: auto;
    box-shadow: 0 -8px 40px rgba(0,0,0,.15);
    animation: slideUp .22s ease;
}
@keyframes slideUp {
    from { transform: translateY(40px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
}

/* Drag handle */
.modal-handle {
    width: 36px; height: 4px;
    background: #e5e7eb; border-radius: 2px;
    margin: 10px auto 0;
}

/* ===== Close-order modal ===== */
.cmodal-header { padding: 14px 20px 0; display: flex; align-items: center; gap: 12px; }
.cmodal-icon {
    width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 19px;
}
.cmodal-icon-green { background: #f0fdf4; border: 1px solid #bbf7d0; }
.cmodal-title { font-size: 16px; font-weight: 700; color: #111827; margin: 0; }
.cmodal-sub   { font-size: 12px; color: #9ca3af; margin: 2px 0 0; }
.cmodal-body  { padding: 14px 20px; display: flex; flex-direction: column; gap: 11px; }

.modal-label {
    font-size: 11px; font-weight: 700; color: #6b7280;
    text-transform: uppercase; letter-spacing: .4px;
    display: block; margin-bottom: 5px;
}
.modal-input {
    width: 100%; padding: 10px 12px;
    border: 1px solid #e5e7eb; border-radius: 10px;
    font-size: 14px; font-family: inherit; color: #111827;
    outline: none; background: #fff;
    transition: border .15s, box-shadow .15s;
    box-sizing: border-box;
    -webkit-appearance: none;
}
.modal-input:focus { border-color: #93c5fd; box-shadow: 0 0 0 3px #dbeafe40; }
.modal-textarea { resize: vertical; min-height: 70px; }

.commission-box {
    background: #f8fbff; border: 1px solid #e0ecff;
    border-radius: 10px; padding: 11px 13px;
    display: flex; align-items: center; justify-content: space-between;
}
.commission-box-left .label { font-size: 12px; color: #6b7280; font-weight: 500; }
.commission-box-left .hint  { font-size: 10.5px; color: #9ca3af; margin-top: 2px; }
.commission-box-right .value { font-size: 16px; font-weight: 700; color: #16a34a; text-align: right; }
.commission-box-right .rate  { font-size: 11px; color: #9ca3af; text-align: right; }

.cmodal-footer {
    padding: 10px 20px 24px;
    display: flex; gap: 8px;
}

/* ===== Delete confirm modal ===== */
.dmodal-header { padding: 14px 20px 0; display: flex; align-items: flex-start; gap: 13px; }
.dmodal-icon {
    width: 42px; height: 42px; border-radius: 10px; flex-shrink: 0;
    background: #fef2f2; border: 1px solid #fecaca;
    display: flex; align-items: center; justify-content: center; font-size: 20px;
}
.dmodal-title { font-size: 16px; font-weight: 700; color: #111827; margin: 0 0 4px; }
.dmodal-desc  { font-size: 13px; color: #6b7280; margin: 0; line-height: 1.5; }
.dmodal-warn  {
    margin: 13px 20px 0;
    background: #fef2f2; border: 1px solid #fecaca;
    border-radius: 10px; padding: 10px 13px;
    font-size: 12px; color: #dc2626; font-weight: 500;
    display: flex; align-items: center; gap: 6px;
}
.dmodal-footer {
    padding: 14px 20px 24px;
    display: flex; gap: 8px;
}

/* Shared modal buttons */
.mbtn {
    flex: 1; padding: 12px 18px; border-radius: 10px; font-size: 14px;
    font-family: inherit; font-weight: 700; cursor: pointer;
    border: 1px solid transparent; transition: all .15s;
    display: inline-flex; align-items: center; justify-content: center; gap: 5px;
    min-height: 46px;
}
.mbtn-cancel { background: #f3f4f6; color: #374151; border-color: #e5e7eb; }
.mbtn-cancel:hover, .mbtn-cancel:active { background: #e5e7eb; }
.mbtn-confirm-green { background: #16a34a; color: #fff; }
.mbtn-confirm-green:hover, .mbtn-confirm-green:active { background: #15803d; }
.mbtn-confirm-red { background: #dc2626; color: #fff; }
.mbtn-confirm-red:hover, .mbtn-confirm-red:active { background: #b91c1c; }

/* ===== RESPONSIVE BREAKPOINTS ===== */

/* Mobile: card layout */
@media (max-width: 767px) {
    .ord-wrap { padding: 12px 12px 0; }
    .stat-row { grid-template-columns: repeat(3, 1fr); gap: 7px; margin-bottom: 10px; }
    .stat-card { padding: 10px 9px; border-radius: 11px; }
    .stat-card-value { font-size: 22px; }
    .order-cards { display: flex; }
    .ord-table-wrap { display: none; }
}

/* Desktop: table layout */
@media (min-width: 768px) {
    .ord-wrap { padding: 18px 20px 0; }
    .filter-card { flex-direction: row; align-items: flex-end; }
    .filter-row { flex-wrap: nowrap; flex: 1; }
    .filter-actions { flex: none; }
    .filter-btn { flex: none; }
    .filter-group { flex: none; }
    .filter-select { width: auto; }
    .order-cards { display: none; }
    .ord-table-wrap { display: block; }

    /* Desktop modal: centered */
    .modal-overlay { align-items: center; padding: 16px; }
    .modal-box {
        border-radius: 16px;
        width: 420px;
        max-height: 90vh;
        animation: modalIn .18s ease;
    }
    @keyframes modalIn {
        from { opacity:0; transform:scale(.95) translateY(8px); }
        to   { opacity:1; transform:scale(1)   translateY(0); }
    }
    .modal-handle { display: none; }
    .cmodal-footer, .dmodal-footer { justify-content: flex-end; }
    .mbtn { flex: none; }
    .stat-card-value { font-size: 26px; }
    .stat-card-label { font-size: 11px; }
}
</style>

<div class="ord-wrap">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="ord-alert ord-alert-success">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="ord-alert ord-alert-error">✕ {{ session('error') }}</div>
    @endif

    {{-- Stat cards --}}
    <div class="stat-row">
        <a href="{{ route('admin.orders.index', ['consultation_status'=>'chua_tu_van']) }}" class="stat-card">
            <div class="stat-card-label">Chưa tư vấn</div>
            <div class="stat-card-value stat-warning">{{ $orders->where('consultation_status','chua_tu_van')->count() }}</div>
            <div class="stat-card-sub">Cần xử lý</div>
        </a>
        <a href="{{ route('admin.orders.index', ['consultation_status'=>'da_tu_van']) }}" class="stat-card">
            <div class="stat-card-label">Chờ chốt</div>
            <div class="stat-card-value stat-blue">{{ $orders->where('consultation_status','da_tu_van')->count() }}</div>
            <div class="stat-card-sub">Đã tư vấn</div>
        </a>
        <a href="{{ route('admin.orders.index', ['consultation_status'=>'da_chot_don']) }}" class="stat-card">
            <div class="stat-card-label">Đã chốt</div>
            <div class="stat-card-value stat-green">{{ $orders->where('consultation_status','da_chot_don')->count() }}</div>
            <div class="stat-card-sub">Thành công</div>
        </a>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" style="display:contents">
            <div class="filter-row">
                <div class="filter-group">
                    <span class="filter-label">Trạng thái tư vấn</span>
                    <select name="consultation_status" class="filter-select">
                        <option value="">Tất cả trạng thái</option>
                        <option value="chua_tu_van" @selected(request('consultation_status')==='chua_tu_van')>Chưa tư vấn</option>
                        <option value="da_tu_van"   @selected(request('consultation_status')==='da_tu_van')>Đã tư vấn</option>
                        <option value="da_chot_don" @selected(request('consultation_status')==='da_chot_don')>Đã chốt đơn</option>
                    </select>
                </div>
                <div class="filter-group">
                    <span class="filter-label">Nhân viên</span>
                    <select name="staff_id" class="filter-select">
                        <option value="">Tất cả</option>
                        @foreach($staffList ?? [] as $s)
                            <option value="{{ $s->id }}" @selected(request('staff_id')==$s->id)>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="filter-actions">
                <button type="submit" class="filter-btn filter-btn-primary">Lọc</button>
                <a href="{{ route('admin.orders.index') }}" class="filter-btn filter-btn-reset"> Xóa</a>
            </div>
        </form>
    </div>

    {{-- Table / Cards --}}
    <div class="table-card">
        <div class="table-card-header">
            <span class="table-card-title">Danh sách đơn hàng</span>
            <span class="table-count-badge">{{ $orders->total() }} đơn</span>
        </div>

        {{-- ===== MOBILE: Card layout ===== --}}
        <div class="order-cards">
            @forelse($orders as $order)
            <div class="order-card">
                {{-- Top row: ID + customer + badge --}}
                <div class="oc-top">
                    <span class="oc-id">#{{ $order->id }}</span>
                    <div class="oc-customer">
                        <div class="oc-name">{{ $order->customer_name }}</div>
                        <div class="oc-phone">{{ $order->customer_phone }}</div>
                    </div>
                    @if($order->consultation_status === 'chua_tu_van')
                        <span class="badge badge-warning">Chưa tư vấn</span>
                    @elseif($order->consultation_status === 'da_tu_van')
                        <span class="badge badge-info">Đã tư vấn ✓</span>
                    @else
                        <span class="badge badge-success">Đã chốt 🎉</span>
                    @endif
                </div>

                {{-- Mid row: car + staff --}}
                <div class="oc-mid">
                    <span class="oc-car">🚗 {{ $order->car->name ?? 'N/A' }}</span>
                    @if($order->assignedStaff)
                        <span class="staff-chip">{{ $order->assignedStaff->name }}</span>
                    @endif
                </div>

                {{-- Bottom: price + commission + date + actions --}}
                <div class="oc-bottom">
                    <div class="oc-meta">
                        @if($order->sale_price)
                            <span class="oc-price">{{ number_format($order->sale_price,0,',','.') }}đ</span>
                        @endif
                        @if($order->commission_amount)
                            <span class="oc-commission">+{{ number_format($order->commission_amount,0,',','.') }}đ</span>
                        @endif
                        @if(!$order->sale_price && !$order->commission_amount)
                            <span class="oc-dash">—</span>
                        @endif
                        <span class="oc-date">{{ $order->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="oc-actions">
                        <a href="{{ route('admin.orders.show', $order) }}" class="act-btn act-view">Xem</a>
                        @if($order->consultation_status === 'da_tu_van')
                            <button type="button" class="act-btn act-close"
                                onclick="openCloseModal({{ $order->id }},'{{ addslashes($order->car->name ?? '') }}',{{ $order->car->price_per_day ?? 0 }})">
                                Chốt
                            </button>
                        @endif
                        @if(auth()->user()->isAdmin())
                            <button type="button" class="act-btn act-delete"
                                onclick="openDeleteModal({{ $order->id }},'{{ addslashes($order->customer_name) }}','{{ route('admin.orders.destroy', $order) }}')">
                                Xóa
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">Không có đơn hàng nào.</div>
            @endforelse
        </div>

        {{-- ===== DESKTOP: Table layout ===== --}}
        <div class="ord-table-wrap">
            <table class="ord-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Khách hàng</th>
                        <th>Xe</th>
                        <th>Nhân viên</th>
                        <th>Tư vấn</th>
                        <th>Giá chốt</th>
                        <th>Hoa hồng</th>
                        <th>Ngày</th>
                        <th style="text-align:right">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td><span style="font-size:12px;color:#c0c5cc;font-weight:700">#{{ $order->id }}</span></td>
                        <td>
                            <div style="font-weight:600;color:#111827;font-size:13px">{{ $order->customer_name }}</div>
                            <div style="font-size:11px;color:#9ca3af;margin-top:1px">{{ $order->customer_phone }}</div>
                        </td>
                        <td><span style="font-size:13px;font-weight:500;color:#374151">{{ $order->car->name ?? 'N/A' }}</span></td>
                        <td>
                            @if($order->assignedStaff)
                                <span class="staff-chip">{{ $order->assignedStaff->name }}</span>
                            @else
                                <span style="color:#d1d5db;font-size:12px">—</span>
                            @endif
                        </td>
                        <td>
                            @if($order->consultation_status === 'chua_tu_van')
                                <span class="badge badge-warning">Chưa tư vấn</span>
                            @elseif($order->consultation_status === 'da_tu_van')
                                <span class="badge badge-info">Đã tư vấn</span>
                            @else
                                <span class="badge badge-success">Đã chốt</span>
                            @endif
                        </td>
                        <td>
                            <span style="{{ $order->sale_price ? 'font-size:13px;font-weight:700;color:#1d4ed8' : 'color:#d1d5db;font-size:12px' }}">
                                {{ $order->sale_price ? number_format($order->sale_price,0,',','.') . 'đ' : '—' }}
                            </span>
                        </td>
                        <td>
                            <span style="{{ $order->commission_amount ? 'font-size:13px;font-weight:600;color:#16a34a' : 'color:#d1d5db;font-size:12px' }}">
                                {{ $order->commission_amount ? number_format($order->commission_amount,0,',','.') . 'đ' : '—' }}
                            </span>
                        </td>
                        <td><span style="font-size:12px;color:#9ca3af;white-space:nowrap">{{ $order->created_at->format('d/m/Y') }}</span></td>
                        <td>
                            <div style="display:inline-flex;gap:5px;align-items:center;justify-content:flex-end">
                                <a href="{{ route('admin.orders.show', $order) }}" class="act-btn act-view">Xem</a>
                                @if($order->consultation_status === 'da_tu_van')
                                    <button type="button" class="act-btn act-close"
                                        onclick="openCloseModal({{ $order->id }},'{{ addslashes($order->car->name ?? '') }}',{{ $order->car->price_per_day ?? 0 }})">
                                        ✓ Chốt
                                    </button>
                                @endif
                                @if(auth()->user()->isAdmin())
                                    <button type="button" class="act-btn act-delete"
                                        onclick="openDeleteModal({{ $order->id }},'{{ addslashes($order->customer_name) }}','{{ route('admin.orders.destroy', $order) }}')">
                                        Xóa
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9"><div class="empty-state">Không có đơn hàng nào.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="pag-wrap">{{ $orders->links() }}</div>
        @endif
    </div>

    <div style="height:24px"></div>
</div>

{{-- ===== Modal chốt đơn ===== --}}
<div id="close-modal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-handle"></div>
        <div class="cmodal-header">
            <div class="cmodal-icon cmodal-icon-green">✅</div>
            <div>
                <h3 class="cmodal-title">Chốt đơn hàng</h3>
                <p class="cmodal-sub" id="modal-car-name"></p>
            </div>
        </div>
        <form id="close-order-form" method="POST" action="">
            @csrf
            <div class="cmodal-body">
                <div>
                    <label class="modal-label">Giá bán cuối (đ) <span style="color:#dc2626">*</span></label>
                    <input type="number" name="sale_price" id="modal-sale-price"
                           class="modal-input" placeholder="5500000000"
                           required oninput="calcModalCommission()">
                </div>

                <div class="commission-box">
                    <div class="commission-box-left">
                        <div class="label">Hoa hồng dự tính</div>
                        <div class="hint">0.05% nếu &lt; 10 tỷ &nbsp;·&nbsp; 0.1% nếu ≥ 10 tỷ</div>
                    </div>
                    <div class="commission-box-right">
                        <div class="value" id="modal-commission-val">—</div>
                        <div class="rate"  id="modal-commission-rate"></div>
                    </div>
                </div>

                <div>
                    <label class="modal-label">Ghi chú</label>
                    <textarea name="manager_note" class="modal-input modal-textarea" placeholder="Ghi chú thêm..."></textarea>
                </div>
            </div>
            <div class="cmodal-footer">
                <button type="button" onclick="closeCloseModal()" class="mbtn mbtn-cancel">Hủy</button>
                <button type="submit" class="mbtn mbtn-confirm-green">✅ Xác nhận chốt</button>
            </div>
        </form>
    </div>
</div>

{{-- ===== Modal xác nhận xóa ===== --}}
<div id="delete-modal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-handle"></div>
        <div class="dmodal-header">
            <div class="dmodal-icon">🗑</div>
            <div>
                <h3 class="dmodal-title">Xóa đơn hàng</h3>
                <p class="dmodal-desc" id="delete-modal-desc">Bạn có chắc muốn xóa đơn này không?</p>
            </div>
        </div>
        <div class="dmodal-warn">
            ⚠️ Hành động này không thể hoàn tác sau khi xác nhận.
        </div>
        <form id="delete-order-form" method="POST" action="">
            @csrf @method('DELETE')
            <div class="dmodal-footer">
                <button type="button" onclick="closeDeleteModal()" class="mbtn mbtn-cancel">Hủy bỏ</button>
                <button type="submit" class="mbtn mbtn-confirm-red">🗑 Xóa đơn hàng</button>
            </div>
        </form>
    </div>
</div>

<script>
/* ---- Close order modal ---- */
function openCloseModal(orderId, carName, defaultPrice) {
    const base = '{{ route("admin.orders.close", ["order"=>"__ID__"]) }}'.replace('__ID__', orderId);
    document.getElementById('close-order-form').action = base;
    document.getElementById('modal-car-name').textContent = carName || '';
    const priceInput = document.getElementById('modal-sale-price');
    priceInput.value = defaultPrice > 0 ? defaultPrice : '';
    document.getElementById('close-modal').style.display = 'flex';
    calcModalCommission();
    // Prevent body scroll
    document.body.style.overflow = 'hidden';
}
function closeCloseModal() {
    document.getElementById('close-modal').style.display = 'none';
    document.body.style.overflow = '';
}
document.getElementById('close-modal').addEventListener('click', function(e) {
    if (e.target === this) closeCloseModal();
});
function calcModalCommission() {
    const price = parseFloat(document.getElementById('modal-sale-price').value) || 0;
    const rate  = price >= 10000000000 ? 0.1 : 0.05;
    const comm  = Math.round(price * rate / 100);
    document.getElementById('modal-commission-val').textContent =
        price > 0 ? new Intl.NumberFormat('vi-VN').format(comm) + 'đ' : '—';
    document.getElementById('modal-commission-rate').textContent =
        price > 0 ? '(' + rate + '%)' : '';
}

/* ---- Delete modal ---- */
function openDeleteModal(orderId, customerName, actionUrl) {
    document.getElementById('delete-order-form').action = actionUrl;
    document.getElementById('delete-modal-desc').textContent =
        'Bạn sắp xóa đơn #' + orderId + ' của khách "' + customerName + '".';
    document.getElementById('delete-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeDeleteModal() {
    document.getElementById('delete-modal').style.display = 'none';
    document.body.style.overflow = '';
}
document.getElementById('delete-modal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>
@endsection