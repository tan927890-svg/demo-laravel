@extends('layouts.admin')
@section('page-title', 'Tạo thông báo mới')

@section('topbar-actions')
  <a href="{{ route('admin.notifications.index') }}" class="btn btn-sm">← Quay lại</a>
@endsection

@section('content')
<div class="card card-pad" style="max-width:600px;margin:0 auto">
  <form method="POST" action="{{ route('admin.notifications.store') }}">
    @csrf

    <div class="form-group">
      <label class="form-label">Tiêu đề <span style="color:var(--danger)">*</span></label>
      <input type="text" name="title" class="form-control" value="{{ old('title') }}"
        placeholder="VD: Họp nhân viên sáng thứ 2" required>
      @error('title') <div class="form-hint" style="color:var(--danger)">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label class="form-label">Nội dung <span style="color:var(--danger)">*</span></label>
      <textarea name="body" class="form-control" rows="5"
        placeholder="Nội dung chi tiết thông báo..." required>{{ old('body') }}</textarea>
      @error('body') <div class="form-hint" style="color:var(--danger)">{{ $message }}</div> @enderror
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Loại thông báo</label>
        <select name="type" class="form-control">
          <option value="info"    @selected(old('type')=='info')>ℹ️ Thông tin</option>
          <option value="warning" @selected(old('type')=='warning')>⚠️ Cảnh báo</option>
          <option value="success" @selected(old('type')=='success')>✅ Tốt</option>
          <option value="urgent"  @selected(old('type')=='urgent')>🚨 Khẩn cấp</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Gửi đến</label>
        <select name="target_role" class="form-control">
          <option value="all"     @selected(old('target_role')=='all')>Tất cả</option>
          <option value="staff"   @selected(old('target_role')=='staff')>Chỉ nhân viên</option>
          <option value="manager" @selected(old('target_role')=='manager')>Chỉ Manager</option>
        </select>
      </div>
    </div>

    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:8px">
      <a href="{{ route('admin.notifications.index') }}" class="btn">Hủy</a>
      <button type="submit" class="btn btn-primary">📢 Gửi thông báo</button>
    </div>
  </form>
</div>
@endsection
