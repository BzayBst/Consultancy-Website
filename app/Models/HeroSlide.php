<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class HeroSlide extends Model
{
    protected $fillable = [
        'badge',
        'title_line1',
        'title_line2',
        'title_highlight',
        'title_line3',
        'description',
        'features',
        'btn_primary_label',
        'btn_primary_href',
        'btn_ghost_label',
        'btn_ghost_href',
        'image_path',
        'image_alt',
        'plane_emoji',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'features'  => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // ── Scopes ──────────────────────────────────────────────────────────

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}