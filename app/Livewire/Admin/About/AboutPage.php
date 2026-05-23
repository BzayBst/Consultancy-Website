<?php

namespace App\Livewire\Admin\About;

use App\Services\AboutService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('admin.layouts.app')]
#[Title('About Page – HASU Admin')]
class AboutPage extends Component
{
    use WithFileUploads;

    // ── Active tab ────────────────────────────────────────────────────────
    public string $activeTab = 'hero';

    // ─────────────────────────────────────────────────────────────────────
    // TAB 1 — PAGE HERO
    // ─────────────────────────────────────────────────────────────────────
    public string $hero_badge     = '';
    public string $hero_title     = '';
    public string $hero_highlight = '';
    public string $hero_subtitle  = '';

    // ─────────────────────────────────────────────────────────────────────
    // TAB 2 — OUR STORY
    // ─────────────────────────────────────────────────────────────────────
    public ?string $story_image_current   = null;
    public $story_image_upload            = null;
    public string $story_float_icon       = '🏆';
    public string $story_float_title      = 'Best Consultancy';
    public string $story_float_subtitle   = 'Bhairahawa Region, 2023';
    public string $story_section_label    = 'Our Story';
    public string $story_section_title    = 'How HASU Began Its Journey';
    public string $story_paragraph_1      = '';
    public string $story_paragraph_2      = '';

    // Milestones list + modal
    public array $milestones          = [];
    public bool  $showMilestoneModal  = false;
    public bool  $showMilestoneDelete = false;
    public ?int  $editingMilestoneId  = null;
    public ?int  $deletingMilestoneId = null;
    public string $ms_year  = '';
    public string $ms_title = '';
    public string $ms_desc  = '';

    // ─────────────────────────────────────────────────────────────────────
    // TAB 3 — STATS
    // ─────────────────────────────────────────────────────────────────────
    public array $stats           = [];
    public bool  $showStatModal   = false;
    public bool  $showStatDelete  = false;
    public ?int  $editingStatId   = null;
    public ?int  $deletingStatId  = null;
    public string $st_number = '';
    public string $st_accent = '+';
    public string $st_label  = '';

    // ─────────────────────────────────────────────────────────────────────
    // TAB 4 — MISSION / VISION / PURPOSE
    // ─────────────────────────────────────────────────────────────────────
    public array $mvCards          = [];
    public bool  $showMvModal      = false;
    public bool  $showMvDelete     = false;
    public ?int  $editingMvId      = null;
    public ?int  $deletingMvId     = null;
    public string $mv_icon  = '';
    public string $mv_title = '';
    public string $mv_body  = '';

    // ── Rules ──────────────────────────────────────────────────────────────
    protected function rules(): array
    {
        return [
            'hero_badge'     => 'nullable|string|max:150',
            'hero_title'     => 'required|string|max:200',
            'hero_highlight' => 'nullable|string|max:80',
            'hero_subtitle'  => 'nullable|string|max:400',

            'story_image_upload'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'story_float_icon'     => 'nullable|string|max:10',
            'story_float_title'    => 'nullable|string|max:80',
            'story_float_subtitle' => 'nullable|string|max:80',
            'story_section_label'  => 'nullable|string|max:80',
            'story_section_title'  => 'nullable|string|max:150',
            'story_paragraph_1'    => 'nullable|string|max:1500',
            'story_paragraph_2'    => 'nullable|string|max:1500',

            'ms_year'  => 'required|string|max:10',
            'ms_title' => 'required|string|max:150',
            'ms_desc'  => 'nullable|string|max:500',

            'st_number' => 'required|string|max:20',
            'st_accent' => 'required|string|max:5',
            'st_label'  => 'required|string|max:80',

            'mv_icon'  => 'required|string|max:10',
            'mv_title' => 'required|string|max:100',
            'mv_body'  => 'required|string|max:600',
        ];
    }

    // ── Mount ─────────────────────────────────────────────────────────────
    public function mount(AboutService $service): void
    {
        $this->loadHero($service);
        $this->loadStory($service);
        $this->loadStats($service);
        $this->loadMvCards($service);
        $this->milestones = $service->getMilestones()->toArray();
    }

    private function loadHero(AboutService $service): void
    {
        $hero = $service->getHero();
        $this->hero_badge     = $hero?->badge     ?? '';
        $this->hero_title     = $hero?->title     ?? 'Your Trusted Partner in';
        $this->hero_highlight = $hero?->highlight ?? 'Global Education';
        $this->hero_subtitle  = $hero?->subtitle  ?? '';
    }

