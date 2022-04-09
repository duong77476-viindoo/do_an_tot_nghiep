<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable=[
        'email','password','name','phone'
    ];

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function phieu_nhaps(){
        return $this->hasMany(PhieuNhap::class);
    }

    public function getAuthPassword(){
        return $this->password;
    }
    public function hasAnyRoles($roles){

        if(is_array($roles)){
            foreach($roles as $role){
                if($this->hasRole($role)){
                    return true;
                }
            }
        }else{
            if($this->hasRole($roles)){
                return true;
            }
        }
        return false;
    }
    public function hasRole($role)
    {
        if($this->roles()->where('name',$role)->first()){
            return true;
        }
        return false;
    }

}
