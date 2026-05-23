<?php

use App\Livewire\Admin\About\AboutPage;
use App\Livewire\Admin\Auth\Login;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Hero\HeroSlides;
use App\Livewire\Admin\Settings\SiteSettings;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('home');


Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/ventures', function () {
    return view('pages.ventures');
})->name('ventures');

Route::get('/courses', function () {
    return view('pages.courses');
})->name('courses');

Route::get('/course-detail', function () {
    return view('pages.course-detail');
})->name('course.detail');

Route::get('/study-abroad', function () {
    return view('pages.study-abroad');
})->name('study-abroad');

Route::get('study-abroad-detail', function () {
    return view('pages.study-abroad-detail');
})->name('study-abroad-detail');

Route::get('/blog', function () {
    return view('pages.blog');
})->name('blog');

Route::get('/gallery', function () {
    return view('pages.gallery');
})->name('gallery');

Route::get('/book-appointment', function () {
    return view('pages.book-appointment');
})->name('book-appointment');

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

        Route::get('/about-page', AboutPage::class)->name('about-page');

        // Logout (POST to prevent CSRF-free logouts)
        Route::post('/logout', function () {
            auth('admin')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()->route('admin.login');
        })->name('logout');

    });

});
