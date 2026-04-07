@endsection
{{-- ============================================================
     resources/views/components/login-modal.blade.php
     
     CÁCH DÙNG: Include vào bất kỳ Blade layout nào:
       @include('components.login-modal')
     hoặc dùng Blade component:
       <x-login-modal />
     
     YÊU CẦU ROUTE (routes/web.php):
       Route::post('/login',    [AuthController::class, 'login'])->name('login');
       Route::post('/register', [AuthController::class, 'register'])->name('register');
       Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');
       Route::get('/password/reset', ...)->name('password.request');
============================================================ --}}

@guest
{{-- ════════════════════════════════════════════════════
     LOGIN / REGISTER MODAL COMPONENT
     Chỉ render khi user chưa đăng nhập (@guest)
════════════════════════════════════════════════════ --}}
<div class="ccd-overlay" id="ccdOverlay" role="dialog" aria-modal="true" aria-label="Đăng nhập / Đăng ký">
  <div class="ccd-modal">

    <button class="ccd-close" onclick="ccdClose()" aria-label="Đóng">✕</button>

    {{-- TABS --}}
    <div class="ccd-head">
      <div class="ccd-tabs">
        <button class="ccd-tab on" id="ccdTabLogin" onclick="ccdSwitch('login')">
          <span class="tab-num">01</span>ĐĂNG NHẬP
        </button>
        <button class="ccd-tab" id="ccdTabReg" onclick="ccdSwitch('reg')">
          <span class="tab-num">02</span>ĐĂNG KÝ
        </button>
      </div>
    </div>

    <div class="ccd-body">

      {{-- ── Thông báo lỗi từ Laravel session ── --}}
      @if($errors->any() && in_array(old('_form'), ['login', 'register']))
        <div class="ccd-alert-err">
          <strong>LỖI</strong>
          {{ $errors->first() }}
        </div>
      @endif

      {{-- ── Success banner (JS-only, cho UX preview) ── --}}
      <div class="ccd-success" id="ccdSuccess">
        <strong>THÀNH CÔNG</strong>
        <span id="ccdSuccessText"></span>
      </div>

      {{-- ══ FORM ĐĂNG NHẬP ══ --}}
      <div id="ccdLoginForm">
        <form method="POST" action="{{ route('login') }}" id="formLogin" novalidate>
          @csrf
          {{-- Dùng để phân biệt form khi Laravel redirect về --}}
          <input type="hidden" name="_form" value="login">

          <div class="ccd-form-group">
            <label class="ccd-label" for="ccdLEmail">Email</label>
            <input class="ccd-input {{ $errors->has('email') && old('_form') === 'login' ? 'ccd-invalid' : '' }}"
                   type="email" id="ccdLEmail" name="email"
                   value="{{ old('email') }}"
                   placeholder="email@example.com"
                   autocomplete="email">
            <div class="ccd-err" id="ccdLEmailErr">Vui lòng nhập email hợp lệ.</div>
          </div>

          <div class="ccd-form-group">
            <label class="ccd-label" for="ccdLPass">Mật Khẩu</label>
            <input class="ccd-input" type="password" id="ccdLPass" name="password"
                   placeholder="••••••••" autocomplete="current-password">
            <div class="ccd-err" id="ccdLPassErr">Vui lòng nhập mật khẩu.</div>
          </div>

          <div class="ccd-forgot">
            <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
          </div>

          {{-- remember me --}}
          <div class="ccd-check-row" style="margin-bottom:12px">
            <input type="checkbox" id="ccdRemember" name="remember">
            <label for="ccdRemember">Ghi nhớ đăng nhập</label>
          </div>

          <button type="submit" class="ccd-submit" onclick="return ccdValidateLogin()">
            ĐĂNG NHẬP
          </button>
        </form>

        <div class="ccd-hint">
          Chưa có tài khoản? <a onclick="ccdSwitch('reg')">Đăng ký ngay</a>
        </div>
        <hr class="ccd-divider">
        <div class="ccd-alt">
          Hoặc <a onclick="ccdClose()">tiếp tục không cần tài khoản</a>
        </div>
      </div>

      {{-- ══ FORM ĐĂNG KÝ ══ --}}
      <div id="ccdRegForm" style="display:none">
        <form method="POST" action="{{ route('register') }}" id="formRegister" novalidate>
          @csrf
          <input type="hidden" name="_form" value="register">

          <div class="ccd-row">
            <div class="ccd-form-group">
              <label class="ccd-label" for="ccdRHo">Họ</label>
              <input class="ccd-input" type="text" id="ccdRHo"
                     name="ho" value="{{ old('ho') }}" placeholder="Nguyễn">
            </div>
            <div class="ccd-form-group">
              <label class="ccd-label" for="ccdRTen">Tên</label>
              <input class="ccd-input" type="text" id="ccdRTen"
                     name="ten" value="{{ old('ten') }}" placeholder="Văn An">
            </div>
          </div>

          <div class="ccd-form-group">
            <label class="ccd-label" for="ccdREmail">Email</label>
            <input class="ccd-input {{ $errors->has('email') && old('_form') === 'register' ? 'ccd-invalid' : '' }}"
                   type="email" id="ccdREmail" name="email"
                   value="{{ old('email') }}"
                   placeholder="email@example.com">
            <div class="ccd-err" id="ccdREmailErr">Vui lòng nhập email hợp lệ.</div>
          </div>

          <div class="ccd-form-group">
            <label class="ccd-label" for="ccdRPhone">Số Điện Thoại</label>
            <input class="ccd-input" type="tel" id="ccdRPhone"
                   name="phone" value="{{ old('phone') }}" placeholder="0912 345 678">
          </div>

          <div class="ccd-form-group">
            <label class="ccd-label" for="ccdRPass">Mật Khẩu</label>
            <input class="ccd-input" type="password" id="ccdRPass"
                   name="password" placeholder="Tối thiểu 8 ký tự" autocomplete="new-password">
            <div class="ccd-err" id="ccdRPassErr">Mật khẩu cần ít nhất 8 ký tự.</div>
          </div>

          <div class="ccd-form-group">
            <label class="ccd-label" for="ccdRPassConfirm">Xác Nhận Mật Khẩu</label>
            <input class="ccd-input" type="password" id="ccdRPassConfirm"
                   name="password_confirmation"
                   placeholder="Nhập lại mật khẩu" autocomplete="new-password">
          </div>

          <div class="ccd-check-row">
            <input type="checkbox" id="ccdAgree" name="agree" value="1">
            <label for="ccdAgree">
              Tôi đồng ý với
              <a href="{{ url('/terms') }}">Điều khoản sử dụng</a>
              và
              <a href="{{ url('/privacy') }}">Chính sách bảo mật</a>
              của AUTO X
            </label>
          </div>

          <button type="submit" class="ccd-submit" onclick="return ccdValidateRegister()">
            TẠO TÀI KHOẢN
          </button>
        </form>

        <div class="ccd-hint">
          Đã có tài khoản? <a onclick="ccdSwitch('login')">Đăng nhập</a>
        </div>
      </div>

    </div>{{-- /ccd-body --}}
  </div>{{-- /ccd-modal --}}
