<?php

namespace App\Services;

use App\Models\Team;
use App\Repositories\Contracts\TeamRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeamService
{
    public function __construct(
        protected TeamRepositoryInterface $repository
    ) {}

    /* ------------------------------------------------------------------ */

    public function list(int $perPage = 10, string $search = '', string $status = ''): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage, $search, $status);
    }

    /* ------------------------------------------------------------------ */

    public function all(): Collection
    {
        return $this->repository->all();
    }

    /* ------------------------------------------------------------------ */

    public function find(int $id): Team
    {
        return $this->repository->find($id);
    }

    /* ------------------------------------------------------------------ */

    public function create(array $validated, ?UploadedFile $photo = null): Team
    {
        $validated['photo'] = $photo ? $this->storePhoto($photo) : null;
        $validated['slug']  = $this->uniqueSlug($validated['name']);

        return $this->repository->create($validated);
    }

    /* ------------------------------------------------------------------ */

    public function update(int $id, array $validated, ?UploadedFile $photo = null, bool $removePhoto = false): Team
    {
        $team = $this->repository->find($id);

        if ($photo) {
            $this->deletePhoto($team->photo);
            $validated['photo'] = $this->storePhoto($photo);
        } elseif ($removePhoto) {
            $this->deletePhoto($team->photo);
            $validated['photo'] = null;
        }

        // Regenerate slug only if name changed and no custom slug provided
        if (isset($validated['name']) && $validated['name'] !== $team->name) {
            $validated['slug'] = $this->uniqueSlug($validated['name'], $id);
        }

        return $this->repository->update($id, $validated);
    }

    /* ------------------------------------------------------------------ */

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    /* ------------------------------------------------------------------ */

    public function restore(int $id): bool
    {
        return $this->repository->restore($id);
    }

    /* ------------------------------------------------------------------ */

    public function reorder(array $orderedIds): void
    {
        $this->repository->updateOrder($orderedIds);
    }

    /* ------------------------------------------------------------------ */
    /*  Helpers                                                             */
    /* ------------------------------------------------------------------ */

    private function storePhoto(UploadedFile $file): string
    {
        return $file->store('teams', 'public');
    }

    private function deletePhoto(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function uniqueSlug(string $name, ?int $exceptId = null): string
    {
        $slug  = Str::slug($name);
        $count = 0;

        do {
            $candidate = $count > 0 ? "{$slug}-{$count}" : $slug;
            $query = Team::where('slug', $candidate);
            if ($exceptId) {
                $query->where('id', '!=', $exceptId);
            }
            $exists = $query->exists();
            $count++;
        } while ($exists);

        return $candidate;
    }
}
