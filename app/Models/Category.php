<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    public function category_products(){
        return $this->hasMany(CategoryProduct::class);
    }

    protected static function boot() {
        parent::boot();

        static::saving(function ($cate){
            $cate->code = Str::slug($cate->nganh_hang->name.'-'.$cate->name);
        });

    }

    public function nganh_hang(){
        return $this->belongsTo(NganhHang::class);
    }
}
