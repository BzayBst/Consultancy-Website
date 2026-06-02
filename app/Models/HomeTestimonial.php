<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeTestimonial extends Model
{
    protected $fillable = [
        'section_label',
        'section_label_ja',
        'section_title',
        'section_title_ja',
        'section_subtitle',
        'section_subtitle_ja',
        'testimonials',
        'is_active',
    ];

    protected $casts = [
        'testimonials' => 'array',
        'is_active' => 'boolean',
    ];
}
