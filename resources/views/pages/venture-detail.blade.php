@extends('layouts.app', ['active' => 'ventures'])

@section('title', 'Our Ventures – ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description', 'Learn about HASU Educational Consultancy — our story, mission, vision, team, and why
    thousands of Nepali students trust us.')

@section('content')
    <!-- ===== VENTURE HERO ===== -->
    <section id="vd-hero" class="vd-hero" style="--vd-accent:#2952e3;--vd-accent-dark:#1a3ed4">
        <div class="ph-dot ph-dot-1"></div>
        <div class="ph-dot ph-dot-2"></div>
        <div class="ph-dot ph-dot-3"></div>
        <div class="container">
            <div class="vd-hero-inner fade-up">
                <div class="vd-hero-content">
                    <div class="breadcrumb">
                        <a href="index.html">Home</a>
                        <span>›</span>
                        <a href="ventures.html">Our Ventures</a>
                        <span>›</span>
                        <span style="color:rgba(255,255,255,.9)">HASU Educational Consultancy</span>
                    </div>
                    <div class="vd-hero-brand">
                        <div class="vd-hero-logo">🎓</div>
                        <div>
                            <span class="venture-tag vd-tag">Education · Flagship</span>
                            <h1>HASU Educational<br><span class="highlight">Consultancy</span></h1>
                        </div>
                    </div>
                    <p class="vd-hero-desc">Nepal's trusted study-abroad consultancy — guiding students to top universities
                        in Japan, Australia, UK, Canada, USA, and New Zealand since 2013.</p>
                    <div class="vd-hero-actions">
                        <a href="contact.html" class="btn btn-primary">Book Free Counseling</a>
                        <a href="tel:+97756493528" class="btn btn-outline vd-btn-outline">Call 056-493528</a>
                    </div>
                </div>
                <div class="vd-hero-visual">
                    <div class="vd-hero-banner">
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&q=80"
                            alt="Students on campus">
                    </div>
                    <span class="venture-status status-flagship vd-hero-status">Flagship Venture</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== INFO STRIP ===== -->
    <section class="vd-info-strip">
        <div class="container">
            <div class="vd-info-grid fade-up">
                <div class="vd-info-item">
                    <div class="vd-info-icon">📍</div>
                    <div>
                        <strong>Location</strong>
                        <span>Bhairahawa-11, Chitwan</span>
                    </div>
                </div>
                <div class="vd-info-item">
                    <div class="vd-info-icon">📅</div>
                    <div>
                        <strong>Established</strong>
                        <span>2013 · Registered 2015</span>
                    </div>
                </div>
                <div class="vd-info-item">
                    <div class="vd-info-icon">✉</div>
                    <div>
                        <strong>Email</strong>
                        <span>abc@gmail.com</span>
                    </div>
                </div>
                <div class="vd-info-item">
                    <div class="vd-info-icon">📍</div>
                    <div>
                        <strong>Contact</strong>
                        <span>980000000</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== OVERVIEW ===== -->
   <section class="cd-main section">
  <div class="container">
    <div class="cd-layout">

      <div class="cd-content fade-up">
        <h1 class="cd-title">Ventur Details </h1>
       

        <div class="cd-description">
          <p>Prepare for study and work in Japan with HASU's comprehensive Japanese language program. Our expert instructors guide you from beginner basics to exam-ready proficiency for NAT, JLPT (N5–N2), and J-TEST certifications.</p>
          <p>Whether you are planning to study at a Japanese university or language school, a strong Japanese foundation is essential. We combine structured classroom learning, conversation practice, mock tests, and personalized feedback to help you achieve your target level on schedule.</p>
          <p>Classes run in small batches at our Bhairahawa campus with flexible morning and evening timings. Enroll alongside your study-abroad counseling at HASU for a seamless path from language prep to visa approval.</p>
        </div>

        <div class="cd-highlights">
          <h3>What We Do</h3>
          <ul>
            <li>Hiragana, Katakana, and Kanji fundamentals</li>
            <li>JLPT N5 to N2 level grammar and vocabulary</li>
            <li>NAT and J-TEST exam strategies and mock papers</li>
            <li>Conversation skills for daily life and interviews in Japan</li>
            <li>Reading comprehension for academic and visa documents</li>
          </ul>
        </div>

      </div>

    </div>
  </div>
</section>

    <!-- ===== RELATED VENTURES ===== -->
    <section id="vd-related" class="section">
        <div class="container">
            <div class="section-head fade-up">
                <div class="section-label">Explore More</div>
                <h2 class="section-title">Other HASU Ventures</h2>
                <p class="section-sub">Discover how our family of ventures works together to support your complete journey.
                </p>
            </div>
            <div class="vd-related-grid">
                <a href="ventures.html" class="vd-related-card fade-up">
                    <div class="vd-related-icon" style="background:linear-gradient(135deg,#7b1fa2,#e91e63)">🗣️</div>
                    <h4>HASU Language Institute</h4>
                    <p>Japanese, IELTS &amp; PTE preparation</p>
                    <span class="vd-related-link">View Venture →</span>
                </a>
                <a href="ventures.html" class="vd-related-card fade-up" style="transition-delay:.1s">
                    <div class="vd-related-icon" style="background:linear-gradient(135deg,#1d4ed8,#60a5fa)">🇯🇵</div>
                    <h4>HASU Japan Desk</h4>
                    <p>Dedicated Japan admissions support</p>
                    <span class="vd-related-link">View Venture →</span>
                </a>
                <a href="ventures.html" class="vd-related-card fade-up" style="transition-delay:.2s">
                    <div class="vd-related-icon" style="background:linear-gradient(135deg,#0d9488,#14b8a6)">📋</div>
                    <h4>HASU Document Services</h4>
                    <p>Visa documents &amp; translation</p>
                    <span class="vd-related-link">View Venture →</span>
                </a>
            </div>
            <div class="vd-back-wrap fade-up">
                <a href="ventures.html" class="btn btn-secondary">← Back to All Ventures</a>
            </div>
        </div>
    </section>
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
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -40px 0px'
        });
        fadeEls.forEach(el => observer.observe(el));

        const statNums = document.querySelectorAll('#vd-stats .stat-num');
        const statObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const accent = el.querySelector('.accent');
                    const accentText = accent ? accent.textContent : '';
                    const rawText = el.textContent.replace(accentText, '').trim();
                    const target = parseInt(rawText.replace(/\D/g, ''), 10);
                    if (isNaN(target) || target <= 1) return;
                    let start = 0;
                    const duration = 1400;
                    const step = (timestamp) => {
                        if (!start) start = timestamp;
                        const progress = Math.min((timestamp - start) / duration, 1);
                        const eased = 1 - Math.pow(1 - progress, 3);
                        el.innerHTML = Math.floor(eased * target).toLocaleString() + (accent ?
                            '<span class="accent">' + accentText + '</span>' : '');
                        if (progress < 1) requestAnimationFrame(step);
                    };
                    requestAnimationFrame(step);
                    statObserver.unobserve(el);
                }
            });
        }, {
            threshold: 0.5
        });
        statNums.forEach(el => statObserver.observe(el));
    </script>
@endpush
