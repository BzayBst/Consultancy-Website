{{-- resources/views/livewire/admin/home/home-about.blade.php --}}

<div class="ha-wrap" x-data>

    {{-- ── Header ──────────────────────────────────────────────────── --}}
    <div class="ha-header">
        <div>
            <h1>Home – About Section</h1>
            <p>Manage the "About The Company" section on the homepage</p>
        </div>
        <a href="{{ route('home') }}#about" target="_blank" class="btn-preview">
            👁 Preview Section →
        </a>
    </div>

    {{-- ── Flash ───────────────────────────────────────────────────── --}}
    @if (session('success'))
        <div class="alert alert-success"
             x-data="{ show: true }" x-show="show"
             x-init="setTimeout(() => show = false, 3200)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-end="opacity-0">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- ══════════════════════════════════════════════════
         LIVE PREVIEW
    ══════════════════════════════════════════════════ --}}
    <div class="ha-preview">
        <div class="ha-preview-label">Live Preview</div>
        <div class="hap-inner">
            {{-- Left: image + badge --}}
            <div class="hap-img-side">
                <div class="hap-img-wrap">
                    @if ($image_upload)
                        <img src="{{ $image_upload->temporaryUrl() }}" alt="preview">
                    @elseif ($image_current)
                        <img src="{{ str_starts_with($image_current,'http') ? $image_current : Storage::url($image_current) }}" alt="{{ $image_alt }}">
                    @else
                        <div class="hap-img-placeholder">🖼️</div>
                    @endif
                    @if ($badge_number)
                    <div class="hap-badge">
                        <strong>{{ $badge_number }}</strong>
                        <span>{{ $badge_label ?: 'Years of Experience' }}</span>
                    </div>
                    @endif
                </div>
            </div>
            {{-- Right: content --}}
            <div class="hap-content-side">
                <div class="hap-section-label">{{ $section_label ?: 'About The Company' }}</div>
                <div class="hap-section-title">{{ $section_title ?: 'Your Trusted Partner in Global Education' }}</div>
                @if ($paragraph_1)
                    <p class="hap-para">{{ Str::limit($paragraph_1, 120) }}</p>
                @endif
                @if (!empty(array_filter($badges, fn($b) => !empty($b['label']))))
                <div class="hap-badges">
                    @foreach ($badges as $b)
                        @if(!empty($b['label']))
                        <div class="hap-badge-chip">
                            <span>{{ $b['icon'] ?? '' }}</span>
                            <strong>{{ $b['label'] }}</strong>
                        </div>
                        @endif
                    @endforeach
                </div>
                @endif
                @if (!empty(array_filter($perks, fn($p) => trim($p) !== '')))
                <ul class="hap-perks">
                    @foreach ($perks as $p)
                        @if(trim($p) !== '') <li>{{ $p }}</li> @endif
                    @endforeach
                </ul>
                @endif
                @if ($cta_label)
                <div class="hap-cta">
                    <span class="hap-btn">{{ $cta_label }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════
         FORM
    ══════════════════════════════════════════════════ --}}
    <form wire:submit="save">

        {{-- ── Card 1: Image & Badge ── --}}
        <div class="ha-card">
            <div class="ha-card-header">
                <h2>📸 Section Image & Experience Badge</h2>
            </div>
            <div class="ha-grid-2" style="padding:24px">

                {{-- Image --}}
                <div class="form-group">
                    <label>Section Image</label>
                    <div class="upload-box" x-data="{ drag: false }"
                         @dragover.prevent="drag=true"
                         @dragleave.prevent="drag=false"
                         @drop.prevent="drag=false"
                         :class="{ 'dragging': drag }">
                        @if ($image_upload)
                            <img src="{{ $image_upload->temporaryUrl() }}" class="upload-prev">
                        @elseif ($image_current)
                            <img src="{{ str_starts_with($image_current,'http') ? $image_current : Storage::url($image_current) }}" class="upload-prev">
                        @else
                            <div class="upload-ph">
                                <span>🖼️</span>
                                <small>Click or drag · JPG, PNG, WebP · Max 3MB</small>
                            </div>
                        @endif
                        <input type="file" wire:model="image_upload" accept="image/*" class="upload-input">
                    </div>
                    @error('image_upload') <span class="fe">{{ $message }}</span> @enderror
                    <div wire:loading wire:target="image_upload" class="uploading-msg">Uploading…</div>
                </div>

                {{-- Badge + Alt --}}
                <div>
                    <div class="form-group">
                        <label>Image Alt Text</label>
                        <input type="text" wire:model="image_alt" placeholder="About HASU">
                        @error('image_alt') <span class="fe">{{ $message }}</span> @enderror
                    </div>

                    <div class="badge-mini-preview">
                        <strong>{{ $badge_number ?: '11' }}</strong>
                        <span>{{ $badge_label ?: 'Years of Experience' }}</span>
                    </div>

                    <div class="ha-grid-2" style="margin-top:0">
                        <div class="form-group">
                            <label>Badge Number</label>
                            <input type="text" wire:model.live="badge_number" placeholder="11">
                            @error('badge_number') <span class="fe">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Badge Label</label>
                            <input type="text" wire:model.live="badge_label" placeholder="Years of Experience">
                            @error('badge_label') <span class="fe">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── Card 2: Text Content ── --}}
        <div class="ha-card">
            <div class="ha-card-header">
                <h2>✍️ Section Text</h2>
            </div>
            <div style="padding:24px">
                <div class="ha-grid-2">
                    <div class="form-group">
                        <label>Section Label <span class="req">*</span></label>
                        <input type="text" wire:model.live="section_label" placeholder="About The Company">
                        @error('section_label') <span class="fe">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Section Title <span class="req">*</span></label>
                        <input type="text" wire:model.live="section_title" placeholder="Your Trusted Partner in Global Education">
                        @error('section_title') <span class="fe">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group ha-full">
                        <label>Paragraph 1</label>
                        <textarea wire:model.live="paragraph_1" rows="4"
                                  placeholder="Established in 2013 and officially registered in 2015..."></textarea>
                        <div class="char-count">{{ strlen($paragraph_1) }} / 1500</div>
                        @error('paragraph_1') <span class="fe">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group ha-full">
                        <label>Paragraph 2</label>
                        <textarea wire:model.live="paragraph_2" rows="3"
                                  placeholder="We specialize in Japanese language prep (NAT, JLPT, J-TEST)..."></textarea>
                        <div class="char-count">{{ strlen($paragraph_2) }} / 1500</div>
                        @error('paragraph_2') <span class="fe">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Card 3: Badges (icon chips) ── --}}
        <div class="ha-card">
            <div class="ha-card-header">
                <div>
                    <h2>🏅 Icon Badges</h2>
                    <p>The highlighted chips shown below the paragraphs (e.g. "Best Immigration Resources")</p>
                </div>
                <button type="button" wire:click="addBadge" class="btn-add-sm">+ Add Badge</button>
            </div>
            <div style="padding:20px 24px">
                @foreach ($badges as $i => $badge)
                <div class="badge-row">
                    <input type="text"
                           wire:model.live="badges.{{ $i }}.icon"
                           class="badge-icon-input" placeholder="🏅" maxlength="10">
                    <input type="text"
                           wire:model.live="badges.{{ $i }}.label"
                           class="badge-label-input" placeholder="Best Immigration Resources">
                    <button type="button" wire:click="removeBadge({{ $i }})" class="row-remove">✕</button>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ── Card 4: Perks list ── --}}
        <div class="ha-card">
            <div class="ha-card-header">
                <div>
                    <h2>✅ Perks / Bullet Points</h2>
                    <p>The checkmark list items shown below the badges</p>
                </div>
                <button type="button" wire:click="addPerk" class="btn-add-sm">+ Add Perk</button>
            </div>
            <div style="padding:20px 24px">
                @foreach ($perks as $i => $perk)
                <div class="perk-row">
                    <span class="perk-check">✓</span>
                    <input type="text"
                           wire:model.live="perks.{{ $i }}"
                           placeholder="Offer 100% Genuine Assistance">
                    <button type="button" wire:click="removePerk({{ $i }})" class="row-remove">✕</button>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ── Card 5: CTA Button ── --}}
        <div class="ha-card">
            <div class="ha-card-header">
                <h2>🔗 CTA Button</h2>
            </div>
            <div class="ha-grid-2" style="padding:24px">
                <div class="form-group">
                    <label>Button Label</label>
                    <input type="text" wire:model="cta_label" placeholder="Know More">
                    @error('cta_label') <span class="fe">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Button Link (href)</label>
                    <input type="text" wire:model="cta_href" placeholder="/about">
                    @error('cta_href') <span class="fe">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- ── Save ── --}}
        <div class="ha-actions">
            <button type="submit" class="btn-save" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="save">💾 Save About Section</span>
                <span wire:loading wire:target="save">Saving…</span>
            </button>
        </div>

    </form>

