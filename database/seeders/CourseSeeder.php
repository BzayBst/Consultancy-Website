<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CoursePage;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        CoursePage::updateOrCreate(['id' => 1], [
            'hero_badge' => 'HASU Language Institute',
            'hero_title' => 'Language & Test Prep',
            'hero_highlight' => 'Courses',
            'hero_subtitle' => 'Internationally recognized language training and exam preparation taught by certified experts at our institute.',
            'intro_label' => 'What We Teach',
            'intro_title' => 'Prepare for Your Future Abroad',
            'intro_subtitle' => 'From Japanese language mastery to IELTS and PTE band targets, HASU offers structured programs with mock tests, small batches, and personalized coaching.',
            'stats' => [
                ['number' => '6', 'accent' => '+', 'label' => 'Active Programs'],
                ['number' => '15', 'accent' => '+', 'label' => 'Expert Trainers'],
                ['number' => '2000', 'accent' => '+', 'label' => 'Students Trained'],
                ['number' => '98', 'accent' => '%', 'label' => 'Success Rate'],
            ],
            'catalog_label' => 'Browse All',
            'catalog_title' => 'Our Course Catalog',
            'why_label' => 'Why HASU',
            'why_title' => 'Why Students Choose Our Courses',
            'why_description' => 'HASU Language Institute combines certified trainers, proven curricula, and integration with our study-abroad consultancy so your language prep and university application move forward together.',
            'why_items' => [
                ['icon' => '*', 'title' => 'Certified Trainers', 'description' => 'Experienced language instructors and test-prep coaches.'],
                ['icon' => '*', 'title' => 'Mock Tests Weekly', 'description' => 'Simulated exams with score analysis and improvement plans.'],
                ['icon' => '*', 'title' => 'Small Batches', 'description' => 'Limited class sizes for personal attention and faster progress.'],
                ['icon' => '*', 'title' => 'Study Abroad Link', 'description' => 'Seamless counseling support for admissions and visas.'],
            ],
            'cta_title' => 'Not Sure Which Course Is Right for You?',
            'cta_subtitle' => 'Visit our campus or book a free assessment. We will recommend the best program for your goals.',
            'cta_button_label' => 'Apply Now',
            'cta_button_url' => '/contact',
            'cta_phone_label' => 'Call Us Today',
            'cta_phone_url' => 'tel:+97756493528',
        ]);

        $courses = [
            [
                'title' => 'Japanese Language Course',
                'slug' => 'japanese-language-course',
                'category' => 'language',
                'badge' => 'Japanese',
                'tag' => 'Language - 6-12 Months',
                'excerpt' => 'NAT, JLPT, and J-TEST preparation for students aiming to study in Japan.',
                'image_path' => 'https://images.unsplash.com/photo-1528360983277-13d401cdc186?w=800&q=80',
                'is_featured' => true,
                'overview' => 'Prepare for study and work in Japan with HASU comprehensive Japanese language program.',
                'description' => [
                    ['body' => 'Our expert instructors guide you from beginner basics to exam-ready proficiency for NAT, JLPT, and J-TEST certifications.'],
                    ['body' => 'Classes run in small batches with flexible morning and evening timings, conversation practice, mock tests, and personalized feedback.'],
                ],
                'meta_items' => [
                    ['label' => 'NAT - JLPT - J-TEST'],
                    ['label' => '6-12 Months'],
                    ['label' => 'HASU Language Institute'],
                ],
                'highlights' => [
                    ['item' => 'Hiragana, Katakana, and Kanji fundamentals'],
                    ['item' => 'JLPT N5 to N2 grammar and vocabulary'],
                    ['item' => 'NAT and J-TEST exam strategies'],
                    ['item' => 'Conversation skills for daily life and interviews'],
                ],
                'sidebar_items' => [
                    ['label' => 'Duration', 'value' => '6-12 Months'],
                    ['label' => 'Level', 'value' => 'Beginner to Advanced'],
                    ['label' => 'Exams', 'value' => 'NAT, JLPT, J-TEST'],
                    ['label' => 'Location', 'value' => 'Bhairahawa'],
                ],
                'sort_order' => 1,
            ],
            [
                'title' => 'IELTS Preparation',
                'slug' => 'ielts-preparation',
                'category' => 'test-prep',
                'badge' => 'IELTS',
                'tag' => 'Test Prep - 2-4 Months',
                'excerpt' => 'Academic and General IELTS coaching with full mock test practice.',
                'image_path' => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=800&q=80',
                'overview' => 'Build your IELTS score with structured reading, writing, listening, and speaking practice.',
                'meta_items' => [['label' => 'Academic and General'], ['label' => '2-4 Months']],
                'highlights' => [['item' => 'Band-focused writing feedback'], ['item' => 'Speaking interview practice'], ['item' => 'Full mock test series']],
                'sidebar_items' => [['label' => 'Duration', 'value' => '2-4 Months'], ['label' => 'Mode', 'value' => 'Classroom']],
                'sort_order' => 2,
            ],
            [
                'title' => 'PTE Academic',
                'slug' => 'pte-academic',
                'category' => 'test-prep',
                'badge' => 'PTE',
                'tag' => 'Test Prep - 1-3 Months',
                'excerpt' => 'Computer-based PTE prep with scoring practice and weekly mocks.',
                'image_path' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&q=80',
                'overview' => 'Prepare for PTE Academic with section-wise strategy, timing drills, and mock score review.',
                'meta_items' => [['label' => 'Computer-Based Test'], ['label' => '1-3 Months']],
                'highlights' => [['item' => 'Speaking and writing templates'], ['item' => 'Reading and listening drills'], ['item' => 'Mock score analysis']],
                'sidebar_items' => [['label' => 'Duration', 'value' => '1-3 Months'], ['label' => 'Mode', 'value' => 'Practice Lab']],
                'sort_order' => 3,
            ],
        ];

        foreach ($courses as $course) {
            Course::updateOrCreate(['slug' => $course['slug']], array_merge([
                'sidebar_title' => 'Enroll Today',
                'sidebar_subtitle' => 'Limited seats per batch. Book your placement test and start your journey.',
                'is_active' => true,
            ], $course));
        }
    }
}
