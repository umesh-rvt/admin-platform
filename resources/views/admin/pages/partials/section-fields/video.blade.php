<div class="video-section-fields space-y-4">
    <!-- Video Source -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-video text-red-500 mr-1"></i>Video Source
        </label>
        <div class="space-y-3">
            <div class="flex space-x-2">
                <button type="button" class="video-source-tab flex-1 py-2 px-4 text-sm font-medium rounded-lg border border-gray-300 bg-white hover:bg-gray-50 active" data-source="embed">
                    <i class="fab fa-youtube text-red-500 mr-1"></i>Embed (YouTube, Vimeo)
                </button>
                <button type="button" class="video-source-tab flex-1 py-2 px-4 text-sm font-medium rounded-lg border border-gray-300 bg-white hover:bg-gray-50" data-source="upload">
                    <i class="fas fa-upload text-blue-500 mr-1"></i>Upload File
                </button>
                <button type="button" class="video-source-tab flex-1 py-2 px-4 text-sm font-medium rounded-lg border border-gray-300 bg-white hover:bg-gray-50" data-source="url">
                    <i class="fas fa-link text-green-500 mr-1"></i>Direct URL
                </button>
            </div>

            <!-- Embed Code Tab -->
            <div class="video-source-content" data-source="embed">
                <textarea name="sections[{{ $index }}][content]" rows="6"
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 font-mono text-sm"
                          placeholder="Paste your YouTube or Vimeo embed code here...
