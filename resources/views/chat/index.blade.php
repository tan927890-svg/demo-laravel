<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AUTO X Chat</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;overflow:hidden}
body{font-family:'Segoe UI',sans-serif;background:#f0f2f5}

#app{
  position:absolute;
  top:0;left:0;right:0;bottom:0;
  display:flex;
  flex-direction:column;
  background:#fff;
  overflow:hidden;
}

/* Header */
#hd{
  background:#0d2137;
  padding:14px 18px;
  display:flex;
  align-items:center;
  gap:12px;
  flex-shrink:0;
  min-height:64px;
}
#hd .dot{width:9px;height:9px;border-radius:50%;background:#4ade80;flex-shrink:0}
#hd-logo{width:38px;height:38px;border-radius:50%;background:#1c3557;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#5b9ff5;border:1.5px solid #2a4a6a;flex-shrink:0;font-family:'Nunito',sans-serif}
#hd-text .name{color:#fff;font-size:15px;font-weight:600;font-family:'Nunito',sans-serif}
#hd-text .sub{color:#8eafc8;font-size:12px}

/* Messages */
#ms{
  flex:1;
  min-height:0;
  overflow-y:auto;
  overflow-x:hidden;
  padding:14px;
  display:flex;
  flex-direction:column;
  gap:10px;
  background:#f7f9fc;
}
#ms::-webkit-scrollbar{width:4px}
#ms::-webkit-scrollbar-thumb{background:#d0d7e3;border-radius:4px}

