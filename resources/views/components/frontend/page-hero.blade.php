{{-- resources/views/components/frontend/page-hero.blade.php --}}
@props([
    'badge'       => '',
    'title'       => '',
    'highlight'   => '',
    'titleAfter'  => '',
    'subtitle'    => '',
    'breadcrumbs' => [],   // [['label'=>'Home','url'=>'/'], ['label'=>'About Us']]
])

<section id="page-hero">
  <div class="ph-dot ph-dot-1"></div>
  <div class="ph-dot ph-dot-2"></div>
  <div class="ph-dot ph-dot-3"></div>
  <div class="container">
    <div class="page-hero-inner">
      @if($badge)
        <div class="hero-badge-top">{{ $badge }}</div>
      @endif

      <h1>
        {!! $title !!}
        @if($highlight)
          <br><span class="highlight">{{ $highlight }}</span>
        @endif
        @if($titleAfter)
          <br>{{ $titleAfter }}
        @endif
      </h1>

      @if($subtitle)
        <p>{{ $subtitle }}</p>
      @endif

      @if(count($breadcrumbs) > 0)
        <div class="breadcrumb">
          @foreach($breadcrumbs as $i => $crumb)
            @if(isset($crumb['url']))
              <a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
              <span>›</span>
            @else
              <span style="color:rgba(255,255,255,.85)">{{ $crumb['label'] }}</span>
            @endif
          @endforeach
        </div>
      @endif
    </div>
  </div>
</section>