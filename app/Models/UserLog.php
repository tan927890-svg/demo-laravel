<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $fillable = ['user_id', 'causer_id', 'action', 'changes'];
    protected $casts = ['changes' => 'array'];

    public function causer()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}