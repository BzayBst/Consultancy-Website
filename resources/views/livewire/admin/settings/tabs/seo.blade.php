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