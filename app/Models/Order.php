<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'car_id',
        'user_id',
        'contact_id',
        'assigned_to',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'deposit_amount',
        'note',
        'status',
        'start_date',
        'end_date',
        'consultation_status',
        'consulted_at',
        'sale_price',
        'commission_rate',
        'commission_amount',
        'closed_at',
        'manager_note',
    ];

    protected $casts = [
        'start_date'   => 'date',
        'end_date'     => 'date',
        'consulted_at' => 'datetime',
        'closed_at'    => 'datetime',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assignedStaff()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function getConsultationLabelAttribute(): string
    {
        return match($this->consultation_status) {
            'moi'          => 'Mới',
            'dang_tu_van'  => 'Đang tư vấn',
            'da_tu_van'    => 'Đã tư vấn',
            'da_chot_don'  => 'Đã chốt đơn',
            'huy'          => 'Huỷ',
            default        => 'Không rõ',
        };
    }

    public function getConsultationBadgeAttribute(): string
    {
        return match($this->consultation_status) {
            'moi'          => 'badge-info',
            'dang_tu_van'  => 'badge-warning',
            'da_tu_van'    => 'badge-primary',
            'da_chot_don'  => 'badge-success',
            'huy'          => 'badge-danger',
            default        => 'badge-secondary',
        };
    }
}