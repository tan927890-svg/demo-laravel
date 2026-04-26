{{-- resources/views/news-show.blade.php — AUTO X --}}
@extends('layouts.frontend')
@section('title', $post->title . ' — AUTO X')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow+Condensed:wght@600;700;800&family=Barlow:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
:root {
  --blue:        #1c69d4;
  --blue-dark:   #1352a8;
  --blue-light:  #e8f0fb;
  --blue-border: rgba(28,105,212,0.18);
  --black:       #0d0d0d;
  --white:       #ffffff;
  --gray-1:      #f4f4f4;
  --gray-2:      #e4e4e4;
  --gray-3:      #c8c8c8;
  --gray-4:      #888888;
  --gray-5:      #555555;
  --font:        'Barlow', sans-serif;
  --font-h:      'Barlow Condensed', sans-serif;
  --font-display:'Bebas Neue', sans-serif;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: var(--font); background: var(--gray-1); color: var(--black); }
a { text-decoration: none; color: inherit; }
img { display: block; max-width: 100%; }

/* ── TICKER ── */
.ticker-bar {
  background: var(--black);
  height: 38px;
  display: flex;
  align-items: center;
  overflow: hidden;
  border-bottom: 2px solid var(--blue);
}
.ticker-label {
  background: var(--blue);
  color: #fff;
  font-size: 10px;
  font-weight: 800;
  letter-spacing: 2px;
  text-transform: uppercase;
  padding: 0 16px;
  height: 100%;
  display: flex;
  align-items: center;
  white-space: nowrap;
  flex-shrink: 0;
}
.ticker-track { overflow: hidden; flex: 1; padding: 0 20px; }
.ticker-track span {
  display: inline-block;
  white-space: nowrap;
  font-size: 12px;
  color: rgba(255,255,255,.7);
  animation: ticker 35s linear infinite;
}
@keyframes ticker { from { transform: translateX(100vw) } to { transform: translateX(-100%) } }
.ticker-date {
  padding: 0 20px;
  font-size: 11px;
  font-weight: 700;
  color: rgba(255,255,255,.4);
  white-space: nowrap;
  flex-shrink: 0;
  border-left: 1px solid rgba(255,255,255,.1);
}

/* ── BREADCRUMB ── */
.crumb-bar { background: var(--white); border-bottom: 1px solid var(--gray-2); padding: 0 40px; }
.crumb-inner {
  max-width: 860px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  height: 42px;
  gap: 8px;
  font-size: 12px;
  color: var(--gray-4);
}
.crumb-inner a { color: var(--blue); }
.crumb-inner a:hover { text-decoration: underline; }
.crumb-sep { opacity: .4; font-size: 14px; }
.crumb-current { color: var(--black); font-weight: 600; }

/* ── LAYOUT: single column, max 860px ── */
.page-wrap {
  max-width: 860px;
  margin: 0 auto;
  padding: 28px 40px 80px;
}

/* ── HERO ── */
.article-hero {
  position: relative;
  height: 460px;
  overflow: hidden;
  background: var(--black);
  margin-bottom: 0;
}
.article-hero img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  opacity: .88;
  transition: transform 8s ease, opacity .4s;
}
.article-hero:hover img { transform: scale(1.03); opacity: .95; }
.hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,.72) 0%, rgba(0,0,0,.1) 55%, transparent 100%);
}
.hero-meta {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  padding: 28px 32px;
}
.hero-cat {
  display: inline-flex;
  align-items: center;
  background: var(--blue);
  color: #fff;
  font-size: 10px;
  font-weight: 800;
  letter-spacing: 2.5px;
  text-transform: uppercase;
  padding: 5px 14px;
  margin-bottom: 12px;
}
.hero-title {
  font-family: var(--font-display);
  font-size: 38px;
  color: #fff;
  line-height: 1.05;
  text-shadow: 0 2px 20px rgba(0,0,0,.5);
  margin-bottom: 12px;
}
.hero-info {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
}
.hero-info span { font-size: 12px; color: rgba(255,255,255,.65); display: flex; align-items: center; gap: 4px; }
.hero-info .dot { width: 3px; height: 3px; background: rgba(255,255,255,.3); border-radius: 50%; }

