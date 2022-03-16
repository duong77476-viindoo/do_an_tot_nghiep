<?php

namespace App\Providers;

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
    }
}
