<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Venture extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'name_ja', 'slug', 'tagline', 'tagline_ja', 'category', 'status',
        'emoji', 'banner_gradient', 'tag_label', 'tag_label_ja', 'tag_color', 'tag_bg', 'accent_color',
        'description', 'description_ja', 'long_description', 'long_description_ja', 'highlights', 'highlights_ja', 'section_title', 'section_title_ja',
        'location', 'established', 'email', 'phone', 'website_url',
        'primary_btn_label', 'primary_btn_label_ja', 'primary_btn_url',
        'secondary_btn_label', 'secondary_btn_label_ja', 'secondary_btn_url',
        'banner_image', 'is_featured', 'is_active', 'order',
    ];

    protected $casts = [
        'highlights'  => 'array',
        'highlights_ja'  => 'array',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
        'order'       => 'integer',
    ];

    /* ── Accessors ── */

    public function getBannerImageUrlAttribute(): string
    {
        return $this->banner_image
            ? asset('storage/' . $this->banner_image)
            : '';
    }

    public function getBannerStyleAttribute(): string
    {
        return $this->banner_gradient
            ? "background:linear-gradient({$this->banner_gradient})"
            : 'background:linear-gradient(135deg,#0d1560,#2952e3)';
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'flagship'    => 'Flagship Venture',
            'active'      => 'Active',
            'new'         => 'New',
            'coming_soon' => 'Coming Soon',
            default       => ucfirst($this->status),
        };
    }

    /* ── Scopes ── */

    public function scopeActive($q)   { return $q->where('is_active', true)->whereNull('deleted_at'); }
    public function scopeOrdered($q)  { return $q->orderBy('order')->orderBy('name'); }
    public function scopeFeatured($q) { return $q->where('is_featured', true); }

    /* ── Boot ── */

    protected static function boot(): void
    {
        parent::boot();
        static::creating(fn ($v) => $v->slug = $v->slug ?: self::uniqueSlug($v->name));
        static::updating(function ($v) {
            if ($v->isDirty('name') && ! $v->isDirty('slug')) {
                $v->slug = self::uniqueSlug($v->name, $v->id);
            }
        });
    }

    private static function uniqueSlug(string $name, ?int $exceptId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i    = 1;
        while (static::withTrashed()->where('slug', $slug)->when($exceptId, fn($q) => $q->where('id','!=',$exceptId))->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }
        return $slug;
    }
}
