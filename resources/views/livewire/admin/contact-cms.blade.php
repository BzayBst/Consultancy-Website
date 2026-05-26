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
</style>
