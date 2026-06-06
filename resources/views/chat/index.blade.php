<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Auto X Chat</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;overflow:hidden}
body{font-family:'Segoe UI',sans-serif;background:#f0f2f5}

#app{position:absolute;top:0;left:0;right:0;bottom:0;display:flex;flex-direction:column;background:#fff;overflow:hidden}

/* Header */
#hd{background:#0d2137;padding:14px 18px;display:flex;align-items:center;gap:12px;flex-shrink:0;min-height:64px}
#hd .dot{width:9px;height:9px;border-radius:50%;background:#4ade80;flex-shrink:0}
#hd-logo{width:38px;height:38px;border-radius:50%;background:#1c3557;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#5b9ff5;border:1.5px solid #2a4a6a;flex-shrink:0}
#hd-text .name{color:#fff;font-size:15px;font-weight:600}
#hd-text .sub{color:#8eafc8;font-size:12px}
#hd-clear{margin-left:auto;background:transparent;border:1px solid #2a4a6a;color:#8eafc8;font-size:11px;padding:5px 10px;border-radius:6px;cursor:pointer;transition:all .15s}
#hd-clear:hover{background:#1c3557;color:#fff}

/* Messages */
#ms{flex:1;min-height:0;overflow-y:auto;overflow-x:hidden;padding:14px;display:flex;flex-direction:column;gap:10px;background:#f7f9fc}
#ms::-webkit-scrollbar{width:4px}
#ms::-webkit-scrollbar-thumb{background:#d0d7e3;border-radius:4px}

.m{display:flex;gap:8px;align-items:flex-end;max-width:88%}
.m.u{align-self:flex-end;flex-direction:row-reverse}
.av{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:600;flex-shrink:0}
.m.b .av{background:#0d2137;color:#8eafc8}
.m.u .av{background:#1c69d4;color:#fff}
.bub{padding:10px 14px;border-radius:16px;font-size:13.5px;line-height:1.7;max-width:100%;word-break:break-word}
.m.b .bub{background:#fff;color:#1a1a1a;border-bottom-left-radius:4px;box-shadow:0 1px 4px rgba(0,0,0,0.08)}
.m.u .bub{background:#1c69d4;color:#fff;border-bottom-right-radius:4px}

/* Car image card */
.car-img-card{border-radius:12px;overflow:hidden;background:#fff;box-shadow:0 2px 10px rgba(0,0,0,0.1);margin-bottom:8px;max-width:280px;cursor:pointer;transition:transform .15s}
.car-img-card:hover{transform:translateY(-2px)}
.car-img-card img{width:100%;height:140px;object-fit:cover;display:block}
.car-img-card-body{padding:8px 10px 10px}
.car-img-card-name{font-weight:700;font-size:13px;color:#0d2137;margin-bottom:2px}
.car-img-card-price{font-size:12px;color:#1c69d4;font-weight:600}

/* Compare imgs */
.car-compare-imgs{display:flex;gap:8px;margin-bottom:8px}
.car-compare-imgs .car-img-mini{flex:1;border-radius:10px;overflow:hidden;background:#fff;box-shadow:0 1px 6px rgba(0,0,0,0.09)}
.car-compare-imgs .car-img-mini img{width:100%;height:90px;object-fit:cover;display:block}
.car-compare-imgs .car-img-mini .mini-label{font-size:10px;font-weight:700;color:#0d2137;padding:4px 8px;background:#f0f5ff;text-align:center}

/* Typing */
.typing{display:flex;gap:4px;padding:12px 14px;align-items:center}
.typing span{width:7px;height:7px;border-radius:50%;background:#b0bec5;animation:bounce 1.2s infinite}
.typing span:nth-child(2){animation-delay:.2s}
.typing span:nth-child(3){animation-delay:.4s}
@keyframes bounce{0%,60%,100%{transform:translateY(0)}30%{transform:translateY(-6px)}}

/* Quick buttons */
#qb{display:flex;flex-wrap:wrap;gap:6px;padding:8px 14px 10px;background:#f7f9fc;border-top:1px solid #eef0f4;flex-shrink:0}
#qb:empty{display:none}
.qb{font-size:12px;padding:6px 12px;border:1px solid #c8d4e8;border-radius:20px;background:#fff;color:#1c69d4;cursor:pointer;transition:all .15s;font-weight:500}
.qb:hover{background:#1c69d4;color:#fff;border-color:#1c69d4}

/* Input */
#ir{display:flex;gap:8px;padding:10px 12px;border-top:1px solid #eef0f4;background:#fff;flex-shrink:0}
#ui{flex:1;font-size:13.5px;padding:9px 14px;border:1px solid #dde3ef;border-radius:22px;background:#f7f9fc;color:#1a1a1a;outline:none;transition:border-color .15s}
#ui:focus{border-color:#1c69d4;background:#fff}
#ui:disabled{opacity:.6;cursor:not-allowed}
#sb{width:36px;height:36px;border-radius:50%;background:#1c69d4;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:background .15s}
#sb:hover{background:#1555b0}
#sb:disabled{background:#b0bec5;cursor:not-allowed}
#sb svg{width:14px;height:14px;fill:#fff}
#img-btn{width:36px;height:36px;border-radius:50%;background:#f0f2f5;border:1px solid #dde3ef;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:background .15s}
#img-btn:hover{background:#e0e4ec}
#img-btn svg{width:16px;height:16px;fill:#6b7280}

/* Image preview in input */
#img-preview-wrap{display:none;padding:6px 12px 0;align-items:center;gap:8px}
#img-preview-wrap img{height:48px;width:48px;object-fit:cover;border-radius:6px;border:1px solid #dde3ef}
#img-preview-wrap .rm{background:#e74c3c;color:#fff;border:none;border-radius:50%;width:18px;height:18px;font-size:10px;cursor:pointer;display:flex;align-items:center;justify-content:center}

/* See all cars link */
.see-all-cars{display:inline-flex;align-items:center;gap:5px;margin-top:10px;padding:6px 14px;background:#eef4ff;border:1px solid #c8d4e8;border-radius:20px;font-size:12px;font-weight:600;color:#1c69d4;text-decoration:none;transition:background .15s}
.see-all-cars:hover{background:#ddeaff}

/* Booking form */
.booking-bubble{background:#fff;border:1.5px solid #1c69d4;border-radius:16px;border-bottom-left-radius:4px;box-shadow:0 2px 12px rgba(28,105,212,0.12);overflow:hidden;width:100%;max-width:340px}
.booking-bubble-header{background:#1c69d4;padding:10px 14px;display:flex;align-items:center;gap:8px}
.booking-bubble-header span{color:#fff;font-size:13px;font-weight:700}
.booking-form{padding:14px;display:flex;flex-direction:column;gap:10px}
.bf-row{display:grid;grid-template-columns:1fr 1fr;gap:8px}
.bf-group{display:flex;flex-direction:column;gap:4px}
.bf-group label{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#888}
.bf-group label .req{color:#1c69d4}
.bf-group input,.bf-group select{padding:8px 10px;border:1px solid #dde3ef;border-radius:8px;font-size:13px;color:#1a1a1a;background:#f7f9fc;outline:none;transition:border-color .15s;width:100%}
.bf-group input:focus,.bf-group select:focus{border-color:#1c69d4;background:#fff}
.bf-group select{appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%23888' stroke-width='1.5' fill='none'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center;padding-right:28px}
.bf-time-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:5px}
.bf-time{padding:6px 4px;border:1px solid #dde3ef;border-radius:6px;font-size:11px;font-weight:600;text-align:center;cursor:pointer;color:#666;background:#f7f9fc;transition:all .15s}
.bf-time:hover{border-color:#1c69d4;color:#1c69d4}
.bf-time.active{background:#1c69d4;border-color:#1c69d4;color:#fff}
.bf-submit{padding:10px;background:#1c69d4;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s}
.bf-submit:hover:not(:disabled){background:#1555b0}
.bf-submit:disabled{opacity:.6;cursor:not-allowed}
.bf-error{font-size:11px;color:#e74c3c;font-weight:600;display:none;padding:6px 10px;background:#fff5f5;border-radius:6px;border-left:3px solid #e74c3c}
.bf-success{text-align:center;padding:20px 14px}
.bf-success .check{font-size:36px;margin-bottom:8px}
.bf-success h4{color:#1c69d4;font-size:14px;font-weight:700;margin-bottom:6px}
.bf-success p{color:#666;font-size:12px;line-height:1.6}
.bf-success .ref-code{display:inline-block;margin-top:10px;padding:6px 14px;background:#eef4ff;border:1px solid #c8d4e8;border-radius:6px;font-size:12px;font-weight:700;color:#1c69d4;letter-spacing:1px}

/* Error banner */
.err-banner{background:#fff5f5;border:1px solid #fca5a5;border-radius:10px;padding:10px 14px;font-size:12.5px;color:#dc2626;line-height:1.5}
</style>
</head>
<body>
<div id="app">
  <div id="hd">
    <div id="hd-logo">AX</div>
    <div class="dot"></div>
    <div id="hd-text">
      <div class="name">Auto X Advisor</div>
      <div class="sub">Trợ lý AI tư vấn xe · Đang trực tuyến</div>
    </div>
    <button id="hd-clear" onclick="clearSession()">Xóa chat</button>
  </div>

  <div id="ms"></div>
  <div id="qb"></div>

  <!-- Image preview strip (above input) -->
  <div id="img-preview-wrap">
    <img id="img-preview-thumb" src="" alt="">
    <button class="rm" onclick="clearImage()" title="Xóa ảnh">✕</button>
    <span style="font-size:12px;color:#6b7280">Ảnh đính kèm</span>
  </div>

  <div id="ir">
    <label id="img-btn" title="Gửi ảnh xe">
      <input type="file" id="img-input" accept="image/*" style="display:none" onchange="onImgPick(this)">
      <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="3" ry="3" stroke="#6b7280" stroke-width="2" fill="none"/><circle cx="8.5" cy="8.5" r="1.5" fill="#6b7280"/><path d="M21 15l-5-5L5 21" stroke="#6b7280" stroke-width="2" fill="none" stroke-linejoin="round"/></svg>
    </label>
    <input id="ui" placeholder="Nhập câu hỏi của bạn..." autocomplete="off"/>
    <button id="sb"><svg viewBox="0 0 24 24"><path d="M2 21l21-9L2 3v7l15 2-15 2z"/></svg></button>
  </div>
</div>

<script>
// ════════════════════════════════════════════════════════════
// CONFIG
// ════════════════════════════════════════════════════════════
var CHAT_URL    = '{{ route("chat.send") }}';
var IMG_URL     = '{{ route("chat.image") }}';
var CLEAR_URL   = '{{ route("chat.clear") }}';
var CARS_API    = '{{ url("/api/cars-data") }}';
var BOOKING_URL = '{{ route("booking.store") }}';
var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').content;
var CARS_KEY    = 'autox_cars_v1';
var SESS_KEY    = 'autox_session_id';
var DAT_LICH    = '{{ url("/services/dat-lich") }}';
var SHOWROOM    = 'Auto X';
var CARS_PAGE   = '{{ route("cars.index") }}';

var QUICK_DEFAULT = [
  'Xem tất cả xe', 'Bảng giá', 'Ngân sách dưới 5 tỷ',
  'SUV 7 chỗ', 'Xe điện', 'Đặt lịch lái thử'
];

var msDiv = document.getElementById('ms');
var qbDiv = document.getElementById('qb');
var uiEl  = document.getElementById('ui');
var sbEl  = document.getElementById('sb');

// ════════════════════════════════════════════════════════════
// SESSION ID (per-browser tab)
// ════════════════════════════════════════════════════════════
function _getSessionId() {
  var sid = sessionStorage.getItem(SESS_KEY);
  if (!sid) {
    sid = 'web_' + Math.random().toString(36).slice(2) + '_' + Date.now();
    sessionStorage.setItem(SESS_KEY, sid);
  }
  return sid;
}

// ════════════════════════════════════════════════════════════
// LOCAL CAR DATA (để hiển thị ảnh + quick fallback)
// ════════════════════════════════════════════════════════════
var _cars = [];

function _loadCars() {
  var CACHE_TTL = 5 * 60 * 1000;
  var cached   = localStorage.getItem(CARS_KEY);
  var cachedAt = parseInt(localStorage.getItem(CARS_KEY + '_ts') || '0');
  if (cached && (Date.now() - cachedAt) < CACHE_TTL) {
    try { _cars = JSON.parse(cached); return; } catch(_) {}
  }
  fetch(CARS_API)
    .then(function(r){ return r.json(); })
    .then(function(d){
      if (d.status === 'ok') {
        _cars = d.cars;
        localStorage.setItem(CARS_KEY, JSON.stringify(_cars));
        localStorage.setItem(CARS_KEY + '_ts', String(Date.now()));
      }
    })
    .catch(function(e){ console.warn('[Cars]', e); });
}

function _getCarImg(car) {
  if (car.image)     return car.image;
  if (car.thumbnail) return car.thumbnail;
  if (car.images && car.images.length) return car.images[0];
  if (car.slug)      return '/storage/cars/' + car.slug + '.jpg';
  return null;
}

function _findCar(name) {
  if (!name) return null;
  var q = name.toLowerCase().trim();
  return _cars.find(function(c){ return c.name.toLowerCase() === q; }) ||
    _cars.find(function(c){
      var n = c.name.toLowerCase();
      return n.includes(q) || q.includes(n);
    }) || null;
}

function _fmt(price) {
  if (!price) return 'Liên hệ';
  var p = Number(price);
  if (p >= 1e9) return (p/1e9).toFixed(2).replace(/\.?0+$/,'') + ' tỷ';
  if (p >= 1e6) return Math.round(p/1e6) + ' triệu';
  return p.toLocaleString('vi-VN') + ' VNĐ';
}

// ════════════════════════════════════════════════════════════
// IMAGE ATTACHMENT
// ════════════════════════════════════════════════════════════
var _pendingImg = null; // {b64, mediaType}

function onImgPick(input) {
  var file = input.files && input.files[0];
  if (!file) return;
  var reader = new FileReader();
  reader.onload = function(e) {
    var dataUrl = e.target.result;
    var match   = dataUrl.match(/^data:([^;]+);base64,(.+)$/);
    if (!match) return;
    _pendingImg = { b64: match[2], mediaType: match[1] };
    var wrap = document.getElementById('img-preview-wrap');
    document.getElementById('img-preview-thumb').src = dataUrl;
    wrap.style.display = 'flex';
    uiEl.placeholder   = 'Mô tả thêm về ảnh (hoặc Enter để gửi)...';
    uiEl.focus();
  };
  reader.readAsDataURL(file);
  input.value = '';
}

function clearImage() {
  _pendingImg = null;
  document.getElementById('img-preview-wrap').style.display = 'none';
  document.getElementById('img-preview-thumb').src = '';
  uiEl.placeholder = 'Nhập câu hỏi của bạn...';
}

// ════════════════════════════════════════════════════════════
// MARKDOWN-LITE PARSER
// ════════════════════════════════════════════════════════════
function _parseMarkdown(text) {
  if (!text) return '';
  return text
    .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
    .replace(/\*\*(.+?)\*\*/g,'<strong>$1</strong>')
    .replace(/\*(.+?)\*/g,'<em>$1</em>')
    .replace(/\[([^\]]+)\]\((https?:\/\/[^\)]+)\)/g,
      '<a href="$2" target="_blank" style="color:#1c69d4;text-decoration:underline">$1</a>')
    .replace(/\[([^\]]+)\]\((\/[^\)]+)\)/g,
      '<a href="$2" target="_blank" style="color:#1c69d4;text-decoration:underline">$1</a>')
    .replace(/(\/services\/dat-lich)/g,
      '<a href="$1" target="_blank" style="color:#1c69d4;font-weight:600">Đặt lịch lái thử</a>')
    .replace(/^[-•]\s+(.+)$/gm,'<span style="display:block;padding-left:10px">• $1</span>')
    .replace(/\n/g,'<br>');
}

// ════════════════════════════════════════════════════════════
// INJECT CAR IMAGES
// Chỉ inject khi bot nhắc tên xe trong ngữ cảnh tư vấn bình thường.
// KHÔNG inject khi response là thông báo xe không có trong kho
// hoặc so sánh thất bại (để tránh hiển thị card lẫn lộn với chữ).
// ════════════════════════════════════════════════════════════
var _NO_INJECT_PATTERNS = [
  'showroom không có',
  'chúng tôi không có',
  'không có trong kho',
  'không tìm thấy',
  'các xe đang có tại showroom',
  'các xe đang có',
  'xe đang có tại showroom',
];

function _injectCarImages(text, bubbleEl) {
  if (!_cars.length) return;

  // Không render card khi response báo không có xe / so sánh thất bại
  var textLower = text.toLowerCase();
  for (var pi = 0; pi < _NO_INJECT_PATTERNS.length; pi++) {
    if (textLower.indexOf(_NO_INJECT_PATTERNS[pi]) !== -1) return;
  }

  var mentioned = [];
  _cars.forEach(function(car){
    if (text.toLowerCase().indexOf(car.name.toLowerCase()) !== -1 && mentioned.length < 2) {
      var img = _getCarImg(car);
      if (img && !mentioned.find(function(c){ return c.id === car.id; })) {
        mentioned.push(car);
      }
    }
  });
  if (!mentioned.length) return;

  var row = document.createElement('div');
  row.style.cssText = 'display:flex;gap:8px;margin-top:10px;flex-wrap:wrap';
  mentioned.forEach(function(car){
    var img = _getCarImg(car);
    var priceStr = _fmt(car.min_price);
    if (car.max_price && car.max_price !== car.min_price) priceStr += ' – ' + _fmt(car.max_price);
    var card = document.createElement('div');
    card.className = 'car-img-card';
    card.onclick = function(){ send('Cho tôi biết chi tiết về ' + car.name); };
    card.innerHTML =
      '<img src="' + img + '" alt="' + car.name + '" onerror="this.parentElement.style.display=\'none\'">' +
      '<div class="car-img-card-body">' +
        '<div class="car-img-card-name">' + car.name + '</div>' +
        '<div class="car-img-card-price">Từ ' + priceStr + '</div>' +
      '</div>';
    row.appendChild(card);
  });
  bubbleEl.appendChild(row);

  // ── Link "Xem tất cả xe" ──────────────────────────────────
  var seeAll = document.createElement('div');
  seeAll.style.cssText = 'margin-top:8px';
  seeAll.innerHTML = '<a href="' + CARS_PAGE + '" class="see-all-cars" target="_blank">'
    + '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0">'
    + '<rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/>'
    + '<circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>'
    + 'Xem tất cả xe →</a>';
  bubbleEl.appendChild(seeAll);
}

// ════════════════════════════════════════════════════════════
// UI HELPERS
// ════════════════════════════════════════════════════════════
function _setEnabled(on) {
  uiEl.disabled = !on;
  sbEl.disabled = !on;
}

function _scrollBottom() {
  requestAnimationFrame(function(){ msDiv.scrollTop = msDiv.scrollHeight; });
}

function renderMsg(role, html, rawText) {
  var wrap = document.createElement('div');
  wrap.className = 'm ' + (role === 'bot' ? 'b' : 'u');
  var av = document.createElement('div');
  av.className = 'av';
  av.textContent = role === 'bot' ? 'AX' : 'Bạn';
  var bub = document.createElement('div');
  bub.className = 'bub';
  bub.innerHTML = html;

  if (role === 'bot' && rawText) {
    _injectCarImages(rawText, bub);
  }

  wrap.appendChild(av);
  wrap.appendChild(bub);
  msDiv.appendChild(wrap);
  _scrollBottom();
  return { wrap: wrap, bub: bub };
}

function addUserMsg(text) {
  renderMsg('user', _parseMarkdown(text), null);
}

function addBotMsg(text) {
  renderMsg('bot', _parseMarkdown(text), text);
}

function addErrMsg(text) {
  var wrap = document.createElement('div');
  wrap.className = 'm b';
  var av = document.createElement('div'); av.className = 'av'; av.textContent = 'AX';
  var bub = document.createElement('div'); bub.className = 'bub';
  bub.innerHTML = '<div class="err-banner">' + text + '</div>';
  wrap.appendChild(av); wrap.appendChild(bub);
  msDiv.appendChild(wrap);
  _scrollBottom();
}

function showTyping() {
  var wrap = document.createElement('div');
  wrap.className = 'm b'; wrap.id = 'typing-indicator';
  var av = document.createElement('div'); av.className = 'av'; av.textContent = 'AX';
  var bub = document.createElement('div'); bub.className = 'bub typing';
  bub.innerHTML = '<span></span><span></span><span></span>';
  wrap.appendChild(av); wrap.appendChild(bub);
  msDiv.appendChild(wrap);
  _scrollBottom();
}

function hideTyping() {
  var el = document.getElementById('typing-indicator');
  if (el) el.remove();
}

function setQuick(arr) {
  qbDiv.innerHTML = '';
  (arr || []).forEach(function(txt){
    var b = document.createElement('button');
    b.className = 'qb'; b.textContent = txt;
    b.onclick = function(){ send(txt); };
    qbDiv.appendChild(b);
  });
}

// ════════════════════════════════════════════════════════════
// BOOKING FORM
// ════════════════════════════════════════════════════════════
function renderBookingForm() {
  var wrap = document.createElement('div');
  wrap.className = 'm b';
  var av = document.createElement('div'); av.className = 'av'; av.textContent = 'AX';
  var bub = document.createElement('div');
  bub.className = 'bub';
  bub.style.cssText = 'padding:0;background:transparent;box-shadow:none';

  var carOptions = _cars.map(function(c){
    return '<option value="' + c.name + '">' + c.name + '</option>';
  }).join('');

  bub.innerHTML =
    '<div style="font-size:13.5px;line-height:1.7;padding:10px 14px 8px;background:#fff;border-radius:16px 16px 0 0;box-shadow:0 1px 4px rgba(0,0,0,0.08)">Vui lòng điền thông tin để đặt lịch lái thử:</div>' +
    '<div class="booking-bubble">' +
      '<div class="booking-bubble-header"><span>📅 Đặt lịch lái thử</span></div>' +
      '<div class="booking-form" id="bf-form">' +
        '<div class="bf-row">' +
          '<div class="bf-group"><label>Họ tên <span class="req">*</span></label><input type="text" id="bf-ten" placeholder="Nguyễn Văn A"></div>' +
          '<div class="bf-group"><label>Điện thoại <span class="req">*</span></label><input type="tel" id="bf-tel" placeholder="0909 123 456"></div>' +
        '</div>' +
        '<div class="bf-group"><label>Email <span class="req">*</span></label><input type="email" id="bf-email" placeholder="email@example.com"></div>' +
        '<div class="bf-row">' +
          '<div class="bf-group"><label>Ngày hẹn <span class="req">*</span></label><input type="date" id="bf-ngay"></div>' +
          '<div class="bf-group"><label>Dòng xe</label>' +
            '<select id="bf-xe"><option value="">-- Chọn xe --</option>' + carOptions + '</select>' +
          '</div>' +
        '</div>' +
        '<div class="bf-group"><label>Khung giờ</label>' +
          '<div class="bf-time-grid">' +
            ['8:00','9:00','10:00','13:30','14:00','15:00','16:00','17:00'].map(function(t,i){
              return '<div class="bf-time' + (i===0?' active':'') + '" onclick="bfTime(this)">' + t + '</div>';
            }).join('') +
          '</div>' +
        '</div>' +
        '<div class="bf-error" id="bf-error"></div>' +
        '<button class="bf-submit" id="bf-btn" onclick="bfSubmit()">✅ Xác nhận đặt lịch</button>' +
      '</div>' +
      '<div class="bf-success" id="bf-success" style="display:none">' +
        '<div class="check">🎉</div>' +
        '<h4>Đặt lịch thành công!</h4>' +
        '<p>Chúng tôi sẽ xác nhận qua điện thoại trong vòng 30 phút.</p>' +
        '<div class="ref-code" id="bf-ref"></div>' +
      '</div>' +
    '</div>';

  wrap.appendChild(av); wrap.appendChild(bub);
  msDiv.appendChild(wrap);
  _scrollBottom();

  var tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);
  var el = document.getElementById('bf-ngay');
  if (el) el.min = tomorrow.toISOString().split('T')[0];
}

function bfTime(el) {
  document.querySelectorAll('.bf-time').forEach(function(t){ t.classList.remove('active'); });
  el.classList.add('active');
}

function bfSubmit() {
  var ten   = (document.getElementById('bf-ten').value||'').trim();
  var tel   = (document.getElementById('bf-tel').value||'').trim();
  var email = (document.getElementById('bf-email').value||'').trim();
  var ngay  = (document.getElementById('bf-ngay').value||'').trim();
  var xe    = (document.getElementById('bf-xe').value||'').trim();
  var gio   = '';
  var at = document.querySelector('.bf-time.active');
  if (at) gio = at.textContent.trim();

  var errEl = document.getElementById('bf-error');
  errEl.style.display = 'none';
  if (!ten)                                { errEl.textContent='Vui lòng nhập họ tên.'; errEl.style.display='block'; return; }
  if (!tel||!/^[0-9]{10}$/.test(tel.replace(/\s/g,''))) { errEl.textContent='Số điện thoại phải đủ 10 chữ số.'; errEl.style.display='block'; return; }
  if (!email||!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { errEl.textContent='Email không hợp lệ.'; errEl.style.display='block'; return; }
  if (!ngay)                               { errEl.textContent='Vui lòng chọn ngày hẹn.'; errEl.style.display='block'; return; }

  var btn = document.getElementById('bf-btn');
  btn.disabled = true; btn.textContent = 'Đang gửi...';

  fetch(BOOKING_URL, {
    method: 'POST',
    headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF_TOKEN},
    body: JSON.stringify({ho_ten:ten,dien_thoai:tel,email:email,ngay:ngay,gio:gio,
      dich_vu:'laithu',chu_de:'Lái thử xe mới'+(xe?' — '+xe:''),
      hang_xe:xe,mau_xe:'',ghi_chu:'Đặt lịch qua chatbot'})
  })
  .then(function(r){ return r.json(); })
  .then(function(data){
    if (data.success) {
      document.getElementById('bf-form').style.display = 'none';
      document.getElementById('bf-success').style.display = 'block';
      document.getElementById('bf-ref').textContent = 'Mã lịch: ' + data.ref;
      _scrollBottom();
      setTimeout(function(){
        addBotMsg('Đã nhận lịch hẹn! Mã: **' + data.ref + '**\nNhân viên sẽ gọi xác nhận trong 30 phút.');
        setQuick(QUICK_DEFAULT);
      }, 1000);
    } else {
      btn.disabled = false; btn.textContent = '✅ Xác nhận đặt lịch';
      errEl.textContent = 'Có lỗi xảy ra, vui lòng thử lại.'; errEl.style.display = 'block';
    }
  })
  .catch(function(){
    btn.disabled = false; btn.textContent = '✅ Xác nhận đặt lịch';
    errEl.textContent = 'Không kết nối được, vui lòng thử lại.'; errEl.style.display = 'block';
  });
}

// ════════════════════════════════════════════════════════════
// CLEAR SESSION
// ════════════════════════════════════════════════════════════
function clearSession() {
  if (!confirm('Xóa toàn bộ lịch sử chat?')) return;
  fetch(CLEAR_URL, {
    method: 'POST',
    headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF_TOKEN},
    body: JSON.stringify({})
  }).catch(function(){});
  sessionStorage.removeItem(SESS_KEY);
  msDiv.innerHTML = '';
  addBotMsg('Xin chào! Tôi là trợ lý tư vấn xe của **' + SHOWROOM + '**. Bạn cần tìm hiểu về xe gì ạ?');
  setQuick(QUICK_DEFAULT);
}

// ════════════════════════════════════════════════════════════
// SEND
// ════════════════════════════════════════════════════════════
function send(txt) {
  var t = (txt !== undefined ? txt : uiEl.value).trim();
  if (!t && !_pendingImg) return;

  uiEl.value = '';
  setQuick([]);
  _setEnabled(false);

  if (!_pendingImg && /^đặt lịch|^lái thử$/i.test(t)) {
    addUserMsg(t);
    _setEnabled(true);
    renderBookingForm();
    setQuick(QUICK_DEFAULT);
    return;
  }

  var sessionId = _getSessionId();

  // ── Gửi ảnh ──────────────────────────────────────────────
  if (_pendingImg) {
    var imgData = _pendingImg;
    clearImage();
    if (t) addUserMsg(t);
    addUserMsg('[Đã gửi ảnh]');
    showTyping();

    fetch(IMG_URL, {
      method: 'POST',
      headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF_TOKEN},
      body: JSON.stringify({
        image_b64: imgData.b64,
        media_type: imgData.mediaType,
        message: t || ''
      })
    })
    .then(function(r){ return r.json(); })
    .then(function(data){
      hideTyping();
      if (data.response) {
        addBotMsg(data.response);
      } else {
        addErrMsg('Không phân tích được ảnh. Vui lòng thử lại.');
      }
      setQuick(QUICK_DEFAULT);
      _setEnabled(true);
    })
    .catch(function(e){
      hideTyping();
      addErrMsg('Lỗi kết nối khi gửi ảnh: ' + e.message);
      setQuick(QUICK_DEFAULT);
      _setEnabled(true);
    });
    return;
  }

  // ── Gửi text → AI ────────────────────────────────────────
  addUserMsg(t);
  showTyping();

  fetch(CHAT_URL, {
    method: 'POST',
    headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF_TOKEN},
    body: JSON.stringify({ message: t, session_id: sessionId })
  })
  .then(function(r){ return r.json(); })
  .then(function(data){
    hideTyping();
    if (data.response) {
      addBotMsg(data.response);
    } else if (data.error) {
      addErrMsg('Lỗi: ' + data.error);
    } else {
      addErrMsg('Không nhận được phản hồi từ server.');
    }
    setQuick(QUICK_DEFAULT);
    _setEnabled(true);
    uiEl.focus();
  })
  .catch(function(e){
    hideTyping();
    addErrMsg(
      'Không kết nối được đến server AI.<br>' +
      '<span style="font-size:11px;color:#999">Chi tiết: ' + e.message + '</span>'
    );
    setQuick(QUICK_DEFAULT);
    _setEnabled(true);
  });
}

// ════════════════════════════════════════════════════════════
// INIT
// ════════════════════════════════════════════════════════════
sbEl.onclick = function(){ send(); };
uiEl.addEventListener('keydown', function(e){
  if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); send(); }
});

window.addEventListener('load', function(){
  _loadCars();
  addBotMsg('Xin chào! Tôi là trợ lý tư vấn xe của **' + SHOWROOM + '**.\n\nTôi có thể giúp bạn tìm hiểu về **xe, giá, thông số, màu sắc** và **đặt lịch lái thử**. Bạn cần gì ạ?');
  setQuick(QUICK_DEFAULT);
  uiEl.focus();
});
</script>
</body>
</html>