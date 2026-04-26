<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarExpense extends Model
{
    protected $fillable = [
        'car_id',
        'name',
        'amount',
        'category',
        'note',
    ];

    protected $casts = [
        'amount' => 'decimal:0',
    ];

    // Danh sách chi phí mặc định khi thêm xe mới
    public static array $defaults = [
        ['name' => 'Vận chuyển quốc tế',   'category' => 'vận_chuyển', 'amount' => 0],
        ['name' => 'Thuế nhập khẩu',        'category' => 'thuế',       'amount' => 0],
        ['name' => 'Thuế TTĐB',             'category' => 'thuế',       'amount' => 0],
        ['name' => 'VAT',                   'category' => 'thuế',       'amount' => 0],
        ['name' => 'Phí thông quan',        'category' => 'thuế',       'amount' => 0],
        ['name' => 'Đăng ký / biển số',     'category' => 'đăng_ký',   'amount' => 0],
        ['name' => 'Sửa chữa / tân trang',  'category' => 'sửa_chữa',  'amount' => 0],
        ['name' => 'Marketing / đăng tin',  'category' => 'marketing',  'amount' => 0],
        ['name' => 'Hoa hồng môi giới',     'category' => 'hoa_hồng',  'amount' => 0],
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 0, ',', '.') . ' ₫';
    }
}
