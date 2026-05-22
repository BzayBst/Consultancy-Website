<?php

use App\Livewire\Admin\Auth\Login;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Hero\HeroSlides;
use App\Livewire\Admin\Settings\SiteSettings;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| All admin routes live under the /admin prefix with the 'web' middleware.
| Protected routes use the 'admin.auth' middleware alias.
| Guest-only routes (login) use the 'admin.guest' middleware alias.
|
*/

Route::prefix('admin')->name('admin.')->middleware(['web'])->group(function () {

    // ── Guest only ────────────────────────────────────────────────────────
    Route::middleware('admin.guest')->group(function () {
        Route::get('/login', Login::class)->name('login');
    });

    // ── Authenticated admin ───────────────────────────────────────────────
    Route::middleware('admin.auth')->group(function () {

        // Dashboard
        Route::get('/dashboard', Dashboard::class)->name('dashboard');

        Route::get('/settings', SiteSettings::class)->name('settings');

        // Hero Slides
        Route::get('/hero-slides', HeroSlides::class)->name('hero-slides');

        // Logout (POST to prevent CSRF-free logouts)
        Route::post('/logout', function () {
            auth('admin')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()->route('admin.login');
        })->name('logout');

    });

});
