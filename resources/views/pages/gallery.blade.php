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
            display: block;
            width: 100%;
            border: 0;
            border-radius: 8px;
            overflow: hidden;
            aspect-ratio: 4/3;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            background: #fff;
            padding: 0;
            text-decoration: none;
            font: inherit;
            color: inherit;
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

        .gallery-media-badge {
            position: absolute;
            top: 14px;
            right: 14px;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 11px;
            border-radius: 999px;
            background: rgba(204, 34, 34, .94);
            color: #fff;
            font-size: .78rem;
            font-weight: 700;
        }

        .gallery-play {
            position: absolute;
            inset: 0;
            display: grid;
            place-items: center;
            pointer-events: none;
        }

        .gallery-play span {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: #fff;
            background: rgba(13, 21, 96, .82);
            box-shadow: 0 10px 30px rgba(0,0,0,.22);
            font-size: 1.25rem;
            transform: translateY(-4px);
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

        .gallery-viewer {
            position: fixed;
            inset: 0;
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: rgba(4, 8, 34, .88);
        }

        .gallery-viewer.is-open {
            display: flex;
        }

        .gallery-viewer img {
            max-width: min(1100px, 92vw);
            max-height: 82vh;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 24px 80px rgba(0,0,0,.4);
            background: #fff;
        }

        .gallery-viewer-caption {
            position: absolute;
            left: 24px;
            right: 24px;
            bottom: 22px;
            color: #fff;
            text-align: center;
            font-weight: 600;
        }

        .gallery-viewer-btn {
            position: absolute;
            border: 1px solid rgba(255,255,255,.26);
            background: rgba(255,255,255,.12);
            color: #fff;
            border-radius: 8px;
            cursor: pointer;
            font: inherit;
            font-weight: 800;
        }

        .gallery-viewer-close {
            top: 18px;
            right: 18px;
            width: 40px;
            height: 40px;
        }

        .gallery-viewer-prev,
        .gallery-viewer-next {
            top: 50%;
            width: 44px;
            height: 54px;
            transform: translateY(-50%);
        }

        .gallery-viewer-prev { left: 18px; }
        .gallery-viewer-next { right: 18px; }

        @media(max-width:640px) {
            .gallery-viewer-prev,
            .gallery-viewer-next {
                top: auto;
                bottom: 64px;
                transform: none;
            }
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
                    @if($image->is_image)
                        <button
                            type="button"
                            class="gallery-item gallery-image-item fade-up"
                            data-category="{{ $image->category }}"
                            data-full="{{ $image->image_url }}"
                            data-title="{{ $image->title }}"
                            @if($i > 0) style="transition-delay:{{ round(($i % 4) * 0.1, 2) }}s" @endif
                        >
                            <img src="{{ $image->image_url }}" alt="{{ $image->alt_text ?: $image->title }}">
                            <span class="gallery-media-badge">Photo</span>
                            <div class="gallery-overlay">
                                <h4>{{ $image->title }}</h4>
                            </div>
                        </button>
                    @else
                        <a
                            href="{{ $image->link_url }}"
                            target="_blank"
                            rel="noopener"
                            class="gallery-item fade-up"
                            data-category="{{ $image->category }}"
                            @if($i > 0) style="transition-delay:{{ round(($i % 4) * 0.1, 2) }}s" @endif
                        >
                            <img src="{{ $image->image_url }}" alt="{{ $image->alt_text ?: $image->title }}">
                            <span class="gallery-media-badge">{{ $image->media_label }}</span>
                            <div class="gallery-play"><span>&#9658;</span></div>
                            <div class="gallery-overlay">
                                <h4>{{ $image->title }}</h4>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
            <div class="gallery-viewer" id="galleryViewer" aria-hidden="true">
                <button type="button" class="gallery-viewer-btn gallery-viewer-close" id="galleryViewerClose" aria-label="Close image viewer">x</button>
                <button type="button" class="gallery-viewer-btn gallery-viewer-prev" id="galleryViewerPrev" aria-label="Previous image">&lsaquo;</button>
                <img src="" alt="" id="galleryViewerImage">
                <button type="button" class="gallery-viewer-btn gallery-viewer-next" id="galleryViewerNext" aria-label="Next image">&rsaquo;</button>
                <div class="gallery-viewer-caption" id="galleryViewerCaption"></div>
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
        const imageItems = Array.from(document.querySelectorAll('.gallery-image-item'));
        const viewer = document.getElementById('galleryViewer');
        const viewerImage = document.getElementById('galleryViewerImage');
        const viewerCaption = document.getElementById('galleryViewerCaption');
        const viewerClose = document.getElementById('galleryViewerClose');
        const viewerPrev = document.getElementById('galleryViewerPrev');
        const viewerNext = document.getElementById('galleryViewerNext');
        let activeImageIndex = 0;

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

        function visibleImageItems() {
            return imageItems.filter(item => item.style.display !== 'none');
        }

        function openViewer(item) {
            const items = visibleImageItems();
            activeImageIndex = Math.max(0, items.indexOf(item));
            renderViewer(items[activeImageIndex] || item);
            viewer.classList.add('is-open');
            viewer.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeViewer() {
            viewer.classList.remove('is-open');
            viewer.setAttribute('aria-hidden', 'true');
            viewerImage.src = '';
            document.body.style.overflow = '';
        }

        function renderViewer(item) {
            if (!item) return;
            viewerImage.src = item.dataset.full;
            viewerImage.alt = item.querySelector('img')?.alt || item.dataset.title || '';
            viewerCaption.textContent = item.dataset.title || '';
        }

        function moveViewer(direction) {
            const items = visibleImageItems();
            if (!items.length) return;
            activeImageIndex = (activeImageIndex + direction + items.length) % items.length;
            renderViewer(items[activeImageIndex]);
        }

        imageItems.forEach(item => {
            item.addEventListener('click', () => openViewer(item));
        });

        viewerClose?.addEventListener('click', closeViewer);
        viewerPrev?.addEventListener('click', () => moveViewer(-1));
        viewerNext?.addEventListener('click', () => moveViewer(1));
        viewer?.addEventListener('click', event => {
            if (event.target === viewer) closeViewer();
        });

        document.addEventListener('keydown', event => {
            if (!viewer?.classList.contains('is-open')) return;
            if (event.key === 'Escape') closeViewer();
            if (event.key === 'ArrowLeft') moveViewer(-1);
            if (event.key === 'ArrowRight') moveViewer(1);
        });
    </script>
@endpush
