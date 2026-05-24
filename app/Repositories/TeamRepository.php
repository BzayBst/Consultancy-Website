<?php

namespace App\Repositories;

use App\Models\Team;
use App\Repositories\Contracts\TeamRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TeamRepository implements TeamRepositoryInterface
{
    public function __construct(protected Team $model) {}

    /* ------------------------------------------------------------------ */

    public function paginate(int $perPage = 10, string $search = '', string $status = ''): LengthAwarePaginator
    {
        return $this->model
            ->withTrashed()
            ->when($search, fn ($q) => $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            }))
            ->when($status === 'active',   fn ($q) => $q->whereNull('deleted_at')->where('is_active', true))
            ->when($status === 'inactive', fn ($q) => $q->whereNull('deleted_at')->where('is_active', false))
            ->when($status === 'trashed',  fn ($q) => $q->onlyTrashed())
            ->ordered()
            ->paginate($perPage);
    }

    /* ------------------------------------------------------------------ */

    public function all(): Collection
    {
        return $this->model->active()->ordered()->get();
    }

    /* ------------------------------------------------------------------ */

    public function find(int $id): Team
    {
        return $this->model->withTrashed()->findOrFail($id);
    }

    /* ------------------------------------------------------------------ */

    public function create(array $data): Team
    {
        return $this->model->create($data);
    }

    /* ------------------------------------------------------------------ */

    public function update(int $id, array $data): Team
    {
        $team = $this->find($id);
        $team->update($data);
        return $team->fresh();
    }

    /* ------------------------------------------------------------------ */

    public function delete(int $id): bool
    {
        return (bool) $this->find($id)->delete();
    }

    /* ------------------------------------------------------------------ */

    public function restore(int $id): bool
    {
        return (bool) $this->model->withTrashed()->findOrFail($id)->restore();
    }

    /* ------------------------------------------------------------------ */

    public function updateOrder(array $orderedIds): void
    {
        foreach ($orderedIds as $position => $id) {
            $this->model->where('id', $id)->update(['order' => $position + 1]);
        }
    }
}
