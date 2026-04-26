@extends('layouts.admin')
@section('page-title', 'Bảng tổng')

@push('styles')
<style>
/* ── Stat cards ── */
.dash-stat {
  border-radius: 10px; padding: 18px 20px;
  position: relative; overflow: hidden;
  border-left: 5px solid transparent;
}
.dash-stat.s-blue   { border-left-color: #3b82f6 }
.dash-stat.s-green  { border-left-color: #22c55e }
.dash-stat.s-amber  { border-left-color: #f59e0b }
.dash-stat.s-red    { border-left-color: #ef4444 }
.dash-stat.s-purple { border-left-color: #a855f7 }
.dash-stat-icon {
  position:absolute;top:14px;right:16px;
  font-size:40px;opacity:.65;
  line-height:1;
}
.dash-stat-label { font-size:14px;color:var(--text-muted);text-transform:uppercase;letter-spacing:.6px;margin-bottom:6px }
.dash-stat-val   { font-size:32px;font-weight:700;line-height:1 }
.dash-stat-sub   { font-size:13px;color:var(--text-muted);margin-top:5px }

/* ── Donut ── */
.donut-wrap { position:relative;flex-shrink:0 }
.donut-wrap svg { display:block }
.donut-center {
  position:absolute;inset:0;
  display:flex;flex-direction:column;align-items:center;justify-content:center;
}
.donut-pct { font-size:26px;font-weight:700;line-height:1 }
.donut-lbl { font-size:13px;color:var(--text-muted);margin-top:2px }

/* ── Legend ── */
.leg-row {
  display:flex;align-items:center;justify-content:space-between;
  font-size:15px;padding:8px 0;border-bottom:1px solid var(--border);
}
.leg-row:last-child { border-bottom:none }
.leg-dot { width:11px;height:11px;border-radius:50%;margin-right:8px;flex-shrink:0;display:inline-block }

/* ── Layout ── */
.dash-grid-stats {
  display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:14px;
}
.dash-grid-main {
  display:grid;gap:14px;
  height: calc(100vh - 232px);
  min-height: 380px;
}
.dash-grid-main.col-3 { grid-template-columns: 1.6fr 1fr 1fr }
.dash-panel { display:flex;flex-direction:column;overflow:hidden }

/* ── Table trong panel ── */
.dash-panel .table th { font-size:13px }
.dash-panel .table td { font-size:15px;padding:10px 12px }

/* ── Panel header ── */
.panel-hd {
  padding:14px 18px;border-bottom:1px solid var(--border);
  font-weight:600;font-size:16px;flex-shrink:0;
  display:flex;align-items:center;justify-content:space-between;
}

/* ══════════════════════════════
   RESPONSIVE — Tablet (≤ 1024px)
══════════════════════════════ */
@media (max-width: 1024px) {
  .dash-grid-stats {
    grid-template-columns: repeat(2, 1fr);
  }
  .dash-grid-main.col-3 {
    grid-template-columns: 1fr 1fr;
  }
  .dash-grid-main.col-3 > .card:first-child {
    grid-column: 1 / -1;
  }
}

/* ══════════════════════════════
   RESPONSIVE — Mobile (≤ 768px)
══════════════════════════════ */
@media (max-width: 768px) {

  /* Stats: 2 cột */
  .dash-grid-stats {
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    margin-bottom: 10px;
  }

  .dash-stat {
    padding: 16px 14px;
  }

  .dash-stat-icon {
    font-size: 34px;
    top: 12px; right: 12px;
  }

  .dash-stat-label { font-size: 11px; margin-bottom: 4px; letter-spacing: .4px; }
  .dash-stat-val   { font-size: 28px; }
  .dash-stat-sub   { font-size: 12px; }

  /* Main grid: 1 cột dọc */
  .dash-grid-main,
  .dash-grid-main.col-3 {
    grid-template-columns: 1fr !important;
    height: auto !important;
    min-height: unset;
  }

  .dash-panel {
    min-height: 220px;
  }

  .panel-hd {
    font-size: 15px;
    padding: 12px 14px;
  }

  .dash-panel .table th { font-size: 12px; padding: 8px 10px; }
  .dash-panel .table td { font-size: 14px; padding: 9px 10px; }

  .leg-row  { font-size: 14px; padding: 7px 0; }
  .leg-dot  { width: 10px; height: 10px; }

  .donut-pct { font-size: 24px; }
  .donut-lbl { font-size: 12px; }

  /* Thao tác nhanh — nút to hơn trên mobile */
  .dash-panel .btn {
    padding: 14px !important;
    font-size: 15px;
  }
}

/* ══════════════════════════════
   RESPONSIVE — Small Mobile (≤ 480px)
══════════════════════════════ */
@media (max-width: 480px) {

  .dash-grid-stats {
    grid-template-columns: 1fr 1fr;
    gap: 8px;
  }

  .dash-stat {
    padding: 13px 12px;
  }

  .dash-stat-icon  { font-size: 28px; opacity: .60; }
  .dash-stat-label { font-size: 10px; letter-spacing: .2px; }
  .dash-stat-val   { font-size: 24px; }
  .dash-stat-sub   { font-size: 11px; }

  .panel-hd { font-size: 14px; padding: 11px 12px; }

  .dash-panel .table th { font-size: 11px; }
  .dash-panel .table td { font-size: 13px; padding: 8px 8px; }

  .leg-row  { font-size: 13px; }

  .donut-pct { font-size: 20px; }
}
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════
     ADMIN DASHBOARD
═══════════════════════════════════ --}}
@if(auth()->user()->isAdmin())

<div class="dash-grid-stats">
  <div class="card dash-stat s-blue">
    <div class="dash-stat-icon">💰</div>
    <div class="dash-stat-label">Tổng doanh thu</div>
    <div class="dash-stat-val" style="font-size:24px;color:var(--primary)">
      {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}đ
    </div>
    <div class="dash-stat-sub">Đơn đã chốt</div>
  </div>
  <div class="card dash-stat s-green">
    <div class="dash-stat-icon">📦</div>
    <div class="dash-stat-label">Tổng đơn hàng</div>
    <div class="dash-stat-val">{{ $stats['total_orders'] ?? 0 }}</div>
    <div class="dash-stat-sub" style="color:var(--success)">{{ $stats['closed_orders'] ?? 0 }} đã chốt</div>
  </div>
  <div class="card dash-stat s-amber">
    <div class="dash-stat-icon">🚗</div>
    <div class="dash-stat-label">Xe sẵn có</div>
    <div class="dash-stat-val">{{ $stats['available_cars'] ?? 0 }}</div>
    <div class="dash-stat-sub">/ {{ $stats['total_cars'] ?? 0 }} tổng</div>
  </div>
  <div class="card dash-stat s-red">
    <div class="dash-stat-icon">📧</div>
    <div class="dash-stat-label">Liên hệ chưa đọc</div>
    <div class="dash-stat-val" style="color:var(--danger)">{{ $stats['unread_contacts'] ?? 0 }}</div>
    <div class="dash-stat-sub">/ {{ $stats['total_contacts'] ?? 0 }} tổng</div>
  </div>
</div>

@if(isset($topStaff) && $topStaff->count())
@php
  $totalOrd  = max($stats['total_orders'] ?? 1, 1);
  $closedOrd = $stats['closed_orders'] ?? 0;
  $openOrd   = $totalOrd - $closedOrd;
  $r1 = 42; $c1 = 2*M_PI*$r1;
  $d1close = $c1*($closedOrd/$totalOrd);
  $d1open  = $c1*($openOrd /$totalOrd);
  $pct1    = round($closedOrd/$totalOrd*100);

  $totalCars = max($stats['total_cars'] ?? 1, 1);
  $availCars = $stats['available_cars'] ?? 0;
  $usedCars  = $totalCars - $availCars;
  $r2 = 42; $c2 = 2*M_PI*$r2;
  $d2avail = $c2*($availCars/$totalCars);
  $d2used  = $c2*($usedCars /$totalCars);
  $pct2    = round($availCars/$totalCars*100);
@endphp

<div class="dash-grid-main col-3">

  {{-- Top nhân viên --}}
  <div class="card dash-panel">
    <div class="panel-hd">🏆 Top nhân viên bán hàng</div>
    <div style="flex:1;overflow-y:auto">
      <table class="table">
        <thead><tr><th>#</th><th>Nhân viên</th><th>Đơn chốt</th><th>Doanh thu</th></tr></thead>
        <tbody>
          @foreach($topStaff as $i => $staff)
          <tr>
            <td>
              @if($i==0)🥇@elseif($i==1)🥈@elseif($i==2)🥉
              @else<span style="color:var(--text-muted)">{{ $i+1 }}</span>@endif
            </td>
            <td style="font-weight:500">{{ $staff->name }}</td>
            <td>{{ $staff->closed_count }}</td>
            <td style="color:var(--primary);font-weight:600">
              {{ number_format($staff->revenue_sum ?? 0, 0, ',', '.') }}đ
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div style="padding:12px 16px;border-top:1px solid var(--border);display:flex;gap:8px;flex-shrink:0">
      <a href="{{ route('admin.users.index') }}"  class="btn btn-sm" style="flex:1;text-align:center">👥 Quản lý NV</a>
      <a href="{{ route('admin.orders.index') }}" class="btn btn-sm" style="flex:1;text-align:center">📦 Đơn hàng</a>
    </div>
  </div>

  {{-- Donut: tỉ lệ đơn --}}
  <div class="card dash-panel">
    <div class="panel-hd">🥧 Tỉ lệ đơn hàng</div>
    <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:20px;padding:20px 18px">
      <div class="donut-wrap" style="width:130px;height:130px">
        <svg viewBox="0 0 100 100" width="130" height="130" style="transform:rotate(-90deg)">
          <circle cx="50" cy="50" r="{{ $r1 }}" fill="none" stroke="var(--border)" stroke-width="13"/>
          @if($openOrd > 0)
          <circle cx="50" cy="50" r="{{ $r1 }}" fill="none" stroke="#e2e8f0" stroke-width="13"
            stroke-dasharray="{{ $d1open }} {{ $c1 }}" stroke-dashoffset="{{ -$d1close }}"/>
          @endif
          @if($closedOrd > 0)
          <circle cx="50" cy="50" r="{{ $r1 }}" fill="none" stroke="#22c55e" stroke-width="13"
            stroke-dasharray="{{ $d1close }} {{ $c1 }}" stroke-dashoffset="0"/>
          @endif
        </svg>
        <div class="donut-center">
          <span class="donut-pct">{{ $pct1 }}%</span>
          <span class="donut-lbl">chốt</span>
        </div>
      </div>
      <div style="width:100%">
        <div class="leg-row">
          <span><span class="leg-dot" style="background:#22c55e"></span>Đã chốt</span>
          <strong>{{ $closedOrd }}</strong>
        </div>
        <div class="leg-row">
          <span><span class="leg-dot" style="background:#e2e8f0"></span>Chưa chốt</span>
          <strong>{{ $openOrd }}</strong>
        </div>
        <div class="leg-row">
          <span style="color:var(--text-muted)">Tổng cộng</span>
          <strong>{{ $totalOrd }}</strong>
        </div>
      </div>
    </div>
  </div>

  {{-- Donut: kho xe + thao tác nhanh --}}
  <div class="card dash-panel">
    <div class="panel-hd">🚗 Kho xe</div>
    <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;padding:16px 18px">
      <div class="donut-wrap" style="width:120px;height:120px">
        <svg viewBox="0 0 100 100" width="120" height="120" style="transform:rotate(-90deg)">
          <circle cx="50" cy="50" r="{{ $r2 }}" fill="none" stroke="var(--border)" stroke-width="13"/>
          @if($usedCars > 0)
          <circle cx="50" cy="50" r="{{ $r2 }}" fill="none" stroke="#f59e0b" stroke-width="13"
            stroke-dasharray="{{ $d2used }} {{ $c2 }}" stroke-dashoffset="{{ -$d2avail }}"/>
          @endif
          @if($availCars > 0)
          <circle cx="50" cy="50" r="{{ $r2 }}" fill="none" stroke="#3b82f6" stroke-width="13"
            stroke-dasharray="{{ $d2avail }} {{ $c2 }}" stroke-dashoffset="0"/>
          @endif
        </svg>
        <div class="donut-center">
          <span class="donut-pct">{{ $pct2 }}%</span>
          <span class="donut-lbl">sẵn có</span>
        </div>
      </div>
      <div style="width:100%">
        <div class="leg-row">
          <span><span class="leg-dot" style="background:#3b82f6"></span>Sẵn có</span>
          <strong>{{ $availCars }}</strong>
        </div>
        <div class="leg-row">
          <span><span class="leg-dot" style="background:#f59e0b"></span>Đang sử dụng</span>
          <strong>{{ $usedCars }}</strong>
        </div>
      </div>
      <div style="width:100%;display:flex;flex-direction:column;gap:8px">
        <a href="{{ route('admin.cars.create') }}"       class="btn" style="text-align:center">+ Thêm xe mới</a>
        <a href="{{ route('admin.dashboard.revenue') }}" class="btn" style="text-align:center">📊 Báo cáo doanh thu</a>
        <a href="{{ route('admin.contacts.index') }}"    class="btn" style="text-align:center">📧 Liên hệ</a>
      </div>
    </div>
  </div>

</div>
@endif


{{-- ═══════════════════════════════════
     MANAGER DASHBOARD
═══════════════════════════════════ --}}
@elseif(auth()->user()->isManager())

<div class="dash-grid-stats">
  <div class="card dash-stat s-blue">
    <div class="dash-stat-icon">💰</div>
    <div class="dash-stat-label">Doanh thu team</div>
    <div class="dash-stat-val" style="font-size:24px;color:var(--primary)">
      {{ number_format($stats['team_revenue'] ?? 0, 0, ',', '.') }}đ
    </div>
  </div>
  <div class="card dash-stat s-green">
    <div class="dash-stat-icon">✅</div>
    <div class="dash-stat-label">Đơn đã chốt</div>
    <div class="dash-stat-val" style="color:var(--success)">{{ $stats['closed_orders'] ?? 0 }}</div>
  </div>
  <div class="card dash-stat s-amber">
    <div class="dash-stat-icon">⏳</div>
    <div class="dash-stat-label">Chờ duyệt</div>
    <div class="dash-stat-val" style="color:var(--warning)">{{ $stats['pending_review'] ?? 0 }}</div>
    <div class="dash-stat-sub">Đơn "Đã tư vấn"</div>
  </div>
  <div class="card dash-stat s-purple">
    <div class="dash-stat-icon">📋</div>
    <div class="dash-stat-label">Tổng đơn</div>
    <div class="dash-stat-val">{{ $stats['team_orders'] ?? 0 }}</div>
  </div>
</div>

@php
  $tTotal   = max($stats['team_orders'] ?? 1, 1);
  $tClosed  = $stats['closed_orders']  ?? 0;
  $tPending = $stats['pending_review'] ?? 0;
  $tOther   = max($tTotal - $tClosed - $tPending, 0);
  $rT = 42; $cT = 2*M_PI*$rT;
  $dTC = $cT*($tClosed /$tTotal);
  $dTP = $cT*($tPending/$tTotal);
  $dTO = $cT*($tOther  /$tTotal);
  $pctT = round($tClosed/$tTotal*100);
@endphp

<div class="dash-grid-main col-3">

  {{-- Đơn chờ chốt --}}
  <div class="card dash-panel">
    <div class="panel-hd">
      <span>⏳ Đơn chờ chốt</span>
      <a href="{{ route('admin.orders.index', ['consultation_status' => 'da_tu_van']) }}"
         style="font-size:14px;color:var(--primary);font-weight:400">Xem tất cả →</a>
    </div>
    <div style="flex:1;overflow-y:auto">
      <table class="table">
        <thead><tr><th>Khách</th><th>Xe</th><th>NV</th><th></th></tr></thead>
        <tbody>
          @forelse($recentOrders ?? [] as $order)
          <tr>
            <td style="font-weight:500">{{ $order->customer_name }}</td>
            <td style="color:var(--text-muted)">{{ $order->car->name ?? 'N/A' }}</td>
            <td>{{ $order->assignedStaff->name ?? '—' }}</td>
            <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm">Chốt</a></td>
          </tr>
          @empty
          <tr><td colspan="4" style="text-align:center;padding:40px;color:var(--text-muted)">Không có đơn chờ duyệt</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- Donut: tỉ lệ team --}}
  <div class="card dash-panel">
    <div class="panel-hd">🥧 Tỉ lệ đơn team</div>
    <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:20px;padding:20px 18px">
      <div class="donut-wrap" style="width:130px;height:130px">
        <svg viewBox="0 0 100 100" width="130" height="130" style="transform:rotate(-90deg)">
          <circle cx="50" cy="50" r="{{ $rT }}" fill="none" stroke="var(--border)" stroke-width="13"/>
          @if($tOther > 0)
          <circle cx="50" cy="50" r="{{ $rT }}" fill="none" stroke="#e2e8f0" stroke-width="13"
            stroke-dasharray="{{ $dTO }} {{ $cT }}" stroke-dashoffset="{{ -$dTC - $dTP }}"/>
          @endif
          @if($tPending > 0)
          <circle cx="50" cy="50" r="{{ $rT }}" fill="none" stroke="#f59e0b" stroke-width="13"
            stroke-dasharray="{{ $dTP }} {{ $cT }}" stroke-dashoffset="{{ -$dTC }}"/>
          @endif
          @if($tClosed > 0)
          <circle cx="50" cy="50" r="{{ $rT }}" fill="none" stroke="#22c55e" stroke-width="13"
            stroke-dasharray="{{ $dTC }} {{ $cT }}" stroke-dashoffset="0"/>
          @endif
        </svg>
        <div class="donut-center">
          <span class="donut-pct">{{ $pctT }}%</span>
          <span class="donut-lbl">chốt</span>
        </div>
      </div>
      <div style="width:100%">
        <div class="leg-row">
          <span><span class="leg-dot" style="background:#22c55e"></span>Đã chốt</span>
          <strong>{{ $tClosed }}</strong>
        </div>
        <div class="leg-row">
          <span><span class="leg-dot" style="background:#f59e0b"></span>Chờ duyệt</span>
          <strong>{{ $tPending }}</strong>
        </div>
        <div class="leg-row">
          <span><span class="leg-dot" style="background:#e2e8f0"></span>Đang xử lý</span>
          <strong>{{ $tOther }}</strong>
        </div>
      </div>
    </div>
  </div>

  {{-- Hiệu suất nhân viên --}}
  <div class="card dash-panel">
    <div class="panel-hd">👥 Hiệu suất nhân viên</div>
    <div style="flex:1;overflow-y:auto;padding:16px 18px">
      @forelse($staffPerformance ?? [] as $staff)
      @php
        $swTotal  = (int) $staff->total_orders_count;
        $swClosed = (int) $staff->closed_count;
        $sw = $swTotal > 0 ? round($swClosed / $swTotal * 100) : 0;
        $sc = $sw >= 60 ? '#22c55e' : ($sw >= 40 ? '#3b82f6' : '#f59e0b');
      @endphp
      <div style="margin-bottom:18px">
        <div style="display:flex;justify-content:space-between;font-size:15px;font-weight:500;margin-bottom:6px">
          <span>{{ $staff->name }}</span>
          <span style="color:var(--text-muted);font-weight:400">{{ $swClosed }}/{{ $swTotal }} đơn</span>
        </div>
        <div style="background:var(--border);border-radius:5px;height:10px;overflow:hidden">
          <div style="width:{{ $sw }}%;height:100%;border-radius:5px;background:{{ $sc }};transition:width .4s ease"></div>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:13px;margin-top:5px">
          <span style="color:var(--text-muted)">{{ number_format($staff->revenue_sum ?? 0, 0, ',', '.') }}đ</span>
          <span style="color:{{ $sc }};font-weight:600">{{ $sw }}% chốt</span>
        </div>
      </div>
      @empty
      <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;color:var(--text-muted)">
        <div style="font-size:40px;margin-bottom:12px">📭</div>
        <div style="font-size:15px">Chưa có dữ liệu nhân viên</div>
      </div>
      @endforelse
    </div>
  </div>

</div>


{{-- ═══════════════════════════════════
     STAFF DASHBOARD
═══════════════════════════════════ --}}
@else

<div class="dash-grid-stats">
  <div class="card dash-stat s-blue">
    <div class="dash-stat-icon">👥</div>
    <div class="dash-stat-label">Tổng khách</div>
    <div class="dash-stat-val">{{ $stats['my_orders'] ?? 0 }}</div>
  </div>
  <div class="card dash-stat s-amber">
    <div class="dash-stat-icon">💬</div>
    <div class="dash-stat-label">Đang tư vấn</div>
    <div class="dash-stat-val" style="color:var(--warning)">{{ $stats['my_consulting'] ?? 0 }}</div>
  </div>
  <div class="card dash-stat s-green">
    <div class="dash-stat-icon">✅</div>
    <div class="dash-stat-label">Đã chốt đơn</div>
    <div class="dash-stat-val" style="color:var(--success)">{{ $stats['my_closed'] ?? 0 }}</div>
  </div>
  <div class="card dash-stat s-purple">
    <div class="dash-stat-icon">🎁</div>
    <div class="dash-stat-label">Hoa hồng</div>
    <div class="dash-stat-val" style="font-size:24px;color:var(--primary)">
      {{ number_format($stats['my_commission'] ?? 0, 0, ',', '.') }}đ
    </div>
  </div>
</div>

@php
  $myTotal   = max($stats['my_orders']    ?? 1, 1);
  $myClosed  = $stats['my_closed']        ?? 0;
  $myConsult = $stats['my_consulting']    ?? 0;
  $myOther   = max($myTotal - $myClosed - $myConsult, 0);
  $rM = 42; $cM = 2*M_PI*$rM;
  $dMC = $cM*($myClosed /$myTotal);
  $dMK = $cM*($myConsult/$myTotal);
  $dMO = $cM*($myOther  /$myTotal);
  $pctM = round($myClosed/$myTotal*100);

  $commTarget = 5000000;
  $commVal    = $stats['my_commission'] ?? 0;
  $commPct    = min(100, $commTarget > 0 ? round($commVal/$commTarget*100) : 0);
  $commColor  = $commPct >= 100 ? '#22c55e' : ($commPct >= 60 ? '#3b82f6' : '#f59e0b');
@endphp

<div class="dash-grid-main col-3">

  {{-- Đơn hàng của tôi --}}
  <div class="card dash-panel">
    <div class="panel-hd">
      <span>📋 Đơn hàng của tôi</span>
      <a href="{{ route('admin.staff.orders.index') }}" style="font-size:14px;color:var(--primary);font-weight:400">Xem tất cả →</a>
    </div>
    <div style="flex:1;overflow-y:auto">
      <table class="table">
        <thead><tr><th>Khách</th><th>Xe</th><th>Trạng thái</th></tr></thead>
        <tbody>
          @forelse($myOrders ?? [] as $order)
          <tr>
            <td style="font-weight:500">{{ $order->customer_name }}</td>
            <td style="color:var(--text-muted)">{{ $order->car->name ?? 'N/A' }}</td>
            <td><span class="badge {{ $order->consultation_badge }}">{{ $order->consultation_label }}</span></td>
          </tr>
          @empty
          <tr><td colspan="3" style="text-align:center;padding:40px;color:var(--text-muted)">Chưa có đơn hàng</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- Donut: hiệu suất cá nhân --}}
  <div class="card dash-panel">
    <div class="panel-hd">🥧 Hiệu suất của tôi</div>
    <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:20px;padding:20px 18px">
      <div class="donut-wrap" style="width:130px;height:130px">
        <svg viewBox="0 0 100 100" width="130" height="130" style="transform:rotate(-90deg)">
          <circle cx="50" cy="50" r="{{ $rM }}" fill="none" stroke="var(--border)" stroke-width="13"/>
          @if($myOther > 0)
          <circle cx="50" cy="50" r="{{ $rM }}" fill="none" stroke="#e2e8f0" stroke-width="13"
            stroke-dasharray="{{ $dMO }} {{ $cM }}" stroke-dashoffset="{{ -$dMC - $dMK }}"/>
          @endif
          @if($myConsult > 0)
          <circle cx="50" cy="50" r="{{ $rM }}" fill="none" stroke="#f59e0b" stroke-width="13"
            stroke-dasharray="{{ $dMK }} {{ $cM }}" stroke-dashoffset="{{ -$dMC }}"/>
          @endif
          @if($myClosed > 0)
          <circle cx="50" cy="50" r="{{ $rM }}" fill="none" stroke="#22c55e" stroke-width="13"
            stroke-dasharray="{{ $dMC }} {{ $cM }}" stroke-dashoffset="0"/>
          @endif
        </svg>
        <div class="donut-center">
          <span class="donut-pct">{{ $pctM }}%</span>
          <span class="donut-lbl">chốt</span>
        </div>
      </div>
      <div style="width:100%">
        <div class="leg-row">
          <span><span class="leg-dot" style="background:#22c55e"></span>Đã chốt</span>
          <strong>{{ $myClosed }}</strong>
        </div>
        <div class="leg-row">
          <span><span class="leg-dot" style="background:#f59e0b"></span>Đang tư vấn</span>
          <strong>{{ $myConsult }}</strong>
        </div>
        <div class="leg-row">
          <span><span class="leg-dot" style="background:#e2e8f0"></span>Chờ xử lý</span>
          <strong>{{ $myOther }}</strong>
        </div>
      </div>
    </div>
  </div>

  {{-- Thao tác nhanh + progress hoa hồng --}}
  <div class="card dash-panel">
    <div class="panel-hd">⚡ Thao tác nhanh</div>
    <div style="flex:1;display:flex;flex-direction:column;padding:16px 18px;gap:10px">
      <a href="{{ route('admin.staff.orders.create') }}" class="btn" style="text-align:center;padding:14px;font-size:15px">+ Tạo đơn hàng mới</a>
      <a href="{{ route('admin.staff.customers') }}"     class="btn" style="text-align:center;padding:14px;font-size:15px">👥 Xem khách hàng</a>
      <a href="{{ route('admin.staff.attendance') }}"    class="btn" style="text-align:center;padding:14px;font-size:15px">📍 Chấm công GPS</a>
      <a href="{{ route('admin.staff.performance') }}"   class="btn" style="text-align:center;padding:14px;font-size:15px">📊 Hiệu suất cá nhân</a>
      <div style="margin-top:auto;padding:14px;background:var(--border);border-radius:10px">
        <div style="font-size:13px;color:var(--text-muted);margin-bottom:8px">🎯 Hoa hồng tháng này</div>
        <div style="background:rgba(255,255,255,.6);border-radius:5px;height:10px;overflow:hidden;margin-bottom:8px">
          <div style="width:{{ $commPct }}%;height:100%;background:{{ $commColor }};border-radius:5px;transition:width .4s ease"></div>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:14px">
          <span style="font-weight:600;color:{{ $commColor }}">{{ number_format($commVal,0,',','.') }}đ</span>
          <span style="color:var(--text-muted)">{{ $commPct }}% mục tiêu</span>
        </div>
      </div>
    </div>
  </div>

</div>

@endif

@endsection