@extends('layouts.admin')

@section('title', 'Edit Page')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Edit Page: {{ $page->title }}</h1>
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
        <form method="POST" action="{{ route('admin.pages.update', $page) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" 
                           value="{{ old('title', $page->title) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-300 @enderror"
                           placeholder="Page title">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                    <input type="text" name="slug" id="slug" 
                           value="{{ old('slug', $page->slug) }}"
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
                            <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', $page->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
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
                        <option value="draft" {{ old('status', $page->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $page->status) == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta Title</label>
                <input type="text" name="meta_title" id="meta_title" 
                       value="{{ old('meta_title', $page->meta_title) }}"
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
                          placeholder="SEO meta description">{{ old('meta_description', $page->meta_description) }}</textarea>
                @error('meta_description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                       {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="ml-2 text-sm text-gray-700">Active</label>
            </div>

            <!-- Page Sections -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <label class="block text-sm font-medium text-gray-700">Page Sections</label>
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Drag sections to reorder them
                    </div>
                </div>
                <div id="sections-container" class="space-y-4">
                    @foreach($page->sections as $index => $section)
                        @include('admin.pages.partials.section-form', [
                            'section' => $section,
                            'index' => $index
                        ])
                    @endforeach
                    
                    @if($page->sections->count() == 0)
                        @include('admin.pages.partials.section-form', [
                            'section' => null,
                            'index' => 0
                        ])
                    @endif
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
                    <i class="fas fa-save mr-2"></i>Update Page
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let sectionIndex = {{ $page->sections->count() > 0 ? $page->sections->count() : 1 }};
    
    // Add section
    document.getElementById('add-section').addEventListener('click', function() {
        // For now, we'll create a simple new section and reload the form
        // In a full implementation, you'd want to dynamically create the section form
        const container = document.getElementById('sections-container');
        
        // Create a temporary basic section that will be replaced on save
        const newSection = document.createElement('div');
        newSection.className = 'section-item bg-white border-2 border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200';
        newSection.innerHTML = `
            <div class="section-header bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 rounded-t-xl border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="section-type-icon w-10 h-10 rounded-lg flex items-center justify-center text-white font-semibold text-sm">
                            <i class="fas fa-grip-vertical text-gray-400 cursor-move"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 section-type-label">
                                <i class="fas fa-align-left text-blue-500 mr-2"></i>New Text Section
                            </h4>
                            <p class="text-sm text-gray-500">Section ${sectionIndex + 1}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="button" class="toggle-section text-gray-400 hover:text-gray-600" title="Collapse/Expand">
                            <i class="fas fa-chevron-up"></i>
                        </button>
                        <button type="button" class="remove-section text-red-400 hover:text-red-600" title="Remove Section">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="section-content p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-1 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-heading text-gray-400 mr-1"></i>Section Title
                            </label>
                            <input type="text" name="sections[${sectionIndex}][title]" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter section title">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-cog text-gray-400 mr-1"></i>Section Type
                            </label>
                            <select name="sections[${sectionIndex}][type]" 
                                    class="section-type-select w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="text" selected>📝 Text Content</option>
                                <option value="html">💻 HTML Content</option>
                                <option value="image">🖼️ Image with Caption</option>
                                <option value="video">🎥 Video Embed</option>
                                <option value="gallery">🖼️ Image Gallery</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-sort-numeric-down text-gray-400 mr-1"></i>Sort Order
                            </label>
                            <input type="number" name="sections[${sectionIndex}][sort_order]" 
                                   value="${(sectionIndex + 1) * 10}"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   min="0" step="10">
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="sections[${sectionIndex}][is_active]" value="1"
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                   checked>
                            <label class="ml-2 text-sm text-gray-700">
                                <i class="fas fa-eye text-gray-400 mr-1"></i>Active
                            </label>
                        </div>
                    </div>
                    <div class="lg:col-span-2">
                        <div class="section-fields">
                            <div class="text-section-fields space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-align-left text-blue-500 mr-1"></i>Text Content
                                    </label>
                                    <textarea name="sections[${sectionIndex}][content]" rows="8"
                                              class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 font-mono text-sm"
                                              placeholder="Enter your text content here..."></textarea>
                                    <p class="text-xs text-gray-500 mt-2">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Plain text content. Line breaks will be preserved.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                if (confirm('Are you sure you want to remove this section?')) {
                    sectionItem.remove();
                }
            } else {
                alert('At least one section is required.');
            }
        }
        
        // Toggle section content
        if (e.target.closest('.toggle-section')) {
            const content = e.target.closest('.section-item').querySelector('.section-content');
            const icon = e.target.closest('.toggle-section').querySelector('i');
            
            if (content.style.display === 'none') {
                content.style.display = 'block';
                icon.className = 'fas fa-chevron-up';
            } else {
                content.style.display = 'none';
                icon.className = 'fas fa-chevron-down';
            }
        }
    });
    
    // Handle section type changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('section-type-select')) {
            const sectionItem = e.target.closest('.section-item');
            const typeLabel = sectionItem.querySelector('.section-type-label');
            const selectedType = e.target.value;
            
            // Update the section header label
            const icons = {
                'text': '<i class="fas fa-align-left text-blue-500 mr-2"></i>Text Section',
                'html': '<i class="fas fa-code text-green-500 mr-2"></i>HTML Section',
                'image': '<i class="fas fa-image text-purple-500 mr-2"></i>Image Section',
                'video': '<i class="fas fa-video text-red-500 mr-2"></i>Video Section',
                'gallery': '<i class="fas fa-images text-yellow-500 mr-2"></i>Gallery Section'
            };
            
            if (typeLabel && icons[selectedType]) {
                typeLabel.innerHTML = icons[selectedType];
            }
            
            // Note: In a full implementation, you'd want to dynamically load 
            // the appropriate section fields template here
        }
    });
    
    // Auto-generate slug from title
    document.getElementById('title').addEventListener('input', function() {
        const name = this.value;
        const slug = name.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        document.getElementById('slug').value = slug;
    });
});
</script>
@endsection