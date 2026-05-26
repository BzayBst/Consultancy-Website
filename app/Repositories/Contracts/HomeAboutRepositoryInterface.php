<?php

namespace App\Repositories\Contracts;

use App\Models\HomeAbout;

interface HomeAboutRepositoryInterface
{
    public function get(): ?HomeAbout;
    public function save(array $data): HomeAbout;
}