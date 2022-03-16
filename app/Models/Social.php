<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;
    protected $fillable = [
        'provider_id',  'provider',  'user_id'
    ];

    public function admin(){
        return $this->belongsTo(Admin::class, 'user_id');
    }

}
