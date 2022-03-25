<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Video extends Model
{
    use HasFactory;
    protected static function boot() {
        parent::boot();

        static::saving(function ($video){
            $video->code = Str::slug($video->title);
        });


    }
    public function product(){
        return $this->belongsTo(ProductGroup::class);
    }
}
