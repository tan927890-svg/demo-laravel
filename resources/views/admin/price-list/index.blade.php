@extends('layouts.admin')

@section('page-title', 'Cập nhật bảng giá')

@section('content')
<style>
*, *::before, *::after { box-sizing: border-box; }

.pl-wrap { padding: 20px 16px; }

.pl-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
}
.pl-title { font-size: 24px; font-weight: 700; color: #111827; margin: 0; }
.pl-subtitle { font-size: 14px; color: #6b7280; margin-top: 4px; }

/* Brand tabs */
.brand-tabs {
    display: flex; gap: 8px; flex-wrap: wrap;
    align-items: center; margin-bottom: 14px;
}
.brand-tab {
    padding: 7px 15px; border: 1px solid #d1d5db; border-radius: 6px;
    text-decoration: none; font-size: 14px; color: #374151;
    white-space: nowrap; transition: background .15s, color .15s;
}
.brand-tab:hover { background: #f3f4f6; }
.brand-tab.active { background: #1d4ed8; color: #fff; border-color: #1d4ed8; }

/* Toolbar */
.toolbar {
    display: flex; gap: 10px; align-items: center;
    justify-content: space-between; margin-bottom: 18px; flex-wrap: wrap;
}
.search-form { display: flex; gap: 8px; flex: 1; min-width: 0; max-width: 400px; }
.search-input {
    flex: 1; min-width: 0; padding: 9px 14px;
    border: 1px solid #d1d5db; border-radius: 6px; font-size: 15px;
    outline: none; background: #fff;
}
.search-input:focus { border-color: #1d4ed8; box-shadow: 0 0 0 3px #dbeafe; }
.btn-search {
    padding: 9px 16px; background: #1d4ed8; color: #fff;
    border: none; border-radius: 6px; font-size: 15px; cursor: pointer;
}
.btn-clear {
    padding: 9px 13px; border: 1px solid #d1d5db; border-radius: 6px;
    font-size: 15px; text-decoration: none; color: #374151; background: #fff;
}

/* Alert */
.alert-success {
    background: #dcfce7; color: #166534; padding: 13px 16px;
    border-radius: 6px; margin-bottom: 16px; font-size: 15px;
}

/* Table */
.table-wrap {
    overflow-x: auto; background: #fff;
    border-radius: 8px; border: 1px solid #e5e7eb;
}
.pl-table {
    width: 100%; border-collapse: collapse; font-size: 15px; min-width: 700px;
}
.pl-table thead tr { background: #f9fafb; border-bottom: 1px solid #e5e7eb; }
.pl-table th {
    padding: 13px 16px; text-align: left;
    font-weight: 600; color: #374151; font-size: 14px;
}
.pl-table td {
    padding: 12px 16px; border-bottom: 1px solid #f3f4f6;
    color: #374151; vertical-align: middle;
}

.car-thumb {
    width: 76px; height: 50px; object-fit: contain;
    background: #f3f4f6; border-radius: 6px;
    border: 1px solid #e5e7eb; display: block;
}
.car-thumb-placeholder {
    width: 76px; height: 50px; background: #f3f4f6;
    border-radius: 6px; border: 1px solid #e5e7eb;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: #d1d5db;
}
.car-name-cell .name { font-weight: 600; color: #111827; }
.car-name-cell .model { font-size: 13px; color: #9ca3af; margin-top: 2px; }

/* Price input */
.price-input {
    width: 100%; padding: 8px 12px;
    border: 1px solid #d1d5db; border-radius: 6px;
    font-size: 15px; font-weight: 600; color: #111827;
    outline: none; min-width: 180px;
    transition: border-color .15s, box-shadow .15s;
}
.price-input:focus { border-color: #1d4ed8; box-shadow: 0 0 0 3px #dbeafe; }

/* Image upload */
.img-upload-wrap { display: flex; flex-direction: column; gap: 6px; }
.img-upload-wrap input[type=file] { font-size: 13px; }
.img-preview {
    width: 76px; height: 50px; object-fit: contain;
    border-radius: 4px; border: 1px solid #e5e7eb;
    background: #f3f4f6; display: block;
}
.img-filename { font-size: 12px; color: #6b7280; margin-top: 2px; }

/* Save bar */
.save-bar {
    position: sticky; bottom: 0; background: #fff;
    border-top: 1px solid #e5e7eb;
    padding: 14px 20px;
    display: flex; align-items: center;
    justify-content: space-between;
    gap: 12px; flex-wrap: wrap;
    box-shadow: 0 -2px 8px rgba(0,0,0,0.07);
    z-index: 10;
}
.save-note { font-size: 14px; color: #6b7280; }
.btn-save {
    background: #16a34a; color: #fff;
    padding: 11px 28px; border: none;
    border-radius: 6px; font-size: 16px;
    font-weight: 700; cursor: pointer;
    transition: background .15s;
}
.btn-save:hover { background: #15803d; }

@media (max-width: 640px) {
    .pl-wrap { padding: 14px 12px; }
    .pl-title { font-size: 20px; }
    .search-form { max-width: 100%; width: 100%; }
    .save-bar { flex-direction: column; align-items: stretch; }
    .btn-save { text-align: center; }
}
</style>

<div class="pl-wrap">

    <div class="pl-header">
        <div>
            <h2 class="pl-title">📋 Cập nhật bảng giá</h2>
            <div class="pl-subtitle">Chỉnh giá và ảnh đại diện của từng xe — lưu một lần toàn bộ</div>
        </div>
        <a href="{{ route('admin.cars.index') }}"
           style="padding:9px 18px;border:1px solid #d1d5db;border-radius:6px;
                  text-decoration:none;font-size:14px;color:#374151;background:#fff;">
            ← Quay lại DS xe
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    {{-- Brand tabs --}}
    <div class="brand-tabs">
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
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Tìm tên xe, model..." class="search-input">
            <button type="submit" class="btn-search">Tìm</button>
            @if(request('search'))
                <a href="{{ route('admin.price-list.index', ['brand' => request('brand')]) }}" class="btn-clear">✕</a>
            @endif
        </form>
        <span style="font-size:14px;color:#6b7280;">{{ $cars->count() }} xe</span>
    </div>

    {{-- Main form --}}
    <form method="POST"
          action="{{ route('admin.price-list.update') }}"
          enctype="multipart/form-data">
        @csrf
        @if(request('brand'))
            <input type="hidden" name="brand" value="{{ request('brand') }}">
        @endif
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif

        <div class="table-wrap">
            <table class="pl-table">
                <thead>
                    <tr>
                        <th>Ảnh hiện tại</th>
                        <th>Tên xe</th>
                        <th>Hãng</th>
                        <th>Giá hiện tại (VNĐ)</th>
                        <th>Ảnh mới (tuỳ chọn)</th>
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
                                <img src="{{ $thumb }}" alt="{{ $car->name }}" class="car-thumb"
                                     id="preview-{{ $car->id }}">
                            @else
                                <div class="car-thumb-placeholder" id="preview-{{ $car->id }}">🚗</div>
                            @endif
                        </td>
                        <td>
                            <div class="car-name-cell">
                                <div class="name">{{ $car->name }}</div>
                                <div class="model">{{ $car->model }}</div>
                            </div>
                        </td>
                        <td style="color:#6b7280;">{{ $car->brand->name ?? '—' }}</td>
                        <td>
                            <input type="number"
                                   name="prices[{{ $car->id }}]"
                                   value="{{ $car->price_per_day }}"
                                   class="price-input"
                                   min="0" step="1000000"
                                   placeholder="Nhập giá...">
                        </td>
                        <td>
                            <div class="img-upload-wrap">
                                <input type="file"
                                       name="images[{{ $car->id }}]"
                                       accept="image/*"
                                       onchange="previewImg(this, {{ $car->id }})">
                                @if($thumb)
                                    <span class="img-filename">Ảnh hiện tại đã có</span>
                                @else
                                    <span class="img-filename" style="color:#f59e0b;">Chưa có ảnh</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:40px;text-align:center;color:#9ca3af;">
                            Chưa có xe nào.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Sticky save bar --}}
        @if($cars->count())
        <div class="save-bar">
            <span class="save-note">
                💾 Nhấn lưu để cập nhật giá và ảnh cho <strong>{{ $cars->count() }}</strong> xe đang hiển thị
            </span>
            <button type="submit" class="btn-save">💾 Lưu bảng giá</button>
        </div>
        @endif
    </form>

</div>

<script>
function previewImg(input, carId) {
    if (!input.files || !input.files[0]) return;
    const file  = input.files[0];
    const url   = URL.createObjectURL(file);
    const prev  = document.getElementById('preview-' + carId);
    if (!prev) return;

    // Nếu placeholder div thì thay bằng img
    if (prev.tagName === 'DIV') {
        const img = document.createElement('img');
        img.src   = url;
        img.className = 'car-thumb';
        img.id    = 'preview-' + carId;
        prev.replaceWith(img);
    } else {
        prev.src = url;
    }
    // Cập nhật label
    const label = input.closest('.img-upload-wrap').querySelector('.img-filename');
    if (label) { label.textContent = file.name; label.style.color = '#16a34a'; }
}
</script>
@endsection
