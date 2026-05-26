{{-- resources/views/livewire/admin/venture.blade.php --}}

<div class="vt-wrap" x-data>

    {{-- ── Header ── --}}
    <div class="vt-header">
        <div>
            <h1>Ventures</h1>
            <p>Manage the HASU family of ventures shown on the public Ventures page</p>
        </div>
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
            <a href="{{ route('ventures') }}" target="_blank" class="btn-preview">👁 Preview Page →</a>
            <button wire:click="openCreate" class="btn-add-sm">+ Add Venture</button>
        </div>
    </div>

    {{-- ── Flash ── --}}
    @if(session('success'))
    <div class="alert-success" x-data="{show:true}" x-show="show"
         x-init="setTimeout(()=>show=false,3500)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-end="opacity-0">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- ── Filters ── --}}
    <div class="vt-card" style="margin-bottom:24px">
        <div class="vt-card-header">
            <div>
                <h2>Search & Filters</h2>
                <p>Filter and manage ventures</p>
            </div>
            <span class="tab-count">{{ $ventures->total() }} Ventures</span>
        </div>
        <div class="vt-grid-4" style="padding:20px 24px">
            <div class="form-group">
                <label>Search</label>
                <div class="search-wrap">
                    <span>🔍</span>
                    <input type="text" wire:model.live.debounce.300ms="search"
                           placeholder="Name, tagline, location…">
                </div>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select wire:model.live="filterCategory">
                    <option value="">All Categories</option>
                    <option value="education">Education</option>
                    <option value="language">Language</option>
                    <option value="business">Business</option>
                    <option value="innovation">Innovation</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select wire:model.live="filterStatus">
                    <option value="">All Statuses</option>
                    <option value="flagship">Flagship</option>
                    <option value="active">Active</option>
                    <option value="new">New</option>
                    <option value="coming_soon">Coming Soon</option>
                </select>
            </div>
            <div class="form-group">
                <label>Visibility</label>
                <select wire:model.live="filterActive">
                    <option value="">All</option>
                    <option value="active">Visible</option>
                    <option value="inactive">Hidden</option>
                    <option value="trashed">Trashed</option>
                </select>
            </div>
        </div>
    </div>

    {{-- ── Frontend Preview strip ── --}}
    <div class="frontend-preview">
        <div class="fp-label-row">
            <span class="fp-line"></span>
            <span class="fp-label">OUR VENTURES</span>
            <span class="fp-line"></span>
        </div>
        <div class="fp-title">HASU Venture Portfolio</div>
        <div class="fp-grid">
            @foreach($ventures->where('is_active', true)->take(6) as $v)
            <div class="fp-card" style="{{ $v->banner_style }}">
                <div class="fp-card-top">
                    <span class="fp-emoji">{{ $v->emoji }}</span>
                    @if($v->is_featured)<span class="fp-feat-badge">⭐ Featured</span>@endif
                </div>
                <div class="fp-card-body">
                    <div class="fp-tag" style="background:{{ $v->tag_bg ?? '#e8edfd' }};color:{{ $v->tag_color ?? '#2952e3' }}">
                        {{ $v->tag_label ?: ucfirst($v->category) }}
                    </div>
                    <strong>{{ $v->name }}</strong>
                    <p>{{ Str::limit($v->description, 60) }}</p>
                    @if($v->location || $v->established)
                    <div class="fp-meta">
                        @if($v->location)<span>📍 {{ $v->location }}</span>@endif
                        @if($v->established)<span>📅 {{ $v->established }}</span>@endif
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
            @if($ventures->where('is_active', true)->isEmpty())
            <div class="fp-empty">No active ventures yet · Add ventures below ↓</div>
            @endif
        </div>
    </div>

    {{-- ── Ventures list ── --}}
    <div class="vt-card">
        <div class="vt-card-header">
            <div>
                <h2>All Ventures</h2>
                <p>Drag to reorder · Toggle visibility · Edit or delete</p>
            </div>
            <button wire:click="openCreate" class="btn-add-sm">+ Add Venture</button>
        </div>

        <div class="vt-list" id="ventureList">
            @forelse($ventures as $v)
            <div class="vt-list-item {{ $v->trashed() ? 'is-trashed' : '' }}" data-id="{{ $v->id }}">

                <div class="vt-drag" title="Drag to reorder">⠿</div>

                {{-- Banner mini --}}
                <div class="vt-banner-mini" style="{{ $v->banner_style }}">
                    @if($v->banner_image)
                        <img src="{{ asset('storage/'.$v->banner_image) }}" alt="{{ $v->name }}">
                    @else
                        <span>{{ $v->emoji }}</span>
                    @endif
                </div>

                {{-- Info --}}
                <div class="vt-list-content">
                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
                        <strong>{{ $v->name }}</strong>
                        @if($v->is_featured)<span class="vt-feat-badge">⭐ Featured</span>@endif
                        <span class="vt-status-badge {{ $v->status }}">{{ $v->status_label }}</span>
                    </div>
                    <span class="vt-cat">{{ ucfirst($v->category) }}</span>
                    @if($v->location)<span class="vt-loc">📍 {{ $v->location }}</span>@endif
                </div>

                <div class="vt-order-badge">#{{ $v->order }}</div>

                {{-- Actions --}}
                <div class="vt-list-actions">
                    @if(!$v->trashed())
                        <button wire:click="toggleFeatured({{ $v->id }})"
                                class="vt-btn-feat {{ $v->is_featured ? 'active' : '' }}" title="Toggle featured">
                            {{ $v->is_featured ? '⭐' : '☆' }}
                        </button>
                        <button wire:click="toggleActive({{ $v->id }})"
                                class="vt-toggle {{ $v->is_active ? 'on' : 'off' }}">
                            {{ $v->is_active ? '✅ Visible' : '⭕ Hidden' }}
                        </button>
                        <button wire:click="openEdit({{ $v->id }})" class="vt-btn-edit">✏️ Edit</button>
                        <button wire:click="confirmDelete({{ $v->id }})" class="vt-btn-del">🗑 Delete</button>
                    @else
                        <span class="vt-trashed-badge">🗑 Trashed</span>
                        <button wire:click="confirmRestore({{ $v->id }})" class="vt-btn-restore">↩ Restore</button>
                    @endif
                </div>
            </div>
            @empty
            <div class="vt-empty">
                <span>🚀</span>
                <p>No ventures found. Click <strong>+ Add Venture</strong> to get started.</p>
            </div>
            @endforelse
        </div>

        @if($ventures->hasPages())
        <div class="vt-pagination">
            <span class="vt-page-info">Showing {{ $ventures->firstItem() }}–{{ $ventures->lastItem() }} of {{ $ventures->total() }}</span>
            {{ $ventures->links() }}
        </div>
        @endif
    </div>


    {{-- ════ CREATE / EDIT MODAL ════ --}}
    @if($showModal)
    <div class="modal-backdrop" x-data x-on:keydown.escape.window="$wire.closeModal()">
        <div class="modal-box modal-xl" @click.outside="$wire.closeModal()">

            <div class="modal-head">
                <h2>{{ $isEdit ? 'Edit Venture' : 'Add Venture' }}</h2>
                <button class="modal-close" wire:click="closeModal">✕</button>
            </div>

            <div class="modal-body">

                {{-- Live preview card ── --}}
                <div class="venture-modal-preview">
                    <div class="vmp-banner" style="background:linear-gradient({{ $banner_gradient ?: '135deg,#0d1560,#2952e3' }})">
                        @if($bannerImage)
                            <img src="{{ $bannerImage->temporaryUrl() }}" class="vmp-img">
                        @elseif($existingImage && !$removeImage)
                            <img src="{{ asset('storage/'.$existingImage) }}" class="vmp-img">
                        @else
                            <span class="vmp-emoji">{{ $emoji ?: '🎓' }}</span>
                        @endif
                        <span class="vmp-status {{ $status }}">{{ match($status) {
                            'flagship' => 'Flagship Venture',
                            'active' => 'Active',
                            'new' => 'New',
                            'coming_soon' => 'Coming Soon',
                            default => $status
                        } }}</span>
                    </div>
                    <div class="vmp-body">
                        <div class="vmp-tag" style="background:{{ $tag_bg ?: '#e8edfd' }};color:{{ $tag_color ?: '#2952e3' }}">
                            {{ $tag_label ?: ucfirst($category) }}
                        </div>
                        <strong>{{ $name ?: 'Venture Name' }}</strong>
                        <p>{{ $description ?: 'Short description will appear here.' }}</p>
                        <div class="vmp-meta">
                            @if($location)<span>📍 {{ $location }}</span>@endif
                            @if($established)<span>📅 {{ $established }}</span>@endif
                        </div>
                    </div>
                </div>

                <form wire:submit="save" id="ventureForm">

                    {{-- ── Basic Info ── --}}
                    <div class="modal-section-title">Basic Information</div>
                    <div class="vt-grid-2">
                        <div class="form-group">
                            <label>Venture Name <span class="req">*</span></label>
                            <input type="text" wire:model.live="name" placeholder="e.g. HASU Language Institute">
                            @error('name') <span class="fe">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Tagline</label>
                            <input type="text" wire:model="tagline" placeholder="Short headline for hero section">
                            @error('tagline') <span class="fe">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>URL Slug</label>
                            <div class="slug-wrap"><span>/ventures/</span>
                                <input type="text" wire:model="slug" placeholder="auto-generated">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Display Order</label>
                            <input type="number" wire:model="order" min="0">
                            <small class="form-hint">Lower = appears first</small>
                        </div>
                        <div class="form-group">
                            <label>Category <span class="req">*</span></label>
                            <select wire:model="category">
                                <option value="education">Education</option>
                                <option value="language">Language</option>
                                <option value="business">Business</option>
                                <option value="innovation">Innovation</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status <span class="req">*</span></label>
                            <select wire:model.live="status">
                                <option value="flagship">Flagship Venture</option>
                                <option value="active">Active</option>
                                <option value="new">New</option>
                                <option value="coming_soon">Coming Soon</option>
                            </select>
                        </div>
                        <div class="form-group vt-full">
                            <label>Short Description <span class="form-optional">(shown on venture cards)</span></label>
                            <textarea wire:model.live="description" rows="2" maxlength="500"
                                      placeholder="Brief description for the venture card and hero subtitle…"></textarea>
                            <div style="display:flex;justify-content:flex-end;margin-top:3px">
                                <span class="char-count">{{ strlen($description) }} / 500</span>
                            </div>
                        </div>
                        <div class="form-group vt-full">
                            <label>Full Detail Description <span class="form-optional">(shown on detail page)</span></label>
                            <textarea wire:model="long_description" rows="6"
                                      placeholder="Full details about this venture — its services, history, and value proposition…"></textarea>
                        </div>
                        <div class="form-group vt-full">
                            <label>
                                Highlights / What We Do
                                <span class="form-optional">(one bullet point per line)</span>
                            </label>
                            <textarea wire:model="highlights_raw" rows="4"
                                      placeholder="Admission & university placement&#10;Visa documentation & processing&#10;Scholarship & financial guidance"></textarea>
                            <small class="form-hint">Each line = one bullet on the detail page.</small>
                        </div>
                        <div class="form-group">
                            <label>Section Title for Highlights</label>
                            <input type="text" wire:model="section_title" placeholder="What We Do">
                        </div>
                        <div class="form-group">
                            <label>Emoji Logo</label>
                            <input type="text" wire:model.live="emoji" placeholder="🎓" maxlength="10"
                                   style="font-size:18px;text-align:center">
                            <small class="form-hint">Paste any emoji — used as the venture logo icon</small>
                        </div>
                    </div>

                    {{-- ── Branding ── --}}
                    <div class="modal-section-title">Branding & Colors</div>
                    <div class="vt-grid-2">
                        <div class="form-group">
                            <label>Banner Gradient <span class="form-optional">(CSS gradient value)</span></label>
                            <input type="text" wire:model.live="banner_gradient"
                                   placeholder="135deg,#0d1560,#2952e3">
                            <small class="form-hint">Format: angle,color1,color2</small>
                        </div>
                        <div class="form-group">
                            <label>Accent Color</label>
                            <div style="display:flex;gap:8px;align-items:center">
                                <input type="color" wire:model.live="accent_color" style="width:42px;height:36px;padding:2px;border-radius:6px;border:1.5px solid var(--border);cursor:pointer">
                                <input type="text" wire:model.live="accent_color" placeholder="#2952e3" style="flex:1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tag Label <span class="form-optional">(e.g. "Education · Est. 2013")</span></label>
                            <input type="text" wire:model.live="tag_label" placeholder="Education · Est. 2013">
                        </div>
                        <div class="form-group">
                            <label>Tag Colors</label>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
                                <div>
                                    <small class="form-hint" style="margin-bottom:4px;display:block">Text color</small>
                                    <div style="display:flex;gap:6px;align-items:center">
                                        <input type="color" wire:model.live="tag_color" style="width:36px;height:32px;padding:2px;border-radius:4px;border:1px solid var(--border);cursor:pointer">
                                        <input type="text" wire:model.live="tag_color" placeholder="#2952e3" style="font-size:12px">
                                    </div>
                                </div>
                                <div>
                                    <small class="form-hint" style="margin-bottom:4px;display:block">Background</small>
                                    <div style="display:flex;gap:6px;align-items:center">
                                        <input type="color" wire:model.live="tag_bg" style="width:36px;height:32px;padding:2px;border-radius:4px;border:1px solid var(--border);cursor:pointer">
                                        <input type="text" wire:model.live="tag_bg" placeholder="#e8edfd" style="font-size:12px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Meta ── --}}
                    <div class="modal-section-title">Contact & Meta Details</div>
                    <div class="vt-grid-2">
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" wire:model.live="location" placeholder="Bhairahawa">
                        </div>
                        <div class="form-group">
                            <label>Established</label>
                            <input type="text" wire:model="established" placeholder="2013 · Registered 2015">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" wire:model="email" placeholder="info@hasuedu.com">
                            @error('email') <span class="fe">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" wire:model="phone" placeholder="+977-98XXXXXXXX">
                        </div>
                        <div class="form-group vt-full">
                            <label>Website URL</label>
                            <input type="url" wire:model="website_url" placeholder="https://…">
                            @error('website_url') <span class="fe">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- ── Buttons ── --}}
                    <div class="modal-section-title">Call-to-Action Buttons</div>
                    <div class="vt-grid-2">
                        <div class="form-group">
                            <label>Primary Button Label</label>
                            <input type="text" wire:model="primary_btn_label" placeholder="Learn More →">
                        </div>
                        <div class="form-group">
                            <label>Primary Button URL</label>
                            <input type="text" wire:model="primary_btn_url" placeholder="/ventures/slug or https://…">
                        </div>
                        <div class="form-group">
                            <label>Secondary Button Label</label>
                            <input type="text" wire:model="secondary_btn_label" placeholder="Contact">
                        </div>
                        <div class="form-group">
                            <label>Secondary Button URL</label>
                            <input type="text" wire:model="secondary_btn_url" placeholder="/contact">
                        </div>
                    </div>

                    {{-- ── Toggles ── --}}
                    <div class="modal-section-title">Visibility & Flags</div>
                    <div class="vt-toggles-row">
                        <label class="toggle-label">
                            <div class="toggle-switch">
                                <input type="checkbox" wire:model="is_active" id="vt_is_active">
                                <span class="toggle-slider"></span>
                            </div>
                            <span>Visible on website</span>
                        </label>
                        <label class="toggle-label">
                            <div class="toggle-switch">
                                <input type="checkbox" wire:model="is_featured" id="vt_is_featured">
                                <span class="toggle-slider toggle-gold"></span>
                            </div>
                            <span>⭐ Featured <span class="form-optional">(shown as the big hero card)</span></span>
                        </label>
                    </div>

                    {{-- ── Banner Image ── --}}
                    <div class="modal-section-title">Banner / Hero Image <span class="form-optional">(optional — shown in detail page hero)</span></div>
                    <div class="vt-grid-2">
                        <div class="form-group">
                            <div class="upload-box" x-data="{drag:false}"
                                 @dragover.prevent="drag=true" @dragleave.prevent="drag=false" @drop.prevent="drag=false"
                                 :class="{dragging:drag}">
                                @if($bannerImage)
                                    <img src="{{ $bannerImage->temporaryUrl() }}" class="upload-prev">
                                @elseif($existingImage && !$removeImage)
                                    <img src="{{ asset('storage/'.$existingImage) }}" class="upload-prev">
                                @else
                                    <div class="upload-ph">
                                        <span>🖼️</span>
                                        <small>Click or drag · JPG PNG WebP · Max 3MB<br>Recommended: 1200×600 px</small>
                                    </div>
                                @endif
                                <input type="file" wire:model="bannerImage" accept="image/*" class="upload-input">
                            </div>
                            @error('bannerImage') <span class="fe">{{ $message }}</span> @enderror
                            <div wire:loading wire:target="bannerImage" class="uploading">Uploading…</div>
                            @if($existingImage && !$bannerImage)
                            <label class="remove-photo-check">
                                <input type="checkbox" wire:model.live="removeImage">
                                <span>Remove current image</span>
                            </label>
                            @endif
                        </div>
                        <div class="photo-tips">
                            <strong>Image Tips</strong>
                            <ul>
                                <li>Used as the hero section background image</li>
                                <li>Wide/landscape format (16:9 or wider) works best</li>
                                <li>Recommended: 1200×600 px or wider</li>
                                <li>JPG, PNG, or WebP — Max 3 MB</li>
                                <li>If no image, the gradient is used instead</li>
                            </ul>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-foot">
                <button type="button" wire:click="closeModal" class="btn-cancel">Cancel</button>
                <button form="ventureForm" type="submit" class="btn-save"
                        wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">{{ $isEdit ? '💾 Update Venture' : '✨ Create Venture' }}</span>
                    <span wire:loading wire:target="save">Saving…</span>
                </button>
            </div>
        </div>
    </div>
    @endif


    {{-- ════ DELETE MODAL ════ --}}
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
                    <p>This venture will be soft-deleted and can be restored from the Trashed filter.</p>
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

    {{-- ════ RESTORE MODAL ════ --}}
    @if($confirmingRestoreId)
    <div class="modal-backdrop">
        <div class="modal-box modal-xs">
            <div class="modal-head">
                <h2>Restore Venture?</h2>
                <button class="modal-close" wire:click="cancelRestore">✕</button>
            </div>
            <div class="modal-body">
                <div class="delete-confirm">
                    <span class="delete-icon">↩️</span>
                    <p>This venture will be restored and visible on the website again.</p>
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

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
document.addEventListener('livewire:initialized', () => initSortable());
Livewire.hook('commit', ({ succeed }) => { succeed(() => setTimeout(initSortable, 60)); });
function initSortable() {
    const el = document.getElementById('ventureList');
    if (!el || el._sortable) return;
    el._sortable = Sortable.create(el, {
        handle: '.vt-drag', animation: 150, ghostClass: 'vt-list-item--ghost',
        onEnd() {
            const ids = [...el.querySelectorAll('.vt-list-item')].map(i => +i.dataset.id);
            @this.reorder(ids);
        }
    });
}
</script>

