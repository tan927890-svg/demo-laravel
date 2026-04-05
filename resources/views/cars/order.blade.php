@extends('layouts.frontend')

@section('title', 'Đặt xe — ' . $car->name . ' - Concept Car Dealer')

@push('styles')
<style>
.order-section {
  min-height: 80vh; padding: 80px 0;
  background: var(--bg);
}
.container { max-width: 900px; margin: 0 auto; padding: 0 48px; }
.order-header { text-align: center; margin-bottom: 48px; }
.order-eyebrow {
  font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
  letter-spacing: 4px; text-transform: uppercase; color: var(--red);
  margin-bottom: 12px; display: flex; align-items: center; justify-content: center; gap: 12px;
}
.order-eyebrow::before, .order-eyebrow::after { content: ''; width: 24px; height: 1px; background: var(--red); }
.order-title {
  font-family: 'Barlow Condensed', sans-serif; font-size: clamp(36px,5vw,60px);
  font-weight: 900; color: var(--white); text-transform: uppercase; letter-spacing: -1px;
}
.order-title em { color: var(--red); font-style: normal; }

/* CAR SUMMARY */
.car-summary {
  background: var(--card); border: 1px solid var(--border);
  padding: 24px; margin-bottom: 32px;
  display: flex; gap: 20px; align-items: center;
}
.car-summary-img { width: 120px; height: 80px; object-fit: cover; flex-shrink: 0; }
.car-summary-img-placeholder { width: 120px; height: 80px; background: var(--bg3); flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
.car-summary-info { flex: 1; }
.car-summary-brand { font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--red); margin-bottom: 4px; }
.car-summary-name { font-family: 'Barlow Condensed', sans-serif; font-size: 22px; font-weight: 800; color: var(--white); text-transform: uppercase; }
.car-summary-price { font-family: 'Barlow Condensed', sans-serif; font-size: 24px; font-weight: 900; color: var(--red); margin-top: 6px; }
.car-summary-price small { font-size: 12px; color: var(--muted); font-family: 'Barlow', sans-serif; }

/* FORM */
.order-form { background: var(--card); border: 1px solid var(--border); padding: 40px; }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.form-group { margin-bottom: 20px; }
.form-group.full { grid-column: 1 / -1; }
.form-group label {
  display: block; font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700;
  letter-spacing: 2.5px; text-transform: uppercase; color: var(--muted); margin-bottom: 8px;
}
.form-group label span { color: var(--red); }
.form-group input, .form-group textarea, .form-group select {
  width: 100%; background: var(--bg); border: 1px solid var(--border);
  color: var(--text); padding: 12px 16px; font-family: 'Barlow', sans-serif;
  font-size: 14px; outline: none; transition: border-color .2s; box-sizing: border-box;
  appearance: none;
}
.form-group input:focus, .form-group textarea:focus, .form-group select:focus { border-color: var(--red); }
.form-group input::placeholder, .form-group textarea::placeholder { color: var(--subtle); }
.form-group textarea { resize: vertical; min-height: 100px; }

.alert-error { background: rgba(212,43,43,.1); border: 1px solid rgba(212,43,43,.3); padding: 16px 20px; margin-bottom: 24px; }
.alert-error li { font-size: 13px; color: #f87171; margin-bottom: 4px; list-style: disc; margin-left: 16px; }

.note-box { background: rgba(212,43,43,.06); border: 1px solid rgba(212,43,43,.2); padding: 16px 20px; margin-bottom: 24px; font-size: 13px; color: var(--muted); }
.note-box strong { color: var(--white); }

.btn-submit {
  width: 100%; background: var(--red); color: #fff; border: none;
  font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700;
  letter-spacing: 3px; text-transform: uppercase; padding: 18px;
  cursor: pointer; transition: background .2s; margin-top: 8px;
}
.btn-submit:hover { background: var(--red-dark); }

.page-breadcrumb { background: var(--bg2); border-bottom: 1px solid var(--border); padding: 14px 48px; display: flex; align-items: center; gap: 10px; font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: var(--subtle); }
.page-breadcrumb a { color: var(--subtle); text-decoration: none; transition: color .2s; }
.page-breadcrumb a:hover { color: var(--red); }
.page-breadcrumb span { color: var(--red); }

@media(max-width: 768px) {
  .container { padding: 0 20px; }
  .form-grid { grid-template-columns: 1fr; }
  .car-summary { flex-direction: column; }
  .order-form { padding: 24px; }
}
</style>
@endpush

@section('content')

<div class="page-breadcrumb">
  <a href="{{ url('/') }}">Home</a> ›
  <a href="{{ route('cars.index') }}">Xe</a> ›
  <a href="{{ route('cars.show', $car) }}">{{ $car->name }}</a> ›
  <span>Đặt xe</span>
</div>

<section class="order-section">
  <div class="container">

    <div class="order-header">
      <div class="order-eyebrow">Đặt xe</div>
      <div class="order-title">Xác Nhận <em>Thuê Xe</em></div>
    </div>

    {{-- Car summary --}}
    <div class="car-summary">
      @if($car->image_url)
        <img class="car-summary-img" src="{{ asset($car->image_url) }}" alt="{{ $car->name }}">
      @elseif($car->image)
        <img class="car-summary-img" src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}">
      @else
        <div class="car-summary-img-placeholder">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.2)" stroke-width="1"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
        </div>
      @endif
      <div class="car-summary-info">
        <div class="car-summary-brand">{{ $car->brand?->name ?? $car->brand }}</div>
        <div class="car-summary-name">{{ $car->name }}</div>
        <div class="car-summary-price">
          {{ number_format($car->price_per_day ?? $car->price) }}
          <small>VNĐ / ngày</small>
        </div>
      </div>
    </div>

    {{-- Form --}}
    <div class="order-form">
      @if($errors->any())
        <div class="alert-error">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('orders.store', $car) }}">
        @csrf
        <div class="form-grid">
          <div class="form-group">
            <label>Họ và tên <span>*</span></label>
            <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()?->name) }}" placeholder="Nguyễn Văn A" required>
          </div>
          <div class="form-group">
            <label>Số điện thoại <span>*</span></label>
            <input type="tel" name="customer_phone" value="{{ old('customer_phone') }}" placeholder="0901 234 567" required>
          </div>
          <div class="form-group full">
            <label>Email <span>*</span></label>
            <input type="email" name="customer_email" value="{{ old('customer_email', auth()->user()?->email) }}" placeholder="email@example.com" required>
          </div>
          <div class="form-group">
            <label>Ngày nhận xe <span>*</span></label>
            <input type="date" name="start_date" value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" required>
          </div>
          <div class="form-group">
            <label>Ngày trả xe <span>*</span></label>
            <input type="date" name="end_date" value="{{ old('end_date') }}" min="{{ date('Y-m-d') }}" required>
          </div>
          <div class="form-group full">
            <label>Địa chỉ</label>
            <input type="text" name="customer_address" value="{{ old('customer_address') }}" placeholder="Số nhà, đường, quận, tỉnh/thành">
          </div>
          <div class="form-group full">
            <label>Ghi chú</label>
            <textarea name="note" placeholder="Yêu cầu thêm, câu hỏi...">{{ old('note') }}</textarea>
          </div>
        </div>

        <div class="note-box">
          💡 Sau khi đặt xe, nhân viên sẽ liên hệ trong <strong>24 giờ</strong> để xác nhận lịch.
        </div>

        <button type="submit" class="btn-submit">Xác nhận đặt xe →</button>
      </form>
    </div>

  </div>
</section>

@endsection