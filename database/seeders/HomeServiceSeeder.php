<?php

namespace Database\Seeders;

use App\Models\HomeService;
use Illuminate\Database\Seeder;

class HomeServiceSeeder extends Seeder
{
    public function run(): void
    {
        HomeService::updateOrCreate(['id' => 1], [
            'section_label' => 'What We Offer',
            'section_title' => 'Our Core Services',
            'section_subtitle' => 'From admission guidance to visa processing, we handle every step of your international education journey.',
            'services' => [
                [
                    'icon' => '*',
                    'title' => 'Admission Guidance',
                    'description' => 'At HASU Educational, we simplify your journey to studying abroad, making it personalized, seamless, and stress-free.',
                    'link_label' => 'Read More',
                    'link_url' => route('contact'),
                ],
                [
                    'icon' => '*',
                    'title' => 'Study Visa Counseling',
                    'description' => 'Guiding you at every critical step in your journey to study abroad, ensuring clarity at every milestone.',
                    'link_label' => 'Read More',
                    'link_url' => route('contact'),
                ],
                [
                    'icon' => '*',
                    'title' => 'Financial Assistance',
                    'description' => 'At HASU International Educational Pvt. Ltd., we simplify financial guidance, scholarship, and student loan processing.',
                    'link_label' => 'Read More',
                    'link_url' => route('contact'),
                ],
                [
                    'icon' => '*',
                    'title' => 'Visa Assistance',
                    'description' => 'HASU International Educational Pvt. Ltd. simplifies your visa application process for a smooth international transition.',
                    'link_label' => 'Read More',
                    'link_url' => route('contact'),
                ],
            ],
            'is_active' => true,
        ]);
    }
}
