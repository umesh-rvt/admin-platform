<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/admin.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-white border-r border-gray-200 w-64 min-h-screen flex-shrink-0 shadow-lg">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo-favicon.png') }}" alt="Logo" class="h-8 w-auto mr-3">
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">{{ config('app.name', 'Laravel') }}</h1>
                        <p class="text-sm text-gray-500">Admin Panel</p>
                    </div>
                </div>
            </div>
            
            <nav class="mt-6 px-4">
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        <i class="fas fa-tachometer-alt mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-primary-700' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                        Dashboard
                    </a>

                    @if(auth()->user()->hasPermission('users.view'))
                    <a href="{{ route('admin.users.index') }}" 
                       class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        <i class="fas fa-users mr-3 {{ request()->routeIs('admin.users.*') ? 'text-primary-700' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                        Users
                    </a>
                    @endif

                    @if(auth()->user()->hasPermission('roles.view'))
                    <a href="{{ route('admin.roles.index') }}" 
                       class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.roles.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        <i class="fas fa-user-tag mr-3 {{ request()->routeIs('admin.roles.*') ? 'text-primary-700' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                        Roles
                    </a>
                    @endif

                    @if(auth()->user()->hasPermission('permissions.view'))
                    <a href="{{ route('admin.permissions.index') }}" 
                       class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.permissions.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        <i class="fas fa-key mr-3 {{ request()->routeIs('admin.permissions.*') ? 'text-primary-700' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                        Permissions
                    </a>
                    @endif

                    @if(auth()->user()->hasPermission('categories.view'))
                    <a href="{{ route('admin.categories.index') }}" 
                       class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        <i class="fas fa-tags mr-3 {{ request()->routeIs('admin.categories.*') ? 'text-primary-700' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                        Categories
                    </a>
                    @endif

                    @if(auth()->user()->hasPermission('pages.view'))
                    <a href="{{ route('admin.pages.index') }}" 
                       class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.pages.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        <i class="fas fa-file-alt mr-3 {{ request()->routeIs('admin.pages.*') ? 'text-primary-700' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                        Pages
                    </a>
                    @endif

                    @if(auth()->user()->hasPermission('contacts.view'))
                    <a href="{{ route('admin.contacts.index') }}" 
                       class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.contacts.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        <i class="fas fa-envelope mr-3 {{ request()->routeIs('admin.contacts.*') ? 'text-primary-700' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                        Contact Submissions
                    </a>
                    @endif

                    @if(auth()->user()->hasPermission('settings.view'))
                    <a href="{{ route('admin.settings.index') }}" 
                       class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        <i class="fas fa-cog mr-3 {{ request()->routeIs('admin.settings.*') ? 'text-primary-700' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                        Settings
                    </a>
                    @endif
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm border-b">
                <div class="flex justify-between items-center px-6 py-4">
                    <div class="flex items-center">
                        <button id="sidebar-toggle" class="text-gray-500 hover:text-gray-700 lg:hidden">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h2 class="ml-4 text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                        </div>
                        
                        <div class="relative">
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('warning'))
                    <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                        {{ session('warning') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            const sidebar = document.querySelector('.bg-gray-800');
            sidebar.classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html>