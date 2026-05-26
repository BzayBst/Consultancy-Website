<?php

namespace Database\Seeders;

use App\Models\HomeAbout;
use Illuminate\Database\Seeder;

class HomeAboutSeeder extends Seeder
{
    public function run(): void
    {
        HomeAbout::updateOrCreate(['id' => 1], [
            'image_path'    => 'https://images.unsplash.com/photo-1434030216411-0b793f4b6175?w=700&q=80',
            'image_alt'     => 'About HASU',
            'badge_number'  => '11',
            'badge_label'   => 'Years of Experience',
            'section_label' => 'About The Company',
            'section_title' => 'Your Trusted Partner in Global Education',
            'paragraph_1'   => 'Established in 2013 and officially registered in 2015, HASU International Educational Pvt. Ltd. is the best educational consultancy in Bhairahawa. We guide Nepali students to higher education opportunities in Japan, Australia, Canada, the US, UK, and New Zealand through comprehensive counseling and application support.',
            'paragraph_2'   => 'We specialize in Japanese language prep (NAT, JLPT, J-TEST), English exams (IELTS, PTE), and full visa processing — ensuring a smooth journey from planning to placement.',
            'badges'        => [
                ['icon' => '🏅', 'label' => 'Best Immigration Resources'],
                ['icon' => '🛂', 'label' => 'Visa Assistance'],
            ],
            'perks'         => [
                'Offer 100% Genuine Assistance',
                "It's Faster & Reliable Execution",
                'Accurate & Expert Advice',
            ],
            'cta_label' => 'Know More',
            'cta_href'  => '/about',
        ]);

        $this->command->info('✅ Home About section seeded.');
    }
}