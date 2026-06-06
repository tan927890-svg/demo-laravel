{{-- resources/views/admin/payroll/index.blade.php --}}
@extends('layouts.admin')

@section('page-title', 'Bảng lương tháng ' . $month . '/' . $year)

@section('content')
<div class="container-fluid py-4">

  {{-- Header --}}
  <div class="section-header mb-4">
    <div>
      <h4 class="mb-1" style="font-size:20px;font-weight:800">Bảng lương</h4>
      <p style="color:var(--text-3);font-size:13px;margin:0">Admin tính lương → Kiểm tra → Chốt → Xuất Excel</p>
    </div>

    {{-- Bộ lọc tháng --}}
    <form method="GET" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
      <select name="month" class="form-input">
        @for($m = 1; $m <= 12; $m++)
          <option value="{{ $m }}" @selected($m == $month)>Tháng {{ $m }}</option>
        @endfor
      </select>
      <select name="year" class="form-input">
        @for($y = 2024; $y <= now()->year + 1; $y++)
          <option value="{{ $y }}" @selected($y == $year)>{{ $y }}</option>
        @endfor
      </select>
      <button class="btn btn-sm">Xem</button>
    </form>
  </div>

  @if(session('success'))
    <div class="alert alert-success flash">{{ session('success') }}</div>
  @endif

  {{-- Action bar --}}
  <div style="display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap">
    <form method="POST" action="{{ route('admin.payroll.calculate') }}"
          id="form-calculate">
      @csrf
      <input type="hidden" name="month" value="{{ $month }}">
      <input type="hidden" name="year"  value="{{ $year }}">
      <button type="button" class="btn btn-primary"
              data-form="form-calculate"
              data-title="Tính lương tháng {{ $month }}/{{ $year }}"
              data-body="Hệ thống sẽ tính lương cho toàn bộ nhân viên. Các bảng lương đã chốt sẽ không bị tính lại."
              data-ok="⚡ Tính ngay"
              data-type="primary"
              onclick="triggerConfirm(this)">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
        Tính lương tháng {{ $month }}/{{ $year }}
      </button>
    </form>

    @if($payrolls->count())
    <a href="{{ route('admin.payroll.export', ['month' => $month, 'year' => $year]) }}"
       class="btn" style="border-color:#16a34a;color:#16a34a">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
      Xuất Excel tháng {{ $month }}/{{ $year }}
    </a>
    @endif
  </div>

  @if($payrolls->isEmpty())
    <div class="card card-pad" style="text-align:center;color:var(--text-3);padding:48px">
      <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
      <p style="font-size:15px;font-weight:700;margin-bottom:6px">Chưa có bảng lương tháng này</p>
      <p style="font-size:13px">Bấm <strong>Tính lương</strong> để bắt đầu</p>
    </div>
  @else

  {{-- Summary stats --}}
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:14px;margin-bottom:20px">
    <div class="stat-card">
      <div class="stat-label">Tổng nhân viên</div>
      <div class="stat-val">{{ $payrolls->count() }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Tổng lương phải trả</div>
      <div class="stat-val" style="font-size:20px">{{ number_format($payrolls->sum('total_salary'), 0, ',', '.') }}đ</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Đi làm đủ tháng</div>
      <div class="stat-val" style="color:var(--success)">
        {{ $payrolls->filter(fn($p) => ($p->valid_days ?? 0) >= ($p->working_days ?? 30))->count() }}
      </div>
      <div class="stat-sub">/ {{ $payrolls->count() }} người</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Đã chốt</div>
      <div class="stat-val" style="color:var(--success)">{{ $payrolls->where('status','approved')->count() }}</div>
      <div class="stat-sub">/ {{ $payrolls->count() }} người</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Chưa chốt</div>
      <div class="stat-val" style="color:var(--warning)">{{ $payrolls->where('status','draft')->count() }}</div>
    </div>
  </div>

  {{-- Bảng --}}
  <div class="card">
    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>Nhân viên</th>
            <th class="text-end">Lương cứng</th>
            <th class="text-center">Ngày công</th>
            <th class="text-end">Hoa hồng</th>
            <th class="text-end">Thưởng KPI</th>
            <th class="text-center">% KPI</th>
            <th class="text-end" style="font-weight:800">Tổng lương</th>
            <th class="text-center">Trạng thái</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($payrolls as $payroll)
          @php
            $userName     = $payroll->user?->name     ?? '(Đã xóa)';
            $userUsername = $payroll->user?->username  ?? '—';
            $isDeleted    = is_null($payroll->user) || $payroll->user->trashed();
            $validDays    = $payroll->valid_days   ?? 0;
            $workingDays  = $payroll->working_days ?? 30;
            $isFullMonth  = $validDays >= $workingDays;
          @endphp
          <tr>
            <td>
              <div style="display:flex;align-items:center;gap:10px">
                <div style="width:34px;height:34px;border-radius:50%;background:{{ $isDeleted ? 'linear-gradient(135deg,#94a3b8,#64748b)' : 'linear-gradient(135deg,#f59e0b,#f97316)' }};display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;color:#fff;flex-shrink:0">
                  {{ strtoupper(substr($userName, 0, 2)) }}
                </div>
                <div>
                  <div style="display:flex;align-items:center;gap:6px;font-weight:700;font-size:14px">
                    {{ $userName }}
                    @if($isDeleted)
                      <span style="font-size:10px;font-weight:600;padding:1px 6px;border-radius:99px;background:#fee2e2;color:#dc2626">Đã xóa</span>
                    @endif
                  </div>
                  <div style="font-size:12px;color:var(--text-3)">{{ $userUsername }}</div>
                </div>
              </div>
            </td>

            <td style="text-align:right">{{ number_format($payroll->base_salary, 0, ',', '.') }}đ</td>

            {{-- Ngày công --}}
            <td style="text-align:center">
              <div style="display:inline-flex;flex-direction:column;align-items:center;gap:3px;min-width:72px">
                <span style="font-weight:700;font-size:13px;color:{{ $isFullMonth ? '#16a34a' : '#d97706' }}">
                  {{ $validDays }}/{{ $workingDays }}
                </span>
                <div style="width:60px;height:5px;border-radius:99px;background:#e5e7eb;overflow:hidden">
                  <div style="height:100%;border-radius:99px;
                              width:{{ min(100, round($validDays / max($workingDays,1) * 100)) }}%;
                              background:{{ $isFullMonth ? '#16a34a' : '#d97706' }}">
                  </div>
                </div>
                @if(!$isFullMonth)
                  <span style="font-size:10px;color:#d97706">thiếu {{ $workingDays - $validDays }} ngày</span>
                @else
                  <span style="font-size:10px;color:#16a34a">đủ tháng</span>
                @endif
              </div>
            </td>

            <td style="text-align:right">{{ number_format($payroll->total_commission, 0, ',', '.') }}đ</td>
            <td style="text-align:right">{{ number_format($payroll->kpi_bonus, 0, ',', '.') }}đ</td>
            <td style="text-align:center">
              @php $kp = $payroll->kpi_percent; @endphp
              <span style="font-weight:700;color:{{ $kp >= 100 ? '#16a34a' : ($kp >= 80 ? '#d97706' : '#94a3b8') }}">
                {{ $kp }}%
              </span>
            </td>
            <td style="text-align:right;font-weight:800;font-size:15px">
              {{ number_format($payroll->total_salary, 0, ',', '.') }}đ
            </td>

            {{-- Trạng thái --}}
            <td style="text-align:center">
              @if($payroll->status === 'approved')
                <form method="POST" action="{{ route('admin.payroll.reopen', $payroll) }}"
                      id="form-reopen-{{ $payroll->id }}" style="display:inline">
                  @csrf
                  <button type="button" style="border:none;background:none;padding:0;cursor:pointer"
                          data-form="form-reopen-{{ $payroll->id }}"
                          data-title="Mở lại bảng lương"
                          data-body="Bảng lương của <strong>{{ e($userName) }}</strong> sẽ được mở lại để tính lại."
                          data-ok="🔓 Mở lại"
                          data-type="warning"
                          onclick="triggerConfirm(this)">
                    <span style="display:inline-flex;align-items:center;gap:4px;padding:5px 12px;border-radius:20px;font-size:12px;font-weight:600;background:#dcfce7;color:#166534;cursor:pointer;transition:opacity .15s"
                          onmouseover="this.style.opacity='.75'" onmouseout="this.style.opacity='1'">
                      ✅ Đã chốt
                    </span>
                  </button>
                </form>
              @else
                <form method="POST" action="{{ route('admin.payroll.approve', $payroll) }}"
                      id="form-approve-{{ $payroll->id }}" style="display:inline">
                  @csrf
                  <button type="button" style="border:none;background:none;padding:0;cursor:pointer"
                          data-form="form-approve-{{ $payroll->id }}"
                          data-title="Chốt bảng lương"
                          data-body="Xác nhận chốt lương tháng {{ $payroll->month }}/{{ $payroll->year }} cho <strong>{{ e($userName) }}</strong>?"
                          data-ok="✅ Chốt lương"
                          data-type="primary"
                          onclick="triggerConfirm(this)">
                    <span style="display:inline-flex;align-items:center;gap:4px;padding:5px 12px;border-radius:20px;font-size:12px;font-weight:600;background:#fef3c7;color:#92400e;cursor:pointer;transition:opacity .15s"
                          onmouseover="this.style.opacity='.75'" onmouseout="this.style.opacity='1'">
                      📝 Nháp
                    </span>
                  </button>
                </form>
              @endif
            </td>

            {{-- Actions --}}
            <td style="text-align:right">
              <div style="display:flex;gap:6px;justify-content:flex-end;align-items:center">
                <a href="{{ route('admin.payroll.show', $payroll) }}" class="btn btn-sm">Chi tiết →</a>

                @if($payroll->status !== 'approved')
                <form method="POST" action="{{ route('admin.payroll.destroy', $payroll) }}"
                      id="form-delete-{{ $payroll->id }}" style="display:inline">
                  @csrf
                  @method('DELETE')
                  <button type="button"
                          style="width:32px;height:32px;border-radius:8px;border:1px solid #fecaca;background:#fff;
                                 color:#dc2626;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;
                                 transition:background .15s"
                          onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='#fff'"
                          data-form="form-delete-{{ $payroll->id }}"
                          data-title="Xoá bảng lương"
                          data-body="Xoá bảng lương tháng {{ $payroll->month }}/{{ $payroll->year }} của <strong>{{ e($userName) }}</strong>? Hành động này không thể hoàn tác."
                          data-ok="🗑️ Xoá"
                          data-type="danger"
                          onclick="triggerConfirm(this)"
                          title="Xoá bảng lương">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                    </svg>
                  </button>
                </form>
                @endif
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif

  {{-- ══════════════════════════════════════════════════════ --}}
  {{-- Quản lý lương cứng — inline, không cần trang riêng    --}}
  {{-- ══════════════════════════════════════════════════════ --}}
  <div style="margin-top:32px">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:8px">
      <div>
        <h5 style="font-size:15px;font-weight:800;margin:0">Lương cứng nhân viên</h5>
        <p style="font-size:12px;color:var(--text-3);margin:3px 0 0">Click vào nhân viên để cập nhật lương cứng</p>
      </div>
      <span style="background:#eff6ff;color:#2563eb;font-size:11px;font-weight:700;padding:3px 10px;border-radius:99px;font-family:monospace">
        {{ $staff->count() }} nhân viên
      </span>
    </div>

    <div class="card">
      @if($staff->isEmpty())
        <div style="text-align:center;padding:40px 24px;color:var(--text-3)">
          <p style="font-size:14px">Chưa có nhân viên nào.</p>
        </div>
      @else
      @php $avatarColors = ['#ede9fe|#7c3aed','#dbeafe|#2563eb','#dcfce7|#16a34a','#ffedd5|#ea580c','#fce7f3|#db2777']; @endphp
      <div class="table-responsive">
        <table id="salary-table">
          <thead>
            <tr>
              <th>Nhân viên</th>
              <th style="text-align:right">Lương cứng hiện tại</th>
              <th style="text-align:right">Hiệu lực</th>
              <th style="width:32px"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($staff as $i => $user)
            @php
              $latest     = $user->salaryHistories->first();
              $initials   = collect(explode(' ', $user->name))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->implode('');
              [$avBg, $avColor] = explode('|', $avatarColors[$i % count($avatarColors)]);
            @endphp

            {{-- Staff row --}}
            <tr id="srow-{{ $user->id }}"
                onclick="toggleSalaryInline({{ $user->id }})"
                style="cursor:pointer;transition:background .12s"
                onmouseover="if(!this.classList.contains('srow-active'))this.style.background='#f8fafc'"
                onmouseout="if(!this.classList.contains('srow-active'))this.style.background=''">
              <td>
                <div style="display:flex;align-items:center;gap:10px">
                  <div style="width:34px;height:34px;border-radius:9px;background:{{ $avBg }};color:{{ $avColor }};
                              display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0">
                    {{ $initials }}
                  </div>
                  <div>
                    <div style="font-weight:700;font-size:14px">{{ $user->name }}</div>
                    <div style="font-size:11px;color:var(--text-3);font-family:monospace">{{ $user->username ?? $user->email }}</div>
                  </div>
                </div>
              </td>
              <td style="text-align:right">
                @if($latest)
                  <span id="sdisplay-{{ $user->id }}" style="font-weight:700;font-family:monospace">
                    {{ number_format($latest->base_salary, 0, ',', '.') }}đ
                  </span>
                @else
                  <span id="sdisplay-{{ $user->id }}" style="color:#d1d5db;font-style:italic;font-size:13px">Chưa có</span>
                @endif
              </td>
              <td style="text-align:right">
                @if($latest)
                  <span id="seff-{{ $user->id }}" style="display:inline-flex;align-items:center;padding:3px 8px;border-radius:6px;font-size:11px;font-weight:600;background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0">
                    T{{ $latest->effective_month }}/{{ $latest->effective_year }}
                  </span>
                @else
                  <span id="seff-{{ $user->id }}" style="display:inline-flex;align-items:center;padding:3px 8px;border-radius:6px;font-size:11px;color:#94a3b8;background:#f8fafc;border:1px solid #e2e8f0">—</span>
                @endif
              </td>
              <td>
                <svg id="schev-{{ $user->id }}" width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="#94a3b8" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                     style="display:block;margin-left:auto;transition:transform .2s">
                  <polyline points="6 9 12 15 18 9"/>
                </svg>
              </td>
            </tr>

            {{-- Inline form row --}}
            <tr id="sinline-{{ $user->id }}" style="display:none;background:#f8faff">
              <td colspan="4" style="padding:0;border-bottom:2px solid #dbeafe">
                <form method="POST" action="{{ route('admin.payroll.salary.store') }}"
                      style="padding:14px 20px;display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap">
                  @csrf
                  <input type="hidden" name="user_id" value="{{ $user->id }}">

                  <div style="display:flex;flex-direction:column;gap:5px">
                    <label style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:var(--text-2)">Lương cứng mới</label>
                    <div style="position:relative">
                      <input type="number"
                             name="base_salary"
                             class="sinput-salary"
                             style="height:38px;width:160px;padding:0 28px 0 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:14px;font-family:monospace;color:#0f172a;background:#fff;outline:none"
                             placeholder="0" min="0" step="500000"
                             value="{{ $latest?->base_salary ?? '' }}"
                             onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,.1)'"
                             onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'"
                             required>
                      <span style="position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:12px;color:#94a3b8;pointer-events:none">đ</span>
                    </div>
                  </div>

                  <div style="display:flex;flex-direction:column;gap:5px">
                    <label style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:var(--text-2)">Tháng</label>
                    <select name="effective_month"
                            style="height:38px;width:115px;padding:0 10px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;color:#0f172a;background:#fff;outline:none;cursor:pointer">
                      @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" @selected($m == ($latest?->effective_month ?? now()->month))>Tháng {{ $m }}</option>
                      @endfor
                    </select>
                  </div>

                  <div style="display:flex;flex-direction:column;gap:5px">
                    <label style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:var(--text-2)">Năm</label>
                    <select name="effective_year"
                            style="height:38px;width:82px;padding:0 10px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;color:#0f172a;background:#fff;outline:none;cursor:pointer">
                      @for($y = 2024; $y <= now()->year + 2; $y++)
                        <option value="{{ $y }}" @selected($y == ($latest?->effective_year ?? now()->year))>{{ $y }}</option>
                      @endfor
                    </select>
                  </div>

                  <div style="display:flex;flex-direction:column;gap:5px;flex:1;min-width:160px">
                    <label style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:var(--text-2)">
                      Ghi chú <span style="font-weight:400;text-transform:none;letter-spacing:0;color:#94a3b8">(tuỳ chọn)</span>
                    </label>
                    <input type="text" name="note"
                           style="height:38px;width:100%;padding:0 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;color:#0f172a;background:#fff;outline:none"
                           placeholder="VD: Tăng lương theo đánh giá Q2..."
                           onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">
                  </div>

                  <div style="display:flex;gap:8px;flex-shrink:0">
                    <button type="button"
                            onclick="closeSalaryInline({{ $user->id }}, event)"
                            style="height:38px;padding:0 14px;background:#f1f5f9;color:#475569;font-size:13px;font-weight:500;border:1px solid #e2e8f0;border-radius:9px;cursor:pointer">
                      Huỷ
                    </button>
                    <button type="submit"
                            style="height:38px;padding:0 18px;display:inline-flex;align-items:center;gap:6px;background:#2563eb;color:#fff;font-size:13px;font-weight:700;border:none;border-radius:9px;cursor:pointer">
                      <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                      Lưu lương
                    </button>
                  </div>
                </form>
              </td>
            </tr>

            @endforeach
          </tbody>
        </table>
      </div>
      @endif
    </div>
  </div>

