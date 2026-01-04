<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('All Tickets') }}
        </h2>
    </x-slot>

    <div class="p-6">
        @if($tickets->isEmpty())
            <p>No tickets found.</p>
        @else
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">Title</th>
                        <th class="px-4 py-2 border">Category</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Message</th>
                        <th class="px-4 py-2 border">Created At</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                    <tr>
                        <td class="px-4 py-2 border">{{ $ticket->title }}</td>

                        {{-- Show first category (if exists) --}}
                        <td class="px-4 py-2 border">
                            {{ $ticket->categories->first()?->name ?? 'N/A' }}
                        </td>

                        <td class="px-4 py-2 border capitalize">{{ $ticket->status }}</td>

                        {{-- Show first message --}}
                        <td class="px-4 py-2 border">
                            {{ $ticket->messages->first()?->message ?? 'No message' }}
                        </td>

                        <td class="px-4 py-2 border">{{ $ticket->created_at->format('Y-m-d H:i') }}</td>

                        <td class="px-4 py-2 border">
                            <a href="{{ route('tickets.show', $ticket->uuid) }}" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>