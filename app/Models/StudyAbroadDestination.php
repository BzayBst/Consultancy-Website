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
        'name_ja',
        'slug',
        'flag',
        'card_tag',
        'card_title',
        'card_title_ja',
        'card_description',
        'card_description_ja',
        'card_image',
        'overview',
        'overview_ja',
        'benefits_title',
        'benefits_title_ja',
        'benefits_description',
        'benefits_description_ja',
        'requirements_ja',
        'benefits',
        'courses',
        'scholarship_text',
        'scholarship_text_ja',
        'cities',
        'universities',
        'faqs',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'benefits' => 'array',
        'requirements_ja' => 'array',
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
