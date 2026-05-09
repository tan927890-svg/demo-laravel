{{-- resources/views/admin/orders/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Đơn hàng của tôi')

@section('content')

{{-- XÓA SAU KHI TEST --}}
@php dd($allOrders) @endphp

@if(session('success'))
  <div class="alert alert-success" style="margin-bottom:16px">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-error" style="margin-bottom:16px">{{ session('error') }}</div>
@endif

<div class="card">
  <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center">
    <span style="font-weight:600">Danh sách đơn hàng</span>
    <span style="font-size:13px;color:var(--text-muted)">{{ $orders->total() }} đơn</span>
  </div>

  <table class="table">
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
      @php
        $key = $order->customer_phone . '|' . $order->customer_name;
        $isLoyal = ($allOrders[$key] ?? 0) >= 2;
      @endphp
      <tr>
        <td style="color:var(--text-muted)">#{{ $order->id }}</td>

        {{-- Khách hàng --}}
        <td>
          <div style="font-weight:600">{{ $order->customer_name ?? 'N/A' }}</div>
          <div style="font-size:12px;color:var(--text-muted)">{{ $order->customer_phone ?? '' }}</div>
          @if($isLoyal)
            <span style="
              display:inline-block;
              margin-top:4px;
              font-size:11px;
              background:#fef3c7;
              color:#d97706;
              padding:2px 8px;
              border-radius:999px;
              font-weight:600;
            ">⭐ Thân thuộc</span>
          @endif
        </td>

        {{-- Xe --}}
        <td>
          <div style="font-weight:500">{{ $order->car->name ?? 'N/A' }}</div>
          @if($order->car?->price)
            <div style="font-size:12px;color:var(--text-muted)">
              {{ number_format($order->car->price, 0, ',', '.') }}đ
            </div>
          @endif
        </td>

        {{-- Trạng thái --}}
        <td>
          @if($order->consultation_status === 'chua_tu_van')
            <span class="badge badge-warning">Chưa tư vấn</span>
          @elseif($order->consultation_status === 'da_tu_van')
            <span class="badge badge-info">Đã tư vấn ✓</span>
          @elseif($order->consultation_status === 'da_chot_don')
            <span class="badge badge-success">Đã chốt đơn 🎉</span>
          @endif
        </td>

        {{-- Hoa hồng --}}
        <td style="font-weight:600;color:#16a34a">
          @if($order->commission_amount)
            {{ number_format($order->commission_amount, 0, ',', '.') }}đ
          @else
            <span style="color:var(--text-muted)">—</span>
          @endif
        </td>

        {{-- Ngày tạo --}}
        <td style="color:var(--text-muted)">
          {{ $order->created_at->format('d/m/Y') }}
        </td>

        {{-- Thao tác --}}
        <td style="text-align:right">
          <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm">Chi tiết</a>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" style="text-align:center;padding:40px;color:var(--text-muted)">
          Chưa có đơn hàng nào.
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