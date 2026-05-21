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