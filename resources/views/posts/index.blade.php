<x-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-semibold text-gray-900">Blog Posts</h1>
            <a href="{{ route('posts.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Create Post
            </a>
        </div>

        <!-- Table Component -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200">
            <div>
                <table class="w-full table-fixed divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="w-[5%] px-3 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                            <th class="w-[10%] px-3 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Image</th>
                            <th class="w-[20%] px-3 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Title</th>
                            <th class="w-[20%] px-3 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Slug</th>
                            <th class="w-[15%] px-3 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Posted By</th>
                            <th class="w-[10%] px-3 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Created At</th>
                            <th class="w-[20%] px-3 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($posts as $post)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-3 py-4 text-sm font-medium text-gray-900">{{ $post->id }}</td>
                                <td class="px-3 py-4">
                                    @if($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" 
                                             alt="Post thumbnail" 
                                             class="h-12 w-16 object-cover rounded-md"
                                             loading="lazy">
                                    @else
                                        <div class="h-12 w-16 bg-gray-100 rounded-md flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-700">
                                    <div class="truncate">{{$post['title']}}</div>
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-700">
                                    <div class="truncate">{{$post->slug}}</div>
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-700">
                                    <div class="truncate">{{ $post->user->name}}</div>
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-700">{{ $post->created_at->format("Y-m-d") }}</td>
                                <td class="px-3 py-4">
                                    <div class="flex items-center gap-2">
                                        <view-ajax :id="{{$post->id}}"></view-ajax>

                                        @if(auth()->id() == $post->user->id)
                                            <a href="{{ route("posts.edit", $post) }}"
                                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-md hover:bg-indigo-200 transition-colors duration-150">
                                                Edit
                                            </a>

                                            @if($post->deleted_at)
                                                <form action="{{  route("posts.restore", $post)  }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method("PATCH")
                                                    <button type="submit"
                                                            onclick="return confirm('Are you sure to restore post {{$post->name}}?')"
                                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-emerald-700 bg-emerald-100 rounded-md hover:bg-emerald-200 transition-colors duration-150">
                                                        Restore
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button type="submit"
                                                            onclick="return confirm('Are you sure to delete post {{$post->name}}?')"
                                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-rose-700 bg-rose-100 rounded-md hover:bg-rose-200 transition-colors duration-150">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
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
