@extends('layouts.app', ['active' => 'course-detail'])

@section('title', localized($course, 'title') . ' - ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description', localized($course, 'excerpt') ?: localized($course, 'overview') ?: 'Course details from HASU Educational Consultancy.')

@section('content')
    <x-frontend.page-hero
        badge="{{ localized($course, 'badge') ?: localized($coursePage, 'hero_badge') ?: 'HASU Language Institute' }}"
        title="{{ localized($course, 'title') }}"
        highlight="{{ localized($coursePage, 'hero_highlight') ?: (app()->getLocale() === 'ja' ? 'コース' : 'Course') }}"
        subtitle="{{ localized($course, 'excerpt') ?: localized($coursePage, 'hero_subtitle') }}"
        :breadcrumbs="[['label' => 'Home', 'url' => route('home')], ['label' => 'All Courses', 'url' => route('courses')], ['label' => localized($course, 'title')]]"
    />

    <section class="cd-main section">
      <div class="container">
        <div class="cd-layout">
          <div class="cd-content fade-up">
            <h1 class="cd-title">{{ localized($course, 'title') }}</h1>
            @if(! empty(localized($course, 'meta_items')))
            <div class="cd-meta">
              @foreach(localized($course, 'meta_items') as $item)
                <span>{{ $item['label'] ?? '' }}</span>
              @endforeach
            </div>
            @endif

            <div class="cd-description">
              @if(localized($course, 'overview'))
                <p>{{ localized($course, 'overview') }}</p>
              @endif
              @foreach(localized($course, 'description') ?? [] as $paragraph)
                @if(! empty($paragraph['body']))
                  <p>{{ $paragraph['body'] }}</p>
                @endif
              @endforeach
            </div>

            @if(! empty(localized($course, 'highlights')))
            <div class="cd-highlights">
              <h3>{{ app()->getLocale() === 'ja' ? '学べること' : 'What You Will Learn' }}</h3>
              <ul>
                @foreach(localized($course, 'highlights') as $highlight)
                  @if(! empty($highlight['item']))
                    <li>{{ $highlight['item'] }}</li>
                  @endif
                @endforeach
              </ul>
            </div>
            @endif

            <div class="cd-mobile-apply">
              <a href="{{ $coursePage?->cta_button_url ?: route('contact') }}" class="btn btn-primary btn-block">{{ localized($coursePage, 'cta_button_label') ?: (app()->getLocale() === 'ja' ? '申し込む' : 'Apply Now') }}</a>
            </div>
          </div>

          <aside class="cd-sidebar fade-up" style="transition-delay:.1s">
            <div class="cd-sidebar-card">
              <div class="cd-sidebar-flag">{{ localized($course, 'badge') ?: (app()->getLocale() === 'ja' ? 'コース' : 'Course') }}</div>
              <h3>{{ localized($course, 'sidebar_title') ?: (app()->getLocale() === 'ja' ? '今すぐ登録' : 'Enroll Today') }}</h3>
              <p>{{ localized($course, 'sidebar_subtitle') ?: (app()->getLocale() === 'ja' ? '適性検査を予約して学習を始めましょう。' : 'Book your placement test and start your learning journey.') }}</p>
              @if(! empty(localized($course, 'sidebar_items')))
              <ul class="cd-sidebar-info">
                @foreach(localized($course, 'sidebar_items') as $item)
                  <li><span>{{ $item['label'] ?? '' }}</span><strong>{{ $item['value'] ?? '' }}</strong></li>
                @endforeach
              </ul>
              @endif
              <a href="{{ $coursePage?->cta_button_url ?: route('contact') }}" class="btn btn-primary btn-block cd-apply-btn">{{ localized($coursePage, 'cta_button_label') ?: (app()->getLocale() === 'ja' ? '申し込む' : 'Apply Now') }}</a>
              <a href="tel:+97756493528" class="btn btn-secondary btn-block" style="margin-top:10px">{{ localized($coursePage, 'cta_phone_label') ?: (app()->getLocale() === 'ja' ? '電話する' : 'Call 056-493528') }}</a>
            </div>
          </aside>
        </div>
      </div>
    </section>

    @if($otherCourses->isNotEmpty())
    <section id="cd-popular" class="section">
      <div class="container">
        <div class="section-head fade-up">
          <div class="section-label">{{ app()->getLocale() === 'ja' ? 'その他のコース' : 'More Courses' }}</div>
          <h2 class="section-title">{{ app()->getLocale() === 'ja' ? '人気のあるコース' : 'Other Popular Courses' }}</h2>
          <p class="section-sub">{{ app()->getLocale() === 'ja' ? 'HASUの他の言語および試験対策プログラムをご覧ください。' : 'Explore our other language and test-prep programs at HASU Language Institute.' }}</p>
        </div>
        <div class="courses-grid cd-popular-grid">
          @foreach($otherCourses as $i => $other)
          <a href="{{ route('course.show', $other->slug) }}" class="course-card course-card-link fade-up" style="transition-delay:{{ $i * .1 }}s">
            <div class="course-img">
              @if($other->image_url)
                <img src="{{ $other->image_url }}" alt="{{ localized($other, 'title') }}">
              @endif
              @if(localized($other, 'badge'))
                <div class="course-flag">{{ localized($other, 'badge') }}</div>
              @endif
            </div>
            <div class="course-body">
              <h4>{{ localized($other, 'title') }}</h4>
              <p>{{ localized($other, 'excerpt') }}</p>
              <span class="course-card-cta">{{ app()->getLocale() === 'ja' ? 'コースを見る' : 'View Course' }}</span>
            </div>
          </a>
          @endforeach
          <a href="{{ route('courses') }}" class="course-card course-card-link fade-up" style="transition-delay:.2s">
            <div class="course-body">
              <h4>{{ localized($coursePage, 'catalog_title') ?: (app()->getLocale() === 'ja' ? 'すべてのコースを見る' : 'View All Courses') }}</h4>
              <p>{{ app()->getLocale() === 'ja' ? 'HASUの言語および試験対策プログラムの完全なリストを参照してください。' : 'Browse the full list of language and test-prep programs at HASU.' }}</p>
              <span class="course-card-cta">{{ localized($coursePage, 'catalog_label') ?: (app()->getLocale() === 'ja' ? 'すべて表示' : 'Browse All') }}</span>
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
                    <h2>{{ localized($coursePage, 'cta_title') ?: 'Not Sure Which Course Is Right for You?' }}</h2>
                    <p>{{ localized($coursePage, 'cta_subtitle') ?: 'Visit our campus or book a free assessment. We will recommend the best program for your goals.' }}</p>
                    <div class="cta-actions">
                        <a href="{{ $coursePage?->cta_button_url ?: route('contact') }}" class="btn btn-cta-primary">{{ localized($coursePage, 'cta_button_label') ?: 'Apply Now' }}</a>
                        <a href="{{ $coursePage?->cta_phone_url ?: 'tel:+97756493528' }}" class="btn btn-cta-ghost">{{ localized($coursePage, 'cta_phone_label') ?: 'Call Us Today' }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
