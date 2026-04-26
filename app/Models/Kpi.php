<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Kpi.php
class Kpi extends Model
{
    protected $fillable = [
        'user_id', 'target_revenue', 'actual_revenue',
        'target_orders', 'actual_orders', 'year', 'month',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Tính % đạt KPI
    public function getPercentAttribute(): float
    {
        if ($this->target_revenue == 0) return 0;
        return round(($this->actual_revenue / $this->target_revenue) * 100, 1);
    }

    public function getStatusAttribute(): string
    {
        return $this->percent >= 100 ? 'Đạt' : 'Chưa đạt';
    }
}
