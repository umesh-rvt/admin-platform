<div class="section-item bg-white border-2 border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200" data-section-id="{{ $section->id ?? '' }}">
    <!-- Section Header -->
    <div class="section-header bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 rounded-t-xl border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="section-type-icon w-10 h-10 rounded-lg flex items-center justify-center text-white font-semibold text-sm">
                    <i class="fas fa-grip-vertical text-gray-400 cursor-move"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 section-type-label">
                        @switch($section->type ?? 'text')
                            @case('text') <i class="fas fa-align-left text-blue-500 mr-2"></i>Text Section @break
                            @case('html') <i class="fas fa-code text-green-500 mr-2"></i>HTML Section @break
                            @case('image') <i class="fas fa-image text-purple-500 mr-2"></i>Image Section @break
                            @case('video') <i class="fas fa-video text-red-500 mr-2"></i>Video Section @break
                            @case('gallery') <i class="fas fa-images text-yellow-500 mr-2"></i>Gallery Section @break
                            @default <i class="fas fa-align-left text-blue-500 mr-2"></i>Text Section
                        @endswitch
                    </h4>
                    <p class="text-sm text-gray-500">Section {{ ($index ?? 0) + 1 }}</p>
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

    <!-- Section Content -->
    <div class="section-content p-6">
        @if(isset($section->id))
            <input type="hidden" name="sections[{{ $index }}][id]" value="{{ $section->id }}">
        @endif
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Basic Fields -->
            <div class="lg:col-span-1 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-heading text-gray-400 mr-1"></i>Section Title
                    </label>
                    <input type="text" name="sections[{{ $index }}][title]" 
                           value="{{ old('sections.'.$index.'.title', $section->title ?? '') }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Enter section title">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-cog text-gray-400 mr-1"></i>Section Type
                    </label>
                    <select name="sections[{{ $index }}][type]" 
                            class="section-type-select w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            data-index="{{ $index }}">
                        <option value="text" {{ ($section->type ?? 'text') == 'text' ? 'selected' : '' }}>📝 Text Content</option>
                        <option value="html" {{ ($section->type ?? '') == 'html' ? 'selected' : '' }}>💻 HTML Content</option>
                        <option value="image" {{ ($section->type ?? '') == 'image' ? 'selected' : '' }}>🖼️ Image with Caption</option>
                        <option value="video" {{ ($section->type ?? '') == 'video' ? 'selected' : '' }}>🎥 Video Embed</option>
                        <option value="gallery" {{ ($section->type ?? '') == 'gallery' ? 'selected' : '' }}>🖼️ Image Gallery</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-sort-numeric-down text-gray-400 mr-1"></i>Sort Order
                    </label>
                    <input type="number" name="sections[{{ $index }}][sort_order]" 
                           value="{{ old('sections.'.$index.'.sort_order', $section->sort_order ?? ($index + 1) * 10) }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           min="0" step="10">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="sections[{{ $index }}][is_active]" value="1"
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                           {{ old('sections.'.$index.'.is_active', $section->is_active ?? true) ? 'checked' : '' }}>
                    <label class="ml-2 text-sm text-gray-700">
                        <i class="fas fa-eye text-gray-400 mr-1"></i>Active
                    </label>
                </div>
            </div>

            <!-- Dynamic Content Fields -->
            <div class="lg:col-span-2">
                <div class="section-fields">
                    @include('admin.pages.partials.section-fields.' . ($section->type ?? 'text'), [
                        'section' => $section ?? null,
                        'index' => $index
                    ])
                </div>
            </div>
        </div>

        <!-- Section Preview -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="flex items-center justify-between mb-3">
                <h5 class="text-sm font-medium text-gray-700">
                    <i class="fas fa-eye text-gray-400 mr-1"></i>Preview
                </h5>
                <button type="button" class="refresh-preview text-blue-600 hover:text-blue-800 text-sm">
                    <i class="fas fa-refresh mr-1"></i>Refresh Preview
                </button>
            </div>
            <div class="section-preview bg-gray-50 border border-gray-200 rounded-lg p-4 min-h-[100px]">
                <div class="text-gray-500 text-center py-8">
                    <i class="fas fa-eye text-3xl mb-2"></i>
                    <p>Preview will appear here</p>
                </div>
            </div>
        </div>
    </div>
</div>
