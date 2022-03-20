<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NganhHang extends Model
{
    use HasFactory;
    public function product_groups(){
        return $this->hasMany(ProductGroup::class);
    }
}
