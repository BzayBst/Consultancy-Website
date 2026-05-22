{{-- resources/views/livewire/admin/hero/hero-slides.blade.php --}}

<div class="hs-wrap" x-data>

    {{-- ── Page header ──────────────────────────────────────────────── --}}
    <div class="hs-header">
        <div>
            <h1>Hero Slides</h1>
            <p>Manage the homepage hero slider — drag to reorder</p>
        </div>
        <button wire:click="openCreate" class="btn-add">
            + New Slide
        </button>
    </div>

    {{-- ── Flash ───────────────────────────────────────────────────── --}}
    @if (session('success'))
        <div class="alert alert-success" x-data="{ show: true }" x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-end="opacity-0">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- ── Slides list ─────────────────────────────────────────────── --}}
    <div class="hs-list" id="slidesList">
        @forelse ($slides as $slide)
        <div class="hs-card" data-id="{{ $slide['id'] }}">

            {{-- Drag handle --}}
            <div class="hs-drag-handle" title="Drag to reorder">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16"/>
                </svg>
            </div>

            {{-- Slide number --}}
            <div class="hs-order">#{{ $loop->iteration }}</div>

            {{-- Thumbnail --}}
            <div class="hs-thumb">
                @if (!empty($slide['image_path']))
                    @if (str_starts_with($slide['image_path'], 'http'))
                        <img src="{{ $slide['image_path'] }}" alt="{{ $slide['image_alt'] ?? '' }}">
                    @else
                        <img src="{{ Storage::url($slide['image_path']) }}" alt="{{ $slide['image_alt'] ?? '' }}">
                    @endif
                @else
                    <div class="hs-thumb-empty">🖼️</div>
                @endif
            </div>

            {{-- Content preview --}}
            <div class="hs-content">
                <div class="hs-badge-preview">{{ $slide['badge'] ?? '—' }}</div>
                <div class="hs-title-preview">
                    {{ $slide['title_line1'] ?? '' }}
                    @if(!empty($slide['title_highlight']))
                        <span class="hs-highlight">{{ $slide['title_highlight'] }}</span>
                    @endif
                    {{ $slide['title_line3'] ?? '' }}
                </div>
                <div class="hs-desc-preview">{{ Str::limit($slide['description'] ?? '', 80) }}</div>
                <div class="hs-feats-preview">
                    @foreach (($slide['features'] ?? []) as $feat)
                        @if(!empty($feat['label']))
                            <span class="hs-feat-chip">{{ $feat['icon'] ?? '' }} {{ $feat['label'] }}</span>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Actions --}}
            <div class="hs-actions">
                {{-- Active toggle --}}
                <button wire:click="toggleActive({{ $slide['id'] }})"
                        class="hs-toggle {{ $slide['is_active'] ? 'active' : 'inactive' }}"
                        title="{{ $slide['is_active'] ? 'Active — click to deactivate' : 'Inactive — click to activate' }}">
                    {{ $slide['is_active'] ? '✅ Active' : '⭕ Inactive' }}
                </button>

                {{-- Edit --}}
                <button wire:click="openEdit({{ $slide['id'] }})" class="hs-btn-edit" title="Edit">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit
                </button>

                {{-- Delete --}}
                <button wire:click="confirmDelete({{ $slide['id'] }})" class="hs-btn-delete" title="Delete">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Delete
                </button>
            </div>

        </div>
        @empty
            <div class="hs-empty">
                <span>🖼️</span>
                <p>No hero slides yet. Click <strong>+ New Slide</strong> to add the first one.</p>
            </div>
        @endforelse
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         CREATE / EDIT MODAL
    ══════════════════════════════════════════════════════════════ --}}
    @if ($showModal)
    <div class="modal-backdrop" x-data x-init="document.body.style.overflow='hidden'"
         x-on:keydown.escape.window="$wire.showModal = false">

        <div class="modal-box modal-lg" @click.outside="$wire.showModal = false">

            <div class="modal-head">
                <h2>{{ $editingId ? 'Edit Slide' : 'New Slide' }}</h2>
                <button class="modal-close" wire:click="$set('showModal', false)">✕</button>
            </div>

            <div class="modal-body">
                <form wire:submit="save" id="slideForm">

                    {{-- ── Section: Badge ── --}}
                    <div class="form-section">
                        <div class="form-section-title">Badge & Status</div>
                        <div class="form-row-2">
                            <div class="form-group">
                                <label>Badge Text</label>
                                <input type="text" wire:model="badge"
                                       placeholder="Building Bright Futures With HASU">
                                @error('badge') <span class="field-error">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label>Plane / Accent Emoji</label>
                                <input type="text" wire:model="plane_emoji" placeholder="✈️" maxlength="10">
                                @error('plane_emoji') <span class="field-error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" wire:model="is_active">
                                <span>Active (visible on website)</span>
                            </label>
                        </div>
                    </div>

                    {{-- ── Section: Title ── --}}
                    <div class="form-section">
                        <div class="form-section-title">Title Lines</div>
                        <div class="title-preview-box">
                            <span>{{ $title_line1 }}</span>
                            @if($title_line2) <span> {{ $title_line2 }}</span> @endif
                            @if($title_highlight) <span class="hs-highlight"> {{ $title_highlight }}</span> @endif
                            @if($title_line3) <span> {{ $title_line3 }}</span> @endif
                        </div>
                        <div class="form-row-2">
                            <div class="form-group">
                                <label>Line 1 <span class="req">*</span></label>
                                <input type="text" wire:model.live="title_line1"
                                       placeholder="Shaping Educational">
                                @error('title_line1') <span class="field-error">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label>Line 2</label>
                                <input type="text" wire:model.live="title_line2"
                                       placeholder="And Career">
                            </div>
                            <div class="form-group">
                                <label>Highlighted Word</label>
                                <input type="text" wire:model.live="title_highlight"
                                       placeholder="Dreams">
                                <small class="form-hint">Rendered in accent colour</small>
                            </div>
                            <div class="form-group">
                                <label>Line 3</label>
                                <input type="text" wire:model.live="title_line3"
                                       placeholder="With HASU">
                            </div>
                        </div>
                    </div>

                    {{-- ── Section: Description ── --}}
                    <div class="form-section">
                        <div class="form-section-title">Description</div>
                        <div class="form-group">
                            <textarea wire:model="description" rows="2"
                                      placeholder="Your trusted partner for global education and career success."></textarea>
                            @error('description') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- ── Section: Features ── --}}
                    <div class="form-section">
                        <div class="form-section-title">
                            Feature Icons
                            <button type="button" wire:click="addFeature" class="btn-add-feat">+ Add</button>
                        </div>
                        <div class="features-grid">
                            @foreach ($features as $i => $feat)
                            <div class="feat-row">
                                <input type="text" wire:model="features.{{ $i }}.icon"
                                       class="feat-icon-input" placeholder="🎓" maxlength="10">
                                <input type="text" wire:model="features.{{ $i }}.label"
                                       class="feat-label-input" placeholder="Study Abroad Guidance">
                                <button type="button" wire:click="removeFeature({{ $i }})"
                                        class="feat-remove">✕</button>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ── Section: Buttons ── --}}
                    <div class="form-section">
                        <div class="form-section-title">Call-to-Action Buttons</div>
                        <div class="form-row-2">
                            <div class="form-group">
                                <label>Primary Button Label</label>
                                <input type="text" wire:model="btn_primary_label" placeholder="Get Started">
                            </div>
                            <div class="form-group">
                                <label>Primary Button Link</label>
                                <input type="text" wire:model="btn_primary_href" placeholder="#about">
                            </div>
                            <div class="form-group">
                                <label>Ghost Button Label</label>
                                <input type="text" wire:model="btn_ghost_label" placeholder="Our Services">
                            </div>
                            <div class="form-group">
                                <label>Ghost Button Link</label>
                                <input type="text" wire:model="btn_ghost_href" placeholder="#services">
                            </div>
                        </div>
                    </div>

                    {{-- ── Section: Image ── --}}
                    <div class="form-section">
                        <div class="form-section-title">Slide Image</div>
                        <div class="form-row-2">

                            {{-- Upload --}}
                            <div class="form-group">
                                <label>Upload Image</label>
                                <div class="upload-box" x-data="{ drag: false }"
                                     @dragover.prevent="drag=true"
                                     @dragleave.prevent="drag=false"
                                     @drop.prevent="drag=false"
                                     :class="{ 'dragging': drag }">
                                    @if ($image_upload)
                                        <img src="{{ $image_upload->temporaryUrl() }}" class="upload-prev">
                                    @elseif ($image_current)
                                        <img src="{{ Storage::url($image_current) }}" class="upload-prev">
                                    @else
                                        <div class="upload-ph">
                                            <span>🖼️</span>
                                            <small>PNG, JPG, WebP · Max 3MB</small>
                                        </div>
                                    @endif
                                    <input type="file" wire:model="image_upload"
                                           accept="image/*" class="upload-input">
                                </div>
                                @error('image_upload') <span class="field-error">{{ $message }}</span> @enderror
                                <div wire:loading wire:target="image_upload" class="uploading-msg">Uploading…</div>
                            </div>

                            {{-- OR external URL --}}
                            <div class="form-group">
                                <label>Or External Image URL</label>
                                <input type="url" wire:model="image_url"
                                       placeholder="https://images.unsplash.com/...">
                                @error('image_url') <span class="field-error">{{ $message }}</span> @enderror
                                @if ($image_url && !$image_upload)
                                    <img src="{{ $image_url }}" class="url-preview" alt="preview">
                                @endif
                                <small class="form-hint">Upload takes priority over URL if both are set</small>
                            </div>

                        </div>
                    </div>

                </form>
            </div>{{-- /.modal-body --}}

            <div class="modal-foot">
                <button type="button" wire:click="$set('showModal', false)" class="btn-cancel">
                    Cancel
                </button>
                <button form="slideForm" type="submit" class="btn-save"
                        wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">
                        {{ $editingId ? '💾 Update Slide' : '✨ Create Slide' }}
                    </span>
                    <span wire:loading wire:target="save">Saving…</span>
                </button>
            </div>

        </div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
         DELETE CONFIRM MODAL
    ══════════════════════════════════════════════════════════════ --}}
    @if ($showDeleteModal)
    <div class="modal-backdrop">
        <div class="modal-box modal-sm">
            <div class="modal-head">
                <h2>Delete Slide</h2>
                <button class="modal-close" wire:click="$set('showDeleteModal', false)">✕</button>
            </div>
            <div class="modal-body">
                <div class="delete-confirm">
                    <span class="delete-icon">🗑️</span>
                    <p>Are you sure you want to delete this slide? This action cannot be undone.</p>
                </div>
            </div>
            <div class="modal-foot">
                <button wire:click="$set('showDeleteModal', false)" class="btn-cancel">Cancel</button>
                <button wire:click="delete" class="btn-delete-confirm"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove>Yes, Delete</span>
                    <span wire:loading>Deleting…</span>
                </button>
            </div>
        </div>
    </div>
    @endif

