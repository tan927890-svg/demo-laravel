@extends('layouts.admin')

@section('page-title', 'Cập nhật bảng giá')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
*, *::before, *::after { box-sizing: border-box; }

.pl-wrap {
    padding: 20px 20px 0;
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #f5f6fa;
    min-height: 100vh;
}

/* ===== Header ===== */
.pl-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
    flex-wrap: wrap;
    gap: 10px;
}
.pl-header-left { display: flex; align-items: center; gap: 10px; }
.pl-header-icon {
    width: 38px; height: 38px;
    background: #eff6ff;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
    border: 1px solid #bfdbfe;
}
.pl-title { font-size: 18px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -.2px; }
.pl-subtitle { font-size: 12px; color: #9ca3af; margin: 2px 0 0; }
.pl-back {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 7px 14px; border: 1px solid #e5e7eb;
    border-radius: 8px; text-decoration: none;
    font-size: 13px; font-weight: 500;
    color: #374151; background: #fff;
    transition: background .15s;
}
.pl-back:hover { background: #f3f4f6; }

/* ===== Alert ===== */
.alert-success {
    background: #f0fdf4; color: #15803d;
    padding: 10px 14px; border-radius: 8px;
    margin-bottom: 12px; font-size: 13px;
    border: 1px solid #bbf7d0;
    display: flex; align-items: center; gap: 7px;
}
.alert-success::before {
    content: '✓'; width: 18px; height: 18px;
    background: #15803d; color: #fff;
    border-radius: 50%; display: inline-flex;
    align-items: center; justify-content: center;
    font-size: 10px; font-weight: 700; flex-shrink: 0;
}

/* ===== Brand tabs ===== */
.brand-tabs-wrap {
    display: flex; gap: 5px; flex-wrap: wrap;
    align-items: center; margin-bottom: 12px;
    background: #fff; border: 1px solid #e5e7eb;
    border-radius: 10px; padding: 6px 10px;
}
.brand-tabs-label {
    font-size: 11px; font-weight: 700; color: #9ca3af;
    text-transform: uppercase; letter-spacing: .6px; margin-right: 2px;
}
.brand-tab {
    padding: 5px 12px; border: 1px solid transparent;
    border-radius: 7px; text-decoration: none;
    font-size: 13px; font-weight: 500; color: #6b7280;
    white-space: nowrap; transition: all .15s;
}
.brand-tab:hover { background: #f3f4f6; color: #374151; }
.brand-tab.active { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; font-weight: 600; }

/* ===== Toolbar ===== */
.toolbar {
    display: flex; gap: 8px; align-items: center;
    justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap;
}
.search-form { display: flex; gap: 6px; flex: 1; min-width: 0; max-width: 380px; }
.search-input-wrap { position: relative; flex: 1; min-width: 0; }
.search-icon { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 13px; pointer-events: none; }
.search-input {
    width: 100%; padding: 7px 12px 7px 30px;
    border: 1px solid #e5e7eb; border-radius: 8px;
    font-size: 13px; font-family: inherit;
    outline: none; background: #fff; color: #111827;
    transition: border .15s, box-shadow .15s;
}
.search-input::placeholder { color: #c0c5cc; }
.search-input:focus { border-color: #93c5fd; box-shadow: 0 0 0 3px #dbeafe50; }
.btn-search {
    padding: 7px 14px; background: #1d4ed8; color: #fff;
    border: none; border-radius: 8px; font-size: 13px;
    font-family: inherit; font-weight: 600; cursor: pointer;
    white-space: nowrap; transition: background .15s;
}
.btn-search:hover { background: #1e40af; }
.btn-clear {
    display: flex; align-items: center; justify-content: center;
    width: 32px; height: 32px; border: 1px solid #e5e7eb;
    border-radius: 8px; text-decoration: none; color: #6b7280;
    background: #fff; font-size: 13px; transition: all .15s; flex-shrink: 0;
}
.btn-clear:hover { background: #fef2f2; color: #ef4444; border-color: #fca5a5; }
.car-count {
    font-size: 12px; color: #9ca3af;
    background: #f3f4f6; border: 1px solid #e5e7eb;
    border-radius: 6px; padding: 4px 10px; font-weight: 600;
}

/* ===== Table card ===== */
.table-card {
    background: #fff; border-radius: 12px;
    border: 1px solid #e5e7eb; overflow: hidden;
}
.table-wrap { overflow-x: auto; }
.pl-table {
    width: 100%; border-collapse: collapse;
    font-size: 13px; min-width: 680px;
}
.pl-table thead tr {
    background: #f9fafb; border-bottom: 1px solid #f0f0f0;
}
.pl-table th {
    padding: 10px 14px; text-align: left;
    font-weight: 700; color: #6b7280;
    font-size: 11px; text-transform: uppercase;
    letter-spacing: .5px; white-space: nowrap;
}
.pl-table tbody tr {
    border-bottom: 1px solid #f9fafb;
    transition: background .1s;
}
.pl-table tbody tr:last-child { border-bottom: none; }
.pl-table tbody tr:hover { background: #fafbff; }
.pl-table td { padding: 10px 14px; color: #374151; vertical-align: middle; }

/* Thumbnail */
.car-thumb {
    width: 66px; height: 44px; object-fit: contain;
    background: #f8f9fb; border-radius: 7px;
    border: 1px solid #eef0f3; display: block;
}
.car-thumb-placeholder {
    width: 66px; height: 44px; background: #f8f9fb;
    border-radius: 7px; border: 1px solid #eef0f3;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; color: #d1d5db;
}

/* Car name cell */
.car-name { font-weight: 600; color: #111827; font-size: 13px; }
.car-model { font-size: 11px; color: #b0b6c2; margin-top: 1px; }

/* Brand chip */
.brand-chip {
    display: inline-flex; align-items: center;
    background: #f3f4f6; color: #374151;
    font-size: 11px; font-weight: 600;
    padding: 3px 8px; border-radius: 5px;
    border: 1px solid #e5e7eb;
}

/* Price input */
.price-input {
    width: 100%; padding: 7px 10px;
    border: 1px solid #e5e7eb; border-radius: 7px;
    font-size: 13px; font-family: inherit;
    font-weight: 700; color: #1d4ed8;
    outline: none; min-width: 160px;
    background: #f8fbff;
    transition: border-color .15s, box-shadow .15s;
}
.price-input:focus {
    border-color: #93c5fd;
    box-shadow: 0 0 0 3px #dbeafe50;
    background: #fff;
}

/* File upload */
.file-upload-label {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 10px; border: 1px dashed #d1d5db;
    border-radius: 7px; cursor: pointer;
    font-size: 12px; color: #6b7280;
    background: #fafafa;
    transition: all .15s; white-space: nowrap;
}
.file-upload-label:hover { border-color: #93c5fd; color: #1d4ed8; background: #eff6ff; }
.file-upload-input { display: none; }
.file-name-tag {
    font-size: 11px; color: #9ca3af;
    margin-top: 3px; display: block;
}
.file-name-tag.has-file { color: #15803d; font-weight: 600; }
.file-name-tag.no-image { color: #f59e0b; }

/* Empty state */
.empty-state { padding: 40px; text-align: center; color: #9ca3af; font-size: 14px; }

/* ===== Sticky save bar ===== */
.save-bar {
    position: sticky; bottom: 0;
    background: #fff; border-top: 1px solid #e5e7eb;
    padding: 10px 20px;
    display: flex; align-items: center;
    justify-content: space-between;
    gap: 12px; flex-wrap: wrap;
    box-shadow: 0 -4px 16px rgba(0,0,0,0.06);
    z-index: 10; margin: 0 -20px;
}
.save-note { font-size: 13px; color: #6b7280; }
.save-note strong { color: #111827; }
.btn-save {
    display: inline-flex; align-items: center; gap: 6px;
    background: #16a34a; color: #fff;
    padding: 9px 22px; border: none;
    border-radius: 8px; font-size: 14px;
    font-family: inherit; font-weight: 700; cursor: pointer;
    transition: background .15s; white-space: nowrap;
}
.btn-save:hover { background: #15803d; }

@media (max-width: 640px) {
    .pl-wrap { padding: 14px 14px 0; }
    .pl-title { font-size: 16px; }
    .search-form { max-width: 100%; width: 100%; }
    .save-bar { flex-direction: column; align-items: stretch; margin: 0 -14px; padding: 10px 14px; }
    .btn-save { justify-content: center; }
}
</style>

<div class="pl-wrap">

    {{-- Header --}}
    <div class="pl-header">
        <div class="pl-header-left">
            <div class="pl-header-icon">📋</div>
            <div>
                <h2 class="pl-title">Cập nhật bảng giá</h2>
                <p class="pl-subtitle">Chỉnh giá và ảnh đại diện — lưu một lần toàn bộ</p>
            </div>
        </div>
        <a href="{{ route('admin.cars.index') }}" class="pl-back">← Quay lại DS xe</a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    {{-- Brand tabs --}}
    <div class="brand-tabs-wrap">
        <span class="brand-tabs-label">Hãng</span>
        <a href="{{ route('admin.price-list.index', ['search' => request('search')]) }}"
           class="brand-tab {{ !request('brand') ? 'active' : '' }}">Tất cả</a>
        @foreach($brands as $brand)
            <a href="{{ route('admin.price-list.index', ['brand' => $brand->id, 'search' => request('search')]) }}"
               class="brand-tab {{ request('brand') == $brand->id ? 'active' : '' }}">
                {{ $brand->name }}
            </a>
        @endforeach
    </div>

    {{-- Toolbar --}}
    <div class="toolbar">
        <form method="GET" action="{{ route('admin.price-list.index') }}" class="search-form">
            @if(request('brand'))
                <input type="hidden" name="brand" value="{{ request('brand') }}">
            @endif
            <div class="search-input-wrap">
                <span class="search-icon">🔍</span>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Tìm tên xe, model..." class="search-input">
            </div>
            <button type="submit" class="btn-search">Tìm</button>
            @if(request('search'))
                <a href="{{ route('admin.price-list.index', ['brand' => request('brand')]) }}" class="btn-clear" title="Xoá">✕</a>
            @endif
        </form>
        <span class="car-count">{{ $cars->count() }} xe</span>
    </div>

    {{-- Main form --}}
    <form method="POST" action="{{ route('admin.price-list.update') }}" enctype="multipart/form-data">
        @csrf
        @if(request('brand'))
            <input type="hidden" name="brand" value="{{ request('brand') }}">
        @endif
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif

        <div class="table-card">
            <div class="table-wrap">
                <table class="pl-table">
                    <thead>
                        <tr>
                            <th>Ảnh</th>
                            <th>Tên xe</th>
                            <th>Hãng</th>
                            <th>Giá bán (VNĐ)</th>
                            <th>Ảnh mới</th>
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
                        @endphp
                        <tr>
                            <td>
                                @if($thumb)
                                    <img src="{{ $thumb }}" alt="{{ $car->name }}" class="car-thumb" id="preview-{{ $car->id }}">
                                @else
                                    <div class="car-thumb-placeholder" id="preview-{{ $car->id }}">🚗</div>
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
                                <input type="number"
                                       name="prices[{{ $car->id }}]"
                                       value="{{ $car->price_per_day }}"
                                       class="price-input"
                                       min="0" step="1000000"
                                       placeholder="Nhập giá...">
                            </td>
                            <td>
                                <label class="file-upload-label" for="img-{{ $car->id }}">
                                    📁 Chọn ảnh
                                </label>
                                <input type="file"
                                       id="img-{{ $car->id }}"
                                       name="images[{{ $car->id }}]"
                                       accept="image/*"
                                       class="file-upload-input"
                                       onchange="previewImg(this, {{ $car->id }})">
                                <span class="file-name-tag {{ $thumb ? '' : 'no-image' }}" id="fname-{{ $car->id }}">
                                    {{ $thumb ? 'Đã có ảnh' : 'Chưa có ảnh' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5"><div class="empty-state">Chưa có xe nào.</div></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Sticky save bar --}}
        @if($cars->count())
        <div class="save-bar">
            <span class="save-note">
                Đang hiển thị <strong>{{ $cars->count() }}</strong> xe — nhấn lưu để cập nhật tất cả
            </span>
            <button type="submit" class="btn-save">💾 Lưu bảng giá</button>
        </div>
        @endif
    </form>

</div>

<script>
function previewImg(input, carId) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const url  = URL.createObjectURL(file);
    const prev = document.getElementById('preview-' + carId);
    const fname = document.getElementById('fname-' + carId);
    if (prev) {
        if (prev.tagName === 'DIV') {
            const img = document.createElement('img');
            img.src = url; img.className = 'car-thumb'; img.id = 'preview-' + carId;
            prev.replaceWith(img);
        } else { prev.src = url; }
    }
    if (fname) {
        const name = file.name.length > 20 ? file.name.substring(0, 18) + '…' : file.name;
        fname.textContent = name;
        fname.className = 'file-name-tag has-file';
    }
}
</script>
@endsection