<?php

namespace Database\Seeders;

use App\Livewire\Admin\About\CoreValues;
use App\Livewire\Admin\Settings\SiteSettings;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            AdminSeeder::class,
            HeroSlideSeeder::class,
            SettingSeeder::class,
            CoreValuesSeeder::class,
            WhyUsSeeder::class,
            CourseSeeder::class,
            HomeAboutSeeder::class,
            HomeServiceSeeder::class,
            HomeTestimonialSeeder::class,
            BlogPostSeeder::class,
        ]);
    }
}
