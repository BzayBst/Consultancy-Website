{{-- resources/views/pages/ventures.blade.php --}}
@extends('layouts.app', ['active' => 'ventures'])

@section('title', 'Our Ventures – ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description', 'Learn about HASU Educational Consultancy — our story, mission, vision, team, and why thousands of Nepali students trust us.')

@section('content')

{{-- ===== PAGE HERO ===== --}}
<x-frontend.page-hero
    badge="One Family · Many Ventures · Endless Opportunities"
    title="Growing Together,"
    highlight="Building Futures"
    subtitle="Explore the HASU family of ventures — each dedicated to education, language, and opportunity for Nepali students and communities."
    :breadcrumbs="[['label'=>'Home','url'=> route('home')], ['label'=>'Our Ventures']]"
/>

<!-- ===== INTRO ===== -->
<section id="ventures-intro" class="section">
  <div class="container">
    <div class="ventures-page-intro fade-up">
      <div class="section-label">Our Business</div>
      <h2 class="section-title">A Family of Ventures Under One Roof</h2>
      <p class="section-sub">Beyond education consultancy, HASU operates a growing portfolio of companies united by one mission — empowering people to grow, learn, and succeed at home and abroad.</p>
    </div>
  </div>
</section>

<!-- ===== FEATURED VENTURE ===== -->
<section id="venture-featured">
  <div class="container">
    <div class="venture-featured-card fade-up">
      <div class="vf-banner" style="background:linear-gradient(135deg,#0d1560 0%,#2952e3 60%,#5b7cf7 100%)">
        <span class="venture-status status-flagship">Flagship Venture</span>
        <div class="vf-banner-deco">🎓</div>
      </div>
      <div class="vf-body">
        <div class="vf-logo">🎓</div>
        <div class="vf-content">
          <span class="venture-tag" style="background:var(--blue-light);color:var(--blue)">Education · Est. 2013</span>
          <h2>HASU Educational Consultancy</h2>
          <p>Our flagship company guiding Nepali students to top universities in Japan, Australia, UK, Canada, USA, and New Zealand since 2013. From counseling and admissions to visa processing and pre-departure orientation — we handle every step of your global education journey.</p>
          <ul class="vf-highlights">
            <li>Admission & university placement</li>
            <li>Visa documentation & processing</li>
            <li>Scholarship & financial guidance</li>
            <li>Pre-departure orientation</li>
          </ul>
          <div class="vf-actions">
            <a href="venture-detail.html" class="btn btn-primary">View Full Details →</a>
            <a href="contact.html" class="btn btn-secondary">Book Counseling</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== VENTURE LISTING ===== -->
