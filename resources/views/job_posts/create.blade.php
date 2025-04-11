<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Post a New Job
        </h2>
    </x-slot>

    <div class="py-1 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-400 rounded">
                            <strong>There were some errors:</strong>
                            <ul class="list-disc pl-5 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('job-posts.store') }}">
                        @csrf

                        <div class="mb-6">
                            <label for="summary" class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                            <input id="summary" name="summary" type="text" required
                                class="block w-full rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900"
                                value="{{ old('summary') }}">
                        </div>

                        <div class="mb-6">
                            <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Job Description</label>
                            <textarea id="body" name="body" rows="6" required
                                class="block w-full rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900">{{ old('body') }}</textarea>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-indigo-600 rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Post Job
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>