@extends('layouts.admin')

@section('page-title', 'Chi tiết xe: ' . $car->name)

@section('topbar-actions')
  <a href="{{ route('admin.cars.index') }}" class="btn btn-sm">← Quay lại</a>
  @if(Auth::user()->canManageStaff())
    <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-sm btn-primary">Chỉnh sửa</a>
  @endif
@endsection

@section('content')
<div style="display:grid;grid-template-columns:1fr 340px;gap:18px;align-items:start">

  {{-- ══ LEFT ══ --}}
  <div style="display:flex;flex-direction:column;gap:14px">

    {{-- THÔNG TIN CƠ BẢN --}}
    <div class="card card-pad">
      <div style="font-size:13px;font-weight:600;margin-bottom:14px;color:var(--text-2);letter-spacing:.3px">THÔNG TIN CƠ BẢN</div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Tên xe</label>
          <div class="form-control" style="background:var(--bg);color:var(--text)">{{ $car->name }}</div>
        </div>
        <div class="form-group">
          <label class="form-label">Thương hiệu</label>
          <div class="form-control" style="background:var(--bg);color:var(--text)">{{ $car->brand->name ?? '—' }}</div>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Giá bán (VNĐ)</label>
          <div class="form-control" style="background:var(--bg);color:var(--text)">
            {{ number_format($car->price_per_day, 0, ',', '.') }}đ
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Năm sản xuất</label>
          <div class="form-control" style="background:var(--bg);color:var(--text)">{{ $car->year ?? '—' }}</div>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Số chỗ ngồi</label>
          <div class="form-control" style="background:var(--bg);color:var(--text)">{{ $car->seats ? $car->seats . ' chỗ' : '—' }}</div>
        </div>
        <div class="form-group">
          <label class="form-label">Loại nhiên liệu</label>
          <div class="form-control" style="background:var(--bg);color:var(--text)">{{ $car->fuel_type ?? '—' }}</div>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Mô tả ngắn</label>
        <div class="form-control" style="background:var(--bg);color:var(--text);min-height:72px;white-space:pre-wrap">{{ $car->description ?? '—' }}</div>
      </div>

      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Nội dung chi tiết</label>
        <div class="form-control" style="background:var(--bg);color:var(--text);min-height:160px;white-space:pre-wrap">{{ $car->content ?? '—' }}</div>
      </div>
    </div>

    {{-- THÔNG SỐ KỸ THUẬT --}}
    <div class="card card-pad">
      <div style="font-size:13px;font-weight:600;margin-bottom:14px;color:var(--text-2);letter-spacing:.3px">THÔNG SỐ KỸ THUẬT</div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Động cơ</label>
          <div class="form-control" style="background:var(--bg);color:var(--text)">{{ $car->engine ?? '—' }}</div>
        </div>
        <div class="form-group">
          <label class="form-label">Hộp số</label>
          <div class="form-control" style="background:var(--bg);color:var(--text)">{{ $car->transmission ?? '—' }}</div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Công suất (HP)</label>
          <div class="form-control" style="background:var(--bg);color:var(--text)">{{ $car->horsepower ?? '—' }}</div>
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Mức tiêu thụ (L/100km)</label>
          <div class="form-control" style="background:var(--bg);color:var(--text)">{{ $car->fuel_consumption ?? '—' }}</div>
        </div>
      </div>
    </div>

  </div>

  {{-- ══ RIGHT ══ --}}
  <div style="display:flex;flex-direction:column;gap:14px">

    {{-- TRẠNG THÁI --}}
    <div class="card card-pad">
      <div style="font-size:13px;font-weight:600;margin-bottom:14px;color:var(--text-2);letter-spacing:.3px">TRẠNG THÁI</div>
      <div class="form-group">
        <label class="form-label">Trạng thái hàng</label>
        <div>
          @if($car->status === 'available')
            <span class="badge badge-green">Còn hàng</span>
          @elseif($car->status === 'out_of_stock')
            <span class="badge badge-red">Hết hàng</span>
          @else
            <span class="badge badge-amber">Sắp ra mắt</span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Xe nổi bật</label>
        <div>
          @if($car->is_featured)
            <span class="badge badge-purple">⭐ Nổi bật</span>
          @else
            <span class="badge badge-gray">Không</span>
          @endif
        </div>
      </div>

      @if($car->is_featured)
        @if($car->badge_label)
        <div class="form-group">
          <label class="form-label">Nhãn badge</label>
          <div class="form-control" style="background:var(--bg);color:var(--text)">{{ $car->badge_label }}</div>
        </div>
        @endif
        @if($car->image_360_prefix)
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Prefix ảnh 360°</label>
          <div class="form-control" style="background:var(--bg);color:var(--text)">{{ $car->image_360_prefix }}</div>
        </div>
        @endif
      @endif
    </div>

    {{-- ẢNH ĐẠI DIỆN --}}
    <div class="card card-pad">
      <div style="font-size:13px;font-weight:600;margin-bottom:14px;color:var(--text-2);letter-spacing:.3px">ẢNH ĐẠI DIỆN</div>
      @if($car->image_url)
        <img src="{{ asset($car->image_url) }}"
             style="width:100%;height:160px;object-fit:contain;border-radius:8px;border:1px solid var(--border);background:#f8f8f8"
             onerror="this.style.opacity='.2'">
        <div class="form-hint" style="margin-top:8px">{{ $car->image_url }}</div>
      @else
        <div style="text-align:center;color:var(--text-3);padding:40px 0;font-size:13px">Chưa có ảnh</div>
      @endif
    </div>

    {{-- SEO --}}
    <div class="card card-pad">
      <div style="font-size:13px;font-weight:600;margin-bottom:14px;color:var(--text-2);letter-spacing:.3px">SEO</div>
      <div class="form-group">
        <label class="form-label">Slug URL</label>
        <div class="form-control" style="background:var(--bg);color:var(--text)">{{ $car->slug ?? '—' }}</div>
      </div>
      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Meta description</label>
        <div class="form-control" style="background:var(--bg);color:var(--text);min-height:60px;white-space:pre-wrap">{{ $car->meta_description ?? '—' }}</div>
      </div>
    </div>

  </div>
</div>
@endsection