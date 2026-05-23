<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutStory extends Model
{
    protected $table = 'about_stories';

    protected $fillable = [
        'image_path', 'float_badge_icon', 'float_badge_title',
        'float_badge_subtitle', 'section_label', 'section_title',
        'paragraph_1', 'paragraph_2',
    ];
}
