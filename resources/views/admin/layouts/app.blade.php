<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin – HASU Educational Consultancy' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="admin-body">

    {{-- ── Sidebar ──────────────────────────────────────────────── --}}
    <aside class="admin-sidebar" id="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('logo.png') }}" alt="HASU">
            <span>Admin</span>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>

            {{-- Placeholder nav items — expand as you build CMS modules --}}
            <div class="nav-group-label">Content</div>
            <a href="#" class="">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v10a2 2 0 01-2 2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13 2v6h6"/></svg>
                Pages
            </a>
            <a href="#" class="">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                Blog Posts
            </a>
            <a href="#" class="">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Gallery
            </a>
            <a href="#" class="">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Events
            </a>

            <div class="nav-group-label">Settings</div>
            <a href="#" class="">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
                Settings
            </a>
            <a href="#" class="">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Admins
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-admin-info">
                <div class="sidebar-avatar">{{ strtoupper(substr(auth('admin')->user()->name, 0, 1)) }}</div>
                <div>
                    <strong>{{ auth('admin')->user()->name }}</strong>
                    <small>{{ auth('admin')->user()->email }}</small>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout" title="Logout">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </aside>

    {{-- ── Top bar ──────────────────────────────────────────────── --}}
    <div class="admin-topbar">
        <button class="sidebar-toggle" id="sidebarToggle" onclick="document.getElementById('sidebar').classList.toggle('open')">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>

        <div class="topbar-breadcrumb">
            {{ $title ?? 'Dashboard' }}
        </div>

        <div class="topbar-right">
            <span class="topbar-date">{{ now()->format('D, d M Y') }}</span>
        </div>
    </div>

    {{-- ── Main content ─────────────────────────────────────────── --}}
    <main class="admin-main">
        {{ $slot }}
    </main>

    @livewireScripts

    <style>
    :root {
        --navy: #0d1560;
        --blue: #2952e3;
        --blue-light: #e8edfd;
        --red: #cc2222;
        --red-light: #fdeaea;
        --border: #e2e8f0;
        --text: #555;
        --light: #f5f7fb;
        --sidebar-w: 240px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body.admin-body {
        font-family: 'DM Sans', sans-serif;
        background: var(--light);
        color: #333;
        min-height: 100vh;
    }

    /* ── Sidebar ── */
    .admin-sidebar {
        position: fixed; top: 0; left: 0; bottom: 0;
        width: var(--sidebar-w);
        background: var(--navy);
        display: flex; flex-direction: column;
        z-index: 200;
        transition: transform .3s;
    }

    .sidebar-logo {
        display: flex; align-items: center; gap: 10px;
        padding: 20px 20px 16px;
        border-bottom: 1px solid rgba(255,255,255,.08);
    }
    .sidebar-logo img {
        height: 36px; width: auto;
        filter: brightness(0) invert(1);
        object-fit: contain;
    }
    .sidebar-logo span {
        font-size: 11px; font-weight: 700; letter-spacing: 2px;
        text-transform: uppercase; color: rgba(255,255,255,.5);
    }

    .sidebar-nav {
        flex: 1; overflow-y: auto;
        padding: 16px 0;
    }
    .sidebar-nav a {
        display: flex; align-items: center; gap: 11px;
        padding: 10px 20px;
        font-size: 13.5px; font-weight: 500;
        color: rgba(255,255,255,.65);
        text-decoration: none;
        transition: all .2s;
        border-left: 3px solid transparent;
    }
    .sidebar-nav a:hover {
        color: #fff;
        background: rgba(255,255,255,.06);
    }
    .sidebar-nav a.active {
        color: #fff;
        background: rgba(255,255,255,.1);
        border-left-color: var(--red);
    }
    .nav-group-label {
        font-size: 10px; font-weight: 700; letter-spacing: 2px;
        text-transform: uppercase;
        color: rgba(255,255,255,.3);
        padding: 16px 20px 6px;
    }

    .sidebar-footer {
        padding: 14px 16px;
        border-top: 1px solid rgba(255,255,255,.08);
        display: flex; align-items: center; justify-content: space-between; gap: 8px;
    }
    .sidebar-admin-info {
        display: flex; align-items: center; gap: 10px; min-width: 0;
    }
    .sidebar-avatar {
        width: 34px; height: 34px; border-radius: 50%;
        background: var(--red); color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; font-weight: 700; flex-shrink: 0;
    }
    .sidebar-admin-info strong {
        display: block; font-size: 13px; color: #fff;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .sidebar-admin-info small {
        font-size: 11px; color: rgba(255,255,255,.45);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block;
    }
    .sidebar-logout {
        background: rgba(255,255,255,.08); border: none;
        color: rgba(255,255,255,.6); cursor: pointer;
        width: 30px; height: 30px; border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        transition: all .2s; flex-shrink: 0;
    }
    .sidebar-logout:hover { background: var(--red); color: #fff; }

    /* ── Top bar ── */
    .admin-topbar {
        position: fixed; top: 0;
        left: var(--sidebar-w); right: 0;
        height: 56px; z-index: 100;
        background: #fff;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center;
        padding: 0 24px; gap: 16px;
    }
    .sidebar-toggle {
        display: none;
        background: none; border: none; cursor: pointer;
        color: var(--navy); padding: 4px;
    }
    .topbar-breadcrumb {
        flex: 1; font-size: 15px; font-weight: 600; color: var(--navy);
    }
    .topbar-right { display: flex; align-items: center; gap: 16px; }
    .topbar-date { font-size: 12px; color: var(--text); }

    /* ── Main ── */
    .admin-main {
        margin-left: var(--sidebar-w);
        padding-top: 56px;
        min-height: 100vh;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .admin-sidebar { transform: translateX(-100%); }
        .admin-sidebar.open { transform: none; }
        .admin-topbar { left: 0; }
        .admin-main { margin-left: 0; }
        .sidebar-toggle { display: flex; }
    }
    </style>
</body>
</html>