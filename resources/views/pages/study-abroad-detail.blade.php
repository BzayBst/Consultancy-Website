@extends('layouts.app', ['active' => 'study-abroad'])

@section('title', ($destination->card_title ?: 'Study in ' . $destination->country) . ' - ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description', $destination->card_description ?: 'Study abroad destination details, benefits, courses, cities, institutions, and FAQs.')

@php
  $studyAbroadMediaUrl = fn ($path) => \Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])
    ? $path
    : \Illuminate\Support\Facades\Storage::url($path);
@endphp

@push('head')
<style>
  .detail-section { padding: 60px 0; }
  .detail-section:nth-child(even) { background-color: #f8f9fa; }
  .uni-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; margin-top: 30px; }
  .uni-card { background: #fff; border: 1px solid #eaeaea; border-radius: 8px; padding: 24px; text-align: center; transition: transform 0.3s ease, box-shadow 0.3s ease; }
  .uni-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); border-color: var(--blue); }
  .uni-card img { max-width: 100%; height: 60px; object-fit: contain; margin-bottom: 15px; }
  .uni-card h5 { font-size: 15px; margin: 0; color: #333; }
  .faq-container { max-width: 800px; margin: 0 auto; }
  .faq-item { background: #fff; border: 1px solid #eaeaea; border-radius: 6px; margin-bottom: 12px; }
  .faq-item summary { font-weight: 600; padding: 18px 20px; cursor: pointer; outline: none; list-style: none; display: flex; justify-content: space-between; align-items: center; }
  .faq-item summary::after { content: '+'; font-size: 20px; color: var(--blue); }
  .faq-item[open] summary::after { content: '-'; }
  .faq-item p { padding: 0 20px 20px; margin: 0; color: #555; font-size: 15px; line-height: 1.6; }
</style>
@endpush

@section('content')
    <x-frontend.page-hero
        badge="{{ $studyAbroadPage?->hero_badge ?: 'Global Opportunities' }}"
        title="{{ $destination->card_title ?: 'Study in' }}"
        highlight="{{ $destination->card_title ? '' : $destination->country }}"
        subtitle="{{ $destination->card_description ?: $studyAbroadPage?->hero_subtitle }}"
        :breadcrumbs="[['label' => 'Home', 'url' => route('home')], ['label' => 'Study Abroad', 'url' => route('study-abroad')], ['label' => $destination->country]]"
    />

    @if($destination->overview)
    <section class="detail-section">
      <div class="container fade-up">
        <div style="max-width: 800px; margin: 0 auto; text-align: center;">
          <div class="section-label">Overview</div>
          <h2 class="section-title">Your Pathway to {{ $destination->country }}</h2>
          <p style="font-size: 1.1rem; color: #555; line-height: 1.8;">{{ $destination->overview }}</p>
        </div>
      </div>
    </section>
    @endif

    @if(! empty($destination->benefits))
    <section id="courses-why" class="detail-section" style="padding-top: 0;">
      <div class="container">
        <div class="courses-why-inner fade-up">
          <div class="courses-why-text">
            <div class="section-label courses-why-label">Benefits</div>
            <h2 class="courses-why-title">{{ $destination->benefits_title ?: 'Why Study in ' . $destination->country . '?' }}</h2>
            @if($destination->benefits_description)
              <p>{{ $destination->benefits_description }}</p>
            @endif
          </div>
          <div class="courses-why-grid">
            @foreach($destination->benefits as $benefit)
            <div class="courses-why-item">
              <div class="icon-wrap">{{ $benefit['icon'] ?? '*' }}</div>
              <h5>{{ $benefit['title'] ?? '' }}</h5>
              <p>{{ $benefit['description'] ?? '' }}</p>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </section>
    @endif

    @if(! empty($destination->courses))
    <section class="detail-section">
      <div class="container">
        <div class="courses-listing-head fade-up">
          <div>
            <div class="section-label">Academics</div>
            <h2 class="section-title" style="text-align: left; margin-bottom: 0;">Popular Courses in {{ $destination->country }}</h2>
          </div>
        </div>
        <div class="courses-grid fade-up">
          @foreach($destination->courses as $course)
          <div class="course-card course-list-card">
            <div class="course-body">
              @if(! empty($course['tag']))
                <span class="course-list-tag" style="background:var(--blue-light);color:var(--blue)">{{ $course['tag'] }}</span>
              @endif
              <h4>{{ $course['title'] ?? '' }}</h4>
              <p>{{ $course['description'] ?? '' }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section>
    @endif

    @if($destination->scholarship_text)
    <section class="detail-section">
      <div class="container">
        <div class="fade-up" style="background: var(--blue); color: white; padding: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 30px;">
          <div style="flex: 1; min-width: 300px;">
            <h2 style="margin-top: 0;">Scholarship Opportunities</h2>
            <p style="color: rgba(255,255,255,0.9); margin-bottom: 0; font-size: 1.1rem;">{{ $destination->scholarship_text }}</p>
          </div>
          <div>
            <a href="{{ route('contact') }}" class="btn" style="background: #fff; color: var(--blue); font-weight: 600;">Check Your Eligibility</a>
          </div>
        </div>
      </div>
    </section>
    @endif

    @if(! empty($destination->cities))
    <section class="detail-section">
      <div class="container">
        <div style="text-align: center; margin-bottom: 40px;" class="fade-up">
          <div class="section-label">Locations</div>
          <h2 class="section-title">Popular Student Cities</h2>
        </div>
        <div class="courses-grid fade-up">
          @foreach($destination->cities as $city)
          <div class="course-card">
            @if(! empty($city['image']))
              <div class="course-img"><img src="{{ $studyAbroadMediaUrl($city['image']) }}" alt="{{ $city['title'] ?? '' }}"></div>
            @endif
            <div class="course-body">
              <h4>{{ $city['title'] ?? '' }}</h4>
              <p>{{ $city['description'] ?? '' }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section>
    @endif

    @if(! empty($destination->universities))
    <section class="detail-section">
      <div class="container">
        <div style="text-align: center; margin-bottom: 40px;" class="fade-up">
          <div class="section-label">Institutions</div>
          <h2 class="section-title">Partner Universities & Language Schools</h2>
          <p>We work with top-rated institutions to secure your admission.</p>
        </div>
        <div class="uni-grid fade-up">
          @foreach($destination->universities as $university)
          <div class="uni-card">
            @if(! empty($university['logo']))
              <img src="{{ $studyAbroadMediaUrl($university['logo']) }}" alt="{{ $university['name'] ?? 'Institution logo' }}">
            @endif
            <h5>{{ $university['name'] ?? '' }}</h5>
          </div>
          @endforeach
        </div>
      </div>
    </section>
    @endif

    @if(! empty($destination->faqs))
    <section class="detail-section">
      <div class="container">
        <div style="text-align: center; margin-bottom: 40px;" class="fade-up">
          <div class="section-label">Questions?</div>
          <h2 class="section-title">Frequently Asked Questions</h2>
        </div>
        <div class="faq-container fade-up">
          @foreach($destination->faqs as $faq)
          <details class="faq-item">
            <summary>{{ $faq['question'] ?? '' }}</summary>
            <p>{{ $faq['answer'] ?? '' }}</p>
          </details>
          @endforeach
        </div>
      </div>
    </section>
    @endif

    <section id="cta-banner" class="cta-courses">
      <div class="container">
        <div class="cta-inner">
          <div class="cta-text fade-up">
            <h2>Ready to Start Your Application?</h2>
            <p>Let HASU Educational Consultancy guide you through document preparation, language classes, and visa filing.</p>
            <div class="cta-actions">
              <a href="{{ route('contact') }}" class="btn btn-cta-primary">Apply Now</a>
              <a href="tel:+9779856040895" class="btn btn-cta-ghost">Call Our Advisors</a>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
