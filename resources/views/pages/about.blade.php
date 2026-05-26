{{-- resources/views/pages/about.blade.php --}}
@extends('layouts.app', ['active' => 'about'])

@section('title', 'About Us - ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description', 'Learn about HASU Educational Consultancy, our story, mission, vision, team, and why thousands of Nepali students trust us.')

@section('content')

@php
    $aboutMilestones = collect($aboutMilestones ?? []);
    $aboutStats = collect($aboutStats ?? []);
    $aboutMvCards = collect($aboutMvCards ?? []);
    $teams = collect($teams ?? []);

    $storyImage = $aboutStory?->image_path
        ? (str_starts_with($aboutStory->image_path, 'http')
            ? $aboutStory->image_path
            : Storage::url($aboutStory->image_path))
        : 'https://images.unsplash.com/photo-1434030216411-0b793f4b6175?w=700&q=80';
@endphp

{{-- ===== PAGE HERO ===== --}}
<x-frontend.page-hero
    badge="{{ $aboutHero?->badge ?: 'Est. ' . setting('general_established', '2013') . ' - Chitwan, Nepal' }}"
    title="{{ $aboutHero?->title ?: 'Your Trusted Partner in' }}"
    highlight="{{ $aboutHero?->highlight ?: 'Global Education' }}"
    subtitle="{{ $aboutHero?->subtitle ?: 'For over a decade, HASU Educational Consultancy has been guiding Nepali students toward world-class academic opportunities and brighter futures.' }}"
    :breadcrumbs="[['label'=>'Home','url'=> route('home')], ['label'=>'About Us']]"
/>

{{-- ===== OUR STORY ===== --}}
<section id="story" class="section">
  <div class="container">
    <div class="story-inner">
      <div class="story-img-wrap fade-up">
        <img src="{{ $storyImage }}" alt="{{ $aboutStory?->section_title ?: 'HASU Office' }}">

        <div class="story-img-float">
          <div class="icon">{{ $aboutStory?->float_badge_icon ?: '*' }}</div>
          <div>
            <strong>{{ $aboutStory?->float_badge_title ?: 'Best Consultancy' }}</strong>
            <small>{{ $aboutStory?->float_badge_subtitle ?: 'Bhairahawa Region, 2023' }}</small>
          </div>
        </div>

        <div class="story-exp-badge">
          <strong>{{ date('Y') - (int) setting('general_established', '2013') }}</strong>
          <span>Years of Excellence</span>
        </div>
      </div>

      <div class="story-content fade-up" style="transition-delay:.15s">
        <div class="section-label">{{ $aboutStory?->section_label ?: 'Our Story' }}</div>
        <h2 class="section-title">{{ $aboutStory?->section_title ?: 'How HASU Began Its Journey' }}</h2>

        @if($aboutStory?->paragraph_1)
          <p>{{ $aboutStory->paragraph_1 }}</p>
        @endif

        @if($aboutStory?->paragraph_2)
          <p>{{ $aboutStory->paragraph_2 }}</p>
        @endif

        @if(! $aboutStory?->paragraph_1 && ! $aboutStory?->paragraph_2)
          <p>Founded in {{ setting('general_established', '2013') }}, HASU International Educational Pvt. Ltd. started with a mission to make world-class education accessible to every Nepali student.</p>
        @endif

        @if($aboutMilestones->isNotEmpty())
        <div class="story-milestones">
          @foreach($aboutMilestones as $m)
          <div class="milestone">
            <div class="milestone-year">{{ $m->year }}</div>
            <div class="milestone-info">
              <h5>{{ $m->title }}</h5>
              @if($m->description)
                <p>{{ $m->description }}</p>
              @endif
            </div>
          </div>
          @endforeach
        </div>
        @endif
      </div>
    </div>
  </div>
</section>

{{-- ===== STATS ROW ===== --}}
@if($aboutStats->isNotEmpty())
<section id="stats">
  <div class="container" style="padding:0 24px">
    <div class="stats-inner">
      @foreach($aboutStats as $i => $stat)
      <div class="stat-item fade-up" @if($i > 0) style="transition-delay:{{ round($i * 0.1, 2) }}s" @endif>
        <span class="stat-num">{{ $stat->number }}<span class="accent">{{ $stat->accent }}</span></span>
        <span class="stat-label">{{ $stat->label }}</span>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ===== MISSION VISION ===== --}}
