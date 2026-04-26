{{-- resources/views/admin/news/form.blade.php --}}
@extends('layouts.admin')
@section('page-title', isset($news) ? 'Sửa bài viết' : 'Bài viết mới')
@section('topbar-actions')
  <a href="{{ route('admin.news.index') }}" class="btn btn-sm">← Quay lại</a>
@endsection

@section('content')
<form method="POST"
      action="{{ isset($news) ? route('admin.news.update', $news) : route('admin.news.store') }}"
      enctype="multipart/form-data"
      id="news-form">
  @csrf @if(isset($news)) @method('PUT') @endif

  @if($errors->any())
    <div class="alert alert-error" style="margin-bottom:16px">
      @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
    </div>
  @endif

  <div style="display:grid;grid-template-columns:1fr 300px;gap:18px;align-items:start">

    {{-- CỘT TRÁI --}}
    <div style="display:flex;flex-direction:column;gap:14px">
      <div class="card card-pad">

        <div class="form-group">
          <label class="form-label">Tiêu đề <span style="color:red">*</span></label>
          <input class="form-control" name="title" id="input-title"
                 value="{{ old('title', $news->title ?? '') }}"
                 required placeholder="Tiêu đề bài viết...">
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Slug URL</label>
            <input class="form-control" name="slug" id="input-slug"
                   value="{{ old('slug', $news->slug ?? '') }}"
                   placeholder="tieu-de-bai-viet">
            <div class="form-hint">Để trống sẽ tự tạo</div>
          </div>
          <div class="form-group">
            <label class="form-label">Danh mục</label>
            <select class="form-control" name="news_category_id">
              <option value="">-- Chọn danh mục --</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                  {{ old('news_category_id', $news->news_category_id ?? '') == $cat->id ? 'selected' : '' }}>
                  {{ $cat->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Tóm tắt</label>
          <textarea class="form-control" name="excerpt" rows="2"
                    placeholder="Mô tả ngắn hiển thị trên danh sách...">{{ old('excerpt', $news->excerpt ?? '') }}</textarea>
        </div>

        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Nội dung</label>
          {{--
            QUAN TRỌNG: dùng {!! !!} thay vì {{ }} để không escape HTML.
            Content trong DB chứa thẻ <p>, <strong>... nên {{ }} sẽ hiện raw HTML text.
          --}}
          <textarea class="form-control" name="content" id="content-editor" rows="20"
                    style="font-family:monospace;font-size:13px;line-height:1.7;resize:vertical"
                    placeholder="Nhập nội dung bài viết...">{!! old('content', $news->content ?? '') !!}</textarea>
          <div class="form-hint">Hỗ trợ HTML: &lt;p&gt;, &lt;strong&gt;, &lt;h2&gt;, &lt;ul&gt;, &lt;img&gt;...</div>
        </div>

      </div>
    </div>

    {{-- CỘT PHẢI --}}
    <div style="display:flex;flex-direction:column;gap:14px">

      <div class="card card-pad">
        <div class="form-group">
          <label class="form-label">Trạng thái</label>
          <select class="form-control" name="status">
            <option value="published" {{ old('status', $news->status ?? 'published') == 'published' ? 'selected' : '' }}>Đăng ngay</option>
            <option value="draft"     {{ old('status', $news->status ?? '') == 'draft'     ? 'selected' : '' }}>Lưu nháp</option>
            <option value="scheduled" {{ old('status', $news->status ?? '') == 'scheduled' ? 'selected' : '' }}>Hẹn giờ</option>
          </select>
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Ngày đăng</label>
          <input class="form-control" type="datetime-local" name="published_at"
                 value="{{ old('published_at', isset($news->published_at) ? $news->published_at->format('Y-m-d\TH:i') : '') }}">
        </div>
      </div>

      {{-- ẢNH BÌA --}}
      <div class="card card-pad">
        <div class="form-label" style="margin-bottom:8px;font-weight:600">Ảnh bìa</div>

        <div id="thumbnail-preview"
             style="{{ (isset($news) && !empty($news->thumbnail)) ? '' : 'display:none;' }}margin-bottom:10px">
          <img id="preview-img"
               src="{{ (isset($news) && !empty($news->thumbnail)) ? asset($news->thumbnail) : '' }}"
               alt="Ảnh bìa"
               style="width:100%;height:150px;object-fit:cover;border-radius:8px;border:1px solid #e0e0e0;display:block">
          <button type="button" onclick="clearThumbnail()"
                  style="margin-top:6px;width:100%;background:transparent;border:1px solid #ddd;
                         padding:6px;font-size:12px;cursor:pointer;border-radius:4px;color:#888">
            ✕ Xóa ảnh
          </button>
        </div>

        <input type="hidden" name="remove_thumbnail" id="remove-thumbnail" value="0">

        <div class="form-group" style="margin-bottom:0">
          <label class="form-label" style="font-size:12px;color:#888">
            {{ (isset($news) && !empty($news->thumbnail)) ? 'Thay ảnh mới' : 'Upload ảnh bìa' }}
          </label>
          {{-- Bỏ giới hạn size ở client, controller sẽ tự resize --}}
          <input class="form-control" type="file" name="thumbnail" accept="image/*"
                 id="thumbnail-upload" onchange="previewUpload(this)">
          <div class="form-hint">JPG, PNG, WEBP. Ảnh lớn sẽ tự động nén.</div>
        </div>
      </div>

      <div style="display:flex;gap:8px">
        <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center">
          {{ isset($news) ? 'Cập nhật' : 'Đăng bài' }}
        </button>
        <a href="{{ route('admin.news.index') }}" class="btn" style="justify-content:center">Hủy</a>
      </div>

    </div>
  </div>
</form>

@push('scripts')
<script>
function previewUpload(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('preview-img').src = e.target.result;
      document.getElementById('thumbnail-preview').style.display = 'block';
      document.getElementById('remove-thumbnail').value = '0';
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function clearThumbnail() {
  document.getElementById('preview-img').src = '';
  document.getElementById('thumbnail-preview').style.display = 'none';
  document.getElementById('thumbnail-upload').value = '';
  document.getElementById('remove-thumbnail').value = '1';
}

document.getElementById('input-title').addEventListener('input', function () {
  const slugField = document.getElementById('input-slug');
  if (!slugField.dataset.manual) slugField.value = slugify(this.value);
});
document.getElementById('input-slug').addEventListener('input', function () {
  this.dataset.manual = this.value ? '1' : '';
});
function slugify(str) {
  const map = {
    'à':'a','á':'a','ả':'a','ã':'a','ạ':'a','ă':'a','ằ':'a','ắ':'a','ẳ':'a','ẵ':'a','ặ':'a',
    'â':'a','ầ':'a','ấ':'a','ẩ':'a','ẫ':'a','ậ':'a','đ':'d',
    'è':'e','é':'e','ẻ':'e','ẽ':'e','ê':'e','ề':'e','ế':'e','ể':'e','ễ':'e','ệ':'e',
    'ì':'i','í':'i','ỉ':'i','ĩ':'i','ị':'i',
    'ò':'o','ó':'o','ỏ':'o','õ':'o','ọ':'o','ô':'o','ồ':'o','ố':'o','ổ':'o','ỗ':'o','ộ':'o',
    'ơ':'o','ờ':'o','ớ':'o','ở':'o','ỡ':'o','ợ':'o',
    'ù':'u','ú':'u','ủ':'u','ũ':'u','ụ':'u','ư':'u','ừ':'u','ứ':'u','ử':'u','ữ':'u','ự':'u',
    'ỳ':'y','ý':'y','ỷ':'y','ỹ':'y','ỵ':'y',
  };
  return str.toLowerCase()
    .split('').map(c => map[c] || c).join('')
    .replace(/[^a-z0-9\s-]/g, '').trim()
    .replace(/\s+/g, '-').replace(/-+/g, '-');
}
</script>
@endpush
@endsection