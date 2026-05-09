@extends('layouts.admin')

@section('page-title', 'Chi tiết xe: ' . $car->name)

@section('topbar-actions')
  <a href="{{ route('admin.cars.index') }}" class="btn btn-sm">← Quay lại</a>
  @if(Auth::user()->canManageStaff())
    <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-sm btn-primary">Chỉnh sửa</a>
  @endif
@endsection

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

*, *::before, *::after { box-sizing: border-box; }

.show-wrap {
    padding: 28px 24px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #f5f6fa;
    min-height: 100vh;
}

/* ===== Page Header ===== */
.show-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}
.show-header-left {
    display: flex;
    align-items: center;
    gap: 14px;
}
.show-car-avatar {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    background: #fff;
    border: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    flex-shrink: 0;
    overflow: hidden;
}
.show-car-avatar img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.show-title {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 4px;
    letter-spacing: -.3px;
}
.show-subtitle {
    font-size: 13px;
    color: #9ca3af;
    margin: 0;
}
.show-header-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
}
.sh-btn {
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
    border: 1px solid #e5e7eb;
    transition: all .15s;
}
.sh-btn-back {
    background: #fff;
    color: #374151;
}
.sh-btn-back:hover { background: #f3f4f6; }
.sh-btn-edit {
    background: #1d4ed8;
    color: #fff;
    border-color: #1d4ed8;
}
.sh-btn-edit:hover { background: #1e40af; }

/* ===== Grid layout ===== */
.show-grid {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 18px;
    align-items: start;
}
@media (max-width: 900px) {
    .show-grid { grid-template-columns: 1fr; }
}

/* ===== Section card ===== */
.section-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
    margin-bottom: 0;
}
.section-card + .section-card { margin-top: 16px; }

.section-header {
    padding: 14px 20px;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
    align-items: center;
    gap: 8px;
}
.section-icon {
    width: 28px;
    height: 28px;
    border-radius: 7px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}
.section-title {
    font-size: 13px;
    font-weight: 700;
    color: #374151;
    letter-spacing: .2px;
    text-transform: uppercase;
}
.section-body {
    padding: 18px 20px;
}

/* ===== Field grid ===== */
.field-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 14px;
}
.field-row:last-child { margin-bottom: 0; }
.field-single { margin-bottom: 14px; }
.field-single:last-child { margin-bottom: 0; }

.field-label {
    font-size: 11px;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: 5px;
}
.field-value {
    font-size: 14px;
    color: #111827;
    font-weight: 500;
    background: #f8f9fb;
    border: 1px solid #eef0f3;
    border-radius: 8px;
    padding: 9px 12px;
    min-height: 38px;
    line-height: 1.5;
}
.field-value.multiline {
    min-height: 72px;
    white-space: pre-wrap;
    font-weight: 400;
}
.field-value.large-multiline {
    min-height: 140px;
    white-space: pre-wrap;
    font-weight: 400;
    font-size: 13px;
}
.field-value.empty {
    color: #c0c5cc;
    font-weight: 400;
    font-style: italic;
}
.field-hint {
    font-size: 11px;
    color: #9ca3af;
    margin-top: 5px;
    word-break: break-all;
}

