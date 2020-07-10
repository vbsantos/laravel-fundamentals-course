@extends('layout')

@section('content')

    <div class="row">

        <div class="col-8">

            @forelse ($posts as $post)

                <p class="mt-4 mb-4">
                    <h3>
                        <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
                    </h3>

                    @component('components.badge',['type' => 'danger', 'show' => $post->trashed()])
                        REMOVED
                    @endComponent

                    {{-- @component('components.badge',['type' => 'secondary']) --}}
                    <small class="text-muted">
                        @component('components.updated', ['date' => $post->created_at->diffForHumans(), 'name' => $post->user->name])
                            Added
                        @endComponent
                    </small>
                    {{-- @endComponent --}}

                    <p>
                        {{-- <small class="text-muted">Added {{ $post->created_at->diffForHumans() }} by {{ $post->user->name }}</small> --}}
                        {{-- <small class="text-muted">
                            @component('components.updated', ['date' => $post->created_at->diffForHumans(), 'name' => $post->user->name])
                                Added
                            @endComponent
                        </small> --}}
                        {{-- <br /> --}}
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
                    @component('components.card')
                        @slot('title', 'Most Commented Posts')
                        @slot('subtitle', 'What users are currenty talking about')
                        @slot('items')
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
                        @endslot
                    @endcomponent
                </div>

                <div class="row">
                    @component('components.card')
                        @slot('title', 'Most Active Users')
                        @slot('subtitle', 'Users with most posts written')
                        @slot('items')
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
                        @endslot
                    @endcomponent
                </div>

                <div class="row">
                    @component('components.card')
                        @slot('title', 'Most Active Users Last Month')
                        @slot('subtitle', 'Users with most posts written in the last month')
                        @slot('items')
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
                        @endslot
                    @endcomponent
                </div>

            </div>
        </div>

    </div>

@endsection
