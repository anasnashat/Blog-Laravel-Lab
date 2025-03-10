<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'ITI Blog Post' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a class="text-2xl font-bold text-blue-600 hover:text-blue-700 transition" href="{{ route('posts.index') }}">
                            ITI Blog Post
                        </a>
                    </div>
                    <div class="hidden md:flex items-center space-x-8 ml-10">
                        <a class="px-3 py-2 text-sm font-medium rounded-md transition {{ request()->routeIs('posts.index') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50' }}"
                           href="{{ route('posts.index') }}">All Posts</a>
                        <a class="px-3 py-2 text-sm font-medium rounded-md transition {{ request()->routeIs('posts.myPosts') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50' }}"
                           href="{{ route('posts.myPosts') }}">My Posts</a>
                        <a class="px-3 py-2 text-sm font-medium rounded-md transition {{ request()->routeIs('posts.dashboard') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50' }}"
                           href="{{ route('dashboard') }}">Dashboard</a>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div id="app" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div id="alert-container" class="fixed top-6 right-6 z-50 flex flex-col gap-3">
            @if (session()->has('success'))
                <x-alert 
                    type="success" 
                    :message="session('success')" 
                    :desc="session('success_description')" 
                />
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <x-alert 
                        type="error" 
                        message="Error" 
                        :desc="$error" 
                    />
                @endforeach
            @endif
        </div>

        {{ $slot }}
    </div>

    @vite(['resources/js/app.js'])
</body>
</html>
