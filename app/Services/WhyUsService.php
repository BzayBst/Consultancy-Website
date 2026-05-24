<?php

namespace App\Services;

use App\Models\WhyUsSection;
use App\Repositories\Contracts\WhyUsRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class WhyUsService
{
    public function __construct(
        protected WhyUsRepositoryInterface $repo
    ) {}

    // ── Section ──────────────────────────────────────────────────────────
    public function getSection(): ?WhyUsSection
    {
        return $this->repo->getSection();
    }

    public function saveSection(array $data, ?UploadedFile $image = null): WhyUsSection
    {
        if ($image && $image->isValid()) {
            $old = $this->repo->getSection()?->image_path;
            if ($old && ! str_starts_with($old, 'http') && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $data['image_path'] = $image->store('why-us', 'public');
        }

        return $this->repo->saveSection($data);
    }

    // ── Features ─────────────────────────────────────────────────────────
    public function getFeatures(): Collection
    {
        return $this->repo->getFeatures();
    }

    public function findFeature(int $id)
    {
        return $this->repo->findFeature($id);
    }

    public function createFeature(array $data)
    {
        return $this->repo->createFeature($data);
    }

    public function updateFeature(int $id, array $data)
    {
        return $this->repo->updateFeature($id, $data);
    }

    public function deleteFeature(int $id): void
    {
        $this->repo->deleteFeature($id);
    }

    public function reorderFeatures(array $ids)
    {
        $this->repo->reorderFeatures($ids);
    }

    public function toggleFeature(int $id): bool
    {
        return $this->repo->toggleFeature($id);
    }
}
