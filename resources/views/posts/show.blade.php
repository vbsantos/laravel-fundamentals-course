@extends('layout')

@section('content')

    @if((new Carbon\Carbon())->diffInMinutes($post->created_at) < 240)

        <p>
            <small>
                <strong>New Post!</strong>
            </small>
        </p>

    @else

        <p>
            <small class="text-muted">Added {{ $post->created_at->diffForHumans() }}</small>
        </p>

    @endif

    <article>
        <h1>{{ $post->title }}</h1>
        <p><pre style="white-space: pre-wrap;">{{ $post->content }}</pre></p>
    </article>

    <h2>Comments</h2>

    @forelse ($post->comments as $comment)

        <p>
            {{ $comment->content }}
            <br />
            <small class="text-muted">
                ({{ $comment->created_at->diffForHumans() }})
            </small>
        </p>

    @empty

        <p>
            <small class="text-muted">No comments for this posts yet! :(</small>
        </p>

    @endforelse

@endsection
