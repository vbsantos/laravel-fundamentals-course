@if ($errors->any())
    <div style="mt-2 mb-2">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    </div>
@endif
