<?php

namespace App\Livewire\Admin\Settings;

use App\Services\SettingService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('admin.layouts.app')]
#[Title('Site Settings – HASU Admin')]
class SiteSettings extends Component
{
    use WithFileUploads;

    // ── Active tab ───────────────────────────────────────────────────────
    public string $activeTab = 'general';

    // ── General ──────────────────────────────────────────────────────────
    public string $general_site_name    = '';
    public string $general_tagline      = '';
    public string $general_established  = '';
    public string $general_copyright    = '';
    public $general_logo                = null;   // UploadedFile | null
    public $general_favicon             = null;
    public ?string $general_logo_current    = null;  // existing stored path
    public ?string $general_favicon_current = null;

    // ── Contact ──────────────────────────────────────────────────────────
    public string $contact_phone_primary   = '';
    public string $contact_phone_secondary = '';
    public string $contact_phone_landline  = '';
    public string $contact_email_primary   = '';
    public string $contact_email_secondary = '';
    public string $contact_address         = '';
    public string $contact_map_embed       = '';

    // ── Social ───────────────────────────────────────────────────────────
    public string $social_facebook  = '';
    public string $social_instagram = '';
    public string $social_youtube   = '';
    public string $social_tiktok    = '';
    public string $social_linkedin  = '';
    public string $social_twitter   = '';
    public string $social_whatsapp  = '';

    // ── SEO ──────────────────────────────────────────────────────────────
    public string $seo_meta_title       = '';
    public string $seo_meta_description = '';
    public string $seo_meta_keywords    = '';
    public string $seo_google_analytics = '';
    public string $seo_google_tag       = '';
    public $seo_og_image                = null;
    public ?string $seo_og_image_current = null;

    // ── Validation rules ─────────────────────────────────────────────────
    protected function rules(): array
    {
        return [
            // General
            'general_site_name'   => 'required|string|max:150',
            'general_tagline'     => 'nullable|string|max:200',
            'general_established' => 'nullable|string|max:10',
            'general_copyright'   => 'nullable|string|max:255',
            'general_logo'        => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'general_favicon'     => 'nullable|image|mimes:png,ico,jpg|max:512',

            // Contact
            'contact_phone_primary'   => 'nullable|string|max:30',
            'contact_phone_secondary' => 'nullable|string|max:30',
            'contact_phone_landline'  => 'nullable|string|max:30',
            'contact_email_primary'   => 'nullable|email|max:150',
            'contact_email_secondary' => 'nullable|email|max:150',
            'contact_address'         => 'nullable|string|max:500',
            'contact_map_embed'       => 'nullable|string|max:2000',

            // Social
            'social_facebook'  => 'nullable|url|max:255',
            'social_instagram'  => 'nullable|url|max:255',
            'social_youtube'   => 'nullable|url|max:255',
            'social_tiktok'    => 'nullable|url|max:255',
            'social_linkedin'  => 'nullable|url|max:255',
            'social_twitter'   => 'nullable|url|max:255',
            'social_whatsapp'  => 'nullable|string|max:20',

            // SEO
            'seo_meta_title'       => 'nullable|string|max:160',
            'seo_meta_description' => 'nullable|string|max:320',
            'seo_meta_keywords'    => 'nullable|string|max:500',
            'seo_google_analytics' => 'nullable|string|max:50',
            'seo_google_tag'       => 'nullable|string|max:50',
            'seo_og_image'         => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ];
    }

    // ── Mount ─────────────────────────────────────────────────────────────
    public function mount(SettingService $settingService): void
    {
        $all = array_merge(
            $settingService->getGroupValues('general'),
            $settingService->getGroupValues('contact'),
            $settingService->getGroupValues('social'),
            $settingService->getGroupValues('seo'),
        );

        foreach ($all as $key => $value) {
            // Image fields — store as "*_current" for display; keep the upload property null
            if (in_array($key, ['general_logo', 'general_favicon', 'seo_og_image'])) {
                $this->{$key . '_current'} = $value;
                continue;
            }

            if (property_exists($this, $key)) {
                $this->$key = $value ?? '';
            }
        }
    }

