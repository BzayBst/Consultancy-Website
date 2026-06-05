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
    public string $pageTab = 'hero';

    public string $hero_badge = '';
    public string $hero_badge_ja = '';
    public string $hero_title = '';
    public string $hero_title_ja = '';
    public string $hero_highlight = '';
    public string $hero_highlight_ja = '';
    public string $hero_subtitle = '';
    public string $hero_subtitle_ja = '';
    public string $intro_label = '';
    public string $intro_label_ja = '';
    public string $intro_title = '';
    public string $intro_title_ja = '';
    public string $intro_subtitle = '';
    public string $intro_subtitle_ja = '';
    public array $stats = [];
    public array $stats_ja = [];
    public string $catalog_label = '';
    public string $catalog_label_ja = '';
    public string $catalog_title = '';
    public string $catalog_title_ja = '';
    public string $why_label = '';
    public string $why_label_ja = '';
    public string $why_title = '';
    public string $why_title_ja = '';
    public string $why_description = '';
    public string $why_description_ja = '';
    public array $why_items = [];
    public array $why_items_ja = [];
    public string $cta_title = '';
    public string $cta_title_ja = '';
    public string $cta_subtitle = '';
    public string $cta_subtitle_ja = '';
    public string $cta_button_label = '';
    public string $cta_button_label_ja = '';
    public string $cta_button_url = '';
    public string $cta_phone_label = '';
    public string $cta_phone_label_ja = '';
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
    public string $title_ja = '';
    public string $slug = '';
    public string $category = 'language';
    public string $badge = '';
    public string $badge_ja = '';
    public string $tag = '';
    public string $tag_ja = '';
    public string $excerpt = '';
    public string $excerpt_ja = '';
    public bool $is_featured = false;
    public string $overview = '';
    public string $overview_ja = '';
    public array $description = [];
    public array $description_ja = [];
    public array $meta_items = [];
    public array $meta_items_ja = [];
    public array $highlights = [];
    public array $highlights_ja = [];
    public string $sidebar_title = '';
    public string $sidebar_title_ja = '';
    public string $sidebar_subtitle = '';
    public string $sidebar_subtitle_ja = '';
    public array $sidebar_items = [];
    public array $sidebar_items_ja = [];
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
        $this->hero_badge_ja = $page?->hero_badge_ja ?? '';
        $this->hero_title = $page?->hero_title ?? 'Language & Test Prep';
        $this->hero_title_ja = $page?->hero_title_ja ?? '';
        $this->hero_highlight = $page?->hero_highlight ?? 'Courses';
        $this->hero_highlight_ja = $page?->hero_highlight_ja ?? '';
        $this->hero_subtitle = $page?->hero_subtitle ?? 'Internationally recognized language training and exam preparation taught by certified experts at our institute.';
        $this->hero_subtitle_ja = $page?->hero_subtitle_ja ?? '';
        $this->intro_label = $page?->intro_label ?? 'What We Teach';
        $this->intro_label_ja = $page?->intro_label_ja ?? '';
        $this->intro_title = $page?->intro_title ?? 'Prepare for Your Future Abroad';
        $this->intro_title_ja = $page?->intro_title_ja ?? '';
        $this->intro_subtitle = $page?->intro_subtitle ?? 'From Japanese language mastery to IELTS and PTE band targets, HASU offers structured programs with mock tests, small batches, and personalized coaching.';
        $this->intro_subtitle_ja = $page?->intro_subtitle_ja ?? '';
        $this->stats = $this->normalizeRows($page?->stats ?? $this->defaultStats(), ['number', 'accent', 'label']);
        $this->stats_ja = $this->normalizeRows($page?->stats_ja ?? $this->defaultStats(), ['number', 'accent', 'label']);
        $this->catalog_label = $page?->catalog_label ?? 'Browse All';
        $this->catalog_label_ja = $page?->catalog_label_ja ?? '';
        $this->catalog_title = $page?->catalog_title ?? 'Our Course Catalog';
        $this->catalog_title_ja = $page?->catalog_title_ja ?? '';
        $this->why_label = $page?->why_label ?? 'Why HASU';
        $this->why_label_ja = $page?->why_label_ja ?? '';
        $this->why_title = $page?->why_title ?? 'Why Students Choose Our Courses';
        $this->why_title_ja = $page?->why_title_ja ?? '';
        $this->why_description = $page?->why_description ?? 'HASU Language Institute combines certified trainers, proven curricula, and integration with our study-abroad consultancy.';
        $this->why_description_ja = $page?->why_description_ja ?? '';
        $this->why_items = $this->normalizeRows($page?->why_items ?? $this->defaultWhyItems(), ['icon', 'title', 'description']);
        $this->why_items_ja = $this->normalizeRows($page?->why_items_ja ?? $this->defaultWhyItems(), ['icon', 'title', 'description']);
        $this->cta_title = $page?->cta_title ?? 'Not Sure Which Course Is Right for You?';
        $this->cta_title_ja = $page?->cta_title_ja ?? '';
        $this->cta_subtitle = $page?->cta_subtitle ?? 'Visit our campus or book a free assessment. We will recommend the best program for your goals.';
        $this->cta_subtitle_ja = $page?->cta_subtitle_ja ?? '';
        $this->cta_button_label = $page?->cta_button_label ?? 'Apply Now';
        $this->cta_button_label_ja = $page?->cta_button_label_ja ?? '';
        $this->cta_button_url = $page?->cta_button_url ?? route('contact');
        $this->cta_phone_label = $page?->cta_phone_label ?? 'Call Us Today';
        $this->cta_phone_label_ja = $page?->cta_phone_label_ja ?? '';
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

    public function setPageTab(string $tab): void
    {
        $this->pageTab = $tab;
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
            'stats_ja.*.label' => ['nullable', 'string', 'max:80'],
            'catalog_label' => ['nullable', 'string', 'max:80'],
            'catalog_title' => ['nullable', 'string', 'max:160'],
            'why_label' => ['nullable', 'string', 'max:80'],
            'why_title' => ['nullable', 'string', 'max:160'],
            'why_description' => ['nullable', 'string', 'max:700'],
            'why_items.*.icon' => ['nullable', 'string', 'max:20'],
            'why_items.*.title' => ['nullable', 'string', 'max:100'],
            'why_items.*.description' => ['nullable', 'string', 'max:300'],
            'why_items_ja.*.title' => ['nullable', 'string', 'max:100'],
            'why_items_ja.*.description' => ['nullable', 'string', 'max:300'],
            'cta_title' => ['nullable', 'string', 'max:160'],
            'cta_subtitle' => ['nullable', 'string', 'max:500'],
            'cta_button_label' => ['nullable', 'string', 'max:80'],
            'cta_button_url' => ['nullable', 'string', 'max:255'],
            'cta_phone_label' => ['nullable', 'string', 'max:80'],
            'cta_phone_url' => ['nullable', 'string', 'max:255'],
        ]);

        CoursePage::updateOrCreate(['id' => 1], [
            'hero_badge' => $this->hero_badge,
            'hero_badge_ja' => $this->hero_badge_ja ?: null,
            'hero_title' => $this->hero_title,
            'hero_title_ja' => $this->hero_title_ja ?: null,
            'hero_highlight' => $this->hero_highlight,
            'hero_highlight_ja' => $this->hero_highlight_ja ?: null,
            'hero_subtitle' => $this->hero_subtitle,
            'hero_subtitle_ja' => $this->hero_subtitle_ja ?: null,
            'intro_label' => $this->intro_label,
            'intro_label_ja' => $this->intro_label_ja ?: null,
            'intro_title' => $this->intro_title,
            'intro_title_ja' => $this->intro_title_ja ?: null,
            'intro_subtitle' => $this->intro_subtitle,
            'intro_subtitle_ja' => $this->intro_subtitle_ja ?: null,
            'stats' => $this->cleanRows($this->stats),
            'stats_ja' => $this->cleanRows($this->stats_ja),
            'catalog_label' => $this->catalog_label,
            'catalog_label_ja' => $this->catalog_label_ja ?: null,
            'catalog_title' => $this->catalog_title,
            'catalog_title_ja' => $this->catalog_title_ja ?: null,
            'why_label' => $this->why_label,
            'why_label_ja' => $this->why_label_ja ?: null,
            'why_title' => $this->why_title,
            'why_title_ja' => $this->why_title_ja ?: null,
            'why_description' => $this->why_description,
            'why_description_ja' => $this->why_description_ja ?: null,
            'why_items' => $this->cleanRows($this->why_items),
            'why_items_ja' => $this->cleanRows($this->why_items_ja),
            'cta_title' => $this->cta_title,
            'cta_title_ja' => $this->cta_title_ja ?: null,
            'cta_subtitle' => $this->cta_subtitle,
            'cta_subtitle_ja' => $this->cta_subtitle_ja ?: null,
            'cta_button_label' => $this->cta_button_label,
            'cta_button_label_ja' => $this->cta_button_label_ja ?: null,
            'cta_button_url' => $this->cta_button_url,
            'cta_phone_label' => $this->cta_phone_label,
            'cta_phone_label_ja' => $this->cta_phone_label_ja ?: null,
            'cta_phone_url' => $this->cta_phone_url,
        ]);

        session()->flash('success', 'Course page settings saved.');
    }

    public function addStat(): void
    {
        $this->stats[] = ['number' => '', 'accent' => '+', 'label' => ''];
        $this->stats_ja[] = ['number' => '', 'accent' => '+', 'label' => ''];
    }

    public function removeStat(int $index): void
    {
        unset($this->stats[$index]);
        $this->stats = array_values($this->stats);
        if (isset($this->stats_ja[$index])) {
            unset($this->stats_ja[$index]);
            $this->stats_ja = array_values($this->stats_ja);
        }
    }

    public function addWhyItem(): void
    {
        $this->why_items[] = ['icon' => '', 'title' => '', 'description' => ''];
        $this->why_items_ja[] = ['icon' => '', 'title' => '', 'description' => ''];
    }

    public function removeWhyItem(int $index): void
    {
        unset($this->why_items[$index]);
        $this->why_items = array_values($this->why_items);
        if (isset($this->why_items_ja[$index])) {
            unset($this->why_items_ja[$index]);
            $this->why_items_ja = array_values($this->why_items_ja);
        }
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
        $this->title_ja = $course->title_ja ?? '';
        $this->slug = $course->slug;
        $this->category = $course->category ?? 'language';
        $this->badge = $course->badge ?? '';
        $this->tag = $course->tag ?? '';
        $this->excerpt = $course->excerpt ?? '';
        $this->excerpt_ja = $course->excerpt_ja ?? '';
        $this->badge_ja = $course->badge_ja ?? '';
        $this->tag_ja = $course->tag_ja ?? '';
        $this->image_current = $course->image_path;
        $this->is_featured = $course->is_featured;
        $this->overview = $course->overview ?? '';
        $this->overview_ja = $course->overview_ja ?? '';
        $this->description = $this->normalizeRows($course->description ?? [], ['body']);
        $this->description_ja = $this->normalizeRows($course->description_ja ?? [], ['body']);
        $this->meta_items = $this->normalizeRows($course->meta_items ?? [], ['label']);
        $this->meta_items_ja = $this->normalizeRows($course->meta_items_ja ?? [], ['label']);
        $this->highlights = $this->normalizeRows($course->highlights ?? [], ['item']);
        $this->highlights_ja = $this->normalizeRows($course->highlights_ja ?? [], ['item']);
        $this->sidebar_title = $course->sidebar_title ?? '';
        $this->sidebar_title_ja = $course->sidebar_title_ja ?? '';
        $this->sidebar_subtitle = $course->sidebar_subtitle ?? '';
        $this->sidebar_subtitle_ja = $course->sidebar_subtitle_ja ?? '';
        $this->sidebar_items = $this->normalizeRows($course->sidebar_items ?? [], ['label', 'value']);
        $this->sidebar_items_ja = $this->normalizeRows($course->sidebar_items_ja ?? [], ['label', 'value']);
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
            'description_ja.*.body' => ['nullable', 'string', 'max:1200'],
            'meta_items.*.label' => ['nullable', 'string', 'max:100'],
            'meta_items_ja.*.label' => ['nullable', 'string', 'max:100'],
            'highlights.*.item' => ['nullable', 'string', 'max:200'],
            'highlights_ja.*.item' => ['nullable', 'string', 'max:200'],
            'sidebar_title' => ['nullable', 'string', 'max:120'],
            'sidebar_title_ja' => ['nullable', 'string', 'max:120'],
            'sidebar_subtitle' => ['nullable', 'string', 'max:400'],
            'sidebar_subtitle_ja' => ['nullable', 'string', 'max:400'],
            'sidebar_items.*.label' => ['nullable', 'string', 'max:80'],
            'sidebar_items.*.value' => ['nullable', 'string', 'max:120'],
            'sidebar_items_ja.*.label' => ['nullable', 'string', 'max:80'],
            'sidebar_items_ja.*.value' => ['nullable', 'string', 'max:120'],
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
            'title_ja' => $this->title_ja ?: null,
            'slug' => $slug,
            'category' => $this->category,
            'badge' => $this->badge ?: null,
            'badge_ja' => $this->badge_ja ?: null,
            'tag' => $this->tag ?: null,
            'tag_ja' => $this->tag_ja ?: null,
            'excerpt' => $this->excerpt ?: null,
            'excerpt_ja' => $this->excerpt_ja ?: null,
            'is_featured' => $this->is_featured,
            'overview' => $this->overview ?: null,
            'overview_ja' => $this->overview_ja ?: null,
            'description' => $this->cleanRows($this->description),
            'description_ja' => $this->cleanRows($this->description_ja),
            'meta_items' => $this->cleanRows($this->meta_items),
            'meta_items_ja' => $this->cleanRows($this->meta_items_ja),
            'highlights' => $this->cleanRows($this->highlights),
            'highlights_ja' => $this->cleanRows($this->highlights_ja),
            'sidebar_title' => $this->sidebar_title ?: null,
            'sidebar_title_ja' => $this->sidebar_title_ja ?: null,
            'sidebar_subtitle' => $this->sidebar_subtitle ?: null,
            'sidebar_subtitle_ja' => $this->sidebar_subtitle_ja ?: null,
            'sidebar_items' => $this->cleanRows($this->sidebar_items),
            'sidebar_items_ja' => $this->cleanRows($this->sidebar_items_ja),
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
        $this->description_ja[] = ['body' => ''];
    }

    public function removeDescription(int $index): void
    {
        unset($this->description[$index]);
        $this->description = array_values($this->description);
        if (isset($this->description_ja[$index])) {
            unset($this->description_ja[$index]);
            $this->description_ja = array_values($this->description_ja);
        }
    }

    public function addMetaItem(): void
    {
        $this->meta_items[] = ['label' => ''];
        $this->meta_items_ja[] = ['label' => ''];
    }

    public function removeMetaItem(int $index): void
    {
        unset($this->meta_items[$index]);
        $this->meta_items = array_values($this->meta_items);
        if (isset($this->meta_items_ja[$index])) {
            unset($this->meta_items_ja[$index]);
            $this->meta_items_ja = array_values($this->meta_items_ja);
        }
    }

    public function addHighlight(): void
    {
        $this->highlights[] = ['item' => ''];
        $this->highlights_ja[] = ['item' => ''];
    }

    public function removeHighlight(int $index): void
    {
        unset($this->highlights[$index]);
        $this->highlights = array_values($this->highlights);
        if (isset($this->highlights_ja[$index])) {
            unset($this->highlights_ja[$index]);
            $this->highlights_ja = array_values($this->highlights_ja);
        }
    }

    public function addSidebarItem(): void
    {
        $this->sidebar_items[] = ['label' => '', 'value' => ''];
        $this->sidebar_items_ja[] = ['label' => '', 'value' => ''];
    }

    public function removeSidebarItem(int $index): void
    {
        unset($this->sidebar_items[$index]);
        $this->sidebar_items = array_values($this->sidebar_items);
        if (isset($this->sidebar_items_ja[$index])) {
            unset($this->sidebar_items_ja[$index]);
            $this->sidebar_items_ja = array_values($this->sidebar_items_ja);
        }
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
        $this->title_ja = '';
        $this->slug = '';
        $this->category = 'language';
        $this->badge = '';
        $this->badge_ja = '';
        $this->tag = '';
        $this->tag_ja = '';
        $this->excerpt = '';
        $this->excerpt_ja = '';
        $this->is_featured = false;
        $this->overview = '';
        $this->overview_ja = '';
        $this->description = [];
        $this->description_ja = [];
        $this->meta_items = [];
        $this->meta_items_ja = [];
        $this->highlights = [];
        $this->highlights_ja = [];
        $this->sidebar_title = '';
        $this->sidebar_title_ja = '';
        $this->sidebar_subtitle = '';
        $this->sidebar_subtitle_ja = '';
        $this->sidebar_items = [];
        $this->sidebar_items_ja = [];
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
