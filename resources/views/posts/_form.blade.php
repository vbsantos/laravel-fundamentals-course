@component('components.errors') @endcomponent

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

    <label>Thumbnail</label>

    <input
        type="file"
        name="thumbnail"
        class="form-control-file"
    />

</div>

<div class="form-group">

    <label>Content</label>

    <textarea
        style="height:400px"
        class="form-control"
        type="text"
        name="content"
    >{{ old('content', $post->content ?? null) }}</textarea>

</div>
