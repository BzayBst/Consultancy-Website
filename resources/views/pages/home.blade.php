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
      <p class="section-sub">Beyond education consultancy, we run a family of ventures united by one mission — empowering people to grow, learn, and succeed.</p>
    </div>
    <div class="ventures-grid">

      <div class="venture-card fade-up">
        <span class="venture-status status-flagship">Flagship</span>
        <div class="venture-banner" style="background:linear-gradient(135deg,#0d1560,#2952e3)">
          <span style="font-size:72px;opacity:.12;user-select:none">🎓</span>
        </div>
        <div class="venture-logo-wrap">🎓</div>
        <div class="venture-body">
          <span class="venture-tag" style="background:var(--blue-light);color:var(--blue)">Education</span>
          <h3>HASU Educational Consultancy</h3>
          <p>Our flagship company guiding Nepali students to top universities in Japan, Australia, UK, Canada, and beyond since {{ setting('general_established', '2013') }}.</p>
        </div>
        <div class="venture-links">
          <a href="#" class="venture-link primary">Learn More →</a>
          <a href="{{ route('contact') }}" class="venture-link outline">Contact</a>
        </div>
      </div>

      <div class="venture-card fade-up" style="transition-delay:.1s">
        <span class="venture-status status-active">Active</span>
        <div class="venture-banner" style="background:linear-gradient(135deg,#7b1fa2,#e91e63)">
          <span style="font-size:72px;opacity:.12;user-select:none">🗣️</span>
        </div>
        <div class="venture-logo-wrap">🗣️</div>
        <div class="venture-body">
          <span class="venture-tag" style="background:#fdf4ff;color:#7b1fa2">Language</span>
          <h3>HASU Language Institute</h3>
          <p>Specialized language training center offering Japanese (NAT/JLPT/J-TEST), IELTS, and PTE classes with expert instructors.</p>
        </div>
        <div class="venture-links">
          <a href="#" class="venture-link primary">View Courses →</a>
          <a href="#cta-banner" class="venture-link outline">Enroll</a>
        </div>
      </div>

      <div class="venture-card fade-up" style="transition-delay:.2s">
        <span class="venture-status status-new">New</span>
        <div class="venture-banner" style="background:linear-gradient(135deg,#cc2222,#ff6f00)">
          <span style="font-size:72px;opacity:.12;user-select:none">🏢</span>
        </div>
        <div class="venture-logo-wrap">🏢</div>
        <div class="venture-body">
          <span class="venture-tag" style="background:#fff7ed;color:#c2410c">Business</span>
          <h3>Your Third Venture</h3>
          <p>Describe your third company here — what it does, who it serves, and what makes it unique.</p>
        </div>
        <div class="venture-links">
          <a href="#" class="venture-link primary">Learn More →</a>
          <a href="{{ route('contact') }}" class="venture-link outline">Contact</a>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ===== WHAT WE OFFER ===== --}}
<section id="services" class="section">
  <div class="container">
    <div class="section-head fade-up">
      <div class="section-label">What We Offer</div>
      <h2 class="section-title">Our Core Services</h2>
      <p class="section-sub">From admission guidance to visa processing, we handle every step of your international education journey.</p>
    </div>
    <div class="services-grid">
      <div class="service-card fade-up">
        <div class="service-icon">🎓</div>
        <h4>Admission Guidance</h4>
        <p>At HASU Educational, we simplify your journey to studying abroad, making it personalized, seamless, and stress-free.</p>
        <a href="#" class="read-more">Read More →</a>
      </div>
      <div class="service-card fade-up" style="transition-delay:.1s">
        <div class="service-icon">📚</div>
        <h4>Study Visa Counseling</h4>
        <p>Guiding you at every critical step in your journey to study abroad, ensuring clarity at every milestone.</p>
        <a href="#" class="read-more">Read More →</a>
      </div>
      <div class="service-card fade-up" style="transition-delay:.2s">
        <div class="service-icon">💰</div>
        <h4>Financial Assistance</h4>
        <p>At HASU International Educational Pvt. Ltd., we simplify financial guidance, scholarship, and student loan processing.</p>
        <a href="#" class="read-more">Read More →</a>
      </div>
      <div class="service-card fade-up" style="transition-delay:.3s">
        <div class="service-icon">🛂</div>
        <h4>Visa Assistance</h4>
        <p>HASU International Educational Pvt. Ltd. simplifies your visa application process for a smooth international transition.</p>
        <a href="#" class="read-more">Read More →</a>
      </div>
    </div>
   
  </div>
