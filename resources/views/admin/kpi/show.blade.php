@extends('layouts.admin')

@section('title', 'KPI — ' . $user->name)
@section('page-title', 'KPI của ' . $user->name)

@section('topbar-actions')
  <a href="{{ route('admin.kpi.index') }}" class="btn btn-sm">← Quay lại</a>
  <a href="{{ route('admin.staff.orders.create', ['assigned_to' => $user->id]) }}" class="btn btn-primary btn-sm">
    ➕ Tạo đơn mới
  </a>
@endsection

@section('content')

<style>
/* ══ STAT CARDS ══ */
.kpi-stats-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr); /* mobile: 2 cột */
  gap: 12px;
  margin-bottom: 20px;
}
@media (min-width: 640px) {
  .kpi-stats-grid {
    grid-template-columns: repeat(4, 1fr); /* desktop: 4 cột */
  }
}
.kpi-stats-grid .stat-card {
  min-width: 0; /* tránh tràn */
}
.kpi-stats-grid .stat-val {
  font-size: 20px !important;
  word-break: break-all;
}

/* ══ FORM ĐẶT KPI ══ */
.kpi-target-form {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  align-items: flex-end;
}
.kpi-target-form > div { flex: 1 1 120px; min-width: 100px; }
.kpi-target-form input[style*="width:200px"] { width: 100% !important; }
.kpi-target-form input[style*="width:100px"] { width: 100% !important; }
.kpi-target-form .btn { flex-shrink: 0; }

/* ══ BẢNG ĐƠN HÀNG — desktop ══ */
.order-table-wrap { display: none; }
@media (min-width: 640px) {
  .order-table-wrap { display: block; }
  .order-mobile-list { display: none !important; }
}

/* ══ BẢNG ĐƠN HÀNG — mobile card list ══ */
.order-mobile-list { display: block; }
.order-mobile-item {
  padding: 14px 16px;
  border-bottom: 1px solid var(--border);
}
.order-mobile-item:last-child { border-bottom: none; }

