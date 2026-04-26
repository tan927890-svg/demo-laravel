@extends('layouts.admin')
@section('page-title', 'Báo cáo doanh thu')

@section('topbar-actions')
  <a href="{{ route('admin.dashboard') }}" class="btn btn-sm" style="color:var(--text-muted)">← Quay lại</a>
@endsection

@php
  $revenueByMonth = [];
  $commByMonth    = [];
  $countByMonth   = [];
  $totalRev  = $revenueStats['total_revenue'] ?: 1;
  $totalComm = $revenueStats['total_commission'];
  $ratio     = $totalRev > 0 ? $totalComm / $totalRev : 0;
  for ($m = 1; $m <= 12; $m++) {
      $row = $monthlyRevenue->get($m);
      $rev = $row ? (float)$row->total : 0;
      $revenueByMonth[] = $rev;
      $commByMonth[]    = round($rev * $ratio);
      $countByMonth[]   = $row ? (int)$row->count : 0;
  }
@endphp

@section('content')

{{-- Filter --}}
<div class="card card-pad" style="margin-bottom:16px">
  <form method="GET" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap">
    <div>
      <label style="font-size:12px;color:var(--text-muted);display:block;margin-bottom:4px">Năm</label>
      <select name="year" class="form-input">
        @foreach(range(now()->year, now()->year - 3) as $y)
          <option value="{{ $y }}" @selected($year == $y)>{{ $y }}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label style="font-size:12px;color:var(--text-muted);display:block;margin-bottom:4px">Nhân viên</label>
      <select name="staff_id" class="form-input" style="width:160px">
        <option value="">Tất cả</option>
        @foreach($staffList as $s)
          <option value="{{ $s->id }}" @selected($staffId == $s->id)>{{ $s->name }}</option>
        @endforeach
      </select>
    </div>
    <button type="submit" class="btn">Xem báo cáo</button>
    <a href="{{ route('admin.dashboard.revenue') }}" class="btn" style="background:var(--surface2)">Xóa lọc</a>
  </form>
</div>

