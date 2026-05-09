<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'user_id', 'month', 'year',
        'base_salary', 'total_commission', 'kpi_bonus', 'kpi_percent', 'total_salary',
        'status', 'approved_by', 'approved_at', 'note',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function user()      { return $this->belongsTo(User::class); }
    public function approver()  { return $this->belongsTo(User::class, 'approved_by'); }

    public function isDraft():    bool { return $this->status === 'draft'; }
    public function isApproved(): bool { return $this->status === 'approved'; }
    public function isLocked():   bool { return $this->status === 'approved'; }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft'    => 'Nháp',
            'approved' => 'Đã chốt',
            default    => 'Không xác định',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'draft'    => 'badge-gray',
            'approved' => 'badge-success',
            default    => 'badge-gray',
        };
    }

    public function getPeriodAttribute(): string
    {
        return "Tháng {$this->month}/{$this->year}";
    }
}