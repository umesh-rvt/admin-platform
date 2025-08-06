<x-guest-layout>
    <div class="auth-card">
        <div class="auth-header">
            <img class="auth-logo" src="{{ asset('images/logo.png') }}" alt="Logo">
            <h2 class="auth-title">Create an account</h2>
            <p class="auth-subtitle">
                Get started with your free account
            </p>
        </div>

        <div class="auth-form-container">
            <div class="auth-form">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="form-label">Full name</label>
                        <div class="mt-1">
                            <input id="name" name="name" type="text" required 
                                class="form-input" value="{{ old('name') }}" autocomplete="name">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="form-label">Email address</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" required 
                                class="form-input" value="{{ old('email') }}" autocomplete="email">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
