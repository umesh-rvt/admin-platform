{{-- Image Section --}}
<section class="section-image py-12 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="section-content">
            @if($section->title)
                <div class="text-center mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        {{ $section->title }}
                    </h2>
                    <div class="w-20 h-1 bg-gradient-to-r from-purple-500 to-pink-500 mx-auto rounded-full"></div>
                </div>
            @endif
            
            @if($section->image_path || $section->content)
                @php
                    $settings = json_decode($section->settings ?? '{}', true);
                    $size = $settings['size'] ?? 'large';
                    $align = $settings['align'] ?? 'center';
                    $rounded = $settings['rounded'] ?? 'md';
                    $shadow = $settings['shadow'] ?? true;
                    $lightbox = $settings['lightbox'] ?? false;
                    
                    $sizeClasses = [
                        'small' => 'max-w-sm',
                        'medium' => 'max-w-md',
                        'large' => 'max-w-2xl',
                        'full' => 'max-w-full'
                    ];
                    
                    $alignClasses = [
                        'left' => 'mr-auto',
                        'center' => 'mx-auto',
                        'right' => 'ml-auto'
                    ];
                    
                    $roundedClasses = [
                        'none' => '',
                        'sm' => 'rounded-sm',
                        'md' => 'rounded-lg',
                        'lg' => 'rounded-xl',
                        'full' => 'rounded-full'
                    ];
                    
                    $imageClasses = implode(' ', [
                        $sizeClasses[$size] ?? 'max-w-2xl',
                        $alignClasses[$align] ?? 'mx-auto',
                        $roundedClasses[$rounded] ?? 'rounded-lg',
                        $shadow ? 'shadow-xl' : '',
                        'transition-transform duration-300 hover:scale-105'
                    ]);
                @endphp
                
                <div class="image-container text-{{ $align }}">
                    @if($section->image_path)
                        <div class="image-wrapper mb-6">
                            @if($lightbox)
                                <a href="{{ asset('storage/' . $section->image_path) }}" 
                                   class="lightbox-trigger block" 
                                   data-lightbox="section-{{ $index }}"
                                   data-title="{{ $section->title }}">
                            @endif
                            
                            <img src="{{ asset('storage/' . $section->image_path) }}" 
                                 alt="{{ $section->title ?? 'Section image' }}" 
                                 class="{{ $imageClasses }} w-full h-auto object-cover">
                            
                            @if($lightbox)
                                </a>
                                <div class="text-center mt-2">
                                    <span class="text-sm text-gray-500">
                                        <i class="fas fa-search-plus mr-1"></i>Click to enlarge
                                    </span>
                                </div>
                            @endif
                        </div>
                    @endif
                    
                    @if($section->content)
                        <div class="image-caption">
                            <div class="prose prose-lg prose-purple max-w-none mx-auto text-center">
                                <div class="text-gray-600 italic leading-relaxed">
                                    {!! nl2br(e($section->content)) !!}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</section>

@if($lightbox ?? false)
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    @endpush
    
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    @endpush
@endif

<style>
.section-image .image-container {
    position: relative;
}

.section-image .image-wrapper {
    position: relative;
    overflow: hidden;
}

.section-image .image-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(147, 51, 234, 0.1), rgba(236, 72, 153, 0.1));
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
    z-index: 1;
}

.section-image .image-wrapper:hover::before {
    opacity: 1;
}

.section-image .lightbox-trigger {
    position: relative;
    display: inline-block;
}

.section-image .lightbox-trigger::after {
    content: '\f065';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 0.5rem;
    border-radius: 50%;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 2;
}

.section-image .lightbox-trigger:hover::after {
    opacity: 1;
}

.section-image .image-caption {
    max-width: 42rem;
    margin: 0 auto;
}
</style>
