@extends('layouts.admin')

@section('page-title', 'Quản lý khách hàng')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

.cm-wrap {
    font-family: 'DM Sans', sans-serif;
    padding: 14px 14px 32px;
    background: #f5f6fa;
    min-height: 100vh;
}
.cm-wrap *, .cm-wrap *::before, .cm-wrap *::after { box-sizing: border-box; }

/* ── Filter bar ── */
.cm-filter {
    display: flex;
    flex-direction: column;
    gap: 9px;
    margin-bottom: 12px;
    padding: 13px 14px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
}
.cm-filter-row { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }

.cm-search-wrap {
    position: relative;
    flex: 1;
    min-width: 0;
}
.cm-search-wrap svg {
    position: absolute;
    left: 11px; top: 50%;
    transform: translateY(-50%);
    width: 15px; height: 15px;
    color: #9ca3af; pointer-events: none;
}
.cm-input {
    width: 100%;
    padding: 9px 12px 9px 34px;
    border: 1.5px solid #e5e7eb;
    border-radius: 9px;
    font-size: 13.5px;
    font-family: inherit;
    color: #111827;
    background: #f9fafb;
    outline: none;
    transition: border-color .15s, background .15s;
    -webkit-appearance: none;
}
.cm-input:focus {
    border-color: #6366f1;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(99,102,241,.08);
}
.cm-input::placeholder { color: #c4c9d4; }

.cm-selects-row { display: flex; gap: 8px; }

.cm-select {
    flex: 1;
    min-width: 0;
    padding: 9px 28px 9px 10px;
    border: 1.5px solid #e5e7eb;
    border-radius: 9px;
    font-size: 13px;
    font-family: inherit;
    color: #374151;
    background: #f9fafb url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 9px center;
    -webkit-appearance: none; appearance: none;
    outline: none; cursor: pointer;
    transition: border-color .15s;
}
.cm-select:focus { border-color: #6366f1; background-color: #fff; box-shadow: 0 0 0 3px rgba(99,102,241,.08); }

.cm-filter-actions { display: flex; gap: 7px; }
.cm-btn-filter {
    flex: 1;
    padding: 9px 16px;
    background: #111827;
    color: #fff;
    border: none;
    border-radius: 9px;
    font-size: 13.5px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    transition: background .15s;
    white-space: nowrap;
}
.cm-btn-filter:hover { background: #1f2937; }

.cm-btn-clear {
    flex: 1;
    padding: 9px 12px;
    background: transparent;
    color: #6b7280;
    border: 1.5px solid #e5e7eb;
    border-radius: 9px;
    font-size: 13px;
    font-family: inherit;
    cursor: pointer;
    text-decoration: none;
    display: flex; align-items: center; justify-content: center; gap: 5px;
    transition: all .15s;
    white-space: nowrap;
}
.cm-btn-clear:hover { border-color: #ef4444; color: #ef4444; background: #fef2f2; }

/* ── Table card ── */
.cm-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    overflow: hidden;
}
.cm-card-header {
    padding: 12px 14px;
    border-bottom: 1px solid #f0f0f0;
    display: flex; align-items: center; justify-content: space-between;
}
.cm-card-title { font-size: 14px; font-weight: 700; color: #111827; }
.cm-count-badge {
    font-size: 11px; color: #6b7280; background: #f3f4f6;
    border: 1px solid #e5e7eb; border-radius: 6px;
    padding: 2px 8px; font-weight: 600;
}

/* ── DESKTOP TABLE ── */
.cm-table-wrap { display: none; overflow-x: auto; }
.cm-table {
    width: 100%;
    border-collapse: collapse;
}
.cm-table thead tr {
    background: #f8f9fb;
    border-bottom: 1px solid #e5e7eb;
}
.cm-table thead th {
    padding: 10px 14px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .55px;
    color: #9ca3af;
    text-align: left;
    white-space: nowrap;
}
.cm-table tbody tr {
    border-bottom: 1px solid #f3f4f6;
    transition: background .1s;
}
.cm-table tbody tr:last-child { border-bottom: none; }
.cm-table tbody tr:hover { background: #fafbff; }
.cm-table td { padding: 12px 14px; vertical-align: middle; }

/* ── MOBILE CARDS ── */
.cm-cards { display: flex; flex-direction: column; }
.cm-cust-card {
    padding: 13px 14px;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
    align-items: center;
    gap: 11px;
    text-decoration: none;
    transition: background .1s;
}
.cm-cust-card:last-child { border-bottom: none; }
.cm-cust-card:active { background: #fafbff; }

.cm-card-avatar {
    width: 40px; height: 40px;
    border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 15px;
    flex-shrink: 0;
}

.cm-card-body { flex: 1; min-width: 0; }
.cm-card-top {
    display: flex; align-items: center;
    justify-content: space-between; gap: 8px; margin-bottom: 4px;
}
.cm-card-name { font-size: 14px; font-weight: 700; color: #111827; }
.cm-card-phone {
    font-size: 11.5px; color: #9ca3af;
    font-family: 'DM Mono', monospace;
}
.cm-card-bottom {
    display: flex; align-items: center;
    gap: 8px; flex-wrap: wrap; margin-top: 4px;
}
.cm-card-email { font-size: 12px; color: #6b7280; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.cm-card-staff { font-size: 11px; color: #9ca3af; flex-shrink: 0; }
.cm-card-arrow {
    color: #d1d5db; flex-shrink: 0;
    display: flex; align-items: center;
}

/* ── Shared ── */
.cm-avatar {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 14px;
    flex-shrink: 0;
}
.cm-customer-cell { display: flex; align-items: center; gap: 10px; }
.cm-customer-name { font-size: 14px; font-weight: 600; color: #111827; line-height: 1.3; }
.cm-customer-phone { font-size: 12px; color: #9ca3af; font-family: 'DM Mono', monospace; margin-top: 2px; }
.cm-email { font-size: 13.5px; color: #4b5563; }
.cm-staff-name { font-size: 14px; font-weight: 600; color: #111827; }
.cm-staff-role { font-size: 12px; color: #9ca3af; margin-top: 2px; }
.cm-note { font-size: 13px; color: #6b7280; max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.cm-num { font-size: 12px; font-family: 'DM Mono', monospace; color: #d1d5db; font-weight: 500; }

.cm-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px;
    border-radius: 20px;
    font-size: 11px; font-weight: 600;
    white-space: nowrap; flex-shrink: 0;
}
.cm-badge-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.cm-badge-gray  { background: #f3f4f6; color: #6b7280; }
.cm-badge-gray  .cm-badge-dot { background: #9ca3af; }
.cm-badge-blue  { background: #eff6ff; color: #1d4ed8; }
.cm-badge-blue  .cm-badge-dot { background: #3b82f6; }
.cm-badge-green { background: #f0fdf4; color: #15803d; }
.cm-badge-green .cm-badge-dot { background: #22c55e; }

/* ── Loyal badge ── */
.cm-badge-loyal {
    display: inline-block;
    font-size: 11px;
    background: #fef3c7;
    color: #d97706;
    padding: 2px 8px;
    border-radius: 999px;
    font-weight: 700;
    border: 1px solid #fde68a;
    white-space: nowrap;
    margin-left: 4px;
    vertical-align: middle;
}

.cm-btn-detail {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 12px;
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #e5e7eb;
    border-radius: 7px;
    font-size: 12.5px; font-weight: 600;
    font-family: inherit;
    text-decoration: none;
    transition: all .15s;
    white-space: nowrap;
}
.cm-btn-detail:hover { background: #111827; color: #fff; border-color: #111827; }
.cm-btn-detail svg { width: 13px; height: 13px; }

/* Empty */
.cm-empty { text-align: center; padding: 60px 20px; color: #9ca3af; }
.cm-empty-icon {
    width: 52px; height: 52px; background: #f3f4f6;
    border-radius: 14px; display: flex; align-items: center;
    justify-content: center; margin: 0 auto 14px;
}
.cm-empty-icon svg { width: 24px; height: 24px; color: #d1d5db; }
.cm-empty-title { font-size: 15px; font-weight: 600; color: #374151; margin-bottom: 4px; }
.cm-empty-sub   { font-size: 13px; }

.cm-pagination { padding: 12px 14px; border-top: 1px solid #f3f4f6; }

/* ── RESPONSIVE ── */
@media (max-width: 767px) {
    .cm-wrap { padding: 12px 12px 32px; }
    .cm-cards { display: flex; }
    .cm-table-wrap { display: none !important; }
}
@media (min-width: 768px) {
    .cm-wrap { padding: 16px 20px 32px; }
    .cm-filter { flex-direction: row; align-items: center; flex-wrap: wrap; }
    .cm-filter-row { flex: 1; flex-wrap: nowrap; }
    .cm-search-wrap { max-width: 260px; }
    .cm-selects-row { flex: 1; }
    .cm-select { flex: none; width: auto; }
    .cm-filter-actions { flex: none; }
    .cm-btn-filter, .cm-btn-clear { flex: none; width: auto; }
    .cm-cards { display: none !important; }
    .cm-table-wrap { display: block; }
}
</style>

<div class="cm-wrap">

    {{-- Filter bar --}}
    <form method="GET" action="{{ route('admin.staff.customers') }}" class="cm-filter">

        {{-- Search --}}
        <div class="cm-filter-row">
            <div class="cm-search-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Tên, email, số điện thoại..." class="cm-input">
            </div>
        </div>

        {{-- Selects --}}
        <div class="cm-selects-row">
            @if($staffList->isNotEmpty())
            <select name="staff_id" class="cm-select">
                <option value="">Tất cả nhân viên</option>
                @foreach($staffList as $staff)
                    <option value="{{ $staff->id }}" {{ request('staff_id') == $staff->id ? 'selected' : '' }}>
                        {{ $staff->name }}
                    </option>
                @endforeach
            </select>
            @endif

            <select name="status" class="cm-select">
                <option value="">Tất cả trạng thái</option>
                <option value="chua_tu_van" {{ request('status') === 'chua_tu_van' ? 'selected' : '' }}>Chưa tư vấn</option>
                <option value="da_tu_van"   {{ request('status') === 'da_tu_van'   ? 'selected' : '' }}>Đã tư vấn</option>
                <option value="da_chot_don" {{ request('status') === 'da_chot_don' ? 'selected' : '' }}>Đã chốt đơn</option>
            </select>
        </div>

        {{-- Actions --}}
        <div class="cm-filter-actions">
            <button type="submit" class="cm-btn-filter">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                </svg>
                Lọc
            </button>
            @if(request('search') || request('staff_id') || request('status'))
            <a href="{{ route('admin.staff.customers') }}" class="cm-btn-clear">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18M6 6l12 12"/>
                </svg>
                Xóa lọc
            </a>
            @endif
        </div>
    </form>

    {{-- Table/Card wrapper --}}
    <div class="cm-card">
        <div class="cm-card-header">
            <span class="cm-card-title">Danh sách khách hàng</span>
            <span class="cm-count-badge">{{ $orders->total() }} khách</span>
        </div>

        {{-- ===== MOBILE: Cards ===== --}}
        <div class="cm-cards">
            @forelse($orders as $i => $order)
            @php
                $initials = collect(explode(' ', $order->customer_name))->map(fn($w) => strtoupper(mb_substr($w,0,1)))->last(null, '?');
                $colors = ['#e0e7ff,#6366f1','#fce7f3,#db2777','#d1fae5,#059669','#fef3c7,#d97706','#fee2e2,#dc2626','#e0f2fe,#0284c7'];
                $col = $colors[$order->id % count($colors)];
                [$bg, $fg] = explode(',', $col);
                $statusMap = [
                    'chua_tu_van' => ['label' => 'Chưa tư vấn', 'class' => 'cm-badge-gray'],
                    'da_tu_van'   => ['label' => 'Đã tư vấn',   'class' => 'cm-badge-blue'],
                    'da_chot_don' => ['label' => 'Đã chốt đơn', 'class' => 'cm-badge-green'],
                ];
                $s = $statusMap[$order->consultation_status ?? ''] ?? ['label' => '—', 'class' => 'cm-badge-gray'];
                $loyalKey = $order->customer_phone . '|' . $order->customer_name;
                $isLoyal  = ($allOrders[$loyalKey] ?? 0) >= 2;
            @endphp
            <a href="{{ route('admin.orders.show', $order) }}" class="cm-cust-card">
                <div class="cm-card-avatar" style="background:{{ $bg }};color:{{ $fg }}">{{ $initials }}</div>
                <div class="cm-card-body">
                    <div class="cm-card-top">
                        <div>
                            <div class="cm-card-name">
                                {{ $order->customer_name }}
                                @if($isLoyal)
                                    <span class="cm-badge-loyal">⭐ Thân thuộc</span>
                                @endif
                            </div>
                            <div class="cm-card-phone">{{ $order->customer_phone }}</div>
                        </div>
                        <span class="cm-badge {{ $s['class'] }}">
                            <span class="cm-badge-dot"></span>{{ $s['label'] }}
                        </span>
                    </div>
                    <div class="cm-card-bottom">
                        <span class="cm-card-email">{{ $order->customer_email }}</span>
                        @if($order->assignedUser)
                            <span class="cm-card-staff">· {{ $order->assignedUser->name }}</span>
                        @endif
                    </div>
                </div>
                <div class="cm-card-arrow">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                </div>
            </a>
            @empty
            <div class="cm-empty">
                <div class="cm-empty-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div class="cm-empty-title">Chưa có khách hàng nào</div>
                <div class="cm-empty-sub">Thử thay đổi bộ lọc hoặc tìm kiếm khác</div>
            </div>
            @endforelse
        </div>

        {{-- ===== DESKTOP: Table ===== --}}
        <div class="cm-table-wrap">
            <table class="cm-table">
                <thead>
                    <tr>
                        <th style="width:44px">#</th>
                        <th>Khách hàng</th>
                        <th>Email</th>
                        @if($staffList->isNotEmpty())
                        <th>Nhân viên phụ trách</th>
                        @endif
                        <th>Trạng thái</th>
                        <th>Ghi chú</th>
                        <th style="text-align:center;width:100px">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $i => $order)
                    @php
                        $initials = collect(explode(' ', $order->customer_name))->map(fn($w) => strtoupper(mb_substr($w,0,1)))->last(null, '?');
                        $colors = ['#e0e7ff,#6366f1','#fce7f3,#db2777','#d1fae5,#059669','#fef3c7,#d97706','#fee2e2,#dc2626','#e0f2fe,#0284c7'];
                        $col = $colors[$order->id % count($colors)];
                        [$bg, $fg] = explode(',', $col);
                        $statusMap = [
                            'chua_tu_van' => ['label' => 'Chưa tư vấn', 'class' => 'cm-badge-gray'],
                            'da_tu_van'   => ['label' => 'Đã tư vấn',   'class' => 'cm-badge-blue'],
                            'da_chot_don' => ['label' => 'Đã chốt đơn', 'class' => 'cm-badge-green'],
                        ];
                        $s = $statusMap[$order->consultation_status ?? ''] ?? ['label' => $order->consultation_label ?? '—', 'class' => 'cm-badge-gray'];
                        $loyalKey = $order->customer_phone . '|' . $order->customer_name;
                        $isLoyal  = ($allOrders[$loyalKey] ?? 0) >= 2;
                    @endphp
                    <tr>
                        <td><span class="cm-num">{{ $orders->firstItem() + $i }}</span></td>
                        <td>
                            <div class="cm-customer-cell">
                                <div class="cm-avatar" style="background:{{ $bg }};color:{{ $fg }}">{{ $initials }}</div>
                                <div>
                                    <div class="cm-customer-name">
                                        {{ $order->customer_name }}
                                        @if($isLoyal)
                                            <span class="cm-badge-loyal">⭐ Thân thuộc</span>
                                        @endif
                                    </div>
                                    <div class="cm-customer-phone">{{ $order->customer_phone }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="cm-email">{{ $order->customer_email }}</span></td>
                        @if($staffList->isNotEmpty())
                        <td>
                            @if($order->assignedUser)
                                <div class="cm-staff-name">{{ $order->assignedUser->name }}</div>
                                <div class="cm-staff-role">
                                    @if($order->assignedUser->isStaff()) Nhân viên
                                    @elseif($order->assignedUser->isManager()) Manager
                                    @else Admin
                                    @endif
                                </div>
                            @else
                                <span style="color:#d1d5db;font-size:13px">Chưa phân công</span>
                            @endif
                        </td>
                        @endif
                        <td>
                            <span class="cm-badge {{ $s['class'] }}">
                                <span class="cm-badge-dot"></span>{{ $s['label'] }}
                            </span>
                        </td>
                        <td>
                            <span class="cm-note" title="{{ $order->note }}">{{ $order->note ?? '—' }}</span>
                        </td>
                        <td style="text-align:center">
                            <a href="{{ route('admin.orders.show', $order) }}" class="cm-btn-detail">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                                Chi tiết
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $staffList->isNotEmpty() ? 7 : 6 }}">
                            <div class="cm-empty">
                                <div class="cm-empty-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    </svg>
                                </div>
                                <div class="cm-empty-title">Chưa có khách hàng nào</div>
                                <div class="cm-empty-sub">Thử thay đổi bộ lọc hoặc tìm kiếm khác</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="cm-pagination">{{ $orders->links() }}</div>
        @endif
    </div>

</div>
@endsection