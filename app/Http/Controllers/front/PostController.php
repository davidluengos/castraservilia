<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::published()->paginate(12);

        return view('front.posts.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = Post::findBySlug($slug);
        if (! $post) {
            abort(404);
        }
        $post->load('images');

        return view('front.posts.show', compact('post'));
    }
}
