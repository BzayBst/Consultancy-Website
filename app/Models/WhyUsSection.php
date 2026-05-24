<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyUsSection extends Model
{
    protected $table    = 'why_us_sections';
    protected $fillable = [
        'section_label', 'title', 'description',
        'image_path', 'image_alt',
        'badge_number', 'badge_label',
    ];
}