.order-mi-top {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 8px;
  margin-bottom: 8px;
}
.order-mi-name  { font-size: 14px; font-weight: 700; color: #111827; }
.order-mi-phone { font-size: 12px; color: #9ca3af; margin-top: 2px; }
.order-mi-car   { font-size: 13px; color: #374151; margin-bottom: 6px; }

.order-mi-row {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: wrap;
  margin-bottom: 10px;
}

.order-mi-price {
  font-size: 13px;
  color: #4f46e5;
  font-weight: 600;
}
.order-mi-comm {
  font-size: 12px;
  color: #059669;
  font-weight: 600;
}
.order-mi-date {
  font-size: 12px;
  color: #9ca3af;
  margin-left: auto;
}

.order-mi-actions {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}
.order-mi-actions .btn { font-size: 12px; flex: 1; justify-content: center; text-align: center; }

/* ══ NHÂN VIÊN CARD ══ */
.kpi-staff-card {
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  gap: 14px;
  flex-wrap: wrap;
}
.kpi-staff-card .badge { margin-left: auto; }
</style>

{{-- Thông tin nhân viên --}}
<div class="card card-pad kpi-staff-card">
  <div style="width:44px;height:44px;font-size:16px;border-radius:50%;background:var(--accent);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0">
    {{ strtoupper(substr($user->name, 0, 2)) }}
  </div>
  <div style="min-width:0">
    <div style="font-size:15px;font-weight:600">{{ $user->name }}</div>
    <div style="font-size:12px;color:var(--text-3);word-break:break-all">{{ $user->email }}</div>
  </div>
  <span class="badge badge-gray">{{ ucfirst($user->role ?? 'staff') }}</span>
</div>

{{-- Form đặt KPI target --}}
@if(auth()->user()->isManager() || auth()->user()->isAdmin())
@php
  $currentKpi = \App\Models\Kpi::where('user_id', $user->id)
    ->where('month', now()->month)->where('year', now()->year)->first();
@endphp
<div class="card card-pad" style="margin-bottom:16px">
  <div style="font-size:14px;font-weight:700;margin-bottom:14px">🎯 Đặt KPI tháng</div>
  <form method="POST" action="{{ route('admin.kpi.setTarget', $user) }}" class="kpi-target-form">
    @csrf
    <div>
      <label class="form-label">Tháng</label>
      <select name="month" class="form-input">
        @for($m = 1; $m <= 12; $m++)
          <option value="{{ $m }}" @selected($m == now()->month)>Tháng {{ $m }}</option>
        @endfor
      </select>
    </div>
    <div>
      <label class="form-label">Năm</label>
      <select name="year" class="form-input">
        @for($y = 2024; $y <= now()->year + 1; $y++)
          <option value="{{ $y }}" @selected($y == now()->year)>{{ $y }}</option>
        @endfor
      </select>
    </div>
    <div style="flex:2 1 160px">
      <label class="form-label">Doanh thu mục tiêu (đ)</label>
      <input type="number" name="target_revenue" class="form-input"
             value="{{ $currentKpi?->target_revenue ?? '' }}"
             placeholder="VD: 5000000000" min="1" style="width:100%" required>
    </div>
    <div>
      <label class="form-label">Số đơn mục tiêu</label>
      <input type="number" name="target_orders" class="form-input"
             value="{{ $currentKpi?->target_orders ?? '' }}"
             placeholder="VD: 3" min="0" style="width:100%">
    </div>
    <div style="flex:0 0 auto;align-self:flex-end">
      <button class="btn btn-primary" type="submit">Lưu KPI</button>
    </div>
    @if($currentKpi)
      <div style="flex:1 1 100%;font-size:12px;color:var(--text-3)">
        Hiện tại tháng {{ now()->month }}/{{ now()->year }}:
        {{ number_format($currentKpi->target_revenue, 0, ',', '.') }}đ
      </div>
    @endif
  </form>
  @if(session('success'))<div class="alert alert-success flash" style="margin-top:10px">{{ session('success') }}</div>@endif
</div>
@endif

{{-- Stat cards --}}
<div class="kpi-stats-grid">
  <div class="stat-card">
    <div class="stat-label">Tổng đơn</div>
    <div class="stat-val">{{ $stats['total'] }}</div>
    <div class="stat-sub">đơn được ghi nhận</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Đã chốt</div>
    <div class="stat-val" style="color:var(--success)">{{ $stats['closed'] }}</div>
    <div class="stat-sub">tỉ lệ {{ $stats['conversion_rate'] }}%</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Doanh số</div>
    <div class="stat-val" style="font-size:16px !important">{{ number_format($stats['revenue'], 0, ',', '.') }}đ</div>
    <div class="stat-sub">tổng giá trị chốt</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Hoa hồng</div>
    <div class="stat-val" style="font-size:16px !important;color:var(--success)">{{ number_format($stats['commission'], 0, ',', '.') }}đ</div>
    <div class="stat-sub">tổng hoa hồng nhận được</div>
  </div>
</div>

{{-- Biểu đồ --}}
@if($monthly->count())
@php
  $revenueByMonth    = array_fill(1, 12, 0);
  $commissionByMonth = array_fill(1, 12, 0);
  foreach ($monthly as $row) {
    $revenueByMonth[$row->month]    = (float) $row->revenue;
    $commissionByMonth[$row->month] = (float) $row->commission;
  }
@endphp
<div class="card card-pad" style="margin-bottom:20px;overflow:hidden">
  <div style="font-weight:600;font-size:14px;margin-bottom:16px">📈 Doanh số & Hoa hồng theo tháng — {{ now()->year }}</div>
  <div style="position:relative;width:100%;overflow-x:auto">
    <canvas id="kpiChart" style="max-height:280px;min-width:320px"></canvas>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('kpiChart').getContext('2d'), {
  type: 'bar',
  data: {
    labels: ['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'],
    datasets: [
      {
        label: 'Doanh số',
        data: @json(array_values($revenueByMonth)),
        backgroundColor: 'rgba(59,130,246,0.75)',
        borderRadius: 6,
        yAxisID: 'y',
      },
      {
        label: 'Hoa hồng',
        data: @json(array_values($commissionByMonth)),
        backgroundColor: 'rgba(34,197,94,0.85)',
        borderRadius: 6,
        yAxisID: 'y1',
      }
    ]
  },
  options: {
    responsive: true,
    interaction: { mode: 'index', intersect: false },
    plugins: {
      legend: { position: 'top' },
      tooltip: {
        callbacks: {
          label: c => c.dataset.label + ': ' +
            new Intl.NumberFormat('vi-VN').format(c.parsed.y) + 'đ'
        }
      }
    },
    scales: {
      y:  { type:'linear', position:'left',  ticks:{ callback: v => new Intl.NumberFormat('vi-VN',{notation:'compact'}).format(v)+'đ' } },
      y1: { type:'linear', position:'right', grid:{ drawOnChartArea:false }, ticks:{ callback: v => new Intl.NumberFormat('vi-VN',{notation:'compact'}).format(v)+'đ' } }
    }
  }
});
</script>
@endif

{{-- Danh sách đơn hàng --}}
@if($orders->count())
<div class="card" style="margin-bottom:20px">
  <div style="padding:14px 18px;border-bottom:1px solid var(--border);font-weight:600;font-size:14px">
    📋 Danh sách đơn hàng
  </div>

  {{-- DESKTOP TABLE --}}
  <div class="order-table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Khách hàng</th>
          <th>Xe</th>
          <th>Trạng thái</th>
          <th>Ngày tạo</th>
          <th style="text-align:right">Hành động</th>
        </tr>
      </thead>
      <tbody>
        @foreach($orders as $order)
        @php
          $statusMap = [
            'chua_tu_van' => ['label' => 'Chưa tư vấn', 'color' => '#92400e', 'bg' => '#fef3c7'],
            'da_tu_van'   => ['label' => 'Đã tư vấn',   'color' => '#1e40af', 'bg' => '#dbeafe'],
            'da_chot_don' => ['label' => 'Đã chốt',     'color' => '#166534', 'bg' => '#dcfce7'],
          ];
          $s = $statusMap[$order->consultation_status] ?? ['label' => $order->consultation_status, 'color' => '#555', 'bg' => '#f3f4f6'];
        @endphp
        <tr>
          <td style="color:var(--text-muted)">{{ $order->id }}</td>
          <td>
            <div style="font-weight:600;font-size:13px">{{ $order->customer_name }}</div>
            <div style="font-size:12px;color:var(--text-muted)">{{ $order->customer_phone }}</div>
          </td>
          <td style="font-size:13px">{{ $order->car?->name ?? '—' }}</td>
          <td>
            <span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;color:{{ $s['color'] }};background:{{ $s['bg'] }}">
              {{ $s['label'] }}
            </span>
            @if($order->sale_price)
              <div style="font-size:11px;color:var(--text-3);margin-top:3px">
                {{ number_format($order->sale_price, 0, ',', '.') }}đ
                @if($order->commission_amount)
                  &nbsp;·&nbsp;🏆 {{ number_format($order->commission_amount, 0, ',', '.') }}đ
                @endif
              </div>
            @endif
          </td>
          <td style="font-size:13px;color:var(--text-muted)">{{ $order->created_at->format('d/m/Y') }}</td>
          <td style="text-align:right">
            <div style="display:flex;gap:6px;justify-content:flex-end;align-items:center;flex-wrap:wrap">
              @if($order->consultation_status === 'chua_tu_van')
                <form id="consulted-form-dt-{{ $order->id }}" action="{{ route('admin.kpi.markConsulted', $order) }}" method="POST" style="display:none">@csrf</form>
                <button type="button" class="btn btn-sm"
                  style="background:#dbeafe;color:#1e40af;border-color:#bfdbfe;font-size:12px"
                  onclick="openKpiConfirm('consulted-form-dt-{{ $order->id }}', 'Xác nhận tư vấn', 'Xác nhận đã tư vấn xong khách <strong>{{ addslashes($order->customer_name) }}</strong>?', 'info')">
                  💬 Đã tư vấn
                </button>
                <form id="delete-form-dt-{{ $order->id }}" action="{{ route('admin.kpi.destroyOrder', [$user, $order]) }}" method="POST" style="display:none">@csrf @method('DELETE')</form>
                <button type="button" class="btn btn-sm btn-danger" style="font-size:12px"
                  onclick="openKpiConfirm('delete-form-dt-{{ $order->id }}', 'Xóa đơn hàng', 'Xóa đơn <strong>#{{ $order->id }}</strong> của <strong>{{ addslashes($order->customer_name) }}</strong>? Không thể hoàn tác!', 'danger')">
                  Xóa
                </button>
              @elseif($order->consultation_status === 'da_tu_van')
                <button type="button" class="btn btn-sm"
                  style="background:#dcfce7;color:#166534;border-color:#bbf7d0;font-size:12px"
                  onclick="openCloseModal({{ $order->id }}, '{{ addslashes($order->car?->name ?? '') }}', {{ $order->car->price_per_day ?? 0 }})">
                  ✅ Chốt đơn
                </button>
              @else
                <span style="font-size:12px;color:var(--text-muted)">Hoàn tất</span>
              @endif
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{-- MOBILE CARD LIST --}}
  <div class="order-mobile-list">
    @foreach($orders as $order)
    @php
      $statusMap = [
        'chua_tu_van' => ['label' => 'Chưa tư vấn', 'color' => '#92400e', 'bg' => '#fef3c7'],
        'da_tu_van'   => ['label' => 'Đã tư vấn',   'color' => '#1e40af', 'bg' => '#dbeafe'],
        'da_chot_don' => ['label' => 'Đã chốt',     'color' => '#166534', 'bg' => '#dcfce7'],
      ];
      $s = $statusMap[$order->consultation_status] ?? ['label' => $order->consultation_status, 'color' => '#555', 'bg' => '#f3f4f6'];
    @endphp
    <div class="order-mobile-item">
      {{-- Top: tên + badge --}}
      <div class="order-mi-top">
        <div>
          <div class="order-mi-name">{{ $order->customer_name }}</div>
          <div class="order-mi-phone">{{ $order->customer_phone }}</div>
        </div>
        <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;color:{{ $s['color'] }};background:{{ $s['bg'] }};flex-shrink:0">
          {{ $s['label'] }}
        </span>
      </div>

      {{-- Xe --}}
      <div class="order-mi-car">🚗 {{ $order->car?->name ?? '—' }}</div>

      {{-- Giá + hoa hồng + ngày --}}
      <div class="order-mi-row">
        @if($order->sale_price)
          <span class="order-mi-price">{{ number_format($order->sale_price, 0, ',', '.') }}đ</span>
          @if($order->commission_amount)
            <span class="order-mi-comm">🏆 {{ number_format($order->commission_amount, 0, ',', '.') }}đ</span>
          @endif
        @endif
        <span class="order-mi-date">{{ $order->created_at->format('d/m/Y') }}</span>
      </div>

      {{-- Actions --}}
      <div class="order-mi-actions">
        @if($order->consultation_status === 'chua_tu_van')
          <form id="consulted-form-{{ $order->id }}" action="{{ route('admin.kpi.markConsulted', $order) }}" method="POST" style="display:none">@csrf</form>
          <button type="button" class="btn btn-sm"
            style="background:#dbeafe;color:#1e40af;border-color:#bfdbfe;font-size:12px"
            onclick="openKpiConfirm('consulted-form-{{ $order->id }}', 'Xác nhận tư vấn', 'Xác nhận đã tư vấn xong khách <strong>{{ addslashes($order->customer_name) }}</strong>?', 'info')">
            💬 Đã tư vấn
          </button>
          <form id="delete-form-{{ $order->id }}" action="{{ route('admin.kpi.destroyOrder', [$user, $order]) }}" method="POST" style="display:none">@csrf @method('DELETE')</form>
          <button type="button" class="btn btn-sm btn-danger" style="font-size:12px"
            onclick="openKpiConfirm('delete-form-{{ $order->id }}', 'Xóa đơn hàng', 'Xóa đơn <strong>#{{ $order->id }}</strong> của <strong>{{ addslashes($order->customer_name) }}</strong>? Không thể hoàn tác!', 'danger')">
            Xóa
          </button>
        @elseif($order->consultation_status === 'da_tu_van')
          <button type="button" class="btn btn-sm"
            style="background:#dcfce7;color:#166534;border-color:#bbf7d0;font-size:12px"
            onclick="openCloseModal({{ $order->id }}, '{{ addslashes($order->car?->name ?? '') }}', {{ $order->car->price_per_day ?? 0 }})">
            ✅ Chốt đơn
          </button>
        @else
          <span style="font-size:12px;color:var(--text-muted)">Hoàn tất</span>
        @endif
      </div>
    </div>
    @endforeach
  </div>

  <div style="padding:12px 18px">
    {{ $orders->links() }}
  </div>
</div>
@endif

{{-- ── Modal chốt đơn ── --}}
<div id="close-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.45);backdrop-filter:blur(3px);align-items:center;justify-content:center;padding:16px">
  <div style="background:#fff;border-radius:14px;padding:24px;width:100%;max-width:420px;box-shadow:0 20px 60px rgba(0,0,0,.18);animation:modalIn .18s ease">
    <div style="font-size:22px;margin-bottom:8px">✅</div>
    <div style="font-weight:700;font-size:16px;margin-bottom:4px">Chốt đơn hàng</div>
    <div id="modal-car-name" style="font-size:13px;color:var(--text-3);margin-bottom:18px"></div>
    <form id="close-order-form" method="POST" action="">
      @csrf
      <div style="display:flex;flex-direction:column;gap:12px">
        <div>
          <label style="font-size:12px;font-weight:600;color:var(--text-2);display:block;margin-bottom:5px">
            Giá bán cuối (đ) <span style="color:var(--danger)">*</span>
          </label>
          <input type="number" name="sale_price" id="modal-sale-price" class="form-control"
            placeholder="5500000000" required oninput="calcModalCommission()" style="width:100%">
        </div>
        <div style="padding:10px 12px;background:#f9fafb;border-radius:8px;font-size:13px">
          Hoa hồng dự tính:
          <strong id="modal-commission-val" style="color:var(--success)">—</strong>
          <span id="modal-commission-rate" style="color:var(--text-3);font-size:12px"></span>
          <div style="margin-top:4px;font-size:11px;color:var(--text-3)">
            0.05% nếu &lt; 10 tỷ &nbsp;·&nbsp; 0.1% nếu ≥ 10 tỷ
          </div>
        </div>
        <div>
          <label style="font-size:12px;font-weight:600;color:var(--text-2);display:block;margin-bottom:5px">Ghi chú</label>
          <textarea name="manager_note" class="form-control" rows="2" placeholder="Ghi chú thêm..." style="width:100%"></textarea>
        </div>
        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:4px;flex-wrap:wrap">
          <button type="button" onclick="closeCloseModal()" class="btn">Hủy</button>
          <button type="submit" class="btn btn-primary">✅ Xác nhận chốt đơn</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- ── Modal xác nhận chung ── --}}
