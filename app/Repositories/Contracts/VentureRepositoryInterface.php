<?php

namespace App\Repositories\Contracts;

use App\Models\Venture;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface VentureRepositoryInterface
{
    public function paginate(int $perPage, string $search, string $category, string $status, string $filter): LengthAwarePaginator;

    public function allActive(): Collection;

    public function find(int $id): Venture;

    public function findBySlug(string $slug): Venture;

    public function create(array $data): Venture;

    public function update(int $id, array $data): Venture;

    public function delete(int $id): void;

    public function restore(int $id): void;

    public function reorder(array $orderedIds): void;
}
