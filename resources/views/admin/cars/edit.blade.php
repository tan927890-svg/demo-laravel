@extends('layouts.admin')
@section('page-title', 'Sửa xe: ' . $car->name)

@section('topbar-actions')
  <a href="{{ route('admin.cars.index') }}" class="btn btn-sm">← Quay lại</a>
  <button type="submit" form="car-form" class="btn btn-primary btn-sm">💾 Lưu thay đổi</button>
@endsection

@section('content')
<form id="car-form" method="POST" action="{{ route('admin.cars.update', $car) }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')

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
            <input class="form-control" name="name" value="{{ old('name', $car->name) }}" required placeholder="VD: VF 9">
          </div>
          <div class="form-group">
            <label class="form-label">Thương hiệu <span class="req">*</span></label>
            <select class="form-control" name="brand_id" required>
              <option value="">-- Chọn --</option>
              @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ old('brand_id', $car->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Tagline</label>
            <input class="form-control" name="tagline" value="{{ old('tagline', $car->tagline) }}" placeholder="VD: Crossover điện thế hệ mới">
          </div>
          <div class="form-group">
            <label class="form-label">Giá niêm yết (VNĐ) <span class="req">*</span></label>
            <input class="form-control" type="number" name="price_per_day" value="{{ old('price_per_day', $car->price_per_day) }}" required placeholder="VD: 458000000">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Số chỗ ngồi</label>
            <select class="form-control" name="seats">
              @foreach([2,4,5,7,8,9] as $s)
                <option value="{{ $s }}" {{ old('seats', $car->seats) == $s ? 'selected':'' }}>{{ $s }} chỗ</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Nhiên liệu</label>
            <select class="form-control" name="fuel_type">
              @foreach(['Xăng','Dầu','Điện','Hybrid'] as $f)
                <option value="{{ $f }}" {{ old('fuel_type', $car->fuel_type) == $f ? 'selected':'' }}>{{ $f }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Hộp số</label>
            <select class="form-control" name="transmission">
              @foreach(['Tự động','Sàn','CVT','DCT'] as $t)
                <option value="{{ $t }}" {{ old('transmission', $car->transmission) == $t ? 'selected':'' }}>{{ $t }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Mô tả ngắn</label>
          <textarea class="form-control" name="description" rows="3" placeholder="Mô tả ngắn gọn…">{{ old('description', $car->description) }}</textarea>
        </div>
      </div>

      {{-- ② BIẾN THỂ --}}
      <div class="card card-pad">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
          <div class="section-title" style="margin-bottom:0">② Biến thể / Phiên bản</div>
          <button type="button" class="btn-add" onclick="addVariant()">+ Thêm phiên bản</button>
        </div>
        <div class="form-hint" style="margin-bottom:12px">Tên phiên bản hiển thị ở cột header bảng thông số kỹ thuật.</div>
        <div id="variants-list">
          @forelse($car->variants->sortBy('sort_order') as $vi => $variant)
          <div class="repeater-row" id="variant-{{ $vi }}">
            <div class="repeater-header">
              <span class="repeater-num">Phiên bản #{{ $vi + 1 }}</span>
              <button type="button" class="btn-remove" onclick="removeRow('variant-{{ $vi }}')">✕</button>
            </div>
            <div class="form-row" style="margin-bottom:0">
              <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Tên phiên bản <span class="req">*</span></label>
                <input class="form-control" name="variants[{{ $vi }}][name]" value="{{ $variant->name }}" placeholder="VD: Standard, Plus, Pro…">
              </div>
              <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Giá bán (VNĐ)</label>
                <input class="form-control" type="number" name="variants[{{ $vi }}][price]" value="{{ $variant->price }}" min="0">
              </div>
            </div>
            <input type="hidden" name="variants[{{ $vi }}][sort_order]" value="{{ $variant->sort_order }}">
          </div>
          @empty
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
                <input class="form-control" type="number" name="variants[0][price]" min="0">
              </div>
            </div>
          </div>
          @endforelse
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
          @forelse($car->specs->sortBy(['category_order','sort_order']) as $si => $spec)
          <div class="repeater-row" id="spec-{{ $si }}">
            <div class="repeater-header">
              <span class="repeater-num">Thông số #{{ $si + 1 }}</span>
              <button type="button" class="btn-remove" onclick="removeRow('spec-{{ $si }}')">✕</button>
            </div>
            <div class="form-row">
              <div class="form-group"><label class="form-label">Danh mục <span class="req">*</span></label><input class="form-control" name="specs[{{ $si }}][category]" value="{{ $spec->category }}" placeholder="VD: Động cơ điện"></div>
              <div class="form-group"><label class="form-label">Tên thông số <span class="req">*</span></label><input class="form-control" name="specs[{{ $si }}][spec_key]" value="{{ $spec->spec_key }}" placeholder="VD: Công suất"></div>
              <div class="form-group"><label class="form-label">Giá trị <span class="req">*</span></label><input class="form-control" name="specs[{{ $si }}][spec_value]" value="{{ $spec->spec_value }}" placeholder="VD: 100 kW"></div>
            </div>
            <div class="form-row" style="margin-bottom:0">
              <div class="form-group" style="margin-bottom:0"><label class="form-label">Thứ tự danh mục</label><input class="form-control" type="number" name="specs[{{ $si }}][category_order]" value="{{ $spec->category_order }}" style="width:80px"></div>
              <div class="form-group" style="margin-bottom:0"><label class="form-label">Thứ tự trong danh mục</label><input class="form-control" type="number" name="specs[{{ $si }}][sort_order]" value="{{ $spec->sort_order }}" style="width:80px"></div>
            </div>
          </div>
          @empty
          <div class="repeater-row" id="spec-0">
            <div class="repeater-header">
              <span class="repeater-num">Thông số #1</span>
              <button type="button" class="btn-remove" onclick="removeRow('spec-0')">✕</button>
            </div>
            <div class="form-row">
              <div class="form-group"><label class="form-label">Danh mục <span class="req">*</span></label><input class="form-control" name="specs[0][category]" placeholder="VD: Động cơ điện"></div>
              <div class="form-group"><label class="form-label">Tên thông số <span class="req">*</span></label><input class="form-control" name="specs[0][spec_key]" placeholder="VD: Công suất"></div>
              <div class="form-group"><label class="form-label">Giá trị <span class="req">*</span></label><input class="form-control" name="specs[0][spec_value]" placeholder="VD: 100 kW"></div>
            </div>
            <div class="form-row" style="margin-bottom:0">
              <div class="form-group" style="margin-bottom:0"><label class="form-label">Thứ tự danh mục</label><input class="form-control" type="number" name="specs[0][category_order]" value="0" style="width:80px"></div>
              <div class="form-group" style="margin-bottom:0"><label class="form-label">Thứ tự trong danh mục</label><input class="form-control" type="number" name="specs[0][sort_order]" value="0" style="width:80px"></div>
            </div>
          </div>
          @endforelse
        </div>
      </div>

      {{-- ④ TÍNH NĂNG NỔI BẬT --}}
      <div class="card card-pad">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
          <div class="section-title" style="margin-bottom:0">④ Tính năng nổi bật</div>
          <button type="button" class="btn-add" onclick="addFeature()">+ Thêm tính năng</button>
        </div>
        <div class="form-hint" style="margin-bottom:12px">Hiển thị 2 slide đầu trên trang chi tiết (Ngoại thất / Nội thất).</div>
        <div id="features-list">
          @forelse($car->features->sortBy('sort_order') as $fi => $feature)
          <div class="repeater-row" id="feature-{{ $fi }}">
            <div class="repeater-header">
              <span class="repeater-num">Tính năng #{{ $fi + 1 }}</span>
              <button type="button" class="btn-remove" onclick="removeRow('feature-{{ $fi }}')">✕</button>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Tiêu đề <span class="req">*</span></label>
                <input class="form-control" name="features[{{ $fi }}][title]" value="{{ $feature->title }}" placeholder="VD: Ngoại thất VF 9">
              </div>
            </div>
            <div class="form-group">
              <label class="form-label">Mô tả</label>
              <textarea class="form-control" name="features[{{ $fi }}][description]" rows="2">{{ $feature->description }}</textarea>
            </div>
            <div class="form-row" style="margin-bottom:0">
              <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Ảnh chính</label>
                @if($feature->image)
                  <div class="img-thumb-wrap" style="margin-bottom:8px">
                    <img src="/{{ ltrim($feature->image,'/') }}" style="height:80px;border-radius:6px;object-fit:cover;">
                  </div>
                  <div class="form-hint" style="margin-bottom:4px">Ảnh hiện tại. Upload mới để thay.</div>
                @endif
                <input type="file" class="form-control" name="feature_images[{{ $fi }}]" accept="image/*" onchange="previewFeatureImg(this,'fp{{ $fi }}')">
                <div id="fp{{ $fi }}" class="img-thumb-wrap" style="display:none;margin-top:8px"><img style="height:80px;border-radius:6px;object-fit:cover;"></div>
                <input type="hidden" name="features[{{ $fi }}][image]" value="{{ $feature->image }}">
              </div>
              <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Ảnh phụ (tùy chọn)</label>
                @if($feature->image2)
                  <div class="img-thumb-wrap" style="margin-bottom:8px">
                    <img src="/{{ ltrim($feature->image2,'/') }}" style="height:80px;border-radius:6px;object-fit:cover;">
                  </div>
                  <div class="form-hint" style="margin-bottom:4px">Ảnh hiện tại. Upload mới để thay.</div>
                @endif
                <input type="file" class="form-control" name="feature_images2[{{ $fi }}]" accept="image/*" onchange="previewFeatureImg(this,'fp2-{{ $fi }}')">
                <div id="fp2-{{ $fi }}" class="img-thumb-wrap" style="display:none;margin-top:8px"><img style="height:80px;border-radius:6px;object-fit:cover;"></div>
                <input type="hidden" name="features[{{ $fi }}][image2]" value="{{ $feature->image2 }}">
              </div>
            </div>
            <input type="hidden" name="features[{{ $fi }}][sort_order]" value="{{ $feature->sort_order }}">
          </div>
          @empty
          <div class="repeater-row" id="feature-0">
            <div class="repeater-header">
              <span class="repeater-num">Tính năng #1</span>
              <button type="button" class="btn-remove" onclick="removeRow('feature-0')">✕</button>
            </div>
            <div class="form-row"><div class="form-group"><label class="form-label">Tiêu đề <span class="req">*</span></label><input class="form-control" name="features[0][title]" placeholder="VD: Ngoại thất VF 9"></div></div>
            <div class="form-group"><label class="form-label">Mô tả</label><textarea class="form-control" name="features[0][description]" rows="2" placeholder="Mô tả tính năng…"></textarea></div>
            <div class="form-row" style="margin-bottom:0">
              <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Ảnh chính <span class="req">*</span></label>
                <input type="file" class="form-control" name="feature_images[0]" accept="image/*" onchange="previewFeatureImg(this,'fp0')">
                <div id="fp0" class="img-thumb-wrap" style="display:none;margin-top:8px"><img style="height:80px;border-radius:6px;object-fit:cover;"></div>
                <input type="hidden" name="features[0][image]" id="fi0">
              </div>
              <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Ảnh phụ (tùy chọn)</label>
                <input type="file" class="form-control" name="feature_images2[0]" accept="image/*" onchange="previewFeatureImg(this,'fp2-0')">
                <div id="fp2-0" class="img-thumb-wrap" style="display:none;margin-top:8px"><img style="height:80px;border-radius:6px;object-fit:cover;"></div>
                <input type="hidden" name="features[0][image2]" id="fi2-0">
              </div>
            </div>
            <input type="hidden" name="features[0][sort_order]" value="0">
          </div>
          @endforelse
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
          @forelse($car->galleries->where('type','image')->sortBy('sort_order') as $gi => $gallery)
          <div class="repeater-row" id="gallery-{{ $gi }}">
            <div class="repeater-header">
              <span class="repeater-num">Ảnh #{{ $gi + 1 }}</span>
              <button type="button" class="btn-remove" onclick="removeRow('gallery-{{ $gi }}')">✕</button>
            </div>
            <div class="form-row" style="margin-bottom:6px;align-items:flex-end">
              <div class="form-group" style="margin-bottom:0;flex:2">
                <label class="form-label">Đường dẫn ảnh</label>
                <div style="display:flex;gap:6px">
                  <input class="form-control" name="galleries[{{ $gi }}][file_path]" id="gpath{{ $gi }}"
                         value="{{ $gallery->file_path }}"
                         oninput="previewFromUrl(this,'gp{{ $gi }}')">
                  <button type="button" class="btn-browse" onclick="openBrowser('car','gpath{{ $gi }}','gp{{ $gi }}')" title="Chọn từ thư mục">📁</button>
                </div>
              </div>
              <div class="form-group" style="margin-bottom:0;flex:1">
                <label class="form-label">Chú thích</label>
                <input class="form-control" name="galleries[{{ $gi }}][caption]" value="{{ $gallery->caption }}" placeholder="Chú thích…">
              </div>
            </div>
            @if($gallery->file_path)
            <div id="gp{{ $gi }}" class="img-thumb-wrap" style="margin-top:8px">
              <img src="/{{ ltrim($gallery->file_path,'/') }}" style="height:80px;border-radius:6px;object-fit:cover;">
            </div>
            @else
            <div id="gp{{ $gi }}" class="img-thumb-wrap" style="display:none;margin-top:8px">
              <img style="height:80px;border-radius:6px;object-fit:cover;">
            </div>
            @endif
            <div class="upload-divider">— hoặc upload file mới —</div>
            <input type="file" class="form-control" name="gallery_files[{{ $gi }}]" accept="image/*"
                   onchange="previewGalleryImg(this,'gp{{ $gi }}','gpath{{ $gi }}')">
            <div class="form-hint" style="margin-top:4px">Upload sẽ lưu vào public/images/car/</div>
            <input type="hidden" name="galleries[{{ $gi }}][type]" value="image">
            <input type="hidden" name="galleries[{{ $gi }}][sort_order]" value="{{ $gallery->sort_order }}">
          </div>
          @empty
          <div class="repeater-row" id="gallery-0">
            <div class="repeater-header">
              <span class="repeater-num">Ảnh #1</span>
              <button type="button" class="btn-remove" onclick="removeRow('gallery-0')">✕</button>
            </div>
            <div class="form-row" style="margin-bottom:6px;align-items:flex-end">
              <div class="form-group" style="margin-bottom:0;flex:2">
                <label class="form-label">Đường dẫn ảnh</label>
                <div style="display:flex;gap:6px">
                  <input class="form-control" name="galleries[0][file_path]" id="gpath0" placeholder="images/car/..." oninput="previewFromUrl(this,'gp0')">
                  <button type="button" class="btn-browse" onclick="openBrowser('car','gpath0','gp0')" title="Chọn từ thư mục">📁</button>
                </div>
              </div>
              <div class="form-group" style="margin-bottom:0;flex:1">
                <label class="form-label">Chú thích</label>
                <input class="form-control" name="galleries[0][caption]" placeholder="Chú thích…">
              </div>
            </div>
            <div class="upload-divider">— hoặc upload file mới —</div>
            <input type="file" class="form-control" name="gallery_files[0]" accept="image/*" onchange="previewGalleryImg(this,'gp0','gpath0')">
            <div class="form-hint" style="margin-top:4px">Upload sẽ lưu vào public/images/car/</div>
            <div id="gp0" class="img-thumb-wrap" style="display:none;margin-top:8px"><img style="height:80px;border-radius:6px;object-fit:cover;"></div>
            <input type="hidden" name="galleries[0][type]" value="image">
            <input type="hidden" name="galleries[0][sort_order]" value="0">
          </div>
          @endforelse
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
          @forelse($car->colors->sortBy('sort_order') as $ci => $color)
          <div class="repeater-row" id="color-{{ $ci }}">
            <div class="repeater-header">
              <span class="repeater-num">Màu #{{ $ci + 1 }}</span>
              <button type="button" class="btn-remove" onclick="removeRow('color-{{ $ci }}')">✕</button>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Tên màu <span class="req">*</span></label>
                <input class="form-control" name="colors[{{ $ci }}][name]" value="{{ $color->name }}" placeholder="VD: Đỏ Fiery">
              </div>
              <div class="form-group">
                <label class="form-label">Mã màu HEX</label>
                <div style="display:flex;gap:8px;align-items:center">
                  <input type="color" value="{{ $color->hex_code ?: '#c62828' }}"
                         oninput="syncHex(this,'hex{{ $ci }}')"
                         style="width:40px;height:36px;border:1px solid var(--border);border-radius:6px;cursor:pointer;padding:2px;flex-shrink:0">
                  <input class="form-control" id="hex{{ $ci }}" name="colors[{{ $ci }}][hex_code]" value="{{ $color->hex_code }}" placeholder="#c62828" style="flex:1">
                </div>
              </div>
            </div>
            <div class="form-row" style="margin-bottom:0;align-items:flex-start">
              <div class="form-group" style="margin-bottom:0;flex:2">
                <label class="form-label">Đường dẫn ảnh xe màu này</label>
                <div style="display:flex;gap:6px;margin-bottom:6px">
                  <input class="form-control" name="colors[{{ $ci }}][image]" id="cimg{{ $ci }}"
                         value="{{ $color->image }}"
                         oninput="previewFromUrl(this,'cp{{ $ci }}')">
                  <button type="button" class="btn-browse" onclick="openBrowser('car','cimg{{ $ci }}','cp{{ $ci }}')" title="Chọn từ thư mục">📁</button>
                </div>
                @if($color->image)
                <div id="cp{{ $ci }}" class="img-thumb-wrap" style="margin-bottom:6px">
                  <img src="/{{ ltrim($color->image,'/') }}" style="height:80px;border-radius:6px;object-fit:cover;">
                </div>
                @else
                <div id="cp{{ $ci }}" class="img-thumb-wrap" style="display:none;margin-bottom:6px">
                  <img style="height:80px;border-radius:6px;object-fit:cover;">
                </div>
                @endif
                <div class="upload-divider">— hoặc upload file mới —</div>
                <input type="file" class="form-control" name="color_images[{{ $ci }}]" accept="image/*"
                       onchange="previewColorImg(this,'cp{{ $ci }}','cimg{{ $ci }}')">
                <div class="form-hint" style="margin-top:4px">Upload lưu vào public/images/colors/ · .png nền trong suốt tốt hơn</div>
              </div>
              <div class="form-group" style="margin-bottom:0;flex:1">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;margin-bottom:4px">
                  <input type="checkbox" name="colors[{{ $ci }}][is_default]" value="1" {{ $color->is_default ? 'checked':'' }}> Màu mặc định
                </label>
                <input type="hidden" name="colors[{{ $ci }}][sort_order]" value="{{ $color->sort_order }}">
              </div>
            </div>
          </div>
          @empty
          <div class="repeater-row" id="color-0">
            <div class="repeater-header">
              <span class="repeater-num">Màu #1</span>
              <button type="button" class="btn-remove" onclick="removeRow('color-0')">✕</button>
            </div>
            <div class="form-row">
              <div class="form-group"><label class="form-label">Tên màu <span class="req">*</span></label><input class="form-control" name="colors[0][name]" placeholder="VD: Đỏ Fiery"></div>
              <div class="form-group">
                <label class="form-label">Mã màu HEX</label>
                <div style="display:flex;gap:8px;align-items:center">
                  <input type="color" value="#c62828" oninput="syncHex(this,'hex0')" style="width:40px;height:36px;border:1px solid var(--border);border-radius:6px;cursor:pointer;padding:2px;flex-shrink:0">
                  <input class="form-control" id="hex0" name="colors[0][hex_code]" placeholder="#c62828" style="flex:1">
                </div>
              </div>
            </div>
            <div class="form-row" style="margin-bottom:0;align-items:flex-start">
              <div class="form-group" style="margin-bottom:0;flex:2">
                <label class="form-label">Đường dẫn ảnh xe màu này</label>
                <div style="display:flex;gap:6px;margin-bottom:6px">
                  <input class="form-control" name="colors[0][image]" id="cimg0" placeholder="images/car/..." oninput="previewFromUrl(this,'cp0')">
                  <button type="button" class="btn-browse" onclick="openBrowser('car','cimg0','cp0')" title="Chọn từ thư mục">📁</button>
                </div>
                <div id="cp0" class="img-thumb-wrap" style="display:none"><img style="height:80px;border-radius:6px;object-fit:cover;"></div>
                <div class="upload-divider">— hoặc upload file mới —</div>
                <input type="file" class="form-control" name="color_images[0]" accept="image/*" onchange="previewColorImg(this,'cp0','cimg0')">
                <div class="form-hint" style="margin-top:4px">Upload lưu vào public/images/colors/ · .png nền trong suốt tốt hơn</div>
              </div>
              <div class="form-group" style="margin-bottom:0;flex:1">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px">
                  <input type="checkbox" name="colors[0][is_default]" value="1"> Màu mặc định
                </label>
                <input type="hidden" name="colors[0][sort_order]" value="0">
              </div>
            </div>
          </div>
          @endforelse
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
            <option value="available"    {{ old('status',$car->status)=='available'    ? 'selected':'' }}>✅ Còn hàng</option>
            <option value="out_of_stock" {{ old('status',$car->status)=='out_of_stock' ? 'selected':'' }}>❌ Hết hàng</option>
            <option value="coming_soon"  {{ old('status',$car->status)=='coming_soon'  ? 'selected':'' }}>🔜 Sắp ra mắt</option>
          </select>
        </div>
        <div class="form-group">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px">
            <input type="checkbox" name="is_available" value="1" {{ old('is_available', $car->is_available) ? 'checked':'' }}>
            Hiển thị trên trang web
          </label>
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px">
            <input type="checkbox" name="is_featured" value="1" id="cb_featured" {{ old('is_featured', $car->is_featured) ? 'checked':'' }}>
            Hiển thị trong "Xe Nổi Bật"
          </label>
        </div>
        <div id="featured-fields" style="{{ old('is_featured', $car->is_featured) ? '':'display:none;' }}margin-top:12px;padding-top:12px;border-top:1px solid var(--border)">
          <div class="form-group">
            <label class="form-label">Badge label</label>
            <input class="form-control" name="badge_label" value="{{ old('badge_label', $car->badge_label) }}" placeholder="VD: Flagship, Bán chạy…">
          </div>
          <div class="form-group">
            <label class="form-label">Prefix ảnh 360°</label>
            <input class="form-control" name="image_360_prefix" value="{{ old('image_360_prefix', $car->image_360_prefix) }}" placeholder="VD: images/vinfast/vf9-do">
            <div class="form-hint">Prefix + số thứ tự + .png</div>
          </div>
          <div class="form-group" style="margin-bottom:0">
            <label class="form-label">Số frame 360°</label>
            <input class="form-control" type="number" name="image_360_frames" value="{{ old('image_360_frames', $car->image_360_frames ?? 8) }}" min="1" max="72" style="width:90px">
          </div>
        </div>
      </div>

      {{-- ẢNH ĐẠI DIỆN --}}
      <div class="card card-pad">
        <div class="section-title">Ảnh đại diện</div>
        <div class="form-hint" style="margin-bottom:10px">Hiển thị trong danh sách xe và phần Giá & Hạng xe.</div>
        <label class="form-label">Đường dẫn ảnh</label>
        <div style="display:flex;gap:6px;margin-bottom:6px">
          <input class="form-control" name="image_url" id="final-image-url"
                 value="{{ old('image_url', $car->image_url) }}"
                 placeholder="images/car/..." oninput="previewFromUrl(this,'main-url-preview')">
          <button type="button" class="btn-browse" onclick="openBrowser('car','final-image-url','main-url-preview')" title="Chọn từ thư mục">📁</button>
        </div>
        @if($car->image_url)
        <div id="main-url-preview" class="img-thumb-wrap" style="margin-bottom:6px">
          <img src="/{{ ltrim($car->image_url,'/') }}" style="width:100%;height:100px;object-fit:contain;border-radius:6px;border:1px solid var(--border);background:#f5f5f5">
        </div>
        @else
        <div id="main-url-preview" class="img-thumb-wrap" style="display:none;margin-bottom:6px">
          <img style="width:100%;height:100px;object-fit:contain;border-radius:6px;border:1px solid var(--border);background:#f5f5f5">
        </div>
        @endif
        <div class="upload-divider">— hoặc upload file mới —</div>
        <input type="file" class="form-control" name="image_file" id="img-file-input" accept="image/*">
        <div id="main-upload-preview" style="display:none;margin-top:8px">
          <img id="main-img-preview" style="width:100%;height:100px;object-fit:contain;border-radius:6px;border:1px solid var(--border);background:#f5f5f5">
        </div>
        <div class="form-hint" style="margin-top:6px">Upload lưu vào public/images/car/ · .png nền trong suốt đẹp hơn.</div>
      </div>

      {{-- NÚT LƯU --}}
      <div class="card card-pad" style="background:var(--primary,#1d4ed8);border:none;padding:14px">
        <button type="submit" class="btn"
          style="width:100%;background:#fff;color:#1d4ed8;font-weight:700;font-size:15px;padding:12px;border:none;border-radius:6px;cursor:pointer">
          💾 Lưu thay đổi
        </button>
      </div>

    </div>{{-- end RIGHT --}}
  </div>
</form>

{{-- ══════════ IMAGE BROWSER MODAL ══════════ --}}
<div id="img-browser-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.6);align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:10px;width:900px;max-width:95vw;max-height:88vh;display:flex;flex-direction:column;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.35)">
    <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid #e5e7eb;flex-shrink:0">
      <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
        <span style="font-weight:700;font-size:14px">📁 Chọn ảnh từ thư mục</span>
        <select id="browser-folder-select" onchange="browserLoadFolder(this.value)"
                style="border:1px solid #d1d5db;border-radius:6px;padding:4px 10px;font-size:13px;cursor:pointer">
          <option value="car">images/car/</option>
          <option value="hero">images/hero/</option>
          <option value="features">images/features/</option>
          <option value="colors">images/colors/</option>
          <option value="vinfast">images/vinfast/</option>
        </select>
        <span id="browser-count" style="font-size:12px;color:#9ca3af"></span>
      </div>
      <button onclick="closeBrowser()" style="background:none;border:none;font-size:22px;cursor:pointer;color:#6b7280;line-height:1;padding:4px">✕</button>
    </div>
    <div style="padding:10px 20px;border-bottom:1px solid #f3f4f6;flex-shrink:0">
      <input id="browser-search" type="text" placeholder="Tìm theo tên file…" oninput="browserFilter(this.value)"
             style="width:100%;border:1px solid #e5e7eb;border-radius:6px;padding:7px 12px;font-size:13px;box-sizing:border-box">
    </div>
    <div id="browser-grid" style="flex:1;overflow-y:auto;padding:16px;display:grid;grid-template-columns:repeat(auto-fill,minmax(130px,1fr));gap:10px;align-content:start;min-height:300px">
      <div style="grid-column:1/-1;text-align:center;padding:40px;color:#9ca3af;font-size:13px">Đang tải…</div>
    </div>
    <div style="padding:12px 20px;border-top:1px solid #e5e7eb;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;background:#f9fafb">
      <div id="browser-selected-path" style="font-size:12px;color:#6b7280;font-family:monospace;flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;padding-right:12px"></div>
      <div style="display:flex;gap:8px;flex-shrink:0">
        <button onclick="closeBrowser()" style="padding:8px 18px;border:1px solid #d1d5db;border-radius:6px;background:#fff;font-size:13px;cursor:pointer">Huỷ</button>
        <button onclick="confirmBrowser()" id="browser-confirm-btn"
                style="padding:8px 20px;border:none;border-radius:6px;background:#1d4ed8;color:#fff;font-size:13px;font-weight:600;cursor:pointer;opacity:.35;pointer-events:none;transition:opacity .15s">
          ✓ Chọn ảnh này
        </button>
      </div>
    </div>
  </div>
</div>

{{-- ═══════════ STYLES ═══════════ --}}
<style>
.section-title{font-size:11px;font-weight:700;margin-bottom:14px;color:var(--text-muted,#6b7280);letter-spacing:.7px;text-transform:uppercase}
.req{color:#ef4444}
.repeater-row{border:1px solid var(--border,#e5e7eb);border-radius:8px;padding:14px;margin-bottom:10px;background:var(--bg-subtle,#f9fafb)}
.repeater-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
.repeater-num{font-size:11px;font-weight:700;color:var(--text-muted,#6b7280);text-transform:uppercase;letter-spacing:.4px}
.btn-remove{background:#fee2e2;color:#dc2626;border:none;border-radius:5px;width:26px;height:26px;cursor:pointer;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center}
.btn-remove:hover{background:#fca5a5}
.btn-add{background:transparent;border:1px solid var(--border,#e5e7eb);color:var(--text,#374151);border-radius:6px;padding:5px 12px;font-size:12px;font-weight:600;cursor:pointer}
.btn-add:hover{background:var(--bg-subtle,#f3f4f6)}
.btn-browse{background:#f3f4f6;border:1px solid #e5e7eb;border-radius:6px;padding:6px 10px;cursor:pointer;font-size:14px;flex-shrink:0;transition:background .15s;white-space:nowrap}
.btn-browse:hover{background:#e5e7eb}
.img-thumb-wrap img{max-width:100%;display:block}
.upload-divider{font-size:11px;color:var(--text-muted,#9ca3af);text-align:center;margin:8px 0;letter-spacing:.3px}
.browser-item{border:2px solid transparent;border-radius:8px;overflow:hidden;cursor:pointer;transition:border-color .15s,transform .1s;background:#f9fafb;position:relative}
.browser-item:hover{border-color:#93c5fd;transform:scale(1.02)}
.browser-item.selected{border-color:#1d4ed8;box-shadow:0 0 0 3px rgba(29,78,216,.15)}
.browser-item img{width:100%;height:90px;object-fit:cover;display:block}
.browser-item-name{font-size:10px;color:#6b7280;padding:4px 6px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;background:#fff;border-top:1px solid #f3f4f6}
.browser-item-check{position:absolute;top:5px;right:5px;width:20px;height:20px;background:#1d4ed8;border-radius:50%;display:none;align-items:center;justify-content:center;color:#fff;font-size:11px;font-weight:700}
.browser-item.selected .browser-item-check{display:flex}
</style>

{{-- ═══════════ SCRIPTS ═══════════ --}}
<script>
// ── Upload previews ───────────────────────────────────
document.getElementById('img-file-input').addEventListener('change', function() {
  if (this.files && this.files[0]) {
    document.getElementById('main-img-preview').src = URL.createObjectURL(this.files[0]);
    document.getElementById('main-upload-preview').style.display = '';
  }
});

// ── Featured toggle ───────────────────────────────────
document.getElementById('cb_featured').addEventListener('change', function() {
  document.getElementById('featured-fields').style.display = this.checked ? '' : 'none';
});

// ── Preview từ URL ────────────────────────────────────
function previewFromUrl(input, wrapId) {
  var val = (typeof input === 'string') ? input : input.value.trim();
  var wrap = document.getElementById(wrapId);
  if (!wrap) return;
  var img = wrap.querySelector('img');
  if (!img) return;
  if (val) {
    img.src = val.match(/^https?:\/\//) ? val : '/' + val;
    wrap.style.display = '';
  } else {
    wrap.style.display = 'none';
  }
}

function previewFeatureImg(input, wrapId) {
  if (input.files && input.files[0]) {
    var wrap = document.getElementById(wrapId);
    wrap.querySelector('img').src = URL.createObjectURL(input.files[0]);
    wrap.style.display = '';
  }
}
function previewGalleryImg(input, wrapId, urlInputId) {
  if (input.files && input.files[0]) {
    var wrap = document.getElementById(wrapId);
    wrap.querySelector('img').src = URL.createObjectURL(input.files[0]);
    wrap.style.display = '';
    if (urlInputId) document.getElementById(urlInputId).value = '';
  }
}
function previewColorImg(input, wrapId, urlInputId) {
  if (input.files && input.files[0]) {
    var wrap = document.getElementById(wrapId);
    wrap.querySelector('img').src = URL.createObjectURL(input.files[0]);
    wrap.style.display = '';
    if (urlInputId) document.getElementById(urlInputId).value = '';
  }
}
function syncHex(picker, hexId) { document.getElementById(hexId).value = picker.value; }
function removeRow(id) { var el = document.getElementById(id); if (el) el.remove(); }

/* ══════════════════════════════════════════
   IMAGE BROWSER
══════════════════════════════════════════ */
var _bTarget  = null;
var _bPreview = null;
var _bFiles   = [];
var _bSel     = null;

function openBrowser(folder, inputId, previewWrapId) {
  _bTarget  = inputId;
  _bPreview = previewWrapId;
  _bSel     = null;
  var modal = document.getElementById('img-browser-modal');
  modal.style.display = 'flex';
  document.body.style.overflow = 'hidden';
  document.getElementById('browser-folder-select').value = folder;
  document.getElementById('browser-search').value = '';
  document.getElementById('browser-selected-path').textContent = '';
  var btn = document.getElementById('browser-confirm-btn');
  btn.style.opacity = '.35'; btn.style.pointerEvents = 'none';
  browserLoadFolder(folder);
}

function closeBrowser() {
  document.getElementById('img-browser-modal').style.display = 'none';
  document.body.style.overflow = '';
}

function browserLoadFolder(folder) {
  document.getElementById('browser-grid').innerHTML =
    '<div style="grid-column:1/-1;text-align:center;padding:48px;color:#9ca3af;font-size:13px">Đang tải…</div>';
  document.getElementById('browser-count').textContent = '';
  _bSel = null;

  fetch('{{ route("admin.cars.imageBrowser") }}?folder=' + folder)
    .then(function(r) { return r.json(); })
    .then(function(files) { _bFiles = files; browserRender(files); })
    .catch(function() {
      document.getElementById('browser-grid').innerHTML =
        '<div style="grid-column:1/-1;text-align:center;padding:48px;color:#ef4444;font-size:13px">Không tải được danh sách ảnh.</div>';
    });
}

function browserFilter(q) {
  browserRender(_bFiles.filter(function(f) {
    return f.name.toLowerCase().includes(q.toLowerCase());
  }));
}

function browserRender(files) {
  var grid = document.getElementById('browser-grid');
  document.getElementById('browser-count').textContent = files.length + ' ảnh';
  if (!files.length) {
    grid.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:48px;color:#9ca3af;font-size:13px">Không có ảnh nào trong thư mục này.</div>';
    return;
  }
  grid.innerHTML = '';
  files.forEach(function(file) {
    var div = document.createElement('div');
    div.className = 'browser-item';
    div.dataset.path = file.path;
    div.innerHTML =
      '<img src="' + file.url + '" loading="lazy" onerror="this.style.background=\'#eee\';this.style.height=\'60px\'">' +
      '<div class="browser-item-name" title="' + file.name + '">' + file.name + '</div>' +
      '<div class="browser-item-check">✓</div>';
    div.addEventListener('click', function() {
      document.querySelectorAll('.browser-item').forEach(function(el) { el.classList.remove('selected'); });
      div.classList.add('selected');
      _bSel = file.path;
      document.getElementById('browser-selected-path').textContent = file.path;
      var btn = document.getElementById('browser-confirm-btn');
      btn.style.opacity = '1'; btn.style.pointerEvents = 'auto';
    });
    div.addEventListener('dblclick', confirmBrowser);
    grid.appendChild(div);
  });
}

function confirmBrowser() {
  if (!_bSel) return;
  if (_bTarget) {
    var inp = document.getElementById(_bTarget);
    if (inp) { inp.value = _bSel; inp.dispatchEvent(new Event('input')); }
  }
  if (_bPreview) {
    var wrap = document.getElementById(_bPreview);
    if (wrap) {
      var img = wrap.querySelector('img');
      if (img) img.src = '/' + _bSel;
      wrap.style.display = '';
    }
  }
  closeBrowser();
}

document.getElementById('img-browser-modal').addEventListener('click', function(e) {
  if (e.target === this) closeBrowser();
});
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeBrowser(); });

/* ══════════════════════════════════════════
   REPEATERS
══════════════════════════════════════════ */
var variantIdx = {{ $car->variants->count() ?: 1 }};
function addVariant() {
  var i = variantIdx++;
  document.getElementById('variants-list').insertAdjacentHTML('beforeend', `
  <div class="repeater-row" id="variant-${i}">
    <div class="repeater-header"><span class="repeater-num">Phiên bản #${i+1}</span><button type="button" class="btn-remove" onclick="removeRow('variant-${i}')">✕</button></div>
    <div class="form-row" style="margin-bottom:0">
      <div class="form-group" style="margin-bottom:0"><label class="form-label">Tên phiên bản <span class="req">*</span></label><input class="form-control" name="variants[${i}][name]" placeholder="VD: Plus, Pro…"></div>
      <div class="form-group" style="margin-bottom:0"><label class="form-label">Giá bán (VNĐ)</label><input class="form-control" type="number" name="variants[${i}][price]" min="0"></div>
    </div>
    <input type="hidden" name="variants[${i}][sort_order]" value="${i}">
  </div>`);
}

var specIdx = {{ $car->specs->count() ?: 1 }};
function addSpec() {
  var i = specIdx++;
  document.getElementById('specs-list').insertAdjacentHTML('beforeend', `
  <div class="repeater-row" id="spec-${i}">
    <div class="repeater-header"><span class="repeater-num">Thông số #${i+1}</span><button type="button" class="btn-remove" onclick="removeRow('spec-${i}')">✕</button></div>
    <div class="form-row">
      <div class="form-group"><label class="form-label">Danh mục <span class="req">*</span></label><input class="form-control" name="specs[${i}][category]" placeholder="VD: Kích thước"></div>
      <div class="form-group"><label class="form-label">Tên thông số <span class="req">*</span></label><input class="form-control" name="specs[${i}][spec_key]" placeholder="VD: Chiều dài"></div>
      <div class="form-group"><label class="form-label">Giá trị <span class="req">*</span></label><input class="form-control" name="specs[${i}][spec_value]" placeholder="VD: 4626 mm"></div>
    </div>
    <div class="form-row" style="margin-bottom:0">
      <div class="form-group" style="margin-bottom:0"><label class="form-label">Thứ tự danh mục</label><input class="form-control" type="number" name="specs[${i}][category_order]" value="0" style="width:80px"></div>
      <div class="form-group" style="margin-bottom:0"><label class="form-label">Thứ tự trong danh mục</label><input class="form-control" type="number" name="specs[${i}][sort_order]" value="${i}" style="width:80px"></div>
    </div>
  </div>`);
}

var featureIdx = {{ $car->features->count() ?: 1 }};
function addFeature() {
  var i = featureIdx++;
  document.getElementById('features-list').insertAdjacentHTML('beforeend', `
  <div class="repeater-row" id="feature-${i}">
    <div class="repeater-header"><span class="repeater-num">Tính năng #${i+1}</span><button type="button" class="btn-remove" onclick="removeRow('feature-${i}')">✕</button></div>
    <div class="form-row"><div class="form-group"><label class="form-label">Tiêu đề <span class="req">*</span></label><input class="form-control" name="features[${i}][title]" placeholder="VD: Nội thất VF 9"></div></div>
    <div class="form-group"><label class="form-label">Mô tả</label><textarea class="form-control" name="features[${i}][description]" rows="2" placeholder="Mô tả…"></textarea></div>
    <div class="form-row" style="margin-bottom:0">
      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Ảnh chính <span class="req">*</span></label>
        <input type="file" class="form-control" name="feature_images[${i}]" accept="image/*" onchange="previewFeatureImg(this,'fp${i}')">
        <div id="fp${i}" class="img-thumb-wrap" style="display:none;margin-top:8px"><img style="height:80px;border-radius:6px;object-fit:cover;"></div>
        <input type="hidden" name="features[${i}][image]" id="fi${i}">
      </div>
      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Ảnh phụ</label>
        <input type="file" class="form-control" name="feature_images2[${i}]" accept="image/*" onchange="previewFeatureImg(this,'fp2${i}')">
        <div id="fp2${i}" class="img-thumb-wrap" style="display:none;margin-top:8px"><img style="height:80px;border-radius:6px;object-fit:cover;"></div>
        <input type="hidden" name="features[${i}][image2]" id="fi2${i}">
      </div>
    </div>
    <input type="hidden" name="features[${i}][sort_order]" value="${i}">
  </div>`);
}

var galleryIdx = {{ $car->galleries->count() ?: 1 }};
function addGallery() {
  var i = galleryIdx++;
  document.getElementById('gallery-list').insertAdjacentHTML('beforeend', `
  <div class="repeater-row" id="gallery-${i}">
    <div class="repeater-header"><span class="repeater-num">Ảnh #${i+1}</span><button type="button" class="btn-remove" onclick="removeRow('gallery-${i}')">✕</button></div>
    <div class="form-row" style="margin-bottom:6px;align-items:flex-end">
      <div class="form-group" style="margin-bottom:0;flex:2">
        <label class="form-label">Đường dẫn ảnh</label>
        <div style="display:flex;gap:6px">
          <input class="form-control" name="galleries[${i}][file_path]" id="gpath${i}" placeholder="images/car/..." oninput="previewFromUrl(this,'gp${i}')">
          <button type="button" class="btn-browse" onclick="openBrowser('car','gpath${i}','gp${i}')" title="Chọn từ thư mục">📁</button>
        </div>
      </div>
      <div class="form-group" style="margin-bottom:0;flex:1">
        <label class="form-label">Chú thích</label>
        <input class="form-control" name="galleries[${i}][caption]" placeholder="Chú thích…">
      </div>
    </div>
    <div class="upload-divider">— hoặc upload file mới —</div>
    <input type="file" class="form-control" name="gallery_files[${i}]" accept="image/*" onchange="previewGalleryImg(this,'gp${i}','gpath${i}')">
    <div class="form-hint" style="margin-top:4px">Upload sẽ lưu vào public/images/car/</div>
    <div id="gp${i}" class="img-thumb-wrap" style="display:none;margin-top:8px"><img style="height:80px;border-radius:6px;object-fit:cover;"></div>
    <input type="hidden" name="galleries[${i}][type]" value="image">
    <input type="hidden" name="galleries[${i}][sort_order]" value="${i}">
  </div>`);
}

var colorIdx = {{ $car->colors->count() ?: 1 }};
function addColor() {
  var i = colorIdx++;
  document.getElementById('colors-list').insertAdjacentHTML('beforeend', `
  <div class="repeater-row" id="color-${i}">
    <div class="repeater-header"><span class="repeater-num">Màu #${i+1}</span><button type="button" class="btn-remove" onclick="removeRow('color-${i}')">✕</button></div>
    <div class="form-row">
      <div class="form-group"><label class="form-label">Tên màu <span class="req">*</span></label><input class="form-control" name="colors[${i}][name]" placeholder="VD: Trắng, Đen…"></div>
      <div class="form-group">
        <label class="form-label">Mã HEX</label>
        <div style="display:flex;gap:8px;align-items:center">
          <input type="color" value="#000000" oninput="syncHex(this,'hex${i}')" style="width:40px;height:36px;border:1px solid var(--border);border-radius:6px;cursor:pointer;padding:2px;flex-shrink:0">
          <input class="form-control" id="hex${i}" name="colors[${i}][hex_code]" placeholder="#000000" style="flex:1">
        </div>
      </div>
    </div>
    <div class="form-row" style="margin-bottom:0;align-items:flex-start">
      <div class="form-group" style="margin-bottom:0;flex:2">
        <label class="form-label">Đường dẫn ảnh xe màu này</label>
        <div style="display:flex;gap:6px;margin-bottom:6px">
          <input class="form-control" name="colors[${i}][image]" id="cimg${i}" placeholder="images/car/..." oninput="previewFromUrl(this,'cp${i}')">
          <button type="button" class="btn-browse" onclick="openBrowser('car','cimg${i}','cp${i}')" title="Chọn từ thư mục">📁</button>
        </div>
        <div id="cp${i}" class="img-thumb-wrap" style="display:none"><img style="height:80px;border-radius:6px;object-fit:cover;"></div>
        <div class="upload-divider">— hoặc upload file mới —</div>
        <input type="file" class="form-control" name="color_images[${i}]" accept="image/*" onchange="previewColorImg(this,'cp${i}','cimg${i}')">
        <div class="form-hint" style="margin-top:4px">Upload lưu vào public/images/colors/ · .png trong suốt tốt hơn</div>
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