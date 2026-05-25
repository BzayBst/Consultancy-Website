{{-- resources/views/livewire/admin/event.blade.php --}}

<div class="ev-wrap" x-data>

    {{-- ── Header ─────────────────────────────────────────────────── --}}
    <div class="ev-header">
        <div>
            <h1>Events</h1>
            <p>Manage the "Upcoming &amp; Recent Events" section — featured event, date, location and more</p>
        </div>
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
            <a href="#" target="_blank" class="btn-preview">👁 Preview Section →</a>
            <button wire:click="openCreate" class="btn-add-sm">+ Add Event</button>
        </div>
    </div>

    {{-- ── Flash ───────────────────────────────────────────────────── --}}
    @if (session('success'))
        <div class="alert alert-success"
             x-data="{ show:true }" x-show="show"
             x-init="setTimeout(()=>show=false,3000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-end="opacity-0">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- ── Tabs ────────────────────────────────────────────────────── --}}
    <div class="ev-tabs">
        <button wire:click="setTab('section')" class="ev-tab {{ $activeTab==='section'?'active':'' }}">
            <span>⚙️</span> Section Settings
        </button>
        <button wire:click="setTab('events')" class="ev-tab {{ $activeTab==='events'?'active':'' }}">
            <span>📅</span> Events
            <span class="tab-count">{{ $events->where('is_active',true)->count() }}/{{ $events->count() }}</span>
        </button>
    </div>


    {{-- ════════════════════════════════════════════════════
         TAB 1 — SECTION SETTINGS
    ════════════════════════════════════════════════════ --}}
    @if ($activeTab === 'section')

    <div class="section-preview">
        <div class="sp-label-row">
            <span class="sp-line"></span>
            <span class="sp-label">{{ $section_label ?: 'LATEST EVENTS' }}</span>
            <span class="sp-line"></span>
        </div>
        <div class="sp-title">{{ $title ?: 'Upcoming & Recent Events' }}</div>
        <div class="sp-layout">
            @php $featured = $events->where('is_active',true)->where('is_featured',true)->first()
                          ?? $events->where('is_active',true)->first(); @endphp
            <div class="sp-featured">
                <div class="sp-feat-img">
                    @if($featured && $featured->image)
                        <img src="{{ asset('storage/'.$featured->image) }}" alt="{{ $featured->title }}">
                    @else
                        <div class="sp-feat-img-empty">🖼️</div>
                    @endif
                </div>
                <div class="sp-feat-body">
                    @if($featured)
                        <span class="sp-badge-upcoming">{{ strtoupper($featured->status) }}</span>
                        <div class="sp-feat-title">{{ $featured->title }}</div>
                        <div class="sp-feat-meta">
                            @if($featured->event_date)<div>📅 {{ $featured->event_date->format('d M Y') }}</div>@endif
                            @if($featured->location)<div>📍 {{ $featured->location }}</div>@endif
                            @if($featured->organizer)<div>ℹ️ {{ $featured->organizer }}</div>@endif
                        </div>
                    @else
                        <div class="sp-feat-empty">No featured event</div>
                    @endif
                </div>
            </div>
            <div class="sp-list">
                @foreach($events->where('is_active',true)->take(4) as $ev)
                <div class="sp-ev-row">
                    <div class="sp-date-box">
                        <span class="sp-day">{{ $ev->event_date->format('d') }}</span>
                        <span class="sp-mon">{{ $ev->event_date->format('M') }}</span>
                    </div>
                    <div class="sp-ev-info">
                        <strong>{{ $ev->title }}</strong>
                        <p>{{ Str::limit($ev->description,70) }}</p>
                    </div>
                </div>
                @endforeach
                @if($events->where('is_active',true)->isEmpty())
                    <div class="sp-list-empty">No active events yet</div>
                @endif
            </div>
        </div>
    </div>

    <form wire:submit="saveSection">
        <div class="ev-card">
            <div class="ev-card-header"><h2>Section Text</h2></div>
            <div class="ev-grid-2" style="padding:24px">
                <div class="form-group">
                    <label>Section Label</label>
                    <input type="text" wire:model.live="section_label" placeholder="LATEST EVENTS">
                    @error('section_label') <span class="fe">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Title <span class="req">*</span></label>
                    <input type="text" wire:model.live="title" placeholder="Upcoming &amp; Recent Events">
                    @error('title') <span class="fe">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="ev-actions">
            <button type="submit" class="btn-save" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="saveSection">💾 Save Section Settings</span>
                <span wire:loading wire:target="saveSection">Saving…</span>
            </button>
        </div>
    </form>
    @endif


    {{-- ════════════════════════════════════════════════════
         TAB 2 — EVENTS LIST
    ════════════════════════════════════════════════════ --}}
    @if ($activeTab === 'events')

    <div class="ev-filters">
        <div class="ev-search">
            <span class="search-icon">🔍</span>
            <input type="text" wire:model.live.debounce.300ms="search"
                   placeholder="Search title, location, organizer…">
        </div>
        <div class="filter-group">
            <select wire:model.live="filterStatus">
                <option value="">All Status</option>
                <option value="upcoming">Upcoming</option>
                <option value="ongoing">Ongoing</option>
                <option value="past">Past</option>
            </select>
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
    </div>

    {{-- Live frontend preview --}}
    <div class="frontend-preview">
        <div class="fp-label-row">
            <span class="fp-line"></span>
            <span class="fp-label">{{ $section_label ?: 'LATEST EVENTS' }}</span>
            <span class="fp-line"></span>
        </div>
        <div class="fp-title">{{ $title ?: 'Upcoming & Recent Events' }}</div>
        <div class="fp-layout">
            @php $featured = $events->where('is_active',true)->where('is_featured',true)->first()
                          ?? $events->where('is_active',true)->first(); @endphp
            <div class="fp-featured">
                <div class="fp-feat-img">
                    @if($featured && $featured->image)
                        <img src="{{ asset('storage/'.$featured->image) }}" alt="{{ $featured->title }}">
                    @else
                        <div class="fp-feat-img-empty">🖼️<br><small>Featured image</small></div>
                    @endif
                </div>
                <div class="fp-feat-body">
                    @if($featured)
                        <span class="fp-badge {{ $featured->status }}">{{ strtoupper($featured->status) }}</span>
                        <div class="fp-feat-title">{{ $featured->title }}</div>
                        <div class="fp-feat-meta">
                            @if($featured->event_date)
                            <div class="fp-meta-row"><span>📅</span><span>{{ $featured->event_date->format('d M Y') }}</span></div>
                            @endif
                            @if($featured->location)
                            <div class="fp-meta-row"><span>📍</span><span>{{ $featured->location }}</span></div>
                            @endif
                            @if($featured->organizer)
                            <div class="fp-meta-row"><span>ℹ️</span><span>{{ $featured->organizer }}</span></div>
                            @endif
                        </div>
                        <a href="#" class="fp-learn-more">Learn More</a>
                    @else
                        <div class="fp-feat-empty">No featured event · Mark one as featured below ↓</div>
                    @endif
                </div>
            </div>
            <div class="fp-list">
                @foreach($events->where('is_active',true)->take(4) as $ev)
                <div class="fp-ev-row">
                    <div class="fp-date-box">
                        <span class="fp-day">{{ $ev->event_date->format('d') }}</span>
                        <span class="fp-mon">{{ $ev->event_date->format('M') }}</span>
                    </div>
                    <div class="fp-ev-info">
                        <strong>{{ $ev->title }}</strong>
                        <p>{{ Str::limit($ev->description,90) }}</p>
                    </div>
                </div>
                @endforeach
                @if($events->where('is_active',true)->isEmpty())
                    <div class="fp-list-empty">No active events · Add events below ↓</div>
                @endif
            </div>
        </div>
    </div>

    {{-- List --}}
    <div class="ev-card">
        <div class="ev-card-header">
            <div>
                <h2>All Events</h2>
                <p>Click ✏️ to edit · toggle visibility · mark as featured</p>
            </div>
        </div>
        <div class="ev-list">
            @forelse ($events as $event)
            <div class="ev-list-item {{ $event->trashed()?'is-trashed':'' }}">
                <div class="ev-thumb">
                    @if($event->image)
                        <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}">
                    @else
                        <div class="ev-thumb-empty">📅</div>
                    @endif
                </div>
                <div class="ev-date-mini">
                    <span class="edm-day">{{ $event->event_date->format('d') }}</span>
                    <span class="edm-mon">{{ $event->event_date->format('M') }}</span>
                    <span class="edm-year">{{ $event->event_date->format('Y') }}</span>
                </div>
                <div class="ev-list-content">
                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:3px">
                        <strong>{{ $event->title }}</strong>
                        @if($event->is_featured) <span class="ev-badge-featured">⭐ Featured</span> @endif
                        <span class="ev-status-badge {{ $event->status }}">{{ ucfirst($event->status) }}</span>
                        @if($event->long_description) <span class="ev-has-detail">📄 Detail page</span> @endif
                    </div>
                    @if($event->location)  <span class="ev-meta">📍 {{ $event->location }}</span>  @endif
                    @if($event->organizer) <span class="ev-meta">ℹ️ {{ $event->organizer }}</span> @endif
                </div>
                <div class="ev-list-actions">
                    @if(! $event->trashed())
                       
                        <button wire:click="toggleFeatured({{ $event->id }})"
                                class="ev-btn-feat {{ $event->is_featured?'active':'' }}"
                                title="{{ $event->is_featured?'Remove featured':'Set as featured' }}">
                            {{ $event->is_featured?'⭐':'☆' }}
                        </button>
                        <button wire:click="toggleActive({{ $event->id }})"
                                class="ev-toggle {{ $event->is_active?'on':'off' }}">
                            {{ $event->is_active?'✅ Visible':'⭕ Hidden' }}
                        </button>
                        <button wire:click="openEdit({{ $event->id }})" class="ev-btn-edit">✏️ Edit</button>
                        <button wire:click="confirmDelete({{ $event->id }})" class="ev-btn-del">🗑 Delete</button>
                    @else
                        <span class="ev-trashed-badge">🗑 Trashed</span>
                        <button wire:click="confirmRestore({{ $event->id }})" class="ev-btn-restore">↩ Restore</button>
                    @endif
                </div>
            </div>
            @empty
            <div class="ev-empty">
                <span>📅</span>
                <p>No events yet. Click <strong>+ Add Event</strong> to create the first one.</p>
            </div>
            @endforelse
        </div>
        @if($events instanceof \Illuminate\Pagination\LengthAwarePaginator && $events->hasPages())
            <div class="ev-pagination">
                <span class="ev-page-info">
                    Showing {{ $events->firstItem() }}–{{ $events->lastItem() }} of {{ $events->total() }}
                </span>
                {{ $events->links() }}
            </div>
        @endif
    </div>
    @endif


    {{-- ════════════════════════════════════════════════════
         CREATE / EDIT MODAL
    ════════════════════════════════════════════════════ --}}
    @if ($showModal)
    <div class="modal-backdrop" x-data x-on:keydown.escape.window="$wire.closeModal()">
        <div class="modal-box modal-xl" @click.outside="$wire.closeModal()">

            <div class="modal-head">
                <h2>{{ $isEdit ? 'Edit Event' : 'Add Event' }}</h2>
                <button class="modal-close" wire:click="closeModal">✕</button>
            </div>

            <div class="modal-body">

                {{-- Live mini-preview --}}
                <div class="event-modal-preview">
                    <div class="emp-featured">
                        <div class="emp-img">
                            @if($photo)
                                <img src="{{ $photo->temporaryUrl() }}" alt="preview">
                            @elseif($existingPhoto && !$removePhoto)
                                <img src="{{ asset('storage/'.$existingPhoto) }}" alt="current">
                            @else
                                <div class="emp-img-empty">🖼️</div>
                            @endif
                        </div>
                        <div class="emp-body">
                            <span class="emp-badge {{ $status ?: 'upcoming' }}">{{ strtoupper($status ?: 'UPCOMING') }}</span>
                            <div class="emp-title">{{ $ev_title ?: 'Event Title' }}</div>
                            <div class="emp-meta">
                                @if($event_date)<div>📅 {{ \Carbon\Carbon::parse($event_date)->format('d M Y') }}</div>@endif
                                @if($location)<div>📍 {{ $location }}</div>@endif
                                @if($organizer)<div>ℹ️ {{ $organizer }}</div>@endif
                            </div>
                        </div>
                    </div>
                    <div class="emp-row-preview">
                        <div class="emp-date-box">
                            <span class="emp-day">{{ $event_date ? \Carbon\Carbon::parse($event_date)->format('d') : '01' }}</span>
                            <span class="emp-mon">{{ $event_date ? \Carbon\Carbon::parse($event_date)->format('M') : 'JAN' }}</span>
                        </div>
                        <div class="emp-row-info">
                            <strong>{{ $ev_title ?: 'Event Title' }}</strong>
                            <p>{{ $description ? Str::limit($description,90) : 'Short description will appear here.' }}</p>
                        </div>
                    </div>
                </div>

                {{-- ── MODAL INNER TABS ── --}}
                <div class="modal-inner-tabs">
                    <button type="button" onclick="switchModalTab(this,'mtab-basic')"   class="mit active">📋 Basic Info</button>
                    <button type="button" onclick="switchModalTab(this,'mtab-detail')"  class="mit">📄 Detail Page</button>
                    <button type="button" onclick="switchModalTab(this,'mtab-photo')"   class="mit">🖼️ Image</button>
                </div>

                <form wire:submit="save" id="eventForm">

                    {{-- ── TAB: Basic Info ── --}}
                    <div id="mtab-basic" class="mtab-panel active">
                        <div class="ev-grid-2">

                            <div class="form-group ev-full">
                                <label>Event Title <span class="req">*</span></label>
                                <input type="text" wire:model.live="ev_title"
                                       placeholder="e.g. Free IELTS Seminar – Bhairahawa">
                                @error('ev_title') <span class="fe">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group ev-full">
                                <label>Short Description
                                    <span class="form-hint-inline">— shown in event list rows (max 400 chars)</span>
                                </label>
                                <textarea wire:model.live="description" rows="2" maxlength="400"
                                          placeholder="Walk-in seminar on IELTS preparation strategies and band score targets."></textarea>
                                <div style="display:flex;justify-content:space-between;margin-top:4px">
                                    @error('description') <span class="fe">{{ $message }}</span> @else <span></span> @enderror
                                    <span class="char-count">{{ strlen($description) }} / 400</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Event Date <span class="req">*</span></label>
                                <input type="date" wire:model.live="event_date">
                                @error('event_date') <span class="fe">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>End Date <span class="form-optional">(optional, for multi-day)</span></label>
                                <input type="date" wire:model="event_end_date">
                                @error('event_end_date') <span class="fe">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Start Time <span class="form-optional">(optional)</span></label>
                                <input type="time" wire:model="event_time">
                                @error('event_time') <span class="fe">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Status <span class="req">*</span></label>
                                <select wire:model.live="status">
                                    <option value="upcoming">Upcoming</option>
                                    <option value="ongoing">Ongoing</option>
                                    <option value="past">Past</option>
                                </select>
                                @error('status') <span class="fe">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Location <span class="form-optional">(optional)</span></label>
                                <input type="text" wire:model.live="location"
                                       placeholder="e.g. Bharatpur, Chitwan">
                                @error('location') <span class="fe">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Organizer <span class="form-optional">(optional)</span></label>
                                <input type="text" wire:model.live="organizer"
                                       placeholder="e.g. HASU Educational Consultancy">
                                @error('organizer') <span class="fe">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group ev-full">
                                <label>Learn More / Register URL <span class="form-optional">(optional)</span></label>
                                <input type="url" wire:model="learn_more_url"
                                       placeholder="https://…">
                                @error('learn_more_url') <span class="fe">{{ $message }}</span> @enderror
                                <small class="form-hint">If blank, the "Learn More" button links to the Contact page.</small>
                            </div>

                            <div class="form-group ev-full">
                                <div class="ev-toggles-row">
                                    <label class="toggle-label">
                                        <div class="toggle-switch">
                                            <input type="checkbox" wire:model="is_active" id="modal_is_active">
                                            <span class="toggle-slider"></span>
                                        </div>
                                        <span>Visible on website</span>
                                    </label>
                                    <label class="toggle-label">
                                        <div class="toggle-switch">
                                            <input type="checkbox" wire:model="is_featured" id="modal_is_featured">
                                            <span class="toggle-slider toggle-gold"></span>
                                        </div>
                                        <span>⭐ Featured event <span class="form-optional">(big card on left)</span></span>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- ── TAB: Detail Page ── --}}
                    <div id="mtab-detail" class="mtab-panel">

                        <div class="detail-info-banner">
                            📄 This content appears on the <strong>event detail page</strong>
                            when visitors click "Learn More". Leave blank to skip the detail page.
                        </div>

                        <div class="form-group" style="margin-bottom:20px">
                            <label>Long Description
                                <span class="form-hint-inline">— supports basic HTML tags</span>
                            </label>
                            <textarea wire:model="long_description" rows="10"
                                      placeholder="&lt;p&gt;Write a full description of the event here…&lt;/p&gt;&#10;&lt;p&gt;You can use &lt;strong&gt;bold&lt;/strong&gt;, &lt;em&gt;italic&lt;/em&gt;, and &lt;ul&gt;&lt;li&gt;lists&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;"></textarea>
                            @error('long_description') <span class="fe">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Highlights / What to Expect
                                <span class="form-hint-inline">— one bullet point per line</span>
                            </label>
                            <textarea wire:model="highlights_raw" rows="6"
                                      placeholder="Free entry for all students&#10;Bring your academic transcripts&#10;JLPT N4+ level recommended&#10;Seats are limited — arrive early"></textarea>
                            @error('highlights_raw') <span class="fe">{{ $message }}</span> @enderror
                            <small class="form-hint">
                                Each line becomes one ✓ bullet on the detail page under "What to Expect".
                            </small>
                        </div>

                        {{-- Preview of highlights --}}
                        @if(trim($highlights_raw))
                        <div class="highlights-preview">
                            <strong>Preview — What to Expect</strong>
                            <ul>
                                @foreach(array_filter(array_map('trim', explode("\n", $highlights_raw))) as $hl)
                                <li>{{ $hl }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                    </div>

                    {{-- ── TAB: Image ── --}}
                    <div id="mtab-photo" class="mtab-panel">
                        <div class="ev-grid-2">
                            <div class="form-group">
                                <label>Event Image</label>
                                <div class="upload-box" x-data="{ drag:false }"
                                     @dragover.prevent="drag=true" @dragleave.prevent="drag=false"
                                     @drop.prevent="drag=false" :class="{ 'dragging': drag }">
                                    @if($photo)
                                        <img src="{{ $photo->temporaryUrl() }}" class="upload-prev">
                                    @elseif($existingPhoto && !$removePhoto)
                                        <img src="{{ asset('storage/'.$existingPhoto) }}" class="upload-prev">
                                    @else
                                        <div class="upload-ph">
                                            <span>🖼️</span>
                                            <small>Click or drag · JPG PNG WebP · Max 3MB<br>Recommended: 800×500 px</small>
                                        </div>
                                    @endif
                                    <input type="file" wire:model="photo" accept="image/*" class="upload-input">
                                </div>
                                @error('photo') <span class="fe">{{ $message }}</span> @enderror
                                <div wire:loading wire:target="photo" class="uploading">Uploading…</div>
                                @if($existingPhoto && !$photo)
                                    <label class="remove-photo-check">
                                        <input type="checkbox" wire:model.live="removePhoto">
                                        <span>Remove current image</span>
                                    </label>
                                @endif
                            </div>
                            <div class="photo-tips">
                                <strong>Image Tips</strong>
                                <ul>
                                    <li>Used as the featured event card image</li>
                                    <li>Also shown as the hero image on the detail page</li>
                                    <li>Landscape / wide format works best</li>
                                    <li>Recommended: 800×500 px or wider</li>
                                    <li>JPG, PNG, or WebP · Max 3 MB</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-foot">
                <button type="button" wire:click="closeModal" class="btn-cancel">Cancel</button>
                <button form="eventForm" type="submit" class="btn-save"
                        wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">
                        {{ $isEdit ? '💾 Update Event' : '✨ Create Event' }}
                    </span>
                    <span wire:loading wire:target="save">Saving…</span>
                </button>
            </div>

        </div>
    </div>
    @endif


    {{-- DELETE CONFIRM --}}
    @if ($confirmingDeleteId)
    <div class="modal-backdrop">
        <div class="modal-box modal-xs">
            <div class="modal-head">
                <h2>Move to Trash?</h2>
                <button class="modal-close" wire:click="cancelDelete">✕</button>
            </div>
            <div class="modal-body">
                <div class="delete-confirm">
                    <span class="delete-icon">🗑️</span>
                    <p>This event will be soft-deleted. You can restore it from the <strong>Trashed</strong> filter.</p>
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

    {{-- RESTORE CONFIRM --}}
    @if ($confirmingRestoreId)
    <div class="modal-backdrop">
        <div class="modal-box modal-xs">
            <div class="modal-head">
                <h2>Restore Event?</h2>
                <button class="modal-close" wire:click="cancelRestore">✕</button>
            </div>
            <div class="modal-body">
                <div class="delete-confirm">
                    <span class="delete-icon">↩️</span>
                    <p>This event will be restored and visible on the website again.</p>
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

<script>
function switchModalTab(btn, id) {
    document.querySelectorAll('.mit').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.mtab-panel').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById(id).classList.add('active');
}
</script>

<style>
:root {
    --navy:#0d1560;--blue:#2952e3;--blue-light:#e8edfd;
    --red:#cc2222;--red-dark:#a81a1a;
    --border:#e2e8f0;--text:#555;--light:#f5f7fb;
    --gold:#f59e0b;
    --radius:8px;--shadow:0 2px 12px rgba(0,0,0,.07);
}

/* ── Page ── */
.ev-wrap   { padding:32px 28px;max-width:1100px; }
.ev-header { display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px; }
.ev-header h1 { font-family:'Playfair Display',serif;font-size:24px;color:var(--navy);margin-bottom:4px; }
.ev-header p  { font-size:13px;color:var(--text); }
.btn-preview  { padding:9px 18px;border:1.5px solid var(--border);border-radius:var(--radius);font-size:13px;font-weight:600;color:var(--navy);text-decoration:none;transition:all .2s; }
.btn-preview:hover { border-color:var(--blue);color:var(--blue); }
.alert { display:flex;align-items:center;gap:10px;padding:12px 18px;border-radius:var(--radius);font-size:14px;font-weight:500;margin-bottom:20px;background:#f0fdf4;color:#166534;border:1px solid #bbf7d0; }

/* ── Tabs ── */
.ev-tabs { display:flex;gap:4px;border-bottom:2px solid var(--border);margin-bottom:24px; }
.ev-tab  { display:flex;align-items:center;gap:8px;padding:10px 22px;background:none;border:none;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:500;color:var(--text);cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-2px;transition:all .2s;border-radius:6px 6px 0 0; }
.ev-tab:hover  { color:var(--navy);background:var(--light); }
.ev-tab.active { color:var(--navy);border-bottom-color:var(--red);background:#fff;font-weight:600; }
.tab-count { font-size:11px;font-weight:700;background:var(--blue-light);color:var(--blue);padding:2px 8px;border-radius:20px; }

/* ── Section Preview ── */
.section-preview,.frontend-preview { background:#fff;border:1px solid var(--border);border-radius:14px;padding:28px 24px;margin-bottom:24px; }
.sp-label-row,.fp-label-row { display:flex;align-items:center;justify-content:center;gap:12px;margin-bottom:10px; }
.sp-line,.fp-line { display:block;width:32px;height:2px;background:var(--red); }
.sp-label,.fp-label { font-size:11px;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;color:var(--red); }
.sp-title,.fp-title { font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:var(--navy);text-align:center;margin-bottom:20px; }
.sp-layout,.fp-layout { display:grid;grid-template-columns:1fr 1.2fr;gap:20px; }
.sp-featured,.fp-featured { border:1px solid var(--border);border-radius:10px;overflow:hidden;background:#fff;box-shadow:var(--shadow); }
.sp-feat-img,.fp-feat-img { background:#1a1a2e;min-height:120px;display:flex;align-items:center;justify-content:center;overflow:hidden; }
.sp-feat-img img,.fp-feat-img img { width:100%;height:130px;object-fit:cover; }
.sp-feat-img-empty,.fp-feat-img-empty { font-size:32px;color:rgba(255,255,255,.3); }
.fp-feat-img-empty small { display:block;font-size:11px;color:rgba(255,255,255,.25);margin-top:4px;text-align:center; }
.sp-feat-body,.fp-feat-body { padding:14px 16px; }
.sp-badge-upcoming,.fp-badge { display:inline-block;font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;padding:3px 10px;border-radius:4px;margin-bottom:8px; }
.sp-badge-upcoming,.fp-badge.upcoming { background:var(--red);color:#fff; }
.fp-badge.ongoing { background:var(--blue);color:#fff; }
.fp-badge.past    { background:#64748b;color:#fff; }
.sp-feat-title,.fp-feat-title { font-family:'Playfair Display',serif;font-size:14px;font-weight:700;color:var(--navy);margin-bottom:8px;line-height:1.3; }
.sp-feat-meta,.fp-feat-meta  { display:flex;flex-direction:column;gap:4px;font-size:11px;color:var(--text);margin-bottom:10px; }
.fp-meta-row { display:flex;align-items:center;gap:6px; }
.fp-learn-more { display:inline-block;background:var(--blue);color:#fff;padding:7px 16px;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none; }
.sp-feat-empty,.fp-feat-empty { font-size:12px;color:#94a3b8;text-align:center;padding:12px; }
.sp-list,.fp-list { display:flex;flex-direction:column;gap:10px; }
.sp-ev-row,.fp-ev-row { display:flex;align-items:center;gap:12px;background:var(--light);border-radius:8px;padding:12px 14px;border-left:4px solid var(--navy); }
.sp-date-box,.fp-date-box { background:var(--navy);color:#fff;border-radius:6px;padding:7px 10px;text-align:center;flex-shrink:0;min-width:44px; }
.sp-day,.fp-day { display:block;font-size:18px;font-weight:700;line-height:1; }
.sp-mon,.fp-mon { display:block;font-size:9px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;opacity:.8;margin-top:2px; }
.sp-ev-info strong,.fp-ev-info strong { display:block;font-size:13px;font-weight:700;color:var(--navy);margin-bottom:2px; }
.sp-ev-info p,.fp-ev-info p { font-size:11px;color:var(--text);margin:0;line-height:1.3; }
.sp-list-empty,.fp-list-empty { padding:16px;color:#94a3b8;font-size:12px;text-align:center; }

/* ── Filters ── */
.ev-filters { display:flex;gap:12px;align-items:center;flex-wrap:wrap;margin-bottom:20px; }
.ev-search  { flex:1;min-width:200px;display:flex;align-items:center;gap:8px;background:#fff;border:1.5px solid var(--border);border-radius:var(--radius);padding:9px 14px; }
.ev-search:focus-within { border-color:var(--blue);box-shadow:0 0 0 3px rgba(41,82,227,.1); }
.search-icon { font-size:14px;flex-shrink:0; }
.ev-search input { flex:1;border:none;outline:none;font-family:'DM Sans',sans-serif;font-size:14px;color:#333;background:transparent; }
.filter-group { display:flex;gap:8px;flex-wrap:wrap; }
.filter-group select { padding:9px 28px 9px 13px;border:1.5px solid var(--border);border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:13px;color:#333;outline:none;cursor:pointer;background:#fff;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8'%3E%3Cpath d='M0 0l6 8 6-8z' fill='%23555'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center; }
.filter-group select:focus { border-color:var(--blue); }

/* ── Cards ── */
.ev-card { background:#fff;border-radius:12px;border:1px solid var(--border);box-shadow:var(--shadow);overflow:hidden; }
.ev-card-header { display:flex;justify-content:space-between;align-items:center;padding:18px 24px 16px;border-bottom:1px solid var(--border);background:var(--light);flex-wrap:wrap;gap:10px; }
.ev-card-header h2 { font-size:16px;font-weight:700;color:var(--navy);margin-bottom:3px; }
.ev-card-header p  { font-size:13px;color:var(--text); }
.ev-actions { display:flex;justify-content:flex-end;margin:16px 0 4px; }

/* ── Event List ── */
.ev-list { padding:0 16px 16px; }
.ev-list-item { display:flex;align-items:center;gap:14px;background:#fff;border:1px solid var(--border);border-radius:8px;padding:14px 16px;margin-top:10px;transition:box-shadow .2s; }
.ev-list-item:hover { box-shadow:0 3px 14px rgba(0,0,0,.08); }
.ev-list-item.is-trashed { opacity:.6;background:#fff5f5; }
.ev-thumb { width:72px;height:48px;border-radius:6px;overflow:hidden;flex-shrink:0;border:1px solid var(--border);background:var(--light);display:flex;align-items:center;justify-content:center; }
.ev-thumb img { width:100%;height:100%;object-fit:cover; }
.ev-thumb-empty { font-size:20px; }
.ev-date-mini { background:var(--navy);color:#fff;border-radius:6px;padding:6px 10px;text-align:center;flex-shrink:0;min-width:44px; }
.edm-day  { display:block;font-size:18px;font-weight:700;line-height:1; }
.edm-mon  { display:block;font-size:9px;font-weight:600;letter-spacing:1px;text-transform:uppercase;opacity:.8; }
.edm-year { display:block;font-size:9px;opacity:.6;margin-top:1px; }
.ev-list-content { flex:1;min-width:0; }
.ev-list-content strong { font-size:14px;font-weight:700;color:var(--navy); }
.ev-meta { display:inline-block;font-size:11px;color:#94a3b8;margin-right:12px;margin-top:3px; }
.ev-status-badge { font-size:10px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;padding:2px 9px;border-radius:20px; }
.ev-status-badge.upcoming { background:#e0f2fe;color:#0369a1; }
.ev-status-badge.ongoing  { background:#dcfce7;color:#166534; }
.ev-status-badge.past     { background:#f1f5f9;color:#64748b; }
.ev-badge-featured { font-size:10px;font-weight:700;background:#fef9c3;color:#854d0e;padding:2px 8px;border-radius:20px;border:1px solid #fde68a; }
.ev-has-detail { font-size:10px;font-weight:600;background:#ede9fe;color:#6d28d9;padding:2px 8px;border-radius:20px; }
.ev-trashed-badge { font-size:12px;color:#991b1b;background:#fee2e2;padding:4px 10px;border-radius:20px;font-weight:600; }
.ev-list-actions { display:flex;align-items:center;gap:6px;flex-shrink:0;flex-wrap:wrap; }
.ev-btn-view { font-size:14px;width:32px;height:32px;border:1px solid var(--border);border-radius:var(--radius);cursor:pointer;background:#fff;transition:all .2s;display:flex;align-items:center;justify-content:center;text-decoration:none; }
.ev-btn-view:hover { background:var(--blue-light);border-color:var(--blue); }
.ev-btn-feat { font-size:16px;width:32px;height:32px;border:1px solid var(--border);border-radius:var(--radius);cursor:pointer;background:#fff;transition:all .2s;display:flex;align-items:center;justify-content:center; }
.ev-btn-feat:hover,.ev-btn-feat.active { background:#fef9c3;border-color:#fde68a; }
.ev-toggle { font-size:12px;padding:5px 12px;border:none;border-radius:20px;cursor:pointer;font-weight:600;white-space:nowrap;transition:all .2s; }
.ev-toggle.on  { background:#dcfce7;color:#166534; }
.ev-toggle.off { background:#fee2e2;color:#991b1b; }
.ev-btn-edit { font-size:12px;font-weight:600;padding:6px 12px;border-radius:var(--radius);border:none;cursor:pointer;background:var(--blue-light);color:var(--blue);transition:all .2s; }
.ev-btn-edit:hover { background:var(--blue);color:#fff; }
.ev-btn-del { font-size:12px;font-weight:600;padding:6px 12px;border-radius:var(--radius);border:none;cursor:pointer;background:#fee2e2;color:var(--red);transition:all .2s; }
.ev-btn-del:hover { background:var(--red);color:#fff; }
.ev-btn-restore { font-size:12px;font-weight:600;padding:6px 12px;border-radius:var(--radius);border:none;cursor:pointer;background:#dcfce7;color:#166534;transition:all .2s; }
.ev-btn-restore:hover { background:#166534;color:#fff; }
.ev-empty { text-align:center;padding:40px;color:#94a3b8;font-size:14px; }
.ev-empty span { display:block;font-size:36px;margin-bottom:10px; }
.ev-pagination { display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:8px; }
.ev-page-info  { font-size:13px;color:var(--text); }

/* ── Buttons ── */
.btn-save { display:inline-flex;align-items:center;gap:8px;padding:10px 26px;background:var(--red);color:#fff;border:none;border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer;transition:background .2s; }
.btn-save:hover:not(:disabled) { background:var(--red-dark); }
.btn-save:disabled { opacity:.65;cursor:not-allowed; }
.btn-add-sm { padding:9px 18px;background:var(--navy);color:#fff;border:none;border-radius:var(--radius);font-size:13px;font-weight:600;cursor:pointer;transition:background .2s;white-space:nowrap; }
.btn-add-sm:hover { background:var(--blue); }

/* ── Form ── */
.ev-grid-2 { display:grid;grid-template-columns:1fr 1fr;gap:14px 20px; }
.ev-full   { grid-column:1/-1; }
.form-group { display:flex;flex-direction:column;gap:6px; }
.form-group label { font-size:13px;font-weight:600;color:var(--navy); }
.form-optional,.form-hint-inline { font-size:12px;font-weight:400;color:#94a3b8; }
.form-group input,
.form-group select,
.form-group textarea {
    width:100%;padding:9px 13px;border:1.5px solid var(--border);border-radius:var(--radius);
    font-family:'DM Sans',sans-serif;font-size:14px;color:#333;
    outline:none;transition:border-color .2s,box-shadow .2s;resize:vertical;background:#fff;
}
.form-group input:focus,.form-group textarea:focus,.form-group select:focus { border-color:var(--blue);box-shadow:0 0 0 3px rgba(41,82,227,.1); }
.req       { color:var(--red); }
.form-hint { font-size:11px;color:#94a3b8; }
.fe        { font-size:12px;color:var(--red); }
.char-count{ font-size:11px;color:#94a3b8; }

/* Toggles row */
.ev-toggles-row { display:flex;gap:28px;flex-wrap:wrap; }
.toggle-label { display:flex;align-items:center;gap:10px;cursor:pointer;font-size:14px;font-weight:500;color:var(--navy); }
.toggle-switch { position:relative;width:44px;height:24px;flex-shrink:0; }
.toggle-switch input { opacity:0;width:0;height:0;position:absolute; }
.toggle-slider { position:absolute;inset:0;background:#cbd5e1;border-radius:24px;transition:.3s;cursor:pointer; }
.toggle-slider::before { content:'';position:absolute;left:3px;top:3px;width:18px;height:18px;background:#fff;border-radius:50%;transition:.3s; }
.toggle-switch input:checked + .toggle-slider { background:var(--blue); }
.toggle-switch input:checked + .toggle-gold  { background:var(--gold); }
.toggle-switch input:checked + .toggle-slider::before,
.toggle-switch input:checked + .toggle-gold::before { transform:translateX(20px); }

/* Upload */
.upload-box { border:2px dashed var(--border);border-radius:var(--radius);min-height:120px;position:relative;cursor:pointer;display:flex;align-items:center;justify-content:center;overflow:hidden;transition:border-color .2s,background .2s; }
.upload-box:hover,.upload-box.dragging { border-color:var(--blue);background:var(--blue-light); }
.upload-ph  { display:flex;flex-direction:column;align-items:center;gap:6px;color:#94a3b8;text-align:center;padding:12px; }
.upload-ph span { font-size:28px; }
.upload-ph small{ font-size:12px;line-height:1.5; }
.upload-prev { max-width:100%;max-height:150px;object-fit:contain;padding:8px; }
.upload-input { position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%; }
.uploading    { font-size:12px;color:var(--blue);margin-top:4px; }
.remove-photo-check { display:flex;align-items:center;gap:8px;margin-top:8px;font-size:13px;color:var(--red);cursor:pointer; }
.photo-tips { padding:16px 18px;background:var(--light);border-radius:var(--radius);border:1px solid var(--border); }
.photo-tips strong { display:block;font-size:13px;font-weight:700;color:var(--navy);margin-bottom:10px; }
.photo-tips ul { margin:0;padding-left:16px;display:flex;flex-direction:column;gap:6px; }
.photo-tips li { font-size:12px;color:var(--text);line-height:1.4; }

/* Modal inner tabs */
.modal-inner-tabs { display:flex;gap:3px;border-bottom:2px solid var(--border);margin-bottom:22px; }
.mit { padding:8px 18px;background:none;border:none;font-family:'DM Sans',sans-serif;font-size:13px;font-weight:500;color:var(--text);cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-2px;border-radius:6px 6px 0 0;transition:all .2s; }
.mit:hover { color:var(--navy);background:var(--light); }
.mit.active { color:var(--navy);border-bottom-color:var(--blue);font-weight:600;background:#fff; }
.mtab-panel { display:none; }
.mtab-panel.active { display:block; }

/* Detail page tab */
.detail-info-banner { background:var(--blue-light);border:1px solid #c7d7fa;border-radius:var(--radius);padding:12px 16px;font-size:13px;color:var(--navy);margin-bottom:18px;line-height:1.5; }
.highlights-preview { background:var(--light);border:1px solid var(--border);border-radius:var(--radius);padding:16px 18px;margin-top:14px; }
.highlights-preview strong { display:block;font-size:13px;font-weight:700;color:var(--navy);margin-bottom:10px; }
.highlights-preview ul { padding-left:0;list-style:none;display:flex;flex-direction:column;gap:8px; }
.highlights-preview ul li { display:flex;align-items:flex-start;gap:8px;font-size:13px;color:var(--text); }
.highlights-preview ul li::before { content:'✓';display:flex;align-items:center;justify-content:center;width:20px;height:20px;border-radius:50%;background:var(--navy);color:#fff;font-size:10px;font-weight:700;flex-shrink:0;margin-top:1px; }

/* Event modal preview */
.event-modal-preview { display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px; }
.emp-featured { border:1px solid var(--border);border-radius:10px;overflow:hidden;box-shadow:var(--shadow); }
.emp-img { background:#1a1a2e;min-height:110px;display:flex;align-items:center;justify-content:center;overflow:hidden; }
.emp-img img { width:100%;height:110px;object-fit:cover; }
.emp-img-empty { font-size:28px;color:rgba(255,255,255,.2); }
.emp-body { padding:14px 16px; }
.emp-badge { display:inline-block;font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;padding:3px 10px;border-radius:4px;margin-bottom:8px; }
.emp-badge.upcoming { background:var(--red);color:#fff; }
.emp-badge.ongoing  { background:var(--blue);color:#fff; }
.emp-badge.past     { background:#64748b;color:#fff; }
.emp-title { font-family:'Playfair Display',serif;font-size:14px;font-weight:700;color:var(--navy);margin-bottom:8px;line-height:1.3; }
.emp-meta  { display:flex;flex-direction:column;gap:4px;font-size:11px;color:var(--text); }
.emp-row-preview { display:flex;align-items:center;gap:12px;background:var(--light);border-radius:8px;padding:14px;border-left:4px solid var(--navy);align-self:center; }
.emp-date-box { background:var(--navy);color:#fff;border-radius:6px;padding:8px 12px;text-align:center;flex-shrink:0;min-width:48px; }
.emp-day  { display:block;font-size:20px;font-weight:700;line-height:1; }
.emp-mon  { display:block;font-size:9px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;opacity:.8;margin-top:2px; }
.emp-row-info strong { display:block;font-size:13px;font-weight:700;color:var(--navy);margin-bottom:3px; }
.emp-row-info p { font-size:12px;color:var(--text);margin:0;line-height:1.4; }

/* ── Modal ── */
.modal-backdrop { position:fixed;inset:0;z-index:1000;background:rgba(13,21,96,.45);backdrop-filter:blur(3px);display:flex;align-items:center;justify-content:center;padding:20px; }
.modal-box { background:#fff;border-radius:14px;box-shadow:0 20px 60px rgba(0,0,0,.25);width:100%;display:flex;flex-direction:column;max-height:90vh;overflow:hidden; }
.modal-xs  { max-width:360px; }
.modal-xl  { max-width:860px; }
.modal-head { display:flex;justify-content:space-between;align-items:center;padding:18px 24px 14px;border-bottom:1px solid var(--border);flex-shrink:0; }
.modal-head h2 { font-family:'Playfair Display',serif;font-size:18px;color:var(--navy); }
.modal-close { background:none;border:none;font-size:18px;cursor:pointer;color:#94a3b8;padding:2px 6px;border-radius:4px;transition:all .2s; }
.modal-close:hover { background:var(--light);color:var(--navy); }
.modal-body { flex:1;overflow-y:auto;padding:22px 24px; }
.modal-foot { display:flex;justify-content:flex-end;gap:10px;padding:14px 24px;border-top:1px solid var(--border);flex-shrink:0; }
.btn-cancel { padding:9px 20px;background:var(--light);color:var(--navy);border:1px solid var(--border);border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer;transition:all .2s; }
.btn-cancel:hover { background:var(--border); }
.btn-delete-confirm { padding:9px 20px;background:var(--red);color:#fff;border:none;border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer;transition:background .2s; }
.btn-delete-confirm:hover:not(:disabled) { background:var(--red-dark); }
.btn-restore-confirm { padding:9px 20px;background:#166534;color:#fff;border:none;border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer;transition:background .2s; }
.btn-restore-confirm:hover:not(:disabled) { background:#14532d; }
.delete-confirm { display:flex;flex-direction:column;align-items:center;text-align:center;gap:12px;padding:10px 0; }
.delete-icon { font-size:36px; }
.delete-confirm p { font-size:14px;color:var(--text);line-height:1.6; }

@media(max-width:768px){
    .ev-wrap { padding:16px; }
    .ev-tabs { overflow-x:auto; }
    .ev-tab  { padding:10px 14px;font-size:13px;white-space:nowrap; }
    .ev-grid-2 { grid-template-columns:1fr; }
    .sp-layout,.fp-layout { grid-template-columns:1fr; }
    .event-modal-preview { grid-template-columns:1fr; }
    .ev-list-item { flex-wrap:wrap; }
    .ev-list-actions { width:100%; }
    .modal-inner-tabs { overflow-x:auto; }
}
@media(max-width:480px){
    .filter-group { flex-wrap:wrap; }
    .ev-toggles-row { flex-direction:column;gap:14px; }
    .mit { white-space:nowrap;font-size:12px;padding:8px 12px; }
}
</style>