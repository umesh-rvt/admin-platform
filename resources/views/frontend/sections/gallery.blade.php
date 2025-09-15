{{-- Gallery Section --}}
<section class="section-gallery py-12 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="section-content">
            @if($section->title)
                <div class="text-center mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        {{ $section->title }}
                    </h2>
                    <div class="w-20 h-1 bg-gradient-to-r from-yellow-500 to-orange-500 mx-auto rounded-full"></div>
                </div>
            @endif
            
            @if($section->content)
                <div class="gallery-description text-center mb-12">
                    <div class="prose prose-lg prose-yellow max-w-3xl mx-auto">
                        <div class="text-gray-600 leading-relaxed">
                            {!! nl2br(e($section->content)) !!}
                        </div>
                    </div>
                </div>
            @endif
            
            @php
                $settings = json_decode($section->settings ?? '{}', true);
                $layout = $settings['layout'] ?? 'grid';
                $columns = $settings['columns'] ?? 3;
                $ratio = $settings['ratio'] ?? '1:1';
                $gap = $settings['gap'] ?? 'md';
                $lightbox = $settings['lightbox'] ?? true;
                $captions = $settings['captions'] ?? true;
                $lazyLoad = $settings['lazy_load'] ?? true;
                
                // Get gallery images (for now, we'll simulate with the single image)
                $galleryImages = $settings['gallery_images'] ?? [];
                
                // If no gallery images but there's a main image, use that
                if (empty($galleryImages) && $section->image_path) {
                    $galleryImages = [[
                        'path' => $section->image_path,
                        'alt' => $section->title ?? '',
                        'caption' => $section->content ?? ''
                    ]];
                }
                
                $gapClasses = [
                    'sm' => 'gap-2',
                    'md' => 'gap-4',
                    'lg' => 'gap-6',
                    'xl' => 'gap-8'
                ];
                
                $columnClasses = [
                    2 => 'grid-cols-1 md:grid-cols-2',
                    3 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
                    4 => 'grid-cols-2 md:grid-cols-3 lg:grid-cols-4',
                    5 => 'grid-cols-2 md:grid-cols-3 lg:grid-cols-5',
                    6 => 'grid-cols-2 md:grid-cols-4 lg:grid-cols-6'
                ];
                
                $ratioClasses = [
                    'auto' => '',
                    '1:1' => 'aspect-w-1 aspect-h-1',
                    '4:3' => 'aspect-w-4 aspect-h-3',
                    '16:9' => 'aspect-w-16 aspect-h-9',
                    '3:4' => 'aspect-w-3 aspect-h-4'
                ];
            @endphp
            
            @if(!empty($galleryImages))
                <div class="gallery-container">
                    @switch($layout)
                        @case('grid')
                            <div class="gallery-grid grid {{ $columnClasses[$columns] ?? 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3' }} {{ $gapClasses[$gap] ?? 'gap-4' }}">
                                @foreach($galleryImages as $imageIndex => $image)
                                    <div class="gallery-item group relative overflow-hidden rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                        <div class="{{ $ratioClasses[$ratio] ?? 'aspect-w-1 aspect-h-1' }}">
                                            @if($lightbox)
                                                <a href="{{ asset('storage/' . $image['path']) }}" 
                                                   class="lightbox-gallery block w-full h-full" 
                                                   data-lightbox="gallery-{{ $index }}"
                                                   data-title="{{ $image['caption'] ?? $image['alt'] ?? '' }}">
                                            @endif
                                            
                                            <img src="{{ asset('storage/' . $image['path']) }}" 
                                                 alt="{{ $image['alt'] ?? 'Gallery image' }}" 
                                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                                 {{ $lazyLoad ? 'loading="lazy"' : '' }}>
                                            
                                            {{-- Overlay --}}
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                <div class="absolute bottom-0 left-0 right-0 p-4">
                                                    @if($captions && !empty($image['caption']))
                                                        <p class="text-white text-sm font-medium">{{ $image['caption'] }}</p>
                                                    @endif
                                                </div>
                                                
                                                @if($lightbox)
                                                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                                        <div class="bg-white/20 backdrop-blur-sm rounded-full p-3">
                                                            <i class="fas fa-search-plus text-white text-xl"></i>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            @if($lightbox)
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @break
                            
                        @case('masonry')
                            <div class="gallery-masonry columns-1 md:columns-2 lg:columns-{{ $columns }} {{ $gapClasses[$gap] ?? 'gap-4' }} space-y-4">
                                @foreach($galleryImages as $imageIndex => $image)
                                    <div class="gallery-item group relative overflow-hidden rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 break-inside-avoid mb-4">
                                        @if($lightbox)
                                            <a href="{{ asset('storage/' . $image['path']) }}" 
                                               class="lightbox-gallery block" 
                                               data-lightbox="gallery-{{ $index }}"
                                               data-title="{{ $image['caption'] ?? $image['alt'] ?? '' }}">
                                        @endif
                                        
                                        <img src="{{ asset('storage/' . $image['path']) }}" 
                                             alt="{{ $image['alt'] ?? 'Gallery image' }}" 
                                             class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105"
                                             {{ $lazyLoad ? 'loading="lazy"' : '' }}>
                                        
                                        {{-- Overlay --}}
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                                @if($captions && !empty($image['caption']))
                                                    <p class="text-white text-sm font-medium">{{ $image['caption'] }}</p>
                                                @endif
                                            </div>
                                            
                                            @if($lightbox)
                                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                                    <div class="bg-white/20 backdrop-blur-sm rounded-full p-3">
                                                        <i class="fas fa-search-plus text-white text-xl"></i>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        @if($lightbox)
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @break
                            
                        @case('carousel')
                            <div class="gallery-carousel relative">
                                <div class="carousel-container overflow-hidden rounded-xl">
                                    <div class="carousel-track flex transition-transform duration-500 ease-in-out">
                                        @foreach($galleryImages as $imageIndex => $image)
                                            <div class="carousel-slide flex-shrink-0 w-full">
                                                <div class="aspect-w-16 aspect-h-9">
                                                    @if($lightbox)
                                                        <a href="{{ asset('storage/' . $image['path']) }}" 
                                                           class="lightbox-gallery block w-full h-full" 
                                                           data-lightbox="gallery-{{ $index }}"
                                                           data-title="{{ $image['caption'] ?? $image['alt'] ?? '' }}">
                                                    @endif
                                                    
                                                    <img src="{{ asset('storage/' . $image['path']) }}" 
                                                         alt="{{ $image['alt'] ?? 'Gallery image' }}" 
                                                         class="w-full h-full object-cover"
                                                         {{ $lazyLoad ? 'loading="lazy"' : '' }}>
                                                    
                                                    @if($captions && !empty($image['caption']))
                                                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6">
                                                            <p class="text-white text-lg font-medium">{{ $image['caption'] }}</p>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($lightbox)
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                {{-- Carousel Controls --}}
                                @if(count($galleryImages) > 1)
                                    <button class="carousel-prev absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/20 backdrop-blur-sm text-white rounded-full p-3 hover:bg-white/30 transition-all duration-200">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button class="carousel-next absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/20 backdrop-blur-sm text-white rounded-full p-3 hover:bg-white/30 transition-all duration-200">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                    
                                    {{-- Dots indicator --}}
                                    <div class="carousel-dots flex justify-center space-x-2 mt-6">
                                        @foreach($galleryImages as $imageIndex => $image)
                                            <button class="carousel-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-yellow-500 transition-colors duration-200 {{ $imageIndex === 0 ? 'bg-yellow-500' : '' }}" 
                                                    data-slide="{{ $imageIndex }}"></button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            @break
                    @endswitch
                </div>
            @endif
        </div>
    </div>
