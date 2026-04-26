<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Đặt mật khẩu mới – AutoX</title>
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
      --success: #15803d;
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

    .steps {
      display: flex;
      align-items: center;
      margin-bottom: 32px;
    }
    .step { display: flex; align-items: center; gap: 8px; }
    .step-dot {
      width: 28px; height: 28px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      font-weight: 600;
      flex-shrink: 0;
    }
    .step-dot.done { background: #dcfce7; color: #15803d; }
    .step-dot.active { background: var(--navy); color: var(--white); }
    .step-label { font-size: 11px; font-weight: 500; color: var(--gray); white-space: nowrap; }
    .step-label.active { color: var(--navy); font-weight: 600; }
    .step-label.done { color: #15803d; }
    .step-line { flex: 1; height: 1.5px; background: var(--gray-light); margin: 0 10px; min-width: 20px; }
    .step-line.done { background: #86efac; }

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
      line-height: 1.6;
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

    .input-wrap { position: relative; }

    input[type="password"],
    input[type="text"] {
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

    /* Password strength bar */
    .strength-bar {
      display: flex;
      gap: 4px;
      margin-top: 8px;
    }
    .strength-bar span {
      flex: 1;
      height: 3px;
      border-radius: 2px;
      background: var(--gray-light);
      transition: background 0.3s;
    }
    .strength-bar span.weak { background: #f87171; }
    .strength-bar span.medium { background: #fbbf24; }
    .strength-bar span.strong { background: #34d399; }

    .strength-label {
      font-size: 11px;
      color: var(--gray);
      margin-top: 4px;
      height: 16px;
      transition: color 0.2s;
    }

    /* Match indicator */
    .match-hint {
      font-size: 12px;
      margin-top: 6px;
      display: flex;
      align-items: center;
      gap: 5px;
      min-height: 18px;
    }
    .match-hint.ok { color: var(--success); }
    .match-hint.no { color: var(--error); }

    .btn-primary {
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
      margin-bottom: 20px;
    }
    .btn-primary:hover {
      background: var(--navy-light);
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(0,45,116,0.22);
    }
    .btn-primary:active { transform: translateY(0); }
    .btn-primary:disabled {
      background: var(--gray-light);
      color: var(--gray);
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    .right {
      width: 42%;
      position: relative;
      overflow: hidden;
      flex-shrink: 0;
      background: linear-gradient(135deg, #002D74 0%, #1a4a9e 60%, #dfa674 100%);
    }
    .right img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .right-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(0,45,116,0.45) 0%, rgba(223,166,116,0.2) 100%);
    }
    .right-badge {
      position: absolute;
      bottom: 36px; left: 28px; right: 28px;
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
      .left { padding: 36px 28px; }
    }
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
        <div class="step-dot done">
          <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
            <path d="M2 6l3 3 5-5" stroke="#15803d" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <span class="step-label done">Email</span>
      </div>
      <div class="step-line done"></div>
      <div class="step">
        <div class="step-dot done">
          <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
            <path d="M2 6l3 3 5-5" stroke="#15803d" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <span class="step-label done">Xác minh OTP</span>
      </div>
      <div class="step-line done"></div>
      <div class="step">
        <div class="step-dot active">3</div>
        <span class="step-label active">Mật khẩu mới</span>
      </div>
    </div>

    <h1>Đặt mật<br>khẩu mới</h1>
    <p class="subtitle">Tạo mật khẩu mạnh — ít nhất 8 ký tự, bao gồm chữ hoa, số và ký tự đặc biệt.</p>

    @if ($errors->any())
      <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.reset') }}" id="resetForm">
      @csrf

      <div class="form-group">
        <label for="password">Mật khẩu mới</label>
        <div class="input-wrap">
          <input
            type="password"
            id="password"
            name="password"
            placeholder="••••••••"
            autocomplete="new-password"
            class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
            required
          >
          <button type="button" class="toggle-pw" onclick="togglePw('password','eyeIcon1')" title="Hiện/ẩn">
            <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
              <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
              <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
            </svg>
          </button>
        </div>
        <div class="strength-bar">
          <span id="s1"></span><span id="s2"></span><span id="s3"></span><span id="s4"></span>
        </div>
        <p class="strength-label" id="strengthLabel"></p>
      </div>

      <div class="form-group">
        <label for="password_confirmation">Xác nhận mật khẩu</label>
        <div class="input-wrap">
          <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            placeholder="••••••••"
            autocomplete="new-password"
            required
          >
          <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation','eyeIcon2')" title="Hiện/ẩn">
            <svg id="eyeIcon2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
              <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
              <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
            </svg>
          </button>
        </div>
        <p class="match-hint" id="matchHint"></p>
      </div>

      <button type="submit" class="btn-primary" id="submitBtn" disabled>Cập nhật mật khẩu</button>
    </form>

  </div>

  <div class="right">
    <img
      src="{{ asset('images/CTN Mercedes-Benz-G-Class-1-CTN.png') }}"
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
const eyeSvgOpen = `<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>`;
const eyeSvgClosed = `<path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>`;

function togglePw(inputId, iconId) {
  const input = document.getElementById(inputId);
  const icon  = document.getElementById(iconId);
  if (input.type === 'password') {
    input.type = 'text';
    icon.innerHTML = eyeSvgClosed;
  } else {
    input.type = 'password';
    icon.innerHTML = eyeSvgOpen;
  }
}

function getStrength(pw) {
  let score = 0;
  if (pw.length >= 8) score++;
  if (/[A-Z]/.test(pw)) score++;
  if (/[0-9]/.test(pw)) score++;
  if (/[^A-Za-z0-9]/.test(pw)) score++;
  return score;
}

const pwInput   = document.getElementById('password');
const confInput = document.getElementById('password_confirmation');
const bars      = [document.getElementById('s1'), document.getElementById('s2'), document.getElementById('s3'), document.getElementById('s4')];
const strengthLabel = document.getElementById('strengthLabel');
const matchHint = document.getElementById('matchHint');
const submitBtn = document.getElementById('submitBtn');

const levels = [
  { label: '',          cls: '' },
  { label: 'Yếu',      cls: 'weak' },
  { label: 'Trung bình', cls: 'medium' },
  { label: 'Khá mạnh', cls: 'medium' },
  { label: 'Mạnh',     cls: 'strong' },
];

function updateUI() {
  const pw   = pwInput.value;
  const conf = confInput.value;
  const score = pw ? getStrength(pw) : 0;

  bars.forEach((b, i) => {
    b.className = '';
    if (i < score) b.className = levels[score].cls;
  });

  strengthLabel.textContent = pw ? levels[score].label : '';
  strengthLabel.style.color = score <= 1 ? '#f87171' : score <= 3 ? '#fbbf24' : '#34d399';

  if (conf) {
    if (pw === conf) {
      matchHint.textContent = '✓ Mật khẩu khớp';
      matchHint.className = 'match-hint ok';
    } else {
      matchHint.textContent = '✗ Mật khẩu không khớp';
      matchHint.className = 'match-hint no';
    }
  } else {
    matchHint.textContent = '';
    matchHint.className = 'match-hint';
  }

  submitBtn.disabled = !(pw && conf && pw === conf && score >= 2);
}

pwInput.addEventListener('input', updateUI);
confInput.addEventListener('input', updateUI);
</script>

</body>
</html>
