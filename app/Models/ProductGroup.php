<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function PHPUnit\Framework\exactly;

class ProductGroup extends Model
{
    use HasFactory;
    public function category_products(){
        return $this->belongsToMany(CategoryProduct::class);
    }


    public function orders(){
        return $this->belongsToMany(Order::class);
    }
    public function galleries(){
        return $this->hasMany(Gallery::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function video(){
        return $this->belongsTo(Video::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function nganh_hang(){
        return $this->belongsTo(NganhHang::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    protected static function boot() {
        parent::boot();



        static::saving(function ($product_group){
            $product_group->code = Str::slug($product_group->name);
            $product_group->meta_keywords = 'BC '.$product_group->name;
        });

        static::saved(function ($product_group){
            CategoryProductProduct::where('product_group_id',$product_group->id)->delete();
        });

        static::deleting(function ($product_group){
            CategoryProductProduct::where('product_group_id',$product_group->id)->delete();
            if($product_group->anh_dai_dien!='no-image.jpeg')
                unlink('public/uploads/products/'.$product_group->anh_dai_dien);
        });
    }
}
