@extends('layout')

@section('content')

<div class="row">

    <div class="col-8">

        @component('components.badge', ['type' => 'danger', 'show' => $post->trashed()])
            REMOVED
        @endcomponent

        @if((new Carbon\Carbon())->diffInMinutes($post->created_at) < 240)

            @component('components.badge', ['type' => 'success'])
                {{-- New Post by {{ $post->user->name }} --}}
                @component('components.updated', ['name' => $post->user->name])
                    Brand new Post
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

        <br/>

        @component('components.badge', ['type' => 'info'])
            Currently being read by {{ $counter }} {{ $counter == 1 ? 'person' : 'people' }}
        @endcomponent

        <br/>

        @component('components.tags', ['tags' => $post->tags] )

        @endComponent

        <article>
            @if($post->image)

                <div class="mt-4 mb-4" style="
                    background-image: url('{{ $post->image->url() }}');
                    background-repeat: no-repeat;
                    background-size: 100%;
                    min-height: 210px;
                    color: white;
                    text-align: center;
                    background-attachment: fixed;
                ">
                    <h1 style="
                        padding-top: 15%;
                        text-shadow: 1px 2px #000;
                    ">
                        {{ $post->title }}
                    </h1>
                </div>

            @else
                <h1>{{ $post->title }}</h1>
            @endif
            <pre style="font-family: sans-serif;white-space: pre-wrap;">{{ $post->content }}</pre>
        </article>

        <hr />

        <h2>Comments</h2>

        @include('comments._form')

        <hr />

        @forelse ($post->comments as $comment)

            <p>
                @component('components.badge', ['type' => 'danger', 'show' => $comment->trashed()])
                    REMOVED
                @endcomponent

                @component('components.badge', ['type' => 'secondary'])
                    @component('components.updated', ['date' => $comment->created_at->diffForHumans(), 'name' => $comment->user->name])
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

    </div>

    <div class="col-4">
        @include('posts._activity')
    </div>

</div>

@endsection
