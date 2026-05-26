@extends('layouts.app', ['active' => 'gallery'])

@section('title', 'Gallery - ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description', 'Explore photos from HASU classes, seminars, events, and student success moments.')

@push('head')
    <style>
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

        .gallery-empty {
            margin-top: 40px;
            padding: 48px 24px;
            border: 1px dashed rgba(13, 21, 96, .22);
            border-radius: 8px;
            text-align: center;
            color: var(--text);
            background: #fff;
        }

        .gallery-empty strong {
            display: block;
            color: var(--navy);
            font-size: 1.15rem;
            margin-bottom: 6px;
        }
    </style>
@endpush

@section('content')
    @php
        $galleryImages = collect($galleryImages ?? []);
        $galleryCategories = collect($galleryCategories ?? []);
    @endphp

    {{-- ===== PAGE HERO ===== --}}
    <x-frontend.page-hero
        badge="Memories & Moments"
        title="Gallery Section"
        highlight="Gallery"
        subtitle="Glimpses of our vibrant classes, study abroad seminars, and successful visa grant celebrations."
        :breadcrumbs="[['label' => 'Home', 'url' => route('home')], ['label' => 'Gallery']]"
    />

    <section class="gallery-section">
        <div class="container">
            <div class="courses-listing-head fade-up">
                <div>
                    <div class="section-label" style="margin-bottom:8px">Visual Journey</div>
                    <h2 class="section-title" style="margin-bottom:0;text-align:left">Life at HASU</h2>
                </div>

                @if($galleryCategories->isNotEmpty())
                <div class="course-filters" id="galleryFilters">
                    <button type="button" class="cf-filter-btn active" data-filter="all">All</button>
                    @foreach($galleryCategories as $category)
                        <button type="button" class="cf-filter-btn" data-filter="{{ $category }}">
                            {{ Str::headline($category) }}
                        </button>
                    @endforeach
                </div>
                @endif
            </div>

            @if($galleryImages->isNotEmpty())
            <div class="gallery-grid" id="galleryGrid">
                @foreach($galleryImages as $i => $image)
                <div
                    class="gallery-item fade-up"
                    data-category="{{ $image->category }}"
                    @if($i > 0) style="transition-delay:{{ round(($i % 4) * 0.1, 2) }}s" @endif
                >
                    <img src="{{ $image->image_url }}" alt="{{ $image->alt_text ?: $image->title }}">
                    <div class="gallery-overlay">
                        <h4>{{ $image->title }}</h4>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="gallery-empty fade-up">
                <strong>Gallery coming soon</strong>
                <span>Images added from the CMS will appear here automatically.</span>
            </div>
            @endif
        </div>
    </section>

    <section id="cta-banner" class="cta-courses">
        <div class="container">
            <div class="cta-inner">
                <div class="cta-text fade-up">
                    <h2>Ready to Be Part of Our Success Story?</h2>
                    <p>Enroll in our classes today or consult with our experts to start your study abroad journey.</p>
                    <div class="cta-actions">
                        <a href="{{ route('contact') }}" class="btn btn-cta-primary">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
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
