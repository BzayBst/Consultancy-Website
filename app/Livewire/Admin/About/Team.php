<?php

namespace App\Livewire\Admin\About;


use App\Services\TeamService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('admin.layouts.app')]
#[Title('Team Page – HASU Admin')]
class Team extends Component
{
    use WithPagination, WithFileUploads;

    /* ------------------------------------------------------------------ */
    /*  List / filter state                                                 */
    /* ------------------------------------------------------------------ */

    public string $search  = '';
    public string $status  = '';       // '' | 'active' | 'inactive' | 'trashed'
    public int    $perPage = 10;

    /* ------------------------------------------------------------------ */
    /*  Modal state                                                         */
    /* ------------------------------------------------------------------ */

    public bool   $showModal   = false;
    public bool   $isEdit      = false;
    public ?int   $editingId   = null;

    /* ------------------------------------------------------------------ */
    /*  Form fields                                                         */
    /* ------------------------------------------------------------------ */

    public string $name        = '';
    public string $slug        = '';
    public string $designation = '';
    public string $bio         = '';
    public string $email       = '';
    public string $phone       = '';
    public int    $order       = 0;
    public bool   $is_active   = true;
    public bool   $removePhoto = false;

    public string $social_facebook = '';
    public string $social_linkedin = '';
    public string $social_twitter  = '';

    public        $photo;                  // Livewire temp upload
    public ?string $existingPhoto = null;  // Current stored path

    /* ------------------------------------------------------------------ */
    /*  Delete / Restore confirm                                            */
    /* ------------------------------------------------------------------ */

    public ?int $confirmingDeleteId  = null;
    public ?int $confirmingRestoreId = null;

    /* ------------------------------------------------------------------ */
    /*  Query string                                                        */
    /* ------------------------------------------------------------------ */

