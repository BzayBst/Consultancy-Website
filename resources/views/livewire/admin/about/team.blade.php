{{-- resources/views/livewire/admin/about/team.blade.php --}}

<div class="cv-wrap" x-data>

    {{-- ───────────────── HEADER ───────────────── --}}
    <div class="cv-header">
        <div>
            <h1>Team Members</h1>
            <p>Manage all team members displayed on the public About page</p>
        </div>

        <div style="display:flex;gap:10px;">
            <a href="{{ route('about') }}#team"
               target="_blank"
               class="btn-preview">
                👁 Preview
            </a>

            <button wire:click="openCreate"
                    class="btn-add-sm">
                + Add Member
            </button>
        </div>
    </div>


    {{-- ───────────────── FILTERS ───────────────── --}}
    <div class="cv-card" style="margin-bottom:24px;">

        <div class="cv-card-header">
            <div>
                <h2>Search & Filters</h2>
                <p>Filter and manage team members</p>
            </div>

            <span class="tab-badge">
                {{ $teams->total() }} Members
            </span>
        </div>

        <div class="cv-grid-2" style="padding:24px;">

            <div class="form-group">
                <label>Search</label>

                <input type="text"
                       wire:model.live.debounce.300ms="search"
                       placeholder="Search name, designation, email...">
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


    {{-- ───────────────── PREVIEW CARDS ───────────────── --}}
    <div class="cv-cards-preview">

        @forelse($teams as $team)

        <div class="cvp-card">

            <div class="cvp-photo">
                <img src="{{ $team->photo_url }}"
                     alt="{{ $team->name }}">
            </div>

            <div class="cvp-body">
                <strong>{{ $team->name }}</strong>

                <div class="cvp-role">
                    {{ $team->designation }}
                </div>

                <p>
                    {{ Str::limit($team->bio ?: 'No biography available.', 90) }}
                </p>
            </div>

        </div>

        @empty

        <p class="cvp-empty">
            No team members found.
        </p>

        @endforelse

    </div>


    {{-- ───────────────── LIST ───────────────── --}}
    <div class="cv-card">

        <div class="cv-card-header">
            <div>
                <h2>Team Members</h2>
                <p>Manage all team members and visibility</p>
            </div>

            <button wire:click="openCreate"
                    class="btn-add-sm">
                + Add Member
            </button>
        </div>


        <div class="cv-list">

            @forelse($teams as $team)

            <div class="cv-list-item">

                <div class="cv-photo">
                    <img src="{{ $team->photo_url }}"
                         alt="{{ $team->name }}">
                </div>

                <div class="cv-list-content">

                    <strong>
                        {{ $team->name }}
                    </strong>

                    <span class="tm-role">
                        {{ $team->designation }}
                    </span>

                    @if($team->email)
                    <small>
                        {{ $team->email }}
                    </small>
                    @endif

                </div>


                <div class="cv-list-actions">

                    @if(!$team->trashed())

                    <button wire:click="toggleActive({{ $team->id }})"
                            class="cv-toggle {{ $team->is_active ? 'on' : 'off' }}">

                        {{ $team->is_active ? '✅ Active' : '⭕ Hidden' }}

                    </button>

                    <button wire:click="openEdit({{ $team->id }})"
                            class="cv-btn-edit">
                        ✏️ Edit
                    </button>

                    <button wire:click="confirmDelete({{ $team->id }})"
                            class="cv-btn-del">
                        🗑 Delete
                    </button>

                    @else

                    <button wire:click="confirmRestore({{ $team->id }})"
                            class="cv-btn-edit"
                            style="background:#dcfce7;color:#166534;">
                        ♻ Restore
                    </button>

                    @endif

                </div>

            </div>

            @empty

            <div class="cv-empty">
                <span>👥</span>
                <p>No team members found.</p>
            </div>

            @endforelse

        </div>

    </div>


    {{-- ───────────────── PAGINATION ───────────────── --}}
    @if($teams->hasPages())

    <div style="margin-top:20px;">
        {{ $teams->links() }}
    </div>

    @endif



    {{-- ════════════════════════════════════════════
         MODAL
    ════════════════════════════════════════════ --}}
    @if($showModal)

    <div class="modal-backdrop">

        <div class="modal-box modal-lg">

            <div class="modal-head">

                <h2>
                    {{ $isEdit ? 'Edit Team Member' : 'Add Team Member' }}
                </h2>

                <button class="modal-close"
                        wire:click="closeModal">
                    ✕
                </button>

            </div>


            <div class="modal-body">

                {{-- Preview --}}
                <div class="value-modal-preview">

                    <div class="vmp-left">

                        <div class="tm-modal-photo">

                            @if($photo)

                            <img src="{{ $photo->temporaryUrl() }}">

                            @elseif($existingPhoto && ! $removePhoto)

                            <img src="{{ asset('storage/'.$existingPhoto) }}">

                            @else

                            👤

                            @endif

                        </div>

                    </div>

                    <div class="vmp-right">

                        <strong>
                            {{ $name ?: 'Team Member Name' }}
                        </strong>

                        <div class="cvp-role">
                            {{ $designation ?: 'Designation' }}
                        </div>

                        <p>
                            {{ $bio ?: 'Biography preview will appear here.' }}
                        </p>

                    </div>

                </div>


                {{-- Form --}}
                <div class="cv-grid-2">

                    <div class="form-group">
                        <label>Full Name</label>

                        <input type="text"
                               wire:model.live="name">

                        @error('name')
                        <span class="fe">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label>Designation</label>

                        <input type="text"
                               wire:model.live="designation">

                        @error('designation')
                        <span class="fe">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label>Email</label>

                        <input type="email"
                               wire:model.live="email">
                    </div>


                    <div class="form-group">
                        <label>Phone</label>

                        <input type="text"
                               wire:model.live="phone">
                    </div>


                    <div class="form-group">
                        <label>Facebook URL</label>

                        <input type="url"
                               wire:model.live="social_facebook">
                    </div>


                    <div class="form-group">
                        <label>LinkedIn URL</label>

                        <input type="url"
                               wire:model.live="social_linkedin">
                    </div>


                    <div class="form-group">
                        <label>Twitter URL</label>

                        <input type="url"
                               wire:model.live="social_twitter">
                    </div>


                    <div class="form-group">
                        <label>Display Order</label>

                        <input type="number"
                               wire:model.live="order">
                    </div>


                    <div class="form-group cv-full">
                        <label>Biography</label>

                        <textarea wire:model.live="bio"
                                  rows="4"></textarea>

                        <div class="char-count">
                            {{ strlen($bio) }} / 500
                        </div>
                    </div>


                    <div class="form-group cv-full">
                        <label>Profile Photo</label>

                        <input type="file"
                               wire:model="photo">

                        @error('photo')
                        <span class="fe">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group cv-full">

                        <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">

                            <input type="checkbox"
                                   wire:model.live="is_active">

                            Active Member

                        </label>

                    </div>

                </div>

            </div>


            <div class="modal-foot">

                <button wire:click="closeModal"
                        class="btn-cancel">
                    Cancel
                </button>

                <button wire:click="save"
                        class="btn-save">

                    {{ $isEdit ? '💾 Update Member' : '✨ Create Member' }}

                </button>

            </div>

        </div>

    </div>

    @endif

