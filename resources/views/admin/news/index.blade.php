{{-- resources/views/admin/news/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Quản Lý Tin Tức')

@section('content')
<div style="padding:32px">

  {{-- Header --}}
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px">
    <div>
      <h1 style="font-family:'Bebas Neue';font-size:32px;letter-spacing:2px;color:#f0ebe4">
        QUẢN LÝ TIN TỨC
      </h1>
      <p style="font-size:12px;color:#666;margin-top:4px">
        Tổng: {{ $newsList->total() }} bài viết
      </p>
    </div>
    <div style="display:flex;gap:10px">
      <a href="{{ route('admin.news.categories') }}"
         style="background:#1a1a1a;border:1px solid #333;color:#888;padding:10px 20px;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;text-decoration:none">
        CHUYÊN MỤC
      </a>
      <a href="{{ route('admin.news.tags') }}"
         style="background:#1a1a1a;border:1px solid #333;color:#888;padding:10px 20px;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;text-decoration:none">
        TAGS
      </a>
      <a href="{{ route('admin.news.create') }}"
         style="background:#E8192C;color:#fff;padding:10px 24px;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;text-decoration:none">
        + TẠO BÀI VIẾT
      </a>
    </div>
  </div>

  {{-- Alert --}}
  @if(session('success'))
    <div style="background:rgba(232,25,44,.1);border:1px solid rgba(232,25,44,.3);color:#f0ebe4;padding:12px 16px;font-size:13px;margin-bottom:20px">
      {{ session('success') }}
    </div>
  @endif

  {{-- Filter --}}
  <form method="GET" style="display:flex;gap:10px;margin-bottom:20px">
    <input type="text" name="q" value="{{ request('q') }}"
           placeholder="Tìm tiêu đề..."
           style="background:#141414;border:1px solid #2a2a2a;color:#f0ebe4;padding:10px 16px;font-size:13px;font-family:'Barlow',sans-serif;outline:none;flex:1">
    <select name="status"
            style="background:#141414;border:1px solid #2a2a2a;color:#888;padding:10px 16px;font-size:13px;font-family:'Barlow',sans-serif;outline:none">
      <option value="">Tất cả trạng thái</option>
      <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Đã xuất bản</option>
      <option value="draft"     {{ request('status') === 'draft'     ? 'selected' : '' }}>Bản nháp</option>
    </select>
    <select name="category"
            style="background:#141414;border:1px solid #2a2a2a;color:#888;padding:10px 16px;font-size:13px;font-family:'Barlow',sans-serif;outline:none">
      <option value="">Tất cả chuyên mục</option>
      @foreach($categories as $cat)
        <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
          {{ $cat->name }}
        </option>
      @endforeach
    </select>
    <button type="submit"
            style="background:#E8192C;color:#fff;border:none;padding:10px 20px;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;cursor:pointer">
      LỌC
    </button>
    <a href="{{ route('admin.news.index') }}"
       style="background:#222;color:#888;padding:10px 18px;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;text-decoration:none;display:flex;align-items:center">
      XÓA LỌC
    </a>
  </form>

  {{-- Table --}}
  <div style="background:#111;border:1px solid #1c1c1c;overflow:hidden">
    <table style="width:100%;border-collapse:collapse">
      <thead>
        <tr style="background:#141414;border-bottom:1px solid #1c1c1c">
          <th style="padding:14px 20px;text-align:left;font-size:10px;font-weight:700;letter-spacing:2px;color:#555;text-transform:uppercase">BÀI VIẾT</th>
          <th style="padding:14px 20px;text-align:left;font-size:10px;font-weight:700;letter-spacing:2px;color:#555;text-transform:uppercase">CHUYÊN MỤC</th>
          <th style="padding:14px 20px;text-align:center;font-size:10px;font-weight:700;letter-spacing:2px;color:#555;text-transform:uppercase">LƯỢT XEM</th>
          <th style="padding:14px 20px;text-align:center;font-size:10px;font-weight:700;letter-spacing:2px;color:#555;text-transform:uppercase">TRẠNG THÁI</th>
          <th style="padding:14px 20px;text-align:left;font-size:10px;font-weight:700;letter-spacing:2px;color:#555;text-transform:uppercase">NGÀY</th>
          <th style="padding:14px 20px;text-align:center;font-size:10px;font-weight:700;letter-spacing:2px;color:#555;text-transform:uppercase">THAO TÁC</th>
        </tr>
      </thead>
      <tbody>
        @forelse($newsList as $news)
        <tr style="border-bottom:1px solid #1a1a1a;transition:background .15s" onmouseover="this.style.background='#141414'" onmouseout="this.style.background=''">
          {{-- Bài viết --}}
          <td style="padding:16px 20px;max-width:360px">
            <div style="display:flex;align-items:center;gap:14px">
              @if($news->thumbnail)
                <img src="{{ asset('storage/' . $news->thumbnail) }}"
                     style="width:72px;height:48px;object-fit:cover;flex-shrink:0">
              @else
                <div style="width:72px;height:48px;background:#1a1a1a;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                  <span style="font-size:9px;color:#333;letter-spacing:1px">NO IMG</span>
                </div>
              @endif
              <div>
                <div style="font-size:13px;font-weight:600;color:#f0ebe4;margin-bottom:4px;line-height:1.3">
                  {{ Str::limit($news->title, 60) }}
                </div>
                <div style="font-size:10px;color:#444;letter-spacing:.5px">
                  {{ $news->slug }}
                </div>
              </div>
            </div>
          </td>

          {{-- Chuyên mục --}}
          <td style="padding:16px 20px">
            <span style="font-size:11px;color:#888;background:#1a1a1a;padding:4px 10px;letter-spacing:1px">
              {{ $news->category->name ?? '—' }}
            </span>
          </td>

          {{-- Lượt xem --}}
          <td style="padding:16px 20px;text-align:center;font-size:13px;color:#888">
            {{ number_format($news->views) }}
          </td>

          {{-- Trạng thái --}}
          <td style="padding:16px 20px;text-align:center">
            <button onclick="toggleStatus({{ $news->id }}, this)"
                    data-id="{{ $news->id }}"
                    style="background:{{ $news->status === 'published' ? 'rgba(34,197,94,.15)' : 'rgba(255,255,255,.05)' }};
                           border:1px solid {{ $news->status === 'published' ? 'rgba(34,197,94,.4)' : '#333' }};
                           color:{{ $news->status === 'published' ? '#4ade80' : '#666' }};
                           padding:5px 12px;font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;cursor:pointer;font-family:'Barlow',sans-serif">
              {{ $news->status === 'published' ? 'PUBLISHED' : 'DRAFT' }}
            </button>
          </td>

          {{-- Ngày --}}
          <td style="padding:16px 20px;font-size:12px;color:#555;white-space:nowrap">
            {{ $news->published_at?->format('d/m/Y') ?? '—' }}
          </td>

          {{-- Thao tác --}}
          <td style="padding:16px 20px;text-align:center">
            <div style="display:flex;gap:6px;justify-content:center">
              <a href="{{ route('news.show', $news->slug) }}" target="_blank"
                 title="Xem"
                 style="background:#1a1a1a;border:1px solid #2a2a2a;color:#666;padding:6px 12px;font-size:10px;font-weight:700;letter-spacing:1px;text-decoration:none;transition:all .2s"
                 onmouseover="this.style.color='#f0ebe4'" onmouseout="this.style.color='#666'">
                XEM
              </a>
              <a href="{{ route('admin.news.edit', $news) }}"
                 style="background:#1a1a1a;border:1px solid #2a2a2a;color:#666;padding:6px 12px;font-size:10px;font-weight:700;letter-spacing:1px;text-decoration:none;transition:all .2s"
                 onmouseover="this.style.color='#f0ebe4'" onmouseout="this.style.color='#666'">
                SỬA
              </a>
              <form method="POST" action="{{ route('admin.news.destroy', $news) }}"
                    onsubmit="return confirm('Xóa bài viết này?')" style="margin:0">
                @csrf
                @method('DELETE')
                <button type="submit"
                        style="background:#1a1a1a;border:1px solid #2a2a2a;color:#666;padding:6px 12px;font-size:10px;font-weight:700;letter-spacing:1px;cursor:pointer;font-family:'Barlow',sans-serif;transition:all .2s"
                        onmouseover="this.style.color='#E8192C';this.style.borderColor='#E8192C'" onmouseout="this.style.color='#666';this.style.borderColor='#2a2a2a'">
                  XÓA
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" style="padding:48px;text-align:center;color:#444;font-size:13px">
            Chưa có bài viết nào. <a href="{{ route('admin.news.create') }}" style="color:#E8192C">Tạo bài viết đầu tiên →</a>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  <div style="margin-top:20px">
    {{ $newsList->links() }}
  </div>

</div>

<script>
function toggleStatus(id, btn) {
  fetch(`/admin/news/${id}/toggle-status`, {
    method: 'PATCH',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      'Accept': 'application/json',
    }
  })
  .then(r => r.json())
  .then(data => {
    const isPublished = data.status === 'published';
    btn.textContent  = isPublished ? 'PUBLISHED' : 'DRAFT';
    btn.style.background    = isPublished ? 'rgba(34,197,94,.15)' : 'rgba(255,255,255,.05)';
    btn.style.borderColor   = isPublished ? 'rgba(34,197,94,.4)'  : '#333';
    btn.style.color         = isPublished ? '#4ade80' : '#666';
  });
}
</script>
@endsection
