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
                        {{-- <br/>
                        <small class="text-muted">{{ $post->user->name }} ({{ $post->created_at->diffForHumans() }})</small> --}}
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
