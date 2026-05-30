<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentSubmission extends Model
{
    protected $fillable = [
        'reference',
        'branch',
        'appointment_date',
        'appointment_time',
        'first_name',
        'last_name',
        'email',
        'phone',
        'education',
        'destination',
        'service',
        'notes',
        'is_read',
        'status',
        'internal_notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'is_read'          => 'boolean',
    ];

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeUpcoming($query)
    {
        return $query->whereDate('appointment_date', '>=', today());
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(fn ($q) =>
            $q->where('first_name', 'like', "%{$term}%")
              ->orWhere('last_name',  'like', "%{$term}%")
              ->orWhere('email',      'like', "%{$term}%")
              ->orWhere('phone',      'like', "%{$term}%")
              ->orWhere('reference',  'like', "%{$term}%")
              ->orWhere('notes',      'like', "%{$term}%")
        );
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getInitialsAttribute(): string
    {
        return strtoupper(
            substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1)
        );
    }

    public function getIsUpcomingAttribute(): bool
    {
        return $this->appointment_date && $this->appointment_date->isFuture();
    }
}