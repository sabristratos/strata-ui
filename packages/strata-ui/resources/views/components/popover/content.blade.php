@props([
    'padding' => 'normal',
])

@php
$paddings = [
    'none' => '',
    'sm' => 'p-3',
    'normal' => 'p-4',
    'lg' => 'p-6',
];

$classes = $paddings[$padding] ?? $paddings['normal'];
@endphp

<div data-strata-popover-content {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
