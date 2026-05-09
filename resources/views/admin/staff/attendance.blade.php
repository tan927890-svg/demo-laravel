@extends('layouts.admin')
@section('page-title', 'Chấm công GPS')

@push('styles')
<style>
  .attendance-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    align-items: start;
  }

  .checkin-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 16px;
  }

  .history-table th,
  .history-table td {
    white-space: nowrap;
  }

  /* ── Face modal overlay ── */
  #face-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.65);
    z-index: 9999;
    align-items: center;
    justify-content: center;
  }
  #face-modal.open { display: flex; }

  #face-modal .modal-box {
    background: var(--card-bg, #fff);
    border-radius: 16px;
    padding: 24px;
    width: min(420px, 92vw);
    display: flex;
    flex-direction: column;
    gap: 14px;
    box-shadow: 0 20px 60px rgba(0,0,0,.35);
  }

  #face-modal .modal-title {
    font-weight: 700;
    font-size: 16px;
    text-align: center;
  }

  #face-video-wrap {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    background: #111;
    aspect-ratio: 4/3;
  }

  #face-video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transform: scaleX(-1); /* mirror */
  }

  #face-canvas {
    position: absolute;
    inset: 0;
    transform: scaleX(-1);
  }

  #face-status-bar {
    text-align: center;
    font-size: 13px;
    min-height: 36px;
    line-height: 1.4;
    padding: 6px 12px;
    border-radius: 8px;
    background: var(--bg, #f5f5f3);
    color: var(--text-muted, #888);
  }

  #btn-cancel-face {
    background: transparent;
    border: 1px solid var(--border, #ddd);
    border-radius: 8px;
    padding: 9px;
    cursor: pointer;
    font-size: 13px;
    color: var(--text-muted, #666);
  }

  /* Register face button */
  #btn-register-face {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px dashed var(--border, #ccc);
    background: transparent;
    font-size: 13px;
    cursor: pointer;
    color: var(--text-muted, #666);
    margin-bottom: 10px;
  }
  #btn-register-face:hover { background: var(--bg, #f5f5f3); }

  /* Nút bị khoá khi chưa xác minh mặt */
  .btn-attendance {
    width: 100%;
    justify-content: center;
    font-size: 15px;
    padding: 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: opacity .2s;
  }
  .btn-attendance:disabled { opacity: .45; cursor: not-allowed; }

  @media (max-width: 768px) {
    .attendance-grid      { grid-template-columns: 1fr; }
    .checkin-info-grid    { grid-template-columns: 1fr 1fr; }
    .history-table        { font-size: 12px; }
    .history-table th,
    .history-table td     { padding: 8px 10px; }
    .history-table .col-address { display: none; }
  }
</style>
@endpush

@section('content')

@if(session('success'))
  <div class="alert alert-success" style="margin-bottom:16px">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-error" style="margin-bottom:16px">{{ session('error') }}</div>
@endif

<div class="attendance-grid">

  {{-- ──────────────────────────────────────── --}}
  {{-- Chấm công hôm nay                       --}}
  {{-- ──────────────────────────────────────── --}}
  <div class="card card-pad">
    <div style="font-weight:600;font-size:15px;margin-bottom:4px">📍 Chấm công hôm nay</div>
    <div style="font-size:12px;color:var(--text-muted);margin-bottom:18px">
      {{ now()->format('l, d/m/Y') }}
    </div>

    {{-- Trạng thái ca làm --}}
    @if($record && $record->check_in_at && $record->check_out_at)
      <div style="text-align:center;padding:20px;background:#f0fdf4;border-radius:10px;margin-bottom:16px">
        <div style="font-size:32px;margin-bottom:6px">✅</div>
        <div style="font-weight:600;color:var(--success)">Đã hoàn thành ca làm</div>
        <div style="font-size:13px;color:var(--text-muted);margin-top:4px">
          {{ $record->work_hours }} giờ làm việc
        </div>
      </div>
    @elseif($record && $record->check_in_at)
      <div style="text-align:center;padding:20px;background:#fef9c3;border-radius:10px;margin-bottom:16px">
        <div style="font-size:32px;margin-bottom:6px">🟡</div>
        <div style="font-weight:600;color:#ca8a04">Đang làm việc</div>
        <div style="font-size:13px;color:var(--text-muted);margin-top:4px">
          Check-in lúc {{ $record->check_in_at->format('H:i') }}
        </div>
      </div>
    @else
      <div style="text-align:center;padding:20px;background:var(--bg);border-radius:10px;margin-bottom:16px">
        <div style="font-size:32px;margin-bottom:6px">⏰</div>
        <div style="font-weight:600;color:var(--text-muted)">Chưa check-in</div>
      </div>
    @endif

    {{-- Thông tin check-in / check-out --}}
    @if($record)
    <div class="checkin-info-grid">
      <div style="padding:12px;background:var(--bg);border-radius:8px">
        <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px">CHECK-IN</div>
        @if($record->check_in_at)
          <div style="font-weight:700;font-size:20px;color:var(--success)">
            {{ $record->check_in_at->format('H:i') }}
          </div>
          <div style="font-size:11px;color:var(--text-muted);margin-top:2px;word-break:break-word">
            {{ $record->check_in_address ?? 'Không có địa chỉ' }}
          </div>
        @else
          <div style="color:var(--text-muted)">—</div>
        @endif
      </div>
      <div style="padding:12px;background:var(--bg);border-radius:8px">
        <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px">CHECK-OUT</div>
        @if($record->check_out_at)
          <div style="font-weight:700;font-size:20px;color:var(--danger)">
            {{ $record->check_out_at->format('H:i') }}
          </div>
          <div style="font-size:11px;color:var(--text-muted);margin-top:2px;word-break:break-word">
            {{ $record->check_out_address ?? 'Không có địa chỉ' }}
          </div>
        @else
          <div style="color:var(--text-muted)">—</div>
        @endif
      </div>
    </div>
    @endif

    {{-- GPS status --}}
    <div id="gps-status"
         style="padding:10px 14px;background:var(--bg);border-radius:8px;font-size:13px;color:var(--text-muted);text-align:center;margin-bottom:10px">
      ⏳ Đang lấy vị trí GPS...
    </div>

    {{-- Nút đăng ký khuôn mặt (hiện nếu chưa đăng ký) --}}
    <div id="face-register-wrap" style="display:none">
      <button id="btn-register-face" onclick="openModal('register')">
        📷 Chưa đăng ký khuôn mặt — Nhấn để đăng ký
      </button>
    </div>

    {{-- ── FORM CHECK-IN ── --}}
    @if(!$record || !$record->check_in_at)
    <form id="checkin-form" method="POST" action="{{ route('admin.staff.attendance.checkin') }}">
      @csrf
      <input type="hidden" name="lat"          id="lat-in">
      <input type="hidden" name="lng"          id="lng-in">
      <input type="hidden" name="address"      id="addr-in">
      <input type="hidden" name="face_verified" id="face-verified-in" value="0">

      {{-- Bước 1: quét mặt (luôn hiện, mở modal) --}}
      <button type="button" id="btn-face-checkin" disabled
              onclick="openModal('checkin')"
              class="btn-attendance"
              style="background:#2563eb;color:#fff;margin-bottom:8px">
        📷 Quét khuôn mặt để Check-in
      </button>

      {{-- Bước 2: submit (chỉ kích hoạt sau khi mặt khớp) --}}
      <button type="submit" id="btn-checkin" disabled
              class="btn-attendance"
              style="background:#16a34a;color:#fff">
        📍 Xác nhận Check-in
      </button>
    </form>

    {{-- ── FORM CHECK-OUT ── --}}
    @elseif($record && $record->check_in_at && !$record->check_out_at)
    <form id="checkout-form" method="POST" action="{{ route('admin.staff.attendance.checkout') }}">
      @csrf
      <input type="hidden" name="lat"          id="lat-out">
      <input type="hidden" name="lng"          id="lng-out">
      <input type="hidden" name="address"      id="addr-out">
      <input type="hidden" name="face_verified" id="face-verified-out" value="0">

      {{-- Bước 1: quét mặt --}}
      <button type="button" id="btn-face-checkout" disabled
              onclick="openModal('checkout')"
              class="btn-attendance"
              style="background:#2563eb;color:#fff;margin-bottom:8px">
        📷 Quét khuôn mặt để Check-out
      </button>

      {{-- Bước 2: submit (chỉ kích hoạt sau khi mặt khớp) --}}
      <button type="submit" id="btn-checkout" disabled
              class="btn-attendance"
              style="background:#dc2626;color:#fff">
        📍 Xác nhận Check-out
      </button>
    </form>
    @endif

  </div>

  {{-- ──────────────────────────────────────── --}}
  {{-- Lịch sử chấm công                       --}}
  {{-- ──────────────────────────────────────── --}}
  <div class="card" style="overflow:hidden">
    <div style="padding:14px 18px;border-bottom:1px solid var(--border);font-weight:600">
      📅 Lịch sử 30 ngày gần nhất
    </div>
    <div style="overflow-x:auto">
      <table class="history-table" style="width:100%;border-collapse:collapse;font-size:14px">
        <thead>
          <tr>
            <th style="text-align:left;padding:11px 16px;font-size:12px;font-weight:700;color:var(--text-2);letter-spacing:.4px;text-transform:uppercase;border-bottom:1px solid var(--border);background:#fafaf8">Ngày</th>
            <th style="text-align:left;padding:11px 16px;font-size:12px;font-weight:700;color:var(--text-2);letter-spacing:.4px;text-transform:uppercase;border-bottom:1px solid var(--border);background:#fafaf8">Check-in</th>
            <th style="text-align:left;padding:11px 16px;font-size:12px;font-weight:700;color:var(--text-2);letter-spacing:.4px;text-transform:uppercase;border-bottom:1px solid var(--border);background:#fafaf8">Check-out</th>
            <th style="text-align:left;padding:11px 16px;font-size:12px;font-weight:700;color:var(--text-2);letter-spacing:.4px;text-transform:uppercase;border-bottom:1px solid var(--border);background:#fafaf8">Giờ</th>
          </tr>
        </thead>
        <tbody>
          @forelse($history as $h)
          <tr>
            <td style="padding:11px 16px;border-bottom:1px solid var(--border);font-size:13px">{{ $h->work_date->format('d/m/Y') }}</td>
            <td style="padding:11px 16px;border-bottom:1px solid var(--border);color:var(--success);font-weight:600">
              {{ $h->check_in_at ? $h->check_in_at->format('H:i') : '—' }}
            </td>
            <td style="padding:11px 16px;border-bottom:1px solid var(--border);color:var(--danger)">
              {{ $h->check_out_at ? $h->check_out_at->format('H:i') : '—' }}
            </td>
            <td style="padding:11px 16px;border-bottom:1px solid var(--border)">
              @if($h->work_hours)
                <span style="font-weight:600">{{ $h->work_hours }}h</span>
              @else
                <span style="color:var(--text-muted)">—</span>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" style="text-align:center;padding:30px;color:var(--text-muted)">
              Chưa có lịch sử chấm công
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

{{-- ──────────────────────────────────────────── --}}
{{-- Face Recognition Modal                      --}}
{{-- ──────────────────────────────────────────── --}}
<div id="face-modal">
  <div class="modal-box">
    <div class="modal-title" id="modal-title">📷 Xác minh khuôn mặt</div>

    <div id="face-video-wrap">
      <video id="face-video" autoplay muted playsinline></video>
      <canvas id="face-canvas"></canvas>
    </div>

    <div id="face-status-bar">Đang khởi động camera...</div>

    <button id="btn-cancel-face" onclick="closeModal()">✕ Hủy</button>
  </div>
</div>

@push('scripts')
{{-- face-api.js từ CDN --}}
<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

<script>
// ══════════════════════════════════════════════════
// CẤU HÌNH
// ══════════════════════════════════════════════════
const OFFICE_LAT    = {{ config('app.office.lat') }};
const OFFICE_LNG    = {{ config('app.office.lng') }};
const OFFICE_RADIUS = {{ config('app.office.radius', 150) }};
const MODEL_URL     = '/face-models';
const MATCH_THRESHOLD = 0.5;

// ══════════════════════════════════════════════════
// STATE
// ══════════════════════════════════════════════════
const isIOS = /iPhone|iPad|iPod/.test(navigator.userAgent);

let modelsLoaded    = false;
let savedDescriptor = null;   // Float32Array từ server
let currentMode     = null;   // 'checkin' | 'checkout' | 'register'
let videoStream     = null;
let detectionLoop   = null;
let gpsReady        = false;  // GPS đã lấy được và trong vùng cho phép
let faceRegistered  = false;  // Đã đăng ký khuôn mặt

// ══════════════════════════════════════════════════
// GPS HELPERS
// ══════════════════════════════════════════════════
function getDistance(lat1, lng1, lat2, lng2) {
  const R = 6371000;
  const dLat = (lat2 - lat1) * Math.PI / 180;
  const dLng = (lng2 - lng1) * Math.PI / 180;
  const a = Math.sin(dLat/2)**2
          + Math.cos(lat1*Math.PI/180) * Math.cos(lat2*Math.PI/180)
          * Math.sin(dLng/2)**2;
  return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
}

function setGpsStatus(html, color) {
  const el = document.getElementById('gps-status');
  if (el) { el.innerHTML = html; el.style.color = color || ''; }
}

// Kích hoạt nút quét mặt (bước 1) — chỉ sau khi GPS OK
function enableFaceBtn() {
  ['btn-face-checkin', 'btn-face-checkout'].forEach(id => {
    const btn = document.getElementById(id);
    if (btn) { btn.disabled = false; btn.style.opacity = '1'; }
  });
}

// Kích hoạt nút submit (bước 2) — chỉ sau khi mặt khớp
function enableSubmitBtn(mode) {
  const id  = mode === 'checkin' ? 'btn-checkin' : 'btn-checkout';
  const btn = document.getElementById(id);
  if (btn) {
    btn.disabled = false;
    btn.style.opacity = '1';
    btn.style.boxShadow = '0 0 0 3px rgba(22,163,74,.35)'; // highlight xanh
  }
}

// ══════════════════════════════════════════════════
// LOAD MODELS
// ══════════════════════════════════════════════════
async function loadModels() {
  if (modelsLoaded) return;
  await Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
    faceapi.nets.faceLandmark68TinyNet.loadFromUri(MODEL_URL),
    faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL),
  ]);
  modelsLoaded = true;
}

