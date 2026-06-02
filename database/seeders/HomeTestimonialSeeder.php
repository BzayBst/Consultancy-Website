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
            'section_label_ja' => 'お客様の声と成功事例',
            'section_title' => 'What Our Students Say',
            'section_title_ja' => '学生の声',
            'section_subtitle' => 'Real words from students, parents, and partners whose lives were changed by HASU.',
            'section_subtitle_ja' => 'HASUによって人生が変わった学生、保護者、パートナーからの実際の声です。',
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
            'testimonials_ja' => [
                [
                    'quote' => '親として、息子の日本留学に信頼できるコンサルタントを探していました。HASUは透明性と専門性を持って私たちを導き、すべてを丁寧に対応して各段階で最新情報を共有してくれました。',
                    'name' => 'プラモド・アディカリ様',
                    'role' => '保護者 - 日本留学',
                    'avatar' => 'PA',
                    'rating' => 5,
                ],
                [
                    'quote' => '私たちはHASUと数年間提携しており、紹介される学生の質に常に感銘を受けています。チームは学生が日本での生活に学業面でも文化面でも備えられるよう支援しています。',
                    'name' => '中村 卓成様',
                    'role' => '京都国際アカデミー校長',
                    'avatar' => 'TN',
                    'rating' => 5,
                ],
                [
                    'quote' => 'HASUのおかげで日本留学の夢が実現しました。JLPT対策からビザ申請まで、すべての段階を専門的にサポートしてくれました。',
                    'name' => 'アニル・タパ様',
                    'role' => '大阪大学、日本',
                    'avatar' => 'AT',
                    'rating' => 5,
                ],
            ],
            'is_active' => true,
        ]);
    }
}
