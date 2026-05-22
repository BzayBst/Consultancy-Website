<?php

namespace App\Livewire\Admin\Hero;

use App\Services\HeroSlideService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('admin.layouts.app')]
#[Title('Hero Slides – HASU Admin')]
class HeroSlides extends Component
{
    use WithFileUploads;

    // ── List state ───────────────────────────────────────────────────────
    public $slides = [];

    // ── Modal state ──────────────────────────────────────────────────────
    public bool $showModal    = false;
    public bool $showDeleteModal = false;
    public ?int $editingId    = null;   // null = creating
    public ?int $deletingId   = null;

    // ── Form fields ──────────────────────────────────────────────────────
    public string $badge             = '';
    public string $title_line1       = '';
    public string $title_line2       = '';
    public string $title_highlight   = '';
    public string $title_line3       = '';
    public string $description       = '';
    public string $btn_primary_label = '';
    public string $btn_primary_href  = '';
    public string $btn_ghost_label   = '';
    public string $btn_ghost_href    = '';
    public string $image_url         = '';   // external URL fallback
    public $image_upload             = null; // UploadedFile
    public ?string $image_current    = null; // existing stored path
    public string $plane_emoji       = '✈️';
    public bool   $is_active         = true;

    // Features — array of {icon, label}
    public array $features = [
        ['icon' => '', 'label' => ''],
        ['icon' => '', 'label' => ''],
        ['icon' => '', 'label' => ''],
        ['icon' => '', 'label' => ''],
    ];

    // ── Validation ───────────────────────────────────────────────────────
    protected function rules(): array
    {
        return [
            'badge'               => 'nullable|string|max:120',
            'title_line1'         => 'required|string|max:100',
            'title_line2'         => 'nullable|string|max:100',
            'title_highlight'     => 'nullable|string|max:60',
            'title_line3'         => 'nullable|string|max:100',
            'description'         => 'nullable|string|max:300',
            'btn_primary_label'   => 'nullable|string|max:60',
            'btn_primary_href'    => 'nullable|string|max:200',
            'btn_ghost_label'     => 'nullable|string|max:60',
            'btn_ghost_href'      => 'nullable|string|max:200',
            'image_url'           => 'nullable|url|max:500',
            'image_upload'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'plane_emoji'         => 'nullable|string|max:10',
            'is_active'           => 'boolean',
            'features'            => 'array',
            'features.*.icon'     => 'nullable|string|max:10',
            'features.*.label'    => 'nullable|string|max:60',
        ];
    }

    // ── Mount ─────────────────────────────────────────────────────────────
    public function mount(HeroSlideService $service): void
    {
        $this->slides = $service->all()->toArray();
    }

    // ── Open create modal ─────────────────────────────────────────────────
    public function openCreate(): void
    {
        $this->resetForm();
        $this->editingId = null;
        $this->showModal = true;
    }

    // ── Open edit modal ───────────────────────────────────────────────────
    public function openEdit(int $id, HeroSlideService $service): void
    {
        $this->resetForm();
        $slide = $service->find($id);
        $this->editingId = $id;

        $this->badge             = $slide->badge ?? '';
        $this->title_line1       = $slide->title_line1 ?? '';
        $this->title_line2       = $slide->title_line2 ?? '';
        $this->title_highlight   = $slide->title_highlight ?? '';
        $this->title_line3       = $slide->title_line3 ?? '';
        $this->description       = $slide->description ?? '';
        $this->btn_primary_label = $slide->btn_primary_label ?? '';
        $this->btn_primary_href  = $slide->btn_primary_href ?? '';
        $this->btn_ghost_label   = $slide->btn_ghost_label ?? '';
        $this->btn_ghost_href    = $slide->btn_ghost_href ?? '';
        $this->plane_emoji       = $slide->plane_emoji ?? '✈️';
        $this->is_active         = $slide->is_active;

        // Image — distinguish between stored file vs external URL
        $ip = $slide->image_path ?? '';
        if (str_starts_with($ip, 'http')) {
            $this->image_url     = $ip;
            $this->image_current = null;
        } else {
            $this->image_current = $ip ?: null;
            $this->image_url     = '';
        }

        // Features — ensure 4 rows minimum
        $feats = is_array($slide->features) ? $slide->features : [];
        while (count($feats) < 4) {
            $feats[] = ['icon' => '', 'label' => ''];
        }
        $this->features = array_slice($feats, 0, 4);

        $this->showModal = true;
    }

