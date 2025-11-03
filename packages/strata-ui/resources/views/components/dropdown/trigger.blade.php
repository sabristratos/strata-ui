@props([
    'variant' => 'default',
    'size' => 'md',
])

@php
$dropdownId = $attributes->get('data-dropdown-trigger');

if (!$dropdownId) {
    throw new \InvalidArgumentException('Dropdown trigger requires a data-dropdown-trigger attribute with matching dropdown id');
}

$classes = 'inline-block cursor-pointer';
@endphp

<div
    @click="toggle()"
    data-dropdown-trigger="{{ $dropdownId }}"
    aria-haspopup="true"
    :aria-expanded="open"
    :aria-controls="'{{ $dropdownId }}'"
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</div>
