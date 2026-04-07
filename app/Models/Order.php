<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'car_id',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'deposit_amount',
        'note',
        'status'
    ];

    // 🔗 Quan hệ với Car
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    // 🔗 Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}