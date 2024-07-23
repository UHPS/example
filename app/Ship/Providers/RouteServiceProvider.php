<?php

namespace App\Ship\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = 'dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::none();
        });

        Route::get('', function () {
            return 'Welcome to the API, stand with Ukraine 🇺🇦';
        });

        $webRoutes = [
            'Admin',
            'Dashboard',
            'User',
            'Banner',
            'Brand',
            'Logo',
            'Vacancy',
            'Service',
            'News',
            'Page',
            'Auth',
            'TopEmployersVacancy',
            'JobCategory',
            'Review',
            'Consultation',
            'Payment',
            'Company',
            'IncomingApplication',
        ];

        $apiRoutes = [
            'User',
            'Auth',
            'Company',
            'Resume',
            'Experience',
            'Education',
            'Course',
            'Language',
            'FileManager',
            'City',
            'JobCategory',
            'News',
            'Vacancy',
            'Entry',
            'ResumeDocument',
            'Application',
            'Bookmark',
            'TopEmployersVacancy',
            'JobCategory',
            'Review',
            'Consultation',
            'Payment',
            'OpenedContact',
            'Logs',
            'Note',
            'Page',
            'Notification',
            'Service',
            'Invoice',
            'Banner',
            'Brand',
            'Location',
            'Verification',
            'SavedSearch',
            'Employer',
            'PaymentHub',
            'IncomingApplication',
        ];


        $this->routes(function () use ($webRoutes, $apiRoutes) {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->prefix('services')
                ->group(base_path('routes/web.php'));

            foreach ($webRoutes as $webRoute) {
                Route::middleware(['web'])
                    // ->prefix('admin')
                    ->group(base_path('app/Containers/' . $webRoute . '/UI/WEB/Routes/RouteProvider.php'));
            }

            foreach ($apiRoutes as $apiRoute) {
                Route::middleware(['api'])
                    ->prefix('api')
                    ->group(base_path('app/Containers/' . $apiRoute . '/UI/API/Routes/RouteProvider.php'));
            }
        });
    }
}
