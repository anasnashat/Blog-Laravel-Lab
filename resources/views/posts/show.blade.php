<x-layout>
    <!-- Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-3xl mx-auto space-y-6">
            <!-- Post Info Card -->
            <div class="bg-white rounded border border-gray-200 shadow-sm">
                <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-700">Post Info</h2>
                </div>
                <div class="px-4 py-4">
                    <h3 class="text-xl font-semibold text-gray-800">Title:</h3>
                    <p class="text-gray-600">{{ $post->title }}</p>
                    <h3 class="text-xl font-semibold text-gray-800 mt-4">Description:</h3>
                    <p class="text-gray-600">{{ $post->description }}</p>
                </div>
            </div>

            <!-- Post Creator Info Card -->
            <div class="bg-white rounded border border-gray-200 shadow-sm">
                <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-700">Post Creator Info</h2>
                </div>
                <div class="px-4 py-4">
                    <p class="text-gray-800"><strong>Name:</strong> {{ $post->user->name }}</p>
                    <p class="text-gray-800"><strong>Email:</strong> {{ $post->user->email }}</p>
                    <p class="text-gray-800"><strong>Created At:</strong> {{ $post->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <!-- Comment Section -->
            <div class="bg-white rounded border border-gray-200 shadow-sm">
                <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-700">Comments</h2>
                </div>

                <div class="px-4 py-4 space-y-4">
                    <!-- Display Comments -->
                    @foreach($post->comments as $comment)
                        <div class="border-b border-gray-200 pb-3">
                            <div class="flex items-center">
                                <div class="bg-gray-300 w-10 h-10 rounded-full flex items-center justify-center text-gray-800 font-semibold">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-semibold text-gray-900">{{ $comment->user->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <p class="text-gray-700 mt-2">{{ $comment->content }}</p>
                        </div>
                    @endforeach

                    <!-- Comment Form -->
                    @auth
                        <form action="{{ route('comments.store') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="commentable_id" value="{{ $post->id }}">
                            <input type="hidden" name="commentable_type" value="App\Models\Post">

                            <textarea name="content" rows="3" class="w-full border-gray-300 rounded-md p-2" placeholder="Write a comment..." required></textarea>

                            <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white font-medium rounded hover:bg-blue-700">
                                Post Comment
                            </button>
                        </form>
                    @else
                        <p class="text-gray-500 text-sm">You must <a href="{{ route('login') }}" class="text-blue-600 hover:underline">log in</a> to comment.</p>
                    @endauth
                </div>
            </div>

            <!-- Back Button -->
            <div class="flex justify-end">
                <a href="{{ route('posts.index') }}" class="px-4 py-2 bg-gray-600 text-white font-medium rounded hover:bg-gray-700">
                    Back to All Posts
                </a>
            </div>
        </div>
    </div>
</x-layout>
