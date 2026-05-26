<?php

namespace App\Services;

use App\Models\HomeService;

class HomeServiceService
{
    public function get(): ?HomeService
    {
        return HomeService::first();
    }

    public function save(array $data): HomeService
    {
        if (isset($data['services'])) {
            $data['services'] = collect($data['services'])
                ->map(fn ($service) => [
                    'icon' => trim($service['icon'] ?? ''),
                    'title' => trim($service['title'] ?? ''),
                    'description' => trim($service['description'] ?? ''),
                    'link_label' => trim($service['link_label'] ?? ''),
                    'link_url' => trim($service['link_url'] ?? ''),
                ])
                ->filter(fn ($service) => $service['title'] !== '' || $service['description'] !== '')
                ->values()
                ->all();
        }

        $record = HomeService::firstOrNew(['id' => 1]);
        $record->fill($data)->save();

        return $record->fresh();
    }
}
