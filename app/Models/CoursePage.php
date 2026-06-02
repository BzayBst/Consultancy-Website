<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursePage extends Model
{
    protected $fillable = [
        'hero_badge',
        'hero_badge_ja',
        'hero_title',
        'hero_title_ja',
        'hero_highlight',
        'hero_highlight_ja',
        'hero_subtitle',
        'hero_subtitle_ja',
        'intro_label',
        'intro_label_ja',
        'intro_title',
        'intro_title_ja',
        'intro_subtitle',
        'intro_subtitle_ja',
        'stats',
        'catalog_label',
        'catalog_label_ja',
        'catalog_title',
        'catalog_title_ja',
        'why_label',
        'why_label_ja',
        'why_title',
        'why_title_ja',
        'why_description',
        'why_description_ja',
        'why_items',
        'cta_title',
        'cta_title_ja',
        'cta_subtitle',
        'cta_subtitle_ja',
        'cta_button_label',
        'cta_button_label_ja',
        'cta_button_url',
        'cta_phone_label',
        'cta_phone_label_ja',
        'cta_phone_url',
    ];

    protected $casts = [
        'stats' => 'array',
        'why_items' => 'array',
    ];
}
