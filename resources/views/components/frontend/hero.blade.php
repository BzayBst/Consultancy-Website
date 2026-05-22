@php
    $slides = \App\Models\HeroSlide::active()->ordered()->get();
@endphp

@if ($slides->isEmpty())
    {{-- Fallback if no slides are seeded --}}
    <section id="hero" style="min-height:50vh;display:flex;align-items:center;justify-content:center;background:#0d1560;color:#fff;">
        <p style="font-size:18px;opacity:.6;">No hero slides configured. <a href="/admin/hero-slides" style="color:#f4c842;">Add slides →</a></p>
    </section>
@else
<section id="hero">
  <div class="container hero-container">
    <div class="hero-inner">

      {{-- Left: text slides + controls --}}
      <div class="hero-col-text">
        <div class="hero-text-track" id="heroTextTrack">

          @foreach ($slides as $index => $slide)
          <div class="hero-text-slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">

            @if ($slide->badge)
              <div class="hero-badge-top">{{ $slide->badge }}</div>
            @endif

            <h1 class="hero-title">
              @if ($slide->title_line1){{ $slide->title_line1 }}<br>@endif
              @if ($slide->title_line2){{ $slide->title_line2 }} @endif
              @if ($slide->title_highlight)<span class="highlight">{{ $slide->title_highlight }}</span>@endif
              @if ($slide->title_line3)<br>{{ $slide->title_line3 }}@endif
            </h1>

            @if ($slide->description)
              <p class="hero-desc">{{ $slide->description }}</p>
            @endif

            @if (!empty($slide->features))
            <div class="hero-features">
              @foreach ($slide->features as $feat)
                @if (!empty($feat['label']))
                <div class="hero-feat">
                  <div class="hero-feat-icon">{{ $feat['icon'] ?? '' }}</div>
                  <span>{{ $feat['label'] }}</span>
                </div>
                @endif
              @endforeach
            </div>
            @endif

            <div class="hero-btns">
              @if ($slide->btn_primary_label)
                <a href="{{ $slide->btn_primary_href ?? '#' }}" class="btn btn-primary">
                  {{ $slide->btn_primary_label }}
                </a>
              @endif
              @if ($slide->btn_ghost_label)
                <a href="{{ $slide->btn_ghost_href ?? '#' }}" class="btn-ghost">
                  {{ $slide->btn_ghost_label }}
                </a>
              @endif
            </div>

          </div>
          @endforeach

        </div>

        @if ($slides->count() > 1)
        <div class="hero-controls" id="heroControls">
          <button type="button" class="hero-arrow hero-arrow-prev" id="heroPrev" aria-label="Previous slide">←</button>
          <div class="hero-dots" id="heroDots">
            @foreach ($slides as $index => $slide)
              <button type="button"
                      class="hero-dot-slide {{ $index === 0 ? 'active' : '' }}"
                      data-slide="{{ $index }}"
                      aria-label="Slide {{ $index + 1 }}">
              </button>
            @endforeach
          </div>
          <button type="button" class="hero-arrow hero-arrow-next" id="heroNext" aria-label="Next slide">→</button>
        </div>
        @endif
      </div>

      {{-- Right: image slides --}}
      <div class="hero-col-visual">
        <div class="hero-visual-track" id="heroVisualTrack">

          @foreach ($slides as $index => $slide)
          <div class="hero-visual-slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
            <div class="hero-right">
              <div class="hero-circle-bg"></div>
              <div class="hero-circle-ring"></div>
              <div class="hero-plane">{{ $slide->plane_emoji ?? '✈️' }}</div>
              <div class="hero-dot-tl"></div>
              <div class="hero-dot-tr"></div>
              <div class="hero-img-wrap">
                @if (!empty($slide->image_path))
                  @if (str_starts_with($slide->image_path, 'http'))
                    <img src="{{ $slide->image_path }}" alt="{{ $slide->image_alt ?? '' }}">
                  @else
                    <img src="{{ Storage::url($slide->image_path) }}" alt="{{ $slide->image_alt ?? '' }}">
                  @endif
                @endif
              </div>
            </div>
          </div>
          @endforeach

        </div>
      </div>

    </div>
  </div>
</section>
@endif