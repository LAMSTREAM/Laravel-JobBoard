<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Job Details
        </h2>
    </x-slot>

    <div class="py-1 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">{{ $jobPost->summary }}</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Posted on {{ $jobPost->created_at->format('Y-m-d') }}
                            @if($jobPost->user)
                                by <span class="font-medium text-gray-800">{{ $jobPost->user->name }}</span>
                            @else
                                <span class="font-medium text-gray-400">(Unknown)</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Job Description</h4>
                        <div class="text-gray-700 text-sm whitespace-pre-line">
                            {{ $jobPost->body }}
                        </div>
                    </div>

                    @if(auth()->user()->role === 'viewer')
                        <div class="flex justify-between items-center">
                            <form action="{{ route('job-posts.toggle-interest', $jobPost->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 {{ $jobPost->interestedUsers->contains(auth()->user()) ? 'bg-red-600 text-white border border-red-600 hover:bg-red-700' : 'bg-white text-red-600 border border-red-600 hover:bg-red-50' }} rounded-md font-semibold text-sm uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition ease-in-out duration-150">
                                    {{ $jobPost->interestedUsers->contains(auth()->user()) ? 'Withdraw Interest' : "I'm Interested" }}
                                </button>
                            </form>
                            <a href="{{ route('job-posts.index') }}" class="text-sm text-indigo-600 hover:underline">&larr; Back to Job List</a>
                        </div>
                    @endif

                    @if(auth()->user()->id === $jobPost->user_id)
                        <div>
                            <h4 class=" text-lg font-semibold text-gray-800 mb-2">Interested Users</h4>
                            @if($jobPost->interestedUsers->isEmpty())
                                <p class="text-sm text-gray-500">No users have marked interest yet.</p>
                            @else
                                <ul class="list-disc pl-5 text-sm text-gray-700 space-y-1">
                                    @foreach ($jobPost->interestedUsers as $user)
                                        <li>{{ $user->name }} ({{ $user->email }})</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div>
                            <a href="{{ route('job-posts.index') }}" class="text-sm text-indigo-600 hover:underline">&larr; Back to Job List</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>