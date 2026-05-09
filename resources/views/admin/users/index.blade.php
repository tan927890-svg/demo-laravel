@extends('layouts.admin')
@section('page-title', 'Quản lý nhân viên')

@section('topbar-actions')
  @if(auth()->user()->isAdmin() || auth()->user()->isManager())
  <a href="{{ route('admin.users.create') }}" class="btn btn-sm">+ Thêm nhân viên</a>
  @endif
@endsection

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

.sm-wrap {
    font-family: 'DM Sans', sans-serif;
    padding: 8px 0 32px;
}
.sm-wrap *, .sm-wrap *::before, .sm-wrap *::after { box-sizing: border-box; }

/* ── Alert ── */
.sm-alert {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 13.5px; font-weight: 500;
    margin-bottom: 16px;
}
.sm-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
.sm-alert-error   { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
.sm-alert svg { width: 16px; height: 16px; flex-shrink: 0; }

/* ── Card wrapper ── */
.sm-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    overflow: hidden;
}
.sm-card-head {
    padding: 14px 20px;
    border-bottom: 1px solid #f0f0f0;
    display: flex; align-items: center; justify-content: space-between;
    background: #fafafa;
}
.sm-card-title {
    font-size: 14px; font-weight: 700; color: #111827;
    display: flex; align-items: center; gap: 8px;
}
.sm-card-count {
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    border-radius: 20px;
    padding: 2px 9px;
    font-size: 12px; font-weight: 600; color: #6b7280;
}

/* ══════════════════════════════
   Desktop ≥1024px / Mobile <1024px
══════════════════════════════ */
.sm-table-wrap  { display: none; }
.sm-mobile-list { display: block; }

@media (min-width: 1024px) {
    .sm-table-wrap  { display: block !important; }
    .sm-mobile-list { display: none !important; }
}

