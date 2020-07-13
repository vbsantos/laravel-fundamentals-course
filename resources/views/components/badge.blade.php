@if (!isset($show) || $show)

    <span style="font-size:0.8rem;" class="mt-1 badge badge-{{ $type ?? 'success' }}">

        {{ $slot }}

    </span>

@endif
