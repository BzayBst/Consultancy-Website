@extends('layouts.app', ['active' => 'study-abroad'])

@section('title', (localized($destination, 'card_title') ?: (app()->getLocale() === 'ja' ? (localized($destination, 'country') ?: $destination->country) . '留学' : 'Study in ' . $destination->country)) . ' - ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description', localized($destination, 'card_description') ?: (app()->getLocale() === 'ja' ? '留学先の詳細、メリット、コース、都市、教育機関、よくある質問をご案内します。' : 'Study abroad destination details, benefits, courses, cities, institutions, and FAQs.'))

@php
  $isJa = app()->getLocale() === 'ja';
  $countryLabel = localized($destination, 'country') ?: $destination->country;

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
        badge="{{ localized($studyAbroadPage, 'hero_badge') ?: 'Global Opportunities' }}"
        title="{{ localized($destination, 'card_title') ?: ($isJa ? $countryLabel . '留学' : 'Study in') }}"
        highlight="{{ localized($destination, 'card_title') ? '' : $countryLabel }}"
        subtitle="{{ localized($destination, 'card_description') ?: localized($studyAbroadPage, 'hero_subtitle') }}"
        :breadcrumbs="[
          ['label' => $isJa ? 'ホーム' : 'Home', 'url' => route('home')],
          ['label' => $isJa ? '留学' : 'Study Abroad', 'url' => route('study-abroad')],
          ['label' => $countryLabel],
        ]"
    />

    {{-- ── Overview ── --}}
    @if(localized($destination, 'overview'))
    <section class="detail-section">
      <div class="container fade-up">
        <div style="max-width: 800px; margin: 0 auto; text-align: center;">
          <div class="section-label">{{ $isJa ? '概要' : 'Overview' }}</div>
          <h2 class="section-title">{{ $isJa ? $countryLabel . 'への進学サポート' : 'Your Pathway to ' . $countryLabel }}</h2>
          <p style="font-size: 1.1rem; color: #555; line-height: 1.8;">{{ localized($destination, 'overview') }}</p>
        </div>
      </div>
    </section>
    @endif

    {{-- ── Benefits ── --}}
    @if(! empty($destination->benefits))
    <section id="courses-why" class="detail-section" style="padding-top: 0;">
      <div class="container">
        <div class="courses-why-inner fade-up">
          <div class="courses-why-text">
            <div class="section-label courses-why-label">{{ $isJa ? 'メリット' : 'Benefits' }}</div>
            <h2 class="courses-why-title">
              {{ localized($destination, 'benefits_title') ?: ($isJa ? $countryLabel . 'で学ぶメリット' : 'Why Study in ' . $countryLabel . '?') }}
            </h2>
            @if(localized($destination, 'benefits_description'))
              <p>{{ localized($destination, 'benefits_description') }}</p>
            @endif
          </div>
          <div class="courses-why-grid">
            @foreach($destination->benefits as $benefit)
            <div class="courses-why-item">
              <div class="icon-wrap">{{ $benefit['icon'] ?? '*' }}</div>
              <h5>{{ localized($benefit, 'title') }}</h5>
              <p>{{ localized($benefit, 'description') }}</p>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </section>
    @endif

    {{-- ── Courses ── --}}
    @if(! empty($destination->courses))
    <section class="detail-section">
      <div class="container">
        <div class="courses-listing-head fade-up">
          <div>
            <div class="section-label">{{ $isJa ? '学習分野' : 'Academics' }}</div>
            <h2 class="section-title" style="text-align: left; margin-bottom: 0;">
              {{ $isJa ? $countryLabel . 'で人気のコース' : 'Popular Courses in ' . $countryLabel }}
            </h2>
          </div>
        </div>
        <div class="courses-grid fade-up">
          @foreach($destination->courses as $course)
          <div class="course-card course-list-card">
            <div class="course-body">
              @if(! empty($course['tag']) || ! empty($course['tag_ja']))
                <span class="course-list-tag" style="background:var(--blue-light);color:var(--blue)">
                  {{ localized($course, 'tag') }}
                </span>
              @endif
              <h4>{{ localized($course, 'title') }}</h4>
              <p>{{ localized($course, 'description') }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section>
    @endif

    {{-- ── Scholarship ── --}}
    @if(localized($destination, 'scholarship_text'))
    <section class="detail-section">
      <div class="container">
        <div class="fade-up" style="background: var(--blue); color: white; padding: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 30px;">
          <div style="flex: 1; min-width: 300px;">
            <h2 style="margin-top: 0;">{{ $isJa ? '奨学金の機会' : 'Scholarship Opportunities' }}</h2>
            <p style="color: rgba(255,255,255,0.9); margin-bottom: 0; font-size: 1.1rem;">{{ localized($destination, 'scholarship_text') }}</p>
          </div>
          <div>
            <a href="{{ route('contact') }}" class="btn" style="background: #fff; color: var(--blue); font-weight: 600;">
              {{ $isJa ? '対象条件を確認する' : 'Check Your Eligibility' }}
            </a>
          </div>
        </div>
      </div>
    </section>
    @endif

    {{-- ── Cities ── --}}
    @if(! empty($destination->cities))
    <section class="detail-section">
      <div class="container">
        <div style="text-align: center; margin-bottom: 40px;" class="fade-up">
          <div class="section-label">{{ $isJa ? '都市' : 'Locations' }}</div>
          <h2 class="section-title">{{ $isJa ? '人気の学生都市' : 'Popular Student Cities' }}</h2>
        </div>
        <div class="courses-grid fade-up">
          @foreach($destination->cities as $city)
          <div class="course-card">
            @if(! empty($city['image']))
              <div class="course-img">
                <img src="{{ $studyAbroadMediaUrl($city['image']) }}" alt="{{ localized($city, 'title') }}">
              </div>
            @endif
            <div class="course-body">
              <h4>{{ localized($city, 'title') }}</h4>
              <p>{{ localized($city, 'description') }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section>
    @endif

    {{-- ── Universities / Institutions ── --}}
    @if(! empty($destination->universities))
    <section class="detail-section">
      <div class="container">
        <div style="text-align: center; margin-bottom: 40px;" class="fade-up">
          <div class="section-label">{{ $isJa ? '教育機関' : 'Institutions' }}</div>
          <h2 class="section-title">{{ $isJa ? '提携大学・語学学校' : 'Partner Universities & Language Schools' }}</h2>
          <p>{{ $isJa ? '評価の高い教育機関と連携し、入学手続きをサポートします。' : 'We work with top-rated institutions to secure your admission.' }}</p>
        </div>
        <div class="uni-grid fade-up">
          @foreach($destination->universities as $university)
          <div class="uni-card">
            @if(! empty($university['logo']))
              <img src="{{ $studyAbroadMediaUrl($university['logo']) }}" alt="{{ localized($university, 'name') ?: 'Institution logo' }}">
            @endif
            <h5>{{ localized($university, 'name') }}</h5>
          </div>
          @endforeach
        </div>
      </div>
    </section>
    @endif

    {{-- ── FAQs ── --}}
    @if(! empty($destination->faqs))
    <section class="detail-section">
      <div class="container">
        <div style="text-align: center; margin-bottom: 40px;" class="fade-up">
          <div class="section-label">{{ $isJa ? '質問' : 'Questions?' }}</div>
          <h2 class="section-title">{{ $isJa ? 'よくある質問' : 'Frequently Asked Questions' }}</h2>
        </div>
        <div class="faq-container fade-up">
          @foreach($destination->faqs as $faq)
          <details class="faq-item">
            <summary>{{ localized($faq, 'question') }}</summary>
            <p>{{ localized($faq, 'answer') }}</p>
          </details>
          @endforeach
        </div>
      </div>
    </section>
    @endif

    {{-- ── CTA ── --}}
    <section id="cta-banner" class="cta-courses">
      <div class="container">
        <div class="cta-inner">
          <div class="cta-text fade-up">
            <h2>{{ localized($studyAbroadPage, 'cta_title') ?: ($isJa ? '出願を始める準備はできましたか？' : 'Ready to Start Your Application?') }}</h2>
            <p>{{ localized($studyAbroadPage, 'cta_subtitle') ?: ($isJa ? 'HASU Educational Consultancyが書類準備、語学クラス、ビザ申請まで丁寧にサポートします。' : 'Let HASU Educational Consultancy guide you through document preparation, language classes, and visa filing.') }}</p>
            <div class="cta-actions">
              <a href="{{ $studyAbroadPage?->cta_button_url ?: route('contact') }}" class="btn btn-cta-primary">
                {{ localized($studyAbroadPage, 'cta_button_label') ?: ($isJa ? '申し込む' : 'Apply Now') }}
              </a>
              <a href="tel:+9779856040895" class="btn btn-cta-ghost">{{ $isJa ? 'アドバイザーに電話する' : 'Call Our Advisors' }}</a>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
