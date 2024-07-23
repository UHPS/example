<?php

namespace App\Ship\Providers;

use Illuminate\Mail\MailManager;
use Illuminate\Support\ServiceProvider;
use App\Ship\Drivers\EsputnikMailDriver;

class EsputnikServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->extendMailManager();
    }

    protected function extendMailManager()
    {
        $this->app->make(MailManager::class)->extend('esputnik', function ($app) {
            return new EsputnikMailDriver(
                config('services.esputnik.user'),
                config('services.esputnik.key'),
                config('services.esputnik.url')
            );
        });
    }
}
