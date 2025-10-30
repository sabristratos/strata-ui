@props([
    'selected' => false,
])

<tr
    data-strata-table-row
    :class="{
        'hover:bg-table-row-hover transition-colors': hoverable,
        'bg-primary/10': @js($selected)
    }"
    {{ $attributes }}
>
    {{ $slot }}
</tr>
