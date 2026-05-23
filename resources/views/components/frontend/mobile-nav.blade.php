{{-- resources/views/components/frontend/mobile-nav.blade.php --}}
@props(['active' => ''])

<div class="mobile-nav" id="mobileNav">
  <button class="close-btn" id="closeNav">✕</button>
  <a href="{{ route('home') }}"    class="{{ $active === 'home'     ? 'active' : '' }}">Home</a>
  <a href="{{ route('about') }}"   class="{{ $active === 'about'    ? 'active' : '' }}">About Us</a>
  <a href="#" class="{{ $active === 'ventures' ? 'active' : '' }}">Our Ventures</a>

  <span class="mobile-nav-label">Courses</span>
  <a href="#"               class="mobile-nav-sub {{ $active === 'courses'         ? 'active' : '' }}">All Courses</a>
  <a href="#" class="mobile-nav-sub {{ $active === 'course-japanese' ? 'active' : '' }}">Japanese Language</a>
  <a href="#"    class="mobile-nav-sub {{ $active === 'course-ielts'    ? 'active' : '' }}">IELTS</a>
  <a href="#"      class="mobile-nav-sub {{ $active === 'course-pte'      ? 'active' : '' }}">PTE</a>

  <a href="#"">Study Abroad</a>
  <a href="#"">Gallery</a>
  <a href="#"">Blogs</a>
  <a href="{{ route('contact') }}" class="{{ $active === 'contact' ? 'active' : '' }}">Contact</a>
  <a href="#cta-banner" class="btn btn-primary" style="text-align:center;margin-top:8px">Useful Links</a>
</div>