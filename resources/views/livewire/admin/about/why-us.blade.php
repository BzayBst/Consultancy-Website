{{-- resources/views/livewire/admin/about/why-us.blade.php --}}

<div class="wu-wrap" x-data>

    {{-- ── Header ───────────────────────────────────────────────────── --}}
    <div class="wu-header">
        <div>
            <h1>Why Choose Us</h1>
            <p>Manage the "Reasons Students Trust Us" section on the About page</p>
        </div>
        <a href="{{ route('about') }}#why-us" target="_blank" class="btn-preview">
            👁 Preview Section →
        </a>
    </div>

    {{-- ── Flash ───────────────────────────────────────────────────── --}}
    @if (session('success'))
        <div class="alert alert-success"
             x-data="{ show: true }" x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-end="opacity-0">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- ── Tabs ────────────────────────────────────────────────────── --}}
    <div class="wu-tabs">
        <button wire:click="setTab('section')"
                class="wu-tab {{ $activeTab === 'section' ? 'active' : '' }}">
            <span>⚙️</span> Section Settings
        </button>
        <button wire:click="setTab('features')"
                class="wu-tab {{ $activeTab === 'features' ? 'active' : '' }}">
            <span>📋</span> Feature Cards
            <span class="tab-count">{{ count(array_filter($features, fn($f) => $f['is_active'])) }}/{{ count($features) }}</span>
        </button>
    </div>

    {{-- ════════════════════════════════════════════════════
         TAB 1 — SECTION SETTINGS
    ════════════════════════════════════════════════════ --}}
    @if ($activeTab === 'section')

    {{-- Live Preview --}}
    <div class="section-preview">
        <div class="sp-left">
            <div class="sp-label">{{ $section_label ?: 'Why Choose HASU' }}</div>
            <div class="sp-title">{{ $title ?: 'Reasons Students Trust Us' }}</div>
            <div class="sp-desc">{{ Str::limit($description, 120) }}</div>
            <div class="sp-features-grid">
                @foreach (array_slice(array_filter($features, fn($f) => $f['is_active']), 0, 4) as $f)
                <div class="sp-feat-card">
                    <span class="sp-feat-icon">{{ $f['icon'] }}</span>
                    <strong>{{ $f['title'] }}</strong>
                    <p>{{ Str::limit($f['description'] ?? '', 60) }}</p>
                </div>
                @endforeach
            </div>
        </div>
        <div class="sp-right">
            @if ($image_upload)
                <img src="{{ $image_upload->temporaryUrl() }}" class="sp-image" alt="preview">
            @elseif ($image_current)
                <img src="{{ str_starts_with($image_current, 'http') ? $image_current : Storage::url($image_current) }}"
                     class="sp-image" alt="{{ $image_alt }}">
            @else
                <div class="sp-image-empty">🖼️ No image</div>
            @endif
            @if ($badge_number)
            <div class="sp-badge">
                <strong>{{ $badge_number }}</strong>
                <span>{{ $badge_label }}</span>
            </div>
            @endif
        </div>
    </div>

    <form wire:submit="saveSection">
        <div class="wu-card">
            <div class="wu-card-header">
                <h2>Section Text</h2>
            </div>
            <div class="wu-grid-2" style="padding:24px">
                <div class="form-group">
                    <label>Section Label</label>
                    <input type="text" wire:model.live="section_label"
                           placeholder="Why Choose HASU">
                    @error('section_label') <span class="fe">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Title <span class="req">*</span></label>
                    <input type="text" wire:model.live="title"
                           placeholder="Reasons Students Trust Us">
                    @error('title') <span class="fe">{{ $message }}</span> @enderror
                </div>
                <div class="form-group wu-full">
                    <label>Description</label>
                    <textarea wire:model.live="description" rows="3"
                              placeholder="With over a decade of experience and thousands of successful placements..."></textarea>
                    @error('description') <span class="fe">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="wu-card" style="margin-top:16px">
            <div class="wu-card-header">
                <h2>Image & Badge</h2>
                <p>The image shown on the right side of the section</p>
            </div>
            <div class="wu-grid-2" style="padding:24px">

                {{-- Image upload --}}
                <div class="form-group">
                    <label>Section Image</label>
                    <div class="upload-box" x-data="{ drag: false }"
                         @dragover.prevent="drag=true"
                         @dragleave.prevent="drag=false"
                         @drop.prevent="drag=false"
                         :class="{ 'dragging': drag }">
                        @if ($image_upload)
                            <img src="{{ $image_upload->temporaryUrl() }}" class="upload-prev">
                        @elseif ($image_current)
                            <img src="{{ str_starts_with($image_current,'http') ? $image_current : Storage::url($image_current) }}"
                                 class="upload-prev">
                        @else
                            <div class="upload-ph">
                                <span>🖼️</span>
                                <small>Click or drag · JPG, PNG, WebP · Max 3MB</small>
                            </div>
                        @endif
                        <input type="file" wire:model="image_upload" accept="image/*" class="upload-input">
                    </div>
                    @error('image_upload') <span class="fe">{{ $message }}</span> @enderror
                    <div wire:loading wire:target="image_upload" class="uploading">Uploading…</div>
                </div>

                {{-- Badge + alt --}}
                <div>
                    <div class="form-group">
                        <label>Image Alt Text</label>
                        <input type="text" wire:model="image_alt" placeholder="HASU students">
                        @error('image_alt') <span class="fe">{{ $message }}</span> @enderror
                    </div>

                    <div class="badge-preview-mini" style="margin:16px 0">
                        <strong class="bpm-num">{{ $badge_number ?: '98%' }}</strong>
                        <span class="bpm-label">{{ $badge_label ?: 'Visa Success Rate' }}</span>
                    </div>

                    <div class="wu-grid-2">
                        <div class="form-group">
                            <label>Badge Number / Text</label>
                            <input type="text" wire:model.live="badge_number" placeholder="98%">
                            @error('badge_number') <span class="fe">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Badge Label</label>
                            <input type="text" wire:model.live="badge_label" placeholder="Visa Success Rate">
                            @error('badge_label') <span class="fe">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="wu-actions">
            <button type="submit" class="btn-save" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="saveSection">💾 Save Section Settings</span>
                <span wire:loading wire:target="saveSection">Saving…</span>
            </button>
        </div>
    </form>
    @endif

    {{-- ════════════════════════════════════════════════════
         TAB 2 — FEATURE CARDS
    ════════════════════════════════════════════════════ --}}
    @if ($activeTab === 'features')

    {{-- Cards Preview --}}
    <div class="features-preview-grid">
        @foreach (array_filter($features, fn($f) => $f['is_active']) as $f)
        <div class="fpg-card">
            <span class="fpg-icon">{{ $f['icon'] }}</span>
            <strong>{{ $f['title'] }}</strong>
            <p>{{ Str::limit($f['description'] ?? '', 70) }}</p>
        </div>
        @endforeach
        @if (empty(array_filter($features, fn($f) => $f['is_active'])))
            <div class="fpg-empty">No active feature cards</div>
        @endif
    </div>

    <div class="wu-card">
        <div class="wu-card-header">
            <div>
                <h2>Feature Cards</h2>
                <p>Drag to reorder · Toggle to show/hide on the website</p>
            </div>
            <button type="button" wire:click="openCreateFeature" class="btn-add-sm">
                + Add Feature
            </button>
        </div>

        <div class="wu-list" id="featureList">
            @forelse ($features as $f)
            <div class="wu-list-item" data-id="{{ $f['id'] }}">

                <div class="wu-drag" title="Drag to reorder">⠿</div>

                <div class="wu-feat-icon-display">{{ $f['icon'] }}</div>

                <div class="wu-list-content">
                    <strong>{{ $f['title'] }}</strong>
                    <span>{{ Str::limit($f['description'] ?? '', 80) }}</span>
                </div>

                <div class="wu-list-actions">
                    <button wire:click="toggleFeature({{ $f['id'] }})"
                            class="wu-toggle {{ $f['is_active'] ? 'on' : 'off' }}"
                            title="{{ $f['is_active'] ? 'Active — click to hide' : 'Hidden — click to show' }}">
                        {{ $f['is_active'] ? '✅ Visible' : '⭕ Hidden' }}
                    </button>
                    <button wire:click="openEditFeature({{ $f['id'] }})" class="wu-btn-edit">
                        ✏️ Edit
                    </button>
                    <button wire:click="confirmDelete({{ $f['id'] }})" class="wu-btn-del">
                        🗑 Delete
                    </button>
                </div>

            </div>
            @empty
            <div class="wu-empty">
                <span>📋</span>
                <p>No feature cards yet. Click <strong>+ Add Feature</strong> to create the first one.</p>
            </div>
            @endforelse
        </div>
    </div>
    @endif

    {{-- ════════════════════════════════════════════════════
         FEATURE MODAL (Create / Edit)
    ════════════════════════════════════════════════════ --}}
    @if ($showFeatureModal)
    <div class="modal-backdrop"
         x-data x-on:keydown.escape.window="$wire.showFeatureModal = false">
        <div class="modal-box modal-sm" @click.outside="$wire.showFeatureModal = false">

            <div class="modal-head">
                <h2>{{ $editingFeatureId ? 'Edit Feature Card' : 'Add Feature Card' }}</h2>
                <button class="modal-close" wire:click="$set('showFeatureModal', false)">✕</button>
            </div>

            <div class="modal-body">

                {{-- Live mini-preview --}}
                <div class="feat-modal-preview">
                    <div class="fmp-icon">{{ $f_icon ?: '⭐' }}</div>
                    <div class="fmp-body">
                        <strong>{{ $f_title ?: 'Feature Title' }}</strong>
                        <p>{{ $f_desc ?: 'Feature description will appear here.' }}</p>
                    </div>
                </div>

                <form wire:submit="saveFeature" id="featForm">
                    <div class="wu-grid-2">
                        <div class="form-group">
                            <label>Icon Emoji <span class="req">*</span></label>
                            <input type="text" wire:model.live="f_icon"
                                   placeholder="✅" maxlength="10"
                                   class="icon-input">
                            @error('f_icon') <span class="fe">{{ $message }}</span> @enderror
                            <small class="form-hint">Paste any emoji from your keyboard</small>
                        </div>
                        <div class="form-group">
                            <label>Feature Title <span class="req">*</span></label>
                            <input type="text" wire:model.live="f_title"
                                   placeholder="100% Genuine Assistance">
                            @error('f_title') <span class="fe">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:14px">
                        <label>Description</label>
                        <textarea wire:model.live="f_desc" rows="3"
                                  placeholder="No false promises. Every piece of advice we give is honest, verified, and in your best interest."
                                  maxlength="400"></textarea>
                        <div class="char-count">{{ strlen($f_desc) }} / 400</div>
                        @error('f_desc') <span class="fe">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>

            <div class="modal-foot">
                <button type="button" wire:click="$set('showFeatureModal', false)" class="btn-cancel">
                    Cancel
                </button>
                <button form="featForm" type="submit" class="btn-save"
                        wire:loading.attr="disabled" wire:target="saveFeature">
                    <span wire:loading.remove wire:target="saveFeature">
                        {{ $editingFeatureId ? '💾 Update Feature' : '✨ Create Feature' }}
                    </span>
                    <span wire:loading wire:target="saveFeature">Saving…</span>
                </button>
            </div>

        </div>
    </div>
    @endif

    {{-- ════════════════════════════════════════════════════
         DELETE CONFIRM MODAL
    ════════════════════════════════════════════════════ --}}
    @if ($showDeleteModal)
    <div class="modal-backdrop">
        <div class="modal-box modal-xs">
            <div class="modal-head">
                <h2>Delete Feature</h2>
                <button class="modal-close" wire:click="$set('showDeleteModal', false)">✕</button>
            </div>
            <div class="modal-body">
                <div class="delete-confirm">
                    <span class="delete-icon">🗑️</span>
                    <p>Are you sure you want to delete this feature card? This cannot be undone.</p>
                </div>
            </div>
            <div class="modal-foot">
                <button wire:click="$set('showDeleteModal', false)" class="btn-cancel">Cancel</button>
                <button wire:click="deleteFeature" class="btn-delete-confirm"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove>Delete</span>
                    <span wire:loading>Deleting…</span>
                </button>
            </div>
        </div>
    </div>
    @endif

