<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarColor extends Model
{
    protected $fillable = [
        'car_id', 'name', 'hex_code', 'image',
        'price_addon', 'is_default', 'sort_order',
    ];

    protected $casts = [
        'is_default'  => 'boolean',
        'price_addon' => 'decimal:0',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}