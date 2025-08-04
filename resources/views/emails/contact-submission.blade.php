<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .field {
            margin-bottom: 15px;
        }
        .field-label {
            font-weight: bold;
            color: #555;
        }
        .field-value {
            margin-top: 5px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 3px;
        }
        .footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>New Contact Form Submission</h2>
        <p>A new contact form submission has been received on your website.</p>
    </div>

    <div class="content">
        <div class="field">
            <div class="field-label">Name:</div>
            <div class="field-value">{{ $submission->name }}</div>
        </div>

        <div class="field">
            <div class="field-label">Email:</div>
            <div class="field-value">{{ $submission->email }}</div>
        </div>

        @if($submission->phone)
        <div class="field">
            <div class="field-label">Phone:</div>
            <div class="field-value">{{ $submission->phone }}</div>
        </div>
        @endif

        <div class="field">
            <div class="field-label">Subject:</div>
            <div class="field-value">{{ $submission->subject }}</div>
        </div>

        <div class="field">
            <div class="field-label">Message:</div>
            <div class="field-value">{{ $submission->message }}</div>
        </div>

        <div class="field">
            <div class="field-label">Submitted At:</div>
            <div class="field-value">{{ $submission->created_at->format('F j, Y \a\t g:i A') }}</div>
        </div>
    </div>

    <div class="footer">
        <p>This email was sent from your website's contact form. Please respond to the sender directly using their email address.</p>
        <p>Submission ID: {{ $submission->id }}</p>
    </div>
</body>
</html> 