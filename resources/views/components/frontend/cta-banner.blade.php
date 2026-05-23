{{-- resources/views/components/frontend/cta-banner.blade.php --}}
@props([
    'title'   => 'Reach Out to Our Consultant Now',
    'subtitle'=> 'Free counseling sessions available — take the first step toward your dream education abroad.',
    'btnLabel'=> 'Book Free Counseling',
    'btnLink' => '#',
    'btn2Label'=> 'Learn More',
    'btn2Link' => '#about',
])

@php
  $phone1 = setting('contact_phone_landline', '056-493528');
  $phone2 = setting('contact_phone_primary',  '9853646493');
  $phone3 = setting('contact_phone_secondary','9802924850');
  $email  = setting('contact_email_primary',  'info@hasuedu.com');
  $fb     = setting('social_facebook');
  $li     = setting('social_linkedin');
  $yt     = setting('social_youtube');
  $ig     = setting('social_instagram');
@endphp

<section id="cta-banner">
  <div class="container">
    <div class="cta-inner">
      <div class="cta-text fade-up">
        <h2>{{ $title }}</h2>
        <p>{{ $subtitle }}</p>
        <br>
        <a href="{{ $btnLink }}"  class="btn btn-primary" style="margin-right:12px">{{ $btnLabel }}</a>
        <a href="{{ $btn2Link }}" class="btn btn-outline" style="color:#fff;border-color:rgba(255,255,255,.5)">{{ $btn2Label }}</a>
      </div>
      <div class="cta-contact fade-up" style="transition-delay:.15s">
        <a href="mailto:{{ $email }}">✉ {{ $email }}</a>
        @if($phone1) <a href="tel:{{ preg_replace('/[^+\d]/', '', $phone1) }}">📞 {{ $phone1 }}</a> @endif
        @if($phone2) <a href="tel:{{ preg_replace('/[^+\d]/', '', $phone2) }}">📞 {{ $phone2 }}</a> @endif
        @if($phone3) <a href="tel:{{ preg_replace('/[^+\d]/', '', $phone3) }}">📞 {{ $phone3 }}</a> @endif
        <div style="display:flex;gap:10px;margin-top:8px">
          @if($fb) <a href="{{ $fb }}" target="_blank" rel="noopener" class="social-link">f</a>   @endif
          @if($li) <a href="{{ $li }}" target="_blank" rel="noopener" class="social-link">in</a>  @endif
          @if($yt) <a href="{{ $yt }}" target="_blank" rel="noopener" class="social-link">▶</a>   @endif
          @if($ig) <a href="{{ $ig }}" target="_blank" rel="noopener" class="social-link">✦</a>   @endif
          @if(!$fb && !$li && !$yt && !$ig)
            <a href="#" class="social-link">f</a>
            <a href="#" class="social-link">in</a>
            <a href="#" class="social-link">▶</a>
            <a href="#" class="social-link">✦</a>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>