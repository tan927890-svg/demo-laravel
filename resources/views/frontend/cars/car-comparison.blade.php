{{--
    PARTIAL: resources/views/frontend/cars/_comparison.blade.php
    USAGE  : @include('frontend.cars._comparison', ['car' => $car, 'relatedCars' => $relatedCars])
    REQUIRE: $car->load(['variants', 'specs'])
             $relatedCars->load(['variants', 'specs'])
--}}

@php
/**
 * Lấy URL ảnh xe (dùng lại helper carImgPath nếu đã khai báo ở show.blade)
 * Nếu partial này được dùng độc lập, khai báo lại ở đây
 */
if (!function_exists('compImgUrl')) {
    function compImgUrl($val): ?string {
        if (!$val) return null;
        $val = trim($val);
        if ($val === '') return null;
        if (preg_match('#^https?://#i', $val)) return $val;
        $val = ltrim($val, '/');
        $segs = explode('/', $val);
        $enc  = array_map(fn($s) => rawurlencode(rawurldecode($s)), $segs);
        return asset(implode('/', $enc));
    }
}

/** Lấy ảnh đầu tiên có sẵn của xe */
function compCarImg($c): ?string {
    foreach (['image_url', 'image', 'hero_image'] as $f) {
        $url = compImgUrl($c->$f ?? null);
        if ($url) return $url;
    }
    return null;
}

/** Chuẩn bị dữ liệu 1 xe thành mảng JS-safe */
function compCarData($c): array {
    return [
        'id'       => $c->id,
        'name'     => $c->name,
        'brand'    => $c->brand?->name ?? (string)($c->brand ?? ''),
        'img'      => compCarImg($c),
        'variants' => $c->variants
                        ->unique('name')
                        ->values()
                        ->map(fn($v) => ['name' => $v->name, 'price' => (int)$v->price])
                        ->toArray(),
        'specs'    => $c->specs
                        ->groupBy('category')
                        ->map(fn($g) => $g->pluck('spec_value', 'spec_key'))
                        ->toArray(),
    ];
}

$compMainCar  = compCarData($car);
$compAllCars  = collect([$car])
                    ->concat($relatedCars)
                    ->map(fn($c) => compCarData($c))
                    ->values()
                    ->toArray();
@endphp

{{-- ══════════════════════════════════════════════════════════════
     SECTION
══════════════════════════════════════════════════════════════ --}}
<section class="section section-alt" id="so-sanh">

{{-- ── CSS (scoped, chỉ load 1 lần nhờ @once) ────────────────── --}}
@once
<style>
/* ── Comparison Section ── */
.cmp-wrap { padding: 0; }
.cmp-header { padding: 40px 60px 28px; }

