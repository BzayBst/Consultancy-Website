<?php

namespace App\Repositories\Contracts;

use App\Models\AboutHero;
use App\Models\AboutMilestone;
use App\Models\AboutMvCard;
use App\Models\AboutStat;
use App\Models\AboutStory;
use Illuminate\Support\Collection;

interface AboutRepositoryInterface
{
    // ── Hero ──────────────────────────────────────────────────────────────
    public function getHero(): ?AboutHero;
    public function saveHero(array $data): AboutHero;

    // ── Story ─────────────────────────────────────────────────────────────
    public function getStory(): ?AboutStory;
    public function saveStory(array $data): AboutStory;

    // ── Milestones ────────────────────────────────────────────────────────
    public function getMilestones(): Collection;
    public function findMilestone(int $id): AboutMilestone;
    public function createMilestone(array $data): AboutMilestone;
    public function updateMilestone(int $id, array $data): AboutMilestone;
    public function deleteMilestone(int $id): void;
    public function reorderMilestones(array $orderedIds): void;

    // ── Stats ─────────────────────────────────────────────────────────────
    public function getStats(): Collection;
    public function findStat(int $id): AboutStat;
    public function createStat(array $data): AboutStat;
    public function updateStat(int $id, array $data): AboutStat;
    public function deleteStat(int $id): void;
    public function reorderStats(array $orderedIds): void;

    // ── MV Cards ──────────────────────────────────────────────────────────
    public function getMvCards(): Collection;
    public function findMvCard(int $id): AboutMvCard;
    public function createMvCard(array $data): AboutMvCard;
    public function updateMvCard(int $id, array $data): AboutMvCard;
    public function deleteMvCard(int $id): void;
    public function reorderMvCards(array $orderedIds): void;
}