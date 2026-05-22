<?php

namespace App\Repositories;

use App\Models\HeroSlide;
use App\Repositories\Contracts\HeroSlideRepositoryInterface;
use Illuminate\Support\Collection;

class HeroSlideRepository implements HeroSlideRepositoryInterface
{
    public function __construct(protected HeroSlide $model) {}

    public function allOrdered(): Collection
    {
        return $this->model->ordered()->get();
    }

    public function activeOrdered(): Collection
    {
        return $this->model->active()->ordered()->get();
    }

    public function find(int $id): HeroSlide
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): HeroSlide
    {
        // Auto-assign sort_order to end of list
        if (! isset($data['sort_order'])) {
            $data['sort_order'] = ($this->model->max('sort_order') ?? 0) + 1;
        }

        return $this->model->create($data);
    }

    public function update(int $id, array $data): HeroSlide
    {
        $slide = $this->find($id);
        $slide->update($data);
        return $slide->fresh();
    }

    public function delete(int $id): void
    {
        $this->find($id)->delete();
    }

    public function reorder(array $orderedIds): void
    {
        // $orderedIds = [id1, id2, id3, ...] in new order
        foreach ($orderedIds as $sortOrder => $id) {
            $this->model->where('id', $id)->update(['sort_order' => $sortOrder + 1]);
        }
    }

    public function toggleActive(int $id): bool
    {
        $slide = $this->find($id);
        $slide->update(['is_active' => ! $slide->is_active]);
        return $slide->fresh()->is_active;
    }
}