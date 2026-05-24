<?php

namespace Database\Seeders;

use App\Models\CoreValue;
use App\Models\CoreValuesSection;
use Illuminate\Database\Seeder;

class CoreValuesSeeder extends Seeder
{
    public function run(): void
    {
        CoreValuesSection::updateOrCreate(['id' => 1], [
            'section_label' => 'Core Values',
            'title'         => 'The Principles We Live By',
            'subtitle'      => 'Our values aren\'t just words on a wall — they shape every interaction, every decision, every outcome.',
        ]);

        $values = [
            ['icon' => '🔍', 'title' => 'Transparency',   'description' => 'We share honest timelines, realistic expectations, and complete information so students can make truly informed decisions.',              'sort_order' => 1],
            ['icon' => '💡', 'title' => 'Excellence',     'description' => 'We hold ourselves to the highest standards in counseling, documentation, and every service we provide.',                                   'sort_order' => 2],
            ['icon' => '❤️', 'title' => 'Student-First',  'description' => 'Every policy, every process, every decision is made with one question in mind: what is best for our student?',                           'sort_order' => 3],
            ['icon' => '🔒', 'title' => 'Integrity',      'description' => 'We do the right thing — even when it\'s difficult. Our reputation is built on trust earned one student at a time.',                       'sort_order' => 4],
            ['icon' => '🌱', 'title' => 'Empowerment',    'description' => 'We equip students with knowledge, skills, and confidence to thrive academically and professionally overseas.',                             'sort_order' => 5],
            ['icon' => '🤲', 'title' => 'Community',      'description' => 'Our alumni network stays connected — supporting each other and inspiring the next generation of global Nepali students.',                  'sort_order' => 6],
        ];

        foreach ($values as $v) {
            CoreValue::updateOrCreate(
                ['title' => $v['title']],
                array_merge($v, ['is_active' => true])
            );
        }

        $this->command->info('✅ Core Values seeded: ' . count($values) . ' values.');
    }
}