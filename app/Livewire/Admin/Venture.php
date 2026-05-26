<?php

namespace App\Livewire\Admin;

use App\Models\Venture as VentureModel;
use App\Services\VentureService;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('admin.layouts.app')]
#[Title('Ventures – HASU Admin')]
class Venture extends Component
{
    use WithFileUploads, WithPagination;

    /* ── Filters ── */
    public string $search = '';

    public string $filterCategory = '';

    public string $filterStatus = '';

    public string $filterActive = '';

    public int $perPage = 10;

    /* ── Modal ── */
    public bool $showModal = false;

    public bool $isEdit = false;

    public ?int $editingId = null;

    /* ── Form fields ── */
    public string $name = '';

    public string $slug = '';

    public string $tagline = '';

    public string $category = 'education';

    public string $status = 'active';

    public string $emoji = '🎓';

    public string $banner_gradient = '135deg,#0d1560,#2952e3';

    public string $tag_label = '';

    public string $tag_color = '#2952e3';

    public string $tag_bg = '#e8edfd';

    public string $accent_color = '#2952e3';

    public string $description = '';

    public string $long_description = '';

    public string $highlights_raw = '';

    public string $section_title = 'What We Do';

    public string $location = '';

    public string $established = '';

    public string $email = '';

    public string $phone = '';

    public string $website_url = '';

    public string $primary_btn_label = 'Learn More →';

    public string $primary_btn_url = '';

    public string $secondary_btn_label = 'Contact';

    public string $secondary_btn_url = '';

    public bool $is_featured = false;

    public bool $is_active = true;

    public int $order = 0;

    public bool $removeImage = false;

    public $bannerImage;

    public ?string $existingImage = null;

    /* ── Confirms ── */
    public ?int $confirmingDeleteId = null;

    public ?int $confirmingRestoreId = null;

    /* ── Query string ── */
    protected $queryString = [
        'search' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterActive' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    /* ── Validation ── */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:180'],
            'tagline' => ['nullable', 'string', 'max:200'],
            'category' => ['required', 'in:education,language,business,innovation'],
            'status' => ['required', 'in:flagship,active,new,coming_soon'],
            'emoji' => ['nullable', 'string', 'max:10'],
            'banner_gradient' => ['nullable', 'string', 'max:200'],
            'tag_label' => ['nullable', 'string', 'max:80'],
            'tag_color' => ['nullable', 'string', 'max:20'],
            'tag_bg' => ['nullable', 'string', 'max:20'],
            'accent_color' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:500'],
            'long_description' => ['nullable', 'string'],
            'highlights_raw' => ['nullable', 'string'],
            'section_title' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:150'],
            'established' => ['nullable', 'string', 'max:80'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'website_url' => ['nullable', 'url', 'max:300'],
            'primary_btn_label' => ['nullable', 'string', 'max:60'],
            'primary_btn_url' => ['nullable', 'string', 'max:300'],
            'secondary_btn_label' => ['nullable', 'string', 'max:60'],
            'secondary_btn_url' => ['nullable', 'string', 'max:300'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'order' => ['integer', 'min:0'],
            'bannerImage' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ];
    }

    /* ── Lifecycle ── */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterCategory(): void
    {
        $this->resetPage();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    public function updatingFilterActive(): void
    {
        $this->resetPage();
    }

    public function updatedName(string $value): void
    {
        if (! $this->isEdit) {
            $this->slug = Str::slug($value);
        }
    }

    /* ── Modal ── */
    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function openEdit(int $id, VentureService $service): void
    {
        $this->resetForm();
        $this->isEdit = true;
        $this->editingId = $id;
        $v = $service->find($id);

        $this->name = $v->name;
        $this->slug = $v->slug;
        $this->tagline = $v->tagline ?? '';
        $this->category = $v->category ?? 'education';
        $this->status = $v->status ?? 'active';
        $this->emoji = $v->emoji ?? '🎓';
        $this->banner_gradient = $v->banner_gradient ?? '135deg,#0d1560,#2952e3';
        $this->tag_label = $v->tag_label ?? '';
        $this->tag_color = $v->tag_color ?? '#2952e3';
        $this->tag_bg = $v->tag_bg ?? '#e8edfd';
        $this->accent_color = $v->accent_color ?? '#2952e3';
        $this->description = $v->description ?? '';
        $this->long_description = $v->long_description ?? '';
        $this->highlights_raw = $v->highlights ? implode("\n", $v->highlights) : '';
        $this->section_title = $v->section_title ?? 'What We Do';
        $this->location = $v->location ?? '';
        $this->established = $v->established ?? '';
        $this->email = $v->email ?? '';
        $this->phone = $v->phone ?? '';
        $this->website_url = $v->website_url ?? '';
        $this->primary_btn_label = $v->primary_btn_label ?? 'Learn More →';
        $this->primary_btn_url = $v->primary_btn_url ?? '';
        $this->secondary_btn_label = $v->secondary_btn_label ?? 'Contact';
        $this->secondary_btn_url = $v->secondary_btn_url ?? '';
        $this->is_featured = $v->is_featured;
        $this->is_active = $v->is_active;
        $this->order = $v->order;
        $this->existingImage = $v->banner_image;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    /* ── Save ── */
    public function save(VentureService $service): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => $this->slug ?: null,
            'tagline' => $this->tagline ?: null,
            'category' => $this->category,
            'status' => $this->status,
            'emoji' => $this->emoji ?: '🎓',
            'banner_gradient' => $this->banner_gradient ?: null,
            'tag_label' => $this->tag_label ?: null,
            'tag_color' => $this->tag_color ?: null,
            'tag_bg' => $this->tag_bg ?: null,
            'accent_color' => $this->accent_color ?: '#2952e3',
            'description' => $this->description ?: null,
            'long_description' => $this->long_description ?: null,
            'highlights' => $this->highlights_raw
                ? array_values(array_filter(array_map('trim', explode("\n", $this->highlights_raw))))
                : null,
            'section_title' => $this->section_title ?: 'What We Do',
            'location' => $this->location ?: null,
            'established' => $this->established ?: null,
            'email' => $this->email ?: null,
            'phone' => $this->phone ?: null,
            'website_url' => $this->website_url ?: null,
            'primary_btn_label' => $this->primary_btn_label ?: null,
            'primary_btn_url' => $this->primary_btn_url ?: null,
            'secondary_btn_label' => $this->secondary_btn_label ?: null,
            'secondary_btn_url' => $this->secondary_btn_url ?: null,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
            'order' => $this->order,
        ];

        // Only one featured at a time
        if ($this->is_featured) {
            VentureModel::where('is_featured', true)
                ->when($this->editingId, fn ($q) => $q->where('id', '!=', $this->editingId))
                ->update(['is_featured' => false]);
        }

        $msg = $this->isEdit ? 'Venture updated.' : 'Venture created.';
        $this->isEdit
            ? $service->update($this->editingId, $data, $this->bannerImage ?: null, $this->removeImage)
            : $service->create($data, $this->bannerImage ?: null);

        $this->closeModal();
        $this->dispatch('notify', type: 'success', message: $msg);
    }

