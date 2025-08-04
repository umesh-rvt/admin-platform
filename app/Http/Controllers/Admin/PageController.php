<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends AdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->requirePermission('pages.view');

        $query = Page::with('sections');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by active status
        if ($request->filled('active')) {
            $query->where('is_active', $request->active === 'active');
        }

        $pages = $query->latest()->paginate(15);

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->requirePermission('pages.create');

        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->requirePermission('pages.create');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $page = Page::create($validated);

        $this->logActivity('create', "Created page: {$page->title}", $page);

        return redirect()->route('admin.pages.edit', $page)
            ->with('success', 'Page created successfully. You can now add sections.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        $this->requirePermission('pages.view');

        $page->load('sections');
        return view('admin.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        $this->requirePermission('pages.edit');

        $page->load('sections');
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $this->requirePermission('pages.edit');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $page->update($validated);

        $this->logActivity('update', "Updated page: {$page->title}", $page);

        return redirect()->route('admin.pages.edit', $page)
            ->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $this->requirePermission('pages.delete');

        $pageTitle = $page->title;
        $page->delete();

        $this->logActivity('delete', "Deleted page: {$pageTitle}");

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }

    /**
     * Store a new section for the page.
     */
    public function storeSection(Request $request, Page $page)
    {
        $this->requirePermission('page_sections.create');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:text,html,image,video,gallery',
            'image_path' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $section = $page->sections()->create($validated);

        $this->logActivity('create', "Added section to page: {$page->title}", $section);

        return redirect()->route('admin.pages.edit', $page)
            ->with('success', 'Section added successfully.');
    }

    /**
     * Update a section.
     */
    public function updateSection(Request $request, Page $page, PageSection $section)
    {
        $this->requirePermission('page_sections.edit');

        // Ensure section belongs to the page
        if ($section->page_id !== $page->id) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:text,html,image,video,gallery',
            'image_path' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $section->update($validated);

        $this->logActivity('update', "Updated section in page: {$page->title}", $section);

        return redirect()->route('admin.pages.edit', $page)
            ->with('success', 'Section updated successfully.');
    }

    /**
     * Remove a section.
     */
    public function destroySection(Page $page, PageSection $section)
    {
        $this->requirePermission('page_sections.delete');

        // Ensure section belongs to the page
        if ($section->page_id !== $page->id) {
            abort(404);
        }

        $section->delete();

        $this->logActivity('delete', "Deleted section from page: {$page->title}");

        return redirect()->route('admin.pages.edit', $page)
            ->with('success', 'Section deleted successfully.');
    }

    /**
     * Toggle page status.
     */
    public function toggleStatus(Page $page)
    {
        $this->requirePermission('pages.publish');

        $newStatus = $page->status === 'published' ? 'draft' : 'published';
        $page->update(['status' => $newStatus]);

        $this->logActivity('update', "Changed page status to {$newStatus}: {$page->title}", $page);

        return redirect()->route('admin.pages.index')
            ->with('success', "Page status changed to {$newStatus} successfully.");
    }
}
