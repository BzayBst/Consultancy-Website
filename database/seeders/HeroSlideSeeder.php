<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'badge'              => 'Building Bright Futures With HASU',
                'title_line1'        => 'Shaping Educational',
                'title_line2'        => 'And Career',
                'title_highlight'    => 'Dreams',
                'title_line3'        => 'With HASU',
                'description'        => 'Your trusted partner for global education and career success.',
                'features'           => [
                    ['icon' => '🎓', 'label' => 'Study Abroad Guidance'],
                    ['icon' => '🏫', 'label' => 'University Admissions'],
                    ['icon' => '🛂', 'label' => 'Visa Assistance'],
                    ['icon' => '💼', 'label' => 'Career Counseling'],
                ],
                'btn_primary_label'  => 'Get Started',
                'btn_primary_href'   => '#about',
                'btn_ghost_label'    => 'Our Services',
                'btn_ghost_href'     => '#services',
                'image_path'         => 'https://images.unsplash.com/photo-1529400971008-f566de0e6dfc?w=600&q=80',
                'image_alt'          => 'Student looking at globe',
                'plane_emoji'        => '✈️',
                'sort_order'         => 1,
                'is_active'          => true,
            ],
            [
                'badge'              => 'Study in Japan · Since 2013',
                'title_line1'        => 'Your Gateway to',
                'title_line2'        => null,
                'title_highlight'    => 'Japan',
                'title_line3'        => 'Starts Here',
                'description'        => 'Expert guidance for Japanese universities, NAT/JLPT prep, and student visa processing.',
                'features'           => [
                    ['icon' => '🇯🇵', 'label' => 'Japan Admissions'],
                    ['icon' => '📝', 'label' => 'NAT & JLPT Prep'],
                    ['icon' => '🛂', 'label' => 'Visa Processing'],
                    ['icon' => '🏫', 'label' => 'Partner Schools'],
                ],
                'btn_primary_label'  => 'Study in Japan',
                'btn_primary_href'   => '#study-abroad',
                'btn_ghost_label'    => 'Language Courses',
                'btn_ghost_href'     => '#courses',
                'image_path'         => 'https://images.unsplash.com/photo-1493976040374-85c8e912f1f9?w=600&q=80',
                'image_alt'          => 'Traditional Japanese lantern street',
                'plane_emoji'        => '🇯🇵',
                'sort_order'         => 2,
                'is_active'          => true,
            ],
            [
                'badge'              => 'HASU Language Institute',
                'title_line1'        => 'Master Languages.',
                'title_line2'        => 'Unlock',
                'title_highlight'    => 'Global',
                'title_line3'        => 'Opportunities',
                'description'        => 'IELTS, PTE, and Japanese language classes with certified trainers and proven results.',
                'features'           => [
                    ['icon' => '🇬🇧', 'label' => 'IELTS Coaching'],
                    ['icon' => '🇦🇺', 'label' => 'PTE Academic'],
                    ['icon' => '🗣️', 'label' => 'Japanese Classes'],
                    ['icon' => '📊', 'label' => 'Mock Tests'],
                ],
                'btn_primary_label'  => 'View Courses',
                'btn_primary_href'   => '#courses',
                'btn_ghost_label'    => 'Enroll Now',
                'btn_ghost_href'     => '#cta-banner',
                'image_path'         => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=600&q=80',
                'image_alt'          => 'Student preparing for exams',
                'plane_emoji'        => '📚',
                'sort_order'         => 3,
                'is_active'          => true,
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::updateOrCreate(
                ['sort_order' => $slide['sort_order']],
                $slide
            );
        }

        $this->command->info('✅ Hero slides seeded: ' . count($slides) . ' slides.');
    }
}