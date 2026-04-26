@extends('layouts.admin')
@section('page-title', 'Thông báo nội bộ')

@section('topbar-actions')
  <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary btn-sm">+ Tạo thông báo</a>
@endsection

@section('content')

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- ===== SOUND TOGGLE BUTTON ===== --}}
<div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
  <button id="soundToggleBtn" onclick="toggleSound()"
    style="display:inline-flex;align-items:center;gap:7px;
           padding:7px 16px;border-radius:30px;border:1.5px solid var(--border,#e2e8f0);
           background:var(--bg-card,#fff);cursor:pointer;font-size:13px;font-weight:600;
           color:var(--text-1,#1e293b);transition:all .2s;box-shadow:0 1px 4px rgba(0,0,0,.06)">
    <span id="soundIcon" style="font-size:16px">🔔</span>
    <span id="soundLabel">Âm thanh: Bật</span>
  </button>
  <span style="font-size:12px;color:var(--text-3,#94a3b8)">
    Phát âm khi có thông báo mới
  </span>
</div>

<div class="card">
  <table class="table">
    <thead>
      <tr>
        <th>Loại</th>
        <th>Tiêu đề</th>
        <th>Nội dung</th>
        <th>Gửi đến</th>
        <th>Người gửi</th>
        <th>Thời gian</th>
        @if(auth()->user()->isAdmin()) <th></th> @endif
      </tr>
    </thead>
    <tbody>
      @forelse($notifications as $n)
      <tr>
        <td>
          @php
            $colors = ['info'=>'#dbeafe','warning'=>'#fef3c7','success'=>'#dcfce7','urgent'=>'#fee2e2'];
            $texts  = ['info'=>'#1d4ed8','warning'=>'#92400e','success'=>'#15803d','urgent'=>'#dc2626'];
          @endphp
          <span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700;
            background:{{ $colors[$n->type] }};color:{{ $texts[$n->type] }}">
            {{ $n->typeIcon() }} {{ ucfirst($n->type) }}
          </span>
        </td>
        <td style="font-weight:600">{{ $n->title }}</td>
        <td style="color:var(--text-2);font-size:13px;max-width:300px">
          {{ Str::limit($n->body, 80) }}
        </td>
        <td style="font-size:13px">
          @if(!$n->target_role || $n->target_role === 'all') Tất cả
          @elseif($n->target_role === 'staff') Nhân viên
          @elseif($n->target_role === 'manager') Manager
          @endif
        </td>
        <td style="font-size:13px">{{ $n->creator->name ?? '—' }}</td>
        <td style="font-size:12px;color:var(--text-3)">{{ $n->created_at->format('d/m/Y H:i') }}</td>
        @if(auth()->user()->isAdmin())
        <td>
          <form method="POST" action="{{ route('admin.notifications.destroy', $n) }}"
            onsubmit="return confirm('Xóa thông báo này?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Xóa</button>
          </form>
        </td>
        @endif
      </tr>
      @empty
      <tr>
        <td colspan="7" style="text-align:center;padding:40px;color:var(--text-3)">Chưa có thông báo nào</td>
      </tr>
      @endforelse
    </tbody>
  </table>
  @if($notifications->hasPages())
  <div style="padding:14px 18px;border-top:1px solid var(--border)">
    {{ $notifications->links() }}
  </div>
  @endif
</div>

{{-- ===== SOUND SYSTEM ===== --}}
<script>
(function () {

  var soundEnabled = localStorage.getItem('notif_sound') !== 'off';
  var audioCtx     = null;
  var pendingPlay  = false; // chờ gesture để phát

  updateBtn();

  // ── Tạo / lấy AudioContext ───────────────────────────────────────────────
  function getCtx() {
    if (!audioCtx) {
      audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    }
    // Một số trình duyệt suspend context nếu chưa có gesture
    if (audioCtx.state === 'suspended') {
      audioCtx.resume();
    }
    return audioCtx;
  }

  // ── Phát âm ─────────────────────────────────────────────────────────────
  function playNotifSound(type) {
    if (!soundEnabled) return;
    var ctx = getCtx();

    if (ctx.state === 'suspended') {
      // Chưa unlock → đánh dấu chờ, phát khi unlock
      pendingPlay = type;
      return;
    }

    var presets = {
      info:    { freqs: [660, 880],      gap: 0.30, dur: 0.70, vol: 0.13 },
      success: { freqs: [740, 988],      gap: 0.30, dur: 0.70, vol: 0.13 },
      warning: { freqs: [550, 494],      gap: 0.32, dur: 0.75, vol: 0.14 },
      urgent:  { freqs: [660, 740, 880], gap: 0.28, dur: 0.60, vol: 0.15 }
    };

    var p   = presets[type] || presets.info;
    var now = ctx.currentTime;

    p.freqs.forEach(function(freq, i) {
      var osc  = ctx.createOscillator();
      var gain = ctx.createGain();
      var t    = now + i * (p.dur * 0.52 + p.gap);

      osc.type = 'sine';
      osc.frequency.setValueAtTime(freq, t);

      gain.gain.setValueAtTime(0,      t);
      gain.gain.linearRampToValueAtTime(p.vol, t + 0.08);
      gain.gain.setValueAtTime(p.vol,          t + 0.13);
      gain.gain.exponentialRampToValueAtTime(0.001, t + p.dur);

      osc.connect(gain);
      gain.connect(ctx.destination);
      osc.start(t);
      osc.stop(t + p.dur + 0.12);
    });
  }

  // ── Unlock AudioContext khi có bất kỳ tương tác nào ─────────────────────
  // Bắt TẤT CẢ các gesture có thể xảy ra sau khi trang load
  function onFirstInteraction() {
    var ctx = getCtx();
    ctx.resume().then(function() {
      if (pendingPlay) {
        // Có âm thanh đang chờ → phát ngay
        var type = pendingPlay;
        pendingPlay = false;
        setTimeout(function() { playNotifSound(type); }, 100);
      }
    });
    // Gỡ tất cả listener sau lần đầu
    ['click','mousedown','keydown','touchstart','scroll','mousemove'].forEach(function(ev) {
      document.removeEventListener(ev, onFirstInteraction);
    });
  }

  ['click','mousedown','keydown','touchstart','scroll','mousemove'].forEach(function(ev) {
    document.addEventListener(ev, onFirstInteraction, { once: true, passive: true });
  });

  // ── Phát khi vào trang — áp dụng tất cả role (staff / manager / admin) ──
  var hasNotifs  = {{ $notifications->count() > 0 ? 'true' : 'false' }};
  var latestType = '{{ $notifications->count() > 0 ? $notifications->first()->type : "info" }}';
  // sessionKey theo ID → tự reset khi có thông báo mới hơn
  var sessionKey = 'notif_played_{{ $notifications->count() > 0 ? $notifications->first()->id : 0 }}';

  if (hasNotifs && !sessionStorage.getItem(sessionKey)) {
    sessionStorage.setItem(sessionKey, '1');
    // Thử phát ngay, nếu context chưa unlock thì pendingPlay sẽ giữ lại
    playNotifSound(latestType);
  }

  // ── Toggle bật / tắt ─────────────────────────────────────────────────────
  window.toggleSound = function() {
    soundEnabled = !soundEnabled;
    localStorage.setItem('notif_sound', soundEnabled ? 'on' : 'off');
    updateBtn();
    if (soundEnabled) playNotifSound('success');
  };

  function updateBtn() {
    var icon  = document.getElementById('soundIcon');
    var label = document.getElementById('soundLabel');
    var btn   = document.getElementById('soundToggleBtn');
    if (!icon || !label || !btn) return;
    if (soundEnabled) {
      icon.textContent  = '🔔';
      label.textContent = 'Âm thanh: Bật';
      btn.style.borderColor = 'var(--primary, #3b82f6)';
      btn.style.color       = 'var(--primary, #3b82f6)';
    } else {
      icon.textContent  = '🔕';
      label.textContent = 'Âm thanh: Tắt';
      btn.style.borderColor = 'var(--border, #e2e8f0)';
      btn.style.color       = 'var(--text-3, #94a3b8)';
    }
  }

  // ── Polling 30 giây: phát khi có thông báo mới trong lúc đang dùng ───────
  @if($notifications->count())
  var lastSeenId = {{ $notifications->first()->id }};
  @else
  var lastSeenId = 0;
  @endif

  function pollNewNotifications() {
    fetch('/admin/notifications/latest?after=' + lastSeenId, {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function(res) { return res.ok ? res.json() : null; })
    .then(function(data) {
      if (data && data.id && data.id > lastSeenId) {
        lastSeenId = data.id;
        playNotifSound(data.type || 'info');
        showNewBadge();
      }
    })
    .catch(function() {});
  }

  function showNewBadge() {
    var btn = document.getElementById('soundToggleBtn');
    if (!btn) return;
    var old = btn.querySelector('.notif-badge');
    if (old) old.remove();
    var badge = document.createElement('span');
    badge.className  = 'notif-badge';
    badge.textContent = '● Mới';
    badge.style.cssText = 'position:absolute;top:-6px;right:-6px;background:#ef4444;color:#fff;' +
      'font-size:10px;font-weight:700;padding:2px 6px;border-radius:20px;animation:fadeInPop .3s ease';
    btn.style.position = 'relative';
    btn.appendChild(badge);
    setTimeout(function() { badge.remove(); }, 8000);
  }

  setTimeout(function() {
    pollNewNotifications();
    setInterval(pollNewNotifications, 30000);
  }, 5000);

})();
</script>

<style>
@keyframes fadeInPop {
  from { opacity:0; transform:scale(.5); }
  to   { opacity:1; transform:scale(1); }
}
</style>

@endsection