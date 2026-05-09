@extends('layouts.admin')

@section('page-title', 'Quản lý xe')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

*, *::before, *::after { box-sizing: border-box; }

.cars-wrap {
    padding: 28px 24px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #f5f6fa;
    min-height: 100vh;
}

/* ===== Header ===== */
.page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
}
.page-header-left {}
.cars-title {
    font-size: 22px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 4px;
    letter-spacing: -0.3px;
}
.cars-subtitle {
    font-size: 13px;
    color: #9ca3af;
    margin: 0;
}
.header-actions {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}

/* ===== Alert ===== */
.alert-success {
    background: #f0fdf4;
    color: #15803d;
    padding: 12px 16px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-size: 14px;
    border: 1px solid #bbf7d0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.alert-success::before {
    content: '✓';
    width: 20px;
    height: 20px;
    background: #15803d;
    color: #fff;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    flex-shrink: 0;
}

/* ===== Brand tabs ===== */
.brand-tabs-wrap {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    align-items: center;
    margin-bottom: 16px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 8px 12px;
}
.brand-tabs-label {
    font-size: 12px;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: .6px;
    margin-right: 4px;
}
.brand-tab {
    padding: 6px 14px;
    border: 1px solid transparent;
    border-radius: 8px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    color: #6b7280;
    white-space: nowrap;
    transition: all .15s;
}
.brand-tab:hover {
    background: #f3f4f6;
    color: #374151;
}
.brand-tab.active {
    background: #eff6ff;
    color: #1d4ed8;
    border-color: #bfdbfe;
    font-weight: 600;
}

