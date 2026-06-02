<?php

namespace App\Livewire\Admin\Home;

use App\Services\HomeTestimonialService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('admin.layouts.app')]
#[Title('Home - Testimonials')]
class HomeTestimonials extends Component
{
    public string $section_label = '';
    public string $section_label_ja = '';
    public string $section_title = '';
    public string $section_title_ja = '';
    public string $section_subtitle = '';
    public string $section_subtitle_ja = '';
    public bool $is_active = true;

    public array $testimonials = [
        ['quote' => '', 'name' => '', 'role' => '', 'avatar' => '', 'rating' => 5],
    ];

    public array $testimonials_ja = [
        ['quote' => '', 'name' => '', 'role' => '', 'avatar' => '', 'rating' => 5],
    ];

    public bool $showTestimonialModal = false;
    public ?int $editingTestimonialIndex = null;
    public array $testimonialForm = [
        'quote' => '',
        'quote_ja' => '',
        'name' => '',
        'name_ja' => '',
        'role' => '',
        'role_ja' => '',
        'avatar' => '',
        'rating' => 5,
    ];

    public function mount(HomeTestimonialService $service): void
    {
        $record = $service->get();

        if (! $record) {
            $this->section_label = 'Testimonials And Success Stories';
            $this->section_title = 'What Our Students Say';
            $this->section_subtitle = 'Real words from students, parents, and partners whose lives were changed by HASU.';
            return;
        }

        $this->section_label = $record->section_label ?? '';
        $this->section_label_ja = $record->section_label_ja ?? '';
        $this->section_title = $record->section_title ?? '';
        $this->section_title_ja = $record->section_title_ja ?? '';
        $this->section_subtitle = $record->section_subtitle ?? '';
        $this->section_subtitle_ja = $record->section_subtitle_ja ?? '';
        $this->is_active = $record->is_active;
        $this->testimonials = is_array($record->testimonials) && count($record->testimonials)
            ? $record->testimonials
            : [['quote' => '', 'name' => '', 'role' => '', 'avatar' => '', 'rating' => 5]];

        $this->testimonials_ja = is_array($record->testimonials_ja) && count($record->testimonials_ja)
            ? $record->testimonials_ja
            : [['quote' => '', 'name' => '', 'role' => '', 'avatar' => '', 'rating' => 5]];

        $this->syncJapaneseTestimonials();
    }

    public function addTestimonial(): void
    {
        $this->openCreateTestimonial();
    }

    public function openCreateTestimonial(): void
    {
        $this->resetTestimonialForm();
        $this->editingTestimonialIndex = null;
        $this->showTestimonialModal = true;
    }

    public function openEditTestimonial(int $index): void
    {
        $this->syncJapaneseTestimonials();

        $testimonial = $this->testimonials[$index] ?? [];
        $testimonialJa = $this->testimonials_ja[$index] ?? [];

        $this->testimonialForm = [
            'quote' => $testimonial['quote'] ?? '',
            'quote_ja' => $testimonialJa['quote'] ?? '',
            'name' => $testimonial['name'] ?? '',
            'name_ja' => $testimonialJa['name'] ?? '',
            'role' => $testimonial['role'] ?? '',
            'role_ja' => $testimonialJa['role'] ?? '',
            'avatar' => $testimonial['avatar'] ?? '',
            'rating' => (int) ($testimonial['rating'] ?? 5),
        ];

        $this->editingTestimonialIndex = $index;
        $this->showTestimonialModal = true;
    }

    public function closeTestimonialModal(): void
    {
        $this->showTestimonialModal = false;
        $this->editingTestimonialIndex = null;
        $this->resetTestimonialForm();
    }

