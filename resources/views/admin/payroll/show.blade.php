@extends('layouts.admin')

@section('title', 'Bảng lương — ' . $user->name)
@section('page-title', 'Chi tiết bảng lương — ' . $user->name)

@section('topbar-actions')
  <a href="{{ route('admin.payroll.index', ['month' => $payroll->month, 'year' => $payroll->year]) }}"
     class="btn btn-sm">← Quay lại</a>

  @if(auth()->user()->isAdmin() && $payroll->status !== 'approved')
    <form method="POST" action="{{ route('admin.payroll.approve', $payroll) }}"
          id="form-approve" style="display:inline" onsubmit="return false">
      @csrf
      <button type="button" class="btn btn-primary btn-sm"
              onclick="showPayrollConfirm('Chốt bảng lương','Xác nhận chốt lương tháng {{ $payroll->month }}/{{ $payroll->year }} cho <b>{{ $user->name }}</b>?','✅ Chốt lương','primary','form-approve')">
        ✅ Chốt lương
      </button>
    </form>
  @elseif(auth()->user()->isAdmin() && $payroll->status === 'approved')
    <form method="POST" action="{{ route('admin.payroll.reopen', $payroll) }}"
          id="form-reopen" style="display:inline" onsubmit="return false">
      @csrf
      <button type="button" class="btn btn-sm"
              onclick="showPayrollConfirm('Mở lại bảng lương','Bảng lương của <b>{{ $user->name }}</b> sẽ được mở lại để tính lại.','🔓 Mở lại','warning','form-reopen')">
        🔓 Mở lại
      </button>
    </form>
  @endif
@endsection

@section('content')

@if(session('success'))
  <div class="alert alert-success flash" style="margin-bottom:16px">{{ session('success') }}</div>
@endif

@php
  $base         = $payroll->base_salary        ?? 0;
  $commission   = $payroll->total_commission   ?? 0;
  $kpiBonus     = $payroll->kpi_bonus          ?? 0;
  $kpiPercent   = $payroll->kpi_percent        ?? 0;
  $total        = $payroll->total_salary       ?? 0;
  $validDays    = $payroll->valid_days         ?? 0;
  $workingDays  = $payroll->working_days       ?? 30;

  // Lương cứng thực tế sau tính ngày công
  $attendanceSalary = $workingDays > 0 ? round(($validDays / $workingDays) * $base) : 0;

  // Tăng ca — dùng đúng tên cột từ migration
  $overtimeHours    = $payroll->overtime_hours      ?? 0;
  $overtimeRate     = $payroll->overtime_rate       ?? 0;
  $overtimeAllowance = $payroll->overtime_allowance ?? 0;
@endphp

{{-- Thông tin nhân viên --}}
<div class="card card-pad" style="margin-bottom:16px;display:flex;align-items:center;gap:14px;flex-wrap:wrap">
  <div style="width:46px;height:46px;font-size:16px;border-radius:50%;background:var(--accent);color:#fff;
              display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0">
    {{ strtoupper(substr($user->name, 0, 2)) }}
  </div>
  <div style="flex:1;min-width:0">
    <div style="font-size:15px;font-weight:600">{{ $user->name }}</div>
    <div style="font-size:12px;color:var(--text-3)">{{ $user->email }}</div>
  </div>
  <div style="display:flex;gap:8px;align-items:center;flex-shrink:0">
    <span class="badge badge-gray">{{ ucfirst($user->role ?? 'staff') }}</span>
    @php
      $statusStyle = match($payroll->status) {
        'approved' => ['label' => '✅ Đã chốt', 'color' => '#166534', 'bg' => '#dcfce7'],
        'draft'    => ['label' => '📝 Nháp',    'color' => '#92400e', 'bg' => '#fef3c7'],
        default    => ['label' => ucfirst($payroll->status), 'color' => '#555', 'bg' => '#f3f4f6'],
      };
    @endphp
    <span style="padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;
                 color:{{ $statusStyle['color'] }};background:{{ $statusStyle['bg'] }}">
      {{ $statusStyle['label'] }}
    </span>
  </div>
