@extends('layouts.frontend')

@section('title', $car->name . ' - AUTO X')

@section('hide_home_hero', true)

@push('styles')
<style>
/* ── STICKY WRAPPER ── */
.detail-sticky-wrap {
  position: sticky;
  top: 0;
  z-index: 100;
  background: #fff;
  box-shadow: 0 2px 12px rgba(0,0,0,0.10);
}

/* ── BREADCRUMB ── */
.page-breadcrumb {
  background: #fff;
  border-bottom: 1px solid #DDD0B5;
  padding: 8px 40px;
  display: flex; align-items: center; gap: 8px;
  font-family: 'Barlow', sans-serif; font-size: 13px; color: #555;
}
.page-breadcrumb a { color: #555; text-decoration: none; transition: color .2s; }
.page-breadcrumb a:hover { color: #9A6F28; }
.page-breadcrumb span { color: #9A6F28; font-weight: 600; }

/* ── DETAIL NAV ── */
.detail-nav {
  background: #fff;
  border-top: 3px solid #C9A84C;
  border-bottom: 1px solid #e5e5e5;
  display: flex; align-items: stretch; justify-content: center;
  overflow-x: auto; scrollbar-width: none;
  padding: 0; height: 56px; pointer-events: all;
}
.detail-nav::-webkit-scrollbar { display: none; }
.detail-nav a {
  font-family: 'Barlow', sans-serif; font-size: 16px; font-weight: 600; color: #444;
  padding: 0 20px; text-decoration: none; white-space: nowrap;
  border-bottom: 3px solid transparent; position: relative; overflow: hidden;
  display: flex; align-items: center;
  transition: color .25s, border-color .25s, background .25s;
  height: 100%; box-sizing: border-box; cursor: pointer; pointer-events: all;
  user-select: none; -webkit-user-select: none;
}
.detail-nav a:hover { color: #c00; border-bottom-color: rgba(204,0,0,.25); }
.detail-nav a.active { color: #c00 !important; border-bottom-color: #c00 !important; font-weight: 700; }
.detail-nav a .ripple {
  position: absolute; border-radius: 50%; background: rgba(204,0,0,.12);
  transform: scale(0); animation: ripple-anim 0.65s linear forwards; pointer-events: none;
}
@keyframes ripple-anim { to { transform: scale(4); opacity: 0; } }

/* ── HERO ── */
.car-hero { position: relative; height: 560px; overflow: hidden; background: #0d0d0f; }
.car-hero-img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; display: block; transform: scale(1.01); animation: hero-zoom 6s ease-out forwards; }
@keyframes hero-zoom { to { transform: scale(1); } }
.car-hero-overlay { 
  position: absolute; 
  inset: 0; 
  background: linear-gradient(
    to top,
    rgba(0,0,0,.85) 0%,
    rgba(0,0,0,.5) 30%,
    rgba(0,0,0,.1) 60%,
    transparent 100%
  ); 
}
.car-hero-content { 
  position: absolute; 
  bottom: 0; 
  left: 0; 
  right: 0; 
  padding: 0 80px 60px;  /* giữ nguyên 60px như gốc */
  display: flex; 
  align-items: flex-end; 
  justify-content: space-between; 
}
.car-hero-eyebrow { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 4px; text-transform: uppercase; color: var(--red); margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
.car-hero-eyebrow::before { content: ''; width: 28px; height: 1px; background: var(--red); }
.car-hero-name { 
  font-family: 'Barlow Condensed', sans-serif !important; 
  font-size: clamp(52px,7vw,90px) !important; 
  font-weight: 900 !important; 
  color: #fff !important; 
  text-transform: uppercase !important; 
  letter-spacing: -2px !important; 
  line-height: .9 !important; 
  animation: slide-up .7s cubic-bezier(.22,1,.36,1) both; 
}
@keyframes slide-up { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:none} }
.car-hero-tagline { font-family: 'Barlow Condensed', sans-serif; font-size: 20px; font-weight: 500; color: rgba(255,255,255,.55); text-transform: uppercase; letter-spacing: 3px; margin-top: 8px; }
.car-hero-right { text-align: right; }
.car-hero-price-label { font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 600; letter-spacing: 3px; text-transform: uppercase; color: rgba(255,255,255,.8) !important; margin-bottom: 4px; }
.car-hero-price { font-family: 'Barlow Condensed', sans-serif; font-size: 42px; font-weight: 900; color: #f6eeee !important; line-height: 1; }
.car-hero-price small { font-family: 'Barlow', sans-serif; font-size: 13px; font-weight: 400; color: rgba(255,255,255,.7) !important; }
.car-hero-status { display: inline-flex; align-items: center; gap: 6px; margin-top: 10px; font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 5px 12px; }
.status-available   { background: rgba(34,197,94,.15);  border: 1px solid rgba(34,197,94,.4);  color: #4ade80; }
.status-rented      { background: rgba(212,43,43,.15);  border: 1px solid rgba(212,43,43,.4);  color: #f87171; }
.status-maintenance { background: rgba(234,179,8,.15);  border: 1px solid rgba(234,179,8,.4);  color: #fbbf24; }
.status-out-of-stock { background: rgba(212,43,43,.15); border: 1px solid rgba(212,43,43,.4);  color: #f87171; }
.status-coming-soon  { background: rgba(234,179,8,.15); border: 1px solid rgba(234,179,8,.4);  color: #fbbf24; }
.car-hero-placeholder { position: absolute; inset: 0; background: linear-gradient(160deg,#1c1c1e 0%,#2a1616 45%,#1c1c1e 100%); }
.car-hero-name { color: #fff !important; }
.car-hero-eyebrow { color: #d42b2b !important; }

/* ── SECTIONS ── */
.section { padding: 72px 0; }
.section-alt { background: var(--bg2); }
.container { max-width: 1280px; margin: 0 auto; padding: 0 60px; }
.section-label { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 4px; text-transform: uppercase; color: var(--red); margin-bottom: 8px; display: flex; align-items: center; gap: 12px; }
.section-label::before { content: ''; width: 24px; height: 1px; background: var(--red); }
.section-title { font-family: 'Barlow Condensed', sans-serif; font-size: clamp(32px,4vw,52px); font-weight: 900; color: var(--black); text-transform: uppercase; letter-spacing: -1px; margin-bottom: 48px; line-height: 1; }
.section-title em { color: var(--red); font-style: normal; }

/* ── GIA & HANG XE ── */
.price-color-section { background: #f5f4f0; padding: 72px 0; }
.price-color-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
.pcs-left .section-label { color: #c00; }
.pcs-left .section-label::before { background: #c00; }
.car-name-display { margin-bottom: 28px; }
.car-name-display-label { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: #9a9a9a; margin-bottom: 6px; }
.car-name-display-value { font-family: 'Barlow Condensed', sans-serif; font-size: 28px; font-weight: 800; color: #111; text-transform: uppercase; letter-spacing: 1px; line-height: 1.1; }
.price-display { margin-bottom: 28px; }
.price-display-label { font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: #9a9a9a; margin-bottom: 8px; }
.price-display-value { font-family: 'Barlow Condensed', sans-serif; font-size: 72px; font-weight: 900; color: #6b6b6b; line-height: 1; }
.price-display-value span { font-size: 18px; font-family: 'Barlow', sans-serif; color: #9a9a9a; margin-left: 8px; vertical-align: top; }
.cta-row { display: flex; gap: 12px; flex-wrap: wrap; }
.btn-outline-alt { font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; background: #fff; color: #c00; border: 2px solid #c00; padding: 14px 32px; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: background .15s, color .15s, transform .12s; }
.btn-outline-alt:hover { background: #c00; color: #fff; transform: translateY(-2px); }
.btn-outline-alt.secondary { border-color: #c00; color: #c00; }

/* ── 360 VIEWER ── */
.car-360-wrap {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 400px;
  cursor: grab;
  user-select: none;
  -webkit-user-select: none;
}
.car-360-wrap:active { cursor: grabbing; }
.color-preview {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 400px;
}
.color-preview-watermark {
  position: absolute;
  top: 10px; right: 0;
  font-family: 'Barlow Condensed', sans-serif;
  font-size: clamp(52px,8vw,100px);
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: -3px;
  color: rgba(0,0,0,.05);
  line-height: 1;
  pointer-events: none;
  user-select: none;
  white-space: nowrap;
}
.car-360-img {
  width: 100%;
  max-height: 460px;
  object-fit: contain;
  display: block;
  filter: drop-shadow(0 28px 56px rgba(0,0,0,.22)) drop-shadow(0 8px 20px rgba(0,0,0,.12));
  pointer-events: none;
  position: relative;
  z-index: 1;
}
.color-preview-img {
  width: 100%;
  max-height: 460px;
  object-fit: contain;
  display: block;
  transition: opacity .4s ease;
  filter: drop-shadow(0 28px 56px rgba(0,0,0,.22)) drop-shadow(0 8px 20px rgba(0,0,0,.12));
  position: relative;
  z-index: 1;
  background: transparent;
}
.car-360-hint {
  position: absolute;
  bottom: 52px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  align-items: center;
  gap: 8px;
  font-family: 'Rajdhani', sans-serif;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: rgba(0,0,0,.4);
  pointer-events: none;
  white-space: nowrap;
  z-index: 4;
  transition: opacity .5s;
}
.car-360-hint svg { width: 18px; height: 18px; opacity: .6; flex-shrink: 0; }
.car-360-dots {
  position: absolute;
  bottom: 28px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 5px;
  z-index: 4;
}
.car-360-dots span {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: rgba(0,0,0,.15);
  display: block;
  transition: background .15s, transform .15s;
}
.car-360-dots span.active {
  background: #c00;
  transform: scale(1.4);
}
.car-360-bar {
  position: absolute;
  bottom: 10px;
  left: 50%;
  transform: translateX(-50%);
  width: 100px;
  height: 3px;
  background: rgba(0,0,0,.08);
  border-radius: 2px;
  overflow: hidden;
  z-index: 4;
}
.car-360-bar-fill {
  height: 100%;
  background: #c00;
  border-radius: 2px;
  transition: width .08s linear;
}
.car-360-auto-btn {
  position: absolute;
  top: 12px;
  right: 12px;
  width: 36px; height: 36px;
  background: rgba(255,255,255,.9);
  border: 1.5px solid #ddd;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer;
  z-index: 5;
  transition: background .2s, border-color .2s, transform .15s;
  box-shadow: 0 2px 8px rgba(0,0,0,.12);
}
.car-360-auto-btn:hover {
  background: #c00;
  border-color: #c00;
  transform: scale(1.08);
}
.car-360-auto-btn:hover .btn-icon-stroke { stroke: #fff !important; }
.car-360-auto-btn:hover .btn-icon-fill  { fill: #fff !important; }
.car-360-badge {
  position: absolute;
  top: 12px;
  left: 12px;
  font-family: 'Rajdhani', sans-serif;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: #c00;
  background: rgba(255,255,255,.9);
  border: 1px solid rgba(204,0,0,.2);
  padding: 4px 10px;
  z-index: 5;
  display: flex;
  align-items: center;
  gap: 6px;
}
.car-360-badge::before {
  content: '';
  width: 6px; height: 6px;
  border-radius: 50%;
  background: #c00;
  animation: pulse360 1.2s ease-in-out infinite;
}
@keyframes pulse360 {
  0%,100% { opacity: 1; transform: scale(1); }
  50%      { opacity: .4; transform: scale(.7); }
}

/* ── TINH NANG ── */
.features-section { background: #fff; }
.feature-slide { display: grid; grid-template-columns: 45% 55%; min-height: 480px; opacity: 0; transform: translateY(32px); transition: opacity .75s cubic-bezier(.22,1,.36,1), transform .75s cubic-bezier(.22,1,.36,1); align-items: stretch; border-bottom: 1px solid #ececec; }
.feature-slide.in-view { opacity: 1; transform: none; }
.feature-slide.reverse { grid-template-columns: 55% 45%; }
.feature-slide-body { display: flex; flex-direction: column; justify-content: center; padding: 72px 80px; background: #fff; position: relative; overflow: hidden; }
.feature-slide.reverse .feature-slide-body { order: 2; }
.feature-slide-body::before { content: ''; position: absolute; left: 0; top: 60px; bottom: 60px; width: 3px; background: linear-gradient(to bottom, transparent, #c00 30%, #c00 70%, transparent); opacity: 0; transition: opacity .5s .4s; }
.feature-slide.in-view .feature-slide-body::before { opacity: 1; }
.feature-slide.reverse .feature-slide-body::before { left: auto; right: 0; }
.feature-slide-number { font-family: 'Barlow Condensed', sans-serif; font-size: 140px; font-weight: 900; color: rgba(0,0,0,.04); line-height: 1; position: absolute; top: 16px; right: 32px; letter-spacing: -6px; user-select: none; pointer-events: none; }
.feature-slide.reverse .feature-slide-number { right: auto; left: 32px; }
.feature-slide-number.hide-num { display: none; }
.feature-slide-badge { font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 4px; text-transform: uppercase; color: #c00; margin-bottom: 16px; display: flex; align-items: center; gap: 10px; opacity: 0; transform: translateX(-16px); transition: opacity .5s .2s, transform .5s .2s; }
.feature-slide.in-view .feature-slide-badge { opacity: 1; transform: none; }
.feature-slide-badge::before { content:''; width:20px; height:1px; background:#c00; flex-shrink:0; }
.feature-slide-variant { font-family: 'Barlow', sans-serif; font-size: 12px; color: #aaa; margin-bottom: 12px; letter-spacing: 2px; text-transform: uppercase; opacity: 0; transform: translateX(-16px); transition: opacity .5s .3s, transform .5s .3s; }
.feature-slide.in-view .feature-slide-variant { opacity: 1; transform: none; }
.feature-slide-title { font-family: 'Barlow Condensed', sans-serif; font-size: clamp(28px,3vw,48px); font-weight: 900; color: #111; text-transform: uppercase; letter-spacing: -1px; line-height: .95; font-style: italic; margin-bottom: 20px; opacity: 0; transform: translateY(20px); transition: opacity .6s .25s, transform .6s .25s; }
.feature-slide.in-view .feature-slide-title { opacity: 1; transform: none; }
.feature-slide-desc { font-family: 'Barlow', sans-serif; font-size: 15px; color: #555; line-height: 1.85; margin-bottom: 36px; max-width: 440px; opacity: 0; transform: translateY(16px); transition: opacity .6s .35s, transform .6s .35s; }
.feature-slide.in-view .feature-slide-desc { opacity: 1; transform: none; }
.btn-feature-detail { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; background: transparent; color: #111; border: 1.5px solid #111; padding: 13px 28px; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; align-self: flex-start; position: relative; overflow: hidden; opacity: 0; transform: translateY(12px); transition: opacity .5s .45s, transform .5s .45s, border-color .25s, color .25s; }
.feature-slide.in-view .btn-feature-detail { opacity: 1; transform: none; }
.btn-feature-detail::after { content: ''; position: absolute; inset: 0; background: #c00; transform: scaleX(0); transform-origin: left; transition: transform .3s cubic-bezier(.22,1,.36,1); z-index: 0; }
.btn-feature-detail span { position: relative; z-index: 1; }
.btn-feature-detail:hover { border-color: #c00; color: #fff; }
.btn-feature-detail:hover::after { transform: scaleX(1); }
.feature-slide-imgs { position: relative; overflow: hidden; background: #f0eeea; min-height: 420px; }
.feature-slide.reverse .feature-slide-imgs { order: 1; }
.feature-slide-imgs .img-slot { position: absolute; inset: 0; }
.feature-slide-imgs .img-slot img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.8s ease; }
.feature-slide.in-view .feature-slide-imgs .img-slot img { transform: scale(1.03); }
.feature-slide-imgs::after { content: ''; position: absolute; inset: 0; background: linear-gradient(270deg, transparent 65%, rgba(255,255,255,.3) 100%); pointer-events: none; z-index: 2; }
.feature-slide.reverse .feature-slide-imgs::after { background: linear-gradient(90deg, transparent 65%, rgba(255,255,255,.3) 100%); }
.img-slot-no-img { position: absolute; inset: 0; background: linear-gradient(135deg,#f5f5f3 0%,#e8e5e0 100%); display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 16px; }
.img-slot-no-img-icon { width: 64px; height: 64px; opacity: .2; }
.img-slot-no-img-text { font-family: 'Barlow Condensed', sans-serif; font-size: 13px; font-weight: 700; letter-spacing: 4px; text-transform: uppercase; color: rgba(0,0,0,.2); }

/* ── MODAL ── */
.feature-modal-backdrop { position: fixed; inset: 0; z-index: 99999; background: rgba(0,0,0,.97); display: none; flex-direction: column; opacity: 0; transition: opacity .3s; overflow-y: auto; }
.feature-modal-backdrop.visible { opacity: 1; }
.feature-modal { min-height: 100vh; display: flex; flex-direction: column; background: #0d0d0f; max-width: 1100px; margin: 0 auto; width: 100%; padding-bottom: 80px; }
.feature-modal-header { padding: 28px 40px 0; display: flex; align-items: center; justify-content: flex-end; }
.feature-modal-close { width: 48px; height: 48px; background: #c00; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 20px; color: #fff; transition: background .2s; flex-shrink: 0; }
.feature-modal-close:hover { background: #a00; }
.feature-modal-section-label { font-family: 'Barlow Condensed', sans-serif; font-size: clamp(28px,4vw,48px); font-weight: 900; color: #fff; text-transform: uppercase; letter-spacing: -1px; font-style: italic; text-align: center; padding: 28px 48px 0; line-height: 1; }
.feature-modal-tab-row { display: flex; justify-content: center; padding: 16px 48px 0; }
.feature-modal-tab { font-family: 'Barlow Condensed', sans-serif; font-size: 18px; font-weight: 700; color: #fff; text-transform: uppercase; letter-spacing: 1px; padding-bottom: 10px; border-bottom: 3px solid #c00; display: inline-block; }
.modal-slider { position: relative; width: 100%; background: #000; margin-top: 28px; }
.modal-slider-track-wrap { overflow: hidden; width: 100%; }
.modal-slider-track { display: flex; transition: transform .45s cubic-bezier(.22,1,.36,1); }
.modal-slider-track .modal-slide { flex: 0 0 100%; width: 100%; background: #000; display: flex; align-items: center; justify-content: center; }
.modal-slider-track .modal-slide img { width: 100%; max-height: 540px; object-fit: contain; display: block; }
.modal-slider-btn { position: absolute; top: 50%; transform: translateY(-50%); width: 52px; height: 52px; background: rgba(0,0,0,.55); border: 1px solid rgba(255,255,255,.18); color: #fff; font-size: 28px; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10; transition: background .2s, border-color .2s; }
.modal-slider-btn:hover { background: #c00; border-color: #c00; }
.modal-slider-btn.prev { left: 16px; }
.modal-slider-btn.next { right: 16px; }
.modal-slider-dots { display: flex; justify-content: center; gap: 10px; padding: 16px 0 0; }
.modal-slider-dots .dot { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,.25); cursor: pointer; transition: background .2s, transform .2s; }
.modal-slider-dots .dot.active { background: #c00; transform: scale(1.35); }
.modal-slider.single .modal-slider-btn,.modal-slider.single .modal-slider-dots,.modal-slider.single .modal-slider-progress { display: none; }
.modal-slider-progress { display: flex; align-items: center; gap: 14px; padding: 10px 48px 0; }
.modal-slider-progress-track { flex: 1; height: 3px; background: rgba(255,255,255,.12); border-radius: 2px; position: relative; cursor: pointer; overflow: hidden; }
.modal-slider-progress-fill { position: absolute; left: 0; top: 0; height: 100%; background: #c00; border-radius: 2px; transition: width .4s cubic-bezier(.22,1,.36,1); pointer-events: none; }
.modal-slider-progress-count { font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700; letter-spacing: 2px; color: rgba(255,255,255,.4); white-space: nowrap; flex-shrink: 0; }
.feature-modal-desc { padding: 28px 80px 0; }
.feature-modal-text { font-family: 'Barlow', sans-serif; font-size: 16px; color: rgba(255,255,255,.7); line-height: 1.9; max-width: 860px; }

/* ── THONG SO ── */
.specs-section-inner { padding: 0 0 72px; max-width: 800px; margin: 0 auto; }
.specs-outer-wrap { position: relative; border: 1px solid #e0e0e0; border-radius: 4px; overflow: hidden; }
.specs-layout { display: flex; }
.specs-col-fixed { flex-shrink: 0; width: 200px; min-width: 160px; background: #f8f8f8; border-right: 2px solid #c00; z-index: 3; position: relative; }
.specs-col-value { flex: 1; background: #fff; }
.specs-header-fixed { height: 48px; background: #c00; display: flex; align-items: center; justify-content: center; padding: 0 16px; font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: #fff; }
.specs-header-value { height: 48px; background: #c00; display: flex; align-items: center; justify-content: center; padding: 0 16px; font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #fff; }
.specs-cat-fixed { background: #f0f0f0; border-left: 3px solid #c00; border-bottom: 1px solid #e0e0e0; border-top: 1px solid #e8e8e8; padding: 8px 16px; display: flex; align-items: center; gap: 10px; cursor: pointer; user-select: none; min-height: 38px; }
.specs-cat-label { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #222; flex: 1; line-height: 1.3; }
.specs-cat-arrow { color: #c00; font-size: 12px; transition: transform .25s; flex-shrink: 0; }
.specs-cat-fixed.collapsed .specs-cat-arrow { transform: rotate(180deg); }
.specs-cat-spacer { background: #f0f0f0; border-bottom: 1px solid #e0e0e0; border-top: 1px solid #e8e8e8; min-height: 38px; }
.specs-key-cell { padding: 10px 16px; border-bottom: 1px solid #ececec; font-family: 'Barlow', sans-serif; font-size: 13px; color: #666; min-height: 40px; display: flex; align-items: center; line-height: 1.4; background: #f8f8f8; }
.specs-val-cell { padding: 10px 16px; border-bottom: 1px solid #ececec; font-family: 'Barlow', sans-serif; font-size: 13px; color: #111; font-weight: 500; min-height: 40px; display: flex; align-items: center; justify-content: center; text-align: center; line-height: 1.4; background: #fff; }
.specs-row-group.collapsed .specs-key-cell,.specs-row-group.collapsed .specs-val-cell { display: none; }

/* ── THU VIEN ── */
.tv-section { background: #000; padding: 64px 0; }
.tv-head { text-align: center; margin-bottom: 24px; }
.tv-head-title { font-family: 'Barlow Condensed', sans-serif; font-size: clamp(28px,4vw,44px); font-weight: 900; text-transform: uppercase; font-style: italic; letter-spacing: 2px; color: #fff; }
.tv-head-title em { color: #c00; font-style: normal; }
.tv-tabs { display: flex; justify-content: center; gap: 0; border-bottom: 1px solid rgba(255,255,255,0.12); margin-bottom: 0; }
.tv-tab { background: none; border: none; color: rgba(255,255,255,.45); font-family: 'Barlow Condensed', sans-serif; font-size: 16px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 10px 32px 14px; cursor: pointer; border-bottom: 3px solid transparent; position: relative; top: 1px; transition: color .2s, border-color .2s; }
.tv-tab.active { color: #fff; border-bottom-color: #fff; }
.tv-tab:hover:not(.active) { color: rgba(255,255,255,.75); }
.tv-photo { display: none; padding-top: 0; }
.tv-video { display: none; padding: 32px 60px 0; }
.tv-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; height: 380px; gap: 3px; margin-bottom: 8px; position: relative; }
.tv-slot { overflow: hidden; background: #111; cursor: pointer; position: relative; }
.tv-slot img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .5s ease; }
.tv-slot:hover img { transform: scale(1.04); }
.tv-arrow { position: absolute; top: 50%; transform: translateY(-50%); width: 50px; height: 50px; background: rgba(0,0,0,.6); border: none; color: #fff; font-size: 28px; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10; transition: background .2s; line-height: 1; }
.tv-arrow:hover { background: #c00; }
.tv-arrow-prev { left: 14px; }
.tv-arrow-next { right: 14px; }
.tv-thumbs { display: flex; gap: 5px; justify-content: center; padding: 4px 40px 0; overflow-x: auto; scrollbar-width: none; flex-wrap: nowrap; }
.tv-thumbs::-webkit-scrollbar { display: none; }
.tv-thumb { flex-shrink: 0; width: 96px; height: 64px; overflow: hidden; cursor: pointer; border: 2px solid transparent; transition: border-color .2s; }
.tv-thumb.tv-thumb-active { border-color: #c00; }
.tv-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.tv-video-wrap { max-width: 900px; margin: 0 auto 16px; }
.tv-video-main { position: relative; background: #000; cursor: pointer; overflow: hidden; }
.tv-video-main img { width: 100%; display: block; aspect-ratio: 16/9; object-fit: cover; }
.tv-video-main iframe, .tv-video-main video { width: 100%; display: block; aspect-ratio: 16/9; border: none; background: #000; }
.tv-play-overlay { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,.22); transition: background .2s; }
.tv-video-main:hover .tv-play-overlay { background: rgba(0,0,0,.38); }
.tv-play-circle { width: 74px; height: 74px; background: rgba(255,255,255,.93); border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: transform .2s; }
.tv-video-main:hover .tv-play-circle { transform: scale(1.08); }
.tv-play-tri { width: 0; height: 0; border-style: solid; border-width: 16px 0 16px 30px; border-color: transparent transparent transparent #c00; margin-left: 6px; }
.tv-vthumbs { display: flex; gap: 6px; justify-content: center; flex-wrap: wrap; }
.tv-vthumb { width: 96px; height: 64px; overflow: hidden; cursor: pointer; border: 2px solid transparent; position: relative; transition: border-color .2s; }
.tv-vthumb.tv-vthumb-active { border-color: #c00; }
.tv-vthumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.tv-vthumb-pi-wrap { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,.38); }
.tv-vthumb-pi { width: 0; height: 0; border-style: solid; border-width: 7px 0 7px 13px; border-color: transparent transparent transparent #fff; }
.tv-no-thumb { width: 100%; aspect-ratio: 16/9; background: #111; display: flex; align-items: center; justify-content: center; }
.tv-no-thumb-txt { font-family: 'Barlow Condensed', sans-serif; font-size: 13px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: rgba(255,255,255,.2); }

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
.info-cta-btn { font-family: 'Rajdhani', sans-serif; font-size: 18px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; border: 1px solid #ffffff; color: #ffffff; padding: 16px 40px; min-width: 280px; cursor: pointer; background: transparent; transition: background .2s, color .2s; text-decoration: none; display: inline-block; text-align: center; }
.info-cta-btn:hover { background: #ffffff; color: #111; }

/* ── RESPONSIVE ── */
@media(max-width:1024px) {
  .price-color-layout { grid-template-columns: 1fr; gap: 40px; }
  .feature-slide,.feature-slide.reverse { grid-template-columns: 1fr !important; min-height: auto; }
  .feature-slide.reverse .feature-slide-imgs,.feature-slide.reverse .feature-slide-body { order: unset; }
  .feature-slide-imgs { min-height: 280px; }
  .feature-slide-body { padding: 48px 40px; }
  .feature-modal-header { padding: 20px 20px 0; }
  .feature-modal-section-label { padding: 20px 20px 0; font-size: 26px; }
  .feature-modal-tab-row { padding: 12px 20px 0; }
  .feature-modal-desc { padding: 20px 20px 0; }
  .modal-slider-progress { padding: 10px 20px 0; }
  .related-grid { grid-template-columns: repeat(2,1fr); }
  .car-hero-content { padding: 0 40px 40px; flex-direction: column; align-items: flex-start; gap: 20px; }
  .specs-section-inner { padding: 0 20px 60px; max-width: 100%; }
  .specs-col-fixed { width: 150px; min-width: 130px; }
  .tv-video { padding: 24px 24px 0; }
}
@media(max-width:768px) {
  .container { padding: 0 20px; }
  .page-breadcrumb { padding: 8px 20px; font-size: 12px; }
  .car-hero { height: 420px; }
  .related-grid { grid-template-columns: 1fr; }
  .info-cta { padding: 60px 20px; }
  .info-cta-btn { min-width: unset; width: 100%; }
  .feature-slide-body { padding: 36px 24px; }
  .feature-slide-imgs { min-height: 220px; }
  .detail-nav a { padding: 0 14px; font-size: 12px; }
  .specs-col-fixed { width: 120px; min-width: 100px; }
  .specs-header-fixed,.specs-cat-label { font-size: 10px; }
  .specs-key-cell { font-size: 12px; padding: 8px 10px; }
  .specs-val-cell { font-size: 12px; padding: 8px 10px; }
  .tv-grid { height: 220px; grid-template-columns: 1fr; }
  .tv-slot:nth-child(2),.tv-slot:nth-child(3) { display: none; }
  .tv-thumbs { padding: 4px 12px 0; }
  .tv-video { padding: 20px 16px 0; }
  .car-360-wrap { min-height: 260px; }
}
/* ── COLOR PICKER 360 ── */
.color-picker-360 {
  display: flex; justify-content: center;
  gap: 20px; margin-top: 20px; flex-wrap: wrap;
}
.color-picker-360-item {
  display: flex; flex-direction: column;
  align-items: center; gap: 6px;
  cursor: pointer; transition: transform .2s;
}
.color-picker-360-item:hover { transform: translateY(-3px); }
.color-picker-360-dot {
  width: 36px; height: 36px; border-radius: 50%;
  border: 3px solid transparent;
  transition: border-color .25s, transform .25s;
  box-sizing: border-box;
}
.color-picker-360-item.active360 .color-picker-360-dot {
  border-color: #c00; transform: scale(1.18);
}
.color-picker-360-label {
  font-family: 'Rajdhani', sans-serif; font-size: 10px;
  font-weight: 700; letter-spacing: 2px;
  text-transform: uppercase; color: #999;
  transition: color .2s;
}
.color-picker-360-item.active360 .color-picker-360-label { color: #c00; }
.color-picker-360-item.active360 .color-picker-360-label { color: #c00; }
</style>
@endpush

@section('content')

@php
function carImgPath($val) {
    if (!$val) return null;
    $val = trim($val);
    if ($val === '') return null;
    if (preg_match('#^https?://#i', $val)) return $val;
    $val = ltrim($val, '/');
    $segments = explode('/', $val);
    $encoded  = array_map(fn($seg) => rawurlencode(rawurldecode($seg)), $segments);
    return asset(implode('/', $encoded));
}
@endphp

{{-- ===== STICKY: BREADCRUMB + NAV ===== --}}
<div class="detail-sticky-wrap" id="detail-sticky-wrap">
  <div class="page-breadcrumb">
    <a href="{{ url('/') }}">Home</a> ›
    <a href="{{ route('cars.index') }}">Xe</a> ›
    <span>{{ $car->name }}</span>
  </div>
  <nav class="detail-nav" id="detail-nav">
    <a href="#gia-mau-sac" class="nav-link">Giá & Hạng xe</a>
    <a href="#tinh-nang"   class="nav-link">Tính năng nổi bật</a>
    @if($specsByCategory->count())
      @php
        $specCats   = $specsByCategory->keys();
        $hasSafety  = $specCats->contains(fn($c) => str_contains(strtoupper($c), 'AN TOÀN'));
        $hasBattery = $specCats->contains(fn($c) => str_contains(strtoupper($c), 'PIN'));
        $hasOffroad = $specCats->contains(fn($c) => str_contains(strtoupper($c), 'ĐỊA HÌNH'));
      @endphp
      @if($hasSafety)  <a href="#thong-so" class="nav-link" data-cat="an-toan">An toàn</a>@endif
    @endif
    <a href="#thong-so"  class="nav-link">Thông số kỹ thuật</a>
    <a href="#thu-vien"  class="nav-link">Thư viện ảnh</a>
    <a href="#thong-tin" class="nav-link">Thông tin chi tiết</a>
    @if($relatedCars->count())
    <a href="#so-sanh" class="nav-link">So sánh sản phẩm</a>
    @endif
  </nav>
</div>

{{-- HERO --}}
<section class="car-hero">
@php
  $vinColorMap = [
    // ── VF3: có 360° ──
    'vinfast-vf-3' => [
      'Hồng' => ['has360' => true,  'prefix' => 'images/vinfast/vf3-hong', 'frames' => 8, 'ext' => 'png', 'hex' => '#f4a7b9', 'static' => 'images/vinfast/vf3-hong1.png'],
      'Xanh' => ['has360' => true,  'prefix' => 'images/vinfast/vf3-xanh', 'frames' => 8, 'ext' => 'png', 'hex' => '#5b9bd5', 'static' => 'images/vinfast/vf3-xanh1.png'],
      'Xám'  => ['has360' => true,  'prefix' => 'images/vinfast/vf3-xam',  'frames' => 8, 'ext' => 'png', 'hex' => '#9e9e9e', 'static' => 'images/vinfast/vf3-xam1.png'],
    ],
    // ── VF5: chỉ tĩnh ──
    'vinfast-vf-5' => [
      'Vàng' => ['has360' => false, 'prefix' => '', 'frames' => 0, 'ext' => 'png', 'hex' => '#fdd835', 'static' => 'images/vinfast/vf5-vang.png'],
      'Xám'  => ['has360' => false, 'prefix' => '', 'frames' => 0, 'ext' => 'png', 'hex' => '#9e9e9e', 'static' => 'images/vinfast/vf5-xam.png'],
      'Xanh' => ['has360' => false, 'prefix' => '', 'frames' => 0, 'ext' => 'png', 'hex' => '#5b9bd5', 'static' => 'images/vinfast/vf5-xanh.png'],
    ],
    // ── VF6: chỉ tĩnh ──
    'vinfast-vf-6' => [
      'Xanh'  => ['has360' => false, 'prefix' => '', 'frames' => 0, 'ext' => 'png', 'hex' => '#5b9bd5', 'static' => 'images/vinfast/vf6-xanh.png'],
      'Xám'   => ['has360' => false, 'prefix' => '', 'frames' => 0, 'ext' => 'png', 'hex' => '#9e9e9e', 'static' => 'images/vinfast/vf6-xam.png'],
      'Trắng' => ['has360' => false, 'prefix' => '', 'frames' => 0, 'ext' => 'png', 'hex' => '#f5f5f5', 'static' => 'images/vinfast/vf6-trang.png'],
    ],
    // ── VF7: có 360° ──
    'vinfast-vf-7' => [
      'Đỏ'    => ['has360' => true,  'prefix' => 'images/vinfast/vf7-do',    'frames' => 8, 'ext' => 'png', 'hex' => '#c62828', 'static' => 'images/vinfast/vf7-do1.png'],
      'Trắng' => ['has360' => true,  'prefix' => 'images/vinfast/vf7-trang', 'frames' => 8, 'ext' => 'png', 'hex' => '#f5f5f5', 'static' => 'images/vinfast/vf7-trang1.png'],
      'Xám'   => ['has360' => true,  'prefix' => 'images/vinfast/vf7-xam',   'frames' => 8, 'ext' => 'png', 'hex' => '#757575', 'static' => 'images/vinfast/vf7-xam1.png'],
    ],
    // ── VF8: chỉ tĩnh ──
    'vinfast-vf-8' => [
      'Xanh'   => ['has360' => false, 'prefix' => '', 'frames' => 0, 'ext' => 'png', 'hex' => '#1565c0', 'static' => 'images/vinfast/vf8-xanh.png'],
      'Đỏ nâu' => ['has360' => false, 'prefix' => '', 'frames' => 0, 'ext' => 'png', 'hex' => '#6d4c41', 'static' => 'images/vinfast/vf8-donau.png'],
      'Trắng'  => ['has360' => false, 'prefix' => '', 'frames' => 0, 'ext' => 'png', 'hex' => '#f5f5f5', 'static' => 'images/vinfast/vf8-trang.png'],
    ],
    // ── VF9: chỉ tĩnh ──
    'vinfast-vf-9' => [
      'Đỏ'    => ['has360' => false, 'prefix' => '', 'frames' => 0, 'ext' => 'png', 'hex' => '#c62828', 'static' => 'images/vinfast/vf9-do.png'],
      'Đen'   => ['has360' => false, 'prefix' => '', 'frames' => 0, 'ext' => 'png', 'hex' => '#212121', 'static' => 'images/vinfast/vf9-den.png'],
      'Trắng' => ['has360' => false, 'prefix' => '', 'frames' => 0, 'ext' => 'png', 'hex' => '#f5f5f5', 'static' => 'images/vinfast/vf9-trang.png'],
    ],
  ];

  $carSlugLower360 = strtolower(Str::slug($car->name));
  $vinColors       = $vinColorMap[$carSlugLower360] ?? [];
  $isVinFast       = count($vinColors) > 0;

  // Build allColors360
  $allColors360 = [];
  foreach ($vinColors as $colorName => $cfg) {
    $colorFrames = [];
    if ($cfg['has360']) {
      for ($fi = 1; $fi <= $cfg['frames']; $fi++) {
        $p = $cfg['prefix'] . $fi . '.' . $cfg['ext'];
        if (file_exists(public_path($p))) $colorFrames[] = asset($p);
      }
    }
    $allColors360[$colorName] = [
      'frames' => $colorFrames,
      'static' => file_exists(public_path($cfg['static'])) ? asset($cfg['static']) : null,
      'hex'    => $cfg['hex'],
      'has360' => $cfg['has360'] && count($colorFrames) >= 2,
    ];
  }

  // Màu đầu tiên mặc định
  $firstColor = array_values($allColors360)[0] ?? null;
  $frames360  = $firstColor['frames'] ?? [];
  $has360     = count($frames360) >= 2;
  $previewImg = $firstColor['static'] ?? null;

  // Fallback Mercedes
  if (!$isVinFast) {
    $previewImg = carImgPath($car->image_url ?? null);
    if (!$previewImg) {
      $defaultColor = $car->colors->firstWhere('is_default', true) ?? $car->colors->first();
      $previewImg   = carImgPath($defaultColor?->image ?? null);
    }
    if (!$previewImg) {
      $fg = $car->galleries->where('type','image')
              ->filter(fn($g) => str_contains($g->file_path ?? '', 'images/car/'))
              ->sortBy('sort_order')->first();
      $previewImg = carImgPath($fg?->file_path ?? null);
    }
  }

  // Hero background
  if ($isVinFast) {
    $vfNgoaiMap = [
      'vinfast-vf-3' => 'images/vinfast/vf3-ngoai',
      'vinfast-vf-5' => 'images/vinfast/vf5-ngoai',
      'vinfast-vf-6' => 'images/vinfast/vf6-ngoai',
      'vinfast-vf-7' => 'images/vinfast/vf7-ngoai1',
      'vinfast-vf-8' => 'images/vinfast/vf8-ngoai1',
      'vinfast-vf-9' => 'images/vinfast/vf9-ngoai',
    ];
    $vfBase  = $vfNgoaiMap[$carSlugLower360] ?? null;
    $heroSrc = null;
    if ($vfBase) {
      foreach (['png', 'jpg', 'jpeg'] as $ext) {
        if (file_exists(public_path("{$vfBase}.{$ext}"))) {
          $heroSrc = asset("{$vfBase}.{$ext}"); break;
        }
      }
    }
    $heroSrc = $heroSrc ?? $frames360[0] ?? $previewImg ?? null;

  } else {
    $merHeroMap = [
      'mercedes-benz-e-class'    => 'images/car/benz-class',
      'mercedes-benz-eqs'        => 'images/car/benz-eqs',
      'mercedes-benz-g-class'    => 'images/car/benz-g-class',
      'mercedes-benz-gle'        => 'images/car/benz-gle',
      'mercedes-benz-gls'        => 'images/car/benz-gls',
      'mercedes-benz-s-class'    => 'images/car/benz-s-class',
      'mercedes-benz-sl-class'   => 'images/car/benz-sl-class',
      'mercedes-maybach-s-class' => 'images/car/mabach-class',
      'mercedes-maybach-gls'     => 'images/car/maybach-gls',
      'mercedes-amg-gle'         => 'images/car/amg-gle',
    ];
    $merBase = $merHeroMap[Str::slug($car->name)] ?? null;
    $heroSrc = null;
    if ($merBase) {
      foreach (['png', 'jpg', 'jpeg'] as $ext) {
        if (file_exists(public_path("{$merBase}.{$ext}"))) {
          $heroSrc = asset("{$merBase}.{$ext}"); break;
        }
      }
    }
    $heroSrc = $heroSrc ?? $previewImg ?? null;
  }
@endphp
  <img class="car-hero-img" src="{{ $heroSrc }}" alt="{{ $car->name }}"
       onerror="this.style.display='none';this.closest('.car-hero').querySelector('.car-hero-placeholder').style.display='block';">
  <div class="car-hero-overlay"></div>
  <div class="car-hero-placeholder" style="display:none;"></div>
  <div class="car-hero-content">
    <div class="car-hero-left">
      <div class="car-hero-eyebrow">{{ $car->brand?->name ?? $car->brand }}</div>
      <div class="car-hero-name">{{ $car->name }}</div>
      @if($car->tagline)<div class="car-hero-tagline">{{ $car->tagline }}</div>@endif
    </div>
    <div class="car-hero-right">
      <div class="car-hero-price-label">Giá từ</div>
      <div class="car-hero-price">{{ number_format($car->price_per_day ?? $car->price) }}<small>VNĐ</small></div>
      @php
        $statusMap = [
          'available'    => ['class' => 'status-available',    'label' => 'Còn xe'],
          'out_of_stock' => ['class' => 'status-out-of-stock', 'label' => 'Hết hàng'],
          'coming_soon'  => ['class' => 'status-coming-soon',  'label' => 'Sắp ra mắt'],
          'rented'       => ['class' => 'status-rented',       'label' => 'Đang thuê'],
          'maintenance'  => ['class' => 'status-maintenance',  'label' => 'Bảo dưỡng'],
        ];
        $st = $statusMap[$car->status ?? 'available'] ?? $statusMap['available'];
      @endphp
      <div class="car-hero-status {{ $st['class'] }}">● {{ $st['label'] }}</div>
    </div>
  </div>
</section>

{{-- GIA & HANG XE --}}
<section class="price-color-section" id="gia-mau-sac">
  <div class="container">
    <div class="price-color-layout">

      {{-- LEFT: thông tin giá --}}
      <div class="pcs-left">
        <div class="section-label">Bộ sưu tập</div>
        <div class="section-title" style="color:#111;margin-bottom:32px;">Giá & <em style="color:#c00;">Hạng xe</em></div>
        <div class="car-name-display">
          <div class="car-name-display-label">Dòng xe</div>
          <div class="car-name-display-value">{{ $car->name }}</div>
        </div>
        <div class="price-display">
          <div class="price-display-label">Giá bán lẻ đề xuất</div>
          <div class="price-display-value">{{ number_format($car->price_per_day ?? $car->price) }}<span>VNĐ</span></div>
        </div>
        <div class="cta-row">
          <a href="{{ route('cars.costEstimate', $car) }}" class="btn-outline-alt">DỰ TOÁN CHI PHÍ →</a>
          <a href="{{ route('services.booking') }}?chu_de=Test+drive+(lái+thử+xe)&svc=kiemtra" class="btn-outline-alt secondary">ĐĂNG KÝ LÁI THỬ →</a>
        </div>
      </div>

      @if($has360)
      {{-- ===== 360° VIEWER ===== --}}
      {{-- VF3 / VF7: 360° + color picker --}}
      <div>
        <div class="car-360-wrap" id="car360wrap"
             data-frames='@json($frames360)'
             data-total="{{ count($frames360) }}">

          {{-- Watermark tên xe --}}
          <div class="color-preview-watermark">{{ $car->name }}</div>

          {{-- Badge 360 --}}
          <div class="car-360-badge">360°</div>

          {{-- Ảnh hiển thị --}}
          <img class="car-360-img" id="car360img"
               src="{{ $frames360[0] }}" alt="{{ $car->name }}">

          {{-- Nút play/pause --}}
          <button class="car-360-auto-btn" id="car360autoBtn" title="Bật/tắt tự xoay" type="button">
            {{-- Icon Pause (đang chạy) --}}
            <svg id="car360iconPause" viewBox="0 0 24 24" fill="none" width="16" height="16">
              <rect x="5"  y="4" width="4" height="16" rx="1" fill="#555" class="btn-icon-fill"/>
              <rect x="15" y="4" width="4" height="16" rx="1" fill="#555" class="btn-icon-fill"/>
            </svg>
            {{-- Icon Play (đang dừng) --}}
            <svg id="car360iconPlay" viewBox="0 0 24 24" fill="none" width="16" height="16" style="display:none;">
              <path d="M6 4l13 8-13 8V4z" fill="#555" class="btn-icon-fill"/>
            </svg>
          </button>

          {{-- Dots chỉ frame --}}
          <div class="car-360-dots" id="car360dots">
            @foreach($frames360 as $fi => $_)
              <span class="{{ $fi === 0 ? 'active' : '' }}"></span>
            @endforeach
          </div>

          {{-- Gợi ý kéo --}}
          <div class="car-360-hint" id="car360hint">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
              <path d="M5 12h14M14 7l5 5-5 5"/>
            </svg>
            KÉO ĐỂ XOAY 360°
          </div>

          {{-- Thanh tiến trình --}}
          <div class="car-360-bar">
            <div class="car-360-bar-fill" id="car360fill" style="width:0%"></div>
          </div>

        </div>

        {{-- Color picker --}}
        <div class="color-picker-360" id="colorPicker360">
          @foreach($allColors360 as $colorName => $colorData)
          <div class="color-picker-360-item {{ $loop->first ? 'active360' : '' }}"
               onclick="change360Color({{ json_encode($colorData['frames']) }},{{ json_encode($colorData['static']) }},{{ $colorData['has360'] ? 'true' : 'false' }},this)">
            <div class="color-picker-360-dot"
                 style="background:{{ $colorData['hex'] }};{{ $colorName==='Trắng'?'box-shadow:inset 0 0 0 1px #ccc;':'' }}"></div>
            <span class="color-picker-360-label">{{ $colorName }}</span>
          </div>
          @endforeach
        </div>
      </div>
      {{-- END 360° VIEWER --}}

      @elseif($isVinFast && $previewImg)
      {{-- VF5/6/8/9: ảnh tĩnh + color picker --}}
      <div>
        <div class="color-preview">
          <div class="color-preview-watermark">{{ $car->name }}</div>
          <img class="color-preview-img" id="vinStaticImg" src="{{ $previewImg }}" alt="{{ $car->name }}">
        </div>
        <div class="color-picker-360" id="colorPicker360">
          @foreach($allColors360 as $colorName => $colorData)
          <div class="color-picker-360-item {{ $loop->first ? 'active360' : '' }}"
               onclick="change360Color([],{{ json_encode($colorData['static']) }},false,this)">
            <div class="color-picker-360-dot"
                 style="background:{{ $colorData['hex'] }};{{ $colorName==='Trắng'?'box-shadow:inset 0 0 0 1px #ccc;':'' }}"></div>
            <span class="color-picker-360-label">{{ $colorName }}</span>
          </div>
          @endforeach
        </div>
      </div>

      @elseif($previewImg)
      {{-- Mercedes: ảnh tĩnh, không có color picker --}}
      <div class="color-preview">
        <div class="color-preview-watermark">{{ $car->name }}</div>
        <img class="color-preview-img" src="{{ $previewImg }}" alt="{{ $car->name }}">
      </div>

      @else
      <div class="color-preview">
        <div class="color-preview-watermark">{{ $car->name }}</div>
      </div>
      @endif

    </div>
  </div>
</section>

{{-- TINH NANG NOI BAT --}}
@if($car->features->count())
@php
  $featurePairs = $car->features->unique('id')->sortBy('sort_order')->values();
  $ngoai = $featurePairs->first(fn($f) => str_contains(strtolower($f->title), 'ngoại') || str_contains(strtolower($f->title), 'ngoai'));
  $noi   = $featurePairs->first(fn($f) => str_contains(strtolower($f->title), 'nội')   || str_contains(strtolower($f->title), 'noi'));
  if (!$ngoai) $ngoai = $featurePairs->get(0);
  if (!$noi)   $noi   = $featurePairs->get(1);
  $twoFeatures = collect([$ngoai, $noi])->filter();
@endphp
<section class="features-section" id="tinh-nang">
  <div class="features-snap-wrap">
    @foreach($twoFeatures as $idx => $feature)
      @php
        $featImg   = carImgPath(!empty(trim($feature->image ?? '')) ? $feature->image : null);
        $isReverse = $idx % 2 === 1;
        $badgeText = $idx === 0 ? 'NGOẠI THẤT' : 'NỘI THẤT';
        $num       = str_pad($idx + 1, 2, '0', STR_PAD_LEFT);
        $modalImg1 = carImgPath(!empty(trim($feature->image ?? ''))  ? $feature->image  : null);
        $modalImg2 = carImgPath(!empty(trim($feature->image2 ?? '')) ? $feature->image2 : null);
      @endphp
      <div class="feature-slide {{ $isReverse ? 'reverse' : '' }}"
           style="min-height:520px;"
           data-title="{{ $feature->title }}"
           data-desc="{{ $feature->description }}"
           data-badge="{{ $badgeText }}"
           data-variant=""
           data-img="{{ $modalImg1 ?? '' }}"
           data-img2="{{ $modalImg2 ?? '' }}">

        {{-- TEXT SIDE --}}
        <div class="feature-slide-body">
          <div class="feature-slide-number">{{ $num }}</div>
          <div class="feature-slide-badge">{{ $badgeText }}</div>
          <div class="feature-slide-title">{{ $feature->title }}</div>
          <div class="feature-slide-desc">{{ $feature->description }}</div>
          <button class="btn-feature-detail" onclick="openFeatureModal(this.closest('.feature-slide'))">
            <span>XEM CHI TIẾT →</span>
          </button>
        </div>

        {{-- IMAGE SIDE --}}
        <div class="feature-slide-imgs">
          <div class="img-slot">
            @if($featImg)
              <img src="{{ $featImg }}" alt="{{ $feature->title }}" loading="lazy"
                   onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
              <div class="img-slot-no-img" style="display:none;">
                <svg class="img-slot-no-img-icon" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="1">
                  <rect x="3" y="3" width="18" height="18" rx="2"/>
                  <circle cx="8.5" cy="8.5" r="1.5"/>
                  <polyline points="21 15 16 10 5 21"/>
                </svg>
                <span class="img-slot-no-img-text">{{ $car->name }}</span>
              </div>
            @else
              <div class="img-slot-no-img">
                <svg class="img-slot-no-img-icon" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="1">
                  <rect x="3" y="3" width="18" height="18" rx="2"/>
                  <circle cx="8.5" cy="8.5" r="1.5"/>
                  <polyline points="21 15 16 10 5 21"/>
                </svg>
                <span class="img-slot-no-img-text">{{ $car->name }}</span>
              </div>
            @endif
          </div>
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
    <div class="feature-modal-tab-row"><span class="feature-modal-tab" id="modal-title"></span></div>
    <div class="modal-slider" id="modal-slider">
      <button class="modal-slider-btn prev" onclick="sliderMove(-1)">&#8249;</button>
      <div class="modal-slider-track-wrap">
        <div class="modal-slider-track" id="modal-slider-track"></div>
      </div>
      <button class="modal-slider-btn next" onclick="sliderMove(1)">&#8250;</button>
      <div class="modal-slider-dots" id="modal-slider-dots"></div>
      <div class="modal-slider-progress">
        <div class="modal-slider-progress-track" id="progress-track">
          <div class="modal-slider-progress-fill" id="progress-fill"></div>
        </div>
        <span class="modal-slider-progress-count" id="progress-count">1 / 1</span>
      </div>
    </div>
    <div class="feature-modal-desc">
      <div class="feature-modal-text" id="modal-desc"></div>
    </div>
  </div>
</div>
@endif

{{-- THONG SO KY THUAT --}}
@if($specsByCategory->count())
<section class="section" id="thong-so" style="background:#f5f4f0;">
  <div class="container">
    <div class="section-label" style="color:#c00;">Chi tiết</div>
    <div class="section-title" style="color:#111;">Thông Số <em style="color:#c00;">Kỹ Thuật</em></div>
  </div>
  @php $firstVariant = $car->variants->unique('name')->first(); @endphp
  <div class="specs-section-inner">
    <div class="specs-outer-wrap">
      <div class="specs-layout">
        <div class="specs-col-fixed">
          <div class="specs-header-fixed">DANH MỤC</div>
          @foreach($specsByCategory as $category => $specs)
            <div class="specs-cat-fixed" data-cat="{{ Str::slug($category) }}" onclick="toggleSpecsCat('{{ Str::slug($category) }}')">
              <span class="specs-cat-label">{{ $category }}</span>
              <span class="specs-cat-arrow">&#8963;</span>
            </div>
            <div class="specs-row-group" data-cat-rows="{{ Str::slug($category) }}">
              @foreach($specs as $spec)<div class="specs-key-cell">{{ $spec->spec_key }}</div>@endforeach
            </div>
          @endforeach
        </div>
        <div class="specs-col-value">
          @if($firstVariant)
          <div class="specs-header-value">{{ strtoupper($firstVariant->name) }}</div>
          @else
          <div class="specs-header-value">{{ strtoupper($car->name) }}</div>
          @endif
          @foreach($specsByCategory as $category => $specs)
            <div class="specs-cat-spacer" data-cat="{{ Str::slug($category) }}"></div>
            <div class="specs-row-group" data-cat-rows="{{ Str::slug($category) }}">
              @foreach($specs as $spec)<div class="specs-val-cell">{{ $spec->spec_value }}</div>@endforeach
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
@endif

{{-- THU VIEN ANH & VIDEO --}}
@if($car->galleries->count())
@php
  $colorImages    = $car->colors->pluck('image')->filter()->values();
$imageGalleries = $car->galleries
    ->where('type', 'image')
    ->filter(fn($g) => !$colorImages->contains($g->file_path))
    ->sortBy('sort_order')
    ->values();
  $videoGalleries = $car->galleries->where('type','video')->sortBy('sort_order')->values();
  $tvImgUrls = $imageGalleries->map(fn($g) => carImgPath($g->file_path ?? null))->filter()->values();
  $tvVideos = $videoGalleries->map(function($g) {
      return [
          'src'     => $g->file_path ?? '',
          'thumb'   => carImgPath($g->thumbnail ?? null),
          'caption' => $g->caption ?? '',
      ];
  })->values();
  $hasPhoto = $tvImgUrls->count() > 0;
  $hasVideo = $tvVideos->count() > 0;
@endphp

<section class="tv-section" id="thu-vien">
  <div class="tv-head">
    <div class="tv-head-title"><em id="tv-title-em">Thư Viện</em>&nbsp;<span id="tv-title-word">Ảnh</span></div>
  </div>
  <div class="tv-tabs">
    @if($hasPhoto)
      <button class="tv-tab tv-active" onclick="tvSwitch('photo',this)">Ảnh</button>
    @endif
    @if($hasVideo)
      <button class="tv-tab {{ !$hasPhoto ? 'tv-active' : '' }}" onclick="tvSwitch('video',this)">Video</button>
    @endif
  </div>

  @if($hasPhoto)
  <div class="tv-photo {{ $hasPhoto ? 'tv-active' : '' }}" id="tv-photo">
    <div class="tv-single" id="tv-grid" style="position:relative;width:100%;max-width:1000px;margin:0 auto;background:#000;">
      <button class="tv-arrow tv-arrow-prev" onclick="tvShift(-1)">&#8249;</button>
      <img id="tv-img-0" src="{{ $tvImgUrls[0] ?? '' }}" alt=""
           style="width:100%;height:480px;object-fit:contain;display:block;"
           onerror="this.style.display='none';">
      <button class="tv-arrow tv-arrow-next" onclick="tvShift(1)">&#8250;</button>
    </div>
    <div class="tv-thumbs" id="tv-thumbs">
      @foreach($tvImgUrls as $i => $url)
        <div class="tv-thumb {{ $i === 0 ? 'tv-thumb-active' : '' }}" onclick="tvGoTo({{ $i }})">
          <img src="{{ $url }}" alt="" onerror="this.closest('.tv-thumb').style.display='none';">
        </div>
      @endforeach
    </div>
  </div>
  @endif

  @if($hasVideo)
  <div class="tv-video {{ !$hasPhoto ? 'tv-active' : '' }}" id="tv-video">
    <div class="tv-video-wrap">
      <div class="tv-video-main" id="tv-video-main">
        <div id="tv-player-inner">
          @php $fv = $tvVideos[0]; @endphp
          @if($fv['thumb'])
            <img src="{{ $fv['thumb'] }}" alt="" id="tv-vid-thumb">
          @else
            <div class="tv-no-thumb"><span class="tv-no-thumb-txt">{{ $car->name }}</span></div>
          @endif
          <div class="tv-play-overlay" id="tv-play-overlay">
            <div class="tv-play-circle"><div class="tv-play-tri"></div></div>
          </div>
        </div>
      </div>
      @if($tvVideos->count() > 1)
      <div class="tv-vthumbs" style="margin-top:10px;">
        @foreach($tvVideos as $vi => $vid)
          <div class="tv-vthumb {{ $vi === 0 ? 'tv-vthumb-active' : '' }}" onclick="tvSelectVideo({{ $vi }},this)">
            @if($vid['thumb'])
              <img src="{{ $vid['thumb'] }}" alt="" onerror="this.closest('.tv-vthumb').style.background='#222';this.style.display='none';">
            @else
              <div style="width:100%;height:100%;background:#222;"></div>
            @endif
            <div class="tv-vthumb-pi-wrap"><div class="tv-vthumb-pi"></div></div>
          </div>
        @endforeach
      </div>
      @endif
    </div>
  </div>
  @endif
</section>

@push('scripts')
<script>
(function(){
'use strict';
/* ── init display ── */
(function(){
  var photoEl = document.getElementById('tv-photo');
  var videoEl = document.getElementById('tv-video');
  if (photoEl) photoEl.style.display = 'block';
  if (videoEl) videoEl.style.display = 'none';
})();

var TV_IMGS   = @json($tvImgUrls->values());
var TV_VIDEOS = @json($tvVideos->values());
var tvIdx     = 0;
var tvVidIdx  = 0;

function tvUpdateGrid() {
  var n = TV_IMGS.length;
  if (!n) return;
  var s0 = document.getElementById('tv-img-0');
  if (s0) { s0.style.display = ''; s0.src = TV_IMGS[tvIdx % n]; }
  document.querySelectorAll('.tv-thumb').forEach(function(t,i){
    t.classList.toggle('tv-thumb-active', i === tvIdx);
  });
  var thumbs = document.querySelectorAll('.tv-thumb');
  if (thumbs[tvIdx]) thumbs[tvIdx].scrollIntoView({ behavior:'smooth', block:'nearest', inline:'center' });
}
window.tvShift = function(dir) {
  if (!TV_IMGS.length) return;
  tvIdx = (tvIdx + dir + TV_IMGS.length) % TV_IMGS.length;
  tvUpdateGrid();
};
window.tvGoTo = function(i) { tvIdx = i; tvUpdateGrid(); };

function tvLoadVideo(idx) {
  var vid = TV_VIDEOS[idx];
  if (!vid) return;
  var inner = document.getElementById('tv-player-inner');
  if (!inner) return;
  var src = vid.src || '';
  var ytMatch = src.match(/(?:youtu\.be\/|[?&]v=)([A-Za-z0-9_-]{11})/);
  if (ytMatch) { inner.innerHTML = '<iframe src="https://www.youtube.com/embed/'+ytMatch[1]+'?autoplay=1&rel=0" allowfullscreen allow="autoplay;fullscreen" style="width:100%;aspect-ratio:16/9;border:none;display:block;background:#000;"></iframe>'; return; }
  var vmMatch = src.match(/vimeo\.com\/(\d+)/);
  if (vmMatch) { inner.innerHTML = '<iframe src="https://player.vimeo.com/video/'+vmMatch[1]+'?autoplay=1" allowfullscreen allow="autoplay;fullscreen" style="width:100%;aspect-ratio:16/9;border:none;display:block;background:#000;"></iframe>'; return; }
  if (/\.(mp4|webm|ogg)$/i.test(src)) { inner.innerHTML = '<video src="'+src+'" controls autoplay playsinline style="width:100%;aspect-ratio:16/9;display:block;background:#000;"></video>'; return; }
  if (vid.thumb) {
    inner.innerHTML = '<img src="'+vid.thumb+'" style="width:100%;aspect-ratio:16/9;object-fit:cover;display:block;"><div class="tv-play-overlay"><div class="tv-play-circle"><div class="tv-play-tri"></div></div></div>';
    inner.querySelector('.tv-play-overlay')?.addEventListener('click', function(){ tvLoadVideo(tvVidIdx); });
  }
}
window.tvSelectVideo = function(idx, el) {
  tvVidIdx = idx;
  document.querySelectorAll('.tv-vthumb').forEach(function(t){ t.classList.remove('tv-vthumb-active'); });
  el.classList.add('tv-vthumb-active');
  var vid = TV_VIDEOS[idx];
  var inner = document.getElementById('tv-player-inner');
  if (inner && vid) {
    var thumbHtml = vid.thumb ? '<img src="'+vid.thumb+'" alt="" style="width:100%;aspect-ratio:16/9;object-fit:cover;display:block;">' : '<div class="tv-no-thumb"><span class="tv-no-thumb-txt">Video</span></div>';
    inner.innerHTML = thumbHtml + '<div class="tv-play-overlay" id="tv-play-overlay"><div class="tv-play-circle"><div class="tv-play-tri"></div></div></div>';
    document.getElementById('tv-play-overlay')?.addEventListener('click', function(){ tvLoadVideo(tvVidIdx); });
  }
};
document.getElementById('tv-play-overlay')?.addEventListener('click', function(){ tvLoadVideo(tvVidIdx); });

window.tvSwitch = function(tab, btn) {
  document.querySelectorAll('.tv-tab').forEach(function(b){ b.classList.remove('tv-active'); });
  btn.classList.add('tv-active');
  var photoEl = document.getElementById('tv-photo');
  var videoEl = document.getElementById('tv-video');
  var word    = document.getElementById('tv-title-word');
  if (photoEl) photoEl.style.display = tab === 'photo' ? 'block' : 'none';
  if (videoEl) videoEl.style.display = tab === 'video' ? 'block' : 'none';
  if (word) word.textContent = tab === 'photo' ? 'Ảnh' : 'Video';
  if (tab === 'photo') {
    var inner = document.getElementById('tv-player-inner');
    var vid   = TV_VIDEOS[tvVidIdx];
    if (inner && vid) {
      var thumbHtml = vid.thumb ? '<img src="'+vid.thumb+'" alt="" style="width:100%;aspect-ratio:16/9;object-fit:cover;display:block;">' : '<div class="tv-no-thumb"><span class="tv-no-thumb-txt">Video</span></div>';
      inner.innerHTML = thumbHtml + '<div class="tv-play-overlay" id="tv-play-overlay"><div class="tv-play-circle"><div class="tv-play-tri"></div></div></div>';
      document.getElementById('tv-play-overlay')?.addEventListener('click', function(){ tvLoadVideo(tvVidIdx); });
    }
  }
};
})();
</script>
@endpush

@endif
{{-- END THU VIEN --}}

{{-- THONG TIN CHI TIET --}}
<section class="section" id="thong-tin" style="padding:0;">
  <div class="info-cta" style="position:relative;overflow:hidden;padding:100px 60px;background:#0d0d0f;">
    @php
      $index = ($car->id % 4) + 1;
      $extensions = ['png', 'jpeg', 'jpg'];
      $image = null;
      foreach ($extensions as $ext) {
          $path = "images/car/Banner{$index}.{$ext}";
          if (file_exists(public_path($path))) { $image = $path; break; }
      }
    @endphp
   <div style="position:absolute;inset:0;background:url('{{ asset($image) }}') center/cover no-repeat;opacity:1;"></div>
<div style="position:absolute;inset:0;background:linear-gradient(to bottom, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.5) 100%);"></div>
    <div style="position:relative;z-index:1;">
      <div class="info-cta-title">Thông Tin Chi Tiết</div>
      <div class="info-cta-btns">
        <a href="{{ route('services.booking') }}" class="info-cta-btn">Đặt xe ngay →</a>
        <a href="{{ route('cars.compare') }}" class="info-cta-btn">So sánh sản phẩm →</a>
      </div>
    </div>
  </div>
</section>

{{-- XE LIEN QUAN --}}
@if($relatedCars->count())
<section class="section section-alt" id="so-sanh" style="padding: 0;">
  <div class="container" style="padding-top: 24px; padding-bottom: 16px;">
    <div class="section-label">Cùng hãng</div>
    <div class="section-title">Xe <em>Liên Quan</em></div>
  </div>
  <div class="related-grid">
    @foreach($relatedCars as $related)
      @php
        $rc = $related->colors->firstWhere('is_default',true) ?? $related->colors->first();
        $ri = carImgPath($rc?->image ?? null);
        if (!$ri) $ri = carImgPath($related->image_url ?? null);
        if (!$ri) {
            $rg = $related->galleries->where('type','image')
                    ->filter(fn($g) => str_contains($g->file_path ?? '', '-TN'))
                    ->sortBy('sort_order')->first();
            $ri = carImgPath($rg?->file_path ?? null);
        }
        if (!$ri) {
            $rg = $related->galleries->where('type','image')->sortBy('sort_order')->first();
            $ri = carImgPath($rg?->file_path ?? null);
        }
      @endphp
      <a href="{{ route('cars.show',$related->id) }}" class="related-card">
        @if($ri)
          <img class="related-img" src="{{ $ri }}" alt="{{ $related->name }}"
               onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
          <div style="height:160px;background:var(--bg3);display:none;align-items:center;justify-content:center;"><span style="font-family:'Barlow Condensed',sans-serif;font-size:13px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.15);">{{ $related->name }}</span></div>
        @else
          <div style="height:160px;background:var(--bg3);display:flex;align-items:center;justify-content:center;"><span style="font-family:'Barlow Condensed',sans-serif;font-size:13px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.15);">{{ $related->name }}</span></div>
        @endif
        <div class="related-body">
          <div class="related-brand">{{ $related->brand?->name ?? $related->brand }}</div>
          <div class="related-name">{{ $related->name }}</div>
          <div class="related-price">{{ number_format($related->price_per_day ?? $related->price) }}<small>VNĐ</small></div>
        </div>
      </a>
    @endforeach
  </div>
</section>
@endif

@endsection

@push('scripts')
<script>
(function(){
'use strict';

/* ══════════════════════════════════════════════
   360° VIEWER
══════════════════════════════════════════════ */
(function(){
  var wrap = document.getElementById('car360wrap');
  if (!wrap) return;

  var frames = [];
  try { frames = JSON.parse(wrap.dataset.frames || '[]'); } catch(e) { return; }
  if (frames.length < 2) return;

  var img      = document.getElementById('car360img');
  var dotsWrap = document.getElementById('car360dots');
  var fillEl   = document.getElementById('car360fill');
  var autoBtn  = document.getElementById('car360autoBtn');
  var iconPlay = document.getElementById('car360iconPlay');
  var iconPause= document.getElementById('car360iconPause');
  var hintEl   = document.getElementById('car360hint');

  var total        = frames.length;
  var curIdx       = 0;
  var autoPlay     = true;
  var autoTimer    = null;
  var isDrag       = false;
  var dragStartX   = 0;
  var dragStartIdx = 0;
  var sensitivity  = Math.max(1, Math.round(280 / total));

  // Preload
  frames.forEach(function(src){ new Image().src = src; });

  function showFrame(idx) {
    curIdx = ((idx % total) + total) % total;
    if (img) img.src = frames[curIdx];
    if (dotsWrap) {
      dotsWrap.querySelectorAll('span').forEach(function(d, i){
        d.classList.toggle('active', i === curIdx);
      });
    }
    if (fillEl) fillEl.style.width = (total > 1 ? (curIdx / (total-1)) * 100 : 100) + '%';
  }

  function startAuto() {
    clearInterval(autoTimer);
    autoPlay = true;
    if (iconPlay)  iconPlay.style.display  = 'none';
    if (iconPause) iconPause.style.display = '';
    autoTimer = setInterval(function(){ showFrame(curIdx + 1); }, 120);
  }

  function stopAuto() {
    clearInterval(autoTimer);
    autoTimer = null;
    autoPlay  = false;
    if (iconPlay)  iconPlay.style.display  = '';
    if (iconPause) iconPause.style.display = 'none';
  }

  // ── Listener colorchange (từ change360Color) ──
  wrap.addEventListener('colorchange', function(e) {
    var newFrames = e.detail && e.detail.frames;
    if (!newFrames || newFrames.length < 2) return;

    newFrames.forEach(function(src){ new Image().src = src; });

    frames      = newFrames;
    total       = newFrames.length;
    curIdx      = 0;
    sensitivity = Math.max(1, Math.round(280 / total));

    if (dotsWrap) {
      dotsWrap.innerHTML = '';
      newFrames.forEach(function(_, i){
        var s = document.createElement('span');
        if (i === 0) s.classList.add('active');
        dotsWrap.appendChild(s);
      });
    }

    showFrame(0);
    if (autoPlay) startAuto();
  });

  // ── Events ──
  if (autoBtn) {
    autoBtn.addEventListener('click', function(e){
      e.preventDefault(); e.stopPropagation();
      autoPlay ? stopAuto() : startAuto();
    });
  }

  wrap.addEventListener('mousedown', function(e){
    if (e.target === autoBtn || autoBtn?.contains(e.target)) return;
    stopAuto();
    isDrag = true; dragStartX = e.clientX; dragStartIdx = curIdx;
    e.preventDefault();
  });
  window.addEventListener('mousemove', function(e){
    if (!isDrag) return;
    showFrame(dragStartIdx + Math.round((dragStartX - e.clientX) / sensitivity));
  });
  window.addEventListener('mouseup', function(){ isDrag = false; });

  wrap.addEventListener('touchstart', function(e){
    if (e.target === autoBtn || autoBtn?.contains(e.target)) return;
    stopAuto();
    isDrag = true; dragStartX = e.touches[0].clientX; dragStartIdx = curIdx;
  }, { passive: true });
  wrap.addEventListener('touchmove', function(e){
    if (!isDrag) return;
    showFrame(dragStartIdx + Math.round((dragStartX - e.touches[0].clientX) / sensitivity));
  }, { passive: true });
  wrap.addEventListener('touchend', function(){ isDrag = false; });

  wrap.addEventListener('wheel', function(e){
    e.preventDefault(); stopAuto();
    showFrame(curIdx + (e.deltaY > 0 ? 1 : -1));
  }, { passive: false });

  wrap.addEventListener('mouseenter', function(){
    if (autoPlay) clearInterval(autoTimer);
  });
  wrap.addEventListener('mouseleave', function(){
    if (autoPlay && !isDrag) startAuto();
  });

  if (hintEl) {
    setTimeout(function(){
      hintEl.style.opacity = '0';
      setTimeout(function(){ hintEl.style.display = 'none'; }, 500);
    }, 3500);
  }

  showFrame(0);
  startAuto();

})();

// ── change360Color: gọi từ color picker ──
window.change360Color = function(newFrames, staticImg, has360, el) {
  if (has360 && newFrames.length >= 2) {
    // VF3/VF7: đổi frames 360°
    newFrames.forEach(function(src){ new Image().src = src; });
    var wrap = document.getElementById('car360wrap');
    if (wrap) wrap.dispatchEvent(new CustomEvent('colorchange', { detail: { frames: newFrames } }));
  } else {
    // VF5/6/8/9: đổi ảnh tĩnh
    var staticEl = document.getElementById('vinStaticImg');
    if (staticEl && staticImg) staticEl.src = staticImg;
  }
  document.querySelectorAll('.color-picker-360-item').forEach(function(b){ b.classList.remove('active360'); });
  if (el) el.classList.add('active360');
};

/* ══════════════════════════════════════════════
   STICKY NAV
══════════════════════════════════════════════ */
var wrap2  = document.getElementById('detail-sticky-wrap');
var nav2   = document.getElementById('detail-nav');
var links  = Array.from(nav2?.querySelectorAll('a.nav-link') || []);

function getHeaderH() {
  var h = 0;
  document.querySelectorAll('header,#header,.site-header,.navbar,.main-header').forEach(function(el) {
    if (el === wrap2 || el.contains(wrap2)) return;
    var r = el.getBoundingClientRect();
    if (r.top <= 1 && r.height > 10) h = Math.max(h, Math.round(r.bottom));
  });
  return h;
}
function applyTop() { if (wrap2) wrap2.style.top = (getHeaderH() || 0) + 'px'; }
applyTop();
[100,300,600,1000,2000].forEach(function(t){ setTimeout(applyTop, t); });
window.addEventListener('resize', applyTop);
window.addEventListener('load',   applyTop);

links.forEach(function(a) {
  a.addEventListener('click', function(e) {
    e.preventDefault(); e.stopPropagation();
    var old = this.querySelector('.ripple'); if (old) old.remove();
    var rect = this.getBoundingClientRect(),
        size = Math.max(rect.width, rect.height) * 2,
        rip  = document.createElement('span');
    rip.className = 'ripple';
    rip.style.cssText = 'width:'+size+'px;height:'+size+'px;left:'+(e.clientX-rect.left-size/2)+'px;top:'+(e.clientY-rect.top-size/2)+'px;';
    this.appendChild(rip);
    setTimeout(function(){ rip.remove(); }, 700);

    links.forEach(function(l){ l.classList.remove('active'); });
    this.classList.add('active');

    var target = document.getElementById(this.getAttribute('href').slice(1));
    if (!target) return;
    var wrapH = wrap2 ? wrap2.offsetHeight : 0;
    var top   = target.getBoundingClientRect().top + window.scrollY - (parseInt(wrap2?.style.top)||0) - wrapH - 8;
    window.scrollTo({ top: top, behavior: 'smooth' });

    var cat = this.dataset.cat;
    if (cat) setTimeout(function() {
      var btn = document.querySelector('.specs-cat-fixed[data-cat="'+cat+'"]');
      if (btn && btn.classList.contains('collapsed')) window.toggleSpecsCat(cat);
    }, 550);
  });
});

var sIds = ['gia-mau-sac','tinh-nang','thong-so','thu-vien','thong-tin','so-sanh'];
function updateNav() {
  var wrapH = wrap2 ? wrap2.offsetHeight : 0;
  var off   = (parseInt(wrap2?.style.top)||0) + wrapH + 32;
  var active = sIds[0];
  sIds.forEach(function(id) {
    var el = document.getElementById(id);
    if (el && window.scrollY >= el.offsetTop - off) active = id;
  });
  links.forEach(function(l) {
    var h = l.getAttribute('href').slice(1);
    l.classList.toggle('active', h === active && !l.dataset.cat);
  });
}
var tick = false;
window.addEventListener('scroll', function() {
  if (!tick) { tick = true; requestAnimationFrame(function(){ updateNav(); tick = false; }); }
}, { passive: true });
setTimeout(updateNav, 400);
window.addEventListener('load', updateNav);

/* ══════════════════════════════════════════════
   FEATURE REVEAL
══════════════════════════════════════════════ */
var obs = new IntersectionObserver(function(entries) {
  entries.forEach(function(e) {
    if (e.isIntersecting) { e.target.classList.add('in-view'); obs.unobserve(e.target); }
  });
}, { threshold: .08 });
document.querySelectorAll('.feature-slide').forEach(function(s){ obs.observe(s); });

/* ══════════════════════════════════════════════
   SPECS TOGGLE
══════════════════════════════════════════════ */
window.toggleSpecsCat = function(slug) {
  var btn = document.querySelector('.specs-cat-fixed[data-cat="'+slug+'"]');
  if (btn) btn.classList.toggle('collapsed');
  document.querySelectorAll('.specs-row-group[data-cat-rows="'+slug+'"]').forEach(function(g){ g.classList.toggle('collapsed'); });
  document.querySelectorAll('.specs-cat-spacer[data-cat="'+slug+'"]').forEach(function(s){
    s.style.display = btn?.classList.contains('collapsed') ? 'none' : '';
  });
};

/* ══════════════════════════════════════════════
   FEATURE MODAL + SLIDER
══════════════════════════════════════════════ */
var mIdx = 0, mSrcs = [];
function updateSlider() {
  var track = document.getElementById('modal-slider-track');
  var dots  = document.getElementById('modal-slider-dots');
  var fill  = document.getElementById('progress-fill');
  var cnt   = document.getElementById('progress-count');
  if (track) track.style.transform = 'translateX(-'+(mIdx*100)+'%)';
  if (dots)  Array.from(dots.querySelectorAll('.dot')).forEach(function(d,i){ d.classList.toggle('active', i===mIdx); });
  if (fill)  fill.style.width = mSrcs.length > 1 ? ((mIdx+1)/mSrcs.length*100)+'%' : '100%';
  if (cnt)   cnt.textContent  = (mIdx+1)+' / '+mSrcs.length;
}
window.sliderMove = function(dir) {
  if (mSrcs.length <= 1) return;
  mIdx = (mIdx + dir + mSrcs.length) % mSrcs.length;
  updateSlider();
};
document.getElementById('progress-track')?.addEventListener('click', function(e) {
  if (mSrcs.length <= 1) return;
  mIdx = Math.min(Math.floor(e.offsetX / this.offsetWidth * mSrcs.length), mSrcs.length-1);
  updateSlider();
});
var tx = 0;
var sliderEl = document.getElementById('modal-slider');
sliderEl?.addEventListener('touchstart', function(e){ tx = e.touches[0].clientX; }, { passive: true });
sliderEl?.addEventListener('touchend',   function(e){ if (Math.abs(e.changedTouches[0].clientX-tx)>40) window.sliderMove(e.changedTouches[0].clientX < tx ? 1 : -1); }, { passive: true });

window.openFeatureModal = function(slide) {
  document.getElementById('modal-badge').textContent = slide.dataset.badge;
  document.getElementById('modal-title').textContent = slide.dataset.title;
  document.getElementById('modal-desc').textContent  = slide.dataset.desc;
  mSrcs = [slide.dataset.img, slide.dataset.img2].filter(Boolean); mIdx = 0;
  var track = document.getElementById('modal-slider-track');
  track.innerHTML = ''; track.style.transform = 'translateX(0)';
  mSrcs.forEach(function(src) {
    var w = document.createElement('div'); w.className = 'modal-slide';
    var im = document.createElement('img'); im.src = src; im.alt = '';
    w.appendChild(im); track.appendChild(w);
  });
  var dots = document.getElementById('modal-slider-dots'); dots.innerHTML = '';
  mSrcs.forEach(function(_, i) {
    var d = document.createElement('span');
    d.className = 'dot' + (i===0 ? ' active' : '');
    d.onclick = function(){ mIdx = i; updateSlider(); };
    dots.appendChild(d);
  });
  document.getElementById('modal-slider').classList.toggle('single', mSrcs.length <= 1);
  updateSlider();
  var bd = document.getElementById('feature-modal-backdrop'); if (!bd) return;
  bd.style.display = 'flex'; document.body.style.overflow = 'hidden';
  requestAnimationFrame(function(){ bd.classList.add('visible'); });
};
window.closeFeatureModal = function() {
  var bd = document.getElementById('feature-modal-backdrop'); if (!bd) return;
  bd.classList.remove('visible');
  setTimeout(function(){ bd.style.display = 'none'; document.body.style.overflow = ''; }, 300);
};
document.getElementById('feature-modal-backdrop')?.addEventListener('click', function(e){
  if (e.target === this) window.closeFeatureModal();
});
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape')     window.closeFeatureModal();
  if (e.key === 'ArrowLeft')  window.sliderMove(-1);
  if (e.key === 'ArrowRight') window.sliderMove(1);
});

})();
</script>
@endpush