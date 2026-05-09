{{-- resources/views/admin/news/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Tin tức')

@section('topbar-actions')
  <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-sm">＋ Thêm bài viết</a>
@endsection

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

.nw-wrap {
    font-family: 'DM Sans', sans-serif;
    padding: 8px 0 32px;
}
.nw-wrap *, .nw-wrap *::before, .nw-wrap *::after { box-sizing: border-box; }

/* ── Alert ── */
.nw-alert {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px; border-radius: 10px;
    font-size: 13.5px; font-weight: 500; margin-bottom: 16px;
    background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d;
}
.nw-alert svg { width: 16px; height: 16px; flex-shrink: 0; }

/* ── Filter bar ── */
.nw-filter {
    display: flex; gap: 8px; flex-wrap: wrap; align-items: center;
    padding: 13px 18px; border-bottom: 1px solid #f0f0f0;
    background: #fafafa;
}
.nw-filter-left {
    display: flex; align-items: center; gap: 8px;
    font-size: 14px; font-weight: 700; color: #111827; flex: 1;
}
.nw-filter-left svg { color: #6366f1; }
.nw-count {
    background: #f3f4f6; border: 1px solid #e5e7eb;
    border-radius: 20px; padding: 2px 9px;
    font-size: 12px; font-weight: 600; color: #6b7280;
}
.nw-filter-right { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }

.nw-search-wrap { position: relative; }
.nw-search-wrap svg {
    position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
    width: 14px; height: 14px; color: #9ca3af; pointer-events: none;
}
.nw-input {
    padding: 8px 12px 8px 32px;
    border: 1.5px solid #e5e7eb; border-radius: 8px;
    font-size: 13.5px; font-family: inherit; color: #111827;
    background: #fff; outline: none; width: 210px;
    transition: border-color .15s;
}
.nw-input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.08); }
.nw-input::placeholder { color: #c4c9d4; }

.nw-select {
    padding: 8px 30px 8px 11px;
    border: 1.5px solid #e5e7eb; border-radius: 8px;
    font-size: 13.5px; font-family: inherit; color: #374151;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 9px center;
    appearance: none; outline: none; cursor: pointer;
    transition: border-color .15s;
}
.nw-select:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.08); }

