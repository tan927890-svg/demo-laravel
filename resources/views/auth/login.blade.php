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

    body {
      font-family: 'DM Sans', sans-serif;
      min-height: 100vh;
      background: var(--cream);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      position: relative;
      overflow: hidden;
    }

    /* background blobs */
    body::before {
      content: '';
      position: fixed;
      width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(223,166,116,0.25) 0%, transparent 70%);
      top: -100px; right: -100px;
      border-radius: 50%;
      pointer-events: none;
    }
    body::after {
      content: '';
      position: fixed;
      width: 400px; height: 400px;
      background: radial-gradient(circle, rgba(0,45,116,0.08) 0%, transparent 70%);
      bottom: -80px; left: -80px;
      border-radius: 50%;
      pointer-events: none;
    }

    .card {
      background: var(--white);
      border-radius: 24px;
      display: flex;
      max-width: 860px;
      width: 100%;
      overflow: hidden;
      box-shadow: 0 24px 60px rgba(0,0,0,0.12), 0 4px 16px rgba(0,0,0,0.06);
      animation: fadeUp 0.5s cubic-bezier(.22,.68,0,1.2) both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(28px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* ── LEFT PANEL ── */
    .left {
      flex: 1;
      padding: 48px 44px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 36px;
    }
    .brand-icon {
      width: 36px; height: 36px;
      background: var(--navy);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 18px;
    }
    .brand-name {
      font-family: 'Playfair Display', serif;
      font-size: 20px;
      font-weight: 700;
      color: var(--navy);
      letter-spacing: -0.02em;
    }

    h1 {
      font-family: 'Playfair Display', serif;
      font-size: 30px;
      font-weight: 700;
      color: var(--navy);
      line-height: 1.2;
      margin-bottom: 8px;
    }
    .subtitle {
      font-size: 14px;
      color: var(--gray);
      margin-bottom: 32px;
      font-weight: 400;
    }

    /* ── ALERTS ── */
    .alert-error {
      background: #fef2f2;
      border: 1px solid #fecaca;
      border-radius: 10px;
      padding: 12px 14px;
      margin-bottom: 20px;
      font-size: 13px;
      color: var(--error);
    }
    .alert-success {
      background: #f0fdf4;
      border: 1px solid #bbf7d0;
      border-radius: 10px;
      padding: 12px 14px;
      margin-bottom: 20px;
      font-size: 13px;
      color: #15803d;
    }

    /* ── FORM ── */
    .form-group { margin-bottom: 18px; }

    label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--navy);
      letter-spacing: 0.04em;
      text-transform: uppercase;
      margin-bottom: 7px;
    }

    .input-wrap {
      position: relative;
    }

    input[type="email"],
    input[type="password"],
    input[type="text"] {
      width: 100%;
      border: 1.5px solid var(--gray-light);
      border-radius: 12px;
      padding: 12px 16px;
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

    /* remember + forgot */
    .row-extras {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 26px;
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
      border-radius: 4px;
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

    /* ── BUTTONS ── */
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
      margin-bottom: 14px;
    }
    .btn-login:hover {
      background: var(--navy-light);
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(0,45,116,0.22);
    }
    .btn-login:active { transform: translateY(0); }

    .divider {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 14px;
      color: var(--gray);
      font-size: 12px;
    }
    .divider::before, .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--gray-light);
    }

    .btn-google {
      width: 100%;
      padding: 12px;
      background: var(--white);
      color: #374151;
      border: 1.5px solid var(--gray-light);
      border-radius: 12px;
      font-size: 14px;
      font-weight: 500;
      font-family: 'DM Sans', sans-serif;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      transition: all 0.2s;
      margin-bottom: 28px;
    }
    .btn-google:hover {
      background: #f9fafb;
      border-color: #d1d5db;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

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

    /* ── RIGHT PANEL ── */
    .right {
      width: 42%;
      position: relative;
      overflow: hidden;
      flex-shrink: 0;
    }
    .right img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }
    .right-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(0,45,116,0.45) 0%, rgba(223,166,116,0.2) 100%);
    }
    .right-badge {
      position: absolute;
      bottom: 36px;
      left: 28px;
      right: 28px;
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
    .right-badge span {
      font-size: 12px;
      opacity: 0.75;
      font-weight: 400;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 640px) {
      .right { display: none; }
      .left { padding: 36px 28px; }
    }
  </style>
</head>
<body>

<div class="card">

  <!-- LEFT -->
  <div class="left">
    <div class="brand">
      <div class="brand-icon">🚗</div>
      <span class="brand-name">AutoX</span>
    </div>

    <h1>Chào mừng<br>trở lại</h1>
    <p class="subtitle">Đăng nhập để tiếp tục quản lý hệ thống xe của bạn.</p>

    {{-- Error / Success messages --}}
    @if ($errors->any())
      <div class="alert-error">
        {{ $errors->first() }}
      </div>
    @endif
    @if (session('status'))
      <div class="alert-success">
        {{ session('status') }}
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div class="form-group">
        <label for="email">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          value="{{ old('email') }}"
          placeholder="you@example.com"
          autocomplete="email"
          class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
          required
        >
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

    <div class="divider">hoặc</div>

    <button class="btn-google" type="button">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="20px">
        <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
        <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
        <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
        <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
      </svg>
      Đăng nhập với Google
    </button>

    <div class="register-row">
      Chưa có tài khoản? <a href="#">Đăng ký ngay</a>
    </div>
  </div>

  <!-- RIGHT -->
  <<div class="right">
  <img src="{{ asset('images/Xe/Audi/AudiR8.avif') }}" alt="AutoX">
  <div class="right-overlay"></div>
  <div class="right-badge">
    <p>"Trải nghiệm mua xe<br>đơn giản & minh bạch"</p>
    <span>Hơn 500+ khách hàng tin tưởng AutoX</span>
  </div>
</div>

<script>
function togglePw() {
  const input = document.getElementById('password');
  const icon  = document.getElementById('eyeIcon');
  if (input.type === 'password') {
    input.type = 'text';
    icon.innerHTML = `<path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>`;
  } else {
    input.type = 'password';
    icon.innerHTML = `<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>`;
  }
}
</script>

</body>
</html>