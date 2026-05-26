{{--
    resources/views/components/frontend/home-about.blade.php
    Dynamic drop-in for the #about section on the homepage.

    Usage in home.blade.php:
        <x-frontend.home-about />
--}}

@php
    $r = \App\Models\HomeAbout::first();
@endphp

@if ($r)
<section id="about" class="section">
  <div class="container">
    <div class="about-inner">

      {{-- ── Left: image + exp badge ── --}}
      <div class="about-img-wrap fade-up">
        @if ($r->image_path)
          <img src="{{ $r->imageUrl() }}" alt="{{ $r->image_alt ?? 'About HASU' }}">
        @else
          <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b6175?w=700&q=80" alt="About HASU">
        @endif

        <div class="about-exp-badge">
          <strong>{{ $r->badge_number ?? (setting('general_established') ? (date('Y') - (int)setting('general_established')) : '11') }}</strong>
          <span>{{ $r->badge_label ?? 'Years of Experience' }}</span>
        </div>
      </div>

      {{-- ── Right: text content ── --}}
      <div class="about-content fade-up" style="transition-delay:.15s">

        <div class="section-label">{{ $r->section_label ?? 'About The Company' }}</div>
        <h2 class="section-title">{{ $r->section_title ?? 'Your Trusted Partner in Global Education' }}</h2>

        @if ($r->paragraph_1)
          <p>{{ $r->paragraph_1 }}</p>
        @endif

        @if ($r->paragraph_2)
          <p>{{ $r->paragraph_2 }}</p>
        @endif

        {{-- Badges --}}
        @if (!empty($r->badges))
        <div class="about-badges">
          @foreach ($r->badges as $badge)
            @if (!empty($badge['label']))
            <div class="about-badge">
              <div class="icon">{{ $badge['icon'] ?? '' }}</div>
              <span>{{ $badge['label'] }}</span>
            </div>
            @endif
          @endforeach
        </div>
        @endif

        {{-- Perks --}}
        @if (!empty($r->perks))
        <ul class="about-perks">
          @foreach ($r->perks as $perk)
            @if (trim($perk) !== '')
              <li>{{ $perk }}</li>
            @endif
          @endforeach
        </ul>
        @endif

        {{-- Phone contact --}}
        <div class="about-contact">
          <div class="phone-icon">📞</div>
          <div>
            <strong>
              {{ setting('contact_phone_landline', '056-493528') }}
              @if(setting('contact_phone_primary'))  | {{ setting('contact_phone_primary') }}  @endif
              @if(setting('contact_phone_secondary')) | {{ setting('contact_phone_secondary') }} @endif
            </strong>
            <span>Have any questions? Call us anytime</span>
          </div>
        </div>

        <br>
        @if ($r->cta_label)
          <a href="{{ $r->cta_href ?? route('about') }}" class="btn btn-primary">
            {{ $r->cta_label }}
          </a>
        @endif

      </div>

    </div>
  </div>
</section>
@else
{{-- Fallback if not seeded yet --}}
<section id="about" class="section">
  <div class="container">
    <div class="text-center" style="padding:60px 0;color:#94a3b8">
      <p>About section not configured yet. <a href="/admin/home/about" style="color:var(--blue)">Configure it in the CMS →</a></p>
    </div>
  </div>
</section>
@endif