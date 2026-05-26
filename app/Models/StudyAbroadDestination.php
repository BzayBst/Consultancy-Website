<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class StudyAbroadDestination extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'country',
        'slug',
        'flag',
        'card_tag',
        'card_title',
        'card_description',
        'card_image',
        'overview',
        'benefits_title',
        'benefits_description',
        'benefits',
        'courses',
        'scholarship_text',
        'cities',
        'universities',
        'faqs',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'benefits' => 'array',
        'courses' => 'array',
        'cities' => 'array',
        'universities' => 'array',
        'faqs' => 'array',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function getCardImageUrlAttribute(): ?string
    {
        if (! $this->card_image) {
            return null;
        }

        return Str::startsWith($this->card_image, ['http://', 'https://'])
            ? $this->card_image
            : asset('storage/' . $this->card_image);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('country');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (StudyAbroadDestination $destination) {
            if (! $destination->slug) {
                $destination->slug = Str::slug($destination->country);
            }
        });
    }
}
