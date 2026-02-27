<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class EmailTemplate extends Model
{
    use SoftDeletes, Sluggable;

    protected $fillable = [
        'name',
        'subject',
        'description',
        'status',
        'slug',
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
                'source' => 'name',
                'onUpdate' => false,
                'includeTrashed' => true,
            ]
        ];
    }
}