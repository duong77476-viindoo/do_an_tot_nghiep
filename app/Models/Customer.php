<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

}
