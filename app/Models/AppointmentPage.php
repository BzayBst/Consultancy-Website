<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentPage extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_highlight',
        'hero_subtitle',
        'form_title',
        'form_subtitle',
        'faq_label',
        'faq_title',
        'faq_subtitle',
        'cta_title',
        'cta_subtitle',
    ];
}