<div id="kpi-confirm-modal" style="display:none;position:fixed;inset:0;z-index:10000;background:rgba(0,0,0,.45);backdrop-filter:blur(3px);align-items:center;justify-content:center;padding:16px">
  <div style="background:#fff;border-radius:16px;padding:28px 24px 22px;width:100%;max-width:380px;box-shadow:0 20px 60px rgba(0,0,0,.18);animation:modalIn .18s ease">
    <div id="kpi-confirm-icon" style="width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;font-size:22px"></div>
    <div id="kpi-confirm-title" style="font-size:16px;font-weight:700;color:#111827;margin-bottom:6px"></div>
    <div id="kpi-confirm-message" style="font-size:13.5px;color:#6b7280;line-height:1.5;margin-bottom:22px"></div>
    <div style="display:flex;gap:8px;justify-content:flex-end">
      <button onclick="closeKpiConfirm()" style="padding:9px 18px;background:#f3f4f6;color:#374151;border:1px solid #e5e7eb;border-radius:8px;font-size:13.5px;font-weight:600;font-family:inherit;cursor:pointer">Hủy bỏ</button>
      <button id="kpi-confirm-ok" style="padding:9px 18px;border:none;border-radius:8px;font-size:13.5px;font-weight:700;color:#fff;cursor:pointer;font-family:inherit">Xác nhận</button>
    </div>
  </div>
