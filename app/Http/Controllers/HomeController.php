<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CoursePage;
use App\Models\Event;
use App\Models\GalleryImage;
use App\Models\BlogPost;
use App\Models\StudyAbroadDestination;
use App\Models\StudyAbroadPage;
use App\Models\HomeService;
use App\Models\HomeTestimonial;
use App\Models\Venture;
use App\Services\AboutService;
use App\Services\EventService;
use App\Services\TeamService;

class HomeController extends Controller
{
    public function index(EventService $eventService)
    {
        $events = Event::active()
            ->get()
            ->sortBy(fn (Event $event) => [
                in_array($event->status, ['upcoming', 'ongoing'], true) ? 0 : 1,
                in_array($event->status, ['upcoming', 'ongoing'], true)
                    ? optional($event->event_date)->timestamp
                    : - optional($event->event_date)->timestamp,
            ])
            ->values();

        $featuredEvent = $events->firstWhere('is_featured', true) ?? $events->first();

        return view('pages.home', [
            'ventures' => Venture::active()->ordered()->take(3)->get(),
            'homeServices' => HomeService::first(),
            'homeTestimonials' => HomeTestimonial::first(),
            'courses' => Course::active()->ordered()->take(3)->get(),
            'coursePage' => CoursePage::first(),
            'destinations' => StudyAbroadDestination::active()->ordered()->take(4)->get(),
            'studyAbroadPage' => StudyAbroadPage::first(),
            'eventSection' => $eventService->getSectionSettings(),
            'featuredEvent' => $featuredEvent,
            'events' => $events
                ->when($featuredEvent, fn ($items) => $items->reject(fn ($event) => $event->is($featuredEvent)))
                ->take(4)
                ->values(),
            'latestBlogPosts' => BlogPost::active()->published()->ordered()->take(3)->get(),
        ]);
    }

    public function about(AboutService $aboutService, TeamService $teamService)
    {
        return view('pages.about', [
            'aboutHero' => $aboutService->getHero(),
            'aboutStory' => $aboutService->getStory(),
            'aboutMilestones' => $aboutService->getMilestones()
                ->where('is_active', true)
                ->values(),
            'aboutStats' => $aboutService->getStats()
                ->where('is_active', true)
                ->values(),
            'aboutMvCards' => $aboutService->getMvCards()
                ->where('is_active', true)
                ->values(),
            'teams' => $teamService->all(),
        ]);
    }

    public function gallery()
    {
        $galleryImages = GalleryImage::active()->ordered()->get();

        return view('pages.gallery', [
            'galleryImages' => $galleryImages,
            'galleryCategories' => $galleryImages
                ->pluck('category')
                ->unique()
                ->values(),
        ]);
    }

    public function blog()
    {
        return view('pages.blog', [
            'posts' => BlogPost::active()->published()->ordered()->paginate(9),
        ]);
    }

    public function blogDetail(BlogPost $post)
    {
        abort_unless($post->is_active && (! $post->published_at || $post->published_at->lte(now())), 404);

        return view('pages.blog-detail', [
            'post' => $post,
            'otherPosts' => BlogPost::active()
                ->published()
                ->where('id', '!=', $post->id)
                ->ordered()
                ->take(3)
                ->get(),
        ]);
    }

    public function courses()
    {
        $courses = Course::active()->ordered()->get();

        return view('pages.courses', [
            'coursePage' => CoursePage::first(),
            'courses' => $courses,
            'featuredCourse' => $courses->firstWhere('is_featured', true) ?? $courses->first(),
            'courseCategories' => $courses->pluck('category')->filter()->unique()->values(),
        ]);
    }

    public function firstCourseDetail()
    {
        $course = Course::active()->ordered()->first();

        return $course
            ? redirect()->route('course.show', $course->slug)
            : redirect()->route('courses');
    }

    public function courseDetail(Course $course)
    {
        abort_unless($course->is_active, 404);

        return view('pages.course-detail', [
            'coursePage' => CoursePage::first(),
            'course' => $course,
            'otherCourses' => Course::active()
                ->where('id', '!=', $course->id)
                ->ordered()
                ->take(3)
                ->get(),
        ]);
    }

    public function studyAbroad()
    {
        return view('pages.study-abroad', [
            'studyAbroadPage' => StudyAbroadPage::first(),
            'destinations' => StudyAbroadDestination::active()->ordered()->get(),
        ]);
    }

    public function studyAbroadDetail(StudyAbroadDestination $destination)
    {
        abort_unless($destination->is_active, 404);

        return view('pages.study-abroad-detail', [
            'studyAbroadPage' => StudyAbroadPage::first(),
            'destination' => $destination,
        ]);
    }

    public function eventDetail(Event $event)
    {
        abort_unless($event->is_active, 404);

        return view('pages.event-detail', [
            'event' => $event,
            'otherEvents' => Event::active()
                ->where('id', '!=', $event->id)
                ->orderBy('event_date')
                ->take(3)
                ->get(),
        ]);
    }
}
