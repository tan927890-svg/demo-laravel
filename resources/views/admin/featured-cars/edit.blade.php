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
    flex-wrap: wrap; gap: 10px;
}
.frames-section-header h2 { font-size: 15px; font-weight: 700; margin: 0; }
.frames-hint {
    font-size: 12px; color: #6b7280;
    padding: 12px 24px; border-bottom: 1px solid #f3f4f6;
    background: #fffbf0; border-left: 3px solid #f59e0b;
}

/* ── Bulk action bar ── */
.bulk-bar {
    display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
    padding: 10px 24px; background: #fff7ed; border-bottom: 1px solid #fed7aa;
    font-size: 13px;
}
.bulk-bar label { display: flex; align-items: center; gap: 6px; cursor: pointer; font-weight: 600; color: #374151; }
.bulk-bar input[type=checkbox] { width: 16px; height: 16px; accent-color: #dc2626; cursor: pointer; }
.bulk-bar .bulk-count { color: #9ca3af; font-size: 12px; }
.btn-bulk-delete {
    margin-left: auto;
    background: #dc2626; color: #fff; border: none; border-radius: 6px;
    padding: 7px 16px; font-size: 12px; font-weight: 700; cursor: pointer;
    display: inline-flex; align-items: center; gap: 6px;
    transition: background .2s; white-space: nowrap;
}
.btn-bulk-delete:hover { background: #b91c1c; }
.btn-bulk-delete:disabled { background: #9ca3af; cursor: not-allowed; }

.frames-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 1px;
    background: #e5e7eb; padding: 0;
}
.frame-cell {
    background: #fff; padding: 16px;
    display: flex; flex-direction: column; align-items: center; gap: 10px;
    position: relative; transition: background .15s;
}
.frame-cell.selected { background: #fef2f2; }

/* Checkbox overlay */
.frame-checkbox-wrap {
    position: absolute; top: 10px; left: 10px; z-index: 2;
    display: none;
}
.frame-checkbox-wrap input[type=checkbox] {
    width: 18px; height: 18px; accent-color: #dc2626; cursor: pointer;
    border-radius: 4px;
}
.select-mode .frame-checkbox-wrap { display: block; }

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
.frame-cell.selected .frame-preview.has-image { border-color: #dc2626; }
.frame-preview img { width: 100%; height: 100%; object-fit: contain; }
.frame-preview .no-img-text { font-size: 11px; color: #9ca3af; text-align: center; padding: 8px; }
.frame-preview .exists-badge {
    position: absolute; top: 6px; right: 6px;
    background: #22c55e; color: #fff; font-size: 9px; font-weight: 700;
    letter-spacing: 1px; padding: 2px 6px; border-radius: 3px;
}
.frame-cell.selected .frame-preview .exists-badge { background: #dc2626; }

/* Single delete (hidden in select mode) */
.frame-delete-form { width: 100%; }
.btn-frame-delete {
    width: 100%; background: #fff; color: #dc2626;
    border: 1.5px solid #fca5a5; border-radius: 6px;
    padding: 5px 0; font-size: 11px; font-weight: 700;
    cursor: pointer; transition: background .2s;
}
.btn-frame-delete:hover { background: #fef2f2; }
.select-mode .frame-delete-form { display: none; }

/* Batch upload section */
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
.batch-preview-frame-label { font-size: 12px; font-weight: 700; color: #374151; }
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

/* Badge */
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
.btn-sm { padding: 6px 12px; font-size: 12px; }

/* ── Confirm Modal ── */
.modal-overlay {
    display: none; position: fixed; inset: 0; z-index: 9999;
    background: rgba(0,0,0,.5); backdrop-filter: blur(3px);
    align-items: center; justify-content: center;
}
.modal-overlay.open { display: flex; }
.modal-box {
    background: #fff; border-radius: 16px; padding: 36px 32px 28px;
    max-width: 400px; width: 90%;
    box-shadow: 0 24px 80px rgba(0,0,0,.18);
    text-align: center;
    animation: modalPop .2s cubic-bezier(.34,1.56,.64,1);
}
@keyframes modalPop {
    from { transform: scale(.88) translateY(12px); opacity: 0; }
    to   { transform: scale(1)   translateY(0);    opacity: 1; }
}
.modal-icon-wrap {
    display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;
}
.modal-title { font-size: 18px; font-weight: 800; color: #111; margin-bottom: 8px; }
.modal-desc  { font-size: 13px; color: #6b7280; margin-bottom: 28px; line-height: 1.6; }
.modal-desc strong { color: #111; }
.modal-actions { display: flex; gap: 10px; justify-content: center; }
.modal-actions .btn { min-width: 120px; justify-content: center; padding: 9px 18px; font-size: 13px; }
.btn-danger-solid { background: #dc2626; color: #fff; border: none; }
.btn-danger-solid:hover { background: #b91c1c; color: #fff; }

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
        $slug360   = \Illuminate\Support\Str::slug($car->name);
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
            <div style="display:flex;align-items:center;gap:10px;">
                <span style="font-size:12px;color:#6b7280;">
                    @php $filled = collect($frames)->where('exists', true)->count(); @endphp
                    {{ $filled }}/8 frame đã có ảnh
                </span>
                @if($filled > 0)
                    <button class="btn btn-outline btn-sm" id="toggleSelectBtn" onclick="toggleSelectMode()">
                        ☑ Chọn để xoá
                    </button>
                @endif
            </div>
        </div>

        <div class="frames-hint">
            💡 Thứ tự frame: Frame 1 = góc chính diện → Frame 8 = xoay gần về góc ban đầu.
            Thả đúng thứ tự 1→8, ảnh sẽ tự gán vào đúng frame.
        </div>

        {{-- Bulk action bar (ẩn mặc định) --}}
        <div class="bulk-bar" id="bulkBar" style="display:none;">
            <label>
                <input type="checkbox" id="checkAll" onchange="toggleCheckAll(this)">
                Chọn tất cả
            </label>
            <span class="bulk-count" id="bulkCount">0 frame được chọn</span>
            <button class="btn-bulk-delete" id="bulkDeleteBtn" disabled
                    onclick="openBulkDeleteModal()">
                🗑 Xoá các frame đã chọn
            </button>
            <button class="btn btn-outline btn-sm" onclick="toggleSelectMode()">Huỷ</button>
        </div>

        <div class="frames-grid" id="framesGrid">
            @foreach($frames as $num => $frame)
                <div class="frame-cell" id="frame-cell-{{ $num }}" data-num="{{ $num }}">
                    {{-- Checkbox chọn (chỉ hiện khi có ảnh và đang select mode) --}}
                    @if($frame['exists'])
                        <div class="frame-checkbox-wrap">
                            <input type="checkbox" class="frame-cb" value="{{ $num }}"
                                   onchange="updateBulkCount()">
                        </div>
                    @endif

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
                        {{-- Form xoá đơn --}}
                        <form class="frame-delete-form" method="POST"
                              action="{{ route('admin.featured-cars.delete-frame', [$car, $num]) }}"
                              id="single-delete-form-{{ $num }}">
                            @csrf @method('DELETE')
                        </form>
                        <button type="button" class="btn-frame-delete frame-delete-form"
                                onclick="openSingleDeleteModal({{ $num }})">
                            🗑 Xoá frame {{ $num }}
                        </button>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Form xoá hàng loạt --}}
        <form id="bulkDeleteForm" method="POST"
              action="{{ route('admin.featured-cars.delete-frames', $car) }}"
              style="display:none;">
            @csrf @method('DELETE')
            <div id="bulkDeleteInputs"></div>
        </form>
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

{{-- ── Confirm Modal (dùng chung cho cả single & bulk) ── --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-icon-wrap">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width:80px;height:auto;object-fit:contain;">
        </div>
        <div class="modal-title" id="modalTitle">Xoá frame?</div>
        <div class="modal-desc" id="modalDesc"></div>
        <div class="modal-actions">
            <button class="btn btn-outline" onclick="closeModal()">Huỷ bỏ</button>
            <button class="btn btn-danger-solid" id="modalConfirmBtn">🗑 Xác nhận xoá</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
/* ══════════════════════════════
   SELECT MODE
══════════════════════════════ */
var selectModeActive = false;

function toggleSelectMode() {
    selectModeActive = !selectModeActive;
    var grid    = document.getElementById('framesGrid');
    var bar     = document.getElementById('bulkBar');
    var btn     = document.getElementById('toggleSelectBtn');

    grid.classList.toggle('select-mode', selectModeActive);
    bar.style.display = selectModeActive ? 'flex' : 'none';
    if (btn) btn.style.display = selectModeActive ? 'none' : '';

    // Uncheck all when exiting
    if (!selectModeActive) {
        document.querySelectorAll('.frame-cb').forEach(function (cb) { cb.checked = false; });
        document.getElementById('checkAll').checked = false;
        updateBulkCount();
    }
}

function toggleCheckAll(master) {
    document.querySelectorAll('.frame-cb').forEach(function (cb) {
        cb.checked = master.checked;
        var cell = cb.closest('.frame-cell');
        if (cell) cell.classList.toggle('selected', master.checked);
    });
    updateBulkCount();
}

function updateBulkCount() {
    var checked = document.querySelectorAll('.frame-cb:checked');
    var count   = checked.length;
    document.getElementById('bulkCount').textContent = count + ' frame được chọn';
    document.getElementById('bulkDeleteBtn').disabled = count === 0;

    // Sync checkAll master
    var all = document.querySelectorAll('.frame-cb');
    document.getElementById('checkAll').indeterminate = count > 0 && count < all.length;
    document.getElementById('checkAll').checked = count === all.length && all.length > 0;

    // Highlight cells
    document.querySelectorAll('.frame-cb').forEach(function (cb) {
        var cell = cb.closest('.frame-cell');
        if (cell) cell.classList.toggle('selected', cb.checked);
    });
}

/* ══════════════════════════════
   MODAL (chung)
══════════════════════════════ */
var _pendingAction = null;

function openSingleDeleteModal(frameNum) {
    document.getElementById('modalTitle').textContent = 'Xoá frame ' + frameNum + '?';
    document.getElementById('modalDesc').innerHTML =
        'Ảnh của <strong>Frame ' + frameNum + '</strong> sẽ bị xoá vĩnh viễn khỏi server.';
    _pendingAction = function () {
        document.getElementById('single-delete-form-' + frameNum).submit();
    };
    openModal();
}

function openBulkDeleteModal() {
    var checked = Array.from(document.querySelectorAll('.frame-cb:checked')).map(function (cb) { return cb.value; });
    if (checked.length === 0) return;
    document.getElementById('modalTitle').textContent = 'Xoá ' + checked.length + ' frame?';
    document.getElementById('modalDesc').innerHTML =
        'Các frame <strong>' + checked.join(', ') + '</strong> sẽ bị xoá vĩnh viễn khỏi server.';
    _pendingAction = function () {
        var container = document.getElementById('bulkDeleteInputs');
        container.innerHTML = '';
        checked.forEach(function (num) {
            var inp = document.createElement('input');
            inp.type  = 'hidden';
            inp.name  = 'frames[]';
            inp.value = num;
            container.appendChild(inp);
        });
        document.getElementById('bulkDeleteForm').submit();
    };
    openModal();
}

function openModal() {
    document.getElementById('deleteModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('deleteModal').classList.remove('open');
    document.body.style.overflow = '';
    _pendingAction = null;
}

document.getElementById('modalConfirmBtn').addEventListener('click', function () {
    if (_pendingAction) {
        this.disabled = true;
        this.textContent = 'Đang xử lý...';
        _pendingAction();
    }
});

document.getElementById('deleteModal').addEventListener('click', function (e) {
    if (e.target === this) closeModal();
});

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeModal();
});

/* ══════════════════════════════
   BATCH UPLOAD
══════════════════════════════ */
(function () {
    var fileInput  = document.getElementById('fileInput');
    var dropZone   = document.getElementById('dropZone');
    var preview    = document.getElementById('batchPreview');
    var uploadBtn  = document.getElementById('uploadBtn');
    var uploadForm = document.getElementById('uploadForm');
    var formInputs = document.getElementById('formInputs');
    var stagedFiles = [];

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
        fi.type = 'file'; fi.name = 'frames[]'; fi.multiple = true; fi.style.display = 'none';
        fi.files = dt.files;
        formInputs.appendChild(fi);
        uploadBtn.disabled = true;
        uploadBtn.textContent = '⏳ Đang upload...';
        uploadForm.style.display = 'block';
        uploadForm.submit();
    };
})();
</script>
@endpush

@endsection