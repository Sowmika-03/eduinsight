<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('authorization', function ($app) {
            return new \App\Services\AuthorizationService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configure mail view paths
        \Illuminate\Support\Facades\View::addNamespace('mail', resource_path('views/emails'));
    }
}
