<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;
    public function products(){
        return $this->belongsToMany(Product::class);
    }

    protected static function boot() {
        parent::boot();



        static::saving(function ($tag){
            $tag->code = Str::slug($tag->name);
            $tag->meta_keywords = 'BC '.$tag->name;
            $tag->desc = $tag->name;
        });

    }
}
