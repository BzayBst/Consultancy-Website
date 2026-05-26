<div class="sa-wrap" x-data>
    <div class="sa-header">
        <div>
            <h1>Study Abroad</h1>
            <p>Manage the listing page and destination detail pages.</p>
        </div>
        <div class="sa-header-actions">
            <a href="{{ route('study-abroad') }}" target="_blank" class="btn-preview">Preview Page</a>
            <button wire:click="openCreate" class="btn-add">+ Add Destination</button>
        </div>
    </div>

    @if (session('success'))
        <div class="alert-success" x-data="{ show:true }" x-show="show" x-init="setTimeout(()=>show=false,3000)">
            {{ session('success') }}
        </div>
    @endif

    <div class="sa-tabs">
        <button wire:click="setTab('page')" class="sa-tab {{ $activeTab === 'page' ? 'active' : '' }}">Page Settings</button>
        <button wire:click="setTab('destinations')" class="sa-tab {{ $activeTab === 'destinations' ? 'active' : '' }}">
            Destinations <span>{{ $destinations->total() }}</span>
        </button>
    </div>

    @if($activeTab === 'page')
    <form wire:submit="savePage">
        <div class="sa-card">
            <div class="sa-card-header">
                <h2>Hero Banner</h2>
                <p>Controls the top banner on the Study Abroad page.</p>
            </div>
            <div class="sa-preview">
                <span>{{ $hero_badge ?: 'Global Opportunities' }}</span>
                <strong>{{ $hero_title ?: 'Choose Your Dream' }} {{ $hero_highlight }}</strong>
                <p>{{ Str::limit($hero_subtitle, 130) }}</p>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Badge</label>
                    <input type="text" wire:model.live="hero_badge">
                    @error('hero_badge') <small>{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>Highlight</label>
                    <input type="text" wire:model.live="hero_highlight">
                    @error('hero_highlight') <small>{{ $message }}</small> @enderror
                </div>
                <div class="form-group full">
                    <label>Title <span>*</span></label>
                    <input type="text" wire:model.live="hero_title">
                    @error('hero_title') <small>{{ $message }}</small> @enderror
                </div>
                <div class="form-group full">
                    <label>Subtitle</label>
                    <textarea rows="3" wire:model.live="hero_subtitle"></textarea>
                    @error('hero_subtitle') <small>{{ $message }}</small> @enderror
                </div>
            </div>
        </div>

        <div class="sa-card">
            <div class="sa-card-header">
                <h2>Listing & CTA Text</h2>
                <p>Controls the section heading and bottom call-to-action.</p>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Section Label</label>
                    <input type="text" wire:model.live="section_label">
                    @error('section_label') <small>{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>Section Title <span>*</span></label>
                    <input type="text" wire:model.live="section_title">
                    @error('section_title') <small>{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>CTA Title</label>
                    <input type="text" wire:model.live="cta_title">
                    @error('cta_title') <small>{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>CTA Button Label</label>
                    <input type="text" wire:model.live="cta_button_label">
                    @error('cta_button_label') <small>{{ $message }}</small> @enderror
                </div>
                <div class="form-group full">
                    <label>CTA Subtitle</label>
                    <textarea rows="3" wire:model.live="cta_subtitle"></textarea>
                    @error('cta_subtitle') <small>{{ $message }}</small> @enderror
                </div>
                <div class="form-group full">
                    <label>CTA Button URL</label>
                    <input type="text" wire:model.live="cta_button_url" placeholder="{{ route('contact') }}">
                    @error('cta_button_url') <small>{{ $message }}</small> @enderror
                </div>
            </div>
        </div>

        <div class="sa-actions">
            <button type="submit" class="btn-save" wire:loading.attr="disabled">Save Page Settings</button>
        </div>
    </form>
    @endif

    @if($activeTab === 'destinations')
    <div class="sa-filters">
        <div class="sa-search">
            <span>Search</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Country, title, tag">
        </div>
        <select wire:model.live="filterActive">
            <option value="">All Visibility</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="trashed">Trashed</option>
        </select>
        <select wire:model.live="perPage">
            <option value="10">10 / page</option>
            <option value="25">25 / page</option>
            <option value="50">50 / page</option>
        </select>
    </div>

    <div class="sa-list">
        @forelse($destinations as $destination)
        <div class="sa-row {{ $destination->trashed() ? 'is-trashed' : '' }}">
            <div class="sa-thumb">
                @if($destination->card_image_url)
                    <img src="{{ $destination->card_image_url }}" alt="{{ $destination->country }}">
                @else
                    <span>{{ $destination->flag ?: strtoupper(substr($destination->country, 0, 1)) }}</span>
                @endif
            </div>
            <div class="sa-row-body">
                <strong>{{ $destination->card_title ?: 'Study in ' . $destination->country }}</strong>
                <p>{{ $destination->card_tag ?: $destination->country }}</p>
                <small>{{ $destination->slug }} - Order {{ $destination->sort_order }}</small>
            </div>
            <div class="sa-row-actions">
                @if($destination->trashed())
                    <span class="trashed-label">Trashed</span>
                    <button wire:click="confirmRestore({{ $destination->id }})" class="btn-restore">Restore</button>
                @else
                    <a href="{{ route('study-abroad-detail', $destination->slug) }}" target="_blank" class="btn-link">View</a>
                    <button wire:click="toggleActive({{ $destination->id }})" class="btn-toggle {{ $destination->is_active ? 'on' : 'off' }}">
                        {{ $destination->is_active ? 'Visible' : 'Hidden' }}
                    </button>
                    <button wire:click="openEdit({{ $destination->id }})" class="btn-edit">Edit</button>
                    <button wire:click="confirmDelete({{ $destination->id }})" class="btn-delete">Delete</button>
                @endif
            </div>
        </div>
        @empty
        <div class="sa-empty">
            <strong>No destinations yet.</strong>
            <span>Add Japan, Australia, UK, Canada, or any destination you offer.</span>
        </div>
        @endforelse
    </div>

    @if($destinations->hasPages())
        <div class="sa-pagination">{{ $destinations->links() }}</div>
    @endif
    @endif

    @if($showModal)
    <div class="modal-backdrop" x-on:keydown.escape.window="$wire.closeModal()">
        <div class="modal-box" @click.outside="$wire.closeModal()">
            <div class="modal-head">
                <h2>{{ $isEdit ? 'Edit Destination' : 'Add Destination' }}</h2>
                <button wire:click="closeModal" class="modal-close">x</button>
            </div>

            <form wire:submit.prevent="saveDestination">
                <div class="modal-body">
                    @if($errors->any())
                    <div class="form-error-summary">
                        Please check the required fields before saving.
                    </div>
                    @endif

                    <div class="destination-subtabs">
                        @foreach([
                            'listing' => 'Listing',
                            'overview' => 'Overview',
                            'benefits' => 'Benefits',
                            'courses' => 'Courses',
                            'scholarship' => 'Scholarship',
                            'cities' => 'Cities',
                            'universities' => 'Institutions',
                            'faqs' => 'FAQs',
                        ] as $tab => $label)
                            <button type="button" wire:click="setDestinationTab('{{ $tab }}')" class="destination-subtab {{ $destinationTab === $tab ? 'active' : '' }}">{{ $label }}</button>
                        @endforeach
                    </div>

                    @if($destinationTab === 'listing')
                    <div class="subtab-panel">
                        <div class="modal-section-title">Listing Card</div>
                        <div class="form-grid no-pad">
                            <div class="form-group">
                                <label>Country <span>*</span></label>
                                <input type="text" wire:model.live="country" placeholder="Japan">
                                @error('country') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" wire:model.live="slug" placeholder="japan">
                                @error('slug') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Flag / Short Label</label>
                                <input type="text" wire:model.live="flag" placeholder="Japan">
                                @error('flag') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Sort Order</label>
                                <input type="number" min="0" wire:model.live="sort_order">
                                @error('sort_order') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Card Tag</label>
                                <input type="text" wire:model.live="card_tag" placeholder="Asia - High Tech & Culture">
                                @error('card_tag') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Card Title</label>
                                <input type="text" wire:model.live="card_title" placeholder="Study in Japan">
                                @error('card_title') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group full">
                                <label>Card Description</label>
                                <textarea rows="3" wire:model.live="card_description"></textarea>
                                @error('card_description') <small>{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <label class="upload-box">
                            @if($card_image_upload)
                                <img src="{{ $card_image_upload->temporaryUrl() }}" alt="Preview">
                            @elseif($card_image_current)
                                <img src="{{ str_starts_with($card_image_current, 'http') ? $card_image_current : Storage::url($card_image_current) }}" alt="Current">
                            @else
                                <div><strong>Upload card image</strong><span>JPG, PNG or WebP up to 3MB</span></div>
                            @endif
                            <input type="file" wire:model="card_image_upload" accept="image/png,image/jpeg,image/webp">
                        </label>
                        @error('card_image_upload') <small class="upload-error">{{ $message }}</small> @enderror
                        <div wire:loading wire:target="card_image_upload" class="uploading">Uploading image...</div>

                        <label class="toggle-row">
                            <input type="checkbox" wire:model.live="is_active">
                            <span>Show this destination on the frontend</span>
                        </label>
                    </div>
                    @endif

                    @if($destinationTab === 'overview')
                    <div class="subtab-panel">
                        <div class="modal-section-title">Overview</div>
                        <div class="form-group full">
                            <label>Overview Text</label>
                            <textarea rows="8" wire:model.live="overview"></textarea>
                        </div>
                    </div>
                    @endif

                    @if($destinationTab === 'benefits')
                    <div class="subtab-panel">
                        <div class="modal-section-title with-action">
                            <span>Benefits</span>
                            <button type="button" wire:click="addBenefit" class="btn-add-inline">+ Add Benefit</button>
                        </div>
                        <div class="form-grid no-pad">
                            <div class="form-group">
                                <label>Benefits Title</label>
                                <input type="text" wire:model.live="benefits_title" placeholder="Why Study in Japan?">
                            </div>
                            <div class="form-group">
                                <label>Benefits Description</label>
                                <textarea rows="3" wire:model.live="benefits_description"></textarea>
                            </div>
                        </div>
                        <div class="repeat-list">
                            @forelse($benefits as $i => $benefit)
                            <div class="repeat-card">
                                <div class="repeat-head">
                                    <strong>Benefit {{ $i + 1 }}</strong>
                                    <button type="button" wire:click="removeBenefit({{ $i }})">Remove</button>
                                </div>
                                <div class="form-grid no-pad">
                                    <div class="form-group">
                                        <label>Icon</label>
                                        <input type="text" wire:model.live="benefits.{{ $i }}.icon" placeholder="*">
                                    </div>
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" wire:model.live="benefits.{{ $i }}.title">
                                    </div>
                                    <div class="form-group full">
                                        <label>Description</label>
                                        <textarea rows="2" wire:model.live="benefits.{{ $i }}.description"></textarea>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="repeat-empty">No benefits yet. Click <strong>+ Add Benefit</strong>.</div>
                            @endforelse
                        </div>
                    </div>
                    @endif

                    @if($destinationTab === 'courses')
                    <div class="subtab-panel">
                        <div class="modal-section-title with-action">
                            <span>Popular Courses</span>
                            <button type="button" wire:click="addCourse" class="btn-add-inline">+ Add Course</button>
                        </div>
                        <div class="repeat-list">
                            @forelse($courses as $i => $course)
                            <div class="repeat-card">
                                <div class="repeat-head">
                                    <strong>Course {{ $i + 1 }}</strong>
                                    <button type="button" wire:click="removeCourse({{ $i }})">Remove</button>
                                </div>
                                <div class="form-grid no-pad">
                                    <div class="form-group">
                                        <label>Tag</label>
                                        <input type="text" wire:model.live="courses.{{ $i }}.tag" placeholder="Technology">
                                    </div>
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" wire:model.live="courses.{{ $i }}.title">
                                    </div>
                                    <div class="form-group full">
                                        <label>Description</label>
                                        <textarea rows="2" wire:model.live="courses.{{ $i }}.description"></textarea>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="repeat-empty">No courses yet. Click <strong>+ Add Course</strong>.</div>
                            @endforelse
                        </div>
                    </div>
                    @endif

                    @if($destinationTab === 'scholarship')
                    <div class="subtab-panel">
                        <div class="modal-section-title">Scholarship</div>
                        <div class="form-group full">
                            <label>Scholarship Text</label>
                            <textarea rows="7" wire:model.live="scholarship_text"></textarea>
                        </div>
                    </div>
                    @endif

                    @if($destinationTab === 'cities')
                    <div class="subtab-panel">
                        <div class="modal-section-title with-action">
                            <span>Popular Cities</span>
                            <button type="button" wire:click="addCity" class="btn-add-inline">+ Add City</button>
                        </div>
                        <div class="repeat-list">
                            @forelse($cities as $i => $city)
                            <div class="repeat-card">
                                <div class="repeat-head">
                                    <strong>City {{ $i + 1 }}</strong>
                                    <button type="button" wire:click="removeCity({{ $i }})">Remove</button>
                                </div>
                                <div class="form-grid no-pad">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" wire:model.live="cities.{{ $i }}.title">
                                    </div>
                                    <div class="form-group">
                                        <label>City Image</label>
                                        <label class="upload-box small-upload">
                                            @if(! empty($cityImageUploads[$i]))
                                                <img src="{{ $cityImageUploads[$i]->temporaryUrl() }}" alt="City preview">
                                            @elseif(! empty($city['image']))
                                                <img src="{{ str_starts_with($city['image'], 'http') ? $city['image'] : Storage::url($city['image']) }}" alt="Current city image">
                                            @else
                                                <div><strong>Upload city image</strong><span>JPG, PNG or WebP up to 3MB</span></div>
                                            @endif
                                            <input type="file" wire:model="cityImageUploads.{{ $i }}" accept="image/png,image/jpeg,image/webp">
                                        </label>
                                        @error("cityImageUploads.$i") <small class="upload-error">{{ $message }}</small> @enderror
                                        <div wire:loading wire:target="cityImageUploads.{{ $i }}" class="uploading">Uploading image...</div>
                                    </div>
                                    <div class="form-group full">
                                        <label>Description</label>
                                        <textarea rows="2" wire:model.live="cities.{{ $i }}.description"></textarea>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="repeat-empty">No cities yet. Click <strong>+ Add City</strong>.</div>
                            @endforelse
                        </div>
                    </div>
                    @endif

                    @if($destinationTab === 'universities')
                    <div class="subtab-panel">
                        <div class="modal-section-title with-action">
                            <span>Institutions</span>
                            <button type="button" wire:click="addUniversity" class="btn-add-inline">+ Add Institution</button>
                        </div>
                        <div class="repeat-list">
                            @forelse($universities as $i => $university)
                            <div class="repeat-card">
                                <div class="repeat-head">
                                    <strong>Institution {{ $i + 1 }}</strong>
                                    <button type="button" wire:click="removeUniversity({{ $i }})">Remove</button>
                                </div>
                                <div class="form-grid no-pad">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" wire:model.live="universities.{{ $i }}.name">
                                    </div>
                                    <div class="form-group">
                                        <label>Logo</label>
                                        <label class="upload-box small-upload">
                                            @if(! empty($universityLogoUploads[$i]))
                                                <img src="{{ $universityLogoUploads[$i]->temporaryUrl() }}" alt="Logo preview">
                                            @elseif(! empty($university['logo']))
                                                <img src="{{ str_starts_with($university['logo'], 'http') ? $university['logo'] : Storage::url($university['logo']) }}" alt="Current logo">
                                            @else
                                                <div><strong>Upload logo</strong><span>PNG, JPG, WebP or SVG up to 3MB</span></div>
                                            @endif
                                            <input type="file" wire:model="universityLogoUploads.{{ $i }}" accept="image/png,image/jpeg,image/webp,image/svg+xml">
                                        </label>
                                        @error("universityLogoUploads.$i") <small class="upload-error">{{ $message }}</small> @enderror
                                        <div wire:loading wire:target="universityLogoUploads.{{ $i }}" class="uploading">Uploading logo...</div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="repeat-empty">No institutions yet. Click <strong>+ Add Institution</strong>.</div>
                            @endforelse
                        </div>
                    </div>
                    @endif

                    @if($destinationTab === 'faqs')
                    <div class="subtab-panel">
                        <div class="modal-section-title with-action">
                            <span>FAQs</span>
                            <button type="button" wire:click="addFaq" class="btn-add-inline">+ Add FAQ</button>
                        </div>
                        <div class="repeat-list">
                            @forelse($faqs as $i => $faq)
                            <div class="repeat-card">
                                <div class="repeat-head">
                                    <strong>FAQ {{ $i + 1 }}</strong>
                                    <button type="button" wire:click="removeFaq({{ $i }})">Remove</button>
                                </div>
                                <div class="form-group full">
                                    <label>Question</label>
                                    <input type="text" wire:model.live="faqs.{{ $i }}.question">
                                </div>
                                <div class="form-group full">
                                    <label>Answer</label>
                                    <textarea rows="3" wire:model.live="faqs.{{ $i }}.answer"></textarea>
                                </div>
                            </div>
                            @empty
                            <div class="repeat-empty">No FAQs yet. Click <strong>+ Add FAQ</strong>.</div>
                            @endforelse
                        </div>
                    </div>
                    @endif
                </div>

                <div class="modal-foot">
                    <button type="button" wire:click="closeModal" class="btn-cancel">Cancel</button>
                    <button type="button" wire:click="saveDestination" class="btn-save" wire:loading.attr="disabled" wire:target="saveDestination,card_image_upload">
                        <span wire:loading.remove wire:target="saveDestination">{{ $isEdit ? 'Update Destination' : 'Add Destination' }}</span>
                        <span wire:loading wire:target="saveDestination">Saving...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if($confirmingDeleteId)
    <div class="modal-backdrop">
        <div class="confirm-box">
            <h2>Delete destination?</h2>
            <p>This moves it to trash. You can restore it later.</p>
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
            <h2>Restore destination?</h2>
            <p>This will return it to the destination manager.</p>
            <div>
                <button wire:click="cancelRestore" class="btn-cancel">Cancel</button>
                <button wire:click="restore" class="btn-confirm-restore">Restore</button>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.sa-wrap { padding:24px; }
.sa-header { display:flex;justify-content:space-between;align-items:center;gap:16px;margin-bottom:18px; }
.sa-header h1 { font-family:'Playfair Display',serif;font-size:28px;color:var(--navy);margin:0 0 4px; }
.sa-header p { color:var(--text);font-size:14px;margin:0; }
.sa-header-actions { display:flex;gap:10px;flex-wrap:wrap; }
.btn-preview,.btn-add,.btn-save,.btn-cancel,.btn-confirm-delete,.btn-confirm-restore { border:none;border-radius:8px;padding:10px 16px;font-size:13px;font-weight:700;text-decoration:none;cursor:pointer; }
.btn-preview { background:#fff;color:var(--navy);border:1px solid var(--border); }
.btn-add { background:var(--navy);color:#fff; }
.btn-save { background:var(--red);color:#fff; }
.btn-cancel { background:#f1f5f9;color:var(--navy); }
.btn-confirm-delete { background:var(--red);color:#fff; }
.btn-confirm-restore,.btn-restore { background:#dcfce7;color:#166534; }
.alert-success { background:#dcfce7;color:#166534;border:1px solid #bbf7d0;border-radius:8px;padding:12px 14px;margin-bottom:16px;font-size:14px; }
.sa-tabs,.destination-subtabs { display:flex;gap:4px;border-bottom:2px solid var(--border);margin-bottom:20px;overflow-x:auto; }
.sa-tab,.destination-subtab { border:none;background:transparent;padding:11px 20px;border-bottom:2px solid transparent;margin-bottom:-2px;border-radius:7px 7px 0 0;color:var(--text);font-weight:700;cursor:pointer;white-space:nowrap; }
.sa-tab.active,.destination-subtab.active { color:var(--navy);background:#fff;border-bottom-color:var(--red); }
.sa-tab span { background:#e8edfd;color:var(--blue);border-radius:999px;padding:2px 8px;font-size:11px;margin-left:6px; }
.sa-card { background:#fff;border:1px solid var(--border);border-radius:12px;box-shadow:0 4px 14px rgba(15,23,42,.05);margin-bottom:18px;overflow:hidden; }
.sa-card-header { padding:18px 22px;border-bottom:1px solid var(--border);background:#f8fafc; }
.sa-card-header h2 { margin:0 0 3px;color:var(--navy);font-size:17px; }
.sa-card-header p { margin:0;color:var(--text);font-size:13px; }
.sa-preview { margin:20px 22px 0;padding:20px;border-radius:10px;background:var(--navy);color:#fff; }
.sa-preview span { display:block;color:#ffcccc;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:2px;margin-bottom:8px; }
.sa-preview strong { display:block;font-family:'Playfair Display',serif;font-size:24px;margin-bottom:8px; }
.sa-preview p { color:rgba(255,255,255,.78);margin:0; }
.form-grid { display:grid;grid-template-columns:1fr 1fr;gap:14px 18px;padding:22px; }
.form-grid.no-pad { padding:0; }
.form-group { display:flex;flex-direction:column;gap:6px;margin-bottom:14px; }
.form-group.full,.full { grid-column:1/-1; }
.form-group label { color:var(--navy);font-size:13px;font-weight:800; }
.form-group label span { color:var(--red); }
.form-group input,.form-group textarea,.sa-filters select { border:1.5px solid var(--border);border-radius:8px;padding:10px 12px;font:inherit;outline:none;background:#fff; }
.form-group textarea { resize:vertical;line-height:1.5; }
.form-group input:focus,.form-group textarea:focus { border-color:var(--blue);box-shadow:0 0 0 3px rgba(41,82,227,.1); }
.form-group small,.upload-error { color:var(--red);font-size:12px; }
.form-error-summary { background:#fee2e2;color:#991b1b;border:1px solid #fecaca;border-radius:8px;padding:11px 13px;margin-bottom:16px;font-size:13px;font-weight:700; }
.sa-actions { display:flex;justify-content:flex-end;margin-top:-4px; }
.sa-filters { display:flex;gap:10px;align-items:center;flex-wrap:wrap;margin-bottom:16px; }
.sa-search { flex:1;min-width:240px;background:#fff;border:1px solid var(--border);border-radius:8px;display:flex;align-items:center;gap:10px;padding:9px 12px; }
.sa-search span { font-size:12px;font-weight:800;color:var(--navy); }
.sa-search input { flex:1;border:none;outline:none;font:inherit;background:transparent; }
.sa-list { display:flex;flex-direction:column;gap:10px; }
.sa-row { display:flex;align-items:center;gap:14px;background:#fff;border:1px solid var(--border);border-radius:10px;padding:13px 14px;box-shadow:0 4px 14px rgba(15,23,42,.04); }
.sa-row.is-trashed { opacity:.65;background:#fff5f5; }
.sa-thumb { width:92px;height:62px;border-radius:8px;overflow:hidden;background:#e8edfd;color:var(--navy);display:flex;align-items:center;justify-content:center;font-weight:800;flex-shrink:0; }
.sa-thumb img { width:100%;height:100%;object-fit:cover; }
.sa-row-body { flex:1;min-width:0; }
.sa-row-body strong { color:var(--navy);font-size:15px;display:block;margin-bottom:3px; }
.sa-row-body p { color:var(--text);font-size:13px;margin:0 0 3px; }
.sa-row-body small { color:#64748b;font-size:11px; }
.sa-row-actions { display:flex;align-items:center;gap:6px;flex-wrap:wrap;justify-content:flex-end; }
.sa-row-actions button,.btn-link { border:none;border-radius:7px;padding:7px 10px;font-size:12px;font-weight:800;cursor:pointer;text-decoration:none; }
.btn-link { background:#fff;color:var(--navy);border:1px solid var(--border); }
.btn-toggle.on { background:#dcfce7;color:#166534; }
.btn-toggle.off { background:#fee2e2;color:#991b1b; }
.btn-edit { background:#e8edfd;color:var(--blue); }
.btn-delete { background:#fee2e2;color:var(--red); }
.trashed-label { color:#991b1b;font-size:12px;font-weight:800; }
.sa-empty,.repeat-empty { background:#fff;border:1px dashed var(--border);border-radius:10px;padding:28px;text-align:center;color:#64748b; }
.sa-empty { display:flex;flex-direction:column;gap:5px; }
.sa-empty strong { color:var(--navy); }
.sa-pagination { background:#fff;border:1px solid var(--border);border-radius:8px;margin-top:14px;padding:12px 16px; }
.modal-backdrop { position:fixed;inset:0;z-index:1000;background:rgba(13,21,96,.45);display:flex;align-items:center;justify-content:center;padding:20px; }
.modal-box,.confirm-box { background:#fff;border-radius:12px;box-shadow:0 20px 60px rgba(0,0,0,.25);width:100%; }
.modal-box { max-width:980px;max-height:90vh;overflow:hidden;display:flex;flex-direction:column; }
.modal-box form { display:flex;flex-direction:column;flex:1;min-height:0; }
.confirm-box { max-width:390px;padding:24px;text-align:center; }
.confirm-box h2 { font-family:'Playfair Display',serif;color:var(--navy);font-size:20px;margin-bottom:8px; }
.confirm-box p { color:var(--text);font-size:14px;line-height:1.5;margin-bottom:18px; }
.modal-head,.modal-foot { display:flex;align-items:center;justify-content:space-between;gap:12px;padding:16px 20px;border-bottom:1px solid var(--border); }
.modal-foot { justify-content:flex-end;border-top:1px solid var(--border);border-bottom:0; }
.modal-head h2 { font-family:'Playfair Display',serif;color:var(--navy);font-size:20px;margin:0; }
.modal-close { border:none;background:#f1f5f9;border-radius:6px;width:30px;height:30px;cursor:pointer;color:var(--navy); }
.modal-head,.modal-foot { flex-shrink:0; }
.modal-body { padding:20px;overflow-y:auto;flex:1;min-height:0; }
.modal-section-title { color:var(--navy);font-size:14px;font-weight:900;margin:8px 0 14px;padding-bottom:8px;border-bottom:1px solid var(--border); }
.modal-section-title.with-action { display:flex;align-items:center;justify-content:space-between;gap:12px; }
.btn-add-inline { border:none;border-radius:7px;background:var(--navy);color:#fff;padding:8px 12px;font-size:12px;font-weight:800;cursor:pointer; }
.upload-box { border:2px dashed var(--border);border-radius:10px;min-height:190px;display:flex;align-items:center;justify-content:center;text-align:center;cursor:pointer;overflow:hidden;position:relative;background:#f8fafc;margin:8px 0 18px; }
.upload-box:hover { border-color:var(--blue);background:#eef3ff; }
.upload-box img { width:100%;height:230px;object-fit:contain;padding:10px; }
.upload-box input { position:absolute;inset:0;opacity:0;cursor:pointer; }
.upload-box strong { display:block;color:var(--navy);margin-bottom:4px; }
.small-upload { min-height:130px;margin-bottom:6px; }
.small-upload img { height:140px; }
.upload-box span,.uploading { color:#64748b;font-size:12px; }
.toggle-row { display:flex;align-items:center;gap:9px;margin-top:16px;color:var(--navy);font-size:14px;font-weight:700; }
.repeat-list { display:flex;flex-direction:column;gap:12px; }
.repeat-card { border:1px solid var(--border);border-radius:10px;padding:14px;background:#f8fafc; }
.repeat-head { display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:12px; }
.repeat-head strong { color:var(--navy);font-size:14px; }
.repeat-head button { border:none;background:#fee2e2;color:var(--red);border-radius:7px;padding:6px 10px;font-size:12px;font-weight:800;cursor:pointer; }
@media(max-width:760px){
  .sa-wrap { padding:16px; }
  .sa-header,.sa-row { align-items:flex-start;flex-direction:column; }
  .form-grid { grid-template-columns:1fr; }
  .sa-row-actions { justify-content:flex-start; }
}
</style>
