<?php

namespace App\Providers;

use App\Repositories\AdminRepository;
use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Repositories\Contracts\SettingRepositoryInterface;
use App\Repositories\SettingRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            AdminRepositoryInterface::class,
            AdminRepository::class,
        );

        $this->app->bind(
            SettingRepositoryInterface::class,
            SettingRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
