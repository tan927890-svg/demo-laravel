<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiTier extends Model
{
    protected $fillable = [
        'min_percent',
        'max_percent',
        'bonus_amount',
        'bonus_over_target_percent',
        'label',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Tìm bậc thưởng phù hợp với % KPI đạt được
    public static function findForPercent(float $percent): ?static
    {
        return static::where('is_active', true)
            ->where('min_percent', '<=', $percent)
            ->where(function ($q) use ($percent) {
                $q->whereNull('max_percent')
                  ->orWhere('max_percent', '>=', $percent);
            })
            ->orderByDesc('min_percent')
            ->first();
    }

    // Tính tiền thưởng dựa trên % KPI và doanh thu thực tế
    public function calculateBonus(float $actualRevenue, float $targetRevenue): int
    {
        $bonus = (int) $this->bonus_amount;

        // Nếu có thưởng % phần vượt chỉ tiêu
        if ($this->bonus_over_target_percent > 0 && $targetRevenue > 0) {
            $overRevenue = max(0, $actualRevenue - $targetRevenue);
            $bonus += (int) round($overRevenue * $this->bonus_over_target_percent / 100);
        }

        return $bonus;
    }
}
