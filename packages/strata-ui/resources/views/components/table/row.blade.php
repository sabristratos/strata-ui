@props([
    'selected' => false,
])

<tr
    data-strata-table-row
    :class="{
        'hover:bg-table-row-hover transition-colors duration-150': hoverable,
        'bg-table-row-selected': @js($selected)
    }"
    aria-selected="{{ $selected ? 'true' : 'false' }}"
    {{ $attributes->merge(['class' => '']) }}
>
    {{ $slot }}
</tr>