</div>



<style>

:root{
    --navy:#0d1560;
    --blue:#2952e3;
    --blue-light:#e8edfd;
    --red:#cc2222;
    --red-dark:#a81a1a;
    --border:#e2e8f0;
    --text:#555;
    --light:#f5f7fb;
    --radius:10px;
    --shadow:0 2px 12px rgba(0,0,0,.07);
}

.cv-wrap{
    padding:32px 28px;
    max-width:1200px;
}

.cv-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:24px;
    flex-wrap:wrap;
    gap:14px;
}

.cv-header h1{
    font-size:28px;
    color:var(--navy);
    margin-bottom:5px;
}

.cv-header p{
    font-size:14px;
    color:var(--text);
}

.btn-preview{
    padding:10px 18px;
    border:1px solid var(--border);
    border-radius:var(--radius);
    text-decoration:none;
    color:var(--navy);
    background:#fff;
    font-size:13px;
    font-weight:600;
}

.btn-add-sm{
    padding:10px 18px;
    border:none;
    border-radius:var(--radius);
    background:var(--navy);
    color:#fff;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
}

.cv-card{
    background:#fff;
    border-radius:14px;
    border:1px solid var(--border);
    overflow:hidden;
    box-shadow:var(--shadow);
}

.cv-card-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:18px 24px;
    border-bottom:1px solid var(--border);
    background:var(--light);
}

