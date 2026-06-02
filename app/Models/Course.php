<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'title_ja',
        'slug',
        'category',
        'badge',
        'badge_ja',
        'tag',
        'tag_ja',
        'excerpt',
        'excerpt_ja',
        'image_path',
        'is_featured',
        'overview',
        'overview_ja',
        'description',
        'description_ja',
        'meta_items',
        'meta_items_ja',
        'highlights',
        'highlights_ja',
        'sidebar_title',
        'sidebar_title_ja',
        'sidebar_subtitle',
        'sidebar_subtitle_ja',
        'sidebar_items',
        'sidebar_items_ja',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'description' => 'array',
        'description_ja' => 'array',
        'meta_items' => 'array',
        'meta_items_ja' => 'array',
        'highlights' => 'array',
        'highlights_ja' => 'array',
        'sidebar_items' => 'array',
        'sidebar_items_ja' => 'array',
        'sort_order' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        return Str::startsWith($this->image_path, ['http://', 'https://'])
            ? $this->image_path
            : asset('storage/' . $this->image_path);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (Course $course) {
            if (! $course->slug) {
                $course->slug = Str::slug($course->title);
            }
        });
    }
}
