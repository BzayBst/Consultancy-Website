<?php

namespace App\Livewire\Admin\About;

use App\Services\CoreValuesService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('admin.layouts.app')]
#[Title('Core Values – HASU Admin')]
class CoreValues extends Component
{
    // ── Active tab ────────────────────────────────────────────────────────
    public string $activeTab = 'section';

    // ── Section header fields ─────────────────────────────────────────────
    #[Validate('required|string|max:80')]
    public string $section_label = '';

    #[Validate('required|string|max:200')]
    public string $section_title = '';

    #[Validate('nullable|string|max:400')]
    public string $section_subtitle = '';

    // ── Values list ───────────────────────────────────────────────────────
    public array $values          = [];
    public bool  $showValueModal  = false;
    public bool  $showDeleteModal = false;
    public ?int  $editingValueId  = null;
    public ?int  $deletingValueId = null;

    // ── Value form fields ─────────────────────────────────────────────────
    #[Validate('required|string|max:10')]
    public string $v_icon = '';

    #[Validate('required|string|max:100')]
    public string $v_title = '';

    #[Validate('nullable|string|max:500')]
    public string $v_desc = '';

    // ── Mount ─────────────────────────────────────────────────────────────
    public function mount(CoreValuesService $service): void
    {
        $this->loadSection($service);
        $this->values = $service->getValues()->toArray();
    }

    private function loadSection(CoreValuesService $service): void
    {
        $s = $service->getSection();
        $this->section_label    = $s?->section_label ?? 'Core Values';
        $this->section_title    = $s?->title         ?? 'The Principles We Live By';
        $this->section_subtitle = $s?->subtitle      ?? '';
    }

    // ── Tab ───────────────────────────────────────────────────────────────
    public function setTab(string $tab): void { $this->activeTab = $tab; }

    // ── Save section ──────────────────────────────────────────────────────
    public function saveSection(CoreValuesService $service): void
    {
        $this->validate([
            'section_label'    => 'required|string|max:80',
            'section_title'    => 'required|string|max:200',
            'section_subtitle' => 'nullable|string|max:400',
        ]);

        $service->saveSection([
            'section_label' => $this->section_label,
            'title'         => $this->section_title,
            'subtitle'      => $this->section_subtitle,
        ]);

        $this->resetErrorBag();
        session()->flash('success', 'Section header saved.');
    }

    // ── Value CRUD ────────────────────────────────────────────────────────
    public function openCreateValue(): void
    {
        $this->resetValueForm();
        $this->editingValueId = null;
        $this->showValueModal = true;
    }

    public function openEditValue(int $id, CoreValuesService $service): void
    {
        $this->resetValueForm();
        $v = $service->findValue($id);
        $this->editingValueId = $id;
        $this->v_icon  = $v->icon;
        $this->v_title = $v->title;
        $this->v_desc  = $v->description ?? '';
        $this->showValueModal = true;
    }

    public function saveValue(CoreValuesService $service): void
    {
        $this->validate([
            'v_icon'  => 'required|string|max:10',
            'v_title' => 'required|string|max:100',
            'v_desc'  => 'nullable|string|max:500',
        ]);

        $data      = ['icon' => $this->v_icon, 'title' => $this->v_title, 'description' => $this->v_desc];
        $wasEditing = $this->editingValueId;

        $wasEditing
            ? $service->updateValue($wasEditing, $data)
            : $service->createValue($data);

        $this->values        = $service->getValues()->toArray();
        $this->showValueModal = false;
        $this->resetValueForm();
        session()->flash('success', $wasEditing ? 'Value updated.' : 'Value created.');
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingValueId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteValue(CoreValuesService $service): void
    {
        if ($this->deletingValueId) {
            $service->deleteValue($this->deletingValueId);
            $this->values         = $service->getValues()->toArray();
            $this->showDeleteModal = false;
            $this->deletingValueId = null;
            session()->flash('success', 'Value deleted.');
        }
    }

    public function toggleValue(int $id, CoreValuesService $service): void
    {
        $service->toggleValue($id);
        $this->values = $service->getValues()->toArray();
    }

    public function reorderValues(array $ids, CoreValuesService $service): void
    {
        $service->reorderValues($ids);
        $this->values = $service->getValues()->toArray();
    }

    private function resetValueForm(): void
    {
        $this->v_icon         = '';
        $this->v_title        = '';
        $this->v_desc         = '';
        $this->editingValueId = null;
        $this->resetErrorBag();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.about.core-values');
    }
}