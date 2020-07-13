<span>

    @foreach ($tags as $tag)

        <a style="font-size: 0.8rem;" class="mt-1 badge badge-dark" href="{{ route('posts.tags.index', ['tag' => $tag->id]) }}">

            {{ $tag->name }}

        </a>

    @endforeach

</span>
