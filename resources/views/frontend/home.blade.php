@extends('layouts.frontend')

@section('title', 'Home')
@section('meta_description', $settings['site_description'] ?? 'Welcome to our platform')
@section('meta_keywords', $settings['site_keywords'] ?? '')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                {{ $settings['hero_title'] ?? 'Welcome to Our Platform' }}
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100">
                {{ $settings['hero_subtitle'] ?? 'Your trusted platform for excellence and innovation' }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact.show') }}" 
                   class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold text-lg transition-colors">
                    Get Started
                </a>
                @guest
                <a href="{{ route('register') }}" 
                   class="border-2 border-white text-white hover:bg-white hover:text-blue-600 px-8 py-3 rounded-lg font-semibold text-lg transition-colors">
                    Sign Up
                </a>
                @endguest
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose Us</h2>
            <p class="text-xl text-gray-600">Discover what makes us different</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-lg shadow-md text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Secure & Reliable</h3>
                <p class="text-gray-600">Your data is protected with industry-leading security measures.</p>
            </div>
            
            <div class="bg-white p-8 rounded-lg shadow-md text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-rocket text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Fast & Efficient</h3>
                <p class="text-gray-600">Lightning-fast performance that keeps you productive.</p>
            </div>
            
            <div class="bg-white p-8 rounded-lg shadow-md text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-headset text-2xl text-purple-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">24/7 Support</h3>
                <p class="text-gray-600">Round-the-clock support to help you succeed.</p>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">About Our Platform</h2>
                <p class="text-lg text-gray-600 mb-6">
                    {{ $settings['about_content'] ?? 'We are dedicated to providing the best experience for our users. Our platform combines cutting-edge technology with user-friendly design to deliver exceptional results.' }}
                </p>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-gray-700">Advanced security features</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-gray-700">User-friendly interface</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-gray-700">24/7 customer support</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-gray-700">Regular updates and improvements</span>
                    </div>
                </div>
            </div>
            <div class="bg-gray-200 rounded-lg p-8 text-center">
                <i class="fas fa-chart-line text-6xl text-blue-600 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Growing Together</h3>
                <p class="text-gray-600">Join thousands of satisfied users who trust our platform.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-blue-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
        <p class="text-xl mb-8 text-blue-100">Join our platform today and experience the difference.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact.show') }}" 
               class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold text-lg transition-colors">
                Contact Us
            </a>
            @guest
            <a href="{{ route('register') }}" 
               class="border-2 border-white text-white hover:bg-white hover:text-blue-600 px-8 py-3 rounded-lg font-semibold text-lg transition-colors">
                Sign Up Now
            </a>
            @endguest
        </div>
    </div>
</section>
@endsection 