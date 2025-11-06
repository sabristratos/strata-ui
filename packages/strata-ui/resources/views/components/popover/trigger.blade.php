@props([
    'target' => null,
])

@php
if (!$target) {
    throw new \InvalidArgumentException('Popover trigger requires a "target" prop');
}

$classes = 'inline-block cursor-pointer focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 rounded-md';
@endphp

<div
    @click.stop="toggle()"
    tabindex="0"
    data-popover-trigger="{{ $target }}"
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</div>
