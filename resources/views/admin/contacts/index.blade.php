@extends('layouts.admin')
@section('page-title', 'Liên hệ từ khách hàng')

@section('topbar-actions')
  @if($unreadCount > 0)
  <form method="POST" action="{{ route('admin.contacts.markAllRead') }}" style="display:inline">
    @csrf
    <button type="submit" class="btn btn-sm">✓ Đánh dấu tất cả đã đọc</button>
  </form>
  @endif
@endsection

@push('styles')
<style>
/* ── Tabs ── */
.contact-tabs { display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap; }
.ctab {
    padding:8px 18px; border-radius:8px; border:1px solid #e5e7eb;
    font-size:14px; text-decoration:none; color:#374151;
    background:#fff; cursor:pointer; display:flex; align-items:center; gap:6px;
    transition: all .15s;
}
.ctab:hover { background:#f3f4f6; }
.ctab.active { background:#1d4ed8; color:#fff; border-color:#1d4ed8; }

/* ── Stats ── */
.stat-mini {
    background:#fff; border:1px solid #e5e7eb; border-radius:10px;
    padding:10px 14px; flex:1; min-width:140px;
}
.stat-mini .num { font-size:22px; font-weight:700; line-height:1; margin-bottom:4px; }
.stat-mini .lbl { font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:#9ca3af; }

/* ── Table ── */
.contact-thead {
    display:grid;
    grid-template-columns: 12px 220px 1fr 100px 110px 160px 180px;
    gap:16px; padding:9px 16px;
    font-size:10.5px; font-weight:700; color:#6b7280;
    letter-spacing:.5px; text-transform:uppercase;
    border-bottom:1px solid #e5e7eb; background:#f9fafb;
}
.contact-row {
    display:grid;
    grid-template-columns: 12px 220px 1fr 100px 110px 160px 180px;
    gap:16px; align-items:center; padding:10px 16px;
    border-bottom:1px solid #f3f4f6; transition: background .1s;
}
.contact-row:hover { background:#fafafa; }
.contact-row.unread { background:#fffbeb; }
.contact-row.unread:hover { background:#fef3c7; }

/* ── Tags ── */
.tag {
    display:inline-block;
    font-size:11px; font-weight:700; padding:3px 9px; border-radius:20px;
    letter-spacing:.4px; text-transform:uppercase; white-space:nowrap;
}
.tag-baogianhanh { background:#fef3c7; color:#92400e; }
.tag-datlich     { background:#dbeafe; color:#1e40af; }
.tag-baoduong    { background:#d1fae5; color:#065f46; }
.tag-nhangiao    { background:#ede9fe; color:#5b21b6; }
.tag-lienhe      { background:#f3f4f6; color:#374151; }

/* ── Dots ── */
.unread-dot { width:8px; height:8px; border-radius:50%; background:#1d4ed8; flex-shrink:0; }
.read-dot   { width:8px; height:8px; border-radius:50%; background:#d1d5db; flex-shrink:0; }

/* ── Action buttons ── */
.action-btns { display:flex; gap:5px; justify-content:flex-end; flex-wrap:nowrap; }
.action-btns .btn { font-size:12px; padding:5px 10px; white-space:nowrap; }
</style>
@endpush

@section('content')

@if(session('success'))
  <div class="alert alert-success" style="margin-bottom:12px">{{ session('success') }}</div>
@endif

{{-- Stats --}}
<div style="display:flex;gap:8px;margin-bottom:12px;flex-wrap:wrap">
  <div class="stat-mini">
    <div class="num">{{ $contacts->total() }}</div>
    <div class="lbl">Tổng liên hệ</div>
  </div>
  <div class="stat-mini">
    <div class="num" style="color:#1d4ed8">{{ $unreadCount }}</div>
    <div class="lbl">Chưa đọc</div>
  </div>
  <div class="stat-mini">
    <div class="num" style="color:#16a34a">{{ $contacts->total() - $unreadCount }}</div>
    <div class="lbl">Đã đọc</div>
  </div>
</div>

{{-- Category Tabs --}}
@php
  $categories = [
    ''           => ['label' => 'Tất cả',        'icon' => '📋'],
    'baogianhanh'=> ['label' => 'Báo giá nhanh', 'icon' => '💰'],
    'datlich'    => ['label' => 'Đặt lịch',      'icon' => '📅'],
    'baoduong'   => ['label' => 'Bảo dưỡng',     'icon' => '🔧'],
    'nhangiao'   => ['label' => 'Nhận & Giao xe','icon' => '🚗'],
    'lienhe'     => ['label' => 'Liên hệ khác',  'icon' => '✉️'],
  ];
@endphp
<div class="contact-tabs">
  @foreach($categories as $key => $cat)
    <a href="{{ route('admin.contacts.index', array_merge(request()->query(), ['loai' => $key, 'page' => 1])) }}"
       class="ctab {{ request('loai', '') === $key ? 'active' : '' }}">
      {{ $cat['icon'] }} {{ $cat['label'] }}
    </a>
  @endforeach
</div>

{{-- Filter --}}
<div class="card" style="margin-bottom:12px;padding:10px 16px">
  <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
    @if(request('loai'))
      <input type="hidden" name="loai" value="{{ request('loai') }}">
    @endif
    <input class="form-control" name="q" value="{{ request('q') }}"
           placeholder="Tìm tên, số điện thoại, tiêu đề..."
           style="flex:1;min-width:220px;font-size:13px">
    <select class="form-control" name="status" style="width:170px;font-size:13px" onchange="this.form.submit()">
      <option value="">Tất cả trạng thái</option>
      <option value="unread" {{ request('status')=='unread' ? 'selected':'' }}>Chưa đọc ({{ $unreadCount }})</option>
      <option value="read"   {{ request('status')=='read'   ? 'selected':'' }}>Đã đọc</option>
    </select>
    <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
    @if(request('q') || request('status'))
      <a href="{{ route('admin.contacts.index', ['loai' => request('loai')]) }}"
         class="btn btn-sm">✕ Xóa lọc</a>
    @endif
  </form>
</div>

{{-- Table --}}
<div class="card" style="overflow-x:auto">
  <div style="min-width:900px">

    <div class="contact-thead">
      <div></div>
      <div>Người gửi</div>
      <div>Nội dung</div>
      <div>Loại</div>
      <div>Ngày gửi</div>
      <div>Phân công</div>
      <div style="text-align:right">Thao tác</div>
    </div>

    @forelse($contacts as $contact)
      @php
        $subjectLower = strtolower($contact->subject ?? '');
        if (str_contains($subjectLower, 'báo giá') || str_contains($subjectLower, 'bao gia')) {
            $tagClass = 'tag-baogianhanh'; $tagLabel = 'Báo giá';
        } elseif (str_contains($subjectLower, 'đặt lịch') || str_contains($subjectLower, 'dat lich')) {
            $tagClass = 'tag-datlich'; $tagLabel = 'Đặt lịch';
        } elseif (str_contains($subjectLower, 'bảo dưỡng') || str_contains($subjectLower, 'bao duong') || str_contains($subjectLower, 'nhắc')) {
            $tagClass = 'tag-baoduong'; $tagLabel = 'Bảo dưỡng';
        } elseif (str_contains($subjectLower, 'nhận') || str_contains($subjectLower, 'giao xe') || str_contains($subjectLower, 'pickup')) {
            $tagClass = 'tag-nhangiao'; $tagLabel = 'Nhận/Giao';
        } else {
            $tagClass = 'tag-lienhe'; $tagLabel = 'Liên hệ';
        }
      @endphp

      <div class="contact-row {{ $contact->is_read ? '' : 'unread' }}">

        {{-- Dot --}}
        <div style="display:flex;align-items:center">
          <div class="{{ $contact->is_read ? 'read-dot' : 'unread-dot' }}"></div>
        </div>

        {{-- Người gửi --}}
        <div>
          <div style="font-weight:{{ $contact->is_read ? '500' : '700' }};font-size:13.5px;color:#111827">
            {{ $contact->name }}
          </div>
          <div style="font-size:12px;color:#9ca3af;margin-top:2px">
            {{ $contact->phone ?? $contact->email ?? '—' }}
          </div>
        </div>

        {{-- Nội dung --}}
        <div style="min-width:0">
          <a href="{{ route('admin.contacts.show', $contact) }}"
             style="font-size:13.5px;font-weight:{{ $contact->is_read ? '400' : '600' }};
                    display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
                    color:#111827;text-decoration:none;">
            {{ $contact->subject ?? \Illuminate\Support\Str::limit($contact->message, 60) }}
          </a>
        </div>

        {{-- Loại --}}
        <div><span class="tag {{ $tagClass }}">{{ $tagLabel }}</span></div>

        {{-- Ngày gửi --}}
        <div style="font-size:12.5px;color:#6b7280;white-space:nowrap">
          {{ $contact->created_at->format('d/m H:i') }}
        </div>

        {{-- Phân công --}}
        <div>
          @if($contact->assignedTo)
            <span style="font-size:11.5px;background:#d1fae5;color:#065f46;border-radius:20px;
                         padding:3px 9px;font-weight:600;white-space:nowrap;display:inline-block">
              ✓ {{ $contact->assignedTo->name }}
            </span>
          @else
            <span style="font-size:12.5px;color:#9ca3af">Chưa phân công</span>
          @endif
        </div>

        {{-- Thao tác --}}
        <div class="action-btns">
          <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm">Xem</a>
          <button type="button" class="btn btn-sm btn-primary"
              data-url="{{ route('admin.contacts.assign', $contact) }}"
              data-name="{{ $contact->name }}"
              onclick="openAssign(this)">
            Chuyển NV
          </button>
          <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" class="ct-del-form" style="display:inline">
            @csrf @method('DELETE')
            <button type="button" class="btn btn-sm btn-danger"
              onclick="ctConfirmDelete(this, '{{ addslashes($contact->name) }}')">Xóa</button>
          </form>
        </div>

      </div>
    @empty
      <div style="text-align:center;padding:50px;color:#9ca3af;font-size:14px">
        Chưa có liên hệ nào.
      </div>
    @endforelse

  </div>

  @if($contacts->hasPages())
  <div style="padding:12px 16px;border-top:1px solid #e5e7eb">
    {{ $contacts->withQueryString()->links() }}
  </div>
  @endif
</div>

{{-- ── Modal chuyển NV ── --}}
<div id="assignModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);
     backdrop-filter:blur(3px);z-index:9999;align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:14px;padding:26px;width:100%;max-width:440px;
              margin:0 16px;box-shadow:0 20px 60px rgba(0,0,0,.15);animation:ctSlideUp .2s ease">
    <div style="font-size:15px;font-weight:700;margin-bottom:3px">Chuyển cho nhân viên</div>
    <div id="assignSubtitle" style="font-size:13px;color:#9ca3af;margin-bottom:18px"></div>

    <form id="assignForm" method="POST">
      @csrf
      <div style="margin-bottom:12px">
        <label style="display:block;font-size:12.5px;font-weight:600;color:#374151;margin-bottom:5px">
          Chọn nhân viên <span style="color:red">*</span>
        </label>
        <select name="assigned_to" required
            style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:8px 12px;font-size:13.5px;font-family:inherit">
          <option value="">-- Chọn --</option>
          @foreach($staffList as $staff)
            <option value="{{ $staff->id }}">{{ $staff->name }} ({{ ucfirst($staff->role) }})</option>
          @endforeach
        </select>
      </div>
      <div style="margin-bottom:18px">
        <label style="display:block;font-size:12.5px;font-weight:600;color:#374151;margin-bottom:5px">
          Ghi chú cho nhân viên
        </label>
        <textarea name="staff_note" rows="3"
            style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:8px 12px;font-size:13.5px;resize:vertical;font-family:inherit"
            placeholder="Lưu ý khi liên hệ khách..."></textarea>
      </div>
      <div style="display:flex;gap:8px;justify-content:flex-end">
        <button type="button" onclick="closeAssign()" class="btn btn-sm">Huỷ</button>
        <button type="submit" class="btn btn-sm btn-primary">✓ Xác nhận chuyển</button>
      </div>
    </form>
  </div>
</div>

{{-- ── Modal xóa liên hệ ── --}}
<div id="ct-del-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);
     backdrop-filter:blur(3px);z-index:9999;align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:14px;padding:26px 26px 20px;width:340px;max-width:90vw;
    box-shadow:0 20px 60px rgba(0,0,0,.18);animation:ctSlideUp .2s ease">

    <div style="width:42px;height:42px;border-radius:50%;background:#fee2e2;
      display:flex;align-items:center;justify-content:center;margin-bottom:12px">
      <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="2.5" viewBox="0 0 24 24">
        <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
        <path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
      </svg>
    </div>

    <div style="font-size:15px;font-weight:700;color:#111827;margin-bottom:5px">Xóa liên hệ?</div>
    <div style="font-size:13px;color:#6b7280;margin-bottom:20px;line-height:1.5">
      Liên hệ từ <strong id="ct-del-name" style="color:#111827"></strong> sẽ bị xóa vĩnh viễn.
    </div>

    <div style="display:flex;gap:8px;justify-content:flex-end">
      <button onclick="ctCloseModal()"
        style="padding:7px 16px;border:1px solid #e5e7eb;border-radius:8px;font-size:13px;
          font-weight:600;cursor:pointer;background:#fff;color:#374151;font-family:inherit"
        onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">
        Huỷ
      </button>
      <button id="ct-del-confirm"
        style="padding:7px 16px;border:none;border-radius:8px;font-size:13px;font-weight:600;
          cursor:pointer;background:#dc2626;color:#fff;font-family:inherit"
        onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">
        Xóa
      </button>
    </div>
  </div>
</div>

<style>
@keyframes ctSlideUp {
  from { opacity:0; transform:translateY(10px) }
  to   { opacity:1; transform:translateY(0) }
}
</style>

@push('scripts')
<script>
/* ── Assign modal ── */
function openAssign(btn) {
    document.getElementById('assignSubtitle').textContent = btn.dataset.name;
    document.getElementById('assignForm').action = btn.dataset.url;
    document.getElementById('assignModal').style.display = 'flex';
}
function closeAssign() {
    document.getElementById('assignModal').style.display = 'none';
}
document.getElementById('assignModal').addEventListener('click', function(e) {
    if (e.target === this) closeAssign();
});

/* ── Delete modal ── */
(function () {
  var _form   = null;
  var overlay = document.getElementById('ct-del-overlay');

  window.ctConfirmDelete = function(btn, name) {
    _form = btn.closest('.ct-del-form');
    document.getElementById('ct-del-name').textContent = name;
    overlay.style.display = 'flex';
  };

  document.getElementById('ct-del-confirm').addEventListener('click', function () {
    if (_form) { var f = _form; _form = null; overlay.style.display = 'none'; f.submit(); }
  });

  window.ctCloseModal = function () {
    overlay.style.display = 'none'; _form = null;
  };

  overlay.addEventListener('click', function (e) { if (e.target === this) ctCloseModal(); });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') ctCloseModal(); });
})();
</script>
@endpush

@endsection