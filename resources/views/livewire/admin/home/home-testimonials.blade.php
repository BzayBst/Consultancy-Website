<div class="ht-wrap">
    <div class="ht-header">
        <div>
            <h1>Home - Testimonials</h1>
            <p>Manage the homepage testimonial slider and section heading.</p>
        </div>
        <a href="{{ route('home') }}#testimonials" target="_blank" class="btn-preview">Preview Section</a>
    </div>

    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <form wire:submit="save">
        <div class="ht-card">
            <div class="ht-card-header">
                <h2>Section Text</h2>
            </div>
            <div class="ht-card-body">
                <label class="toggle-row">
                    <input type="checkbox" wire:model="is_active">
                    <span>Show this section on the homepage</span>
                </label>

                <div class="ht-grid-2">
                    <div class="form-group">
                        <label>Section Label</label>
                        <input type="text" wire:model.live="section_label" placeholder="Testimonials And Success Stories">
                        @error('section_label') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Section Title <span>*</span></label>
                        <input type="text" wire:model.live="section_title" placeholder="What Our Students Say">
                        @error('section_title') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group ht-full">
                        <label>Section Subtitle</label>
                        <textarea wire:model.live="section_subtitle" rows="3" placeholder="Short intro shown under the heading"></textarea>
                        @error('section_subtitle') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="ht-card">
            <div class="ht-card-header">
                <div>
                    <h2>Slides</h2>
                    <p>Each item becomes one slide in the homepage testimonial carousel.</p>
                </div>
                <button type="button" wire:click="addTestimonial" class="btn-add">+ Add Slide</button>
            </div>
            <div class="ht-card-body">
                @foreach($testimonials as $i => $testimonial)
                <div class="testimonial-row">
                    <div class="testimonial-row-head">
                        <strong>Slide {{ $i + 1 }}</strong>
                        <button type="button" wire:click="removeTestimonial({{ $i }})" class="btn-remove">Remove</button>
                    </div>
                    <div class="ht-grid-2">
                        <div class="form-group ht-full">
                            <label>Quote</label>
                            <textarea wire:model.live="testimonials.{{ $i }}.quote" rows="4" placeholder="Write testimonial quote"></textarea>
                            @error("testimonials.$i.quote") <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" wire:model.live="testimonials.{{ $i }}.name" placeholder="Student or parent name">
                            @error("testimonials.$i.name") <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Role / Detail</label>
                            <input type="text" wire:model.live="testimonials.{{ $i }}.role" placeholder="University, country, or role">
                            @error("testimonials.$i.role") <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Avatar Text</label>
                            <input type="text" wire:model.live="testimonials.{{ $i }}.avatar" placeholder="AT or icon">
                            @error("testimonials.$i.avatar") <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Rating</label>
                            <input type="number" min="1" max="5" wire:model.live="testimonials.{{ $i }}.rating">
                            @error("testimonials.$i.rating") <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="ht-actions">
            <button type="submit" class="btn-save" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="save">Save Testimonials</span>
                <span wire:loading wire:target="save">Saving...</span>
            </button>
        </div>
    </form>

    <style>
        :root{--navy:#0d1560;--blue:#2952e3;--red:#cc2222;--border:#e2e8f0;--text:#555;--light:#f5f7fb;--radius:8px;--shadow:0 2px 12px rgba(0,0,0,.07)}
        .ht-wrap{padding:32px 28px;max-width:1120px}
        .ht-header{display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;margin-bottom:24px}
        .ht-header h1{font-family:'Playfair Display',serif;font-size:24px;color:var(--navy);margin-bottom:4px}
        .ht-header p{font-size:13px;color:var(--text)}
        .btn-preview{padding:9px 18px;border:1.5px solid var(--border);border-radius:var(--radius);font-size:13px;font-weight:600;color:var(--navy);text-decoration:none;background:#fff}
        .alert-success{padding:12px 18px;border-radius:var(--radius);background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;margin-bottom:20px;font-size:14px}
        .ht-card{background:#fff;border:1px solid var(--border);border-radius:12px;box-shadow:var(--shadow);margin-bottom:20px;overflow:hidden}
        .ht-card-header{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;padding:16px 22px;background:var(--light);border-bottom:1px solid var(--border)}
        .ht-card-header h2{font-size:15px;color:var(--navy);margin-bottom:3px}
        .ht-card-header p{font-size:12px;color:var(--text)}
        .ht-card-body{padding:22px}
        .ht-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:14px 18px}
        .ht-full{grid-column:1/-1}
        .form-group{display:flex;flex-direction:column;gap:6px}
        .form-group label{font-size:13px;font-weight:600;color:var(--navy)}
        .form-group label span,.field-error{color:var(--red)}
        .form-group input,.form-group textarea{width:100%;padding:9px 12px;border:1.5px solid var(--border);border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:14px;outline:none}
        .form-group input:focus,.form-group textarea:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(41,82,227,.1)}
        .field-error{font-size:12px}
        .toggle-row{display:flex;align-items:center;gap:10px;margin-bottom:18px;font-size:13px;font-weight:600;color:var(--navy)}
        .testimonial-row{border:1px solid var(--border);border-radius:10px;padding:16px;margin-bottom:14px;background:#fff}
        .testimonial-row-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px}
        .testimonial-row-head strong{font-size:13px;color:var(--navy)}
        .btn-add,.btn-save{border:none;border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-weight:600;cursor:pointer}
        .btn-add{background:var(--navy);color:#fff;padding:8px 14px;font-size:13px}
        .btn-remove{border:none;background:#fee2e2;color:var(--red);border-radius:6px;padding:6px 10px;font-size:12px;font-weight:700;cursor:pointer}
        .ht-actions{display:flex;justify-content:flex-end;margin-bottom:18px}
        .btn-save{background:var(--red);color:#fff;padding:11px 26px;font-size:14px}
        .btn-save:disabled{opacity:.65;cursor:not-allowed}
        @media(max-width:640px){.ht-wrap{padding:16px}.ht-grid-2{grid-template-columns:1fr}}
    </style>
</div>
