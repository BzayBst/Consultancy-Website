{{-- resources/views/livewire/admin/settings/site-settings.blade.php --}}

<div class="settings-wrap" x-data>

    {{-- ── Page header ─────────────────────────────────────────────── --}}
    <div class="settings-header">
        <div>
            <h1>Site Settings</h1>
            <p>Manage your website's global configuration</p>
        </div>
    </div>

    {{-- ── Flash message ───────────────────────────────────────────── --}}
    @if (session('success'))
        <div class="alert alert-success" x-data="{ show: true }" x-show="show"
             x-init="setTimeout(() => show = false, 3500)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <span>✅</span> {{ session('success') }}
        </div>
    @endif

    {{-- ── Tab navigation ──────────────────────────────────────────── --}}
    <div class="settings-tabs">
        <button wire:click="setTab('general')"
                class="tab-btn {{ $activeTab === 'general' ? 'active' : '' }}">
            <span class="tab-icon">🏢</span> General
        </button>
        <button wire:click="setTab('contact')"
                class="tab-btn {{ $activeTab === 'contact' ? 'active' : '' }}">
            <span class="tab-icon">📞</span> Contact
        </button>
        <button wire:click="setTab('social')"
                class="tab-btn {{ $activeTab === 'social' ? 'active' : '' }}">
            <span class="tab-icon">📱</span> Social Media
        </button>
        <button wire:click="setTab('seo')"
                class="tab-btn {{ $activeTab === 'seo' ? 'active' : '' }}">
            <span class="tab-icon">🔍</span> SEO
        </button>
    </div>

    {{-- ── Tab panels ──────────────────────────────────────────────── --}}
    <div class="settings-body">

        {{-- ════════════════ GENERAL ════════════════ --}}
        @if ($activeTab === 'general')
            @include('admin.settings.tabs.general')
        @endif

        {{-- ════════════════ CONTACT ════════════════ --}}
        @if ($activeTab === 'contact')
            @include('admin.settings.tabs.contact')
        @endif

        {{-- ════════════════ SOCIAL ════════════════ --}}
        @if ($activeTab === 'social')
            @include('admin.settings.tabs.social')
        @endif

        {{-- ════════════════ SEO ════════════════ --}}
        @if ($activeTab === 'seo')
            @include('admin.settings.tabs.seo')
        @endif

    </div>{{-- /.settings-body --}}

</div>{{-- /.settings-wrap --}}

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
    --radius: 8px;
    --shadow: 0 2px 12px rgba(0,0,0,.07);
}

.settings-wrap { padding: 32px 28px; max-width: 1000px; }

/* ── Header ── */
.settings-header {
    display: flex; justify-content: space-between; align-items: flex-start;
    margin-bottom: 28px;
}
.settings-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: 24px; color: var(--navy); margin-bottom: 4px;
}
.settings-header p { font-size: 14px; color: var(--text); }

/* ── Alert ── */
.alert {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 18px; border-radius: var(--radius);
    font-size: 14px; font-weight: 500; margin-bottom: 24px;
}
.alert-success {
    background: #f0fdf4; color: #166534;
    border: 1px solid #bbf7d0;
}

/* ── Tabs ── */
.settings-tabs {
    display: flex; gap: 4px;
    border-bottom: 2px solid var(--border);
    margin-bottom: 28px;
}
.tab-btn {
    display: flex; align-items: center; gap: 7px;
    padding: 10px 20px;
    background: none; border: none;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px; font-weight: 500; color: var(--text);
    cursor: pointer; border-bottom: 2px solid transparent;
    margin-bottom: -2px; transition: all .2s; border-radius: 6px 6px 0 0;
}
.tab-btn:hover { color: var(--navy); background: var(--light); }
.tab-btn.active { color: var(--navy); border-bottom-color: var(--red); background: #fff; font-weight: 600; }
.tab-icon { font-size: 16px; }

/* ── Settings card ── */
.settings-card {
    background: #fff; border-radius: 12px;
    border: 1px solid var(--border);
    box-shadow: var(--shadow); overflow: hidden;
    margin-bottom: 20px;
}
.settings-card-header {
    padding: 20px 24px 16px;
    border-bottom: 1px solid var(--border);
    background: var(--light);
}
.settings-card-header h2 {
    font-size: 16px; font-weight: 700; color: var(--navy); margin-bottom: 3px;
}
.settings-card-header p { font-size: 13px; color: var(--text); }

/* ── Grid ── */
.settings-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px 24px;
    padding: 24px;
}

