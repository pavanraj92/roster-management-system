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
        return $this->belongsToMany(Role::class, 'role_has_permissions', 'permission_id', 'role_id');
    }

    /**
     * Scope for Permission Search (DataTable).
     */
    public function scopeSearch($query, string $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('display_name', 'like', "%{$keyword}%")
                ->orWhere('group_name', 'like', "%{$keyword}%")
                ->orWhere('name', 'like', "%{$keyword}%");
        });
    }

    /**
     * Accessor for display name with fallback.
     */
    public function getLabelAttribute(): string
    {
        return $this->display_name ?: ucfirst(str_replace(['_', '-'], ' ', (string) $this->name));
    }

    /**
     * Accessor for group name with fallback.
     */
    public function getGroupLabelAttribute(): string
    {
        return $this->group_name ?: 'System';
    }

    public function scopeWebGuard($query)
    {
        return $query->where('guard_name', 'web');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('group_name')
            ->orderBy('display_name')
            ->orderBy('name');
    }
}
