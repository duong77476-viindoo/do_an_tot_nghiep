<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NganhHang extends Model
{
    use HasFactory;
    public function product_groups(){
        return $this->hasMany(ProductGroup::class);
    }
    public function dac_tinhs(){
        return $this->hasMany(DacTinh::class);
    }

    protected static function boot() {
        parent::boot();

        static::saving(function ($nganh_hang){
            $nganh_hang->code = Str::slug($nganh_hang->name);
        });

    }
}
