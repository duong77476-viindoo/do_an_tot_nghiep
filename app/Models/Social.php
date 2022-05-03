<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;
    protected $fillable = [
        'provider_id', 'provider_email', 'provider',  'user_id'
    ];

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

}