.sm-table { width: 100%; border-collapse: collapse; }
.sm-table thead tr { background: #f8f9fb; border-bottom: 1px solid #e5e7eb; }
.sm-table thead th {
    padding: 10px 16px;
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .55px;
    color: #9ca3af; text-align: left; white-space: nowrap;
}
.sm-table tbody tr { border-bottom: 1px solid #f3f4f6; transition: background .1s; }
.sm-table tbody tr:last-child { border-bottom: none; }
.sm-table tbody tr:hover { background: #fafbff; }
.sm-table td { padding: 14px 16px; vertical-align: middle; }

/* Mobile card */
.sm-mobile-item {
    padding: 16px;
    border-bottom: 1px solid #f3f4f6;
}
.sm-mobile-item:last-child { border-bottom: none; }
.sm-mi-top { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 10px; }
.sm-mi-info { flex: 1; min-width: 0; }
.sm-mi-name {
    font-size: 14px; font-weight: 700; color: #111827;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 3px;
}
.sm-mi-email {
    font-size: 12px; color: #6b7280;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 5px;
}
.sm-mi-tags { display: flex; flex-wrap: wrap; gap: 4px; }
.sm-mi-stats {
    display: flex; gap: 0;
    background: #f8f9fb; border-radius: 10px; overflow: hidden; margin-bottom: 10px;
}
.sm-mi-stat { flex: 1; padding: 8px 10px; text-align: center; border-right: 1px solid #f0f0f0; }
.sm-mi-stat:last-child { border-right: none; }
.sm-mi-stat-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #9ca3af; margin-bottom: 3px; }
.sm-mi-stat-val { font-size: 14px; font-weight: 700; color: #111827; }
.sm-mi-stat-val.purple { color: #6366f1; font-size: 12px; }
.sm-mi-stat-val.muted  { color: #d1d5db; }
.sm-mi-actions { display: flex; gap: 6px; flex-wrap: wrap; }

/* ── Avatar ── */
.sm-avatar {
    width: 38px; height: 38px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 14px; flex-shrink: 0;
}

/* ── Role badge ── */
.sm-role {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 20px;
    font-size: 12px; font-weight: 600; white-space: nowrap;
}
.sm-role-dot { width: 6px; height: 6px; border-radius: 50%; }
.sm-role-admin   { background: #fee2e2; color: #dc2626; }
.sm-role-admin   .sm-role-dot { background: #ef4444; }
.sm-role-manager { background: #fef3c7; color: #d97706; }
.sm-role-manager .sm-role-dot { background: #f59e0b; }
.sm-role-staff   { background: #dbeafe; color: #1d4ed8; }
.sm-role-staff   .sm-role-dot { background: #3b82f6; }

/* ── Buttons ── */
.sm-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 11px; border-radius: 7px;
    font-size: 12.5px; font-weight: 600;
    font-family: inherit; cursor: pointer;
    text-decoration: none; transition: all .15s; white-space: nowrap; border: none;
}
.sm-btn svg { width: 13px; height: 13px; }
.sm-btn-default { background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; }
.sm-btn-default:hover { background: #111827; color: #fff; border-color: #111827; }
.sm-btn-edit    { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
.sm-btn-edit:hover { background: #1d4ed8; color: #fff; border-color: #1d4ed8; }
.sm-btn-delete  { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
.sm-btn-delete:hover { background: #dc2626; color: #fff; border-color: #dc2626; }

/* ── Table styles ── */
.sm-staff-cell { display: flex; align-items: center; gap: 10px; }
.sm-staff-name { font-size: 14px; font-weight: 600; color: #111827; line-height: 1.3; }
.sm-email   { font-size: 13px; color: #6b7280; }
.sm-stat-num { font-size: 15px; font-weight: 700; color: #111827; }
.sm-revenue { font-size: 13px; font-weight: 600; color: #6366f1; }
.sm-dash    { color: #d1d5db; font-size: 15px; }
.sm-date    { font-size: 12px; color: #9ca3af; }
.sm-actions { display: flex; gap: 6px; justify-content: flex-end; align-items: center; flex-wrap: wrap; }

/* ── Empty ── */
.sm-empty { text-align: center; padding: 64px 20px; }
.sm-empty-icon {
    width: 54px; height: 54px; background: #f3f4f6; border-radius: 14px;
    display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;
}
.sm-empty-icon svg { width: 26px; height: 26px; color: #d1d5db; }
.sm-empty-title { font-size: 15px; font-weight: 600; color: #374151; margin-bottom: 4px; }
.sm-empty-sub   { font-size: 13px; color: #9ca3af; }

/* ── Pagination ── */
.sm-pagination { padding: 14px 18px; border-top: 1px solid #f3f4f6; }

/* ── Delete modal ── */
.sm-backdrop {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,.45); backdrop-filter: blur(3px);
    z-index: 9999; align-items: center; justify-content: center; padding: 16px;
}
.sm-backdrop.active { display: flex; }
.sm-modal {
    background: #fff; border-radius: 16px;
    padding: 28px 28px 22px; width: 100%; max-width: 380px;
    box-shadow: 0 20px 60px rgba(0,0,0,.18);
    animation: sm-in .18s ease;
}
@keyframes sm-in { from { transform:scale(.95);opacity:0 } to { transform:scale(1);opacity:1 } }
.sm-modal-icon {
    width: 48px; height: 48px; background: #fef2f2; border-radius: 12px;
    display: flex; align-items: center; justify-content: center; margin-bottom: 16px;
}
.sm-modal-icon svg { width: 22px; height: 22px; color: #dc2626; }
.sm-modal-title { font-size: 16px; font-weight: 700; color: #111827; margin-bottom: 6px; }
.sm-modal-desc  { font-size: 13.5px; color: #6b7280; line-height: 1.5; margin-bottom: 22px; }
.sm-modal-desc strong { color: #111827; }
.sm-modal-acts  { display: flex; gap: 8px; justify-content: flex-end; }
.sm-modal-cancel {
    padding: 9px 18px; background: #f3f4f6; color: #374151;
    border: 1px solid #e5e7eb; border-radius: 8px;
    font-size: 13.5px; font-weight: 600; font-family: inherit; cursor: pointer;
}
.sm-modal-cancel:hover { background: #e5e7eb; }
.sm-modal-ok {
    padding: 9px 18px; background: #dc2626; color: #fff;
    border: none; border-radius: 8px;
    font-size: 13.5px; font-weight: 600; font-family: inherit; cursor: pointer;
}
.sm-modal-ok:hover { background: #b91c1c; }
</style>

<div class="sm-wrap">

    @if(session('success'))
    <div class="sm-alert sm-alert-success">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="sm-alert sm-alert-error">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="sm-card">

        <div class="sm-card-head">
            <div class="sm-card-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Danh sách nhân viên
                <span class="sm-card-count">{{ $users->total() }} người</span>
            </div>
        </div>

        {{-- ══ DESKTOP TABLE ≥1024px ══ --}}
        <div class="sm-table-wrap">
            <table class="sm-table">
                <thead>
                    <tr>
                        <th>Nhân viên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th style="text-align:center">Đơn chốt</th>
                        <th style="text-align:center">Doanh thu</th>
                        <th>Ngày tạo</th>
                        <th style="text-align:right">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    @php
                        $initials = collect(explode(' ', $user->name))->map(fn($w) => strtoupper(mb_substr($w,0,1)))->last(null, '?');
                        $colors = ['#e0e7ff,#6366f1','#fce7f3,#db2777','#d1fae5,#059669','#fef3c7,#d97706','#fee2e2,#dc2626','#e0f2fe,#0284c7'];
                        $col = $colors[$user->id % count($colors)];
                        [$bg, $fg] = explode(',', $col);
                        $rev   = $user->orders()->where('consultation_status','da_chot_don')->sum('sale_price');
                        $deals = $user->orders()->where('consultation_status','da_chot_don')->count();
                    @endphp
                    <tr>
                        <td>
                            <div class="sm-staff-cell">
                                <div class="sm-avatar" style="background:{{ $bg }};color:{{ $fg }}">{{ $initials }}</div>
                                <span class="sm-staff-name">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td><span class="sm-email">{{ $user->email }}</span></td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="sm-role sm-role-admin"><span class="sm-role-dot"></span>Admin</span>
                            @elseif($user->role === 'manager')
                                <span class="sm-role sm-role-manager"><span class="sm-role-dot"></span>Manager</span>
                            @else
                                <span class="sm-role sm-role-staff"><span class="sm-role-dot"></span>Staff</span>
                            @endif
                        </td>
                        <td style="text-align:center"><span class="sm-stat-num">{{ $deals }}</span></td>
                        <td style="text-align:center">
                            @if($rev > 0)
                                <span class="sm-revenue">{{ number_format($rev,0,',','.') }}đ</span>
                            @else
                                <span class="sm-dash">—</span>
                            @endif
                        </td>
                        <td><span class="sm-date">{{ $user->created_at->format('d/m/Y') }}</span></td>
                        <td>
                            <div class="sm-actions">
                                <a href="{{ route('admin.kpi.show', $user) }}" class="sm-btn sm-btn-default">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                                    KPI
                                </a>
                                @if(auth()->user()->isAdmin() || (auth()->user()->isManager() && $user->role === 'staff'))
                                <a href="{{ route('admin.users.edit', $user) }}" class="sm-btn sm-btn-edit">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Sửa
                                </a>
                                @endif
                                @if((auth()->user()->isAdmin() && $user->role !== 'admin') || (auth()->user()->isManager() && $user->role === 'staff'))
                                <button type="button" class="sm-btn sm-btn-delete"
                                        onclick="openDeleteModal('{{ route('admin.users.destroy', $user) }}', '{{ addslashes($user->name) }}')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                    Xóa
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="sm-empty">
                                <div class="sm-empty-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                </div>
                                <div class="sm-empty-title">Chưa có nhân viên nào</div>
                                <div class="sm-empty-sub">Thêm nhân viên đầu tiên bằng nút ở trên</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ══ MOBILE CARD LIST <1024px ══ --}}
        <div class="sm-mobile-list">
            @forelse($users as $user)
            @php
                $initials = collect(explode(' ', $user->name))->map(fn($w) => strtoupper(mb_substr($w,0,1)))->last(null, '?');
                $colors = ['#e0e7ff,#6366f1','#fce7f3,#db2777','#d1fae5,#059669','#fef3c7,#d97706','#fee2e2,#dc2626','#e0f2fe,#0284c7'];
                $col = $colors[$user->id % count($colors)];
                [$bg, $fg] = explode(',', $col);
                $rev   = $user->orders()->where('consultation_status','da_chot_don')->sum('sale_price');
                $deals = $user->orders()->where('consultation_status','da_chot_don')->count();
            @endphp
            <div class="sm-mobile-item">
                <div class="sm-mi-top">
                    <div class="sm-avatar" style="background:{{ $bg }};color:{{ $fg }};width:42px;height:42px;border-radius:11px;font-size:15px;">{{ $initials }}</div>
                    <div class="sm-mi-info">
                        <div class="sm-mi-name">{{ $user->name }}</div>
                        <div class="sm-mi-email">{{ $user->email }}</div>
                        <div class="sm-mi-tags">
                            @if($user->role === 'admin')
                                <span class="sm-role sm-role-admin" style="padding:3px 8px;font-size:11px;"><span class="sm-role-dot"></span>Admin</span>
                            @elseif($user->role === 'manager')
                                <span class="sm-role sm-role-manager" style="padding:3px 8px;font-size:11px;"><span class="sm-role-dot"></span>Manager</span>
                            @else
                                <span class="sm-role sm-role-staff" style="padding:3px 8px;font-size:11px;"><span class="sm-role-dot"></span>Staff</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="sm-mi-stats">
                    <div class="sm-mi-stat">
                        <div class="sm-mi-stat-label">Đơn chốt</div>
                        <div class="sm-mi-stat-val">{{ $deals }}</div>
                    </div>
                    <div class="sm-mi-stat">
                        <div class="sm-mi-stat-label">Doanh thu</div>
                        <div class="sm-mi-stat-val {{ $rev > 0 ? 'purple' : 'muted' }}">
                            {{ $rev > 0 ? number_format($rev,0,',','.') . 'đ' : '—' }}
                        </div>
                    </div>
                    <div class="sm-mi-stat">
                        <div class="sm-mi-stat-label">Ngày tạo</div>
                        <div class="sm-mi-stat-val" style="font-size:12px;color:#6b7280;font-weight:500;">{{ $user->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>

                <div class="sm-mi-actions">
                    <a href="{{ route('admin.kpi.show', $user) }}" class="sm-btn sm-btn-default">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                        KPI
                    </a>
                    @if(auth()->user()->isAdmin() || (auth()->user()->isManager() && $user->role === 'staff'))
                    <a href="{{ route('admin.users.edit', $user) }}" class="sm-btn sm-btn-edit">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Sửa
                    </a>
                    @endif
                    @if((auth()->user()->isAdmin() && $user->role !== 'admin') || (auth()->user()->isManager() && $user->role === 'staff'))
                    <button type="button" class="sm-btn sm-btn-delete"
                            onclick="openDeleteModal('{{ route('admin.users.destroy', $user) }}', '{{ addslashes($user->name) }}')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                        Xóa
                    </button>
                    @endif
                </div>
            </div>
            @empty
            <div class="sm-empty">
                <div class="sm-empty-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div class="sm-empty-title">Chưa có nhân viên nào</div>
                <div class="sm-empty-sub">Thêm nhân viên đầu tiên bằng nút ở trên</div>
            </div>
            @endforelse
        </div>

        @if($users->hasPages())
        <div class="sm-pagination">{{ $users->links() }}</div>
        @endif

    </div>
</div>

{{-- Delete confirm modal --}}
<div class="sm-backdrop" id="deleteBackdrop">
    <div class="sm-modal">
        <div class="sm-modal-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                <path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
            </svg>
        </div>
        <div class="sm-modal-title">Xác nhận xóa nhân viên</div>
        <div class="sm-modal-desc">Bạn có chắc muốn xóa nhân viên <strong id="deleteUserName"></strong>? Hành động này không thể hoàn tác.</div>
        <div class="sm-modal-acts">
            <button class="sm-modal-cancel" onclick="closeDeleteModal()">Hủy bỏ</button>
            <form id="deleteForm" method="POST" style="display:contents">
                @csrf @method('DELETE')
                <button type="submit" class="sm-modal-ok">Xóa nhân viên</button>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteModal(action, name) {
    document.getElementById('deleteForm').action = action;
    document.getElementById('deleteUserName').textContent = name;
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