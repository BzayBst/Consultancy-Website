<div class="sa-wrap">
    <div class="sa-header">
        <div>
            <h1>Contact & Appointments</h1>
            <p>Manage page text and review submitted forms.</p>
        </div>
        <div class="sa-header-actions">
            <a href="{{ route('contact') }}" target="_blank" class="btn-preview">Preview Contact</a>
            <a href="{{ route('book-appointment') }}" target="_blank" class="btn-preview">Preview Booking</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="sa-tabs">
        <button wire:click="setTab('contact-page')" class="sa-tab {{ $activeTab === 'contact-page' ? 'active' : '' }}">Contact Page</button>
        <button wire:click="setTab('branches')" class="sa-tab {{ $activeTab === 'branches' ? 'active' : '' }}">Branch Offices <span>{{ $branches->count() }}</span></button>
        <button wire:click="setTab('faqs')" class="sa-tab {{ $activeTab === 'faqs' ? 'active' : '' }}">FAQs <span>{{ $faqs->count() }}</span></button>
        <button wire:click="setTab('appointment-page')" class="sa-tab {{ $activeTab === 'appointment-page' ? 'active' : '' }}">Booking Page</button>
        <button wire:click="setTab('contacts')" class="sa-tab {{ $activeTab === 'contacts' ? 'active' : '' }}">Contact Inbox <span>{{ $contactSubmissions->total() }}</span></button>
        <button wire:click="setTab('appointments')" class="sa-tab {{ $activeTab === 'appointments' ? 'active' : '' }}">Bookings <span>{{ $appointmentSubmissions->total() }}</span></button>
    </div>

    @if($activeTab === 'contact-page')
    <form wire:submit="saveContactPage" class="sa-card">
        <div class="sa-card-header"><h2>Contact Page Text</h2><p>Controls major headings and helper text.</p></div>
        <div class="form-grid">
            <div class="form-group"><label>Hero Title</label><input type="text" wire:model.live="contact_hero_title"></div>
            <div class="form-group"><label>Hero Highlight</label><input type="text" wire:model.live="contact_hero_highlight"></div>
            <div class="form-group full"><label>Hero Subtitle</label><textarea rows="3" wire:model.live="contact_hero_subtitle"></textarea></div>
            <div class="form-group"><label>Form Title</label><input type="text" wire:model.live="contact_form_title"></div>
            <div class="form-group"><label>Branch Title</label><input type="text" wire:model.live="contact_branch_title"></div>
            <div class="form-group full"><label>Form Subtitle</label><textarea rows="2" wire:model.live="contact_form_subtitle"></textarea></div>
            <div class="form-group full"><label>Branch Subtitle</label><textarea rows="2" wire:model.live="contact_branch_subtitle"></textarea></div>
            <div class="form-group"><label>FAQ Label</label><input type="text" wire:model.live="contact_faq_label"></div>
            <div class="form-group"><label>FAQ Title</label><input type="text" wire:model.live="contact_faq_title"></div>
            <div class="form-group full"><label>FAQ Subtitle</label><textarea rows="2" wire:model.live="contact_faq_subtitle"></textarea></div>
            <div class="form-group"><label>Social Title</label><input type="text" wire:model.live="contact_social_title"></div>
            <div class="form-group full"><label>Social Subtitle</label><textarea rows="2" wire:model.live="contact_social_subtitle"></textarea></div>
        </div>
        <div class="sa-actions"><button class="btn-save">Save Contact Page</button></div>
    </form>
    @endif

    @if($activeTab === 'branches')
    <div class="sa-grid-two">
        <form wire:submit="saveBranch" class="sa-card">
            <div class="sa-card-header">
                <h2>{{ $branchId ? 'Edit Branch Office' : 'Add Branch Office' }}</h2>
                <p>Head office details are managed from Site Settings. Add other offices here.</p>
            </div>
            <div class="form-grid">
                <div class="form-group"><label>Branch Name *</label><input type="text" wire:model.live="branch_name" placeholder="Kathmandu Branch"></div>
                <div class="form-group"><label>Location Label</label><input type="text" wire:model.live="branch_location_label" placeholder="Kathmandu, Nepal"></div>
                <div class="form-group full"><label>Address</label><textarea rows="3" wire:model.live="branch_address"></textarea></div>
                <div class="form-group"><label>Phone</label><input type="text" wire:model.live="branch_phone" placeholder="01-XXXXXXX | 9841XXXXXX"></div>
                <div class="form-group"><label>Email</label><input type="email" wire:model.live="branch_email" placeholder="branch@hasuedu.com"></div>
                <div class="form-group"><label>Weekday Hours</label><input type="text" wire:model.live="branch_weekday_hours" placeholder="Sun-Fri 9AM-5PM"></div>
                <div class="form-group"><label>Saturday Hours</label><input type="text" wire:model.live="branch_saturday_hours" placeholder="Sat 10AM-2PM"></div>
                <div class="form-group"><label>Sort Order</label><input type="number" min="0" wire:model.live="branch_sort_order"></div>
                <div class="form-group"><label>Map Link URL</label><input type="url" wire:model.live="branch_map_link_url" placeholder="https://maps.app.goo.gl/..."></div>
                <div class="form-group full"><label>Map Embed URL or Iframe</label><textarea rows="3" wire:model.live="branch_map_embed_url" placeholder="Paste Google Maps embed URL or iframe code"></textarea></div>
                <div class="form-group full checkbox-row">
                    <label><input type="checkbox" wire:model.live="branch_is_active"> Active on contact page</label>
                </div>
            </div>
            <div class="sa-actions">
                @if($branchId)
                    <button type="button" class="btn-preview" wire:click="resetBranchForm">Cancel Edit</button>
                @endif
                <button class="btn-save">{{ $branchId ? 'Update Branch' : 'Save Branch' }}</button>
            </div>
        </form>

        <div class="sa-list compact-list">
            @forelse($branches as $branch)
                <div class="sa-row {{ $branch->is_active ? '' : 'muted-row' }}">
                    <div class="sa-row-body">
                        <strong>{{ $branch->name }}</strong>
                        <p>{{ $branch->location_label ?: $branch->address ?: 'No address added' }}</p>
                        <small>{{ $branch->phone ?: 'No phone' }} | {{ $branch->email ?: 'No email' }}</small>
                    </div>
                    <div class="sa-row-actions">
                        <button wire:click="editBranch({{ $branch->id }})" class="btn-toggle on">Edit</button>
                        <button wire:click="toggleBranchActive({{ $branch->id }})" class="btn-toggle {{ $branch->is_active ? 'on' : 'off' }}">{{ $branch->is_active ? 'Active' : 'Hidden' }}</button>
                        <button wire:click="deleteBranch({{ $branch->id }})" wire:confirm="Delete this branch office?" class="btn-toggle off">Delete</button>
                    </div>
                </div>
            @empty
                <div class="sa-empty"><strong>No branch offices yet.</strong><p>Add a branch office to show it beside the head office on the contact page.</p></div>
            @endforelse
        </div>
    </div>
    @endif

    @if($activeTab === 'faqs')
        <div class="sa-card contact-faq-panel">
            <div class="sa-card-header contact-faq-header">
                <div>
                    <h2>Contact Page FAQs</h2>
                    <p>Questions displayed in the Frequently Asked Questions section.</p>
                </div>
                <button type="button" class="btn-save contact-faq-add" wire:click="addFaq">Add FAQ</button>
            </div>

            @if($showFaqForm)
                <form wire:submit="saveFaq" class="contact-faq-form">
                    <div class="form-grid no-pad">
                        <div class="form-group full"><label>Question *</label><input type="text" wire:model.live="faq_question"></div>
                        <div class="form-group full"><label>Answer *</label><textarea rows="4" wire:model.live="faq_answer"></textarea></div>
                        <div class="form-group"><label>Sort Order</label><input type="number" min="0" wire:model.live="faq_sort_order"></div>
                        <div class="form-group checkbox-row"><label><input type="checkbox" wire:model.live="faq_is_active"> Active on contact page</label></div>
                    </div>
                    <div class="sa-actions">
                        <button type="button" class="btn-preview" wire:click="resetFaqForm">Cancel</button>
                        <button class="btn-save">{{ $faqId ? 'Update FAQ' : 'Save FAQ' }}</button>
                    </div>
                </form>
            @endif

            <div class="contact-faq-table-wrap">
                <table class="contact-faq-table">
                    <thead>
                        <tr>
                            <th style="width:70px">Order</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th style="width:100px">Status</th>
                            <th style="width:190px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faqs as $faq)
                            <tr class="{{ $faq->is_active ? '' : 'muted-row' }}">
                                <td>{{ $faq->sort_order }}</td>
                                <td><strong>{{ $faq->question }}</strong></td>
                                <td>{{ \Illuminate\Support\Str::limit($faq->answer, 120) }}</td>
                                <td><span class="faq-status {{ $faq->is_active ? 'active' : 'hidden' }}">{{ $faq->is_active ? 'Active' : 'Hidden' }}</span></td>
                                <td>
                                    <div class="contact-faq-actions">
                                        <button wire:click="editFaq({{ $faq->id }})" class="faq-action edit">Edit</button>
                                        <button wire:click="toggleFaqActive({{ $faq->id }})" class="faq-action {{ $faq->is_active ? 'hide' : 'show' }}">{{ $faq->is_active ? 'Hide' : 'Show' }}</button>
                                        <button wire:click="deleteFaq({{ $faq->id }})" wire:confirm="Delete this FAQ?" class="faq-action delete">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="contact-faq-empty">No FAQs yet. Click Add FAQ to create the first one.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if($activeTab === 'appointment-page')
    <form wire:submit="saveAppointmentPage" class="sa-card">
        <div class="sa-card-header"><h2>Booking Page Text</h2><p>Controls major headings and helper text.</p></div>
        <div class="form-grid">
            <div class="form-group"><label>Hero Title</label><input type="text" wire:model.live="appointment_hero_title"></div>
            <div class="form-group"><label>Hero Highlight</label><input type="text" wire:model.live="appointment_hero_highlight"></div>
            <div class="form-group full"><label>Hero Subtitle</label><textarea rows="3" wire:model.live="appointment_hero_subtitle"></textarea></div>
            <div class="form-group"><label>Form Title</label><input type="text" wire:model.live="appointment_form_title"></div>
            <div class="form-group full"><label>Form Subtitle</label><textarea rows="2" wire:model.live="appointment_form_subtitle"></textarea></div>
            <div class="form-group"><label>FAQ Label</label><input type="text" wire:model.live="appointment_faq_label"></div>
            <div class="form-group"><label>FAQ Title</label><input type="text" wire:model.live="appointment_faq_title"></div>
            <div class="form-group full"><label>FAQ Subtitle</label><textarea rows="2" wire:model.live="appointment_faq_subtitle"></textarea></div>
            <div class="form-group"><label>CTA Title</label><input type="text" wire:model.live="appointment_cta_title"></div>
            <div class="form-group full"><label>CTA Subtitle</label><textarea rows="2" wire:model.live="appointment_cta_subtitle"></textarea></div>
        </div>
        <div class="sa-actions"><button class="btn-save">Save Booking Page</button></div>
    </form>
    @endif

    @if($activeTab === 'contacts')
        <div class="sa-list">
        @forelse($contactSubmissions as $item)
            <div class="sa-row {{ $item->is_read ? '' : 'unread' }}">
                <div class="sa-row-body">
                    <strong>{{ $item->first_name }} {{ $item->last_name }} - {{ $item->email }}</strong>
                    <p>{{ $item->phone ?: 'No phone' }} | {{ $item->destination ?: 'No destination' }} | {{ $item->service ?: 'No service' }}</p>
                    <small>{{ $item->created_at->format('M d, Y h:i A') }}</small>
                    <div class="submission-message">{{ $item->message }}</div>
                </div>
                <div class="sa-row-actions">
                    <button wire:click="toggleContactRead({{ $item->id }})" class="btn-toggle {{ $item->is_read ? 'on' : 'off' }}">{{ $item->is_read ? 'Read' : 'Unread' }}</button>
                </div>
            </div>
        @empty
            <div class="sa-empty"><strong>No contact submissions yet.</strong></div>
        @endforelse
        </div>
        <div class="sa-pagination">{{ $contactSubmissions->links() }}</div>
    @endif

    @if($activeTab === 'appointments')
        <div class="sa-list">
        @forelse($appointmentSubmissions as $item)
            <div class="sa-row {{ $item->is_read ? '' : 'unread' }}">
                <div class="sa-row-body">
                    <strong>{{ $item->reference }} - {{ $item->first_name }} {{ $item->last_name }}</strong>
                    <p>{{ $item->branch }} | {{ $item->appointment_date?->format('M d, Y') }} at {{ $item->appointment_time }}</p>
                    <small>{{ $item->email }} | {{ $item->phone }} | {{ $item->service ?: 'No service' }}</small>
                    @if($item->notes)<div class="submission-message">{{ $item->notes }}</div>@endif
                </div>
                <div class="sa-row-actions">
                    <button wire:click="toggleAppointmentRead({{ $item->id }})" class="btn-toggle {{ $item->is_read ? 'on' : 'off' }}">{{ $item->is_read ? 'Read' : 'Unread' }}</button>
                </div>
            </div>
        @empty
            <div class="sa-empty"><strong>No appointment bookings yet.</strong></div>
        @endforelse
        </div>
        <div class="sa-pagination">{{ $appointmentSubmissions->links() }}</div>
    @endif
