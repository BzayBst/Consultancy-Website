<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use App\Models\CoursePage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CourseManager extends Component
{
    use WithFileUploads, WithPagination;

    public string $activeTab = 'page';
    public string $courseTab = 'listing';

    public string $hero_badge = '';
    public string $hero_title = '';
    public string $hero_highlight = '';
    public string $hero_subtitle = '';
    public string $intro_label = '';
    public string $intro_title = '';
    public string $intro_subtitle = '';
    public array $stats = [];
    public string $catalog_label = '';
    public string $catalog_title = '';
    public string $why_label = '';
    public string $why_title = '';
    public string $why_description = '';
    public array $why_items = [];
    public string $cta_title = '';
    public string $cta_subtitle = '';
    public string $cta_button_label = '';
    public string $cta_button_url = '';
    public string $cta_phone_label = '';
    public string $cta_phone_url = '';

    public string $search = '';
    public string $filterActive = '';
    public int $perPage = 10;

    public bool $showModal = false;
    public bool $isEdit = false;
    public ?int $editingId = null;
    public ?int $confirmingDeleteId = null;
    public ?int $confirmingRestoreId = null;

    public string $title = '';
    public string $slug = '';
    public string $category = 'language';
    public string $badge = '';
    public string $tag = '';
    public string $excerpt = '';
    public bool $is_featured = false;
    public string $overview = '';
    public array $description = [];
    public array $meta_items = [];
    public array $highlights = [];
    public string $sidebar_title = '';
    public string $sidebar_subtitle = '';
    public array $sidebar_items = [];
    public int $sort_order = 0;
    public bool $is_active = true;

    public $image_upload;
    public ?string $image_current = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterActive' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function mount(): void
    {
        $page = CoursePage::first();

        $this->hero_badge = $page?->hero_badge ?? 'HASU Language Institute';
        $this->hero_title = $page?->hero_title ?? 'Language & Test Prep';
        $this->hero_highlight = $page?->hero_highlight ?? 'Courses';
        $this->hero_subtitle = $page?->hero_subtitle ?? 'Internationally recognized language training and exam preparation taught by certified experts at our institute.';
        $this->intro_label = $page?->intro_label ?? 'What We Teach';
        $this->intro_title = $page?->intro_title ?? 'Prepare for Your Future Abroad';
        $this->intro_subtitle = $page?->intro_subtitle ?? 'From Japanese language mastery to IELTS and PTE band targets, HASU offers structured programs with mock tests, small batches, and personalized coaching.';
        $this->stats = $this->normalizeRows($page?->stats ?? $this->defaultStats(), ['number', 'accent', 'label']);
        $this->catalog_label = $page?->catalog_label ?? 'Browse All';
        $this->catalog_title = $page?->catalog_title ?? 'Our Course Catalog';
        $this->why_label = $page?->why_label ?? 'Why HASU';
        $this->why_title = $page?->why_title ?? 'Why Students Choose Our Courses';
        $this->why_description = $page?->why_description ?? 'HASU Language Institute combines certified trainers, proven curricula, and integration with our study-abroad consultancy.';
        $this->why_items = $this->normalizeRows($page?->why_items ?? $this->defaultWhyItems(), ['icon', 'title', 'description']);
        $this->cta_title = $page?->cta_title ?? 'Not Sure Which Course Is Right for You?';
        $this->cta_subtitle = $page?->cta_subtitle ?? 'Visit our campus or book a free assessment. We will recommend the best program for your goals.';
        $this->cta_button_label = $page?->cta_button_label ?? 'Apply Now';
        $this->cta_button_url = $page?->cta_button_url ?? route('contact');
        $this->cta_phone_label = $page?->cta_phone_label ?? 'Call Us Today';
        $this->cta_phone_url = $page?->cta_phone_url ?? 'tel:+97756493528';
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function setCourseTab(string $tab): void
    {
        $this->courseTab = $tab;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterActive(): void
    {
        $this->resetPage();
    }

    public function savePage(): void
    {
        $this->validate([
            'hero_badge' => ['nullable', 'string', 'max:120'],
            'hero_title' => ['required', 'string', 'max:160'],
            'hero_highlight' => ['nullable', 'string', 'max:80'],
            'hero_subtitle' => ['nullable', 'string', 'max:500'],
            'intro_label' => ['nullable', 'string', 'max:80'],
            'intro_title' => ['nullable', 'string', 'max:160'],
            'intro_subtitle' => ['nullable', 'string', 'max:500'],
            'stats.*.number' => ['nullable', 'string', 'max:20'],
            'stats.*.accent' => ['nullable', 'string', 'max:10'],
            'stats.*.label' => ['nullable', 'string', 'max:80'],
            'catalog_label' => ['nullable', 'string', 'max:80'],
            'catalog_title' => ['nullable', 'string', 'max:160'],
            'why_label' => ['nullable', 'string', 'max:80'],
            'why_title' => ['nullable', 'string', 'max:160'],
            'why_description' => ['nullable', 'string', 'max:700'],
            'why_items.*.icon' => ['nullable', 'string', 'max:20'],
            'why_items.*.title' => ['nullable', 'string', 'max:100'],
            'why_items.*.description' => ['nullable', 'string', 'max:300'],
            'cta_title' => ['nullable', 'string', 'max:160'],
            'cta_subtitle' => ['nullable', 'string', 'max:500'],
            'cta_button_label' => ['nullable', 'string', 'max:80'],
            'cta_button_url' => ['nullable', 'string', 'max:255'],
            'cta_phone_label' => ['nullable', 'string', 'max:80'],
            'cta_phone_url' => ['nullable', 'string', 'max:255'],
        ]);

        CoursePage::updateOrCreate(['id' => 1], [
            'hero_badge' => $this->hero_badge,
            'hero_title' => $this->hero_title,
            'hero_highlight' => $this->hero_highlight,
            'hero_subtitle' => $this->hero_subtitle,
            'intro_label' => $this->intro_label,
            'intro_title' => $this->intro_title,
            'intro_subtitle' => $this->intro_subtitle,
            'stats' => $this->cleanRows($this->stats),
            'catalog_label' => $this->catalog_label,
            'catalog_title' => $this->catalog_title,
            'why_label' => $this->why_label,
            'why_title' => $this->why_title,
            'why_description' => $this->why_description,
            'why_items' => $this->cleanRows($this->why_items),
            'cta_title' => $this->cta_title,
            'cta_subtitle' => $this->cta_subtitle,
            'cta_button_label' => $this->cta_button_label,
            'cta_button_url' => $this->cta_button_url,
            'cta_phone_label' => $this->cta_phone_label,
            'cta_phone_url' => $this->cta_phone_url,
        ]);

        session()->flash('success', 'Course page settings saved.');
    }

    public function addStat(): void
    {
        $this->stats[] = ['number' => '', 'accent' => '+', 'label' => ''];
    }

    public function removeStat(int $index): void
    {
        unset($this->stats[$index]);
        $this->stats = array_values($this->stats);
    }

    public function addWhyItem(): void
    {
        $this->why_items[] = ['icon' => '', 'title' => '', 'description' => ''];
    }

    public function removeWhyItem(int $index): void
    {
        unset($this->why_items[$index]);
        $this->why_items = array_values($this->why_items);
    }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->showModal = true;
        $this->activeTab = 'courses';
    }

    public function openEdit(int $id): void
    {
        $this->resetForm();
        $course = Course::withTrashed()->findOrFail($id);

        $this->isEdit = true;
        $this->editingId = $course->id;
        $this->title = $course->title;
        $this->slug = $course->slug;
        $this->category = $course->category ?? 'language';
        $this->badge = $course->badge ?? '';
        $this->tag = $course->tag ?? '';
        $this->excerpt = $course->excerpt ?? '';
        $this->image_current = $course->image_path;
        $this->is_featured = $course->is_featured;
        $this->overview = $course->overview ?? '';
        $this->description = $this->normalizeRows($course->description ?? [], ['body']);
        $this->meta_items = $this->normalizeRows($course->meta_items ?? [], ['label']);
        $this->highlights = $this->normalizeRows($course->highlights ?? [], ['item']);
        $this->sidebar_title = $course->sidebar_title ?? '';
        $this->sidebar_subtitle = $course->sidebar_subtitle ?? '';
        $this->sidebar_items = $this->normalizeRows($course->sidebar_items ?? [], ['label', 'value']);
        $this->sort_order = $course->sort_order;
        $this->is_active = $course->is_active;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function saveCourse(): void
    {
        $this->validate([
            'title' => ['required', 'string', 'max:160'],
            'slug' => ['nullable', 'string', 'max:180'],
            'category' => ['required', 'string', 'max:80'],
            'badge' => ['nullable', 'string', 'max:80'],
            'tag' => ['nullable', 'string', 'max:120'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'is_featured' => ['boolean'],
            'overview' => ['nullable', 'string', 'max:2000'],
            'description.*.body' => ['nullable', 'string', 'max:1200'],
            'meta_items.*.label' => ['nullable', 'string', 'max:100'],
            'highlights.*.item' => ['nullable', 'string', 'max:200'],
            'sidebar_title' => ['nullable', 'string', 'max:120'],
            'sidebar_subtitle' => ['nullable', 'string', 'max:400'],
            'sidebar_items.*.label' => ['nullable', 'string', 'max:80'],
            'sidebar_items.*.value' => ['nullable', 'string', 'max:120'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $slug = Str::slug($this->slug ?: $this->title);
        $query = Course::withTrashed()->where('slug', $slug);
        if ($this->isEdit) {
            $query->where('id', '!=', $this->editingId);
        }
        if ($query->exists()) {
            $this->addError('slug', 'This slug is already in use.');
            return;
        }

        $data = [
            'title' => $this->title,
            'slug' => $slug,
            'category' => $this->category,
            'badge' => $this->badge ?: null,
            'tag' => $this->tag ?: null,
            'excerpt' => $this->excerpt ?: null,
            'is_featured' => $this->is_featured,
            'overview' => $this->overview ?: null,
            'description' => $this->cleanRows($this->description),
            'meta_items' => $this->cleanRows($this->meta_items),
            'highlights' => $this->cleanRows($this->highlights),
            'sidebar_title' => $this->sidebar_title ?: null,
            'sidebar_subtitle' => $this->sidebar_subtitle ?: null,
            'sidebar_items' => $this->cleanRows($this->sidebar_items),
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ];

        if ($this->image_upload) {
            $this->deletePhoto($this->image_current);
            $data['image_path'] = $this->image_upload->store('courses', 'public');
        }

        if ($this->isEdit) {
            Course::withTrashed()->findOrFail($this->editingId)->update($data);
            $message = 'Course updated successfully.';
        } else {
            Course::create($data);
            $message = 'Course added successfully.';
        }

        $this->closeModal();
        session()->flash('success', $message);
    }

    public function addDescription(): void
    {
        $this->description[] = ['body' => ''];
    }

    public function removeDescription(int $index): void
    {
        unset($this->description[$index]);
        $this->description = array_values($this->description);
    }

    public function addMetaItem(): void
    {
        $this->meta_items[] = ['label' => ''];
    }

    public function removeMetaItem(int $index): void
    {
        unset($this->meta_items[$index]);
        $this->meta_items = array_values($this->meta_items);
    }

    public function addHighlight(): void
    {
        $this->highlights[] = ['item' => ''];
    }

    public function removeHighlight(int $index): void
    {
        unset($this->highlights[$index]);
        $this->highlights = array_values($this->highlights);
    }

    public function addSidebarItem(): void
    {
        $this->sidebar_items[] = ['label' => '', 'value' => ''];
    }

    public function removeSidebarItem(int $index): void
    {
        unset($this->sidebar_items[$index]);
        $this->sidebar_items = array_values($this->sidebar_items);
    }

    public function toggleActive(int $id): void
    {
        $course = Course::withTrashed()->findOrFail($id);
        $course->update(['is_active' => ! $course->is_active]);
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

        Course::findOrFail($this->confirmingDeleteId)->delete();
        $this->confirmingDeleteId = null;
        session()->flash('success', 'Course moved to trash.');
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

        Course::withTrashed()->findOrFail($this->confirmingRestoreId)->restore();
        $this->confirmingRestoreId = null;
        session()->flash('success', 'Course restored.');
    }

    private function resetForm(): void
    {
        $this->resetValidation();
        $this->editingId = null;
        $this->courseTab = 'listing';
        $this->title = '';
        $this->slug = '';
        $this->category = 'language';
        $this->badge = '';
        $this->tag = '';
        $this->excerpt = '';
        $this->is_featured = false;
        $this->overview = '';
        $this->description = [];
        $this->meta_items = [];
        $this->highlights = [];
        $this->sidebar_title = '';
        $this->sidebar_subtitle = '';
        $this->sidebar_items = [];
        $this->sort_order = (Course::max('sort_order') ?? 0) + 1;
        $this->is_active = true;
        $this->image_upload = null;
        $this->image_current = null;
    }

    private function normalizeRows(array $rows, array $keys): array
    {
        return collect($rows)
            ->map(function ($row) use ($keys) {
                $row = is_array($row) ? $row : [];
                $normalized = [];
                foreach ($keys as $key) {
                    $normalized[$key] = $row[$key] ?? '';
                }
                return $normalized;
            })
            ->values()
            ->toArray();
    }

    private function cleanRows(array $rows): array
    {
        return collect($rows)
            ->map(function ($input) {
                $clean = [];
                foreach ((array) $input as $key => $value) {
                    $clean[$key] = is_string($value) ? trim($value) : $value;
                }
                return $clean;
            })
            ->filter(fn ($row) => collect($row)->filter(fn ($value) => filled($value))->isNotEmpty())
            ->values()
            ->toArray();
    }

    private function deletePhoto(?string $path): void
    {
        if ($path && ! Str::startsWith($path, ['http://', 'https://']) && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function defaultStats(): array
    {
        return [
            ['number' => '6', 'accent' => '+', 'label' => 'Active Programs'],
            ['number' => '15', 'accent' => '+', 'label' => 'Expert Trainers'],
            ['number' => '2000', 'accent' => '+', 'label' => 'Students Trained'],
            ['number' => '98', 'accent' => '%', 'label' => 'Success Rate'],
        ];
    }

    private function defaultWhyItems(): array
    {
        return [
            ['icon' => '*', 'title' => 'Certified Trainers', 'description' => 'Experienced instructors and exam-focused coaches.'],
            ['icon' => '*', 'title' => 'Mock Tests Weekly', 'description' => 'Simulated exams with score analysis and feedback.'],
            ['icon' => '*', 'title' => 'Small Batches', 'description' => 'Limited class sizes for personal attention.'],
            ['icon' => '*', 'title' => 'Study Abroad Link', 'description' => 'Connected counseling for admissions and visas.'],
        ];
    }

    public function render()
    {
        $courses = Course::withTrashed()
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('tag', 'like', '%' . $this->search . '%')
                    ->orWhere('category', 'like', '%' . $this->search . '%');
            }))
            ->when($this->filterActive === 'active', fn ($q) => $q->whereNull('deleted_at')->where('is_active', true))
            ->when($this->filterActive === 'inactive', fn ($q) => $q->whereNull('deleted_at')->where('is_active', false))
            ->when($this->filterActive === 'trashed', fn ($q) => $q->onlyTrashed())
            ->ordered()
            ->paginate($this->perPage);

        return view('livewire.admin.course-manager', [
            'courses' => $courses,
        ])->layout('admin.layouts.app', ['title' => 'Courses']);
    }
}
