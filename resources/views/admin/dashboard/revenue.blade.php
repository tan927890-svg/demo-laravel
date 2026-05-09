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

@push('styles')
<style>
.rev-page {
  --rp-primary:      #6C63FF;
  --rp-success:      #10B981;
  --rp-warning:      #F59E0B;
  --rp-primary-soft: rgba(108,99,255,.10);
  --rp-success-soft: rgba(16,185,129,.10);
  --rp-warning-soft: rgba(245,158,11,.10);
  --rp-radius:       16px;
  --rp-shadow:       0 2px 16px rgba(108,99,255,.07), 0 1px 4px rgba(0,0,0,.05);
  font-family: 'Be Vietnam Pro', 'Segoe UI', sans-serif;
  /* ✅ Fix: đảm bảo không overflow ngang */
  overflow-x: hidden;
}

/* ── Filter bar ── */
.rev-filter {
  background: #fff;
  border-radius: var(--rp-radius);
  box-shadow: var(--rp-shadow);
  padding: 14px 16px;
  margin-bottom: 14px;
  /* ✅ Fix: box-sizing để padding không vượt width */
  box-sizing: border-box;
  width: 100%;
}
.rev-filter-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
  margin-bottom: 10px;
}
.rev-filter-actions {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
}
.rev-filter label {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: .07em;
  text-transform: uppercase;
  color: #94A3B8;
  display: block;
  margin-bottom: 5px;
}
.rev-filter .form-input {
  width: 100%;
  border: 1.5px solid #E2E8F0;
  border-radius: 10px;
  padding: 9px 10px;
  font-size: 13px;
  background: #F8FAFC;
  color: #1E293B;
  outline: none;
  box-sizing: border-box;
  -webkit-appearance: none;
  transition: border-color .2s;
  /* ✅ Fix: tránh overflow */
  min-width: 0;
}
.rev-filter .form-input:focus { border-color: var(--rp-primary); }
.rev-btn-apply {
  background: var(--rp-primary);
  color: #fff;
  border: none;
  border-radius: 10px;
  padding: 11px 12px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  width: 100%;
  text-align: center;
  box-sizing: border-box;
}
.rev-btn-reset {
  background: #F1F5F9;
  color: #64748B;
  border: none;
  border-radius: 10px;
  padding: 11px 12px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  text-decoration: none;
  display: block;
  text-align: center;
  width: 100%;
  box-sizing: border-box;
}

/* ── Stat cards ──
   ✅ Fix: dùng grid 1 cột trên mobile thay vì scroll ngang
   → hiển thị đủ 3 card, không bị cắt, số không wrap
── */
.rev-stats-wrap {
  margin-bottom: 14px;
}

.rev-stats {
  display: grid;
  grid-template-columns: 1fr;
  gap: 10px;
}

.rev-stat-card {
  background: #fff;
  border-radius: var(--rp-radius);
  box-shadow: var(--rp-shadow);
  padding: 16px 18px;
  display: flex;
  align-items: center;
  gap: 14px;
  width: 100%;
  box-sizing: border-box;
  position: relative;
  overflow: hidden;
}
.rev-stat-card::after {
  content: '';
  position: absolute;
  top: -24px; right: -24px;
  width: 72px; height: 72px;
  border-radius: 50%;
  opacity: .07;
}
.rev-stat-card.s-primary::after { background: var(--rp-primary); }
.rev-stat-card.s-success::after { background: var(--rp-success); }
.rev-stat-card.s-warning::after { background: var(--rp-warning); }

.rev-stat-icon {
  width: 44px; height: 44px;
  border-radius: 13px;
  display: flex; align-items: center; justify-content: center;
  font-size: 20px;
  flex-shrink: 0;
}
.s-primary .rev-stat-icon { background: var(--rp-primary-soft); }
.s-success .rev-stat-icon { background: var(--rp-success-soft); }
.s-warning .rev-stat-icon { background: var(--rp-warning-soft); }

.rev-stat-info {
  /* ✅ Fix: min-width:0 để text không đẩy layout */
  min-width: 0;
  flex: 1;
}