/* Cột xe */
.cmp-cols { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; padding: 0 60px 24px; }
.cmp-col { border: 1px solid #e5e5e5; border-radius: 8px; overflow: hidden; background: #fff; }
.cmp-col.cmp-active { border-color: #cc0000; }

.cmp-img-wrap { height: 130px; display: flex; align-items: center; justify-content: center; background: #f8f8f8; padding: 12px; }
.cmp-img-wrap img { max-height: 100px; max-width: 100%; object-fit: contain; }

.cmp-placeholder { height: 130px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; background: #f8f8f8; cursor: pointer; border: none; width: 100%; }
.cmp-placeholder:hover { background: #f0ece2; }
.cmp-placeholder svg { opacity: .18; }
.cmp-placeholder span { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: #888; }

.cmp-name-row { display: flex; }
.cmp-badge { background: #cc0000; color: #fff; font-family: 'Barlow Condensed', sans-serif; font-size: 14px; font-weight: 700; padding: 9px 14px; flex: 1; display: flex; align-items: center; justify-content: space-between; letter-spacing: 0.4px; min-width: 0; }
.cmp-badge-name { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.cmp-badge-btns button { background: none; border: none; cursor: pointer; color: rgba(255,255,255,.65); font-size: 14px; padding: 0 4px; line-height: 1; }
.cmp-badge-btns button:hover { color: #fff; }
.cmp-remove { background: #fff; border: none; border-left: 1px solid #e5e5e5; cursor: pointer; padding: 9px 12px; color: #aaa; font-size: 15px; flex-shrink: 0; }
.cmp-remove:hover { color: #cc0000; }

.cmp-select-btn { width: 100%; padding: 9px; border: 1px solid #cc0000; color: #cc0000; background: #fff; font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; }
.cmp-select-btn:hover { background: #cc0000; color: #fff; }

.cmp-variant-wrap { position: relative; }
.cmp-variant-wrap select { width: 100%; padding: 9px 30px 9px 14px; border: none; border-top: 1px solid #e5e5e5; font-size: 13px; font-family: 'Barlow', sans-serif; background: #fff; color: #333; appearance: none; cursor: pointer; }
.cmp-variant-wrap::after { content: '⌄'; position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #999; font-size: 13px; }

/* Bảng thông số */
.cmp-table-wrap { padding: 0 60px 60px; }
.cmp-table { width: 100%; border: 1px solid #e5e5e5; border-radius: 8px; overflow: hidden; }
.cmp-table-head { display: grid; grid-template-columns: 180px repeat(3, 1fr); background: #cc0000; }
.cmp-table-head > div { padding: 10px 14px; font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #fff; }
.cmp-table-head > div:not(:first-child) { border-left: 1px solid rgba(255,255,255,.15); text-align: center; }
.cmp-cat { display: grid; grid-template-columns: 180px repeat(3, 1fr); background: rgba(204,0,0,.07); border-top: 1px solid rgba(204,0,0,.15); border-bottom: 1px solid rgba(204,0,0,.15); }
.cmp-cat > div { padding: 8px 14px; font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: #cc0000; }
.cmp-cat > div:not(:first-child) { border-left: 1px solid rgba(204,0,0,.1); }
.cmp-row { display: grid; grid-template-columns: 180px repeat(3, 1fr); border-bottom: .5px solid #e5e5e5; }
.cmp-row:last-child { border-bottom: none; }
.cmp-row:nth-child(odd) { background: #fafaf8; }
.cmp-row:nth-child(even) { background: #fff; }
.cmp-key { padding: 9px 14px; font-size: 12px; color: #777; font-family: 'Barlow', sans-serif; display: flex; align-items: center; }
.cmp-val { padding: 9px 10px; font-size: 12px; color: #222; font-family: 'Barlow', sans-serif; text-align: center; border-left: .5px solid #e5e5e5; display: flex; align-items: center; justify-content: center; line-height: 1.4; }
.cmp-val.cmp-primary { background: rgba(204,0,0,.04); }
.cmp-val.cmp-empty { color: #ccc; }

/* Picker modal */
.cmp-overlay { display: none; position: fixed; inset: 0; z-index: 99999; background: rgba(0,0,0,.55); align-items: center; justify-content: center; }
.cmp-overlay.open { display: flex; }
.cmp-picker { background: #fff; border-radius: 12px; padding: 24px; width: min(480px,92vw); max-height: 68vh; overflow-y: auto; }
.cmp-picker-title { font-family: 'Barlow Condensed', sans-serif; font-size: 20px; font-weight: 900; text-transform: uppercase; color: #111; letter-spacing: -.5px; margin-bottom: 16px; }
.cmp-picker-list { display: flex; flex-direction: column; gap: 8px; }
.cmp-picker-item { display: flex; align-items: center; gap: 14px; padding: 10px 12px; border: .5px solid #e5e5e5; border-radius: 8px; cursor: pointer; }
.cmp-picker-item:hover { border-color: #cc0000; background: rgba(204,0,0,.03); }
.cmp-picker-item img { width: 72px; height: 46px; object-fit: contain; background: #f5f5f5; border-radius: 4px; flex-shrink: 0; }
.cmp-picker-item .pi-name { font-family: 'Barlow Condensed', sans-serif; font-size: 15px; font-weight: 700; text-transform: uppercase; color: #111; }
.cmp-picker-item .pi-brand { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: #888; }
.cmp-picker-cancel { width: 100%; margin-top: 14px; padding: 10px; border: 1px solid #e5e5e5; border-radius: 6px; background: #f5f5f5; cursor: pointer; font-size: 13px; color: #666; font-family: 'Barlow', sans-serif; }
.cmp-picker-cancel:hover { color: #111; background: #eee; }

/* Responsive */
@media(max-width: 1024px) {
    .cmp-header, .cmp-table-wrap { padding-left: 24px; padding-right: 24px; }
    .cmp-cols { padding-left: 24px; padding-right: 24px; }
}
@media(max-width: 768px) {
    .cmp-cols { grid-template-columns: 1fr; padding: 0 20px 16px; }
    .cmp-header { padding: 32px 20px 20px; }
    .cmp-table-wrap { padding: 0 0 48px; }
    .cmp-table { border-radius: 0; border-left: none; border-right: none; }
    .cmp-table-head, .cmp-cat, .cmp-row { grid-template-columns: 130px repeat(3, 1fr); }
    .cmp-key { font-size: 11px; padding: 8px 10px; }
    .cmp-val { font-size: 11px; padding: 8px 6px; }
}
</style>
@endonce

{{-- ── MARKUP ─────────────────────────────────────────────────── --}}
<div class="cmp-wrap">
    {{-- Header --}}
    <div class="cmp-header container">
        <div class="section-label">Đánh giá</div>
        <div class="section-title">So Sánh <em>Sản Phẩm</em></div>
    </div>

    {{-- Cols --}}
    <div class="cmp-cols" id="cmp-cols"></div>

    {{-- Table --}}
    <div class="cmp-table-wrap">
        <div class="cmp-table" id="cmp-table"></div>
    </div>
</div>

{{-- Picker Overlay --}}
<div class="cmp-overlay" id="cmp-overlay">
    <div class="cmp-picker">
        <div class="cmp-picker-title">Chọn xe để so sánh</div>
        <div class="cmp-picker-list" id="cmp-picker-list"></div>
        <button class="cmp-picker-cancel" onclick="cmpClosePicker()">Đóng</button>
    </div>
</div>

</section>

{{-- ══════════════════════════════════════════════════════════════
     SCRIPT
══════════════════════════════════════════════════════════════ --}}
@push('scripts')
<script>
(function () {
'use strict';

/* ── 1. Dữ liệu từ Laravel ─────────────────────────────── */
const CMP_CARS = @json($compAllCars);

/* ── 2. State ───────────────────────────────────────────── */
let slots       = [0, null, null];   // slot 0 luôn là xe đang xem
let vIdxs       = {};                // variant đang chọn mỗi xe
CMP_CARS.forEach((_, i) => vIdxs[i] = 0);
let pickerSlot  = null;

/* ── 3. Helpers ─────────────────────────────────────────── */
function specVal(carIdx, cat, key) {
    if (carIdx === null) return null;
    return CMP_CARS[carIdx].specs?.[cat]?.[key] ?? '–';
}

function fmtPrice(p) {
    return new Intl.NumberFormat('vi-VN').format(p) + ' VNĐ';
}

/* ── 4. Render cột xe ───────────────────────────────────── */
function renderCols() {
    const wrap = document.getElementById('cmp-cols');
    wrap.innerHTML = '';

    for (let s = 0; s < 3; s++) {
        const idx = slots[s];
        const col = document.createElement('div');
        col.className = 'cmp-col' + (idx !== null ? ' cmp-active' : '');

        if (idx !== null) {
            const car  = CMP_CARS[idx];
            const vi   = vIdxs[idx] ?? 0;
            const opts = (car.variants || [])
                .map((v, i) => `<option value="${i}" ${i === vi ? 'selected' : ''}>${v.name}</option>`)
                .join('');
            const img  = car.img
                ? `<img src="${car.img}" alt="${car.name}"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">`
                : '';
            const removeBtnHtml = s > 0
                ? `<button class="cmp-remove" onclick="cmpRemove(${s})" title="Xóa">✕</button>`
                : '';

            col.innerHTML = `
                <div class="cmp-img-wrap">
                    ${img}
                    <div style="display:${car.img ? 'none' : 'flex'};width:100%;height:100%;align-items:center;justify-content:center;">
                        <span style="font-family:'Barlow Condensed',sans-serif;font-size:13px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(0,0,0,.15);">${car.name}</span>
                    </div>
                </div>
                <div class="cmp-name-row">
                    <div class="cmp-badge">
                        <span class="cmp-badge-name">${car.name}</span>
                        <div class="cmp-badge-btns">
                            <button onclick="cmpOpenPicker(${s})" title="Đổi xe">↺</button>
                        </div>
                    </div>
                    ${removeBtnHtml}
                </div>
                <div class="cmp-variant-wrap">
                    <select onchange="cmpChangeVariant(${s}, this.value)">${opts}</select>
                </div>`;
        } else {
            col.innerHTML = `
                <button class="cmp-placeholder" onclick="cmpOpenPicker(${s})">
                    <svg width="56" height="36" viewBox="0 0 80 48" fill="none">
                        <path d="M8 34L12 22Q14 16 22 14L28 13L34 6Q36 4 40 4L52 4Q56 4 60 8L66 14L70 14Q76 14 78 20L80 28L80 34Q80 38 76 38L72 38Q72 44 66 44Q60 44 60 38L20 38Q20 44 14 44Q8 44 8 38Z" fill="#999" opacity="0.35"/>
                        <text x="40" y="30" text-anchor="middle" font-size="20" fill="#999" opacity="0.5">+</text>
                    </svg>
                    <span>Chọn thêm sản phẩm</span>
                </button>
                <button class="cmp-select-btn" onclick="cmpOpenPicker(${s})">
                    Chọn thêm sản phẩm +
                </button>`;
        }

        wrap.appendChild(col);
    }
}

/* ── 5. Render bảng thông số ────────────────────────────── */
function renderTable() {
    const wrap    = document.getElementById('cmp-table');
    const firstCar = slots.map(s => s !== null ? CMP_CARS[s] : null).find(Boolean);
    if (!firstCar || !firstCar.specs) { wrap.innerHTML = ''; return; }

    const cats  = Object.keys(firstCar.specs);
    const names = slots.map(s => s !== null
        ? CMP_CARS[s].name.split(' ').slice(0, 3).join(' ')
        : '');

    let html = `
        <div class="cmp-table-head">
            <div>Thông số</div>
            ${names.map(n => `<div>${n}</div>`).join('')}
        </div>`;

    for (const cat of cats) {
        const keys = Object.keys(firstCar.specs[cat] || {});
        if (!keys.length) continue;

        html += `
            <div class="cmp-cat">
                <div>${cat}</div>
                ${slots.map(() => '<div></div>').join('')}
            </div>`;

        for (const key of keys) {
            const vals = slots.map(s => specVal(s, cat, key));
            html += `
                <div class="cmp-row">
                    <div class="cmp-key">${key}</div>
                    ${vals.map((v, i) => {
                        if (slots[i] === null) return `<div class="cmp-val cmp-empty">—</div>`;
                        return `<div class="cmp-val${i === 0 ? ' cmp-primary' : ''}">${v}</div>`;
                    }).join('')}
                </div>`;
        }
    }

    wrap.innerHTML = html;
}

/* ── 6. Picker ──────────────────────────────────────────── */
window.cmpOpenPicker = function (slot) {
    pickerSlot = slot;
    const list = document.getElementById('cmp-picker-list');
    list.innerHTML = '';

    let hasItems = false;
    CMP_CARS.forEach((car, idx) => {
        if (slots.includes(idx)) return;
        hasItems = true;
        const item = document.createElement('div');
        item.className = 'cmp-picker-item';
        item.innerHTML = `
            ${car.img
                ? `<img src="${car.img}" alt="${car.name}" onerror="this.style.display='none'">`
                : `<div style="width:72px;height:46px;background:#f5f5f5;border-radius:4px;flex-shrink:0;"></div>`}
            <div>
                <div class="pi-name">${car.name}</div>
                <div class="pi-brand">${car.brand}</div>
            </div>`;
        item.onclick = () => {
            slots[slot] = idx;
            vIdxs[idx]  = 0;
            cmpClosePicker();
            renderCols();
            renderTable();
        };
        list.appendChild(item);
    });

    if (!hasItems) {
        list.innerHTML = `<p style="text-align:center;color:#999;font-size:13px;padding:16px 0;">Không còn xe nào để thêm</p>`;
    }

    document.getElementById('cmp-overlay').classList.add('open');
    document.body.style.overflow = 'hidden';
};

window.cmpClosePicker = function () {
    document.getElementById('cmp-overlay').classList.remove('open');
    document.body.style.overflow = '';
    pickerSlot = null;
};

window.cmpRemove = function (slot) {
    slots[slot] = null;
    renderCols();
    renderTable();
};

window.cmpChangeVariant = function (slot, vi) {
    const idx = slots[slot];
    if (idx !== null) {
        vIdxs[idx] = parseInt(vi);
        renderTable();
    }
};

/* Click ngoài đóng picker */
document.getElementById('cmp-overlay').addEventListener('click', function (e) {
    if (e.target === this) cmpClosePicker();
});

/* ESC đóng picker */
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') cmpClosePicker();
});

/* ── 7. Init ─────────────────────────────────────────────── */
renderCols();
renderTable();

})();
</script>
@endpush
