<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all()->sortByDesc('created_at');
        $categories = Category::all()->keyBy('id');
        // $categories = Category::all()->keyBy('id');
        return view('posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::check()) {
            abort(403);
        }

        $categories = Category::all();
        $authors = User::all();

        return view('posts.create', compact('categories', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $categories = Category::all();
        $authors = User::all();

        if ($request->title == null || $request->author_id == null || $request->body == null) {
            //if you deleted everyting - go back and fill it!

            return redirect()->route('posts.create', compact('categories', 'authors'))->with('error', 'Failed to create post. Please try again.');
        }

        $post = Post::create([
            'title' => $request->title,
            'author_id' => $request->author_id,
            'body' => $request->body,
            'category_id' => $request->category_id
        ]);

        return redirect()->route('posts.show', $post->id)->with('success', 'Post has been created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id);
        $categories = Category::all();
        $authors = User::all();

        return view('posts.edit', compact('post', 'categories', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);

        if (! Gate::allows('update-post', $post)) {
            abort(403);
        }

        if ($request->title == null || $request->author_id == null || $request->body == null) {
            //if you deleted everyting - go back and fill it!
            return redirect()->route('posts.edit', $id);
        }
        //all clear - updating the post!
        $post->title = $request->title;
        $post->author_id = $request->author_id;
        $post->category_id = $request->category_id;
        $post->body = $request->body;
        $post->save();
        return redirect()->route('posts.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Post::findOrfail($id)->delete();
        return redirect()->route('posts.index');
    }
}
