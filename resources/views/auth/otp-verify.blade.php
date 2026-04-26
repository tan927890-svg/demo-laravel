<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Xác minh OTP – AutoX</title>
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
    .step-dot.done   { background: #dcfce7; color: #15803d; }
    .step-dot.active { background: var(--navy); color: var(--white); }
    .step-dot.pending { background: var(--gray-light); color: var(--gray); }
    .step-label { font-size: 11px; font-weight: 500; color: var(--gray); white-space: nowrap; }
    .step-label.active  { color: var(--navy); font-weight: 600; }
    .step-label.done    { color: #15803d; }
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
    .subtitle strong { color: var(--navy); font-weight: 600; }

    .alert-error {
      background: #fef2f2;
      border: 1px solid #fecaca;
      border-radius: 10px;
      padding: 12px 14px;
      margin-bottom: 20px;
      font-size: 13px;
      color: var(--error);
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

    /* OTP input boxes */
    .otp-wrap {
      display: flex;
      gap: 10px;
      justify-content: flex-start;
    }
    .otp-wrap input {
      width: 52px; height: 56px;
      border: 1.5px solid var(--gray-light);
      border-radius: 12px;
      text-align: center;
      font-size: 22px;
      font-weight: 700;
      font-family: 'DM Sans', sans-serif;
      color: var(--navy);
      background: #fafafa;
      outline: none;
      transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
      caret-color: var(--brown);
    }
    .otp-wrap input:focus {
      border-color: var(--brown);
      background: var(--white);
      box-shadow: 0 0 0 3px rgba(223,166,116,0.15);
    }
    .otp-wrap input.is-invalid { border-color: var(--error); }

    /* Hidden real input */
    #otp { display: none; }

    .field-hint {
      font-size: 12px;
      color: var(--gray);
      margin-top: 8px;
    }

    .timer {
      font-size: 13px;
      color: var(--gray);
      margin-top: 6px;
    }
    .timer span { color: var(--navy); font-weight: 600; }
    .timer .resend-btn {
      background: none;
      border: none;
      color: var(--brown-dark);
      font-weight: 600;
      font-size: 13px;
      cursor: pointer;
      font-family: inherit;
      padding: 0;
      text-decoration: underline;
      display: none;
    }
    .timer .resend-btn:hover { color: var(--navy); }

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
      margin-bottom: 16px;
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

    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 13px;
      color: var(--gray);
      text-decoration: none;
      transition: color 0.15s;
    }
    .back-link:hover { color: var(--navy); }

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
      .otp-wrap input { width: 44px; height: 50px; font-size: 20px; }
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
        <div class="step-dot active">2</div>
        <span class="step-label active">Xác minh OTP</span>
      </div>
      <div class="step-line"></div>
      <div class="step">
        <div class="step-dot pending">3</div>
        <span class="step-label">Mật khẩu mới</span>
      </div>
    </div>

    <h1>Nhập mã<br>xác minh</h1>
    <p class="subtitle">
      Chúng tôi đã gửi mã OTP 6 số đến<br>
      <strong>{{ session('otp_email') }}</strong>
    </p>

    @if ($errors->any())
      <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.otp.verify') }}" id="otpForm">
      @csrf

      {{-- Hidden input gửi lên server --}}
      <input type="hidden" name="otp" id="otp">

      <div class="form-group">
        <label>Mã OTP</label>
        <div class="otp-wrap" id="otpBoxes">
          <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="one-time-code">
          <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
          <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
          <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
          <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
          <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
        </div>
        <p class="field-hint">Hiệu lực trong 10 phút. Kiểm tra cả hộp thư Spam.</p>
        <div class="timer">
          Mã hết hạn sau: <span id="countdown">10:00</span>
          <button type="button" class="resend-btn" id="resendBtn"
            onclick="document.getElementById('resendForm').submit()">
            Gửi lại mã
          </button>
        </div>
      </div>

      <button type="submit" class="btn-primary" id="submitBtn" disabled>Xác nhận</button>
    </form>

    {{-- Form gửi lại OTP --}}
    <form method="POST" action="{{ route('password.email') }}" id="resendForm" style="display:none">
      @csrf
      <input type="hidden" name="email" value="{{ session('otp_email') }}">
    </form>

    <a href="{{ route('password.request') }}" class="back-link">← Quay lại</a>

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
// ── OTP boxes ──
const boxes     = Array.from(document.querySelectorAll('#otpBoxes input'));
const hiddenOtp = document.getElementById('otp');
const submitBtn = document.getElementById('submitBtn');

boxes.forEach((box, i) => {
  box.addEventListener('input', e => {
    const val = e.target.value.replace(/\D/g, '');
    e.target.value = val;
    if (val && i < boxes.length - 1) boxes[i + 1].focus();
    syncOtp();
  });

  box.addEventListener('keydown', e => {
    if (e.key === 'Backspace' && !box.value && i > 0) {
      boxes[i - 1].focus();
      boxes[i - 1].value = '';
      syncOtp();
    }
  });

  box.addEventListener('paste', e => {
    e.preventDefault();
    const pasted = (e.clipboardData || window.clipboardData)
      .getData('text').replace(/\D/g, '').slice(0, 6);
    pasted.split('').forEach((ch, j) => {
      if (boxes[j]) boxes[j].value = ch;
    });
    if (boxes[pasted.length - 1]) boxes[pasted.length - 1].focus();
    syncOtp();
  });
});

function syncOtp() {
  const val = boxes.map(b => b.value).join('');
  hiddenOtp.value = val;
  submitBtn.disabled = val.length < 6;
}

// ── Countdown ──
const countdownEl = document.getElementById('countdown');
const resendBtn   = document.getElementById('resendBtn');
let seconds = 10 * 60;

const timer = setInterval(() => {
  seconds--;
  if (seconds <= 0) {
    clearInterval(timer);
    countdownEl.style.display = 'none';
    resendBtn.style.display = 'inline';
    return;
  }
  const m = String(Math.floor(seconds / 60)).padStart(2, '0');
  const s = String(seconds % 60).padStart(2, '0');
  countdownEl.textContent = `${m}:${s}`;
}, 1000);

// Auto focus first box
boxes[0].focus();
</script>

</body>
</html>