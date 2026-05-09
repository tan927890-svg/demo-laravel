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

    /** Giờ tăng ca trong ngày (chỉ tính từ giờ thứ 9 trở đi) */
    public function getOvertimeHoursAttribute(): float
    {
        if (!$this->check_in_at || !$this->check_out_at) return 0;
        $worked = $this->check_in_at->diffInMinutes($this->check_out_at) / 60;
        return round(max(0, $worked - 8), 1);
    }

    /** Đếm số ngày làm đủ 8 tiếng trong tháng */
    public static function countValidDays(int $userId, int $month, int $year): int
    {
        return self::where('user_id', $userId)
            ->whereYear('work_date', $year)
            ->whereMonth('work_date', $month)
            ->whereNotNull('check_out_at')
            ->get()
            ->filter(fn($a) => $a->work_hours >= 8)
            ->count();
    }

    /** Tổng giờ tăng ca trong tháng */
    public static function countOvertimeHours(int $userId, int $month, int $year): float
    {
        return round(
            self::where('user_id', $userId)
                ->whereYear('work_date', $year)
                ->whereMonth('work_date', $month)
                ->whereNotNull('check_out_at')
                ->get()
                ->sum(fn($a) => $a->overtime_hours),
            1
        );
    }
}