</div>

{{-- ── Custom Confirm Modal ── --}}
<div id="confirm-overlay"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:9998;align-items:center;justify-content:center">
  <div style="background:#fff;border-radius:16px;padding:32px;max-width:420px;width:90%;
              box-shadow:0 24px 64px rgba(0,0,0,0.18);animation:modalIn .15s ease">
    <div id="confirm-icon"  style="font-size:32px;margin-bottom:12px;text-align:center"></div>
    <div id="confirm-title" style="font-size:17px;font-weight:800;margin-bottom:8px;text-align:center"></div>
    <div id="confirm-body"  style="font-size:14px;color:var(--text-3);margin-bottom:28px;line-height:1.6;text-align:center"></div>
    <div style="display:flex;gap:10px;justify-content:center">
      <button onclick="closeConfirm()" class="btn" style="min-width:90px;font-weight:600">Huỷ</button>
      <button id="confirm-ok" class="btn btn-primary" style="min-width:120px;font-weight:600"></button>
    </div>
  </div>
</div>

<style>
@keyframes modalIn {
  from { opacity:0; transform:translateY(12px) scale(.97) }
  to   { opacity:1; transform:translateY(0) scale(1) }
}
#confirm-overlay.open { display:flex !important }
</style>

<script>
/* ── Payroll confirm modal ── */
let _cb = null;

