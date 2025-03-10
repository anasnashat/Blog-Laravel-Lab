@props(['post' => null, 'action', 'method' => 'POST'])

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
        <h1 class="text-2xl font-semibold text-gray-900 mb-6">
            {{ $post ? 'Edit Post' : 'Create New Post' }}
        </h1>

        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($method === 'PUT')
                @method('PUT')
            @endif

            <!-- Image Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Post Image
                </label>
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="h-32 w-32 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                            <img id="preview" 
                                 src="{{ $post && $post->image ? asset('storage/' . $post->image) : '#' }}" 
                                 alt="Preview" 
                                 class="h-full w-full object-cover rounded-lg {{ $post && $post->image ? '' : 'hidden' }}">
                            <div id="placeholder" class="text-center p-4 {{ $post && $post->image ? 'hidden' : '' }}">
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
                               accept="image/*"
                               class="hidden"
                               onchange="previewImage(this)">
                        <label for="image" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">
                            {{ $post && $post->image ? 'Change Image' : 'Choose Image' }}
                        </label>
                        @if($post && $post->image)
                            <button type="button" 
                                    onclick="removeImage()"
                                    class="ml-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Remove
                            </button>
                        @endif
                        <p class="mt-2 text-xs text-gray-500">
                            PNG, JPG, GIF up to 2MB
                        </p>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       value="{{ old('title', $post?->title) }}"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Add other fields here -->

            <div class="flex justify-end space-x-3">
                <a href="{{ route('posts.index') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    {{ $post ? 'Update Post' : 'Create Post' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const placeholder = document.getElementById('placeholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    }

    function removeImage() {
        const preview = document.getElementById('preview');
        const placeholder = document.getElementById('placeholder');
        const input = document.getElementById('image');
        
        // Add a hidden input to signal image removal
        const removeInput = document.createElement('input');
        removeInput.type = 'hidden';
        removeInput.name = 'remove_image';
        removeInput.value = '1';
        input.parentNode.appendChild(removeInput);
        
        // Reset the file input
        input.value = '';
        
        // Update the preview
        preview.src = '#';
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
    }
</script> 