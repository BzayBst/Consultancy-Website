<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPage extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_highlight',
        'hero_subtitle',
        'form_title',
        'form_subtitle',
        'branch_title',
        'branch_subtitle',
        'faq_label',
        'faq_title',
        'faq_subtitle',
        'social_title',
        'social_subtitle',
    ];
}