/* ===== Badges ===== */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    border: 1px solid transparent;
}
.badge-green  { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
.badge-red    { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
.badge-amber  { background: #fffbeb; color: #b45309; border-color: #fde68a; }
.badge-purple { background: #f5f3ff; color: #6d28d9; border-color: #ddd6fe; }
.badge-gray   { background: #f3f4f6; color: #6b7280; border-color: #e5e7eb; }
.badge-blue   { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }

/* ===== Car image ===== */
.car-image-box {
    width: 100%;
    height: 170px;
    border-radius: 10px;
    border: 1px solid #eef0f3;
    background: #f8f9fb;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.car-image-box img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.car-image-empty {
    font-size: 13px;
    color: #c0c5cc;
    text-align: center;
    padding: 40px 0;
}
.car-image-empty-icon { font-size: 32px; margin-bottom: 8px; }

/* ===== Spec grid ===== */
.spec-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
.spec-item {
    background: #f8f9fb;
    border: 1px solid #eef0f3;
    border-radius: 10px;
    padding: 12px 14px;
}
.spec-item-label {
    font-size: 11px;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: 4px;
}
.spec-item-value {
    font-size: 15px;
    font-weight: 700;
    color: #111827;
}
.spec-item-value.empty {
    color: #c0c5cc;
    font-weight: 400;
    font-size: 13px;
    font-style: italic;
}

/* ===== Divider ===== */
.section-divider {
    height: 1px;
    background: #f3f4f6;
    margin: 14px 0;
}

/* ===== Status row ===== */
.status-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #f3f4f6;
}
.status-row:last-child { border-bottom: none; padding-bottom: 0; }
.status-row:first-child { padding-top: 0; }
.status-row-label {
    font-size: 13px;
    color: #6b7280;
    font-weight: 500;
}
</style>

<div class="show-wrap">

    {{-- ===== PAGE HEADER ===== --}}
    <div class="show-header">
        <div class="show-header-left">
            <div class="show-car-avatar">
                @if($car->image_url)
                    <img src="{{ asset($car->image_url) }}" onerror="this.parentElement.innerHTML='🚗'">
                @else
                    🚗
                @endif
            </div>
            <div>
                <h2 class="show-title">{{ $car->name }}</h2>
                <p class="show-subtitle">{{ $car->brand->name ?? '' }}{{ $car->model ? ' · ' . $car->model : '' }} · ID #{{ $car->id }}</p>
            </div>
        </div>
        <div class="show-header-actions">
            <a href="{{ route('admin.cars.index') }}" class="sh-btn sh-btn-back">← Quay lại</a>
            @if(Auth::user()->canManageStaff())
                <a href="{{ route('admin.cars.edit', $car) }}" class="sh-btn sh-btn-edit">✏ Chỉnh sửa</a>
            @endif
        </div>
    </div>

    {{-- ===== MAIN GRID ===== --}}
    <div class="show-grid">

        {{-- ══ LEFT COLUMN ══ --}}
        <div>

            {{-- THÔNG TIN CƠ BẢN --}}
            <div class="section-card">
                <div class="section-header">
                    <div class="section-icon" style="background:#eff6ff;">📋</div>
                    <span class="section-title">Thông tin cơ bản</span>
                </div>
                <div class="section-body">
                    <div class="field-row">
                        <div>
                            <div class="field-label">Tên xe</div>
                            <div class="field-value">{{ $car->name ?: '' }}<span class="{{ $car->name ? '' : 'empty' }}">{{ $car->name ?: 'Chưa có' }}</span></div>
                        </div>
                        <div>
                            <div class="field-label">Thương hiệu</div>
                            <div class="field-value {{ !($car->brand->name ?? null) ? 'empty' : '' }}">{{ $car->brand->name ?? 'Chưa có' }}</div>
                        </div>
                    </div>

                    <div class="field-row">
                        <div>
                            <div class="field-label">Giá bán (VNĐ)</div>
                            <div class="field-value" style="color:#1d4ed8;font-weight:700;">
                                {{ number_format($car->price_per_day, 0, ',', '.') }}đ
                            </div>
                        </div>
                        <div>
                            <div class="field-label">Năm sản xuất</div>
                            <div class="field-value {{ !$car->year ? 'empty' : '' }}">{{ $car->year ?? 'Chưa có' }}</div>
                        </div>
                    </div>

                    <div class="field-row">
                        <div>
                            <div class="field-label">Số chỗ ngồi</div>
                            <div class="field-value {{ !$car->seats ? 'empty' : '' }}">{{ $car->seats ? $car->seats . ' chỗ' : 'Chưa có' }}</div>
                        </div>
                        <div>
                            <div class="field-label">Loại nhiên liệu</div>
                            <div class="field-value {{ !$car->fuel_type ? 'empty' : '' }}">{{ $car->fuel_type ?? 'Chưa có' }}</div>
                        </div>
                    </div>

                    <div class="field-single">
                        <div class="field-label">Mô tả ngắn</div>
                        <div class="field-value multiline {{ !$car->description ? 'empty' : '' }}">{{ $car->description ?? 'Chưa có mô tả.' }}</div>
                    </div>

                    <div class="field-single">
                        <div class="field-label">Nội dung chi tiết</div>
                        <div class="field-value large-multiline {{ !$car->content ? 'empty' : '' }}">{{ $car->content ?? 'Chưa có nội dung.' }}</div>
                    </div>
                </div>
            </div>

            {{-- THÔNG SỐ KỸ THUẬT --}}
            <div class="section-card" style="margin-top:16px;">
                <div class="section-header">
                    <div class="section-icon" style="background:#fff7ed;">⚙️</div>
                    <span class="section-title">Thông số kỹ thuật</span>
                </div>
                <div class="section-body">
                    <div class="spec-grid">
                        <div class="spec-item">
                            <div class="spec-item-label">Động cơ</div>
                            <div class="spec-item-value {{ !$car->engine ? 'empty' : '' }}">{{ $car->engine ?? 'Chưa có' }}</div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-item-label">Hộp số</div>
                            <div class="spec-item-value {{ !$car->transmission ? 'empty' : '' }}">{{ $car->transmission ?? 'Chưa có' }}</div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-item-label">Công suất</div>
                            <div class="spec-item-value {{ !$car->horsepower ? 'empty' : '' }}">
                                @if($car->horsepower)
                                    {{ $car->horsepower }} <span style="font-size:12px;font-weight:500;color:#6b7280;">HP</span>
                                @else
                                    Chưa có
                                @endif
                            </div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-item-label">Tiêu thụ nhiên liệu</div>
                            <div class="spec-item-value {{ !$car->fuel_consumption ? 'empty' : '' }}">
                                @if($car->fuel_consumption)
                                    {{ $car->fuel_consumption }} <span style="font-size:12px;font-weight:500;color:#6b7280;">L/100km</span>
                                @else
                                    Chưa có
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ══ RIGHT COLUMN ══ --}}
        <div>

            {{-- ẢNH ĐẠI DIỆN --}}
            <div class="section-card">
                <div class="section-header">
                    <div class="section-icon" style="background:#f0fdf4;">🖼</div>
                    <span class="section-title">Ảnh đại diện</span>
                </div>
                <div class="section-body">
                    @if($car->image_url)
                        <div class="car-image-box">
                            <img src="{{ asset($car->image_url) }}" alt="{{ $car->name }}" onerror="this.style.opacity='.2'">
                        </div>
                        <div class="field-hint" style="margin-top:10px;">{{ $car->image_url }}</div>
                    @else
                        <div class="car-image-box">
                            <div class="car-image-empty">
                                <div class="car-image-empty-icon">📷</div>
                                Chưa có ảnh
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- TRẠNG THÁI --}}
            <div class="section-card" style="margin-top:16px;">
                <div class="section-header">
                    <div class="section-icon" style="background:#fef2f2;">📊</div>
                    <span class="section-title">Trạng thái</span>
                </div>
                <div class="section-body" style="padding-top:14px;padding-bottom:14px;">
                    <div class="status-row">
                        <span class="status-row-label">Tình trạng hàng</span>
                        @if($car->status === 'available')
                            <span class="badge badge-green">✓ Còn hàng</span>
                        @elseif($car->status === 'out_of_stock')
                            <span class="badge badge-red">Hết hàng</span>
                        @elseif($car->status === 'reserved')
                            <span class="badge badge-amber">Đã đặt</span>
                        @elseif($car->status === 'rented')
                            <span class="badge badge-red">Đang thuê</span>
                        @elseif($car->status === 'maintenance')
                            <span class="badge badge-amber">Bảo dưỡng</span>
                        @else
                            <span class="badge badge-blue">Sắp ra mắt</span>
                        @endif
                    </div>
                    <div class="status-row">
                        <span class="status-row-label">Xe nổi bật</span>
                        @if($car->is_featured)
                            <span class="badge badge-purple">⭐ Nổi bật</span>
                        @else
                            <span class="badge badge-gray">Không</span>
                        @endif
                    </div>

                    @if($car->is_featured && $car->badge_label)
                    <div class="status-row">
                        <span class="status-row-label">Nhãn badge</span>
                        <span class="badge badge-blue">{{ $car->badge_label }}</span>
                    </div>
                    @endif
                </div>

                @if($car->is_featured && $car->image_360_prefix)
                <div style="padding: 0 20px 16px;">
                    <div class="field-label">Prefix ảnh 360°</div>
                    <div class="field-value" style="font-size:13px;word-break:break-all;">{{ $car->image_360_prefix }}</div>
                </div>
                @endif
            </div>

            {{-- SEO --}}
            <div class="section-card" style="margin-top:16px;">
                <div class="section-header">
                    <div class="section-icon" style="background:#f5f3ff;">🔍</div>
                    <span class="section-title">SEO</span>
                </div>
                <div class="section-body">
                    <div class="field-single">
                        <div class="field-label">Slug URL</div>
                        <div class="field-value {{ !$car->slug ? 'empty' : '' }}" style="font-family:monospace;font-size:13px;">
                            {{ $car->slug ?? 'Chưa có' }}
                        </div>
                    </div>
                    <div class="field-single">
                        <div class="field-label">Meta description</div>
                        <div class="field-value multiline {{ !$car->meta_description ? 'empty' : '' }}">{{ $car->meta_description ?? 'Chưa có.' }}</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection