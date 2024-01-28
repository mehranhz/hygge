<?php

namespace App\Providers;

use App\Services\Contracts\UserRegistrationInterface;
use App\Services\UserRegistrationService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRegistrationInterface::class, UserRegistrationService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
