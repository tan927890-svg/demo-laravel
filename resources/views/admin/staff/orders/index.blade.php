@extends('layouts.admin')
@section('page-title', 'Đơn hàng của tôi')

@section('topbar-actions')
  <a href="{{ route('admin.staff.orders.create') }}" class="btn btn-sm btn-primary">+ Tạo đơn mới</a>
@endsection

@section('content')

{{-- Stats --}}
<div style="display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:20px">
  <div class="stat-card" style="text-align:center">
    <div class="stat-label">Tổng đơn</div>
    <div class="stat-val">{{ $stats['total'] }}</div>
  </div>
  <div class="stat-card" style="text-align:center">
    <div class="stat-label">Chưa tư vấn</div>
    <div class="stat-val" style="color:var(--warning)">{{ $stats['chua'] }}</div>
  </div>
  <div class="stat-card" style="text-align:center">
    <div class="stat-label">Đã tư vấn</div>
    <div class="stat-val" style="color:var(--info)">{{ $stats['da_tu_van'] }}</div>
  </div>
  <div class="stat-card" style="text-align:center">
    <div class="stat-label">Đã chốt</div>
    <div class="stat-val" style="color:var(--success)">{{ $stats['da_chot'] }}</div>
  </div>
  <div class="stat-card" style="text-align:center">
    <div class="stat-label">Hoa hồng</div>
    <div class="stat-val" style="font-size:18px;letter-spacing:-0.5px">
      {{ number_format($stats['commission'], 0, ',', '.') }}đ
    </div>
  </div>
</div>

{{-- Filter --}}
<div class="card card-pad" style="margin-bottom:14px">
  <form method="GET" style="display:flex;gap:10px;align-items:center">
    <select name="status" class="form-control" style="width:200px">
      <option value="">Tất cả trạng thái</option>
      <option value="chua_tu_van" @selected(request('status')==='chua_tu_van')>Chưa tư vấn</option>
      <option value="da_tu_van"   @selected(request('status')==='da_tu_van')>Đã tư vấn</option>
      <option value="da_chot_don" @selected(request('status')==='da_chot_don')>Đã chốt đơn</option>
    </select>
    <button type="submit" class="btn">Lọc</button>
    <a href="{{ route('admin.staff.orders.index') }}" class="btn">Xóa lọc</a>
  </form>
</div>

