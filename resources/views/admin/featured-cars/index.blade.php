{{-- resources/views/admin/featured-cars/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Quản lý Xe Nổi Bật')

@push('styles')
<style>
.feat-admin { max-width: 1300px; margin: 0 auto; padding: 32px 24px; }
.feat-admin h1 {
    font-size: 26px; font-weight: 800; margin-bottom: 4px;
    color: #111; letter-spacing: -.5px;
}
.feat-admin .subtitle { color: #888; font-size: 13px; margin-bottom: 16px; }

.filter-bar { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; margin-bottom: 28px; }
.filter-bar a {
    padding: 6px 14px; border: 1px solid #d1d5db; border-radius: 4px;
    text-decoration: none; font-size: 13px; color: #374151;
    transition: all .15s;
}
.filter-bar a:hover { background: #f3f4f6; }
.filter-bar a.active-feat {
    background: #1d4ed8; color: #fff; border-color: #1d4ed8; font-weight: 600;
}
.filter-bar .divider { color: #d1d5db; font-size: 18px; }

.section-card {
    background: #fff; border: 1px solid #e5e7eb;
    border-radius: 12px; overflow: hidden; margin-bottom: 32px;
}
.section-card-header {
    padding: 18px 24px; border-bottom: 1px solid #e5e7eb;
    display: flex; align-items: center; justify-content: space-between;
    background: #f9fafb;
}
.section-card-header h2 { font-size: 15px; font-weight: 700; color: #111; margin: 0; }
.badge-count {
    background: #1d4ed8; color: #fff; border-radius: 20px;
    font-size: 11px; font-weight: 700; padding: 2px 10px; margin-left: 8px;
}

.feat-list { padding: 16px 24px; display: flex; flex-direction: column; gap: 12px; }
.feat-row {
    display: grid; grid-template-columns: 100px 1fr 150px auto;
    gap: 16px; align-items: center;
    padding: 12px 16px; border: 1px solid #e5e7eb; border-radius: 8px;
    background: #fff; transition: border-color .2s;
}
.feat-row:hover { border-color: #1d4ed8; }
.feat-row.staff-row { grid-template-columns: 100px 1fr 150px; }
.feat-row-thumb {
    width: 100px; height: 60px; object-fit: contain; background: #f3f4f6;
    border-radius: 6px;
}
.feat-row-thumb-placeholder {
    width: 100px; height: 60px; background: #f3f4f6; border-radius: 6px;
    display: flex; align-items: center; justify-content: center; color: #ccc; font-size: 22px;
}
.feat-row-name { font-weight: 700; font-size: 15px; color: #111; }
.feat-row-badge-val {
    font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;
    color: #1d4ed8; background: #eff6ff; padding: 2px 8px; border-radius: 4px;
    display: inline-block; margin-top: 4px;
}
.feat-row-status { display: flex; flex-direction: column; gap: 6px; align-items: flex-start; }
.frame-status { font-size: 12px; color: #555; }
.frame-dots { display: flex; gap: 4px; margin-top: 2px; }
.frame-dot { width: 10px; height: 10px; border-radius: 50%; background: #e5e7eb; }
.frame-dot.filled { background: #22c55e; }
.feat-row-actions { display: flex; gap: 8px; flex-shrink: 0; }

.btn { display: inline-flex; align-items: center; gap: 6px; border-radius: 6px;
    font-size: 12px; font-weight: 700; letter-spacing: .5px;
    padding: 7px 14px; border: none; cursor: pointer; text-decoration: none;
    transition: all .2s; white-space: nowrap; }
.btn-primary { background: #1d4ed8; color: #fff; }
.btn-primary:hover { background: #1e40af; color: #fff; }
.btn-outline { background: #fff; color: #374151; border: 1.5px solid #d1d5db; }
.btn-outline:hover { background: #f3f4f6; }
.btn-danger { background: #fff; color: #dc2626; border: 1.5px solid #fca5a5; }
.btn-danger:hover { background: #fef2f2; }
.btn-danger-solid { background: #dc2626; color: #fff; border: none; }
.btn-danger-solid:hover { background: #b91c1c; color: #fff; }
.btn-success { background: #16a34a; color: #fff; }
.btn-success:hover { background: #15803d; color: #fff; }
.btn-sm { padding: 5px 11px; font-size: 11px; }

.avail-table { width: 100%; border-collapse: collapse; }
.avail-table th {
    font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;
    color: #6b7280; padding: 12px 16px; border-bottom: 1px solid #e5e7eb;
    text-align: left; background: #f9fafb;
}
.avail-table td { padding: 12px 16px; border-bottom: 1px solid #f3f4f6; }
.avail-table tr:last-child td { border-bottom: none; }
.avail-table tr:hover td { background: #fafafa; }

.mark-form { display: flex; gap: 8px; align-items: center; }
.mark-form input[type=text] {
    border: 1.5px solid #d1d5db; border-radius: 6px;
    padding: 6px 12px; font-size: 12px; width: 130px;
    outline: none; transition: border-color .2s;
}
.mark-form input[type=text]:focus { border-color: #1d4ed8; }

.alert-success {
    background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d;
    padding: 12px 18px; border-radius: 8px; font-size: 13px; margin-bottom: 20px;
}
.empty-feat { text-align: center; padding: 40px 20px; color: #9ca3af; font-size: 14px; }

/* ── Custom Confirm Modal ── */
.modal-overlay {
    display: none; position: fixed; inset: 0; z-index: 9999;
    background: rgba(0, 0, 0, .5);
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
    align-items: center; justify-content: center;
}
.modal-overlay.open { display: flex; }
.modal-box {
    background: #fff; border-radius: 16px; padding: 36px 32px 28px;
    max-width: 400px; width: 90%;
    box-shadow: 0 24px 80px rgba(0,0,0,.18), 0 4px 16px rgba(0,0,0,.08);
    text-align: center;
    animation: modalPop .2s cubic-bezier(.34,1.56,.64,1);
}
@keyframes modalPop {
    from { transform: scale(.88) translateY(12px); opacity: 0; }
    to   { transform: scale(1)   translateY(0);    opacity: 1; }
}
.modal-icon-wrap {
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
}
.modal-title {
    font-size: 18px; font-weight: 800; color: #111;
    margin-bottom: 8px; letter-spacing: -.3px;
}
.modal-desc {
    font-size: 13px; color: #6b7280; margin-bottom: 28px;
    line-height: 1.6;
}
.modal-desc strong { color: #111; }
.modal-actions {
    display: flex; gap: 10px; justify-content: center;
}
.modal-actions .btn {
    min-width: 120px; justify-content: center;
    padding: 9px 18px; font-size: 13px;
}

@media (max-width: 700px) {
    .feat-row { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="feat-admin">
    <h1>{{ Auth::user()->canManageStaff() ? 'Quản lý Xe Nổi Bật' : 'Xe Nổi Bật' }}</h1>
    <p class="subtitle">
        @if(Auth::user()->canManageStaff())
            Chọn xe, gán badge và upload ảnh 360° (8 frame) để hiển thị trên trang "Xe Nổi Bật".
        @else
            Danh sách xe đang được hiển thị nổi bật trên website.
        @endif
    </p>

    {{-- ── FILTER BAR ── --}}
    <div class="filter-bar">
        @foreach(\App\Models\Brand::orderBy('name')->get() as $b)
            <a href="{{ route('admin.cars.index', ['brand' => $b->id]) }}">{{ $b->name }}</a>
        @endforeach
        <span class="divider">|</span>
        <a href="{{ route('admin.featured-cars.index') }}" class="active-feat">⭐ Xe nổi bật</a>
    </div>

    @if(session('success'))
        <div class="alert-success">✓ {{ session('success') }}</div>
    @endif

    {{-- ── DANH SÁCH XE ĐANG NỔI BẬT ── --}}
    <div class="section-card">
        <div class="section-card-header">
            <h2>
                Đang hiển thị nổi bật
                <span class="badge-count">{{ $featured->count() }}</span>
            </h2>
        </div>

        @if($featured->isEmpty())
            <div class="empty-feat">Chưa có xe nổi bật nào.</div>
        @else
            <div class="feat-list">
                @foreach($featured as $car)
                    @php
                        $slug   = \Illuminate\Support\Str::slug($car->name);
                        $folder = public_path("images/quay360/{$slug}/");
                        $filled = 0;
                        for ($i = 1; $i <= 8; $i++) {
                            if (file_exists($folder . $i . '.png')) $filled++;
                        }
                        $thumb = null;
                        if (file_exists($folder . '1.png')) {
                            $thumb = rtrim(asset("images/quay360/{$slug}"), '/') . '/1.png';
                        } elseif (!empty($car->image)) {
                            $raw = $car->image;
                            $thumb = preg_match('#^https?://#i', $raw) ? $raw : asset(ltrim($raw, '/'));
                        }
                    @endphp
                    <div class="feat-row {{ Auth::user()->isStaff() ? 'staff-row' : '' }}">
                        @if($thumb)
                            <img class="feat-row-thumb" src="{{ $thumb }}" alt="{{ $car->name }}">
                        @else
                            <div class="feat-row-thumb-placeholder">🚗</div>
                        @endif

                        <div>
                            <div class="feat-row-name">{{ $car->name }}</div>
                            @if($car->badge_label)
                                <span class="feat-row-badge-val">{{ $car->badge_label }}</span>
                            @else
                                <span style="font-size:11px;color:#aaa;">Chưa có badge</span>
                            @endif
                        </div>

                        <div class="feat-row-status">
                            <div class="frame-status">
                                Ảnh 360°: <strong>{{ $filled }}/8</strong>
                            </div>
                            <div class="frame-dots">
                                @for($i = 1; $i <= 8; $i++)
                                    <div class="frame-dot {{ file_exists($folder . $i . '.png') ? 'filled' : '' }}"
                                         title="Frame {{ $i }}"></div>
                                @endfor
                            </div>
                        </div>

                        {{-- Chỉ admin/manager mới thấy nút thao tác --}}
                        @if(Auth::user()->canManageStaff())
                        <div class="feat-row-actions">
                            <a href="{{ route('admin.featured-cars.edit', $car) }}"
                               class="btn btn-primary btn-sm">
                                ✏️ Upload ảnh 360°
                            </a>

                            {{-- Form ẩn, submit bởi modal --}}
                            <form method="POST"
                                  action="{{ route('admin.featured-cars.unmark', $car) }}"
                                  id="unmark-form-{{ $car->id }}">
                                @csrf @method('PATCH')
                            </form>

                            <button type="button" class="btn btn-danger btn-sm"
                                    onclick="openUnmarkModal('{{ $car->id }}', '{{ addslashes($car->name) }}')">
                                ✕ Bỏ nổi bật
                            </button>
                        </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ── DANH SÁCH XE CÓ THỂ THÊM — chỉ admin/manager ── --}}
    @if(Auth::user()->canManageStaff())
    <div class="section-card">
        <div class="section-card-header">
            <h2>Xe có thể thêm vào nổi bật</h2>
        </div>
        <table class="avail-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên xe</th>
                    <th>Hãng</th>
                    <th>Giá (VNĐ)</th>
                    <th>Badge nổi bật</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($available as $i => $car)
                    <tr>
                        <td style="color:#9ca3af;">{{ $i + 1 }}</td>
                        <td style="font-weight:600;">{{ $car->name }}</td>
                        <td style="color:#6b7280;">{{ $car->brand->name ?? '—' }}</td>
                        <td>{{ number_format($car->price_per_day ?? $car->price) }}</td>
                        <td>
                            <form class="mark-form" method="POST"
                                  action="{{ route('admin.featured-cars.mark', $car) }}">
                                @csrf @method('PATCH')
                                <input type="text" name="badge_label"
                                       placeholder="Badge (vd: Flagship)"
                                       maxlength="60">
                                <button class="btn btn-success btn-sm" type="submit">
                                    ★ Thêm nổi bật
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('admin.featured-cars.edit', $car) }}"
                               class="btn btn-outline btn-sm">Quản lý ảnh 360°</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:32px;color:#9ca3af;">
                            Tất cả xe đã được đánh dấu nổi bật.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

</div>

{{-- ── Custom Confirm Modal ── --}}
<div class="modal-overlay" id="unmarkModal">
    <div class="modal-box">
        <div class="modal-icon-wrap">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width:80px;height:auto;object-fit:contain;display:block;">
        </div>
        <div class="modal-title">Bỏ xe khỏi nổi bật?</div>
        <div class="modal-desc">
            Xe <strong id="unmarkCarName"></strong> sẽ không còn hiển thị
            trong danh sách <em>Xe Nổi Bật</em> trên website nữa.
        </div>
        <div class="modal-actions">
            <button class="btn btn-outline" onclick="closeUnmarkModal()">
                Huỷ bỏ
            </button>
            <button class="btn btn-danger-solid" id="unmarkConfirmBtn">
                ✕ Xác nhận bỏ
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
let _unmarkFormId = null;

function openUnmarkModal(carId, carName) {
    _unmarkFormId = carId;
    document.getElementById('unmarkCarName').textContent = carName;
    document.getElementById('unmarkModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeUnmarkModal() {
    document.getElementById('unmarkModal').classList.remove('open');
    document.body.style.overflow = '';
    _unmarkFormId = null;
}

document.getElementById('unmarkConfirmBtn').addEventListener('click', function () {
    if (_unmarkFormId) {
        this.disabled = true;
        this.textContent = 'Đang xử lý...';
        document.getElementById('unmark-form-' + _unmarkFormId).submit();
    }
});

// Đóng khi click ra ngoài modal box
document.getElementById('unmarkModal').addEventListener('click', function (e) {
    if (e.target === this) closeUnmarkModal();
});

// Đóng khi nhấn Escape
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeUnmarkModal();
});
</script>
@endpush

@endsection