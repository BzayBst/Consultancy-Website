<?php

namespace App\Livewire\Admin;

use App\Models\AppointmentPage;
use App\Models\AppointmentSubmission;
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

    public function render()
    {
        return view('livewire.admin.contact-cms', [
            'contactSubmissions' => ContactSubmission::latest()->paginate(10, ['*'], 'contactPage'),
            'appointmentSubmissions' => AppointmentSubmission::latest()->paginate(10, ['*'], 'appointmentPage'),
        ])->layout('admin.layouts.app', ['title' => 'Contact & Appointments']);
    }
}
