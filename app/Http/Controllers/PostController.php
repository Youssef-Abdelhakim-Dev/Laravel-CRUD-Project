<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
public function index()
{
    $posts = Post::latest()->paginate(6);
    $randomPosts = Post::inRandomOrder()->limit(3)->get();

    // Add this line
    $randomPostsTitles = $randomPosts->pluck('title')->toArray();

    return view('posts.index', compact('posts', 'randomPosts', 'randomPostsTitles'));
}



  public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'content' => 'required',
        'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'videos.*' => 'mimetypes:video/mp4,video/avi|max:102400',
        'audios.*' => 'mimetypes:audio/mpeg,audio/wav|max:10240',
    ]);

    $post = Post::create([
        'title' => $request->title,
        'content' => $request->content,
    ]);

    $media = [];

    if($request->hasFile('photos')) {
        foreach($request->file('photos') as $file) {
            $path = $file->store('uploads/photos', 'public');
            $media[] = $path;
        }
    }

    if($request->hasFile('videos')) {
        foreach($request->file('videos') as $file) {
            $path = $file->store('uploads/videos', 'public');
            $media[] = $path;
        }
    }

    if($request->hasFile('audios')) {
        foreach($request->file('audios') as $file) {
            $path = $file->store('uploads/audios', 'public');
            $media[] = $path;
        }
    }

    $post->media = json_encode($media);
    $post->save();

    return redirect()->route('posts.index')->with('success', 'Post created!');
}



    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'   => 'required|min:3',
            'content' => 'required|min:5',
        ]);

        $post->update($request->all());

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully.');
    }
}
