@extends('layouts.app', ['active' => 'course-detail'])

@section('title', $course->title . ' - ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description', $course->excerpt ?: $course->overview ?: 'Course details from HASU Educational Consultancy.')

@section('content')
    <x-frontend.page-hero
        badge="{{ $course->badge ?: $coursePage?->hero_badge ?: 'HASU Language Institute' }}"
        title="{{ $course->title }}"
        highlight="Course"
        subtitle="{{ $course->excerpt ?: $coursePage?->hero_subtitle }}"
        :breadcrumbs="[['label' => 'Home', 'url' => route('home')], ['label' => 'All Courses', 'url' => route('courses')], ['label' => $course->title]]"
    />

    <section class="cd-main section">
      <div class="container">
        <div class="cd-layout">
          <div class="cd-content fade-up">
            <h1 class="cd-title">{{ $course->title }}</h1>
            @if(! empty($course->meta_items))
            <div class="cd-meta">
              @foreach($course->meta_items as $item)
                <span>{{ $item['label'] ?? '' }}</span>
              @endforeach
            </div>
            @endif

            <div class="cd-description">
              @if($course->overview)
                <p>{{ $course->overview }}</p>
              @endif
              @foreach($course->description ?? [] as $paragraph)
                @if(! empty($paragraph['body']))
                  <p>{{ $paragraph['body'] }}</p>
                @endif
              @endforeach
            </div>

            @if(! empty($course->highlights))
            <div class="cd-highlights">
              <h3>What You Will Learn</h3>
              <ul>
                @foreach($course->highlights as $highlight)
                  @if(! empty($highlight['item']))
                    <li>{{ $highlight['item'] }}</li>
                  @endif
                @endforeach
              </ul>
            </div>
            @endif

            <div class="cd-mobile-apply">
              <a href="{{ route('contact') }}" class="btn btn-primary btn-block">Apply Now</a>
            </div>
          </div>

          <aside class="cd-sidebar fade-up" style="transition-delay:.1s">
            <div class="cd-sidebar-card">
              <div class="cd-sidebar-flag">{{ $course->badge ?: 'Course' }}</div>
              <h3>{{ $course->sidebar_title ?: 'Enroll Today' }}</h3>
              <p>{{ $course->sidebar_subtitle ?: 'Book your placement test and start your learning journey.' }}</p>
              @if(! empty($course->sidebar_items))
              <ul class="cd-sidebar-info">
                @foreach($course->sidebar_items as $item)
                  <li><span>{{ $item['label'] ?? '' }}</span><strong>{{ $item['value'] ?? '' }}</strong></li>
                @endforeach
              </ul>
              @endif
              <a href="{{ route('contact') }}" class="btn btn-primary btn-block cd-apply-btn">Apply Now</a>
              <a href="tel:+97756493528" class="btn btn-secondary btn-block" style="margin-top:10px">Call 056-493528</a>
            </div>
          </aside>
        </div>
      </div>
    </section>

    @if($otherCourses->isNotEmpty())
    <section id="cd-popular" class="section">
      <div class="container">
        <div class="section-head fade-up">
          <div class="section-label">More Courses</div>
          <h2 class="section-title">Other Popular Courses</h2>
          <p class="section-sub">Explore our other language and test-prep programs at HASU Language Institute.</p>
        </div>
        <div class="courses-grid cd-popular-grid">
          @foreach($otherCourses as $i => $other)
          <a href="{{ route('course.show', $other->slug) }}" class="course-card course-card-link fade-up" style="transition-delay:{{ $i * .1 }}s">
            <div class="course-img">
              @if($other->image_url)
                <img src="{{ $other->image_url }}" alt="{{ $other->title }}">
              @endif
              @if($other->badge)
                <div class="course-flag">{{ $other->badge }}</div>
              @endif
            </div>
            <div class="course-body">
              <h4>{{ $other->title }}</h4>
              <p>{{ $other->excerpt }}</p>
              <span class="course-card-cta">View Course</span>
            </div>
          </a>
          @endforeach
          <a href="{{ route('courses') }}" class="course-card course-card-link fade-up" style="transition-delay:.2s">
            <div class="course-body">
              <h4>View All Courses</h4>
              <p>Browse the full list of language and test-prep programs at HASU.</p>
              <span class="course-card-cta">Browse All</span>
            </div>
          </a>
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
            </div>
        </div>
    </section>
@endsection
