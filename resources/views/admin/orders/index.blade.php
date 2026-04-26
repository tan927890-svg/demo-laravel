@extends('layouts.admin')
@section('page-title', 'Quản lý đơn hàng')

@section('topbar-actions')
  <a href="{{ route('admin.orders.create') }}" class="btn" style="background:var(--primary);color:#fff;font-size:14px;padding:8px 16px">+ Tạo đơn mới</a>
  <a href="{{ route('admin.dashboard') }}" class="btn btn-sm" style="font-size:14px;padding:8px 14px">← Dashboard</a>
@endsection

@section('content')

@if(session('success'))
  <div class="alert alert-success" style="margin-bottom:16px">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-error" style="margin-bottom:16px">{{ session('error') }}</div>
@endif

{{-- Filter --}}
<div class="card card-pad" style="margin-bottom:14px">
  <form method="GET" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap">
    <div>
      <label style="font-size:13px;color:var(--text-muted);display:block;margin-bottom:4px">Trạng thái tư vấn</label>
      <select name="consultation_status" class="form-input" style="width:180px;font-size:14px">
        <option value="">Tất cả</option>
        <option value="chua_tu_van" @selected(request('consultation_status')==='chua_tu_van')>Chưa tư vấn</option>
        <option value="da_tu_van"   @selected(request('consultation_status')==='da_tu_van')>Đã tư vấn</option>
        <option value="da_chot_don" @selected(request('consultation_status')==='da_chot_don')>Đã chốt đơn</option>
      </select>
    </div>
    <div>
      <label style="font-size:13px;color:var(--text-muted);display:block;margin-bottom:4px">Nhân viên</label>
      <select name="staff_id" class="form-input" style="width:160px;font-size:14px">
        <option value="">Tất cả</option>
        @foreach($staffList ?? [] as $s)
          <option value="{{ $s->id }}" @selected(request('staff_id')==$s->id)>{{ $s->name }}</option>
        @endforeach
      </select>
    </div>
    <button type="submit" class="btn" style="font-size:14px;padding:8px 18px">Lọc</button>
    <a href="{{ route('admin.orders.index') }}" class="btn" style="background:var(--surface2);font-size:14px;padding:8px 18px">Xóa lọc</a>
  </form>
</div>

{{-- Thống kê nhanh --}}
<div style="display:flex;gap:10px;margin-bottom:14px">
  <a href="{{ route('admin.orders.index', ['consultation_status'=>'chua_tu_van']) }}"
     class="card card-pad" style="flex:1;text-decoration:none;text-align:center">
    <div style="font-size:13px;color:var(--text-muted)">Chưa tư vấn</div>
    <div style="font-size:28px;font-weight:700;color:var(--warning);margin-top:2px">
      {{ $orders->where('consultation_status','chua_tu_van')->count() }}
    </div>
  </a>
  <a href="{{ route('admin.orders.index', ['consultation_status'=>'da_tu_van']) }}"
     class="card card-pad" style="flex:1;text-decoration:none;text-align:center">
    <div style="font-size:13px;color:var(--text-muted)">Chờ chốt</div>
    <div style="font-size:28px;font-weight:700;color:var(--info,#3b82f6);margin-top:2px">
      {{ $orders->where('consultation_status','da_tu_van')->count() }}
    </div>
  </a>
  <a href="{{ route('admin.orders.index', ['consultation_status'=>'da_chot_don']) }}"
     class="card card-pad" style="flex:1;text-decoration:none;text-align:center">
    <div style="font-size:13px;color:var(--text-muted)">Đã chốt</div>
    <div style="font-size:28px;font-weight:700;color:var(--success);margin-top:2px">
      {{ $orders->where('consultation_status','da_chot_don')->count() }}
    </div>
  </a>
</div>

