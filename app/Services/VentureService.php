<?php

namespace App\Services;

use App\Models\Venture;
use App\Repositories\Contracts\VentureRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class VentureService
{
    public function __construct(protected VentureRepositoryInterface $repository) {}

    public function list(int $perPage = 10, string $search = '', string $category = '', string $status = '', string $filter = ''): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage, $search, $category, $status, $filter);
    }

    public function allActive(): Collection
    {
        return $this->repository->allActive();
    }

    public function find(int $id): Venture
    {
        return $this->repository->find($id);
    }

    public function findBySlug(string $slug): Venture
    {
        return $this->repository->findBySlug($slug);
    }

    public function create(array $data, ?UploadedFile $image = null): Venture
    {
        if ($image) {
            $data['banner_image'] = $image->store('ventures', 'public');
        }

        return $this->repository->create($data);
    }

    public function update(int $id, array $data, ?UploadedFile $image = null, bool $removeImage = false): Venture
    {
        $venture = $this->repository->find($id);
        if ($image) {
            $this->deleteImage($venture->banner_image);
            $data['banner_image'] = $image->store('ventures', 'public');
        } elseif ($removeImage) {
            $this->deleteImage($venture->banner_image);
            $data['banner_image'] = null;
        }

        return $this->repository->update($id, $data);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function restore(int $id): void
    {
        $this->repository->restore($id);
    }

    public function reorder(array $ids): void
    {
        $this->repository->reorder($ids);
    }

    private function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
