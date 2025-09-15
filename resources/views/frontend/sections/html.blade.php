{{-- HTML Section --}}
<section class="section-html py-12 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="section-content">
            @if($section->title)
                <div class="text-center mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        {{ $section->title }}
                    </h2>
                    <div class="w-20 h-1 bg-gradient-to-r from-green-500 to-emerald-500 mx-auto rounded-full"></div>
                </div>
            @endif
            
            @if($section->content)
                <div class="html-content">
                    @php
                        $settings = json_decode($section->settings ?? '{}', true);
                        $sanitize = $settings['sanitize'] ?? true;
                        $addProse = $settings['add_prose'] ?? false;
                        
                        $content = $section->content;
                        if ($sanitize) {
                            // Basic HTML sanitization (you might want to use a proper HTML purifier)
                            $content = strip_tags($content, '<p><br><strong><em><ul><ol><li><h1><h2><h3><h4><h5><h6><a><img><div><span><blockquote>');
                        }
                    @endphp
                    
                    <div class="{{ $addProse ? 'prose prose-lg prose-green max-w-none mx-auto' : '' }}">
                        {!! $content !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<style>
.section-html .html-content {
    line-height: 1.7;
}

.section-html .html-content h1,
.section-html .html-content h2,
.section-html .html-content h3,
.section-html .html-content h4,
.section-html .html-content h5,
.section-html .html-content h6 {
    color: #1f2937;
    font-weight: 700;
    margin-bottom: 1rem;
    margin-top: 2rem;
}

.section-html .html-content h1 { font-size: 2.25rem; }
.section-html .html-content h2 { font-size: 1.875rem; }
.section-html .html-content h3 { font-size: 1.5rem; }
.section-html .html-content h4 { font-size: 1.25rem; }

.section-html .html-content p {
    margin-bottom: 1.5rem;
    color: #374151;
}

.section-html .html-content a {
    color: #059669;
    text-decoration: underline;
    transition: color 0.2s ease;
}

.section-html .html-content a:hover {
    color: #047857;
}

.section-html .html-content blockquote {
    border-left: 4px solid #10b981;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #6b7280;
    background-color: #f0fdf4;
    padding: 1rem;
    border-radius: 0.375rem;
}

.section-html .html-content ul,
.section-html .html-content ol {
    margin-bottom: 1.5rem;
    padding-left: 1.5rem;
}

.section-html .html-content li {
    margin-bottom: 0.5rem;
    color: #374151;
}
</style>
