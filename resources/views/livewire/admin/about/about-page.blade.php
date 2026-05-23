{{-- resources/views/livewire/admin/about/about-page.blade.php --}}

<div class="ab-wrap" x-data>

    {{-- ── Page Header ──────────────────────────────────────────────── --}}
    <div class="ab-header">
        <div>
            <h1>About Page</h1>
            <p>Manage all sections of the public About Us page</p>
        </div>
        <a href="{{ route('about') }}" target="_blank" class="btn-preview">
            👁 Preview Page →
        </a>
    </div>

    {{-- ── Flash ───────────────────────────────────────────────────── --}}
    @if (session('success'))
        <div class="alert alert-success" x-data="{ show: true }" x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-end="opacity-0">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- ── Tabs ────────────────────────────────────────────────────── --}}
    <div class="ab-tabs">
        @foreach([
            'hero'    => ['icon' => '🦸', 'label' => 'Page Hero'],
            'story'   => ['icon' => '📖', 'label' => 'Our Story'],
            'stats'   => ['icon' => '📊', 'label' => 'Stats'],
            'mission' => ['icon' => '🎯', 'label' => 'Mission / Vision'],
        ] as $tab => $info)
        <button wire:click="setTab('{{ $tab }}')"
                class="ab-tab {{ $activeTab === $tab ? 'active' : '' }}">
            <span>{{ $info['icon'] }}</span> {{ $info['label'] }}
        </button>
        @endforeach
    </div>

    <div class="ab-body">

    {{-- ════════════════════════════════════════════════════
         TAB 1 — PAGE HERO
    ════════════════════════════════════════════════════ --}}
    @if ($activeTab === 'hero')
    <form wire:submit="saveHero">
        <div class="ab-card">
            <div class="ab-card-header">
                <div>
                    <h2>Page Hero Banner</h2>
                    <p>The large banner at the top of the About Us page</p>
                </div>
            </div>

            {{-- Live preview --}}
            <div class="hero-preview-box">
                <div class="hero-preview-badge">{{ $hero_badge ?: 'Est. 2013 · Bhairahawa, Nepal' }}</div>
                <div class="hero-preview-title">
                    {{ $hero_title ?: 'Your Trusted Partner in' }}
                    @if($hero_highlight)
                        <span class="hero-preview-hl"> {{ $hero_highlight }}</span>
                    @endif
                </div>
                <div class="hero-preview-sub">{{ Str::limit($hero_subtitle, 100) }}</div>
            </div>

            <div class="ab-grid-2" style="padding:24px">
                <div class="form-group">
                    <label>Badge Text</label>
                    <input type="text" wire:model.live="hero_badge"
                           placeholder="Est. 2013 · Bhairahawa, Nepal">
                    @error('hero_badge') <span class="fe">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Highlighted Word <span class="hint">Shown in gold/accent colour</span></label>
                    <input type="text" wire:model.live="hero_highlight"
                           placeholder="Global Education">
                    @error('hero_highlight') <span class="fe">{{ $message }}</span> @enderror
                </div>
                <div class="form-group ab-full">
                    <label>Title <span class="req">*</span></label>
                    <input type="text" wire:model.live="hero_title"
                           placeholder="Your Trusted Partner in">
                    @error('hero_title') <span class="fe">{{ $message }}</span> @enderror
                </div>
                <div class="form-group ab-full">
                    <label>Subtitle / Description</label>
                    <textarea wire:model.live="hero_subtitle" rows="3"
                              placeholder="For over a decade, HASU Educational Consultancy has been guiding..."></textarea>
                    @error('hero_subtitle') <span class="fe">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="ab-actions">
            <button type="submit" class="btn-save" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="saveHero">💾 Save Hero</span>
                <span wire:loading wire:target="saveHero">Saving…</span>
            </button>
        </div>
    </form>
    @endif

    {{-- ════════════════════════════════════════════════════
         TAB 2 — OUR STORY
    ════════════════════════════════════════════════════ --}}
    @if ($activeTab === 'story')
    <form wire:submit="saveStory">
        <div class="ab-card">
            <div class="ab-card-header">
                <h2>Story Section</h2>
                <p>Image, floating badge, section text, and timeline milestones</p>
            </div>

            <div style="padding:24px">

                {{-- ── Image + Float badge ── --}}
                <div class="ab-section-title">📸 Section Image & Floating Badge</div>
                <div class="ab-grid-2">
                    <div class="form-group">
                        <label>Story Image</label>
                        <div class="upload-box" x-data="{ drag:false }"
                             @dragover.prevent="drag=true" @dragleave.prevent="drag=false"
                             @drop.prevent="drag=false" :class="{'dragging':drag}">
                            @if ($story_image_upload)
                                <img src="{{ $story_image_upload->temporaryUrl() }}" class="upload-prev">
                            @elseif ($story_image_current)
                                <img src="{{ str_starts_with($story_image_current,'http') ? $story_image_current : Storage::url($story_image_current) }}" class="upload-prev">
                            @else
                                <div class="upload-ph"><span>🖼️</span><small>Click or drag · JPG, PNG, WebP · Max 3MB</small></div>
                            @endif
                            <input type="file" wire:model="story_image_upload" accept="image/*" class="upload-input">
                        </div>
                        @error('story_image_upload') <span class="fe">{{ $message }}</span> @enderror
                        <div wire:loading wire:target="story_image_upload" class="uploading">Uploading…</div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label>Float Badge Icon</label>
                            <input type="text" wire:model="story_float_icon" placeholder="🏆" maxlength="10">
                        </div>
                        <div class="form-group">
                            <label>Float Badge Title</label>
                            <input type="text" wire:model="story_float_title" placeholder="Best Consultancy">
                        </div>
                        <div class="form-group">
                            <label>Float Badge Subtitle</label>
                            <input type="text" wire:model="story_float_subtitle" placeholder="Bhairahawa Region, 2023">
                        </div>
                    </div>
                </div>

                {{-- ── Text content ── --}}
                <div class="ab-section-title" style="margin-top:28px">✍️ Story Text</div>
                <div class="ab-grid-2">
                    <div class="form-group">
                        <label>Section Label</label>
                        <input type="text" wire:model="story_section_label" placeholder="Our Story">
                    </div>
                    <div class="form-group">
                        <label>Section Title</label>
                        <input type="text" wire:model="story_section_title" placeholder="How HASU Began Its Journey">
                    </div>
                    <div class="form-group ab-full">
                        <label>Paragraph 1</label>
                        <textarea wire:model="story_paragraph_1" rows="4"
                                  placeholder="Founded in 2013 and officially registered in 2015..."></textarea>
                    </div>
                    <div class="form-group ab-full">
                        <label>Paragraph 2</label>
                        <textarea wire:model="story_paragraph_2" rows="3"
                                  placeholder="We specialize in guiding students to top universities..."></textarea>
                    </div>
                </div>

            </div>
        </div>

        <div class="ab-actions">
            <button type="submit" class="btn-save" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="saveStory">💾 Save Story Section</span>
                <span wire:loading wire:target="saveStory">Saving…</span>
            </button>
        </div>
    </form>

    {{-- ── Milestones sub-section ── --}}
    <div class="ab-card" style="margin-top:20px">
        <div class="ab-card-header">
            <div>
                <h2>Timeline Milestones</h2>
                <p>Drag to reorder. These appear in the story section timeline.</p>
            </div>
            <button type="button" wire:click="openCreateMilestone" class="btn-add-sm">+ Add Milestone</button>
        </div>

        <div class="ab-list" id="milestoneList">
            @forelse ($milestones as $m)
            <div class="ab-list-item" data-id="{{ $m['id'] }}">
                <div class="ab-drag">⠿</div>
                <div class="ab-list-year">{{ $m['year'] }}</div>
                <div class="ab-list-content">
                    <strong>{{ $m['title'] }}</strong>
                    <span>{{ Str::limit($m['description'] ?? '', 70) }}</span>
                </div>
                <div class="ab-list-actions">
                    <button type="button"
                            wire:click="toggleMilestone({{ $m['id'] }})"
                            class="ab-toggle {{ $m['is_active'] ? 'on' : 'off' }}">
                        {{ $m['is_active'] ? '✅' : '⭕' }}
                    </button>
                    <button type="button" wire:click="openEditMilestone({{ $m['id'] }})" class="ab-btn-edit">Edit</button>
                    <button type="button" wire:click="confirmDeleteMilestone({{ $m['id'] }})" class="ab-btn-del">Delete</button>
                </div>
            </div>
            @empty
            <div class="ab-empty">No milestones yet. Click <strong>+ Add Milestone</strong>.</div>
            @endforelse
        </div>
    </div>
    @endif

    {{-- ════════════════════════════════════════════════════
         TAB 3 — STATS
    ════════════════════════════════════════════════════ --}}
    @if ($activeTab === 'stats')
    <div class="ab-card">
        <div class="ab-card-header">
            <div>
                <h2>Statistics Row</h2>
                <p>The 4 numbers shown on the navy bar below the page hero. Drag to reorder.</p>
            </div>
            <button type="button" wire:click="openCreateStat" class="btn-add-sm">+ Add Stat</button>
        </div>

        {{-- Live preview --}}
        <div class="stats-preview">
            @foreach ($stats as $s)
            @if ($s['is_active'])
            <div class="sp-item">
                <span class="sp-num">{{ $s['number'] }}<span class="sp-accent">{{ $s['accent'] }}</span></span>
                <span class="sp-label">{{ $s['label'] }}</span>
            </div>
            @endif
            @endforeach
        </div>

        <div class="ab-list" id="statList">
            @forelse ($stats as $s)
            <div class="ab-list-item" data-id="{{ $s['id'] }}">
                <div class="ab-drag">⠿</div>
                <div class="ab-stat-preview">
                    <strong>{{ $s['number'] }}<span style="color:#f4c842">{{ $s['accent'] }}</span></strong>
                </div>
                <div class="ab-list-content">
                    <strong>{{ $s['label'] }}</strong>
                </div>
                <div class="ab-list-actions">
                    <button type="button" wire:click="toggleStat({{ $s['id'] }})"
                            class="ab-toggle {{ $s['is_active'] ? 'on' : 'off' }}">
                        {{ $s['is_active'] ? '✅' : '⭕' }}
                    </button>
                    <button type="button" wire:click="openEditStat({{ $s['id'] }})" class="ab-btn-edit">Edit</button>
                    <button type="button" wire:click="confirmDeleteStat({{ $s['id'] }})" class="ab-btn-del">Delete</button>
                </div>
            </div>
            @empty
            <div class="ab-empty">No stats yet. Click <strong>+ Add Stat</strong>.</div>
            @endforelse
        </div>
    </div>
    @endif

    {{-- ════════════════════════════════════════════════════
         TAB 4 — MISSION / VISION / PURPOSE
    ════════════════════════════════════════════════════ --}}
    @if ($activeTab === 'mission')
    <div class="ab-card">
        <div class="ab-card-header">
            <div>
                <h2>Mission, Vision & Purpose Cards</h2>
                <p>The 3-column card grid below the story section. Drag to reorder.</p>
            </div>
            <button type="button" wire:click="openCreateMv" class="btn-add-sm">+ Add Card</button>
        </div>

        {{-- Cards preview --}}
        <div class="mv-preview">
            @foreach ($mvCards as $c)
            @if ($c['is_active'])
            <div class="mvp-card">
                <div class="mvp-icon">{{ $c['icon'] }}</div>
                <h4>{{ $c['title'] }}</h4>
                <p>{{ Str::limit($c['body'], 90) }}</p>
            </div>
            @endif
            @endforeach
        </div>

        <div class="ab-list" id="mvList">
            @forelse ($mvCards as $c)
            <div class="ab-list-item" data-id="{{ $c['id'] }}">
                <div class="ab-drag">⠿</div>
                <div class="ab-mv-icon">{{ $c['icon'] }}</div>
                <div class="ab-list-content">
                    <strong>{{ $c['title'] }}</strong>
                    <span>{{ Str::limit($c['body'], 70) }}</span>
                </div>
                <div class="ab-list-actions">
                    <button type="button" wire:click="toggleMv({{ $c['id'] }})"
                            class="ab-toggle {{ $c['is_active'] ? 'on' : 'off' }}">
                        {{ $c['is_active'] ? '✅' : '⭕' }}
                    </button>
                    <button type="button" wire:click="openEditMv({{ $c['id'] }})" class="ab-btn-edit">Edit</button>
                    <button type="button" wire:click="confirmDeleteMv({{ $c['id'] }})" class="ab-btn-del">Delete</button>
                </div>
            </div>
            @empty
            <div class="ab-empty">No cards yet. Click <strong>+ Add Card</strong>.</div>
            @endforelse
        </div>
    </div>
    @endif

    </div>{{-- /.ab-body --}}

    {{-- ════════════════════════════════════════════════════
         MILESTONE MODAL
    ════════════════════════════════════════════════════ --}}
    @if ($showMilestoneModal)
    <div class="modal-backdrop">
        <div class="modal-box modal-sm" @click.outside="$wire.showMilestoneModal = false">
            <div class="modal-head">
                <h2>{{ $editingMilestoneId ? 'Edit Milestone' : 'Add Milestone' }}</h2>
                <button class="modal-close" wire:click="$set('showMilestoneModal',false)">✕</button>
            </div>
            <div class="modal-body">
                <form wire:submit="saveMilestone" id="msForm">
                    <div class="form-group">
                        <label>Year <span class="req">*</span></label>
                        <input type="text" wire:model="ms_year" placeholder="2013" maxlength="10">
                        @error('ms_year') <span class="fe">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Title <span class="req">*</span></label>
                        <input type="text" wire:model="ms_title" placeholder="Founded by Educational Visionaries">
                        @error('ms_title') <span class="fe">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea wire:model="ms_desc" rows="3" placeholder="Brief description of this milestone..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-foot">
                <button wire:click="$set('showMilestoneModal',false)" class="btn-cancel">Cancel</button>
                <button form="msForm" type="submit" class="btn-save" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="saveMilestone">{{ $editingMilestoneId ? 'Update' : 'Create' }}</span>
                    <span wire:loading wire:target="saveMilestone">Saving…</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ════════════════════════════════════════════════════
         STAT MODAL
    ════════════════════════════════════════════════════ --}}
    @if ($showStatModal)
    <div class="modal-backdrop">
        <div class="modal-box modal-sm" @click.outside="$wire.showStatModal = false">
            <div class="modal-head">
                <h2>{{ $editingStatId ? 'Edit Stat' : 'Add Stat' }}</h2>
                <button class="modal-close" wire:click="$set('showStatModal',false)">✕</button>
            </div>
            <div class="modal-body">
                {{-- Live preview --}}
                <div class="stat-modal-preview">
                    <span class="smp-num">{{ $st_number ?: '0' }}<span class="smp-accent">{{ $st_accent ?: '+' }}</span></span>
                    <span class="smp-label">{{ $st_label ?: 'Label' }}</span>
                </div>
                <form wire:submit="saveStat" id="stForm">
                    <div class="ab-grid-2">
                        <div class="form-group">
                            <label>Number <span class="req">*</span>
                                <span class="hint">e.g. 11 or 5000</span>
                            </label>
                            <input type="text" wire:model.live="st_number" placeholder="11">
                            @error('st_number') <span class="fe">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Accent <span class="req">*</span>
                                <span class="hint">e.g. + or %</span>
                            </label>
                            <input type="text" wire:model.live="st_accent" placeholder="+" maxlength="5">
                            @error('st_accent') <span class="fe">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Label <span class="req">*</span></label>
                        <input type="text" wire:model.live="st_label" placeholder="Years of Experience">
                        @error('st_label') <span class="fe">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-foot">
                <button wire:click="$set('showStatModal',false)" class="btn-cancel">Cancel</button>
                <button form="stForm" type="submit" class="btn-save" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="saveStat">{{ $editingStatId ? 'Update' : 'Create' }}</span>
                    <span wire:loading wire:target="saveStat">Saving…</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ════════════════════════════════════════════════════
         MV CARD MODAL
    ════════════════════════════════════════════════════ --}}
    @if ($showMvModal)
    <div class="modal-backdrop">
        <div class="modal-box modal-sm" @click.outside="$wire.showMvModal = false">
            <div class="modal-head">
                <h2>{{ $editingMvId ? 'Edit Card' : 'Add Card' }}</h2>
                <button class="modal-close" wire:click="$set('showMvModal',false)">✕</button>
            </div>
            <div class="modal-body">
                {{-- Live preview --}}
                @if($mv_icon || $mv_title)
                <div class="mv-modal-preview">
                    <div class="mvmp-icon">{{ $mv_icon ?: '🎯' }}</div>
                    <h4>{{ $mv_title ?: 'Card Title' }}</h4>
                    <p>{{ Str::limit($mv_body, 80) ?: 'Card description will appear here.' }}</p>
                </div>
                @endif
                <form wire:submit="saveMv" id="mvForm">
                    <div class="ab-grid-2">
                        <div class="form-group">
                            <label>Icon Emoji <span class="req">*</span></label>
                            <input type="text" wire:model.live="mv_icon" placeholder="🎯" maxlength="10">
                            @error('mv_icon') <span class="fe">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Card Title <span class="req">*</span></label>
                            <input type="text" wire:model.live="mv_title" placeholder="Our Mission">
                            @error('mv_title') <span class="fe">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Body Text <span class="req">*</span></label>
                        <textarea wire:model.live="mv_body" rows="4"
                                  placeholder="To empower Nepali students with genuine, expert guidance..."></textarea>
                        <div class="char-count">{{ strlen($mv_body) }} / 600</div>
                        @error('mv_body') <span class="fe">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-foot">
                <button wire:click="$set('showMvModal',false)" class="btn-cancel">Cancel</button>
                <button form="mvForm" type="submit" class="btn-save" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="saveMv">{{ $editingMvId ? 'Update' : 'Create' }}</span>
                    <span wire:loading wire:target="saveMv">Saving…</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ════════════════════════════════════════════════════
         DELETE CONFIRM MODALS (shared pattern)
    ════════════════════════════════════════════════════ --}}
    @foreach([
        ['show' => $showMilestoneDelete, 'closeField' => 'showMilestoneDelete', 'action' => 'deleteMilestone', 'label' => 'milestone'],
        ['show' => $showStatDelete,      'closeField' => 'showStatDelete',      'action' => 'deleteStat',      'label' => 'stat'],
        ['show' => $showMvDelete,        'closeField' => 'showMvDelete',        'action' => 'deleteMv',        'label' => 'card'],
    ] as $del)
    @if ($del['show'])
    <div class="modal-backdrop">
        <div class="modal-box modal-xs">
            <div class="modal-head">
                <h2>Delete {{ ucfirst($del['label']) }}</h2>
                <button class="modal-close" wire:click="$set('{{ $del['closeField'] }}',false)">✕</button>
            </div>
            <div class="modal-body">
                <div class="delete-confirm">
                    <span class="delete-icon">🗑️</span>
                    <p>Are you sure? This cannot be undone.</p>
                </div>
            </div>
            <div class="modal-foot">
                <button wire:click="$set('{{ $del['closeField'] }}',false)" class="btn-cancel">Cancel</button>
                <button wire:click="{{ $del['action'] }}" class="btn-delete-confirm"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove>Delete</span>
                    <span wire:loading>Deleting…</span>
                </button>
            </div>
        </div>
    </div>
    @endif
    @endforeach

