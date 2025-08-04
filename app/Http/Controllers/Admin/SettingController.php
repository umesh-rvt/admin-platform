<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends AdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->requirePermission('settings.view');

        $settings = Setting::orderBy('group')->orderBy('display_name')->get()->groupBy('group');
        
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $this->requirePermission('settings.edit');

        $settings = $request->except(['_token', '_method']);
        
        foreach ($settings as $key => $value) {
            // Handle file uploads for image settings
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $path = $file->store('settings', 'public');
                Setting::setValue($key, $path);
            } else {
                Setting::setValue($key, $value);
            }
        }

        $this->logActivity('update', 'Updated site settings');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Get settings by group.
     */
    public function getByGroup($group)
    {
        $this->requirePermission('settings.view');

        $settings = Setting::where('group', $group)->get();
        
        return response()->json($settings);
    }

    /**
     * Reset settings to default.
     */
    public function reset()
    {
        $this->requirePermission('settings.edit');

        // This would reset settings to default values
        // Implementation depends on your default settings strategy
        
        $this->logActivity('update', 'Reset site settings to default');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings reset to default successfully.');
    }
}
