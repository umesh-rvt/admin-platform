@extends('layouts.admin')

@section('title', 'Category Details')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Category: {{ $category->name }}</h1>
        <div class="flex space-x-2">
            @if(auth()->user()->hasPermission('categories.edit'))
            <a href="{{ route('admin.categories.edit', $category) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            @endif
            <a href="{{ route('admin.categories.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i>Back to Categories
            </a>
        </div>
    </div>

    <!-- Category Details -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Category Information</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $category->name }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Slug</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $category->slug }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $category->description ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sort Order</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $category->sort_order }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <p class="mt-1 text-sm text-gray-900">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Created At</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $category->created_at->format('M j, Y H:i:s') }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Updated At</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $category->updated_at->format('M j, Y H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pages in this Category -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Pages in this Category ({{ $category->pages->count() }})</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Active</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($category->pages as $page)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $page->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $page->slug }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $page->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($page->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $page->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $page->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    @if(auth()->user()->hasPermission('pages.view'))
                                    <a href="{{ route('admin.pages.show', $page) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('pages.edit'))
                                    <a href="{{ route('admin.pages.edit', $page) }}" 
                                       class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No pages found in this category.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection