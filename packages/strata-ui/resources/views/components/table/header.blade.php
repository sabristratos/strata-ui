@props([])

@php
$classes = trim(implode(' ', array_filter([
    'bg-table-header',
    'text-table-header-foreground',
])));
@endphp

<thead
    data-strata-table-header
    :class="{
        'sticky top-0 z-10': sticky,
        '{{ $classes }}': true
    }"
    {{ $attributes }}
>
    {{ $slot }}
</thead>
