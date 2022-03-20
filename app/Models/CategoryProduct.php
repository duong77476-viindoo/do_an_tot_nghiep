<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CategoryProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_product_name',
        'category_product_desc',
        'category_product_status',
        'meta_keywords',
        'code'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function product_groups(){
        return $this->belongsToMany(ProductGroup::class);
    }

    protected static function boot() {
        parent::boot();

//        static::creating(function ($param) {
//            $param->slug = Str::slug($param->name);
//        });

        static::saving(function ($cate){
            $cate->code = Str::slug($cate->category_product_name);
        });



//        static::deleting(function ($brand){
//
//        });
    }
}
