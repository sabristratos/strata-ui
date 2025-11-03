@props([
    'align' => 'left',
])

@php
$alignments = [
    'left' => 'text-left',
    'center' => 'text-center',
    'right' => 'text-right',
];

$alignClass = $alignments[$align] ?? $alignments['left'];

$paddingSizes = [
    'sm' => 'px-3 py-2 @max-sm:py-3',
    'md' => 'px-4 py-3 @max-sm:py-4',
    'lg' => 'px-6 py-4 @max-sm:py-5',
];

$borderClasses = 'border-b border-table-border';
@endphp

<td
    data-strata-table-cell
    :class="{
        '{{ $alignClass }}': true,
        '{{ $paddingSizes['sm'] }}': size === 'sm',
        '{{ $paddingSizes['md'] }}': size === 'md',
        '{{ $paddingSizes['lg'] }}': size === 'lg',
        '{{ $borderClasses }}': variant === 'bordered'
    }"
    {{ $attributes->merge(['class' => '']) }}
>
    {{ $slot }}
</td>