<div class="card">
  <div style="padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between">
    <span style="font-weight:600;font-size:15px">
      Danh sách đơn hàng
      <span style="font-size:13px;font-weight:400;color:var(--text-muted);margin-left:8px">
        {{ $orders->total() }} đơn
      </span>
    </span>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th style="font-size:13px">#</th>
        <th style="font-size:13px">Khách hàng</th>
        <th style="font-size:13px">Xe</th>
        <th style="font-size:13px">Nhân viên</th>
        <th style="font-size:13px">Tư vấn</th>
        <th style="font-size:13px">Giá chốt</th>
        <th style="font-size:13px">Hoa hồng</th>
        <th style="font-size:13px">Ngày</th>
        <th style="text-align:right;font-size:13px">Hành động</th>
      </tr>
    </thead>
    <tbody>
      @forelse($orders as $order)
      <tr>
        <td style="color:var(--text-muted);font-size:14px">#{{ $order->id }}</td>
        <td>
          <div style="font-weight:500;font-size:14px">{{ $order->customer_name }}</div>
          <div style="font-size:12px;color:var(--text-muted)">{{ $order->customer_phone }}</div>
        </td>
        <td style="font-size:14px">{{ $order->car->name ?? 'N/A' }}</td>
        <td style="font-size:14px">{{ $order->assignedStaff->name ?? '—' }}</td>
        <td>
          @if($order->consultation_status === 'chua_tu_van')
            <span class="badge badge-warning">Chưa tư vấn</span>
          @elseif($order->consultation_status === 'da_tu_van')
            <span class="badge badge-info">Đã tư vấn</span>
          @else
            <span class="badge badge-success">Đã chốt</span>
          @endif
        </td>
        <td style="font-size:14px;color:var(--primary);font-weight:600">
          {{ $order->sale_price ? number_format($order->sale_price,0,',','.') . 'đ' : '—' }}
        </td>
        <td style="font-size:14px;color:var(--success)">
          {{ $order->commission_amount ? number_format($order->commission_amount,0,',','.') . 'đ' : '—' }}
        </td>
        <td style="font-size:13px;color:var(--text-muted)">{{ $order->created_at->format('d/m/Y') }}</td>
        <td style="text-align:right">
          <div style="display:inline-flex;gap:6px;align-items:center">
            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm" style="font-size:13px">Xem</a>

            @if($order->consultation_status === 'da_tu_van')
              <button type="button" class="btn btn-sm"
                style="background:var(--success);color:#fff;font-size:13px"
                onclick="openCloseModal(
                  {{ $order->id }},
                  '{{ addslashes($order->car->name ?? '') }}',
                  {{ $order->car->price_per_day ?? 0 }}
                )">
                Chốt đơn
              </button>
            @endif

            @if(auth()->user()->isAdmin())
            <form method="POST"
                  action="{{ route('admin.orders.destroy', $order) }}"
                  style="display:inline"
                  onsubmit="return confirm('Xóa đơn #{{ $order->id }} — {{ $order->customer_name }}?\nHành động này không thể hoàn tác!')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger" style="font-size:13px">Xóa</button>
            </form>
            @endif
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="9" style="text-align:center;padding:40px;color:var(--text-muted);font-size:14px">
          Không có đơn hàng nào.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>

  @if($orders->hasPages())
  <div style="padding:14px 18px;border-top:1px solid var(--border)">
    {{ $orders->links() }}
  </div>
  @endif
</div>

{{-- Modal chốt đơn --}}
<div id="close-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.45);backdrop-filter:blur(3px);align-items:center;justify-content:center">
  <div style="background:#fff;border-radius:14px;padding:28px;width:420px;animation:modalIn .18s ease">
    <div style="font-size:22px;margin-bottom:8px">✅</div>
    <div style="font-weight:700;font-size:17px;margin-bottom:4px">Chốt đơn hàng</div>
    <div id="modal-car-name" style="font-size:14px;color:var(--text-muted);margin-bottom:18px"></div>

    <form id="close-order-form" method="POST" action="">
      @csrf
      <div style="display:flex;flex-direction:column;gap:12px">

        <div>
          <label style="font-size:13px;font-weight:600;color:var(--text-2);display:block;margin-bottom:5px">
            Giá bán cuối (đ) <span style="color:var(--danger)">*</span>
          </label>
          <input type="number" name="sale_price" id="modal-sale-price" class="form-control"
            style="font-size:14px"
            placeholder="5500000000" required oninput="calcModalCommission()">
        </div>

        <div style="padding:10px 12px;background:#f9fafb;border-radius:8px;font-size:14px">
          Hoa hồng dự tính:
          <strong id="modal-commission-val" style="color:var(--success)">—</strong>
          <span id="modal-commission-rate" style="color:var(--text-muted);font-size:12px"></span>
          <div style="margin-top:4px;font-size:12px;color:var(--text-muted)">
            0.05% nếu &lt; 10 tỷ &nbsp;·&nbsp; 0.1% nếu ≥ 10 tỷ
          </div>
        </div>

        <div>
          <label style="font-size:13px;font-weight:600;color:var(--text-2);display:block;margin-bottom:5px">Ghi chú</label>
          <textarea name="manager_note" class="form-control" rows="2" placeholder="Ghi chú thêm..." style="font-size:14px"></textarea>
        </div>

        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:4px">
          <button type="button" onclick="closeCloseModal()" class="btn" style="font-size:14px">Hủy</button>
          <button type="submit" class="btn btn-primary" style="font-size:14px">✅ Xác nhận chốt đơn</button>
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
  const base = '{{ route("admin.orders.close", ["order" => "__ID__"]) }}'.replace('__ID__', orderId);
  document.getElementById('close-order-form').action = base;
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