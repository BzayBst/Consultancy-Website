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
    public string $section_title = '';
    public string $section_subtitle = '';
    public bool $is_active = true;

    public array $services = [
        ['icon' => '', 'title' => '', 'description' => '', 'link_label' => '', 'link_url' => ''],
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
        $this->section_title = $record->section_title ?? '';
        $this->section_subtitle = $record->section_subtitle ?? '';
        $this->is_active = $record->is_active;
        $this->services = is_array($record->services) && count($record->services)
            ? $record->services
            : [['icon' => '', 'title' => '', 'description' => '', 'link_label' => '', 'link_url' => '']];
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
            'section_title' => ['required', 'string', 'max:180'],
            'section_subtitle' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
            'services' => ['array'],
            'services.*.icon' => ['nullable', 'string', 'max:20'],
            'services.*.title' => ['nullable', 'string', 'max:120'],
            'services.*.description' => ['nullable', 'string', 'max:500'],
            'services.*.link_label' => ['nullable', 'string', 'max:50'],
            'services.*.link_url' => ['nullable', 'string', 'max:255'],
        ]);

        $saved = $service->save([
            'section_label' => $this->section_label,
            'section_title' => $this->section_title,
            'section_subtitle' => $this->section_subtitle,
            'services' => $this->services,
            'is_active' => $this->is_active,
        ]);

        $this->services = is_array($saved->services) && count($saved->services)
            ? $saved->services
            : [['icon' => '', 'title' => '', 'description' => '', 'link_label' => '', 'link_url' => '']];

        session()->flash('success', 'Core services section saved successfully.');
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.home.home-services');
    }
}
