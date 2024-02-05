<?php

namespace App\Providers;

use App\Services\AuthenticateViaEmailAndPasswordService;
use App\Services\Contracts\AuthenticationInterface;
use App\Services\Contracts\EmailVerificationInterface;
use App\Services\Contracts\RoleCreateServiceInterface;
use App\Services\Contracts\UserRegistrationInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\EmailVerificationService;
use App\Services\RoleCreateService;
use App\Services\UserRegistrationService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRegistrationInterface::class, UserRegistrationService::class);
        $this->app->bind(EmailVerificationInterface::class, EmailVerificationService::class);
        $this->app->bind(UserServiceInterface::class,UserService::class);
        $this->app->bind(AuthenticationInterface::class, AuthenticateViaEmailAndPasswordService::class);
        $this->app->bind(RoleCreateServiceInterface::class,RoleCreateService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
