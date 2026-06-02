<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeService extends Model
{
    protected $fillable = [
        'section_label',
        'section_label_ja',
        'section_title',
        'section_title_ja',
        'section_subtitle',
        'section_subtitle_ja',
        'services',
        'services_ja',
        'is_active',
    ];

    protected $casts = [
        'services' => 'array',
        'services_ja' => 'array',
        'is_active' => 'boolean',
    ];
}
