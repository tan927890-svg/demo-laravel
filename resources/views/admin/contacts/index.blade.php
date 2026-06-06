@extends('layouts.admin')
@section('page-title', request('loai') === 'dat-coc' ? 'Đặt cọc xe' : 'Liên hệ từ khách hàng')

@section('topbar-actions')
  @if(request('loai') !== 'dat-coc' && $unreadCount > 0)
  <form method="POST" action="{{ route('admin.contacts.markAllRead') }}" style="display:inline">
    @csrf
    <button type="submit" class="btn btn-sm">✓ Đánh dấu tất cả đã đọc</button>
  </form>
  @endif
  @if(request('loai') === 'dat-coc')
  <a href="{{ route('admin.deposits.export') }}" class="btn btn-sm">⬇ Xuất CSV</a>
  @endif
@endsection

@push('styles')
<style>
.contact-tabs { display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap; }
.ctab {
    padding:8px 18px; border-radius:8px; border:1px solid #e5e7eb;
    font-size:14px; text-decoration:none; color:#374151;
    background:#fff; cursor:pointer; display:flex; align-items:center; gap:6px;
    transition: all .15s;
}
.ctab:hover { background:#f3f4f6; }
.ctab.active { background:#1d4ed8; color:#fff; border-color:#1d4ed8; }
.ctab.active-deposit { background:#16a34a; color:#fff; border-color:#16a34a; }

.stat-mini {
    background:#fff; border:1px solid #e5e7eb; border-radius:10px;
    padding:10px 14px; flex:1; min-width:140px;
}
.stat-mini .num { font-size:22px; font-weight:700; line-height:1; margin-bottom:4px; }
.stat-mini .lbl { font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:#9ca3af; }

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

.deposit-thead {
    display:grid;
    grid-template-columns: 150px 190px 1fr 120px 130px 100px 140px 110px;
    gap:12px; padding:9px 16px;
    font-size:10.5px; font-weight:700; color:#6b7280;
    letter-spacing:.5px; text-transform:uppercase;
    border-bottom:1px solid #e5e7eb; background:#f9fafb;
}
.deposit-row {
    display:grid;
    grid-template-columns: 150px 190px 1fr 120px 130px 100px 140px 110px;
    gap:12px; align-items:center; padding:10px 16px;
    border-bottom:1px solid #f3f4f6; transition: background .1s;
}
.deposit-row:hover { background:#fafafa; }
.deposit-row.pending-row { background:#fffbeb; }
.deposit-row.pending-row:hover { background:#fef3c7; }

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
.tag-pending     { background:#fef3c7; color:#92400e; }
.tag-confirmed   { background:#dbeafe; color:#1e40af; }
.tag-completed   { background:#d1fae5; color:#065f46; }
.tag-cancelled   { background:#fee2e2; color:#991b1b; }

.unread-dot { width:8px; height:8px; border-radius:50%; background:#1d4ed8; flex-shrink:0; }
.read-dot   { width:8px; height:8px; border-radius:50%; background:#d1d5db; flex-shrink:0; }

.action-btns { display:flex; gap:5px; justify-content:flex-end; flex-wrap:nowrap; }
.action-btns .btn { font-size:12px; padding:5px 10px; white-space:nowrap; }

.status-select-wrap { position:relative; display:inline-block; }
.status-select-wrap select {
    font-size:11px; font-weight:700; padding:3px 22px 3px 9px;
    border-radius:20px; cursor:pointer; appearance:none;
    -webkit-appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath fill='%236b7280' d='M0 0l5 6 5-6z'/%3E%3C/svg%3E");
    background-repeat:no-repeat; background-position:right 7px center;
    letter-spacing:.3px; text-transform:uppercase; border:none;
}

.ct-modal-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(0,0,0,.45);
    backdrop-filter: blur(3px);
    z-index: 9999;
    align-items: center;
    justify-content: center;
}
.ct-modal-overlay.open { display: flex; }

@keyframes ctSlideUp {
    from { opacity:0; transform:translateY(10px); }
    to   { opacity:1; transform:translateY(0); }
}
.ct-modal-box { animation: ctSlideUp .2s ease; }
</style>
@endpush

@section('content')

@if(session('success'))
  <div class="alert alert-success" style="margin-bottom:12px">{{ session('success') }}</div>
@endif

@php $activeTab = request('loai', ''); @endphp

{{-- ═══ STATS ═══ --}}
@if($activeTab === 'dat-coc')
  <div style="display:flex;gap:8px;margin-bottom:12px;flex-wrap:wrap">
    <div class="stat-mini">
      <div class="num">{{ $depositStats['total'] }}</div>
      <div class="lbl">Tổng đặt cọc</div>
    </div>
    <div class="stat-mini">
      <div class="num" style="color:#d97706">{{ $depositStats['pending'] }}</div>
      <div class="lbl">Chờ xử lý</div>
    </div>
    <div class="stat-mini">
      <div class="num" style="color:#1d4ed8">{{ $depositStats['confirmed'] }}</div>
      <div class="lbl">Đã xác nhận</div>
    </div>
    <div class="stat-mini">
      <div class="num" style="color:#16a34a">{{ $depositStats['completed'] }}</div>
      <div class="lbl">Hoàn thành</div>
    </div>
    <div class="stat-mini">
      <div class="num" style="color:#dc2626">{{ $depositStats['cancelled'] }}</div>
      <div class="lbl">Đã huỷ</div>
    </div>
    <div class="stat-mini" style="border-color:#6ee7b7">
      <div class="num" style="color:#059669;font-size:17px">{{ number_format($depositTotalAmount) }} ₫</div>
      <div class="lbl">Tổng tiền cọc</div>
    </div>
  </div>
@else
  <div style="display:flex;gap:8px;margin-bottom:12px;flex-wrap:wrap">
    <div class="stat-mini">
      <div class="num">{{ $totalContactCount }}</div>
      <div class="lbl">Tổng liên hệ</div>
    </div>
    <div class="stat-mini">
      <div class="num" style="color:#1d4ed8">{{ $unreadCount }}</div>
      <div class="lbl">Chưa đọc</div>
    </div>
    <div class="stat-mini">
      <div class="num" style="color:#16a34a">{{ $readCount }}</div>
      <div class="lbl">Đã đọc</div>
    </div>
  </div>
@endif

{{-- ═══ TABS ═══ --}}
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
    <a href="{{ route('admin.contacts.index', array_merge(request()->except(['loai','page']), ['loai' => $key, 'page' => 1])) }}"
       class="ctab {{ $activeTab === $key ? 'active' : '' }}">
      {{ $cat['icon'] }} {{ $cat['label'] }}
    </a>
  @endforeach

  <span style="width:1px;background:#e5e7eb;margin:0 4px;align-self:stretch;display:inline-block"></span>

  <a href="{{ route('admin.contacts.index', ['loai' => 'dat-coc', 'page' => 1]) }}"
     class="ctab {{ $activeTab === 'dat-coc' ? 'active-deposit' : '' }}"
     style="{{ $activeTab !== 'dat-coc' ? 'border-color:#bbf7d0;color:#16a34a' : '' }}">
    💳 Đặt cọc xe
    @if(isset($depositStats) && $depositStats['pending'] > 0 && $activeTab !== 'dat-coc')
      <span style="background:#dc2626;color:#fff;border-radius:20px;font-size:10px;
                   font-weight:700;padding:1px 6px;line-height:1.6">
        {{ $depositStats['pending'] }}
      </span>
    @endif
  </a>
</div>

{{-- ═══ SECTION: LIÊN HỆ ═══ --}}
@if($activeTab !== 'dat-coc')

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
      <a href="{{ route('admin.contacts.index', ['loai' => request('loai')]) }}" class="btn btn-sm">✕ Xóa lọc</a>
    @endif
  </form>
</div>

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
        <div style="display:flex;align-items:center">
          <div class="{{ $contact->is_read ? 'read-dot' : 'unread-dot' }}"></div>
        </div>
        <div>
          <div style="font-weight:{{ $contact->is_read ? '500' : '700' }};font-size:13.5px;color:#111827">
            {{ $contact->name }}
          </div>
          <div style="font-size:12px;color:#9ca3af;margin-top:2px">
            {{ $contact->phone ?? $contact->email ?? '—' }}
          </div>
        </div>
        <div style="min-width:0">
          <a href="{{ route('admin.contacts.show', $contact) }}"
             style="font-size:13.5px;font-weight:{{ $contact->is_read ? '400' : '600' }};
                    display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
                    color:#111827;text-decoration:none;">
            {{ $contact->subject ?? \Illuminate\Support\Str::limit($contact->message, 60) }}
          </a>
        </div>
        <div><span class="tag {{ $tagClass }}">{{ $tagLabel }}</span></div>
        <div style="font-size:12.5px;color:#6b7280;white-space:nowrap">
          {{ $contact->created_at->format('d/m H:i') }}
        </div>
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

@endif {{-- end contacts --}}


{{-- ═══ SECTION: ĐẶT CỌC ═══ --}}
@if($activeTab === 'dat-coc')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
  <div style="width:4px;height:20px;background:#16a34a;border-radius:4px"></div>
  <span style="font-size:13px;font-weight:700;color:#16a34a;text-transform:uppercase;letter-spacing:.5px">
    Danh sách đặt cọc xe
  </span>
</div>

<div class="card" style="margin-bottom:12px;padding:10px 16px">
  <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
    <input type="hidden" name="loai" value="dat-coc">
    <input class="form-control" name="search" value="{{ request('search') }}"
           placeholder="Tên, SĐT, mã giao dịch..."
           style="flex:1;min-width:220px;font-size:13px">
    <select class="form-control" name="dep_status" style="width:170px;font-size:13px" onchange="this.form.submit()">
      <option value="">Tất cả trạng thái</option>
      <option value="pending"   {{ request('dep_status')=='pending'   ? 'selected':'' }}>⏳ Chờ xử lý</option>
      <option value="confirmed" {{ request('dep_status')=='confirmed' ? 'selected':'' }}>✅ Đã xác nhận</option>
      <option value="completed" {{ request('dep_status')=='completed' ? 'selected':'' }}>🏁 Hoàn thành</option>
      <option value="cancelled" {{ request('dep_status')=='cancelled' ? 'selected':'' }}>❌ Đã huỷ</option>
    </select>
    <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
    @if(request('search') || request('dep_status'))
      <a href="{{ route('admin.contacts.index', ['loai' => 'dat-coc']) }}" class="btn btn-sm">✕ Xóa lọc</a>
    @endif
  </form>
</div>

<div class="card" style="overflow-x:auto">
  <div style="min-width:1000px">
    <div class="deposit-thead">
      <div>Mã giao dịch</div>
      <div>Khách hàng</div>
      <div>Xe</div>
      <div style="text-align:right">Số tiền cọc</div>
      <div style="text-align:center">Trạng thái</div>
      <div>Ngày đặt</div>
      <div>Phân công</div>
      <div style="text-align:right">Thao tác</div>
    </div>

    @forelse($deposits as $deposit)
      @php
        $depTagClass = match($deposit->status) {
            'pending'   => 'tag-pending',
            'confirmed' => 'tag-confirmed',
            'completed' => 'tag-completed',
            'cancelled' => 'tag-cancelled',
            default     => 'tag-lienhe',
        };
      @endphp
      <div class="deposit-row {{ $deposit->status === 'pending' ? 'pending-row' : '' }}">

        <div>
          <code style="font-size:12px;color:#1d4ed8;background:#eff6ff;padding:2px 7px;border-radius:5px">
            {{ $deposit->transaction_code }}
          </code>
        </div>

        <div>
          <div style="font-weight:600;font-size:13.5px;color:#111827">{{ $deposit->customer_name }}</div>
          <div style="font-size:12px;color:#9ca3af">{{ $deposit->customer_phone }}</div>
          @if($deposit->customer_email)
            <div style="font-size:11.5px;color:#9ca3af">{{ $deposit->customer_email }}</div>
          @endif
        </div>

        <div style="min-width:0">
          <div style="font-size:13px;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
            {{ optional($deposit->car)->name ?? '—' }}
          </div>
          @if($deposit->color)
            <div style="font-size:11.5px;color:#9ca3af">{{ $deposit->color->name }}</div>
          @endif
        </div>

        <div style="text-align:right;font-weight:700;color:#16a34a;font-size:13.5px;white-space:nowrap">
          {{ number_format($deposit->deposit_amount) }} ₫
        </div>

        <div style="text-align:center">
          <form action="{{ route('admin.deposits.status', $deposit) }}" method="POST"
                style="display:inline" onchange="this.submit()">
            @csrf @method('PATCH')
            <div class="status-select-wrap">
              <select name="status" class="tag {{ $depTagClass }}" style="padding-right:20px;cursor:pointer">
                <option value="pending"   {{ $deposit->status=='pending'   ? 'selected':'' }}>⏳ Chờ xử lý</option>
                <option value="confirmed" {{ $deposit->status=='confirmed' ? 'selected':'' }}>✅ Xác nhận</option>
                <option value="completed" {{ $deposit->status=='completed' ? 'selected':'' }}>🏁 Hoàn thành</option>
                <option value="cancelled" {{ $deposit->status=='cancelled' ? 'selected':'' }}>❌ Huỷ</option>
              </select>
            </div>
          </form>
        </div>

        <div style="font-size:12.5px;color:#6b7280;white-space:nowrap">
          {{ $deposit->created_at->format('d/m H:i') }}
        </div>

        <div>
          @if($deposit->assignedTo)
            <span style="font-size:11.5px;background:#d1fae5;color:#065f46;border-radius:20px;
                         padding:3px 9px;font-weight:600;white-space:nowrap;display:inline-block">
              ✓ {{ $deposit->assignedTo->name }}
            </span>
          @else
            <span style="font-size:12.5px;color:#9ca3af">Chưa phân công</span>
          @endif
        </div>

        <div class="action-btns">
          <a href="{{ route('admin.deposits.show', $deposit) }}" class="btn btn-sm">Xem</a>
          <button type="button" class="btn btn-sm btn-primary"
              data-url="{{ route('admin.deposits.assign', $deposit) }}"
              data-name="{{ $deposit->customer_name }}"
              data-phone="{{ $deposit->customer_phone }}"
              data-car="{{ optional($deposit->car)->name ?? '—' }}"
              data-color="{{ optional($deposit->color)->name ?? '' }}"
              data-amount="{{ number_format($deposit->deposit_amount) }}"
              data-txn="{{ $deposit->transaction_code }}"
              data-assigned="{{ optional($deposit->assignedTo)->name ?? '' }}"
              onclick="openDepositAssign(this)"
              style="background:#16a34a;border-color:#16a34a">
            Chuyển NV
          </button>
        </div>

      </div>
    @empty
      <div style="text-align:center;padding:50px;color:#9ca3af;font-size:14px">
        Chưa có đặt cọc nào.
      </div>
    @endforelse
  </div>

  @if($deposits->hasPages())
  <div style="padding:12px 16px;border-top:1px solid #e5e7eb">
    {{ $deposits->withQueryString()->links() }}
  </div>
  @endif
</div>

@endif {{-- end deposits --}}


{{-- ═══ MODALS ═══ --}}

{{-- Modal: Chuyển NV liên hệ --}}
<div id="assignModal" class="ct-modal-overlay">
  <div class="ct-modal-box" style="background:#fff;border-radius:14px;padding:26px;width:100%;max-width:440px;
              margin:0 16px;box-shadow:0 20px 60px rgba(0,0,0,.15)">
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

{{-- Modal: Chuyển NV đặt cọc --}}
<div id="depositAssignModal" class="ct-modal-overlay">
  <div class="ct-modal-box" style="background:#fff;border-radius:14px;padding:26px;width:100%;max-width:460px;
              margin:0 16px;box-shadow:0 20px 60px rgba(0,0,0,.15)">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
      <div style="width:40px;height:40px;border-radius:50%;background:#d1fae5;
                  display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:18px">💳</div>
      <div>
        <div style="font-size:15px;font-weight:700;color:#111827">Chuyển đặt cọc cho nhân viên</div>
        <div id="depAssignSubtitle" style="font-size:12.5px;color:#9ca3af;margin-top:1px"></div>
      </div>
    </div>
    <div id="depAssignInfo"
         style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;
                padding:12px 14px;margin-bottom:16px;font-size:12.5px;line-height:2;color:#374151">
    </div>
    <div id="depCurrentAssign"
         style="display:none;background:#fefce8;border:1px solid #fde68a;
                border-radius:8px;padding:8px 12px;margin-bottom:14px;font-size:12px;color:#92400e">
    </div>
    <form id="depositAssignForm" method="POST">
      @csrf
      <div style="margin-bottom:12px">
        <label style="display:block;font-size:12.5px;font-weight:600;color:#374151;margin-bottom:5px">
          Chọn nhân viên phụ trách <span style="color:red">*</span>
        </label>
        <select name="assigned_to" required
            style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:8px 12px;
                   font-size:13.5px;font-family:inherit;color:#111827">
          <option value="">-- Chọn nhân viên --</option>
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
            style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:8px 12px;
                   font-size:13.5px;resize:vertical;font-family:inherit;color:#111827"
            placeholder="VD: Khách muốn nhận xe cuối tuần, liên hệ trước 5h chiều..."></textarea>
      </div>
      <div style="display:flex;gap:8px;justify-content:flex-end">
        <button type="button" onclick="closeDepositAssign()" class="btn btn-sm">Huỷ</button>
        <button type="submit" class="btn btn-sm btn-primary"
            style="background:#16a34a;border-color:#16a34a;padding:7px 18px">
          ✓ Xác nhận chuyển
        </button>
      </div>
    </form>
  </div>
</div>

{{-- Modal: Xóa liên hệ --}}
<div id="ct-del-overlay" class="ct-modal-overlay">
  <div class="ct-modal-box" style="background:#fff;border-radius:14px;padding:26px 26px 20px;
       width:340px;max-width:90vw;box-shadow:0 20px 60px rgba(0,0,0,.18)">
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
          font-weight:600;cursor:pointer;background:#fff;color:#374151;font-family:inherit">Huỷ</button>
      <button id="ct-del-confirm"
        style="padding:7px 16px;border:none;border-radius:8px;font-size:13px;font-weight:600;
          cursor:pointer;background:#dc2626;color:#fff;font-family:inherit">Xóa</button>
    </div>
  </div>
</div>

<script>
(function () {
  function openOverlay(id)  { var el = document.getElementById(id); if (el) el.classList.add('open'); }
  function closeOverlay(id) { var el = document.getElementById(id); if (el) el.classList.remove('open'); }

  ['assignModal', 'depositAssignModal', 'ct-del-overlay'].forEach(function (id) {
    var el = document.getElementById(id);
    if (!el) return;
    el.addEventListener('click', function (e) { if (e.target === this) closeOverlay(id); });
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      ['assignModal', 'depositAssignModal', 'ct-del-overlay'].forEach(closeOverlay);
    }
  });

  window.openAssign = function (btn) {
    var subtitle = document.getElementById('assignSubtitle');
    var form = document.getElementById('assignForm');
    if (subtitle) subtitle.textContent = btn.dataset.name || '';
    if (form) {
      form.action = btn.dataset.url || '';
      var sel = form.querySelector('select[name=assigned_to]');
      var txt = form.querySelector('textarea[name=staff_note]');
      if (sel) sel.value = '';
      if (txt) txt.value = '';
    }
    openOverlay('assignModal');
  };
  window.closeAssign = function () { closeOverlay('assignModal'); };

  window.openDepositAssign = function (btn) {
    var subtitle = document.getElementById('depAssignSubtitle');
    var infoBox  = document.getElementById('depAssignInfo');
    var curBox   = document.getElementById('depCurrentAssign');
    var form     = document.getElementById('depositAssignForm');

    if (subtitle) subtitle.textContent = 'Mã GD: ' + (btn.dataset.txn || '');
    if (infoBox) {
      infoBox.innerHTML =
        '👤 <b>Khách hàng:</b> ' + (btn.dataset.name || '') + ' — ' + (btn.dataset.phone || '') + '<br>' +
        '🚗 <b>Xe:</b> ' + (btn.dataset.car || '—') +
          (btn.dataset.color ? ' · ' + btn.dataset.color : '') + '<br>' +
        '💰 <b>Số tiền cọc:</b> <span style="color:#16a34a;font-weight:700">' +
          (btn.dataset.amount || '0') + ' ₫</span>';
    }
    if (curBox) {
      if (btn.dataset.assigned) {
        curBox.style.display = 'block';
        curBox.innerHTML = '⚠️ Hiện đang phụ trách bởi <b>' + btn.dataset.assigned + '</b> — chuyển sẽ ghi đè.';
      } else {
        curBox.style.display = 'none';
      }
    }
    if (form) {
      form.action = btn.dataset.url || '';
      var sel = form.querySelector('select[name=assigned_to]');
      var txt = form.querySelector('textarea[name=staff_note]');
      if (sel) sel.value = '';
      if (txt) txt.value = '';
    }
    openOverlay('depositAssignModal');
  };
  window.closeDepositAssign = function () { closeOverlay('depositAssignModal'); };

  var _delForm = null;
  window.ctConfirmDelete = function (btn, name) {
    _delForm = btn.closest('.ct-del-form');
    var nameEl = document.getElementById('ct-del-name');
    if (nameEl) nameEl.textContent = name;
    openOverlay('ct-del-overlay');
  };

  var delBtn = document.getElementById('ct-del-confirm');
  if (delBtn) {
    delBtn.addEventListener('click', function () {
      if (_delForm) {
        var f = _delForm; _delForm = null;
        closeOverlay('ct-del-overlay');
        f.submit();
      }
    });
  }
  window.ctCloseModal = function () { _delForm = null; closeOverlay('ct-del-overlay'); };
}());
</script>

@endsection