    // ── Tab switching ─────────────────────────────────────────────────────
    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    // ── Save handlers (one per tab) ───────────────────────────────────────
    public function saveGeneral(SettingService $settingService): void
    {
        $this->validateOnly([
            'general_site_name', 'general_tagline', 'general_established',
            'general_copyright', 'general_logo', 'general_favicon',
        ]);

        $data = [
            'general_site_name'   => $this->general_site_name,
            'general_tagline'     => $this->general_tagline,
            'general_established' => $this->general_established,
            'general_copyright'   => $this->general_copyright,
        ];

        $files = array_filter([
            'general_logo'    => $this->general_logo,
            'general_favicon' => $this->general_favicon,
        ]);

        $settingService->saveGroup('general', $data, $files);

        // Refresh current image paths after save
        $saved = $settingService->getGroupValues('general');
        $this->general_logo_current    = $saved['general_logo']    ?? null;
        $this->general_favicon_current = $saved['general_favicon'] ?? null;
        $this->general_logo    = null;
        $this->general_favicon = null;

        $this->dispatch('saved');
        session()->flash('success', 'General settings saved successfully.');
    }

    public function saveContact(SettingService $settingService): void
    {
        $this->validateOnly([
            'contact_phone_primary', 'contact_phone_secondary', 'contact_phone_landline',
            'contact_email_primary', 'contact_email_secondary',
            'contact_address', 'contact_map_embed',
        ]);

        $settingService->saveGroup('contact', [
            'contact_phone_primary'   => $this->contact_phone_primary,
            'contact_phone_secondary' => $this->contact_phone_secondary,
            'contact_phone_landline'  => $this->contact_phone_landline,
            'contact_email_primary'   => $this->contact_email_primary,
            'contact_email_secondary' => $this->contact_email_secondary,
            'contact_address'         => $this->contact_address,
            'contact_map_embed'       => $this->contact_map_embed,
        ]);

        $this->dispatch('saved');
        session()->flash('success', 'Contact settings saved successfully.');
    }

    public function saveSocial(SettingService $settingService): void
    {
        $this->validateOnly([
            'social_facebook', 'social_instagram', 'social_youtube',
            'social_tiktok', 'social_linkedin', 'social_twitter', 'social_whatsapp',
        ]);

        $settingService->saveGroup('social', [
            'social_facebook'  => $this->social_facebook,
            'social_instagram'  => $this->social_instagram,
            'social_youtube'   => $this->social_youtube,
            'social_tiktok'    => $this->social_tiktok,
            'social_linkedin'  => $this->social_linkedin,
            'social_twitter'   => $this->social_twitter,
            'social_whatsapp'  => $this->social_whatsapp,
        ]);

        $this->dispatch('saved');
        session()->flash('success', 'Social media settings saved successfully.');
    }

    public function saveSeo(SettingService $settingService): void
    {
        $this->validateOnly([
            'seo_meta_title', 'seo_meta_description', 'seo_meta_keywords',
            'seo_google_analytics', 'seo_google_tag', 'seo_og_image',
        ]);

        $data = [
            'seo_meta_title'       => $this->seo_meta_title,
            'seo_meta_description' => $this->seo_meta_description,
            'seo_meta_keywords'    => $this->seo_meta_keywords,
            'seo_google_analytics' => $this->seo_google_analytics,
            'seo_google_tag'       => $this->seo_google_tag,
        ];

        $files = array_filter([
            'seo_og_image' => $this->seo_og_image,
        ]);

        $settingService->saveGroup('seo', $data, $files);

        $saved = $settingService->getGroupValues('seo');
        $this->seo_og_image_current = $saved['seo_og_image'] ?? null;
        $this->seo_og_image = null;

        $this->dispatch('saved');
        session()->flash('success', 'SEO settings saved successfully.');
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.settings.site-settings');
    }
}