<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function PHPUnit\Framework\exactly;

class Product extends Model
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

    public function video(){
        return $this->belongsTo(Video::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function product_line(){
        return $this->belongsTo(ProductLine::class);
    }
    protected static function boot() {
        parent::boot();



        static::saving(function ($product){
            $product->code = Str::slug($product->name);
            $product->meta_keywords = 'BC '.$product->name;
        });

        static::saved(function ($product){
            CategoryProductProduct::where('product_id',$product->id)->delete();
        });

        static::deleting(function ($product){
            CategoryProductProduct::where('product_id',$product->id)->delete();
            if($product->anh_dai_dien!='no-image.jpeg')
                unlink('public/uploads/products/'.$product->anh_dai_dien);
        });
    }
}
