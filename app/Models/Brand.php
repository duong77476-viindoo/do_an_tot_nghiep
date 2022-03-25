<?php

namespace App\Models;

use App\api\API_V1;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'brand_name',
        'brand_slug',
        'brand_desc',
        'brand_status',
        'meta_keywords'
    ];

    public function product_groups(){
        return $this->hasMany(ProductGroup::class);
    }



    //đoạn này tạo ra một số hàm như beforeSave, afterSave giống Yii
    protected static function boot() {
        parent::boot();

//        static::creating(function ($param) {
//            $param->slug = Str::slug($param->name);
//        });

        static::saving(function ($brand){
            $brand->brand_slug = Str::slug($brand->brand_name);
            $brand->meta_keywords = 'BC '.$brand->name;
        });



//        static::deleting(function ($brand){
//
//        });
    }
}
