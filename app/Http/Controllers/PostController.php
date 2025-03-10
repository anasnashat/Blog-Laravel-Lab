<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::withTrashed()->with('user')->paginate(5);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
//        dd($request);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public'); // Store in storage/app/public/posts
        }

        $post = $request->all();
        $post['user_id'] = auth()->id();
        $post['image'] = $imagePath ?? null;

//        var_dump($post);
        Post::create($post);
        return to_route('posts.index')->with('success','Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {

//        dd($post->comments[0]->user);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {

        return view('posts.create', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
//        dd($request);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $imagePath = $request->file('image')->store('posts', 'public');
        } else {
            $imagePath = $post->image;
        }
        $post_data = $request->all();
        $post_data['image'] = $imagePath;
        $post->update($post_data);
        return to_route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return to_route('posts.index');
    }
    public function restore($post)
    {
        $post = Post::withTrashed()->findOrFail($post);

        $post->restore();
        return to_route('posts.index');
    }

    public function myPosts(): string
    {
        $posts = Post::where('user_id', auth()->id())->paginate(5);
        return view('posts.index', compact('posts'));
    }

    public function showApi($id)
    {
        $post = Post::with('user')->findOrFail($id);
        return response()->json($post);
    }
}