</div>

{{-- SortableJS --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
document.addEventListener('livewire:initialized', () => initSortable());
Livewire.hook('commit', ({ succeed }) => { succeed(() => setTimeout(initSortable, 60)); });

function initSortable() {
    const el = document.getElementById('featureList');
    if (!el || el._sortable) return;
    el._sortable = Sortable.create(el, {
        handle: '.wu-drag',
        animation: 150,
        ghostClass: 'wu-list-item--ghost',
        onEnd() {
            const ids = [...el.querySelectorAll('.wu-list-item')].map(i => +i.dataset.id);
            @this.reorderFeatures(ids);
        }
    });
}
</script>

<style>
:root {
    --navy:#0d1560;--blue:#2952e3;--blue-light:#e8edfd;
    --red:#cc2222;--red-dark:#a81a1a;
    --border:#e2e8f0;--text:#555;--light:#f5f7fb;
    --radius:8px;--shadow:0 2px 12px rgba(0,0,0,.07);
}

/* ── Page ── */
.wu-wrap   { padding:32px 28px;max-width:1100px; }
.wu-header { display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px; }
.wu-header h1 { font-family:'Playfair Display',serif;font-size:24px;color:var(--navy);margin-bottom:4px; }
.wu-header p  { font-size:13px;color:var(--text); }
.btn-preview  { padding:9px 18px;border:1.5px solid var(--border);border-radius:var(--radius);font-size:13px;font-weight:600;color:var(--navy);text-decoration:none;transition:all .2s; }
.btn-preview:hover { border-color:var(--blue);color:var(--blue); }
.alert { display:flex;align-items:center;gap:10px;padding:12px 18px;border-radius:var(--radius);font-size:14px;font-weight:500;margin-bottom:20px;background:#f0fdf4;color:#166534;border:1px solid #bbf7d0; }

/* ── Tabs ── */
.wu-tabs { display:flex;gap:4px;border-bottom:2px solid var(--border);margin-bottom:24px; }
.wu-tab  { display:flex;align-items:center;gap:8px;padding:10px 22px;background:none;border:none;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:500;color:var(--text);cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-2px;transition:all .2s;border-radius:6px 6px 0 0; }
.wu-tab:hover  { color:var(--navy);background:var(--light); }
.wu-tab.active { color:var(--navy);border-bottom-color:var(--red);background:#fff;font-weight:600; }
.tab-count { font-size:11px;font-weight:700;background:var(--blue-light);color:var(--blue);padding:2px 8px;border-radius:20px; }

/* ── Section preview ── */
.section-preview {
    background:linear-gradient(135deg,var(--navy) 0%,#1a2a8a 55%,#6a0f0f 100%);
    border-radius:14px;padding:28px 32px;margin-bottom:24px;
    display:grid;grid-template-columns:1fr auto;gap:32px;align-items:center;
}
.sp-label { font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#ffaaaa;margin-bottom:8px; }
.sp-title { font-family:'Playfair Display',serif;font-size:22px;color:#fff;margin-bottom:8px; }
.sp-desc  { font-size:13px;color:rgba(255,255,255,.7);margin-bottom:16px;max-width:460px; }
.sp-features-grid { display:grid;grid-template-columns:1fr 1fr;gap:10px; }
.sp-feat-card { background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);border-radius:8px;padding:12px 14px; }
.sp-feat-icon { display:block;font-size:20px;margin-bottom:6px; }
.sp-feat-card strong { display:block;font-size:12px;font-weight:700;color:#fff;margin-bottom:3px; }
.sp-feat-card p { font-size:11px;color:rgba(255,255,255,.6);line-height:1.4;margin:0; }
.sp-right { position:relative;flex-shrink:0; }
.sp-image { width:200px;height:200px;object-fit:cover;border-radius:10px; }
.sp-image-empty { width:200px;height:160px;background:rgba(255,255,255,.08);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:32px;color:rgba(255,255,255,.3); }
.sp-badge { position:absolute;bottom:-12px;left:-12px;background:var(--red);color:#fff;border-radius:8px;padding:12px 16px;text-align:center; }
.sp-badge strong { display:block;font-size:22px;font-weight:700;line-height:1; }
.sp-badge span   { font-size:11px;opacity:.9; }

/* Badge mini preview */
.badge-preview-mini { background:var(--red);color:#fff;border-radius:8px;padding:14px 20px;text-align:center;display:inline-flex;flex-direction:column;align-items:center;gap:4px; }
.bpm-num   { font-family:'Playfair Display',serif;font-size:28px;font-weight:700;line-height:1; }
.bpm-label { font-size:12px;opacity:.9;font-weight:500; }

/* ── Features preview grid ── */
.features-preview-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:24px;background:linear-gradient(135deg,var(--navy) 0%,#1a2a8a 55%,#6a0f0f 100%);border-radius:14px;padding:20px; }
.fpg-card { background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);border-radius:10px;padding:16px; }
.fpg-icon { display:block;font-size:24px;margin-bottom:8px; }
.fpg-card strong { display:block;font-size:13px;font-weight:700;color:#fff;margin-bottom:4px; }
.fpg-card p { font-size:11px;color:rgba(255,255,255,.6);line-height:1.4;margin:0; }
.fpg-empty { grid-column:1/-1;text-align:center;padding:20px;color:rgba(255,255,255,.4);font-size:13px; }

/* ── Cards ── */
.wu-card { background:#fff;border-radius:12px;border:1px solid var(--border);box-shadow:var(--shadow);overflow:hidden; }
.wu-card-header { display:flex;justify-content:space-between;align-items:center;padding:18px 24px 16px;border-bottom:1px solid var(--border);background:var(--light);flex-wrap:wrap;gap:10px; }
.wu-card-header h2 { font-size:16px;font-weight:700;color:var(--navy);margin-bottom:3px; }
.wu-card-header p  { font-size:13px;color:var(--text); }
.wu-actions { display:flex;justify-content:flex-end;margin:16px 0 4px; }
.btn-save { display:inline-flex;align-items:center;gap:8px;padding:10px 26px;background:var(--red);color:#fff;border:none;border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer;transition:background .2s; }
.btn-save:hover:not(:disabled) { background:var(--red-dark); }
.btn-save:disabled { opacity:.65;cursor:not-allowed; }
.btn-add-sm { padding:7px 16px;background:var(--navy);color:#fff;border:none;border-radius:var(--radius);font-size:13px;font-weight:600;cursor:pointer;transition:background .2s;white-space:nowrap; }
.btn-add-sm:hover { background:var(--blue); }

/* ── Form ── */
.wu-grid-2 { display:grid;grid-template-columns:1fr 1fr;gap:14px 20px; }
.wu-full   { grid-column:1/-1; }
.form-group { display:flex;flex-direction:column;gap:6px; }
.form-group label { font-size:13px;font-weight:600;color:var(--navy); }
.form-group input[type="text"],
.form-group textarea {
    width:100%;padding:9px 13px;border:1.5px solid var(--border);border-radius:var(--radius);
    font-family:'DM Sans',sans-serif;font-size:14px;color:#333;
    outline:none;transition:border-color .2s,box-shadow .2s;resize:vertical;
}
.form-group input:focus,.form-group textarea:focus { border-color:var(--blue);box-shadow:0 0 0 3px rgba(41,82,227,.1); }
.icon-input { text-align:center;font-size:20px;letter-spacing:2px; }
.req       { color:var(--red); }
.form-hint { font-size:11px;color:#94a3b8; }
.fe        { font-size:12px;color:var(--red); }
.char-count{ font-size:11px;color:#94a3b8;text-align:right; }

/* ── Upload ── */
.upload-box { border:2px dashed var(--border);border-radius:var(--radius);min-height:120px;position:relative;cursor:pointer;display:flex;align-items:center;justify-content:center;overflow:hidden;transition:border-color .2s,background .2s; }
.upload-box:hover,.upload-box.dragging { border-color:var(--blue);background:var(--blue-light); }
.upload-ph  { display:flex;flex-direction:column;align-items:center;gap:6px;color:#94a3b8;text-align:center; }
.upload-ph span { font-size:28px; }
.upload-ph small{ font-size:12px; }
.upload-prev { max-width:100%;max-height:120px;object-fit:contain;padding:8px; }
.upload-input{ position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%; }
.uploading   { font-size:12px;color:var(--blue);margin-top:4px; }

/* ── List ── */
.wu-list { padding:0 16px 16px; }
.wu-list-item { display:flex;align-items:center;gap:12px;background:#fff;border:1px solid var(--border);border-radius:8px;padding:14px 16px;margin-top:10px;transition:box-shadow .2s; }
.wu-list-item:hover { box-shadow:0 3px 14px rgba(0,0,0,.08); }
.wu-list-item--ghost { opacity:.35;background:var(--light); }
.wu-drag { cursor:grab;color:#cbd5e1;font-size:18px;flex-shrink:0;padding:2px 5px;border-radius:4px; }
.wu-drag:hover { color:var(--navy);background:var(--light); }
.wu-feat-icon-display { font-size:26px;flex-shrink:0;width:36px;text-align:center; }
.wu-list-content { flex:1;min-width:0; }
.wu-list-content strong { display:block;font-size:14px;font-weight:700;color:var(--navy);margin-bottom:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
.wu-list-content span   { font-size:12px;color:var(--text);line-height:1.4; }
.wu-list-actions { display:flex;align-items:center;gap:8px;flex-shrink:0; }
.wu-toggle { font-size:12px;padding:5px 12px;border:none;border-radius:20px;cursor:pointer;font-weight:600;white-space:nowrap;transition:all .2s; }
.wu-toggle.on  { background:#dcfce7;color:#166534; }
.wu-toggle.off { background:#fee2e2;color:#991b1b; }
.wu-btn-edit { font-size:12px;font-weight:600;padding:6px 12px;border-radius:var(--radius);border:none;cursor:pointer;background:var(--blue-light);color:var(--blue);transition:all .2s; }
.wu-btn-edit:hover { background:var(--blue);color:#fff; }
.wu-btn-del  { font-size:12px;font-weight:600;padding:6px 12px;border-radius:var(--radius);border:none;cursor:pointer;background:#fee2e2;color:var(--red);transition:all .2s; }
.wu-btn-del:hover  { background:var(--red);color:#fff; }
.wu-empty { text-align:center;padding:40px;color:#94a3b8;font-size:14px; }
.wu-empty span { display:block;font-size:36px;margin-bottom:10px; }

/* ── Feature modal preview ── */
.feat-modal-preview { background:var(--light);border:1px solid var(--border);border-radius:var(--radius);padding:16px 18px;margin-bottom:18px;display:flex;align-items:flex-start;gap:14px; }
.fmp-icon { font-size:32px;flex-shrink:0;line-height:1; }
.fmp-body strong { display:block;font-size:14px;font-weight:700;color:var(--navy);margin-bottom:4px; }
.fmp-body p      { font-size:12px;color:var(--text);line-height:1.5;margin:0; }

/* ── Modal ── */
.modal-backdrop { position:fixed;inset:0;z-index:1000;background:rgba(13,21,96,.45);backdrop-filter:blur(3px);display:flex;align-items:center;justify-content:center;padding:20px; }
.modal-box { background:#fff;border-radius:14px;box-shadow:0 20px 60px rgba(0,0,0,.25);width:100%;display:flex;flex-direction:column;max-height:90vh;overflow:hidden; }
.modal-xs  { max-width:360px; }
.modal-sm  { max-width:540px; }
.modal-head{ display:flex;justify-content:space-between;align-items:center;padding:18px 24px 14px;border-bottom:1px solid var(--border);flex-shrink:0; }
.modal-head h2 { font-family:'Playfair Display',serif;font-size:18px;color:var(--navy); }
.modal-close { background:none;border:none;font-size:18px;cursor:pointer;color:#94a3b8;padding:2px 6px;border-radius:4px;transition:all .2s; }
.modal-close:hover { background:var(--light);color:var(--navy); }
.modal-body { flex:1;overflow-y:auto;padding:20px 24px; }
.modal-foot { display:flex;justify-content:flex-end;gap:10px;padding:14px 24px;border-top:1px solid var(--border);flex-shrink:0; }
.btn-cancel { padding:9px 20px;background:var(--light);color:var(--navy);border:1px solid var(--border);border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer;transition:all .2s; }
.btn-cancel:hover { background:var(--border); }
.btn-delete-confirm { padding:9px 20px;background:var(--red);color:#fff;border:none;border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer;transition:background .2s; }
.btn-delete-confirm:hover:not(:disabled) { background:var(--red-dark); }
.delete-confirm { display:flex;flex-direction:column;align-items:center;text-align:center;gap:12px;padding:10px 0; }
.delete-icon { font-size:36px; }
.delete-confirm p { font-size:14px;color:var(--text);line-height:1.6; }

@media(max-width:768px){
    .wu-wrap { padding:16px; }
    .wu-tabs { overflow-x:auto; }
    .wu-tab  { padding:10px 14px;font-size:13px;white-space:nowrap; }
    .wu-grid-2 { grid-template-columns:1fr; }
    .features-preview-grid { grid-template-columns:1fr 1fr; }
    .section-preview { grid-template-columns:1fr; }
    .sp-image,.sp-image-empty { width:100%;height:160px; }
}
@media(max-width:480px){
    .features-preview-grid { grid-template-columns:1fr; }
    .wu-list-actions { flex-wrap:wrap; }
}
</style>