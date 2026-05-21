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

    public function getByGroup(string $group): Collection
    {
        return $this->getAll()->where('group', $group)->keyBy('key');
    }

    public function getAll(): Collection
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return $this->model->all()->keyBy('key');
        });
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->getAll()->get($key)?->value ?? $default;
    }

    public function set(string $key, mixed $value): void
    {
        $this->model->where('key', $key)->update(['value' => $value]);
        $this->clearCache();
    }

    public function bulkSet(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->model
                ->where('key', $key)
                ->update(['value' => $value]);
        }

        $this->clearCache();
    }

    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}