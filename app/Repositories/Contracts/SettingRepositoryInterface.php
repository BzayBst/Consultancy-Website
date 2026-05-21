<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface SettingRepositoryInterface
{
    /**
     * Get all settings as a flat ['key' => 'value'] array (cached).
     */
    public function getAllFlat(): array;

    /**
     * Get all settings as a Collection (wraps getAllFlat).
     */
    public function getAll(): Collection;

    /**
     * Get all Setting models for a given group, keyed by 'key'.
     */
    public function getByGroup(string $group): Collection;

    /**
     * Get a single setting value by key.
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Update a single setting by key.
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