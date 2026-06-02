<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPage extends Model
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
        'branch_title',
        'branch_title_ja',
        'branch_subtitle',
        'branch_subtitle_ja',
        'faq_label',
        'faq_label_ja',
        'faq_title',
        'faq_title_ja',
        'faq_subtitle',
        'faq_subtitle_ja',
        'social_title',
        'social_title_ja',
        'social_subtitle',
        'social_subtitle_ja',
    ];
}
