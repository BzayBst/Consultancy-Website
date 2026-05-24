<?php

namespace App\Providers;

use App\Repositories\AboutHeroSectionRepository;
use App\Repositories\AboutRepository;
use App\Repositories\AdminRepository;
use App\Repositories\Contracts\AboutHeroSectionRepositoryInterface;
use App\Repositories\Contracts\AboutRepositoryInterface;
use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Repositories\Contracts\CoreValuesRepositoryInterface;
use App\Repositories\Contracts\HeroSlideRepositoryInterface;
use App\Repositories\Contracts\SettingRepositoryInterface;
use App\Repositories\Contracts\TeamRepositoryInterface;
use App\Repositories\Contracts\WhyUsRepositoryInterface;
use App\Repositories\CoreValuesRepository;
use App\Repositories\HeroSlideRepository;
use App\Repositories\SettingRepository;
use App\Repositories\TeamRepository;
use App\Repositories\WhyUsRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);

        $this->app->bind(
            SettingRepositoryInterface::class,
            SettingRepository::class,
        );

        $this->app->bind(
            HeroSlideRepositoryInterface::class,
            HeroSlideRepository::class,
        );

        $this->app->bind(
            AboutRepositoryInterface::class,
            AboutRepository::class
        );

        
        $this->app->bind(
            WhyUsRepositoryInterface::class,
            WhyUsRepository::class,
        );

         $this->app->bind(
            CoreValuesRepositoryInterface::class,
            CoreValuesRepository::class,
        );

         $this->app->bind(TeamRepositoryInterface::class, TeamRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
