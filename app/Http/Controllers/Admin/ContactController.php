<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactController extends AdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->requirePermission('contacts.view');

        $query = ContactSubmission::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $contacts = $query->latest()->paginate(15);

        // Get status counts for filters
        $statusCounts = [
            'new' => ContactSubmission::where('status', 'new')->count(),
            'read' => ContactSubmission::where('status', 'read')->count(),
            'replied' => ContactSubmission::where('status', 'replied')->count(),
            'closed' => ContactSubmission::where('status', 'closed')->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'statusCounts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactSubmission $contact)
    {
        $this->requirePermission('contacts.view');

        // Mark as read if status is new
        if ($contact->status === 'new') {
            $contact->markAsRead();
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactSubmission $contact)
    {
        $this->requirePermission('contacts.view');

        return view('admin.contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactSubmission $contact)
    {
        $this->requirePermission('contacts.view');

        $validated = $request->validate([
            'admin_notes' => 'nullable|string',
            'status' => 'required|in:new,read,replied,closed',
        ]);

        $contact->update($validated);

        $this->logActivity('update', "Updated contact submission: {$contact->subject}", $contact);

        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', 'Contact submission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactSubmission $contact)
    {
        $this->requirePermission('contacts.delete');

        $subject = $contact->subject;
        $contact->delete();

        $this->logActivity('delete', "Deleted contact submission: {$subject}");

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact submission deleted successfully.');
    }

    /**
     * Mark contact as read.
     */
    public function markAsRead(ContactSubmission $contact)
    {
        $this->requirePermission('contacts.view');

        $contact->markAsRead();

        $this->logActivity('update', "Marked contact as read: {$contact->subject}", $contact);

        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', 'Contact marked as read.');
    }

    /**
     * Mark contact as replied.
     */
    public function markAsReplied(ContactSubmission $contact)
    {
        $this->requirePermission('contacts.reply');

        $contact->markAsReplied();

        $this->logActivity('update', "Marked contact as replied: {$contact->subject}", $contact);

        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', 'Contact marked as replied.');
    }

    /**
     * Mark contact as closed.
     */
    public function markAsClosed(ContactSubmission $contact)
    {
        $this->requirePermission('contacts.view');

        $contact->markAsClosed();

        $this->logActivity('update', "Marked contact as closed: {$contact->subject}", $contact);

        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', 'Contact marked as closed.');
    }

    /**
     * Bulk actions for contact submissions.
     */
    public function bulkAction(Request $request)
    {
        $this->requirePermission('contacts.view');

        $validated = $request->validate([
            'action' => 'required|in:mark_read,mark_replied,mark_closed,delete',
            'contacts' => 'required|array',
            'contacts.*' => 'exists:contact_submissions,id',
        ]);

        $contacts = ContactSubmission::whereIn('id', $validated['contacts'])->get();
        $count = 0;

        foreach ($contacts as $contact) {
            switch ($validated['action']) {
                case 'mark_read':
                    if ($this->hasPermission('contacts.view')) {
                        $contact->markAsRead();
                        $count++;
                    }
                    break;
                case 'mark_replied':
                    if ($this->hasPermission('contacts.reply')) {
                        $contact->markAsReplied();
                        $count++;
                    }
                    break;
                case 'mark_closed':
                    if ($this->hasPermission('contacts.view')) {
                        $contact->markAsClosed();
                        $count++;
                    }
                    break;
                case 'delete':
                    if ($this->hasPermission('contacts.delete')) {
                        $contact->delete();
                        $count++;
                    }
                    break;
            }
        }

        $action = str_replace('_', ' ', $validated['action']);
        $this->logActivity('bulk_action', "Bulk {$action} on {$count} contact submissions");

        return redirect()->route('admin.contacts.index')
            ->with('success', "Bulk action completed on {$count} contact submissions.");
    }
}
