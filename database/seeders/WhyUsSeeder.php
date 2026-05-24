<?php

namespace Database\Seeders;

use App\Models\WhyUsFeature;
use App\Models\WhyUsSection;
use Illuminate\Database\Seeder;

class WhyUsSeeder extends Seeder
{
    public function run(): void
    {
        WhyUsSection::updateOrCreate(['id' => 1], [
            'section_label' => 'Why Choose HASU',
            'title'         => 'Reasons Students Trust Us',
            'description'   => 'With over a decade of experience and thousands of successful placements, HASU stands apart from the rest. We don\'t just process applications — we build futures.',
            'image_path'    => 'https://images.unsplash.com/photo-1529400971008-f566de0e6dfc?w=700&q=80',
            'image_alt'     => 'HASU students',
            'badge_number'  => '98%',
            'badge_label'   => 'Visa Success Rate',
        ]);

        $features = [
            ['icon' => '✅', 'title' => '100% Genuine Assistance',   'description' => 'No false promises. Every piece of advice we give is honest, verified, and in your best interest.',                                      'sort_order' => 1],
            ['icon' => '⚡', 'title' => 'Fast & Reliable Execution',  'description' => 'We process applications swiftly and accurately, never missing critical deadlines or intake windows.',                                    'sort_order' => 2],
            ['icon' => '🏅', 'title' => 'Expert Team',               'description' => 'Our counselors are certified specialists with first-hand knowledge of destination countries and institutions.',                          'sort_order' => 3],
            ['icon' => '🤝', 'title' => 'End-to-End Support',        'description' => 'From first consultation to pre-departure briefing, we are by your side every single step of the way.',                                  'sort_order' => 4],
            ['icon' => '🛂', 'title' => 'High Visa Success Rate',    'description' => 'Our meticulous document preparation and strategic counseling ensure a 98% visa approval rate.',                                          'sort_order' => 5],
            ['icon' => '🌏', 'title' => 'Global University Network', 'description' => 'Official partnerships with leading universities across Japan, Australia, UK, Canada, USA, and more.',                                    'sort_order' => 6],
        ];

        foreach ($features as $feat) {
            WhyUsFeature::updateOrCreate(
                ['title' => $feat['title']],
                array_merge($feat, ['is_active' => true])
            );
        }

        $this->command->info('✅ Why Us section seeded.');
    }
}