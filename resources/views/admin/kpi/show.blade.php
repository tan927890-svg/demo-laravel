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

{{-- Thông tin nhân viên --}}
<div class="card card-pad" style="margin-bottom:16px;display:flex;align-items:center;gap:14px">
  <div style="width:44px;height:44px;font-size:16px;border-radius:50%;background:var(--accent);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0">
    {{ strtoupper(substr($user->name, 0, 2)) }}
  </div>
  <div>
    <div style="font-size:15px;font-weight:600">{{ $user->name }}</div>
    <div style="font-size:12px;color:var(--text-3)">{{ $user->email }}</div>
  </div>
  <span class="badge badge-gray" style="margin-left:auto">{{ ucfirst($user->role ?? 'staff') }}</span>
</div>

{{-- Stat cards --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px">
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
    <div class="stat-val" style="font-size:20px">{{ number_format($stats['revenue'], 0, ',', '.') }}đ</div>
    <div class="stat-sub">tổng giá trị chốt</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Hoa hồng</div>
    <div class="stat-val" style="font-size:20px;color:var(--success)">{{ number_format($stats['commission'], 0, ',', '.') }}đ</div>
    <div class="stat-sub">tổng hoa hồng nhận được</div>
  </div>
</div>

{{-- Biểu đồ — chỉ hiện khi có dữ liệu --}}
@if($monthly->count())
@php
  $revenueByMonth    = array_fill(1, 12, 0);
  $commissionByMonth = array_fill(1, 12, 0);
  foreach ($monthly as $row) {
    $revenueByMonth[$row->month]    = (float) $row->revenue;
    $commissionByMonth[$row->month] = (float) $row->commission;
  }
@endphp
<div class="card card-pad" style="margin-bottom:20px">
  <div style="font-weight:600;font-size:14px;margin-bottom:16px">📈 Doanh số & Hoa hồng theo tháng — {{ now()->year }}</div>
  <canvas id="kpiChart" style="max-height:320px"></canvas>
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

{{-- Danh sách đơn hàng — chỉ hiện khi có đơn --}}
@if($orders->count())
<div class="card" style="margin-bottom:20px">
  <div style="padding:14px 18px;border-bottom:1px solid var(--border);font-weight:600;font-size:14px">
    📋 Danh sách đơn hàng
  </div>
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
      <tr>
        <td style="color:var(--text-muted)">{{ $order->id }}</td>
        <td>
          <div style="font-weight:600;font-size:13px">{{ $order->customer_name }}</div>
          <div style="font-size:12px;color:var(--text-muted)">{{ $order->customer_phone }}</div>
        </td>
        <td style="font-size:13px">{{ $order->car?->name ?? '—' }}</td>
        <td>
          @php
            $statusMap = [
              'chua_tu_van' => ['label' => 'Chưa tư vấn', 'color' => '#92400e', 'bg' => '#fef3c7'],
              'da_tu_van'   => ['label' => 'Đã tư vấn',   'color' => '#1e40af', 'bg' => '#dbeafe'],
              'da_chot_don' => ['label' => 'Đã chốt',     'color' => '#166534', 'bg' => '#dcfce7'],
            ];
            $s = $statusMap[$order->consultation_status] ?? ['label' => $order->consultation_status, 'color' => '#555', 'bg' => '#f3f4f6'];
          @endphp
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

            {{-- Chưa tư vấn: nút Đã tư vấn + Xóa --}}
            @if($order->consultation_status === 'chua_tu_van')
              <form action="{{ route('admin.kpi.markConsulted', $order) }}" method="POST" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-sm"
                  style="background:#dbeafe;color:#1e40af;border-color:#bfdbfe;font-size:12px"
                  onclick="return confirm('Xác nhận đã tư vấn cho khách hàng này?')">
                  💬 Đã tư vấn
                </button>
              </form>
              <form action="{{ route('admin.kpi.destroyOrder', [$user, $order]) }}" method="POST"
                onsubmit="return confirm('Xóa đơn này?')" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" style="font-size:12px">Xóa</button>
              </form>

            {{-- Đã tư vấn: nút Chốt đơn --}}
            @elseif($order->consultation_status === 'da_tu_van')
              <button type="button" class="btn btn-sm"
                style="background:#dcfce7;color:#166534;border-color:#bbf7d0;font-size:12px"
                onclick="openCloseModal({{ $order->id }}, '{{ addslashes($order->car?->name ?? '') }}', {{ $order->car->price_per_day ?? 0 }})">
                ✅ Chốt đơn
              </button>

            {{-- Đã chốt --}}
            @else
              <span style="font-size:12px;color:var(--text-muted)">Hoàn tất</span>
            @endif

          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div style="padding:12px 18px">
    {{ $orders->links() }}
  </div>
</div>
@endif

{{-- ── Modal chốt đơn ── --}}
<div id="close-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.45);backdrop-filter:blur(3px);align-items:center;justify-content:center">
  <div style="background:#fff;border-radius:14px;padding:28px;width:400px;box-shadow:0 20px 60px rgba(0,0,0,.18);animation:modalIn .18s ease">
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
            placeholder="5500000000" required oninput="calcModalCommission()">
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
          <textarea name="manager_note" class="form-control" rows="2" placeholder="Ghi chú thêm..."></textarea>
        </div>

        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:4px">
          <button type="button" onclick="closeCloseModal()" class="btn">Hủy</button>
          <button type="submit" class="btn btn-primary">✅ Xác nhận chốt đơn</button>
        </div>
      </div>
    </form>
  </div>
</div>

<style>
@keyframes modalIn {
  from { opacity:0; transform:scale(.95) translateY(8px); }
  to   { opacity:1; transform:scale(1)  translateY(0); }
}
</style>

<script>
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
  const rate  = price >= 10000000000 ? 0.1 : 0.05;
  const comm  = Math.round(price * rate / 100);
  document.getElementById('modal-commission-val').textContent =
    price > 0 ? new Intl.NumberFormat('vi-VN').format(comm) + 'đ' : '—';
  document.getElementById('modal-commission-rate').textContent =
    price > 0 ? ' (' + rate + '%)' : '';
}
</script>

@endsection