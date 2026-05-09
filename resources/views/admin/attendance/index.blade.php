@extends('layouts.admin')
@section('page-title', 'Chấm công nhân viên')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
    --att-font: 'Be Vietnam Pro', sans-serif;
    --att-green: #16a34a;
    --att-green-light: #dcfce7;
    --att-amber: #d97706;
    --att-amber-light: #fef3c7;
    --att-blue: #2563eb;
    --att-blue-light: #dbeafe;
    --att-gray: #6b7280;
    --att-gray-light: #f3f4f6;
    --att-danger: #dc2626;
    --att-surface: #ffffff;
    --att-border: #e5e7eb;
    --att-text: #111827;
    --att-text-2: #6b7280;
    --att-shadow: 0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.05);
    --att-shadow-md: 0 4px 16px rgba(0,0,0,.10);
}

.att-wrap {
    font-family: var(--att-font);
    padding: 16px;
    max-width: 1200px;
    margin: 0 auto;
    box-sizing: border-box;
}
.att-wrap *, .att-wrap *::before, .att-wrap *::after { box-sizing: border-box; }

/* ── Page Header ── */
.att-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 12px;
}
.att-title { font-size: 18px; font-weight: 700; color: var(--att-text); letter-spacing: -.3px; margin: 0 0 2px; }
.att-subtitle { font-size: 12px; color: var(--att-text-2); margin: 0; }

/* ── Stats Row ── */
.att-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
    margin-bottom: 12px;
}
.att-stat-card {
    background: var(--att-surface);
    border: 1px solid var(--att-border);
    border-radius: 10px;
    padding: 10px 14px;
    box-shadow: var(--att-shadow);
}
.att-stat-label { font-size: 10.5px; font-weight: 600; text-transform: uppercase; letter-spacing: .6px; color: var(--att-text-2); margin-bottom: 4px; }
.att-stat-value { font-size: 22px; font-weight: 700; line-height: 1; color: var(--att-text); }
.att-stat-card.green .att-stat-value { color: var(--att-green); }
.att-stat-card.amber .att-stat-value { color: var(--att-amber); }
.att-stat-card.gray  .att-stat-value { color: var(--att-gray); }

/* ── Card ── */
.att-card {
    background: var(--att-surface);
    border: 1px solid var(--att-border);
    border-radius: 14px;
    box-shadow: var(--att-shadow);
    overflow: hidden;
}

/* ── Toolbar ── */
.att-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    padding: 12px 16px;
    border-bottom: 1px solid var(--att-border);
    background: #fafafa;
}
.att-toolbar-left { display: flex; align-items: center; gap: 10px; }
.att-toolbar-icon {
    width: 34px; height: 34px; border-radius: 8px;
    background: var(--att-green-light);
    display: flex; align-items: center; justify-content: center;
    color: var(--att-green);
}
.att-toolbar-title { font-size: 14px; font-weight: 600; color: var(--att-text); }
.att-toolbar-date {
    font-size: 12px; color: var(--att-text-2);
    background: var(--att-gray-light);
    padding: 2px 8px; border-radius: 20px; font-weight: 500;
}

