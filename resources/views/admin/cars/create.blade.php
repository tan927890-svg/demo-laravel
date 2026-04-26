@extends('layouts.admin')
@section('page-title', 'Thêm xe mới')

@section('topbar-actions')
  <a href="{{ route('admin.cars.index') }}" class="btn btn-sm">← Quay lại</a>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.cars.store') }}" enctype="multipart/form-data">
  @csrf

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
      <div class="card card-pad">
        <div style="font-size:13px;font-weight:600;margin-bottom:14px;color:var(--text-muted);letter-spacing:.3px">THÔNG TIN CƠ BẢN</div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Tên xe <span style="color:red">*</span></label>
            <input class="form-control" name="name" value="{{ old('name') }}" required placeholder="VD: Camry 2.5Q">
          </div>
          <div class="form-group">
            <label class="form-label">Thương hiệu <span style="color:red">*</span></label>
            <select class="form-control" name="brand_id" id="brand_id" required>
              <option value="">-- Chọn thương hiệu --</option>
              @foreach($brands as $brand)
                <option value="{{ $brand->id }}"
                  data-price="{{ $brand->default_price_per_day }}"
                  data-fuel="{{ $brand->default_fuel_type }}"
                  data-transmission="{{ $brand->default_transmission }}"
                  data-seats="{{ $brand->default_seats }}"
                  {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                  {{ $brand->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Giá bán (VNĐ) <span style="color:red">*</span></label>
            <input class="form-control" type="number" name="price_per_day" value="{{ old('price_per_day') }}" required placeholder="VD: 1235000000">
          </div>
          <div class="form-group">
            <label class="form-label">Năm sản xuất <span style="color:red">*</span></label>
            <input class="form-control" type="number" name="year" value="{{ old('year', date('Y')) }}" required min="2000" max="{{ date('Y')+2 }}">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Số chỗ ngồi</label>
            <select class="form-control" name="seats" id="seats">
              @foreach([2,4,5,7,8,9] as $s)
                <option value="{{ $s }}" {{ old('seats', 5) == $s ? 'selected' : '' }}>{{ $s }} chỗ</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Loại nhiên liệu</label>
            <select class="form-control" name="fuel_type" id="fuel_type">
              @foreach(['Xăng','Dầu','Điện','Hybrid'] as $f)
                <option value="{{ $f }}" {{ old('fuel_type', 'Xăng') == $f ? 'selected' : '' }}>{{ $f }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Mô tả ngắn</label>
          <textarea class="form-control" name="description" rows="3" placeholder="Mô tả ngắn gọn về xe...">{{ old('description') }}</textarea>
        </div>

        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Nội dung chi tiết</label>
          <textarea class="form-control" name="content" rows="8" placeholder="Nội dung trang chi tiết xe...">{{ old('content') }}</textarea>
        </div>
      </div>

      <div class="card card-pad">
        <div style="font-size:13px;font-weight:600;margin-bottom:14px;color:var(--text-muted);letter-spacing:.3px">THÔNG SỐ KỸ THUẬT</div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Động cơ</label>
            <input class="form-control" name="engine" value="{{ old('engine') }}" placeholder="VD: 2.5L 4 xi-lanh">
          </div>
          <div class="form-group">
            <label class="form-label">Hộp số</label>
            <select class="form-control" name="transmission" id="transmission">
              @foreach(['Tự động','Sàn','CVT','DCT'] as $t)
                <option value="{{ $t }}" {{ old('transmission', 'Tự động') == $t ? 'selected' : '' }}>{{ $t }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Công suất (HP)</label>
            <input class="form-control" name="horsepower" type="number" value="{{ old('horsepower') }}" placeholder="VD: 182">
          </div>
          <div class="form-group">
            <label class="form-label">Mức tiêu thụ (L/100km)</label>
            <input class="form-control" name="fuel_consumption" value="{{ old('fuel_consumption') }}" placeholder="VD: 7.2">
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
            <option value="available"    {{ old('status','available') == 'available'    ? 'selected':'' }}>Còn hàng</option>
            <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected':'' }}>Hết hàng</option>
            <option value="coming_soon"  {{ old('status') == 'coming_soon'  ? 'selected':'' }}>Sắp ra mắt</option>
          </select>
        </div>

        {{-- XE NỔI BẬT --}}
        <div class="form-group">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px">
            <input type="checkbox" name="is_featured" value="1" id="cb_featured"
                   {{ old('is_featured') ? 'checked' : '' }}>
            Hiển thị trong "Xe Nổi Bật"
          </label>
        </div>

        {{-- BADGE --}}
        <div class="form-group" id="featured-fields" style="{{ old('is_featured') ? '' : 'display:none;' }}">
          <label class="form-label">Nhãn badge</label>
          <input class="form-control" type="text" name="badge_label"
                 value="{{ old('badge_label') }}"
                 placeholder="VD: Flagship, Bán chạy, Full Electric...">
          <div class="form-hint">Hiển thị kèm xe nổi bật (để trống nếu không cần)</div>
        </div>

        {{-- PREFIX ẢNH 360 --}}
        <div class="form-group" id="prefix360-field" style="{{ old('is_featured') ? '' : 'display:none;' }}margin-bottom:0">
          <label class="form-label">Prefix ảnh 360°</label>
          <input class="form-control" type="text" name="image_360_prefix"
                 value="{{ old('image_360_prefix') }}"
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
        <div id="preview-wrap" style="display:none;margin-bottom:12px">
          <img id="img-preview" style="width:100%;height:120px;object-fit:cover;border-radius:8px;border:1px solid var(--border)">
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Upload ảnh</label>
          <input class="form-control" type="file" name="images[]" id="img-input" multiple accept="image/*">
          <div class="form-hint">Chọn nhiều ảnh. Ảnh đầu tiên sẽ là ảnh chính.</div>
        </div>
      </div>

      {{-- SEO --}}
      <div class="card card-pad">
        <div style="font-size:13px;font-weight:600;margin-bottom:14px;color:var(--text-muted);letter-spacing:.3px">SEO</div>
        <div class="form-group">
          <label class="form-label">Slug URL</label>
          <input class="form-control" name="slug" value="{{ old('slug') }}" placeholder="ten-xe-hang-nam">
          <div class="form-hint">Để trống sẽ tự tạo từ tên xe</div>
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Meta description</label>
          <textarea class="form-control" name="meta_description" rows="2" placeholder="Mô tả hiển thị trên Google...">{{ old('meta_description') }}</textarea>
        </div>
      </div>

      <div style="display:flex;gap:8px">
        <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center">Thêm xe</button>
        <a href="{{ route('admin.cars.index') }}" class="btn" style="flex:1;justify-content:center">Hủy</a>
      </div>
    </div>

  </div>
</form>

<script>
// Toggle featured fields khi check/uncheck
document.getElementById('cb_featured').addEventListener('change', function () {
  const show = this.checked;
  document.getElementById('featured-fields').style.display  = show ? '' : 'none';
  document.getElementById('prefix360-field').style.display  = show ? '' : 'none';
});

document.getElementById('brand_id').addEventListener('change', function () {
  const opt = this.options[this.selectedIndex];
  if (opt.dataset.price)        document.querySelector('[name=price_per_day]').value = opt.dataset.price;
  if (opt.dataset.fuel)         document.getElementById('fuel_type').value    = opt.dataset.fuel;
  if (opt.dataset.transmission) document.getElementById('transmission').value = opt.dataset.transmission;
  if (opt.dataset.seats) {
    for (let o of document.getElementById('seats').options)
      if (o.value == opt.dataset.seats) o.selected = true;
  }
});

document.getElementById('img-input').addEventListener('change', function () {
  if (this.files && this.files[0]) {
    document.getElementById('img-preview').src = URL.createObjectURL(this.files[0]);
    document.getElementById('preview-wrap').style.display = '';
  }
});
</script>
@endsection