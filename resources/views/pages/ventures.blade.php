{{-- resources/views/pages/ventures.blade.php --}}
@extends('layouts.app', ['active' => 'ventures'])

@section('title', 'Our Ventures – ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description', 'Explore the HASU family of ventures — education consultancy, language institute, events, and more.')

@section('content')

{{-- ===== PAGE HERO ===== --}}
<x-frontend.page-hero
    badge="One Family · Many Ventures · Endless Opportunities"
    title="Growing Together,"
    highlight="Building Futures"
    subtitle="Explore the HASU family of ventures — each dedicated to education, language, and opportunity for Nepali students and communities."
    :breadcrumbs="[['label'=>'Home','url'=>route('home')],['label'=>'Our Ventures']]"
/>

{{-- ===== INTRO ===== --}}
<section id="ventures-intro" class="section">
    <div class="container">
        <div class="ventures-page-intro fade-up">
            <div class="section-label">Our Business</div>
            <h2 class="section-title">A Family of Ventures Under One Roof</h2>
            <p class="section-sub">Beyond education consultancy, HASU operates a growing portfolio of companies united by one mission — empowering people to grow, learn, and succeed at home and abroad.</p>
        </div>
    </div>
</section>

{{-- ===== FEATURED VENTURE ===== --}}
@if($featured)
<section id="venture-featured">
    <div class="container">
        <div class="venture-featured-card fade-up">
            <div class="vf-banner" style="background:linear-gradient({{ $featured->banner_gradient ?? '135deg,#0d1560,#2952e3' }})">
                @if($featured->banner_image)
                    <img src="{{ $featured->banner_image_url }}" class="vf-banner-img" alt="{{ $featured->name }}">
                @endif
                <span class="venture-status status-{{ str_replace('_','-',$featured->status) }}">
                    {{ $featured->status_label }}
                </span>
                <div class="vf-banner-deco">{{ $featured->emoji }}</div>
            </div>
            <div class="vf-body">
                <div class="vf-logo">{{ $featured->emoji }}</div>
                <div class="vf-content">
                    @if($featured->tag_label)
                    <span class="venture-tag"
                          style="background:{{ $featured->tag_bg ?? '#e8edfd' }};color:{{ $featured->tag_color ?? '#2952e3' }}">
                        {{ $featured->tag_label }}
                    </span>
                    @endif
                    <h2>{{ $featured->name }}</h2>
                    @if($featured->tagline)
                    <p class="vf-tagline">{{ $featured->tagline }}</p>
                    @endif
                    @if($featured->description)
                    <p>{{ $featured->description }}</p>
                    @endif
                    @if($featured->highlights)
                    <ul class="vf-highlights">
                        @foreach($featured->highlights as $h)
                        <li>{{ $h }}</li>
                        @endforeach
                    </ul>
                    @endif
                    <div class="vf-actions">
                        @if($featured->primary_btn_label)
                        <a href="{{ $featured->primary_btn_url ?? route('ventures.show', $featured->slug) }}"
                           class="btn btn-primary">
                            {{ $featured->primary_btn_label }}
                        </a>
                        @else
                        <a href="{{ route('ventures.show', $featured->slug) }}" class="btn btn-primary">
                            View Full Details →
                        </a>
                        @endif
                        @if($featured->secondary_btn_label)
                        <a href="{{ $featured->secondary_btn_url ?? route('contact') }}"
                           class="btn btn-secondary">
                            {{ $featured->secondary_btn_label }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ===== VENTURE LISTING ===== --}}
@if($portfolio->isNotEmpty())
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
                <button class="vf-btn" data-filter="innovation">Innovation</button>
            </div>
        </div>

        <div class="ventures-grid ventures-page-grid" id="venturesGrid">
            @foreach($portfolio as $venture)
            <div class="venture-card fade-up" data-category="{{ $venture->category }}">
                <span class="venture-status status-{{ str_replace('_','-',$venture->status) }}">
                    {{ $venture->status_label }}
                </span>
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
                    <span class="venture-tag"
                          style="background:{{ $venture->tag_bg ?? '#e8edfd' }};color:{{ $venture->tag_color ?? '#2952e3' }}">
                        {{ $venture->tag_label }}
                    </span>
                    @endif
                    <h3>{{ $venture->name }}</h3>
                    @if($venture->description)
                    <p>{{ Str::limit($venture->description, 100) }}</p>
                    @endif
                    <div class="venture-meta">
                        @if($venture->location)<span>📍 {{ $venture->location }}</span>@endif
                        @if($venture->established)<span>📅 {{ $venture->established }}</span>@endif
                    </div>
                </div>
                <div class="venture-links">
                    <a href="{{ $venture->primary_btn_url ?? route('ventures.show', $venture->slug) }}"
                       class="venture-link primary">
                        {{ $venture->primary_btn_label ?? 'Learn More →' }}
                    </a>
                    @if($venture->secondary_btn_label)
                    <a href="{{ $venture->secondary_btn_url ?? route('contact') }}"
                       class="venture-link outline">
                        {{ $venture->secondary_btn_label }}
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== ECOSYSTEM ===== --}}
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

<x-frontend.cta-banner
    title="Ready to Begin Your Global Journey?"
    subtitle="Book a free counseling session today — let HASU guide you to the education you deserve."
    btn-label="Book Free Counseling"
    btn-link="{{ route('contact') }}"
    btn2-label="Our Services"
    btn2-link="{{ route('home') }}#services"
/>

@endsection

@push('scripts')
<script>
const navbar = document.getElementById('navbar');
if(navbar) window.addEventListener('scroll', () => navbar.classList.toggle('scrolled', window.scrollY > 20));

const hamburger = document.getElementById('hamburger');
const mobileNav = document.getElementById('mobileNav');
const closeNav  = document.getElementById('closeNav');
if(hamburger) hamburger.addEventListener('click', () => mobileNav.classList.add('open'));
if(closeNav)  closeNav.addEventListener('click',  () => mobileNav.classList.remove('open'));
if(mobileNav) mobileNav.querySelectorAll('a').forEach(a => a.addEventListener('click', () => mobileNav.classList.remove('open')));

const fadeEls = document.querySelectorAll('.fade-up');
new IntersectionObserver((entries) => {
    entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('visible'); } });
}, { threshold:0.1, rootMargin:'0px 0px -40px 0px' }).observe = function(el){ IntersectionObserver.prototype.observe.call(this,el); };
const obs = new IntersectionObserver((entries) => {
    entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('visible'); } });
}, { threshold:0.1, rootMargin:'0px 0px -40px 0px' });
fadeEls.forEach(el => obs.observe(el));

// Category filter
const filterBtns    = document.querySelectorAll('.vf-btn');
const ventureCards  = document.querySelectorAll('#venturesGrid .venture-card');
filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const filter = btn.dataset.filter;
        ventureCards.forEach(card => {
            const show = filter === 'all' || card.dataset.category === filter;
            card.style.display = show ? '' : 'none';
            if (show) {
                card.style.opacity = '0'; card.style.transform = 'translateY(16px)';
                requestAnimationFrame(() => {
                    card.style.transition = 'opacity .4s, transform .4s';
                    card.style.opacity = '1'; card.style.transform = '';
                });
            }
        });
    });
});
</script>
@endpush