{{-- resources/views/pages/courses.blade.php --}}
@extends('layouts.app', ['active' => 'courses'])

@php
    $courses = collect($courses ?? []);
    $courseCategories = collect($courseCategories ?? []);
    $stats = collect($coursePage?->stats ?? []);
    $whyItems = collect($coursePage?->why_items ?? []);
@endphp

@section('title', 'Courses - ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description', $coursePage?->hero_subtitle ?: 'Explore the courses offered by HASU Educational Consultancy.')

@section('content')
    <x-frontend.page-hero
        badge="{{ $coursePage?->hero_badge ?: 'HASU Language Institute' }}"
        title="{{ $coursePage?->hero_title ?: 'Language & Test Prep' }}"
        highlight="{{ $coursePage?->hero_highlight ?: 'Courses' }}"
        subtitle="{{ $coursePage?->hero_subtitle ?: 'Internationally recognized language training and exam preparation taught by certified experts at our institute.' }}"
        :breadcrumbs="[['label' => 'Home', 'url' => route('home')], ['label' => 'All Courses']]"
    />

    <section id="courses-intro" class="section">
        <div class="container">
            <div class="courses-page-intro fade-up">
                <div class="section-label">{{ $coursePage?->intro_label ?: 'What We Teach' }}</div>
                <h2 class="section-title">{{ $coursePage?->intro_title ?: 'Prepare for Your Future Abroad' }}</h2>
                <p class="section-sub">{{ $coursePage?->intro_subtitle ?: 'From language mastery to test preparation, HASU offers structured programs with mock tests, small batches, and personalized coaching.' }}</p>
            </div>
        </div>
    </section>

    @if($stats->isNotEmpty())
    <section id="stats">
        <div class="container" style="padding:0 24px">
            <div class="stats-inner">
                @foreach($stats as $i => $stat)
                <div class="stat-item fade-up" style="transition-delay:{{ $i * .1 }}s">
                    <span class="stat-num">{{ $stat['number'] ?? '' }}<span class="accent">{{ $stat['accent'] ?? '' }}</span></span>
                    <span class="stat-label">{{ $stat['label'] ?? '' }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if($featuredCourse)
    <section id="course-featured" style="margin-top: 5px;">
        <div class="container">
            <div class="course-featured-card fade-up">
                <div class="cf-img">
                    @if($featuredCourse->image_url)
                        <img src="{{ $featuredCourse->image_url }}" alt="{{ $featuredCourse->title }}">
                    @endif
                    @if($featuredCourse->badge)
                        <span class="course-flag">{{ $featuredCourse->badge }}</span>
                    @endif
                </div>
                <div class="cf-body">
                    @if($featuredCourse->tag)
                        <span class="course-list-tag" style="background:var(--blue-light);color:var(--blue)">{{ $featuredCourse->tag }}</span>
                    @endif
                    <h2>{{ $featuredCourse->title }}</h2>
                    <p>{{ $featuredCourse->excerpt ?: $featuredCourse->overview }}</p>
                    @if(! empty($featuredCourse->highlights))
                    <ul class="cf-highlights">
                        @foreach(array_slice($featuredCourse->highlights, 0, 3) as $highlight)
                            <li>{{ $highlight['item'] ?? '' }}</li>
                        @endforeach
                    </ul>
                    @endif
                    <div class="cf-actions">
                        <a href="{{ route('course.show', $featuredCourse->slug) }}" class="btn btn-primary">View Course Details</a>
                        <a href="{{ route('contact') }}" class="btn btn-secondary">Apply Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <section id="courses-listing">
        <div class="container">
            <div class="courses-listing-head fade-up">
                <div>
                    <div class="section-label" style="margin-bottom:8px">{{ $coursePage?->catalog_label ?: 'Browse All' }}</div>
                    <h2 class="section-title" style="margin-bottom:0;text-align:left">{{ $coursePage?->catalog_title ?: 'Our Course Catalog' }}</h2>
                </div>
                @if($courseCategories->isNotEmpty())
                <div class="course-filters" id="courseFilters">
                    <button type="button" class="cf-filter-btn active" data-filter="all">All</button>
                    @foreach($courseCategories as $category)
                        <button type="button" class="cf-filter-btn" data-filter="{{ $category }}">{{ Str::headline($category) }}</button>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="courses-grid courses-page-grid" id="coursesGrid">
                @forelse($courses as $i => $course)
                <a href="{{ route('course.show', $course->slug) }}" class="course-card course-card-link course-list-card fade-up"
                    data-category="{{ $course->category }}" style="transition-delay:{{ ($i % 6) * .06 }}s">
                    <div class="course-img">
                        @if($course->image_url)
                            <img src="{{ $course->image_url }}" alt="{{ $course->title }}">
                        @endif
                        @if($course->badge)
                            <div class="course-flag">{{ $course->badge }}</div>
                        @endif
                    </div>
                    <div class="course-body">
                        @if($course->tag)
                            <span class="course-list-tag">{{ $course->tag }}</span>
                        @endif
                        <h4>{{ $course->title }}</h4>
                        <p>{{ $course->excerpt }}</p>
                        <span class="course-card-cta">View Course</span>
                    </div>
                </a>
                @empty
                <div class="sa-empty">
                    <strong>No courses added yet.</strong>
                    <span>Please add courses from the admin CMS.</span>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    @if($whyItems->isNotEmpty())
    <section id="courses-why">
        <div class="container">
            <div class="courses-why-inner fade-up">
                <div class="courses-why-text">
                    <div class="section-label courses-why-label">{{ $coursePage?->why_label ?: 'Why HASU' }}</div>
                    <h2 class="courses-why-title">{{ $coursePage?->why_title ?: 'Why Students Choose Our Courses' }}</h2>
                    <p>{{ $coursePage?->why_description }}</p>
                    <a href="{{ $coursePage?->cta_button_url ?: route('contact') }}" class="btn btn-primary">Book Free Assessment</a>
                </div>
                <div class="courses-why-grid">
                    @foreach($whyItems as $item)
                    <div class="courses-why-item">
                        <div class="icon-wrap">{{ $item['icon'] ?? '*' }}</div>
                        <h5>{{ $item['title'] ?? '' }}</h5>
                        <p>{{ $item['description'] ?? '' }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <section id="cta-banner" class="cta-courses">
        <div class="container">
            <div class="cta-inner">
                <div class="cta-text fade-up">
                    <h2>{{ $coursePage?->cta_title ?: 'Not Sure Which Course Is Right for You?' }}</h2>
                    <p>{{ $coursePage?->cta_subtitle ?: 'Visit our campus or book a free assessment. We will recommend the best program for your goals.' }}</p>
                    <div class="cta-actions">
                        <a href="{{ $coursePage?->cta_button_url ?: route('contact') }}" class="btn btn-cta-primary">{{ $coursePage?->cta_button_label ?: 'Apply Now' }}</a>
                        <a href="{{ $coursePage?->cta_phone_url ?: 'tel:+97756493528' }}" class="btn btn-cta-ghost">{{ $coursePage?->cta_phone_label ?: 'Call Us Today' }}</a>
                    </div>
                </div>
                <div class="cta-contact cta-contact-card fade-up" style="transition-delay:.15s">
                    <span class="cta-contact-label">Get in touch</span>
                    <a href="mailto:{{ setting('contact_email', 'info@hasuedu.com') }}">{{ setting('contact_email', 'info@hasuedu.com') }}</a>
                    <a href="tel:+97756493528">056-493528</a>
                    <a href="tel:+9779853646493">9853646493</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const filterBtns = document.querySelectorAll('.cf-filter-btn');
        const courseCards = document.querySelectorAll('#coursesGrid .course-list-card');
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const filter = btn.dataset.filter;
                courseCards.forEach(card => {
                    const cat = card.dataset.category;
                    card.style.display = (filter === 'all' || cat === filter) ? '' : 'none';
                });
            });
        });
    </script>
@endpush
