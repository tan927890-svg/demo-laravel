@extends('layouts.frontend')

@section('title', 'Trang chủ')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,700;1,400&family=Didact+Gothic&family=Cormorant+Garamond:wght@300;400;600;700&display=swap');

/* ══════════════════════════════════════
   GLOBAL
══════════════════════════════════════ */
body {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-rendering: optimizeLegibility;
}

/* ══════════════════════════════════════
   HERO BANNER
══════════════════════════════════════ */
.banner-wrap {
    position: relative;
    width: 100%;
    height: 90vh;
    min-height: 600px;
    overflow: hidden;
    background: #0a0a0a;
}
.banner-track {
    display: flex;
    height: 100%;
    transition: transform 0.75s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    will-change: transform;
}
.banner-slide {
    flex: 0 0 100%;
    position: relative;
    height: 100%;
    overflow: hidden;
}
.banner-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center center;
    display: block;
}
.banner-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.12);
    pointer-events: none;
}

/* ══════════════════════════════════════
   SLIDE NUMBER NAV
══════════════════════════════════════ */
.banner-slide-nums {
    position: absolute;
    left: 36px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    flex-direction: column;
    gap: 6px;
    z-index: 10;
}
.banner-slide-num {
    display: flex;
    align-items: center;
    cursor: pointer;
    background: none;
    border: none;
    padding: 4px 0;
    gap: 0;
    transition: opacity 0.35s ease;
}
.banner-slide-num-text {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    font-weight: 400;
    color: rgba(255,255,255,0.45);
    line-height: 1;
    min-width: 36px;
    text-align: left;
    letter-spacing: 0.5px;
    text-shadow: 0 1px 6px rgba(0,0,0,0.6);
    transition: font-size 0.35s cubic-bezier(0.25,0.46,0.45,0.94),
                color 0.35s ease,
                font-weight 0.35s ease;
}
.banner-slide-num-line {
    display: block;
    width: 3px;
    height: 60px;
    background: rgba(201, 168, 76, 0.2);
    border-radius: 2px;
    margin-left: 10px;
    transition: background 0.4s ease;
    flex-shrink: 0;
}
.banner-slide-num.active .banner-slide-num-text {
    font-size: 34px;
    font-weight: 700;
    color: #ffffff;
    text-shadow: 0 2px 12px rgba(0,0,0,0.7);
}
.banner-slide-num.active .banner-slide-num-line {
    height: 38px;
    background: #c9a84c;
}
.banner-dots {
    position: absolute;
    bottom: 28px; left: 50%;
    transform: translateX(-50%);
    display: flex; gap: 8px; z-index: 10;
}
.banner-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: rgba(255,255,255,0.35);
    border: none; cursor: pointer;
    transition: all 0.3s; padding: 0;
}
.banner-dot.active {
    background: #c9a84c;
    width: 28px; border-radius: 4px;
}
.banner-counter {
    position: absolute;
    bottom: 28px; right: 28px;
    font-family: 'Didact Gothic', sans-serif;
    font-size: 12px; letter-spacing: 2.5px;
    color: rgba(255,255,255,0.45); z-index: 10;
}

