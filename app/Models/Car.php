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
    'brand',        // giữ lại cột cũ (string) — có thể dùng để migration data
    'brand_id',     // cột mới — foreign key
    'model',
    'year',
    'price',
    'price_per_day',
    'color',
    'mileage',
    'fuel_type',
    'image_url',   // ← thêm dòng này
    'transmission',
    'condition',
    'engine',
    'seats',
    'description',
    'images',
    'image',
    'status',
    'is_available',
    'slug',
    'tagline',
    'hero_image',
];

public function brand()
{
    return $this->belongsTo(\App\Models\Brand::class);
}
    protected $casts = [
    'price_per_day' => 'decimal:0',
    'is_available' => 'boolean',
];
    // Auto-generate slug khi tạo mới
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($car) {
            $car->slug = Str::slug($car->name . '-' . $car->year . '-' . uniqid());
        });
    }

    // Relations
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    // ── Relationships mới cho trang detail ──────────────────────

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

public function images()
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

// Helper: specs nhóm theo category
public function specsByCategory()
{
    return $this->specs->groupBy('category');
}

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeByBrand($query, $brand)
    {
        return $query->where('brand', $brand);
    }

    public function scopePriceBetween($query, $min, $max)
    {
        if ($min) $query->where('price', '>=', $min);
        if ($max) $query->where('price', '<=', $max);
        return $query;
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', '.') . ' ₫';
    }

    public function getMainImageAttribute()
    {
        $images = $this->images ?? [];
        return count($images) > 0 ? $images[0] : 'images/car-placeholder.jpg';
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'available' => ['label' => 'Còn hàng',   'color' => 'green'],
            'reserved'  => ['label' => 'Đã đặt cọc', 'color' => 'yellow'],
            'sold'      => ['label' => 'Đã bán',      'color' => 'red'],
            default     => ['label' => 'Không rõ',    'color' => 'gray'],
        };
    }
}
