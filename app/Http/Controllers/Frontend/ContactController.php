<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Requests\Frontend\ContactRequest;
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
    public function store(ContactRequest $request)
    {
        $validated = $request->validated();

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
