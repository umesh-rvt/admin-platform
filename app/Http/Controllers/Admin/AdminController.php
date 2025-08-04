<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        // Get latest activity logs
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        // Get summary statistics
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_pages' => \App\Models\Page::count(),
            'total_contacts' => \App\Models\ContactSubmission::count(),
            'new_contacts' => \App\Models\ContactSubmission::where('status', 'new')->count(),
        ];

        return view('admin.dashboard', compact('recentActivities', 'stats'));
    }

    /**
     * Log activity for admin actions.
     */
    protected function logActivity($action, $description, $model = null, $properties = [])
    {
        ActivityLog::log($action, $description, $model, $properties);
    }

    /**
     * Get setting value.
     */
    protected function getSetting($key, $default = null)
    {
        return Setting::getValue($key, $default);
    }

    /**
     * Set setting value.
     */
    protected function setSetting($key, $value)
    {
        return Setting::setValue($key, $value);
    }

    /**
     * Check if user has permission.
     */
    protected function hasPermission($permission)
    {
        return auth()->user()->hasPermission($permission);
    }

    /**
     * Check if user has any of the given permissions.
     */
    protected function hasAnyPermission($permissions)
    {
        return auth()->user()->hasAnyPermission($permissions);
    }

    /**
     * Abort if user doesn't have permission.
     */
    protected function requirePermission($permission)
    {
        if (!$this->hasPermission($permission)) {
            abort(403, 'You do not have permission to perform this action.');
        }
    }
}
