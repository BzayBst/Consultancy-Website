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
use App\Repositories\Contracts\HomeAboutRepositoryInterface;
use App\Repositories\Contracts\SettingRepositoryInterface;
use App\Repositories\Contracts\TeamRepositoryInterface;
use App\Repositories\Contracts\VentureRepositoryInterface;
use App\Repositories\Contracts\WhyUsRepositoryInterface;
use App\Repositories\CoreValuesRepository;
use App\Repositories\HeroSlideRepository;
use App\Repositories\HomeAboutRepository;
use App\Repositories\SettingRepository;
use App\Repositories\TeamRepository;
use App\Repositories\VentureRepository;
use App\Repositories\WhyUsRepository;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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

         $this->app->bind(VentureRepositoryInterface::class, VentureRepository::class);

           $this->app->bind(
            HomeAboutRepositoryInterface::class,
            HomeAboutRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('contact-form', function (Request $request) {
            $key = $request->ip().'|'.strtolower((string) $request->input('email'));

            return [
                Limit::perMinute(3)->by($key),
                Limit::perHour(12)->by($request->ip()),
                Limit::perDay(30)->by($request->ip()),
            ];
        });

        RateLimiter::for('appointment-form', function (Request $request) {
            $key = $request->ip().'|'.strtolower((string) $request->input('email'));

            return [
                Limit::perMinute(2)->by($key),
                Limit::perHour(8)->by($request->ip()),
                Limit::perDay(20)->by($request->ip()),
            ];
        });
    }
}
