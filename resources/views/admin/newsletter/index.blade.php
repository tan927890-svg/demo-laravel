{{-- resources/views/admin/newsletter/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Newsletter')

@section('content')

{{-- Thống kê --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px">
  <div class="card card-pad" style="text-align:center">
    <div style="font-size:28px;font-weight:700;color:var(--primary)">{{ $totalActive }}</div>
    <div style="font-size:13px;color:var(--text-muted);margin-top:4px">Đang đăng ký</div>
  </div>
  <div class="card card-pad" style="text-align:center">
    <div style="font-size:28px;font-weight:700">{{ $subscribers->total() }}</div>
    <div style="font-size:13px;color:var(--text-muted);margin-top:4px">Tổng subscriber</div>
  </div>
  <div class="card card-pad" style="text-align:center">
    <div style="font-size:28px;font-weight:700;color:#e74c3c">{{ $subscribers->total() - $totalActive }}</div>
    <div style="font-size:13px;color:var(--text-muted);margin-top:4px">Đã hủy đăng ký</div>
  </div>
</div>

{{-- Bảng danh sách --}}
<div class="card">
  <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between">
    <span style="font-weight:600">Danh sách subscriber</span>
    <form method="GET" style="display:flex;gap:8px">
      <input class="form-control" name="search" value="{{ request('search') }}" placeholder="Tìm email..." style="width:220px">
      <select class="form-control" name="status" style="width:140px" onchange="this.form.submit()">
        <option value="">Tất cả</option>
        <option value="active"   {{ request('status') == 'active'   ? 'selected':'' }}>Active</option>
        <option value="inactive" {{ request('status') == 'inactive' ? 'selected':'' }}>Inactive</option>
      </select>
      <button class="btn btn-primary btn-sm" type="submit">Lọc</button>
    </form>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Email</th>
        <th>Tên</th>
        <th>Trạng thái</th>
        <th>Ngày đăng ký</th>
        <th style="text-align:right">Thao tác</th>
      </tr>
    </thead>
    <tbody>
      @forelse($subscribers as $i => $sub)
      <tr>
        <td style="color:var(--text-muted)">{{ $subscribers->firstItem() + $i }}</td>
        <td>{{ $sub->email }}</td>
        <td>{{ $sub->name ?? '—' }}</td>
        <td>
          @if($sub->status === 'active')
            <span class="badge badge-success">Active</span>
          @else
            <span class="badge badge-gray">Inactive</span>
          @endif
        </td>
        <td style="color:var(--text-muted)">{{ $sub->created_at->format('d/m/Y') }}</td>
        <td style="text-align:right">
          <form method="POST" action="{{ route('admin.newsletter.destroy', $sub) }}" onsubmit="return confirm('Xóa subscriber này?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger" type="submit">Xóa</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" style="text-align:center;padding:40px;color:var(--text-muted)">Chưa có subscriber nào.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  @if($subscribers->hasPages())
  <div style="padding:16px 20px;border-top:1px solid var(--border)">
    {{ $subscribers->withQueryString()->links() }}
  </div>
  @endif
</div>

@endsection