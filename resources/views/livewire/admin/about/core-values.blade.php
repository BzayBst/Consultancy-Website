{{-- resources/views/livewire/admin/about/core-values.blade.php --}}

<div class="cv-wrap" x-data>

    {{-- ── Header ───────────────────────────────────────────────────── --}}
    <div class="cv-header">
        <div>
            <h1>Core Values</h1>
            <p>Manage the "Principles We Live By" section on the About Us page</p>
        </div>
        <a href="{{ route('about') }}#values" target="_blank" class="btn-preview">
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
    <div class="cv-tabs">
        <button wire:click="setTab('section')"
                class="cv-tab {{ $activeTab === 'section' ? 'active' : '' }}">
            <span>⚙️</span> Section Header
        </button>
        <button wire:click="setTab('values')"
                class="cv-tab {{ $activeTab === 'values' ? 'active' : '' }}">
            <span>🃏</span> Value Cards
            <span class="tab-badge">
                {{ count(array_filter($values, fn($v) => $v['is_active'])) }}/{{ count($values) }}
            </span>
        </button>
    </div>

    {{-- ════════════════════════════════════════════════════
         TAB 1 — SECTION HEADER
    ════════════════════════════════════════════════════ --}}
    @if ($activeTab === 'section')

    {{-- Live Preview --}}
    <div class="section-header-preview">
        <div class="shp-label">— {{ $section_label ?: 'CORE VALUES' }} —</div>
        <div class="shp-title">{{ $section_title ?: 'The Principles We Live By' }}</div>
        <div class="shp-subtitle">{{ $section_subtitle }}</div>
    </div>

    <form wire:submit="saveSection">
        <div class="cv-card">
            <div class="cv-card-header">
                <h2>Section Header Text</h2>
                <p>The label, title and subtitle shown above the value cards</p>
            </div>
            <div class="cv-grid-2" style="padding:24px">
                <div class="form-group">
                    <label>Section Label <span class="req">*</span></label>
                    <input type="text" wire:model.live="section_label"
                           placeholder="Core Values">
                    @error('section_label') <span class="fe">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Section Title <span class="req">*</span></label>
                    <input type="text" wire:model.live="section_title"
                           placeholder="The Principles We Live By">
                    @error('section_title') <span class="fe">{{ $message }}</span> @enderror
                </div>
                <div class="form-group cv-full">
                    <label>Subtitle / Description</label>
                    <textarea wire:model.live="section_subtitle" rows="2"
                              placeholder="Our values aren't just words on a wall — they shape every interaction, every decision, every outcome."
                              maxlength="400"></textarea>
                    <div class="char-count">{{ strlen($section_subtitle) }} / 400</div>
                    @error('section_subtitle') <span class="fe">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="cv-actions">
            <button type="submit" class="btn-save" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="saveSection">💾 Save Header</span>
                <span wire:loading wire:target="saveSection">Saving…</span>
            </button>
        </div>
    </form>
    @endif

    {{-- ════════════════════════════════════════════════════
         TAB 2 — VALUE CARDS
    ════════════════════════════════════════════════════ --}}
    @if ($activeTab === 'values')

    {{-- Cards Preview — matches the screenshot layout --}}
    <div class="cv-cards-preview">
        @foreach (array_filter($values, fn($v) => $v['is_active']) as $v)
        <div class="cvp-card">
            <div class="cvp-icon-wrap">
                <span class="cvp-icon">{{ $v['icon'] }}</span>
            </div>
            <div class="cvp-body">
                <strong>{{ $v['title'] }}</strong>
                <p>{{ Str::limit($v['description'] ?? '', 80) }}</p>
            </div>
        </div>
        @endforeach
        @if (empty(array_filter($values, fn($v) => $v['is_active'])))
            <p class="cvp-empty">No active value cards</p>
        @endif
    </div>

    <div class="cv-card">
        <div class="cv-card-header">
            <div>
                <h2>Value Cards</h2>
                <p>Drag to reorder · Toggle to show/hide · Each card displays on the website with a left accent border</p>
            </div>
            <button type="button" wire:click="openCreateValue" class="btn-add-sm">
                + Add Value
            </button>
        </div>

        <div class="cv-list" id="valueList">
            @forelse ($values as $v)
            <div class="cv-list-item" data-id="{{ $v['id'] }}">

                {{-- Drag handle --}}
                <div class="cv-drag" title="Drag to reorder">⠿</div>

                {{-- Left accent border indicator --}}
                <div class="cv-accent-bar {{ $v['is_active'] ? 'active' : 'inactive' }}"></div>

                {{-- Icon --}}
                <div class="cv-value-icon">{{ $v['icon'] }}</div>

                {{-- Content --}}
                <div class="cv-list-content">
                    <strong>{{ $v['title'] }}</strong>
                    <span>{{ Str::limit($v['description'] ?? '', 90) }}</span>
                </div>

                {{-- Actions --}}
                <div class="cv-list-actions">
                    <button wire:click="toggleValue({{ $v['id'] }})"
                            class="cv-toggle {{ $v['is_active'] ? 'on' : 'off' }}"
                            title="{{ $v['is_active'] ? 'Visible — click to hide' : 'Hidden — click to show' }}">
                        {{ $v['is_active'] ? '✅ Visible' : '⭕ Hidden' }}
                    </button>
                    <button wire:click="openEditValue({{ $v['id'] }})" class="cv-btn-edit">
                        ✏️ Edit
                    </button>
                    <button wire:click="confirmDelete({{ $v['id'] }})" class="cv-btn-del">
                        🗑 Delete
                    </button>
                </div>

            </div>
            @empty
            <div class="cv-empty">
                <span>🃏</span>
                <p>No value cards yet. Click <strong>+ Add Value</strong> to create the first one.</p>
            </div>
            @endforelse
        </div>
    </div>
    @endif

    {{-- ════════════════════════════════════════════════════
         CREATE / EDIT MODAL
    ════════════════════════════════════════════════════ --}}
    @if ($showValueModal)
    <div class="modal-backdrop"
         x-data x-on:keydown.escape.window="$wire.showValueModal = false">
        <div class="modal-box modal-sm" @click.outside="$wire.showValueModal = false">

            <div class="modal-head">
                <h2>{{ $editingValueId ? 'Edit Value Card' : 'Add Value Card' }}</h2>
                <button class="modal-close" wire:click="$set('showValueModal', false)">✕</button>
            </div>

            <div class="modal-body">

                {{-- Live preview matching the frontend card style --}}
                <div class="value-modal-preview">
                    <div class="vmp-left">
                        <div class="vmp-icon-circle">
                            <span>{{ $v_icon ?: '⭐' }}</span>
                        </div>
                    </div>
                    <div class="vmp-right">
                        <strong>{{ $v_title ?: 'Value Title' }}</strong>
                        <p>{{ $v_desc ?: 'The value description will appear here once you fill in the fields below.' }}</p>
                    </div>
                </div>

                <form wire:submit="saveValue" id="valueForm">
                    <div class="cv-grid-2">
                        <div class="form-group">
                            <label>Icon Emoji <span class="req">*</span></label>
                            <input type="text" wire:model.live="v_icon"
                                   placeholder="🔍" maxlength="10"
                                   class="icon-input"
                                   autocomplete="off">
                            @error('v_icon') <span class="fe">{{ $message }}</span> @enderror
                            <small class="form-hint">Paste any emoji from your keyboard or emoji picker</small>
                        </div>
                        <div class="form-group">
                            <label>Value Title <span class="req">*</span></label>
                            <input type="text" wire:model.live="v_title"
                                   placeholder="Transparency">
                            @error('v_title') <span class="fe">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:14px">
                        <label>Description</label>
                        <textarea wire:model.live="v_desc" rows="3"
                                  placeholder="We share honest timelines, realistic expectations, and complete information so students can make truly informed decisions."
                                  maxlength="500"></textarea>
                        <div class="char-count">{{ strlen($v_desc) }} / 500</div>
                        @error('v_desc') <span class="fe">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>

            <div class="modal-foot">
                <button type="button" wire:click="$set('showValueModal', false)" class="btn-cancel">
                    Cancel
                </button>
                <button form="valueForm" type="submit" class="btn-save"
                        wire:loading.attr="disabled" wire:target="saveValue">
                    <span wire:loading.remove wire:target="saveValue">
                        {{ $editingValueId ? '💾 Update Value' : '✨ Create Value' }}
                    </span>
                    <span wire:loading wire:target="saveValue">Saving…</span>
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
                <h2>Delete Value</h2>
                <button class="modal-close" wire:click="$set('showDeleteModal', false)">✕</button>
            </div>
            <div class="modal-body">
                <div class="delete-confirm">
                    <span class="delete-icon">🗑️</span>
                    <p>Are you sure you want to delete this value card? This cannot be undone.</p>
                </div>
            </div>
            <div class="modal-foot">
                <button wire:click="$set('showDeleteModal', false)" class="btn-cancel">Cancel</button>
                <button wire:click="deleteValue" class="btn-delete-confirm"
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
    const el = document.getElementById('valueList');
    if (!el || el._sortable) return;
    el._sortable = Sortable.create(el, {
        handle: '.cv-drag',
        animation: 150,
        ghostClass: 'cv-list-item--ghost',
        onEnd() {
            const ids = [...el.querySelectorAll('.cv-list-item')].map(i => +i.dataset.id);
            @this.reorderValues(ids);
        }
    });
}
</script>

