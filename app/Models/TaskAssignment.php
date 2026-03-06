<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskAssignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'task_id',
        'staff_id',
        'assigned_date',
        'deadline',
        'status',
    ];

    protected $dates = [
        'assigned_date',
        'deadline'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
