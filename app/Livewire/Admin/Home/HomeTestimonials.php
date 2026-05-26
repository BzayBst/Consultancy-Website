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
    public string $section_title = '';
    public string $section_subtitle = '';
    public bool $is_active = true;

    public array $testimonials = [
        ['quote' => '', 'name' => '', 'role' => '', 'avatar' => '', 'rating' => 5],
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
        $this->section_title = $record->section_title ?? '';
        $this->section_subtitle = $record->section_subtitle ?? '';
        $this->is_active = $record->is_active;
        $this->testimonials = is_array($record->testimonials) && count($record->testimonials)
            ? $record->testimonials
            : [['quote' => '', 'name' => '', 'role' => '', 'avatar' => '', 'rating' => 5]];
    }

    public function addTestimonial(): void
    {
        $this->testimonials[] = ['quote' => '', 'name' => '', 'role' => '', 'avatar' => '', 'rating' => 5];
    }

    public function removeTestimonial(int $index): void
    {
        array_splice($this->testimonials, $index, 1);

        if (empty($this->testimonials)) {
            $this->addTestimonial();
        }
    }

    public function save(HomeTestimonialService $service): void
    {
        $this->validate([
            'section_label' => ['nullable', 'string', 'max:120'],
            'section_title' => ['required', 'string', 'max:180'],
            'section_subtitle' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
            'testimonials' => ['array'],
            'testimonials.*.quote' => ['nullable', 'string', 'max:1000'],
            'testimonials.*.name' => ['nullable', 'string', 'max:120'],
            'testimonials.*.role' => ['nullable', 'string', 'max:180'],
            'testimonials.*.avatar' => ['nullable', 'string', 'max:20'],
            'testimonials.*.rating' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        $saved = $service->save([
            'section_label' => $this->section_label,
            'section_title' => $this->section_title,
            'section_subtitle' => $this->section_subtitle,
            'testimonials' => $this->testimonials,
            'is_active' => $this->is_active,
        ]);

        $this->testimonials = is_array($saved->testimonials) && count($saved->testimonials)
            ? $saved->testimonials
            : [['quote' => '', 'name' => '', 'role' => '', 'avatar' => '', 'rating' => 5]];

        session()->flash('success', 'Testimonials section saved successfully.');
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.home.home-testimonials');
    }
}
