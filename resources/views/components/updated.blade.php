<span>

    {{ $slot }} {{ $date ?? "" }}

    @if (isset($name))

        by {{ $name }}

    @endif

</span>
