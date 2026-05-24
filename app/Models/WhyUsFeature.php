<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyUsFeature extends Model
{
    protected $table = 'why_us_features';

    protected $fillable = ['icon', 'title', 'description', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean', 'sort_order' => 'integer'];

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('sort_order')->orderBy('id');
    }
}
