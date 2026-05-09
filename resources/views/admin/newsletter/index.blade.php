{{-- resources/views/admin/newsletter/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Newsletter')

@section('content')

{{-- ── Stats ── --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:12px">

  <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:10px 14px;box-shadow:0 1px 3px rgba(0,0,0,.06)">
    <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#6b7280;margin-bottom:4px">Đang đăng ký</div>
    <div style="font-size:22px;font-weight:700;color:#16a34a">{{ $totalActive }}</div>
  </div>

  <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:10px 14px;box-shadow:0 1px 3px rgba(0,0,0,.06)">
    <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#6b7280;margin-bottom:4px">Tổng subscriber</div>
    <div style="font-size:22px;font-weight:700;color:#111827">{{ $subscribers->total() }}</div>
  </div>

  <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:10px 14px;box-shadow:0 1px 3px rgba(0,0,0,.06)">
    <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#6b7280;margin-bottom:4px">Đã hủy đăng ký</div>
    <div style="font-size:22px;font-weight:700;color:#dc2626">{{ $subscribers->total() - $totalActive }}</div>
  </div>

</div>

{{-- ── Main Card ── --}}
<div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;box-shadow:0 1px 3px rgba(0,0,0,.06);overflow:hidden">

  {{-- Toolbar --}}
  <div style="padding:12px 16px;border-bottom:1px solid #e5e7eb;background:#fafafa;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px">
    <div style="display:flex;align-items:center;gap:8px">
      <div style="width:30px;height:30px;border-radius:7px;background:#dcfce7;display:flex;align-items:center;justify-content:center;color:#16a34a">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
        </svg>
      </div>
      <span style="font-size:13.5px;font-weight:600;color:#111827">Danh sách subscriber</span>
    </div>

    <form method="GET" style="display:flex;gap:6px;align-items:center;flex-wrap:wrap">
      <div style="position:relative">
        <svg style="position:absolute;left:8px;top:50%;transform:translateY(-50%);color:#9ca3af;pointer-events:none"
          width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input name="search" value="{{ request('search') }}" placeholder="Tìm email..."
          style="padding:6px 10px 6px 28px;border:1px solid #e5e7eb;border-radius:7px;font-size:12.5px;
                 background:#fff;color:#111827;width:200px;outline:none;font-family:inherit">
      </div>
      <select name="status" onchange="this.form.submit()"
        style="padding:6px 10px;border:1px solid #e5e7eb;border-radius:7px;font-size:12.5px;
               background:#fff;color:#111827;cursor:pointer;font-family:inherit">
        <option value="">Tất cả</option>
        <option value="active"   {{ request('status') == 'active'   ? 'selected':'' }}>Active</option>
        <option value="inactive" {{ request('status') == 'inactive' ? 'selected':'' }}>Inactive</option>
      </select>
      <button type="submit"
        style="padding:6px 14px;background:#111827;color:#fff;border:none;border-radius:7px;
               font-size:12.5px;font-weight:600;cursor:pointer;font-family:inherit">
        Lọc
      </button>
    </form>
  </div>

  {{-- Table --}}
  <table style="width:100%;border-collapse:collapse;font-size:13.5px">
    <thead>
      <tr style="background:#f9fafb">
        <th style="padding:9px 14px;text-align:left;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#6b7280;border-bottom:1px solid #e5e7eb">#</th>
        <th style="padding:9px 14px;text-align:left;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#6b7280;border-bottom:1px solid #e5e7eb">Email</th>
        <th style="padding:9px 14px;text-align:left;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#6b7280;border-bottom:1px solid #e5e7eb">Tên</th>
        <th style="padding:9px 14px;text-align:left;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#6b7280;border-bottom:1px solid #e5e7eb">Trạng thái</th>
        <th style="padding:9px 14px;text-align:left;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#6b7280;border-bottom:1px solid #e5e7eb">Ngày đăng ký</th>
        <th style="padding:9px 14px;text-align:right;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#6b7280;border-bottom:1px solid #e5e7eb">Thao tác</th>
      </tr>
    </thead>
    <tbody>
      @forelse($subscribers as $i => $sub)
      <tr style="border-bottom:1px solid #f3f4f6;transition:background .12s" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background=''">
        <td style="padding:10px 14px;color:#9ca3af;font-size:12px">{{ $subscribers->firstItem() + $i }}</td>
        <td style="padding:10px 14px">
          <div style="display:flex;align-items:center;gap:8px">
            <div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);
              display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;flex-shrink:0">
              {{ mb_strtoupper(mb_substr($sub->email, 0, 1)) }}
            </div>
            <span style="font-weight:500;color:#111827">{{ $sub->email }}</span>
          </div>
        </td>
        <td style="padding:10px 14px;color:#374151">{{ $sub->name ?? '—' }}</td>
        <td style="padding:10px 14px">
          @if($sub->status === 'active')
            <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:20px;font-size:11.5px;font-weight:600;background:#dcfce7;color:#15803d">
              <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block"></span>
              Active
            </span>
          @else
            <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:20px;font-size:11.5px;font-weight:600;background:#f3f4f6;color:#6b7280">
              <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block"></span>
              Inactive
            </span>
          @endif
        </td>
        <td style="padding:10px 14px;color:#6b7280;font-size:12.5px">{{ $sub->created_at->format('d/m/Y') }}</td>
        <td style="padding:10px 14px;text-align:right">
          <form method="POST" action="{{ route('admin.newsletter.destroy', $sub) }}" class="nl-del-form">
            @csrf @method('DELETE')
            <button type="button"
              onclick="nlConfirmDelete(this, '{{ addslashes($sub->email) }}')"
              style="display:inline-flex;align-items:center;gap:5px;padding:5px 11px;border:1px solid #fca5a5;
                border-radius:7px;font-size:12px;font-weight:600;cursor:pointer;background:#fff;
                color:#dc2626;transition:background .12s;font-family:inherit"
              onmouseover="this.style.background='#fee2e2'"
              onmouseout="this.style.background='#fff'">
              <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
              </svg>
              Xóa
            </button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" style="text-align:center;padding:40px;color:#9ca3af;font-size:13px">Chưa có subscriber nào.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  @if($subscribers->hasPages())
  <div style="padding:12px 16px;border-top:1px solid #e5e7eb">
    {{ $subscribers->withQueryString()->links() }}
  </div>
  @endif

</div>

{{-- ── Custom Delete Modal ── --}}
<div id="nl-modal-overlay" style="display:none;position:fixed;inset:0;z-index:9999;
  background:rgba(0,0,0,.45);backdrop-filter:blur(3px);
  align-items:center;justify-content:center">

  <div style="background:#fff;border-radius:14px;padding:26px 26px 20px;width:340px;max-width:90vw;
    box-shadow:0 20px 60px rgba(0,0,0,.18);animation:nlSlideUp .2s ease">

    <div style="width:42px;height:42px;border-radius:50%;background:#fee2e2;
      display:flex;align-items:center;justify-content:center;margin-bottom:12px">
      <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="2.5" viewBox="0 0 24 24">
        <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
        <path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
      </svg>
    </div>

    <div style="font-size:15px;font-weight:700;color:#111827;margin-bottom:5px">Xóa subscriber?</div>
    <div style="font-size:13px;color:#6b7280;margin-bottom:20px;line-height:1.5">
      Email <strong id="nl-modal-email" style="color:#111827"></strong> sẽ bị xóa vĩnh viễn.
    </div>

    <div style="display:flex;gap:8px;justify-content:flex-end">
      <button onclick="nlCloseModal()"
        style="padding:7px 16px;border:1px solid #e5e7eb;border-radius:8px;font-size:13px;font-weight:600;
          cursor:pointer;background:#fff;color:#374151;font-family:inherit"
        onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">
        Huỷ
      </button>
      <button id="nl-modal-confirm"
        style="padding:7px 16px;border:none;border-radius:8px;font-size:13px;font-weight:600;
          cursor:pointer;background:#dc2626;color:#fff;font-family:inherit"
        onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">
        Xóa
      </button>
    </div>
  </div>
</div>

<style>
@keyframes nlSlideUp {
  from { opacity:0; transform:translateY(10px) }
  to   { opacity:1; transform:translateY(0) }
}
</style>

<script>
(function () {
  var _form   = null;
  var overlay = document.getElementById('nl-modal-overlay');

  window.nlConfirmDelete = function(btn, email) {
    _form = btn.closest('.nl-del-form');
    document.getElementById('nl-modal-email').textContent = email;
    overlay.style.display = 'flex';
  };

  document.getElementById('nl-modal-confirm').addEventListener('click', function () {
    if (_form) { var f = _form; _form = null; overlay.style.display = 'none'; f.submit(); }
  });

  window.nlCloseModal = function () {
    overlay.style.display = 'none'; _form = null;
  };

  overlay.addEventListener('click', function (e) { if (e.target === this) nlCloseModal(); });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') nlCloseModal(); });
})();
</script>

@endsection