<?php

namespace Database\Seeders;

use App\Models\HomeTestimonial;
use Illuminate\Database\Seeder;

class HomeTestimonialSeeder extends Seeder
{
    public function run(): void
    {
        HomeTestimonial::updateOrCreate(['id' => 1], [
            'section_label' => 'Testimonials And Success Stories',
            'section_title' => 'What Our Students Say',
            'section_subtitle' => 'Real words from students, parents, and partners whose lives were changed by HASU.',
            'testimonials' => [
                [
                    'quote' => "As a parent, I was looking for a reliable consultancy for my son's study in Japan. HASU guided us with transparency and professionalism. They took care of everything and kept us updated at every stage.",
                    'name' => 'Mr. Pramod Adhikari',
                    'role' => 'Parent - Study in Japan',
                    'avatar' => 'PA',
                    'rating' => 5,
                ],
                [
                    'quote' => 'We have partnered with HASU for several years and are consistently impressed by the quality of students they recommend. Their team prepares students academically and culturally for life in Japan.',
                    'name' => 'Mr. Takunari Nakamura',
                    'role' => 'Principal, Kyoto International Academy of Language',
                    'avatar' => 'TN',
                    'rating' => 5,
                ],
                [
                    'quote' => 'HASU made my dream of studying in Japan a reality. From JLPT coaching to visa processing, every step was handled with professionalism.',
                    'name' => 'Anil Thapa',
                    'role' => 'Osaka University, Japan',
                    'avatar' => 'AT',
                    'rating' => 5,
                ],
            ],
            'is_active' => true,
        ]);
    }
}