    // ── Save (create or update) ───────────────────────────────────────────
    public function save(HeroSlideService $service): void
    {
        $this->validate();

        // Resolve image — upload takes priority over URL
        $imagePath = null;
        $imageFile = $this->image_upload;

        if (! $imageFile && $this->image_url) {
            // Use external URL directly as image_path
            $imagePath = $this->image_url;
        }

        $data = [
            'badge'             => $this->badge,
            'title_line1'       => $this->title_line1,
            'title_line2'       => $this->title_line2,
            'title_highlight'   => $this->title_highlight,
            'title_line3'       => $this->title_line3,
            'description'       => $this->description,
            'btn_primary_label' => $this->btn_primary_label,
            'btn_primary_href'  => $this->btn_primary_href,
            'btn_ghost_label'   => $this->btn_ghost_label,
            'btn_ghost_href'    => $this->btn_ghost_href,
            'plane_emoji'       => $this->plane_emoji,
            'is_active'         => $this->is_active,
        ];

        // Only set image_path from URL if no file upload
        if ($imagePath && ! $imageFile) {
            $data['image_path'] = $imagePath;
        }

        if ($this->editingId) {
            $service->update($this->editingId, $data, $imageFile, $this->features);
        } else {
            $service->create($data, $imageFile, $this->features);
        }

        $this->slides    = $service->all()->toArray();
        $this->showModal = false;
        $this->resetForm();
        session()->flash('success', $this->editingId ? 'Slide updated.' : 'Slide created.');
    }

    // ── Confirm delete ────────────────────────────────────────────────────
    public function confirmDelete(int $id): void
    {
        $this->deletingId      = $id;
        $this->showDeleteModal = true;
    }

    public function delete(HeroSlideService $service): void
    {
        if ($this->deletingId) {
            $service->delete($this->deletingId);
            $this->slides          = $service->all()->toArray();
            $this->deletingId      = null;
            $this->showDeleteModal = false;
            session()->flash('success', 'Slide deleted.');
        }
    }

    // ── Toggle active ─────────────────────────────────────────────────────
    public function toggleActive(int $id, HeroSlideService $service): void
    {
        $service->toggleActive($id);
        $this->slides = $service->all()->toArray();
    }

    // ── Reorder (called from JS SortableJS dragend) ───────────────────────
    public function reorder(array $orderedIds, HeroSlideService $service): void
    {
        $service->reorder($orderedIds);
        $this->slides = $service->all()->toArray();
    }

    // ── Feature row helpers ───────────────────────────────────────────────
    public function addFeature(): void
    {
        $this->features[] = ['icon' => '', 'label' => ''];
    }

    public function removeFeature(int $index): void
    {
        array_splice($this->features, $index, 1);
    }

    // ── Helpers ───────────────────────────────────────────────────────────
    private function resetForm(): void
    {
        $this->reset([
            'editingId', 'badge', 'title_line1', 'title_line2', 'title_highlight',
            'title_line3', 'description', 'btn_primary_label', 'btn_primary_href',
            'btn_ghost_label', 'btn_ghost_href', 'image_url', 'image_upload',
            'image_current', 'plane_emoji', 'is_active',
        ]);
        $this->plane_emoji = '✈️';
        $this->is_active   = true;
        $this->features    = [
            ['icon' => '', 'label' => ''],
            ['icon' => '', 'label' => ''],
            ['icon' => '', 'label' => ''],
            ['icon' => '', 'label' => ''],
        ];
        $this->resetValidation();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.hero.hero-slides');
    }
}