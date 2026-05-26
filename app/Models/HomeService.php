<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeService extends Model
{
    protected $fillable = [
        'section_label',
        'section_title',
        'section_subtitle',
        'services',
        'is_active',
    ];

    protected $casts = [
        'services' => 'array',
        'is_active' => 'boolean',
    ];
}