    /* ── Toggle ── */
    public function toggleActive(int $id, VentureService $service): void
    {
        $v = $service->find($id);
        $service->update($id, ['is_active' => ! $v->is_active]);
        $this->dispatch('notify', type: 'success', message: 'Status updated.');
    }

    public function toggleFeatured(int $id, VentureService $service): void
    {
        $v = $service->find($id);
        if (! $v->is_featured) {
            VentureModel::where('is_featured', true)->update(['is_featured' => false]);
        }
        $service->update($id, ['is_featured' => ! $v->is_featured]);
        $this->dispatch('notify', type: 'success', message: 'Featured status updated.');
    }

    /* ── Delete ── */
    public function confirmDelete(int $id): void
    {
        $this->confirmingDeleteId = $id;
    }

    public function cancelDelete(): void
    {
        $this->confirmingDeleteId = null;
    }

    public function delete(VentureService $service): void
    {
        if (! $this->confirmingDeleteId) {
            return;
        }
        $service->delete($this->confirmingDeleteId);
        $this->confirmingDeleteId = null;
        $this->dispatch('notify', type: 'success', message: 'Venture moved to trash.');
    }

    /* ── Restore ── */
    public function confirmRestore(int $id): void
    {
        $this->confirmingRestoreId = $id;
    }

    public function cancelRestore(): void
    {
        $this->confirmingRestoreId = null;
    }

    public function restore(VentureService $service): void
    {
        if (! $this->confirmingRestoreId) {
            return;
        }
        $service->restore($this->confirmingRestoreId);
        $this->confirmingRestoreId = null;
        $this->dispatch('notify', type: 'success', message: 'Venture restored.');
    }

    /* ── Reorder ── */
    public function reorder(array $ids, VentureService $service): void
    {
        $service->reorder($ids);
        $this->dispatch('notify', type: 'success', message: 'Order updated.');
    }

    /* ── Reset form ── */
    private function resetForm(): void
    {
        $this->resetValidation();
        $this->editingId = null;
        $this->name = '';
        $this->slug = '';
        $this->tagline = '';
        $this->category = 'education';
        $this->status = 'active';
        $this->emoji = '🎓';
        $this->banner_gradient = '135deg,#0d1560,#2952e3';
        $this->tag_label = '';
        $this->tag_color = '#2952e3';
        $this->tag_bg = '#e8edfd';
        $this->accent_color = '#2952e3';
        $this->description = '';
        $this->long_description = '';
        $this->highlights_raw = '';
        $this->section_title = 'What We Do';
        $this->location = '';
        $this->established = '';
        $this->email = '';
        $this->phone = '';
        $this->website_url = '';
        $this->primary_btn_label = 'Learn More →';
        $this->primary_btn_url = '';
        $this->secondary_btn_label = 'Contact';
        $this->secondary_btn_url = '';
        $this->is_featured = false;
        $this->is_active = true;
        $this->order = 0;
        $this->removeImage = false;
        $this->existingImage = null;
        $this->bannerImage = null;
    }

    public function render(VentureService $service)
    {
        return view('livewire.admin.venture', [
            'ventures' => $service->list($this->perPage, $this->search, $this->filterCategory, $this->filterStatus, $this->filterActive),
        ]);
    }
}
