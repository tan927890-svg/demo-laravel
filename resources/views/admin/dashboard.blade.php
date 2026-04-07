@extends('layouts.admin')

@section('title', 'AutoAdmin – Quản lý hệ thống xe')

@section('styles')
<style>
  :root {
    --bg-base: #0f1117;
    --bg-surface: #181c27;
    --bg-card: #1e2232;
    --bg-hover: #252a3a;
    --border: #2a3050;
    --border-light: #323859;
    --text-primary: #e8eaf6;
    --text-secondary: #8892b0;
    --text-muted: #4a5270;
    --accent: #4f8cff;
    --accent-glow: rgba(79,140,255,0.18);
    --green: #22d3a5;
    --green-dim: rgba(34,211,165,0.12);
    --red: #ff5c7a;
    --red-dim: rgba(255,92,122,0.12);
    --yellow: #ffb84f;
    --yellow-dim: rgba(255,184,79,0.12);
    --radius: 10px;
    --sidebar-w: 240px;
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: 'Be Vietnam Pro', sans-serif;
    background: var(--bg-base);
    color: var(--text-primary);
    display: flex;
    min-height: 100vh;
    font-size: 14px;
  }

  /* ── SIDEBAR ── */
  .sidebar {
    width: var(--sidebar-w);
    background: var(--bg-surface);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    position: fixed;
    top: 0; left: 0; bottom: 0;
    z-index: 50;
  }

  .logo {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 20px 18px;
    border-bottom: 1px solid var(--border);
  }

  .logo-icon {
    width: 38px; height: 38px;
    background: var(--accent);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
  }

  .logo-text h2 { font-size: 15px; font-weight: 700; color: var(--text-primary); }
  .logo-text p  { font-size: 11px; color: var(--text-muted); margin-top: 1px; }

  .nav-section { padding: 18px 12px 6px; }
  .nav-label {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.12em;
    color: var(--text-muted);
    text-transform: uppercase;
    padding: 0 6px;
    margin-bottom: 6px;
  }

  .nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 10px;
    border-radius: var(--radius);
    cursor: pointer;
    color: var(--text-secondary);
    font-size: 13.5px;
    font-weight: 500;
    transition: all 0.15s;
    margin-bottom: 2px;
    text-decoration: none;
  }
  .nav-item:hover { background: var(--bg-hover); color: var(--text-primary); }
  .nav-item.active { background: var(--accent-glow); color: var(--accent); }
  .nav-item .icon { font-size: 16px; width: 20px; text-align: center; }
  .badge {
    margin-left: auto;
    background: var(--accent);
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 99px;
  }

  .sidebar-bottom {
    margin-top: auto;
    padding: 12px;
    border-top: 1px solid var(--border);
  }

  /* ── MAIN ── */
  .main {
    margin-left: var(--sidebar-w);
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }

  /* ── TOPBAR ── */
  .topbar {
    display: flex; align-items: center;
    padding: 14px 28px;
    border-bottom: 1px solid var(--border);
    background: var(--bg-surface);
    gap: 12px;
  }

  .topbar h1 { font-size: 17px; font-weight: 700; flex: 1; }

  .btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    border: 1px solid var(--border);
    background: var(--bg-card);
    color: var(--text-primary);
    transition: all 0.15s;
    font-family: inherit;
  }
  .btn:hover { background: var(--bg-hover); border-color: var(--border-light); }
  .btn-primary { background: var(--accent); border-color: var(--accent); color: #fff; }
  .btn-primary:hover { background: #3a78f0; border-color: #3a78f0; }

  /* ── CONTENT ── */
  .content { padding: 24px 28px; flex: 1; }

  /* ── STAT CARDS ── */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 24px;
  }

  .stat-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 18px 20px;
    transition: border-color 0.15s;
  }
  .stat-card:hover { border-color: var(--border-light); }

  .stat-label { font-size: 12px; color: var(--text-secondary); font-weight: 500; margin-bottom: 8px; }
  .stat-value { font-size: 28px; font-weight: 700; font-family: 'JetBrains Mono', monospace; line-height: 1; margin-bottom: 6px; }
  .stat-change { font-size: 11.5px; font-weight: 500; }
  .stat-change.up   { color: var(--green); }
  .stat-change.warn { color: var(--red); }
  .stat-change.info { color: var(--yellow); }

  /* ── TABS ── */
  .tabs { display: flex; gap: 4px; margin-bottom: 18px; }
  .tab {
    padding: 8px 18px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    font-size: 13.5px;
    border: 1px solid transparent;
    color: var(--text-secondary);
    transition: all 0.15s;
  }
  .tab.active { background: var(--bg-card); border-color: var(--border); color: var(--text-primary); }
  .tab:hover:not(.active) { color: var(--text-primary); }

  /* ── TABLE PANEL ── */
  .panel {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
  }

  .panel-toolbar {
    display: flex; align-items: center; gap: 10px;
    padding: 14px 18px;
    border-bottom: 1px solid var(--border);
  }

  .search-wrap {
    display: flex; align-items: center;
    background: var(--bg-surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 7px 12px;
    gap: 8px;
    flex: 1; max-width: 300px;
    transition: border-color 0.15s;
  }
  .search-wrap:focus-within { border-color: var(--accent); }
  .search-wrap input {
    background: none; border: none; outline: none;
    color: var(--text-primary); font-size: 13px;
    font-family: inherit; width: 100%;
  }
  .search-wrap input::placeholder { color: var(--text-muted); }
  .search-icon { color: var(--text-muted); font-size: 14px; }

  select {
    background: var(--bg-surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 7px 30px 7px 12px;
    color: var(--text-primary);
    font-size: 13px;
    font-family: inherit;
    outline: none;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238892b0' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    transition: border-color 0.15s;
  }
  select:focus { border-color: var(--accent); }

  /* ── TABLE ── */
  table { width: 100%; border-collapse: collapse; }
  thead th {
    text-align: left;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--text-muted);
    padding: 10px 18px;
    border-bottom: 1px solid var(--border);
  }
  tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background 0.1s;
    cursor: pointer;
  }
  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: var(--bg-hover); }

  td { padding: 14px 18px; vertical-align: middle; }

  .car-name { font-weight: 600; font-size: 14px; color: var(--text-primary); }
  .car-sub  { font-size: 11.5px; color: var(--text-muted); margin-top: 2px; }

  .brand-tag {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 13px; font-weight: 500;
  }

  .type-pill {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 99px;
    font-size: 11.5px;
    font-weight: 600;
  }
  .type-oto   { background: var(--accent-glow); color: var(--accent); }
  .type-suv   { background: var(--green-dim); color: var(--green); }
  .type-dien  { background: var(--yellow-dim); color: var(--yellow); }

  .price {
    font-family: 'JetBrains Mono', monospace;
    font-size: 13.5px;
    font-weight: 600;
    color: var(--text-primary);
  }

  .stock-num { font-family: 'JetBrains Mono', monospace; font-weight: 600; font-size: 14px; }
  .stock-num.out { color: var(--red); }
  .stock-num.low { color: var(--yellow); }
  .stock-num.ok  { color: var(--green); }

  .action-btn {
    background: none; border: none; cursor: pointer;
    color: var(--text-muted); font-size: 17px;
    padding: 4px 6px; border-radius: 6px;
    transition: all 0.12s;
    line-height: 1;
  }
  .action-btn:hover { background: var(--bg-hover); color: var(--text-primary); }

  /* ── PAGINATION ── */
  .pagination {
    display: flex; align-items: center; gap: 6px;
    padding: 14px 18px;
    border-top: 1px solid var(--border);
    background: var(--bg-surface);
  }
  .pg-info { font-size: 12.5px; color: var(--text-muted); flex: 1; }
  .pg-btn {
    width: 32px; height: 32px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 7px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
    border: 1px solid var(--border);
    background: var(--bg-card);
    color: var(--text-secondary);
    transition: all 0.12s;
  }
  .pg-btn:hover { background: var(--bg-hover); color: var(--text-primary); }
  .pg-btn.active { background: var(--accent); border-color: var(--accent); color: #fff; }

  /* ── MODAL ── */
  .modal-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(3px);
    z-index: 100;
    align-items: center; justify-content: center;
  }
  .modal-overlay.open { display: flex; }
  .modal {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    width: 440px;
    max-width: 95vw;
    padding: 28px;
    animation: slideUp 0.2s ease;
  }
  @keyframes slideUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .modal-title { font-size: 17px; font-weight: 700; margin-bottom: 22px; }
  .form-group { margin-bottom: 16px; }
  .form-label { font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px; display: block; }
  .form-input {
    width: 100%;
    background: var(--bg-surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 9px 12px;
    color: var(--text-primary);
    font-size: 13.5px;
    font-family: inherit;
    outline: none;
    transition: border-color 0.15s;
  }
  .form-input:focus { border-color: var(--accent); }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .modal-actions { display: flex; gap: 10px; margin-top: 24px; justify-content: flex-end; }

  /* scrollbar */
  ::-webkit-scrollbar { width: 6px; height: 6px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: var(--border-light); border-radius: 99px; }
</style>
@endsection

@section('content')

<!-- ═══ SIDEBAR ═══ -->
<aside class="sidebar">
  <div class="logo">
    <div class="logo-icon">🚗</div>
    <div class="logo-text">
      <h2>AutoAdmin</h2>
      <p>Quản lý hệ thống xe</p>
    </div>
  </div>

  <div class="nav-section">
    <div class="nav-label">Tổng quan</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <span class="icon">≡</span> Dashboard
    </a>
  </div>

  <div class="nav-section">
    <div class="nav-label">Quản lý</div>
    <a href="{{ route('admin.cars.index') }}" class="nav-item {{ request()->routeIs('admin.cars.*') ? 'active' : '' }}">
      <span class="icon">🚗</span> Sản phẩm xe
      <span class="badge">{{ $stats['total_cars'] ?? 0 }}</span>
    </a>
    <a href="{{ route('admin.orders.index') }}" class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
      <span class="icon">📋</span> Đơn đặt cọc
      @if(($stats['pending_orders'] ?? 0) > 0)
        <span class="badge" style="background:var(--yellow)">{{ $stats['pending_orders'] }}</span>
      @endif
    </a>
    <a href="#" class="nav-item">
      <span class="icon">👥</span> Người dùng
    </a>
  </div>

  <div class="sidebar-bottom">
    <div class="nav-label" style="padding:0 6px;margin-bottom:6px;">Hệ thống</div>
    <a href="#" class="nav-item">
      <span class="icon">⚙️</span> Cài đặt
    </a>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="nav-item" style="width:100%;background:none;border:none;text-align:left;">
        <span class="icon">🚪</span> Đăng xuất
      </button>
    </form>
  </div>
</aside>

<!-- ═══ MAIN ═══ -->
<main class="main">

  <!-- Topbar -->
  <div class="topbar">
    <h1>Sản phẩm xe</h1>
    <button class="btn" onclick="openModal('news')">＋ Thêm tin tức</button>
    <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">＋ Thêm xe mới</a>
  </div>

  <!-- Content -->
  <div class="content">

    <!-- Stats — lấy từ controller -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-label">Tổng sản phẩm</div>
        <div class="stat-value">{{ $stats['total_cars'] ?? 0 }}</div>
        <div class="stat-change up">Tổng xe trong hệ thống</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Đang bán</div>
        <div class="stat-value" style="color:var(--green)">{{ $stats['available_cars'] ?? 0 }}</div>
        <div class="stat-change up">Còn hàng</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Đã bán</div>
        <div class="stat-value" style="color:var(--red)">{{ $stats['sold_cars'] ?? 0 }}</div>
        <div class="stat-change warn">Xe đã bán ra</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Đơn chờ duyệt</div>
        <div class="stat-value">{{ $stats['pending_orders'] ?? 0 }}</div>
        <div class="stat-change info">Cần xử lý</div>
      </div>
    </div>

    <!-- Tabs -->
    <div class="tabs">
      <div class="tab active" onclick="switchTab(this,'cars')">Sản phẩm xe</div>
      <div class="tab" onclick="switchTab(this,'news')">Tin tức</div>
    </div>

    <!-- Table Panel -->
    <div class="panel" id="carsPanel">
      <div class="panel-toolbar">
        <div class="search-wrap">
          <span class="search-icon">🔍</span>
          <input type="text" placeholder="Tìm kiếm..." id="searchInput" oninput="filterTable()">
        </div>
        <select id="filterType" onchange="filterTable()">
          <option value="">Tất cả loại</option>
          <option value="Ô tô">Ô tô</option>
          <option value="SUV">SUV</option>
          <option value="Xe điện">Xe điện</option>
        </select>
        <select id="filterStatus" onchange="filterTable()">
          <option value="">Tất cả trạng thái</option>
          <option value="ok">Còn hàng</option>
          <option value="out">Hết hàng</option>
        </select>
      </div>

      <table id="carTable">
        <thead>
          <tr>
            <th>Tên xe</th>
            <th>Hãng</th>
            <th>Loại</th>
            <th>Giá (VNĐ)</th>
            <th>Tồn kho</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="carTableBody"></tbody>
      </table>

      <div class="pagination">
        <div class="pg-info" id="pgInfo"></div>
        <div id="pgButtons"></div>
      </div>
    </div>

    <!-- News Panel (hidden) -->
    <div class="panel" id="newsPanel" style="display:none; padding:40px; text-align:center; color:var(--text-muted);">
      📰 Quản lý tin tức xe — Coming soon
    </div>

  </div>
</main>

<!-- ═══ MODAL THÊM XE ═══ -->
<div class="modal-overlay" id="carModal">
  <div class="modal">
    <div class="modal-title">🚗 Đăng xe mới</div>
    <form method="POST" action="{{ route('admin.cars.store') }}">
      @csrf
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Tên xe</label>
          <input class="form-input" name="name" placeholder="VD: Camry 2025" required>
        </div>
        <div class="form-group">
          <label class="form-label">Hãng</label>
          <input class="form-input" name="brand" placeholder="VD: Toyota" required>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Loại xe</label>
          <select class="form-input" name="type">
            <option>Ô tô</option>
            <option>SUV</option>
            <option>Xe điện</option>
            <option>Pickup</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Tồn kho</label>
          <input class="form-input" name="stock" type="number" placeholder="0" min="0">
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Phân khúc</label>
        <input class="form-input" name="sub" placeholder="VD: Sedan hạng D">
      </div>
      <div class="form-group">
        <label class="form-label">Giá bán (VNĐ)</label>
        <input class="form-input" name="price" type="number" placeholder="1150000000" required>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn" onclick="closeModal('carModal')">Hủy</button>
        <button type="submit" class="btn btn-primary">Đăng</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL TIN TỨC -->
<div class="modal-overlay" id="newsModal">
  <div class="modal">
    <div class="modal-title">📰 Thêm tin tức</div>
    <div class="form-group">
      <label class="form-label">Tiêu đề</label>
      <input class="form-input" placeholder="Tiêu đề bài viết...">
    </div>
    <div class="form-group">
      <label class="form-label">Tóm tắt</label>
      <textarea class="form-input" rows="3" placeholder="Nội dung tóm tắt..." style="resize:vertical"></textarea>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Chuyên mục</label>
        <select class="form-input">
          <option>Đánh giá xe</option>
          <option>Tin thị trường</option>
          <option>Kỹ thuật</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Tác giả</label>
        <input class="form-input" placeholder="Tên tác giả">
      </div>
    </div>
    <div class="modal-actions">
      <button class="btn" onclick="closeModal('newsModal')">Hủy</button>
      <button class="btn btn-primary">Đăng bài</button>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
// ── DATA từ Laravel (PHP → JS) ──
const cars = @json($cars ?? []);

const typeClass = { 'Ô tô':'type-oto', 'SUV':'type-suv', 'Xe điện':'type-dien' };
const fmtPrice = n => Number(n).toLocaleString('vi-VN');

// ── PAGINATION ──
let page = 1;
const PER = 5;
let filtered = [...cars];

function renderTable() {
  const start = (page-1)*PER, end = start+PER;
  const slice = filtered.slice(start, end);
  const tbody = document.getElementById('carTableBody');

  if (slice.length === 0) {
    tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;padding:40px;color:var(--text-muted)">Không tìm thấy xe nào</td></tr>`;
    document.getElementById('pgInfo').textContent = '';
    document.getElementById('pgButtons').innerHTML = '';
    return;
  }

  tbody.innerHTML = slice.map(c => {
    const stock = parseInt(c.stock ?? 0);
    const sc = stock === 0 ? 'out' : stock <= 5 ? 'low' : 'ok';
    const editUrl = `/admin/cars/${c.id}/edit`;
    return `<tr onclick="window.location='${editUrl}'">
      <td><div class="car-name">${c.name}</div><div class="car-sub">${c.sub ?? ''}</div></td>
      <td><span class="brand-tag">${c.brand}</span></td>
      <td><span class="type-pill ${typeClass[c.type]||'type-oto'}">${c.type}</span></td>
      <td><span class="price">${fmtPrice(c.price)}</span></td>
      <td><span class="stock-num ${sc}">${stock}</span></td>
      <td>
        <a href="${editUrl}" onclick="event.stopPropagation()" class="action-btn" title="Sửa">✏️</a>
      </td>
    </tr>`;
  }).join('');

  document.getElementById('pgInfo').textContent =
    `Hiển thị ${start+1}–${Math.min(end, filtered.length)} / ${filtered.length} sản phẩm`;
  renderPagination();
}

function renderPagination() {
  const total = Math.ceil(filtered.length / PER);
  const wrap = document.getElementById('pgButtons');
  let btns = '';
  for (let i = 1; i <= total; i++) {
    if (i===1 || i===total || Math.abs(i-page)<=1)
      btns += `<button class="pg-btn${i===page?' active':''}" onclick="goPage(${i})">${i}</button>`;
    else if (Math.abs(i-page)===2)
      btns += `<button class="pg-btn" style="cursor:default;pointer-events:none;">…</button>`;
  }
  wrap.innerHTML = `<div style="display:flex;gap:5px">${btns}</div>`;
}

function goPage(n) { page = n; renderTable(); }

function filterTable() {
  const q = document.getElementById('searchInput').value.toLowerCase();
  const t = document.getElementById('filterType').value;
  const s = document.getElementById('filterStatus').value;
  filtered = cars.filter(c => {
    const matchQ = !q || c.name.toLowerCase().includes(q) || c.brand.toLowerCase().includes(q);
    const matchT = !t || c.type === t;
    const stock  = parseInt(c.stock ?? 0);
    const matchS = !s || (s==='out' ? stock===0 : stock>0);
    return matchQ && matchT && matchS;
  });
  page = 1;
  renderTable();
}

// ── TABS ──
function switchTab(el, panel) {
  document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
  document.getElementById('carsPanel').style.display = panel==='cars' ? '' : 'none';
  document.getElementById('newsPanel').style.display = panel==='news' ? '' : 'none';
}

// ── MODAL ──
function openModal(type) {
  document.getElementById(type==='car' ? 'carModal' : 'newsModal').classList.add('open');
}
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

document.querySelectorAll('.modal-overlay').forEach(m => {
  m.addEventListener('click', e => { if (e.target===m) m.classList.remove('open'); });
});

// ── INIT ──
renderTable();
</script>
@endsection