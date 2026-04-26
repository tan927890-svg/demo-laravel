<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand_id',
        'model',
        'price_per_day',
        'color',
        'mileage',
        'fuel_type',
        'image_url',
        'condition',
        'engine',
        'seats',
        'description',
        'images',
        'image',
        'status',
        'is_available',
        'is_featured',
        'badge_label',
        'slug',
        'tagline',
        'hero_image',
        'image_360_prefix',
        'image_360_frames',
        'cost_price',
        'sale_price',   // ← thêm
    ];

    protected $casts = [
        'price_per_day'    => 'decimal:0',
        'cost_price'       => 'decimal:0',  // ← thêm
        'sale_price'       => 'decimal:0',  // ← thêm
        'is_available'     => 'boolean',
        'is_featured'      => 'boolean',
        'image_360_frames' => 'integer',
    ];

    // ── Boot ────────────────────────────────────────────────────
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($car) {
            $car->slug = Str::slug($car->name . '-' . uniqid());
        });
    }

    // ── Relationships ────────────────────────────────────────────
    public function brand()
    {
        return $this->belongsTo(\App\Models\Brand::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function variants()
    {
        return $this->hasMany(CarVariant::class)->orderBy('sort_order');
    }

    public function colors()
    {
        return $this->hasMany(CarColor::class)->orderBy('sort_order');
    }

    public function defaultColor()
    {
        return $this->hasOne(CarColor::class)->where('is_default', true);
    }

    public function specs()
    {
        return $this->hasMany(CarSpec::class)
                    ->orderBy('category_order')
                    ->orderBy('sort_order');
    }

    public function features()
    {
        return $this->hasMany(CarFeature::class)->orderBy('sort_order');
    }

    public function galleries()
    {
        return $this->hasMany(CarGallery::class)->orderBy('sort_order');
    }

    public function carImages()
    {
        return $this->hasMany(CarGallery::class)
                    ->where('type', 'image')
                    ->orderBy('sort_order');
    }

    public function videos()
    {
        return $this->hasMany(CarGallery::class)
                    ->where('type', 'video')
                    ->orderBy('sort_order');
    }

    // ── Helpers ──────────────────────────────────────────────────
    public function specsByCategory()
    {
        return $this->specs->groupBy('category');
    }

    public function get360Frames(): array
    {
        $prefix = rtrim($this->image_360_prefix ?? '', '/') . '/';
        $total  = $this->image_360_frames ?? 8;
        $frames = [];

        for ($i = 1; $i <= $total; $i++) {
            $relativePath = ltrim(str_replace(url('/'), '', $prefix . $i . '.png'), '/');
            $disk         = public_path($relativePath);

            $frames[$i] = file_exists($disk)
                ? asset($relativePath) . '?t=' . filemtime($disk)
                : null;
        }

        return $frames;
    }

    public function get360FrameCount(): int
    {
        return collect($this->get360Frames())->filter()->count();
    }

    // ── Scopes ───────────────────────────────────────────────────
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByBrand($query, $brand)
    {
        return $query->whereHas('brand', fn($b) => $b->where('name', $brand));
    }

    public function scopePriceBetween($query, $min, $max)
    {
        if ($min) $query->where('price_per_day', '>=', $min);
        if ($max) $query->where('price_per_day', '<=', $max);
        return $query;
    }

    // ── Accessors ────────────────────────────────────────────────
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price_per_day, 0, ',', '.') . ' ₫';
    }

    public function getMainImageAttribute()
    {
        $img = $this->image_url ?? $this->image ?? $this->hero_image ?? null;
        return $img ?? 'images/car-placeholder.jpg';
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'available' => ['label' => 'Còn hàng',   'color' => 'green'],
            'reserved'  => ['label' => 'Đã đặt cọc', 'color' => 'yellow'],
            'sold'      => ['label' => 'Đã bán',      'color' => 'red'],
            default     => ['label' => 'Không rõ',    'color' => 'gray'],
        };
    }

    public function expenses()
    {
        return $this->hasMany(\App\Models\CarExpense::class)->orderBy('id');
    }
}