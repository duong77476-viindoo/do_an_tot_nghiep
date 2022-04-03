<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DacTinh extends Model
{
    use HasFactory;

    public function nganh_hang(){
        return $this->belongsTo(NganhHang::class);
    }

    protected static function boot() {
        parent::boot();

        static::saving(function ($dac_tinh){
            $dac_tinh->code = Str::slug($dac_tinh->name);
        });

    }
}
