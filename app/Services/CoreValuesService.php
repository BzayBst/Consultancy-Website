<?php

namespace App\Services;

use App\Models\CoreValue;
use App\Models\CoreValuesSection;
use App\Repositories\Contracts\CoreValuesRepositoryInterface;
use Illuminate\Support\Collection;

class CoreValuesService
{
    public function __construct(
        protected CoreValuesRepositoryInterface $repo
    ) {}

    public function getSection(): ?CoreValuesSection
    {
        return $this->repo->getSection();
    }

    public function saveSection(array $data): CoreValuesSection
    {
        return $this->repo->saveSection($data);
    }

    public function getValues(): Collection
    {
        return $this->repo->getValues();
    }

    public function findValue(int $id): CoreValue
    {
        return $this->repo->findValue($id);
    }

    public function createValue(array $data)
    {
        return $this->repo->createValue($data);
    }

    public function updateValue(int $id, array $data)
    {
        return $this->repo->updateValue($id, $data);
    }

    public function deleteValue(int $id): void
    {
        $this->repo->deleteValue($id);
    }

    public function reorderValues(array $ids): void
    {
        $this->repo->reorderValues($ids);
    }

    public function toggleValue(int $id): bool
    {
        return $this->repo->toggleValue($id);
    }
}
