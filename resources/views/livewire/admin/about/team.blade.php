{{-- resources/views/livewire/admin/about/team.blade.php --}}

<div class="tm-wrap" x-data>

    {{-- ── Header ───────────────────────────────────────────────────── --}}
    <div class="tm-header">
        <div>
            <h1>Team Members</h1>
            <p>Manage the "Meet the HASU Team" section on the About page</p>
        </div>
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
            <a href="{{ route('about') }}#team" target="_blank" class="btn-preview">
                👁 Preview Section →
            </a>
            <button wire:click="openCreate" class="btn-add-sm">
                + Add Member
            </button>
        </div>
    </div>

    {{-- ── Flash ───────────────────────────────────────────────────── --}}
    @if (session('success'))
        <div class="alert-success"
             x-data="{ show: true }" x-show="show"
             x-init="setTimeout(() => show = false, 3500)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-end="opacity-0">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- ── Filters ──────────────────────────────────────────────────── --}}
    <div class="tm-card" style="margin-bottom:24px">
        <div class="tm-card-header">
            <div>
                <h2>Search & Filters</h2>
                <p>Filter and manage team members</p>
            </div>
            <span class="tab-count">{{ $teams->total() }} Members</span>
        </div>
        <div class="tm-grid-3" style="padding:20px 24px">
            <div class="form-group">
                <label>Search</label>
                <div class="search-wrap">
                    <span class="search-icon">🔍</span>
                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           placeholder="Search name, designation, email…">
                </div>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select wire:model.live="status">
                    <option value="">All Members</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="trashed">Trashed</option>
                </select>
            </div>
            <div class="form-group">
                <label>Per Page</label>
                <select wire:model.live="perPage">
                    <option value="10">10 / page</option>
                    <option value="25">25 / page</option>
                    <option value="50">50 / page</option>
                </select>
            </div>
        </div>
    </div>

    {{-- ── Frontend Preview Cards (matches the public About page design) ── --}}
    <div class="frontend-preview">
        <div class="fp-label-row">
            <span class="fp-line"></span>
            <span class="fp-label">OUR PEOPLE</span>
            <span class="fp-line"></span>
        </div>
        <div class="fp-title">Meet the HASU Team</div>
        <div class="fp-cards">
            @forelse($teams->where('is_active', true)->take(4) as $team)
            <div class="fp-card">
                <div class="fp-card-top">
                    <img src="{{ $team->photo_url }}" alt="{{ $team->name }}" class="fp-photo">
                </div>
                <div class="fp-card-bottom">
                    <strong class="fp-name">{{ $team->name }}</strong>
                    <span class="fp-desg">{{ $team->designation }}</span>
                    @if($team->bio)
                        <p class="fp-bio">{{ Str::limit($team->bio, 80) }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="fp-empty">No active members · Add members below ↓</div>
            @endforelse
        </div>
    </div>

    {{-- ── Members List ──────────────────────────────────────────────── --}}
    <div class="tm-card">
        <div class="tm-card-header">
            <div>
                <h2>All Team Members</h2>
                <p>Drag to reorder · Toggle visibility · Edit or delete</p>
            </div>
            <button wire:click="openCreate" class="btn-add-sm">
                + Add Member
            </button>
        </div>

        <div class="tm-list" id="teamMemberList">
            @forelse($teams as $team)
            <div class="tm-list-item {{ $team->trashed() ? 'is-trashed' : '' }}" data-id="{{ $team->id }}">

                <div class="tm-drag" title="Drag to reorder">⠿</div>

                {{-- Photo --}}
                <div class="tm-thumb">
                    <img src="{{ $team->photo_url }}" alt="{{ $team->name }}">
                </div>

                {{-- Info --}}
                <div class="tm-list-content">
                    <strong>{{ $team->name }}</strong>
                    <span class="tm-desg">{{ $team->designation }}</span>
                    @if($team->email)
                        <span class="tm-email">{{ $team->email }}</span>
                    @endif
                </div>

                {{-- Order --}}
                <div class="tm-order-badge" title="Display order">#{{ $team->order }}</div>

                {{-- Actions --}}
                <div class="tm-list-actions">
                    @if(!$team->trashed())
                        <button wire:click="toggleActive({{ $team->id }})"
                                class="tm-toggle {{ $team->is_active ? 'on' : 'off' }}">
                            {{ $team->is_active ? '✅ Active' : '⭕ Hidden' }}
                        </button>
                        <button wire:click="openEdit({{ $team->id }})" class="tm-btn-edit">
                            ✏️ Edit
                        </button>
                        <button wire:click="confirmDelete({{ $team->id }})" class="tm-btn-del">
                            🗑 Delete
                        </button>
                    @else
                        <span class="tm-trashed-badge">🗑 Trashed</span>
                        <button wire:click="confirmRestore({{ $team->id }})"
                                class="tm-btn-restore">
                            ↩ Restore
                        </button>
                    @endif
                </div>

            </div>
            @empty
            <div class="tm-empty">
                <span>👥</span>
                <p>No team members found. Click <strong>+ Add Member</strong> to get started.</p>
            </div>
            @endforelse
        </div>

        @if($teams->hasPages())
        <div class="tm-pagination">
            <span class="tm-page-info">
                Showing {{ $teams->firstItem() }}–{{ $teams->lastItem() }} of {{ $teams->total() }}
            </span>
            {{ $teams->links() }}
        </div>
        @endif
    </div>


    {{-- ════════════════════════════════════════════════════
         CREATE / EDIT MODAL
    ════════════════════════════════════════════════════ --}}
    @if($showModal)
    <div class="modal-backdrop"
         x-data
         x-on:keydown.escape.window="$wire.closeModal()">
        <div class="modal-box modal-lg" @click.outside="$wire.closeModal()">

            <div class="modal-head">
                <h2>{{ $isEdit ? 'Edit Team Member' : 'Add Team Member' }}</h2>
                <button class="modal-close" wire:click="closeModal">✕</button>
            </div>

            <div class="modal-body">

                {{-- Live preview — matches the public card exactly --}}
                <div class="member-modal-preview">
                    <div class="mmp-card-top">
                        @if($photo)
                            <img src="{{ $photo->temporaryUrl() }}" class="mmp-photo" alt="preview">
                        @elseif($existingPhoto && !$removePhoto)
                            <img src="{{ asset('storage/'.$existingPhoto) }}" class="mmp-photo" alt="current">
                        @else
                            <div class="mmp-avatar">👤</div>
                        @endif
                    </div>
                    <div class="mmp-card-bottom">
                        <strong>{{ $name ?: 'Full Name' }}</strong>
                        <span>{{ $designation ?: 'DESIGNATION' }}</span>
                        <p>{{ $bio ? Str::limit($bio, 80) : 'Bio will appear here.' }}</p>
                    </div>
                </div>

                <form wire:submit="save" id="memberForm">
                    <div class="tm-grid-2">

                        <div class="form-group">
                            <label>Full Name <span class="req">*</span></label>
                            <input type="text" wire:model.live="name"
                                   placeholder="e.g. Ram Prasad Sharma">
                            @error('name') <span class="fe">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Designation <span class="req">*</span></label>
                            <input type="text" wire:model.live="designation"
                                   placeholder="e.g. FOUNDER &amp; CEO">
                            @error('designation') <span class="fe">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Email <span class="form-optional">(optional)</span></label>
                            <input type="email" wire:model="email"
                                   placeholder="name@hasuedu.com">
                            @error('email') <span class="fe">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Phone <span class="form-optional">(optional)</span></label>
                            <input type="text" wire:model="phone"
                                   placeholder="+977-98XXXXXXXX">
                            @error('phone') <span class="fe">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>URL Slug</label>
                            <div class="slug-wrap">
                                <span>/team/</span>
                                <input type="text" wire:model="slug" placeholder="auto-generated">
                            </div>
                            @error('slug') <span class="fe">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Display Order</label>
                            <input type="number" wire:model="order" min="0" placeholder="0">
                            <small class="form-hint">Lower number = appears first</small>
                            @error('order') <span class="fe">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group tm-full">
                            <label>Short Bio</label>
                            <textarea wire:model.live="bio" rows="3" maxlength="500"
                                      placeholder="With 11+ years guiding students abroad…"></textarea>
                            <div style="display:flex;justify-content:space-between;margin-top:4px">
                                @error('bio') <span class="fe">{{ $message }}</span>
                                @else <span></span> @enderror
                                <span class="char-count">{{ strlen($bio) }} / 500</span>
                            </div>
                        </div>

                        {{-- Active toggle --}}
                        <div class="form-group tm-full">
                            <label class="toggle-label">
                                <div class="toggle-switch">
                                    <input type="checkbox" wire:model="is_active" id="modal_is_active">
                                    <span class="toggle-slider"></span>
                                </div>
                                <span>Visible on website</span>
                            </label>
                        </div>

                    </div>

                    {{-- Social Links --}}
                    <div class="tm-section-divider"><span>Social Links <span class="form-optional">(optional)</span></span></div>
                    <div class="tm-grid-3" style="margin-bottom:4px">
                        <div class="form-group">
                            <label>📘 Facebook</label>
                            <input type="url" wire:model="social_facebook"
                                   placeholder="https://facebook.com/…">
                            @error('social_facebook') <span class="fe">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>💼 LinkedIn</label>
                            <input type="url" wire:model="social_linkedin"
                                   placeholder="https://linkedin.com/in/…">
                            @error('social_linkedin') <span class="fe">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>𝕏 Twitter / X</label>
                            <input type="url" wire:model="social_twitter"
                                   placeholder="https://x.com/…">
                            @error('social_twitter') <span class="fe">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Photo --}}
                    <div class="tm-section-divider"><span>Profile Photo</span></div>
                    <div class="tm-grid-2">
                        <div class="form-group">
                            <label>Upload Photo</label>
                            <div class="upload-box" x-data="{ drag:false }"
                                 @dragover.prevent="drag=true"
                                 @dragleave.prevent="drag=false"
                                 @drop.prevent="drag=false"
                                 :class="{ 'dragging': drag }">
                                @if($photo)
                                    <img src="{{ $photo->temporaryUrl() }}" class="upload-prev">
                                @elseif($existingPhoto && !$removePhoto)
                                    <img src="{{ asset('storage/'.$existingPhoto) }}" class="upload-prev">
                                @else
                                    <div class="upload-ph">
                                        <span>🖼️</span>
                                        <small>Click or drag · JPG PNG WebP · Max 2MB<br>Recommended: 400×400 px</small>
                                    </div>
                                @endif
                                <input type="file" wire:model="photo" accept="image/*" class="upload-input">
                            </div>
                            @error('photo') <span class="fe">{{ $message }}</span> @enderror
                            <div wire:loading wire:target="photo" class="uploading">Uploading…</div>
                            @if($existingPhoto && !$photo)
                                <label class="remove-photo-check">
                                    <input type="checkbox" wire:model.live="removePhoto">
                                    <span>Remove current photo</span>
                                </label>
                            @endif
                        </div>
                        <div class="photo-tips">
                            <strong>Photo Tips</strong>
                            <ul>
                                <li>Use a clear, professional headshot</li>
                                <li>Square crop works best (400×400)</li>
                                <li>Neutral or light background preferred</li>
                                <li>JPG, PNG, or WebP format</li>
                                <li>Max file size: 2 MB</li>
                            </ul>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-foot">
                <button type="button" wire:click="closeModal" class="btn-cancel">Cancel</button>
                <button form="memberForm" type="submit" class="btn-save"
                        wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">
                        {{ $isEdit ? '💾 Update Member' : '✨ Add Member' }}
                    </span>
                    <span wire:loading wire:target="save">Saving…</span>
                </button>
            </div>

        </div>
    </div>
    @endif


    {{-- ════════════════════════════════════════════════════
         DELETE CONFIRM MODAL
    ════════════════════════════════════════════════════ --}}
    @if($confirmingDeleteId)
    <div class="modal-backdrop">
        <div class="modal-box modal-xs">
            <div class="modal-head">
                <h2>Move to Trash?</h2>
                <button class="modal-close" wire:click="cancelDelete">✕</button>
            </div>
            <div class="modal-body">
                <div class="delete-confirm">
                    <span class="delete-icon">🗑️</span>
                    <p>This team member will be soft-deleted. You can restore them from the <strong>Trashed</strong> filter.</p>
                </div>
            </div>
            <div class="modal-foot">
                <button wire:click="cancelDelete" class="btn-cancel">Cancel</button>
                <button wire:click="delete" class="btn-delete-confirm" wire:loading.attr="disabled">
                    <span wire:loading.remove>Delete</span>
                    <span wire:loading>Deleting…</span>
                </button>
            </div>
        </div>
    </div>
    @endif


    {{-- ════════════════════════════════════════════════════
         RESTORE CONFIRM MODAL
    ════════════════════════════════════════════════════ --}}
    @if($confirmingRestoreId)
    <div class="modal-backdrop">
        <div class="modal-box modal-xs">
            <div class="modal-head">
                <h2>Restore Member?</h2>
                <button class="modal-close" wire:click="cancelRestore">✕</button>
            </div>
            <div class="modal-body">
                <div class="delete-confirm">
                    <span class="delete-icon">↩️</span>
                    <p>This team member will be restored and become visible on the website again.</p>
                </div>
            </div>
            <div class="modal-foot">
                <button wire:click="cancelRestore" class="btn-cancel">Cancel</button>
                <button wire:click="restore" class="btn-restore-confirm" wire:loading.attr="disabled">
                    <span wire:loading.remove>Restore</span>
                    <span wire:loading>Restoring…</span>
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
    const el = document.getElementById('teamMemberList');
    if (!el || el._sortable) return;
    el._sortable = Sortable.create(el, {
        handle: '.tm-drag',
        animation: 150,
        ghostClass: 'tm-list-item--ghost',
        onEnd() {
            const ids = [...el.querySelectorAll('.tm-list-item')].map(i => +i.dataset.id);
            @this.reorderMembers(ids);
        }
    });
}
</script>

