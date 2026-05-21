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
        <form wire:submit="saveGeneral">
            <div class="settings-card">
                <div class="settings-card-header">
                    <h2>General Settings</h2>
                    <p>Basic identity information for your website</p>
                </div>

                <div class="settings-grid">

                    {{-- Site Name --}}
                    <div class="form-group">
                        <label>Site Name <span class="req">*</span></label>
                        <input type="text" wire:model="general_site_name"
                               placeholder="HASU Educational Consultancy">
                        @error('general_site_name')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Established Year --}}
                    <div class="form-group">
                        <label>Established Year</label>
                        <input type="text" wire:model="general_established"
                               placeholder="2013">
                        @error('general_established')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Tagline --}}
                    <div class="form-group form-group--full">
                        <label>Tagline / Slogan</label>
                        <input type="text" wire:model="general_tagline"
                               placeholder="Your Trusted Partner in Global Education">
                        @error('general_tagline')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Copyright --}}
                    <div class="form-group form-group--full">
                        <label>Copyright Text</label>
                        <input type="text" wire:model="general_copyright"
                               placeholder="HASU Educational Consultancy. All Rights Reserved.">
                        @error('general_copyright')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Logo --}}
                    <div class="form-group">
                        <label>Site Logo</label>
                        <div class="upload-box" x-data="{ dragging: false }"
                             @dragover.prevent="dragging = true"
                             @dragleave.prevent="dragging = false"
                             @drop.prevent="dragging = false"
                             :class="{ 'dragging': dragging }">

                            @if ($general_logo)
                                <img src="{{ $general_logo->temporaryUrl() }}"
                                     class="upload-preview" alt="Logo preview">
                            @elseif ($general_logo_current)
                                <img src="{{ Storage::url($general_logo_current) }}"
                                     class="upload-preview" alt="Current logo">
                            @else
                                <div class="upload-placeholder">
                                    <span>🖼️</span>
                                    <small>Click or drag to upload logo</small>
                                    <small>PNG, SVG, WebP · Max 2MB</small>
                                </div>
                            @endif

                            <input type="file" wire:model="general_logo"
                                   accept="image/*" class="upload-input">
                        </div>
                        @error('general_logo')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                        <div wire:loading wire:target="general_logo" class="upload-loading">
                            Uploading…
                        </div>
                    </div>

                    {{-- Favicon --}}
                    <div class="form-group">
                        <label>Favicon</label>
                        <div class="upload-box" x-data="{ dragging: false }"
                             @dragover.prevent="dragging = true"
                             @dragleave.prevent="dragging = false"
                             @drop.prevent="dragging = false"
                             :class="{ 'dragging': dragging }">

                            @if ($general_favicon)
                                <img src="{{ $general_favicon->temporaryUrl() }}"
                                     class="upload-preview upload-preview--sm" alt="Favicon preview">
                            @elseif ($general_favicon_current)
                                <img src="{{ Storage::url($general_favicon_current) }}"
                                     class="upload-preview upload-preview--sm" alt="Current favicon">
                            @else
                                <div class="upload-placeholder">
                                    <span>⭐</span>
                                    <small>Click or drag to upload favicon</small>
                                    <small>PNG, ICO · Max 512KB</small>
                                </div>
                            @endif

                            <input type="file" wire:model="general_favicon"
                                   accept="image/*,.ico" class="upload-input">
                        </div>
                        @error('general_favicon')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                        <div wire:loading wire:target="general_favicon" class="upload-loading">
                            Uploading…
                        </div>
                    </div>

                </div>{{-- /.settings-grid --}}
            </div>{{-- /.settings-card --}}

            <div class="settings-actions">
                <button type="submit" class="btn-save" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="saveGeneral">💾 Save General Settings</span>
                    <span wire:loading wire:target="saveGeneral">Saving…</span>
                </button>
            </div>
        </form>
        @endif

        {{-- ════════════════ CONTACT ════════════════ --}}
        @if ($activeTab === 'contact')
        <form wire:submit="saveContact">
            <div class="settings-card">
                <div class="settings-card-header">
                    <h2>Contact Information</h2>
                    <p>Phone numbers, emails, and address shown across the site</p>
                </div>

                <div class="settings-grid">

                    <div class="form-group">
                        <label>Primary Phone</label>
                        <div class="input-icon-wrap">
                            <span class="input-prefix">📞</span>
                            <input type="tel" wire:model="contact_phone_primary"
                                   placeholder="+977-9856040895">
                        </div>
                        @error('contact_phone_primary') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Secondary Phone</label>
                        <div class="input-icon-wrap">
                            <span class="input-prefix">📞</span>
                            <input type="tel" wire:model="contact_phone_secondary"
                                   placeholder="+977-9855040895">
                        </div>
                        @error('contact_phone_secondary') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Landline / Office</label>
                        <div class="input-icon-wrap">
                            <span class="input-prefix">☎️</span>
                            <input type="tel" wire:model="contact_phone_landline"
                                   placeholder="056-493528">
                        </div>
                        @error('contact_phone_landline') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Primary Email</label>
                        <div class="input-icon-wrap">
                            <span class="input-prefix">✉️</span>
                            <input type="email" wire:model="contact_email_primary"
                                   placeholder="info@hasuedu.com">
                        </div>
                        @error('contact_email_primary') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Secondary Email</label>
                        <div class="input-icon-wrap">
                            <span class="input-prefix">✉️</span>
                            <input type="email" wire:model="contact_email_secondary"
                                   placeholder="support@hasuedu.com">
                        </div>
                        @error('contact_email_secondary') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label>Office Address</label>
                        <textarea wire:model="contact_address" rows="3"
                                  placeholder="Birendra Campus Gate, Bhairahawa-11, Rupandehi"></textarea>
                        @error('contact_address') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label>Google Maps Embed Code
                            <span class="label-hint">Paste the full &lt;iframe&gt; src URL from Google Maps → Share → Embed</span>
                        </label>
                        <textarea wire:model="contact_map_embed" rows="3"
                                  placeholder="https://www.google.com/maps/embed?pb=..."></textarea>
                        @error('contact_map_embed') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                </div>
            </div>

            <div class="settings-actions">
                <button type="submit" class="btn-save" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="saveContact">💾 Save Contact Settings</span>
                    <span wire:loading wire:target="saveContact">Saving…</span>
                </button>
            </div>
        </form>
        @endif

        {{-- ════════════════ SOCIAL ════════════════ --}}
        @if ($activeTab === 'social')
        <form wire:submit="saveSocial">
            <div class="settings-card">
                <div class="settings-card-header">
                    <h2>Social Media Links</h2>
                    <p>Links shown in the header, footer, and contact sections</p>
                </div>

                <div class="settings-grid">

                    @php
                    $socials = [
                        ['key' => 'social_facebook',  'label' => 'Facebook',  'icon' => '🔵', 'placeholder' => 'https://facebook.com/hasuedu'],
                        ['key' => 'social_instagram',  'label' => 'Instagram',  'icon' => '📸', 'placeholder' => 'https://instagram.com/hasuedu'],
                        ['key' => 'social_youtube',   'label' => 'YouTube',   'icon' => '▶️', 'placeholder' => 'https://youtube.com/@hasuedu'],
                        ['key' => 'social_tiktok',    'label' => 'TikTok',    'icon' => '🎵', 'placeholder' => 'https://tiktok.com/@hasuedu'],
                        ['key' => 'social_linkedin',  'label' => 'LinkedIn',  'icon' => '💼', 'placeholder' => 'https://linkedin.com/company/hasuedu'],
                        ['key' => 'social_twitter',   'label' => 'Twitter / X','icon' => '🐦', 'placeholder' => 'https://twitter.com/hasuedu'],
                        ['key' => 'social_whatsapp',  'label' => 'WhatsApp',  'icon' => '💬', 'placeholder' => '+9779856040895'],
                    ];
                    @endphp

                    @foreach ($socials as $social)
                    <div class="form-group">
                        <label>{{ $social['label'] }}</label>
                        <div class="input-icon-wrap">
                            <span class="input-prefix">{{ $social['icon'] }}</span>
                            <input type="{{ $social['key'] === 'social_whatsapp' ? 'tel' : 'url' }}"
                                   wire:model="{{ $social['key'] }}"
                                   placeholder="{{ $social['placeholder'] }}">
                        </div>
                        @error($social['key']) <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    @endforeach

                </div>
            </div>

            <div class="settings-actions">
                <button type="submit" class="btn-save" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="saveSocial">💾 Save Social Settings</span>
                    <span wire:loading wire:target="saveSocial">Saving…</span>
                </button>
            </div>
        </form>
        @endif

        {{-- ════════════════ SEO ════════════════ --}}
        @if ($activeTab === 'seo')
        <form wire:submit="saveSeo">
            <div class="settings-card">
                <div class="settings-card-header">
                    <h2>SEO & Analytics</h2>
                    <p>Meta tags and tracking codes for search engines and analytics</p>
                </div>

                <div class="settings-grid">

                    <div class="form-group form-group--full">
                        <label>Meta Title
                            <span class="label-hint">Recommended: 50–60 characters</span>
                        </label>
                        <input type="text" wire:model="seo_meta_title"
                               placeholder="HASU Educational Consultancy – Study Abroad from Nepal"
                               maxlength="160">
                        <div class="char-count">{{ strlen($seo_meta_title) }} / 160</div>
                        @error('seo_meta_title') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label>Meta Description
                            <span class="label-hint">Recommended: 150–160 characters</span>
                        </label>
                        <textarea wire:model="seo_meta_description" rows="3"
                                  placeholder="HASU is Nepal's trusted educational consultancy for studying in Japan, Australia, Canada, UK, USA and more."
                                  maxlength="320"></textarea>
                        <div class="char-count">{{ strlen($seo_meta_description) }} / 320</div>
                        @error('seo_meta_description') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label>Meta Keywords
                            <span class="label-hint">Comma separated</span>
                        </label>
                        <textarea wire:model="seo_meta_keywords" rows="2"
                                  placeholder="study abroad Nepal, educational consultancy Bhairahawa, IELTS coaching Nepal"></textarea>
                        @error('seo_meta_keywords') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Google Analytics ID
                            <span class="label-hint">e.g. G-XXXXXXXXXX</span>
                        </label>
                        <input type="text" wire:model="seo_google_analytics"
                               placeholder="G-XXXXXXXXXX">
                        @error('seo_google_analytics') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Google Tag Manager ID
                            <span class="label-hint">e.g. GTM-XXXXXXX</span>
                        </label>
                        <input type="text" wire:model="seo_google_tag"
                               placeholder="GTM-XXXXXXX">
                        @error('seo_google_tag') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    {{-- OG Image --}}
                    <div class="form-group form-group--full">
                        <label>OG / Social Share Image
                            <span class="label-hint">Recommended: 1200×630px, max 2MB</span>
                        </label>
                        <div class="upload-box upload-box--wide" x-data="{ dragging: false }"
                             @dragover.prevent="dragging = true"
                             @dragleave.prevent="dragging = false"
                             @drop.prevent="dragging = false"
                             :class="{ 'dragging': dragging }">

                            @if ($seo_og_image)
                                <img src="{{ $seo_og_image->temporaryUrl() }}"
                                     class="upload-preview upload-preview--wide" alt="OG preview">
                            @elseif ($seo_og_image_current)
                                <img src="{{ Storage::url($seo_og_image_current) }}"
                                     class="upload-preview upload-preview--wide" alt="Current OG image">
                            @else
                                <div class="upload-placeholder">
                                    <span>🌐</span>
                                    <small>Click or drag to upload social share image</small>
                                    <small>PNG, JPG, WebP · 1200×630 recommended · Max 2MB</small>
                                </div>
                            @endif

                            <input type="file" wire:model="seo_og_image"
                                   accept="image/*" class="upload-input">
                        </div>
                        @error('seo_og_image') <span class="field-error">{{ $message }}</span> @enderror
                        <div wire:loading wire:target="seo_og_image" class="upload-loading">Uploading…</div>
                    </div>

                    {{-- SERP Preview --}}
                    <div class="form-group form-group--full">
                        <label>Search Engine Preview</label>
                        <div class="serp-preview">
                            <div class="serp-title">{{ $seo_meta_title ?: 'Your page title will appear here' }}</div>
                            <div class="serp-url">{{ config('app.url') }}</div>
                            <div class="serp-desc">{{ $seo_meta_description ?: 'Your meta description will appear here. Make it compelling to improve click-through rates from search results.' }}</div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="settings-actions">
                <button type="submit" class="btn-save" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="saveSeo">💾 Save SEO Settings</span>
                    <span wire:loading wire:target="saveSeo">Saving…</span>
                </button>
            </div>
        </form>
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