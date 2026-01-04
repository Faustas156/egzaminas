<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark:text-gray-200 leading-tight">View Ticket</h2>
    </x-slot>

    &nbsp;
    <div class="p-6 max-w-xl mx-auto border rounded bg-white dark:bg-gray-800">
        <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $ticket->title }}</h3>
        <p class="text-gray-700 dark:text-gray-300 text-sm mb-4">
            Status: {{ $ticket->status }} • Created {{ $ticket->created_at->diffForHumans() }}
        </p>

        <h4 class="font-semibold text-gray-800 dark:text-gray-200">Description</h4>
        <p class="text-gray-700 dark:text-gray-300 mb-6">
            {{ $ticket->messages->first()->message ?? 'No description' }}
        </p>

        <h3 class="font-bold mt-4 text-gray-900 dark:text-gray-100">Comments</h3>
        @forelse($ticket->messages as $msg)
        <div class="border p-2 mb-2 rounded">
            <p class="text-gray-800 dark:text-gray-100">{{ $msg->message }}</p>
            <small class="text-gray-500 dark:text-gray-400">by {{ $msg->user->name }} • {{ $msg->created_at->diffForHumans() }}</small>
        </div>

        @empty
        <p>No comments yet.</p>
        @endforelse

        @if(Auth::user()->role === 'admin')
        <form action="{{ route('tickets.updateStatus', $ticket) }}" method="POST" class="mt-6 flex items-center gap-3">
            @csrf
            @method('PATCH')
            <select name="status">
                <option value="open" @selected($ticket->status === 'open')>Open</option>
                <option value="in_progress" @selected($ticket->status === 'in_progress')>In Progress</option>
                <option value="closed" @selected($ticket->status === 'closed')>Closed</option>
            </select>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md
                      font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none
                      focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">Update Status</button>
        </form>
        @endif

        <form action="{{ route('tickets.addComment', $ticket) }}" method="POST" class="mt-4 space-y-1">
            @csrf
            <textarea name="message" class="w-full border rounded px-3 py-2" rows="3" placeholder="Add a comment"></textarea>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md
                      font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none
                      focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">Add Comment</button>
        </form>
    </div>
</x-app-layout>