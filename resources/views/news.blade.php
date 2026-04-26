{{-- ============================================================
    resources/views/news.blade.php  —  AUTO X
    ============================================================ --}}
@extends('layouts.frontend')
@section('title', 'Tin Tức Xe Hơi — AUTO X')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Barlow:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
.nx-root {
  --blue:        #1c69d4;
  --blue-dark:   #1555b0;
  --blue-light:  #e8f0fb;
  --blue-border: rgba(28,105,212,0.2);
  --black:       #111111;
  --white:       #ffffff;
  --gray-1:      #f5f5f5;
  --gray-2:      #e5e5e5;
  --gray-3:      #cccccc;
  --gray-4:      #888888;
  --gray-5:      #555555;
  --font:        'Barlow', sans-serif;
  --font-h:      'Barlow Condensed', sans-serif;
}

/* Chỉ scope trong .nx-root, không reset toàn trang */
.nx-root *, .nx-root *::before, .nx-root *::after { box-sizing: border-box; }
.nx-root { font-family: var(--font); color: var(--black); }
.nx-root a { text-decoration: none; color: inherit; }
.nx-root img { display: block; max-width: 100%; }

.nx-container { max-width: 1200px; margin: 0 auto; padding: 0 40px; }

/* TOP BAR */
.nx-top-bar {
  background: var(--blue);
  height: 36px;
  display: flex;
  align-items: center;
  padding: 0 40px;
  gap: 32px;
  overflow: hidden;
}
.nx-ticker { font-size: 12px; color: rgba(255,255,255,.85); overflow: hidden; flex: 1; }
.nx-ticker span { animation: nx-marquee 32s linear infinite; display: inline-block; white-space: nowrap; }
@keyframes nx-marquee { from { transform: translateX(100%) } to { transform: translateX(-100%) } }
.nx-top-date { font-size: 11px; font-weight: 600; color: rgba(255,255,255,.7); white-space: nowrap; }

/* PAGE HEADER */
.nx-page-header {
  background: var(--white);
  border-bottom: 3px solid var(--blue);
  padding: 24px 0 0;
  margin: 0;
}
.nx-page-header-inner {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  padding-bottom: 0;
}
.nx-page-title {
  font-family: var(--font-h);
  font-size: 28px;
  font-weight: 800;
  color: var(--black);
  text-transform: uppercase;
  margin: 0;
  line-height: 1.2;
  padding-bottom: 12px;
}
.nx-page-title span { color: var(--blue); }
.nx-breadcrumb {
  font-size: 12px;
  color: var(--gray-4);
  display: flex;
  align-items: center;
  gap: 6px;
  padding-bottom: 10px;
  margin: 0;
}
.nx-breadcrumb a { color: var(--blue); }
.nx-breadcrumb a:hover { text-decoration: underline; }

/* CATEGORY FILTER */
.nx-cat-filter {
  background: var(--white);
  border-bottom: 1px solid var(--gray-2);
  margin: 0;
}
.nx-cat-inner {
  display: flex;
  align-items: center;
  overflow-x: auto;
  scrollbar-width: none;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 40px;
}
.nx-cat-inner::-webkit-scrollbar { display: none; }
.nx-cat-btn {
  font-family: var(--font);
  font-size: 13px;
  font-weight: 600;
  color: var(--gray-5);
  padding: 13px 20px;
  border: none;
  border-bottom: 3px solid transparent;
  background: none;
  white-space: nowrap;
  cursor: pointer;
  transition: color .2s, border-color .2s;
  text-decoration: none !important;
  display: inline-block;
  line-height: 1;
}
.nx-cat-btn:hover { color: var(--blue); }
.nx-cat-btn.active { color: var(--blue); border-bottom-color: var(--blue); }

/* MAIN WRAP */
.nx-wrap { background: var(--gray-1); padding: 36px 0 80px; }

