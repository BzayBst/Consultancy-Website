<?php

namespace App\Repositories\Contracts;

use App\Models\Team;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TeamRepositoryInterface
{
    public function paginate(int $perPage = 10, string $search = '', string $status = ''): LengthAwarePaginator;

    public function all(): Collection;

    public function find(int $id): Team;

    public function create(array $data): Team;

    public function update(int $id, array $data): Team;

    public function delete(int $id): bool;

    public function restore(int $id): bool;

    public function updateOrder(array $orderedIds): void;
}
