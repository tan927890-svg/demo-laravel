{{-- resources/views/orders/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Đơn hàng của tôi')

@section('content')

@if(session('success'))
  <div class="alert alert-success" style="margin-bottom:16px">{{ session('success') }}</div>
@endif

@if(session('error'))
  <div class="alert alert-error" style="margin-bottom:16px">{{ session('error') }}</div>
@endif

<div class="card">
  <div style="padding:16px 20px;border-bottom:1px solid var(--border)">
    <span style="font-weight:600">Danh sách đơn hàng</span>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Xe</th>
        <th>Ngày thuê</th>
        <th>Ngày trả</th>
        <th>Tổng tiền</th>
        <th>Trạng thái</th>
        <th style="text-align:right">Hành động</th>
      </tr>
    </thead>
    <tbody>
      @forelse($orders as $order)
      <tr>
        <td style="color:var(--text-muted)">{{ $order->id }}</td>
        <td style="font-weight:600">{{ $order->car->name ?? 'N/A' }}</td>
        <td style="color:var(--text-muted)">{{ \Carbon\Carbon::parse($order->start_date)->format('d/m/Y') }}</td>
        <td style="color:var(--text-muted)">{{ \Carbon\Carbon::parse($order->end_date)->format('d/m/Y') }}</td>
        <td style="font-weight:600">{{ number_format($order->total_price, 0, ',', '.') }}đ</td>
        <td>
          @if($order->status === 'pending')
            <span class="badge badge-warning">Chờ xác nhận</span>
          @elseif($order->status === 'confirmed')
            <span class="badge badge-info">Đã xác nhận</span>
          @elseif($order->status === 'completed')
            <span class="badge badge-success">Hoàn thành</span>
          @else
            <span class="badge badge-danger">Đã hủy</span>
          @endif
        </td>
        <td style="text-align:right;display:flex;gap:6px;justify-content:flex-end">
          <a href="{{ route('orders.show', $order) }}" class="btn btn-sm">Xem</a>
          @if($order->status === 'pending')
          <form method="POST" action="{{ route('orders.destroy', $order) }}" onsubmit="return confirm('Hủy đơn hàng này?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger" type="submit">Hủy</button>
          </form>
          @endif
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" style="text-align:center;padding:40px;color:var(--text-muted)">
          Bạn chưa có đơn hàng nào. <a href="{{ route('cars.index') }}" style="color:var(--primary)">Xem xe ngay</a>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>

  @if($orders->hasPages())
  <div style="padding:16px 20px;border-top:1px solid var(--border)">
    {{ $orders->links() }}
  </div>
  @endif
</div>

@endsection