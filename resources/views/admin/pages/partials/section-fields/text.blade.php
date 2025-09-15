<div class="text-section-fields space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-align-left text-blue-500 mr-1"></i>Text Content
        </label>
        <div class="relative">
            <textarea name="sections[{{ $index }}][content]" rows="8"
                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 font-mono text-sm"
                      placeholder="Enter your text content here...">{{ old('sections.'.$index.'.content', $section->content ?? '') }}</textarea>
            <div class="absolute bottom-2 right-2 text-xs text-gray-400">
                <span class="char-count">0</span> characters
            </div>
        </div>
        <div class="flex items-center justify-between mt-2">
            <p class="text-xs text-gray-500">
                <i class="fas fa-info-circle mr-1"></i>
                Plain text content. Line breaks will be preserved.
            </p>
            <div class="flex space-x-2">
                <button type="button" class="text-xs text-blue-600 hover:text-blue-800" onclick="insertTextTemplate('paragraph')">
                    <i class="fas fa-paragraph mr-1"></i>Paragraph
                </button>
                <button type="button" class="text-xs text-blue-600 hover:text-blue-800" onclick="insertTextTemplate('list')">
                    <i class="fas fa-list mr-1"></i>List
                </button>
            </div>
        </div>
    </div>

    <!-- Text Formatting Options -->
    <div class="bg-blue-50 rounded-lg p-4">
        <h6 class="text-sm font-medium text-gray-700 mb-3">
            <i class="fas fa-paint-brush text-blue-500 mr-1"></i>Text Formatting Options
        </h6>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Text Alignment</label>
                <select name="sections[{{ $index }}][settings][text_align]" 
                        class="w-full text-sm border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                    <option value="left">Left</option>
                    <option value="center">Center</option>
                    <option value="right">Right</option>
                    <option value="justify">Justify</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Text Size</label>
                <select name="sections[{{ $index }}][settings][text_size]" 
                        class="w-full text-sm border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                    <option value="sm">Small</option>
                    <option value="base" selected>Normal</option>
                    <option value="lg">Large</option>
                    <option value="xl">Extra Large</option>
                </select>
            </div>
        </div>
    </div>
</div>

<script>
function insertTextTemplate(type) {
    const textarea = event.target.closest('.text-section-fields').querySelector('textarea');
    let template = '';
    
    switch(type) {
        case 'paragraph':
            template = '\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\n\n';
            break;
        case 'list':
            template = '\n• First item\n• Second item\n• Third item\n\n';
            break;
    }
    
    textarea.value += template;
    textarea.focus();
}
</script>
