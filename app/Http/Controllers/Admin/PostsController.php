<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allposts = Post::paginate(10);

        return Inertia::render("Admin/Post/index", compact('allposts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $status = [
            'yes' => __('Yes'),
            'no' => __('No')
        ];

        return Inertia::render("Admin/Post/create", compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:250|string',
            'content' => 'required|string|max:100000',
            'is_post' => 'required|in:yes,no'
        ]);

        Post::create([
            'title' => $request->title,
            'slug' => str()->slug($request->title),
            'content' => $request->content,
            'is_post' => $request->is_post,
        ]);

        return to_route('admin.posts.index')->with('message', __('Post has been created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::where('id', $id)->firstOrFail();

        return Inertia::render("Admin/Post/show", compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::where('id', $id)->firstOrFail();
        $status = [
            'yes' => __('Yes'),
            'no' => __('No')
        ];

        return Inertia::render("Admin/Post/edit", compact('post', 'status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::where('id', $id)->firstOrFail();

        $request->validate([
            'title' => 'required|max:250|string',
            'content' => 'required|string|max:100000',
            'is_post' => 'required|in:yes,no'
        ]);

        $post->update([
            'title' => $request->title,
            'slug' => str()->slug($request->title),
            'content' => $request->content,
            'is_post' => $request->is_post,
        ]);

        return to_route('admin.posts.index')->with('message', __('Post has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::where('id', $id)->firstOrFail();
        $post->delete();
        return to_route('admin.posts.index')->with('message', __('Post has been deleted'));
    }
}
