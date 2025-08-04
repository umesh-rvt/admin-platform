@extends('layouts.admin')

@section('title', 'Page Details')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Page: {{ $page->title }}</h1>
        <div class="flex space-x-3">
            @if(auth()->user()->hasPermission('pages.edit'))
            <a href="{{ route('admin.pages.edit', $page) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-edit mr-2"></i>Edit Page
            </a>
            @endif
            <a href="{{ route('pages.show', $page->slug) }}" target="_blank"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-external-link-alt mr-2"></i>View Page
            </a>
            <a href="{{ route('admin.pages.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i>Back to Pages
            </a>
        </div>
    </div>

    <!-- Page Information -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Page Information</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $page->title }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Slug</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $page->slug }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $page->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($page->status) }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Active Status</label>
                    <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $page->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $page->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Created</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $page->created_at->format('M j, Y g:i A') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $page->updated_at->format('M j, Y g:i A') }}</p>
                </div>
            </div>
            
            @if($page->meta_title)
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700">Meta Title</label>
                <p class="mt-1 text-sm text-gray-900">{{ $page->meta_title }}</p>
            </div>
            @endif
            
            @if($page->meta_description)
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700">Meta Description</label>
                <p class="mt-1 text-sm text-gray-900">{{ $page->meta_description }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Page Sections -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Page Sections ({{ $page->sections->count() }})</h3>
        </div>
        <div class="p-6">
            @if($page->sections->count() > 0)
                <div class="space-y-6">
                    @foreach($page->sections as $section)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900">{{ $section->title }}</h4>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ ucfirst($section->type) }}
                                    </span>
                                </div>
                                <div class="flex space-x-2">
                                    @if(auth()->user()->hasPermission('pages.edit'))
                                    <button type="button" class="text-blue-600 hover:text-blue-900" 
                                            onclick="editSection({{ $section->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @endif
                                    @if(auth()->user()->hasPermission('pages.delete'))
                                    <form method="POST" action="{{ route('admin.pages.sections.destroy', [$page, $section]) }}" 
                                          class="inline" onsubmit="return confirm('Are you sure you want to delete this section?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            <div class="prose max-w-none">
                                @if($section->type === 'text')
                                    <div class="text-gray-700">{!! nl2br(e($section->content)) !!}</div>
                                @elseif($section->type === 'image')
                                    @if(filter_var($section->content, FILTER_VALIDATE_URL))
                                        <img src="{{ $section->content }}" alt="{{ $section->title }}" class="max-w-full h-auto rounded">
                                    @else
                                        <div class="text-gray-500 italic">Image URL: {{ $section->content }}</div>
                                    @endif
                                @elseif($section->type === 'video')
                                    <div class="text-gray-500 italic">Video URL: {{ $section->content }}</div>
                                @else
                                    <div class="text-gray-700">{!! nl2br(e($section->content)) !!}</div>
                                @endif
                            </div>
                            <div class="mt-4 text-xs text-gray-500">
                                Order: {{ $section->order }} | Created: {{ $section->created_at->format('M j, Y g:i A') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No sections found for this page.</p>
            @endif
        </div>
    </div>

    <!-- Add Section Form -->
    @if(auth()->user()->hasPermission('pages.edit'))
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Add New Section</h3>
        </div>
        <form method="POST" action="{{ route('admin.pages.sections.store', $page) }}" class="p-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Section Title</label>
                    <input type="text" name="title" id="title" 
                           value="{{ old('title') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-300 @enderror"
                           placeholder="Section title">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Section Type</label>
                    <select name="type" id="type" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('type') border-red-300 @enderror">
                        <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
                        <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Image</option>
                        <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video</option>
                        <option value="gallery" {{ old('type') == 'gallery' ? 'selected' : '' }}>Gallery</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-6">
                <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                <textarea name="content" id="content" rows="4"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('content') border-red-300 @enderror"
                          placeholder="Section content">{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-plus mr-2"></i>Add Section
                </button>
            </div>
        </form>
    </div>
    @endif
</div>

<script>
function editSection(sectionId) {
    // This would typically open a modal or redirect to an edit form
    // For now, we'll just show an alert
    alert('Edit section functionality would be implemented here');
}
</script>
@endsection