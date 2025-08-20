<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} @yield('title', '')</title>
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="keywords" content="@yield('meta_keywords', '')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-900">
                        {{ $settings['site_name'] ?? config('app.name', 'Laravel') }}
                    </a>
                </div>
                
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" 
                       class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Home
                    </a>
                    <a href="{{ route('contact.show') }}" 
                       class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Contact
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" 
                           class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Login
                        </a>
                        <a href="{{ route('register') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Register
                        </a>
                    @endauth
                </nav>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" id="mobile-menu-button" 
                            class="text-gray-700 hover:text-gray-900 focus:outline-none focus:text-gray-900">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="space-y-1">
                    <a href="{{ route('home') }}" 
                       class="block text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">
                        Home
                    </a>
                    <a href="{{ route('contact.show') }}" 
                       class="block text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">
                        Contact
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="block text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" 
                           class="block text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">
                            Login
                        </a>
                        <a href="{{ route('register') }}" 
                           class="block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-base font-medium">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-lg font-semibold mb-4">{{ $settings['site_name'] ?? config('app.name', 'Laravel') }}</h3>
                    <p class="text-gray-300 mb-4">{{ $settings['site_description'] ?? 'Your trusted platform for excellence.' }}</p>
                    <div class="flex space-x-4">
                        @if(($settings['social_facebook'] ?? false) || ($settings['facebook_url'] ?? false))
                            <a href="{{ $settings['social_facebook'] ?? $settings['facebook_url'] }}" class="text-gray-300 hover:text-white">
                                <i class="fab fa-facebook text-xl"></i>
                            </a>
                        @endif
                        @if(($settings['social_twitter'] ?? false) || ($settings['twitter_url'] ?? false))
                            <a href="{{ $settings['social_twitter'] ?? $settings['twitter_url'] }}" class="text-gray-300 hover:text-white">
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                        @endif
                        @if(($settings['social_instagram'] ?? false) || ($settings['instagram_url'] ?? false))
                            <a href="{{ $settings['social_instagram'] ?? $settings['instagram_url'] }}" class="text-gray-300 hover:text-white">
                                <i class="fab fa-instagram text-xl"></i>
                            </a>
                        @endif
                        @if(($settings['social_linkedin'] ?? false) || ($settings['linkedin_url'] ?? false))
                            <a href="{{ $settings['social_linkedin'] ?? $settings['linkedin_url'] }}" class="text-gray-300 hover:text-white">
                                <i class="fab fa-linkedin text-xl"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white">Home</a></li>
                        <li><a href="{{ route('contact.show') }}" class="text-gray-300 hover:text-white">Contact</a></li>
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white">Dashboard</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-gray-300 hover:text-white">Login</a></li>
                            <li><a href="{{ route('register') }}" class="text-gray-300 hover:text-white">Register</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Info</h4>
                    <div class="space-y-2 text-gray-300">
                        @if($settings['contact_email'] ?? false)
                            <p><i class="fas fa-envelope mr-2"></i>{{ $settings['contact_email'] }}</p>
                        @endif
                        @if($settings['contact_phone'] ?? false)
                            <p><i class="fas fa-phone mr-2"></i>{{ $settings['contact_phone'] }}</p>
                        @endif
                        @if($settings['contact_address'] ?? false)
                            <p><i class="fas fa-map-marker-alt mr-2"></i>{{ $settings['contact_address'] }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; {{ date('Y') }} {{ $settings['site_name'] ?? config('app.name', 'Laravel') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html> 