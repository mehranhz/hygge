<?php

namespace App\Providers;

use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\EmailVerificationTokenRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\EmailVerificationTokenRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(EloquentRepositoryInterface::class,BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(EmailVerificationTokenRepositoryInterface::class, EmailVerificationTokenRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
