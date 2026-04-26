@extends('layouts.admin')
@section('page-title', 'Hiệu suất cá nhân')

@section('content')

{{-- Stats tổng --}}
<div style="display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:20px">
  <div class="card card-pad" style="text-align:center">
    <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px">Tổng khách tư vấn</div>
    <div style="font-size:28px;font-weight:700">{{ $stats['total_customers'] }}</div>
  </div>
  <div class="card card-pad" style="text-align:center">
    <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px">Đã tư vấn</div>
    <div style="font-size:28px;font-weight:700;color:#3b82f6">{{ $stats['consulted'] }}</div>
  </div>
  <div class="card card-pad" style="text-align:center">
    <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px">Đơn thành công</div>
    <div style="font-size:28px;font-weight:700;color:var(--success)">{{ $stats['closed'] }}</div>
  </div>
  <div class="card card-pad" style="text-align:center">
    <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px">Tỷ lệ chuyển đổi</div>
    <div style="font-size:28px;font-weight:700;color:var(--primary)">{{ $stats['conversion_rate'] }}%</div>
  </div>
  <div class="card card-pad" style="text-align:center">
    <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px">Tổng hoa hồng</div>
    <div style="font-size:18px;font-weight:700;color:var(--success)">
      {{ number_format($stats['commission'], 0, ',', '.') }}đ
    </div>
  </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:16px">

  {{-- Biểu đồ doanh số theo tháng --}}
  <div class="card card-pad">
    <div style="font-weight:600;margin-bottom:16px">📊 Doanh số theo tháng ({{ now()->year }})</div>

    @if($monthly->count())
    <div style="overflow-x:auto">
      <table class="table">
        <thead>
          <tr>
            <th>Tháng</th>
            <th>Số đơn</th>
            <th>Doanh thu</th>
            <th>Hoa hồng</th>
            <th>Biểu đồ</th>
          </tr>
        </thead>
        <tbody>
          @php $maxRevenue = $monthly->max('revenue') ?: 1; @endphp
          @foreach($monthly as $m)
          <tr>
            <td style="font-weight:500">Tháng {{ $m->month }}</td>
            <td style="text-align:center">
              <span class="badge badge-info">{{ $m->cnt }}</span>
            </td>
            <td style="color:var(--primary);font-weight:600">
              {{ number_format($m->revenue, 0, ',', '.') }}đ
            </td>
            <td style="color:var(--success)">
              {{ number_format($m->commission, 0, ',', '.') }}đ
            </td>
            <td style="width:180px">
              <div style="background:var(--surface2);border-radius:4px;height:10px;overflow:hidden">
                <div style="background:var(--primary);height:100%;border-radius:4px;width:{{ round($m->revenue/$maxRevenue*100) }}%"></div>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @else
    <div style="text-align:center;padding:30px;color:var(--text-muted)">
      Chưa có doanh số nào trong năm {{ now()->year }}
    </div>
    @endif
  </div>

  {{-- Thành tích & Mục tiêu --}}
  <div style="display:flex;flex-direction:column;gap:14px">

    <div class="card card-pad">
      <div style="font-weight:600;margin-bottom:14px">🏆 Thành tích</div>
      <div style="display:flex;flex-direction:column;gap:12px">

        {{-- Tỷ lệ tư vấn --}}
        <div>
          <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:4px">
            <span>Tỷ lệ đã tư vấn</span>
            <span style="font-weight:600">
              {{ $stats['total_customers'] > 0 ? round($stats['consulted']/$stats['total_customers']*100) : 0 }}%
            </span>
          </div>
          <div style="background:var(--surface2);border-radius:4px;height:8px">
            <div style="background:#3b82f6;height:100%;border-radius:4px;
                        width:{{ $stats['total_customers'] > 0 ? round($stats['consulted']/$stats['total_customers']*100) : 0 }}%"></div>
          </div>
        </div>

        {{-- Tỷ lệ chốt đơn --}}
        <div>
          <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:4px">
            <span>Tỷ lệ chốt đơn</span>
            <span style="font-weight:600;color:var(--success)">{{ $stats['conversion_rate'] }}%</span>
          </div>
          <div style="background:var(--surface2);border-radius:4px;height:8px">
            <div style="background:var(--success);height:100%;border-radius:4px;
                        width:{{ min($stats['conversion_rate'],100) }}%"></div>
          </div>
        </div>

      </div>
    </div>

    <div class="card card-pad">
      <div style="font-weight:600;margin-bottom:14px">⚡ Thao tác nhanh</div>
      <div style="display:flex;flex-direction:column;gap:8px">
        <a href="{{ route('admin.staff.orders.create') }}" class="btn">+ Tạo đơn mới</a>
        <a href="{{ route('admin.staff.orders.index') }}"  class="btn">📋 Xem đơn hàng</a>
        <a href="{{ route('admin.staff.attendance') }}"    class="btn">📍 Chấm công</a>
        <a href="{{ route('admin.staff.customers') }}"     class="btn">👥 Danh sách khách</a>
      </div>
    </div>

  </div>
</div>

@endsection
