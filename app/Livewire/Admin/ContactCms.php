<?php

namespace App\Livewire\Admin;

use App\Models\AppointmentPage;
use App\Models\AppointmentSubmission;
use App\Models\BranchOffice;
use App\Models\ContactFaq;
use App\Models\ContactPage;
use App\Models\ContactSubmission;
use Livewire\Component;
use Livewire\WithPagination;

class ContactCms extends Component
{
    use WithPagination;

    public string $activeTab = 'contact-page';

    public string $contact_hero_title = '';
    public string $contact_hero_highlight = '';
    public string $contact_hero_subtitle = '';
    public string $contact_form_title = '';
    public string $contact_form_subtitle = '';
    public string $contact_branch_title = '';
    public string $contact_branch_subtitle = '';
    public string $contact_faq_label = '';
    public string $contact_faq_title = '';
    public string $contact_faq_subtitle = '';
    public string $contact_social_title = '';
    public string $contact_social_subtitle = '';

    public string $appointment_hero_title = '';
    public string $appointment_hero_highlight = '';
    public string $appointment_hero_subtitle = '';
    public string $appointment_form_title = '';
    public string $appointment_form_subtitle = '';
    public string $appointment_faq_label = '';
    public string $appointment_faq_title = '';
    public string $appointment_faq_subtitle = '';
    public string $appointment_cta_title = '';
    public string $appointment_cta_subtitle = '';

    public ?int $branchId = null;
    public string $branch_name = '';
    public string $branch_location_label = '';
    public string $branch_address = '';
    public string $branch_phone = '';
    public string $branch_email = '';
    public string $branch_weekday_hours = '';
    public string $branch_saturday_hours = '';
    public string $branch_map_embed_url = '';
    public string $branch_map_link_url = '';
    public int $branch_sort_order = 0;
    public bool $branch_is_active = true;

    public bool $showFaqForm = false;
    public ?int $faqId = null;
    public string $faq_question = '';
    public string $faq_answer = '';
    public int $faq_sort_order = 0;
    public bool $faq_is_active = true;