/* ===== Toolbar ===== */
.toolbar {
    display: flex;
    gap: 10px;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
    flex-wrap: wrap;
}
.search-form {
    display: flex;
    gap: 8px;
    flex: 1;
    min-width: 0;
    max-width: 400px;
}
.search-input-wrap {
    position: relative;
    flex: 1;
    min-width: 0;
}
.search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 15px;
    pointer-events: none;
}
.search-input {
    width: 100%;
    padding: 9px 14px 9px 36px;
    border: 1px solid #e5e7eb;
    border-radius: 9px;
    font-size: 14px;
    font-family: inherit;
    outline: none;
    background: #fff;
    color: #111827;
    transition: border .15s, box-shadow .15s;
}
.search-input::placeholder { color: #c0c5cc; }
.search-input:focus {
    border-color: #93c5fd;
    box-shadow: 0 0 0 3px #dbeafe80;
}
.btn-search {
    padding: 9px 18px;
    background: #1d4ed8;
    color: #fff;
    border: none;
    border-radius: 9px;
    font-size: 14px;
    font-family: inherit;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: background .15s;
}
.btn-search:hover { background: #1e40af; }
.btn-clear {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border: 1px solid #e5e7eb;
    border-radius: 9px;
    font-size: 14px;
    text-decoration: none;
    color: #6b7280;
    background: #fff;
    transition: all .15s;
    flex-shrink: 0;
}
.btn-clear:hover { background: #f3f4f6; color: #ef4444; border-color: #fca5a5; }

/* ===== Buttons ===== */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 18px;
    border-radius: 9px;
    font-size: 14px;
    font-family: inherit;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
    cursor: pointer;
    border: none;
    transition: all .15s;
}
.btn-primary { background: #1d4ed8; color: #fff; }
.btn-primary:hover { background: #1e40af; }
.btn-teal { background: #0f766e; color: #fff; }
.btn-teal:hover { background: #0d6460; }

/* ===== Card container ===== */
.content-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

/* ===== Table info bar ===== */
.table-info-bar {
    padding: 14px 20px;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
}
.table-count {
    font-size: 13px;
    color: #6b7280;
}
.table-count strong {
    color: #111827;
    font-weight: 600;
}

/* ===== Table ===== */
.table-wrap { overflow-x: auto; }
.cars-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
    min-width: 640px;
}
.cars-table thead tr {
    background: #f9fafb;
    border-bottom: 1px solid #f0f0f0;
}
.cars-table th {
    padding: 12px 18px;
    text-align: left;
    font-weight: 600;
    color: #6b7280;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: .5px;
    white-space: nowrap;
}
.cars-table tbody tr {
    border-bottom: 1px solid #f9fafb;
    transition: background .1s;
}
.cars-table tbody tr:last-child { border-bottom: none; }
.cars-table tbody tr:hover { background: #fafbff; }
.cars-table td {
    padding: 14px 18px;
    color: #374151;
    vertical-align: middle;
}

/* Row ID */
.row-id {
    font-size: 12px;
    color: #c0c5cc;
    font-weight: 600;
    font-variant-numeric: tabular-nums;
}

/* Car thumbnail */
.car-thumb {
    width: 72px;
    height: 48px;
    object-fit: contain;
    background: #f8f9fb;
    border-radius: 8px;
    border: 1px solid #eef0f3;
    display: block;
}
.car-thumb-placeholder {
    width: 72px;
    height: 48px;
    background: #f8f9fb;
    border-radius: 8px;
    border: 1px solid #eef0f3;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #d1d5db;
}

/* Car info */
.car-name {
    font-weight: 600;
    color: #111827;
    font-size: 14px;
    margin-bottom: 2px;
}
.car-model {
    font-size: 12px;
    color: #b0b6c2;
}

/* Brand chip */
.brand-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #f3f4f6;
    color: #374151;
    font-size: 12px;
    font-weight: 500;
    padding: 4px 10px;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
}

/* Price */
.price-cell {
    font-size: 14px;
    font-weight: 600;
    color: #111827;
    font-variant-numeric: tabular-nums;
}
.price-unit {
    font-size: 11px;
    color: #9ca3af;
    font-weight: 400;
    margin-left: 2px;
}

/* Status badge */
.status-badge {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
    white-space: nowrap;
    border: 1px solid transparent;
}

/* Action buttons */
.action-group {
    display: flex;
    gap: 6px;
    justify-content: flex-end;
    flex-wrap: wrap;
}
.btn-view {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #f3f4f6;
    color: #374151;
    padding: 6px 13px;
    border-radius: 7px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    border: 1px solid #e5e7eb;
    transition: all .15s;
}
.btn-view:hover { background: #e5e7eb; }
.btn-edit {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #fffbeb;
    color: #b45309;
    padding: 6px 13px;
    border-radius: 7px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    border: 1px solid #fde68a;
    transition: all .15s;
}
.btn-edit:hover { background: #fef3c7; border-color: #fbbf24; }
.btn-delete {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #fef2f2;
    color: #dc2626;
    padding: 6px 13px;
    border-radius: 7px;
    border: 1px solid #fecaca;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all .15s;
}
.btn-delete:hover { background: #fee2e2; border-color: #fca5a5; }

/* Empty state */
.empty-state {
    padding: 60px 20px;
    text-align: center;
}
.empty-state-icon {
    font-size: 40px;
    margin-bottom: 12px;
}
.empty-state-text {
    font-size: 15px;
    color: #9ca3af;
}

/* ===== Pagination ===== */
.pagination {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 4px;
    flex-wrap: wrap;
}
.page-link, .page-active, .page-disabled {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 10px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    border: 1px solid #e5e7eb;
    text-decoration: none;
    color: #374151;
    background: #fff;
    transition: all .15s;
}
.page-link:hover { background: #f3f4f6; border-color: #d1d5db; }
.page-active {
    background: #1d4ed8;
    color: #fff;
    border-color: #1d4ed8;
    font-weight: 700;
}
.page-disabled { color: #d1d5db; pointer-events: none; }

/* ===== Mobile card view ===== */
@media (max-width: 640px) {
    .cars-wrap { padding: 16px 14px; }
    .cars-title { font-size: 18px; }
    .search-form { max-width: 100%; width: 100%; }
    .toolbar { gap: 8px; }
    .toolbar-actions-wrap { width: 100%; }
    .header-actions { width: 100%; }
    .btn { width: 100%; justify-content: center; }

    .table-wrap { display: none; }
    .card-list { display: flex; flex-direction: column; gap: 10px; }

    .car-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 14px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
        transition: box-shadow .15s;
    }
    .car-card:hover { box-shadow: 0 2px 12px rgba(0,0,0,.07); }
    .car-card-img { flex-shrink: 0; }
    .car-card-img img {
        width: 80px;
        height: 54px;
        border-radius: 8px;
        object-fit: contain;
        border: 1px solid #eef0f3;
        background: #f8f9fb;
        display: block;
    }
    .car-card-img .car-thumb-placeholder {
        width: 80px;
        height: 54px;
        border-radius: 8px;
    }
    .car-card-body { flex: 1; min-width: 0; }
    .car-card-name { font-size: 15px; font-weight: 700; color: #111827; }
    .car-card-model { font-size: 12px; color: #9ca3af; margin-top: 1px; }
    .car-card-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 8px;
        flex-wrap: wrap;
    }
    .car-card-price { font-size: 13px; font-weight: 700; color: #111827; }
    .car-card-actions { display: flex; gap: 6px; margin-top: 10px; flex-wrap: wrap; }
}

@media (min-width: 641px) {
    .card-list { display: none; }
}
</style>

<div class="cars-wrap">

    {{-- Header --}}
    <div class="page-header">
        <div class="page-header-left">
            <h2 class="cars-title">Danh sách xe</h2>
            <p class="cars-subtitle">Quản lý toàn bộ phương tiện trong hệ thống</p>
        </div>
        <div class="header-actions">
            @if(!Auth::user()->isStaff())
            <a href="{{ route('admin.price-list.index', ['brand' => request('brand')]) }}" class="btn btn-teal">
                📋 Bảng giá
            </a>
            @endif
            <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">
                + Thêm xe mới
            </a>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    {{-- Brand tabs --}}
    <div class="brand-tabs-wrap">
        <span class="brand-tabs-label">Hãng</span>
        @foreach($brands as $brand)
            <a href="{{ route('admin.cars.index', ['brand' => $brand->id, 'search' => request('search')]) }}"
               class="brand-tab {{ request('brand') == $brand->id ? 'active' : '' }}">
                {{ $brand->name }}
            </a>
        @endforeach
    </div>

    {{-- Toolbar --}}
    <div class="toolbar">
        <form method="GET" action="{{ route('admin.cars.index') }}" class="search-form">
            @if(request('brand'))
                <input type="hidden" name="brand" value="{{ request('brand') }}">
            @endif
            <div class="search-input-wrap">
                <span class="search-icon">🔍</span>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Tìm tên xe, model..."
                       class="search-input">
            </div>
            <button type="submit" class="btn-search">Tìm kiếm</button>
            @if(request('search'))
                <a href="{{ route('admin.cars.index', ['brand' => request('brand')]) }}" class="btn-clear" title="Xoá tìm kiếm">✕</a>
            @endif
        </form>
    </div>

    {{-- ===== DESKTOP TABLE ===== --}}
    <div class="content-card">
        <div class="table-info-bar">
            <span class="table-count">
                Tìm thấy <strong>{{ $cars->total() }}</strong> xe
                @if(request('search'))
                    cho "<strong>{{ request('search') }}</strong>"
                @endif
            </span>
        </div>

        <div class="table-wrap">
            <table class="cars-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ảnh</th>
                        <th>Tên xe</th>
                        <th>Hãng</th>
                        <th>Giá</th>
                        <th>Trạng thái</th>
                        <th style="text-align:right;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cars as $car)
                    @php
                        $thumb = null;
                        if (!empty($car->image_url)) {
                            $raw   = $car->image_url;
                            $thumb = preg_match('#^https?://#i', $raw) ? $raw : asset(ltrim($raw, '/'));
                        }
                        $adminStatusMap = [
                            'available'    => ['bg' => '#f0fdf4', 'color' => '#15803d', 'border' => '#bbf7d0', 'label' => 'Còn hàng'],
                            'reserved'     => ['bg' => '#fffbeb', 'color' => '#b45309', 'border' => '#fde68a', 'label' => 'Đã đặt'],
                            'rented'       => ['bg' => '#fff1f2', 'color' => '#be123c', 'border' => '#fecdd3', 'label' => 'Đang thuê'],
                            'maintenance'  => ['bg' => '#fff7ed', 'color' => '#c2410c', 'border' => '#fed7aa', 'label' => 'Bảo dưỡng'],
                            'out_of_stock' => ['bg' => '#fef2f2', 'color' => '#dc2626', 'border' => '#fecaca', 'label' => 'Hết hàng'],
                            'coming_soon'  => ['bg' => '#f5f3ff', 'color' => '#6d28d9', 'border' => '#ddd6fe', 'label' => 'Sắp ra mắt'],
                        ];
                        $ast = $adminStatusMap[$car->status] ?? ['bg' => '#f3f4f6', 'color' => '#6b7280', 'border' => '#e5e7eb', 'label' => $car->status ?? '—'];
                    @endphp
                    <tr>
                        <td><span class="row-id">{{ $car->id }}</span></td>
                        <td>
                            @if($thumb)
                                <img src="{{ $thumb }}" alt="{{ $car->name }}" class="car-thumb">
                            @else
                                <div class="car-thumb-placeholder">🚗</div>
                            @endif
                        </td>
                        <td>
                            <div class="car-name">{{ $car->name }}</div>
                            <div class="car-model">{{ $car->model }}</div>
                        </td>
                        <td>
                            <span class="brand-chip">{{ $car->brand->name ?? '—' }}</span>
                        </td>
                        <td>
                            <span class="price-cell">{{ number_format($car->price_per_day) }}<span class="price-unit">₫</span></span>
                        </td>
                        <td>
                            <span class="status-badge"
                                  style="background:{{ $ast['bg'] }}; color:{{ $ast['color'] }}; border-color:{{ $ast['border'] }};">
                                {{ $ast['label'] }}
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                @if(Auth::user()->isStaff())
                                    <a href="{{ route('admin.cars.show', $car) }}" class="btn-view">👁 Xem</a>
                                @else
                                    <a href="{{ route('admin.cars.edit', $car) }}" class="btn-edit">✏ Sửa</a>
                                   @if(Auth::user()->isAdmin())
<form action="{{ route('admin.cars.destroy', $car) }}" method="POST"
      id="delete-form-{{ $car->id }}"
      style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="button" class="btn-delete"
            onclick="openDeleteModal('delete-form-{{ $car->id }}', '{{ addslashes($car->name) }}')">
        🗑 Xóa
    </button>
</form>
@endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon">🚗</div>
                                <div class="empty-state-text">Chưa có xe nào trong danh sách.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== MOBILE CARD LIST ===== --}}
    <div class="card-list">
        @forelse($cars as $car)
        @php
            $thumb = null;
            if (!empty($car->image_url)) {
                $raw   = $car->image_url;
                $thumb = preg_match('#^https?://#i', $raw) ? $raw : asset(ltrim($raw, '/'));
            }
            $adminStatusMap = [
                'available'    => ['bg' => '#f0fdf4', 'color' => '#15803d', 'border' => '#bbf7d0', 'label' => 'Còn hàng'],
                'reserved'     => ['bg' => '#fffbeb', 'color' => '#b45309', 'border' => '#fde68a', 'label' => 'Đã đặt'],
                'rented'       => ['bg' => '#fff1f2', 'color' => '#be123c', 'border' => '#fecdd3', 'label' => 'Đang thuê'],
                'maintenance'  => ['bg' => '#fff7ed', 'color' => '#c2410c', 'border' => '#fed7aa', 'label' => 'Bảo dưỡng'],
                'out_of_stock' => ['bg' => '#fef2f2', 'color' => '#dc2626', 'border' => '#fecaca', 'label' => 'Hết hàng'],
                'coming_soon'  => ['bg' => '#f5f3ff', 'color' => '#6d28d9', 'border' => '#ddd6fe', 'label' => 'Sắp ra mắt'],
            ];
            $ast = $adminStatusMap[$car->status] ?? ['bg' => '#f3f4f6', 'color' => '#6b7280', 'border' => '#e5e7eb', 'label' => $car->status ?? '—'];
        @endphp
        <div class="car-card">
            <div class="car-card-img">
                @if($thumb)
                    <img src="{{ $thumb }}" alt="{{ $car->name }}">
                @else
                    <div class="car-thumb-placeholder">🚗</div>
                @endif
            </div>
            <div class="car-card-body">
                <div class="car-card-name">{{ $car->name }}</div>
                <div class="car-card-model">{{ $car->model }}</div>
                <div class="car-card-meta">
                    <span class="brand-chip" style="font-size:11px;">{{ $car->brand->name ?? '—' }}</span>
                    <span class="car-card-price">{{ number_format($car->price_per_day) }} ₫/ngày</span>
                    <span class="status-badge"
                          style="background:{{ $ast['bg'] }}; color:{{ $ast['color'] }}; border-color:{{ $ast['border'] }}; font-size:11px;">
                        {{ $ast['label'] }}
                    </span>
                </div>
                <div class="car-card-actions">
                   @if(Auth::user()->isStaff())
    <a href="{{ route('admin.cars.show', $car) }}" class="btn-view">👁 Xem</a>
@else
    <a href="{{ route('admin.cars.edit', $car) }}" class="btn-edit">✏ Sửa</a>
    @if(Auth::user()->isAdmin())
    <form action="{{ route('admin.cars.destroy', $car) }}" method="POST"
          id="delete-form-{{ $car->id }}"
          style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="button" class="btn-delete"
                onclick="openDeleteModal('delete-form-{{ $car->id }}', '{{ addslashes($car->name) }}')">
            🗑 Xóa
        </button>
    </form>
    @endif
@endif  {{-- ← thêm dòng này --}}
                </div>
            </div>
        </div>
        @empty
            <div class="empty-state">
                <div class="empty-state-icon">🚗</div>
                <div class="empty-state-text">Chưa có xe nào.</div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($cars->hasPages())
    <div class="pagination">
        @if($cars->onFirstPage())
            <span class="page-disabled">← Trước</span>
        @else
            <a href="{{ $cars->previousPageUrl() }}" class="page-link">← Trước</a>
        @endif

        @foreach($cars->getUrlRange(1, $cars->lastPage()) as $page => $url)
            @if($page == $cars->currentPage())
                <span class="page-active">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
            @endif
        @endforeach

        @if($cars->hasMorePages())
            <a href="{{ $cars->nextPageUrl() }}" class="page-link">Tiếp →</a>
        @else
            <span class="page-disabled">Tiếp →</span>
        @endif
    </div>
    @endif

</div>

{{-- ===== CUSTOM DELETE MODAL ===== --}}
<div id="delete-modal-overlay" style="
    display:none; position:fixed; inset:0; z-index:9999;
    background:rgba(0,0,0,0.45); backdrop-filter:blur(2px);
    align-items:center; justify-content:center;
" onclick="closeDeleteModal()">
    <div style="
        background:#fff; border-radius:16px; padding:28px 28px 24px;
        width:380px; max-width:calc(100vw - 32px);
        box-shadow:0 20px 60px rgba(0,0,0,0.18);
        animation:modalIn .2s ease;
    " onclick="event.stopPropagation()">

        <div style="
            width:52px; height:52px; border-radius:50%;
            background:#fef2f2; border:1px solid #fecaca;
            display:flex; align-items:center; justify-content:center;
            font-size:22px; margin-bottom:18px;
        ">🗑</div>

        <h3 style="margin:0 0 8px; font-size:17px; font-weight:700; color:#111827; font-family:'Plus Jakarta Sans',sans-serif;">
            Xác nhận xóa xe
        </h3>

        <p style="margin:0 0 24px; font-size:14px; color:#6b7280; line-height:1.6; font-family:'Plus Jakarta Sans',sans-serif;">
            Bạn có chắc muốn xóa xe
            <strong id="modal-car-name" style="color:#111827;"></strong>?
            <br>Hành động này <strong style="color:#dc2626;">không thể hoàn tác</strong>.
        </p>

        <div style="display:flex; gap:10px; justify-content:flex-end;">
            <button onclick="closeDeleteModal()" style="
                padding:9px 20px; border-radius:9px; border:1px solid #e5e7eb;
                background:#fff; color:#374151; font-size:14px; font-weight:600;
                font-family:'Plus Jakarta Sans',sans-serif; cursor:pointer;
                transition:background .15s;
            " onmouseover="this.style.background='#f3f4f6'"
               onmouseout="this.style.background='#fff'">
                Hủy bỏ
            </button>
            <button onclick="submitDeleteForm()" style="
                padding:9px 20px; border-radius:9px; border:none;
                background:#dc2626; color:#fff; font-size:14px; font-weight:600;
                font-family:'Plus Jakarta Sans',sans-serif; cursor:pointer;
                transition:background .15s;
            " onmouseover="this.style.background='#b91c1c'"
               onmouseout="this.style.background='#dc2626'">
                🗑 Xóa xe này
            </button>
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
let _deleteFormId = null;

function openDeleteModal(formId, carName) {
    _deleteFormId = formId;
    document.getElementById('modal-car-name').textContent = carName;
    const overlay = document.getElementById('delete-modal-overlay');
    overlay.style.display = 'flex';
}

function closeDeleteModal() {
    document.getElementById('delete-modal-overlay').style.display = 'none';
    _deleteFormId = null;
}

function submitDeleteForm() {
    if (_deleteFormId) {
        document.getElementById(_deleteFormId).submit();
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDeleteModal();
});
</script>
@endsection