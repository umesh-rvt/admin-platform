<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmission;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function show()
    {
        $settings = Setting::getPublicAsArray();
        return view('frontend.contact', compact('settings'));
    }

    /**
     * Store a new contact submission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Create contact submission
        $submission = ContactSubmission::create($validated);

        // Send email notification (queued)
        $adminEmail = Setting::getValue('contact_email', 'admin@example.com');
        if ($adminEmail) {
            Mail::to($adminEmail)->queue(new ContactFormSubmission($submission));
        }

        return redirect()->route('contact.show')
            ->with('success', 'Thank you for your message. We will get back to you soon!');
    }
}