    private function loadStory(AboutService $service): void
    {
        $s = $service->getStory();
        if (! $s) return;
        $this->story_image_current   = $s->image_path;
        $this->story_float_icon      = $s->float_badge_icon     ?? '🏆';
        $this->story_float_title     = $s->float_badge_title    ?? 'Best Consultancy';
        $this->story_float_subtitle  = $s->float_badge_subtitle ?? 'Bhairahawa Region, 2023';
        $this->story_section_label   = $s->section_label        ?? 'Our Story';
        $this->story_section_title   = $s->section_title        ?? 'How HASU Began Its Journey';
        $this->story_paragraph_1     = $s->paragraph_1          ?? '';
        $this->story_paragraph_2     = $s->paragraph_2          ?? '';
    }

    private function loadStats(AboutService $service): void
    {
        $this->stats = $service->getStats()->toArray();
    }

    private function loadMvCards(AboutService $service): void
    {
        $this->mvCards = $service->getMvCards()->toArray();
    }

    // ── Tab ───────────────────────────────────────────────────────────────
    public function setTab(string $tab): void { $this->activeTab = $tab; }

    // ══════════════════════════════════════════════════════════════════════
    // HERO SAVE
    // ══════════════════════════════════════════════════════════════════════
    public function saveHero(AboutService $service): void
    {
        $this->validateOnly(['hero_badge','hero_title','hero_highlight','hero_subtitle']);
        $service->saveHero([
            'badge'     => $this->hero_badge,
            'title'     => $this->hero_title,
            'highlight' => $this->hero_highlight,
            'subtitle'  => $this->hero_subtitle,
        ]);
        session()->flash('success', 'Page hero saved.');
    }

    // ══════════════════════════════════════════════════════════════════════
    // STORY SAVE
    // ══════════════════════════════════════════════════════════════════════
    public function saveStory(AboutService $service): void
    {
        $this->validateOnly([
            'story_image_upload','story_float_icon','story_float_title',
            'story_float_subtitle','story_section_label','story_section_title',
            'story_paragraph_1','story_paragraph_2',
        ]);
        $story = $service->saveStory([
            'float_badge_icon'     => $this->story_float_icon,
            'float_badge_title'    => $this->story_float_title,
            'float_badge_subtitle' => $this->story_float_subtitle,
            'section_label'        => $this->story_section_label,
            'section_title'        => $this->story_section_title,
            'paragraph_1'          => $this->story_paragraph_1,
            'paragraph_2'          => $this->story_paragraph_2,
        ], $this->story_image_upload);

        $this->story_image_current = $story->image_path;
        $this->story_image_upload  = null;
        session()->flash('success', 'Story section saved.');
    }

    // ══════════════════════════════════════════════════════════════════════
    // MILESTONE CRUD
    // ══════════════════════════════════════════════════════════════════════
    public function openCreateMilestone(): void
    {
        $this->resetMilestoneForm();
        $this->editingMilestoneId = null;
        $this->showMilestoneModal = true;
    }

    public function openEditMilestone(int $id, AboutService $service): void
    {
        $m = $service->findMilestone($id);
        $this->editingMilestoneId = $id;
        $this->ms_year  = $m->year;
        $this->ms_title = $m->title;
        $this->ms_desc  = $m->description ?? '';
        $this->showMilestoneModal = true;
    }

    public function saveMilestone(AboutService $service): void
    {
        $this->validateOnly(['ms_year','ms_title','ms_desc']);
        $data = ['year' => $this->ms_year, 'title' => $this->ms_title, 'description' => $this->ms_desc];
        $this->editingMilestoneId
            ? $service->updateMilestone($this->editingMilestoneId, $data)
            : $service->createMilestone($data);

        $this->milestones         = $service->getMilestones()->toArray();
        $this->showMilestoneModal = false;
        $this->resetMilestoneForm();
        session()->flash('success', $this->editingMilestoneId ? 'Milestone updated.' : 'Milestone created.');
    }

    public function confirmDeleteMilestone(int $id): void
    {
        $this->deletingMilestoneId = $id;
        $this->showMilestoneDelete = true;
    }

    public function deleteMilestone(AboutService $service): void
    {
        if ($this->deletingMilestoneId) {
            $service->deleteMilestone($this->deletingMilestoneId);
            $this->milestones          = $service->getMilestones()->toArray();
            $this->showMilestoneDelete = false;
            $this->deletingMilestoneId = null;
            session()->flash('success', 'Milestone deleted.');
        }
    }

    public function toggleMilestone(int $id, AboutService $service): void
    {
        $service->toggleMilestone($id);
        $this->milestones = $service->getMilestones()->toArray();
    }

    public function reorderMilestones(array $ids, AboutService $service): void
    {
        $service->reorderMilestones($ids);
        $this->milestones = $service->getMilestones()->toArray();
    }

