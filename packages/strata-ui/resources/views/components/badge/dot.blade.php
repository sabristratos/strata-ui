@props([
    'variant' => 'secondary',
    'size' => 'md',
])

@php
$dotColors = [
    'primary' => 'bg-primary',
    'secondary' => 'bg-secondary',
    'success' => 'bg-success',
    'warning' => 'bg-warning',
    'destructive' => 'bg-destructive',
    'info' => 'bg-info',
];

$sizes = [
    'sm' => 'text-xs gap-1.5',
    'md' => 'text-sm gap-2',
    'lg' => 'text-base gap-2.5',
];

$dotSizes = [
    'sm' => 'w-1.5 h-1.5',
    'md' => 'w-2 h-2',
    'lg' => 'w-2.5 h-2.5',
];

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$dotSize = $dotSizes[$size] ?? $dotSizes['md'];
$dotColor = $dotColors[$variant] ?? $dotColors['secondary'];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center font-medium text-gray-700 dark:text-gray-300 ' . $sizeClasses]) }}>
    <span class="{{ $dotColor }} {{ $dotSize }} rounded-full"></span>
    {{ $slot }}
</span>
