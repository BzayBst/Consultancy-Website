<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = [
        'hero_slides' => [
            'badge' => 'string',
            'title_line1' => 'string',
            'title_line2' => 'string',
            'title_highlight' => 'string',
            'title_line3' => 'string',
            'description' => 'text',
            'features' => 'json',
            'btn_primary_label' => 'string',
            'btn_ghost_label' => 'string',
            'image_alt' => 'string',
        ],
        'home_abouts' => [
            'image_alt' => 'string',
            'badge_label' => 'string',
            'section_label' => 'string',
            'section_title' => 'string',
            'paragraph_1' => 'text',
            'paragraph_2' => 'text',
            'badges' => 'json',
            'perks' => 'json',
            'cta_label' => 'string',
        ],
        'home_services' => [
            'section_label' => 'string',
            'section_title' => 'string',
            'section_subtitle' => 'text',
            'services' => 'json',
        ],
        'home_testimonials' => [
            'section_label' => 'string',
            'section_title' => 'string',
            'section_subtitle' => 'text',
        ],
        'home_popup_banners' => [
            'section_title' => 'string',
            'subtitle' => 'text',
            'button_label' => 'string',
        ],
        'why_us_sections' => [
            'section_label' => 'string',
            'title' => 'string',
            'description' => 'text',
            'badge_label' => 'string',
        ],
        'why_us_features' => [
            'title' => 'string',
            'description' => 'text',
        ],
        'core_values_sections' => [
            'section_label' => 'string',
            'title' => 'string',
            'subtitle' => 'text',
        ],
        'core_values' => [
            'title' => 'string',
            'description' => 'text',
        ],
        'about_heroes' => [
            'badge' => 'string',
            'title' => 'string',
            'highlight' => 'string',
            'subtitle' => 'text',
        ],
        'about_stories' => [
            'float_badge_title' => 'string',
            'float_badge_subtitle' => 'string',
            'section_label' => 'string',
            'section_title' => 'string',
            'paragraph_1' => 'text',
            'paragraph_2' => 'text',
        ],
        'about_milestones' => [
            'title' => 'string',
            'description' => 'text',
        ],
        'about_stats' => [
            'label' => 'string',
        ],
        'about_mv_cards' => [
            'title' => 'string',
            'body' => 'text',
        ],
        'course_pages' => [
            'hero_badge' => 'string',
            'hero_title' => 'string',
            'hero_highlight' => 'string',
            'hero_subtitle' => 'text',
            'intro_label' => 'string',
            'intro_title' => 'string',
            'intro_subtitle' => 'text',
            'catalog_label' => 'string',
            'catalog_title' => 'string',
            'why_label' => 'string',
            'why_title' => 'string',
            'why_description' => 'text',
            'cta_title' => 'string',
            'cta_subtitle' => 'text',
            'cta_button_label' => 'string',
            'cta_phone_label' => 'string',
        ],
        'courses' => [
            'title' => 'string',
            'badge' => 'string',
            'tag' => 'string',
            'excerpt' => 'text',
            'overview' => 'text',
            'description' => 'json',
            'meta_items' => 'json',
            'highlights' => 'json',
            'sidebar_title' => 'string',
            'sidebar_subtitle' => 'text',
            'sidebar_items' => 'json',
        ],
        'study_abroad_pages' => [
            'hero_badge' => 'string',
            'hero_title' => 'string',
            'hero_highlight' => 'string',
            'hero_subtitle' => 'text',
            'section_label' => 'string',
            'section_title' => 'string',
            'cta_title' => 'string',
            'cta_subtitle' => 'text',
            'cta_button_label' => 'string',
        ],
        'study_abroad_destinations' => [
            'name' => 'string',
            'card_title' => 'string',
            'card_description' => 'text',
            'overview' => 'text',
            'benefits_title' => 'string',
            'benefits_description' => 'text',
            'requirements' => 'json',
            'scholarship_text' => 'text',
        ],
        'ventures' => [
            'name' => 'string',
            'tagline' => 'string',
            'tag_label' => 'string',
            'description' => 'text',
            'long_description' => 'longText',
            'highlights' => 'json',
            'section_title' => 'string',
            'primary_btn_label' => 'string',
            'secondary_btn_label' => 'string',
        ],
        'events' => [
            'title' => 'string',
            'description' => 'text',
            'long_description' => 'longText',
            'highlights' => 'json',
            'location' => 'string',
            'organizer' => 'string',
        ],
        'blog_posts' => [
            'title' => 'string',
            'excerpt' => 'text',
            'content' => 'longText',
            'meta_title' => 'string',
            'meta_description' => 'text',
        ],
        'gallery_images' => [
            'title' => 'string',
            'alt_text' => 'string',
        ],
        'contact_pages' => [
            'hero_title' => 'string',
            'hero_highlight' => 'string',
            'hero_subtitle' => 'text',
            'form_title' => 'string',
            'form_subtitle' => 'text',
            'branch_title' => 'string',
            'branch_subtitle' => 'text',
            'faq_label' => 'string',
            'faq_title' => 'string',
            'faq_subtitle' => 'text',
            'social_title' => 'string',
            'social_subtitle' => 'text',
        ],
        'appointment_pages' => [
            'hero_title' => 'string',
            'hero_highlight' => 'string',
            'hero_subtitle' => 'text',
            'form_title' => 'string',
            'form_subtitle' => 'text',
            'faq_label' => 'string',
            'faq_title' => 'string',
            'faq_subtitle' => 'text',
            'cta_title' => 'string',
            'cta_subtitle' => 'text',
        ],
        'branch_offices' => [
            'name' => 'string',
            'location_label' => 'string',
            'address' => 'text',
            'weekday_hours' => 'string',
            'saturday_hours' => 'string',
        ],
        'contact_faqs' => [
            'question' => 'string',
            'answer' => 'text',
        ],
        'teams' => [
            'name' => 'string',
            'designation' => 'string',
            'bio' => 'text',
        ],
    ];

    public function up(): void
    {
        foreach ($this->tables as $table => $fields) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) use ($table, $fields) {
                foreach ($fields as $field => $type) {
                    $column = $field.'_ja';

                    if (! Schema::hasColumn($table, $field) || Schema::hasColumn($table, $column)) {
                        continue;
                    }

                    $definition = match ($type) {
                        'text' => $blueprint->text($column),
                        'longText' => $blueprint->longText($column),
                        'json' => $blueprint->json($column),
                        default => $blueprint->string($column),
                    };

                    $definition->nullable()->after($field);
                }
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table => $fields) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) use ($table, $fields) {
                foreach (array_keys($fields) as $field) {
                    $column = $field.'_ja';

                    if (Schema::hasColumn($table, $column)) {
                        $blueprint->dropColumn($column);
                    }
                }
            });
        }
    }
};
