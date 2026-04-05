@extends('layouts.frontend')

@section('title', $car->name . ' - Concept Car Dealer')

@push('styles')
<style>
/* ── DETAIL NAV ── */
.detail-nav {
  position: sticky !important;
   top: 80px !important;
  z-index: 100 !important;
  background: #fff !important;
  border-top: 3px solid #C9A84C !important;
  border-bottom: 1px solid #e5e5e5 !important;
  box-shadow: 0 2px 8px rgba(0,0,0,0.07) !important;
  display: flex !important;
  align-items: stretch !important;
  justify-content: center !important;
  overflow-x: auto !important;
  scrollbar-width: none !important;
  backdrop-filter: none !important;
  padding: 0 !important;
    height: 56px !important;
}
.detail-nav::-webkit-scrollbar { display: none !important; }
.detail-nav a {
  font-family: 'Barlow', sans-serif !important;
  font-size: 15px !important;
  font-weight: 500 !important;
  letter-spacing: 0 !important;
  text-transform: none !important;
  color: #333 !important;
  padding: 14px 24px !important;
  text-decoration: none !important;
  white-space: nowrap !important;
  border-bottom: 3px solid transparent !important;
  border-top: none !important;
  position: relative !important;
  overflow: hidden !important;
  display: flex !important;
  align-items: center !important;
  transition: color .25s, border-color .25s, background .25s !important;
   height: 100%;
  display: flex;
  align-items: center;
}
.detail-nav a:hover { color: #9A6F28 !important; border-bottom-color: rgba(201,168,76,0.4) !important; }
.detail-nav a.active { color: #9A6F28 !important; border-bottom-color: #C9A84C !important; font-weight: 600 !important; background: rgba(201,168,76,0.06) !important; }
.detail-nav a .ripple {
  position: absolute;
  border-radius: 50%;
  background: rgba(201,168,76,0.35);
  transform: scale(0);
  animation: ripple-anim 0.65s linear forwards;
  pointer-events: none;
}
@keyframes ripple-anim { to { transform: scale(4); opacity: 0; } }

/* ── BREADCRUMB ── */
.page-breadcrumb { background:#fff !important; border-bottom:1px solid #DDD0B5 !important; padding:13px 40px !important; display:flex !important; align-items:center !important; gap:8px !important; font-family:'Barlow',sans-serif !important; font-size:13px !important; font-weight:400 !important; color:#555 !important; }
.page-breadcrumb a { color:#555 !important; text-decoration:none !important; transition:color .2s !important; }
.page-breadcrumb a:hover { color:#9A6F28 !important; }
.page-breadcrumb span { color:#9A6F28 !important; font-weight:600 !important; }

/* ── HERO ── */
.car-hero { position:relative; height:520px; overflow:hidden; background:#0d0d0f; }
.car-hero-img { width:100%; height:100%; object-fit:cover; display:block; transform:scale(1.01); animation:hero-zoom 6s ease-out forwards; }
@keyframes hero-zoom { to { transform:scale(1); } }
.car-hero-overlay { position:absolute; inset:0; background:linear-gradient(90deg,rgba(0,0,0,.75) 0%,rgba(0,0,0,.2) 60%,transparent 100%); }
.car-hero-content { position:absolute; bottom:0; left:0; right:0; padding:0 80px 60px; display:flex; align-items:flex-end; justify-content:space-between; }
.car-hero-eyebrow { font-family:'Rajdhani',sans-serif; font-size:11px; font-weight:700; letter-spacing:4px; text-transform:uppercase; color:var(--red); margin-bottom:10px; display:flex; align-items:center; gap:12px; }
.car-hero-eyebrow::before { content:''; width:28px; height:1px; background:var(--red); }
.car-hero-name { font-family:'Barlow Condensed',sans-serif; font-size:clamp(52px,7vw,90px); font-weight:900; color:var(--white); text-transform:uppercase; letter-spacing:-2px; line-height:.9; animation:slide-up .7s cubic-bezier(.22,1,.36,1) both; }
@keyframes slide-up { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:none} }
.car-hero-tagline { font-family:'Barlow Condensed',sans-serif; font-size:20px; font-weight:500; color:rgba(255,255,255,.55); text-transform:uppercase; letter-spacing:3px; margin-top:8px; }
.car-hero-right { text-align:right; }
.car-hero-price-label { font-family:'Rajdhani',sans-serif; font-size:10px; font-weight:600; letter-spacing:3px; text-transform:uppercase; color:var(--muted); margin-bottom:4px; }
.car-hero-price { font-family:'Barlow Condensed',sans-serif; font-size:42px; font-weight:900; color:var(--red); line-height:1; }
.car-hero-price small { font-family:'Barlow',sans-serif; font-size:13px; font-weight:400; color:var(--muted); }
.car-hero-status { display:inline-flex; align-items:center; gap:6px; margin-top:10px; font-family:'Rajdhani',sans-serif; font-size:10px; font-weight:700; letter-spacing:2px; text-transform:uppercase; padding:5px 12px; }
.status-available   { background:rgba(34,197,94,.15);  border:1px solid rgba(34,197,94,.4);  color:#4ade80; }
.status-rented      { background:rgba(212,43,43,.15);   border:1px solid rgba(212,43,43,.4);   color:#f87171; }
.status-maintenance { background:rgba(234,179,8,.15);   border:1px solid rgba(234,179,8,.4);   color:#fbbf24; }
.car-hero-placeholder { width:100%; height:100%; background:linear-gradient(160deg,#1c1c1e 0%,#2a1616 45%,#1c1c1e 100%); }

/* ── SECTIONS ── */
.section { padding:72px 0; }
.section-alt { background:var(--bg2); }
.container { max-width:1280px; margin:0 auto; padding:0 60px; }
.section-label { font-family:'Rajdhani',sans-serif; font-size:11px; font-weight:700; letter-spacing:4px; text-transform:uppercase; color:var(--red); margin-bottom:8px; display:flex; align-items:center; gap:12px; }
.section-label::before { content:''; width:24px; height:1px; background:var(--red); }
.section-title { font-family:'Barlow Condensed',sans-serif; font-size:clamp(32px,4vw,52px); font-weight:900; color:var(--white); text-transform:uppercase; letter-spacing:-1px; margin-bottom:48px; line-height:1; }
.section-title em { color:var(--red); font-style:normal; }

/* ── GIÁ & MÀU SẮC ── */
.price-color-section { background:#f5f4f0; padding:72px 0; }
.price-color-layout { display:grid; grid-template-columns:1fr 1fr; gap:80px; align-items:center; }
.pcs-left .section-label { color:#c00; }
.pcs-left .section-label::before { background:#c00; }
.pcs-left .section-title { color:#111; margin-bottom:32px; }
.pcs-left .section-title em { color:#c00; }
.variant-tabs { display:flex; gap:4px; margin-bottom:32px; flex-wrap:wrap; }
.variant-tab { font-family:'Rajdhani',sans-serif; font-size:11px; font-weight:700; letter-spacing:2px; text-transform:uppercase; padding:9px 20px; background:#e8e6e0; border:1px solid #d0cec8; color:#555; cursor:pointer; transition:all .2s; }
.variant-tab.active,.variant-tab:hover { background:#c00; border-color:#c00; color:#fff; }
.color-swatches { display:flex; gap:20px; flex-wrap:wrap; margin-bottom:8px; }
.color-swatch { display:flex; flex-direction:column; align-items:center; gap:10px; cursor:pointer; }
.swatch-circle { width:56px; height:56px; border-radius:50%; border:3px solid transparent; box-shadow:0 0 0 1px rgba(0,0,0,.15); transition:border-color .2s,transform .2s; }
.color-swatch:hover .swatch-circle { transform:scale(1.08); }
.color-swatch.active .swatch-circle { border-color:#c00; box-shadow:0 0 0 2px #c00; }
.swatch-name { font-family:'Rajdhani',sans-serif; font-size:10px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#999; transition:color .2s; }
.color-swatch.active .swatch-name { color:#c00; }
.color-selected-label { font-family:'Rajdhani',sans-serif; font-size:12px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:#c00; margin-bottom:24px; min-height:18px; }
.price-display { margin-bottom:28px; }
.price-display-label { font-family:'Rajdhani',sans-serif; font-size:10px; font-weight:600; letter-spacing:3px; text-transform:uppercase; color:#888; margin-bottom:6px; }
.price-display-value { font-family:'Barlow Condensed',sans-serif; font-size:52px; font-weight:900; color:#111; line-height:1; }
.price-display-value span { font-size:18px; font-family:'Barlow',sans-serif; color:#888; margin-left:4px; }
.cta-row { display:flex; gap:12px; flex-wrap:wrap; }
.btn-primary { font-family:'Rajdhani',sans-serif; font-size:12px; font-weight:700; letter-spacing:3px; text-transform:uppercase; background:#c00; color:#fff; border:2px solid #c00; padding:14px 28px; cursor:pointer; transition:background .2s; text-decoration:none; display:inline-block; }
.btn-primary:hover { background:#a00; border-color:#a00; }
.btn-outline { font-family:'Rajdhani',sans-serif; font-size:12px; font-weight:700; letter-spacing:3px; text-transform:uppercase; background:transparent; color:#111; border:2px solid #111; padding:14px 28px; cursor:pointer; transition:all .2s; text-decoration:none; display:inline-block; }
.btn-outline:hover { border-color:#c00; color:#c00; }
.color-preview { position:relative; display:flex; align-items:center; justify-content:center; min-height:400px; }
.color-preview-watermark { position:absolute; top:10px; right:0; font-family:'Barlow Condensed',sans-serif; font-size:clamp(52px,8vw,100px); font-weight:900; text-transform:uppercase; letter-spacing:-3px; color:rgba(0,0,0,.05); line-height:1; pointer-events:none; user-select:none; white-space:nowrap; }
.color-preview-img { width:100%; max-height:400px; object-fit:contain; display:block; transition:opacity .35s ease; filter:drop-shadow(0 20px 56px rgba(0,0,0,.2)); position:relative; z-index:1; }
.color-preview-badge { position:absolute; bottom:0; right:0; z-index:2; font-family:'Rajdhani',sans-serif; font-size:10px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:#555; background:#e8e6e0; border:1px solid #d0cec8; padding:6px 14px; }
.color-preview-placeholder { width:100%; min-height:320px; display:flex; align-items:center; justify-content:center; background:#e8e6e0; }

/* ══════════════════════════════
   TÍNH NĂNG – Honda-style fullscreen scroll snap
══════════════════════════════ */
.features-section {
  background: #0d0d0f;
  position: relative;
}

/* Wrapper scroll-snap toàn màn hình */
.features-snap-wrap {
  position: relative;
}

/* Mỗi feature chiếm đúng 100vh, snap vào giữa */
.feature-slide {
  display: grid;
  grid-template-columns: 55% 45%;
  height: 100vh;
  position: relative;
  /* Scroll-reveal */
  opacity: 0;
  transform: translateY(40px);
  transition: opacity .75s cubic-bezier(.22,1,.36,1), transform .75s cubic-bezier(.22,1,.36,1);
}
.feature-slide.in-view {
  opacity: 1;
  transform: none;
}
.feature-slide.reverse {
  grid-template-columns: 45% 55%;
}

/* ── Ảnh ── */
.feature-slide-img {
  position: relative;
  overflow: hidden;
}
.feature-slide-img img {
  width: 100%; height: 100%;
  object-fit: cover; display: block;
  transition: transform 0.6s ease;
}
.feature-slide.in-view .feature-slide-img img { transform: scale(1.04); }
.feature-slide-img::after {
  content: '';
  position: absolute; inset: 0;
  background: linear-gradient(90deg, transparent 60%, rgba(13,13,15,.6) 100%);
  pointer-events: none;
}
.feature-slide.reverse .feature-slide-img::after {
  background: linear-gradient(270deg, transparent 60%, rgba(13,13,15,.6) 100%);
}

/* ── Text ── */
.feature-slide-body {
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 72px 80px;
  background: #111;
  position: relative;
  overflow: hidden;
}
.feature-slide.reverse .feature-slide-img { order: 2; }
.feature-slide.reverse .feature-slide-body { order: 1; background: #0d0d0f; }

/* Đường kẻ trang trí */
.feature-slide-body::before {
  content: '';
  position: absolute;
  left: 0; top: 72px; bottom: 72px;
  width: 3px;
  background: linear-gradient(to bottom, transparent, var(--red) 30%, var(--red) 70%, transparent);
  opacity: 0;
  transition: opacity .5s .4s;
}
.feature-slide.in-view .feature-slide-body::before { opacity: 1; }
.feature-slide.reverse .feature-slide-body::before { left: auto; right: 0; }

/* Progress bar dưới cùng slide */
.feature-slide-progress {
  position: absolute;
  bottom: 0; left: 0;
  height: 3px;
  background: var(--red, #c00);
  width: 0%;
  transition: width linear;
  z-index: 5;
}

/* Số thứ tự */
.feature-slide-number {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 120px; font-weight: 900;
  color: rgba(255,255,255,.03);
  line-height: 1;
  position: absolute;
  top: 24px; right: 40px;
  letter-spacing: -6px;
  user-select: none; pointer-events: none;
}
.feature-slide.reverse .feature-slide-number { right: auto; left: 40px; }

.feature-slide-badge {
  font-family: 'Rajdhani', sans-serif;
  font-size: 10px; font-weight: 700; letter-spacing: 4px;
  text-transform: uppercase; color: var(--red);
  margin-bottom: 16px;
  display: flex; align-items: center; gap: 10px;
  /* animate vào */
  opacity: 0; transform: translateX(-16px);
  transition: opacity .5s .2s, transform .5s .2s;
}
.feature-slide.in-view .feature-slide-badge { opacity: 1; transform: none; }
.feature-slide-badge::before {
  content: '';
  width: 20px; height: 1px;
  background: var(--red); flex-shrink: 0;
}
.feature-slide-variant {
  font-family: 'Barlow', sans-serif;
  font-size: 12px; color: rgba(255,255,255,.38);
  margin-bottom: 12px; letter-spacing: 2px;
  text-transform: uppercase;
  opacity: 0; transform: translateX(-16px);
  transition: opacity .5s .3s, transform .5s .3s;
}
.feature-slide.in-view .feature-slide-variant { opacity: 1; transform: none; }

.feature-slide-title {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: clamp(36px, 4.5vw, 64px); font-weight: 900;
  color: #fff; text-transform: uppercase;
  letter-spacing: -1px; line-height: .92;
  font-style: italic; margin-bottom: 24px;
  opacity: 0; transform: translateY(24px);
  transition: opacity .6s .25s, transform .6s .25s;
}
.feature-slide.in-view .feature-slide-title { opacity: 1; transform: none; }

.feature-slide-desc {
  font-size: 15px; color: rgba(255,255,255,.58);
  line-height: 1.9; margin-bottom: 40px;
  max-width: 480px;
  opacity: 0; transform: translateY(16px);
  transition: opacity .6s .35s, transform .6s .35s;
}
.feature-slide.in-view .feature-slide-desc { opacity: 1; transform: none; }

.btn-feature-detail {
  font-family: 'Rajdhani', sans-serif;
  font-size: 11px; font-weight: 700; letter-spacing: 3px;
  text-transform: uppercase;
  background: transparent; color: #fff;
  border: 1px solid rgba(255,255,255,.35);
  padding: 14px 32px; cursor: pointer;
  transition: border-color .25s, background .25s, color .25s;
  text-decoration: none;
  display: inline-flex; align-items: center; gap: 10px;
  align-self: flex-start;
  position: relative; overflow: hidden;
  opacity: 0; transform: translateY(12px);
  transition: opacity .5s .45s, transform .5s .45s, border-color .25s, background .25s;
}
.feature-slide.in-view .btn-feature-detail { opacity: 1; transform: none; }
.btn-feature-detail::after {
  content: '';
  position: absolute; inset: 0;
  background: var(--red);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform .3s cubic-bezier(.22,1,.36,1);
  z-index: 0;
}
.btn-feature-detail span { position: relative; z-index: 1; }
.btn-feature-detail:hover { border-color: var(--red); color: #fff; }
.btn-feature-detail:hover::after { transform: scaleX(1); }

/* ── Dot nav bên phải ── */
.features-dot-nav {
  position: fixed;
  right: 28px;
  top: 50%;
  transform: translateY(-50%);
  z-index: 200;
  display: flex;
  flex-direction: column;
  gap: 10px;
  opacity: 0;
  pointer-events: none;
  transition: opacity .3s;
}
.features-dot-nav.visible {
  opacity: 1;
  pointer-events: auto;
}
.feat-dot {
  width: 8px; height: 8px;
  border-radius: 50%;
  background: rgba(255,255,255,.3);
  border: 1px solid rgba(255,255,255,.5);
  cursor: pointer;
  transition: background .25s, transform .25s;
  display: block;
}
.feat-dot.active {
  background: #c00;
  border-color: #c00;
  transform: scale(1.4);
}

/* Arrow nav ở góc phải dưới */
.features-arrows {
  position: fixed;
  right: 28px;
  bottom: 40px;
  z-index: 200;
  display: flex;
  flex-direction: column;
  gap: 8px;
  opacity: 0;
  pointer-events: none;
  transition: opacity .3s;
}
.features-arrows.visible { opacity: 1; pointer-events: auto; }
.feat-arrow {
  width: 44px; height: 44px;
  background: rgba(255,255,255,.08);
  border: 1px solid rgba(255,255,255,.2);
  color: #fff;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer;
  font-size: 18px;
  transition: background .2s, border-color .2s;
  user-select: none;
}
.feat-arrow:hover { background: #c00; border-color: #c00; }
.feat-arrow:disabled { opacity: .3; pointer-events: none; }

/* Divider */
.feature-divider {
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,.08) 20%, rgba(255,255,255,.08) 80%, transparent);
}

/* ── MODAL ── */
.feature-modal-backdrop { position:fixed; inset:0; z-index:99999 !important; background:rgba(0,0,0,.96); display:none; flex-direction:column; opacity:0; transition:opacity .3s; overflow-y:auto; }
.feature-modal-backdrop.visible { opacity:1; }
.feature-modal { min-height:100vh; display:flex; flex-direction:column; background:#0d0d0f; }
.feature-modal-header { padding:48px 72px 0; display:flex; align-items:flex-start; justify-content:space-between; gap:24px; }
.feature-modal-badge { font-family:'Rajdhani',sans-serif; font-size:11px; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:var(--red); margin-bottom:10px; }
.feature-modal-title { font-family:'Barlow Condensed',sans-serif; font-size:clamp(36px,6vw,72px); font-weight:900; color:#fff; text-transform:uppercase; letter-spacing:-2px; font-style:italic; line-height:.95; }
.feature-modal-close { width:52px; height:52px; background:#c00; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:22px; color:#fff; transition:background .2s; margin-top:4px; }
.feature-modal-close:hover { background:#a00; }
.feature-modal-body { flex:1; display:grid; grid-template-columns:1fr 1fr; gap:0; margin-top:48px; }
.feature-modal-desc { padding:0 72px 72px; display:flex; flex-direction:column; }
.feature-modal-text { font-size:16px; color:rgba(255,255,255,.7); line-height:1.85; }
.feature-modal-imgs { display:grid; grid-template-columns:1fr 1fr; grid-template-rows:1fr 1fr; gap:2px; }
.feature-modal-imgs img { width:100%; height:100%; object-fit:cover; display:block; }
.feature-modal-imgs img:only-child { grid-column:1/-1; grid-row:1/-1; }

/* ── THÔNG SỐ ── */
.specs-variant-tabs { display:flex; gap:2px; margin-bottom:32px; flex-wrap:wrap; }
.spec-table { width:100%; border-collapse:collapse; margin-bottom:32px; }
.spec-table-category { font-family:'Rajdhani',sans-serif; font-size:11px; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:var(--white); background:rgba(212,43,43,.15); border-left:3px solid var(--red); padding:12px 20px; text-align:left; }
.spec-table td { padding:12px 20px; border-bottom:1px solid var(--border); font-size:14px; vertical-align:top; }
.spec-table tr:last-child td { border-bottom:none; }
.spec-key { color:var(--muted); width:45%; }
.spec-val { color:var(--white); font-weight:500; }
.spec-table tr:hover td { background:rgba(255,255,255,.025); }

/* ── THƯ VIỆN ── */
.gallery-tabs { display:flex; gap:24px; margin-bottom:28px; border-bottom:1px solid var(--border); }
.gallery-tab { font-family:'Rajdhani',sans-serif; font-size:12px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--muted); padding:0 0 14px; cursor:pointer; border-bottom:2px solid transparent; transition:color .2s,border-color .2s; background:none; border-top:none; border-left:none; border-right:none; }
.gallery-tab.active { color:var(--red); border-bottom-color:var(--red); }
.gallery-main { margin-bottom:8px; background:var(--bg3); overflow:hidden; }
.gallery-main-img { width:100%; max-height:520px; object-fit:cover; display:block; transition:opacity .3s; }
.gallery-thumbs { display:flex; gap:6px; overflow-x:auto; scrollbar-width:none; }
.gallery-thumbs::-webkit-scrollbar { display:none; }
.gallery-thumb { flex-shrink:0; width:100px; height:68px; overflow:hidden; cursor:pointer; border:2px solid transparent; transition:border-color .2s; }
.gallery-thumb.active { border-color:var(--red); }
.gallery-thumb img { width:100%; height:100%; object-fit:cover; }

/* ── RELATED ── */
.related-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:2px; background:var(--border); }
.related-card { background:var(--card); overflow:hidden; position:relative; transition:background .3s; text-decoration:none; display:block; }
.related-card:hover { background:var(--bg3); }
.related-card::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; background:var(--red); transform:scaleX(0); transform-origin:left; transition:transform .35s; z-index:2; }
.related-card:hover::before { transform:scaleX(1); }
.related-img { width:100%; height:160px; object-fit:cover; display:block; }
.related-body { padding:16px; }
.related-brand { font-family:'Rajdhani',sans-serif; font-size:9px; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:var(--red); margin-bottom:4px; }
.related-name { font-family:'Barlow Condensed',sans-serif; font-size:18px; font-weight:700; color:var(--white); text-transform:uppercase; margin-bottom:8px; }
.related-price { font-family:'Barlow Condensed',sans-serif; font-size:20px; font-weight:800; color:var(--red); }
.related-price small { font-size:11px; color:var(--muted); font-family:'Barlow',sans-serif; }

/* ── CTA ── */
.info-cta { background:var(--bg3); padding:80px 60px; text-align:center; }
.info-cta-title { font-family:'Barlow Condensed',sans-serif; font-size:36px; font-weight:900; color:var(--white); text-transform:uppercase; letter-spacing:-1px; margin-bottom:28px; }
.info-cta-btns { display:flex; justify-content:center; gap:12px; flex-wrap:wrap; }
.info-cta-btn { font-family:'Rajdhani',sans-serif; font-size:12px; font-weight:700; letter-spacing:3px; text-transform:uppercase; border:1px solid var(--white); color:var(--white); padding:16px 40px; min-width:280px; cursor:pointer; background:transparent; transition:background .2s,color .2s; text-decoration:none; display:inline-block; text-align:center; }
.info-cta-btn:hover { background:var(--white); color:#111; }

/* ── RESPONSIVE ── */
@media(max-width:1024px) {
  .price-color-layout { grid-template-columns:1fr; gap:40px; }
  .feature-slide { grid-template-columns:1fr !important; height:auto; min-height:100vh; }
  .feature-slide.reverse .feature-slide-img { order:0; }
  .feature-slide.reverse .feature-slide-body { order:1; }
  .feature-slide-img { min-height:300px; }
  .feature-slide-body { padding: 48px 40px; }
  .feature-modal-body { grid-template-columns:1fr; }
  .feature-modal-header,.feature-modal-desc { padding-left:28px; padding-right:28px; }
  .related-grid { grid-template-columns:repeat(2,1fr); }
  .car-hero-content { padding:0 40px 40px; flex-direction:column; align-items:flex-start; gap:20px; }
  .features-dot-nav, .features-arrows { display:none; }
}
@media(max-width:768px) {
  .container { padding:0 20px; }
  .page-breadcrumb { padding:14px 20px; }
  .car-hero { height:380px; }
  .related-grid { grid-template-columns:1fr; }
  .info-cta { padding:60px 20px; }
  .info-cta-btn { min-width:unset; width:100%; }
  .feature-slide-body { padding:36px 24px; }
  .feature-modal-imgs { grid-template-columns:1fr; }
  .detail-nav a { padding:14px 16px !important; font-size:13px !important; }
}
</style>
@endpush

@section('content')

@php
function carImgPath($val) {
    if (!$val) return null;
    $filename = basename(str_replace('\\', '/', $val));
    return asset('images/car/' . $filename);
}
@endphp

{{-- BREADCRUMB --}}
<div class="page-breadcrumb">
  <a href="{{ url('/') }}">Home</a> ›
  <a href="{{ route('cars.index') }}">Xe</a> ›
  <span>{{ $car->name }}</span>
</div>

{{-- STICKY NAV --}}
<nav class="detail-nav" id="detail-nav">
  <a href="#gia-mau-sac" class="nav-link active">Giá & Màu sắc</a>
  <a href="#tinh-nang"   class="nav-link">Tính năng nổi bật</a>
  <a href="#thong-so"    class="nav-link">Thông số kỹ thuật</a>
  <a href="#thu-vien"    class="nav-link">Thư viện ảnh</a>
  <a href="#thong-tin"   class="nav-link">Thông tin chi tiết</a>
  @if($relatedCars->count())
  <a href="#so-sanh" class="nav-link">So sánh sản phẩm</a>
  @endif
</nav>

{{-- HERO --}}
<section class="car-hero">
  @php
    $heroSrc = carImgPath($car->hero_image)
            ?? carImgPath($car->image_url)
            ?? carImgPath($car->image);
  @endphp
  @if($heroSrc)
    <img class="car-hero-img" src="{{ $heroSrc }}" alt="{{ $car->name }}">
  @else
    <div class="car-hero-placeholder"></div>
  @endif
  <div class="car-hero-overlay"></div>
  <div class="car-hero-content">
    <div class="car-hero-left">
      <div class="car-hero-eyebrow">{{ $car->brand?->name ?? $car->brand }}</div>
      <div class="car-hero-name">{{ $car->name }}</div>
      @if($car->tagline)
        <div class="car-hero-tagline">{{ $car->tagline }}</div>
      @endif
    </div>
    <div class="car-hero-right">
      <div class="car-hero-price-label">Giá thuê từ</div>
      <div class="car-hero-price">
        {{ number_format($car->price_per_day ?? $car->price) }}
        <small>VNĐ/ngày</small>
      </div>
      @php
        $statusMap = [
          'available'   => ['class'=>'status-available',   'label'=>'Còn xe'],
          'rented'      => ['class'=>'status-rented',       'label'=>'Đang thuê'],
          'maintenance' => ['class'=>'status-maintenance',  'label'=>'Bảo dưỡng'],
        ];
        $st = $statusMap[$car->status ?? 'available'] ?? $statusMap['available'];
      @endphp
      <div class="car-hero-status {{ $st['class'] }}">● {{ $st['label'] }}</div>
    </div>
  </div>
</section>

{{-- GIÁ & MÀU SẮC --}}
<section class="price-color-section" id="gia-mau-sac">
  <div class="container">
    <div class="price-color-layout">
      <div class="pcs-left">
        <div class="section-label">Bộ sưu tập</div>
        <div class="section-title">Giá & <em>Màu sắc</em></div>

        @if($car->variants->count())
        <div class="variant-tabs" id="variant-tabs">
          @foreach($car->variants as $variant)
            <button class="variant-tab {{ $loop->first ? 'active' : '' }}"
                    data-price="{{ $variant->price }}"
                    onclick="selectVariant(this)">{{ $variant->name }}</button>
          @endforeach
        </div>
        @endif

        @if($car->colors->count())
        <div class="color-swatches">
          @foreach($car->colors as $color)
            @php $colorImgUrl = carImgPath($color->image); @endphp
            <div class="color-swatch {{ $color->is_default || $loop->first ? 'active' : '' }}"
                 data-image="{{ $colorImgUrl ?? '' }}"
                 data-name="{{ $color->name }}"
                 onclick="selectColor(this)">
              <div class="swatch-circle" style="background:{{ $color->hex_code }};"></div>
              <div class="swatch-name">{{ $color->name }}</div>
            </div>
          @endforeach
        </div>
        <div class="color-selected-label" id="color-selected-label">
          {{ $car->colors->firstWhere('is_default', true)?->name ?? $car->colors->first()?->name }}
        </div>
        @endif

        <div class="price-display">
          <div class="price-display-label">Giá bán lẻ đề xuất</div>
          <div class="price-display-value" id="price-display">
            {{ number_format($car->variants->first()?->price ?? $car->price_per_day ?? $car->price) }}
            <span>VNĐ</span>
          </div>
        </div>

        <div class="cta-row">
          <a href="{{ route('orders.create', $car) }}" class="btn-primary">Đặt xe ngay →</a>
          <a href="#thong-tin" class="btn-outline">Xem thêm →</a>
        </div>
      </div>

      <div class="color-preview">
        <div class="color-preview-watermark">{{ $car->name }}</div>
        @php
          $firstColorImg = $car->colors->firstWhere('is_default', true)?->image
                        ?? $car->colors->first()?->image;
          $previewSrc = carImgPath($firstColorImg)
                     ?? carImgPath($car->image_url)
                     ?? carImgPath($car->image);
        @endphp
        @if($previewSrc)
          <img class="color-preview-img" id="color-preview-img"
               src="{{ $previewSrc }}" alt="{{ $car->name }}">
        @else
          <div class="color-preview-placeholder">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="rgba(0,0,0,.15)" stroke-width="1">
              <rect x="1" y="3" width="15" height="13"/>
              <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/>
              <circle cx="5.5" cy="18.5" r="2.5"/>
              <circle cx="18.5" cy="18.5" r="2.5"/>
            </svg>
          </div>
        @endif
        <div class="color-preview-badge" id="color-preview-badge">
          {{ $car->colors->firstWhere('is_default', true)?->name
          ?? $car->colors->first()?->name ?? $car->name }}
        </div>
      </div>
    </div>
  </div>
</section>

{{-- TÍNH NĂNG NỔI BẬT --}}
@if($car->features->count())
<section class="features-section" id="tinh-nang">

  {{-- Dot navigation --}}
  <div class="features-dot-nav" id="feat-dot-nav">
    @foreach($car->features as $feature)
      <span class="feat-dot {{ $loop->first ? 'active' : '' }}"
            data-index="{{ $loop->index }}"
            title="{{ $feature->title }}"></span>
    @endforeach
  </div>

  {{-- Arrow navigation --}}
  <div class="features-arrows" id="feat-arrows">
    <button class="feat-arrow" id="feat-prev" title="Tính năng trước">▲</button>
    <button class="feat-arrow" id="feat-next" title="Tính năng tiếp">▼</button>
  </div>

  <div class="features-snap-wrap" id="features-snap-wrap">
    @foreach($car->features as $feature)
      @php
        $featImgUrl  = carImgPath($feature->image);
        $isReverse   = $loop->index % 2 === 1;
        $badgeText   = 'TÍNH NĂNG NỔI BẬT';
        $variantText = $feature->variant?->name ? 'Phiên bản ' . $feature->variant->name : '';
        $num         = str_pad($loop->iteration, 2, '0', STR_PAD_LEFT);
      @endphp

      @if(!$loop->first)
        <div class="feature-divider"></div>
      @endif

      <div class="feature-slide {{ $isReverse ? 'reverse' : '' }}"
           id="feat-slide-{{ $loop->index }}"
           data-index="{{ $loop->index }}"
           data-title="{{ $feature->title }}"
           data-desc="{{ $feature->description }}"
           data-badge="{{ $badgeText }}"
           data-variant="{{ $variantText }}"
           data-img="{{ $featImgUrl ?? '' }}">

        <div class="feature-slide-img">
          @if($featImgUrl)
            <img src="{{ $featImgUrl }}" alt="{{ $feature->title }}" loading="lazy">
          @else
            <div style="width:100%;height:100%;min-height:100vh;background:#1a1a1a;display:flex;align-items:center;justify-content:center;">
              <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.1)" stroke-width="1"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
            </div>
          @endif
        </div>

        <div class="feature-slide-body">
          <div class="feature-slide-progress" id="feat-progress-{{ $loop->index }}"></div>
          <div class="feature-slide-number">{{ $num }}</div>
          <div class="feature-slide-badge">{{ $badgeText }}</div>
          @if($variantText)
            <div class="feature-slide-variant">{{ $variantText }}</div>
          @endif
          <div class="feature-slide-title">{{ $feature->title }}</div>
          <div class="feature-slide-desc">{{ $feature->description }}</div>
          <button class="btn-feature-detail"
                  onclick="openFeatureModal(this.closest('.feature-slide'))">
            <span>XEM CHI TIẾT →</span>
          </button>
        </div>
      </div>
    @endforeach
  </div>
</section>

{{-- MODAL --}}
<div class="feature-modal-backdrop" id="feature-modal-backdrop">
  <div class="feature-modal">
    <div class="feature-modal-header">
      <div>
        <div class="feature-modal-badge" id="modal-badge"></div>
        <div class="feature-modal-title" id="modal-title"></div>
      </div>
      <button class="feature-modal-close" onclick="closeFeatureModal()">✕</button>
    </div>
    <div class="feature-modal-body">
      <div class="feature-modal-desc">
        <div class="feature-modal-text" id="modal-desc"></div>
      </div>
      <div class="feature-modal-imgs" id="modal-imgs"></div>
    </div>
  </div>
</div>
@endif

{{-- THÔNG SỐ KỸ THUẬT --}}
@if($specsByCategory->count())
<section class="section" id="thong-so">
  <div class="container">
    <div class="section-label">Chi tiết</div>
    <div class="section-title">Thông Số <em>Kỹ Thuật</em></div>
    @if($car->variants->count())
    <div class="specs-variant-tabs">
      @foreach($car->variants as $variant)
        <button class="variant-tab {{ $loop->first ? 'active' : '' }}"
                data-variant="{{ $variant->id }}"
                onclick="selectSpecVariant(this)">{{ $variant->name }}</button>
      @endforeach
    </div>
    @endif
    <table class="spec-table">
      @foreach($specsByCategory as $category => $specs)
        <tr><td colspan="2" class="spec-table-category">{{ $category }}</td></tr>
        @foreach($specs as $spec)
          <tr>
            <td class="spec-key">{{ $spec->spec_key }}</td>
            <td class="spec-val">{{ $spec->spec_value }}</td>
          </tr>
        @endforeach
      @endforeach
    </table>
  </div>
</section>
@endif

{{-- THƯ VIỆN ẢNH --}}
@if($car->galleries->count())
<section class="section section-alt" id="thu-vien">
  <div class="container">
    <div class="section-label">Khám phá</div>
    <div class="section-title"><em>Thư Viện</em> Ảnh</div>
    @php
      $imageGalleries = $car->galleries->where('type', 'image');
      $videoGalleries = $car->galleries->where('type', 'video');
    @endphp
    <div class="gallery-tabs">
      @if($imageGalleries->count())
        <button class="gallery-tab active" onclick="switchGalleryTab('image', this)">Ảnh</button>
      @endif
      @if($videoGalleries->count())
        <button class="gallery-tab {{ !$imageGalleries->count() ? 'active' : '' }}"
                onclick="switchGalleryTab('video', this)">Video</button>
      @endif
    </div>
    <div class="gallery-main">
      @php $firstImg = $imageGalleries->first(); @endphp
      @if($firstImg)
        <img class="gallery-main-img" id="gallery-main-img"
             src="{{ carImgPath($firstImg->file_path) }}" alt="{{ $car->name }}">
      @endif
    </div>
    <div class="gallery-thumbs">
      @foreach($imageGalleries as $img)
        @php $imgUrl = carImgPath($img->file_path); @endphp
        <div class="gallery-thumb {{ $loop->first ? 'active' : '' }}"
             onclick="selectThumb(this, '{{ $imgUrl }}')">
          <img src="{{ $imgUrl }}" alt="">
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- THÔNG TIN CHI TIẾT --}}
<section class="section" id="thong-tin">
  <div class="info-cta">
    <div class="info-cta-title">Thông Tin Chi Tiết</div>
    <div class="info-cta-btns">
      <a href="{{ route('orders.create', $car) }}" class="info-cta-btn">Đặt xe ngay →</a>
      @if($relatedCars->count())
        <a href="#so-sanh" class="info-cta-btn">So sánh sản phẩm →</a>
      @endif
    </div>
  </div>
</section>

{{-- XE LIÊN QUAN --}}
@if($relatedCars->count())
<section class="section section-alt" id="so-sanh">
  <div class="container">
    <div class="section-label">Cùng hãng</div>
    <div class="section-title">Xe <em>Liên Quan</em></div>
  </div>
  <div class="related-grid">
    @foreach($relatedCars as $related)
      @php $relImg = carImgPath($related->image_url) ?? carImgPath($related->image); @endphp
      <a href="{{ route('cars.show', $related->id) }}" class="related-card">
        @if($relImg)
          <img class="related-img" src="{{ $relImg }}" alt="{{ $related->name }}" onerror="this.style.display='none'">
        @else
          <div style="height:160px;background:var(--bg3);display:flex;align-items:center;justify-content:center;">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.2)" stroke-width="1">
              <rect x="1" y="3" width="15" height="13"/>
              <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/>
              <circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>
            </svg>
          </div>
        @endif
        <div class="related-body">
          <div class="related-brand">{{ $related->brand?->name ?? $related->brand }}</div>
          <div class="related-name">{{ $related->name }}</div>
          <div class="related-price">
            {{ number_format($related->price_per_day ?? $related->price) }}
            <small>VNĐ/ngày</small>
          </div>
        </div>
      </a>
    @endforeach
  </div>
</section>
@endif

@endsection

@push('scripts')
<script>
(function () {
  'use strict';

  /* ══════════════════════════════════════════
     1. HEADER HEIGHT → CSS var --header-h
        Đo đáy thực của mọi phần tử fixed/sticky
        rồi lấy giá trị lớn nhất (ngoại trừ detail-nav)
  ══════════════════════════════════════════ */
  function measureHeader() {
    let h = 0;
    // Quét toàn bộ các phần tử fixed/sticky, loại trừ detail-nav
    document.querySelectorAll('*').forEach(el => {
      if (el === document.getElementById('detail-nav')) return;
      if (el.closest && el.closest('#detail-nav')) return;
      const pos = getComputedStyle(el).position;
      if (pos !== 'fixed' && pos !== 'sticky') return;
      const rect = el.getBoundingClientRect();
      if (rect.top < 10 && rect.height > 10 && rect.width > 100) {
        h = Math.max(h, Math.round(rect.bottom));
      }
    });
    // Fallback 1: offsetHeight của mega-menu / header
    if (h === 0) {
      const el = document.querySelector('.mega-menu') || document.querySelector('#header') || document.querySelector('header');
      if (el) h = el.offsetHeight || 0;
    }
    // Fallback 2: nếu vẫn 0 sau khi page load → đặt giá trị mặc định hợp lý
    if (h === 0 && document.readyState === 'complete') h = 80;
    if (h > 0) document.documentElement.style.setProperty('--header-h', h + 'px');
  }

  // Chạy sớm và nhiều lần để bắt kịp header render
  measureHeader();
  [50, 150, 300, 600, 1000, 2000].forEach(t => setTimeout(measureHeader, t));
  window.addEventListener('load',   measureHeader);
  window.addEventListener('resize', () => setTimeout(measureHeader, 100));

  /* ══════════════════════════════════════════
     2. NAV – Ripple + Scroll + Highlight
  ══════════════════════════════════════════ */
  const detailNav = document.getElementById('detail-nav');

  detailNav?.querySelectorAll('a.nav-link').forEach(a => {
    a.addEventListener('click', function (e) {
      e.preventDefault();

      // Ripple
      const old = this.querySelector('.ripple');
      if (old) old.remove();
      const rect = this.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height) * 2;
      const rip  = document.createElement('span');
      rip.className = 'ripple';
      rip.style.cssText =
        `width:${size}px;height:${size}px;` +
        `left:${e.clientX - rect.left - size / 2}px;` +
        `top:${e.clientY - rect.top  - size / 2}px;`;
      this.appendChild(rip);
      setTimeout(() => rip.remove(), 700);

      // Active
      detailNav.querySelectorAll('a').forEach(l => l.classList.remove('active'));
      this.classList.add('active');

      // Scroll với offset đúng
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        const headerH = parseInt(
          getComputedStyle(document.documentElement).getPropertyValue('--header-h') || '0'
        );
        const top = target.getBoundingClientRect().top
                  + window.scrollY
                  - headerH
                  - detailNav.offsetHeight
                  - 4;
        window.scrollTo({ top, behavior: 'smooth' });
      }
    });
  });

  // Highlight theo section đang xem
  const secObs = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        detailNav?.querySelectorAll('a.nav-link').forEach(l => l.classList.remove('active'));
        const a = detailNav?.querySelector(`.nav-link[href="#${entry.target.id}"]`);
        if (a) a.classList.add('active');
      }
    });
  }, { rootMargin: '-25% 0px -65% 0px' });
  document.querySelectorAll('section[id]').forEach(s => secObs.observe(s));

  /* ══════════════════════════════════════════
     3. FEATURE SCROLL REVEAL (scroll-triggered)
  ══════════════════════════════════════════ */
  const featureSlides = Array.from(document.querySelectorAll('.feature-slide'));

  const revealObs = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('in-view');
        revealObs.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15 });

  featureSlides.forEach(slide => revealObs.observe(slide));

  /* ══════════════════════════════════════════
     4. FEATURES AUTO-SCROLL + DOT + ARROW NAV
  ══════════════════════════════════════════ */
  (function initFeatureScroll() {
    if (!featureSlides.length) return;

    const dotNav   = document.getElementById('feat-dot-nav');
    const arrowsEl = document.getElementById('feat-arrows');
    const prevBtn  = document.getElementById('feat-prev');
    const nextBtn  = document.getElementById('feat-next');
    const featSec  = document.getElementById('tinh-nang');
    const AUTO_DUR = 5000; // 4 giây mỗi slide
    const LOCK_DUR = 900;  // khóa wheel sau mỗi lần chuyển

    let current      = 0;
    let autoTimer    = null;
    let wheelLock    = false;
    const total      = featureSlides.length;

    /* ── Kiểm tra user đang nhìn vào section này chưa ── */
    function isInsideFeat() {
      if (!featSec) return false;
      const r = featSec.getBoundingClientRect();
      return r.top < window.innerHeight && r.bottom > 0;
    }

    /* ── Scroll smooth đến slide idx ── */
   function goTo(idx) {
  idx = Math.max(0, Math.min(total - 1, idx));
  current = idx;

  const slide   = featureSlides[idx];
  const headerH = parseInt(
    getComputedStyle(document.documentElement).getPropertyValue('--header-h') || '0'
  );

  const top = slide.getBoundingClientRect().top + window.scrollY - headerH - 10;

  window.scrollTo({ top, behavior: 'smooth' });

  updateDots(idx);
  updateArrows(idx);
  startProgress(idx);
  scheduleNext(idx);
}

    /* ── Dots ── */
    function updateDots(idx) {
      dotNav?.querySelectorAll('.feat-dot').forEach((d, i) => d.classList.toggle('active', i === idx));
    }

    /* ── Arrows ── */
    function updateArrows(idx) {
      if (prevBtn) prevBtn.disabled = idx === 0;
      if (nextBtn) nextBtn.disabled = idx === total - 1;
    }

    /* ── Progress bar ── */
    function startProgress(idx) {
      featureSlides.forEach((_, i) => {
        const b = document.getElementById('feat-progress-' + i);
        if (b) { b.style.transition = 'none'; b.style.width = '0%'; }
      });
      const bar = document.getElementById('feat-progress-' + idx);
      if (!bar || idx === total - 1) return;
      requestAnimationFrame(() => requestAnimationFrame(() => {
        bar.style.transition = `width ${AUTO_DUR}ms linear`;
        bar.style.width = '100%';
      }));
    }

    /* ── Lên lịch tự chuyển ── */
    function scheduleNext(idx) {
      clearTimeout(autoTimer);
      if (idx < total - 1) {
        autoTimer = setTimeout(() => {
          if (isInsideFeat()) goTo(idx + 1);
          else scheduleNext(idx); // chờ thêm nếu user đã cuộn ra ngoài
        }, AUTO_DUR);
      }
    }

    /* ── Khởi động auto khi section vào viewport ── */
    function tryStart() {
      if (!isInsideFeat()) return;
      updateDots(current);
      updateArrows(current);
      dotNav?.classList.add('visible');
      arrowsEl?.classList.add('visible');
      startProgress(current);
      scheduleNext(current);
    }

    /* ── Dừng khi rời section ── */
    function tryStop() {
      if (isInsideFeat()) return;
      clearTimeout(autoTimer);
      dotNav?.classList.remove('visible');
      arrowsEl?.classList.remove('visible');
      featureSlides.forEach((_, i) => {
        const b = document.getElementById('feat-progress-' + i);
        if (b) { b.style.transition = 'none'; b.style.width = '0%'; }
      });
    }

    /* ── Dùng scroll event để detect vào/ra section ── */
    let wasInside = false;
    window.addEventListener('scroll', () => {
      const inside = isInsideFeat();
      if (inside && !wasInside) tryStart();
      if (!inside && wasInside) tryStop();
      wasInside = inside;
    }, { passive: true });

    /* ── Dot click ── */
    dotNav?.querySelectorAll('.feat-dot').forEach(d => {
      d.addEventListener('click', () => goTo(+d.dataset.index));
    });

    /* ── Arrow click ── */
    prevBtn?.addEventListener('click', () => goTo(current - 1));
    nextBtn?.addEventListener('click', () => goTo(current + 1));

    /* ── Keyboard ── */
    document.addEventListener('keydown', e => {
      if (!isInsideFeat()) return;
      if (e.key === 'ArrowDown' || e.key === 'ArrowRight') { e.preventDefault(); goTo(current + 1); }
      if (e.key === 'ArrowUp'   || e.key === 'ArrowLeft')  { e.preventDefault(); goTo(current - 1); }
    });

    /* ── Scroll wheel hijack ── */
    let wheelAccum = 0;
    window.addEventListener('wheel', e => {
      if (!isInsideFeat()) return;
      if (current === 0 && e.deltaY < 0) return;
      if (current === total - 1 && e.deltaY > 0) return;
       e.preventDefault();
      if (wheelLock) return;
      wheelAccum += e.deltaY;
      if (Math.abs(wheelAccum) < 50) return;
      wheelLock  = true;
      wheelAccum = 0;
      goTo(current + (e.deltaY > 0 ? 1 : -1));
      setTimeout(() => { wheelLock = false; }, LOCK_DUR);
    }, { passive: false });

    /* ── Touch swipe ── */
    let touchStartY = 0;
    window.addEventListener('touchstart', e => { touchStartY = e.touches[0].clientY; }, { passive: true });
    window.addEventListener('touchend', e => {
      if (!isInsideFeat()) return;
      const dy = touchStartY - e.changedTouches[0].clientY;
      if (Math.abs(dy) < 40) return;
      goTo(current + (dy > 0 ? 1 : -1));
    }, { passive: true });

    /* ── Sync dot khi scroll tay ── */
    const slideObs = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const idx = +entry.target.dataset.index;
          if (idx !== current) { current = idx; updateDots(idx); updateArrows(idx); }
        }
      });
    }, { rootMargin: '-40% 0px -40% 0px' });
    featureSlides.forEach(s => slideObs.observe(s));

    // Init
    updateDots(0);
    updateArrows(0);
    // Nếu page load thẳng vào section này
    setTimeout(() => { if (isInsideFeat()) tryStart(); }, 500);
  })();

  /* ══════════════════════════════════════════
     5. UI helpers
  ══════════════════════════════════════════ */
  window.selectVariant = function (btn) {
    document.querySelectorAll('#variant-tabs .variant-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const price = parseInt(btn.dataset.price);
    if (price) document.getElementById('price-display').innerHTML =
      new Intl.NumberFormat('vi-VN').format(price) + ' <span>VNĐ</span>';
  };

  window.selectColor = function (el) {
    document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
    el.classList.add('active');
    const previewImg = document.getElementById('color-preview-img');
    if (previewImg && el.dataset.image) {
      previewImg.style.opacity = '0';
      setTimeout(() => { previewImg.src = el.dataset.image; previewImg.style.opacity = '1'; }, 280);
    }
    const b = document.getElementById('color-preview-badge');
    const l = document.getElementById('color-selected-label');
    if (b) b.textContent = el.dataset.name;
    if (l) l.textContent = el.dataset.name;
  };

  window.selectSpecVariant = function (btn) {
    document.querySelectorAll('.specs-variant-tabs .variant-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
  };

  window.selectThumb = function (thumb, src) {
    document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');
    const m = document.getElementById('gallery-main-img');
    if (m) { m.style.opacity = '0'; setTimeout(() => { m.src = src; m.style.opacity = '1'; }, 200); }
  };

  window.switchGalleryTab = function (type, btn) {
    document.querySelectorAll('.gallery-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
  };

  /* ══════════════════════════════════════════
     6. MODAL
  ══════════════════════════════════════════ */
  const HIDE_SELS = ['#header', '#detail-nav', '.mega-menu'];

  window.openFeatureModal = function (slide) {
    document.getElementById('modal-title').textContent = slide.dataset.title;
    document.getElementById('modal-desc').textContent  = slide.dataset.desc;
    document.getElementById('modal-badge').textContent = slide.dataset.badge;

    const imgsEl = document.getElementById('modal-imgs');
    imgsEl.innerHTML = '';
    if (slide.dataset.img) {
      [slide.dataset.img, slide.dataset.img, slide.dataset.img, slide.dataset.img].forEach(src => {
        const img = document.createElement('img');
        img.src = src; img.alt = slide.dataset.title;
        imgsEl.appendChild(img);
      });
    }

    HIDE_SELS.forEach(s => document.querySelectorAll(s).forEach(el => {
      el.dataset.prev = el.style.display || '';
      el.style.setProperty('display', 'none', 'important');
    }));

    const bd = document.getElementById('feature-modal-backdrop');
    bd.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    requestAnimationFrame(() => bd.classList.add('visible'));
  };

  window.closeFeatureModal = function () {
    const bd = document.getElementById('feature-modal-backdrop');
    bd.classList.remove('visible');
    setTimeout(() => {
      bd.style.display = 'none';
      document.body.style.overflow = '';
      HIDE_SELS.forEach(s => document.querySelectorAll(s).forEach(el => {
        el.style.display = el.dataset.prev ?? '';
        delete el.dataset.prev;
      }));
    }, 300);
  };

  document.getElementById('feature-modal-backdrop')?.addEventListener('click', function (e) {
    if (e.target === this) window.closeFeatureModal();
  });
  document.addEventListener('keydown', e => { if (e.key === 'Escape') window.closeFeatureModal(); });

})();
</script>
@endpush