<div class="sa-wrap" x-data>
    <div class="sa-header">
        <div>
            <h1>Courses</h1>
            <p>Manage the courses page and individual course detail pages.</p>
        </div>
        <div class="sa-header-actions">
            <a href="{{ route('courses') }}" target="_blank" class="btn-preview">Preview Page</a>
            <button wire:click="openCreate" class="btn-add">+ Add Course</button>
        </div>
    </div>

    @if (session('success'))
        <div class="alert-success" x-data="{ show:true }" x-show="show" x-init="setTimeout(()=>show=false,3000)">
            {{ session('success') }}
        </div>
    @endif

    <div class="sa-tabs">
        <button wire:click="setTab('page')" class="sa-tab {{ $activeTab === 'page' ? 'active' : '' }}">Page Settings</button>
        <button wire:click="setTab('courses')" class="sa-tab {{ $activeTab === 'courses' ? 'active' : '' }}">
            Courses <span>{{ $courses->total() }}</span>
        </button>
    </div>

    @if($activeTab === 'page')
    <form wire:submit="savePage">
        <div class="sa-card">
            <div class="sa-card-header">
                <h2>Hero Banner</h2>
                <p>Controls the top banner on the Courses page.</p>
            </div>
            <div class="sa-preview">
                <span>{{ $hero_badge ?: 'HASU Language Institute' }}</span>
                <strong>{{ $hero_title ?: 'Language & Test Prep' }} {{ $hero_highlight }}</strong>
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
                <h2>Intro & Catalog</h2>
                <p>Controls intro text and the course catalog heading.</p>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Intro Label</label>
                    <input type="text" wire:model.live="intro_label">
                </div>
                <div class="form-group">
                    <label>Intro Title</label>
                    <input type="text" wire:model.live="intro_title">
                </div>
                <div class="form-group full">
                    <label>Intro Subtitle</label>
                    <textarea rows="3" wire:model.live="intro_subtitle"></textarea>
                </div>
                <div class="form-group">
                    <label>Catalog Label</label>
                    <input type="text" wire:model.live="catalog_label">
                </div>
                <div class="form-group">
                    <label>Catalog Title</label>
                    <input type="text" wire:model.live="catalog_title">
                </div>
            </div>
        </div>

        <div class="sa-card">
            <div class="sa-card-header with-action">
                <div>
                    <h2>Stats</h2>
                    <p>Numbers shown below the intro section.</p>
                </div>
                <button type="button" wire:click="addStat" class="btn-add-inline">+ Add Stat</button>
            </div>
            <div class="repeat-list">
                @foreach($stats as $i => $stat)
                <div class="repeat-card">
                    <div class="repeat-head">
                        <strong>Stat {{ $i + 1 }}</strong>
                        <button type="button" wire:click="removeStat({{ $i }})">Remove</button>
                    </div>
                    <div class="form-grid no-pad">
                        <div class="form-group">
                            <label>Number</label>
                            <input type="text" wire:model.live="stats.{{ $i }}.number">
                        </div>
                        <div class="form-group">
                            <label>Accent</label>
                            <input type="text" wire:model.live="stats.{{ $i }}.accent">
                        </div>
                        <div class="form-group full">
                            <label>Label</label>
                            <input type="text" wire:model.live="stats.{{ $i }}.label">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="sa-card">
            <div class="sa-card-header with-action">
                <div>
                    <h2>Why Choose Section</h2>
                    <p>Controls the supporting benefit section.</p>
                </div>
                <button type="button" wire:click="addWhyItem" class="btn-add-inline">+ Add Item</button>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Label</label>
                    <input type="text" wire:model.live="why_label">
                </div>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" wire:model.live="why_title">
                </div>
                <div class="form-group full">
                    <label>Description</label>
                    <textarea rows="3" wire:model.live="why_description"></textarea>
                </div>
            </div>
            <div class="repeat-list">
                @foreach($why_items as $i => $item)
                <div class="repeat-card">
                    <div class="repeat-head">
                        <strong>Item {{ $i + 1 }}</strong>
                        <button type="button" wire:click="removeWhyItem({{ $i }})">Remove</button>
                    </div>
                    <div class="form-grid no-pad">
                        <div class="form-group">
                            <label>Icon / Short Label</label>
                            <input type="text" wire:model.live="why_items.{{ $i }}.icon">
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" wire:model.live="why_items.{{ $i }}.title">
                        </div>
                        <div class="form-group full">
                            <label>Description</label>
                            <textarea rows="2" wire:model.live="why_items.{{ $i }}.description"></textarea>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="sa-card">
            <div class="sa-card-header">
                <h2>CTA</h2>
                <p>Controls the bottom call-to-action.</p>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" wire:model.live="cta_title">
                </div>
                <div class="form-group">
                    <label>Button Label</label>
                    <input type="text" wire:model.live="cta_button_label">
                </div>
                <div class="form-group full">
                    <label>Subtitle</label>
                    <textarea rows="3" wire:model.live="cta_subtitle"></textarea>
                </div>
                <div class="form-group">
                    <label>Button URL</label>
                    <input type="text" wire:model.live="cta_button_url">
                </div>
                <div class="form-group">
                    <label>Phone Button URL</label>
                    <input type="text" wire:model.live="cta_phone_url">
                </div>
                <div class="form-group">
                    <label>Phone Button Label</label>
                    <input type="text" wire:model.live="cta_phone_label">
                </div>
            </div>
        </div>

        <div class="sa-actions">
            <button type="submit" class="btn-save" wire:loading.attr="disabled">Save Page Settings</button>
        </div>
    </form>
    @endif

    @if($activeTab === 'courses')
    <div class="sa-filters">
        <div class="sa-search">
            <span>Search</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Title, tag, category">
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
        @forelse($courses as $course)
        <div class="sa-row {{ $course->trashed() ? 'is-trashed' : '' }}">
            <div class="sa-thumb">
                @if($course->image_url)
                    <img src="{{ $course->image_url }}" alt="{{ $course->title }}">
                @else
                    <span>{{ strtoupper(substr($course->title, 0, 1)) }}</span>
                @endif
            </div>
            <div class="sa-row-body">
                <strong>{{ $course->title }}</strong>
                <p>{{ $course->tag ?: $course->category }} {{ $course->is_featured ? '- Featured' : '' }}</p>
                <small>{{ $course->slug }} - Order {{ $course->sort_order }}</small>
            </div>
            <div class="sa-row-actions">
                @if($course->trashed())
                    <span class="trashed-label">Trashed</span>
                    <button wire:click="confirmRestore({{ $course->id }})" class="btn-restore">Restore</button>
                @else
                    <a href="{{ route('course.show', $course->slug) }}" target="_blank" class="btn-link">View</a>
                    <button wire:click="toggleActive({{ $course->id }})" class="btn-toggle {{ $course->is_active ? 'on' : 'off' }}">
                        {{ $course->is_active ? 'Visible' : 'Hidden' }}
                    </button>
                    <button wire:click="openEdit({{ $course->id }})" class="btn-edit">Edit</button>
                    <button wire:click="confirmDelete({{ $course->id }})" class="btn-delete">Delete</button>
                @endif
            </div>
        </div>
        @empty
        <div class="sa-empty">
            <strong>No courses yet.</strong>
            <span>Add language, IELTS, PTE, JLPT, NAT, or interview preparation courses.</span>
        </div>
        @endforelse
    </div>

    @if($courses->hasPages())
        <div class="sa-pagination">{{ $courses->links() }}</div>
    @endif
    @endif

    @if($showModal)
    <div class="modal-backdrop" x-on:keydown.escape.window="$wire.closeModal()">
        <div class="modal-box" @click.outside="$wire.closeModal()">
            <div class="modal-head">
                <h2>{{ $isEdit ? 'Edit Course' : 'Add Course' }}</h2>
                <button wire:click="closeModal" class="modal-close">x</button>
            </div>

            <form wire:submit.prevent="saveCourse">
                <div class="modal-body">
                    @if($errors->any())
                    <div class="form-error-summary">
                        Please check the required fields before saving.
                    </div>
                    @endif

                    <div class="destination-subtabs">
                        @foreach([
                            'listing' => 'Listing',
                            'detail' => 'Detail',
                            'meta' => 'Meta',
                            'sidebar' => 'Sidebar',
                        ] as $tab => $label)
                            <button type="button" wire:click="setCourseTab('{{ $tab }}')" class="destination-subtab {{ $courseTab === $tab ? 'active' : '' }}">{{ $label }}</button>
                        @endforeach
                    </div>

                    @if($courseTab === 'listing')
                    <div class="subtab-panel">
                        <div class="modal-section-title">Listing Card</div>
                        <div class="form-grid no-pad">
                            <div class="form-group">
                                <label>Title <span>*</span></label>
                                <input type="text" wire:model.live="title" placeholder="Japanese Language Course">
                                @error('title') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" wire:model.live="slug" placeholder="japanese-language-course">
                                @error('slug') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select wire:model.live="category">
                                    <option value="language">Language</option>
                                    <option value="test-prep">Test Prep</option>
                                    <option value="interview">Interview</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Badge</label>
                                <input type="text" wire:model.live="badge" placeholder="Japanese">
                            </div>
                            <div class="form-group">
                                <label>Tag</label>
                                <input type="text" wire:model.live="tag" placeholder="Language - 6-12 Months">
                            </div>
                            <div class="form-group">
                                <label>Sort Order</label>
                                <input type="number" min="0" wire:model.live="sort_order">
                            </div>
                            <div class="form-group full">
                                <label>Excerpt</label>
                                <textarea rows="3" wire:model.live="excerpt"></textarea>
                            </div>
                        </div>

                        <label class="upload-box">
                            @if($image_upload)
                                <img src="{{ $image_upload->temporaryUrl() }}" alt="Preview">
                            @elseif($image_current)
                                <img src="{{ str_starts_with($image_current, 'http') ? $image_current : Storage::url($image_current) }}" alt="Current">
                            @else
                                <div><strong>Upload course image</strong><span>JPG, PNG or WebP up to 3MB</span></div>
                            @endif
                            <input type="file" wire:model="image_upload" accept="image/png,image/jpeg,image/webp">
                        </label>
                        @error('image_upload') <small class="upload-error">{{ $message }}</small> @enderror
                        <div wire:loading wire:target="image_upload" class="uploading">Uploading image...</div>

                        <label class="toggle-row">
                            <input type="checkbox" wire:model.live="is_featured">
                            <span>Feature this course at the top of the courses page</span>
                        </label>
                        <label class="toggle-row">
                            <input type="checkbox" wire:model.live="is_active">
                            <span>Show this course on the frontend</span>
                        </label>
                    </div>
                    @endif

                    @if($courseTab === 'detail')
                    <div class="subtab-panel">
                        <div class="modal-section-title">Detail Content</div>
                        <div class="form-group full">
                            <label>Overview</label>
                            <textarea rows="5" wire:model.live="overview"></textarea>
                        </div>
                        <div class="modal-section-title with-action">
                            <span>Description Paragraphs</span>
                            <button type="button" wire:click="addDescription" class="btn-add-inline">+ Add Paragraph</button>
                        </div>
                        <div class="repeat-list">
                            @forelse($description as $i => $row)
                            <div class="repeat-card">
                                <div class="repeat-head">
                                    <strong>Paragraph {{ $i + 1 }}</strong>
                                    <button type="button" wire:click="removeDescription({{ $i }})">Remove</button>
                                </div>
                                <div class="form-group full">
                                    <textarea rows="3" wire:model.live="description.{{ $i }}.body"></textarea>
                                </div>
                            </div>
                            @empty
                            <div class="repeat-empty">No paragraphs yet. Click <strong>+ Add Paragraph</strong>.</div>
                            @endforelse
                        </div>

                        <div class="modal-section-title with-action">
                            <span>What Students Learn</span>
                            <button type="button" wire:click="addHighlight" class="btn-add-inline">+ Add Item</button>
                        </div>
                        <div class="repeat-list">
                            @forelse($highlights as $i => $row)
                            <div class="repeat-card">
                                <div class="repeat-head">
                                    <strong>Item {{ $i + 1 }}</strong>
                                    <button type="button" wire:click="removeHighlight({{ $i }})">Remove</button>
                                </div>
                                <div class="form-group full">
                                    <input type="text" wire:model.live="highlights.{{ $i }}.item">
                                </div>
                            </div>
                            @empty
                            <div class="repeat-empty">No learning items yet. Click <strong>+ Add Item</strong>.</div>
                            @endforelse
                        </div>
                    </div>
                    @endif

                    @if($courseTab === 'meta')
                    <div class="subtab-panel">
                        <div class="modal-section-title with-action">
                            <span>Header Meta Items</span>
                            <button type="button" wire:click="addMetaItem" class="btn-add-inline">+ Add Meta</button>
                        </div>
                        <div class="repeat-list">
                            @forelse($meta_items as $i => $row)
                            <div class="repeat-card">
                                <div class="repeat-head">
                                    <strong>Meta {{ $i + 1 }}</strong>
                                    <button type="button" wire:click="removeMetaItem({{ $i }})">Remove</button>
                                </div>
                                <div class="form-group full">
                                    <input type="text" wire:model.live="meta_items.{{ $i }}.label" placeholder="NAT - JLPT - J-TEST">
                                </div>
                            </div>
                            @empty
                            <div class="repeat-empty">No meta items yet. Click <strong>+ Add Meta</strong>.</div>
                            @endforelse
                        </div>
                    </div>
                    @endif

                    @if($courseTab === 'sidebar')
                    <div class="subtab-panel">
                        <div class="modal-section-title">Enroll Box</div>
                        <div class="form-grid no-pad">
                            <div class="form-group">
                                <label>Sidebar Title</label>
                                <input type="text" wire:model.live="sidebar_title" placeholder="Enroll Today">
                            </div>
                            <div class="form-group">
                                <label>Sidebar Subtitle</label>
                                <textarea rows="3" wire:model.live="sidebar_subtitle"></textarea>
                            </div>
                        </div>
                        <div class="modal-section-title with-action">
                            <span>Sidebar Facts</span>
                            <button type="button" wire:click="addSidebarItem" class="btn-add-inline">+ Add Fact</button>
                        </div>
                        <div class="repeat-list">
                            @forelse($sidebar_items as $i => $row)
                            <div class="repeat-card">
                                <div class="repeat-head">
                                    <strong>Fact {{ $i + 1 }}</strong>
                                    <button type="button" wire:click="removeSidebarItem({{ $i }})">Remove</button>
                                </div>
                                <div class="form-grid no-pad">
                                    <div class="form-group">
                                        <label>Label</label>
                                        <input type="text" wire:model.live="sidebar_items.{{ $i }}.label" placeholder="Duration">
                                    </div>
                                    <div class="form-group">
                                        <label>Value</label>
                                        <input type="text" wire:model.live="sidebar_items.{{ $i }}.value" placeholder="6-12 Months">
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="repeat-empty">No sidebar facts yet. Click <strong>+ Add Fact</strong>.</div>
                            @endforelse
                        </div>
                    </div>
                    @endif
                </div>

                <div class="modal-foot">
                    <button type="button" wire:click="closeModal" class="btn-cancel">Cancel</button>
                    <button type="submit" class="btn-save" wire:loading.attr="disabled">Save Course</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if($confirmingDeleteId)
    <div class="modal-backdrop">
        <div class="confirm-box">
            <h2>Move Course to Trash?</h2>
            <p>This hides the course from the frontend. You can restore it later.</p>
            <div class="confirm-actions">
                <button wire:click="cancelDelete" class="btn-cancel">Cancel</button>
                <button wire:click="delete" class="btn-delete-confirm">Move to Trash</button>
            </div>
        </div>
    </div>
    @endif

    @if($confirmingRestoreId)
    <div class="modal-backdrop">
        <div class="confirm-box">
            <h2>Restore Course?</h2>
            <p>This returns the course to the admin list. Visibility still follows its active status.</p>
            <div class="confirm-actions">
                <button wire:click="cancelRestore" class="btn-cancel">Cancel</button>
                <button wire:click="restore" class="btn-restore-confirm">Restore</button>
            </div>
        </div>
    </div>
    @endif
</div>

@include('livewire.admin.course-manager-styles')
