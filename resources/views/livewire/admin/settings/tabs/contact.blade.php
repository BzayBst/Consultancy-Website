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
                            
                            <input type="tel" wire:model="contact_phone_primary"
                                   placeholder="+977-9856040895">
                        </div>
                        @error('contact_phone_primary') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Secondary Phone</label>
                        <div class="input-icon-wrap">
                            
                            <input type="tel" wire:model="contact_phone_secondary"
                                   placeholder="+977-9855040895">
                        </div>
                        @error('contact_phone_secondary') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Landline / Office</label>
                        <div class="input-icon-wrap">
                            
                            <input type="tel" wire:model="contact_phone_landline"
                                   placeholder="056-493528">
                        </div>
                        @error('contact_phone_landline') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Primary Email</label>
                        <div class="input-icon-wrap">
                           
                            <input type="email" wire:model="contact_email_primary"
                                   placeholder="info@hasuedu.com">
                        </div>
                        @error('contact_email_primary') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Secondary Email</label>
                        <div class="input-icon-wrap">
                           
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