{{-- Tổng kết --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px">
  <div class="card card-pad" style="text-align:center">
    <div style="font-size:12px;color:var(--text-muted)">Tổng doanh thu</div>
    <div style="font-size:24px;font-weight:700;color:var(--primary);margin-top:4px">
      {{ number_format($revenueStats['total_revenue'], 0, ',', '.') }}đ
    </div>
    <div style="font-size:11px;color:var(--text-muted);margin-top:2px">
      {{ $revenueStats['total_orders'] }} đơn đã chốt
    </div>
  </div>
  <div class="card card-pad" style="text-align:center">
    <div style="font-size:12px;color:var(--text-muted)">Tổng hoa hồng đã trả</div>
    <div style="font-size:24px;font-weight:700;color:var(--success);margin-top:4px">
      {{ number_format($revenueStats['total_commission'], 0, ',', '.') }}đ
    </div>
  </div>
  <div class="card card-pad" style="text-align:center">
    <div style="font-size:12px;color:var(--text-muted)">Lợi nhuận sau hoa hồng</div>
    <div style="font-size:24px;font-weight:700;color:var(--warning);margin-top:4px">
      {{ number_format($revenueStats['total_revenue'] - $revenueStats['total_commission'], 0, ',', '.') }}đ
    </div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px">

  {{-- Biểu đồ Line Chart --}}
  <div class="card card-pad">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:8px">
      <div style="font-weight:600;color:var(--text)">📊 Doanh thu theo tháng – {{ $year }}</div>
      <div style="display:flex;gap:14px;font-size:12px;color:var(--text-muted)">
        <span style="display:flex;align-items:center;gap:5px">
          <span style="width:20px;height:2px;background:#7F77DD;display:inline-block;border-radius:2px"></span>Doanh thu
        </span>
        <span style="display:flex;align-items:center;gap:5px">
          <span style="width:20px;height:0;border-top:2px dashed #1D9E75;display:inline-block"></span>Hoa hồng
        </span>
      </div>
    </div>
    <div id="chartWrap" style="position:relative;width:100%;height:260px;overflow:visible">
      <canvas id="revenueChart"></canvas>
      <div id="chartTooltip" style="display:none;position:absolute;background:var(--surface,#fff);border:1px solid var(--border,#e0e0e0);border-radius:10px;padding:13px 17px;font-size:14px;pointer-events:none;z-index:100;min-width:190px;color:var(--text,#555)"></div>
    </div>
  </div>

  {{-- Doanh thu theo nhân viên --}}
  <div class="card">
    <div style="padding:14px 18px;border-bottom:1px solid var(--border);font-weight:600;color:var(--text)">
      👥 Doanh thu theo nhân viên
    </div>
    <div style="padding:12px 18px">
      @php $maxRev = $staffRevenue->max('revenue_sum') ?: 1; @endphp
      @forelse($staffRevenue as $s)
      <div style="padding:10px 0;border-bottom:1px solid var(--border)">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;flex-wrap:wrap;gap:4px">
          <span style="font-size:13px;font-weight:500;color:var(--text)">{{ $s->name }}</span>
          <div style="display:flex;gap:12px;font-size:12px">
            <span style="color:#7F77DD;font-weight:600">{{ number_format($s->revenue_sum ?? 0, 0, ',', '.') }}đ</span>
            <span style="color:#1D9E75">{{ number_format($s->commission_sum ?? 0, 0, ',', '.') }}đ</span>
            <span style="color:var(--text-muted)">{{ $s->closed_count }} đơn</span>
          </div>
        </div>
        <div style="height:5px;background:var(--surface2);border-radius:4px;overflow:hidden">
          <div style="height:100%;width:{{ $maxRev > 0 ? round(($s->revenue_sum ?? 0) / $maxRev * 100) : 0 }}%;background:#7F77DD;border-radius:4px;transition:width .4s"></div>
        </div>
      </div>
      @empty
      <div style="text-align:center;padding:20px;color:var(--text-muted)">Chưa có dữ liệu</div>
      @endforelse
      <div style="padding-top:8px;display:flex;gap:14px;font-size:11px;color:var(--text-muted)">
        <span style="color:#7F77DD">▪ Doanh thu</span>
        <span style="color:#1D9E75">▪ Hoa hồng</span>
      </div>
    </div>
  </div>

</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script>
(function () {
  var revenueData = {{ json_encode($revenueByMonth) }};
  var commData    = {{ json_encode($commByMonth) }};
  var countData   = {{ json_encode($countByMonth) }};
  var chartYear   = {{ $year }};
  var MONTHS = ['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'];

  function fmtVND(v) {
    if (v >= 1e9) return (v / 1e9).toFixed(2) + ' tỷ';
    if (v >= 1e6) return (v / 1e6).toFixed(0) + ' tr';
    return Number(v).toLocaleString('vi-VN') + 'đ';
  }

  var ttip = document.getElementById('chartTooltip');

  new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
      labels: MONTHS,
      datasets: [
        {
          label: 'Doanh thu',
          data: revenueData,
          borderColor: '#7F77DD',
          backgroundColor: 'rgba(127,119,221,0.08)',
          borderWidth: 2,
          pointRadius: 4,
          pointHoverRadius: 7,
          pointBackgroundColor: '#7F77DD',
          pointHoverBackgroundColor: '#ffffff',
          pointHoverBorderColor: '#7F77DD',
          pointHoverBorderWidth: 2,
          fill: true,
          tension: 0.35,
        },
        {
          label: 'Hoa hồng',
          data: commData,
          borderColor: '#1D9E75',
          borderWidth: 2,
          borderDash: [5, 4],
          pointRadius: 3,
          pointHoverRadius: 6,
          pointBackgroundColor: '#1D9E75',
          pointHoverBackgroundColor: '#ffffff',
          pointHoverBorderColor: '#1D9E75',
          pointHoverBorderWidth: 2,
          fill: false,
          tension: 0.35,
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: { mode: 'index', intersect: false },
      plugins: {
        legend: { display: false },
        tooltip: {
          enabled: false,
          external: function(ctx) {
            var t = ctx.tooltip;
            if (t.opacity === 0) { ttip.style.display = 'none'; return; }
            var i = t.dataPoints && t.dataPoints[0] ? t.dataPoints[0].dataIndex : null;
            if (i === null) return;
            ttip.innerHTML =
              '<div style="font-weight:600;margin-bottom:10px;font-size:15px">' +
                'Tháng ' + (i + 1) + ' \u2013 ' + chartYear +
              '</div>' +
              '<div style="display:flex;flex-direction:column;gap:7px">' +
                '<div style="display:flex;justify-content:space-between;gap:24px">' +
                  '<span style="opacity:.7">Doanh thu</span>' +
                  '<span style="font-weight:600;color:#7F77DD">' + fmtVND(revenueData[i]) + '</span>' +
                '</div>' +
                '<div style="display:flex;justify-content:space-between;gap:24px">' +
                  '<span style="opacity:.7">Hoa hồng</span>' +
                  '<span style="font-weight:600;color:#1D9E75">' + fmtVND(commData[i]) + '</span>' +
                '</div>' +
                '<div style="display:flex;justify-content:space-between;gap:24px">' +
                  '<span style="opacity:.7">Số đơn</span>' +
                  '<span style="font-weight:600">' + countData[i] + '</span>' +
                '</div>' +
              '</div>';
            ttip.style.display = 'block';
            var wrap = document.getElementById('chartWrap');
            var ww = wrap.offsetWidth;
            var tw = ttip.offsetWidth || 200;
            var lx = t.caretX + 16;
            if (lx + tw > ww) lx = t.caretX - tw - 16;
            if (lx < 0) lx = 4;
            var ly = t.caretY - 40;
            if (ly < 0) ly = 4;
            ttip.style.left = lx + 'px';
            ttip.style.top  = ly + 'px';
          }
        }
      },
      scales: {
        x: {
          grid: { color: 'rgba(128,128,128,0.12)' },
          ticks: { color: '#888', font: { size: 12 }, autoSkip: false },
          border: { color: 'rgba(128,128,128,0.12)' }
        },
        y: {
          grid: { color: 'rgba(128,128,128,0.12)' },
          ticks: {
            color: '#888',
            font: { size: 12 },
            callback: function(v) {
              if (v >= 1e9) return (v / 1e9).toFixed(1) + 'tỷ';
              if (v >= 1e6) return (v / 1e6).toFixed(0) + 'tr';
              return v;
            }
          },
          border: { color: 'rgba(128,128,128,0.12)' }
        }
      }
    }
  });
})();
</script>
@endpush