/* FEATURED */
.nx-featured {
  background: var(--white);
  border: 1px solid var(--gray-2);
  overflow: hidden;
  margin-bottom: 36px;
  display: grid;
  grid-template-columns: 55% 45%;
}
.nx-featured:hover .nx-fc-img img { transform: scale(1.04); }
.nx-fc-img { position: relative; overflow: hidden; height: 340px; }
.nx-fc-img img { width: 100%; height: 100%; object-fit: cover; object-position: center; transition: transform .6s ease; }
.nx-fc-badge {
  position: absolute; top: 0; left: 0;
  background: var(--blue); color: var(--white);
  font-size: 10px; font-weight: 700; letter-spacing: 2px;
  text-transform: uppercase; padding: 5px 14px;
}
.nx-fc-body {
  padding: 32px 36px;
  display: flex; flex-direction: column; justify-content: center;
  border-left: 4px solid var(--blue);
  min-width: 0;
}
.nx-fc-label { font-size: 10px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--blue); margin-bottom: 12px; }
.nx-fc-title {
  font-family: var(--font-h); font-size: 26px; font-weight: 800;
  color: var(--black); line-height: 1.2; text-transform: uppercase;
  margin-bottom: 14px;
  display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
}
.nx-fc-excerpt {
  font-size: 14px; color: var(--gray-5); line-height: 1.75; margin-bottom: 16px;
  display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden;
}
.nx-fc-meta {
  font-size: 11px; color: var(--gray-4);
  display: flex; align-items: center; gap: 8px;
  border-top: 1px solid var(--gray-2); padding-top: 14px;
}
.nx-fc-dot { width: 3px; height: 3px; background: var(--gray-3); border-radius: 50%; flex-shrink: 0; }
.nx-fc-btn {
  display: inline-flex; align-items: center; gap: 6px;
  margin-top: 16px; background: var(--blue); color: var(--white) !important;
  font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;
  padding: 11px 24px; transition: background .2s; width: fit-content;
}
.nx-fc-btn:hover { background: var(--blue-dark); }

/* SECTION HEADER */
.nx-sec-hdr {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 20px; padding-bottom: 12px;
  border-bottom: 2px solid var(--blue);
}
.nx-sec-title { font-family: var(--font-h); font-size: 20px; font-weight: 800; color: var(--black); text-transform: uppercase; margin: 0; }
.nx-sec-title span { color: var(--blue); }
.nx-sec-more { font-size: 12px; font-weight: 600; color: var(--blue); }
.nx-sec-more:hover { text-decoration: underline; }

/* NEWS GRID */
.nx-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 20px; }

.nx-card {
  background: var(--white); border: 1px solid var(--gray-2);
  overflow: hidden; display: flex; flex-direction: column; min-width: 0;
  transition: box-shadow .25s, transform .22s;
}
.nx-card:hover { box-shadow: 0 6px 24px rgba(28,105,212,.13); transform: translateY(-3px); }
.nx-card:hover .nx-card-img img { transform: scale(1.06); }
.nx-card-img { position: relative; overflow: hidden; height: 168px; background: var(--gray-2); flex-shrink: 0; }
.nx-card-img img { width: 100%; height: 100%; object-fit: cover; object-position: center; transition: transform .5s ease; }
.nx-card-badge {
  position: absolute; top: 0; left: 0;
  background: var(--blue); color: var(--white);
  font-size: 9px; font-weight: 700; letter-spacing: 2px;
  text-transform: uppercase; padding: 3px 10px;
}
.nx-card-body { padding: 15px 16px 17px; flex: 1; display: flex; flex-direction: column; }
.nx-card-title {
  font-family: var(--font-h); font-size: 15px; font-weight: 700;
  color: var(--black); line-height: 1.3; text-transform: uppercase; margin-bottom: 7px;
  display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.nx-card-excerpt {
  font-size: 12px; color: var(--gray-5); line-height: 1.62; margin-bottom: 8px;
  display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
  flex: 1;
}
.nx-card-meta {
  font-size: 11px; color: var(--gray-4);
  display: flex; align-items: center; gap: 6px;
  margin-top: auto; padding-top: 10px; border-top: 1px solid var(--gray-2);
}
.nx-card-dot { width: 2px; height: 2px; background: var(--gray-3); border-radius: 50%; }
.nx-card-more { font-size: 11px; font-weight: 700; color: var(--blue); margin-left: auto; }

/* LOAD MORE */
.nx-load-more { text-align: center; margin-top: 36px; }
.nx-load-more-btn {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--white); color: var(--blue);
  border: 2px solid var(--blue);
  font-family: var(--font); font-size: 12px; font-weight: 700;
  letter-spacing: 2px; text-transform: uppercase;
  padding: 12px 40px; cursor: pointer;
  transition: background .2s, color .2s;
}
.nx-load-more-btn:hover { background: var(--blue); color: var(--white); }

/* CTA */
.nx-cta { background: var(--white); padding: 64px 0; text-align: center; border-top: 1px solid var(--gray-2); }
.nx-cta-title {
  font-family: var(--font-h); font-size: clamp(30px,4vw,50px);
  font-weight: 800; color: var(--black); text-transform: uppercase;
  line-height: 1; margin-bottom: 14px;
}
.nx-cta-title span { color: var(--blue); }
.nx-cta-desc { font-size: 14px; color: var(--gray-5); max-width: 420px; margin: 0 auto 26px; line-height: 1.75; }
.nx-cta-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
.nx-btn-blue {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--blue); color: #fff !important;
  font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;
  padding: 13px 30px; border: 2px solid var(--blue);
  transition: background .2s, transform .15s;
}
.nx-btn-blue:hover { background: var(--blue-dark); transform: translateY(-2px); }
.nx-btn-outline {
  display: inline-flex; align-items: center; gap: 8px;
  background: transparent; color: var(--black);
  font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;
  padding: 12px 30px; border: 2px solid var(--black);
  transition: background .2s, color .2s;
}
.nx-btn-outline:hover { background: var(--black); color: var(--white); }

