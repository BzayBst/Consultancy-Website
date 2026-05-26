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
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="3" width="7" height="7" rx="1" />
                    <rect x="3" y="14" width="7" height="7" rx="1" />
                    <rect x="14" y="14" width="7" height="7" rx="1" />
                </svg>
                Dashboard
            </a>

            <div class="nav-group-label">Content</div>

            <div class="nav-dropdown-wrapper {{ request()->routeIs('admin.home*') || request()->routeIs('admin.hero-slides') ? 'open' : '' }}">
                <button type="button" class="nav-dropdown-toggle" onclick="toggleDropdown(this)">
                    <span class="nav-label-group">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v10a2 2 0 01-2 2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 2v6h6" />
                        </svg>
                        Home Page
                    </span>
                    <svg class="chevron-icon" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div class="nav-dropdown-menu">
                    <a href="{{ route('admin.hero-slides') }}"
                        class="{{ request()->routeIs('admin.hero-slides') ? 'active' : '' }}">
                        Sliders
                    </a>
                    
                    <a href="{{ route('admin.home.about') }}"
                        class="{{ request()->routeIs('admin.home.about') ? 'active' : '' }}">
                        About Section
                    </a>
                </div>
            </div>


            {{-- Fixed Dropdown Component --}}
            <div class="nav-dropdown-wrapper {{ request()->routeIs('admin.about*') ? 'open' : '' }}">
                <button type="button" class="nav-dropdown-toggle" onclick="toggleDropdown(this)">
                    <span class="nav-label-group">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v10a2 2 0 01-2 2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 2v6h6" />
                        </svg>
                        About Page
                    </span>
                    <svg class="chevron-icon" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div class="nav-dropdown-menu">
                    <a href="{{ route('admin.about-page') }}"
                        class="{{ request()->routeIs('admin.about-page') ? 'active' : '' }}">
                        Overview / Main
                    </a>
                    <a href="{{ route('admin.about-page.why-us') }}" class="{{ request()->routeIs('admin.about-page.why-us') ? 'active' : '' }}">
                        Why Choose
                    </a>
                    <a href="{{ route('admin.about.core-values') }}" class="{{ request()->routeIs('admin.about.core-values') ? 'active' : '' }}">
                        Core Values
                    </a>
                    <a href="{{ route('admin.teams.index') }}" class="{{ request()->routeIs('admin.teams.index') ? 'active' : '' }}">
                        Team
                    </a>
                </div>
            </div>

            <a href="#" class="">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4 12.5-12.5z" />
                </svg>
                Blog Posts
            </a>

            <a href="{{ route('admin.gallery.index') }}"
                class="{{ request()->routeIs('admin.gallery.index') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Gallery
            </a>

            <a href="{{ route('admin.courses.index') }}"
                class="{{ request()->routeIs('admin.courses.index') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5A2.5 2.5 0 016.5 17H20" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4.5A2.5 2.5 0 016.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15z" />
                </svg>
                Courses
            </a>

            <a href="{{ route('admin.contact-cms.index') }}"
                class="{{ request()->routeIs('admin.contact-cms.index') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a4 4 0 01-4 4H7l-4 4V7a4 4 0 014-4h10a4 4 0 014 4v8z" />
                </svg>
                Contact CMS
            </a>

            <a href="{{ route('admin.study-abroad.index') }}"
                class="{{ request()->routeIs('admin.study-abroad.index') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3a9 9 0 100 18 9 9 0 000-18z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.6 9h16.8M3.6 15h16.8M12 3c2.2 2.4 3.3 5.4 3.3 9S14.2 18.6 12 21c-2.2-2.4-3.3-5.4-3.3-9S9.8 5.4 12 3z" />
                </svg>
                Study Abroad
            </a>

            <a href="{{ route('admin.events.index') }}" class="">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Events
            </a>

            <div class="nav-group-label">Settings</div>
            <a href="{{ route('admin.settings') }}"
                class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                Settings
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
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3 3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </aside>

    {{-- ── Top bar ──────────────────────────────────────────────── --}}
    <div class="admin-topbar">
        <button class="sidebar-toggle" id="sidebarToggle"
            onclick="document.getElementById('sidebar').classList.toggle('open')">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
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
    <script>
        function toggleDropdown(button) {
            const wrapper = button.parentElement;
            wrapper.classList.toggle('open');
        }
    </script>

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

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body.admin-body {
            font-family: 'DM Sans', sans-serif;
            background: var(--light);
            color: #333;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-w);
            background: var(--navy);
            display: flex;
            flex-direction: column;
            z-index: 200;
            transition: transform .3s;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 20px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        .sidebar-logo img {
            height: 36px;
            width: auto;
            filter: brightness(0) invert(1);
            object-fit: contain;
        }

        .sidebar-logo span {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .5);
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 16px 0;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 20px;
            font-size: 13.5px;
            font-weight: 500;
            color: rgba(255, 255, 255, .65);
            text-decoration: none;
            transition: all .2s;
            border-left: 3px solid transparent;
        }

        .sidebar-nav a:hover {
            color: #fff;
            background: rgba(255, 255, 255, .06);
        }

        .sidebar-nav a.active {
            color: #fff;
            background: rgba(255, 255, 255, .1);
            border-left-color: var(--red);
        }

        /* ── FIXED NAV DROPDOWN STYLING ── */
        .nav-dropdown-wrapper {
            display: flex;
            flex-direction: column;
        }

        .nav-dropdown-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 10px 20px;
            font-family: inherit;
            font-size: 13.5px;
            font-weight: 500;
            color: rgba(255, 255, 255, .65);
            background: transparent;
            border: none;
            border-left: 3px solid transparent;
            cursor: pointer;
            text-align: left;
            transition: all .2s;
        }

        .nav-dropdown-toggle:hover {
            color: #fff;
            background: rgba(255, 255, 255, .06);
        }

        /* Keep parent highlighted if sub-route is active */
        .nav-dropdown-wrapper.open .nav-dropdown-toggle {
            color: #fff;
            background: rgba(255, 255, 255, .03);
        }

        .nav-label-group {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .nav-dropdown-menu {
            display: none;
            flex-direction: column;
            background: rgba(0, 0, 0, 0.15);
            padding: 4px 0;
        }

        .nav-dropdown-wrapper.open .nav-dropdown-menu {
            display: flex;
        }

        /* Child items styling matching theme rules */
        .nav-dropdown-menu a {
            padding: 8px 20px 8px 52px; /* Indent beautifully past parent icon alignment */
            font-size: 13px;
            color: rgba(255, 255, 255, .55);
            border-left: none;
        }

        .nav-dropdown-menu a:hover {
            color: #fff;
            background: rgba(255, 255, 255, .04);
        }

        .nav-dropdown-menu a.active {
            color: #fff;
            background: transparent;
            font-weight: 600;
            position: relative;
        }

        /* Tiny indicators for active submenu items instead of thick full layout borders */
        .nav-dropdown-menu a.active::before {
            content: '';
            position: absolute;
            left: 38px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 4px;
            background: var(--red);
            border-radius: 50%;
        }

        .chevron-icon {
            color: rgba(255, 255, 255, .4);
            transition: transform 0.2s ease, color 0.2s;
        }

        .nav-dropdown-toggle:hover .chevron-icon,
        .nav-dropdown-wrapper.open .chevron-icon {
            color: #fff;
        }

        .nav-dropdown-wrapper.open .chevron-icon {
            transform: rotate(180deg);
        }

        .nav-group-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .3);
            padding: 16px 20px 6px;
        }

        .sidebar-footer {
            padding: 14px 16px;
            border-top: 1px solid rgba(255, 255, 255, .08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .sidebar-admin-info {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .sidebar-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--red);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .sidebar-admin-info strong {
            display: block;
            font-size: 13px;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-admin-info small {
            font-size: 11px;
            color: rgba(255, 255, 255, .45);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
        }

        .sidebar-logout {
            background: rgba(255, 255, 255, .08);
            border: none;
            color: rgba(255, 255, 255, .6);
            cursor: pointer;
            width: 30px;
            height: 30px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
            flex-shrink: 0;
        }

        .sidebar-logout:hover {
            background: var(--red);
            color: #fff;
        }

        /* ── Top bar ── */
        .admin-topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-w);
            right: 0;
            height: 56px;
            z-index: 100;
            background: #fff;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 16px;
        }

        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--navy);
            padding: 4px;
        }

        .topbar-breadcrumb {
            flex: 1;
            font-size: 15px;
            font-weight: 600;
            color: var(--navy);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-date {
            font-size: 12px;
            color: var(--text);
        }

        /* ── Main ── */
        .admin-main {
            margin-left: var(--sidebar-w);
            padding-top: 56px;
            min-height: 100vh;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.open {
                transform: none;
            }

            .admin-topbar {
                left: 0;
            }

            .admin-main {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: flex;
            }
        }
    </style>

</body>

</html>
