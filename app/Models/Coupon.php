<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    public function get_tinh_nang($tinh_nang){
        if ($tinh_nang==1){
            return 'Giảm theo phần trăm';
        }else
            return 'Giảm theo tiền';
    }
}
