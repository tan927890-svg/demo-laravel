@extends('layouts.admin')

@section('page-title', 'Hồ sơ cá nhân')

@push('styles')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;600;700;800&display=swap');

  .profile-wrap {
    max-width: 780px;
    margin: 0 auto;
    font-family: 'Bricolage Grotesque', var(--font);
  }

  /* ── PAGE HEADER ── */
  .profile-header {
    margin-bottom: 32px;
  }
  .profile-header h1 {
    font-size: 26px;
    font-weight: 800;
    letter-spacing: -.6px;
    color: var(--text);
    margin-bottom: 4px;
  }
  .profile-header p {
    font-size: 14px;
    color: var(--text-3);
  }

  /* ── TABS ── */
  .profile-tabs {
    display: flex;
    gap: 0;
    margin-bottom: 28px;
    border-bottom: 2px solid var(--border);
  }
  .profile-tab-btn {
    padding: 10px 22px;
    border: none;
    background: transparent;
    font-family: 'Bricolage Grotesque', var(--font);
    font-size: 14px;
    font-weight: 700;
    color: var(--text-3);
    cursor: pointer;
    position: relative;
    transition: color .18s;
    margin-bottom: -2px;
  }
  .profile-tab-btn::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
    background: var(--text);
    border-radius: 2px 2px 0 0;
    transform: scaleX(0);
    transition: transform .2s cubic-bezier(.4,0,.2,1);
  }
  .profile-tab-btn.active {
    color: var(--text);
  }
  .profile-tab-btn.active::after {
    transform: scaleX(1);
  }

  /* ── CARD ── */
  .profile-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 18px;
    overflow: hidden;
  }

  /* ── AVATAR SECTION ── */
  .avatar-section {
    display: flex;
    align-items: center;
    gap: 24px;
    padding: 28px 28px 24px;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(135deg, #fafaf8 0%, #f4f4f0 100%);
  }
  .avatar-ring {
    position: relative;
    width: 88px;
    height: 88px;
    flex-shrink: 0;
  }
  .avatar-ring::before {
    content: '';
    position: absolute;
    inset: -3px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f59e0b, #f97316, #ef4444);
    z-index: 0;
  }
  #avatar-preview {
    position: relative;
    z-index: 1;
    width: 88px;
    height: 88px;
    border-radius: 50%;
    overflow: hidden;
    background: linear-gradient(135deg, #f59e0b, #f97316);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    font-weight: 800;
    color: #fff;
    border: 3px solid #fff;
  }
  #avatar-preview img {
    width: 100%; height: 100%; object-fit: cover;
  }
  .avatar-upload-btn {
    position: absolute;
    bottom: 0; right: -2px;
    width: 28px; height: 28px;
    border-radius: 50%;
    background: var(--text);
    color: #fff;
    border: 2px solid #fff;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    z-index: 2;
    transition: background .15s, transform .15s;
  }
  .avatar-upload-btn:hover { background: #333; transform: scale(1.08); }
  .avatar-upload-btn svg { width: 12px; height: 12px; }

  .avatar-info .user-fullname {
    font-size: 20px;
    font-weight: 800;
    letter-spacing: -.3px;
    color: var(--text);
    margin-bottom: 4px;
  }
  .avatar-info .user-meta {
    font-size: 13px;
    color: var(--text-3);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .role-badge {
    display: inline-flex;
    align-items: center;
    padding: 2px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .3px;
    text-transform: uppercase;
  }
  .role-admin   { background: #1a1a1a; color: #fff; }
  .role-manager { background: #dbeafe; color: #1d4ed8; }
  .role-staff   { background: #dcfce7; color: #15803d; }

  .upload-label {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    border-radius: 10px;
    border: 1.5px solid var(--border);
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    background: #fff;
    color: var(--text-2);
    transition: all .15s;
    font-family: 'Bricolage Grotesque', var(--font);
  }
  .upload-label:hover {
    border-color: #aaa;
    background: var(--bg);
    color: var(--text);
  }
  .upload-label svg { width: 14px; height: 14px; flex-shrink: 0; }

  /* ── FORM SECTION ── */
  .form-section { padding: 28px; }

  .field-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
    margin-bottom: 18px;
  }
  @media (max-width: 600px) { .field-grid { grid-template-columns: 1fr; } }

  .field-group { display: flex; flex-direction: column; gap: 6px; }
  .field-label {
    font-size: 12px;
    font-weight: 800;
    color: var(--text-3);
    text-transform: uppercase;
    letter-spacing: .6px;
  }
  .field-input {
    width: 100%;
    padding: 11px 15px;
    border: 1.5px solid var(--border);
    border-radius: 11px;
    font-size: 14px;
    font-family: 'Bricolage Grotesque', var(--font);
    font-weight: 600;
    color: var(--text);
    background: var(--surface);
    outline: none;
    transition: border-color .15s, box-shadow .15s;
  }
  .field-input:focus {
    border-color: var(--text);
    box-shadow: 0 0 0 3px rgba(26,26,26,.06);
  }
  .field-error { font-size: 12px; color: var(--danger); font-weight: 600; margin-top: 2px; }

  /* ── PASSWORD FIELDS ── */
  .pwd-wrap { position: relative; }
  .pwd-wrap .field-input { padding-right: 44px; }
  .pwd-toggle {
    position: absolute;
    right: 13px; top: 50%;
    transform: translateY(-50%);
    background: none; border: none; cursor: pointer;
    color: var(--text-3);
    padding: 4px;
    transition: color .15s;
  }
  .pwd-toggle:hover { color: var(--text); }
  .pwd-toggle svg { width: 16px; height: 16px; display: block; }

  /* ── STRENGTH BAR ── */
  .strength-wrap { margin-bottom: 22px; }
  .strength-track {
    height: 5px;
    background: var(--border);
    border-radius: 5px;
    overflow: hidden;
    margin-bottom: 5px;
  }
  #strength-bar {
    height: 100%;
    width: 0;
    border-radius: 5px;
    transition: width .35s cubic-bezier(.4,0,.2,1), background .35s;
  }
  #strength-label { font-size: 11px; font-weight: 700; color: var(--text-3); }

  /* ── FORM FOOTER ── */
  .form-footer {
    display: flex;
    justify-content: flex-end;
    padding-top: 8px;
    border-top: 1px solid var(--border);
    margin-top: 4px;
  }
  .save-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 22px;
    border-radius: 11px;
    border: none;
    background: var(--text);
    color: #fff;
    font-size: 14px;
    font-weight: 800;
    font-family: 'Bricolage Grotesque', var(--font);
    cursor: pointer;
    transition: background .15s, transform .12s;
    letter-spacing: -.1px;
  }
  .save-btn:hover { background: #333; transform: translateY(-1px); }
  .save-btn:active { transform: translateY(0); }
  .save-btn svg { width: 15px; height: 15px; flex-shrink: 0; }

  /* ── ALERTS ── */
  .profile-alert {
    padding: 13px 18px;
    border-radius: 11px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 22px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .profile-alert-success {
    background: #f0fdf4;
    color: #15803d;
    border: 1.5px solid #bbf7d0;
  }
  .profile-alert-error {
    background: #fff1f2;
    color: #be123c;
    border: 1.5px solid #fecdd3;
  }

  /* ── DIVIDER LABEL ── */
  .section-divider {
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .8px;
    color: var(--text-3);
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 1px solid var(--border);
  }
</style>
@endpush

@section('content')
<div class="profile-wrap">

  {{-- Header --}}
  <div class="profile-header">
    <h1>Hồ sơ cá nhân</h1>
    <p>Cập nhật thông tin tài khoản và mật khẩu của bạn</p>
  </div>

  {{-- Tabs --}}
  @php $tab = session('tab', 'info'); @endphp
  <div class="profile-tabs">
    <button class="profile-tab-btn {{ $tab === 'info' ? 'active' : '' }}" id="tab-info" onclick="switchTab('info')">
      Thông tin
    </button>
    <button class="profile-tab-btn {{ $tab === 'password' ? 'active' : '' }}" id="tab-password" onclick="switchTab('password')">
      Đổi mật khẩu
    </button>
  </div>

  {{-- Alerts --}}
  @if(session('success'))
    <div class="profile-alert profile-alert-success flash">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
      {{ session('success') }}
    </div>
  @endif
  @if($errors->any() && !$errors->has('current_password'))
    <div class="profile-alert profile-alert-error flash">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      {{ $errors->first() }}
    </div>
  @endif

  {{-- ── TAB: THÔNG TIN ── --}}
  <div id="panel-info" style="{{ $tab === 'password' ? 'display:none' : '' }}">
    <div class="profile-card">

      {{-- Avatar section --}}
      <div class="avatar-section">
        <div class="avatar-ring">
          <div id="avatar-preview">
            @if($user->avatar)
              <img src="/images/{{ $user->avatar }}" alt="Avatar">
            @else
              {{ strtoupper(substr($user->name, 0, 2)) }}
            @endif
          </div>
          <label for="avatar-file" class="avatar-upload-btn" title="Đổi ảnh">
            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
          </label>
        </div>

        <div class="avatar-info">
          <div class="user-fullname">{{ $user->name }}</div>
          <div class="user-meta">
            <span class="role-badge {{ $user->isAdmin() ? 'role-admin' : ($user->isManager() ? 'role-manager' : 'role-staff') }}">
              @if($user->isAdmin()) Admin
              @elseif($user->isManager()) Manager
              @else Nhân viên
              @endif
            </span>
            <span>·</span>
            <span>{{ $user->email }}</span>
          </div>
          <label for="avatar-file" class="upload-label">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            Tải ảnh lên
          </label>
        </div>
      </div>

      {{-- Form --}}
      <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" id="form-info">
        @csrf @method('PATCH')
        <input type="file" name="avatar" id="avatar-file" accept="image/*" style="display:none" onchange="previewAvatar(this)">

        <div class="form-section">
          <div class="section-divider">Thông tin cơ bản</div>

          <div class="field-grid">
            <div class="field-group">
              <label class="field-label">Họ và tên</label>
              <input type="text" name="name" class="field-input" value="{{ old('name', $user->name) }}" required>
              @error('name')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div class="field-group">
              <label class="field-label">Tên đăng nhập</label>
              <input type="text" name="username" class="field-input" value="{{ old('username', $user->username) }}" required>
              @error('username')<div class="field-error">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="field-group" style="margin-bottom:24px;">
            <label class="field-label">Email</label>
            <input type="email" name="email" class="field-input" value="{{ old('email', $user->email) }}" required>
            @error('email')<div class="field-error">{{ $message }}</div>@enderror
          </div>

          <div class="form-footer">
            <button type="submit" class="save-btn">
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
              Lưu thay đổi
            </button>
          </div>
        </div>
      </form>

    </div>
  </div>

  {{-- ── TAB: ĐỔI MẬT KHẨU ── --}}
  <div id="panel-password" style="{{ $tab !== 'password' ? 'display:none' : '' }}">
    <div class="profile-card">

      @if($errors->has('current_password'))
        <div class="profile-alert profile-alert-error" style="margin:24px 28px 0;">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          {{ $errors->first('current_password') }}
        </div>
      @endif

      <form method="POST" action="{{ route('admin.profile.password') }}">
        @csrf @method('PATCH')

        <div class="form-section">
          <div class="section-divider">Cập nhật mật khẩu</div>

          <div class="field-group" style="margin-bottom:18px;">
            <label class="field-label">Mật khẩu hiện tại</label>
            <div class="pwd-wrap">
              <input type="password" name="current_password" id="cp" class="field-input" required>
              <button type="button" class="pwd-toggle" onclick="togglePwd('cp','eye-cp')">
                <svg id="eye-cp" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
          </div>

          <div class="field-grid" style="margin-bottom:0;">
            <div class="field-group">
              <label class="field-label">Mật khẩu mới</label>
              <div class="pwd-wrap">
                <input type="password" name="password" id="np" class="field-input" required minlength="6">
                <button type="button" class="pwd-toggle" onclick="togglePwd('np','eye-np')">
                  <svg id="eye-np" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
              </div>
              @error('password')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div class="field-group">
              <label class="field-label">Xác nhận mật khẩu mới</label>
              <div class="pwd-wrap">
                <input type="password" name="password_confirmation" id="pc" class="field-input" required>
                <button type="button" class="pwd-toggle" onclick="togglePwd('pc','eye-pc')">
                  <svg id="eye-pc" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
              </div>
            </div>
          </div>

          {{-- Strength --}}
          <div class="strength-wrap" style="margin-top:16px;">
            <div class="strength-track">
              <div id="strength-bar"></div>
            </div>
            <div id="strength-label"></div>
          </div>

          <div class="form-footer">
            <button type="submit" class="save-btn">
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
              Đổi mật khẩu
            </button>
          </div>
        </div>

      </form>
    </div>
  </div>

</div>

<script>
function switchTab(name) {
  ['info','password'].forEach(function(t) {
    document.getElementById('panel-' + t).style.display = t === name ? '' : 'none';
    document.getElementById('tab-' + t).classList.toggle('active', t === name);
  });
}

function previewAvatar(input) {
  if (!input.files || !input.files[0]) return;
  var reader = new FileReader();
  reader.onload = function(e) {
    var wrap = document.getElementById('avatar-preview');
    wrap.innerHTML = '<img src="' + e.target.result + '" alt="Avatar" style="width:100%;height:100%;object-fit:cover;">';
  };
  reader.readAsDataURL(input.files[0]);
}

function togglePwd(inputId, iconId) {
  var inp  = document.getElementById(inputId);
  var icon = document.getElementById(iconId);
  if (inp.type === 'password') {
    inp.type = 'text';
    icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
  } else {
    inp.type = 'password';
    icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
  }
}

document.getElementById('np').addEventListener('input', function() {
  var val = this.value;
  var score = 0;
  if (val.length >= 6)  score++;
  if (val.length >= 10) score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;
  var levels = [
    { w:'0%',   c:'transparent', t:'' },
    { w:'20%',  c:'#ef4444', t:'Rất yếu' },
    { w:'40%',  c:'#f97316', t:'Yếu' },
    { w:'65%',  c:'#eab308', t:'Trung bình' },
    { w:'85%',  c:'#22c55e', t:'Mạnh' },
    { w:'100%', c:'#16a34a', t:'Rất mạnh' },
  ];
  var lv = val.length === 0 ? 0 : Math.max(1, Math.min(score, 5));
  var bar = document.getElementById('strength-bar');
  var lbl = document.getElementById('strength-label');
  bar.style.width = levels[lv].w;
  bar.style.background = levels[lv].c;
  lbl.textContent = levels[lv].t;
  lbl.style.color = levels[lv].c;
});
</script>
@endsection