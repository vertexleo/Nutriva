<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\SocialiteManager;

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
        Vite::prefetch(concurrency: 3);

        $this->app->booted(function () {
            $socialite = $this->app->make(SocialiteManager::class);
            $socialite->extend('microsoft', function ($app) {
                return $app->make('Laravel\\Socialite\\Two\\ProviderFactory')->createProvider(
                    'SocialiteProviders\\Microsoft\\Provider',
                    $app['config']['services.microsoft']
                );
            });
        });
    }
}