<div class="card">
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Khách hàng</th>
        <th>Xe quan tâm</th>
        <th>Trạng thái</th>
        <th>Hoa hồng</th>
        <th>Ngày tạo</th>
        <th style="text-align:right">Thao tác</th>
      </tr>
    </thead>
    <tbody>
      @forelse($orders as $order)
      <tr>
        <td style="color:var(--text-2);font-size:13px">#{{ $order->id }}</td>
        <td>
          <div style="font-weight:700">{{ $order->customer_name }}</div>
          <div style="font-size:12px;color:var(--text-2)">{{ $order->customer_phone }}</div>
        </td>
        <td>
          <div style="font-size:13px;font-weight:600">{{ $order->car->name ?? 'N/A' }}</div>
          @if($order->car && $order->car->price_per_day)
            <div style="font-size:12px;color:var(--text-2)">
              {{ number_format($order->car->price_per_day, 0, ',', '.') }}đ
            </div>
          @endif
        </td>
        <td>
          @if($order->consultation_status === 'chua_tu_van')
            <span class="badge badge-amber">Chưa tư vấn</span>
          @elseif($order->consultation_status === 'da_tu_van')
            <span class="badge badge-blue">Đã tư vấn ✓</span>
          @else
            <span class="badge badge-green">Đã chốt đơn 🎉</span>
          @endif
        </td>
        <td style="font-size:13px;color:var(--success);font-weight:700">
          {{ $order->commission_amount ? number_format($order->commission_amount,0,',','.') . 'đ' : '—' }}
        </td>
        <td style="font-size:12px;color:var(--text-2)">{{ $order->created_at->format('d/m/Y') }}</td>
        <td style="text-align:right">
          <div style="display:inline-flex;gap:6px;align-items:center">

            {{-- Đã tư vấn --}}
            @if($order->consultation_status === 'chua_tu_van')
            <form method="POST"
                  action="{{ route('admin.staff.orders.consultation', $order) }}"
                  style="display:inline">
              @csrf
              <input type="hidden" name="consultation_status" value="da_tu_van">
              <button type="submit" class="btn btn-sm"
                      style="background:var(--info);color:#fff;border-color:var(--info)"
                      onclick="return confirm('Xác nhận đã tư vấn xong khách này?')">
                ✓ Đã tư vấn
              </button>
            </form>
            @endif

            {{-- Chốt đơn — chỉ Manager/Admin thấy, đơn đã tư vấn --}}
            @if($order->consultation_status === 'da_tu_van' && (Auth::user()->isAdmin() || Auth::user()->isManager()))
            <button onclick="toggleClose({{ $order->id }})" class="btn btn-sm"
                    style="background:var(--success);color:#fff;border-color:var(--success)">
              💰 Chốt đơn
            </button>
            @endif

            {{-- Chi tiết --}}
            <button onclick="toggleDetail({{ $order->id }})" class="btn btn-sm">Chi tiết</button>

            {{-- Xóa — chỉ cho phép khi chưa tư vấn --}}
            @if($order->consultation_status === 'chua_tu_van')
            <form method="POST"
                  action="{{ route('admin.staff.orders.destroy', $order) }}"
                  style="display:inline"
                  onsubmit="return confirm('Xóa đơn hàng #{{ $order->id }} của {{ $order->customer_name }}? Hành động này không thể hoàn tác!')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
            </form>
            @endif

          </div>
        </td>
      </tr>

      {{-- Row chốt đơn (Manager/Admin) --}}
      @if($order->consultation_status === 'da_tu_van' && (Auth::user()->isAdmin() || Auth::user()->isManager()))
      <tr id="close-{{ $order->id }}" style="display:none">
        <td colspan="7" style="padding:16px 20px;background:#f0fdf4;border-bottom:1px solid var(--border)">
          <form method="POST" action="{{ route('admin.orders.close', $order) }}">
            @csrf
            <div style="font-weight:700;margin-bottom:12px;color:var(--success)">💰 Chốt đơn #{{ $order->id }} — {{ $order->customer_name }}</div>
            <div style="display:grid;grid-template-columns:1fr 1fr 2fr auto;gap:12px;align-items:end">
              <div>
                <label class="form-label">Giá bán thực tế (đ) <span style="color:var(--danger)">*</span></label>
                <input type="number" name="sale_price" class="form-control"
                       placeholder="VD: 5500000000"
                       value="{{ $order->car->price_per_day ?? '' }}"
                       min="1" required
                       oninput="calcCommission({{ $order->id }}, this.value)">
              </div>
              <div>
                <label class="form-label">Hoa hồng dự kiến</label>
                <div id="commission-preview-{{ $order->id }}"
                     style="padding:8px 12px;background:var(--bg);border:1px solid var(--border);border-radius:8px;font-weight:700;color:var(--success);font-size:14px;min-height:38px">
                  —
                </div>
              </div>
              <div>
                <label class="form-label">Ghi chú</label>
                <input type="text" name="manager_note" class="form-control" placeholder="Ghi chú thêm (nếu có)">
              </div>
              <div style="display:flex;gap:8px">
                <button type="button" onclick="toggleClose({{ $order->id }})" class="btn btn-sm">Hủy</button>
                <button type="submit" class="btn btn-sm"
                        style="background:var(--success);color:#fff;border-color:var(--success)"
                        onclick="return confirm('Xác nhận chốt đơn này?')">
                  ✓ Xác nhận chốt
                </button>
              </div>
            </div>
            <div style="margin-top:8px;font-size:12px;color:var(--text-2)">
              * Hoa hồng tự động: <strong>0.05%</strong> nếu &lt; 10 tỷ · <strong>0.1%</strong> nếu ≥ 10 tỷ
            </div>
          </form>
        </td>
      </tr>
      @endif

      {{-- Row chi tiết --}}
      <tr id="detail-{{ $order->id }}" style="display:none">
        <td colspan="7" style="padding:16px 20px;background:var(--bg);border-bottom:1px solid var(--border)">
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;font-size:13px">
            <div>
              <div style="font-weight:700;margin-bottom:8px">Thông tin khách</div>
              <div style="color:var(--text-2);line-height:2">
                Email: {{ $order->customer_email }}<br>
                @if($order->customer_address)Địa chỉ: {{ $order->customer_address }}<br>@endif
                @if($order->note)Ghi chú: {{ $order->note }}@endif
              </div>
            </div>
            @if($order->consultation_status === 'chua_tu_van')
            <div>
              <div style="font-weight:700;margin-bottom:8px">Cập nhật ghi chú tư vấn</div>
              <form method="POST" action="{{ route('admin.staff.orders.consultation', $order) }}">
                @csrf
                <input type="hidden" name="consultation_status" value="chua_tu_van">
                <textarea name="note" class="form-control" rows="2"
                          style="margin-bottom:8px"
                          placeholder="Ghi chú tình trạng tư vấn...">{{ $order->note }}</textarea>
                <button type="submit" class="btn btn-sm">Lưu ghi chú</button>
              </form>
            </div>
            @elseif($order->consultation_status === 'da_chot_don')
            <div>
              <div style="font-weight:700;margin-bottom:8px">Thông tin chốt đơn</div>
              <div style="color:var(--text-2);line-height:2">
                Giá chốt: <strong>{{ number_format($order->sale_price ?? 0, 0, ',', '.') }}đ</strong><br>
                Hoa hồng {{ $order->commission_rate }}%:
                <strong style="color:var(--success)">{{ number_format($order->commission_amount ?? 0, 0, ',', '.') }}đ</strong><br>
                Chốt lúc: {{ $order->closed_at?->format('d/m/Y H:i') ?? '—' }}<br>
                @if($order->manager_note)Ghi chú Manager: {{ $order->manager_note }}@endif
              </div>
            </div>
            @endif
          </div>
        </td>
      </tr>

      @empty
      <tr>
        <td colspan="7" style="text-align:center;padding:48px;color:var(--text-2)">
          Bạn chưa có đơn hàng nào.
          <a href="{{ route('admin.staff.orders.create') }}">Tạo đơn ngay →</a>
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

<script>
function toggleDetail(id) {
  const row = document.getElementById('detail-' + id);
  row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
}

function toggleClose(id) {
  const row = document.getElementById('close-' + id);
  row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
}

function calcCommission(id, value) {
  const sale = parseInt(value) || 0;
  const rate = sale >= 10000000000 ? 0.1 : 0.05;
  const commission = Math.round(sale * rate / 100);
  const el = document.getElementById('commission-preview-' + id);
  if (commission > 0) {
    el.textContent = commission.toLocaleString('vi-VN') + 'đ (' + rate + '%)';
  } else {
    el.textContent = '—';
  }
}
</script>

@endsection