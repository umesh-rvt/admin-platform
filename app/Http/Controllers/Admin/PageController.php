<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StorePageRequest;
use App\Http\Requests\Admin\UpdatePageRequest;
use App\Http\Requests\Admin\StorePageSectionRequest;
use App\Http\Requests\Admin\UpdatePageSectionRequest;
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
    public function store(StorePageRequest $request)
    {
        $this->requirePermission('pages.create');

        $validated = $request->validated();

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $page = Page::create($validated);

        // Persist sections sent from the create page form (optional)
        $sections = $request->input('sections', []);
        if (is_array($sections) && count($sections) > 0) {
            $preparedSections = [];
            foreach ($sections as $section) {
                $title = trim((string)($section['title'] ?? ''));
                $content = trim((string)($section['content'] ?? ''));
                if ($title !== '' || $content !== '') {
                    $preparedSections[] = [
                        'title' => $title,
                        'content' => $content,
                        'type' => in_array(($section['type'] ?? 'text'), ['text','html','image','video','gallery']) ? $section['type'] : 'text',
                        'image_path' => $section['image_path'] ?? null,
                        'sort_order' => isset($section['sort_order']) ? (int) $section['sort_order'] : 0,
                        'is_active' => isset($section['is_active']) ? (bool) $section['is_active'] : true,
                    ];
                }
            }
            if (!empty($preparedSections)) {
                $page->sections()->createMany($preparedSections);
            }
        }

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
    public function update(UpdatePageRequest $request, Page $page)
    {
        $this->requirePermission('pages.edit');

        $validated = $request->validated();

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $page->update($validated);

        // Handle batch upsert of sections submitted with the page form
        $incomingSections = $request->input('sections', []);
        if (is_array($incomingSections)) {
            // Track existing and submitted IDs
            $existingIds = $page->sections()->pluck('id')->all();
            $submittedIds = [];

            foreach ($incomingSections as $section) {
                $sectionId = isset($section['id']) ? (int) $section['id'] : null;
                $payload = [
                    'title' => trim((string)($section['title'] ?? '')),
                    'content' => (string)($section['content'] ?? ''),
                    'type' => in_array(($section['type'] ?? 'text'), ['text','html','image','video','gallery']) ? $section['type'] : 'text',
                    'image_path' => $section['image_path'] ?? null,
                    'sort_order' => isset($section['sort_order']) ? (int) $section['sort_order'] : 0,
                    'is_active' => isset($section['is_active']) ? (bool) $section['is_active'] : true,
                ];

                // Skip entirely empty new sections
                if (!$sectionId && $payload['title'] === '' && trim($payload['content']) === '') {
                    continue;
                }

                if ($sectionId && in_array($sectionId, $existingIds, true)) {
                    // Update existing
                    $page->sections()->where('id', $sectionId)->update($payload);
                    $submittedIds[] = $sectionId;
                } else {
                    // Create new
                    $newSection = $page->sections()->create($payload);
                    $submittedIds[] = $newSection->id;
                }
            }

            // Delete sections that were removed in the form
            $idsToDelete = array_diff($existingIds, $submittedIds);
            if (!empty($idsToDelete)) {
                $page->sections()->whereIn('id', $idsToDelete)->delete();
            }
        }

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
    public function storeSection(StorePageSectionRequest $request, Page $page)
    {
        $this->requirePermission('page_sections.create');

        $validated = $request->validated();

        $section = $page->sections()->create($validated);

        $this->logActivity('create', "Added section to page: {$page->title}", $section);

        return redirect()->route('admin.pages.edit', $page)
            ->with('success', 'Section added successfully.');
    }

    /**
     * Update a section.
     */
    public function updateSection(UpdatePageSectionRequest $request, Page $page, PageSection $section)
    {
        $this->requirePermission('page_sections.edit');

        // Ensure section belongs to the page
        if ($section->page_id !== $page->id) {
            abort(404);
        }

        $validated = $request->validated();

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
