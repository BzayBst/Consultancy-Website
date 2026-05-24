<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class EventService
{
    /* ------------------------------------------------------------------ */
    /*  Section settings  (stored via your setting() helper)               */
    /* ------------------------------------------------------------------ */

    public function getSectionSettings(): array
    {
        return [
            'section_label' => setting('events_section_label', 'LATEST EVENTS'),
            'title'         => setting('events_section_title', 'Upcoming & Recent Events'),
        ];
    }

    public function saveSectionSettings(array $data): void
    {
        setting(['events_section_label' => $data['section_label']]);
        setting(['events_section_title' => $data['title']]);
        setting()->save();
    }

    /* ------------------------------------------------------------------ */
    /*  List                                                                */
    /* ------------------------------------------------------------------ */

    public function list(
        int    $perPage      = 10,
        string $search       = '',
        string $filterStatus = '',
        string $filterActive = ''
    ): LengthAwarePaginator {
        return Event::withTrashed()
            ->when($search, fn ($q) => $q->where(function ($q) use ($search) {
                $q->where('title',     'like', "%{$search}%")
                  ->orWhere('location',  'like', "%{$search}%")
                  ->orWhere('organizer', 'like', "%{$search}%");
            }))
            ->when($filterStatus, fn ($q) => $q->where('status', $filterStatus))
            ->when($filterActive === 'active',   fn ($q) => $q->whereNull('deleted_at')->where('is_active', true))
            ->when($filterActive === 'inactive', fn ($q) => $q->whereNull('deleted_at')->where('is_active', false))
            ->when($filterActive === 'trashed',  fn ($q) => $q->onlyTrashed())
            ->orderBy('event_date')
            ->paginate($perPage);
    }

    /* ------------------------------------------------------------------ */
    /*  CRUD                                                                */
    /* ------------------------------------------------------------------ */

    public function find(int $id): Event
    {
        return Event::withTrashed()->findOrFail($id);
    }

    public function create(array $data, ?UploadedFile $photo = null): Event
    {
        $data['image'] = $photo ? $photo->store('events', 'public') : null;
        return Event::create($data);
    }

    public function update(int $id, array $data, ?UploadedFile $photo = null, bool $removePhoto = false): Event
    {
        $event = $this->find($id);

        if ($photo) {
            $this->deleteImage($event->image);
            $data['image'] = $photo->store('events', 'public');
        } elseif ($removePhoto) {
            $this->deleteImage($event->image);
            $data['image'] = null;
        }

        $event->update($data);
        return $event->fresh();
    }

    public function delete(int $id): void
    {
        $this->find($id)->delete();
    }

    public function restore(int $id): void
    {
        Event::withTrashed()->findOrFail($id)->restore();
    }

    /* ------------------------------------------------------------------ */

    private function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}