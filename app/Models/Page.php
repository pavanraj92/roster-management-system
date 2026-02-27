<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use Sluggable, SoftDeletes;

    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'short_description',
        'description',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => false,
                'includeTrashed' => true,
            ]
        ];
    }
}