/* ── ARTICLE ── */
.article-card { background: var(--white); }

.article-body { padding: 36px 40px 44px; }

.article-excerpt {
  font-size: 16px;
  color: var(--gray-5);
  line-height: 1.78;
  border-left: 4px solid var(--blue);
  padding: 12px 20px;
  background: var(--blue-light);
  margin-bottom: 30px;
  font-style: italic;
}
.article-content { font-size: 15px; color: #2a2a2a; line-height: 1.9; }
.article-content p { margin-bottom: 20px; }
.article-content h2 {
  font-family: var(--font-h);
  font-size: 24px;
  font-weight: 800;
  color: var(--black);
  text-transform: uppercase;
  margin: 36px 0 14px;
  padding-bottom: 10px;
  border-bottom: 2px solid var(--blue);
}
.article-content h3 { font-family: var(--font-h); font-size: 19px; font-weight: 700; color: var(--black); margin: 26px 0 10px; }
.article-content ul, .article-content ol { margin: 0 0 20px 24px; }
.article-content li { margin-bottom: 7px; }
.article-content strong { color: var(--black); }
.article-content img { max-width: 100%; margin: 24px 0; }
.article-content blockquote {
  border-left: 4px solid var(--blue);
  padding: 14px 22px;
  background: var(--blue-light);
  margin: 24px 0;
  font-style: italic;
  color: var(--gray-5);
}

/* ── TAGS ── */
.tags-row {
  display: flex; flex-wrap: wrap; gap: 8px;
  margin-top: 32px; padding-top: 22px;
  border-top: 1px solid var(--gray-2);
}
.tag-pill {
  font-size: 10px; font-weight: 700; letter-spacing: 1.5px;
  text-transform: uppercase; color: var(--blue);
  border: 1px solid var(--blue-border); background: var(--blue-light);
  padding: 6px 14px; transition: background .2s, color .2s;
}
.tag-pill:hover { background: var(--blue); color: #fff; }

/* ── AUTHOR ── */
.author-box {
  display: flex; align-items: center; gap: 16px;
  background: var(--gray-1);
  border-top: 3px solid var(--blue);
  padding: 22px 28px;
  margin-top: 32px;
}
.author-avatar {
  width: 52px; height: 52px; border-radius: 50%;
  background: var(--blue); color: #fff;
  font-family: var(--font-display); font-size: 24px;
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.author-name { font-size: 14px; font-weight: 700; margin-bottom: 3px; }
.author-role { font-size: 12px; color: var(--gray-4); }

/* ── SHARE ── */
.share-bar {
  display: flex; align-items: center; gap: 10px;
  padding: 18px 28px;
  border-top: 1px solid var(--gray-2);
}
.share-label { font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--gray-4); margin-right: 4px; }
.share-btn {
  display: flex; align-items: center; gap: 6px;
  font-size: 11px; font-weight: 700;
  padding: 7px 14px;
  border: 1px solid var(--gray-2); color: var(--gray-5);
  background: var(--white); cursor: pointer;
  transition: background .2s, color .2s, border-color .2s;
}
.share-btn:hover { background: var(--blue); color: #fff; border-color: var(--blue); }

/* ── RELATED ── */
.related-section { margin-top: 32px; }
.sec-head {
  display: flex; align-items: baseline; justify-content: space-between;
  margin-bottom: 18px; padding-bottom: 12px;
  border-bottom: 3px solid var(--blue);
}
.sec-title { font-family: var(--font-display); font-size: 26px; letter-spacing: .5px; color: var(--black); }
.sec-title em { color: var(--blue); font-style: normal; }
.sec-more { font-size: 12px; font-weight: 700; color: var(--blue); }
.related-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }

/* ── NEWS CARD ── */
.nc {
  background: var(--white); overflow: hidden;
  display: flex; flex-direction: column;
  transition: box-shadow .25s, transform .22s;
}
.nc:hover { box-shadow: 0 8px 28px rgba(28,105,212,.14); transform: translateY(-4px); }
.nc:hover .nc-img img { transform: scale(1.07); }
.nc-img { position: relative; height: 150px; overflow: hidden; background: var(--gray-2); }
.nc-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
.nc-badge {
  position: absolute; top: 0; left: 0;
  background: var(--blue); color: #fff;
  font-size: 9px; font-weight: 800; letter-spacing: 2px;
  text-transform: uppercase; padding: 4px 10px;
}
.nc-body { padding: 14px 16px 16px; flex: 1; display: flex; flex-direction: column; }
.nc-title {
  font-family: var(--font-h); font-size: 14px; font-weight: 700;
  color: var(--black); text-transform: uppercase; line-height: 1.3;
  margin-bottom: 7px;
  display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
  transition: color .2s;
}
.nc:hover .nc-title { color: var(--blue); }
.nc-excerpt {
  font-size: 12px; color: var(--gray-5); line-height: 1.6; flex: 1; margin-bottom: 10px;
  display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.nc-meta {
  font-size: 11px; color: var(--gray-4);
  display: flex; align-items: center; gap: 6px;
  padding-top: 10px; border-top: 1px solid var(--gray-2); margin-top: auto;
}
.nc-dot { width: 2px; height: 2px; background: var(--gray-3); border-radius: 50%; }
.nc-more { font-size: 11px; font-weight: 700; color: var(--blue); margin-left: auto; }

/* ── REVEAL ── */
[data-reveal] { opacity: 0; transform: translateY(20px); transition: opacity .6s ease, transform .6s ease; }
[data-reveal].in { opacity: 1; transform: none; }

/* ── RESPONSIVE ── */
@media (max-width: 768px) {
  .page-wrap { padding: 16px 16px 48px; }
  .crumb-bar { padding: 0 16px; }
  .article-hero { height: 260px; }
  .hero-title { font-size: 26px; }
  .article-body { padding: 22px 20px 30px; }
  .related-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px) {
  .related-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')

{{-- TICKER --}}
<div class="ticker-bar">
  <div class="ticker-label">▸ Breaking</div>
  <div class="ticker-track">
    <span>Mercedes E-Class 2025 chính thức ra mắt tại Việt Nam &nbsp;&nbsp;&nbsp; ▸ &nbsp;&nbsp;&nbsp; BMW 7 Series giảm giá 300 triệu trong tháng 4 &nbsp;&nbsp;&nbsp; ▸ &nbsp;&nbsp;&nbsp; Cuộc chiến xe điện 2025: Tesla vs BYD vs VinFast &nbsp;&nbsp;&nbsp; ▸ &nbsp;&nbsp;&nbsp; Toyota Camry 2025 - thiết kế mới, động cơ hybrid &nbsp;&nbsp;&nbsp; ▸ &nbsp;&nbsp;&nbsp; Volvo EX90 đạt giải xe an toàn nhất năm 2025</span>
  </div>
  <div class="ticker-date">{{ now()->locale('vi')->isoFormat('D [Tháng] M, YYYY') }}</div>
</div>

{{-- BREADCRUMB --}}
<div class="crumb-bar">
  <div class="crumb-inner">
    <a href="{{ url('/') }}">Trang chủ</a>
    <span class="crumb-sep">›</span>
    <a href="{{ route('news.index') }}">Tin tức</a>
    @if($post->category)
      <span class="crumb-sep">›</span>
      <a href="{{ route('news.index', ['category' => $post->category->slug]) }}">{{ $post->category->name }}</a>
    @endif
    <span class="crumb-sep">›</span>
    <span class="crumb-current">{{ Str::limit($post->title, 48) }}</span>
  </div>
</div>

{{-- MAIN --}}
<div class="page-wrap">

  {{-- HERO --}}
  <div class="article-hero" data-reveal>
    <img
      src="{{ $post->thumbnail ? asset($post->thumbnail) : 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?w=1400&q=90' }}"
      alt="{{ $post->title }}"
    >
    <div class="hero-overlay"></div>
    <div class="hero-meta">
      @if($post->category)
        <div class="hero-cat">{{ $post->category->name }}</div>
      @endif
      <h1 class="hero-title">{{ $post->title }}</h1>
      <div class="hero-info">
        <span>{{ $post->author->name ?? 'Ban Biên Tập' }}</span>
        <div class="dot"></div>
        <span>{{ $post->published_at->format('d/m/Y') }}</span>
        <div class="dot"></div>
        <span>{{ $post->read_time ?? 5 }} phút đọc</span>
        <div class="dot"></div>
        <span>{{ number_format($post->views ?? 0) }} lượt xem</span>
      </div>
    </div>
  </div>

  {{-- ARTICLE --}}
  <div class="article-card" data-reveal>
    <div class="article-body">
      @if($post->excerpt)
        <p class="article-excerpt">{{ $post->excerpt }}</p>
      @endif

      <div class="article-content">
        {!! $post->content !!}
      </div>

      @if($post->tags && $post->tags->count())
        <div class="tags-row">
          @foreach($post->tags as $tag)
            <a href="{{ route('news.index', ['tag' => $tag->slug]) }}" class="tag-pill">{{ $tag->name }}</a>
          @endforeach
        </div>
      @endif

      <div class="author-box">
        <div class="author-avatar">{{ strtoupper(substr($post->author->name ?? 'A', 0, 1)) }}</div>
        <div>
          <div class="author-name">{{ $post->author->name ?? 'Ban Biên Tập' }}</div>
          <div class="author-role">Biên tập viên AUTO X</div>
        </div>
      </div>
    </div>

    <div class="share-bar">
      <span class="share-label">Chia sẻ</span>
      <button class="share-btn" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href))">
        Facebook
      </button>
      <button class="share-btn" onclick="navigator.clipboard.writeText(location.href).then(()=>this.textContent='✓ Đã sao chép')">
        Sao chép link
      </button>
    </div>
  </div>

  {{-- BÀI LIÊN QUAN — lấy từ DB: cùng category, loại trừ bài hiện tại --}}
  @if($related->count())
  <div class="related-section" data-reveal>
    <div class="sec-head">
      <div class="sec-title">Bài Viết <em>Liên Quan</em></div>
      <a href="{{ route('news.index', $post->category ? ['category' => $post->category->slug] : []) }}" class="sec-more">Xem tất cả →</a>
    </div>
    <div class="related-grid">
      @foreach($related as $r)
      <a href="{{ route('news.show', $r->slug) }}" class="nc">
        <div class="nc-img">
          <img
            src="{{ $r->thumbnail ? asset($r->thumbnail) : 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=600&q=85' }}"
            alt="{{ $r->title }}"
            loading="lazy"
          >
          @if($r->category)<div class="nc-badge">{{ $r->category->name }}</div>@endif
        </div>
        <div class="nc-body">
          <div class="nc-title">{{ $r->title }}</div>
          <p class="nc-excerpt">{{ Str::limit($r->excerpt ?? '', 80) }}</p>
          <div class="nc-meta">
            <span>{{ $r->published_at->format('d/m/Y') }}</span>
            <div class="nc-dot"></div>
            <span>{{ $r->read_time ?? 5 }} phút</span>
            <span class="nc-more">Đọc →</span>
          </div>
        </div>
      </a>
      @endforeach
    </div>
  </div>
  @endif

</div>

@endsection

@push('scripts')
<script>
const ro = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) { e.target.classList.add('in'); ro.unobserve(e.target); }
  });
}, { threshold: 0.06 });
document.querySelectorAll('[data-reveal]').forEach(el => ro.observe(el));
</script>
@endpush