<section id="ventures-listing">
  <div class="container">
    <div class="ventures-listing-head fade-up">
      <div>
        <div class="section-label" style="margin-bottom:8px">Browse All</div>
        <h2 class="section-title" style="margin-bottom:0;text-align:left">Our Venture Portfolio</h2>
      </div>
      <div class="venture-filters" id="ventureFilters">
        <button class="vf-btn active" data-filter="all">All</button>
        <button class="vf-btn" data-filter="education">Education</button>
        <button class="vf-btn" data-filter="language">Language</button>
        <button class="vf-btn" data-filter="business">Business</button>
      </div>
    </div>

    <div class="ventures-grid ventures-page-grid" id="venturesGrid">

      <div class="venture-card fade-up" data-category="education">
        <span class="venture-status status-flagship">Flagship</span>
        <div class="venture-banner" style="background:linear-gradient(135deg,#0d1560,#2952e3)">
          <span style="font-size:72px;opacity:.12;user-select:none">🎓</span>
        </div>
        <div class="venture-logo-wrap">🎓</div>
        <div class="venture-body">
          <span class="venture-tag" style="background:var(--blue-light);color:var(--blue)">Education</span>
          <h3>HASU Educational Consultancy</h3>
          <p>Flagship consultancy for study abroad — Japan, Australia, UK, Canada, USA &amp; New Zealand.</p>
          <div class="venture-meta">
            <span>📍 Bhairahawa</span>
            <span>📅 Since 2013</span>
          </div>
        </div>
        <div class="venture-links">
          <a href="venture-detail.html" class="venture-link primary">Learn More →</a>
          <a href="contact.html" class="venture-link outline">Contact</a>
        </div>
      </div>

      <div class="venture-card fade-up" data-category="language" style="transition-delay:.08s">
        <span class="venture-status status-active">Active</span>
        <div class="venture-banner" style="background:linear-gradient(135deg,#7b1fa2,#e91e63)">
          <span style="font-size:72px;opacity:.12;user-select:none">🗣️</span>
        </div>
        <div class="venture-logo-wrap">🗣️</div>
        <div class="venture-body">
          <span class="venture-tag" style="background:#fdf4ff;color:#7b1fa2">Language</span>
          <h3>HASU Language Institute</h3>
          <p>Japanese (NAT/JLPT/J-TEST), IELTS &amp; PTE classes with certified expert instructors.</p>
          <div class="venture-meta">
            <span>📍 Bhairahawa</span>
            <span>📅 Since 2018</span>
          </div>
        </div>
        <div class="venture-links">
          <a href="index.html#courses" class="venture-link primary">View Courses →</a>
          <a href="contact.html" class="venture-link outline">Enroll</a>
        </div>
      </div>

      <div class="venture-card fade-up" data-category="business" style="transition-delay:.16s">
        <span class="venture-status status-new">New</span>
        <div class="venture-banner" style="background:linear-gradient(135deg,#cc2222,#ff6f00)">
          <span style="font-size:72px;opacity:.12;user-select:none">🏢</span>
        </div>
        <div class="venture-logo-wrap">🏢</div>
        <div class="venture-body">
          <span class="venture-tag" style="background:#fff7ed;color:#c2410c">Business</span>
          <h3>HASU Events &amp; Sports</h3>
          <p>Community events and sports initiatives including HASU Chitwan GoldCup — building local pride.</p>
          <div class="venture-meta">
            <span>📍 Chitwan</span>
            <span>📅 Since 2024</span>
          </div>
        </div>
        <div class="venture-links">
          <a href="index.html#events" class="venture-link primary">View Events →</a>
          <a href="contact.html" class="venture-link outline">Partner</a>
        </div>
      </div>

      <div class="venture-card fade-up" data-category="education" style="transition-delay:.24s">
        <span class="venture-status status-active">Active</span>
        <div class="venture-banner" style="background:linear-gradient(135deg,#0d9488,#14b8a6)">
          <span style="font-size:72px;opacity:.12;user-select:none">📋</span>
        </div>
        <div class="venture-logo-wrap">📋</div>
        <div class="venture-body">
          <span class="venture-tag" style="background:#ecfdf5;color:#0d9488">Admissions</span>
          <h3>HASU Document Services</h3>
          <p>Professional document preparation, translation, and notarization for student visa applications.</p>
          <div class="venture-meta">
            <span>📍 Bhairahawa</span>
            <span>📅 Since 2016</span>
          </div>
        </div>
        <div class="venture-links">
          <a href="contact.html" class="venture-link primary">Get Help →</a>
          <a href="contact.html" class="venture-link outline">Contact</a>
        </div>
      </div>

      <div class="venture-card fade-up" data-category="language" style="transition-delay:.32s">
        <span class="venture-status status-active">Active</span>
        <div class="venture-banner" style="background:linear-gradient(135deg,#1d4ed8,#60a5fa)">
          <span style="font-size:72px;opacity:.12;user-select:none">🇯🇵</span>
        </div>
        <div class="venture-logo-wrap">🇯🇵</div>
        <div class="venture-body">
          <span class="venture-tag" style="background:var(--blue-light);color:var(--blue)">Japan Focus</span>
          <h3>HASU Japan Desk</h3>
          <p>Dedicated Japan admissions desk with direct university partnerships and cultural prep programs.</p>
          <div class="venture-meta">
            <span>📍 Bhairahawa</span>
            <span>📅 Since 2015</span>
          </div>
        </div>
        <div class="venture-links">
          <a href="index.html#study-abroad" class="venture-link primary">Study Japan →</a>
          <a href="contact.html" class="venture-link outline">Inquire</a>
        </div>
      </div>

      <div class="venture-card fade-up" data-category="business" style="transition-delay:.4s">
        <span class="venture-status status-coming">Coming Soon</span>
        <div class="venture-banner" style="background:linear-gradient(135deg,#4c1d95,#7c3aed)">
          <span style="font-size:72px;opacity:.12;user-select:none">🚀</span>
        </div>
        <div class="venture-logo-wrap">🚀</div>
        <div class="venture-body">
          <span class="venture-tag" style="background:#f5f3ff;color:#6d28d9">Innovation</span>
          <h3>HASU Digital Platform</h3>
          <p>Online counseling portal and student tracking system — launching soon to serve students nationwide.</p>
          <div class="venture-meta">
            <span>🌐 Online</span>
            <span>📅 2026</span>
          </div>
        </div>
        <div class="venture-links">
          <a href="contact.html" class="venture-link primary">Notify Me →</a>
          <a href="contact.html" class="venture-link outline">Contact</a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ===== ECOSYSTEM ===== -->
