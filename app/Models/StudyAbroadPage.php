<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyAbroadPage extends Model
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
        'section_label',
        'section_label_ja',
        'section_title',
        'section_title_ja',
        'cta_title',
        'cta_title_ja',
        'cta_subtitle',
        'cta_subtitle_ja',
        'cta_button_label',
        'cta_button_label_ja',
        'cta_button_url',
    ];
}
