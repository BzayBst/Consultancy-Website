<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyAbroadPage extends Model
{
    protected $fillable = [
        'hero_badge',
        'hero_title',
        'hero_highlight',
        'hero_subtitle',
        'section_label',
        'section_title',
        'cta_title',
        'cta_subtitle',
        'cta_button_label',
        'cta_button_url',
    ];
}