</div>

@include('livewire.admin.course-manager-styles')
<style>
.submission-message{margin-top:10px;padding:10px 12px;border-radius:8px;background:#f8fafc;color:#334155;font-size:13px;line-height:1.5}
.sa-row.unread{border-color:var(--blue);box-shadow:0 4px 18px rgba(41,82,227,.12)}
.sa-grid-two{display:grid;grid-template-columns:minmax(0,1fr) minmax(320px,.85fr);gap:24px;align-items:start}
.compact-list{margin:0}
.muted-row{opacity:.68}
.checkbox-row label{display:flex;align-items:center;gap:10px;font-weight:600;color:#334155}
.checkbox-row input{width:16px;height:16px}
.contact-faq-panel{overflow:hidden}
.contact-faq-header{display:flex!important;align-items:center;justify-content:space-between;gap:18px;padding:22px 26px!important}
.contact-faq-header h2{font-size:20px!important;margin-bottom:5px!important}
.contact-faq-header p{font-size:14px!important;line-height:1.5}
.contact-faq-add{min-width:110px;white-space:nowrap}
.contact-faq-form{margin:22px 26px 6px;padding:20px;border:1px solid #dbe4f0;border-radius:10px;background:#f8fafc}
.contact-faq-table-wrap{margin:22px 26px 26px;border:1px solid #e2e8f0;border-radius:10px;overflow-x:auto;background:#fff}
.contact-faq-table{width:100%;min-width:860px;border-collapse:separate;border-spacing:0;font-size:14px;line-height:1.45}
.contact-faq-table th,.contact-faq-table td{padding:16px 18px;text-align:left;vertical-align:top;border-bottom:1px solid #e2e8f0;color:#334155}
.contact-faq-table th{background:#f8fafc;color:#0f172a;font-weight:800;font-size:13px;text-transform:uppercase;letter-spacing:.03em}
.contact-faq-table tbody tr:last-child td{border-bottom:none}
.contact-faq-table tbody tr:hover{background:#fbfdff}
.contact-faq-table td:nth-child(2){min-width:230px}
.contact-faq-table td:nth-child(3){min-width:280px;color:#475569}
.faq-status{display:inline-flex;align-items:center;border-radius:999px;padding:5px 10px;font-size:12px;font-weight:800}
.faq-status.active{background:#dcfce7;color:#166534}
.faq-status.hidden{background:#f1f5f9;color:#64748b}
.contact-faq-actions{display:flex;align-items:center;gap:8px;flex-wrap:nowrap}
.faq-action{border:none;border-radius:7px;padding:8px 11px;font-size:12px;font-weight:800;line-height:1;cursor:pointer;white-space:nowrap}
.faq-action.edit{background:#e8edfd;color:#2952e3}
.faq-action.hide,.faq-action.show{background:#dcfce7;color:#166534}
.faq-action.delete{background:#fee2e2;color:#991b1b}
.contact-faq-empty{padding:34px!important;text-align:center;color:#64748b}
@media(max-width:720px){
    .contact-faq-header{align-items:flex-start;flex-direction:column}
    .contact-faq-add{width:100%}
    .contact-faq-form,.contact-faq-table-wrap{margin-left:16px;margin-right:16px}
}
@media(max-width:1100px){.sa-grid-two{grid-template-columns:1fr}}
</style>
