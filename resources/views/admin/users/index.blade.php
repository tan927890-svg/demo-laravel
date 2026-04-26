@extends('layouts.admin')
@section('page-title', 'Quản lý nhân viên')

@section('topbar-actions')
  @if(auth()->user()->isAdmin() || auth()->user()->isManager())
  <a href="{{ route('admin.users.create') }}" class="btn btn-sm">+ Thêm nhân viên</a>
  @endif
@endsection

@section('content')

@if(session('success'))
  <div class="alert alert-success" style="margin-bottom:16px">{{ session('success') }}</div>
@endif

@if(session('error'))
  <div class="alert alert-danger" style="margin-bottom:16px">{{ session('error') }}</div>
@endif

<div class="card">
  <div style="padding:14px 18px;border-bottom:1px solid var(--border);font-weight:600">
    Danh sách nhân viên
    <span style="font-size:12px;font-weight:400;color:var(--text-muted);margin-left:6px">
      {{ $users->total() }} người
    </span>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th>Nhân viên</th>
        <th>Email</th>
        <th>Vai trò</th>
        <th style="text-align:center">Đơn chốt</th>
        <th style="text-align:center">Doanh thu</th>
        <th>Ngày tạo</th>
        <th style="text-align:right">Hành động</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $user)
      <tr>
        <td>
          <div style="font-weight:500">{{ $user->name }}</div>

          {{-- Nhân viên tự đổi mật khẩu qua OTP --}}
          @if($user->password_reset_at)
            <div style="font-size:11px;color:#16a34a;margin-top:2px">
              🔑 Đổi mật khẩu {{ $user->password_reset_at->diffForHumans() }}
            </div>
          @endif

          {{-- Badge nếu admin/manager vừa chỉnh sửa --}}
          @if($user->logs->first())
            <div style="font-size:11px;color:#6366f1;margin-top:2px">
              • vừa cập nhật {{ $user->logs->first()->created_at->diffForHumans() }}
            </div>
          @endif
        </td>
        <td style="font-size:13px;color:var(--text-muted)">{{ $user->email }}</td>
        <td>
          @if($user->role === 'admin')
            <span class="badge badge-danger">Admin</span>
          @elseif($user->role === 'manager')
            <span class="badge badge-warning">Manager</span>
          @else
            <span class="badge badge-info">Staff</span>
          @endif
        </td>
        <td style="text-align:center">
          {{ $user->orders()->where('consultation_status','da_chot_don')->count() }}
        </td>
        <td style="text-align:center;font-size:13px;color:var(--primary)">
          @php
            $rev = $user->orders()->where('consultation_status','da_chot_don')->sum('sale_price');
          @endphp
          {{ $rev > 0 ? number_format($rev,0,',','.') . 'đ' : '—' }}
        </td>
        <td style="font-size:12px;color:var(--text-muted)">
          {{ $user->created_at->format('d/m/Y') }}
        </td>
        <td style="text-align:right;display:flex;gap:6px;justify-content:flex-end">
          <a href="{{ route('admin.kpi.show', $user) }}" class="btn btn-sm">KPI</a>

          @if(auth()->user()->isAdmin() || (auth()->user()->isManager() && $user->role === 'staff'))
          <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm">Sửa</a>
          @endif

          @if(
            (auth()->user()->isAdmin() && $user->role !== 'admin') ||
            (auth()->user()->isManager() && $user->role === 'staff')
          )
          <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                onsubmit="return confirm('Xóa nhân viên {{ $user->name }}?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
          </form>
          @endif
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" style="text-align:center;padding:40px;color:var(--text-muted)">
          Chưa có nhân viên nào.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>

  @if($users->hasPages())
  <div style="padding:14px 18px;border-top:1px solid var(--border)">
    {{ $users->links() }}
  </div>
  @endif
</div>

@endsection