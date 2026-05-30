<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class GalleryImage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'category',
        'media_type',
        'link_url',
        'image_path',
        'alt_text',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getImageUrlAttribute(): string
    {
        return Str::startsWith($this->image_path, ['http://', 'https://'])
            ? $this->image_path
            : asset('storage/' . $this->image_path);
    }

    public function getIsImageAttribute(): bool
    {
        return ($this->media_type ?? 'image') === 'image';
    }

    public function getIsExternalAttribute(): bool
    {
        return in_array($this->media_type, ['youtube', 'facebook'], true) && filled($this->link_url);
    }

    public function getMediaLabelAttribute(): string
    {
        return match ($this->media_type ?? 'image') {
            'youtube' => 'YouTube',
            'facebook' => 'Facebook',
            default => 'Photo',
        };
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('created_at');
    }
}
