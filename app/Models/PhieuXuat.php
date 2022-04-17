<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuXuat extends Model
{
    use HasFactory;
    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
