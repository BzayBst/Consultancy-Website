<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- SEO --}}
<title>@yield('title', setting('seo_meta_title', config('app.name')))</title>
<meta name="description" content="@yield('meta_description', setting('seo_meta_description', ''))">
<meta name="keywords" content="@yield('meta_keywords', setting('seo_meta_keywords', ''))">

{{-- Open Graph --}}
<meta property="og:title" content="@yield('title', setting('seo_meta_title', config('app.name')))">
<meta property="og:description" content="@yield('meta_description', setting('seo_meta_description', ''))">
@if(setting('seo_og_image'))
<meta property="og:image" content="{{ Storage::url(setting('seo_og_image')) }}">
@endif
<meta property="og:type" content="website">

{{-- Favicon --}}
@if(setting('general_favicon'))
<link rel="icon" href="{{ Storage::url(setting('general_favicon')) }}">
@endif

{{-- Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

{{-- Styles --}}
<link rel="stylesheet" href="{{ asset('design/style.css') }}">

{{-- Extra head --}}
@stack('head')

{{-- Google Analytics --}}
@if(setting('seo_google_analytics'))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ setting('seo_google_analytics') }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{{ setting('seo_google_analytics') }}');
</script>
@endif
</head>
<body>

{{-- Top bar --}}
<x-frontend.topbar />

{{-- Navbar --}}
<x-frontend.navbar :active="$active ?? ''" />

{{-- Mobile Nav --}}
<x-frontend.mobile-nav :active="$active ?? ''" />

{{-- Page content --}}
@yield('content')

{{-- Footer --}}
<x-frontend.footer />

{{-- Global JS --}}
<script>
// ── Sticky nav shadow ──────────────────────────────────
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
  navbar.classList.toggle('scrolled', window.scrollY > 20);
});

// ── Mobile nav ─────────────────────────────────────────
const hamburger = document.getElementById('hamburger');
const mobileNav = document.getElementById('mobileNav');
const closeNav  = document.getElementById('closeNav');
hamburger.addEventListener('click', () => mobileNav.classList.add('open'));
closeNav.addEventListener('click',  () => mobileNav.classList.remove('open'));
mobileNav.querySelectorAll('a').forEach(a =>
  a.addEventListener('click', () => mobileNav.classList.remove('open'))
);

// ── Courses dropdown ────────────────────────────────────
document.querySelectorAll('.nav-dropdown').forEach(dropdown => {
  const toggle = dropdown.querySelector('.nav-dropdown-toggle');
  toggle?.addEventListener('click', (e) => {
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

// ── Scroll reveal ───────────────────────────────────────
const fadeEls = document.querySelectorAll('.fade-up');
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
fadeEls.forEach(el => observer.observe(el));
</script>

@stack('scripts')
</body>
</html>