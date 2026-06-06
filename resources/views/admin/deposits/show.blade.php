{{-- resources/views/admin/deposits/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Chi tiết đặt cọc #' . $deposit->id)

@section('content')
<div style="max-width:1000px;margin:0 auto;padding:24px 20px;font-family:'Be Vietnam Pro',sans-serif;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
        <div>
            <a href="{{ route('admin.contacts.index', ['loai' => 'dat-coc']) }}"
               style="font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#888;text-decoration:none;display:inline-flex;align-items:center;gap:6px;margin-bottom:8px;">
                ← Danh sách đặt cọc
            </a>
            <h1 style="font-size:26px;font-weight:900;color:#111;margin:0;letter-spacing:-0.5px;">
                Đặt cọc <span style="color:#c00;">#{{ $deposit->id }}</span>
            </h1>
            <div style="font-size:11px;color:#aaa;margin-top:4px;font-weight:600;letter-spacing:1px;text-transform:uppercase;">
                Tạo lúc {{ $deposit->created_at->format('H:i · d/m/Y') }}
            </div>
        </div>

        {{-- Status badge --}}
        <div>
            @php
                $statusMap = [
                    'pending'   => ['label' => 'Chờ xác nhận', 'bg' => '#fef9c3', 'color' => '#b45309', 'border' => '#fde68a'],
                    'confirmed' => ['label' => 'Đã xác nhận',  'bg' => '#dcfce7', 'color' => '#15803d', 'border' => '#86efac'],
                    'cancelled' => ['label' => 'Đã huỷ',       'bg' => '#fee2e2', 'color' => '#b91c1c', 'border' => '#fca5a5'],
                    'completed' => ['label' => 'Hoàn tất',     'bg' => '#eff6ff', 'color' => '#1d4ed8', 'border' => '#bfdbfe'],
                    'refunded'  => ['label' => 'Đã hoàn cọc', 'bg' => '#f3f4f6', 'color' => '#374151', 'border' => '#d1d5db'],
                ];
                $st = $statusMap[$deposit->status] ?? ['label' => $deposit->status, 'bg' => '#f3f4f6', 'color' => '#374151', 'border' => '#d1d5db'];
            @endphp
            <span style="display:inline-block;padding:7px 18px;border-radius:20px;font-size:12px;font-weight:800;letter-spacing:1px;text-transform:uppercase;background:{{ $st['bg'] }};color:{{ $st['color'] }};border:1.5px solid {{ $st['border'] }};">
                {{ $st['label'] }}
            </span>
        </div>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div style="background:#dcfce7;border-left:3px solid #16a34a;border-radius:0 6px 6px 0;padding:12px 16px;margin-bottom:16px;font-size:13px;color:#15803d;font-weight:600;">
            ✓ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background:#fee2e2;border-left:3px solid #ef4444;border-radius:0 6px 6px 0;padding:12px 16px;margin-bottom:16px;font-size:13px;color:#991b1b;font-weight:600;">
            ⚠ {{ session('error') }}
        </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 320px;gap:18px;align-items:start;">

        {{-- ===== CỘT TRÁI ===== --}}
        <div>

            {{-- THÔNG TIN KHÁCH HÀNG --}}
            <div style="background:#fff;border-top:3px solid #1a1a1a;border-radius:0 0 6px 6px;padding:24px 26px;margin-bottom:14px;box-shadow:0 1px 4px rgba(0,0,0,.06);">
                <div style="font-size:11px;font-weight:800;letter-spacing:3px;text-transform:uppercase;color:#888;margin-bottom:18px;padding-bottom:12px;border-bottom:1px solid #f0f0f0;">
                    👤 Thông tin khách hàng
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                    @php
                        $fields = [
                            ['Họ và tên',      $deposit->customer_name,    true],
                            ['Email',           $deposit->customer_email,   false],
                            ['Số điện thoại',  $deposit->customer_phone,   false],
                            ['CCCD / CMND',    $deposit->customer_id_card, false],
                            ['Địa chỉ',        $deposit->customer_address, false],
                        ];
                    @endphp
                    @foreach($fields as [$label, $value, $full])
                        <div style="{{ $full ? 'grid-column:1/-1;' : '' }}">
                            <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#aaa;margin-bottom:5px;">{{ $label }}</div>
                            <div style="font-size:15px;font-weight:600;color:{{ $value ? '#111' : '#ccc' }};">
                                {{ $value ?: '—' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- THÔNG TIN ĐẶT CỌC --}}
            <div style="background:#fff;border-top:3px solid #c00;border-radius:0 0 6px 6px;padding:24px 26px;margin-bottom:14px;box-shadow:0 1px 4px rgba(0,0,0,.06);">
                <div style="font-size:11px;font-weight:800;letter-spacing:3px;text-transform:uppercase;color:#888;margin-bottom:18px;padding-bottom:12px;border-bottom:1px solid #f0f0f0;">
                    💰 Thông tin đặt cọc
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">

                    {{-- Số tiền --}}
                    <div style="grid-column:1/-1;">
                        <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#aaa;margin-bottom:5px;">Số tiền đặt cọc</div>
                        <div style="font-size:32px;font-weight:900;color:#c00;letter-spacing:-0.5px;">
                            {{ number_format($deposit->deposit_amount) }}<span style="font-size:14px;color:#aaa;font-weight:500;margin-left:4px;">đ</span>
                        </div>
                    </div>

                    {{-- Phương thức --}}
                    <div>
                        <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#aaa;margin-bottom:5px;">Phương thức</div>
                        @php
                            $methodMap = [
                                'bank_transfer' => '🏦 Chuyển khoản',
                                'momo'          => '💜 MoMo',
                                'vnpay'         => '💳 VNPay',
                                'cash'          => '💵 Tiền mặt',
                            ];
                        @endphp
                        <div style="font-size:15px;font-weight:700;color:#111;">
                            {{ $methodMap[$deposit->payment_method] ?? $deposit->payment_method }}
                        </div>
                    </div>

                    {{-- Mã GD --}}
                    <div>
                        <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#aaa;margin-bottom:5px;">Mã giao dịch</div>
                        <code style="font-size:13px;color:#1d4ed8;background:#eff6ff;padding:3px 10px;border-radius:5px;font-weight:700;">
                            {{ $deposit->transaction_code }}
                        </code>
                    </div>

                    {{-- Giá xe & còn lại --}}
                    @php $carPrice = $deposit->car?->price_per_day ?? $deposit->car?->price ?? 0; @endphp
                    @if($carPrice > 0)
                    <div>
                        <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#aaa;margin-bottom:5px;">Giá xe</div>
                        <div style="font-size:15px;font-weight:600;color:#111;">{{ number_format($carPrice) }}đ</div>
                    </div>
                    <div>
                        <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#aaa;margin-bottom:5px;">Còn lại khi nhận xe</div>
                        <div style="font-size:15px;font-weight:600;color:#111;">{{ number_format(max(0, $carPrice - $deposit->deposit_amount)) }}đ</div>
                    </div>
                    @endif

                    {{-- Màu xe --}}
                    @if($deposit->relationLoaded('color') && $deposit->color)
                    <div>
                        <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#aaa;margin-bottom:5px;">Màu xe</div>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span style="width:16px;height:16px;border-radius:50%;background:{{ $deposit->color->hex_code ?? '#ccc' }};border:1.5px solid rgba(0,0,0,.1);flex-shrink:0;display:inline-block;"></span>
                            <span style="font-size:15px;font-weight:600;color:#111;">{{ $deposit->color->name }}</span>
                        </div>
                    </div>
                    @endif

                </div>

                {{-- Ghi chú --}}
                @if($deposit->note)
                <div style="margin-top:18px;padding-top:16px;border-top:1px solid #f0f0f0;">
                    <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#aaa;margin-bottom:8px;">Ghi chú</div>
                    <div style="font-size:14px;color:#555;line-height:1.7;background:#f9f9f7;padding:12px 14px;border-radius:6px;border-left:3px solid #ddd;">
                        {{ $deposit->note }}
                    </div>
                </div>
                @endif
            </div>

            {{-- CẬP NHẬT TRẠNG THÁI --}}
            <div style="background:#fff;border-top:3px solid #1a1a1a;border-radius:0 0 6px 6px;padding:24px 26px;box-shadow:0 1px 4px rgba(0,0,0,.06);">
                <div style="font-size:11px;font-weight:800;letter-spacing:3px;text-transform:uppercase;color:#888;margin-bottom:18px;padding-bottom:12px;border-bottom:1px solid #f0f0f0;">
                    ⚙️ Cập nhật trạng thái
                </div>
                <form action="{{ route('admin.deposits.update', $deposit->id) }}" method="POST"
                      style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;">
                    @csrf
                    @method('PATCH')
                    <div style="flex:1;min-width:180px;">
                        <label style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#aaa;margin-bottom:6px;display:block;">
                            Trạng thái mới
                        </label>
                        <select name="status"
                                style="width:100%;padding:9px 13px;border:1.5px solid #e2e2e2;border-radius:6px;font-family:'Be Vietnam Pro',sans-serif;font-size:14px;font-weight:600;color:#111;background:#fafafa;outline:none;">
                            <option value="pending"   {{ $deposit->status === 'pending'   ? 'selected' : '' }}>⏳ Chờ xác nhận</option>
                            <option value="confirmed" {{ $deposit->status === 'confirmed' ? 'selected' : '' }}>✅ Đã xác nhận</option>
                            <option value="completed" {{ $deposit->status === 'completed' ? 'selected' : '' }}>🏁 Hoàn tất</option>
                            <option value="cancelled" {{ $deposit->status === 'cancelled' ? 'selected' : '' }}>❌ Đã huỷ</option>
                            <option value="refunded"  {{ $deposit->status === 'refunded'  ? 'selected' : '' }}>💸 Đã hoàn cọc</option>
                        </select>
                    </div>
                    <button type="submit"
                            style="padding:10px 22px;background:#1a1a1a;color:#fff;border:none;border-radius:6px;font-family:'Be Vietnam Pro',sans-serif;font-size:12px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;cursor:pointer;">
                        Lưu
                    </button>
                </form>

                {{-- Xoá — chỉ Admin --}}
                @if(Auth::user()->isAdmin())
                    <div style="margin-top:16px;padding-top:16px;border-top:1px solid #f0f0f0;">
                        @if(in_array($deposit->status, ['cancelled', 'refunded']))
                            <form id="delete-form" action="{{ route('admin.deposits.destroy', $deposit->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="document.getElementById('modal-delete').style.display='flex'"
                                        style="padding:9px 20px;background:#fff;color:#ef4444;border:1.5px solid #fca5a5;border-radius:6px;font-family:'Be Vietnam Pro',sans-serif;font-size:12px;font-weight:700;cursor:pointer;">
                                    🗑 Xoá đặt cọc
                                </button>
                            </form>
                        @else
                            <p style="font-size:12px;color:#bbb;margin:0;line-height:1.6;">
                                ⚠️ Chỉ được xoá khi trạng thái là
                                <strong style="color:#999;">Đã huỷ</strong> hoặc
                                <strong style="color:#999;">Đã hoàn cọc</strong>.
                                Vui lòng đổi trạng thái trước.
                            </p>
                        @endif
                    </div>
                @endif

            </div>

        </div>

        {{-- ===== CỘT PHẢI: Xe ===== --}}
        <div style="position:sticky;top:80px;">
            @if($deposit->car)
            @php
                $car    = $deposit->car;
                $carImg = null;

                $defColor = $car->colors->firstWhere('is_default', true) ?? $car->colors->first();
                if ($defColor?->image) {
                    $segs   = explode('/', ltrim($defColor->image, '/'));
                    $carImg = asset(implode('/', array_map(fn($s) => rawurlencode(rawurldecode($s)), $segs)));
                }

                if (!$carImg) {
                    $gal = $car->galleries
                        ->where('type', 'image')
                        ->filter(fn($g) => str_contains($g->file_path ?? '', '-TN'))
                        ->sortBy('sort_order')->first()
                        ?? $car->galleries->where('type', 'image')->sortBy('sort_order')->first();

                    if ($gal?->file_path) {
                        $segs   = explode('/', ltrim($gal->file_path, '/'));
                        $carImg = asset(implode('/', array_map(fn($s) => rawurlencode(rawurldecode($s)), $segs)));
                    }
                }
            @endphp

            <div style="background:#0d0d0f;border-radius:8px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.15);">
                <div style="position:relative;height:180px;overflow:hidden;background:#111;">
                    @if($carImg)
                        <img src="{{ $carImg }}" alt="{{ $car->name }}"
                             style="width:100%;height:100%;object-fit:cover;display:block;">
                    @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                            <span style="font-size:11px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,.08);">{{ $car->name }}</span>
                        </div>
                    @endif
                    <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.7) 0%,transparent 60%);"></div>
                    @if($car->brand?->name)
                        <div style="position:absolute;top:10px;left:10px;font-size:9px;font-weight:800;letter-spacing:3px;text-transform:uppercase;color:#f0c040;background:rgba(0,0,0,.75);border:1px solid rgba(240,192,64,.4);padding:4px 10px;border-radius:3px;">
                            {{ $car->brand->name }}
                        </div>
                    @endif
                </div>

                <div style="padding:18px 20px;">
                    <div style="font-size:24px;font-weight:900;text-transform:uppercase;color:#fff;letter-spacing:-0.5px;line-height:1;margin-bottom:4px;">
                        {{ $car->name }}
                    </div>
                    @php $cp = $car->price_per_day ?? $car->price ?? 0; @endphp
                    @if($cp > 0)
                        <div style="font-size:22px;font-weight:900;color:#f0c040;line-height:1;margin-bottom:14px;">
                            {{ number_format($cp) }}<span style="font-size:11px;color:rgba(255,255,255,.4);margin-left:3px;font-weight:500;">VNĐ</span>
                        </div>
                    @else
                        <div style="font-size:14px;color:rgba(255,255,255,.3);margin-bottom:14px;">Liên hệ báo giá</div>
                    @endif

                    <a href="{{ route('admin.cars.show', $car->slug ?? $car->id) }}"
                       style="display:block;text-align:center;padding:9px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);border-radius:6px;color:rgba(255,255,255,.7);font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;text-decoration:none;">
                        Xem trang xe →
                    </a>
                </div>
            </div>
            @endif

            {{-- Meta --}}
            <div style="background:#fff;border-radius:6px;padding:18px 20px;margin-top:14px;box-shadow:0 1px 4px rgba(0,0,0,.06);">
                <div style="font-size:10px;font-weight:800;letter-spacing:3px;text-transform:uppercase;color:#aaa;margin-bottom:14px;">
                    Thông tin hệ thống
                </div>
                @foreach([
                    ['ID',        '#' . $deposit->id],
                    ['Tạo lúc',   $deposit->created_at->format('H:i d/m/Y')],
                    ['Cập nhật',  $deposit->updated_at->format('H:i d/m/Y')],
                ] as [$lbl, $val])
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f5f5f5;font-size:13px;">
                    <span style="color:#aaa;font-weight:500;">{{ $lbl }}</span>
                    <span style="color:#111;font-weight:700;">{{ $val }}</span>
                </div>
                @endforeach

                @if($deposit->confirmed_at)
                <div style="display:flex;justify-content:space-between;padding:8px 0;font-size:13px;">
                    <span style="color:#aaa;font-weight:500;">Xác nhận lúc</span>
                    <span style="color:#16a34a;font-weight:700;">{{ $deposit->confirmed_at->format('H:i d/m/Y') }}</span>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>

