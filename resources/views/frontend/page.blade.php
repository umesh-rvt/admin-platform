@extends('layouts.frontend')

@section('title', $page->title)
@section('meta_description', $page->meta_description)
@section('meta_keywords', $page->meta_keywords)

@section('content')
<!-- Page Header -->
<section class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $page->title }}</h1>
            @if($page->meta_description)
                <p class="text-xl text-gray-600">{{ $page->meta_description }}</p>
            @endif
        </div>
    </div>
</section>

<!-- Page Content -->
<section class="py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @forelse($sections as $section)
            <div class="mb-12 last:mb-0">
                @if($section->title)
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ $section->title }}</h2>
                @endif
                
                @switch($section->type)
                    @case('text')
                        <div class="prose prose-lg max-w-none">
                            {!! nl2br(e($section->content)) !!}
                        </div>
                        @break
                        
                    @case('html')
                        <div class="prose prose-lg max-w-none">
                            {!! $section->content !!}
                        </div>
                        @break
                        
                    @case('image')
                        <div class="text-center">
                            @if($section->image_path)
                                <img src="{{ asset('storage/' . $section->image_path) }}" 
                                     alt="{{ $section->title }}" 
                                     class="max-w-full h-auto rounded-lg shadow-lg">
                            @endif
                            @if($section->content)
                                <div class="mt-4 prose prose-lg max-w-none">
                                    {!! nl2br(e($section->content)) !!}
                                </div>
                            @endif
                        </div>
                        @break
                        
                    @case('video')
                        <div class="text-center">
                            <div class="aspect-w-16 aspect-h-9 mb-4">
                                {!! $section->content !!}
                            </div>
                            @if($section->title)
                                <h3 class="text-xl font-semibold text-gray-900">{{ $section->title }}</h3>
                            @endif
                        </div>
                        @break
                        
                    @case('gallery')
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @if($section->image_path)
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $section->image_path) }}" 
                                         alt="{{ $section->title }}" 
                                         class="w-full h-64 object-cover rounded-lg shadow-md">
                                    @if($section->title)
                                        <h3 class="mt-2 text-lg font-medium text-gray-900">{{ $section->title }}</h3>
                                    @endif
                                </div>
                            @endif
                            @if($section->content)
                                <div class="prose prose-lg max-w-none">
                                    {!! nl2br(e($section->content)) !!}
                                </div>
                            @endif
                        </div>
                        @break
                        
                    @default
                        <div class="prose prose-lg max-w-none">
                            {!! nl2br(e($section->content)) !!}
                        </div>
                @endswitch
            </div>
        @empty
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-file-alt text-6xl"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No Content Available</h3>
                <p class="text-gray-600">This page doesn't have any content sections yet.</p>
            </div>
        @endforelse
    </div>
</section>
@endsection 