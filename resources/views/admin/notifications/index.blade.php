@extends('layouts.admin')
@section('page-title', 'Thông báo nội bộ')

@section('topbar-actions')
  <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary btn-sm">+ Tạo thông báo</a>
@endsection

@section('content')

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif


<div class="card">
  <table class="table">
    <thead>
      <tr>
        <th>Loại</th>
        <th>Tiêu đề</th>
        <th>Nội dung</th>
        <th>Gửi đến</th>
        <th>Người gửi</th>
        <th>Thời gian</th>
        @if(auth()->user()->isAdmin()) <th></th> @endif
      </tr>
    </thead>
    <tbody>
      @forelse($notifications as $n)
      <tr>
        <td>
          @php
            $colors = ['info'=>'#dbeafe','warning'=>'#fef3c7','success'=>'#dcfce7','urgent'=>'#fee2e2'];
            $texts  = ['info'=>'#1d4ed8','warning'=>'#92400e','success'=>'#15803d','urgent'=>'#dc2626'];
          @endphp
          <span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700;
            background:{{ $colors[$n->type] }};color:{{ $texts[$n->type] }}">
            {{ $n->typeIcon() }} {{ ucfirst($n->type) }}
          </span>
        </td>
        <td style="font-weight:600">{{ $n->title }}</td>
        <td style="color:var(--text-2);font-size:13px;max-width:300px">
          {{ Str::limit($n->body, 80) }}
        </td>
        <td style="font-size:13px">
          @if(!$n->target_role || $n->target_role === 'all') Tất cả
          @elseif($n->target_role === 'staff') Nhân viên
          @elseif($n->target_role === 'manager') Manager
          @endif
        </td>
        <td style="font-size:13px">{{ $n->creator->name ?? '—' }}</td>
        <td style="font-size:12px;color:var(--text-3)">{{ $n->created_at->format('d/m/Y H:i') }}</td>
        @if(auth()->user()->isAdmin())
        <td>
          {{-- Form xóa — submit bằng JS sau khi user xác nhận qua modal --}}
          <form method="POST" action="{{ route('admin.notifications.destroy', $n) }}" class="ntf-del-form">
            @csrf @method('DELETE')
            <button type="button" class="btn btn-sm btn-danger"
              onclick="ntfConfirmDelete(this, '{{ addslashes($n->title) }}')">Xóa</button>
          </form>
        </td>
        @endif
      </tr>
      @empty
      <tr>
        <td colspan="7" style="text-align:center;padding:40px;color:var(--text-3)">Chưa có thông báo nào</td>
      </tr>
      @endforelse
    </tbody>
  </table>
  @if($notifications->hasPages())
  <div style="padding:14px 18px;border-top:1px solid var(--border)">
    {{ $notifications->links() }}
  </div>
  @endif
</div>

{{-- ===== CUSTOM CONFIRM MODAL ===== --}}
<div id="ntf-modal-overlay" style="
  display:none;position:fixed;inset:0;z-index:9999;
  background:rgba(0,0,0,.45);backdrop-filter:blur(3px);
  align-items:center;justify-content:center;animation:ntfFadeIn .18s ease">

  <div style="
    background:#fff;border-radius:14px;padding:28px 28px 22px;
    width:340px;max-width:90vw;box-shadow:0 20px 60px rgba(0,0,0,.18);
    animation:ntfSlideUp .2s ease;position:relative">

    {{-- Icon --}}
    <div style="width:44px;height:44px;border-radius:50%;background:#fee2e2;
      display:flex;align-items:center;justify-content:center;margin-bottom:14px">
      <svg width="20" height="20" fill="none" stroke="#dc2626" stroke-width="2.5" viewBox="0 0 24 24">
        <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
        <path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
      </svg>
    </div>

    <div style="font-size:15px;font-weight:700;color:#111827;margin-bottom:6px">Xóa thông báo?</div>
    <div style="font-size:13px;color:#6b7280;margin-bottom:22px;line-height:1.5">
      Thông báo <strong id="ntf-modal-title" style="color:#111827"></strong> sẽ bị xóa vĩnh viễn và không thể khôi phục.
    </div>

    <div style="display:flex;gap:8px;justify-content:flex-end">
      <button onclick="ntfCloseModal()"
        style="padding:8px 18px;border:1px solid #e5e7eb;border-radius:8px;
          font-size:13px;font-weight:600;cursor:pointer;background:#fff;color:#374151;
          transition:background .12s;font-family:inherit"
        onmouseover="this.style.background='#f9fafb'"
        onmouseout="this.style.background='#fff'">
        Huỷ
      </button>
      <button id="ntf-modal-confirm"
        style="padding:8px 18px;border:none;border-radius:8px;
          font-size:13px;font-weight:600;cursor:pointer;
          background:#dc2626;color:#fff;transition:background .12s;font-family:inherit"
        onmouseover="this.style.background='#b91c1c'"
        onmouseout="this.style.background='#dc2626'">
        Xóa
      </button>
    </div>
  </div>
</div>

<style>
@keyframes ntfFadeIn  { from { opacity:0 } to { opacity:1 } }
@keyframes ntfSlideUp { from { opacity:0; transform:translateY(12px) } to { opacity:1; transform:translateY(0) } }
</style>

{{-- ===== MODAL JS ===== --}}
<script>
(function () {
  var _pendingForm = null;
  var overlay = document.getElementById('ntf-modal-overlay');

  window.ntfConfirmDelete = function(btn, title) {
    _pendingForm = btn.closest('.ntf-del-form');
    document.getElementById('ntf-modal-title').textContent = '"' + title + '"';
    overlay.style.display = 'flex';
  };

  document.getElementById('ntf-modal-confirm').addEventListener('click', function() {
    if (_pendingForm) {
      var form = _pendingForm;
      _pendingForm = null;
      overlay.style.display = 'none';
      form.submit();
    }
  });

  window.ntfCloseModal = function() {
    overlay.style.display = 'none';
    _pendingForm = null;
  };

  overlay.addEventListener('click', function(e) {
    if (e.target === this) ntfCloseModal();
  });

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') ntfCloseModal();
  });
})();
</script>

@endsection