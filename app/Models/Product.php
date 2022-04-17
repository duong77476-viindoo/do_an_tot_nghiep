<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function product_group(){
        return $this->belongsTo(ProductGroup::class);
    }

    public function product_specs(){
        return $this->hasMany(ProductSpec::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function ratings(){
        return $this->hasMany(Rating::class);
    }

    public function orders(){
        return $this->belongsToMany(Order::class);
    }

    public function phieu_nhaps(){
        return $this->belongsToMany(PhieuNhap::class);
    }

    public function phieu_xuats(){
        return $this->belongsToMany(PhieuXuat::class);
    }

}