</div>

<style>
:root{--navy:#0d1560;--blue:#2952e3;--blue-light:#e8edfd;--red:#cc2222;--red-dark:#a81a1a;--border:#e2e8f0;--text:#555;--light:#f5f7fb;--radius:8px;--shadow:0 2px 12px rgba(0,0,0,.07);}

/* ── Page ── */
.ha-wrap   { padding:32px 28px; max-width:1100px; }
.ha-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
.ha-header h1 { font-family:'Playfair Display',serif; font-size:24px; color:var(--navy); margin-bottom:4px; }
.ha-header p  { font-size:13px; color:var(--text); }
.btn-preview  { padding:9px 18px; border:1.5px solid var(--border); border-radius:var(--radius); font-size:13px; font-weight:600; color:var(--navy); text-decoration:none; transition:all .2s; }
.btn-preview:hover { border-color:var(--blue); color:var(--blue); }
.alert { display:flex; align-items:center; gap:10px; padding:12px 18px; border-radius:var(--radius); font-size:14px; font-weight:500; margin-bottom:20px; background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; }

/* ── Live Preview ── */
.ha-preview { background:var(--light); border:1px solid var(--border); border-radius:12px; padding:20px 24px; margin-bottom:28px; }
.ha-preview-label { font-size:10px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:#94a3b8; margin-bottom:14px; }
.hap-inner { display:grid; grid-template-columns:1fr 1.4fr; gap:32px; align-items:center; }
.hap-img-side { position:relative; }
.hap-img-wrap { position:relative; border-radius:10px; overflow:visible; }
.hap-img-wrap img { width:100%; height:200px; object-fit:cover; border-radius:10px; display:block; }
.hap-img-placeholder { width:100%; height:200px; background:#e2e8f0; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:40px; color:#94a3b8; }
.hap-badge { position:absolute; bottom:-12px; right:-12px; background:linear-gradient(135deg,var(--blue),var(--red)); color:#fff; border-radius:8px; padding:12px 16px; text-align:center; box-shadow:var(--shadow); }
.hap-badge strong { display:block; font-size:22px; font-weight:700; line-height:1; }
.hap-badge span   { font-size:10px; opacity:.9; letter-spacing:1px; }
.hap-section-label { font-size:10px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--red); margin-bottom:6px; display:flex; align-items:center; gap:10px; }
.hap-section-label::before,.hap-section-label::after { content:''; display:block; width:20px; height:2px; background:var(--red); }
.hap-section-title { font-family:'Playfair Display',serif; font-size:18px; font-weight:700; color:var(--navy); margin-bottom:8px; }
.hap-para { font-size:12px; color:var(--text); line-height:1.6; margin-bottom:10px; }
.hap-badges { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:10px; }
.hap-badge-chip { display:flex; align-items:center; gap:6px; background:var(--blue-light); border-left:3px solid var(--blue); border-radius:6px; padding:8px 12px; }
.hap-badge-chip span { font-size:16px; }
.hap-badge-chip strong { font-size:12px; color:var(--navy); }
.hap-perks { list-style:none; margin-bottom:10px; padding:0; }
.hap-perks li { font-size:12px; color:var(--text); padding:3px 0; display:flex; align-items:center; gap:6px; }
.hap-perks li::before { content:'✓'; color:var(--red); font-weight:700; }
.hap-cta { margin-top:8px; }
.hap-btn { display:inline-block; background:var(--red); color:#fff; font-size:12px; font-weight:600; padding:8px 18px; border-radius:4px; }

/* ── Badge mini preview ── */
.badge-mini-preview { background:linear-gradient(135deg,var(--blue),var(--red)); color:#fff; border-radius:8px; padding:14px 20px; text-align:center; margin:12px 0; display:inline-flex; flex-direction:column; align-items:center; gap:4px; }
.badge-mini-preview strong { font-family:'Playfair Display',serif; font-size:28px; font-weight:700; line-height:1; }
.badge-mini-preview span   { font-size:11px; opacity:.9; }

/* ── Cards ── */
.ha-card { background:#fff; border-radius:12px; border:1px solid var(--border); box-shadow:var(--shadow); overflow:hidden; margin-bottom:20px; }
.ha-card-header { display:flex; justify-content:space-between; align-items:center; padding:16px 24px 14px; border-bottom:1px solid var(--border); background:var(--light); flex-wrap:wrap; gap:10px; }
.ha-card-header h2 { font-size:15px; font-weight:700; color:var(--navy); margin-bottom:3px; }
.ha-card-header p  { font-size:12px; color:var(--text); }
.ha-actions { display:flex; justify-content:flex-end; margin-top:4px; margin-bottom:16px; }
.btn-save { display:inline-flex; align-items:center; gap:8px; padding:11px 28px; background:var(--red); color:#fff; border:none; border-radius:var(--radius); font-family:'DM Sans',sans-serif; font-size:14px; font-weight:600; cursor:pointer; transition:background .2s; }
.btn-save:hover:not(:disabled) { background:var(--red-dark); }
.btn-save:disabled { opacity:.65; cursor:not-allowed; }
.btn-add-sm { padding:7px 14px; background:var(--navy); color:#fff; border:none; border-radius:var(--radius); font-size:13px; font-weight:600; cursor:pointer; white-space:nowrap; transition:background .2s; }
.btn-add-sm:hover { background:var(--blue); }

/* ── Form ── */
.ha-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:14px 20px; }
.ha-full   { grid-column:1/-1; }
.form-group { display:flex; flex-direction:column; gap:6px; }
.form-group label { font-size:13px; font-weight:600; color:var(--navy); }
.form-group input[type="text"],
.form-group textarea {
    width:100%; padding:9px 13px; border:1.5px solid var(--border);
    border-radius:var(--radius); font-family:'DM Sans',sans-serif;
    font-size:14px; color:#333; outline:none;
    transition:border-color .2s, box-shadow .2s; resize:vertical;
}
.form-group input:focus,.form-group textarea:focus { border-color:var(--blue); box-shadow:0 0 0 3px rgba(41,82,227,.1); }
.req   { color:var(--red); }
.fe    { font-size:12px; color:var(--red); }
.char-count { font-size:11px; color:#94a3b8; text-align:right; }

/* ── Upload ── */
.upload-box { border:2px dashed var(--border); border-radius:var(--radius); min-height:120px; position:relative; cursor:pointer; display:flex; align-items:center; justify-content:center; overflow:hidden; transition:border-color .2s, background .2s; }
.upload-box:hover,.upload-box.dragging { border-color:var(--blue); background:var(--blue-light); }
.upload-ph  { display:flex; flex-direction:column; align-items:center; gap:6px; color:#94a3b8; text-align:center; }
.upload-ph span  { font-size:28px; }
.upload-ph small { font-size:12px; }
.upload-prev { max-width:100%; max-height:120px; object-fit:contain; padding:8px; }
.upload-input { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
.uploading-msg { font-size:12px; color:var(--blue); margin-top:4px; }

/* ── Badge rows ── */
.badge-row { display:flex; gap:10px; align-items:center; margin-bottom:10px; }
.badge-icon-input  { width:70px !important; text-align:center; font-size:18px; flex-shrink:0; }
.badge-label-input { flex:1; }
.row-remove { background:#fee2e2; color:var(--red); border:none; width:30px; height:30px; border-radius:50%; cursor:pointer; font-size:13px; flex-shrink:0; transition:all .2s; display:flex; align-items:center; justify-content:center; }
.row-remove:hover { background:var(--red); color:#fff; }

/* ── Perk rows ── */
.perk-row { display:flex; gap:10px; align-items:center; margin-bottom:10px; }
.perk-check { color:var(--red); font-weight:700; font-size:16px; flex-shrink:0; }
.perk-row input { flex:1; }

@media(max-width:768px){
    .ha-wrap  { padding:16px; }
    .ha-grid-2 { grid-template-columns:1fr; }
    .hap-inner { grid-template-columns:1fr; }
}
</style>