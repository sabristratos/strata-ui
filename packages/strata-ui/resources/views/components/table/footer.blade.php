@props([])

@php
$classes = 'bg-table-footer text-table-footer-foreground border-t border-table-border';
@endphp

<tfoot
    data-strata-table-footer
    class="{{ $classes }}"
    {{ $attributes }}
>
    {{ $slot }}
</tfoot>
