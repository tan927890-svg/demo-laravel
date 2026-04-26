@extends('layouts.admin')

@section('page-title', 'Sửa xe: ' . $car->name)

@section('topbar-actions')
  <a href="{{ route('admin.cars.index') }}" class="btn btn-sm">← Quay lại</a>
@endsection

@section('content')
<form method="POST"
      action="{{ route('admin.cars.update', $car) }}"
      enctype="multipart/form-data"
      id="car-form">
  @csrf @method('PUT')

  @if($errors->any())
    <div class="alert alert-error">
      <ul style="margin:0;padding-left:18px">
        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  {{-- Hidden: lưu gallery_id được chọn làm ảnh bìa --}}
  <input type="hidden" name="cover_gallery_id" id="cover_gallery_id"
         value="{{ $car->galleries->where('type','image')->sortBy('sort_order')->first()?->id }}">

  <div style="display:grid;grid-template-columns:1fr 340px;gap:18px;align-items:start">

    {{-- ══ LEFT ══ --}}
    <div style="display:flex;flex-direction:column;gap:14px">

      {{-- THÔNG TIN CƠ BẢN --}}
      <div class="card card-pad">
        <div style="font-size:13px;font-weight:600;margin-bottom:14px;color:var(--text-muted);letter-spacing:.3px">THÔNG TIN CƠ BẢN</div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Tên xe <span style="color:red">*</span></label>
            <input class="form-control" name="name" value="{{ old('name', $car->name) }}" required placeholder="VD: Camry 2.5Q">
          </div>
          <div class="form-group">
            <label class="form-label">Thương hiệu <span style="color:red">*</span></label>
            <select class="form-control" name="brand_id" required>
              <option value="">-- Chọn thương hiệu --</option>
              @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ old('brand_id', $car->brand_id) == $brand->id ? 'selected' : '' }}>
                  {{ $brand->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Giá bán (VNĐ) <span style="color:red">*</span></label>
            <input class="form-control" type="number" name="price_per_day" value="{{ old('price_per_day', $car->price_per_day) }}" required placeholder="VD: 1235000000">
          </div>
          <div class="form-group">
            <label class="form-label">Năm sản xuất</label>
            <input class="form-control" type="number" name="year" value="{{ old('year', $car->year) }}" min="2000" max="{{ date('Y')+2 }}">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Số chỗ ngồi</label>
            <select class="form-control" name="seats">
              @foreach([2,4,5,7,8,9] as $s)
                <option value="{{ $s }}" {{ old('seats', $car->seats) == $s ? 'selected' : '' }}>{{ $s }} chỗ</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Loại nhiên liệu</label>
            <select class="form-control" name="fuel_type">
              @foreach(['Xăng','Dầu','Điện','Hybrid'] as $f)
                <option value="{{ $f }}" {{ old('fuel_type', $car->fuel_type) == $f ? 'selected' : '' }}>{{ $f }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Mô tả ngắn</label>
          <textarea class="form-control" name="description" rows="3" placeholder="Mô tả ngắn gọn về xe...">{{ old('description', $car->description) }}</textarea>
        </div>

        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Nội dung chi tiết</label>
          <textarea name="content" id="car-content-editor" style="display:none">{{ old('content', $car->content) }}</textarea>
          <div id="car-tinymce-wrap" style="border:1px solid var(--border,#e2e8f0);border-radius:6px;overflow:hidden;min-height:360px;"></div>
        </div>
      </div>

      {{-- THÔNG SỐ KỸ THUẬT --}}
      <div class="card card-pad">
        <div style="font-size:13px;font-weight:600;margin-bottom:14px;color:var(--text-muted);letter-spacing:.3px">THÔNG SỐ KỸ THUẬT</div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Động cơ</label>
            <input class="form-control" name="engine" value="{{ old('engine', $car->engine) }}" placeholder="VD: 2.5L 4 xi-lanh">
          </div>
          <div class="form-group">
            <label class="form-label">Hộp số</label>
            <select class="form-control" name="transmission">
              @foreach(['Tự động','Sàn','CVT','DCT'] as $t)
                <option value="{{ $t }}" {{ old('transmission', $car->transmission) == $t ? 'selected' : '' }}>{{ $t }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Công suất (HP)</label>
            <input class="form-control" name="horsepower" type="number" value="{{ old('horsepower', $car->horsepower) }}" placeholder="VD: 182">
          </div>
          <div class="form-group">
            <label class="form-label">Mức tiêu thụ (L/100km)</label>
            <input class="form-control" name="fuel_consumption" value="{{ old('fuel_consumption', $car->fuel_consumption) }}" placeholder="VD: 7.2">
          </div>
        </div>
      </div>

    </div>

    {{-- ══ RIGHT ══ --}}
    <div style="display:flex;flex-direction:column;gap:14px">

      {{-- TRẠNG THÁI --}}
      <div class="card card-pad">
        <div style="font-size:13px;font-weight:600;margin-bottom:14px;color:var(--text-muted);letter-spacing:.3px">TRẠNG THÁI</div>
        <div class="form-group">
          <label class="form-label">Trạng thái hàng</label>
          <select class="form-control" name="status">
            <option value="available"    {{ old('status', $car->status) == 'available'    ? 'selected' : '' }}>Còn hàng</option>
            <option value="out_of_stock" {{ old('status', $car->status) == 'out_of_stock' ? 'selected' : '' }}>Hết hàng</option>
            <option value="coming_soon"  {{ old('status', $car->status) == 'coming_soon'  ? 'selected' : '' }}>Sắp ra mắt</option>
          </select>
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px">
            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $car->is_featured) ? 'checked' : '' }}>
            Xe nổi bật (hiển thị trang chủ)
          </label>
        </div>
      </div>

      {{-- ẢNH ĐẠI DIỆN --}}
      @php $coverGallery = $car->galleries->where('type','image')->sortBy('sort_order')->first(); @endphp
      <div class="card card-pad">
        <div class="form-label" style="margin-bottom:8px;font-size:13px;font-weight:600;color:var(--text-muted);letter-spacing:.3px">ẢNH ĐẠI DIỆN</div>

        <div id="thumbnail-preview" style="{{ $coverGallery ? '' : 'display:none;' }}margin-bottom:10px">
          <img id="preview-img"
               src="{{ $coverGallery ? Storage::disk('public')->url($coverGallery->file_path) : '' }}"
               style="width:100%;height:160px;object-fit:cover;border-radius:8px;border:1px solid var(--border,#e2e8f0)">
          <button type="button" onclick="clearThumbnail()"
                  style="margin-top:6px;width:100%;background:transparent;border:1px solid #fca5a5;padding:6px;font-size:12px;cursor:pointer;border-radius:6px;color:#e53e3e">
            × Xóa ảnh bìa
          </button>
        </div>

        <div class="form-group" style="margin-bottom:8px">
          <label class="form-label" style="font-size:12px;color:#888">Upload ảnh mới</label>
          <input class="form-control" type="file" name="images[]" multiple accept="image/*"
                 id="thumbnail-upload" onchange="previewUpload(this)">
          <div class="form-hint">Chọn nhiều ảnh. Ảnh đầu tiên sẽ là ảnh chính.</div>
        </div>

        <div style="text-align:center;font-size:12px;color:#aaa;margin-bottom:8px">— hoặc —</div>

        <button type="button" onclick="openMediaModal()"
                style="width:100%;background:var(--primary,#2563eb);color:#fff;border:none;padding:9px;font-size:13px;border-radius:6px;cursor:pointer">
          🖼 Chọn từ thư viện ảnh
        </button>
      </div>

      {{-- DANH SÁCH ẢNH ĐÃ UPLOAD --}}
      @if($car->galleries->where('type','image')->count())
      <div class="card card-pad">
        <div style="font-size:13px;font-weight:600;margin-bottom:10px;color:var(--text-muted);letter-spacing:.3px">
          ẢNH ĐÃ UPLOAD ({{ $car->galleries->where('type','image')->count() }})
        </div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:6px">
          @foreach($car->galleries->where('type','image')->sortBy('sort_order') as $g)
          <div style="position:relative" id="gallery-item-{{ $g->id }}">
            <img src="{{ Storage::disk('public')->url($g->file_path) }}"
                 style="width:100%;height:70px;object-fit:cover;border-radius:6px;border:2px solid {{ $g->sort_order == 0 ? '#2563eb' : 'var(--border,#e2e8f0)' }}">
            @if($g->sort_order == 0)
              <span style="position:absolute;top:3px;left:3px;background:#2563eb;color:#fff;font-size:9px;padding:1px 5px;border-radius:3px;font-weight:600">BÌA</span>
            @endif
            <button type="button" onclick="deleteGallery({{ $g->id }})"
                    style="position:absolute;top:3px;right:3px;background:rgba(0,0,0,.55);border:none;color:#fff;border-radius:50%;width:20px;height:20px;cursor:pointer;font-size:13px;display:flex;align-items:center;justify-content:center;padding:0;line-height:1">
              ×
            </button>
          </div>
          @endforeach
        </div>
      </div>
      @endif

      {{-- SEO --}}
      <div class="card card-pad">
        <div style="font-size:13px;font-weight:600;margin-bottom:14px;color:var(--text-muted);letter-spacing:.3px">SEO</div>
        <div class="form-group">
          <label class="form-label">Slug URL</label>
          <input class="form-control" name="slug" value="{{ old('slug', $car->slug) }}" placeholder="ten-xe-hang-nam">
          <div class="form-hint">Để trống sẽ tự tạo từ tên xe</div>
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Meta description</label>
          <textarea class="form-control" name="meta_description" rows="2" placeholder="Mô tả hiển thị trên Google...">{{ old('meta_description', $car->meta_description) }}</textarea>
        </div>
      </div>

      <div style="display:flex;gap:8px">
        <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center">Cập nhật xe</button>
        <a href="{{ route('admin.cars.index') }}" class="btn" style="flex:1;justify-content:center">Hủy</a>
      </div>

    </div>
  </div>
</form>

{{-- ══ MEDIA MODAL ══ --}}
<div id="media-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.6);padding:40px 20px;overflow-y:auto">
  <div style="background:#fff;border-radius:12px;max-width:960px;margin:0 auto;overflow:hidden">

    <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid #eee">
      <div style="font-weight:700;font-size:16px">Thư viện ảnh xe</div>
      <button type="button" onclick="closeMediaModal()" style="background:none;border:none;font-size:22px;cursor:pointer;color:#888">✕</button>
    </div>

    <div style="padding:12px 20px;border-bottom:1px solid #eee;display:flex;gap:10px;align-items:center">
      <input type="text" id="media-search" placeholder="🔍 Tìm kiếm ảnh..."
             oninput="filterMedia(this.value)"
             style="flex:1;border:1px solid #ddd;border-radius:6px;padding:8px 12px;font-size:13px;outline:none">
      <input type="file" id="modal-upload-input" accept="image/*" style="display:none">
      <button type="button" id="modal-upload-btn" onclick="uploadFromModal()"
              style="background:#2563eb;color:#fff;border:none;padding:8px 16px;border-radius:6px;font-size:13px;cursor:pointer;white-space:nowrap">
        ⬆ Upload ảnh mới
      </button>
    </div>

    <div id="media-grid"
         style="display:grid;grid-template-columns:repeat(auto-fill,minmax(130px,1fr));gap:10px;padding:16px 20px;max-height:500px;overflow-y:auto">
      <div style="text-align:center;color:#aaa;grid-column:1/-1;padding:40px">Đang tải...</div>
    </div>

    <div style="padding:14px 20px;border-top:1px solid #eee;display:flex;justify-content:space-between;align-items:center">
      <span style="font-size:12px;color:#aaa">Click vào ảnh để chọn làm ảnh bìa</span>
      <button type="button" onclick="closeMediaModal()"
              style="background:#f3f4f6;border:1px solid #ddd;padding:8px 20px;border-radius:6px;cursor:pointer;font-size:13px">Đóng</button>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
const BASE_URL = '{{ url('/') }}';
const CAR_ID   = {{ $car->id }};
let allImages    = [];
let editorMediaCb = null;

// ══ TINYMCE ══════════════════════════════════════════════════
tinymce.init({
  selector: '#car-tinymce-wrap',
  plugins: ['advlist','autolink','lists','link','image','charmap','preview','searchreplace',
            'visualblocks','code','fullscreen','insertdatetime','media','table','help','wordcount'],
  toolbar: 'undo redo | blocks | bold italic underline strikethrough | ' +
           'forecolor backcolor | alignleft aligncenter alignright alignjustify | ' +
           'bullist numlist outdent indent | link image media table | ' +
           'code fullscreen | removeformat help',
  toolbar_mode: 'sliding',
  menubar: 'file edit view insert format tools table help',
  height: 420,
  skin: 'oxide', content_css: 'default',
  promotion: false, branding: false, resize: true,

  setup(editor) {
    const ta = document.getElementById('car-content-editor');
    editor.on('init', () => editor.setContent(ta.value || ''));
    editor.on('change input keyup', () => { ta.value = editor.getContent(); });
  },

  images_upload_handler(blobInfo) {
    return new Promise((resolve, reject) => {
      const fd = new FormData();
      fd.append('file', blobInfo.blob(), blobInfo.filename());
      fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
      fd.append('car_id', CAR_ID);
      fetch('{{ route("admin.media.upload") }}', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(d => d.location ? resolve(d.location) : reject('Upload thất bại'))
        .catch(() => reject('Lỗi kết nối'));
    });
  },

  file_picker_types: 'image',
  file_picker_callback(cb) {
    editorMediaCb = cb;
    openMediaModal();
  },
});

document.getElementById('car-form').addEventListener('submit', () => {
  const ed = tinymce.activeEditor;
  if (ed) document.getElementById('car-content-editor').value = ed.getContent();
});

// ══ MEDIA MODAL ══════════════════════════════════════════════
function openMediaModal() {
  document.getElementById('media-modal').style.display = 'block';
  if (!allImages.length) loadImages(); else renderGrid(allImages);
}
function closeMediaModal() {
  document.getElementById('media-modal').style.display = 'none';
  editorMediaCb = null;
}

function loadImages() {
  document.getElementById('media-grid').innerHTML =
    '<div style="color:#aaa;grid-column:1/-1;text-align:center;padding:40px">Đang tải...</div>';

  fetch(`{{ route("admin.media.images") }}?car_id=${CAR_ID}`)
    .then(r => r.json())
    .then(imgs => {
      allImages = imgs.map(img => ({
        id:       img.id,
        url:      img.url,
        path:     img.path,
        filename: img.url.split('/').pop(),
      }));
      renderGrid(allImages);
    })
    .catch(() => {
      document.getElementById('media-grid').innerHTML =
        '<div style="color:#e00;grid-column:1/-1;text-align:center;padding:40px">Không thể tải ảnh.</div>';
    });
}

function renderGrid(images) {
  const grid = document.getElementById('media-grid');
  if (!images.length) {
    grid.innerHTML = '<div style="color:#aaa;grid-column:1/-1;text-align:center;padding:40px">Chưa có ảnh nào. Hãy upload ảnh trước.</div>';
    return;
  }
  grid.innerHTML = images.map(img => `
    <div onclick="selectMediaImage(${img.id}, '${img.url}', '${img.filename}')"
         style="cursor:pointer;border:2px solid transparent;border-radius:8px;overflow:hidden;transition:border-color .15s"
         onmouseover="this.style.borderColor='#2563eb'"
         onmouseout="this.style.borderColor='transparent'">
      <img src="${img.url}" loading="lazy"
           style="width:100%;height:90px;object-fit:cover;display:block">
      <div style="font-size:10px;color:#888;padding:4px 6px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
        ${img.filename}
      </div>
    </div>
  `).join('');
}

function selectMediaImage(id, url, filename) {
  if (editorMediaCb) {
    editorMediaCb(url, { title: filename });
  } else {
    document.getElementById('cover_gallery_id').value = id;
    document.getElementById('preview-img').src = url;
    document.getElementById('thumbnail-preview').style.display = 'block';
  }
  closeMediaModal();
}

function filterMedia(q) {
  renderGrid(allImages.filter(img => img.filename.toLowerCase().includes(q.toLowerCase())));
}

function uploadFromModal() {
  document.getElementById('modal-upload-input').click();
}

document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('modal-upload-input').addEventListener('change', function () {
    if (!this.files.length) return;
    const fd = new FormData();
    fd.append('file', this.files[0]);
    fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
    fd.append('car_id', CAR_ID);
    const btn = document.getElementById('modal-upload-btn');
    btn.textContent = 'Đang upload...';
    btn.disabled = true;

    fetch('{{ route("admin.media.upload") }}', { method: 'POST', body: fd })
      .then(r => r.json())
      .then(d => {
        if (d.id && d.url) {
          allImages.unshift({ id: d.id, url: d.url, path: d.path, filename: d.url.split('/').pop() });
          renderGrid(allImages);
        }
      })
      .catch(() => alert('Upload thất bại!'))
      .finally(() => { btn.textContent = '⬆ Upload ảnh mới'; btn.disabled = false; this.value = ''; });
  });

  document.getElementById('media-modal').addEventListener('click', function (e) {
    if (e.target === this) closeMediaModal();
  });
});

function previewUpload(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => {
      document.getElementById('preview-img').src = e.target.result;
      document.getElementById('thumbnail-preview').style.display = 'block';
      document.getElementById('cover_gallery_id').value = '';
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function clearThumbnail() {
  document.getElementById('preview-img').src = '';
  document.getElementById('thumbnail-preview').style.display = 'none';
  document.getElementById('cover_gallery_id').value = '';
  document.getElementById('thumbnail-upload').value = '';
}

function deleteGallery(id) {
  if (!confirm('Xóa ảnh này?')) return;
  fetch(`/admin/cars/gallery/${id}`, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      'Accept': 'application/json',
    },
  })
  .then(r => r.json())
  .then(d => {
    if (d.success) {
      document.getElementById(`gallery-item-${id}`)?.remove();
      allImages = allImages.filter(img => img.id != id);
    } else {
      alert('Xóa thất bại!');
    }
  })
  .catch(() => alert('Lỗi kết nối!'));
}
</script>
@endpush
@endsection