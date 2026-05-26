{{-- resources/views/pages/venture-detail.blade.php --}}
@extends('layouts.app', ['active' => 'ventures'])

@section('title', $venture->name . ' – ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description', $venture->tagline ?? $venture->description ?? 'HASU venture details.')

@push('head')
<style>
/* ── Venture Detail Hero ── */
.vd-hero {
    background:linear-gradient(var(--vd-accent, #2952e3), var(--vd-accent-dark, #1a3ed4));
    padding:72px 0 80px;
    position:relative;
    overflow:hidden;
}
.vd-hero::before {
    content:'';position:absolute;inset:0;
    background-image:radial-gradient(rgba(255,255,255,.05) 1px,transparent 1px);
    background-size:28px 28px;pointer-events:none;
}
.vd-hero-wave { position:absolute;bottom:-2px;left:0;right:0;height:64px;background:#fff;clip-path:ellipse(55% 100% at 50% 100%); }
.ph-dot { position:absolute;border-radius:50%;border:1.5px solid rgba(255,255,255,.08); }
.ph-dot-1 { width:400px;height:400px;top:-140px;right:-80px; }
.ph-dot-2 { width:240px;height:240px;bottom:-60px;left:-60px; }
.ph-dot-3 { width:160px;height:160px;top:40px;left:30%; }

.vd-hero-inner { display:grid;grid-template-columns:1fr 420px;gap:48px;align-items:center;position:relative;z-index:2; }
.breadcrumb { display:flex;align-items:center;gap:8px;font-size:13px;color:rgba(255,255,255,.6);margin-bottom:20px;flex-wrap:wrap; }
.breadcrumb a { color:rgba(255,255,255,.6);text-decoration:none;transition:color .2s; }
.breadcrumb a:hover { color:#fff; }
.breadcrumb span { color:rgba(255,255,255,.3); }

.vd-hero-brand { display:flex;align-items:center;gap:16px;margin-bottom:16px; }
.vd-hero-logo  { font-size:52px;line-height:1;flex-shrink:0; }
.vd-tag        { display:inline-block;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;padding:4px 12px;border-radius:20px;background:rgba(255,255,255,.15);color:rgba(255,255,255,.9);margin-bottom:8px; }
.vd-hero-content h1 { font-family:'Playfair Display',serif;font-size:clamp(28px,4vw,46px);color:#fff;line-height:1.15;margin-bottom:0; }
.vd-hero-content h1 .highlight { color:#f4c842; }
.vd-hero-desc  { font-size:15px;color:rgba(255,255,255,.78);margin-bottom:28px;max-width:480px;line-height:1.65; }
.vd-hero-actions { display:flex;gap:14px;flex-wrap:wrap; }
.btn { display:inline-block;padding:12px 28px;border-radius:6px;font-size:14px;font-weight:700;text-decoration:none;transition:all .25s; }
.btn-primary  { background:#2952e3;color:#fff;border:2px solid #2952e3; }
.btn-primary:hover { background:#1a3ed4;border-color:#1a3ed4; }
.btn-outline, .vd-btn-outline { background:transparent;border:2px solid rgba(255,255,255,.5);color:#fff; }
.btn-outline:hover,.vd-btn-outline:hover { background:rgba(255,255,255,.12); }
.btn-secondary { background:#f0f4fd;color:#0d1560;border:1.5px solid #e2e8f0; }
.btn-secondary:hover { background:#e2e8f0; }

.vd-hero-visual { position:relative; }
.vd-hero-banner { border-radius:14px;overflow:hidden;box-shadow:0 20px 48px rgba(0,0,0,.3); }
.vd-hero-banner img { width:100%;height:280px;object-fit:cover;display:block; }
.vd-hero-banner-placeholder { width:100%;height:280px;display:flex;align-items:center;justify-content:center;font-size:80px;opacity:.25; }
.vd-hero-status { position:absolute;top:14px;left:14px; }

/* ── Info Strip ── */
.vd-info-strip { background:#fff;border-bottom:1px solid #e2e8f0; }
.vd-info-grid  { display:grid;grid-template-columns:repeat(4,1fr);gap:0; }
.vd-info-item  { display:flex;align-items:center;gap:14px;padding:22px 24px;border-right:1px solid #e2e8f0;transition:background .2s; }
.vd-info-item:last-child { border-right:none; }
.vd-info-item:hover { background:#f5f7fb; }
.vd-info-icon  { width:42px;height:42px;border-radius:10px;background:#f0f4fd;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0; }
.vd-info-item strong { display:block;font-size:13px;font-weight:700;color:#0d1560;margin-bottom:2px; }
.vd-info-item span   { font-size:12px;color:#555; }

/* ── Main Content ── */
.cd-main   { padding:72px 0 80px; }
.cd-layout { display:grid;grid-template-columns:1fr 320px;gap:48px;align-items:start; }
.cd-title  { font-family:'Playfair Display',serif;font-size:clamp(24px,3vw,36px);color:#0d1560;margin-bottom:24px;line-height:1.2; }
.cd-description { font-size:15px;color:#555;line-height:1.8;margin-bottom:32px; }
.cd-description p { margin-bottom:16px; }
.cd-description p:last-child { margin-bottom:0; }
.cd-highlights { margin-bottom:32px; }
.cd-highlights h3 { font-family:'Playfair Display',serif;font-size:20px;color:#0d1560;margin-bottom:16px; }
.cd-highlights ul { list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px; }
.cd-highlights li { display:flex;align-items:flex-start;gap:12px;font-size:14px;color:#555;line-height:1.5; }
.cd-highlights li::before { content:'✓';display:flex;align-items:center;justify-content:center;width:22px;height:22px;background:#0d1560;color:#fff;border-radius:50%;font-size:11px;font-weight:700;flex-shrink:0;margin-top:1px; }

/* ── Sidebar ── */
.cd-sidebar-card { background:#fff;border-radius:14px;padding:28px;box-shadow:0 4px 24px rgba(0,0,0,.09);border:1px solid #e2e8f0;position:sticky;top:88px; }
.cd-sidebar-flag { font-size:48px;text-align:center;margin-bottom:14px;line-height:1; }
.cd-sidebar-card h3 { font-family:'Playfair Display',serif;font-size:20px;color:#0d1560;margin-bottom:6px; }
.cd-sidebar-card > p { font-size:13px;color:#555;margin-bottom:20px;line-height:1.6; }
.cd-sidebar-info { list-style:none;padding:0;margin:0 0 22px;display:flex;flex-direction:column;gap:0; }
.cd-sidebar-info li { display:flex;justify-content:space-between;align-items:flex-start;padding:10px 0;border-bottom:1px solid #f0f4fd;font-size:13px;gap:12px; }
.cd-sidebar-info li:last-child { border-bottom:none; }
.cd-sidebar-info li span  { color:#555;flex-shrink:0; }
.cd-sidebar-info li strong { color:#0d1560;font-weight:600;text-align:right; }
.btn-block { display:block;width:100%;text-align:center;padding:13px;border-radius:6px;font-size:15px;font-weight:700;cursor:pointer;transition:all .25s;text-decoration:none;margin-bottom:10px; }
.btn-block:last-child { margin-bottom:0; }

/* Share */
.vd-share { margin-top:18px;padding-top:16px;border-top:1px solid #e2e8f0; }
.vd-share p { font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#94a3b8;margin-bottom:10px; }
.vd-share-links { display:flex;gap:8px; }
.vd-share-link { width:34px;height:34px;border-radius:8px;border:1.5px solid #e2e8f0;display:flex;align-items:center;justify-content:center;font-size:15px;text-decoration:none;transition:all .2s; }
.vd-share-link:hover { border-color:#2952e3;background:#e8edfd; }

/* ── Related ventures ── */
#vd-related { background:#f0f4fd;padding:72px 0; }
.vd-related-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:40px; }
.vd-related-card { background:#fff;border-radius:12px;padding:24px;box-shadow:0 2px 12px rgba(0,0,0,.07);border:1px solid #e2e8f0;text-decoration:none;display:block;transition:transform .25s,box-shadow .25s; }
.vd-related-card:hover { transform:translateY(-4px);box-shadow:0 8px 28px rgba(0,0,0,.12); }
.vd-related-icon { width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:24px;margin-bottom:14px; }
.vd-related-card h4 { font-family:'Playfair Display',serif;font-size:16px;color:#0d1560;font-weight:700;margin-bottom:6px; }
.vd-related-card p  { font-size:13px;color:#555;margin-bottom:12px;line-height:1.5; }
.vd-related-link    { font-size:13px;font-weight:600;color:#2952e3; }
.vd-back-wrap       { text-align:center;margin-top:36px; }

/* ── CTA ── */
.cta-ventures { background:linear-gradient(120deg,#0d1560 0%,#1a237e 45%,#283593 70%,#cc2222 130%);padding:64px 0; }
.cta-inner    { display:flex;align-items:center;justify-content:space-between;gap:32px;flex-wrap:wrap; }
.cta-text h2  { font-family:'Playfair Display',serif;font-size:clamp(22px,3vw,34px);color:#fff;margin-bottom:8px; }
.cta-text p   { font-size:15px;color:rgba(255,255,255,.75); }
.cta-actions  { display:flex;gap:14px;flex-wrap:wrap;margin-top:20px; }
.btn-cta-primary { background:#cc2222;color:#fff;border:2px solid #cc2222;border-radius:6px;padding:13px 30px;font-size:15px;font-weight:700;text-decoration:none;display:inline-block;transition:all .25s; }
.btn-cta-primary:hover { background:#a81a1a;border-color:#a81a1a; }
.btn-cta-ghost { background:transparent;border:2px solid rgba(255,255,255,.5);color:#fff;padding:12px 28px;border-radius:6px;font-weight:600;font-size:14px;text-decoration:none;display:inline-block;transition:all .25s; }
.btn-cta-ghost:hover { background:rgba(255,255,255,.12); }
.cta-contact-card { background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:12px;padding:20px 24px;backdrop-filter:blur(6px);display:flex;flex-direction:column;gap:8px; }
.cta-contact-label { font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.5); }
.cta-contact-card a { font-size:14px;color:rgba(255,255,255,.85);text-decoration:none;transition:color .2s; }
.cta-contact-card a:hover { color:#fff; }

/* Venture status badges */
.venture-status { display:inline-block;font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;padding:4px 12px;border-radius:4px; }
.status-flagship   { background:#2952e3;color:#fff; }
.status-active     { background:#166534;color:#fff; }
.status-new        { background:#f59e0b;color:#fff; }
.status-coming-soon { background:#64748b;color:#fff; }

/* Shared fade-up */
.fade-up { opacity:0;transform:translateY(28px);transition:opacity .65s,transform .65s; }
.fade-up.visible { opacity:1;transform:none; }

/* Section helpers */
.section-label { display:inline-flex;align-items:center;gap:10px;font-size:12px;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;color:#cc2222;margin-bottom:10px; }
.section-label::before,.section-label::after { content:'';display:block;width:32px;height:2px;background:#cc2222; }
.section-title { font-family:'Playfair Display',serif;font-size:clamp(22px,3vw,36px);color:#0d1560;line-height:1.22;margin-bottom:12px; }
.section-sub { font-size:15px;color:#555;max-width:600px;margin:0 auto; }
.section-head { text-align:center;margin-bottom:0; }

@media(max-width:960px){
    .vd-hero-inner { grid-template-columns:1fr; }
    .vd-hero-visual { display:none; }
    .vd-info-grid  { grid-template-columns:1fr 1fr; }
    .vd-info-item:nth-child(2) { border-right:none; }
    .vd-info-item:nth-child(3) { border-right:1px solid #e2e8f0; }
    .cd-layout     { grid-template-columns:1fr; }
    .cd-sidebar-card { position:static; }
    .vd-related-grid { grid-template-columns:1fr 1fr; }
}
@media(max-width:560px){
    .vd-info-grid  { grid-template-columns:1fr; }
    .vd-info-item  { border-right:none !important;border-bottom:1px solid #e2e8f0; }
    .vd-related-grid { grid-template-columns:1fr; }
    .cta-inner { flex-direction:column; }
}
</style>
@endpush

@section('content')

{{-- ===== HERO ===== --}}
<section id="vd-hero" class="vd-hero"
         style="--vd-accent:{{ $venture->accent_color ?? '#2952e3' }};--vd-accent-dark:{{ $venture->accent_color ?? '#1a3ed4' }}">
    <div class="ph-dot ph-dot-1"></div>
    <div class="ph-dot ph-dot-2"></div>
    <div class="ph-dot ph-dot-3"></div>
    <div class="vd-hero-wave"></div>
    <div class="container">
        <div class="vd-hero-inner fade-up">
            <div class="vd-hero-content">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}">Home</a><span>›</span>
                    <a href="{{ route('ventures') }}">Our Ventures</a><span>›</span>
                    <span style="color:rgba(255,255,255,.9)">{{ $venture->name }}</span>
                </div>
                <div class="vd-hero-brand">
                    <div class="vd-hero-logo">{{ $venture->emoji }}</div>
                    <div>
                        @if($venture->tag_label)
                        <span class="venture-tag vd-tag"
                              style="background:rgba(255,255,255,.15);color:rgba(255,255,255,.9)">
                            {{ $venture->tag_label }}
                        </span>
                        @endif
                        <h1>{{ $venture->name }}
                            @if($venture->tagline)
                            <br><span class="highlight" style="color:#f4c842;font-size:.75em">{{ $venture->tagline }}</span>
                            @endif
                        </h1>
                    </div>
                </div>
                @if($venture->description)
                <p class="vd-hero-desc">{{ $venture->description }}</p>
                @endif
                <div class="vd-hero-actions">
                    @if($venture->primary_btn_label)
                    <a href="{{ $venture->primary_btn_url ?? route('contact') }}" class="btn btn-primary">
                        {{ $venture->primary_btn_label }}
                    </a>
                    @else
                    <a href="{{ route('contact') }}" class="btn btn-primary">Book Free Counseling</a>
                    @endif
                    @if($venture->phone)
                    <a href="tel:{{ $venture->phone }}" class="btn btn-outline vd-btn-outline">
                        📞 {{ $venture->phone }}
                    </a>
                    @endif
                </div>
            </div>
            <div class="vd-hero-visual">
                <div class="vd-hero-banner" style="{{ $venture->banner_style }}">
                    @if($venture->banner_image)
                        <img src="{{ $venture->banner_image_url }}" alt="{{ $venture->name }}">
                    @else
                        <div class="vd-hero-banner-placeholder">{{ $venture->emoji }}</div>
                    @endif
                </div>
                <span class="venture-status status-{{ str_replace('_','-',$venture->status) }} vd-hero-status">
                    {{ $venture->status_label }}
                </span>
            </div>
        </div>
    </div>
</section>

{{-- ===== INFO STRIP ===== --}}
@if($venture->location || $venture->established || $venture->email || $venture->phone)
<section class="vd-info-strip">
    <div class="container">
        <div class="vd-info-grid fade-up">
            @if($venture->location)
            <div class="vd-info-item">
                <div class="vd-info-icon">📍</div>
                <div><strong>Location</strong><span>{{ $venture->location }}</span></div>
            </div>
            @endif
            @if($venture->established)
            <div class="vd-info-item">
                <div class="vd-info-icon">📅</div>
                <div><strong>Established</strong><span>{{ $venture->established }}</span></div>
            </div>
            @endif
            @if($venture->email)
            <div class="vd-info-item">
                <div class="vd-info-icon">✉</div>
                <div><strong>Email</strong><span>{{ $venture->email }}</span></div>
            </div>
            @endif
            @if($venture->phone)
            <div class="vd-info-item">
                <div class="vd-info-icon">📞</div>
                <div><strong>Contact</strong><span>{{ $venture->phone }}</span></div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- ===== MAIN CONTENT + SIDEBAR ===== --}}
<section class="cd-main">
    <div class="container">
        <div class="cd-layout">

            {{-- ── Left content ── --}}
            <div class="cd-content fade-up">
                <h1 class="cd-title">{{ $venture->name }}</h1>

                @if($venture->long_description)
                <div class="cd-description">
                    {!! nl2br(e($venture->long_description)) !!}
                </div>
                @elseif($venture->description)
                <div class="cd-description">
                    <p>{{ $venture->description }}</p>
                </div>
                @endif

                @if($venture->highlights && count($venture->highlights))
                <div class="cd-highlights">
                    <h3>{{ $venture->section_title ?? 'What We Do' }}</h3>
                    <ul>
                        @foreach($venture->highlights as $point)
                        <li>{{ $point }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

            {{-- ── Sidebar ── --}}
            <aside class="cd-sidebar fade-up" style="transition-delay:.1s">
                <div class="cd-sidebar-card">
                    <div class="cd-sidebar-flag">{{ $venture->emoji }}</div>
                    <h3>{{ $venture->name }}</h3>
                    @if($venture->tagline)
                    <p>{{ $venture->tagline }}</p>
                    @else
                    <p>Get in touch with our team to learn more about this venture.</p>
                    @endif

                    <ul class="cd-sidebar-info">
                        @if($venture->category)
                        <li><span>Category</span><strong>{{ ucfirst($venture->category) }}</strong></li>
                        @endif
                        @if($venture->status)
                        <li><span>Status</span><strong>{{ $venture->status_label }}</strong></li>
                        @endif
                        @if($venture->location)
                        <li><span>📍 Location</span><strong>{{ $venture->location }}</strong></li>
                        @endif
                        @if($venture->established)
                        <li><span>📅 Since</span><strong>{{ $venture->established }}</strong></li>
                        @endif
                        @if($venture->email)
                        <li><span>✉ Email</span><strong>{{ $venture->email }}</strong></li>
                        @endif
                        @if($venture->phone)
                        <li><span>📞 Phone</span><strong>{{ $venture->phone }}</strong></li>
                        @endif
                        @if($venture->website_url)
                        <li><span>🌐 Website</span>
                            <strong><a href="{{ $venture->website_url }}" target="_blank"
                                       style="color:#2952e3;text-decoration:none">Visit →</a></strong>
                        </li>
                        @endif
                    </ul>

                    @if($venture->primary_btn_label)
                    <a href="{{ $venture->primary_btn_url ?? route('contact') }}"
                       class="btn btn-primary btn-block">
                        {{ $venture->primary_btn_label }}
                    </a>
                    @else
                    <a href="{{ route('contact') }}" class="btn btn-primary btn-block">
                        Get in Touch
                    </a>
                    @endif

                    @if($venture->secondary_btn_label)
                    <a href="{{ $venture->secondary_btn_url ?? route('contact') }}"
                       class="btn btn-secondary btn-block">
                        {{ $venture->secondary_btn_label }}
                    </a>
                    @else
                    <a href="tel:{{ setting('general_phone', '+97756493528') }}"
                       class="btn btn-secondary btn-block">
                        📞 Call Us
                    </a>
                    @endif

                    <div class="vd-share">
                        <p>Share this venture</p>
                        <div class="vd-share-links">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                               target="_blank" class="vd-share-link" title="Share on Facebook">📘</a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($venture->name) }}"
                               target="_blank" class="vd-share-link" title="Share on Twitter">𝕏</a>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($venture->name . ' – ' . request()->url()) }}"
                               target="_blank" class="vd-share-link" title="Share on WhatsApp">💬</a>
                        </div>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</section>

{{-- ===== RELATED VENTURES ===== --}}
@if($otherVentures->isNotEmpty())
<section id="vd-related">
    <div class="container">
        <div class="section-head fade-up">
            <div class="section-label">Explore More</div>
            <h2 class="section-title">Other HASU Ventures</h2>
            <p class="section-sub">Discover how our family of ventures works together to support your complete journey.</p>
        </div>
        <div class="vd-related-grid">
            @foreach($otherVentures as $i => $other)
            <a href="{{ route('ventures.show', $other->slug) }}"
               class="vd-related-card fade-up"
               style="transition-delay:{{ $i * 0.1 }}s">
                <div class="vd-related-icon" style="{{ $other->banner_style }}">
                    {{ $other->emoji }}
                </div>
                <h4>{{ $other->name }}</h4>
                @if($other->description)
                <p>{{ Str::limit($other->description, 80) }}</p>
                @endif
                <span class="vd-related-link">View Venture →</span>
            </a>
            @endforeach
        </div>
        <div class="vd-back-wrap fade-up">
            <a href="{{ route('ventures') }}" class="btn btn-secondary">← Back to All Ventures</a>
        </div>
    </div>
</section>
@endif

{{-- ===== CTA ===== --}}
<section class="cta-ventures">
    <div class="container">
        <div class="cta-inner">
            <div class="cta-text fade-up">
                <h2>Ready to Begin Your Global Journey?</h2>
                <p>Book a free counseling session today — let HASU guide you to the education you deserve.</p>
                <div class="cta-actions">
                    <a href="{{ route('contact') }}" class="btn-cta-primary">Book Free Counseling</a>
                    <a href="{{ route('ventures') }}" class="btn-cta-ghost">All Ventures →</a>
                </div>
            </div>
            <div class="cta-contact-card fade-up" style="transition-delay:.15s">
                <span class="cta-contact-label">Get in touch</span>
                <a href="mailto:{{ setting('general_email', 'info@hasuedu.com') }}">
                    ✉ {{ setting('general_email', 'info@hasuedu.com') }}
                </a>
                <a href="tel:{{ setting('general_phone', '+97756493528') }}">
                    📞 {{ setting('general_phone', '056-493528') }}
                </a>
                <a href="tel:{{ setting('general_phone2', '+9779853646493') }}">
                    📞 {{ setting('general_phone2', '9853646493') }}
                </a>
            </div>
        </div>
    </div>
</section>

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

const obs = new IntersectionObserver((entries) => {
    entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('visible'); obs.unobserve(e.target); } });
}, { threshold:0.1, rootMargin:'0px 0px -40px 0px' });
document.querySelectorAll('.fade-up').forEach(el => obs.observe(el));
</script>
@endpush