@extends('layouts.app', ['active' => 'gallery'])

@section('title', 'Gallery – ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description',
    'Learn about HASU Educational Consultancy — our story, mission, vision, team, and why
    thousands of Nepali students trust us.')

    @push('head')
        <style>
            /* Specific styles for Gallery */
            .gallery-section {
                padding: 80px 0;
            }

            .gallery-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 24px;
                margin-top: 40px;
            }

            .gallery-item {
                position: relative;
                border-radius: 8px;
                overflow: hidden;
                aspect-ratio: 4/3;
                cursor: pointer;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            }

            .gallery-item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.5s ease;
            }

            .gallery-overlay {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
                padding: 30px 20px 20px;
                color: #fff;
                opacity: 0;
                transform: translateY(20px);
                transition: all 0.4s ease;
            }

            .gallery-item:hover img {
                transform: scale(1.08);
            }

            .gallery-item:hover .gallery-overlay {
                opacity: 1;
                transform: translateY(0);
            }

            .gallery-overlay h4 {
                margin: 0;
                font-size: 1.1rem;
                font-family: 'DM Sans', sans-serif;
                font-weight: 500;
            }
        </style>
    @endpush

@section('content')

    {{-- ===== PAGE HERO ===== --}}
    <x-frontend.page-hero badge="Memories & Moments" title="Gallery Section" highlight="Gallery"
        subtitle="Glimpses of our vibrant classes, study abroad seminars, and successful visa grant celebrations."
        :breadcrumbs="[['label' => 'Home', 'url' => route('home')], ['label' => 'Gallery']]" />


    <section class="gallery-section">
        <div class="container">
            <div class="courses-listing-head fade-up">
                <div>
                    <div class="section-label" style="margin-bottom:8px">Visual Journey</div>
                    <h2 class="section-title" style="margin-bottom:0;text-align:left">Life at HASU</h2>
                </div>
                <div class="course-filters" id="galleryFilters">
                    <button type="button" class="cf-filter-btn active" data-filter="all">All</button>
                    <button type="button" class="cf-filter-btn" data-filter="classes">Classes</button>
                    <button type="button" class="cf-filter-btn" data-filter="events">Seminars</button>
                    <button type="button" class="cf-filter-btn" data-filter="success">Success Stories</button>
                </div>
            </div>

            <div class="gallery-grid" id="galleryGrid">

                <div class="gallery-item fade-up" data-category="classes">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=800&q=80"
                        alt="Japanese Language Class">
                    <div class="gallery-overlay">
                        <h4>Interactive Japanese Class</h4>
                    </div>
                </div>

                <div class="gallery-item fade-up" data-category="events" style="transition-delay:.1s">
                    <img src="https://images.unsplash.com/photo-1544531586-fde5298cdd40?w=800&q=80"
                        alt="Study Abroad Seminar">
                    <div class="gallery-overlay">
                        <h4>Study in Australia Seminar</h4>
                    </div>
                </div>

                <div class="gallery-item fade-up" data-category="success" style="transition-delay:.2s">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=800&q=80" alt="Visa Success">
                    <div class="gallery-overlay">
                        <h4>Recent Visa Approvals</h4>
                    </div>
                </div>

                <div class="gallery-item fade-up" data-category="classes" style="transition-delay:.3s">
                    <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&q=80"
                        alt="IELTS Mock Test">
                    <div class="gallery-overlay">
                        <h4>Weekly IELTS Mock Test</h4>
                    </div>
                </div>

                <div class="gallery-item fade-up" data-category="events" style="transition-delay:.1s">
                    <img src="https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?w=800&q=80"
                        alt="Pre-Departure Briefing">
                    <div class="gallery-overlay">
                        <h4>Pre-Departure Briefing</h4>
                    </div>
                </div>

                <div class="gallery-item fade-up" data-category="success" style="transition-delay:.2s">
                    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&q=80"
                        alt="Graduating Students">
                    <div class="gallery-overlay">
                        <h4>Alumni Success in Japan</h4>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="cta-banner" class="cta-courses">
        <div class="container">
            <div class="cta-inner">
                <div class="cta-text fade-up">
                    <h2>Ready to Be Part of Our Success Story?</h2>
                    <p>Enroll in our classes today or consult with our experts to start your study abroad journey.</p>
                    <div class="cta-actions">
                        <a href="contact.html" class="btn btn-cta-primary">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
@push('scripts')
    <script>
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => navbar.classList.toggle('scrolled', window.scrollY > 20));

        // Mobile Nav Logic
        const hamburger = document.getElementById('hamburger');
        const mobileNav = document.getElementById('mobileNav');
        const closeNav = document.getElementById('closeNav');
        hamburger.addEventListener('click', () => mobileNav.classList.add('open'));
        closeNav.addEventListener('click', () => mobileNav.classList.remove('open'));

        // Fade Animation
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

        // Gallery Filtering Logic
        const filterBtns = document.querySelectorAll('.cf-filter-btn');
        const galleryItems = document.querySelectorAll('#galleryGrid .gallery-item');
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const filter = btn.dataset.filter;
                galleryItems.forEach(item => {
                    const cat = item.dataset.category;
                    item.style.display = (filter === 'all' || cat === filter) ? '' : 'none';
                });
            });
        });
    </script>
@endpush
