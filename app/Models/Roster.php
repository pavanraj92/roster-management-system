<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Roster extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'shift_id',
        'task_id',
        'created_by',
        'date',
    ];

    protected $dates = ['date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
