@extends('layouts.admin')

@section('title', 'Edit Contact')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Edit Contact Submission</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.contacts.show', $contact) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-eye mr-2"></i>View
            </a>
            <a href="{{ route('admin.contacts.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i>Back to Contacts
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Contact Information</h3>
        </div>
        <form method="POST" action="{{ route('admin.contacts.update', $contact) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="action" value="update">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" 
                           value="{{ old('name', $contact->name) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-300 @enderror"
                           readonly>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" 
                           value="{{ old('email', $contact->email) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-300 @enderror"
                           readonly>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone" 
                           value="{{ old('phone', $contact->phone) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-300 @enderror"
                           readonly>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-300 @enderror">
                        <option value="new" {{ old('status', $contact->status) == 'new' ? 'selected' : '' }}>New</option>
                        <option value="read" {{ old('status', $contact->status) == 'read' ? 'selected' : '' }}>Read</option>
                        <option value="replied" {{ old('status', $contact->status) == 'replied' ? 'selected' : '' }}>Replied</option>
                        <option value="closed" {{ old('status', $contact->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                <input type="text" name="subject" id="subject" 
                       value="{{ old('subject', $contact->subject) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('subject') border-red-300 @enderror"
                       readonly>
                @error('subject')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                <textarea name="message" id="message" rows="6"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('message') border-red-300 @enderror"
                          readonly>{{ old('message', $contact->message) }}</textarea>
                @error('message')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="admin_notes" class="block text-sm font-medium text-gray-700">Admin Notes</label>
                <textarea name="admin_notes" id="admin_notes" rows="4"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('admin_notes') border-red-300 @enderror"
                          placeholder="Add internal notes about this contact...">{{ old('admin_notes', $contact->admin_notes) }}</textarea>
                @error('admin_notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Metadata (Read-only) -->
            <div class="border-t border-gray-200 pt-6">
                <h4 class="text-md font-medium text-gray-900 mb-4">Submission Details</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Submitted Date</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $contact->created_at->format('M j, Y g:i A') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $contact->updated_at->format('M j, Y g:i A') }}</p>
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

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.contacts.show', $contact) }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-save mr-2"></i>Update Contact
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
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

                <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject) }}" 
                   class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-center">
                    <i class="fas fa-envelope mr-2"></i>Send Email
                </a>
            </div>
        </div>
    </div>
</div>
@endsection