</section>

{{-- ===== COURSES ===== --}}
<section id="courses" class="section" style="background:#fff">
  <div class="container">
    <div class="section-head fade-up">
      <div class="section-label">Check Our Course</div>
      <h2 class="section-title">Popular Language & Test Prep Courses</h2>
      <p class="section-sub">Prepare for your future with internationally recognized language and aptitude certifications.</p>
    </div>
    <div class="courses-grid">
      <a href="#" class="course-card course-card-link fade-up">
        <div class="course-img">
          <img src="https://images.unsplash.com/photo-1528360983277-13d401cdc186?w=600&q=80" alt="Japanese Language">
          <div class="course-flag">🇯🇵 Japanese</div>
        </div>
        <div class="course-body">
          <h4>Japanese Language Course</h4>
          <p>NAT, JLPT, J-TEST preparation for students aiming to study or work in Japan.</p>
          <span class="course-card-cta">View Course →</span>
        </div>
      </a>
      <a href="#" class="course-card course-card-link fade-up" style="transition-delay:.1s">
        <div class="course-img">
          <img src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=600&q=80" alt="IELTS">
          <div class="course-flag">🇬🇧 IELTS</div>
        </div>
        <div class="course-body">
          <h4>IELTS Preparation</h4>
          <p>Expert coaching for IELTS with IDP-certified trainers and mock test sessions.</p>
          <span class="course-card-cta">View Course →</span>
        </div>
      </a>
      <a href="#" class="course-card course-card-link fade-up" style="transition-delay:.2s">
        <div class="course-img">
          <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&q=80" alt="PTE">
          <div class="course-flag">🇦🇺 PTE</div>
        </div>
        <div class="course-body">
          <h4>PTE Academic</h4>
          <p>Pearson Test of English preparation with proven strategies and practice materials.</p>
          <span class="course-card-cta">View Course →</span>
        </div>
      </a>
    </div>
    <div class="courses-cta"><a href="#" class="btn btn-primary">More Courses</a></div>
  </div>
</section>

{{-- ===== STUDY ABROAD ===== --}}
<section id="study-abroad" class="section">
  <div class="container">
    <div class="section-head fade-up">
      <div class="section-label">Study Abroad</div>
      <h2 class="section-title">Choose Your Dream Destination</h2>
      <p class="section-sub">We assist students in pursuing world-class education across the globe with expert guidance at every step.</p>
    </div>
    <div class="countries-grid">
      <div class="country-card fade-up">
        <img src="https://images.unsplash.com/photo-1526484892869-6f44c5ad80c3?w=500&q=80" alt="Japan">
        <div class="country-overlay">
          <div class="country-flag">🇯🇵</div>
          <h4>Study in Japan</h4>
          <span>Top Universities · Scholarships</span>
        </div>
      </div>
      <div class="country-card fade-up" style="transition-delay:.1s">
        <img src="https://images.unsplash.com/photo-1523482580672-f109ba8cb9be?w=500&q=80" alt="Australia">
        <div class="country-overlay">
          <div class="country-flag">🇦🇺</div>
          <h4>Study in Australia</h4>
          <span>World-Ranked Universities</span>
        </div>
      </div>
      <div class="country-card fade-up" style="transition-delay:.2s">
        <img src="https://images.unsplash.com/photo-1486325212027-8081e485255e?w=500&q=80" alt="UK">
        <div class="country-overlay">
          <div class="country-flag">🇬🇧</div>
          <h4>Study in UK</h4>
          <span>Prestigious Institutions</span>
        </div>
      </div>
      <div class="country-card fade-up" style="transition-delay:.3s">
        <img src="https://images.unsplash.com/photo-1549880338-65ddcdfd017b?w=500&q=80" alt="Canada">
        <div class="country-overlay">
          <div class="country-flag">🇨🇦</div>
          <h4>Study in Canada</h4>
          <span>Post-Study Work Visa</span>
        </div>
      </div>
    </div>
    <div class="study-cta"><a href="#" class="btn btn-secondary">More Countries</a></div>
  </div>
