<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Traits\HasPermissions;

class Role extends SpatieRole
{
    use HasPermissions;

    public $table = 'roles';
    public $timestamps = true;

    protected $dates = [
        'created_at',
        'updated_at',
        // 'deleted_at',
    ];

    protected $fillable = [
        'name',
        'guard_name',
        'created_at',
        'updated_at',
        // 'deleted_at',
    ];

    public function adminUsers()
    {
        return $this->belongsToMany(User::class, 'model_has_roles', 'role_id', 'model_id')
            ->where('guard_name', 'web');
    }

    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions', 'role_id', 'permission_id')
            ->where('guard_name', 'web');
    }


    public function getGuardName()
    {
        return $this->guard_name;
    }

    /**
     * Scope a query to only include assignable roles (excluding admin/super-admin).
     */
    public function scopeAssignable($query)
    {
        return $query->where('guard_name', 'web')
            ->whereNotIn('name', ['admin', 'super-admin'])
            ->orderBy('name');
    }
}
