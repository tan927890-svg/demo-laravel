@extends('layouts.admin')
@section('page-title', 'KPI nhân viên')

@section('content')

<div class="card">
  <div style="padding:14px 18px;border-bottom:1px solid var(--border);font-weight:600">
    👥 Thống kê KPI nhân viên
  </div>
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Nhân viên</th>
        <th>Email</th>
        <th>Tổng đơn</th>
        <th>Đã chốt</th>
        <th>Doanh số</th>
        <th>Hoa hồng</th>
        <th style="text-align:right">Hành động</th>
      </tr>
    </thead>
    <tbody>
      @forelse($staffList as $index => $staff)
      <tr>
        <td style="color:var(--text-muted)">{{ $index + 1 }}</td>
        <td style="font-weight:600">{{ $staff->name }}</td>
        <td style="font-size:13px;color:var(--text-muted)">{{ $staff->email }}</td>
        <td>{{ $staff->kpi_total }}</td>
        <td style="color:var(--success);font-weight:600">{{ $staff->kpi_closed }}</td>
        <td style="font-weight:700;color:var(--primary)">
          {{ number_format($staff->kpi_revenue ?? 0, 0, ',', '.') }}đ
        </td>
        <td style="color:var(--success)">
          {{ number_format($staff->kpi_commission ?? 0, 0, ',', '.') }}đ
        </td>
        <td style="text-align:right">
          <a href="{{ route('admin.kpi.show', $staff) }}" class="btn btn-sm">Chi tiết</a>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="8" style="text-align:center;padding:40px;color:var(--text-muted)">
          Chưa có nhân viên nào.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

@endsection