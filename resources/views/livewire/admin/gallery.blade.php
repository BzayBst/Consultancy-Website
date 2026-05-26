<div class="gal-wrap" x-data>
    <div class="gal-header">
        <div>
            <h1>Gallery</h1>
            <p>Manage images shown on the frontend gallery page.</p>
        </div>
        <div class="gal-header-actions">
            <a href="{{ route('gallery') }}" target="_blank" class="btn-preview">Preview Page</a>
            <button wire:click="openCreate" class="btn-add">+ Add Image</button>
        </div>
    </div>

    @if (session('success'))
        <div class="alert-success" x-data="{ show:true }" x-show="show" x-init="setTimeout(()=>show=false,3000)">
            {{ session('success') }}
        </div>
    @endif

    <div class="gal-filters">
        <div class="gal-search">
            <span>Search</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Title, category, alt text">
        </div>
        <select wire:model.live="filterCategory">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}">{{ Str::headline($cat) }}</option>
            @endforeach
        </select>
        <select wire:model.live="filterActive">
            <option value="">All Visibility</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="trashed">Trashed</option>
        </select>
        <select wire:model.live="perPage">
            <option value="12">12 / page</option>
            <option value="24">24 / page</option>
            <option value="48">48 / page</option>
        </select>
    </div>

    <div class="gal-grid">
        @forelse($images as $image)
            <div class="gal-card {{ $image->trashed() ? 'is-trashed' : '' }}">
                <div class="gal-thumb">
                    <img src="{{ $image->image_url }}" alt="{{ $image->alt_text ?: $image->title }}">
                    <span class="gal-badge">{{ Str::headline($image->category) }}</span>
                </div>
                <div class="gal-body">
                    <h3>{{ $image->title }}</h3>
                    @if($image->alt_text)
                        <p>{{ $image->alt_text }}</p>
                    @endif
                    <div class="gal-meta">
                        <span>Order {{ $image->sort_order }}</span>
                        <span>{{ $image->is_active ? 'Visible' : 'Hidden' }}</span>
                    </div>
                </div>
                <div class="gal-actions">
                    @if($image->trashed())
                        <span class="trashed-label">Trashed</span>
                        <button wire:click="confirmRestore({{ $image->id }})" class="btn-restore">Restore</button>
                    @else
                        <button wire:click="toggleActive({{ $image->id }})" class="btn-toggle {{ $image->is_active ? 'on' : 'off' }}">
                            {{ $image->is_active ? 'Visible' : 'Hidden' }}
                        </button>
                        <button wire:click="openEdit({{ $image->id }})" class="btn-edit">Edit</button>
                        <button wire:click="confirmDelete({{ $image->id }})" class="btn-delete">Delete</button>
                    @endif
                </div>
            </div>
        @empty
            <div class="gal-empty">
                <strong>No gallery images yet.</strong>
                <span>Add your first image to populate the frontend gallery.</span>
            </div>
        @endforelse
    </div>

    @if($images->hasPages())
        <div class="gal-pagination">
            {{ $images->links() }}
        </div>
    @endif

    @if($showModal)
        <div class="modal-backdrop" x-on:keydown.escape.window="$wire.closeModal()">
            <div class="modal-box" @click.outside="$wire.closeModal()">
                <div class="modal-head">
                    <h2>{{ $isEdit ? 'Edit Gallery Image' : 'Add Gallery Image' }}</h2>
                    <button wire:click="closeModal" class="modal-close">x</button>
                </div>

                <form wire:submit="save">
                    <div class="modal-body">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Title <span>*</span></label>
                                <input type="text" wire:model.live="title" placeholder="Study in Australia Seminar">
                                @error('title') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Category <span>*</span></label>
                                <input type="text" wire:model.live="category" list="gallery-categories" placeholder="classes">
                                <datalist id="gallery-categories">
                                    <option value="classes">
                                    <option value="events">
                                    <option value="success">
                                </datalist>
                                @error('category') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Alt Text</label>
                                <input type="text" wire:model.live="alt_text" placeholder="Students attending a seminar">
                                @error('alt_text') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Sort Order <span>*</span></label>
                                <input type="number" min="0" wire:model.live="sort_order">
                                @error('sort_order') <small>{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="upload-row">
                            <label class="upload-box">
                                @if($photo)
                                    <img src="{{ $photo->temporaryUrl() }}" alt="Preview">
                                @elseif($existingPhoto)
                                    <img src="{{ asset('storage/' . $existingPhoto) }}" alt="Current image">
                                @else
                                    <div>
                                        <strong>Upload image</strong>
                                        <span>JPG, PNG or WebP up to 3MB</span>
                                    </div>
                                @endif
                                <input type="file" wire:model="photo" accept="image/png,image/jpeg,image/webp">
                            </label>
                            @error('photo') <small class="upload-error">{{ $message }}</small> @enderror
                            <div wire:loading wire:target="photo" class="uploading">Uploading image...</div>
                        </div>

                        <label class="toggle-row">
                            <input type="checkbox" wire:model.live="is_active">
                            <span>Show this image on the frontend</span>
                        </label>
                    </div>

                    <div class="modal-foot">
                        <button type="button" wire:click="closeModal" class="btn-cancel">Cancel</button>
                        <button type="submit" class="btn-save" wire:loading.attr="disabled">
                            {{ $isEdit ? 'Update Image' : 'Add Image' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if($confirmingDeleteId)
        <div class="modal-backdrop">
            <div class="confirm-box">
                <h2>Delete image?</h2>
                <p>This moves the image to trash. You can restore it later.</p>
                <div>
                    <button wire:click="cancelDelete" class="btn-cancel">Cancel</button>
                    <button wire:click="delete" class="btn-confirm-delete">Delete</button>
                </div>
            </div>
        </div>
    @endif

    @if($confirmingRestoreId)
        <div class="modal-backdrop">
            <div class="confirm-box">
                <h2>Restore image?</h2>
                <p>This will return the image to the gallery manager.</p>
                <div>
                    <button wire:click="cancelRestore" class="btn-cancel">Cancel</button>
                    <button wire:click="restore" class="btn-confirm-restore">Restore</button>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.gal-wrap { padding:24px; }
.gal-header { display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px; }
.gal-header h1 { font-family:'Playfair Display',serif;font-size:28px;color:var(--navy);margin:0 0 4px; }
.gal-header p { color:var(--text);font-size:14px;margin:0; }
.gal-header-actions { display:flex;gap:10px;flex-wrap:wrap; }
.btn-preview,.btn-add { border:none;border-radius:8px;padding:10px 16px;font-size:13px;font-weight:700;text-decoration:none;cursor:pointer; }
.btn-preview { background:#fff;color:var(--navy);border:1px solid var(--border); }
.btn-add { background:var(--navy);color:#fff; }
.alert-success { background:#dcfce7;color:#166534;border:1px solid #bbf7d0;border-radius:8px;padding:12px 14px;margin-bottom:16px;font-size:14px; }
.gal-filters { display:flex;gap:10px;align-items:center;flex-wrap:wrap;margin-bottom:18px; }
.gal-search { flex:1;min-width:240px;background:#fff;border:1px solid var(--border);border-radius:8px;display:flex;align-items:center;gap:10px;padding:9px 12px; }
.gal-search span { font-size:12px;font-weight:700;color:var(--navy); }
.gal-search input { flex:1;border:none;outline:none;font:inherit;background:transparent; }
.gal-filters select { background:#fff;border:1px solid var(--border);border-radius:8px;padding:10px 12px;font:inherit;color:#333; }
.gal-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px; }
.gal-card { background:#fff;border:1px solid var(--border);border-radius:10px;overflow:hidden;box-shadow:0 4px 14px rgba(15,23,42,.05);display:flex;flex-direction:column; }
.gal-card.is-trashed { opacity:.65;background:#fff5f5; }
.gal-thumb { position:relative;aspect-ratio:4/3;background:#e2e8f0;overflow:hidden; }
.gal-thumb img { width:100%;height:100%;object-fit:cover;display:block; }
.gal-badge { position:absolute;left:10px;bottom:10px;background:rgba(13,21,96,.9);color:#fff;border-radius:999px;padding:5px 10px;font-size:11px;font-weight:700; }
.gal-body { padding:13px 14px;flex:1; }
.gal-body h3 { font-size:15px;color:var(--navy);margin:0 0 5px; }
.gal-body p { color:var(--text);font-size:12px;line-height:1.4;margin:0 0 10px; }
.gal-meta { display:flex;gap:8px;flex-wrap:wrap;color:#64748b;font-size:11px; }
.gal-meta span { background:#f1f5f9;border-radius:999px;padding:3px 8px; }
.gal-actions { display:flex;gap:6px;align-items:center;padding:12px 14px;border-top:1px solid var(--border);flex-wrap:wrap; }
.gal-actions button { border:none;border-radius:7px;padding:7px 10px;font-size:12px;font-weight:700;cursor:pointer; }
.btn-toggle.on { background:#dcfce7;color:#166534; }
.btn-toggle.off { background:#fee2e2;color:#991b1b; }
.btn-edit { background:#e8edfd;color:var(--blue); }
.btn-delete { background:#fee2e2;color:var(--red); }
.btn-restore,.btn-confirm-restore { background:#dcfce7;color:#166534; }
.trashed-label { color:#991b1b;font-size:12px;font-weight:700;margin-right:auto; }
.gal-empty { grid-column:1/-1;background:#fff;border:1px dashed var(--border);border-radius:10px;padding:36px;text-align:center;color:#64748b;display:flex;flex-direction:column;gap:5px; }
.gal-empty strong { color:var(--navy); }
.gal-pagination { margin-top:18px;background:#fff;border-radius:8px;padding:12px 16px;border:1px solid var(--border); }
.modal-backdrop { position:fixed;inset:0;z-index:1000;background:rgba(13,21,96,.45);display:flex;align-items:center;justify-content:center;padding:20px; }
.modal-box,.confirm-box { background:#fff;border-radius:12px;box-shadow:0 20px 60px rgba(0,0,0,.25);width:100%; }
.modal-box { max-width:720px;max-height:90vh;overflow:hidden;display:flex;flex-direction:column; }
.confirm-box { max-width:380px;padding:24px;text-align:center; }
.confirm-box h2 { font-family:'Playfair Display',serif;color:var(--navy);font-size:20px;margin-bottom:8px; }
.confirm-box p { color:var(--text);font-size:14px;line-height:1.5;margin-bottom:18px; }
.modal-head,.modal-foot { display:flex;align-items:center;justify-content:space-between;gap:12px;padding:16px 20px;border-bottom:1px solid var(--border); }
.modal-foot { justify-content:flex-end;border-top:1px solid var(--border);border-bottom:0; }
.modal-head h2 { font-family:'Playfair Display',serif;color:var(--navy);font-size:20px;margin:0; }
.modal-close { border:none;background:#f1f5f9;border-radius:6px;width:30px;height:30px;cursor:pointer;color:var(--navy); }
.modal-body { padding:20px;overflow-y:auto; }
.form-grid { display:grid;grid-template-columns:1fr 1fr;gap:14px; }
.form-group { display:flex;flex-direction:column;gap:6px; }
.form-group label { color:var(--navy);font-size:13px;font-weight:700; }
.form-group label span { color:var(--red); }
.form-group input { border:1.5px solid var(--border);border-radius:8px;padding:10px 12px;font:inherit;outline:none; }
.form-group input:focus { border-color:var(--blue);box-shadow:0 0 0 3px rgba(41,82,227,.1); }
.form-group small,.upload-error { color:var(--red);font-size:12px; }
.upload-row { margin-top:16px; }
.upload-box { border:2px dashed var(--border);border-radius:10px;min-height:220px;display:flex;align-items:center;justify-content:center;text-align:center;cursor:pointer;overflow:hidden;position:relative;background:#f8fafc; }
.upload-box:hover { border-color:var(--blue);background:#eef3ff; }
.upload-box img { width:100%;height:260px;object-fit:contain;padding:10px; }
.upload-box input { position:absolute;inset:0;opacity:0;cursor:pointer; }
.upload-box strong { display:block;color:var(--navy);margin-bottom:4px; }
.upload-box span,.uploading { color:#64748b;font-size:12px; }
.toggle-row { display:flex;align-items:center;gap:9px;margin-top:16px;color:var(--navy);font-size:14px;font-weight:600; }
.btn-cancel,.btn-save,.btn-confirm-delete,.btn-confirm-restore { border:none;border-radius:8px;padding:10px 16px;font-size:13px;font-weight:700;cursor:pointer; }
.btn-cancel { background:#f1f5f9;color:var(--navy); }
.btn-save { background:var(--red);color:#fff; }
.btn-confirm-delete { background:var(--red);color:#fff; }
@media(max-width:700px){
  .gal-wrap { padding:16px; }
  .gal-header { align-items:flex-start;flex-direction:column; }
  .form-grid { grid-template-columns:1fr; }
}
</style>