</div>

{{-- Kỳ lương --}}
<div class="card card-pad" style="margin-bottom:16px">
  <div style="font-size:14px;font-weight:700;margin-bottom:14px">📅 Kỳ lương</div>
  <div style="display:flex;gap:24px;flex-wrap:wrap">
    <div>
      <div style="font-size:12px;color:var(--text-3)">Tháng / Năm</div>
      <div style="font-size:15px;font-weight:600">Tháng {{ $payroll->month }} / {{ $payroll->year }}</div>
    </div>
    @if($payroll->approver)
    <div>
      <div style="font-size:12px;color:var(--text-3)">Người chốt</div>
      <div style="font-size:15px;font-weight:600">{{ $payroll->approver->name }}</div>
    </div>
    @endif
    @if($payroll->approved_at)
    <div>
      <div style="font-size:12px;color:var(--text-3)">Ngày chốt</div>
      <div style="font-size:15px;font-weight:600">{{ \Carbon\Carbon::parse($payroll->approved_at)->format('d/m/Y H:i') }}</div>
    </div>
    @endif
    @if($payroll->note)
    <div>
      <div style="font-size:12px;color:var(--text-3)">Ghi chú</div>
      <div style="font-size:14px">{{ $payroll->note }}</div>
    </div>
    @endif
  </div>
</div>

{{-- Nhập lương cứng (chỉ admin, chưa chốt) --}}
@if(auth()->user()->isAdmin() && $payroll->status !== 'approved')
<div class="card card-pad" style="margin-bottom:16px">
  <div style="font-size:14px;font-weight:700;margin-bottom:14px">💰 Nhập lương cứng</div>
  <form method="POST" action="{{ route('admin.payroll.updateBaseSalary', $payroll) }}">
    @csrf
    @method('PATCH')
    <div style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap">
      <div style="flex:1;min-width:180px">
        <label style="font-size:12px;color:var(--text-3);display:block;margin-bottom:6px">
          Lương cứng (VNĐ)
        </label>
        <input
          type="number"
          name="base_salary"
          value="{{ old('base_salary', $payroll->base_salary ?? 0) }}"
          min="0"
          step="100000"
          class="form-control"
          style="width:100%;padding:8px 12px;border:1px solid var(--border);border-radius:8px;font-size:15px"
          placeholder="Ví dụ: 8000000"
        >
        @error('base_salary')
          <div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>
        @enderror
      </div>
      <button type="submit" class="btn btn-primary btn-sm" style="white-space:nowrap;padding:8px 20px">
        💾 Lưu & tính lại lương
      </button>
    </div>
  </form>

  {{-- Hiển thị ngày công sau khi có lương cứng --}}
  @if($base > 0)
  <div style="margin-top:16px;padding:14px 16px;border-radius:10px;background:var(--bg-2, #f8f9fa);border:1px solid var(--border)">
    <div style="font-size:12px;color:var(--text-3);margin-bottom:8px;font-weight:600">📊 Ngày công tháng {{ $payroll->month }}/{{ $payroll->year }}</div>
    <div style="display:flex;gap:20px;flex-wrap:wrap;align-items:center">
      <div>
        <span style="font-size:22px;font-weight:800;color:{{ $validDays >= $workingDays ? 'var(--success)' : '#d97706' }}">
          {{ $validDays }}
        </span>
        <span style="font-size:14px;color:var(--text-3)"> / {{ $workingDays }} ngày</span>
      </div>

      {{-- Thanh tiến trình ngày công --}}
      <div style="flex:1;min-width:160px">
        <div style="height:8px;border-radius:99px;background:var(--border);overflow:hidden">
          <div style="height:100%;border-radius:99px;
                      width:{{ min(100, round($validDays / max($workingDays, 1) * 100)) }}%;
                      background:{{ $validDays >= $workingDays ? 'var(--success, #16a34a)' : '#d97706' }};
                      transition:width 0.4s ease">
          </div>
        </div>
        <div style="font-size:11px;color:var(--text-3);margin-top:4px">
          {{ round($validDays / max($workingDays, 1) * 100) }}% ngày công (mỗi ngày đủ 8 tiếng)
        </div>
      </div>

      {{-- Lương tính theo ngày công --}}
      <div style="text-align:right">
        <div style="font-size:11px;color:var(--text-3)">Lương cứng thực tế</div>
        <div style="font-size:15px;font-weight:700;color:{{ $validDays >= $workingDays ? 'var(--success)' : '#d97706' }}">
          {{ number_format($attendanceSalary, 0, ',', '.') }}đ
        </div>
        @if($validDays < $workingDays)
        <div style="font-size:11px;color:#ef4444">
          Trừ {{ number_format($base - $attendanceSalary, 0, ',', '.') }}đ (thiếu {{ $workingDays - $validDays }} ngày)
        </div>
        @endif
      </div>
    </div>
  </div>
  @endif