</div>
@endguest

{{-- ════════════════════════════════════════════════════
     STYLES — Dán vào file CSS chính hoặc để trong
     @push('styles') của layout cha
════════════════════════════════════════════════════ --}}
@push('styles')
<style>
/* ── LOGIN MODAL ─────────────────────────────────────── */
.ccd-overlay{
  display:none;position:fixed;inset:0;
  background:rgba(0,0,0,.9);z-index:9999;
  align-items:center;justify-content:center;
  backdrop-filter:blur(8px);
}
.ccd-overlay.open{display:flex}

.ccd-modal{
  background:#141414;width:100%;max-width:460px;
  position:relative;border-top:3px solid #E8192C;
  animation:ccdSlideUp .3s ease;
}
@keyframes ccdSlideUp{from{transform:translateY(20px);opacity:0}to{transform:none;opacity:1}}

/* Close */
.ccd-close{
  position:absolute;top:14px;right:18px;
  background:none;border:none;color:#444;
  font-size:20px;cursor:pointer;line-height:1;
  transition:color .2s;
}
.ccd-close:hover{color:#f0ebe4}

/* Tabs */
.ccd-head{padding:26px 36px 0;border-bottom:1px solid #222}
.ccd-tabs{display:flex;gap:0}
.ccd-tab{
  background:none;border:none;
  color:#555;font-family:'Barlow',sans-serif;
  font-size:10px;font-weight:700;letter-spacing:3px;
  text-transform:uppercase;cursor:pointer;
  padding:0 0 16px;margin-right:28px;
  border-bottom:2px solid transparent;
  transition:all .2s;
}
.ccd-tab .tab-num{
  display:block;font-family:'Bebas Neue';
  font-size:20px;line-height:1;margin-bottom:2px;
}
.ccd-tab.on{color:#f0ebe4;border-bottom-color:#E8192C}

/* Body */
.ccd-body{padding:32px 36px}

/* Error alert (server-side) */
.ccd-alert-err{
  background:rgba(232,25,44,.1);
  border:1px solid rgba(232,25,44,.3);
  padding:12px 16px;margin-bottom:16px;
  font-size:13px;color:#f0ebe4;line-height:1.5;
}
.ccd-alert-err strong{
  display:block;font-size:9px;letter-spacing:2.5px;
  text-transform:uppercase;color:#E8192C;margin-bottom:4px;
}

/* Success (JS preview) */
.ccd-success{
  display:none;background:rgba(232,25,44,.07);
  border:1px solid rgba(232,25,44,.25);
  padding:16px 20px;margin-bottom:20px;
  font-size:13px;color:#ccc;line-height:1.6;
}
.ccd-success strong{
  display:block;font-size:9px;letter-spacing:2.5px;
  text-transform:uppercase;color:#E8192C;margin-bottom:5px;
}

/* Forms */
.ccd-form-group{margin-bottom:18px}
.ccd-label{
  display:block;font-size:10px;font-weight:700;
  letter-spacing:2px;text-transform:uppercase;
  color:#555;margin-bottom:7px;
}
.ccd-input{
  width:100%;background:#0d0d0d;
  border:1px solid #2a2a2a;color:#f0ebe4;
  padding:13px 16px;font-size:13px;
  font-family:'Barlow',sans-serif;outline:none;
  transition:border-color .2s;
}
.ccd-input:focus{border-color:#E8192C}
.ccd-input::placeholder{color:#333}
.ccd-input.ccd-invalid{border-color:#E8192C}
.ccd-err{
  font-size:11px;color:#E8192C;
  margin-top:5px;display:none;
}
.ccd-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.ccd-check-row{display:flex;align-items:flex-start;gap:10px;margin-bottom:20px}
.ccd-check-row input{margin-top:3px;accent-color:#E8192C}
.ccd-check-row label{font-size:12px;color:#555;cursor:pointer;line-height:1.5}
.ccd-check-row a{color:#E8192C;text-decoration:none}
.ccd-forgot{display:flex;justify-content:flex-end;margin:-4px 0 16px}
.ccd-forgot a{font-size:11px;color:#E8192C;text-decoration:none}
.ccd-submit{
  width:100%;background:#E8192C;color:#f0ebe4;
  border:none;padding:15px;
  font-size:10px;font-weight:700;letter-spacing:3px;
  text-transform:uppercase;cursor:pointer;
  transition:background .2s;margin-top:4px;
  font-family:'Barlow',sans-serif;
}
.ccd-submit:hover{background:#B01020}
.ccd-hint{text-align:center;font-size:11px;color:#444;margin-top:14px}
.ccd-hint a{color:#E8192C;cursor:pointer;text-decoration:none}
.ccd-divider{border:none;border-top:1px solid #222;margin:20px 0}
.ccd-alt{text-align:center;font-size:11px;color:#333}
.ccd-alt a{color:#E8192C;cursor:pointer;text-decoration:none}
/* ─────────────────────────────────────────────────── */
</style>
@endpush

{{-- ════════════════════════════════════════════════════
     SCRIPTS — Dán vào @push('scripts') của layout cha
════════════════════════════════════════════════════ --}}
@push('scripts')
<script>
// ─── Mở modal ───────────────────────────────────────────
function ccdOpenLogin(defaultTab) {
  ccdSwitch(defaultTab || 'login');
  document.getElementById('ccdOverlay').classList.add('open');
}

// ─── Đóng modal ─────────────────────────────────────────
function ccdClose() {
  document.getElementById('ccdOverlay').classList.remove('open');
}

// Đóng khi click backdrop
var _ccdEl = document.getElementById('ccdOverlay');
if (_ccdEl) {
  _ccdEl.addEventListener('click', function(e) {
    if (e.target === this) ccdClose();
  });
}

// Đóng bằng ESC
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') ccdClose();
});

// ─── Chuyển tab ─────────────────────────────────────────
function ccdSwitch(tab) {
  var isLogin = tab === 'login';
  document.getElementById('ccdTabLogin').classList.toggle('on',  isLogin);
  document.getElementById('ccdTabReg').classList.toggle('on',   !isLogin);
  document.getElementById('ccdLoginForm').style.display = isLogin ? 'block' : 'none';
  document.getElementById('ccdRegForm').style.display   = isLogin ? 'none'  : 'block';
  document.getElementById('ccdSuccess').style.display   = 'none';
  _ccdClearErrors();
}

function _ccdClearErrors() {
  document.querySelectorAll('.ccd-err').forEach(function(e) { e.style.display = 'none'; });
}

function _ccdValidEmail(v) {
  return v && /\S+@\S+\.\S+/.test(v);
}

// ─── Validate trước khi submit (client-side) ─────────────
function ccdValidateLogin() {
  _ccdClearErrors();
  var email = document.getElementById('ccdLEmail').value.trim();
  var pass  = document.getElementById('ccdLPass').value;
  var ok = true;
  if (!_ccdValidEmail(email)) {
    document.getElementById('ccdLEmailErr').style.display = 'block'; ok = false;
  }
  if (!pass) {
    document.getElementById('ccdLPassErr').style.display = 'block'; ok = false;
  }
  return ok; // false ngăn form submit
}

function ccdValidateRegister() {
  _ccdClearErrors();
  var email = document.getElementById('ccdREmail').value.trim();
  var pass  = document.getElementById('ccdRPass').value;
  var ok = true;
  if (!_ccdValidEmail(email)) {
    document.getElementById('ccdREmailErr').style.display = 'block'; ok = false;
  }
  if (pass.length < 8) {
    document.getElementById('ccdRPassErr').style.display = 'block'; ok = false;
  }
  return ok;
}

// ─── Tự mở modal nếu Laravel redirect về với lỗi ─────────
@if($errors->any() && in_array(old('_form'), ['login', 'register']))
  document.addEventListener('DOMContentLoaded', function() {
    ccdOpenLogin('{{ old("_form") }}');
  });
@endif
</script>
@endpush
