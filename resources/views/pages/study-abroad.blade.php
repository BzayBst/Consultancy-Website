@extends('layouts.app', ['active' => 'study-abroad'])

@section('title', 'Study Abroad – ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description',
    'Learn about HASU Educational Consultancy — our story, mission, vision, team, and why
    thousands of Nepali students trust us.')

@section('content')

    {{-- ===== PAGE HERO ===== --}}
    <x-frontend.page-hero badge="Global Opportunities"
        title="Choose Your Dream" highlight="Destination"
        subtitle="Explore top study abroad destinations and unlock world-class education with our expert visa and admission guidance."
        :breadcrumbs="[['label' => 'Home', 'url' => route('home')], ['label' => 'Study Abroad']]" />


    <section id="courses-listing" style="padding-top: 60px;">
        <div class="container">
            <div class="courses-listing-head fade-up">
                <div>
                    <div class="section-label" style="margin-bottom:8px">Explore</div>
                    <h2 class="section-title" style="margin-bottom:0;text-align:left">Popular Countries</h2>
                </div>
            </div>

            <div class="courses-grid courses-page-grid" id="coursesGrid">

                <a href="{{ route('study-abroad-detail') }}" class="course-card course-card-link fade-up">
                    <div class="course-img">
                        <img src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?w=600&q=80"
                            alt="Study in Japan">
                        <div class="course-flag">🇯🇵 Japan</div>
                    </div>
                    <div class="course-body">
                        <span class="course-list-tag">Asia · High Tech & Culture</span>
                        <h4>Study in Japan</h4>
                        <p>Experience world-class technology, rich cultural heritage, and excellent post-study work
                            opportunities.</p>
                        <span class="course-card-cta">Explore Japan →</span>
                    </div>
                </a>

                <a href="#" class="course-card course-card-link fade-up" style="transition-delay:.06s">
                    <div class="course-img">
                        <img src="https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?w=600&q=80"
                            alt="Study in Australia">
                        <div class="course-flag">🇦🇺 Australia</div>
                    </div>
                    <div class="course-body">
                        <span class="course-list-tag">Oceania · Top Universities</span>
                        <h4>Study in Australia</h4>
                        <p>Renowned for its global academic excellence, diverse culture, and amazing quality of life for
                            international students.</p>
                        <span class="course-card-cta">Explore Australia →</span>
                    </div>
                </a>

                <a href="#" class="course-card course-card-link fade-up" style="transition-delay:.12s">
                    <div class="course-img">
                        <img src="https://images.unsplash.com/photo-1513635269975-5969336cdac0?w=600&q=80"
                            alt="Study in UK">
                        <div class="course-flag">🇬🇧 United Kingdom</div>
                    </div>
                    <div class="course-body">
                        <span class="course-list-tag">Europe · Heritage & Quality</span>
                        <h4>Study in the UK</h4>
                        <p>Home to some of the world's oldest and most prestigious universities with shorter, intensive
                            degree programs.</p>
                        <span class="course-card-cta">Explore UK →</span>
                    </div>
                </a>

                <a href="#" class="course-card course-card-link fade-up" style="transition-delay:.18s">
                    <div class="course-img">
                        <img src="https://images.unsplash.com/photo-1503614472-8c93d56e92ce?w=600&q=80"
                            alt="Study in Canada">
                        <div class="course-flag">🇨🇦 Canada</div>
                    </div>
                    <div class="course-body">
                        <span class="course-list-tag">North America · Welcoming</span>
                        <h4>Study in Canada</h4>
                        <p>High-quality education with affordable tuition fees, famously friendly locals, and clear paths to
                            permanent residency.</p>
                        <span class="course-card-cta">Explore Canada →</span>
                    </div>
                </a>

            </div>
        </div>
    </section>

    <section id="cta-banner" class="cta-courses" style="margin-top: 60px;">
        <div class="container">
            <div class="cta-inner">
                <div class="cta-text fade-up">
                    <h2>Confused About Where to Apply?</h2>
                    <p>Book a free counseling session. We will evaluate your profile and recommend the perfect country and
                        university for you.</p>
                    <div class="cta-actions">
                        <a href="contact.html" class="btn btn-cta-primary">Book Consultation</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Scroll and fade-up JS from your original file
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => navbar.classList.toggle('scrolled', window.scrollY > 20));

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
