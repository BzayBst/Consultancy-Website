{{-- resources/views/pages/home.blade.php --}}
@extends('layouts.app', ['active' => 'home'])

@section('title', setting('seo_meta_title', 'HASU Educational Consultancy'))
@section('meta_description', setting('seo_meta_description'))

@section('content')

{{-- ===== HERO SLIDER ===== --}}
<x-frontend.hero />

{{-- ===== ABOUT THE COMPANY ===== --}}
{{-- <section id="about" class="section">
  <div class="container">
    <div class="about-inner">

      <div class="about-img-wrap fade-up">
        <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b6175?w=700&q=80" alt="About HASU">
        <div class="about-exp-badge">
          <strong>{{ setting('general_established') ? (date('Y') - (int)setting('general_established')) : '11' }}</strong>
          <span>Years of Experience</span>
        </div>
      </div>

      <div class="about-content fade-up" style="transition-delay:.15s">
        <div class="section-label">About The Company</div>
        <h2 class="section-title">Your Trusted Partner in Global Education</h2>
        <p>Established in {{ setting('general_established', '2013') }} and officially registered in 2015, HASU International Educational Pvt. Ltd. is the best educational consultancy in Bhairahawa. We guide Nepali students to higher education opportunities in Japan, Australia, Canada, the US, UK, and New Zealand through comprehensive counseling and application support.</p>
        <p>We specialize in Japanese language prep (NAT, JLPT, J-TEST), English exams (IELTS, PTE), and full visa processing — ensuring a smooth journey from planning to placement.</p>
        <div class="about-badges">
          <div class="about-badge"><div class="icon">🏅</div><span>Best Immigration Resources</span></div>
          <div class="about-badge"><div class="icon">🛂</div><span>Visa Assistance</span></div>
        </div>
        <ul class="about-perks">
          <li>Offer 100% Genuine Assistance</li>
          <li>It's Faster &amp; Reliable Execution</li>
          <li>Accurate &amp; Expert Advice</li>
        </ul>
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
        <a href="{{ route('about') }}" class="btn btn-primary">Know More</a>
      </div>

    </div>
  </div>
</section> --}}
<x-frontend.home-about />

{{-- ===== OUR VENTURES ===== --}}
<section id="ventures">
  <div class="container">
    <div class="ventures-intro fade-up">
      <div class="section-label">Our Business</div>
      <h2 class="section-title">Our Ventures</h2>
      <p class="section-sub">Beyond education consultancy, we run a family of ventures united by one mission - empowering people to grow, learn, and succeed.</p>
    </div>
    <div class="ventures-grid">
      @forelse($ventures as $i => $venture)
      <div class="venture-card fade-up" @if($i > 0) style="transition-delay:{{ round($i * .1, 2) }}s" @endif>
        <span class="venture-status status-{{ str_replace('_','-',$venture->status) }}">{{ $venture->status_label }}</span>
        <div class="venture-banner" style="{{ $venture->banner_style }}">
          @if($venture->banner_image)
            <img src="{{ $venture->banner_image_url }}" class="venture-banner-img" alt="{{ $venture->name }}">
          @else
            <span style="font-size:72px;opacity:.12;user-select:none">{{ $venture->emoji }}</span>
          @endif
        </div>
        <div class="venture-logo-wrap">{{ $venture->emoji }}</div>
        <div class="venture-body">
          @if($venture->tag_label)
            <span class="venture-tag" style="background:{{ $venture->tag_bg ?? 'var(--blue-light)' }};color:{{ $venture->tag_color ?? 'var(--blue)' }}">{{ $venture->tag_label }}</span>
          @endif
          <h3>{{ $venture->name }}</h3>
          @if($venture->description)
            <p>{{ \Illuminate\Support\Str::limit($venture->description, 120) }}</p>
          @endif
        </div>
        <div class="venture-links">
          <a href="{{ $venture->primary_btn_url ?: route('ventures.show', $venture->slug) }}" class="venture-link primary">{{ $venture->primary_btn_label ?: 'Learn More' }}</a>
          {{-- <a href="{{ $venture->secondary_btn_url ?: route('contact') }}" class="venture-link outline">{{ $venture->secondary_btn_label ?: 'Contact' }}</a> --}}
        </div>
      </div>
      @empty
      <div class="sa-empty">
        <strong>No ventures added yet.</strong>
        <span>Ventures added from the CMS will appear here automatically.</span>
      </div>
      @endforelse
    </div>
  </div>
