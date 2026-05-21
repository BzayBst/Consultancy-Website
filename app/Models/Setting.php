<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'group',
        'key',
        'value',
        'type',   // text | textarea | image | boolean | email | url | tel
    ];

    protected $casts = [
        'value' => 'string',
    ];

    // ── Scopes ──────────────────────────────────────────────────────────

    public function scopeGroup($query, string $group)
    {
        return $query->where('group', $group);
    }

    // ── Helpers ─────────────────────────────────────────────────────────

    /**
     * Cast value based on the field type.
     */
    public function typedValue(): mixed
    {
        return match ($this->type) {
            'boolean' => (bool) $this->value,
            default   => $this->value,
        };
    }
}