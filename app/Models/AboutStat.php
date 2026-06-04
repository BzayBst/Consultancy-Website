<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutStat extends Model
{
    protected $table = 'about_stats';

    protected $fillable = ['number', 'accent', 'label', 'label_ja', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean', 'sort_order' => 'integer'];

    public function getLabelForLocaleAttribute()
    {
        if (app()->getLocale() === 'ja' && $this->label_ja) {
            return $this->label_ja;
        }

        return $this->label;
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('sort_order');
    }
}
