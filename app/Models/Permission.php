<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    public $table = 'permissions';

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'name',
        'display_name',
        'guard_name',
        'group_name',
        'created_at',
        'updated_at',
    ];

    public function roles(): BelongsToMany
    {
        return parent::roles();
    }
}
