@props([
    'variant' => 'default',
    'size' => 'md',
])

@php
$classes = 'inline-block cursor-pointer focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 rounded-md';
@endphp

<div
    x-popover-trigger="$id('dropdown')"
    @keydown="handleKeydown"
    x-ref="trigger"
    :style="`anchor-name: --dropdown-${$id('dropdown')};`"
    aria-haspopup="true"
    :aria-expanded="open"
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</div>
