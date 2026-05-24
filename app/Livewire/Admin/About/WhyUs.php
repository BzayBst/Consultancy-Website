<?php

namespace App\Livewire\Admin\About;

use App\Services\WhyUsService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('admin.layouts.app')]
#[Title('Why Choose Us – HASU Admin')]
class WhyUs extends Component
{
    use WithFileUploads;

    // ── Active tab ────────────────────────────────────────────────────────
    public string $activeTab = 'section';

    // ── Section fields ────────────────────────────────────────────────────
    #[Validate('required|string|max:100')]
    public string $section_label = '';

    #[Validate('required|string|max:200')]
    public string $title = '';

    #[Validate('nullable|string|max:500')]
    public string $description = '';

    #[Validate('nullable|string|max:150')]
    public string $image_alt = '';

    #[Validate('nullable|string|max:20')]
    public string $badge_number = '';

    #[Validate('nullable|string|max:80')]
    public string $badge_label = '';

    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:3072')]
    public $image_upload = null;

    public ?string $image_current = null;

    // ── Features list ─────────────────────────────────────────────────────
    public array $features          = [];
    public bool  $showFeatureModal  = false;
    public bool  $showDeleteModal   = false;
    public ?int  $editingFeatureId  = null;
    public ?int  $deletingFeatureId = null;

    // ── Feature form fields — prefixed to avoid collision with section fields
    #[Validate('required|string|max:10')]
    public string $f_icon = '';

    #[Validate('required|string|max:100')]
    public string $f_title = '';

    #[Validate('nullable|string|max:400')]
    public string $f_desc = '';

    // ── Mount ─────────────────────────────────────────────────────────────
    public function mount(WhyUsService $service): void
    {
        $this->loadSection($service);
        $this->features = $service->getFeatures()->toArray();
    }

    private function loadSection(WhyUsService $service): void
    {
        $s = $service->getSection();
        $this->section_label = $s?->section_label ?? 'Why Choose HASU';
        $this->title         = $s?->title         ?? 'Reasons Students Trust Us';
        $this->description   = $s?->description   ?? '';
        $this->image_alt     = $s?->image_alt     ?? '';
        $this->badge_number  = $s?->badge_number  ?? '98%';
        $this->badge_label   = $s?->badge_label   ?? 'Visa Success Rate';
        $this->image_current = $s?->image_path    ?? null;
    }

    // ── Tab ───────────────────────────────────────────────────────────────
    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    // ── Save section ──────────────────────────────────────────────────────
    public function saveSection(WhyUsService $service): void
    {
        // Validate only the section fields — call validateOnly once per field
        $this->validate([
            'section_label' => 'required|string|max:100',
            'title'         => 'required|string|max:200',
            'description'   => 'nullable|string|max:500',
            'image_alt'     => 'nullable|string|max:150',
            'badge_number'  => 'nullable|string|max:20',
            'badge_label'   => 'nullable|string|max:80',
            'image_upload'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $saved = $service->saveSection([
            'section_label' => $this->section_label,
            'title'         => $this->title,
            'description'   => $this->description,
            'image_alt'     => $this->image_alt,
            'badge_number'  => $this->badge_number,
            'badge_label'   => $this->badge_label,
        ], $this->image_upload);

        $this->image_current = $saved->image_path;
        $this->image_upload  = null;
        $this->resetErrorBag();
        session()->flash('success', 'Section settings saved.');
    }

    // ── Feature CRUD ──────────────────────────────────────────────────────
    public function openCreateFeature(): void
    {
        $this->resetFeatureForm();
        $this->editingFeatureId = null;
        $this->showFeatureModal = true;
    }

    public function openEditFeature(int $id, WhyUsService $service): void
    {
        $this->resetFeatureForm();
        $f = $service->findFeature($id);
        $this->editingFeatureId = $id;
        $this->f_icon  = $f->icon;
        $this->f_title = $f->title;
        $this->f_desc  = $f->description ?? '';
        $this->showFeatureModal = true;
    }

    public function saveFeature(WhyUsService $service): void
    {
        // Validate only feature fields explicitly
        $this->validate([
            'f_icon'  => 'required|string|max:10',
            'f_title' => 'required|string|max:100',
            'f_desc'  => 'nullable|string|max:400',
        ]);

        $data = [
            'icon'        => $this->f_icon,
            'title'       => $this->f_title,
            'description' => $this->f_desc,
        ];

        $wasEditing = $this->editingFeatureId;

        if ($wasEditing) {
            $service->updateFeature($wasEditing, $data);
        } else {
            $service->createFeature($data);
        }

        $this->features        = $service->getFeatures()->toArray();
        $this->showFeatureModal = false;
        $this->resetFeatureForm();

        session()->flash('success', $wasEditing ? 'Feature updated.' : 'Feature created.');
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingFeatureId = $id;
        $this->showDeleteModal   = true;
    }

    public function deleteFeature(WhyUsService $service): void
    {
        if ($this->deletingFeatureId) {
            $service->deleteFeature($this->deletingFeatureId);
            $this->features          = $service->getFeatures()->toArray();
            $this->showDeleteModal   = false;
            $this->deletingFeatureId = null;
            session()->flash('success', 'Feature deleted.');
        }
    }

    public function toggleFeature(int $id, WhyUsService $service): void
    {
        $service->toggleFeature($id);
        $this->features = $service->getFeatures()->toArray();
    }

    public function reorderFeatures(array $ids, WhyUsService $service): void
    {
        $service->reorderFeatures($ids);
        $this->features = $service->getFeatures()->toArray();
    }

    private function resetFeatureForm(): void
    {
        $this->f_icon  = '';
        $this->f_title = '';
        $this->f_desc  = '';
        $this->editingFeatureId = null;
        $this->resetErrorBag(); // Livewire 3 — clears all validation errors
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.about.why-us');
    }
}