    protected $queryString = [
        'search'  => ['except' => ''],
        'status'  => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    /* ------------------------------------------------------------------ */
    /*  Validation                                                          */
    /* ------------------------------------------------------------------ */

    protected function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'max:100'],
            'slug'            => ['nullable', 'string', 'max:120'],
            'designation'     => ['required', 'string', 'max:100'],
            'bio'             => ['nullable', 'string', 'max:500'],
            'email'           => ['nullable', 'email', 'max:150'],
            'phone'           => ['nullable', 'string', 'max:20'],
            'order'           => ['required', 'integer', 'min:0'],
            'is_active'       => ['boolean'],
            'photo'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'social_facebook' => ['nullable', 'url', 'max:255'],
            'social_linkedin' => ['nullable', 'url', 'max:255'],
            'social_twitter'  => ['nullable', 'url', 'max:255'],
        ];
    }

    protected $validationAttributes = [
        'name'        => 'full name',
        'designation' => 'designation / role',
        'photo'       => 'profile photo',
    ];

    /* ------------------------------------------------------------------ */
    /*  Lifecycle hooks                                                     */
    /* ------------------------------------------------------------------ */

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingStatus(): void { $this->resetPage(); }

    public function updatedName(string $value): void
    {
        // Auto-fill slug only on create
        if (! $this->isEdit) {
            $this->slug = \Illuminate\Support\Str::slug($value);
        }
    }

    /* ------------------------------------------------------------------ */
    /*  Modal open / close                                                  */
    /* ------------------------------------------------------------------ */

    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEdit    = false;
        $this->showModal = true;
    }

    public function openEdit(int $id, TeamService $service): void
    {
        $this->resetForm();
        $this->isEdit    = true;
        $this->editingId = $id;

        $team = $service->find($id);

        $this->name        = $team->name;
        $this->slug        = $team->slug;
        $this->designation = $team->designation;
        $this->bio         = $team->bio         ?? '';
        $this->email       = $team->email        ?? '';
        $this->phone       = $team->phone        ?? '';
        $this->order       = $team->order;
        $this->is_active   = $team->is_active;
        $this->existingPhoto = $team->photo;

        $social = $team->social_links ?? [];
        $this->social_facebook = $social['facebook'] ?? '';
        $this->social_linkedin = $social['linkedin'] ?? '';
        $this->social_twitter  = $social['twitter']  ?? '';

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    /* ------------------------------------------------------------------ */
    /*  Save (create + update)                                              */
    /* ------------------------------------------------------------------ */

    public function save(TeamService $service): void
    {
        $this->validate();

        $data = [
            'name'         => $this->name,
            'slug'         => $this->slug ?: null,
            'designation'  => $this->designation,
            'bio'          => $this->bio   ?: null,
            'email'        => $this->email ?: null,
            'phone'        => $this->phone ?: null,
            'order'        => $this->order,
            'is_active'    => $this->is_active,
            'social_links' => array_filter([
                'facebook' => $this->social_facebook,
                'linkedin' => $this->social_linkedin,
                'twitter'  => $this->social_twitter,
            ]),
        ];

        if ($this->isEdit) {
            $service->update($this->editingId, $data, $this->photo ?: null, $this->removePhoto);
            $message = 'Team member updated successfully.';
        } else {
            $service->create($data, $this->photo ?: null);
            $message = 'Team member added successfully.';
        }

        $this->closeModal();
        $this->dispatch('notify', type: 'success', message: $message);
    }

    /* ------------------------------------------------------------------ */
    /*  Toggle active inline                                                */
    /* ------------------------------------------------------------------ */

    public function toggleActive(int $id, TeamService $service): void
    {
        $team = $service->find($id);
        $service->update($id, ['is_active' => ! $team->is_active]);
        $this->dispatch('notify', type: 'success', message: 'Status updated.');
    }

    /* ------------------------------------------------------------------ */
    /*  Delete                                                              */
    /* ------------------------------------------------------------------ */

    public function confirmDelete(int $id): void
    {
        $this->confirmingDeleteId = $id;
    }

    public function cancelDelete(): void
    {
        $this->confirmingDeleteId = null;
    }

    public function delete(TeamService $service): void
    {
        if (! $this->confirmingDeleteId) return;
        $service->delete($this->confirmingDeleteId);
        $this->confirmingDeleteId = null;
        $this->dispatch('notify', type: 'success', message: 'Team member moved to trash.');
    }

    /* ------------------------------------------------------------------ */
    /*  Restore                                                             */
    /* ------------------------------------------------------------------ */

    public function confirmRestore(int $id): void
    {
        $this->confirmingRestoreId = $id;
    }

    public function cancelRestore(): void
    {
        $this->confirmingRestoreId = null;
    }

    public function restore(TeamService $service): void
    {
        if (! $this->confirmingRestoreId) return;
        $service->restore($this->confirmingRestoreId);
        $this->confirmingRestoreId = null;
        $this->dispatch('notify', type: 'success', message: 'Team member restored.');
    }

    /* ------------------------------------------------------------------ */
    /*  Helpers                                                             */
    /* ------------------------------------------------------------------ */

    private function resetForm(): void
    {
        $this->resetValidation();
        $this->editingId      = null;
        $this->name           = '';
        $this->slug           = '';
        $this->designation    = '';
        $this->bio            = '';
        $this->email          = '';
        $this->phone          = '';
        $this->order          = 0;
        $this->is_active      = true;
        $this->removePhoto    = false;
        $this->existingPhoto  = null;
        $this->photo          = null;
        $this->social_facebook = '';
        $this->social_linkedin = '';
        $this->social_twitter  = '';
    }

    /* ------------------------------------------------------------------ */
    /*  Render                                                              */
    /* ------------------------------------------------------------------ */

    public function render(TeamService $service)
    {
        return view('livewire.admin.about.team', [
            'teams' => $service->list($this->perPage, $this->search, $this->status),
        ]);
    }
}
