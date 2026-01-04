<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Ticket
        </h2>
    </x-slot>

    <div class="p-6 max-w-xl mx-auto">
        <form method="POST" action="{{ route('tickets.update', $ticket) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Title</label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $ticket->title) }}"
                    class="w-full border rounded px-3 py-2"
                    required
                />
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Update message</label>
                <textarea
                    name="message"
                    rows="4"
                    class="w-full border rounded px-3 py-2"
                    required
                ></textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Category</label>
                <select name="category_id" class="w-full border rounded px-3 py-2">
                    @foreach ($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            @selected($ticket->categories->contains($category))
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button
                type="submit"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md
                 font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none
                 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                Update Ticket
            </button>
        </form>
    </div>
</x-app-layout>