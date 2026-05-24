<?php

namespace App\Repositories;

use App\Models\WhyUsFeature;
use App\Models\WhyUsSection;
use App\Repositories\Contracts\WhyUsRepositoryInterface;
use Illuminate\Support\Collection;

class WhyUsRepository implements WhyUsRepositoryInterface
{
    // ── Section ──────────────────────────────────────────────────────────
    public function getSection(): ?WhyUsSection
    {
        return WhyUsSection::first();
    }

    public function saveSection(array $data): WhyUsSection
    {
        $section = WhyUsSection::firstOrNew(['id' => 1]);
        $section->fill($data)->save();
        return $section->fresh();
    }

    // ── Features ─────────────────────────────────────────────────────────
    public function getFeatures(): Collection
    {
        return WhyUsFeature::ordered()->get();
    }

    public function findFeature(int $id): WhyUsFeature
    {
        return WhyUsFeature::findOrFail($id);
    }

    public function createFeature(array $data): WhyUsFeature
    {
        if (! isset($data['sort_order'])) {
            $data['sort_order'] = (WhyUsFeature::max('sort_order') ?? 0) + 1;
        }
        return WhyUsFeature::create($data);
    }

    public function updateFeature(int $id, array $data): WhyUsFeature
    {
        $f = $this->findFeature($id);
        $f->update($data);
        return $f->fresh();
    }

    public function deleteFeature(int $id): void
    {
        $this->findFeature($id)->delete();
    }

    public function reorderFeatures(array $orderedIds): void
    {
        foreach ($orderedIds as $sort => $id) {
            WhyUsFeature::where('id', $id)->update(['sort_order' => $sort + 1]);
        }
    }

    public function toggleFeature(int $id): bool
    {
        $f = $this->findFeature($id);
        $new = ! $f->is_active;
        $f->update(['is_active' => $new]);
        return $new;
    }
}