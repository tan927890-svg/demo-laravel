<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Tạo mật khẩu mới – AutoX</title>
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
      --success: #16a34a;
      --warn: #d97706;
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
      font-size: 28px;
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
      line-height: 1.5;
    }

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

    .form-group { margin-bottom: 20px; }

    label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--navy);
      letter-spacing: 0.04em;
      text-transform: uppercase;
      margin-bottom: 7px;
    }

    .input-wrap { position: relative; }

    input[type="password"],
    input[type="text"],
    input[type="email"] {
      width: 100%;
      border: 1.5px solid var(--gray-light);
      border-radius: 12px;
      padding: 12px 44px 12px 16px;
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
    input.is-invalid { border-color: var(--error) !important; }
    input.is-valid   { border-color: var(--success) !important; }

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

    /* ── PASSWORD STRENGTH ── */
    .strength-wrap {
      margin-top: 10px;
    }
    .strength-bars {
      display: flex;
      gap: 4px;
      margin-bottom: 6px;
    }
    .strength-bar {
      flex: 1;
      height: 4px;
      border-radius: 99px;
      background: var(--gray-light);
      transition: background 0.3s;
    }
    .strength-label {
      font-size: 12px;
      color: var(--gray);
      font-weight: 500;
    }

    /* ── REQUIREMENTS CHECKLIST ── */
    .req-list {
      margin-top: 12px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 6px 12px;
    }
    .req-item {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 12px;
      color: var(--gray);
      transition: color 0.2s;
    }
    .req-item.ok { color: var(--success); }
    .req-item.fail { color: var(--error); }

    .req-dot {
      width: 7px; height: 7px;
      border-radius: 50%;
      border: 1.5px solid currentColor;
      flex-shrink: 0;
      transition: background 0.2s;
    }
    .req-item.ok .req-dot {
      background: var(--success);
      border-color: var(--success);
    }
    .req-item.fail .req-dot {
      background: var(--error);
      border-color: var(--error);
    }

    /* ── MATCH INDICATOR ── */
    .match-msg {
      margin-top: 8px;
      font-size: 12px;
      font-weight: 500;
      min-height: 16px;
      transition: color 0.2s;
    }
    .match-msg.ok   { color: var(--success); }
    .match-msg.fail { color: var(--error); }

    /* ── BUTTON ── */
    .btn-submit {
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
      margin-top: 8px;
    }
    .btn-submit:hover {
      background: var(--navy-light);
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(0,45,116,0.22);
    }
    .btn-submit:active { transform: translateY(0); }
    .btn-submit:disabled {
      background: var(--gray-light);
      color: var(--gray);
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    .back-link {
      display: flex;
      align-items: center;
      gap: 6px;
      margin-top: 20px;
      font-size: 13px;
      color: var(--gray);
      text-decoration: none;
      width: fit-content;
      transition: color 0.15s;
    }
    .back-link:hover { color: var(--navy); }

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

    /* ── SECURITY BADGE ── */
    .security-note {
      display: flex;
      align-items: center;
      gap: 8px;
      background: #eff6ff;
      border: 1px solid #bfdbfe;
      border-radius: 10px;
      padding: 10px 14px;
      margin-bottom: 24px;
      font-size: 12px;
      color: #1d4ed8;
    }

    @media (max-width: 640px) {
      .right { display: none; }
      .left { padding: 36px 28px; }
      .req-list { grid-template-columns: 1fr; }
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

    <h1>Tạo mật khẩu<br>mới</h1>
    <p class="subtitle">Nhập mật khẩu mới cho tài khoản của bạn. Đảm bảo mật khẩu đủ mạnh để bảo vệ tài khoản.</p>

    {{-- Thông báo lỗi / thành công --}}
    @if ($errors->any())
      <div class="alert-error">{{ $errors->first() }}</div>
    @endif
    @if (session('status'))
      <div class="alert-success">{{ session('status') }}</div>
    @endif

    <div class="security-note">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
      </svg>
      Mật khẩu được mã hóa an toàn và không được lưu dưới dạng văn bản thường.
    </div>

    <form method="POST" action="{{ route('password.reset.update') }}" id="resetForm">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">

      {{-- Email (ẩn hoặc hiện tùy flow) --}}
      <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

      {{-- Mật khẩu mới --}}
      <div class="form-group">
        <label for="password">Mật khẩu mới</label>
        <div class="input-wrap">
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Nhập mật khẩu mới"
            autocomplete="new-password"
            oninput="onPasswordInput()"
            class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
            required
          >
          <button type="button" class="toggle-pw" onclick="togglePw('password','eyeIcon1')" title="Hiện/ẩn mật khẩu">
            <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
              <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
              <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
            </svg>
          </button>
        </div>

        {{-- Thanh đánh giá độ mạnh --}}
        <div class="strength-wrap">
          <div class="strength-bars">
            <div class="strength-bar" id="bar1"></div>
            <div class="strength-bar" id="bar2"></div>
            <div class="strength-bar" id="bar3"></div>
            <div class="strength-bar" id="bar4"></div>
          </div>
          <span class="strength-label" id="strengthLabel"></span>
        </div>

        {{-- Checklist yêu cầu --}}
        <div class="req-list">
          <div class="req-item" id="req-length">
            <div class="req-dot"></div> Tối thiểu 8 ký tự
          </div>
          <div class="req-item" id="req-upper">
            <div class="req-dot"></div> Chữ hoa (A-Z)
          </div>
          <div class="req-item" id="req-lower">
            <div class="req-dot"></div> Chữ thường (a-z)
          </div>
          <div class="req-item" id="req-number">
            <div class="req-dot"></div> Chữ số (0-9)
          </div>
          <div class="req-item" id="req-special">
            <div class="req-dot"></div> Ký tự đặc biệt (!@#...)
          </div>
        </div>
      </div>

      {{-- Xác nhận mật khẩu --}}
      <div class="form-group">
        <label for="password_confirmation">Xác nhận mật khẩu mới</label>
        <div class="input-wrap">
          <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            placeholder="Nhập lại mật khẩu"
            autocomplete="new-password"
            oninput="onConfirmInput()"
            class="{{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
            required
          >
          <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation','eyeIcon2')" title="Hiện/ẩn mật khẩu">
            <svg id="eyeIcon2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
              <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
              <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
            </svg>
          </button>
        </div>
        <div class="match-msg" id="matchMsg"></div>
      </div>

      <button type="submit" class="btn-submit" id="submitBtn" disabled>
        Đặt lại mật khẩu
      </button>
    </form>

    <a href="{{ route('login') }}" class="back-link">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
      </svg>
      Quay lại đăng nhập
    </a>
  </div>

  <!-- RIGHT -->
  <div class="right">
    <img src="{{ asset('images/Xe/Audi/AudiR8.avif') }}" alt="AutoX">
    <div class="right-overlay"></div>
    <div class="right-badge">
      <p>"Bảo mật tài khoản<br>là ưu tiên hàng đầu"</p>
      <span>AutoX bảo vệ dữ liệu của bạn 24/7</span>
    </div>
  </div>

</div>

<script>
const EYE_OPEN = `<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>`;
const EYE_CLOSED = `<path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>`;

function togglePw(inputId, iconId) {
  const input = document.getElementById(inputId);
  const icon  = document.getElementById(iconId);
  if (input.type === 'password') {
    input.type = 'text';
    icon.innerHTML = EYE_CLOSED;
  } else {
    input.type = 'password';
    icon.innerHTML = EYE_OPEN;
  }
}

const STRENGTH_CONFIG = [
  { label: 'Rất yếu',  color: '#ef4444', bars: 1 },
  { label: 'Yếu',      color: '#f97316', bars: 2 },
  { label: 'Trung bình', color: '#eab308', bars: 3 },
  { label: 'Mạnh',     color: '#22c55e', bars: 4 },
];

let reqsPassed = false;
let confirmMatch = false;

function checkReqs(pw) {
  const reqs = {
    'req-length':  pw.length >= 8,
    'req-upper':   /[A-Z]/.test(pw),
    'req-lower':   /[a-z]/.test(pw),
    'req-number':  /[0-9]/.test(pw),
    'req-special': /[^A-Za-z0-9]/.test(pw),
  };
  let passed = 0;
  for (const [id, ok] of Object.entries(reqs)) {
    const el = document.getElementById(id);
    el.classList.toggle('ok', ok);
    el.classList.toggle('fail', pw.length > 0 && !ok);
    if (ok) passed++;
  }
  return { passed, total: Object.keys(reqs).length };
}

function updateStrengthBars(score) {
  const bars = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3'), document.getElementById('bar4')];
  const label = document.getElementById('strengthLabel');
  bars.forEach((b, i) => {
    b.style.background = i < score ? STRENGTH_CONFIG[score-1].color : '';
  });
  label.textContent = score > 0 ? STRENGTH_CONFIG[score-1].label : '';
  label.style.color  = score > 0 ? STRENGTH_CONFIG[score-1].color : '';
}

function calcStrength(pw) {
  if (!pw) return 0;
  let score = 0;
  if (pw.length >= 8)  score++;
  if (pw.length >= 12) score++;
  if (/[A-Z]/.test(pw) && /[a-z]/.test(pw)) score++;
  if (/[0-9]/.test(pw) && /[^A-Za-z0-9]/.test(pw)) score++;
  return Math.min(score, 4);
}

function onPasswordInput() {
  const pw = document.getElementById('password').value;
  const { passed, total } = checkReqs(pw);
  const score = calcStrength(pw);
  updateStrengthBars(score);
  reqsPassed = passed === total;

  const pwInput = document.getElementById('password');
  pwInput.classList.toggle('is-valid', reqsPassed && pw.length > 0);
  pwInput.classList.toggle('is-invalid', !reqsPassed && pw.length > 0);

  onConfirmInput();
}

function onConfirmInput() {
  const pw   = document.getElementById('password').value;
  const conf = document.getElementById('password_confirmation').value;
  const msg  = document.getElementById('matchMsg');
  const confInput = document.getElementById('password_confirmation');

  if (!conf) {
    msg.textContent = '';
    confirmMatch = false;
    confInput.classList.remove('is-valid','is-invalid');
  } else if (pw === conf) {
    msg.textContent = '✓ Mật khẩu khớp';
    msg.className = 'match-msg ok';
    confirmMatch = true;
    confInput.classList.add('is-valid');
    confInput.classList.remove('is-invalid');
  } else {
    msg.textContent = '✗ Mật khẩu không khớp';
    msg.className = 'match-msg fail';
    confirmMatch = false;
    confInput.classList.add('is-invalid');
    confInput.classList.remove('is-valid');
  }

  document.getElementById('submitBtn').disabled = !(reqsPassed && confirmMatch);
}
</script>

</body>
</html>