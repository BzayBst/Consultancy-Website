<?php

namespace App\Repositories\Contracts;

use App\Models\WhyUsFeature;
use App\Models\WhyUsSection;
use Illuminate\Support\Collection;

interface WhyUsRepositoryInterface
{
    public function getSection(): ?WhyUsSection;
    public function saveSection(array $data): WhyUsSection;

    public function getFeatures(): Collection;
    public function findFeature(int $id): WhyUsFeature;
    public function createFeature(array $data): WhyUsFeature;
    public function updateFeature(int $id, array $data): WhyUsFeature;
    public function deleteFeature(int $id): void;
    public function reorderFeatures(array $orderedIds): void;
    public function toggleFeature(int $id): bool;
}