{{-- ===== MODAL XOÁ ===== --}}
@if(Auth::user()->isAdmin())
<div id="modal-delete"
     style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.5);align-items:center;justify-content:center;"
     onclick="if(event.target===this) this.style.display='none'">
    <div style="background:#fff;border-radius:16px;padding:32px;width:100%;max-width:420px;margin:16px;box-shadow:0 24px 64px rgba(0,0,0,.25);">

        {{-- Icon --}}
        <div style="width:52px;height:52px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
            <svg width="24" height="24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                <path d="M10 11v6M14 11v6"/>
                <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
            </svg>
        </div>

        {{-- Title --}}
        <div style="font-size:18px;font-weight:900;color:#111;margin-bottom:8px;">
            Xoá đặt cọc #{{ $deposit->id }}?
        </div>

        {{-- Body --}}
        <div style="font-size:14px;color:#777;line-height:1.7;margin-bottom:28px;">
            Hành động này <strong style="color:#ef4444;">không thể hoàn tác</strong>.
            Vui lòng đảm bảo đã hoàn tiền cho khách hàng trước khi tiến hành xoá.
        </div>

        {{-- Actions --}}
        <div style="display:flex;gap:10px;">
            <button onclick="document.getElementById('modal-delete').style.display='none'"
                    style="flex:1;padding:11px;background:#f5f5f5;border:1.5px solid #e5e5e5;border-radius:8px;font-family:'Be Vietnam Pro',sans-serif;font-size:13px;font-weight:700;cursor:pointer;color:#555;transition:background .15s;"
                    onmouseover="this.style.background='#ebebeb'" onmouseout="this.style.background='#f5f5f5'">
                Huỷ bỏ
            </button>
            <button onclick="document.getElementById('delete-form').submit()"
                    style="flex:1;padding:11px;background:#ef4444;border:1.5px solid #ef4444;border-radius:8px;font-family:'Be Vietnam Pro',sans-serif;font-size:13px;font-weight:700;cursor:pointer;color:#fff;transition:background .15s;"
                    onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">
                Xoá vĩnh viễn
            </button>
        </div>
    </div>
</div>
@endif

@endsection