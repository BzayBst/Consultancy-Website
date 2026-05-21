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
     * $data    = ['key' => 'value', ...]  (text/textarea/url/etc.)
     * $files   = ['key' => UploadedFile]  (image fields)
     * $group   = 'general' | 'contact' | 'social' | 'seo'
     */
    public function saveGroup(string $group, array $data, array $files = []): void
    {
        // Handle file uploads first
        foreach ($files as $key => $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                // Delete old file if it exists
                $oldPath = $this->settingRepository->get($key);
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }

                $path = $file->store("settings/{$group}", 'public');
                $data[$key] = $path;
            }
        }

        $this->settingRepository->bulkSet($data);
    }

    /**
     * Get all settings for a group as a flat key=>value array.
     */
    public function getGroupValues(string $group): array
    {
        return $this->settingRepository
            ->getByGroup($group)
            ->mapWithKeys(fn ($setting, $key) => [$key => $setting->value])
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