<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Quên mật khẩu – AutoX</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    :root {
      --cream: #f5f0e8; --brown: #dfa674; --brown-dark: #c4864e;
      --navy: #002D74; --navy-light: #1a4a9e; --white: #ffffff;
      --gray: #6b7280; --gray-light: #e5e7eb; --error: #dc2626;
    }
    body {
      font-family: 'DM Sans', sans-serif; min-height: 100vh;
      background: var(--cream); display: flex; align-items: center;
      justify-content: center; padding: 20px; position: relative; overflow: hidden;
    }
    body::before {
      content: ''; position: fixed; width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(223,166,116,0.25) 0%, transparent 70%);
      top: -100px; right: -100px; border-radius: 50%; pointer-events: none;
    }
    body::after {
      content: ''; position: fixed; width: 400px; height: 400px;
      background: radial-gradient(circle, rgba(0,45,116,0.08) 0%, transparent 70%);
      bottom: -80px; left: -80px; border-radius: 50%; pointer-events: none;
    }
    .card {
      background: var(--white); border-radius: 24px; display: flex;
      max-width: 860px; width: 100%; overflow: hidden;
      box-shadow: 0 24px 60px rgba(0,0,0,0.12), 0 4px 16px rgba(0,0,0,0.06);
      animation: fadeUp 0.5s cubic-bezier(.22,.68,0,1.2) both;
    }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(28px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .left { flex: 1; padding: 48px 44px; display: flex; flex-direction: column; justify-content: center; }
    .brand { display: flex; align-items: center; gap: 10px; margin-bottom: 36px; }
    .brand-icon { width: 56px; height: 56px; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; }
    .brand-icon img { width: 100%; height: 100%; object-fit: cover; }
    .brand-name { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 700; color: var(--navy); letter-spacing: -0.02em; }
    .steps { display: flex; align-items: center; gap: 0; margin-bottom: 32px; }
    .step { display: flex; align-items: center; gap: 8px; }
    .step-dot { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; flex-shrink: 0; }
    .step-dot.active { background: var(--navy); color: var(--white); }
    .step-dot.inactive { background: var(--gray-light); color: var(--gray); }
    .step-label { font-size: 11px; font-weight: 500; color: var(--gray); white-space: nowrap; }
    .step-label.active { color: var(--navy); font-weight: 600; }
    .step-line { flex: 1; height: 1.5px; background: var(--gray-light); margin: 0 10px; min-width: 20px; }
    h1 { font-family: 'Playfair Display', serif; font-size: 30px; font-weight: 700; color: var(--navy); line-height: 1.2; margin-bottom: 8px; }
    .subtitle { font-size: 14px; color: var(--gray); margin-bottom: 32px; font-weight: 400; line-height: 1.6; }
    .alert-error { background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; padding: 12px 14px; margin-bottom: 20px; font-size: 13px; color: var(--error); }
    .form-group { margin-bottom: 18px; }
    label { display: block; font-size: 12px; font-weight: 600; color: var(--navy); letter-spacing: 0.04em; text-transform: uppercase; margin-bottom: 7px; }
    input[type="text"] { width: 100%; border: 1.5px solid var(--gray-light); border-radius: 12px; padding: 12px 16px; font-size: 14px; font-family: 'DM Sans', sans-serif; color: #111827; background: #fafafa; outline: none; transition: border-color 0.2s, background 0.2s, box-shadow 0.2s; }
    input:focus { border-color: var(--brown); background: var(--white); box-shadow: 0 0 0 3px rgba(223,166,116,0.15); }
    input.is-invalid { border-color: var(--error); }
    .btn-primary { width: 100%; padding: 13px; background: var(--navy); color: var(--white); border: none; border-radius: 12px; font-size: 15px; font-weight: 600; font-family: 'DM Sans', sans-serif; cursor: pointer; transition: background 0.2s, transform 0.15s, box-shadow 0.2s; letter-spacing: 0.02em; margin-bottom: 20px; }
    .btn-primary:hover { background: var(--navy-light); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,45,116,0.22); }
    .btn-primary:active { transform: translateY(0); }
    .back-row { font-size: 13.5px; color: var(--gray); text-align: center; }
    .back-row a { color: var(--navy); font-weight: 600; text-decoration: none; transition: color 0.15s; }
    .back-row a:hover { color: var(--brown-dark); }
    .right { width: 42%; position: relative; overflow: hidden; flex-shrink: 0; background: linear-gradient(135deg, #002D74 0%, #1a4a9e 60%, #dfa674 100%); }
    .right img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .right-overlay { position: absolute; inset: 0; background: linear-gradient(135deg, rgba(0,45,116,0.45) 0%, rgba(223,166,116,0.2) 100%); }
    .right-badge { position: absolute; bottom: 36px; left: 28px; right: 28px; background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.25); border-radius: 16px; padding: 18px 20px; color: var(--white); }
    .right-badge p { font-family: 'Playfair Display', serif; font-size: 16px; font-weight: 600; line-height: 1.4; margin-bottom: 6px; }
    .right-badge span { font-size: 12px; opacity: 0.75; font-weight: 400; }
    @media (max-width: 640px) { .right { display: none; } .left { padding: 36px 28px; } }
  </style>
</head>
<body>
<div class="card">
  <div class="left">
    <div class="brand">
      <div class="brand-icon">
        <img src="{{ asset('images/logo.png') }}" alt="AutoX Logo">
      </div>
      <span class="brand-name">AUTO X</span>
    </div>

    <div class="steps">
      <div class="step">
        <div class="step-dot active">1</div>
        <span class="step-label active">Tài khoản</span>
      </div>
      <div class="step-line"></div>
      <div class="step">
        <div class="step-dot inactive">2</div>
        <span class="step-label">Xác minh OTP</span>
      </div>
      <div class="step-line"></div>
      <div class="step">
        <div class="step-dot inactive">3</div>
        <span class="step-label">Mật khẩu mới</span>
      </div>
    </div>

    <h1>Quên<br>mật khẩu?</h1>
    <p class="subtitle">Nhập tên đăng nhập hoặc email của bạn. Chúng tôi sẽ gửi mã OTP 6 số về hộp thư — hiệu lực 10 phút.</p>

    @if ($errors->any())
      <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
      @csrf
      <div class="form-group">
        <label for="login">Tên đăng nhập hoặc Email</label>
        <input
          type="text"
          id="login"
          name="login"
          value="{{ old('login') }}"
          placeholder="nguyen.vana hoặc you@autox.vn"
          autocomplete="username"
          class="{{ $errors->has('login') ? 'is-invalid' : '' }}"
          autofocus
          required
        >
      </div>
      <button type="submit" class="btn-primary">Gửi mã OTP</button>
    </form>

    <div class="back-row">
      <a href="{{ route('login') }}">← Quay lại đăng nhập</a>
    </div>
  </div>

  <div class="right">
    <img src="{{ asset('images/CTN Mercedes-Benz-G-Class-1-CTN.png') }}" alt="AutoX" onerror="this.style.display='none'">
    <div class="right-overlay"></div>
    <div class="right-badge">
      <p>"Trải nghiệm mua xe<br>đơn giản & minh bạch"</p>
      <span>Hơn 500+ khách hàng tin tưởng AutoX</span>
    </div>
  </div>
</div>
</body>
</html>