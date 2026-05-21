<form wire:submit="saveSocial">
            <div class="settings-card">
                <div class="settings-card-header">
                    <h2>Social Media Links</h2>
                    <p>Links shown in the header, footer, and contact sections</p>
                </div>

                <div class="settings-grid">

                    @php
                    $socials = [
                        ['key' => 'social_facebook',  'label' => 'Facebook', 'placeholder' => 'https://facebook.com/hasuedu'],
                        ['key' => 'social_instagram',  'label' => 'Instagram', 'placeholder' => 'https://instagram.com/hasuedu'],
                        ['key' => 'social_youtube',   'label' => 'YouTube', 'placeholder' => 'https://youtube.com/@hasuedu'],
                        ['key' => 'social_tiktok',    'label' => 'TikTok', 'placeholder' => 'https://tiktok.com/@hasuedu'],
                        ['key' => 'social_linkedin',  'label' => 'LinkedIn',   'placeholder' => 'https://linkedin.com/company/hasuedu'],
                        ['key' => 'social_twitter',   'label' => 'Twitter / X', 'placeholder' => 'https://twitter.com/hasuedu'],
                        ['key' => 'social_whatsapp',  'label' => 'WhatsApp',  'placeholder' => '+9779812345678'],
                    ];
                    @endphp

                    @foreach ($socials as $social)
                    <div class="form-group">
                        <label>{{ $social['label'] }}</label>
                        <div class="input-icon-wrap">
                            
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