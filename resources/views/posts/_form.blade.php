<div class="form-group">
    <label>Title</label>
    <input
        class="form-control"
        type="text"
        name="title"
        value="{{ old('title', $post->title ?? null) }}"
    />
</div>

<div class="form-group">
    <label>Content</label>
    <textarea
        style="height:300px"
        class="form-control"
        type="text"
        name="content"
    >{{ old('content', $post->content ?? null) }}</textarea>
</div>

@if ($errors->any())
    <div style="color: red">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