</div>

<style>
@keyframes modalIn {
  from { opacity:0; transform:scale(.95) translateY(8px); }
  to   { opacity:1; transform:scale(1)  translateY(0); }
}
</style>

<script>
/* ── Chốt đơn modal ── */
function openCloseModal(orderId, carName, defaultPrice) {
  document.getElementById('close-order-form').action =
    '{{ url("admin/kpi/orders") }}/' + orderId + '/close';
  document.getElementById('modal-car-name').textContent = carName || '';
  const priceInput = document.getElementById('modal-sale-price');
  priceInput.value = defaultPrice > 0 ? defaultPrice : '';
  document.getElementById('close-modal').style.display = 'flex';
  calcModalCommission();
}
function closeCloseModal() {
  document.getElementById('close-modal').style.display = 'none';
}
document.getElementById('close-modal').addEventListener('click', function(e) {
  if (e.target === this) closeCloseModal();
});
function calcModalCommission() {
  const price = parseFloat(document.getElementById('modal-sale-price').value) || 0;
  const rate  = price >= 10000000000 ? 10 : 5;
  const comm  = Math.round(price * rate / 100);
  document.getElementById('modal-commission-val').textContent =
    price > 0 ? new Intl.NumberFormat('vi-VN').format(comm) + 'đ' : '—';
  document.getElementById('modal-commission-rate').textContent =
    price > 0 ? ' (' + rate + '%)' : '';
}

