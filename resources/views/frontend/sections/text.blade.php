{{-- Text Section --}}
<section class="section-text py-12 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="section-content">
            @if($section->title)
                <div class="text-center mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        {{ $section->title }}
                    </h2>
                    <div class="w-20 h-1 bg-gradient-to-r from-blue-500 to-purple-500 mx-auto rounded-full"></div>
                </div>
            @endif
            
            @if($section->content)
                <div class="prose prose-lg prose-blue max-w-none mx-auto">
                    <div class="text-content leading-relaxed text-gray-700 text-lg">
                        {!! nl2br(e($section->content)) !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<style>
.section-text .text-content {
    line-height: 1.8;
    font-size: 1.125rem;
}

.section-text .text-content p {
    margin-bottom: 1.5rem;
}

.section-text .prose {
    color: #374151;
}

.section-text .prose strong {
    color: #1f2937;
    font-weight: 600;
}

.section-text .prose em {
    color: #6b7280;
    font-style: italic;
}
</style>
