<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Repositories\Contracts\SettingRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SettingRepository implements SettingRepositoryInterface
{
    private const CACHE_KEY = 'site_settings';
    private const CACHE_TTL = 60 * 60 * 24; // 24 hours

    public function __construct(protected Setting $model) {}

    /**
     * Returns a flat array: ['key_name' => 'value', ...]
     * This is the single source of truth — everything else reads from this.
     */
    public function getAllFlat(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return $this->model
                ->all(['group', 'key', 'value'])
                ->pluck('value', 'key')
                ->toArray();
        });
    }

    /**
     * Get all settings for a given group as a flat ['key' => 'value'] array.
     */
    public function getByGroup(string $group): Collection
    {
        // Return a collection of Setting models keyed by 'key' for the given group
        return $this->model
            ->where('group', $group)
            ->get()
            ->keyBy('key');
    }

    public function getAll(): Collection
    {
        return collect($this->getAllFlat());
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->getAllFlat()[$key] ?? $default;
    }

    public function set(string $key, mixed $value): void
    {
        $this->model->where('key', $key)->update(['value' => $value]);
        $this->clearCache();
    }

    public function bulkSet(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->model->where('key', $key)->update(['value' => $value]);
        }
        $this->clearCache();
    }

    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}