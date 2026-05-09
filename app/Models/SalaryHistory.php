<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryHistory extends Model
{
    protected $fillable = [
        'user_id',
        'base_salary',
        'effective_month',
        'effective_year',
        'created_by',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Lấy lương cứng của một user tại tháng/năm cụ thể
    // Lấy bản ghi gần nhất có hiệu lực <= tháng đó
    public static function getForMonth(int $userId, int $month, int $year): int
    {
        $record = static::where('user_id', $userId)
            ->where(function ($q) use ($month, $year) {
                $q->where('effective_year', '<', $year)
                  ->orWhere(function ($q2) use ($month, $year) {
                      $q2->where('effective_year', $year)
                         ->where('effective_month', '<=', $month);
                  });
            })
            ->orderByDesc('effective_year')
            ->orderByDesc('effective_month')
            ->first();

        return $record ? (int) $record->base_salary : 0;
    }
}
