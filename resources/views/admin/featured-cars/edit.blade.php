{{-- resources/views/admin/featured-cars/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Upload ảnh 360° - ' . $car->name)

@push('styles')
<style>
.edit360 { max-width: 960px; margin: 0 auto; padding: 32px 24px; }
.edit360-header { margin-bottom: 28px; }
.edit360-header h1 { font-size: 24px; font-weight: 800; color: #111; letter-spacing: -.5px; }
.edit360-header .back-link {
    font-size: 13px; color: #6b7280; text-decoration: none;
    display: inline-flex; align-items: center; gap: 4px; margin-bottom: 10px;
}
.edit360-header .back-link:hover { color: #111; }

.car-info-row {
    display: flex; align-items: center; gap: 16px;
    padding: 16px; background: #f9fafb; border: 1px solid #e5e7eb;
    border-radius: 10px; margin-bottom: 28px;
}
.car-info-row img { width: 90px; height: 55px; object-fit: contain; background: #fff; border-radius: 6px; }
.car-info-name { font-weight: 700; font-size: 16px; }
.car-info-price { font-size: 13px; color: #6b7280; margin-top: 2px; }

.alert-success {
    background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d;
    padding: 12px 18px; border-radius: 8px; font-size: 13px; margin-bottom: 20px;
}
.alert-error {
    background: #fef2f2; border: 1px solid #fca5a5; color: #dc2626;
    padding: 12px 18px; border-radius: 8px; font-size: 13px; margin-bottom: 20px;
}

.frames-section {
    background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
    overflow: hidden; margin-bottom: 24px;
}
.frames-section-header {
    padding: 16px 24px; border-bottom: 1px solid #e5e7eb;
    background: #f9fafb; display: flex; align-items: center; justify-content: space-between;
}
.frames-section-header h2 { font-size: 15px; font-weight: 700; margin: 0; }
.frames-hint {
    font-size: 12px; color: #6b7280;
    padding: 12px 24px; border-bottom: 1px solid #f3f4f6;
    background: #fffbf0; border-left: 3px solid #f59e0b;
}

.frames-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 1px;
    background: #e5e7eb; padding: 0;
}
.frame-cell {
    background: #fff; padding: 16px;
    display: flex; flex-direction: column; align-items: center; gap: 10px;
}
.frame-number {
    font-size: 11px; font-weight: 700; letter-spacing: 1px;
    text-transform: uppercase; color: #9ca3af;
}
.frame-preview {
    width: 100%; aspect-ratio: 4/3;
    border: 2px dashed #e5e7eb; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden; position: relative; background: #f9fafb;
    transition: border-color .2s;
}
.frame-preview.has-image { border-style: solid; border-color: #22c55e; }
.frame-preview img { width: 100%; height: 100%; object-fit: contain; }
.frame-preview .no-img-text { font-size: 11px; color: #9ca3af; text-align: center; padding: 8px; }
.frame-preview .exists-badge {
    position: absolute; top: 6px; right: 6px;
    background: #22c55e; color: #fff; font-size: 9px; font-weight: 700;
    letter-spacing: 1px; padding: 2px 6px; border-radius: 3px;
}

.frame-delete-form { width: 100%; }
.btn-frame-delete {
    width: 100%; background: #fff; color: #dc2626;
    border: 1.5px solid #fca5a5; border-radius: 6px;
    padding: 5px 0; font-size: 11px; font-weight: 700;
    cursor: pointer; transition: background .2s;
}
.btn-frame-delete:hover { background: #fef2f2; }

.batch-section {
    background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
    overflow: hidden; margin-bottom: 24px;
}
.batch-section-header {
    padding: 16px 24px; border-bottom: 1px solid #e5e7eb; background: #f9fafb;
}
.batch-section-header h2 { font-size: 15px; font-weight: 700; margin: 0; }

.batch-drop {
    margin: 24px; border: 2px dashed #d1d5db; border-radius: 10px;
    padding: 40px 20px; text-align: center; cursor: pointer;
    transition: border-color .2s, background .2s; background: #fafafa;
}
.batch-drop:hover, .batch-drop.dragover { border-color: #d42b2b; background: #fff5f5; }
.batch-drop input[type=file] { display: none; }
.batch-drop-icon { font-size: 36px; margin-bottom: 10px; }
.batch-drop-text { font-size: 14px; font-weight: 600; color: #374151; }
.batch-drop-sub { font-size: 12px; color: #9ca3af; margin-top: 4px; }

.batch-preview {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;
    padding: 0 24px 24px;
}
.batch-preview-item {
    border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; position: relative;
}
.batch-preview-item img { width: 100%; aspect-ratio: 4/3; object-fit: contain; background: #f9fafb; display: block; }
.batch-preview-label {
    padding: 6px 10px; background: #f9fafb; border-top: 1px solid #e5e7eb;
    display: flex; align-items: center; justify-content: space-between;
}
.batch-preview-frame-label {
    font-size: 12px; font-weight: 700; color: #374151;
}
.batch-preview-remove {
    background: none; border: none; color: #dc2626; cursor: pointer;
    font-size: 16px; line-height: 1; padding: 0;
}
.batch-upload-btn {
    display: block; margin: 0 24px 24px;
    background: #d42b2b; color: #fff; border: none; border-radius: 8px;
    padding: 13px 0; font-size: 14px; font-weight: 700; letter-spacing: .5px;
    cursor: pointer; text-align: center; width: calc(100% - 48px);
    transition: background .2s;
}
.batch-upload-btn:hover { background: #b52222; }
.batch-upload-btn:disabled { background: #9ca3af; cursor: not-allowed; }

.badge-section {
    background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
    overflow: hidden; margin-bottom: 24px;
}
.badge-section-header {
    padding: 16px 24px; border-bottom: 1px solid #e5e7eb; background: #f9fafb;
}
.badge-form {
    padding: 20px 24px; display: flex; gap: 12px; align-items: center;
}
.badge-form input[type=text] {
    flex: 1; border: 1.5px solid #d1d5db; border-radius: 8px;
    padding: 10px 14px; font-size: 14px; outline: none; transition: border-color .2s;
}
.badge-form input[type=text]:focus { border-color: #d42b2b; }
.badge-presets { padding: 0 24px 20px; display: flex; gap: 8px; flex-wrap: wrap; }
.badge-preset {
    background: #f3f4f6; border: 1.5px solid #e5e7eb; border-radius: 20px;
    padding: 4px 14px; font-size: 12px; font-weight: 700; cursor: pointer;
    transition: all .2s; color: #374151;
}
.badge-preset:hover { background: #d42b2b; color: #fff; border-color: #d42b2b; }

.btn {
    display: inline-flex; align-items: center; gap: 6px;
    border-radius: 8px; font-size: 13px; font-weight: 700;
    padding: 9px 18px; border: none; cursor: pointer;
    text-decoration: none; transition: all .2s; white-space: nowrap;
}
.btn-primary { background: #d42b2b; color: #fff; }
.btn-primary:hover { background: #b52222; color: #fff; }
.btn-outline { background: #fff; color: #374151; border: 1.5px solid #d1d5db; }
.btn-outline:hover { background: #f3f4f6; }

@media (max-width: 600px) {
    .frames-grid, .batch-preview { grid-template-columns: repeat(2, 1fr); }
}
</style>
@endpush

@section('content')
<div class="edit360">
    <div class="edit360-header">
        <a href="{{ route('admin.featured-cars.index') }}" class="back-link">← Quay lại danh sách</a>
        <h1>Quản lý ảnh 360° — {{ $car->name }}</h1>
    </div>

    @if(session('success'))
        <div class="alert-success">✓ {{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $e) {{ $e }}<br> @endforeach
        </div>
    @endif

    @php
        // Ưu tiên ảnh 360° frame 1 nếu có, rồi mới dùng ảnh thường của xe
        $slug360  = \Illuminate\Support\Str::slug($car->name);
        $folder360 = public_path("images/quay360/{$slug360}/");
        if (file_exists($folder360 . '1.png')) {
            $thumb = rtrim(asset("images/quay360/{$slug360}"), '/') . '/1.png';
        } elseif (!empty($car->image_url)) {
            $raw = $car->image_url;
            $thumb = preg_match('#^https?://#i', $raw) ? $raw : rtrim(asset(ltrim($raw, '/')), '/');
        } elseif (!empty($car->image)) {
            $raw = $car->image;
            $thumb = preg_match('#^https?://#i', $raw) ? $raw : rtrim(asset(ltrim($raw, '/')), '/');
        } else {
            $thumb = null;
        }
    @endphp

    <div class="car-info-row">
        @if($thumb)
            <img src="{{ $thumb }}" alt="{{ $car->name }}">
        @endif
        <div>
            <div class="car-info-name">{{ $car->name }}</div>
            <div class="car-info-price">
                Giá: {{ number_format($car->price_per_day ?? $car->price) }} VNĐ
                · Trạng thái: {{ $car->status }}
                · Nổi bật: {{ $car->is_featured ? '✓ Có' : '✗ Chưa' }}
            </div>
        </div>
        @if(!$car->is_featured)
            <form method="POST" action="{{ route('admin.featured-cars.mark', $car) }}" style="margin-left:auto;">
                @csrf @method('PATCH')
                <input type="hidden" name="badge_label" value="{{ $car->badge_label ?? '' }}">
                <button class="btn btn-primary" type="submit">★ Đánh dấu nổi bật</button>
            </form>
        @endif
    </div>

    {{-- BADGE --}}
    <div class="badge-section">
        <div class="badge-section-header">
            <h2 style="font-size:15px;font-weight:700;margin:0;">🏷️ Badge hiển thị trên card</h2>
        </div>
        <form method="POST" action="{{ route('admin.featured-cars.mark', $car) }}" class="badge-form">
            @csrf @method('PATCH')
            <input type="text" name="badge_label" id="badgeInput"
                   placeholder="Vd: Flagship, Biểu tượng, Bán chạy, Full Electric..."
                   value="{{ old('badge_label', $car->badge_label) }}"
                   maxlength="60">
            <button class="btn btn-primary" type="submit">Lưu badge</button>
        </form>
        <div class="badge-presets">
            @foreach(['Flagship','Biểu tượng','Bán chạy','Full Electric','Mới ra mắt','Giới hạn','Performance'] as $preset)
                <button class="badge-preset" onclick="document.getElementById('badgeInput').value='{{ $preset }}'">
                    {{ $preset }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- FRAME HIỆN TẠI --}}
    <div class="frames-section">
        <div class="frames-section-header">
            <h2>Ảnh 360° hiện tại (8 frame)</h2>
            <span style="font-size:12px;color:#6b7280;">
                @php $filled = collect($frames)->where('exists', true)->count(); @endphp
                {{ $filled }}/8 frame đã có ảnh
            </span>
        </div>
        <div class="frames-hint">
            💡 Thứ tự frame: Frame 1 = góc chính diện → Frame 8 = xoay gần về góc ban đầu.
            Thả đúng thứ tự 1→8, ảnh sẽ tự gán vào đúng frame.
        </div>
        <div class="frames-grid">
            @foreach($frames as $num => $frame)
                <div class="frame-cell">
                    <div class="frame-number">Frame {{ $num }}</div>
                    <div class="frame-preview {{ $frame['exists'] ? 'has-image' : '' }}">
                        @if($frame['exists'])
                            <img src="{{ $frame['url'] }}" alt="Frame {{ $num }}">
                            <span class="exists-badge">✓</span>
                        @else
                            <div class="no-img-text">Chưa có ảnh</div>
                        @endif
                    </div>
                    @if($frame['exists'])
                        <form class="frame-delete-form" method="POST"
                              action="{{ route('admin.featured-cars.delete-frame', [$car, $num]) }}"
                              onsubmit="return confirm('Xoá frame {{ $num }}?')">
                            @csrf @method('DELETE')
                            <button class="btn-frame-delete" type="submit">🗑 Xoá frame {{ $num }}</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    {{-- UPLOAD MỚI --}}
    <div class="batch-section">
        <div class="batch-section-header">
            <h2 style="font-size:15px;font-weight:700;margin:0;">📤 Upload ảnh 360° mới</h2>
        </div>

        <div class="batch-drop" id="dropZone" onclick="document.getElementById('fileInput').click()">
            <input type="file" id="fileInput" multiple accept="image/png,image/jpeg,image/webp">
            <div class="batch-drop-icon">🖼️</div>
            <div class="batch-drop-text">Kéo thả ảnh vào đây hoặc click để chọn</div>
            <div class="batch-drop-sub">
                PNG / JPG / WebP · Tối đa 8 ảnh · Mỗi ảnh ≤ 5MB<br>
                <strong>Lưu ý:</strong> Thả đúng thứ tự Frame 1→8. Ảnh sẽ tự gán theo thứ tự bạn thả.
            </div>
        </div>

        <div class="batch-preview" id="batchPreview" style="display:none;"></div>

        <form id="uploadForm" method="POST"
              action="{{ route('admin.featured-cars.update360', $car) }}"
              enctype="multipart/form-data" style="display:none;">
            @csrf @method('PUT')
            <div id="formInputs"></div>
        </form>

        <button class="batch-upload-btn" id="uploadBtn" disabled onclick="submitUpload()">
            📤 Upload ảnh lên server
        </button>
    </div>
</div>

@push('scripts')
<script>
(function () {
    var fileInput  = document.getElementById('fileInput');
    var dropZone   = document.getElementById('dropZone');
    var preview    = document.getElementById('batchPreview');
    var uploadBtn  = document.getElementById('uploadBtn');
    var uploadForm = document.getElementById('uploadForm');
    var formInputs = document.getElementById('formInputs');

    var stagedFiles = []; // { file, objectUrl }

    ['dragover','dragleave','drop'].forEach(function (evt) {
        dropZone.addEventListener(evt, function (e) {
            e.preventDefault();
            dropZone.classList.toggle('dragover', evt === 'dragover');
            if (evt === 'drop') handleFiles(Array.from(e.dataTransfer.files));
        });
    });

    fileInput.addEventListener('change', function () {
        handleFiles(Array.from(fileInput.files));
        fileInput.value = '';
    });

    function handleFiles(files) {
        files = files.filter(function (f) { return f.type.startsWith('image/'); });
        if (stagedFiles.length + files.length > 8) {
            alert('Tối đa 8 ảnh.');
            files = files.slice(0, 8 - stagedFiles.length);
        }
        files.forEach(function (f) {
            stagedFiles.push({ file: f, objectUrl: URL.createObjectURL(f) });
        });
        renderPreview();
    }

    function renderPreview() {
        if (stagedFiles.length === 0) {
            preview.style.display = 'none';
            uploadBtn.disabled = true;
            uploadBtn.textContent = '📤 Upload ảnh lên server';
            return;
        }
        preview.style.display = 'grid';
        preview.innerHTML = '';
        stagedFiles.forEach(function (item, idx) {
            var div = document.createElement('div');
            div.className = 'batch-preview-item';
            div.innerHTML =
                '<img src="' + item.objectUrl + '" alt="Frame ' + (idx + 1) + '">' +
                '<div class="batch-preview-label">' +
                    '<span class="batch-preview-frame-label">Frame ' + (idx + 1) + '</span>' +
                    '<button class="batch-preview-remove" data-idx="' + idx + '" type="button">✕</button>' +
                '</div>';

            div.querySelector('.batch-preview-remove').addEventListener('click', function (e) {
                var i2 = parseInt(e.target.dataset.idx);
                URL.revokeObjectURL(stagedFiles[i2].objectUrl);
                stagedFiles.splice(i2, 1);
                renderPreview();
            });

            preview.appendChild(div);
        });
        uploadBtn.disabled = false;
        uploadBtn.textContent = '📤 Upload ' + stagedFiles.length + ' ảnh lên server';
    }

    window.submitUpload = function () {
        if (stagedFiles.length === 0) return;

        var dt = new DataTransfer();
        stagedFiles.forEach(function (s) { dt.items.add(s.file); });

        formInputs.innerHTML = '';

        stagedFiles.forEach(function (s, i) {
            var inp = document.createElement('input');
            inp.type  = 'hidden';
            inp.name  = 'frame_indices[' + i + ']';
            inp.value = i;
            formInputs.appendChild(inp);
        });

        var fi = document.createElement('input');
        fi.type     = 'file';
        fi.name     = 'frames[]';
        fi.multiple = true;
        fi.style.display = 'none';
        fi.files    = dt.files;
        formInputs.appendChild(fi);

        uploadBtn.disabled    = true;
        uploadBtn.textContent = '⏳ Đang upload...';
        uploadForm.style.display = 'block';
        uploadForm.submit();
    };
})();
</script>
@endpush

@endsection