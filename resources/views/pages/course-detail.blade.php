@extends('layouts.app', ['active' => 'courses'])

@section('title', 'Courses – ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description',
    'Explore the courses offered by HASU Educational Consultancy — tailored for Nepali students
    seeking global education opportunities.')

@section('content')
 {{-- ===== PAGE HERO ===== --}}
    <x-frontend.page-hero badge="🇯🇵 Japanese Language" title="Japanese Language Course" highlight="Courses"
        subtitle="Internationally recognized language training and exam preparation — taught by certified experts at our institute."
        :breadcrumbs="[['label' => 'Home', 'url' => route('home')], ['label' => 'All Courses']]" />

<!-- ===== COURSE MAIN ===== -->
<section class="cd-main section">
  <div class="container">
    <div class="cd-layout">

      <div class="cd-content fade-up">
        <h1 class="cd-title">Japanese Language Course</h1>
        <div class="cd-meta">
          <span>📚 NAT · JLPT · J-TEST</span>
          <span>⏱ 6–12 Months</span>
          <span>🏫 HASU Language Institute</span>
        </div>

        <div class="cd-description">
          <p>Prepare for study and work in Japan with HASU's comprehensive Japanese language program. Our expert instructors guide you from beginner basics to exam-ready proficiency for NAT, JLPT (N5–N2), and J-TEST certifications.</p>
          <p>Whether you are planning to study at a Japanese university or language school, a strong Japanese foundation is essential. We combine structured classroom learning, conversation practice, mock tests, and personalized feedback to help you achieve your target level on schedule.</p>
          <p>Classes run in small batches at our Bhairahawa campus with flexible morning and evening timings. Enroll alongside your study-abroad counseling at HASU for a seamless path from language prep to visa approval.</p>
        </div>

        <div class="cd-highlights">
          <h3>What You Will Learn</h3>
          <ul>
            <li>Hiragana, Katakana, and Kanji fundamentals</li>
            <li>JLPT N5 to N2 level grammar and vocabulary</li>
            <li>NAT and J-TEST exam strategies and mock papers</li>
            <li>Conversation skills for daily life and interviews in Japan</li>
            <li>Reading comprehension for academic and visa documents</li>
          </ul>
        </div>

        <div class="cd-mobile-apply">
          <a href="contact.html" class="btn btn-primary btn-block">Apply Now</a>
        </div>
      </div>

      <aside class="cd-sidebar fade-up" style="transition-delay:.1s">
        <div class="cd-sidebar-card">
          <div class="cd-sidebar-flag">🇯🇵</div>
          <h3>Enroll Today</h3>
          <p>Limited seats per batch. Book your placement test and start your Japan journey.</p>
          <ul class="cd-sidebar-info">
            <li><span>Duration</span><strong>6–12 Months</strong></li>
            <li><span>Level</span><strong>Beginner to Advanced</strong></li>
            <li><span>Exams</span><strong>NAT, JLPT, J-TEST</strong></li>
            <li><span>Location</span><strong>Bhairahawa</strong></li>
          </ul>
          <a href="contact.html" class="btn btn-primary btn-block cd-apply-btn">Apply Now</a>
          <a href="tel:+97756493528" class="btn btn-secondary btn-block" style="margin-top:10px">Call 056-493528</a>
        </div>
      </aside>

    </div>
  </div>
</section>

<!-- ===== OTHER POPULAR COURSES ===== -->
<section id="cd-popular" class="section">
  <div class="container">
    <div class="section-head fade-up">
      <div class="section-label">More Courses</div>
      <h2 class="section-title">Other Popular Courses</h2>
      <p class="section-sub">Explore our other language and test-prep programs at HASU Language Institute.</p>
    </div>
    <div class="courses-grid cd-popular-grid">
      <a href="course-detail-ielts.html" class="course-card course-card-link fade-up">
        <div class="course-img">
          <img src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=600&q=80" alt="IELTS Preparation">
          <div class="course-flag">🇬🇧 IELTS</div>
        </div>
        <div class="course-body">
          <h4>IELTS Preparation</h4>
          <p>Expert coaching for IELTS with IDP-certified trainers and mock test sessions.</p>
          <span class="course-card-cta">View Course →</span>
        </div>
      </a>
      <a href="course-detail-pte.html" class="course-card course-card-link fade-up" style="transition-delay:.1s">
        <div class="course-img">
          <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&q=80" alt="PTE Academic">
          <div class="course-flag">🇦🇺 PTE</div>
        </div>
        <div class="course-body">
          <h4>PTE Academic</h4>
          <p>Pearson Test of English preparation with proven strategies and practice materials.</p>
          <span class="course-card-cta">View Course →</span>
        </div>
      </a>
      <a href="courses.html" class="course-card course-card-link fade-up" style="transition-delay:.2s">
        <div class="course-img">
          <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b6175?w=600&q=80" alt="All courses">
          <div class="course-flag">📚 All</div>
        </div>
        <div class="course-body">
          <h4>View All Courses</h4>
          <p>Browse the full list of language and test-prep programs at HASU.</p>
          <span class="course-card-cta">Browse All →</span>
        </div>
      </a>
    </div>
  </div>
</section>

    <!-- ===== CTA ===== -->
    <section id="cta-banner" class="cta-courses">
        <div class="container">
            <div class="cta-inner">
                <div class="cta-text fade-up">
                    <h2>Not Sure Which Course Is Right for You?</h2>
                    <p>Visit our campus or book a free assessment — we'll recommend the best program for your goals.</p>
                    <div class="cta-actions">
                        <a href="contact.html" class="btn btn-cta-primary">Apply Now</a>
                        <a href="tel:+97756493528" class="btn btn-cta-ghost">Call Us Today</a>
                    </div>
                </div>
                <div class="cta-contact cta-contact-card fade-up" style="transition-delay:.15s">
                    <span class="cta-contact-label">Get in touch</span>
                    <a href="mailto:info@hasuedu.com">✉ info@hasuedu.com</a>
                    <a href="tel:+97756493528">📞 056-493528</a>
                    <a href="tel:+9779853646493">📞 9853646493</a>
                </div>
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

        document.querySelectorAll('.nav-dropdown').forEach(dropdown => {
            const toggle = dropdown.querySelector('.nav-dropdown-toggle');
            toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                const open = dropdown.classList.toggle('open');
                toggle.setAttribute('aria-expanded', open);
            });
        });
        document.addEventListener('click', () => {
            document.querySelectorAll('.nav-dropdown.open').forEach(d => {
                d.classList.remove('open');
                d.querySelector('.nav-dropdown-toggle')?.setAttribute('aria-expanded', 'false');
            });
        });

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
    </script>
@endpush
