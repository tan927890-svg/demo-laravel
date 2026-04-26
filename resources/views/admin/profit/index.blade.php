@extends('layouts.admin')

@section('page-title', 'Lợi nhuận xe')

@push('styles')
<style>
.profit-pos { color: var(--success); font-weight: 700; }
/* Override stat-card & layout spacing */
.stat-card { padding: 14px 16px !important; }
.stat-label { font-size: 10px; margin-bottom: 4px; }
.stat-val { font-size: 20px !important; }
.filter-bar { margin-bottom: 10px !important; }
.profit-neg { color: var(--danger);  font-weight: 700; }
.stat-val.pos { color: var(--success); }
.stat-val.neg { color: var(--danger); }
.quick-val {
    display: inline-block; padding: 2px 8px; border-radius: 20px;
    font-size: 11px; font-weight: 700; cursor: pointer;
    background: #f1f5f9; color: #334155;
    border: 1px solid #e2e8f0;
    transition: background .1s;
}
.quick-val:hover { background: #e2e8f0; }
.exp-row { display: grid; grid-template-columns: 1fr 180px auto; gap: 8px; align-items: center; margin-bottom: 8px; }
.exp-row input[type=text], .exp-row input[type=number] {
    width: 100%; padding: 8px 12px;
    border: 1px solid var(--border); border-radius: 8px;
    font-size: 13px; font-family: var(--font); background: var(--bg);
}
.exp-row input:focus { outline: none; border-color: #999; }
.quick-row { display: flex; gap: 4px; margin-top: 3px; flex-wrap: wrap; }
.btn-rm-exp {
    background: none; border: 1px solid #fecaca; border-radius: 8px;
    color: var(--danger); cursor: pointer; padding: 6px 10px; font-size: 14px;
    transition: background .1s;
}
.btn-rm-exp:hover { background: #fef2f2; }

.two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.calc-box {
    margin-top: 14px; padding: 14px 16px; border-radius: 12px;
    background: #f8fafc; border: 1px solid var(--border);
    display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px;
}
.calc-item { font-size: 12px; color: var(--text-2); }
.calc-item strong { display: block; font-size: 15px; color: var(--text); margin-top: 2px; }
.calc-item.highlight strong { font-size: 17px; }
.profit-pct-wrap {
    display: flex; align-items: center; gap: 8px; margin-top: 10px;
}
.profit-pct-wrap input[type=range] { flex: 1; }
.profit-pct-wrap .pct-badge {
    min-width: 52px; text-align: center;
    padding: 4px 10px; border-radius: 20px;
    font-size: 13px; font-weight: 700;
    background: var(--primary, #2563eb); color: #fff;
}

/* ── Modal redesign ── */
.modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,.5); z-index: 100;
    align-items: center; justify-content: center;
    backdrop-filter: blur(2px);
}
.modal-overlay.open { display: flex; }
.modal-box {
    background: var(--surface); border-radius: 16px;
    border: 1px solid var(--border); width: 680px; max-width: 96vw;
    max-height: 92vh; overflow-y: auto; padding: 24px;
    box-shadow: 0 24px 80px rgba(0,0,0,.18);
}
.modal-title { font-size: 18px; font-weight: 800; }

/* Form */
.form-group { margin-top: 14px; }
.form-label { font-size: 11px; font-weight: 700; color: var(--text-2);
    text-transform: uppercase; letter-spacing: .6px;
    display: block; margin-bottom: 6px; }

/* Input + dropdown combo */
.input-select-wrap { position: relative; }
.input-select-wrap .form-control,
.input-select-wrap input[type=number],
.input-select-wrap input[type=text] {
    width: 100%; padding-right: 36px;
}
.select-arrow {
    position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
    color: var(--text-2); font-size: 12px; cursor: pointer;
    user-select: none; pointer-events: all;
    transition: transform .15s;
}
.dropdown-opts {
    display: none; position: absolute; top: calc(100% + 4px); left: 0; right: 0;
    background: var(--surface); border: 1px solid var(--border);
    border-radius: 10px; box-shadow: 0 8px 32px rgba(0,0,0,.12);
    z-index: 200; max-height: 220px; overflow-y: auto;
    padding: 4px;
}
.dropdown-opts.open { display: block; }
.dd-opt {
    display: flex; align-items: center; justify-content: space-between;
    padding: 8px 12px; border-radius: 7px; cursor: pointer;
    font-size: 13px; transition: background .1s;
}
.dd-opt:hover, .dd-opt.selected { background: var(--primary-light, #eff6ff); }
.dd-opt.selected .dd-label { color: var(--primary, #2563eb); font-weight: 700; }
.dd-label { font-weight: 600; }
.dd-tag {
    font-size: 10px; padding: 2px 7px; border-radius: 20px;
    background: #e0f2fe; color: #0369a1; font-weight: 700;
}

/* Expense rows */
.exp-row-wrap { margin-bottom: 8px; }
.exp-row {
    display: grid; grid-template-columns: 1fr 200px 36px; gap: 8px; align-items: start;
}
.exp-row input[type=text], .exp-row input[type=number] {
    width: 100%; padding: 8px 12px;
    border: 1px solid var(--border); border-radius: 8px;
    font-size: 13px; font-family: var(--font); background: var(--bg);
    box-sizing: border-box;
}
.exp-row .input-select-wrap input[type=text] { padding-right: 30px; }
.exp-row input:focus { outline: none; border-color: #999; }
.quick-row { display: flex; gap: 4px; margin-top: 4px; flex-wrap: wrap; }
.btn-rm-exp {
    background: none; border: 1px solid #fecaca; border-radius: 8px;
    color: var(--danger); cursor: pointer; padding: 8px 10px; font-size: 14px;
    transition: background .1s; width: 36px; height: 36px;
    display: flex; align-items: center; justify-content: center;
}
.btn-rm-exp:hover { background: #fef2f2; }
.btn-add-exp {
    font-size: 12px; padding: 5px 12px; border-radius: 20px;
    background: var(--bg); border: 1px solid var(--border);
    cursor: pointer; font-weight: 700; color: var(--text-2);
    transition: all .1s;
}
.btn-add-exp:hover { background: var(--primary, #2563eb); color: #fff; border-color: transparent; }

/* Profit pct */
.profit-pct-wrap { display: flex; align-items: center; gap: 8px; margin-top: 8px; }
.profit-pct-wrap input[type=range] { flex: 1; }
.pct-input {
    width: 64px; padding: 6px 8px;
    border: 1px solid var(--border); border-radius: 8px;
    font-size: 13px; text-align: center;
}

/* Calc box */
.calc-box {
    margin-top: 12px; padding: 14px 16px; border-radius: 12px;
    background: #f8fafc; border: 1px solid var(--border);
    display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px;
}
.calc-item { font-size: 12px; color: var(--text-2); }
.calc-item strong { display: block; font-size: 15px; color: var(--text); margin-top: 3px; }
.calc-item.highlight strong { font-size: 16px; color: var(--primary, #2563eb); }
</style>
@endpush

@section('content')

{{-- Stats --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:14px">
    <div class="stat-card">
        <div class="stat-label">Tổng xe</div>
        <div class="stat-val">{{ $summary['total_cars'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Tổng chi phí</div>
        <div class="stat-val" style="font-size:22px">
            {{ $summary['total_cost'] > 0 ? number_format($summary['total_cost'],0,',','.') . ' ₫' : '—' }}
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Tổng doanh thu</div>
        <div class="stat-val" style="font-size:22px">
            {{ $summary['total_revenue'] > 0 ? number_format($summary['total_revenue'],0,',','.') . ' ₫' : '—' }}
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Tổng lợi nhuận</div>
        @php $p = $summary['total_profit']; @endphp
        <div class="stat-val {{ $p >= 0 ? 'pos' : 'neg' }}" style="font-size:22px">
            {{ $p >= 0 ? '+' : '' }}{{ number_format($p,0,',','.') }} ₫
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="filter-bar">
    <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap;width:100%">
        <div class="search-wrap" style="flex:1;min-width:200px">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input class="form-control search-wrap" type="text" name="search" placeholder="Tìm tên xe..." value="{{ request('search') }}">
        </div>
        <select name="status" class="form-control" style="width:160px">
            <option value="">Tất cả trạng thái</option>
            <option value="available" {{ request('status')=='available'?'selected':'' }}>Còn hàng</option>
            <option value="reserved"  {{ request('status')=='reserved'?'selected':'' }}>Đã đặt cọc</option>
            <option value="sold"      {{ request('status')=='sold'?'selected':'' }}>Đã bán</option>
        </select>
        <button type="submit" class="btn btn-primary">Lọc</button>
        <a href="{{ route('admin.profit.index') }}" class="btn">Xoá lọc</a>
    </form>
</div>

{{-- Table --}}
<div class="card">
    <table>
        <thead>
            <tr>
                <th>Xe</th>
                <th>Giá nhập</th>
                <th>Chi phí phát sinh</th>
                <th>Tổng chi phí</th>
                <th>Giá bán</th>
                <th>Lợi nhuận</th>
                <th>Trạng thái</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse($cars as $car)
            @php
                $cost      = (float)($car->cost_price ?? 0);
                $expSum    = $car->expenses->sum('amount');
                $totalCost = $cost + $expSum;
                $revenue   = (float)($car->sale_price ?? 0);
                $profit    = $revenue - $totalCost;
                $hasData   = $revenue > 0 && $totalCost > 0;
                $status    = $car->status_label;
            @endphp
            <tr>
                <td>
                    <div style="font-weight:700;font-size:14px">{{ $car->name }}</div>
                    <div style="font-size:12px;color:var(--text-3)">{{ $car->brand?->name }}</div>
                </td>
                <td>{{ $cost > 0 ? number_format($cost,0,',','.') . ' ₫' : '—' }}</td>
                <td>{{ $expSum > 0 ? number_format($expSum,0,',','.') . ' ₫' : '—' }}</td>
                <td style="font-weight:600">{{ $totalCost > 0 ? number_format($totalCost,0,',','.') . ' ₫' : '—' }}</td>
                <td>{{ $revenue > 0 ? number_format($revenue,0,',','.') . ' ₫' : '—' }}</td>
                <td class="{{ $hasData ? ($profit >= 0 ? 'profit-pos' : 'profit-neg') : '' }}">
                    {{ $hasData ? ($profit >= 0 ? '+' : '') . number_format($profit,0,',','.') . ' ₫' : '—' }}
                </td>
                <td><span class="badge badge-{{ $status['color'] === 'green' ? 'green' : ($status['color'] === 'red' ? 'red' : 'amber') }}">{{ $status['label'] }}</span></td>
                <td>
                    <button class="btn btn-sm" onclick="openModal({{ $car->id }})">Nhập chi phí</button>
                    <a href="{{ route('admin.profit.show', $car) }}" class="btn btn-sm">Chi tiết</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" style="text-align:center;color:var(--text-3);padding:40px">Chưa có xe nào</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

{{ $cars->links() }}

{{-- ── MODAL NHẬP CHI PHÍ ── --}}
<div class="modal-overlay" id="modal-overlay" onclick="closeModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()">

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
            <div class="modal-title" id="modal-car-name" style="margin-bottom:0">Nhập chi phí</div>
            <button type="button" onclick="closeModal()" style="background:none;border:none;cursor:pointer;color:var(--text-2);font-size:20px;line-height:1;padding:4px">×</button>
        </div>

        <form method="POST" id="expense-form" novalidate>
            @csrf
            @method('PUT')

            {{-- Giá nhập --}}
            <div class="form-group">
                <label class="form-label">Giá nhập xe</label>
                <div class="input-select-wrap">
                    <input type="number" name="cost_price" id="modal-cost" class="form-control"
                           placeholder="Nhập hoặc chọn giá nhập..." min="0" oninput="recalc()">
                    <div class="select-arrow">▾</div>
                    <div class="dropdown-opts" id="dd-cost">
                        @foreach([500000000=>['500tr',''],800000000=>['800tr',''],1000000000=>['1 tỷ',''],1200000000=>['1.2 tỷ',''],1500000000=>['1.5 tỷ',''],2000000000=>['2 tỷ','phổ biến'],2500000000=>['2.5 tỷ',''],3000000000=>['3 tỷ',''],5000000000=>['5 tỷ','cao cấp']] as $v => $meta)
                        <div class="dd-opt" onclick="setVal('modal-cost', {{ $v }}); closeDd('dd-cost')">
                            <span class="dd-label">{{ $meta[0] }}</span>
                            @if($meta[1])<span class="dd-tag">{{ $meta[1] }}</span>@endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Chi phí phát sinh --}}
            <div style="margin-top:16px">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
                    <label class="form-label" style="margin:0">Chi phí phát sinh</label>
                    <button type="button" class="btn-add-exp" onclick="addExpRow()">+ Thêm</button>
                </div>
                <div id="exp-list"></div>
            </div>

            {{-- % lợi nhuận --}}
            <div style="margin-top:16px">
                <label class="form-label">Biên lợi nhuận mong muốn</label>
                <div class="profit-pct-wrap">
                    <input type="range" id="profit-pct-range" min="0" max="50" step="0.5" value="10" oninput="recalc()">
                    <span class="pct-badge" id="profit-pct-label">10%</span>
                    <input type="number" id="profit-pct-input" value="10" min="0" max="100" step="0.5"
                           class="pct-input" oninput="syncRange(this)">
                    <span style="font-size:12px;color:var(--text-2)">%</span>
                </div>
            </div>

            {{-- Calc box --}}
            <div class="calc-box" id="calc-box" style="display:none">
                <div class="calc-item">
                    <span>Tổng chi phí</span>
                    <strong id="calc-total-cost">—</strong>
                </div>
                <div class="calc-item highlight">
                    <span>Giá bán đề xuất</span>
                    <strong id="calc-sale-price">—</strong>
                </div>
                <div class="calc-item">
                    <span>Lợi nhuận</span>
                    <strong id="calc-profit">—</strong>
                </div>
            </div>

            {{-- Giá bán --}}
            <div class="form-group" style="margin-top:14px">
                <label class="form-label">Giá bán <span style="font-weight:400;color:var(--text-2)">(tự động — có thể chỉnh tay)</span></label>
                <div class="input-select-wrap">
                    <input type="number" name="sale_price" id="modal-sale" class="form-control"
                           placeholder="Giá bán (₫)" min="0" oninput="recalcFromSale()">
                    <div class="select-arrow">▾</div>
                    <div class="dropdown-opts" id="dd-sale">
                        @foreach([1000000000=>['1 tỷ',''],1500000000=>['1.5 tỷ',''],2000000000=>['2 tỷ',''],2500000000=>['2.5 tỷ','phổ biến'],3000000000=>['3 tỷ',''],3500000000=>['3.5 tỷ',''],4000000000=>['4 tỷ',''],5000000000=>['5 tỷ','cao cấp']] as $v => $meta)
                        <div class="dd-opt" onclick="setVal('modal-sale', {{ $v }}); closeDd('dd-sale')">
                            <span class="dd-label">{{ $meta[0] }}</span>
                            @if($meta[1])<span class="dd-tag">{{ $meta[1] }}</span>@endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:20px;padding-top:16px;border-top:1px solid var(--border)">
                <button type="button" class="btn" onclick="closeModal()">Huỷ</button>
                <button type="button" class="btn btn-primary" onclick="submitExpenseForm()">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>

<script>
const EXPENSE_PRESETS = [
    { label: 'Vận chuyển nội địa',  category: 'vận_chuyển', amounts: [10000000, 30000000, 50000000] },
    { label: 'Vận chuyển quốc tế',  category: 'vận_chuyển', amounts: [50000000, 80000000, 120000000] },
    { label: 'Thuế nhập khẩu',      category: 'thuế',       amounts: [100000000, 200000000, 500000000] },
    { label: 'Thuế tiêu thụ đặc biệt', category: 'thuế',    amounts: [200000000, 400000000, 800000000] },
    { label: 'Thuế VAT',            category: 'thuế',       amounts: [50000000, 100000000, 200000000] },
    { label: 'Đăng ký biển số',     category: 'đăng_ký',   amounts: [2000000, 5000000, 10000000] },
    { label: 'Phí trước bạ',        category: 'đăng_ký',   amounts: [20000000, 50000000, 100000000] },
    { label: 'Sửa chữa / tân trang',category: 'sửa_chữa',  amounts: [5000000, 20000000, 50000000] },
    { label: 'Hoa hồng môi giới',   category: 'hoa_hồng',  amounts: [5000000, 10000000, 20000000] },
    { label: 'Marketing / đăng tin',category: 'marketing',  amounts: [500000, 1000000, 3000000] },
    { label: 'Bảo hiểm xe',         category: 'bảo_hiểm',  amounts: [3000000, 7000000, 15000000] },
    { label: 'Chi phí khác',        category: '',           amounts: [1000000, 5000000, 10000000] },
];

const QUICK = {
    'vận_chuyển': [50000000, 80000000, 120000000],
    'thuế':       [100000000, 200000000, 500000000],
    'đăng_ký':    [2000000, 5000000, 10000000],
    'sửa_chữa':   [5000000, 20000000, 50000000],
    'marketing':  [500000, 1000000, 3000000],
    'hoa_hồng':   [5000000, 10000000, 20000000],
    'bảo_hiểm':   [3000000, 7000000, 15000000],
};

const BASE_URL = '{{ route("admin.profit.update", ":id") }}';
let currentCarId = null;

@php
$carsJson = $cars->keyBy('id')->map(function($c) {
    return [
        'name'       => $c->name,
        'cost_price' => $c->cost_price,
        'sale_price' => $c->sale_price,
        'expenses'   => $c->expenses->map(function($e) {
            return ['name' => $e->name, 'amount' => (float)$e->amount, 'category' => $e->category];
        })->values(),
    ];
});
@endphp
let carsData = @json($carsJson);

// ── Format helpers ─────────────────────────────────────────────
function fmtQ(n) {
    if (n >= 1e9) return (n/1e9).toFixed(n%1e9===0?0:1) + 'tỷ';
    if (n >= 1e6) return Math.round(n/1e6) + 'tr';
    return Math.round(n/1e3) + 'k';
}
function fmt(n) {
    return new Intl.NumberFormat('vi-VN').format(Math.round(n)) + ' ₫';
}

// ── Dropdown ───────────────────────────────────────────────────
document.addEventListener('click', function(e) {
    if (!e.target.closest('.input-select-wrap')) {
        document.querySelectorAll('.dropdown-opts.open').forEach(d => d.classList.remove('open'));
    }
});
document.querySelectorAll('.select-arrow').forEach(arrow => {
    arrow.addEventListener('click', function(e) {
        e.stopPropagation();
        const dd = this.parentElement.querySelector('.dropdown-opts');
        const isOpen = dd.classList.contains('open');
        document.querySelectorAll('.dropdown-opts.open').forEach(d => d.classList.remove('open'));
        if (!isOpen) dd.classList.add('open');
    });
});
function closeDd(id) {
    document.getElementById(id)?.classList.remove('open');
}

// ── Expense preset dropdown ────────────────────────────────────
function buildPresetDropdown(wrap, currentCat) {
    const dd = wrap.querySelector('.exp-preset-dd');
    dd.innerHTML = '';
    EXPENSE_PRESETS.forEach((p, i) => {
        const div = document.createElement('div');
        div.className = 'dd-opt' + (p.category === currentCat ? ' selected' : '');
        div.innerHTML = `<span class="dd-label">${p.label}</span>`;
        div.onclick = () => {
            wrap.querySelector('.exp-name-input').value = p.label;
            wrap.querySelector('input[type="hidden"]').value = p.category;
            updateAmountQuick(wrap, p.amounts);
            dd.classList.remove('open');
        };
        dd.appendChild(div);
    });
}

function updateAmountQuick(wrap, amounts) {
    wrap.querySelector('.quick-row').innerHTML = amounts
        .map(v => `<span class="quick-val" onclick="setRowAmt(this, ${v})">${fmtQ(v)}</span>`)
        .join('');
}

// ── Lấy tổng chi phí ──────────────────────────────────────────
function getTotalCost() {
    const cost    = parseFloat(document.getElementById('modal-cost').value) || 0;
    const expRows = document.querySelectorAll('#exp-list input[type="number"][name^="expenses["]');
    let expSum    = 0;
    expRows.forEach(r => expSum += parseFloat(r.value) || 0);
    return { cost, expSum, total: cost + expSum };
}

// ── Tính giá bán từ tổng chi phí + % lời ──────────────────────
function recalc() {
    const pct       = parseFloat(document.getElementById('profit-pct-input').value) || 0;
    const { total } = getTotalCost();
    const salePrice = total > 0 ? Math.round(total * (1 + pct / 100)) : 0;
    if (total > 0) {
        document.getElementById('modal-sale').value = salePrice;
    }
    updateCalcBox();
}

function recalcFromSale() {
    const { total } = getTotalCost();
    const sale      = parseFloat(document.getElementById('modal-sale').value) || 0;
    if (total > 0 && sale > 0) {
        const pct = ((sale - total) / total * 100).toFixed(1);
        document.getElementById('profit-pct-input').value = pct;
        document.getElementById('profit-pct-range').value  = Math.min(pct, 50);
        document.getElementById('profit-pct-label').textContent = pct + '%';
    }
    updateCalcBox();
}

function updateCalcBox() {
    const { total } = getTotalCost();
    const sale      = parseFloat(document.getElementById('modal-sale').value) || 0;
    const profit    = sale - total;
    const box       = document.getElementById('calc-box');
    if (total > 0 || sale > 0) {
        box.style.display = 'grid';
        document.getElementById('calc-total-cost').textContent = fmt(total);
        document.getElementById('calc-sale-price').textContent = sale > 0 ? fmt(sale) : '—';
        const profitEl = document.getElementById('calc-profit');
        profitEl.textContent = sale > 0 ? (profit >= 0 ? '+' : '') + fmt(profit) : '—';
        profitEl.style.color = profit >= 0 ? 'var(--success)' : 'var(--danger)';
    } else {
        box.style.display = 'none';
    }
}

function syncRange(input) {
    const v = parseFloat(input.value) || 0;
    document.getElementById('profit-pct-range').value = Math.min(v, 50);
    document.getElementById('profit-pct-label').textContent = v + '%';
    recalc();
}

document.getElementById('profit-pct-range').addEventListener('input', function() {
    const v = this.value;
    document.getElementById('profit-pct-input').value = v;
    document.getElementById('profit-pct-label').textContent = v + '%';
    recalc();
});

function setVal(id, val) {
    document.getElementById(id).value = val;
    id === 'modal-cost' ? recalc() : recalcFromSale();
}

// ── Submit ─────────────────────────────────────────────────────
function submitExpenseForm() {
    updateCalcBox();
    const saleVal = document.getElementById('modal-sale').value;
    if (!saleVal || parseFloat(saleVal) <= 0) {
        alert('Vui lòng nhập giá nhập để tính giá bán, hoặc nhập giá bán thủ công.');
        return;
    }
    const form = document.getElementById('expense-form');
    form.action = BASE_URL.replace(':id', currentCarId);
    form.submit();
}

// ── Open / Close modal ─────────────────────────────────────────
function openModal(carId) {
    currentCarId = carId;
    const car = carsData[carId];
    document.getElementById('modal-car-name').textContent = car.name;
    document.getElementById('modal-cost').value = car.cost_price ?? '';
    document.getElementById('modal-sale').value = car.sale_price ?? '';

    document.getElementById('profit-pct-range').value = 10;
    document.getElementById('profit-pct-input').value = 10;
    document.getElementById('profit-pct-label').textContent = '10%';

    expRowIndex = 0;
    const list = document.getElementById('exp-list');
    list.innerHTML = '';
    car.expenses.forEach(e => addExpRow(e.name, e.amount, e.category));

    if (car.sale_price) {
        recalcFromSale();
    } else {
        recalc();
    }

    // Re-init dropdown arrows (since modal content updated)
    document.querySelectorAll('#modal-overlay .select-arrow').forEach(arrow => {
        arrow.onclick = function(e) {
            e.stopPropagation();
            const dd = this.parentElement.querySelector('.dropdown-opts');
            const isOpen = dd.classList.contains('open');
            document.querySelectorAll('.dropdown-opts.open').forEach(d => d.classList.remove('open'));
            if (!isOpen) dd.classList.add('open');
        };
    });

    document.getElementById('modal-overlay').classList.add('open');
}

function closeModal(e) {
    if (!e || e.target === document.getElementById('modal-overlay')) {
        document.querySelectorAll('.dropdown-opts.open').forEach(d => d.classList.remove('open'));
        document.getElementById('modal-overlay').classList.remove('open');
    }
}

// ── Expense rows ───────────────────────────────────────────────
let expRowIndex = 0;

function addExpRow(name='', amount='', category='') {
    const list = document.getElementById('exp-list');
    const div  = document.createElement('div');
    div.className = 'exp-row-wrap';

    const idx    = expRowIndex++;
    const catVal = category || '';

    // Find preset for this category/name
    let preset = EXPENSE_PRESETS.find(p => p.category === catVal && p.label === name)
              || EXPENSE_PRESETS.find(p => p.category === catVal)
              || EXPENSE_PRESETS[0];
    const amounts = preset ? preset.amounts : [5000000, 20000000, 50000000];
    const qbtns = amounts.map(v => `<span class="quick-val" onclick="setRowAmt(this, ${v})">${fmtQ(v)}</span>`).join('');

    // Build preset options
    const presetOpts = EXPENSE_PRESETS.map(p =>
        `<div class="dd-opt${p.label === name ? ' selected' : ''}"
              onclick="selectPreset(this, ${idx}, '${p.label.replace(/'/g,"\\'")}', '${p.category}', [${p.amounts.join(',')}])">
            <span class="dd-label">${p.label}</span>
         </div>`
    ).join('');

    const safeAmount = amount ? Number(amount) : '';

    div.innerHTML = `
        <div class="exp-row">
            <div class="input-select-wrap" style="position:relative">
                <input type="text" class="exp-name-input" name="expenses[${idx}][name]"
                       placeholder="Chọn hoặc nhập tên..." value="${name}" oninput="recalc()">
                <div class="select-arrow" onclick="toggleExpDd(this)">▾</div>
                <div class="dropdown-opts exp-preset-dd" id="exp-dd-${idx}">
                    ${presetOpts}
                </div>
            </div>
            <div>
                <input type="number" name="expenses[${idx}][amount]" placeholder="Số tiền (₫)"
                       value="${safeAmount}" min="0" oninput="recalc()">
                <div class="quick-row">${qbtns}</div>
            </div>
            <button type="button" class="btn-rm-exp" onclick="this.closest('.exp-row-wrap').remove();recalc()">×</button>
        </div>
        <input type="hidden" name="expenses[${idx}][category]" value="${catVal}">
    `;
    list.appendChild(div);
}

function toggleExpDd(arrow) {
    const dd = arrow.parentElement.querySelector('.dropdown-opts');
    const isOpen = dd.classList.contains('open');
    document.querySelectorAll('.dropdown-opts.open').forEach(d => d.classList.remove('open'));
    if (!isOpen) dd.classList.add('open');
}

function selectPreset(el, idx, label, cat, amounts) {
    const wrap = el.closest('.exp-row-wrap');
    wrap.querySelector('.exp-name-input').value = label;
    wrap.querySelector(`input[name="expenses[${idx}][category]"]`).value = cat;
    wrap.querySelector('.quick-row').innerHTML = amounts
        .map(v => `<span class="quick-val" onclick="setRowAmt(this, ${v})">${fmtQ(v)}</span>`)
        .join('');
    el.closest('.dropdown-opts').classList.remove('open');
    recalc();
}

function setRowAmt(btn, val) {
    btn.closest('.exp-row').querySelector('input[type=number]').value = val;
    recalc();
}
</script>

@endsection