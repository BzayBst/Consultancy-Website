<?php

namespace App\Repositories\Contracts;

use App\Models\CoreValue;
use App\Models\CoreValuesSection;
use Illuminate\Support\Collection;

interface CoreValuesRepositoryInterface
{
    public function getSection(): ?CoreValuesSection;

    public function saveSection(array $data): CoreValuesSection;

    public function getValues(): Collection;

    public function findValue(int $id): CoreValue;

    public function createValue(array $data): CoreValue;

    public function updateValue(int $id, array $data): CoreValue;

    public function deleteValue(int $id): void;

    public function reorderValues(array $orderedIds): void;

    public function toggleValue(int $id): bool;
}
