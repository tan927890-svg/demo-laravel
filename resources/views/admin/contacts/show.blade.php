@extends('layouts.admin')
@section('page-title', 'Chi tiết liên hệ')

{{-- Bỏ nút "Đánh dấu tất cả đã đọc" ở trang chi tiết để tránh nhầm lẫn --}}

@push('styles')
<style>
.detail-label {
    font-size:13px; font-weight:700; color:#6b7280;
    text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px;
    display:flex; align-items:center; gap:5px;
}
.detail-value { font-size:16px; color:#111827; }
.tag {
    display:inline-block; font-size:13px; font-weight:700;
    padding:4px 12px; border-radius:20px; letter-spacing:.4px;
    text-transform:uppercase; white-space:nowrap;
}
.tag-baogianhanh { background:#fef3c7; color:#92400e; }
.tag-datlich     { background:#dbeafe; color:#1e40af; }
.tag-baoduong    { background:#d1fae5; color:#065f46; }
.tag-nhangiao    { background:#ede9fe; color:#5b21b6; }
.tag-lienhe      { background:#f3f4f6; color:#374151; }

@keyframes popIn {
    from { opacity:0; transform:scale(.94) translateY(10px); }
    to   { opacity:1; transform:scale(1)   translateY(0);    }
}
</style>
@endpush

@section('content')

@if(session('success'))
  <div class="alert alert-success" style="margin-bottom:12px">{{ session('success') }}</div>
@endif

@php
  $subjectLower = strtolower($contact->subject ?? '');
  if (str_contains($subjectLower, 'báo giá') || str_contains($subjectLower, 'bao gia')) {
      $tagClass = 'tag-baogianhanh'; $tagLabel = 'Báo giá';
  } elseif (str_contains($subjectLower, 'đặt lịch') || str_contains($subjectLower, 'dat lich')) {
      $tagClass = 'tag-datlich'; $tagLabel = 'Đặt lịch';
  } elseif (str_contains($subjectLower, 'bảo dưỡng') || str_contains($subjectLower, 'bao duong') || str_contains($subjectLower, 'nhắc')) {
      $tagClass = 'tag-baoduong'; $tagLabel = 'Bảo dưỡng';
  } elseif (str_contains($subjectLower, 'nhận') || str_contains($subjectLower, 'giao xe') || str_contains($subjectLower, 'pickup')) {
      $tagClass = 'tag-nhangiao'; $tagLabel = 'Nhận/Giao';
  } else {
      $tagClass = 'tag-lienhe'; $tagLabel = 'Liên hệ';
  }
@endphp

<div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden">

  {{-- Header --}}
  <div style="display:flex;align-items:center;justify-content:space-between;
              padding:16px 24px;border-bottom:1px solid #f3f4f6;background:#fafafa">
    <div style="display:flex;align-items:center;gap:12px">
      <a href="{{ route('admin.contacts.index') }}"
         style="display:inline-flex;align-items:center;gap:5px;font-size:14px;color:#6b7280;
                text-decoration:none;padding:6px 12px;border:1px solid #e5e7eb;
                border-radius:7px;background:#fff">
        <svg width="14" height="14" fill="none" stroke="#6b7280" stroke-width="2" viewBox="0 0 24 24">
          <path d="M19 12H5M12 5l-7 7 7 7"/>
        </svg>
        Quay lại
      </a>
      <span class="tag {{ $tagClass }}">{{ $tagLabel }}</span>
      {{-- Luôn hiển thị "Đã đọc" vì show() đã mark rồi --}}
      <span style="font-size:14px;color:#9ca3af;display:flex;align-items:center;gap:4px">
        <svg width="14" height="14" fill="none" stroke="#9ca3af" stroke-width="2.5" viewBox="0 0 24 24">
          <path d="M20 6L9 17l-5-5"/>
        </svg>
        Đã đọc
      </span>
    </div>
    <div style="display:flex;align-items:center;gap:16px">
      <span style="font-size:14px;color:#9ca3af">{{ $contact->created_at->format('d/m/Y H:i') }}</span>
      <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}"
            id="deleteForm" style="margin:0">
        @csrf @method('DELETE')
        <button type="button"
                onclick="document.getElementById('deleteModal').style.display='flex'"
                style="font-size:14px;color:#ef4444;background:none;border:none;
                       cursor:pointer;padding:0;display:inline-flex;align-items:center;gap:5px">
          <svg width="14" height="14" fill="none" stroke="#ef4444" stroke-width="2" viewBox="0 0 24 24">
            <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/>
          </svg>
          Xóa
        </button>
      </form>
    </div>
  </div>

  {{-- Thông tin 4 cột --}}
  <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:0;border-bottom:1px solid #f3f4f6">
    <div style="padding:20px 24px;border-right:1px solid #f3f4f6">
      <div class="detail-label">
        <svg width="14" height="14" fill="none" stroke="#6366f1" stroke-width="2" viewBox="0 0 24 24">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
        </svg>
        Họ tên
      </div>
      <div class="detail-value" style="font-weight:700">{{ $contact->name }}</div>
    </div>
    <div style="padding:20px 24px;border-right:1px solid #f3f4f6">
      <div class="detail-label">
        <svg width="14" height="14" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
          <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.71 3.35 2 2 0 0 1 3.7 1h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 8.91a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/>
        </svg>
        Điện thoại
      </div>
      <div class="detail-value">
        @if($contact->phone)
          <a href="tel:{{ $contact->phone }}" style="color:#1d4ed8;font-weight:600">{{ $contact->phone }}</a>
        @else <span style="color:#d1d5db">—</span> @endif
      </div>
    </div>
    <div style="padding:20px 24px;border-right:1px solid #f3f4f6">
      <div class="detail-label">
        <svg width="14" height="14" fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24">
          <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
          <polyline points="22,6 12,13 2,6"/>
        </svg>
        Email
      </div>
      <div class="detail-value">
        @if($contact->email)
          <a href="mailto:{{ $contact->email }}" style="color:#1d4ed8">{{ $contact->email }}</a>
        @else <span style="color:#d1d5db">—</span> @endif
      </div>
    </div>
    <div style="padding:20px 24px">
      <div class="detail-label">
        <svg width="14" height="14" fill="none" stroke="#0ea5e9" stroke-width="2" viewBox="0 0 24 24">
          <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/>
          <line x1="8" y1="18" x2="21" y2="18"/>
          <line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/>
          <line x1="3" y1="18" x2="3.01" y2="18"/>
        </svg>
        Tiêu đề
      </div>
      <div class="detail-value">{{ $contact->subject ?? '—' }}</div>
    </div>
  </div>

  {{-- Nội dung --}}
  <div style="padding:20px 24px;border-bottom:1px solid #f3f4f6">
    <div class="detail-label" style="margin-bottom:10px">
      <svg width="14" height="14" fill="none" stroke="#8b5cf6" stroke-width="2" viewBox="0 0 24 24">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
      </svg>
      Nội dung tin nhắn
    </div>
    <div style="font-size:15px;color:#374151;line-height:1.8;white-space:pre-wrap;
                padding:16px;background:#f9fafb;border-radius:8px;">{{ $contact->message }}</div>
  </div>

  {{-- Phân công --}}
  <div style="padding:20px 24px">
    <div style="font-size:15px;font-weight:700;color:#111827;margin-bottom:14px;
                display:flex;align-items:center;gap:8px">
      <svg width="16" height="16" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
      </svg>
      Phân công nhân viên
      @if($contact->assignedTo)
        <span style="font-size:13px;background:#d1fae5;color:#065f46;border-radius:20px;
                     padding:3px 12px;font-weight:600">
          ✓ {{ $contact->assignedTo->name }}
          @if($contact->assigned_at)
            <span style="font-weight:400;opacity:.7">— {{ \Carbon\Carbon::parse($contact->assigned_at)->format('d/m H:i') }}</span>
          @endif
        </span>
      @else
        <span style="font-size:14px;color:#9ca3af;font-weight:400">Chưa phân công</span>
      @endif
    </div>

    <form method="POST" action="{{ route('admin.contacts.assign', $contact) }}">
      @csrf
      <div style="display:flex;gap:12px;align-items:flex-end">
        <div style="flex:1">
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px">
            Nhân viên <span style="color:red">*</span>
          </label>
          <select name="assigned_to" required
              style="width:100%;border:1px solid #d1d5db;border-radius:8px;
                     padding:10px 12px;font-size:14px;color:#111827">
            <option value="">-- Chọn nhân viên --</option>
            @foreach($staffList as $staff)
              <option value="{{ $staff->id }}" {{ $contact->assigned_to == $staff->id ? 'selected' : '' }}>
                {{ $staff->name }} ({{ ucfirst($staff->role) }})
              </option>
            @endforeach
          </select>
        </div>
        <div style="flex:2">
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px">
            Ghi chú
          </label>
          <input type="text" name="staff_note" value="{{ $contact->staff_note }}"
              placeholder="Lưu ý khi liên hệ khách..."
              style="width:100%;border:1px solid #d1d5db;border-radius:8px;
                     padding:10px 12px;font-size:14px;color:#111827">
        </div>
        <div>
          <button type="submit" class="btn btn-primary"
                  style="font-size:14px;padding:10px 20px;white-space:nowrap">
            ✓ Phân công
          </button>
        </div>
      </div>
    </form>
  </div>

</div>

{{-- Delete Modal --}}
<div id="deleteModal"
     style="display:none;position:fixed;inset:0;z-index:9999;
            align-items:center;justify-content:center;pointer-events:none">
  <div style="pointer-events:auto;background:#fff;border-radius:16px;padding:32px 28px;
              max-width:380px;width:90%;text-align:center;animation:popIn .2s ease;
              box-shadow:0 8px 48px rgba(0,0,0,.15);border:1px solid #fecaca;">
    <div style="width:52px;height:52px;background:#fee2e2;border-radius:50%;
                display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
      <svg width="24" height="24" fill="none" stroke="#ef4444" stroke-width="2.2" viewBox="0 0 24 24">
        <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/>
      </svg>
    </div>
    <div style="font-size:18px;font-weight:700;color:#111827;margin-bottom:8px">Xóa liên hệ này?</div>
    <div style="font-size:14px;color:#6b7280;line-height:1.7;margin-bottom:24px">
      Hành động này không thể hoàn tác.<br>Liên hệ sẽ bị xóa vĩnh viễn.
    </div>
    <div style="display:flex;gap:10px;justify-content:center">
      <button onclick="document.getElementById('deleteModal').style.display='none'"
              style="padding:10px 24px;border:1px solid #e5e7eb;border-radius:8px;
                     font-size:14px;font-weight:600;color:#374151;background:#fff;cursor:pointer">
        Hủy bỏ
      </button>
      <button onclick="document.getElementById('deleteForm').submit()"
              style="padding:10px 24px;background:#ef4444;border:none;border-radius:8px;
                     font-size:14px;font-weight:600;color:#fff;cursor:pointer">
        Xóa vĩnh viễn
      </button>
    </div>
  </div>
</div>

@endsection