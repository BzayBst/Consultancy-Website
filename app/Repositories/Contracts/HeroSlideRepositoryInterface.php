<?php

namespace App\Repositories\Contracts;

use App\Models\HeroSlide;
use Illuminate\Support\Collection;

interface HeroSlideRepositoryInterface
{
    public function allOrdered(): Collection;

    public function activeOrdered(): Collection;

    public function find(int $id): HeroSlide;

    public function create(array $data): HeroSlide;

    public function update(int $id, array $data): HeroSlide;

    public function delete(int $id): void;

    public function reorder(array $orderedIds): void;   // [$id => $sortOrder]

    public function toggleActive(int $id): bool;        // returns new state
}