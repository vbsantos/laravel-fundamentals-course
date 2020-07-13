<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class PostTagController extends Controller
{
    public function index($tag)
    {
        $tag = Tag::findOrFail($tag);
        $posts = $tag->blogPosts()->withCount('comments')->get();
        return view('posts.index', [
            'posts' => $posts
        ]);
    }
}
