<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Top 5 Reasons to Choose Japan for Your Higher Education',
                'slug' => 'top-5-reasons-to-choose-japan-for-your-higher-education',
                'category' => 'Study Guide',
                'excerpt' => 'Japan offers a unique blend of world-class technology, rich cultural heritage, and increasing opportunities for international students.',
                'image_path' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=600&q=80',
                'published_at' => '2025-10-15',
                'content' => '<p>Japan continues to be one of the most rewarding destinations for Nepali students who want quality education, practical career pathways, and a rich cultural experience.</p><h2>Why Japan stands out</h2><p>Students can access advanced academic programs, language learning opportunities, and a safe society with strong support systems for international learners.</p>',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'How to Score a Band 7.5+ in the IELTS Speaking Test',
                'slug' => 'how-to-score-a-band-75-in-the-ielts-speaking-test',
                'category' => 'Test Prep',
                'excerpt' => 'Struggling with the speaking module? Our trainers share practical strategies for improving confidence, fluency, and pronunciation.',
                'image_path' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b6175?w=600&q=80',
                'published_at' => '2025-10-02',
                'content' => '<p>A strong IELTS speaking score comes from clear structure, regular practice, and confidence in everyday English communication.</p><h2>Practice with intent</h2><p>Record your answers, review common cue cards, and focus on speaking naturally instead of memorizing full scripts.</p>',
                'sort_order' => 2,
            ],
            [
                'title' => 'A Complete Guide to Fully Funded Scholarships in 2026',
                'slug' => 'a-complete-guide-to-fully-funded-scholarships-in-2026',
                'category' => 'Scholarships',
                'excerpt' => 'Financial constraints should not stop you from dreaming big. Here are scholarship options students can start preparing for early.',
                'image_path' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=600&q=80',
                'published_at' => '2025-09-20',
                'content' => '<p>Scholarship applications reward early preparation. Students should organize academic documents, recommendation letters, and personal statements before deadlines arrive.</p>',
                'sort_order' => 3,
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::updateOrCreate(['slug' => $post['slug']], $post + ['is_active' => true]);
        }
    }
}