</section>

{{-- ===== WHAT WE OFFER ===== --}}
@if($homeServices?->is_active && ! empty($homeServices->services))
<section id="services" class="section">
  <div class="container">
    <div class="section-head fade-up">
      <div class="section-label">{{ $homeServices->section_label ?: 'What We Offer' }}</div>
      <h2 class="section-title">{{ $homeServices->section_title ?: 'Our Core Services' }}</h2>
      @if($homeServices->section_subtitle)
        <p class="section-sub">{{ $homeServices->section_subtitle }}</p>
      @endif
    </div>
    <div class="services-grid">
      @foreach($homeServices->services as $i => $service)
        @if(! empty($service['title']) || ! empty($service['description']))
        <div class="service-card fade-up" @if($i > 0) style="transition-delay:{{ round(($i % 6) * .1, 2) }}s" @endif>
          @if(! empty($service['icon']))
            <div class="service-icon">{{ $service['icon'] }}</div>
          @endif
          @if(! empty($service['title']))
            <h4>{{ $service['title'] }}</h4>
          @endif
          @if(! empty($service['description']))
            <p>{{ $service['description'] }}</p>
          @endif
          {{-- @if(! empty($service['link_label']) && ! empty($service['link_url']))
            <a href="{{ $service['link_url'] }}" class="read-more">{{ $service['link_label'] }}</a>
          @endif --}}
        </div>
        @endif
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ===== COURSES ===== --}}
<section id="courses" class="section" style="background:#fff">
  <div class="container">
    <div class="section-head fade-up">
      <div class="section-label">{{ $coursePage?->catalog_label ?: 'Check Our Course' }}</div>
      <h2 class="section-title">{{ $coursePage?->catalog_title ?: 'Popular Language & Test Prep Courses' }}</h2>
      <p class="section-sub">{{ $coursePage?->intro_subtitle ?: 'Prepare for your future with internationally recognized language and aptitude certifications.' }}</p>
    </div>
    <div class="courses-grid">
      @forelse($courses as $i => $course)
      <a href="{{ route('course.show', $course->slug) }}" class="course-card course-card-link fade-up" @if($i > 0) style="transition-delay:{{ round($i * .1, 2) }}s" @endif>
        <div class="course-img">
          @if($course->image_url)
            <img src="{{ $course->image_url }}" alt="{{ $course->title }}">
          @endif
          @if($course->badge)
            <div class="course-flag">{{ $course->badge }}</div>
          @endif
        </div>
        <div class="course-body">
          <h4>{{ $course->title }}</h4>
          @if($course->excerpt)
            <p>{{ $course->excerpt }}</p>
          @endif
          <span class="course-card-cta">View Course</span>
        </div>
      </a>
      @empty
      <div class="sa-empty">
        <strong>No courses added yet.</strong>
        <span>Courses added from the CMS will appear here automatically.</span>
      </div>
      @endforelse
    </div>
    <div class="courses-cta"><a href="{{ route('courses') }}" class="btn btn-primary">More Courses</a></div>
  </div>
</section>