<section id="venture-eco" class="section">
  <div class="container">
    <div class="section-head fade-up">
      <div class="section-label">How It Works</div>
      <h2 class="section-title">One Ecosystem, Complete Support</h2>
      <p class="section-sub">Our ventures don't operate in silos — they work together so every student gets seamless support from language prep to landing abroad.</p>
    </div>
    <div class="venture-eco-grid">
      <div class="eco-card fade-up">
        <div class="eco-step">01</div>
        <div class="eco-icon">🗣️</div>
        <h4>Learn &amp; Prepare</h4>
        <p>Start at HASU Language Institute — master Japanese, IELTS, or PTE with expert trainers before you apply.</p>
      </div>
      <div class="eco-card fade-up" style="transition-delay:.1s">
        <div class="eco-step">02</div>
        <div class="eco-icon">🎓</div>
        <h4>Apply &amp; Place</h4>
        <p>HASU Educational Consultancy handles university selection, applications, scholarships, and visa processing.</p>
      </div>
      <div class="eco-card fade-up" style="transition-delay:.2s">
        <div class="eco-step">03</div>
        <div class="eco-icon">✈️</div>
        <h4>Depart &amp; Thrive</h4>
        <p>Pre-departure briefings, document services, and alumni community keep you supported long after you land.</p>
      </div>
    </div>
  </div>
</section>


{{-- ===== CTA BANNER ===== --}}
<x-frontend.cta-banner
    title="Ready to Begin Your Global Journey?"
    subtitle="Book a free counseling session today — let HASU guide you to the education you deserve."
    btn-label="Book Free Counseling"
    btn-link="#"
    btn2-label="Our Services"
    btn2-link="{{ route('home') }}#services"
/>

@endsection

@push('scripts')
<script>
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => navbar.classList.toggle('scrolled', window.scrollY > 20));

const hamburger = document.getElementById('hamburger');
const mobileNav = document.getElementById('mobileNav');
const closeNav = document.getElementById('closeNav');
hamburger.addEventListener('click', () => mobileNav.classList.add('open'));
closeNav.addEventListener('click', () => mobileNav.classList.remove('open'));
mobileNav.querySelectorAll('a').forEach(a => a.addEventListener('click', () => mobileNav.classList.remove('open')));

const fadeEls = document.querySelectorAll('.fade-up');
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
fadeEls.forEach(el => observer.observe(el));

const statNums = document.querySelectorAll('.stat-num');
const statObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const el = entry.target;
      const accent = el.querySelector('.accent');
      const accentText = accent ? accent.textContent : '';
      const rawText = el.textContent.replace(accentText, '').trim();
      const target = parseInt(rawText.replace(/\D/g, ''));
      if (isNaN(target) || target <= 1) return;
      let start = 0;
      const duration = 1400;
      const step = (timestamp) => {
        if (!start) start = timestamp;
        const progress = Math.min((timestamp - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        const current = Math.floor(eased * target);
        el.innerHTML = current.toLocaleString() + (accent ? `<span class="accent">${accentText}</span>` : '');
        if (progress < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
      statObserver.unobserve(el);
    }
  });
}, { threshold: 0.5 });
statNums.forEach(el => statObserver.observe(el));

const filterBtns = document.querySelectorAll('.vf-btn');
const ventureCards = document.querySelectorAll('#venturesGrid .venture-card');
filterBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    filterBtns.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const filter = btn.dataset.filter;
    ventureCards.forEach(card => {
      const cat = card.dataset.category;
      const show = filter === 'all' || cat === filter;
      card.style.display = show ? '' : 'none';
      if (show) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(16px)';
        requestAnimationFrame(() => {
          card.style.transition = 'opacity .4s, transform .4s';
          card.style.opacity = '1';
          card.style.transform = '';
        });
      }
    });
  });
});
</script>
@endpush