// ══════════════════════════════════════════════════
// LẤY DESCRIPTOR TỪ SERVER
// ══════════════════════════════════════════════════
async function fetchSavedDescriptor() {
  try {
    const res  = await fetch('{{ route('admin.staff.attendance.face.get') }}');
    const data = await res.json();
    if (data.registered && data.descriptor) {
      savedDescriptor = new Float32Array(data.descriptor);
      faceRegistered  = true;
      return true;
    }
  } catch(e) {}
  return false;
}

// ══════════════════════════════════════════════════
// MỞ MODAL
// ══════════════════════════════════════════════════
async function openModal(mode) {
  currentMode = mode;   // lưu TRƯỚC khi làm gì khác

  const modal  = document.getElementById('face-modal');
  const title  = document.getElementById('modal-title');
  const status = document.getElementById('face-status-bar');

  const labels = {
    checkin:  '📷 Quét mặt — Check-in',
    checkout: '📷 Quét mặt — Check-out',
    register: '📷 Đăng ký khuôn mặt',
  };
  title.textContent  = labels[mode];
  status.textContent = 'Đang tải model nhận diện...';
  status.style.color = '';

  modal.classList.add('open');

  await loadModels();
  status.textContent = 'Đang mở camera...';

  try {
    videoStream = await navigator.mediaDevices.getUserMedia({
      video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } },
      audio: false,
    });
    const video  = document.getElementById('face-video');
    video.srcObject = videoStream;
    await new Promise(r => video.onloadedmetadata = r);

    const canvas  = document.getElementById('face-canvas');
    canvas.width  = video.videoWidth;
    canvas.height = video.videoHeight;

    if (mode === 'register') {
      status.textContent = 'Nhìn thẳng vào camera rồi giữ yên...';
      startRegisterLoop();
    } else {
      // checkin / checkout — cần descriptor
      if (!savedDescriptor) {
        const ok = await fetchSavedDescriptor();
        if (!ok) {
          setFaceStatus('❌ Chưa đăng ký khuôn mặt. Hãy đăng ký trước.', '#dc2626');
          return;
        }
      }
      status.textContent = 'Nhìn thẳng vào camera...';
      startVerifyLoop();
    }
  } catch(err) {
    setFaceStatus('❌ Không mở được camera: ' + err.message, '#dc2626');
  }
}

