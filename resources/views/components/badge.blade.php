@if (!isset($show) || $show)
    <span class="badge badge-pill badge-{{ $type ?? 'success' }}">
        {{ $slot }}
    </span>
@endif
