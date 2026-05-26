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
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'is_read' => 'boolean',
    ];
}
