<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {

        $post = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        $post['user_id'] = auth()->id();
        $post['slug'] = Str::slug($post['title']);
//        var_dump($post);
        Post::create($post);
        return to_route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $post_data = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $post_data['user_id'] = auth()->id();
        $post_data['slug'] = Str::slug($post_data['title']);
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
}
