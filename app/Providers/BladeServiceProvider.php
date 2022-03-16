<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Blade::if('hasRole',function ($role_name){
            if(Auth::user()){//nếu đã đăng nhập
                if(Auth::user()->hasAnyRoles($role_name))
                    return true;
            }
            return false;
        });
    }
}
