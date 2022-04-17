<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhaCungCap extends Model
{
    use HasFactory;

    public function phieu_nhaps(){
        return $this->hasMany(PhieuNhap::class);
    }

    public function cong_no_nccs(){
        return $this->hasMany(CongNoNcc::class);
    }

    public function thanh_toan_cong_no_nccs(){
        return $this->hasMany(ThanhToanCongNoNcc::class);
    }
}
