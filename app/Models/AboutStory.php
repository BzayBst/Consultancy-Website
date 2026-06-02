<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutStory extends Model
{
    protected $table = 'about_stories';

    protected $fillable = [
        'image_path', 'float_badge_icon',
        'float_badge_title', 'float_badge_title_ja',
        'float_badge_subtitle', 'float_badge_subtitle_ja',
        'section_label', 'section_label_ja',
        'section_title', 'section_title_ja',
        'paragraph_1', 'paragraph_1_ja',
        'paragraph_2', 'paragraph_2_ja',
    ];
}
