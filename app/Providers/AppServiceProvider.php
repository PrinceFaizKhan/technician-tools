<?php

namespace App\Providers;

use App\Services\AppSettingsService;
use App\Services\ErrorCodeSearchService;
use App\Services\MediaStorageService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Singleton pattern bindings
        $this->app->singleton(AppSettingsService::class, fn () => new AppSettingsService);
        $this->app->singleton(MediaStorageService::class, fn () => new MediaStorageService);
        $this->app->singleton(ErrorCodeSearchService::class, fn () => new ErrorCodeSearchService);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
