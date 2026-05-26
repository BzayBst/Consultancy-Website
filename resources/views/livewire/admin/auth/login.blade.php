{{-- resources/views/livewire/admin/auth/login.blade.php --}}

<div class="auth-page">

    {{-- Background with dot-grid matching the site hero --}}
    <div class="auth-bg">
        <div class="auth-bg-dots"></div>
        <div class="auth-bg-wave"></div>
    </div>

    <div class="auth-card-wrap">

        {{-- Logo / Branding --}}
        <div class="auth-logo">
            <img src="{{ Storage::url(setting('general_logo')) }}" alt="HASU Educational Consultancy">
            <div class="auth-logo-sub">Admin Portal</div>
        </div>

        {{-- Card --}}
        <div class="auth-card">

            <div class="auth-card-header">
                <h1>Welcome Back</h1>
                <p>Sign in to manage HASU's CMS</p>
            </div>

            <form wire:submit="login" novalidate>
                @csrf

                {{-- Email --}}
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">Email Address</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <input
                            type="email"
                            id="email"
                            wire:model="email"
                            placeholder="admin@hasuedu.com"
                            autocomplete="email"
                            autofocus
                        >
                    </div>
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}"
                     x-data="{ show: false }">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        <input
                            :type="show ? 'text' : 'password'"
                            id="password"
                            wire:model="password"
                            placeholder="••••••••"
                            autocomplete="current-password"
                        >
                        <button type="button" class="input-toggle" @click="show = !show" tabindex="-1">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="form-row">
                    <label class="checkbox-label">
                        <input type="checkbox" wire:model="remember">
                        <span>Keep me signed in</span>
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-login" wire:loading.attr="disabled">
                    <span wire:loading.remove>Sign In</span>
                    <span wire:loading class="btn-loading">
                        <svg class="spin" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="31.4" stroke-dashoffset="10" stroke-linecap="round"/></svg>
                        Signing in…
                    </span>
                </button>

            </form>

        </div>

        <div class="auth-footer">
            &copy; {{ date('Y') }} HASU Educational Consultancy &mdash; Admin Area
        </div>

    </div>

</div>

<style>
/* ============================
   HASU Admin Auth Styles
   ============================ */
:root {
    --blue: #2952e3;
    --blue-dark: #1a3ed4;
    --red: #cc2222;
    --red-dark: #a81a1a;
    --navy: #0d1560;
    --border: #e2e8f0;
    --text: #555;
    --light: #f0f4fd;
    --radius: 8px;
    --shadow: 0 4px 24px rgba(0,0,0,0.09);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body.admin-auth-body {
    font-family: 'DM Sans', sans-serif;
    min-height: 100vh;
    background: #fff;
    overflow-x: hidden;
}

/* ---- Background ---- */
.auth-page {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 16px;
}

.auth-bg {
    position: fixed;
    inset: 0;
    background: linear-gradient(120deg, #0d1560 0%, #1a237e 40%, #283593 65%, #3949ab 100%);
    z-index: 0;
}

.auth-bg-dots {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(255,255,255,.07) 1px, transparent 1px);
    background-size: 28px 28px;
}

.auth-bg-wave {
    position: absolute;
    bottom: -2px; left: 0; right: 0;
    height: 120px;
    background: #fff;
    clip-path: ellipse(60% 100% at 50% 100%);
}

/* ---- Card wrap ---- */
.auth-card-wrap {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 420px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 24px;
}

/* ---- Logo ---- */
.auth-logo {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
}

.auth-logo img {
    height: 64px;
    width: auto;
    filter: brightness(0) invert(1);
    object-fit: contain;
}

.auth-logo-sub {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: rgba(255,255,255,.65);
}

/* ---- Card ---- */
.auth-card {
    width: 100%;
    background: #fff;
    border-radius: 16px;
    padding: 40px 36px;
    box-shadow: 0 20px 60px rgba(13,21,96,.25);
}

.auth-card-header {
    text-align: center;
    margin-bottom: 32px;
}

.auth-card-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: 26px;
    color: var(--navy);
    margin-bottom: 6px;
}

.auth-card-header p {
    font-size: 13px;
    color: var(--text);
}

/* ---- Form ---- */
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: var(--navy);
    margin-bottom: 7px;
}

.input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon {
    position: absolute;
    left: 13px;
    color: #94a3b8;
    display: flex;
    pointer-events: none;
}

.input-wrap input {
    width: 100%;
    padding: 11px 40px 11px 38px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    color: #333;
    background: #fff;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
}

.input-wrap input:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(41, 82, 227, .12);
}

.has-error .input-wrap input {
    border-color: var(--red);
}

.has-error .input-wrap input:focus {
    box-shadow: 0 0 0 3px rgba(204, 34, 34, .12);
}

.input-toggle {
    position: absolute;
    right: 12px;
    background: none;
    border: none;
    cursor: pointer;
    color: #94a3b8;
    padding: 2px;
    display: flex;
    transition: color .2s;
}

.input-toggle:hover { color: var(--navy); }

.field-error {
    display: block;
    font-size: 12px;
    color: var(--red);
    margin-top: 5px;
}

/* ---- Checkbox ---- */
.form-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-size: 13px;
    color: var(--text);
}

.checkbox-label input[type="checkbox"] {
    width: 15px;
    height: 15px;
    accent-color: var(--blue);
    cursor: pointer;
}

/* ---- Submit button ---- */
.btn-login {
    width: 100%;
    padding: 13px;
    background: var(--red);
    color: #fff;
    border: none;
    border-radius: var(--radius);
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: background .25s, transform .15s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-login:hover:not(:disabled) {
    background: var(--red-dark);
    transform: translateY(-1px);
}

.btn-login:disabled {
    opacity: .7;
    cursor: not-allowed;
}

.btn-loading {
    display: flex;
    align-items: center;
    gap: 8px;
}

.spin {
    animation: spin .8s linear infinite;
}

@keyframes spin { to { transform: rotate(360deg); } }

/* ---- Footer ---- */
.auth-footer {
    font-size: 12px;
    color: rgba(255,255,255,.45);
    text-align: center;
}

@media (max-width: 480px) {
    .auth-card { padding: 28px 20px; }
}
</style>