    private function resetMilestoneForm(): void
    {
        $this->editingMilestoneId = null;
        $this->ms_year = $this->ms_title = $this->ms_desc = '';
        $this->resetValidation(['ms_year','ms_title','ms_desc']);
    }

    // ══════════════════════════════════════════════════════════════════════
    // STAT CRUD
    // ══════════════════════════════════════════════════════════════════════
    public function openCreateStat(): void
    {
        $this->resetStatForm();
        $this->editingStatId = null;
        $this->showStatModal = true;
    }

    public function openEditStat(int $id, AboutService $service): void
    {
        $s = $service->findStat($id);
        $this->editingStatId = $id;
        $this->st_number = $s->number;
        $this->st_accent = $s->accent;
        $this->st_label  = $s->label;
        $this->showStatModal = true;
    }

    public function saveStat(AboutService $service): void
    {
        $this->validateOnly(['st_number','st_accent','st_label']);
        $data = ['number' => $this->st_number, 'accent' => $this->st_accent, 'label' => $this->st_label];
        $this->editingStatId
            ? $service->updateStat($this->editingStatId, $data)
            : $service->createStat($data);

        $this->stats         = $service->getStats()->toArray();
        $this->showStatModal = false;
        $this->resetStatForm();
        session()->flash('success', $this->editingStatId ? 'Stat updated.' : 'Stat created.');
    }

    public function confirmDeleteStat(int $id): void
    {
        $this->deletingStatId = $id;
        $this->showStatDelete = true;
    }

    public function deleteStat(AboutService $service): void
    {
        if ($this->deletingStatId) {
            $service->deleteStat($this->deletingStatId);
            $this->stats         = $service->getStats()->toArray();
            $this->showStatDelete = false;
            $this->deletingStatId = null;
            session()->flash('success', 'Stat deleted.');
        }
    }

    public function toggleStat(int $id, AboutService $service): void
    {
        $service->toggleStat($id);
        $this->stats = $service->getStats()->toArray();
    }

    public function reorderStats(array $ids, AboutService $service): void
    {
        $service->reorderStats($ids);
        $this->stats = $service->getStats()->toArray();
    }

    private function resetStatForm(): void
    {
        $this->editingStatId = null;
        $this->st_number = '';
        $this->st_accent = '+';
        $this->st_label  = '';
        $this->resetValidation(['st_number','st_accent','st_label']);
    }

    // ══════════════════════════════════════════════════════════════════════
    // MV CARD CRUD
    // ══════════════════════════════════════════════════════════════════════
    public function openCreateMv(): void
    {
        $this->resetMvForm();
        $this->editingMvId = null;
        $this->showMvModal = true;
    }

    public function openEditMv(int $id, AboutService $service): void
    {
        $c = $service->findMvCard($id);
        $this->editingMvId = $id;
        $this->mv_icon  = $c->icon;
        $this->mv_title = $c->title;
        $this->mv_body  = $c->body;
        $this->showMvModal = true;
    }

    public function saveMv(AboutService $service): void
    {
        $this->validateOnly(['mv_icon','mv_title','mv_body']);
        $data = ['icon' => $this->mv_icon, 'title' => $this->mv_title, 'body' => $this->mv_body];
        $this->editingMvId
            ? $service->updateMvCard($this->editingMvId, $data)
            : $service->createMvCard($data);

        $this->mvCards     = $service->getMvCards()->toArray();
        $this->showMvModal = false;
        $this->resetMvForm();
        session()->flash('success', $this->editingMvId ? 'Card updated.' : 'Card created.');
    }

    public function confirmDeleteMv(int $id): void
    {
        $this->deletingMvId = $id;
        $this->showMvDelete = true;
    }

    public function deleteMv(AboutService $service): void
    {
        if ($this->deletingMvId) {
            $service->deleteMvCard($this->deletingMvId);
            $this->mvCards      = $service->getMvCards()->toArray();
            $this->showMvDelete = false;
            $this->deletingMvId = null;
            session()->flash('success', 'Card deleted.');
        }
    }

    public function toggleMv(int $id, AboutService $service): void
    {
        $service->toggleMvCard($id);
        $this->mvCards = $service->getMvCards()->toArray();
    }

    public function reorderMvCards(array $ids, AboutService $service): void
    {
        $service->reorderMvCards($ids);
        $this->mvCards = $service->getMvCards()->toArray();
    }

    private function resetMvForm(): void
    {
        $this->editingMvId = null;
        $this->mv_icon = $this->mv_title = $this->mv_body = '';
        $this->resetValidation(['mv_icon','mv_title','mv_body']);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.about.about-page');
    }
}