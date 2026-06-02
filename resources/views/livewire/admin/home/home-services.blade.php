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
                        <label>Section Label (Japanese)</label>
                        <input type="text" wire:model.live="section_label_ja" placeholder="提供するサービス">
                        @error('section_label_ja') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Section Title <span>*</span></label>
                        <input type="text" wire:model.live="section_title" placeholder="Our Core Services">
                        @error('section_title') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Section Title (Japanese)</label>
                        <input type="text" wire:model.live="section_title_ja" placeholder="コアサービス">
                        @error('section_title_ja') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group hs-full">
                        <label>Section Subtitle</label>
                        <textarea wire:model.live="section_subtitle" rows="3" placeholder="Short intro shown under the heading"></textarea>
                        @error('section_subtitle') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group hs-full">
                        <label>Section Subtitle (Japanese)</label>
                        <textarea wire:model.live="section_subtitle_ja" rows="3" placeholder="見出しの下に表示される短い紹介文です。"></textarea>
                        @error('section_subtitle_ja') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="hs-card">
            <div class="hs-card-header">
                <div>
                    <h2>Services</h2>
                    <p>Add, edit, reorder manually, or remove homepage services.</p>
                </div>
                <button type="button" wire:click="openCreateService" class="btn-add">+ Add Service</button>
            </div>
            <div class="hs-card-body">
                <div class="service-table-wrap">
                    <table class="service-table">
                        <thead>
                            <tr>
                                <th style="width:56px">Order</th>
                                <th style="width:72px">Icon</th>
                                <th>Title</th>
                                <th>Japanese Title</th>
                                <th>Description</th>
                                <th style="width:178px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $i => $service)
                                @php $serviceJa = $services_ja[$i] ?? []; @endphp
                                <tr>
                                    <td>
                                        <div class="order-actions">
                                            <button type="button" wire:click="moveServiceUp({{ $i }})" class="btn-icon" @disabled($i === 0) aria-label="Move service up">↑</button>
                                            <button type="button" wire:click="moveServiceDown({{ $i }})" class="btn-icon" @disabled($i === count($services) - 1) aria-label="Move service down">↓</button>
                                        </div>
                                    </td>
                                    <td><span class="service-icon">{{ $service['icon'] ?: '*' }}</span></td>
                                    <td><strong>{{ $service['title'] ?: 'Untitled service' }}</strong></td>
                                    <td>{{ $serviceJa['title'] ?? '-' }}</td>
                                    <td><span class="description-cell">{{ $service['description'] ?: '-' }}</span></td>
                                    <td>
                                        <div class="table-actions">
                                            <button type="button" wire:click="openEditService({{ $i }})" class="btn-edit">Edit</button>
                                            <button type="button" wire:click="removeService({{ $i }})" wire:confirm="Remove this service?" class="btn-remove">Remove</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <strong>No services added yet.</strong>
                                            <span>Use Add Service to create the first row.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="hs-actions">
            <button type="submit" class="btn-save" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="save">Save Core Services</span>
                <span wire:loading wire:target="save">Saving...</span>
            </button>
        </div>
    </form>

    @if($showServiceModal)
        <div class="modal-backdrop" wire:click="closeServiceModal">
            <div class="service-modal" wire:click.stop>
                <div class="modal-header">
                    <div>
                        <h2>{{ $editingServiceIndex === null ? 'Add Service' : 'Edit Service' }}</h2>
                        <p>Fill the English and Japanese content for this homepage service.</p>
                    </div>
                    <button type="button" wire:click="closeServiceModal" class="btn-close" aria-label="Close modal">×</button>
                </div>

                <div class="modal-body">
                    <div class="hs-grid-2">
                        <div class="form-group">
                            <label>Icon / Symbol</label>
                            <input type="text" wire:model.live="serviceForm.icon" placeholder="*">
                            @error('serviceForm.icon') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" wire:model.live="serviceForm.title" placeholder="Admission Guidance">
                            @error('serviceForm.title') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Title (Japanese)</label>
                            <input type="text" wire:model.live="serviceForm.title_ja" placeholder="入学ガイダンス">
                            @error('serviceForm.title_ja') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Link Label</label>
                            <input type="text" wire:model.live="serviceForm.link_label" placeholder="Read More">
                            @error('serviceForm.link_label') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Link Label (Japanese)</label>
                            <input type="text" wire:model.live="serviceForm.link_label_ja" placeholder="詳細を見る">
                            @error('serviceForm.link_label_ja') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Link URL</label>
                            <input type="text" wire:model.live="serviceForm.link_url" placeholder="/contact or #courses">
                            @error('serviceForm.link_url') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group hs-full">
                            <label>Description</label>
                            <textarea wire:model.live="serviceForm.description" rows="3" placeholder="Describe this service"></textarea>
                            @error('serviceForm.description') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group hs-full">
                            <label>Description (Japanese)</label>
                            <textarea wire:model.live="serviceForm.description_ja" rows="3" placeholder="このサービスについて説明してください"></textarea>
                            @error('serviceForm.description_ja') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" wire:click="closeServiceModal" class="btn-cancel">Cancel</button>
                    <button type="button" wire:click="saveServiceModal" class="btn-save">
                        {{ $editingServiceIndex === null ? 'Add Service' : 'Update Service' }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    <style>
        :root{--navy:#0d1560;--blue:#2952e3;--blue-light:#e8edfd;--red:#cc2222;--border:#e2e8f0;--text:#555;--light:#f5f7fb;--radius:8px;--shadow:0 2px 12px rgba(0,0,0,.07)}
        .hs-wrap{padding:32px 28px;max-width:1120px}
        .hs-header{display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;margin-bottom:24px}
        .hs-header h1{font-family:'Playfair Display',serif;font-size:24px;color:var(--navy);margin-bottom:4px}
        .hs-header p{font-size:13px;color:var(--text)}
        .btn-preview{padding:9px 18px;border:1.5px solid var(--border);border-radius:var(--radius);font-size:13px;font-weight:600;color:var(--navy);text-decoration:none;background:#fff}
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
        .service-table-wrap{width:100%;overflow-x:auto;border:1px solid var(--border);border-radius:10px}
        .service-table{width:100%;min-width:860px;border-collapse:collapse;background:#fff}
        .service-table th,.service-table td{padding:12px 14px;border-bottom:1px solid var(--border);text-align:left;vertical-align:top;font-size:13px;color:var(--text)}
        .service-table th{background:#f8fafc;color:var(--navy);font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.04em}
        .service-table tr:last-child td{border-bottom:none}
        .service-table strong{color:var(--navy);font-size:13px}
        .service-icon{width:34px;height:34px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;background:var(--blue-light);color:var(--blue);font-weight:700}
        .description-cell{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;line-height:1.5}
        .order-actions,.table-actions{display:flex;align-items:center;gap:6px}
        .btn-icon{width:28px;height:28px;border:1px solid var(--border);border-radius:6px;background:#fff;color:var(--navy);font-weight:700;cursor:pointer}
        .btn-icon:disabled{opacity:.35;cursor:not-allowed}
        .empty-state{display:flex;flex-direction:column;align-items:center;gap:4px;padding:20px;color:var(--text)}
        .empty-state strong{color:var(--navy)}
        .btn-add,.btn-save{border:none;border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-weight:600;cursor:pointer}
        .btn-add{background:var(--navy);color:#fff;padding:8px 14px;font-size:13px}
        .btn-edit{border:none;background:var(--blue-light);color:var(--blue);border-radius:6px;padding:6px 10px;font-size:12px;font-weight:700;cursor:pointer}
        .btn-remove{border:none;background:#fee2e2;color:var(--red);border-radius:6px;padding:6px 10px;font-size:12px;font-weight:700;cursor:pointer}
        .hs-actions{display:flex;justify-content:flex-end;margin-bottom:18px}
        .btn-save{background:var(--red);color:#fff;padding:11px 26px;font-size:14px}
        .btn-save:disabled{opacity:.65;cursor:not-allowed}
        .modal-backdrop{position:fixed;inset:0;z-index:1000;background:rgba(15,23,42,.48);display:flex;align-items:center;justify-content:center;padding:16px;overflow-y:auto}
        .service-modal{width:min(720px,calc(100vw - 32px));max-height:calc(100vh - 32px);overflow:auto;background:#fff;border-radius:12px;box-shadow:0 24px 80px rgba(15,23,42,.25)}
        .modal-header{display:flex;justify-content:space-between;gap:14px;align-items:flex-start;padding:18px 22px;background:var(--light);border-bottom:1px solid var(--border)}
        .modal-header h2{font-size:17px;color:var(--navy);margin-bottom:4px}
        .modal-header p{font-size:12px;color:var(--text)}
        .btn-close{width:32px;height:32px;border:1px solid var(--border);border-radius:50%;background:#fff;color:var(--navy);font-size:20px;line-height:1;cursor:pointer}
        .modal-body{padding:22px}
        .modal-actions{display:flex;justify-content:flex-end;gap:10px;padding:16px 22px;border-top:1px solid var(--border);background:#fff}
        .btn-cancel{border:1px solid var(--border);border-radius:var(--radius);background:#fff;color:var(--navy);padding:10px 18px;font-family:'DM Sans',sans-serif;font-weight:600;cursor:pointer}
        @media(max-width:900px){.preview-grid{grid-template-columns:1fr 1fr}.service-modal .hs-grid-2{grid-template-columns:1fr}}
        @media(max-width:640px){.hs-wrap{padding:16px}.hs-grid-2,.preview-grid{grid-template-columns:1fr}.modal-actions{flex-direction:column-reverse}.modal-actions button{width:100%}}
    </style>
</div>
