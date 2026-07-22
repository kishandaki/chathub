<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Services\Auth\AuthService;
use App\Services\Auth\LoginSecurityService;
use App\Services\Auth\TwoFactorService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LoginSecurityService::class, function ($app) {
            return new LoginSecurityService();
        });

        $this->app->singleton(TwoFactorService::class, function ($app) {
            return new TwoFactorService();
        });

        $this->app->singleton(AuthService::class, function ($app) {
            return new AuthService(
                $app->make(LoginSecurityService::class),
                $app->make(TwoFactorService::class),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