/* ── Export Form ── */
.att-export-form { display: flex; align-items: center; gap: 8px; }
.att-month-picker-wrap { position: relative; }
.att-month-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 7px 12px;
    border: 1px solid var(--att-border); border-radius: 8px;
    font-size: 13px; font-weight: 500; color: var(--att-text);
    background: var(--att-surface); cursor: pointer;
    white-space: nowrap; transition: border-color .15s;
    font-family: var(--att-font); min-width: 140px;
    justify-content: space-between;
}
.att-month-btn:hover { border-color: #9ca3af; }
.att-month-btn svg { flex-shrink: 0; color: var(--att-text-2); }

.att-month-dropdown {
    display: none; position: absolute; top: calc(100% + 6px); right: 0;
    background: var(--att-surface); border: 1px solid var(--att-border);
    border-radius: 12px; box-shadow: var(--att-shadow-md);
    padding: 12px; width: 240px; z-index: 999;
}
.att-month-dropdown.open { display: block; }
.att-md-year { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
.att-md-year-label { font-size: 14px; font-weight: 700; color: var(--att-text); }
.att-md-year-btn {
    background: none; border: 1px solid var(--att-border); border-radius: 6px;
    width: 26px; height: 26px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: var(--att-text-2); transition: background .12s; font-family: var(--att-font);
}
.att-md-year-btn:hover { background: var(--att-gray-light); }
.att-md-months { display: grid; grid-template-columns: repeat(4, 1fr); gap: 4px; }
.att-md-month-btn {
    background: none; border: 1px solid transparent; border-radius: 7px;
    padding: 7px 4px; font-size: 12px; font-weight: 500; cursor: pointer;
    color: var(--att-text); transition: background .12s, border-color .12s;
    font-family: var(--att-font); text-align: center;
}
.att-md-month-btn:hover { background: var(--att-gray-light); }
.att-md-month-btn.active { background: var(--att-text); color: #fff; border-color: var(--att-text); }
.att-md-footer {
    display: flex; justify-content: space-between; align-items: center;
    border-top: 1px solid var(--att-border); margin-top: 10px; padding-top: 10px;
}
.att-md-footer-btn {
    font-size: 12px; font-weight: 600; background: none; border: none;
    cursor: pointer; color: var(--att-green); font-family: var(--att-font);
    padding: 3px 6px; border-radius: 5px; transition: background .12s;
}
.att-md-footer-btn:hover { background: var(--att-green-light); }
.att-md-footer-btn.clear { color: var(--att-text-2); }
.att-md-footer-btn.clear:hover { background: var(--att-gray-light); }
#att-month-input { display: none; }

.att-export-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 7px 15px; background: var(--att-green); color: #fff;
    border: none; border-radius: 8px; font-size: 13px; font-weight: 600;
    cursor: pointer; white-space: nowrap; font-family: var(--att-font);
    transition: background .15s, transform .1s;
    box-shadow: 0 1px 3px rgba(22,163,74,.25);
}
.att-export-btn:hover { background: #15803d; transform: translateY(-1px); }
.att-export-btn:active { transform: translateY(0); }

/* ── Badges ── */
.att-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 9px; border-radius: 20px;
    font-size: 11.5px; font-weight: 600; white-space: nowrap;
}
.att-badge-green { background: var(--att-green-light); color: #15803d; }
.att-badge-amber { background: var(--att-amber-light); color: #b45309; }
.att-badge-blue  { background: var(--att-blue-light);  color: #1d4ed8; }
.att-badge-gray  { background: var(--att-gray-light);  color: #4b5563; }

/* ── Time / Hour shared ── */
.att-time-in  { font-weight: 600; color: var(--att-green); font-size: 14px; font-variant-numeric: tabular-nums; }
.att-time-out { font-weight: 600; color: var(--att-danger); font-size: 14px; font-variant-numeric: tabular-nums; }
.att-dash     { color: #d1d5db; font-size: 16px; }
.att-hours    { font-weight: 600; font-size: 14px; color: var(--att-text); font-variant-numeric: tabular-nums; }

/* ── History button ── */
.att-history-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 12px; border: 1px solid var(--att-border); border-radius: 7px;
    font-size: 12px; font-weight: 600; color: var(--att-text);
    text-decoration: none; background: var(--att-surface);
    transition: background .12s, border-color .12s; white-space: nowrap;
    font-family: var(--att-font);
}
.att-history-btn:hover { background: var(--att-gray-light); border-color: #9ca3af; color: var(--att-text); text-decoration: none; }

/* ══════════════════════════════
   DESKTOP TABLE (≥768px)
══════════════════════════════ */
.att-table-wrap  { display: none; }
.att-mobile-list { display: block; }

@media (min-width: 768px) {
    .att-table-wrap  { display: block; }
    .att-mobile-list { display: none; }
    .att-stats { grid-template-columns: repeat(4, 1fr); }
    .att-toolbar { flex-direction: row; }
}

.att-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
.att-table thead tr { background: #f9fafb; }
.att-table th {
    padding: 9px 14px; text-align: left;
    font-size: 10.5px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .5px;
    color: var(--att-text-2); border-bottom: 1px solid var(--att-border); white-space: nowrap;
}
.att-table th.center { text-align: center; }
.att-table th.right  { text-align: right; }
.att-table tbody tr { border-bottom: 1px solid var(--att-border); transition: background .12s; }
.att-table tbody tr:last-child { border-bottom: none; }
.att-table tbody tr:hover { background: #f9fafb; }
.att-table td { padding: 10px 14px; vertical-align: middle; }
.att-table td.center { text-align: center; }
.att-table td.right  { text-align: right; }
.att-emp-cell { display: flex; align-items: center; }
.att-emp-name  { font-weight: 600; color: var(--att-text); line-height: 1.3; }
.att-emp-email { font-size: 11.5px; color: var(--att-text-2); margin-top: 1px; }
.att-avatar {
    width: 32px; height: 32px; border-radius: 50%;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700; color: #fff;
    flex-shrink: 0; margin-right: 9px;
}
.att-avatar.manager { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }

/* ══════════════════════════════
   MOBILE CARD LIST (<768px)
══════════════════════════════ */
.att-mobile-item {
    padding: 14px 16px;
    border-bottom: 1px solid var(--att-border);
}
.att-mobile-item:last-child { border-bottom: none; }

/* Top: avatar + name + email + badges */
.att-mi-top {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}
.att-mi-avatar {
    width: 40px; height: 40px; border-radius: 50%;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; font-weight: 700; color: #fff; flex-shrink: 0;
}
.att-mi-avatar.manager { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
.att-mi-info { flex: 1; min-width: 0; }
.att-mi-name {
    font-size: 14px; font-weight: 700; color: var(--att-text);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    margin-bottom: 2px;
}
.att-mi-email {
    font-size: 11px; color: var(--att-text-2);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    margin-bottom: 5px;
}
.att-mi-badges { display: flex; gap: 5px; flex-wrap: wrap; }

/* Stats row: 3 ô check-in / check-out / giờ làm */
.att-mi-times {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 6px;
    margin-bottom: 10px;
}
.att-mi-time-box {
    background: var(--att-gray-light);
    border-radius: 8px;
    padding: 8px 10px;
    text-align: center;
}
.att-mi-time-label {
    font-size: 9.5px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .05em;
    color: var(--att-text-2); margin-bottom: 4px;
}
.att-mi-time-val { font-size: 15px; font-weight: 700; line-height: 1; }

/* Action */
.att-mi-action { display: flex; }
.att-mi-action .att-history-btn { width: 100%; justify-content: center; }

/* Mobile stats: 2 col */
@media (max-width: 767px) {
    .att-stats { grid-template-columns: 1fr 1fr; }
    .att-wrap { padding: 10px; }
    .att-toolbar { flex-direction: column; align-items: flex-start; }
    .att-export-form { width: 100%; }
    .att-month-btn { flex: 1; min-width: 0; }
    .att-export-btn { flex-shrink: 0; }
}
</style>
@endpush

@section('content')
@php
    $total   = $users->count();
    $working = collect($todayRecords)->filter(fn($r) => $r->check_in_at && !$r->check_out_at)->count();
    $done    = collect($todayRecords)->filter(fn($r) => $r->check_in_at &&  $r->check_out_at)->count();
    $absent  = $total - $working - $done;
@endphp

<div class="att-wrap">

    <div class="att-header">
        <div>
            <h1 class="att-title">Chấm công nhân viên</h1>
            <p class="att-subtitle">Theo dõi trạng thái làm việc theo thời gian thực</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="att-stats">
        <div class="att-stat-card">
            <div class="att-stat-label">Tổng nhân viên</div>
            <div class="att-stat-value">{{ $total }}</div>
        </div>
        <div class="att-stat-card green">
            <div class="att-stat-label">Hoàn thành</div>
            <div class="att-stat-value">{{ $done }}</div>
        </div>
        <div class="att-stat-card amber">
            <div class="att-stat-label">Đang làm việc</div>
            <div class="att-stat-value">{{ $working }}</div>
        </div>
        <div class="att-stat-card gray">
            <div class="att-stat-label">Chưa check-in</div>
            <div class="att-stat-value">{{ $absent }}</div>
        </div>
    </div>

    <div class="att-card">

        {{-- Toolbar --}}
        <div class="att-toolbar">
            <div class="att-toolbar-left">
                <div class="att-toolbar-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <span class="att-toolbar-title">Hôm nay</span>
                <span class="att-toolbar-date">{{ now()->format('d/m/Y') }}</span>
            </div>

            <form method="GET" action="{{ route('admin.attendance.export') }}" class="att-export-form" id="att-export-form">
                <input type="hidden" name="month" id="att-month-input" value="{{ now()->format('Y-m') }}">
                <div class="att-month-picker-wrap">
                    <button type="button" class="att-month-btn" id="att-month-btn">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <span id="att-month-label">{{ now()->translatedFormat('M Y') }}</span>
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div class="att-month-dropdown" id="att-month-dropdown">
                        <div class="att-md-year">
                            <button type="button" class="att-md-year-btn" id="att-year-prev">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                            </button>
                            <span class="att-md-year-label" id="att-year-label">2026</span>
                            <button type="button" class="att-md-year-btn" id="att-year-next">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                        </div>
                        <div class="att-md-months" id="att-md-months"></div>
                        <div class="att-md-footer">
                            <button type="button" class="att-md-footer-btn clear" id="att-clear-btn">Xóa</button>
                            <button type="button" class="att-md-footer-btn" id="att-today-btn">Tháng này</button>
                        </div>
                    </div>
                </div>
                <button type="submit" class="att-export-btn">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    Xuất Excel
                </button>
            </form>
        </div>

        {{-- ══ DESKTOP TABLE ══ --}}
        <div class="att-table-wrap">
            <table class="att-table">
                <thead>
                    <tr>
                        <th>Nhân viên</th>
                        <th>Vai trò</th>
                        <th class="center">Trạng thái</th>
                        <th class="center">Check-in</th>
                        <th class="center">Check-out</th>
                        <th class="center">Giờ làm</th>
                        <th class="right">Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    @php
                        $rec     = $todayRecords[$u->id] ?? null;
                        $initial = mb_strtoupper(mb_substr($u->name, 0, 1));
                    @endphp
                    <tr>
                        <td>
                            <div class="att-emp-cell">
                                <div class="att-avatar {{ $u->role === 'manager' ? 'manager' : '' }}">{{ $initial }}</div>
                                <div>
                                    <div class="att-emp-name">{{ $u->name }}</div>
                                    <div class="att-emp-email">{{ $u->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($u->role === 'manager')
                                <span class="att-badge att-badge-amber">
                                    <svg width="10" height="10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    Manager
                                </span>
                            @else
                                <span class="att-badge att-badge-blue">
                                    <svg width="10" height="10" fill="currentColor" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    Staff
                                </span>
                            @endif
                        </td>
                        <td class="center">
                            @if(!$rec || !$rec->check_in_at)
                                <span class="att-badge att-badge-gray">Chưa check-in</span>
                            @elseif($rec->check_in_at && !$rec->check_out_at)
                                <span class="att-badge att-badge-amber">
                                    <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block;animation:attPulse 1.4s ease-in-out infinite;"></span>
                                    Đang làm
                                </span>
                            @else
                                <span class="att-badge att-badge-green">
                                    <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                    Hoàn thành
                                </span>
                            @endif
                        </td>
                        <td class="center">
                            @if($rec?->check_in_at) <span class="att-time-in">{{ $rec->check_in_at->format('H:i') }}</span>
                            @else <span class="att-dash">—</span> @endif
                        </td>
                        <td class="center">
                            @if($rec?->check_out_at) <span class="att-time-out">{{ $rec->check_out_at->format('H:i') }}</span>
                            @else <span class="att-dash">—</span> @endif
                        </td>
                        <td class="center">
                            @if($rec?->work_hours) <span class="att-hours">{{ $rec->work_hours }}<span style="font-size:11px;font-weight:500;color:var(--att-text-2)">h</span></span>
                            @else <span class="att-dash">—</span> @endif
                        </td>
                        <td class="right">
                            <a href="{{ route('admin.attendance.show', $u) }}" class="att-history-btn">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Lịch sử
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ══ MOBILE CARD LIST ══ --}}
        <div class="att-mobile-list">
            @foreach($users as $u)
            @php
                $rec     = $todayRecords[$u->id] ?? null;
                $initial = mb_strtoupper(mb_substr($u->name, 0, 1));
            @endphp
            <div class="att-mobile-item">

                {{-- Top: avatar + name + email + badges --}}
                <div class="att-mi-top">
                    <div class="att-mi-avatar {{ $u->role === 'manager' ? 'manager' : '' }}">{{ $initial }}</div>
                    <div class="att-mi-info">
                        <div class="att-mi-name">{{ $u->name }}</div>
                        <div class="att-mi-email">{{ $u->email }}</div>
                        <div class="att-mi-badges">
                            {{-- Role --}}
                            @if($u->role === 'manager')
                                <span class="att-badge att-badge-amber" style="font-size:10.5px;padding:2px 7px;">Manager</span>
                            @else
                                <span class="att-badge att-badge-blue" style="font-size:10.5px;padding:2px 7px;">Staff</span>
                            @endif
                            {{-- Status --}}
                            @if(!$rec || !$rec->check_in_at)
                                <span class="att-badge att-badge-gray" style="font-size:10.5px;padding:2px 7px;">Chưa check-in</span>
                            @elseif($rec->check_in_at && !$rec->check_out_at)
                                <span class="att-badge att-badge-amber" style="font-size:10.5px;padding:2px 7px;">
                                    <span style="width:5px;height:5px;border-radius:50%;background:currentColor;display:inline-block;animation:attPulse 1.4s ease-in-out infinite;"></span>
                                    Đang làm
                                </span>
                            @else
                                <span class="att-badge att-badge-green" style="font-size:10.5px;padding:2px 7px;">Hoàn thành</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Times: check-in / check-out / giờ làm --}}
                <div class="att-mi-times">
                    <div class="att-mi-time-box">
                        <div class="att-mi-time-label">Check-in</div>
                        <div class="att-mi-time-val">
                            @if($rec?->check_in_at)
                                <span class="att-time-in" style="font-size:14px;">{{ $rec->check_in_at->format('H:i') }}</span>
                            @else
                                <span class="att-dash">—</span>
                            @endif
                        </div>
                    </div>
                    <div class="att-mi-time-box">
                        <div class="att-mi-time-label">Check-out</div>
                        <div class="att-mi-time-val">
                            @if($rec?->check_out_at)
                                <span class="att-time-out" style="font-size:14px;">{{ $rec->check_out_at->format('H:i') }}</span>
                            @else
                                <span class="att-dash">—</span>
                            @endif
                        </div>
                    </div>
                    <div class="att-mi-time-box">
                        <div class="att-mi-time-label">Giờ làm</div>
                        <div class="att-mi-time-val">
                            @if($rec?->work_hours)
                                <span class="att-hours" style="font-size:14px;">{{ $rec->work_hours }}<span style="font-size:10px;font-weight:500;color:var(--att-text-2)">h</span></span>
                            @else
                                <span class="att-dash">—</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Action --}}
                <div class="att-mi-action">
                    <a href="{{ route('admin.attendance.show', $u) }}" class="att-history-btn">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Xem lịch sử
                    </a>
                </div>

            </div>
            @endforeach
        </div>

    </div>
</div>

<style>
@keyframes attPulse {
    0%, 100% { opacity: 1; }
    50% { opacity: .3; }
}
</style>

<script>
(function () {
    const MONTHS = ['Th1','Th2','Th3','Th4','Th5','Th6','Th7','Th8','Th9','Th10','Th11','Th12'];
    const MONTHS_VI = ['Tháng 1','Tháng 2','Tháng 3','Tháng 4','Tháng 5','Tháng 6',
                       'Tháng 7','Tháng 8','Tháng 9','Tháng 10','Tháng 11','Tháng 12'];
    const now = new Date();
    let selYear = now.getFullYear(), selMonth = now.getMonth();

    const btn = document.getElementById('att-month-btn');
    const dropdown = document.getElementById('att-month-dropdown');
    const yearLabel = document.getElementById('att-year-label');
    const monthsGrid = document.getElementById('att-md-months');
    const monthLabel = document.getElementById('att-month-label');
    const hiddenInput = document.getElementById('att-month-input');

    function pad(n){ return String(n).padStart(2,'0'); }

    function renderMonths() {
        yearLabel.textContent = selYear;
        monthsGrid.innerHTML = '';
        MONTHS.forEach((m, i) => {
            const b = document.createElement('button');
            b.type = 'button';
            b.className = 'att-md-month-btn' + (i === selMonth ? ' active' : '');
            b.textContent = m;
            b.addEventListener('click', () => { selMonth = i; applySelection(); closeDropdown(); });
            monthsGrid.appendChild(b);
        });
    }

    function applySelection() {
        hiddenInput.value = selYear + '-' + pad(selMonth + 1);
        monthLabel.textContent = MONTHS_VI[selMonth] + ' ' + selYear;
    }

    function openDropdown()  { dropdown.classList.add('open'); renderMonths(); }
    function closeDropdown() { dropdown.classList.remove('open'); }

    btn.addEventListener('click', (e) => { e.stopPropagation(); dropdown.classList.contains('open') ? closeDropdown() : openDropdown(); });
    document.getElementById('att-year-prev').addEventListener('click', () => { selYear--; renderMonths(); });
    document.getElementById('att-year-next').addEventListener('click', () => { selYear++; renderMonths(); });
    document.getElementById('att-today-btn').addEventListener('click', () => { selYear = now.getFullYear(); selMonth = now.getMonth(); applySelection(); closeDropdown(); });
    document.getElementById('att-clear-btn').addEventListener('click', () => { hiddenInput.value = ''; monthLabel.textContent = 'Chọn tháng'; closeDropdown(); });
    document.addEventListener('click', (e) => { if (!dropdown.contains(e.target) && e.target !== btn) closeDropdown(); });

    applySelection();
})();
</script>

@endsection