{{-- ===== STUDY ABROAD ===== --}}
<section id="study-abroad" class="section">
  <div class="container">
    <div class="section-head fade-up">
      <div class="section-label">{{ $studyAbroadPage?->section_label ?: 'Study Abroad' }}</div>
      <h2 class="section-title">{{ $studyAbroadPage?->section_title ?: 'Choose Your Dream Destination' }}</h2>
      <p class="section-sub">{{ $studyAbroadPage?->hero_subtitle ?: 'We assist students in pursuing world-class education across the globe with expert guidance at every step.' }}</p>
    </div>
    <div class="countries-grid">
      @forelse($destinations as $i => $destination)
      <a href="{{ route('study-abroad-detail', $destination->slug) }}" class="country-card fade-up" @if($i > 0) style="transition-delay:{{ round($i * .1, 2) }}s" @endif>
        @if($destination->card_image_url)
          <img src="{{ $destination->card_image_url }}" alt="{{ $destination->card_title ?: 'Study in ' . $destination->country }}">
        @endif
        <div class="country-overlay">
          @if($destination->flag)
            <div class="country-flag">{{ $destination->flag }}</div>
          @endif
          <h4>{{ $destination->card_title ?: 'Study in ' . $destination->country }}</h4>
          @if($destination->card_description)
            <span>{{ \Illuminate\Support\Str::limit($destination->card_description, 70) }}</span>
          @endif
        </div>
      </a>
      @empty
      <div class="sa-empty">
        <strong>No destinations added yet.</strong>
        <span>Study abroad destinations added from the CMS will appear here automatically.</span>
      </div>
      @endforelse
    </div>
    <div class="study-cta"><a href="{{ route('study-abroad') }}" class="btn btn-secondary">More Countries</a></div>
  </div>
</section>

{{-- ===== TESTIMONIALS SLIDER ===== --}}
@if($homeTestimonials?->is_active && ! empty($homeTestimonials->testimonials))
<section id="testimonials" class="section testimonials-slider-section">
  <div class="container">
    <div class="section-head test-head fade-up">
      <div class="section-label">{{ $homeTestimonials->section_label ?: 'Testimonials And Success Stories' }}</div>
      <h2 class="section-title">{{ $homeTestimonials->section_title ?: 'What Our Students Say' }}</h2>
      @if($homeTestimonials->section_subtitle)
        <p class="section-sub">{{ $homeTestimonials->section_subtitle }}</p>
      @endif
    </div>
    <div class="test-slider fade-up">
      <div class="test-slider-viewport">
        <div class="test-slider-track" id="testSliderTrack">
          @foreach($homeTestimonials->testimonials as $t)
          <div class="test-slide {{ $loop->first ? 'active' : '' }}">
            <div class="test-card">
              <div class="stars">{{ str_repeat('*', (int)($t['rating'] ?? 5)) }}</div>
              @if(! empty($t['quote']))
                <p class="test-quote">"{{ $t['quote'] }}"</p>
              @endif
              <div class="test-author">
                <div class="test-avatar-placeholder">{{ $t['avatar'] ?: substr($t['name'] ?? 'H', 0, 1) }}</div>
                <div>
                  @if(! empty($t['name']))<strong>{{ $t['name'] }}</strong>@endif
                  @if(! empty($t['role']))<span>{{ $t['role'] }}</span>@endif
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="test-slider-controls">
        <button type="button" class="test-arrow test-prev" id="testPrev" aria-label="Previous testimonial">←</button>
        <div class="test-dots" id="testDots">
          @foreach($homeTestimonials->testimonials as $t)
            <button type="button" class="test-dot {{ $loop->first ? 'active' : '' }}"
                    data-slide="{{ $loop->index }}" aria-label="Testimonial {{ $loop->iteration }}"></button>
          @endforeach
        </div>
        <button type="button" class="test-arrow test-next" id="testNext" aria-label="Next testimonial">→</button>
      </div>
    </div>
  </div>
</section>
@endif

