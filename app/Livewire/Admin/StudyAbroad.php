<?php

namespace App\Livewire\Admin;

use App\Models\StudyAbroadDestination;
use App\Models\StudyAbroadPage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class StudyAbroad extends Component
{
    use WithFileUploads, WithPagination;

    public string $activeTab = 'page';

    public string $hero_badge = '';
    public string $hero_title = '';
    public string $hero_highlight = '';
    public string $hero_subtitle = '';
    public string $section_label = '';
    public string $section_title = '';
    public string $cta_title = '';
    public string $cta_subtitle = '';
    public string $cta_button_label = '';
    public string $cta_button_url = '';

    public string $search = '';
    public string $filterActive = '';
    public int $perPage = 10;

    public bool $showModal = false;
    public bool $isEdit = false;
    public ?int $editingId = null;
    public string $destinationTab = 'listing';

    public string $country = '';
    public string $slug = '';
    public string $flag = '';
    public string $card_tag = '';
    public string $card_title = '';
    public string $card_description = '';
    public string $overview = '';
    public string $benefits_title = '';
    public string $benefits_description = '';
    public array $benefits = [];
    public array $courses = [];
    public string $scholarship_text = '';
    public array $cities = [];
    public array $universities = [];
    public array $cityImageUploads = [];
    public array $universityLogoUploads = [];
    public array $faqs = [];
    public int $sort_order = 0;
    public bool $is_active = true;
    public bool $removePhoto = false;

    public $card_image_upload;
    public ?string $card_image_current = null;

    public ?int $confirmingDeleteId = null;
    public ?int $confirmingRestoreId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterActive' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function mount(): void
    {
        $page = StudyAbroadPage::first();

        $this->hero_badge = $page?->hero_badge ?? 'Global Opportunities';
        $this->hero_title = $page?->hero_title ?? 'Choose Your Dream';
        $this->hero_highlight = $page?->hero_highlight ?? 'Destination';
        $this->hero_subtitle = $page?->hero_subtitle ?? 'Explore top study abroad destinations and unlock world-class education with our expert visa and admission guidance.';
        $this->section_label = $page?->section_label ?? 'Explore';
        $this->section_title = $page?->section_title ?? 'Popular Countries';
        $this->cta_title = $page?->cta_title ?? 'Confused About Where to Apply?';
        $this->cta_subtitle = $page?->cta_subtitle ?? 'Book a free counseling session. We will evaluate your profile and recommend the perfect country and university for you.';
        $this->cta_button_label = $page?->cta_button_label ?? 'Book Consultation';
        $this->cta_button_url = $page?->cta_button_url ?? route('contact');
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function setDestinationTab(string $tab): void
    {
        $this->destinationTab = $tab;
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
            'hero_subtitle' => ['nullable', 'string', 'max:400'],
            'section_label' => ['nullable', 'string', 'max:80'],
            'section_title' => ['required', 'string', 'max:160'],
            'cta_title' => ['nullable', 'string', 'max:160'],
            'cta_subtitle' => ['nullable', 'string', 'max:400'],
            'cta_button_label' => ['nullable', 'string', 'max:80'],
            'cta_button_url' => ['nullable', 'string', 'max:255'],
        ]);

        StudyAbroadPage::updateOrCreate(['id' => 1], [
            'hero_badge' => $this->hero_badge,
            'hero_title' => $this->hero_title,
            'hero_highlight' => $this->hero_highlight,
            'hero_subtitle' => $this->hero_subtitle,
            'section_label' => $this->section_label,
            'section_title' => $this->section_title,
            'cta_title' => $this->cta_title,
            'cta_subtitle' => $this->cta_subtitle,
            'cta_button_label' => $this->cta_button_label,
            'cta_button_url' => $this->cta_button_url,
        ]);

        session()->flash('success', 'Study Abroad page settings saved.');
    }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->showModal = true;
        $this->activeTab = 'destinations';
    }

    public function openEdit(int $id): void
    {
        $this->resetForm();
        $destination = StudyAbroadDestination::withTrashed()->findOrFail($id);

        $this->isEdit = true;
        $this->editingId = $destination->id;
        $this->country = $destination->country;
        $this->slug = $destination->slug;
        $this->flag = $destination->flag ?? '';
        $this->card_tag = $destination->card_tag ?? '';
        $this->card_title = $destination->card_title ?? '';
        $this->card_description = $destination->card_description ?? '';
        $this->overview = $destination->overview ?? '';
        $this->benefits_title = $destination->benefits_title ?? '';
        $this->benefits_description = $destination->benefits_description ?? '';
        $this->benefits = $this->normalizeRows($destination->benefits ?? [], ['icon', 'title', 'description']);
        $this->courses = $this->normalizeRows($destination->courses ?? [], ['tag', 'title', 'description']);
        $this->scholarship_text = $destination->scholarship_text ?? '';
        $this->cities = $this->normalizeRows($destination->cities ?? [], ['title', 'description', 'image']);
        $this->universities = $this->normalizeRows($destination->universities ?? [], ['name', 'logo']);
        $this->faqs = $this->normalizeRows($destination->faqs ?? [], ['question', 'answer']);
        $this->sort_order = $destination->sort_order;
        $this->is_active = $destination->is_active;
        $this->card_image_current = $destination->card_image;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function saveDestination(): void
    {
        $this->validate([
            'country' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:140'],
            'flag' => ['nullable', 'string', 'max:20'],
            'card_tag' => ['nullable', 'string', 'max:120'],
            'card_title' => ['nullable', 'string', 'max:160'],
            'card_description' => ['nullable', 'string', 'max:500'],
            'overview' => ['nullable', 'string', 'max:2000'],
            'benefits_title' => ['nullable', 'string', 'max:160'],
            'benefits_description' => ['nullable', 'string', 'max:500'],
            'benefits.*.icon' => ['nullable', 'string', 'max:20'],
            'benefits.*.title' => ['nullable', 'string', 'max:120'],
            'benefits.*.description' => ['nullable', 'string', 'max:400'],
            'courses.*.tag' => ['nullable', 'string', 'max:80'],
            'courses.*.title' => ['nullable', 'string', 'max:120'],
            'courses.*.description' => ['nullable', 'string', 'max:400'],
            'scholarship_text' => ['nullable', 'string', 'max:1000'],
            'cities.*.title' => ['nullable', 'string', 'max:120'],
            'cities.*.description' => ['nullable', 'string', 'max:400'],
            'cities.*.image' => ['nullable', 'string', 'max:500'],
            'cityImageUploads.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'universities.*.name' => ['nullable', 'string', 'max:160'],
            'universities.*.logo' => ['nullable', 'string', 'max:500'],
            'universityLogoUploads.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:3072'],
            'faqs.*.question' => ['nullable', 'string', 'max:220'],
            'faqs.*.answer' => ['nullable', 'string', 'max:800'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'card_image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        $slug = Str::slug($this->slug ?: $this->country);
        $query = StudyAbroadDestination::withTrashed()->where('slug', $slug);
        if ($this->isEdit) {
            $query->where('id', '!=', $this->editingId);
        }
        if ($query->exists()) {
            $this->addError('slug', 'This slug is already in use.');
            return;
        }

        $cities = $this->cities;
        foreach ($this->cityImageUploads as $index => $upload) {
            if (! $upload) {
                continue;
            }

            $this->deletePhoto($cities[$index]['image'] ?? null);
            $cities[$index]['image'] = $upload->store('study-abroad/cities', 'public');
        }

        $universities = $this->universities;
        foreach ($this->universityLogoUploads as $index => $upload) {
            if (! $upload) {
                continue;
            }

            $this->deletePhoto($universities[$index]['logo'] ?? null);
            $universities[$index]['logo'] = $upload->store('study-abroad/institutions', 'public');
        }

        $data = [
            'country' => $this->country,
            'slug' => $slug,
            'flag' => $this->flag ?: null,
            'card_tag' => $this->card_tag ?: null,
            'card_title' => $this->card_title ?: 'Study in ' . $this->country,
            'card_description' => $this->card_description ?: null,
            'overview' => $this->overview ?: null,
            'benefits_title' => $this->benefits_title ?: null,
            'benefits_description' => $this->benefits_description ?: null,
            'benefits' => $this->cleanRows($this->benefits),
            'courses' => $this->cleanRows($this->courses),
            'scholarship_text' => $this->scholarship_text ?: null,
            'cities' => $this->cleanRows($cities),
            'universities' => $this->cleanRows($universities),
            'faqs' => $this->cleanRows($this->faqs),
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ];

        if ($this->card_image_upload) {
            $this->deletePhoto($this->card_image_current);
            $data['card_image'] = $this->card_image_upload->store('study-abroad', 'public');
        }

        if ($this->isEdit) {
            StudyAbroadDestination::withTrashed()->findOrFail($this->editingId)->update($data);
            $message = 'Destination updated successfully.';
        } else {
            StudyAbroadDestination::create($data);
            $message = 'Destination added successfully.';
        }

        $this->closeModal();
        session()->flash('success', $message);
    }

    public function addBenefit(): void
    {
        $this->benefits[] = ['icon' => '', 'title' => '', 'description' => ''];
    }

    public function removeBenefit(int $index): void
    {
        unset($this->benefits[$index]);
        $this->benefits = array_values($this->benefits);
    }

    public function addCourse(): void
    {
        $this->courses[] = ['tag' => '', 'title' => '', 'description' => ''];
    }

    public function removeCourse(int $index): void
    {
        unset($this->courses[$index]);
        $this->courses = array_values($this->courses);
    }

    public function addCity(): void
    {
        $this->cities[] = ['title' => '', 'description' => '', 'image' => ''];
    }

    public function removeCity(int $index): void
    {
        unset($this->cities[$index]);
        $this->cities = array_values($this->cities);
        unset($this->cityImageUploads[$index]);
        $this->cityImageUploads = array_values($this->cityImageUploads);
    }

    public function addUniversity(): void
    {
        $this->universities[] = ['name' => '', 'logo' => ''];
    }

    public function removeUniversity(int $index): void
    {
        unset($this->universities[$index]);
        $this->universities = array_values($this->universities);
        unset($this->universityLogoUploads[$index]);
        $this->universityLogoUploads = array_values($this->universityLogoUploads);
    }

    public function addFaq(): void
    {
        $this->faqs[] = ['question' => '', 'answer' => ''];
    }

    public function removeFaq(int $index): void
    {
        unset($this->faqs[$index]);
        $this->faqs = array_values($this->faqs);
    }

    public function toggleActive(int $id): void
    {
        $destination = StudyAbroadDestination::withTrashed()->findOrFail($id);
        $destination->update(['is_active' => ! $destination->is_active]);
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

        StudyAbroadDestination::findOrFail($this->confirmingDeleteId)->delete();
        $this->confirmingDeleteId = null;
        session()->flash('success', 'Destination moved to trash.');
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

        StudyAbroadDestination::withTrashed()->findOrFail($this->confirmingRestoreId)->restore();
        $this->confirmingRestoreId = null;
        session()->flash('success', 'Destination restored.');
    }

    private function resetForm(): void
    {
        $this->resetValidation();
        $this->editingId = null;
        $this->destinationTab = 'listing';
        $this->country = '';
        $this->slug = '';
        $this->flag = '';
        $this->card_tag = '';
        $this->card_title = '';
        $this->card_description = '';
        $this->overview = '';
        $this->benefits_title = '';
        $this->benefits_description = '';
        $this->benefits = [];
        $this->courses = [];
        $this->scholarship_text = '';
        $this->cities = [];
        $this->universities = [];
        $this->cityImageUploads = [];
        $this->universityLogoUploads = [];
        $this->faqs = [];
        $this->sort_order = (StudyAbroadDestination::max('sort_order') ?? 0) + 1;
        $this->is_active = true;
        $this->removePhoto = false;
        $this->card_image_upload = null;
        $this->card_image_current = null;
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

    public function render()
    {
        $destinations = StudyAbroadDestination::withTrashed()
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('country', 'like', '%' . $this->search . '%')
                    ->orWhere('card_title', 'like', '%' . $this->search . '%')
                    ->orWhere('card_tag', 'like', '%' . $this->search . '%');
            }))
            ->when($this->filterActive === 'active', fn ($q) => $q->whereNull('deleted_at')->where('is_active', true))
            ->when($this->filterActive === 'inactive', fn ($q) => $q->whereNull('deleted_at')->where('is_active', false))
            ->when($this->filterActive === 'trashed', fn ($q) => $q->onlyTrashed())
            ->ordered()
            ->paginate($this->perPage);

        return view('livewire.admin.study-abroad', [
            'destinations' => $destinations,
        ])->layout('admin.layouts.app', ['title' => 'Study Abroad']);
    }
}
