<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Http\Requests\StorePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
// use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(BlogPost::all());
        // DB::connection()->enableQueryLog();

        // $posts = BlogPost::all();
        // $posts = BlogPost::with('comments')->get();

        // foreach ($posts as $post) {
        //     foreach ($post->comments as $comment) {
        //         echo $comment->content;
        //     }
        // }

        // dd(DB::getQueryLog());

        return view(
            'posts.index',
            ['posts' => BlogPost::withCount('comments')->get()]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('post.create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        // dd($request->all());

        $validatedInputs = $request->validated();

        $post = BlogPost::create($validatedInputs);

        $request->session()->flash('status', 'Blog post was created!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // dd(BlogPost::find($id));
        // $request->session()->reflash();

        return view('posts.show', [
            'post' => BlogPost::with('comments')->findOrfail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You are not authorized to edit this blog post!");
        // }
        $this->authorize($post);

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize($post);

        $validatedInputs = $request->validated();

        $post->fill($validatedInputs);
        $post->save();

        $request->session()->flash('status', 'Blog post was updated!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // BlogPost::destroy($id);
        $post = BlogPost::findOrFail($id);

        $this->authorize($post);

        $post->delete();

        $request->session()->flash('status', 'Blog post was deleted!');

        return redirect()->route('posts.index');
    }
}
