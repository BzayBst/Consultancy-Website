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

    public bool $showServiceModal = false;
    public ?int $editingServiceIndex = null;
    public array $serviceForm = [
        'icon' => '',
        'title' => '',
        'title_ja' => '',
        'description' => '',
        'description_ja' => '',
        'link_label' => '',
        'link_label_ja' => '',
        'link_url' => '',
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

        $this->syncJapaneseServices();
    }

    public function addService(): void
    {
        $this->openCreateService();
    }

    public function openCreateService(): void
    {
        $this->resetServiceForm();
        $this->editingServiceIndex = null;
        $this->showServiceModal = true;
    }

    public function openEditService(int $index): void
    {
        $this->syncJapaneseServices();

        $service = $this->services[$index] ?? [];
        $serviceJa = $this->services_ja[$index] ?? [];

        $this->serviceForm = [
            'icon' => $service['icon'] ?? '',
            'title' => $service['title'] ?? '',
            'title_ja' => $serviceJa['title'] ?? '',
            'description' => $service['description'] ?? '',
            'description_ja' => $serviceJa['description'] ?? '',
            'link_label' => $service['link_label'] ?? '',
            'link_label_ja' => $serviceJa['link_label'] ?? '',
            'link_url' => $service['link_url'] ?? '',
        ];

        $this->editingServiceIndex = $index;
        $this->showServiceModal = true;
    }

    public function closeServiceModal(): void
    {
        $this->showServiceModal = false;
        $this->editingServiceIndex = null;
        $this->resetServiceForm();
    }

    public function saveServiceModal(): void
    {
        $this->validate([
            'serviceForm.icon' => ['nullable', 'string', 'max:20'],
            'serviceForm.title' => ['nullable', 'string', 'max:120'],
            'serviceForm.title_ja' => ['nullable', 'string', 'max:120'],
            'serviceForm.description' => ['nullable', 'string', 'max:500'],
            'serviceForm.description_ja' => ['nullable', 'string', 'max:500'],
            'serviceForm.link_label' => ['nullable', 'string', 'max:50'],
            'serviceForm.link_label_ja' => ['nullable', 'string', 'max:50'],
            'serviceForm.link_url' => ['nullable', 'string', 'max:255'],
        ]);

        $service = [
            'icon' => $this->serviceForm['icon'],
            'title' => $this->serviceForm['title'],
            'description' => $this->serviceForm['description'],
            'link_label' => $this->serviceForm['link_label'],
            'link_url' => $this->serviceForm['link_url'],
        ];

        $serviceJa = [
            'icon' => $this->serviceForm['icon'],
            'title' => $this->serviceForm['title_ja'],
            'description' => $this->serviceForm['description_ja'],
            'link_label' => $this->serviceForm['link_label_ja'],
        ];

        if ($this->editingServiceIndex === null) {
            if ($this->hasOnlyBlankService()) {
                $this->services = [$service];
                $this->services_ja = [$serviceJa];
            } else {
                $this->services[] = $service;
                $this->services_ja[] = $serviceJa;
            }
        } else {
            $this->services[$this->editingServiceIndex] = $service;
            $this->services_ja[$this->editingServiceIndex] = $serviceJa;
        }

        $this->closeServiceModal();
    }

    public function removeService(int $index): void
    {
        array_splice($this->services, $index, 1);
        array_splice($this->services_ja, $index, 1);

        $this->services = array_values($this->services);
        $this->services_ja = array_values($this->services_ja);
    }

    public function moveServiceUp(int $index): void
    {
        if ($index <= 0) {
            return;
        }

        $this->swapServices($index, $index - 1);
    }

    public function moveServiceDown(int $index): void
    {
        if ($index >= count($this->services) - 1) {
            return;
        }

        $this->swapServices($index, $index + 1);
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

        $this->syncJapaneseServices();

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

    private function resetServiceForm(): void
    {
        $this->serviceForm = [
            'icon' => '',
            'title' => '',
            'title_ja' => '',
            'description' => '',
            'description_ja' => '',
            'link_label' => '',
            'link_label_ja' => '',
            'link_url' => '',
        ];
        $this->resetValidation('serviceForm');
    }

    private function syncJapaneseServices(): void
    {
        foreach ($this->services as $index => $service) {
            $this->services_ja[$index] = [
                'icon' => $service['icon'] ?? '',
                'title' => $this->services_ja[$index]['title'] ?? '',
                'description' => $this->services_ja[$index]['description'] ?? '',
                'link_label' => $this->services_ja[$index]['link_label'] ?? '',
            ];
        }

        $this->services_ja = array_slice($this->services_ja, 0, count($this->services));
    }

    private function hasOnlyBlankService(): bool
    {
        if (count($this->services) !== 1) {
            return false;
        }

        $service = $this->services[0];

        return trim((string) ($service['icon'] ?? '')) === ''
            && trim((string) ($service['title'] ?? '')) === ''
            && trim((string) ($service['description'] ?? '')) === ''
            && trim((string) ($service['link_label'] ?? '')) === ''
            && trim((string) ($service['link_url'] ?? '')) === '';
    }

    private function swapServices(int $from, int $to): void
    {
        $this->syncJapaneseServices();

        [$this->services[$from], $this->services[$to]] = [$this->services[$to], $this->services[$from]];
        [$this->services_ja[$from], $this->services_ja[$to]] = [$this->services_ja[$to], $this->services_ja[$from]];

        $this->services = array_values($this->services);
        $this->services_ja = array_values($this->services_ja);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.home.home-services');
    }
}
