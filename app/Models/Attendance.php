<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'roster_id',
        'user_id',
        'shift_id',
        'date',
        'clock_in',
        'clock_out',
        'total_hours',
        'status'
        ];

    public function roster() {
        return $this->belongsTo(Roster::class, 'roster_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shift() {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}
