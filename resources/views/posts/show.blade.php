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
                        <div class="bg-gray-100 p-4 rounded mb-4">
                            <p class="text-gray-800">{{ $comment->content }}</p>
                            <p class="text-sm text-gray-600">By: {{ $comment->user->name }}</p>

                            @if(auth()->id() === $comment->user_id)
                            <button onclick="showEditForm({{ $comment->id }})"
                                    class="text-blue-600 hover:underline">
                                Edit
                            </button>

                            <form id="edit-form-{{ $comment->id }}"
                                  action="{{ route('comments.update', $comment) }}"
                                  method="POST"
                                  class="hidden">
                                @csrf
                                @method('PATCH')

                                <textarea name="content" class="w-full border rounded p-2">{{ $comment->content }}</textarea>
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded mt-2">
                                    Save
                                </button>
                            </form>
                            @endif
                        </div>
                    @endforeach

                    <script>
                        function showEditForm(commentId) {
                            document.getElementById('edit-form-' + commentId).classList.toggle('hidden');
                        }
                    </script>

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
