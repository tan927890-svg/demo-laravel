<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'country',
        'default_price_per_day',
        'default_fuel_type',
        'default_transmission',
        'default_seats',
    ];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}