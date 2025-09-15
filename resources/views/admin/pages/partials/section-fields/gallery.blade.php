<div class="gallery-section-fields space-y-4">
    <!-- Gallery Images -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-images text-yellow-500 mr-1"></i>Gallery Images
        </label>
        <div class="gallery-container">
            <div class="gallery-grid grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4" id="gallery-grid-{{ $index }}">
                <!-- Existing images will be loaded here -->
                @if(isset($section->settings['gallery_images']))
                    @foreach($section->settings['gallery_images'] as $imageIndex => $image)
                        <div class="gallery-item relative group">
                            <img src="{{ asset('storage/' . $image['path']) }}" 
                                 alt="{{ $image['alt'] ?? '' }}" 
                                 class="w-full h-32 object-cover rounded-lg shadow-md">
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg flex items-center justify-center">
                                <div class="flex space-x-2">
                                    <button type="button" class="edit-gallery-image bg-yellow-600 text-white p-2 rounded-full hover:bg-yellow-700" data-index="{{ $imageIndex }}">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <button type="button" class="remove-gallery-image bg-red-600 text-white p-2 rounded-full hover:bg-red-700" data-index="{{ $imageIndex }}">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="sections[{{ $index }}][gallery][{{ $imageIndex }}][path]" value="{{ $image['path'] }}">
                            <input type="hidden" name="sections[{{ $index }}][gallery][{{ $imageIndex }}][alt]" value="{{ $image['alt'] ?? '' }}">
                            <input type="hidden" name="sections[{{ $index }}][gallery][{{ $imageIndex }}][caption]" value="{{ $image['caption'] ?? '' }}">
                        </div>
                    @endforeach
                @endif
                
                <!-- Add Image Button -->
                <div class="gallery-add-item border-2 border-dashed border-gray-300 rounded-lg h-32 flex items-center justify-center hover:border-yellow-400 transition-colors cursor-pointer">
                    <div class="text-center">
                        <i class="fas fa-plus text-2xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-500">Add Image</p>
                    </div>
                    <input type="file" class="hidden gallery-image-input" accept="image/*" multiple>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Description -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-align-left text-yellow-500 mr-1"></i>Gallery Description
        </label>
        <textarea name="sections[{{ $index }}][content]" rows="3"
                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500"
                  placeholder="Enter gallery description...">{{ old('sections.'.$index.'.content', $section->content ?? '') }}</textarea>
    </div>

    <!-- Gallery Layout Options -->
    <div class="bg-yellow-50 rounded-lg p-4">
        <h6 class="text-sm font-medium text-gray-700 mb-3">
            <i class="fas fa-th text-yellow-500 mr-1"></i>Gallery Layout
        </h6>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Layout Style</label>
                <select name="sections[{{ $index }}][settings][layout]" 
                        class="w-full text-sm border-gray-300 rounded focus:ring-yellow-500 focus:border-yellow-500">
                    <option value="grid" selected>Grid Layout</option>
                    <option value="masonry">Masonry Layout</option>
                    <option value="carousel">Carousel/Slider</option>
                    <option value="justified">Justified Gallery</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Columns</label>
                <select name="sections[{{ $index }}][settings][columns]" 
                        class="w-full text-sm border-gray-300 rounded focus:ring-yellow-500 focus:border-yellow-500">
                    <option value="2">2 Columns</option>
                    <option value="3" selected>3 Columns</option>
                    <option value="4">4 Columns</option>
                    <option value="5">5 Columns</option>
                    <option value="6">6 Columns</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Image Ratio</label>
                <select name="sections[{{ $index }}][settings][ratio]" 
                        class="w-full text-sm border-gray-300 rounded focus:ring-yellow-500 focus:border-yellow-500">
                    <option value="auto">Auto (Original)</option>
                    <option value="1:1" selected>Square (1:1)</option>
                    <option value="4:3">Landscape (4:3)</option>
                    <option value="16:9">Wide (16:9)</option>
                    <option value="3:4">Portrait (3:4)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Gap Size</label>
                <select name="sections[{{ $index }}][settings][gap]" 
                        class="w-full text-sm border-gray-300 rounded focus:ring-yellow-500 focus:border-yellow-500">
                    <option value="sm">Small</option>
                    <option value="md" selected>Medium</option>
                    <option value="lg">Large</option>
                    <option value="xl">Extra Large</option>
                </select>
            </div>
        </div>
        <div class="mt-3 space-y-2">
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <input type="checkbox" name="sections[{{ $index }}][settings][lightbox]" value="1"
                           class="rounded border-gray-300 text-yellow-600 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50"
                           checked>
                    <label class="ml-2 text-sm text-gray-700">Enable lightbox</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="sections[{{ $index }}][settings][captions]" value="1"
                           class="rounded border-gray-300 text-yellow-600 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50"
                           checked>
                    <label class="ml-2 text-sm text-gray-700">Show captions</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="sections[{{ $index }}][settings][lazy_load]" value="1"
                           class="rounded border-gray-300 text-yellow-600 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50"
                           checked>
                    <label class="ml-2 text-sm text-gray-700">Lazy loading</label>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="bg-gray-50 rounded-lg p-4">
        <h6 class="text-sm font-medium text-gray-700 mb-3">
            <i class="fas fa-tools text-gray-500 mr-1"></i>Bulk Actions
        </h6>
        <div class="flex flex-wrap gap-2">
            <button type="button" class="bulk-upload bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                <i class="fas fa-upload mr-1"></i>Upload Multiple
            </button>
            <button type="button" class="sort-alphabetically bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                <i class="fas fa-sort-alpha-down mr-1"></i>Sort A-Z
            </button>
            <button type="button" class="reverse-order bg-purple-600 text-white px-3 py-1 rounded text-sm hover:bg-purple-700">
                <i class="fas fa-exchange-alt mr-1"></i>Reverse Order
            </button>
            <button type="button" class="clear-all bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                <i class="fas fa-trash mr-1"></i>Clear All
            </button>
        </div>
    </div>
