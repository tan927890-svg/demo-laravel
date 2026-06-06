@extends('layouts.admin')
@section('page-title', 'Sửa nhân viên: ' . $user->name)

@section('topbar-actions')
  <a href="{{ route('admin.users.index') }}" class="btn btn-sm">← Quay lại</a>
@endsection

@push('styles')
<style>
.edit-wrap { max-width: 560px; margin: 0 auto; }
.edit-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; overflow: hidden; }
.edit-header {
    padding: 24px 28px 20px; border-bottom: 1px solid #f3f4f6;
    display: flex; align-items: center; gap: 14px;
}
.edit-avatar {
    width: 44px; height: 44px; border-radius: 50%; background: #1d4ed8;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; font-weight: 700; color: #fff;
    flex-shrink: 0; letter-spacing: -0.5px; overflow: hidden;
}
.edit-avatar img { width: 100%; height: 100%; object-fit: cover; }
.edit-header-text h2 { font-size: 15px; font-weight: 700; color: #111; margin: 0 0 2px; }
.edit-header-text p  { font-size: 12px; color: #9ca3af; margin: 0; }
.section-title {
    font-size: 11px; font-weight: 700; color: #6b7280;
    letter-spacing: .6px; text-transform: uppercase; padding: 18px 28px 0;
}
.edit-body { padding: 14px 28px 4px; display: flex; flex-direction: column; gap: 16px; }
.field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.field-group { display: flex; flex-direction: column; gap: 6px; }
.field-label {
    font-size: 12px; font-weight: 600; color: #374151; letter-spacing: .3px;
    display: flex; align-items: center; gap: 4px;
}
.field-label .req  { color: #ef4444; }
.field-label .opt  { font-size: 11px; font-weight: 400; color: #9ca3af; }
.field-label .lock { font-size: 10px; color: #9ca3af; margin-left: auto; }
.field-input {
    width: 100%; padding: 9px 13px; border: 1.5px solid #e5e7eb; border-radius: 8px;
    font-size: 13px; color: #111; background: #fafafa; outline: none;
    transition: border-color .15s, background .15s; font-family: inherit; box-sizing: border-box;
}
.field-input:focus { border-color: #1d4ed8; background: #fff; }
.field-input::placeholder { color: #c4c4c4; }
.field-input:disabled, .field-input[readonly] {
    background: #f3f4f6; color: #9ca3af; cursor: not-allowed; border-color: #e5e7eb;
}
.field-error { font-size: 11px; color: #ef4444; display: flex; align-items: center; gap: 4px; }
.field-hint  { font-size: 11px; color: #9ca3af; }
.role-info {
    background: #f8faff; border: 1px solid #e0e7ff; border-radius: 8px;
    padding: 10px 14px; font-size: 12px; color: #374151; line-height: 1.8;
}
.role-info strong { color: #1d4ed8; }
.email-notice {
    background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px;
    padding: 10px 14px; font-size: 12px; color: #0369a1; line-height: 1.6;
}
.status-row { display: flex; align-items: center; gap: 10px; }
.badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
.badge-active  { background: #dcfce7; color: #166534; }
.badge-blocked { background: #fee2e2; color: #991b1b; }
.divider { height: 1px; background: #f3f4f6; margin: 4px 0; }
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
@media(max-width: 480px) {
    .field-row { grid-template-columns: 1fr; }
    .edit-body { padding: 14px 18px 4px; }
    .edit-footer { padding: 14px 18px 20px; }
    .section-title { padding: 14px 18px 0; }
}
</style>
@endpush

@section('content')
<div class="edit-wrap">
  <div class="edit-card">

    <div class="edit-header">
      <div class="edit-avatar">
        @if($user->avatar)
          <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
        @else
          {{ strtoupper(substr($user->name, 0, 2)) }}
        @endif
      </div>
      <div class="edit-header-text">
        <h2>Chỉnh sửa nhân viên</h2>
        <p>{{ $user->username }} · {{ $user->email }}</p>
      </div>
    </div>

    <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data">
      @csrf @method('PUT')

      {{-- ── Thông tin cơ bản ── --}}
      <p class="section-title">Thông tin cơ bản</p>
      <div class="edit-body">

        <div class="field-group">
          <label class="field-label">Họ và tên <span class="req">*</span></label>
          <input type="text" name="name" class="field-input"
                 value="{{ old('name', $user->name) }}" placeholder="Nguyễn Văn A" required>
          @error('name')<div class="field-error">⚠ {{ $message }}</div>@enderror
        </div>

        <div class="field-row">
          <div class="field-group">
            <label class="field-label">Tên đăng nhập <span class="req">*</span></label>
            <input type="text" name="username" class="field-input"
                   value="{{ old('username', $user->username) }}"
                   placeholder="vd: nguyenvana" required
                   autocomplete="off" autocapitalize="none" spellcheck="false">
            @error('username')
              <div class="field-error">⚠ {{ $message }}</div>
            @else
              <div class="field-hint">Chữ thường, số, _ và - (không dấu)</div>
            @enderror
          </div>

          <div class="field-group">
            <label class="field-label">Số điện thoại <span class="opt">(tuỳ chọn)</span></label>
            <input type="text" name="phone" class="field-input"
                   value="{{ old('phone', $user->phone) }}" placeholder="0901 234 567">
            @error('phone')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
        </div>

        <div class="field-group">
          <label class="field-label">Ảnh đại diện <span class="opt">(tuỳ chọn)</span></label>
          <input type="file" name="avatar" class="field-input" accept="image/*">
          @error('avatar')<div class="field-error">⚠ {{ $message }}</div>@enderror
        </div>

      </div>

      {{-- ── Email (chỉ Admin) ── --}}
      @if(auth()->user()->isAdmin())
        <div class="divider" style="margin: 10px 0 0;"></div>
        <p class="section-title">Email đăng nhập</p>
        <div class="edit-body">
          <div class="field-group">
            <label class="field-label">
              Email <span class="req">*</span>
              <span class="lock">🔒 Chỉ Admin</span>
            </label>
            <input type="email" name="email" class="field-input"
                   value="{{ old('email', $user->email) }}"
                   placeholder="email@example.com" required>
            @error('email')<div class="field-error">⚠ {{ $message }}</div>@enderror
            <div class="email-notice">
              ℹ️ Khi đổi email, hệ thống sẽ gửi OTP xác nhận đến địa chỉ email mới trước khi cập nhật.
            </div>
          </div>
        </div>
      @endif

      {{-- ── Phân quyền & Trạng thái ── --}}
      <div class="divider" style="margin: 10px 0 0;"></div>
      <p class="section-title">Phân quyền & Trạng thái</p>
      <div class="edit-body" style="padding-bottom: 8px;">

        @if(auth()->user()->isAdmin())
          <div class="field-group">
            <label class="field-label">
              Vai trò <span class="req">*</span>
              <span class="lock">🔒 Chỉ Admin</span>
            </label>
            <select name="role" class="field-input" required>
              <option value="staff"   @selected(old('role',$user->role)==='staff')>Staff – Nhân viên tư vấn</option>
              <option value="manager" @selected(old('role',$user->role)==='manager')>Manager – Quản lý team</option>
              {{-- Không có option admin — không cho tạo thêm admin --}}
            </select>
            @error('role')<div class="field-error">⚠ {{ $message }}</div>@enderror
            <div class="role-info">
              <strong>Staff</strong>: Tạo đơn, tư vấn khách, chấm công GPS<br>
              <strong>Manager</strong>: Duyệt đơn, nhập giá &amp; hoa hồng, xem báo cáo team
            </div>
          </div>
        @else
          <input type="hidden" name="role" value="{{ $user->role }}">
          <div class="field-group">
            <label class="field-label">Vai trò hiện tại</label>
            <input type="text" class="field-input" readonly
                   value="{{ match($user->role) {
                     'admin'   => 'Admin – Toàn quyền hệ thống',
                     'manager' => 'Manager – Quản lý team',
                     default   => 'Staff – Nhân viên tư vấn',
                   } }}">
          </div>
        @endif

        <div class="field-group">
          <label class="field-label">Trạng thái tài khoản</label>
          <div class="status-row">
            <select name="status" class="field-input" style="flex:1">
              <option value="active"  @selected(old('status',$user->status)==='active')>✅ Hoạt động</option>
              <option value="blocked" @selected(old('status',$user->status)==='blocked')>🚫 Đã khóa</option>
            </select>
            <span class="badge {{ $user->status === 'active' ? 'badge-active' : 'badge-blocked' }}">
              {{ $user->status === 'active' ? '● Đang hoạt động' : '● Đã khóa' }}
            </span>
          </div>
          @error('status')<div class="field-error">⚠ {{ $message }}</div>@enderror
        </div>

      </div>

      <div class="edit-footer">
        <button type="submit" class="btn-save">Lưu thay đổi</button>
        <a href="{{ route('admin.users.index') }}" class="btn-cancel">Hủy</a>
      </div>

    </form>
  </div>
</div>

{{-- ── Lịch sử thay đổi ── --}}
@if($user->logs->count())
<div class="edit-wrap" style="margin-top:16px">
  <div class="edit-card">
    <div class="edit-header" style="padding:16px 28px">
      <div style="font-size:13px;font-weight:700;color:#111">🕓 Lịch sử thay đổi</div>
    </div>
    @foreach($user->logs->take(10) as $log)
      @php
        $changes = is_string($log->changes) ? json_decode($log->changes, true) : $log->changes;
      @endphp
      <div style="padding:12px 28px;border-bottom:1px solid #f3f4f6">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
          <span style="font-size:12px;font-weight:600;color:#111">
            @if($log->action === 'password_reset_self')
              👤 {{ $user->name }} <span style="font-weight:400;color:#6b7280">(tự đổi)</span>
            @else
              {{ $log->causer?->name ?? 'Hệ thống' }}
            @endif
          </span>
          <span style="font-size:11px;color:#9ca3af">
            {{ $log->created_at->diffForHumans() }} · {{ $log->created_at->format('d/m/Y H:i') }}
          </span>
        </div>
        @if($log->action === 'password_reset_by_admin')
          <div style="font-size:12px;color:#f59e0b">🔑 Admin đặt lại mật khẩu</div>
        @elseif($log->action === 'password_reset_self')
          <div style="font-size:12px;color:#16a34a">🔑 Tự đổi mật khẩu qua OTP</div>
        @elseif(!empty($changes))
          @foreach($changes as $change)
            <div style="font-size:12px;color:#374151;margin-top:2px">
              <span style="color:#6b7280">{{ $change['field'] }}:</span>
              <span style="color:#ef4444">{{ $change['old'] }}</span>
              <span style="color:#9ca3af;margin:0 4px">→</span>
              <span style="color:#16a34a">{{ $change['new'] }}</span>
            </div>
          @endforeach
        @endif
      </div>
    @endforeach
  </div>
</div>
@endif

@endsection