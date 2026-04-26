@extends('layouts.admin')
@section('page-title', 'Lịch sử chấm công — ' . $user->name)

@section('content')

<div class="card">
    <div style="padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between">
        <div>
            <span style="font-weight:600">{{ $user->name }}</span>
            <span style="font-size:12px;color:var(--text-2);margin-left:8px">{{ $user->email }}</span>
        </div>
        <a href="{{ route('admin.attendance.index') }}" class="btn btn-sm">← Quay lại</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Ngày</th>
                <th style="text-align:center">Check-in</th>
                <th style="text-align:center">Check-out</th>
                <th style="text-align:center">Giờ làm</th>
                <th>Địa điểm check-in</th>
            </tr>
        </thead>
        <tbody>
            @forelse($history as $h)
            <tr>
                <td style="font-weight:500">{{ $h->work_date->format('d/m/Y') }}</td>
                <td style="text-align:center;font-weight:600;color:var(--success)">
                    {{ $h->check_in_at?->format('H:i') ?? '—' }}
                </td>
                <td style="text-align:center;color:var(--danger)">
                    {{ $h->check_out_at?->format('H:i') ?? '—' }}
                </td>
                <td style="text-align:center">
                    {{ $h->work_hours ? $h->work_hours . 'h' : '—' }}
                </td>
                <td style="font-size:12px;color:var(--text-2)">
                    {{ $h->check_in_address ?? '—' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;padding:40px;color:var(--text-2)">
                    Chưa có lịch sử chấm công
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($history->hasPages())
    <div style="padding:14px 18px;border-top:1px solid var(--border)">
        {{ $history->links() }}
    </div>
    @endif
</div>

@endsection