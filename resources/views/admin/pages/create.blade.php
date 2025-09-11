@extends('layouts.admin')

@section('title', 'Create Page')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Create Page</h1>
        <a href="{{ route('admin.pages.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i>Back to Pages
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Page Information</h3>
        </div>
        <form method="POST" action="{{ route('admin.pages.store') }}" class="p-6 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" 
                           value="{{ old('title') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-300 @enderror"
                           placeholder="Page title">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                    <input type="text" name="slug" id="slug" 
                           value="{{ old('slug') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('slug') border-red-300 @enderror"
                           placeholder="page-slug">
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">URL-friendly version of the title</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="categories" class="block text-sm font-medium text-gray-700">Categories</label>
                    <select name="categories[]" id="categories" multiple
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('categories') border-red-300 @enderror">
                        @foreach(App\Models\Category::active()->orderBy('name')->get() as $category)
                            <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('categories')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Hold Ctrl (Cmd on Mac) to select multiple categories</p>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-300 @enderror">
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta Title</label>
                <input type="text" name="meta_title" id="meta_title" 
                       value="{{ old('meta_title') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('meta_title') border-red-300 @enderror"
                       placeholder="SEO meta title">
                @error('meta_title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="meta_description" class="block text-sm font-medium text-gray-700">Meta Description</label>
                <textarea name="meta_description" id="meta_description" rows="3"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('meta_description') border-red-300 @enderror"
                          placeholder="SEO meta description">{{ old('meta_description') }}</textarea>
                @error('meta_description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                       {{ old('is_active', true) ? 'checked' : '' }}>
                <label for="is_active" class="ml-2 text-sm text-gray-700">Active</label>
            </div>

            <!-- Page Sections -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Page Sections</label>
                <div id="sections-container">
                    <div class="section-item border border-gray-200 rounded-lg p-4 mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Section Title</label>
                                <input type="text" name="sections[0][title]" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Section title">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Section Type</label>
                                <select name="sections[0][type]" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="text">Text</option>
                                    <option value="image">Image</option>
                                    <option value="video">Video</option>
                                    <option value="gallery">Gallery</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Content</label>
                            <textarea name="sections[0][content]" rows="4"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Section content"></textarea>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="button" class="remove-section text-red-600 hover:text-red-900">
                                <i class="fas fa-trash mr-1"></i>Remove Section
                            </button>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-section" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-plus mr-2"></i>Add Section
                </button>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.pages.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-save mr-2"></i>Create Page
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let sectionIndex = 1;
    
    // Auto-generate slug from title
    document.getElementById('title').addEventListener('input', function() {
        const title = this.value;
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        document.getElementById('slug').value = slug;
    });
    
    // Add section
    document.getElementById('add-section').addEventListener('click', function() {
        const container = document.getElementById('sections-container');
        const newSection = document.createElement('div');
        newSection.className = 'section-item border border-gray-200 rounded-lg p-4 mb-4';
        newSection.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Section Title</label>
                    <input type="text" name="sections[${sectionIndex}][title]" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Section title">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Section Type</label>
                    <select name="sections[${sectionIndex}][type]" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="text">Text</option>
                        <option value="image">Image</option>
                        <option value="video">Video</option>
                        <option value="gallery">Gallery</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Content</label>
                <textarea name="sections[${sectionIndex}][content]" rows="4"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Section content"></textarea>
            </div>
            <div class="mt-4 flex justify-end">
                <button type="button" class="remove-section text-red-600 hover:text-red-900">
                    <i class="fas fa-trash mr-1"></i>Remove Section
                </button>
            </div>
        `;
        container.appendChild(newSection);
        sectionIndex++;
    });
    
    // Remove section
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-section')) {
            const sectionItem = e.target.closest('.section-item');
            if (document.querySelectorAll('.section-item').length > 1) {
                sectionItem.remove();
            } else {
                alert('At least one section is required.');
            }
        }
    });
});
</script>
@endsection