<style>
:root {
    --navy:#0d1560; --blue:#2952e3; --blue-light:#e8edfd;
    --red:#cc2222;  --red-dark:#a81a1a;
    --border:#e2e8f0; --text:#555; --light:#f5f7fb;
    --radius:8px; --shadow:0 2px 12px rgba(0,0,0,.07);
}

/* ── Page ── */
.cv-wrap   { padding:32px 28px; max-width:1100px; }
.cv-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
.cv-header h1 { font-family:'Playfair Display',serif; font-size:24px; color:var(--navy); margin-bottom:4px; }
.cv-header p  { font-size:13px; color:var(--text); }
.btn-preview  { padding:9px 18px; border:1.5px solid var(--border); border-radius:var(--radius); font-size:13px; font-weight:600; color:var(--navy); text-decoration:none; transition:all .2s; }
.btn-preview:hover { border-color:var(--blue); color:var(--blue); }
.alert { display:flex; align-items:center; gap:10px; padding:12px 18px; border-radius:var(--radius); font-size:14px; font-weight:500; margin-bottom:20px; background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; }

/* ── Tabs ── */
.cv-tabs { display:flex; gap:4px; border-bottom:2px solid var(--border); margin-bottom:24px; }
.cv-tab  { display:flex; align-items:center; gap:8px; padding:10px 22px; background:none; border:none; font-family:'DM Sans',sans-serif; font-size:14px; font-weight:500; color:var(--text); cursor:pointer; border-bottom:2px solid transparent; margin-bottom:-2px; transition:all .2s; border-radius:6px 6px 0 0; }
.cv-tab:hover  { color:var(--navy); background:var(--light); }
.cv-tab.active { color:var(--navy); border-bottom-color:var(--red); background:#fff; font-weight:600; }
.tab-badge { font-size:11px; font-weight:700; background:var(--blue-light); color:var(--blue); padding:2px 8px; border-radius:20px; }

/* ── Section header preview ── */
.section-header-preview {
    background:var(--light); border:1px solid var(--border);
    border-radius:12px; padding:28px 32px; text-align:center;
    margin-bottom:24px;
}
.shp-label {
    font-size:11px; font-weight:700; letter-spacing:2.5px;
    text-transform:uppercase; color:var(--red);
    display:flex; align-items:center; justify-content:center; gap:12px;
    margin-bottom:12px;
}
.shp-label::before, .shp-label::after {
    content:''; display:block; width:32px; height:2px; background:var(--red);
}
.shp-title    { font-family:'Playfair Display',serif; font-size:26px; font-weight:700; color:var(--navy); margin-bottom:10px; }
.shp-subtitle { font-size:14px; color:var(--text); max-width:560px; margin:0 auto; line-height:1.6; }

/* ── Cards preview — matches the screenshot 3-column grid ── */
.cv-cards-preview {
    display:grid; grid-template-columns:repeat(3,1fr); gap:16px;
    margin-bottom:24px;
}
.cvp-card {
    background:#fff; border-radius:10px; border:1px solid var(--border);
    border-left:4px solid var(--blue);
    padding:18px 20px; display:flex; align-items:flex-start; gap:14px;
    box-shadow:var(--shadow); transition:border-left-color .25s;
}
.cvp-card:hover { border-left-color:var(--red); }
.cvp-icon-wrap {
    width:48px; height:48px; border-radius:50%; background:var(--blue-light);
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.cvp-icon  { font-size:22px; }
.cvp-body strong { display:block; font-size:14px; font-weight:700; color:var(--navy); margin-bottom:4px; }
.cvp-body p      { font-size:12px; color:var(--text); line-height:1.5; margin:0; }
.cvp-empty { grid-column:1/-1; text-align:center; padding:20px; font-size:13px; color:#94a3b8; }

/* ── Card ── */
.cv-card { background:#fff; border-radius:12px; border:1px solid var(--border); box-shadow:var(--shadow); overflow:hidden; }
.cv-card-header { display:flex; justify-content:space-between; align-items:center; padding:18px 24px 16px; border-bottom:1px solid var(--border); background:var(--light); flex-wrap:wrap; gap:10px; }
.cv-card-header h2 { font-size:16px; font-weight:700; color:var(--navy); margin-bottom:3px; }
.cv-card-header p  { font-size:13px; color:var(--text); }
.cv-actions { display:flex; justify-content:flex-end; margin:16px 0 4px; }
.btn-save { display:inline-flex; align-items:center; gap:8px; padding:10px 26px; background:var(--red); color:#fff; border:none; border-radius:var(--radius); font-family:'DM Sans',sans-serif; font-size:14px; font-weight:600; cursor:pointer; transition:background .2s; }
.btn-save:hover:not(:disabled) { background:var(--red-dark); }
.btn-save:disabled { opacity:.65; cursor:not-allowed; }
.btn-add-sm { padding:7px 16px; background:var(--navy); color:#fff; border:none; border-radius:var(--radius); font-size:13px; font-weight:600; cursor:pointer; transition:background .2s; white-space:nowrap; }
.btn-add-sm:hover { background:var(--blue); }

/* ── Form ── */
.cv-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:14px 20px; }
.cv-full   { grid-column:1/-1; }
.form-group { display:flex; flex-direction:column; gap:6px; }
.form-group label { font-size:13px; font-weight:600; color:var(--navy); }
.form-group input[type="text"],
.form-group textarea {
    width:100%; padding:9px 13px; border:1.5px solid var(--border);
    border-radius:var(--radius); font-family:'DM Sans',sans-serif;
    font-size:14px; color:#333; outline:none;
    transition:border-color .2s, box-shadow .2s; resize:vertical;
}
.form-group input:focus, .form-group textarea:focus { border-color:var(--blue); box-shadow:0 0 0 3px rgba(41,82,227,.1); }
.icon-input { text-align:center; font-size:20px; letter-spacing:2px; }
.req       { color:var(--red); }
.form-hint { font-size:11px; color:#94a3b8; }
.fe        { font-size:12px; color:var(--red); }
.char-count{ font-size:11px; color:#94a3b8; text-align:right; }

/* ── List ── */
.cv-list { padding:0 16px 16px; }
.cv-list-item {
    display:flex; align-items:center; gap:12px;
    background:#fff; border:1px solid var(--border);
    border-left:4px solid var(--blue);
    border-radius:8px; padding:14px 16px;
    margin-top:10px; transition:box-shadow .2s, border-left-color .2s;
}
.cv-list-item:hover { box-shadow:0 3px 14px rgba(0,0,0,.08); border-left-color:var(--red); }
.cv-list-item--ghost { opacity:.35; background:var(--light); }
.cv-drag  { cursor:grab; color:#cbd5e1; font-size:18px; flex-shrink:0; padding:2px 5px; border-radius:4px; }
.cv-drag:hover { color:var(--navy); background:var(--light); }
.cv-accent-bar { width:0; } /* Visual handled by border-left on item */
.cv-value-icon { font-size:26px; flex-shrink:0; width:36px; text-align:center; }
.cv-list-content { flex:1; min-width:0; }
.cv-list-content strong { display:block; font-size:14px; font-weight:700; color:var(--navy); margin-bottom:3px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.cv-list-content span   { font-size:12px; color:var(--text); line-height:1.4; display:block; }
.cv-list-actions { display:flex; align-items:center; gap:8px; flex-shrink:0; }
.cv-toggle { font-size:12px; padding:5px 12px; border:none; border-radius:20px; cursor:pointer; font-weight:600; white-space:nowrap; transition:all .2s; }
.cv-toggle.on  { background:#dcfce7; color:#166534; }
.cv-toggle.off { background:#fee2e2; color:#991b1b; }
.cv-btn-edit { font-size:12px; font-weight:600; padding:6px 12px; border-radius:var(--radius); border:none; cursor:pointer; background:var(--blue-light); color:var(--blue); transition:all .2s; }
.cv-btn-edit:hover { background:var(--blue); color:#fff; }
.cv-btn-del  { font-size:12px; font-weight:600; padding:6px 12px; border-radius:var(--radius); border:none; cursor:pointer; background:#fee2e2; color:var(--red); transition:all .2s; }
.cv-btn-del:hover  { background:var(--red); color:#fff; }
.cv-empty { text-align:center; padding:40px; color:#94a3b8; font-size:14px; }
.cv-empty span { display:block; font-size:36px; margin-bottom:10px; }

/* ── Value modal preview — matches card style ── */
.value-modal-preview {
    background:var(--light); border:1px solid var(--border);
    border-left:4px solid var(--blue); border-radius:var(--radius);
    padding:18px 20px; margin-bottom:20px;
    display:flex; align-items:flex-start; gap:16px;
}
.vmp-left { flex-shrink:0; }
.vmp-icon-circle {
    width:52px; height:52px; border-radius:50%; background:#fff;
    border:2px solid var(--border); display:flex; align-items:center;
    justify-content:center; font-size:26px; box-shadow:var(--shadow);
}
.vmp-right { flex:1; min-width:0; }
.vmp-right strong { display:block; font-size:15px; font-weight:700; color:var(--navy); margin-bottom:5px; }
.vmp-right p      { font-size:13px; color:var(--text); line-height:1.6; margin:0; }

/* ── Modal ── */
.modal-backdrop { position:fixed; inset:0; z-index:1000; background:rgba(13,21,96,.45); backdrop-filter:blur(3px); display:flex; align-items:center; justify-content:center; padding:20px; }
.modal-box { background:#fff; border-radius:14px; box-shadow:0 20px 60px rgba(0,0,0,.25); width:100%; display:flex; flex-direction:column; max-height:90vh; overflow:hidden; }
.modal-xs  { max-width:360px; }
.modal-sm  { max-width:540px; }
.modal-head{ display:flex; justify-content:space-between; align-items:center; padding:18px 24px 14px; border-bottom:1px solid var(--border); flex-shrink:0; }
.modal-head h2 { font-family:'Playfair Display',serif; font-size:18px; color:var(--navy); }
.modal-close { background:none; border:none; font-size:18px; cursor:pointer; color:#94a3b8; padding:2px 6px; border-radius:4px; transition:all .2s; }
.modal-close:hover { background:var(--light); color:var(--navy); }
.modal-body { flex:1; overflow-y:auto; padding:20px 24px; }
.modal-foot { display:flex; justify-content:flex-end; gap:10px; padding:14px 24px; border-top:1px solid var(--border); flex-shrink:0; }
.btn-cancel { padding:9px 20px; background:var(--light); color:var(--navy); border:1px solid var(--border); border-radius:var(--radius); font-family:'DM Sans',sans-serif; font-size:14px; font-weight:600; cursor:pointer; transition:all .2s; }
.btn-cancel:hover { background:var(--border); }
.btn-delete-confirm { padding:9px 20px; background:var(--red); color:#fff; border:none; border-radius:var(--radius); font-family:'DM Sans',sans-serif; font-size:14px; font-weight:600; cursor:pointer; transition:background .2s; }
.btn-delete-confirm:hover:not(:disabled) { background:var(--red-dark); }
.delete-confirm { display:flex; flex-direction:column; align-items:center; text-align:center; gap:12px; padding:10px 0; }
.delete-icon { font-size:36px; }
.delete-confirm p { font-size:14px; color:var(--text); line-height:1.6; }

@media(max-width:768px) {
    .cv-wrap { padding:16px; }
    .cv-tabs { overflow-x:auto; }
    .cv-tab  { padding:10px 14px; font-size:13px; white-space:nowrap; }
    .cv-grid-2 { grid-template-columns:1fr; }
    .cv-cards-preview { grid-template-columns:1fr 1fr; }
    .cv-list-actions { flex-wrap:wrap; gap:6px; }
}
@media(max-width:480px) {
    .cv-cards-preview { grid-template-columns:1fr; }
}
</style>