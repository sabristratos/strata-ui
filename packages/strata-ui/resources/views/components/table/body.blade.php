@props([])

<tbody
    data-strata-table-body
    :class="{
        '[&>tr:nth-child(even)]:bg-muted/50': striped
    }"
    {{ $attributes->merge(['class' => '']) }}
>
    {{ $slot }}
</tbody>
