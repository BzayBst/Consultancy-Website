<?php

namespace App\Livewire\Admin;

use App\Models\AppointmentSubmission;
use App\Models\ContactSubmission;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class LeadManager extends Component
{
    use WithPagination;

    // ─── Tab & Routing ────────────────────────────────────────────────────────
    #[Url(as: 'tab')]
    public string $activeTab = 'all';

    // ─── Filters ──────────────────────────────────────────────────────────────
    #[Url]
    public string $search = '';

    #[Url]
    public string $statusFilter = '';

    #[Url]
    public string $serviceFilter = '';

    #[Url]
    public string $destinationFilter = '';

    #[Url]
    public string $dateFrom = '';

    #[Url]
    public string $dateTo = '';

    #[Url]
    public string $sortBy = 'created_at';

    #[Url]
    public string $sortDir = 'desc';

    // ─── Detail / Slide-over ─────────────────────────────────────────────────
    public ?int $selectedId = null;
    public ?string $selectedType = null; // 'contact' | 'appointment'
    public bool $showDetail = false;

    // ─── Inline note editor ───────────────────────────────────────────────────
    public string $newNote = '';
    public bool $editingNote = false;

    // ─── Bulk actions ─────────────────────────────────────────────────────────
    public array $selected = [];
    public bool $selectAll = false;

    // ─── Status constants ─────────────────────────────────────────────────────
    const STATUS_NEW       = 'new';
    const STATUS_IN_REVIEW = 'in_review';
    const STATUS_CONTACTED = 'contacted';
    const STATUS_CONVERTED = 'converted';
    const STATUS_CLOSED    = 'closed';

    const STATUSES = [
        self::STATUS_NEW       => ['label' => 'New',        'color' => 'blue'],
        self::STATUS_IN_REVIEW => ['label' => 'In Review',  'color' => 'amber'],
        self::STATUS_CONTACTED => ['label' => 'Contacted',  'color' => 'purple'],
        self::STATUS_CONVERTED => ['label' => 'Converted',  'color' => 'green'],
        self::STATUS_CLOSED    => ['label' => 'Closed',     'color' => 'gray'],
    ];

    // ─── Pagination ───────────────────────────────────────────────────────────
    public int $perPage = 20;

    // ─────────────────────────────────────────────────────────────────────────
    // Computed: Leads query
    // ─────────────────────────────────────────────────────────────────────────

    #[Computed]
    public function leads(): \Illuminate\Pagination\LengthAwarePaginator
    {
        $contacts = $this->buildContactQuery();
        $appointments = $this->buildAppointmentQuery();

        if ($this->activeTab === 'contacts') {
            return $contacts->paginate($this->perPage);
        }

        if ($this->activeTab === 'appointments') {
            return $appointments->paginate($this->perPage);
        }

        // Unified "all" tab — merge via union + manual sort/paginate
        return $this->mergedLeads();
    }

    #[Computed]
    public function selectedLead(): ?array
    {
        if (! $this->selectedId || ! $this->selectedType) {
            return null;
        }

        $model = $this->selectedType === 'contact'
            ? ContactSubmission::find($this->selectedId)
            : AppointmentSubmission::find($this->selectedId);

        return $model ? $this->normalizeLead($model, $this->selectedType) : null;
    }

    #[Computed]
    public function stats(): array
    {
        return [
            'total'        => ContactSubmission::count() + AppointmentSubmission::count(),
            'unread'       => ContactSubmission::where('is_read', false)->count()
                            + AppointmentSubmission::where('is_read', false)->count(),
            'new'          => ContactSubmission::where('status', self::STATUS_NEW)->count()
                            + AppointmentSubmission::where('status', self::STATUS_NEW)->count(),
            'converted'    => ContactSubmission::where('status', self::STATUS_CONVERTED)->count()
                            + AppointmentSubmission::where('status', self::STATUS_CONVERTED)->count(),
            'contacts'     => ContactSubmission::count(),
            'appointments' => AppointmentSubmission::count(),
            'today'        => ContactSubmission::whereDate('created_at', today())->count()
                            + AppointmentSubmission::whereDate('created_at', today())->count(),
        ];
    }

    #[Computed]
    public function availableServices(): array
    {
        $c = ContactSubmission::select('service')->whereNotNull('service')->distinct()->pluck('service');
        $a = AppointmentSubmission::select('service')->whereNotNull('service')->distinct()->pluck('service');

        return $c->merge($a)->unique()->sort()->values()->toArray();
    }

    #[Computed]
    public function availableDestinations(): array
    {
        $c = ContactSubmission::select('destination')->whereNotNull('destination')->distinct()->pluck('destination');
        $a = AppointmentSubmission::select('destination')->whereNotNull('destination')->distinct()->pluck('destination');

        return $c->merge($a)->unique()->sort()->values()->toArray();
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Query builders
    // ─────────────────────────────────────────────────────────────────────────

    private function buildContactQuery()
    {
        return ContactSubmission::query()
            ->when($this->search, fn ($q) =>
                $q->where(fn ($inner) =>
                    $inner->where('first_name', 'like', "%{$this->search}%")
                          ->orWhere('last_name',  'like', "%{$this->search}%")
                          ->orWhere('email',       'like', "%{$this->search}%")
                          ->orWhere('phone',       'like', "%{$this->search}%")
                          ->orWhere('message',     'like', "%{$this->search}%")
                )
            )
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->serviceFilter, fn ($q) => $q->where('service', $this->serviceFilter))
            ->when($this->destinationFilter, fn ($q) => $q->where('destination', $this->destinationFilter))
            ->when($this->dateFrom, fn ($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo,   fn ($q) => $q->whereDate('created_at', '<=', $this->dateTo))
            ->orderBy($this->sortBy, $this->sortDir);
    }

    private function buildAppointmentQuery()
    {
        return AppointmentSubmission::query()
            ->when($this->search, fn ($q) =>
                $q->where(fn ($inner) =>
                    $inner->where('first_name',   'like', "%{$this->search}%")
                          ->orWhere('last_name',   'like', "%{$this->search}%")
                          ->orWhere('email',        'like', "%{$this->search}%")
                          ->orWhere('phone',        'like', "%{$this->search}%")
                          ->orWhere('reference',    'like', "%{$this->search}%")
                          ->orWhere('notes',        'like', "%{$this->search}%")
                )
            )
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->serviceFilter, fn ($q) => $q->where('service', $this->serviceFilter))
            ->when($this->destinationFilter, fn ($q) => $q->where('destination', $this->destinationFilter))
            ->when($this->dateFrom, fn ($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo,   fn ($q) => $q->whereDate('created_at', '<=', $this->dateTo))
            ->orderBy($this->sortBy, $this->sortDir);
    }

    /**
     * Merge both models for the "All" tab.
     * We collect both, tag each with type, sort in PHP, then manually paginate.
     */
    private function mergedLeads(): \Illuminate\Pagination\LengthAwarePaginator
    {
        $contacts = $this->buildContactQuery()
            ->get()
            ->map(fn ($m) => $this->normalizeLead($m, 'contact'));

        $appointments = $this->buildAppointmentQuery()
            ->get()
            ->map(fn ($m) => $this->normalizeLead($m, 'appointment'));

        $merged = $contacts->merge($appointments)->sortBy(
            fn ($item) => $item[$this->sortBy] ?? $item['created_at'],
            SORT_REGULAR,
            $this->sortDir === 'desc',
        )->values();

        // Manual paginator
        $page    = $this->getPage();
        $total   = $merged->count();
        $items   = $merged->slice(($page - 1) * $this->perPage, $this->perPage)->values();

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items, $total, $this->perPage, $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    /**
     * Normalize any model into a unified array shape for the view.
     */
    public function normalizeLead($model, string $type): array
    {
        $base = [
            'id'          => $model->id,
            'type'        => $type,
            'type_label'  => $type === 'contact' ? 'Contact' : 'Consultation',
            'first_name'  => $model->first_name,
            'last_name'   => $model->last_name,
            'full_name'   => trim("{$model->first_name} {$model->last_name}"),
            'email'       => $model->email,
            'phone'       => $model->phone ?? null,
            'destination' => $model->destination ?? null,
            'service'     => $model->service ?? null,
            'status'      => $model->status ?? self::STATUS_NEW,
            'is_read'     => $model->is_read,
            'notes'       => $model->internal_notes ?? null,
            'created_at'  => $model->created_at,
        ];

        if ($type === 'contact') {
            $base['message']  = $model->message ?? null;
            $base['branch']   = null;
            $base['reference']= null;
            $base['education']= null;
            $base['appointment_date'] = null;
            $base['appointment_time'] = null;
        } else {
            $base['message']  = $model->notes ?? null;
            $base['branch']   = $model->branch ?? null;
            $base['reference']= $model->reference ?? null;
            $base['education']= $model->education ?? null;
            $base['appointment_date'] = $model->appointment_date?->format('M j, Y') ?? null;
            $base['appointment_time'] = $model->appointment_time ?? null;
        }

        return $base;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Actions
    // ─────────────────────────────────────────────────────────────────────────

    public function openDetail(int $id, string $type): void
    {
        $this->selectedId   = $id;
        $this->selectedType = $type;
        $this->showDetail   = true;
        $this->newNote      = '';
        $this->editingNote  = false;

        // Auto-mark as read
        $this->markRead($id, $type);

        unset($this->selectedLead); // clear computed cache
    }

    public function closeDetail(): void
    {
        $this->showDetail   = false;
        $this->selectedId   = null;
        $this->selectedType = null;
        $this->editingNote  = false;
        $this->newNote      = '';
    }

    public function updateStatus(int $id, string $type, string $status): void
    {
        abort_unless(array_key_exists($status, self::STATUSES), 422, 'Invalid status.');

        $model = $type === 'contact'
            ? ContactSubmission::findOrFail($id)
            : AppointmentSubmission::findOrFail($id);

        $model->update(['status' => $status]);

        unset($this->leads, $this->selectedLead, $this->stats);

        $this->dispatch('notify', message: 'Status updated.', type: 'success');
    }

    public function markRead(int $id, string $type): void
    {
        $model = $type === 'contact'
            ? ContactSubmission::find($id)
            : AppointmentSubmission::find($id);

        if ($model && ! $model->is_read) {
            $model->update(['is_read' => true]);
            unset($this->leads, $this->stats);
        }
    }

    public function toggleRead(int $id, string $type): void
    {
        $model = $type === 'contact'
            ? ContactSubmission::findOrFail($id)
            : AppointmentSubmission::findOrFail($id);

        $model->update(['is_read' => ! $model->is_read]);
        unset($this->leads, $this->selectedLead, $this->stats);
    }

    public function saveNote(): void
    {
        $this->validate(['newNote' => 'required|string|max:5000']);

        $model = $this->selectedType === 'contact'
            ? ContactSubmission::findOrFail($this->selectedId)
            : AppointmentSubmission::findOrFail($this->selectedId);

        $existing   = $model->internal_notes ?? '';
        $timestamp  = now()->format('M j, Y g:i A');
        $separator  = $existing ? "\n\n" : '';
        $model->update([
            'internal_notes' => $existing . $separator . "[{$timestamp}]\n" . $this->newNote,
        ]);

        $this->newNote     = '';
        $this->editingNote = false;
        unset($this->selectedLead);

        $this->dispatch('notify', message: 'Note saved.', type: 'success');
    }

    public function deleteNote(int $id, string $type): void
    {
        $model = $type === 'contact'
            ? ContactSubmission::findOrFail($id)
            : AppointmentSubmission::findOrFail($id);

        $model->update(['internal_notes' => null]);
        unset($this->selectedLead);

        $this->dispatch('notify', message: 'Notes cleared.', type: 'success');
    }

    // ─── Bulk ─────────────────────────────────────────────────────────────────

    public function bulkMarkRead(): void
    {
        foreach ($this->selected as $key) {
            [$type, $id] = explode(':', $key);
            $this->markRead((int) $id, $type);
        }
        $this->selected   = [];
        $this->selectAll  = false;
        unset($this->leads, $this->stats);
        $this->dispatch('notify', message: 'Marked as read.', type: 'success');
    }

    public function bulkUpdateStatus(string $status): void
    {
        abort_unless(array_key_exists($status, self::STATUSES), 422);

        foreach ($this->selected as $key) {
            [$type, $id] = explode(':', $key);
            $this->updateStatus((int) $id, $type, $status);
        }
        $this->selected  = [];
        $this->selectAll = false;
        unset($this->leads, $this->stats);
        $this->dispatch('notify', message: 'Status updated for selected leads.', type: 'success');
    }

    // ─── Filter helpers ───────────────────────────────────────────────────────

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->resetPage();
        $this->selected  = [];
        $this->selectAll = false;
        unset($this->leads);
    }

    public function sortBy(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy  = $column;
            $this->sortDir = 'desc';
        }
        $this->resetPage();
        unset($this->leads);
    }

    public function resetFilters(): void
    {
        $this->search          = '';
        $this->statusFilter    = '';
        $this->serviceFilter   = '';
        $this->destinationFilter = '';
        $this->dateFrom        = '';
        $this->dateTo          = '';
        $this->sortBy          = 'created_at';
        $this->sortDir         = 'desc';
        $this->resetPage();
        unset($this->leads);
    }

    public function updatedSearch(): void    { $this->resetPage(); unset($this->leads); }
    public function updatedStatusFilter(): void { $this->resetPage(); unset($this->leads); }
    public function updatedServiceFilter(): void { $this->resetPage(); unset($this->leads); }
    public function updatedDestinationFilter(): void { $this->resetPage(); unset($this->leads); }
    public function updatedDateFrom(): void { $this->resetPage(); unset($this->leads); }
    public function updatedDateTo(): void { $this->resetPage(); unset($this->leads); }

    public function updatedSelectAll(bool $value): void
    {
        if ($value) {
            $this->selected = $this->leads->map(
                fn ($lead) => "{$lead['type']}:{$lead['id']}"
            )->toArray();
        } else {
            $this->selected = [];
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Render
    // ─────────────────────────────────────────────────────────────────────────

    public function render()
    {
        return view('livewire.admin.lead-manager', [
            'leads'                 => $this->leads,
            'stats'                 => $this->stats,
            'statuses'              => self::STATUSES,
            'selectedLead'          => $this->selectedLead,
            'availableServices'     => $this->availableServices,
            'availableDestinations' => $this->availableDestinations,
            'activeTab'             => $this->activeTab,
            'sortBy'                => $this->sortBy,
            'sortDir'               => $this->sortDir,
            'selected'              => $this->selected,
            'selectedId'            => $this->selectedId,
            'selectedType'          => $this->selectedType,
            'showDetail'            => $this->showDetail,
            'editingNote'           => $this->editingNote,
        ])->layout('admin.layouts.app', ['title' => 'Lead Manager']);
    }
}
