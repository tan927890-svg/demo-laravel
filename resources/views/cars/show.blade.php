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
.car-hero-overlay { position: absolute; inset: 0; background: linear-gradient(90deg,rgba(0,0,0,.75) 0%,rgba(0,0,0,.2) 60%,transparent 100%); }
.car-hero-content { position: absolute; bottom: 0; left: 0; right: 0; padding: 0 80px 60px; display: flex; align-items: flex-end; justify-content: space-between; }
.car-hero-eyebrow { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 4px; text-transform: uppercase; color: var(--red); margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
.car-hero-eyebrow::before { content: ''; width: 28px; height: 1px; background: var(--red); }
.car-hero-name { font-family: 'Barlow Condensed', sans-serif; font-size: clamp(52px,7vw,90px); font-weight: 900; color: var(--white); text-transform: uppercase; letter-spacing: -2px; line-height: .9; animation: slide-up .7s cubic-bezier(.22,1,.36,1) both; }
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
/* ── [THÊM MỚI] 2 status class ── */
.status-out-of-stock {
  background: rgba(212,43,43,.15);
  border: 1px solid rgba(212,43,43,.4);
  color: #f87171;
}
.status-coming-soon {
  background: rgba(234,179,8,.15);
  border: 1px solid rgba(234,179,8,.4);
  color: #fbbf24;
}
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
.color-preview { position: relative; display: flex; align-items: center; justify-content: center; min-height: 400px; background: transparent; }
.color-preview-watermark { position: absolute; top: 10px; right: 0; font-family: 'Barlow Condensed', sans-serif; font-size: clamp(52px,8vw,100px); font-weight: 900; text-transform: uppercase; letter-spacing: -3px; color: rgba(0,0,0,.05); line-height: 1; pointer-events: none; user-select: none; white-space: nowrap; }
.color-preview-img { width: 100%; max-height: 460px; object-fit: contain; display: block; transition: opacity .4s ease; filter: drop-shadow(0 28px 56px rgba(0,0,0,.22)) drop-shadow(0 8px 20px rgba(0,0,0,.12)); position: relative; z-index: 1; background: transparent; }

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

/* ── THU VIEN MỚI ── */
.tv-section { background: #000; padding: 64px 0; }
.tv-head { text-align: center; margin-bottom: 24px; }
.tv-head-title { font-family: 'Barlow Condensed', sans-serif; font-size: clamp(28px,4vw,44px); font-weight: 900; text-transform: uppercase; font-style: italic; letter-spacing: 2px; color: #fff; }
.tv-head-title em { color: #c00; font-style: normal; }
.tv-tabs { display: flex; justify-content: center; gap: 0; border-bottom: 1px solid rgba(255,255,255,0.12); margin-bottom: 0; }
.tv-tab { background: none; border: none; color: rgba(255,255,255,.45); font-family: 'Barlow Condensed', sans-serif; font-size: 16px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 10px 32px 14px; cursor: pointer; border-bottom: 3px solid transparent; position: relative; top: 1px; transition: color .2s, border-color .2s; }
.tv-tab.active { color: #fff; border-bottom-color: #fff; }
.tv-tab:hover:not(.active) { color: rgba(255,255,255,.75); }

/* PHOTO */
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

/* VIDEO */
.tv-video { display: none; padding: 32px 60px 0; }
.tv-video.tv-active { display: block; }
.tv-video-wrap { max-width: 900px; margin: 0 auto 16px; }
.tv-video-main { position: relative; background: #000; cursor: pointer; overflow: hidden; }
.tv-video-main img { width: 100%; display: block; aspect-ratio: 16/9; object-fit: cover; }
.tv-video-main iframe,
.tv-video-main video { width: 100%; display: block; aspect-ratio: 16/9; border: none; background: #000; }
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
}

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
      <!-- @if($hasBattery) <a href="#thong-so" class="nav-link" data-cat="pin-sac">Pin & Sạc</a>@endif -->
      <!-- @if($hasOffroad) <a href="#thong-so" class="nav-link" data-cat="dia-hinh">Địa hình</a>@endif -->
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
  $bannerNum = ($car->id % 7) + 1;
  $base = 'images/car/Banner' . $bannerNum;

  if (file_exists(public_path($base . '.png'))) {
      $heroSrc = asset($base . '.png');
  } elseif (file_exists(public_path($base . '.jpg'))) {
      $heroSrc = asset($base . '.jpg');
  } elseif (file_exists(public_path($base . '.jpeg'))) {
      $heroSrc = asset($base . '.jpeg');
  } else {
      $heroSrc = '';
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
      {{-- ① [SỬA] $statusMap mở rộng thêm out_of_stock & coming_soon --}}
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
      <div class="color-preview">
        <div class="color-preview-watermark">{{ $car->name }}</div>
        @php
          $previewImg = carImgPath($car->image_url ?? null);
          if (!$previewImg) {
              $defaultColor = $car->colors->firstWhere('is_default', true) ?? $car->colors->first();
              $previewImg = carImgPath($defaultColor?->image ?? null);
          }
          if (!$previewImg) {
              $fg = $car->galleries->where('type','image')
                      ->filter(fn($g) => str_contains($g->file_path ?? '', 'images/car/'))
                      ->sortBy('sort_order')->first();
              $previewImg = carImgPath($fg?->file_path ?? null);
          }
        @endphp
        @if($previewImg)
          <img class="color-preview-img" src="{{ $previewImg }}" alt="{{ $car->name }}">
        @else
          <div style="font-family:'Barlow Condensed',sans-serif;font-size:clamp(24px,3vw,40px);font-weight:900;letter-spacing:2px;text-transform:uppercase;color:rgba(0,0,0,.15);text-align:center;padding:60px 0;">{{ $car->name }}</div>
        @endif
      </div>
    </div>
  </div>
</section>

{{-- TINH NANG NOI BAT --}}
@if($car->features->count())
<section class="features-section" id="tinh-nang">
  <div class="features-snap-wrap">
    @php
      $uniqueFeatures = $car->features->unique('id')->sortBy('sort_order')->values();
    @endphp
    @foreach($uniqueFeatures as $feature)
      @php
        $rawImg1   = !empty(trim($feature->image ?? '')) ? $feature->image : 'images/CTN/TN.png';
        $modalImg1 = carImgPath(!empty(trim($feature->image ?? ''))  ? $feature->image  : null);
        $modalImg2 = carImgPath(!empty(trim($feature->image2 ?? '')) ? $feature->image2 : null);
        if (!$modalImg2) {
            $nextF = $uniqueFeatures->get($loop->index + 1);
            if ($nextF && !empty(trim($nextF->image ?? '')) && str_contains($nextF->image, 'NT '))
                $modalImg2 = carImgPath($nextF->image);
        }
        $featImg1    = carImgPath($rawImg1);
        $isReverse   = $loop->index % 2 === 1;
        $badgeText   = 'TÍNH NĂNG NỔI BẬT';
        $variantText = $feature->variant?->name ? 'Phiên bản ' . $feature->variant->name : '';
        $num         = str_pad($loop->iteration, 2, '0', STR_PAD_LEFT);
        $showNum     = $loop->iteration <= 3;
      @endphp
      <div class="feature-slide {{ $isReverse ? 'reverse' : '' }}"
           data-title="{{ $feature->title }}" data-desc="{{ $feature->description }}"
           data-badge="{{ $badgeText }}" data-variant="{{ $variantText }}"
           data-img="{{ $modalImg1 ?? '' }}" data-img2="{{ $modalImg2 ?? '' }}">
        <div class="feature-slide-body">
          <div class="feature-slide-number {{ !$showNum ? 'hide-num' : '' }}">{{ $num }}</div>
          <div class="feature-slide-badge">{{ $badgeText }}</div>
          @if($variantText)<div class="feature-slide-variant">{{ $variantText }}</div>@endif
          <div class="feature-slide-title">{{ $feature->title }}</div>
          <div class="feature-slide-desc">{{ $feature->description }}</div>
          <button class="btn-feature-detail" onclick="openFeatureModal(this.closest('.feature-slide'))">
            <span>XEM CHI TIẾT →</span>
          </button>
        </div>
        <div class="feature-slide-imgs">
          <div class="img-slot">
            @if($featImg1)
              <img src="{{ $featImg1 }}" alt="{{ $feature->title }}" loading="lazy"
                   onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
              <div class="img-slot-no-img" style="display:none;">
                <svg class="img-slot-no-img-icon" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                <span class="img-slot-no-img-text">{{ $car->name }}</span>
              </div>
            @else
              <div class="img-slot-no-img">
                <svg class="img-slot-no-img-icon" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
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

{{-- ===== THU VIEN ANH & VIDEO ===== --}}
@if($car->galleries->count())
@php
  $imageGalleries = $car->galleries->where('type','image')->sortBy('sort_order')->values();
  $videoGalleries = $car->galleries->where('type','video')->sortBy('sort_order')->values();

  /* Danh sách URL ảnh đã encode đúng đường dẫn CTN */
  $tvImgUrls = $imageGalleries->map(fn($g) => carImgPath($g->file_path ?? null))->filter()->values();

  /* Danh sách video: src + thumbnail */
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

  {{-- TIÊU ĐỀ --}}
  <div class="tv-head">
    <div class="tv-head-title"><em id="tv-title-em">Thư Viện</em>&nbsp;<span id="tv-title-word">Ảnh</span></div>
  </div>

  {{-- TABS --}}
  <div class="tv-tabs">
    @if($hasPhoto)
      <button class="tv-tab tv-active" onclick="tvSwitch('photo',this)">Ảnh</button>
    @endif
    @if($hasVideo)
      <button class="tv-tab {{ !$hasPhoto ? 'tv-active' : '' }}" onclick="tvSwitch('video',this)">Video</button>
    @endif
  </div>

  {{-- ===== PHOTO ===== --}}
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
          <img src="{{ $url }}" alt=""
               onerror="this.closest('.tv-thumb').style.display='none';">
        </div>
      @endforeach
    </div>

</div>
@endif

  {{-- ===== VIDEO ===== --}}
  @if($hasVideo)
  <div class="tv-video {{ !$hasPhoto ? 'tv-active' : '' }}" id="tv-video">
    <div class="tv-video-wrap">

      {{-- Player chính --}}
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

      {{-- Thumbnails video (nếu có nhiều hơn 1) --}}
      @if($tvVideos->count() > 1)
      <div class="tv-vthumbs" style="margin-top:10px;">
        @foreach($tvVideos as $vi => $vid)
          <div class="tv-vthumb {{ $vi === 0 ? 'tv-vthumb-active' : '' }}" onclick="tvSelectVideo({{ $vi }},this)">
            @if($vid['thumb'])
              <img src="{{ $vid['thumb'] }}" alt=""
                   onerror="this.closest('.tv-vthumb').style.background='#222';this.style.display='none';">
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
var tvIdx     = 0;
var tvVidIdx  = 0;

/* ── Khởi tạo display ban đầu ── */
(function(){
  var photoEl = document.getElementById('tv-photo');
  var videoEl = document.getElementById('tv-video');
  if (photoEl) photoEl.style.display = 'block';
  if (videoEl) videoEl.style.display = 'none';
})();

/* ── DATA TỪ BLADE ── */
var TV_IMGS   = @json($tvImgUrls->values());
var TV_VIDEOS = @json($tvVideos->values());
var tvIdx     = 0;
var tvVidIdx  = 0;

/* ══ PHOTO ══ */
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

window.tvGoTo = function(i) {
  tvIdx = i;
  tvUpdateGrid();
};

window.tvThumbClick = function(slotOffset) {
  tvIdx = (tvIdx + slotOffset) % TV_IMGS.length;
  tvUpdateGrid();
};

/* ══ VIDEO ══ */
function tvLoadVideo(idx) {
  var vid = TV_VIDEOS[idx];
  if (!vid) return;
  var inner = document.getElementById('tv-player-inner');
  if (!inner) return;

  var src = vid.src || '';

  /* YouTube */
  var ytMatch = src.match(/(?:youtu\.be\/|[?&]v=)([A-Za-z0-9_-]{11})/);
  if (ytMatch) {
    inner.innerHTML = '<iframe src="https://www.youtube.com/embed/'+ytMatch[1]+'?autoplay=1&rel=0" allowfullscreen allow="autoplay;fullscreen" style="width:100%;aspect-ratio:16/9;border:none;display:block;background:#000;"></iframe>';
    return;
  }

  /* Vimeo */
  var vmMatch = src.match(/vimeo\.com\/(\d+)/);
  if (vmMatch) {
    inner.innerHTML = '<iframe src="https://player.vimeo.com/video/'+vmMatch[1]+'?autoplay=1" allowfullscreen allow="autoplay;fullscreen" style="width:100%;aspect-ratio:16/9;border:none;display:block;background:#000;"></iframe>';
    return;
  }

  /* File mp4/webm local */
  if (/\.(mp4|webm|ogg)$/i.test(src)) {
    inner.innerHTML = '<video src="'+src+'" controls autoplay playsinline style="width:100%;aspect-ratio:16/9;display:block;background:#000;"></video>';
    return;
  }

  /* Fallback: chỉ show thumbnail */
  if (vid.thumb) {
    inner.innerHTML = '<img src="'+vid.thumb+'" style="width:100%;aspect-ratio:16/9;object-fit:cover;display:block;">'
      + '<div class="tv-play-overlay"><div class="tv-play-circle"><div class="tv-play-tri"></div></div></div>';
    document.querySelector('#tv-player-inner .tv-play-overlay')?.addEventListener('click', function(){ tvLoadVideo(tvVidIdx); });
  }
}

window.tvSelectVideo = function(idx, el) {
  tvVidIdx = idx;
  document.querySelectorAll('.tv-vthumb').forEach(function(t){ t.classList.remove('tv-vthumb-active'); });
  el.classList.add('tv-vthumb-active');

  /* Reset player về thumbnail trước khi load */
  var vid = TV_VIDEOS[idx];
  var inner = document.getElementById('tv-player-inner');
  if (inner && vid) {
    var thumbHtml = vid.thumb
      ? '<img src="'+vid.thumb+'" alt="" style="width:100%;aspect-ratio:16/9;object-fit:cover;display:block;">'
      : '<div class="tv-no-thumb"><span class="tv-no-thumb-txt">Video</span></div>';
    inner.innerHTML = thumbHtml + '<div class="tv-play-overlay" id="tv-play-overlay"><div class="tv-play-circle"><div class="tv-play-tri"></div></div></div>';
    document.getElementById('tv-play-overlay')?.addEventListener('click', function(){ tvLoadVideo(tvVidIdx); });
  }
};

/* ── Gắn sự kiện play ban đầu ── */
document.getElementById('tv-play-overlay')?.addEventListener('click', function(){
  tvLoadVideo(tvVidIdx);
});

/* ══ SWITCH TAB ══ */
window.tvSwitch = function(tab, btn) {
  document.querySelectorAll('.tv-tab').forEach(function(b){ b.classList.remove('tv-active'); });
  btn.classList.add('tv-active');

  var photoEl = document.getElementById('tv-photo');
  var videoEl = document.getElementById('tv-video');
  var word    = document.getElementById('tv-title-word');

  if (photoEl) { photoEl.style.display = tab === 'photo' ? 'block' : 'none'; }
  if (videoEl) { videoEl.style.display = tab === 'video' ? 'block' : 'none'; }
  if (word)    word.textContent = tab === 'photo' ? 'Ảnh' : 'Video';

  /* Dừng video khi chuyển tab */
  if (tab === 'photo') {
    var inner = document.getElementById('tv-player-inner');
    var vid   = TV_VIDEOS[tvVidIdx];
    if (inner && vid) {
      var thumbHtml = vid.thumb
        ? '<img src="'+vid.thumb+'" alt="" style="width:100%;aspect-ratio:16/9;object-fit:cover;display:block;">'
        : '<div class="tv-no-thumb"><span class="tv-no-thumb-txt">Video</span></div>';
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
        if (file_exists(public_path($path))) {
            $image = $path;
            break;
        }
    }
@endphp
 <div style="position:absolute; inset:0;
        background:url('{{ asset($image) }}') center/cover no-repeat;
        opacity:0.80;">
    </div>
    <div style="position:relative;z-index:1;">
      <div class="info-cta-title">Thông Tin Chi Tiết</div>
      <div class="info-cta-btns">
        <a href="{{ route('orders.create', $car) }}" class="info-cta-btn">Đặt xe ngay →</a>
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

/* ── Sticky offset theo header ── */
const wrap  = document.getElementById('detail-sticky-wrap');
const nav   = document.getElementById('detail-nav');
const links = Array.from(nav?.querySelectorAll('a.nav-link') || []);

function getHeaderH() {
  let h = 0;
  document.querySelectorAll('header,#header,.site-header,.navbar,.main-header').forEach(el => {
    if (el === wrap || el.contains(wrap)) return;
    const r = el.getBoundingClientRect();
    if (r.top <= 1 && r.height > 10) h = Math.max(h, Math.round(r.bottom));
  });
  return h;
}
function applyTop() { if (wrap) wrap.style.top = (getHeaderH() || 0) + 'px'; }
applyTop();
[100, 300, 600, 1000, 2000].forEach(t => setTimeout(applyTop, t));
window.addEventListener('resize', applyTop);
window.addEventListener('load',   applyTop);

/* ── Nav click + ripple ── */
links.forEach(a => {
  a.addEventListener('click', function(e) {
    e.preventDefault(); e.stopPropagation();
    const old = this.querySelector('.ripple'); if (old) old.remove();
    const rect = this.getBoundingClientRect(),
          size = Math.max(rect.width, rect.height) * 2,
          rip  = document.createElement('span');
    rip.className = 'ripple';
    rip.style.cssText = `width:${size}px;height:${size}px;left:${e.clientX-rect.left-size/2}px;top:${e.clientY-rect.top-size/2}px;`;
    this.appendChild(rip); setTimeout(() => rip.remove(), 700);

    links.forEach(l => l.classList.remove('active'));
    this.classList.add('active');

    const target = document.getElementById(this.getAttribute('href').slice(1));
    if (!target) return;
    const wrapH = wrap ? wrap.offsetHeight : 0;
    const top   = target.getBoundingClientRect().top + window.scrollY - (parseInt(wrap?.style.top) || 0) - wrapH - 8;
    window.scrollTo({ top, behavior: 'smooth' });

    const cat = this.dataset.cat;
    if (cat) setTimeout(() => {
      const btn = document.querySelector(`.specs-cat-fixed[data-cat="${cat}"]`);
      if (btn && btn.classList.contains('collapsed')) window.toggleSpecsCat(cat);
    }, 550);
  });
});

/* ── Active nav khi scroll ── */
const sIds = ['gia-mau-sac','tinh-nang','thong-so','thu-vien','thong-tin','so-sanh'];
function updateNav() {
  const wrapH = wrap ? wrap.offsetHeight : 0;
  const off   = (parseInt(wrap?.style.top) || 0) + wrapH + 32;
  let active  = sIds[0];
  sIds.forEach(id => {
    const el = document.getElementById(id);
    if (el && window.scrollY >= el.offsetTop - off) active = id;
  });
  links.forEach(l => {
    const h = l.getAttribute('href').slice(1);
    l.classList.toggle('active', h === active && !l.dataset.cat);
  });
}
let tick = false;
window.addEventListener('scroll', () => {
  if (!tick) { tick = true; requestAnimationFrame(() => { updateNav(); tick = false; }); }
}, { passive: true });
setTimeout(updateNav, 400);
window.addEventListener('load', updateNav);

/* ── Feature reveal ── */
const obs = new IntersectionObserver(en => {
  en.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in-view'); obs.unobserve(e.target); } });
}, { threshold: .08 });
document.querySelectorAll('.feature-slide').forEach(s => obs.observe(s));

/* ── Specs toggle ── */
window.toggleSpecsCat = function(slug) {
  const btn = document.querySelector(`.specs-cat-fixed[data-cat="${slug}"]`);
  if (btn) btn.classList.toggle('collapsed');
  document.querySelectorAll(`.specs-row-group[data-cat-rows="${slug}"]`).forEach(g => g.classList.toggle('collapsed'));
  document.querySelectorAll(`.specs-cat-spacer[data-cat="${slug}"]`).forEach(s => {
    s.style.display = btn?.classList.contains('collapsed') ? 'none' : '';
  });
};

/* ── Modal + Slider ── */
let idx = 0, srcs = [];
function updateSlider() {
  const track = document.getElementById('modal-slider-track');
  const dots  = document.getElementById('modal-slider-dots');
  const fill  = document.getElementById('progress-fill');
  const cnt   = document.getElementById('progress-count');
  if (track) track.style.transform = `translateX(-${idx * 100}%)`;
  if (dots)  Array.from(dots.querySelectorAll('.dot')).forEach((d,i) => d.classList.toggle('active', i === idx));
  if (fill)  fill.style.width = srcs.length > 1 ? ((idx+1)/srcs.length*100)+'%' : '100%';
  if (cnt)   cnt.textContent = `${idx+1} / ${srcs.length}`;
}
window.sliderMove = function(dir) {
  if (srcs.length <= 1) return;
  idx = (idx + dir + srcs.length) % srcs.length;
  updateSlider();
};
document.getElementById('progress-track')?.addEventListener('click', function(e) {
  if (srcs.length <= 1) return;
  idx = Math.min(Math.floor(e.offsetX / this.offsetWidth * srcs.length), srcs.length - 1);
  updateSlider();
});
let tx = 0;
const sliderEl = document.getElementById('modal-slider');
sliderEl?.addEventListener('touchstart', e => { tx = e.touches[0].clientX; }, { passive: true });
sliderEl?.addEventListener('touchend',   e => { if (Math.abs(e.changedTouches[0].clientX - tx) > 40) window.sliderMove(e.changedTouches[0].clientX < tx ? 1 : -1); }, { passive: true });

window.openFeatureModal = function(slide) {
  document.getElementById('modal-badge').textContent = slide.dataset.badge;
  document.getElementById('modal-title').textContent = slide.dataset.title;
  document.getElementById('modal-desc').textContent  = slide.dataset.desc;
  srcs = [slide.dataset.img, slide.dataset.img2].filter(Boolean); idx = 0;
  const track = document.getElementById('modal-slider-track');
  track.innerHTML = ''; track.style.transform = 'translateX(0)';
  srcs.forEach(src => {
    const w = document.createElement('div'); w.className = 'modal-slide';
    const img = document.createElement('img'); img.src = src; img.alt = '';
    w.appendChild(img); track.appendChild(w);
  });
  const dots = document.getElementById('modal-slider-dots'); dots.innerHTML = '';
  srcs.forEach((_,i) => {
    const d = document.createElement('span');
    d.className = 'dot' + (i === 0 ? ' active' : '');
    d.onclick = () => { idx = i; updateSlider(); };
    dots.appendChild(d);
  });
  document.getElementById('modal-slider').classList.toggle('single', srcs.length <= 1);
  updateSlider();
  const bd = document.getElementById('feature-modal-backdrop'); if (!bd) return;
  bd.style.display = 'flex'; document.body.style.overflow = 'hidden';
  requestAnimationFrame(() => bd.classList.add('visible'));
};
window.closeFeatureModal = function() {
  const bd = document.getElementById('feature-modal-backdrop'); if (!bd) return;
  bd.classList.remove('visible');
  setTimeout(() => { bd.style.display = 'none'; document.body.style.overflow = ''; }, 300);
};
document.getElementById('feature-modal-backdrop')?.addEventListener('click', function(e) { if (e.target === this) window.closeFeatureModal(); });
document.addEventListener('keydown', e => {
  if (e.key === 'Escape')     window.closeFeatureModal();
  if (e.key === 'ArrowLeft')  window.sliderMove(-1);
  if (e.key === 'ArrowRight') window.sliderMove(1);
});

})();
</script>
@endpush