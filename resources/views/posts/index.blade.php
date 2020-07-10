@extends('layout')

@section('content')

    <div class="row">

        <div class="col-8">

            @forelse ($posts as $post)

                <p>
                    <h3>
                        @if ($post->trashed())
                            <small class="text-muted">
                                [deleted]
                            </small>
                            <del>
                                <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
                            </del>
                        @else
                                <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
                        @endif
                    </h3>
                    <p>
                        <small class="text-muted">Added {{ $post->created_at->diffForHumans() }} by {{ $post->user->name }}</small>

                        <br/>

                        @if ($post->comments_count)
                            <small class="text-muted">{{ $post->comments_count }} comments</small>
                        @else
                            <small class="text-muted">No comments yet :(</small>
                        @endif
                    </p>

                    @can('update', $post)
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
                    @endcan

                    @if (!$post->trashed())
                        @can('delete', $post)
                            <form class="fm-inline" method="POST" action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                                @csrf
                                @method('DELETE')
                                <input
                                    class="btn btn-sm btn-outline-danger"
                                    type="submit"
                                    value="Delete"
                                />
                            </form>
                        @endcan
                    @endif
                </p>

            @empty

                <p>
                    <small>No blog posts yet... :(</small>
                </p>

            @endforelse

        </div>

        <div class="col-4">
            <div class="container">

                <div class="row">
                    <div class="card" style="min-width: 270px; width: 270px;">
                        <div class="card-body">
                            <h5 class="card-title">Most Commented Posts</h5>
                            <small class="text-muted">
                                What users are currenty talking about
                            </small>
                        </div>
                        <ul class="list-group list-group-flush">
                            @forelse ($mostCommented as $post)
                                <li class="list-group-item">
                                    <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                                        {{ $post->title }}
                                    </a>
                                    <br/>
                                    <small class="text-muted">{{ $post->user->name }} ({{ $post->created_at->diffForHumans() }})</small>
                                    <br />
                                    <small class="text-muted">{{ $post->comments_count }} {{ $post->comments_count == 1 ? "comment" : "comments" }}</small>
                                </li>
                            @empty
                                <li class="list-group-item">
                                    <small>No blog posts yet... :(</small>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="card mt-4" style="min-width: 270px; width: 270px;">
                        <div class="card-body">
                            <h5 class="card-title">Most Active Users</h5>
                            <small class="text-muted">
                                Users with most posts written
                            </small>
                        </div>
                        <ul class="list-group list-group-flush">
                            @forelse ($mostActive as $user)
                                <li class="list-group-item">
                                    {{ $user->name }}
                                    <small class="text-muted">
                                        {{ $user->blog_posts_count }} {{ $user->blog_posts_count == 1 ? "post" : "posts" }} created
                                    </small>
                                </li>
                            @empty
                                <li class="list-group-item">
                                    <small>No users yet... :(</small>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="card mt-4" style="min-width: 270px; width: 270px;">
                        <div class="card-body">
                            <h5 class="card-title">Most Active Users Last Month</h5>
                            <small class="text-muted">
                                Users with most posts written in the last month
                            </small>
                        </div>
                        <ul class="list-group list-group-flush">
                            @forelse ($mostActiveLastMonth as $user)
                                <li class="list-group-item">
                                    {{ $user->name }}
                                    <small class="text-muted">
                                        {{ $user->blog_posts_count }} {{ $user->blog_posts_count == 1 ? "post" : "posts" }} created
                                    </small>
                                </li>
                            @empty
                                <li class="list-group-item">
                                    <small>No users yet... :(</small>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection
