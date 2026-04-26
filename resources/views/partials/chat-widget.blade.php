{{--
  AUTO X – Chat Widget Popup
  Lưu tại: resources/views/partials/chat-widget.blade.php
--}}

<style>
#ax-chat-overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 260px;
  width: 400px;
  height: 100vh;
  overflow: hidden;
  z-index: 8500;
  box-shadow: 6px 0 32px rgba(0,0,0,0.18);
  border-right: 1px solid #e8edf4;
  transition: left .28s ease;
  flex-direction: column;
}
#ax-chat-overlay.open         { display: flex; }
#ax-chat-overlay.sb-collapsed { left: 64px; }

#ax-chat-close-btn {
  position: fixed;
  top: 14px;
  left: calc(260px + 400px - 44px);
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background: rgba(255,255,255,0.18);
  border: none;
  cursor: pointer;
  display: none;
  align-items: center;
  justify-content: center;
  color: #8eafc8;
  font-size: 16px;
  line-height: 1;
  transition: background .15s, color .15s, left .28s ease;
  z-index: 9999;
}
#ax-chat-close-btn.visible      { display: flex; }
#ax-chat-close-btn:hover        { background: rgba(255,255,255,0.3); color: #fff; }
#ax-chat-close-btn.sb-collapsed { left: calc(64px + 400px - 44px); }

#ax-chat-overlay iframe {
  width: 100%;
  height: 100%;
  flex: 1;
  min-height: 0;
  border: none;
  display: block;
}

/* ══════════════════════════════════════════
   HIỆU ỨNG NÚT CHAT – VIETNAM AIRLINES STYLE
   ══════════════════════════════════════════ */

/* Wrapper bọc ngoài nút để chứa các vòng sóng */
#ax-chat-open-btn {
  position: relative;
  overflow: visible !important;
}

/* ── Vòng sóng ripple – đặt thẳng trên nút ── */
#ax-chat-open-btn::before,
#ax-chat-open-btn::after {
  content: '';
  position: absolute;
  inset: 0;
  border-radius: 28px;
  border: 1.5px solid rgba(255,255,255,0.55);
  opacity: 0;
  pointer-events: none;
  animation: ax-ripple 2.6s ease-out infinite;
  z-index: 0;
}
#ax-chat-open-btn::before { animation-delay: 0s; }
#ax-chat-open-btn::after  { animation-delay: 0.9s; }

/* Vòng thứ 3 */
.ax-chat-ring3 {
  position: absolute;
  inset: 0;
  border-radius: 28px;
  border: 1.5px solid rgba(255,255,255,0.30);
  opacity: 0;
  pointer-events: none;
  animation: ax-ripple 2.6s ease-out infinite;
  animation-delay: 1.8s;
  z-index: 0;
}

@keyframes ax-ripple {
  0%   { transform: scale(1);    opacity: 0.65; }
  100% { transform: scale(1.18); opacity: 0;    }
}

/* Glow nền nhấp nháy nhẹ */
@keyframes ax-glow {
  0%, 100% { box-shadow: 0 0 0 0 rgba(255,255,255,0.06); }
  50%       { box-shadow: 0 0 16px 5px rgba(255,255,255,0.12); }
}

/* Icon robot nhún nhẹ */
@keyframes ax-bob {
  0%, 100% { transform: translateY(0);    }
  50%       { transform: translateY(-3px); }
}

/* Chữ shimmer như logo Vietnam Airlines */
@keyframes ax-shimmer {
  0%   { background-position: -200% center; }
  100% { background-position:  200% center; }
}

#ax-chat-open-btn {
  animation: ax-glow 3s ease-in-out infinite !important;
}

#ax-chat-open-btn .sb-chat-avatar {
  animation: ax-bob 2.2s ease-in-out infinite;
}

