@props([])

@php
$classes = trim(implode(' ', array_filter([
    'bg-table-header',
    'text-table-header-foreground',
    'border-t',
    'border-table-border',
])));
@endphp

<tfoot
    data-strata-table-footer
    class="{{ $classes }}"
    {{ $attributes }}
>
    {{ $slot }}
</tfoot>
