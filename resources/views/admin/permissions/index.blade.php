@extends('layouts.admin')

@section('title', 'Permissions')

@push('styles')
<style>
    .badge-container {
        max-height: 1.5rem;
        overflow: hidden;
    }
    .badge-container:hover {
        max-height: none;
        position: relative;
        z-index: 10;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Permissions Management</h1>
            <p class="mt-1 text-sm text-gray-600">Manage system permissions by module</p>
        </div>
        @if(auth()->user()->hasPermission('permissions.create'))
        <a href="{{ route('admin.permissions.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-plus mr-2"></i>Add Permission
        </a>
        @endif
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="GET" action="{{ route('admin.permissions.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Search Permissions</label>
                    <input type="text" name="search" id="search" 
                           value="{{ request('search') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Search by name or display name...">
                </div>
                <div>
                    <label for="module" class="block text-sm font-medium text-gray-700">Filter by Module</label>
                    <select name="module" id="module" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Modules</option>
                        @foreach($modules as $module)
                            <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>
                                {{ ucfirst($module) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Permissions by Module -->
    @forelse($permissionsByModule as $module => $modulePermissions)
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">{{ ucfirst($module) }} Module</h3>
                    <p class="text-sm text-gray-500">{{ $modulePermissions->count() }} permissions</p>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permission Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Display Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roles</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($modulePermissions as $permission)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-mono text-sm">{{ $permission->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $permission->display_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $permission->description ?: '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="badge-container">
                                @foreach($permission->roles as $role)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $role->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $role->display_name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                @if(auth()->user()->hasPermission('permissions.edit'))
                                <a href="{{ route('admin.permissions.edit', $permission) }}" 
                                   class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif
                                
                                @if(auth()->user()->hasPermission('permissions.delete'))
                                <form action="{{ route('admin.permissions.destroy', $permission) }}" 
                                      method="POST" 
                                      class="inline-block"
                                      onsubmit="return confirm('Are you sure you want to delete this permission?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <div class="text-gray-500">
            <i class="fas fa-lock text-4xl mb-4"></i>
            <p class="text-lg">No permissions found</p>
            <p class="text-sm">Try adjusting your search or filter criteria</p>
        </div>
    </div>
    @endforelse
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when module select changes
    document.getElementById('module').addEventListener('change', function() {
        this.form.submit();
    });
});
</script>
@endpush

@endsection
