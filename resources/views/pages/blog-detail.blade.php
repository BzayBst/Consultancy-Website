@extends('layouts.app', ['active' => 'blog'])

@section('title', ($post->meta_title ?: $post->title) . ' - ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description', $post->meta_description ?: $post->excerpt ?: 'Blog article from HASU Educational Consultancy.')

@push('head')
<style>
.bd-main{padding:72px 0 80px}
.bd-layout{display:grid;grid-template-columns:minmax(0,1fr) 320px;gap:44px;align-items:start}
.bd-article{background:#fff;border:1px solid #eaeaea;border-radius:10px;overflow:hidden;box-shadow:0 4px 22px rgba(15,23,42,.06)}
.bd-image{width:100%;aspect-ratio:16/8;background:#e2e8f0;overflow:hidden}
.bd-image img{width:100%;height:100%;object-fit:cover;display:block}
.bd-body{padding:34px}
.bd-meta{display:flex;gap:10px;align-items:center;flex-wrap:wrap;margin-bottom:14px;color:#64748b;font-size:13px}
.bd-title{font-family:'Playfair Display',serif;color:var(--navy);font-size:clamp(28px,4vw,44px);line-height:1.16;margin-bottom:16px}
.bd-excerpt{font-size:16px;color:#555;line-height:1.75;margin-bottom:26px;border-left:3px solid var(--blue);padding-left:16px}
.bd-content{font-size:15px;color:#444;line-height:1.85}
.bd-content h2,.bd-content h3{font-family:'Playfair Display',serif;color:var(--navy);margin:28px 0 12px;line-height:1.25}
.bd-content h2{font-size:26px}.bd-content h3{font-size:21px}
.bd-content p,.bd-content ul,.bd-content ol,.bd-content blockquote{margin-bottom:18px}
.bd-content ul,.bd-content ol{padding-left:22px}
.bd-content blockquote{border-left:4px solid var(--red);background:#f8fafc;padding:16px 18px;border-radius:0 8px 8px 0;color:#334155}
.bd-sidebar-card{background:#fff;border:1px solid #eaeaea;border-radius:10px;padding:22px;position:sticky;top:90px;box-shadow:0 4px 18px rgba(15,23,42,.05)}
.bd-sidebar-card h3{font-family:'Playfair Display',serif;color:var(--navy);font-size:20px;margin-bottom:16px}
.bd-other{display:flex;gap:12px;text-decoration:none;color:inherit;padding:12px 0;border-top:1px solid #eef2f7}
.bd-other:first-of-type{border-top:0;padding-top:0}
.bd-other-img{width:72px;height:58px;border-radius:6px;background:#e2e8f0;overflow:hidden;flex-shrink:0}
.bd-other-img img{width:100%;height:100%;object-fit:cover;display:block}
.bd-other h4{font-size:13px;color:var(--navy);line-height:1.35;margin-bottom:4px}
.bd-other span{font-size:11px;color:#64748b}
@media(max-width:900px){.bd-layout{grid-template-columns:1fr}.bd-sidebar-card{position:static}.bd-body{padding:24px}}
</style>
@endpush

@section('content')
    <x-frontend.page-hero
        badge="{{ $post->category ?: 'Blog' }}"
        title="{{ $post->title }}"
        highlight="Article"
        subtitle="{{ $post->excerpt }}"
        :breadcrumbs="[['label' => 'Home', 'url' => route('home')], ['label' => 'Blogs', 'url' => route('blog')], ['label' => $post->title]]"
    />

    <section class="bd-main">
        <div class="container">
            <div class="bd-layout">
                <article class="bd-article fade-up">
                    <div class="bd-image">
                        @if($post->image_url)
                            <img src="{{ $post->image_url }}" alt="{{ $post->image_alt ?: $post->title }}">
                        @endif
                    </div>
                    <div class="bd-body">
                        <div class="bd-meta">
                            @if($post->category)<span class="course-list-tag">{{ $post->category }}</span>@endif
                            @if($post->published_at)<span>{{ $post->published_at->format('M d, Y') }}</span>@endif
                        </div>
                        <h1 class="bd-title">{{ $post->title }}</h1>
                        @if($post->excerpt)
                            <p class="bd-excerpt">{{ $post->excerpt }}</p>
                        @endif
                        <div class="bd-content">
                            {!! $post->content ?: '<p>Content coming soon.</p>' !!}
                        </div>
                    </div>
                </article>

                <aside class="bd-sidebar fade-up" style="transition-delay:.1s">
                    <div class="bd-sidebar-card">
                        <h3>More Articles</h3>
                        @forelse($otherPosts as $other)
                            <a href="{{ route('blog.show', $other->slug) }}" class="bd-other">
                                <div class="bd-other-img">
                                    @if($other->image_url)
                                        <img src="{{ $other->image_url }}" alt="{{ $other->image_alt ?: $other->title }}">
                                    @endif
                                </div>
                                <div>
                                    <h4>{{ $other->title }}</h4>
                                    <span>{{ $other->published_at?->format('M d, Y') }}</span>
                                </div>
                            </a>
                        @empty
                            <p style="color:#64748b;font-size:13px;line-height:1.6">More articles will appear here as they are published.</p>
                        @endforelse
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
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