<style>
:root{
    --navy:#0d1560;--blue:#2952e3;--blue-light:#e8edfd;
    --red:#cc2222;--red-dark:#a81a1a;--gold:#f59e0b;
    --border:#e2e8f0;--text:#555;--light:#f5f7fb;--page-bg:#eef0f8;
    --radius:8px;--shadow:0 2px 12px rgba(0,0,0,.07);
}

/* ── Page ── */
.vt-wrap   { padding:32px 28px;max-width:1200px; }
.vt-header { display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px; }
.vt-header h1 { font-family:'Playfair Display',serif;font-size:26px;color:var(--navy);margin-bottom:4px;font-weight:700; }
.vt-header p  { font-size:13px;color:var(--text); }
.alert-success { display:flex;align-items:center;gap:10px;padding:12px 18px;border-radius:var(--radius);font-size:14px;font-weight:500;margin-bottom:20px;background:#f0fdf4;color:#166534;border:1px solid #bbf7d0; }
.btn-preview { padding:9px 18px;border:1.5px solid var(--border);border-radius:var(--radius);font-size:13px;font-weight:600;color:var(--navy);text-decoration:none;transition:all .2s;background:#fff; }
.btn-preview:hover { border-color:var(--blue);color:var(--blue); }
.btn-add-sm { padding:9px 18px;background:var(--navy);color:#fff;border:none;border-radius:var(--radius);font-size:13px;font-weight:600;cursor:pointer;transition:background .2s;white-space:nowrap; }
.btn-add-sm:hover { background:var(--blue); }
.tab-count  { font-size:11px;font-weight:700;background:var(--blue-light);color:var(--blue);padding:3px 10px;border-radius:20px; }

/* ── Card ── */
.vt-card { background:#fff;border-radius:12px;border:1px solid var(--border);box-shadow:var(--shadow);overflow:hidden; }
.vt-card-header { display:flex;justify-content:space-between;align-items:center;padding:18px 24px;border-bottom:1px solid var(--border);background:var(--light);flex-wrap:wrap;gap:10px; }
.vt-card-header h2 { font-size:16px;font-weight:700;color:var(--navy);margin-bottom:3px; }
.vt-card-header p  { font-size:13px;color:var(--text); }

/* ── Grids ── */
.vt-grid-2 { display:grid;grid-template-columns:1fr 1fr;gap:14px 20px; }
.vt-grid-4 { display:grid;grid-template-columns:repeat(4,1fr);gap:14px 16px; }
.vt-full   { grid-column:1/-1; }

/* ── Forms ── */
.form-group { display:flex;flex-direction:column;gap:6px; }
.form-group label { font-size:13px;font-weight:600;color:var(--navy); }
.form-optional { font-size:12px;font-weight:400;color:#94a3b8; }
.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="url"],
.form-group input[type="number"],
.form-group textarea,
.form-group select {
    width:100%;padding:9px 13px;border:1.5px solid var(--border);border-radius:var(--radius);
    font-family:'DM Sans',sans-serif;font-size:14px;color:#333;
    outline:none;transition:border-color .2s,box-shadow .2s;background:#fff;resize:vertical;
}
.form-group input:focus,.form-group textarea:focus,.form-group select:focus { border-color:var(--blue);box-shadow:0 0 0 3px rgba(41,82,227,.1); }
.req  { color:var(--red); }
.fe   { font-size:12px;color:var(--red);margin-top:2px; }
.form-hint  { font-size:11px;color:#94a3b8; }
.char-count { font-size:11px;color:#94a3b8; }

/* Search */
.search-wrap { display:flex;align-items:center;gap:8px;border:1.5px solid var(--border);border-radius:var(--radius);padding:0 13px;background:#fff;transition:border-color .2s; }
.search-wrap:focus-within { border-color:var(--blue);box-shadow:0 0 0 3px rgba(41,82,227,.1); }
.search-wrap input { flex:1;border:none;outline:none;padding:9px 0;font-family:'DM Sans',sans-serif;font-size:14px;color:#333;background:transparent; }

/* Slug */
.slug-wrap { display:flex;align-items:center;border:1.5px solid var(--border);border-radius:var(--radius);overflow:hidden;transition:border-color .2s; }
.slug-wrap:focus-within { border-color:var(--blue);box-shadow:0 0 0 3px rgba(41,82,227,.1); }
.slug-wrap span { padding:9px 10px 9px 13px;font-size:13px;color:#94a3b8;background:var(--light);white-space:nowrap;border-right:1.5px solid var(--border); }
.slug-wrap input { border:none;outline:none;padding:9px 13px;font-family:'DM Sans',sans-serif;font-size:14px;color:#333;flex:1;box-shadow:none !important; }

/* Modal section title */
.modal-section-title { font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#94a3b8;margin:22px 0 12px;display:flex;align-items:center;gap:10px; }
.modal-section-title::before,.modal-section-title::after { content:'';flex:1;height:1px;background:var(--border); }

/* Toggles */
.vt-toggles-row { display:flex;gap:28px;flex-wrap:wrap;margin-bottom:4px; }
.toggle-label  { display:flex;align-items:center;gap:10px;cursor:pointer;font-size:14px;font-weight:500;color:var(--navy); }
.toggle-switch { position:relative;width:44px;height:24px;flex-shrink:0; }
.toggle-switch input { opacity:0;width:0;height:0;position:absolute; }
.toggle-slider { position:absolute;inset:0;background:#cbd5e1;border-radius:24px;transition:.3s;cursor:pointer; }
.toggle-slider::before { content:'';position:absolute;left:3px;top:3px;width:18px;height:18px;background:#fff;border-radius:50%;transition:.3s; }
.toggle-switch input:checked + .toggle-slider { background:var(--blue); }
.toggle-switch input:checked + .toggle-gold  { background:var(--gold); }
.toggle-switch input:checked + .toggle-slider::before { transform:translateX(20px); }

/* Upload */
.upload-box { border:2px dashed var(--border);border-radius:var(--radius);min-height:130px;position:relative;cursor:pointer;display:flex;align-items:center;justify-content:center;overflow:hidden;transition:border-color .2s,background .2s; }
.upload-box:hover,.upload-box.dragging { border-color:var(--blue);background:var(--blue-light); }
.upload-ph  { display:flex;flex-direction:column;align-items:center;gap:6px;color:#94a3b8;text-align:center;padding:12px; }
.upload-ph span { font-size:28px; }
.upload-ph small { font-size:12px;line-height:1.5; }
.upload-prev { max-width:100%;max-height:150px;object-fit:contain;padding:8px; }
.upload-input { position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%; }
.uploading    { font-size:12px;color:var(--blue);margin-top:4px; }
.remove-photo-check { display:flex;align-items:center;gap:8px;margin-top:8px;font-size:13px;color:var(--red);cursor:pointer; }
.photo-tips { padding:16px 18px;background:var(--light);border-radius:var(--radius);border:1px solid var(--border); }
.photo-tips strong { display:block;font-size:13px;font-weight:700;color:var(--navy);margin-bottom:10px; }
.photo-tips ul { margin:0;padding-left:16px;display:flex;flex-direction:column;gap:6px; }
.photo-tips li { font-size:12px;color:var(--text);line-height:1.4; }

/* ── Frontend Preview ── */
.frontend-preview { background:var(--page-bg);border:1px solid var(--border);border-radius:14px;padding:24px;margin-bottom:24px; }
.fp-label-row { display:flex;align-items:center;justify-content:center;gap:12px;margin-bottom:10px; }
.fp-line  { display:block;width:32px;height:2px;background:var(--red); }
.fp-label { font-size:11px;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;color:var(--red); }
.fp-title { font-family:'Playfair Display',serif;font-size:20px;font-weight:700;color:var(--navy);text-align:center;margin-bottom:18px; }
.fp-grid  { display:grid;grid-template-columns:repeat(3,1fr);gap:12px; }
.fp-card  { border-radius:10px;overflow:hidden;box-shadow:var(--shadow); }
.fp-card-top { padding:16px;display:flex;align-items:center;justify-content:space-between;min-height:64px; }
.fp-emoji { font-size:28px; }
.fp-feat-badge { font-size:10px;font-weight:700;background:rgba(255,255,255,.2);color:#fff;padding:3px 8px;border-radius:20px; }
.fp-card-body { background:#fff;padding:14px; }
.fp-tag   { display:inline-block;font-size:10px;font-weight:700;padding:2px 9px;border-radius:20px;margin-bottom:6px; }
.fp-card-body strong { display:block;font-size:13px;font-weight:700;color:var(--navy);margin-bottom:4px; }
.fp-card-body p { font-size:11px;color:var(--text);line-height:1.4;margin-bottom:6px; }
.fp-meta  { display:flex;gap:8px;flex-wrap:wrap; }
.fp-meta span { font-size:10px;color:#94a3b8; }
.fp-empty { grid-column:1/-1;padding:16px;color:#94a3b8;font-size:13px;text-align:center; }

/* ── List ── */
.vt-list { padding:0 16px 16px; }
.vt-list-item { display:flex;align-items:center;gap:14px;background:#fff;border:1px solid var(--border);border-radius:8px;padding:14px 16px;margin-top:10px;transition:box-shadow .2s; }
.vt-list-item:hover { box-shadow:0 3px 14px rgba(0,0,0,.08); }
.vt-list-item--ghost { opacity:.35;background:var(--light); }
.vt-list-item.is-trashed { opacity:.6;background:#fff5f5; }
.vt-drag { cursor:grab;color:#cbd5e1;font-size:18px;flex-shrink:0;padding:2px 5px;border-radius:4px; }
.vt-drag:hover { color:var(--navy);background:var(--light); }
.vt-banner-mini { width:72px;height:48px;border-radius:6px;overflow:hidden;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:22px; }
.vt-banner-mini img { width:100%;height:100%;object-fit:cover; }
.vt-list-content { flex:1;min-width:0; }
.vt-list-content strong { display:block;font-size:14px;font-weight:700;color:var(--navy);margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
.vt-cat  { display:inline;font-size:11px;color:#94a3b8;margin-right:10px; }
.vt-loc  { display:inline;font-size:11px;color:#94a3b8; }
.vt-order-badge { font-size:11px;font-weight:700;color:#94a3b8;background:var(--light);border:1px solid var(--border);border-radius:20px;padding:3px 10px;flex-shrink:0; }
.vt-list-actions { display:flex;align-items:center;gap:6px;flex-shrink:0;flex-wrap:wrap; }
.vt-btn-feat { font-size:16px;width:32px;height:32px;border:1px solid var(--border);border-radius:var(--radius);cursor:pointer;background:#fff;transition:all .2s;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
.vt-btn-feat:hover,.vt-btn-feat.active { background:#fef9c3;border-color:#fde68a; }
.vt-toggle { font-size:12px;padding:5px 12px;border:none;border-radius:20px;cursor:pointer;font-weight:600;white-space:nowrap;transition:all .2s; }
.vt-toggle.on  { background:#dcfce7;color:#166534; }
.vt-toggle.off { background:#fee2e2;color:#991b1b; }
.vt-btn-edit { font-size:12px;font-weight:600;padding:6px 12px;border-radius:var(--radius);border:none;cursor:pointer;background:var(--blue-light);color:var(--blue);transition:all .2s; }
.vt-btn-edit:hover { background:var(--blue);color:#fff; }
.vt-btn-del { font-size:12px;font-weight:600;padding:6px 12px;border-radius:var(--radius);border:none;cursor:pointer;background:#fee2e2;color:var(--red);transition:all .2s; }
.vt-btn-del:hover { background:var(--red);color:#fff; }
.vt-trashed-badge { font-size:12px;color:#991b1b;background:#fee2e2;padding:4px 10px;border-radius:20px;font-weight:600; }
.vt-btn-restore { font-size:12px;font-weight:600;padding:6px 12px;border-radius:var(--radius);border:none;cursor:pointer;background:#dcfce7;color:#166534;transition:all .2s; }
.vt-btn-restore:hover { background:#166534;color:#fff; }
.vt-feat-badge { font-size:10px;font-weight:700;background:#fef9c3;color:#854d0e;padding:2px 8px;border-radius:20px;border:1px solid #fde68a; }
.vt-status-badge { font-size:10px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;padding:2px 9px;border-radius:20px; }
.vt-status-badge.flagship   { background:#e8edfd;color:#2952e3; }
.vt-status-badge.active     { background:#dcfce7;color:#166534; }
.vt-status-badge.new        { background:#fef9c3;color:#854d0e; }
.vt-status-badge.coming_soon { background:#f1f5f9;color:#64748b; }
.vt-empty { text-align:center;padding:40px;color:#94a3b8;font-size:14px; }
.vt-empty span { display:block;font-size:36px;margin-bottom:10px; }
.vt-pagination { display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:8px; }
.vt-page-info  { font-size:13px;color:var(--text); }

/* ── Venture modal preview ── */
.venture-modal-preview { display:grid;grid-template-columns:240px 1fr;border-radius:10px;overflow:hidden;box-shadow:var(--shadow);margin-bottom:22px;border:1px solid var(--border); }
.vmp-banner { display:flex;flex-direction:column;align-items:center;justify-content:center;padding:20px;position:relative;min-height:120px; }
.vmp-img    { width:100%;height:100%;object-fit:cover;position:absolute;inset:0;border-radius:0; }
.vmp-emoji  { font-size:48px;z-index:1; }
.vmp-status { position:absolute;top:10px;right:10px;font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;padding:3px 9px;border-radius:20px;z-index:2; }
.vmp-status.flagship   { background:#2952e3;color:#fff; }
.vmp-status.active     { background:#166534;color:#fff; }
.vmp-status.new        { background:var(--gold);color:#fff; }
.vmp-status.coming_soon { background:#64748b;color:#fff; }
.vmp-body   { background:#fff;padding:18px 20px;display:flex;flex-direction:column;justify-content:center; }
.vmp-tag    { display:inline-block;font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;margin-bottom:8px;align-self:flex-start; }
.vmp-body strong { display:block;font-family:'Playfair Display',serif;font-size:16px;font-weight:700;color:var(--navy);margin-bottom:4px; }
.vmp-body p { font-size:12px;color:var(--text);line-height:1.5;margin-bottom:8px; }
.vmp-meta   { display:flex;gap:12px;flex-wrap:wrap; }
.vmp-meta span { font-size:11px;color:#94a3b8; }

/* ── Modal ── */
.modal-backdrop { position:fixed;inset:0;z-index:1000;background:rgba(13,21,96,.45);backdrop-filter:blur(3px);display:flex;align-items:center;justify-content:center;padding:20px; }
.modal-box { background:#fff;border-radius:14px;box-shadow:0 20px 60px rgba(0,0,0,.25);width:100%;display:flex;flex-direction:column;max-height:90vh;overflow:hidden; }
.modal-xs  { max-width:360px; }
.modal-xl  { max-width:900px; }
.modal-head { display:flex;justify-content:space-between;align-items:center;padding:18px 24px 14px;border-bottom:1px solid var(--border);flex-shrink:0; }
.modal-head h2 { font-family:'Playfair Display',serif;font-size:18px;color:var(--navy); }
.modal-close { background:none;border:none;font-size:18px;cursor:pointer;color:#94a3b8;padding:2px 6px;border-radius:4px;transition:all .2s; }
.modal-close:hover { background:var(--light);color:var(--navy); }
.modal-body { flex:1;overflow-y:auto;padding:22px 24px; }
.modal-foot { display:flex;justify-content:flex-end;gap:10px;padding:14px 24px;border-top:1px solid var(--border);flex-shrink:0; }
.btn-cancel { padding:9px 20px;background:var(--light);color:var(--navy);border:1px solid var(--border);border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer;transition:all .2s; }
.btn-cancel:hover { background:var(--border); }
.btn-save { display:inline-flex;align-items:center;gap:8px;padding:10px 26px;background:var(--red);color:#fff;border:none;border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer;transition:background .2s; }
.btn-save:hover:not(:disabled) { background:var(--red-dark); }
.btn-save:disabled { opacity:.65;cursor:not-allowed; }
.btn-delete-confirm  { padding:9px 20px;background:var(--red);color:#fff;border:none;border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer; }
.btn-delete-confirm:hover:not(:disabled) { background:var(--red-dark); }
.btn-restore-confirm { padding:9px 20px;background:#166534;color:#fff;border:none;border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer; }
.delete-confirm { display:flex;flex-direction:column;align-items:center;text-align:center;gap:12px;padding:10px 0; }
.delete-icon { font-size:36px; }
.delete-confirm p { font-size:14px;color:var(--text);line-height:1.6; }

@media(max-width:960px){
    .vt-wrap { padding:16px; }
    .vt-grid-4,.vt-grid-2 { grid-template-columns:1fr 1fr; }
    .fp-grid { grid-template-columns:1fr 1fr; }
    .venture-modal-preview { grid-template-columns:1fr; }
}
@media(max-width:560px){
    .vt-grid-4,.vt-grid-2 { grid-template-columns:1fr; }
    .fp-grid { grid-template-columns:1fr; }
    .vt-list-actions { flex-wrap:wrap; }
}
</style>