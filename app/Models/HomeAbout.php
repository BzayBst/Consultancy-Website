<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeAbout extends Model
{
    protected $table = 'home_abouts';

    protected $fillable = [
        'image_path', 'image_alt',
        'badge_number', 'badge_label',
        'section_label', 'section_title',
        'paragraph_1', 'paragraph_2',
        'badges', 'perks',
        'cta_label', 'cta_href',
    ];

    protected $casts = [
        'badges' => 'array',
        'perks'  => 'array',
    ];

    public function imageUrl(): ?string
    {
        if (! $this->image_path) return null;
        return str_starts_with($this->image_path, 'http')
            ? $this->image_path
            : \Illuminate\Support\Facades\Storage::url($this->image_path);
    }
}