</div>{{-- /.hs-wrap --}}

{{-- SortableJS for drag-to-reorder --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
document.addEventListener('livewire:initialized', () => {
    initSortable();
    Livewire.hook('commit', ({ succeed }) => {
        succeed(() => { setTimeout(initSortable, 50); });
    });
});

function initSortable() {
    const el = document.getElementById('slidesList');
    if (!el || el._sortable) return;
    el._sortable = Sortable.create(el, {
        handle: '.hs-drag-handle',
        animation: 150,
        ghostClass: 'hs-card--ghost',
        onEnd() {
            const ids = [...el.querySelectorAll('.hs-card')]
                .map(c => parseInt(c.dataset.id));
            @this.reorder(ids);
        }
    });
}
</script>

<style>
:root {
    --navy: #0d1560; --blue: #2952e3; --blue-light: #e8edfd;
    --red: #cc2222; --red-dark: #a81a1a;
    --border: #e2e8f0; --text: #555; --light: #f5f7fb;
    --radius: 8px; --shadow: 0 2px 12px rgba(0,0,0,.07);
}

/* ── Page ── */
.hs-wrap { padding: 32px 28px; }
.hs-header {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 24px;
}
.hs-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: 24px; color: var(--navy); margin-bottom: 4px;
}
.hs-header p { font-size: 13px; color: var(--text); }
.btn-add {
    padding: 10px 22px; background: var(--red); color: #fff;
    border: none; border-radius: var(--radius);
    font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 600;
    cursor: pointer; transition: background .2s;
}
.btn-add:hover { background: var(--red-dark); }
.alert {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 18px; border-radius: var(--radius);
    font-size: 14px; font-weight: 500; margin-bottom: 20px;
    background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0;
}

/* ── Slide card ── */
.hs-list { display: flex; flex-direction: column; gap: 12px; }
.hs-card {
    background: #fff; border: 1px solid var(--border);
    border-radius: 10px; padding: 14px 18px;
    display: flex; align-items: center; gap: 16px;
    box-shadow: var(--shadow); transition: box-shadow .2s;
}
.hs-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.1); }
.hs-card--ghost { opacity: .4; background: var(--light); }
.hs-drag-handle {
    cursor: grab; color: #cbd5e1; flex-shrink: 0;
    padding: 4px; border-radius: 4px;
}
.hs-drag-handle:hover { color: var(--navy); background: var(--light); }
.hs-order {
    flex-shrink: 0; width: 28px; text-align: center;
    font-size: 12px; font-weight: 700; color: #94a3b8;
}
.hs-thumb {
    width: 90px; height: 60px; border-radius: 6px; overflow: hidden;
    flex-shrink: 0; background: var(--light);
    display: flex; align-items: center; justify-content: center;
}
.hs-thumb img { width: 100%; height: 100%; object-fit: cover; }
.hs-thumb-empty { font-size: 24px; color: #cbd5e1; }
.hs-content { flex: 1; min-width: 0; }
.hs-badge-preview {
    font-size: 10px; font-weight: 700; letter-spacing: 1.5px;
    text-transform: uppercase; color: var(--red); margin-bottom: 3px;
}
.hs-title-preview {
    font-size: 14px; font-weight: 700; color: var(--navy);
    margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.hs-highlight { color: var(--red); }
.hs-desc-preview { font-size: 12px; color: var(--text); margin-bottom: 6px; }
.hs-feats-preview { display: flex; gap: 6px; flex-wrap: wrap; }
.hs-feat-chip {
    font-size: 11px; background: var(--blue-light); color: var(--navy);
    padding: 2px 8px; border-radius: 20px;
}
.hs-actions {
    display: flex; align-items: center; gap: 8px; flex-shrink: 0; flex-wrap: wrap;
}
.hs-toggle {
    font-size: 12px; font-weight: 600; padding: 5px 12px;
    border: none; border-radius: 20px; cursor: pointer; transition: all .2s;
}
.hs-toggle.active { background: #dcfce7; color: #166534; }
.hs-toggle.inactive { background: #fee2e2; color: #991b1b; }
.hs-btn-edit, .hs-btn-delete {
    display: flex; align-items: center; gap: 5px;
    font-size: 12px; font-weight: 600; padding: 6px 12px;
    border-radius: var(--radius); border: none; cursor: pointer; transition: all .2s;
}
.hs-btn-edit { background: var(--blue-light); color: var(--blue); }
.hs-btn-edit:hover { background: var(--blue); color: #fff; }
.hs-btn-delete { background: #fee2e2; color: var(--red); }
.hs-btn-delete:hover { background: var(--red); color: #fff; }
.hs-empty {
    text-align: center; padding: 60px 20px; color: #94a3b8;
    font-size: 15px; background: #fff; border-radius: 10px; border: 1px dashed var(--border);
}
.hs-empty span { display: block; font-size: 40px; margin-bottom: 12px; }

/* ── Modal ── */
.modal-backdrop {
    position: fixed; inset: 0; z-index: 1000;
    background: rgba(13,21,96,.45); backdrop-filter: blur(3px);
    display: flex; align-items: center; justify-content: center; padding: 20px;
}
.modal-box {
    background: #fff; border-radius: 14px;
    box-shadow: 0 20px 60px rgba(0,0,0,.25);
    width: 100%; display: flex; flex-direction: column;
    max-height: 90vh; overflow: hidden;
}
.modal-sm { max-width: 400px; }
.modal-lg { max-width: 860px; }
.modal-head {
    display: flex; justify-content: space-between; align-items: center;
    padding: 20px 24px 16px; border-bottom: 1px solid var(--border);
    flex-shrink: 0;
}
.modal-head h2 {
    font-family: 'Playfair Display', serif; font-size: 20px; color: var(--navy);
}
.modal-close {
    background: none; border: none; font-size: 18px;
    cursor: pointer; color: #94a3b8; padding: 2px 6px;
    border-radius: 4px; transition: all .2s;
}
.modal-close:hover { background: var(--light); color: var(--navy); }
.modal-body {
    flex: 1; overflow-y: auto; padding: 24px;
}
.modal-foot {
    display: flex; justify-content: flex-end; gap: 10px;
    padding: 16px 24px; border-top: 1px solid var(--border); flex-shrink: 0;
}
.btn-cancel {
    padding: 10px 22px; background: var(--light); color: var(--navy);
    border: 1px solid var(--border); border-radius: var(--radius);
    font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 600;
    cursor: pointer; transition: all .2s;
}
.btn-cancel:hover { background: var(--border); }
.btn-save {
    padding: 10px 26px; background: var(--red); color: #fff;
    border: none; border-radius: var(--radius);
    font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 600;
    cursor: pointer; transition: background .2s;
}
.btn-save:hover:not(:disabled) { background: var(--red-dark); }
.btn-save:disabled { opacity: .65; cursor: not-allowed; }
.btn-delete-confirm {
    padding: 10px 22px; background: var(--red); color: #fff;
    border: none; border-radius: var(--radius);
    font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 600;
    cursor: pointer; transition: background .2s;
}
.btn-delete-confirm:hover:not(:disabled) { background: var(--red-dark); }

/* ── Form sections ── */
.form-section { margin-bottom: 28px; }
.form-section-title {
    font-size: 12px; font-weight: 700; letter-spacing: 1.5px;
    text-transform: uppercase; color: #94a3b8;
    margin-bottom: 14px; display: flex; align-items: center; gap: 10px;
}
.form-row-2 {
    display: grid; grid-template-columns: 1fr 1fr; gap: 14px 20px;
}
.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-group label {
    font-size: 13px; font-weight: 600; color: var(--navy);
}
.form-group input[type="text"],
.form-group input[type="url"],
.form-group textarea {
    width: 100%; padding: 9px 13px;
    border: 1.5px solid var(--border); border-radius: var(--radius);
    font-family: 'DM Sans', sans-serif; font-size: 14px; color: #333;
    outline: none; transition: border-color .2s, box-shadow .2s;
    resize: vertical;
}
.form-group input:focus, .form-group textarea:focus {
    border-color: var(--blue); box-shadow: 0 0 0 3px rgba(41,82,227,.1);
}
.form-hint { font-size: 11px; color: #94a3b8; }
.field-error { font-size: 12px; color: var(--red); }
.req { color: var(--red); }
.checkbox-label {
    display: flex; align-items: center; gap: 8px;
    cursor: pointer; font-size: 13px; color: var(--text);
}
.checkbox-label input { width: 15px; height: 15px; accent-color: var(--blue); }

/* ── Title preview box ── */
.title-preview-box {
    background: var(--navy); color: #fff; border-radius: var(--radius);
    padding: 12px 16px; font-family: 'Playfair Display', serif;
    font-size: 16px; margin-bottom: 14px; min-height: 44px;
}
.title-preview-box .hs-highlight { color: #f4c842; }

/* ── Features ── */
.btn-add-feat {
    font-size: 11px; font-weight: 600; padding: 3px 10px;
    background: var(--blue-light); color: var(--blue);
    border: none; border-radius: 20px; cursor: pointer; margin-left: auto;
}
.features-grid { display: flex; flex-direction: column; gap: 8px; }
.feat-row { display: flex; gap: 8px; align-items: center; }
.feat-icon-input { width: 64px !important; text-align: center; flex-shrink: 0; }
.feat-label-input { flex: 1; }
.feat-remove {
    background: #fee2e2; color: var(--red); border: none;
    width: 28px; height: 28px; border-radius: 50%;
    cursor: pointer; font-size: 12px; flex-shrink: 0; transition: all .2s;
}
.feat-remove:hover { background: var(--red); color: #fff; }

/* ── Upload ── */
.upload-box {
    border: 2px dashed var(--border); border-radius: var(--radius);
    min-height: 120px; position: relative; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden; transition: border-color .2s, background .2s;
}
.upload-box:hover, .upload-box.dragging {
    border-color: var(--blue); background: var(--blue-light);
}
.upload-ph {
    display: flex; flex-direction: column; align-items: center; gap: 6px;
    color: #94a3b8; text-align: center;
}
.upload-ph span { font-size: 28px; }
.upload-ph small { font-size: 12px; }
.upload-prev {
    max-width: 100%; max-height: 120px;
    object-fit: contain; padding: 8px;
}
.upload-input {
    position: absolute; inset: 0; opacity: 0;
    cursor: pointer; width: 100%; height: 100%;
}
.uploading-msg { font-size: 12px; color: var(--blue); margin-top: 4px; }
.url-preview {
    margin-top: 8px; width: 100%; height: 80px;
    object-fit: cover; border-radius: 6px; border: 1px solid var(--border);
}

/* ── Delete confirm modal ── */
.delete-confirm {
    display: flex; flex-direction: column; align-items: center;
    text-align: center; gap: 14px; padding: 12px 0;
}
.delete-icon { font-size: 40px; }
.delete-confirm p { font-size: 15px; color: var(--text); line-height: 1.6; }

@media (max-width: 640px) {
    .hs-wrap { padding: 16px; }
    .hs-card { flex-wrap: wrap; }
    .hs-thumb { width: 70px; height: 50px; }
    .form-row-2 { grid-template-columns: 1fr; }
    .modal-lg { max-width: 100%; }
}
</style>