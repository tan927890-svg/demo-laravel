<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Deposit extends Model
{
    protected $fillable = [
        'car_id',
        'color_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'customer_id_card',
        'deposit_amount',
        'payment_method',
        'transaction_code',
        'status',
        'note',
        'confirmed_at',
        'assigned_to',
        'staff_note',
        'final_amount',
        'final_payment_method',
        'final_payment_note',
        'final_paid_at',
        'finalized_by',
    ];

    protected $casts = [
        'confirmed_at'   => 'datetime',
        'final_paid_at'  => 'datetime',
        'deposit_amount' => 'decimal:0',
        'final_amount'   => 'decimal:0',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($deposit) {
            $deposit->transaction_code = 'DEP-' . strtoupper(Str::random(10));
        });
    }

    // Quan hệ
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function color()
    {
        return $this->belongsTo(CarColor::class, 'color_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function finalizedBy()
    {
        return $this->belongsTo(User::class, 'finalized_by');
    }

    // Accessor: amount — alias của deposit_amount (dùng trong view)
    public function getAmountAttribute()
    {
        return $this->deposit_amount;
    }

    // Accessor: nhãn trạng thái
    public function getStatusLabelAttribute()
    {
        $map = [
            'pending'   => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'cancelled' => 'Đã huỷ',
            'completed' => 'Hoàn tất',
            'refunded'  => 'Đã hoàn cọc',
        ];

        return $map[$this->status] ?? 'Không rõ';
    }

    // Accessor: nhãn phương thức thanh toán
    public function getPaymentMethodLabelAttribute()
    {
        $map = [
            'bank_transfer' => 'Chuyển khoản ngân hàng',
            'cash'          => 'Tiền mặt tại showroom',
            'momo'          => 'Ví MoMo',
            'vnpay'         => 'VNPay',
        ];

        return $map[$this->payment_method] ?? $this->payment_method;
    }
}