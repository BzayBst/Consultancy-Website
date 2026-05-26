<div class="hs-wrap">
    <div class="hs-header">
        <div>
            <h1>Home - Core Services</h1>
            <p>Manage the "What We Offer" section on the homepage.</p>
        </div>
        <a href="{{ route('home') }}#services" target="_blank" class="btn-preview">Preview Section</a>
    </div>

    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="hs-preview">
        <div class="preview-label">Live Preview</div>
        <div class="preview-head">
            <span>{{ $section_label ?: 'What We Offer' }}</span>
            <h2>{{ $section_title ?: 'Our Core Services' }}</h2>
            @if($section_subtitle)
                <p>{{ $section_subtitle }}</p>
            @endif
        </div>
        <div class="preview-grid">
            @foreach($services as $service)
                @if(trim($service['title'] ?? '') !== '' || trim($service['description'] ?? '') !== '')
                <div class="preview-card">
                    <div class="preview-icon">{{ $service['icon'] ?: '*' }}</div>
                    <h4>{{ $service['title'] }}</h4>
                    <p>{{ $service['description'] }}</p>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    <form wire:submit="save">
        <div class="hs-card">
            <div class="hs-card-header">
                <h2>Section Text</h2>
            </div>
            <div class="hs-card-body">
                <label class="toggle-row">
                    <input type="checkbox" wire:model="is_active">
                    <span>Show this section on the homepage</span>
                </label>

                <div class="hs-grid-2">
                    <div class="form-group">
                        <label>Section Label</label>
                        <input type="text" wire:model.live="section_label" placeholder="What We Offer">
                        @error('section_label') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Section Title <span>*</span></label>
                        <input type="text" wire:model.live="section_title" placeholder="Our Core Services">
                        @error('section_title') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group hs-full">
                        <label>Section Subtitle</label>
                        <textarea wire:model.live="section_subtitle" rows="3" placeholder="Short intro shown under the heading"></textarea>
                        @error('section_subtitle') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="hs-card">
            <div class="hs-card-header">
                <div>
                    <h2>Service Cards</h2>
                    <p>Add, edit, reorder manually, or remove homepage service cards.</p>
                </div>
                <button type="button" wire:click="addService" class="btn-add">+ Add Service</button>
            </div>
            <div class="hs-card-body">
                @foreach($services as $i => $service)
                <div class="service-row">
                    <div class="service-row-head">
                        <strong>Service {{ $i + 1 }}</strong>
                        <button type="button" wire:click="removeService({{ $i }})" class="btn-remove">Remove</button>
                    </div>
                    <div class="hs-grid-2">
                        <div class="form-group">
                            <label>Icon / Symbol</label>
                            <input type="text" wire:model.live="services.{{ $i }}.icon" placeholder="*">
                            @error("services.$i.icon") <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" wire:model.live="services.{{ $i }}.title" placeholder="Admission Guidance">
                            @error("services.$i.title") <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group hs-full">
                            <label>Description</label>
                            <textarea wire:model.live="services.{{ $i }}.description" rows="3" placeholder="Describe this service"></textarea>
                            @error("services.$i.description") <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label>Link Label</label>
                            <input type="text" wire:model.live="services.{{ $i }}.link_label" placeholder="Read More">
                            @error("services.$i.link_label") <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Link URL</label>
                            <input type="text" wire:model.live="services.{{ $i }}.link_url" placeholder="/contact or #courses">
                            @error("services.$i.link_url") <span class="field-error">{{ $message }}</span> @enderror
                        </div> --}}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="hs-actions">
            <button type="submit" class="btn-save" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="save">Save Core Services</span>
                <span wire:loading wire:target="save">Saving...</span>
            </button>
        </div>
    </form>

    <style>
        :root{--navy:#0d1560;--blue:#2952e3;--blue-light:#e8edfd;--red:#cc2222;--border:#e2e8f0;--text:#555;--light:#f5f7fb;--radius:8px;--shadow:0 2px 12px rgba(0,0,0,.07)}
        .hs-wrap{padding:32px 28px;max-width:1120px}
        .hs-header{display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;margin-bottom:24px}
        .hs-header h1{font-family:'Playfair Display',serif;font-size:24px;color:var(--navy);margin-bottom:4px}
        .hs-header p{font-size:13px;color:var(--text)}
        .btn-preview{padding:9px 18px;border:1.5px solid var(--border);border-radius:var(--radius);font-size:13px;font-weight:600;color:var(--navy);text-decoration:none}
        .alert-success{padding:12px 18px;border-radius:var(--radius);background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;margin-bottom:20px;font-size:14px}
        .hs-preview,.hs-card{background:#fff;border:1px solid var(--border);border-radius:12px;box-shadow:var(--shadow);margin-bottom:20px;overflow:hidden}
        .hs-preview{padding:22px}
        .preview-label{font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#94a3b8;margin-bottom:12px}
        .preview-head{text-align:center;max-width:720px;margin:0 auto 22px}
        .preview-head span{font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--red)}
        .preview-head h2{font-family:'Playfair Display',serif;font-size:24px;color:var(--navy);margin:8px 0}
        .preview-head p{font-size:13px;color:var(--text);line-height:1.6}
        .preview-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px}
        .preview-card{border:1px solid var(--border);border-bottom:3px solid var(--blue);border-radius:8px;padding:16px;background:var(--light)}
        .preview-icon{width:42px;height:42px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:var(--blue-light);color:var(--blue);font-size:18px;margin-bottom:10px}
        .preview-card h4{font-size:14px;color:var(--navy);margin-bottom:6px}
        .preview-card p{font-size:12px;color:var(--text);line-height:1.55}
        .hs-card-header{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;padding:16px 22px;background:var(--light);border-bottom:1px solid var(--border)}
        .hs-card-header h2{font-size:15px;color:var(--navy);margin-bottom:3px}
        .hs-card-header p{font-size:12px;color:var(--text)}
        .hs-card-body{padding:22px}
        .hs-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:14px 18px}
        .hs-full{grid-column:1/-1}
        .form-group{display:flex;flex-direction:column;gap:6px}
        .form-group label{font-size:13px;font-weight:600;color:var(--navy)}
        .form-group label span,.field-error{color:var(--red)}
        .form-group input,.form-group textarea{width:100%;padding:9px 12px;border:1.5px solid var(--border);border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:14px;outline:none}
        .form-group input:focus,.form-group textarea:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(41,82,227,.1)}
        .field-error{font-size:12px}
        .toggle-row{display:flex;align-items:center;gap:10px;margin-bottom:18px;font-size:13px;font-weight:600;color:var(--navy)}
        .service-row{border:1px solid var(--border);border-radius:10px;padding:16px;margin-bottom:14px;background:#fff}
        .service-row-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px}
        .service-row-head strong{font-size:13px;color:var(--navy)}
        .btn-add,.btn-save{border:none;border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-weight:600;cursor:pointer}
        .btn-add{background:var(--navy);color:#fff;padding:8px 14px;font-size:13px}
        .btn-remove{border:none;background:#fee2e2;color:var(--red);border-radius:6px;padding:6px 10px;font-size:12px;font-weight:700;cursor:pointer}
        .hs-actions{display:flex;justify-content:flex-end;margin-bottom:18px}
        .btn-save{background:var(--red);color:#fff;padding:11px 26px;font-size:14px}
        .btn-save:disabled{opacity:.65;cursor:not-allowed}
        @media(max-width:900px){.preview-grid{grid-template-columns:1fr 1fr}}
        @media(max-width:640px){.hs-wrap{padding:16px}.hs-grid-2,.preview-grid{grid-template-columns:1fr}}
    </style>
</div>
