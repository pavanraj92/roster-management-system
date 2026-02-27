<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerSetting extends Model
{
    protected $fillable = [
        'title',
        'sub_title',
        'image',
        'status',
        'is_sub_banner',
        'is_single_banner',
    ];
}
