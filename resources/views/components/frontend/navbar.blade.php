{{-- resources/views/components/frontend/navbar.blade.php --}}
@props(['active' => ''])

@php
    $logo = setting('general_logo');
    $siteName = setting('general_site_name', 'HASU Educational Consultancy');
@endphp

<nav id="navbar">
    <a href="{{ route('home') }}" class="nav-logo-img">
        @if ($logo)
            <img src="{{ str_starts_with($logo, 'http') ? $logo : Storage::url($logo) }}" alt="{{ $siteName }}"
                style="height:100px;width:auto;display:block;object-fit:contain">
        @else
            <img src="{{ asset('images/logo.png') }}" alt="{{ $siteName }}"
                style="height:100px;width:auto;display:block;object-fit:contain">
        @endif
    </a>

    <div class="nav-links">
        <a href="{{ route('home') }}" class="{{ $active === 'home' ? 'active' : '' }}">Home</a>
        <a href="{{ route('about') }}" class="{{ $active === 'about' ? 'active' : '' }}">About Us</a>
        <a href="{{ route('ventures') }}" class="{{ $active === 'ventures' ? 'active' : '' }}">Our Ventures</a>

        {{-- Courses dropdown --}}
        <div class="nav-dropdown">
            <button type="button"
                class="nav-dropdown-toggle {{ in_array($active, ['courses', 'course-detail']) ? 'active' : '' }}"
                aria-expanded="false" aria-haspopup="true">
                Courses ▾
            </button>
            <div class="nav-dropdown-menu">
                <a href="{{ route('courses') }}" class="{{ $active === 'courses' ? 'active' : '' }}">All Courses</a>
                <a href="{{ route('course.detail') }}" class="{{ $active === 'course-japanese' ? 'active' : '' }}">Japanese Language</a>
                <a href="{{ route('course.detail') }}" class="{{ $active === 'course-ielts' ? 'active' : '' }}">IELTS</a>
                <a href="{{ route('course.detail') }}" class="{{ $active === 'course-pte' ? 'active' : '' }}">PTE</a>
            </div>
        </div>

        <a href="{{ route('study-abroad') }}" class="{{ $active === 'study-abroad' ? 'active' : '' }}">Study Abroad</a>
        <a href="{{ route('gallery') }}" class="{{ $active === 'gallery' ? 'active' : '' }}">Gallery</a>
        <a href="{{ route('blog') }}" class="{{ $active === 'blog' ? 'active' : '' }}">Blogs</a>
        <a href="{{ route('contact') }}" class="{{ $active === 'contact' ? 'active' : '' }}">Contact</a>
    </div>

    <div class="nav-right">
        <a href="{{ route('book-appointment') }}" class="btn btn-primary">Book a Consultation</a>
    </div>

    <div class="hamburger" id="hamburger">
        <span></span><span></span><span></span>
    </div>
</nav>
