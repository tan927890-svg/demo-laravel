@extends('layouts.admin')
@section('page-title', 'Chấm công nhân viên')

@section('content')

<div class="card">
    <div style="padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px">
        <div style="font-weight:600">
            Chấm công hôm nay —
            <span style="font-size:12px;font-weight:400;color:var(--text-2)">
                {{ now()->format('d/m/Y') }}
            </span>
        </div>

        {{-- Export button --}}
        <form method="GET" action="{{ route('admin.attendance.export') }}" style="display:flex;gap:8px;align-items:center">
            <input type="month"
                   name="month"
                   value="{{ now()->format('Y-m') }}"
                   style="padding:6px 10px;border:1px solid var(--border);border-radius:6px;font-size:13px;background:var(--bg);color:var(--text)">
            <button type="submit"
                    style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;background:#16a34a;color:#fff;border:none;border-radius:6px;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Xuất Excel
            </button>
        </form>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Nhân viên</th>
                <th>Vai trò</th>
                <th style="text-align:center">Trạng thái</th>
                <th style="text-align:center">Check-in</th>
                <th style="text-align:center">Check-out</th>
                <th style="text-align:center">Giờ làm</th>
                <th style="text-align:right">Chi tiết</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            @php $rec = $todayRecords[$u->id] ?? null; @endphp
            <tr>
                <td>
                    <div style="font-weight:500">{{ $u->name }}</div>
                    <div style="font-size:12px;color:var(--text-2)">{{ $u->email }}</div>
                </td>
                <td>
                    @if($u->role === 'manager')
                        <span class="badge badge-amber">Manager</span>
                    @else
                        <span class="badge badge-blue">Staff</span>
                    @endif
                </td>
                <td style="text-align:center">
                    @if(!$rec || !$rec->check_in_at)
                        <span class="badge badge-gray">Chưa check-in</span>
                    @elseif($rec->check_in_at && !$rec->check_out_at)
                        <span class="badge badge-amber">🟡 Đang làm</span>
                    @else
                        <span class="badge badge-green">✅ Hoàn thành</span>
                    @endif
                </td>
                <td style="text-align:center;font-weight:600;color:var(--success)">
                    {{ $rec?->check_in_at?->format('H:i') ?? '—' }}
                </td>
                <td style="text-align:center;color:var(--danger)">
                    {{ $rec?->check_out_at?->format('H:i') ?? '—' }}
                </td>
                <td style="text-align:center">
                    {{ $rec?->work_hours ? $rec->work_hours . 'h' : '—' }}
                </td>
                <td style="text-align:right">
                    <a href="{{ route('admin.attendance.show', $u) }}" class="btn btn-sm">
                        Lịch sử
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection