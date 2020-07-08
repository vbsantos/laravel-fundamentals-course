@extends('layout')

@section('content')

    @forelse ($posts as $post)

        <p>
            <h3>
                <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
            </h3>

            @if ($post->comments_count)

                <p>
                    <small class="text-muted">{{ $post->comments_count }} comments!</small>
                </p>

            @else

                <p>
                    <small class="text-muted">No comments yet :(</small>
                </p>

            @endif

            <a class="btn btn-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>

            <form class="fm-inline" method="POST" action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                @csrf
                @method('DELETE')
                <input
                    class="btn btn-primary"
                    type="submit"
                    value="Delete"
                />
            </form>
        </p>

    @empty

        <p>
            <small>No blog posts yet! :(</small>
        </p>

    @endforelse

@endsection
