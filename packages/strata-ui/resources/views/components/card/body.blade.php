@props([
    'padding' => 'normal',
])

@php
$paddings = [
    'none' => '',
    'sm' => 'p-4',
    'normal' => 'px-6 py-4',
    'lg' => 'p-8',
];

$classes = $paddings[$padding] ?? $paddings['normal'];
@endphp

<div data-strata-card-body {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
