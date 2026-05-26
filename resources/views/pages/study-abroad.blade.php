@extends('layouts.app', ['active' => 'study-abroad'])

@section('title', 'Study Abroad - ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description', 'Explore top study abroad destinations and unlock world-class education with expert visa and admission guidance.')

@section('content')
    @php
        $destinations = collect($destinations ?? []);
    @endphp

    {{-- ===== PAGE HERO ===== --}}
    <x-frontend.page-hero
        badge="{{ $studyAbroadPage?->hero_badge ?: 'Global Opportunities' }}"
        title="{{ $studyAbroadPage?->hero_title ?: 'Choose Your Dream' }}"
        highlight="{{ $studyAbroadPage?->hero_highlight ?: 'Destination' }}"
        subtitle="{{ $studyAbroadPage?->hero_subtitle ?: 'Explore top study abroad destinations and unlock world-class education with our expert visa and admission guidance.' }}"
        :breadcrumbs="[['label' => 'Home', 'url' => route('home')], ['label' => 'Study Abroad']]"
    />

    <section id="courses-listing" style="padding-top: 60px;">
        <div class="container">
            <div class="courses-listing-head fade-up">
                <div>
                    <div class="section-label" style="margin-bottom:8px">{{ $studyAbroadPage?->section_label ?: 'Explore' }}</div>
                    <h2 class="section-title" style="margin-bottom:0;text-align:left">{{ $studyAbroadPage?->section_title ?: 'Popular Countries' }}</h2>
                </div>
            </div>

            @if($destinations->isNotEmpty())
            <div class="courses-grid courses-page-grid" id="coursesGrid">
                @foreach($destinations as $i => $destination)
                <a
                    href="{{ route('study-abroad-detail', $destination->slug) }}"
                    class="course-card course-card-link fade-up"
                    @if($i > 0) style="transition-delay:{{ round(($i % 6) * 0.06, 2) }}s" @endif
                >
                    <div class="course-img">
                        @if($destination->card_image_url)
                            <img src="{{ $destination->card_image_url }}" alt="{{ $destination->card_title ?: 'Study in ' . $destination->country }}">
                        @endif
                        <div class="course-flag">{{ trim(($destination->flag ?: '') . ' ' . $destination->country) }}</div>
                    </div>
                    <div class="course-body">
                        @if($destination->card_tag)
                            <span class="course-list-tag">{{ $destination->card_tag }}</span>
                        @endif
                        <h4>{{ $destination->card_title ?: 'Study in ' . $destination->country }}</h4>
                        @if($destination->card_description)
                            <p>{{ $destination->card_description }}</p>
                        @endif
                        <span class="course-card-cta">Explore {{ $destination->country }} →</span>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="fade-up" style="margin-top:40px;padding:42px 24px;background:#fff;border:1px dashed rgba(13,21,96,.22);border-radius:8px;text-align:center;color:var(--text)">
                <strong style="display:block;color:var(--navy);font-size:1.1rem;margin-bottom:6px">Destinations coming soon</strong>
                <span>Destinations added from the CMS will appear here automatically.</span>
            </div>
            @endif
        </div>
    </section>

    <section id="cta-banner" class="cta-courses" style="margin-top: 60px;">
        <div class="container">
            <div class="cta-inner">
                <div class="cta-text fade-up">
                    <h2>{{ $studyAbroadPage?->cta_title ?: 'Confused About Where to Apply?' }}</h2>
                    <p>{{ $studyAbroadPage?->cta_subtitle ?: 'Book a free counseling session. We will evaluate your profile and recommend the perfect country and university for you.' }}</p>
                    <div class="cta-actions">
                        <a href="{{ $studyAbroadPage?->cta_button_url ?: route('contact') }}" class="btn btn-cta-primary">
                            {{ $studyAbroadPage?->cta_button_label ?: 'Book Consultation' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
