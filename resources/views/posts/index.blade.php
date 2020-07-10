@extends('layout')

@section('content')

    @forelse ($posts as $post)

        <p>
            <h3>
                <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
            </h3>

            <p>
                <small class="text-muted">Added {{ $post->created_at->diffForHumans() }} by {{ $post->user->name }}</small>

                <br/>

                @if ($post->comments_count)
                    <small class="text-muted">{{ $post->comments_count }} comments!</small>
                @else
                    <small class="text-muted">No comments yet :(</small>
                @endif
            </p>

            @can('update', $post)
                <a class="btn btn-sm btn-outline-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
            @endcan

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
        </p>

    @empty

        <p>
            <small>No blog posts yet! :(</small>
        </p>

    @endforelse

@endsection