/* ── Confirm modal ── */
const THEMES = {
  info:    { bg:'#eff6ff', icon:'💬', btn:'#2563eb' },
  danger:  { bg:'#fef2f2', icon:'🗑️',  btn:'#dc2626' },
  success: { bg:'#f0fdf4', icon:'✅', btn:'#16a34a' },
};
let _kpiFormId = null;

function openKpiConfirm(formId, title, message, type) {
  _kpiFormId = formId;
  const t = THEMES[type] || THEMES.info;
  const icon = document.getElementById('kpi-confirm-icon');
  icon.style.background = t.bg;
  icon.textContent = t.icon;
  document.getElementById('kpi-confirm-title').textContent = title;
  document.getElementById('kpi-confirm-message').innerHTML = message;
  document.getElementById('kpi-confirm-ok').style.background = t.btn;
  document.getElementById('kpi-confirm-modal').style.display = 'flex';
  document.body.style.overflow = 'hidden';
}
function closeKpiConfirm() {
  document.getElementById('kpi-confirm-modal').style.display = 'none';
  document.body.style.overflow = '';
  _kpiFormId = null;
}
document.getElementById('kpi-confirm-ok').addEventListener('click', function() {
  const id = _kpiFormId;
  closeKpiConfirm();
  if (id) { const f = document.getElementById(id); if (f) f.submit(); }
});
document.getElementById('kpi-confirm-modal').addEventListener('click', function(e) {
  if (e.target === this) closeKpiConfirm();
});
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeKpiConfirm(); });
</script>

@endsection