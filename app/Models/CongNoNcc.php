<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CongNoNcc extends Model
{
    use HasFactory;
    public function nha_cung_cap(){
        return $this->belongsTo(NhaCungCap::class);
    }
}
