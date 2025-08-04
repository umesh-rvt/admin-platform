@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">User: {{ $user->name }}</h1>
        <div class="flex space-x-3">
            @if(auth()->user()->hasPermission('users.edit'))
            <a href="{{ route('admin.users.edit', $user) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-edit mr-2"></i>Edit User
            </a>
            @endif
            <a href="{{ route('admin.users.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i>Back to Users
            </a>
        </div>
    </div>

    <!-- User Information -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">User Information</h3>
        </div>
        <div class="p-6">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0 h-20 w-20">
                    <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center">
                        <span class="text-2xl font-medium text-gray-700">
                            {{ substr($user->name, 0, 1) }}
                        </span>
                    </div>
                </div>
                <div class="ml-6">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email Verified</label>
                    <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Created</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M j, Y g:i A') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('M j, Y g:i A') }}</p>
                </div>
                @if($user->last_login_at)
                <div>
                    <label class="block text-sm font-medium text-gray-700">Last Login</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->last_login_at->format('M j, Y g:i A') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- User Roles -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Assigned Roles ({{ $user->roles->count() }})</h3>
                @if(auth()->user()->hasPermission('users.edit'))
                <button type="button" onclick="showAssignRolesModal()" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                    <i class="fas fa-plus mr-2"></i>Assign Roles
                </button>
                @endif
            </div>
        </div>
        <div class="p-6">
            @if($user->roles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($user->roles as $role)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium text-gray-900">{{ $role->display_name }}</h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $role->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $role->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mb-3">{{ $role->name }}</p>
                            @if($role->description)
                                <p class="text-xs text-gray-600 mb-3">{{ Str::limit($role->description, 80) }}</p>
                            @endif
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">{{ $role->permissions->count() }} permissions</span>
                                @if(auth()->user()->hasPermission('roles.view'))
                                <a href="{{ route('admin.roles.show', $role) }}" 
                                   class="text-blue-600 hover:text-blue-900 text-xs">
                                    View Role
                                </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No roles assigned to this user.</p>
            @endif
        </div>
    </div>

    <!-- User Permissions (through roles) -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Effective Permissions</h3>
        </div>
        <div class="p-6">
            @php
                $allPermissions = collect();
                foreach($user->roles as $role) {
                    $allPermissions = $allPermissions->merge($role->permissions);
                }
                $allPermissions = $allPermissions->unique('id')->groupBy('module');
            @endphp
            
            @if($allPermissions->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($allPermissions as $module => $modulePermissions)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 mb-3">{{ ucfirst($module) }}</h4>
                            <div class="space-y-2">
                                @foreach($modulePermissions as $permission)
                                    <div class="flex items-center">
                                        <i class="fas fa-check text-green-600 mr-2 text-xs"></i>
                                        <span class="text-xs text-gray-700">{{ $permission->display_name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">This user has no permissions through assigned roles.</p>
            @endif
        </div>
    </div>

    <!-- Activity Log (if available) -->
    @if($user->activities ?? false)
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Recent Activity</h3>
        </div>
        <div class="p-6">
            @if($user->activities->count() > 0)
                <div class="space-y-4">
                    @foreach($user->activities->take(10) as $activity)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600 text-xs"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900">{{ $activity->description }}</p>
                                <p class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No recent activity</p>
            @endif
        </div>
    </div>
    @endif

    <!-- Quick Actions -->
    @if(auth()->user()->hasPermission('users.edit'))
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @if($user->id !== auth()->id())
                <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full {{ $user->is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-2 rounded-lg">
                        <i class="fas {{ $user->is_active ? 'fa-ban' : 'fa-check' }} mr-2"></i>
                        {{ $user->is_active ? 'Deactivate' : 'Activate' }} User
                    </button>
                </form>
                @endif

                @if(!$user->email_verified_at)
                <button type="button" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-envelope mr-2"></i>Send Verification
                </button>
                @endif

                <button type="button" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-key mr-2"></i>Reset Password
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Assign Roles Modal -->
    @if(auth()->user()->hasPermission('users.edit'))
    <div id="assign-roles-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg shadow-lg p-6 w-96 max-h-96 overflow-y-auto">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Assign Roles</h3>
                <form method="POST" action="{{ route('admin.users.assign-roles', $user) }}">
                    @csrf
                    <div class="space-y-3 mb-4">
                        @foreach($availableRoles as $role)
                            <label class="flex items-center">
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                       class="rounded border-gray-300 text-blue-600"
                                       {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">{{ $role->display_name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="hideAssignRolesModal()" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                            Cancel
                        </button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                            Update Roles
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
function showAssignRolesModal() {
    document.getElementById('assign-roles-modal').classList.remove('hidden');
}

function hideAssignRolesModal() {
    document.getElementById('assign-roles-modal').classList.add('hidden');
}
</script>
@endsection