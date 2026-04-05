{{-- resources/views/admin/news/form.blade.php --}}
{{-- Dùng chung cho Create và Edit --}}
@extends('layouts.admin')

@section('title', isset($news) ? 'Sửa Bài Viết' : 'Tạo Bài Viết Mới')

@push('styles')
<style>
.form-group{margin-bottom:22px}
.form-label{display:block;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#555;margin-bottom:8px}
.form-input{width:100%;background:#141414;border:1px solid #2a2a2a;color:#f0ebe4;padding:12px 16px;font-size:14px;font-family:'Barlow',sans-serif;outline:none;transition:border-color .2s}
.form-input:focus{border-color:#E8192C}
.form-input::placeholder{color:#333}
.form-select{width:100%;background:#141414;border:1px solid #2a2a2a;color:#f0ebe4;padding:12px 16px;font-size:14px;font-family:'Barlow',sans-serif;outline:none;cursor:pointer}
.form-textarea{width:100%;background:#141414;border:1px solid #2a2a2a;color:#f0ebe4;padding:12px 16px;font-size:14px;font-family:'Barlow',sans-serif;outline:none;resize:vertical;min-height:120px;transition:border-color .2s}
.form-textarea:focus{border-color:#E8192C}
.form-error{font-size:11px;color:#E8192C;margin-top:5px}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.tag-check{display:inline-flex;align-items:center;gap:6px;background:#141414;border:1px solid #222;padding:7px 14px;cursor:pointer;margin:4px;font-size:11px;font-weight:600;letter-spacing:1px;color:#666;transition:all .2s}
.tag-check:hover{border-color:#E8192C;color:#E8192C}
.tag-check input{accent-color:#E8192C}
</style>
@endpush

@section('content')
<div style="padding:32px;max-width:1000px">

  {{-- Header --}}
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px">
    <div>
      <a href="{{ route('admin.news.index') }}"
         style="font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#555;text-decoration:none;display:inline-flex;align-items:center;gap:6px;margin-bottom:10px">
        ← QUAY LẠI
      </a>
      <h1 style="font-family:'Bebas Neue';font-size:32px;letter-spacing:2px;color:#f0ebe4">
        {{ isset($news) ? 'SỬA BÀI VIẾT' : 'TẠO BÀI VIẾT MỚI' }}
      </h1>
    </div>
  </div>

  <form method="POST"
        action="{{ isset($news) ? route('admin.news.update', $news) : route('admin.news.store') }}"
        enctype="multipart/form-data">
    @csrf
    @isset($news)
      @method('PUT')
    @endisset

    <div style="display:grid;grid-template-columns:1fr 300px;gap:24px;align-items:start">

      {{-- Left Column --}}
      <div>
        {{-- Tiêu đề --}}
        <div class="form-group">
          <label class="form-label">Tiêu Đề *</label>
          <input type="text" name="title" class="form-input"
                 value="{{ old('title', $news->title ?? '') }}"
                 placeholder="Nhập tiêu đề bài viết..."
                 id="titleInput" oninput="autoSlug()">
          @error('title') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        {{-- Slug --}}
        <div class="form-group">
          <label class="form-label">Slug (URL)</label>
          <input type="text" name="slug" class="form-input" id="slugInput"
                 value="{{ old('slug', $news->slug ?? '') }}"
                 placeholder="tu-dong-tao-tu-tieu-de">
          @error('slug') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        {{-- Tóm tắt --}}
        <div class="form-group">
          <label class="form-label">Tóm Tắt (Excerpt)</label>
          <textarea name="excerpt" class="form-textarea" rows="3"
                    placeholder="Mô tả ngắn, hiển thị trong danh sách bài viết (tối đa 160 ký tự)...">{{ old('excerpt', $news->excerpt ?? '') }}</textarea>
          @error('excerpt') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        {{-- Nội dung --}}
        <div class="form-group">
          <label class="form-label">Nội Dung *</label>
          <textarea name="content" class="form-textarea" id="contentEditor" rows="18"
                    placeholder="Viết nội dung bài viết tại đây... (hỗ trợ HTML)">{{ old('content', $news->content ?? '') }}</textarea>
          @error('content') <div class="form-error">{{ $message }}</div> @enderror
          <div style="font-size:11px;color:#444;margin-top:6px">
            💡 Hỗ trợ HTML. Ví dụ: &lt;p&gt;, &lt;h2&gt;, &lt;strong&gt;, &lt;ul&gt;, &lt;img&gt;
          </div>
        </div>
      </div>

      {{-- Right Column --}}
      <div>

        {{-- Publish box --}}
        <div style="background:#111;border:1px solid #1c1c1c;padding:20px;margin-bottom:16px">
          <div class="form-group">
            <label class="form-label">Trạng Thái</label>
            <select name="status" class="form-select">
              <option value="draft"     {{ old('status', $news->status ?? 'draft') === 'draft'     ? 'selected' : '' }}>📝 Bản Nháp</option>
              <option value="published" {{ old('status', $news->status ?? 'draft') === 'published' ? 'selected' : '' }}>✅ Xuất Bản</option>
            </select>
          </div>

          <button type="submit"
                  style="width:100%;background:#E8192C;color:#fff;border:none;padding:14px;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;cursor:pointer;font-family:'Barlow',sans-serif;margin-top:4px">
            {{ isset($news) ? 'CẬP NHẬT BÀI VIẾT' : 'ĐĂNG BÀI VIẾT' }}
          </button>
        </div>

        {{-- Chuyên mục --}}
        <div style="background:#111;border:1px solid #1c1c1c;padding:20px;margin-bottom:16px">
          <div class="form-group" style="margin-bottom:0">
            <label class="form-label">Chuyên Mục</label>
            <select name="news_category_id" class="form-select">
              <option value="">— Chọn chuyên mục —</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                        {{ old('news_category_id', $news->news_category_id ?? '') == $cat->id ? 'selected' : '' }}>
                  {{ $cat->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        {{-- Thumbnail --}}
        <div style="background:#111;border:1px solid #1c1c1c;padding:20px;margin-bottom:16px">
          <label class="form-label">Ảnh Thumbnail</label>
          @isset($news)
            @if($news->thumbnail)
              <img src="{{ asset('storage/' . $news->thumbnail) }}"
                   style="width:100%;height:160px;object-fit:cover;margin-bottom:12px">
            @endif
          @endisset
          <input type="file" name="thumbnail" accept="image/*"
                 style="width:100%;font-size:12px;color:#666;font-family:'Barlow',sans-serif"
                 onchange="previewThumb(this)">
          <img id="thumbPreview" style="width:100%;height:160px;object-fit:cover;margin-top:12px;display:none">
          @error('thumbnail') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        {{-- Tags --}}
        <div style="background:#111;border:1px solid #1c1c1c;padding:20px">
          <label class="form-label">Tags</label>
          <div>
            @php
              $selectedTags = old('tags', isset($news) ? $news->tags->pluck('id')->toArray() : []);
            @endphp
            @foreach($tags as $tag)
              <label class="tag-check">
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                       {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }}>
                {{ $tag->name }}
              </label>
            @endforeach
          </div>
        </div>

      </div>
    </div>
  </form>

</div>

<script>
// Auto-generate slug từ title
let slugEdited = false;
document.getElementById('slugInput').addEventListener('input', () => { slugEdited = true; });

function autoSlug() {
  if (slugEdited) return;
  const title = document.getElementById('titleInput').value;
  const slug = title
    .toLowerCase()
    .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
    .replace(/đ/g, 'd').replace(/[^a-z0-9\s-]/g, '')
    .trim().replace(/\s+/g, '-');
  document.getElementById('slugInput').value = slug;
}

// Preview thumbnail
function previewThumb(input) {
  const preview = document.getElementById('thumbPreview');
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => {
      preview.src = e.target.result;
      preview.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
@endsection
