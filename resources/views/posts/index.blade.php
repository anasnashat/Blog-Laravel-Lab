<x-layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Blog Posts</h1>
            <a href="{{ route('posts.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Create Post
            </a>
        </div>

        <!-- Table Component -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posted By</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($posts as $post)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $post->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{$post['title']}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $post->user->name}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $post->created_at->format("Y-m-d") }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <view-ajax :id="{{$post->id}}"></view-ajax>

                                    @if(auth()->id() == $post->user->id)
                                        <a href="{{ route("posts.edit", $post['id']) }}" 
                                           class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 rounded-md hover:bg-blue-200 transition-colors">
                                            Edit
                                        </a>
                                        
                                        @if($post->deleted_at)
                                            <form action="{{  route("posts.restore", $post)  }}" method="POST" class="inline-block">
                                                @csrf
                                                @method("PATCH")
                                                <button type="submit" 
                                                        onclick="return confirm('Are you sure to restore post {{$post->name}}?')"
                                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-green-700 bg-green-100 rounded-md hover:bg-green-200 transition-colors">
                                                    Restore
                                                </button>
                                            </form>
                                            @else
                                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit"
                                                    onclick="return confirm('Are you sure to delete post {{$post->name}}?')"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-700 bg-red-100 rounded-md hover:bg-red-200 transition-colors">
                                                Delete
                                            </button>
                                        </form>
                                        @endif
                                        

                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-layout>
