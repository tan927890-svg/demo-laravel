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
            <input class="form-control" type="number" name="price_per_day"
                   value="{{ old('price_per_day', $car->price_per_day) }}" required placeholder="VD: 1235000000">
          </div>
          <div class="form-group">
            <label class="form-label">Năm sản xuất</label>
            <input class="form-control" type="number" name="year"
                   value="{{ old('year', $car->year) }}" min="2000" max="{{ date('Y')+2 }}">
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
          <textarea class="form-control" name="description" rows="3"
                    placeholder="Mô tả ngắn gọn về xe...">{{ old('description', $car->description) }}</textarea>
        </div>

        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Nội dung chi tiết</label>
          <textarea class="form-control" name="content" rows="8"
                    placeholder="Nội dung trang chi tiết xe...">{{ old('content', $car->content) }}</textarea>
        </div>
      </div>

      {{-- THÔNG SỐ KỸ THUẬT --}}
      <div class="card card-pad">
        <div style="font-size:13px;font-weight:600;margin-bottom:14px;color:var(--text-muted);letter-spacing:.3px">THÔNG SỐ KỸ THUẬT</div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Động cơ</label>
            <input class="form-control" name="engine"
                   value="{{ old('engine', $car->engine) }}" placeholder="VD: 2.5L 4 xi-lanh">
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
            <input class="form-control" name="horsepower" type="number"
                   value="{{ old('horsepower', $car->horsepower) }}" placeholder="VD: 182">
          </div>
          <div class="form-group">
            <label class="form-label">Mức tiêu thụ (L/100km)</label>
            <input class="form-control" name="fuel_consumption"
                   value="{{ old('fuel_consumption', $car->fuel_consumption) }}" placeholder="VD: 7.2">
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

        {{-- XE NỔI BẬT --}}
        <div class="form-group">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px">
            <input type="checkbox" name="is_featured" value="1" id="cb_featured"
                   {{ old('is_featured', $car->is_featured) ? 'checked' : '' }}>
            Hiển thị trong "Xe Nổi Bật"
          </label>
        </div>

        {{-- BADGE --}}
        <div class="form-group" id="featured-fields"
             style="{{ old('is_featured', $car->is_featured) ? '' : 'display:none;' }}">
          <label class="form-label">Nhãn badge</label>
          <input class="form-control" type="text" name="badge_label"
                 value="{{ old('badge_label', $car->badge_label ?? '') }}"
                 placeholder="VD: Flagship, Bán chạy, Full Electric...">
          <div class="form-hint">Hiển thị kèm xe nổi bật (để trống nếu không cần)</div>
        </div>

        {{-- PREFIX ẢNH 360 --}}
        <div class="form-group" id="prefix360-field"
             style="{{ old('is_featured', $car->is_featured) ? '' : 'display:none;' }}margin-bottom:0">
          <label class="form-label">Prefix ảnh 360°</label>
          <input class="form-control" type="text" name="image_360_prefix"
                 value="{{ old('image_360_prefix', $car->image_360_prefix ?? '') }}"
                 placeholder="VD: Mercedes-AMG GLE">
          <div class="form-hint">
            Tên prefix file trong <code>public/images/quay360/</code><br>
            VD: nhập <strong>Mercedes-AMG GLE</strong> → dùng file <strong>Mercedes-AMG GLE1.png</strong> … <strong>8.png</strong>
          </div>
        </div>
      </div>

      {{-- ẢNH ĐẠI DIỆN --}}
      <div class="card card-pad">
        <div style="font-size:13px;font-weight:600;margin-bottom:14px;color:var(--text-muted);letter-spacing:.3px">ẢNH ĐẠI DIỆN</div>

        {{-- Preview ảnh hiện tại --}}
        <div id="preview-wrap" style="{{ $car->image_url ? '' : 'display:none;' }}margin-bottom:12px">
          <img id="img-preview"
               src="{{ $car->image_url ? asset($car->image_url) : '' }}"
               style="width:100%;height:160px;object-fit:contain;border-radius:8px;border:1px solid var(--border,#e2e8f0);background:#f8f8f8"
               onerror="this.style.opacity='.2'">
        </div>

        {{-- Nhập tay đường dẫn --}}
        <div class="form-group">
          <label class="form-label">Đường dẫn ảnh</label>
          <input class="form-control" type="text" name="image_url" id="image_url_input"
                 value="{{ old('image_url', $car->image_url) }}"
                 placeholder="images/car/Ten-Xe-TN.png"
                 oninput="previewByUrl(this.value)">
          <div class="form-hint">Đường dẫn tương đối trong <code>public/</code>, VD: <code>images/car/Mercedes-AMG-GLE-TN.png</code></div>
        </div>

        <div style="text-align:center;font-size:12px;color:#aaa;margin:4px 0 10px">— hoặc upload file mới —</div>

        {{-- Upload file --}}
        <div class="form-group" style="margin-bottom:0">
          <input class="form-control" type="file" name="image_file" accept="image/*"
                 id="img-input" onchange="previewUpload(this)">
          <div class="form-hint">Upload sẽ lưu vào <code>public/images/car/</code> và tự cập nhật đường dẫn</div>
        </div>
      </div>

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
          <textarea class="form-control" name="meta_description" rows="2"
                    placeholder="Mô tả hiển thị trên Google...">{{ old('meta_description', $car->meta_description) }}</textarea>
        </div>
      </div>

      <div style="display:flex;gap:8px">
        <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center">Cập nhật xe</button>
        <a href="{{ route('admin.cars.index') }}" class="btn" style="flex:1;justify-content:center">Hủy</a>
      </div>

    </div>
  </div>
</form>

<script>
document.getElementById('cb_featured').addEventListener('change', function () {
  const show = this.checked;
  document.getElementById('featured-fields').style.display = show ? '' : 'none';
  document.getElementById('prefix360-field').style.display = show ? '' : 'none';
});

function previewByUrl(val) {
  const wrap = document.getElementById('preview-wrap');
  const img  = document.getElementById('img-preview');
  if (val) {
    img.src = '/' + val.replace(/^\/+/, '');
    wrap.style.display = '';
  }
}

function previewUpload(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => {
      document.getElementById('img-preview').src = e.target.result;
      document.getElementById('preview-wrap').style.display = '';
      // Xóa input text để controller dùng file upload thay thế
      document.getElementById('image_url_input').value = '';
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
@endsection