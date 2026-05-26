<?php

namespace App\Livewire\Admin;

use App\Models\BlogPost;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class BlogPosts extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';
    public string $filterActive = '';
    public int $perPage = 10;

    public bool $showModal = false;
    public bool $isEdit = false;
    public ?int $editingId = null;

    public string $title = '';
    public string $slug = '';
    public string $category = '';
    public string $excerpt = '';
    public string $content = '';
    public string $image_alt = '';
    public string $published_at = '';
    public string $meta_title = '';
    public string $meta_description = '';
    public bool $is_featured = false;
    public bool $is_active = true;
    public int $sort_order = 0;
    public bool $removePhoto = false;

    public $photo;
    public ?string $existingPhoto = null;

    public ?int $confirmingDeleteId = null;
    public ?int $confirmingRestoreId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterActive' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:180'],
            'slug' => [
                'nullable',
                'string',
                'max:200',
                Rule::unique('blog_posts', 'slug')->ignore($this->editingId)->withoutTrashed(),
            ],
            'category' => ['nullable', 'string', 'max:80'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'image_alt' => ['nullable', 'string', 'max:180'],
            'published_at' => ['nullable', 'date'],
            'meta_title' => ['nullable', 'string', 'max:180'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ];
    }

    public function updatedTitle(): void
    {
        if (! $this->isEdit && $this->slug === '') {
            $this->slug = Str::slug($this->title);
        }
    }

    public function updatingSearch(): void
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
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $this->resetForm();
        $post = BlogPost::withTrashed()->findOrFail($id);

        $this->isEdit = true;
        $this->editingId = $post->id;
        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->category = $post->category ?? '';
        $this->excerpt = $post->excerpt ?? '';
        $this->content = $post->content ?? '';
        $this->image_alt = $post->image_alt ?? '';
        $this->published_at = $post->published_at?->format('Y-m-d') ?? '';
        $this->meta_title = $post->meta_title ?? '';
        $this->meta_description = $post->meta_description ?? '';
        $this->is_featured = $post->is_featured;
        $this->is_active = $post->is_active;
        $this->sort_order = $post->sort_order;
        $this->existingPhoto = $post->image_path;
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
            'slug' => $this->slug ?: Str::slug($this->title),
            'category' => $this->category ?: null,
            'excerpt' => $this->excerpt ?: null,
            'content' => $this->content ?: null,
            'image_alt' => $this->image_alt ?: null,
            'published_at' => $this->published_at ?: null,
            'meta_title' => $this->meta_title ?: null,
            'meta_description' => $this->meta_description ?: null,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        if ($this->photo) {
            $this->deletePhoto($this->existingPhoto);
            $data['image_path'] = $this->photo->store('blog', 'public');
        } elseif ($this->removePhoto && $this->isEdit) {
            $this->deletePhoto($this->existingPhoto);
            $data['image_path'] = null;
        }

        if ($this->isEdit) {
            BlogPost::withTrashed()->findOrFail($this->editingId)->update($data);
            $message = 'Blog post updated successfully.';
        } else {
            BlogPost::create($data);
            $message = 'Blog post created successfully.';
        }

        $this->closeModal();
        session()->flash('success', $message);
    }

    public function toggleActive(int $id): void
    {
        $post = BlogPost::withTrashed()->findOrFail($id);
        $post->update(['is_active' => ! $post->is_active]);
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

        BlogPost::findOrFail($this->confirmingDeleteId)->delete();
        $this->confirmingDeleteId = null;
        session()->flash('success', 'Blog post moved to trash.');
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

        BlogPost::withTrashed()->findOrFail($this->confirmingRestoreId)->restore();
        $this->confirmingRestoreId = null;
        session()->flash('success', 'Blog post restored.');
    }

    private function resetForm(): void
    {
        $this->resetValidation();
        $this->isEdit = false;
        $this->editingId = null;
        $this->title = '';
        $this->slug = '';
        $this->category = '';
        $this->excerpt = '';
        $this->content = '';
        $this->image_alt = '';
        $this->published_at = now()->format('Y-m-d');
        $this->meta_title = '';
        $this->meta_description = '';
        $this->is_featured = false;
        $this->is_active = true;
        $this->sort_order = (BlogPost::max('sort_order') ?? 0) + 1;
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
        return view('livewire.admin.blog-posts', [
            'posts' => BlogPost::withTrashed()
                ->when($this->search, fn ($query) => $query->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('category', 'like', '%' . $this->search . '%')
                        ->orWhere('excerpt', 'like', '%' . $this->search . '%');
                }))
                ->when($this->filterActive === 'active', fn ($query) => $query->whereNull('deleted_at')->where('is_active', true))
                ->when($this->filterActive === 'inactive', fn ($query) => $query->whereNull('deleted_at')->where('is_active', false))
                ->when($this->filterActive === 'trashed', fn ($query) => $query->onlyTrashed())
                ->ordered()
                ->paginate($this->perPage),
        ])->layout('admin.layouts.app', ['title' => 'Blog Posts']);
    }
}
