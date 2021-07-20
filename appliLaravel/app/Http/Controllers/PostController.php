<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @return View
     */
    public function index()
    {
            $posts = Post::with('user')->latest('updated_at')->paginate(10);
            return view('pages.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @return View
     */
    public function create()
    {
        return view('pages.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:20',
            'content' => 'required|string',
            'comment' => 'string',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->route('posts.create')
                ->withErrors($validator)
                ->withInput();
        }

        $post = Post::create([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
            'content' => $request->input('content'),
            'user_id' => auth()->user()->id,
            'comment' => $request->input('comment')
        ]);
        return redirect()->route('posts.show', $post->slug)
            ->with('success', 'Post created successfully');
        }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     * @return View
     */
    public function show(Post $post)
    {
        $post->load('user');
        return view('pages.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     * @return View
     */
    public function edit(Post $post)
    {
        return view('pages.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     * @return RedirectResponse
     */
    public function update(Request $request, Post $post)
{
    if ($post->user_id !== auth()->id()) {
        return redirect()->route('posts.index')
            ->with('error', 'You cannot edit this post');
    }
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:20',
        'content' => 'required|string',
        'comment' => 'string'
    ]);
    if ($validator->fails()) {
        return redirect()
            ->route('posts.create')
            ->withErrors($validator)
            ->withInput();
    }
    $post->update([
        'title' => $request->input('title'),
        'slug' => Str::slug($request->input('title')),
        'content' => $request->input('content'),
        'user_id' => auth()->user()->id,
        'comment' => $request->input('comment')
    ]);
    return redirect()->route('posts.show', $post->slug)
        ->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     * @return RedirectResponse
     */
    public function destroy(Post $post)
{
    if ($post->user_id !== auth()->id()) {
        return redirect()->route('posts.index')
            ->with('error', 'You cannot delete this post');
    }
    $post->delete();
        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully');
}



}
