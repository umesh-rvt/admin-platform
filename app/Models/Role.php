<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the users that belong to this role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the permissions that belong to this role.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Check if role has a specific permission.
     */
    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            return $this->permissions()->where('name', $permission)->exists();
        }
        return $this->permissions()->where('id', $permission->id)->exists();
    }

    /**
     * Assign permissions to the role.
     */
    public function assignPermissions($permissions)
    {
        if (is_array($permissions)) {
            $this->permissions()->sync($permissions);
        } else {
            $this->permissions()->attach($permissions);
        }
    }

    /**
     * Remove permissions from the role.
     */
    public function removePermissions($permissions)
    {
        if (is_array($permissions)) {
            $this->permissions()->detach($permissions);
        } else {
            $this->permissions()->detach($permissions);
        }
    }
}
