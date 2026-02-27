<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisibilitySetting extends Model
{
    protected $fillable = [
        'key',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];
}