    public function mount(): void
    {
        $contact = ContactPage::first();
        $this->contact_hero_title = $contact?->hero_title ?? 'Get In Touch With HASU';
        $this->contact_hero_highlight = $contact?->hero_highlight ?? 'Touch';
        $this->contact_hero_subtitle = $contact?->hero_subtitle ?? 'Have questions about studying abroad, visa processing, or our courses? Our counselors are ready to guide you anytime.';
        $this->contact_form_title = $contact?->form_title ?? 'Send Us a Message';
        $this->contact_form_subtitle = $contact?->form_subtitle ?? 'Fill out the form below and our team will get back to you within 24 hours.';
        $this->contact_branch_title = $contact?->branch_title ?? 'Our Office Locations';
        $this->contact_branch_subtitle = $contact?->branch_subtitle ?? 'We have multiple branches across Nepal. Click on a branch to see its exact location on the map.';
        $this->contact_faq_label = $contact?->faq_label ?? 'Quick Answers';
        $this->contact_faq_title = $contact?->faq_title ?? 'Frequently Asked Questions';
        $this->contact_faq_subtitle = $contact?->faq_subtitle ?? 'Common questions from students and parents before reaching out to us.';
        $this->contact_social_title = $contact?->social_title ?? 'Connect With Us on Social Media';
        $this->contact_social_subtitle = $contact?->social_subtitle ?? 'Stay updated with news, events, scholarship alerts, student success stories, and study abroad tips.';

        $appointment = AppointmentPage::first();
        $this->appointment_hero_title = $appointment?->hero_title ?? 'Book Your Free Consultation';
        $this->appointment_hero_highlight = $appointment?->hero_highlight ?? 'Free';
        $this->appointment_hero_subtitle = $appointment?->hero_subtitle ?? 'Schedule a visit at your nearest HASU branch. Our expert counselors will guide you on universities, visas, and the best study abroad pathway for you.';
        $this->appointment_form_title = $appointment?->form_title ?? 'Schedule Your Visit';
        $this->appointment_form_subtitle = $appointment?->form_subtitle ?? 'Complete the steps below to book your in-person consultation at any HASU branch.';
        $this->appointment_faq_label = $appointment?->faq_label ?? 'Quick Answers';
        $this->appointment_faq_title = $appointment?->faq_title ?? 'Frequently Asked Questions';
        $this->appointment_faq_subtitle = $appointment?->faq_subtitle ?? 'Common questions about in-person consultations at HASU.';
        $this->appointment_cta_title = $appointment?->cta_title ?? 'Have Questions Before Booking?';
        $this->appointment_cta_subtitle = $appointment?->cta_subtitle ?? 'Our team is available on call, email, and WhatsApp to answer any questions before your visit.';
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function saveContactPage(): void
    {
        $this->validate([
            'contact_hero_title' => ['required', 'string', 'max:180'],
            'contact_hero_highlight' => ['nullable', 'string', 'max:80'],
            'contact_hero_subtitle' => ['nullable', 'string', 'max:600'],
            'contact_form_title' => ['nullable', 'string', 'max:160'],
            'contact_form_subtitle' => ['nullable', 'string', 'max:400'],
            'contact_branch_title' => ['nullable', 'string', 'max:160'],
            'contact_branch_subtitle' => ['nullable', 'string', 'max:400'],
            'contact_faq_label' => ['nullable', 'string', 'max:80'],
            'contact_faq_title' => ['nullable', 'string', 'max:160'],
            'contact_faq_subtitle' => ['nullable', 'string', 'max:400'],
            'contact_social_title' => ['nullable', 'string', 'max:160'],
            'contact_social_subtitle' => ['nullable', 'string', 'max:500'],
        ]);

        ContactPage::updateOrCreate(['id' => 1], [
            'hero_title' => $this->contact_hero_title,
            'hero_highlight' => $this->contact_hero_highlight,
            'hero_subtitle' => $this->contact_hero_subtitle,
            'form_title' => $this->contact_form_title,
            'form_subtitle' => $this->contact_form_subtitle,
            'branch_title' => $this->contact_branch_title,
            'branch_subtitle' => $this->contact_branch_subtitle,
            'faq_label' => $this->contact_faq_label,
            'faq_title' => $this->contact_faq_title,
            'faq_subtitle' => $this->contact_faq_subtitle,
            'social_title' => $this->contact_social_title,
            'social_subtitle' => $this->contact_social_subtitle,
        ]);

        session()->flash('success', 'Contact page saved.');
    }

    public function saveAppointmentPage(): void
    {
        $this->validate([
            'appointment_hero_title' => ['required', 'string', 'max:180'],
            'appointment_hero_highlight' => ['nullable', 'string', 'max:80'],
            'appointment_hero_subtitle' => ['nullable', 'string', 'max:600'],
            'appointment_form_title' => ['nullable', 'string', 'max:160'],
            'appointment_form_subtitle' => ['nullable', 'string', 'max:400'],
            'appointment_faq_label' => ['nullable', 'string', 'max:80'],
            'appointment_faq_title' => ['nullable', 'string', 'max:160'],
            'appointment_faq_subtitle' => ['nullable', 'string', 'max:400'],
            'appointment_cta_title' => ['nullable', 'string', 'max:160'],
            'appointment_cta_subtitle' => ['nullable', 'string', 'max:500'],
        ]);

        AppointmentPage::updateOrCreate(['id' => 1], [
            'hero_title' => $this->appointment_hero_title,
            'hero_highlight' => $this->appointment_hero_highlight,
            'hero_subtitle' => $this->appointment_hero_subtitle,
            'form_title' => $this->appointment_form_title,
            'form_subtitle' => $this->appointment_form_subtitle,
            'faq_label' => $this->appointment_faq_label,
            'faq_title' => $this->appointment_faq_title,
            'faq_subtitle' => $this->appointment_faq_subtitle,
            'cta_title' => $this->appointment_cta_title,
            'cta_subtitle' => $this->appointment_cta_subtitle,
        ]);

        session()->flash('success', 'Appointment page saved.');
    }

    public function toggleContactRead(int $id): void
    {
        $submission = ContactSubmission::findOrFail($id);
        $submission->update(['is_read' => ! $submission->is_read]);
    }

    public function toggleAppointmentRead(int $id): void
    {
        $submission = AppointmentSubmission::findOrFail($id);
        $submission->update(['is_read' => ! $submission->is_read]);
    }

    public function saveBranch(): void
    {
        $data = $this->validate([
            'branch_name' => ['required', 'string', 'max:160'],
            'branch_location_label' => ['nullable', 'string', 'max:160'],
            'branch_address' => ['nullable', 'string', 'max:800'],
            'branch_phone' => ['nullable', 'string', 'max:120'],
            'branch_email' => ['nullable', 'email', 'max:160'],
            'branch_weekday_hours' => ['nullable', 'string', 'max:120'],
            'branch_saturday_hours' => ['nullable', 'string', 'max:120'],
            'branch_map_embed_url' => ['nullable', 'string', 'max:2000'],
            'branch_map_link_url' => ['nullable', 'url', 'max:500'],
            'branch_sort_order' => ['integer', 'min:0', 'max:9999'],
            'branch_is_active' => ['boolean'],
        ]);

        BranchOffice::updateOrCreate(
            ['id' => $this->branchId],
            [
                'name' => $data['branch_name'],
                'location_label' => $data['branch_location_label'],
                'address' => $data['branch_address'],
                'phone' => $data['branch_phone'],
                'email' => $data['branch_email'],
                'weekday_hours' => $data['branch_weekday_hours'],
                'saturday_hours' => $data['branch_saturday_hours'],
                'map_embed_url' => $data['branch_map_embed_url'],
                'map_link_url' => $data['branch_map_link_url'],
                'sort_order' => $data['branch_sort_order'],
                'is_active' => $data['branch_is_active'],
            ]
        );

        $this->resetBranchForm();
        session()->flash('success', 'Branch office saved.');
    }

    public function editBranch(int $id): void
    {
        $branch = BranchOffice::findOrFail($id);

        $this->branchId = $branch->id;
        $this->branch_name = $branch->name;
        $this->branch_location_label = $branch->location_label ?? '';
        $this->branch_address = $branch->address ?? '';
        $this->branch_phone = $branch->phone ?? '';
        $this->branch_email = $branch->email ?? '';
        $this->branch_weekday_hours = $branch->weekday_hours ?? '';
        $this->branch_saturday_hours = $branch->saturday_hours ?? '';
        $this->branch_map_embed_url = $branch->map_embed_url ?? '';
        $this->branch_map_link_url = $branch->map_link_url ?? '';
        $this->branch_sort_order = $branch->sort_order;
        $this->branch_is_active = $branch->is_active;
        $this->activeTab = 'branches';
    }

    public function toggleBranchActive(int $id): void
    {
        $branch = BranchOffice::findOrFail($id);
        $branch->update(['is_active' => ! $branch->is_active]);
    }

    public function deleteBranch(int $id): void
    {
        BranchOffice::findOrFail($id)->delete();
        $this->resetBranchForm();
        session()->flash('success', 'Branch office deleted.');
    }

    public function resetBranchForm(): void
    {
        $this->branchId = null;
        $this->branch_name = '';
        $this->branch_location_label = '';
        $this->branch_address = '';
        $this->branch_phone = '';
        $this->branch_email = '';
        $this->branch_weekday_hours = '';
        $this->branch_saturday_hours = '';
        $this->branch_map_embed_url = '';
        $this->branch_map_link_url = '';
        $this->branch_sort_order = 0;
        $this->branch_is_active = true;
    }

    public function addFaq(): void
    {
        $this->resetFaqForm();
        $this->showFaqForm = true;
        $this->activeTab = 'faqs';
    }

    public function saveFaq(): void
    {
        $data = $this->validate([
            'faq_question' => ['required', 'string', 'max:255'],
            'faq_answer' => ['required', 'string', 'max:1200'],
            'faq_sort_order' => ['integer', 'min:0', 'max:9999'],
            'faq_is_active' => ['boolean'],
        ]);

        ContactFaq::updateOrCreate(
            ['id' => $this->faqId],
            [
                'question' => $data['faq_question'],
                'answer' => $data['faq_answer'],
                'sort_order' => $data['faq_sort_order'],
                'is_active' => $data['faq_is_active'],
            ]
        );

        $this->resetFaqForm();
        session()->flash('success', 'Contact FAQ saved.');
    }

    public function editFaq(int $id): void
    {
        $faq = ContactFaq::findOrFail($id);

        $this->faqId = $faq->id;
        $this->faq_question = $faq->question;
        $this->faq_answer = $faq->answer;
        $this->faq_sort_order = $faq->sort_order;
        $this->faq_is_active = $faq->is_active;
        $this->showFaqForm = true;
        $this->activeTab = 'faqs';
    }

    public function toggleFaqActive(int $id): void
    {
        $faq = ContactFaq::findOrFail($id);
        $faq->update(['is_active' => ! $faq->is_active]);
    }

    public function deleteFaq(int $id): void
    {
        ContactFaq::findOrFail($id)->delete();
        $this->resetFaqForm();
        session()->flash('success', 'Contact FAQ deleted.');
    }

    public function resetFaqForm(): void
    {
        $this->faqId = null;
        $this->faq_question = '';
        $this->faq_answer = '';
        $this->faq_sort_order = 0;
        $this->faq_is_active = true;
        $this->showFaqForm = false;
    }

    public function render()
    {
        return view('livewire.admin.contact-cms', [
            'contactSubmissions' => ContactSubmission::latest()->paginate(10, ['*'], 'contactPage'),
            'appointmentSubmissions' => AppointmentSubmission::latest()->paginate(10, ['*'], 'appointmentPage'),
            'branches' => BranchOffice::ordered()->get(),
            'faqs' => ContactFaq::ordered()->get(),
        ])->layout('admin.layouts.app', ['title' => 'Contact & Appointments']);
    }
}