.rev-stat-label {
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .06em;
  color: #94A3B8;
  margin-bottom: 4px;
}
.rev-stat-value {
  /* ✅ Fix: clamp co lại trên màn nhỏ, không wrap */
  font-size: clamp(13px, 4vw, 18px);
  font-weight: 800;
  line-height: 1.2;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.s-primary .rev-stat-value { color: var(--rp-primary); }
.s-success .rev-stat-value { color: var(--rp-success); }
.s-warning .rev-stat-value { color: var(--rp-warning); }
.rev-stat-sub { font-size: 11px; color: #94A3B8; margin-top: 3px; }

/* ── Chart card ── */
.rev-chart-card {
  background: #fff;
  border-radius: var(--rp-radius);
  box-shadow: var(--rp-shadow);
  padding: 18px 16px;
  margin-bottom: 14px;
  box-sizing: border-box;
  width: 100%;
}
.rev-chart-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 14px;
  flex-wrap: wrap;
  gap: 8px;
}
.rev-chart-title {
  font-size: 14px;
  font-weight: 700;
  color: #1E293B;
}
.rev-chart-legend {
  display: flex;
  gap: 12px;
  font-size: 11px;
  color: #94A3B8;
  font-weight: 600;
}
.rev-chart-legend span { display: flex; align-items: center; gap: 5px; }
.rleg-rev  { width: 18px; height: 2.5px; background: #6C63FF; border-radius: 2px; display: inline-block; }
.rleg-comm { width: 18px; height: 0; border-top: 2.5px dashed #10B981; display: inline-block; }

#chartWrap { position: relative; width: 100%; height: 220px; }

/* ── Tooltip ── */
#revTooltip {
  display: none;
  position: absolute;
  background: #fff;
  border: 1.5px solid #EEF2FF;
  border-radius: 12px;
  padding: 12px 14px;
  font-size: 12px;
  pointer-events: none;
  z-index: 100;
  min-width: 170px;
  color: #1E293B;
  box-shadow: 0 8px 32px rgba(108,99,255,.13);
}
#revTooltip .tt-title {
  font-weight: 700;
  font-size: 13px;
  margin-bottom: 8px;
  padding-bottom: 7px;
  border-bottom: 1px solid #EEF2FF;
}
.tt-row {
  display: flex;
  justify-content: space-between;
  gap: 16px;
  margin-bottom: 5px;
  font-size: 12px;
}
.tt-lbl { color: #94A3B8; }

/* ── Staff card ── */
.rev-staff-card {
  background: #fff;
  border-radius: var(--rp-radius);
  box-shadow: var(--rp-shadow);
  overflow: hidden;
  margin-bottom: 14px;
  box-sizing: border-box;
  width: 100%;
}
.rev-staff-head {
  padding: 15px 16px;
  border-bottom: 1.5px solid #F8FAFC;
  font-size: 14px;
  font-weight: 700;
  color: #1E293B;
}
.rev-staff-body { padding: 4px 16px 12px; }
.rev-staff-row {
  padding: 10px 0;
  border-bottom: 1px solid #F8FAFC;
}
.rev-staff-row:last-child { border-bottom: none; }

.rev-staff-meta {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 7px;
  gap: 8px;
}
.rev-staff-name {
  font-size: 13px;
  font-weight: 600;
  color: #1E293B;
  /* ✅ Fix: tránh push layout */
  min-width: 0;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.rev-staff-nums {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 2px;
  font-size: 12px;
  font-weight: 600;
  flex-shrink: 0;
}
.rn-rev  { color: var(--rp-primary); }
.rn-comm { color: var(--rp-success); }
.rn-cnt  { color: #94A3B8; font-weight: 500; font-size: 11px; }

.rev-bar-bg { height: 5px; background: #F1F5F9; border-radius: 4px; overflow: hidden; }
.rev-bar-fill {
  height: 100%;
  background: linear-gradient(90deg, #6C63FF, #A78BFA);
  border-radius: 4px;
  transition: width .5s cubic-bezier(.4,0,.2,1);
}
.rev-staff-foot {
  padding: 9px 16px 12px;
  display: flex;
  gap: 14px;
  font-size: 11px;
  font-weight: 600;
  border-top: 1.5px solid #F8FAFC;
}

/* ── Desktop (≥769px) ── */
@media (min-width: 769px) {
  .rev-filter {
    display: flex;
    gap: 14px;
    align-items: flex-end;
    flex-wrap: wrap;
    padding: 16px 22px;
    margin-bottom: 20px;
  }
  .rev-filter-row  { display: contents; }
  .rev-filter-actions { display: contents; }
  .rev-filter > div { margin: 0; }
  .rev-btn-apply,
  .rev-btn-reset {
    width: auto;
    padding: 9px 22px;
  }

  .rev-stats {
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 20px;
  }
  .rev-stat-card {
    padding: 22px 24px;
  }
  .rev-stat-value { font-size: 21px; }

  .rev-bottom {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
    margin-bottom: 20px;
  }
  .rev-chart-card,
  .rev-staff-card { margin-bottom: 0; }
  #chartWrap { height: 260px; }

  .rev-staff-nums { flex-direction: row; align-items: center; gap: 12px; }
  .rev-staff-nums .rn-cnt { font-size: 12px; }
}
</style>
@endpush

@section('content')
<div class="rev-page">

  {{-- ── Filter ── --}}
  <form method="GET" action="{{ route('admin.dashboard.revenue') }}">
    <div class="rev-filter">
      <div class="rev-filter-row">
        <div>
          <label>Năm</label>
          <select name="year" class="form-input">
            @foreach(range(now()->year, now()->year - 3) as $y)
              <option value="{{ $y }}" @selected($year == $y)>{{ $y }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label>Nhân viên</label>
          <select name="staff_id" class="form-input">
            <option value="">Tất cả</option>
            @foreach($staffList as $s)
              <option value="{{ $s->id }}" @selected($staffId == $s->id)>{{ $s->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="rev-filter-actions">
        <button type="submit" class="rev-btn-apply">Xem báo cáo</button>
        <a href="{{ route('admin.dashboard.revenue') }}" class="rev-btn-reset">Xóa lọc</a>
      </div>
    </div>
  </form>

  {{-- ── Stat Cards ── --}}
  <div class="rev-stats-wrap">
    <div class="rev-stats">
      <div class="rev-stat-card s-primary">
        <div class="rev-stat-icon">💰</div>
        <div class="rev-stat-info">
          <div class="rev-stat-label">Tổng doanh thu</div>
          <div class="rev-stat-value">{{ number_format($revenueStats['total_revenue'], 0, ',', '.') }}đ</div>
          <div class="rev-stat-sub">{{ $revenueStats['total_orders'] }} đơn đã chốt</div>
        </div>
      </div>
      <div class="rev-stat-card s-success">
        <div class="rev-stat-icon">🤝</div>
        <div class="rev-stat-info">
          <div class="rev-stat-label">Tổng hoa hồng đã trả</div>
          <div class="rev-stat-value">{{ number_format($revenueStats['total_commission'], 0, ',', '.') }}đ</div>
        </div>
      </div>
      <div class="rev-stat-card s-warning">
        <div class="rev-stat-icon">📈</div>
        <div class="rev-stat-info">
          <div class="rev-stat-label">Lợi nhuận sau hoa hồng</div>
          <div class="rev-stat-value">{{ number_format($revenueStats['total_revenue'] - $revenueStats['total_commission'], 0, ',', '.') }}đ</div>
        </div>
      </div>
    </div>
  </div>

  {{-- ── Desktop: 2 cột / Mobile: xếp dọc ── --}}
  <div class="rev-bottom">

    {{-- Chart --}}
    <div class="rev-chart-card">
      <div class="rev-chart-header">
        <div class="rev-chart-title">📊 Doanh thu theo tháng – {{ $year }}</div>
        <div class="rev-chart-legend">
          <span><span class="rleg-rev"></span>Doanh thu</span>
          <span><span class="rleg-comm"></span>Hoa hồng</span>
        </div>
      </div>
      <div id="chartWrap">
        <canvas id="revenueChart"></canvas>
        <div id="revTooltip">
          <div class="tt-title"></div>
          <div class="tt-body"></div>
        </div>
      </div>
    </div>

    {{-- Staff --}}
    <div class="rev-staff-card">
      <div class="rev-staff-head">👥 Doanh thu theo nhân viên</div>
      <div class="rev-staff-body">
        @php $maxRev = $staffRevenue->max('revenue_sum') ?: 1; @endphp
        @forelse($staffRevenue as $s)
        <div class="rev-staff-row">
          <div class="rev-staff-meta">
            <span class="rev-staff-name">{{ $s->name }}</span>
            <div class="rev-staff-nums">
              <span class="rn-rev">{{ number_format($s->revenue_sum ?? 0, 0, ',', '.') }}đ</span>
              <span class="rn-comm">{{ number_format($s->commission_sum ?? 0, 0, ',', '.') }}đ</span>
              <span class="rn-cnt">{{ $s->closed_count }} đơn</span>
            </div>
          </div>
          <div class="rev-bar-bg">
            <div class="rev-bar-fill"
                 style="width:{{ $maxRev > 0 ? round(($s->revenue_sum ?? 0) / $maxRev * 100) : 0 }}%">
            </div>
          </div>
        </div>
        @empty
        <div style="text-align:center;padding:32px 0;color:#94A3B8;font-size:14px">Chưa có dữ liệu</div>
        @endforelse
      </div>
      <div class="rev-staff-foot">
        <span class="rn-rev">▪ Doanh thu</span>
        <span class="rn-comm">▪ Hoa hồng</span>
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

  var ttip    = document.getElementById('revTooltip');
  var ttTitle = ttip.querySelector('.tt-title');
  var ttBody  = ttip.querySelector('.tt-body');

  new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
      labels: MONTHS,
      datasets: [
        {
          label: 'Doanh thu',
          data: revenueData,
          borderColor: '#6C63FF',
          backgroundColor: 'rgba(108,99,255,0.08)',
          borderWidth: 2.5,
          pointRadius: 3,
          pointHoverRadius: 6,
          pointBackgroundColor: '#6C63FF',
          pointHoverBackgroundColor: '#ffffff',
          pointHoverBorderColor: '#6C63FF',
          pointHoverBorderWidth: 2.5,
          fill: true,
          tension: 0.4,
        },
        {
          label: 'Hoa hồng',
          data: commData,
          borderColor: '#10B981',
          borderWidth: 2,
          borderDash: [5, 4],
          pointRadius: 2,
          pointHoverRadius: 5,
          pointBackgroundColor: '#10B981',
          fill: false,
          tension: 0.4,
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

            ttTitle.textContent = 'Tháng ' + (i + 1) + ' – ' + chartYear;
            ttBody.innerHTML =
              '<div class="tt-row"><span class="tt-lbl">Doanh thu</span><span style="font-weight:700;color:#6C63FF">' + fmtVND(revenueData[i]) + '</span></div>' +
              '<div class="tt-row"><span class="tt-lbl">Hoa hồng</span><span style="font-weight:700;color:#10B981">' + fmtVND(commData[i]) + '</span></div>' +
              '<div class="tt-row"><span class="tt-lbl">Số đơn</span><span style="font-weight:700">' + countData[i] + '</span></div>';

            ttip.style.display = 'block';
            var wrap = document.getElementById('chartWrap');
            var ww   = wrap.offsetWidth;
            var tw   = ttip.offsetWidth || 180;
            var lx   = t.caretX + 14;
            if (lx + tw > ww) lx = t.caretX - tw - 14;
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
          grid: { color: 'rgba(100,116,139,.08)' },
          ticks: {
            color: '#94A3B8',
            font: { size: 11, weight: '500' },
            autoSkip: false,
            maxRotation: 0,
          },
          border: { color: 'transparent' }
        },
        y: {
          grid: { color: 'rgba(100,116,139,.08)' },
          ticks: {
            color: '#94A3B8',
            font: { size: 11 },
            maxTicksLimit: 5,
            callback: function(v) {
              if (v >= 1e9) return (v / 1e9).toFixed(1) + 'tỷ';
              if (v >= 1e6) return (v / 1e6).toFixed(0) + 'tr';
              return v;
            }
          },
          border: { color: 'transparent' }
        }
      }
    }
  });
})();
</script>
@endpush