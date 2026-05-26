{{-- resources/views/components/frontend/mobile-nav.blade.php --}}
@props(['active' => ''])

@php
  $navCourses = \App\Models\Course::active()->ordered()->get(['title', 'slug']);
@endphp

<div class="mobile-nav" id="mobileNav">
  <button class="close-btn" id="closeNav">x</button>
  <a href="{{ route('home') }}" class="{{ $active === 'home' ? 'active' : '' }}">Home</a>
  <a href="{{ route('about') }}" class="{{ $active === 'about' ? 'active' : '' }}">About Us</a>
  <a href="{{ route('ventures') }}" class="{{ $active === 'ventures' ? 'active' : '' }}">Our Ventures</a>

  <span class="mobile-nav-label">Courses</span>
  <a href="{{ route('courses') }}" class="mobile-nav-sub {{ $active === 'courses' ? 'active' : '' }}">All Courses</a>
  @foreach($navCourses as $navCourse)
    <a href="{{ route('course.show', $navCourse->slug) }}" class="mobile-nav-sub {{ request()->routeIs('course.show') && request()->route('course')?->slug === $navCourse->slug ? 'active' : '' }}">
      {{ $navCourse->title }}
    </a>
  @endforeach

  <a href="{{ route('study-abroad') }}" class="{{ $active === 'study-abroad' ? 'active' : '' }}">Study Abroad</a>
  <a href="{{ route('gallery') }}" class="{{ $active === 'gallery' ? 'active' : '' }}">Gallery</a>
  <a href="{{ route('blog') }}" class="{{ $active === 'blog' ? 'active' : '' }}">Blogs</a>
  <a href="{{ route('contact') }}" class="{{ $active === 'contact' ? 'active' : '' }}">Contact</a>
  <a href="{{ route('book-appointment') }}" class="btn btn-primary" style="text-align:center;margin-top:8px">Book a Consultation</a>
</div>
