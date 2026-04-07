<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarVariant extends Model
{
    protected $fillable = ['car_id', 'name', 'price', 'sort_order'];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function specs(): HasMany
    {
        return $this->hasMany(CarSpec::class, 'variant_id')
                    ->orderBy('category_order')
                    ->orderBy('sort_order');
    }

    public function features(): HasMany
    {
        return $this->hasMany(CarFeature::class, 'variant_id')
                    ->orderBy('sort_order');
    }

    public function formattedPrice(): string
    {
        return number_format($this->price, 0, ',', '.') . ' VNĐ';
    }
}