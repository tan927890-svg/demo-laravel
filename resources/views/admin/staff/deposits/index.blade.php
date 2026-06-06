@extends('layouts.admin')
@section('page-title', 'Đặt cọc của tôi')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

.sd-wrap *, .sd-wrap *::before, .sd-wrap *::after { box-sizing: border-box; }
.sd-wrap {
  font-family: 'Plus Jakarta Sans', sans-serif;
  padding: 14px 14px 0;
  background: #f5f6fa;
  min-height: 100vh;
}

/* Stats */
.sd-stat-row {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 8px;
  margin-bottom: 10px;
}
.sd-stat-card {
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  padding: 11px 10px;
  text-align: center;
}
.sd-stat-label {
  font-size: 9.5px; font-weight: 700;
  color: #9ca3af; text-transform: uppercase; letter-spacing: .4px;
  line-height: 1.2; margin-bottom: 4px;
}
.sd-stat-val { font-size: 22px; font-weight: 700; color: #111827; line-height: 1; }

/* Filter */
.sd-filter {
  background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
  padding: 12px 14px; margin-bottom: 10px;
  display: flex; flex-direction: column; gap: 10px;
}
.sd-filter-row { display: flex; gap: 8px; align-items: flex-end; flex-wrap: wrap; }
.sd-filter-input {
  flex: 1; min-width: 200px;
  padding: 9px 11px; border: 1px solid #e5e7eb; border-radius: 9px;
  font-size: 13px; font-family: inherit; color: #111827;
  background: #f9fafb; outline: none;
}
.sd-filter-input:focus { border-color: #93c5fd; }
.sd-filter-select {
  padding: 9px 28px 9px 10px; border: 1px solid #e5e7eb; border-radius: 9px;
  font-size: 13px; font-family: inherit; color: #111827;
  background: #f9fafb url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E") no-repeat right 10px center;
  -webkit-appearance: none; appearance: none; outline: none;
}
.sd-filter-select:focus { border-color: #93c5fd; }
.sd-fbtn {
  padding: 9px 16px; border-radius: 9px; font-size: 13px;
  font-family: inherit; font-weight: 600; cursor: pointer; border: none;
  transition: all .15s; white-space: nowrap;
}
.sd-fbtn-primary { background: #16a34a; color: #fff; }
.sd-fbtn-reset   { background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; text-decoration: none; display: inline-flex; align-items: center; }

/* Table card */
.sd-card {
  background: #fff; border: 1px solid #e5e7eb;
  border-radius: 14px; overflow: hidden;
}
.sd-card-header {
  padding: 12px 14px; border-bottom: 1px solid #f0f0f0;
  display: flex; align-items: center; justify-content: space-between;
}
.sd-card-title { font-size: 14px; font-weight: 700; color: #111827; }
.sd-count-badge {
  font-size: 11px; color: #6b7280; background: #f3f4f6;
  border: 1px solid #e5e7eb; border-radius: 6px;
  padding: 2px 8px; font-weight: 600;
}

/* Desktop table */
.sd-desktop { display: none; overflow-x: auto; }
.sd-table { width: 100%; border-collapse: collapse; font-size: 13px; min-width: 760px; }
.sd-table thead tr { background: #f9fafb; border-bottom: 1px solid #f0f0f0; }
.sd-table th {
  padding: 9px 13px; text-align: left; font-weight: 700; color: #6b7280;
  font-size: 11px; text-transform: uppercase; letter-spacing: .5px; white-space: nowrap;
}
.sd-table tbody tr { border-bottom: 1px solid #f9fafb; transition: background .1s; }
.sd-table tbody tr:last-child { border-bottom: none; }
.sd-table tbody tr:hover { background: #f0fdf4; }
.sd-table td { padding: 9px 13px; color: #374151; vertical-align: middle; }
.sd-table tbody tr.pending-row { background: #fffbeb; }
.sd-table tbody tr.pending-row:hover { background: #fef3c7; }

/* Mobile cards */
.sd-mobile { display: flex; flex-direction: column; }
.sd-m-card { padding: 13px 14px; border-bottom: 1px solid #f3f4f6; }
.sd-m-card:last-child { border-bottom: none; }
.sd-m-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 8px; margin-bottom: 7px; }
.sd-m-txn { font-size: 11px; color: #1d4ed8; background: #eff6ff; padding: 2px 7px; border-radius: 5px; font-weight: 700; font-family: monospace; }
.sd-m-customer { flex: 1; }
.sd-m-name  { font-size: 14px; font-weight: 700; color: #111827; }
.sd-m-phone { font-size: 11px; color: #9ca3af; margin-top: 1px; }
.sd-m-mid { display: flex; align-items: center; gap: 7px; margin-bottom: 9px; flex-wrap: wrap; }
.sd-car-chip {
  font-size: 12px; color: #374151; font-weight: 500;
  background: #f9fafb; border: 1px solid #f0f0f0;
  border-radius: 6px; padding: 3px 8px; white-space: nowrap;
}
.sd-m-bot { display: flex; align-items: center; justify-content: space-between; gap: 8px; flex-wrap: wrap; }
.sd-m-meta { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.sd-amount { font-size: 14px; font-weight: 700; color: #16a34a; }
.sd-date   { font-size: 11px; color: #9ca3af; }

/* Tags / badges */
.tag {
  display: inline-block; font-size: 11px; font-weight: 700;
  padding: 3px 9px; border-radius: 20px; letter-spacing: .4px;
  text-transform: uppercase; white-space: nowrap;
}
.tag-pending   { background: #fef3c7; color: #92400e; }
.tag-confirmed { background: #dbeafe; color: #1e40af; }
.tag-completed { background: #d1fae5; color: #065f46; }
.tag-cancelled { background: #fee2e2; color: #991b1b; }

/* Staff note box */
.sd-note-box {
  display: none; padding: 13px 14px;
  background: #f0fdf4; border-top: 1px solid #bbf7d0;
}
.sd-note-box.open { display: block; }
.sd-note-label { font-size: 10px; font-weight: 700; color: #16a34a; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 5px; }
.sd-note-text  { font-size: 13px; color: #374151; line-height: 1.5; }

/* Note row (desktop) */
.note-row { background: #f0fdf4 !important; }
.note-row td { padding: 13px 16px !important; }

/* Buttons */
.sd-btn {
  display: inline-flex; align-items: center; justify-content: center;
  padding: 6px 11px; border-radius: 8px; font-size: 12px;
  font-family: inherit; font-weight: 600; cursor: pointer;
  text-decoration: none; border: 1px solid transparent;
  transition: all .15s; white-space: nowrap;
}
.sd-btn-default { background: #f3f4f6; color: #374151; border-color: #e5e7eb; }
.sd-btn-default:hover { background: #e5e7eb; }
.sd-btn-green { background: #16a34a; color: #fff; }
.sd-btn-green:hover { background: #15803d; color: #fff; }
.sd-btn-sm { padding: 5px 10px; font-size: 11px; }

.sd-pag { padding: 10px 14px; border-top: 1px solid #f0f0f0; }

/* Responsive */
@media (max-width: 767px) {
  .sd-wrap { padding: 12px 12px 0; }
  .sd-stat-row { grid-template-columns: repeat(3, 1fr); gap: 7px; }
  .sd-stat-val { font-size: 19px; }
  .sd-desktop { display: none !important; }
  .sd-mobile { display: flex; }
}
@media (min-width: 768px) {
  .sd-wrap { padding: 18px 20px 0; }
  .sd-stat-row { grid-template-columns: repeat(5, 1fr); gap: 12px; margin-bottom: 18px; }
  .sd-stat-val { font-size: 24px; }
  .sd-filter { flex-direction: row; align-items: flex-end; }
  .sd-filter-row { flex: 1; }
  .sd-desktop { display: block; }
  .sd-mobile { display: none !important; }
}
</style>

<div class="sd-wrap">

  {{-- Stats --}}
  <div class="sd-stat-row">
    <div class="sd-stat-card">
      <div class="sd-stat-label">Tổng cọc</div>
      <div class="sd-stat-val">{{ $stats['total'] }}</div>
    </div>
    <div class="sd-stat-card">
      <div class="sd-stat-label">Chờ xử lý</div>
      <div class="sd-stat-val" style="color:#d97706">{{ $stats['pending'] }}</div>
    </div>
    <div class="sd-stat-card">
      <div class="sd-stat-label">Đã xác nhận</div>
      <div class="sd-stat-val" style="color:#1d4ed8">{{ $stats['confirmed'] }}</div>
    </div>
    <div class="sd-stat-card">
      <div class="sd-stat-label">Hoàn thành</div>
      <div class="sd-stat-val" style="color:#16a34a">{{ $stats['completed'] }}</div>
    </div>
    <div class="sd-stat-card">
      <div class="sd-stat-label">Đã huỷ</div>
      <div class="sd-stat-val" style="color:#dc2626">{{ $stats['cancelled'] }}</div>
    </div>
  </div>

  {{-- Filter --}}
  <div class="sd-filter">
    <form method="GET" style="display:contents">
      <div class="sd-filter-row">
        <input class="sd-filter-input" name="search" value="{{ request('search') }}"
               placeholder="Tên, SĐT, mã giao dịch...">
        <select name="dep_status" class="sd-filter-select" onchange="this.form.submit()">
          <option value="">Tất cả trạng thái</option>
          <option value="pending"   @selected(request('dep_status')==='pending')>⏳ Chờ xử lý</option>
          <option value="confirmed" @selected(request('dep_status')==='confirmed')>✅ Đã xác nhận</option>
          <option value="completed" @selected(request('dep_status')==='completed')>🏁 Hoàn thành</option>
          <option value="cancelled" @selected(request('dep_status')==='cancelled')>❌ Đã huỷ</option>
        </select>
        <button type="submit" class="sd-fbtn sd-fbtn-primary">Lọc</button>
      </div>
    </form>
    @if(request('search') || request('dep_status'))
      <a href="{{ route('admin.staff.deposits.index') }}" class="sd-fbtn sd-fbtn-reset">✕ Xóa lọc</a>
    @endif
  </div>

  {{-- Table card --}}
  <div class="sd-card">
    <div class="sd-card-header">
      <span class="sd-card-title">💳 Đặt cọc được phân công</span>
      <span class="sd-count-badge">{{ $deposits->total() }} đặt cọc</span>
    </div>

    {{-- ── MOBILE ── --}}
    <div class="sd-mobile">
      @forelse($deposits as $dep)
      @php
        $tagClass = match($dep->status) {
          'pending'   => 'tag-pending',
          'confirmed' => 'tag-confirmed',
          'completed' => 'tag-completed',
          'cancelled' => 'tag-cancelled',
          default     => 'tag-pending',
        };
      @endphp
      <div class="sd-m-card">
        <div class="sd-m-top">
          <code class="sd-m-txn">{{ $dep->transaction_code }}</code>
          <span class="tag {{ $tagClass }}">{{ $dep->status_label }}</span>
        </div>

        <div class="sd-m-customer" style="margin-bottom:7px">
          <div class="sd-m-name">{{ $dep->customer_name }}</div>
          <div class="sd-m-phone">{{ $dep->customer_phone }}</div>
          @if($dep->customer_email)
            <div class="sd-m-phone">{{ $dep->customer_email }}</div>
          @endif
        </div>

        <div class="sd-m-mid">
          <span class="sd-car-chip">🚗 {{ optional($dep->car)->name ?? '—' }}</span>
          @if($dep->color)
            <span class="sd-car-chip">🎨 {{ $dep->color->name }}</span>
          @endif
        </div>

        <div class="sd-m-bot">
          <div class="sd-m-meta">
            <span class="sd-amount">{{ number_format($dep->deposit_amount) }} ₫</span>
            <span class="sd-date">{{ $dep->created_at->format('d/m/Y H:i') }}</span>
          </div>
          <div style="display:flex;gap:6px;align-items:center">
            <a href="{{ route('admin.staff.deposits.show', $dep->id) }}"
               class="sd-btn sd-btn-green sd-btn-sm">👁 Chi tiết</a>
            @if($dep->staff_note)
              <button type="button" class="sd-btn sd-btn-default sd-btn-sm"
                      onclick="toggleNote('m-{{ $dep->id }}')">📝 Ghi chú</button>
            @endif
          </div>
        </div>

        @if($dep->staff_note)
        <div id="note-m-{{ $dep->id }}" class="sd-note-box" style="margin-top:10px;border-radius:8px">
          <div class="sd-note-label">Ghi chú từ Admin</div>
          <div class="sd-note-text">{{ $dep->staff_note }}</div>
        </div>
        @endif
      </div>
      @empty
      <div style="padding:48px;text-align:center;color:#9ca3af;font-size:13px">
        Bạn chưa được phân công đặt cọc nào.
      </div>
      @endforelse
    </div>

    {{-- ── DESKTOP ── --}}
    <div class="sd-desktop">
      <table class="sd-table">
        <thead>
          <tr>
            <th>Mã giao dịch</th>
            <th>Khách hàng</th>
            <th>Xe</th>
            <th style="text-align:right">Số tiền cọc</th>
            <th>Trạng thái</th>
            <th>Ngày đặt</th>
            <th style="text-align:right">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          @forelse($deposits as $dep)
          @php
            $tagClass = match($dep->status) {
              'pending'   => 'tag-pending',
              'confirmed' => 'tag-confirmed',
              'completed' => 'tag-completed',
              'cancelled' => 'tag-cancelled',
              default     => 'tag-pending',
            };
          @endphp
          <tr class="{{ $dep->status === 'pending' ? 'pending-row' : '' }}">
            <td>
              <code style="font-size:12px;color:#1d4ed8;background:#eff6ff;padding:2px 7px;border-radius:5px">
                {{ $dep->transaction_code }}
              </code>
            </td>
            <td>
              <div style="font-weight:700;color:#111827">{{ $dep->customer_name }}</div>
              <div style="font-size:12px;color:#9ca3af">{{ $dep->customer_phone }}</div>
              @if($dep->customer_email)
                <div style="font-size:11.5px;color:#9ca3af">{{ $dep->customer_email }}</div>
              @endif
            </td>
            <td>
              <div style="font-weight:500">{{ optional($dep->car)->name ?? '—' }}</div>
              @if($dep->color)
                <div style="font-size:11.5px;color:#9ca3af">{{ $dep->color->name }}</div>
              @endif
            </td>
            <td style="text-align:right;font-weight:700;color:#16a34a;white-space:nowrap">
              {{ number_format($dep->deposit_amount) }} ₫
            </td>
            <td><span class="tag {{ $tagClass }}">{{ $dep->status_label }}</span></td>
            <td style="font-size:12.5px;color:#6b7280;white-space:nowrap">
              {{ $dep->created_at->format('d/m/Y H:i') }}
            </td>
            <td style="text-align:right">
              <div style="display:flex;gap:6px;justify-content:flex-end;align-items:center">
                <a href="{{ route('admin.staff.deposits.show', $dep->id) }}"
                   class="sd-btn sd-btn-green sd-btn-sm">👁 Chi tiết</a>
                @if($dep->staff_note)
                  <button type="button" class="sd-btn sd-btn-default sd-btn-sm"
                          onclick="toggleNote('d-{{ $dep->id }}')">📝 Ghi chú</button>
                @endif
              </div>
            </td>
          </tr>

          @if($dep->staff_note)
          <tr id="note-d-{{ $dep->id }}" class="note-row" style="display:none">
            <td colspan="7">
              <div class="sd-note-label">📋 Ghi chú từ Admin / Manager</div>
              <div class="sd-note-text">{{ $dep->staff_note }}</div>
            </td>
          </tr>
          @endif

          @empty
          <tr>
            <td colspan="7" style="text-align:center;padding:48px;color:#9ca3af">
              Bạn chưa được phân công đặt cọc nào.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($deposits->hasPages())
    <div class="sd-pag">{{ $deposits->withQueryString()->links() }}</div>
    @endif
  </div>

  <div style="height:24px"></div>
</div>

<script>
function toggleNote(id) {
  var mEl = document.getElementById('note-' + id);
  if (!mEl) return;
  if (mEl.tagName === 'TR') {
    mEl.style.display = mEl.style.display === 'none' ? 'table-row' : 'none';
  } else {
    mEl.classList.toggle('open');
  }
}
</script>

@endsection