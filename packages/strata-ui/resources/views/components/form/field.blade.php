@props([
    'spacing' => 'default',
])

@php
$spacingClasses = [
    'tight' => 'space-y-1',
    'default' => 'space-y-1.5',
    'loose' => 'space-y-2',
];

$classes = $spacingClasses[$spacing] ?? $spacingClasses['default'];
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
