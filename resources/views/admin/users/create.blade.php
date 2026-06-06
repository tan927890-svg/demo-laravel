@extends('layouts.admin')
@section('page-title', 'Thêm nhân viên mới')

@section('topbar-actions')
  <a href="{{ route('admin.users.index') }}" class="btn btn-sm">← Quay lại</a>
@endsection

@push('styles')
<style>
.edit-wrap { max-width: 520px; margin: 0 auto; }
.edit-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; overflow: hidden; }
.edit-header {
    padding: 24px 28px 20px; border-bottom: 1px solid #f3f4f6;
    display: flex; align-items: center; gap: 14px;
}
.edit-avatar {
    width: 44px; height: 44px; border-radius: 50%; background: #1d4ed8;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; color: #fff; flex-shrink: 0;
}
.edit-header-text h2 { font-size: 15px; font-weight: 700; color: #111; margin: 0 0 2px; }
.edit-header-text p  { font-size: 12px; color: #9ca3af; margin: 0; }
.edit-body { padding: 24px 28px; display: flex; flex-direction: column; gap: 18px; }
.field-group { display: flex; flex-direction: column; gap: 6px; }
.field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.field-label {
    font-size: 12px; font-weight: 600; color: #374151;
    letter-spacing: .3px; display: flex; align-items: center; gap: 4px;
}
.field-label span.req { color: #ef4444; }
.field-input {
    width: 100%; padding: 9px 13px; border: 1.5px solid #e5e7eb;
    border-radius: 8px; font-size: 13px; color: #111; background: #fafafa;
    outline: none; transition: border-color .15s, background .15s;
    font-family: inherit; box-sizing: border-box;
}
.field-input:focus { border-color: #1d4ed8; background: #fff; }
.field-input::placeholder { color: #c4c4c4; }
.field-error { font-size: 11px; color: #ef4444; display: flex; align-items: center; gap: 4px; }
.field-hint  { font-size: 11px; color: #9ca3af; }
.role-info {
    background: #f8faff; border: 1px solid #e0e7ff;
    border-radius: 8px; padding: 12px 14px; font-size: 12px;
    color: #374151; line-height: 1.7;
}
.role-info strong { color: #1d4ed8; }
.divider { height: 1px; background: #f3f4f6; margin: 2px 0; }
.edit-footer { padding: 16px 28px 24px; display: flex; gap: 10px; }
.btn-save {
    flex: 1; padding: 10px 0; background: #1d4ed8; color: #fff;
    border: none; border-radius: 8px; font-size: 13px; font-weight: 600;
    cursor: pointer; transition: background .15s; font-family: inherit;
}
.btn-save:hover { background: #1e40af; }
.btn-cancel {
    padding: 10px 20px; background: #f3f4f6; color: #374151; border: none;
    border-radius: 8px; font-size: 13px; font-weight: 500; text-decoration: none;
    display: inline-flex; align-items: center; cursor: pointer;
    transition: background .15s; font-family: inherit;
}
.btn-cancel:hover { background: #e5e7eb; }
</style>
@endpush

@section('content')
<div class="edit-wrap">
  <div class="edit-card">

    <div class="edit-header">
      <div class="edit-avatar">👤</div>
      <div class="edit-header-text">
        <h2>Thêm nhân viên mới</h2>
        <p>Tạo tài khoản và phân quyền truy cập</p>
      </div>
    </div>

    <form method="POST" action="{{ route('admin.users.store') }}">
      @csrf

      <div class="edit-body">

        {{-- Họ tên --}}
        <div class="field-group">
          <label class="field-label">Họ và tên <span class="req">*</span></label>
          <input type="text" name="name" class="field-input"
                 value="{{ old('name') }}" placeholder="Nguyễn Văn A" required>
          @error('name')<div class="field-error">⚠ {{ $message }}</div>@enderror
        </div>

        {{-- Username + Email --}}
        <div class="field-row">
          <div class="field-group">
            <label class="field-label">Tên đăng nhập <span class="req">*</span></label>
            <input type="text" name="username" class="field-input"
                   value="{{ old('username') }}"
                   placeholder="vd: nguyenvana" required
                   autocomplete="off" autocapitalize="none" spellcheck="false">
            @error('username')
              <div class="field-error">⚠ {{ $message }}</div>
            @else
              <div class="field-hint">Chữ thường, số, _ và - (không dấu)</div>
            @enderror
          </div>

          <div class="field-group">
            <label class="field-label">Email <span class="req">*</span></label>
            <input type="email" name="email" class="field-input"
                   value="{{ old('email') }}" placeholder="nhanvien@email.com" required>
            @error('email')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
        </div>

        {{-- Mật khẩu --}}
        <div class="field-group">
          <label class="field-label">Mật khẩu <span class="req">*</span></label>
          <input type="password" name="password" class="field-input"
                 placeholder="Tối thiểu 6 ký tự" required autocomplete="new-password">
          @error('password')<div class="field-error">⚠ {{ $message }}</div>@enderror
        </div>

        <div class="divider"></div>

        {{-- Vai trò --}}
        <div class="field-group">
          <label class="field-label">Vai trò <span class="req">*</span></label>
          <select name="role" class="field-input" required>
            <option value="staff" @selected(old('role')==='staff')>Staff – Nhân viên tư vấn</option>
            @if(auth()->user()->isAdmin())
              <option value="manager" @selected(old('role')==='manager')>Manager – Quản lý team</option>
            @endif
            {{-- Không cho phép tạo Admin mới dù bất kỳ ai --}}
          </select>
          @error('role')<div class="field-error">⚠ {{ $message }}</div>@enderror
          <div class="role-info">
            <strong>Staff</strong>: Tạo đơn, tư vấn khách, chấm công GPS<br>
            <strong>Manager</strong>: Duyệt đơn, nhập giá &amp; hoa hồng, xem báo cáo team
          </div>
        </div>

      </div>

      <div class="edit-footer">
        <button type="submit" class="btn-save">Tạo tài khoản</button>
        <a href="{{ route('admin.users.index') }}" class="btn-cancel">Hủy</a>
      </div>

    </form>
  </div>
</div>
@endsection