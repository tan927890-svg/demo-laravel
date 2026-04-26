@extends('layouts.admin')

@section('page-title', 'Quản lý xe')

@section('content')
<style>
/* ===== Reset & Base ===== */
*, *::before, *::after { box-sizing: border-box; }

.cars-wrap { padding: 20px 16px; }

/* ===== Page title ===== */
.cars-title {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #111827;
}

/* ===== Brand tabs ===== */
.brand-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    align-items: center;
    margin-bottom: 14px;
}
.brand-tab {
    padding: 8px 16px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    color: #374151;
    white-space: nowrap;
    transition: background .15s, color .15s;
}
.brand-tab:hover { background: #f3f4f6; }
.brand-tab.active {
    background: #1d4ed8;
    color: #fff;
    border-color: #1d4ed8;
}

/* ===== Toolbar (search + add) ===== */
.toolbar {
    display: flex;
    gap: 10px;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
    flex-wrap: wrap;
}
.search-form {
    display: flex;
    gap: 8px;
    flex: 1;
    min-width: 0;
    max-width: 420px;
}
.search-input {
    flex: 1;
    min-width: 0;
    padding: 9px 14px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 15px;
    outline: none;
    background: #fff;
}
.search-input:focus { border-color: #1d4ed8; box-shadow: 0 0 0 3px #dbeafe; }
.btn-search {
    padding: 9px 16px;
    background: #1d4ed8;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 15px;
    cursor: pointer;
    white-space: nowrap;
}
.btn-clear {
    padding: 9px 13px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 15px;
    text-decoration: none;
    color: #374151;
    background: #fff;
    white-space: nowrap;
}
.btn-add {
    background: #1d4ed8;
    color: #fff;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 6px;
    font-size: 15px;
    font-weight: 600;
    white-space: nowrap;
    flex-shrink: 0;
}
.toolbar-actions {
    display: flex;
    gap: 8px;
    flex-shrink: 0;
    align-items: center;
}

/* ===== Alert ===== */
.alert-success {
    background: #dcfce7;
    color: #166534;
    padding: 13px 16px;
    border-radius: 6px;
    margin-bottom: 16px;
    font-size: 15px;
}

/* ===== Table (desktop) ===== */
.table-wrap {
    overflow-x: auto;
    background: #fff;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}
.cars-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 15px;
    min-width: 620px;
}
.cars-table thead tr {
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
}
.cars-table th {
    padding: 13px 16px;
    text-align: left;
    font-weight: 600;
    color: #374151;
    font-size: 14px;
}
.cars-table td {
    padding: 13px 16px;
    border-bottom: 1px solid #f3f4f6;
    color: #374151;
    vertical-align: middle;
}
.car-name { font-weight: 600; color: #111827; font-size: 15px; }
.car-model { font-size: 13px; color: #9ca3af; margin-top: 2px; }

/* ===== Car thumbnail ===== */
.car-thumb {
    width: 76px;
    height: 50px;
    object-fit: contain;
    background: #f3f4f6;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
    display: block;
}
.car-thumb-placeholder {
    width: 76px;
    height: 50px;
    background: #f3f4f6;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #d1d5db;
}

/* ===== Status badge ===== */
.status-badge {
    padding: 4px 11px;
    border-radius: 99px;
    font-size: 13px;
    font-weight: 600;
    display: inline-block;
    white-space: nowrap;
}

/* ===== Action buttons ===== */
.action-group { display: flex; gap: 8px; justify-content: center; flex-wrap: wrap; }
.btn-view  { background: #6b7280; color: #fff; padding: 7px 15px; border-radius: 5px; text-decoration: none; font-size: 14px; font-weight: 600; }
.btn-edit  { background: #f59e0b; color: #fff; padding: 7px 15px; border-radius: 5px; text-decoration: none; font-size: 14px; font-weight: 600; }
.btn-delete {
    background: #ef4444; color: #fff; padding: 7px 15px;
    border-radius: 5px; border: none; font-size: 14px; font-weight: 600; cursor: pointer;
}

/* ===== Pagination ===== */
.pagination {
    margin-top: 22px;
    display: flex;
    justify-content: center;
    gap: 5px;
    flex-wrap: wrap;
}
.page-link, .page-active, .page-disabled {
    padding: 8px 14px;
    border-radius: 5px;
    font-size: 14px;
    border: 1px solid #e5e7eb;
    text-decoration: none;
    color: #374151;
    background: #fff;
}
.page-active { background: #1d4ed8; color: #fff; border-color: #1d4ed8; }
.page-disabled { color: #9ca3af; }

/* ===== Mobile card view ===== */
@media (max-width: 640px) {
    .cars-wrap { padding: 14px 12px; }
    .cars-title { font-size: 20px; }
    .brand-tab { font-size: 13px; padding: 7px 13px; }
    .search-input, .btn-search, .btn-clear { font-size: 15px; }
    .toolbar { gap: 8px; }
    .search-form { max-width: 100%; width: 100%; }
    .toolbar-actions { width: 100%; flex-direction: column; }
    .btn-add { width: 100%; text-align: center; }

    .table-wrap { display: none; }
    .card-list { display: flex; flex-direction: column; gap: 12px; }

    .car-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 14px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }
    .car-card-img { flex-shrink: 0; }
    .car-card-img img, .car-card-img .car-thumb-placeholder {
        width: 80px;
        height: 54px;
        border-radius: 6px;
        object-fit: contain;
        border: 1px solid #e5e7eb;
        background: #f3f4f6;
    }
    .car-card-img .car-thumb-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #d1d5db;
    }
    .car-card-body { flex: 1; min-width: 0; }
    .car-card-name { font-size: 16px; font-weight: 700; color: #111827; }
    .car-card-model { font-size: 13px; color: #9ca3af; margin-top: 1px; }
    .car-card-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 7px;
        flex-wrap: wrap;
    }
    .car-card-brand { font-size: 13px; color: #6b7280; }
    .car-card-price { font-size: 14px; font-weight: 600; color: #374151; }
    .car-card-actions { display: flex; gap: 8px; margin-top: 10px; flex-wrap: wrap; }
    .car-card-actions .btn-view,
    .car-card-actions .btn-edit,
    .car-card-actions .btn-delete { font-size: 14px; padding: 8px 16px; }
}

@media (min-width: 641px) {
    .card-list { display: none; }
}
</style>

<div class="cars-wrap">

    <h2 class="cars-title">Danh sách xe</h2>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    {{-- Brand tabs --}}
    <div class="brand-tabs">
        @foreach($brands as $brand)
            <a href="{{ route('admin.cars.index', ['brand' => $brand->id, 'search' => request('search')]) }}"
               class="brand-tab {{ request('brand') == $brand->id ? 'active' : '' }}">
                {{ $brand->name }}
            </a>
        @endforeach
        <a href="{{ route('admin.featured-cars.index') }}"
           onclick="history.replaceState(null,'','{{ route('admin.cars.index') }}');"
           class="brand-tab">
            ⭐ Xe nổi bật
        </a>
    </div>

    {{-- Toolbar --}}
    <div class="toolbar">
        <form method="GET" action="{{ route('admin.cars.index') }}" class="search-form">
            @if(request('brand'))
                <input type="hidden" name="brand" value="{{ request('brand') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Tìm tên xe, model..."
                   class="search-input">
            <button type="submit" class="btn-search">Tìm</button>
            @if(request('search'))
                <a href="{{ route('admin.cars.index', ['brand' => request('brand')]) }}" class="btn-clear">✕</a>
            @endif
        </form>

        {{-- ── Nút hành động bên phải ── --}}
        <div class="toolbar-actions">
            @if(!Auth::user()->isStaff())
            <a href="{{ route('admin.price-list.index', ['brand' => request('brand')]) }}"
               class="btn-add" style="background:#0f766e;">
                📋 Bảng giá
            </a>
            @endif
            <a href="{{ route('admin.cars.create') }}" class="btn-add">+ Thêm xe mới</a>
        </div>
    </div>

    {{-- ===== DESKTOP TABLE ===== --}}
    <div class="table-wrap">
        <table class="cars-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ảnh</th>
                    <th>Tên xe</th>
                    <th>Hãng</th>
                    <th>Giá (VNĐ)</th>
                    <th>Trạng thái</th>
                    <th style="text-align:center;">Thao tác</th>
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
                        'available'    => ['bg' => '#dcfce7', 'color' => '#166534', 'label' => 'Còn hàng'],
                        'reserved'     => ['bg' => '#fef9c3', 'color' => '#854d0e', 'label' => 'Đã đặt'],
                        'rented'       => ['bg' => '#fee2e2', 'color' => '#991b1b', 'label' => 'Đang thuê'],
                        'maintenance'  => ['bg' => '#fef3c7', 'color' => '#92400e', 'label' => 'Bảo dưỡng'],
                        'out_of_stock' => ['bg' => '#fee2e2', 'color' => '#991b1b', 'label' => 'Hết hàng'],
                        'coming_soon'  => ['bg' => '#ede9fe', 'color' => '#5b21b6', 'label' => 'Sắp ra mắt'],
                    ];
                    $ast = $adminStatusMap[$car->status] ?? ['bg' => '#f3f4f6', 'color' => '#6b7280', 'label' => $car->status ?? '—'];
                @endphp
                <tr>
                    <td style="color:#6b7280;">{{ $car->id }}</td>
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
                    <td>{{ $car->brand->name ?? '—' }}</td>
                    <td>{{ number_format($car->price_per_day) }}</td>
                    <td>
                        <span class="status-badge" style="background:{{ $ast['bg'] }}; color:{{ $ast['color'] }};">
                            {{ $ast['label'] }}
                        </span>
                    </td>
                    <td>
                        <div class="action-group">
                            @if(Auth::user()->isStaff())
                                <a href="{{ route('admin.cars.show', $car) }}" class="btn-view">Xem</a>
                            @else
                                <a href="{{ route('admin.cars.edit', $car) }}" class="btn-edit">Sửa</a>
                                @if(Auth::user()->isAdmin())
                                <form action="{{ route('admin.cars.destroy', $car) }}" method="POST"
                                      onsubmit="return confirm('Bạn chắc chắn muốn xóa xe này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Xóa</button>
                                </form>
                                @endif
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding:40px; text-align:center; color:#9ca3af; font-size:15px;">Chưa có xe nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
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
                'available'    => ['bg' => '#dcfce7', 'color' => '#166534', 'label' => 'Còn hàng'],
                'reserved'     => ['bg' => '#fef9c3', 'color' => '#854d0e', 'label' => 'Đã đặt'],
                'rented'       => ['bg' => '#fee2e2', 'color' => '#991b1b', 'label' => 'Đang thuê'],
                'maintenance'  => ['bg' => '#fef3c7', 'color' => '#92400e', 'label' => 'Bảo dưỡng'],
                'out_of_stock' => ['bg' => '#fee2e2', 'color' => '#991b1b', 'label' => 'Hết hàng'],
                'coming_soon'  => ['bg' => '#ede9fe', 'color' => '#5b21b6', 'label' => 'Sắp ra mắt'],
            ];
            $ast = $adminStatusMap[$car->status] ?? ['bg' => '#f3f4f6', 'color' => '#6b7280', 'label' => $car->status ?? '—'];
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
                    <span class="car-card-brand">{{ $car->brand->name ?? '—' }}</span>
                    <span style="color:#d1d5db;">•</span>
                    <span class="car-card-price">{{ number_format($car->price_per_day) }} ₫/ngày</span>
                    <span class="status-badge" style="background:{{ $ast['bg'] }}; color:{{ $ast['color'] }};">
                        {{ $ast['label'] }}
                    </span>
                </div>
                <div class="car-card-actions">
                    @if(Auth::user()->isStaff())
                        <a href="{{ route('admin.cars.show', $car) }}" class="btn-view">Xem</a>
                    @else
                        <a href="{{ route('admin.cars.edit', $car) }}" class="btn-edit">Sửa</a>
                        @if(Auth::user()->isAdmin())
                        <form action="{{ route('admin.cars.destroy', $car) }}" method="POST"
                              onsubmit="return confirm('Bạn chắc chắn muốn xóa xe này?')"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Xóa</button>
                        </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        @empty
            <div style="text-align:center; padding:40px; color:#9ca3af; font-size:15px;">Chưa có xe nào.</div>
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
@endsection