.cv-card-header h2{
    font-size:16px;
    color:var(--navy);
    margin-bottom:4px;
}

.cv-card-header p{
    font-size:13px;
    color:var(--text);
}

.cv-grid-2{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
}

.form-group{
    display:flex;
    flex-direction:column;
    gap:6px;
}

.form-group label{
    font-size:13px;
    font-weight:600;
    color:var(--navy);
}

.form-group input,
.form-group textarea,
.form-group select{
    width:100%;
    padding:11px 14px;
    border:1px solid var(--border);
    border-radius:var(--radius);
    font-size:14px;
}

.cv-cards-preview{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:18px;
    margin-bottom:24px;
}

.cvp-card{
    background:#fff;
    border-radius:14px;
    border:1px solid var(--border);
    padding:18px;
    display:flex;
    gap:16px;
    box-shadow:var(--shadow);
}

.cvp-photo{
    width:72px;
    height:72px;
    border-radius:50%;
    overflow:hidden;
    flex-shrink:0;
}

.cvp-photo img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.cvp-role{
    font-size:12px;
    color:var(--red);
    font-weight:700;
    margin:5px 0;
}

.cvp-body p{
    font-size:13px;
    color:var(--text);
    line-height:1.6;
}

.cv-list{
    padding:16px;
}

.cv-list-item{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    padding:16px;
    border:1px solid var(--border);
    border-radius:12px;
    margin-bottom:12px;
}

.cv-photo{
    width:56px;
    height:56px;
    border-radius:50%;
    overflow:hidden;
    flex-shrink:0;
}

.cv-photo img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.cv-list-content{
    flex:1;
}

.tm-role{
    display:block;
    color:var(--red);
    font-size:12px;
    font-weight:700;
    margin-top:5px;
}

.cv-list-actions{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
}

.cv-toggle,
.cv-btn-edit,
.cv-btn-del{
    border:none;
    border-radius:8px;
    padding:8px 12px;
    font-size:12px;
    font-weight:600;
    cursor:pointer;
}

.cv-toggle.on{
    background:#dcfce7;
    color:#166534;
}

.cv-toggle.off{
    background:#fee2e2;
    color:#991b1b;
}

.cv-btn-edit{
    background:var(--blue-light);
    color:var(--blue);
}

.cv-btn-del{
    background:#fee2e2;
    color:var(--red);
}

.modal-backdrop{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.45);
    display:flex;
    align-items:center;
    justify-content:center;
    z-index:999;
    padding:20px;
}

.modal-box{
    width:100%;
    max-width:900px;
    background:#fff;
    border-radius:18px;
    overflow:hidden;
}

.modal-head{
    padding:20px 24px;
    border-bottom:1px solid var(--border);
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.modal-body{
    padding:24px;
}

.modal-foot{
    padding:18px 24px;
    border-top:1px solid var(--border);
    display:flex;
    justify-content:flex-end;
    gap:10px;
}

.btn-save{
    padding:10px 20px;
    background:var(--red);
    color:#fff;
    border:none;
    border-radius:10px;
    font-weight:600;
}

.btn-cancel{
    padding:10px 20px;
    background:var(--light);
    border:none;
    border-radius:10px;
}

.value-modal-preview{
    display:flex;
    gap:18px;
    background:var(--light);
    padding:18px;
    border-radius:14px;
    margin-bottom:24px;
}

.tm-modal-photo{
    width:90px;
    height:90px;
    border-radius:50%;
    overflow:hidden;
    background:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:40px;
}

.tm-modal-photo img{
    width:100%;
    height:100%;
    object-fit:cover;
}

@media(max-width:768px){

    .cv-grid-2{
        grid-template-columns:1fr;
    }

    .cv-cards-preview{
        grid-template-columns:1fr;
    }

    .cv-list-item{
        flex-direction:column;
        align-items:flex-start;
    }

}

</style>