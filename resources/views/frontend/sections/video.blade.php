{{-- Video Section --}}
<section class="section-video py-12 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="section-content">
            @if($section->title)
                <div class="text-center mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        {{ $section->title }}
                    </h2>
                    <div class="w-20 h-1 bg-gradient-to-r from-red-500 to-pink-500 mx-auto rounded-full"></div>
                </div>
            @endif
            
            @if($section->content || $section->video_url)
                @php
                    $settings = json_decode($section->settings ?? '{}', true);
                    $aspectRatio = $settings['aspect_ratio'] ?? '16:9';
                    $maxWidth = $settings['max_width'] ?? 'lg';
                    $autoplay = $settings['autoplay'] ?? false;
                    $loop = $settings['loop'] ?? false;
                    $muted = $settings['muted'] ?? false;
                    $controls = $settings['controls'] ?? true;
                    
                    $aspectClasses = [
                        '16:9' => 'aspect-w-16 aspect-h-9',
                        '4:3' => 'aspect-w-4 aspect-h-3',
                        '1:1' => 'aspect-w-1 aspect-h-1',
                        '21:9' => 'aspect-w-21 aspect-h-9'
                    ];
                    
                    $maxWidthClasses = [
                        'sm' => 'max-w-md',
                        'md' => 'max-w-lg',
                        'lg' => 'max-w-4xl',
                        'xl' => 'max-w-6xl',
                        'full' => 'max-w-full'
                    ];
                @endphp
                
                <div class="video-container {{ $maxWidthClasses[$maxWidth] ?? 'max-w-4xl' }} mx-auto">
                    <div class="video-wrapper relative {{ $aspectClasses[$aspectRatio] ?? 'aspect-w-16 aspect-h-9' }} rounded-xl overflow-hidden shadow-2xl bg-black">
                        @if($section->content)
                            {{-- Embed code (YouTube, Vimeo, etc.) --}}
                            <div class="video-embed">
                                {!! $section->content !!}
                            </div>
                        @elseif($section->video_url)
                            {{-- Direct video URL --}}
                            <video class="w-full h-full object-cover" 
                                   {{ $controls ? 'controls' : '' }}
                                   {{ $autoplay ? 'autoplay' : '' }}
                                   {{ $loop ? 'loop' : '' }}
                                   {{ $muted ? 'muted' : '' }}
                                   preload="metadata">
                                <source src="{{ $section->video_url }}" type="video/mp4">
                                <source src="{{ $section->video_url }}" type="video/webm">
                                <p class="text-center text-gray-500 p-8">
                                    Your browser doesn't support HTML5 video. 
                                    <a href="{{ $section->video_url }}" class="text-red-500 underline">Download the video</a> instead.
                                </p>
                            </video>
                        @endif
                        
                        {{-- Video overlay for better visual appeal --}}
                        <div class="video-overlay absolute inset-0 bg-gradient-to-t from-black/20 to-transparent pointer-events-none"></div>
                        
                        {{-- Play button overlay for non-autoplay videos --}}
                        @if(!$autoplay && $section->content)
                            <div class="play-overlay absolute inset-0 flex items-center justify-center pointer-events-none">
                                <div class="play-button bg-red-600 text-white rounded-full p-4 shadow-lg transform transition-transform hover:scale-110">
                                    <i class="fas fa-play text-2xl ml-1"></i>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    @if($section->caption ?? $section->content)
                        <div class="video-caption mt-6 text-center">
                            <div class="prose prose-lg prose-red max-w-none mx-auto">
                                <div class="text-gray-600 leading-relaxed">
                                    {!! nl2br(e($section->caption ?? '')) !!}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</section>

<style>
.section-video .video-wrapper {
    position: relative;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.section-video .video-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at center, transparent 0%, rgba(0, 0, 0, 0.1) 100%);
    pointer-events: none;
    z-index: 1;
}

.section-video .video-embed iframe,
.section-video .video-embed video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
    border-radius: 0.75rem;
}

.section-video .play-overlay {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.section-video .video-wrapper:hover .play-overlay {
    opacity: 1;
}

.section-video .play-button {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
    }
    70% {
        transform: scale(1.05);
        box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
    }
    100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
    }
}

.section-video video {
    background: #000;
}

/* Custom video controls styling */
.section-video video::-webkit-media-controls-panel {
    background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.8));
}

.section-video .video-caption {
    max-width: 42rem;
    margin: 0 auto;
}

/* Responsive aspect ratio utility classes */
.aspect-w-16 { padding-bottom: 56.25%; }
.aspect-w-4 { padding-bottom: 75%; }
.aspect-w-1 { padding-bottom: 100%; }
.aspect-w-21 { padding-bottom: 42.857%; }

.aspect-w-16,
.aspect-w-4,
.aspect-w-1,
.aspect-w-21 {
    position: relative;
    height: 0;
}

.aspect-w-16 > *,
.aspect-w-4 > *,
.aspect-w-1 > *,
.aspect-w-21 > * {
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle video loading states
    const videos = document.querySelectorAll('.section-video video');
    
    videos.forEach(video => {
        video.addEventListener('loadstart', function() {
            this.closest('.video-wrapper').classList.add('loading');
        });
        
        video.addEventListener('canplay', function() {
            this.closest('.video-wrapper').classList.remove('loading');
        });
        
        video.addEventListener('error', function() {
            this.closest('.video-wrapper').classList.add('error');
        });
    });
    
    // Handle play button clicks for embedded videos
    const playOverlays = document.querySelectorAll('.section-video .play-overlay');
    
    playOverlays.forEach(overlay => {
        overlay.addEventListener('click', function() {
            const iframe = this.parentElement.querySelector('iframe');
            if (iframe) {
                // Try to trigger autoplay for YouTube/Vimeo
                const src = iframe.src;
                if (src.includes('youtube.com')) {
                    iframe.src = src + (src.includes('?') ? '&' : '?') + 'autoplay=1';
                } else if (src.includes('vimeo.com')) {
                    iframe.src = src + (src.includes('?') ? '&' : '?') + 'autoplay=1';
                }
            }
            this.style.display = 'none';
        });
    });
});
</script>
