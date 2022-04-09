<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuNhap extends Model
{
    use HasFactory;

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function nha_cung_cap(){
        return $this->belongsTo(NhaCungCap::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