</div>

{{-- Nhập đơn giá tăng ca (chỉ admin, chưa chốt) --}}
<div class="card card-pad" style="margin-bottom:16px">
  <div style="font-size:14px;font-weight:700;margin-bottom:14px">⏱️ Tăng ca</div>

  {{-- Tổng giờ tăng ca từ GPS --}}
  <div style="padding:12px 16px;border-radius:10px;background:var(--bg-2,#f8f9fa);
              border:1px solid var(--border);margin-bottom:14px;display:flex;gap:24px;flex-wrap:wrap;align-items:center">
    <div>
      <div style="font-size:12px;color:var(--text-3)">Giờ tăng ca (GPS)</div>
      <div style="font-size:22px;font-weight:800;color:var(--accent)">
        {{ number_format($overtimeHours, 1) }}
        <span style="font-size:14px;font-weight:400;color:var(--text-3)">giờ</span>
      </div>
    </div>
    <div>
      <div style="font-size:12px;color:var(--text-3)">Đơn giá hiện tại</div>
      <div style="font-size:18px;font-weight:700">
        {{ $overtimeRate > 0 ? number_format($overtimeRate, 0, ',', '.') . 'đ/giờ' : '—' }}
      </div>
    </div>
    <div>
      <div style="font-size:12px;color:var(--text-3)">Tiền tăng ca</div>
      <div style="font-size:18px;font-weight:700;color:{{ $overtimeAllowance > 0 ? 'var(--success,#16a34a)' : 'var(--text-3)' }}">
        {{ $overtimeAllowance > 0 ? number_format($overtimeAllowance, 0, ',', '.') . 'đ' : '—' }}
      </div>
    </div>
  </div>

  {{-- Form nhập đơn giá --}}
  <form method="POST" action="{{ route('admin.payroll.updateOvertimeRate', $payroll) }}">
    @csrf
    @method('PATCH')
    <div style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap">
      <div style="flex:1;min-width:180px">
        <label style="font-size:12px;color:var(--text-3);display:block;margin-bottom:6px">
          Đơn giá tăng ca (VNĐ/giờ)
        </label>
        <input
          type="number"
          name="overtime_rate"
          value="{{ old('overtime_rate', $payroll->overtime_rate ?? 0) }}"
          min="0"
          step="5000"
          class="form-control"
          style="width:100%;padding:8px 12px;border:1px solid var(--border);border-radius:8px;font-size:15px"
          placeholder="Ví dụ: 50000"
        >
        @error('overtime_rate')
          <div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>
        @enderror
      </div>
      <button type="submit" class="btn btn-primary btn-sm" style="white-space:nowrap;padding:8px 20px">
        ⚡ Tính lương tăng ca
      </button>
    </div>
    @if($overtimeHours > 0 && $overtimeRate > 0)
    <div style="margin-top:10px;padding:8px 12px;border-radius:8px;background:#f0fdf4;border:1px solid #bbf7d0;font-size:12px;color:#15803d">
      Công thức: <strong>{{ number_format($overtimeHours, 1) }} giờ</strong>
      × <strong>{{ number_format($overtimeRate, 0, ',', '.') }}đ</strong>
      = <strong>{{ number_format($overtimeAllowance, 0, ',', '.') }}đ</strong>
    </div>
    @elseif($overtimeHours == 0)
    <div style="margin-top:10px;font-size:12px;color:var(--text-3)">
      ℹ️ Chưa có dữ liệu giờ tăng ca từ GPS trong tháng này.
    </div>
    @endif
  </form>
