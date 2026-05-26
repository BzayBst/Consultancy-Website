<?php

namespace App\Repositories;

use App\Models\HomeAbout;
use App\Repositories\Contracts\HomeAboutRepositoryInterface;

class HomeAboutRepository implements HomeAboutRepositoryInterface
{
    public function get(): ?HomeAbout
    {
        return HomeAbout::first();
    }

    public function save(array $data): HomeAbout
    {
        $record = HomeAbout::firstOrNew(['id' => 1]);
        $record->fill($data)->save();
        return $record->fresh();
    }
}