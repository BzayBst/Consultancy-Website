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
                        <label>Section Label (Japanese)</label>
                        <input type="text" wire:model.live="section_label_ja" placeholder="お客様の声と成功事例">
                        @error('section_label_ja') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Section Title <span>*</span></label>
                        <input type="text" wire:model.live="section_title" placeholder="What Our Students Say">
                        @error('section_title') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Section Title (Japanese)</label>
                        <input type="text" wire:model.live="section_title_ja" placeholder="学生の声">
                        @error('section_title_ja') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group ht-full">
                        <label>Section Subtitle</label>
                        <textarea wire:model.live="section_subtitle" rows="3" placeholder="Short intro shown under the heading"></textarea>
                        @error('section_subtitle') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group ht-full">
                        <label>Section Subtitle (Japanese)</label>
                        <textarea wire:model.live="section_subtitle_ja" rows="3" placeholder="見出しの下に表示される短い紹介文です。"></textarea>
                        @error('section_subtitle_ja') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="ht-card">
            <div class="ht-card-header">
                <div>
                    <h2>Slides</h2>
                    <p>Each row becomes one slide in the homepage testimonial carousel.</p>
                </div>
                <button type="button" wire:click="openCreateTestimonial" class="btn-add">+ Add Slide</button>
            </div>
            <div class="ht-card-body">
                <div class="testimonial-table-wrap">
                    <table class="testimonial-table">
                        <thead>
                            <tr>
                                <th style="width:56px">Order</th>
                                <th>Quote</th>
                                <th>Name</th>
                                <th>Japanese Name</th>
                                <th style="width:78px">Rating</th>
                                <th style="width:178px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($testimonials as $i => $testimonial)
                                @php $testimonialJa = $testimonials_ja[$i] ?? []; @endphp
                                <tr>
                                    <td>
                                        <div class="order-actions">
                                            <button type="button" wire:click="moveTestimonialUp({{ $i }})" class="btn-icon" @disabled($i === 0) aria-label="Move slide up">↑</button>
                                            <button type="button" wire:click="moveTestimonialDown({{ $i }})" class="btn-icon" @disabled($i === count($testimonials) - 1) aria-label="Move slide down">↓</button>
                                        </div>
                                    </td>
                                    <td><span class="quote-cell">{{ $testimonial['quote'] ?: 'No quote added' }}</span></td>
                                    <td>
                                        <strong>{{ $testimonial['name'] ?: 'Unnamed' }}</strong>
                                        @if(! empty($testimonial['role']))<span class="muted">{{ $testimonial['role'] }}</span>@endif
                                    </td>
                                    <td>
                                        {{ $testimonialJa['name'] ?? '-' }}
                                        @if(! empty($testimonialJa['role']))<span class="muted">{{ $testimonialJa['role'] }}</span>@endif
                                    </td>
                                    <td>{{ (int) ($testimonial['rating'] ?? 5) }}/5</td>
                                    <td>
                                        <div class="table-actions">
                                            <button type="button" wire:click="openEditTestimonial({{ $i }})" class="btn-edit">Edit</button>
                                            <button type="button" wire:click="removeTestimonial({{ $i }})" wire:confirm="Remove this slide?" class="btn-remove">Remove</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <strong>No testimonial slides added yet.</strong>
                                            <span>Use Add Slide to create the first row.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="ht-actions">
            <button type="submit" class="btn-save" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="save">Save Testimonials</span>
                <span wire:loading wire:target="save">Saving...</span>
            </button>
        </div>
    </form>

    @if($showTestimonialModal)
        <div class="modal-backdrop" wire:click="closeTestimonialModal">
            <div class="testimonial-modal" wire:click.stop>
                <div class="modal-header">
                    <div>
                        <h2>{{ $editingTestimonialIndex === null ? 'Add Slide' : 'Edit Slide' }}</h2>
                        <p>Fill the English and Japanese content for this testimonial slide.</p>
                    </div>
                    <button type="button" wire:click="closeTestimonialModal" class="btn-close" aria-label="Close modal">×</button>
                </div>

                <div class="modal-body">
                    <div class="ht-grid-2">
                        <div class="form-group ht-full">
                            <label>Quote</label>
                            <textarea wire:model.live="testimonialForm.quote" rows="4" placeholder="Write testimonial quote"></textarea>
                            @error('testimonialForm.quote') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group ht-full">
                            <label>Quote (Japanese)</label>
                            <textarea wire:model.live="testimonialForm.quote_ja" rows="4" placeholder="お客様の声を日本語で入力してください"></textarea>
                            @error('testimonialForm.quote_ja') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" wire:model.live="testimonialForm.name" placeholder="Student or parent name">
                            @error('testimonialForm.name') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Name (Japanese)</label>
                            <input type="text" wire:model.live="testimonialForm.name_ja" placeholder="氏名">
                            @error('testimonialForm.name_ja') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Role / Detail</label>
                            <input type="text" wire:model.live="testimonialForm.role" placeholder="University, country, or role">
                            @error('testimonialForm.role') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Role / Detail (Japanese)</label>
                            <input type="text" wire:model.live="testimonialForm.role_ja" placeholder="大学、国、役割など">
                            @error('testimonialForm.role_ja') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Avatar Text</label>
                            <input type="text" wire:model.live="testimonialForm.avatar" placeholder="AT or icon">
                            @error('testimonialForm.avatar') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Rating</label>
                            <input type="number" min="1" max="5" wire:model.live="testimonialForm.rating">
                            @error('testimonialForm.rating') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" wire:click="closeTestimonialModal" class="btn-cancel">Cancel</button>
                    <button type="button" wire:click="saveTestimonialModal" class="btn-save">
                        {{ $editingTestimonialIndex === null ? 'Add Slide' : 'Update Slide' }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    <style>
        :root{--navy:#0d1560;--blue:#2952e3;--blue-light:#e8edfd;--red:#cc2222;--border:#e2e8f0;--text:#555;--light:#f5f7fb;--radius:8px;--shadow:0 2px 12px rgba(0,0,0,.07)}
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
        .testimonial-table-wrap{width:100%;overflow-x:auto;border:1px solid var(--border);border-radius:10px}
        .testimonial-table{width:100%;min-width:860px;border-collapse:collapse;background:#fff}
        .testimonial-table th,.testimonial-table td{padding:12px 14px;border-bottom:1px solid var(--border);text-align:left;vertical-align:top;font-size:13px;color:var(--text)}
        .testimonial-table th{background:#f8fafc;color:var(--navy);font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.04em}
        .testimonial-table tr:last-child td{border-bottom:none}
        .testimonial-table strong{display:block;color:var(--navy);font-size:13px}
        .muted{display:block;color:#64748b;font-size:12px;margin-top:3px}
        .quote-cell{display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;line-height:1.5}
        .order-actions,.table-actions{display:flex;align-items:center;gap:6px}
        .btn-icon{width:28px;height:28px;border:1px solid var(--border);border-radius:6px;background:#fff;color:var(--navy);font-weight:700;cursor:pointer}
        .btn-icon:disabled{opacity:.35;cursor:not-allowed}
        .empty-state{display:flex;flex-direction:column;align-items:center;gap:4px;padding:20px;color:var(--text)}
        .empty-state strong{color:var(--navy)}
        .btn-add,.btn-save{border:none;border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-weight:600;cursor:pointer}
        .btn-add{background:var(--navy);color:#fff;padding:8px 14px;font-size:13px}
        .btn-edit{border:none;background:var(--blue-light);color:var(--blue);border-radius:6px;padding:6px 10px;font-size:12px;font-weight:700;cursor:pointer}
        .btn-remove{border:none;background:#fee2e2;color:var(--red);border-radius:6px;padding:6px 10px;font-size:12px;font-weight:700;cursor:pointer}
        .ht-actions{display:flex;justify-content:flex-end;margin-bottom:18px}
        .btn-save{background:var(--red);color:#fff;padding:11px 26px;font-size:14px}
        .btn-save:disabled{opacity:.65;cursor:not-allowed}
        .modal-backdrop{position:fixed;inset:0;z-index:1000;background:rgba(15,23,42,.48);display:flex;align-items:center;justify-content:center;padding:16px;overflow-y:auto}
        .testimonial-modal{width:min(760px,calc(100vw - 32px));max-height:calc(100vh - 32px);overflow:auto;background:#fff;border-radius:12px;box-shadow:0 24px 80px rgba(15,23,42,.25)}
        .modal-header{display:flex;justify-content:space-between;gap:14px;align-items:flex-start;padding:18px 22px;background:var(--light);border-bottom:1px solid var(--border)}
        .modal-header h2{font-size:17px;color:var(--navy);margin-bottom:4px}
        .modal-header p{font-size:12px;color:var(--text)}
        .btn-close{width:32px;height:32px;border:1px solid var(--border);border-radius:50%;background:#fff;color:var(--navy);font-size:20px;line-height:1;cursor:pointer}
        .modal-body{padding:22px}
        .modal-actions{display:flex;justify-content:flex-end;gap:10px;padding:16px 22px;border-top:1px solid var(--border);background:#fff}
        .btn-cancel{border:1px solid var(--border);border-radius:var(--radius);background:#fff;color:var(--navy);padding:10px 18px;font-family:'DM Sans',sans-serif;font-weight:600;cursor:pointer}
        @media(max-width:900px){.testimonial-modal .ht-grid-2{grid-template-columns:1fr}}
        @media(max-width:640px){.ht-wrap{padding:16px}.ht-grid-2{grid-template-columns:1fr}.modal-actions{flex-direction:column-reverse}.modal-actions button{width:100%}}
    </style>
</div>
