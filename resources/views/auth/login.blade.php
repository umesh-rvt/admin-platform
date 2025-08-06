<x-guest-layout>
    <div class="auth-card">
        <div class="auth-header">
            <img class="auth-logo" src="{{ asset('images/logo.png') }}" alt="Logo">
            <h2 class="auth-title">Welcome back</h2>
            <p class="auth-subtitle">
                Sign in to access your account
            </p>
        </div>

        <div class="auth-form-container">
            <div class="auth-form">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="form-label">Email address</label>
                        <div class="mt-1">
                            <input id="email" 
                                   name="email" 
                                   type="email" 
                                   autocomplete="email" 
                                   required 
                                   class="form-input"
                                   value="{{ old('email') }}">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="form-label">Password</label>
                        <div class="mt-1">
                            <input id="password" 
                                   name="password" 
                                   type="password"
                                   required 
                                   class="form-input"
                                   autocomplete="current-password">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" 
                                   type="checkbox"
                                   name="remember"
                                   class="form-checkbox">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-sm text-primary-600 hover:text-primary-700">
                                Forgot your password?
                            </a>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="w-full btn btn-primary">
                            Sign in
                        </button>
                    </div>

                    @if (Route::has('register'))
                    <p class="text-center text-sm text-gray-600">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700">
                            Create one now
                        </a>
                    </p>
                    @endif
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