.nw-btn-filter {
    padding: 8px 15px; background: #111827; color: #fff;
    border: none; border-radius: 8px;
    font-size: 13.5px; font-weight: 600; font-family: inherit; cursor: pointer;
    display: flex; align-items: center; gap: 6px; transition: background .15s;
    white-space: nowrap;
}
.nw-btn-filter:hover { background: #1f2937; }

/* ── Card ── */
.nw-card {
    background: #fff; border: 1px solid #e5e7eb;
    border-radius: 14px; overflow: hidden;
}

/* ── Table ── */
.nw-table { width: 100%; border-collapse: collapse; }
.nw-table thead tr { background: #f8f9fb; border-bottom: 1px solid #e5e7eb; }
.nw-table thead th {
    padding: 10px 16px; font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .55px;
    color: #9ca3af; text-align: left; white-space: nowrap;
}
.nw-table tbody tr { border-bottom: 1px solid #f3f4f6; transition: background .1s; }
.nw-table tbody tr:last-child { border-bottom: none; }
.nw-table tbody tr:hover { background: #fafbff; }
.nw-table td { padding: 13px 16px; vertical-align: middle; }

.nw-num  { font-size: 12px; color: #d1d5db; font-weight: 500; }

/* Title cell */
.nw-title { font-size: 14px; font-weight: 600; color: #111827; line-height: 1.3; }
.nw-slug  { font-size: 11.5px; color: #9ca3af; margin-top: 3px; }

/* Category */
.nw-cat {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: 6px;
    background: #f3f4f6; border: 1px solid #e5e7eb;
    font-size: 12px; font-weight: 500; color: #6b7280;
}

/* Badge */
.nw-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 20px;
    font-size: 12px; font-weight: 600; white-space: nowrap;
}
.nw-badge-dot { width: 6px; height: 6px; border-radius: 50%; }
.nw-badge-published { background: #f0fdf4; color: #15803d; }
.nw-badge-published .nw-badge-dot { background: #22c55e; }
.nw-badge-draft     { background: #f3f4f6; color: #6b7280; }
.nw-badge-draft     .nw-badge-dot { background: #9ca3af; }
.nw-badge-scheduled { background: #fffbeb; color: #d97706; }
.nw-badge-scheduled .nw-badge-dot { background: #f59e0b; }

/* Date */
.nw-date { font-size: 13px; color: #9ca3af; }

/* Actions */
.nw-actions { display: flex; gap: 6px; justify-content: flex-end; align-items: center; }
.nw-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 11px; border-radius: 7px;
    font-size: 12.5px; font-weight: 600; font-family: inherit;
    text-decoration: none; cursor: pointer; transition: all .15s; white-space: nowrap;
    border: 1px solid transparent;
}
.nw-btn svg { width: 13px; height: 13px; }
.nw-btn-edit {
    background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe;
}
.nw-btn-edit:hover { background: #1d4ed8; color: #fff; border-color: #1d4ed8; }
.nw-btn-delete {
    background: #fef2f2; color: #dc2626; border-color: #fecaca;
}
.nw-btn-delete:hover { background: #dc2626; color: #fff; border-color: #dc2626; }

/* Empty */
.nw-empty { text-align: center; padding: 64px 20px; }
.nw-empty-icon {
    width: 54px; height: 54px; background: #f3f4f6; border-radius: 14px;
    display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;
}
.nw-empty-icon svg { width: 26px; height: 26px; color: #d1d5db; }
.nw-empty-title { font-size: 15px; font-weight: 600; color: #374151; margin-bottom: 4px; }
.nw-empty-sub   { font-size: 13px; color: #9ca3af; }

/* Pagination */
.nw-pagination { padding: 14px 18px; border-top: 1px solid #f3f4f6; }

/* Delete modal */
.nw-backdrop {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,.45); backdrop-filter: blur(3px);
    z-index: 9999; align-items: center; justify-content: center;
}
.nw-backdrop.active { display: flex; }
.nw-modal {
    background: #fff; border-radius: 16px;
    padding: 28px 28px 22px; width: 100%; max-width: 380px;
    box-shadow: 0 20px 60px rgba(0,0,0,.18);
    animation: nw-in .18s ease;
}
@keyframes nw-in { from { transform:scale(.95);opacity:0 } to { transform:scale(1);opacity:1 } }
.nw-modal-icon {
    width: 48px; height: 48px; background: #fef2f2; border-radius: 12px;
    display: flex; align-items: center; justify-content: center; margin-bottom: 16px;
}
.nw-modal-icon svg { width: 22px; height: 22px; color: #dc2626; }
.nw-modal-title { font-size: 16px; font-weight: 700; color: #111827; margin-bottom: 6px; }
.nw-modal-desc  { font-size: 13.5px; color: #6b7280; line-height: 1.5; margin-bottom: 22px; }
.nw-modal-desc strong { color: #111827; }
.nw-modal-acts  { display: flex; gap: 8px; justify-content: flex-end; }
.nw-modal-cancel {
    padding: 9px 18px; background: #f3f4f6; color: #374151;
    border: 1px solid #e5e7eb; border-radius: 8px;
    font-size: 13.5px; font-weight: 600; font-family: inherit; cursor: pointer;
    transition: background .15s;
}
.nw-modal-cancel:hover { background: #e5e7eb; }
.nw-modal-ok {
    padding: 9px 18px; background: #dc2626; color: #fff;
    border: none; border-radius: 8px;
    font-size: 13.5px; font-weight: 600; font-family: inherit; cursor: pointer;
    transition: background .15s;
}
.nw-modal-ok:hover { background: #b91c1c; }
</style>

<div class="nw-wrap">

    @if(session('success'))
    <div class="nw-alert">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="nw-card">

        {{-- Filter --}}
        <form method="GET" action="{{ request()->url() }}">
            <div class="nw-filter">
                <div class="nw-filter-left">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                    </svg>
                    Danh sách bài viết
                    <span class="nw-count">{{ $news->total() }} bài</span>
                </div>
                <div class="nw-filter-right">
                    <div class="nw-search-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                        </svg>
                        <input class="nw-input" name="search" value="{{ request('search') }}" placeholder="Tìm tiêu đề...">
                    </div>
                    <select class="nw-select" name="status" onchange="this.form.submit()">
                        <option value="">Tất cả trạng thái</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Đã đăng</option>
                        <option value="draft"     {{ request('status') == 'draft'     ? 'selected' : '' }}>Nháp</option>
                    </select>
                    <button class="nw-btn-filter" type="submit">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                        </svg>
                        Lọc
                    </button>
                </div>
            </div>
        </form>

        {{-- Table --}}
        <table class="nw-table">
            <thead>
                <tr>
                    <th style="width:44px">#</th>
                    <th>Tiêu đề</th>
                    <th>Danh mục</th>
                    <th>Trạng thái</th>
                    <th>Ngày đăng</th>
                    <th style="text-align:right; width:120px">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $i => $item)
                <tr>
                    <td><span class="nw-num">{{ $news->firstItem() + $i }}</span></td>

                    <td>
                        <div class="nw-title">{{ $item->title }}</div>
                        <div class="nw-slug">{{ $item->slug }}</div>
                    </td>

                    <td>
                        @if($item->category)
                            <span class="nw-cat">{{ $item->category->name }}</span>
                        @else
                            <span style="color:#d1d5db">—</span>
                        @endif
                    </td>

                    <td>
                        @if($item->status === 'published')
                            <span class="nw-badge nw-badge-published"><span class="nw-badge-dot"></span>Đã đăng</span>
                        @elseif($item->status === 'draft')
                            <span class="nw-badge nw-badge-draft"><span class="nw-badge-dot"></span>Nháp</span>
                        @else
                            <span class="nw-badge nw-badge-scheduled"><span class="nw-badge-dot"></span>Hẹn giờ</span>
                        @endif
                    </td>

                    <td>
                        <span class="nw-date">
                            {{ $item->published_at ? $item->published_at->format('d/m/Y') : '—' }}
                        </span>
                    </td>

                    <td>
                        <div class="nw-actions">
                            <a href="{{ route('admin.news.edit', $item) }}" class="nw-btn nw-btn-edit">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                                Sửa
                            </a>
                            <button type="button" class="nw-btn nw-btn-delete"
                                    onclick="openDeleteModal('{{ route('admin.news.destroy', $item) }}', '{{ addslashes($item->title) }}')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                    <path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                                </svg>
                                Xóa
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="nw-empty">
                            <div class="nw-empty-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                                </svg>
                            </div>
                            <div class="nw-empty-title">Chưa có bài viết nào</div>
                            <div class="nw-empty-sub">Tạo bài viết đầu tiên bằng nút ở trên</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($news->hasPages())
        <div class="nw-pagination">{{ $news->withQueryString()->links() }}</div>
        @endif

    </div>
</div>

{{-- Delete modal --}}
<div class="nw-backdrop" id="deleteBackdrop">
    <div class="nw-modal">
        <div class="nw-modal-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                <path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
            </svg>
        </div>
        <div class="nw-modal-title">Xác nhận xóa bài viết</div>
        <div class="nw-modal-desc">Bạn có chắc muốn xóa bài viết <strong id="deleteTitle"></strong>? Hành động này không thể hoàn tác.</div>
        <div class="nw-modal-acts">
            <button class="nw-modal-cancel" onclick="closeDeleteModal()">Hủy bỏ</button>
            <form id="deleteForm" method="POST" style="display:contents">
                @csrf @method('DELETE')
                <button type="submit" class="nw-modal-ok">Xóa bài viết</button>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteModal(action, title) {
    document.getElementById('deleteForm').action = action;
    document.getElementById('deleteTitle').textContent = title;
    document.getElementById('deleteBackdrop').classList.add('active');
}
function closeDeleteModal() {
    document.getElementById('deleteBackdrop').classList.remove('active');
}
document.getElementById('deleteBackdrop').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>

@endsection