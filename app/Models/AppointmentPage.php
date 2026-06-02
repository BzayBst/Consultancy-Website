<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentPage extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_title_ja',
        'hero_highlight',
        'hero_highlight_ja',
        'hero_subtitle',
        'hero_subtitle_ja',
        'form_title',
        'form_title_ja',
        'form_subtitle',
        'form_subtitle_ja',
        'faq_label',
        'faq_label_ja',
        'faq_title',
        'faq_title_ja',
        'faq_subtitle',
        'faq_subtitle_ja',
        'cta_title',
        'cta_title_ja',
        'cta_subtitle',
        'cta_subtitle_ja',
    ];
}
