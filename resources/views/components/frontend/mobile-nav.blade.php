{{-- resources/views/components/frontend/mobile-nav.blade.php --}}
@props(['active' => ''])

@php
  $navCourses = \App\Models\Course::active()->ordered()->get(['title', 'title_ja', 'slug']);
  $isJa = app()->isLocale('ja');
@endphp

<div class="mobile-nav" id="mobileNav">
  <button class="close-btn" id="closeNav">x</button>
  <a href="{{ route('home') }}" class="{{ $active === 'home' ? 'active' : '' }}">{{ $isJa ? 'ホーム' : 'Home' }}</a>
  <a href="{{ route('about') }}" class="{{ $active === 'about' ? 'active' : '' }}">{{ $isJa ? '私たちについて' : 'About Us' }}</a>
  <a href="{{ route('ventures') }}" class="{{ $active === 'ventures' ? 'active' : '' }}">{{ $isJa ? '事業内容' : 'Our Ventures' }}</a>

  <span class="mobile-nav-label">{{ $isJa ? 'コース' : 'Courses' }}</span>
  <a href="{{ route('courses') }}" class="mobile-nav-sub {{ $active === 'courses' ? 'active' : '' }}">{{ $isJa ? 'すべてのコース' : 'All Courses' }}</a>
  @foreach($navCourses as $navCourse)
    <a href="{{ route('course.show', $navCourse->slug) }}" class="mobile-nav-sub {{ request()->routeIs('course.show') && request()->route('course')?->slug === $navCourse->slug ? 'active' : '' }}">
      {{ localized($navCourse, 'title') }}
    </a>
  @endforeach

  <a href="{{ route('study-abroad') }}" class="{{ $active === 'study-abroad' ? 'active' : '' }}">{{ $isJa ? '留学' : 'Study Abroad' }}</a>
  <a href="{{ route('gallery') }}" class="{{ $active === 'gallery' ? 'active' : '' }}">{{ $isJa ? 'ギャラリー' : 'Gallery' }}</a>
  <a href="{{ route('blog') }}" class="{{ $active === 'blog' ? 'active' : '' }}">{{ $isJa ? 'ブログ' : 'Blogs' }}</a>
  <a href="{{ route('contact') }}" class="{{ $active === 'contact' ? 'active' : '' }}">{{ $isJa ? 'お問い合わせ' : 'Contact' }}</a>
  <div class="mobile-lang-switch">
    <a href="{{ language_url('en') }}" class="{{ ! $isJa ? 'active' : '' }}">EN</a>
    <a href="{{ language_url('ja') }}" class="{{ $isJa ? 'active' : '' }}">日本語</a>
  </div>
  <a href="{{ route('book-appointment') }}" class="btn btn-primary" style="text-align:center;margin-top:8px">{{ $isJa ? '相談予約' : 'Book a Consultation' }}</a>
</div>
