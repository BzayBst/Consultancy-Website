<div class="popup-admin-wrap">
    <div class="popup-admin-header">
        <div>
            <h1>Home Popup Banners</h1>
            <p>Upload popup images that appear when visitors open the home page.</p>
        </div>
        <a href="{{ route('home') }}" target="_blank" class="btn-preview">Preview Home</a>
    </div>

    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <form wire:submit="save" class="popup-card upload-card">
        <div class="popup-card-head">
            <h2>Upload Banners</h2>
            <p>Select one or more JPG, PNG, or WebP images.</p>
        </div>

        <div class="popup-form-grid">
            <label class="upload-box full">
                <div>
                    <strong>Choose banner images</strong>
                    <span>Multiple images allowed, up to 4MB each</span>
                </div>
                <input type="file" wire:model="photos" accept="image/png,image/jpeg,image/webp" multiple>
            </label>

            @if($photos)
                <div class="preview-strip full">
                    @foreach($photos as $photo)
                        <img src="{{ $photo->temporaryUrl() }}" alt="Popup preview">
                    @endforeach
                </div>
            @endif

            <div class="form-group">
                <label>Title</label>
                <input type="text" wire:model.live="title" placeholder="Admission open banner">
                @error('title') <small>{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <label>Link URL</label>
                <input type="url" wire:model.live="link_url" placeholder="https://... or leave empty">
                @error('link_url') <small>{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <label>Starting Sort Order</label>
                <input type="number" min="0" wire:model.live="sort_order">
                @error('sort_order') <small>{{ $message }}</small> @enderror
            </div>
            <label class="toggle-row">
                <input type="checkbox" wire:model.live="is_active">
                <span>Show uploaded banners immediately</span>
            </label>
        </div>

        @error('photos') <div class="upload-error">{{ $message }}</div> @enderror
        @error('photos.*') <div class="upload-error">{{ $message }}</div> @enderror
        <div wire:loading wire:target="photos" class="uploading">Preparing image preview...</div>

        <div class="popup-actions">
            <button type="submit" class="btn-save" wire:loading.attr="disabled">Save Banners</button>
        </div>
    </form>

    <div class="popup-grid">
        @forelse($banners as $banner)
            <div class="popup-banner-card">
                <div class="popup-thumb">
                    <img src="{{ $banner->image_url }}" alt="{{ $banner->title ?: 'Popup banner' }}">
                    <span class="status-pill {{ $banner->is_active ? 'active' : 'hidden' }}">{{ $banner->is_active ? 'Visible' : 'Hidden' }}</span>
                </div>
                <div class="popup-card-body">
                    <h3>{{ $banner->title ?: 'Untitled banner' }}</h3>
                    @if($banner->link_url)
                        <a href="{{ $banner->link_url }}" target="_blank">{{ Str::limit($banner->link_url, 44) }}</a>
                    @else
                        <span>No link</span>
                    @endif
                    <label class="order-row">
                        Sort
                        <input type="number" min="0" value="{{ $banner->sort_order }}" wire:change="updateOrder({{ $banner->id }}, $event.target.value)">
                    </label>
                </div>
                <div class="popup-card-actions">
                    <button type="button" wire:click="toggleActive({{ $banner->id }})" class="btn-toggle {{ $banner->is_active ? 'on' : 'off' }}">
                        {{ $banner->is_active ? 'Visible' : 'Hidden' }}
                    </button>
                    <button type="button" wire:click="delete({{ $banner->id }})" wire:confirm="Delete this popup banner?" class="btn-delete">Delete</button>
                </div>
            </div>
        @empty
            <div class="popup-empty">
                <strong>No popup banners yet.</strong>
                <span>Upload images to show a popup on the home page.</span>
            </div>
        @endforelse
    </div>
</div>

<style>
.popup-admin-wrap{padding:24px}
.popup-admin-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px}
.popup-admin-header h1{font-family:'Playfair Display',serif;font-size:28px;color:var(--navy);margin:0 0 4px}
.popup-admin-header p{color:var(--text);font-size:14px;margin:0}
.btn-preview,.btn-save,.btn-delete,.btn-toggle{border:none;border-radius:8px;padding:10px 16px;font-size:13px;font-weight:700;text-decoration:none;cursor:pointer}
.btn-preview{background:#fff;color:var(--navy);border:1px solid var(--border)}
.btn-save{background:var(--red);color:#fff}
.btn-delete{background:#fee2e2;color:#991b1b}
.btn-toggle.on{background:#dcfce7;color:#166534}
.btn-toggle.off{background:#fee2e2;color:#991b1b}
.alert-success{background:#dcfce7;color:#166534;border:1px solid #bbf7d0;border-radius:8px;padding:12px 14px;margin-bottom:16px;font-size:14px}
.popup-card{background:#fff;border:1px solid var(--border);border-radius:12px;box-shadow:0 4px 14px rgba(15,23,42,.05);margin-bottom:18px;overflow:hidden}
.popup-card-head{padding:18px 22px;border-bottom:1px solid var(--border);background:#f8fafc}
.popup-card-head h2{font-size:18px;color:var(--navy);margin:0 0 4px}
.popup-card-head p{font-size:13px;color:var(--text);margin:0}
.popup-form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;padding:22px}
.full{grid-column:1/-1}
.upload-box{min-height:190px;border:2px dashed var(--border);border-radius:10px;background:#f8fafc;display:flex;align-items:center;justify-content:center;text-align:center;position:relative;cursor:pointer}
.upload-box:hover{border-color:var(--blue);background:#eef3ff}
.upload-box input{position:absolute;inset:0;opacity:0;cursor:pointer}
.upload-box strong{display:block;color:var(--navy);margin-bottom:5px}
.upload-box span,.uploading{font-size:12px;color:#64748b}
.preview-strip{display:grid;grid-template-columns:repeat(auto-fill,minmax(130px,1fr));gap:10px}
.preview-strip img{width:100%;height:100px;object-fit:cover;border-radius:8px;border:1px solid var(--border)}
.form-group{display:flex;flex-direction:column;gap:6px}
.form-group label{font-size:13px;font-weight:700;color:var(--navy)}
.form-group input{border:1.5px solid var(--border);border-radius:8px;padding:10px 12px;font:inherit;outline:none}
.form-group input:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(41,82,227,.1)}
.form-group small,.upload-error{color:var(--red);font-size:12px}
.toggle-row{display:flex;align-items:center;gap:9px;color:var(--navy);font-size:14px;font-weight:600}
.popup-actions{padding:0 22px 22px;display:flex;justify-content:flex-end}
.popup-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px}
.popup-banner-card{background:#fff;border:1px solid var(--border);border-radius:10px;overflow:hidden;box-shadow:0 4px 14px rgba(15,23,42,.05)}
.popup-thumb{aspect-ratio:4/3;background:#e2e8f0;position:relative}
.popup-thumb img{width:100%;height:100%;object-fit:cover}
.status-pill{position:absolute;left:10px;bottom:10px;border-radius:999px;padding:5px 10px;font-size:11px;font-weight:800}
.status-pill.active{background:#dcfce7;color:#166534}
.status-pill.hidden{background:#f1f5f9;color:#64748b}
.popup-card-body{padding:14px}
.popup-card-body h3{font-size:15px;color:var(--navy);margin:0 0 6px}
.popup-card-body a,.popup-card-body span{font-size:12px;color:#64748b}
.order-row{display:flex;align-items:center;gap:8px;margin-top:12px;font-size:12px;font-weight:700;color:var(--navy)}
.order-row input{width:80px;border:1px solid var(--border);border-radius:7px;padding:7px 8px}
.popup-card-actions{display:flex;gap:8px;padding:12px 14px;border-top:1px solid var(--border);flex-wrap:wrap}
.popup-empty{grid-column:1/-1;background:#fff;border:1px dashed var(--border);border-radius:10px;padding:36px;text-align:center;color:#64748b;display:flex;flex-direction:column;gap:5px}
.popup-empty strong{color:var(--navy)}
@media(max-width:700px){.popup-admin-wrap{padding:16px}.popup-admin-header{align-items:flex-start;flex-direction:column}.popup-form-grid{grid-template-columns:1fr}}
</style>
