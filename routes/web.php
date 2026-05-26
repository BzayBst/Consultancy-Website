<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\VentureController;
use App\Livewire\Admin\About\AboutPage;
use App\Livewire\Admin\About\CoreValues;
use App\Livewire\Admin\About\Team;
use App\Livewire\Admin\About\WhyUs;
use App\Livewire\Admin\Auth\Login;
use App\Livewire\Admin\CourseManager;
use App\Livewire\Admin\ContactCms;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Event;
use App\Livewire\Admin\Gallery;
use App\Livewire\Admin\Hero\HeroSlides;
use App\Livewire\Admin\Home\HomeAbout;
use App\Livewire\Admin\Settings\SiteSettings;
use App\Livewire\Admin\StudyAbroad;
use App\Livewire\Admin\Venture;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('pages.home');
// })->name('home');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'submitContact'])->name('contact.submit');

Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::get('/ventures',          [VentureController::class, 'index'])->name('ventures');
Route::get('/ventures/{slug}',   [VentureController::class, 'show'])->name('ventures.show');

Route::get('/courses', [HomeController::class, 'courses'])->name('courses');

Route::get('/course-detail', [HomeController::class, 'firstCourseDetail'])->name('course.detail');
Route::get('/courses/{course:slug}', [HomeController::class, 'courseDetail'])->name('course.show');

Route::get('/study-abroad', [HomeController::class, 'studyAbroad'])->name('study-abroad');

Route::get('/study-abroad-detail', function () {
    $destination = \App\Models\StudyAbroadDestination::active()->ordered()->first();

    return $destination
        ? redirect()->route('study-abroad-detail', $destination->slug)
        : redirect()->route('study-abroad');
});

Route::get('/study-abroad/{destination:slug}', [HomeController::class, 'studyAbroadDetail'])->name('study-abroad-detail');

Route::get('/blog', function () {
    return view('pages.blog');
})->name('blog');

Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');

Route::get('/book-appointment', [ContactController::class, 'appointment'])->name('book-appointment');
Route::post('/book-appointment', [ContactController::class, 'submitAppointment'])->name('book-appointment.submit');

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

         // About page sections
        Route::get('/about-page/why-us', WhyUs::class)->name('about-page.why-us');

        Route::get('/teams', Team::class)->name('teams.index');

        Route::get('/events', Event::class)->name('events.index');

        Route::get('/gallery', Gallery::class)->name('gallery.index');

        Route::get('/courses', CourseManager::class)->name('courses.index');

        Route::get('/contact-cms', ContactCms::class)->name('contact-cms.index');

        Route::get('/study-abroad', StudyAbroad::class)->name('study-abroad.index');

         Route::get('/about/core-values', CoreValues::class)->name('about.core-values');

         Route::get('ventures', Venture::class)->name('ventures.index');

           // Home page sections
        Route::get('/home/about', HomeAbout::class)->name('home.about');

         

        // Logout (POST to prevent CSRF-free logouts)
        Route::post('/logout', function () {
            auth('admin')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()->route('admin.login');
        })->name('logout');

    });

});
