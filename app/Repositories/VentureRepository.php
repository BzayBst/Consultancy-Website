<?php

namespace App\Repositories;

use App\Models\Venture;
use App\Repositories\Contracts\VentureRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class VentureRepository implements VentureRepositoryInterface
{
    public function __construct(protected Venture $model) {}

    public function paginate(int $perPage, string $search, string $category, string $status, string $filter): LengthAwarePaginator
    {
        return $this->model->withTrashed()
            ->when($search, fn ($q) => $q->where(fn ($q) => $q->where('name', 'like', "%$search%")->orWhere('tagline', 'like', "%$search%")->orWhere('location', 'like', "%$search%")))
            ->when($category, fn ($q) => $q->where('category', $category))
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($filter === 'active', fn ($q) => $q->whereNull('deleted_at')->where('is_active', true))
            ->when($filter === 'inactive', fn ($q) => $q->whereNull('deleted_at')->where('is_active', false))
            ->when($filter === 'trashed', fn ($q) => $q->onlyTrashed())
            ->ordered()
            ->paginate($perPage);
    }

    public function allActive(): Collection
    {
        return $this->model->active()->ordered()->get();
    }

    public function find(int $id): Venture
    {
        return $this->model->withTrashed()->findOrFail($id);
    }

    public function findBySlug(string $slug): Venture
    {
        return $this->model->active()->where('slug', $slug)->firstOrFail();
    }

    public function create(array $data): Venture
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Venture
    {
        $v = $this->find($id);
        $v->update($data);

        return $v->fresh();
    }

    public function delete(int $id): void
    {
        $this->find($id)->delete();
    }

    public function restore(int $id): void
    {
        $this->model->withTrashed()->findOrFail($id)->restore();
    }

    public function reorder(array $orderedIds): void
    {
        foreach ($orderedIds as $pos => $id) {
            $this->model->where('id', $id)->update(['order' => $pos + 1]);
        }
    }
}
