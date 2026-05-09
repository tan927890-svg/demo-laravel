@extends('layouts.admin')
@section('page-title', 'Thêm xe mới')

@section('topbar-actions')
  <a href="{{ route('admin.cars.index') }}" class="btn btn-sm">← Quay lại</a>
  <button type="submit" form="car-form" class="btn btn-primary btn-sm">💾 Lưu xe</button>
@endsection

@section('content')
<form id="car-form" method="POST" action="{{ route('admin.cars.store') }}" enctype="multipart/form-data">
  @csrf

  @if($errors->any())
    <div class="alert alert-error" style="margin-bottom:16px">
      <ul style="margin:0;padding-left:18px">
        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <div style="display:grid;grid-template-columns:1fr 340px;gap:18px;align-items:start">

    {{-- ════════ LEFT ════════ --}}
    <div style="display:flex;flex-direction:column;gap:16px">

      {{-- ① THÔNG TIN CƠ BẢN --}}
      <div class="card card-pad">
        <div class="section-title">① Thông tin cơ bản</div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Tên xe <span class="req">*</span></label>
            <input class="form-control" name="name" value="{{ old('name') }}" required placeholder="VD: VF 9">
          </div>
          <div class="form-group">
            <label class="form-label">Thương hiệu <span class="req">*</span></label>
            <select class="form-control" name="brand_id" required>
              <option value="">-- Chọn --</option>
              @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                  {{ $brand->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Tagline (hiển thị dưới tên xe ở hero)</label>
            <input class="form-control" name="tagline" value="{{ old('tagline') }}" placeholder="VD: Crossover điện thế hệ mới">
          </div>
          <div class="form-group">
            <label class="form-label">Giá niêm yết (VNĐ) <span class="req">*</span></label>
            <input class="form-control" type="number" name="price_per_day" value="{{ old('price_per_day') }}" required placeholder="VD: 458000000">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Số chỗ ngồi</label>
            <select class="form-control" name="seats">
              @foreach([2,4,5,7,8,9] as $s)
                <option value="{{ $s }}" {{ old('seats',5) == $s ? 'selected':'' }}>{{ $s }} chỗ</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Nhiên liệu</label>
            <select class="form-control" name="fuel_type">
              @foreach(['Xăng','Dầu','Điện','Hybrid'] as $f)
                <option value="{{ $f }}" {{ old('fuel_type','Xăng') == $f ? 'selected':'' }}>{{ $f }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Hộp số</label>
            <select class="form-control" name="transmission">
              @foreach(['Tự động','Sàn','CVT','DCT'] as $t)
                <option value="{{ $t }}" {{ old('transmission','Tự động') == $t ? 'selected':'' }}>{{ $t }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Mô tả ngắn</label>
          <textarea class="form-control" name="description" rows="3" placeholder="Mô tả ngắn gọn…">{{ old('description') }}</textarea>
        </div>
      </div>

      {{-- ② BIẾN THỂ / PHIÊN BẢN --}}
      <div class="card card-pad">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
          <div class="section-title" style="margin-bottom:0">② Biến thể / Phiên bản</div>
          <button type="button" class="btn-add" onclick="addVariant()">+ Thêm phiên bản</button>
        </div>
        <div class="form-hint" style="margin-bottom:12px">Tên phiên bản hiển thị ở cột header bảng thông số kỹ thuật.</div>
        <div id="variants-list">
          <div class="repeater-row" id="variant-0">
            <div class="repeater-header">
              <span class="repeater-num">Phiên bản #1</span>
              <button type="button" class="btn-remove" onclick="removeRow('variant-0')">✕</button>
            </div>
            <div class="form-row" style="margin-bottom:0">
              <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Tên phiên bản <span class="req">*</span></label>
                <input class="form-control" name="variants[0][name]" placeholder="VD: Standard, Plus, Pro…">
              </div>
              <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Giá bán (VNĐ)</label>
                <input class="form-control" type="number" name="variants[0][price]" min="0" placeholder="VD: 458000000">
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- ③ THÔNG SỐ KỸ THUẬT --}}
      <div class="card card-pad">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
          <div class="section-title" style="margin-bottom:0">③ Thông số kỹ thuật</div>
          <button type="button" class="btn-add" onclick="addSpec()">+ Thêm thông số</button>
        </div>
        <div class="form-hint" style="margin-bottom:12px">Nhóm theo danh mục: Động cơ, Kích thước, Pin & Sạc…</div>
        <div id="specs-list">
          <div class="repeater-row" id="spec-0">
            <div class="repeater-header">
              <span class="repeater-num">Thông số #1</span>
              <button type="button" class="btn-remove" onclick="removeRow('spec-0')">✕</button>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Danh mục <span class="req">*</span></label>
                <input class="form-control" name="specs[0][category]" placeholder="VD: Động cơ điện">
              </div>
              <div class="form-group">
                <label class="form-label">Tên thông số <span class="req">*</span></label>
                <input class="form-control" name="specs[0][spec_key]" placeholder="VD: Công suất">
              </div>
              <div class="form-group">
                <label class="form-label">Giá trị <span class="req">*</span></label>
                <input class="form-control" name="specs[0][spec_value]" placeholder="VD: 100 kW">
              </div>
            </div>
            <div class="form-row" style="margin-bottom:0">
              <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Thứ tự danh mục</label>
                <input class="form-control" type="number" name="specs[0][category_order]" value="0" min="0" style="width:80px">
              </div>
              <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Thứ tự trong danh mục</label>
                <input class="form-control" type="number" name="specs[0][sort_order]" value="0" min="0" style="width:80px">
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- ④ TÍNH NĂNG NỔI BẬT --}}
      <div class="card card-pad">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
          <div class="section-title" style="margin-bottom:0">④ Tính năng nổi bật</div>
          <button type="button" class="btn-add" onclick="addFeature()">+ Thêm tính năng</button>
        </div>
        <div class="form-hint" style="margin-bottom:12px">
          Hiển thị 2 slide đầu trên trang chi tiết (Ngoại thất / Nội thất). Mỗi tính năng nên có ảnh minh họa.
        </div>
        <div id="features-list">
          <div class="repeater-row" id="feature-0">
            <div class="repeater-header">
              <span class="repeater-num">Tính năng #1</span>
              <button type="button" class="btn-remove" onclick="removeRow('feature-0')">✕</button>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Tiêu đề <span class="req">*</span></label>
                <input class="form-control" name="features[0][title]" placeholder="VD: Ngoại thất VF 9">
              </div>
            </div>
            <div class="form-group">
              <label class="form-label">Mô tả</label>
              <textarea class="form-control" name="features[0][description]" rows="2" placeholder="Mô tả tính năng…"></textarea>
            </div>
            <div class="form-row" style="margin-bottom:0">
              <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Ảnh chính <span class="req">*</span></label>
                <input type="file" class="form-control" name="feature_images[0]" accept="image/*"
                       onchange="previewFeatureImg(this, 'fp0')">
                <div id="fp0" class="img-thumb-wrap" style="display:none;margin-top:8px">
                  <img style="height:80px;border-radius:6px;object-fit:cover;">
                </div>
                <input type="hidden" name="features[0][image]" id="fi0">
                <div class="form-hint">Ảnh hiển thị toàn bộ slide bên phải.</div>
              </div>
              <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Ảnh phụ (tùy chọn)</label>
                <input type="file" class="form-control" name="feature_images2[0]" accept="image/*"
                       onchange="previewFeatureImg(this, 'fp2-0')">
                <div id="fp2-0" class="img-thumb-wrap" style="display:none;margin-top:8px">
                  <img style="height:80px;border-radius:6px;object-fit:cover;">
                </div>
                <input type="hidden" name="features[0][image2]" id="fi2-0">
                <div class="form-hint">Hiển thị trong modal khi bấm "Xem chi tiết".</div>
              </div>
            </div>
            <input type="hidden" name="features[0][sort_order]" value="0">
          </div>
        </div>
      </div>

      {{-- ⑤ THƯ VIỆN ẢNH --}}
      <div class="card card-pad">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
          <div class="section-title" style="margin-bottom:0">⑤ Thư viện ảnh</div>
          <button type="button" class="btn-add" onclick="addGallery()">+ Thêm ảnh</button>
        </div>
        <div class="form-hint" style="margin-bottom:12px">Ảnh hiển thị trong phần Thư viện ảnh cuối trang chi tiết.</div>
        <div id="gallery-list">
          <div class="repeater-row" id="gallery-0">
            <div class="repeater-header">
              <span class="repeater-num">Ảnh #1</span>
              <button type="button" class="btn-remove" onclick="removeRow('gallery-0')">✕</button>
            </div>
            <div class="form-row" style="margin-bottom:8px;align-items:flex-end">
              <div class="form-group" style="margin-bottom:0;flex:2">
                <label class="form-label">URL ảnh</label>
                <input class="form-control" name="galleries[0][file_path]" id="gpath0"
                       placeholder="images/car/..."
                       oninput="previewFromUrl(this,'gp0')">
              </div>
              <div class="form-group" style="margin-bottom:0;flex:1">
                <label class="form-label">Chú thích</label>
                <input class="form-control" name="galleries[0][caption]" placeholder="Chú thích…">
              </div>
            </div>
            <div class="upload-divider">— hoặc upload file mới —</div>
            <input type="file" class="form-control" name="gallery_files[0]" accept="image/*"
                   onchange="previewGalleryImg(this,'gp0','gpath0')">
            <div class="form-hint" style="margin-top:4px">Upload sẽ lưu vào public/images/car/</div>
            <div id="gp0" class="img-thumb-wrap" style="display:none;margin-top:8px">
              <img style="height:80px;border-radius:6px;object-fit:cover;">
            </div>
            <input type="hidden" name="galleries[0][type]" value="image">
            <input type="hidden" name="galleries[0][sort_order]" value="0">
          </div>
        </div>
      </div>

      {{-- ⑥ MÀU SẮC --}}
      <div class="card card-pad">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
          <div class="section-title" style="margin-bottom:0">⑥ Màu sắc xe</div>
          <button type="button" class="btn-add" onclick="addColor()">+ Thêm màu</button>
        </div>
        <div class="form-hint" style="margin-bottom:12px">Ảnh theo màu hiển thị trong color picker ở trang chi tiết.</div>
        <div id="colors-list">
          <div class="repeater-row" id="color-0">
            <div class="repeater-header">
              <span class="repeater-num">Màu #1</span>
              <button type="button" class="btn-remove" onclick="removeRow('color-0')">✕</button>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Tên màu <span class="req">*</span></label>
                <input class="form-control" name="colors[0][name]" placeholder="VD: Đỏ Fiery">
              </div>
              <div class="form-group">
                <label class="form-label">Mã màu HEX</label>
                <div style="display:flex;gap:8px;align-items:center">
                  <input type="color" value="#c62828"
                         oninput="syncHex(this,'hex0')"
                         style="width:40px;height:36px;border:1px solid var(--border);border-radius:6px;cursor:pointer;padding:2px;flex-shrink:0">
                  <input class="form-control" id="hex0" name="colors[0][hex_code]"
                         placeholder="#c62828" style="flex:1">
                </div>
              </div>
            </div>
            <div class="form-row" style="margin-bottom:0;align-items:flex-start">
              <div class="form-group" style="margin-bottom:0;flex:2">
                <label class="form-label">URL ảnh xe màu này</label>
                <input class="form-control" name="colors[0][image]" id="cimg0"
                       placeholder="images/car/..."
                       oninput="previewFromUrl(this,'cp0')">
                <div class="upload-divider">— hoặc upload file mới —</div>
                <input type="file" class="form-control" name="color_images[0]" accept="image/*"
                       onchange="previewColorImg(this,'cp0','cimg0')">
                <div class="form-hint" style="margin-top:4px">Upload sẽ lưu vào public/images/car/ · .png nền trong suốt tốt hơn</div>
                <div id="cp0" class="img-thumb-wrap" style="display:none;margin-top:8px">
                  <img style="height:80px;border-radius:6px;object-fit:cover;">
                </div>
              </div>
              <div class="form-group" style="margin-bottom:0;flex:1">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;margin-bottom:4px">
                  <input type="checkbox" name="colors[0][is_default]" value="1"> Màu mặc định
                </label>
                <input type="hidden" name="colors[0][sort_order]" value="0">
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>{{-- end LEFT --}}

    {{-- ════════ RIGHT SIDEBAR ════════ --}}
    <div style="display:flex;flex-direction:column;gap:16px;position:sticky;top:16px">

      {{-- TRẠNG THÁI --}}
      <div class="card card-pad">
        <div class="section-title">Trạng thái</div>
        <div class="form-group">
          <label class="form-label">Tình trạng hàng</label>
          <select class="form-control" name="status">
            <option value="available"    {{ old('status','available')=='available'   ?'selected':'' }}>✅ Còn hàng</option>
            <option value="out_of_stock" {{ old('status')=='out_of_stock'?'selected':'' }}>❌ Hết hàng</option>
            <option value="coming_soon"  {{ old('status')=='coming_soon' ?'selected':'' }}>🔜 Sắp ra mắt</option>
          </select>
        </div>
        <div class="form-group">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px">
            <input type="checkbox" name="is_available" value="1" {{ old('is_available',1) ? 'checked':'' }}>
            Hiển thị trên trang web
          </label>
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px">
            <input type="checkbox" name="is_featured" value="1" id="cb_featured" {{ old('is_featured') ? 'checked':'' }}>
            Hiển thị trong "Xe Nổi Bật"
          </label>
        </div>
        <div id="featured-fields" style="{{ old('is_featured') ? '':'display:none;' }}margin-top:12px;padding-top:12px;border-top:1px solid var(--border)">
          <div class="form-group">
            <label class="form-label">Badge label</label>
            <input class="form-control" name="badge_label" value="{{ old('badge_label') }}" placeholder="VD: Flagship, Bán chạy…">
          </div>
          <div class="form-group">
            <label class="form-label">Prefix ảnh 360°</label>
            <input class="form-control" name="image_360_prefix" value="{{ old('image_360_prefix') }}" placeholder="VD: images/vinfast/vf9-do">
            <div class="form-hint">Prefix + số thứ tự + .png (VD: images/vinfast/vf9-do1.png … 8.png)</div>
          </div>
          <div class="form-group" style="margin-bottom:0">
            <label class="form-label">Số frame 360°</label>
            <input class="form-control" type="number" name="image_360_frames" value="{{ old('image_360_frames',8) }}" min="1" max="72" style="width:90px">
          </div>
        </div>
      </div>

      {{-- ẢNH ĐẠI DIỆN --}}
      <div class="card card-pad">
        <div class="section-title">Ảnh đại diện</div>
        <div class="form-hint" style="margin-bottom:10px">Hiển thị trong danh sách xe và phần Giá & Hạng xe.</div>
        <div id="main-preview-wrap" style="display:none;margin-bottom:10px">
          <img id="main-img-preview" style="width:100%;height:150px;object-fit:contain;border-radius:8px;border:1px solid var(--border);background:#f5f5f5">
        </div>
        <input type="file" class="form-control" name="image_file" id="img-file-input" accept="image/*">
        <input type="hidden" name="image_url" id="final-image-url" value="{{ old('image_url') }}">
        <div class="form-hint" style="margin-top:6px">Ảnh .png nền trong suốt cho đẹp hơn.</div>
      </div>

      {{-- ẢNH HERO --}}
      <div class="card card-pad">
        <div class="section-title">Ảnh Hero (banner đầu trang)</div>
        <div class="form-hint" style="margin-bottom:10px">Ảnh nền lớn hiển thị ở section Hero và Thông tin chi tiết.</div>
        <div id="hero-preview-wrap" style="display:none;margin-bottom:10px">
          <img id="hero-img-preview" style="width:100%;height:100px;object-fit:cover;border-radius:8px;border:1px solid var(--border)">
        </div>
        <input type="file" class="form-control" name="hero_image_file" id="hero-file-input" accept="image/*">
        <input type="hidden" name="hero_image" id="final-hero-image" value="{{ old('hero_image') }}">
      </div>

      {{-- NÚT LƯU --}}
      <div class="card card-pad" style="background:var(--primary,#1d4ed8);border:none;padding:14px">
        <button type="submit" class="btn"
          style="width:100%;background:#fff;color:#1d4ed8;font-weight:700;font-size:15px;padding:12px;border:none;border-radius:6px;cursor:pointer">
          💾 Lưu xe mới
        </button>
      </div>

    </div>{{-- end RIGHT --}}
  </div>
