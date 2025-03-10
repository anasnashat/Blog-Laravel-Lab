@auth
<x-layout>
    <div class="max-w-2xl mx-auto">

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">
                {{ isset($post) ? 'Edit Post' : 'Create New Post' }}
            </h1>
            <p class="mt-1 text-sm text-gray-600">
                {{ isset($post) ? 'Update your post information below.' : 'Fill in the information below to create your post.' }}
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}"
                  method="POST"
                  class="space-y-6 p-6"
                  enctype="multipart/form-data" 

            >
                @csrf
                @if(isset($post))
                    @method('PUT')
                @endif

                <!-- Title Input -->

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text"
                           name="title"
                           id="title"
                           value="{{ old('title', isset($post) ? $post->title : '') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                  @error('title') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                           placeholder="Enter post title">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description Input -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description"
                              id="description"
                              rows="4"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                     @error('description') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                              placeholder="Enter post description">{{ old('description', isset($post) ? $post->description : '') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Post Image</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="h-32 w-32 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                                <img id="preview" 
                                     src="{{ isset($post) && $post->image ? asset('storage/' . $post->image) : '#' }}"
                                     alt="Preview" 
                                     class="h-full w-full object-cover rounded-lg {{ isset($post) && $post->image ? '' : 'hidden' }}">
                                <div id="placeholder" class="text-center p-4 {{ isset($post) && $post->image ? 'hidden' : '' }}">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="mt-1 text-xs text-gray-500">Upload Image</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow">
                            <input type="file"
                                   name="image"
                                   id="image"
                                   onchange="previewImage(this)"
                                   class="hidden"
                                   accept="image/*">
                            <label for="image" 
                                   class="cursor-pointer inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 hover:border-gray-400 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition">
                                Choose Image
                            </label>
                            @if(isset($post) && $post->image)
                                <button type="button" 
                                        onclick="removeImage()"
                                        class="ml-2 inline-flex items-center px-4 py-2 bg-red-100 border border-transparent rounded-md font-semibold text-xs text-red-700 uppercase tracking-widest hover:bg-red-200 focus:outline-none focus:border-red-500 focus:ring focus:ring-red-200 active:bg-red-300 disabled:opacity-25 transition">
                                    Remove
                                </button>
                            @endif
                            @error('image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('posts.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ isset($post) ? 'Update Post' : 'Create Post' }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Additional Info Card (if needed) -->
        <div class="mt-6 bg-yellow-50 rounded-lg p-4 border border-yellow-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Attention</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>All fields are required. Make sure to provide clear and accurate information.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
@endauth
@guest
    <x-layout>
    <div class="text-center mt-8">
        <h1 class=" w-100  text-center text-2xl font-semibold text-gray-800 mt-8">Please login to create a post</h1>
    </div>
    </x-layout>
@endguest