// ══════════════════════════════════════════════════
// ĐÓNG MODAL — KHÔNG reset currentMode ở đây
// ══════════════════════════════════════════════════
function closeModal() {
  stopCamera();
  document.getElementById('face-modal').classList.remove('open');
  // currentMode KHÔNG bị null ở đây — submitAttendanceForm() cần nó
}

function setFaceStatus(msg, color) {
  const el = document.getElementById('face-status-bar');
  el.textContent = msg;
  el.style.color = color || '';
}

// ══════════════════════════════════════════════════
// DỪNG CAMERA
// ══════════════════════════════════════════════════
function stopCamera() {
  if (detectionLoop) { cancelAnimationFrame(detectionLoop); detectionLoop = null; }
  if (videoStream)   { videoStream.getTracks().forEach(t => t.stop()); videoStream = null; }
  const canvas = document.getElementById('face-canvas');
  canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
}

const detectorOptions = new faceapi.TinyFaceDetectorOptions({
  inputSize: 320,
  scoreThreshold: 0.5,
});

// ══════════════════════════════════════════════════
// VÒNG LẶP ĐĂNG KÝ
// ══════════════════════════════════════════════════
function startRegisterLoop() {
  let stableFrames = 0;

  async function loop() {
    const video  = document.getElementById('face-video');
    const canvas = document.getElementById('face-canvas');
    const result = await faceapi
      .detectSingleFace(video, detectorOptions)
      .withFaceLandmarks(true)
      .withFaceDescriptor();

    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    if (result) {
      drawBox(ctx, result.detection.box, '#16a34a');
      stableFrames++;

      if (stableFrames < 10) {
        setFaceStatus(`Giữ yên... (${stableFrames}/10)`, '#ca8a04');
      } else {
        setFaceStatus('✅ Đang lưu khuôn mặt...', '#16a34a');
        stopCamera();
        await saveDescriptor(result.descriptor);
        return;
      }
    } else {
      stableFrames = 0;
      setFaceStatus('Không nhận ra khuôn mặt. Hãy nhìn thẳng vào camera.', '#dc2626');
    }

    detectionLoop = requestAnimationFrame(loop);
  }

  detectionLoop = requestAnimationFrame(loop);
}

