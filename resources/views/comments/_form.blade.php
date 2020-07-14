<div class="mb-2 mb-1">

    @auth

        <form method="POST" action="{{ route('posts.comments.store', ['post' => $post->id]) }}">

            @component('components.errors') @endcomponent

            @csrf

            <div class="form-group">

                <textarea
                    style="height:80px"
                    class="form-control"
                    type="text"
                    name="content"
                >{{ old('content') }}</textarea>

            </div>

            <button
                class="btn btn-primary btn-block"
                type="submit"
            >
                Add Comment!
            </button>

        </form>


    @else

        <a href="{{ route('login') }}">Log in to comment on this post!</a>

    @endauth


</div>
