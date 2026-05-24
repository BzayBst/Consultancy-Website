{{-- resources/views/livewire/admin/team.blade.php --}}
<div>

    {{-- =====================================================================
         PAGE HEADER
    ====================================================================== --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="page-title mb-1">Team Members</h4>
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Team</li>
            </ol>
        </div>
        <button wire:click="openCreate" class="btn btn-primary">
            <i class="ti ti-plus me-1"></i> Add Member
        </button>
    </div>

    {{-- =====================================================================
         FILTERS
    ====================================================================== --}}
    <div class="card mb-3">
        <div class="card-body py-3">
            <div class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-search"></i></span>
                        <input type="text"
                               wire:model.live.debounce.300ms="search"
                               class="form-control"
                               placeholder="Search name, designation, email…">
                    </div>
                </div>
                <div class="col-md-3">
                    <select wire:model.live="status" class="form-select">
                        <option value="">All Members</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="trashed">Trashed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model.live="perPage" class="form-select">
                        <option value="10">10 / page</option>
                        <option value="25">25 / page</option>
                        <option value="50">50 / page</option>
                    </select>
                </div>
                <div class="col-md-2 text-end">
                    <span class="text-muted small">{{ $teams->total() }} result(s)</span>
                </div>
            </div>
        </div>
    </div>

    {{-- =====================================================================
         TABLE
    ====================================================================== --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:56px"></th>
                            <th>Member</th>
                            <th>Designation</th>
                            <th style="width:80px" class="text-center">Order</th>
                            <th style="width:110px" class="text-center">Status</th>
                            <th style="width:120px" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($teams as $team)
                            <tr @class(['opacity-50' => $team->trashed()])>

                                <td>
                                    <img src="{{ $team->photo_url }}"
                                         alt="{{ $team->name }}"
                                         class="rounded-circle object-fit-cover"
                                         width="42" height="42"
                                         style="border:2px solid #e2e8f0">
                                </td>

                                <td>
                                    <div class="fw-semibold">{{ $team->name }}</div>
                                    @if($team->email)
                                        <div class="small text-muted">{{ $team->email }}</div>
                                    @endif
                                </td>

                                <td>
                                    <span class="badge bg-primary-subtle text-primary fw-semibold"
                                          style="font-size:10px;letter-spacing:.5px;text-transform:uppercase">
                                        {{ $team->designation }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="badge bg-secondary-subtle text-secondary">
                                        {{ $team->order }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    @if(! $team->trashed())
                                        <button wire:click="toggleActive({{ $team->id }})"
                                                class="btn btn-sm {{ $team->is_active ? 'btn-success' : 'btn-secondary' }}">
                                            {{ $team->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    @else
                                        <span class="badge bg-danger">Trashed</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if(! $team->trashed())
                                        <button wire:click="openEdit({{ $team->id }})"
                                                class="btn btn-sm btn-outline-primary me-1"
                                                title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                        <button wire:click="confirmDelete({{ $team->id }})"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Delete">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    @else
                                        <button wire:click="confirmRestore({{ $team->id }})"
                                                class="btn btn-sm btn-outline-success"
                                                title="Restore">
                                            <i class="ti ti-refresh"></i>
                                        </button>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="ti ti-users-group d-block mb-2" style="font-size:2rem"></i>
                                    No team members found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($teams->hasPages())
            <div class="card-footer d-flex align-items-center justify-content-between py-2">
                <div class="small text-muted">
                    Showing {{ $teams->firstItem() }}–{{ $teams->lastItem() }} of {{ $teams->total() }}
                </div>
                {{ $teams->links() }}
            </div>
        @endif
    </div>


    {{-- =====================================================================
         CREATE / EDIT MODAL
    ====================================================================== --}}
    @if($showModal)
    <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5)">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">

                {{-- Header --}}
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ti ti-{{ $isEdit ? 'edit' : 'user-plus' }} me-2 text-primary"></i>
                        {{ $isEdit ? 'Edit Team Member' : 'Add Team Member' }}
                    </h5>
                    <button type="button" wire:click="closeModal" class="btn-close"></button>
                </div>

                {{-- Body --}}
                <div class="modal-body">
                    <div class="row g-4">

                        {{-- ===== LEFT: MAIN DETAILS ===== --}}
                        <div class="col-lg-8">

                            {{-- Basic Info --}}
                            <div class="card mb-4 border">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0 small fw-bold text-uppercase text-muted">
                                        <i class="ti ti-user me-1"></i> Basic Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">
                                                Full Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                   wire:model.live="name"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   placeholder="e.g. Ram Prasad Sharma">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">
                                                Designation <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                   wire:model="designation"
                                                   class="form-control @error('designation') is-invalid @enderror"
                                                   placeholder="e.g. Founder & CEO">
                                            @error('designation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">URL Slug</label>
                                            <div class="input-group">
                                                <span class="input-group-text text-muted small">/team/</span>
                                                <input type="text"
                                                       wire:model="slug"
                                                       class="form-control @error('slug') is-invalid @enderror"
                                                       placeholder="auto-generated">
                                            </div>
                                            @error('slug')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Display Order</label>
                                            <input type="number"
                                                   wire:model="order"
                                                   class="form-control @error('order') is-invalid @enderror"
                                                   min="0">
                                            @error('order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Lower = appears first.</div>
                                        </div>

                                        <div class="col-md-3 d-flex align-items-end pb-1">
                                            <div class="form-check form-switch">
                                                <input type="checkbox"
                                                       wire:model="is_active"
                                                       class="form-check-input"
                                                       id="modal_is_active"
                                                       role="switch">
                                                <label class="form-check-label fw-semibold" for="modal_is_active">
                                                    Active
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Short Bio</label>
                                            <textarea wire:model="bio"
                                                      class="form-control @error('bio') is-invalid @enderror"
                                                      rows="3"
                                                      maxlength="500"
                                                      placeholder="A brief description about this team member…"></textarea>
                                            <div class="d-flex justify-content-between mt-1">
                                                @error('bio')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                @else
                                                    <span></span>
                                                @enderror
                                                <span class="text-muted small">{{ strlen($bio) }} / 500</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- Contact --}}
                            <div class="card mb-4 border">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0 small fw-bold text-uppercase text-muted">
                                        <i class="ti ti-address-book me-1"></i> Contact Details
                                        <span class="fw-normal text-muted">(optional)</span>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Email</label>
                                            <input type="email"
                                                   wire:model="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   placeholder="name@hasuedu.com">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Phone</label>
                                            <input type="text"
                                                   wire:model="phone"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   placeholder="+977-98XXXXXXXX">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Social Links --}}
                            <div class="card border">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0 small fw-bold text-uppercase text-muted">
                                        <i class="ti ti-share me-1"></i> Social Links
                                        <span class="fw-normal text-muted">(optional)</span>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">
                                                <i class="ti ti-brand-facebook text-primary me-1"></i>Facebook
                                            </label>
                                            <input type="url"
                                                   wire:model="social_facebook"
                                                   class="form-control @error('social_facebook') is-invalid @enderror"
                                                   placeholder="https://facebook.com/…">
                                            @error('social_facebook')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">
                                                <i class="ti ti-brand-linkedin text-primary me-1"></i>LinkedIn
                                            </label>
                                            <input type="url"
                                                   wire:model="social_linkedin"
                                                   class="form-control @error('social_linkedin') is-invalid @enderror"
                                                   placeholder="https://linkedin.com/in/…">
                                            @error('social_linkedin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">
                                                <i class="ti ti-brand-x text-primary me-1"></i>X / Twitter
                                            </label>
                                            <input type="url"
                                                   wire:model="social_twitter"
                                                   class="form-control @error('social_twitter') is-invalid @enderror"
                                                   placeholder="https://x.com/…">
                                            @error('social_twitter')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- ===== RIGHT: PHOTO ===== --}}
                        <div class="col-lg-4">
                            <div class="card border">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0 small fw-bold text-uppercase text-muted">
                                        <i class="ti ti-photo me-1"></i> Profile Photo
                                    </h6>
                                </div>
                                <div class="card-body text-center">

                                    {{-- Preview --}}
                                    <div class="mb-3">
                                        @if($photo)
                                            <img src="{{ $photo->temporaryUrl() }}"
                                                 class="rounded-circle object-fit-cover"
                                                 style="width:110px;height:110px;border:3px solid #e2e8f0"
                                                 alt="Preview">
                                            <div class="text-success small mt-1">
                                                <i class="ti ti-check"></i> New photo selected
                                            </div>
                                        @elseif($existingPhoto && ! $removePhoto)
                                            <img src="{{ asset('storage/' . $existingPhoto) }}"
                                                 class="rounded-circle object-fit-cover"
                                                 style="width:110px;height:110px;border:3px solid #e2e8f0"
                                                 alt="Current photo">
                                            <div class="text-muted small mt-1">Current photo</div>
                                        @else
                                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                                                 style="width:110px;height:110px;border:3px solid #e2e8f0">
                                                <i class="ti ti-user text-muted" style="font-size:2.5rem"></i>
                                            </div>
                                            <div class="text-muted small mt-1">No photo</div>
                                        @endif
                                    </div>

                                    <label class="btn btn-outline-primary btn-sm w-100 mb-2">
                                        <i class="ti ti-upload me-1"></i>
                                        {{ $photo ? 'Change' : ($existingPhoto ? 'Replace' : 'Upload Photo') }}
                                        <input type="file"
                                               wire:model="photo"
                                               accept="image/jpg,image/jpeg,image/png,image/webp"
                                               class="d-none">
                                    </label>

                                    @if($existingPhoto && ! $photo)
                                        <div class="form-check text-start mt-2">
                                            <input type="checkbox"
                                                   wire:model.live="removePhoto"
                                                   class="form-check-input"
                                                   id="modal_removePhoto">
                                            <label class="form-check-label small text-danger" for="modal_removePhoto">
                                                Remove current photo
                                            </label>
                                        </div>
                                    @endif

                                    @error('photo')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror

                                    <div wire:loading wire:target="photo" class="mt-2">
                                        <div class="progress" style="height:4px">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated w-100"></div>
                                        </div>
                                        <div class="small text-muted mt-1">Uploading…</div>
                                    </div>

                                    <p class="text-muted small mt-3 mb-0">
                                        JPG, PNG, WebP — max 2 MB<br>Recommended: 400×400 px
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>{{-- /row --}}
                </div>{{-- /modal-body --}}

                {{-- Footer --}}
                <div class="modal-footer">
                    <button type="button" wire:click="closeModal" class="btn btn-secondary">
                        <i class="ti ti-x me-1"></i> Cancel
                    </button>
                    <button type="button"
                            wire:click="save"
                            wire:loading.attr="disabled"
                            class="btn btn-primary">
                        <span wire:loading wire:target="save"
                              class="spinner-border spinner-border-sm me-1"></span>
                        <span wire:loading.remove wire:target="save">
                            <i class="ti ti-device-floppy me-1"></i>
                        </span>
                        {{ $isEdit ? 'Update Member' : 'Create Member' }}
                    </button>
                </div>

            </div>
        </div>
    </div>
    @endif


    {{-- =====================================================================
         DELETE CONFIRM MODAL
    ====================================================================== --}}
    @if($confirmingDeleteId)
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5)">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title text-danger">
                            <i class="ti ti-trash me-1"></i> Move to Trash?
                        </h5>
                    </div>
                    <div class="modal-body small text-muted">
                        This member will be soft-deleted. You can restore them later from the
                        <strong>Trashed</strong> filter.
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button wire:click="cancelDelete" class="btn btn-sm btn-secondary">
                            Cancel
                        </button>
                        <button wire:click="delete" class="btn btn-sm btn-danger">
                            <span wire:loading wire:target="delete"
                                  class="spinner-border spinner-border-sm me-1"></span>
                            Yes, Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif


    {{-- =====================================================================
         RESTORE CONFIRM MODAL
    ====================================================================== --}}
    @if($confirmingRestoreId)
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5)">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title text-success">
                            <i class="ti ti-refresh me-1"></i> Restore Member?
                        </h5>
                    </div>
                    <div class="modal-body small text-muted">
                        This team member will be restored and become visible again.
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button wire:click="cancelRestore" class="btn btn-sm btn-secondary">
                            Cancel
                        </button>
                        <button wire:click="restore" class="btn btn-sm btn-success">
                            <span wire:loading wire:target="restore"
                                  class="spinner-border spinner-border-sm me-1"></span>
                            Yes, Restore
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>