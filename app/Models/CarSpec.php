<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarSpec extends Model
{
    protected $fillable = [
        'car_id', 'variant_id',
        'category', 'spec_key', 'spec_value',
        'category_order', 'sort_order',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(CarVariant::class);
    }
}