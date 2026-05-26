<?php

namespace App\Livewire\Admin\Home;

use App\Services\HomeAboutService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('admin.layouts.app')]
#[Title('Home – About Section')]
class HomeAbout extends Component
{
    use WithFileUploads;

    // ── Image ─────────────────────────────────────────────────────────────
    public ?string $image_current = null;

    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:3072')]
    public $image_upload = null;

    #[Validate('nullable|string|max:150')]
    public string $image_alt = '';

    // ── Badge ─────────────────────────────────────────────────────────────
    #[Validate('nullable|string|max:20')]
    public string $badge_number = '';

    #[Validate('nullable|string|max:80')]
    public string $badge_label = '';

    // ── Text ──────────────────────────────────────────────────────────────
    #[Validate('required|string|max:100')]
    public string $section_label = '';

    #[Validate('required|string|max:200')]
    public string $section_title = '';

    #[Validate('nullable|string|max:1500')]
    public string $paragraph_1 = '';

    #[Validate('nullable|string|max:1500')]
    public string $paragraph_2 = '';

    // ── Badges (icon chips) ───────────────────────────────────────────────
    public array $badges = [
        ['icon' => '', 'label' => ''],
        ['icon' => '', 'label' => ''],
    ];

    // ── Perks list ────────────────────────────────────────────────────────
    public array $perks = ['', '', ''];

    // ── CTA ───────────────────────────────────────────────────────────────
    #[Validate('nullable|string|max:80')]
    public string $cta_label = '';

    #[Validate('nullable|string|max:255')]
    public string $cta_href = '';

    // ── Mount ─────────────────────────────────────────────────────────────
    public function mount(HomeAboutService $service): void
    {
        $r = $service->get();
        if (! $r) return;

        $this->image_current = $r->image_path;
        $this->image_alt     = $r->image_alt     ?? '';
        $this->badge_number  = $r->badge_number  ?? '';
        $this->badge_label   = $r->badge_label   ?? '';
        $this->section_label = $r->section_label ?? '';
        $this->section_title = $r->section_title ?? '';
        $this->paragraph_1   = $r->paragraph_1   ?? '';
        $this->paragraph_2   = $r->paragraph_2   ?? '';
        $this->cta_label     = $r->cta_label     ?? '';
        $this->cta_href      = $r->cta_href      ?? '';

        // Badges — ensure minimum 2 rows
        $b = is_array($r->badges) ? $r->badges : [];
        while (count($b) < 2) $b[] = ['icon' => '', 'label' => ''];
        $this->badges = $b;

        // Perks — ensure minimum 3 rows
        $p = is_array($r->perks) ? $r->perks : [];
        while (count($p) < 3) $p[] = '';
        $this->perks = $p;
    }

    // ── Badge row helpers ─────────────────────────────────────────────────
    public function addBadge(): void
    {
        $this->badges[] = ['icon' => '', 'label' => ''];
    }

    public function removeBadge(int $i): void
    {
        array_splice($this->badges, $i, 1);
        if (empty($this->badges)) $this->badges = [['icon' => '', 'label' => '']];
    }

    // ── Perk row helpers ──────────────────────────────────────────────────
    public function addPerk(): void
    {
        $this->perks[] = '';
    }

    public function removePerk(int $i): void
    {
        array_splice($this->perks, $i, 1);
        if (empty($this->perks)) $this->perks = [''];
    }

    // ── Save ──────────────────────────────────────────────────────────────
    public function save(HomeAboutService $service): void
    {
        $this->validate([
            'image_upload'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'image_alt'     => 'nullable|string|max:150',
            'badge_number'  => 'nullable|string|max:20',
            'badge_label'   => 'nullable|string|max:80',
            'section_label' => 'required|string|max:100',
            'section_title' => 'required|string|max:200',
            'paragraph_1'   => 'nullable|string|max:1500',
            'paragraph_2'   => 'nullable|string|max:1500',
            'cta_label'     => 'nullable|string|max:80',
            'cta_href'      => 'nullable|string|max:255',
        ]);

        $saved = $service->save([
            'image_alt'     => $this->image_alt,
            'badge_number'  => $this->badge_number,
            'badge_label'   => $this->badge_label,
            'section_label' => $this->section_label,
            'section_title' => $this->section_title,
            'paragraph_1'   => $this->paragraph_1,
            'paragraph_2'   => $this->paragraph_2,
            'badges'        => $this->badges,
            'perks'         => $this->perks,
            'cta_label'     => $this->cta_label,
            'cta_href'      => $this->cta_href,
        ], $this->image_upload);

        $this->image_current = $saved->imageUrl();
        $this->image_upload  = null;
        $this->resetErrorBag();
        session()->flash('success', 'About section saved successfully.');
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.home.home-about');
    }
}