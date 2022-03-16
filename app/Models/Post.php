<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
    protected static function boot() {
        parent::boot();

        static::saving(function ($post){
            $post->code = Str::slug($post->title);
        });

        static::deleting(function ($post){
            if($post->image!='no-image.jpeg')
                unlink('public/uploads/posts/'.$post->image);
        });
    }

    public function post_type(){
        return $this->belongsTo(PostType::class);
    }
}
