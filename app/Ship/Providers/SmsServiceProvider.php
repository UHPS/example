<?php

namespace App\Ship\Providers;

use Illuminate\Support\ServiceProvider;
use App\Containers\Sms\Channels\SmsChannel;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use App\Containers\Sms\Services\SmsDecorator;
use App\Containers\Sms\Contracts\SmsInterface;
use App\Containers\Sms\Services\LogSmsService;
use App\Containers\Sms\Services\SmsClubService;
use App\Containers\Sms\Services\EsputnikService;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->extendSmsManager();
    }

    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(SmsInterface::class, function ($app) {
            $drivers = $this->resolveSmsDrivers();
            return new SmsDecorator(...$drivers);
        });
    }


    protected function extendSmsManager()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('sms', function ($app) {
                return app(SmsChannel::class);
            });
        });
    }

    protected function resolveSmsDrivers(): array
    {
        $drivers = [];
        $selectedDrivers = explode(',', config('sms.drivers'));

        foreach ($selectedDrivers as $driver) {
            switch (trim($driver)) {
                case 'smsclub':
                    $drivers[] = new SmsClubService(
                        config('sms.sms-club.key'),
                        config('sms.sms-club.url')
                    );
                    break;
                case 'esputnik':
                    $drivers[] = new EsputnikService(
                        config('services.esputnik.user'),
                        config('services.esputnik.key'),
                        config('services.esputnik.url')
                    );
                    break;
                case 'log':
                    $drivers[] = new LogSmsService();
                    break;
            }
        }

        return $drivers;
    }
}
