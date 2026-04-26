<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
   protected $fillable = [
    'name', 'email', 'phone', 'subject',
    'message', 'is_read', 'car_interest',
    'assigned_to', 'staff_note', 'assigned_at', 'assign_status',
];

protected $casts = [
    'is_read'     => 'boolean',
    'assigned_at' => 'datetime',
];

public function assignedTo()
{
    return $this->belongsTo(User::class, 'assigned_to');
}

}