// ══════════════════════════════════════════════════
// VÒNG LẶP XÁC MINH (checkin / checkout)
// ══════════════════════════════════════════════════
function startVerifyLoop() {
  let matchedFrames = 0;

  async function loop() {
    const video  = document.getElementById('face-video');
    const canvas = document.getElementById('face-canvas');
    const result = await faceapi
      .detectSingleFace(video, detectorOptions)
      .withFaceLandmarks(true)
      .withFaceDescriptor();

    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    if (result) {
      const dist    = faceapi.euclideanDistance(result.descriptor, savedDescriptor);
      const matched = dist < MATCH_THRESHOLD;

      drawBox(ctx, result.detection.box, matched ? '#16a34a' : '#dc2626');

      if (matched) {
        matchedFrames++;
        const pct = Math.round((1 - dist / MATCH_THRESHOLD) * 100);
        setFaceStatus(`✅ Khớp ${pct}% — (${matchedFrames}/5 frame)`, '#16a34a');

        if (matchedFrames >= 5) {
          // Xác minh thành công → đóng modal → mở khoá nút submit
          stopCamera();
          setFaceStatus('✅ Xác minh thành công!', '#16a34a');

          // Lưu mode vào biến cục bộ TRƯỚC khi đóng modal
          const verifiedMode = currentMode;
          document.getElementById('face-modal').classList.remove('open');
          currentMode = null;

          onFaceVerified(verifiedMode);
          return;
        }
      } else {
        matchedFrames = 0;
        const pct = Math.round((1 - dist) * 100);
        setFaceStatus(`❌ Không khớp (${pct}%). Nhìn thẳng hơn.`, '#dc2626');
      }
    } else {
      matchedFrames = 0;
      setFaceStatus('Không nhận ra khuôn mặt. Hãy nhìn thẳng vào camera.', '#888');
    }

    detectionLoop = requestAnimationFrame(loop);
  }

  detectionLoop = requestAnimationFrame(loop);
}

