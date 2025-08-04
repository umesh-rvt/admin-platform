@extends('layouts.admin')

@section('title', 'Contact Details')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Contact Submission</h1>
        <div class="flex space-x-3">
            @if(auth()->user()->hasPermission('contacts.edit'))
            <a href="{{ route('admin.contacts.edit', $contact) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            @endif
            <a href="{{ route('admin.contacts.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i>Back to Contacts
            </a>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Contact Information</h3>
                @php
                    $statusColors = [
                        'new' => 'bg-yellow-100 text-yellow-800',
                        'read' => 'bg-blue-100 text-blue-800',
                        'replied' => 'bg-green-100 text-green-800',
                        'closed' => 'bg-red-100 text-red-800'
                    ];
                @endphp
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$contact->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($contact->status) }}
                </span>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $contact->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <p class="mt-1 text-sm text-gray-900">
                        <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:text-blue-800">
                            {{ $contact->email }}
                        </a>
                    </p>
                </div>
                @if($contact->phone)
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <p class="mt-1 text-sm text-gray-900">
                        <a href="tel:{{ $contact->phone }}" class="text-blue-600 hover:text-blue-800">
                            {{ $contact->phone }}
                        </a>
                    </p>
                </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700">Submitted</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $contact->created_at->format('M j, Y g:i A') }}</p>
                </div>
                @if($contact->ip_address)
                <div>
                    <label class="block text-sm font-medium text-gray-700">IP Address</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $contact->ip_address }}</p>
                </div>
                @endif
                @if($contact->user_agent)
                <div>
                    <label class="block text-sm font-medium text-gray-700">User Agent</label>
                    <p class="mt-1 text-sm text-gray-900">{{ Str::limit($contact->user_agent, 100) }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Message -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Subject & Message</h3>
        </div>
        <div class="p-6">
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Subject</label>
                <p class="mt-1 text-lg font-medium text-gray-900">{{ $contact->subject }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Message</label>
                <div class="mt-1 p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $contact->message }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    @if(auth()->user()->hasPermission('contacts.edit'))
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @if($contact->status !== 'read')
                <form method="POST" action="{{ route('admin.contacts.mark-read', $contact) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-eye mr-2"></i>Mark as Read
                    </button>
                </form>
                @endif

                @if($contact->status !== 'replied')
                <form method="POST" action="{{ route('admin.contacts.mark-replied', $contact) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-reply mr-2"></i>Mark as Replied
                    </button>
                </form>
                @endif

                @if($contact->status !== 'closed')
                <form method="POST" action="{{ route('admin.contacts.mark-closed', $contact) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-times-circle mr-2"></i>Mark as Closed
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Reply Form -->
    @if(auth()->user()->hasPermission('contacts.edit') && $contact->status !== 'closed')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Send Reply</h3>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('admin.contacts.update', $contact) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="action" value="reply">
                
                <div class="mb-4">
                    <label for="reply_subject" class="block text-sm font-medium text-gray-700">Subject</label>
                    <input type="text" name="reply_subject" id="reply_subject" 
                           value="Re: {{ $contact->subject }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div class="mb-4">
                    <label for="reply_message" class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea name="reply_message" id="reply_message" rows="6"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Type your reply here..."></textarea>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                        <i class="fas fa-paper-plane mr-2"></i>Send Reply
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Admin Notes -->
    @if(auth()->user()->hasPermission('contacts.edit'))
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Admin Notes</h3>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('admin.contacts.update', $contact) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="action" value="notes">
                
                <div class="mb-4">
                    <label for="admin_notes" class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="admin_notes" id="admin_notes" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Add internal notes about this contact...">{{ $contact->admin_notes }}</textarea>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-save mr-2"></i>Save Notes
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>

<script>
// Auto-mark as read when viewing
@if($contact->status === 'new')
fetch('{{ route('admin.contacts.mark-read', $contact) }}', {
    method: 'PATCH',
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json',
    },
}).then(() => {
    // Update status badge
    const statusBadge = document.querySelector('.inline-flex.items-center.px-2\\.5');
    if (statusBadge) {
        statusBadge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
        statusBadge.textContent = 'Read';
    }
});
@endif
</script>
@endsection