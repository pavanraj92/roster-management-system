<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Roster extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'staff_id',
        'shift_id',
        'roster_date',
    ];

    protected $dates = ['roster_date'];

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