#ax-chat-open-btn span {
  background: linear-gradient(
    90deg,
    #ffffff 0%,
    #ffffff 35%,
    #d4af6a 50%,
    #ffffff 65%,
    #ffffff 100%
  );
  background-size: 200% auto;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  animation: ax-shimmer 3.5s linear infinite;
  font-weight: 700 !important;
}

/* Khi hover – tắt shimmer, sáng solid */
#ax-chat-open-btn:hover span {
  background: none !important;
  -webkit-text-fill-color: #ffffff !important;
  color: #ffffff !important;
  animation: none !important;
}

/* Dot gõ phím – hiện khi chat đang mở */
#ax-chat-open-btn.is-open .sb-chat-avatar::after {
  content: '' !important;
  font-size: 0 !important;
}
#ax-chat-open-btn.is-open .sb-chat-avatar {
  animation: none;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 3px;
}
.ax-typing-dot {
  width: 5px; height: 5px;
  border-radius: 50%;
  background: #ffffff;
  animation: ax-typing 1.2s ease-in-out infinite;
  flex-shrink: 0;
}
.ax-typing-dot:nth-child(2) { animation-delay: 0.2s; }
.ax-typing-dot:nth-child(3) { animation-delay: 0.4s; }
@keyframes ax-typing {
  0%, 60%, 100% { transform: translateY(0);   opacity: 0.4; }
  30%            { transform: translateY(-5px); opacity: 1;   }
}
</style>

{{-- Nút X đặt NGOÀI div overlay để iframe không che --}}
<div id="ax-chat-overlay">
  <iframe
    src="{{ route('chat.index') }}"
    title="AUTO X Chat"
    allowtransparency="true"
  ></iframe>
</div>
<button id="ax-chat-close-btn" title="Đóng chat">✕</button>

<script>
(function () {
  var sidebar  = document.getElementById('ax-sidebar');
  var overlay  = document.getElementById('ax-chat-overlay');
  var openBtn  = document.getElementById('ax-chat-open-btn');
  var closeBtn = document.getElementById('ax-chat-close-btn');
  if (!overlay || !closeBtn) return;

  /* ── Inject vòng sóng thứ 3 + typing dots ── */
  if (openBtn) {
    var ring3 = document.createElement('span');
    ring3.className = 'ax-chat-ring3';
    openBtn.appendChild(ring3);

    /* Typing dots (ẩn mặc định, hiện khi chat mở) */
    var avatar = openBtn.querySelector('.sb-chat-avatar');
    if (avatar) {
      var d1 = document.createElement('span'); d1.className = 'ax-typing-dot';
      var d2 = document.createElement('span'); d2.className = 'ax-typing-dot';
      var d3 = document.createElement('span'); d3.className = 'ax-typing-dot';
      avatar.appendChild(d1);
      avatar.appendChild(d2);
      avatar.appendChild(d3);
    }
  }

  function syncPos() {
    var collapsed = sidebar && sidebar.classList.contains('collapsed');
    overlay.classList.toggle('sb-collapsed', collapsed);
    closeBtn.classList.toggle('sb-collapsed', collapsed);
  }

  function openChat() {
    syncPos();
    overlay.classList.add('open');
    closeBtn.classList.add('visible');
    if (openBtn) openBtn.classList.add('is-open');
  }

  function closeChat() {
    overlay.classList.remove('open');
    closeBtn.classList.remove('visible');
    if (openBtn) openBtn.classList.remove('is-open');
  }

  if (openBtn) {
    openBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      overlay.classList.contains('open') ? closeChat() : openChat();
    });
  }

  closeBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    closeChat();
  });

  var collapseBtn = document.getElementById('sb-collapse-btn');
  if (collapseBtn) {
    collapseBtn.addEventListener('click', function () {
      setTimeout(syncPos, 300);
    });
  }

  document.addEventListener('click', function (e) {
    if (overlay.classList.contains('open')
        && !overlay.contains(e.target)
        && !closeBtn.contains(e.target)
        && openBtn && !openBtn.contains(e.target)) {
      closeChat();
    }
  });
})();
</script>