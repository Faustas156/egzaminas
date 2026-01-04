<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark:text-gray-200 leading-tight">View Ticket</h2>
    </x-slot>

    <div class="p-6 max-w-xl mx-auto border rounded">
        <h3 class="font-bold text-lg">{{ $ticket->title }}</h3>
        <p class="text-sm text-gray-500 mb-4">
            Status: {{ $ticket->status }} • Created {{ $ticket->created_at->diffForHumans() }}
        </p>

        <h4 class="font-semibold">Description</h4>
        <p class="mb-4">
            {{ $ticket->messages->first()->message ?? 'No description' }}
        </p>

        <h3 class="font-bold mt-4">Comments</h3>
        @forelse($ticket->messages as $msg)
        <div class="border p-2 mb-2 rounded">
            <p>{{ $msg->message }}</p>
            <small class="text-gray-500">by {{ $msg->user->name }} • {{ $msg->created_at->diffForHumans() }}</small>
        </div>
        @empty
        <p>No comments yet.</p>
        @endforelse

        <form action="{{ route('tickets.addComment', $ticket) }}" method="POST">
            @csrf
            <textarea name="message" class="w-full border rounded px-3 py-2" rows="3" placeholder="Add a comment"></textarea>
            <button type="submit" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">Add Comment</button>
        </form>


        <form action="{{ route('tickets.updateStatus', $ticket) }}" method="POST">
            @csrf
            @method('PATCH')
            <select name="status">
                <option value="open" @selected($ticket->status === 'open')>Open</option>
                <option value="in_progress" @selected($ticket->status === 'in_progress')>In Progress</option>
                <option value="closed" @selected($ticket->status === 'closed')>Closed</option>
            </select>
            <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Update Status</button>
        </form>



    </div>
</x-app-layout>