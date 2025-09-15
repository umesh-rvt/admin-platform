<div class="image-section-fields space-y-4">
    <!-- Image Upload -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-image text-purple-500 mr-1"></i>Image
        </label>
        <div class="image-upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-purple-400 transition-colors">
            @if(isset($section->image_path) && $section->image_path)
                <div class="image-preview mb-4">
                    <img src="{{ asset('storage/' . $section->image_path) }}" 
                         alt="Section image" 
                         class="max-w-full max-h-48 mx-auto rounded-lg shadow-md">
                    <input type="hidden" name="sections[{{ $index }}][image_path]" value="{{ $section->image_path }}">
                </div>
                <div class="flex justify-center space-x-2">
                    <button type="button" class="change-image bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700">
                        <i class="fas fa-exchange-alt mr-1"></i>Change Image
                    </button>
                    <button type="button" class="remove-image bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700">
                        <i class="fas fa-trash mr-1"></i>Remove
                    </button>
                </div>
            @else
                <div class="upload-placeholder">
                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600 mb-2">Click to upload an image or drag and drop</p>
                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                    <input type="file" name="sections[{{ $index }}][image]" 
                           class="hidden image-input" 
                           accept="image/*">
                    <button type="button" class="upload-button bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 mt-3">
                        <i class="fas fa-upload mr-1"></i>Choose Image
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Image Caption -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-quote-right text-purple-500 mr-1"></i>Image Caption
        </label>
        <textarea name="sections[{{ $index }}][content]" rows="3"
                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500"
                  placeholder="Enter image caption or description...">{{ old('sections.'.$index.'.content', $section->content ?? '') }}</textarea>
        <p class="text-xs text-gray-500 mt-1">
            <i class="fas fa-info-circle mr-1"></i>
            Optional caption that will appear below the image
        </p>
    </div>

    <!-- Image Display Options -->
    <div class="bg-purple-50 rounded-lg p-4">
        <h6 class="text-sm font-medium text-gray-700 mb-3">
            <i class="fas fa-cog text-purple-500 mr-1"></i>Display Options
        </h6>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Image Size</label>
                <select name="sections[{{ $index }}][settings][size]" 
                        class="w-full text-sm border-gray-300 rounded focus:ring-purple-500 focus:border-purple-500">
                    <option value="small">Small (25%)</option>
                    <option value="medium">Medium (50%)</option>
                    <option value="large" selected>Large (75%)</option>
                    <option value="full">Full Width (100%)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Alignment</label>
                <select name="sections[{{ $index }}][settings][align]" 
                        class="w-full text-sm border-gray-300 rounded focus:ring-purple-500 focus:border-purple-500">
                    <option value="left">Left</option>
                    <option value="center" selected>Center</option>
                    <option value="right">Right</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Border Radius</label>
                <select name="sections[{{ $index }}][settings][rounded]" 
                        class="w-full text-sm border-gray-300 rounded focus:ring-purple-500 focus:border-purple-500">
                    <option value="none">None</option>
                    <option value="sm">Small</option>
                    <option value="md" selected>Medium</option>
                    <option value="lg">Large</option>
                    <option value="full">Full (Circle)</option>
                </select>
            </div>
        </div>
        <div class="mt-3 flex items-center space-x-4">
            <div class="flex items-center">
                <input type="checkbox" name="sections[{{ $index }}][settings][shadow]" value="1"
                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50"
                       checked>
                <label class="ml-2 text-sm text-gray-700">Add shadow</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="sections[{{ $index }}][settings][lightbox]" value="1"
                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                <label class="ml-2 text-sm text-gray-700">Enable lightbox</label>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle image upload button clicks
    document.addEventListener('click', function(e) {
        if (e.target.closest('.upload-button')) {
            const input = e.target.closest('.image-upload-area').querySelector('.image-input');
            input.click();
        }
        
        if (e.target.closest('.change-image')) {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = function() {
                // Handle image change
                console.log('Image changed:', this.files[0]);
            };
            input.click();
        }
        
        if (e.target.closest('.remove-image')) {
            const uploadArea = e.target.closest('.image-upload-area');
            uploadArea.innerHTML = `
                <div class="upload-placeholder">
                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600 mb-2">Click to upload an image or drag and drop</p>
                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                    <input type="file" name="sections[${uploadArea.closest('.section-item').dataset.index}][image]" 
                           class="hidden image-input" 
                           accept="image/*">
                    <button type="button" class="upload-button bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 mt-3">
                        <i class="fas fa-upload mr-1"></i>Choose Image
                    </button>
                </div>
            `;
        }
    });
    
    // Handle file input changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('image-input')) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const uploadArea = file.closest('.image-upload-area');
                    uploadArea.innerHTML = `
                        <div class="image-preview mb-4">
                            <img src="${e.target.result}" 
                                 alt="Section image" 
                                 class="max-w-full max-h-48 mx-auto rounded-lg shadow-md">
                        </div>
                        <div class="flex justify-center space-x-2">
                            <button type="button" class="change-image bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700">
                                <i class="fas fa-exchange-alt mr-1"></i>Change Image
                            </button>
                            <button type="button" class="remove-image bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700">
                                <i class="fas fa-trash mr-1"></i>Remove
                            </button>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        }
    });
});
</script>
