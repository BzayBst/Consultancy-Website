<?php

namespace App\Repositories;

use App\Models\AboutHero;
use App\Models\AboutMilestone;
use App\Models\AboutMvCard;
use App\Models\AboutStat;
use App\Models\AboutStory;
use App\Repositories\Contracts\AboutRepositoryInterface;
use Illuminate\Support\Collection;

class AboutRepository implements AboutRepositoryInterface
{
    // ── Hero ──────────────────────────────────────────────────────────────
    public function getHero(): ?AboutHero
    {
        return AboutHero::first();
    }

    public function saveHero(array $data): AboutHero
    {
        $hero = AboutHero::firstOrNew(['id' => 1]);
        $hero->fill($data)->save();
        return $hero->fresh();
    }

    // ── Story ─────────────────────────────────────────────────────────────
    public function getStory(): ?AboutStory
    {
        return AboutStory::first();
    }

    public function saveStory(array $data): AboutStory
    {
        $story = AboutStory::firstOrNew(['id' => 1]);
        $story->fill($data)->save();
        return $story->fresh();
    }

    // ── Milestones ────────────────────────────────────────────────────────
    public function getMilestones(): Collection
    {
        return AboutMilestone::ordered()->get();
    }

    public function findMilestone(int $id): AboutMilestone
    {
        return AboutMilestone::findOrFail($id);
    }

    public function createMilestone(array $data): AboutMilestone
    {
        if (! isset($data['sort_order'])) {
            $data['sort_order'] = (AboutMilestone::max('sort_order') ?? 0) + 1;
        }
        return AboutMilestone::create($data);
    }

    public function updateMilestone(int $id, array $data): AboutMilestone
    {
        $m = $this->findMilestone($id);
        $m->update($data);
        return $m->fresh();
    }

    public function deleteMilestone(int $id): void
    {
        $this->findMilestone($id)->delete();
    }

    public function reorderMilestones(array $orderedIds): void
    {
        foreach ($orderedIds as $sort => $id) {
            AboutMilestone::where('id', $id)->update(['sort_order' => $sort + 1]);
        }
    }

    // ── Stats ─────────────────────────────────────────────────────────────
    public function getStats(): Collection
    {
        return AboutStat::ordered()->get();
    }

    public function findStat(int $id): AboutStat
    {
        return AboutStat::findOrFail($id);
    }

    public function createStat(array $data): AboutStat
    {
        if (! isset($data['sort_order'])) {
            $data['sort_order'] = (AboutStat::max('sort_order') ?? 0) + 1;
        }
        return AboutStat::create($data);
    }

    public function updateStat(int $id, array $data): AboutStat
    {
        $s = $this->findStat($id);
        $s->update($data);
        return $s->fresh();
    }

    public function deleteStat(int $id): void
    {
        $this->findStat($id)->delete();
    }

    public function reorderStats(array $orderedIds): void
    {
        foreach ($orderedIds as $sort => $id) {
            AboutStat::where('id', $id)->update(['sort_order' => $sort + 1]);
        }
    }

    // ── MV Cards ──────────────────────────────────────────────────────────
    public function getMvCards(): Collection
    {
        return AboutMvCard::ordered()->get();
    }

    public function findMvCard(int $id): AboutMvCard
    {
        return AboutMvCard::findOrFail($id);
    }

    public function createMvCard(array $data): AboutMvCard
    {
        if (! isset($data['sort_order'])) {
            $data['sort_order'] = (AboutMvCard::max('sort_order') ?? 0) + 1;
        }
        return AboutMvCard::create($data);
    }

    public function updateMvCard(int $id, array $data): AboutMvCard
    {
        $c = $this->findMvCard($id);
        $c->update($data);
        return $c->fresh();
    }

    public function deleteMvCard(int $id): void
    {
        $this->findMvCard($id)->delete();
    }

    public function reorderMvCards(array $orderedIds): void
    {
        foreach ($orderedIds as $sort => $id) {
            AboutMvCard::where('id', $id)->update(['sort_order' => $sort + 1]);
        }
    }
}