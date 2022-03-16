<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected static function boot() {
        parent::boot();
        static::deleting(function ($slider){
            if($slider->image!='no-image.jpeg')
                unlink('public/uploads/sliders/'.$slider->image);
        });
    }
}
