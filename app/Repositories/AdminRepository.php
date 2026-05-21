<?php

namespace App\Repositories;

use App\Models\Admin;
use App\Repositories\Contracts\AdminRepositoryInterface;

class AdminRepository implements AdminRepositoryInterface
{
    public function __construct(protected Admin $model) {}

    public function findByEmail(string $email): ?Admin
    {
        return $this->model->where('email', $email)->first();
    }

    public function findById(int $id): ?Admin
    {
        return $this->model->find($id);
    }

    public function updateLastLogin(int $id, string $ip): void
    {
        $this->model->where('id', $id)->update([
            'last_login_at' => now(),
            'last_login_ip' => $ip,
        ]);
    }
}