<?php

namespace App\Ship\Providers;

use Illuminate\Auth\Events\Registered;
use App\Containers\User\Listeners\UserEventSubscriber;
use App\Containers\Admin\Listeners\AdminEventSubscriber;
use App\Containers\ChangeLog\Listeners\ChangeLogEventSubscriber;
use App\Containers\Vacancy\Listeners\VacancyEventSubscriber;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    protected $subscribe = [
        AdminEventSubscriber::class,
        UserEventSubscriber::class,
        ChangeLogEventSubscriber::class,
        VacancyEventSubscriber::class,
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
