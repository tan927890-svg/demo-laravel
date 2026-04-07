<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarFeature extends Model
{
    protected $fillable = [
        'car_id', 'variant_id',
        'title', 'description', 'image', 'image2', 'sort_order',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(CarVariant::class);
    }

    public function featureImages(): HasMany
    {
        return $this->hasMany(CarFeatureImage::class)->orderBy('sort_order');
    }

    /**
     * Lấy ảnh theo variant_id
     * Ưu tiên: ảnh của variant cụ thể → ảnh mặc định (variant_id = NULL)
     */
    public function imagesForVariant(?int $variantId = null)
    {
        return $this->featureImages()
            ->where(function ($q) use ($variantId) {
                $q->where('variant_id', $variantId)
                  ->orWhereNull('variant_id');
            })
            ->orderByRaw('CASE WHEN variant_id IS NULL THEN 1 ELSE 0 END')
            ->get();
    }
}