    public function saveTestimonialModal(): void
    {
        $this->validate([
            'testimonialForm.quote' => ['nullable', 'string', 'max:1000'],
            'testimonialForm.quote_ja' => ['nullable', 'string', 'max:1000'],
            'testimonialForm.name' => ['nullable', 'string', 'max:120'],
            'testimonialForm.name_ja' => ['nullable', 'string', 'max:120'],
            'testimonialForm.role' => ['nullable', 'string', 'max:180'],
            'testimonialForm.role_ja' => ['nullable', 'string', 'max:180'],
            'testimonialForm.avatar' => ['nullable', 'string', 'max:20'],
            'testimonialForm.rating' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        $rating = max(1, min(5, (int) ($this->testimonialForm['rating'] ?? 5)));
        $testimonial = [
            'quote' => $this->testimonialForm['quote'],
            'name' => $this->testimonialForm['name'],
            'role' => $this->testimonialForm['role'],
            'avatar' => $this->testimonialForm['avatar'],
            'rating' => $rating,
        ];
        $testimonialJa = [
            'quote' => $this->testimonialForm['quote_ja'],
            'name' => $this->testimonialForm['name_ja'],
            'role' => $this->testimonialForm['role_ja'],
            'avatar' => $this->testimonialForm['avatar'],
            'rating' => $rating,
        ];

        if ($this->editingTestimonialIndex === null) {
            if ($this->hasOnlyBlankTestimonial()) {
                $this->testimonials = [$testimonial];
                $this->testimonials_ja = [$testimonialJa];
            } else {
                $this->testimonials[] = $testimonial;
                $this->testimonials_ja[] = $testimonialJa;
            }
        } else {
            $this->testimonials[$this->editingTestimonialIndex] = $testimonial;
            $this->testimonials_ja[$this->editingTestimonialIndex] = $testimonialJa;
        }

        $this->closeTestimonialModal();
    }

    public function removeTestimonial(int $index): void
    {
        array_splice($this->testimonials, $index, 1);
        array_splice($this->testimonials_ja, $index, 1);

        $this->testimonials = array_values($this->testimonials);
        $this->testimonials_ja = array_values($this->testimonials_ja);
    }

    public function moveTestimonialUp(int $index): void
    {
        if ($index <= 0) {
            return;
        }

        $this->swapTestimonials($index, $index - 1);
    }

    public function moveTestimonialDown(int $index): void
    {
        if ($index >= count($this->testimonials) - 1) {
            return;
        }

        $this->swapTestimonials($index, $index + 1);
    }

    public function save(HomeTestimonialService $service): void
    {
        $this->validate([
            'section_label' => ['nullable', 'string', 'max:120'],
            'section_label_ja' => ['nullable', 'string', 'max:120'],
            'section_title' => ['required', 'string', 'max:180'],
            'section_title_ja' => ['nullable', 'string', 'max:180'],
            'section_subtitle' => ['nullable', 'string', 'max:500'],
            'section_subtitle_ja' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
            'testimonials' => ['array'],
            'testimonials.*.quote' => ['nullable', 'string', 'max:1000'],
            'testimonials.*.name' => ['nullable', 'string', 'max:120'],
            'testimonials.*.role' => ['nullable', 'string', 'max:180'],
            'testimonials.*.avatar' => ['nullable', 'string', 'max:20'],
            'testimonials.*.rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'testimonials_ja' => ['array'],
            'testimonials_ja.*.quote' => ['nullable', 'string', 'max:1000'],
            'testimonials_ja.*.name' => ['nullable', 'string', 'max:120'],
            'testimonials_ja.*.role' => ['nullable', 'string', 'max:180'],
            'testimonials_ja.*.avatar' => ['nullable', 'string', 'max:20'],
            'testimonials_ja.*.rating' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        $this->syncJapaneseTestimonials();

        $saved = $service->save([
            'section_label' => $this->section_label,
            'section_label_ja' => $this->section_label_ja,
            'section_title' => $this->section_title,
            'section_title_ja' => $this->section_title_ja,
            'section_subtitle' => $this->section_subtitle,
            'section_subtitle_ja' => $this->section_subtitle_ja,
            'testimonials' => $this->testimonials,
            'testimonials_ja' => $this->testimonials_ja,
            'is_active' => $this->is_active,
        ]);

        $this->testimonials = is_array($saved->testimonials) && count($saved->testimonials)
            ? $saved->testimonials
            : [['quote' => '', 'name' => '', 'role' => '', 'avatar' => '', 'rating' => 5]];

        $this->testimonials_ja = is_array($saved->testimonials_ja) && count($saved->testimonials_ja)
            ? $saved->testimonials_ja
            : [['quote' => '', 'name' => '', 'role' => '', 'avatar' => '', 'rating' => 5]];

        session()->flash('success', 'Testimonials section saved successfully.');
    }

    private function resetTestimonialForm(): void
    {
        $this->testimonialForm = [
            'quote' => '',
            'quote_ja' => '',
            'name' => '',
            'name_ja' => '',
            'role' => '',
            'role_ja' => '',
            'avatar' => '',
            'rating' => 5,
        ];
        $this->resetValidation('testimonialForm');
    }

    private function syncJapaneseTestimonials(): void
    {
        foreach ($this->testimonials as $index => $testimonial) {
            $this->testimonials_ja[$index] = [
                'quote' => $this->testimonials_ja[$index]['quote'] ?? '',
                'name' => $this->testimonials_ja[$index]['name'] ?? '',
                'role' => $this->testimonials_ja[$index]['role'] ?? '',
                'avatar' => $testimonial['avatar'] ?? '',
                'rating' => (int) ($testimonial['rating'] ?? 5),
            ];
        }

        $this->testimonials_ja = array_slice($this->testimonials_ja, 0, count($this->testimonials));
    }

    private function hasOnlyBlankTestimonial(): bool
    {
        if (count($this->testimonials) !== 1) {
            return false;
        }

        $testimonial = $this->testimonials[0];

        return trim((string) ($testimonial['quote'] ?? '')) === ''
            && trim((string) ($testimonial['name'] ?? '')) === ''
            && trim((string) ($testimonial['role'] ?? '')) === ''
            && trim((string) ($testimonial['avatar'] ?? '')) === '';
    }

    private function swapTestimonials(int $from, int $to): void
    {
        $this->syncJapaneseTestimonials();

        [$this->testimonials[$from], $this->testimonials[$to]] = [$this->testimonials[$to], $this->testimonials[$from]];
        [$this->testimonials_ja[$from], $this->testimonials_ja[$to]] = [$this->testimonials_ja[$to], $this->testimonials_ja[$from]];

        $this->testimonials = array_values($this->testimonials);
        $this->testimonials_ja = array_values($this->testimonials_ja);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.home.home-testimonials');
    }
}
