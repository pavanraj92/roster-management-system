<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use SoftDeletes;

    protected $table = 'shifts';

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'color',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function rosters()
    {
        return $this->hasMany(Roster::class);
    }
}