// ══════════════════════════════════════════════════
// SAU KHI MẶT KHỚP — mở khoá nút submit
// ══════════════════════════════════════════════════
function onFaceVerified(mode) {
  if (mode === 'checkin') {
    document.getElementById('face-verified-in').value = '1';
    // Ẩn nút quét, highlight nút submit
    const faceBtn   = document.getElementById('btn-face-checkin');
    if (faceBtn) {
      faceBtn.textContent = '✅ Đã xác minh khuôn mặt';
      faceBtn.disabled    = true;
      faceBtn.style.opacity = '0.6';
      faceBtn.style.background = '#15803d';
    }
    enableSubmitBtn('checkin');

  } else if (mode === 'checkout') {
    document.getElementById('face-verified-out').value = '1';
    const faceBtn   = document.getElementById('btn-face-checkout');
    if (faceBtn) {
      faceBtn.textContent = '✅ Đã xác minh khuôn mặt';
      faceBtn.disabled    = true;
      faceBtn.style.opacity = '0.6';
      faceBtn.style.background = '#15803d';
    }
    enableSubmitBtn('checkout');
  }
}

// ══════════════════════════════════════════════════
// VẼ BOUNDING BOX
// ══════════════════════════════════════════════════
function drawBox(ctx, box, color) {
  ctx.strokeStyle = color;
  ctx.lineWidth   = 2.5;
  ctx.strokeRect(box.x, box.y, box.width, box.height);

  const s = 20;
  ctx.lineWidth = 3.5;
  [[box.x, box.y], [box.x+box.width, box.y],
   [box.x, box.y+box.height], [box.x+box.width, box.y+box.height]].forEach(([cx,cy]) => {
    const dx = cx === box.x ? 1 : -1;
    const dy = cy === box.y ? 1 : -1;
    ctx.beginPath();
    ctx.moveTo(cx, cy + dy*s);
    ctx.lineTo(cx, cy);
    ctx.lineTo(cx + dx*s, cy);
    ctx.stroke();
  });
}

