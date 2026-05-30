<?php

namespace App\Livewire\Admin;

use App\Models\GalleryImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Gallery extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';
    public string $filterCategory = '';
    public string $filterActive = '';
    public int $perPage = 12;

    public bool $showModal = false;
    public bool $isEdit = false;
    public ?int $editingId = null;

    public string $title = '';
    public string $category = 'classes';
    public string $media_type = 'image';
    public string $link_url = '';
    public string $alt_text = '';
    public int $sort_order = 0;
    public bool $is_active = true;
    public bool $removePhoto = false;

    public $photo;
    public ?string $existingPhoto = null;

    public ?int $confirmingDeleteId = null;
    public ?int $confirmingRestoreId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'filterActive' => ['except' => ''],
        'perPage' => ['except' => 12],
    ];

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:60'],
            'media_type' => ['required', 'in:image,youtube,facebook'],
            'link_url' => ['nullable', 'required_unless:media_type,image', 'url', 'max:2048'],
            'alt_text' => ['nullable', 'string', 'max:180'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'photo' => [$this->isEdit ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterCategory(): void
    {
        $this->resetPage();
    }

    public function updatingFilterActive(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $this->resetForm();
        $image = GalleryImage::withTrashed()->findOrFail($id);

        $this->isEdit = true;
        $this->editingId = $image->id;
        $this->title = $image->title;
        $this->category = $image->category;
        $this->media_type = $image->media_type ?? 'image';
        $this->link_url = $image->link_url ?? '';
        $this->alt_text = $image->alt_text ?? '';
        $this->sort_order = $image->sort_order;
        $this->is_active = $image->is_active;
        $this->existingPhoto = $image->image_path;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'category' => Str::slug($this->category),
            'media_type' => $this->media_type,
            'link_url' => $this->media_type === 'image' ? null : $this->link_url,
            'alt_text' => $this->alt_text ?: null,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ];

        if ($this->photo) {
            $this->deletePhoto($this->existingPhoto);
            $data['image_path'] = $this->photo->store('gallery', 'public');
        } elseif ($this->removePhoto && $this->isEdit) {
            $this->deletePhoto($this->existingPhoto);
            $data['image_path'] = null;
        }

        if ($this->isEdit) {
            GalleryImage::withTrashed()->findOrFail($this->editingId)->update($data);
            $message = 'Gallery item updated successfully.';
        } else {
            GalleryImage::create($data);
            $message = 'Gallery item added successfully.';
        }

        $this->closeModal();
        session()->flash('success', $message);
    }

    public function toggleActive(int $id): void
    {
        $image = GalleryImage::withTrashed()->findOrFail($id);
        $image->update(['is_active' => ! $image->is_active]);
    }

    public function confirmDelete(int $id): void
    {
        $this->confirmingDeleteId = $id;
    }

    public function cancelDelete(): void
    {
        $this->confirmingDeleteId = null;
    }

    public function delete(): void
    {
        if (! $this->confirmingDeleteId) {
            return;
        }

        GalleryImage::findOrFail($this->confirmingDeleteId)->delete();
        $this->confirmingDeleteId = null;
        session()->flash('success', 'Gallery item moved to trash.');
    }

    public function confirmRestore(int $id): void
    {
        $this->confirmingRestoreId = $id;
    }

    public function cancelRestore(): void
    {
        $this->confirmingRestoreId = null;
    }

    public function restore(): void
    {
        if (! $this->confirmingRestoreId) {
            return;
        }

        GalleryImage::withTrashed()->findOrFail($this->confirmingRestoreId)->restore();
        $this->confirmingRestoreId = null;
        session()->flash('success', 'Gallery item restored.');
    }

    private function resetForm(): void
    {
        $this->resetValidation();
        $this->editingId = null;
        $this->title = '';
        $this->category = 'classes';
        $this->media_type = 'image';
        $this->link_url = '';
        $this->alt_text = '';
        $this->sort_order = (GalleryImage::max('sort_order') ?? 0) + 1;
        $this->is_active = true;
        $this->removePhoto = false;
        $this->existingPhoto = null;
        $this->photo = null;
    }

    private function deletePhoto(?string $path): void
    {
        if ($path && ! Str::startsWith($path, ['http://', 'https://']) && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function render()
    {
        $images = GalleryImage::withTrashed()
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('category', 'like', '%' . $this->search . '%')
                    ->orWhere('media_type', 'like', '%' . $this->search . '%')
                    ->orWhere('link_url', 'like', '%' . $this->search . '%')
                    ->orWhere('alt_text', 'like', '%' . $this->search . '%');
            }))
            ->when($this->filterCategory, fn ($q) => $q->where('category', $this->filterCategory))
            ->when($this->filterActive === 'active', fn ($q) => $q->whereNull('deleted_at')->where('is_active', true))
            ->when($this->filterActive === 'inactive', fn ($q) => $q->whereNull('deleted_at')->where('is_active', false))
            ->when($this->filterActive === 'trashed', fn ($q) => $q->onlyTrashed())
            ->ordered()
            ->paginate($this->perPage);

        return view('livewire.admin.gallery', [
            'images' => $images,
            'categories' => GalleryImage::query()
                ->select('category')
                ->distinct()
                ->orderBy('category')
                ->pluck('category'),
            'showModal' => $this->showModal,
            'isEdit' => $this->isEdit,
            'media_type' => $this->media_type,
            'photo' => $this->photo,
            'existingPhoto' => $this->existingPhoto,
            'confirmingDeleteId' => $this->confirmingDeleteId,
            'confirmingRestoreId' => $this->confirmingRestoreId,
        ])->layout('admin.layouts.app', ['title' => 'Gallery']);
    }
}
