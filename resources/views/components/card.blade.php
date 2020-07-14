<div class="card mb-4" style="min-width: 270px; width: 100%;">
    <div class="card-body">
        <h5 class="card-title">{{ $title }}</h5>
        <small class="text-muted">
            {{ $subtitle }}
        </small>
    </div>
    <ul class="list-group list-group-flush">
        @if(is_a($items, 'Illuminate\Support\Collection'))
            @foreach ($items as $item)
                <li class="list-group-item">
                    {{ $item }}
                </li>
            @endforeach
        @else
            {{ $items }}
        @endif
    </ul>
</div>