// ══════════════════════════════════════════════════
// LƯU DESCRIPTOR LÊN SERVER
// ══════════════════════════════════════════════════
async function saveDescriptor(descriptor) {
  try {
    const res = await fetch('{{ route('admin.staff.attendance.face.save') }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
      },
      body: JSON.stringify({ descriptor: Array.from(descriptor) }),
    });

    const data = await res.json();
    if (data.success) {
      savedDescriptor = descriptor;
      faceRegistered  = true;
      setFaceStatus('✅ Đã lưu khuôn mặt thành công!', '#16a34a');
      document.getElementById('face-register-wrap').style.display = 'none';
      // Nếu GPS đã OK thì kích hoạt nút quét
      if (gpsReady) enableFaceBtn();
      setTimeout(closeModal, 1500);
    } else {
      setFaceStatus('❌ Lưu thất bại. Vui lòng thử lại.', '#dc2626');
    }
  } catch(e) {
    setFaceStatus('❌ Lỗi kết nối: ' + e.message, '#dc2626');
  }
}

// ══════════════════════════════════════════════════
// GPS — KHỞI ĐỘNG KHI LOAD TRANG
// ══════════════════════════════════════════════════
if (navigator.geolocation) {
  setGpsStatus('⏳ Đang lấy vị trí GPS' + (isIOS ? ' (iOS có thể mất 10–15 giây)...' : '...'));

  navigator.geolocation.getCurrentPosition(
    async function(pos) {
      const lat  = pos.coords.latitude;
      const lng  = pos.coords.longitude;
      const dist = Math.round(getDistance(lat, lng, OFFICE_LAT, OFFICE_LNG));

      // Gán toạ độ + địa chỉ vào form
      ['lat-in','lat-out'].forEach(id => { const e=document.getElementById(id); if(e) e.value=lat; });
      ['lng-in','lng-out'].forEach(id => { const e=document.getElementById(id); if(e) e.value=lng; });

      let address = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
      try {
        const res  = await fetch(
          `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`,
          { headers: { 'Accept-Language': 'vi' } }
        );
        const geoData = await res.json();
        if (geoData.display_name) address = geoData.display_name;
      } catch(e) {}
      ['addr-in','addr-out'].forEach(id => { const e=document.getElementById(id); if(e) e.value=address; });

      // Kiểm tra khuôn mặt đã đăng ký chưa
      const hasDescriptor = await fetchSavedDescriptor();
      if (!hasDescriptor) {
        document.getElementById('face-register-wrap').style.display = 'block';
      }

      if (dist <= OFFICE_RADIUS) {
        gpsReady = true;
        setGpsStatus(`✅ Bạn đang ở trong văn phòng <strong>(cách ${dist}m)</strong>`, '#16a34a');

        // Chỉ kích hoạt nút quét mặt (bước 1) — nút submit vẫn khoá
        if (hasDescriptor) enableFaceBtn();
        // Nếu chưa đăng ký, nút quét mặt sẽ được enable sau khi đăng ký xong

      } else {
        setGpsStatus(
          `❌ Cách văn phòng <strong>${dist}m</strong> — cần trong vòng <strong>${OFFICE_RADIUS}m</strong>`,
          '#dc2626'
        );
        // GPS ngoài vùng → không enable gì cả
      }
    },
    function(err) {
      let msg = '❌ Không lấy được vị trí GPS.';
      if (err.code === 1) {
        msg = isIOS
          ? '❌ Chưa cấp quyền GPS. Vào <strong>Cài đặt → Quyền riêng tư → Dịch vụ vị trí → Safari</strong> → chọn "Khi dùng".'
          : '❌ Chưa cấp quyền GPS. Hãy cho phép trình duyệt truy cập vị trí.';
      } else if (err.code === 3) {
        msg = '❌ GPS quá chậm. Hãy ra chỗ thoáng và thử lại.';
      }
      setGpsStatus(msg, '#dc2626');
    },
    {
      enableHighAccuracy: true,
      timeout:    isIOS ? 15000 : 10000,
      maximumAge: 0,
    }
  );
} else {
  setGpsStatus('❌ Trình duyệt không hỗ trợ GPS.', '#dc2626');
}
</script>
@endpush

@endsection