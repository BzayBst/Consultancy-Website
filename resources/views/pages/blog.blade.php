@extends('layouts.app', ['active' => 'blog'])

@section('title', 'Blog - ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description', 'Stay updated with study abroad tips, scholarship guides, visa updates, and insights from HASU Educational Consultancy.')

@push('head')
<style>
.blog-section{padding:80px 0}
.blog-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:30px;margin-top:40px}
.blog-card{background:#fff;border-radius:8px;border:1px solid #eaeaea;overflow:hidden;transition:transform .3s ease,box-shadow .3s ease;text-decoration:none;color:inherit;display:flex;flex-direction:column}
.blog-card:hover{transform:translateY(-5px);box-shadow:0 15px 30px rgba(0,0,0,.08)}
.blog-img{width:100%;aspect-ratio:16/10;overflow:hidden;background:#e2e8f0}
.blog-img img{width:100%;height:100%;object-fit:cover;transition:transform .5s ease}
.blog-card:hover .blog-img img{transform:scale(1.05)}
.blog-content{padding:24px;display:flex;flex-direction:column;flex-grow:1}
.blog-meta{font-size:13px;color:#777;margin-bottom:12px;display:flex;align-items:center;gap:10px;flex-wrap:wrap}
.blog-title{font-family:'Playfair Display',serif;font-size:1.25rem;margin:0 0 12px;color:#1a1a1a;line-height:1.3}
.blog-excerpt{font-size:14px;color:#555;line-height:1.6;margin-bottom:20px}
.blog-read-more{margin-top:auto;font-weight:600;color:var(--blue);font-size:14px}
.blog-empty{grid-column:1/-1;background:#fff;border:1px dashed rgba(13,21,96,.25);border-radius:8px;padding:42px 24px;text-align:center;color:#64748b}
.blog-empty strong{display:block;color:var(--navy);font-size:1.1rem;margin-bottom:6px}
.blog-pagination{margin-top:34px;background:#fff;border:1px solid #eaeaea;border-radius:8px;padding:14px 18px}
</style>
@endpush

@section('content')
    <x-frontend.page-hero
        badge="News & Insights"
        title="Blog Section"
        highlight="Blog"
        subtitle="Stay updated with the best study abroad tips, scholarship guides, and updates from HASU Educational Consultancy."
        :breadcrumbs="[['label' => 'Home', 'url' => route('home')], ['label' => 'Blogs']]"
    />

    <section class="blog-section">
        <div class="container">
            <div class="courses-listing-head fade-up">
                <div>
                    <div class="section-label" style="margin-bottom:8px">Latest Articles</div>
                    <h2 class="section-title" style="margin-bottom:0;text-align:left">Read Our Insights</h2>
                </div>
            </div>

            <div class="blog-grid">
                @forelse($posts as $i => $post)
                <a href="{{ route('blog.show', $post->slug) }}" class="blog-card fade-up" @if($i > 0) style="transition-delay:{{ round(($i % 6) * .08, 2) }}s" @endif>
                    <div class="blog-img">
                        @if($post->image_url)
                            <img src="{{ $post->image_url }}" alt="{{ $post->image_alt ?: $post->title }}">
                        @endif
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            @if($post->category)
                                <span class="course-list-tag" style="padding:2px 8px">{{ $post->category }}</span>
                            @endif
                            @if($post->published_at)
                                <span>{{ $post->published_at->format('M d, Y') }}</span>
                            @endif
                        </div>
                        <h3 class="blog-title">{{ $post->title }}</h3>
                        @if($post->excerpt)
                            <p class="blog-excerpt">{{ $post->excerpt }}</p>
                        @endif
                        <span class="blog-read-more">Read Full Article</span>
                    </div>
                </a>
                @empty
                <div class="blog-empty">
                    <strong>No blog posts added yet.</strong>
                    <span>Posts added from the CMS will appear here automatically.</span>
                </div>
                @endforelse
            </div>

            @if($posts->hasPages())
                <div class="blog-pagination">{{ $posts->links() }}</div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
const navbar = document.getElementById('navbar');
if (navbar) window.addEventListener('scroll', () => navbar.classList.toggle('scrolled', window.scrollY > 20));

const hamburger = document.getElementById('hamburger');
const mobileNav = document.getElementById('mobileNav');
const closeNav = document.getElementById('closeNav');
hamburger?.addEventListener('click', () => mobileNav?.classList.add('open'));
closeNav?.addEventListener('click', () => mobileNav?.classList.remove('open'));

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
@endpush
