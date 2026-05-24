<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'designation',
        'bio',
        'photo',
        'email',
        'phone',
        'social_links',
        'order',
        'is_active',
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_active'    => 'boolean',
        'order'        => 'integer',
    ];

    /* ------------------------------------------------------------------ */
    /*  Accessors                                                           */
    /* ------------------------------------------------------------------ */

    public function getPhotoUrlAttribute(): string
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : asset('images/admin/placeholder-avatar.png');
    }

    /* ------------------------------------------------------------------ */
    /*  Scopes                                                              */
    /* ------------------------------------------------------------------ */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    /* ------------------------------------------------------------------ */
    /*  Boot                                                                */
    /* ------------------------------------------------------------------ */

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Team $team) {
            if (empty($team->slug)) {
                $team->slug = Str::slug($team->name);
            }
        });

        static::updating(function (Team $team) {
            if ($team->isDirty('name') && ! $team->isDirty('slug')) {
                $team->slug = Str::slug($team->name);
            }
        });
    }
}
