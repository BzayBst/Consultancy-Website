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

        // Card / listing
        'card_tag',
        'card_tag_ja',
        'card_title',
        'card_title_ja',
        'card_description',
        'card_description_ja',
        'card_image',

        // Detail page – overview
        'overview',
        'overview_ja',

        // Detail page – benefits section
        'benefits_title',
        'benefits_title_ja',
        'benefits_description',
        'benefits_description_ja',
        'benefits',          // JSON array: [{icon, title, title_ja, description, description_ja}]

        // Detail page – courses section
        'courses',           // JSON array: [{tag, tag_ja, title, title_ja, description, description_ja}]

        // Detail page – scholarship section
        'scholarship_text',
        'scholarship_text_ja',

        // Detail page – cities section
        'cities',            // JSON array: [{title, title_ja, description, description_ja, image}]

        // Detail page – institutions section
        'universities',      // JSON array: [{name, name_ja, logo}]

        // Detail page – FAQs section
        'faqs',              // JSON array: [{question, question_ja, answer, answer_ja}]

        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'benefits'    => 'array',
        'courses'     => 'array',
        'cities'      => 'array',
        'universities' => 'array',
        'faqs'        => 'array',
        'sort_order'  => 'integer',
        'is_active'   => 'boolean',
    ];

    /* ── Accessors ── */

    public function getCardImageUrlAttribute(): ?string
    {
        if (! $this->card_image) {
            return null;
        }

        return Str::startsWith($this->card_image, ['http://', 'https://'])
            ? $this->card_image
            : asset('storage/' . $this->card_image);
    }

    /* ── Scopes ── */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('country');
    }

    /* ── Boot ── */

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