{{-- resources/views/orders/show.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Chi tiết đơn hàng #' . $order->id)

@section('topbar-actions')
  <a href="{{ route('orders.index') }}" class="btn btn-sm">← Quay lại</a>
@endsection

@section('content')

<div style="display:grid;grid-template-columns:1fr 300px;gap:18px;align-items:start">

  {{-- Cột trái: thông tin xe --}}
  <div class="card card-pad">
    <div style="font-weight:600;font-size:15px;margin-bottom:14px">Thông tin xe</div>

    @if($order->car->image)
      <img src="{{ Storage::url($order->car->image) }}"
           style="width:100%;height:200px;object-fit:cover;border-radius:8px;border:1px solid var(--border);margin-bottom:14px">
    @endif

    <div style="display:flex;flex-direction:column;gap:8px;color:var(--text-muted);font-size:14px">
      <div><span style="color:var(--text);font-weight:500">Tên xe:</span> {{ $order->car->name }}</div>
      <div><span style="color:var(--text);font-weight:500">Hãng:</span> {{ $order->car->brand }}</div>
      <div><span style="color:var(--text);font-weight:500">Năm sản xuất:</span> {{ $order->car->year }}</div>
      <div><span style="color:var(--text);font-weight:500">Giá/ngày:</span> {{ number_format($order->car->price_per_day, 0, ',', '.') }}đ</div>
    </div>
  </div>

  {{-- Cột phải: thông tin đơn & hành động --}}
  <div style="display:flex;flex-direction:column;gap:14px">
    <div class="card card-pad">
      <div style="font-weight:600;font-size:15px;margin-bottom:14px">Thông tin đơn hàng</div>

      <div style="display:flex;flex-direction:column;gap:8px;font-size:14px;color:var(--text-muted)">
        <div><span style="color:var(--text);font-weight:500">Ngày thuê:</span>
          {{ \Carbon\Carbon::parse($order->start_date)->format('d/m/Y') }}</div>
        <div><span style="color:var(--text);font-weight:500">Ngày trả:</span>
          {{ \Carbon\Carbon::parse($order->end_date)->format('d/m/Y') }}</div>
        <div><span style="color:var(--text);font-weight:500">Số ngày:</span>
          {{ \Carbon\Carbon::parse($order->start_date)->diffInDays($order->end_date) }} ngày</div>
        <div><span style="color:var(--text);font-weight:500">Tổng tiền:</span>
          <span style="font-size:16px;font-weight:700;color:var(--primary)">
            {{ number_format($order->total_price, 0, ',', '.') }}đ
          </span>
        </div>
        <div style="margin-top:4px">
          <span style="color:var(--text);font-weight:500">Trạng thái:</span>
          @if($order->status === 'pending')
            <span class="badge badge-warning">Chờ xác nhận</span>
          @elseif($order->status === 'confirmed')
            <span class="badge badge-info">Đã xác nhận</span>
          @elseif($order->status === 'completed')
            <span class="badge badge-success">Hoàn thành</span>
          @else
            <span class="badge badge-danger">Đã hủy</span>
          @endif
        </div>
        @if($order->notes)
        <div><span style="color:var(--text);font-weight:500">Ghi chú:</span> {{ $order->notes }}</div>
        @endif
      </div>
    </div>

    {{-- Hành động --}}
    <div style="display:flex;gap:8px">
      @if($order->status === 'pending')
      <form method="POST" action="{{ route('orders.destroy', $order) }}"
            onsubmit="return confirm('Hủy đơn hàng này?')" style="flex:1">
        @csrf @method('DELETE')
        <button class="btn btn-danger" type="submit" style="width:100%;justify-content:center">Hủy đơn hàng</button>
      </form>
      @endif
      <a href="{{ route('orders.index') }}" class="btn" style="justify-content:center;flex:1">Quay lại</a>
    </div>
  </div>

</div>

@endsection