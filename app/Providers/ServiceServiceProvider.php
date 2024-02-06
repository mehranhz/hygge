<?php

namespace App\Providers;

use App\Services\AuthenticateViaEmailAndPasswordService;
use App\Services\Contracts\AuthenticationInterface;
use App\Services\Contracts\EmailVerificationInterface;
use App\Services\Contracts\PermissionCreateInterface;
use App\Services\Contracts\PermissionListInterface;
use App\Services\Contracts\RoleCreateInterface;
use App\Services\Contracts\RoleListInterface;
use App\Services\Contracts\UserRegistrationInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\EmailVerificationService;
use App\Services\PermissionCreateService;
use App\Services\PermissionListService;
use App\Services\RoleCreateService;
use App\Services\RoleListService;
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
        $this->app->bind(RoleCreateInterface::class,RoleCreateService::class);
        $this->app->bind(RoleListInterface::class, RoleListService::class);
        $this->app->bind(PermissionCreateInterface::class,PermissionCreateService::class);
        $this->app->bind(PermissionListInterface::class,PermissionListService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
