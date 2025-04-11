<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Job Listings
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div
                    class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-800 text-sm font-medium rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg divide-y divide-gray-200">
                <div class="flex items-center justify-end px-4 py-2">
                    <form method="GET" action="{{ route('job-posts.index') }}">
                        <label for="sort" class="text-sm text-gray-600 mr-2">Sort by:</label>
                        <select name="sort" id="sort" onchange="this.form.submit()"
                            class="border border-gray-300 rounded px-2 py-1 text-sm text-gray-800">
                            <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>Newest</option>
                            <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Oldest</option>
                        </select>
                    </form>
                </div>

                @foreach ($jobPosts as $jobPost)
                    <div id="job-{{ $jobPost->id }}" class="px-4 py-4 hover:bg-gray-50 transition">
                        <div class="flex flex-row flex-wrap justify-between items-center gap-4">
                            <a href="{{ route('job-posts.show', $jobPost->id) }}" class="flex-1 min-w-0">
                                <div class="truncate">
                                    <h3 class="text-base font-medium text-gray-900">{{ $jobPost->summary }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Posted on {{ $jobPost->created_at->format('Y-m-d') }}
                                        @if($jobPost->user)
                                            by <span class="font-medium text-gray-800">{{ $jobPost->user->name }}</span>
                                        @else
                                            <span class="font-medium text-gray-400">(Unknown)</span>
                                        @endif
                                    </p>
                                </div>
                            </a>

                            @if (auth()->user()->role === 'viewer')
                                <button type="button" data-id="{{ $jobPost->id }}"
                                    data-route="{{ route('job-posts.toggle-interest', $jobPost->id) }}"
                                    class="toggle-interest inline-flex items-center px-3 py-1.5 {{ $jobPost->interestedUsers->contains(auth()->user()) ? 'bg-red-600 text-white border border-red-600 hover:bg-red-700' : 'bg-white text-red-600 border border-red-600 hover:bg-red-50' }} rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                                    {{ $jobPost->interestedUsers->contains(auth()->user()) ? 'Withdraw' : 'Interested' }}
                                </button>
                            @endif

                            @if (auth()->user()->id === $jobPost->user_id)
                                <div class="flex flex-col md:flex-row gap-3">
                                    <a href="{{ route('job-posts.edit', $jobPost->id) }}"
                                        class="text-center inline-flex items-center px-3 py-1.5 bg-yellow-500 border border-yellow-500 rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('job-posts.destroy', $jobPost->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')"
                                            class="inline-flex items-center px-3 py-1.5 bg-red-600 border border-red-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $jobPosts->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
    <script>
        // Toggle interest by ajax
        document.querySelectorAll('.toggle-interest').forEach(button => {
            button.addEventListener('click', async () => {
                const route = button.getAttribute('data-route');
                const id = button.getAttribute('data-id');
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await fetch(route, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    location.reload();
                } else {
                    alert('Failed to update interest.');
                }
            });
        });
    </script>
</x-app-layout>