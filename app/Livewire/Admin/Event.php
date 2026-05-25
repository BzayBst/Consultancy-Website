<?php

namespace App\Livewire\Admin;

use App\Models\Event as EventModel;
use App\Services\EventService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Event extends Component
{
    use WithPagination, WithFileUploads;

    /* ------------------------------------------------------------------ */
    /*  Tab                                                                 */
    /* ------------------------------------------------------------------ */
    public string $activeTab = 'events';

    /* ------------------------------------------------------------------ */
    /*  Section settings                                                    */
    /* ------------------------------------------------------------------ */
    public string $section_label = '';
    public string $title         = '';

    /* ------------------------------------------------------------------ */
    /*  List / filter state                                                 */
    /* ------------------------------------------------------------------ */
    public string $search       = '';
    public string $filterStatus = '';
    public string $filterActive = '';
    public int    $perPage      = 10;

    /* ------------------------------------------------------------------ */
    /*  Modal state                                                         */
    /* ------------------------------------------------------------------ */
    public bool  $showModal = false;
    public bool  $isEdit    = false;
    public ?int  $editingId = null;

    /* ------------------------------------------------------------------ */
    /*  Form fields — basic                                                 */
    /* ------------------------------------------------------------------ */
    public string $ev_title        = '';
    public string $description     = '';
    public string $long_description= '';
    public string $highlights_raw  = ''; // newline-separated list → stored as JSON array
    public string $event_date      = '';
    public string $event_end_date  = '';
    public string $event_time      = '';
    public string $status          = 'upcoming';
    public string $location        = '';
    public string $organizer       = '';
    public string $learn_more_url  = '';
    public bool   $is_active       = true;
    public bool   $is_featured     = false;
    public bool   $removePhoto     = false;

    public        $photo;
    public ?string $existingPhoto  = null;

    /* ------------------------------------------------------------------ */
    /*  Confirm modals                                                      */
    /* ------------------------------------------------------------------ */
    public ?int $confirmingDeleteId  = null;
    public ?int $confirmingRestoreId = null;

    /* ------------------------------------------------------------------ */
    /*  Query string                                                        */
    /* ------------------------------------------------------------------ */
    protected $queryString = [
        'search'       => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterActive' => ['except' => ''],
        'perPage'      => ['except' => 10],
    ];

    /* ------------------------------------------------------------------ */
    /*  Validation                                                          */
    /* ------------------------------------------------------------------ */
    protected function rules(): array
    {
        return [
            'ev_title'         => ['required', 'string', 'max:200'],
            'description'      => ['nullable', 'string', 'max:400'],
            'long_description' => ['nullable', 'string'],
            'highlights_raw'   => ['nullable', 'string'],
            'event_date'       => ['required', 'date'],
            'event_end_date'   => ['nullable', 'date', 'after_or_equal:event_date'],
            'event_time'       => ['nullable', 'string'],
            'status'           => ['required', 'in:upcoming,ongoing,past'],
            'location'         => ['nullable', 'string', 'max:200'],
            'organizer'        => ['nullable', 'string', 'max:200'],
            'learn_more_url'   => ['nullable', 'url', 'max:500'],
            'is_active'        => ['boolean'],
            'is_featured'      => ['boolean'],
            'photo'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ];
    }

    protected $validationAttributes = [
        'ev_title'   => 'event title',
        'event_date' => 'event date',
        'photo'      => 'event image',
    ];

    /* ------------------------------------------------------------------ */
    /*  Lifecycle                                                           */
    /* ------------------------------------------------------------------ */
    public function mount(EventService $service): void
    {
        $settings            = $service->getSectionSettings();
        $this->section_label = $settings['section_label'] ?? '';
        $this->title         = $settings['title']         ?? '';
    }

    public function updatingSearch(): void       { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }
    public function updatingFilterActive(): void { $this->resetPage(); }

    /* ------------------------------------------------------------------ */
    /*  Tabs                                                                */
    /* ------------------------------------------------------------------ */
    public function setTab(string $tab): void { $this->activeTab = $tab; }

    /* ------------------------------------------------------------------ */
    /*  Section settings                                                    */
    /* ------------------------------------------------------------------ */
    public function saveSection(EventService $service): void
    {
        $this->validate([
            'section_label' => ['nullable', 'string', 'max:60'],
            'title'         => ['required', 'string', 'max:150'],
        ]);

        $service->saveSectionSettings([
            'section_label' => $this->section_label,
            'title'         => $this->title,
        ]);

        session()->flash('success', 'Section settings saved.');
    }

    /* ------------------------------------------------------------------ */
    /*  Modal open / close                                                  */
    /* ------------------------------------------------------------------ */
    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEdit    = false;
        $this->showModal = true;
        $this->activeTab = 'events';
    }

    public function openEdit(int $id, EventService $service): void
    {
        $this->resetForm();
        $this->isEdit    = true;
        $this->editingId = $id;

        $event = $service->find($id);

        $this->ev_title         = $event->title;
        $this->description      = $event->description      ?? '';
        $this->long_description = $event->long_description ?? '';
        $this->highlights_raw   = $event->highlights
                                    ? implode("\n", $event->highlights)
                                    : '';
        $this->event_date       = $event->event_date       ? $event->event_date->format('Y-m-d')     : '';
        $this->event_end_date   = $event->event_end_date   ? $event->event_end_date->format('Y-m-d') : '';
        $this->event_time       = $event->event_time       ?? '';
        $this->status           = $event->status           ?? 'upcoming';
        $this->location         = $event->location         ?? '';
        $this->organizer        = $event->organizer        ?? '';
        $this->learn_more_url   = $event->learn_more_url   ?? '';
        $this->is_active        = $event->is_active;
        $this->is_featured      = $event->is_featured;
        $this->existingPhoto    = $event->image;
        $this->showModal        = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    /* ------------------------------------------------------------------ */
    /*  Save (create + update)                                              */
    /* ------------------------------------------------------------------ */
    public function save(EventService $service): void
    {
        $this->validate();

        // Convert newline-separated highlights into array
        $highlights = collect(explode("\n", $this->highlights_raw))
            ->map(fn ($l) => trim($l))
            ->filter()
            ->values()
            ->toArray();

        $data = [
            'title'            => $this->ev_title,
            'description'      => $this->description      ?: null,
            'long_description' => $this->long_description ?: null,
            'highlights'       => $highlights ?: null,
            'event_date'       => $this->event_date,
            'event_end_date'   => $this->event_end_date   ?: null,
            'event_time'       => $this->event_time       ?: null,
            'status'           => $this->status,
            'location'         => $this->location         ?: null,
            'organizer'        => $this->organizer        ?: null,
            'learn_more_url'   => $this->learn_more_url   ?: null,
            'is_active'        => $this->is_active,
            'is_featured'      => $this->is_featured,
        ];

        if ($this->isEdit) {
            $service->update($this->editingId, $data, $this->photo ?: null, $this->removePhoto);
            $message = 'Event updated successfully.';
        } else {
            $service->create($data, $this->photo ?: null);
            $message = 'Event created successfully.';
        }

        $this->closeModal();
        session()->flash('success', $message);
    }

    /* ------------------------------------------------------------------ */
    /*  Toggles                                                             */
    /* ------------------------------------------------------------------ */
    public function toggleActive(int $id, EventService $service): void
    {
        $event = $service->find($id);
        $service->update($id, ['is_active' => ! $event->is_active]);
    }

    public function toggleFeatured(int $id, EventService $service): void
    {
        $event = $service->find($id);
        if (! $event->is_featured) {
            EventModel::where('is_featured', true)->update(['is_featured' => false]);
        }
        $service->update($id, ['is_featured' => ! $event->is_featured]);
    }

    /* ------------------------------------------------------------------ */
    /*  Delete                                                              */
    /* ------------------------------------------------------------------ */
    public function confirmDelete(int $id): void  { $this->confirmingDeleteId = $id; }
    public function cancelDelete(): void          { $this->confirmingDeleteId = null; }

    public function delete(EventService $service): void
    {
        if (! $this->confirmingDeleteId) return;
        $service->delete($this->confirmingDeleteId);
        $this->confirmingDeleteId = null;
        session()->flash('success', 'Event moved to trash.');
    }

    /* ------------------------------------------------------------------ */
    /*  Restore                                                             */
    /* ------------------------------------------------------------------ */
    public function confirmRestore(int $id): void { $this->confirmingRestoreId = $id; }
    public function cancelRestore(): void         { $this->confirmingRestoreId = null; }

    public function restore(EventService $service): void
    {
        if (! $this->confirmingRestoreId) return;
        $service->restore($this->confirmingRestoreId);
        $this->confirmingRestoreId = null;
        session()->flash('success', 'Event restored.');
    }

    /* ------------------------------------------------------------------ */
    /*  Helpers                                                             */
    /* ------------------------------------------------------------------ */
    private function resetForm(): void
    {
        $this->resetValidation();
        $this->editingId        = null;
        $this->ev_title         = '';
        $this->description      = '';
        $this->long_description = '';
        $this->highlights_raw   = '';
        $this->event_date       = '';
        $this->event_end_date   = '';
        $this->event_time       = '';
        $this->status           = 'upcoming';
        $this->location         = '';
        $this->organizer        = '';
        $this->learn_more_url   = '';
        $this->is_active        = true;
        $this->is_featured      = false;
        $this->removePhoto      = false;
        $this->existingPhoto    = null;
        $this->photo            = null;
    }

    /* ------------------------------------------------------------------ */
    /*  Render                                                              */
    /* ------------------------------------------------------------------ */
    public function render(EventService $service)
    {
        return view('livewire.admin.event', [
            'events' => $service->list(
                $this->perPage,
                $this->search,
                $this->filterStatus,
                $this->filterActive,
            ),
        ])->layout('admin.layouts.app', ['title' => 'Events']);
    }
}