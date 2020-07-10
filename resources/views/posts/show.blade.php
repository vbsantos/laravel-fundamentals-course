@extends('layout')

@section('content')

    @component('components.badge', ['type' => 'danger', 'show' => $post->trashed()])
        REMOVED
    @endcomponent

    @if((new Carbon\Carbon())->diffInMinutes($post->created_at) < 240)

        @component('components.badge', ['type' => 'success'])
            {{-- New Post by {{ $post->user->name }} --}}
            @component('components.updated', ['name' => $post->user->name])
                New Post
            @endComponent
        @endcomponent

    @else

        @component('components.badge', ['type' => 'secondary'])
            {{-- Added {{ $post->created_at->diffForHumans() }} by {{ $post->user->name }} --}}
            @component('components.updated', ['date' => $post->created_at->diffForHumans(), 'name' => $post->user->name])
                Added
            @endComponent
        @endcomponent

    @endif

    @component('components.badge', ['type' => 'warning', 'show' => $post->created_at != $post->updated_at])
        @component('components.updated', ['date' => $post->updated_at->diffForHumans()])
            Updated
        @endComponent
    @endcomponent

    <article>
        <h1>{{ $post->title }}</h1>
        <p><pre style="white-space: pre-wrap;">{{ $post->content }}</pre></p>
    </article>

    <h2>Comments</h2>

    @forelse ($post->comments as $comment)

        <p>
            @component('components.badge', ['type' => 'danger', 'show' => $comment->trashed()])
                REMOVED
            @endcomponent

            @component('components.badge', ['type' => 'secondary'])
                @component('components.updated', ['date' => $comment->created_at->diffForHumans()])
                    Added
                @endComponent
            @endcomponent

            @component('components.badge', ['type' => 'warning', 'show' => $comment->created_at != $comment->updated_at])
                @component('components.updated', ['date' => $comment->updated_at->diffForHumans()])
                    Updated
                @endComponent
            @endcomponent

            <br />

            {{ $comment->content }}
        </p>

    @empty

        <p>
            <small class="text-muted">No comments for this posts yet! :(</small>
        </p>

    @endforelse

@endsection
