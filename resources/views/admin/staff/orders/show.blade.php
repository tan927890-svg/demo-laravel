@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng')
@section('page-title', 'Chi tiết đơn hàng')

@section('content')
<style>
  .order-wrapper {
    display: flex;
    justify-content: center;
    padding: 32px 16px;
  }

  .order-paper {
    width: 100%;
    max-width: 680px;
    background: #fff;
    border: 1px solid #e2e2e2;
    border-radius: 4px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    overflow: hidden;
    font-family: 'Segoe UI', sans-serif;
    font-size: 14px;
    color: #1a1a1a;
  }

  /* ── Header ── */
  .order-header {
    background: #1a1a1a;
    color: #fff;
    padding: 20px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .order-header h2 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    letter-spacing: 0.4px;
  }
  .order-header .order-id {
    font-size: 13px;
    opacity: 0.6;
  }

  /* ── Alerts ── */
  .order-alert {
    padding: 12px 28px;
    font-size: 13px;
    border-bottom: 1px solid #e2e2e2;
  }
  .order-alert.success { background: #f0fdf4; color: #166534; }
  .order-alert.error   { background: #fff1f2; color: #9f1239; }

  /* ── Section title ── */
  .section-title {
    padding: 14px 28px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #888;
    background: #fafafa;
    border-top: 1px solid #e2e2e2;
    border-bottom: 1px solid #e2e2e2;
  }
  .section-title:first-child {
    border-top: none;
  }

  /* ── Field rows ── */
  .field-row {
    display: flex;
    align-items: flex-start;
    padding: 11px 28px;
    border-bottom: 1px solid #f0f0f0;
  }
  .field-row:last-child {
    border-bottom: none;
  }
  .field-label {
    flex: 0 0 160px;
    color: #888;
    font-size: 13px;
    padding-top: 1px;
  }
  .field-value {
    flex: 1;
    font-size: 13px;
    font-weight: 500;
    color: #1a1a1a;
    word-break: break-word;
  }

  /* ── Badge ── */
  .badge {
    display: inline-block;
    padding: 2px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
  }

  /* ── Update form ── */
  .form-section {
    padding: 20px 28px;
  }
  .form-group {
    margin-bottom: 16px;
  }
  .form-group label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #888;
    margin-bottom: 6px;
  }
  .form-group select,
  .form-group textarea {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 13px;
    font-family: inherit;
    color: #1a1a1a;
    background: #fff;
    box-sizing: border-box;
    resize: vertical;
    transition: border-color 0.15s;
  }
  .form-group select:focus,
  .form-group textarea:focus {
    outline: none;
    border-color: #1a1a1a;
  }
  .form-group select { max-width: 260px; }
  .form-group textarea { min-height: 90px; }

  .btn-save {
    background: #1a1a1a;
    color: #fff;
    border: none;
    padding: 10px 24px;
    border-radius: 4px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.15s;
  }
  .btn-save:hover { background: #333; }

  /* ── Footer ── */
  .order-footer {
    padding: 18px 28px;
    background: #fafafa;
    border-top: 1px solid #e2e2e2;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
  }
  .btn-link {
    display: inline-block;
    padding: 8px 16px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 13px;
    color: #444;
    text-decoration: none;
    background: #fff;
    transition: border-color 0.15s, color 0.15s;
  }
  .btn-link:hover { border-color: #1a1a1a; color: #1a1a1a; }
</style>

<div class="order-wrapper">
  <div class="order-paper">

    {{-- Header --}}
    <div class="order-header">
      <h2>Chi tiết đơn hàng</h2>
      <span class="order-id">#{{ $order->id }}</span>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
      <div class="order-alert success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="order-alert error">{{ session('error') }}</div>
    @endif

    {{-- Thông tin khách hàng --}}
    <div class="section-title">Thông tin khách hàng</div>

    <div class="field-row">
      <div class="field-label">Họ tên</div>
      <div class="field-value">{{ $order->customer_name }}</div>
    </div>
    <div class="field-row">
      <div class="field-label">Số điện thoại</div>
      <div class="field-value">{{ $order->customer_phone }}</div>
    </div>
    <div class="field-row">
      <div class="field-label">Email</div>
      <div class="field-value">{{ $order->customer_email }}</div>
    </div>
    <div class="field-row">
      <div class="field-label">Địa chỉ</div>
      <div class="field-value">{{ $order->customer_address ?? '—' }}</div>
    </div>

    {{-- Thông tin đơn hàng --}}
    <div class="section-title">Thông tin đơn hàng</div>

    <div class="field-row">
      <div class="field-label">Xe quan tâm</div>
      <div class="field-value">{{ $order->car?->name ?? '—' }}</div>
    </div>
    <div class="field-row">
      <div class="field-label">Trạng thái tư vấn</div>
      <div class="field-value">
        <span class="badge {{ $order->consultation_badge }}">
          {{ $order->consultation_label }}
        </span>
      </div>
    </div>
    <div class="field-row">
      <div class="field-label">Ngày tạo</div>
      <div class="field-value">{{ $order->created_at->format('d/m/Y H:i') }}</div>
    </div>
    @if($order->consulted_at)
    <div class="field-row">
      <div class="field-label">Ngày tư vấn</div>
      <div class="field-value">{{ \Carbon\Carbon::parse($order->consulted_at)->format('d/m/Y H:i') }}</div>
    </div>
    @endif
    <div class="field-row">
      <div class="field-label">Ghi chú</div>
      <div class="field-value">{{ $order->note ?? '—' }}</div>
    </div>

    {{-- Cập nhật tư vấn --}}
    @if($order->consultation_status !== 'da_chot_don')
    <div class="section-title">Cập nhật tư vấn</div>
    <div class="form-section">
      <form method="POST" action="{{ route('admin.staff.orders.consultation', $order) }}">
        @csrf
        <div class="form-group">
          <label>Trạng thái</label>
          <select name="consultation_status">
            <option value="chua_tu_van" {{ $order->consultation_status === 'chua_tu_van' ? 'selected' : '' }}>Chưa tư vấn</option>
            <option value="da_tu_van"   {{ $order->consultation_status === 'da_tu_van'   ? 'selected' : '' }}>Đã tư vấn</option>
          </select>
        </div>
        <div class="form-group">
          <label>Ghi chú tư vấn</label>
          <textarea name="note" placeholder="Nhập ghi chú...">{{ old('note', $order->note) }}</textarea>
        </div>
        <button type="submit" class="btn-save">Lưu cập nhật</button>
      </form>
    </div>
    @endif

    {{-- Footer --}}
    <div class="order-footer">
      <a href="{{ route('admin.staff.customers') }}" class="btn-link">← Danh sách khách hàng</a>
      <a href="{{ route('admin.staff.orders.index') }}" class="btn-link">← Danh sách đơn hàng</a>
    </div>

  </div>
</div>
@endsection