function triggerConfirm(el) {
  const formId = el.dataset.form;
  showConfirm(
    el.dataset.title,
    el.dataset.body,
    el.dataset.ok,
    el.dataset.type,
    function () { document.getElementById(formId).submit(); }
  );
}

function showConfirm(title, body, okLabel, type, callback) {
  const icons = { primary:'⚡', warning:'🔓', danger:'🗑️' };
  document.getElementById('confirm-icon').textContent  = icons[type] ?? '❓';
  document.getElementById('confirm-title').textContent = title;
  document.getElementById('confirm-body').innerHTML    = body;
  const ok = document.getElementById('confirm-ok');
  ok.textContent       = okLabel;
  ok.style.background  = type === 'warning' ? '#d97706' : (type === 'danger' ? '#dc2626' : '');
  ok.style.borderColor = type === 'warning' ? '#d97706' : (type === 'danger' ? '#dc2626' : '');
  _cb = callback;
  document.getElementById('confirm-overlay').classList.add('open');
}

function closeConfirm() {
  document.getElementById('confirm-overlay').classList.remove('open');
  _cb = null;
}

document.getElementById('confirm-ok').addEventListener('click', () => {
  const fn = _cb; closeConfirm(); if (fn) fn();
});
document.getElementById('confirm-overlay').addEventListener('click', function(e) {
  if (e.target === this) closeConfirm();
});

