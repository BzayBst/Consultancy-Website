<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CoursePage;
use App\Models\GalleryImage;
use App\Models\StudyAbroadDestination;
use App\Models\StudyAbroadPage;
use App\Services\AboutService;
use App\Services\TeamService;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home');
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
}
