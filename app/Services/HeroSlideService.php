<?php

namespace App\Services;

use App\Models\HeroSlide;
use App\Repositories\Contracts\HeroSlideRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class HeroSlideService
{
    public function __construct(
        protected HeroSlideRepositoryInterface $slideRepository
    ) {}

    public function all(): Collection
    {
        return $this->slideRepository->allOrdered();
    }

    public function activeSlides(): Collection
    {
        return $this->slideRepository->activeOrdered();
    }

    public function find(int $id): HeroSlide
    {
        return $this->slideRepository->find($id);
    }

    /**
     * Create a new slide.
     * $data    — validated form fields
     * $image   — optional UploadedFile
     * $features — array of ['icon'=>'🎓','label'=>'Study Abroad']
     */
    public function create(array $data, ?UploadedFile $image, array $features): HeroSlide
    {
        if ($image && $image->isValid()) {
            $data['image_path'] = $image->store('hero', 'public');
        }

        $data['features'] = $this->sanitizeFeatures($features);

        return $this->slideRepository->create($data);
    }

    /**
     * Update an existing slide.
     */
    public function update(int $id, array $data, ?UploadedFile $image, array $features): HeroSlide
    {
        if ($image && $image->isValid()) {
            // Delete old image
            $old = $this->slideRepository->find($id)->image_path;
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $data['image_path'] = $image->store('hero', 'public');
        }

        $data['features'] = $this->sanitizeFeatures($features);

        return $this->slideRepository->update($id, $data);
    }

    /**
     * Delete a slide and its image.
     */
    public function delete(int $id): void
    {
        $slide = $this->slideRepository->find($id);
        if ($slide->image_path && Storage::disk('public')->exists($slide->image_path)) {
            Storage::disk('public')->delete($slide->image_path);
        }
        $this->slideRepository->delete($id);
    }

    public function reorder(array $orderedIds): void
    {
        $this->slideRepository->reorder($orderedIds);
    }

    public function toggleActive(int $id): bool
    {
        return $this->slideRepository->toggleActive($id);
    }

    private function sanitizeFeatures(array $features): array
    {
        return array_values(
            array_filter($features, fn ($f) => ! empty($f['label']))
        );
    }
}