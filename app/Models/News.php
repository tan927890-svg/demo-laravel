<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = [
        'news_category_id',
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'read_time',
        'views',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // ── Boot: tự tạo slug & excerpt ──────────────────────────────
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
            if (empty($model->excerpt) && $model->content) {
                $model->excerpt = Str::limit(strip_tags($model->content), 160);
            }
            if ($model->status === 'published' && empty($model->published_at)) {
                $model->published_at = now();
            }
            // Tự tính read_time (~200 từ/phút)
            if ($model->content) {
                $wordCount = str_word_count(strip_tags($model->content));
                $model->read_time = max(1, (int) ceil($wordCount / 200));
            }
        });

        static::updating(function ($model) {
            if ($model->status === 'published' && empty($model->published_at)) {
                $model->published_at = now();
            }
            if ($model->content) {
                $wordCount = str_word_count(strip_tags($model->content));
                $model->read_time = max(1, (int) ceil($wordCount / 200));
            }
        });
    }

    // ── Relationships ────────────────────────────────────────────
    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(NewsTag::class, 'news_news_tag');
    }

    // ── Scopes ──────────────────────────────────────────────────
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function scopeByDate(Builder $query): Builder
{
    return $query->orderByDesc('published_at');
}
    public function scopePopular(Builder $query): Builder
    {
        return $query->orderByDesc('views');
    }

    public function scopeByCategory(Builder $query, string $slug): Builder
    {
        return $query->whereHas('category', fn($q) => $q->where('slug', $slug));
    }

    public function scopeByTag(Builder $query, string $slug): Builder
    {
        return $query->whereHas('tags', fn($q) => $q->where('slug', $slug));
    }

    // ── Helpers ──────────────────────────────────────────────────
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : null;
    }
}