/* REVEAL */
[data-reveal] { opacity: 0; transform: translateY(16px); transition: opacity .6s ease, transform .6s ease; }
[data-reveal].in { opacity: 1; transform: none; }

/* RESPONSIVE */
@media (max-width: 1024px) {
  .nx-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
  .nx-featured { grid-template-columns: 1fr; }
  .nx-fc-img { height: 260px; }
  .nx-fc-body { border-left: none; border-top: 4px solid var(--blue); padding: 24px; }
}
@media (max-width: 768px) {
  .nx-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  .nx-container { padding: 0 20px; }
  .nx-cat-inner { padding: 0 20px; }
  .nx-top-bar { padding: 0 20px; }
}
@media (max-width: 480px) {
  .nx-grid { grid-template-columns: 1fr; }
  .nx-container { padding: 0 14px; }
  .nx-cat-inner { padding: 0 14px; }
  .nx-top-bar { padding: 0 14px; }
  .nx-fc-title { font-size: 20px; }
}
</style>
@endpush

@section('content')
<div class="nx-root">

@php
$fallback = [
  'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=600&q=85',
  'https://images.unsplash.com/photo-1583121274602-3e2820c69888?w=600&q=85',
  'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?w=600&q=85',
  'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=600&q=85',
  'https://images.unsplash.com/photo-1525609004556-c46c7d6cf023?w=600&q=85',
  'https://images.unsplash.com/photo-1471479917193-f00955256257?w=600&q=85',
  'https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?w=600&q=85',
  'https://images.unsplash.com/photo-1550355291-bbee04a92027?w=600&q=85',
  'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?w=600&q=85',
];
@endphp

{{-- TOP BAR --}}
<div class="nx-top-bar">
  <div class="nx-ticker">
    <span>▸ Mercedes E-Class 2025 chính thức ra mắt &nbsp;&nbsp;&nbsp; ▸ BMW 7 Series giảm giá 300 triệu tháng 4 &nbsp;&nbsp;&nbsp; ▸ Cuộc chiến xe điện 2025: Tesla vs BYD vs VinFast &nbsp;&nbsp;&nbsp; ▸ Thị trường xe sang Q1/2025 tăng trưởng 18% &nbsp;&nbsp;&nbsp;</span>
  </div>
  <div class="nx-top-date">{{ now()->locale('vi')->isoFormat('D [Tháng] M, YYYY') }}</div>
</div>

{{-- PAGE HEADER --}}
<div class="nx-page-header">
  <div class="nx-container">
    <div class="nx-page-header-inner">
      <h1 class="nx-page-title">Tin <span>Tức</span> Xe Hơi</h1>
      <div class="nx-breadcrumb">
        <a href="{{ url('/') }}">Trang chủ</a>
        <span>›</span>
        <span>Tin tức</span>
      </div>
    </div>
  </div>
</div>

{{-- CATEGORY FILTER --}}
<div class="nx-cat-filter">
  <div class="nx-cat-inner">
    <a href="{{ route('news.index') }}"
       class="nx-cat-btn {{ !request('category') ? 'active' : '' }}">Tất Cả</a>
    <a href="{{ route('news.index', ['category' => 'ra-mat-moi']) }}"
       class="nx-cat-btn {{ request('category') === 'ra-mat-moi' ? 'active' : '' }}">Ra Mắt Mới</a>
    <a href="{{ route('news.index', ['category' => 'danh-gia']) }}"
       class="nx-cat-btn {{ request('category') === 'danh-gia' ? 'active' : '' }}">Đánh Giá Xe</a>
    <a href="{{ route('news.index', ['category' => 'xu-huong']) }}"
       class="nx-cat-btn {{ request('category') === 'xu-huong' ? 'active' : '' }}">Xu Hướng</a>
    <a href="{{ route('news.index', ['category' => 'cong-nghe']) }}"
       class="nx-cat-btn {{ request('category') === 'cong-nghe' ? 'active' : '' }}">Công Nghệ</a>
    <a href="{{ route('news.index', ['category' => 'thi-truong']) }}"
       class="nx-cat-btn {{ request('category') === 'thi-truong' ? 'active' : '' }}">Thị Trường</a>
    <a href="{{ route('news.index', ['category' => 'meo-hay']) }}"
       class="nx-cat-btn {{ request('category') === 'meo-hay' ? 'active' : '' }}">Mẹo Hay</a>
  </div>
