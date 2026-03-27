<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'brand', 'model', 'year', 'price', 'color',
        'mileage', 'fuel_type', 'transmission', 'condition',
        'engine', 'seats', 'description', 'images', 'status', 'slug',
    ];

    protected $casts = [
        'images' => 'array',
        'price'  => 'decimal:0',
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
