<?php

namespace App\Ship\Providers;

use App\Ship\Service\SuperAdminState;
use Illuminate\Support\ServiceProvider;

class SuperAdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SuperAdminState::class, function ($app) {
            return new SuperAdminState();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