@media (max-width: 768px) {
    .banner-wrap { height: 65vw; min-height: 320px; }
    .banner-slide-nums { left: 14px; gap: 2px; }
    .banner-slide-num-text { font-size: 14px; }
    .banner-slide-num.active .banner-slide-num-text { font-size: 24px; }
    .banner-slide-num.active .banner-slide-num-line { height: 40px; background: #ffffff; }
    .banner-slide-num-line { height: 40px; background: rgba(201,168,76,0.2); }
}

/* ══════════════════════════════════════
   WHY CHOOSE
══════════════════════════════════════ */
.why-section {
    background: #faf7f2;
    padding: 120px 0;
    position: relative;
    overflow: hidden;
}
.section-label {
    font-family: 'Didact Gothic', sans-serif;
    font-size: 15px; letter-spacing: 4px;
    text-transform: uppercase; color: #c9a84c;
    display: flex; align-items: center; gap: 14px;
    margin-bottom: 20px;
}
.section-label::before, .section-label::after {
    content: ''; display: inline-block;
    height: 1px; background: #c9a84c; opacity: 0.5;
}
.section-label::before { width: 30px; }
.section-label::after  { flex: 1; max-width: 60px; }
.section-heading {
    font-family: 'Playfair Display', serif;
    font-size: clamp(40px, 4.5vw, 64px);
    font-weight: 400; color: #1a1a1a;
    line-height: 1.12; margin: 0 0 16px;
    letter-spacing: -0.8px;
}
.section-heading em { font-style: italic; color: #9a6f28; }
.section-desc {
    font-family: 'Didact Gothic', sans-serif;
    font-size: 17px; line-height: 2;
    color: #5a5048; max-width: 480px;
}
.why-intro {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 48px; padding-bottom: 0;
}
.why-intro-left { flex-shrink: 0; }
.why-intro-right { padding-bottom: 6px; }
.why-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 32px; margin-top: 72px;
}
.why-pillar {
    background: transparent; padding: 0;
    position: relative; transition: transform 0.3s;
}
.why-pillar:hover { transform: translateY(-4px); }
.why-pillar-number { display: none; }
.why-pillar-icon {
    width: 100%; height: 180px;
    overflow: hidden; margin-bottom: 24px;
}
.why-pillar-icon img {
    width: 100%; height: 100%;
    object-fit: cover;
    filter: sepia(10%) brightness(0.9);
    transition: transform 0.5s ease, filter 0.4s;
}
.why-pillar:hover .why-pillar-icon img {
    transform: scale(1.05);
    filter: sepia(0%) brightness(1.0);
}
.why-pillar h5 {
    font-family: 'Playfair Display', serif;
    font-size: 22px; font-weight: 600;
    color: #1a1a1a; margin: 0 0 12px;
    letter-spacing: 0.1px;
}
.why-pillar p {
    font-family: 'Didact Gothic', sans-serif;
    font-size: 16px; line-height: 1.95;
    color: #5a5048; margin: 0;
}
.why-pillar-line {
    display: block; width: 32px; height: 2px;
    background: #c9a84c; margin-top: 20px;
    transition: width 0.4s ease;
}
.why-pillar:hover .why-pillar-line { width: 64px; }

/* ══════════════════════════════════════
   CAR FLEET
══════════════════════════════════════ */
.fleet-section { background: #fff; padding: 100px 0; }
.fleet-header {
    display: flex; align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 64px; padding: 0 80px; gap: 24px;
}
.fleet-view-all {
    font-family: 'Didact Gothic', sans-serif;
    font-size: 15px; letter-spacing: 3.5px;
    text-transform: uppercase; color: #9a6f28 !important;
    text-decoration: none; display: flex;
    align-items: center; gap: 10px; flex-shrink: 0;
    padding-bottom: 2px;
    border-bottom: 1px solid rgba(154,111,40,0.4);
    transition: gap 0.3s;
}
.fleet-view-all:hover { gap: 18px; }
.fleet-carousel-wrap { position: relative; padding: 0 80px; }
.fleet-carousel-track-outer { overflow: hidden; }
.fleet-carousel-track {
    display: flex; gap: 2px;
    transition: transform 0.65s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    will-change: transform;
}
.fleet-card {
    background: #fff; overflow: hidden;
    position: relative; cursor: pointer;
    text-decoration: none; display: block;
    transition: background 0.25s;
    flex: 0 0 calc(33.333% - 2px); min-width: 0;
}
.fleet-card-body { text-align: center; }
.fleet-card:hover { background: #faf7f2; }
.fleet-card-img {
    width: 100%; height: 220px;
    overflow: hidden; position: relative;
}
.fleet-card-img img {
    width: 100%; height: 100%;
    object-fit: cover; transition: transform 0.7s ease;
    filter: saturate(0.9);
}
.fleet-card:hover .fleet-card-img img {
    transform: scale(1.05); filter: saturate(1.0);
}
.fleet-card-overlay {
    position: absolute; inset: 0;
    background: rgba(10,10,10,0);
    display: flex; align-items: center; justify-content: center;
    transition: background 0.3s;
}
.fleet-card:hover .fleet-card-overlay { background: rgba(10,10,10,0.18); }
.fleet-card-overlay-btn {
    font-family: 'Didact Gothic', sans-serif;
    font-size: 11px; letter-spacing: 3px;
    text-transform: uppercase; color: #fff;
    border: 1px solid rgba(255,255,255,0.7);
    padding: 10px 24px; opacity: 0;
    transform: translateY(10px); transition: all 0.3s;
}
.fleet-card:hover .fleet-card-overlay-btn {
    opacity: 1; transform: translateY(0);
}
.fleet-card-body {
    padding: 24px 28px 28px;
    border-bottom: 1px solid #f0ebe1;
    position: relative;
}
.fleet-card-body::after {
    content: ''; position: absolute;
    bottom: -1px; left: 0; width: 0; height: 2px;
    background: #c9a84c; transition: width 0.4s ease;
}
.fleet-card:hover .fleet-card-body::after { width: 100%; }
.fleet-card-name {
    font-family: 'Playfair Display', serif;
    font-size: 22px; font-weight: 500;
    color: #040404; display: block;
    margin-bottom: 8px; letter-spacing: 0.2px;
}
.fleet-card-meta {
    font-family: 'Didact Gothic', sans-serif;
    font-size: 11px; letter-spacing: 1.5px;
    color: #fffefd; text-transform: uppercase;
    display: flex; gap: 16px; margin-bottom: 16px;
}
.fleet-card-price {
    font-family: 'Poppins', sans-serif;
    font-size: 24px; font-weight: 300;
    color: #837c27; letter-spacing: 0.5px;
}
.fleet-card-price small {
    font-family: 'Didact Gothic', sans-serif;
    font-size: 12px; letter-spacing: 1.5px;
    color: #aaa099; text-transform: uppercase; margin-left: 4px;
}
.fleet-nav {
    position: absolute; top: 50%; transform: translateY(-60%);
    width: 52px; height: 52px; background: #1a1a1a;
    border: none; cursor: pointer; display: flex;
    align-items: center; justify-content: center;
    z-index: 10; transition: background 0.25s; flex-shrink: 0;
}
.fleet-nav:hover { background: #c9a84c; }
.fleet-nav svg {
    width: 18px; height: 18px; stroke: #c9a84c;
    fill: none; stroke-width: 1.5; stroke-linecap: round;
    stroke-linejoin: round; transition: stroke 0.25s;
}
.fleet-nav:hover svg { stroke: #1a1a1a; }
.fleet-nav-prev { left: 12px; }
.fleet-nav-next { right: 12px; }
.fleet-dots {
    display: flex; justify-content: center;
    gap: 8px; margin-top: 36px;
}
.fleet-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: #e0d8c8; border: none; cursor: pointer;
    transition: all 0.3s; padding: 0;
}
.fleet-dot.active {
    background: #c9a84c; width: 24px; border-radius: 3px;
}

/* ══════════════════════════════════════
   VIDEO SECTION — PHONE FRAME
══════════════════════════════════════ */
.video-section {
    background: #ffffff;
    padding: 60px 0;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.phone-scene {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 72px;
    width: 100%;
    max-width: 1200px;
    padding: 0 40px;
    box-sizing: border-box;
}
.phone-side-text {
    flex: 1;
    max-width: 420px;
}
.phone-side-text .section-label { margin-bottom: 16px; }
.phone-side-text h3 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(32px, 3.5vw, 52px);
    font-weight: 400; color: #1a1a1a;
    margin: 0 0 20px; line-height: 1.2;
    letter-spacing: -0.5px;
}
.phone-side-text h3 em { font-style: italic; color: #9a6f28; }
.phone-side-text p {
    font-family: 'Didact Gothic', sans-serif;
    font-size: 16px; color: #5a5048;
    line-height: 2; margin: 0 0 36px;
}
.phone-cta {
    display: inline-flex; align-items: center; gap: 10px;
    border: 1px solid rgba(154,111,40,0.5);
    color: #9a6f28 !important; padding: 13px 32px;
    font-family: 'Didact Gothic', sans-serif;
    font-size: 12px; letter-spacing: 3px;
    text-transform: uppercase; text-decoration: none !important;
    transition: all 0.3s;
}
.phone-cta:hover {
    background: #c9a84c; border-color: #c9a84c;
    color: #fff !important; gap: 18px;
}
.phone-frame { position: relative; flex-shrink: 0; }

.phone-outer {
    position: relative;
    width: 360px;
    height: 700px;
    border-radius: 44px;
    background: linear-gradient(145deg, #2a2010, #1a1408);
    border: 3px solid #c9a84c;
    box-shadow:
        0 0 0 1px rgba(201,168,76,0.12),
        0 40px 80px rgba(0,0,0,0.18),
        0 8px 24px rgba(201,168,76,0.1);
    overflow: hidden;
}
.phone-notch {
    position: absolute;
    top: 0; left: 50%;
    transform: translateX(-50%);
    width: 100px; height: 28px;
    background: #111;
    border-radius: 0 0 18px 18px;
    z-index: 10;
}
.phone-screen {
    position: absolute;
    inset: 3px;
    border-radius: 42px;
    overflow: hidden;
    background: #000;
}
.phone-video-slot {
    position: absolute;
    inset: 0;
    display: none;
    background: #000;
}
.phone-video-slot.active { display: block; }
.phone-video-slot video {
    width: 100%; height: 100%;
    border: none; display: block;
    object-fit: cover;
}
.phone-video-slot iframe {
    width: 100%; height: 100%;
    border: none; display: block;
}
.phone-slot-badge {
    position: absolute;
    top: 48px; right: 14px;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    border: 1px solid rgba(201,168,76,0.4);
    border-radius: 20px;
    padding: 4px 10px;
    font-family: 'Didact Gothic', sans-serif;
    font-size: 11px; letter-spacing: 1.5px;
    color: #c9a84c; z-index: 25;
    pointer-events: none; transition: opacity 0.3s;
}
.phone-home-bar {
    position: absolute;
    bottom: 12px; left: 50%;
    transform: translateX(-50%);
    width: 100px; height: 4px;
    background: rgba(255,255,255,0.25);
    border-radius: 2px; z-index: 10;
}
.phone-video-controls {
    position: absolute;
    bottom: 28px; left: 18px;
    display: flex; flex-direction: column; gap: 10px;
    z-index: 20;
}
.phone-ctrl-btn {
    width: 42px; height: 42px;
    border-radius: 50%;
    background: rgba(0,0,0,0.45);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.2);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
    font-size: 16px; line-height: 1; padding: 0;
}
.phone-ctrl-btn:hover {
    background: rgba(201,168,76,0.75);
    transform: scale(1.1);
}
.phone-nav {
    position: absolute;
    right: -60px; top: 50%;
    transform: translateY(-50%);
    display: flex; flex-direction: column; gap: 10px;
}
.phone-nav-btn {
    width: 44px; height: 44px; border-radius: 50%;
    background: #f5f0e8;
    border: 1px solid #e0d8c8;
    color: #5a5048; font-size: 16px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.25s;
    user-select: none;
}
.phone-nav-btn:hover {
    background: #c9a84c; border-color: #c9a84c; color: #fff;
    transform: scale(1.08);
}
.phone-nav-btn:active { transform: scale(0.95); }

@media (max-width: 1000px) { .phone-scene { gap: 48px; } }
@media (max-width: 900px) {
    .phone-scene { flex-direction: column-reverse; gap: 48px; }
    .phone-side-text { text-align: center; max-width: 100%; }
    .phone-nav { right: -56px; }
}
@media (max-width: 580px) {
    .phone-outer { width: 320px; height: 580px; border-radius: 44px; }
    .phone-nav { display: none; }
    .phone-scene { padding: 0 20px; }
}

/* ══════════════════════════════════════
   CAR AD BANNER — ĐÃ SỬA:
   - Bỏ border-top/bottom đen
   - Hoán đổi: QR bên trái, text bên phải
   - Mở rộng text để lấp khoảng trống
══════════════════════════════════════ */
.car-ad-section {
    background: #faf7f2;
    padding: 0 80px;
    overflow: hidden;
    /* ĐÃ XÓA: border-top và border-bottom */
}
.car-ad-inner {
    position: relative;
    display: flex;
    align-items: center;
    min-height: 360px;
    overflow: hidden;
}
.car-ad-text {
    position: relative;
    z-index: 2;
    flex: 0 0 auto;
    max-width: 460px; /* tăng từ 320px → 460px để lấp khoảng trống */
    padding: 40px 0;
}
.car-ad-label-new {
    font-family: 'Didact Gothic', sans-serif;
    font-size: 13px;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #c9a84c;
    font-weight: 700;
    margin-bottom: 8px;
    display: block;
}
.car-ad-title-new {
    font-family: 'Playfair Display', serif;
    font-size: clamp(32px, 3.5vw, 52px);
    font-weight: 700;
    color: #9a6f28;
    line-height: 1.0;
    margin: 0 0 2px;
}
.car-ad-subtitle-new {
    font-family: 'Playfair Display', serif;
    font-size: clamp(20px, 2.2vw, 30px);
    font-weight: 400;
    font-style: italic;
    color: #1a1a1a;
    margin: 0 0 10px;
    line-height: 1.2;
}
.car-ad-desc-new {
    font-family: 'Didact Gothic', sans-serif;
    font-size: 14px;
    color: #5a5048;
    line-height: 1.8;
    margin: 0 0 24px;
}
.car-ad-btn-new {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: transparent;
    border: 1px solid rgba(154,111,40,0.5);
    color: #9a6f28 !important;
    font-family: 'Didact Gothic', sans-serif;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 3px;
    text-transform: uppercase;
    padding: 13px 28px;
    text-decoration: none !important;
    transition: all 0.3s;
}
.car-ad-btn-new:hover {
    background: #c9a84c;
    border-color: #c9a84c;
    color: #fff !important;
    gap: 14px;
}
.car-ad-img-wrap-new {
    flex: 1;
    position: relative;
    z-index: 2;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    height: 360px;
    overflow: visible;
}
.car-ad-img-wrap-new img {
    height: 340px;
    width: auto;
    max-width: 860px;
    object-fit: contain;
    object-position: center bottom;
    display: block;
    filter: drop-shadow(0 20px 40px rgba(0,0,0,0.14));
    transition: transform 0.6s cubic-bezier(0.25,0.46,0.45,0.94);
}
.car-ad-inner:hover .car-ad-img-wrap-new img {
    transform: translateX(-10px) scale(1.04);
}
.car-ad-qr-wrap {
    position: relative;
    z-index: 2;
    flex: 0 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 24px 24px 24px 0; /* padding-right để tách khỏi xe */
    order: -1; /* ĐÃ SỬA: đưa QR sang bên trái */
}
.car-ad-qr-wrap img {
    width: 110px; height: 110px;
    border: 4px solid #fff;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    display: block;
}
.car-ad-qr-label {
    font-family: 'Didact Gothic', sans-serif;
    font-size: 10px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #5a5048;
    text-align: center;
    line-height: 1.6;
    font-weight: 600;
}

@media (max-width: 1100px) { .car-ad-section { padding: 0 40px; } }
@media (max-width: 768px) {
    .car-ad-section { padding: 0 20px; }
    .car-ad-inner { flex-wrap: wrap; min-height: auto; padding: 28px 0 0; }
    .car-ad-text { max-width: 100%; padding: 0 0 20px; }
    .car-ad-img-wrap-new { height: 220px; width: 100%; order: 3; }
    .car-ad-img-wrap-new img { height: 210px; }
    .car-ad-qr-wrap { display: none; }
}

/* ══════════════════════════════════════
   TESTIMONIALS
══════════════════════════════════════ */
.testimonial-section { background: #faf7f2; padding: 80px 80px; }
.testimonial-grid {
    position: relative;
    overflow: hidden;
    margin-top: 48px;
    background: #e8e0d0;
}
.testimonial-track {
    display: flex;
    gap: 0;
    transition: transform 0.65s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.testimonial-card {
    flex: 0 0 50%;
    background: #faf7f2;
    padding: 28px 32px;
    transition: background 0.25s;
    position: relative;
    border-right: 2px solid #e8e0d0;
    box-sizing: border-box;
}
.testimonial-card:last-child { border-right: none; }
.testimonial-card:hover { background: #fff; }
.testimonial-card-img-wrap {
    width: 100%; height: 160px;
    overflow: hidden; margin-bottom: 20px;
    background: #f0ebe1;
    display: flex; align-items: center; justify-content: center;
}
.testimonial-card-img { width: 100%; height: 100%; object-fit: cover; }
.testimonial-card-quote {
    font-family: 'Cormorant Garamond', serif;
    font-size: 19px; font-weight: 600;
    line-height: 1.8; color: #3a3530;
    margin: 0 0 20px;
}
.testimonial-card-author {
    display: flex; align-items: center; gap: 12px;
    border-top: 1px solid #e8e0d0; padding-top: 16px;
}
.testimonial-card-author img {
    width: 38px; height: 38px; border-radius: 50%;
    object-fit: cover; border: 1px solid #c9a84c;
}
.testimonial-card-author-name {
    font-family: 'Playfair Display', serif;
    font-size: 18px; font-weight: 500;
    color: #1a1a1a; display: block;
}
.testimonial-card-author-role {
    font-family: 'Didact Gothic', sans-serif;
    font-size: 11px; letter-spacing: 1.8px;
    text-transform: uppercase; color: #c9a84c;
}
.testimonial-card-ornament {
    position: absolute; top: 16px; right: 20px;
    font-family: 'Playfair Display', serif;
    font-size: 56px; line-height: 1;
    color: rgba(201,168,76,0.12);
    font-style: italic; pointer-events: none; user-select: none;
}
.testimonial-dots { display: flex; justify-content: center; gap: 8px; margin-top: 24px; }

/* ══════════════════════════════════════
   PRICE UPDATE BANNER
══════════════════════════════════════ */
.price-banner-section {
    background: #5a5a5a;
    padding: 48px 24px;
    display: flex; align-items: center;
    justify-content: center; gap: 40px;
}
.price-banner-box {
    border: 2px dashed #c9a84c;
    background: #fefbe8; border-radius: 12px;
    padding: 40px 80px; text-align: center;
    max-width: 860px; width: 100%;
}
.price-banner-title {
    font-family: 'Didact Gothic', sans-serif;
    font-size: 19px; font-weight: 700; color: #1a1a1a;
    margin: 0 0 20px; letter-spacing: 0.3px; line-height: 1.65;
}
.price-banner-btn {
    display: inline-flex; align-items: center; gap: 10px;
    background: #0068FF; color: #fff !important;
    text-decoration: none !important; padding: 13px 28px;
    border-radius: 50px; font-family: 'Didact Gothic', sans-serif;
    font-size: 15px; font-weight: 700; letter-spacing: 0.5px;
    transition: background 0.25s, transform 0.2s;
    box-shadow: 0 4px 16px rgba(0,104,255,0.4);
}
.price-banner-btn:hover {
    background: #0055d4; transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,104,255,0.5);
}
.price-banner-note {
    font-family: 'Didact Gothic', sans-serif;
    font-size: 15px; color: #6b6056; margin: 16px 0 0; line-height: 1.85;
}
.price-banner-hotline {
    background: #0e4f6f; color: #fff;
    padding: 16px 24px; border-radius: 4px;
    font-family: 'Didact Gothic', sans-serif;
    font-size: 15px; font-weight: 700; letter-spacing: 0.5px;
    white-space: nowrap; flex-shrink: 0;
}
@media (max-width: 900px) {
    .price-banner-section { flex-direction: column; padding: 36px 20px; gap: 20px; }
    .price-banner-box { padding: 24px 20px; }
    .price-banner-hotline { width: 100%; text-align: center; }
}

/* ══════════════════════════════════════
   FLOAT BUTTONS
══════════════════════════════════════ */
.float-group {
    position: fixed; bottom: 28px; right: 28px;
    z-index: 9999; display: flex; flex-direction: column;
    align-items: center; gap: 12px;
}
.float-btn {
    width: 52px; height: 52px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    text-decoration: none !important;
    position: relative; cursor: pointer; flex-shrink: 0;
}
.float-btn::before, .float-btn::after {
    content: ''; position: absolute; inset: -3px;
    border-radius: 50%; background: transparent;
    animation: floatRing 2s ease-out infinite;
}
.float-btn::after { inset: -7px; animation-delay: 0.45s; }
.float-btn-zalo {
    background: #0068FF;
    animation: shakeLoop 2.5s ease-in-out 1.2s infinite, glowBlue 2s ease-in-out 0.5s infinite;
}
.float-btn-zalo::before { border: 2px solid rgba(0,104,255,0.55); }
.float-btn-zalo::after  { border: 2px solid rgba(0,104,255,0.25); animation-delay: 1.15s; }
.float-btn-zalo img { width: 36px; height: 36px; object-fit: contain; border-radius: 50%; }
@keyframes floatRing { 0%{transform:scale(1);opacity:1} 100%{transform:scale(1.55);opacity:0} }
@keyframes shakeLoop {
    0%{transform:rotate(0deg)} 5%{transform:rotate(-20deg)} 10%{transform:rotate(20deg)}
    15%{transform:rotate(-16deg)} 20%{transform:rotate(16deg)} 25%{transform:rotate(-10deg)}
    30%{transform:rotate(10deg)} 35%,100%{transform:rotate(0deg)}
}
@keyframes glowBlue {
    0%,100%{box-shadow:0 4px 16px rgba(0,104,255,0.45),0 0 6px rgba(0,104,255,0.3)}
    50%{box-shadow:0 4px 28px rgba(0,104,255,0.85),0 0 20px rgba(0,104,255,0.55)}
}
@media (max-width:768px) { .float-group{bottom:18px;right:14px;} .float-btn{width:46px;height:46px;} }

/* ══════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════ */
@media (max-width: 1100px) {
    .fleet-carousel-wrap { padding: 0 60px; }
    .fleet-header { padding: 0 60px; }
    .video-section { padding: 50px 40px; }
    .testimonial-section { padding: 60px 40px; }
    .why-grid { grid-template-columns: repeat(2, 1fr); gap: 40px; }
}
@media (max-width: 768px) {
    .fleet-carousel-wrap { padding: 0 52px; }
    .fleet-header { flex-direction: column; align-items: flex-start; padding: 0 20px; }
    .why-grid { grid-template-columns: repeat(2, 1fr); gap: 28px; }
    .why-intro { flex-direction: column; align-items: flex-start; gap: 16px; }
    .testimonial-card { flex: 0 0 100%; border-right: none; }
    .video-section { padding: 40px 20px; }
    .testimonial-section { padding: 48px 20px; }
    .testimonial-card-img-wrap { height: 130px; }
}
@media (max-width: 520px) {
    .why-grid { grid-template-columns: 1fr; }
    .fleet-nav { width: 40px; height: 40px; }
}
</style>
@endpush

@section('content')

{{-- HERO BANNER --}}
<section class="banner-wrap">
    <div class="banner-track" id="bannerTrack">
        <div class="banner-slide" id="slide-0">
            <img src="{{ asset('images/car/Banner8.jpeg') }}" alt="MEC - Mua bán xe đã qua sử dụng">
            <div class="banner-overlay"></div>
        </div>
        <div class="banner-slide" id="slide-1">
            <img src="{{ asset('images/car/Banner3.png') }}" alt="MEC - Sang trọng đẳng cấp">
            <div class="banner-overlay"></div>
        </div>
        <div class="banner-slide" id="slide-2">
            <img src="{{ asset('images/car/Banner7.png') }}" alt="MEC - Lái thử miễn phí">
            <div class="banner-overlay"></div>
        </div>
        <div class="banner-slide" id="slide-3">
            <img src="{{ asset('images/car/Banner4.png') }}" alt="MEC - Trả góp 0%">
            <div class="banner-overlay"></div>
        </div>
    </div>
    <div class="banner-slide-nums" id="bannerSlideNums"></div>
    <div class="banner-dots" id="bannerDots"></div>
    <div class="banner-counter" id="bannerCounter">01 / 04</div>
</section>

{{-- TẠI SAO CHỌN AUTOX --}}
<section class="why-section">
    <div class="container">
        <div class="why-intro">
            <div class="why-intro-left">
                <p class="section-label">Về Chúng Tôi</p>
                <h2 class="section-heading" style="margin-bottom:0;">
                    Tại Sao Chọn<br><em>AutoX</em>
                </h2>
            </div>
            <div class="why-intro-right">
                <p class="section-desc" style="max-width:420px;">
                    AutoX mang đến trải nghiệm sở hữu và thuê xe cao cấp chuẩn mực quốc tế —
                    kết hợp giữa bộ sưu tập xe đẳng cấp, dịch vụ cá nhân hoá và đội ngũ tư vấn
                    chuyên nghiệp tận tâm.
                </p>
            </div>
        </div>
        <div class="why-grid">
            <div class="why-pillar">
                <div class="why-pillar-icon">
                    <img src="{{ asset('images/CTN/Mercedes-Maybach-GLS-CTN.png') }}" alt="">
                </div>
                <h5>Đa Dạng Mẫu Xe</h5>
                <p>Hàng trăm mẫu xe từ phổ thông đến siêu sang, đáp ứng mọi phong cách và ngân sách.</p>
                <span class="why-pillar-line"></span>
            </div>
            <div class="why-pillar">
                <div class="why-pillar-icon">
                    <img src="{{ asset('images/team/suport.jpg') }}" alt="">
                </div>
                <h5>Hỗ Trợ 24/7</h5>
                <p>Đội ngũ tư vấn luôn sẵn sàng — mọi lúc, mọi nơi, bất kể ngày hay đêm.</p>
                <span class="why-pillar-line"></span>
            </div>
            <div class="why-pillar">
                <div class="why-pillar-icon">
                    <img src="{{ asset('images/testimonial/showroom.jpg') }}" alt="">
                </div>
                <h5>Đại Lý Uy Tín</h5>
                <p>Hợp tác với các đại lý chính hãng được chứng nhận, đảm bảo nguồn gốc và chất lượng.</p>
                <span class="why-pillar-line"></span>
            </div>
            <div class="why-pillar">
                <div class="why-pillar-icon">
                    <img src="{{ asset('images/team/customer car.webp') }}" alt="">
                </div>
                <h5>Giá Tốt Nhất</h5>
                <p>Cam kết mức giá cạnh tranh nhất thị trường, cùng nhiều ưu đãi tài chính linh hoạt.</p>
                <span class="why-pillar-line"></span>
            </div>
        </div>
    </div>
</section>

{{-- FLEET --}}
<section class="fleet-section">
    <div class="fleet-header">
        <div>
            <p class="section-label" style="margin-bottom:16px;">Bộ Sưu Tập</p>
            <h2 class="section-heading" style="margin:0;">Xe <em>Nổi Bật</em></h2>
        </div>
        <a href="{{ route('cars.index') }}" class="fleet-view-all">Xem tất cả →</a>
    </div>
    <div class="fleet-carousel-wrap">
        <button class="fleet-nav fleet-nav-prev" id="fleetPrev" aria-label="Trước">
            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <div class="fleet-carousel-track-outer">
            <div class="fleet-carousel-track" id="fleetTrack">
                @forelse($featuredCars as $car)
                <a href="{{ route('cars.show', $car) }}" class="fleet-card">
                    <div class="fleet-card-img">
                        @if($car->image_url)
                            @if(str_starts_with($car->image_url, 'images/'))
                                <img src="{{ asset($car->image_url) }}" alt="{{ $car->name }}"
                                     onerror="this.src='{{ asset('images/car/placeholder.jpg') }}'">
                            @else
                                <img src="{{ asset('images/car/' . $car->image_url) }}" alt="{{ $car->name }}"
                                     onerror="this.src='{{ asset('images/car/placeholder.jpg') }}'">
                            @endif
                        @else
                            <img src="{{ asset('images/car/placeholder.jpg') }}" alt="No image">
                        @endif
                        <div class="fleet-card-overlay">
                            <span class="fleet-card-overlay-btn">Xem Chi Tiết</span>
                        </div>
                    </div>
                    <div class="fleet-card-body">
                        <span class="fleet-card-name">{{ $car->name }}</span>
                        <div class="fleet-card-meta">
                            @if($car->year) <span>{{ $car->year }}</span> @endif
                            @if($car->transmission) <span>{{ $car->transmission }}</span> @endif
                        </div>
                        <div class="fleet-card-price">
                            {{ number_format($car->price_per_day) }} VNĐ
                        </div>
                    </div>
                </a>
                @empty
                <div style="padding:60px 0;text-align:center;color:#aaa099;font-family:'Didact Gothic',sans-serif;font-size:13px;letter-spacing:2px;text-transform:uppercase;width:100%;">
                    Chưa có xe nào trong bộ sưu tập
                </div>
                @endforelse
            </div>
        </div>
        <button class="fleet-nav fleet-nav-next" id="fleetNext" aria-label="Tiếp">
            <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
    </div>
    <div class="fleet-dots" id="fleetDots"></div>
</section>

{{-- VIDEO --}}
<section class="video-section" id="video-section">
  <div class="phone-scene">
    <div class="phone-side-text">
      <p class="section-label">AutoX Showcase</p>
      <h3>Khám Phá Thế Giới<br><em>Xe Đẳng Cấp</em></h3>
      <p>
        Trải nghiệm những hành trình đẳng cấp cùng bộ sưu tập xe sang trọng tại AutoX —
        nơi mỗi chuyến đi đều là một kỷ niệm khó quên.
      </p>
      <a href="{{ route('cars.index') }}" class="phone-cta">Xem bộ sưu tập →</a>
    </div>

    <div class="phone-frame">
      <div class="phone-outer">
        <div class="phone-notch"></div>
        <div class="phone-screen">
          <div class="phone-video-slot active" data-slot="0">
            <video id="phoneVideo" muted loop playsinline preload="none"
              data-src="{{ asset('images/video/demo.mp4') }}"></video>
          </div>
          <div class="phone-video-slot" data-slot="1">
            <iframe id="ytFrame" src="about:blank"
              data-yt="https://www.youtube.com/embed/wzZa0c4-0qU?autoplay=1&mute=1&loop=1&playlist=wzZa0c4-0qU&controls=0&playsinline=1&rel=0&modestbranding=1"
              allow="autoplay; encrypted-media; fullscreen" allowfullscreen frameborder="0"></iframe>
          </div>
          <div class="phone-slot-badge" id="slotBadge" style="display:none">1 / 2</div>
          <div class="phone-video-controls" id="phoneVideoControls">
            <button class="phone-ctrl-btn" id="phoneMuteBtn" title="Mute/Unmute">🔇</button>
            <button class="phone-ctrl-btn" id="phonePlayBtn" title="Play/Pause">⏸</button>
          </div>
        </div>
        <div class="phone-home-bar"></div>
      </div>
      <div class="phone-nav">
        <div class="phone-nav-btn" id="phoneNavUp" title="Video trước">&#8679;</div>
        <div class="phone-nav-btn" id="phoneNavDown" title="Video tiếp theo">&#8681;</div>
      </div>
    </div>
  </div>
</section>

{{-- CAR AD BANNER --}}
{{-- ĐÃ SỬA: bỏ border đen, QR sang trái, text mở rộng sang phải --}}
<section class="car-ad-section">
    <div class="car-ad-inner">

        {{-- QR — ĐÃ CHUYỂN LÊN ĐẦU (bên trái) nhờ order: -1 trong CSS --}}
        <div class="car-ad-qr-wrap">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&color=0d3a4a&data={{ urlencode(url('/cars')) }}"
                 alt="QR Code AutoX">
            <span class="car-ad-qr-label">Quét để xem<br>bộ sưu tập</span>
        </div>

        {{-- ẢNH XE — ở giữa --}}
        <div class="car-ad-img-wrap-new">
            <img src="{{ asset('images/car/Mercedes-Maybach-GLS-TN.png') }}"
                 alt="Mercedes-Maybach GLS"
                 onerror="this.src='{{ asset('images/CTN/Mercedes-Maybach-GLS-CTN.png') }}'">
        </div>

        {{-- TEXT — ĐÃ CHUYỂN SANG PHẢI, mở rộng max-width --}}
        <div class="car-ad-text">
            <span class="car-ad-label-new">Quảng cáo xe</span>
            <h3 class="car-ad-title-new">Đẳng cấp<br>thượng lưu.</h3>
            <p class="car-ad-subtitle-new">Hiện diện giữa muôn thương hiệu.</p>
            <p class="car-ad-desc-new">Sở hữu ngay để trải nghiệm sự sang trọng đích thực trên mọi cung đường — nơi phong cách gặp gỡ hiệu suất vượt trội, khẳng định đẳng cấp của bạn.</p>
            <a href="{{ route('cars.index') }}" class="car-ad-btn-new">Liên hệ ngay →</a>
        </div>

    </div>
</section>

{{-- TESTIMONIALS --}}
<section class="testimonial-section">
    <p class="section-label">Khách Hàng Nói Gì</p>
    <h2 class="section-heading">Nhận Xét <em>Từ Thực Tế</em></h2>
    <div class="testimonial-grid">
        <div class="testimonial-track" id="testimonialTrack">
            <div class="testimonial-card">
                <span class="testimonial-card-ornament">"</span>
                <div class="testimonial-card-img-wrap">
                    <img class="testimonial-card-img" src="{{ asset('images/testimonial/01.jpg') }}" alt="">
                </div>
                <blockquote class="testimonial-card-quote">
                    "Tôi rất ấn tượng với không gian hiện đại và sự đón tiếp nồng hậu tại showroom.
                    Đội ngũ nhân viên tư vấn rất am hiểu kỹ thuật, giúp tôi chọn được dòng xe phù hợp."
                </blockquote>
                <div class="testimonial-card-author">
                    <img src="{{ asset('images/team/02.jpg') }}" alt="">
                    <div>
                        <span class="testimonial-card-author-name">Nguyễn Văn A</span>
                        <span class="testimonial-card-author-role">AutoX · Khách hàng thân thiết</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <span class="testimonial-card-ornament">"</span>
                <div class="testimonial-card-img-wrap">
                    <img class="testimonial-card-img" src="{{ asset('images/testimonial/02.jpg') }}" alt="">
                </div>
                <blockquote class="testimonial-card-quote">
                    "Sau 6 tháng cầm lái, tôi hoàn toàn hài lòng với khả năng vận hành của xe.
                    Xe chạy êm, tiết kiệm nhiên liệu và các tính năng an toàn thực sự vượt mong đợi."
                </blockquote>
                <div class="testimonial-card-author">
                    <img src="{{ asset('images/team/03.jpg') }}" alt="">
                    <div>
                        <span class="testimonial-card-author-name">Trần Thị B</span>
                        <span class="testimonial-card-author-role">Chủ xe BMW · 6 tháng sử dụng</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <span class="testimonial-card-ornament">"</span>
                <div class="testimonial-card-img-wrap">
                    <img class="testimonial-card-img" src="{{ asset('images/testimonial/03.jpg') }}" alt="">
                </div>
                <blockquote class="testimonial-card-quote">
                    "Điểm tôi thích nhất ở AutoX là hệ thống chi nhánh có mặt ở nhiều tỉnh thành.
                    Nhân viên ở mọi chi nhánh đều có chung phong cách phục vụ chu đáo, tận tâm."
                </blockquote>
                <div class="testimonial-card-author">
                    <img src="{{ asset('images/team/02.jpg') }}" alt="">
                    <div>
                        <span class="testimonial-card-author-name">Lê Hoàng C</span>
                        <span class="testimonial-card-author-role">Khách hàng thân thiết · Hà Nội</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <span class="testimonial-card-ornament">"</span>
                <div class="testimonial-card-img-wrap">
                    <img class="testimonial-card-img" src="{{ asset('images/testimonial/04.jpg') }}" alt="">
                </div>
                <blockquote class="testimonial-card-quote">
                    "Xe đẹp, lái chất, dịch vụ 5 sao! Từ lúc xem xe đến khi nhận xe chỉ mất vài ngày.
                    Thủ tục trả góp tại showroom rất đơn giản và minh bạch. Tôi rất hài lòng!"
                </blockquote>
                <div class="testimonial-card-author">
                    <img src="{{ asset('images/team/01.jpg') }}" alt="">
                    <div>
                        <span class="testimonial-card-author-name">Phạm Thị Minh T</span>
                        <span class="testimonial-card-author-role">Khách hàng thân thiết · TP.HCM</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="testimonial-dots fleet-dots" id="testimonialDots"></div>
</section>

{{-- PRICE UPDATE BANNER --}}
<section class="price-banner-section">
    <div class="price-banner-box">
        <p class="price-banner-title">
            ✨ Cập nhật Giá Lăn Bánh mới nhất Tháng 04/2026
        </p>
        <a href="https://zalo.me/0372254313" target="_blank" class="price-banner-btn">
            <img src="https://upload.wikimedia.org/wikipedia/commons/d/d6/Logo_Zalo.png"
                 alt="Zalo" style="width:32px;height:32px;object-fit:contain;border-radius:6px;">
            Nhận Báo Giá qua Zalo ngay!!
        </a>
        <p class="price-banner-note">
            Quà tặng dành cho khách hàng gửi yêu cầu báo giá Online.<br>
            * Quý khách vui lòng liên hệ hotline tư vấn, nhận thông tin ưu đãi và khuyến mãi.
        </p>
    </div>
    <div class="price-banner-hotline">Hotline: 0909 123 456</div>
</section>

<div class="float-group">
    <a href="https://zalo.me/0372254313" target="_blank" class="float-btn float-btn-zalo">
        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d6/Logo_Zalo.png" alt="Zalo">
    </a>
</div>

{{-- POPUP BÁO GIÁ NHANH --}}
<style>
.popup-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.55);
    z-index: 99999;
    display: flex; align-items: center; justify-content: center;
}
.popup-box {
    background: #fff; width: 100%; max-width: 440px;
    border-radius: 6px; overflow: hidden; position: relative;
    animation: popupIn .3s ease;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}
.popup-close-btn {
    position: absolute; top: 10px; right: 10px;
    width: 28px; height: 28px;
    background: rgba(0,0,0,0.45); border: none; border-radius: 50%;
    font-size: 14px; cursor: pointer; display: flex;
    align-items: center; justify-content: center;
    color: #fff; z-index: 2; line-height: 1; transition: background .2s;
}
.popup-close-btn:hover { background: rgba(0,0,0,0.65); }
.popup-img { width: 100%; height: 200px; object-fit: cover; display: block; margin: 0; padding: 0; border-radius: 6px 6px 0 0; }
.popup-body { padding: 20px 24px 24px; }
.popup-title {
    font-family: 'Playfair Display', serif;
    font-size: 24px; font-weight: 400; color: #1a1a1a;
    text-align: center; margin: 0 0 6px; line-height: 1.3;
}
.popup-title em { font-style: italic; color: #9a6f28; }
.popup-desc {
    font-family: 'Didact Gothic', sans-serif;
    font-size: 15px; color: #6b6056;
    text-align: center; margin: 0 0 16px; line-height: 1.6;
}
.popup-radio-row { display: flex; justify-content: center; gap: 28px; margin-bottom: 16px; }
.popup-radio-row label {
    display: flex; align-items: center; gap: 7px;
    font-family: 'Didact Gothic', sans-serif; font-size: 16px;
    color: #1a1a1a; cursor: pointer;
}
.popup-radio-row input[type="radio"] { accent-color: #c9a84c; width: 16px; height: 16px; cursor: pointer; }
.popup-input {
    width: 100%; padding: 11px 16px; border: 1px solid #e0d8c8;
    border-radius: 50px; font-family: 'Didact Gothic', sans-serif;
    font-size: 15px; color: #1a1a1a; outline: none;
    box-sizing: border-box; margin-bottom: 10px; background: #fff;
    transition: border-color .2s;
}
.popup-input:focus { border-color: #c9a84c; }
.popup-select {
    width: 100%; padding: 11px 16px; border: 1px solid #e0d8c8;
    border-radius: 50px; font-family: 'Didact Gothic', sans-serif;
    font-size: 13px; color: #1a1a1a; outline: none;
    box-sizing: border-box; margin-bottom: 12px;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%23999' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") no-repeat right 16px center;
    appearance: none; -webkit-appearance: none; cursor: pointer;
}
.popup-submit-btn {
    width: 100%; padding: 13px; background: #c9a84c; color: #fff;
    border: none; border-radius: 50px;
    font-family: 'Didact Gothic', sans-serif; font-size: 14px;
    letter-spacing: 3px; text-transform: uppercase; cursor: pointer;
    transition: background .2s;
}
.popup-submit-btn:hover { background: #b8963e; }
@keyframes popupIn {
    from { opacity: 0; transform: translateY(-16px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

<div id="popup-overlay" class="popup-backdrop">
    <div class="popup-box">
        <button onclick="closePopup()" class="popup-close-btn">✕</button>
        <img class="popup-img" src="{{ asset('images/CTN/Mercedes-Benz-E-Class-CTN.png') }}" alt="AutoX">
        <div class="popup-body">
            <h2 class="popup-title">Chào mừng đến với <em>AutoX</em></h2>
            <p class="popup-desc">Nhập thông tin để tư vấn viên hỗ trợ ngay. Chọn hình thức thanh toán:</p>
            <div class="popup-radio-row">
                <label><input type="radio" name="popup-payment" value="tra-gop" checked> Trả góp</label>
                <label><input type="radio" name="popup-payment" value="tra-thang"> Trả thẳng</label>
            </div>
            <input type="text" id="popup-ten" class="popup-input" placeholder="Họ và tên">
            <input type="tel" id="popup-sdt" class="popup-input"
                   placeholder="Vui lòng nhập số điện thoại"
                   maxlength="10" inputmode="numeric" pattern="[0-9]{10}" required
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            <select id="popup-dongxe" class="popup-select">
                <option value="">— Chọn dòng xe —</option>
                <option value="Mercedes-AMG GT">Mercedes-AMG GT</option>
                <option value="Mercedes-Benz E-Class">Mercedes-Benz E-Class</option>
                <option value="Mercedes-Benz EQS">Mercedes-Benz EQS</option>
                <option value="Mercedes-Benz G-Class">Mercedes-Benz G-Class</option>
                <option value="Mercedes-Benz GLE">Mercedes-Benz GLE</option>
                <option value="Mercedes-Benz GLS">Mercedes-Benz GLS</option>
                <option value="Mercedes-Benz S-Class">Mercedes-Benz S-Class</option>
                <option value="Mercedes-Benz SL-Class">Mercedes-Benz SL-Class</option>
                <option value="Mercedes-Maybach GLS">Mercedes-Maybach GLS</option>
                <option value="Mercedes-Maybach S-Class">Mercedes-Maybach S-Class</option>
            </select>
            <button id="popup-submit" class="popup-submit-btn">Gửi yêu cầu</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
/* ══════════════════════════════════════
   BANNER HERO
══════════════════════════════════════ */
(function(){
    var track    = document.getElementById('bannerTrack');
    var slides   = document.querySelectorAll('.banner-slide');
    var dotsWrap = document.getElementById('bannerDots');
    var numsWrap = document.getElementById('bannerSlideNums');
    var counter  = document.getElementById('bannerCounter');
    var total    = slides.length;
    var current  = 0;
    var timer    = null;
    var DELAY    = 4500;

    function pad(n){ return n < 10 ? '0' + n : n; }

    function buildDots(){
        for(var i = 0; i < total; i++){
            var d = document.createElement('button');
            d.className = 'banner-dot' + (i === 0 ? ' active' : '');
            d.setAttribute('data-i', i);
            d.addEventListener('click', function(){
                goTo(parseInt(this.getAttribute('data-i'))); reset();
            });
            dotsWrap.appendChild(d);
        }
    }

    function buildNums(){
        for(var i = 0; i < total; i++){
            var btn = document.createElement('button');
            btn.className = 'banner-slide-num' + (i === 0 ? ' active' : '');
            btn.setAttribute('data-i', i);
            btn.innerHTML =
                '<span class="banner-slide-num-text">' + pad(i + 1) + '</span>' +
                '<span class="banner-slide-num-line"></span>';
            btn.addEventListener('click', function(){
                goTo(parseInt(this.getAttribute('data-i'))); reset();
            });
            numsWrap.appendChild(btn);
        }
    }

    function updateUI(){
        dotsWrap.querySelectorAll('.banner-dot').forEach(function(d, i){
            d.classList.toggle('active', i === current);
        });
        numsWrap.querySelectorAll('.banner-slide-num').forEach(function(n, i){
            n.classList.toggle('active', i === current);
        });
        counter.textContent = pad(current + 1) + ' / ' + pad(total);
    }

    function goTo(idx){
        current = (idx + total) % total;
        track.style.transform = 'translateX(-' + (current * 100) + '%)';
        updateUI();
    }

    function start(){ timer = setInterval(function(){ goTo(current + 1); }, DELAY); }
    function reset(){ clearInterval(timer); start(); }

    var wrap = document.querySelector('.banner-wrap');
    wrap.addEventListener('mouseenter', function(){ clearInterval(timer); });
    wrap.addEventListener('mouseleave', start);

    buildDots(); buildNums(); start();
})();

/* ══════════════════════════════════════
   VIDEO PHONE
══════════════════════════════════════ */
(function() {
    var video       = document.getElementById('phoneVideo');
    var ytFrame     = document.getElementById('ytFrame');
    var muteBtn     = document.getElementById('phoneMuteBtn');
    var playBtn     = document.getElementById('phonePlayBtn');
    var controls    = document.getElementById('phoneVideoControls');
    var slotBadge   = document.getElementById('slotBadge');
    var navUp       = document.getElementById('phoneNavUp');
    var navDown     = document.getElementById('phoneNavDown');
    var slots       = document.querySelectorAll('.phone-video-slot');
    var totalSlots  = slots.length;
    var currentSlot = 0;
    var videoLoaded = false;
    var ytLoaded    = false;

    function updateBadge() { slotBadge.textContent = (currentSlot + 1) + ' / ' + totalSlots; }
    function showControls(show) { controls.style.display = show ? 'flex' : 'none'; }

    function loadLocalVideo() {
        if (!videoLoaded) { video.src = video.getAttribute('data-src'); videoLoaded = true; }
        video.play().catch(function(){});
        playBtn.textContent = '⏸';
    }
    function pauseLocalVideo() { video.pause(); playBtn.textContent = '▶'; }
    function muteLocalVideo() { video.muted = true; muteBtn.textContent = '🔇'; }

    function loadYouTube() {
        if (!ytLoaded) { ytFrame.src = ytFrame.getAttribute('data-yt'); ytLoaded = true; }
    }
    function unloadYouTube() { ytFrame.src = 'about:blank'; ytLoaded = false; }

    function switchSlot(dir) {
        slots[currentSlot].classList.remove('active');
        if (currentSlot === 0) pauseLocalVideo(); else unloadYouTube();
        currentSlot = (currentSlot + dir + totalSlots) % totalSlots;
        slots[currentSlot].classList.add('active');
        updateBadge();
        if (currentSlot === 0) { showControls(true); loadLocalVideo(); }
        else { showControls(false); loadYouTube(); }
    }

    if (navUp)   navUp.addEventListener('click',  function() { switchSlot(-1); });
    if (navDown) navDown.addEventListener('click', function() { switchSlot(1); });

    muteBtn.addEventListener('click', function() {
        video.muted = !video.muted;
        muteBtn.textContent = video.muted ? '🔇' : '🔊';
    });
    playBtn.addEventListener('click', function() {
        if (video.paused) { video.play().catch(function(){}); playBtn.textContent = '⏸'; }
        else { video.pause(); playBtn.textContent = '▶'; }
    });

    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    if (currentSlot === 0) loadLocalVideo(); else loadYouTube();
                } else {
                    if (currentSlot === 0) { pauseLocalVideo(); muteLocalVideo(); }
                    else unloadYouTube();
                }
            });
        }, { threshold: 0.35 });
        observer.observe(document.querySelector('.phone-outer'));
    } else {
        loadLocalVideo();
    }

    updateBadge(); showControls(true);
})();

/* ══════════════════════════════════════
   POPUP
══════════════════════════════════════ */
function closePopup() {
    document.getElementById('popup-overlay').style.display = 'none';
}

function showToast(msg, type) {
    var existing = document.getElementById('ax-toast');
    if (existing) existing.remove();
    var toast = document.createElement('div');
    toast.id = 'ax-toast';
    toast.style.cssText = [
        'position:fixed','bottom:32px','left:50%',
        'transform:translateX(-50%) translateY(20px)',
        'background:' + (type === 'success' ? '#1a1a1a' : '#c0392b'),
        'color:#fff','font-family:"Didact Gothic",sans-serif',
        'font-size:13px','letter-spacing:1.5px','padding:14px 28px',
        'border-radius:2px','box-shadow:0 8px 32px rgba(0,0,0,0.35)',
        'z-index:999999','display:flex','align-items:center','gap:10px',
        'opacity:0','transition:opacity .3s ease, transform .3s ease',
        'max-width:90vw','text-align:center',
        'border-left:3px solid ' + (type === 'success' ? '#c9a84c' : '#e74c3c')
    ].join(';');
    var icon = type === 'success' ? '✓' : '✕';
    toast.innerHTML = '<span style="font-size:16px;color:' + (type === 'success' ? '#c9a84c' : '#e74c3c') + '">' + icon + '</span> ' + msg;
    document.body.appendChild(toast);
    requestAnimationFrame(function() {
        toast.style.opacity = '1';
        toast.style.transform = 'translateX(-50%) translateY(0)';
    });
    setTimeout(function() {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(-50%) translateY(20px)';
        setTimeout(function() { toast.remove(); }, 350);
    }, 3200);
}

function setFieldError(el, hasError) {
    el.style.borderColor = hasError ? '#e74c3c' : '#ddd';
    el.style.transition = 'border-color .2s';
}

document.getElementById('popup-submit').addEventListener('click', function () {
    var btn    = this;
    var tenEl  = document.getElementById('popup-ten');
    var sdtEl  = document.getElementById('popup-sdt');
    var dongEl = document.getElementById('popup-dongxe');
    var ten  = tenEl.value.trim();
    var sdt  = sdtEl.value.trim();
    var dong = dongEl.value.trim();
    setFieldError(tenEl, false); setFieldError(sdtEl, false); setFieldError(dongEl, false);
    var missing = [];
    if (!ten)  { setFieldError(tenEl, true);  missing.push('Họ và tên'); }
    if (!sdt)  { setFieldError(sdtEl, true);  missing.push('Số điện thoại'); }
    if (!dong) { setFieldError(dongEl, true); missing.push('Dòng xe'); }
    if (missing.length > 0) { showToast('Vui lòng điền: ' + missing.join(', '), 'error'); return; }
    btn.disabled = true; btn.textContent = 'Đang gửi...';
    fetch('{{ route("bao-gia-nhanh.store") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ ten: ten, so_dien_thoai: sdt, dong_xe: dong })
    })
    .then(function(r) { if (!r.ok) throw new Error('Server error ' + r.status); return r.json(); })
    .then(function(data) {
        if (data.success) { showToast('Đăng ký thành công! Chúng tôi sẽ liên hệ sớm.', 'success'); setTimeout(closePopup, 1800); }
        else { showToast('Có lỗi xảy ra, vui lòng thử lại!', 'error'); }
    })
    .catch(function(err) { console.error('Fetch error:', err); showToast('Có lỗi xảy ra, vui lòng thử lại!', 'error'); })
    .finally(function() { btn.disabled = false; btn.textContent = 'GỬI YÊU CẦU'; });
});

['popup-ten','popup-sdt','popup-dongxe'].forEach(function(id) {
    document.getElementById(id).addEventListener('input', function() { setFieldError(this, false); });
    document.getElementById(id).addEventListener('change', function() { setFieldError(this, false); });
});

/* ══════════════════════════════════════
   FLEET CAROUSEL
══════════════════════════════════════ */
(function() {
    var track    = document.getElementById('fleetTrack');
    var prevBtn  = document.getElementById('fleetPrev');
    var nextBtn  = document.getElementById('fleetNext');
    var dotsWrap = document.getElementById('fleetDots');
    if (!track) return;

    var cards     = track.querySelectorAll('.fleet-card');
    var total     = cards.length;
    var current   = 0;
    var autoTimer = null;
    var AUTO_DELAY = 4000;

    function getPerView() {
        var w = window.innerWidth;
        if (w <= 520) return 1;
        if (w <= 900) return 2;
        return 3;
    }
    function cardWidth() { return track.parentElement.offsetWidth / getPerView(); }
    function sizeCards() {
        var w = cardWidth();
        cards.forEach(function(c) { c.style.flex = '0 0 ' + w + 'px'; c.style.width = w + 'px'; });
    }
    function maxIndex() { return Math.max(0, total - getPerView()); }
    function buildDots() {
        dotsWrap.innerHTML = '';
        var count = maxIndex() + 1;
        for (var i = 0; i < count; i++) {
            var d = document.createElement('button');
            d.className = 'fleet-dot' + (i === current ? ' active' : '');
            d.setAttribute('data-i', i);
            d.addEventListener('click', function() { goTo(parseInt(this.getAttribute('data-i'))); resetAuto(); });
            dotsWrap.appendChild(d);
        }
    }
    function updateDots() {
        dotsWrap.querySelectorAll('.fleet-dot').forEach(function(d, i) { d.classList.toggle('active', i === current); });
    }
    function goTo(idx) {
        current = Math.max(0, Math.min(idx, maxIndex()));
        track.style.transform = 'translateX(-' + (current * (cardWidth() + 2)) + 'px)';
        updateDots();
    }
    function startAuto() { autoTimer = setInterval(function() { goTo(current >= maxIndex() ? 0 : current + 1); }, AUTO_DELAY); }
    function resetAuto() { clearInterval(autoTimer); startAuto(); }

    prevBtn.addEventListener('click', function() { goTo(current - 1); resetAuto(); });
    nextBtn.addEventListener('click', function() { goTo(current + 1); resetAuto(); });
    track.addEventListener('mouseenter', function() { clearInterval(autoTimer); });
    track.addEventListener('mouseleave', startAuto);
    window.addEventListener('resize', function() { sizeCards(); buildDots(); goTo(Math.min(current, maxIndex())); });

    sizeCards(); buildDots(); goTo(0); startAuto();
})();

/* ══════════════════════════════════════
   TESTIMONIAL CAROUSEL
══════════════════════════════════════ */
(function() {
    var track    = document.getElementById('testimonialTrack');
    var dotsWrap = document.getElementById('testimonialDots');
    if (!track) return;

    var cards     = track.querySelectorAll('.testimonial-card');
    var total     = cards.length;
    var current   = 0;
    var autoTimer = null;
    var DELAY     = 4500;

    function getPerView() { return window.innerWidth <= 768 ? 1 : 2; }
    function sizeCards() {
        var pv = getPerView();
        cards.forEach(function(c) { c.style.flex = '0 0 ' + (100 / pv) + '%'; });
    }
    function maxIndex() { return Math.max(0, total - getPerView()); }
    function buildDots() {
        dotsWrap.innerHTML = '';
        var count = maxIndex() + 1;
        for (var i = 0; i < count; i++) {
            var d = document.createElement('button');
            d.className = 'fleet-dot' + (i === current ? ' active' : '');
            d.setAttribute('data-i', i);
            d.addEventListener('click', function() { goTo(parseInt(this.getAttribute('data-i'))); resetAuto(); });
            dotsWrap.appendChild(d);
        }
    }
    function updateDots() {
        dotsWrap.querySelectorAll('.fleet-dot').forEach(function(d, i) { d.classList.toggle('active', i === current); });
    }
    function goTo(idx) {
        current = Math.max(0, Math.min(idx, maxIndex()));
        track.style.transform = 'translateX(-' + ((100 / getPerView()) * current) + '%)';
        updateDots();
    }
    function startAuto() { autoTimer = setInterval(function() { goTo(current >= maxIndex() ? 0 : current + 1); }, DELAY); }
    function resetAuto() { clearInterval(autoTimer); startAuto(); }

    track.addEventListener('mouseenter', function() { clearInterval(autoTimer); });
    track.addEventListener('mouseleave', startAuto);
    window.addEventListener('resize', function() { sizeCards(); buildDots(); goTo(Math.min(current, maxIndex())); });

    sizeCards(); buildDots(); goTo(0); startAuto();
})();
</script>
@endpush