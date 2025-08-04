<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the specified page.
     */
    public function show(Page $page)
    {
        // Check if page is published and active
        if ($page->status !== 'published' || !$page->is_active) {
            abort(404);
        }

        // Get page sections
        $sections = $page->activeSections()->orderBy('sort_order')->get();

        // Get site settings for layout
        $settings = Setting::getPublicAsArray();

        return view('frontend.page', compact('page', 'sections', 'settings'));
    }
}
