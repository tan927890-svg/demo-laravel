<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaoGiaNhanh extends Model
{
    protected $table = 'bao_gia_nhanh';
    protected $fillable = ['ten', 'so_dien_thoai', 'dong_xe'];
}
