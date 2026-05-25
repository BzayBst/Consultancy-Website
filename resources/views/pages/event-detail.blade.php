{{-- resources/views/pages/event-detail.blade.php --}}
@extends('layouts.app', ['active' => 'events'])

@section('title', $event->title . ' – ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description', $event->description ?? 'Event details at HASU Educational Consultancy.')

@push('head')
<style>
/* ===== EVENT DETAIL ===== */
.ed-main   { padding:72px 0 80px; }
.ed-layout { display:grid;grid-template-columns:1fr 340px;gap:48px;align-items:start; }

/* ── Content left ── */
.ed-content {}
.ed-status-row { display:flex;align-items:center;gap:12px;margin-bottom:16px;flex-wrap:wrap; }
.ed-badge { display:inline-block;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;padding:5px 14px;border-radius:4px; }
.ed-badge.upcoming { background:#cc2222;color:#fff; }
.ed-badge.ongoing  { background:#2952e3;color:#fff; }
.ed-badge.past     { background:#64748b;color:#fff; }
.ed-title { font-family:'Playfair Display',serif;font-size:clamp(26px,4vw,42px);color:#0d1560;line-height:1.2;margin-bottom:20px; }

.ed-meta { display:flex;flex-wrap:wrap;gap:10px 20px;margin-bottom:28px; }
.ed-meta-item { display:flex;align-items:center;gap:8px;font-size:14px;color:#555;background:#f0f4fd;padding:7px 14px;border-radius:6px; }
.ed-meta-item strong { color:#0d1560;font-weight:600; }

.ed-hero-img { width:100%;border-radius:12px;overflow:hidden;margin-bottom:32px;box-shadow:0 4px 24px rgba(0,0,0,.1); }
.ed-hero-img img { width:100%;height:420px;object-fit:cover;display:block; }
.ed-hero-img-placeholder { width:100%;height:320px;background:linear-gradient(135deg,#0d1560 0%,#1a237e 50%,#283593 100%);display:flex;align-items:center;justify-content:center;border-radius:12px; }
.ed-hero-img-placeholder span { font-size:64px;opacity:.3; }

.ed-description { font-size:15px;color:#555;line-height:1.8;margin-bottom:32px; }
.ed-description p { margin-bottom:16px; }
.ed-description p:last-child { margin-bottom:0; }

.ed-highlights { margin-bottom:32px; }
.ed-highlights h3 { font-family:'Playfair Display',serif;font-size:20px;color:#0d1560;margin-bottom:16px; }
.ed-highlights ul { list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px; }
.ed-highlights li { display:flex;align-items:flex-start;gap:12px;font-size:14px;color:#555;line-height:1.5; }
.ed-highlights li::before { content:'✓';display:flex;align-items:center;justify-content:center;width:22px;height:22px;background:#0d1560;color:#fff;border-radius:50%;font-size:11px;font-weight:700;flex-shrink:0;margin-top:1px; }

.ed-mobile-cta { display:none;margin-top:24px; }

/* ── Sidebar ── */
.ed-sidebar {}
.ed-sidebar-card {
    background:#fff;border-radius:14px;padding:28px;
    box-shadow:0 4px 24px rgba(0,0,0,.09);
    border:1px solid #e2e8f0;
    position:sticky;top:88px;
}
.ed-sidebar-date {
    background:linear-gradient(135deg,#0d1560 0%,#1a3ed4 100%);
    border-radius:10px;padding:18px 20px;text-align:center;
    margin-bottom:20px;
}
.ed-sb-day  { font-size:44px;font-weight:700;color:#fff;line-height:1;font-family:'Playfair Display',serif; }
.ed-sb-mon  { font-size:13px;font-weight:600;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.75);margin-top:2px; }
.ed-sb-year { font-size:12px;color:rgba(255,255,255,.5);margin-top:4px; }
.ed-sb-end  { font-size:12px;color:rgba(255,255,255,.6);margin-top:8px;padding-top:8px;border-top:1px solid rgba(255,255,255,.15); }

.ed-sidebar-card h3 { font-family:'Playfair Display',serif;font-size:20px;color:#0d1560;margin-bottom:6px; }
.ed-sidebar-card > p { font-size:13px;color:#555;margin-bottom:20px;line-height:1.6; }

.ed-sidebar-info { list-style:none;padding:0;margin:0 0 24px;display:flex;flex-direction:column;gap:0; }
.ed-sidebar-info li { display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #f0f4fd;font-size:13px; }
.ed-sidebar-info li:last-child { border-bottom:none; }
.ed-sidebar-info li span  { color:#555; }
.ed-sidebar-info li strong { color:#0d1560;font-weight:600;text-align:right;max-width:180px; }

.btn-block { display:block;width:100%;text-align:center;padding:13px;border-radius:6px;font-size:15px;font-weight:700;cursor:pointer;transition:all .25s;text-decoration:none; }
.btn-primary   { background:#2952e3;color:#fff; }
.btn-primary:hover { background:#1a3ed4; }
.btn-secondary { background:#f0f4fd;color:#0d1560;border:1.5px solid #e2e8f0; }
.btn-secondary:hover { background:#e2e8f0; }

.ed-share { margin-top:20px;padding-top:18px;border-top:1px solid #e2e8f0; }
.ed-share p { font-size:12px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;margin-bottom:10px; }
.ed-share-links { display:flex;gap:8px; }
.ed-share-link { display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:8px;border:1.5px solid #e2e8f0;font-size:16px;text-decoration:none;transition:all .2s;color:#555; }
.ed-share-link:hover { border-color:#2952e3;color:#2952e3;background:#e8edfd; }

/* ===== OTHER EVENTS ===== */
#ed-other { background:#f0f4fd;padding:72px 0; }
.ed-other-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-top:40px; }
.ed-other-card { background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.06);transition:transform .25s,box-shadow .25s;text-decoration:none;display:block; }
.ed-other-card:hover { transform:translateY(-4px);box-shadow:0 8px 28px rgba(0,0,0,.12); }
.ed-other-img { position:relative;height:160px;overflow:hidden;background:#1a1a2e; }
.ed-other-img img { width:100%;height:100%;object-fit:cover;transition:transform .4s; }
.ed-other-card:hover .ed-other-img img { transform:scale(1.05); }
.ed-other-img-placeholder { width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:36px;opacity:.25; }
.ed-other-date-badge { position:absolute;top:12px;left:12px;background:rgba(13,21,96,.9);backdrop-filter:blur(4px);color:#fff;border-radius:6px;padding:6px 10px;text-align:center;min-width:44px; }
.ed-odb-day { display:block;font-size:18px;font-weight:700;line-height:1; }
.ed-odb-mon { display:block;font-size:9px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;opacity:.8; }
.ed-other-body { padding:18px 20px; }
.ed-other-status { display:inline-block;font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;padding:3px 10px;border-radius:20px;margin-bottom:8px; }
.ed-other-status.upcoming { background:#e0f2fe;color:#0369a1; }
.ed-other-status.ongoing  { background:#dcfce7;color:#166534; }
.ed-other-status.past     { background:#f1f5f9;color:#64748b; }
.ed-other-body h4 { font-family:'Playfair Display',serif;font-size:16px;color:#0d1560;font-weight:600;margin-bottom:6px;line-height:1.3; }
.ed-other-body p  { font-size:13px;color:#555;line-height:1.5;margin-bottom:12px; }
.ed-other-meta    { display:flex;gap:12px;flex-wrap:wrap; }
.ed-other-meta span { font-size:11px;color:#94a3b8; }
.ed-other-cta  { font-size:13px;font-weight:600;color:#2952e3;margin-top:10px;display:block; }

/* ===== CTA ===== */
.cta-events { background:linear-gradient(120deg,#0d1560 0%,#1a237e 45%,#283593 70%,#cc2222 130%);padding:64px 0; }
.cta-inner  { display:flex;align-items:center;justify-content:space-between;gap:32px;flex-wrap:wrap; }
.cta-text h2 { font-family:'Playfair Display',serif;font-size:clamp(22px,3vw,34px);color:#fff;margin-bottom:8px; }
.cta-text p  { font-size:15px;color:rgba(255,255,255,.75); }
.cta-actions { display:flex;gap:14px;flex-wrap:wrap;margin-top:20px; }
.btn-cta-primary { background:#cc2222;color:#fff;border:2px solid #cc2222;border-radius:6px;padding:13px 30px;font-size:15px;font-weight:700;cursor:pointer;transition:all .25s;text-decoration:none;display:inline-block; }
.btn-cta-primary:hover { background:#a81a1a;border-color:#a81a1a; }
.btn-cta-ghost { background:transparent;border:2px solid rgba(255,255,255,.55);color:#fff;padding:12px 28px;border-radius:6px;font-weight:600;font-size:14px;text-decoration:none;display:inline-block;transition:all .25s; }
.btn-cta-ghost:hover { background:rgba(255,255,255,.12); }
.cta-contact-card { background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:12px;padding:20px 24px;backdrop-filter:blur(6px);display:flex;flex-direction:column;gap:8px; }
.cta-contact-label { font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.5); }
.cta-contact-card a { font-size:14px;color:rgba(255,255,255,.85);text-decoration:none;transition:color .2s; }
.cta-contact-card a:hover { color:#fff; }

/* fade-up shared */
.fade-up { opacity:0;transform:translateY(28px);transition:opacity .65s,transform .65s; }
.fade-up.visible { opacity:1;transform:none; }

@media(max-width:960px){
    .ed-layout { grid-template-columns:1fr; }
    .ed-sidebar-card { position:static; }
    .ed-mobile-cta { display:block; }
    .ed-sidebar .ed-apply-btns { display:none; }
    .ed-other-grid { grid-template-columns:1fr 1fr; }
}
@media(max-width:600px){
    .ed-other-grid { grid-template-columns:1fr; }
    .ed-hero-img img { height:240px; }
    .cta-inner { flex-direction:column; }
}
</style>
@endpush

@section('content')

{{-- ===== PAGE HERO ===== --}}
<x-frontend.page-hero
    badge="📅 {{ ucfirst($event->status) }}"
    title="{{ $event->title }}"
    highlight="{{ $event->title }}"
    subtitle="{{ $event->description }}"
    :breadcrumbs="[
        ['label' => 'Home',   'url' => route('home')],
        ['label' => 'Events', 'url' => route('events')],
        ['label' => $event->title],
    ]" />

{{-- ===== EVENT MAIN ===== --}}
<section class="ed-main">
    <div class="container">
        <div class="ed-layout">

            {{-- ── LEFT CONTENT ── --}}
            <div class="ed-content fade-up">

                {{-- Status + meta row --}}
                <div class="ed-status-row">
                    <span class="ed-badge {{ $event->status }}">{{ strtoupper($event->status) }}</span>
                </div>

                <h1 class="ed-title">{{ $event->title }}</h1>

                {{-- Meta chips --}}
                <div class="ed-meta">
                    @if($event->event_date)
                    <div class="ed-meta-item">
                        📅 <strong>
                            {{ $event->event_date->format('d M Y') }}
                            @if($event->event_end_date && $event->event_end_date->ne($event->event_date))
                                – {{ $event->event_end_date->format('d M Y') }}
                            @endif
                        </strong>
                    </div>
                    @endif
                    @if($event->event_time)
                    <div class="ed-meta-item">⏰ <strong>{{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}</strong></div>
                    @endif
                    @if($event->location)
                    <div class="ed-meta-item">📍 <strong>{{ $event->location }}</strong></div>
                    @endif
                    @if($event->organizer)
                    <div class="ed-meta-item">ℹ️ <strong>{{ $event->organizer }}</strong></div>
                    @endif
                </div>

                {{-- Hero image --}}
                @if($event->image)
                <div class="ed-hero-img">
                    <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}">
                </div>
                @else
                <div class="ed-hero-img-placeholder fade-up">
                    <span>📅</span>
                </div>
                @endif

                {{-- Long description --}}
                @if($event->long_description)
                <div class="ed-description">
                    {!! nl2br(e($event->long_description)) !!}
                </div>
                @elseif($event->description)
                <div class="ed-description">
                    <p>{{ $event->description }}</p>
                </div>
                @endif

                {{-- Highlights list --}}
                @if($event->highlights && count($event->highlights))
                <div class="ed-highlights fade-up">
                    <h3>What to Expect</h3>
                    <ul>
                        @foreach($event->highlights as $point)
                        <li>{{ $point }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Mobile CTA --}}
                <div class="ed-mobile-cta">
                    @if($event->learn_more_url)
                        <a href="{{ $event->learn_more_url }}" target="_blank" class="btn btn-primary btn-block">Register Now</a>
                    @else
                        <a href="{{ route('contact') }}" class="btn btn-primary btn-block">Contact Us to Register</a>
                    @endif
                </div>

            </div>

            {{-- ── SIDEBAR ── --}}
            <aside class="ed-sidebar fade-up" style="transition-delay:.1s">
                <div class="ed-sidebar-card">

                    {{-- Date box --}}
                    @if($event->event_date)
                    <div class="ed-sidebar-date">
                        <div class="ed-sb-day">{{ $event->event_date->format('d') }}</div>
                        <div class="ed-sb-mon">{{ $event->event_date->format('M') }}</div>
                        <div class="ed-sb-year">{{ $event->event_date->format('Y') }}</div>
                        @if($event->event_end_date && $event->event_end_date->ne($event->event_date))
                        <div class="ed-sb-end">Until {{ $event->event_end_date->format('d M Y') }}</div>
                        @endif
                    </div>
                    @endif

                    <h3>Event Details</h3>
                    <p>Join us for this {{ $event->status === 'past' ? 'past' : 'upcoming' }} event. {{ $event->status !== 'past' ? 'Reserve your spot today.' : '' }}</p>

                    <ul class="ed-sidebar-info">
                        @if($event->event_date)
                        <li>
                            <span>📅 Date</span>
                            <strong>{{ $event->event_date->format('d M Y') }}</strong>
                        </li>
                        @endif
                        @if($event->event_time)
                        <li>
                            <span>⏰ Time</span>
                            <strong>{{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}</strong>
                        </li>
                        @endif
                        @if($event->location)
                        <li>
                            <span>📍 Location</span>
                            <strong>{{ $event->location }}</strong>
                        </li>
                        @endif
                        @if($event->organizer)
                        <li>
                            <span>ℹ️ Organizer</span>
                            <strong>{{ $event->organizer }}</strong>
                        </li>
                        @endif
                        <li>
                            <span>🎫 Status</span>
                            <strong>{{ ucfirst($event->status) }}</strong>
                        </li>
                    </ul>

                    @if($event->status !== 'past')
                    <div class="ed-apply-btns">
                        @if($event->learn_more_url)
                            <a href="{{ $event->learn_more_url }}" target="_blank" class="btn btn-primary btn-block ed-apply-btn">
                                Register Now
                            </a>
                        @else
                            <a href="{{ route('contact') }}" class="btn btn-primary btn-block ed-apply-btn">
                                Contact to Register
                            </a>
                        @endif
                        <a href="tel:+97756493528" class="btn btn-secondary btn-block" style="margin-top:10px">
                            📞 Call 056-493528
                        </a>
                    </div>
                    @endif

                    {{-- Share --}}
                    <div class="ed-share">
                        <p>Share this event</p>
                        <div class="ed-share-links">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                               target="_blank" class="ed-share-link" title="Share on Facebook">📘</a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($event->title) }}"
                               target="_blank" class="ed-share-link" title="Share on Twitter">𝕏</a>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($event->title . ' – ' . request()->url()) }}"
                               target="_blank" class="ed-share-link" title="Share on WhatsApp">💬</a>
                        </div>
                    </div>

                </div>
            </aside>

        </div>
    </div>
</section>

{{-- ===== OTHER UPCOMING EVENTS ===== --}}
@if($otherEvents->count())
<section id="ed-other">
    <div class="container">
        <div class="section-head fade-up" style="text-align:center;margin-bottom:0">
            <div class="section-label">More Events</div>
            <h2 class="section-title">Other Upcoming Events</h2>
            <p class="section-sub">Don't miss these other events from HASU Educational Consultancy.</p>
        </div>
        <div class="ed-other-grid">
            @foreach($otherEvents as $other)
            <a href="{{ route('events.show', $other->id) }}" class="ed-other-card fade-up">
                <div class="ed-other-img">
                    @if($other->image)
                        <img src="{{ asset('storage/'.$other->image) }}" alt="{{ $other->title }}">
                    @else
                        <div class="ed-other-img-placeholder">📅</div>
                    @endif
                    <div class="ed-other-date-badge">
                        <span class="ed-odb-day">{{ $other->event_date->format('d') }}</span>
                        <span class="ed-odb-mon">{{ $other->event_date->format('M') }}</span>
                    </div>
                </div>
                <div class="ed-other-body">
                    <span class="ed-other-status {{ $other->status }}">{{ ucfirst($other->status) }}</span>
                    <h4>{{ $other->title }}</h4>
                    <p>{{ Str::limit($other->description, 80) }}</p>
                    <div class="ed-other-meta">
                        @if($other->location)<span>📍 {{ $other->location }}</span>@endif
                        @if($other->organizer)<span>ℹ️ {{ $other->organizer }}</span>@endif
                    </div>
                    <span class="ed-other-cta">Learn More →</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== CTA ===== --}}
<section class="cta-events">
    <div class="container">
        <div class="cta-inner">
            <div class="cta-text fade-up">
                <h2>Want to Know About Future Events?</h2>
                <p>Stay connected with HASU — follow us or contact our team to get notified about upcoming seminars, fairs, and workshops.</p>
                <div class="cta-actions">
                    <a href="{{ route('contact') }}" class="btn-cta-primary">Contact Us</a>
                    <a href="{{ route('events') }}" class="btn-cta-ghost">All Events →</a>
                </div>
            </div>
            <div class="cta-contact-card fade-up" style="transition-delay:.15s">
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
if(navbar) window.addEventListener('scroll', () => navbar.classList.toggle('scrolled', window.scrollY > 20));

const hamburger = document.getElementById('hamburger');
const mobileNav = document.getElementById('mobileNav');
const closeNav  = document.getElementById('closeNav');
if(hamburger) hamburger.addEventListener('click', () => mobileNav.classList.add('open'));
if(closeNav)  closeNav.addEventListener('click',  () => mobileNav.classList.remove('open'));
if(mobileNav) mobileNav.querySelectorAll('a').forEach(a => a.addEventListener('click', () => mobileNav.classList.remove('open')));

const fadeEls = document.querySelectorAll('.fade-up');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('visible'); observer.unobserve(e.target); } });
}, { threshold:0.1, rootMargin:'0px 0px -40px 0px' });
fadeEls.forEach(el => observer.observe(el));
</script>
@endpush