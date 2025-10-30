@props([
    'padding' => 'default',
])

@php
$paddings = [
    'none' => '',
    'sm' => 'p-4',
    'default' => 'p-6',
    'lg' => 'p-8',
];

$paddingClasses = $paddings[$padding] ?? $paddings['default'];
$classes = "flex-1 overflow-y-auto $paddingClasses";
@endphp

<div data-strata-modal-body {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
