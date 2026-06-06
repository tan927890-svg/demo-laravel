{{-- resources/views/deposits/success.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Đặt cọc thành công - AUTO X')

@section('hide_home_hero', true)

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800;900&family=Barlow+Condensed:ital,wght@0,700;0,900;1,900&display=swap" rel="stylesheet">
<style>
.suc-page { background: #f4f4f2; min-height: 100vh; padding: 0 0 100px; font-family: 'Be Vietnam Pro', sans-serif; }

/* ── BANNER ── */
.suc-banner { background: #111; border-bottom: 2px solid #222; padding: 22px 0 18px; margin-bottom: 40px; position: relative; overflow: hidden; }
.suc-banner::before { content:''; position:absolute; inset:0; background:rgba(0,0,0,.5); }
.suc-banner-inner { position:relative; z-index:1; max-width:1120px; margin:0 auto; padding:0 40px; display:flex; align-items:center; gap:20px; }
.suc-banner-icon { font-size:36px; line-height:1; }
.suc-banner-label { font-size:10px; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:rgba(255,255,255,.5); margin-bottom:4px; }
.suc-banner-title { font-family:'Barlow Condensed',sans-serif; font-size:clamp(22px,3.5vw,36px); font-weight:900; color:#fff; text-transform:uppercase; letter-spacing:-1px; line-height:1; }

/* ── CONTAINER ── */
.suc-container { max-width: 760px; margin: 0 auto; padding: 0 40px; }

/* ── HERO ── */
.suc-hero { text-align: center; margin-bottom: 32px; }
.suc-hero-emoji { font-size: 56px; line-height: 1; margin-bottom: 14px; display: block; }
.suc-hero-title { font-family: 'Barlow Condensed', sans-serif; font-size: clamp(32px,5vw,52px); font-weight: 900; text-transform: uppercase; color: #111; letter-spacing: -1px; line-height: 1.1; margin-bottom: 10px; }
.suc-hero-title em { color: #16a34a; font-style: normal; }
.suc-hero-sub { font-size: 10px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: #777; display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 12px; }
.suc-hero-sub::before { content:''; width:16px; height:2px; background:#16a34a; }
.suc-hero-sub::after  { content:''; width:16px; height:2px; background:#16a34a; }
.suc-hero-desc { font-size: 15px; color: #666; line-height: 1.7; font-weight: 400; }
.suc-hero-desc strong { color: #111; font-weight: 700; }

/* ── CARD ── */
.suc-card { background: #fff; border-top: 3px solid #1a1a1a; border-radius: 0 0 4px 4px; padding: 26px 28px; margin-bottom: 14px; box-shadow: 0 1px 4px rgba(0,0,0,.05); }
.suc-card.green { border-top-color: #16a34a; }
.suc-card.blue  { border-top-color: #2563eb; }
.suc-card-title { font-family: 'Barlow Condensed', sans-serif; font-size: 16px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; color: #111; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 8px; }

/* ── DETAIL ROWS ── */
.suc-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f0f0f0; font-size: 14px; gap: 12px; }
.suc-row:last-child { border-bottom: none; padding-bottom: 0; }
.suc-row-label { color: #888; font-weight: 500; flex-shrink: 0; }
.suc-row-value { font-weight: 700; color: #111; text-align: right; }
.suc-row-value.code { font-family: 'Barlow Condensed', sans-serif; font-size: 18px; font-weight: 900; color: #c00; letter-spacing: 1px; }
.suc-row-value.amount { font-family: 'Barlow Condensed', sans-serif; font-size: 22px; font-weight: 900; color: #16a34a; }
.suc-row-value.badge { display: inline-flex; align-items: center; gap: 5px; background: #fef9c3; color: #854d0e; font-size: 11px; font-weight: 800; padding: 3px 10px; border-radius: 20px; border: 1px solid #fde047; text-transform: uppercase; letter-spacing: 1px; }

/* ── BANK INFO ── */
.suc-bank-row { display: flex; gap: 10px; padding: 9px 0; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
.suc-bank-row:last-child { border-bottom: none; }
.suc-bank-row .lbl { color: #93c5fd; font-weight: 600; min-width: 140px; flex-shrink: 0; }
.suc-bank-row .val { color: #fff; font-weight: 700; }
.suc-bank-row .val code { background: rgba(255,255,255,.15); padding: 2px 10px; border-radius: 4px; font-family: 'Barlow Condensed', sans-serif; font-size: 16px; font-weight: 900; letter-spacing: 1px; color: #fde047; }

/* ── ACTIONS ── */
.suc-actions { display: flex; gap: 12px; margin-top: 28px; }
.suc-btn { flex: 1; padding: 14px 20px; border-radius: 6px; font-family: 'Be Vietnam Pro', sans-serif; font-size: 12px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; text-decoration: none; text-align: center; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all .2s; border: none; cursor: pointer; }
.suc-btn-outline { background: transparent; color: #555; border: 2px solid #ddd; }
.suc-btn-outline:hover { border-color: #999; color: #111; }
.suc-btn-primary { background: #1a1a1a; color: #fff; }
.suc-btn-primary:hover { background: #c00; transform: translateY(-1px); }

/* ── PLEDGE ── */
.suc-pledge { background: rgba(22,163,74,.06); border: 1px solid rgba(22,163,74,.2); border-radius: 6px; padding: 16px 20px; margin-top: 14px; }
.suc-pledge-title { font-size: 9px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; color: #16a34a; margin-bottom: 10px; }
.suc-pledge ul { margin: 0; padding-left: 16px; }
.suc-pledge ul li { font-size: 13px; color: #444; line-height: 2; font-weight: 500; }

@media (max-width: 680px) {
    .suc-container { padding: 0 16px; }
    .suc-banner-inner { padding: 0 16px; }
    .suc-card { padding: 20px 18px; }
    .suc-actions { flex-direction: column; }
    .suc-row-value.code { font-size: 15px; }
}
</style>
@endpush

@section('content')
<div class="suc-page">

    {{-- ── BANNER ── --}}
    <div class="suc-banner">
        <div class="suc-banner-inner">
            <div class="suc-banner-icon">✅</div>
            <div>
                <div class="suc-banner-label">AUTO X Showroom</div>
                <div class="suc-banner-title">Đặt cọc thành công</div>
            </div>
        </div>
    </div>

    <div class="suc-container">

        {{-- HERO --}}
        <div class="suc-hero">
            <span class="suc-hero-emoji">🎉</span>
            <div class="suc-hero-title">Cảm ơn bạn đã <em>tin tưởng</em></div>
            <div class="suc-hero-sub">AUTO X Showroom · Đăng ký giữ chỗ</div>
            <p class="suc-hero-desc">
                Yêu cầu đặt cọc của bạn đã được ghi nhận.<br>
                Tư vấn viên sẽ liên hệ xác nhận trong vòng <strong>24 giờ</strong>.
            </p>
        </div>

        {{-- CHI TIẾT ĐẶT CỌC --}}
        <div class="suc-card">
            <div class="suc-card-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Chi tiết đặt cọc
            </div>

            <div class="suc-row">
                <span class="suc-row-label">Mã giao dịch</span>
                <span class="suc-row-value code">{{ $deposit->transaction_code }}</span>
            </div>
            <div class="suc-row">
                <span class="suc-row-label">Xe đặt cọc</span>
                <span class="suc-row-value">{{ $deposit->car->name }}</span>
            </div>
            <div class="suc-row">
                <span class="suc-row-label">Họ và tên</span>
                <span class="suc-row-value">{{ $deposit->customer_name }}</span>
            </div>
            <div class="suc-row">
                <span class="suc-row-label">Số điện thoại</span>
                <span class="suc-row-value">{{ $deposit->customer_phone }}</span>
            </div>
            <div class="suc-row">
                <span class="suc-row-label">Email</span>
                <span class="suc-row-value">{{ $deposit->customer_email }}</span>
            </div>
            <div class="suc-row">
                <span class="suc-row-label">Số tiền cọc</span>
                <span class="suc-row-value amount">{{ number_format($deposit->deposit_amount, 0, ',', '.') }}đ</span>
            </div>
            <div class="suc-row">
                <span class="suc-row-label">Phương thức TT</span>
                <span class="suc-row-value">{{ $deposit->payment_method_label }}</span>
            </div>
            <div class="suc-row">
                <span class="suc-row-label">Trạng thái</span>
                <span class="suc-row-value badge">⏳ {{ $deposit->status_label }}</span>
            </div>
        </div>

        {{-- THÔNG TIN CHUYỂN KHOẢN --}}
        @if($deposit->payment_method === 'bank_transfer')
        <div class="suc-card blue" style="background:#1e3a8a;">
            <div class="suc-card-title" style="color:#fff;border-bottom-color:rgba(255,255,255,.1);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#93c5fd" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                <span style="color:#93c5fd;">Thông tin chuyển khoản</span>
            </div>
            <div class="suc-bank-row">
                <span class="lbl">Ngân hàng</span>
                <span class="val">{{ config('payment.bank_name', env('PAYMENT_BANK_NAME', 'MB Bank')) }}</span>
            </div>
            <div class="suc-bank-row">
                <span class="lbl">Số tài khoản</span>
                <span class="val">{{ config('payment.bank_account', env('PAYMENT_BANK_ACCOUNT', '0328078853')) }}</span>
            </div>
            <div class="suc-bank-row">
                <span class="lbl">Chủ tài khoản</span>
                <span class="val">{{ config('payment.bank_owner', env('PAYMENT_BANK_OWNER', 'VO MINH TAN')) }}</span>
            </div>
            <div class="suc-bank-row">
                <span class="lbl">Nội dung CK</span>
                <span class="val"><code>{{ $deposit->transaction_code }}</code></span>
            </div>
        </div>
        @endif

        {{-- CAM KẾT --}}
        <div class="suc-pledge">
            <div class="suc-pledge-title">✦ Cam kết của chúng tôi</div>
            <ul>
                <li>Giữ xe trong vòng <strong>30 ngày</strong> kể từ khi nhận cọc</li>
                <li>Hoàn trả 100% tiền cọc nếu xe không còn hàng</li>
                <li>Tư vấn viên liên hệ xác nhận trong <strong>24 giờ</strong></li>
            </ul>
        </div>

        {{-- ACTIONS --}}
        <div class="suc-actions">
            <a href="{{ route('cars.show', $deposit->car->slug) }}" class="suc-btn suc-btn-outline">
                ← Xem lại xe
            </a>
            <a href="{{ url('/') }}" class="suc-btn suc-btn-primary">
                Về trang chủ →
            </a>
        </div>

    </div>
</div>
@endsection