<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchOffice extends Model
{
    protected $fillable = [
        'name',
        'name_ja',
        'location_label',
        'location_label_ja',
        'address',
        'address_ja',
        'phone',
        'email',
        'weekday_hours',
        'weekday_hours_ja',
        'saturday_hours',
        'saturday_hours_ja',
        'map_embed_url',
        'map_link_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
