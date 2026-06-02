<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'title_ja',
        'description',        // short (used in listing rows)
        'description_ja',
        'long_description',   // rich detail page content
        'long_description_ja',
        'highlights',         // JSON array of bullet points
        'highlights_ja',
        'event_date',
        'event_end_date',
        'event_time',
        'status',
        'location',
        'location_ja',
        'organizer',
        'organizer_ja',
        'learn_more_url',
        'image',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'event_date'     => 'date',
        'event_end_date' => 'date',
        'is_active'      => 'boolean',
        'is_featured'    => 'boolean',
        'highlights'     => 'array',
        'highlights_ja'  => 'array',
    ];

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/admin/placeholder-event.png');
    }

    public function scopeActive($query)   { return $query->where('is_active', true); }
    public function scopeUpcoming($query) { return $query->where('status', 'upcoming'); }
    public function scopeFeatured($query) { return $query->where('is_featured', true); }
}
