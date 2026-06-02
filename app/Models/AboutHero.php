<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutHero extends Model
{
    protected $table = 'about_heroes';

    protected $fillable = [
        'badge', 'badge_ja',
        'title', 'title_ja',
        'highlight', 'highlight_ja',
        'subtitle', 'subtitle_ja',
    ];
}