{{-- ===== EVENTS ===== --}}
<section id="events" class="section">
  <div class="container">
    <div class="section-head fade-up">
      <div class="section-label">{{ $eventSection['section_label'] ?? 'Latest Events' }}</div>
      <h2 class="section-title">{{ $eventSection['title'] ?? 'Upcoming & Recent Events' }}</h2>
    </div>
    @if($featuredEvent || $events->isNotEmpty())
    <div class="events-grid">
      @if($featuredEvent)
      <div class="event-featured fade-up">
        <img src="{{ $featuredEvent->image_url }}" alt="{{ $featuredEvent->title }}">
        <div class="event-featured-body">
          <div class="event-tag">{{ ucfirst($featuredEvent->status) }}</div>
          <h3>{{ $featuredEvent->title }}</h3>
          <ul class="event-meta">
            @if($featuredEvent->event_date)
              <li><span>Date</span> {{ $featuredEvent->event_date->format('d M Y') }}</li>
            @endif
            @if($featuredEvent->location)
              <li><span>Place</span> {{ $featuredEvent->location }}</li>
            @endif
            @if($featuredEvent->organizer)
              <li><span>Host</span> {{ $featuredEvent->organizer }}</li>
            @endif
          </ul>
          <a href="{{ $featuredEvent->learn_more_url ?: route('events.show', $featuredEvent) }}" @if($featuredEvent->learn_more_url) target="_blank" rel="noopener" @endif class="btn btn-secondary" style="font-size:13px;padding:9px 20px">Learn More</a>
        </div>
      </div>
      @endif
      <div class="events-list fade-up" style="transition-delay:.15s">
        @forelse($events as $event)
        <div class="event-item">
          <div class="event-date">
            <strong>{{ $event->event_date?->format('d') }}</strong>
            <span>{{ $event->event_date?->format('M') }}</span>
          </div>
          <div class="event-info">
            <h4><a href="{{ $event->learn_more_url ?: route('events.show', $event) }}" @if($event->learn_more_url) target="_blank" rel="noopener" @endif style="color:inherit;text-decoration:none">{{ $event->title }}</a></h4>
            @if($event->description)
              <p>{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>
            @endif
          </div>
        </div>
        @empty
          @unless($featuredEvent)
          <div class="sa-empty">
            <strong>No events added yet.</strong>
            <span>Events added from the CMS will appear here automatically.</span>
          </div>
          @endunless
        @endforelse
      </div>
    </div>
    @else
    <div class="sa-empty fade-up">
      <strong>No events added yet.</strong>
      <span>Events added from the CMS will appear here automatically.</span>
    </div>
    @endif
    <div class="events-cta"><a href="{{ route('events') }}" class="btn btn-primary">More Events</a></div>
  </div>
</section>

{{-- ===== BLOG ===== --}}
<section id="blog" class="section">
  <div class="container">
    <div class="section-head fade-up">
      <div class="section-label">Latest Blog Posts</div>
      <h2 class="section-title">News & Insights</h2>
      <p class="section-sub">Stay informed with the latest updates on study abroad, visa rules, and exam tips.</p>
    </div>
    <div class="blog-grid">
      @forelse($latestBlogPosts as $i => $blog)
      <div class="blog-card fade-up" @if($i > 0) style="transition-delay:{{ $i * 0.1 }}s" @endif>
        <div class="blog-img">
          @if($blog->image_url)
            <img src="{{ $blog->image_url }}" alt="{{ $blog->image_alt ?: $blog->title }}">
          @endif
          @if($blog->published_at)
            <div class="blog-date">{{ $blog->published_at->format('M d, Y') }}</div>
          @endif
        </div>
        <div class="blog-body">
          @if($blog->category)
            <div class="blog-meta">{{ $blog->category }}</div>
          @endif
          <h4>{{ $blog->title }}</h4>
          @if($blog->excerpt)
            <p>{{ $blog->excerpt }}</p>
          @endif
          <a href="{{ route('blog.show', $blog->slug) }}" class="blog-link">Learn More</a>
        </div>
      </div>
      @empty
      <div class="sa-empty">
        <strong>No blog posts added yet.</strong>
        <span>Posts added from the CMS will appear here automatically.</span>
      </div>
      @endforelse
    </div>
    <div class="blog-cta"><a href="{{ route('blog') }}" class="btn btn-secondary">More Blogs</a></div>
  </div>
</section>

{{-- ===== CTA BANNER ===== --}}
<x-frontend.cta-banner
    title="Reach Out to Our Consultant Now"
    subtitle="Free counseling sessions available — take the first step toward your dream education abroad."
    btn-label="Book Free Counseling"
    btn-link="#"
    btn2-label="Learn More"
    btn2-link="{{ route('about') }}"
/>

@if(($homePopupBanners ?? collect())->isNotEmpty())
<div class="home-popup" id="homePopup" aria-hidden="true">
  <div class="home-popup-backdrop" data-popup-close></div>
  <div class="home-popup-dialog" role="dialog" aria-modal="true" aria-label="Home page announcement">
    <button type="button" class="home-popup-close" data-popup-close aria-label="Close popup">x</button>
    <div class="home-popup-frame">
      @foreach($homePopupBanners as $banner)
        <a href="{{ $banner->link_url ?: '#' }}" class="home-popup-slide {{ $loop->first ? 'active' : '' }}" data-popup-slide="{{ $loop->index }}" @if($banner->link_url) target="_blank" rel="noopener" @else onclick="return false" @endif>
          <img src="{{ $banner->image_url }}" alt="{{ $banner->title ?: 'Announcement banner' }}">
        </a>
      @endforeach
    </div>
    @if($homePopupBanners->count() > 1)
      <button type="button" class="home-popup-nav prev" id="homePopupPrev" aria-label="Previous banner">‹</button>
      <button type="button" class="home-popup-nav next" id="homePopupNext" aria-label="Next banner">›</button>
      <div class="home-popup-dots">
        @foreach($homePopupBanners as $banner)
          <button type="button" class="{{ $loop->first ? 'active' : '' }}" data-popup-dot="{{ $loop->index }}" aria-label="Show banner {{ $loop->iteration }}"></button>
        @endforeach
      </div>
    @endif
  </div>
</div>

<style>
.home-popup{position:fixed;inset:0;z-index:5000;display:none;align-items:center;justify-content:center;padding:22px}
.home-popup.show{display:flex}
.home-popup-backdrop{position:absolute;inset:0;background:rgba(9,15,55,.72);backdrop-filter:blur(3px)}
.home-popup-dialog{position:relative;width:min(92vw,760px);max-height:88vh;border-radius:10px;background:#fff;box-shadow:0 28px 90px rgba(0,0,0,.35);overflow:hidden}
.home-popup-close{position:absolute;top:10px;right:10px;z-index:4;width:34px;height:34px;border:none;border-radius:50%;background:rgba(13,21,96,.88);color:#fff;font-size:18px;font-weight:800;cursor:pointer;line-height:1}
.home-popup-frame{position:relative;background:#f8fafc}
.home-popup-slide{display:none}
.home-popup-slide.active{display:block}
.home-popup-slide img{width:100%;max-height:82vh;object-fit:contain;display:block}
.home-popup-nav{position:absolute;top:50%;transform:translateY(-50%);z-index:3;width:38px;height:48px;border:none;border-radius:8px;background:rgba(13,21,96,.82);color:#fff;font-size:30px;line-height:1;cursor:pointer}
.home-popup-nav.prev{left:12px}
.home-popup-nav.next{right:12px}
.home-popup-dots{position:absolute;left:0;right:0;bottom:12px;z-index:3;display:flex;justify-content:center;gap:8px}
.home-popup-dots button{width:9px;height:9px;border-radius:999px;border:none;background:rgba(255,255,255,.65);cursor:pointer}
.home-popup-dots button.active{width:24px;background:#cc2222}
@media(max-width:560px){.home-popup{padding:14px}.home-popup-dialog{width:100%;border-radius:8px}.home-popup-nav{width:32px;height:42px;font-size:24px}}
</style>
@endif

@endsection

@push('scripts')
<script>
// Home popup banner
(function () {
  const popup = document.getElementById('homePopup');
  if (!popup) return;

  const slides = popup.querySelectorAll('[data-popup-slide]');
  const dots = popup.querySelectorAll('[data-popup-dot]');
  const prev = document.getElementById('homePopupPrev');
  const next = document.getElementById('homePopupNext');
  let current = 0;

  function show(index) {
    current = (index + slides.length) % slides.length;
    slides.forEach((slide, i) => slide.classList.toggle('active', i === current));
    dots.forEach((dot, i) => dot.classList.toggle('active', i === current));
  }

  function closePopup() {
    popup.classList.remove('show');
    popup.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    sessionStorage.setItem('homePopupSeen', '1');
  }

  function openPopup() {
    popup.classList.add('show');
    popup.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  if (!sessionStorage.getItem('homePopupSeen')) {
    window.setTimeout(openPopup, 450);
  }

  popup.querySelectorAll('[data-popup-close]').forEach(el => el.addEventListener('click', closePopup));
  prev?.addEventListener('click', () => show(current - 1));
  next?.addEventListener('click', () => show(current + 1));
  dots.forEach(dot => dot.addEventListener('click', () => show(parseInt(dot.dataset.popupDot, 10))));
  document.addEventListener('keydown', event => {
    if (!popup.classList.contains('show')) return;
    if (event.key === 'Escape') closePopup();
    if (event.key === 'ArrowLeft') show(current - 1);
    if (event.key === 'ArrowRight') show(current + 1);
  });
})();

// ── Hero Slider ──────────────────────────────────────────────────────
(function () {
  const textSlides   = document.querySelectorAll('.hero-text-slide');
  const visualSlides = document.querySelectorAll('.hero-visual-slide');
  const dots         = document.querySelectorAll('.hero-dot-slide');
  const prevBtn      = document.getElementById('heroPrev');
  const nextBtn      = document.getElementById('heroNext');
  const hero         = document.getElementById('hero');
  const textTrack    = document.getElementById('heroTextTrack');
  if (!textSlides.length) return;

  let current = 0, timer = null;
  const INTERVAL = 5500;

  function setTrackHeight() {
    const active = textSlides[current];
    if (active && textTrack) textTrack.style.minHeight = active.offsetHeight + 'px';
  }

  function goTo(index) {
    current = (index + textSlides.length) % textSlides.length;
    textSlides.forEach((s, i)   => s.classList.toggle('active', i === current));
    visualSlides.forEach((s, i) => s.classList.toggle('active', i === current));
    dots.forEach((d, i)         => d.classList.toggle('active', i === current));
    requestAnimationFrame(setTrackHeight);
  }

  function startAutoplay() { stopAutoplay(); timer = setInterval(() => goTo(current + 1), INTERVAL); }
  function stopAutoplay()  { if (timer) clearInterval(timer); timer = null; }
  function resetAutoplay() { stopAutoplay(); startAutoplay(); }

  dots.forEach(d => d.addEventListener('click', () => { goTo(parseInt(d.dataset.slide, 10)); resetAutoplay(); }));
  prevBtn?.addEventListener('click', () => { goTo(current - 1); resetAutoplay(); });
  nextBtn?.addEventListener('click', () => { goTo(current + 1); resetAutoplay(); });
  hero?.addEventListener('mouseenter', stopAutoplay);
  hero?.addEventListener('mouseleave', startAutoplay);
  document.addEventListener('visibilitychange', () => document.hidden ? stopAutoplay() : startAutoplay());

  setTrackHeight();
  window.addEventListener('resize', setTrackHeight);
  startAutoplay();
})();

// ── Testimonials Slider ───────────────────────────────────────────────
(function () {
  const track   = document.getElementById('testSliderTrack');
  const section = document.querySelector('.testimonials-slider-section');
  if (!track || !section) return;

  const slides  = track.querySelectorAll('.test-slide');
  const dots    = section.querySelectorAll('.test-dot');
  const prevBtn = document.getElementById('testPrev');
  const nextBtn = document.getElementById('testNext');
  let current = 0, timer = null;
  const INTERVAL = 6000;

  function goTo(index) {
    current = (index + slides.length) % slides.length;
    track.style.transform = `translateX(-${current * 100}%)`;
    slides.forEach((s, i) => s.classList.toggle('active', i === current));
    dots.forEach((d, i)   => d.classList.toggle('active', i === current));
  }

  function startAutoplay() { stopAutoplay(); timer = setInterval(() => goTo(current + 1), INTERVAL); }
  function stopAutoplay()  { if (timer) clearInterval(timer); timer = null; }
  function resetAutoplay() { stopAutoplay(); startAutoplay(); }

  dots.forEach(d => d.addEventListener('click', () => { goTo(parseInt(d.dataset.slide, 10)); resetAutoplay(); }));
  prevBtn?.addEventListener('click', () => { goTo(current - 1); resetAutoplay(); });
  nextBtn?.addEventListener('click', () => { goTo(current + 1); resetAutoplay(); });
  section.addEventListener('mouseenter', stopAutoplay);
  section.addEventListener('mouseleave', startAutoplay);
  document.addEventListener('visibilitychange', () => document.hidden ? stopAutoplay() : startAutoplay());

  goTo(0);
  startAutoplay();
})();
</script>
@endpush