.m{display:flex;gap:8px;align-items:flex-end;max-width:88%}
.m.u{align-self:flex-end;flex-direction:row-reverse}
.av{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:600;flex-shrink:0;font-family:'Nunito',sans-serif}
.m.b .av{background:#0d2137;color:#8eafc8}
.m.u .av{background:#1c69d4;color:#fff}
.bub{padding:10px 14px;border-radius:16px;font-size:13.5px;line-height:1.7;max-width:100%;word-break:break-word}
.m.b .bub{background:#fff;color:#1a1a1a;border-bottom-left-radius:4px;box-shadow:0 1px 4px rgba(0,0,0,0.08)}
.m.u .bub{background:#1c69d4;color:#fff;border-bottom-right-radius:4px}

/* Typing indicator */
.typing{display:flex;gap:4px;padding:12px 14px;align-items:center}
.typing span{width:7px;height:7px;border-radius:50%;background:#b0bec5;animation:bounce 1.2s infinite}
.typing span:nth-child(2){animation-delay:.2s}
.typing span:nth-child(3){animation-delay:.4s}
@keyframes bounce{0%,60%,100%{transform:translateY(0)}30%{transform:translateY(-6px)}}

/* Quick buttons */
#qb{
  display:flex;
  flex-wrap:wrap;
  gap:6px;
  padding:8px 14px 10px;
  background:#f7f9fc;
  border-top:1px solid #eef0f4;
  flex-shrink:0;
}
#qb:empty{display:none}
.qb{font-size:12px;padding:6px 12px;border:1px solid #c8d4e8;border-radius:20px;background:#fff;color:#1c69d4;cursor:pointer;transition:all .15s;font-weight:500;font-family:'Segoe UI',sans-serif}
.qb:hover{background:#1c69d4;color:#fff;border-color:#1c69d4}

/* Input row */
#ir{
  display:flex;
  gap:8px;
  padding:10px 12px;
  border-top:1px solid #eef0f4;
  background:#fff;
  flex-shrink:0;
}
#ui{flex:1;font-size:13.5px;padding:9px 14px;border:1px solid #dde3ef;border-radius:22px;background:#f7f9fc;color:#1a1a1a;outline:none;transition:border-color .15s;font-family:'Segoe UI',sans-serif}
#ui:focus{border-color:#1c69d4;background:#fff}
#ui:disabled{opacity:.6;cursor:not-allowed}
#sb{width:36px;height:36px;border-radius:50%;background:#1c69d4;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:background .15s}
#sb:hover{background:#1555b0}
#sb:disabled{background:#b0bec5;cursor:not-allowed}
#sb svg{width:14px;height:14px;fill:#fff}
</style>
</head>
<body>
<div id="app">
  <div id="hd">
    <div id="hd-logo">AX</div>
    <div class="dot"></div>
    <div id="hd-text">
      <div class="name">AUTO X Advisor</div>
      <div class="sub">Trợ lý AI · Đang trực tuyến</div>
    </div>
  </div>

  <div id="ms"></div>
  <div id="qb"></div>

  <div id="ir">
    <input id="ui" placeholder="Nhập câu hỏi của bạn..." autocomplete="off"/>
    <button id="sb"><svg viewBox="0 0 24 24"><path d="M2 21l21-9L2 3v7l15 2-15 2z"/></svg></button>
  </div>
</div>

<script>
var API_URL = 'http://127.0.0.1:8000/api/chat';

var msDiv = document.getElementById('ms');
var qbDiv = document.getElementById('qb');
var uiEl  = document.getElementById('ui');
var sbEl  = document.getElementById('sb');

var QUICK_DEFAULT = ['Xem tất cả xe', 'Ngân sách dưới 5 tỷ', 'SUV 7 chỗ', 'Xe điện', 'Liên hệ showroom'];

function addMsg(role, html) {
  var wrap = document.createElement('div');
  wrap.className = 'm ' + (role === 'bot' ? 'b' : 'u');
  var av = document.createElement('div');
  av.className = 'av';
  av.textContent = role === 'bot' ? 'AX' : 'Bạn';
  var bub = document.createElement('div');
  bub.className = 'bub';
  bub.innerHTML = html;
  wrap.appendChild(av);
  wrap.appendChild(bub);
  msDiv.appendChild(wrap);
  requestAnimationFrame(function() { msDiv.scrollTop = msDiv.scrollHeight; });
  return wrap;
}

function showTyping() {
  var wrap = document.createElement('div');
  wrap.className = 'm b';
  wrap.id = 'typing-indicator';
  var av = document.createElement('div');
  av.className = 'av';
  av.textContent = 'AX';
  var bub = document.createElement('div');
  bub.className = 'bub typing';
  bub.innerHTML = '<span></span><span></span><span></span>';
  wrap.appendChild(av);
  wrap.appendChild(bub);
  msDiv.appendChild(wrap);
  msDiv.scrollTop = msDiv.scrollHeight;
}

function hideTyping() {
  var el = document.getElementById('typing-indicator');
  if (el) el.remove();
}

function setQuick(arr) {
  qbDiv.innerHTML = '';
  (arr || []).forEach(function(txt) {
    var b = document.createElement('button');
    b.className = 'qb';
    b.textContent = txt;
    b.onclick = function() { send(txt); };
    qbDiv.appendChild(b);
  });
}

function setLoading(on) {
  uiEl.disabled = on;
  sbEl.disabled = on;
}

function send(txt) {
  var t = (txt || uiEl.value).trim();
  if (!t) return;
  uiEl.value = '';
  setQuick([]);
  addMsg('user', t);
  setLoading(true);
  showTyping();

  fetch(API_URL, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ message: t })
  })
  .then(function(r) {
    if (!r.ok) throw new Error('Lỗi server: ' + r.status);
    return r.json();
  })
  .then(function(data) {
    hideTyping();
    if (data.status === 'success') {
      // Chuyển \n thành <br> cho đẹp
      var html = data.response
        .replace(/&/g,'&amp;')
        .replace(/</g,'&lt;')
        .replace(/>/g,'&gt;')
        .replace(/\n/g,'<br>');
      addMsg('bot', html);
      setQuick(QUICK_DEFAULT);
    } else {
      addMsg('bot', '⚠️ Có lỗi xảy ra, vui lòng thử lại.');
      setQuick(QUICK_DEFAULT);
    }
  })
  .catch(function(err) {
    hideTyping();
    addMsg('bot', '⚠️ Không kết nối được server AI. Vui lòng thử lại sau.<br><small style="color:#aaa">'+err.message+'</small>');
    setQuick(QUICK_DEFAULT);
  })
  .finally(function() {
    setLoading(false);
    uiEl.focus();
  });
}

sbEl.onclick = function() { send(); };
uiEl.addEventListener('keydown', function(e) { if (e.key === 'Enter' && !e.shiftKey) send(); });

window.addEventListener('load', function() {
  addMsg('bot', 'Xin chào Quý khách! Tôi là trợ lý AI của <b>AUTO X Showroom</b>.<br><br>Tôi có thể hỗ trợ về <b>xe, giá, phiên bản</b> và <b>đặt lịch lái thử</b>. Bạn cần gì ạ?');
  setQuick(QUICK_DEFAULT);
});
</script>
</body>
</html>