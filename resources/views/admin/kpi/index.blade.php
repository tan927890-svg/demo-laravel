@extends('layouts.admin')
@section('page-title', 'KPI nhân viên')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

.kpi-wrap {
    font-family: 'DM Sans', sans-serif;
    padding: 8px 0 32px;
}
.kpi-wrap *, .kpi-wrap *::before, .kpi-wrap *::after { box-sizing: border-box; }

/* ── Card ── */
.kpi-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    overflow: hidden;
}
.kpi-card-head {
    padding: 14px 20px;
    border-bottom: 1px solid #f0f0f0;
    background: #fafafa;
    display: flex; align-items: center; gap: 10px;
}
.kpi-card-title {
    font-size: 14px; font-weight: 700; color: #111827;
    display: flex; align-items: center; gap: 8px;
}
.kpi-card-count {
    background: #f3f4f6; border: 1px solid #e5e7eb;
    border-radius: 20px; padding: 2px 9px;
    font-size: 12px; font-weight: 600; color: #6b7280;
}

/* ── Avatar ── */
.kpi-avatar {
    width: 38px; height: 38px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 14px; flex-shrink: 0;
}

/* ── Shared stat styles ── */
.kpi-closed {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 20px;
    background: #f0fdf4; color: #15803d;
    font-size: 13px; font-weight: 600;
}
.kpi-closed-dot { width: 6px; height: 6px; border-radius: 50%; background: #22c55e; }
.kpi-revenue    { font-size: 13px; font-weight: 700; color: #4f46e5; }
.kpi-commission { font-size: 13px; font-weight: 600; color: #059669; }
.kpi-zero       { color: #d1d5db; }

/* ── Action btn ── */
.kpi-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 12px;
    background: #f3f4f6; color: #374151;
    border: 1px solid #e5e7eb; border-radius: 7px;
    font-size: 12.5px; font-weight: 600; font-family: inherit;
    text-decoration: none; transition: all .15s; white-space: nowrap;
}
.kpi-btn:hover { background: #111827; color: #fff; border-color: #111827; }
.kpi-btn svg { width: 13px; height: 13px; }

/* ── Empty ── */
.kpi-empty { text-align: center; padding: 64px 20px; }
.kpi-empty-icon {
    width: 54px; height: 54px; background: #f3f4f6; border-radius: 14px;
    display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;
}
.kpi-empty-icon svg { width: 26px; height: 26px; color: #d1d5db; }
.kpi-empty-title { font-size: 15px; font-weight: 600; color: #374151; margin-bottom: 4px; }
.kpi-empty-sub   { font-size: 13px; color: #9ca3af; }

/* ══════════════════════════════
   DESKTOP TABLE (≥768px)
══════════════════════════════ */
.kpi-table-wrap  { display: none; }
.kpi-mobile-list { display: block; }

@media (min-width: 768px) {
    .kpi-table-wrap  { display: block; }
    .kpi-mobile-list { display: none; }
}

.kpi-table { width: 100%; border-collapse: collapse; }
.kpi-table thead tr { background: #f8f9fb; border-bottom: 1px solid #e5e7eb; }
.kpi-table thead th {
    padding: 10px 16px;
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .55px;
    color: #9ca3af; text-align: left; white-space: nowrap;
}
.kpi-table tbody tr { border-bottom: 1px solid #f3f4f6; transition: background .1s; }
.kpi-table tbody tr:last-child { border-bottom: none; }
.kpi-table tbody tr:hover { background: #fafbff; }
.kpi-table td { padding: 14px 16px; vertical-align: middle; }
.kpi-staff-cell { display: flex; align-items: center; gap: 10px; }
.kpi-staff-name { font-size: 14px; font-weight: 600; color: #111827; }
.kpi-email { font-size: 13px; color: #9ca3af; }
.kpi-num   { font-size: 12px; color: #d1d5db; font-weight: 500; }
.kpi-total { font-size: 14px; font-weight: 600; color: #374151; }

/* ══════════════════════════════
   MOBILE CARD LIST (<768px)
══════════════════════════════ */
.kpi-mobile-item {
    padding: 16px;
    border-bottom: 1px solid #f3f4f6;
}
.kpi-mobile-item:last-child { border-bottom: none; }

/* Top row: avatar + name + email + rank */
.kpi-mi-top {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
}
.kpi-mi-info { flex: 1; min-width: 0; }
.kpi-mi-name {
    font-size: 14px; font-weight: 700; color: #111827;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    margin-bottom: 2px;
}
.kpi-mi-email {
    font-size: 12px; color: #9ca3af;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.kpi-mi-rank {
    width: 26px; height: 26px; border-radius: 8px;
    background: #f3f4f6; border: 1px solid #e5e7eb;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 700; color: #9ca3af;
    flex-shrink: 0;
}

/* Stats grid: 2x2 */
.kpi-mi-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
    margin-bottom: 12px;
}
.kpi-mi-stat {
    background: #f8f9fb;
    border-radius: 10px;
    padding: 10px 12px;
}
.kpi-mi-stat-label {
    font-size: 10px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .05em;
    color: #9ca3af; margin-bottom: 5px;
}
.kpi-mi-stat-val {
    font-size: 15px; font-weight: 700; color: #111827;
    line-height: 1;
}

/* Action */
.kpi-mi-action { display: flex; }
.kpi-mi-action .kpi-btn { width: 100%; justify-content: center; }
</style>

<div class="kpi-wrap">
    <div class="kpi-card">

        <div class="kpi-card-head">
            <div class="kpi-card-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
                </svg>
                Thống kê KPI nhân viên
                <span class="kpi-card-count">{{ $staffList->count() }} người</span>
            </div>
        </div>

        {{-- ══ DESKTOP TABLE ══ --}}
        <div class="kpi-table-wrap">
            <table class="kpi-table">
                <thead>
                    <tr>
                        <th style="width:44px">#</th>
                        <th>Nhân viên</th>
                        <th>Email</th>
                        <th>Tổng đơn</th>
                        <th>Đã chốt</th>
                        <th>Doanh số</th>
                        <th>Hoa hồng</th>
                        <th style="text-align:right; width:100px">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staffList as $index => $staff)
                    @php
                        $initials = collect(explode(' ', $staff->name))->map(fn($w) => strtoupper(mb_substr($w,0,1)))->last(null, '?');
                        $colors = ['#e0e7ff,#6366f1','#fce7f3,#db2777','#d1fae5,#059669','#fef3c7,#d97706','#fee2e2,#dc2626','#e0f2fe,#0284c7'];
                        [$bg, $fg] = explode(',', $colors[$staff->id % count($colors)]);
                    @endphp
                    <tr>
                        <td><span class="kpi-num">{{ $index + 1 }}</span></td>
                        <td>
                            <div class="kpi-staff-cell">
                                <div class="kpi-avatar" style="background:{{ $bg }};color:{{ $fg }}">{{ $initials }}</div>
                                <span class="kpi-staff-name">{{ $staff->name }}</span>
                            </div>
                        </td>
                        <td><span class="kpi-email">{{ $staff->email }}</span></td>
                        <td><span class="kpi-total">{{ $staff->kpi_total }}</span></td>
                        <td>
                            @if($staff->kpi_closed > 0)
                                <span class="kpi-closed"><span class="kpi-closed-dot"></span>{{ $staff->kpi_closed }}</span>
                            @else
                                <span class="kpi-zero">—</span>
                            @endif
                        </td>
                        <td>
                            @if(($staff->kpi_revenue ?? 0) > 0)
                                <span class="kpi-revenue">{{ number_format($staff->kpi_revenue, 0, ',', '.') }}đ</span>
                            @else
                                <span class="kpi-zero">—</span>
                            @endif
                        </td>
                        <td>
                            @if(($staff->kpi_commission ?? 0) > 0)
                                <span class="kpi-commission">{{ number_format($staff->kpi_commission, 0, ',', '.') }}đ</span>
                            @else
                                <span class="kpi-zero">—</span>
                            @endif
                        </td>
                        <td style="text-align:right">
                            <a href="{{ route('admin.kpi.show', $staff) }}" class="kpi-btn">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                                Chi tiết
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="kpi-empty">
                                <div class="kpi-empty-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
                                    </svg>
                                </div>
                                <div class="kpi-empty-title">Chưa có nhân viên nào</div>
                                <div class="kpi-empty-sub">Dữ liệu KPI sẽ hiển thị khi có nhân viên</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ══ MOBILE CARD LIST ══ --}}
        <div class="kpi-mobile-list">
            @forelse($staffList as $index => $staff)
            @php
                $initials = collect(explode(' ', $staff->name))->map(fn($w) => strtoupper(mb_substr($w,0,1)))->last(null, '?');
                $colors = ['#e0e7ff,#6366f1','#fce7f3,#db2777','#d1fae5,#059669','#fef3c7,#d97706','#fee2e2,#dc2626','#e0f2fe,#0284c7'];
                [$bg, $fg] = explode(',', $colors[$staff->id % count($colors)]);
            @endphp
            <div class="kpi-mobile-item">

                {{-- Top: rank + avatar + name + email --}}
                <div class="kpi-mi-top">
                    <div class="kpi-mi-rank">{{ $index + 1 }}</div>
                    <div class="kpi-avatar" style="background:{{ $bg }};color:{{ $fg }}">{{ $initials }}</div>
                    <div class="kpi-mi-info">
                        <div class="kpi-mi-name">{{ $staff->name }}</div>
                        <div class="kpi-mi-email">{{ $staff->email }}</div>
                    </div>
                </div>

                {{-- Stats: 2x2 grid --}}
                <div class="kpi-mi-stats">
                    <div class="kpi-mi-stat">
                        <div class="kpi-mi-stat-label">Tổng đơn</div>
                        <div class="kpi-mi-stat-val" style="color:#374151">{{ $staff->kpi_total }}</div>
                    </div>
                    <div class="kpi-mi-stat">
                        <div class="kpi-mi-stat-label">Đã chốt</div>
                        <div class="kpi-mi-stat-val" style="color:#15803d">
                            @if($staff->kpi_closed > 0)
                                {{ $staff->kpi_closed }}
                            @else
                                <span style="color:#d1d5db;font-size:18px;font-weight:400">—</span>
                            @endif
                        </div>
                    </div>
                    <div class="kpi-mi-stat">
                        <div class="kpi-mi-stat-label">Doanh số</div>
                        <div class="kpi-mi-stat-val" style="font-size:12px">
                            @if(($staff->kpi_revenue ?? 0) > 0)
                                <span class="kpi-revenue">{{ number_format($staff->kpi_revenue, 0, ',', '.') }}đ</span>
                            @else
                                <span style="color:#d1d5db;font-size:18px;font-weight:400">—</span>
                            @endif
                        </div>
                    </div>
                    <div class="kpi-mi-stat">
                        <div class="kpi-mi-stat-label">Hoa hồng</div>
                        <div class="kpi-mi-stat-val" style="font-size:12px">
                            @if(($staff->kpi_commission ?? 0) > 0)
                                <span class="kpi-commission">{{ number_format($staff->kpi_commission, 0, ',', '.') }}đ</span>
                            @else
                                <span style="color:#d1d5db;font-size:18px;font-weight:400">—</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Action --}}
                <div class="kpi-mi-action">
                    <a href="{{ route('admin.kpi.show', $staff) }}" class="kpi-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                        Xem chi tiết
                    </a>
                </div>

            </div>
            @empty
            <div class="kpi-empty">
                <div class="kpi-empty-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
                    </svg>
                </div>
                <div class="kpi-empty-title">Chưa có nhân viên nào</div>
                <div class="kpi-empty-sub">Dữ liệu KPI sẽ hiển thị khi có nhân viên</div>
            </div>
            @endforelse
        </div>

    </div>
</div>

@endsection