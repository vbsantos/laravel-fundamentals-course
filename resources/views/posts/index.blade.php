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


                    @component('components.badge',['type' => 'secondary'])
                    {{-- <small class="text-muted"> --}}
                        @component('components.updated', ['date' => $post->created_at->diffForHumans(), 'name' => $post->user->name])
                            Added
                        @endComponent
                    {{-- </small> --}}
                    @endComponent

                    <br/>

                    @component('components.tags', ['tags' => $post->tags] ) @endComponent

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

                    @auth
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
                    @endauth
                </p>

            @empty

                <p>
                    <small>No blog posts yet... :(</small>
                </p>

            @endforelse

        </div>

        <div class="col-4">
            @include('posts._activity')
        </div>

    </div>

@endsection
