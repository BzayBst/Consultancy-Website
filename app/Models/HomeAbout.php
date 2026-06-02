<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeAbout extends Model
{
    protected $table = 'home_abouts';

    protected $fillable = [
        'image_path', 'image_alt', 'image_alt_ja',
        'badge_number', 'badge_label', 'badge_label_ja',
        'section_label', 'section_title', 'section_label_ja', 'section_title_ja',
        'paragraph_1', 'paragraph_2', 'paragraph_1_ja', 'paragraph_2_ja',
        'badges', 'perks', 'badges_ja', 'perks_ja',
        'cta_label', 'cta_href', 'cta_label_ja',
    ];

    protected $casts = [
        'badges' => 'array',
        'perks'  => 'array',
        'badges_ja' => 'array',
        'perks_ja' => 'array',
    ];

    public function imageUrl(): ?string
    {
        if (! $this->image_path) return null;
        return str_starts_with($this->image_path, 'http')
            ? $this->image_path
            : \Illuminate\Support\Facades\Storage::url($this->image_path);
    }
}