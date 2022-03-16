<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PostType extends Model
{
    use HasFactory;
    protected static function boot() {
        parent::boot();

        static::saving(function ($post_type){
            $post_type->code = Str::slug($post_type->name);
        });

    }

    public function posts(){
        return $this->hasMany(Post::class);
    }
}
