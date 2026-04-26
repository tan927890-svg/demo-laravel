<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Đăng nhập – AutoX</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --cream: #f5f0e8;
      --brown: #dfa674;
      --brown-dark: #c4864e;
      --navy: #002D74;
      --navy-light: #1a4a9e;
      --white: #ffffff;
      --gray: #6b7280;
      --gray-light: #e5e7eb;
      --error: #dc2626;
    }

    html, body { margin: 0; padding: 0; }

    body {
      font-family: 'DM Sans', sans-serif;
      min-height: 100vh;
      background-image: url('{{ asset('images/CTN/Mercedes-Maybach-S-Class-1-CTN.png') }}');
      background-size: cover;
      background-position: center center;
      background-repeat: no-repeat;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      position: relative;
    }

    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background: linear-gradient(
        135deg,
        rgba(0, 20, 60, 0.55) 0%,
        rgba(0, 45, 116, 0.40) 50%,
        rgba(0, 10, 30, 0.60) 100%
      );
      z-index: 0;
      pointer-events: none;
    }

    body::after {
      content: '';
      position: fixed;
      width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(223,166,116,0.18) 0%, transparent 70%);
      top: -80px; right: -80px;
      border-radius: 50%;
      pointer-events: none;
      z-index: 0;
    }

    .card {
      background: var(--white);
      border-radius: 24px;
      display: flex;
      max-width: 860px;
      width: 100%;
      overflow: hidden;
      box-shadow:
        0 32px 80px rgba(0,0,0,0.40),
        0 8px 24px rgba(0,0,0,0.20),
        0 0 0 1px rgba(255,255,255,0.08);
      animation: fadeUp 0.5s cubic-bezier(.22,.68,0,1.2) both;
      position: relative;
      z-index: 1;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(28px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .left {
      flex: 1;
      padding: 44px 44px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 28px;
    }

    .brand-icon {
      width: 56px; height: 56px;
      border-radius: 50%;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .brand-icon img { width: 100%; height: 100%; object-fit: cover; }

    .brand-name {
      font-family: 'Playfair Display', serif;
      font-size: 20px;
      font-weight: 700;
      color: var(--navy);
      letter-spacing: -0.02em;
    }

    h1 {
      font-family: 'Playfair Display', serif;
      font-size: 28px;
      font-weight: 700;
      color: var(--navy);
      line-height: 1.2;
      margin-bottom: 6px;
    }
    .subtitle {
      font-size: 13.5px;
      color: var(--gray);
      margin-bottom: 28px;
      font-weight: 400;
    }

    .alert-error {
      background: #fef2f2;
      border: 1px solid #fecaca;
      border-radius: 10px;
      padding: 11px 14px;
      margin-bottom: 16px;
      font-size: 13px;
      color: var(--error);
    }
    .alert-success {
      background: #f0fdf4;
      border: 1px solid #bbf7d0;
      border-radius: 10px;
      padding: 11px 14px;
      margin-bottom: 16px;
      font-size: 13px;
      color: #15803d;
    }

    .form-group { margin-bottom: 16px; }

    label {
      display: block;
      font-size: 11px;
      font-weight: 600;
      color: var(--navy);
      letter-spacing: 0.04em;
      text-transform: uppercase;
      margin-bottom: 6px;
    }

    .input-wrap { position: relative; }

    input[type="email"],
    input[type="password"],
    input[type="text"] {
      width: 100%;
      border: 1.5px solid var(--gray-light);
      border-radius: 12px;
      padding: 11px 16px;
      font-size: 14px;
      font-family: 'DM Sans', sans-serif;
      color: #111827;
      background: #fafafa;
      outline: none;
      transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
    }
    input:focus {
      border-color: var(--brown);
      background: var(--white);
      box-shadow: 0 0 0 3px rgba(223,166,116,0.15);
    }
    input.is-invalid { border-color: var(--error); }

    /* Password field has extra right padding for the toggle button */
    .input-wrap input[type="password"],
    .input-wrap input[type="text"] {
      padding-right: 44px;
    }

    .field-hint {
      font-size: 11px;
      color: #9ca3af;
      margin-top: 4px;
      padding-left: 2px;
    }

    .toggle-pw {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: var(--gray);
      display: flex;
      align-items: center;
      transition: color 0.15s;
      background: none;
      border: none;
      padding: 0;
    }
    .toggle-pw:hover { color: var(--navy); }

    .row-extras {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 22px;
    }
    .remember {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      color: var(--gray);
      cursor: pointer;
    }
    .remember input[type="checkbox"] {
      width: 16px; height: 16px;
      accent-color: var(--navy);
      cursor: pointer;
    }
    .forgot {
      font-size: 13px;
      color: var(--brown-dark);
      text-decoration: none;
      font-weight: 500;
      transition: color 0.15s;
    }
    .forgot:hover { color: var(--navy); }

    .btn-login {
      width: 100%;
      padding: 13px;
      background: var(--navy);
      color: var(--white);
      border: none;
      border-radius: 12px;
      font-size: 15px;
      font-weight: 600;
      font-family: 'DM Sans', sans-serif;
      cursor: pointer;
      transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
      letter-spacing: 0.02em;
      margin-bottom: 22px;
    }
    .btn-login:hover {
      background: var(--navy-light);
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(0,45,116,0.22);
    }
    .btn-login:active { transform: translateY(0); }

    .register-row {
      font-size: 13.5px;
      color: var(--gray);
      text-align: center;
    }
    .register-row a {
      color: var(--navy);
      font-weight: 600;
      text-decoration: none;
      transition: color 0.15s;
    }
    .register-row a:hover { color: var(--brown-dark); }

    .right {
      width: 42%;
      position: relative;
      overflow: hidden;
      flex-shrink: 0;
      background: linear-gradient(135deg, #002D74 0%, #1a4a9e 60%, #dfa674 100%);
    }
    .right img { display: none; }
    .right-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(
        160deg,
        rgba(0,45,116,0.55) 0%,
        rgba(0,45,116,0.25) 50%,
        rgba(223,166,116,0.35) 100%
      );
    }
    .right-badge {
      position: absolute;
      bottom: 36px;
      left: 28px; right: 28px;
      background: rgba(255,255,255,0.15);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255,255,255,0.25);
      border-radius: 16px;
      padding: 18px 20px;
      color: var(--white);
    }
    .right-badge p {
      font-family: 'Playfair Display', serif;
      font-size: 16px;
      font-weight: 600;
      line-height: 1.4;
      margin-bottom: 6px;
    }
    .right-badge span { font-size: 12px; opacity: 0.75; font-weight: 400; }

    @media (max-width: 640px) {
      .right { display: none; }
      .left { padding: 32px 24px; }
    }
  </style>
</head>
<body>

<div class="card">

  <!-- LEFT -->
  <div class="left">
    <div class="brand">
      <div class="brand-icon">
        <img src="{{ asset('images/logo.png') }}" alt="AutoX Logo">
      </div>
      <span class="brand-name">AUTO X</span>
    </div>

    <h1>Chào mừng<br>trở lại</h1>
    <p class="subtitle">Đăng nhập bằng tên đăng nhập hoặc email của bạn.</p>

    @if ($errors->any())
      <div class="alert-error">{{ $errors->first() }}</div>
    @endif
    @if (session('status'))
      <div class="alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
      @csrf

      {{-- Single identity field: username OR email --}}
      <div class="form-group">
        <label for="login">Tên đăng nhập hoặc Email</label>
        <input
          type="text"
          id="login"
          name="login"
          value="{{ old('login') }}"
          placeholder="nguyen.vana hoặc you@example.com"
          autocomplete="username"
          class="{{ $errors->has('login') ? 'is-invalid' : '' }}"
          autofocus
          required
        >
        <p class="field-hint">Nhập tên đăng nhập hoặc địa chỉ email đã đăng ký</p>
      </div>

      <div class="form-group">
        <label for="password">Mật khẩu</label>
        <div class="input-wrap">
          <input
            type="password"
            id="password"
            name="password"
            placeholder="••••••••"
            autocomplete="current-password"
            class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
            required
          >
          <button type="button" class="toggle-pw" onclick="togglePw()" title="Hiện/ẩn mật khẩu">
            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
              <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
              <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
            </svg>
          </button>
        </div>
      </div>

      <div class="row-extras">
        <label class="remember">
          <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
          Ghi nhớ đăng nhập
        </label>
        <a href="{{ route('password.request') }}" class="forgot">Quên mật khẩu?</a>
      </div>

      <button type="submit" class="btn-login">Đăng nhập</button>
    </form>

    <div class="register-row">
      Chưa có tài khoản? <a href="#">Đăng ký ngay</a>
    </div>
  </div>

  <!-- RIGHT -->
  <div class="right">
    <img
      src="{{ asset('images/CTN/Mercedes-Maybach-S-Class-1-CTN.png') }}"
      alt="AutoX"
      onerror="this.style.display='none'"
    >
    <div class="right-overlay"></div>
    <div class="right-badge">
      <p>"Trải nghiệm mua xe<br>đơn giản & minh bạch"</p>
      <span>Hơn 500+ khách hàng tin tưởng AutoX</span>
    </div>
  </div>

</div>

<script>
(function() {
  var btn  = document.querySelector('.btn-login');
  var form = document.querySelector('form');

  function unlockAudio() {
    try {
      var ctx = new (window.AudioContext || window.webkitAudioContext)();
      var buf = ctx.createBuffer(1, 1, 22050);
      var src = ctx.createBufferSource();
      src.buffer = buf;
      src.connect(ctx.destination);
      src.start(0);
      sessionStorage.setItem('audio_unlocked', '1');
    } catch(e) {}
  }

  if (btn) {
    btn.addEventListener('mousedown',  unlockAudio);
    btn.addEventListener('touchstart', unlockAudio, { passive: true });
  }
  if (form) {
    form.addEventListener('submit', unlockAudio);
  }
})();

function togglePw() {
  var input = document.getElementById('password');
  var icon  = document.getElementById('eyeIcon');
  if (input.type === 'password') {
    input.type = 'text';
    icon.innerHTML = '<path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>';
  } else {
    input.type = 'password';
    icon.innerHTML = '<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>';
  }
}
</script>

</body>
</html>