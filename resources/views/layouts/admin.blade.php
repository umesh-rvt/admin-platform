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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 min-h-screen flex-shrink-0">
            <div class="p-4">
                <h1 class="text-2xl font-bold">{{ config('app.name', 'Laravel') }}</h1>
                <p class="text-gray-400 text-sm">Admin Panel</p>
            </div>
            
            <nav class="mt-8">
                <div class="px-4 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>

                    @if(auth()->user()->hasPermission('users.view'))
                    <a href="{{ route('admin.users.index') }}" 
                       class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <i class="fas fa-users mr-3"></i>
                        Users
                    </a>
                    @endif

                    @if(auth()->user()->hasPermission('roles.view'))
                    <a href="{{ route('admin.roles.index') }}" 
                       class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.roles.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <i class="fas fa-user-tag mr-3"></i>
                        Roles
                    </a>
                    @endif

                    @if(auth()->user()->hasPermission('permissions.view'))
                    <a href="{{ route('admin.permissions.index') }}" 
                       class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.permissions.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <i class="fas fa-key mr-3"></i>
                        Permissions
                    </a>
                    @endif

                    @if(auth()->user()->hasPermission('pages.view'))
                    <a href="{{ route('admin.pages.index') }}" 
                       class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.pages.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <i class="fas fa-file-alt mr-3"></i>
                        Pages
                    </a>
                    @endif

                    @if(auth()->user()->hasPermission('contacts.view'))
                    <a href="{{ route('admin.contacts.index') }}" 
                       class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.contacts.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <i class="fas fa-envelope mr-3"></i>
                        Contact Submissions
                    </a>
                    @endif

                    @if(auth()->user()->hasPermission('settings.view'))
                    <a href="{{ route('admin.settings.index') }}" 
                       class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <i class="fas fa-cog mr-3"></i>
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
                            <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                        </div>
                        
                        <div class="relative">
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-sign-out-alt"></i>
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