/* ── Form groups ── */
.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-group--full { grid-column: 1 / -1; }

.form-group label {
    font-size: 13px; font-weight: 600; color: var(--navy);
}
.req { color: var(--red); }
.label-hint {
    font-size: 11px; font-weight: 400; color: #94a3b8; margin-left: 6px;
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="tel"],
.form-group input[type="url"],
.form-group textarea {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px; color: #333;
    background: #fff; outline: none;
    transition: border-color .2s, box-shadow .2s;
    resize: vertical;
}
.form-group input:focus,
.form-group textarea:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(41,82,227,.1);
}
.field-error { font-size: 12px; color: var(--red); }
.char-count { font-size: 11px; color: #94a3b8; text-align: right; }

/* ── Input with icon prefix ── */
.input-icon-wrap { position: relative; display: flex; align-items: center; }
.input-prefix {
    position: absolute; left: 12px; font-size: 15px;
    pointer-events: none; line-height: 1;
}
.input-icon-wrap input { padding-left: 38px; }

/* ── Upload box ── */
.upload-box {
    position: relative;
    border: 2px dashed var(--border);
    border-radius: var(--radius);
    min-height: 140px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: border-color .2s, background .2s;
    overflow: hidden;
}
.upload-box:hover, .upload-box.dragging {
    border-color: var(--blue);
    background: var(--blue-light);
}
.upload-box--wide { min-height: 180px; }
.upload-placeholder {
    display: flex; flex-direction: column; align-items: center; gap: 6px;
    color: #94a3b8; text-align: center; padding: 16px;
}
.upload-placeholder span { font-size: 32px; }
.upload-placeholder small { font-size: 12px; display: block; }
.upload-preview {
    max-width: 100%; max-height: 140px;
    object-fit: contain; border-radius: 6px;
    padding: 8px;
}
.upload-preview--sm { max-height: 80px; }
.upload-preview--wide { max-height: 180px; width: 100%; object-fit: cover; }
.upload-input {
    position: absolute; inset: 0;
    opacity: 0; cursor: pointer; width: 100%; height: 100%;
}
.upload-loading { font-size: 12px; color: var(--blue); margin-top: 4px; }

/* ── SERP preview ── */
.serp-preview {
    background: #fff; border: 1px solid var(--border);
    border-radius: var(--radius); padding: 18px 20px;
    font-family: Arial, sans-serif;
}
.serp-title {
    font-size: 18px; color: #1a0dab; margin-bottom: 3px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.serp-url { font-size: 13px; color: #006621; margin-bottom: 6px; }
.serp-desc { font-size: 13px; color: #545454; line-height: 1.5;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}

/* ── Save actions ── */
.settings-actions {
    display: flex; justify-content: flex-end;
    padding: 4px 0 8px;
}
.btn-save {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 28px;
    background: var(--red); color: #fff;
    border: none; border-radius: var(--radius);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px; font-weight: 600;
    cursor: pointer; transition: background .2s, transform .15s;
}
.btn-save:hover:not(:disabled) { background: #a81a1a; transform: translateY(-1px); }
.btn-save:disabled { opacity: .65; cursor: not-allowed; }

@media (max-width: 640px) {
    .settings-wrap { padding: 16px; }
    .settings-grid { grid-template-columns: 1fr; }
    .settings-tabs { overflow-x: auto; }
    .tab-btn { padding: 10px 14px; font-size: 13px; white-space: nowrap; }
}
</style>