<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use SoftDeletes;

    protected $table = 'attendances';

    protected $fillable = [
        'roster_id',
        'user_id',
        'shift_id',
        'date',
        'clock_in',
        'clock_out',
        'total_hours',
        'shift_status',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'clock_in' => 'datetime',
        'clock_out' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'present',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function roster() {
        return $this->belongsTo(Roster::class, 'roster_id');
    }
}