</form>

{{-- ═══════════ STYLES ═══════════ --}}
<style>
.section-title {
  font-size: 11px; font-weight: 700; margin-bottom: 14px;
  color: var(--text-muted, #6b7280); letter-spacing: .7px; text-transform: uppercase;
}
.req { color: #ef4444; }
.repeater-row {
  border: 1px solid var(--border, #e5e7eb); border-radius: 8px;
  padding: 14px; margin-bottom: 10px; background: var(--bg-subtle, #f9fafb);
}
.repeater-header {
  display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;
}
.repeater-num { font-size: 11px; font-weight: 700; color: var(--text-muted,#6b7280); text-transform: uppercase; letter-spacing: .4px; }
.btn-remove {
  background: #fee2e2; color: #dc2626; border: none; border-radius: 5px;
  width: 26px; height: 26px; cursor: pointer; font-size: 12px; font-weight: 700;
  display: flex; align-items: center; justify-content: center;
}
.btn-remove:hover { background: #fca5a5; }
.btn-add {
  background: transparent; border: 1px solid var(--border,#e5e7eb);
  color: var(--text,#374151); border-radius: 6px; padding: 5px 12px;
  font-size: 12px; font-weight: 600; cursor: pointer;
}
.btn-add:hover { background: var(--bg-subtle,#f3f4f6); }
.img-thumb-wrap img { max-width: 100%; display: block; }
.upload-divider {
  font-size: 11px; color: var(--text-muted,#9ca3af);
  text-align: center; margin: 8px 0; letter-spacing: .3px;
}
</style>

{{-- ═══════════ SCRIPTS ═══════════ --}}
<script>
// ─── Ảnh đại diện ────────────────────────────────────
document.getElementById('img-file-input').addEventListener('change', function() {
  if (this.files && this.files[0]) {
    document.getElementById('main-img-preview').src = URL.createObjectURL(this.files[0]);
    document.getElementById('main-preview-wrap').style.display = '';
  }
});

// ─── Ảnh hero ────────────────────────────────────────
document.getElementById('hero-file-input').addEventListener('change', function() {
  if (this.files && this.files[0]) {
    document.getElementById('hero-img-preview').src = URL.createObjectURL(this.files[0]);
    document.getElementById('hero-preview-wrap').style.display = '';
  }
});

// ─── Is Featured toggle ──────────────────────────────
document.getElementById('cb_featured').addEventListener('change', function() {
  document.getElementById('featured-fields').style.display = this.checked ? '' : 'none';
});

// ─── Preview từ URL text input ────────────────────────
function previewFromUrl(input, wrapId) {
  const val = input.value.trim();
  const wrap = document.getElementById(wrapId);
  if (val) {
    wrap.querySelector('img').src = val.startsWith('http') ? val : '/' + val;
    wrap.style.display = '';
  } else {
    wrap.style.display = 'none';
  }
}

// ─── Preview tính năng ───────────────────────────────
function previewFeatureImg(input, wrapId) {
  if (input.files && input.files[0]) {
    const wrap = document.getElementById(wrapId);
    wrap.querySelector('img').src = URL.createObjectURL(input.files[0]);
    wrap.style.display = '';
  }
}

// ─── Preview gallery (URL input xóa khi chọn file) ───
function previewGalleryImg(input, wrapId, urlInputId) {
  if (input.files && input.files[0]) {
    const wrap = document.getElementById(wrapId);
    wrap.querySelector('img').src = URL.createObjectURL(input.files[0]);
    wrap.style.display = '';
    if (urlInputId) document.getElementById(urlInputId).value = '';
  }
}

// ─── Preview màu sắc (URL input xóa khi chọn file) ───
function previewColorImg(input, wrapId, urlInputId) {
  if (input.files && input.files[0]) {
    const wrap = document.getElementById(wrapId);
    wrap.querySelector('img').src = URL.createObjectURL(input.files[0]);
    wrap.style.display = '';
    if (urlInputId) document.getElementById(urlInputId).value = '';
  }
}

// ─── Sync color picker ───────────────────────────────
function syncHex(picker, hexId) {
  document.getElementById(hexId).value = picker.value;
}

// ─── Remove row ──────────────────────────────────────
function removeRow(id) {
  const el = document.getElementById(id);
  if (el) el.remove();
}

// ─── Repeater: BIẾN THỂ ──────────────────────────────
let variantIdx = 1;
function addVariant() {
  const i = variantIdx++;
  document.getElementById('variants-list').insertAdjacentHTML('beforeend', `
  <div class="repeater-row" id="variant-${i}">
    <div class="repeater-header">
      <span class="repeater-num">Phiên bản #${i+1}</span>
      <button type="button" class="btn-remove" onclick="removeRow('variant-${i}')">✕</button>
    </div>
    <div class="form-row" style="margin-bottom:0">
      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Tên phiên bản <span class="req">*</span></label>
        <input class="form-control" name="variants[${i}][name]" placeholder="VD: Plus, Pro…">
      </div>
      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Giá bán (VNĐ)</label>
        <input class="form-control" type="number" name="variants[${i}][price]" min="0">
      </div>
    </div>
    <input type="hidden" name="variants[${i}][sort_order]" value="${i}">
  </div>`);
}

// ─── Repeater: THÔNG SỐ ──────────────────────────────
let specIdx = 1;
function addSpec() {
  const i = specIdx++;
  document.getElementById('specs-list').insertAdjacentHTML('beforeend', `
  <div class="repeater-row" id="spec-${i}">
    <div class="repeater-header">
      <span class="repeater-num">Thông số #${i+1}</span>
      <button type="button" class="btn-remove" onclick="removeRow('spec-${i}')">✕</button>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Danh mục <span class="req">*</span></label>
        <input class="form-control" name="specs[${i}][category]" placeholder="VD: Kích thước">
      </div>
      <div class="form-group">
        <label class="form-label">Tên thông số <span class="req">*</span></label>
        <input class="form-control" name="specs[${i}][spec_key]" placeholder="VD: Chiều dài">
      </div>
      <div class="form-group">
        <label class="form-label">Giá trị <span class="req">*</span></label>
        <input class="form-control" name="specs[${i}][spec_value]" placeholder="VD: 4626 mm">
      </div>
    </div>
    <div class="form-row" style="margin-bottom:0">
      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Thứ tự danh mục</label>
        <input class="form-control" type="number" name="specs[${i}][category_order]" value="0" min="0" style="width:80px">
      </div>
      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Thứ tự trong danh mục</label>
        <input class="form-control" type="number" name="specs[${i}][sort_order]" value="${i}" min="0" style="width:80px">
      </div>
    </div>
  </div>`);
}

// ─── Repeater: TÍNH NĂNG ─────────────────────────────
let featureIdx = 1;
function addFeature() {
  const i = featureIdx++;
  document.getElementById('features-list').insertAdjacentHTML('beforeend', `
  <div class="repeater-row" id="feature-${i}">
    <div class="repeater-header">
      <span class="repeater-num">Tính năng #${i+1}</span>
      <button type="button" class="btn-remove" onclick="removeRow('feature-${i}')">✕</button>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Tiêu đề <span class="req">*</span></label>
        <input class="form-control" name="features[${i}][title]" placeholder="VD: Nội thất VF 9">
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Mô tả</label>
      <textarea class="form-control" name="features[${i}][description]" rows="2" placeholder="Mô tả…"></textarea>
    </div>
    <div class="form-row" style="margin-bottom:0">
      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Ảnh chính <span class="req">*</span></label>
        <input type="file" class="form-control" name="feature_images[${i}]" accept="image/*"
               onchange="previewFeatureImg(this,'fp${i}')">
        <div id="fp${i}" class="img-thumb-wrap" style="display:none;margin-top:8px">
          <img style="height:80px;border-radius:6px;object-fit:cover;">
        </div>
        <input type="hidden" name="features[${i}][image]" id="fi${i}">
      </div>
      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Ảnh phụ</label>
        <input type="file" class="form-control" name="feature_images2[${i}]" accept="image/*"
               onchange="previewFeatureImg(this,'fp2${i}')">
        <div id="fp2${i}" class="img-thumb-wrap" style="display:none;margin-top:8px">
          <img style="height:80px;border-radius:6px;object-fit:cover;">
        </div>
        <input type="hidden" name="features[${i}][image2]" id="fi2${i}">
      </div>
    </div>
    <input type="hidden" name="features[${i}][sort_order]" value="${i}">
  </div>`);
}

// ─── Repeater: GALLERY ───────────────────────────────
let galleryIdx = 1;
function addGallery() {
  const i = galleryIdx++;
  document.getElementById('gallery-list').insertAdjacentHTML('beforeend', `
  <div class="repeater-row" id="gallery-${i}">
    <div class="repeater-header">
      <span class="repeater-num">Ảnh #${i+1}</span>
      <button type="button" class="btn-remove" onclick="removeRow('gallery-${i}')">✕</button>
    </div>
    <div class="form-row" style="margin-bottom:8px;align-items:flex-end">
      <div class="form-group" style="margin-bottom:0;flex:2">
        <label class="form-label">URL ảnh</label>
        <input class="form-control" name="galleries[${i}][file_path]" id="gpath${i}"
               placeholder="images/car/..."
               oninput="previewFromUrl(this,'gp${i}')">
      </div>
      <div class="form-group" style="margin-bottom:0;flex:1">
        <label class="form-label">Chú thích</label>
        <input class="form-control" name="galleries[${i}][caption]" placeholder="Chú thích…">
      </div>
    </div>
    <div class="upload-divider">— hoặc upload file mới —</div>
    <input type="file" class="form-control" name="gallery_files[${i}]" accept="image/*"
           onchange="previewGalleryImg(this,'gp${i}','gpath${i}')">
    <div class="form-hint" style="margin-top:4px">Upload sẽ lưu vào public/images/car/</div>
    <div id="gp${i}" class="img-thumb-wrap" style="display:none;margin-top:8px">
      <img style="height:80px;border-radius:6px;object-fit:cover;">
    </div>
    <input type="hidden" name="galleries[${i}][type]" value="image">
    <input type="hidden" name="galleries[${i}][sort_order]" value="${i}">
  </div>`);
}

// ─── Repeater: MÀU SẮC ──────────────────────────────
let colorIdx = 1;
function addColor() {
  const i = colorIdx++;
  document.getElementById('colors-list').insertAdjacentHTML('beforeend', `
  <div class="repeater-row" id="color-${i}">
    <div class="repeater-header">
      <span class="repeater-num">Màu #${i+1}</span>
      <button type="button" class="btn-remove" onclick="removeRow('color-${i}')">✕</button>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Tên màu <span class="req">*</span></label>
        <input class="form-control" name="colors[${i}][name]" placeholder="VD: Trắng, Đen…">
      </div>
      <div class="form-group">
        <label class="form-label">Mã HEX</label>
        <div style="display:flex;gap:8px;align-items:center">
          <input type="color" value="#000000" oninput="syncHex(this,'hex${i}')"
                 style="width:40px;height:36px;border:1px solid var(--border);border-radius:6px;cursor:pointer;padding:2px;flex-shrink:0">
          <input class="form-control" id="hex${i}" name="colors[${i}][hex_code]" placeholder="#000000" style="flex:1">
        </div>
      </div>
    </div>
    <div class="form-row" style="margin-bottom:0;align-items:flex-start">
      <div class="form-group" style="margin-bottom:0;flex:2">
        <label class="form-label">URL ảnh xe màu này</label>
        <input class="form-control" name="colors[${i}][image]" id="cimg${i}"
               placeholder="images/car/..."
               oninput="previewFromUrl(this,'cp${i}')">
        <div class="upload-divider">— hoặc upload file mới —</div>
        <input type="file" class="form-control" name="color_images[${i}]" accept="image/*"
               onchange="previewColorImg(this,'cp${i}','cimg${i}')">
        <div class="form-hint" style="margin-top:4px">Upload sẽ lưu vào public/images/car/ · .png nền trong suốt tốt hơn</div>
        <div id="cp${i}" class="img-thumb-wrap" style="display:none;margin-top:8px">
          <img style="height:80px;border-radius:6px;object-fit:cover;">
        </div>
      </div>
      <div class="form-group" style="margin-bottom:0;flex:1">
        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px">
          <input type="checkbox" name="colors[${i}][is_default]" value="1"> Màu mặc định
        </label>
      </div>
    </div>
    <input type="hidden" name="colors[${i}][sort_order]" value="${i}">
  </div>`);
}
</script>
@endsection