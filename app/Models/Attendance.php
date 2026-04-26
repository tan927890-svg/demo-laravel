<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'check_in_at',
        'check_in_lat',
        'check_in_lng',
        'check_in_address',
        'check_out_at',
        'check_out_lat',
        'check_out_lng',
        'check_out_address',
        'work_date',
    ];

    protected $casts = [
        'check_in_at'  => 'datetime',
        'check_out_at' => 'datetime',
        'work_date'    => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Tổng giờ làm trong ngày */
    public function getWorkHoursAttribute(): ?float
    {
        if ($this->check_in_at && $this->check_out_at) {
            return round($this->check_in_at->diffInMinutes($this->check_out_at) / 60, 1);
        }
        return null;
    }
}
