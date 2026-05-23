<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutHero extends Model
{
    protected $table = 'about_heroes';

    protected $fillable = ['badge', 'title', 'highlight', 'subtitle'];
}
