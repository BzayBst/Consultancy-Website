<?php

namespace App\Services;

use App\Models\AboutHero;
use App\Models\AboutStory;
use App\Repositories\Contracts\AboutRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class AboutService
{
    public function __construct(
        protected AboutRepositoryInterface $repo
    ) {}

    // ── Hero ──────────────────────────────────────────────────────────────
    public function getHero(): ?AboutHero
    {
        return $this->repo->getHero();
    }

    public function saveHero(array $data): AboutHero
    {
        return $this->repo->saveHero($data);
    }

    // ── Story ─────────────────────────────────────────────────────────────
    public function getStory(): ?AboutStory
    {
        return $this->repo->getStory();
    }

    public function saveStory(array $data, ?UploadedFile $image = null): AboutStory
    {
        if ($image && $image->isValid()) {
            $old = $this->repo->getStory()?->image_path;
            if ($old && ! str_starts_with($old, 'http') && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $data['image_path'] = $image->store('about', 'public');
        }

        return $this->repo->saveStory($data);
    }

    // ── Milestones ────────────────────────────────────────────────────────
    public function getMilestones(): Collection
    {
        return $this->repo->getMilestones();
    }

    public function findMilestone(int $id)
    {
        return $this->repo->findMilestone($id);
    }

    public function createMilestone(array $data)
    {
        return $this->repo->createMilestone($data);
    }

    public function updateMilestone(int $id, array $data)
    {
        return $this->repo->updateMilestone($id, $data);
    }

    public function deleteMilestone(int $id): void
    {
        $this->repo->deleteMilestone($id);
    }

    public function reorderMilestones(array $ids)
    {
        $this->repo->reorderMilestones($ids);
    }

    public function toggleMilestone(int $id): bool
    {
        $m = $this->repo->findMilestone($id);
        $this->repo->updateMilestone($id, ['is_active' => ! $m->is_active]);

        return ! $m->is_active;
    }

    // ── Stats ─────────────────────────────────────────────────────────────
    public function getStats(): Collection
    {
        return $this->repo->getStats();
    }

    public function findStat(int $id)
    {
        return $this->repo->findStat($id);
    }

    public function createStat(array $data)
    {
        return $this->repo->createStat($data);
    }

    public function updateStat(int $id, array $d)
    {
        return $this->repo->updateStat($id, $d);
    }

    public function deleteStat(int $id): void
    {
        $this->repo->deleteStat($id);
    }

    public function reorderStats(array $ids)
    {
        $this->repo->reorderStats($ids);
    }

    public function toggleStat(int $id): bool
    {
        $s = $this->repo->findStat($id);
        $this->repo->updateStat($id, ['is_active' => ! $s->is_active]);

        return ! $s->is_active;
    }

    // ── MV Cards ──────────────────────────────────────────────────────────
    public function getMvCards(): Collection
    {
        return $this->repo->getMvCards();
    }

    public function findMvCard(int $id)
    {
        return $this->repo->findMvCard($id);
    }

    public function createMvCard(array $data)
    {
        return $this->repo->createMvCard($data);
    }

    public function updateMvCard(int $id, array $d)
    {
        return $this->repo->updateMvCard($id, $d);
    }

    public function deleteMvCard(int $id): void
    {
        $this->repo->deleteMvCard($id);
    }

    public function reorderMvCards(array $ids)
    {
        $this->repo->reorderMvCards($ids);
    }

    public function toggleMvCard(int $id): bool
    {
        $c = $this->repo->findMvCard($id);
        $this->repo->updateMvCard($id, ['is_active' => ! $c->is_active]);

        return ! $c->is_active;
    }
}
