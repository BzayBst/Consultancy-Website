<?php

namespace App\Services;

use App\Repositories\Contracts\SettingRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SettingService
{
    public function __construct(
        protected SettingRepositoryInterface $settingRepository
    ) {}

    /**
     * Save a group of settings.
     * $data  = ['key' => 'value', ...]  plain text/url/etc fields
     * $files = ['key' => UploadedFile]  image fields
     */
    public function saveGroup(string $group, array $data, array $files = []): void
    {
        foreach ($files as $key => $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $oldPath = $this->settingRepository->get($key);
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
                $data[$key] = $file->store("settings/{$group}", 'public');
            }
        }

        $this->settingRepository->bulkSet($data);
    }

    /**
     * Get all settings for a group as a guaranteed flat ['key' => 'string'] array.
     * Every value is cast to string — null becomes empty string.
     */
    public function getGroupValues(string $group): array
    {
        // Query directly — no cache object risk, returns plain string values
        return \App\Models\Setting::where('group', $group)
            ->get(['key', 'value'])
            ->mapWithKeys(fn ($row) => [$row->key => (string) ($row->value ?? '')])
            ->toArray();
    }

    /**
     * Get a single value by key.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->settingRepository->get($key, $default);
    }
}