@props([
    'variant' => 'default',
    'size' => 'md',
])

@php
$classes = 'inline-block cursor-pointer focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 rounded-md';
@endphp

<div
    :popovertarget="$id('dropdown')"
    @keydown="handleKeydown"
    tabindex="0"
    x-ref="trigger"
    aria-haspopup="true"
    :aria-expanded="open"
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</div>