</section>

@if($lightbox ?? true)
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    @endpush
    
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    @endpush
@endif

<style>
.section-gallery .gallery-item {
    position: relative;
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
}

.section-gallery .gallery-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(251, 191, 36, 0.1), rgba(245, 158, 11, 0.1));
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
    z-index: 1;
}

.section-gallery .gallery-item:hover::before {
    opacity: 1;
}

/* Aspect ratio utilities */
.aspect-w-1 { padding-bottom: 100%; }
.aspect-w-3 { padding-bottom: 133.333%; }
.aspect-w-4 { padding-bottom: 75%; }
.aspect-w-16 { padding-bottom: 56.25%; }

.aspect-w-1,
.aspect-w-3,
.aspect-w-4,
.aspect-w-16 {
    position: relative;
    height: 0;
}

.aspect-w-1 > *,
.aspect-w-3 > *,
.aspect-w-4 > *,
.aspect-w-16 > * {
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}

/* Masonry layout */
.gallery-masonry {
    column-gap: 1rem;
}

/* Carousel specific styles */
.carousel-container {
    position: relative;
    background: #000;
}

.carousel-track {
    transform: translateX(0);
}

.carousel-slide img {
    background: #000;
}

.carousel-dot.active {
    background-color: #eab308 !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize carousels
    const carousels = document.querySelectorAll('.gallery-carousel');
    
    carousels.forEach(carousel => {
        const track = carousel.querySelector('.carousel-track');
        const slides = carousel.querySelectorAll('.carousel-slide');
        const prevBtn = carousel.querySelector('.carousel-prev');
        const nextBtn = carousel.querySelector('.carousel-next');
        const dots = carousel.querySelectorAll('.carousel-dot');
        
        let currentSlide = 0;
        const totalSlides = slides.length;
        
        if (totalSlides <= 1) return;
        
        function goToSlide(index) {
            currentSlide = index;
            track.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            // Update dots
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === currentSlide);
            });
        }
        
        function nextSlide() {
            goToSlide((currentSlide + 1) % totalSlides);
        }
        
        function prevSlide() {
            goToSlide((currentSlide - 1 + totalSlides) % totalSlides);
        }
        
        // Event listeners
        if (nextBtn) nextBtn.addEventListener('click', nextSlide);
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);
        
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => goToSlide(index));
        });
        
        // Auto-advance (optional)
        // setInterval(nextSlide, 5000);
    });
    
    // Lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src || img.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('img[loading="lazy"]').forEach(img => {
            imageObserver.observe(img);
        });
    }
});
</script>
