<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Tickets
            </h2>

            <div class="flex items-center gap-3">
                <!-- Export PDF -->
                <a href="{{ route('tickets.pdf') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md
                      font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none
                      focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                    Export PDF
                </a>
                <!-- Create Ticket -->
                <a href="{{ route('tickets.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md
                      font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none
                      focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                    Create Ticket
                </a>
            </div>
        </div>
    </x-slot>


    <div class="p-6">
        @forelse ($tickets as $ticket)
        <div class="mb-4 p-4 border border-gray-300 dark:border-gray-700 rounded
            bg-white dark:bg-gray-800">
            <h3 class="font-bold text-gray-900 dark:text-gray-100">
                {{ $ticket->title }}
            </h3>

            <p class="text-gray-700 dark:text-gray-300">
                Status: <span class="font-medium">{{ $ticket->status }}</span>
            </p>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $ticket->created_at->diffForHumans() }}
            </p>

            @can('view', $ticket)
            <a href="{{ route('tickets.show', $ticket) }}" class="text-green-600 dark:text-green-400 hover:underline">
                View
            </a>
            @endcan

            @if($user->role === 'admin' || Auth::id() === $ticket->user_id)
            <a href="{{ route('tickets.edit', $ticket) }}" class="inline-block hover:underline">
                <span class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-500">
                    Edit
                </span>
            </a>
            @endif

            @can('delete', $ticket)
            <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="text-red-600 dark:text-red-400 hover:underline"
                    onclick="return confirm('Are you sure you want to delete this ticket?')">
                    Delete
                </button>
            </form>
            @endcan
        </div>
        @empty
        <p class="text-white">No tickets found.</p>
        @endforelse
    </div>
</x-app-layout>