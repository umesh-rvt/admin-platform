<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionController extends AdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->requirePermission('permissions.view');

        $query = Permission::with('roles');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('display_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by module if requested
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        // Get permissions and group them by module
        $permissions = $query->get();
        $permissionsByModule = $permissions->groupBy('module');
        
        // Get unique modules for filter
        $modules = $permissionsByModule->keys()->sort();

        return view('admin.permissions.index', compact('permissionsByModule', 'modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->requirePermission('permissions.create');

        $modules = Permission::distinct()->pluck('module')->filter()->sort();
        return view('admin.permissions.create', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->requirePermission('permissions.create');

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'module' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $permission = Permission::create($validated);

        $this->logActivity('create', "Created permission: {$permission->display_name}", $permission);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        $this->requirePermission('permissions.view');

        $permission->load('roles');
        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        $this->requirePermission('permissions.edit');

        $modules = Permission::distinct()->pluck('module')->filter()->sort();
        return view('admin.permissions.edit', compact('permission', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $this->requirePermission('permissions.edit');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($permission->id)],
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'module' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $permission->update($validated);

        $this->logActivity('update', "Updated permission: {$permission->display_name}", $permission);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $this->requirePermission('permissions.delete');

        $permissionName = $permission->display_name;
        $permission->delete();

        $this->logActivity('delete', "Deleted permission: {$permissionName}");

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }

    /**
     * Toggle permission active status.
     */
    public function toggleStatus(Permission $permission)
    {
        $this->requirePermission('permissions.edit');

        $permission->update(['is_active' => !$permission->is_active]);

        $status = $permission->is_active ? 'activated' : 'deactivated';
        $this->logActivity('update', "{$status} permission: {$permission->display_name}", $permission);

        return redirect()->route('admin.permissions.index')
            ->with('success', "Permission {$status} successfully.");
    }

    /**
     * Get permissions by module.
     */
    public function getByModule($module)
    {
        $this->requirePermission('permissions.view');

        $permissions = Permission::where('module', $module)->active()->get();
        
        return response()->json($permissions);
    }
}
