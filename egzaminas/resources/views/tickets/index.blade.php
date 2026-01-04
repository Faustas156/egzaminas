<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Tickets
            </h2>

            <a href="{{ route('tickets.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md
                  font-semibold text-sm text-white hover:bg-blue-700 focus:outline-none
                  focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                Create Ticket
            </a>
        </div>
    </x-slot>

    <div class="p-6">
        @forelse ($tickets as $ticket)
        <div class="mb-4 p-4 border rounded">
            <h3 class="font-bold">{{ $ticket->title }}</h3>
            <p>Status: {{ $ticket->status }}</p>
            <p class="text-sm text-gray-500">
                {{ $ticket->created_at->diffForHumans() }}
            </p>
            @can('view', $ticket)
            <a href="{{ route('tickets.show', $ticket) }}" class="text-green-600 hover:underline">
                View
            </a>
            @endcan
            @if($user->role === 'admin' || Auth::id() === $ticket->user_id)
            <a href="{{ route('tickets.edit', $ticket) }}" class="text-blue-600 hover:underline">
                Edit
            </a>
            @endif
            @can('delete', $ticket)
            <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="text-red-600 hover:underline"
                    onclick="return confirm('Are you sure you want to delete this ticket?')">
                    Delete
                </button>
            </form>
            @endcan
        </div>
        @empty
        <p>No tickets found.</p>
        @endforelse
    </div>
</x-app-layout>