</section>

{{-- ===== TESTIMONIALS SLIDER ===== --}}
<section id="testimonials" class="section testimonials-slider-section">
  <div class="container">
    <div class="section-head test-head fade-up">
      <div class="section-label">Testimonials And Success Stories</div>
      <h2 class="section-title">What Our Students Say</h2>
      <p class="section-sub">Real words from students, parents, and partners whose lives were changed by HASU.</p>
    </div>
    <div class="test-slider fade-up">
      <div class="test-slider-viewport">
        <div class="test-slider-track" id="testSliderTrack">
          @php
          $testimonials = [
            ['quote'=>'As a parent, I was looking for a reliable consultancy for my son\'s study in Japan. HASU guided us with transparency and professionalism. They took care of everything and kept us updated at every stage.','name'=>'Mr. Pramod Adhikari','role'=>'Parent · Study in Japan','avatar'=>'👤'],
            ['quote'=>'We have partnered with HASU for several years and are consistently impressed by the quality of students they recommend. Their team prepares students academically and culturally for life in Japan.','name'=>'Mr. Takunari Nakamura','role'=>'Principal, Kyoto International Academy of Language','avatar'=>'🏫'],
            ['quote'=>'HASU made my dream of studying in Japan a reality. From JLPT coaching to visa processing, every step was handled with professionalism. I am now enrolled at Osaka University!','name'=>'Anil Thapa','role'=>'Osaka University, Japan','avatar'=>'👦'],
            ['quote'=>'I was confused about studying in Australia, but HASU\'s counselors cleared every doubt. They got me into my first-choice university and helped with the entire visa process. Highly recommend!','name'=>'Sita Gurung','role'=>'University of Melbourne, Australia','avatar'=>'👧'],
            ['quote'=>'The team at HASU is incredibly dedicated. They went above and beyond to ensure my documents were perfect. My student visa was approved on the first attempt — something I didn\'t expect!','name'=>'Rajan Bhattarai','role'=>'University of Toronto, Canada','avatar'=>'👨'],
            ['quote'=>'HASU\'s IELTS coaching was a game changer. I scored an 8.0 band and secured a scholarship to the University of Leeds. The trainers are exceptionally skilled and supportive.','name'=>'Kabita Shrestha','role'=>'University of Leeds, United Kingdom','avatar'=>'👩'],
          ];
          @endphp
          @foreach($testimonials as $t)
          <div class="test-slide {{ $loop->first ? 'active' : '' }}">
            <div class="test-card">
              <div class="stars">★★★★★</div>
              <p class="test-quote">"{{ $t['quote'] }}"</p>
              <div class="test-author">
                <div class="test-avatar-placeholder">{{ $t['avatar'] }}</div>
                <div>
                  <strong>{{ $t['name'] }}</strong>
                  <span>{{ $t['role'] }}</span>
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
          @foreach($testimonials as $t)
            <button type="button" class="test-dot {{ $loop->first ? 'active' : '' }}"
                    data-slide="{{ $loop->index }}" aria-label="Testimonial {{ $loop->iteration }}"></button>
          @endforeach
        </div>
        <button type="button" class="test-arrow test-next" id="testNext" aria-label="Next testimonial">→</button>
      </div>
    </div>
  </div>