<style>
:root {
    --navy:#0d1560; --blue:#2952e3; --blue-light:#e8edfd;
    --red:#cc2222;  --red-dark:#a81a1a;
    --border:#e2e8f0; --text:#555; --light:#f5f7fb;
    --page-bg:#eef0f8;
    --radius:8px; --shadow:0 2px 12px rgba(0,0,0,.07);
}

/* ── Page ── */
.tm-wrap   { padding:32px 28px; max-width:1100px; }
.tm-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
.tm-header h1 { font-family:'Playfair Display',serif; font-size:26px; color:var(--navy); margin-bottom:4px; font-weight:700; }
.tm-header p  { font-size:13px; color:var(--text); }

.alert-success { display:flex; align-items:center; gap:10px; padding:12px 18px; border-radius:var(--radius); font-size:14px; font-weight:500; margin-bottom:20px; background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; }

.btn-preview { padding:9px 18px; border:1.5px solid var(--border); border-radius:var(--radius); font-size:13px; font-weight:600; color:var(--navy); text-decoration:none; transition:all .2s; background:#fff; }
.btn-preview:hover { border-color:var(--blue); color:var(--blue); }
.btn-add-sm  { padding:9px 18px; background:var(--navy); color:#fff; border:none; border-radius:var(--radius); font-size:13px; font-weight:600; cursor:pointer; transition:background .2s; white-space:nowrap; }
.btn-add-sm:hover { background:var(--blue); }
.tab-count   { font-size:11px; font-weight:700; background:var(--blue-light); color:var(--blue); padding:3px 10px; border-radius:20px; }

/* ── Card ── */
.tm-card { background:#fff; border-radius:12px; border:1px solid var(--border); box-shadow:var(--shadow); overflow:hidden; }
.tm-card-header { display:flex; justify-content:space-between; align-items:center; padding:18px 24px; border-bottom:1px solid var(--border); background:var(--light); flex-wrap:wrap; gap:10px; }
.tm-card-header h2 { font-size:16px; font-weight:700; color:var(--navy); margin-bottom:3px; }
.tm-card-header p  { font-size:13px; color:var(--text); }

/* ── Grids ── */
.tm-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:14px 20px; }
.tm-grid-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px 20px; }
.tm-full   { grid-column:1/-1; }

/* ── Forms ── */
.form-group { display:flex; flex-direction:column; gap:6px; }
.form-group label { font-size:13px; font-weight:600; color:var(--navy); }
.form-optional { font-size:12px; font-weight:400; color:#94a3b8; }
.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="url"],
.form-group input[type="number"],
.form-group textarea,
.form-group select {
    width:100%; padding:9px 13px; border:1.5px solid var(--border); border-radius:var(--radius);
    font-family:'DM Sans',sans-serif; font-size:14px; color:#333;
    outline:none; transition:border-color .2s,box-shadow .2s; background:#fff; resize:vertical;
}
.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus { border-color:var(--blue); box-shadow:0 0 0 3px rgba(41,82,227,.1); }
.req   { color:var(--red); }
.fe    { font-size:12px; color:var(--red); margin-top:2px; }
.form-hint  { font-size:11px; color:#94a3b8; }
.char-count { font-size:11px; color:#94a3b8; }

/* Search wrap */
.search-wrap { display:flex; align-items:center; gap:8px; border:1.5px solid var(--border); border-radius:var(--radius); padding:0 13px; background:#fff; transition:border-color .2s; }
.search-wrap:focus-within { border-color:var(--blue); box-shadow:0 0 0 3px rgba(41,82,227,.1); }
.search-icon { font-size:14px; flex-shrink:0; }
.search-wrap input { flex:1; border:none; outline:none; padding:9px 0; font-family:'DM Sans',sans-serif; font-size:14px; color:#333; background:transparent; }

/* Slug wrap */
.slug-wrap { display:flex; align-items:center; border:1.5px solid var(--border); border-radius:var(--radius); overflow:hidden; transition:border-color .2s; }
.slug-wrap:focus-within { border-color:var(--blue); box-shadow:0 0 0 3px rgba(41,82,227,.1); }
.slug-wrap span { padding:9px 10px 9px 13px; font-size:13px; color:#94a3b8; background:var(--light); white-space:nowrap; border-right:1.5px solid var(--border); }
.slug-wrap input { border:none; outline:none; padding:9px 13px; font-family:'DM Sans',sans-serif; font-size:14px; color:#333; flex:1; box-shadow:none !important; }

/* ── Toggle switch ── */
.toggle-label  { display:flex; align-items:center; gap:10px; cursor:pointer; font-size:14px; font-weight:500; color:var(--navy); }
.toggle-switch { position:relative; width:44px; height:24px; flex-shrink:0; }
.toggle-switch input { opacity:0; width:0; height:0; position:absolute; }
.toggle-slider { position:absolute; inset:0; background:#cbd5e1; border-radius:24px; transition:.3s; cursor:pointer; }
.toggle-slider::before { content:''; position:absolute; left:3px; top:3px; width:18px; height:18px; background:#fff; border-radius:50%; transition:.3s; }
.toggle-switch input:checked + .toggle-slider { background:var(--blue); }
.toggle-switch input:checked + .toggle-slider::before { transform:translateX(20px); }

/* ── Section divider ── */
.tm-section-divider { display:flex; align-items:center; gap:12px; margin:20px 0 14px; font-size:12px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:1px; }
.tm-section-divider::before,.tm-section-divider::after { content:''; flex:1; height:1px; background:var(--border); }

/* ── Upload ── */
.upload-box { border:2px dashed var(--border); border-radius:var(--radius); min-height:120px; position:relative; cursor:pointer; display:flex; align-items:center; justify-content:center; overflow:hidden; transition:border-color .2s,background .2s; }
.upload-box:hover,.upload-box.dragging { border-color:var(--blue); background:var(--blue-light); }
.upload-ph  { display:flex; flex-direction:column; align-items:center; gap:6px; color:#94a3b8; text-align:center; padding:12px; }
.upload-ph span  { font-size:28px; }
.upload-ph small { font-size:12px; line-height:1.5; }
.upload-prev  { max-width:100%; max-height:140px; object-fit:contain; padding:8px; }
.upload-input { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
.uploading    { font-size:12px; color:var(--blue); margin-top:4px; }
.remove-photo-check { display:flex; align-items:center; gap:8px; margin-top:8px; font-size:13px; color:var(--red); cursor:pointer; }

/* ── Photo tips ── */
.photo-tips { padding:16px 18px; background:var(--light); border-radius:var(--radius); border:1px solid var(--border); }
.photo-tips strong { display:block; font-size:13px; font-weight:700; color:var(--navy); margin-bottom:10px; }
.photo-tips ul { margin:0; padding-left:16px; display:flex; flex-direction:column; gap:6px; }
.photo-tips li { font-size:12px; color:var(--text); line-height:1.4; }

/* ── Frontend preview strip ── */
.frontend-preview { background:var(--page-bg); border:1px solid var(--border); border-radius:14px; padding:24px; margin-bottom:24px; text-align:center; }
.fp-label-row { display:flex; align-items:center; justify-content:center; gap:12px; margin-bottom:10px; }
.fp-line  { display:block; width:32px; height:2px; background:var(--red); }
.fp-label { font-size:11px; font-weight:700; letter-spacing:2.5px; text-transform:uppercase; color:var(--red); }
.fp-title { font-family:'Playfair Display',serif; font-size:20px; font-weight:700; color:var(--navy); margin-bottom:18px; }
.fp-cards { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; text-align:left; }
.fp-card  { border-radius:10px; overflow:hidden; box-shadow:var(--shadow); }
.fp-card-top { background:#dde0ef; padding:20px 16px; display:flex; align-items:center; justify-content:center; min-height:100px; }
.fp-photo { width:64px; height:64px; border-radius:50%; object-fit:cover; }
.fp-card-bottom { background:#fff; padding:14px; }
.fp-name  { display:block; font-family:'Playfair Display',serif; font-size:13px; font-weight:700; color:var(--navy); margin-bottom:3px; }
.fp-desg  { display:block; font-size:10px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--red); margin-bottom:6px; }
.fp-bio   { font-size:11px; color:var(--text); line-height:1.4; margin:0; }
.fp-empty { grid-column:1/-1; padding:16px; color:#94a3b8; font-size:13px; }

/* ── List ── */
.tm-list { padding:0 16px 16px; }
.tm-list-item { display:flex; align-items:center; gap:14px; background:#fff; border:1px solid var(--border); border-radius:8px; padding:14px 16px; margin-top:10px; transition:box-shadow .2s; }
.tm-list-item:hover { box-shadow:0 3px 14px rgba(0,0,0,.08); }
.tm-list-item--ghost { opacity:.35; background:var(--light); }
.tm-list-item.is-trashed { opacity:.6; background:#fff5f5; }
.tm-drag { cursor:grab; color:#cbd5e1; font-size:18px; flex-shrink:0; padding:2px 5px; border-radius:4px; }
.tm-drag:hover { color:var(--navy); background:var(--light); }
.tm-thumb { width:48px; height:48px; border-radius:50%; overflow:hidden; flex-shrink:0; border:2px solid var(--border); background:var(--page-bg); }
.tm-thumb img { width:100%; height:100%; object-fit:cover; display:block; }
.tm-list-content { flex:1; min-width:0; }
.tm-list-content strong { display:block; font-size:14px; font-weight:700; color:var(--navy); margin-bottom:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.tm-desg  { display:block; font-size:10px; font-weight:700; letter-spacing:.8px; text-transform:uppercase; color:var(--red); margin-bottom:1px; }
.tm-email { display:block; font-size:12px; color:#94a3b8; }
.tm-order-badge { font-size:11px; font-weight:700; color:#94a3b8; background:var(--light); border:1px solid var(--border); border-radius:20px; padding:3px 10px; flex-shrink:0; }
.tm-list-actions { display:flex; align-items:center; gap:6px; flex-shrink:0; flex-wrap:wrap; }
.tm-toggle { font-size:12px; padding:5px 12px; border:none; border-radius:20px; cursor:pointer; font-weight:600; white-space:nowrap; transition:all .2s; }
.tm-toggle.on  { background:#dcfce7; color:#166534; }
.tm-toggle.off { background:#fee2e2; color:#991b1b; }
.tm-btn-edit { font-size:12px; font-weight:600; padding:6px 12px; border-radius:var(--radius); border:none; cursor:pointer; background:var(--blue-light); color:var(--blue); transition:all .2s; }
.tm-btn-edit:hover { background:var(--blue); color:#fff; }
.tm-btn-del  { font-size:12px; font-weight:600; padding:6px 12px; border-radius:var(--radius); border:none; cursor:pointer; background:#fee2e2; color:var(--red); transition:all .2s; }
.tm-btn-del:hover  { background:var(--red); color:#fff; }
.tm-trashed-badge  { font-size:12px; color:#991b1b; background:#fee2e2; padding:4px 10px; border-radius:20px; font-weight:600; }
.tm-btn-restore { font-size:12px; font-weight:600; padding:6px 12px; border-radius:var(--radius); border:none; cursor:pointer; background:#dcfce7; color:#166534; transition:all .2s; }
.tm-btn-restore:hover { background:#166534; color:#fff; }
.tm-empty { text-align:center; padding:40px; color:#94a3b8; font-size:14px; }
.tm-empty span { display:block; font-size:36px; margin-bottom:10px; }
.tm-pagination { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-top:1px solid var(--border); flex-wrap:wrap; gap:8px; }
.tm-page-info  { font-size:13px; color:var(--text); }

/* ── Modal preview (matches public card) ── */
.member-modal-preview { display:grid; grid-template-columns:160px 1fr; border-radius:10px; overflow:hidden; box-shadow:var(--shadow); margin-bottom:22px; border:1px solid var(--border); }
.mmp-card-top    { background:#dde0ef; display:flex; align-items:center; justify-content:center; padding:20px; min-height:100px; }
.mmp-photo       { width:80px; height:80px; border-radius:50%; object-fit:cover; }
.mmp-avatar      { font-size:52px; line-height:1; }
.mmp-card-bottom { background:#fff; padding:18px 20px; display:flex; flex-direction:column; justify-content:center; }
.mmp-card-bottom strong { display:block; font-family:'Playfair Display',serif; font-size:16px; font-weight:700; color:var(--navy); margin-bottom:4px; }
.mmp-card-bottom span   { display:block; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--red); margin-bottom:8px; }
.mmp-card-bottom p      { font-size:12px; color:var(--text); line-height:1.5; margin:0; }

/* ── Modal ── */
.modal-backdrop { position:fixed; inset:0; z-index:1000; background:rgba(13,21,96,.45); backdrop-filter:blur(3px); display:flex; align-items:center; justify-content:center; padding:20px; }
.modal-box { background:#fff; border-radius:14px; box-shadow:0 20px 60px rgba(0,0,0,.25); width:100%; display:flex; flex-direction:column; max-height:90vh; overflow:hidden; }
.modal-xs  { max-width:360px; }
.modal-lg  { max-width:760px; }
.modal-head { display:flex; justify-content:space-between; align-items:center; padding:18px 24px 14px; border-bottom:1px solid var(--border); flex-shrink:0; }
.modal-head h2 { font-family:'Playfair Display',serif; font-size:18px; color:var(--navy); }
.modal-close { background:none; border:none; font-size:18px; cursor:pointer; color:#94a3b8; padding:2px 6px; border-radius:4px; transition:all .2s; }
.modal-close:hover { background:var(--light); color:var(--navy); }
.modal-body { flex:1; overflow-y:auto; padding:22px 24px; }
.modal-foot { display:flex; justify-content:flex-end; gap:10px; padding:14px 24px; border-top:1px solid var(--border); flex-shrink:0; }
.btn-cancel { padding:9px 20px; background:var(--light); color:var(--navy); border:1px solid var(--border); border-radius:var(--radius); font-family:'DM Sans',sans-serif; font-size:14px; font-weight:600; cursor:pointer; transition:all .2s; }
.btn-cancel:hover { background:var(--border); }
.btn-save { display:inline-flex; align-items:center; gap:8px; padding:10px 26px; background:var(--red); color:#fff; border:none; border-radius:var(--radius); font-family:'DM Sans',sans-serif; font-size:14px; font-weight:600; cursor:pointer; transition:background .2s; }
.btn-save:hover:not(:disabled) { background:var(--red-dark); }
.btn-save:disabled { opacity:.65; cursor:not-allowed; }
.btn-delete-confirm  { padding:9px 20px; background:var(--red); color:#fff; border:none; border-radius:var(--radius); font-family:'DM Sans',sans-serif; font-size:14px; font-weight:600; cursor:pointer; }
.btn-delete-confirm:hover:not(:disabled) { background:var(--red-dark); }
.btn-restore-confirm { padding:9px 20px; background:#166534; color:#fff; border:none; border-radius:var(--radius); font-family:'DM Sans',sans-serif; font-size:14px; font-weight:600; cursor:pointer; }
.delete-confirm { display:flex; flex-direction:column; align-items:center; text-align:center; gap:12px; padding:10px 0; }
.delete-icon { font-size:36px; }
.delete-confirm p { font-size:14px; color:var(--text); line-height:1.6; }

@media(max-width:768px){
    .tm-wrap { padding:16px; }
    .tm-grid-2,.tm-grid-3 { grid-template-columns:1fr; }
    .fp-cards { grid-template-columns:1fr 1fr; }
    .member-modal-preview { grid-template-columns:1fr; }
}
@media(max-width:480px){
    .fp-cards { grid-template-columns:1fr; }
    .tm-list-actions { flex-wrap:wrap; }
}
</style>