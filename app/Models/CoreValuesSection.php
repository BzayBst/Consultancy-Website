<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoreValuesSection extends Model
{
    protected $table = 'core_values_sections';

    protected $fillable = ['section_label', 'title', 'subtitle', 'section_label_ja', 'title_ja', 'subtitle_ja'];
}
