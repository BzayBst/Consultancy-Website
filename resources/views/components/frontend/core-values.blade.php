@php
    $section = \App\Models\CoreValuesSection::first();
    $values  = \App\Models\CoreValue::active()->ordered()->get();
@endphp

@if ($section || $values->isNotEmpty())
<section id="values" class="section">
  <div class="container">

    <div class="section-head fade-up">
      <div class="section-label">{{ $section?->section_label ?? 'Core Values' }}</div>
      <h2 class="section-title">{{ $section?->title ?? 'The Principles We Live By' }}</h2>
      @if ($section?->subtitle)
        <p class="section-sub">{{ $section->subtitle }}</p>
      @endif
    </div>

    @if ($values->isNotEmpty())
    <div class="values-grid">
      @foreach ($values as $i => $value)
      <div class="value-card fade-up" @if($i > 0) style="transition-delay:{{ round($i * 0.08, 2) }}s" @endif>
        <div class="value-icon">{{ $value->icon }}</div>
        <div>
          <h4>{{ $value->title }}</h4>
          @if ($value->description)
            <p>{{ $value->description }}</p>
          @endif
        </div>
      </div>
      @endforeach
    </div>
    @endif

  </div>
</section>
@endif