<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursePage extends Model
{
    protected $fillable = [
        'hero_badge',
        'hero_title',
        'hero_highlight',
        'hero_subtitle',
        'intro_label',
        'intro_title',
        'intro_subtitle',
        'stats',
        'catalog_label',
        'catalog_title',
        'why_label',
        'why_title',
        'why_description',
        'why_items',
        'cta_title',
        'cta_subtitle',
        'cta_button_label',
        'cta_button_url',
        'cta_phone_label',
        'cta_phone_url',
    ];

    protected $casts = [
        'stats' => 'array',
        'why_items' => 'array',
    ];
}
