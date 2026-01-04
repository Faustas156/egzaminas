<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 dark:text-gray-200 leading-tight">
            {{ __('Create Ticket') }}
        </h2>
    </x-slot>

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 max-w-md mx-auto">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="flex justify-center p-6">
        <div class="w-full max-w-md">
            <form method="POST" action="{{ route('tickets.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="title" class="block mb-1 text-sm font-medium text-gray-300 dark:text-gray-400">
                        Title
                    </label>
                    <input id="title" name="title" type="text"
                        class="block w-full border-gray-300 rounded-md shadow-sm 
                        focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 
                        py-3" required />

                    <x-input-error :messages="$errors->get('title')" class="mt-1" />
                </div>

                <div>
                    <label for="message" class="block mb-1 text-sm font-medium text-gray-300 dark:text-gray-400">
                        Description
                    </label>
                    <textarea id="message" name="message" rows="5" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                    <x-input-error :messages="$errors->get('message')" class="mt-1" />
                </div>

                <div>
                    <label for="category_id" class="block mb-1 text-sm font-medium text-gray-300 dark:text-gray-400">
                        Category
                    </label>
                    <select name="category_id" required
                        class="block w-full border-gray-300 rounded-md shadow-sm
                        focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                        py-3">
                        <option value="" disabled selected>Select issue type</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-1" />
                </div>

                <div class="text-center mt-6">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md
                 font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none
                 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                        Submit
                    </button>
                </div>
            </form>
        </div>
</x-app-layout>