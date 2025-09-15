<div class="html-section-fields space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-code text-green-500 mr-1"></i>HTML Content
        </label>
        <div class="relative">
            <textarea name="sections[{{ $index }}][content]" rows="12"
                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 font-mono text-sm"
                      placeholder="<div>
    <h2>Your HTML content here</h2>
    <p>You can use any HTML tags...</p>
</div>">{{ old('sections.'.$index.'.content', $section->content ?? '') }}</textarea>
            <div class="absolute top-2 right-2">
                <button type="button" class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded" onclick="formatHTML(this)">
                    <i class="fas fa-magic mr-1"></i>Format
                </button>
            </div>
        </div>
        <div class="flex items-center justify-between mt-2">
            <p class="text-xs text-gray-500">
                <i class="fas fa-exclamation-triangle text-yellow-500 mr-1"></i>
                Raw HTML content. Be careful with user input.
            </p>
            <div class="flex space-x-2">
                <button type="button" class="text-xs text-green-600 hover:text-green-800" onclick="insertHTMLTemplate('card')">
                    <i class="fas fa-id-card mr-1"></i>Card
                </button>
                <button type="button" class="text-xs text-green-600 hover:text-green-800" onclick="insertHTMLTemplate('alert')">
                    <i class="fas fa-bell mr-1"></i>Alert
                </button>
                <button type="button" class="text-xs text-green-600 hover:text-green-800" onclick="insertHTMLTemplate('button')">
                    <i class="fas fa-mouse-pointer mr-1"></i>Button
                </button>
            </div>
        </div>
    </div>

    <!-- HTML Safety Options -->
    <div class="bg-green-50 rounded-lg p-4">
        <h6 class="text-sm font-medium text-gray-700 mb-3">
            <i class="fas fa-shield-alt text-green-500 mr-1"></i>Safety & Styling Options
        </h6>
        <div class="space-y-3">
            <div class="flex items-center">
                <input type="checkbox" name="sections[{{ $index }}][settings][sanitize]" value="1"
                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50"
                       checked>
                <label class="ml-2 text-sm text-gray-700">Sanitize HTML (recommended)</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="sections[{{ $index }}][settings][add_prose]" value="1"
                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                <label class="ml-2 text-sm text-gray-700">Apply prose styling</label>
            </div>
        </div>
    </div>
</div>

<script>
function insertHTMLTemplate(type) {
    const textarea = event.target.closest('.html-section-fields').querySelector('textarea');
    let template = '';
    
    switch(type) {
        case 'card':
            template = `
<div class="bg-white rounded-lg shadow-md p-6 mb-4">
    <h3 class="text-xl font-semibold mb-2">Card Title</h3>
    <p class="text-gray-600">Card content goes here...</p>
</div>`;
            break;
        case 'alert':
            template = `
<div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-info-circle"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm">This is an info alert message.</p>
        </div>
    </div>
</div>`;
            break;
        case 'button':
            template = `
<div class="text-center my-6">
    <a href="#" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Click Me
    </a>
</div>`;
            break;
    }
    
    textarea.value += template;
    textarea.focus();
}

function formatHTML(button) {
    const textarea = button.closest('.html-section-fields').querySelector('textarea');
    // Simple HTML formatting (you might want to use a proper HTML formatter library)
    let html = textarea.value;
    // Basic indentation
    html = html.replace(/></g, '>\n<');
    textarea.value = html;
}
</script>
