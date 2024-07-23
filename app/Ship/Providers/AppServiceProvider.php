<?php

namespace App\Ship\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Containers\CounterView\UI\WEB\Helpers\GettingQuantityEntityHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('uk');

        if (env('FORCE_HTTPS')) {
            URL::forceScheme('https');
        }

        if (app()->runningInConsole()) {
            $filesystem = new Filesystem();
            $migrationsDirsList = [];

            foreach ($filesystem->directories(app_path('/Containers')) as $directory) {
                $migrationsDir = $directory . '/Data/Migrations';
                if (is_dir($migrationsDir)) {
                    $migrationsDirsList[] = $migrationsDir;
                }
            }

            $this->loadMigrationsFrom($migrationsDirsList);
        }

        JsonResource::withoutWrapping();
        Paginator::useBootstrapFour();

        $this->app->bind('gettingQuantityEntityHelper',function(){
            return app(GettingQuantityEntityHelper::class);
        });
    }
}
