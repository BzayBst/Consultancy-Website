<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@hasuedu.com'],
            [
                'name'      => 'Super Admin',
                'password'  => Hash::make('Admin@12345'),
                'is_active' => true,
            ]
        );

        $this->command->info('✅ Admin seeded: admin@hasuedu.com / Admin@12345');
    }
}