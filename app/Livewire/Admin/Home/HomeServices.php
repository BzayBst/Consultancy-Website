<?php

namespace App\Livewire\Admin\Home;

use App\Services\HomeServiceService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('admin.layouts.app')]
#[Title('Home - Core Services')]
class HomeServices extends Component
{
    public string $section_label = '';
    public string $section_label_ja = '';
    public string $section_title = '';
    public string $section_title_ja = '';
    public string $section_subtitle = '';
    public string $section_subtitle_ja = '';
    public bool $is_active = true;

    public array $services = [
        ['icon' => '', 'title' => '', 'description' => '', 'link_label' => '', 'link_url' => ''],
    ];

    public array $services_ja = [
        ['icon' => '', 'title' => '', 'description' => '', 'link_label' => ''],
    ];

    public function mount(HomeServiceService $service): void
    {
        $record = $service->get();

        if (! $record) {
            $this->section_label = 'What We Offer';
            $this->section_title = 'Our Core Services';
            $this->section_subtitle = 'From admission guidance to visa processing, we handle every step of your international education journey.';
            $this->services = [
                ['icon' => '*', 'title' => 'Admission Guidance', 'description' => '', 'link_label' => 'Read More', 'link_url' => ''],
            ];
            return;
        }

        $this->section_label = $record->section_label ?? '';
        $this->section_label_ja = $record->section_label_ja ?? '';
        $this->section_title = $record->section_title ?? '';
        $this->section_title_ja = $record->section_title_ja ?? '';
        $this->section_subtitle = $record->section_subtitle ?? '';
        $this->section_subtitle_ja = $record->section_subtitle_ja ?? '';
        $this->is_active = $record->is_active;
        $this->services = is_array($record->services) && count($record->services)
            ? $record->services
            : [['icon' => '', 'title' => '', 'description' => '', 'link_label' => '', 'link_url' => '']];

        $this->services_ja = is_array($record->services_ja) && count($record->services_ja)
            ? $record->services_ja
            : [['icon' => '', 'title' => '', 'description' => '', 'link_label' => '']];
    }

    public function addService(): void
    {
        $this->services[] = ['icon' => '', 'title' => '', 'description' => '', 'link_label' => 'Read More', 'link_url' => ''];
    }

    public function removeService(int $index): void
    {
        array_splice($this->services, $index, 1);

        if (empty($this->services)) {
            $this->addService();
        }
    }

    public function save(HomeServiceService $service): void
    {
        $this->validate([
            'section_label' => ['nullable', 'string', 'max:100'],
            'section_label_ja' => ['nullable', 'string', 'max:100'],
            'section_title' => ['required', 'string', 'max:180'],
            'section_title_ja' => ['nullable', 'string', 'max:180'],
            'section_subtitle' => ['nullable', 'string', 'max:500'],
            'section_subtitle_ja' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
            'services' => ['array'],
            'services.*.icon' => ['nullable', 'string', 'max:20'],
            'services.*.title' => ['nullable', 'string', 'max:120'],
            'services.*.description' => ['nullable', 'string', 'max:500'],
            'services.*.link_label' => ['nullable', 'string', 'max:50'],
            'services.*.link_url' => ['nullable', 'string', 'max:255'],
            'services_ja' => ['array'],
            'services_ja.*.icon' => ['nullable', 'string', 'max:20'],
            'services_ja.*.title' => ['nullable', 'string', 'max:120'],
            'services_ja.*.description' => ['nullable', 'string', 'max:500'],
            'services_ja.*.link_label' => ['nullable', 'string', 'max:50'],
        ]);

        $saved = $service->save([
            'section_label' => $this->section_label,
            'section_label_ja' => $this->section_label_ja,
            'section_title' => $this->section_title,
            'section_title_ja' => $this->section_title_ja,
            'section_subtitle' => $this->section_subtitle,
            'section_subtitle_ja' => $this->section_subtitle_ja,
            'services' => $this->services,
            'services_ja' => $this->services_ja,
            'is_active' => $this->is_active,
        ]);

        $this->services = is_array($saved->services) && count($saved->services)
            ? $saved->services
            : [['icon' => '', 'title' => '', 'description' => '', 'link_label' => '', 'link_url' => '']];

        $this->services_ja = is_array($saved->services_ja) && count($saved->services_ja)
            ? $saved->services_ja
            : [['icon' => '', 'title' => '', 'description' => '', 'link_label' => '']];

        session()->flash('success', 'Core services section saved successfully.');
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.home.home-services');
    }
}