</div>

{{-- SortableJS --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
document.addEventListener('livewire:initialized', () => initAllSortables());
Livewire.hook('commit', ({ succeed }) => { succeed(() => setTimeout(initAllSortables, 60)); });

function initAllSortables() {
    [
        { id: 'milestoneList', fn: (ids) => @this.reorderMilestones(ids) },
        { id: 'statList',      fn: (ids) => @this.reorderStats(ids) },
        { id: 'mvList',        fn: (ids) => @this.reorderMvCards(ids) },
    ].forEach(({ id, fn }) => {
        const el = document.getElementById(id);
        if (!el || el._sortable) return;
        el._sortable = Sortable.create(el, {
            handle: '.ab-drag',
            animation: 150,
            ghostClass: 'ab-list-item--ghost',
            onEnd() {
                fn([...el.querySelectorAll('.ab-list-item')].map(i => +i.dataset.id));
            }
        });
    });
}
</script>

<style>
:root {
    --navy:#0d1560;--blue:#2952e3;--blue-light:#e8edfd;
    --red:#cc2222;--red-dark:#a81a1a;--border:#e2e8f0;
    --text:#555;--light:#f5f7fb;--radius:8px;--shadow:0 2px 12px rgba(0,0,0,.07);
}

/* ── Page ── */
.ab-wrap { padding:32px 28px; }
.ab-header { display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px; }
.ab-header h1 { font-family:'Playfair Display',serif;font-size:24px;color:var(--navy);margin-bottom:4px; }
.ab-header p  { font-size:13px;color:var(--text); }
.btn-preview  { padding:9px 18px;border:1.5px solid var(--border);border-radius:var(--radius);font-size:13px;font-weight:600;color:var(--navy);text-decoration:none;transition:all .2s; }
.btn-preview:hover { border-color:var(--blue);color:var(--blue); }
.alert { display:flex;align-items:center;gap:10px;padding:12px 18px;border-radius:var(--radius);font-size:14px;font-weight:500;margin-bottom:20px;background:#f0fdf4;color:#166534;border:1px solid #bbf7d0; }

/* ── Tabs ── */
.ab-tabs { display:flex;gap:4px;border-bottom:2px solid var(--border);margin-bottom:28px; }
.ab-tab  { display:flex;align-items:center;gap:7px;padding:10px 20px;background:none;border:none;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:500;color:var(--text);cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-2px;transition:all .2s;border-radius:6px 6px 0 0; }
.ab-tab:hover  { color:var(--navy);background:var(--light); }
.ab-tab.active { color:var(--navy);border-bottom-color:var(--red);background:#fff;font-weight:600; }

/* ── Cards ── */
.ab-card { background:#fff;border-radius:12px;border:1px solid var(--border);box-shadow:var(--shadow);overflow:hidden;margin-bottom:20px; }
.ab-card-header { display:flex;justify-content:space-between;align-items:center;padding:18px 24px 16px;border-bottom:1px solid var(--border);background:var(--light);flex-wrap:wrap;gap:10px; }
.ab-card-header h2 { font-size:16px;font-weight:700;color:var(--navy);margin-bottom:3px; }
.ab-card-header p  { font-size:13px;color:var(--text); }
.ab-actions { display:flex;justify-content:flex-end;margin-bottom:8px; }
.btn-save { display:inline-flex;align-items:center;gap:8px;padding:10px 26px;background:var(--red);color:#fff;border:none;border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer;transition:background .2s; }
.btn-save:hover:not(:disabled){ background:var(--red-dark); }
.btn-save:disabled { opacity:.65;cursor:not-allowed; }
.btn-add-sm { padding:7px 16px;background:var(--navy);color:#fff;border:none;border-radius:var(--radius);font-size:13px;font-weight:600;cursor:pointer;transition:background .2s;white-space:nowrap; }
.btn-add-sm:hover { background:var(--blue); }

/* ── Form ── */
.ab-grid-2 { display:grid;grid-template-columns:1fr 1fr;gap:14px 20px; }
.ab-full   { grid-column:1/-1; }
.form-group { display:flex;flex-direction:column;gap:6px; }
.form-group label { font-size:13px;font-weight:600;color:var(--navy); }
.form-group input[type="text"],
.form-group input[type="tel"],
.form-group textarea {
    width:100%;padding:9px 13px;border:1.5px solid var(--border);border-radius:var(--radius);
    font-family:'DM Sans',sans-serif;font-size:14px;color:#333;outline:none;
    transition:border-color .2s,box-shadow .2s;resize:vertical;
}
.form-group input:focus,.form-group textarea:focus { border-color:var(--blue);box-shadow:0 0 0 3px rgba(41,82,227,.1); }
.req   { color:var(--red); }
.hint  { font-size:11px;font-weight:400;color:#94a3b8;margin-left:4px; }
.fe    { font-size:12px;color:var(--red); }
.char-count { font-size:11px;color:#94a3b8;text-align:right; }
.ab-section-title { font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#94a3b8;margin-bottom:12px; }

/* ── Hero preview ── */
.hero-preview-box { background:linear-gradient(120deg,#0d1560,#2952e3);padding:24px 28px;margin:0; }
.hero-preview-badge { font-size:10px;font-weight:800;letter-spacing:2px;text-transform:uppercase;background:var(--red);color:#fff;display:inline-block;padding:4px 12px;border-radius:2px;margin-bottom:10px; }
.hero-preview-title { font-family:'Playfair Display',serif;font-size:22px;color:#fff;line-height:1.2; }
.hero-preview-hl   { color:#f4c842; }
.hero-preview-sub  { font-size:13px;color:rgba(255,255,255,.7);margin-top:8px; }

/* ── Stats preview ── */
.stats-preview { display:flex;background:var(--navy);padding:0; }
.sp-item   { flex:1;padding:20px;text-align:center;border-right:1px solid rgba(255,255,255,.1); }
.sp-item:last-child { border-right:none; }
.sp-num    { font-family:'Playfair Display',serif;font-size:28px;font-weight:700;color:#fff;display:block;line-height:1; }
.sp-accent { color:#f4c842; }
.sp-label  { font-size:12px;color:rgba(255,255,255,.6);display:block;margin-top:4px; }

/* Stat modal preview */
.stat-modal-preview { background:var(--navy);border-radius:var(--radius);padding:16px 24px;text-align:center;margin-bottom:20px; }
.smp-num    { font-family:'Playfair Display',serif;font-size:32px;font-weight:700;color:#fff;display:block;line-height:1; }
.smp-accent { color:#f4c842; }
.smp-label  { font-size:13px;color:rgba(255,255,255,.65);display:block;margin-top:6px; }

/* ── MV cards preview ── */
.mv-preview { display:grid;grid-template-columns:repeat(3,1fr);gap:16px;padding:20px 24px;background:var(--light);border-bottom:1px solid var(--border); }
.mvp-card   { background:#fff;border-radius:10px;padding:20px;border:1px solid var(--border);text-align:left; }
.mvp-icon   { font-size:28px;margin-bottom:10px; }
.mvp-card h4{ font-size:14px;font-weight:700;color:var(--navy);margin-bottom:6px; }
.mvp-card p { font-size:12px;color:var(--text);line-height:1.5; }

/* MV modal preview */
.mv-modal-preview { background:var(--light);border:1px solid var(--border);border-radius:var(--radius);padding:18px 20px;margin-bottom:18px;text-align:center; }
.mvmp-icon { font-size:36px;margin-bottom:8px; }
.mv-modal-preview h4 { font-size:16px;font-weight:700;color:var(--navy);margin-bottom:6px; }
.mv-modal-preview p  { font-size:13px;color:var(--text);line-height:1.6; }

/* ── List ── */
.ab-list { padding:0 16px 16px; }
.ab-list-item { display:flex;align-items:center;gap:12px;background:#fff;border:1px solid var(--border);border-radius:8px;padding:12px 16px;margin-top:10px;transition:box-shadow .2s; }
.ab-list-item:hover { box-shadow:0 3px 14px rgba(0,0,0,.08); }
.ab-list-item--ghost { opacity:.4;background:var(--light); }
.ab-drag  { cursor:grab;color:#cbd5e1;font-size:18px;flex-shrink:0;padding:2px 4px;border-radius:4px; }
.ab-drag:hover { color:var(--navy);background:var(--light); }
.ab-list-year { background:var(--navy);color:#fff;font-size:12px;font-weight:700;padding:5px 12px;border-radius:4px;flex-shrink:0; }
.ab-stat-preview strong { font-family:'Playfair Display',serif;font-size:20px;font-weight:700;color:var(--navy);min-width:60px;display:block;text-align:center; }
.ab-mv-icon { font-size:24px;flex-shrink:0; }
.ab-list-content { flex:1;min-width:0; }
.ab-list-content strong { display:block;font-size:14px;font-weight:600;color:var(--navy);margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
.ab-list-content span   { font-size:12px;color:var(--text); }
.ab-list-actions { display:flex;align-items:center;gap:8px;flex-shrink:0; }
.ab-toggle { font-size:12px;padding:4px 10px;border:none;border-radius:20px;cursor:pointer;font-weight:600; }
.ab-toggle.on  { background:#dcfce7;color:#166534; }
.ab-toggle.off { background:#fee2e2;color:#991b1b; }
.ab-btn-edit { font-size:12px;font-weight:600;padding:5px 12px;border-radius:var(--radius);border:none;cursor:pointer;background:var(--blue-light);color:var(--blue);transition:all .2s; }
.ab-btn-edit:hover { background:var(--blue);color:#fff; }
.ab-btn-del  { font-size:12px;font-weight:600;padding:5px 12px;border-radius:var(--radius);border:none;cursor:pointer;background:#fee2e2;color:var(--red);transition:all .2s; }
.ab-btn-del:hover  { background:var(--red);color:#fff; }
.ab-empty { text-align:center;padding:32px;font-size:14px;color:#94a3b8; }

/* ── Upload ── */
.upload-box { border:2px dashed var(--border);border-radius:var(--radius);min-height:120px;position:relative;cursor:pointer;display:flex;align-items:center;justify-content:center;overflow:hidden;transition:border-color .2s,background .2s; }
.upload-box:hover,.upload-box.dragging { border-color:var(--blue);background:var(--blue-light); }
.upload-ph  { display:flex;flex-direction:column;align-items:center;gap:6px;color:#94a3b8;text-align:center; }
.upload-ph span { font-size:28px; }
.upload-ph small{ font-size:12px; }
.upload-prev { max-width:100%;max-height:120px;object-fit:contain;padding:8px; }
.upload-input{ position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%; }
.uploading   { font-size:12px;color:var(--blue);margin-top:4px; }

/* ── Modal ── */
.modal-backdrop { position:fixed;inset:0;z-index:1000;background:rgba(13,21,96,.45);backdrop-filter:blur(3px);display:flex;align-items:center;justify-content:center;padding:20px; }
.modal-box { background:#fff;border-radius:14px;box-shadow:0 20px 60px rgba(0,0,0,.25);width:100%;display:flex;flex-direction:column;max-height:90vh;overflow:hidden; }
.modal-xs  { max-width:360px; }
.modal-sm  { max-width:520px; }
.modal-head{ display:flex;justify-content:space-between;align-items:center;padding:18px 24px 14px;border-bottom:1px solid var(--border);flex-shrink:0; }
.modal-head h2 { font-family:'Playfair Display',serif;font-size:18px;color:var(--navy); }
.modal-close { background:none;border:none;font-size:18px;cursor:pointer;color:#94a3b8;padding:2px 6px;border-radius:4px;transition:all .2s; }
.modal-close:hover { background:var(--light);color:var(--navy); }
.modal-body { flex:1;overflow-y:auto;padding:20px 24px; }
.modal-foot { display:flex;justify-content:flex-end;gap:10px;padding:14px 24px;border-top:1px solid var(--border);flex-shrink:0; }
.btn-cancel { padding:9px 20px;background:var(--light);color:var(--navy);border:1px solid var(--border);border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer;transition:all .2s; }
.btn-cancel:hover { background:var(--border); }
.btn-delete-confirm { padding:9px 20px;background:var(--red);color:#fff;border:none;border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer;transition:background .2s; }
.btn-delete-confirm:hover:not(:disabled) { background:var(--red-dark); }
.delete-confirm { display:flex;flex-direction:column;align-items:center;text-align:center;gap:12px;padding:8px 0; }
.delete-icon { font-size:36px; }
.delete-confirm p { font-size:14px;color:var(--text);line-height:1.6; }

@media(max-width:640px){
    .ab-wrap { padding:16px; }
    .ab-tabs { overflow-x:auto; }
    .ab-tab  { padding:10px 14px;font-size:13px;white-space:nowrap; }
    .ab-grid-2 { grid-template-columns:1fr; }
    .mv-preview { grid-template-columns:1fr; }
    .stats-preview { flex-wrap:wrap; }
}
</style>