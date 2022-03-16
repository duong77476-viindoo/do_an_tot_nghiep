<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;
    public function product_variation_values(){
        return $this->hasMany(ProductVariationValue::class);
    }

    public function product_line(){
        return $this->belongsTo(ProductLine::class);
    }
}
