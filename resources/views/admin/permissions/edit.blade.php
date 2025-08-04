@extends('layouts.admin')

@section('title', 'Edit Permission')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Edit Permission: {{ $permission->display_name }}</h1>
        <a href="{{ route('admin.permissions.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i>Back to Permissions
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Permission Information</h3>
        </div>
        <form method="POST" action="{{ route('admin.permissions.update', $permission) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" 
                           value="{{ old('name', $permission->name) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-300 @enderror"
                           placeholder="e.g., users.create">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Use dot notation: module.action (e.g., users.create, pages.edit)</p>
                </div>

                <div>
                    <label for="display_name" class="block text-sm font-medium text-gray-700">Display Name</label>
                    <input type="text" name="display_name" id="display_name" 
                           value="{{ old('display_name', $permission->display_name) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('display_name') border-red-300 @enderror"
                           placeholder="e.g., Create Users">
                    @error('display_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="module" class="block text-sm font-medium text-gray-700">Module</label>
                    <select name="module" id="module" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('module') border-red-300 @enderror">
                        <option value="">Select Module</option>
                        <option value="users" {{ old('module', $permission->module) == 'users' ? 'selected' : '' }}>Users</option>
                        <option value="roles" {{ old('module', $permission->module) == 'roles' ? 'selected' : '' }}>Roles</option>
                        <option value="permissions" {{ old('module', $permission->module) == 'permissions' ? 'selected' : '' }}>Permissions</option>
                        <option value="pages" {{ old('module', $permission->module) == 'pages' ? 'selected' : '' }}>Pages</option>
                        <option value="contacts" {{ old('module', $permission->module) == 'contacts' ? 'selected' : '' }}>Contacts</option>
                        <option value="settings" {{ old('module', $permission->module) == 'settings' ? 'selected' : '' }}>Settings</option>
                        <option value="dashboard" {{ old('module', $permission->module) == 'dashboard' ? 'selected' : '' }}>Dashboard</option>
                    </select>
                    @error('module')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="action" class="block text-sm font-medium text-gray-700">Action</label>
                    <select name="action" id="action" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('action') border-red-300 @enderror">
                        <option value="">Select Action</option>
                        <option value="view" {{ old('action', $permission->action) == 'view' ? 'selected' : '' }}>View</option>
                        <option value="create" {{ old('action', $permission->action) == 'create' ? 'selected' : '' }}>Create</option>
                        <option value="edit" {{ old('action', $permission->action) == 'edit' ? 'selected' : '' }}>Edit</option>
                        <option value="delete" {{ old('action', $permission->action) == 'delete' ? 'selected' : '' }}>Delete</option>
                        <option value="publish" {{ old('action', $permission->action) == 'publish' ? 'selected' : '' }}>Publish</option>
                        <option value="manage" {{ old('action', $permission->action) == 'manage' ? 'selected' : '' }}>Manage</option>
                    </select>
                    @error('action')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-300 @enderror"
                          placeholder="Permission description...">{{ old('description', $permission->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                       {{ old('is_active', $permission->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="ml-2 text-sm text-gray-700">Active</label>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.permissions.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-save mr-2"></i>Update Permission
                </button>
            </div>
        </form>
    </div>
</div>
@endsection