Example:
<iframe width='560' height='315' src='https://www.youtube.com/embed/VIDEO_ID' frameborder='0' allowfullscreen></iframe>">{{ old('sections.'.$index.'.content', $section->content ?? '') }}</textarea>
                <div class="flex items-center justify-between mt-2">
                    <p class="text-xs text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Paste the embed code from YouTube, Vimeo, or other video platforms
                    </p>
                    <button type="button" class="text-xs text-red-600 hover:text-red-800" onclick="generateEmbedCode()">
                        <i class="fas fa-magic mr-1"></i>Generate from URL
                    </button>
                </div>
            </div>

            <!-- Upload Tab -->
            <div class="video-source-content hidden" data-source="upload">
                <div class="video-upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-red-400 transition-colors">
                    <i class="fas fa-video text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600 mb-2">Click to upload a video file</p>
                    <p class="text-xs text-gray-500">MP4, WebM, OGV up to 100MB</p>
                    <input type="file" name="sections[{{ $index }}][video_file]" 
                           class="hidden video-input" 
                           accept="video/*">
                    <button type="button" class="upload-video-button bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 mt-3">
                        <i class="fas fa-upload mr-1"></i>Choose Video
                    </button>
                </div>
            </div>

            <!-- Direct URL Tab -->
            <div class="video-source-content hidden" data-source="url">
                <input type="text" name="sections[{{ $index }}][video_url]" 
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                       placeholder="https://example.com/video.mp4">
                <p class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-info-circle mr-1"></i>
                    Direct URL to video file (MP4, WebM, OGV)
                </p>
            </div>
        </div>
    </div>

    <!-- Video Caption -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-closed-captioning text-red-500 mr-1"></i>Video Caption/Description
        </label>
        <textarea name="sections[{{ $index }}][caption]" rows="3"
                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500"
                  placeholder="Enter video description or caption...">{{ old('sections.'.$index.'.caption', $section->caption ?? '') }}</textarea>
    </div>

    <!-- Video Display Options -->
    <div class="bg-red-50 rounded-lg p-4">
        <h6 class="text-sm font-medium text-gray-700 mb-3">
            <i class="fas fa-cog text-red-500 mr-1"></i>Video Options
        </h6>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Aspect Ratio</label>
                <select name="sections[{{ $index }}][settings][aspect_ratio]" 
                        class="w-full text-sm border-gray-300 rounded focus:ring-red-500 focus:border-red-500">
                    <option value="16:9" selected>16:9 (Widescreen)</option>
                    <option value="4:3">4:3 (Standard)</option>
                    <option value="1:1">1:1 (Square)</option>
                    <option value="21:9">21:9 (Ultra-wide)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Max Width</label>
                <select name="sections[{{ $index }}][settings][max_width]" 
                        class="w-full text-sm border-gray-300 rounded focus:ring-red-500 focus:border-red-500">
                    <option value="sm">Small (480px)</option>
                    <option value="md">Medium (640px)</option>
                    <option value="lg" selected>Large (800px)</option>
                    <option value="xl">Extra Large (1024px)</option>
                    <option value="full">Full Width</option>
                </select>
            </div>
        </div>
        <div class="mt-3 space-y-2">
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <input type="checkbox" name="sections[{{ $index }}][settings][autoplay]" value="1"
                           class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                    <label class="ml-2 text-sm text-gray-700">Autoplay</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="sections[{{ $index }}][settings][loop]" value="1"
                           class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                    <label class="ml-2 text-sm text-gray-700">Loop</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="sections[{{ $index }}][settings][muted]" value="1"
                           class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                    <label class="ml-2 text-sm text-gray-700">Muted</label>
                </div>
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="sections[{{ $index }}][settings][controls]" value="1"
                       class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50"
                       checked>
                <label class="ml-2 text-sm text-gray-700">Show controls</label>
            </div>
        </div>
    </div>

    <!-- Quick YouTube/Vimeo URL Converter -->
    <div class="bg-blue-50 rounded-lg p-4">
        <h6 class="text-sm font-medium text-gray-700 mb-3">
            <i class="fab fa-youtube text-red-500 mr-1"></i>Quick Convert
        </h6>
        <div class="flex space-x-2">
            <input type="text" id="video-url-{{ $index }}" 
                   class="flex-1 text-sm border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Paste YouTube or Vimeo URL here...">
            <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700" 
                    onclick="convertVideoUrl({{ $index }})">
                <i class="fas fa-convert mr-1"></i>Convert
            </button>
        </div>
        <p class="text-xs text-gray-500 mt-1">
            Automatically converts YouTube/Vimeo URLs to embed codes
        </p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle video source tabs
    document.addEventListener('click', function(e) {
        if (e.target.closest('.video-source-tab')) {
            const tab = e.target.closest('.video-source-tab');
            const source = tab.dataset.source;
            const container = tab.closest('.video-section-fields');
            
            // Update active tab
            container.querySelectorAll('.video-source-tab').forEach(t => t.classList.remove('active', 'bg-blue-50', 'border-blue-300'));
            tab.classList.add('active', 'bg-blue-50', 'border-blue-300');
            
            // Show/hide content
            container.querySelectorAll('.video-source-content').forEach(content => {
                if (content.dataset.source === source) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            });
        }
        
        if (e.target.closest('.upload-video-button')) {
            const input = e.target.closest('.video-upload-area').querySelector('.video-input');
            input.click();
        }
    });
});

function convertVideoUrl(index) {
    const input = document.getElementById(`video-url-${index}`);
    const url = input.value.trim();
    const textarea = document.querySelector(`textarea[name="sections[${index}][content]"]`);
    
    if (!url) return;
    
    let embedCode = '';
    
    // YouTube URL patterns
    const youtubeRegex = /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
    const youtubeMatch = url.match(youtubeRegex);
    
    if (youtubeMatch) {
        const videoId = youtubeMatch[1];
        embedCode = `<iframe width="560" height="315" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>`;
    }
    
    // Vimeo URL patterns
    const vimeoRegex = /(?:https?:\/\/)?(?:www\.)?vimeo\.com\/(\d+)/;
    const vimeoMatch = url.match(vimeoRegex);
    
    if (vimeoMatch) {
        const videoId = vimeoMatch[1];
        embedCode = `<iframe src="https://player.vimeo.com/video/${videoId}" width="560" height="315" frameborder="0" allowfullscreen></iframe>`;
    }
    
    if (embedCode) {
        textarea.value = embedCode;
        input.value = '';
        // Switch to embed tab
        const embedTab = document.querySelector('.video-source-tab[data-source="embed"]');
        if (embedTab) embedTab.click();
    } else {
        alert('Please enter a valid YouTube or Vimeo URL');
    }
}
</script>
