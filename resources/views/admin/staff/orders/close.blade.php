{{--
  admin/orders/close.blade.php
  Manager nhập sale_price → tự tính hoa hồng:
    < 10 tỷ  → 0.5% × sale_price
    ≥ 10 tỷ  → 1.0% × sale_price
  cost_price hiển thị để manager biết lãi/lỗ (không dùng để tính commission)
--}}

<div class="card card-pad" style="max-width:560px">

  <div style="display:flex;align-items:center;gap:12px;margin-bottom:18px;padding-bottom:14px;border-bottom:1px solid var(--border)">
    <div style="width:36px;height:36px;background:#FFF8E1;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0">💰</div>
    <div>
      <div style="font-weight:700;font-size:14px">Chốt đơn — {{ $order->car->name }}</div>
      <div style="font-size:12px;color:var(--text-2);margin-top:2px">
        MSRP: <strong>{{ number_format($order->car->msrp_price, 0, ',', '.') }}₫</strong>
        @if($order->car->cost_price)
          · Giá nhập: <strong>{{ number_format($order->car->cost_price, 0, ',', '.') }}₫</strong>
        @endif
      </div>
    </div>
  </div>

  @if($errors->any())
    <div class="alert alert-error" style="margin-bottom:16px">
      @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
    </div>
  @endif

  <form method="POST" action="{{ route('admin.orders.close', $order) }}">
    @csrf @method('PATCH')

    {{-- Giá chốt --}}
    <div style="margin-bottom:16px">
      <label class="form-label">
        Giá chốt thực tế <span style="color:var(--danger)">*</span>
        <span style="font-weight:400;color:var(--text-3);font-size:11px">(2 bên thỏa thuận)</span>
      </label>
      <input type="number"
             name="sale_price"
             id="salePrice"
             class="form-control"
             placeholder="Ví dụ: 3200000000"
             min="1"
             step="1000000"
             value="{{ old('sale_price') }}"
             required>
      <div id="saleFmt" style="font-size:12px;color:var(--text-2);margin-top:4px;min-height:16px"></div>
      @error('sale_price')
        <div style="color:var(--danger);font-size:12px;margin-top:4px">{{ $message }}</div>
      @enderror
    </div>

    {{-- Preview --}}
    <div id="preview" style="display:none;background:var(--bg);border:1px solid var(--border);border-radius:8px;padding:14px;margin-bottom:16px;font-size:13px">

      <div style="display:flex;flex-direction:column;gap:8px">

        <div style="display:flex;justify-content:space-between">
          <span style="color:var(--text-2)">Giá MSRP</span>
          <span>{{ number_format($order->car->msrp_price, 0, ',', '.') }}₫</span>
        </div>

        <div style="display:flex;justify-content:space-between">
          <span style="color:var(--text-2)">Giá chốt</span>
          <span id="prevSale" style="font-weight:700"></span>
        </div>

        @if($order->car->cost_price)
        <div style="display:flex;justify-content:space-between">
          <span style="color:var(--text-2)">Lợi nhuận đại lý</span>
          <span id="prevProfit" style="color:#2563eb;font-weight:600"></span>
        </div>
        @endif

        <div style="height:1px;background:var(--border)"></div>

        <div style="display:flex;justify-content:space-between;align-items:center">
          <span style="color:var(--text-2)">
            % Hoa hồng áp dụng
            <span id="rateHint" style="font-size:10px;padding:2px 8px;border-radius:10px;background:#f0f0f0;color:#666;margin-left:6px"></span>
          </span>
          <span id="prevRate" style="font-weight:600"></span>
        </div>

        <div style="background:#fffbea;border:1px solid #fde68a;border-radius:6px;padding:10px 14px;display:flex;justify-content:space-between;align-items:center">
          <span style="font-weight:600">💵 Hoa hồng Sales nhận</span>
          <span id="prevCommission" style="font-weight:800;font-size:17px;color:var(--primary)"></span>
        </div>

      </div>
    </div>

    {{-- Ghi chú --}}
    <div style="margin-bottom:16px">
      <label class="form-label">Ghi chú nội bộ <span style="color:var(--text-3);font-weight:400">(tùy chọn)</span></label>
      <textarea name="manager_note" class="form-control" rows="2"
                placeholder="Ghi chú cho đơn này...">{{ old('manager_note') }}</textarea>
    </div>

    <div style="display:flex;gap:8px;justify-content:flex-end">
      <a href="{{ route('admin.orders.show', $order) }}" class="btn">Hủy</a>
      <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
        ✓ Xác nhận chốt đơn
      </button>
    </div>

  </form>
</div>

<script>
(function () {
  const MSRP      = {{ $order->car->msrp_price }};
  const COST      = {{ $order->car->cost_price ?? 0 }};
  const THRESHOLD = 10_000_000_000;

  const salePriceEl = document.getElementById('salePrice');
  const preview     = document.getElementById('preview');
  const submitBtn   = document.getElementById('submitBtn');

  function fmt(n) {
    if (n >= 1e9) {
      const ty = n / 1e9;
      return (ty % 1 === 0 ? ty.toFixed(0) : ty.toFixed(2).replace(/\.?0+$/, '')) + ' tỷ ₫';
    }
    if (n >= 1e6) return Math.round(n / 1e6).toLocaleString('vi') + ' triệu ₫';
    return n.toLocaleString('vi') + ' ₫';
  }

  function update() {
    const sale = parseInt(salePriceEl.value) || 0;
    document.getElementById('saleFmt').textContent = sale > 0 ? '≈ ' + fmt(sale) : '';

    if (sale <= 0) {
      preview.style.display = 'none';
      submitBtn.disabled    = true;
      return;
    }

    const rate       = sale >= THRESHOLD ? 1.0 : 0.5;
    const commission = Math.round(sale * rate / 100);

    document.getElementById('prevSale').textContent       = fmt(sale);
    document.getElementById('prevRate').textContent       = rate + '%';
    document.getElementById('rateHint').textContent       = sale >= THRESHOLD ? '≥ 10 tỷ → 1%' : '< 10 tỷ → 0.5%';
    document.getElementById('prevCommission').textContent = fmt(commission);

    // Lợi nhuận đại lý (chỉ hiện nếu có cost)
    var profitEl = document.getElementById('prevProfit');
    if (profitEl && COST > 0) {
      profitEl.textContent = fmt(sale - COST);
    }

    preview.style.display = 'block';
    submitBtn.disabled    = false;
  }

  salePriceEl.addEventListener('input', update);
  update();
})();
</script>