@if($aboutMvCards->isNotEmpty())
<section id="mission" class="section">
  <div class="container">
    <div class="section-head fade-up">
      <div class="section-label">Who We Are</div>
      <h2 class="section-title">Mission, Vision & Purpose</h2>
      <p class="section-sub">Everything we do is guided by a commitment to student success, integrity, and global opportunity.</p>
    </div>

    <div class="mv-grid">
      @foreach($aboutMvCards as $i => $card)
      <div class="mv-card fade-up" @if($i > 0) style="transition-delay:{{ round($i * 0.1, 2) }}s" @endif>
        <div class="mv-icon">{{ $card->icon }}</div>
        <h3>{{ $card->title }}</h3>
        <p>{{ $card->body }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ===== WHY CHOOSE US ===== --}}
<x-frontend.why-us />

{{-- ===== CORE VALUES ===== --}}
<x-frontend.core-values />

{{-- ===== TEAM ===== --}}
@if($teams->isNotEmpty())
<section id="team" class="section" style="background:var(--light)">
  <div class="container">
    <div class="section-head fade-up">
      <div class="section-label">Our People</div>
      <h2 class="section-title">Meet the HASU Team</h2>
      <p class="section-sub">Our dedicated counselors and specialists bring years of experience, genuine care, and insider knowledge.</p>
    </div>

    <div class="team-grid">
      @foreach($teams as $i => $member)
      <div class="team-card fade-up" @if($i > 0) style="transition-delay:{{ round($i * 0.1, 2) }}s" @endif>
        <div class="team-photo">
          @if($member->photo)
            <img src="{{ $member->photo_url }}" alt="{{ $member->name }}">
          @else
            <div class="team-photo-placeholder">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
          @endif

          @if(! empty($member->social_links))
          <div class="team-overlay">
            <div class="team-socials">
              @if(! empty($member->social_links['linkedin']))
                <a href="{{ $member->social_links['linkedin'] }}" target="_blank" rel="noopener">in</a>
              @endif
              @if(! empty($member->social_links['facebook']))
                <a href="{{ $member->social_links['facebook'] }}" target="_blank" rel="noopener">f</a>
              @endif
              @if(! empty($member->social_links['twitter']))
                <a href="{{ $member->social_links['twitter'] }}" target="_blank" rel="noopener">x</a>
              @endif
            </div>
          </div>
          @endif
        </div>

        <div class="team-body">
          <div class="team-name">{{ $member->name }}</div>
          <div class="team-role">{{ $member->designation }}</div>
          @if($member->bio)
            <div class="team-bio">{{ $member->bio }}</div>
          @endif
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ===== CTA BANNER ===== --}}
<x-frontend.cta-banner
    title="Ready to Begin Your Global Journey?"
    subtitle="Book a free counseling session today - let HASU guide you to the education you deserve."
    btn-label="Book Free Counseling"
    btn-link="#"
    btn2-label="Our Services"
    btn2-link="{{ route('home') }}#services"
/>

@endsection

@push('scripts')
<script>
// Stat counter animation
const statNums = document.querySelectorAll('.stat-num');
const statObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const el = entry.target;
      const accent = el.querySelector('.accent');
      const accentText = accent ? accent.textContent : '';
      const target = parseInt(el.textContent.replace(accentText,'').replace(/\D/g,''));
      if (isNaN(target)) return;
      let start = 0;
      const step = (ts) => {
        if (!start) start = ts;
        const progress = Math.min((ts - start) / 1400, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        el.innerHTML = Math.floor(eased * target).toLocaleString() + (accent ? `<span class="accent">${accentText}</span>` : '');
        if (progress < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
      statObserver.unobserve(el);
    }
  });
}, { threshold: 0.5 });
statNums.forEach(el => statObserver.observe(el));
</script>
@endpush
