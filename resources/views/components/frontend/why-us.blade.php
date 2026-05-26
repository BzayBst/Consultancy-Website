{{--
    resources/views/components/frontend/why-us.blade.php
    Dynamic drop-in for the #why-us section on the About page.

    Usage:
        <x-frontend.why-us />
--}}

@php
    $section  = \App\Models\WhyUsSection::first();
    $features = \App\Models\WhyUsFeature::active()->ordered()->get();
@endphp

@if ($section || $features->isNotEmpty())
<section id="why-us">
  <div class="container">
    <div class="why-inner">

      {{-- ── Left: text + feature grid ── --}}
      <div class="why-left fade-up">

        {{-- Label --}}
        <div class="section-label" style="color:#ffaaaa">
          {{ $section?->section_label ?? 'Why Choose HASU' }}
        </div>

        {{-- Title --}}
        <h2 class="section-title" style="color:#fff">
          {{ $section?->title ?? 'Reasons Students Trust Us' }}
        </h2>

        {{-- Description --}}
        @if ($section?->description)
          <p>{{ $section->description }}</p>
        @endif

        {{-- Feature cards --}}
        @if ($features->isNotEmpty())
        <div class="why-features">
          @foreach ($features as $feat)
          <div class="why-feat">
            <div class="why-feat-icon">{{ $feat->icon }}</div>
            <h5>{{ $feat->title }}</h5>
            @if ($feat->description)
              <p>{{ $feat->description }}</p>
            @endif
          </div>
          @endforeach
        </div>
        @endif

      </div>

      {{-- ── Right: image + badge ── --}}
      <div class="why-img-wrap fade-up" style="transition-delay:.15s">

        @if ($section?->image_path)
          @if (str_starts_with($section->image_path, 'http'))
            <img src="{{ $section->image_path }}"
                 alt="{{ $section?->image_alt ?? '' }}">
          @else
            <img src="{{ Storage::url($section->image_path) }}"
                 alt="{{ $section?->image_alt ?? '' }}">
          @endif
        @endif

        @if ($section?->badge_number)
        <div class="why-img-badge">
          <strong>{{ $section->badge_number }}</strong>
          <span>{{ $section?->badge_label ?? '' }}</span>
        </div>
        @endif

      </div>

    </div>
  </div>
</section>
@endif