</div>

<!-- Image Edit Modal -->
<div id="image-edit-modal-{{ $index }}" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-semibold mb-4">Edit Image</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alt Text</label>
                <input type="text" id="edit-alt-{{ $index }}" class="w-full border-gray-300 rounded focus:ring-yellow-500 focus:border-yellow-500" placeholder="Describe the image">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Caption</label>
                <textarea id="edit-caption-{{ $index }}" rows="3" class="w-full border-gray-300 rounded focus:ring-yellow-500 focus:border-yellow-500" placeholder="Image caption"></textarea>
            </div>
        </div>
        <div class="flex justify-end space-x-2 mt-6">
            <button type="button" class="cancel-edit bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
            <button type="button" class="save-edit bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Save</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle gallery image upload
    document.addEventListener('click', function(e) {
        if (e.target.closest('.gallery-add-item')) {
            const input = e.target.closest('.gallery-add-item').querySelector('.gallery-image-input');
            input.click();
        }
        
        if (e.target.closest('.bulk-upload')) {
            const input = document.createElement('input');
            input.type = 'file';
            input.multiple = true;
            input.accept = 'image/*';
            input.onchange = function() {
                // Handle bulk upload
                console.log('Bulk upload:', this.files);
            };
            input.click();
        }
        
        if (e.target.closest('.edit-gallery-image')) {
            const index = e.target.closest('.edit-gallery-image').dataset.index;
            // Show edit modal
            document.getElementById(`image-edit-modal-{{ $index }}`).classList.remove('hidden');
        }
        
        if (e.target.closest('.remove-gallery-image')) {
            const item = e.target.closest('.gallery-item');
            if (confirm('Remove this image from the gallery?')) {
                item.remove();
            }
        }
        
        if (e.target.closest('.clear-all')) {
            if (confirm('Remove all images from the gallery?')) {
                document.querySelectorAll('.gallery-item').forEach(item => item.remove());
            }
        }
    });
    
    // Handle file input changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('gallery-image-input')) {
            const files = e.target.files;
            const grid = e.target.closest('.gallery-section-fields').querySelector('.gallery-grid');
            const addButton = grid.querySelector('.gallery-add-item');
            
            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageItem = document.createElement('div');
                    imageItem.className = 'gallery-item relative group';
                    imageItem.innerHTML = `
                        <img src="${e.target.result}" 
                             alt="" 
                             class="w-full h-32 object-cover rounded-lg shadow-md">
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg flex items-center justify-center">
                            <div class="flex space-x-2">
                                <button type="button" class="edit-gallery-image bg-yellow-600 text-white p-2 rounded-full hover:bg-yellow-700" data-index="${Date.now() + index}">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>
                                <button type="button" class="remove-gallery-image bg-red-600 text-white p-2 rounded-full hover:bg-red-700" data-index="${Date.now() + index}">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </div>
                    `;
                    grid.insertBefore(imageItem, addButton);
                };
                reader.readAsDataURL(file);
            });
            
            e.target.value = ''; // Reset input
        }
    });
});
</script>