/* ── Salary inline toggle ── */
var _openSalaryId = null;

function toggleSalaryInline(id) {
  if (_openSalaryId && _openSalaryId !== id) closeSalaryInline(_openSalaryId, null);

  var inlineRow = document.getElementById('sinline-' + id);
  var staffRow  = document.getElementById('srow-' + id);
  var chev      = document.getElementById('schev-' + id);
  var isOpen    = inlineRow.style.display !== 'none';

  if (isOpen) {
    inlineRow.style.display = 'none';
    staffRow.classList.remove('srow-active');
    staffRow.style.background = '';
    chev.style.transform = 'rotate(0deg)';
    _openSalaryId = null;
  } else {
    inlineRow.style.display = 'table-row';
    staffRow.classList.add('srow-active');
    staffRow.style.background = '#eff6ff';
    chev.style.transform = 'rotate(180deg)';
    _openSalaryId = id;
    setTimeout(function () {
      var inp = inlineRow.querySelector('.sinput-salary');
      if (inp) { inp.focus(); inp.select(); }
    }, 50);
  }
}

function closeSalaryInline(id, e) {
  if (e) e.stopPropagation();
  var inlineRow = document.getElementById('sinline-' + id);
  var staffRow  = document.getElementById('srow-' + id);
  var chev      = document.getElementById('schev-' + id);
  inlineRow.style.display = 'none';
  staffRow.classList.remove('srow-active');
  staffRow.style.background = '';
  chev.style.transform = 'rotate(0deg)';
  if (_openSalaryId === id) _openSalaryId = null;
}
</script>
@endsection