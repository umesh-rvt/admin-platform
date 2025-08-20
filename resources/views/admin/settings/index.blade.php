@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Site Settings</h1>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        
        <!-- General Settings -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">General Settings</h3>
            </div>
            <div class="p-6 space-y-6">
                @foreach($settings['general'] ?? [] as $setting)
                    @unless(in_array($setting->key, ['hero_title', 'hero_subtitle', 'about_content']))
                        <div>
                            <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700">
                                {{ $setting->display_name }}
                            </label>
                            @if($setting->description)
                                <p class="text-sm text-gray-500 mb-2">{{ $setting->description }}</p>
                            @endif
                            
                            @if($setting->type === 'textarea')
                                <textarea name="{{ $setting->key }}" id="{{ $setting->key }}" rows="3"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old($setting->key, $setting->value) }}</textarea>
                            @elseif($setting->type === 'image')
                                <div class="mt-1 flex items-center space-x-4">
                                    @if($setting->value)
                                        <img src="{{ asset('storage/' . $setting->value) }}" alt="{{ $setting->display_name }}" class="h-20 w-20 object-cover rounded">
                                    @endif
                                    <input type="file" name="{{ $setting->key }}" id="{{ $setting->key }}"
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>
                            @else
                                <input type="{{ $setting->type }}" name="{{ $setting->key }}" id="{{ $setting->key }}"
                                       value="{{ old($setting->key, $setting->value) }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @endif
                        </div>
                    @endunless
                @endforeach
            </div>
        </div>

        <!-- Homepage Content Settings -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Homepage Content</h3>
            </div>
            <div class="p-6 space-y-6">
                @foreach($settings['general'] ?? [] as $setting)
                    @if(in_array($setting->key, ['hero_title', 'hero_subtitle', 'about_content']))
                        <div>
                            <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700">
                                {{ $setting->display_name }}
                            </label>
                            @if($setting->description)
                                <p class="text-sm text-gray-500 mb-2">{{ $setting->description }}</p>
                            @endif
                            
                            @if($setting->type === 'textarea')
                                <textarea name="{{ $setting->key }}" id="{{ $setting->key }}" rows="3"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old($setting->key, $setting->value) }}</textarea>
                            @else
                                <input type="{{ $setting->type }}" name="{{ $setting->key }}" id="{{ $setting->key }}"
                                       value="{{ old($setting->key, $setting->value) }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Layout Settings -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Layout Settings</h3>
            </div>
            <div class="p-6 space-y-6">
                @foreach($settings['layout'] ?? [] as $setting)
                    <div>
                        <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700">
                            {{ $setting->display_name }}
                        </label>
                        @if($setting->description)
                            <p class="text-sm text-gray-500 mb-2">{{ $setting->description }}</p>
                        @endif
                        
                        @if($setting->type === 'textarea')
                            <textarea name="{{ $setting->key }}" id="{{ $setting->key }}" rows="3"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old($setting->key, $setting->value) }}</textarea>
                        @elseif($setting->type === 'image')
                            <div class="mt-1 flex items-center space-x-4">
                                @if($setting->value)
                                    <img src="{{ asset('storage/' . $setting->value) }}" alt="{{ $setting->display_name }}" class="h-20 w-20 object-cover rounded">
                                @endif
                                <input type="file" name="{{ $setting->key }}" id="{{ $setting->key }}"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        @else
                            <input type="{{ $setting->type }}" name="{{ $setting->key }}" id="{{ $setting->key }}"
                                   value="{{ old($setting->key, $setting->value) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Contact Settings -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Contact Settings</h3>
            </div>
            <div class="p-6 space-y-6">
                @foreach($settings['contact'] ?? [] as $setting)
                    @unless(str_contains($setting->key, 'contact_label_'))
                        <div>
                            <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700">
                                {{ $setting->display_name }}
                            </label>
                            @if($setting->description)
                                <p class="text-sm text-gray-500 mb-2">{{ $setting->description }}</p>
                            @endif
                            
                            @if($setting->type === 'textarea')
                                <textarea name="{{ $setting->key }}" id="{{ $setting->key }}" rows="3"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old($setting->key, $setting->value) }}</textarea>
                            @else
                                <input type="{{ $setting->type }}" name="{{ $setting->key }}" id="{{ $setting->key }}"
                                       value="{{ old($setting->key, $setting->value) }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @endif
                        </div>
                    @endunless
                @endforeach
            </div>
        </div>

        <!-- Social Media Settings -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Social Media Settings</h3>
            </div>
            <div class="p-6 space-y-6">
                @foreach($settings['social'] ?? [] as $setting)
                    <div>
                        <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700">
                            {{ $setting->display_name }}
                        </label>
                        @if($setting->description)
                            <p class="text-sm text-gray-500 mb-2">{{ $setting->description }}</p>
                        @endif
                        
                        <input type="{{ $setting->type }}" name="{{ $setting->key }}" id="{{ $setting->key }}"
                               value="{{ old($setting->key, $setting->value) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Email Settings -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Email Settings</h3>
            </div>
            <div class="p-6 space-y-6">
                @foreach($settings['email'] ?? [] as $setting)
                    <div>
                        <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700">
                            {{ $setting->display_name }}
                        </label>
                        @if($setting->description)
                            <p class="text-sm text-gray-500 mb-2">{{ $setting->description }}</p>
                        @endif
                        
                        <input type="{{ $setting->type }}" name="{{ $setting->key }}" id="{{ $setting->key }}"
                               value="{{ old($setting->key, $setting->value) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Contact Form Labels -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Contact Form Labels</h3>
            </div>
            <div class="p-6 space-y-6">
                @foreach($settings['contact'] ?? [] as $setting)
                    @if(str_contains($setting->key, 'contact_label_'))
                        <div>
                            <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700">
                                {{ $setting->display_name }}
                            </label>
                            @if($setting->description)
                                <p class="text-sm text-gray-500 mb-2">{{ $setting->description }}</p>
                            @endif
                            
                            <input type="{{ $setting->type }}" name="{{ $setting->key }}" id="{{ $setting->key }}"
                                   value="{{ old($setting->key, $setting->value) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                <i class="fas fa-save mr-2"></i>Save Settings
            </button>
        </div>
    </form>
</div>
@endsection 