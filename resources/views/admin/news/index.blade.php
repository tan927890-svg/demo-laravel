{{-- resources/views/admin/news/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Tin tức')

@section('topbar-actions')
  <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-sm">＋ Thêm bài viết</a>
@endsection

@section('content')

@if(session('success'))
  <div class="alert alert-success" style="margin-bottom:16px">{{ session('success') }}</div>
@endif

<div class="card">
  <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between">
    <span style="font-weight:600">Danh sách bài viết</span>
    <form method="GET" style="display:flex;gap:8px">
      <input class="form-control" name="search" value="{{ request('search') }}" placeholder="Tìm tiêu đề..." style="width:220px">
      <select class="form-control" name="status" style="width:140px" onchange="this.form.submit()">
        <option value="">Tất cả</option>
        <option value="published" {{ request('status') == 'published' ? 'selected':'' }}>Đã đăng</option>
        <option value="draft"     {{ request('status') == 'draft'     ? 'selected':'' }}>Nháp</option>
      </select>
      <button class="btn btn-primary btn-sm" type="submit">Lọc</button>
    </form>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Tiêu đề</th>
        <th>Danh mục</th>
        <th>Trạng thái</th>
        <th>Ngày đăng</th>
        <th style="text-align:right">Thao tác</th>
      </tr>
    </thead>
    <tbody>
      @forelse($news as $i => $item)
      <tr>
        <td style="color:var(--text-muted)">{{ $news->firstItem() + $i }}</td>
        <td>
          <div style="font-weight:600">{{ $item->title }}</div>
          <div style="font-size:12px;color:var(--text-muted)">{{ $item->slug }}</div>
        </td>
        <td>{{ $item->category->name ?? '—' }}</td>
        <td>
          @if($item->status === 'published')
            <span class="badge badge-success">Đã đăng</span>
          @elseif($item->status === 'draft')
            <span class="badge badge-gray">Nháp</span>
          @else
            <span class="badge badge-warning">Hẹn giờ</span>
          @endif
        </td>
        <td style="color:var(--text-muted)">
          {{ $item->published_at ? $item->published_at->format('d/m/Y') : '—' }}
        </td>
        <td style="text-align:right">
          <div style="display:flex;gap:6px;justify-content:flex-end">
            <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm">Sửa</a>
            <form method="POST" action="{{ route('admin.news.destroy', $item) }}" onsubmit="return confirm('Xóa bài viết này?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger" type="submit">Xóa</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" style="text-align:center;padding:40px;color:var(--text-muted)">Chưa có bài viết nào.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  @if($news->hasPages())
  <div style="padding:16px 20px;border-top:1px solid var(--border)">
    {{ $news->withQueryString()->links() }}
  </div>
  @endif
</div>

@endsection