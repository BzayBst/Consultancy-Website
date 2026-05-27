{{-- resources/views/livewire/admin/dashboard.blade.php --}}

<div class="dashboard-wrap">

    {{-- Welcome bar --}}
    <div class="dash-header">
        <div>
            <h1>Welcome back, {{ $admin->name }} 👋</h1>
            <p>Here's what's happening with HASU today.</p>
        </div>
        <div class="dash-header-meta">
            @if ($admin->last_login_at)
                <span>Last login: {{ $admin->last_login_at->diffForHumans() }} · {{ $admin->last_login_ip }}</span>
            @endif
        </div>
    </div>

    {{-- Stat cards — wire up to real data as you build modules --}}
    <div class="dash-stats">
        <div class="dash-stat">
            <div class="dash-stat-icon" style="background:#e8edfd">📝</div>
            <div>
                <strong>{{ $blogCount }}</strong>
                <span>Blog Posts</span>
            </div>
        </div>
        <div class="dash-stat">
            <div class="dash-stat-icon" style="background:#fdeaea">🎓</div>
            <div>
                <strong>{{ $courseCount }}</strong>
                <span>Courses</span>
            </div>
        </div>
        <div class="dash-stat">
            <div class="dash-stat-icon" style="background:#f0fdf4">📅</div>
            <div>
                <strong>{{ $eventCount }}</strong>
                <span>Events</span>
            </div>
        </div>
        <div class="dash-stat">
            <div class="dash-stat-icon" style="background:#fef9c3">🖼️</div>
            <div>
                <strong>{{ $galleryCount }}</strong>
                <span>Gallery Items</span>
            </div>
        </div>
    </div>

    {{-- Quick actions --}}
    <div class="dash-section-title">Quick Actions</div>
    <div class="dash-actions">
        <a href="{{ route('admin.blog-posts.index') }}" class="dash-action">
            <span>✏️</span> New Blog Post
        </a>
        <a href="{{ route('admin.events.index') }}" class="dash-action">
            <span>📅</span> Add Event
        </a>
        <a href="{{ route('admin.gallery.index') }}" class="dash-action">
            <span>🖼️</span> Upload Gallery
        </a>
        <a href="{{ route('admin.settings') }}" class="dash-action">
            <span>⚙️</span> Site Settings
        </a>
    </div>

</div>

<style>
    .dashboard-wrap {
        padding: 32px 28px;
    }

    .dash-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .dash-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        color: #0d1560;
        margin-bottom: 4px;
    }

    .dash-header p {
        font-size: 14px;
        color: #555;
    }

    .dash-header-meta {
        font-size: 12px;
        color: #94a3b8;
    }

    .dash-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 36px;
    }

    .dash-stat {
        background: #fff;
        border-radius: 10px;
        padding: 20px 22px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
        display: flex;
        align-items: center;
        gap: 16px;
        border-bottom: 3px solid transparent;
        transition: border-color .25s, transform .25s;
    }

    .dash-stat:hover {
        border-bottom-color: #cc2222;
        transform: translateY(-3px);
    }

    .dash-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .dash-stat strong {
        display: block;
        font-size: 26px;
        color: #0d1560;
        font-weight: 700;
    }

    .dash-stat span {
        font-size: 12px;
        color: #555;
    }

    .dash-section-title {
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #94a3b8;
        margin-bottom: 14px;
    }

    .dash-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .dash-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        padding: 11px 20px;
        font-size: 14px;
        font-weight: 500;
        color: #0d1560;
        text-decoration: none;
        transition: all .2s;
    }

    .dash-action:hover {
        border-color: #2952e3;
        color: #2952e3;
        background: #e8edfd;
    }

    @media (max-width: 768px) {
        .dashboard-wrap {
            padding: 20px 16px;
        }

        .dash-stats {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 480px) {
        .dash-stats {
            grid-template-columns: 1fr;
        }
    }
</style>
