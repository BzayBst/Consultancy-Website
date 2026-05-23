@extends('layouts.app', ['active' => 'blog'])

@section('title', 'Blog – ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description',
    'Learn about HASU Educational Consultancy — our story, mission, vision, team, and why
    thousands of Nepali students trust us.')

    @push('head')
        <style>
            /* Blog Specific Styles */
            .blog-section {
                padding: 80px 0;
            }

            .blog-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
                gap: 30px;
                margin-top: 40px;
            }

            .blog-card {
                background: #fff;
                border-radius: 8px;
                border: 1px solid #eaeaea;
                overflow: hidden;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                text-decoration: none;
                color: inherit;
                display: flex;
                flex-direction: column;
            }

            .blog-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            }

            .blog-img {
                width: 100%;
                aspect-ratio: 16/10;
                overflow: hidden;
            }

            .blog-img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.5s ease;
            }

            .blog-card:hover .blog-img img {
                transform: scale(1.05);
            }

            .blog-content {
                padding: 24px;
                display: flex;
                flex-direction: column;
                flex-grow: 1;
            }

            .blog-meta {
                font-size: 13px;
                color: #777;
                margin-bottom: 12px;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .blog-title {
                font-family: 'Playfair Display', serif;
                font-size: 1.25rem;
                margin: 0 0 12px 0;
                color: #1a1a1a;
                line-height: 1.3;
            }

            .blog-excerpt {
                font-size: 14px;
                color: #555;
                line-height: 1.6;
                margin-bottom: 20px;
            }

            .blog-read-more {
                margin-top: auto;
                font-weight: 600;
                color: var(--blue);
                font-size: 14px;
            }

            .blog-card:hover .blog-read-more {
                color: var(--blue-dark);
            }
        </style>
    @endpush

@section('content')

    {{-- ===== PAGE HERO ===== --}}
    <x-frontend.page-hero badge="News & Insights" title="Blog Section" highlight="Blog"
        subtitle="Stay updated with the best study abroad tips, scholarship guides, and updates from HASU Educational Consultancy."
        :breadcrumbs="[['label' => 'Home', 'url' => route('home')], ['label' => 'Blogs']]" />

    <section class="blog-section">
        <div class="container">

            <div class="courses-listing-head fade-up">
                <div>
                    <div class="section-label" style="margin-bottom:8px">Latest Articles</div>
                    <h2 class="section-title" style="margin-bottom:0;text-align:left">Read Our Insights</h2>
                </div>
            </div>

            <div class="blog-grid">

                <a href="#" class="blog-card fade-up">
                    <div class="blog-img">
                        <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=600&q=80"
                            alt="University Campus">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span class="course-list-tag" style="padding: 2px 8px;">Study Guide</span>
                            <span>📅 Oct 15, 2025</span>
                        </div>
                        <h3 class="blog-title">Top 5 Reasons to Choose Japan for Your Higher Education</h3>
                        <p class="blog-excerpt">Japan offers a unique blend of world-class technology, rich cultural
                            heritage, and increasing opportunities for international students...</p>
                        <span class="blog-read-more">Read Full Article →</span>
                    </div>
                </a>

                <a href="#" class="blog-card fade-up" style="transition-delay: .1s">
                    <div class="blog-img">
                        <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=600&q=80" alt="IELTS Prep">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span class="course-list-tag"
                                style="background:var(--blue-light);color:var(--blue);padding: 2px 8px;">Test Prep</span>
                            <span>📅 Oct 02, 2025</span>
                        </div>
                        <h3 class="blog-title">How to Score a Band 7.5+ in the IELTS Speaking Test</h3>
                        <p class="blog-excerpt">Struggling with the speaking module? Our IDP-certified trainers share their
                            top strategies for boosting your confidence and pronunciation...</p>
                        <span class="blog-read-more">Read Full Article →</span>
                    </div>
                </a>

                <a href="#" class="blog-card fade-up" style="transition-delay: .2s">
                    <div class="blog-img">
                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=600&q=80" alt="Graduation">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span class="course-list-tag"
                                style="background:#e8f5e9;color:#2e7d32;padding: 2px 8px;">Scholarships</span>
                            <span>📅 Sep 20, 2025</span>
                        </div>
                        <h3 class="blog-title">A Complete Guide to Fully Funded Scholarships in 2026</h3>
                        <p class="blog-excerpt">Financial constraints shouldn't stop you from dreaming big. Here is our
                            curated list of government and university scholarships you can apply for...</p>
                        <span class="blog-read-more">Read Full Article →</span>
                    </div>
                </a>

                <a href="#" class="blog-card fade-up">
                    <div class="blog-img">
                        <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=600&q=80"
                            alt="Student Interview">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span class="course-list-tag" style="padding: 2px 8px;">Visas</span>
                            <span>📅 Sep 12, 2025</span>
                        </div>
                        <h3 class="blog-title">Ace Your Student Visa Interview: Common Questions</h3>
                        <p class="blog-excerpt">Preparation is key when facing a visa officer. We break down the most
                            frequently asked questions and how to answer them effectively...</p>
                        <span class="blog-read-more">Read Full Article →</span>
                    </div>
                </a>

            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        // Navbar & Mobile Menu JS
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => navbar.classList.toggle('scrolled', window.scrollY > 20));

        const hamburger = document.getElementById('hamburger');
        const mobileNav = document.getElementById('mobileNav');
        const closeNav = document.getElementById('closeNav');
        hamburger.addEventListener('click', () => mobileNav.classList.add('open'));
        closeNav.addEventListener('click', () => mobileNav.classList.remove('open'));

        // Fade Animation JS
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
