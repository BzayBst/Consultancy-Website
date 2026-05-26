<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeTestimonial extends Model
{
    protected $fillable = [
        'section_label',
        'section_title',
        'section_subtitle',
        'testimonials',
        'is_active',
    ];

    protected $casts = [
        'testimonials' => 'array',
        'is_active' => 'boolean',
    ];
}