</section>

{{-- ===== EVENTS ===== --}}
<section id="events" class="section">
  <div class="container">
    <div class="section-head fade-up">
      <div class="section-label">Latest Events</div>
      <h2 class="section-title">Upcoming & Recent Events</h2>
    </div>
    <div class="events-grid">
      <div class="event-featured fade-up">
        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600&q=80" alt="Event">
        <div class="event-featured-body">
          <div class="event-tag">Upcoming</div>
          <h3>HASU Chitwan GoldCup 3.0</h3>
          <ul class="event-meta">
            <li><span>📅</span> 19 Aug 2025</li>
            <li><span>📍</span> Bharatpur, Chitwan</li>
            <li><span>ℹ️</span> To be Announced, Jovem Pvt.</li>
          </ul>
          <a href="#" class="btn btn-secondary" style="font-size:13px;padding:9px 20px">Learn More</a>
        </div>
      </div>
      <div class="events-list fade-up" style="transition-delay:.15s">
        @php
        $events = [
          ['day'=>'15','mon'=>'Jun','title'=>'Free IELTS Seminar – Bhairahawa','desc'=>'Walk-in seminar on IELTS preparation strategies and band score targets.'],
          ['day'=>'22','mon'=>'Jun','title'=>'Japan Education Fair 2025','desc'=>'Meet representatives from top Japanese universities and language schools.'],
          ['day'=>'05','mon'=>'Jul','title'=>'Australia University Info Session','desc'=>'Learn about intakes, scholarships, and post-study work rights in Australia.'],
          ['day'=>'18','mon'=>'Jul','title'=>'PTE Practice Mock Test','desc'=>'Free mock PTE exam for registered students at HASU main campus.'],
        ];
        @endphp
        @foreach($events as $ev)
        <div class="event-item">
          <div class="event-date"><strong>{{ $ev['day'] }}</strong><span>{{ $ev['mon'] }}</span></div>
          <div class="event-info">
            <h4>{{ $ev['title'] }}</h4>
            <p>{{ $ev['desc'] }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    <div class="events-cta"><a href="#" class="btn btn-primary">More Events</a></div>
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
      @php
      $blogs = [
        ['img'=>'https://images.unsplash.com/photo-1528360983277-13d401cdc186?w=600&q=80','date'=>'May 12, 2025','meta'=>'Japan · Visa','title'=>'How to Apply for a Japanese Student Visa','desc'=>'A step-by-step guide to the Japanese student visa application process from Nepal.'],
        ['img'=>'https://images.unsplash.com/photo-1523482580672-f109ba8cb9be?w=600&q=80','date'=>'Apr 28, 2025','meta'=>'Australia · Visa','title'=>'How to Apply for an Australian Student Visa','desc'=>'Everything you need to know about the Australian Subclass 500 student visa.'],
        ['img'=>'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=600&q=80','date'=>'Apr 05, 2025','meta'=>'Japan · Intake','title'=>'April Intake 2026 – Complete Guide for Nepali Students','desc'=>'Key deadlines, required documents, and preparation tips for Japan April intake.'],
      ];
      @endphp
      @foreach($blogs as $i => $blog)
      <div class="blog-card fade-up" @if($i > 0) style="transition-delay:{{ $i * 0.1 }}s" @endif>
        <div class="blog-img">
          <img src="{{ $blog['img'] }}" alt="{{ $blog['title'] }}">
          <div class="blog-date">{{ $blog['date'] }}</div>
        </div>
        <div class="blog-body">
          <div class="blog-meta">{{ $blog['meta'] }}</div>
          <h4>{{ $blog['title'] }}</h4>
          <p>{{ $blog['desc'] }}</p>
          <a href="#" class="blog-link">Learn More →</a>
        </div>
      </div>
      @endforeach
    </div>
    <div class="blog-cta"><a href="#" class="btn btn-secondary">More Blogs</a></div>
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

@endsection

@push('scripts')
<script>
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