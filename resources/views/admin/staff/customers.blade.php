@extends('layouts.admin')

@section('page-title', 'Quản lý khách hàng')

@section('content')
<div style="padding:4px 0 20px;">

  {{-- Filter bar --}}
  <form method="GET" action="{{ route('admin.staff.customers') }}"
        style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:18px; align-items:center;">

    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Tìm tên, email, SĐT..."
           class="form-control" style="max-width:240px;">

    @if($staffList->isNotEmpty())
    <select name="staff_id" class="form-control" style="max-width:200px;">
      <option value="">— Tất cả nhân viên —</option>
      @foreach($staffList as $staff)
        <option value="{{ $staff->id }}" {{ request('staff_id') == $staff->id ? 'selected' : '' }}>
          {{ $staff->name }}
        </option>
      @endforeach
    </select>
    @endif

    <select name="status" class="form-control" style="max-width:180px;">
      <option value="">— Tất cả trạng thái —</option>
      <option value="chua_tu_van"  {{ request('status') === 'chua_tu_van'  ? 'selected' : '' }}>Chưa tư vấn</option>
      <option value="da_tu_van"    {{ request('status') === 'da_tu_van'    ? 'selected' : '' }}>Đã tư vấn</option>
      <option value="da_chot_don"  {{ request('status') === 'da_chot_don'  ? 'selected' : '' }}>Đã chốt đơn</option>
    </select>

    <button type="submit" class="btn btn-primary">Lọc</button>

    @if(request('search') || request('staff_id') || request('status'))
      <a href="{{ route('admin.staff.customers') }}" class="btn">✕ Xoá lọc</a>
    @endif
  </form>

  <div class="card">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Khách hàng</th>
          <th>Email</th>
          @if($staffList->isNotEmpty())
          <th>Nhân viên phụ trách</th>
          @endif
          <th>Trạng thái</th>
          <th>Ghi chú</th>
          <th style="text-align:center">Thao tác</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $i => $order)
        <tr>
          <td style="color:var(--text-3)">{{ $orders->firstItem() + $i }}</td>
          <td>
            <div style="font-weight:600">{{ $order->customer_name }}</div>
            <div style="font-size:13px; color:var(--text-3); margin-top:2px">{{ $order->customer_phone }}</div>
          </td>
          <td style="font-size:14px">{{ $order->customer_email }}</td>
          @if($staffList->isNotEmpty())
          <td>
            @if($order->assignedUser)
              <div style="font-size:14px; font-weight:600">{{ $order->assignedUser->name }}</div>
              <div style="font-size:13px; color:var(--text-3); margin-top:2px">
                @if($order->assignedUser->isStaff()) Nhân viên
                @elseif($order->assignedUser->isManager()) Manager
                @else Admin
                @endif
              </div>
            @else
              <span style="color:var(--text-3)">—</span>
            @endif
          </td>
          @endif
          <td>
            <span class="badge {{ $order->consultation_badge }}">
              {{ $order->consultation_label }}
            </span>
          </td>
          <td style="font-size:13px; color:var(--text-2); max-width:180px">
            {{ $order->note ?? '—' }}
          </td>
          <td style="text-align:center">
            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm">Chi tiết</a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="{{ $staffList->isNotEmpty() ? 7 : 6 }}"
              style="text-align:center; padding:40px; color:var(--text-3)">
            Chưa có khách hàng nào.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>

    @if($orders->hasPages())
    <div class="card-pad" style="padding-top:0">
      {{ $orders->links() }}
    </div>
    @endif
  </div>

</div>
@endsection