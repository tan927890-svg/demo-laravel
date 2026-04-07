@extends('layouts.frontend')

@section('title', $car->name . ' - AUTO X')

@push('styles')
<style>
/* ── DETAIL NAV ── */
.detail-nav {
  position: sticky;
  top: 0;
  z-index: 9999;
  background: #fff;
  border-top: 3px solid #C9A84C;
  border-bottom: 1px solid #e5e5e5;
  box-shadow: 0 2px 12px rgba(0,0,0,0.10);
  display: flex;
  align-items: stretch;
  justify-content: center;
  overflow-x: auto;
  scrollbar-width: none;
  padding: 0;
  height: 76px;
  pointer-events: all;
}
.detail-nav::-webkit-scrollbar { display: none; }
.detail-nav a {
  font-family: 'Barlow', sans-serif;
  font-size: 15px;
  font-weight: 500;
  color: #333;
  padding: 0 24px;
  text-decoration: none;
  white-space: nowrap;
  border-bottom: 3px solid transparent;
  position: relative;
  overflow: hidden;
  display: flex;
  align-items: center;
  transition: color .25s, border-color .25s, background .25s;
  height: 100%;
  box-sizing: border-box;
  cursor: pointer;
  pointer-events: all;
  user-select: none;
  -webkit-user-select: none;
}
.detail-nav a:hover { color: #9A6F28; border-bottom-color: rgba(201,168,76,0.4); }
.detail-nav a.active { color: #9A6F28; border-bottom-color: #C9A84C; font-weight: 600; background: rgba(201,168,76,0.06); }
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
.page-breadcrumb {
  background: #fff;
  border-bottom: 1px solid #DDD0B5;
  padding: 13px 40px;
  display: flex;
  align-items: center;
  gap: 8px;
  font-family: 'Barlow', sans-serif;
  font-size: 13px;
  color: #555;
}
.page-breadcrumb a { color: #555; text-decoration: none; transition: color .2s; }
.page-breadcrumb a:hover { color: #9A6F28; }
.page-breadcrumb span { color: #9A6F28; font-weight: 600; }

/* ── HERO ── */
.car-hero { position: relative; height: 520px; overflow: hidden; background: #0d0d0f; }
.car-hero-img { width: 100%; height: 100%; object-fit: cover; display: block; transform: scale(1.01); animation: hero-zoom 6s ease-out forwards; }
@keyframes hero-zoom { to { transform: scale(1); } }
.car-hero-overlay { position: absolute; inset: 0; background: linear-gradient(90deg,rgba(0,0,0,.75) 0%,rgba(0,0,0,.2) 60%,transparent 100%); }
.car-hero-content { position: absolute; bottom: 0; left: 0; right: 0; padding: 0 80px 60px; display: flex; align-items: flex-end; justify-content: space-between; }
.car-hero-eyebrow { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 4px; text-transform: uppercase; color: var(--red); margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
.car-hero-eyebrow::before { content: ''; width: 28px; height: 1px; background: var(--red); }
.car-hero-name { font-family: 'Barlow Condensed', sans-serif; font-size: clamp(52px,7vw,90px); font-weight: 900; color: var(--white); text-transform: uppercase; letter-spacing: -2px; line-height: .9; animation: slide-up .7s cubic-bezier(.22,1,.36,1) both; }
@keyframes slide-up { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:none} }
.car-hero-tagline { font-family: 'Barlow Condensed', sans-serif; font-size: 20px; font-weight: 500; color: rgba(255,255,255,.55); text-transform: uppercase; letter-spacing: 3px; margin-top: 8px; }
.car-hero-right { text-align: right; }
.car-hero-price-label { font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 600; letter-spacing: 3px; text-transform: uppercase; color: var(--muted); margin-bottom: 4px; }
.car-hero-price { font-family: 'Barlow Condensed', sans-serif; font-size: 42px; font-weight: 900; color: var(--red); line-height: 1; }
.car-hero-price small { font-family: 'Barlow', sans-serif; font-size: 13px; font-weight: 400; color: var(--muted); }
.car-hero-status { display: inline-flex; align-items: center; gap: 6px; margin-top: 10px; font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 5px 12px; }
.status-available   { background: rgba(34,197,94,.15);  border: 1px solid rgba(34,197,94,.4);  color: #4ade80; }
.status-rented      { background: rgba(212,43,43,.15);   border: 1px solid rgba(212,43,43,.4);   color: #f87171; }
.status-maintenance { background: rgba(234,179,8,.15);   border: 1px solid rgba(234,179,8,.4);   color: #fbbf24; }
.car-hero-placeholder { width: 100%; height: 100%; background: linear-gradient(160deg,#1c1c1e 0%,#2a1616 45%,#1c1c1e 100%); }

/* ── SECTIONS ── */
.section { padding: 72px 0; }
.section-alt { background: var(--bg2); }
.container { max-width: 1280px; margin: 0 auto; padding: 0 60px; }
.section-label { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 4px; text-transform: uppercase; color: var(--red); margin-bottom: 8px; display: flex; align-items: center; gap: 12px; }
.section-label::before { content: ''; width: 24px; height: 1px; background: var(--red); }
.section-title { font-family: 'Barlow Condensed', sans-serif; font-size: clamp(32px,4vw,52px); font-weight: 900; color: var(--white); text-transform: uppercase; letter-spacing: -1px; margin-bottom: 48px; line-height: 1; }
.section-title em { color: var(--red); font-style: normal; }

/* ── GIA & MAU SAC ── */
.price-color-section { background: #f5f4f0; padding: 72px 0; }
.price-color-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
.pcs-left .section-label { color: #c00; }
.pcs-left .section-label::before { background: #c00; }
.pcs-left .section-title { color: #111; margin-bottom: 32px; }
.pcs-left .section-title em { color: #c00; }
.variant-tabs { 
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* 3 ô mỗi dòng */
  gap: 8px;
  margin-bottom: 32px;
  max-height: 120px; /* chỉ 2 dòng */
  overflow: hidden;
}
.variant-tab { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 9px 20px; background: #e8e6e0; border: 1px solid #d0cec8; color: #555; cursor: pointer; transition: all .2s; }
.variant-tab.active,.variant-tab:hover { background: #c00; border-color: #c00; color: #fff; }
.color-swatches { display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 8px; }
.color-swatch { display: flex; flex-direction: column; align-items: center; gap: 10px; cursor: pointer; }
  .swatch-circle { width: 64px; height: 64px; border-radius: 50%; border: 3px solid transparent; box-shadow: 0 6px 16px rgba(0,0,0,.12); transition: border-color .18s, transform .18s; }
.color-swatch:hover .swatch-circle { transform: scale(1.08); }
  .color-swatch.active .swatch-circle { border-color: transparent; box-shadow: none; }
  .color-swatch::after { content: ''; height: 4px; width: 44px; background: transparent; display: block; margin-top: 6px; border-radius: 4px; transition: background .18s, transform .18s; }
  .color-swatch.active::after { background: #c00; transform: translateY(0); }
  .swatch-name { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 0.5px; text-transform: none; color: #666; transition: color .18s; }
  .color-swatch.active .swatch-name { color: #c00; }
.color-selected-label { font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #c00; margin-bottom: 24px; min-height: 18px; }
  .price-display { margin-bottom: 28px; }
  .price-display-label { font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: #9a9a9a; margin-bottom: 8px; }
  .price-display-value { font-family: 'Barlow Condensed', sans-serif; font-size: 72px; font-weight: 900; color: #6b6b6b; line-height: 1; }
  .price-display-value span { font-size: 18px; font-family: 'Barlow', sans-serif; color: #9a9a9a; margin-left: 8px; vertical-align: top; }
.cta-row { display: flex; gap: 12px; flex-wrap: wrap; }

.btn-primary {
  font-family: 'Rajdhani', sans-serif;
  font-size: 12px; font-weight: 700;
  letter-spacing: 3px; text-transform: uppercase;
  background: #cc0000; color: #fff;
  border: 2px solid #cc0000;
  padding: 14px 32px;
  cursor: pointer; text-decoration: none;
  display: inline-flex; align-items: center; gap: 8px;
  transition: background .2s, border-color .2s, transform .15s;
}
.btn-primary:hover { background: #a00000; border-color: #a00000; transform: translateY(-1px); }

.btn-outline {
  font-family: 'Rajdhani', sans-serif;
  font-size: 12px; font-weight: 700;
  letter-spacing: 3px; text-transform: uppercase;
  background: transparent; color: #111;
  border: 2px solid #111;
  padding: 14px 32px;
  cursor: pointer; text-decoration: none;
  display: inline-flex; align-items: center; gap: 8px;
  transition: border-color .2s, color .2s, transform .15s;
}

.btn-outline-alt {
  font-family: 'Rajdhani', sans-serif;
  font-size: 12px; font-weight: 700;
  letter-spacing: 3px; text-transform: uppercase;
  background: #fff; color: #c00;
  border: 2px solid #c00;
  padding: 14px 32px;
  cursor: pointer; text-decoration: none;
  display: inline-flex; align-items: center; gap: 8px;
  transition: background .15s, color .15s, transform .12s;
}
.btn-outline-alt:hover { background: #c00; color: #fff; transform: translateY(-2px); }

.btn-outline-alt.secondary { border-color: #c00; color: #c00; }
.btn-outline:hover { border-color: #c00; color: #c00; transform: translateY(-1px); }

.color-preview { position: relative; display: flex; align-items: center; justify-content: center; min-height: 400px; }
.color-preview-watermark { position: absolute; top: 10px; right: 0; font-family: 'Barlow Condensed', sans-serif; font-size: clamp(52px,8vw,100px); font-weight: 900; text-transform: uppercase; letter-spacing: -3px; color: rgba(0,0,0,.05); line-height: 1; pointer-events: none; user-select: none; white-space: nowrap; }
.color-preview-img { width: 100%; max-height: 400px; object-fit: contain; display: block; transition: opacity .35s ease; filter: drop-shadow(0 20px 56px rgba(0,0,0,.2)); position: relative; z-index: 1; }
.color-preview-badge { position: absolute; bottom: 0; right: 0; z-index: 2; font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #555; background: #e8e6e0; border: 1px solid #d0cec8; padding: 6px 14px; }
.color-preview-placeholder { width: 100%; min-height: 320px; display: flex; align-items: center; justify-content: center; background: #e8e6e0; }

/* ── TINH NANG ── */
.features-section { background: #0d0d0f; position: relative; }
.features-snap-wrap { position: relative; }

.feature-slide {
  display: grid;
  grid-template-columns: 55% 45%;
  min-height: 520px;
  position: relative;
  opacity: 0;
  transform: translateY(40px);
  transition: opacity .75s cubic-bezier(.22,1,.36,1), transform .75s cubic-bezier(.22,1,.36,1);
  align-items: stretch;
}
.feature-slide.in-view { opacity: 1; transform: none; }
.feature-slide.reverse { grid-template-columns: 45% 55%; }

.feature-slide-imgs {
  position: relative;
  overflow: hidden;
  background: #111;
}
.feature-slide-imgs .img-slot {
  position: absolute; inset: 0;
}
.feature-slide-imgs .img-slot img {
  width: 100%; height: 100%;
  object-fit: cover; display: block;
  transition: transform 0.7s ease;
}
.feature-slide.in-view .feature-slide-imgs .img-slot img { transform: scale(1.04); }
.feature-slide-imgs::after {
  content: ''; position: absolute; inset: 0;
  background: linear-gradient(90deg, transparent 70%, rgba(13,13,15,.7) 100%);
  pointer-events: none; z-index: 2;
}
.feature-slide.reverse .feature-slide-imgs::after {
  background: linear-gradient(270deg, transparent 70%, rgba(13,13,15,.7) 100%);
}

.img-slot-no-img {
  position: absolute; inset: 0;
  background: linear-gradient(135deg, #1a1a1f 0%, #2a1818 50%, #111 100%);
  display: flex; align-items: center; justify-content: center;
  flex-direction: column; gap: 16px;
}
.img-slot-no-img-icon {
  width: 64px; height: 64px; opacity: .12;
}
.img-slot-no-img-text {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 13px; font-weight: 700;
  letter-spacing: 4px; text-transform: uppercase;
  color: rgba(255,255,255,.15);
}

.feature-slide-body {
  display: flex; flex-direction: column; justify-content: center;
  padding: 72px; background: #111;
  position: relative; overflow: hidden;
}
.feature-slide.reverse .feature-slide-imgs { order: 2; }
.feature-slide.reverse .feature-slide-body { order: 1; background: #0d0d0f; }
.feature-slide-body::before {
  content: ''; position: absolute;
  left: 0; top: 72px; bottom: 72px; width: 3px;
  background: linear-gradient(to bottom, transparent, var(--red) 30%, var(--red) 70%, transparent);
  opacity: 0; transition: opacity .5s .4s;
}
.feature-slide.in-view .feature-slide-body::before { opacity: 1; }
.feature-slide.reverse .feature-slide-body::before { left: auto; right: 0; }
.feature-slide-number {
  font-family: 'Barlow Condensed', sans-serif; font-size: 120px; font-weight: 900;
  color: rgba(255,255,255,.03); line-height: 1;
  position: absolute; top: 24px; right: 40px;
  letter-spacing: -6px; user-select: none; pointer-events: none;
}
.feature-slide.reverse .feature-slide-number { right: auto; left: 40px; }
.feature-slide-badge {
  font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700;
  letter-spacing: 4px; text-transform: uppercase; color: var(--red); margin-bottom: 16px;
  display: flex; align-items: center; gap: 10px;
  opacity: 0; transform: translateX(-16px); transition: opacity .5s .2s, transform .5s .2s;
}
.feature-slide.in-view .feature-slide-badge { opacity: 1; transform: none; }
.feature-slide-badge::before { content:''; width:20px; height:1px; background:var(--red); flex-shrink:0; }
.feature-slide-variant {
  font-family: 'Barlow', sans-serif; font-size: 12px; color: rgba(255,255,255,.38);
  margin-bottom: 12px; letter-spacing: 2px; text-transform: uppercase;
  opacity: 0; transform: translateX(-16px); transition: opacity .5s .3s, transform .5s .3s;
}
.feature-slide.in-view .feature-slide-variant { opacity: 1; transform: none; }
.feature-slide-title {
  font-family: 'Barlow Condensed', sans-serif; font-size: clamp(32px, 3.5vw, 56px);
  font-weight: 900; color: #fff; text-transform: uppercase;
  letter-spacing: -1px; line-height: .92; font-style: italic; margin-bottom: 24px;
  opacity: 0; transform: translateY(24px); transition: opacity .6s .25s, transform .6s .25s;
}
.feature-slide.in-view .feature-slide-title { opacity: 1; transform: none; }
.feature-slide-desc {
  font-size: 15px; color: rgba(255,255,255,.58);
  line-height: 1.9; margin-bottom: 40px; max-width: 460px;
  opacity: 0; transform: translateY(16px); transition: opacity .6s .35s, transform .6s .35s;
}
.feature-slide.in-view .feature-slide-desc { opacity: 1; transform: none; }
.btn-feature-detail {
  font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700;
  letter-spacing: 3px; text-transform: uppercase;
  background: transparent; color: #fff; border: 1px solid rgba(255,255,255,.35);
  padding: 14px 32px; cursor: pointer; text-decoration: none;
  display: inline-flex; align-items: center; gap: 10px; align-self: flex-start;
  position: relative; overflow: hidden;
  opacity: 0; transform: translateY(12px); transition: opacity .5s .45s, transform .5s .45s, border-color .25s;
}
.feature-slide.in-view .btn-feature-detail { opacity: 1; transform: none; }
.btn-feature-detail::after {
  content: ''; position: absolute; inset: 0;
  background: var(--red); transform: scaleX(0); transform-origin: left;
  transition: transform .3s cubic-bezier(.22,1,.36,1); z-index: 0;
}
.btn-feature-detail span { position: relative; z-index: 1; }
.btn-feature-detail:hover { border-color: var(--red); color: #fff; }
.btn-feature-detail:hover::after { transform: scaleX(1); }
.feature-divider {
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,.08) 20%, rgba(255,255,255,.08) 80%, transparent);
}

/* ── MODAL ── */
.feature-modal-backdrop {
  position: fixed; inset: 0; z-index: 99999;
  background: rgba(0,0,0,.97); display: none; flex-direction: column;
  opacity: 0; transition: opacity .3s; overflow-y: auto;
}
.feature-modal-backdrop.visible { opacity: 1; }
.feature-modal {
  min-height: 100vh; display: flex; flex-direction: column;
  background: #0d0d0f; max-width: 1100px; margin: 0 auto; width: 100%;
  padding-bottom: 80px;
}
.feature-modal-header {
  padding: 28px 40px 0; display: flex; align-items: center; justify-content: flex-end;
}
.feature-modal-close {
  width: 48px; height: 48px; background: #c00; border: none; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  font-size: 20px; color: #fff; transition: background .2s; flex-shrink: 0;
}
.feature-modal-close:hover { background: #a00; }
.feature-modal-section-label {
  font-family: 'Barlow Condensed', sans-serif; font-size: clamp(32px, 5vw, 56px);
  font-weight: 900; color: #fff; text-transform: uppercase;
  letter-spacing: -1px; font-style: italic; text-align: center;
  padding: 36px 48px 0; line-height: 1;
}
.feature-modal-tab-row { display: flex; justify-content: center; padding: 20px 48px 0; }
.feature-modal-tab {
  font-family: 'Barlow Condensed', sans-serif; font-size: 20px; font-weight: 700;
  color: #fff; text-transform: uppercase; letter-spacing: 1px;
  padding-bottom: 10px; border-bottom: 3px solid #c00; display: inline-block;
}
.modal-slider { position: relative; width: 100%; background: #000; margin-top: 28px; }
.modal-slider-track-wrap { overflow: hidden; width: 100%; }
.modal-slider-track { display: flex; transition: transform .45s cubic-bezier(.22,1,.36,1); }
.modal-slider-track .modal-slide {
  flex: 0 0 100%; width: 100%; background: #000;
  display: flex; align-items: center; justify-content: center;
}
.modal-slider-track .modal-slide img { width: 100%; max-height: 560px; object-fit: cover; display: block; }
.modal-slider-btn {
  position: absolute; top: 50%; transform: translateY(-50%);
  width: 52px; height: 52px; background: rgba(0,0,0,.55); border: 1px solid rgba(255,255,255,.18);
  color: #fff; font-size: 28px; cursor: pointer;
  display: flex; align-items: center; justify-content: center; z-index: 10;
  transition: background .2s, border-color .2s;
}
.modal-slider-btn:hover { background: #c00; border-color: #c00; }
.modal-slider-btn.prev { left: 16px; }
.modal-slider-btn.next { right: 16px; }
.modal-slider-dots { display: flex; justify-content: center; gap: 10px; padding: 16px 0 0; }
.modal-slider-dots .dot { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,.25); cursor: pointer; transition: background .2s, transform .2s; }
.modal-slider-dots .dot.active { background: #c00; transform: scale(1.35); }
.modal-slider.single .modal-slider-btn,
.modal-slider.single .modal-slider-dots { display: none; }
.feature-modal-desc { padding: 32px 80px 0; }
.feature-modal-text { font-family: 'Barlow', sans-serif; font-size: 16px; color: rgba(255,255,255,.72); line-height: 1.9; max-width: 860px; }

/* ── THONG SO ── */
.specs-variant-tabs { display: flex; gap: 2px; margin-bottom: 32px; flex-wrap: wrap; }
.spec-table { width: 100%; border-collapse: collapse; margin-bottom: 32px; }
.spec-table-category { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--white); background: rgba(212,43,43,.15); border-left: 3px solid var(--red); padding: 12px 20px; text-align: left; }
.spec-table td { padding: 12px 20px; border-bottom: 1px solid var(--border); font-size: 14px; vertical-align: top; }
.spec-table tr:last-child td { border-bottom: none; }
.spec-key { color: var(--muted); width: 45%; }
.spec-val { color: var(--white); font-weight: 500; }
.spec-table tr:hover td { background: rgba(255,255,255,.025); }

/* ── THU VIEN ── */
.gallery-tabs { display: flex; gap: 24px; margin-bottom: 28px; border-bottom: 1px solid var(--border); }
.gallery-tab { font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--muted); padding: 0 0 14px; cursor: pointer; border-bottom: 2px solid transparent; transition: color .2s,border-color .2s; background: none; border-top: none; border-left: none; border-right: none; }
.gallery-tab.active { color: var(--red); border-bottom-color: var(--red); }
.gallery-main { margin-bottom: 8px; background: var(--bg3); overflow: hidden; }
.gallery-main-img { width: 100%; max-height: 520px; object-fit: cover; display: block; transition: opacity .3s; }
.gallery-thumbs { display: flex; gap: 6px; overflow-x: auto; scrollbar-width: none; }
.gallery-thumbs::-webkit-scrollbar { display: none; }
.gallery-thumb { flex-shrink: 0; width: 100px; height: 68px; overflow: hidden; cursor: pointer; border: 2px solid transparent; transition: border-color .2s; }
.gallery-thumb.active { border-color: var(--red); }
.gallery-thumb img { width: 100%; height: 100%; object-fit: cover; }

/* ── RELATED ── */
.related-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 2px; background: var(--border); }
.related-card { background: var(--card); overflow: hidden; position: relative; transition: background .3s; text-decoration: none; display: block; }
.related-card:hover { background: var(--bg3); }
.related-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: var(--red); transform: scaleX(0); transform-origin: left; transition: transform .35s; z-index: 2; }
.related-card:hover::before { transform: scaleX(1); }
.related-img { width: 100%; height: 160px; object-fit: cover; display: block; }
.related-body { padding: 16px; }
.related-brand { font-family: 'Rajdhani', sans-serif; font-size: 9px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--red); margin-bottom: 4px; }
.related-name { font-family: 'Barlow Condensed', sans-serif; font-size: 18px; font-weight: 700; color: var(--white); text-transform: uppercase; margin-bottom: 8px; }
.related-price { font-family: 'Barlow Condensed', sans-serif; font-size: 20px; font-weight: 800; color: var(--red); }
.related-price small { font-size: 11px; color: var(--muted); font-family: 'Barlow', sans-serif; }

/* ── CTA ── */
.info-cta { background: var(--bg3); padding: 80px 60px; text-align: center; }
.info-cta-title { font-family: 'Barlow Condensed', sans-serif; font-size: 36px; font-weight: 900; color: var(--white); text-transform: uppercase; letter-spacing: -1px; margin-bottom: 28px; }
.info-cta-btns { display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }
.info-cta-btn { font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; border: 1px solid var(--white); color: var(--white); padding: 16px 40px; min-width: 280px; cursor: pointer; background: transparent; transition: background .2s,color .2s; text-decoration: none; display: inline-block; text-align: center; }
.info-cta-btn:hover { background: var(--white); color: #111; }

/* ── RESPONSIVE ── */
@media(max-width:1024px) {
  .price-color-layout { grid-template-columns: 1fr; gap: 40px; }
  .feature-slide, .feature-slide.reverse { grid-template-columns: 1fr !important; min-height: auto; }
  .feature-slide.reverse .feature-slide-imgs { order: 0; }
  .feature-slide.reverse .feature-slide-body { order: 1; }
  .feature-slide-imgs { min-height: 280px; }
  .feature-slide-body { padding: 48px 40px; }
  .feature-modal-header { padding: 20px 20px 0; }
  .feature-modal-section-label { padding: 28px 20px 0; font-size: 28px; }
  .feature-modal-tab-row { padding: 16px 20px 0; }
  .feature-modal-desc { padding: 24px 20px 0; }
  .modal-slider-track .modal-slide img { max-height: 360px; }
  .related-grid { grid-template-columns: repeat(2,1fr); }
  .car-hero-content { padding: 0 40px 40px; flex-direction: column; align-items: flex-start; gap: 20px; }
}
@media(max-width:768px) {
  .container { padding: 0 20px; }
  .page-breadcrumb { padding: 14px 20px; }
  .car-hero { height: 380px; }
  .related-grid { grid-template-columns: 1fr; }
  .info-cta { padding: 60px 20px; }
  .info-cta-btn { min-width: unset; width: 100%; }
  .feature-slide-body { padding: 36px 24px; }
  .feature-slide-imgs { min-height: 220px; }
  .modal-slider-track .modal-slide img { max-height: 240px; }
  .detail-nav a { padding: 0 16px; font-size: 13px; }
  .feature-modal-desc { padding: 20px 20px 0; }
}
</style>
@endpush

@section('content')

@php
/**
 * FIX: Hàm carImgPath được viết lại để xử lý đúng đường dẫn ảnh.
 *
 * Vấn đề cũ: rawurlencode() encode cả dấu '/' thành '%2F' khiến URL bị sai.
 * Fix: Tách từng segment của path, encode riêng từng segment, rồi ghép lại bằng '/'.
 * Ngoài ra loại bỏ leading slash thừa trước khi gọi asset().
 */
function carImgPath($val) {
    if (!$val) return null;

    $val = trim($val);
    if ($val === '') return null;

    // Nếu đã là URL đầy đủ (http/https) thì trả về luôn
    if (preg_match('#^https?://#i', $val)) {
        return $val;
    }

    // Bỏ leading slash để tránh double-slash với asset()
    $val = ltrim($val, '/');

    // Tách theo '/', encode từng segment (chỉ encode tên file/folder, không encode '/')
    $segments = explode('/', $val);
    $encoded  = array_map(function ($seg) {
        // rawurlencode encode dấu cách, ký tự đặc biệt, ký tự Unicode
        // Không encode các ký tự an toàn thêm để tránh double-encode
        return rawurlencode(rawurldecode($seg));
    }, $segments);

    return asset(implode('/', $encoded));
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
  <a href="#gia-mau-sac" class="nav-link">Giá & Màu sắc</a>
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
    // FIX: Thử lần lượt hero_image -> image_url -> image, lấy cái đầu tiên có giá trị
    $heroSrc = null;
    foreach (['hero_image', 'image_url', 'image'] as $_field) {
        $heroSrc = carImgPath($car->$_field ?? null);
        if ($heroSrc) break;
    }
  @endphp
  @if($heroSrc)
    <img class="car-hero-img"
         src="{{ $heroSrc }}"
         alt="{{ $car->name }}"
         onerror="this.style.display='none';this.nextElementSibling.style.display='none';this.closest('.car-hero').querySelector('.car-hero-placeholder').style.display='block';">
    <div class="car-hero-overlay"></div>
  @else
    <div class="car-hero-placeholder"></div>
  @endif
  {{-- Placeholder ẩn, hiện khi ảnh lỗi --}}
  <div class="car-hero-placeholder" style="display:none;position:absolute;inset:0;"></div>
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
          'available'   => ['class' => 'status-available',   'label' => 'Còn xe'],
          'rented'      => ['class' => 'status-rented',       'label' => 'Đang thuê'],
          'maintenance' => ['class' => 'status-maintenance',  'label' => 'Bảo dưỡng'],
        ];
        $st = $statusMap[$car->status ?? 'available'] ?? $statusMap['available'];
      @endphp
      <div class="car-hero-status {{ $st['class'] }}">● {{ $st['label'] }}</div>
    </div>
  </div>
</section>

{{-- GIA & MAU SAC --}}
<section class="price-color-section" id="gia-mau-sac">
  <div class="container">
    <div class="price-color-layout">
      <div class="pcs-left">
        <div class="section-label">Bộ sưu tập</div>
        <div class="section-title">Giá & <em>Màu sắc</em></div>

              @if($car->variants->count())
        @php
          // Lọc trùng theo tên + giới hạn 6 cái (2 dòng)
          $uniqueVariants = $car->variants->unique('name')->take(6);
        @endphp

        <div class="variant-tabs" id="variant-tabs">
          @foreach($uniqueVariants as $variant)
            <button class="variant-tab {{ $loop->first ? 'active' : '' }}"
                    data-price="{{ $variant->price }}"
                    onclick="selectVariant(this)">
              {{ $variant->name }}
            </button>
          @endforeach
        </div>
        @endif

        @if($car->colors->count())
        <div class="color-swatches">
          @foreach($car->colors as $color)
            @php
              // FIX: Encode đúng đường dẫn ảnh màu
              $colorImgUrl = carImgPath($color->image ?? null);
            @endphp
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
          <a href="{{ route('cars.costEstimate', $car) }}" class="btn-outline-alt">DỰ TOÁN CHI PHÍ →</a>
          <a href="{{ url('/contact') }}" class="btn-outline-alt secondary">ĐĂNG KÝ LÁI THỬ →</a>
        </div>
      </div>

      {{-- FIX: Preview ảnh màu xe --}}
      <div class="color-preview">
        <div class="color-preview-watermark">{{ $car->name }}</div>
        @php
          // FIX: Ưu tiên ảnh màu mặc định -> màu đầu tiên -> ảnh xe
          $defaultColor   = $car->colors->firstWhere('is_default', true) ?? $car->colors->first();
          $firstColorImg  = carImgPath($defaultColor?->image ?? null);

          // Fallback sang ảnh xe nếu màu không có ảnh
          if (!$firstColorImg) {
              foreach (['image_url', 'image', 'hero_image'] as $_f) {
                  $firstColorImg = carImgPath($car->$_f ?? null);
                  if ($firstColorImg) break;
              }
          }

          $previewColorName = $defaultColor?->name ?? $car->name;
        @endphp
        @if($firstColorImg)
          <img class="color-preview-img"
               id="color-preview-img"
               src="{{ $firstColorImg }}"
               alt="{{ $car->name }}"
               onerror="this.style.display='none';document.getElementById('color-preview-fallback').style.display='flex';">
        @endif
        {{-- Fallback placeholder --}}
        <div class="color-preview-placeholder" id="color-preview-fallback"
             style="{{ $firstColorImg ? 'display:none;' : '' }}">
          <span style="font-family:'Barlow Condensed',sans-serif;font-size:14px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:rgba(0,0,0,.2);">{{ $car->name }}</span>
        </div>
        <div class="color-preview-badge" id="color-preview-badge">
          {{ $previewColorName }}
        </div>
      </div>
    </div>
  </div>
</section>

{{-- TINH NANG NOI BAT --}}
@if($car->features->count())
<section class="features-section" id="tinh-nang">
  <div class="features-snap-wrap" id="features-snap-wrap">
   @foreach($car->features->unique('id') as $feature)
      @php
        // FIX: Encode đúng đường dẫn ảnh tính năng
        $featImg1 = null;
        foreach (['image', 'image_url'] as $_f) {
            $featImg1 = carImgPath($feature->$_f ?? null);
            if ($featImg1) break;
        }

        $featImg2 = null;
        foreach (['image2', 'image2_url'] as $_f) {
            $featImg2 = carImgPath($feature->$_f ?? null);
            if ($featImg2) break;
        }

        $isReverse   = $loop->index % 2 === 1;
        $badgeText   = 'TINH NANG NOI BAT';
        $variantText = $feature->variant?->name ? 'Phien ban ' . $feature->variant->name : '';
        $num         = str_pad($loop->iteration, 2, '0', STR_PAD_LEFT);
      @endphp

      @if(!$loop->first)<div class="feature-divider"></div>@endif

      <div class="feature-slide {{ $isReverse ? 'reverse' : '' }}"
           data-title="{{ $feature->title }}"
           data-desc="{{ $feature->description }}"
           data-badge="{{ $badgeText }}"
           data-variant="{{ $variantText }}"
           data-img="{{ $featImg1 ?? '' }}"
           data-img2="{{ $featImg2 ?? '' }}">

        {{-- VUNG ANH --}}
        <div class="feature-slide-imgs">
          <div class="img-slot">
            @if($featImg1)
              <img src="{{ $featImg1 }}"
                   alt="{{ $feature->title }}"
                   loading="lazy"
                   onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
              <div class="img-slot-no-img" style="display:none;">
                <svg class="img-slot-no-img-icon" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1">
                  <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/>
                  <polyline points="21 15 16 10 5 21"/>
                </svg>
                <span class="img-slot-no-img-text">{{ $car->name }}</span>
              </div>
            @else
              <div class="img-slot-no-img">
                <svg class="img-slot-no-img-icon" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1">
                  <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/>
                  <polyline points="21 15 16 10 5 21"/>
                </svg>
                <span class="img-slot-no-img-text">{{ $car->name }}</span>
              </div>
            @endif
          </div>
        </div>

        {{-- VUNG TEXT --}}
        <div class="feature-slide-body">
          <div class="feature-slide-number">{{ $num }}</div>
          <div class="feature-slide-badge">{{ $badgeText }}</div>
          @if($variantText)<div class="feature-slide-variant">{{ $variantText }}</div>@endif
          <div class="feature-slide-title">{{ $feature->title }}</div>
          <div class="feature-slide-desc">{{ $feature->description }}</div>
          <button class="btn-feature-detail"
                  onclick="openFeatureModal(this.closest('.feature-slide'))">
            <span>XEM CHI TIET →</span>
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
      <button class="feature-modal-close" onclick="closeFeatureModal()">✕</button>
    </div>
    <div class="feature-modal-section-label" id="modal-badge"></div>
    <div class="feature-modal-tab-row">
      <span class="feature-modal-tab" id="modal-title"></span>
    </div>
    <div class="modal-slider" id="modal-slider">
      <button class="modal-slider-btn prev" onclick="sliderMove(-1)">&#8249;</button>
      <div class="modal-slider-track-wrap">
        <div class="modal-slider-track" id="modal-slider-track"></div>
      </div>
      <button class="modal-slider-btn next" onclick="sliderMove(1)">&#8250;</button>
      <div class="modal-slider-dots" id="modal-slider-dots"></div>
    </div>
    <div class="feature-modal-desc">
      <div class="feature-modal-text" id="modal-desc"></div>
    </div>
  </div>
</div>
@endif

{{-- THONG SO KY THUAT --}}
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

{{-- THU VIEN ANH --}}
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
      @php
        // FIX: Encode đúng đường dẫn ảnh gallery
        $firstImg    = $imageGalleries->first();
        $firstImgSrc = carImgPath($firstImg?->file_path ?? null);
      @endphp
      @if($firstImg && $firstImgSrc)
        <img class="gallery-main-img"
             id="gallery-main-img"
             src="{{ $firstImgSrc }}"
             alt="{{ $car->name }}"
             onerror="this.style.background='#222';this.removeAttribute('src');">
      @endif
    </div>
    <div class="gallery-thumbs">
      @foreach($imageGalleries as $img)
        @php $imgUrl = carImgPath($img->file_path ?? null); @endphp
        @if($imgUrl)
        <div class="gallery-thumb {{ $loop->first ? 'active' : '' }}"
             onclick="selectThumb(this, '{{ $imgUrl }}')">
          <img src="{{ $imgUrl }}"
               alt=""
               onerror="this.closest('.gallery-thumb').style.display='none';">
        </div>
        @endif
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- THONG TIN CHI TIET --}}
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

{{-- XE LIEN QUAN --}}
@if($relatedCars->count())
<section class="section section-alt" id="so-sanh">
  <div class="container">
    <div class="section-label">Cùng hãng</div>
    <div class="section-title">Xe <em>Liên Quan</em></div>
  </div>
  <div class="related-grid">
    @foreach($relatedCars as $related)
      @php
        // FIX: Encode đúng ảnh xe liên quan
        $relImg = null;
        foreach (['image_url', 'image', 'hero_image'] as $_f) {
            $relImg = carImgPath($related->$_f ?? null);
            if ($relImg) break;
        }
      @endphp
      <a href="{{ route('cars.show', $related->id) }}" class="related-card">
        @if($relImg)
          <img class="related-img"
               src="{{ $relImg }}"
               alt="{{ $related->name }}"
               onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
          <div style="height:160px;background:var(--bg3);display:none;align-items:center;justify-content:center;">
            <span style="font-family:'Barlow Condensed',sans-serif;font-size:13px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.15);">{{ $related->name }}</span>
          </div>
        @else
          <div style="height:160px;background:var(--bg3);display:flex;align-items:center;justify-content:center;">
            <span style="font-family:'Barlow Condensed',sans-serif;font-size:13px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.15);">{{ $related->name }}</span>
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

  /* 1. Sticky nav */
  const detailNav = document.getElementById('detail-nav');
  const navLinks  = Array.from(detailNav?.querySelectorAll('a.nav-link') || []);

  function getHeaderHeight() {
    let h = 0;
    document.querySelectorAll('header, #header, .site-header, .navbar, .main-header').forEach(el => {
      if (el === detailNav || el.contains(detailNav)) return;
      const rect = el.getBoundingClientRect();
      if (rect.top <= 1 && rect.height > 10) h = Math.max(h, Math.round(rect.bottom));
    });
    return h;
  }

  function applyNavTop() {
    if (!detailNav) return;
    const h = getHeaderHeight();
    detailNav.style.top = (h > 0 ? h : 0) + 'px';
  }
  applyNavTop();
  [100, 300, 600, 1000, 2000].forEach(t => setTimeout(applyNavTop, t));
  window.addEventListener('resize', applyNavTop);
  window.addEventListener('load', applyNavTop);

  /* 2. Nav click */
  navLinks.forEach(a => {
    a.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();

      const old = this.querySelector('.ripple'); if (old) old.remove();
      const rect = this.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height) * 2;
      const rip  = document.createElement('span');
      rip.className = 'ripple';
      rip.style.cssText = `width:${size}px;height:${size}px;left:${e.clientX-rect.left-size/2}px;top:${e.clientY-rect.top-size/2}px;`;
      this.appendChild(rip);
      setTimeout(() => rip.remove(), 700);

      navLinks.forEach(l => l.classList.remove('active'));
      this.classList.add('active');

      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        const navH = detailNav ? detailNav.offsetHeight : 0;
        const top  = target.getBoundingClientRect().top + window.scrollY - parseInt(detailNav?.style.top || 0) - navH - 8;
        window.scrollTo({ top, behavior: 'smooth' });
      }
    });
  });

  /* 3. Active nav on scroll */
  function updateActiveNav() {
    const navH   = detailNav ? detailNav.offsetHeight : 0;
    const offset = parseInt(detailNav?.style.top || 0) + navH + 24;
    const sections = navLinks
      .map(a => document.getElementById(a.getAttribute('href').slice(1)))
      .filter(Boolean);
    if (!sections.length) return;
    let activeIdx = 0;
    sections.forEach((sec, i) => {
      if (window.scrollY >= sec.offsetTop - offset) activeIdx = i;
    });
    navLinks.forEach((l, i) => l.classList.toggle('active', i === activeIdx));
  }
  let navTick = false;
  window.addEventListener('scroll', () => {
    if (!navTick) { navTick = true; requestAnimationFrame(() => { updateActiveNav(); navTick = false; }); }
  }, { passive: true });
  setTimeout(updateActiveNav, 400);
  window.addEventListener('load', updateActiveNav);

  /* 4. Feature reveal */
  const revealObs = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in-view'); revealObs.unobserve(e.target); } });
  }, { threshold: 0.08 });
  document.querySelectorAll('.feature-slide').forEach(s => revealObs.observe(s));

  /* 5. UI Helpers */
  window.selectVariant = function (btn) {
    document.querySelectorAll('#variant-tabs .variant-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const price = parseInt(btn.dataset.price);
    if (price) document.getElementById('price-display').innerHTML =
      new Intl.NumberFormat('vi-VN').format(price) + ' <span>VND</span>';
  };

  window.selectColor = function (el) {
    document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
    el.classList.add('active');

    const imgEl      = document.getElementById('color-preview-img');
    const fallbackEl = document.getElementById('color-preview-fallback');

    if (el.dataset.image && el.dataset.image !== '') {
      // Có ảnh màu: hiện ảnh, ẩn fallback
      if (imgEl) {
        imgEl.style.opacity = '0';
        setTimeout(() => {
          imgEl.src = el.dataset.image;
          imgEl.style.display = 'block';
          imgEl.style.opacity = '1';
          if (fallbackEl) fallbackEl.style.display = 'none';
        }, 280);
      }
    } else {
      // Không có ảnh màu: hiện fallback
      if (imgEl) imgEl.style.display = 'none';
      if (fallbackEl) fallbackEl.style.display = 'flex';
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

  /* 6. Modal + Slider */
  let sliderIdx = 0, sliderSrcs = [];

  window.sliderMove = function (dir) {
    if (sliderSrcs.length <= 1) return;
    sliderIdx = (sliderIdx + dir + sliderSrcs.length) % sliderSrcs.length;
    updateSlider();
  };

  function updateSlider() {
    const track = document.getElementById('modal-slider-track');
    const dots  = document.getElementById('modal-slider-dots');
    if (track) track.style.transform = `translateX(-${sliderIdx * 100}%)`;
    if (dots) Array.from(dots.querySelectorAll('.dot')).forEach((d, i) =>
      d.classList.toggle('active', i === sliderIdx));
  }

  window.openFeatureModal = function (slide) {
    document.getElementById('modal-badge').textContent = slide.dataset.badge;
    document.getElementById('modal-title').textContent = slide.dataset.title;
    document.getElementById('modal-desc').textContent  = slide.dataset.desc;

    sliderSrcs = [slide.dataset.img, slide.dataset.img2].filter(Boolean);
    sliderIdx  = 0;

    const track = document.getElementById('modal-slider-track');
    track.innerHTML = '';
    track.style.transform = 'translateX(0)';
    sliderSrcs.forEach(src => {
      const wrap = document.createElement('div'); wrap.className = 'modal-slide';
      const img  = document.createElement('img');  img.src = src; img.alt = '';
      wrap.appendChild(img); track.appendChild(wrap);
    });

    const dots = document.getElementById('modal-slider-dots');
    dots.innerHTML = '';
    sliderSrcs.forEach((_, i) => {
      const dot = document.createElement('span');
      dot.className = 'dot' + (i === 0 ? ' active' : '');
      dot.onclick = () => { sliderIdx = i; updateSlider(); };
      dots.appendChild(dot);
    });

    document.getElementById('modal-slider').classList.toggle('single', sliderSrcs.length <= 1);

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
    }, 300);
  };

  document.getElementById('feature-modal-backdrop')?.addEventListener('click', function (e) {
    if (e.target === this) window.closeFeatureModal();
  });

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape')     window.closeFeatureModal();
    if (e.key === 'ArrowLeft')  window.sliderMove(-1);
    if (e.key === 'ArrowRight') window.sliderMove(1);
  });

})();
</script>
@endpush