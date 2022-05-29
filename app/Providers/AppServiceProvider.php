<?php

namespace App\Providers;

use App\Models\NganhHang;
use App\Models\Product;
use Illuminate\Support\ServiceProvider;
use Sendportal\Base\Facades\Sendportal;
use function Clue\StreamFilter\fun;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Sendportal::setCurrentWorkspaceIdResolver(function (){
            return 1;
        });

        Sendportal::setSidebarHtmlContentResolver(function () {
            return view('admin.marketing.manageUsersMenuItem')->render();
        });

        Sendportal::setHeaderHtmlContentResolver(function () {
            return view('admin.marketing.userManagementHeader')->render();
        });

        view()->composer('*',function ($view){
            $min_price = Product::min('gia_ban');
            $max_price = Product::max('gia_ban') +1000;
            $nganh_hangs = NganhHang::all();
            $view->with('min_price',$min_price)
                ->with('max_price',$max_price)
                ->with('nganh_hangs',$nganh_hangs);
        });
    }
}
