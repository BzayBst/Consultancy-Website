{{-- resources/views/components/frontend/footer.blade.php --}}
@php
  $logo       = setting('general_logo');
  $siteName   = setting('general_site_name', 'HASU Educational Consultancy');
  $footerDesc = setting('general_copyright', 'Empowering students with expert guidance to academic success.');
  $address    = setting('contact_address', 'Birendra Campus Gate Bhairahawa-11, Rupandehi');
  $phone1     = setting('contact_phone_landline', '056-493528');
  $phone2     = setting('contact_phone_primary',  '9853646493');
  $phone3     = setting('contact_phone_secondary','9802924850');
  $email      = setting('contact_email_primary',  'info@hasuedu.com');
  $facebook   = setting('social_facebook');
  $linkedin   = setting('social_linkedin');
  $youtube    = setting('social_youtube');
  $instagram  = setting('social_instagram');
  $year       = date('Y');
@endphp

<footer>
  <div class="container">
    <div class="footer-grid">

      {{-- Brand --}}
      <div>
        @if($logo)
          <img src="{{ str_starts_with($logo, 'http') ? $logo : Storage::url($logo) }}"
               alt="{{ $siteName }}"
               style="height:60px;width:auto;object-fit:contain;margin-bottom:10px;filter:brightness(0) invert(1)">
        @else
          <img src="{{ asset('images/logo.png') }}" alt="{{ $siteName }}"
               style="height:60px;width:auto;object-fit:contain;margin-bottom:10px;filter:brightness(0) invert(1)">
        @endif
        <p class="footer-desc">{{ $footerDesc }}</p>
        <div class="footer-socials">
          @if($facebook)  <a href="{{ $facebook }}"  target="_blank" rel="noopener" class="social-link">f</a>  @endif
          @if($linkedin)  <a href="{{ $linkedin }}"  target="_blank" rel="noopener" class="social-link">in</a> @endif
          @if($youtube)   <a href="{{ $youtube }}"   target="_blank" rel="noopener" class="social-link">▶</a>  @endif
          @if($instagram) <a href="{{ $instagram }}" target="_blank" rel="noopener" class="social-link">✦</a>  @endif
          {{-- fallback static icons if none set --}}
          @if(!$facebook && !$linkedin && !$youtube && !$instagram)
            <a href="#" class="social-link">f</a>
            <a href="#" class="social-link">in</a>
            <a href="#" class="social-link">▶</a>
            <a href="#" class="social-link">✦</a>
          @endif
        </div>
      </div>

      {{-- Services --}}
      <div class="footer-col">
        <h5>Our Services</h5>
        <ul>
          <li><a href="#">Visa Assistance</a></li>
          <li><a href="#">Financial Assistance</a></li>
          <li><a href="#">Study Visa Counseling</a></li>
          <li><a href="#">Admission Guidance</a></li>
        </ul>
      </div>

      {{-- Quick Links --}}
      <div class="footer-col">
        <h5>Quick Links</h5>
        <ul>
          <li><a href="{{ route('home') }}">Home</a></li>
          <li><a href="{{ route('about') }}">About Us</a></li>
          <li><a href="{{ route('home') }}#services">Our Services</a></li>
          <li><a href="{{ route('home') }}#blog">Study Blog Posts</a></li>
          <li><a href="{{ route('contact') }}">Contact Us</a></li>
        </ul>
      </div>

      {{-- Contact --}}
      <div class="footer-col">
        <h5>Get In Touch</h5>
        <ul class="footer-contact-list">
          <li><span class="ic">📍</span> {{ $address }}</li>
          <li>
            <span class="ic">📞</span>
            {{ $phone1 }}@if($phone2) | {{ $phone2 }}@endif@if($phone3) | {{ $phone3 }}@endif
          </li>
          <li><span class="ic">✉</span> {{ $email }}</li>
        </ul>
      </div>

    </div>

    <div class="footer-bottom">
      <p>© {{ $year }} {{ $siteName }}. All Rights Reserved.</p>
      
    </div>
  </div>
</footer>