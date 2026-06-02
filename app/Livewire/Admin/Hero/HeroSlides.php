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
    public string $badge_ja          = '';
    public string $title_line1       = '';
    public string $title_line1_ja    = '';
    public string $title_line2       = '';
    public string $title_line2_ja    = '';
    public string $title_highlight   = '';
    public string $title_highlight_ja = '';
    public string $title_line3       = '';
    public string $title_line3_ja    = '';
    public string $description       = '';
    public string $description_ja    = '';
    public string $btn_primary_label = '';
    public string $btn_primary_label_ja = '';
    public string $btn_primary_href  = '';
    public string $btn_ghost_label   = '';
    public string $btn_ghost_label_ja = '';
    public string $btn_ghost_href    = '';
    public string $image_url         = '';   // external URL fallback
    public $image_upload             = null; // UploadedFile
    public ?string $image_current    = null; // existing stored path
    public string $image_alt         = '';
    public string $image_alt_ja      = '';
    public string $plane_emoji       = '✈️';
    public bool   $is_active         = true;

    // Features — array of {icon, label}
    public array $features = [
        ['icon' => '', 'label' => ''],
        ['icon' => '', 'label' => ''],
        ['icon' => '', 'label' => ''],
        ['icon' => '', 'label' => ''],
    ];

    public array $features_ja = [
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
            'badge_ja'            => 'nullable|string|max:120',
            'title_line1'         => 'required|string|max:100',
            'title_line1_ja'      => 'nullable|string|max:100',
            'title_line2'         => 'nullable|string|max:100',
            'title_line2_ja'      => 'nullable|string|max:100',
            'title_highlight'     => 'nullable|string|max:60',
            'title_highlight_ja'  => 'nullable|string|max:60',
            'title_line3'         => 'nullable|string|max:100',
            'title_line3_ja'      => 'nullable|string|max:100',
            'description'         => 'nullable|string|max:300',
            'description_ja'      => 'nullable|string|max:300',
            'btn_primary_label'   => 'nullable|string|max:60',
            'btn_primary_label_ja' => 'nullable|string|max:60',
            'btn_primary_href'    => 'nullable|string|max:200',
            'btn_ghost_label'     => 'nullable|string|max:60',
            'btn_ghost_label_ja'  => 'nullable|string|max:60',
            'btn_ghost_href'      => 'nullable|string|max:200',
            'image_url'           => 'nullable|url|max:500',
            'image_upload'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'image_alt'           => 'nullable|string|max:150',
            'image_alt_ja'        => 'nullable|string|max:150',
            'plane_emoji'         => 'nullable|string|max:10',
            'is_active'           => 'boolean',
            'features'            => 'array',
            'features.*.icon'     => 'nullable|string|max:10',
            'features.*.label'    => 'nullable|string|max:60',
            'features_ja'         => 'array',
            'features_ja.*.icon'  => 'nullable|string|max:10',
            'features_ja.*.label' => 'nullable|string|max:60',
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
        $this->badge_ja          = $slide->badge_ja ?? '';
        $this->title_line1       = $slide->title_line1 ?? '';
        $this->title_line1_ja    = $slide->title_line1_ja ?? '';
        $this->title_line2       = $slide->title_line2 ?? '';
        $this->title_line2_ja    = $slide->title_line2_ja ?? '';
        $this->title_highlight   = $slide->title_highlight ?? '';
        $this->title_highlight_ja = $slide->title_highlight_ja ?? '';
        $this->title_line3       = $slide->title_line3 ?? '';
        $this->title_line3_ja    = $slide->title_line3_ja ?? '';
        $this->description       = $slide->description ?? '';
        $this->description_ja    = $slide->description_ja ?? '';
        $this->btn_primary_label = $slide->btn_primary_label ?? '';
        $this->btn_primary_label_ja = $slide->btn_primary_label_ja ?? '';
        $this->btn_primary_href  = $slide->btn_primary_href ?? '';
        $this->btn_ghost_label   = $slide->btn_ghost_label ?? '';
        $this->btn_ghost_label_ja = $slide->btn_ghost_label_ja ?? '';
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

        $this->image_alt      = $slide->image_alt ?? '';
        $this->image_alt_ja   = $slide->image_alt_ja ?? '';

        // Features — ensure 4 rows minimum
        $feats = is_array($slide->features) ? $slide->features : [];
        while (count($feats) < 4) {
            $feats[] = ['icon' => '', 'label' => ''];
        }
        $this->features = array_slice($feats, 0, 4);

        $featsJa = is_array($slide->features_ja) ? $slide->features_ja : [];
        while (count($featsJa) < 4) {
            $featsJa[] = ['icon' => '', 'label' => ''];
        }
        $this->features_ja = array_slice($featsJa, 0, 4);

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
            'badge_ja'          => $this->badge_ja ?: null,
            'title_line1'       => $this->title_line1,
            'title_line1_ja'    => $this->title_line1_ja ?: null,
            'title_line2'       => $this->title_line2,
            'title_line2_ja'    => $this->title_line2_ja ?: null,
            'title_highlight'   => $this->title_highlight,
            'title_highlight_ja' => $this->title_highlight_ja ?: null,
            'title_line3'       => $this->title_line3,
            'title_line3_ja'    => $this->title_line3_ja ?: null,
            'description'       => $this->description,
            'description_ja'    => $this->description_ja ?: null,
            'btn_primary_label' => $this->btn_primary_label,
            'btn_primary_label_ja' => $this->btn_primary_label_ja ?: null,
            'btn_primary_href'  => $this->btn_primary_href,
            'btn_ghost_label'   => $this->btn_ghost_label,
            'btn_ghost_label_ja' => $this->btn_ghost_label_ja ?: null,
            'btn_ghost_href'    => $this->btn_ghost_href,
            'image_alt'         => $this->image_alt ?: null,
            'image_alt_ja'      => $this->image_alt_ja ?: null,
            'plane_emoji'       => $this->plane_emoji,
            'is_active'         => $this->is_active,
            'features_ja'       => array_values(array_filter($this->features_ja, fn ($f) => ! empty($f['label']))),
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
        $this->features_ja[] = ['icon' => '', 'label' => ''];
    }

    public function removeFeature(int $index): void
    {
        array_splice($this->features, $index, 1);
        array_splice($this->features_ja, $index, 1);
    }

    // ── Helpers ───────────────────────────────────────────────────────────
    private function resetForm(): void
    {
        $this->reset([
            'editingId', 'badge', 'badge_ja', 'title_line1', 'title_line1_ja',
            'title_line2', 'title_line2_ja', 'title_highlight', 'title_highlight_ja',
            'title_line3', 'title_line3_ja', 'description', 'description_ja',
            'btn_primary_label', 'btn_primary_label_ja', 'btn_primary_href',
            'btn_ghost_label', 'btn_ghost_label_ja', 'btn_ghost_href', 'image_url', 'image_upload',
            'image_current', 'image_alt', 'image_alt_ja', 'plane_emoji', 'is_active',
        ]);
        $this->plane_emoji = '✈️';
        $this->is_active   = true;
        $this->features    = [
            ['icon' => '', 'label' => ''],
            ['icon' => '', 'label' => ''],
            ['icon' => '', 'label' => ''],
            ['icon' => '', 'label' => ''],
        ];
        $this->features_ja = [
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
