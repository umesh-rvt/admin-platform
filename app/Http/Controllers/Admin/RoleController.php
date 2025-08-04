<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends AdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->requirePermission('roles.view');

        $query = Role::with('permissions');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('display_name', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $roles = $query->latest()->paginate(15);

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->requirePermission('roles.create');

        $permissions = Permission::active()->get()->groupBy('module');
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->requirePermission('roles.create');

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
            'is_active' => 'boolean',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'display_name' => $validated['display_name'],
            'description' => $validated['description'],
            'is_active' => $validated['is_active'] ?? true,
        ]);

        // Assign permissions
        if (!empty($validated['permissions'])) {
            $role->permissions()->attach($validated['permissions']);
        }

        $this->logActivity('create', "Created role: {$role->display_name}", $role);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $this->requirePermission('roles.view');

        $role->load(['permissions', 'users']);
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $this->requirePermission('roles.edit');

        $permissions = Permission::active()->get()->groupBy('module');
        $role->load('permissions');
        
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $this->requirePermission('roles.edit');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role->id)],
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
            'is_active' => 'boolean',
        ]);

        $role->update([
            'name' => $validated['name'],
            'display_name' => $validated['display_name'],
            'description' => $validated['description'],
            'is_active' => $validated['is_active'] ?? true,
        ]);

        // Sync permissions
        $role->permissions()->sync($validated['permissions'] ?? []);

        $this->logActivity('update', "Updated role: {$role->display_name}", $role);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->requirePermission('roles.delete');

        // Prevent deleting admin role
        if ($role->name === 'admin') {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete the admin role.');
        }

        $roleName = $role->display_name;
        $role->delete();

        $this->logActivity('delete', "Deleted role: {$roleName}");

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    /**
     * Assign permissions to role.
     */
    public function assignPermissions(Request $request, Role $role)
    {
        $this->requirePermission('roles.assign_permissions');

        $validated = $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->permissions()->sync($validated['permissions'] ?? []);

        $this->logActivity('update', "Assigned permissions to role: {$role->display_name}", $role);

        return redirect()->route('admin.roles.edit', $role)
            ->with('success', 'Permissions assigned successfully.');
    }

    /**
     * Toggle role active status.
     */
    public function toggleStatus(Role $role)
    {
        $this->requirePermission('roles.edit');

        // Prevent deactivating admin role
        if ($role->name === 'admin') {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot deactivate the admin role.');
        }

        $role->update(['is_active' => !$role->is_active]);

        $status = $role->is_active ? 'activated' : 'deactivated';
        $this->logActivity('update', "{$status} role: {$role->display_name}", $role);

        return redirect()->route('admin.roles.index')
            ->with('success', "Role {$status} successfully.");
    }
}