</div>

{{-- MAIN --}}
<section class="nx-wrap">
  <div class="nx-container">

    {{-- FEATURED --}}
    <a href="{{ route('news.show', $coverStory->slug ?? 'tin-tuc') }}" class="nx-featured" data-reveal>
      <div class="nx-fc-img">
        @if(!empty($coverStory->thumbnail))
          <img src="{{ asset($coverStory->thumbnail) }}" alt="{{ $coverStory->title }}" loading="lazy">
        @else
          <img src="https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?w=1200&q=90" alt="Cover" loading="lazy">
        @endif
        <div class="nx-fc-badge">{{ $coverStory->category->name ?? 'Nổi Bật' }}</div>
      </div>
      <div class="nx-fc-body">
        <div class="nx-fc-label">Bài viết nổi bật</div>
        <div class="nx-fc-title">{{ $coverStory->title ?? 'Mercedes-Benz E-Class 2025: Đỉnh Cao Sedan Hạng D' }}</div>
        <p class="nx-fc-excerpt">{{ $coverStory->excerpt ?? 'Mercedes-Benz E-Class 2025 ra mắt với MBUX Superscreen 14.4 inch, hybrid plug-in tiết kiệm nhiên liệu và công nghệ an toàn Level 2+.' }}</p>
        <div class="nx-fc-meta">
          <span>{{ isset($coverStory->published_at) ? $coverStory->published_at->format('d/m/Y') : '10/04/2025' }}</span>
          <div class="nx-fc-dot"></div>
          <strong>{{ $coverStory->author->name ?? 'Minh Khoa' }}</strong>
          <div class="nx-fc-dot"></div>
          <span>{{ ($coverStory->read_time ?? 8) }} phút đọc</span>
        </div>
        <span class="nx-fc-btn">Đọc ngay →</span>
      </div>
    </a>

    {{-- TIN MỚI NHẤT --}}
    <div class="nx-sec-hdr" data-reveal>
      <div class="nx-sec-title">Tin <span>Mới Nhất</span></div>
      <a href="{{ route('news.index') }}" class="nx-sec-more">Xem tất cả →</a>
    </div>

    <div class="nx-grid" data-reveal>
      @forelse($latestNews ?? [] as $post)
      <a href="{{ route('news.show', $post->slug) }}" class="nx-card">
        <div class="nx-card-img">
          <img
            src="{{ $post->thumbnail ? asset($post->thumbnail) : $fallback[$loop->index % count($fallback)] }}"
            alt="{{ $post->title }}"
            loading="lazy"
          >
          <div class="nx-card-badge">{{ $post->category->name ?? 'Tin Tức' }}</div>
        </div>
        <div class="nx-card-body">
          <div class="nx-card-title">{{ $post->title }}</div>
          <p class="nx-card-excerpt">{{ Str::limit($post->excerpt ?? '', 90) }}</p>
          <div class="nx-card-meta">
            <span>{{ $post->published_at->format('d/m/Y') }}</span>
            <div class="nx-card-dot"></div>
            <span>{{ $post->read_time ?? 5 }} phút</span>
            <span class="nx-card-more">Đọc →</span>
          </div>
        </div>
      </a>
      @empty
        <div class="nx-card">
          <div class="nx-card-body">
            <div class="nx-card-title">Chưa có bài viết nào.</div>
          </div>
        </div>
      @endforelse
    </div>

    <div class="nx-load-more" data-reveal>
      <button class="nx-load-more-btn">Xem thêm bài viết ↓</button>
    </div>

  </div>
</section>

{{-- CTA --}}
<section class="nx-cta">
  <div class="nx-container">
    <div class="nx-cta-title" data-reveal>Khám Phá <span>Showroom</span><br>Của Chúng Tôi</div>
    <p class="nx-cta-desc" data-reveal>Hơn 200 mẫu xe từ 30+ thương hiệu. Liên hệ ngay để được tư vấn miễn phí.</p>
    <div class="nx-cta-btns" data-reveal>
      <a href="{{ route('cars.index') }}" class="nx-btn-blue">Xem Xe Ngay →</a>
      <a href="{{ route('services.booking') }}" class="nx-btn-outline">Đặt Lịch Tư Vấn</a>
    </div>
  </div>
</section>

</div>{{-- end .nx-root --}}
@endsection

@push('scripts')
<script>
const ro = new IntersectionObserver(es => es.forEach(e => {
  if (e.isIntersecting) { e.target.classList.add('in'); ro.unobserve(e.target); }
}), { threshold: 0.06 });
document.querySelectorAll('[data-reveal]').forEach(el => ro.observe(el));
</script>
@endpush