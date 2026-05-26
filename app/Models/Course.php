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
        'slug',
        'category',
        'badge',
        'tag',
        'excerpt',
        'image_path',
        'is_featured',
        'overview',
        'description',
        'meta_items',
        'highlights',
        'sidebar_title',
        'sidebar_subtitle',
        'sidebar_items',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'description' => 'array',
        'meta_items' => 'array',
        'highlights' => 'array',
        'sidebar_items' => 'array',
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
