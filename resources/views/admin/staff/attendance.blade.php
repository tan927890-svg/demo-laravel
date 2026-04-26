@extends('layouts.admin')
@section('page-title', 'Chấm công GPS')

@section('content')

@if(session('success'))
  <div class="alert alert-success" style="margin-bottom:16px">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-error" style="margin-bottom:16px">{{ session('error') }}</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;align-items:start">

  {{-- Chấm công hôm nay --}}
  <div class="card card-pad">
    <div style="font-weight:600;font-size:15px;margin-bottom:4px">📍 Chấm công hôm nay</div>
    <div style="font-size:12px;color:var(--text-muted);margin-bottom:18px">
      {{ now()->format('l, d/m/Y') }}
    </div>

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

    @if($record)
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:16px">
      <div style="padding:12px;background:var(--bg);border-radius:8px">
        <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px">CHECK-IN</div>
        @if($record->check_in_at)
          <div style="font-weight:700;font-size:20px;color:var(--success)">
            {{ $record->check_in_at->format('H:i') }}
          </div>
          <div style="font-size:11px;color:var(--text-muted);margin-top:2px">
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
          <div style="font-size:11px;color:var(--text-muted);margin-top:2px">
            {{ $record->check_out_address ?? 'Không có địa chỉ' }}
          </div>
        @else
          <div style="color:var(--text-muted)">—</div>
        @endif
      </div>
    </div>
    @endif

    <div id="gps-status" style="padding:10px 14px;background:var(--bg);border-radius:8px;font-size:13px;color:var(--text-muted);text-align:center;margin-bottom:14px">
      ⏳ Đang lấy vị trí GPS...
    </div>

    @if(!$record || !$record->check_in_at)
    <form id="checkin-form" method="POST" action="{{ route('admin.staff.attendance.checkin') }}">
      @csrf
      <input type="hidden" name="lat"     id="lat-in">
      <input type="hidden" name="lng"     id="lng-in">
      <input type="hidden" name="address" id="addr-in">
      <button type="submit" id="btn-checkin" class="btn" disabled
              style="width:100%;justify-content:center;background:#16a34a;color:#fff;font-size:15px;padding:12px;border:none;border-radius:8px;cursor:pointer;opacity:.5">
        📍 Check-in
      </button>
    </form>

    @elseif($record && $record->check_in_at && !$record->check_out_at)
    <form id="checkout-form" method="POST" action="{{ route('admin.staff.attendance.checkout') }}">
      @csrf
      <input type="hidden" name="lat"     id="lat-out">
      <input type="hidden" name="lng"     id="lng-out">
      <input type="hidden" name="address" id="addr-out">
      <button type="submit" id="btn-checkout" class="btn" disabled
              style="width:100%;justify-content:center;background:#dc2626;color:#fff;font-size:15px;padding:12px;border:none;border-radius:8px;cursor:pointer;opacity:.5">
        📍 Check-out
      </button>
    </form>
    @endif

  </div>

  {{-- Lịch sử chấm công --}}
  <div class="card">
    <div style="padding:14px 18px;border-bottom:1px solid var(--border);font-weight:600">
      📅 Lịch sử 30 ngày gần nhất
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>Ngày</th>
          <th>Check-in</th>
          <th>Check-out</th>
          <th>Giờ làm</th>
        </tr>
      </thead>
      <tbody>
        @forelse($history as $h)
        <tr>
          <td style="font-size:13px">{{ $h->work_date->format('d/m/Y') }}</td>
          <td style="color:var(--success);font-weight:600">
            {{ $h->check_in_at ? $h->check_in_at->format('H:i') : '—' }}
          </td>
          <td style="color:var(--danger)">
            {{ $h->check_out_at ? $h->check_out_at->format('H:i') : '—' }}
          </td>
          <td>
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

@push('scripts')
<script>
// ✅ Dùng config() thay env() — an toàn, có cache
const OFFICE_LAT    = {{ config('app.office.lat') }};
const OFFICE_LNG    = {{ config('app.office.lng') }};
const OFFICE_RADIUS = {{ config('app.office.radius', 150) }};

// Phát hiện iOS để điều chỉnh timeout
const isIOS = /iPhone|iPad|iPod/.test(navigator.userAgent);

function getDistance(lat1, lng1, lat2, lng2) {
  const R = 6371000;
  const dLat = (lat2 - lat1) * Math.PI / 180;
  const dLng = (lng2 - lng1) * Math.PI / 180;
  const a = Math.sin(dLat/2) * Math.sin(dLat/2)
          + Math.cos(lat1 * Math.PI/180) * Math.cos(lat2 * Math.PI/180)
          * Math.sin(dLng/2) * Math.sin(dLng/2);
  return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
}

function enableBtn(id) {
  const btn = document.getElementById(id);
  if (btn) { btn.disabled = false; btn.style.opacity = '1'; }
}

function setStatus(html, color) {
  const el = document.getElementById('gps-status');
  if (el) { el.innerHTML = html; el.style.color = color || ''; }
}

if (navigator.geolocation) {
  setStatus('⏳ Đang lấy vị trí GPS' + (isIOS ? ' (iOS có thể mất 10–15 giây)...' : '...'));

  navigator.geolocation.getCurrentPosition(
    async function(pos) {
      const lat  = pos.coords.latitude;
      const lng  = pos.coords.longitude;
      const dist = Math.round(getDistance(lat, lng, OFFICE_LAT, OFFICE_LNG));

      // Điền tọa độ vào form
      ['lat-in','lat-out'].forEach(id => { const e = document.getElementById(id); if(e) e.value = lat; });
      ['lng-in','lng-out'].forEach(id => { const e = document.getElementById(id); if(e) e.value = lng; });

      // Reverse geocode lấy địa chỉ
      let address = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
      try {
        const res  = await fetch(
          `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`,
          { headers: { 'Accept-Language': 'vi' } }
        );
        const data = await res.json();
        if (data.display_name) address = data.display_name;
      } catch(e) {}

      ['addr-in','addr-out'].forEach(id => { const e = document.getElementById(id); if(e) e.value = address; });

      if (dist <= OFFICE_RADIUS) {
        setStatus(`✅ Bạn đang ở trong văn phòng <strong>(cách ${dist}m)</strong>`, '#16a34a');
        enableBtn('btn-checkin');
        enableBtn('btn-checkout');
      } else {
        setStatus(
          `❌ Bạn đang cách văn phòng <strong>${dist}m</strong> — cần ở trong vòng <strong>${OFFICE_RADIUS}m</strong> để chấm công`,
          '#dc2626'
        );
        // Nút giữ nguyên disabled
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
      setStatus(msg, '#dc2626');
    },
    {
      enableHighAccuracy: true,
      timeout:    isIOS ? 15000 : 10000, // iOS GPS khởi động chậm hơn
      maximumAge: 0                       // Không dùng cache vị trí cũ
    }
  );
} else {
  setStatus('❌ Trình duyệt không hỗ trợ GPS.', '#dc2626');
}
</script>
@endpush

@endsection