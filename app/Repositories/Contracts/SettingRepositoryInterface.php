<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface SettingRepositoryInterface
{
    /**
     * Get all settings for a given group, keyed by 'key'.
     */
    public function getByGroup(string $group): Collection;

    /**
     * Get all settings across all groups, keyed by 'key'.
     */
    public function getAll(): Collection;

    /**
     * Get a single setting value by key.
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Update or create a setting by key.
     */
    public function set(string $key, mixed $value): void;

    /**
     * Bulk update an array of ['key' => 'value'] pairs.
     */
    public function bulkSet(array $data): void;

    /**
     * Flush the settings cache.
     */
    public function clearCache(): void;
}