</div>
@endif

{{-- Stat cards --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:12px;margin-bottom:20px">
  <div class="stat-card">
    <div class="stat-label">Lương cứng</div>
    <div class="stat-val" style="font-size:19px">{{ number_format($base, 0, ',', '.') }}đ</div>
    <div class="stat-sub">lương cơ bản tháng</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Ngày công</div>
    <div class="stat-val" style="font-size:19px;color:{{ $validDays >= $workingDays ? 'var(--success)' : '#d97706' }}">
      {{ $validDays }}/{{ $workingDays }}
    </div>
    <div class="stat-sub">ngày đủ 8 tiếng</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Hoa hồng</div>
    <div class="stat-val" style="font-size:19px;color:var(--success)">
      {{ number_format($commission, 0, ',', '.') }}đ
    </div>
    <div class="stat-sub">từ đơn đã chốt</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Thưởng KPI</div>
    <div class="stat-val" style="font-size:19px;color:{{ $kpiBonus > 0 ? 'var(--success)' : 'var(--text-3)' }}">
      {{ number_format($kpiBonus, 0, ',', '.') }}đ
    </div>
    <div class="stat-sub">
      % KPI:
      <span style="font-weight:700;color:{{ $kpiPercent >= 100 ? '#16a34a' : ($kpiPercent >= 80 ? '#d97706' : '#94a3b8') }}">
        {{ $kpiPercent }}%
      </span>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Tăng ca</div>
    <div class="stat-val" style="font-size:19px;color:{{ $overtimeAllowance > 0 ? 'var(--success)' : 'var(--text-3)' }}">
      {{ number_format($overtimeAllowance, 0, ',', '.') }}đ
    </div>
    <div class="stat-sub">
      {{ number_format($overtimeHours, 1) }} giờ
      @if($overtimeRate > 0)
        × {{ number_format($overtimeRate, 0, ',', '.') }}đ
      @endif
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Tổng lương</div>
    <div class="stat-val" style="font-size:19px;color:var(--accent)">{{ number_format($total, 0, ',', '.') }}đ</div>
    <div class="stat-sub">thực lãnh</div>
  </div>
</div>

{{-- Chi tiết tính lương --}}
<div class="card card-pad" style="margin-bottom:20px">
  <div style="font-size:14px;font-weight:700;margin-bottom:14px">🧾 Chi tiết tính lương</div>
  <table class="table">
    <tbody>
      <tr>
        <td style="color:var(--text-3);width:50%">Lương cứng (gốc)</td>
        <td style="text-align:right;font-weight:600">{{ number_format($base, 0, ',', '.') }}đ</td>
      </tr>
      <tr>
        <td style="color:var(--text-3)">
          Ngày công
          <span style="font-size:12px;margin-left:6px;color:{{ $validDays >= $workingDays ? '#16a34a' : '#d97706' }};font-weight:700">
            ({{ $validDays }}/{{ $workingDays }} ngày)
          </span>
        </td>
        <td style="text-align:right;font-weight:600;color:{{ $validDays >= $workingDays ? 'var(--success)' : '#d97706' }}">
          {{ number_format($attendanceSalary, 0, ',', '.') }}đ
          @if($validDays < $workingDays && $base > 0)
            <div style="font-size:11px;color:#ef4444;font-weight:400">
              − {{ number_format($base - $attendanceSalary, 0, ',', '.') }}đ
            </div>
          @endif
        </td>
      </tr>
      <tr>
        <td style="color:var(--text-3)">Hoa hồng bán hàng</td>
        <td style="text-align:right;font-weight:600;color:var(--success)">
          + {{ number_format($commission, 0, ',', '.') }}đ
        </td>
      </tr>
      <tr>
        <td style="color:var(--text-3)">
          Thưởng KPI
          <span style="font-size:12px;margin-left:6px;font-weight:700;
                       color:{{ $kpiPercent >= 100 ? '#16a34a' : ($kpiPercent >= 80 ? '#d97706' : '#94a3b8') }}">
            ({{ $kpiPercent }}%)
          </span>
        </td>
        <td style="text-align:right;font-weight:600;color:{{ $kpiBonus > 0 ? 'var(--success)' : 'var(--text-3)' }}">
          @if($kpiBonus > 0)
            + {{ number_format($kpiBonus, 0, ',', '.') }}đ
          @else
            0đ
          @endif
        </td>
      </tr>
      <tr>
        <td style="color:var(--text-3)">
          Tăng ca
          <span style="font-size:12px;margin-left:6px;color:var(--text-3)">
            ({{ number_format($overtimeHours, 1) }} giờ
            @if($overtimeRate > 0)
              × {{ number_format($overtimeRate, 0, ',', '.') }}đ/giờ
            @endif
            )
          </span>
        </td>
        <td style="text-align:right;font-weight:600;color:{{ $overtimeAllowance > 0 ? 'var(--success)' : 'var(--text-3)' }}">
          @if($overtimeAllowance > 0)
            + {{ number_format($overtimeAllowance, 0, ',', '.') }}đ
          @else
            0đ
          @endif
        </td>
      </tr>
      <tr style="border-top:2px solid var(--border)">
        <td style="font-weight:700">Tổng thực lãnh</td>
        <td style="text-align:right;font-weight:700;font-size:16px;color:var(--accent)">
          {{ number_format($total, 0, ',', '.') }}đ
        </td>
      </tr>
    </tbody>
  </table>
</div>

{{-- Modal DOM --}}
<div id="payroll-modal-overlay"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:9999;
            align-items:center;justify-content:center">
  <div style="background:#fff;border-radius:18px;padding:36px 32px;max-width:420px;width:92%;
              box-shadow:0 24px 80px rgba(0,0,0,0.22)">
    <div id="pm-icon"  style="font-size:36px;text-align:center;margin-bottom:12px"></div>
    <div id="pm-title" style="font-size:18px;font-weight:800;text-align:center;margin-bottom:8px"></div>
    <div id="pm-body"  style="font-size:14px;color:#888;text-align:center;line-height:1.6;margin-bottom:28px"></div>
    <div style="display:flex;gap:10px;justify-content:center">
      <button id="pm-cancel" class="btn" style="min-width:90px;font-weight:700">Huỷ</button>
      <button id="pm-ok"     class="btn btn-primary" style="min-width:120px;font-weight:700"></button>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
(function() {
  var overlay  = document.getElementById('payroll-modal-overlay');
  var pmIcon   = document.getElementById('pm-icon');
  var pmTitle  = document.getElementById('pm-title');
  var pmBody   = document.getElementById('pm-body');
  var pmOk     = document.getElementById('pm-ok');
  var pmCancel = document.getElementById('pm-cancel');
  var _formId  = null;

  window.showPayrollConfirm = function(title, body, okLabel, type, formId) {
    var icons = { primary: '✅', warning: '🔓', danger: '🗑️' };
    pmIcon.textContent  = icons[type] || '❓';
    pmTitle.textContent = title;
    pmBody.innerHTML    = body;
    pmOk.textContent    = okLabel;
    pmOk.style.background   = type === 'warning' ? '#d97706' : '';
    pmOk.style.borderColor  = type === 'warning' ? '#d97706' : '';
    _formId = formId;
    overlay.style.display = 'flex';
  };

  pmOk.addEventListener('click', function() {
    overlay.style.display = 'none';
    if (_formId) document.getElementById(_formId).submit();
  });

  pmCancel.addEventListener('click', function() {
    overlay.style.display = 'none';
  });

  overlay.addEventListener('click', function(e) {
    if (e.target === overlay) overlay.style.display = 'none';
  });
})();
</script>
@endpush