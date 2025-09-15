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
<div class="page-sections">
    @forelse($sections as $index => $section)
        @include('frontend.sections.' . $section->type, [
            'section' => $section,
            'index' => $index
        ])
    @empty
        <section class="py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-file-alt text-6xl"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">No Content Available</h3>
                    <p class="text-gray-600">This page doesn't have any content sections yet.</p>
                </div>
            </div>
        </section>
    @endforelse
</div>
@endsection 